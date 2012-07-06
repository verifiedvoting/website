<html>
<head>
<style>
body {
  font-family: Arial, sans-serif;
}
</style>
</head>
<body>
<div style="font-weight:bold;font-size:28px;">Damn Cool Importer</div><hr/>
<form action="index.php" method="post"
enctype="multipart/form-data">
<label for="file">Filename:</label>
<input type="file" name="file" id="file" /> <Br/>
<input type="checkbox" name="drop" value="true" checked="checked"/>Drop entire table and replace
<br />

<input type="submit" name="submit" value="Submit" />
</form>
<hr/>

<?php
include('functions.php');
include('connection.php');

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
	
	if($_POST['drop']=='true') {
  	echo 'dropping the table!';
  	backup_and_drop();
	}
	
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
        print_r($row);
        
        if(!$failed){
            $pass[] = $row;
        } else {
            $fail[] = $row;
        }
        echo '<br/>Inserting row:<Br/>';
        print_r(mysql_insert_array('machine',$row));
        
        
        echo "<br/>";
        
        
        
        $count++;//limit for testing purposes
        //if($count>20) break;
	   
	}
	
    //push $passes into db
    if($drop){
        //backup and then drop the current table first
    }
    
    
}






?>

<hr/>
Damn fine.
</body>
</html>

