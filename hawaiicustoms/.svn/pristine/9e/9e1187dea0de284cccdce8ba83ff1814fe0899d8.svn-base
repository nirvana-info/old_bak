<?php
    
	class ISC_ADMIN_CHANGES_REPORT
	{
		public function HandleToDo($Do)
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('changes.report');
            
            define("ISC_REPORTS_PER_PAGE", 20);
	
            if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Changes_Reports)) {
                $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('ChangesReports') => "index.php?ToDo=viewChangesReports");

                if(!isset($_REQUEST['ajax'])) {
                    $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                }

                $this->ManageChangesReports();

                if(!isset($_REQUEST['ajax'])) {
                    $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                }
            } 
            else {
                $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
            }

		}

		public function _GetChangesReportList(&$Query, $Start, $SortField, $SortOrder, &$NumResults)
		{
			// Return an array containing details about changes.report.
			// Takes into account search too.

			// PostgreSQL is case sensitive for likes, so all matches are done in lower case
			$Query = trim(isc_strtolower($Query));

            if(isset($_GET['days']) && $_GET['days'] != '')   { 
                $days = (int)$_GET['days'];
            }
            else    {
                $days = 15;  
            }
            
			$query = "
				SELECT *, 
                (SELECT COUNT(productid) 
                FROM [|PREFIX|]products p 
                WHERE p.prodbrandid=b.brandid) AS totalproducts,
                (SELECT COUNT(productid) 
                FROM [|PREFIX|]products p 
                WHERE p.prodbrandid=b.brandid AND proddateadded  >= UNIX_TIMESTAMP(DATE_SUB(CURDATE(), INTERVAL $days DAY))) AS newproducts,
                (SELECT COUNT(DISTINCT p.productid)  
                FROM [|PREFIX|]changes_report cr 
                INNER JOIN [|PREFIX|]products p ON cr.changeprodid = p.productid 
                WHERE p.prodbrandid=b.brandid AND cr.changetype='content' AND changedtime > DATE_SUB(NOW(), INTERVAL $days DAY)) AS contentcount,
                (SELECT COUNT(DISTINCT p.productid)  
                FROM [|PREFIX|]changes_report cr 
                INNER JOIN [|PREFIX|]products p ON cr.changeprodid = p.productid 
                WHERE p.prodbrandid=b.brandid AND cr.changetype='application' AND changedtime > DATE_SUB(NOW(), INTERVAL $days DAY)) AS applicationcount,
                (SELECT COUNT(DISTINCT p.productid)  
                FROM [|PREFIX|]changes_report cr 
                INNER JOIN [|PREFIX|]products p ON cr.changeprodid = p.productid 
                WHERE p.prodbrandid=b.brandid AND cr.changetype='price' AND changedtime > DATE_SUB(NOW(), INTERVAL $days DAY)) AS pricecount                  
				FROM [|PREFIX|]brands b
                
			";                                 //proddateadded

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
				$query .= " ORDER BY ".$SortField." ".$SortOrder;

				// Add the limit
				$query .= $GLOBALS["ISC_CLASS_DB"]->AddLimit($Start, ISC_REPORTS_PER_PAGE);
				$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
				return $result;
			}
			else {
				return false;
			}
		}

		public function ManageChangesReportsGrid(&$numChangesReports)
		{
			// Show a list of news in a table
			$page = 0;
			$start = 0;
			$numChangesReports = 0;
			$numPages = 0;
			$GLOBALS['ChangesReportGrid'] = "";
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
				"Brands" => "b.brandname",
				"Products" => "products",
			);

			if (isset($_GET['sortField']) && in_array($_GET['sortField'], $sortLinks)) {
				$sortField = $_GET['sortField'];
				SaveDefaultSortField("ManageChangesReports", $_REQUEST['sortField'], $sortOrder);
			}
			else {
				list($sortField, $sortOrder) = GetDefaultSortField("ManageChangesReports", "b.brandname", $sortOrder);
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
				$start = 1;
			}
			else {
				$start = ($page * ISC_REPORTS_PER_PAGE) - (ISC_REPORTS_PER_PAGE-1);
			}

			$start = $start-1;

			// Get the results for the query
			$brandResult = $this->_GetChangesReportList($query, $start, $sortField, $sortOrder, $numChangesReports);
			$numPages = ceil($numChangesReports / ISC_REPORTS_PER_PAGE);
            
            if(isset($_GET['days']) && $_GET['days'] != '')   { 
                $days = (int)$_GET['days'];
            }
            else    {
                $days = 15;  
            }
            
			// Workout the paging navigation
			if($numChangesReports > ISC_REPORTS_PER_PAGE) {
				$GLOBALS['Nav'] = sprintf("(%s %d of %d) &nbsp;&nbsp;&nbsp;", GetLang('Page'), $page, $numPages);

				$GLOBALS['Nav'] .= BuildPagination($numChangesReports, ISC_REPORTS_PER_PAGE, $page, sprintf("index.php?ToDo=viewChangesReports%s", $sortURL."&days=".$days));
			}
			else {
				$GLOBALS['Nav'] = "";
			}

			$GLOBALS['SearchQuery'] = $query;
			$GLOBALS['SortField'] = $sortField;
			$GLOBALS['SortOrder'] = $sortOrder;

			BuildAdminSortingLinks($sortLinks, "index.php?ToDo=viewChangesReports&amp;".$searchURL."&amp;page=".$page, $sortField, $sortOrder);


			// Workout the maximum size of the array
			$max = $start + ISC_REPORTS_PER_PAGE;

			if ($max > count($brandResult)) {
				$max = count($brandResult);
			}
            
			if($numChangesReports > 0) {
				// Display the news
				while ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($brandResult)) {
					$GLOBALS['BrandId'] = (int) $row['brandid'];
					$GLOBALS['BrandName'] = isc_html_escape($row['brandname']);
					$GLOBALS['TotalProducts'] = (int) $row['totalproducts'];   
                    $GLOBALS['NewProducts'] = (int) $row['newproducts']; 
                    $GLOBALS['ContentModified'] = (int) $row['contentcount'];   
                    $GLOBALS['ApplicationModified'] = (int) $row['applicationcount'];   
                    $GLOBALS['PriceModified'] = (int) $row['pricecount'];   
					$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("changes.report.manage.row");
					$GLOBALS['ChangesReportGrid'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
				}
				$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("changes.report.manage.grid");
				return $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
			}
		}

		public function ManageChangesReports($MsgDesc = "", $MsgStatus = "")
		{
			// Fetch any results, place them in the data grid
			$numChangesReports = 0;
			$GLOBALS['ChangesReportDataGrid'] = $this->ManageChangesReportsGrid($numChangesReports);

			// Was this an ajax based sort? Return the table now
			if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 1) {
				echo $GLOBALS['ChangesReportDataGrid'];
				return;
			}

			if ($MsgDesc != "") {
				$GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
			}
            
			$GLOBALS['ChangesReportIntro'] = GetLang('ManageChangesReportsIntro');
            
			// No results
			if($numChangesReports == 0) {
				$GLOBALS['DisplayGrid'] = "none";
				if(count($_GET) > 1) {
					if ($MsgDesc == "") {
						$GLOBALS['Message'] = MessageBox(GetLang('NoChangesReportResults'), MSG_ERROR);
					}
				}
				else {
					$GLOBALS['DisplaySearch'] = "none";
					$GLOBALS['Message'] = MessageBox(GetLang('NoChangesReports'), MSG_SUCCESS);
				}
			}
            
            $GLOBALS["PageAdminLink"]     = GetConfig('ShopPath');
			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("changes.report.manage");
			$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
		}
        
	}

?>
