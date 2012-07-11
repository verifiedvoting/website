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

<input type="submit" name="submit" value="Submit" />
</form>
<hr/>

<?php
include('verifier/functions.php');
include('verifier/connection.php');

if(count($_POST)>0) {

if ($_FILES["file"]["error"] > 0)
{
	echo "Error: " . $_FILES["file"]["error"] . "<br />";
}
else
{   
    //setup
	$file = $_FILES["file"];
	$pass = array();
	$fail = array();
	$drop = $_POST["drop"]=="true" ? true : false;

	$fref = fopen($file["tmp_name"], "r");
	$column_names = innie(scrub_names(fgetcsv($fref)));	//first row contains the column names instead of data
	
	$row = array();
	$count = 0;
	
	
  //just drop the old rows
  backup_and_drop();
	
	
	$import_list = '';
	
	while($row = fgetcsv($fref)){
    if(count($column_names) != count($row)){
      echo '<br/><br/><b>CSV row length issue while matching column names with row. Failed on row</b>';
      echo '<br/>Column name columns: '.count($column_names)." | row columns: ".count($row);
      print_r($column_names);
      print_r($row);
      break;
    }
    $row = marry($column_names,$row);
    
    $row = array_slice($row,0,33);
    //do some scrubby scrubby
    //turn texts into 0 and 1 to make mysql happy
    $row['pbvs'] = ($row['pbvs']=="TRUE") ? 1 : 0;
    $row['dre_pushbutton'] = ($row['dre_pushbutton']=="TRUE") ? 1 : 0;
    $row['dre_touchscreen'] = ($row['dre_touchscreen']=="TRUE") ? 1 : 0;
    $row['dre_dial'] = ($row['dre_dial']=="TRUE") ? 1 : 0;
    $row['vvpat'] = ($row['vvpat']=="TRUE") ? 1 : 0;
    $row['bmd'] = ($row['bmd']=="TRUE") ? 1 : 0;
    $row['tbad'] = ($row['tbad']=="TRUE") ? 1 : 0;
    $row['punchcard'] = ($row['punchcard']=="TRUE") ? 1 : 0;
    $row['hcpb'] = ($row['hcpb']=="TRUE") ? 1 : 0;
    $row['vote_by_mail'] = ($row['vote_by_mail']=="TRUE") ? 1 : 0;
    
    //do some validation
    //print_r($row);
    //echo $row['county'].' - '.$row['equip_type'];

    //echo '<br/>Inserting row:<Br/>';
    $result = mysql_insert_array('machine',$row);
    
        
    if($result['error']){
        $fail[] = $row;
        $import_list .= $result['error'].'<br/>';
    } else {
        $pass[] = $row;
        $import_list .= $row['county']." - ".$row['equip_type']." row inserted<br/>";
    }
    $count++;//limit for testing purposes
    //if($count>20) break;	   
	}
	echo ($count+1).' rows imported<Br/>';
	echo count($fail).' rows rejected<Br/><br/>';
  echo $import_list;
	
	
  //push $passes into db
  if($drop){
      //backup and then drop the current table first
  }
    
    
}
}





?>



</body>
</html>

