<?php

//GET arguments
// mode [usa | state | machine-summary | official] - same as the table name we want
// state [state fips]
// county [county fips]
// offset [num rows to offset]

//We respond with a json object containing three things
// error : an error int, 0 for no error
// message : human readable string for debugging
// data : the payload
//  [[NOTE: If data is GEOJSON, it will be a STRING in the object, not a subobject
//    It is necesarry to JSON.parse on the clientside]]
//



include('connection.php');

if($_GET['mode']=='help'){
  header(' ',true,501);
  return_json(1, 'modes are usa, state, machine, official');
}

if(! $mode = $_GET['mode']) {
  header(' ',true,501);
  return_json(1,'no mode set, what do you want?');
} 

if($mode=='state'){
  $state = $_GET['state'];
  if(!$state){
    header(' ',true,501);
    return_json(1,'please specify a state');
  }
  
  $query = mysql_escape_string("SELECT * FROM state WHERE state_fips LIKE $state");
  $resource = mysql_query($query);
  
  if(mysql_error()){
    header(' ',true,501);
    return_json(1,mysql_error());
  } else if(mysql_num_rows($resource)>0) {
    $data =  mysql_fetch_assoc($resource);
    return_json(0,'', $data['json']);
  } else {
    return_json(1,'EMPTY SET - No rows in result');
  }
  

} else if ($mode=='machine-summary'){
  if($_GET['state'] || $_GET['county']){
    $state = $_GET['state'];
    $county = $_GET['county'];
    
    $base_query = "SELECT * FROM machine WHERE";
    if($county){
      $base_query .= " county_fips LIKE $county";
      if($state){
        $base_query .= " AND";
      }
    }
    if($state){
      $base_query .= " state_fips LIKE $state";
    }
       
    $base_query = mysql_escape_string($base_query);
    $base_query .= " AND jurisdiction_type LIKE 'County'";
    
    $data = array();
    
    $resource = mysql_query($base_query.' AND (pp_std=1 OR pp_acc=1) LIMIT 4');
    while($get = mysql_fetch_assoc($resource)){
      $data[] = $get;
    }
    
    $resource = mysql_query($base_query.' AND (ev_std=1 OR ev_acc=1) LIMIT 4');
    while($get = mysql_fetch_assoc($resource)){
      $data[] = $get;
    }
    $resource = mysql_query($base_query.' AND (abs_ballots=1) LIMIT 4');
    while($get = mysql_fetch_assoc($resource)){
      $data[] = $get;
    }
    $resource = mysql_query($base_query.' AND (prov_ballots=1) LIMIT 4');
    while($get = mysql_fetch_assoc($resource)){
      $data[] = $get;
    }
    
    if(count($data)>0){
      return_json(0,'',$data);  
    }else {
      return_json(1,'EMPTY SET - No rows in result ');
    }

  } else {
      header(' ',true,501);
    return_json(0,'missing state and county for machine-summary search');
  }
} else if($mode=="country"){
  $country = file_get_contents('usa.json');
  return_json(0,'',$country);
} else if($mode=='official'){
  if($_GET['state']){
    $state = $_GET['state'];
    $county = $_GET['county'];
    
    $query = "SELECT * FROM official WHERE";
    if($state){
      $query .= " state_fips LIKE ". mysql_escape_string($state);
      if($county){
        $query .= " AND county_fips LIKE ".mysql_escape_string($county);
      } else {
        $query .= " AND jurisdiction_type LIKE 'State'";
      }
    }
    
    $resource = mysql_query($query);
  
    if(mysql_error()){
        header(' ',true,501);
      return_json(1,mysql_error());
    } else if(mysql_num_rows($resource)>0){
        $data = array();
      while($get = mysql_fetch_assoc($resource)){
      $data[] = $get;
      }
      return_json(0,'',$data);
    } else {
    return_json(1,'EMPTY SET - No rows in result');
    }
    
  } else {
      header(' ',true,501);
    return_json(0,'missing state or county for official search');
  }
  
}

//takes an error number (0 passes), a message and an optional array of data
function return_json($errorno,$message,$data=array()){
  echo json_encode(array('error'=>$errorno,'message'=>$message,'data'=>$data));
  die();
}


?>
