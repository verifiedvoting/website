<?php
/**
 * Template Name: Importer
 */


?><html>
<head>
<style>
body {
  font-family: Arial, sans-serif;
}
</style>
</head>
<body>
<div style="font-weight:bold;font-size:28px;">Verifier Machine Importer</div><hr/>
<form action="/importer/" method="post"
enctype="multipart/form-data">
<label for="file">Filename:</label>
<input type="file" name="file" id="file" /> <Br/>
<!-- <input type="checkbox" name="drop" value="true" checked="checked"/>Drop entire table and replace -->
<br />
Type of data<br/>
<input type="radio" name="table" value="machine" checked>Machines<Br/>
<input type="radio" name="table" value="official">Officials<br/>
<br/>
<input type="submit" name="submit" value="Submit" />
</form>
<hr/>

<?php
include('verifier/functions.php');
include('verifier/connection.php');

if(count($_POST)>0) {
  
  if ($_FILES["file"]["error"] > 0){
  	echo "Error: " . $_FILES["file"]["error"] . "<br />";
  } else {    
      //setup
    $file = $_FILES["file"];
    $drop = $_POST["drop"]=="true" ? true : false;
    $table = $_POST["table"];
    
    $fref = fopen($file["tmp_name"], "r");
    
    if($table=='machine'){
      $boolscrub = array(
      'pbvs','dre_pushbutton','dre_touchscreen','dre_dial','vvpat','bmd','tbad','punchcard','hcpb','vote_by_mail');
    $pass = explode(
      ' ',
      'year state county division jurisdiction_type corrected_fips st_fips cty_fips div_fips pbvs dre_pushbutton dre_touchscreen dre_dial vvpat bmd tbad punchcard hcpb vote_by_mail equip_type vendor make model firmware_version software_version quantity pp_std pp_std_pc pp_std_cc pp_dis pp_dis_pc pp_dis_cc ev_std ev_dis'
      );
     import_sheet($fref,$table,$pass,$boolscrub);   
    } else if($table=='official'){
      $bools = explode(' ','nation_map state_map county_map audit');
      $pass = explode(' ','state county division jurisdiction_type nation_map state_map county_map precincts state_fips county_fips div_fips current_reg_voters 2010_reg_voters 2010_turnout 2010_pp_voters 2010_uocava 2010_abs 2010_prov 2010_ev 2010_vbm 2012_all_mail_ballot audit position last_name first_name title address_1 address_2 city zipcode phone fax email website');
      import_sheet($fref,$table,$pass,$bools);
    }
   
  }
}


//csv with header row at top still there
//string table name
//array of fieldnames to keep
//array of fieldnames that need to be scrubbed as bools
function import_sheet($csv, $table, $pass, $boolscrub){
  $count = 0;
	$column_names = innie(scrub_names(fgetcsv($csv)));	//first row contains the column names instead of data
	$import_list = '';
	backup_and_drop($table);
  while($row = fgetcsv($csv)){
    
    if(count($column_names) != count($row)){
      echo '<br/><br/><b>CSV row length issue while matching column names with row. Failed on row</b>';
      echo '<br/>Column name columns: '.count($column_names)." | row columns: ".count($row);
      print_r($column_names);
      print_r($row);
      break;
    }
    $row = marry($column_names,$row);
    

    $row = filter_columns($row, $pass);
    $row = scrub_booleans($row, $boolscrub);
    
    $import_list .= $row['county']." - ".$row['equip_type']." row inserted<br/>";

    
    //echo '<br/>Inserting row:<Br/>';
    $result = mysql_insert_array($table,$row);
    $count++;  
  }
  echo $import_list;
}


?>



</body>
</html>

