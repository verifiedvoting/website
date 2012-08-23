<?php

include('connection.php');


$query =  "select DISTINCT(equip_type) from machine";
$result = mysql_query($query);
$rows = array();
echo '<select id="search-equipment">'. "\n";
echo '  <option value="">All Equipment</option>."\n"';
while($row = mysql_fetch_assoc($result)){
  if($row['equip_type']!=''){
  echo '  <option value="'.$row['equip_type'].'">'.$row['equip_type'].'</option>'."\n";
  }
}
echo "</select>\n\n";

$query =  "select DISTINCT(vendor) from machine";
$result = mysql_query($query);
$rows = array();
echo '<select id="search-vendor" multiple="true">'. "\n";
echo '  <option value="">All Vendors</option>'."\n";
while($row = mysql_fetch_assoc($result)){
  if($row['vendor']!='' && $row['vendor'] != 'N/A' && $row['vendor'] != 'n/a'){
  echo '  <option value="'.$row['vendor'].'">'.$row['vendor'].'</option>'."\n";
  }
}
echo "</select>\n\n";

$query =  "select DISTINCT(make) from machine";
$result = mysql_query($query);
$rows = array();
echo '<select id="search-make" multiple="true">'. "\n";
echo '  <option value="">All Makes</option>'."\n";
while($row = mysql_fetch_assoc($result)){
  if($row['make']!='' && $row['make'] != 'N/A' && $row['make'] != 'n/a'){
  echo '  <option value="'.$row['make'].'">'.$row['make'].'</option>'."\n";
  }
}
echo "</select>\n\n";

$query =  "select DISTINCT(model) from machine ORDER BY model";
$result = mysql_query($query);
$rows = array();
echo '<select id="search-model" multiple="true">'. "\n";
echo '  <option value="">All Models</option>'."\n";
while($row = mysql_fetch_assoc($result)){
  if($row['model']!='' && $row['model'] != 'N/A' && $row['model'] != 'n/a'){
  echo '  <option value="'.$row['model'].'">'.$row['model'].'</option>'."\n";
  }
}
echo "</select>\n\n";

?>
