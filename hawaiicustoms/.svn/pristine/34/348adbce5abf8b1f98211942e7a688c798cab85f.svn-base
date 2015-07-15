<?php
class ISC_ADMIN_STATISTICS_ORDERS extends ISC_ADMIN_STATISTICS
{
	/**
	*	Show order statistics by count of item sold, by count of orders and by revenue
	*/
	public function OrderStats()
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

		// Set the global variables for the select boxes
		$from_stamp = $cal['start'];
		$to_stamp = $cal['end'];

		$from_days = $from_stamp / 86400;
		$to_days = $to_stamp / 86400;
		$num_days = floor($to_days - $from_days)+1;

		// If we're looking at only one day then we don't show unique visitors
		// or conversion rates because they're stored per-day and we don't
		// have hourly values for them
		if($num_days > 1) {
			$GLOBALS['HideNoAdvancedStatsMessage'] = "none";
		}

		$from_day = isc_date("d", $from_stamp);
		$from_month = isc_date("m", $from_stamp);
		$from_year = isc_date("Y", $from_stamp);

		$to_day = isc_date("d", $to_stamp);
		$to_month = isc_date("m", $to_stamp);
		$to_year = isc_date("Y", $to_stamp);

		// Get the total cost and number of orders for the period
		$order_details = $this->_GetOrderValueForPeriod($from_stamp, $to_stamp);

		if(is_array($order_details)) {
			$GLOBALS['OverviewOrderTotal'] = $order_details['total'];
			$GLOBALS['OverviewOrderCount'] = $order_details['count'];
			$GLOBALS['OverviewUniqueVisitors'] = $order_details['uniques'];

			// Workout the conversion rate
			if($order_details['uniques'] > 0) {
				$conversion_rate = ($order_details['count'] / $order_details['uniques']) * 100;
			}
			else {
				$conversion_rate = 0;
			}

			$GLOBALS['OverviewConversionRate'] = sprintf("%.2f%%", $conversion_rate);
		}
		else {
			$GLOBALS['OverviewOrderTotal'] = 0;
			$GLOBALS['OverviewOrderCount'] = 0;
			$GLOBALS['OverviewUniqueVisitors'] = 0;
			$GLOBALS['OverviewConversionRate'] = 0;
		}

		// Set the title of the chart
		if($GLOBALS['OverviewOrderCount'] == 1) {
			$lang_var = "OverviewChartTitle1";
		}
		else {
			$lang_var = "OverviewChartTitleX";
		}

		$GLOBALS['OverviewOrderTotal'] = number_format($GLOBALS['OverviewOrderTotal'], GetConfig('DecimalPlaces'));
		$GLOBALS['OverviewUniqueVisitors'] = number_format($GLOBALS['OverviewUniqueVisitors']);

		$orders_by_revenue = $this->_GetOrdersByRevenue($from_stamp, $to_stamp);
		$num_orders_by_revenue = 0;

		foreach($orders_by_revenue as $period) {
			$num_orders_by_revenue += $period['numorders'];
		}

		// Set the title of the chart
		if($num_orders_by_revenue == 1) {
			$lang_var = "OrdersByRevenueChartTitle1";
		}
		else {
			$lang_var = "OrdersByRevenueChartTitleX";
		}

		$GLOBALS['ByRevenueChartTitle'] = sprintf(GetLang($lang_var), number_format($num_orders_by_revenue), isc_date(GetConfig('DisplayDateFormat'), $from_stamp), isc_date(GetConfig('DisplayDateFormat'), $to_stamp));

		$GLOBALS['OverviewFromDays'] = $this->_GetDayOptions($from_day);
		$GLOBALS['OverviewFromMonths'] = $this->_GetMonthOptions($from_month);
		$GLOBALS['OverviewFromYears'] = $this->_GetYearOptions($from_year);

		$GLOBALS['OverviewToDays'] = $this->_GetDayOptions($to_day);
		$GLOBALS['OverviewToMonths'] = $this->_GetMonthOptions($to_month);
		$GLOBALS['OverviewToYears'] = $this->_GetYearOptions($to_year);

		// Set the from and to date stamps
		$GLOBALS['OverviewFromStamp'] = $cal['start'];
		$GLOBALS['OverviewToStamp'] = $cal['end'];

