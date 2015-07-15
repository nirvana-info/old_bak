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

$writethecatsubcat 	= "";
$writethepqvq 	= "";
$query = "select categoryid ,catname  from isc_categories where catparentid = 0 order by catname  asc  ";
$result = mysql_query($query);
while ($row = mysql_fetch_array($result)) {      
                    
				

					$query1 = "select categoryid ,catname  from isc_categories where catparentid = ".$row['categoryid']." order by catname  asc  ";
					$result1 = mysql_query($query1);
					while ($row1 = mysql_fetch_array($result1)) {      
										
									echo "<BR>1".$query2 = "select qn.column_name  from isc_qualifier_associations qa join isc_qualifier_names qn  on qn.qid  = qa.qualifierid where categoryid = ".$row1['categoryid']." ";
									$result2 = mysql_query($query2);
									while ($row2 = mysql_fetch_array($result2)) {    
										if ($row2['column_name'] != "")
										$writethepqvq.= $row2['column_name'].",";

									}
					$cat = str_replace(",", "-", $row['catname']);
					$subcat = str_replace(",", "-", $row1['catname']);
					$writethecatsubcat.=$cat.",".$subcat.",".$writethepqvq."\n";
					$writethepqvq = "";
					}  

//									echo "<BR>2".$query3 = "select qn.column_name  from isc_qualifier_associations qa join isc_qualifier_names qn  on qn.qid  = qa.qualifierid where categoryid = ".$row['categoryid']." ";
//									$result3 = mysql_query($query3);
//									while ($row3 = mysql_fetch_array($result3)) {      
//								if ($row2['column_name'] != "")
//									$writethepqvq.= $row2['column_name'].",";
//									}

					//$cat = str_replace(",", "-", $row['catname']);
					//$subcat = str_replace(",", "-", $row1['catname']);
					//$writethecatsubcat.=$cat.",,".$writethepqvq."\n";
					//$writethepqvq = "";

}  
//echo $writethecatsubcat;

	$filename = 'test.csv';
	 if (!$handle = fopen($filename, 'a')) {
         
	}
    if (fwrite($handle, $writethecatsubcat) === FALSE) {
          
    }
    fclose($handle);								


?>