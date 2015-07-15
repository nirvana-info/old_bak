<?php

/***************************************************************************
*	Created By	: Mayank Jaitly
*	Created On	: 13 July 2010
*	Copyright	: truckchamp.com
*	Version		: 1.0
*	Description	: This class file is to generate the report of orders 
				  created by system users.
/**************************************************************************/

	class ISC_ADMIN_SALES extends ISC_ADMIN_STATISTICS
	{
		private $_customSearch = array();

		/**
		 * The constructor.
		 */
		public function __construct()
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('orders');

			// Initialise custom searches functionality
			require_once(dirname(__FILE__).'/class.customsearch.php');
			$GLOBALS['ISC_CLASS_ADMIN_CUSTOMSEARCH'] = new ISC_ADMIN_CUSTOMSEARCH('orders');
		}
		/*
		* function to handle the coming request to class
		*/

		public function HandleToDo($Do)
		{
			$GLOBALS['BreadcrumEntries'] = array(
				GetLang('Home') => "index.php",
				GetLang('Orders') => 'index.php?ToDo=viewOrders'
			);

			switch (isc_strtolower($Do))
			{
				case 'viewsales':
				default:
					
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Orders)) {

						if(isset($_GET['searchQuery'])) {
							$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Orders') => "index.php?ToDo=viewOrders", GetLang('SearchResults') => "index.php?ToDo=viewOrders");
						}
						else {
							$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Orders') => "index.php?ToDo=viewOrders");
						}

						if (GetSession('ordersearch') > 0) {
							if (!isset($_GET['searchId'])) {
								$_GET['searchId'] = GetSession('ordersearch');
								$_REQUEST['searchId'] = GetSession('ordersearch');
							}

							if ($_GET['searchId'] > 0) {
								$GLOBALS['BreadcrumEntries'] = array_merge($GLOBALS['BreadcrumEntries'], array(GetLang('CustomView') => "index.php?ToDo=customOrderSearch"));
							}
						}

						if (!isset($_REQUEST['ajax'])) {
							$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						}
						if (GetSession('ordersearch') > 0) {
							$this->CustomSearch();
						} else {
							UnsetSession('ordersearch');

							$this->ManageOrders();
						}
						if (!isset($_REQUEST['ajax'])) {
							$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						}
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
			}
		}


		/*
			function to generate order grid
		*/
		private function ManageOrdersGrid(&$numOrders)
		{
			// Show a list of products in a table
			$page = 0;
			$start = 0;
			$numPages = 0;
			$GLOBALS['OrderGrid'] = "";
			$GLOBALS['Nav'] = "";
			$GLOBALS['SmallNav'] = "";
			$catList = "";
			$max = 0;

			// Is this a custom search?
			if(isset($_REQUEST['sortOrder']) && $_REQUEST['sortOrder'] == "asc") {
				$sortOrder = "asc";
			}
			else {
				$sortOrder = "desc";
			}

			$validSortFields = array('orderid', 'custname', 'orddate', 'ordtotalamount');
			if(isset($_REQUEST['sortField']) && in_array($_REQUEST['sortField'], $validSortFields)) {
				$sortField = $_REQUEST['sortField'];
				SaveDefaultSortField("ManageOrders", $_REQUEST['sortField'], $sortOrder);
			}
			else {
				list($sortField, $sortOrder) = GetDefaultSortField("ManageOrders", "orderid", $sortOrder);
			}

			if (isset($_GET['page'])) {
				$page = (int)$_GET['page'];
			} else {
				$page = 1;
			}

			// Build the pagination and sort URL
			$searchURL = '';
			foreach($_GET as $k => $v) {
				if($k == "sortField" || $k == "sortOrder" || $k == "page" || $k == "new" || $k == "ToDo" || $k == "SubmitButton1" || !$v) {
					continue;
				}
				$searchURL .= sprintf("&%s=%s", $k, urlencode($v));
			}

			$sortURL = sprintf("%s&amp;sortField=%s&amp;sortOrder=%s", $searchURL, $sortField, $sortOrder);

			$GLOBALS['SortURL'] = $sortURL;

			// Limit the number of orders returned
			if ($page == 1) {
				$start = 1;
			} else {
				$start = ($page * ISC_ORDERS_PER_PAGE) - (ISC_ORDERS_PER_PAGE-1);
			}

			$start = $start-1;
			
			// Get the results for the query
			$orderResult = $this->_GetOrderList($start, $sortField, $sortOrder, $numOrders);

			$numPages = ceil($numOrders / ISC_ORDERS_PER_PAGE);

			// Add the "(Page x of n)" label
			if($numOrders > ISC_ORDERS_PER_PAGE) {
				$GLOBALS['Nav'] = sprintf("(%s %d of %d) &nbsp;&nbsp;&nbsp;", GetLang('Page'), $page, $numPages);

				$GLOBALS['Nav'] .= BuildPagination($numOrders, ISC_ORDERS_PER_PAGE, $page, sprintf("index.php?ToDo=viewSales%s", $sortURL));
			}
			else {
				$GLOBALS['Nav'] = "";
			}

			if(isset($_GET['searchQuery'])) {
				$query = $_GET['searchQuery'];
			} else {
				$query = "";
			}

			$GLOBALS['Nav'] = rtrim($GLOBALS['Nav'], ' |');
			$GLOBALS['SmallNav'] = rtrim($GLOBALS['SmallNav'], ' |');
			$GLOBALS['TotalOrdersSS']=$numOrders;
			$GLOBALS['SearchQuery'] = $query;
			$GLOBALS['SortField'] = $sortField;
			$GLOBALS['SortOrder'] = $sortOrder;

			$sortLinks = array(
				"Id" => "orderid",
				"Cust" => "custname",
				"Date" => "orddate",
				"Status" => "ordstatus",
				"Message" => "newmessages",
				"Total" => "ordtotalamount"
			);
			BuildAdminSortingLinks($sortLinks, "index.php?ToDo=viewSales&amp;".$searchURL."&amp;page=".$page, $sortField, $sortOrder);

			// Workout the maximum size of the array
			$max = $start + ISC_ORDERS_PER_PAGE;

			if ($max > count($orderResult)) {
				$max = count($orderResult);
			}

			if(!gzte11(ISC_LARGEPRINT)) {
				$GLOBALS['HideOrderMessages'] = "none";
				$GLOBALS['CustomerNameSpan'] = 2;
			}

			// Display the orders
			while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($orderResult)) {
				$GLOBALS['OrderId'] = $row['orderid'];
				$GLOBALS['CustomerId'] = $row['ordcustid'];
				$GLOBALS['OrderId1'] = $row['orderid'];
				$GLOBALS['Customer'] = isc_html_escape($row['custname']);

				$GLOBALS['Date'] = isc_date(GetConfig('DisplayDateFormat'), $row['orddate']);
				$GLOBALS['OrderStatusOptions'] = $this->GetOrderStatusOptions($row['ordstatus']);

				$GLOBALS['Total'] = FormatPriceInCurrency($row['ordtotalamount'], $row['orddefaultcurrencyid'], null, true);
				$GLOBALS['TrackingNo'] = isc_html_escape($row['ordtrackingno']);
				
				switch($row['ordoverview']){
					case 0:
						$orderreview = GetLang('OviewRequestNo');
						break;
					case 1:
						$orderreview = GetLang('OviewRequestYes');
						break;
					case 2:
						$orderreview = GetLang('OviewRequestSure');
						break;
					default:
						$orderreview = GetLang('OviewRequestNo');
						break;
					
				}
				$GLOBALS['Review'] = $orderreview;

				// Look up the country for the IP address of this order
				if(gzte11(ISC_LARGEPRINT)) {
					$suspiciousOrder = false;
					$GLOBALS['FlagCellClass'] = $GLOBALS['FlagCellTitle'] = '';
					if($row['ordgeoipcountrycode'] != '') {
						$flag = strtolower($row['ordgeoipcountrycode']);
						// If the GeoIP based country code and the billing country code don't match, we flag this order as a different colour
						if(strtolower($row['ordgeoipcountrycode']) != strtolower($row['ordbillcountrycode'])) {
							$GLOBALS['FlagCellClass'] = "Suspicious";
							$suspiciousOrder = true;

						}
						$countryName = $row['ordgeoipcountry'];
					}
					else {
						$flag = strtolower($row['ordbillcountrycode']);
						$countryName = $row['ordbillcountry'];
						$GLOBALS['FlagCellTitle'] = $row['ordbillcountry'];
					}
					// Do we have a country flag to show?
					if(file_exists(ISC_BASE_PATH."/lib/flags/".$flag.".gif")) {
						$flag = GetConfig('AppPath')."/lib/flags/".$flag.".gif";
						if($suspiciousOrder == true) {
							$title = sprintf(GetLang('OrderCountriesDontMatch'), $row['ordbillcountry'], $row['ordgeoipcountry']);
							$GLOBALS['OrderCountryFlag'] = "<span onmouseout=\"HideQuickHelp(this);\" onmouseover=\"ShowQuickHelp(this, '".GetLang('PossibleFraudulentOrder')."', '".$title."');\"><img src=\"".$flag."\" alt='' /></span>";
						}
						else {
							$GLOBALS['OrderCountryFlag'] = "<img src=\"".$flag."\" alt='' title=\"".$countryName."\" />";
						}
					}
					else {
						$GLOBALS['OrderCountryFlag'] = '';
					}
				}
				else {
					$GLOBALS['HideCountry'] = "none";
				}

				// Workout the message link -- do they have permission to view order messages?
				$GLOBALS["HideMessages"] = "none";

				if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Order_Messages) && $row['ordcustid'] > 0) {
					$numMessages = GetLang('Messages');
					if($row['nummessages'] == 1) {
						$numMessages = GetLang('OrderMessage');
					}
					$newMessages = '0 '.GetLang('NewText');
					if($row['newmessages'] > 0) {
						$newMessages = "<strong>" . $row['newmessages'] . " " . GetLang('NewText') . "</strong>";
					}
					$GLOBALS['MessageLink'] = sprintf("<a title='%s' class='Action' href='index.php?ToDo=viewOrderMessages&amp;ord
					erId=%d'>%s %s</a><br />(%s)",
						GetLang('MessageOrder'),
						$row['orderid'],
						$row['nummessages'],
						$numMessages,
						$newMessages
					);

					if($row["numunreadmessages"] > 0 && gzte11(ISC_LARGEPRINT)) {
						$GLOBALS["HideMessages"] = "";
						$GLOBALS["NumMessages"] = $row['numunreadmessages'];
					}
				}
				else {
					$GLOBALS['MessageLink'] = sprintf("<a class='Action' disabled>%s (0)</a>", GetLang('Messages'));
				}

				if(!gzte11(ISC_LARGEPRINT)) {
					$GLOBALS["HideMessages"] = "none";
				}

				// If the customer still exists, link to the customer page
				if(trim($row['custname']) != '') {
					$GLOBALS['CustomerLink'] = "<a href='index.php?ToDo=viewCustomers&amp;idFrom=".$GLOBALS['CustomerId']."&idTo=".$GLOBALS['CustomerId']."'>".$GLOBALS['Customer']."</a>";
				}
				else {
					$GLOBALS['CustomerLink'] = $row['ordbillfirstname'].' '.$row['ordbilllastname'];
				}

				if($row['ordcustid'] == 0) {
					$GLOBALS['CustomerLink'] .= " <span style=\"color: gray;\">".GetLang('GuestCheckoutCustomer')."</span>";
				}

				// If the order has any notes, flag it
				if($row['ordnotes'] != '') {
					$GLOBALS['HasNotesClass'] = 'HasNotes';
				}
				else {
					$GLOBALS['HasNotesClass'] = '';
				}

				// If the order has any shipable items, show the link to ship items
				$GLOBALS['ShipItemsLink'] = '';
				if (isset($row['ordtotalshipped']) && isset($row['ordtotalqty'])) {
					if($row['ordisdigital'] == 0 && ($row['ordtotalqty']-$row['ordtotalshipped']) > 0) {
						$GLOBALS['ShipItemsLink'] = '<option id="ShipItemsLink'.$row['orderid'].'"  value="shipItems">'.GetLang('ShipItems').'</option>';
					}
				}


				//Show payment status blow order status
				$GLOBALS['PaymentStatus'] = '';
				$GLOBALS['HidePaymentStatus'] = 'display:none;';
				$GLOBALS['PaymentStatusColor'] = '';
				if($row['ordpaymentstatus'] != '') {
					$GLOBALS['HidePaymentStatus'] = '';
					$GLOBALS['PaymentStatusColor'] = '';
					switch($row['ordpaymentstatus']) {
						case 'authorized':
							$GLOBALS['PaymentStatusColor'] = 'PaymentAuthorized';
							break;
						case 'captured':
							$GLOBALS['PaymentStatus'] = GetLang('Payment')." ".ucfirst($row['ordpaymentstatus']);
							$GLOBALS['PaymentStatusColor'] = 'PaymentCaptured';
							break;
						case 'refunded':
						case 'partially refunded':
						case 'voided':
							$GLOBALS['PaymentStatus'] = GetLang('Payment')." ".ucwords($row['ordpaymentstatus']);
							$GLOBALS['PaymentStatusColor'] = 'PaymentRefunded';
							break;
					}
				}


				// If the allow payment delayed capture, show the link to Delayed capture
				$GLOBALS['DelayedCaptureLink'] = '';
				$GLOBALS['VoidLink'] = '';
				$GLOBALS['RefundLink'] ='';
				$transactionId = trim($row['ordpayproviderid']);

				//if orginal transaction id exist and payment provider is currently enabled
				if($transactionId != '' && GetModuleById('checkout', $provider, $row['orderpaymentmodule']) && $provider->IsEnabled() && !gzte11(ISC_HUGEPRINT)) {
					//if the payment module allow delayed capture and the current payment status is authorized
					//display delay capture option
					if(method_exists($provider, "DelayedCapture") && $row['ordpaymentstatus'] == 'authorized') {
						$GLOBALS['DelayedCaptureLink'] = '<option value="delayedCapture">'.GetLang('CaptureFunds').'</option>';

						$GLOBALS['PaymentStatus'] .= '<a onclick="Order.DelayedCapture('.$row['orderid'].'); return false;" href="#">'.GetLang('CaptureFunds').'</a>';
					}

					//if the payment module allow void transaction and the current payment status is authorized
					//display void option
					if(method_exists($provider, "DoVoid") && $row['ordpaymentstatus'] == 'authorized') {
						$GLOBALS['VoidLink'] = '<option value="voidTransaction">'.GetLang('VoidTransaction').'</option>';
					}

					//if the payment module allow refund and the current payment status is authorized
					//display refund option
					if(method_exists($provider, "DoRefund") && ($row['ordpaymentstatus'] == 'captured' || $row['ordpaymentstatus'] == 'partially refunded')) {
						$GLOBALS['RefundLink'] = '<option value="refundOrder">'.GetLang('Refund').'</option>';
					}
				}

				$GLOBALS["OrderStatusText"] = GetOrderStatusById($row['ordstatus']);
				$GLOBALS['OrderStatusId'] = $row['ordstatus'];
				$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("sales.manage.row");
				$GLOBALS['OrderGrid'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
			}

			// Close the GeoIP database if we used it
			if(isset($gi)) {
				geoip_close($gi);
			}

			// Hide the message box in templates/iphone/MessageBox.html if we're not searching
			if(!isset($_REQUEST["searchQuery"]) && isset($_REQUEST["page"])) {
				$GLOBALS["HideYellowMessage"] = "none";
			}

			$GLOBALS['CurrentPage'] = $page;

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("sales.manage.grid");
			return $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
		}

		// Render the Datepicker widget -- Baskaran
        /**
         * Generate HTML snippets for date picker
         * @param unknown_type $elementId
         * @param unknown_type $currentValue
         */
        private function getDatePickerHtml($elementId, $elementName, $currentValue) {
            return "<input type='text' id='$elementId' name='$elementName' readonly='true' class='datepicker' value='$currentValue'>";
        }

		private function ManageOrders($MsgDesc = "", $MsgStatus = "")
		{
			
			/* For Date range -- Baskaran */
            if(isset($_POST['Calendar'])) {
                $calendarInfo = NULL;
                if (isset($_POST['Calendar']['DateType'])) {
                    $GLOBALS['CurrentDate'] = $_POST['Calendar']['DateType'];
                    $calendarInfo['DateType'] = $GLOBALS['CurrentDate'];
                    if(isset($_POST['Calendar']['From'])) {
                        $datestamp = strtotime($_POST['Calendar']['From']);
                        $calendarInfo['From']['Yr'] = gmdate('Y', $datestamp);
                        $calendarInfo['From']['Mth'] = gmdate('m', $datestamp);
                        $calendarInfo['From']['Day'] = gmdate('d', $datestamp);
                    }
                    if(isset($_POST['Calendar']['To'])){
                        $datestamp = strtotime($_POST['Calendar']['To']);
                        $calendarInfo['To']['Yr'] = gmdate('Y', $datestamp);
                        $calendarInfo['To']['Mth'] = gmdate('m', $datestamp);
                        $calendarInfo['To']['Day'] = gmdate('d', $datestamp);
                    }
                    else {
                        
                        $GLOBALS['CurrentDate'] = "Last24Hours";
                        $calendarInfo['DateType'] = $GLOBALS['CurrentDate'];
                    }
                }
            $cal = $this->CalculateCalendarRestrictions($calendarInfo);
            $GLOBALS['CurrentDate'] = $_POST['Calendar']['DateType'];
            }
            else {
                $cal = $this->CalculateCalendarRestrictions();
                $GLOBALS['CurrentDate'] = "Last24Hours";
            }

            if ($MsgDesc != "") {
                $GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
            }

            $GLOBALS['CalendarDateTypeOptions'] = $this->_GetCalendarDateTypesAsOptions($GLOBALS['CurrentDate']);

            // Set the global variables for the select boxes
            $from_stamp = $cal['start'];
            $to_stamp = $cal['end'];

            $from_days = $from_stamp / 86400;
            $to_days = $to_stamp / 86400;
            $num_days = floor($to_days - $from_days)+1;

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

            // Set the from and to date stamps
            $GLOBALS['OverviewFromStamp'] = $cal['start'];
            $GLOBALS['OverviewToStamp'] = $cal['end'];

            /*if(isset($_POST['currentTab'])) {
                $GLOBALS['CurrentTab'] = (int)$_POST['currentTab'];
            }
            else {
                $GLOBALS['CurrentTab'] = 0;
            }*/

            $GLOBALS['FromStamp'] = $from_stamp;
            $GLOBALS['ToStamp'] = $to_stamp;
            
            //zfang_20100623: Showing date range seletion
            $GLOBALS['FromDatePicker'] = $this->getDatePickerHtml("fromPicker", "Calendar[From]", isc_date('m/d/Y', $from_stamp));
            $GLOBALS['ToDatePicker'] = $this->getDatePickerHtml("toPicker", "Calendar[To]", isc_date('m/d/Y', $to_stamp));

			/* Code Ends */

			$GLOBALS['HideClearResults'] = "none";
			$status = array();
			$num_custom_searches = 0;
			$numOrders = 0;

			// Fetch any results, place them in the data grid
			
			if(isset($_REQUEST['searchQuery']) && $_REQUEST['searchQuery']!='') {
				
				$VendorID=$_REQUEST['searchQuery'];
			}
			else {
				$VendorID=-1;
			}
			$GLOBALS['VendorList'] = $this->GenerateVendorList($VendorID);
			$GLOBALS['CurrentVendor'] = $this->GenerateVendorName($VendorID);
			
			if(isset($_REQUEST['CurrentVendor'])) {
				$GLOBALS['AJAXVALUE']='
							ShowTab(1);';
			}
			else {
				echo '';				
			}
			
			$GLOBALS['OrderDataGrid'] = $this->ManageOrdersGrid($numOrders);
			$GLOBALS['UserDataGrid'] = $this->ManageOverViewGrid($numView);

			// Was this an ajax based sort? Return the table now
			if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 1) {
				echo $GLOBALS['OrderDataGrid'];
				return;
			}

			if(isset($_REQUEST['searchQuery']) || isset($_GET['searchId'])) {
				$GLOBALS['HideClearResults'] = "";
			}

			if(isset($this->_customSearch['searchname'])) {
				$GLOBALS['ViewName'] = $this->_customSearch['searchname'];
			}
			else {
				$GLOBALS['ViewName'] = GetLang('AllOrders');
				$GLOBALS['HideDeleteViewLink'] = "none";
			}

			//zfang

			// Get the custom search as option fields
			$GLOBALS['CustomSearchOptions'] = $GLOBALS['ISC_CLASS_ADMIN_CUSTOMSEARCH']->GetSearchesAsOptions($_REQUEST['searchId'], $num_custom_searches, "AllOrders", "viewOrders", "customOrderSearch");

			if(!isset($_REQUEST['searchId'])) {
				$GLOBALS['HideDeleteCustomSearch'] = "none";
			} else {
				$GLOBALS['CustomSearchId'] = (int)$_REQUEST['searchId'];
			}

			$GLOBALS['OrderIntro'] = GetLang('ManageOrdersIntro');
			$GLOBALS['Message'] = '';
			// No orders
			if($numOrders == 0) {
				$GLOBALS['DisplayGrid'] = "none";

				// Performing a search of some kind
				if(count($_GET) > 1) {
					if ($MsgDesc == "") {
						$GLOBALS['Message'] = MessageBox(GetLang('NoOrderResults'), MSG_ERROR);
					}
				} else {
					$GLOBALS['Message'] = MessageBox(GetLang('NoOrders'), MSG_SUCCESS);
					$GLOBALS['DisplaySearch'] = "none";
				}
			}

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("sales.manage");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();

		}
		
		
		function ManageOverViewGrid(&$numView) {
			$page = 0;
			$start = 0;
			$numPages = 0;
			$max = 0;
			if (isset($_GET['page'])) {
				$page = (int)$_GET['page'];
			} else {
				$page = 1;
			}

			if ($page == 1) {
				$start = 1;
			} else {
				$start = ($page * ISC_ORDERS_PER_PAGE) - (ISC_ORDERS_PER_PAGE-1);
			}

			$start = $start-1;
			
			// Get the results for the query
			$viewResult = $this->_GetOverViewList($start,$numView);

			$numPages = ceil($numView / ISC_ORDERS_PER_PAGE);


			// Add the "(Page x of n)" label
			if($numView > ISC_ORDERS_PER_PAGE) {
				$GLOBALS['Nav'] = sprintf("(%s %d of %d) &nbsp;&nbsp;&nbsp;", GetLang('Page'), $page, $numPages);

				$GLOBALS['Nav'] .= BuildPagination($numView, ISC_ORDERS_PER_PAGE, $page, sprintf("index.php?ToDo=viewSales%s", $sortURL));
			}
			else {
				$GLOBALS['Nav'] = "";
			}

			if(isset($_GET['searchQuery'])) {
				$query = $_GET['searchQuery'];
			} else {
				$query = "";
			}

			$GLOBALS['Nav'] = rtrim($GLOBALS['Nav'], ' |');
			$GLOBALS['SmallNav'] = rtrim($GLOBALS['SmallNav'], ' |');
			$GLOBALS['TotalOrdersSS']=$numView;
			$GLOBALS['SearchQuery'] = $query;
			$GLOBALS['SortField'] = $sortField;
			$GLOBALS['SortOrder'] = $sortOrder;

			$sortLinks = array(
				"Id" => "orderid",
				"Cust" => "custname",
				"Date" => "orddate",
				"Status" => "ordstatus",
				"Message" => "newmessages",
				"Total" => "ordtotalamount"
			);
			BuildAdminSortingLinks($sortLinks, "index.php?ToDo=viewSales&amp;".$searchURL."&amp;page=".$page, $sortField, $sortOrder);

			// Workout the maximum size of the array
			$max = $start + ISC_ORDERS_PER_PAGE;

			if ($max > count($orderResult)) {
				$max = count($orderResult);
			}
		
			$from = $GLOBALS['FromStamp'];
            $to   = $GLOBALS['ToStamp'];
		
			
			$Query="SELECT us.username, os.statusid, os.statusdesc
							FROM  `isc_users` us
					LEFT JOIN isc_orders od ON us.`pk_userid` = od.orderowner
					LEFT JOIN isc_order_status os ON os.statusid = od.ordstatus
					WHERE od.orddate >= '$from' AND od.orddate <='$to'
					ORDER BY us.username";
			
			$orderResult=$GLOBALS['ISC_CLASS_DB']->Query($Query);
			
			/*************************************************************************
				Sample Array : 
				
				orders['mayank']['Completed']=5;
				orders['mayank']['Pending']=10;
				orders['mayank']['Return']=2;
				orders['mayank']['Cancelled']=4;
			/***************************************************************************/
			
			$orders=array();
		
			while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($orderResult)) {
				$orders[$row['username']]['dump']='';
				if($row['statusid']=='10') { # Completed
					$orders[$row['username']]['Completed']++;
					
				}
				else  {
				
				if($row['statusid']=='5') { # Cancelled
					$orders[$row['username']]['Cancelled']++;
				}
				else {
				if($row['statusid']=='6' || $row['statusid']=='4' || $row['statusid']=='15' || $row['statusid']=='16') {  # Returned
					$orders[$row['username']]['Returned']++;
				}
				else {
				
				
				if($row['statusid']=='1' || $row['statusid']=='2' || $row['statusid']=='3' || $row['statusid']=='7' || $row['statusid']=='8' || $row['statusid']=='9' || $row['statusid']=='11') { #Pending
				
					$orders[$row['username']]['Pending']++;
				}
				
				}
				}
		}
			}#while
			
			
			$Query="SELECT username FROM isc_users order by username";
			$userResult=$GLOBALS['ISC_CLASS_DB']->Query($Query);
			while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($userResult)) {
				
				$GLOBALS["UserName"] = $row['username'];
				$GLOBALS['Completed'] = (isset($orders[$row['username']]['Completed'])?$orders[$row['username']]['Completed']:0);
				$GLOBALS["Cancelled"] = (isset($orders[$row['username']]['Cancelled'])?$orders[$row['username']]['Cancelled']:0);
				$GLOBALS['Pending'] =  (isset($orders[$row['username']]['Pending'])?$orders[$row['username']]['Pending']:0);
				$GLOBALS['Returned'] = (isset($orders[$row['username']]['Returned'])?$orders[$row['username']]['Returned']:0);
				
				$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("sales.manage.overview.row");
				$GLOBALS['OrderOverviewGrid'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
				
			}
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("sales.manage.overview.grid");
			return $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
						
		}#ManageOverViewGrid
		
		
		/*
			function to get orderlist according to condition
		*/
		public function _GetOverViewList($Start, &$numView, $AddLimit=true)
		{
			$extraFields = '';
			$extraJoins = '';

			// Return an array containing details about orders.
			$query = "SELECT * FROM [|PREFIX|]users";

			$countQuery = "SELECT COUNT(pk_userid) FROM [|PREFIX|]users";
			
			// Are there any search parameters?
			$queryWhere = '';

			$query .= " WHERE 1=1 ";
			$countQuery .= " WHERE 1=1 ";

			// How many results do we have?
			$result = $GLOBALS['ISC_CLASS_DB']->Query($countQuery);
			$numView = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);

			// Add the limit
			if($AddLimit) {
				$query .= $GLOBALS['ISC_CLASS_DB']->AddLimit($Start, ISC_ORDERS_PER_PAGE);
			}

			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			if($GLOBALS['ISC_CLASS_DB']->CountResult($result) == 0) {
				$GLOBALS['HideViewAllLink'] = 'none';
			}
			return $result;
		}
		
		/*
			function to get orderlist according to condition
		*/
		public function _GetOrderList($Start, $SortField, $SortOrder, &$NumOrders, $AddLimit=true)
		{
			$extraFields = '';
			$extraJoins = '';

			if(isset($_REQUEST['couponCode']) && trim($_REQUEST['couponCode']) != '') {
				$extraFields = 'DISTINCT(co.ordcouporderid), ';
				$extraJoins = sprintf("INNER JOIN [|PREFIX|]order_coupons co ON (co.ordcouporderid=o.orderid AND co.ordcouponcode='%s')", $GLOBALS['ISC_CLASS_DB']->Quote($_REQUEST['couponCode']));
			}

			// Return an array containing details about orders.
			$query = sprintf("
				SELECT %so.*, c.*, s.statusdesc AS ordstatustext, CONCAT(custconfirstname, ' ', custconlastname) AS custname
					
				FROM [|PREFIX|]orders o
				LEFT JOIN [|PREFIX|]customers c ON (o.ordcustid=c.customerid)
				LEFT JOIN [|PREFIX|]order_status s ON (s.statusid=o.ordstatus)
				%s", $extraFields, $extraJoins);

			$countQuery = "SELECT COUNT(o.orderid) FROM [|PREFIX|]orders o";
			if (!empty($extraJoins)) {
				$countQuery .= ' '.$extraJoins;
			}

			// Are there any search parameters?
			$queryWhere = '';

			$res = $this->BuildWhereFromVars($_REQUEST);
			$queryWhere .= $res["query"];
			$countQuery .= $res["count"];

			// Only fetch products which belong to the current vendor
			if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
				$queryWhere .= " AND ordvendorid='".(int)$GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()."'";
			}

			$query .= " WHERE 1=1 ".$queryWhere;
			$countQuery .= " WHERE 1=1 ".$queryWhere;

			// Only those with new messages?
			if(isset($_REQUEST['newMessages'])) {
				$query .= " HAVING newmessages >= 1";
			}

			// How many results do we have?
			$result = $GLOBALS['ISC_CLASS_DB']->Query($countQuery);
			$NumOrders = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);

			// Add the limit
			$query .= sprintf(" order by %s %s", $SortField, $SortOrder);
			if($AddLimit) {
				$query .= $GLOBALS['ISC_CLASS_DB']->AddLimit($Start, ISC_ORDERS_PER_PAGE);
			}

			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			if($GLOBALS['ISC_CLASS_DB']->CountResult($result) == 0) {
				$GLOBALS['HideViewAllLink'] = 'none';
			}
			return $result;
		}

		/**
		* Builds a where statement for order listing based on values in an array
		*
		* @param mixed $array
		* @return mixed
		*/
		public function BuildWhereFromVars($array)
		{
			$queryWhere = "";
			$countQuery = "";
			if(isset($array['searchQuery']) && $array['searchQuery'] != "" && $array['searchQuery'] != '-1') {
				$search_query = $GLOBALS['ISC_CLASS_DB']->Quote($array['searchQuery']);
				$queryWhere .= " AND orderowner <> '-1' AND (orderowner='".$search_query."') ";
				$countQuery .= " LEFT JOIN [|PREFIX|]customers c ON (o.ordcustid=c.customerid)";
				
			}

			if(isset($array['orderStatus']) && $array['orderStatus'] != "") {
				$order_status = $GLOBALS['ISC_CLASS_DB']->Quote((int)$array['orderStatus']);
				$queryWhere .= sprintf(" AND ordstatus='%d'", $order_status);
			}
			// Otherwise, only fetch complete orders
			else {
				$queryWhere .= "AND orderowner <>'-1' AND ordstatus > 0";
			}
			return array("query" => $queryWhere,  "count" => $countQuery);
		}

		
		public function BuildOrderAddressDetails($address, $includeFlag=true)
		{
			if(!isset($address['countrycode'])) {
				$address['countrycode'] = GetCountryISO2ByName($address['shipcountry']);
			}

			$countryFlag = '';
			if($includeFlag && $address['countrycode'] != '' && file_exists(ISC_BASE_PATH."/lib/flags/".strtolower($address['countrycode']).".gif")) {
				$countryFlag = "
					&nbsp;&nbsp;
					<img src=\"".GetConfig('AppPath')."/lib/flags/".strtolower($address['countrycode']).".gif\" style=\"vertical-align: middle;\" alt=\"\" />
				";
			}

			$addressPieces = array(
				isc_html_escape($address['shipfirstname']).' '.isc_html_escape($address['shiplastname']),
				isc_html_escape($address['shipcompany']),
				isc_html_escape($address['shipaddress1']),
				isc_html_escape($address['shipaddress2']),
				trim(isc_html_escape($address['shipcity'].', '.$address['shipstate'].' '.$address['shipzip']), ', '),
				isc_html_escape($address['shipcountry']).$countryFlag
			);

			$addressDetails = '';
			foreach($addressPieces as $piece) {
				if(!trim($piece)) {
					continue;
				}
				else if($addressDetails) {
					$addressDetails .= '<br />';
				}
				$addressDetails .= $piece;
			}
			return $addressDetails;
		}
		
			function fn_getYMMOptions($params,$ymm_type) 
        {
            switch($ymm_type)
            {
                case 'year'        :     
                                    $options = "<option value=''>--select year--</option>";
                                    $filter_array = array();
                                    $ymm_qry = "select group_concat(v.prodstartyear separator '~') as prodstartyear , group_concat(v.prodendyear separator '~') as prodendyear from [|PREFIX|]products p LEFT JOIN [|PREFIX|]import_variations AS v ON v.productid = p.productid where p.prodvisible='1' ";
                                    if( isset($params['make']) && $GLOBALS['UniversalCat'] == 0 )
                                        $ymm_qry .= " and prodmake = '".$params['make']."' ";
                                    if( isset($params['model']) && (!isset($params['model_flag']) || $params['model_flag'] == 1) && $GLOBALS['UniversalCat'] == 0 )
                                        $ymm_qry .= " and prodmodel = '".$params['model']."' ";

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
                                                for($i=0;$i
<=$prod_year_diff;$i++)
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
                                        $selected = "";
                                        if ( isset($params['year']) && strcasecmp($params['year'], $value) == 0 )
                                            $selected = " selected";

                                        $options .= "
<option value='".MakeURLSafe(strtolower($value))."'$selected>$value</option>
";
                                    }
                                    break;
                case 'make'        : 
                                    $options = "
<option value=''>--select make--</option>
";
                                    $filter_array = array();
                                    $ymm_qry = "select group_concat(DISTINCT v.prodmake separator '~') as prodmake from [|PREFIX|]products p LEFT JOIN [|PREFIX|]import_variations AS v ON v.productid = p.productid where p.prodvisible='1' ";

                                    $ymm_res = $GLOBALS['ISC_CLASS_DB']->Query($ymm_qry);
                                    while($ymm_row = $GLOBALS['ISC_CLASS_DB']->Fetch($ymm_res))
                                    {
                                        $filters = explode('~',$ymm_row['prodmake']);
                                        for($j=0;$j<count($filters);$j++) 
                                        {
                                            $filter_value = $filters[$j]; 
                                            if(strtoupper($filter_value) != "NON-SPEC VEHICLE" && strtolower($filter_value) != "all")
                                            {
                                                if(in_array($filter_value,$filter_array))   {
                                                    $count_filter_array[$filter_value]++;
                                                } else {
                                                    $filter_array[] = $filter_value;
                                                    $count_filter_array[$filter_value] = 1;
                                                }
                                            }
                                        }
                                    }
                                    sort($filter_array);
                                    $all_makes = array('CHEVROLET', 'GMC', 'FORD', 'DODGE', 'TOYOTA', 'NISSAN', 'HONDA', 'JEEP', 'HYUNDAI','CHRYSLER', 'INFINITI', 'LEXUS');
                                    $temp_arr =  array_diff($filter_array,$all_makes);

                                    foreach($all_makes as $key => $value) 
                                    {
                                        $selected = "";
                                        if ( isset($params['make']) && strcasecmp($params['make'], $value) == 0 )
                                            $selected = " selected";        
                                        
                                        $options .= "
<option value='".MakeURLSafe(strtolower($value))."'$selected>$value</option>
"; 
                                    }

                                    foreach($temp_arr as $key => $value ) 
                                    {
                                        $selected = "";
                                        if ( isset($params['make']) && strcasecmp($params['make'], $value) == 0 )
                                            $selected = " selected";        

                                        $options .= "
<option value='".MakeURLSafe(strtolower($value))."'$selected>$value</option>
";
                                    }
                                    break;
                case 'model'    : 
                                    $options = "
<option value=''>--select model--</option>
";
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

                                            $options .= "
<option value='".MakeURLSafe(strtolower($value))."'$selected>$value</option>
";
                                        }
                                    }
                                    break;
            }
            return $options;
        }#fn_getYMMOptions
		
		
		function fn_fecthorderymm($orderID) {
			
			$clarion_entity = new ISC_ADMIN_CLARION();
			$clarion_entity->fn_fetchOrderYMM($orderID);
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate('customerexisting.YMM.row');
			return $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate(true);
			
		}
		
		/*
			function to generate the vendor list for select tag on the page.
		*/
		function GenerateVendorList($VendorID) {
			
			$query="SELECT * FROM [|PREFIX|]users";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			
			if($VendorID==0)
				$ret_str='<option value="-1" selected="selected">All Users</option>';
			else
				$ret_str='<option value="-1">All Users</option>';
			
			while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				if($VendorID==$row['pk_userid'])
					$ret_str.='<option value="'.$row['pk_userid'].'" selected="selected">'.$row['username'].'</option>';
				else
					$ret_str.='<option value="'.$row['pk_userid'].'">'.$row['username'].'</option>';
					
			}
			return $ret_str;
		}#GenerateVendorList
		
		/*
			function to fetch the name of selected user in the drop down.
		*/				
		function GenerateVendorName($VendorID) {
			
			if($VendorID=='-1') {
				return 'All';
			} 
			else {
				$query="SELECT * FROM [|PREFIX|]users WHERE pk_userid='".$VendorID."'";
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
				return $row['username'];
			}
			
				
			return $ret_str;
		}#GenerateVendorName
		
		public function GetOrderStatusOptions($SelectedStatus = null)
		{
			// Get all order status options from the database
			static $statuses = null;
			$output = "";

			// Only do the database query the first time
			if ($statuses === null) {
				$statuses = array();
				if($SelectedStatus === 0 || $SelectedStatus === '0') {
					$statuses[] = array(
						"statusid" => 0,
						"statusdesc" => GetLang('Incomplete')
					);
				}
				$query = "select statusid, statusdesc from [|PREFIX|]order_status order by statusorder asc";
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					$statuses[] = $row;
				}
			}

			foreach ($statuses as $row) {
				// Only show the 0 status if it's our current status
				if($row['statusid'] == 0 && $SelectedStatus != 0) {
					continue;
				}
				if ($row['statusid'] == $SelectedStatus) {
					return $row['statusdesc'];
				} 

			}

		
		}
	}
?>