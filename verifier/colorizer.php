<?php

include_once('connection.php');
include_once('functions.php');


$json = file_get_contents("usa_source.json");
$outfile = fopen("usa.json",'w');

$usa = json_decode($json);
$feature = $usa->features[0];

$x =0;

foreach($usa->features as $feature){
  $state_fips = intval($feature->properties->STATE);
  $result =  mysql_query("SELECT * FROM machine WHERE state_fips LIKE $state_fips AND jurisdiction_type LIKE 'State'");// AND (pp_std LIKE 1 OR pp_acc LIKE 1)");
  
  $rows = array();
  while($row = mysql_fetch_assoc($result)){
    $rows[] = $row;
  }
  if(count($rows)<1){
    //continue;
  }
  
  if($state_fips ==1){
    print_r($rows);
  }
  $summary = flatten_array($rows);
  
  if($state_fips==22){
    print_r($summary);
  }

  if($summary['pbvs'] && !$summary['dre_vvpat'] && !$summary['dre_no_vvpat'] && !$summary['dre_x_vvpat']){
    $feature->properties->CODE = 'pbvs';
  } else if($summary['pbvs'] && $summary['dre_vvpat'] && !$summary['dre_no_vvpat'] && !$summary['dre_x_vvpat']){
    $feature->properties->CODE = 'mpbv';
  } else if($summary['pbvs'] && $summary['dre_no_vvpat'] && !$summary['dre_vvpat'] && !$summary['dre_x_vvpat']){
    $feature->properties->CODE = 'mpbn';
  } else if($summary['pbvs'] && $summary['dre_x_vvpat'] && !$summary['dre_vvpat'] && !$summary['dre_no_vvpat']){
    $feature->properties->CODE = 'mpdx';
  } else if($summary['dre_vvpat'] && !$summary['pbvs'] && !$summary['dre_no_vvpat']){
    $feature->properties->CODE = 'drev';
  } else if ($summary['dre_no_vvpat']){
    $feature->properties->CODE = 'dren';
  }
    
  if(!isset($feature->properties->CODE)){
    echo 'wasnt set - '.$feature->properties->NAME." - ".$state_fips."\n";
    print_r($summary);
    $feature->properties->CODE = 'none';
    if($state_fips==1){
      print_r($summary);
    }
  } else {
    echo "set ".$feature->properties->CODE." for ".$feature->properties->NAME." ".$state_fips."\n";
  }
  
  $result =  mysql_query("SELECT * FROM official WHERE state_fips LIKE $state_fips AND jurisdiction_type LIKE 'State'");// AND (pp_std LIKE 1 OR pp_acc LIKE 1)");
 
  

  $x++;
}
echo "TOTAL Xs $x";
$string = json_encode($usa);

fwrite($outfile,$string);
fclose($outfile);

//print_r($row);
// }

//print_r($usa->features[0]->properties->STATE); //'properties']['STATE']);

print("\n");

?>