<?php

CLASS ISC_SIDEPRODUCTFILTERS_PANEL extends PANEL
{
	var $cacheable = true;
	var $cacheId = "";
	public $searchterms;
    public $path;
    
    public function __construct()
    {
        
        $this->path = GetConfig('ShopPath'); 
        
        if(isset($GLOBALS['ISC_CLASS_SEARCH'])) {
            $GLOBALS['ISC_CLASS_SEARCH'] = GetClass('ISC_SEARCH');
            $this->searchterms = $GLOBALS['ISC_CLASS_SEARCH']-> _searchterms;
            $_SESSION['searchterms'] = $this->searchterms; // this variable is used to get the search terms in other pages

			if(isset($_REQUEST['sub_category'])) // this is assigned to get the sub catg value in other pages
			$_SESSION['searchterms']['sub_category'] = $_REQUEST['sub_category'];
			else
			unset($_SESSION['searchterms']['sub_category']);

			if(isset($_REQUEST['brand_series'])) // this is assigned to get the brand series value in other pages
			$_SESSION['searchterms']['brand_series'] = $_REQUEST['brand_series'];
			else
			unset($_SESSION['searchterms']['brand_series']);
            
            if(isset($GLOBALS['v_cols']))
            $_SESSION['v_cols'] =  $GLOBALS['v_cols'];
            else
            unset($_SESSION['v_cols']);
            
            if(isset($GLOBALS['p_cols']))
            $_SESSION['p_cols'] = $GLOBALS['p_cols'];
            else
            unset($_SESSION['p_cols']);
            
            if(isset($GLOBALS['ISC_SRCH_CATG_NAME']))
            $_SESSION['catg_name'] = $GLOBALS['ISC_SRCH_CATG_NAME'];
            else
            unset($_SESSION['catg_name']);
            //$GLOBALS['ISC_CLASS_SEARCH']->HandlePage();
        } else if(isset($_SESSION['searchterms'])) {

			if(!isset($_SESSION['searchterms']['dynfilters']))
				$_SESSION['searchterms']['dynfilters'] = array();

            $this->searchterms = $_SESSION['searchterms'];
            $GLOBALS['v_cols'] = isset($_SESSION['v_cols']) ? $_SESSION['v_cols'] : array();
            $GLOBALS['p_cols'] = isset($_SESSION['p_cols']) ? $_SESSION['p_cols'] : array();
            
            if(isset($_SESSION['catg_name']))
                $GLOBALS['ISC_SRCH_CATG_NAME'] = $_SESSION['catg_name'];
            
            if(isset($this->searchterms['srch_category']))
                $GLOBALS['ISC_SRCH_CATG_ID'] = $this->searchterms['srch_category'][0];

			if(isset($_SESSION['searchterms']['sub_category']))
				$_GET['sub_category'] = $_SESSION['searchterms']['sub_category'];

			if(isset($_SESSION['searchterms']['brand_series'])) {
				$_GET['brand_series'] = $_SESSION['searchterms']['brand_series'];
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
		if(isset($params['brand_series']) && !empty($params['brand_series']))
		$_SESSION['searchterms']['brand_series'] = $params['brand_series'];
        
        // Build the search query using our terms & the fields we want
        
		$column_concat = " p.productid , p.prodcode , group_concat(DISTINCT c.categoryid separator '~') as categoryid, group_concat(DISTINCT prodbrandid separator '~') as prodbrandid ";
		$column_concat .= " , group_concat(DISTINCT v.prodmake separator '~') as prodmake , group_concat(DISTINCT v.prodmodel separator '~') as prodmodel , group_concat(DISTINCT v.prodsubmodel separator '~') as prodsubmodel , group_concat(v.prodstartyear separator '~') as prodstartyear , group_concat(v.prodendyear separator '~') as prodendyear "; 
		
		if(isset($params['catuniversal']) && $params['catuniversal'] == 1) {    // this condition has been added as universal category shd be shown only PQ's 
            
            $column_names = $GLOBALS['p_cols'];
            for($j=0;$j<count($column_names);$j++) 
            {
                $column_concat .=  " , group_concat(DISTINCT ".$column_names[$j]." separator '~') as  ".$column_names[$j];  
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
        
        $searchQueries = BuildProductSearchQuery($this->searchterms);
		$searchQueries['query'] = str_replace('USE INDEX (categoryid)','USE INDEX (PRIMARY)',$searchQueries['query']); 
        //$searchQueries['query'] = str_replace('temp.*',$column_concat,$searchQueries['query']); 
        $searchQueries['query'] = str_replace($GLOBALS['srch_where'],$column_concat,$searchQueries['query']);
        $searchQueries['query'] .= " group by p.productid ";
             
        $Search_Result1 = $GLOBALS['ISC_CLASS_DB']->Query($searchQueries['query']); 
        
        $numrows = $GLOBALS['ISC_CLASS_DB']->CountResult($Search_Result1);
        
        $flag = 0;  // this flag is used to avoid executing query again and again for submodels
        $filterdata = array();         
        $countfilterdata = array();
        $sku = array();
        $count_model['all']['count'] = 0;
        $sub_model_flag = 0;
        $sub_catg = "";

		if(!isset($params['model_flag']) || ( isset($params['model_flag']) && $params['model_flag'] == 1 ) )
                $model_flag_link = 1;
        
        
        $strtocheck = '^(vq|pq)';
            
        if(isset($_REQUEST['sub_category']))
            $sub_catg = "&sub_category=".$_REQUEST['sub_category'];

		if(isset($params['brand_series']))
            $sub_catg .= "&brand_series=".$params['brand_series'];
            
        while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($Search_Result1)) {
            
            $temp_prod_year = array();
            
            $grp_make = explode("~",$row['prodmake']);
                        
            $grp_model = explode("~",$row['prodmodel']);
                        
            if($row['prodsubmodel'] != '~') 
                $grp_submodel = explode("~",$row['prodsubmodel']);
            else
                $grp_submodel = "";
                         
            $grp_startyear = explode("~",$row['prodstartyear']); 
                        
            $grp_endyear = explode("~",$row['prodendyear']);
                        
            $grp_brandid = explode("~",$row['prodbrandid']);

			$grp_categoryid = explode("~",$row['categoryid']);
                        
            $columns = array_keys($row);
            
            foreach($row as $key => $val) {
                if(eregi($strtocheck, $key)) {
                  $grp_dyn = explode('~',$row[$key]);
                  for($g=0;$g<count($grp_dyn);$g++)
                  {
                        $val = strtolower($grp_dyn[$g]);  
                        if(!empty($val)) {
                            
                            $filter_value = explode(";",$val);
                            for($k=0;$k<count($filter_value);$k++)
                            {
                                $val = $filter_value[$k];
                                if(!isset($filterdata[$key])) {
                                    $filterdata[$key][] = $val;
                                    $countfilterdata[$key][$val]['count'] = 1;
                                }
                                else if(!in_array($val,$filterdata[$key])) {
                                    $filterdata[$key][] = $val;
                                    $countfilterdata[$key][$val]['count'] = 1;
                                } else {
                                    $countfilterdata[$key][$val]['count']++;
                                }                               
                            }
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
            
                
            if(isset($params['submodel']) && !empty($params['submodel'])) {
                   $sub_model_flag = 1; 
                   if(!in_array($params['submodel'],$prod_model)) {
                        $prod_model[] =  $params['submodel'];
                        $count_model[$params['submodel']]['count'] = 1;
                   } else {
                       $count_model[$params['submodel']]['count']++;
                   }
                
            }
            else if(isset($params['model']) && !empty($params['model']) && $model_flag_link == 1) {
                 
                 for($g=0;$g<count($grp_submodel);$g++)
                 { 
                    if(!empty($grp_submodel[$g])) {
                       $sub_model_flag = 1; 
                       if(!in_array($grp_submodel[$g],$prod_model)) {
                                $prod_model[] = $grp_submodel[$g];
                                $count_model[$grp_submodel[$g]]['count'] = 1;
                       } else {
                                $count_model[$grp_submodel[$g]]['count']++;
                       }
                    } else if(empty($grp_submodel[$g])) {
                        if(!in_array('ALL',$prod_model)) {
                          $prod_model[] = 'ALL';
                          $count_model['ALL']['count'] = 1;
                        } else
                        $count_model['ALL']['count']++;
                    }
                 }
                    
            } else {
                    
                 for($g=0;$g<count($grp_model);$g++)
                 {
					if(strtolower($grp_model[$g]) != 'all') {   // this condition is added not to show "All" in list
						$sub_model_flag = 1;
						if(!in_array($grp_model[$g],$prod_model)) {                
							$prod_model[] = $grp_model[$g];
							$count_model[$grp_model[$g]]['count'] = 1;
						}
						else
							$count_model[$grp_model[$g]]['count']++;
					}
                 }
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
                                 
        $prod_make_new =  array_unique($prod_make);
        asort($prod_make_new);
        $prod_model_new =  array_unique($prod_model);
        asort($prod_model_new);
        $prod_year_new =  array_unique($prod_year);
        arsort($prod_year_new);
        $srch_qry = isset($params['search_query'])? $params['search_query'] : (isset($params['search_query_adv']) ? $params['search_query_adv'] : '');
		$srch_qry = urlencode($srch_qry);
		$brand_id = array_unique($brand_id);
        $brand_id = array_values($brand_id);
        
        if(isset($params['make']) && !empty($params['make']))
                $make_link = "&make=".urlencode($params['make']);
                
        if(isset($params['year']) && !empty($params['year']))
                $year_link = "&year=".$params['year'];
                
        if(isset($params['model']) && !empty($params['model']))
                $model_link = "&model=".urlencode($params['model']);
		if(isset($params['model_flag']) && $params['model_flag'] == 0)
                $model_link .= "&model_flag=0";
                
        if(isset($params['submodel']) && !empty($params['submodel']))
                $submodel_link = "&submodel=".urlencode($params['submodel']); 
		
		if(isset($params['partnumber']))
        $_GET['partnumber'] = $params['partnumber'];
                
        $query_string_array = $_GET;
		if(isset($params['make']))
        $query_string_array['make'] = $params['make'];
        if(isset($params['model']))
        $query_string_array['model'] = $params['model'];
		if(isset($params['model_flag']) && $params['model_flag'] == 0)
        $query_string_array['model_flag'] = $params['model_flag'];
        if(isset($params['year']))
        $query_string_array['year'] = $params['year'];


		foreach($params['dynfilters'] as $key => $value)
        {
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


		
		if( isset($params['make']) ||  ( isset($params['model']) && $model_flag_link == 1 )  || isset($params['year']) ) {
			$mmy_clear_links = $this->path."/search.php?search_query=".urlencode($params['search_query']);
	
			if(isset($params['brand']))
				$mmy_clear_links .= "&brand=".$params['brand'];

			$GLOBALS['DynMsg'] = "<a href='".$mmy_clear_links."&change=1'>Clear my Vehicle</a>";
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
                            $GLOBALS['BrandName']  =  $value; 
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
                if( !empty($year_link) ) {
                    $links_year .= $year_link;
                if(!empty($make_link))    
                    $links_year .= $make_link;
                if( !empty($model_link) && isset($_REQUEST['model']))   
                    $links_year .= $model_link;
                if( !empty($submodel_link) && isset($_REQUEST['submodel']))   
                    $links_year .= $submodel_link;                    

            }
				if(isset($params['brand']))
					$links_year .= "&brand=".$params['brand'];
				if(isset($params['brand_series']))
					$links_year .= "&brand_series=".$params['brand_series'];
			
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
               $GLOBALS['JSfunction'] = "getvalueswithajax('".$GLOBALS['dynid']."','$str');checkanimate('".$GLOBALS['dynid']."')"; 
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
                    $GLOBALS['JSfunction'] .= ";getvalueswithajax('".$GLOBALS['dynid']."','$str')";
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
                        
                     $GLOBALS['BrandName'] = isc_html_escape($value);

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
					 $GLOBALS['BrandName'] = $params['make'];
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
			$str .= "&brand=".$params['brand'];
		if(isset($params['brand_series']))
			$str .= "&brand_series=".$params['brand_series'];
		$GLOBALS['JSfunction'] = "getvalueswithajax('".$GLOBALS['dynid']."','$str');checkanimate('".$GLOBALS['dynid']."')";
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
        
        /*-------- Model -----------------------------------------*/
            
         if( !empty($make_link) || !empty($model_link) ) { 
             
            $GLOBALS['dynid'] = "prod_model"; 
			$GLOBALS['Dynmainmenu'] = 'Model';
			$output1 = "";
			$display_count = 1;
			$extra = ""; 
            if(count($prod_model_new) > 0 && $sub_model_flag == 1 && ( !isset($params['catuniversal']) || $params['catuniversal'] == 0 ) )     // this condition was added if no submodels exist under a model, then appr msg shd be shown
            {
				$dyn_flag = 0;
                foreach($prod_model_new as $key => $value ) { 
                      
                     if( !empty($model_link) && $model_flag_link == 1 )
                        $GLOBALS['BrandLink'] = "$this->path/search.php?search_query=".$srch_qry.$model_link."&submodel=".urlencode($value);
                     else
                        $GLOBALS['BrandLink'] = "$this->path/search.php?search_query=".$srch_qry."&model=".urlencode($value);                
                        
                        
                     if( !empty($make_link) )
                        $GLOBALS['BrandLink'] .= $make_link;
                        
                     if(!empty($model_link) && !isset($_REQUEST['model'])) // when searched " chevy silverado " and also to revert back to list of silverados
                        $GLOBALS['BrandLink'] .= "&list=".$params['model'];
                     
                     if(!empty($year_link))
                        $GLOBALS['BrandLink'] .= $year_link;
                     
					 $mmy_string_new1 = str_ireplace('&model_flag=0','',$mmy_string_new1); 	
                     $GLOBALS['BrandLink'] .= $mmy_string_new1;
                     
                     $GLOBALS['BrandLink'] .= $sub_catg;
                     
                     $GLOBALS['BrandName'] = isc_html_escape($value);
                     $GLOBALS['BrandCount'] = $count_model[$value]['count'];
                     
                     if(isset($_REQUEST['submodel']) && !empty($_REQUEST['submodel'])) {
					 $dyn_flag = 1;
					 $GLOBALS['BrandName'] =  $_REQUEST['submodel'];
                     //$output1 .= "<li>$_REQUEST[submodel]</li>";
					 $output1 .= "<li></li>";
					 }
                     else {
	                     if($display_count < 11)
                            $output1 .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideProductFilter2");  
                         else
                            $extra .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideProductFilter2");  
                            
                         $display_count++;                            
					 }
                }
                /*if(count($prod_model_new) > 1 && isset($_REQUEST['model']) && !empty($_REQUEST['model']))
                    $output1 .= "<li><a href='".$GLOBALS['BrandLink']."'>ALL</a> (".$count_model['all']['count'].")</li>";*/
                
                $output1 = $GLOBALS['ISC_CLASS_TEMPLATE']->ParseSnippets($output1, $GLOBALS['SNIPPETS']);
             
            } else {
				$dyn_flag = 1;
				$GLOBALS['BrandName'] = "";
                if( isset($params['model']) && ( !isset($params['model_flag']) || $params['model_flag'] == 1 ) ) {
                $GLOBALS['BrandName'] = strtoupper($params['model']);    
                //$output1 = "<li>".strtoupper($_REQUEST['model'])."</li>"; 
                $output1 = "<li></li>"; 
                } 
            }   
            
			$output1 = "<ul>".$output1."</ul>";
			if($display_count > 11) {   
               $GLOBALS['FilterID'] = "model";
               $GLOBALS['ExtraValues'] = $extra;
               $output1 .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideFilterMoreLink");
               //$output .= "<ul class='more'><li><a href=\"javascript:onclick=show_hide('make')\" id='make_more'>More...</a></li></ul>";
            }
			
			$links = "";

            //if( ( !empty($model_link) || !empty($submodel_link) )) {                
                $links =  $srch_qry;
                  
                if(isset($make_link)) {
                    $links .= $make_link;
                }

				if(isset($params['year']))
                    $links .= "&year=".$params['year'];
                
                 
                if(!empty($submodel_link)) {     // only shwing submodel 
                    $links .= $model_link.$submodel_link; 
                }
                else if(isset($_REQUEST['list']))  { // when searched with "chevy silverado", silverado is auto selected as model. For that list is passed as paramater.
                    $links .= "";
                }
                else if(isset($_REQUEST['model']) && !empty($_REQUEST['model'])) {            // submodel listing page 
					$links .= $model_link;
                }
                /*else {
                    $links .= "&model="; 
                    $links .= "&year="; 
                }*/

				$links .= $sub_catg;

				if(isset($params['brand']))
					$links .= "&brand=".$params['brand'];
				if(isset($params['brand_series']))
					$links .= "&brand_series=".$params['brand_series'];

				if(!empty($submodel_link))
                    $links .= "&column=submodel";
                else
                    $links .= "&column=model";
                 
                //*$output1 .= "<li><a class='thickbox' href='redefine_filters.php?search_query=".$links."'><b>Redefine Search...</b></a></li>";
            //}
           
		    /* this below lines are not to display the make when clear is clicked */                            
            if(isset($_REQUEST['change']))
               $GLOBALS['BrandName']  =  "";

			if($dyn_flag == 1 || isset($_REQUEST['change']) ) {
               //*$str = "search_query=".$links;
               $GLOBALS['Dyndisplay1'] = "block"; 
               $GLOBALS['Dyndisplay'] = "none";
               $GLOBALS['Dynimage'] = "imgHdrDropDownIconright.gif";
			   $GLOBALS['DynFilterArrow'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideProductFilterImage");
			   //$GLOBALS['DynFilterArrow'] .= "&nbsp;&nbsp;&nbsp;".$GLOBALS['BrandName'];
               $GLOBALS['DynmenuFilter1'] = $output1;
               $GLOBALS['DynmenuFilter'] = "";
               //*$GLOBALS['JSfunction'] = "getvalueswithajax('".$GLOBALS['dynid']."','$str');checkanimate('".$GLOBALS['dynid']."')"; 
               //$GLOBALS['Dynimage'] = "imgHdrDropDownIconright.gif";
            }
            else {
				$GLOBALS['BrandName'] = "";
                $GLOBALS['Dyndisplay1'] = "none";
                $GLOBALS['Dyndisplay'] = "block";
                $GLOBALS['Dynimage'] = "imgHdrDropDownIconright.gif";
				$GLOBALS['DynFilterArrow'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideProductFilterImage"); 
                //*$GLOBALS['DynmenuFilter'] = $output1;
                $GLOBALS['DynmenuFilter1'] = "";
                //*$GLOBALS['JSfunction'] = "checkanimate('".$GLOBALS['dynid']."')"; 
            }
			$str = "search_query=".$links;
		    $GLOBALS['DynmenuFilter'] = "";
		    $GLOBALS['JSfunction'] = "getvalueswithajax('".$GLOBALS['dynid']."','$str');checkanimate('".$GLOBALS['dynid']."')";
			$GLOBALS['mmyid'] = "mmy_model";
			$dyn_output = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("MyVehicleAreaSearch");
            //$dyn_filter .=  $output1.$filter3;
            $dyn_filter = $dyn_output;

            //$GLOBALS['SNIPPETS']['SideProductFilter2'] = $output1;   
         
        } else {
            $GLOBALS['mousedefaultpointer'] = "mousedefaultpointer";
			$GLOBALS['mmyid'] = "mmy_model";
            $GLOBALS['dynid'] = "prod_model"; 
            $GLOBALS['Dynmainmenu'] = 'Model';
            $GLOBALS['DynmenuFilter'] = "";
            //$GLOBALS['JSfunction'] = "checkanimate('".$GLOBALS['dynid']."')";    
			$GLOBALS['JSfunction'] = "";
            $dyn_output = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("MyVehicleAreaSearch");
            $dyn_filter = $dyn_output;
            //$GLOBALS['HideSideProductFiltersPanelModel'] = "none";     
        }

		if($dyn_flag == 1 && !isset($_REQUEST['change'])) {
        $dyn_top .= $dyn_filter; 
        } else {
        $dyn_top .= $dyn_filter;
        }
        $dyn_filter = "";
        
        
		
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

$dyn_top = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("MyVehicleArea");

/************** Category Listing ********************/
$str = "search_query=".$srch_qry.$make_link.$model_link.$year_link."&column=categories";
$str .= isset($params['brand']) ? "&brand=".$params['brand'] : '';
$str .= isset($GLOBALS['ISC_SRCH_CATG_NAME']) ? "&catg_name=".$GLOBALS['ISC_SRCH_CATG_NAME'] : '';
$dyn_top .= $this->GetCategoryListing($prod_categoryid,$count_categoryid,$str);               


             /*------------ Brand Filter --------------------*/ 
             
if(count($brand_id) > 0 || isset($params['brand'])) {
    $title = "<h2>Brand</h2>";      
    //$dyn_filter .=  $filter1.$title.$filter2;
    $brand_link = "";
	$GLOBALS['dynid'] = "dyn_brand"; 
    $GLOBALS['Dynmainmenu'] = "Brand";  
    $count_brand = 1;
    $extra = "";
    
    $brand_string_array = $query_string_array;
    unset($brand_string_array['brand'],$brand_string_array['brand_series'],$brand_string_array['search_query']);
    $brand_string_new1 = "";
    foreach($brand_string_array as $br_key => $br_val) {
         $brand_string_new1 .= "&".$br_key."=".urlencode($br_val);
    }
    
        
    if(isset($params['brand']) && !empty($params['brand'])) {
       $dyn_flag = 1; 
       $brand_query = "select brandname from [|PREFIX|]brands where brandid = ".$params['brand'];
       $brand_result = $GLOBALS['ISC_CLASS_DB']->Query($brand_query);
       $brand_row = $GLOBALS['ISC_CLASS_DB']->Fetch($brand_result);
       
       $dyn_filter .= <<<P2
        <li><img src='$this->path/templates/default/images/check.gif'>&nbsp;&nbsp;$brand_row[brandname]</li>
P2;
	   if(strtolower($brand_row['brandname']) == strtolower(urldecode($srch_qry))) { // if searched only by brand
       $brandclearurl = "$this->path/search.php?search_query=brands";
	   $str = "search_query=";
	   } else { // if searched with other combinations
	   $search_query = trim(str_ireplace($brand_row['brandname'],'',urldecode($srch_qry)));
       $brandclearurl = "$this->path/search.php?search_query=".urlencode($search_query);
	   $str = "search_query=".urlencode($search_query);
	   }

	   $str .= $brand_string_new1."&brand=".$params['brand']."&column=prodbrandid";
	   
	   if(!empty($brand_string_new1))
	   $brandclearurl .= $brand_string_new1;

	   $GLOBALS['ClearURL'] = "<a href='$brandclearurl'>Clear</a>";	
	   //$dyn_filter .= "<li><a class='thickbox' href='redefine_filters.php?search_query=".$srch_qry.$brand_string_new1."&brand=&column=prodbrandid'><b>Redefine Search...</b></a></li>";
       
    }  else {
       $dyn_flag = 0;
	   $brand_query = "select brandid , brandname from [|PREFIX|]brands where brandid in ( ".implode(",",$brand_id)." ) order by brandname asc ";
	   $brand_result = $GLOBALS['ISC_CLASS_DB']->Query($brand_query);
	   while($brand_row = $GLOBALS['ISC_CLASS_DB']->Fetch($brand_result) )
	   {
			$GLOBALS['BrandName'] = $brand_row['brandname'];
			$search_query = $srch_qry;
		    if(urldecode($srch_qry) == 'brands' || urldecode($srch_qry) == 'categories')
		    $search_query = urlencode($GLOBALS['BrandName']);
			$GLOBALS['BrandLink'] = "$this->path/search.php?search_query=$search_query$brand_string_new1&brand=".$brand_row['brandid'];
			if($count_brand < 11) {
				$dyn_filter .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideProductFilter1");
            } else {
				$extra .=  $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideProductFilter1");
            }
              $count_brand++;
	   }

	   $dyn_filter = "<ul>".$dyn_filter."</ul>";
	   if($count_brand > 11) {
		   $GLOBALS['FilterID'] = "brand";
		   $GLOBALS['ExtraValues'] = $extra;
		   $dyn_filter .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideFilterMoreLink");
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



        /*-------- Other Filters -----------------------------------------*/  
        if( ( !empty($make_link) && ( !empty($model_link) && (!isset($params['model_flag']) || $params['model_flag'] == 1 ) ) && !empty($year_link) ) && ( $numrows > 0 || (isset($_REQUEST['GO']) && $numrows > 0) ) && isset($GLOBALS['ISC_SRCH_CATG_ID']) ) {
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
             
             //$dyn_filter = "";
             for($u=0;$u<count($columns);$u++) {    // loop for the filters . Here columns are the filters.
                if(eregi('^(vq|pq)', $columns[$u])) {   // checking whether the name of the column starts with vq or pq
                    
                  if( isset($filterdata[$columns[$u]]) && count($filterdata[$columns[$u]]) > 0)  {
 
                        $filter_var = array('vq','pq');

						$title = ucfirst(str_ireplace($filter_var,"",$columns[$u]));

						$Qualifier_id = $map_names[$columns[$u]]['qid'];
                        $GLOBALS['CategoryId'] = isset($_REQUEST['sub_category']) ? $_REQUEST['sub_category'] : $GLOBALS['ISC_SRCH_CATG_ID']; 

						$this->GetAssocDetails($GLOBALS['CategoryId'], $Qualifier_id, $OwnAssoc, $ParentAssoc, $OwnValue, $ParentValue);

						$qvalue_mapping_array = $OwnAssoc;

						$GLOBALS['dynid'] = "dyn".($u+1); 
						//$GLOBALS['Dynmainmenu'] = $title;
						$dyn_filter = "";
						$extra = ""; // this is used to hide the values if exceed 10
                        $count_pqvq = 1;
                        //$dyn_filter .=  $filter1.$title.$filter2; 
                         
                        for($k=0;$k<count($filterdata[$columns[$u]]);$k++)       // this loop is for showing the list in the filters column
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

                           if($CurrentValueItem['vname'] != "" && $CurrentValueItem['vimage'] != "" && $CurrentValueItem['vcomments'] != "") {
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
                                   $qs_val = urlencode($qs_val);
                                   
                                   $query_string_new1 .= $qs_key."=".$qs_val;

								   if($qs_key != $columns[$u]) {
                                       if($qualifierclearurl != "search.php?")
                                            $qualifierclearurl .= "&";
                                   
                                       $qualifierclearurl .= $qs_key."=".$qs_val;
                                   }

                                }
                                if(strtolower($original_value) == strtolower($params['dynfilters'][$columns[$u]])) {
								$GLOBALS['ClearURL'] = "<a href='$qualifierclearurl'>Clear</a>";
                                $dyn_filter .= "<li><img src='$this->path/templates/default/images/check.gif'>&nbsp;&nbsp;".ucwords($value)."</li>";
                                //*$dyn_filter .= "<li><a class='thickbox' href='$query_string_new1&column=$columns[$u]'><b>Redefine search...</b></a></li>";
								$str = "$query_string_new1&column=".$columns[$u]; 
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
                                   $qs_val = urlencode($qs_val); 
                                   
                                   $query_string_new1 .= $qs_key."=".$qs_val;
                                }
								//$GLOBALS['ClearURL'] = $query_string_new1;
								$GLOBALS['ClearURL'] = "";
								$query_string_new1 .= "&".$columns[$u]."=".urlencode($original_value);    // this is added to pass the listing value
                                $GLOBALS['QualifierLink'] = $query_string_new1;
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

	function GetCategoryListing($catgids , $catgcount, $str_link)
    {
        
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
                  
        //$output = '<div class="Block CategoryList Moveable" id="SideCategoryList">                    <h2 onclick="%%GLOBAL_CategoryJSFunction%%">%%LNG_ProductsByCategory%% %%GLOBAL_arrowimage%%</h2>                    <div class="BlockContent" id="%%GLOBAL_contentid%%">                        <ul>';
        /*include('/store/includes/display/SideCategoryList.php');
        $categorylist = GetClass('ISC_SIDECATEGORYLIST_PANEL');
        $categorylist->SetPanelSettings();
		$output .= $GLOBALS['SNIPPETS']['SideCategoryList'];*/
		$output = '';
       
       #####################################################################################
            $dept = array();
            $cat_dept = array();
            $cat_department = array();
            $cat_dept_qry = "select categoryid , catdeptid , deptname from [|PREFIX|]categories c left join [|PREFIX|]department d on d.deptid = c.catdeptid where catparentid = 0 and catvisible = 1 order by catdeptid desc, catname";
            $cat_dept_res = $GLOBALS['ISC_CLASS_DB']->Query($cat_dept_qry);
            while($cat_dept_row = $GLOBALS['ISC_CLASS_DB']->Fetch($cat_dept_res)) {
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
            //if(isset($GLOBALS['ISC_CLASS_SEARCH'])) {
            $params = $this->searchterms;
            if(isset($params['make']) && !empty($params['make']))
            $mmy_links .= "&make=".urlencode($params['make']);
            if(isset($params['model']) && !empty($params['model']))
            $mmy_links .= "&model=".urlencode($params['model']);
            if(isset($params['model_flag']) && $params['model_flag'] == 0)
            $mmy_links .= "&model_flag=".$params['model_flag'];
            if(isset($params['submodel']) && !empty($params['submodel']))
            $mmy_links .= "&submodel=".urlencode($params['submodel']);
            if(isset($params['year']) && !empty($params['year']))
            $mmy_links .= "&year=".$params['year'];
			if(isset($params['brand']))
			$mmy_links .= "&brand=".$params['brand'];
			if(isset($params['brand_series']))
			$mmy_links .= "&brand_series=".$params['brand_series'];

			//$GLOBALS['ClearURL'] = "$path/search.php?search_query=".urlencode($params['search_query']).$mmy_links;
			$GLOBALS['ClearURL'] = "";

			/* checked whether all MMY are selected */
            if( isset($params['make']) && isset($params['year']) && isset($params['model']) && ( !isset($params['model_flag']) || ( isset($params['model_flag']) && $params['model_flag'] == 1 ) ) )
            $is_mmy_selected = 1;
            
            $GLOBALS['CategoryJSFunction'] = "getvalueswithajax('all_category','$str_link&categories=$catg_id_selected');checkanimate('all_category')";
            
            //}
			$GLOBALS['ISC_CLASS_VALID_CATEGORIES'] = GetClass('ISC_VALID_CATEGORY');  
            $GLOBALS['ISC_CLASS_VALID_CATEGORIES']->_ProcessCategories($categories);
             
            if(empty($catg_selected)) { // this condition is used to show all categories    
                $GLOBALS['contentid'] = "all_category";
                if(isset($GLOBALS['CategoryJSFunction']))
                $GLOBALS['arrowimage'] = "<img src='$path/templates/default/images/imgHdrDropDownIcon.gif' border='0' id='all_categoryimage'>";
                $temp_dept = "";
                foreach($categories[0] as $rootCat) {
                    // If we don't have permission to view this category then skip
                    if(!CustomerGroupHasAccessToCategory($rootCat['categoryid'])) {
                        continue;
                    }

					if(!isset($GLOBALS['ISC_CLASS_VALID_CATEGORIES']->_newcategoryids[$rootCat['categoryid']]))// not displaying the catg which are having zero products from main catg listing
                    continue;
                    
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
                    //if(eregi('search.php',$_SERVER['REQUEST_URI']))
                    //echo $_SERVER['REQUEST_URI'];
                    $GLOBALS['CategoryLink'] = "$path/search.php?search_query=".urlencode($rootCat['catname']).$mmy_links;
                    //else
                    //$GLOBALS['CategoryLink'] = CatLink($rootCat['categoryid'], $rootCat['catname'], true);
                    if(!isset($catg_count_list[$rootCat['categoryid']]))
                    $catg_count_list[$rootCat['categoryid']] = 0;

					$GLOBALS['LastChildClass'] = "";
                    if($catg_count_list[$rootCat['categoryid']] > 0)
                    $GLOBALS['LastChildClass'] = "validcatg";

					if( isset($params['brand']) || $is_mmy_selected == 1 )
                    $GLOBALS['CategoryCount'] = "(".$catg_count_list[$rootCat['categoryid']].")";  
                         
                    $output .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideCategoryList");

                }
                    $output .= "</ul>";
                
            } else {       // this condition has been added for showing only selected category

					$catg_clear_urls = "$path/search.php?search_query=categories";
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
            qualifierid = ".$QualifierId." and qa.categoryid = ".$CategoryId;
            
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
                qualifierid = ".$QualifierId." and qa.categoryid = ".$ParentCatId;
                
            $parent_assoc_result = $GLOBALS['ISC_CLASS_DB']->Query($parent_assoc_query);
            
            while($parent_assoc_row = $GLOBALS['ISC_CLASS_DB']->Fetch($parent_assoc_result)) {
                 $ParentAssoc[]     = $parent_assoc_row;
                 $ParentValue[]     = strtolower($parent_assoc_row['qvalue']);
            }  
        } else {
				$ParentAssoc[0] = array();
		}
        
    }


}

?>