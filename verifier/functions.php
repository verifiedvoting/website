<?php

/* ------- FUNCTIONS ------- */

//swap an array's key and value
function innie($arr){
  $i = 0;
  $out = array();
  foreach($arr as $key => $value){
    if(isset($out[$value])){
    $out[$value.'2'] = $key;
    } else {
    $out[$value] = $key;
    }
  }
  return($out);
}


//take keys of one array and content of another
function marry($key, $data){
  $out = array();
  foreach($key as $name => $val){
    $out[$name] = $data[$val];
  }   
  return $out;
}

//in array form of 
function scrub_names($in){
  $out = array();
  foreach($in as $key => $value){
    $value = strtolower($value);
    $value = str_replace(array(" ","-"), "_", $value);
    $out[$key] = $value;
  }
  return($out);
}

//takes in a row and processes all indexes listed in names
function scrub_booleans($in, $names){
  foreach($names as $name){
    if(isset($in[$name])){
      $scrubme = $in[$name];
      $scrubme = trim($scrubme);
      if(strlen($scrubme) > 0) {
        $in[$name] = true;
      } else {
        $in[$name] = false;
      } 
    }
  }
  return $in;
}

function filter_columns($in, $names){
  $out = array();
  foreach($names as $name){
    if(isset($in[$name])){
    $out[$name] = $in[$name];
    }
  }  
  return $out;
}

function backup_and_drop($table){
  $dumpfile = "/home/radicaldesigns/verified_wp/wp-content/themes/verified_voting/verifier/importer_backups/".$table . "_" . date("Y-m-d_H-i-s") . ".sql";
  //echo "DEBUG: ABOUT TO SAVE A FILE OUT AS $dumpfile <br/>";
  $dump_result = exec("/usr/bin/mysqldump --opt --host=$server --user=$user --password=$pass $dbname $table > $dumpfile");
  //echo "RESULT " . $dump_result . "<br/><br/>";
  mysql_query("TRUNCATE TABLE $table");//DROP THEM
}

function mysql_insert_array($table, $data, $exclude = array()) {
  $fields = $values = array();
  if( !is_array($exclude) ) $exclude = array($exclude);
  
  foreach( array_keys($data) as $key ){
    if( !in_array($key, $exclude) ) {
      $fields[] = "`$key`";
      $values[] = "'" . mysql_real_escape_string($data[$key]) . "'";
    }
  }
  
  $fields = implode(",", $fields);
  $values = implode(",", $values);
  
  if( mysql_query("INSERT INTO `$table` ($fields) VALUES ($values)") ) {
    return array( "mysql_error" => false,
      "mysql_insert_id" => mysql_insert_id(),
      "mysql_affected_rows" => mysql_affected_rows(),
      "mysql_info" => mysql_info()
    );
  } else {
    return array( "mysql_error" => mysql_error() );
  }
}

function flatten_array($rows){
  $booleans = array('pbvs','dre','dre_pushbutton','dre_touchscreen','dre_dial','vvpat','dre_vvpat','dre_no_vvpat','dre_x_vvpat','bmd','tbad','punchcard','hcpb','vote_by_mail', 'pp_std', 'pp_std_pc', 'pp_std_cc', 'ev_std', 'ev_dis');
  
  $summary = array();
  foreach($booleans as $key){
    $summary[$key] = false;
  }
  

  foreach($booleans as $key){
    foreach($rows as $row){
      if(isset($row[$key]) && $row[$key] != false){
        $summary[$key] = true;
        //break;
      } 
    }
  }
  
  return $summary;
  
}














// free space

?>