<?php

	class ISC_ADMIN_BRANDS
	{   
		public function HandleToDo($Do)
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('brands');
            $GLOBALS['ISC_CLASS_ADMIN_CATEGORY'] = GetClass('ISC_ADMIN_CATEGORY');
            
			switch (isc_strtolower($Do)) {
				case "saveeditedbrand":
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Brands)) {
						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Brands') => "index.php?ToDo=viewBrands");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->SaveEditedBrand();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}

					break;
				}
				case "editbrand":
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Brands)) {
						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Brands') => "index.php?ToDo=viewBrands", GetLang('EditBrand') => "index.php?ToDo=editBrand");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->EditBrand();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}

					break;
				}
				case "savenewbrands":
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Add_Brands)) {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->SaveNewBrands();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}

					break;
				}
				case "addbrand":
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Add_Brands)) {
						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Brands') => "index.php?ToDo=viewBrands", GetLang('AddBrands') => "index.php?ToDo=addBrand");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->AddBrands();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}

					break;
				}
				case "deletebrands":
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Delete_Brands)) {
						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Brands') => "index.php?ToDo=viewBrands");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->DeleteBrands();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}

					break;
				}
                /* Added for series -- Baskaran */
                case "addbrandseries":
                {
                    if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Add_Brands)) {
                        $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Brands') => "index.php?ToDo=viewBrands", GetLang('AddSeries') => "index.php?ToDo=addbrandseries");

                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        $this->AddSeries();
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        die();
                    } else {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
                    }

                    break;
                }
                case "savebrandseries":
                {
                        if(isset($_POST['addanother']) == 'addanother') {
                            $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Brands') => "index.php?ToDo=viewBrands", GetLang('AddSeries') => "index.php?ToDo=addbrandseries");
                        }
                        else {
                            $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Brands') => "index.php?ToDo=viewBrands", GetLang('AddSeries') => "index.php?ToDo=addbrandseries");
                        }
                    
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        $this->SaveNewSeries();
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        die();
                    break;
                }
                case "editbrandseries":
                {
                    if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Brands)) {
                        if(isset($_POST['keepedit']) == 'keepedit') {
                            $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Brands') => "index.php?ToDo=viewBrands", GetLang('EditSeries') => "index.php?ToDo=editBrandSeries");
                        }
                        else {
                            $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Brands') => "index.php?ToDo=viewBrands", GetLang('EditSeries') => "index.php?ToDo=editBrandSeries");
                        }
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        $this->EditSeries();
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        die();
                    } else {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
                    }

                    break;
                }
                case "saveeditedbrandseries":
                {
                        if(isset($_POST['keepedit']) == 'keepedit') {
                            $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Brands') => "index.php?ToDo=viewSeries", GetLang('EditSeries') => "index.php?ToDo=editBrandSeries");
                        }
                        else {
                            $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Brands') => "index.php?ToDo=viewSeries", GetLang('EditSeries') => "index.php?ToDo=editBrandSeries");
                        }
                    
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        $this->SaveEditedSeries();
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        die();
                    break;
                }
                /* Ends here */
				default:
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Brands)) {
						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Brands') => "index.php?ToDo=viewBrands");

						if(!isset($_REQUEST['ajax'])) {
							$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						}

						$this->ManageBrands();

						if(!isset($_REQUEST['ajax'])) {
							$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						}
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
				}
			}
		}

		public function _GetBrandList(&$Query, $Start, $SortField, $SortOrder, &$NumResults)
		{
			// Return an array containing details about brands.
			// Takes into account search too.

			// PostgreSQL is case sensitive for likes, so all matches are done in lower case
			$Query = trim(isc_strtolower($Query));

			$query = "
				SELECT b.*, 
                FLOOR(SUM(p.prodratingtotal)/SUM(p.prodnumratings)) AS prodavgrating, 
                (SELECT COUNT(productid) FROM [|PREFIX|]products p 
                WHERE p.prodbrandid=b.brandid) AS products 
				FROM [|PREFIX|]brands b
                LEFT JOIN [|PREFIX|]products p ON p.prodbrandid=b.brandid
			";

			$countQuery = "SELECT COUNT(*) FROM [|PREFIX|]brands b";

			$queryWhere = ' WHERE 1=1 ';
			if ($Query != "") {
				$queryWhere .= " AND LOWER(b.brandname) LIKE '%".$GLOBALS['ISC_CLASS_DB']->Quote($Query)."%'";
			}

			$query .= $queryWhere;
			$countQuery .= $queryWhere;

			$result = $GLOBALS['ISC_CLASS_DB']->Query($countQuery);
			$NumResults = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);

			if($NumResults > 0) {
				$query .= " GROUP BY b.brandid ORDER BY ".$SortField." ".$SortOrder;

				// Add the limit
				//$query .= $GLOBALS["ISC_CLASS_DB"]->AddLimit($Start, ISC_BRANDS_PER_PAGE);
				$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
				return $result;
			}
			else {
				return false;
			}
		}

		public function ManageBrandsGrid(&$numBrands)
		{
			// Show a list of news in a table
			$page = 0;
			$start = 0;
			$numBrands = 0;
			$numPages = 0;
			$GLOBALS['BrandGrid'] = "";
			$GLOBALS['Nav'] = "";
			$max = 0;
			$searchURL = '';

			if (isset($_GET['searchQuery'])) {
				$query = $_GET['searchQuery'];
				$GLOBALS['Query'] = $query;
				$searchURL .'searchQuery='.urlencode($query);
			} else {
				$query = "";
				$GLOBALS['Query'] = "";
			}

			if (isset($_GET['sortOrder']) && $_GET['sortOrder'] == 'desc') {
				$sortOrder = 'desc';
			} else {
				$sortOrder = "asc";
			}

			$sortLinks = array(
				"Brand" => "b.brandname",
				"Products" => "products",
			);

			if (isset($_GET['sortField']) && in_array($_GET['sortField'], $sortLinks)) {
				$sortField = $_GET['sortField'];
				SaveDefaultSortField("ManageBrands", $_REQUEST['sortField'], $sortOrder);
			}
			else {
				list($sortField, $sortOrder) = GetDefaultSortField("ManageBrands", "b.brandname", $sortOrder);
			}

			if (isset($_GET['page'])) {
				$page = (int)$_GET['page'];
			}
			else {
				$page = 1;
			}

			$sortURL = sprintf("&sortField=%s&sortOrder=%s", $sortField, $sortOrder);
			$GLOBALS['SortURL'] = $sortURL;

			// Limit the number of brands returned
			if ($page == 1) {
				
			}
			else {
				$start = ($page * ISC_BRANDS_PER_PAGE) - (ISC_BRANDS_PER_PAGE-1);
			}
$start = 1;
			$start = $start-1;

			// Get the results for the query
			$brandResult = $this->_GetBrandList($query, $start, $sortField, $sortOrder, $numBrands);
			$numPages = ceil($numBrands / ISC_BRANDS_PER_PAGE);

			// Workout the paging navigation
			if($numBrands > ISC_BRANDS_PER_PAGE) {
				$GLOBALS['Nav'] = sprintf("(%s %d of %d) &nbsp;&nbsp;&nbsp;", GetLang('Page'), $page, $numPages);

				$GLOBALS['Nav'] .= BuildPagination($numBrands, ISC_BRANDS_PER_PAGE, $page, sprintf("index.php?ToDo=viewBrands%s", $sortURL));
			}
			else {
				$GLOBALS['Nav'] = "";
			}

$GLOBALS['Nav'] = "";
			$GLOBALS['SearchQuery'] = $query;
			$GLOBALS['SortField'] = $sortField;
			$GLOBALS['SortOrder'] = $sortOrder;

			BuildAdminSortingLinks($sortLinks, "index.php?ToDo=viewBrands&amp;".$searchURL."&amp;page=".$page, $sortField, $sortOrder);


			// Workout the maximum size of the array
			$max = $start + ISC_BRANDS_PER_PAGE;

			if ($max > count($brandResult)) {
				$max = count($brandResult);
			}

			
			if($numBrands > 0) {
			
				// Display the news
				$i = 1;
				while ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($brandResult)) {
					$GLOBALS['BrandId'] = (int) $row['brandid'];
					$GLOBALS['BrandName'] = isc_html_escape($row['brandname']);
					$GLOBALS['Products'] = (int) $row['products'];

					// Workout the edit link -- do they have permission to do so?
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Brands)) {
						$GLOBALS['EditBrandLink'] = sprintf("<a title='%s' class='Action' href='index.php?ToDo=editBrand&amp;brandId=%d'>%s</a>", GetLang('BrandEdit'), $row['brandid'], GetLang('Edit'));
					} else {
						$GLOBALS['EditNewsLink'] = sprintf("<a class='Action' disabled>%s</a>", GetLang('Edit'));
					} 
                     
                    if($row['prodavgrating'] > 0)    {          
                        $GLOBALS['Rating'] = "";
                        $ratingText = sprintf(GetLang('ReviewRated'), $row['prodavgrating']);

                        for ($r = 0; $r < $row['prodavgrating']; $r++) {
                            $GLOBALS['Rating'] .= sprintf("<img title='%s' width='13' height='12' src='images/rating_on.gif'>", $ratingText);
                        }

                        for ($r = $row['prodavgrating']; $r < 5; $r++) {
                            $GLOBALS['Rating'] .= sprintf("<img title='%s' width='13' height='12' src='images/rating_off.gif'>", $ratingText);
                        }
                    }
                    else    {
                        $GLOBALS['Rating'] = "Not Rated";
                    }
                    
                    $GLOBALS['ViewFeedbackLink'] = sprintf("<a title='%s' class='Action' href='index.php?ToDo=viewReviews&amp;brandid=%d'>%s</a>", GetLang('ViewFeedback'), $row['brandid'], GetLang('ViewFeedback')); 

                    /* To display series under the brands -- Baskaran */
                    $cntquery = $GLOBALS["ISC_CLASS_DB"]->Query("SELECT COUNT( productid ) as prodcnt FROM [|PREFIX|]products WHERE brandseriesid =".$row['brandid']);
                    $cntrow = $GLOBALS["ISC_CLASS_DB"]->Fetch($cntquery);
                    $squery = "
                                SELECT b.*, FLOOR(SUM(p.prodratingtotal)/SUM(p.prodnumratings)) AS seriesprodavgrating, 
                                (SELECT count(productid) FROM [|PREFIX|]products where brandseriesid = b.seriesid) as prodcnt 
                                FROM [|PREFIX|]brand_series b
                                LEFT JOIN [|PREFIX|]products p ON p.brandseriesid=b.seriesid
                                where b.brandid =  ".$row['brandid']." GROUP BY b.seriesid order by seriessort asc ";
                    $sresult = $GLOBALS["ISC_CLASS_DB"]->Query($squery);
                    $GLOBALS['Brandidhide'] = 'b'.$row['brandid'];
                   // $GLOBALS['SeriesGrid'] = '';
				   
					$GLOBALS['SeriesGrid'] = '<ul class="SortableList" id="SeriesList_'.$i.'">';
                    //Append Series Row
				
                    while ($srow = $GLOBALS["ISC_CLASS_DB"]->Fetch($sresult)) {
						
                        $GLOBALS['SeriesId'] = (int) $srow['seriesid'];
                        $GLOBALS['SeriesName'] = wordwrap(isc_html_escape($srow['seriesname']),90,'<br>',true);
                        $GLOBALS['Prodcnt'] = $srow['prodcnt'];
                                // Workout the edit link -- do they have permission to do so?
                                if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Brands)) {
                                    $GLOBALS['EditSeriesLink'] = sprintf("<a title='%s' class='Action' href='index.php?ToDo=editBrandSeries&amp;seriesId=%d'>%s</a>", GetLang('SeriesEdit'), $srow['seriesid'], GetLang('Edit'));
                                } else {
                                    $GLOBALS['EditNewsLink'] = sprintf("<a class='Action' disabled>%s</a>", GetLang('Edit'));
                                }
                                                   
                                if($srow['seriesprodavgrating'] > 0)    {          
                                    $GLOBALS['SeriesRating'] = "";
                                    $ratingText = sprintf(GetLang('ReviewRated'), $srow['seriesprodavgrating']);

                                    for ($r = 0; $r < $srow['seriesprodavgrating']; $r++) {
                                        $GLOBALS['SeriesRating'] .= sprintf("<img title='%s' width='13' height='12' src='images/rating_on.gif'>", $ratingText);
                                    }

                                    for ($r = $srow['seriesprodavgrating']; $r < 5; $r++) {
                                        $GLOBALS['SeriesRating'] .= sprintf("<img title='%s' width='13' height='12' src='images/rating_off.gif'>", $ratingText);
                                    }
                                }
                                else    {
                                    $GLOBALS['SeriesRating'] = "Not Rated";
                                }
                                
                                $GLOBALS['ViewSeriesFeedbackLink'] = sprintf("<a title='%s' class='Action' href='index.php?ToDo=viewReviews&amp;brandid=%d&amp;seriesid=%d'>%s</a>", GetLang('ViewFeedback'), $row['brandid'], $srow['seriesid'], GetLang('ViewFeedback')); 

                                $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("series.manage.row");
                                $GLOBALS['SeriesGrid'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
								
                    } 
					$GLOBALS['SeriesGrid'] .= '</ul>';
					$i++;
                    /* Ends here */                    
					$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("brands.manage.row");
					$GLOBALS['BrandGrid'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
				}
				
				$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("brands.manage.grid");
				return $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
			}
		}

		public function ManageBrands($MsgDesc = "", $MsgStatus = "")
		{
			// Fetch any results, place them in the data grid
			$numBrands = 0;
			$GLOBALS['BrandsDataGrid'] = $this->ManageBrandsGrid($numBrands);

			// Was this an ajax based sort? Return the table now
			if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 1) {
				echo $GLOBALS['BrandsDataGrid'];
				return;
			}

			if ($MsgDesc != "") {
				$GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
			}

			if (isset($_GET['searchQuery'])) {
				$GLOBALS['ClearSearchLink'] = '<a id="SearchClearButton" href="index.php?ToDo=viewBrands">'.GetLang('ClearResults').'</a>';
			} else {
				$GLOBALS['ClearSearchLink'] = '';
			}

			$GLOBALS['BrandIntro'] = GetLang('ManageBrandsIntro');

			// Do we need to disable the delete button?
			if (!$GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Delete_Brands) || $numBrands == 0) {
				$GLOBALS['DisableDelete'] = "DISABLED";
			}

			// No results
			if($numBrands == 0) {
				$GLOBALS['DisplayGrid'] = "none";
				if(count($_GET) > 1) {
					if ($MsgDesc == "") {
						$GLOBALS['Message'] = MessageBox(GetLang('NoBrandResults'), MSG_ERROR);
					}
				}
				else {
					$GLOBALS['DisplaySearch'] = "none";
					$GLOBALS['Message'] = MessageBox(GetLang('NoBrands'), MSG_SUCCESS);
				}
			}

			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("brands.manage");
			$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
		}

        public function DeleteBrands()
        {
            if (isset($_POST['brands']) or isset($_POST['series'])) {
                
                @$brandids = implode("','", $GLOBALS['ISC_CLASS_DB']->Quote($_POST['brands']));
                @$seriesids = implode("','", $GLOBALS['ISC_CLASS_DB']->Quote($_POST['series']));
//                print_r($seriesids); echo "<br>"; print_r($brandids);exit;

                // Log this action
                @$GLOBALS['ISC_CLASS_LOG']->LogAdminAction(count($_POST['brands']));
                @$GLOBALS['ISC_CLASS_LOG']->LogAdminAction(count($_POST['series']));

                if($brandids != ''){
                    # Deleting vendor,pages and update vendorid in users table while deleting the brand -- Baskaran
                    $vquery = $GLOBALS['ISC_CLASS_DB']->Query("SELECT vendorid FROM [|PREFIX|]brands where brandid IN('".$brandids."')");                    
                    // Delete the brands
                    $query = sprintf("delete from [|PREFIX|]brands where brandid in ('%s')", $brandids);
                    $GLOBALS["ISC_CLASS_DB"]->Query($query);

                    // Delete the brand associations
                    $updatedProducts = array(
                        "prodbrandid" => 0
                    );

                    $GLOBALS['ISC_CLASS_DB']->UpdateQuery("products", $updatedProducts, "prodbrandid IN ('".$brandids."')");
                    while($vrow = $GLOBALS["ISC_CLASS_DB"]->Fetch($vquery)){
                        $vendorid = $vrow['vendorid'];
                        $GLOBALS['ISC_CLASS_DB']->Query("delete from [|PREFIX|]vendors WHERE vendorid='".(int)$vendorid."'"); 
                        $GLOBALS['ISC_CLASS_DB']->Query("delete from [|PREFIX|]pages WHERE pagevendorid='".(int)$vendorid."'");                                                                           
                        $GLOBALS['ISC_CLASS_DB']->UpdateQuery("users",array('uservendorid'=> '0'),"uservendorid = $vendorid");                  
                        $GLOBALS['ISC_CLASS_DB']->UpdateQuery("products",array('prodvendorid'=>0),"prodvendorid in ('".$vendorid."')");
                    }                    
                    /* To delete the series record and corresponding series id of brand id Baskaran */
                    # While selecting brand we need to delete brand and the corresponding series in the brand_series table
                    
                    $selquery = $GLOBALS["ISC_CLASS_DB"]->Query("SELECT seriesid FROM [|PREFIX|]brand_series where brandid in('$brandids')");
                    $selid = array();
                    while($selrow = $GLOBALS["ISC_CLASS_DB"]->Fetch($selquery)) {
                    $selid[] = $selrow['seriesid'];
                    }
                    if(count($selid) > 0) {
                        $selimp = implode("','",$selid);
                    
                        $bquery = sprintf("DELETE FROM [|PREFIX|]brand_series where brandid in ('%s')",$brandids);
                        $GLOBALS["ISC_CLASS_DB"]->Query($bquery);
                        
                        $brandProducts = array(
                            "brandseriesid" => 0
                        );
                        
                        $GLOBALS['ISC_CLASS_DB']->UpdateQuery("products", $brandProducts, "brandseriesid IN ('".$selimp."')");
                    }
                }
                # While selecting series deleting only series
                $squery = sprintf("DELETE FROM [|PREFIX|]brand_series where seriesid in ('%s')",$seriesids);
                $GLOBALS["ISC_CLASS_DB"]->Query($squery);
                
                $seriesProducts = array(
                    "brandseriesid" => 0
                );
                $GLOBALS['ISC_CLASS_DB']->UpdateQuery("products", $seriesProducts, "brandseriesid IN ('".$seriesids."')");
                /* Ends here */
                $err = $GLOBALS["ISC_CLASS_DB"]->Error();
                if ($err != "") {
                    $this->ManageBrands($err, MSG_ERROR);
                } else {
                    $this->ManageBrands(GetLang('BrandsDeletedSuccessfully'), MSG_SUCCESS);
                }
            } else {
                if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Brands)) {
                    $this->ManageBrands();
                } else {
                    $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
                }
            }
        }

		public function AddBrands()
		{
			$GLOBALS['BrandTitle'] = GetLang('AddBrands');
			$GLOBALS['BrandIntro'] = GetLang('AddBrandIntro');
			$GLOBALS['CancelMessage'] = GetLang('CancelCreateBrand');
			$GLOBALS['FormAction'] = "SaveNewBrands";

			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("brand.form");
			$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
		}

		public function GetBrandsAsOptions($SelectedBrandId = 0)
		{
			// Return a list of brands as options for a select box.
			$output = "";
			$sel = "";
			$query = "SELECT * FROM [|PREFIX|]brands ORDER BY brandname asc";
			$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);

			while($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
				if($row['brandid'] == $SelectedBrandId) {
					$sel = "selected=\"selected\"";
				}
				else {
					$sel = "";
				}

				$output .= sprintf("<option value='%d' %s>%s</option>", $row['brandid'], $sel, $row['brandname']);
			}

			return $output;
		}

		public function GetBrandsAsArray(&$RefArray)
		{
			/*
				Return a list of brands as an array. This will be used to check
				if a brand already exists. It's more efficient to do one query
				rather than one query per brand check.

				$RefArray - An array passed in by reference only
			*/

			$query = "select brandname from [|PREFIX|]brands";
			$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);

			while($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result))
				$RefArray[] = isc_strtolower($row['brandname']);
		}

		public function SaveNewBrands()
		{
			$brands_added = 0;
			$message = "";
			$current_brands = array();
			$this->GetBrandsAsArray($current_brands);

			if(isset($_POST['brands'])) {
				$brands = $_POST['brands'];
				$brand_list = explode("\n", $brands);
                $altkeyword = trim($_POST['brandaltkeyword']);
				// Log this action
				$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($brand_list);

				// Save the brands to the database
				foreach($brand_list as $brand) {
					$brand = trim($brand);     
                    if(!$GLOBALS['ISC_CLASS_ADMIN_CATEGORY']->SeriesDuplicationExists($brand) && !$GLOBALS['ISC_CLASS_ADMIN_CATEGORY']->CategoryDuplicationExists($brand)) { ////Condition loop check duplication starts here  
                        if(!in_array(isc_strtolower($brand), $current_brands) && trim($brand) != "") {
						    $newBrand = array(
							    "brandname" => $brand,
							    "brandpagetitle" => "",
							    "brandmetakeywords" => "",
							    "brandmetadesc" => "",
                                "brandaltkeyword" => $altkeyword
						    );
						    $GLOBALS['ISC_CLASS_DB']->InsertQuery("brands", $newBrand);
                            $bid = $GLOBALS['ISC_CLASS_DB']->LastId();
                            $query = $GLOBALS["ISC_CLASS_DB"]->Query("SELECT vendorname FROM [|PREFIX|]vendors where vendorname = lower('$brand')");
                            $cnt = $GLOBALS["ISC_CLASS_DB"]->CountResult($query);
                            if($cnt == 0){
                                $newVendor = array(
                                    'vendorname' => $brand
                                );
                                $GLOBALS['ISC_CLASS_DB']->InsertQuery("vendors",$newVendor);
                                $vid = $GLOBALS['ISC_CLASS_DB']->LastId();
                                $GLOBALS['ISC_CLASS_DB']->UpdateQuery("brands",array('vendorid'=>$vid), "brandid = $bid");
                            }
						    ++$brands_added;
					    }
                    }//Condition loop Check duplication ends here
				}

				// Check for an error message from the database
				if($GLOBALS["ISC_CLASS_DB"]->GetErrorMsg() == "") {
					// No error
					if($brands_added == 1) {
						$message = GetLang('OneBrandAddedSuccessfully');
					}
					else {
						$message = sprintf(GetLang('MultiBrandsAddedSuccessfully'), $brands_added);
					}

					$this->ManageBrands($message, MSG_SUCCESS);
				}
				else {
					// Something went wrong
					$message = sprintf(GetLang('BrandAddError'), $GLOBALS["ISC_CLASS_DB"]->GetErrorMsg());
					$this->ManageBrands($message, MSG_ERROR);
				}
			}
			else {
				ob_end_clean();
				header("Location: index.php?ToDo=viewBrands");
				die();
			}
		}

		public function EditBrand($MsgDesc = "", $MsgStatus = "")
		{
			if(isset($_GET['brandId'])) {
				if ($MsgDesc != "") {
					$GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
				}

				$brandId = (int)$_GET['brandId'];
				$query = sprintf("select * from [|PREFIX|]brands where brandid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($brandId));
				$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);

				if($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
					$GLOBALS['BrandId'] = $row['brandid'];
					$GLOBALS['BrandName'] = isc_html_escape($row['brandname']);
					$GLOBALS['BrandPageTitle'] = isc_html_escape($row['brandpagetitle']);
					$GLOBALS['BrandMetaKeywords'] = isc_html_escape($row['brandmetakeywords']);
					$GLOBALS['BrandMetaDesc'] = isc_html_escape($row['brandmetadesc']);
                    $GLOBALS['BrandAltkeyword'] = isc_html_escape($row['brandaltkeyword']);
                    $wysiwygOptions1 = array(
                        'id'        => 'wysiwyg',
                        'width'        => '60%',
                        'height'    => '350px',
                        'value'        => $row['branddescription']
                    );
                    $wysiwygOptions2 = array(
                        'id'        => 'wysiwyg2',
                        'width'        => '60%',
                        'height'    => '350px',
                        'value'        => $row['brandfooter']
                    );
                    $GLOBALS['WYSIWYG1'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor($wysiwygOptions1); 
                    $GLOBALS['WYSIWYG2'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor1($wysiwygOptions2);
					$GLOBALS['BrandTitle'] = GetLang('EditBrand');
					$GLOBALS['BrandIntro'] = GetLang('EditBrandIntro');
					$GLOBALS['CancelMessage'] = GetLang('CancelEditBrand');
					$GLOBALS['FormAction'] = "SaveEditedBrand";
					$GLOBALS['BrandImageMessage'] = '';
					if ($row['brandimagefile'] !== '') {
						$image = '../' . GetConfig('ImageDirectory') . '/' . $row['brandimagefile'];
						$GLOBALS['BrandImageMessage'] = sprintf(GetLang('BrandImageDesc'), $image, $row['brandimagefile']);
					}

					$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("brand.edit.form");
					$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
				}
				else {
					ob_end_clean();
					header("Location: index.php?ToDo=viewBrands");
					die();
				}
			}
			else {
				ob_end_clean();
				header("Location: index.php?ToDo=viewBrands");
				die();
			}
		}

		public function SaveEditedBrand()
		{
			if(isset($_POST['brandName'])) {
				$brandId = (int)$_POST['brandId'];
				$oldBrandName = $_POST['oldBrandName'];
				$brandName = $_POST['brandName'];
				$brandPageTitle = $_POST['brandPageTitle'];
				$brandMetaKeywords = $_POST['brandMetaKeywords'];
				$brandMetaDesc = $_POST['brandMetaDesc'];
                $brandaltkeyword = trim($_POST['brandaltkeyword']); 
                $WYSIWYG1 = $this->FormatWYSIWYGHTML($_POST['wysiwyg']);
                $WYSIWYG2 = $this->FormatWYSIWYGHTML($_POST['wysiwyg2']);

				// Make sure the brand doesn't already exist
				$query = sprintf("select count(brandid) as num from [|PREFIX|]brands where lower(brandname)='%s' and lower(brandname) !='%s'", $GLOBALS['ISC_CLASS_DB']->Quote(isc_strtolower($brandName)), $GLOBALS['ISC_CLASS_DB']->Quote(isc_strtolower($oldBrandName)));
				$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
				$row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result);

				if($row['num'] == 0) {
                     if (!$GLOBALS['ISC_CLASS_ADMIN_CATEGORY']->CategoryDuplicationExists($brandName) && !$GLOBALS['ISC_CLASS_ADMIN_CATEGORY']->SeriesDuplicationExists($brandName)) {
					    // Log this action
					    $GLOBALS['ISC_CLASS_LOG']->LogAdminAction($_POST['brandId'], $_POST['brandName']);

					    // No duplicates
					    $updatedBrand = array(
						    "brandname" => $brandName,
						    "brandpagetitle" => $brandPageTitle,
						    "brandmetakeywords" => $brandMetaKeywords,
						    "brandmetadesc" => $brandMetaDesc,
                            "brandaltkeyword" => $brandaltkeyword,
                            "branddescription" => $WYSIWYG1,
                            "brandfooter" => $WYSIWYG2
					    );
					    $GLOBALS['ISC_CLASS_DB']->UpdateQuery("brands", $updatedBrand, "brandid='".$GLOBALS['ISC_CLASS_DB']->Quote($brandId)."'"); 
                        $vquery = $GLOBALS['ISC_CLASS_DB']->Query("SELECT vendorid FROM [|PREFIX|]brands where brandid = $brandId");             $vrow = $GLOBALS['ISC_CLASS_DB']->Fetch($vquery);
                        $vendorid = $vrow['vendorid'];
                        $GLOBALS['ISC_CLASS_DB']->UpdateQuery("vendors",array('vendorname'=>$brandName),"vendorid=$vendorid");                    
                        $LargeFile = '';
					    if($GLOBALS["ISC_CLASS_DB"]->GetErrorMsg() == "") {

						    if (array_key_exists('delbrandimagefile', $_POST) && $_POST['delbrandimagefile']) {
							    $this->DelBrandImage($brandId);
							    $GLOBALS['ISC_CLASS_DB']->UpdateQuery('brands', array('brandimagefile' => '', 'brandlargefile' => ''), "brandid='" . (int)$brandId . "'");
						    } else if (array_key_exists('brandimagefile', $_FILES) && ($brandimagefile = $this->SaveBrandImage($LargeFile))) {
							    $GLOBALS['ISC_CLASS_DB']->UpdateQuery('brands', array('brandimagefile' => $brandimagefile, 'brandlargefile' => $LargeFile), "brandid='" . (int)$brandId . "'");
						    }

						    $this->ManageBrands(GetLang('BrandUpdatedSuccessfully'), MSG_SUCCESS);
					    }
					    else {
						    $this->EditBrand(sprintf(GetLang('UpdateBrandError'), $GLOBALS["ISC_CLASS_DB"]->GetErrorMsg()), MSG_ERROR);
					    }
                    }
                    else    {     
                         // Duplicate brand name, take them back to the 'Edit' page
                         $_GET['brandId'] = $brandId;
                         $this->EditBrand(sprintf(GetLang('NameAlreadyExists'), $brandName), MSG_ERROR);
                    }
				}
				else {
					// Duplicate brand name, take them back to the 'Edit' page
					$_GET['brandId'] = $brandId;
					$this->EditBrand(sprintf(GetLang('DuplicateBrandName'), $brandName), MSG_ERROR);
				}
			}
			else {
				ob_end_clean();
				header("Location: index.php?ToDo=viewBrands");
				die();
			}
		}

        /* Series added to combine in brand page -- Baskaran */
        public function AddSeries()
        {
            $GLOBALS['Message'] = GetFlashMessageBoxes();  
            $GLOBALS['SeriesTitle'] = GetLang('AddSeries');
            $GLOBALS['SeriesIntro'] = GetLang('AddSeriesIntro');
            $GLOBALS['CancelMessage'] = GetLang('CancelCreateSeries');
            $GLOBALS['FormAction'] = "SaveBrandSeries";
            $brandid = 0;
            $GLOBALS['BrandName'] = $this->BrandName($brandid);
            $wysiwygOptions = array(
                    'id'        => 'wysiwyg',
                    'width'        => '60%',
                    'height'    => '300px'
                );                                                                                 
            $wysiwygOptions3 = array(
                    'id'        => 'wysiwyg3',
                    'width'        => '60%',
                    'height'    => '350px',
                    'value'        => ''
			);
			$wysiwygOptions4 = array(
                    'id'        => 'wysiwyg4',
                    'width'        => '60%',
                    'height'    => '300px'
			);
			$GLOBALS['WYSIWYG'] =  GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor1($wysiwygOptions);
            $GLOBALS['WYSIWYG3'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor($wysiwygOptions3);
            $GLOBALS['WYSIWYG4'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor1($wysiwygOptions4);
            $GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("series.form");
            $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
        }
        
         public function SaveNewSeries() {

        # Used to clear the HTML Editor image upload folder name Baskaran
            $_SESSION['congobrand'] = '';
            $_SESSION['congoseries'] = '';
            
            if(isset($_POST['seriesname'])) {
                $seriesname = $_POST['seriesname'];

                $proddesc = ''; 
                if(isset($_POST["wysiwyg_html"])) {
                    $proddesc = $this->FormatWYSIWYGHTML(trim($_POST["wysiwyg_html"]));
                }
                else {
                    $proddesc = $this->FormatWYSIWYGHTML(trim($_POST['wysiwyg']));
                }

				$featurepoints = $this->FormatWYSIWYGHTML(trim($_POST['wysiwyg3']));
				$divdesc = $this->FormatWYSIWYGHTML(trim($_POST['wysiwyg4']));				
                
                // Save the brands to the database
                    $seriesname = trim($seriesname);
                    $brandid = $_POST['vendor'];
                    $seriesphoto = $this->_StoreFileAndReturnId('seriesimagefile');              
                    $seriesphoto = $this->_AutoGenerateThumb($seriesphoto);

					$serieslargeimage = $this->_StoreFileAndReturnId('serieslargeimagefile');   
					$serieslargeimage = $this->_AutoGenerateThumbForLargeImage($serieslargeimage);
                    
                    $seriescontent = trim($_POST['contents']);
                    /*$featurepoints1 = trim($_POST['featurepoints1']);
                    $featurepoints2 = trim($_POST['featurepoints2']);
                    $featurepoints3 = trim($_POST['featurepoints3']);
                    $featurepoints4 = trim($_POST['featurepoints4']);*/
                    $seriesaltkeyword = trim($_POST['seriesaltkeyword']);

					$seriespagetitle = isc_html_escape($_POST['seriespagetitle']);
					$seriesmetakeywords = isc_html_escape($_POST['seriesmetakeywords']);
					$seriesmetadesc = isc_html_escape($_POST['seriesmetadesc']);
					$seriesimagecaption = isc_html_escape($_POST['seriesimagealt']);

					/*
						-- commented the below variables from the array $newSeries --
						"feature_points1" => $featurepoints1,
						"feature_points2" => $featurepoints2,
						"feature_points3" => $featurepoints3,
						"feature_points4" => $featurepoints4,
					*/
					
					$newSeries = array(
						"seriesname" => $seriesname,
						"brandid" => $brandid,
						"seriesphoto" => $seriesphoto,
						"seriescontent" => $seriescontent,
						"proddesc" => $proddesc,
						"seriesaltkeyword" => $seriesaltkeyword,
						"feature_points" => $featurepoints,
						"divdesc" => $divdesc,
						"serieshoverimagefile" => $serieslargeimage,
						"seriespagetitle" => $seriespagetitle,
						"seriesmetakeywords" => $seriesmetakeywords,
						"seriesmetadesc" => $seriesmetadesc,
						"seriesimagealt" => $seriesimagecaption
					);
                    $query = "select * from [|PREFIX|]brand_series where seriesname = '".$seriesname."'";
                    $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
                    $cnt = $GLOBALS["ISC_CLASS_DB"]->CountResult($result);    
                    if($cnt != 1) {
                        if(!$GLOBALS['ISC_CLASS_ADMIN_CATEGORY']->BrandDuplicationExists($seriesname) && !$GLOBALS['ISC_CLASS_ADMIN_CATEGORY']->CategoryDuplicationExists($seriesname)) {    
                            $GLOBALS['ISC_CLASS_DB']->InsertQuery("brand_series", $newSeries);
                        }
                        else {                                                                                                          
                            FlashMessage(sprintf(GetLang('NameAlreadyExists'),$seriesname), MSG_ERROR, 'index.php?ToDo=addBrandSeries');
                        } 
                    }
                    else {
                        FlashMessage(sprintf(GetLang('SeriesAlreadyAdded'),$seriesname), MSG_ERROR, 'index.php?ToDo=addbrandseries');
                    }
                    
                    if($_POST['addanother'] == 'addanother') {
                        FlashMessage(GetLang('SeriesAddedSuccessfully'), MSG_SUCCESS);
                        header("Location: index.php?ToDo=addbrandseries");
                        exit;
                    }
                // Check for an error message from the database
                if($GLOBALS["ISC_CLASS_DB"]->GetErrorMsg() == "") {
                    // No error                    
                    $this->manageBrands(GetLang('SeriesAddedSuccessfully'), MSG_SUCCESS);
                }
                else {
                    // Something went wrong
                    $message = sprintf(GetLang('SeriesAddError'), $GLOBALS["ISC_CLASS_DB"]->GetErrorMsg());
                    $this->manageBrands($message, MSG_ERROR);
                }
            }
            else {
                ob_end_clean();
                header("Location: index.php?ToDo=viewBrands");
                die();
            }            
        }
        
        public function EditSeries($MsgDesc = "", $MsgStatus = "")
        {
            $GLOBALS['Message'] = GetFlashMessageBoxes(); 
            if(isset($_GET['seriesId'])) {
                if ($MsgDesc != "") {
                    $GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
                }

                $seriesId = (int)$_GET['seriesId'];
                $query = sprintf("select * from [|PREFIX|]brand_series where seriesid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($seriesId));
                $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);

                if($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
                    $GLOBALS['SeriesId'] = $row['seriesid'];
                    $_SESSION['congoseries'] = '';
                    $_SESSION['congobrand'] = '';
                    $_SESSION['congoseries'] = $row['brandid'];
                    $GLOBALS['BrandName'] = $this->BrandName($row['brandid']);
                    $GLOBALS['SeriesName'] = isc_html_escape($row['seriesname']);
                    $GLOBALS['Contents'] = isc_html_escape($row['seriescontent']);
                    $GLOBALS['FeaturePoints1'] = isc_html_escape($row['feature_points1']);
                    $GLOBALS['FeaturePoints2'] = isc_html_escape($row['feature_points2']);
                    $GLOBALS['FeaturePoints3'] = isc_html_escape($row['feature_points3']);
                    $GLOBALS['FeaturePoints4'] = isc_html_escape($row['feature_points4']);
                    $GLOBALS['Seriesaltkeyword'] = isc_html_escape($row['seriesaltkeyword']);

					//blessen
					$GLOBALS['seriespagetitle'] = isc_html_escape($row['seriespagetitle']);
					$GLOBALS['seriesmetakeywords'] = isc_html_escape($row['seriesmetakeywords']);
					$GLOBALS['seriesmetadesc'] = isc_html_escape($row['seriesmetadesc']);
					$GLOBALS['SeriesImageAlt'] = isc_html_escape($row['seriesimagealt']);


                    $GLOBALS['SeriesTitle'] = GetLang('EditSeries');
                    $GLOBALS['SeriesIntro'] = GetLang('EditSeriesIntro');
                    $GLOBALS['CancelMessage'] = GetLang('CancelEditSeries');
                    $GLOBALS['FormAction'] = "SaveEditedBrandSeries";
                    $GLOBALS['SeriesImageMessage'] = '';
                    if ($row['seriesphoto'] != '') {
                        $image = '../' . 'series_images' . '/' . $row['seriesphoto'];
                        $GLOBALS['SeriesImageMessage'] = sprintf(GetLang('SeriesImageDesc'), $image, $row['seriesphoto']);
                    }
                    $GLOBALS['SeriesLargeImageMessage'] = '';
                    if ($row['serieshoverimagefile'] != '') {
                        $limage = '../' . 'series_images' . '/' . $row['serieshoverimagefile'];
                        $GLOBALS['SeriesLargeImageMessage'] = sprintf(GetLang('SeriesLargeImageDesc'), $limage, $row['serieshoverimagefile']);
                    }

                     $wysiwygOptions = array(
                    'id'        => 'wysiwyg',
                    'width'        => '60%',
                    'height'    => '350px',
                    'value'        => $row['proddesc']
                    );
                    $wysiwygOptions1 = array(
                    'id'        => 'wysiwyg1',
                    'width'        => '60%',
                    'height'    => '350px',
                    'value'        => $row['seriesdescription']
                    );
                     $wysiwygOptions2 = array(
                    'id'        => 'wysiwyg2',
                    'width'        => '60%',
                    'height'    => '350px',
                    'value'        => $row['seriesfooter']
                    );
					 $wysiwygOptions3 = array(
                    'id'        => 'wysiwyg3',
                    'width'        => '60%',
                    'height'    => '350px',
                    'value'        => $row['feature_points']
                    );
					 $wysiwygOptions4 = array(
                    'id'        => 'wysiwyg4',
                    'width'        => '60%',
                    'height'    => '350px',
                    'value'        => $row['divdesc']
                    );

                $GLOBALS['WYSIWYG'] =  GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor1($wysiwygOptions);
                $GLOBALS['WYSIWYG1'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor1($wysiwygOptions1);
                $GLOBALS['WYSIWYG2'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor1($wysiwygOptions2);
                $GLOBALS['WYSIWYG3'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor($wysiwygOptions3);
                $GLOBALS['WYSIWYG4'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor1($wysiwygOptions4);
                
                $GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("series.edit.form");
                $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
                }
                else {
                    ob_end_clean();
                    header("Location: index.php?ToDo=viewBrands");
                    die();
                }
            }
            else {
                ob_end_clean();
                header("Location: index.php?ToDo=viewBrands");
                die();
            }
        }
        
        public function SaveEditedSeries()
        {
        # Used to clear the HTML Editor image upload folder name Baskaran
            $_SESSION['congobrand'] = '';
            $_SESSION['congoseries'] = '';

            if(isset($_POST['seriesName'])) {
                
                 $proddesc = ''; 
                if(isset($_POST["wysiwyg_html"])) {
                    $proddesc = $this->FormatWYSIWYGHTML(trim($_POST["wysiwyg_html"]));
                }
                else {
                    $proddesc = $this->FormatWYSIWYGHTML(trim($_POST['wysiwyg']));
                }
                $WYSIWYG1 = $this->FormatWYSIWYGHTML($_POST['wysiwyg1']);
                $WYSIWYG2 = $this->FormatWYSIWYGHTML($_POST['wysiwyg2']);

				$feature_points = $this->FormatWYSIWYGHTML($_POST['wysiwyg3']);
				$div_desc = $this->FormatWYSIWYGHTML($_POST['wysiwyg4']);
                                
//                $brandid = $_POST['vendor']; Commented because, the breand is already disable in tpl, so we cant get the id and we dont want to update here -- Baskaran
                                                   
                $seriesId = (int)$_POST['seriesId']; 
                $bquery = sprintf("SELECT brandid FROM [|PREFIX|]brand_series where seriesid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($seriesId));
                $bresult = $GLOBALS["ISC_CLASS_DB"]->Query($bquery);
                $brandId = $GLOBALS["ISC_CLASS_DB"]->FetchOne($bresult);
                
                $seriesname = trim($_POST['seriesName']);  
                $content = trim($_POST['contents']);

				/*$featurepoints1 = trim($_POST['featurepoints1']);
                $featurepoints2 = trim($_POST['featurepoints2']);
                $featurepoints3 = trim($_POST['featurepoints3']);
                $featurepoints4 = trim($_POST['featurepoints4']);*/
                $seriesaltkeyword = trim($_POST['seriesaltkeyword']);
               
               /* if($_POST['hidvalue'] == 1) {
                    $GLOBALS['ISC_CLASS_DB']->UpdateQuery("brand_series", $updateDesc, "seriesid='".$GLOBALS['ISC_CLASS_DB']->Quote($seriesId)."'"); 
                    $GLOBALS['ISC_CLASS_DB']->UpdateQuery("products", $updateDesc, "brandseriesid='".$GLOBALS['ISC_CLASS_DB']->Quote($seriesId)."'");
                    if($GLOBALS["ISC_CLASS_DB"]->GetErrorMsg() == "") { 
                        $_GET['seriesId'] = $seriesId;
                        $this->EditSeries(GetLang('ProductDescUpdatedSuccessfully'), MSG_SUCCESS); 
                    }
                    else {
                        $this->manageBrands(GetLang('ProductDescUpdatedError'), MSG_ERROR); 
                    }
                }
                else {     
						-- Removed the below variables from the array $updatedSeries --
						"feature_points1" => $featurepoints1,
                        "feature_points2" => $featurepoints2,
                        "feature_points3" => $featurepoints3,
                        "feature_points4" => $featurepoints4,     
				*/

					$seriespagetitle = isc_html_escape($_POST['seriespagetitle']);
					$seriesmetakeywords = isc_html_escape($_POST['seriesmetakeywords']);
					$seriesmetadesc = isc_html_escape($_POST['seriesmetadesc']);
					$seriesimagecaption = isc_html_escape($_POST['seriesimagealt']);


                    $updatedSeries = array(
                        "seriesname" => $seriesname,
                        "seriescontent" => $content,
                        "proddesc" => $proddesc,
                        "seriesaltkeyword" => $seriesaltkeyword,
                        "seriesdescription" => $WYSIWYG1,
                        "seriesfooter" => $WYSIWYG2,
                        "feature_points" => $feature_points,
                        "divdesc" => $div_desc,
						 "seriespagetitle" => $seriespagetitle,
                        "seriesmetakeywords" => $seriesmetakeywords,
                        "seriesmetadesc" => $seriesmetadesc,
						"seriesimagealt" => $seriesimagecaption
                    );

					
                    $query = "select * from [|PREFIX|]brand_series where seriesname = '".$seriesname."' and seriesid != '$seriesId'";  // and brandid='$brandId' added by Simha
                    $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
                    $cnt = $GLOBALS["ISC_CLASS_DB"]->CountResult($result);  
                    if($cnt != 0) {    
                        $_GET['seriesId'] = $seriesId;
                        $this->EditSeries(sprintf(GetLang('SeriesAlreadyAdded'), $seriesname), MSG_ERROR);
                    }
                    else if (!$GLOBALS['ISC_CLASS_ADMIN_CATEGORY']->CategoryDuplicationExists($seriesname) && !$GLOBALS['ISC_CLASS_ADMIN_CATEGORY']->BrandDuplicationExists($seriesname)) {   
                        $GLOBALS['ISC_CLASS_DB']->UpdateQuery("brand_series", $updatedSeries, "seriesid='".$GLOBALS['ISC_CLASS_DB']->Quote($seriesId)."'");
                        if($GLOBALS["ISC_CLASS_DB"]->GetErrorMsg() == "") {

                            if (array_key_exists('delseriesimagefile', $_POST) && $_POST['delseriesimagefile']) {
                                $this->DelSeriesImage($seriesId);
                                $GLOBALS['ISC_CLASS_DB']->UpdateQuery('brand_series', array('seriesphoto' => ''), "seriesid='" . (int)$seriesId . "'");
                            } else if (array_key_exists('seriesimagefile', $_FILES) && ($seriesimagefile = $this->_StoreFileAndReturnId('seriesimagefile'))) {
                                             
                                $seriesimagefile = $this->_AutoGenerateThumb($seriesimagefile);
                                $GLOBALS['ISC_CLASS_DB']->UpdateQuery('brand_series', array('seriesphoto' => $seriesimagefile), "seriesid='" . (int)$seriesId . "'");
                            }

							/* Large Image deletion */
							if (array_key_exists('delserieslargeimagefile', $_POST) && $_POST['delserieslargeimagefile']) {
                                $this->DelSeriesLargeImage($seriesId);
                                $GLOBALS['ISC_CLASS_DB']->UpdateQuery('brand_series', array('serieshoverimagefile' => ''), "seriesid='" . (int)$seriesId . "'");
                            } else if (array_key_exists('serieslargeimagefile', $_FILES) && ($serieslargeimagefile = $this->_StoreFileAndReturnId('serieslargeimagefile'))) {
                                
								$serieslargeimagefile = $this->_AutoGenerateThumbForLargeImage($serieslargeimagefile);
                                $GLOBALS['ISC_CLASS_DB']->UpdateQuery('brand_series', array('serieshoverimagefile' => $serieslargeimagefile), "seriesid='" . (int)$seriesId . "'");
                            }

                            if($_POST['keepedit'] == 'keepedit') {
                                $_GET['seriesId'] = $seriesId;
                                $this->EditSeries(GetLang('SeriesUpdatedSuccessfully'), MSG_SUCCESS);
                                exit;
                            }

                            $this->manageBrands(GetLang('SeriesUpdatedSuccessfully'), MSG_SUCCESS);
                        }
                        else {
                            $this->EditSeries(sprintf(GetLang('UpdateSeriesError'), $GLOBALS["ISC_CLASS_DB"]->GetErrorMsg()), MSG_ERROR);
                        }
                    }
                    else    {
                        $_GET['seriesId'] = $seriesId;
                        $this->EditSeries(sprintf(GetLang('NameAlreadyExists'), $seriesname), MSG_ERROR);
                    }
//                }
            }
            else {
                ob_end_clean();
                header("Location: index.php?ToDo=viewBrands");
                die();
            }
        }
        
        private function BrandName($selectedBrand) {
            $options = '<option value="0">'.GetLang('SelectBrand').'</option>';
            $query = "SELECT * from [|PREFIX|]brands ORDER BY brandname";
            $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
            while($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
                $sel = '';
                if($selectedBrand == $row['brandid']) {
                    $sel = 'selected="selected"';
                }
                $options .= '<option value='.(int)$row['brandid'].' '.$sel.'>'.$row['brandname'].'</option>';
            }
            return $options;
        }
        
         private function BrandNameId($id) {
            $query = "SELECT * from [|PREFIX|]brands where brandid = '$id'";
//            echo $query;exit;
            $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
            $row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result);
            $brandname = $row['brandname'];
            return $brandname;
        }
        
        public function _StoreFileAndReturnId($FileName)
        {
            // This function takes a file name as its arguement and stores
            // this file in the /downloads or /images directory depending
            // on the $FileType enumeration value

            $dir = "series_images";
            
            if (is_array($_FILES[$FileName]) && $_FILES[$FileName]['name'] != "") {
                // If it's an image, make sure it's a valid image type
                if (isc_strtolower(isc_substr($_FILES[$FileName]['type'], 0, 5)) != "image") {
                    return "";
                }

                if (is_dir(sprintf("../%s", $dir))) {               
                                           
                    // Clean up the incoming file name a bit
                    $_FILES[$FileName]['name'] = preg_replace("#[^\w.]#i", "_", $_FILES[$FileName]['name']);
                    $_FILES[$FileName]['name'] = preg_replace("#_{1,}#i", "_", $_FILES[$FileName]['name']);

                    $randomFileName = GenRandFileName($_FILES[$FileName]['name']);
                    $fileName = $randomFileName;
                    $dest = realpath(ISC_BASE_PATH."/" . $dir);
                    while(file_exists($dest."/".$fileName)) {
                        $fileName = basename($randomFileName);
                        $fileName = substr_replace($randomFileName, "-".rand(0, 10000000000), strrpos($randomFileName, "."), 0);
                        $fileName = $randomDir . "/" . $fileName;
                    }
                    $dest .= "/".$fileName;

                    if(move_uploaded_file($_FILES[$FileName]["tmp_name"], $dest)) {
                        isc_chmod($dest, ISC_WRITEABLE_FILE_PERM);
                        // The file was moved successfully
                        return $fileName;
                    }
                    else {
                        // Couldn't move the file, maybe the directory isn't writable?
                        return "";
                    }
                } else {
                    // The directory doesn't exist
                    return "";
                }
            } else {
                // The file doesn't exist in the $_FILES array
                return "";
            }
        }
        
        private function DelSeriesImage($file)
        {
            if (isId($file)) {
                if (!($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($GLOBALS["ISC_CLASS_DB"]->Query("SELECT * FROM [|PREFIX|]brand_series WHERE seriesid='" . (int)$file . "'")))) {
                    return false;
                }

                if ($row['seriesphoto'] == '') {
                    return true;
                } else {
                    $file = $row['seriesphoto'];
                }
            }

            $file = realpath(ISC_BASE_PATH.'/' . 'series_images' . '/' . $file);

            if ($file == '') {
                return false;
            }

            if (file_exists($file)) {
                @unlink($file);
                clearstatcache();
            }

            return !file_exists($file);
        }

		private function DelSeriesLargeImage($file)
        {
            if (isId($file)) {
                if (!($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($GLOBALS["ISC_CLASS_DB"]->Query("SELECT * FROM [|PREFIX|]brand_series WHERE seriesid='" . (int)$file . "'")))) {
                    return false;
                }

                if ($row['serieshoverimagefile'] == '') {
                    return true;
                } else {
                    $file = $row['serieshoverimagefile'];
                }
            }

            $file = realpath(ISC_BASE_PATH.'/' . 'series_images' . '/' . $file);

            if ($file == '') {
                return false;
            }

            if (file_exists($file)) {
                @unlink($file);
                clearstatcache();
            }

            return !file_exists($file);
        }
        
        public function FormatWYSIWYGHTML($HTML)
        {

            if(GetConfig('UseWYSIWYG')) {
                return $HTML;
            }
            else {
                // We need to sanitise all the line feeds first to 'nl'
                $HTML = SanatiseStringToUnix($HTML);

                // Now we can use nl2br()
                $HTML = nl2br($HTML);

                // But we still need to strip out the new lines as nl2br doesn't really 'replace' the new lines, it just inserts <br />before it
                $HTML = str_replace("\n", "", $HTML);

                // Fix up new lines and block level elements.
                $HTML = preg_replace("#(</?(?:html|head|body|div|p|form|table|thead|tbody|tfoot|tr|td|th|ul|ol|li|div|p|blockquote|cite|hr)[^>]*>)\s*<br />#i", "$1", $HTML);
                $HTML = preg_replace("#(&nbsp;)+(</?(?:html|head|body|div|p|form|table|thead|tbody|tfoot|tr|td|th|ul|ol|li|div|p|blockquote|cite|hr)[^>]*>)#i", "$2", $HTML);
                return $HTML;
            }
        }
        
        /* Ends here */
		private function SaveBrandImage(&$LargeFile)
		{
			if (!array_key_exists('brandimagefile', $_FILES) || $_FILES['brandimagefile']['error'] !== 0 || strtolower(substr($_FILES['brandimagefile']['type'], 0, 6)) !== 'image/') {
				return false;
			}

			// Attempt to set the memory limit
			setImageFileMemLimit($_FILES['brandimagefile']['tmp_name']);

			// Generate the destination path
			$randomDir = strtolower(chr(rand(65, 90)));
			$destPath = realpath(ISC_BASE_PATH.'/'.GetConfig('ImageDirectory'));

			if (!is_dir($destPath . '/' . $randomDir)) {
				if (!@mkdir($destPath . '/' . $randomDir, 0777)) {
					$randomDir = '';
				}
			}

			$destFile = GenRandFileName($_FILES['brandimagefile']['name'], 'category');
            $originalFile = str_replace(".","_original.",$destFile);
            $orginalPath = $destPath . '/' . $randomDir . '/' . $originalFile;
            $LargeFile = $randomDir . '/' . $originalFile;
			$destPath = $destPath . '/' . $randomDir . '/' . $destFile;
			$returnPath = $randomDir . '/' . $destFile;

			$tmp = explode('.', $_FILES['brandimagefile']['name']);
			$ext = strtolower($tmp[count($tmp)-1]);
            
			if ($ext == 'jpg') {
				$srcImg = imagecreatefromjpeg($_FILES['brandimagefile']['tmp_name']);
			} else if($ext == 'gif') {
				$srcImg = imagecreatefromgif($_FILES['brandimagefile']['tmp_name']);
				if(!function_exists('imagegif')) {
					$gifHack = 1;
				}
			} else {
				$srcImg = imagecreatefrompng($_FILES['brandimagefile']['tmp_name']);
			}

			$srcWidth = imagesx($srcImg);
			$srcHeight = imagesy($srcImg);
			$widthLimit = GetConfig('BrandImageWidth');
			$heightLimit = GetConfig('BrandImageHeight');

			// If the image is small enough, simply move it and leave it as is
			if($srcWidth <= $widthLimit && $srcHeight <= $heightLimit) {
				imagedestroy($srcImg);
				move_uploaded_file($_FILES['brandimagefile']['tmp_name'], $destPath);
                copy($destPath,$orginalPath);
				return $returnPath;
			}

			// Otherwise, the image needs to be resized
			$attribs = getimagesize($_FILES['brandimagefile']['tmp_name']);
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
            /*
            imagecopyresampled($dstImg, $srcImg, 0, 0, 0, 0, $srcWidth, $srcHeight, $srcWidth, $srcHeight);
            //SSSS
            if ($ext == "jpg") {
                imagejpeg($dstImg, $orginalPath, 100);
            } else if($ext == "gif") {
                if(isset($gifHack) && $gifHack == true) {
                    $thumbFile = isc_substr($destPath, 0, -3)."jpg";
                    imagejpeg($dstImg, $orginalPath, 100);
                }
                else {
                    imagegif($dstImg, $orginalPath);
                }
            } else {
                imagepng($dstImg, $orginalPath);
            }            
            //EEEEE
            
            echo $orginalPath; 
            */
            copy($_FILES['brandimagefile']['tmp_name'], $orginalPath);
            
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
			@unlink($_FILES['brandimagefile']['tmp_name']);

			// Change the permissions on the thumbnail file
			isc_chmod($returnPath, ISC_WRITEABLE_FILE_PERM);
            
			return $returnPath;
		}

		private function DelBrandImage($file)
		{
			if (isId($file)) {
				if (!($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($GLOBALS["ISC_CLASS_DB"]->Query("SELECT * FROM [|PREFIX|]brands WHERE brandid='" . (int)$file . "'")))) {
					return false;
				}

				if ($row['brandimagefile'] == '') {
					return true;
				} else {
					$file = $row['brandimagefile'];
                    $largefile = $row['brandlargefile']; 
				}
			}

			$file = realpath(ISC_BASE_PATH.'/' . GetConfig('ImageDirectory') . '/' . $file);
            $largefile = realpath(ISC_BASE_PATH.'/' . GetConfig('ImageDirectory') . '/' . $largefile);  

			if ($file == '') {
				return false;
			}

			if (file_exists($file)) {
				@unlink($file);
                @unlink($largefile);
				clearstatcache();
			}

			return !file_exists($file);
		}
        
        public function _AutoGenerateThumb($ImageName)
        {
            // Takes the filename of an image already uploaded into the
            // image directory, generates a thumbnal from it, stores it
            // in the image directory and returns its name

            
            $imgFile = realpath(ISC_BASE_PATH."/" . "series_images");          
            $imgFile .= "/" . $ImageName;

            if ($ImageName == '' || !file_exists($imgFile)) {
                return false;
            }

            // A list of thumbnails too
            $tmp = explode(".", $imgFile);
            $ext = isc_strtolower($tmp[count($tmp)-1]);

            // If overriding the existing image, set the output filename to the input filename
            //Large and medium size images by Simha
            
            $thumbFileName = $ImageName;   

            $attribs = @getimagesize($imgFile);
            $width = $attribs[0];
            $height = $attribs[1];

            if(!is_array($attribs)) {
                return false;
            }

            // Check if we have enough available memory to create this image - if we don't, attempt to bump it up
            setImageFileMemLimit($imgFile);
            
            $thumbFile = realpath(ISC_BASE_PATH."/" . "series_images"); 
                
            $thumbFile .= "/" . $thumbFileName;

            if ($ext == "jpg") {
                $srcImg = @imagecreatefromjpeg($imgFile);
            } else if($ext == "gif") {
                $srcImg = @imagecreatefromgif($imgFile);
                if(!function_exists("imagegif")) {
                    $gifHack = 1;
                }
            } else {
                $srcImg = @imagecreatefrompng($imgFile);
            }

            if(!$srcImg) {
                return false;
            }

            $srcWidth = @imagesx($srcImg);
            $srcHeight = @imagesy($srcImg);
            
            //Large and medium size images by Simha
            
            $AutoThumbSize = 120; 

            // This thumbnail is smaller than the Interspire Shopping Cart dimensions, simply copy the image and return
            if($srcWidth <= $AutoThumbSize && $srcHeight <= $AutoThumbSize) {
                @imagedestroy($srcImg);
                if($OverrideExisting == false) {
                    @copy($imgFile, $thumbFile);
                }
                return $thumbFileName;
            }

            // Make sure the thumb has a constant height
            $thumbWidth = $width;
            $thumbHeight = $height;

            if($width > $AutoThumbSize) {
                $thumbWidth = $AutoThumbSize;
                $thumbHeight = ceil(($height*(($AutoThumbSize*100)/$width))/100);
                $height = $thumbHeight;
                $width = $thumbWidth;
            }

            if($height > $AutoThumbSize) {
                $thumbHeight = $AutoThumbSize;
                $thumbWidth = ceil(($width*(($AutoThumbSize*100)/$height))/100);
            }

            $thumbImage = @imagecreatetruecolor($thumbWidth, $thumbHeight);
            if($ext == "gif" && !isset($gifHack)) {
                $colorTransparent = @imagecolortransparent($srcImg);
                @imagepalettecopy($srcImg, $thumbImage);
                @imagecolortransparent($thumbImage, $colorTransparent);
                @imagetruecolortopalette($thumbImage, true, 256);
            }
            else if($ext == "png") {
                @ImageColorTransparent($thumbImage, @ImageColorAllocate($thumbImage, 0, 0, 0));
                @ImageAlphaBlending($thumbImage, false);
            }

            @imagecopyresampled($thumbImage, $srcImg, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $srcWidth, $srcHeight);

            if ($ext == "jpg") {
                @imagejpeg($thumbImage, $thumbFile, 100);
            } else if($ext == "gif") {
                if(isset($gifHack) && $gifHack == true) {
                    $thumbFile = isc_substr($thumbFile, 0, -3)."jpg";
                    @imagejpeg($thumbImage, $thumbFile, 100);
                }
                else {
                    @imagegif($thumbImage, $thumbFile);
                }
            } else {
                @imagepng($thumbImage, $thumbFile);
            }

            @imagedestroy($thumbImage);
            @imagedestroy($srcImg);

            // Change the permissions on the thumbnail file
            isc_chmod($thumbFile, ISC_WRITEABLE_FILE_PERM);

            return $thumbFileName;
        }

		public function _AutoGenerateThumbForLargeImage($ImageName)
        {
            // Takes the filename of an image already uploaded into the
            // image directory, generates a thumbnal from it, stores it
            // in the image directory and returns its name

            
            $imgFile = realpath(ISC_BASE_PATH."/" . "series_images");          
            $imgFile .= "/" . $ImageName;

            if ($ImageName == '' || !file_exists($imgFile)) {
                return false;
            }

            // A list of thumbnails too
            $tmp = explode(".", $imgFile);
            $ext = isc_strtolower($tmp[count($tmp)-1]);

            // If overriding the existing image, set the output filename to the input filename
            //Large and medium size images by Simha
            
            $thumbFileName = $ImageName;   

            $attribs = @getimagesize($imgFile);
            $width = $attribs[0];
            $height = $attribs[1];

            if(!is_array($attribs)) {
                return false;
            }

            // Check if we have enough available memory to create this image - if we don't, attempt to bump it up
            setImageFileMemLimit($imgFile);
            
            $thumbFile = realpath(ISC_BASE_PATH."/" . "series_images"); 
                
            $thumbFile .= "/" . $thumbFileName;

            if ($ext == "jpg") {
                $srcImg = @imagecreatefromjpeg($imgFile);
            } else if($ext == "gif") {
                $srcImg = @imagecreatefromgif($imgFile);
                if(!function_exists("imagegif")) {
                    $gifHack = 1;
                }
            } else {
                $srcImg = @imagecreatefrompng($imgFile);
            }

            if(!$srcImg) {
                return false;
            }

            $srcWidth = @imagesx($srcImg);
            $srcHeight = @imagesy($srcImg);
            
            //Large and medium size images by Simha
            
            $AutoThumbSize = 240; 

            // This thumbnail is smaller than the Interspire Shopping Cart dimensions, simply copy the image and return
            if($srcWidth <= $AutoThumbSize && $srcHeight <= $AutoThumbSize) {
                @imagedestroy($srcImg);
                if($OverrideExisting == false) {
                    @copy($imgFile, $thumbFile);
                }
                return $thumbFileName;
            }

            // Make sure the thumb has a constant height
            $thumbWidth = $width;
            $thumbHeight = $height;

            if($width > $AutoThumbSize) {
                $thumbWidth = $AutoThumbSize;
                $thumbHeight = ceil(($height*(($AutoThumbSize*100)/$width))/100);
                $height = $thumbHeight;
                $width = $thumbWidth;
            }

            if($height > $AutoThumbSize) {
                $thumbHeight = $AutoThumbSize;
                $thumbWidth = ceil(($width*(($AutoThumbSize*100)/$height))/100);
            }

            $thumbImage = @imagecreatetruecolor($thumbWidth, $thumbHeight);
            if($ext == "gif" && !isset($gifHack)) {
                $colorTransparent = @imagecolortransparent($srcImg);
                @imagepalettecopy($srcImg, $thumbImage);
                @imagecolortransparent($thumbImage, $colorTransparent);
                @imagetruecolortopalette($thumbImage, true, 256);
            }
            else if($ext == "png") {
                @ImageColorTransparent($thumbImage, @ImageColorAllocate($thumbImage, 0, 0, 0));
                @ImageAlphaBlending($thumbImage, false);
            }

            @imagecopyresampled($thumbImage, $srcImg, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $srcWidth, $srcHeight);

            if ($ext == "jpg") {
                @imagejpeg($thumbImage, $thumbFile, 100);
            } else if($ext == "gif") {
                if(isset($gifHack) && $gifHack == true) {
                    $thumbFile = isc_substr($thumbFile, 0, -3)."jpg";
                    @imagejpeg($thumbImage, $thumbFile, 100);
                }
                else {
                    @imagegif($thumbImage, $thumbFile);
                }
            } else {
                @imagepng($thumbImage, $thumbFile);
            }

            @imagedestroy($thumbImage);
            @imagedestroy($srcImg);

            // Change the permissions on the thumbnail file
            isc_chmod($thumbFile, ISC_WRITEABLE_FILE_PERM);

            return $thumbFileName;
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
        public function GetSeriesOptions($SelectedSeries = 0, $Container = "<option %s value='%d'>%s</option>", $Sel = "selected=\"selected\"", $Divider = "- ", $IncludeEmpty = true, $Brands=array())
        {
            // Get a list of categories as <option> tags
            $series = '';

            // Make sure $SelectedCats is an array
            if (!is_array($SelectedSeries)) {
                $SelectedSeries = array();
            }

            if (empty($SelectedSeries) || in_array("0", $SelectedSeries)) {
                $sel = 'selected="selected"';
            } else {
                $sel = "";
            }
            
            $squery = "SELECT * FROM [|PREFIX|]brand_series WHERE brandid!='0' ";
            if(count($Brands)>0)    {
                $brandids = implode(',', $Brands);
                $squery   .= " AND brandid IN ($brandids)";
            }
            $squery .= "ORDER BY seriesname ASC";
            $sresult = $GLOBALS["ISC_CLASS_DB"]->Query($squery);
            
            while($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($sresult)) { 
                $sid    = $row['seriesid'];    
                $sname  = $row['seriesname'];    
                if (in_array($sid, $SelectedSeries)) {
                    $s = $Sel;
                } else {
                    $s = '';
                }                    
                $series .= sprintf($Container, $s, $sid, $sname);   
            }

            return $series;
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
        public function GetBrandOptions($SelectedBrands = 0, $Container = "<option %s value='%d'>%s</option>", $Sel = "selected=\"selected\"", $Divider = "- ", $IncludeEmpty = true, $visible='', $visibleBrands=array())
        {
            // Get a list of categories as <option> tags
            $brands = '';

            // Make sure $SelectedCats is an array
            if (!is_array($SelectedBrands)) {
                $SelectedBrands = array();
            }

            if (empty($SelectedBrands) || in_array("0", $SelectedBrands)) {
                $sel = 'selected="selected"';
            } else {
                $sel = "";
            }
            
            $squery = "SELECT brandid, brandname FROM [|PREFIX|]brands ORDER BY brandname asc";        
            $sresult = $GLOBALS["ISC_CLASS_DB"]->Query($squery);
            
            while($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($sresult)) { 
                $sid    = $row['brandid'];    
                $sname  = $row['brandname'];    
                if (in_array($sid, $SelectedBrands)) {
                    $s = $Sel;
                } else {
                    $s = '';
                }                    
                $brands .= sprintf($Container, $s, $sid, $sname);   
            }

            return $brands;
        }

        
	}

?>
