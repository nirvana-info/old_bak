<?php
class ISC_ADMIN_STATISTICS_PRODUCTS extends ISC_ADMIN_STATISTICS
{
	/**
	*	Show statistics for products
	*/
	public function ProductStats()
	{

		if(isset($_POST['Calendar'])) {
			$cal = $this->CalculateCalendarRestrictions($_POST['Calendar']);
			$GLOBALS['CurrentDate'] = $_POST['Calendar']['DateType'];
		}
		else {
			$cal = $this->CalculateCalendarRestrictions();
			$GLOBALS['CurrentDate'] = "Last30Days";
		}

		$GLOBALS['CalendarDateTypeOptions'] = $this->_GetCalendarDateTypesAsOptions($GLOBALS['CurrentDate']);

		if(isset($_POST['currentTab'])) {
			$GLOBALS['CurrentTab'] = (int)$_POST['currentTab'];
		}
		else {
			$GLOBALS['CurrentTab'] = 0;
		}

		// Set the global variables for the select boxes
		$from_stamp = $cal['start'];
		$to_stamp = $cal['end'];

		$from_day = isc_date("d", $from_stamp);
		$from_month = isc_date("m", $from_stamp);
		$from_year = isc_date("Y", $from_stamp);

		$to_day = isc_date("d", $to_stamp);
		$to_month = isc_date("m", $to_stamp);
		$to_year = isc_date("Y", $to_stamp);

		$GLOBALS['OverviewFromDays'] = $this->_GetDayOptions($from_day);
		$GLOBALS['OverviewFromMonths'] = $this->_GetMonthOptions($from_month);
		$GLOBALS['OverviewFromYears'] = $this->_GetYearOptions($from_year);

		$GLOBALS['OverviewToDays'] = $this->_GetDayOptions($to_day);
		$GLOBALS['OverviewToMonths'] = $this->_GetMonthOptions($to_month);
		$GLOBALS['OverviewToYears'] = $this->_GetYearOptions($to_year);

		$GLOBALS['FromStamp'] = $from_stamp;
		$GLOBALS['ToStamp'] = $to_stamp;

		$vendorRestriction = $this->GetVendorRestriction();
		if($vendorRestriction !== false) {
			$GLOBALS['VendorId'] = (int)$vendorRestriction;
		}
		else {
			$GLOBALS['VendorId'] = '';
		}

		// If we can, get a list of the available vendors
		$GLOBALS['HideVendorList'] = 'display: none';
		if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() == 0 && gzte11(ISC_HUGEPRINT)) {
			$GLOBALS['VendorSelect'] = '';
			// All vendors option
			$sel = '';
			if (!isset($_REQUEST['vendorId']) || $_REQUEST['vendorId'] == "") {
				$sel = 'selected="selected"';
			}
			$GLOBALS['VendorSelect'] .= "<option value='' ".$sel.">".GetLang('AllVendors')."</option>";

			// No vendor option
			$sel = '';
			if(isset($_REQUEST['vendorId']) && $_REQUEST['vendorId'] == "0") {
				$sel = 'selected="selected"';
			}
			$GLOBALS['VendorSelect'] .= "<option value='0' ".$sel.">".GetLang('NoSelVendor')."</option>";
			$query = "
				SELECT vendorid, vendorname
				FROM [|PREFIX|]vendors
				ORDER BY vendorname ASC
			";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$hasVendors = false;
			while($vendor = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$hasVendors = true;
				$sel = '';
				if(isset($_REQUEST['vendorId']) && $_REQUEST['vendorId'] == $vendor['vendorid']) {
					$sel = 'selected="selected"';
				}
				$GLOBALS['VendorSelect'] .= "<option value='".$vendor['vendorid']."' ".$sel.">".isc_html_escape($vendor['vendorname'])."</option>";
			}
			if($hasVendors) {
				$GLOBALS['HideVendorList'] = '';
			}
		}

