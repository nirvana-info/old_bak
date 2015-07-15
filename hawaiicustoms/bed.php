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


$k=0;
$query = "SELECT id,prodstartyear, prodendyear,prodmodel , prodsubmodel ,prodmake ,VQbedsize  FROM isc_import_variations  ";
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
	$VQbedsize = $row['VQbedsize'];
	$generalize_bedvalue = "";
if ($VQbedsize != "")
		{

	$query2 = "SELECT id FROM isc_product_mmy  WHERE (year  = '".$prodstartyear."' or year  = '".$prodendyear."' ) and model   = '".$prodmodel."' and submodel = '".$prodsubmodel."' and make   = '".$prodmake."' limit 0,1 ";
	$result2 = mysql_query($query2);
	$row2 = mysql_fetch_array($result2);
	echo "--".$ymm_id = $row2['id'];
	echo "<BR>";

	
			
			$bedsize_pieces = preg_split("/[;,]/", $VQbedsize);
			$end = end($bedsize_pieces);
			if(empty($end)) array_pop($bedsize_pieces);

			foreach ($bedsize_pieces as $key => $value) 
			{
				$query3 = "SELECT id,generalize_value FROM isc_bedsize_translation WHERE irregular_value = '".$value."'  limit 0,1 ";
				$result3 = mysql_query($query3);
				$bed_row = mysql_fetch_array($result3);
				$generalize_bedvalue.= $bed_row['generalize_value'].";";
				
			}		
			echo "-one-".$generalize_bedvalue = trim($generalize_bedvalue,";");
		
			echo "<BR>";

		

		if ($generalize_bedvalue == ""  )
			{

		$query4 = "SELECT bedsize  FROM isc_cabbed_table  WHERE ymm_id = '".$ymm_id."'  limit 0,1 ";
		$result4 = mysql_query($query4);
		$eng_row = mysql_fetch_array($result4);
		if ($eng_row['bedsize'] != "") $generalize_bedvalue = $eng_row['bedsize'];
		echo "-two-".$generalize_bedvalue;		
			}
			if ($generalize_bedvalue != ""  )
						{
			
			echo "<BR>";
						echo $update = "update isc_import_variations set bedsize_generalname = '".$generalize_bedvalue."' where id = ".$ivid." and bedsize_generalname = '' ";
						mysql_query($update);
			
						}

}

    echo "<BR>";

}
?>
