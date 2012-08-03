<?php

//GET arguments
// mode [usa | state | machine | official] - same as the table name we want
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
// x-current-page & x-total-results
//   we put meta information about result paging in the http response headers
// 200 / 501 status codes depending on resuts



include('connection.php');

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
  
  $query = mysql_escape_string("SELECT * FROM state WHERE st_fips LIKE $state");
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
  

} else if ($mode=='machine'){
  if($_GET['state'] || $_GET['county']){
    $state = $_GET['state'];
    $county = $_GET['county'];
    
    $query = "SELECT * FROM machine WHERE";
    if($county){
      $query .= " county_fips LIKE $county";
      if($state){
        $query .= " AND";
      }
    }
    if($state){
      $query .= " state_fips LIKE $state";
    }
 
       
    $query = mysql_escape_string($query);
       
    $query .= " AND jurisdiction_type LIKE 'County'";
    $resource = mysql_query($query);
  
    if(mysql_error()){
        header(' ',true,501);
      return_json(1,mysql_error());
    } else if(mysql_num_rows($resource)>0){
        $data = array();
      while($get = mysql_fetch_assoc($resource)){
      $data[] = $get;
      }
      if(count($data)>4) {
        Header('x-total-results: '.count($data));
        $offset = $_GET['offset'] ? $_GET['offset'] : 0;
        Header('x-current-offset: '.$offset);
        $data = array_slice($data,$offset,5);
      }
      return_json(0,'',$data);
    } else {
    return_json(1,'EMPTY SET - No rows in result');
    }
    
  } else {
      header(' ',true,501);
    return_json(0,'missing state and county for machine search');
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
      if(count($data)>4) {
        Header('x-total-results: '.count($data));
        $offset = $_GET['offset'] ? $_GET['offset'] : 0;
        Header('x-current-offset: '.$offset);
        $data = array_slice($data,$offset,5);
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