		if(isset($_POST['currentTab'])) {
			$GLOBALS['CurrentTab'] = (int)$_POST['currentTab'];
		}
		else {
			$GLOBALS['CurrentTab'] = 0;
		}

		$vendorRestriction = $this->GetVendorRestriction();
		if($vendorRestriction) {
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

		$GLOBALS['FromStamp'] = $from_stamp;
		$GLOBALS['ToStamp'] = $to_stamp;

		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("stats.orders");
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
	}

	/**
	*	Build the grid that will be shown on the "Orders by Date" tab
	**/
	public function OrderStatsByDateGrid()
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

			$GLOBALS['OrdersPerPage'] = $per_page;
			$GLOBALS["IsShowPerPage" . $per_page] = 'selected="selected"';

			// Should we limit the records returned?
			if(isset($_GET['Page'])) {
				$page = (int)$_GET['Page'];
			}
			else {
				$page = 1;
			}

			$GLOBALS['OrdersByDateCurrentPage'] = $page;

			// Workout the start and end records
			$start = ($per_page * $page) - $per_page;
			$end = $start + ($per_page - 1);

			// Only fetch products this user can actually see
			$vendorRestriction = $this->GetVendorRestriction();
			$vendorSql = '';
			if($vendorRestriction !== false) {
				$vendorSql = " AND prodvendorid='".(int)$vendorRestriction."'";
			}

			// How many orders are there in total?
			$query = "
				SELECT COUNT(orderid) AS num
				FROM [|PREFIX|]orders
				WHERE ordstatus IN (".implode(',', GetPaidOrderStatusArray()).") AND orddate >= '".$from_stamp."' AND orddate <= '".$to_stamp."'
				".$vendorSql."
			";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
			$total_orders = $row['num'];

