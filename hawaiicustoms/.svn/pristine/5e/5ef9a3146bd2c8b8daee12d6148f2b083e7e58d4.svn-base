<?php

	class ISC_ADMIN_CATEGORY
	{
		public $tree = null;
        public $dep = 0;
        public $firstdept = 0;
        
		private $catsCached = false;

		public function __construct()
		{
			$this->tree = new Tree();
		}

		public function HandleToDo($Do)
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('categories');

			switch (isc_strtolower($Do))
			{
				case "saveupdatedcategory":
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Categories)) {
						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Categories') => "index.php?ToDo=viewCategories");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->SaveUpdatedCategory();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}

					break;
				}
				case "editcategory":
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Categories)) {
						$catid = $_GET['catId'];
                        $deptid = "deptid=".$_GET['deptid'];
						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Categories') => "index.php?ToDo=viewCategories&$deptid#Universal_$catid", GetLang('EditCategory1') => "index.php?ToDo=editCategory");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->EditCategory();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}

					break;
				}
				case "savecategory":
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Create_Category)) {
						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Categories') => "index.php?ToDo=viewCategories");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->SaveCategory();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}

					break;
				}
				case "createcategory":
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Create_Category)) {
						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Categories') => "index.php?ToDo=viewCategories", GetLang('CreateCategory') => "index.php?ToDo=addCategory");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->CreateCategory();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}

					break;
				}
				case "editcategoryvisibility":
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Categories)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Categories') => "index.php?ToDo=viewCategories");

						if(!isset($_REQUEST['ajax'])) {
							$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						}

						$this->EditCategoryVisibility();

						if(!isset($_REQUEST['ajax'])) {
							$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						}

						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				 case "editcategoryapprove":
                    if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Categories)) {

                        $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Categories') => "index.php?ToDo=viewCategories");

                        if(!isset($_REQUEST['ajax'])) {
                            $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        }
                         
                        $this->editCategoryApprove();

                        if(!isset($_REQUEST['ajax'])) {
                            $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        }

                        die();
                    } else {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
                    }
                    break; 
                case "editcategoryuniversal":
                    if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Categories)) {

                        $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Categories') => "index.php?ToDo=viewCategories");

                        if(!isset($_REQUEST['ajax'])) {
                            $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        }
                         
                        $this->editCategoryUniversal();

                        if(!isset($_REQUEST['ajax'])) {
                            $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        }

                        die();
                    } else {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
                    }
                    break;
                 case "editcategorypopular":
                    if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Categories)) {

                        $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Categories') => "index.php?ToDo=viewCategories");

                        if(!isset($_REQUEST['ajax'])) {
                            $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        }
                         
                        $this->editCategoryPopular();

                        if(!isset($_REQUEST['ajax'])) {
                            $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        }

                        die();
                    } else {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
                    }
                    break;
				case "deletecategory":
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Delete_Categories)) {
						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Categories') => "index.php?ToDo=viewCategories");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->DeleteCategory();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
				}
				//wirror_20100802
				case "getcategoryprods":
				{
					echo $this->GetProductOptions(array(), "<option %s value='%d'>%s</option>", 'selected="selected"', " ", false);

					break;
				}
				default:
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Categories)) {
						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Categories') => "index.php?ToDo=viewCategories");

						$GLOBALS['InfoTip'] = GetLang('InfoTipManageCategories');

                        if(!isset($_REQUEST['ajax'])) { 
						    $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        }
						$this->ManageCategories();
                        if(!isset($_REQUEST['ajax'])) { 
						    $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        }
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
				}
			}
		}
		
		//wirror_20100811: an ajax call for selected condtion to show products
		public function GetProductOptions($SelectedProducts = 0, $Container = "<option %s value='%d'>%s</option>", $Sel = "selected=\"selected\"", $Divider = "- ", $IncludeEmpty = true, $visible='', $visibleProducts=array()){
			
			$products = '';

			// Make sure $SelectedProducts is an array
            if (!is_array($SelectedProducts)) {
                $SelectedProducts = array();
            }

            if (empty($SelectedProducts) || in_array("0", $SelectedProducts)) {
                $sel = 'selected="selected"';
            } else {
                $sel = "";
            }
			
			$query = "
				SELECT p.productid, prodname
				FROM [|PREFIX|]products p
			    LEFT JOIN [|PREFIX|]categoryassociations ca on ca.productid = p.productid 
				LEFT JOIN [|PREFIX|]categories c on c.categoryid = ca.categoryid and c.catvisible = 1 
				WHERE 1=1 
				AND p.prodvisible='1'
			";
			
			if(isset($_GET['category'])&&$_GET['category']!=0)
			{
				$query .= " AND c.catparentid=".$_GET['category'];
				if(isset($_GET['subscategory'])&&$_GET['subscategory']!=0)
				{
					$query .= " AND c.categoryid=".$_GET['subscategory'];
				}
			}
			
			if(isset($_GET['brand'])&&$_GET['brand']!=0)
			{
				$query .= " AND p.prodbrandid=".$_GET['brand'];
			}
			if(isset($_GET['series'])&&$_GET['series']!=0)
			{
				$query .= " AND p.brandseriesid=".$_GET['series'];
			}
			
			$query .= "
				GROUP BY prodname
			    ORDER BY prodname ASC					
			";

			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$sid    = $row['productid'];    
                $sname  = $row['prodname'];    
                if (in_array($sid, $SelectedProducts)) {
                    $s = $Sel;
                } else {
                    $s = '';
                }                    
                $products .= sprintf($Container, $s, $sid, $sname);
			}
			
			return $products;
		}
		
		//wirror_20100729: list series by brands
		private function FilterSeries() {     
            //$brands = explode(',', $_GET['brandids']); 
            $brands = array();
            
            if(isset($_GET['brandid']))    {
                $brands[] = $_GET['brandid'];
            }                  
            if(!isset($_GET['seriesid']))
            {
                $selectedSeries = array();
            }  
            else    {
                $selectedSeries = array(trim($_GET['seriesid']));
            }
                                                
            $GLOBALS['ISC_CLASS_ADMIN_BRANDS'] = GetClass('ISC_ADMIN_BRANDS');
            $GLOBALS['FilteredSeriesList']  = '<select size="1" name="serieslist" id="serieslist" onchange="FilterReviews();" class="Field200">';
            $GLOBALS['FilteredSeriesList'] .= "<option value='0'>All Series</option>";
            $GLOBALS['FilteredSeriesList'] .= $GLOBALS["ISC_CLASS_ADMIN_BRANDS"]->GetSeriesOptions($selectedSeries, "<option %s value='%d'>%s</option>", 'selected="selected"', " ", false, $brands);
            $GLOBALS['FilteredSeriesList'] .= '</select>';
            
            return $GLOBALS['FilteredSeriesList'];

        }
        
        //wirror_20100729: list subcategories
        private function ListSubCategories() {	
			if(!isset($_GET['catid']))
            {
                $selectedCategory = 0;
            }  
            else    {
                $selectedCategory = $_GET['catid'];
            }
			if(!isset($_GET['subcatid']))
            {
                $selectedSubCategory = 0;
            }  
            else    {
                $selectedSubCategory = $_GET['subcatid'];
            }
            
            $GLOBALS['SubCategoriesList']  = '<select name="subcategorieslist" id="subcategorieslist" class="Field200" onchange="FilterReviews();">';
            $GLOBALS['SubCategoriesList'] .= "<option value='0'>All Sub-categories</option>";
            if (isset($selectedCategory) && $selectedCategory!=0) {
            	$GLOBALS['SubCategoriesList'] .= $this->GetFlatCategories($selectedSubCategory, "<option %s value='%d'>%s</option>", "selected=\"selected\"", $selectedCategory);
            }
            $GLOBALS['SubCategoriesList'] .= '</select>';		
			return $GLOBALS['SubCategoriesList'];
		}

		/**
		* getCatsInfo
		* Get all the information for the categories and save them in the arrays
		* $this->catsById to signify what each of them
		* is indexed by. All functions accessing categories should check to see
		* if one of these arrays already has values and if its empty, call this
		* function to populate it. This allows the arrays to serve as a cache
		* ensuring that the database isn't hit excessively for info on cats
		*
		* @return void
		*/
		public function getCatsInfo($visible = '')
		{
			if ($this->catsCached) {
				return;
			}

			if ($visible === 1 || $visible === 0) {
				$visibleSql = ' AND catvisible = '.$visible;
			} else {
				$visibleSql = '';
			}

			$query = "SELECT *
				FROM [|PREFIX|]categories
				WHERE categoryid>0
				".$visibleSql."
				ORDER BY catsort asc, catname asc";

			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$this->catsById[$row['categoryid']] = $row;
				$this->tree->nodesByPid[(int) $row['catparentid']][] = (int) $row['categoryid'];
			}

			$this->catsCached = true;
		}

		/**
		* getCats
		* Returns an array of categories, each indented and prefixed depending
		* on it's position in the category structure. This function calls itself
		* recursively.
		*
		* @param string $stalk What to prefix a question with to signify it is
		* a descendant of its parent
		* @param int $parentid The category id to get descdendants of
		* @param string $prefix This string grows with whitespace depending on
		* the depth of the item in the tree
		*
		* @return array The formatted array of categories
		*/
		public function getCats($stalk = '`- ', $parentid=0, $prefix='', $visible='')
		{
			$subs = array();
			$formatted = array();

			// If we don't have any data get it from the db
			$this->getCatsInfo($visible);
			if (empty($this->tree->nodesByPid)) {
				$parentid = 0;
			}

			if (!isset($this->tree->nodesByPid[$parentid])) {
				return $formatted;
			}

			// Create the formatted array
			foreach ($this->tree->nodesByPid[$parentid] as $k => $catid) {
				$cat = $this->catsById[$catid];
				if (!empty($prefix)) {
					$formatted[$cat['categoryid']] = $prefix.$stalk.isc_html_escape($cat['catname']);
				} else {
					$formatted[$cat['categoryid']] = $prefix.isc_html_escape($cat['catname']);
				}
				$subs = $this->getCats($stalk, $cat['categoryid'], $prefix.'&nbsp;&nbsp;&nbsp;&nbsp;', $visible);
				$formatted = $formatted + $subs;
			}

			return $formatted;
		}

		/**
		* _GetSubCount
		* Returns the number of sub categories under a given categoryid
		*
		* @param int $catid The catid to get the number of subcats for
		*
		* @return int The number of sub categories of $catid
		*/
		private function _GetSubCount($catid)
		{
			$this->getCatsInfo();
			return $this->tree->GetNodeCount($catid);
		}

		public function GetCatNameFromArray(&$CatArray, $CatId)
		{
			// Pass in an array by reference and loop through to find
			// the indented category name. Once found, return it.

			foreach ($CatArray as $c) {
				if ($c[0] == $CatId) {
					if (isset($c[1])) {
						return $c[1];
					}
					else {
						return "";
					}
				}
			}

			return "";
		}

		private function _BuildCategoryList($parentid=0)
		{
			static $categorycache, $product_counts;

            if(!isset($_REQUEST['deptid']))    {
                $resdeptid = 0;
            }
            else    {
                $resdeptid = $_REQUEST['deptid'];  
            }
            
			if(!is_array($categorycache)) {
//                $query = "SELECT * FROM [|PREFIX|]categories ORDER BY catdeptid ASC, catsort ASC, catname ASC";
                $query = "SELECT [|PREFIX|]categories . * , [|PREFIX|]users.username FROM [|PREFIX|]categories JOIN [|PREFIX|]users ON [|PREFIX|]categories.catuserid = [|PREFIX|]users.pk_userid WHERE 1=1 ";
                
                if($resdeptid != 0)    {
                     $query .= " AND catdeptid=".$resdeptid;
                }
                
                $query .= " ORDER BY catdeptid ASC , catsort ASC , catname ASC";
                
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					$categorycache[$row['catparentid']][] = $row;
				}

				//lguan_20100611: To enable product rating in categories view
				// $query = "select categoryid, count(productid) as total from [|PREFIX|]categoryassociations group by categoryid";
				$query = "select c.categoryid, count(c.productid) as total,SUM(p.prodratingtotal)/SUM(p.prodnumratings) AS prodavgrating ";
				$query .= "from [|PREFIX|]categoryassociations c INNER JOIN [|PREFIX|]products p on c.productid=p.productid group by c.categoryid";
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

				while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					$product_counts[$row['categoryid']][0] = $row['total'];
					$product_counts[$row['categoryid']][1] = $row['prodavgrating'];
				}

			}

			if(!isset($categorycache[$parentid])) {
				return '';
			}

			$categoryList = '';

			foreach($categorycache[$parentid] as $category) {
                
                $deptid = $category['catdeptid'];    

                if ($this->dep != $deptid)
                {
                $GLOBALS['Dept'] = $this->getDeptName($category['catdeptid']);
                $GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("category.dep.row");
                $categoryList .= $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate(true);
                }   
               if ($deptid != 0) $this->dep =  $deptid;  

                
				$GLOBALS['SubCats'] = $this->_BuildCategoryList($category['categoryid']);
				if($GLOBALS['SubCats']) {
					$GLOBALS['SubCats'] = sprintf('<ul class="SortableList">%s</ul>', $GLOBALS['SubCats']);
				}

				$GLOBALS['CatId'] = (int) $category['categoryid'];
				$cid = $category['categoryid'];
				$GLOBALS['CatName'] = isc_html_escape($category['catname']);
				$uid = $category['catuserid'];
                /*$user_query = $GLOBALS['ISC_CLASS_DB']->Query("SELECT username from [|PREFIX|]users where pk_userid = '$uid'");
                $user_name = $GLOBALS['ISC_CLASS_DB']->Fetch($user_query);   
                $uname = $user_name['username'];  */
                $uname = $category['username'];  
                $universal = "universal";
                $visible = "visible";
                $pending = "pending";
                $popular = "popular";

				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Categories)) {
                    if($category['catpopular'] == 1){
                        $GLOBALS['Popular'] = "<a id='Popular_".$category['categoryid']."' title='".GetLang('ClickToNotPopular')."' href='index.php?ToDo=editcategorypopular&amp;catId=".$category['categoryid']."&amp;popular=0' onclick=\"quickToggle(this,'$popular'); return false;\"><img border='0' src='images/tick.gif' alt='Popular'></a>";
                    }
                    else {
                        $GLOBALS['Popular'] = "<a id='Popular_".$category['categoryid']."' title='".GetLang('ClickToPopular')."' href='index.php?ToDo=editcategorypopular&amp;catId=".$category['categoryid']."&amp;popular=1' onclick=\"quickToggle(this,'$popular'); return false;\"><img border='0' src='images/cross.gif' alt='UnPopular'></a>";
                    }
                    if($category['catuniversal'] == 1){
                        $GLOBALS['Universal'] = "<a id='Universal_".$category['categoryid']."' title='".GetLang('ClickToNotUniversal')."' href='index.php?ToDo=editcategoryuniversal&amp;catId=".$category['categoryid']."&amp;visible=0' onclick=\"quickToggle(this,'$universal'); return false;\"><img border='0' src='images/tick.gif' alt='Universal'></a>";
                    }
                    else {
                        $GLOBALS['Universal'] = "<a id='Universal_".$category['categoryid']."' title='".GetLang('ClickToUniversal')."' href='index.php?ToDo=editcategoryuniversal&amp;catId=".$category['categoryid']."&amp;visible=1' onclick=\"quickToggle(this,'$universal'); return false;\"><img border='0' src='images/cross.gif' alt='Not Universal'></a>";
                    }
                    if ($category['catvisible'] == 1) {
                        $user = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetUser(); 
                        $name = $user['username'];
                        $GLOBALS['Pending'] = "<a id='CatApprove_".$category['categoryid']."' title='".GetLang('ClickToDeny')."' href='index.php?ToDo=editCategoryApprove&amp;catId=".$category['categoryid']."&amp;approve=2' onclick=\"quickToggle(this,'$pending'); return false;\"><img border='0' src='images/tick.gif' alt='Approved'></a><div id='$cid' style='display:none'>($uname)</div>";
                        $GLOBALS['CatVisible'] = "<a id='CatVisible_".$category['categoryid']."' title='".GetLang('ClickToHideCategory')."' href='index.php?ToDo=editCategoryVisibility&amp;catId=".$category['categoryid']."&amp;visible=0' onclick=\"quickToggle(this,'$visible'); return false;\"><img border='0' src='images/tick.gif' alt='Visible'></a>";
                    } else if($category['catvisible'] == 2){
                        $GLOBALS['Pending'] = "<a id='CatApprove_".$category['categoryid']."' title='".GetLang('ClickToApprove')."' href='index.php?ToDo=editCategoryApprove&amp;catId=".$category['categoryid']."&amp;approve=1' onclick=\"quickToggle(this,'$pending'); return false;\"><img border='0' src='images/cross.gif' alt='Deny'></a><div id='$cid'>($uname)</div>";
                        $GLOBALS['CatVisible'] = "<a id='CatVisible_".$category['categoryid']."' title='".GetLang('ClickToShowCategory')."' href='index.php?ToDo=editCategoryVisibility&amp;catId=".$category['categoryid']."&amp;visible=1' onclick=\"quickToggle(this,'$visible'); return false;\"><img border='0' src='images/cross.gif' alt='Invisible'></a>";
                    }
                    else {
                        $GLOBALS['Pending'] = "<a id='CatApprove_".$category['categoryid']."' title='".GetLang('ClickToDeny')."' href='index.php?ToDo=editCategoryApprove&amp;catId=".$category['categoryid']."&amp;approve=2' onclick=\"quickToggle(this,'$pending'); return false;\"><img border='0' src='images/tick.gif' alt='Approved'></a><div id='$cid' style='display:none'>($uname)</div>";
                        $GLOBALS['CatVisible'] = "<a id='CatVisible_".$category['categoryid']."' title='".GetLang('ClickToShowCategory')."' href='index.php?ToDo=editCategoryVisibility&amp;catId=".$category['categoryid']."&amp;visible=1' onclick=\"quickToggle(this,'$visible'); return false;\"><img border='0' src='images/cross.gif' alt='Invisible'></a>";
                    }                    
                } else {
                    if($category['catpopular'] == 1){
                        $GLOBALS['Popular'] = '<img border="0" src="images/tick.gif" alt="Popular">';
                    }
                    else {
                        $GLOBALS['Popular'] = '<img border="0" src="images/cross.gif" alt="UnPopular">';
                    }
                    if($category['catuniversal'] == 1){
                        $GLOBALS['Universal'] = '<img border="0" src="images/tick.gif" alt="Universal">';
                    }
                    else {
                        $GLOBALS['Universal'] = '<img border="0" src="images/cross.gif" alt="Not Universal">';
                    }
                    if ($category['catvisible'] == 1) {
                        $GLOBALS['CatVisible'] = '<img border="0" src="images/tick.gif" alt="Visible">';
                        $GLOBALS['Pending'] = '<img border="0" src="images/tick.gif" alt="Approved">';
                    }
                    else if ($category['catvisible'] == 2) {
                        $GLOBALS['CatVisible'] = '<img border="0" src="images/cross.gif" alt="Invisible">';
                        $GLOBALS['Pending'] = '<img border="0" src="images/cross.gif" alt="Deny">';
                    }
                     else {
                        $GLOBALS['CatVisible'] = '<img border="0" src="images/cross.gif" alt="Invisible">';
                        $GLOBALS['Pending'] = '<img border="0" src="images/tick.gif" alt="Approved">';
                    }
                }
                 /* Baskaran added starts */
                if($category['catparentid'] == 0){
                    $catid = $category['categoryid'];
                    $catquery = $GLOBALS['ISC_CLASS_DB']->Query("SELECT categoryid FROM [|PREFIX|]categories where catparentid = $catid");
//                    $catquery = $GLOBALS['ISC_CLASS_DB']->Query("SELECT categoryid FROM [|PREFIX|]categories where catparentid = $catid and catdeptid = ".$resdeptid);
                    $catlistid = array();
                    while($catrow = $GLOBALS['ISC_CLASS_DB']->Fetch($catquery)) {
                        $catlistid[] = $catrow['categoryid'];
                    }
                    $catcountlist = implode(",",$catlistid);
                    $prodcount = '';
					//lguan_20100612: Changed following codes to get product rating for categories
                    if(count($catlistid) > 0){
                        $prodcount = $GLOBALS['ISC_CLASS_DB']->Query("SELECT count(*) as prodcount, SUM(p.prodratingtotal)/SUM(p.prodnumratings) AS prodavgrating FROM [|PREFIX|]categoryassociations c INNER JOIN [|PREFIX|]products p on c.productid=p.productid where c.categoryid IN ($catid,$catcountlist)"); 
                    }
                    else {
                        $prodcount = $GLOBALS['ISC_CLASS_DB']->Query("SELECT count(*) as prodcount, SUM(p.prodratingtotal)/SUM(p.prodnumratings) AS prodavgrating FROM [|PREFIX|]categoryassociations c INNER JOIN [|PREFIX|]products p on c.productid=p.productid where c.categoryid IN ($catid)"); 
                    }
                    $prodrow = $GLOBALS['ISC_CLASS_DB']->Fetch($prodcount);
//                    if(count($catlistid) > 0){
                        $GLOBALS['Products'] = $prodrow['prodcount'];
                    /*}
                    else {
                        $GLOBALS['Products'] = 0;
                    } */
					//lguan_20100612: Showing product ratings for parent categories
					if($prodrow['prodavgrating'] > 0)    {          
				        $GLOBALS['Rating'] = "";
				        /*for ($r = 0; $r < $prodrow['prodavgrating']; $r++) {
				            $GLOBALS['Rating'] .= "<img title='%s' width='13' height='12' src='images/rating_on.gif'>";
				        }
				        for ($r = $prodrow['prodavgrating']; $r < 5; $r++) {
				            $GLOBALS['Rating'] .= "<img title='%s' width='13' height='12' src='images/rating_off.gif'>";
				        }*/
				        $ratedValue = $this->getRoundValue($prodrow['prodavgrating']);
        				//$ratingText = sprintf(GetLang('ReviewRated'), $ratedValue);
        				$ratingHtml = sprintf("<img title=''  src='images/IcoRating%s.gif'>", $ratedValue);
        				 $GLOBALS['Rating'] = $ratingHtml;
				    }
				    else    {
				        $GLOBALS['Rating'] = "Not Rated";
				    }
                }  /* Baskaran added ends*/
				else if (isset($product_counts[$category['categoryid']][0])) {
					$GLOBALS['Products'] = (int) $product_counts[$category['categoryid']][0];
				    //lguan_20100611: For enable product rating in product categories
				    if(isset($product_counts[$category['categoryid']][1]) && ($product_counts[$category['categoryid']][1] > 0))    {          
				        $GLOBALS['Rating'] = "";
				       /* for ($r = 0; $r < $product_counts[$category['categoryid']][1]; $r++) {
				            $GLOBALS['Rating'] .= "<img title='%s' width='13' height='12' src='images/rating_on.gif'>";
				        }
				        for ($r = $product_counts[$category['categoryid']][1]; $r < 5; $r++) {
				            $GLOBALS['Rating'] .= "<img title='%s' width='13' height='12' src='images/rating_off.gif'>";
				        }*/
				        $ratedValue = $this->getRoundValue($product_counts[$category['categoryid']][1]);
        				//$ratingText = sprintf(GetLang('ReviewRated'), $ratedValue);
        				$ratingHtml = sprintf("<img title=''  src='images/IcoRating%s.gif'>", $ratedValue);
        				 $GLOBALS['Rating'] = $ratingHtml;
				    }
				    else    {
				        $GLOBALS['Rating'] = "Not Rated";
				    }
				}
				else {
					$GLOBALS['Products'] = 0;
				    $GLOBALS['Rating'] = "Not Rated";
				}
				
				// lguan_20100612: Build up the view feedback link for both root category and sub category
				$GLOBALS['ViewFeedbackLink'] = sprintf("<a title='%s' class='Action' href='index.php?ToDo=viewReviews&amp;catid=%d&amp;subcatid=%d'>%s</a>", 
														GetLang('ViewFeedback'), 
														($category['catparentid'] == 0) ? $category['categoryid'] : $category['catparentid'],
														($category['catparentid'] == 0) ? 0 : $category['categoryid'], 
														GetLang('ViewFeedback'));				

				$GLOBALS['ViewLink'] = sprintf("<a title='%s' href=\"%s\" class=\"bodylink\" target='_blank'>%s</a>", GetLang('ViewCategory'), sprintf("%s/search.php?search_query=%s", $GLOBALS['ShopPathNormal'], urlencode($category['catname'])), GetLang('View'));

				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Create_Category)) {
					$GLOBALS['NewLink'] = sprintf("<a title='%s' href=\"index.php?ToDo=createCategory&amp;parentId=%s\" class=\"bodylink\">%s</a>", GetLang('NewCategory'), $category['categoryid'], GetLang('New'));
				} else {
					$GLOBALS['NewLink'] = sprintf("<a disabled class=\"bodylink\">%s</a>", GetLang('New'));
				}

				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Categories)) {
					$GLOBALS['EditLink'] = sprintf("<a title='%s' href=\"index.php?ToDo=editCategory&amp;catId=%s&amp;deptid=%d\" class=\"bodylink\">%s</a>", GetLang('EditCategory'), $category['categoryid'], $deptid, GetLang('Edit'));
				} else {
					$GLOBALS['EditLink'] = sprintf("<a disabled class=\"bodylink\">%s</a>", GetLang('Edit'));
				}

				if (!$GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Delete_Categories)) {
					$GLOBALS['DisableDelete'] = "DISABLED";
				}

				$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("category.manage.row");
				$GLOBALS['CategoryGrid'] .= $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate(true);
				$categoryList .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
			}
			return $categoryList;
		}
		 //process num,return int,int+0.5.
        // just show the right rating images.
	  private function getRoundValue($num)
        {
        	$i = floor($num);
        	$r = $num-$i;
        	if($r <0.3)
        	{
        		return $i;
        	}
        	else if($r >0.7)
        	{
        		return round($num);
        	}
        	else 
        	{
        		return $i + 0.5;
        	}
        }

		private function ManageCategories($MsgDesc = "", $MsgStatus = "")
		{
			// Show a list of categories to edit/delete
			$arrCatList = array();
			$GLOBALS['CategoryGrid'] = "";

			// If d is set, we've deleted a category. For some strange reason
			// it shows a duplicate list of categories if we don't explicitly
			// refresh the page.
			if (isset($_GET['d'])) {
				$MsgDesc = GetLang('CatDeletedSuccessfully');
				$MsgStatus = MSG_SUCCESS;
			}

            
            //For Department Options Added by Simha 
            $deptid = '';
            if(isset($_GET['deptid'])) {
                $deptid = $_GET['deptid'];
            }  
            $GLOBALS['DeptFilterOptions'] = $this->getDepartmentList($deptid);
            if(!isset($_REQUEST['deptid']))    {
                $_REQUEST['deptid'] = $this->firstdept;
            }
            //For Department Options  Ends Added by Simha
            
			$GLOBALS['Message'] = '';
			if ($MsgDesc != "") {
				$GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
			}
			$GLOBALS['Message'] .= GetFlashMessageBoxes();

			$GLOBALS['CategoryGrid'] = $this->_BuildCategoryList(0);

            $_SESSION['congocatname'] = ''; # Baskaran
            $_SESSION['congoseries'] = '';
            $_SESSION['congobrand'] = '';

			if(isset($_REQUEST['focuspage']))
            {
                $GLOBALS['FocusPage'] = "location.href='#".$_REQUEST['focuspage']."'";
            }

			if (!empty($GLOBALS['CategoryGrid'])) {                    
                $GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("category.manage.grid");
                $GLOBALS['FullCategoryGrid'] = $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate(true);     
                // Was this an ajax based sort? Return the table now
                if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 1) {
                    echo $GLOBALS['FullCategoryGrid'];
                    return;
                }      
				$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("category.manage");
				$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
			} else {
                if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 1) {
                    echo 'No categories found for the selected department';
                    return;
                } 
				// There aren't any questions, show a message so they can create some
				$MsgDesc = GetLang('NoCategories');
				$MsgStatus = MSG_SUCCESS;
				if ($MsgDesc === '') {
					$GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
				}

				$GLOBALS['DisableDelete'] = "DISABLED";

				$GLOBALS['Title'] = GetLang('ManageCategories');
				$GLOBALS['ManageCatIntro'] = GetLang('ManageCatIntro');
				$GLOBALS['ButtonText'] = GetLang('CreateCategory');
				$GLOBALS['ButtonClass'] = "Field150";
				$GLOBALS['URL'] = "index.php?ToDo=createCategory";
				$GLOBALS['DisplayGrid'] = "none";

				$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("category.manage");
				$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
			}
		}

		private function DeleteCategory()
		{
			include_once(ISC_BASE_PATH.'/lib/api/category.api.php');

			$category = new API_CATEGORY();

			if ($category->multiDelete($_POST['categories'])) {

				// Log this action
				$GLOBALS['ISC_CLASS_LOG']->LogAdminAction(count($_POST['categories']));
				//delete category brand cache file,let it rebuild.	NI_Mike 2010.11.25			
				$this->UpdateCategoryBrandProductCache();
				ob_end_clean();
				header("Location: index.php?ToDo=viewCategories&d=1");
				die();
			} else {
				echo $category->error;
			}
		}
		
		//wirror_20100806: get custom contentType options
		private function _GetContentTypeOptions($selectValue = 0)
		{
			$options = '';
			$optionArr = array('Dynamic'=>0, 'Custom'=>1);
			foreach($optionArr as $key=>$val){
				if($selectValue == $val)
					$options .= "<option value='$val' selected='selected'>$key</option>";
				else
					$options .= "<option value='$val'>$key</option>";
			}
			
			return $options;
		}

		private function CreateCategory($Exists = false)
		{
			$GLOBALS['Message'] = GetFlashMessageBoxes();
			//wirror_20100804: remove the cookie CustomContentId, and fetch current CustomContentId from table category
			$customItem = array(
				'contenttype' => 1,
				'description' => "custom products content for category#$catId"
			);
			$contentId = GetClass('ISC_ADMIN_CUSTOMCONTENTS')->createCustomContens($customItem);
			
			//wirror_20100806: show the custom content options
			$GLOBALS['ContentOptions'] = $this->_GetContentTypeOptions();
			$GLOBALS['CustomPageAction'] = 'listCateCustomcontents&customContentId='.$contentId;
			
			#wirror_20100805: hide the custom content id
			$GLOBALS['hiddenFields'] = sprintf("<input type='hidden' id='customContentId' name='customContentId' value='%d'>", $contentId);

			// Create a new category
			$name = "";
			$cat = array();
            $cid = "";

			if (isset($_GET['parentId'])) {
				$cat[] = $_GET['parentId'];
                $cid = $_GET['parentId'];
                $GLOBALS['disabledept'] = 'disabled="disabled"';                
			}

			if ($Exists) {
				// The user has tried to create a category that already exists
				$GLOBALS['Message'] = MessageBox(sprintf(GetLang('CatAlreadyExists'), $_POST['catname']), MSG_ERROR);

				$name = $_POST['catname'];
				$cat[] = $_POST['category'];
			}

			//wirror_20100806: show the custom content options
			$GLOBALS['ContentOptions'] = $this->_GetContentTypeOptions();
			
			$GLOBALS['CategoryName'] = $name;
			$GLOBALS['CategoryOptions'] = $this->GetCategoryOptions($cat);
			$GLOBALS['CategorySort'] = "0"; 
            $GLOBALS['CategorySelect'] = '<select size="5" name="catparentid" id="catparentid" class="Field750" style="height:115" onchange="HandleRootCategory();SelectDept();">';  # Added for to display the category in the Add page -- Baskaran

			$GLOBALS['CategoryPageTitle'] = '';
			$GLOBALS['CategoryMetaKeywords'] = '';
			$GLOBALS['CategoryMetaDesc'] = '';

            /* Baskaran added starts */
            $deptquery = $GLOBALS['ISC_CLASS_DB']->Query("SELECT catdeptid FROM [|PREFIX|]categories where categoryid = '$cid'");
            $deptrow = $GLOBALS['ISC_CLASS_DB']->Fetch($deptquery);
            $deptid = $deptrow['catdeptid'];
            $GLOBALS['CatDeptid'] = $deptid;
            $GLOBALS['CatDepartment'] = $this->getDepartment($deptid);
            $GLOBALS['AltKeyword'] = '';
			$GLOBALS['catuserid'] = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetUserId(); 
            $user = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetUser();
            $userrole = $user['userrole'];
            $catvisible = '';
            if($userrole == 'admin') {
                $catvisible = 1;
            }
            else {
                $catvisible = 2;
            }
            $GLOBALS['catvisible'] = $catvisible;
            /* Baskaran added ends */
			
			$wysiwygOptions = array(
				'id'		=> 'wysiwyg',
				'width'		=> '750px',
				'height'	=> '500px'
			);
            $wysiwygOptions1 = array(
                'id'        => 'wysiwyg1',
                'width'        => '60%',
                'height'    => '300px'
            );
		    $wysiwygOptions2 = array(
				'id'		=> 'wysiwyg2',
				'width'		=> '60%',
				'height'	=> '300px'
			);
			$wysiwygOptions3 = array(
				'id'		=> 'wysiwyg3',
				'width'		=> '60%',
				'height'	=> '300px'
			);
			$GLOBALS['WYSIWYG'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor($wysiwygOptions);
            $GLOBALS['WYSIWYG1'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor1($wysiwygOptions1);
			$GLOBALS['WYSIWYG2'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor1($wysiwygOptions2);
            $GLOBALS['WYSIWYG3'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor1($wysiwygOptions3);
            
            //$SelectedQualifiers = $this->GetSelectedQualifiers($catId);
			$SelectedQualifiers = 0;
            
            $GLOBALS['QualifierOptions'] = $this->GetQualifierOptions($SelectedQualifiers, "<option %s value='%d'>%s</option>", "selected=\"selected\"", "", false); 
            
			$GLOBALS['FormAction'] = "saveCategory";
			$GLOBALS['CatTitle'] = GetLang('AddCatTitle');
			$GLOBALS['CatIntro'] = GetLang('AddCatIntro');
			$GLOBALS['CancelMessage'] = GetLang('CancelCreateCategory');

			if (empty($cat) || in_array("0", $cat)) {
				//$GLOBALS['DisableFileUpload'] = 'disabled="disabled"';
				$GLOBALS['ShowFileUploadMessage'] = '';
                $GLOBALS['ShowHidecatCombine'] = 'none'; 
			} else {
				//$GLOBALS['DisableFileUpload'] = '';
				$GLOBALS['ShowFileUploadMessage'] = 'none';
                $GLOBALS['ShowHidecatCombine'] = '';
			}


$temp = '';
				$pnamearray = array('Category Name', 'Sub Category Name', 'Brand Name','Series Name', 'Part Number', 'Product Code','Product color', 'Product Material', 'Product Style');

				//$savedarray  = explode(",",$category->Productname);   



				foreach ($pnamearray as $key => $value) {

                    

						     $temp.= "<option  value='".$key."' selected='selected' >".$value."</option>";
					
				}

				$GLOBALS['Productname'] =  $temp;
			// Get a list of all layout files
			$GLOBALS['LayoutFiles'] = GetCustomLayoutFilesAsOptions("category.html");

			$GLOBALS['SaveAndAddAnother'] = GetLang('SaveAndAddAnother');

			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("category.form");
			$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
		}
        
        private function GetAllQualifiers() {
            $query = " SELECT qid, column_name, display_names FROM [|PREFIX|]qualifier_names where column_name LIKE 'PQ%' OR column_name LIKE 'VQ%' ORDER BY column_name"; 
            $result = $GLOBALS['ISC_CLASS_DB']->Query($query); 
            $qualifiers = array();
            while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {   
                $qualifiers[$row['qid']]   =  $row['column_name'];
                //$mapping_data.= "<tr><td>".$row['column_name']." : </td><td><input type='text' size='25' value='".$row['display_names']."' name=".$row['column_name']." id=".$row['column_name']." /></td></tr>";  
            }
            return $qualifiers;
        }
       
       
        private function GetSelectedQualifiers($catId) {
            $query = " SELECT mn.qid, mn.column_name, mn.display_names 
                        FROM [|PREFIX|]qualifier_associations qa
                        INNER JOIN [|PREFIX|]qualifier_names mn ON qa.qualifierid = mn.qid 
                        WHERE (mn.column_name LIKE 'PQ%' OR mn.column_name LIKE 'VQ%') AND qa.categoryid='".$catId."' ORDER BY column_name"; 
            $result = $GLOBALS['ISC_CLASS_DB']->Query($query); 
            $qualifiers = array();
            while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {   
                $qualifiers[]   =  $row['qid'];
                //$mapping_data.= "<tr><td>".$row['column_name']." : </td><td><input type='text' size='25' value='".$row['display_names']."' name=".$row['column_name']." id=".$row['column_name']." /></td></tr>";  
            }
            return $qualifiers;
        }
        
		private function SaveCategory()
		{

			$_POST['Productname']  = implode(",",$_POST['Productname']); 
			$error = $this->_CommitCategory();
            
			if (empty($error)) {
				// Log this action
				$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($_POST['catname']);

				if(isset($_POST['AddAnother'])) {
					$location = 'index.php?ToDo=createCategory';
				}
				else {
					$location= 'index.php?ToDo=viewCategories';
				}
				//delete category brand cache file,let it rebuild.	NI_Mike 2010.11.25			
				$this->UpdateCategoryBrandProductCache();
				FlashMessage(sprintf(GetLang('CatSavedSuccessfully'), isc_html_escape($_POST['catname'])), MSG_SUCCESS, $location);
			} else {
				//FlashMessage(sprintf(GetLang('CatNotSaved'), isc_html_escape($_POST['catname'])), MSG_ERROR, 'index.php?ToDo=createCategory');                
                FlashMessage(sprintf($error, isc_html_escape($_POST['catname'])), MSG_ERROR, 'index.php?ToDo=createCategory');    //Language Changed by Simha             
			}
		}

		private function _GetCatData($DataSource, $CatId = 0)
		{
			$arrCat = array();

			if(isset($_POST["wysiwyg_html"])) {
				$_POST['catdesc'] = ISC_ADMIN_PRODUCT::FormatWYSIWYGHTML($_POST['wysiwyg_html']);
			}
			elseif(isset($_POST["wysiwyg"])) {
				$_POST['catdesc'] = ISC_ADMIN_PRODUCT::FormatWYSIWYGHTML($_POST['wysiwyg']);
			}
            if(isset($_POST["wysiwyg1"])) {
                $_POST['WYSIWYG1'] = ISC_ADMIN_PRODUCT::FormatWYSIWYGHTML($_POST['wysiwyg1']);
            }
			if(isset($_POST["wysiwyg2"])) {
                $_POST['wysiwyg2'] = ISC_ADMIN_PRODUCT::FormatWYSIWYGHTML($_POST['wysiwyg2']);
            }
			if(isset($_POST["wysiwyg3"])) {
                $_POST['wysiwyg3'] = ISC_ADMIN_PRODUCT::FormatWYSIWYGHTML($_POST['wysiwyg3']);
            }
			if ($DataSource == ISC_SOURCE_FORM) {
				// Get the details of the category from the database
				$arrCat['catname'] = $_POST['catname'];
				$arrCat['catdesc'] = $_POST['catdesc'];
				$arrCat['category'] = $_POST['catparentid'];
				$arrCat['oldCatId'] = @$_POST['categoryId'];
				$arrCat['catsort'] = (int)$_POST['catsort'];
				$arrCat['catpagetitle'] = $_POST['catpagetitle'];
				$arrCat['catmetakeywords'] = $_POST['catmetakeywords'];
				$arrCat['catmetadesc'] = $_POST['catmetadesc'];
				$arrCat['catlayoutfile'] = $_POST['catlayoutfile'];
                $arrCat['catdeptid'] = $_POST['catdeptid'];
                $arrCat['cataltkeyword'] = $_POST['cataltkeyword'];
                $arrCat['catcombine'] = $_POST['catcombine'];
				$arrCat['EndPrice'] = floatval($_POST['EndPrice']);
                $arrCat['StartPrice'] = floatval($_POST['StartPrice']);
				$arrCat['Productname'] = implode(",", $_POST['Productname']);
                $arrCat['categoryfooter'] = $_POST['wysiwyg1'];
				$arrCat['controlscript'] = $_POST['controlscript'];
				$arrCat['trackingscript'] = $_POST['trackingscript'];
				$arrCat['catimagealt'] = $_POST['catimagealt'];
                $arrCat['featurepoints'] = $_POST['wysiwyg2'];
                $arrCat['divdesc'] = $_POST['wysiwyg3'];
                $arrCat['displayproducts'] = $_POST['displayproducts'];
                //get customcontentid form submitted form
                $arrCat['customContentId'] = $_POST['customContentId'];
                $arrCat['catpagecontent'] = $_POST['catpagecontent'];
			} else {
				// Get category details from the database
				$query = sprintf("select * from [|PREFIX|]categories where categoryid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($CatId));
				$catResult = $GLOBALS["ISC_CLASS_DB"]->Query($query);

				if ($GLOBALS["ISC_CLASS_DB"]->CountResult($catResult) == 1) {
					$arrCat = $GLOBALS["ISC_CLASS_DB"]->Fetch($catResult);
				}
			}

			return $arrCat;
		}

		public function _CommitCategory($CatID = 0)
		{
			include_once(ISC_BASE_PATH.'/lib/api/category.api.php');

			/**
			 * Set this here are the images are going to be handled outside the API
			 */
			$_POST['catimagefile'] = '';
			$_POST['cathoverimagefile'] = '';

			$category = new API_CATEGORY();

			if(isset($_POST["wysiwyg_html"])) {
				$_POST['catdesc'] = ISC_ADMIN_PRODUCT::FormatWYSIWYGHTML($_POST['wysiwyg_html']);
			}
			elseif(isset($_POST["wysiwyg"])) {
				$_POST['catdesc'] = ISC_ADMIN_PRODUCT::FormatWYSIWYGHTML($_POST['wysiwyg']);
			}
            if(isset($_POST["wysiwyg1"])) {
                $_POST['categoryfooter'] = ISC_ADMIN_PRODUCT::FormatWYSIWYGHTML($_POST['wysiwyg1']); # Baskaran
            }
			if(isset($_POST["wysiwyg2"])) {
                $_POST['featurepoints'] = ISC_ADMIN_PRODUCT::FormatWYSIWYGHTML($_POST['wysiwyg2']); # vikas
            }
			if(isset($_POST["wysiwyg3"])) {
                $_POST['divdesc'] = ISC_ADMIN_PRODUCT::FormatWYSIWYGHTML($_POST['wysiwyg3']); # vikas
            }
                        //wirror_20100810: store the two new fields into category table
			$_POST['customcontentid'] = $_POST['customContentId'];
			$_POST['pagecontenttype'] = $_POST['catpagecontent'];
			if ($CatID == 0) {
				$CatID = $category->create() ;
				if($CatID) {
					$GLOBALS['NewCategoryId'] = $CatID;
				}
			} else {
				$category->load($CatID);
				$category->save();
			}

            /* Baskaran Added for combine */
            $rowcat = $GLOBALS["ISC_CLASS_DB"]->Fetch($GLOBALS["ISC_CLASS_DB"]->Query("SELECT * FROM [|PREFIX|]categories WHERE categoryid='" . (int)$CatID . "'"));
            $parentid = $rowcat['catparentid'];
            if($parentid != 0){
                $maincat = $GLOBALS["ISC_CLASS_DB"]->Fetch($GLOBALS["ISC_CLASS_DB"]->Query("SELECT * FROM [|PREFIX|]categories WHERE categoryid='" . (int)$parentid . "'"));                
                $subcat  = strtolower($rowcat['catname']);
                $cat  = strtolower($maincat['catname']);
                $FolderName = $cat;
                $catcombine = '';
                if($rowcat['catcombine'] == '' or empty($rowcat['catcombine'])) {
                    $sc = explode(" ", $subcat);
                    //process 1
                    foreach ($sc as $value) {
                       $cat = str_ireplace($value, " ", $cat );
                      
                    }

                    $c = str_word_count($cat, 1);
                    foreach ($c as $value) {
                       $subcat = str_ireplace($value."s", " ", $subcat );
                       $subcat = str_ireplace($value."es", " ", $subcat );
                      }

                    if (trim($cat) == "s" || trim($cat) == "S") $cat = "";

                    $catcombine = ucwords(trim($subcat." ".$cat));
                }
                else {                                
                    $catcombine = $rowcat['catcombine'];
                }                                
                $GLOBALS["ISC_CLASS_DB"]->UpdateQuery('categories', array('catcombine' => $catcombine), "categoryid='" . (int)$CatID . "'");
            }
            else    {                           
                $FolderName = $_POST['catname'];
            }
            /* Baskaran Ends */

			/**
			 * Do all the image stuff outside the API
			 */
			if (isId($CatID) && array_key_exists('catimagefile', $_FILES)) {      
                $FolderName = preg_replace("#[^\w.]#i", "", $FolderName); 
                $FolderName = strtolower($FolderName); 
				if ($file = $this->SaveCategoryImage($FolderName)) {
					$row = $GLOBALS["ISC_CLASS_DB"]->Fetch($GLOBALS["ISC_CLASS_DB"]->Query("SELECT * FROM [|PREFIX|]categories WHERE categoryid='" . (int)$CatID . "'"));
					if (!isset($GLOBALS['NewCategoryId']) && $row['catimagefile'] !== '') {
						$this->DelCategoryImage($row['catimagefile']);
					}

					$GLOBALS["ISC_CLASS_DB"]->UpdateQuery('categories', array('catimagefile' => $file), "categoryid='" . (int)$CatID . "'");
				}
			}

			if (isId($CatID) && array_key_exists('catimagedel', $_REQUEST) && $_REQUEST['catimagedel']) {
				$row = $GLOBALS["ISC_CLASS_DB"]->Fetch($GLOBALS["ISC_CLASS_DB"]->Query("SELECT * FROM [|PREFIX|]categories WHERE categoryid='" . (int)$CatID . "'"));
				if ($row && $row['catimagefile'] !== '') {
					$this->DelCategoryImage($row['catimagefile']);
				}

				$GLOBALS["ISC_CLASS_DB"]->UpdateQuery('categories', array('catimagefile' => ''), "categoryid='" . (int)$CatID . "'");
			}

			/*
				Added the below code to upload large hover image. - starts - vikas
			*/
			if (isId($CatID) && array_key_exists('cathoverimagefile', $_FILES)) {      
                $FolderName = preg_replace("#[^\w.]#i", "", $FolderName); 
                $FolderName = strtolower($FolderName); 
				if ($file = $this->SaveCategoryHoverImage($FolderName)) {
					$row = $GLOBALS["ISC_CLASS_DB"]->Fetch($GLOBALS["ISC_CLASS_DB"]->Query("SELECT * FROM [|PREFIX|]categories WHERE categoryid='" . (int)$CatID . "'"));
					if (!isset($GLOBALS['NewCategoryId']) && $row['cathoverimagefile'] !== '') {
						$this->DelCategoryHoverImage($row['cathoverimagefile']);
					}

					$GLOBALS["ISC_CLASS_DB"]->UpdateQuery('categories', array('cathoverimagefile' => $file), "categoryid='" . (int)$CatID . "'");
				}
			}

			if (isId($CatID) && array_key_exists('catimagedel', $_REQUEST) && $_REQUEST['catimagedel']) {
				$row = $GLOBALS["ISC_CLASS_DB"]->Fetch($GLOBALS["ISC_CLASS_DB"]->Query("SELECT * FROM [|PREFIX|]categories WHERE categoryid='" . (int)$CatID . "'"));
				if ($row && $row['cathoverimagefile'] !== '') {
					$this->DelCategoryHoverImage($row['cathoverimagefile']);
				}

				$GLOBALS["ISC_CLASS_DB"]->UpdateQuery('categories', array('cathoverimagefile' => ''), "categoryid='" . (int)$CatID . "'");
			}

			/* ------- ends -------- */



            if (isId($CatID))   {
                 $this->UpdateAssociations($CatID);
            }
			return $category->error;
		}

		/**
		 * Get the list of category options to show as parent categories. Prunes impossible
		 * parents from the list
		 *
		 * @param int $CategoryId The Category Id that we are choosing a parent for
		 * @param array The array of selected category ids
		 *
		 * @return string
		 **/
		public function GetCategoryParentOptions($CategoryId, $SelectedCats)
		{
			// Work out which cats we want to keep in the list
			$this->getCatsInfo();

			$cats = '';
			$Container = "<option %s value='%d'>%s</option>";
			$Sel = "selected=\"selected\"";
			$Divider = "- ";

			$impossible_parents = $this->tree->GetBranchFrom($CategoryId, false);
			$impossible_parents[] = $CategoryId;

			$categories = $this->getCats();

			$noParent = '';
			if (in_array('0', $SelectedCats)) {
				$noParent = ' selected="selected"';
			}

			$cats = sprintf("<option value='0'%s>-- %s --</option>\n", $noParent, GetLang("NoParent"));

			foreach ($categories as $cid => $cname) {
				if (in_array($cid, $impossible_parents)) {
					continue;
				}
				if (in_array($cid, $SelectedCats)) {
					$s = $Sel;
				} else {
					$s = '';
				}
				$cats .= sprintf($Container, $s, $cid, $cname);
			}

			unset($this->tree->nodesByPid);
			$this->catsCached = false;

			return $cats;
		}

		/**
		* GetCategoryOptions
		* Get an html options box with categories in it. Categories which are pre
		* selected can be specified as can the format of the html
		*
		* @param array $SelectedCats The cats to pre select in the list
		* @param string $Container The html to use for the option
		* @param string $sel The html to use to signify a cat is selected
		* @param string $Divider The text to prefix sub cats with
		* @param bool $IncludeEmpty Add an option at the top for "
		* please select a category"
		* @param array $hide If not empty then hide catids in this array
		* @param array $visibleCats A list of categories (array) that should be in the select.
		*
		* @return string The html for the options
		*/
		public function GetCategoryOptions($SelectedCats = 0, $Container = "<option %s value='%d'>%s</option>", $Sel = "selected=\"selected\"", $Divider = "- ", $IncludeEmpty = true, $visible='', $visibleCats=array())
		{
			// Get a list of categories as <option> tags
			$cats = '';

			// Make sure $SelectedCats is an array
			if (!is_array($SelectedCats)) {
				$SelectedCats = array();
			}

			if (empty($SelectedCats) || in_array("0", $SelectedCats)) {
				$sel = 'selected="selected"';
			} else {
				$sel = "";
			}

			// Do we include the no parent category item in the list ?
			if ($IncludeEmpty) {
				$cats = sprintf("<option %s value='0'>-- %s --</option>\n", $sel, GetLang("NoParent"));
			}

			// Get a formatted list of all the categories in the system
			$categories = $this->getCats($Divider, 0, '', $visible);

			// Work out which cats we want to keep in the list
			$this->getCatsInfo($visible);

			foreach ($categories as $cid => $cname) {
				// If we're on the front end of the store, do we have permission to view this category?
				if(!defined('ISC_ADMIN_CP') && !CustomerGroupHasAccessToCategory($cid)) {
					continue;
				}
				// Not showing this category in the list
				else if(!empty($visibleCats) && !in_array($cid, $visibleCats)) {
					continue;
				}
				if (in_array($cid, $SelectedCats)) {
					$s = $Sel;
				} else {
					$s = '';
				}
				$cats .= sprintf($Container, $s, $cid, $cname);
			}

			return $cats;
		}

        /* Added by Baskaran */
        public function GetCategoryOptionsProduct($SelectedCats = 0, $Container = "<option %s value='%d'>%s</option>", $Sel = "selected=\"selected\"", $Divider = "- ", $IncludeEmpty = true, $visible='', $visibleCats=array())
        {  
            // Get a list of categories as <option> tags
            $cats = '';

            // Make sure $SelectedCats is an array
            if (!is_array($SelectedCats)) {
                $SelectedCats = array();
            }

            if (empty($SelectedCats) || in_array("0", $SelectedCats)) {
                $sel = 'selected="selected"';
            } else {
                $sel = "";
            }

            // Do we include the no parent category item in the list ?
            if ($IncludeEmpty) {
                $cats = sprintf("<option %s value='0'>-- %s --</option>\n", $sel, GetLang("NoParent"));
            }

            // Get a formatted list of all the categories in the system
            $categories = $this->getCats($Divider, 0, '', $visible);

            // Work out which cats we want to keep in the list
            $this->getCatsInfo($visible);

            foreach ($categories as $cid => $cname) {
                // If we're on the front end of the store, do we have permission to view this category?
                if(!defined('ISC_ADMIN_CP') && !CustomerGroupHasAccessToCategory($cid)) {
                    continue;
                }
                // Not showing this category in the list
                else if(!empty($visibleCats) && !in_array($cid, $visibleCats)) {
                    continue;
                }
                if (in_array($cid, $SelectedCats)) {
                    $s = $Sel;
                } else {
                    $s = '';
                }
                $cats .= sprintf($Container, $s, $cid, $cid, $cname);
                
            }
            
            return $cats;
        }
        /* Ends here */
        
		private function EditCategory()
		{
			$GLOBALS['Message'] = GetFlashMessageBoxes();

			if (isset($_GET['catId'])) {
				$catId = (int) $_GET['catId'];

				include_once(ISC_BASE_PATH.'/lib/api/category.api.php');

				$category = new API_CATEGORY();
				$category->load($catId);
				
				//wirror2010_09_19: costom page for subcategory
				if($category->catparentid != 0){
					$GLOBALS['DisplayCustom'] = 'display: none;';
				}
				
				//wirror_20100804: remove the cookie CustomContentId, and fetch current CustomContentId from table category
				if($category->customcontentid != 0){
					$contentId = isc_html_escape($category->customcontentid);
				}else{
					$customItem = array(
						'contenttype' => 1,
						'description' => "custom products content for category#$catId"
					);
					$contentId = GetClass('ISC_ADMIN_CUSTOMCONTENTS')->createCustomContens($customItem);
				}

				//wirror_20100806: show the custom content options
				$GLOBALS['ContentOptions'] = $this->_GetContentTypeOptions($category->pagecontenttype);			
				$GLOBALS['CustomPageAction'] = "listCateCustomcontents&customContentId=$contentId&catId=$catId";
				
				$GLOBALS['CategoryName'] = isc_html_escape($category->catname);
				$GLOBALS['CategoryOptions'] = $this->GetCategoryParentOptions($catId, array($category->catparentid));
				$GLOBALS['CategorySort'] = isc_html_escape($category->catsort);
				$GLOBALS['CategoryPageTitle'] = isc_html_escape($category->catpagetitle);
				$GLOBALS['CategoryMetaKeywords'] = isc_html_escape($category->catmetakeywords);
				$GLOBALS['CategoryMetaDesc'] = isc_html_escape($category->catmetadesc);
                $GLOBALS['CatDepartment'] = $this->getDepartment($category->catdeptid);
                $GLOBALS['AltKeyword'] = isc_html_escape($category->cataltkeyword);
                $GLOBALS['catcombine'] = isc_html_escape($category->catcombine);
                $GLOBALS['CatDeptid'] = isc_html_escape($category->catdeptid);
				$GLOBALS['StartPrice'] = isc_html_escape($category->StartPrice);
				$GLOBALS['EndPrice'] = isc_html_escape($category->EndPrice);
				$GLOBALS['CatImageAlt'] = isc_html_escape($category->catimagealt);
				if(strtolower($category->displayproducts) == 'on')
				{
					$GLOBALS['DisplayProducts'] = 'checked="checked"';
				}			

                $GLOBALS['CategorySelect'] = '<input type="hidden" name="catparentid" id="catparentid" value="'.$category->catparentid.'">
                <select size="5" name="catparent_id" id="catparent_id" class="Field750" style="height:115" onchange="HandleRootCategory();SelectDept();" disabled="disabled">'; # Added because when we disable the category list, id cant be get while saving, so hidden field is added and the id is changed to catparentid. -- Baskaran

				$temp = '';
				$pnamearray = array('Category Name', 'Sub Category Name', 'Brand Name','Series Name', 'Part Number', 'Product Code','Product color', 'Product Material', 'Product Style');

				$savedarray  = explode(",",$category->Productname);   

				foreach ($pnamearray as $key => $value) {

                    if (in_array($key, $savedarray)) {

						     $temp.= "<option  value='".$key."' selected='selected' >".$value."</option>";
					}
					else
					{
							  $temp.= "<option  value='".$key."' >".$value."</option>";
					}
				}

				$GLOBALS['Productname'] =  $temp;




                $congocatname = '';
                if($category->catparentid == 0) {
                    $space1 =  str_replace(" ","",isc_html_escape($category->catname));
                    $hypen1 = str_replace("-","",$space1);
                    $amp1 = str_replace("&","",$hypen1);
                    $slash1 = str_replace("/","",$amp1);
                    $congocatname = str_replace(",","",$slash1);
                }
                else {
                    $query = "SELECT * from [|PREFIX|]categories where categoryid = $category->catparentid";
                    $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
                    $row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result);
                    $space2 = str_replace(" ","",$row['catname']);
                    $hypen2 = str_replace("-","",$space2);
                    $amp2 = str_replace("&","",$hypen2);
                    $slash2 = str_replace("/","",$amp2);
                    $congocatname = str_replace(",","",$slash2);
                }
                $_SESSION['congocatname'] = $congocatname;
                                
				$wysiwygOptions = array(
					'id'		=> 'wysiwyg',
					'width'		=> '750px',
					'height'	=> '500px',
					'value'		=> $category->catdesc
				);
                 $wysiwygOptions1 = array(
                    'id'        => 'wysiwyg1',
                    'width'        => '60%',
                    'height'    => '300px',
                    'value'        => $category->categoryfooter
                );
				 $wysiwygOptions2 = array(
					'id'		=> 'wysiwyg2',
					'width'		=> '60%',
					'height'	=> '300px',
                    'value'     => $category->featurepoints
				);
				$wysiwygOptions3 = array(
					'id'		=> 'wysiwyg3',
					'width'		=> '60%',
					'height'	=> '300px',
                    'value'     => $category->divdesc
				);
				$GLOBALS['WYSIWYG'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor($wysiwygOptions);
                $GLOBALS['WYSIWYG1'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor1($wysiwygOptions1);
				$GLOBALS['WYSIWYG2'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor1($wysiwygOptions2);
	            $GLOBALS['WYSIWYG3'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor1($wysiwygOptions3);
				
				$GLOBALS['ControlScript'] = $category->controlscript;
				$GLOBALS['TrackingScript'] = $category->trackingscript;

				$GLOBALS['FormAction'] = "saveUpdatedCategory";
				$GLOBALS['CatTitle'] = GetLang('EditCatTitle');
				$GLOBALS['CatIntro'] = GetLang('EditCatIntro');
				$GLOBALS['CancelMessage'] = GetLang('CancelEditCategory');
				$GLOBALS['hiddenFields'] = sprintf("<input type='hidden' id='categoryId' name='categoryId' value='%d'>", $catId);
				#wirror_20100805: hide the custom content id
				$GLOBALS['hiddenFields'] .= sprintf("<input type='hidden' id='customContentId' name='customContentId' value='%d'>", $contentId);

				if ($category->catparentid == '0') {
					//$GLOBALS['DisableFileUpload'] = 'disabled="disabled"';
					$GLOBALS['ShowFileUploadMessage'] = '';
                    $GLOBALS['ShowHidecatCombine'] = 'none'; 
                    $GLOBALS['disabledept'] = '';                     
				} else {
					//$GLOBALS['DisableFileUpload'] = '';
					$GLOBALS['ShowFileUploadMessage'] = 'none';
                    $GLOBALS['ShowHidecatCombine'] = '';
                    $GLOBALS['disabledept'] = 'disabled="disabled"';
				}

				// Get a list of all layout files
				$layoutFile = 'category.html';
				if($category->catlayoutfile != '') {
					$layoutFile = $category->catlayoutfile;
				}
				$GLOBALS['LayoutFiles'] = GetCustomLayoutFilesAsOptions("category.html", $layoutFile);

				$GLOBALS["CatImageMessage"] = '';
				if ($category->catimagefile !== '') {
					$image = '../' . 'category_images' . '/' . $category->catimagefile;
					$GLOBALS["CatImageMessage"] = sprintf(GetLang('CatImageDesc'), $image, $category->catimagefile);
				}

				$GLOBALS["CatHoverImageMessage"] = '';
				if ($category->cathoverimagefile !== '') {
					$image = '../' . 'category_images' . '/' . $category->cathoverimagefile;
					$GLOBALS["CatHoverImageMessage"] = sprintf(GetLang('CatHoverImageDesc'), $image, $category->cathoverimagefile);
				}
                
                $SelectedQualifiers = $this->GetSelectedQualifiers($catId);
                
                $GLOBALS['QualifierOptions'] = $this->GetQualifierOptions($SelectedQualifiers, "<option %s value='%d'>%s</option>", "selected=\"selected\"", "", false);   
                                
				$GLOBALS['SaveAndAddAnother'] = GetLang('SaveAndContinueEditing');

				$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("category.form");
				$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
			} else {
				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Categories)) {
					$this->ManageCategories();
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
				}
			}
		}

		private function SaveUpdatedCategory()
		{
			$catData = $this->_GetCatData(ISC_SOURCE_FORM);
			$existingData = $this->_GetCatData(0, $catData['oldCatId']);
            
            //Added by Simha to check for duplication
            $query = "select COUNT(categoryid) from [|PREFIX|]categories where catname = '".$catData['catname']."' and catparentid='".$catData['category']."' and categoryid != '".(int)$catData['oldCatId']."'";
            $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
            $cnt = $GLOBALS["ISC_CLASS_DB"]->FetchOne($result);  
            
            //Loop for checking the duplication starts right here          
            if($cnt != 0) {
                FlashMessage(sprintf(GetLang('NameAlreadyExists'), $catData['catname']), MSG_ERROR, 'index.php?ToDo=editCategory&catId='.(int)$catData['oldCatId']);              
            }
            else if(!$this->BrandSeriesDuplicationExists($catData['catname']))    {

                $this->UpdateAssociations($catData['oldCatId']);

                /* Baskaran added. To combine the category and subcategory if the combine name is not entered*/
                $catid = $catData['category'];            
                $name_query = "SELECT * FROM [|PREFIX|]categories where categoryid = $catid";
                $name_result = $GLOBALS['ISC_CLASS_DB']->Query($name_query);

                $catname = '';
                while ($name_row = $GLOBALS['ISC_CLASS_DB']->Fetch($name_result)) {
                    $catname = $name_row['catname'];
                    $FolderName = $catname;
                }
                
                $subcat  = strtolower($catData['catname']);
                $cat  = strtolower($catname);
                $catcombine = '';
                if($catData['category'] != 0 and empty($catData['catcombine'])) {
                    $sc = explode(" ", $subcat);
                    //process 1
                    foreach ($sc as $value) {
                       $cat = str_ireplace($value, " ", $cat );
                      
                    }

                    $c = str_word_count($cat, 1);
                    foreach ($c as $value) {
                       $subcat = str_ireplace($value."s", " ", $subcat );
                       $subcat = str_ireplace($value."es", " ", $subcat );
                      }

                    if (trim($cat) == "s" || trim($cat) == "S") $cat = "";

                    $catcombine = ucwords(trim($subcat." ".$cat));
                }
                else {
                    $catcombine = $catData['catcombine'];
                }  
                /* Baskaran code ends */
                
			    // Log this action
			    $GLOBALS['ISC_CLASS_LOG']->LogAdminAction($catData['oldCatId'], $catData['category']);

                /* To update the combine name in the Product table for select category */
                $oldname = '';
                $combinedname = '';

                $catsubid = $catData['oldCatId'];
                $cat_query = "SELECT * FROM [|PREFIX|]categories where categoryid = $catsubid";
                $cat_result = $GLOBALS['ISC_CLASS_DB']->Query($cat_query);
                while ($cat_row = $GLOBALS['ISC_CLASS_DB']->Fetch($cat_result)) {
                    $oldname = $cat_row['catcombine'];
                } 
                # If the combined name is empty 
                if($catData['catcombine'] == '' || empty($catData['catcombine'])) {
                    $combinedname = $catcombine;
                }
                else {
                    # Checking whether the combined name is changed or not
                    if($oldname == '' || $oldname == $catData['catcombine']) {
                        $combinedname = $oldname;
                    }
                    else {
                        # When the combined name is changed with the old one means new combined name is updated in category and related category in products table
                        $combinedname = $catData['catcombine'];
                        $updateprodname = "UPDATE [|PREFIX|]products SET prodname = REPLACE(prodname, '$oldname','$combinedname') WHERE prodcatids = $catsubid";
                        $GLOBALS['ISC_CLASS_DB']->Query($updateprodname);
                    }
                }
                $thriblespace = str_replace("   "," ",$combinedname);
                $doublespace = str_replace("  "," ",$thriblespace);
                /* Code ends */
                /* To update all the deptid of sub category when the root category deptid changed -- Baskaran */
                $catdeptid = '';
                $deptid = $catData['catdeptid'];
                $catdeptquery = $GLOBALS['ISC_CLASS_DB']->Query("SELECT catdeptid FROM [|PREFIX|]categories where categoryid = $catsubid and catparentid = 0");
                $catdeptrow = $GLOBALS['ISC_CLASS_DB']->Fetch($catdeptquery);
                $dbdeptid =  $catdeptrow['catdeptid'];
                if($GLOBALS["ISC_CLASS_DB"]->CountResult($catdeptquery) == 1) {
                    if($deptid != $dbdeptid) {
                        $updatedept = array(
                            "catdeptid" => $deptid
                        );
                        $GLOBALS['ISC_CLASS_DB']->UpdateQuery("categories", $updatedept, "catparentid=$catsubid");
                        $catdeptid = $deptid;
                    }
                    else {
                        $catdeptid = $catData['catdeptid'];
                    }
                }
                else {
                    $catdeptid = $catData['catdeptid'];
                }
                /* Code Ends */
			    $updatedCategory = array(
				    "catparentid" => $catData['category'],
				    "catname" => $catData['catname'],
				    "catdesc" => $catData['catdesc'],
				    "catsort" => (int)$catData['catsort'],
				    "catpagetitle" => $catData['catpagetitle'],
				    "catmetakeywords" => $catData['catmetakeywords'],
				    "catmetadesc" => $catData['catmetadesc'],
				    "catlayoutfile" => $catData['catlayoutfile'],
                    "catdeptid" => $catdeptid,
                    "cataltkeyword" => $catData['cataltkeyword'],
                    "catcombine" => $doublespace,
					"StartPrice" => $catData['StartPrice'],
					"EndPrice" => $catData['EndPrice'],
					"Productname" => $catData['Productname'],
                    "categoryfooter" => $catData['categoryfooter'],
					"controlscript" => $catData['controlscript'],
                    "trackingscript" => $catData['trackingscript'],
					"catimagealt" => $catData['catimagealt'],
					"featurepoints" => $catData['featurepoints'],
					"divdesc" => $catData['divdesc'],
                    "displayproducts" => $catData['displayproducts'],
                    #update the customcontentid field if there is no value existed
                    "pagecontenttype" => $catData['catpagecontent'],
                    "customcontentid" => $catData['customContentId']
			    );
                if($FolderName=='') {
                    $FolderName = $catData['catname'];
                }
			    $GLOBALS['ISC_CLASS_DB']->UpdateQuery("categories", $updatedCategory, "categoryid='".$GLOBALS['ISC_CLASS_DB']->Quote((int)$catData['oldCatId'])."'");
			       
            }
            else    {
                 FlashMessage(sprintf(GetLang('NameAlreadyExists'), $catData['catname']), MSG_ERROR, 'index.php?ToDo=editCategory&catId='.(int)$catData['oldCatId']); 
            }
            //Loop for checking the duplication ends right here
            
            if ($GLOBALS['ISC_CLASS_DB']->GetErrorMsg() == '') {
                $FolderName = preg_replace("#[^\w.]#i", "", $FolderName); 
                $FolderName = strtolower($FolderName);  
				if (array_key_exists('delcatimagefile', $_POST) && $_POST['delcatimagefile']) {
					$this->DelCategoryImage($catData['oldCatId']);
					$GLOBALS['ISC_CLASS_DB']->UpdateQuery('categories', array('catimagefile' => ''), "categoryid='" . (int)$catData['oldCatId'] . "'");
				} else if (array_key_exists('catimagefile', $_FILES) && ($catimagefile = $this->SaveCategoryImage($FolderName))) {
					$GLOBALS['ISC_CLASS_DB']->UpdateQuery('categories', array('catimagefile' => $catimagefile), "categoryid='" . (int)$catData['oldCatId'] . "'");
				}

				if (array_key_exists('delcathoverimagefile', $_POST) && $_POST['delcathoverimagefile']) {
					$this->DelCategoryHoverImage($catData['oldCatId']);
					$GLOBALS['ISC_CLASS_DB']->UpdateQuery('categories', array('cathoverimagefile' => ''), "categoryid='" . (int)$catData['oldCatId'] . "'");
				} else if (array_key_exists('cathoverimagefile', $_FILES) && ($cathoverimagefile = $this->SaveCategoryHoverImage($FolderName))) {
					$GLOBALS['ISC_CLASS_DB']->UpdateQuery('categories', array('cathoverimagefile' => $cathoverimagefile), "categoryid='" . (int)$catData['oldCatId'] . "'");
				}

                /*
				// Also forcefully delete the image if it is not a root category
				if ($catData['category'] == "0") {
					$this->DelCategoryImage($catData['oldCatId']);
					$GLOBALS['ISC_CLASS_DB']->UpdateQuery('categories', array('catimagefile' => ''), "categoryid='" . (int)$catData['oldCatId'] . "'");
				}
                 */
				// If the category doesn't have a parent, rebuild the root categories cache
				$GLOBALS['ISC_CLASS_DATA_STORE']->UpdateRootCategories();

                # Below line is left in interspire old version, from new version it has been placed -- Baskaran
//				if($existingData['category'] != $catData['category']) {
                if($existingData['catparentid'] != $catData['category']) {  
					include_once(ISC_BASE_PATH.'/lib/api/category.api.php');
					$category = new API_CATEGORY();

					// Rebuild the parent list
					$parentList = $category->BuildParentList($catData['oldCatId']);
					$updatedCategory = array(
						"catparentlist" => $parentList
					);
					$GLOBALS['ISC_CLASS_DB']->UpdateQuery("categories", $updatedCategory, "categoryid='".$GLOBALS['ISC_CLASS_DB']->Quote((int)$catData['oldCatId'])."'");

					// Now we also need to update the parent list of all child pages for this category
					$query = sprintf("SELECT categoryid FROM [|PREFIX|]categories WHERE CONCAT(',', catparentlist, ',') LIKE '%%,%s,%%'", $GLOBALS['ISC_CLASS_DB']->Quote($catData['oldCatId']));
					$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
					while($child = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
						$parentList = $category->BuildParentList($child['categoryid']);
						// Update the parent list for this child
						$updatedCategory = array(
							"catparentlist" => $parentList
						);
						$GLOBALS['ISC_CLASS_DB']->UpdateQuery("categories", $updatedCategory, "categoryid='".$GLOBALS['ISC_CLASS_DB']->Quote($child['categoryid'])."'");
					}

					// Rebuild the group pricing caches
					$GLOBALS['ISC_CLASS_DATA_STORE']->UpdateCustomerGroupsCategoryDiscounts();
				}

				if(isset($_POST['AddAnother'])) {
					$location = 'index.php?ToDo=editCategory&catId='.(int)$catData['oldCatId'];
				}
				else {
					$catdeptid = $catdeptid.'&focuspage=Universal_'.(int)$catData['oldCatId'];
					$location= 'index.php?ToDo=viewCategories&deptid='.$catdeptid;
				}
				//delete category brand cache file,let it rebuild.	NI_Mike 2010.11.25			
					$this->UpdateCategoryBrandProductCache();
				FlashMessage(GetLang('CatUpdateSuccessfully'), MSG_SUCCESS, $location);
			} else {
				FlashMessage($GLOBALS['ISC_CLASS_DB']->GetErrorMsg(), MSG_ERROR, 'index.php?ToDo=editCategory&catId='.(int)$catData['oldCatId']);
			}
		}
        
        private function UpdateAssociations($catId)   {
            
            //Restrict universal categories 
            $uQuery = "SELECT catuniversal FROM [|PREFIX|]categories WHERE categoryid='".$catId."'";
            $uResult = $GLOBALS['ISC_CLASS_DB']->Query($uQuery);
            $isUniversal = $GLOBALS['ISC_CLASS_DB']->FetchOne($uResult);
            
            $qualifiers = $_POST['qualifiers'];
            if(count($qualifiers)>0)    {
                $assoc_string = implode(",", $qualifiers); 
            }
            else    {
                $assoc_string = 0;
            }
            
            $d_query = "DELETE FROM [|PREFIX|]qualifier_associations WHERE qualifierid NOT IN (".$assoc_string.") AND categoryid='".$catId."'";
            $d_result = $GLOBALS['ISC_CLASS_DB']->Query($d_query); 
            
            foreach($qualifiers as $value)   {
                if(!$isUniversal)    {
                    $query = "SELECT categoryid FROM [|PREFIX|]qualifier_associations WHERE qualifierid='$value' AND categoryid='$catId'";
                    $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
                    if($GLOBALS['ISC_CLASS_DB']->CountResult($result)==0)    {
                           $newAssoc = array(
                            "qualifierid" => $value,
                            "categoryid" => $catId
                            );
                            $GLOBALS['ISC_CLASS_DB']->InsertQuery("qualifier_associations", $newAssoc);  
                    }
                }
                else {                                                    
                    $gQuery = "SELECT column_name FROM [|PREFIX|]qualifier_names WHERE qid='".$value."'";
                    $gResult = $GLOBALS['ISC_CLASS_DB']->Query($gQuery);
                    $QName = $GLOBALS['ISC_CLASS_DB']->FetchOne($gResult);
                    
                    $pos = strpos($QName, 'PQ');
                    if($pos !== false && $pos==0)    {
                        //Insert
                        $query = "SELECT categoryid FROM [|PREFIX|]qualifier_associations WHERE qualifierid='$value' AND categoryid='$catId'";
                        $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
                        if($GLOBALS['ISC_CLASS_DB']->CountResult($result)==0)    {
                               $newAssoc = array(
                                "qualifierid" => $value,
                                "categoryid" => $catId
                                );
                                $GLOBALS['ISC_CLASS_DB']->InsertQuery("qualifier_associations", $newAssoc);  
                        }
                    }       
                }
            }
                 
            //Add to subcategories
            $query = "SELECT categoryid FROM [|PREFIX|]categories WHERE catparentid='$catId' ORDER BY catsort ASC, catname ASC";
            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
            while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                //
                $this->AddSubcatAssociations($row['categoryid']);
            }   
        }
		
        private function AddSubcatAssociations($catId)  {     
                
            $c_query = "SELECT count(associd) as total FROM [|PREFIX|]qualifier_associations WHERE categoryid='".$catId."'";
            $c_result = $GLOBALS['ISC_CLASS_DB']->Query($c_query);
            $row = $GLOBALS['ISC_CLASS_DB']->Fetch($c_result); 
            
            if($row['total'] == 0)    {
                
                $qualifiers = $_POST['qualifiers'];
                
                //Restrict universal categories 
                $uQuery = "SELECT catuniversal FROM [|PREFIX|]categories WHERE categoryid='".$catId."'";
                $uResult = $GLOBALS['ISC_CLASS_DB']->Query($uQuery);
                $isUniversal = $GLOBALS['ISC_CLASS_DB']->FetchOne($uResult);
                
                foreach($qualifiers as $value)   {
                    if(!$isUniversal)    {
                        $query = "SELECT categoryid FROM [|PREFIX|]qualifier_associations WHERE qualifierid='$value' AND categoryid='$catId'";
                        $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
                        if($GLOBALS['ISC_CLASS_DB']->CountResult($result)==0)    {
                               $newAssoc = array(
                                "qualifierid" => $value,
                                "categoryid" => $catId
                                );
                                $GLOBALS['ISC_CLASS_DB']->InsertQuery("qualifier_associations", $newAssoc);  
                        }
                    }
                    else {                                                    
                        $gQuery = "SELECT column_name FROM [|PREFIX|]qualifier_names WHERE qid='".$value."'";
                        $gResult = $GLOBALS['ISC_CLASS_DB']->Query($gQuery);
                        $QName = $GLOBALS['ISC_CLASS_DB']->FetchOne($gResult);
                        
                        $pos = strpos($QName, 'PQ');
                        if($pos !== false && $pos==0)    {
                            //Insert
                            $query = "SELECT categoryid FROM [|PREFIX|]qualifier_associations WHERE qualifierid='$value' AND categoryid='$catId'";
                            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
                            if($GLOBALS['ISC_CLASS_DB']->CountResult($result)==0)    {
                                   $newAssoc = array(
                                    "qualifierid" => $value,
                                    "categoryid" => $catId
                                    );
                                    $GLOBALS['ISC_CLASS_DB']->InsertQuery("qualifier_associations", $newAssoc);  
                            }
                        }       
                    }
                }

                //Add to subcategories
                $query = "SELECT categoryid FROM [|PREFIX|]categories WHERE catparentid='$catId' ORDER BY catsort ASC, catname ASC";
                $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
                while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                    //
                    $this->AddSubcatAssociations($row['categoryid']);
                }     
            }
        }
       
		/* Baskaran Added starts */
        private function editCategoryApprove()
        {
            // Update the visibility of a product with a simple query
      
            $catId = (int)$_GET['catId'];
            $visible = (int)$_GET['approve'];
                       
            $query = "SELECT catname, catparentlist FROM [|PREFIX|]categories WHERE categoryid='".$catId."'";
            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
            $category = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

            // Log this action
            $GLOBALS['ISC_CLASS_LOG']->LogAdminAction($catId, $category['catname']);
            $parentCats = explode(',', $category['catparentlist']);


            $affectedCats = array($catId);
            $queryPart = "categoryid='".$GLOBALS['ISC_CLASS_DB']->Quote($catId)."'";
            $successMsg = sprintf(GetLang('CategoryApprovedSuccessfully'), '');

            //set a child category to visible should automaticaly set its parents to visible
            if ($visible == 1 && count($parentCats) > 1) {
                $queryPart = "categoryid in (".$GLOBALS['ISC_CLASS_DB']->Quote($category['catparentlist']).")";
                $affectedCats = $parentCats;
                $successMsg = sprintf(GetLang('CategoryApprovedSuccessfully'), GetLang('ParentCategories'));
            }


            //set a parent category to invisible should automatically set its children to invisible
            if ($visible == 2) {
                $query = "SELECT
                                    categoryid, catparentlist
                            FROM
                                    [|PREFIX|]categories
                            WHERE
                                    CONCAT(',',catparentlist,',') LIKE '%,".$catId.",%';";

                $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
                while ($subcat = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                    $affectedCats[] = $subcat['categoryid'];
                }
                if (count($affectedCats)>1) {
                    $successMsg = sprintf(GetLang('CategoryApprovedSuccessfully'), GetLang('SubCategories'));
                }
                $queryPart = "categoryid in (".$GLOBALS['ISC_CLASS_DB']->Quote(implode(',', $affectedCats)).")";
            }

            $updatedCategory = array(
                "catvisible" => $visible
            ); 
            $GLOBALS['ISC_CLASS_DB']->UpdateQuery("categories", $updatedCategory, $queryPart);

            unset($_REQUEST['approve']);
            unset($_GET['approve']);

            if ($GLOBALS["ISC_CLASS_DB"]->Error() == "") {

                // Update the data store
                $GLOBALS['ISC_CLASS_DATA_STORE']->UpdateRootCategories();
                if(isset($_REQUEST['ajax'])) {

                    //generate the javascript to update the Approve icon through ajax
                    $callBackJs = "";
                    foreach ($affectedCats as $cat) {
                            $elementID = 'CatApprove_'.$cat;
                            $callBackJs .= 'ToggleApproveIcon("'.$elementID.'", "approve", '.$visible.','.$cat.');';
                            $elementID = 'CatVisible_'.$cat;
                            $callBackJs .= 'ToggleApproveIcon("'.$elementID.'", "visible", '.$visible.');';
                    }

                    header('Content-type: text/javascript');
                    echo $callBackJs;
                    echo "var status = 1; var message='".$successMsg."'";
                    exit;
                }
                if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Products)) {
                    $this->ManageCategories(GetLang('CategoryApprovedSuccessfully'), MSG_SUCCESS);
                } else {
                    $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('CategoryApprovedSuccessfully'), MSG_SUCCESS);
                }
            } else {
                if(isset($_REQUEST['ajax'])) {
                    header('Content-type: text/javascript');
                    echo "var status = 0;";
                    exit;
                }

                $err = '';
                if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Products)) {
                    $this->ManageCategories(sprintf(GetLang('ErrCategoryApprovedNotChanged'), $err), MSG_ERROR);
                } else {
                    $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(sprintf(GetLang('ErrCategoryApprovedNotChanged'), $err), MSG_ERROR);
                }
            }
        }  
        
        private function editCategoryUniversal()
        {    
      
            $catId = (int)$_GET['catId'];
            $visible = (int)$_GET['visible'];
                       
            $query = "SELECT catname, catparentlist FROM [|PREFIX|]categories WHERE categoryid='".$catId."'";
            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
            $category = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

            // Log this action
            $GLOBALS['ISC_CLASS_LOG']->LogAdminAction($catId, $category['catname']);
            $parentCats = explode(',', $category['catparentlist']);

            $affectedCats = array($catId);
            $queryPart = "categoryid='".$GLOBALS['ISC_CLASS_DB']->Quote($catId)."'";
            $successMsg = sprintf(GetLang('CategoryUniversalSuccessfully'), '');

             //set a child category to visible should automaticaly set its parents to visible
            if ($visible == 0 && count($parentCats) > 1) {
                $queryPart = "categoryid in (".$GLOBALS['ISC_CLASS_DB']->Quote($category['catparentlist']).")";
                $affectedCats = $parentCats;
                $successMsg = sprintf(GetLang('CategoryUniversalSuccessfully'), GetLang('ParentCategories'));
            }               


            //set a parent category to invisible should automatically set its children to invisible
            if ($visible == 1) {
                $query = "SELECT
                                    categoryid, catparentlist
                            FROM
                                    [|PREFIX|]categories
                            WHERE
                                    CONCAT(',',catparentlist,',') LIKE '%,".$catId.",%';";

                $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
                while ($subcat = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                    $affectedCats[] = $subcat['categoryid'];
                }
                if (count($affectedCats)>1) {
                    $successMsg = sprintf(GetLang('CategoryUniversalSuccessfully'), GetLang('SubCategories'));
                }
                $queryPart = "categoryid in (".$GLOBALS['ISC_CLASS_DB']->Quote(implode(',', $affectedCats)).")";  
            }  
            
            $updatedCategory = array(
                "catuniversal" => $visible
            ); 
            $GLOBALS['ISC_CLASS_DB']->UpdateQuery("categories", $updatedCategory, $queryPart);

            unset($_REQUEST['visible']);
            unset($_GET['visible']);

            if ($GLOBALS["ISC_CLASS_DB"]->Error() == "") {

                // Update the data store
                $GLOBALS['ISC_CLASS_DATA_STORE']->UpdateRootCategories();
                if(isset($_REQUEST['ajax'])) {

                    //generate the javascript to update the Universal icon through ajax
                    $callBackJs = "";
                    foreach ($affectedCats as $cat) {
                            $elementID = 'Universal_'.$cat;
                            $callBackJs .= 'ToggleUniversalIcon("'.$elementID.'", "visible", '.$visible.');';
                    }

                    header('Content-type: text/javascript');
                    echo $callBackJs;
                    echo "var status = 1; var message='".$successMsg."'";
                    exit;
                }
                if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Products)) {
                    $this->ManageCategories(GetLang('CategoryUniversalSuccessfully1'), MSG_SUCCESS);
                } else {
                    $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('CategoryUniversalSuccessfully'), MSG_SUCCESS);
                }
            } else { 
                if(isset($_REQUEST['ajax'])) {
                    header('Content-type: text/javascript');
                    echo "var status = 0;";
                    exit;
                }

                $err = '';
                if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Products)) {
                    $this->ManageCategories(sprintf(GetLang('ErrCategoryUniversalNotChanged'), $err), MSG_ERROR);
                } else {
                    $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(sprintf(GetLang('ErrCategoryUniversalNotChanged'), $err), MSG_ERROR);
                }
            }
        } 
        
        private function editCategoryPopular()
        {    
      
            $catId = (int)$_GET['catId'];
            $visible = (int)$_GET['popular'];
                       
            $query = "SELECT catname, catparentlist FROM [|PREFIX|]categories WHERE categoryid='".$catId."'";
            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
            $category = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

            // Log this action
            $GLOBALS['ISC_CLASS_LOG']->LogAdminAction($catId, $category['catname']);
            $parentCats = explode(',', $category['catparentlist']);


            $affectedCats = array($catId);
            $queryPart = "categoryid='".$GLOBALS['ISC_CLASS_DB']->Quote($catId)."'";
            $successMsg = sprintf(GetLang('CategoryPopularSuccessfully'), '');

            $updatedCategory = array(
                "catpopular" => $visible
            ); 
            $GLOBALS['ISC_CLASS_DB']->UpdateQuery("categories", $updatedCategory, $queryPart);

            unset($_REQUEST['popular']);
            unset($_GET['popular']);

            if ($GLOBALS["ISC_CLASS_DB"]->Error() == "") {

                // Update the data store
                $GLOBALS['ISC_CLASS_DATA_STORE']->UpdateRootCategories();
                if(isset($_REQUEST['ajax'])) {

                    //generate the javascript to update the Popular icon through ajax
                    $callBackJs = "";
                    foreach ($affectedCats as $cat) {
                            $elementID = 'Popular_'.$cat;
                            $callBackJs .= 'TogglePopularIcon("'.$elementID.'", "popular", '.$visible.');';
                    }

                    header('Content-type: text/javascript');
                    echo $callBackJs;
                    echo "var status = 1; var message='".$successMsg."'";
                    exit;
                }
                if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Products)) {
                    $this->ManageCategories(GetLang('CategoryPopularSuccessfully'), MSG_SUCCESS);
                } else {
                    $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('CategoryPopularSuccessfully'), MSG_SUCCESS);
                }
            } else { 
                if(isset($_REQUEST['ajax'])) {
                    header('Content-type: text/javascript');
                    echo "var status = 0;";
                    exit;
                }

                $err = '';
                if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Products)) {
                    $this->ManageCategories(sprintf(GetLang('ErrCategoryPopularNotChanged'), $err), MSG_ERROR);
                } else {
                    $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(sprintf(GetLang('ErrCategoryPopularNotChanged'), $err), MSG_ERROR);
                }
            }
        }
         
		/* Baskaran Added Ends*/

        private function EditCategoryVisibility()
		{
			// Update the visibility of a product with a simple query

			$catId = (int)$_GET['catId'];
			$visible = (int)$_GET['visible'];

			$query = "SELECT catname, catparentlist, catdeptid FROM [|PREFIX|]categories WHERE categoryid='".$catId."'";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$category = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

			$deptid = $category['catdeptid'];

			// Log this action
			$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($catId, $category['catname']);
			$parentCats = explode(',', $category['catparentlist']);


			$affectedCats = array($catId);
			$queryPart = "categoryid='".$GLOBALS['ISC_CLASS_DB']->Quote($catId)."'";
			$successMsg = sprintf(GetLang('CategoryVisibilitySuccessfully'), '');

			//set a child category to visible should automaticaly set its parents to visible
			if ($visible == 1 && count($parentCats) > 1) {
				$queryPart = "categoryid in (".$GLOBALS['ISC_CLASS_DB']->Quote($category['catparentlist']).")";
				$affectedCats = $parentCats;
				$successMsg = sprintf(GetLang('CategoryVisibilitySuccessfully'), GetLang('ParentCategories'));
			}


			//set a parent category to invisible should automatically set its children to invisible
			if ($visible == 0) {
				$query = "SELECT
									categoryid, catparentlist
							FROM
									[|PREFIX|]categories
							WHERE
									CONCAT(',',catparentlist,',') LIKE '%,".$catId.",%' and catdeptid = ".$deptid;

				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				while ($subcat = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					$affectedCats[] = $subcat['categoryid'];
				}
				if (count($affectedCats)>1) {
					$successMsg = sprintf(GetLang('CategoryVisibilitySuccessfully'), GetLang('SubCategories'));
				}
				$queryPart = "categoryid in (".$GLOBALS['ISC_CLASS_DB']->Quote(implode(',', $affectedCats)).")";
			}

			//setting a parent category to visible should automatically set its children to visible
			if ($visible == 1 && count($parentCats) == 1) {
				$query = "SELECT
									categoryid, catparentlist
							FROM
									[|PREFIX|]categories
							WHERE
									catparentid = ".$catId." and catdeptid = ".$deptid;

				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				while ($subcat = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					$affectedCats[] = $subcat['categoryid'];
				}
				if (count($affectedCats)>1) {
					$successMsg = sprintf(GetLang('CategoryVisibilitySuccessfully'), GetLang('SubCategories'));
				}
				$queryPart = "categoryid in (".$GLOBALS['ISC_CLASS_DB']->Quote(implode(',', $affectedCats)).")";
			}

			$updatedCategory = array(
				"catvisible" => $visible
			);
			$GLOBALS['ISC_CLASS_DB']->UpdateQuery("categories", $updatedCategory, $queryPart);

			unset($_REQUEST['visible']);
			unset($_GET['visible']);

			if ($GLOBALS["ISC_CLASS_DB"]->Error() == "") {

				// Update the data store
				$GLOBALS['ISC_CLASS_DATA_STORE']->UpdateRootCategories();
				if(isset($_REQUEST['ajax'])) {

					//generate the javascript to update the visibility icon through ajax
					$callBackJs = "";
					foreach ($affectedCats as $cat) {
                        if($visible != 1) {
						    $elementID = 'CatVisible_'.$cat;
						    $callBackJs .= 'ToggleVisibilityIcon("'.$elementID.'", "visible", '.$visible.');';
                        }
                        else {
                            $elementID = 'CatVisible_'.$cat;
                            $callBackJs .= 'ToggleVisibilityIcon("'.$elementID.'", "visible", '.$visible.','.$cat.');';
                            $elementID = 'CatApprove_'.$cat;
                            $callBackJs .= 'ToggleVisibilityIcon("'.$elementID.'", "approve", '.$visible.','.$cat.');';
                        }

					}

					header('Content-type: text/javascript');
					echo $callBackJs;
					echo "var status = 1; var message='".$successMsg."'";
					exit;
				}

				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Products)) {
					$this->ManageCategories(GetLang('CategoryVisibilitySuccessfully'), MSG_SUCCESS);
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('CategoryVisibilitySuccessfully'), MSG_SUCCESS);
				}
			} else {
				if(isset($_REQUEST['ajax'])) {
					header('Content-type: text/javascript');
					echo "var status = 0;";
					exit;
				}

				$err = '';
				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Products)) {
					$this->ManageCategories(sprintf(GetLang('ErrCategoryVisibilityNotChanged'), $err), MSG_ERROR);
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(sprintf(GetLang('ErrCategoryVisibilityNotChanged'), $err), MSG_ERROR);
				}
			}
		}

		public function RemoveRootImages()
		{
			//Interspire functionality has been changed by which the root category images cannot be deleted --- By Simha  
            /*
            $result = $GLOBALS['ISC_CLASS_DB']->Query("SELECT * FROM [|PREFIX|]categories WHERE catparentid='0' AND catimagefile != ''");

			while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$this->DelCategoryImage($row['categoryid']);
				$GLOBALS['ISC_CLASS_DB']->UpdateQuery('categories', array('catimagefile' => ''), "categoryid='" . (int)$row['categoryid'] . "'");
			}
            */
		}

		private function SaveCategoryImage($FolderName)
		{                  
            if (!array_key_exists('catimagefile', $_FILES) || $_FILES['catimagefile']['error'] !== 0 || strtolower(substr($_FILES['catimagefile']['type'], 0, 6)) !== 'image/') {
				return false;
			}

			// Attempt to set the memory limit so we can resize this image
			setImageFileMemLimit($_FILES['catimagefile']['tmp_name']);

            $subDir = "";
            
			// Determine the destination directory
			//$randomDir = strtolower(chr(rand(65, 90)));
            
            $subDir = $FolderName; 
            
			$destPath = realpath(ISC_BASE_PATH.'/' . 'category_images');

			if (!is_dir($destPath . '/' . $subDir)) {
				if (!mkdir($destPath . '/' . $subDir, 0777)) {
					$subDir = '';
				}
			}                       
            
			$destFile = GenRandFileName($_FILES['catimagefile']['name'], 'category');
			$destPath = $destPath . '/' . $subDir . '/' . $destFile;
			$returnPath = $subDir . '/' . $destFile;

			$tmp = explode('.', $_FILES['catimagefile']['name']);
			$ext = strtolower($tmp[count($tmp)-1]);

			if ($ext == 'jpg') {
				$srcImg = imagecreatefromjpeg($_FILES['catimagefile']['tmp_name']);
			} else if($ext == 'gif') {
				$srcImg = imagecreatefromgif($_FILES['catimagefile']['tmp_name']);
				if(!function_exists('imagegif')) {
					$gifHack = 1;
				}
			} else {
				$srcImg = imagecreatefrompng($_FILES['catimagefile']['tmp_name']);
			}

			$srcWidth = imagesx($srcImg);
			$srcHeight = imagesy($srcImg);
			$widthLimit = GetConfig('CategoryImageWidth');
			$heightLimit = GetConfig('CategoryImageHeight');

			// If the image is small enough, simply move it
			if($srcWidth <= $widthLimit && $srcHeight <= $heightLimit) {
				imagedestroy($srcImg);
				move_uploaded_file($_FILES['catimagefile']['tmp_name'], $destPath);
				return $returnPath;
			}

			// Otherwise, resize it
			$attribs = getimagesize($_FILES['catimagefile']['tmp_name']);
			$width = $attribs[0];
			$height = $attribs[1];

			if($width > $widthLimit) {
				$height = ceil(($widthLimit/$width)*$height);
				$width = $widthLimit;
			}

			if($height > $heightLimit) {
				$width = ceil(($heightLimit/$height)*$width);
				$height = $heightLimit;
			}

			$dstImg = imagecreatetruecolor($width, $height);
			if($ext == "gif" && !isset($gifHack)) {
				$colorTransparent = imagecolortransparent($srcImg);
				imagepalettecopy($srcImg, $dstImg);
				imagecolortransparent($dstImg, $colorTransparent);
				imagetruecolortopalette($dstImg, true, 256);
			}
			else if($ext == "png") {
				ImageColorTransparent($dstImg, ImageColorAllocate($dstImg, 0, 0, 0));
				ImageAlphaBlending($dstImg, false);
			}

			imagecopyresampled($dstImg, $srcImg, 0, 0, 0, 0, $width, $height, $srcWidth, $srcHeight);

			if ($ext == "jpg") {
				imagejpeg($dstImg, $destPath, 100);
			} else if($ext == "gif") {
				if(isset($gifHack) && $gifHack == true) {
					$thumbFile = isc_substr($destPath, 0, -3)."jpg";
					imagejpeg($dstImg, $destPath, 100);
				}
				else {
					imagegif($dstImg, $destPath);
				}
			} else {
				imagepng($dstImg, $destPath);
			}

			@imagedestroy($dstImg);
			@imagedestroy($srcImg);
			@unlink($_FILES['catimagefile']['tmp_name']);

			// Change the permissions on the thumbnail file
			isc_chmod($returnPath, ISC_WRITEABLE_FILE_PERM);

			return $returnPath;
		}

		/*
			Added the below duplicate function of the above function.
			Saving the large hover image file.
		*/

		private function SaveCategoryHoverImage($FolderName)
		{                  
            if (!array_key_exists('cathoverimagefile', $_FILES) || $_FILES['cathoverimagefile']['error'] !== 0 || strtolower(substr($_FILES['cathoverimagefile']['type'], 0, 6)) !== 'image/') {
				return false;
			}

			// Attempt to set the memory limit so we can resize this image
			setImageFileMemLimit($_FILES['cathoverimagefile']['tmp_name']);

            $subDir = "";
            
			// Determine the destination directory
			//$randomDir = strtolower(chr(rand(65, 90)));
            
            $subDir = $FolderName; 
            
			$destPath = realpath(ISC_BASE_PATH.'/' . 'category_images');

			if (!is_dir($destPath . '/' . $subDir)) {
				if (!mkdir($destPath . '/' . $subDir, 0777)) {
					$subDir = '';
				}
			}                       
            
			$destFile = GenRandFileName($_FILES['cathoverimagefile']['name'], 'category');
			$destPath = $destPath . '/' . $subDir . '/' . $destFile;
			$returnPath = $subDir . '/' . $destFile;

			$tmp = explode('.', $_FILES['cathoverimagefile']['name']);
			$ext = strtolower($tmp[count($tmp)-1]);

			if ($ext == 'jpg') {
				$srcImg = imagecreatefromjpeg($_FILES['cathoverimagefile']['tmp_name']);
			} else if($ext == 'gif') {
				$srcImg = imagecreatefromgif($_FILES['cathoverimagefile']['tmp_name']);
				if(!function_exists('imagegif')) {
					$gifHack = 1;
				}
			} else {
				$srcImg = imagecreatefrompng($_FILES['cathoverimagefile']['tmp_name']);
			}

			$srcWidth = imagesx($srcImg);
			$srcHeight = imagesy($srcImg);
			$widthLimit = GetConfig('CategoryImageWidth') * 2;
			$heightLimit = GetConfig('CategoryImageHeight') * 2;

			// If the image is small enough, simply move it
			if($srcWidth <= $widthLimit && $srcHeight <= $heightLimit) {
				imagedestroy($srcImg);
				move_uploaded_file($_FILES['cathoverimagefile']['tmp_name'], $destPath);
				return $returnPath;
			}

			// Otherwise, resize it
			
			$attribs = getimagesize($_FILES['cathoverimagefile']['tmp_name']);
			$width = $attribs[0];
			$height = $attribs[1];

			if($width > $widthLimit) {
				$height = ceil(($widthLimit/$width)*$height);
				$width = $widthLimit;
			}

			if($height > $heightLimit) {
				$width = ceil(($heightLimit/$height)*$width);
				$height = $heightLimit;
			}

			$dstImg = imagecreatetruecolor($width, $height);
			if($ext == "gif" && !isset($gifHack)) {
				$colorTransparent = imagecolortransparent($srcImg);
				imagepalettecopy($srcImg, $dstImg);
				imagecolortransparent($dstImg, $colorTransparent);
				imagetruecolortopalette($dstImg, true, 256);
			}
			else if($ext == "png") {
				ImageColorTransparent($dstImg, ImageColorAllocate($dstImg, 0, 0, 0));
				ImageAlphaBlending($dstImg, false);
			}

			imagecopyresampled($dstImg, $srcImg, 0, 0, 0, 0, $width, $height, $srcWidth, $srcHeight);

			if ($ext == "jpg") {
				imagejpeg($dstImg, $destPath, 100);
			} else if($ext == "gif") {
				if(isset($gifHack) && $gifHack == true) {
					$thumbFile = isc_substr($destPath, 0, -3)."jpg";
					imagejpeg($dstImg, $destPath, 100);
				}
				else {
					imagegif($dstImg, $destPath);
				}
			} else {
				imagepng($dstImg, $destPath);
			}

			@imagedestroy($dstImg);
			@imagedestroy($srcImg);
			@unlink($_FILES['cathoverimagefile']['tmp_name']);

			// Change the permissions on the thumbnail file
			isc_chmod($returnPath, ISC_WRITEABLE_FILE_PERM);

			return $returnPath;
			
		}

		private function DelCategoryImage($file)
		{
			if (isId($file)) {
				if (!($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($GLOBALS["ISC_CLASS_DB"]->Query("SELECT * FROM [|PREFIX|]categories WHERE categoryid='" . (int)$file . "'")))) {
					return false;
				}

				if ($row['catimagefile'] == '') {
					return true;
				} else {
					$file = $row['catimagefile'];
				}
			}

			$file = realpath(ISC_BASE_PATH.'/' . 'category_images' . '/' . $file);

			if ($file == '') {
				return false;
			}

			if (file_exists($file)) {
				@unlink($file);
				clearstatcache();
			}

			return !file_exists($file);
		}

		/*
			Below function is used to delete hoverimage
		*/

		private function DelCategoryHoverImage($file)
		{
			if (isId($file)) {
				if (!($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($GLOBALS["ISC_CLASS_DB"]->Query("SELECT * FROM [|PREFIX|]categories WHERE categoryid='" . (int)$file . "'")))) {
					return false;
				}

				if ($row['cathoverimagefile'] == '') {
					return true;
				} else {
					$file = $row['cathoverimagefile'];
				}
			}

			$file = realpath(ISC_BASE_PATH.'/' . 'category_images' . '/' . $file);

			if ($file == '') {
				return false;
			}

			if (file_exists($file)) {
				@unlink($file);
				clearstatcache();
			}

			return !file_exists($file);
		}
		 
        public function GetQualifierOptions($SelectedQualifiers = 0, $Container = "<option %s value='%d'>%s</option>", $Sel = "selected=\"selected\"", $Divider = "- ", $IncludeEmpty = true)
        {
            // Get a list of categories as <option> tags
            $quals = '';
            $Container;
            // Make sure $SelectedCats is an array
            if (!is_array($SelectedQualifiers)) {
                $SelectedQualifiers = array();
            }

            if (empty($SelectedQualifiers) || in_array("0", $SelectedQualifiers)) {
                $sel = 'selected="selected"';
            } else {
                $sel = "";
            }

            // Do we include the no parent category item in the list ?
            if ($IncludeEmpty) {
                $quals = sprintf("<option %s value='0'>-- %s --</option>\n", $sel, GetLang("NoParent"));       //need to be fixed
            }
            
            // Get a formatted list of all the categories in the system
            $qualifiers = $this->GetAllQualifiers();
            
            /*
            // Work out which cats we want to keep in the list
            $this->getCatsInfo($visible);
             */
            foreach ($qualifiers as $qid => $cname) {
                // If we're on the front end of the store, do we have permission to view this category?
                /*
                if(!defined('ISC_ADMIN_CP') && !CustomerGroupHasAccessToCategory($cid)) {
                    continue;
                } 
                // Not showing this category in the list
                else if(!empty($visibleCats) && !in_array($qid, $visibleCats)) {
                    continue;
                }
                */
                if (in_array($qid, $SelectedQualifiers)) {
                    $s = $Sel;
                } else {
                    $s = '';
                }                
                $quals .= sprintf($Container, $s, $qid, $cname);
            }                 
            return $quals;
        }
          

        private function getDepartment($deptid = 0) {
            $options = '<option value="0">'.GetLang('SelectDept').'</option>';
            $query = "select * from [|PREFIX|]department ORDER BY deptname ASC";
            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
            while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                $sel = '';
                if($deptid == $row['deptid']) {
                    $sel = 'selected="selected"';
                }
                $options .= '<option value='.(int)$row['deptid'].' '.$sel.'>'.isc_html_escape($row['deptname']).'</option>';
            }
            return $options;
        }
        
        private function getDepartmentList($deptid = 0) {
            $options = '';
            $query = "select * from [|PREFIX|]department ORDER BY deptname ASC";
            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
            while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                $sel = '';
                if($deptid == $row['deptid']) {
                    $sel = 'selected="selected"';
                }
                if($this->firstdept==0) 
                {
                    $this->firstdept = (int)$row['deptid'];
                }
                $options .= '<option value='.(int)$row['deptid'].' '.$sel.'>'.isc_html_escape($row['deptname']).'</option>';
            }
            $options .= '<option value="all">All Departments</option>'; 
            return $options;
        }
        
        private function getDeptName($deptid) {
            $query = "SELECT deptname from [|PREFIX|]department where deptid='$deptid' ";
            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);     
            $row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
            return $row['deptname'];
        }
        
        
        /**
        * DuplicationExists
        * Check to see if a category, brand or series with a given name exists under a given  
        *                                                
        * @param int $name The name of the category
        *
        * @return boolean Does the category, brand or series exist or not ?
        */
        function BrandSeriesDuplicationExists($name)
        {
            //$query = "SELECT COUNT(*) FROM [|PREFIX|]categories WHERE catname='".$this->db->Quote($name)."'";
            $query = "SELECT COUNT(*) FROM 
                        (
                        SELECT brandname AS brandname FROM isc_brands WHERE brandname = '".$GLOBALS['ISC_CLASS_DB']->Quote($name)."'
                        UNION
                        SELECT seriesname AS brandname FROM isc_brand_series WHERE seriesname = '".$GLOBALS['ISC_CLASS_DB']->Quote($name)."'
                        ) AS temp";

            $result     = $GLOBALS['ISC_CLASS_DB']->Query($query);

            $num        = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);

            if ($num > 0) {
                return true;
            } else {
                return false;
            }
        }

        /**
        * DuplicationExists
        * Check to see if a category, brand or series with a given name exists under a given  
        *                                                
        * @param int $name The name of the category
        *
        * @return boolean Does the category, brand or series exist or not ?
        */
        function CategoryDuplicationExists($name)
        {
            //$query = "SELECT COUNT(*) FROM [|PREFIX|]categories WHERE catname='".$this->db->Quote($name)."'";
            $query      = "SELECT COUNT(*) FROM isc_categories WHERE catname = '".$GLOBALS['ISC_CLASS_DB']->Quote($name)."'
                        ";

            $result     = $GLOBALS['ISC_CLASS_DB']->Query($query);

            $num        = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);

            if ($num > 0) {
                return true;
            } else {
                return false;
            }
        }

        /**
        * DuplicationExists
        * Check to see if a category, brand or series with a given name exists under a given  
        *                                                
        * @param int $name The name of the category
        *
        * @return boolean Does the category, brand or series exist or not ?
        */
        function SeriesDuplicationExists($name)
        {
            //$query = "SELECT COUNT(*) FROM [|PREFIX|]categories WHERE catname='".$this->db->Quote($name)."'";
            $query      = "SELECT COUNT(*) FROM isc_brand_series WHERE seriesname = '".$GLOBALS['ISC_CLASS_DB']->Quote($name)."'
                        ";

            $result     = $GLOBALS['ISC_CLASS_DB']->Query($query);

            $num        = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);

            if ($num > 0) {
                return true;
            } else {
                return false;
            }
        }

        /**
        * DuplicationExists
        * Check to see if a category, brand or series with a given name exists under a given  
        *                                                
        * @param int $name The name of the category
        *
        * @return boolean Does the category, brand or series exist or not ?
        */
        function BrandDuplicationExists($name)
        {
            //$query = "SELECT COUNT(*) FROM [|PREFIX|]categories WHERE catname='".$this->db->Quote($name)."'";
            $query      = "SELECT COUNT(*) FROM isc_brands WHERE brandname = '".$GLOBALS['ISC_CLASS_DB']->Quote($name)."'
                        ";

            $result     = $GLOBALS['ISC_CLASS_DB']->Query($query);

            $num        = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);

            if ($num > 0) {
                return true;
            } else {
                return false;
            }
        }

        
		/**
		* Get categories by a parent id without hierachy, only the first level childs will be retrieved
		* Returned html of options
		* 
		* lguan_20100612: Creation to support product rating by categories
		*/
		public function GetFlatCategories($SelectedCats = 0, $Container = "<option %s value='%d'>%s</option>", $Sel = "selected=\"selected\"", $parentcatid=0)
		{
			// Get a list of categories as <option> tags
			$cats = ''; 
			$query = sprintf("SELECT categoryid, catname FROM isc_categories WHERE catparentid=%d ORDER BY catname ASC", $parentcatid);
            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
            while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                $sel = '';
                if($SelectedCats == $row['categoryid']) {
                    $sel = 'selected="selected"';
                }
                $cats .= sprintf($Container, $sel, $row['categoryid'], isc_html_escape($row['catname']));
            }
			return $cats;
			
		}
        
	// Add by NI_20101125_Mike
     // rebuild category brand  cached data,need to reclauate the total number of the product of each root category.
	 function UpdateCategoryBrandProductCache()
       {
       		 $GLOBALS['ISC_CategoryBrandCache'] = GetClass('ISC_CACHECATEGORYBRANDS');
           $GLOBALS['ISC_CategoryBrandCache']->ClearCategoryBrandData();
            $GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess(array('general', 'Category_Brand back_end'),'Category Brand cache file is updated.','Category Brand  cache file is updated.');
       }
       
		//zcs=>build Category,subcategory options
		public function GetCategoryAsOptions($isSub = FALSE)
		{
			$output = "";
			$sel = "";
			$query = "SELECT * FROM [|PREFIX|]categories WHERE catparentid ".($isSub ? "!=" : "=")." '0' ORDER BY catname ASC";
			$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
		
			while($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)){
				$output .= sprintf("<option value='%d'>%s</option>", $row['categoryid'], $row['catname']);
			}
		
			return $output;
		}
		//<=zcs
	}

?>
