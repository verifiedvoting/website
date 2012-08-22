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
  $dumpfile = "/home/radicaldesigns/verified_wp/wp-content/themes/verified_voting/verifier/importer_backups/".$table. ".sql";
  $exec_string = "/usr/bin/mysqldump --host=".$GLOBALS['server']." --user=".$GLOBALS['user']." --password=".$GLOBALS['password']." ".$GLOBALS['dbname']." $table > $dumpfile";  
  $dump_result = exec($exec_string);
  mysql_query("TRUNCATE TABLE $table");//DROP THEM
}

function restore_backup($table){
  //mysql_select_db($mysql_database) or die('Error selecting MySQL database: ' . mysql_error());

  $templine = '';
  $lines = file('/home/radicaldesigns/verified_wp/wp-content/themes/verified_voting/verifier/importer_backups/'.$table.'.sql');

  foreach ($lines as $line)
  {
    // Skip it if it's a comment
    if (substr($line, 0, 2) == '--' || $line == ''){
      continue;
    }
    
    // Add this line to the current segment
    $templine .= $line;
    // If it has a semicolon at the end, it's the end of the query
    if (substr(trim($line), -1, 1) == ';'){
      // Perform the query
      mysql_query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
      // Reset temp variable to empty
      $templine = '';
    }
  }
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