			// Are there any orders?
			if($total_orders > 0) {

				// Workout the paging
				$num_pages = ceil($total_orders / $per_page);
				$paging = sprintf(GetLang('PageXOfX'), $page, $num_pages);
				$paging .= "&nbsp;&nbsp;&nbsp;&nbsp;";

				// Is there more than one page? If so show the &laquo; to jump back to page 1
				if($num_pages > 1) {
					$paging .= "<a href='javascript:void(0)' onclick='ChangeOrdersByDatePage(1)'>&laquo;</a> | ";
				}
				else {
					$paging .= "&laquo; | ";
				}

				// Are we on page 2 or above?
				if($page > 1) {
					$paging .= sprintf("<a href='javascript:void(0)' onclick='ChangeOrdersByDatePage(%d)'>%s</a> | ", $page-1, GetLang('Prev'));
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
							$paging .= sprintf("<a href='javascript:void(0)' onclick='ChangeOrdersByDatePage(%d)'>%d</a> | ", $i, $i);
						}
					}
				}

				// Are we on page 2 or above?
				if($page < $num_pages) {
					$paging .= sprintf("<a href='javascript:void(0)' onclick='ChangeOrdersByDatePage(%d)'>%s</a> | ", $page+1, GetLang('Next'));
				}
				else {
					$paging .= sprintf("%s | ", GetLang('Next'));
				}

				// Is there more than one page? If so show the &raquo; to go to the last page
				if($num_pages > 1) {
					$paging .= sprintf("<a href='javascript:void(0)' onclick='ChangeOrdersByDatePage(%d)'>&raquo;</a> | ", $num_pages);
				}
				else {
					$paging .= "&raquo; | ";
				}

				$paging = rtrim($paging, ' |');
				$GLOBALS['Paging'] = $paging;

				// Should we set focus to the grid?
				if(isset($_GET['FromLink']) && $_GET['FromLink'] == "true") {
					$GLOBALS['JumpToOrdersByDateGrid'] = "<script type=\"text/javascript\">document.location.href='#ordersByDateAnchor';</script>";
				}

				if(isset($_GET['SortOrder']) && $_GET['SortOrder'] == "desc") {
					$sortOrder = 'desc';
				}
				else {
					$sortOrder = 'asc';
				}

				$sortFields = array('orderid','name','orddate','ordtotalamount','ordtrackingno');
				if(isset($_GET['SortBy']) && in_array($_GET['SortBy'], $sortFields)) {
					$sortField = $_GET['SortBy'];
					SaveDefaultSortField("OrderStatsByDate", $_REQUEST['SortBy'], $sortOrder);
				}
				else {
					list($sortField, $sortOrder) = GetDefaultSortField("OrderStatsByDate", "orddate", $sortOrder);
				}

				$sortLinks = array(
					"Id" => "orderid",
					"Cust" => "name",
					"Date" => "orddate",
					"Total" => "ordtotalamount",
					"Tracking" => "ordtrackingno"
				);
				BuildAdminSortingLinks($sortLinks, "javascript:SortOrdersByDate('%%SORTFIELD%%', '%%SORTORDER%%');", $sortField, $sortOrder);

				// Fetch the orders for this page
				$query = "
					SELECT orderid, customerid, concat(custconfirstname, ' ', custconlastname) AS name, orddate, ordtotalamount, ordtrackingno, ordbillfirstname, ordbilllastname
					FROM [|PREFIX|]orders
					LEFT JOIN [|PREFIX|]customers ON (ordcustid=customerid)
					WHERE ordstatus IN (".implode(',', GetPaidOrderStatusArray()).") AND orddate >= '".$from_stamp."' AND orddate <= '".$to_stamp."'
					".$vendorSql."
					ORDER BY ".$sortField." ".$sortOrder
				;
				// Add the limit
				$query .= $GLOBALS['ISC_CLASS_DB']->AddLimit($start, $per_page);
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

				while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					if($row['ordtrackingno']) {
						$trackingNo = isc_html_escape($row['ordtrackingno']);
					}
					else {
						$trackingNo = GetLang('NA');
					}
					if(!$row['name']) {
						$row['name'] = $row['ordbillfirstname'].' '.$row['ordbilllastname'];
					}
					$GLOBALS['OrderGrid'] .= sprintf("
						<tr class=\"GridRow\" onmouseover=\"this.className='GridRowOver';\" onmouseout=\"this.className='GridRow';\">
							<td nowrap height=\"22\" class=\"".$GLOBALS['SortedFieldIdClass']."\">
								%s
							</td>
							<td nowrap=\"nowrap\" class=\"".$GLOBALS['SortedFieldCustClass']."\">
								<a href='index.php?ToDo=viewCustomers&amp;searchQuery=%d' target='_blank'>%s</a>
							</td>
							<td nowrap class=\"".$GLOBALS['SortedFieldDateClass']."\">
								%s
							</td>
							<td nowrap class=\"".$GLOBALS['SortedFieldTotalClass']."\">
								%s
							</td>
							<td nowrap>
								%s
							</td>
							<td nowrap>
								<a href=\"index.php?ToDo=viewOrders&orderId=%d\" target=\"_blank\">%s</a>
							</td>
						</tr>

					", (int) $row['orderid'],
					   isc_html_escape($row['customerid']),
					   isc_html_escape($row['name']),
					   isc_date(GetConfig('ExtendedDisplayDateFormat'), $row['orddate']),
					   FormatPrice($row['ordtotalamount']),
					   $trackingNo,
					   $row['orderid'],
					   GetLang('StatsViewOrder')
					);
				}

				$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("stats.orders.bydategrid");
				$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
			}
		}
	}

	/**
	*	Build the grid that will be shown on the "Orders by Items Sold" tab
	**/
	public function OrderStatsByItemsSoldGrid()
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

			$GLOBALS['OrdersPerPage'] = $per_page;
			$GLOBALS["IsShowPerPage" . $per_page] = 'selected="selected"';

			// Should we limit the records returned?
			if(isset($_GET['Page'])) {
				$page = (int)$_GET['Page'];
			}
			else {
				$page = 1;
			}

			$GLOBALS['OrdersByItemsSoldCurrentPage'] = $page;

			// Workout the start and end records
			$start = ($per_page * $page) - $per_page;
			$end = $start + ($per_page - 1);

			// Only fetch products this user can actually see
			$vendorRestriction = $this->GetVendorRestriction();
			$vendorSql = '';
			if($vendorRestriction !== false) {
				$vendorSql = " AND prodvendorid='" . $GLOBALS['ISC_CLASS_DB']->Quote($vendorRestriction) . "'";
			}

			// How many orders are there in total?
			$query = "
				SELECT
					COUNT(*) AS num
				FROM
					[|PREFIX|]order_products
					INNER JOIN [|PREFIX|]orders ON orderorderid = orderid
					LEFT JOIN [|PREFIX|]products ON ordprodid = productid
				WHERE
					ordstatus IN (".implode(',', GetPaidOrderStatusArray()) . ") AND
					orddate >= '" . $from_stamp . "' AND
					orddate <= '" . $to_stamp . "' AND
					ordprodid != 0
					" . $vendorSql;

			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
			$total_orders = $row['num'];

			if ($total_orders > 0) {
				// Workout the paging
				$num_pages = ceil($total_orders / $per_page);
				$paging = sprintf(GetLang('PageXOfX'), $page, $num_pages);
				$paging .= "&nbsp;&nbsp;&nbsp;&nbsp;";

				// Is there more than one page? If so show the &laquo; to jump back to page 1
				if($num_pages > 1) {
					$paging .= "<a href='javascript:void(0)' onclick='ChangeOrdersByItemsSoldPage(1)'>&laquo;</a> | ";
				}
				else {
					$paging .= "&laquo; | ";
				}

				// Are we on page 2 or above?
				if($page > 1) {
					$paging .= sprintf("<a href='javascript:void(0)' onclick='ChangeOrdersByItemsSoldPage(%d)'>%s</a> | ", $page-1, GetLang('Prev'));
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
							$paging .= sprintf("<a href='javascript:void(0)' onclick='ChangeOrdersByItemsSoldPage(%d)'>%d</a> | ", $i, $i);
						}
					}
				}

				// Are we on page 2 or above?
				if($page < $num_pages) {
					$paging .= sprintf("<a href='javascript:void(0)' onclick='ChangeOrdersByItemsSoldPage(%d)'>%s</a> | ", $page+1, GetLang('Next'));
				}
				else {
					$paging .= sprintf("%s | ", GetLang('Next'));
				}

				// Is there more than one page? If so show the &raquo; to go to the last page
				if($num_pages > 1) {
					$paging .= sprintf("<a href='javascript:void(0)' onclick='ChangeOrdersByItemsSoldPage(%d)'>&raquo;</a> | ", $num_pages);
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

				$sortFields = array('ordprodid','ordprodsku','ordprodname','numorders','revenue','numitemssold');
				if(isset($_GET['SortBy']) && in_array($_GET['SortBy'], $sortFields)) {
					$sortField = $_GET['SortBy'];
					SaveDefaultSortField("OrderStatsBySold", $_REQUEST['SortBy'], $sortOrder);
				}
				else {
					list($sortField, $sortOrder) = GetDefaultSortField("OrderStatsBySold", "numorders", $sortOrder);
				}

				$sortLinks = array(
					"ProductId" => "ordprodid",
					"Code" => "ordprodsku",
					"Name" => "ordprodname",
					"NumOrders" => "numorders",
					"Revenue" => "revenue",
					"UnitsSold" => "numitemssold"
				);
				BuildAdminSortingLinks($sortLinks, "javascript:SortOrdersByItemsSold('%%SORTFIELD%%', '%%SORTORDER%%');", $sortField, $sortOrder);

				// Fetch the orders for this page
				$query = "
					SELECT
						ordprodid,
						ordprodsku,
						ordprodname,
						COUNT(DISTINCT(orderid)) AS numorders,
						(ordprodcost * SUM(ordprodqty)) AS revenue,
						SUM(ordprodqty) AS numitemssold,
						productid
					FROM
						[|PREFIX|]order_products
						INNER JOIN [|PREFIX|]orders ON orderorderid = orderid
						LEFT JOIN [|PREFIX|]products ON ordprodid = productid
					WHERE
						ordstatus IN (".implode(',', GetPaidOrderStatusArray()).") AND
						orddate >= '".$from_stamp."' AND
						orddate <= '".$to_stamp."' AND
						ordprodtype != 'giftcertificate' AND
						ordprodid != 0
						" . $vendorSql . "
					GROUP BY
						ordprodid DESC
					ORDER BY
						" . $sortField . " " . $sortOrder
				;
				// Add the Limit
				$query .= $GLOBALS['ISC_CLASS_DB']->AddLimit($start, $per_page);
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

				if($GLOBALS['ISC_CLASS_DB']->CountResult($result) > 0) {
					while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
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
									%s
								</td>
								<td nowrap class=\"".$GLOBALS['SortedFieldNumOrdersClass']."\">
									%s
								</td>
								<td nowrap class=\"".$GLOBALS['SortedFieldUnitsSoldClass']."\">
									%s
								</td>
								<td nowrap class=\"".$GLOBALS['SortedFieldRevenueClass']."\">
									%s
								</td>
							</tr>
						", (int) $row['ordprodid'],
						   $sku,
						   $prodlink,
						   (int) $row['numorders'],
						   (int) $row['numitemssold'],
						   FormatPrice($row['revenue'])
						);
					}
				}
			}
			else {
				$GLOBALS['HideStatsRows'] = "none";
				$GLOBALS['OrderGrid'] .= sprintf("
					<tr class=\"GridRow\" onmouseover=\"this.className='GridRowOver';\" onmouseout=\"this.className='GridRow';\">
						<td nowrap height=\"22\" colspan=\"6\">
							<em>%s</em>
						</td>
					</tr>
				", GetLang('StatsNoOrdersForDate')
				);
			}

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("stats.orders.byitemssoldgrid");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}
	}

	/**
	*	Get the number of orders per revenue bracket for the specified from/to date
	*/
	public function _GetOrdersByRevenue($FromStamp, $ToStamp)
	{
		// Only fetch products this user can actually see
		$vendorRestriction = $this->GetVendorRestriction();
		$vendorSql = '';
		if($vendorRestriction !== false) {
			$vendorSql = " AND ordvendorid='".(int)$vendorRestriction."'";
		}

		$query = "
			SELECT min(ordtotalamount) AS mintotal, MAX(ordtotalamount) AS maxtotal
			FROM [|PREFIX|]orders
			WHERE ordstatus IN (".implode(',', GetPaidOrderStatusArray()).") AND orddate >= '".$FromStamp."' AND orddate <= '".$ToStamp."'
			".$vendorSql."
		";
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
		$order_list = array();

		$mintotal = $row['mintotal'];
		$maxtotal = $row['maxtotal'];

		// What's the difference between the min and max?
		$diff = $maxtotal - $mintotal;

		if($diff <= 1000) {
			$increments = 10;
		}
		else if($diff <= 10000) {
			$increments = 100;
		}
		else {
			$increments = 1000;
		}

		for($i = 0; $i < ceil($maxtotal); $i+=$increments) {
			$start = $i;
			$end = ($i + $increments) - 1;
			$order_list[sprintf("%s - %s", FormatPrice($start), FormatPrice($end))] = array("min" => $start,
																															"max" => $end,
																															"range" => sprintf("%s - %s", FormatPrice($start), FormatPrice($end)),
																															"numorders" => 0
			);
		}

		// Now we'll get the total of all orders between the periods and save them into an array
		$query = "
			SELECT ordtotalamount
			FROM [|PREFIX|]orders
			WHERE ordstatus IN (".implode(',', GetPaidOrderStatusArray()).") AND orddate >= '".$FromStamp."' AND orddate <= '".$ToStamp."'
			".$vendorSql."
		";
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			foreach($order_list as $k=>$v) {
				if($row['ordtotalamount'] >= $v['min'] && $row['ordtotalamount'] <= $v['max']) {
					$order_list[$k]['numorders']++;
					break;
				}
			}
		}

		return $order_list;
	}

	/**
	*	Generate the chart data for "Orders by Revenue"
	*/
	public function OrderStatsByRevenueData()
	{

		if(isset($_GET['from']) && is_numeric($_GET['from']) && isset($_GET['to']) && is_numeric($_GET['to'])) {

			$from_stamp = (int)$_GET['from'];
			$to_stamp = (int)$_GET['to'];

			$xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
			$xml .= "<pie>\n";

			// Only fetch products this user can actually see
			$vendorRestriction = $this->GetVendorRestriction();
			$vendorSql = '';
			if($vendorRestriction !== false) {
				$vendorSql = " AND ordvendorid='".(int)$vendorRestriction."'";
			}

			$query = "
				SELECT COUNT(orderid) AS num, MIN(ordtotalamount) AS mintotal, MAX(ordtotalamount) AS maxtotal
				FROM [|PREFIX|]orders
				WHERE ordstatus IN (".implode(',', GetPaidOrderStatusArray()).") AND orddate >= '".$from_stamp."' AND orddate <= '".$to_stamp."'
				".$vendorSql."
			";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
			$num_orders = $row['num'];
			$order_list = array();

			$mintotal = $row['mintotal'];
			$maxtotal = $row['maxtotal'];

			// If there aren't any orders then we'll show dummy data
			if($num_orders == 0) {
				$mintotal = 1;
				$maxtotal = 100;
			}

			// What's the difference between the min and max?
			$diff = $maxtotal - $mintotal;

			if($diff <= 1000) {
				$increments = 10;
			}
			else if($diff <= 10000) {
				$increments = 100;
			}
			else {
				$increments = 1000;
			}

			for($i = 0; $i < ceil($maxtotal); $i+=$increments) {
				$start = $i;
				$end = ($i + $increments) - 1;
				$order_list[sprintf("%s - %s", FormatPrice($start), FormatPrice($end))] = array("min" => $start,
																																"max" => $end,
																																"numorders" => 0
				);
			}

			// Now we'll get the total of all orders between the periods and save them into an array
			$query = "
				SELECT ordtotalamount
				FROM [|PREFIX|]orders
				WHERE ordstatus IN (".implode(',', GetPaidOrderStatusArray()).") AND orddate >= '".$from_stamp."' AND orddate <= '".$to_stamp."'
				".$vendorSql."
			";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				foreach($order_list as $k=>$v) {
					if($row['ordtotalamount'] >= $v['min'] && $row['ordtotalamount'] <= $v['max']) {
						$order_list[$k]['numorders']++;
						break;
					}
				}
			}

			foreach($order_list as $k=>$v) {
				$xml .= sprintf("\t<slice title=\"%s\" pull_out=\"false\">%d</slice>\n", isc_html_escape($k), (int) $v['numorders']);
			}

			$xml .= "</pie>";
			echo $xml;
		}
	}

	/**
	*	Show a grid breaking down revenue for orders. This is called via AJAX on the "Orders by Revenue" stats page.
	*/
	public function OrderStatsByRevenueGrid()
	{

		if(isset($_GET['From']) && is_numeric($_GET['From']) && isset($_GET['To']) && is_numeric($_GET['To'])) {
			$from_stamp = (int)$_GET['From'];
			$to_stamp = (int)$_GET['To'];
			$orders_by_revenue = $this->_GetOrdersByRevenue($from_stamp, $to_stamp);
			$num_orders_by_revenue = 0;

			foreach($orders_by_revenue as $k=>$v) {
				$num_orders_by_revenue += $v['numorders'];
			}

			$min = $max = $numorders = array();

			// Obtain a list of columns
			foreach($orders_by_revenue as $key => $row) {
				$min[$key]  = $row['min'];
				$max[$key] = $row['max'];
				$numorders[$key] = $row['numorders'];
			}

			array_multisort($numorders, SORT_DESC, $min, SORT_DESC, $max, SORT_DESC, $orders_by_revenue);
			$GLOBALS['OrderGrid'] = "";

			if($num_orders_by_revenue > 0) {
				foreach($orders_by_revenue as $period => $data) {
					$GLOBALS['OrderGrid'] .= sprintf("
					<tr class=\"GridRow\" onmouseover=\"this.className='GridRowOver';\" onmouseout=\"this.className='GridRow';\">
						<td height=\"22\">
							%s
						</td>
						<td>
							%s
						</td>
					</tr>
					", $data['range'], number_format($data['numorders']));
				}
			}
			else {
				$GLOBALS['HideStatsRows'] = "none";
				$GLOBALS['OrderGrid'] .= sprintf("
				<tr class=\"GridRow\" onmouseover=\"this.className='GridRowOver';\" onmouseout=\"this.className='GridRow';\">
					<td colspan=\"2\" height=\"22\">
						<em>%s</em>
					</td>

				</tr>
				", GetLang('StatsNoOrdersForDate'));
			}

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("stats.orders.byrevenuegrid");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}
	}
}
?>