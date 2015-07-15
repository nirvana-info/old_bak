<?php
include(dirname(__FILE__) . "/init.php");
$path = GetConfig('ShopPath');
//$GLOBALS['ISC_CLASS_SEARCH']->HandlePage();
$count = 0;
$Query = "select id , prodmake , prodmodel , prodstartyear , prodendyear , VQcabsize from isc_import_variations where VQcabsize regexp ';'";
$Result = $GLOBALS['ISC_CLASS_DB']->Query($Query);
while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($Result)) {
	
		$id = $row['id'];
		$make = $row['prodmake'];
		$model = $row['prodmodel'];
		$startyear = $row['prodstartyear'];
		$endyear = $row['prodendyear'];
		$general_string = array();
		$cabsizes = explode(";",$row['VQcabsize']);
		$flag = 0;
		for($i=0;$i<count($cabsizes);$i++)
		{
			if($cabsizes[$i] != "") {
				$cab = $cabsizes[$i];
				$query2 = "select generalize_value from isc_cabsize_translation where prodmake = '".$make."' and prodmodel = '".$model."' and prodstartyear = '".$startyear."' and prodendyear = '".$endyear."' and irregular_value = '".$cab."'";
				$result2 = $GLOBALS['ISC_CLASS_DB']->Query($query2);
				$count2 = $GLOBALS['ISC_CLASS_DB']->CountResult($result2);
				if($count2 > 0) {
					$arr2 = $GLOBALS['ISC_CLASS_DB']->Fetch($result2);
					if(!in_array($arr2['generalize_value'] , $general_string)) {
						$flag = 1;
						$general_string[] = $arr2['generalize_value'];
					}
				} else {
					if(!in_array($cabsizes[$i] , $general_string))
						$general_string[] = $cabsizes[$i];
				}
			}
		}

		if(!empty($general_string) && $flag == 1) {
			$count++;
			$query3 = "update isc_import_variations set cabsize_generalname = '".implode(';',$general_string)."' where id = ".$id;
			$result3 = $GLOBALS['ISC_CLASS_DB']->Query($query3);
		}

}
echo "Count :".$count;
?>