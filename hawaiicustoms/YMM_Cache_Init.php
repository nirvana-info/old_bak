<?php

include_once dirname(__FILE__).'/config/config.php';

$cache_folder = isset($GLOBALS['ISC_CFG']["cache_file_folder"]) ? $GLOBALS['ISC_CFG']["cache_file_folder"] :  '/var/tmp/tc_ymm';
$make_array = array('CHEVROLET', 'GMC', 'FORD', 'DODGE', 'TOYOTA', 'NISSAN', 'HONDA', 'JEEP', 'HYUNDAI','CHRYSLER', 'INFINITI', 'LEXUS');

function create_year_cache()
{	
	global $cache_folder;
	$sqlstr = "SELECT min( `prodstartyear` ) as start , max( `prodendyear` ) as end
	FROM `isc_import_variations` iv LEFT JOIN isc_products p ON iv.`productid` = p.productid
	WHERE p.prodvisible = '1' and `prodstartyear` <> 'all' AND `prodendyear` <> 'all'  and `prodstartyear` <> '' AND `prodendyear` <> ''  and `prodstartyear` is not null AND `prodendyear` is not null  ";
	
	$result = mysql_query($sqlstr);
	
	$count = mysql_num_rows($result);
	if( $count < 1 ) 
	{
		$output = "<li>No options available</li>";
	}
	else
	{	
		$row = mysql_fetch_array($result);
		
		$filter_array = range($row['start'], $row['end']);
		
		rsort($filter_array);
		
		$index = 0;
		
		foreach( $filter_array as $value )
		{
			
			if( $index < 10 )
			{
				$list_val .= "<li><a href='".$GLOBALS['ISC_CFG']['ShopPath']."/year/$value' >$value</a></li>";
			}
			else
			{
				$extra_val .= "<li><a href='".$GLOBALS['ISC_CFG']['ShopPath']."/year/$value' >$value</a></li>";
			}
			
			$index++;
		}
		
		$output .= '<ul>'.$list_val."</ul><ul id='extra_year' class='hidelist'>".$extra_val."</ul>";
		if( isset($extra_val) )
			$output .= "<ul class='more'><li><a href=\"javascript:onclick=show_hide('year')\" id='year_more'>More...</a></li></ul>";
	}
	
	try
	{
		file_put_contents($cache_folder.'/column=year_year=_make=_model=.php', $output);
		chmod($cache_folder.'/column=year_year=_make=_model=.php', 0777);
	}
	catch (Exception $e)
	{
		echo 'Message: '.$cache_folder.'/column=year_year=_make=_model=.php: '.$e->getMessage();
	}
	
	echo "year cache created.\n\n";
}

function create_make_cache()
{
	global $cache_folder;
	$sqlstr = "SELECT DISTINCT `prodmake` FROM `isc_import_variations` iv
				LEFT JOIN isc_products p ON iv.`productid` = p.productid
				WHERE p.prodvisible = '1' and iv.`prodstartyear` <> 'all' AND iv.`prodendyear` <> 'all'
				order by prodmake asc ";
	
	global $make_array;
	
	$result = mysql_query($sqlstr);
	
	$count = mysql_num_rows($result);
	
	if( $count < 1 ) 
	{
		$output = "<li>No options available</li>";
	}
	else
	{	
		unset($list_val);
		unset($extra_val);
		
		foreach($make_array as $key=>$value)
		{
			$list_val .= "<li><a href='".$GLOBALS['ISC_CFG']['ShopPath']."/make/".str_replace(' ', '-', $value)."' >".$value."</a></li>";
		}
		
		while( $row = mysql_fetch_array($result) )
		{
			if( strtoupper($row['prodmake']) === 'NON-SPEC VEHICLE' )
				continue;
			if( in_array($row['prodmake'], $make_array) )
				continue;
			$make_array[] = $row['prodmake'];
			
			$extra_val .= "<li><a href='".$GLOBALS['ISC_CFG']['ShopPath']."/make/".str_replace(' ', '-', $row['prodmake'])."' >".$row['prodmake']."</a></li>";
		}
		$output .= '<ul>'.$list_val."</ul><ul id='extra_make' class='hidelist'>".$extra_val."</ul>";
		if( isset($extra_val) )
			$output .= "<ul class='more'><li><a href=\"javascript:onclick=show_hide('make')\" id='make_more'>More...</a></li></ul>";
	}
	
	try
	{
		file_put_contents($cache_folder.'/column=make_year=_make=_model=.php', $output);
		chmod($cache_folder.'/column=make_year=_make=_model=.php', 0777);
	}
	catch (Exception $e)
	{
		echo 'Message: '.$cache_folder.'/column=make_year=_make=_model=.php: '.$e->getMessage();
	}
	
	echo "make cache created.\n\n";
}

