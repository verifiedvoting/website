<?php

include_once('connection.php');
include_once('functions.php');



$result = mysql_query("SELECT * FROM state WHERE state_fips=42");
$row = mysql_fetch_assoc($result);
$json =json_decode($row['json']);

//for each


$x =0;
foreach($json->features as $feature){
  $state_fips = intval($feature->properties->STATE);
  $county_fips = intval($feature->properties->COUNTY);
  $county_query = "SELECT * FROM official WHERE state_fips LIKE $state_fips AND jurisdiction_type LIKE 'County' AND county_fips LIKE $county_fips";// AND (pp_std LIKE 1 OR pp_acc LIKE 1)";
  $result =  mysql_query($county_query);  
  $official = mysql_fetch_assoc($result);
  
  $feature->properties->CODE = strtolower($official['pp_system']);
  
  if(!isset($feature->properties->CODE) || $feature->properties->CODE == 'none'){
    echo 'wasnt set - '.$feature->properties->NAME." - ".$state_fips."\n";
    print_r($summary);
    echo "\n\n";
    $feature->properties->CODE = 'none';
  } else {
    echo "set ".$feature->properties->CODE." for ".$feature->properties->NAME." ".$county_fips."\n";
    if($feature->properties->COUNTY=="059"){
      //display
    }
  }
  $x++;
}
echo "TOTAL Xs $x";

$json_out = json_encode($json);
$update_query = "UPDATE state set json='$json_out' WHERE state_fips=42";
echo mysql_query($update_query);



print("\n");



?>