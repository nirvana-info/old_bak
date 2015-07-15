<?php

include_once dirname(__FILE__).'/class.file_cache.php';

	class ISC_REDEFINE_SEARCH
	{

		public $path;
		public $items;
		public $column;

		function __construct()
		{
			unset($_GET['sort']);
			$this->path = GetConfig('ShopPath');
			$all_makes = array('CHEVROLET', 'GMC', 'FORD', 'DODGE', 'TOYOTA', 'NISSAN', 'HONDA', 'JEEP', 'HYUNDAI','CHRYSLER', 'INFINITI', 'LEXUS');
			$this->items = $_GET; 
			foreach($this->items as $key => $value) 
			{
				$this->items[$key] = MakeURLNormal($value);
			}
			$this->column = isset($this->items['column']) ? $this->items['column'] : '';
		}

		function _ProcessSearch()
		{
			$output = "";
			$column = $this->column;
			if(empty($column)) {
				echo "<p>No options available</p>";    
				die();
			}

			if($column == 'prodbrandid') {
				$selected_value = $_GET['brand']; // To get the originial value so tht it is not shown again in the list
				$_REQUEST['brand'] = ""; // Making the variable as empty so that all the list can be taken
			} else if($column == 'categories') {
				$selected_value = $_GET['catg_name']; // To get the originial value so tht it is not shown again in the list
				$_REQUEST[$column] = ""; // Making the variable as empty so that all the list can be taken    
				$_GET['search_query'] = $_REQUEST['search_query'] = str_ireplace($selected_value,'',MakeURLNormal($_REQUEST['search_query']));
			} else {
				$selected_value = isset($_GET[$column]) ? $_GET[$column] : ''; // To get the originial value so tht it is not shown again in the list
				$_GET[$column] = $_REQUEST[$column] = ""; // Making the variable as empty so that all the list can be taken    
			}
			$selected_value = MakeURLNormal($selected_value);
			$GLOBALS['ISC_CLASS_NEWSEARCH'] = GetClass('ISC_NEWSEARCH');
			$params = $GLOBALS['ISC_CLASS_NEWSEARCH']-> _searchterms;
			/* Adding clerance paramter for clearance page - vikas */
			if(isset($this->items['clearance']))
			{
				$params['clearance'] = 1;
				unset($this->items['clearance']);
			}

			switch($column) {

				case 'categories':
					$output = $this->searchcategories($params,$selected_value);
					break;
				default:
					//$output = $this->searchotherfilters($params,$selected_value);
					//NI Cloud.Liu 2010-05-28
					//modify YMM logic to read from cache file first
					//if fail reading file then get info from original logic
                    
                    
                    
                    
                    $ymm_tmp_column = isset($_GET['column'])?MakeURLSafe($_GET['column']):"";
                    $ymm_tmp_year   = isset($_GET['year'])?MakeURLSafe($_GET['year']):"";
                    $ymm_tmp_make   = isset($_GET['make'])?MakeURLSafe($_GET['make']):"";
                    $ymm_tmp_model  = isset($_GET['model'])?MakeURLSafe($_GET['model']):"";
					$fn = 'column='.$ymm_tmp_column.'_year='.$ymm_tmp_year.'_make='.$ymm_tmp_make.'_model='.$ymm_tmp_model;
					$fc = new file_cache($fn);
					$cache = $fc->get_cache();
					//NI Cloud.Liu 2010-06-11
					//accomplish make info if select column is model
					if( $cache && strtolower($column) === 'model' && isset($params['year'])  )
					{
						$cache = str_replace('/make/'.$params['make'], '/make/'.$params['make'].'/year/'.$params['year'], $cache );
					}
					//accomplish category and other info
					if( isset($cache) )
					{
						$NewLink = '';
						if(isset($params['category'])){
						    $NewLink .= "/category/".MakeURLSafe(strtolower($params['category']));
                        }
						if(isset($params['brand'])){
						    $NewLink .= "/brand/".MakeURLSafe($params['brand']);
                        }
						if(isset($params['series'])){
						    $NewLink .= "/series/".MakeURLSafe($params['series']);
                        }
						if(isset($params['searchtext'])){
						    $NewLink .= "/searchtext/".MakeURLSafe(strtolower($params['searchtext']));
                        }
						if(isset($params['search'])){
						    $NewLink .= "/searchtext/".MakeURLSafe(strtolower($params['search']));
                        }
						if( isset($_REQUEST['abtesting']) && $_REQUEST['abtesting'] != "" ){
							$NewLink = "/a-b-testing/".MakeURLSafe(strtolower($_REQUEST['abtesting']));
						}
						else if( isset($params["search_query"]) && $params["search_query"] != '' ){
							$NewLink = "/".MakeURLSafe(strtolower($params['search_query'])).$NewLink;
						}
						if( isset($NewLink) && $NewLink != '' )
							$cache = str_replace($GLOBALS["ShopPath"], $GLOBALS["ShopPath"].$NewLink, $cache );

						/* For clearance page, need to add clearance as the first paramter in URL to redirect to clearance page - vikas */
						if(isset($params['clearance']))
						{
							$cache = str_replace($GLOBALS["ShopPath"], $GLOBALS["ShopPath"]."/clearance", $cache );
						}
					}
					$output = $cache ? $cache : $this->searchotherfilters($params,$selected_value);
					break;

			}

			return $output;

		}

		function searchcategories($params,$selected_value)
		{
			$GLOBALS['ISC_CategoryBrandCache'] = GetClass('ISC_CACHECATEGORYBRANDS');
	    	$cachedCategoryBrands = $GLOBALS['ISC_CategoryBrandCache']->getCategoryBrandsData();
	    	$ValidCats = $GLOBALS['ISC_CategoryBrandCache']->GetValidCategories($cachedCategoryBrands);
	    
				$output = "";
				unset($params['brand'],$params['series']); // this is added as brand should not be selected when category is being selected
				$searchQueries = BuildProductSearchQuery($params);  

				$mmy_links = "";    // this link is used for applying href links of MMY

				$brand = "";
				if(isset($params['brand']) && isset($params['category'])) {
					$brand = $params['brand'];
					unset($params['brand']);
				}
				unset($params['category'],$params['srch_category']);

				$mmy_links = $this->GetYMMLinks($params);	

				foreach($this->items as $qkey => $qval)
				{
					if( preg_match("/^(pq|vq)/",$qkey) )
					{
						if( $qkey != 'vqsbedsize' && $qkey != 'vqscabsize' )
						{
							if($GLOBALS['EnableSEOUrls'] == 1) 
							{
								$mmy_links .= "/".strtolower($qkey)."/".MakeURLSafe(strtolower($qval));
							}
							else
							{
								$mmy_links .= "&".strtolower($qkey)."=".MakeURLSafe(strtolower($qval));
							}
						}
					}
				}

				/* the below condition is applied as brand has to be assigned to get it in the where condition in general.php */
				if($brand != "") {
					$params['brand'] = $brand;
				}
				
				$categories = $GLOBALS['ISC_CLASS_DATA_STORE']->Read('RootCategories'); 
				/*echo "<a name='list'>LIST</a>";
				echo "<p>Please click on any link from the below list.</p>";
				echo "<div style='height:280px;overflow-y:auto;border:1px solid black'>";*/
				
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
				
				$catg_list = array();
				$catg_count_list = array();
				$catg_qry = "select categoryid , catparentid from [|PREFIX|]categories";
				$catg_res = $GLOBALS['ISC_CLASS_DB']->Query($catg_qry); 
				while($catg_row = $GLOBALS['ISC_CLASS_DB']->Fetch($catg_res)) 
				{
				   $catg_list[$catg_row['categoryid']] =  $catg_row['catparentid'];
				}
				
				$searchQueries = BuildProductSearchQuery($params);
				$searchQueries['query'] = str_replace('USE INDEX (categoryid)','USE INDEX (PRIMARY)',$searchQueries['query']); 
				$searchQueries['query'] = str_replace($GLOBALS['srch_where']," group_concat(DISTINCT c.categoryid separator '~') as categoryid ",$searchQueries['query']);
				$searchQueries['query'] .= " group by p.productid ";
				$catg_select_res = $GLOBALS['ISC_CLASS_DB']->Query($searchQueries['query']);
				//print_r($catgcount);
				while($catg_select_row = $GLOBALS['ISC_CLASS_DB']->Fetch($catg_select_res)) 
				{ 
					$ids = explode('~',$catg_select_row['categoryid']);
				
					for($k=0;$k<count($ids);$k++)
					{
						if(!empty($ids[$k]))
						{
							if(!isset($catg_count_list[$ids[$k]]))
							$catg_count_list[$ids[$k]] = 0;
							
							if($catg_list[$ids[$k]] == 0) {
								$catg_count_list[$ids[$k]] += 1;
							} else {
								if(!isset($catg_count_list[$catg_list[$ids[$k]]]))
								$catg_count_list[$catg_list[$ids[$k]]] = 0;
											   
								$catg_count_list[$catg_list[$ids[$k]]] += 1;
							}
						}
					}
				}
    
				//$GLOBALS['ISC_CLASS_VALID_CATEGORIES'] = GetClass('ISC_VALID_CATEGORY');  
				//$GLOBALS['ISC_CLASS_VALID_CATEGORIES']->_ProcessCategories($categories);
				
				$output .= "<ul>";
				$temp_dept = "";
				foreach($categories[0] as $rootCat) {
					if($rootCat['categoryid'] != $selected_value) {
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

						$GLOBALS['CategoryName'] = isc_html_escape($rootCat['catname']);

						$category_link = "";
						
						if( isset($_REQUEST['abtesting']) && $_REQUEST['abtesting'] != "" )
						{
							$RootCatName = $rootCat['catname'];
						}
						else if($brand == "")
						{
							$RootCatName = $rootCat['catname'];
						}
						else 
						{
							$RootCatName = $brand;
							if ($GLOBALS['EnableSEOUrls'] == 1)
								$category_link = "/category/".MakeURLSafe(Strtolower($rootCat['catname'])); 
							else
								$category_link = "&category=".MakeURLSafe(Strtolower($rootCat['catname']));

						}

						if( isset($_REQUEST['abtesting']) && $_REQUEST['abtesting'] != "" )
						{
							//Modify 2010-10-19 Ronnie
							//$GLOBALS['CategoryLink'] = $this->path."/a-b-testing/".MakeURLSafe(strtolower($_REQUEST['abtesting']))."/category/".MakeURLSafe(strtolower($RootCatName)).$mmy_links;
							$GLOBALS['CategoryLink'] = $this->path."/".MakeURLSafe(strtolower($RootCatName)).$mmy_links;
							
						}
						else
						{
							$GLOBALS['CategoryLink'] = $this->LeftCatLink($RootCatName).$mmy_links.$category_link;
						}
						//$GLOBALS['CategoryLink'] = "$this->path/search.php?search_query=".urlencode($GLOBALS['CategoryName']).$mmy_links;
						if(!isset($catg_count_list[$rootCat['categoryid']]))
						  $catg_count_list[$rootCat['categoryid']] = 0;
						
						//$GLOBALS['CategoryCount'] = "(".$catg_count_list[$rootCat['categoryid']].")";
						$output .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideCategoryList");
						
					}
				}
				
				$output .= "</ul>";
				return $output;
		}

		function searchotherfilters($params,$selected_value) {

				$output = "";
				
				$column = $this->column;
				unset($this->items['column'],$this->items['random'],$this->items['search_query'],$this->items[$column],$this->items['abtesting']);

				if($column == 'prodbrandid')
				unset($this->items['brand'],$params['brand'],$params['flag_srch_brand']);

				if($column == 'model')
				unset($this->items['model_flag']);

				$items = $this->items;
				
				$params['search_query'] = MakeURLSafe($params['search_query']);
				
				if($column == 'make' || $column == 'model' || $column == 'submodel' || $column == 'year') {
					if(isset($GLOBALS['ISC_SRCH_CATG_NAME'])){
					    $params['search_query'] = str_ireplace($GLOBALS['ISC_SRCH_CATG_NAME'],'',MakeURLNormal($params['search_query']));
                    }
					
					unset($params['category'],$params['srch_category'],$params['brand'],$params['series'],$params['flag_srch_brand']); // here category & brand is commented to display all MMY need to be displayed for categories.

					/* 
						The below condition is added as the bedsize and cabsize values are retained when clicking on YMM links.
					*/
					if($column == 'make' || $column == 'model' || $column == 'year') 
					{
						unset($params['dynfilters'],$params['vqsbedsize'],$params['vqscabsize']);
					}

					/*if($column == 'year')
						unset($params['make'],$params['model']);*/
					
					if($column == 'make')
						unset($params['year']);

					if($column == 'model') {
						if(!isset($params['catuniversal']) || $params['catuniversal'] == 1) // if category is universal then show all models else model is dependent of year
						unset($params['catuniversal']); //,$params['year']
					}
					
					$searchQueries = BuildProductSearchQuery($params);  // this has been written seperately as we need to replace the category name with empty to ignore the category selected for redefine search
					if($column == 'year')
					$column_concat = " group_concat(v.prodstartyear separator '~') as prodstartyear , group_concat(v.prodendyear separator '~') as prodendyear";
					else {
					$column_val = "prod".$column;   
					$column_concat = " group_concat(DISTINCT v.prod".$column." separator '~') as ".$column_val;
					}
				} else {
					$searchQueries = BuildProductSearchQuery($params);  // this has been written seperately as we need to replace the category name with empty to ignore the category selected for redefine search
					$column_val = $column;
					if(strcasecmp($column_val,'VQbedsize') == 0)
					$column_concat = " group_concat( DISTINCT if( v.bedsize_generalname != '', v.bedsize_generalname, v.VQbedsize ) separator '~' ) as $column ";
					else if(strcasecmp($column_val,'VQcabsize') == 0)
					$column_concat = " group_concat( DISTINCT if( v.cabsize_generalname != '', v.cabsize_generalname, v.VQcabsize ) separator '~' ) as $column ";
					else
					$column_concat = " group_concat(DISTINCT $column separator '~') as $column ";
				}

				$searchQueries['query'] = str_replace('USE INDEX (categoryid)','USE INDEX (PRIMARY)',$searchQueries['query']); 
				$searchQueries['query'] = str_replace($GLOBALS['srch_where'],$column_concat,$searchQueries['query']);
				$searchQueries['query'] .= " group by p.productid ";
				$Search_Result = $GLOBALS['ISC_CLASS_DB']->Query($searchQueries['query']);
				$numrows = $GLOBALS['ISC_CLASS_DB']->CountResult($Search_Result);

				if($numrows > 0)
				{
					$filter_array = array();
					$count_filter_array = array();
					//echo "<p>Please click on any link from the below list.</p>";
					//echo "<div style='height:280px;overflow-y:auto;border:1px solid black'>";
					$z = 1;
					while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($Search_Result)) {
						if($column == 'prodbrandid') {
							$brandid = $row['prodbrandid'];
							if($brandid != 0) {
							$qry = "select * from [|PREFIX|]brands where brandid = ".$brandid;
							$res =  $GLOBALS['ISC_CLASS_DB']->Query($qry);
							$arr =  $GLOBALS['ISC_CLASS_DB']->Fetch($res);
							
							if(strtolower($selected_value) != strtolower($arr['brandname'])) {
								$arr['brandname'] = ucwords(strtolower($arr['brandname']));
								if(in_array($arr['brandname'],$filter_array)) {
									$count_filter_array[$arr['brandname']]++;
								} else {
									$filter_array[$arr['brandid']] = $arr['brandname'];
									$count_filter_array[$arr['brandname']] = 1;
								}
							}
							}
						}
						else if($column == 'submodel')
						{
							   $filters = explode('~',$row[$column_val]);
							   for($j=0;$j<count($filters);$j++) 
							   {
									if(empty($filters[$j])) {
										$filters[$j] = "ALL";                                       
									}
									
									if(strtolower($selected_value) != strtolower($filters[$j])) {
										$filters[$j] = ucwords($filters[$j]);
										if(in_array($filters[$j],$filter_array))   {
											//echo "<li><a href='search.php?search_query=".$params['search_query']."$links&$column=".urlencode($filters[$j])."'>$filters[$j]</a></li>"; 
											$count_filter_array[$filters[$j]]++;
										} else {
											$filter_array[] = $filters[$j];
											$count_filter_array[$filters[$j]] = 1;
										}
									}
							   }
						}
						else if($column=='model')    
						{
							if(!empty($row[$column_val]) && $row[$column_val] != '~') {
							   $filters = explode('~',$row[$column_val]);
							   for($j=0;$j<count($filters);$j++) 
							   {
									$filter_value = explode(";",$filters[$j]); 
									for($k=0;$k<count($filter_value);$k++)
									{
										if(strtolower($selected_value) != strtolower($filter_value[$k])) {
											$filter_value[$k] = strtoupper($filter_value[$k]);
											if(in_array($filter_value[$k],$filter_array))   {
												$count_filter_array[$filter_value[$k]]++;
											} else {
												$filter_array[] = $filter_value[$k];
												$count_filter_array[$filter_value[$k]] = 1;
											}
										}
									}  
							   }
							}
						}
						else if($column=='make')    
						{
							if(!empty($row[$column_val]) && $row[$column_val] != '~') {
							   $filters = explode('~',$row[$column_val]);
							   for($j=0;$j<count($filters);$j++) 
							   {
									$filter_value = explode(";",$filters[$j]); 
									for($k=0;$k<count($filter_value);$k++)
									{
										//if(strtolower($selected_value) != strtolower($filter_value[$k])) { // commented, as need to show all the makes
										if($filter_value[$k] != "") {
											if(in_array($filter_value[$k],$filter_array))   {
												//echo "<li><a href='search.php?search_query=".$params['search_query']."$links&$column=".urlencode($filters[$j])."'>$filters[$j]</a></li>";
												$count_filter_array[$filter_value[$k]]++;
											} else {
												$filter_array[] = $filter_value[$k];
												$count_filter_array[$filter_value[$k]] = 1;
											}
										}
									}  
							   }
							}
						}
						else if($column!='year')    // for all qualifier filters
						{
							   $row[$column_val] = trim($row[$column_val], '~');
							   //$filters = explode('~',$row[$column_val]);
							   $filters = preg_split('/[~;]+/', $row[$column_val]);
                               $filters = array_unique($filters);
                               $filters = array_values($filters);
							   for($j=0;$j<count($filters);$j++) 
							   {
									if($filters[$j]=='')    {          //Added by Simha
										$filters[$j] = "Others";
									}
									$filter_value = explode(";",$filters[$j]); 
									for($k=0;$k<count($filter_value);$k++)
									{
										if(strtolower($selected_value) != strtolower($filter_value[$k])) {
											if(in_array($filter_value[$k],$filter_array))   {
												//echo "<li><a href='search.php?search_query=".$params['search_query']."$links&$column=".urlencode($filters[$j])."'>$filters[$j]</a></li>";
												$count_filter_array[$filter_value[$k]]++;
											} else {
												$filter_array[] = $filter_value[$k];
												$count_filter_array[$filter_value[$k]] = 1;
											}
										}
									}  
							   }
						
						} else {    // only for year filter
							$z++;
							$grp_startyear = explode("~",$row['prodstartyear']); 
							$grp_endyear = explode("~",$row['prodendyear']);
							for($g=0;$g<count($grp_startyear);$g++)
							{
								$prod_start_year = $grp_startyear[$g];
								$prod_end_year = $grp_endyear[$g]; 

								if(is_numeric($prod_start_year) && is_numeric($prod_end_year)) {
									$prod_year_diff = $prod_end_year - $prod_start_year;
									for($i=0;$i<=$prod_year_diff;$i++)
									{   
										$actual_year = $prod_start_year + $i;
										if(strtolower($selected_value) != $actual_year) {
											if(in_array($actual_year,$filter_array)) {
											   //echo "<li><a href='search.php?search_query=".$params['search_query']."$links&$column=$actual_year'>$actual_year</a></li>";  
												$count_filter_array[$actual_year]++;                                                                   
											}  else {
												$filter_array[] = $actual_year;
												$count_filter_array[$actual_year] = 1;
											}
										}
									}
								}
								else if(!is_numeric($prod_start_year) && !is_numeric($prod_end_year)) {
										if(strtolower($selected_value) != strtolower($prod_start_year))
										{
											if(in_array($prod_start_year,$filter_array)) {
											   //echo "<li><a href='search.php?search_query=".$params['search_query']."$links&$column=$prod_start_year'>$prod_start_year</a></li>";  
											   $count_filter_array[$prod_start_year]++; 
											} else {
												$filter_array[] = $prod_start_year;
												$count_filter_array[$prod_start_year] = 1; 
											}
										}
								}
							   
							}
							
						}
					}

					if($column == 'year')
					rsort($filter_array);
					else if($column == 'submodel')
					sort($filter_array);
					else
					asort($filter_array);
					
					/* the below code has been added to move no-spec vehicle at the end of array */
					if(in_array('NON-SPEC VEHICLE',$filter_array)) {
						$mkey = array_search('NON-SPEC VEHICLE',$filter_array);
						unset($filter_array[$mkey]);
						$filter_array = array_values($filter_array);
						array_push($filter_array,'NON-SPEC VEHICLE');
					}
					
					$output .= $this->showfiltervalues($filter_array,$count_filter_array,$params);

				} else {
					$output .= "<p>Sorry, there are no options available to select.</p>";
				}

				return $output;

		}

		function showfiltervalues($filter_array,$count_filter_array,$params)
		{
			$output = "";
			$column = $this->column;
			$path = $this->path;

			$list = "";
			$counter = 0;
			$extra = "";

			$links = "";
			
			$links = $this->generatelink($this->items);

			if(!empty($filter_array)) {

				if($column == 'make') {

					$all_makes = array('CHEVROLET', 'GMC', 'FORD', 'DODGE', 'TOYOTA', 'NISSAN', 'HONDA', 'JEEP', 'HYUNDAI','CHRYSLER', 'INFINITI', 'LEXUS');
					//$temp_arr =  array_diff($filter_array,$all_makes); // commented as need to show the abpve makes with all other makes also
					$temp_arr =  $filter_array;

					$srch_str = "";
					if( isset($_REQUEST['abtesting']) && $_REQUEST['abtesting'] != "")
					{
						$srch_str = "a-b-testing/".MakeURLSafe(strtolower($_REQUEST['abtesting']));
					}
					else if(isset($GLOBALS['ISC_SRCH_CATG_NAME']) && !isset($this->items['category']))
						$srch_str = MakeURLSafe(strtolower($GLOBALS['ISC_SRCH_CATG_NAME']));
				    else if(isset($GLOBALS['ISC_SRCH_BRAND_NAME']))
						$srch_str = MakeURLSafe(strtolower($GLOBALS['ISC_SRCH_BRAND_NAME']));

					$ymm_link = $this->leftnavigationlink($srch_str,$links,$column,$params);

					foreach($all_makes as $key => $value) {
                       
						   $counter++; // here applied the counter++ seperately as we are avoiding all & universal fit many vehicles.
						   
						   if($srch_str == "" && preg_match('/%s/',$ymm_link))
								$ymm_link = sprintf($ymm_link,$value);

						   $list_val = "<li><a href='".$ymm_link.MakeURLSafe(strtolower($value))."'>$value</a></li>";
								
						   if($counter < 13)
							   $list .= $list_val;
						   else
							   $extra .= $list_val;
					   
					}

					if(count($temp_arr) > 0) {
						foreach($temp_arr as $key => $value ) {
							if(strtoupper($value) != "NON-SPEC VEHICLE" && strtolower($value) != "all") {
                               $counter++; // here applied the counter++ seperately as we are avoiding all & universal fit many vehicles.
							   
							   if($srch_str == "" && preg_match('/%s/',$ymm_link))
							   $ymm_link = sprintf($ymm_link,$value);

							   $list_val = "<li><a href='".$ymm_link.MakeURLSafe(strtolower($value))."'>$value</a></li>";
									
							   if($counter < 13)
								   $list .= $list_val;
							   else
								   $extra .= $list_val;
							}
						}
					}

				} else {

				$srch_str = "";
				if($_REQUEST['abtesting'] && $_REQUEST['abtesting'] != "")
				{
					$srch_str = "a-b-testing/".MakeURLSafe(strtolower($_REQUEST['abtesting']));
				}
				else if(isset($GLOBALS['ISC_SRCH_CATG_NAME']) && !isset($this->items['category']))
					$srch_str = MakeURLSafe(strtolower($GLOBALS['ISC_SRCH_CATG_NAME']));
			    else if(isset($GLOBALS['ISC_SRCH_BRAND_NAME']) && $column != 'prodbrandid')
					$srch_str = MakeURLSafe(strtolower($GLOBALS['ISC_SRCH_BRAND_NAME']));

				$ymm_link = $this->leftnavigationlink($srch_str,$links,$column,$params);
				

				foreach($filter_array as $key => $value)
				{
				   if($column == 'prodbrandid') {

					   if(empty($params['search_query']))
						   $srch_str = urlencode($value);
					   else
						   $srch_str = $params['search_query'];

					   $counter++; // here applied the counter++ seperately as we are avoiding all & universal fit many vehicles.
					   //$column = 'brand';  
					   if(!isset($GLOBALS['ISC_SRCH_CATG_NAME']))	
					   {
							if ($GLOBALS['EnableSEOUrls'] == 1)
							{
								$list_val = "<li><a href='".$this->path."/".MakeURLSafe(strtolower($value));
								
								if($links != "")
									$list_val .= "/$links";

								$list_val .= "'>$value  (".$count_filter_array[$value].")</a></li>";
							}
							else
							{
								$list_val = "<li><a href='".$this->path."/search.php?search_query=$value".$links."'>$value  (".$count_filter_array[$value].")</a></li>";
							}

					   }
					   else
							$list_val = "<li><a href='$ymm_link".MakeURLSafe(strtolower($value))."'>$value (".$count_filter_array[$value].")</a></li>";
					   
					   if($counter < 11)
						  $list .= $list_val;
					   else
						  $extra .= $list_val;
						
				   } else if($column == 'model' || $column == 'submodel' || $column == 'year') {
					   //echo "<li><a href='$path/search.php?search_query=".$value."$links&$column=".urlencode($value)."'>$value</a> (".$count_filter_array[$value].")</li>"; // commented for backup
					   if(strtoupper($value) != "NON-SPEC VEHICLE" && strtolower($value) != "all") {
							$counter++; // here applied the counter++ seperately as we are avoiding all & universal fit many vehicles.
						
						  $ymm_new_link = $ymm_link;

						   if($srch_str == "" && preg_match('/%s/',$ymm_link) ) {
							   if(isset($params['make']))
							   $ymm_new_link = sprintf($ymm_link,$params['make']);
							   else
							   $ymm_new_link = sprintf($ymm_link,$value);
						   }
							
						   $list_val = "<li><a href='".$ymm_new_link.MakeURLSafe(strtolower($value))."'>$value</a></li>";
							
							if($counter < 11)
							   $list .= $list_val;
							else
							   $extra .= $list_val;
					   }
				   } else  {
					   $counter++; // here applied the counter++ seperately as we are avoiding all & universal fit many vehicles.
					   $list_val = "<li><a href='$ymm_link".MakeURLSafe(strtolower($value))."'>$value (".$count_filter_array[$value].")</a></li>";
					   
					   if($counter < 11)
						   $list .= $list_val;
					   else
						   $extra .= $list_val;
				   }
				   
				}
				if($counter == 0)
					$list .= "<li>No options available</li>";

			  }
			} else {
				$list .= "<li>No options available</li>";
			} 
			
			if($counter >= 11 ) {
			   $GLOBALS['FilterID'] = $column;
			   $GLOBALS['ExtraValues'] = $extra;
			   $output .= "<ul>".$list."</ul>";
			   $output .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideFilterMoreLink");
			}
			else {
				$output .= "<ul>".$list."</ul>";
			}
			
			try
			{
                $ymm_tmp_column = isset($_GET['column'])?MakeURLSafe($_GET['column']):"";
                $ymm_tmp_year   = isset($_GET['year'])?MakeURLSafe($_GET['year']):"";
                $ymm_tmp_make   = isset($_GET['make'])?MakeURLSafe($_GET['make']):"";
                $ymm_tmp_model  = isset($_GET['model'])?MakeURLSafe($_GET['model']):"";
                $fn = 'column='.$ymm_tmp_column.'_year='.$ymm_tmp_year.'_make='.$ymm_tmp_make.'_model='.$ymm_tmp_model;
				$fc = new file_cache($fn);
				$fc->save_cache($output);
			}
			catch(Exception $e)
			{
				return $e->getMessage();
			}

			return $output;

		}

		function generatelink($items) {
			$link = "";
			foreach($items as $key => $val) {
				if($val != "") {
					if(is_array($val)) {
						$val = implode("&".$key."[]=",$val);
						$key = $key."[]";
					 } 

					 if($GLOBALS['EnableSEOUrls'] == 1)
						 $link .= strtolower($key)."/".MakeURLSafe(strtolower($val))."/";
					 else
						$link .= "&".strtolower($key)."=".MakeURLSafe($val);

				}
			}

			return $link;
		}

		function leftnavigationlink($srch_str,$links,$column,$params) {

				if($column == 'prodbrandid')
					$column = "brand";
			
				if ($GLOBALS['EnableSEOUrls'] == 1) {
					
					if($srch_str != "") {
						$srch_str .= "/";
						//$links .= "/";
					}

					if(isset($params['clearance']))
					{
						$left_link = sprintf("%s/%s%s%s/", $GLOBALS['ShopPath']."/clearance", $srch_str, $links, strtolower($column) );
					}
					else
					{
						$left_link = sprintf("%s/%s%s%s/", $GLOBALS['ShopPath'], $srch_str, $links, strtolower($column) );
					}
				} else {

					if($srch_str == "")
						$srch_str = "%s";
					else
						$srch_str = $srch_str;
					
					if(isset($params['clearance']))
					{
						$left_link = sprintf("%s/clearance.php?search_query=%s%s&%s=", $GLOBALS['ShopPath'], $srch_str, $links, strtolower($column) );
					}
					else
					{	
						$left_link = sprintf("%s/search.php?search_query=%s%s&%s=", $GLOBALS['ShopPath'], $srch_str, $links, strtolower($column) );
					}
				}
			
				return $left_link;

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
				$NewLink .= "/make/".MakeURLSafe($params['make']);
				if(isset($params['model']) && !empty($params['model']))
				$NewLink .= "/model/".MakeURLSafe($params['model']);
				if(isset($params['model_flag']) && $params['model_flag'] == 0)
				$NewLink .= "/model_flag/".$params['model_flag'];
				if(isset($params['submodel']) && !empty($params['submodel']))
				$NewLink .= "/submodel/".MakeURLSafe($params['submodel']);
				if(isset($params['year']) && !empty($params['year']))
				$NewLink .= "/year/".$params['year'];
				if(isset($params['category']))
				$NewLink .= "/category/".MakeURLSafe(strtolower($params['category']));
				if(isset($params['brand']))
				$NewLink .= "/brand/".MakeURLSafe($params['brand']);
				if(isset($params['series']))
				$NewLink .= "/series/".MakeURLSafe($params['series']);
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
				if(isset($params['category']))
				$NewLink .= "&category=".MakeURLSafe(strtolower($params['category']));
				if(isset($params['brand']))
				$NewLink .= "&brand=".MakeURLSafe($params['brand']);
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
	 * @desc Create Category links
	 * @params Rootcatname
	 */
	 function LeftCatLink($RootCatName)
	 {
		$NewLink = '';
		if ($GLOBALS['EnableSEOUrls'] == 1) {
			$NewLink = sprintf("%s/%s", $this->path, MakeURLSafe(strtolower($RootCatName)));
		} else {
			$NewLink = sprintf("%s/search.php?search_query=%s", GetConfig('ShopPath'), MakeURLSafe($RootCatName));
		}
		return $NewLink;
	 }


	 /**
	 * @desc Create YMM Options
	 */	
	 function _GetYMMOptions()
	 {
		 $params = $_GET;
		 
		 $params['make'] = MakeURLNormal($params['make']);
		 $params['model'] = MakeURLNormal($params['model']);
		 $params['year'] = MakeURLNormal($params['year']);

		 $options = "";
		 $filter_array = array();
		 if( isset($params['ymmtype']) && $params['ymmtype'] == 'make' )
		 {
			/* -------------------- Year Filter ----------------------- */

			 $year_filter_array = array();
			 $ymm_qry = "select group_concat(v.prodstartyear separator '~') as prodstartyear , group_concat(v.prodendyear separator '~') as prodendyear from [|PREFIX|]products p LEFT JOIN [|PREFIX|]import_variations AS v ON v.productid = p.productid where p.prodvisible='1' ";

			 if( isset($params['make']) && $params['make'] != "" && $params['universal'] == 0 )
				 $ymm_qry .= " and ( prodmake = '".$params['make']."' OR prodmake = 'NON-SPEC VEHICLE' ) ";
			 if( isset($params['model']) && $params['model'] != "" && (!isset($params['model_flag']) || $params['model_flag'] == 1) && $params['universal'] == 0 )
				$ymm_qry .= " and ( prodmodel = '".$params['model']."' OR prodmodel = 'all' ) ";
			 
			 $ymm_qry .= " group by p.productid ";	
			 
			 $ymm_res = $GLOBALS['ISC_CLASS_DB']->Query($ymm_qry);

			 while($ymm_row = $GLOBALS['ISC_CLASS_DB']->Fetch($ymm_res))
			 {
				 $grp_startyear = explode("~",$ymm_row['prodstartyear']); 
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
							if(in_array($actual_year,$year_filter_array)) {
								$count_filter_array[$actual_year]++;        
							}  else {
								$year_filter_array[] = $actual_year;
								$count_filter_array[$actual_year] = 1;
							}
						}
					}
				 }
			}
			rsort($year_filter_array);

			if( isset($params['year']) && !in_array($params['year'],$year_filter_array) )
				unset($params['year']);

			 /* -------------------- Year Filter ends ----------------------- */

			 /* -------------------- Model Filter starts ----------------------- */

			 $options .= "<option value=''>--select model--</option>";
			 $ymm_qry = "select distinct prodmodel from [|PREFIX|]products p LEFT JOIN [|PREFIX|]import_variations AS v ON v.productid = p.productid where p.prodvisible='1' ";
			 if( isset($params['make']) )
				 $ymm_qry .= " and ( prodmake = '".$params['make']."' OR prodmake = 'NON-SPEC VEHICLE' ) ";
			 if( isset($params['year']) && $params['year'] != "" && $params['universal'] == 0)
				 $ymm_qry .= " and ( ".$params['year']." between prodstartyear and prodendyear OR prodstartyear = 'all' ) ";
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
				 $options .= "<option value='".MakeURLSafe(strtolower($value))."'>$value</option>";
			 }

 			 /* -------------------- Model Filter ends ----------------------- */

			 /*if($params['year'] == '')
			 {*/
				$options .= "~<option value=''>--select year--</option>";
				foreach($year_filter_array as $key => $value)
				{
					$selected = "";
					if( isset($params['year']) && $params['year'] != '' && $params['year'] == $value)
					$selected = "selected";

					$options .= "<option value='".MakeURLSafe(strtolower($value))."' $selected>$value</option>";
				}
			 /*}*/
					
		 }
		 else if( isset($params['ymmtype']) && $params['ymmtype'] == 'model' )
		 {
			 if($params['year'] == '')
			 {
				 $filter_array = array();
				 $options .= "<option value=''>--select year--</option>";
				 $ymm_qry = "select group_concat(v.prodstartyear separator '~') as prodstartyear , group_concat(v.prodendyear separator '~') as prodendyear from [|PREFIX|]products p LEFT JOIN [|PREFIX|]import_variations AS v ON v.productid = p.productid where p.prodvisible='1' ";
				 if( isset($params['make']) && $params['make'] != "" && $params['universal'] == 0 )
					 $ymm_qry .= " and ( prodmake = '".$params['make']."' OR prodmake = 'NON-SPEC VEHICLE' ) ";
				 if( isset($params['model']) && $params['model'] != "" && (!isset($params['model_flag']) || $params['model_flag'] == 1) && $params['universal'] == 0 )
					 $ymm_qry .= " and ( prodmodel = '".$params['model']."' OR prodmodel = 'all' ) ";

				 $ymm_qry .= " group by p.productid ";	

				 $ymm_res = $GLOBALS['ISC_CLASS_DB']->Query($ymm_qry);
				 while($ymm_row = $GLOBALS['ISC_CLASS_DB']->Fetch($ymm_res))
				 {
					 $grp_startyear = explode("~",$ymm_row['prodstartyear']); 
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
						 }
					}
					rsort($filter_array);
					foreach($filter_array as $key => $value)
					{
						$options .= "<option value='".MakeURLSafe(strtolower($value))."'>$value</option>";
					}
			  }
		 }
		 else if( isset($params['ymmtype']) && $params['ymmtype'] == 'year' )
		 {
			 if( isset($params['make']) )
			 {
					$options .= "<option value=''>--select model--</option>";
					$ymm_qry = "select distinct prodmodel from [|PREFIX|]products p LEFT JOIN [|PREFIX|]import_variations AS v ON v.productid = p.productid where p.prodvisible='1' ";
					if( isset($params['make']) )
						$ymm_qry .= " and ( prodmake = '".$params['make']."' OR prodmake = 'NON-SPEC VEHICLE' ) ";
					if( isset($params['year']) && $params['year'] != "" && $params['universal'] == 0 )
						$ymm_qry .= " and ( ".$params['year']." between prodstartyear and prodendyear OR prodstartyear = 'all' ) ";
					
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
									if(in_array($filter_value,$filter_array))   
									{

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
						if($params['model'] != '' && strtolower($params['model']) == strtolower($value) )
						$selected = "selected";

						$options .= "<option value='".MakeURLSafe(strtolower($value))."' $selected>$value</option>";
					}
			 }
		 }
		 return $options;
						
	 } 

		
	}

?>
