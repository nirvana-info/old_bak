<?php

/**
 * *********  Revise History  ********
 * lguan_20100513: If user access product detail page by URL directly, there will be no search terms in session, this time, the query perforamnce
 * 				at side bar for brand will be very bad, since all products will be retreived. Changed the codes to append category id retrieved
 * 				from product to limit the scope, also make sure the "Other Brand" label will be available.
 * 
 * 
 */
 
CLASS ISC_ABSIDEPRODUCTFILTERS_PANEL extends PANEL
{
	var $cacheable = true;
	var $cacheId = "";
	public $searchterms;
    public $path;
	public $subcatgid;
    
    public function __construct()
    {
        //Modify 2010/10/19 Ronnie
        //$this->path = GetConfig('ShopPath')."/a-b-testing"; 
        $this->path = GetConfig('ShopPath'); 
        
        if(isset($GLOBALS['ISC_CLASS_ABTESTING'])) {
            //$GLOBALS['ISC_CLASS_ABTESTING'] = GetClass('ISC_SEARCH');
            $this->searchterms = $GLOBALS['ISC_CLASS_ABTESTING']-> _searchterms;

			/* Checking the search string. If it is used in any search, will be retained. else it will not be retained */
			if( isset($this->searchterms['search']) )
			{
				$search_str	=	trim(str_ireplace($this->searchterms['search_string'] ,"", $this->searchterms['search']));
				if($search_str == '')
				{
					unset($this->searchterms['search']);
				}
				else
				{
					$this->searchterms['search'] = $search_str;
				}
			}

            $_SESSION['absearchterms'] = $this->searchterms; // this variable is used to get the search terms in other pages

			if(isset($this->searchterms['subcategory'])) // this is assigned to get the sub catg value in other pages
			{
				$_SESSION['absearchterms']['subcategory'] = $this->searchterms['subcategory'];
				$sub_catg_qry = "select categoryid , catname from isc_categories where catname = '".$this->searchterms['subcategory']."'";
				$sub_catg_res = $GLOBALS['ISC_CLASS_DB']->Query($sub_catg_qry);
				$sub_catg_arr = $GLOBALS['ISC_CLASS_DB']->Fetch($sub_catg_res);
				$this->subcatgid = $sub_catg_arr['categoryid'];

			}
			else {
			unset($_SESSION['absearchterms']['subcategory']);
			}

			if(isset($params['series'])) // this is assigned to get the brand series value in other pages
			$_SESSION['absearchterms']['series'] = $params['series'];
			else
			unset($_SESSION['absearchterms']['series']);
            
            if(isset($GLOBALS['v_cols']))
            $_SESSION['v_cols'] =  $GLOBALS['v_cols'];
            else
            unset($_SESSION['v_cols']);
            
            if(isset($GLOBALS['p_cols']))
            $_SESSION['p_cols'] = $GLOBALS['p_cols'];
            else
            unset($_SESSION['p_cols']);

			if(isset($GLOBALS['visible_pqvq']))
			$_SESSION['visible_pqvq'] = $GLOBALS['visible_pqvq'];
			else
            unset($_SESSION['visible_pqvq']);
            
            if(isset($GLOBALS['ISC_SRCH_CATG_NAME']))
            $_SESSION['catg_name'] = $GLOBALS['ISC_SRCH_CATG_NAME'];
            else
            unset($_SESSION['catg_name']);
            //$GLOBALS['ISC_CLASS_ABTESTING']->HandlePage();
        } else if(isset($_SESSION['absearchterms'])) {

			if(!isset($_SESSION['absearchterms']['dynfilters']))
				$_SESSION['absearchterms']['dynfilters'] = array();

			if(!isset($_COOKIE['last_search_selection']['make']))
			{
				unset($_SESSION['absearchterms']['make'],$_SESSION['absearchterms']['model']);
			}

			if(!isset($_COOKIE['last_search_selection']['year']))
			{
				unset($_SESSION['absearchterms']['year']);
			}

            $this->searchterms = $_SESSION['absearchterms'];
            $GLOBALS['v_cols'] = isset($_SESSION['v_cols']) ? $_SESSION['v_cols'] : array();
            $GLOBALS['p_cols'] = isset($_SESSION['p_cols']) ? $_SESSION['p_cols'] : array();
			$GLOBALS['visible_pqvq'] = isset($_SESSION['visible_pqvq']) ? $_SESSION['visible_pqvq'] : array();
            
            if(isset($_SESSION['catg_name']))
                $GLOBALS['ISC_SRCH_CATG_NAME'] = $_SESSION['catg_name'];
            
            if(isset($this->searchterms['srch_category']))
                $GLOBALS['ISC_SRCH_CATG_ID'] = $this->searchterms['srch_category'][0];

			if(isset($_SESSION['absearchterms']['subcategory'])) {
				$_GET['subcategory'] = $_REQUEST['subcategory'] = $_SESSION['absearchterms']['subcategory'];
				$sub_catg_qry = "select categoryid , catname from isc_categories where catname = '".$_SESSION['absearchterms']['subcategory']."'";
				$sub_catg_res = $GLOBALS['ISC_CLASS_DB']->Query($sub_catg_qry);
				$sub_catg_arr = $GLOBALS['ISC_CLASS_DB']->Fetch($sub_catg_res);
				$this->subcatgid = $sub_catg_arr['categoryid'];
			}

			if(isset($_SESSION['absearchterms']['series'])) {
				$_GET['brand_series'] = $_SESSION['absearchterms']['series'];
				$GLOBALS['BRAND_SERIES_FLAG'] = 0;
			}
        }

    }

	function SetPanelSettings()
	{
		$output = "";
        
        $all_makes = array('CHEVROLET', 'GMC', 'FORD', 'DODGE', 'TOYOTA', 'NISSAN', 'HONDA', 'JEEP', 'HYUNDAI','CHRYSLER', 'INFINITI', 'LEXUS');
        
        $colours = array('Red', 'Navy', 'Green', 'Brown', 'Black', 'Silver', 'Dark Gray', 'Tan', 'White');
        
        $prod_make = array();
        $prod_model = array();
		$prod_submodel = array();
        $prod_year = array();
        $prod_price = array();
		$prod_categoryid = array();
        $count_categoryid = array();
        
        $brand_id = array();  
        
        $make_link = "";
        $model_link = "";
		$model_flag_link = 0;
        $submodel_link = "";
        $year_link = "";
        $sub_modelrow = array();
		$GLOBALS['SITEPATH'] = GetConfig('ShopPath');
                
		// Get the link to the "all brands" page
		$GLOBALS['AllBrandsLink'] = BrandLink();
        $params = $this->searchterms;
		if(empty($params))
			$params['dynfilters'] = array();
        
		/*--- Here when brand series is searched directly , brand series is set in seesion to be accessed in other pages --- */ 
		if(isset($params['series']) && !empty($params['series']))
		$_SESSION['absearchterms']['series'] = $params['series'];
        
        // Build the search query using our terms & the fields we want
        
		$column_concat = " p.productid , p.prodcode , group_concat(DISTINCT c.categoryid separator '~') as categoryid, group_concat(DISTINCT prodbrandid separator '~') as prodbrandid ";
		$column_concat .= " , group_concat(DISTINCT v.prodmake separator '~') as prodmake , group_concat(DISTINCT v.prodmodel separator '~') as prodmodel , group_concat(DISTINCT v.prodsubmodel separator '~') as prodsubmodel , group_concat(v.prodstartyear separator '~') as prodstartyear , group_concat(v.prodendyear separator '~') as prodendyear "; 
		
		if(isset($params['catuniversal']) && $params['catuniversal'] == 1) {    // this condition has been added as universal category shd be shown only PQ's 
            
            $column_names = $GLOBALS['p_cols'];
            for($j=0;$j<count($column_names);$j++) 
            {
				if( isset($GLOBALS['visible_pqvq'][$column_names[$j]]) &&  $GLOBALS['visible_pqvq'][$column_names[$j]] == 1 ) // need to add this condition for showing only PQ/VQ's which are made visible in admin section
				{
					$column_concat .=  " , group_concat(DISTINCT ".$column_names[$j]." separator '~') as  ".$column_names[$j];  
				}
            }
        
        } else if( isset($params['make']) && !empty($params['make']) && ( isset($params['model']) && !empty($params['model']) && (!isset($params['model_flag']) || $params['model_flag'] == 1 ) ) && isset($params['year']) && !empty($params['year']) && isset($GLOBALS['ISC_SRCH_CATG_ID']) )
        { 
			$column_names = array_merge($GLOBALS['v_cols'],$GLOBALS['p_cols']);
			for($j=0;$j<count($column_names);$j++) 
			{
				
				if( stristr($column_names[$j],'VQbedsize') ) 
					$column_names[$j] = 'VQbedsize';

				if( stristr($column_names[$j],'VQcabsize') ) 
					$column_names[$j] = 'VQcabsize';
				
				if( isset($GLOBALS['visible_pqvq'][$column_names[$j]]) &&  $GLOBALS['visible_pqvq'][$column_names[$j]] == 1 ) // need to add this condition for showing only PQ/VQ's which are made visible in admin section
				{
					if(eregi('^(vq)',$column_names[$j])) {  // the below 2 cases are added for checking only in bedsize and cabsize
						if($column_names[$j] == 'VQbedsize' OR $column_names[$j] == 'VQcabsize') {
							if(strcasecmp($column_names[$j],'VQbedsize') == 0 )
							$column_concat .=  " , group_concat( DISTINCT if( v.bedsize_generalname != '', v.bedsize_generalname, v.VQbedsize ) separator '~' ) as  ".$column_names[$j];  
							else
							$column_concat .=  " , group_concat( DISTINCT if( v.cabsize_generalname != '', v.cabsize_generalname, v.VQcabsize ) separator '~' ) as  ".$column_names[$j];  
						}
						else
							$column_concat .=  " , group_concat(DISTINCT v.".$column_names[$j]." separator '~') as  ".$column_names[$j];  
					}
					else if(eregi('^(pq)',$column_names[$j])) 
					$column_concat .=  " , group_concat(DISTINCT ".$column_names[$j]." separator '~') as  ".$column_names[$j];  
				}
			}
		}
        
        $searchQueries = BuildProductSearchQuery($this->searchterms);
		$searchQueries['query'] = str_replace('USE INDEX (categoryid)','USE INDEX (PRIMARY)',$searchQueries['query']); 
        //$searchQueries['query'] = str_replace('temp.*',$column_concat,$searchQueries['query']); 
        $searchQueries['query'] = str_replace($GLOBALS['srch_where'],$column_concat,$searchQueries['query']);
        
        // lguan_20100513: If in product detail page, and search terms is empty, should use product id to limit the queries for brand, the original
        //              query was killing the performance
        $showOtherBrandForDetail = false;
        if ($this->searchterms=='') {
            $searchQueries['query'] .= (( isset($GLOBALS['ISC_CLASS_PRODUCT']) && $GLOBALS['ISC_CLASS_PRODUCT']->_product['prodcatids'])
                                            ? ' AND c.categoryid IN ('.($GLOBALS['ISC_CLASS_PRODUCT']->_product['prodcatids']).')'
                                            : '');
            $showOtherBrandForDetail = true;
        }
        
        $searchQueries['query'] .= " group by p.productid ";
		$searchQueries['query'] .= $GLOBALS['having_query'];
             
        $Search_Result1 = $GLOBALS['ISC_CLASS_DB']->Query($searchQueries['query']); 
        
        $numrows = @(int)$GLOBALS['ISC_CLASS_DB']->CountResult($Search_Result1);
        
        $flag = 0;  // this flag is used to avoid executing query again and again for submodels
        $filterdata = array();         
        $countfilterdata = array();
        $sku = array();
		$count_model = array();
        $count_submodel['all']['count'] = 0;
        $sub_model_flag = 0;
        $sub_catg = "";

		if(!isset($params['model_flag']) || ( isset($params['model_flag']) && $params['model_flag'] == 1 ) )
                $model_flag_link = 1;
        
        
        $strtocheck = '^(vq|pq)';
            
        if(isset($params['subcategory']))
            $sub_catg = "&subcategory=".MakeURLSafe(strtolower($params['subcategory']));

		if(isset($params['series']))
            $sub_catg .= "&series=".MakeURLSafe(strtolower($params['series']));

		if(isset($params['category']))
            $sub_catg .= "&category=".MakeURLSafe(strtolower($params['category'])); 
            
        while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($Search_Result1)) {
            
            $temp_prod_year = array();
            
            $grp_make = explode("~",$row['prodmake']);
                        
            $grp_model = explode("~",$row['prodmodel']);
                        
            if($row['prodsubmodel'] != '~') 
                $grp_submodel = explode("~",$row['prodsubmodel']);
            else
                $grp_submodel = array();
                         
            $grp_startyear = explode("~",$row['prodstartyear']); 
                        
            $grp_endyear = explode("~",$row['prodendyear']);
                        
            $grp_brandid = explode("~",$row['prodbrandid']);

			$grp_categoryid = explode("~",$row['categoryid']);
                        
            $columns = array_keys($row);
            
            foreach($row as $key => $qval) {
                if(eregi($strtocheck, $key)) {
				  $qval = trim($qval, '~');
                  $qval = strtolower($qval);
                  $grp_dyn = preg_split('/[~;]+/', $qval);
                  $grp_dyn = array_unique($grp_dyn);
				  $grp_dyn = array_values($grp_dyn);
                  for($g=0;$g<count($grp_dyn);$g++)
                  {
						$val = settype($val , "string");
                        $val = strtolower($grp_dyn[$g]);
						if($val=='')    {          //Added by Simha
                            $val = "Others";
                        }
                        if(!empty($val)) {
                            /*$filter_value = explode(";",$val);
                            for($k=0;$k<count($filter_value);$k++)
                            {*/
                                //$val = $filter_value[$k];
								if($val != "")
								{
									if(!isset($filterdata[$key])) {
										$filterdata[$key][] = $val;
										$countfilterdata[$key][$val]['count'] = 1;
									}
									else if(!in_array($val,$filterdata[$key],true)) {
										$filterdata[$key][] = $val;
										$countfilterdata[$key][$val]['count'] = 1;
									} else {
										$countfilterdata[$key][$val]['count']++;
									}                               
								}
                            //}
                        }
                  }
                }
            }
                   
            $prod_id[] = $row['productid'];
            
            for($g=0;$g<count($grp_brandid);$g++) {
                if($grp_brandid[$g] != 0)
                    $brand_id[] = $grp_brandid[$g]; 
            }

			for($g=0;$g<count($grp_categoryid);$g++) {
                if($grp_categoryid[$g] != "") {
                if(!in_array($grp_categoryid[$g],$prod_categoryid)) {
                    $prod_categoryid[] = $grp_categoryid[$g];
                    $count_categoryid[$grp_categoryid[$g]]['count'] = 1;  
                }
                else  
                    $count_categoryid[$grp_categoryid[$g]]['count']++; 
                }
            
            }
            
            for($g=0;$g<count($grp_make);$g++)
            {
				if($grp_make[$g] != '') {
					$product_make = strtoupper($grp_make[$g]);
					if($product_make != "NON-SPEC VEHICLE") {      // this condition is addded not to show "NON-SPEC VEHICLE" in list
						if(!in_array($product_make,$prod_make)) {
							$prod_make[] = $product_make;
							$count_make[$product_make]['count'] = 1;  
						}
						else  
							$count_make[$product_make]['count']++;  
					}
				}
            }

			for($g=0;$g<count($grp_model);$g++)
			{
				if(strtolower($grp_model[$g]) != 'all') {   // this condition is added not to show "All" in list
					$sub_model_flag = 1;
					$grp_model[$g] = strtoupper($grp_model[$g]);
					if(!in_array($grp_model[$g],$prod_model)) {                
						$prod_model[] = $grp_model[$g];
						$count_model[$grp_model[$g]]['count'] = 1;
					}
					else
						$count_model[$grp_model[$g]]['count']++;
				}
			}
            
            if(count($grp_submodel) > 0) {
				for($g=0;$g<count($grp_submodel);$g++)
				{ 
					if(!empty($grp_submodel[$g])) {
					   $sub_model_flag = 1; 
					   $grp_submodel[$g] = ucwords(strtolower($grp_submodel[$g]));
					   if(!in_array($grp_submodel[$g],$prod_submodel)) {
								$prod_submodel[] = $grp_submodel[$g];
								$count_submodel[$grp_submodel[$g]]['count'] = 1;
					   } else {
								$count_submodel[$grp_submodel[$g]]['count']++;
					   }
					} 
				}
			} else {
				if(!in_array('all',$prod_submodel))
					$count_submodel['all']['count'] = 1;
				else
					$count_submodel['all']['count']++;
			}    
            
            
            for($g=0;$g<count($grp_startyear);$g++)
            {  
				$prod_start_year = $grp_startyear[$g];
				$prod_end_year = $grp_endyear[$g];
				if(empty($prod_end_year))
					$prod_end_year =  $prod_start_year;

				if(strtolower($prod_start_year) != "all") {    // this condition is addded not to show "All" in list
                    
                    if(is_numeric($prod_start_year) && is_numeric($prod_end_year))
                        $prod_year_diff = $prod_end_year - $prod_start_year;
                    
                    if(!is_numeric($prod_start_year) && !is_numeric($prod_end_year)) {
                        
                             if(!in_array($prod_start_year,$temp_prod_year))
                               $temp_prod_year[] = $prod_start_year;
                             
                    }
                    else if(isset($params['year']) && !empty($params['year'])) {
                        if(in_array($params['year'],$prod_year)) {
                            $count_year[$params['year']]['count']++;     
                        } else {
                         $prod_year[] =  $params['year'];
                         $count_year[$params['year']]['count'] = 1;     
                        }
                    }
                    else {
                        
                        for($i=0;$i<=$prod_year_diff;$i++)
                        {
                            $actual_year = $prod_start_year + $i;
                           
                            if(!in_array($actual_year,$temp_prod_year))
                               $temp_prod_year[] = $actual_year;
                        }
                   } 
				}
            }
            
            for($k=0;$k<count($temp_prod_year);$k++) {
                if(!in_array($temp_prod_year[$k],$prod_year)) { 
                    $prod_year[] = $temp_prod_year[$k];
                    $count_year[$temp_prod_year[$k]]['count'] = 1;
                }     
                else
                    $count_year[$temp_prod_year[$k]]['count']++;
            }
            
        }

		//Added by Simha // for removing if it has only others in qualifier values
        foreach($countfilterdata as $key => $value)   {
             if(isset($value['Others']) && count($value)==1 && !isset($params['dynfilters'][$key]))  {
                 unset($countfilterdata[$key]);   
                 unset($filterdata[$key]);
             }
        }
		foreach($filterdata as $key => $num)   {
           $keys = array_keys($num, 'Others');
           if(isset($keys) && count($keys)==1) 
           { 
                unset($num[$keys[0]]);
                $num[] = 'Others';
           }
           $num = array_values($num);
           $filterdata[$key] = $num;  
        }
        //Added by Simha Ends
                                 
        $prod_make_new =  array_unique($prod_make);
        asort($prod_make_new);
        $prod_model_new =  array_unique($prod_model);
        asort($prod_model_new);
		$prod_submodel_new =  array_unique($prod_submodel);
        sort($prod_submodel_new);
        $prod_year_new =  array_unique($prod_year);
        arsort($prod_year_new);
        $srch_qry = isset($params['search_query'])? $params['search_query'] : (isset($params['search_query_adv']) ? $params['search_query_adv'] : '');
		$srch_qry = MakeURLSafe($srch_qry);
		$brand_id = array_unique($brand_id);
        $brand_id = array_values($brand_id);

		$GLOBALS['SearchBrands'] = $brand_id; // This variable is used in searchpage.php for displaying brands.
		$GLOBALS['SearchCategories'] = $prod_categoryid; // This variable is used in searchpage.php for displaying categories.
        
        if(isset($params['make']) && !empty($params['make']))
                $make_link = "&make=".MakeURLSafe($params['make']);
                
        if(isset($params['year']) && !empty($params['year']))
                $year_link = "&year=".$params['year'];
                
        if(isset($params['model']) && !empty($params['model']))
                $model_link = "&model=".MakeURLSafe($params['model']);
		if(isset($params['model_flag']) && $params['model_flag'] == 0)
                $model_link .= "&model_flag=0";
                
        if(isset($params['submodel']) && !empty($params['submodel']))
                $submodel_link = "&submodel=".MakeURLSafe($params['submodel']); 
		
		if(isset($params['partnumber']))
        $_GET['partnumber'] = $params['partnumber'];
                
        $query_string_array = $_GET;
		if(isset($params['make']))
        $query_string_array['make'] = $params['make'];
        if(isset($params['model']))
        $query_string_array['model'] = $params['model'];
		if(isset($params['model_flag']) && $params['model_flag'] == 0)
        $query_string_array['model_flag'] = $params['model_flag'];
		if(isset($params['submodel']))
        $query_string_array['submodel'] = $params['submodel'];
        if(isset($params['year']))
        $query_string_array['year'] = $params['year'];
		if(isset($params['brand']))
        $query_string_array['brand'] = $params['brand'];
		if(isset($params['series']))
        $query_string_array['series'] = $params['series'];
		if(isset($params['subcategory']))
        $query_string_array['subcategory'] = $params['subcategory'];
		if(isset($params['category']))
        $query_string_array['category'] = $params['category'];
		if(isset($params['search']))
        $query_string_array['searchtext'] = $params['search'];
		if(isset($params['searchtext']))
        $query_string_array['searchtext'] = $params['searchtext'];
		if(isset($params['vqsbedsize']))
        $query_string_array['vqsbedsize'] = $params['vqsbedsize'];
		if(isset($params['vqscabsize']))
        $query_string_array['vqscabsize'] = $params['vqscabsize'];

		foreach($params['dynfilters'] as $key => $value)
        {
		   $key = strtolower($key);
           $query_string_array[$key] = $value;
        }

		$query_string_array['search_query'] = $srch_qry;
        unset($query_string_array['page'],$query_string_array['search_key'],$query_string_array['x'],$query_string_array['y'],$query_string_array['sortby'],$query_string_array['orderby'],$query_string_array['change'],$query_string_array['product'],$query_string_array['refer']);
        $mmy_string_array = $query_string_array;
        
        unset($mmy_string_array['make'],$mmy_string_array['model'],$mmy_string_array['submodel'],$mmy_string_array['year'],$mmy_string_array['search_query']);
        $mmy_string_new1 = "";
        foreach($mmy_string_array as $mmy_key => $mmy_val) {
             $mmy_string_new1 .= "&".$mmy_key."=".$mmy_val;
        }

		$dyn_filter = ""; // this is the main variable which is used for assigning to the global variable
		$dyn_top = ""; // this is the variable which will remain on top of the filters
		$dyn_bottom = ""; // this is the variable which will remain at bottom of the filters
		$dyn_flag = 0; // this is the variable which will check which are at top or bottom in the filters, 0 for top and 1 for bottom

		/* The below code will be added to redefine search as we need to pass 'a-b-testing' in all URL's for redefine search */
		//Modify 2010/10/19 Ronnie
		$add_url_redefine = "";//"&abtesting=".MakeURLSafe(strtolower($GLOBALS['PathInfo'][1]));


		
		if( isset($params['make']) ||  ( isset($params['make']) && isset($params['model']) && $model_flag_link == 1 )  || isset($params['year']) ) {
			$mmy_clear_links = $this->path."/search.php?search_query=".urlencode($params['search_query']).$sub_catg;
	
			if(isset($params['brand']))
				$mmy_clear_links .= "&brand=".$params['brand'];

			$clear_mmy_filter_link = $this->GetClearFilterlink($query_string_array,0);

			$GLOBALS['DynMsg'] = "<a href='#' onclick=\"deleteMMYcookies('".$this->path.$clear_mmy_filter_link."');\">Clear my Vehicle</a>";
			$GLOBALS['RemoveBackgroundImage'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("RemoveBgImage");
		}

		if( isset($params['make']) &&  ( isset($params['model']) && $model_flag_link == 1 )  && isset($params['year']) && !isset($_REQUEST['change'])) {  // if MMY is selected

			$GLOBALS['MyVehicleAreaHeader'] =  $params['year']." ".$params['make']." ".$params['model'];
		 
			$GLOBALS['DynmenuFilter'] = "";    
			
		}
		else {

			$GLOBALS['MyVehicleAreaHeader'] = "Choose My Vehicle";
			
			$GLOBALS['DynmenuFilter'] = "";    

		}

		/*-------- Year -----------------------------------------*/
		$GLOBALS['MouseoverFn'] = "this.style.cursor='pointer'";
        $extra_year = "";
        //if( !empty($make_link) || !empty($year_link) || !empty($model_link) ) {
		if( empty($year_link) || !empty($year_link) ) {
        
            $GLOBALS['dynid'] = "prod_year";
            $GLOBALS['Dynmainmenu'] = "Year";
			$output2 = "";
            $year_counter = 1;
            
			if(count($prod_year_new) > 0) {
            foreach($prod_year_new as $key => $value ) {
            
					  if(!isset($_REQUEST['change'])) // when clicked on "clear my vehicle", need to pass the value in the search query to get all Make and year 
					  $GLOBALS['BrandLink'] = "$this->path/search.php?search_query=".$srch_qry;
					  else
                      $GLOBALS['BrandLink'] = "$this->path/search.php?search_query=$value";
                     
                     if( !empty($make_link) )
                        $GLOBALS['BrandLink'] .= $make_link;
                     
					 if( !empty($model_link) )
                        $GLOBALS['BrandLink'] .= $model_link;

                     if( !empty($submodel_link) && isset($_REQUEST['submodel']))
                        $GLOBALS['BrandLink'] .= $submodel_link;                    
                     
                     if( !empty($year_link) )
                        $GLOBALS['BrandLink'] .= $year_link;
                     else
                        $GLOBALS['BrandLink'] .= "&year=".$value;
                        
                     $GLOBALS['BrandLink'] .= $mmy_string_new1;
                     
                     $GLOBALS['BrandLink'] .= $sub_catg;
                        
                     $GLOBALS['BrandName'] = isc_html_escape($value);
                     $GLOBALS['BrandCount'] = $count_year[$value]['count'];
                             
                   if(!empty($year_link)) {

                         if($GLOBALS['BrandName'] == 'ALL' && $GLOBALS['BrandName'] != $params['year']) {
							$GLOBALS['BrandName']  =  $params['year'];
                            //$output2 .= "<li>".$params['year']."</li>";
							$output2 .= "<li></li>"; 
                         } else {
                            $GLOBALS['BrandName']  =  $params['year']; 
                            //$output2 .= "<li>$value</li>";
                            $output2 .= "<li></li>";
						 }
							$dyn_flag = 1;
							break;   // break has been added to display only single listing.
				   } else {
							$dyn_flag = 0;
                       if($year_counter < 11) { 
                                 $output2 .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideProductFilter3");  
                                 $year_counter++;
                       } else {
                                 $extra_year .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideProductFilter3");  
                       }
                   
                   }
            }
			} else if(isset($params['year'])) {
                $dyn_flag = 1;
				$GLOBALS['BrandName']  =  $params['year'];
                $output2 .= "<li>".$params['year']."</li>";
            }

			$output2 = "<ul>".$output2."</ul>";

			/* the below code is used to apply more link if records exceed 10 */
			if($year_counter > 11) {
               $GLOBALS['FilterID'] = "year";
               $GLOBALS['ExtraValues'] = $extra_year;
               $output2 .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideFilterMoreLink"); 
            }
            
            $output2 = $GLOBALS['ISC_CLASS_TEMPLATE']->ParseSnippets($output2, $GLOBALS['SNIPPETS']);
            
                //if( !empty($_REQUEST['year']) && !empty($year_link) ) {
				$links_year = $srch_qry;
                if( !empty($year_link) ) 
                    $links_year .= $year_link;
                if(!empty($make_link))    
                    $links_year .= $make_link;
                if( !empty($model_link) && isset($_REQUEST['model']))   
                    $links_year .= $model_link;
                /*if( !empty($submodel_link) && isset($_REQUEST['submodel']))   {
                    $links_year .= $submodel_link;                    
				}*/
				if(isset($params['brand']))
				{
					$links_year .= "&brand=".MakeURLSafe($params['brand']);
				}
				if(isset($params['search']))
				{
					$links_year .= "&searchtext=".MakeURLSafe(strtolower($params['search']));
				}
				if(isset($params['searchtext']))
				{
					$links_year .= "&searchtext=".MakeURLSafe(strtolower($params['searchtext']));
				}
				if(isset($params['vqsbedsize']))
				{	
					$links_year .= "&vqsbedsize=".MakeURLSafe($params['vqsbedsize']);
				}
				if(isset($params['vqscabsize']))
				{	
					$links_year .= "&vqscabsize=".MakeURLSafe($params['vqscabsize']);
				}
				$links_year .=	$this->GetOtherLinksForRedefine($params);
				$links_year .=	$add_url_redefine;
				
			/* this below lines are not to display the year when clear is clicked */                            
           if(isset($_REQUEST['change']))
               $GLOBALS['BrandName']  =  ""; 

			if($dyn_flag == 1 || isset($_REQUEST['change'])) {
               $str = "search_query=".$links_year.$sub_catg."&column=year";
               $GLOBALS['Dyndisplay1'] = "block"; 
               $GLOBALS['Dyndisplay'] = "none";
               $GLOBALS['Dynimage'] = "imgHdrDropDownIconright.gif"; 
			   $GLOBALS['DynFilterArrow'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideProductFilterImage");
			   //$GLOBALS['DynFilterArrow'] .= "&nbsp;&nbsp;&nbsp;".$GLOBALS['BrandName']; 
               $GLOBALS['DynmenuFilter1'] = $output2;
               $GLOBALS['DynmenuFilter'] = "";
               $GLOBALS['JSfunction'] = "getvalueswithajax('".$GLOBALS['dynid']."','{$str}&getymms=1');checkanimate('".$GLOBALS['dynid']."')"; 
           }
           else {
				$GLOBALS['BrandName'] = "";
                $GLOBALS['Dyndisplay1'] = "none";
                $GLOBALS['Dyndisplay'] = "block";
                $GLOBALS['Dynimage'] = "imgHdrDropDownIconright.gif";
				$GLOBALS['DynFilterArrow'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideProductFilterImage"); 
                $GLOBALS['DynmenuFilter'] = $output2;
                $GLOBALS['DynmenuFilter1'] = "";
                $GLOBALS['JSfunction'] = "checkanimate('".$GLOBALS['dynid']."')"; 
				if(empty($year_link)) {
                    $GLOBALS['DynmenuFilter'] = "";
                    $str = "search_query=".$links_year.$sub_catg."&column=year";
                    $GLOBALS['JSfunction'] .= ";getvalueswithajax('".$GLOBALS['dynid']."','{$str}&getymms=1')";
                }
           }
			$GLOBALS['mmyid'] = "mmy_year";
			$dyn_output = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("MyVehicleAreaSearch");

			$dyn_filter = $dyn_output;
            
            //$GLOBALS['SNIPPETS']['SideProductFilter3'] = $output2;   
            
        } else {
            
            $GLOBALS['HideSideProductFiltersPanelYear'] = "none";     
        }

		if($dyn_flag == 1 && !isset($_REQUEST['change'])) {
        $dyn_top .= $dyn_filter; 
        } else {
        $dyn_top .= $dyn_filter;
        }
        $dyn_filter = "";
                
       /*-------- Make -----------------------------------------*/ 

		$GLOBALS['dynid'] = "prod_make";
        $GLOBALS['Dynmainmenu'] = "Make";
        if(isset($make_link) && !empty($make_link)) {
            
                if(count($prod_make_new) > 0) {
				foreach($prod_make_new as $key => $value ) {
					 if(!isset($_REQUEST['change'])) // when clicked on "clear my vehicle", need to pass the value in the search query to get all Make and year
                     $GLOBALS['BrandLink'] = "$this->path/search.php?search_query=".$srch_qry."&make=".$value; 
					 else
					 $GLOBALS['BrandLink'] = "$this->path/search.php?search_query=$value&make=".$value;


                     if(isset($_REQUEST['model']) && empty($_REQUEST['model']))
                        $GLOBALS['BrandLink'] .= "&model=";
                     if(isset($_REQUEST['year']))
                        $GLOBALS['BrandLink'] .= "&year=".$_REQUEST['year'];
                     
                     $GLOBALS['BrandLink'] .= $sub_catg;
                        
                     $GLOBALS['BrandName'] = strtoupper($value);

					 /* this below patch is temporary used when categories with make 'NON-SPEC VEHICLE' are used when searched by redefine category */
					 if( ( isset($params['catuniversal']) && $params['catuniversal'] == 1 ) || ($GLOBALS['BrandName'] == 'NON-SPEC VEHICLE' && $GLOBALS['BrandName'] != $params['make']) ) {
						  $GLOBALS['BrandName'] = $params['make'];
					 }

                     if(isset($count_make[$value]['count']))
                     $GLOBALS['BrandCount'] = $count_make[$value]['count'];
                     else
                     $GLOBALS['BrandCount'] = 0;

                     $output .= "<li></li>";
					 break; // break has been added to display only single listing.
					 
                }
				} else if(isset($params['make'])) {
					 $GLOBALS['BrandName'] = strtoupper($params['make']);
					 $output .= "<li></li>";
//                     $output .= "<li>".$_REQUEST['make']."</li>";
                }
				$dyn_flag = 1;
                $output = $GLOBALS['ISC_CLASS_TEMPLATE']->ParseSnippets($output, $GLOBALS['SNIPPETS']);
                
        }  else {
                $dyn_flag = 0;
                $temp_arr =  array_diff($prod_make_new,$all_makes);
				$temp_count_make = "";
                $temp_no_count_make = "";
                $display_count = 1;
                
                foreach($all_makes as $key => $value ) {
                
					 if(!isset($_REQUEST['change'])) // when clicked on "clear my vehicle", need to pass the value in the search query to get all Make and year
                     $GLOBALS['BrandLink'] = "$this->path/search.php?search_query=".$srch_qry."&make=".$value;
					 else
					 $GLOBALS['BrandLink'] = "$this->path/search.php?search_query=$value&make=".$value;

                     if(isset($_REQUEST['model']) && empty($_REQUEST['model']))
                        $GLOBALS['BrandLink'] .= "&model=";
                     if(isset($params['year']))
                        $GLOBALS['BrandLink'] .= "&year=".$params['year']; 
                        
                     $GLOBALS['BrandLink'] .= $mmy_string_new1;
					 
					 $GLOBALS['BrandLink'] .= $sub_catg;
                             
                     $GLOBALS['BrandName'] = isc_html_escape($value);
                     if(isset($count_make[$value]['count']))
                     $GLOBALS['BrandCount'] = $count_make[$value]['count'];
                     else
                     $GLOBALS['BrandCount'] = 0;

                     /*if($GLOBALS['BrandCount'] == 0)
                        $temp_no_count_make .= "<li>$GLOBALS[BrandName] ($GLOBALS[BrandCount])</li>";*/
                     if($GLOBALS['BrandCount'] != 0) {
						
						if($display_count < 13) // this condiditon is applied to avoid long listing of make lsit
                        $temp_count_make .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideProductFilter1");  
                        else
                        $temp_no_count_make .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideProductFilter1"); 
                        
                        $display_count++;
                        //$output .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideProductFilter1");  
					 }
                }

                if(count($temp_arr) > 0) {
                    
                    foreach($temp_arr as $key => $value ) {
                    
						 if(!isset($_REQUEST['change'])) // when clicked on "clear my vehicle", need to pass the value in the search query to get all Make and year
                         $GLOBALS['BrandLink'] = "$this->path/search.php?search_query=".$srch_qry."&make=".$value;
						 else
						 $GLOBALS['BrandLink'] = "$this->path/search.php?search_query=$value&make=".$value;

						 if(isset($_REQUEST['model']) && empty($_REQUEST['model']))
                            $GLOBALS['BrandLink'] .= "&model=";
                         if(isset($params['year']))
							$GLOBALS['BrandLink'] .= "&year=".$params['year'];  
                         $GLOBALS['BrandName'] = isc_html_escape($value);
                         if(isset($count_make[$value]['count']))
                         $GLOBALS['BrandCount'] = $count_make[$value]['count'];
                         else
                         $GLOBALS['BrandCount'] = 0;
                         
                         $GLOBALS['BrandLink'] .= $mmy_string_new1;
						 
						 $GLOBALS['BrandLink'] .= $sub_catg;

                         /*if($GLOBALS['BrandCount'] == 0)
                            $temp_no_count_make .= "<li>$GLOBALS[BrandName] ($GLOBALS[BrandCount])</li>";*/
                         if($GLOBALS['BrandCount'] != 0) {
                            
                            if($display_count < 13) // this condiditon is applied to avoid long listing of make list
                            $temp_count_make .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideProductFilter1");  
                            else
                            $temp_no_count_make .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideProductFilter1"); 
                        
                            $display_count++;
                         }
                    }
                    
                }
				
				$output = "<ul>$temp_count_make</ul>";

				if($display_count > 13) {   
					$GLOBALS['FilterID'] = "make";
	                $GLOBALS['ExtraValues'] = $temp_no_count_make;
		            $output .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideFilterMoreLink");
	               //$output .= "<ul class='more'><li><a href=\"javascript:onclick=show_hide('make')\" id='make_more'>More...</a></li></ul>";
               }
                    
                                 
                $output = $GLOBALS['ISC_CLASS_TEMPLATE']->ParseSnippets($output, $GLOBALS['SNIPPETS']);
        }
        
        /* this below lines are not to display the make when clear is clicked */                
        if(isset($_REQUEST['change']))
               $GLOBALS['BrandName']  =  "";

		if($dyn_flag == 1 || isset($_REQUEST['change']) ) {
           //$str = "search_query=".$srch_qry.$make_link."&model=".$year_link.$sub_catg."&column=make"; 
           $GLOBALS['Dyndisplay1'] = "block"; 
           $GLOBALS['Dyndisplay'] = "none";
           $GLOBALS['Dynimage'] = "imgHdrDropDownIconright.gif";
		   $GLOBALS['DynFilterArrow'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideProductFilterImage");
		   //$GLOBALS['DynFilterArrow'] .= "&nbsp;&nbsp;&nbsp;".$GLOBALS['BrandName'];
           $GLOBALS['DynmenuFilter1'] = "<ul>".$output."</ul>";
           $GLOBALS['DynmenuFilter'] = "";
           //$GLOBALS['JSfunction'] = "getvalueswithajax('".$GLOBALS['dynid']."','$str');checkanimate('".$GLOBALS['dynid']."')"; 
           //$GLOBALS['Dynimage'] = "imgHdrDropDownIconright.gif";
        }
        else {
			$GLOBALS['BrandName'] = ""; 
            $GLOBALS['Dyndisplay1'] = "none";
            $GLOBALS['Dyndisplay'] = "block";
            $GLOBALS['Dynimage'] = "imgHdrDropDownIconright.gif";
			$GLOBALS['DynFilterArrow'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideProductFilterImage"); 
            $GLOBALS['DynmenuFilter'] = $output;
            $GLOBALS['DynmenuFilter1'] = "";
            //$GLOBALS['JSfunction'] = "checkanimate('".$GLOBALS['dynid']."')"; 
			if(empty($make_link)) {
                $GLOBALS['DynmenuFilter'] = "";
            }
        }
		$str = "search_query=".$srch_qry.$make_link."&model=".$year_link.$sub_catg."&column=make";
		if(isset($params['brand']))
		{
			$str .= "&brand=".$params['brand'];
		}
		if(isset($params['search']))
		{
			$str .= "&searchtext=".MakeURLSafe(strtolower($params['search']));
		}
		if(isset($params['searchtext']))
		{
			$str .= "&searchtext=".MakeURLSafe(strtolower($params['searchtext']));
		}
		if(isset($params['vqsbedsize']))
		{	
			$str .= "&vqsbedsize=".MakeURLSafe($params['vqsbedsize']);
		}
		if(isset($params['vqscabsize']))
		{	
			$str .= "&vqscabsize=".MakeURLSafe($params['vqscabsize']);
		}
		$str .=	$this->GetOtherLinksForRedefine($params);
		$str .=	$add_url_redefine;
		
		$GLOBALS['JSfunction'] = "getvalueswithajax('".$GLOBALS['dynid']."','{$str}&getymms=1');checkanimate('".$GLOBALS['dynid']."')";
		$GLOBALS['mmyid'] = "mmy_make";
        $dyn_output = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("MyVehicleAreaSearch");

		$dyn_filter = $dyn_output;     
        
        if($dyn_flag == 1 && !isset($_REQUEST['change'])) {
        $dyn_top .= $dyn_filter; 
        } else {
        $dyn_top .= $dyn_filter;
        }
        $dyn_filter = "";
        
        //$GLOBALS['SNIPPETS']['SideProductFilter1'] = $output;
        
        /*-------- Model - Starts -----------------------------------------*/

		$GLOBALS['dynid'] = "prod_model"; 
        $GLOBALS['Dynmainmenu'] = 'Model';
		$output1 = ""; 
        $display_count = 1;
        $extra = ""; 

		if(isset($params['make'])) { // if make is selected then need to enter the loop
		
				if( isset($params['model']) && $model_flag_link == 1 ) { // if make is selected need to show only that make
					$GLOBALS['BrandName'] = strtoupper($params['model']);
					$dyn_flag = 1;
				} else {
					$dyn_flag = 0;
					$model_string_array = $query_string_array;
					unset($model_string_array['model_flag'],$model_string_array['model']);
					$ymm_links = $this->GetYMMLinks($model_string_array);
					$ymm_links .= $this->GetOtherLinks($params);
					foreach($prod_model_new as $key => $value) {

						if ($GLOBALS['EnableSEOUrls'] == 0)
						{
							$GLOBALS['BrandLink'] = $this->path."/search.php?search_query=".$srch_qry;
							$GLOBALS['BrandLink'] .= $ymm_links;
							$GLOBALS['BrandLink'] .= "&model=".$value;
						}
						else
						{
							$GLOBALS['BrandLink'] = $this->path;
							
							if($srch_qry != "")
								$GLOBALS['BrandLink'] .= "/".$srch_qry;
							
							$GLOBALS['BrandLink'] .= $ymm_links;

							$GLOBALS['BrandLink'] .= "/model/".MakeURLSafe(strtolower($value));
						}

						$GLOBALS['BrandName'] = isc_html_escape($value);
						$GLOBALS['BrandCount'] = $count_model[$value]['count'];

						if($display_count < 11)
							$output1 .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideProductFilter2");  
						else
							$extra .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideProductFilter2");  
							
						$display_count++; 
					}

					$output1 = "<ul>".$output1."</ul>";
					
					if($display_count > 11) {   
					   $GLOBALS['FilterID'] = "model";
					   $GLOBALS['ExtraValues'] = $extra;
					   $output1 .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideFilterMoreLink");
					}
				}

				/* the below links are passes for redefine search - starts*/
				
				$links =  $srch_qry;
				$links .= $make_link;
				$links .= $year_link;
				if(isset($params['model']) && $model_flag_link == 1)
					$links .= $model_link;

				$links .= $sub_catg;
				if(isset($params['brand']))
				{
					$links .= "&brand=".MakeURLSafe($params['brand']);
				}
				if(isset($params['search']))
				{
					$links .= "&searchtext=".MakeURLSafe(strtolower($params['search']));
				}
				if(isset($params['searchtext']))
				{
					$links .= "&searchtext=".MakeURLSafe(strtolower($params['searchtext']));
				}
				if(isset($params['vqsbedsize']))
				{	
					$links .= "&vqsbedsize=".MakeURLSafe(strtolower($params['vqsbedsize']));
				}
				if(isset($params['vqscabsize']))
				{	
					$links .= "&vqscabsize=".MakeURLSafe(strtolower($params['vqscabsize']));
				}
				$links .=	$this->GetOtherLinksForRedefine($params);
				
				$links .= "&column=model";
				$links .=	$add_url_redefine;

				/* the below links are passes for redefine search - ends*/


				/* this below lines are not to display the make when clear is clicked */                            
				 if(isset($_REQUEST['change']))
					 $GLOBALS['BrandName']  =  ""; 
				   
				 if($dyn_flag == 1 || isset($_REQUEST['change'])) {
					 $GLOBALS['Dyndisplay1'] = "block"; 
					 $GLOBALS['Dyndisplay'] = "none";
					 $GLOBALS['Dynimage'] = "imgHdrDropDownIconright.gif";
					 $GLOBALS['DynFilterArrow'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideProductFilterImage"); 
					 $GLOBALS['DynmenuFilter1'] = $output1;
					 $GLOBALS['DynmenuFilter'] = "";
					 $str = "search_query=".$links;
					 if(!isset($_REQUEST['change'])) {
						 $GLOBALS['JSfunction'] = "getvalueswithajax('".$GLOBALS['dynid']."','{$str}&getymms=1');checkanimate('".$GLOBALS['dynid']."')"; 
					 } else {
						 $GLOBALS['mousedefaultpointer'] = "mousedefaultpointer";
						 $GLOBALS['JSfunction'] = "";
					 }

				 } else {
					 $GLOBALS['BrandName'] = "";
					 $GLOBALS['Dyndisplay1'] = "none";
					 $GLOBALS['Dyndisplay'] = "block";
					 $GLOBALS['Dynimage'] = "imgHdrDropDownIconright.gif";
					 
					 $GLOBALS['DynmenuFilter'] = "";					 

					 if(isset($params['model_flag']) && $params['model_flag'] == 0 && (!isset($params['catuniversal']) || $params['catuniversal'] == 0))
					 {
						$GLOBALS['DynmenuFilter'] = $output1;
						$GLOBALS['dynidStyle'] = "style='display:block'";
						$GLOBALS['Dynimage'] = "imgHdrDropDownIcon.gif";
					 }
						 
					 $GLOBALS['DynFilterArrow'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideProductFilterImage");
					 $GLOBALS['DynmenuFilter1'] = "";
					 $str = "search_query=".$links;
					 $GLOBALS['JSfunction'] = "getvalueswithajax('".$GLOBALS['dynid']."','{$str}&getymms=1');checkanimate('".$GLOBALS['dynid']."')"; 
				 }
		
		}	else	{
			$GLOBALS['BrandName']  =  "";
			$GLOBALS['mousedefaultpointer'] = "mousedefaultpointer";
			$GLOBALS['DynmenuFilter'] = "";
			$GLOBALS['JSfunction'] = "";
		}
	    
        $GLOBALS['mmyid'] = "mmy_model";    
        $dyn_output = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("MyVehicleAreaSearch");
        $dyn_filter = $dyn_output;
		$dyn_top .= $dyn_filter;
        $dyn_filter = "";
   
       /*-------- Model - Ends -----------------------------------------*/
        
        
		
		$filter1 = <<<P1
    <div class="Block BrandList Moveable" id="SideProductFilters" style="">
P1;

$filter2 =  <<<P1
       <div class="BlockContent">
        <ul>
P1;

$filter3 = <<<P3
        </ul>
        </div>                
        </div>
P3;


			$GLOBALS['MyVehicleArea'] = $dyn_top;
			$GLOBALS['MyVehicleArea'] .= "<p id='fit'>Guaranteed to Fit Your Vehicle!</p>";
						
			if(isset($GLOBALS['DynMsg']))
				$GLOBALS['MyVehicleArea'] .= "<ul id='modifyvehicle'><li>".$GLOBALS['DynMsg']."</li></ul>";  

			if(isset($params['srch_category']) || isset($params['brand']) || isset($params['submodel'])) {

				$clear_filter_below_link = $this->GetClearFilterlink($query_string_array,1);
				
				if($clear_filter_below_link != "/")
				{
					$clear_filter_below_link = "/".MakeURLSafe(strtolower($GLOBALS['PathInfo'][1])).$clear_filter_below_link;
				}

				$GLOBALS['MyVehicleArea'] .= "<ul id='modifyvehicle'><li><a href='". $this->path."$clear_filter_below_link' ";

				if($clear_filter_below_link == '/')
					$GLOBALS['MyVehicleArea'] .= "onclick='return clearOtherFilters();'";

				$GLOBALS['MyVehicleArea'] .= " >Clear All Filters Below</a></li></ul>";
			}

			if( isset($params['search']) )
			{
				$GLOBALS['QualiferValue'] = "";
				if(isset($params['vqsbedsize']))
				{
					$GLOBALS['QualiferValue'] .= "/vqsbedsize/".MakeURLSafe(strtolower($params['vqsbedsize']))."/";
				}
				if(isset($params['vqscabsize']))
				{
					$GLOBALS['QualiferValue'] .= "/vqscabsize/".MakeURLSafe(strtolower($params['vqscabsize']))."/";
				}
				$GLOBALS['QualiferValue'] .= $this->GetOtherLinks($params);
				$GLOBALS['QualiferValue'] = trim($GLOBALS['QualiferValue'],"/");
				if( trim($GLOBALS['QualiferValue']) != "" )
				{
					$GLOBALS['QualiferValue'] =	" var SearchQualVal = '".$GLOBALS['QualiferValue']."/'; ";
				}

				$GLOBALS['QualiferValue'] .=	" var SearchStringVal = '".MakeURLSafe(strtolower($params['search']))."/'; ";
			}

			$dyn_top = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("MyVehicleArea");                                                            

			/************** Category Listing ********************/
			$str = "search_query=".$srch_qry.$make_link.$model_link.$year_link."&column=categories";
			//$str .= isset($params['brand']) ? "&brand=".MakeURLSafe($params['brand']) : '';
			$str .= isset($GLOBALS['ISC_SRCH_CATG_NAME']) ? "&catg_name=".MakeURLSafe($GLOBALS['ISC_SRCH_CATG_NAME']) : '';
			$str .= isset($params['search']) ? "&searchtext=".MakeURLSafe($params['search']) : '';
			$str .= isset($params['searchtext']) ? "&searchtext=".MakeURLSafe($params['searchtext']) : '';
			$str .= isset($params['vqsbedsize']) ? "&vqsbedsize=".MakeURLSafe($params['vqsbedsize']) : '';
			$str .= isset($params['vqscabsize']) ? "&vqscabsize=".MakeURLSafe($params['vqscabsize']) : '';
			$str .=	$this->GetOtherLinksForRedefine($params);
			$str .=	$add_url_redefine;
			$dyn_top .= $this->GetCategoryListing($prod_categoryid,$count_categoryid,$str,(int)$numrows);


             /*------------ Brand Filter --------------------*/ 
             
if(count($brand_id) > 0 || isset($params['brand'])) {
    $title = "<h2>Brand</h2>";      
    //$dyn_filter .=  $filter1.$title.$filter2;
    $brand_link = "";
	$GLOBALS['dynid'] = "dyn_brand"; 
    $GLOBALS['Dynmainmenu'] = "Brand";  
    $count_brand = 1;
    $extra = "";
	$str = "";
    
    $brand_string_array = $query_string_array;
    unset($brand_string_array['brand'],$brand_string_array['series'],$brand_string_array['search_query']);

	$get_mmy_links = "";
	$brand_string_new1 = "";
	if(isset($GLOBALS['ISC_SRCH_CATG_NAME']))
	{
			$get_mmy_links .= MakeURLSafe(strtolower($GLOBALS['PathInfo'][1]));
			$brand_string_new1 .= MakeURLSafe(strtolower($GLOBALS['ISC_SRCH_CATG_NAME']));
	}
	/*else if(isset($GLOBALS['ISC_SRCH_BRAND_NAME']))
			$get_mmy_links .= MakeURLSafe(strtolower($GLOBALS['ISC_SRCH_BRAND_NAME']));*/

	if($get_mmy_links != "") {
		if($GLOBALS['EnableSEOUrls'] == 1)
			$get_mmy_links = "/".$get_mmy_links;
	}

	/* this condition was added when brand & catg is selected and for clear functionality, no need to pass the $params['category'] */
	if(isset($params['brand']) && isset($params['category']) && strtolower($params['category']) == strtolower($GLOBALS['ISC_SRCH_CATG_NAME']))
		unset($brand_string_array['category']);

	$get_mmy_links .= $this->GetYMMLinks($brand_string_array);
	$get_mmy_links .= $this->GetOtherLinks($params);

    foreach($brand_string_array as $br_key => $br_val) {
         $brand_string_new1 .= "&".$br_key."=".MakeURLSafe($br_val);
    }
    //$brand_string_new1 .= $sub_catg;
        
    if(isset($params['brand']) && !empty($params['brand'])) {
       $dyn_flag = 1; 
       $params['brand'] = ucwords(strtolower($params['brand']));
       
       $dyn_filter .= <<<P2
        <li><img src='$this->path/templates/default/images/check.gif'>&nbsp;&nbsp;$params[brand]</li>
P2;

	   if(strtolower($params['brand']) == strtolower(urldecode($srch_qry))) { // if searched only by brand
		   $brandclearurl = "$this->path/search.php?search_query=brands";
		   $str = "search_query=";
	   } 
	   else 
	   { // if searched with other combinations
		   $search_query = trim(str_ireplace($params['brand'],'',MakeURLNormal($srch_qry)));
		   $brandclearurl = "$this->path/search.php?search_query=".MakeURLSafe($search_query);
		   $str = "search_query=";

		   /* the below condition is added not to add the category name again as it is being added in $brand_string_new1 at the top */
		   if( strtolower($search_query) != strtolower( isset($GLOBALS['ISC_SRCH_CATG_NAME']) ? $GLOBALS['ISC_SRCH_CATG_NAME'] : '' ) )
				$str .= MakeURLSafe($search_query);
	   }

	   $str .= $brand_string_new1."&brand=".MakeURLSafe($params['brand'])."&column=prodbrandid";
	   $str .= $this->GetOtherLinksForRedefine($params);
	   $str .=	$add_url_redefine;
	   
	   if(!empty($brand_string_new1))
			$brandclearurl .= $brand_string_new1;

	   $GLOBALS['ClearURL'] = "<a href='".$this->LeftClearLink($get_mmy_links)."'>Clear</a>";	
       
    }  else {

	   $other_brands = ""; // this variables is used to show brand list in "other brands"
       $dyn_flag = 0;
	   $brand_query = "select distinct brandid , brandname from [|PREFIX|]brands b inner join [|PREFIX|]products p on b.brandid = p.prodbrandid order by brandname asc ";
	   $brand_result = $GLOBALS['ISC_CLASS_DB']->Query($brand_query);
	   while($brand_row = $GLOBALS['ISC_CLASS_DB']->Fetch($brand_result) )
	   {
		   if(in_array($brand_row['brandid'],$brand_id))
		   {
				$GLOBALS['BrandName'] = $brand_row['brandname'];
				$search_query = $srch_qry;
				if(urldecode($srch_qry) == 'brands' || urldecode($srch_qry) == 'categories')
				$search_query = MakeURLSafe($GLOBALS['BrandName']);
				//$GLOBALS['BrandLink'] = "$this->path/search.php?search_query=$search_query$brand_string_new1&brand=".$brand_row['brandid'];
				
				if(!isset($GLOBALS['ISC_SRCH_CATG_NAME']))
				{
					if ($GLOBALS['EnableSEOUrls'] == 1)
						$GLOBALS['BrandLink'] = $this->path."/".MakeURLSafe(strtolower($brand_row['brandname'])).$get_mmy_links;
					else
						$GLOBALS['BrandLink'] = $this->path."/search.php?search_query=".MakeURLSafe($brand_row['brandname']).$get_mmy_links;
				} 
				else
				{
					//Modify 2010/10/19 Ronnie
					//$GLOBALS['BrandLink'] = $this->LeftLink($get_mmy_links,'brand',strtolower($brand_row['brandname']));
					$GLOBALS['BrandLink'] = $this->LeftLink("/".MakeURLSafe(strtolower($GLOBALS['ISC_SRCH_CATG_NAME'])),'brand',strtolower($brand_row['brandname']));
				}

				if($count_brand < 11) {
					$dyn_filter .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideProductFilter1");
				} else {
					$extra .=  $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideProductFilter1");
				}
				  $count_brand++;
		   }
		   else // this condition is used for showing other brands
		   {
				$ymm_links_for_brands = $this->GetClearFilterlink($params,1);
				$ymm_links_for_brands = rtrim($ymm_links_for_brands, "/");
				$GLOBALS['BrandName'] = $brand_row['brandname'];
				if ($GLOBALS['EnableSEOUrls'] == 1)
			    {
					//$GLOBALS['BrandLink'] = $this->LeftLink($get_mmy_links,'brand',strtolower($brand_row['brandname']));
					//$GLOBALS['BrandLink'] = $this->path."/".MakeURLSafe(strtolower($brand_row['brandname'])).$ymm_links_for_brands;
			    	//Modify 2010/10/19 Ronnie
			    	$GLOBALS['BrandLink']= sprintf("%s/%s", $this->path, MakeURLSafe(strtolower($brand_row['brandname'])));
					
				}
				else 
				{
					$ymm_links_for_brands = str_replace('categories',MakeURLSafe(strtolower($brand_row['brandname'])),$ymm_links_for_brands);
					$GLOBALS['BrandLink'] = $this->path.$ymm_links_for_brands;
				}
				$other_brands .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideProductFilter1");
		   }
	   }

	   $dyn_filter = "<ul>".$dyn_filter."</ul>";
	   if($count_brand > 11) {
		   $GLOBALS['FilterID'] = "brand";
		   $GLOBALS['ExtraValues'] = $extra;
		   $dyn_filter .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideFilterMoreLink");
	   }

        // lguan_20100513: Added a condition to show other brand when user enter the product detail page without any search teams in session,
        //          So that the other brands will be available for user
	   if( $other_brands != "" && (isset($params['srch_category']) || $showOtherBrandForDetail) )	// adding other brands with the main list
	   {
		    $GLOBALS['OtherBrands'] = $other_brands;
			$dyn_filter .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("OtherBrands");
	   }

	   //$GLOBALS['ClearURL'] = "$this->path/search.php?search_query=$srch_qry$brand_string_new1";
	   $GLOBALS['ClearURL'] = "";
   
    }

	if($dyn_flag == 1) {
       //$str = "search_query=".$links.$model_link."&column=model";
       $GLOBALS['Dyndisplay1'] = "showlist"; 
       $GLOBALS['Dyndisplay'] = "hidelist";
       $GLOBALS['Dynimage'] = "imgHdrDropDownIconright.gif"; 
	   $GLOBALS['DynFilterArrow'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideProductFilterImage"); 
       $GLOBALS['DynmenuFilter1'] = $dyn_filter;
       $GLOBALS['DynmenuFilter'] = "";
       $GLOBALS['JSfunction'] = "getvalueswithajax('".$GLOBALS['dynid']."','$str');checkanimate('".$GLOBALS['dynid']."')"; 
       //$GLOBALS['Dynimage'] = "imgHdrDropDownIconright.gif";
    }
    else {
        $GLOBALS['Dyndisplay1'] = "hidelist";
        $GLOBALS['Dyndisplay'] = "showlist";
        $GLOBALS['Dynimage'] = "imgHdrDropDownIcon.gif";
		$GLOBALS['DynFilterArrow'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideProductFilterImage"); 
        $GLOBALS['DynmenuFilter'] = $dyn_filter;
        $GLOBALS['DynmenuFilter1'] = "";
        $GLOBALS['JSfunction'] = "checkanimate('".$GLOBALS['dynid']."')"; 
    }
    
    $dyn_output = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideProductDynFilter");
    $dyn_filter = $dyn_output;
    
    if($dyn_flag == 1) {
    $dyn_bottom .= $dyn_filter; 
    } else {
    $dyn_top .= $dyn_filter;
    }
    $dyn_filter = "";
} 

	/*------------ Brand Filter ends --------------------*/

	/*------------ Submodel Filter - starts --------------------*/

if( isset($params['model']) && $model_flag_link == 1 && (count($prod_submodel_new) > 0 || isset($params['submodel'])) ) {
   
    $GLOBALS['dynid'] = "dyn_submodel"; 
    $GLOBALS['Dynmainmenu'] = "Submodel";  
    $count_sub_model = 1;
    $extra = "";
    
    $submodel_string = $query_string_array;
    unset($submodel_string['submodel'],$submodel_string['search_query']);

	$get_mmy_links = "";
	/*if(isset($GLOBALS['ISC_SRCH_CATG_NAME']))
			$get_mmy_links .= MakeURLSafe(strtolower($GLOBALS['ISC_SRCH_CATG_NAME']));
	else if(isset($GLOBALS['ISC_SRCH_BRAND_NAME']))
			$get_mmy_links .= MakeURLSafe(strtolower($GLOBALS['ISC_SRCH_BRAND_NAME']));*/

	if(isset($params['search_query']))
	{
		$get_mmy_links .= MakeURLSafe(strtolower($GLOBALS['PathInfo'][1]));
	}

	if($get_mmy_links != "") {
		if($GLOBALS['EnableSEOUrls'] == 1)
			$get_mmy_links = "/".$get_mmy_links;
	}

	$get_mmy_links .= $this->GetYMMLinks($submodel_string);

    $submodel_string_new1 = "";
    foreach($submodel_string as $br_key => $br_val) {
		 if(is_array($br_val)) {
            $br_val = implode("&".$br_key."[]=",$br_val);
			$br_key = $br_key."[]";
		 }
		 else
			$br_val = MakeURLSafe($br_val);

         $submodel_string_new1 .= "&".$br_key."=".$br_val;
    }
    //$submodel_string_new1 .= $sub_catg;
        
    if(isset($params['submodel']) && !empty($params['submodel'])) {
       
	   $params['submodel'] = ucwords(strtolower($params['submodel']));
	   $dyn_flag = 1; 
       $dyn_filter .= <<<P2
        <ul><li><img src='$this->path/templates/default/images/check.gif'>&nbsp;&nbsp;$params[submodel]</li></ul>
P2;
	   $str = "search_query=".$srch_qry;
	   $submodelclearurl = $this->path."/search.php?".$str;
	   $str .= $submodel_string_new1."&submodel=".$params['submodel']."&column=submodel";
	   $str .=	$add_url_redefine;
	   $submodelclearurl .= $submodel_string_new1;
	   $GLOBALS['ClearURL'] = "<a href='".$this->LeftClearLink($get_mmy_links).$this->GetOtherLinks($params)."'>Clear</a>";

    }  else {
       $dyn_flag = 0; 
	   for($s=0;$s<count($prod_submodel_new);$s++) {
			$GLOBALS['BrandName'] = $prod_submodel_new[$s];
			$search_query = $srch_qry;

			$GLOBALS['BrandLink'] = $this->LeftLink($get_mmy_links,'submodel',$prod_submodel_new[$s]);
			$GLOBALS['BrandLink'] .= $this->GetOtherLinks($params);
			if($count_sub_model < 11) {
				$dyn_filter .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideProductFilter1");
            } else {
				$extra .=  $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideProductFilter1");
            }
              $count_sub_model++;
	   }
	   
       $dyn_filter = "<ul>".$dyn_filter."</ul>";
       if($count_sub_model > 11) {
       $GLOBALS['FilterID'] = "submodel";
       $GLOBALS['ExtraValues'] = $extra;
       $dyn_filter .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideFilterMoreLink");
       }
       
	   $GLOBALS['ClearURL'] = "";
    }
    
    
    if($dyn_flag == 1) {
       //$str = "search_query=".$links.$model_link."&column=model";
       $GLOBALS['Dyndisplay1'] = "showlist"; 
       $GLOBALS['Dyndisplay'] = "hidelist";
       $GLOBALS['Dynimage'] = "imgHdrDropDownIconright.gif"; 
       $GLOBALS['DynFilterArrow'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideProductFilterImage");
       $GLOBALS['DynmenuFilter1'] = $dyn_filter;
       $GLOBALS['DynmenuFilter'] = "";
       $GLOBALS['JSfunction'] = "getvalueswithajax('".$GLOBALS['dynid']."','$str');checkanimate('".$GLOBALS['dynid']."')"; 
       //$GLOBALS['Dynimage'] = "imgHdrDropDownIconright.gif";
    }
    else {
        $GLOBALS['Dyndisplay1'] = "hidelist";
        $GLOBALS['Dyndisplay'] = "showlist";
        $GLOBALS['Dynimage'] = "imgHdrDropDownIcon.gif";
        $GLOBALS['DynFilterArrow'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideProductFilterImage");
        $GLOBALS['DynmenuFilter'] = $dyn_filter;
        $GLOBALS['DynmenuFilter1'] = "";
        $GLOBALS['JSfunction'] = "checkanimate('".$GLOBALS['dynid']."')"; 
    }
    
    $dyn_output = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideProductDynFilter");
    $dyn_filter = $dyn_output;
    
    if($dyn_flag == 1) {
    $dyn_bottom .= $dyn_filter; 
    } else {
    $dyn_top .= $dyn_filter;
    }
    $dyn_filter = "";
}

	/*------------ Submodel Filter - ends --------------------*/



        /*-------- Other Filters -----------------------------------------*/  
        if( ( (isset($params['catuniversal']) && $params['catuniversal'] == 1) || ( !empty($make_link) && ( !empty($model_link) && (!isset($params['model_flag']) || $params['model_flag'] == 1 ) ) && !empty($year_link) ) ) && ( $numrows > 0 || (isset($_REQUEST['GO']) && $numrows > 0) ) && isset($GLOBALS['ISC_SRCH_CATG_ID']) ) {
        //    include('includes/display/ProdDynamicFilters.php');
        

        $map_names = array();
        $filter_names = "select * from [|PREFIX|]qualifier_names";
        $filter_result = $GLOBALS['ISC_CLASS_DB']->Query($filter_names);
        while($filter_row = $GLOBALS['ISC_CLASS_DB']->Fetch($filter_result)) {
			if($filter_row['display_names'] != '') 
            $map_names[$filter_row['column_name']]['name'] = $filter_row['display_names'];
			$map_names[$filter_row['column_name']]['qid'] = $filter_row['qid'];
        }
        
        $query_string_new = $this->path."/search.php?";

		$get_mmy_links = "";
		/*if(isset($GLOBALS['ISC_SRCH_CATG_NAME']) && !isset($params['category']))
			$get_mmy_links .= MakeURLSafe(strtolower($GLOBALS['ISC_SRCH_CATG_NAME']));
		else if(isset($GLOBALS['ISC_SRCH_BRAND_NAME']))
			$get_mmy_links .= MakeURLSafe(strtolower($GLOBALS['ISC_SRCH_BRAND_NAME']));*/

		if(isset($params['search_query']))
		{
			$get_mmy_links .= MakeURLSafe(strtolower($GLOBALS['PathInfo'][1]));
		}

		if($get_mmy_links != "") {
			if($GLOBALS['EnableSEOUrls'] == 1)
				$get_mmy_links = "/".$get_mmy_links;
		}

		$get_mmy_links .= $this->GetYMMLinks($params);
		$get_all_param_links = $this->GetOtherLinks($params);
             
             //$dyn_filter = "";
             for($u=0;$u<count($columns);$u++) {    // loop for the filters . Here columns are the filters.
                if(eregi('^(vq|pq)', $columns[$u])) {   // checking whether the name of the column starts with vq or pq
                    
                  if( isset($filterdata[$columns[$u]]) && count($filterdata[$columns[$u]]) > 0)  {
 
                        $filter_var = array('vq','pq');

						//$title = ucfirst(str_ireplace($filter_var,"",$columns[$u]));
						if(!isset($map_names[$columns[$u]]['name']) || empty($map_names[$columns[$u]]['name']))
                            $title = ucfirst(str_ireplace($filter_var,"",$columns[$u]));
                        else
                            $title = $map_names[$columns[$u]]['name'];

						$Qualifier_id = $map_names[$columns[$u]]['qid'];
                        $GLOBALS['CategoryId'] = isset($params['subcategory']) ? $this->subcatgid : $GLOBALS['ISC_SRCH_CATG_ID']; 

						$this->GetAssocDetails($GLOBALS['CategoryId'], $Qualifier_id, $OwnAssoc, $ParentAssoc, $OwnValue, $ParentValue);

						$qvalue_mapping_array = $OwnAssoc;

						/* The below code is added to have the values sorted in alphabetical order and "Others" added at the end - starts */
						if( $columns[$u] == "PQbodylength" || $columns[$u] == "PQbodywidth")
						{
							asort($filterdata[$columns[$u]],SORT_NUMERIC);
						}
						else
						{
							$temp_filterdata = array();
							foreach($filterdata[$columns[$u]] as $k => $kval)
							{
							   $CurrentValueItem = array();
							   $CurrentValueItem['vimage'] = '';
	                           $CurrentValueItem['vname'] = '';
		                       $CurrentValueItem['vcomments'] = '';
							 
							   if(($m = array_search($kval,$OwnValue))!==false) 
							   {  
								   $CurrentValueItem = $qvalue_mapping_array[$m];
								   if($CurrentValueItem['vname'] != '')
								   {
										$kval = $CurrentValueItem['vname'];  
								   }
							   }   

							   if($CurrentValueItem['vimage'] == "" && $CurrentValueItem['vcomments'] == "" && $CurrentValueItem['vname'] == "") 
							   {
									if(($n = array_search($kval,$ParentValue))!==false) 
									{
										$CurrentValueItem = $ParentAssoc[$n];
										if($CurrentValueItem['vname'] != '')
										{
											$kval = $CurrentValueItem['vname']; 
										}
									}
							   }
							   $temp_filterdata[$k] = strtolower($kval);
							}

							asort($filterdata[$columns[$u]]);

							asort($temp_filterdata);
							$temp_arr1 = array_keys($temp_filterdata);
							$temp_arr2 = array();
							foreach($temp_arr1 as $key)
							{
								$temp_arr2[] = $filterdata[$columns[$u]][$key];

							}
							$filterdata[$columns[$u]] = array_combine($temp_arr1,$temp_arr2);
						}

						if( ($others_key = array_search('Others', $filterdata[$columns[$u]])) !== FALSE )
						{
							unset($filterdata[$columns[$u]][$others_key]);
							$filterdata[$columns[$u]][$others_key] = 'Others';
						}
						
						/* - ends - */

						$GLOBALS['dynid'] = "dyn".($u+1); 
						//$GLOBALS['Dynmainmenu'] = $title;
						$dyn_filter = "";
						$extra = ""; // this is used to hide the values if exceed 10
                        $count_pqvq = 1;
                        //$dyn_filter .=  $filter1.$title.$filter2; 
                         
                        //for($k=0;$k<count($filterdata[$columns[$u]]);$k++)       // this loop is for showing the list in the filters column
						foreach($filterdata[$columns[$u]] as $k => $kval)
                        {        //$countfilterdata[$key][$val]['count']
                            $value = $filterdata[$columns[$u]][$k];
							$original_value = $filterdata[$columns[$u]][$k];
							$GLOBALS['HoverImage'] = "";
                            $GLOBALS['Comments'] = "";

							/*-------------- Below code is used to cehck comments in subcategory and main category ------------ */

						   $CurrentValueItem = array();
                           $CurrentValueItem['vimage'] = '';
                           $CurrentValueItem['vname'] = '';
                           $CurrentValueItem['vcomments'] = '';

					       if(($m = array_search($value,$OwnValue))!==false) {  
                                $CurrentValueItem = $qvalue_mapping_array[$m];  
                           }   

                           if($CurrentValueItem['vimage'] == "" && $CurrentValueItem['vcomments'] == "" && $CurrentValueItem['vname'] == "") 
                           {
                                if(($n = array_search($value,$ParentValue))!==false) {
                                    $CurrentValueItem = $ParentAssoc[$n];
                                }
                           }

                           if($CurrentValueItem['vname'] != "" || $CurrentValueItem['vimage'] != "" || $CurrentValueItem['vcomments'] != "") {
                                if(!empty($CurrentValueItem['vname']))
                                    $value = $CurrentValueItem['vname'];

                                if(!empty($CurrentValueItem['vimage'])) {
                                    $file = realpath(ISC_BASE_PATH.'/' . GetConfig('ImageDirectory') . '/' . $CurrentValueItem['vimage']);
                                    if(file_exists($file))
                                    $GLOBALS['HoverImage'] = $this->path."/". GetConfig('ImageDirectory')."/".$CurrentValueItem['vimage'];
                                }
                                $GLOBALS['Comments'] =  $CurrentValueItem['vcomments']; 
                           }

						   /*-------------- Below code is used to cehck comments in subcategory and main category Ends ------------ */

							if(isset($params['dynfilters'][$columns[$u]]) && !empty($params['dynfilters'][$columns[$u]])) {

                                $dyn_flag = 1;
                                $query_string_mod_array = $query_string_array;
                                //*$query_string_mod_array[$columns[$u]]= "";
                                
                                //$query_string_new1 = $query_string_new;
								//*$query_string_new1 = "redefine_filters.php?";
								$query_string_new1 = "";
								$qualifierclearurl = "search.php?";
                                foreach($query_string_mod_array as $qs_key => $qs_val) {
                                   //*if($query_string_new1 != $query_string_new) 
								   if(!empty($query_string_new1))
                                   $query_string_new1 .= "&";

								   if($qs_key != "search_query")
                                   $qs_val = MakeURLSafe($qs_val);
                                   
                                   $query_string_new1 .= $qs_key."=".$qs_val;

								   if($qs_key != $columns[$u]) {
                                       if($qualifierclearurl != "search.php?")
                                            $qualifierclearurl .= "&";
                                   
                                       $qualifierclearurl .= $qs_key."=".$qs_val;
                                   }

                                }
								$get_qualifier_links = $this->GetOtherLinks($params,$columns[$u]);
								if($GLOBALS['EnableSEOUrls'] == 1)
								{
									$qualifierclearurl = $this->path.$get_mmy_links.$get_qualifier_links;
								} else {
									$qualifierclearurl = $this->path."/search.php?search_query=".$get_mmy_links.$get_qualifier_links;
								}
                                if(strtolower($original_value) == strtolower($params['dynfilters'][$columns[$u]])) {
								$GLOBALS['ClearURL'] = "<a href='$qualifierclearurl'>Clear</a>";
                                $dyn_filter .= "<li><img src='$this->path/templates/default/images/check.gif'>&nbsp;&nbsp;".ucwords($value)."</li>";
                                //*$dyn_filter .= "<li><a class='thickbox' href='$query_string_new1&column=$columns[$u]'><b>Redefine search...</b></a></li>";                   
   
								$str = "$query_string_new1&column=".strtolower($columns[$u]); 
								$str .=	$add_url_redefine;
								break;
                                }
                            
                            } else {
                                $dyn_flag = 0;
                                $query_string_mod_array = $query_string_array;
                                $query_string_new1 = $query_string_new."search_query=".$query_string_mod_array['search_query'];
								unset($query_string_mod_array['search_query']);
                                
                                //if(array_key_exists($columns[$u],$query_string_mod_array)) {
                                  //$query_string_mod_array[$columns[$u]] = $original_value;
                                //} 
                                
                                foreach($query_string_mod_array as $qs_key => $qs_val) {
                                   if($query_string_new1 != $query_string_new) 
                                   $query_string_new1 .= "&";

								   if($qs_key != "search_query")
                                   $qs_val = MakeURLSafe($qs_val); 
                                   
                                   $query_string_new1 .= $qs_key."=".$qs_val;
                                }
								//$GLOBALS['ClearURL'] = $query_string_new1;
								$GLOBALS['ClearURL'] = "";
								if($GLOBALS['EnableSEOUrls'] == 1)
								{
									$query_string_new1 = "/".strtolower($columns[$u])."/".MakeURLSafe(strtolower($original_value));    // this is added to pass the listing value
									$GLOBALS['QualifierLink'] = $this->path.$get_mmy_links.$get_all_param_links.$query_string_new1;
								} else {
									$query_string_new1 = "&".strtolower($columns[$u])."=".MakeURLSafe(strtolower($original_value));    // this is added to pass the listing value
									$GLOBALS['QualifierLink'] = $this->path."/search.php?search_query=".$get_mmy_links.$get_all_param_links.$query_string_new1;
								}
								$GLOBALS['QualifierId'] = $Qualifier_id;
                                $GLOBALS['QualifierValue'] = ucwords($value);
                                $GLOBALS['QualifierCount'] = $countfilterdata[$columns[$u]][$original_value]['count'];
                                //$dyn_filter .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideProductFilterValuesHoverImage"); 
                                //$dyn_filter .= "<li><a href='$query_string_new1'>".$value."</a> (".$countfilterdata[$columns[$u]][$value]['count'].")</li>";

								if($count_pqvq < 11)
                                    $dyn_filter .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideProductFilterValuesHoverImage");
                                else
                                    $extra .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideProductFilterValuesHoverImage");

								$count_pqvq++;

                            }
                            
                            
                        }
						$dyn_filter = "<ul>".$dyn_filter."</ul>";
                        if($count_pqvq > 11) {
                           $GLOBALS['FilterID'] = $GLOBALS['dynid'];
                           $GLOBALS['ExtraValues'] = $extra;
                           $dyn_filter .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideFilterMoreLink");
                        }
                        
						if($dyn_flag == 1) {
                           //$str = "search_query=".$links.$model_link."&column=model";
                            $GLOBALS['Dyndisplay1'] = "showlist"; 
                            $GLOBALS['Dyndisplay'] = "hidelist";
                            $GLOBALS['Dynimage'] = "imgHdrDropDownIconright.gif";
							$GLOBALS['DynFilterArrow'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideProductFilterImage"); 
                            $GLOBALS['DynmenuFilter1'] = $dyn_filter;
                            $GLOBALS['DynmenuFilter'] = "";
                            $GLOBALS['JSfunction'] = "getvalueswithajax('".$GLOBALS['dynid']."','$str');checkanimate('".$GLOBALS['dynid']."')"; 
                           //$GLOBALS['Dynimage'] = "imgHdrDropDownIconright.gif";
                        }
                        else {
                            $GLOBALS['Dyndisplay1'] = "hidelist";
                            $GLOBALS['Dyndisplay'] = "showlist";
                            $GLOBALS['Dynimage'] = "imgHdrDropDownIcon.gif";
							$GLOBALS['DynFilterArrow'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideProductFilterImage"); 
                            $GLOBALS['DynmenuFilter'] = $dyn_filter;
                            $GLOBALS['DynmenuFilter1'] = "";
                            $GLOBALS['JSfunction'] = "checkanimate('".$GLOBALS['dynid']."')"; 
                        }
                        
						/* Filter Title related assiciation */ 
                        $CurrentItem = $qvalue_mapping_array[0];
                        if($CurrentItem['qimage']=="" && $CurrentItem['qcomments']=="" && $CurrentItem['qname']=="")    {
                             $CurrentItem = $ParentAssoc[0];
                        }
                         
						if(isset($CurrentItem['qname']) && !empty($CurrentItem['qname']))
                        $GLOBALS['Dynmainmenu'] = $CurrentItem['qname'];
                        else 
                        $GLOBALS['Dynmainmenu'] = $title;

                        $mover_comment = "";
						if(isset($CurrentItem) && !empty($CurrentItem['qcomments']))
						    $mover_comment = $CurrentItem['qcomments'];

                        $mover_image = "";
                        if(isset($CurrentItem['qimage']) && !empty($CurrentItem['qimage'])) {
                            $file = realpath(ISC_BASE_PATH.'/' . GetConfig('ImageDirectory') . '/' . $CurrentItem['qimage']);
							if(file_exists($file))
                            $mover_image = $GLOBALS['SITEPATH']."/". GetConfig('ImageDirectory')."/".$CurrentItem['qimage'];
                        }

                        $GLOBALS['MouseoverFn'] = "loadHoverImage(event, '".$mover_image."', '".$mover_comment."');";
                        $GLOBALS['MouseoutFn'] = "hideTip();";
                        $dyn_output = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideProductDynFilter");  
                             
                        //$dyn_filter .=  $filter3;
                        if($dyn_flag == 1) {
                        $dyn_bottom .= $dyn_output; 
                        } else {
                        $dyn_top .= $dyn_output;
                        }
                        $dyn_filter = "";
                        //$dyn_filter .=  $filter3;
                        
                  }
                  
                }
             }
             
                        
			$dyn_filter =  $dyn_top.$dyn_bottom;
             
             /* form action */
            $qry_string = $_SERVER['QUERY_STRING'];
            if(isset($_REQUEST['page'])) {
                $page = $_REQUEST['page'];
                $search_link = str_ireplace('&page='.$page,'',$qry_string);
            } else {
                $search_link = $qry_string;
            }
            
            $GLOBALS['formaction'] = "search.php?".$search_link;
             
             
        } else {       
            $GLOBALS['HideSideProductFiltersPanelPrice'] = "none";  
        }

		$dyn_filter =  $dyn_top.$dyn_bottom; 

		$GLOBALS['DynFilter'] = $dyn_filter;
        
        if(!isset($params['flag_srch_category']) || $params['flag_srch_category'] == 0 || !eregi('search.php',$_SERVER['REQUEST_URI']) )
            $GLOBALS['HideSideProductFiltersPanelPrice'] = "none";
		else
            $GLOBALS['HideSideProductFiltersPanelPrice'] = "block";

        $GLOBALS['FromPrice'] = "0.00";
        if(isset($_REQUEST['price_from']))
             $GLOBALS['FromPrice'] = $_REQUEST['price_from'];  
                
        if(isset($_REQUEST['price_to']))                
             $GLOBALS['ToPrice'] = $_REQUEST['price_to'];   

               
        if(empty($output1) && empty($output2) && empty($output)) {
            $this->DontDisplay = true;
        }
                    
		/*$output = $GLOBALS['ISC_CLASS_TEMPLATE']->ParseSnippets($output, $GLOBALS['SNIPPETS']);
		$GLOBALS['SNIPPETS']['SideProductFilter1'] = $output;*/
	}

	function GetCategoryListing($catgids , $catgcount, $str_link, $numrows)
    {
        $GLOBALS['ISC_CategoryBrandCache'] = GetClass('ISC_CACHECATEGORYBRANDS');
	    $cachedCategoryBrands = $GLOBALS['ISC_CategoryBrandCache']->getCategoryBrandsData();
	    $ValidCats = $GLOBALS['ISC_CategoryBrandCache']->GetValidCategories($cachedCategoryBrands);
	    
        $categories = $GLOBALS['ISC_CLASS_DATA_STORE']->Read('RootCategories');
        $path = $this->path;
        $catg_selected = "";
        $catg_id_selected = "";
		$is_mmy_selected = 0; // this var is used to check whether all mmy is selected or not. 0 for not selected and 1 for selected.  
        if(isset($GLOBALS['ISC_SRCH_CATG_ID']) && isset($GLOBALS['ISC_SRCH_CATG_NAME'])) {    // this condition is when any main category is selected from the side bar
            $catg_id_selected = $GLOBALS['ISC_SRCH_CATG_ID'];
            $catg_selected = $GLOBALS['ISC_SRCH_CATG_NAME'];
        }
        $catg_list = array();
        $catg_count_list = array();
        $catg_qry = "select categoryid , catparentid from [|PREFIX|]categories";
        $catg_res = $GLOBALS['ISC_CLASS_DB']->Query($catg_qry); 
        while($catg_row = $GLOBALS['ISC_CLASS_DB']->Fetch($catg_res)) 
        {
           $catg_list[$catg_row['categoryid']] =  $catg_row['catparentid'];
        }
        //print_r($catgcount);
        for($j=0;$j<count($catgids);$j++)
        {
            $id = $catgids[$j];
            
            if(!isset($catg_count_list[$id]))
            $catg_count_list[$id] = 0;
            
            if( isset($catg_list[$id]) && $catg_list[$id] == 0) {
                $catg_count_list[$id] += $catgcount[$id]['count'];
            } else {
                
                if(!isset($catg_count_list[$catg_list[$id]]))
                $catg_count_list[$catg_list[$id]] = 0;
                               
                $catg_count_list[$catg_list[$id]] += $catgcount[$id]['count'];
                
            }
        }
        
		$output = '';
       
       #####################################################################################
            $dept = array();
            $cat_dept = array();
            $cat_department = array();
            /*$cat_dept_qry = "select categoryid , catdeptid , deptname from [|PREFIX|]categories c left join [|PREFIX|]department d on d.deptid = c.catdeptid where catparentid = 0 and catvisible = 1 order by deptname asc, catdeptid desc, catname";
            $cat_dept_res = $GLOBALS['ISC_CLASS_DB']->Query($cat_dept_qry);*/
            $CatsDepts = $GLOBALS['ISC_CategoryBrandCache']->GetCatDepts($cachedCategoryBrands);
            //while($cat_dept_row = $GLOBALS['ISC_CLASS_DB']->Fetch($cat_dept_res)) {
        	foreach ($CatsDepts as $cat_dept_row){
                //$cat_department[$cat_dept_row['categoryid']]['catdeptid'] = $cat_dept_row['deptname'];
                $dept[$cat_dept_row['catdeptid']] = $cat_dept_row['deptname'] ;
                $cat_dept[$cat_dept_row['categoryid']] = $cat_dept_row['catdeptid'];
                if(isset($categories[0][$cat_dept_row['categoryid']]))
                $categories[0][$cat_dept_row['categoryid']]['catdeptid'] = $cat_dept_row['catdeptid'];
            }
            //arsort($cat_dept);
            foreach($cat_dept as $key => $value) {
               if(isset($categories[0][$key])) 
               $cat_department[0][$key] = $categories[0][$key];
            }
            $categories = $cat_department;

            $mmy_links = "";
            //if(isset($GLOBALS['ISC_CLASS_ABTESTING'])) {
            $params = $this->searchterms;
            unset($params['subcategory'],$params['category']);
			$params_catg = $params;
			
			//$GLOBALS['ClearURL'] = "$path/search.php?search_query=".urlencode($params['search_query']).$mmy_links;
			$GLOBALS['ClearURL'] = "";

			/* checked whether all MMY are selected */
            if( isset($params['make']) && isset($params['year']) && isset($params['model']) && ( !isset($params['model_flag']) || ( isset($params['model_flag']) && $params['model_flag'] == 1 ) ) )
            $is_mmy_selected = 1;
            
            $GLOBALS['CategoryJSFunction'] = "getvalueswithajax('all_category','$str_link&categories=$catg_id_selected');checkanimate('all_category')";
            
            //}
			//$GLOBALS['ISC_CLASS_VALID_CATEGORIES'] = GetClass('ISC_VALID_CATEGORY');  
            //$GLOBALS['ISC_CLASS_VALID_CATEGORIES']->_ProcessCategories($categories);
             
            if(empty($catg_selected)) { // this condition is used to show all categories   
				$iscategorycount = 0;
				if(isset($params['brand']) || $numrows == 0)	{
					$iscategorycount = 1;
				}
				unset($params['brand'],$params['series'],$params_catg['brand'],$params_catg['series']);

				if(isset($params['brand'])) {
					unset($params_catg['brand']);
				}
				$mmy_links = $this->GetYMMLinks($params_catg);
				$mmy_links .= $this->GetOtherLinks($params_catg);
				
                $GLOBALS['contentid'] = "all_category";
                if(isset($GLOBALS['CategoryJSFunction']))
                $GLOBALS['arrowimage'] = "<img src='$path/templates/default/images/imgHdrDropDownIcon.gif' border='0' id='all_categoryimage'>";
                $temp_dept = "";
                foreach($categories[0] as $rootCat) {
                    // If we don't have permission to view this category then skip
                    if(!CustomerGroupHasAccessToCategory($rootCat['categoryid'])) {
                        continue;
                    }
                    
                	if(!in_array($rootCat['categoryid'],$ValidCats))
					{
						continue;
					}

					/*if(!isset($GLOBALS['ISC_CLASS_VALID_CATEGORIES']->_newcategoryids[$rootCat['categoryid']]))// not displaying the catg which are having zero products from main catg listing
                    continue;*/
                    
                    if($temp_dept != $rootCat['catdeptid']) {
                     if(!empty($temp_dept))
                     $output .= "</ul>";
                     if(!empty($dept[$rootCat['catdeptid']]))
                     $GLOBALS['deptname'] = $dept[$rootCat['catdeptid']];
                     else
                     $GLOBALS['deptname'] = "Other Departments";
                     
                     $GLOBALS['deptid'] = "dept".$rootCat['catdeptid'];
                     
                     $output .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("CategoryDepartment");
                     $output .= "<ul id='".$GLOBALS['deptid']."'>";   
                     //$output .= "<ul><li style='background-color: rgb(255, 15, 25);font-size:12px'>".$dept[$rootCat['catdeptid']]."</li></ul><ul>";
                     $temp_dept = $rootCat['catdeptid'];
                    }

                    //$GLOBALS['SubCategoryList'] = $this->GetSubCategory($categories, $rootCat['categoryid']);
                    $GLOBALS['LastChildClass']='';
                    $GLOBALS['CategoryName'] = isc_html_escape($rootCat['catname']);
                    
					$RootCatName = $rootCat['catname'];
					//$GLOBALS['CategoryLink'] = $this->LeftCatLink($RootCatName).$mmy_links;
					if(isset($params['brand'])) {
						$RootCatName = $params['brand'];
						if($GLOBALS['EnableSEOUrls'] == 1)
							$GLOBALS['CategoryLink'] = $this->LeftCatLink($RootCatName).$mmy_links."/category/".strtolower(MakeURLSafe($rootCat['catname']));
						else
							$GLOBALS['CategoryLink'] = $this->LeftCatLink($RootCatName).$mmy_links."&category=".strtolower(MakeURLSafe($rootCat['catname']));

					} else {
						$RootCatName = $rootCat['catname'];
						$GLOBALS['CategoryLink'] = $this->LeftCatLink($RootCatName).$mmy_links;						
					}

                    if(!isset($catg_count_list[$rootCat['categoryid']]))
                    $catg_count_list[$rootCat['categoryid']] = 0;

					$GLOBALS['LastChildClass'] = "";
                    if($catg_count_list[$rootCat['categoryid']] > 0)
                    $GLOBALS['LastChildClass'] = "validcatg";

					//if( isset($params['brand']) || $is_mmy_selected == 1 )
					if( $iscategorycount == 0)
                    $GLOBALS['CategoryCount'] = "(".$catg_count_list[$rootCat['categoryid']].")";  
                         
                    $output .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideCategoryList");

                }
                    $output .= "</ul>";
                
            } else {       // this condition has been added for showing only selected category
					
					$brand_selected = "";
					if(isset($params_catg['brand'])) {
						$brand_selected = MakeURLSafe(strtolower($params_catg['brand']));
						unset($params_catg['brand']);
					}

					$mmy_links = $this->GetYMMLinks($params_catg);
					if($GLOBALS['EnableSEOUrls'] == 1)
					{
					   $catg_clear_urls = "$path";
					   /*if($brand_selected != "")
							$catg_clear_urls .= "/".$brand_selected;*/
					}
					else
					{
						$catg_clear_urls = "$path/search.php?search_query=";
						if($brand_selected != "")
							$catg_clear_urls .= $brand_selected;
						else
							$catg_clear_urls .= "categories";

						if($mmy_links == "")
							$catg_clear_urls = "$path/";
					}
					
					if(!empty($mmy_links)) {
						$catg_clear_urls .= $mmy_links;
					}
					$GLOBALS['ClearURL'] = "<a href='$catg_clear_urls'>Clear</a>";

                    $GLOBALS['arrowimage'] = "<img src='$path/templates/default/images/imgHdrDropDownIconright.gif' id='all_categoryimage'>";
                    //$GLOBALS['Dynimage'] = "/store/templates/default/images/.gif";
                    //$GLOBALS['SubCategoryList'] = $this->GetSubCategory($categories, $catg_id_selected);
                    $GLOBALS['LastChildClass']='';
                    $GLOBALS['CategoryName'] = "<img src='$path/templates/default/images/check.gif'>&nbsp;&nbsp;".isc_html_escape($catg_selected);

                    //$GLOBALS['CategoryLink'] = "#";
                    $GLOBALS['CategoryLink'] = $mmy_links;
                    $output .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideCategoryList1");
                    $output .= "</ul></div><div id='all_category' class='BlockContent hidelist'>";
                    $temp_dept = "";
                    /*foreach($categories[0] as $rootCat) {
                        // If we don't have permission to view this category then skip
                        if(!CustomerGroupHasAccessToCategory($rootCat['categoryid'])) {
                            continue;
                        }
                        
                        if($temp_dept != $rootCat['catdeptid']) {
                             if(!empty($temp_dept))
                             $output .= "</ul>";
                             if(!empty($dept[$rootCat['catdeptid']]))
                             $GLOBALS['deptname'] = $dept[$rootCat['catdeptid']];
                             else
                             $GLOBALS['deptname'] = "Other Departments";
                             
                             $GLOBALS['deptid'] = "dept".$rootCat['catdeptid'];
                             
                             $output .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("CategoryDepartment");
                             $output .= "<ul id='".$GLOBALS['deptid']."'>";   
                             //$output .= "<ul><li style='background-color: rgb(255, 15, 25);font-size:12px'>".$dept[$rootCat['catdeptid']]."</li></ul><ul>";
                             $temp_dept = $rootCat['catdeptid'];
                        }

                        if($catg_selected != $rootCat['catname'])  {   // not displaying the selected category again
                        //$GLOBALS['SubCategoryList'] = $this->GetSubCategory($categories, $rootCat['categoryid']);
                        $GLOBALS['LastChildClass']='';
                        $GLOBALS['CategoryName'] = isc_html_escape($rootCat['catname']);
                        //if(eregi('search.php',$_SERVER['REQUEST_URI']))
                        //echo $_SERVER['REQUEST_URI'];
                        $GLOBALS['CategoryLink'] = "$path/search.php?search_query=".urlencode($rootCat['catname'])."$mmy_links";
                        //else
                        //$GLOBALS['CategoryLink'] = CatLink($rootCat['categoryid'], $rootCat['catname'], true);
                        $output .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideCategoryList");
                        }
                    }*/
            }
			$GLOBALS['SearchCategoryList'] =  $output;
       #####################################################################################
           
			$output = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SearchCategoryList");
            
            return  $output;
    }

	public function GetAssocDetails($CategoryId, $QualifierId, &$OwnAssoc, &$ParentAssoc, &$OwnValue, &$ParentValue)   {
    
		$OwnAssoc       = array();
        $ParentAssoc    = array(); 
        $OwnValue       = array();   
        $ParentValue    = array();     
        $own_assoc_query = 
            "SELECT qa.displayname qname, qa.hoverimage qimage, qa.comments qcomments, 
            qvalue, 
            qv.displayname vname , qv.hoverimage vimage, qv.comments vcomments 
            FROM [|PREFIX|]qualifier_associations qa 
            LEFT JOIN  [|PREFIX|]qvalue_associations qv on qa.associd = qv.associd 
            WHERE 
            qualifierid = ".$QualifierId." and qa.categoryid = ".$CategoryId." and qa.qualifier_visible = 1 ";
            
        $own_assoc_result = $GLOBALS['ISC_CLASS_DB']->Query($own_assoc_query);
        
        while($own_assoc_row = $GLOBALS['ISC_CLASS_DB']->Fetch($own_assoc_result)) {
             $OwnAssoc[] = $own_assoc_row;
             $OwnValue[] = strtolower($own_assoc_row['qvalue']);
        }
            
        //Parent category details
        $parcatid_query = "select catparentid from [|PREFIX|]categories WHERE categoryid='".$CategoryId."'";
        $parcatid_result = $GLOBALS['ISC_CLASS_DB']->Query($parcatid_query);   
        $ParentCatId = $GLOBALS['ISC_CLASS_DB']->FetchOne($parcatid_result);
        
        if($ParentCatId != 0)    {       
            $parent_assoc_query = 
                "SELECT qa.displayname qname, qa.hoverimage qimage, qa.comments qcomments, 
                qvalue, 
                qv.displayname vname , qv.hoverimage vimage, qv.comments vcomments 
                FROM [|PREFIX|]qualifier_associations qa 
                LEFT JOIN  [|PREFIX|]qvalue_associations qv on qa.associd = qv.associd 
                WHERE 
                qualifierid = ".$QualifierId." and qa.categoryid = ".$ParentCatId." and qa.qualifier_visible = 1 ";
                
            $parent_assoc_result = $GLOBALS['ISC_CLASS_DB']->Query($parent_assoc_query);
            if($GLOBALS['ISC_CLASS_DB']->CountResult($parent_assoc_result) > 0) {
				while($parent_assoc_row = $GLOBALS['ISC_CLASS_DB']->Fetch($parent_assoc_result)) {
					 $ParentAssoc[]     = $parent_assoc_row;
					 $ParentValue[]     = strtolower($parent_assoc_row['qvalue']);
				}  
			} else {
				$ParentAssoc[0] = array();
			}
        } else {
				$ParentAssoc[0] = array();
		}
        
    }


	/**
	 * @desc Create Category links
	 * @params Rootcatname
	 */
	 function LeftCatLink($RootCatName)
	 {
		$NewLink = '';
		if ($GLOBALS['EnableSEOUrls'] == 1) {
			$NewLink = sprintf("%s/%s", $this->path, MakeURLSafe(strtolower($GLOBALS['PathInfo'][1]))."/category/".MakeURLSafe(strtolower($RootCatName)));
		} else {
			$NewLink = sprintf("%s/search.php?search_query=%s", GetConfig('ShopPath'), MakeURLSafe($RootCatName));
		}
		return $NewLink;
	 }

	 /**
	 * @desc Create links for the left navigations links
	 * @params $mmy_links , $filter, $value
	 */
	 function LeftLink($mmy_links , $filter, $value)
	 {
		$NewLink = '';
		if ($GLOBALS['EnableSEOUrls'] == 1) {
			$NewLink = sprintf("%s%s/%s/%s", $this->path, $mmy_links, $filter, MakeURLSafe(strtolower($value)));
		} else {
			$NewLink = sprintf("%s/search.php?search_query=%s&%s=%s", $this->path, $mmy_links, $filter, MakeURLSafe($value));
		}
		return $NewLink;
	 }

	  /**
	 * @desc Create Category links
	 * @params $link
	 */
	 function LeftClearLink($link)
	 {
		$NewLink = '';
		if ($GLOBALS['EnableSEOUrls'] == 1) {
			$NewLink = sprintf("%s%s", $this->path, $link);
		} else {
			if($link != "")
				$NewLink = sprintf("%s/search.php?search_query=%s", GetConfig('ShopPath'), $link);
			else
				$NewLink = sprintf("%s/", GetConfig('ShopPath'));
		}
		return $NewLink;
	 }

	 /**
	 * @desc Create YMM links
	 * @params search paramsters
	 */
	 function GetYMMLinks($params)
	 {
		$NewLink = '';

		if ($GLOBALS['EnableSEOUrls'] == 1) {
			if(isset($params['make']) && !empty($params['make']))
			$NewLink .= "/make/".MakeURLSafe(strtolower($params['make']));
			if(isset($params['model']) && !empty($params['model']))
			$NewLink .= "/model/".MakeURLSafe(strtolower($params['model']));
			if(isset($params['model_flag']) && $params['model_flag'] == 0)
			$NewLink .= "/model_flag/".$params['model_flag'];
			if(isset($params['submodel']) && !empty($params['submodel']))
			$NewLink .= "/submodel/".MakeURLSafe(strtolower($params['submodel']));
			if(isset($params['year']) && !empty($params['year']))
			$NewLink .= "/year/".$params['year'];
			if(isset($params['category']) && !empty($params['category']))
			$NewLink .= "/category/".MakeURLSafe(strtolower($params['category']));
			if(isset($params['brand']))
			$NewLink .= "/brand/".MakeURLSafe(strtolower($params['brand']));
			if(isset($params['subcategory']))
			$NewLink .= "/subcategory/".MakeURLSafe(strtolower($params['subcategory']));
			if(isset($params['series']))
			$NewLink .= "/series/".MakeURLSafe(strtolower($params['series']));
			if(isset($params['searchtext']))
			$NewLink .= "/searchtext/".MakeURLSafe(strtolower($params['searchtext']));
			if(isset($params['search']))
			$NewLink .= "/searchtext/".MakeURLSafe(strtolower($params['search']));
			if( isset($params['vqsbedsize']) )
			{
				$NewLink .= "/vqsbedsize/".MakeURLSafe(strtolower($params['vqsbedsize']));
			}
			if( isset($params['vqscabsize']) )
			{
				$NewLink .= "/vqscabsize/".MakeURLSafe(strtolower($params['vqscabsize']));
			}
		} else {
			if(isset($params['make']) && !empty($params['make']))
			$NewLink .= "&make=".MakeURLSafe($params['make']);
			if(isset($params['model']) && !empty($params['model']))
			$NewLink .= "&model=".MakeURLSafe($params['model']);
			if(isset($params['model_flag']) && $params['model_flag'] == 0)
			$NewLink .= "&model_flag=".$params['model_flag'];
			if(isset($params['submodel']) && !empty($params['submodel']))
			$NewLink .= "&submodel=".MakeURLSafe($params['submodel']);
			if(isset($params['year']) && !empty($params['year']))
			$NewLink .= "&year=".$params['year'];
			if(isset($params['category']) && !empty($params['category']))
			$NewLink .= "&category=".MakeURLSafe(strtolower($params['category']));
			if(isset($params['brand']))
			$NewLink .= "&brand=".MakeURLSafe($params['brand']);
			if(isset($params['subcategory']))
			$NewLink .= "&subcategory=".MakeURLSafe($params['subcategory']);
			if(isset($params['series']))
			$NewLink .= "&series=".MakeURLSafe($params['series']);
			if(isset($params['searchtext']))
			$NewLink .= "&searchtext=".MakeURLSafe(strtolower($params['searchtext']));
			if(isset($params['search']))
			$NewLink .= "&searchtext=".MakeURLSafe(strtolower($params['search']));
			if( isset($params['vqsbedsize']) )
			{
				$NewLink .= "&vqsbedsize=".MakeURLSafe(strtolower($params['vqsbedsize']));
			}
			if( isset($params['vqscabsize']) )
			{
				$NewLink .= "&vqscabsize=".MakeURLSafe(strtolower($params['vqscabsize']));
			}
		}

		return $NewLink;
	 }

	 /**
	 * @desc Create all paramters into links
	 * @params search paramsters, qualifier title
	 */
	 function GetOtherLinks($params,$qualifier = -1)
	 {

		$NewLink = '';
		if( isset($params['dynfilters']) )
		{
			if ($GLOBALS['EnableSEOUrls'] == 1) {
				foreach($params['dynfilters'] as $key => $value) {
					if($qualifier != $key)
					$NewLink .= "/".strtolower($key)."/".MakeURLSafe(strtolower($value));
				}
			} else {
				foreach($params['dynfilters'] as $key => $value) {
					if($qualifier != $key)
					$NewLink .= "&".strtolower($key)."=".MakeURLSafe(strtolower($value));
				}
			}
		}
		return $NewLink;
	 }

	 /**
	 * @desc Create all paramters into links in non seo way only for redefine search
	 * @params search paramsters
	 */
	 function GetOtherLinksForRedefine($params)
	 {
		$NewLink = '';
		foreach($params['dynfilters'] as $key => $value) {
			$NewLink .= "&".strtolower($key)."=".MakeURLSafe(strtolower($value));
		}
		return $NewLink;
	 }

	 /**
	 * @desc Create filters below paramters into links
	 * @params search paramsters, qualifier title
	 * $mmy = 1 -> clear all filters below other than mmy
	 * $mmy = 0 -> clear mmy filters
	 */
	 function GetClearFilterlink($params,$mmy)
	 {

		$NewLink = '';

		if ($GLOBALS['EnableSEOUrls'] == 1) 
		{	
			if($mmy == 1)	// for clear all filters other than mmy
			{
				if(isset($params['make']) && !empty($params['make']))
					$NewLink .= "/make/".MakeURLSafe(strtolower($params['make']));
				if(isset($params['model']) && !empty($params['model']))
					$NewLink .= "/model/".MakeURLSafe(strtolower($params['model']));
                if(isset($params['model_flag']) && $params['model'] == 0)
                    $NewLink .= "/model_flag/".$params['model_flag'];
				if(isset($params['year']) && !empty($params['year']))
					$NewLink .= "/year/".$params['year'];

				if($NewLink == "")
					$NewLink = "/";


			} else {	// for clear mmy filters

				/*if(isset($GLOBALS['ISC_SRCH_CATG_NAME']))
					$NewLink .= "/".MakeURLSafe(strtolower($GLOBALS['ISC_SRCH_CATG_NAME']));
				else if(isset($GLOBALS['ISC_SRCH_BRAND_NAME']))
					$NewLink .= "/".MakeURLSafe(strtolower($GLOBALS['ISC_SRCH_BRAND_NAME']));*/
				
				$NewLink .= "/".MakeURLSafe(strtolower($GLOBALS['PathInfo'][1]));


				if(isset($params['brand']) && $params['brand'] != "" && $NewLink != $params['brand'])
					$NewLink .= "/brand/".MakeURLSafe(strtolower($params['brand']));
				if(isset($params['series']) && $params['series'] != "")
					$NewLink .= "/series/".MakeURLSafe(strtolower($params['series']));
				if(isset($params['subcategory']) && $params['subcategory'] != "")
					$NewLink .= "/subcategory/".MakeURLSafe(strtolower($params['subcategory']));
				
				if($NewLink != "")
					$NewLink .= "";
				else
					$NewLink .= "/";

			}
		} else {
			
			if($mmy == 1)	// for clear all filters other than mmy
			{
				$addLink = "/search.php?search_query=categories";
				if(isset($params['make']) && !empty($params['make']))
					$NewLink .= "&make=".MakeURLSafe(strtolower($params['make']));
				if(isset($params['model']) && !empty($params['model']))
					$NewLink .= "&model=".MakeURLSafe(strtolower($params['model']));
                if(isset($params['model_flag']) && $params['model'] == 0)
                    $NewLink .= "&model_flag=".$params['model_flag'];
				if(isset($params['year']) && !empty($params['year']))
					$NewLink .= "&year=".$params['year'];

				if($NewLink != "") {
					$NewLink = $addLink.$NewLink;
				} else {
					$NewLink = "/";
				}

			
			} else {	// for clear mmy filters
				
				$addLink = "/search.php?search_query=";
				if(isset($GLOBALS['ISC_SRCH_CATG_NAME']))
					$NewLink .= MakeURLSafe(strtolower($GLOBALS['ISC_SRCH_CATG_NAME']));
				else if(isset($GLOBALS['ISC_SRCH_BRAND_NAME']))
					$NewLink .= MakeURLSafe(strtolower($GLOBALS['ISC_SRCH_BRAND_NAME']));

				if(isset($params['brand']) && $params['brand'] != "" && $NewLink != $params['brand'])
					$NewLink .= "&brand=".MakeURLSafe($params['brand']);
				if(isset($params['series']) && $params['series'] != "")
					$NewLink .= "&series=".MakeURLSafe($params['series']);
				if(isset($params['subcategory']) && $params['subcategory'] != "")
					$NewLink .= "&subcategory=".MakeURLSafe($params['subcategory']);


				if($NewLink != "") {
					$NewLink .= "";
					$NewLink = $addLink.$NewLink;
				} else {
					$NewLink .= "/";
				}

			}

		}
		return $NewLink;
	 }


}

?>
