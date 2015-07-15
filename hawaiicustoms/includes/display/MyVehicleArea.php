<?php 
     
	CLASS ISC_MYVEHICLEAREA_PANEL extends PANEL
	{
		var $cacheable = true;
		var $cacheId = "";
    private $productImpVariations = array();

    function SetPanelSettings()
		{
			$path = GetConfig('ShopPath');
			
			$output = "";
			$GLOBALS['SITEPATH'] = $path;
			$GLOBALS['ProductMMYHeader1'] = "Make";
			$GLOBALS['ProductMMYHeader2'] = "Model";
			$GLOBALS['ProductMMYHeader'] = "Year";

			$model_srch_param = "search_query=";
			$year_srch_param = "search_query=";  // Here this was applied earlier "search_query=&year=&column=year"
			$make_srch_param = "search_query=";
			$GLOBALS['mousedefaultpointer'] = "mousedefaultpointer";
			$GLOBALS['ModelJS'] = "";

			$GLOBALS['FLAGCLEARANCE'] = 0;
			
			//wirror_20101124: show the ymm options by searching condition
			$GLOBALS['ISC_CLASS_NEWSEARCH'] = GetClass('ISC_NEWSEARCH');
			$params = $GLOBALS['ISC_CLASS_NEWSEARCH']-> _searchterms;
			
			if(!empty($_COOKIE['last_search_selection']['year']))
				$params['year'] = $_COOKIE['last_search_selection']['year'];
			if(!empty($_COOKIE['last_search_selection']['make']))
				$params['make'] = $_COOKIE['last_search_selection']['make'];
			if(!empty($_COOKIE['last_search_selection']['model']))
				$params['model'] = $_COOKIE['last_search_selection']['model'];
      
      if ($GLOBALS['ProductIds']) {
          $this->productImpVariations = ISC_PRODUCT::GetImpVariationForYMM($GLOBALS['ProductIds'], '', $params['year'], $params['make'], $params['model']);
      }
				
			//if(isset($GLOBALS['ISC_CLASS_CLEARANCE']))
			{
				//$GLOBALS['FLAGCLEARANCE'] = 2;
				//$params = array();
				// johnny change '$i=1' to '$i=0'
				for($i=0;$i<count($GLOBALS['PathInfo']);$i+=2)
				{
					if($GLOBALS['PathInfo'][$i+1] != '')
						$params[$GLOBALS['PathInfo'][$i]] = MakeURLNormal($GLOBALS['PathInfo'][$i+1]);
				}

				if(isset($params['make']))
				{
					$_COOKIE['last_search_selection']['make'] = $params['make'];

					if(isset($params['model']))
					{
						$_COOKIE['last_search_selection']['model'] = $params['model'];
					}
				}
				if(isset($params['year']))
				{
					$_COOKIE['last_search_selection']['year'] = $params['year'];
				}
				$GLOBALS['REMOVEURL'] = $GLOBALS['ShopPath']."/clearance/";
			}
			$this->YMMSelectors($params);
			$GLOBALS['REMOVEURL'] = $this->GetRemoveUrl();
			
			if(!empty($_COOKIE['last_search_selection']['year']) || !empty($params['year'])) {
				$GLOBALS['YearName'] = empty($_COOKIE['last_search_selection']['year']) ? $params['year'] : $_COOKIE['last_search_selection']['year'];
				$model_srch_param .= "&year=".$GLOBALS['YearName'];
				$make_srch_param .= "&year=".$GLOBALS['YearName'];
			}
			
			if(!empty($_COOKIE['last_search_selection']['make']) || !empty($params['make']))  {
				$GLOBALS['MakeName'] = strtoupper(empty($_COOKIE['last_search_selection']['make']) ? $params['make'] : $_COOKIE['last_search_selection']['make']);
				$year_srch_param .= "&make=".MakeURLSafe(strtolower($GLOBALS['MakeName']));
				$model_srch_param .= "&make=".MakeURLSafe(strtolower($GLOBALS['MakeName']));

				$make_srch_param .= "&make=&column=make";
				if(isset($GLOBALS['ISC_CLASS_CLEARANCE']))
				{
					$make_srch_param .= "&clearance=1";
				}
				$make_srch_param .= "&getymms=1";
				$GLOBALS['MakeJS'] = "getvalueswithajax('prod_make','$make_srch_param');";

				$model_srch_param .= "&column=model";
				if(isset($GLOBALS['ISC_CLASS_CLEARANCE']))
				{
					$model_srch_param .= "&clearance=1";
				}
				$model_srch_param .= "&getymms=1";
				$GLOBALS['ModelJS'] .= "getvalueswithajax('prod_model','$model_srch_param');checkanimate('prod_model')";
				$GLOBAL['mousedefaultpointer'] = "";
				if(!empty($_COOKIE['last_search_selection']['model']) || !empty($params['model'])) {
					$GLOBALS['ModelName'] = strtoupper(empty($_COOKIE['last_search_selection']['model']) ? $params['model'] : $_COOKIE['last_search_selection']['model']);
					$year_srch_param .= "&model=".MakeURLSafe(strtolower($GLOBALS['ModelName']));
				}
			} else {
				$make_srch_param .= "&make=&column=make";
				if(isset($GLOBALS['ISC_CLASS_CLEARANCE']))
				{
					$make_srch_param .= "&clearance=1";
				}
				$make_srch_param .= "&getymms=1";
				$GLOBALS['MakeJS'] = "getvalueswithajax('prod_make','$make_srch_param');";
			}

			$year_srch_param .= "&column=year";
			if(isset($GLOBALS['ISC_CLASS_CLEARANCE']))
			{
				$year_srch_param .= "&clearance=1";
			}
			$year_srch_param .= "&getymms=1";
			$GLOBALS['YearJS'] = "getvalueswithajax('prod_year','$year_srch_param');";
            
			$GLOBALS['Dynimage'] = "imgHdrDropDownIconright.gif"; 
			//$GLOBALS['dynid'] = "prod_year";
			$GLOBALS['id'] = "prod_year";
			$GLOBALS['yearid'] = "mmy_year";
			$GLOBALS['DynFilterArrow'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideProductFilterImage");
			//$GLOBALS['dynid'] = "prod_make";
			$GLOBALS['id1'] = "prod_make";
			$GLOBALS['makeid'] = "mmy_make";
			$GLOBALS['DynFilterArrow1'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideProductFilterImage");
			//$GLOBALS['dynid'] = "prod_model";
			$GLOBALS['id2'] = "prod_model";
			$GLOBALS['modelid'] = "mmy_model";
			$GLOBALS['DynFilterArrow2'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideProductFilterImage");
            
			$GLOBALS['ProductMMY'] = $output;
			$output .= "Results Fit Your Vehicle, Guaranteed !";
			
			/*$changeYMM = false;
			if(isset($_COOKIE["last_search_selection"]) && isset($_COOKIE["last_search_selection"]["changeymm"]) && $_COOKIE["last_search_selection"]["changeymm"] == 1)
			{
				$changeYMM = true;
			}
			
			if(isset($GLOBALS["HasSetYMM"]) && $GLOBALS["HasSetYMM"] == true)
			{
				$changeYMM = true;
			}
			if(!$changeYMM)
			{
				//wirror_20101124: modify the clear words
				if((isset($GLOBALS['YearName']) || isset($GLOBALS['MakeName'])) && !isset($GLOBALS['MyVehicleArea'])) {
					$GLOBALS['DeleteCookie'] = "<ul id='modifyvehicle'><li><a href='javascript:deleteMMYcookies()'>Change My Vehicle</a></li></ul>";
				}
			}*/

			if(!$output) {
				$this->DontDisplay = true;
				return;
			}

			$GLOBALS['SNIPPETS']['MyVehicleArea'] = $output;
		}
		
		function getYMMOptions($params,$ymm_type)
		{
      switch($ymm_type)
			{
				case 'year': 	
					$options = "<option value=''>--select year--</option>";
					$filter_array = array();
			//$ymm_qry = "select group_concat(v.prodstartyear separator '~') as prodstartyear , group_concat(v.prodendyear separator '~') as prodendyear from [|PREFIX|]products p LEFT JOIN [|PREFIX|]import_variations AS v ON v.productid = p.productid where p.prodvisible='1' ";
				$ymm_qry = " select min(v.prodstartyear) as prodstartyear , max(v.prodendyear)  as prodendyear from isc_products p LEFT JOIN isc_import_variations AS v ON v.productid = p.productid where p.prodvisible='1' and v.prodstartyear is not null and v.prodstartyear !='' and v.prodstartyear !='all'  and v.prodendyear is not null and v.prodendyear !='' and v.prodendyear !='all'  ";
				if( isset($params['make']) && $GLOBALS['UniversalCat'] == 0 )
				$ymm_qry .= " and prodmake = '".$params['make']."' ";
				if( isset($params['model']) && (!isset($params['model_flag']) || $params['model_flag'] == 1) && $GLOBALS['UniversalCat'] == 0 )
				$ymm_qry .= " and prodmodel = '".$params['model']."' ";

				//$ymm_qry .= " group by p.productid ";
				$ymm_res = $GLOBALS['ISC_CLASS_DB']->Query($ymm_qry);
				if($ymm_row = $GLOBALS['ISC_CLASS_DB']->Fetch($ymm_res))
				{
					if(empty($ymm_row["prodstartyear"]) || !isnumeric($ymm_row["prodstartyear"]))
					{
						$startyear = 1950;
					}
					if(empty($ymm_row["prodendyear"]) || !isnumeric($ymm_row["prodendyear"]))
					{
						$endyear= date('Y');
					}
					$startyear = $ymm_row["prodstartyear"];
					$endyear = $ymm_row["prodendyear"];
					//2011-1-20 Ronnie add,year range 1900~2050
					$YMMMinYear=1900;
					$YMMMaxYear=2050;
					if($startyear<$YMMMinYear){
						$startyear=$YMMMinYear;
					}
					if($startyear>$YMMMaxYear){
						$startyear=$YMMMaxYear;
					}
					if($endyear<$YMMMinYear){
						$endyear=$YMMMinYear;
					}
					if($endyear>$YMMMaxYear){
						$endyear=$YMMMaxYear;
					}
					//$endyear=$YMMMaxYear;
					for($i=$startyear;$i<=$endyear;$i++)
					{
						if(!in_array($i,$filter_array)) {
							$filter_array[] = $i;
						} 
					}
					
					/*$grp_startyear = explode("~",$ymm_row['prodstartyear']);
					$grp_endyear = explode("~",$ymm_row['prodendyear']);
					for($g=0;$g<count($grp_startyear);$g++)
					{
						$prod_start_year = $grp_startyear[$g];
						$prod_end_year = $grp_endyear[$g];

						if(is_numeric($prod_start_year) && is_numeric($prod_end_year))
						{
							$prod_year_diff = $prod_end_year - $prod_start_year;
							for($i=0;$i<=$prod_year_diff;$i++)
							{
								$actual_year = $prod_start_year + $i;
								if(in_array($actual_year,$filter_array)) {
									$count_filter_array[$actual_year]++;
								}  else {
									$filter_array[] = $actual_year;
									$count_filter_array[$actual_year] = 1;
								}
							}
						}
					}*/
				}
					rsort($filter_array);
					foreach($filter_array as $key => $value)
					{
						$selected = "";
						if ( isset($params['year']) && strcasecmp($params['year'], $value) == 0 )
							$selected = " selected";
            if (!empty($this->productImpVariations) && !ISC_PRODUCT::CheckYMMUseVariation($value, $this->productImpVariations, 'year'))
                continue;
            
						$options .= "<option value='".MakeURLSafe(strtolower($value))."'$selected>$value</option>";
					}
					break;
				case 'make': 
					$filter_array = array();
					$GLOBALS['ISC_YMMS'] = GetClass('ISC_YMMS');
    				$result = $GLOBALS['ISC_YMMS']->getResultArray("make","","","");
    				$options = "<option value=''>--select make--</option>";
					
					//$ymm_qry = "select group_concat(DISTINCT v.prodmake separator '~') as prodmake from [|PREFIX|]products p LEFT JOIN [|PREFIX|]import_variations AS v ON v.productid = p.productid where p.prodvisible='1' ";
					//$ymm_qry = "select DISTINCT v.prodmake  as prodmake from [|PREFIX|]products p LEFT JOIN [|PREFIX|]import_variations AS v ON v.productid = p.productid where p.prodvisible='1' ";
					//$ymm_res = $GLOBALS['ISC_CLASS_DB']->Query($ymm_qry);
					//while($ymm_row = $GLOBALS['ISC_CLASS_DB']->Fetch($ymm_res))
					//{
						/*$filters = explode('~',$ymm_row['prodmake']);
						for($j=0;$j<count($filters);$j++) 
					    {
							$filter_value = $filters[$j]; 
							if(strtoupper($filter_value) != "NON-SPEC VEHICLE" && strtolower($filter_value) != "all" && $filter_value != "")
							{
								if(in_array($filter_value,$filter_array))   {
									$count_filter_array[$filter_value]++;
								} else {
									$filter_array[] = $filter_value;
									$count_filter_array[$filter_value] = 1;
								}
							}
					    }*/
						//if(strtoupper($ymm_row['prodmake']) != "NON-SPEC VEHICLE" && strtolower($ymm_row['prodmake']) != "all" && $ymm_row['prodmake'] != "")
						//{
						//	$filter_array[] = $ymm_row['prodmake'];
						//}
					//}
					
					foreach ($result as $key => $value)
					{
						if(strtoupper($value) != "NON-SPEC VEHICLE" && strtolower($value) != "all" && $value != "")
						{
							$filter_array[] = $value;
						}
					}
						
					sort($filter_array);
					$all_makes = array('CHEVROLET', 'GMC', 'FORD', 'DODGE', 'TOYOTA', 'NISSAN', 'HONDA', 'JEEP', 'HYUNDAI','CHRYSLER', 'INFINITI', 'LEXUS');
					//$temp_arr =  array_diff($filter_array,$all_makes);	// commented as client told to include the above makes in other list also
					$temp_arr =  $filter_array;
					//alandy_2011-10-13 modify.
					array_unique($temp_arr);					
					if (!$GLOBALS['ProductIds']) {
                      foreach($all_makes as $key => $value) 
                      {
                        $selected = "";
                        if (!empty($this->productImpVariations) && !ISC_PRODUCT::CheckYMMUseVariation($value, $this->productImpVariations, 'make'))
                            continue;
                        if ( isset($params['make']) && strcasecmp($params['make'], $value) == 0 )
                          $selected = " selected";		

                        $options .= "<option value='".MakeURLSafe(strtolower($value))."'$selected>$value</option>"; 
                      }

                      $options .= "<option value=''>------------</option>"; 
                  }

					foreach($temp_arr as $key => $value ) 
					{
						$selected = "";
            if (!empty($this->productImpVariations) && !ISC_PRODUCT::CheckYMMUseVariation($value, $this->productImpVariations, 'make'))
                continue;
						if ( isset($params['make']) && strcasecmp($params['make'], $value) == 0 )
							$selected = " selected";		

						$options .= "<option value='".MakeURLSafe(strtolower($value))."'$selected>$value</option>";
					}
					break;
				case 'model': 
					$options = "<option value=''>--select model--</option>";
					if(isset($params['make']))
					{	
						$filter_array = array();
						$ymm_qry = "select distinct prodmodel from [|PREFIX|]products p LEFT JOIN [|PREFIX|]import_variations AS v ON v.productid = p.productid where p.prodvisible='1' ";
						if( isset($params['make']) )
							$ymm_qry .= " and prodmake = '".$params['make']."' ";
						if( isset($params['year']) && $GLOBALS['UniversalCat'] == 0 )
							$ymm_qry .= " and ".$params['year']." between prodstartyear and prodendyear ";

						//$ymm_qry .= " group by p.productid ";	
						$ymm_res = $GLOBALS['ISC_CLASS_DB']->Query($ymm_qry);
						while($ymm_row = $GLOBALS['ISC_CLASS_DB']->Fetch($ymm_res))
						{
							if(!empty($ymm_row['prodmodel']) && $ymm_row['prodmodel'] != '~') {
							   $filters = explode('~',$ymm_row['prodmodel']);
							   for($j=0;$j<count($filters);$j++) 
							   {
									$filter_value = ucwords(strtolower($filters[$j]));
									if(strtolower($filter_value) != "all")
									{
										if(in_array($filter_value,$filter_array))   {
										} else {
											$filter_array[] = $filter_value;
										}
									}
							   }
							}
						}
						sort($filter_array);
						foreach($filter_array as $key => $value)
						{
							$selected = "";
							if ( isset($params['model']) && strcasecmp($params['model'], $value) == 0 )
								$selected = " selected";
              
              if (!empty($this->productImpVariations) && !ISC_PRODUCT::CheckYMMUseVariation($value, $this->productImpVariations, 'model'))
                continue;
              
							$options .= "<option value='".MakeURLSafe(strtolower($value))."'$selected>$value</option>";
						}
					}
					break;
			}

			return $options;

		}

		function YMMSelectors($params)
		{
			
			if( isset($params['model']) && !isset($params['make']) )
			{
				unset($params['model']);
			}

			$GLOBALS['UniversalCat'] =      isset($params['catuniversal']) ? $params['catuniversal'] : 0;
			
			$changeYMM = false;
			if(isset($_COOKIE["last_search_selection"]) && isset($_COOKIE["last_search_selection"]["changeymm"]) && $_COOKIE["last_search_selection"]["changeymm"] == 1)
			{
				$changeYMM = true;
			}
			
			$setYmm = false;
			if(isset($_COOKIE["last_search_selection"]) && isset($_COOKIE["last_search_selection"]["setymm"]) && $_COOKIE["last_search_selection"]["setymm"] == 1)
			{
				$setYmm = true;
			}
			
			if($setYmm)
			{
				$changeYMM = false;
				$number_of_days = -1 ;
				$date_of_expiry = time() + 60 * 60 * 24 * $number_of_days ;
				setcookie( "last_search_selection[changeymm]", 0, $date_of_expiry ,"/" );
				setcookie( "last_search_selection[setymm]", 0, $date_of_expiry ,"/" );
				
				$GLOBALS["HasSetYMM"] = true;
			}
			//
			//if($changeYMM ||(!isset($params['year']) && !isset($params['make']) && !isset($params['model']))){
			if(!isset($params['year']) && !isset($params['make']) && !isset($params['model'])){
				$GLOBALS['YearOption']	 =	'<select name="searchyear" id="searchyear_left" onchange="getYmmOptions(\'year\','.$GLOBALS['UniversalCat'].')">'.$this->getYMMOptions($params,'year').'</select>';
				$GLOBALS['MakeOption']	 =	'<select name="searchmake" id="searchmake_left" onchange="getYmmOptions(\'make\','.$GLOBALS['UniversalCat'].')">'.$this->getYMMOptions($params,'make').'</select>';
				$GLOBALS['ModelOption']	 =	'<select name="searchmodel" id="searchmodel_left" onchange="getYmmOptions(\'model\','.$GLOBALS['UniversalCat'].')">'.$this->getYMMOptions($params,'model').'</select>';
				$GLOBALS['YmmButtons']	 =      '<p id="fit">Guaranteed to Fit Your Vehicle!</p><input name="setvehicle" type="image" onclick="setLeftYMM()" value="Set Vehicle" src="/images/left-menu-tc/button-set-vehicle.gif" alt="Submit button" />';
				if(isset($GLOBALS['MyVehicleArea']))
					$GLOBALS['YmmButtons']  .= $GLOBALS['MyVehicleArea'];
			}else{				
				
				$GLOBALS['SelectedOption']=     isset($params['year']) ? $params['year'] : 'Select Year';
				if(isset($params['year']))
				{
					$GLOBALS["HiddenControlId"]="hidden_left_year";
					$GLOBALS["HiddenControlValue"]=isset($params['year']) ? MakeURLSafe(strtolower($params['year'])): '';
					$GLOBALS['YearOption']	  =	$GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("MyVehicleAreaYmmOption");
				}
				else 
				{
					$GLOBALS['YearOption']	 =	'<select name="searchyear" id="searchyear_left" onchange="getYmmOptions(\'year\','.$GLOBALS['UniversalCat'].')">'.$this->getYMMOptions($params,'year').'</select>';
				}
				$GLOBALS['SelectedOption']=   isset($params['make']) ? strtoupper($params['make']) : 'Select Make';
				if(isset($params['make']))
				{
					$GLOBALS["HiddenControlId"]="hidden_left_make";
					$GLOBALS["HiddenControlValue"]=isset($params['make']) ? MakeURLSafe(strtolower($params['make'])) : '';
					$GLOBALS['MakeOption']	  =	$GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("MyVehicleAreaYmmOption");
				}
				else 
				{
					$GLOBALS['MakeOption']	 =	'<select name="searchmake" id="searchmake_left" onchange="getYmmOptions(\'make\','.$GLOBALS['UniversalCat'].')">'.$this->getYMMOptions($params,'make').'</select>';
				}
				$GLOBALS['SelectedOption']=     isset($params['model']) ? strtoupper($params['model']) : 'Select Model';
				if(isset($params['model']))
				{
					$GLOBALS["HiddenControlId"]="hidden_left_model";
					$GLOBALS["HiddenControlValue"]=isset($params['model']) ? MakeURLSafe(strtolower($params['model'])) : '';
					$GLOBALS['ModelOption']	  =     $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("MyVehicleAreaYmmOption");
				}
				else 
				{
					$GLOBALS['ModelOption']	 =	'<select name="searchmodel" id="searchmodel_left" onchange="getYmmOptions(\'model\','.$GLOBALS['UniversalCat'].')">'.$this->getYMMOptions($params,'model').'</select>';
				}
					
				$GLOBALS['YmmButtons'] = "<ul id='modifyvehicle'><li><a href='javascript:deleteMMYcookies()'>Clear My Vehicle</a></li></ul>";
					if(isset($GLOBALS['MyVehicleArea']))
					$GLOBALS['YmmButtons'] .= $GLOBALS['MyVehicleArea'];	
			}
			
		}
		
		//GetRemoveUrl
		function GetRemoveUrl(){
			$url = $GLOBALS['ShopPath'];
			$reqUri = $_SERVER['REQUEST_URI'];
			$reqUri = preg_replace('@/(year|make|model)/[^/]*@i', '', $reqUri);
			
			return $url.$reqUri;
		}
        
	}  
?>