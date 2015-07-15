<?php
ini_set('max_execution_time', '0'); 
$link = mysql_connect('localhost', 'webtc', 'cDReuq3#');
if (!$link) {
    die('Not connected : ' . mysql_error());
}

// make foo the current db truck
$db_selected = mysql_select_db('tc_store', $link);
if (!$db_selected) {
    die ('Can\'t use kb : ' . mysql_error());
}


//$link = mysql_connect('localhost', 'root', '');
//if (!$link) {
//    die('Not connected : ' . mysql_error());
//}
//
//// make foo the current db truck
//$db_selected = mysql_select_db('truck', $link);
//if (!$db_selected) {
//    die ('Can\'t use kb : ' . mysql_error());
//}




$k=0;
$query = "SELECT id,prodstartyear, prodendyear,prodmodel , prodsubmodel ,prodmake ,VQcabsize  FROM isc_import_variations  ";
$result = mysql_query($query);
while ($row = mysql_fetch_array($result) )
{
	echo $k++;

	echo "--". $ivid = $row['id'];
	$prodstartyear = $row['prodstartyear'];
	$prodendyear = $row['prodendyear'];
	$prodmodel = $row['prodmodel'];
	$prodsubmodel = $row['prodsubmodel'];
	$prodmake = $row['prodmake'];
	$VQcabsize = $row['VQcabsize'];
	$generalize_cabvalue = "";
if ($VQcabsize != "")
		{

	$query2 = "SELECT id FROM isc_product_mmy  WHERE (year  = '".$prodstartyear."' or year  = '".$prodendyear."' ) and model   = '".$prodmodel."' and submodel = '".$prodsubmodel."' and make   = '".$prodmake."' limit 0,1 ";
	$result2 = mysql_query($query2);
	$row2 = mysql_fetch_array($result2);
	echo "--".$ymm_id = $row2['id'];
	echo "<BR>";

	
			
			$cabsize_pieces = preg_split("/[;,]/", $VQcabsize);
			$end = end($cabsize_pieces);
			if(empty($end)) array_pop($cabsize_pieces);

			foreach ($cabsize_pieces as $key => $value) 
			{
				$query3 = "SELECT id,generalize_value FROM isc_cabsize_translation WHERE prodstartyear = '".$prodstartyear."' and prodendyear = '".$prodendyear."'  and prodmake  = '".$prodmake."' and prodmodel  = '".$prodmodel."' and irregular_value = '".$value."'  limit 0,1 ";
				$result3 = mysql_query($query3);
				$bed_row = mysql_fetch_array($result3);
				$generalize_cabvalue.= $bed_row['generalize_value'].";";
				
			}		
			echo "-one-".$generalize_cabvalue = trim($generalize_cabvalue,";");
		
			echo "<BR>";

		

		if ($generalize_cabvalue == ""  )
			{

		$query4 = "SELECT cabsize  FROM isc_cabbed_table  WHERE ymm_id = '".$ymm_id."'  limit 0,1 ";
		$result4 = mysql_query($query4);
		$eng_row = mysql_fetch_array($result4);
		if ($eng_row['cabsize'] != "") $generalize_cabvalue = $eng_row['cabsize'];
		echo "-two-".$generalize_cabvalue;		
			}
			if ($generalize_cabvalue != ""  )
						{
			
			echo "<BR>";
						echo $update = "update isc_import_variations set cabsize_generalname = '".$generalize_cabvalue."' where id = ".$ivid." and cabsize_generalname = ''  ";
						mysql_query($update);
			
						}

}

    echo "<BR>";

}
?>