		/**
		 * Hide the inventory screen if we are starter
		 */
		if (!gzte11(ISC_MEDIUMPRINT)) {
			$GLOBALS['HideInventoryTab'] = 'none';
			$GLOBALS['ShowInventoryGrid'] = '0';
		} else {
			$GLOBALS['HideInventoryTab'] = '';
			$GLOBALS['ShowInventoryGrid'] = '1';
		}

		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("stats.products");
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
	}

	public function ProductStatsByNumSoldGrid()
	{

		$GLOBALS['OrderGrid'] = "";

		if(isset($_GET['From']) && isset($_GET['To'])) {

			$from_stamp = (int)$_GET['From'];
			$to_stamp = (int)$_GET['To'];

			// How many records per page?
			if(isset($_GET['Show'])) {
				$per_page = (int)$_GET['Show'];
			}
			else {
				$per_page = 20;
			}

			$GLOBALS['ProductsPerPage'] = $per_page;
			$GLOBALS["IsShowPerPage" . $per_page] = 'selected="selected"';

			// Should we limit the records returned?
			if(isset($_GET['Page'])) {
				$page = (int)$_GET['Page'];
			}
			else {
				$page = 1;
			}

			$GLOBALS['ProductsByNumSoldCurrentPage'] = $page;

			// Workout the start and end records
			$start = ($per_page * $page) - $per_page;
			$end = $start + ($per_page - 1);

			// Only fetch products this user can actually see
			$vendorRestriction = $this->GetVendorRestriction();
			$vendorSql = '';
			if($vendorRestriction !== false) {
				$vendorSql = " AND prodvendorid='" . $GLOBALS['ISC_CLASS_DB']->Quote($vendorRestriction) . "'";
			}

			// How many products are there in total?

			$query = "
				SELECT
					COUNT(*) AS num
				FROM
					[|PREFIX|]order_products
					INNER JOIN [|PREFIX|]orders ON orderorderid = orderid
					LEFT JOIN [|PREFIX|]products ON ordprodid = productid
				WHERE
					ordstatus IN (".implode(',', GetPaidOrderStatusArray()).")
					AND ordprodtype != 'giftcertificate'
					AND ordprodid != 0
					AND orddate >= '" . $from_stamp . "'
					AND orddate <= '" . $to_stamp . "'" .
					$vendorSql;

			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
			$total_products = $row['num'];

			if ($total_products > 0) {
				// Workout the paging
				$num_pages = ceil($total_products / $per_page);
				$paging = sprintf(GetLang('PageXOfX'), $page, $num_pages);
				$paging .= "&nbsp;&nbsp;&nbsp;&nbsp;";

				// Is there more than one page? If so show the &laquo; to jump back to page 1
				if($num_pages > 1) {
					$paging .= "<a href='javascript:void(0)' onclick='ChangeProductsByNumSoldPage(1)'>&laquo;</a> | ";
				}
				else {
					$paging .= "&laquo; | ";
				}

				// Are we on page 2 or above?
				if($page > 1) {
					$paging .= sprintf("<a href='javascript:void(0)' onclick='ChangeProductsByNumSoldPage(%d)'>%s</a> | ", $page-1, GetLang('Prev'));
				}
				else {
					$paging .= sprintf("%s | ", GetLang('Prev'));
				}

				for($i = 1; $i <= $num_pages; $i++) {
					// Only output paging -5 and +5 pages from the page we're on
					if($i >= $page-6 && $i <= $page+5) {
						if($page == $i) {
							$paging .= sprintf("<strong>%d</strong> | ", $i);
						}
						else {
							$paging .= sprintf("<a href='javascript:void(0)' onclick='ChangeProductsByNumSoldPage(%d)'>%d</a> | ", $i, $i);
						}
					}
				}

				// Are we on page 2 or above?
				if($page < $num_pages) {
					$paging .= sprintf("<a href='javascript:void(0)' onclick='ChangeProductsByNumSoldPage(%d)'>%s</a> | ", $page+1, GetLang('Next'));
				}
				else {
					$paging .= sprintf("%s | ", GetLang('Next'));
				}

				// Is there more than one page? If so show the &raquo; to go to the last page
				if($num_pages > 1) {
					$paging .= sprintf("<a href='javascript:void(0)' onclick='ChangeProductsByNumSoldPage(%d)'>&raquo;</a> | ", $num_pages);
				}
				else {
					$paging .= "&raquo; | ";
				}

				$paging = rtrim($paging, ' |');
				$GLOBALS['Paging'] = $paging;

				// Should we set focus to the grid?
				if(isset($_GET['FromLink']) && $_GET['FromLink'] == "true") {
					$GLOBALS['JumpToOrdersByItemsSoldGrid'] = "<script type=\"text/javascript\">document.location.href='#ordersByItemsSoldAnchor';</script>";
				}

				if(isset($_GET['SortOrder']) && $_GET['SortOrder'] == "asc") {
					$sortOrder = 'asc';
				}
				else {
					$sortOrder = 'desc';
				}

				$sortFields = array('ordprodid','ordprodsku','ordprodname','revenue','numitemssold', 'totalprofit');
				if(isset($_GET['SortBy']) && in_array($_GET['SortBy'], $sortFields)) {
					$sortField = $_GET['SortBy'];
					SaveDefaultSortField("ProductStatsBySold", $_REQUEST['SortBy'], $sortOrder);
				}
				else {
					list($sortField, $sortOrder) = GetDefaultSortField("ProductStatsBySold", "numitemssold", $sortOrder);
				}

				$sortLinks = array(
					"ProductId" => "ordprodid",
					"Code" => "ordprodsku",
					"Name" => "ordprodname",
					"UnitsSold" => "numitemssold",
					"Revenue" => "revenue",
					"Profit" => "totalprofit"
				);
				BuildAdminSortingLinks($sortLinks, "javascript:SortProductsByNumSold('%%SORTFIELD%%', '%%SORTORDER%%');", $sortField, $sortOrder);

				// Fetch the orders for this page
				$query = "
					SELECT
						ordprodid,
						ordprodsku,
						ordprodname,
						SUM(ordprodcost * ordprodqty) AS revenue,
						SUM(ordprodqty) as numitemssold,
						IF(ordprodcostprice > '0', SUM((ordprodcost - ordprodcostprice) * ordprodqty), 0) AS totalprofit,
						productid
					FROM
						[|PREFIX|]order_products op
						INNER JOIN [|PREFIX|]orders o ON op.orderorderid = o.orderid
						LEFT JOIN [|PREFIX|]products p ON p.productid = op.ordprodid
					WHERE
						ordstatus IN (".implode(',', GetPaidOrderStatusArray()).")
						AND ordprodtype != 'giftcertificate'
						AND orddate >= '" . $from_stamp . "'
						AND orddate <= '" . $to_stamp . "'
						AND ordprodid != 0 " .
						$vendorSql . "
					GROUP BY
						ordprodid
					ORDER BY " .
						 $sortField . " " . $sortOrder;

				// Add the Limit
				$query .= $GLOBALS['ISC_CLASS_DB']->AddLimit($start, $per_page);
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

				if($GLOBALS['ISC_CLASS_DB']->CountResult($result) > 0) {
					while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {

						if($row['totalprofit'] > 0) {
							$total_profit = sprintf("%s", FormatPrice($row['totalprofit']));
						}
						else {
							$total_profit = GetLang('NA');
						}

						$sku = GetLang('NA');
						if($row['ordprodsku']) {
							$sku = isc_html_escape($row['ordprodsku']);
						}

						$prodlink = $row['ordprodname'];
						if (!is_null($row['productid'])) {
							$prodlink = "<a href='" . ProdLink($row['ordprodname']) . "' target='_blank'>" . isc_html_escape($row['ordprodname']) . "</a>";
						}

						$GLOBALS['OrderGrid'] .= sprintf("
							<tr class=\"GridRow\" onmouseover=\"this.className='GridRowOver';\" onmouseout=\"this.className='GridRow';\">
								<td nowrap height=\"22\" class=\"".$GLOBALS['SortedFieldProductIdClass']."\">
									%d
								</td>
								<td nowrap class=\"".$GLOBALS['SortedFieldCodeClass']."\">
									%s
								</td>
								<td nowrap class=\"".$GLOBALS['SortedFieldNameClass']."\">
									%s</a>
								</td>
								<td nowrap class=\"".$GLOBALS['SortedFieldUnitsSoldClass']."\">
									%s
								</td>
								<td nowrap class=\"".$GLOBALS['SortedFieldRevenueClass']."\">
									%s
								</td>
								<td nowrap class=\"".$GLOBALS['SortedFieldProfitClass']."\">
									%s
								</td>
							</tr>
						", $row['ordprodid'],
						  $sku,
						   $prodlink,
						   (int) $row['numitemssold'],
						   FormatPrice($row['revenue']),
						   $total_profit
						);
					}
				}
			}
			else {
				$GLOBALS['OrderGrid'] .= sprintf("
					<tr class=\"GridRow\" onmouseover=\"this.className='GridRowOver';\" onmouseout=\"this.className='GridRow';\">
						<td nowrap height=\"22\" colspan=\"7\">
							<em>%s</em>
						</td>
					</tr>
				", GetLang('StatsNoOrdersForDate')
				);
			}

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("stats.products.bynumsoldgrid");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}
	}

	/**
	*	Show how many times each product has been viewed
	*/
	public function ProductStatsByNumViewsGrid()
	{

		$GLOBALS['OrderGrid'] = "";

		// How many records per page?
		if(isset($_GET['Show'])) {
			$per_page = (int)$_GET['Show'];
		}
		else {
			$per_page = 20;
		}

		$GLOBALS['ProductsPerPage'] = $per_page;
		$GLOBALS["IsShowPerPage" . $per_page] = 'selected="selected"';

		// Should we limit the records returned?
		if(isset($_GET['Page'])) {
			$page = (int)$_GET['Page'];
		}
		else {
			$page = 1;
		}

		$GLOBALS['ProductsByNumViewsCurrentPage'] = $page;

		// Workout the start and end records
		$start = ($per_page * $page) - $per_page;
		$end = $start + ($per_page - 1);

		// Only fetch products this user can actually see
		$vendorRestriction = $this->GetVendorRestriction();
		$vendorSql = '';
		if($vendorRestriction !== false) {
			$vendorSql = " WHERE prodvendorid = '" . $GLOBALS['ISC_CLASS_DB']->Quote($vendorRestriction) . "'";
		}

		// How many products are there in total?
		$CountQuery = "
			SELECT
				COUNT(*) AS num
			FROM
				[|PREFIX|]products
			" . $vendorSql;

		$result = $GLOBALS['ISC_CLASS_DB']->Query($CountQuery);

		$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
		$total_products = $row['num'];

		//blessen
		if (isset($_REQUEST['export']) and  $total_products <= 0)
				{
				header("location:index.php?ToDo=viewProdStats#");
				exit;
				}

		if ($total_products > 0) {
            
            //Sorting code goes by Simha
            if(isset($_GET['SortOrder']) && $_GET['SortOrder'] == "asc") {
                $sortOrder = 'asc';
            }
            else {
                $sortOrder = 'desc';
            }
            
            /*
            switch($_GET['showby']) {
                case 'category':    {  
                }
                case 'subcategory':    {
                     $cursortfield = 'c.catname';
                     break;
                }
                case 'brand':    {
                     $cursortfield = 'b.brandname';
                     break;
                }
                case 'series':    {
                     $cursortfield = 'seriescomname';
                     break;
                }
                default:
                    $cursortfield = 'p.prodname';
                    break;
                
            }
            
            
            if($_GET['SortBy']=='c.catname' || $_GET['SortBy']=='b.brandname' || $_GET['SortBy']=='seriescomname' || $_GET['SortBy']=='p.prodname')    
            {
                $_GET['SortBy'] = $cursortfield;        
            }
            */                                           //changed field name and commented
            $sortFields = array('commonnamefield','numsold','prodnumviews','unitssoldpercent','avgrating');//changed field name
            if(isset($_GET['SortBy']) && in_array($_GET['SortBy'], $sortFields)) {
                $sortField = $_GET['SortBy'];
                SaveDefaultSortField("ProductStatsByViews", $_REQUEST['SortBy'], $sortOrder);
            }
            else {
                list($sortField, $sortOrder) = GetDefaultSortField("ProductStatsByViews", "prodnumviews", $sortOrder);
            }
            
            $sortLinks = array(        
                "Name" => "commonnamefield",
                "UnitsSold" => "numsold",
                "Views" => "prodnumviews",
                "UnitsSoldPercent" => "unitssoldpercent",
                "AverageRating" => "avgrating"
            );
            
            //Above comment and new addition belowby Simha 
            //$sortLinks = array();
            
            $numSoldCounter = '921124412848294';
            BuildAdminSortingLinks($sortLinks, "javascript:SortProductsByNumViews('%%SORTFIELD%%', '%%SORTORDER%%');", $sortField, $sortOrder);
            //Sorting code goes ends by Simha
            
            $this->GetQueries($countQuery, $mainQuery, $vendorSql, $sortField, $sortOrder, $NameField);
             
            // How many products are there in total?
            $result = $GLOBALS['ISC_CLASS_DB']->Query($countQuery);

            $row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
            $total_records = $row['num'];
            
            
		//blessen
		if (isset($_REQUEST['export']) )
			{
               

				$file_path = 'exporttemp.csv';
				
				$content =  "Item Id,Item,Views,Units Sold ,Units Sold/Views,Average Rating \n";
				$resultexp = $GLOBALS['ISC_CLASS_DB']->Query($mainQuery);
				while($rowex = $GLOBALS['ISC_CLASS_DB']->Fetch($resultexp))
				{

					$pname = str_replace(",", " ", $rowex['commonnamefield']);
					
					$content.=  $rowex['itemid'].",".$pname.",".$rowex['prodnumviews'].",".(float)$rowex['numsold'].",".(float)($rowex['unitssoldpercent']*100)."%,".(float)$rowex['avgrating']."\n";

				}

				if (!$handle = fopen($file_path, 'w')) {
									 
				}

				if (fwrite($handle, $content) === FALSE) {
										
				}
				fclose($handle);
				

				
				

				$nename = "export_".date("F_j_Y_g_i_a");                 

						// file size in bytes
						$fsize = filesize($file_path); 

						$fileContents = file_get_contents($file_path);

						header("Content-length:".$fsize);
						header("Content-type: text/csv");
						header("Content-Disposition: attachment; filename=".$nename.".csv");
						echo $fileContents;
					
									if (file_exists($file_path)) {
										@unlink($file_path);
										clearstatcache();
									}

						die();

			}



			// Workout the paging
			$num_pages = ceil($total_records / $per_page);
            
            // Should we limit the records returned?
            if(isset($_GET['Page']) && (int)$_GET['Page']<=$num_pages) {
                $page = (int)$_GET['Page'];
            }
            else {
                $page = 1;
            }

            // Workout the start and end records
            $start = ($per_page * $page) - $per_page;
            $end = $start + ($per_page - 1);

			$paging = sprintf(GetLang('PageXOfX'), $page, $num_pages);
			$paging .= "&nbsp;&nbsp;&nbsp;&nbsp;";

			// Is there more than one page? If so show the &laquo; to jump back to page 1
			if($num_pages > 1) {
				$paging .= "<a href='javascript:void(0)' onclick='ChangeProductsByNumViewsPage(1)'>&laquo;</a> | ";
			}
			else {
				$paging .= "&laquo; | ";
			}

			// Are we on page 2 or above?
			if($page > 1) {
				$paging .= sprintf("<a href='javascript:void(0)' onclick='ChangeProductsByNumViewsPage(%d)'>%s</a> | ", $page-1, GetLang('Prev'));
			}
			else {
				$paging .= sprintf("%s | ", GetLang('Prev'));
			}

			for($i = 1; $i <= $num_pages; $i++) {
				// Only output paging -5 and +5 pages from the page we're on
				if($i >= $page-6 && $i <= $page+5) {
					if($page == $i) {
						$paging .= sprintf("<strong>%d</strong> | ", $i);
					}
					else {
						$paging .= sprintf("<a href='javascript:void(0)' onclick='ChangeProductsByNumViewsPage(%d)'>%d</a> | ", $i, $i);
					}
				}
			}

			// Are we on page 2 or above?
			if($page < $num_pages) {
				$paging .= sprintf("<a href='javascript:void(0)' onclick='ChangeProductsByNumViewsPage(%d)'>%s</a> | ", $page+1, GetLang('Next'));
			}
			else {
				$paging .= sprintf("%s | ", GetLang('Next'));
			}

			// Is there more than one page? If so show the &raquo; to go to the last page
			if($num_pages > 1) {
				$paging .= sprintf("<a href='javascript:void(0)' onclick='ChangeProductsByNumViewsPage(%d)'>&raquo;</a> | ", $num_pages);
			}
			else {
				$paging .= "&raquo; | ";
			}

			$paging = rtrim($paging, ' |');
			$GLOBALS['Paging'] = $paging;

			// Should we set focus to the grid?
			if(isset($_GET['FromLink']) && $_GET['FromLink'] == "true") {
				$GLOBALS['JumpToOrdersByItemsSoldGrid'] = "<script type=\"text/javascript\">document.location.href='#ordersByItemsSoldAnchor';</script>";
			}
            //Sorting code moved to the topof this loop
            
            //Code here has been moved to the fucntion GetQueries 
            
			// Add the Limit
			$mainQuery .= $GLOBALS['ISC_CLASS_DB']->AddLimit($start, $per_page);      
			$result = $GLOBALS['ISC_CLASS_DB']->Query($mainQuery);

			if($GLOBALS['ISC_CLASS_DB']->CountResult($result) > 0) {
				while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					$code = GetLang('NA');
					if($row['prodcode'] != '') {
						$code = isc_html_escape($row['prodcode']);
					}
					if($_REQUEST['showby']=='' || $_REQUEST['showby']=='products')    {
                        $GLOBALS['OrderGrid'] .= sprintf("
						    <tr class=\"GridRow\" onmouseover=\"this.className='GridRowOver';\" onmouseout=\"this.className='GridRow';\">
							    
							    <td nowrap class=\"".$GLOBALS['SortedFieldNameClass']."\">
								    <a href='%s' target='_blank'>%s</a>
							    </td>
                                <td nowrap class=\"".$GLOBALS['SortedFieldUnitsSoldClass']."\">
                                    %s
                                </td>
							    <td nowrap class=\"".$GLOBALS['SortedFieldViewsClass']."\">
								    %s
							    </td>
                                <td nowrap>
                                    %s
                                </td>
							    <td nowrap class=\"".$GLOBALS['SortedFieldAverageRatingClass']."\">
								    <img src='%s/templates/%s/images/IcoRating%d.gif' />
							    </td>
						    </tr>
					    ", 
					       ProdLink($row['commonnamefield']),
					       isc_html_escape($row['commonnamefield']),
					       number_format($row['prodnumviews']),
                           number_format($row['numsold']),
                           number_format($row['unitssoldpercent']*100, 2)."%",
					       GetConfig('ShopPath'),
					       GetConfig('template'),
					       $row['avgrating']
					    ); 
                    }
                    else    {
                        $GLOBALS['OrderGrid'] .= sprintf("
                            <tr class=\"GridRow\" onmouseover=\"this.className='GridRowOver';\" onmouseout=\"this.className='GridRow';\">
                                
                                <td nowrap class=\"".$GLOBALS['SortedFieldNameClass']."\">
                                    %s
                                </td>
                                <td nowrap class=\"".$GLOBALS['SortedFieldUnitsSoldClass']."\">
                                    %s
                                </td>
                                <td nowrap class=\"".$GLOBALS['SortedFieldViewsClass']."\">
                                    %s
                                </td>
                                <td nowrap>
                                    %s
                                </td>
                                <td nowrap class=\"".$GLOBALS['SortedFieldAverageRatingClass']."\">
                                    <img src='%s/templates/%s/images/IcoRating%d.gif' />
                                </td>
                            </tr>
                        ",                             
                           isc_html_escape($row['commonnamefield']),
                           number_format($row['prodnumviews']),
                           number_format($row['numsold']),
                           number_format($row['unitssoldpercent']*100, 2)."%",
                           GetConfig('ShopPath'),
                           GetConfig('template'),
                           $row['avgrating']
                        );    
                    }
                    /*<td nowrap height=\"22\" class=\"".$GLOBALS['SortedFieldProductIdClass']."\">
                        %d
                    </td>
                    <td nowrap class=\"".$GLOBALS['SortedFieldCodeClass']."\">
                        %s
                    </td>*/    
                    //$row['productid'],$code,    
                    //Removed from top of above string
				}
			}
		}
		else {
			$GLOBALS['OrderGrid'] .= sprintf("
				<tr class=\"GridRow\" onmouseover=\"this.className='GridRowOver';\" onmouseout=\"this.className='GridRow';\">
					<td nowrap height=\"22\" colspan=\"5\">
						<em>%s</em>
					</td>
				</tr>
			", GetLang('StatsNoProducts')
			);
		}

		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("stats.products.bynumviewsgrid");
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
	}

	/**
	*	Show all products by inventory levels
	*/
	public function ProductStatsByInventoryGrid()
	{

		$GLOBALS['OrderGrid'] = "";

		// How many records per page?
		if(isset($_GET['Show'])) {
			$per_page = (int)$_GET['Show'];
		}
		else {
			$per_page = 20;
		}

		$GLOBALS['ProductsPerPage'] = $per_page;
		$GLOBALS["IsShowPerPage" . $per_page] = 'selected="selected"';

		// Should we limit the records returned?
		if(isset($_GET['Page'])) {
			$page = (int)$_GET['Page'];
		}
		else {
			$page = 1;
		}

		$GLOBALS['ProductsByInventoryCurrentPage'] = $page;

		// Workout the start and end records
		$start = ($per_page * $page) - $per_page;
		$end = $start + ($per_page - 1);

		// Only fetch products this user can actually see
		$vendorRestriction = $this->GetVendorRestriction();
		$vendorSql = '';
		if($vendorRestriction !== false) {
			$vendorSql = " WHERE prodvendorid = '" . $GLOBALS['ISC_CLASS_DB']->Quote($vendorRestriction) . "'";
		}

		// How many products are there in total?
		$query = "
			SELECT
				COUNT(*) AS num
			FROM
				[|PREFIX|]products
			" . $vendorRestriction;

		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

		$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
		$total_products = $row['num'];

		if ($total_products > 0) {
			// Workout the paging
			$num_pages = ceil($total_products / $per_page);
			$paging = sprintf(GetLang('PageXOfX'), $page, $num_pages);
			$paging .= "&nbsp;&nbsp;&nbsp;&nbsp;";

			// Is there more than one page? If so show the &laquo; to jump back to page 1
			if($num_pages > 1) {
				$paging .= "<a href='javascript:void(0)' onclick='ChangeProductsByInventoryPage(1)'>&laquo;</a> | ";
			}
			else {
				$paging .= "&laquo; | ";
			}

			// Are we on page 2 or above?
			if($page > 1) {
				$paging .= sprintf("<a href='javascript:void(0)' onclick='ChangeProductsByInventoryPage(%d)'>%s</a> | ", $page-1, GetLang('Prev'));
			}
			else {
				$paging .= sprintf("%s | ", GetLang('Prev'));
			}

			for($i = 1; $i <= $num_pages; $i++) {
				// Only output paging -5 and +5 pages from the page we're on
				if($i >= $page-6 && $i <= $page+5) {
					if($page == $i) {
						$paging .= sprintf("<strong>%d</strong> | ", $i);
					}
					else {
						$paging .= sprintf("<a href='javascript:void(0)' onclick='ChangeProductsByInventoryPage(%d)'>%d</a> | ", $i, $i);
					}
				}
			}

			// Are we on page 2 or above?
			if($page < $num_pages) {
				$paging .= sprintf("<a href='javascript:void(0)' onclick='ChangeProductsByInventoryPage(%d)'>%s</a> | ", $page+1, GetLang('Next'));
			}
			else {
				$paging .= sprintf("%s | ", GetLang('Next'));
			}

			// Is there more than one page? If so show the &raquo; to go to the last page
			if($num_pages > 1) {
				$paging .= sprintf("<a href='javascript:void(0)' onclick='ChangeProductsByInventoryPage(%d)'>&raquo;</a> | ", $num_pages);
			}
			else {
				$paging .= "&raquo; | ";
			}

			$paging = rtrim($paging, ' |');
			$GLOBALS['Paging'] = $paging;

			if(isset($_GET['SortOrder']) && $_GET['SortOrder'] == "desc") {
				$sortOrder = 'desc';
			}
			else {
				$sortOrder = 'asc';
			}

			$sortFields = array('productid', 'prodcode', 'prodname', 'prodnumviews', 'instock');
			if(isset($_GET['SortBy']) && in_array($_GET['SortBy'], $sortFields)) {
				$sortField = $_GET['SortBy'];
				SaveDefaultSortField("ProductStatsByInventory", $_REQUEST['SortBy'], $sortOrder);
			}
			else {
				list($sortField, $sortOrder) = GetDefaultSortField("ProductStatsByInventory", "instock", $sortOrder);
			}

			$sortLinks = array(
				"ProductId" => "productid",
				"Code" => "prodcode",
				"Name" => "prodname",
				"Views" => "prodnumviews",
				"Stock" => "instock"
			);
			BuildAdminSortingLinks($sortLinks, "javascript:SortProductsByInventory('%%SORTFIELD%%', '%%SORTORDER%%');", $sortField, $sortOrder);

			// Fetch the products and inventory levels for this page
			$query = "
				SELECT productid, prodcode, prodname, prodnumviews, prodinvtrack,
					CASE prodinvtrack
						WHEN '0' THEN
							-1
						WHEN '1' THEN
							prodcurrentinv
						WHEN '2' THEN
								(SELECT SUM(vcstock) FROM [|PREFIX|]product_variation_combinations WHERE vcproductid=productid)
						END
						AS instock
				FROM [|PREFIX|]products
				 " . $vendorSql . "
				ORDER BY ".$sortField." ".$sortOrder
			;

			// Add the Limit
			$query .= $GLOBALS['ISC_CLASS_DB']->AddLimit($start, $per_page);
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			if($GLOBALS['ISC_CLASS_DB']->CountResult($result) > 0) {
				while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {

					switch($row['prodinvtrack']) {
						case 0: { // Not tracking
							$tracking_method = GetLang('NA');
							break;
						}
						case 1: { // By product
							$tracking_method = GetLang('StatsByProduct');
							break;
						}
						case 2: { // By option
							$tracking_method = GetLang('StatsByProductOption');
							break;
						}
					}

					switch($row['instock']) {
						case -1: {
							$stock_level = GetLang('NA');
							$edit_link = sprintf("<span class='disabled'>%s</span>", GetLang('UpdateStockLevels'));
							break;
						}
						default: {
							$stock_level = number_format($row['instock']);
							$edit_link = sprintf("<a href='index.php?ToDo=viewProducts&amp;productId=%d' target='_blank'>%s</span>", $row['productid'], GetLang('UpdateStockLevels'));

							if($stock_level == 0) { // Flag if zero
								$stock_level = sprintf("<b style='color:red'>%s</strong>", $stock_level);
							}
						}
					}
					$sku = GetLang('NA');
					if($row['prodcode'] != '') {
						$sku = isc_html_escape($row['prodcode']);
					}               
					$GLOBALS['OrderGrid'] .= sprintf("
						<tr class=\"GridRow\" onmouseover=\"this.className='GridRowOver';\" onmouseout=\"this.className='GridRow';\"> 
							<td nowrap height=\"22\" class=\"".$GLOBALS['SortedFieldProductIdClass']."\">
								%d
							</td>
							<td class=\"".$GLOBALS['SortedFieldCodeClass']."\">
								%s
							</td>
							<td class=\"".$GLOBALS['SortedFieldNameClass']."\">
								<a href='%s' target='_blank'>%s</a>
							</td>
							<td>
								%s
							</td>
							<td class=\"".$GLOBALS['SortedFieldStockClass']."\">
								%s
							</td>
							<td>
								%s
							</td>
						</tr>
					", $row['productid'],
					   $sku,
					   ProdLink($row['prodname']),
					   isc_html_escape($row['prodname']),
					   $tracking_method,
					   $stock_level,
					   $edit_link
					);
				}
			}
		}
		else {
			$GLOBALS['OrderGrid'] .= sprintf("
				<tr class=\"GridRow\" onmouseover=\"this.className='GridRowOver';\" onmouseout=\"this.className='GridRow';\">
					<td nowrap height=\"22\" colspan=\"6\">
						<em>%s</em>
					</td>
				</tr>
			", GetLang('StatsNoProducts')
			);
		}

		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("stats.products.byinventorygrid");
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
	}                                                                                                                             
    
    private function GetQueries(&$countQuery, &$mainQuery, $vendorSql, $sortField, $sortOrder, &$NameField)
    {
            
            switch($_REQUEST['showby']) {
                case 'category':    {
                    if($vendorSql=="")    {   
                        $WhereQuery = " WHERE c.catparentid = 0 ";  
                    }
                    else    {    
                        $WhereQuery = " AND c.catparentid = 0 ";   
                    }
                    
                    $mainQuery = "
                                SELECT
                                    p.productid,
                                    p.prodcode,
                                    p.prodname,
                                    c.categoryid itemid,
                                    c.catname commonnamefield, 
                                    SUM(ordprodqty) AS numsold,
                                    SUM(p.prodnumviews) AS prodnumviews,                            
                                    IF(SUM(p.prodnumratings) > 0, (SUM(p.prodratingtotal) / SUM(p.prodnumratings)), 0) AS avgrating,
                                    IF(SUM(p.prodnumviews) > 0, SUM(ordprodqty) / SUM(p.prodnumviews), 0) AS unitssoldpercent
                                FROM
                                    [|PREFIX|]products p
                                    INNER JOIN [|PREFIX|]categoryassociations ca ON ( ca.productid = p.productid )
                                    LEFT JOIN [|PREFIX|]categories c ON ( c.categoryid = ca.categoryid )        
                                    LEFT JOIN 
                                    (
                                    SELECT 
                                        SUM(ordprodqty) ordprodqty, ordprodid FROM isc_order_products
                                        LEFT JOIN isc_orders ON orderid = orderorderid 
                                        WHERE ordstatus IN (".implode(',', GetPaidOrderStatusArray()).") 
                                        AND ordprodtype != 'giftcertificate' 
                                        GROUP BY ordprodid
                                    ) AS op ON op.ordprodid = p.productid 
                                " . $vendorSql . "
                                " . $WhereQuery . "
                                GROUP BY c.categoryid 
                                ORDER BY
                                " . $sortField . " " . $sortOrder;
                     $countQuery = "SELECT COUNT(DISTINCT c.categoryid) AS num
                                    FROM isc_categories c
                                    INNER JOIN isc_categoryassociations ca ON ( c.categoryid = ca.categoryid ) 
                                    INNER JOIN isc_products p ON ( ca.productid = p.productid ) 
                                    " . $vendorSql . "
                                    " . $WhereQuery . " ";
                                    
                    //$NameField = 'catname';       
                    //LEFT JOIN [|PREFIX|]categories rc ON ((c.catparentid = rc.categoryid) || (c.catparentid=0 AND c.categoryid=rc.categoryid))                     
                    
                    break;
                }
                case 'subcategory':    {
                    $mainQuery = "
                                SELECT
                                    p.productid,
                                    p.prodcode,
                                    p.prodname,
                                    c.categoryid itemid,
                                    c.catname commonnamefield, 
                                    SUM(ordprodqty) AS numsold,
                                    SUM(p.prodnumviews) AS prodnumviews,
                                    IF(SUM(p.prodnumratings) > 0, (SUM(p.prodratingtotal) / SUM(p.prodnumratings)), 0) AS avgrating,
                                    IF(SUM(p.prodnumviews) > 0, SUM(ordprodqty) / SUM(p.prodnumviews), 0) AS unitssoldpercent
                                FROM
                                    [|PREFIX|]products p
                                    INNER JOIN [|PREFIX|]categoryassociations ca ON ( ca.productid = p.productid )
                                    LEFT JOIN [|PREFIX|]categories c ON ( c.categoryid = ca.categoryid ) 
                                    LEFT JOIN 
                                    (
                                    SELECT 
                                        SUM(ordprodqty) ordprodqty, ordprodid FROM isc_order_products
                                        LEFT JOIN isc_orders ON orderid = orderorderid 
                                        WHERE ordstatus IN (".implode(',', GetPaidOrderStatusArray()).") 
                                        AND ordprodtype != 'giftcertificate' 
                                        GROUP BY ordprodid
                                    ) AS op ON op.ordprodid = p.productid 
                                " . $vendorSql . "
                                GROUP BY c.categoryid 
                                ORDER BY
                                " . $sortField . " " . $sortOrder;
                     $countQuery = "
                                    SELECT COUNT(DISTINCT c.categoryid) AS num
                                    FROM isc_categories c
                                    INNER JOIN isc_categoryassociations ca ON ( c.categoryid = ca.categoryid ) 
                                    INNER JOIN isc_products p ON ( ca.productid = p.productid ) 
                                    " . $vendorSql . "";

                    //$NameField = 'catname';
                    
                    break;
                }
                case 'brand':    {
                    $mainQuery = "
                                SELECT
                                    p.productid,
                                    p.prodcode,
                                    p.prodname,
                                    b.brandid itemid, 
                                    b.brandname commonnamefield,                                             
                                    SUM(ordprodqty) AS numsold,
                                    SUM(p.prodnumviews) AS prodnumviews,                             
                                    IF(SUM(p.prodnumratings) > 0, (SUM(p.prodratingtotal) / SUM(p.prodnumratings)), 0) AS avgrating,
                                    IF(SUM(p.prodnumviews) > 0, (SUM(ordprodqty) / SUM(p.prodnumviews)), 0) AS unitssoldpercent
                                FROM
                                    [|PREFIX|]products p                                                 
                                    LEFT JOIN [|PREFIX|]brands b ON p.prodbrandid = b.brandid
                                    LEFT JOIN 
                                    (
                                    SELECT 
                                        SUM(ordprodqty) ordprodqty, ordprodid FROM isc_order_products
                                        LEFT JOIN isc_orders ON orderid = orderorderid 
                                        WHERE ordstatus IN (".implode(',', GetPaidOrderStatusArray()).") 
                                        AND ordprodtype != 'giftcertificate' 
                                        GROUP BY ordprodid
                                    ) AS op ON op.ordprodid = p.productid
                                " . $vendorSql . "
                                GROUP BY b.brandid 
                                ORDER BY
                                " . $sortField . " " . $sortOrder;
                     $countQuery = "SELECT COUNT(DISTINCT b.brandid) AS num
                                    FROM [|PREFIX|]brands b
                                    INNER JOIN isc_products p ON b.brandid = p.prodbrandid 
                                    " . $vendorSql . "";
                                    
                    //$NameField = 'brandname';
                    
                    break;
                }
                case 'series':    {
                    
                    if($vendorSql=="")    {   
                        $WhereQuery1 = " WHERE bs.seriesid != 0 "; 
                        $WhereQuery2 = " WHERE p.brandseriesid = 0 "; 
                    }
                    else    {    
                        $WhereQuery1 = " AND bs.seriesid != 0 ";  
                        $WhereQuery2 = " AND p.brandseriesid = 0 "; 
                    }
                    
                    $mainQuery = "
                    SELECT * FROM 
                                (
                                SELECT
                                    p.productid,
                                    p.prodcode,
                                    p.prodname,
                                    bs.seriesid itemid, 
                                    CONCAT(b.brandname, ' - ', bs.seriesname) AS commonnamefield,
                                    SUM(ordprodqty) AS numsold,
                                    SUM(p.prodnumviews) AS prodnumviews,                                
                                    IF(SUM(p.prodnumratings) > 0, (SUM(p.prodratingtotal) / SUM(p.prodnumratings)), 0) AS avgrating,
                                    IF(SUM(p.prodnumviews) > 0, SUM(ordprodqty)/SUM(p.prodnumviews), 0) AS unitssoldpercent
                                FROM
                                    [|PREFIX|]products p                                                
                                    LEFT JOIN [|PREFIX|]brand_series bs ON p.brandseriesid = bs.seriesid
                                    LEFT JOIN [|PREFIX|]brands b ON bs.brandid = b.brandid
                                    LEFT JOIN 
                                    (
                                    SELECT 
                                        SUM(ordprodqty) ordprodqty, ordprodid FROM isc_order_products
                                        LEFT JOIN isc_orders ON orderid = orderorderid 
                                        WHERE ordstatus IN (".implode(',', GetPaidOrderStatusArray()).") 
                                        AND ordprodtype != 'giftcertificate' 
                                        GROUP BY ordprodid
                                    ) AS op ON op.ordprodid = p.productid 
                                " . $vendorSql . "
                                " . $WhereQuery1 . "
                                GROUP BY bs.seriesid 
                                UNION
                                SELECT
                                    p.productid,
                                    p.prodcode,
                                    p.prodname,
                                    p.prodbrandid itemid, 
                                    b.brandname commonnamefield,
                                    SUM(ordprodqty) AS numsold,
                                    SUM(p.prodnumviews) AS prodnumviews,                           
                                    IF(SUM(p.prodnumratings) > 0, (SUM(p.prodratingtotal) / SUM(p.prodnumratings)), 0) AS avgrating,
                                    IF(SUM(p.prodnumviews) > 0, (SUM(ordprodqty) / SUM(p.prodnumviews)), 0) AS unitssoldpercent
                                FROM
                                    [|PREFIX|]products p                                                  
                                    LEFT JOIN [|PREFIX|]brands b ON p.prodbrandid = b.brandid
                                    LEFT JOIN 
                                    (
                                    SELECT 
                                        SUM(ordprodqty) ordprodqty, ordprodid FROM isc_order_products
                                        LEFT JOIN isc_orders ON orderid = orderorderid 
                                        WHERE ordstatus IN (".implode(',', GetPaidOrderStatusArray()).") 
                                        AND ordprodtype != 'giftcertificate' 
                                        GROUP BY ordprodid
                                    ) AS op ON op.ordprodid = p.productid 
                                " . $vendorSql . "   
                                " . $WhereQuery2 . "
                                GROUP BY b.brandid
                    ) AS combinedtable
                                ORDER BY
                                combinedtable." . $sortField . " " . $sortOrder;
                                
                     $countQuery = "SELECT COUNT(DISTINCT bs.seriesid) AS num
                                    FROM [|PREFIX|]brand_series bs
                                    INNER JOIN isc_products p ON bs.seriesid = p.brandseriesid 
                                    " . $vendorSql . "";    
                                    
                    //$NameField = 'seriescomname';
                    /*
                    echo "<noscript>";
                    echo $mainQuery."<br />";
                    echo $countQuery."<br />";
                    echo "</noscript>"; 
                    */
                    break;
                }    
                default:
                    // Fetch the orders for this page         
                    $mainQuery = "
                        SELECT
                            p.productid itemid,
                            p.prodcode,
                            p.prodname commonnamefield,
                            ordprodqty AS numsold,
                            p.prodnumviews,
                            IF(p.prodnumratings > 0, p.prodratingtotal / p.prodnumratings, 0) AS avgrating,
                            IF(p.prodnumviews > 0, (ordprodqty / p.prodnumviews), 0) AS unitssoldpercent
                        FROM
                            [|PREFIX|]products p
                            LEFT JOIN 
                            (
                            SELECT 
                                SUM(ordprodqty) ordprodqty, ordprodid FROM isc_order_products
                                LEFT JOIN isc_orders ON orderid = orderorderid 
                                WHERE ordstatus IN (".implode(',', GetPaidOrderStatusArray()).") 
                                AND ordprodtype != 'giftcertificate' 
                                GROUP BY ordprodid
                            ) AS op ON op.ordprodid = p.productid 
                        " . $vendorSql . "      
                        ORDER BY
                            " . $sortField . " " . $sortOrder;
                    $countQuery = "
                        SELECT
                            COUNT(*) AS num
                        FROM
                            [|PREFIX|]products
                        " . $vendorSql;
                    //$NameField = 'prodname';
                    
            }
            
            /*
            //Fetch the orders for this page         
            $mainQuery = "
                SELECT
                    p.productid,
                    p.prodcode,
                    p.prodname,
                    $newselect,
                    IF(p.prodnumratings > 0, p.prodratingtotal / p.prodnumratings, 0) AS avgrating
                FROM
                    [|PREFIX|]products p
                " . $leftJoin . "
                " . $vendorSql . "
                " . $groupBy . "
                ORDER BY
                    " . $sortField . " " . $sortOrder;
            */
            
            
            
            
    }
    
    
}
?>