function create_make_year_cache()
{
	global $make_array;
	global $cache_folder;
	foreach($make_array as $make)
	{
		if( strtoupper($make) === 'NON-SPEC VEHICLE' )
			continue;
		$sqlstr = "SELECT min( iv.`prodstartyear` ) AS start , max( iv.`prodendyear` ) AS end FROM `isc_import_variations` iv
					LEFT JOIN isc_products p ON iv.`productid` = p.productid
					WHERE p.prodvisible = '1' and iv.`prodmake` =  '$make' 
					and `prodstartyear` <> 'all' AND `prodendyear` <> 'all'  and `prodstartyear` <> '' AND `prodendyear` <> ''  and `prodstartyear` is not null AND `prodendyear` is not null";
		
		$result = mysql_query($sqlstr);
	
		$count = mysql_num_rows($result);
		
		if( $count < 1 ) 
		{
			$output = "<li>No options available</li>";
		}
		else
		{	
			$row = mysql_fetch_array($result);
		
			$filter_array = range($row['start'], $row['end']);
			
			rsort($filter_array);
			
			$index = 0;
			
			unset($extra_val);
			unset($list_val);
			unset($output);
			
			foreach( $filter_array as $value )
			{
				if( $index < 10 )
				{
					$list_val .= "<li><a href='".$GLOBALS['ISC_CFG']['ShopPath']."/year/$value' >$value</a></li>";
				}
				else
				{
					$extra_val .= "<li><a href='".$GLOBALS['ISC_CFG']['ShopPath']."/year/$value' >$value</a></li>";
				}
				
				$index++;
				//need process for make-year-model cache
				create_make_year_model_cache($make, $value);
			}
			
			$output .= '<ul>'.$list_val."</ul><ul id='extra_year' class='hidelist'>".$extra_val."</ul>";
			if( isset($extra_val) )
				$output .= "<ul class='more'><li><a href=\"javascript:onclick=show_hide('year')\" id='year_more'>More...</a></li></ul>";
		}
		
		try
		{
			file_put_contents($cache_folder."/column=year_year=_make=".str_replace(' ', '_', $make)."_model=.php", $output);
			chmod($cache_folder."/column=year_year=_make=".str_replace(' ', '_', $make)."_model=.php", 0777);
		}
		catch (Exception $e)
		{
			echo 'Message: '.$cache_folder."/column=year_year=_make=".$make."_model=.php".': '.$e->getMessage();
		}
	}
	
	echo "make year cache created.\n\n";
}

function create_make_year_model_cache($make, $year)
{
	global $cache_folder;
	
	$sqlstr = "SELECT DISTINCT iv.`prodmodel` 
		FROM `isc_import_variations` iv
		LEFT JOIN isc_products p ON iv.`productid` = p.productid
		WHERE p.prodvisible = '1' and iv.`prodmake` = '$make' AND $year >= iv.`prodstartyear` AND $year <= iv.`prodendyear` ORDER BY iv.`prodmodel` ASC";
	 
	$result = mysql_query($sqlstr);
	
	$count = mysql_num_rows($result);
	
	unset($output);
	
	if( $count < 1 ) 
	{
		$output = "<li>No options available</li>";
	}
	else
	{	
		$index = 0;
		unset($list_val);
		unset($extra_val);
		
		while( $row = mysql_fetch_array($result) )
		{
			if( $index < 10 )
			{
				$list_val .= "<li><a href='".$GLOBALS['ISC_CFG']['ShopPath']."/make/".str_replace(' ', '-', $make)."/model/".str_replace(' ', '-', $row['prodmodel'])."' >".$row['prodmodel']."</a></li>";
			}
			else
			{
				$extra_val .= "<li><a href='".$GLOBALS['ISC_CFG']['ShopPath']."/make/".str_replace(' ', '-', $make)."/model/".str_replace(' ', '-', $row['prodmodel'])."' >".$row['prodmodel']."</a></li>";
			}
			
			$index++;
		}
		
		$output .= '<ul>'.$list_val."</ul><ul id='extra_model' class='hidelist'>".$extra_val."</ul>";
		if( isset($extra_val) )
			$output .= "<ul class='more'><li><a href=\"javascript:onclick=show_hide('model')\" id='model_more'>More...</a></li></ul>";
	}
	
	try
	{
		file_put_contents($cache_folder."/column=model_year=".$year."_make=".str_replace(' ', '_', $make)."_model=.php", $output);
		chmod($cache_folder."/column=model_year=".$year."_make=".str_replace(' ', '_', $make)."_model=.php", 0777);
	}
	catch (Exception $e)
	{
		echo 'Message: '.$cache_folder."/column=model_year=".$year."_make=".$make."_model=.php".': '.$e->getMessage();
	}
	
	echo "make year model cache created.\n\n";
}

