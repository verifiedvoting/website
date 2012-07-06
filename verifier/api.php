<?php

include('connection.php');

if(! $mode = $_GET['mode']) {
  return_json(1,'no mode set, what do you want?');
} 

if($mode=='state'){
  $state = $_GET['state'];
  if(!$state){
    return_json(1,'please specify a state');
  }
  
  $query = mysql_escape_string("SELECT * FROM state WHERE st_fips LIKE $state");
  $resource = mysql_query($query);
  
  if(mysql_error()){
    return_json(1,mysql_error());
  } else if(mysql_num_rows($resource)>0) {
    $data =  mysql_fetch_assoc($resource);
    return_json(0,'', $data['json']);
  
  } else {
    return_json(1,'EMPTY SET - No rows in result');
  }
  
  return_json(0,'here yer state');

} else if ($mode=='machine'){
  if($_GET['county']){
    $state = $_GET['state'];
    $county = $_GET['county'];
    
    $query = mysql_escape_string("SELECT * FROM machine WHERE cty_fips LIKE $county");
    $resource = mysql_query($query);
    
  
    if(mysql_error()){
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
    
  }
}

//takes an error number (0 passes), a message and an optional array of data
function return_json($errorno,$message,$data=array()){
  echo json_encode(array('error'=>$errorno,'message'=>$message,'data'=>$data));
  die();

}


?>
