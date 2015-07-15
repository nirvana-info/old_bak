<?php

	CLASS ISC_SIDECATEGORYLIST_PANEL extends PANEL
	{
		var $cacheable = true;
		var $cacheId = "categories.sidecategorylist";

		function SetPanelSettings()
		{
			$GLOBALS['ISC_CategoryBrandCache'] = GetClass('ISC_CACHECATEGORYBRANDS');
			$cachedCategoryBrands = $GLOBALS['ISC_CategoryBrandCache']->getCategoryBrandsData();
			//$mycategories = $GLOBALS['ISC_CategoryBrandCache']->GetAllCategories($cachedCategoryBrands);
			$ValidCats = $GLOBALS['ISC_CategoryBrandCache']->GetValidCategories($cachedCategoryBrands);
			
			$path = GetConfig('ShopPath');
			$catg_selected = "";
            $catg_id_selected = "";
            if(isset($GLOBALS['ISC_CLASS_CATEGORY'])) {
                $catg_selected = $GLOBALS['ISC_CLASS_CATEGORY']->GetName();
                $catg_id_selected = $GLOBALS['ISC_CLASS_CATEGORY']->GetCategoryId();
            } else if(isset($GLOBALS['ISC_SRCH_CATG_ID']) && isset($GLOBALS['ISC_SRCH_CATG_NAME'])) {
                $catg_id_selected = $GLOBALS['ISC_SRCH_CATG_ID'];
                $catg_selected = $GLOBALS['ISC_SRCH_CATG_NAME'];
            }

			/* Removing the cookie if set for "clear other filters" */
			if(	isset($_COOKIE['last_search_selection']['clearotherfilters']) && $_COOKIE['last_search_selection']['clearotherfilters'] == 1	)
			{
				if(	isset($_SESSION['searchterms'])	)
				{
					unset($_SESSION['searchterms']['srch_category'],$_SESSION['searchterms']['brand'],$_SESSION['searchterms']['flag_srch_brand']);
					setcookie( 'last_search_selection[clearotherfilters]', '' , time()-3600 ,'/');        
				}
			}

			$output = "";
			$categories = $GLOBALS['ISC_CLASS_DATA_STORE']->Read('RootCategories');

			if (!isset($categories[0])) {
				$this->DontDisplay = true;
				return;
			}
			
			//var_dump($categories);

			/*----- the below block has been added to display the categories department wise ----- */
			$dept = array();
            $cat_dept = array();
            $cat_department = array();
         /*   $cat_dept_qry = "select categoryid , catdeptid , deptname from isc_categories c left join isc_department d on d.deptid = c.catdeptid where catparentid = 0 and catvisible = 1 order by deptname asc, catdeptid desc, catname";
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
            //var_dump($categories);
			/*-------- Ends--------------------------------- */

			$mmy_links = "";
            if(isset($GLOBALS['ISC_CLASS_NEWSEARCH'])) {
            $params = $GLOBALS['ISC_CLASS_NEWSEARCH']-> _searchterms;
            if(isset($params['make']) && !empty($params['make']))
            $mmy_links .= "&make=".urlencode($params['make']);
            if(isset($_REQUEST['model']) && !empty($_REQUEST['model']))
            $mmy_links .= "&model=".urlencode($_REQUEST['model']);
			if(isset($params['model_flag']) && $params['model_flag'] == 0)
            $mmy_links .= "&model_flag=".$params['model_flag'];
            if(isset($params['year']) && !empty($params['year']))
            $mmy_links .= "&year=".$params['year'];

			$GLOBALS['CategoryJSFunction'] = "checkanimate('all_category')";

            }

			//$ValidCats = $this->GetValidCategories();

			//$GLOBALS['ISC_CLASS_VALID_CATEGORIES'] = GetClass('ISC_VALID_CATEGORY');  
            //$GLOBALS['ISC_CLASS_VALID_CATEGORIES']->_ProcessCategories($categories);

			if(empty($catg_selected)) {     
				/* the below two variables are added to apply updown animation and image */
				$GLOBALS['contentid'] = "all_category";
                if(isset($GLOBALS['CategoryJSFunction']))
                $GLOBALS['arrowimage'] = "<img src='$path/templates/default/images/imgHdrDropDownIcon.gif' border='0' id='all_categoryimage'>";
                

				$temp_dept = "";
				//var_dump($ValidCats);
				foreach($categories[0] as $rootCat) {
					// If we don't have permission to view this category then skip
					if(!CustomerGroupHasAccessToCategory($rootCat['categoryid'])) {
						continue;
					}
				
					if(in_array($rootCat['categoryid'],$ValidCats))
					{
							/*if(!isset($GLOBALS['ISC_CLASS_VALID_CATEGORIES']->_newcategoryids[$rootCat['categoryid']]))
							continue;*/

							//  The below line is commented as client told not to show the count on homepage
							// $GLOBALS['CategoryCount'] = " (".$GLOBALS['ISC_CLASS_VALID_CATEGORIES']->_newcategoryids[$rootCat['categoryid']].")";
							$GLOBALS['CategoryCount'] = ""; // making it empty as client told not to show the count on homepage.

							if($temp_dept != $rootCat['catdeptid']) {
								if(!empty($temp_dept))
									$output .= "</ul>";
								if(!empty($dept[$rootCat['catdeptid']]))
									$GLOBALS['deptname'] = $dept[$rootCat['catdeptid']];
								else
									$GLOBALS['deptname'] = "Others";

								$GLOBALS['deptid'] = "dept".$rootCat['catdeptid'];

								$output .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("CategoryDepartment");
								$output .= "<ul id='".$GLOBALS['deptid']."'>";   
								//$output .= "<ul><li style='background-color: rgb(255, 15, 25);font-size:12px'>".$dept[$rootCat['catdeptid']]."</li></ul><ul>";
								$temp_dept = $rootCat['catdeptid'];
							}


							$GLOBALS['SubCategoryList'] = $this->GetSubCategory($categories, $rootCat['categoryid']);
							$GLOBALS['LastChildClass']='';
							$GLOBALS['CategoryName'] = isc_html_escape($rootCat['catname']);
							
							### Common code for creating links SEO friendly and Non-SEO friendly links   
							$RootCatName = $rootCat['catname'];               
							$GLOBALS['CategoryLink'] = $this->LeftCatLink($RootCatName);

							$output .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideCategoryList");
					}

				}
					$output .= "</ul>";
					
			
			} else {		// this condition has been added for showing only selected category
					$GLOBALS['arrowimage'] = "<img src='$path/templates/default/images/imgHdrDropDownIconright.gif' border='0' id='all_categoryimage'>";

                    $GLOBALS['SubCategoryList'] = $this->GetSubCategory($categories, $catg_id_selected);
                    $GLOBALS['LastChildClass']='';
                    $GLOBALS['CategoryName'] = isc_html_escape($catg_selected);
                    //$GLOBALS['CategoryLink'] = "#";
					$GLOBALS['CategoryLink'] = $mmy_links;
                    $output .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideCategoryList1");
					$output .= "</ul></div><div style='display:none' id='all_category' class='BlockContent'>";
					$temp_dept = "";
                    foreach($categories[0] as $rootCat) {
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
                             $GLOBALS['deptname'] = "Others";
                             
                             $GLOBALS['deptid'] = "dept".$rootCat['catdeptid'];
                             
                             $output .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("CategoryDepartment");
                             $output .= "<ul id='".$GLOBALS['deptid']."'>";   
                             //$output .= "<ul><li style='background-color: rgb(255, 15, 25);font-size:12px'>".$dept[$rootCat['catdeptid']]."</li></ul><ul>";
                             $temp_dept = $rootCat['catdeptid'];
                        }

                        if($catg_selected != $rootCat['catname'])  {   
                        $GLOBALS['SubCategoryList'] = $this->GetSubCategory($categories, $rootCat['categoryid']);
                        $GLOBALS['LastChildClass']='';
                        $GLOBALS['CategoryName'] = isc_html_escape($rootCat['catname']);
                        //if(eregi('search.php',$_SERVER['REQUEST_URI']))
                        //echo $_SERVER['REQUEST_URI'];
                        $GLOBALS['CategoryLink'] = "$path/search.php?search_query=".urlencode($rootCat['catname'])."$mmy_links";
                        //else
                        //$GLOBALS['CategoryLink'] = CatLink($rootCat['categoryid'], $rootCat['catname'], true);
                        $output .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideCategoryList");
                        }
                    }
                   
            }

			if(!$output) {
				$this->DontDisplay = true;
				return;
			}

			$GLOBALS['SNIPPETS']['SideCategoryList'] = $output;
		}


		/**
        * @desc Create Category links
        * @params Rootcatname
        */
        function LeftCatLink($RootCatName)
        {
            $NewLink = '';
            if ($GLOBALS['EnableSEOUrls'] == 1) {
                $NewLink = sprintf("%s/%s", GetConfig('ShopPath'), MakeURLSafe(strtolower($RootCatName)));
            } else {
                $NewLink = sprintf("%s/search.php?search_query=%s", GetConfig('ShopPath'), MakeURLSafe($RootCatName));
            }
            return $NewLink;
        }

		/**
		* get the html for sub category list
		*
		* @param array $categories the array of all categories in a tree structure
		* @param int $parentCatId the parent category ID of the sub category list
		*
		* return string the html of the sub category list
		*/
		function GetSubCategory($categories, $parentCatId)
		{

			$output = '';
			//if there is sub category for this parent cat
			if (isset($categories[$parentCatId]) && !empty($categories[$parentCatId])) {
				$i=1;
				foreach ($categories[$parentCatId] as $subCat) {
					// If we don't have permission to view this category then skip
					if (!CustomerGroupHasAccessToCategory($subCat['categoryid'])) {
						continue;
					}
					$catLink = CatLink($subCat['categoryid'], $subCat['catname'], false);
					$catName = isc_html_escape($subCat['catname']);

					$GLOBALS['SubCategoryList'] = $this->GetSubCategory($categories, $subCat['categoryid']);

					//set the class for the last category of its parent category
					$GLOBALS['LastChildClass']='';
					if($i == count($categories[$parentCatId])) {
						$GLOBALS['LastChildClass']='LastChild';
					}
					$i++;

					$GLOBALS['CategoryName'] = $catName;
					$GLOBALS['CategoryLink'] = $catLink;
					$output .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideCategoryList");
				}
			}
			if ($output!='') {
				$output = '<ul>'.$output.'</ul>';
			}
			return $output;
		}

		/**
		* get the category list
		*
		* return array of category list
		*/
		function GetValidCategories()  {   

            $aquery   = array();   

            $aquery[] = "CREATE TEMPORARY TABLE temp
                    SELECT DISTINCT ca.categoryid 
                    FROM isc_products p
                    INNER JOIN isc_categoryassociations ca ON p.productid = ca.productid
                    WHERE prodvisible='1'";

            $aquery[] = "CREATE TEMPORARY TABLE cats
                    SELECT DISTINCT c.categoryid, c.catname
                    FROM temp t
                    INNER JOIN isc_categories c ON t.categoryid = c.categoryid
                    WHERE c.catvisible = 1 AND catparentid = 0";

            $aquery[] = "INSERT INTO cats
                    SELECT DISTINCT c.categoryid, c.catname
                    FROM isc_categories sc
                    INNER JOIN temp t ON t.categoryid = sc.categoryid
                    INNER JOIN isc_categories c ON sc.catparentid = c.categoryid
                    WHERE c.catvisible = 1";
                    
            for($i=0; $i<count($aquery); $i++)
            {
                $result = $GLOBALS['ISC_CLASS_DB']->Query($aquery[$i]); 
            }

            $query = "SELECT DISTINCT * FROM cats ORDER BY 1";
                    
            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);        

            $validcats = array();

            while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                $validcats[] = $row['categoryid'];    
            }

            $aquery   = array();
            $aquery[] = "DROP TABLE cats";
            $aquery[] = "DROP TABLE temp";

            for($i=0; $i<count($aquery); $i++)
            {
                $result = $GLOBALS['ISC_CLASS_DB']->Query($aquery[$i]); 
            }

            return $validcats;
          
        }
        

	}
?>
