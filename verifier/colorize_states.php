<?php

include_once('connection.php');
include_once('functions.php');



$result = mysql_query("SELECT * FROM state WHERE state_fips=42");
$row = mysql_fetch_assoc($result);
$json =json_decode($row['json']);

//for each
print_r($json->features[0]->properties);


$x =0;
foreach($json->features as $feature){
  $state_fips = intval($feature->properties->STATE);
  $county_fips = intval($feature->properties->COUNTY);
  $county_query = "SELECT * FROM machine WHERE state_fips LIKE $state_fips AND jurisdiction_type LIKE 'County' AND county_fips LIKE $county_fips";
  $result =  mysql_query($county_query);// AND (pp_std LIKE 1 OR pp_acc LIKE 1)");
  
  $rows = array();
  while($row = mysql_fetch_assoc($result)){
    $rows[] = $row;
  }
  if(count($rows)<1){
    //continue;
  }
  
 // echo $county_query . "\n";
//  echo count($rows)." machine rows for county\n";
  
  $summary = flatten_array($rows);
  
  if($summary['pbvs'] && !$summary['vvpat'] && !$summary['dre_x_vvpat']){
    $feature->properties->CODE = 'pbvs';
  } else if($summary['pbvs'] && $summary['vvpat']&& !$summary['dre_x_vvpat']){
    $feature->properties->CODE = 'mpbv';
  } else if($summary['pbvs'] && !$summary['vvpat'] && !$summary['dre_x_vvpat']){
    $feature->properties->CODE = 'mpbn';
  } else if($summary['pbvs'] && $summary['dre_x_vvpat'] && !$summary['vvpat']){
    $feature->properties->CODE = 'mpdx';
  } else if($summary['vvpat'] && !$summary['pbvs'] ){
    $feature->properties->CODE = 'drev';
  } else if (!$summary['vvpat']){
    $feature->properties->CODE = 'dren';
  }
  
  if(!isset($feature->properties->CODE)){
    echo 'wasnt set - '.$feature->properties->NAME." - ".$state_fips."\n";
    print_r($summary);
    echo "\n\n";
    $feature->properties->CODE = 'none';
  } else {
    echo "set ".$feature->properties->CODE." for ".$feature->properties->NAME." ".$state_fips."\n\n";
  }
  $x++;
}
echo "TOTAL Xs $x";

$json_out = json_encode($json);
$update_query = "UPDATE state set json='$json_out' WHERE state_fips=42";
echo mysql_query($update_query);



print("\n");



?>