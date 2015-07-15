<?php

class UPDATE_YMM_CACHE_FILE
{
	public $cache_folder;
	public $make_array;
	public $product_result;
	
	function __construct()
	{
		$this->make_array = array();
		$this->cache_folder = isset($GLOBALS['ISC_CFG']["cache_file_folder"]) ? $GLOBALS['ISC_CFG']["cache_file_folder"] : '/var/tmp/tc_ymm';	
		mkdir($this->cache_folder, 0777);
		
		chdir($this->cache_folder);
	}
	
	function create_year_cache()
	{			
		//$cache_folder = isset($GLOBALS['ISC_CFG']["cache_file_folder"]) ? $GLOBALS['ISC_CFG']["cache_file_folder"] : '/var/tmp/tc_ymm';	
		
		$sqlstr = "SELECT min( `prodstartyear` ) as start , max( `prodendyear` ) as end
		FROM `isc_import_variations` iv LEFT JOIN isc_products p ON iv.`productid` = p.productid
		WHERE p.prodvisible = '1' and `prodstartyear` <> 'all' AND `prodendyear` <> 'all'  and `prodstartyear` <> '' AND `prodendyear` <> ''  and `prodstartyear` is not null AND `prodendyear` is not null  ";
			
		$result = $GLOBALS['ISC_CLASS_DB']->Query($sqlstr);
		
		$count = $GLOBALS['ISC_CLASS_DB']->CountResult($result);
		
		if( $count < 1 ) 
		{
			$output = "<li>No options available</li>";
		}
		else
		{	
			$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
			
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
			file_put_contents($this->cache_folder.'/column=year_year=_make=_model=.php', $output);
			chmod($this->cache_folder.'/column=year_year=_make=_model=.php', 0777);
			//echo "year cache created.\n\n";
			return 1;
		}
		catch (Exception $e)
		{
			//echo 'Message: '.$this->cache_folder.'/column=year_year=_make=_model=.php: '.$e->getMessage();
			return 0;
		}	
	}

	function create_make_cache()
	{
		$sqlstr = "SELECT DISTINCT `prodmake` FROM `isc_import_variations` iv
					LEFT JOIN isc_products p ON iv.`productid` = p.productid
					WHERE p.prodvisible = '1' and iv.`prodstartyear` <> 'all' AND iv.`prodendyear` <> 'all' 
					order by prodmake asc ";
					
		$result = $GLOBALS['ISC_CLASS_DB']->Query($sqlstr);
		
		$count = $GLOBALS['ISC_CLASS_DB']->CountResult($result);
		
		$this->make_array = array('CHEVROLET', 'GMC', 'FORD', 'DODGE', 'TOYOTA', 'NISSAN', 'HONDA', 'JEEP', 'HYUNDAI','CHRYSLER', 'INFINITI', 'LEXUS');
		
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
			
			while( $row = $GLOBALS['ISC_CLASS_DB']->Fetch($result) )
			{
				if( strtoupper($row['prodmake']) === 'NON-SPEC VEHICLE' )
					continue;
				if( in_array($row['prodmake'], $make_array) )
					continue;
				$this->make_array[] = $row['prodmake'];
				
				$extra_val .= "<li><a href='".$GLOBALS['ISC_CFG']['ShopPath']."/make/".str_replace(' ', '-', $row['prodmake'])."' >".$row['prodmake']."</a></li>";
			}
			$output .= '<ul>'.$list_val."</ul><ul id='extra_make' class='hidelist'>".$extra_val."</ul>";
			if( isset($extra_val) )
				$output .= "<ul class='more'><li><a href=\"javascript:onclick=show_hide('make')\" id='make_more'>More...</a></li></ul>";
		}
		