function create_make_model_cache()
{
	global $make_array;
	global $cache_folder;
	foreach($make_array as $make)
	{
		if( strtoupper($make) === 'NON-SPEC VEHICLE' )
			continue;
		$sqlstr = "SELECT DISTINCT iv.`prodmodel` FROM `isc_import_variations` iv
					LEFT JOIN isc_products p ON iv.`productid` = p.productid
					WHERE p.prodvisible = '1' and iv.`prodmake` = '$make' ORDER BY iv.`prodmodel` ASC ";
		
		$result = mysql_query($sqlstr);
	
		$count = mysql_num_rows($result);
		
		if( $count < 1 ) 
		{
			$output = "<li>No options available</li>";
		}
		else
		{				
			$index = 0;
			unset($list_val);
			unset($extra_val);
			unset($output);
			
			while( $row = mysql_fetch_array($result) )
			{
				if( $index < 10 )
				{
					$list_val .= "<li><a href='".$GLOBALS['ISC_CFG']['ShopPath']."/make/".str_replace(' ', '-', $make)."/model/".str_replace(' ', '-', $row['prodmodel'])."' >".$row['prodmodel']."</a></li>";
				}
				else
				{
					$extra_val .= "<li><a href='".$GLOBALS['ISC_CFG']['ShopPath']."/make/".str_replace(' ', '-', $make)."/model/".str_replace(' ', '-', $row['prodmodel'])."' >".$row['prodmodel']."</a></li>";
				}
				
				$index++;
				
				//process make model year cache
				create_make_model_year_cache($make, $row['prodmodel']);
			}
			
			$output .= '<ul>'.$list_val."</ul><ul id='extra_model' class='hidelist'>".$extra_val."</ul>";
			if( isset($extra_val) )
				$output .= "<ul class='more'><li><a href=\"javascript:onclick=show_hide('model')\" id='model_more'>More...</a></li></ul>";		
		}
		
		try
		{
			file_put_contents($cache_folder."/column=model_year=_make=".str_replace(' ', '_', $make)."_model=.php", $output);
			chmod($cache_folder."/column=model_year=_make=".str_replace(' ', '_', $make)."_model=.php", 0777);
		}
		catch (Exception $e)
		{
			echo 'Message: '.$cache_folder."/column=model_year=_make=".$make."_model=.php".': '.$e->getMessage();
		}
		
		echo "make model cache created.\n\n";
	}
}

function create_make_model_year_cache($make, $model)
{
	global $cache_folder;
	
	$sqlstr = "SELECT MIN(iv.`prodstartyear`) as start, MAX(iv.`prodendyear`) end FROM `isc_import_variations` iv
				LEFT JOIN isc_products p ON iv.`productid` = p.productid
				WHERE p.prodvisible = '1' and iv.`prodmake` = '$make' AND iv.`prodmodel` = '$model' and `prodstartyear` <> 'all' AND `prodendyear` <> 'all'  and `prodstartyear` <> '' AND `prodendyear` <> ''  and `prodstartyear` is not null AND `prodendyear` is not null  ";
	
	$result = mysql_query($sqlstr);
	
	$count = mysql_num_rows($result);
	
	unset($output);
	
	if( $count < 1 ) 
	{
		$output = "<li>No options available</li>";
	}
	else
	{
		$row = mysql_fetch_array($result);
		
		$filter_array = range($row['start'], $row['end']);
		
		rsort($filter_array);
		
		$index = 0;
		unset($list_val);
		unset($extra_val);
		unset($output);
		
		foreach( $filter_array as $value )
		{
			
			if( $index < 10 )
			{
				$list_val .= "<li><a href='".$GLOBALS['ISC_CFG']['ShopPath']."/year/$value' >$value</a></li>";
			}
			else
			{
				$extra_val .= "<li><a href='".$GLOBALS['ISC_CFG']['ShopPath']."/year/$value' >$value</a></li>";
			}
			
			$index++;
		}
		
		$output .= '<ul>'.$list_val."</ul><ul id='extra_year' class='hidelist'>".$extra_val."</ul>";
		if( isset($extra_val) )
			$output .= "<ul class='more'><li><a href=\"javascript:onclick=show_hide('year')\" id='year_more'>More...</a></li></ul>";
	}
		
	try
	{
		file_put_contents($cache_folder."/column=year_year=_make=".str_replace(' ', '_', $make)."_model=".str_replace('/', '_', str_replace(' ', '_', $model)).".php", $output);
		chmod($cache_folder."/column=year_year=_make=".str_replace(' ', '_', $make)."_model=".str_replace('/', '_', str_replace(' ', '_', $model)).".php", 0777);
	}
	catch (Exception $e)
	{
		echo "Message: ".$cache_folder."/column=year_year=_make=".$make."_model=".$model.".php: ".$e->getMessage();
	}
		
	echo "make model year cache created.\n\n";
}

if( strtolower(PHP_SAPI) === 'cli' )
{
	mkdir($cache_folder, 0777);

	$conn = mysql_connect('127.0.0.1', $GLOBALS['ISC_CFG']["dbUser"], $GLOBALS['ISC_CFG']["dbPass"]) or die("Cannot connect to the database");
		
	mysql_select_db($GLOBALS['ISC_CFG']["dbDatabase"] ,$conn) or die ("Cannot found the database");

	chdir($cache_folder);

	create_year_cache();
	//create_make_cache();
	//create_make_year_cache();
	//create_make_model_cache();
}
?>
