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
<h3>Import</h3>
Existing data is automatically backed up when uploading new version<Br/><Br/>
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
<form action="/importer/" method="Post">
<h3>Restore From Backup</h3>
<input type="radio" name="table" value="machine" checked>Machines<Br/>
<input type="radio" name="table" value="official">Officials<br/>
<input type="hidden" name="restore" value="restore"><br/>
<input type="submit" name="submit" value="Submit" />
</form>
<hr>
<?php
include('verifier/functions.php');
include('verifier/connection.php');


$fail = array(); //array for failed lines

if(count($_POST)>0) {

  if($_POST['restore']) {
    echo 'Did the restore thing!';
    $table = $_POST["table"];
    restore_backup($table);
    
  } else {
  
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
  'pbvs','dre_pushbutton','dre_touchscreen','dre_dial','vvpat','dre','dre_x_vvpat','bmd','tbad','punchcard','hcpb','vote_by_mail','pp_acc', 'pp_std', 'pp_std_pc', 'pp_std_cc', 'ev_std', 'ev_acc','abs_ballots', 'prov_ballots');
        $pass = explode(
          ' ',
          'year state county division jurisdiction_type corrected_fips state_fips city_fips division_fips pbvs dre_vvpat dre_x_vvpat dre_pushbutton dre_touchscreen dre_dial vvpat dre bmd tbad punchcard hcpb vote_by_mail equip_type vendor make model firmware_version software_version quantity pp_std pp_std_pc pp_std_cc pp_acc pp_dis pp_dis_pc pp_dis_cc ev_std ev_acc abs_ballots prov_ballots'
        );
       import_sheet($fref,$table,$pass,$boolscrub);   
      } else if($table=='official'){
        $bools = explode(' ','nation_map state_map county_map audit');
        $pass = explode(' ','state county division jurisdiction_type nation_map state_map county_map precincts state_fips county_fips div_fips current_reg_voters 2010_reg_voters 2010_turnout pp_system 2010_pp_voters 2010_uocava 2010_abs 2010_prov 2010_ev 2010_vbm 2012_all_mail_ballot audit position last_name first_name title address_1 address_2 city zipcode phone fax email website position_additional last_name_additional first_name_additional title_additional address_1_additional address_2_additional city_additional zipcode_additional phone_additional fax_additional email_additional website_additional');
        import_sheet($fref,$table,$pass,$bools);
      }
     
    }
  }
}

function get_fips($number){
  //we have a 9-10 digit code (should be 10 with leading zero but we assume conversions eat it)
  //  A BBB CCCCC
  // AA BBB CCCCC
  $len = strlen($number);
  
  $division = substr($number,$len-5,5); 
  $county = substr($number,$len-8,3);
  $state = 0;
  if($len==10){
    $state = substr($number,0,2);
  } else {
    $state = substr($number,0,1);
  }
  $out =  array('state'=>$state, 'county'=>$county, 'division'=>$division);
  return $out;
}


//csv with header row at top still there
//string table name
//array of fieldnames to keep
//array of fieldnames that need to be scrubbed as bools
function import_sheet($csv, $table, $pass, $boolscrub){
  $count = 2; //first row is just colum names, so data rows start @ 2
	$column_names = innie(scrub_names(fgetcsv($csv)));	//first row contains the column names instead of data
	$import_list = '';

	backup_and_drop($table);
  while($row = fgetcsv($csv)){
    if(count($column_names) != count($row)){
      echo '<b>ERROR row length issue, row #'.$count.', Check row for commas / syntax errors:</b>';
      $fips = get_fips($row[$column_names['fips_code']]);
      echo '<br/>'." State ".$row[$column_names['state']] ."  FIPS State ".$fips['state'].' - county '.$fips['county'].' - Div '. $fips['division']."<br/>";
      echo "row has ".count($row)." columns, CSV header has ".count($column_names)." column names";
      echo "<br/><br/>";
     // print_r($row);
      continue;
      //break;
    }
    $row = marry($column_names,$row);
    
    $fips = get_fips($row['fips_code']);
    $row = filter_columns($row, $pass);
    $row['state_fips'] = $fips['state'];
    $row['county_fips'] = $fips['county'];
    $row['division_fips'] = $fips['division'];
    $row = scrub_booleans($row, $boolscrub);
    
    $import_list .= $row['county']." - ".$row['equip_type']." row inserted<br/>";
    
    $result = mysql_insert_array($table,$row);
    if($result['mysql_error']){
      echo 'ERROR!!! '.$result['mysql_error']."\n<Br/>";
    }
    $count++;  
  }
  echo $import_list;
}


?>



</body>
</html>

