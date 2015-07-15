<?php
$link = mysql_connect('localhost', 'storeadmin', 'storeadmin');
if (!$link) {
    die('Not connected : ' . mysql_error());
}

// make foo the current db
$db_selected = mysql_select_db('store', $link);
if (!$db_selected) {
    die ('Can\'t use kb : ' . mysql_error());
}

$dir = "PQ.csv";
							if (file_exists($dir) ) {
											
								$file_handle = fopen($dir, "r");
								while (!feof($file_handle) ) {
									$line_of_text = fgetcsv($file_handle, 1024);

$resultarray = array_unique($line_of_text);



for ($i = 0; $i <= count($resultarray); $i++) {

	
   
		if ($resultarray[0] != "" and $i == 0)
			{
		$query = "select categoryid  from isc_categories where  catname  = '".$resultarray[0]."'  limit 0,1 ";
		$result = mysql_query($query);
		$row = mysql_fetch_array($result);
		$categoryid1 = $row['categoryid'];
		if ($categoryid1 == "") echo "<BR>".$resultarray[0] ."Not exist ";
		continue;
			}

		if ($resultarray[1] != "" and $i == 1)
			{
		$query = "select categoryid  from isc_categories where  catname  = '".$resultarray[1]."'  limit 0,1 ";
		$result = mysql_query($query);
		$row = mysql_fetch_array($result);
		$categoryid = $row['categoryid'];
		if ($categoryid == "") echo "<BR>".$resultarray[1] ."Not exist ";

		continue;
			}

		if ($categoryid == "") $categoryid = $categoryid1;


		if ($resultarray[$i] != "" )
			{



							$value = $resultarray[$i];
							$string_temp =  substr($value,2);
							$column_name =  substr($value,0,2).strtolower($string_temp);

							$query = "select qid  from isc_qualifier_names  where column_name  = '".$column_name."' ";
							$result = mysql_query($query);
							$row = mysql_fetch_array($result);
							$qualifierid  = $row['qid'];

								
							 if ($categoryid == "" || $qualifierid == "") continue;
							else
								{
							$query = "select associd from isc_qualifier_associations where qualifierid   = ".$qualifierid." and categoryid   = ".$categoryid ." ";
							$result = mysql_query($query);
							$num_rows = mysql_num_rows($result);

							if ($num_rows == 0)
									{
								echo "<BR>".$sql = "INSERT INTO `isc_qualifier_associations` ( `qualifierid`, `categoryid`) VALUES (". $qualifierid.",". $categoryid.")";
								mysql_query($sql);
									}
								}



		}
									
}
									 
}
}
								

?>