		try
		{
			file_put_contents($this->cache_folder.'/column=make_year=_make=_model=.php', $output);
			chmod($this->cache_folder.'/column=make_year=_make=_model=.php', 0777);
			//echo "make cache created.\n\n";	
			return 1;
		}
		catch (Exception $e)
		{
			//echo 'Message: '.$cache_folder.'/column=make_year=_make=_model=.php: '.$e->getMessage();
			return 0;
		}
	}
	
	function get_all_make()
	{
		$sqlstr = "SELECT DISTINCT `prodmake` FROM `isc_import_variations` iv
					LEFT JOIN isc_products p ON iv.`productid` = p.productid
					WHERE p.prodvisible = '1' and iv.`prodstartyear` <> 'all' AND iv.`prodendyear` <> 'all' ";
		
		$result = $GLOBALS['ISC_CLASS_DB']->Query($sqlstr);
		
		$count = $GLOBALS['ISC_CLASS_DB']->CountResult($result);
		
		$this->make_array = array();
		
		while( $row = $GLOBALS['ISC_CLASS_DB']->Fetch($result) )
		{
			if( strtoupper($row['prodmake']) === 'NON-SPEC VEHICLE' )
				continue;
			$this->make_array[] = $row['prodmake'];
		}
	}

	function create_make_year_cache()
	{
		foreach($this->make_array as $make)
		{
			if( strtoupper($make) === 'NON-SPEC VEHICLE' )
				continue;
			$sqlstr = "SELECT min( iv.`prodstartyear` ) AS start , max( iv.`prodendyear` ) AS end FROM `isc_import_variations` iv
						LEFT JOIN isc_products p ON iv.`productid` = p.productid
						WHERE p.prodvisible = '1' and iv.`prodmake` =  '$make' and `prodstartyear` <> 'all' AND `prodendyear` <> 'all'  and `prodstartyear` <> '' AND `prodendyear` <> ''  and `prodstartyear` is not null AND `prodendyear` is not null  ";
			
			$result = $GLOBALS['ISC_CLASS_DB']->Query($sqlstr);
		
			$count = $GLOBALS['ISC_CLASS_DB']->CountResult($result);
			
			if( $count < 1 ) 
			{
				$output = "<li>No options available</li>";
			}
			else
			{	
				$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
			
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
					$this->create_make_year_model_cache($make, $value);
					//echo $make.' '.$value;
				}
				
				$output .= '<ul>'.$list_val."</ul><ul id='extra_year' class='hidelist'>".$extra_val."</ul>";
				if( isset($extra_val) )
					$output .= "<ul class='more'><li><a href=\"javascript:onclick=show_hide('year')\" id='year_more'>More...</a></li></ul>";
			}
			
			try
			{
				file_put_contents($this->cache_folder."/column=year_year=_make=".str_replace(' ', '_', $make)."_model=.php", $output);
				chmod($this->cache_folder."/column=year_year=_make=".str_replace(' ', '_', $make)."_model=.php", 0777);
				//echo "make year cache created.\n\n";	
				return 1;
			}
			catch (Exception $e)
			{
				//echo 'Message: '.$cache_folder."/column=year_year=_make=".$make."_model=.php".': '.$e->getMessage();
				return 0;
			}
		}
	}

	function create_make_year_model_cache($make, $year)
	{
		
		$sqlstr = "SELECT DISTINCT iv.`prodmodel` 
			FROM `isc_import_variations` iv
			LEFT JOIN isc_products p ON iv.`productid` = p.productid
			WHERE p.prodvisible = '1' and iv.`prodmake` = '$make' AND $year >= iv.`prodstartyear` AND $year <= iv.`prodendyear` ORDER BY iv.`prodmodel` ASC";
		 
		$result = $GLOBALS['ISC_CLASS_DB']->Query($sqlstr);
		
		$count = $GLOBALS['ISC_CLASS_DB']->CountResult($result);
		
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
			
			while( $row = $GLOBALS['ISC_CLASS_DB']->Fetch($result) )
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
			file_put_contents($this->cache_folder."/column=model_year=".$year."_make=".str_replace(' ', '_', $make)."_model=.php", $output);
			chmod($this->cache_folder."/column=model_year=".$year."_make=".str_replace(' ', '_', $make)."_model=.php", 0777);
			//echo "make year model cache created.\n\n";
			return 1;
		}
		catch (Exception $e)
		{
			//echo 'Message: '.$cache_folder."/column=model_year=".$year."_make=".$make."_model=.php".': '.$e->getMessage();
			return 0;
		}
	}

	function create_make_model_cache()
	{
		foreach($this->make_array as $make)
		{
			if( strtoupper($make) === 'NON-SPEC VEHICLE' )
				continue;
			$sqlstr = "SELECT DISTINCT iv.`prodmodel` FROM `isc_import_variations` iv
						LEFT JOIN isc_products p ON iv.`productid` = p.productid
						WHERE p.prodvisible = '1' and iv.`prodmake` = '$make' ORDER BY iv.`prodmodel` ASC ";
			
			$result = $GLOBALS['ISC_CLASS_DB']->Query($sqlstr);
		
			$count = $GLOBALS['ISC_CLASS_DB']->CountResult($result);
			
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
				
				while( $row = $GLOBALS['ISC_CLASS_DB']->Fetch($result) )
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
					$this->create_make_model_year_cache($make, $row['prodmodel']);
					//echo $make.' '.$row['prodmodel'];
				}
				
				$output .= '<ul>'.$list_val."</ul><ul id='extra_model' class='hidelist'>".$extra_val."</ul>";
				if( isset($extra_val) )
					$output .= "<ul class='more'><li><a href=\"javascript:onclick=show_hide('model')\" id='model_more'>More...</a></li></ul>";		
			}
			
			try
			{
				file_put_contents($this->cache_folder."/column=model_year=_make=".str_replace(' ', '_', $make)."_model=.php", $output);
				chmod($this->cache_folder."/column=model_year=_make=".str_replace(' ', '_', $make)."_model=.php", 0777);
				//echo "make model cache created.\n\n";
				return 1;
			}
			catch (Exception $e)
			{
				//echo 'Message: '.$this->cache_folder."/column=model_year=_make=".$make."_model=.php".': '.$e->getMessage();
				return 0;
			}
		}
	}

	function create_make_model_year_cache($make, $model)
	{		
		$sqlstr = "SELECT MIN(iv.`prodstartyear`) as start, MAX(iv.`prodendyear`) end FROM `isc_import_variations` iv
				LEFT JOIN isc_products p ON iv.`productid` = p.productid
				WHERE p.prodvisible = '1' and iv.`prodmake` = '$make' AND iv.`prodmodel` = '$model' and `prodstartyear` <> 'all' AND `prodendyear` <> 'all'  and `prodstartyear` <> '' AND `prodendyear` <> ''  and `prodstartyear` is not null AND `prodendyear` is not null  ";
	
		$result = $GLOBALS['ISC_CLASS_DB']->Query($sqlstr);
		
		$count = $GLOBALS['ISC_CLASS_DB']->CountResult($result);
		
		unset($output);
		
		if( $count < 1 ) 
		{
			$output = "<li>No options available</li>";
		}
		else
		{
			$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
			
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
			file_put_contents($this->cache_folder."/column=year_year=_make=".str_replace(' ', '_', $make)."_model=".str_replace('/', '_', str_replace(' ', '_', $model)).".php", $output);
			chmod($this->cache_folder."/column=year_year=_make=".str_replace(' ', '_', $make)."_model=".str_replace('/', '_', str_replace(' ', '_', $model)).".php", 0777);
			//echo "make model year cache created.\n\n";
			return 1;
		}
		catch (Exception $e)
		{
			//echo "Message: ".$this->cache_folder."/column=year_year=_make=".$make."_model=".$model.".php: ".$e->getMessage();
			return 0;
		}
	}

	function get_product_data($ids)
	{
		if( is_array($ids) )
			$product_ids = implode("','", array_map('intval', $ids));
		else
			$product_ids = $ids;
		
		$query = sprintf("SELECT distinct p.`prodmodel`, p.`prodmake`, p.`prodstartyear`, p.`prodendyear`, 
				(select MIN(t.`prodstartyear`) from isc_import_variations t where t.`prodmake` = p.`prodmake`) as make_start_year, 
				(select MAX(t.`prodendyear`) from isc_import_variations t where t.`prodmake` = p.`prodmake`) as make_end_year,
				(select MIN(t.`prodstartyear`) from isc_import_variations t where t.`prodmodel` = p.`prodmodel`) as model_start_year, 
				(select MAX(t.`prodendyear`) from isc_import_variations t where t.`prodmodel` = p.`prodmodel`) as model_end_year,
				(select count(t.`prodmake`) from isc_import_variations t where t.`prodmake` = p.`prodmake`) as make_count,
				(select count(t.`prodmodel`) from isc_import_variations t where t.`prodmodel` = p.`prodmodel`) as model_count
				FROM isc_import_variations p
				WHERE `productid` in ('%s')", $product_ids);
		
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);	
		
		$this->product_result = array();
		
		while( $row = $GLOBALS['ISC_CLASS_DB']->Fetch($result) )
		{
			$this->product_result[] = $row;
		}
	}
	
	function update_product_ymm_cache()
	{
		foreach( $this->product_result as $row )
		{			
			if( $row["make_count"] <= 1 )
			{
				//initial all cache file
				$this->create_all_cache_file();
			}
			else
			{
				if( $row["prodstartyear"] <= $row["make_start_year"] || $row["prodendyear"] >= $row["make_end_year"] )
				{
					//initial all make_year related cache
					$this->make_array = array();
					$this->make_array[] = $row["prodmake"];
					$this->create_make_year_cache();
				}
				else
				{
					if( $row["model_count"] <= 1 )
					{
						//initial all model related cache
						$this->make_array = array();
						$this->make_array[] = $row["prodmake"];
						$this->create_make_model_cache();
					}
					else
					{
						if( $row["prodstartyear"] <= $row["model_start_year"] || $row["prodendyear"] >= $row["model_end_year"] )
						{
							//initial all model year cache
							$this->create_make_model_year_cache($row["prodmake"], $row["prodmodel"]);
						}
					}
				}
			}
		}
		
		return 1;
	}		
	
	function create_all_cache_file()
	{
		$this->create_year_cache();
		$this->create_make_cache();
		$this->create_make_year_cache();
		$this->create_make_model_cache();
	}
}
?>

