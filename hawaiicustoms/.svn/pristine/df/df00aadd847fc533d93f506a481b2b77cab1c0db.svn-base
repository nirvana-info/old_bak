<?php
	class ISC_ADMIN_ORDERS
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

		public function HandleToDo($Do)
		{
			$GLOBALS['BreadcrumEntries'] = array(
				GetLang('Home') => "index.php",
				GetLang('Orders') => 'index.php?ToDo=viewOrders'
			);

			switch (isc_strtolower($Do))
			{
				case 'saveneworder':
					$this->SaveNewOrder();
					break;
				case 'saveupdatedorder':
					$this->SaveUpdatedOrder();
					break;
				case "addorder":
					$this->AddOrder();
					break;
				case 'editorder':
					$this->EditOrder();
					break;
				case "createorderview":
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Orders)) {
						$GLOBALS['BreadcrumEntries'][GetLang('CreateOrderView')] = "index.php?ToDo=createOrderView";
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->CreateView();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				case "printmultiorderinvoices":
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Orders)) {
						$this->PrintMultiInvoices();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				case "deletecustomordersearch":
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Orders)) {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->DeleteCustomSearch();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				case "customordersearch":
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Orders)) {
						$GLOBALS['BreadcrumEntries'][GetLang('CustomView')] = "index.php?ToDo=customOrderSearch";
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->CustomSearch();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				case "searchordersredirect":
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Orders)) {
						$GLOBALS['BreadcrumEntries'][GetLang('SearchResults')] = "index.php?ToDo=searchOrders";
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->SearchOrdersRedirect();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				case "searchorders":
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Orders)) {
						$GLOBALS['BreadcrumEntries'][GetLang('SearchResults')] = "index.php?ToDo=searchOrders";
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->SearchOrders();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				case "saveupdatedordermessage":
					if(!gzte11(ISC_LARGEPRINT)) {
						exit;
					}
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Order_Messages)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Orders') => "index.php?ToDo=viewOrders", GetLang('ViewMessages') => "index.php?ToDo=saveUpdatedOrderMessage");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->SavedUpdatedOrderMessage();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				case "editordermessage":
					if(!gzte11(ISC_LARGEPRINT)) {
						exit;
					}
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Order_Messages)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Orders') => "index.php?ToDo=viewOrders", GetLang('ViewMessages') => "index.php?ToDo=viewOrderMessages&orderId=" . @(int)$_GET['orderId'], GetLang('EditMessage') => "index.php?ToDo=editOrderMessage");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->EditOrderMessage();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				case "savenewordermessage":
					if(!gzte11(ISC_LARGEPRINT)) {
						exit;
					}
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Order_Messages)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Orders') => "index.php?ToDo=viewOrders", GetLang('ViewMessages') => "index.php?ToDo=saveUpdatedOrderMessage");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->SaveNewOrderMessage();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				case "createordermessage":
					if(!gzte11(ISC_LARGEPRINT)) {
						exit;
					}
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Order_Messages)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Orders') => "index.php?ToDo=viewOrders", GetLang('ViewMessages') => "index.php?ToDo=viewOrderMessages&orderId=" . @(int)$_GET['orderId'], GetLang('CreateMessage') => "index.php?ToDo=createOrderMessage");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->CreateOrderMessage();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				case "deleteordermessages":
					if(!gzte11(ISC_LARGEPRINT)) {
						exit;
					}
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Order_Messages)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Orders') => "index.php?ToDo=viewOrders", GetLang('ViewMessages') => "index.php?ToDo=saveUpdatedOrderMessage");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->DeleteOrderMessages();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				case "flagordermessage":
					if(!gzte11(ISC_LARGEPRINT)) {
						exit;
					}
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Order_Messages)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Orders') => "index.php?ToDo=viewOrders", GetLang('ViewMessages') => "index.php?ToDo=viewOrderMessages");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->FlagOrderMessage();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				case "updateordermessagestatus":
					if(!gzte11(ISC_LARGEPRINT)) {
						exit;
					}
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Order_Messages)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Orders') => "index.php?ToDo=viewOrders", GetLang('ViewMessages') => "index.php?ToDo=viewOrderMessages");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->UpdateOrderMessageStatus();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				case "viewordermessages":
					if(!gzte11(ISC_LARGEPRINT)) {
						exit;
					}
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Order_Messages)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Orders') => "index.php?ToDo=viewOrders", GetLang('ViewMessages') => "index.php?ToDo=viewOrderMessages");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->ViewOrderMessages();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				case "deleteorders":
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Delete_Orders)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Orders') => "index.php?ToDo=viewOrders");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->DeleteOrders();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				case "printorderinvoice":
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Orders)) {
						$this->PrintInvoice();
					} else {
						echo "<script type=\"text/javascript\">window.close();</script>";
					}
					break;
				case "importordertrackingnumbers":
					if(gzte11(ISC_MEDIUMPRINT)) {
						if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Import_Order_Tracking_Numbers)) {
							if (!gzte11(ISC_MEDIUMPRINT)) {
								exit;
							}
							$this->ImportTrackingNumbers();
						} else {
							$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
						}
					}
					break;
				case "viewsingleorder":
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Orders)) {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$output = ISC_ADMIN_REMOTE::GetOrderQuickView();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						echo $output;
					}
					break;
				case "updatemultiorderstatus":
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Orders)) {
						$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("pageheader.popup");
						$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
						$this->updateOrderStatusBox();
						$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("pagefooter.popup");
						$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				case "refundorder":
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Orders)) {
						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Orders') => "index.php?ToDo=viewOrders");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->RefundOrder();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				/* Added for Save and Pay -- Baskaran */
				case "payorder":
				    if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Orders)) {
					$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Orders') => "index.php?ToDo=viewOrders", GetLang('PayOrder') => "index.php?ToDo=viewOrderMessages");
		
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->payOrder();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
				    } else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
				    }
				    break;  
				case "paymentorder":
				    if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Orders)) {
					$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Orders') => "index.php?ToDo=viewOrders", GetLang('PayOrder') => "index.php?ToDo=viewOrderMessages");
		
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->PaymentOrder();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
				    } else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
				    }
				    break;
				//Wirror_20110301: confirm the order
				case "confirmorder":
				    if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Orders)) {
					$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Orders') => "index.php?ToDo=viewOrders", GetLang('ConfirmOrder') => 'index.php?ToDo=confirmOrder');
		
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->ConfirmOrder();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
				    } else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
				    }
				    break;  
				/* Baskaran */
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

		private function DeleteOrders()
		{
			$queries = array();

			if(isset($_POST['orders'])) {
				// The orders will be removed from the following tables:
				//
				//     - Orders
				//     - Order_Products
				//	   - order_downloads

				// Start a transaction
				$GLOBALS['ISC_CLASS_DB']->Query("START TRANSACTION");

				// What we do here is feed the list of orders IDs in to a query with the vendor applied so that way
				// we're sure we're only deleting orders this user has permission to delete.
				$orderIds = implode("','", array_map('intval', $_POST['orders']));
				$vendorId = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId();
				if($vendorId > 0) {
					$query = "
						SELECT orderid
						FROM [|PREFIX|]orders
						WHERE orderid IN ('".$orderIds."') AND ordvendorid='".(int)$vendorId."'
					";
					$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
					$orderIds = array(0);
					while($order = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
						$orderIds[] = $order['orderid'];
					}
					$orderIds = implode("','", array_map('intval', $orderIds));
				}

				// Start deleting the orders
				$this->_DeleteOrderProductFields($orderIds);
				$GLOBALS['ISC_CLASS_DB']->DeleteQuery('orders', "WHERE orderid IN ('".$orderIds."')");
				$GLOBALS['ISC_CLASS_DB']->DeleteQuery('order_products', "WHERE orderorderid IN ('".$orderIds."')");
				$GLOBALS['ISC_CLASS_DB']->DeleteQuery('order_downloads', "WHERE orderid IN ('".$orderIds."')");
				$GLOBALS['ISC_CLASS_DB']->DeleteQuery('order_messages', "WHERE messageorderid IN ('".$orderIds."')");
				$GLOBALS['ISC_CLASS_DB']->DeleteQuery('order_coupons', "WHERE ordcouporderid IN ('".$orderIds."')");

				$err = $GLOBALS['ISC_CLASS_DB']->GetErrorMsg();

				if ($err != "") {
					$this->ManageOrders($err, MSG_ERROR);
				} else {
					$GLOBALS['ISC_CLASS_DB']->Query("COMMIT");

					// Log this action
					$GLOBALS['ISC_CLASS_LOG']->LogAdminAction(count($orderIds));

					$this->ManageOrders(GetLang('OrdersDeletedSuccessfully'), MSG_SUCCESS);
				}
			} else {
				if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Orders)) {
					$this->ManageOrders();
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
				}
			}
		}

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
			if(isset($_GET['searchId'])) {
				$this->_customSearch = $GLOBALS['ISC_CLASS_ADMIN_CUSTOMSEARCH']->LoadSearch($_GET['searchId']);
				$_REQUEST = array_merge($_REQUEST, (array)$this->_customSearch['searchvars']);

				// Override custom search sort fields if we have a requested field
				if(isset($_GET['sortField'])) {
					$_REQUEST['sortField'] = $_GET['sortField'];
				}
				if(isset($_GET['sortOrder'])) {
					$_REQUEST['sortOrder'] = $_GET['sortOrder'];
				}
			}
			else if(isset($_GET['searchQuery'])) {
				$GLOBALS['Query'] = $_GET['searchQuery'];
			}

			if(isset($_REQUEST['sortOrder']) && $_REQUEST['sortOrder'] == "asc") {
				$sortOrder = "asc";
			}
			else {
				$sortOrder = "desc";
			}

			$validSortFields = array('orderid', 'custname', 'orddate', 'ordstatus', 'newmessages', 'ordtotalamount', 'ordoverview');
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
				//alandy_2012-3-28 add.
				if(isset($_REQUEST['orderOwner']) && $_REQUEST['orderOwner'] != ''){
					$GLOBALS['Nav'] .= BuildPagination($numOrders, ISC_ORDERS_PER_PAGE, $page, sprintf("index.php?ToDo=viewOrders%s&orderOwner=%s", $sortURL, $_REQUEST['orderOwner']));
				}else{
					$GLOBALS['Nav'] .= BuildPagination($numOrders, ISC_ORDERS_PER_PAGE, $page, sprintf("index.php?ToDo=viewOrders%s", $sortURL));
				}
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

			$GLOBALS['SearchQuery'] = $query;
			$GLOBALS['SortField'] = $sortField;
			$GLOBALS['SortOrder'] = $sortOrder;

			$sortLinks = array(
				"Id" => "orderid",
				"Cust" => "custname",
				"Date" => "orddate",
				"Status" => "ordstatus",
				"Message" => "newmessages",
				"Total" => "ordtotalamount",
				"Review" => "ordoverview"
			);
			BuildAdminSortingLinks($sortLinks, "index.php?ToDo=viewOrders&amp;".$searchURL."&amp;page=".$page, $sortField, $sortOrder);

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
                $GLOBALS['GatewayTotal'] = FormatPriceInCurrency($row['ordgatewayamount'], $row['orddefaultcurrencyid'], null, true);
				$GLOBALS['TrackingNo'] = isc_html_escape($row['ordtrackingno']);
				$orderreview='';
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
				$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("order.manage.row");
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

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("orders.manage.grid");
			return $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
		}

		private function ManageOrders($MsgDesc = "", $MsgStatus = "")
		{
			$GLOBALS['HideClearResults'] = "none";
			$status = array();
			$num_custom_searches = 0;
			$numOrders = 0;

			// Fetch any results, place them in the data grid
			$GLOBALS['OrderDataGrid'] = $this->ManageOrdersGrid($numOrders);

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

			// Do we display the add order buton?
			if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Add_Orders)) {
				$GLOBALS['AddOrderButton'] = '<input type="button" value="' . GetLang('AddAnOrder') . '..." class="FormButton" style="width:100px" onclick="document.location.href=\'index.php?ToDo=addOrder\'" /><br /><br />';
			} else {
				$GLOBALS['AddOrderButton'] = '';
			}

			$GLOBALS['OrderActionOptions'] = '<option selected="1">' . GetLang('ChooseAction') . '</option>';

			// Do we need to disable the delete button?
			if (!$GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Delete_Orders) || $numOrders == 0) {
				$args = 'disabled="1"';
			} else {
				$args = 'value="delete"';
			}

			$GLOBALS['OrderActionOptions'] .= '<option ' . $args . '>' . GetLang('DeleteSelected') . '</option>';

			if($numOrders > 0) {
				if($MsgDesc == "" && (isset($_REQUEST['searchQuery']) || isset($_GET['searchId']) || count($_GET) > 1)) {
					if($numOrders == 1) {
						$MsgDesc = GetLang('OrderSearchResultsBelow1');
					}
					else {
						$MsgDesc = sprintf(GetLang('OrderSearchResultsBelowX'), $numOrders);
					}

					$MsgStatus = MSG_SUCCESS;
				}
				$args1 = 'value="printInvoice"';
				$args2 = 'value="printSlip"';
			}
			else {
				$args1 = 'disabled="1"';
				$args2 = 'disabled="1"';
			}

			$GLOBALS['OrderActionOptions'] .= '<option ' . $args1 . '>' . GetLang('PrintInvoicesSelected') . '</option>';
			$GLOBALS['OrderActionOptions'] .= '<option ' . $args2 . '>' . GetLang('PrintPackingSlipsSelected') . '</option>';

			if(!gzte11(ISC_MEDIUMPRINT)) {
				$GLOBALS[base64_decode('SGlkZUV4cG9ydA==')] = "none";
			} else {
				// Do we need to disable the export button?
				if (!$GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Export_Orders) || $numOrders == 0) {
					$args = 'disabled="1"';
				} else {
					$args = 'value="export"';
				}
				$GLOBALS['OrderActionOptions'] .= '<option ' . $args . '>' . GetLang('ExportOrders') . '</option>';
				//$GLOBALS['OrderActionOptions'] .= '<option ' . $args . '>' . 'Send Review Request' . '</option>';

			}

			//zfang
			//$GLOBALS['OrderActionOptions'] .= '<option ' . $args . '>' . 'Send Review Request' . '</option>';
			$GLOBALS['OrderActionOptions'] .= '<option value="sendOrdReviewReq">' . GetLang('SendReviewRequest') . '</option>';


			$GLOBALS['OrderActionOptions'] .= '<option disabled="1"></option><optgroup label="' . GetLang('BulkOrderStatus') . '">';

			$result = $GLOBALS['ISC_CLASS_DB']->Query("SELECT * FROM [|PREFIX|]order_status where statusid!=0 ORDER BY statusorder ASC");
			while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$GLOBALS['OrderActionOptions'] .= '<option value="updateStatus' . $row['statusid'] . '">' . $row['statusdesc'] . '</option>';
			}
			$GLOBALS['OrderActionOptions'] .= '</optgroup>';

			if (!isset($_REQUEST['searchId'])) {
				$_REQUEST['searchId'] = 0;
			}

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

			if($MsgDesc != "") {
				$GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
			}

			$flashMessages = GetFlashMessages();
			if(is_array($flashMessages)) {
				foreach($flashMessages as $flashMessage) {
					$GLOBALS['Message'] .= MessageBox($flashMessage['message'], $flashMessage['type']);
				}
			}

			$GLOBALS['ExportAction'] = "index.php?ToDo=startExport&t=orders";
			if (isset($GLOBALS['CustomSearchId']) && $GLOBALS['CustomSearchId'] != '0') {
				$GLOBALS['ExportAction'] .= "&searchId=" . $GLOBALS['CustomSearchId'];
			}
			else {
				$query_params = explode('&', $_SERVER['QUERY_STRING']);
				$params = array();
				$ignore = array("ToDo");
				foreach ($query_params as $param) {
					$arr = explode("=", $param);
					if (!in_arrayi($arr[0], $ignore)) {
						$params[$arr[0]] = $arr[1];
					}
				}

				if (count($params)) {
					$GLOBALS['ExportAction'] .= "&" . http_build_query($params);
				}
			}

			// Used for iPhone interface
			$GLOBALS['OrderStatusOptions'] = $this->GetOrderStatusOptions();

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("orders.manage");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
			
			echo $GLOBALS['ISC_CLASS_DB']->GetErrorMsg();

		}

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
				SELECT %so.*, c.*, s.statusdesc AS ordstatustext, CONCAT(custconfirstname, ' ', custconlastname) AS custname,
					(
						SELECT COUNT(messageid)
						FROM [|PREFIX|]order_messages
						WHERE messageorderid=o.orderid
					) AS nummessages,
					(
						SELECT COUNT(messageid)
						FROM [|PREFIX|]order_messages
						WHERE messageorderid=o.orderid AND messagestatus != 'read'
					) AS numunreadmessages,
					(
						SELECT COUNT(messageid)
						FROM [|PREFIX|]order_messages
						WHERE messageorderid=o.orderid AND messagefrom='customer' AND messagestatus='unread'
					) AS newmessages,
				    r.requeststatus AS ordoverview
				FROM [|PREFIX|]orders o
				LEFT JOIN [|PREFIX|]customers c ON (o.ordcustid=c.customerid)
				LEFT JOIN [|PREFIX|]order_status s ON (s.statusid=o.ordstatus)
				LEFT JOIN [|PREFIX|]requests r ON (o.orderid=r.orderid)
				%s", $extraFields, $extraJoins);

			$countQuery = "SELECT COUNT(o.orderid) FROM [|PREFIX|]orders o";
			if (!empty($extraJoins)) {
				$countQuery .= ' '.$extraJoins;
			}

			if(isset($_REQUEST['newMessages'])) {
				$countQuery .= " LEFT JOIN [|PREFIX|]order_messages ON (messageorderid=orderid) AND messagefrom='customer' AND messagestatus='unread'";
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

			if($SortField == "orderid")
			{
				$SortField = "o.orderid";
			}
			
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

			if (isset($array['fromDate']))
			{
				$array['fromDate'] = urldecode(urldecode(urldecode($array['fromDate'])));
			}

			if (isset($array['fromDate']))
			{
				$array['toDate'] = urldecode(urldecode(urldecode($array['toDate'])));
			}


			if(isset($array['orderId']) && $array['orderId'] != '') {
				$queryWhere .= " AND o.orderid='".(int)$array['orderId']."'";
				return array("query" => $queryWhere,  "count" => $countQuery);
			}

			if(isset($array['customerId']) && $array['customerId'] != '') {
				$queryWhere .= " AND ordcustid='".(int)$array['customerId']."'";
				return array("query" => $queryWhere,  "count" => $countQuery);
			}
			

			if(isset($array['searchQuery']) && $array['searchQuery'] != "") {
				$search_query = $GLOBALS['ISC_CLASS_DB']->QuoteEx($array['searchQuery']);//zcs=Fix BUG,escape additional characters
				$queryWhere .= " AND (
					o.orderid='".(int)$search_query."'
					OR ordtrackingno='".$search_query."'
					OR ordpayproviderid='".$search_query."'
					OR CONCAT(custconfirstname, ' ', custconlastname) LIKE '%".$search_query."%'
					OR CONCAT(ordbillfirstname, ' ', ordbilllastname) LIKE '%".$search_query."%'
					OR CONCAT(ordshipfirstname, ' ', ordshiplastname) LIKE '%".$search_query."%'
					OR custconemail    LIKE '%".$search_query."%'
					OR ordbillstreet1  LIKE '%".$search_query."%'
					OR ordbillstreet2  LIKE '%".$search_query."%'
					OR ordbillsuburb   LIKE '%".$search_query."%'
					OR ordbillstate    LIKE '%".$search_query."%'
					OR ordbillzip      LIKE '%".$search_query."%'
					OR ordbillcountry  LIKE '%".$search_query."%'
					OR ordshipstreet1  LIKE '%".$search_query."%'
					OR ordshipstreet2  LIKE '%".$search_query."%'
					OR ordshipsuburb   LIKE '%".$search_query."%'
					OR ordshipstate    LIKE '%".$search_query."%'
					OR ordshipzip      LIKE '%".$search_query."%'
					OR ordshipcountry  LIKE '%".$search_query."%'
				) ";
				$countQuery .= " LEFT JOIN [|PREFIX|]customers c ON (o.ordcustid=c.customerid)";
			}
		
			//alandy_2012-3-28 add.
			if(isset($array['orderOwner']) && $array['orderOwner'] != ''){
				$queryWhere .= sprintf(" AND orderOwner='%d'", $array['orderOwner']);
			}
			
			if(isset($array['orderStatus']) && $array['orderStatus'] != "") {
				$order_status = $GLOBALS['ISC_CLASS_DB']->Quote((int)$array['orderStatus']);
				$queryWhere .= sprintf(" AND ordstatus='%d'", $order_status);
			}
			// Otherwise, only fetch complete orders
			else {
				$queryWhere .= " AND ordstatus > 0";
			}

			if(isset($array['paymentMethod']) && $array['paymentMethod'] != "") {
				$payment_method = $GLOBALS['ISC_CLASS_DB']->Quote($array['paymentMethod']);
				$queryWhere .= sprintf(" AND orderpaymentmodule='%s'", $payment_method);
			}

			if(isset($_REQUEST['shippingMethod']) && $_REQUEST['shippingMethod'] != "") {
				$shipping_method = $GLOBALS['ISC_CLASS_DB']->Quote($_REQUEST['shippingMethod']);
				$queryWhere .= sprintf(" AND ordershipmodule='%s'", $shipping_method);
			}

			if(isset($array['orderFrom']) && isset($array['orderTo']) && $array['orderFrom'] != "" && $array['orderTo'] != "") {
				$order_from = (int)$array['orderFrom'];
				$order_to = (int)$array['orderTo'];
				$queryWhere .= sprintf(" AND (o.orderid >= '%d' and o.orderid <= '%d')", $GLOBALS['ISC_CLASS_DB']->Quote($order_from), $GLOBALS['ISC_CLASS_DB']->Quote($order_to));
			}
			else if(isset($array['orderFrom']) && $array['orderFrom'] != "") {
				$order_from = (int)$array['orderFrom'];
				$queryWhere .= sprintf(" AND o.orderid >= '%d'", $order_from);
			}
			else if(isset($array['orderTo']) && $array['orderTo'] != "") {
				$order_to = (int)$array['orderTo'];
				$queryWhere .= sprintf(" AND o.orderid <= '%d'", $order_to);
			}

			if(isset($array['totalFrom']) && $array['totalFrom'] != "" && isset($array['totalTo']) && $array['totalTo'] != "") {
				$from_total = $array['totalFrom'];
				$to_total = $array['totalTo'];
				$queryWhere .= sprintf(" AND ordtotalamount >= '%s' and ordtotalamount <= '%s'", $GLOBALS['ISC_CLASS_DB']->Quote($from_total), $GLOBALS['ISC_CLASS_DB']->Quote($to_total));
			}
			else if(isset($array['totalFrom']) && $array['totalFrom'] != "") {
				$from_total = $array['totalFrom'];
				$queryWhere .= sprintf(" AND ordtotalamount >= '%s'", $GLOBALS['ISC_CLASS_DB']->Quote($from_total));
			}
			else if(isset($array['totalTo']) && $array['totalTo'] != "") {
				$to_total = $array['totalTo'];
				$queryWhere .= sprintf(" AND ordtotalamount <= '%s'", $GLOBALS['ISC_CLASS_DB']->Quote($to_total));
			}

			// Limit results to a particular date range
			if(isset($array['dateRange']) && $array['dateRange'] != "") {
				$range = $array['dateRange'];
				switch($range) {
					// Orders within the last day
					case "today":
						$from_stamp = isc_gmmktime(0, 0, 0, isc_date("m"), isc_date("d"), isc_date("Y"));
						break;
					// Orders received in the last 2 days
					case "yesterday":
						$from_stamp = isc_gmmktime(0, 0, 0, isc_date("m"), isc_date("d")-1, isc_date("Y"));
						$to_stamp = isc_gmmktime(0, 0, 0, isc_date("m"), isc_date("d"), isc_date("Y"));
						break;
					// Orders received in the last 24 hours
					case "day":
						$from_stamp = time()-60*60*24;
						break;
					// Orders received in the last 7 days
					case "week":
						$from_stamp = time()-60*60*24*7;
						break;
					// Orders received in the last 30 days
					case "month":
						$from_stamp = time()-60*60*24*30;
						break;
					// Orders received this month
					case "this_month":
						$from_stamp = isc_gmmktime(0, 0, 0, isc_date("m"), 1, isc_date("Y"));
						break;
					// Orders received this year
					case "this_year":
						$from_stamp = isc_gmmktime(0, 0, 0, 1, 1, isc_date("Y"));
						break;
					// Custom date
					default:
						if(isset($array['fromDate']) && $array['fromDate'] != "") {
							$from_date = $array['fromDate'];
							$from_data = explode("/", $from_date);
							$from_stamp = isc_gmmktime(0, 0, 0, $from_data[0], $from_data[1], $from_data[2]);
						}
						if(isset($array['toDate']) && $array['toDate'] != "") {
							$to_date = $array['toDate'];
							$to_data = explode("/", $to_date);
							$to_stamp = isc_gmmktime(0, 0, 0, $to_data[0], $to_data[1], $to_data[2]);
						}
				}

				if (!isset($array['SearchByDate']) || $array['SearchByDate'] == 0) {
					if(isset($from_stamp)) {
						$queryWhere .= " AND orddate >= '".(int)$from_stamp."'";
					}
					if(isset($to_stamp)) {
						$queryWhere .= "AND orddate <='".(int)$to_stamp."'";
					}
				} else if ($array['SearchByDate'] == 1) {
					if(isset($from_stamp)) {
						$queryWhere .= " AND (
							SELECT opf.orderprodid
							FROM [|PREFIX|]order_products opf
							WHERE o.orderid=opf.orderorderid AND opf.ordprodeventdate >='".(int)$from_stamp."'
						)";
					}
					if(isset($to_stamp)) {
						$queryWhere .= " AND (
							SELECT opt.orderprodid
							FROM [|PREFIX|]order_products opt
							WHERE o.orderid=opt.orderorderid AND opt.ordprodeventdate <='".(int)$to_stamp."'
						)";
					}
				} else if ($array['SearchByDate'] == 2) {
					if(isset($from_stamp)) {
						$queryWhere .= " AND (orddate >= '".(int)$from_stamp."' OR (
							SELECT opf.orderprodid
							FROM [|PREFIX|]order_products opf
							WHERE o.orderid=opf.orderorderid AND opf.ordprodeventdate >='".(int)$from_stamp."'
						))";
					}

					if(isset($to_stamp)) {
						$queryWhere .= " AND (orddate <= '".(int)$to_stamp."' OR (
							SELECT opt.orderprodid
							FROM [|PREFIX|]order_products opt
							WHERE o.orderid=opt.orderorderid AND opt.ordprodeventdate <='".(int)$to_stamp."'
						))";
					}
					if(isset($to_stamp)) {
						$queryWhere .= "AND orddate <='".(int)$from_stamp."'";
					}
				}
			}

			// Orders which contain a particular product?
			if(isset($array['productId'])) {
				$queryWhere .= " AND (
					SELECT sp.orderprodid
					FROM [|PREFIX|]order_products sp
					WHERE sp.ordprodid='".(int)$array['productId']."' AND sp.orderorderid=o.orderid
					LIMIT 1
				)";
			}

			// Orders by product name
			if(isset($array['productName'])) {
				$queryWhere .= " AND (
					SELECT sp.orderprodid
					FROM [|PREFIX|]order_products sp
					WHERE sp.ordprodname LIKE '%".$GLOBALS['ISC_CLASS_DB']->Quote($array['productName'])."%' AND sp.orderorderid=o.orderid
					LIMIT 1
				)";
			}

			return array("query" => $queryWhere,  "count" => $countQuery);
		}

		/**
		 * Get all the available order status as html options (without the <select> tags)
		 *
		 * @param integer $SelectedStatus The status to mark as selected
		 *
		 * @return string The html with the option tags in it
		 */
		public function GetOrderStatusOptions($SelectedStatus = null)
		{
			// Get all order status options from the database
			static $statuses = null;
			static $statuses2 = null;
			static $statuses3 = null;
			static $statuses4 = null;
			$output = "";

			// Only do the database query the first time
			if ($statuses === null) {
				$statuses = array();
				if($SelectedStatus === 0 || $SelectedStatus === '0') {
					/*$statuses[] = array(
						"statusid" => 0,
						"statusdesc" => GetLang('Incomplete')
					);*/
				}
				$query = "select statusid, statusdesc,statusorder from [|PREFIX|]order_status order by statusorder asc";
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					$statuses[] = $row;
				}
			}
			
			//2011-3-8 Ronnie add, Remove before fulfillment status
			//The status {pending, PayPal pending, awaiting payment} would be hidden.
			if ($statuses2 === null) {
				foreach ($statuses as $row){
					if(!($row['statusdesc']=="Pending"||$row['statusdesc']=="Awaiting Payment"||$row['statusdesc']=="PayPal Pending")){
						$statuses2[]=$row;
					}
				}
			}
			//The status {awaiting fulfillment, awaiting shipment, awaiting pickup} would be hidden.
			if ($statuses3 === null) {
				foreach ($statuses2 as $row){
					if(!($row['statusdesc']=="Awaiting Fulfillment"||$row['statusdesc']=="Awaiting Shipment"||$row['statusdesc']=="Awaiting Pickup")){
						$statuses3[]=$row;
					}
				}
			}
			
			//The status {partially shipped, shipped, completed, cancelled, declined, refunded} would be hidden. 
			if ($statuses4 === null) {
				foreach ($statuses3 as $row){
					if(!($row['statusdesc']=="Partially Shipped"||$row['statusdesc']=="Shipped"||$row['statusdesc']=="Completed"||$row['statusdesc']=="Cancelled"||$row['statusdesc']=="Declined"||$row['statusdesc']=="Refunded")){
						$statuses4[]=$row;
					}
				}
			}
			
	
			if($SelectedStatus==11 || $SelectedStatus==9 || $SelectedStatus==8){
				return $this->setStatusOptionsSelect($statuses2, $SelectedStatus);
			}
			if($SelectedStatus==3 || $SelectedStatus==2 || $SelectedStatus==10 || $SelectedStatus==5 || $SelectedStatus==6 || $SelectedStatus==4){
				return $this->setStatusOptionsSelect($statuses3, $SelectedStatus);
			}
			if($SelectedStatus==15 || $SelectedStatus==16){
				return $this->setStatusOptionsSelect($statuses4, $SelectedStatus);
			}
			return $this->setStatusOptionsSelect($statuses, $SelectedStatus);
			//2011-3-8 Ronnie modify
			/*foreach ($statuses as $row) {
				// Only show the 0 status if it's our current status
				if($row['statusid'] == 0 && $SelectedStatus != 0) {
					continue;
				}
				if ($row['statusid'] == $SelectedStatus) {
					$sel = 'selected="selected"';
				} else {
					$sel = '';
				}
				$output .= sprintf("<option value='%d' %s>%s</option>", $row['statusid'], $sel, $row['statusdesc']);
			}

			return $output;
			*/
		}
		
		private function setStatusOptionsSelect($statuses,$SelectedStatus){
			$output = '';
			foreach ($statuses as $row) {
				// Only show the 0 status if it's our current status
				if($row['statusid'] == 0 && $SelectedStatus != 0) {
					continue;
				}
				if ($row['statusid'] == $SelectedStatus) {
					$sel = 'selected="selected"';
				} else {
					$sel = '';
				}
				$output .= sprintf("<option value='%d' %s>%s</option>", $row['statusid'], $sel, $row['statusdesc']);
			}

			return $output;
		}

		/**
		*	Get a list of order messages and return them as an array. Also pass
		*	back the number of new and total messages to the 2nd and 3rd reference params
		*/
		private function GetOrderMessages($OrderId, $SortField, $SortOrder, &$NewMessages, &$TotalMessages)
		{
			$messages = array();
			$query = sprintf("select *, (select username from [|PREFIX|]users where pk_userid=staffuserid) as uname, (select userfirstname from [|PREFIX|]users where pk_userid=staffuserid) as ufname, (select userlastname from [|PREFIX|]users where pk_userid=staffuserid) as ulname from [|PREFIX|]order_messages where messageorderid='%d' order by %s %s", $GLOBALS['ISC_CLASS_DB']->Quote($OrderId), $SortField, $SortOrder);
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				array_push($messages, $row);

				if($row['messagefrom'] == "customer" && $row['messagestatus'] == "unread") {
					$NewMessages++;
				}

				$TotalMessages++;
			}

			// If we're on the iPhone then reset the message stack to 0 unread
			if(defined("IS_IPHONE")) {
				$updatedMessage = array(
					"messagestatus" => "read"
				);
				$GLOBALS['ISC_CLASS_DB']->UpdateQuery("order_messages", $updatedMessage, "messageorderid='".$GLOBALS['ISC_CLASS_DB']->Quote($OrderId)."'");
			}

			return $messages;
		}

		private function ViewOrderMessages($MsgDesc = "", $MsgStatus = "")
		{
			$new_messages = 0;
			$total_messages = 0;
			$GLOBALS['MessageGrid'] = "";
			$GLOBALS['Indent'] = 0;

			if ($MsgDesc != "") {
				$GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
			}

			if(isset($_GET['sortField'])) {
				$sort_field = $_GET['sortField'];
			} else {
				$sort_field = "messageid";
			}

			if(isset($_GET['sortOrder'])) {
				$sort_order = $_GET['sortOrder'];
			} else {
				$sort_order = "asc";
			}

			if(isset($_REQUEST['orderId'])) {
				$order_id = (int)$_REQUEST['orderId'];
				$GLOBALS['OrderId'] = $order_id;

				// Does this user have permission to view this order?
				$order = GetOrder($order_id);
				if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() && $order['ordvendorid'] != $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
					FlashMessage(GetLang('Unauthorized'), MSG_ERROR, 'index.php?ToDo=viewOrders');
				}

				$message_list = $this->GetOrderMessages($order_id, $sort_field, $sort_order, $new_messages, $total_messages);

				if($total_messages == 1) {
					$lang = "OrderMessagesIntro1";
				} else {
					$lang = "OrderMessagesIntroX";
				}

				$GLOBALS['MessageIntro'] = sprintf(GetLang($lang), $total_messages, $new_messages, $order_id);

				if (!empty($message_list)) {
					foreach($message_list as $message) {
						$GLOBALS['MessageId'] = $message['messageid'];
						$GLOBALS['Subject'] = $message['subject'];
						$GLOBALS['MessageDate'] = isc_date(GetConfig('ExtendedDisplayDateFormat'), $message['datestamp']);

						// If the message isn't read then we'll wrap the subject in bold tags
						if($message['messagestatus'] == "unread" && $message['messagefrom'] == "customer") {
							$GLOBALS['Subject'] = sprintf("<strong>%s</strong>", $GLOBALS['Subject']);
						}

						$GLOBALS['OrderMessage'] = nl2br(isc_html_escape($message['message']));

						if($message['messagefrom'] == "customer") {
							$GLOBALS['OrderFrom'] = GetLang('FromCustomer');
						}
						else {
							if($message['ufname'] != "" || $message['ulname'] != "") {
								$GLOBALS['OrderFrom'] = trim(sprintf("%s %s", $message['ufname'], $message['ulname']));
							} else {
								$GLOBALS['OrderFrom'] = $message['uname'];
							}
						}

						if($message['messagefrom'] == "admin") {
							$GLOBALS['MessageStatus'] = GetLang('NA');
						}
						else if($message['messagefrom'] == "customer" && $message['messagestatus'] == "unread") {
							$GLOBALS['MessageStatus'] = sprintf(GetLang('MessageUnRead'), $GLOBALS['ShopPath'], $order_id, $message['messageid']);
						}
						else {
							$GLOBALS['MessageStatus'] = sprintf(GetLang('MessageRead'), $GLOBALS['ShopPath'], $order_id, $message['messageid']);
						}

						// Is the message flagged?
						if($message['isflagged'] == "0") {
							$GLOBALS['FlagState'] = "1";
							$GLOBALS['HideFlag'] = "none";
							$GLOBALS['FlagText'] = GetLang('Flag');
						}
						else {
							$GLOBALS['FlagState'] = "0";
							$GLOBALS['HideFlag'] = "";
							$GLOBALS['FlagText'] = GetLang('ClearFlag');
						}

						$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("message.manage.row");
						$GLOBALS['MessageGrid'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);

						// If they're sorted by default fields then indent each message
						if($sort_field == "messageid" && $sort_order == "asc") {
							$GLOBALS['Indent'] += 20;
						}
					}
				}
				else {
					$GLOBALS['DisplayGrid'] = "none";
					$GLOBALS['DisableDelete'] = "disabled readonly";
				}

				$GLOBALS['MessageSubject'] = $this->GetRecentCustomerMessage($order_id);
				$GLOBALS['ViewOrderMessages'] = sprintf(GetLang('ViewOrderMessages'), $order_id);
				$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("ordermessages.manage");
				$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
			}
		}

		private function UpdateOrderMessageStatus()
		{
			if (isset($_GET['orderId']) && isset($_GET['messageId']) && isset($_GET['status'])) {
				$order_id = (int)$_GET['orderId'];
				$message_id = (int)$_GET['messageId'];
				$status = $_GET['status'];

				// Does this user have permission to view this order?
				$order = GetOrder($order_id);
				if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() && $order['ordvendorid'] != $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
					FlashMessage(GetLang('Unauthorized'), MSG_ERROR, 'index.php?ToDo=viewOrders');
				}

				$updatedMessage = array(
					"messagestatus" => $status
				);

				if ($GLOBALS['ISC_CLASS_DB']->UpdateQuery("order_messages", $updatedMessage, "messageid='".$GLOBALS['ISC_CLASS_DB']->Quote($message_id)."'")) {
					// Log this action
					$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($message_id, $_GET['status']);

					$this->ViewOrderMessages(sprintf(GetLang('OrderMessageStatusChanged'), $status), MSG_SUCCESS);
				} else {
					$this->ViewOrderMessages(sprintf(GetLang('OrderMessageStatusChangeFailed'), $status), MSG_ERROR);
				}
			}
		}

		private function FlagOrderMessage()
		{
			if(isset($_GET['flagState']) && isset($_GET['orderId']) && isset($_GET['messageId'])) {
				$flag_state = (int)$_GET['flagState'];
				$order_id = (int)$_GET['orderId'];

				// Does this user have permission to view this order?
				$order = GetOrder($order_id);
				if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() && $order['ordvendorid'] != $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
					FlashMessage(GetLang('Unauthorized'), MSG_ERROR, 'index.php?ToDo=viewOrders');
				}

				$message_id = (int)$_GET['messageId'];

				$updatedMessage = array(
					"isflagged" => $flag_state
				);
				if($GLOBALS['ISC_CLASS_DB']->UpdateQuery("order_messages", $updatedMessage, "messageid='".$GLOBALS['ISC_CLASS_DB']->Quote($message_id)."'")) {
					if($flag_state == "0") {
						// Log this action
						$GLOBALS['ISC_CLASS_LOG']->LogAdminAction("cleared", $message_id);

						$lang = "OrderFlagCleared";
					}
					else {
						// Log this action
						$GLOBALS['ISC_CLASS_LOG']->LogAdminAction("flagged", $message_id);

						$lang = "OrderFlaggedOK";
					}

					$this->ViewOrderMessages(GetLang($lang), MSG_SUCCESS);
				}
				else {
					$this->ViewOrderMessages(sprintf(GetLang('OrderFlaggedFailed'), $flag_state), MSG_ERROR);
				}
			}
		}

		private function DeleteOrderMessages()
		{
			if(isset($_POST['orderId']) && is_array($_POST['messages'])) {
				$order_id = (int)$_POST['orderId'];

				// Does this user have permission to view this order?
				$order = GetOrder($order_id);
				if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() && $order['ordvendorid'] != $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
					FlashMessage(GetLang('Unauthorized'), MSG_ERROR, 'index.php?ToDo=viewOrders');
				}

				$message_ids = implode("','", $GLOBALS['ISC_CLASS_DB']->Quote($_POST['messages']));
				$query = sprintf("delete from [|PREFIX|]order_messages where messageorderid='%d' and messageid in('%s')", $GLOBALS['ISC_CLASS_DB']->Quote($order_id), $message_ids);

				if($GLOBALS['ISC_CLASS_DB']->Query($query)) {
					// Log this action
					$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($order_id, count($_POST['messages']));

					$this->ViewOrderMessages(GetLang('OrderMessagesDeletedOK'), MSG_SUCCESS);
				}
				else {
					$this->ViewOrderMessages(GetLang('OrderMessagesDeletedFailed'), MSG_ERROR);
				}
			}
		}

		public function GetCustomerNameByOrderId($OrderId)
		{
			$query = sprintf("select ordcustid, (select concat(custconfirstname, ' ', custconlastname) from [|PREFIX|]customers where customerid=ordcustid) as custname, (select custconemail from [|PREFIX|]customers where customerid=ordcustid) as custemail  from [|PREFIX|]orders where orderid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($OrderId));
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			if ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				return sprintf("%s <%s>", $row['custname'], $row['custemail']);
			} else {
				return sprintf(GetLang('CustomerForOrderX'), $OrderId);
			}
		}

		public function GetCustomerEmailByOrderId($OrderId)
		{
			$query = sprintf("select ordcustid, (select custconemail from [|PREFIX|]customers where customerid=ordcustid) as custemail  from [|PREFIX|]orders where orderid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($OrderId));
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			if ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				return $row['custemail'];
			} else {
				return "";
			}
		}

		/**
		*	Get the subject of the most recent customer message. If none is available just use "Re: Order #xxxx"
		*/
		public function GetRecentCustomerMessage($OrderId)
		{
			$query = sprintf("select subject from [|PREFIX|]order_messages where messageorderid='%d' and messagefrom='customer' order by messageid desc limit 1", $GLOBALS['ISC_CLASS_DB']->Quote($OrderId));
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			if ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				return sprintf(GetLang('OrderMessageRe'), $row['subject']);
			} else {
				return sprintf(GetLang('OrderMessageDefaultSubject'), $OrderId);
			}
		}

		private function CreateOrderMessage()
		{
			if(isset($_GET['orderId'])) {
				$order_id = (int)$_GET['orderId'];

				// Does this user have permission to view this order?
				$order = GetOrder($order_id);
				if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() && $order['ordvendorid'] != $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
					FlashMessage(GetLang('Unauthorized'), MSG_ERROR, 'index.php?ToDo=viewOrders');
				}

				$GLOBALS['OrderId'] = $order_id;
				$GLOBALS['FormAction'] = "saveNewOrderMessage";
				$GLOBALS['Title'] = GetLang('CreateMessage');
				$GLOBALS['Intro'] = GetLang('CreateMessageIntro');
				$GLOBALS['ButtonAction'] = GetLang('SendMessage');

				$GLOBALS['MessageToFrom'] = GetLang('MessageTo');
				$GLOBALS['MessageTo'] = $this->GetCustomerNameByOrderId($order_id);
				$GLOBALS['MessageSubject'] = $this->GetRecentCustomerMessage($order_id);

				$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("ordermessage.form");
				$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
			}
		}

		private function SaveNewOrderMessage()
		{
			if(isset($_POST['orderId']) && isset($_POST['subject']) && isset($_POST['message'])) {
				$order_id = (int)$_POST['orderId'];

				// Does this user have permission to view this order?
				$order = GetOrder($order_id);
				if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() && $order['ordvendorid'] != $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
					FlashMessage(GetLang('Unauthorized'), MSG_ERROR, 'index.php?ToDo=viewOrders');
				}

				$subject = $_POST['subject'];
				$message = $_POST['message'];

				// Save the message to the database first
				$newMessage = array(
					"messagefrom" => "admin",
					"subject" => $subject,
					"message" => $message,
					"datestamp" => time(),
					"messageorderid" => $order_id,
					"messagestatus" => "unread",
					"staffuserid" => $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetUserId(),
					"isflagged" => 0
				);
				$message_id =  $GLOBALS['ISC_CLASS_DB']->InsertQuery("order_messages", $newMessage);
				if($message_id) {
					$message_id = $GLOBALS['ISC_CLASS_DB']->LastId();

					// Log this action
					$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($message_id, $order_id);

					// Now send a notification email to the customer
					$customer_email = $this->GetCustomerEmailByOrderId($order_id);

					// Create a new email API object to send the email
					$store_name = GetConfig('StoreName');

					$emailTemplate = FetchEmailTemplateParser();
					$emailTemplate->SetTemplate("ordermessage_notification");
					$message = $emailTemplate->ParseTemplate(true);

					require_once(ISC_BASE_PATH . "/lib/email.php");
					$obj_email = GetEmailClass();
					$obj_email->Set('CharSet', GetConfig('CharacterSet'));
					$obj_email->From(GetConfig('OrderEmail'), $store_name);
					$obj_email->Set("Subject", $subject);
					$obj_email->AddBody("html", $message);
					$obj_email->AddRecipient($customer_email, "", "h");
					$email_result = $obj_email->Send();

					if($email_result['success']) {
						$this->ViewOrderMessages(GetLang('OrderMessageSentOK'), MSG_SUCCESS);
					}
					else {
						$this->ViewOrderMessages(GetLang('OrderMessagesSentEmailFailed'), MSG_ERROR);
					}
				}
				else {
					$this->ViewOrderMessages(GetLang('OrderMessagesSentFailed'), MSG_ERROR);
				}
			}
		}

		private function EditOrderMessage()
		{
			if(isset($_GET['orderId']) && isset($_GET['messageId'])) {
				$order_id = (int)$_GET['orderId'];

				// Does this user have permission to view this order?
				$order = GetOrder($order_id);
				if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() && $order['ordvendorid'] != $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
					FlashMessage(GetLang('Unauthorized'), MSG_ERROR, 'index.php?ToDo=viewOrders');
				}

				$message_id = (int)$_GET['messageId'];
				$query = sprintf("select * from [|PREFIX|]order_messages where messageid='%d' and messageorderid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($message_id), $GLOBALS['ISC_CLASS_DB']->Quote($order_id));
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

				if($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					$GLOBALS['OrderId'] = $order_id;
					$GLOBALS['FormAction'] = "saveUpdatedOrderMessage";
					$GLOBALS['Title'] = GetLang('EditMessage');
					$GLOBALS['Intro'] = GetLang('EditMessageIntro');
					$GLOBALS['ButtonAction'] = GetLang('SaveMessage');
					$GLOBALS['MessageId'] = $message_id;
					$GLOBALS['MessageTo'] = $this->GetCustomerNameByOrderId($order_id);
					$GLOBALS['MessageSubject'] = $row['subject'];
					$GLOBALS['MessageContent'] = str_replace("<br />", "\n", $row['message']);

					if($row['messagefrom'] == "customer") {
						$GLOBALS['MessageToFrom'] = GetLang('MessageFrom');
					} else {
						$GLOBALS['MessageToFrom'] = GetLang('MessageTo');
					}

					$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("ordermessage.form");
					$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
				}
				else {
					$this->ViewOrderMessages(GetLang('OrderMessageSentOK'), MSG_SUCCESS);
				}
			}
		}

		private function SavedUpdatedOrderMessage()
		{
			if(isset($_POST['orderId']) && isset($_POST['messageId']) && isset($_POST['subject']) && isset($_POST['message'])) {
				$order_id = (int)$_POST['orderId'];

				// Does this user have permission to view this order?
				$order = GetOrder($order_id);
				if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() && $order['ordvendorid'] != $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
					FlashMessage(GetLang('Unauthorized'), MSG_ERROR, 'index.php?ToDo=viewOrders');
				}

				$message_id = (int)$_POST['messageId'];
				$subject = $_POST['subject'];
				// $message = str_replace("\n", "<br />", $_POST['message']);
				$message = $_POST['message'];
				$updatedMessage = array(
					"subject" => $subject,
					"message" => $message
				);
				if($GLOBALS['ISC_CLASS_DB']->UpdateQuery("order_messages", $updatedMessage, "messageid='".$GLOBALS['ISC_CLASS_DB']->Quote($message_id)."'")) {
					// Log this action
					$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($message_id, $order_id);

					$this->ViewOrderMessages(GetLang('OrderMessageUpdatedOK'), MSG_SUCCESS);
				}
				else {
					$this->ViewOrderMessages(GetLang('OrderMessagesUpdatedFailed'), MSG_ERROR);
				}
			}
		}

		private function SearchOrders()
		{
			$GLOBALS['OrderPaymentOptions'] = "";
			$GLOBALS['OrderShippingOptions'] = "";

			$checkout_providers = GetCheckoutModulesThatCustomerHasAccessTo();
			$shipping_providers = GetAvailableModules('shipping', false, true, false);
			//alandy_2012-3-28 add.
			$oderOwner_providers = $this->GetOderOwner();

			if (GetConfig('CurrencyLocation') == 'right') {
				$GLOBALS['CurrencyTokenLeft'] = '';
				$GLOBALS['CurrencyTokenRight'] = GetConfig('CurrencyToken');
			} else {
				$GLOBALS['CurrencyTokenLeft'] = GetConfig('CurrencyToken');
				$GLOBALS['CurrencyTokenRight'] = '';
			}

			foreach ($checkout_providers as $provider) {
				$GLOBALS['OrderPaymentOptions'] .= sprintf("<option value='%s'>%s</option>", $provider['object']->GetId(), $provider['object']->GetName());
			}

			foreach ($shipping_providers as $provider) {
				$GLOBALS['OrderShippingOptions'] .= sprintf("<option value='%s'>%s</option>", $provider['object']->GetId(), $provider['object']->GetName());
			}
			//alandy_2012-3-28 add.
			foreach ($oderOwner_providers as $provider) {
				$GLOBALS['OrderOwnerOptions'] .= sprintf("<option value='%d'>%s</option>", $provider['pk_userid'], $provider['username']);
			}
			$GLOBALS['OrderOwnerOptions'] .= "<option value=0>System</option>";

			$GLOBALS['OrderStatusOptions'] = $this->GetOrderStatusOptions();
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("orders.search");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}

		/**
		*	This function checks to see if the user wants to save the search details as a custom search,
		*	and if they do one is created. They are then forwarded onto the search results
		*/
		private function SearchOrdersRedirect()
		{
			// Format totals back to the western standard
			if($_GET['totalFrom'] != "") {
				$_GET['totalFrom'] = $_REQUEST['totalFrom'] = DefaultPriceFormat($_GET['totalFrom']);
			}

			if($_GET['totalTo'] != "") {
				$_GET['totalTo'] = $_REQUEST['totalTo'] = DefaultPriceFormat($_GET['totalTo']);
			}

			// Are we saving this as a custom search?
			if(isset($_GET['viewName']) && $_GET['viewName'] != '') {
				$search_id = $GLOBALS['ISC_CLASS_ADMIN_CUSTOMSEARCH']->SaveSearch($_GET['viewName'], $_GET);

				if($search_id > 0) {

					// Log this action
					$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($search_id, $_GET['viewName']);

					ob_end_clean();
					header(sprintf("Location:index.php?ToDo=customOrderSearch&searchId=%d&new=true", $search_id));
					exit;
				}
				else {
					$this->ManageOrders(sprintf(GetLang('ViewAlreadExists'), $_GET['viewName']), MSG_ERROR);
				}
			}
			// Plain search
			else {
				$this->ManageOrders();
			}
		}

		/**
		*	Load a custom search
		*/
		private function CustomSearch()
		{
			SetSession('ordersearch', (int) $_GET['searchId']);

			if ($_GET['searchId'] > 0) {
				$this->_customSearch = $GLOBALS['ISC_CLASS_ADMIN_CUSTOMSEARCH']->LoadSearch($_GET['searchId']);
				$_REQUEST = array_merge($_REQUEST, $this->_customSearch['searchvars']);
			}

			if (isset($_REQUEST['new'])) {
				$this->ManageOrders(GetLang('CustomSearchSaved'), MSG_SUCCESS);
			} else {
				$this->ManageOrders();
			}
		}

		private function DeleteCustomSearch()
		{

			if($GLOBALS['ISC_CLASS_ADMIN_CUSTOMSEARCH']->DeleteSearch($_GET['searchId'])) {
				// Log this action
				$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($_GET['searchId']);

				$this->ManageOrders(GetLang('DeleteCustomSearchSuccess'), MSG_SUCCESS);
			}
			else {
				$this->ManageOrders(GetLang('DeleteCustomSearchFailed'), MSG_ERROR);
			}
		}

		/**
		*	Print an invoice for an order. If $EndWithPageBreak is true then we will output a page break
		*/
		private function DoInvoicePrinting($OrderId, $EndWithPageBreak = false, $PrintAutomatically = true)
		{
			// Print a single invoice
			$numProds = 0;
			$numDL = 0;
			$numPhy = 0;

			$GLOBALS['StoreAddressFormatted'] = nl2br(GetConfig('StoreAddress'));

			$query = "
				SELECT o.*, CONCAT(c.custconfirstname, ' ', c.custconlastname) AS ordcustname, c.custconemail AS ordcustemail, c.custconphone AS ordcustphone
				FROM [|PREFIX|]orders o
				LEFT JOIN [|PREFIX|]customers c ON o.ordcustid = c.customerid
				WHERE o.orderid = '".$GLOBALS['ISC_CLASS_DB']->Quote($OrderId)."'
			";

			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			if($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$GLOBALS['InvoiceTitle'] = sprintf(GetLang('InvoiceTitle'), $OrderId);
				$GLOBALS['ItemCost'] = CurrencyConvertFormatPrice($row['ordsubtotal'], $row['ordcurrencyid'], $row['ordcurrencyexchangerate'], true);
				$GLOBALS['ShippingCost'] = CurrencyConvertFormatPrice($row['ordshipcost'], $row['ordcurrencyid'], $row['ordcurrencyexchangerate'], true);

				// Is there a handling fee?
				if($row['ordhandlingcost'] > 0) {
					$GLOBALS['HandlingCost'] = CurrencyConvertFormatPrice($row['ordhandlingcost'], $row['ordcurrencyid'], $row['ordcurrencyexchangerate'], true);
				}
				else {
					$GLOBALS['HideHandlingCost'] = "none";
				}

				// Is there any sales tax?
				if($row['ordtaxtotal'] > 0) {
					if($row['ordtaxname']) {
						$GLOBALS['SalesTaxName'] = isc_html_escape($row['ordtaxname']);
					}
					else {
						$GLOBALS['SalesTaxName'] = GetLang('InvoiceSalesTax');
					}
					if($row['ordtotalincludestax']) {
						$GLOBALS['HideSalesTax'] = 'none';
						$GLOBALS['SalesTaxName'] .= ' '.GetLang('IncludedInTotal');
					}
					else {
						$GLOBALS['HideSalesTax'] = '';
						$GLOBALS['HideSalesTaxIncluded'] = 'none';
					}

					/**
					 * Convert the total to the currency that they ordered with
					 */
					$GLOBALS['SalesTax'] = CurrencyConvertFormatPrice($row['ordtaxtotal'], $row['ordcurrencyid'], $row['ordcurrencyexchangerate'], true);
				}
				else {
					$GLOBALS['HideSalesTax'] = "none";
					$GLOBALS['HideSalesTaxIncluded'] = 'none';
				}

				/**
				 * Convert the total to the currency that they ordered with
				 */
				$GLOBALS['TotalCost'] = CurrencyConvertFormatPrice($row['ordtotalamount'], $row['ordcurrencyid'], $row['ordcurrencyexchangerate'], true);

				$GLOBALS['OrderId'] = $row['orderid'];
				if ($row['orddateshipped'] != 0) {
					$GLOBALS['OrderDate'] = CDate($row['orddateshipped']);
				} else {
					$GLOBALS['OrderDate'] = CDate(mktime());
				}
				$GLOBALS['Comments'] = nl2br(isc_html_escape($row['ordcustmessage']));

				if(!$GLOBALS['Comments']) {
					$GLOBALS['HideComments'] = 'display: none';
				}
				else {
					$GLOBALS['HideComments'] = '';
				}


				// Format the customer details
				$GLOBALS['CustomerName'] = isc_html_escape($row['ordcustname']);
				$GLOBALS['CustomerEmail'] = '';
				$GLOBALS['CustomerPhone'] = '';

				if ($row['ordcustemail'] != '') {
					$GLOBALS['CustomerEmail'] = '<span style="width: 55px; float:left;">' . GetLang('OrderInvoiceEmail') . ':</span> '. isc_html_escape($row['ordcustemail']);
				} else {
					$GLOBALS['CustomerEmail'] = '<span style="width: 55px; float:left;">' . GetLang('OrderInvoiceEmail') . ':</span> '. isc_html_escape($row['ordbillemail']);
				}

				if ($row['ordcustphone'] != '') {
					$GLOBALS['CustomerPhone'] = '<span style="width: 55px; float:left;">' . GetLang('OrderInvoicePhone') . ':</span> '. isc_html_escape($row['ordcustphone']);
				} else {
					$GLOBALS['CustomerPhone'] = '<span style="width: 55px; float:left;">' . GetLang('OrderInvoicePhone') . ':</span> '. isc_html_escape($row['ordbillphone']);
				}

				$GLOBALS['CustomerDetails'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("CustomerDetails");

				$addressDetails = array(
					'shipfirstname'	=> $row['ordbillfirstname'],
					'shiplastname'	=> $row['ordbilllastname'],
					'shipcompany'	=> $row['ordbillcompany'],
					'shipaddress1'	=> $row['ordbillstreet1'],
					'shipaddress2'	=> $row['ordbillstreet2'],
					'shipcity'		=> $row['ordbillsuburb'],
					'shipstate'		=> $row['ordbillstate'],
					'shipzip'		=> $row['ordbillzip'],
					'shipcountry'	=> $row['ordbillcountry'],
					'countrycode'	=> $row['ordbillcountrycode'],
				);
				$GLOBALS['BillingAddress'] = $this->BuildOrderAddressDetails($addressDetails, false);

				// Is there a shipping address, or is it a digital download?
				if($row['ordshipfirstname'] == "") {
					$GLOBALS['ShippingAddress'] = GetLang('NA');
				}
				else {
					$addressDetails = array(
						'shipfirstname'	=> $row['ordshipfirstname'],
						'shiplastname'	=> $row['ordshiplastname'],
						'shipcompany'	=> $row['ordshipcompany'],
						'shipaddress1'	=> $row['ordshipstreet1'],
						'shipaddress2'	=> $row['ordshipstreet2'],
						'shipcity'		=> $row['ordshipsuburb'],
						'shipstate'		=> $row['ordshipstate'],
						'shipzip'		=> $row['ordshipzip'],
						'shipcountry'	=> $row['ordshipcountry'],
						'countrycode'	=> $row['ordshipcountrycode'],
					);
					$GLOBALS['ShippingAddress'] = $this->BuildOrderAddressDetails($addressDetails, false);
				}

				$fieldsArray = $this->GetOrderProductFieldsData($OrderId);

				// Get the products in the order
				$query = sprintf("select * from [|PREFIX|]order_products where orderorderid='%s'", $GLOBALS['ISC_CLASS_DB']->Quote($OrderId));
				$pResult = $GLOBALS['ISC_CLASS_DB']->Query($query);

				$GLOBALS['ProductsTable'] = "";
				$wrappingTotal = 0;
				while ($pRow = $GLOBALS['ISC_CLASS_DB']->Fetch($pResult)) {
					$numProds++;

					if ($pRow['ordprodtype'] == 2) {
						$numDL++;
					} else {
						$numPhy++;

						if ($pRow['ordprodsku'] != "") {
							$sku = isc_html_escape($pRow['ordprodsku']);
						} else {
							$sku = GetLang('NA');
						}

						$pOptions = '';
						if($pRow['ordprodoptions'] != '') {
							$options = @unserialize($pRow['ordprodoptions']);
							if(!empty($options)) {
								$pOptions = "<br /><small>(";
								$comma = '';
								foreach($options as $name => $value) {
									$pOptions .= $comma.isc_html_escape($name).": ".isc_html_escape($value);
									$comma = ', ';
								}
								$pOptions .= ")</small>";
							}
						}

						if($pRow['ordprodwrapcost'] > 0) {
							$wrappingTotal += $pRow['ordprodwrapcost'] * $pRow['ordprodqty'];
						}

						$giftOptions = '';
						if($pRow['ordprodwrapname']) {
							$giftOptions .= "<br /><small>".GetLang('GiftWrapping').": ".isc_html_escape($pRow['ordprodwrapname'])."</small>";
						}

						$eventDate='';
						if ($pRow['ordprodeventdate'] != null) {
							$eventDate = '<br /><span style="padding-left : 10px; padding-bottom:10px; font-size:11px; font-style:italic">('.$pRow['ordprodeventname'] . ': ' . isc_date('dS M Y', $pRow['ordprodeventdate']) . ')</span>';
						}

						$orderProdFields = '';
						$productFields = '';
						if(isset($fieldsArray[$pRow['orderprodid']])) {
							$productFields = $this->LoadOrderProductFieldRow($fieldsArray[$pRow['orderprodid']], false);
						}
						if($productFields != '') {
							$GLOBALS['OrderProductFields'] = $productFields;
							$orderProdFields = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('OrderProductFields');
						}
						$GLOBALS['ProductsTable'] .= sprintf("

							<tr>
								<td valign='top'>%s</td>
								<td valign='top'>%s</td>
								<td valign='top'>%s</td>
								<td valign='top'>%s</td>
							</tr>

						", (int) $pRow['ordprodqty'], $sku, isc_html_escape($pRow['ordprodname']).$pOptions.$giftOptions.$eventDate.$orderProdFields, CurrencyConvertFormatPrice($pRow['ordprodcost'], $row['ordcurrencyid'], $row['ordcurrencyexchangerate'], true));
					}
				}


				if($wrappingTotal > 0) {
					$GLOBALS['GiftWrappingTotal'] = CurrencyConvertFormatPrice($wrappingTotal, $row['ordcurrencyid'], $row['ordcurrencyexchangerate'], true);
				}
				else {
					$GLOBALS['HideGiftWrappingTotal'] = 'display: none';
				}

				if($numDL == $numProds) {
					$GLOBALS['CloseWindow'] = "1";
				}

				$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("order.invoice");
				$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();

				// Should we output a pagebreak?
				if($EndWithPageBreak) {
					echo "<p class='PageBreak'>&nbsp;</p>";
				}

				// Should we print this order automatically?
				if($PrintAutomatically) {
					echo '<script type="text/javascript">window.setTimeout("window.print();", 1000);</script>';
				}
			}
			else {
				echo "<script type=\"text/javascript\">window.close();</script>";
			}
		}

		private function PrintInvoice()
		{
			// Print a packing slip for an order
			ob_end_clean();

			if(isset($_GET['orderId'])) {
				$order_id = (int)$_GET['orderId'];

				// Does this user have permission to view this order?
				$order = GetOrder($order_id);
				if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() && $order['ordvendorid'] != $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
					FlashMessage(GetLang('Unauthorized'), MSG_ERROR, 'index.php?ToDo=viewOrders');
				}

				$this->DoInvoicePrinting($order_id, true, true);
			}
			else {
				echo "<script type=\"text/javascript\">window.close();</script>";
			}

			die();
		}

		private function PrintMultiInvoices()
		{
			// Print multiple invoices and separate each one with a page break
			ob_end_clean();

			if(isset($_POST['orders'])) {
				$order_ids = $_POST['orders'];
				sort($order_ids, SORT_NUMERIC);
				for($i = 0; $i < count($order_ids); $i++) {
					$order_id = $order_ids[$i];

					// Does this user have permission to view this order?
					$order = GetOrder($order_id);
					if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() && $order['ordvendorid'] != $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
						FlashMessage(GetLang('Unauthorized'), MSG_ERROR, 'index.php?ToDo=viewOrders');
					}

					if(count($order_ids) > 1) {
						if($i == count($order_ids)-1) {
							$do_print = true;
							$do_pagebreak = false;
						}
						else {
							$do_print = false;
							$do_pagebreak = true;
						}
					}
					else {
						$do_print = true;
						$do_pagebreak = false;
					}

					$this->DoInvoicePrinting($order_id, $do_pagebreak, $do_print);
				}
			}
			else {
				echo "<script type=\"text/javascript\">window.close();</script>";
			}

			die();
		}

		/**
		*	Create a view for orders. Uses the same form as searching but puts the
		*	name of the view at the top and it's mandatory instead of optional.
		*/
		private function CreateView()
		{
			$GLOBALS['OrderPaymentOptions'] = "";
			$GLOBALS['OrderShippingOptions'] = "";

			if (GetConfig('CurrencyLocation') == 'right') {
				$GLOBALS['CurrencyTokenLeft'] = '';
				$GLOBALS['CurrencyTokenRight'] = GetConfig('CurrencyToken');
			} else {
				$GLOBALS['CurrencyTokenLeft'] = GetConfig('CurrencyToken');
				$GLOBALS['CurrencyTokenRight'] = '';
			}


			$checkout_providers = GetCheckoutModulesThatCustomerHasAccessTo();
			$shipping_providers = GetAvailableModules('shipping', false, true, false);
			//alandy_2012-3-28 add.
			$oderOwner_providers = $this->GetOderOwner();

			foreach($checkout_providers as $provider) {
				$GLOBALS['OrderPaymentOptions'] .= sprintf("<option value='%s'>%s</option>", $provider['object']->GetId(), $provider['object']->GetName());
			}

			foreach($shipping_providers as $provider) {
				$GLOBALS['OrderShippingOptions'] .= sprintf("<option value='%s'>%s</option>", $provider['object']->GetId(), $provider['object']->GetName());
			}

			//alandy_2012-3-28 add.
			foreach ($oderOwner_providers as $provider) {
				$GLOBALS['OrderOwnerOptions'] .= sprintf("<option value='%d'>%s</option>", $provider['pk_userid'], $provider['username']);
			}
			$GLOBALS['OrderOwnerOptions'] .= "<option value=0>System</option>";
			
			$GLOBALS['OrderStatusOptions'] = $this->GetOrderStatusOptions();
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("orders.view");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}


		private function ImportTrackingNumbers()
		{
			require_once dirname(__FILE__)."/class.batch.importer.php";
			$importer = new ISC_BATCH_IMPORTER_TRACKING_NUMBERS();
		}

		private function updateOrderStatusBox()
		{
			if (array_key_exists('orders', $_REQUEST) && array_key_exists('statusId', $_REQUEST) && isId($_REQUEST['statusId'])) {
				$GLOBALS['StatusID'] = $_REQUEST['statusId'];
				$GLOBALS['JavaScriptOrderIds'] = $_REQUEST['orders'];
				$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("orders.updatestatus.popup");
				$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
			}
		}

		/**
		* Delete order configurable product fields and the files uploaded with the order
		*
		* @param string $orderIds order ids separate by comma
		*
		*/
		private function _DeleteOrderProductFields($orderIds)
		{
			$fieldsQuery = "Select * from [|PREFIX|]order_configurable_fields WHERE orderid IN ('".$orderIds."');";
			$fieldsResult = $GLOBALS['ISC_CLASS_DB']->Query($fieldsQuery);
			$fieldIds[] = array(0);
			while($field = $GLOBALS['ISC_CLASS_DB']->Fetch($fieldsResult)) {
				//remove uploaded file if there is any
				if($field['filename'] != '') {
					@unlink(ISC_BASE_PATH.'/'.GetConfig('ImageDirectory').'/configured_products/'.$field['filename']);
				}
				$fieldIds[] = $field['orderfieldid'];
			}
			$fieldIdsString = implode("','", array_map('intval', $fieldIds));

			$GLOBALS['ISC_CLASS_DB']->DeleteQuery('order_configurable_fields', "WHERE orderfieldid IN ('".$fieldIdsString."')");
		}

		/**
		*	Load order product configurable fields layout in imodal.
		*
		*/
		public function LoadOrderProductFieldsFullView()
		{
			if(!isset($_REQUEST['orderId'])) {
				exit;
			}

			$ordprodid = 0;
			$GLOBALS['OrderProducts'] = '';

			$fieldsArray = $this->GetOrderProductFieldsData($_REQUEST['orderId']);

			$query = "SELECT ordprodname, orderprodid
						FROM [|PREFIX|]order_products
						WHERE orderorderid=".(int)$_REQUEST['orderId'];

			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			//each item in the order
			while($orderProd = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				//if this order item doesn't has any configurable fields, go to the next item
				if(!isset($fieldsArray[$orderProd['orderprodid']])) {
					continue;
				}

				$productFields = '';
				$productFields = $this->LoadOrderProductFieldRow($fieldsArray[$orderProd['orderprodid']], true);

				//only load products with configurable fields
				if($productFields != '') {
					$GLOBALS['OrderProductName'] = isc_html_escape($orderProd['ordprodname']);
					$GLOBALS['OrderProductFields'] = $productFields;
					$GLOBALS['OrderProducts'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('OrderProductFields');
				}
			}

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate('order.productfields');
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
			exit;
		}

		public function LoadOrderProductFieldRow($fields, $fullView = false)
		{
			if(empty($fields)) {
				return '' ;
			}
			$productFields = '';

			//each configurable field customer submited
			foreach($fields as $row) {

				if (empty($row['textcontents']) && empty($row['filename'])) {
					continue;
				}

				$fieldValue = '-';
				$fieldName = $row['fieldname'];
				switch($row['fieldtype']) {
					case 'file': {
						$fieldValue = '<a href="'.GetConfig('ShopPath').'/'.GetConfig('ImageDirectory').'/configured_products/'.urlencode($row['originalfilename']).'">'.isc_html_escape($row['originalfilename']).'</a>';
						break;
					}
					default: {
						if(isc_strlen($row['textcontents'])>50 && !$fullView) {
							$fieldValue = isc_html_escape(isc_substr($row['textcontents'], 0, 50))." ..";
						} else {
							$fieldValue = isc_html_escape($row['textcontents']);
						}
						break;
					}
				}

				$productFields .= "<dt>".isc_html_escape($fieldName).":</dt>";
				$productFields .= "<dd>".$fieldValue."</dd>";
			}

			return $productFields;
		}

		/**
		* get the product fields data for each order
		*
		* @param int $orderId, order id
		*
		* @return array an array of product fields data
		*/
		public function GetOrderProductFieldsData($orderId)
		{
			$query = "SELECT o.*
						FROM [|PREFIX|]order_configurable_fields o
							JOIN [|PREFIX|]product_configurable_fields p ON o.fieldid = p.productfieldid
						WHERE
							o.orderid=".(int)$orderId."
						ORDER BY p.fieldsortorder ASC";

			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			$fields = array();
			while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$fields[$row['ordprodid']][] = $row;
			}

			return $fields;
		}

		/**
		 * Return an instance of the cart management API for a particular session ID.
		 * The session ID only needs to be supplied once, as the returned class is a singleton
		 * multiple calls to this method will just return the same object.
		 *
		 * @param string The name of the session to initiate with the API.
		 * @param boolean Set to true to reset the order session to an empty array even if it already exists.
		 * @return object A referenced copy of the API object.
		 */
		public function GetCartApi($sessionId='', $reset=false)
		{
			static $classApi = null;
			if(is_null($classApi)) {
				$classApi = new ISC_ADMIN_CART_API;
				if(!isset($_SESSION['ORDER_MANAGER'][$sessionId]) || $reset == true) {
					$_SESSION['ORDER_MANANGER'][$sessionId] = array();
				}
				$classApi->SetCartSession($_SESSION['ORDER_MANAGER'][$sessionId]);
			}
			$api = &$classApi;
			return $api;
		}

		/**
		 * Show the form to edit an existing order.
		 */
		private function EditOrder()
		{
			$GLOBALS['BreadcrumEntries'][GetLang('EditOrder')] = '';

			if(!$GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Edit_Orders)) {
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
				return;
			}

			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();

			if(!isset($_REQUEST['orderId']) || !($order = GetOrder($_REQUEST['orderId']))) {
				FlashMessage(GetLang('InvalidOrderToEdit'), MSG_SUCCESS, 'index.php?ToDo=viewOrders');
			}

			// Does this user have permission to edit this order?
			if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() && $order['ordvendorid'] != $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
				FlashMessage(GetLang('Unauthorized'), MSG_ERROR, 'index.php?ToDo=viewOrders');
			}

			// Load the customers language file explicitly
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('customers');

			$GLOBALS['FormAction'] = 'SaveUpdatedOrder';
			$GLOBALS['Title'] = GetLang('EditOrder');
			$GLOBALS['Intro'] = GetLang('EditOrderIntro');
			$GLOBALS['SaveAndAddAnother'] = GetLang('SaveAndContinueEditing');

			if($_SERVER['REQUEST_METHOD'] == 'POST') {
				$GLOBALS['OrderSession'] = isc_html_escape($_POST['orderSession']);
				$sessionId = $_POST['orderSession'];
				$api = $this->GetCartApi($order['orderid']);
			}
			else {
				$this->CleanupOrderManagerSessions();
				unset($_SESSION['ORDER_MANAGER'][$order['orderid']]);
				$sessionId = $order['orderid'];

				// Load the products from the order in to the order session
				$api = $this->GetCartApi($order['orderid']);
				$api->LoadInOrderItems($order['orderid']);
			}

			$GLOBALS['OrderSession'] = $sessionId;

			$this->GetCartApi()->Set('SHIPPING_METHOD', array(
				'methodCost' => $order['ordshipcost'],
				'methodName' => $order['ordshipmethod'],
				'methodModule' => $order['ordershipmodule'],
				'handlingCost' => $order['ordhandlingcost'],
				'methodId' => 'existing'
			));
			$this->GetCartApi()->Set('EXISTING_ORDER', $order['orderid']);

			$this->SetupOrderManagementForm($order);

			$GLOBALS['OrderItems'] = $this->GenerateOrderItemsGrid();
			
			$summary = $this->CalculateOrderSummary($order);
			
			//alandy_2011-6-23 modify.
			$GLOBALS['OrderSummary'] = $this->GenerateOrderSummaryTable($summary,$_REQUEST['orderId']);
			$GLOBALS['YearList']     = $this->fn_getYMMOptions($params,'year');
            $GLOBALS['MakeList']     = $this->fn_getYMMOptions($params,'make');
            $GLOBALS['ModelList']    = $this->fn_getYMMOptions($params,'model');
			$GLOBALS['CabSize']=ISC_ADMIN_CLARION::fn_getCabBedsize(1);
			$GLOBALS['BedSize']=ISC_ADMIN_CLARION::fn_getCabBedsize(2);
			
			$GLOBALS["ISC_ADMIN_CLARION"] = new ISC_ADMIN_CLARION();
			//$GLOBALS['ExistingYMM']    = $GLOBALS["ISC_ADMIN_CLARION"]->fnLoadCustomerYMM($order['ordcustid']);
			if($order['ordcustid'] != '0') { # Condition added for to display only selected user YMM list only -- Baskaran
				$GLOBALS['ExistingYMM']    = $GLOBALS["ISC_ADMIN_CLARION"]->fnLoadCustomerYMM($order['ordcustid'], $type=1); # $type=1 is Existing User
			}
			else {
				$GLOBALS['ExistingYMM']    = $GLOBALS["ISC_ADMIN_CLARION"]->fnLoadCustomerYMM($order['orderid'], $type=0); # $type=0 is Anonymous user
			}
	

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate('order.form');
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();

			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
		}

		/**
		 * Set up all of the template variables and predefined values for showing the form to edit an
		 * existing order or create a new order. Will also set up the post variables as values if this
		 * is a post request.
		 *
		 * @param array Optionally, if editing an order, the existing order to use for the default values.
		 */
		private function SetupOrderManagementForm($order=array())
		{
			$GLOBLS['CurrentTab'] = 0;

			if($_SERVER['REQUEST_METHOD'] == 'POST') {
				$postData = $_POST;
			}
			else {
				$postData = $order;
			}

			$orderFields = array(
				'OrderBillFirstName'	=> 'ordbillfirstname',
				'OrderBillLastName'		=> 'ordbilllastname',
				'OrderBillCompany'		=> 'ordbillcompany',
				'OrderBillPhone'		=> 'ordbillphone',
				'OrderBillStreet1'		=> 'ordbillstreet1',
				'OrderBillStreet2'		=> 'ordbillstreet2',
				'OrderBillSuburb'		=> 'ordbillsuburb',
				'OrderBillZip'			=> 'ordbillzip',
				'OrderShipFirstName'	=> 'ordshipfirstname',
				'OrderShipLastName'		=> 'ordshiplastname',
				'OrderShipCompany'		=> 'ordshipcompany',
				'OrderShipPhone'		=> 'ordshipphone',
				'OrderShipStreet1'		=> 'ordshipstreet1',
				'OrderShipStreet2'		=> 'ordshipstreet2',
				'OrderShipSuburb'		=> 'ordshipsuburb',
				'OrderShipZip'			=> 'ordshipzip',
				'CustomerEmail'			=> 'custconemail',
				'CustomerPassword'		=> 'custpassword',
				'CustomerPassword2'		=> 'custpassword2',
				'CustomerStoreCredit'	=> 'custstorecredit',
				'CustomerGroup'			=> 'custgroupid',
				'CustomerType'			=> 'customerType',
				'OrderComments'			=> 'ordcustmessage',
				'OrderNotes'			=> 'ordnotes',
				'OrderId'				=> 'orderid',
				'OrderTrackingNo'		=> 'ordtrackingno',
				'AnonymousEmail'		=> 'anonymousemail',
				'OrderBillEmail'		=> 'ordbillemail',
				'OrderShipEmail'		=> 'ordshipemail'
			);

			/* Added below condition for applying store credit permission - vikas */
			$loggeduser = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetUser();

			if($loggeduser['userstorecreditperm'] == 0)
			{
				$GLOBALS['StoreCreditDisable'] = " disabled=\"\" ";
			}


			$GLOBALS['HideSelectedCustomer'] = 'display: none';
			$GLOBALS['HideCustomerSearch'] = '';
			$GLOBALS['HideAddressSelects'] = 'display: none';

			if(isset($postData['ordcustid']) && $postData['ordcustid'] > 0) {
				$GLOBALS['CurrentTab'] = 1;
				$GLOBALS['CustomerType'] = 'existing';
				$query = "
					SELECT *
					FROM [|PREFIX|]customers WHERE customerid='".(int)$postData['ordcustid']."'
				";
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				$existingCustomer = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
				
				if($existingCustomer['customerid']) {
					$GLOBALS['HideSelectedCustomer'] = '';
					$GLOBALS['HideCustomerSearch'] = 'display: none';
					$GLOBALS['HideHistoryLink'] = 'display: none';

					$GLOBALS['CustomerId'] = $existingCustomer['customerid'];
					$GLOBALS['CustomerFirstName'] = isc_html_escape($existingCustomer['custconfirstname']);
					$GLOBALS['CustomerLastName'] = isc_html_escape($existingCustomer['custconlastname']);

					$GLOBALS['CustomerPhone'] = '';
					if($existingCustomer['custconphone']) {
						$GLOBALS['CustomerPhone'] = isc_html_escape($existingCustomer['custconphone']) . '<br />';
					}

					$GLOBALS['CustomerEmail'] = '';
					if($existingCustomer['custconemail']) {
						$GLOBALS['CustomerEmail'] = '<a href="mailto:'.isc_html_escape($existingCustomer['custconemail']).'">'.isc_html_escape($existingCustomer['custconemail']).'</a><br />';
					}

					$GLOBALS['CustomerCompany'] = '';
					if($existingCustomer['custconcompany']) {
						$GLOBALS['CustomerCompany'] = isc_html_escape($existingCustomer['custconcompany']).'<br />';
					}

					// Grab the addresses
					$addresses = $this->LoadCustomerAddresses($existingCustomer['customerid']);
					$GLOBALS['AddressJson']  =  'OrderManager.LoadInAddresses('.isc_json_encode($addresses).');';
					if(!empty($addresses)) {
						$GLOBALS['HideAddressSelects'] = '';
						$GLOBALS['DisableAddressSelects'] = 'disabled="disabled"';
					}
					$GLOBALS['SelectedCustomer'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('OrdersCustomerSearchResult');
				}
				//alandy_2011-6-23 add.
				/*
				if($postData['orderid']>0){
				 $query = "
					   SELECT ordbillemail,ordshipemail
					   FROM [|PREFIX|]orders WHERE ordcustid='".(int)$postData['ordcustid']."' and orderid=".$postData['orderid']."
				   ";
				   $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				   while($rs=$GLOBALS['ISC_CLASS_DB']->Fetch($result)){
				   	  if(!empty($rs['ordbillemail'])){
				   	   $GLOBALS['GuestCustomerEmail']=$rs['ordbillemail'];
				   	  }else{
				   	  	$GLOBALS['GuestCustomerEmail']=$rs['ordshipemail'];
				   	  }
				   }
				}
				*/
			}
			else if(isset($postData['ordcustid']) && $postData['ordcustid'] == 0) {
				if(!isset($postData['customerType'])) {
					$GLOBALS['CurrentTab'] = 2;
				}
				else if($postData['customerType'] == 'anonymous') {
					$GLOBALS['CurrentTab'] = 2;
				}
				else {
					$GLOBALS['CurrenTab'] = 1;
				}
			}

			/**
			 * Customer and order custom fields
			 */
			$GLOBALS['OrderCustomFormFieldsAccountFormId'] = FORMFIELDS_FORM_ACCOUNT;
			$GLOBALS['OrderCustomFormFieldsBillingFormId'] = FORMFIELDS_FORM_BILLING;
			$GLOBALS['OrderCustomFormFieldsShippingFormId'] = FORMFIELDS_FORM_SHIPPING;
			$GLOBALS['CustomFieldsAccountLeftColumn'] = '';
			$GLOBALS['CustomFieldsAccountRightColumn'] = '';
			$GLOBALS['CustomFieldsBillingColumn'] = '';
			$GLOBALS['CustomFieldsShippingColumn'] = '';

			$formIdx = array(FORMFIELDS_FORM_ACCOUNT, FORMFIELDS_FORM_BILLING, FORMFIELDS_FORM_SHIPPING);

			$fieldMap = array(
				'FirstName'		=> 'firstname',
				'LastName'		=> 'lastname',
				'Company'		=> 'company',
				'Phone'			=> 'phone',
				'AddressLine1'	=> 'street1',
				'AddressLine2'	=> 'street2',
				'City'			=> 'suburb',
				'Zip'			=> 'zip',
				'Country'		=> 'country',
				'State'			=> 'state'
			);

			/**
			 * Now process the forms
			 */
			foreach ($formIdx as $formId) {
				$formSessionId = 0;
				if ($formId == FORMFIELDS_FORM_ACCOUNT) {

					/**
					 * We are only using the real custom fields for the account section, so check here
					 */
					if (!gzte11(ISC_MEDIUMPRINT)) {
						continue;
					}

					if (isset($existingCustomer['custformsessionid'])) {
						$formSessionId = $existingCustomer['custformsessionid'];
					}
				} else {
					if (isset($postData['ordformsessionid'])) {
						$formSessionId = $postData['ordformsessionid'];
					}
				}

				/**
				 * This part here gets all the existing fields
				 */
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$fields = $GLOBALS['ISC_CLASS_FORM']->getFormFields($formId, true);
				} else if (isId($formSessionId)) {
					$fields = $GLOBALS['ISC_CLASS_FORM']->getFormFields($formId, false, $formSessionId);
				} else {
					$fields = $GLOBALS['ISC_CLASS_FORM']->getFormFields($formId);
				}

				/**
				 * Get any selected country and state. This needs to be separate as we physically
				 * print out each form field at a time so we need this information before hand
				 */
				if ($formId !== FORMFIELDS_FORM_ACCOUNT) {
					$countryId = GetCountryIdByName(GetConfig('CompanyCountry'));
					$stateFieldId = 0;
					foreach (array_keys($fields) as $fieldId) {
						if (isc_strtolower($fields[$fieldId]->record['formfieldprivateid']) == 'state') {
							$stateFieldId = $fieldId;
						} else if (isc_strtolower($fields[$fieldId]->record['formfieldprivateid']) == 'country') {
							if ($_SERVER['REQUEST_METHOD'] == 'POST') {
								$country = $fields[$fieldId]->getValue();
							} if ($formId == FORMFIELDS_FORM_BILLING) {
								$country = @$order['ordbillcountry'];
							} else {
								$country = @$order['ordshipcountry'];
							}

							if (trim($country) !== '') {
								$countryId = GetCountryIdByName($country);
							}
						}
					}
				}

				/**
				 * Now we construct and build each form field
				 */
				$column = 0;
				foreach (array_keys($fields) as $fieldId) {

					if ($formId == FORMFIELDS_FORM_ACCOUNT) {

						if ($fields[$fieldId]->record['formfieldprivateid'] !== '' || !gzte11(ISC_MEDIUMPRINT)) {
							continue;
						}

						$fieldHTML = $fields[$fieldId]->loadForFrontend();

						if (($column%2) > 0) {
							$varname = 'CustomFieldsAccountLeftColumn';
						} else {
							$varname = 'CustomFieldsAccountRightColumn';
						}
					} else {

						/**
						 * We are using all the custom fields for the billing/shipping are, so check here
						 */
						if (!gzte11(ISC_MEDIUMPRINT) && $fields[$fieldId]->record['formfieldprivateid'] == '') {
							continue;
						}

						if ($formId == FORMFIELDS_FORM_BILLING) {
							$varname = 'CustomFieldsBillingColumn';
						} else {
							$varname = 'CustomFieldsShippingColumn';
						}

						/**
						 * Set the value for the private fields if this is NOT a post
						 */
						if ($_SERVER['REQUEST_METHOD'] !== 'POST' && $fields[$fieldId]->record['formfieldprivateid'] !== '') {

							$key = @$fieldMap[$fields[$fieldId]->record['formfieldprivateid']];
							if (trim($key) !== '') {
								if ($formId == FORMFIELDS_FORM_BILLING) {
									$key = 'ordbill' . $key;
								} else {
									$key = 'ordship' . $key;
								}

								if (array_key_exists($key, $order)) {
									$fields[$fieldId]->setValue($order[$key]);
								}
							}
						}

						/**
						 * Add in any of the country/state lists if needed
						 */
						if (isc_strtolower($fields[$fieldId]->record['formfieldprivateid']) == 'country') {
							$fields[$fieldId]->setOptions(array_values(GetCountryListAsIdValuePairs()));

							if ($fields[$fieldId]->getValue() == '') {
								$fields[$fieldId]->setValue(GetConfig('CompanyCountry'));
							}

							$fields[$fieldId]->addEventHandler('change', 'FormFieldEvent.SingleSelectPopulateStates', array('countryId' => $fieldId, 'stateId' => $stateFieldId, 'inOrdersAdmin' => true));

						} else if (isc_strtolower($fields[$fieldId]->record['formfieldprivateid']) == 'state' && isId($countryId)) {
							$stateOptions = GetStateListAsIdValuePairs($countryId);
							if (is_array($stateOptions) && !empty($stateOptions)) {
								$fields[$fieldId]->setOptions($stateOptions);
							}
						}

						/**
						 * We also do not what these fields
						 */
						if (isc_strtolower($fields[$fieldId]->record['formfieldprivateid']) == 'savethisaddress' || isc_strtolower($fields[$fieldId]->record['formfieldprivateid']) == 'shiptoaddress') {
							continue;
						}
					}

					$GLOBALS[$varname] .= $fields[$fieldId]->loadForFrontend() . "\n";
					$column++;
				}
			}

			/**
			 * Add this to generate our JS event script
			 */
			$GLOBALS['FormFieldEventData'] = $GLOBALS['ISC_CLASS_FORM']->buildRequiredJS();

			/**
			 * Do we display the customer custom fields?
			 */
			if (!gzte11(ISC_MEDIUMPRINT)) {
				$GLOBALS['HideCustomFieldsAccountLeftColumn'] = 'none';
				$GLOBALS['HideCustomFieldsAccountRightColumn'] = 'none';
			} else {
				if ($GLOBALS['CustomFieldsAccountLeftColumn'] == '') {
					$GLOBALS['HideCustomFieldsAccountLeftColumn'] = 'none';
				}

				if ($GLOBALS['CustomFieldsAccountRightColumn'] == '') {
					$GLOBALS['HideCustomFieldsAccountRightColumn'] = 'none';
				}
			}

			$defaultValues = array(
				'custgroupid' => 0,
				'ordstatus' => 7
			);

			foreach($defaultValues as $postField => $default) {
				if(!isset($postData[$postField])) {
					$postData[$postField] = $default;
				}
			}

			foreach($orderFields as $templateField => $orderField) {
				if(!isset($postData[$orderField])) {
					$GLOBALS[$templateField] = '';
				}
				else {
					$GLOBALS[$templateField] = isc_html_escape($postData[$orderField]);
				}
			}
			
			if(empty($GLOBALS["AnonymousEmail"]))
			{
				$GLOBALS["AnonymousEmail"] = $postData['ordbillemail'];
			}

			if(isset($postData['ordbillsaveAddress'])) {
				$GLOBALS['OrderBillSaveAddress'] = 'checked="checked"';
			}

			if(isset($postData['ordshipsaveAddress'])) {
				$GLOBALS['OrderShipSaveAddress'] = 'checked="checked"';
			}

			if(isset($postData['shippingUseBilling'])) {
				$GLOBALS['ShippingUseBillingChecked'] = 'checked="checked"';
			}

			if(isset($postData['billingUseShipping'])) {
				$GLOBALS['BillingUseShippingChecked'] = 'checked="checked"';
			}

			$GLOBALS['OrderStatusOptions'] = $this->GetOrderStatusOptions($postData['ordstatus']);

			/*
			 * To hide Pay and save button in edit mode -- Baskaran
			 */
			if($postData['ordstatus'] == '11') {
				$GLOBALS['PayandSaveDisplay'] = 'none';
			 }
			else {
				$GLOBALS['PayandSaveDisplay'] = '';
			}
			$customerClass = GetClass('ISC_ADMIN_CUSTOMERS');
			$GLOBALS['CustomerGroupOptions'] = $customerClass->GetCustomerGroupsAsOptions($postData['custgroupid']);

			$GLOBALS['PaymentMethodsList'] = $this->GetPaymentProviderList($postData);

			if(!empty($order)) {
				$GLOBALS['HideEmailInvoice'] = 'display: none';
			}
			else if(isset($postData['emailinvoice'])) {
				$GLOBALS['EmailInvoiceChecked'] = 'checked="checked"';
			}

			$GLOBALS['Message'] = GetFlashMessageBoxes();
		}

		/**
		 * Show the form to create a new order.
		 */
		private function AddOrder()
		{
			$GLOBALS['BreadcrumEntries'][GetLang('AddAnOrder')] = 'index.php?ToDo=addOrder';

			if(!$GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Add_Orders)) {
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
				return;
			}

			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();

			// Load the customers language file explicitly
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('customers');

			$GLOBALS['FormAction'] = 'saveNewOrder';
			$GLOBALS['Title'] = GetLang('AddAnOrder');
			$GLOBALS['Intro'] = GetLang('AddOrderIntro');
			$GLOBALS['SaveAndAddAnother'] = GetLang('SaveAndAddAnother');
			$GLOBALS['CurrentTab'] = 0;
			$GLOBALS['HideCustomerPasswordReminder'] = 'display: none';

			if($_SERVER['REQUEST_METHOD'] == 'POST') {
				$GLOBALS['OrderSession'] = isc_html_escape($_POST['orderSession']);
				$sessionId = $_POST['orderSession'];
			}
			else {
				$this->CleanupOrderManagerSessions();
				do {
					$sessionId = md5(uniqid());
				} while(isset($_SESSION['ORDER_MANAGER'][$sessionId]));
			}

			$api = $this->GetCartApi($sessionId);

			$GLOBALS['OrderSession'] = $sessionId;

			$this->SetupOrderManagementForm();

			$GLOBALS['OrderItems'] = $this->GenerateOrderItemsGrid();
			$GLOBALS['OrderSummary'] = $this->GenerateOrderSummaryTable();
			$GLOBALS['YearList']     = $this->fn_getYMMOptions($params,'year');
            $GLOBALS['MakeList']     = $this->fn_getYMMOptions($params,'make');
            $GLOBALS['ModelList']    = $this->fn_getYMMOptions($params,'model');
			$GLOBALS['CabSize']=ISC_ADMIN_CLARION::fn_getCabBedsize(1);
			$GLOBALS['BedSize']=ISC_ADMIN_CLARION::fn_getCabBedsize(2);

			$GLOBALS["ISC_ADMIN_CLARION"] = new ISC_ADMIN_CLARION();

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate('order.form');
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();

			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
		}

		/**
		 * Clean up and remove any order sessions that were created but not updated
		 * over 24 hours ago.
		 */
		private function CleanupOrderManagerSessions()
		{
			// Delete any order management sessions not updated within the last 24 hours
			if(!isset($_SESSION['ORDER_MANAGER'])) {
				return;
			}

			foreach($_SESSION['ORDER_MANAGER'] as $sessionId => $orderSession) {
				if(time()-$orderSession['LAST_UPDATED'] > 86400) {
					unset($_SESSION['ORDER_MANAGER'][$sessionId]);
				}
			}
		}

		/**
		 * Save a new order in the database.
		 */
		private function SaveNewOrder()
		{
			if(!$GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Add_Orders)) {
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
				return;
			}

			$message = '';
			if(!$this->ValidateOrder($_POST, $message)) {
				FlashMessage($message, MSG_ERROR);
				$this->AddOrder();
				return;
			}
            
			$randompassword = $this->generatePassword(); # Baskaran
			$_POST['custpassword'] = $randompassword;
			$cusemail = $_POST['custconemail'];
			$orderId = $this->CommitOrder($_POST);
			if(!$orderId) {
				$error = $GLOBALS['ISC_CLASS_DB']->GetErrorMsg();
				FlashMessage(GetLang('ProblemSavingOrder').$error, MSG_ERROR);
				$this->AddOrder();
				return;
			}
			else {
				/* Password email -- Baskaran */
				$store_name = GetConfig('StoreName');
				$cusfirstname =  $GLOBALS['CusFirstname'];
		
				$GLOBALS['ISC_LANG']['ThanksForRegisteringAtIntro'] = sprintf(GetLang('ThanksForRegisteringAtIntro'), $GLOBALS['StoreName']);
				$subject = "Thanks for Registering at ";
				$ThanksForRegisteringEmailLogin = sprintf("To sign in to your account, please visit <a href='%s'>%s</a> or <a href='%s'>click here</a>.", $GLOBALS['ShopPathSSL']."/account.php", $GLOBALS['ShopPathSSL']."/account.php", $GLOBALS['ShopPathSSL']."/account.php");
				$ThanksForRegisteringEmailHelp = "If you have any questions regarding your account, click 'Reply' in your email client and we'll be only too happy to help.";
		
				$message = "<html><body style='font-family:Arial; font-size:12px'>
						<div style='padding:0px 20px 20px 20px'>
						    <h2 style='font-size:22px; height:30px; color:#cc6600; border-bottom:dashed 1px gray'>Thanks for Registering at $store_name</h2>
		
						    <p>Hi $cusfirstname,</p>
		
						    <p>Thank you for creating your account at $store_name. Your account details are as follows:</p>
		
						    <p>
							<strong>Email Address:</strong> $cusemail<br />
							<strong>Password:</strong> $randompassword
						    </p>
		
						    <p>$ThanksForRegisteringEmailLogin</a>
		
						    <p>$ThanksForRegisteringEmailHelp</a>
		
						    <p>Thanks<br />$store_name</p>
						</div>
					    </body></html>";
				// Create a new email API object to send the email
				require_once(ISC_BASE_PATH . "/lib/email.php");
				$obj_email = GetEmailClass();
				$obj_email->Set('CharSet', GetConfig('CharacterSet'));
				$obj_email->From(GetConfig('OrderEmail'), $store_name);
				$obj_email->Set("Subject", $subject . $store_name);
				$obj_email->AddBody("html", $message);
				$obj_email->AddRecipient($cusemail, "", "h");
				$email_result = $obj_email->Send();
				/* Code Ends */                
				// Log this action
				$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($orderId);
				if(isset($_REQUEST['saveandpay'])) {
					//echo "Location:".$GLOBALS['ShopPathSSL']."/admin/index.php?ToDo=payOrder&oid=".$orderId;
					//@ob_end_clean(); 
					$location = $GLOBALS['ShopPathSSL']."/admin/index.php?ToDo=payOrder&oid=".$orderId;
					//header("Location:".$GLOBALS['ShopPathSSL']."/admin/index.php?ToDo=payOrder&oid=".$orderId);  
					//die();
				}
				else if(isset($_REQUEST['addAnother'])) {
				    $location = "index.php?ToDo=confirmOrder&oid={$orderId}&continue=addOrder";
				}
				else {
				    $location = "index.php?ToDo=confirmOrder&oid={$orderId}&continue=viewOrders";
				}
				
				FlashMessage(sprintf(GetLang('OrderCreated'), $orderId, $orderId), MSG_SUCCESS, $location);

			}
		}
		
		public function ConfirmOrder(){
			if(isset($_REQUEST['oid'])){
				$orderId = $_REQUEST['oid'];
				$GLOBALS['ConversionCode'] = $this->GetGoogleAnalyticsScript($orderId);
			}
			
			if(isset($_REQUEST['continue']))
				$continueLocation = 'index.php?ToDo='.$_REQUEST['continue'];
			else
				$continueLocation = 'index.php?ToDo=viewOrders';
				
			$GLOBALS['Message'] = GetFlashMessageBoxes();
				
			$GLOBALS['ContinueLocation'] = $continueLocation;
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("order.confirmation");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}
		
		/**
		 * GetCampaignCode
		 * @author: Wirror Yin
		 * @param Int $orderid
		 * @return String
		 */
		private function GetCampaignCode($orderid){
			$CampaignCode = '';
			
			//get current field ids from data base
			$result = $GLOBALS['ISC_CLASS_DB']->Query("SELECT * FROM [|PREFIX|]order_scripts");
						     
			while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			    if($row['scripttype']=='orderscript')    {
				$CampaignCode = $row['scriptvalue'];
			    }
			}
			
			$CATEGORYID = array();
			$CATEGORYNAME = array();
			$PRODUCTID =  array();
			$PRODUCTNAME = array();

			$result = $GLOBALS['ISC_CLASS_DB']->Query("SELECT o.orderid, o.ordsubtotal,o.ordtotalamount,op.ordprodid,op.ordprodname,
								  c.categoryid,c.catname,cu.custconfirstname,cu.custconlastname,cu.custconemail
								  FROM [|PREFIX|]orders o
								  LEFT JOIN [|PREFIX|]order_products op on o.orderid = op.orderorderid
								  LEFT JOIN [|PREFIX|]categoryassociations ca on ca.productid = op.ordprodid
								  LEFT JOIN [|PREFIX|]categories c on c.categoryid = ca.categoryid
								  LEFT JOIN [|PREFIX|]customers cu on cu.customerid  = o.ordcustid
								  WHERE orderid='$orderid'");
			      
			while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
	    
				$TOTAL = number_format($row['ordsubtotal'], 2); 
				$ORDERNUMBER = $row['orderid'];
				array_push($CATEGORYID, $row['categoryid']);
				array_push($CATEGORYNAME, $row['catname']);	 
				array_push($PRODUCTID, $row['ordprodid']);
				array_push($PRODUCTNAME, $row['ordprodname']);
				$FIRSTNAME = $row['custconfirstname'];
				$LASTNAME = $row['custconlastname'];
				$EMAIL = $row['custconemail'];
			}
			
			$CATEGORYID1 = implode(",",array_unique($CATEGORYID));
			$CATEGORYNAME1 =  implode(",",array_unique($CATEGORYNAME));
			$PRODUCTID1 =  implode(",",array_unique($PRODUCTID));
			$PRODUCTNAME1 =  implode(",",array_unique($PRODUCTNAME));
 
			$CampaignCode = str_ireplace('[TOTAL]', $TOTAL, $CampaignCode); 
			$CampaignCode = str_ireplace('[ORDERNUMBER]', $ORDERNUMBER, $CampaignCode);
			$CampaignCode = str_ireplace('[CATEGORYID]', $CATEGORYID1, $CampaignCode);
			$CampaignCode = str_ireplace('[CATEGORYNAME]', $CATEGORYNAME1, $CampaignCode);
			$CampaignCode = str_ireplace('[PRODUCTID]', $PRODUCTID1, $CampaignCode);
			$CampaignCode = str_ireplace('[PRODUCTNAME]', $PRODUCTNAME1, $CampaignCode);
			$CampaignCode = str_ireplace('[FIRSTNAME]', $FIRSTNAME, $CampaignCode);
			$CampaignCode = str_ireplace('[LASTNAME]', $LASTNAME, $CampaignCode);
			$CampaignCode = str_ireplace('[EMAIL]', $EMAIL, $CampaignCode);
			
			return $CampaignCode;
		}
		
		
		/**
		* GoogleAnalytics:  Google Analytics
		* @author: Wirror Yin
		* @param Int $orderid
		* @return void;
		*/
		private function GetGoogleAnalyticsScript($orderid){
			
			$tracker = GetClass('ISC_VISITOR');
			$TrackingCode .= $tracker->GetTrackingJavascript();
			$TrackingCode .= GetTrackingCodeForAllPackages();
			$ConversionCode = '';
			
			$query = "
				SELECT *
				FROM [|PREFIX|]orders
				WHERE orderid='$orderid'
			";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$pendingArray = array();
			$pendingArray['orders'] = array();
			$orders = array();
			while($order = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$orders[] = $order;
				$pendingArray['orders'][$order['orderid']] = $order;
				$pendingArray['total'] += $order['ordtotalamount'];
				if(!$pendingArray['gatewayamount']) {
					$pendingArray['gatewayamount'] = $order['ordgatewayamount'];
				}
		
				if(!$pendingArray['storecreditamount']) {
					$pendingArray['storecreditamount'] = $order['ordstorecreditamount'];
				}
		
				if(!$pendingArray['giftcertificateamount']) {
					$pendingArray['giftcertificateamount'] = $order['ordgiftcertificateamount'];
				}
				if(!$pendingArray['companygiftcertificateamount']) {
					$pendingArray['companygiftcertificateamount'] = $order['ordcompanygiftcertificateamount'];
				}
		
				if($order['orderpaymentmodule'] != 'giftcertificate' && $order['orderpaymentmodule'] != 'storecredit' && $order['orderpaymentmodule'] != '') {
					$pendingArray['paymentmodule'] = $order['orderpaymentmodule'];
				}
				$pendingArray['paymentmethod'] = $order['orderpaymentmethod'];
				$pendingArray['status'] = $order['ordstatus'];
				$pendingArray['ipaddress'] = $order['ordipaddress'];
				$pendingArray['currencyid'] = $order['ordcurrencyid'];
				$pendingArray['customerid'] = $order['ordcustid'];
				$pendingArray['isdigital'] = $order['ordisdigital'];
			}
			
			$analyticsModules = GetAvailableModules('analytics', true, true);
			foreach($analyticsModules as $module) {
				$module['object']->SetOrderData($pendingArray);
				$trackingCode = $module['object']->GetConversionCode();
				if($trackingCode != '') {
					$ConversionCode .= "
						<!-- Start conversion code for ".$module['id']." -->
						".$trackingCode."
						<!-- End conversion code for ".$module['id']." -->
					";
				}
			}
			
			// Include the conversion tracking code for affiliates
			foreach($orders as $order) {
				if(strlen(GetConfig('AffiliateConversionTrackingCode')) > 0) {
					$converted_code = GetConfig('AffiliateConversionTrackingCode');
					$converted_code = str_ireplace('%%ORDER_AMOUNT%%', $order['ordsubtotal'], $converted_code);
					$converted_code = str_ireplace('%%ORDER_ID%%', $order['orderid'], $converted_code);
					$ConversionCode .= '\n\n' . $converted_code;
				}
			}
			
			$ConversionCode .= $this->GetCampaignCode($orderid);
			
			return $TrackingCode.$ConversionCode;
		}

		/* Baskaran */
		/*
		 * Display Payment form tpl.
		 */
        private function payOrder() {
            $orderId = $_GET['oid'];
            if(isset($_GET['oid'])) {
                $query = $GLOBALS['ISC_CLASS_DB']->Query("SELECT * FROM [|PREFIX|]orders where orderid = '$orderId'");
                if($row = $GLOBALS['ISC_CLASS_DB']->Fetch($query)) {
                    $GLOBALS['cardholdername'] = $row['ordbillfirstname']." ".$row['ordbilllastname'];
					//ALANDY_20110420 modify pay order from column ordgatewayamount
                    //$GLOBALS['amount'] = CurrencyConvertFormatPrice($row['ordtotalamount']);
                    $GLOBALS['amount'] = CurrencyConvertFormatPrice($row['ordgatewayamount']);
                    $GLOBALS['OrderTitle'] = GetLang('PayOrder');
                    $GLOBALS['OrderIntro'] = GetLang('PayOrderIntro');
                    $GLOBALS['FormAction'] = "paymentOrder";
                    $GLOBALS['OrderNo'] = $orderId;
                    $GLOBALS['OrderMonths'] = "";
                    $GLOBALS['OrderYears'] = "";

                    for($i = 1; $i <= 12; $i++) {
                        $stamp = mktime(0, 0, 0, $i, 15, isc_date("Y"));

                        $i = str_pad($i, 2, "0", STR_PAD_LEFT);

                        if (@$_POST['ccexpm'] == $i) {
                            $sel = 'selected="selected"';
                        } else {
                            $sel = "";
                        }

                        $GLOBALS['OrderMonths'] .= sprintf("<option %s value='%s'>%s</option>", $sel, $i, isc_date("M", $stamp));
                    }

                    for($i = isc_date("Y"); $i < isc_date("Y")+10; $i++) {

                        if (@$_POST['ccexpy'] == substr($i, 2, 2)) {
                            $sel = 'selected="selected"';
                        } else {
                            $sel = "";
                        }
                        $GLOBALS['OrderYears'] .= sprintf("<option %s value='%s'>%s</option>", $sel, substr($i, 2, 2), $i);
                    }
                    
                    $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate('order.payform');
                    $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
                }
                else {
                    ob_end_clean();
                    header("Location: index.php?ToDo=viewOrders");
                    die();
                }
            }
            else {
                ob_end_clean();
                header("Location: index.php?ToDo=viewOrders");
                die();
            }
        }
        
		/*
		 * CC details going to payment gateway and checked the status.
		 */
        private function PaymentOrder() {
            $orderId = $_GET['oid'];
//            if(isset($_GET['oid'])) {
                $query = $GLOBALS['ISC_CLASS_DB']->Query("SELECT * FROM [|PREFIX|]orders where orderid = '$orderId'");
                $row = $GLOBALS['ISC_CLASS_DB']->Fetch($query);

		$statusquery = $GLOBALS['ISC_CLASS_DB']->Query("SELECT custconfirstname FROM [|PREFIX|]customers c, [|PREFIX|]orders o, [|PREFIX|]customer_groups cg WHERE o.orderid = '$orderId' AND cg.customergroupid = c.custgroupid AND o.ordcustid = c.customerid AND cg.groupname = 'Walk In' ");
                $cnt = $GLOBALS['ISC_CLASS_DB']->CountResult($statusquery);

		// Load the Authorize.net merchant ID
		$query_merchtid = $GLOBALS['ISC_CLASS_DB']->Query("SELECT * FROM [|PREFIX|]module_vars where variablename = '".merchantid."'  AND modulename ='".checkout_authorizenet."' ");
		$row_merchtid = $GLOBALS['ISC_CLASS_DB']->Fetch($query_merchtid);
		$merchant_id = $row_merchtid['variableval'];
		// Load the tranaction key
		$query_key = $GLOBALS['ISC_CLASS_DB']->Query("SELECT * FROM [|PREFIX|]module_vars where variablename = '".transactionkey."' AND modulename ='".checkout_authorizenet."'");
		$row_key = $GLOBALS['ISC_CLASS_DB']->Fetch($query_key);
		$transaction_key = $row_key['variableval'];
		
		//wirror_20110301
		require_once(ISC_BASE_PATH . "/modules/checkout/authorizenet/module.authorizenet.php");
		$moduleClass = GetClass('CHECKOUT_AUTHORIZENET');
		
		// Load the Authorize.net merchant ID
		$merchant_id = $moduleClass->GetValue("merchantid");
		
		// Load the tranaction key
		$transaction_key = $moduleClass->GetValue("transactionkey");

		// Load the Authorize.net transaction Type
		$transactionType = $moduleClass->GetValue('transactiontype');
		
		$testMode = $moduleClass->GetValue("testmode");
		if (isc_strtolower($testMode) == "yes") {
			$post_url = "https://test.authorize.net/gateway/transact.dll";
		}
		else {
			$post_url = "https://secure.authorize.net/gateway/transact.dll";
		}
		
		//wirror_20110530: order description for payment
		$desc_sql = "SELECT GROUP_CONCAT(CONCAT(' ', p.prodvendorprefix, ' ', p.prodcode) SEPARATOR ',') AS prod_desc
			     FROM [|PREFIX|]order_products op
			     INNER JOIN [|PREFIX|]products p ON (p.productid = op.ordprodid)
			     WHERE op.orderorderid='$orderId'
			     GROUP BY op.orderorderid
			     ORDER BY op.orderorderid ASC
			";
		$desc_result = $GLOBALS['ISC_CLASS_DB']->Query($desc_sql);
		$descs = array();
		while($desc = $GLOBALS['ISC_CLASS_DB']->Fetch($desc_result)){
			$descs[] = $desc['prod_desc'];
		}
		if(!empty($descs)){
			$more_desc = implode(',', $descs);
		}else{
			$more_desc = '';
		}
		$order_desc = sprintf(GetLang('YourOrderFrom'), $GLOBALS['StoreName']).' (#'.$orderId.')'.$more_desc;
		
	    $post_values = array(
                
                // the API Login ID and Transaction Key must be replaced with valid values
                "x_login"           => $merchant_id,
                "x_tran_key"        => $transaction_key,

                "x_version"         => "3.1",
                "x_delim_data"      => "TRUE",
                "x_delim_char"      => "|",
                "x_relay_response"  => "FALSE",

                "x_type"            => $transactionType,
                "x_method"          => "CC",
                "x_card_num"        => $_REQUEST['ccno'],
                "x_exp_date"        => $_REQUEST['ccexpm'].$_REQUEST['ccexpy'],
		'x_invoice_num'			=> $orderId,
                "x_amount"          => CurrencyConvertFormatPrice($row['ordtotalamount']),
                "x_description"     => $order_desc,
            

                "x_first_name"      => $row['ordbillfirstname'],
                "x_last_name"       => $row['ordbilllastname'],
                "x_email"           => $row['ordbillemail'],
                "x_address"         => $row['ordbillstreet1'],
                "x_state"           => $row['ordbillstate'],
                "x_zip"             => $row['ordbillzip']
                // Additional fields can be added here as outlined in the AIM integration
                // guide at: http://developer.authorize.net
            );
//             x_card_code
            // This section takes the input fields and converts them to the proper format
            // for an http post.  For example: "x_login=username&x_tran_key=a1B2c3D4"
            $post_string = "";
            foreach( $post_values as $key => $value )
                { $post_string .= "$key=" . urlencode( $value ) . "&"; }
            $post_string = rtrim( $post_string, "& " );

            // This sample code uses the CURL library for php to establish a connection,
            // submit the post, and record the response.
            // If you receive an error, you may want to ensure that you have the curl
            // library enabled in your php configuration
            $request = curl_init($post_url); // initiate curl object
                curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
                curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
                curl_setopt($request, CURLOPT_POSTFIELDS, $post_string); // use HTTP POST to send form data
                curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response.
                $post_response = curl_exec($request); // execute curl post and store results in $post_response
                // additional options may be required depending upon your server configuration
                // you can find documentation on curl options at http://www.php.net/curl_setopt
            curl_close ($request); // close curl object

            // This line takes the response and breaks it into an array using the specified delimiting character
            $response_array = explode($post_values["x_delim_char"],$post_response);

            // The results are output to the screen in the form of an html numbered list.
            for ($i=0; $i<count($response_array); $i++) {
                $response_array[$i] = trim($response_array[$i], '"');
            }
            $transid = $response_array[6];
            $status = $response_array[0];
            $response = $response_array[3];

			$ordstatus = '';
            if($cnt > 0) {
                $ordstatus = '10';
            } 
            else{
                $ordstatus = '11';
            }
        	$paymentStatus = '';

			if($transactionType == 'AUTH_ONLY') {
				$paymentStatus = 'authorized';
			} else if ($transactionType == 'AUTH_CAPTURE') {
				$paymentStatus = 'captured';
			}
			$extraInfo = '';
        	//store credit card number, used in refund transaction
			$cc_vars = array(
				"cc_ccno" => substr($_REQUEST['ccno'], -4),
			);

			// Is there any existing extra info for the pending order?
			if($order['extrainfo'] != "") {
				$extraArray = @unserialize($order['extrainfo']);
				if(is_array($extraArray)) {
					$extraInfo = serialize(@array_merge($extraArray, $cc_vars));
				}
			}
			else {
				$extraInfo = serialize($cc_vars);
			}
    

            if($status == '1') {   
                $updatedProducts = array(
                "ordstatus" => $ordstatus,
                "ordpayproviderid" => $transid,
                'ordpaymentstatus' => $paymentStatus,
                'extrainfo' => $extraInfo
                );
                $GLOBALS['ISC_CLASS_DB']->UpdateQuery("orders",$updatedProducts,"orderid = '$orderId'");
//                $this->ManageOrders($response, MSG_SUCCESS);
                $GLOBALS['Message'] = MessageBox($response, MSG_SUCCESS);
		
		//wirror:20110301
		$location = "index.php?ToDo=confirmOrder&oid=$orderId&continue=addOrder";
		FlashMessage($response, MSG_SUCCESS, $location);
                //header("Location:index.php?ToDo=viewOrders");  # due to client request this is comment and above is placed -- Baskaran
            }
            else {       
                $this->ShowPaymentForm($response,$orderId,$row['ordtotalamount']);
            }
        }

		/*
		 * When Payment details goes wrong then Repaymet form will be shown.
		 */
        private function ShowPaymentForm($response = '', $orderId, $amount) { # Baskaran
            
            $GLOBALS['OrderTitle'] = GetLang('PayOrder');
            $GLOBALS['OrderIntro'] = GetLang('PayOrderIntro');
            $GLOBALS['FormAction'] = "paymentOrder";
            $GLOBALS['OrderNo'] = $orderId;
			$GLOBALS['amount'] = CurrencyConvertFormatPrice($amount);
            $GLOBALS['OrderMonths'] = "";
            $GLOBALS['OrderYears'] = "";

            for($i = 1; $i <= 12; $i++) {
                $stamp = mktime(0, 0, 0, $i, 15, isc_date("Y"));

                $i = str_pad($i, 2, "0", STR_PAD_LEFT);

                if (@$_POST['ccexpm'] == $i) {
                    $sel = 'selected="selected"';
                } else {
                    $sel = "";
                }

                $GLOBALS['OrderMonths'] .= sprintf("<option %s value='%s'>%s</option>", $sel, $i, isc_date("M", $stamp));
            }

            for($i = isc_date("Y"); $i < isc_date("Y")+10; $i++) {

                if (@$_POST['ccexpy'] == substr($i, 2, 2)) {
                    $sel = 'selected="selected"';
                } else {
                    $sel = "";
                }
                $GLOBALS['OrderYears'] .= sprintf("<option %s value='%s'>%s</option>", $sel, substr($i, 2, 2), $i);
            }

//            $require_cvv2 = $this->GetValue("requirecvv2");
//            if($require_cvv2 == "YES") {
                if(isset($_POST['cc_cvv2'])) {
                    $GLOBALS['CCV2'] = (int)$_POST['cc_cvv2'];
                }
//                $GLOBALS['HideCVV2'] = '';
            /*}
            else {
                $GLOBALS['HideCVV2'] = 'none';
            } */
            
            if($response != '') { # Baskaran
                $GLOBALS['Name'] = isc_html_escape($_POST['name']);
                $GLOBALS['Num'] = isc_html_escape($_POST['ccno']);
//                Something went wrong when trying to process your payment. Please review the error message and try again:
                $GLOBALS['Message'] = "<div class='MessageBox MessageBoxError'>$response</div>";
                $GLOBALS['Message'] = MessageBox($response, MSG_ERROR);
            }
            else {
                // Hide the error message box
                $GLOBALS['HideAuthorizeNetError'] = "none";
            }
            
            $GLOBALS['Amount'] = CurrencyConvertFormatPrice($_POST['orderamount']);
            $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("order.repayform");

            //$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("authorizenet");
            $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
        }
	/* Baskaran Ends */
		/**
		 * Save an updated order in the database.
		 */
		private function SaveUpdatedOrder()
		{
			if(!$GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Edit_Orders)) {
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
				return;
			}

			$order = GetOrder($_REQUEST['orderid']);
			if(!isset($order['orderid'])) {
				FlashMessage(GetLang('InvalidOrder'), MSG_ERROR, 'index.php?ToDo=viewOrders');
			}

			// Does this user have permission to edit this order?
			if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() && $order['ordvendorid'] != $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
				FlashMessage(GetLang('Unauthorized'), MSG_ERROR, 'index.php?ToDo=viewOrders');
			}

			$message = '';
			// Validate and if there's an error, show the edit page again for this order
			//alandy_2011-6-22 modify.
			if(!$this->ValidateOrder($_POST, $message,true)) {
				FlashMessage($message, MSG_ERROR);
				$this->EditOrder();
				return;
			}


			// OK, so now it's valid, save the wrapping in the database
			if(!$this->CommitOrder($_POST, $order['orderid'])) {
				$error = $GLOBALS['ISC_CLASS_DB']->GetErrorMsg();

				FlashMessage(GetLang('ProblemSavingOrder').$error, MSG_ERROR);
				$this->EditOrder();
				return;
			}
			else {
				// Log this action
				$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($order['orderid']);
				if(isset($_REQUEST['saveandpay'])) {
					//echo "Location:".$GLOBALS['ShopPathSSL']."/admin/index.php?ToDo=payOrder&oid=".$orderId;
				@ob_end_clean(); 
                    /*$location = 'index.php?ToDo=payOrder&oid='.$orderId;*/  /*$GLOBALS['ShopPathSSL'].*/     header("Location:".$GLOBALS['ShopPathSSL']."/admin/index.php?ToDo=payOrder&oid=".$order['orderid']);  
					//die();
                }
                else if(isset($_REQUEST['addAnother'])) {
					$location = 'index.php?ToDo=editOrder&orderId='.$order['orderid'];
				}
				else {
					$location = 'index.php?ToDo=viewOrders';
				}
				FlashMessage(sprintf(GetLang('OrderUpdated'), $order['orderid']), MSG_SUCCESS, $location);
			}
		}
		
		private function _IsValidEmail($email)
		{
			//echo $email;
			//echo "<br>".$email."<br/>";
			$email = trim($email);
			$email = isc_strtolower($email);
			//echo "<br>".$email."<br/>";
			if(empty($email))
			{
				return false;
			}
			// johnny change regular expression "^[a-zA-Z]" to "^[a-zA-Z0-9]"		
			if(preg_match('/^[a-zA-Z0-9]([A-Za-z0-9]*[-_\.]?[A-Za-z0-9]+)*@([A-Za-z0-9]*[-_\.]?[A-Za-z0-9]+)+[\.][A-Za-z]{2,3}([\.][A-Za-z]{2})?$/i',$email))
			{
				return true;
			}		
			   return false;
		}

		/**
		 * Validate the supplied information about an order before it is inserted/updated.
		 *
		 * @param array An array of details about the order.
		 * @param string An error message, by reference, if there are any errors.
		 * @return boolean True if the order is valid, false if not.
		 */
		//alandy_2011-6-22 modify.
		private function ValidateOrder($data, &$error,$adminsave=false)
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('customers');

			switch($data['customerType']) {
				case 'anonymous':
					break;
				case 'new':
					$requiredFields = array(
						'custconemail' => GetLang('CustomerEmailRequired'),
					);
                    /*'custpassword' => GetLang('CustomerPasswordRequired'), 
                    'custpassword2' => GetLang('CustomerPasswordConfirmRequired')-- is commented due to creating random password -- Baskaran */
					foreach($requiredFields as $field => $message) {
						if(!isset($data[$field]) || !trim($data[$field])) {
							$error = $message . " Email Address:".$data[$field];
							return false;
						}
					}
					//test code start  for the strange issue "email address not accepted on add order page"					
					$myemail = trim($data['custconemail']);
					if(empty($myemail))
					{
						$error = 'please input your email,thanks.'. " Email Address:".$myemail;
						return false;
					}
					
					$ipos = stripos($myemail,'@');
					if(!$ipos && $ipos != 0)
					{
						$error = "email is invlid ,lack of '@'.". " Email Address:".$myemail;
						return false;
					}
					
					if($ipos == 0)
					{
						$error = "email is invlid ,lack of prefix before '@'.". " Your Email Address:".$myemail;
						return false;
					}
					
					if(!stripos($myemail,'@'))
					{
						$error = "email is invlid ,lack of '@'.". " Your Email Address:".$myemail;
						return false;
					}
					
					
					if(stripos($myemail,'.',$ipos)<1)
					{
						$error = "email is invlid ,lack of '.'." . " Email Address:".$myemail;
						return false;
					}
					
					if(stripos($myemail,' ')>0)
					{
						$error = "email is invlid ,contains special white space. ". " Email Address:".$myemail;
						return  false;
					}
					
					// test code end
					// Validate that the email address is actually valid
					//if(!is_email_address($data['custconemail'])) {
					if(!$this->_IsValidEmail($data['custconemail'])) {
						$error = GetLang('CustomerEmailInvalue'). " Email Address:".$myemail;
						return false;
					}
                    
					//alandy_2011-6-20 modify.
					// Is the email address already in use?
					$query = "
						SELECT customerid
						FROM [|PREFIX|]customers
						WHERE isguest=0 and custconemail='".$GLOBALS['ISC_CLASS_DB']->Quote($data['custconemail'])."'
					";
					if($GLOBALS['ISC_CLASS_DB']->FetchOne($query)) {
						$error = GetLang('CustomerEmailNotUnique');
						return false;
					}
					break;
				case 'existing':
					// Did they choose a customer?
					if(!$data['ordcustid']) {
						$error = GetLang('ErrorSelectACustomer');
						return false;
					}

					//alandy_2011-6-22 modify.
					// Does the customer they've chosen actually exist?
					if($adminsave){
						$query = "
						SELECT customerid
						FROM [|PREFIX|]customers
						WHERE  customerid='".(int)$data['ordcustid']."'
					    ";
					}else{
						$query = "
						SELECT customerid
						FROM [|PREFIX|]customers
						WHERE isguest=0 and customerid='".(int)$data['ordcustid']."'
					 ";
					}
					
					if(!$GLOBALS['ISC_CLASS_DB']->FetchOne($query)) {
						$error = GetLang('CustomerDoesntExist');
						return false;
					}
			}

			// Are there any items in the order?
			$cartProducts = $this->GetCartApi($data['orderSession'])->GetProductsInCart();
			if(empty($cartProducts)) {
				$error = GetLang('OrderMustContainOneProduct');
				return false;
			}

			$requiredFields = array(
				'orderpaymentmodule' => GetLang('InvalidPaymentModule')
			);

			foreach($requiredFields as $field => $message) {
				if(!isset($data[$field]) || !trim($data[$field])) {
					$error = $message;
					return false;
				}
			}

			return true;
		}

		/**
		 * Load and return an array of all of the shipping addresses associated with a particular
		 * customer ID. Will also generate a 'preview string' of all of the address details concatenated.
		 *
		 * @param int The ID of the customer to fetch the addresses for.
		 * @return array An array of addresses.
		 */
		public function LoadCustomerAddresses($customerId)
		{
			$customer = GetClass('ISC_CUSTOMER');
			$addresses = $customer->GetCustomerShippingAddresses($customerId);
			$addressResponse = array();
			foreach($addresses as $address) {
				$fields = array(
					'shipfullname',
					'shipcompany',
					'shipaddress1',
					'shipaddress2',
					'shipcity',
					'shipstate',
					'shipzip',
					'shipcountry',
					'shipcustomfields'
				);

				$formattedAddress = '';
				foreach($fields as $field) {

					/**
					 * Load in the custom fields if we have any
					 */
					if ($field == 'shipcustomfields' && isId($address['shipformsessionid'])) {
						$address[$field] = $GLOBALS['ISC_CLASS_FORM']->getSavedSessionData($address['shipformsessionid']);
						continue;
					}

					if(!isset($address[$field])) {
						continue;
					}
					$formattedAddress .= $address[$field] .', ';
				}

				/**
				 * Because we have both the billing and shipping forms in the one page, we have
				 * to assign the same values to both forms. We need to find out what is the original
				 * form so we can map it to the other
				 */
				if (isset($address['shipcustomfields']) && !empty($address['shipcustomfields'])) {
					$fieldIdx = array_keys($address['shipcustomfields']);
					$formIdx = $GLOBALS['ISC_CLASS_FORM']->findFormIdByFieldId($fieldIdx[0]);

					if (is_array($formIdx) && !empty($formIdx)) {
						$fieldMap = $GLOBALS['ISC_CLASS_FORM']->mapAddressFieldList($formIdx[0], $fieldIdx);
						$newCustom = array();

						/**
						 * OK, we got the map. now we can create our new custom fields data
						 */
						foreach ($fieldMap as $sourceFieldId => $targetFieldId) {
							if (!isset($address['shipcustomfields'][$sourceFieldId])) {
								continue;
							}

							$newCustom[$sourceFieldId] = $address['shipcustomfields'][$sourceFieldId];
							$newCustom[$targetFieldId] = $address['shipcustomfields'][$sourceFieldId];
						}

						$address['shipcustomfields'] = $newCustom;
					}
				}

				$formattedAddress = rtrim($formattedAddress, ', ');
				$address['preview'] = $formattedAddress;
				$addressResponse[] = $address;
			}
			return $addressResponse;
		}

		/**
		 * Actually save a new order or an updated existing order in the database
		 * after it's been validated.
		 *
		 * @param array An array of details about the order to save.
		 * @param int The ID of the existing order if we're updating an order.
		 * @return boolean True if successful, false if not.
		 */
		private function CommitOrder($data, $orderId=0)
		{
			$GLOBALS['ISC_CLASS_DB']->StartTransaction();

			/**
			 * We need to find our billing/shipping details from the form fields first as it is
			 * also used in creating the customer
			 */
			$billingDetails = array();
			$shippingDetails = array();
			$billingFields = $GLOBALS['ISC_CLASS_FORM']->getFormFields(FORMFIELDS_FORM_BILLING, true);
			$shippingFields = $GLOBALS['ISC_CLASS_FORM']->getFormFields(FORMFIELDS_FORM_SHIPPING, true);
			$fields = $billingFields + $shippingFields;

			$addressMap = array(
				'FirstName' => 'firstname',
				'LastName' => 'lastname',
				'CompanyName' => 'company',
				'AddressLine1' => 'address1',
				'AddressLine2' => 'address2',
				'City' => 'city',
				'State' => 'state',
				'Zip' => 'zip',
				'State' => 'state',
				'Country' => 'country',
				'Phone' => 'phone'
			);

			foreach (array_keys($fields) as $fieldId) {
				$privateName = $fields[$fieldId]->record['formfieldprivateid'];

				if ($privateName == '' || !array_key_exists($privateName, $addressMap)) {
					continue;
				}

				if ($fields[$fieldId]->record['formfieldformid'] == FORMFIELDS_FORM_BILLING) {
					$detailsVar =& $billingDetails;
				} else {
					$detailsVar =& $shippingDetails;
				}

				/**
				 * Find the country
				 */
				if (isc_strtolower($privateName) == 'country') {
					$detailsVar['shipcountry'] = $fields[$fieldId]->getValue();
					$detailsVar['shipcountryid'] = GetCountryByName($fields[$fieldId]->getValue());
					if (!isId($detailsVar['shipcountryid'])) {
						$detailsVar['shipcountryid'] = 0;
					}

				/**
				 * Else find the state
				 */
				} else if (isc_strtolower($privateName) == 'state') {
					$detailsVar['shipstate'] = $fields[$fieldId]->getValue();
					$stateInfo = GetStateInfoByName($detailsVar['shipstate']);

					if ($stateInfo && isId($stateInfo['stateid'])) {
						$detailsVar['shipstateid'] = $stateInfo['stateid'];
					} else {
						$detailsVar['shipstateid'] = 0;
					}

				/**
				 * Else the rest
				 */
				} else {
					$detailsVar['ship' . $addressMap[$privateName]] = $fields[$fieldId]->getValue();
				}
			}

			// If we're creating an account for this customer, create it now
			if($data['ordcustid'] == 0 && $data['customerType'] == 'new') {
				$customerData = array(
					'email' => $data['custconemail'],
					'password' => $data['custpassword'],
					'firstname' => $billingDetails['shipfirstname'],
					'lastname' => $billingDetails['shiplastname'],
					'company' => $billingDetails['shipcompany'],
					'phone' => $billingDetails['shipphone'],
					'token' => GenerateCustomerToken(),
					'customergroupid' => $data['custgroupid']
				);
                $GLOBALS['CusFirstname'] = $billingDetails['shipfirstname']; # Baskaran
				/* Added the store credit as seperate as it may be disabled while add/edit order - vikas  */
				if( isset($data['custstorecredit']) )
				{
					$customerData['storecredit'] = DefaultPriceFormat($data['custstorecredit']);
				}

				/**
				 * Save the customer custom fields
				 */
				if (gzte11(ISC_MEDIUMPRINT)) {
					$formSessionId = $GLOBALS['ISC_CLASS_FORM']->saveFormSession(FORMFIELDS_FORM_ACCOUNT);
					if (isId($formSessionId)) {
						$customerData['custformsessionid'] = $formSessionId;
					}
				}

				$entity = new ISC_ENTITY_CUSTOMER();
				$data['ordcustid'] = $entity->add($customerData);

				if(!$data['ordcustid']) {
					$GLOBALS['ISC_CLASS_DB']->RollbackTransaction();
					return false;
				}
			}
			
			//2010-11-08 Ronnie add When calculating the ship infomation corresponding to no
			$GLOBALS['BCK_shipcountryid']=$detailsVar['shipcountry'];
			$GLOBALS['BCK_shipstateid']=$detailsVar['shipstate'];
			if($GLOBALS['BCK_shipstateid']==''){
				$GLOBALS['BCK_shipcountryid']=$billingDetails['shipcountry'];
				$GLOBALS['BCK_shipstateid']=$billingDetails['shipstate'];
			}
            foreach ($this->GetCartApi()->GetProductsInCart() as $rowId => $product) {
                 if (!isset($product['exists_order_coupon']) && isset($product['discount'])) {
                    // Now workout the discount amount
                    if ($product['coupontype'] == 0) {
                        // It's a dollar discount
                        $newPrice = $product['product_price'] - $product['discount'];
                    }
                    else {
                        // It's a percentage discount
                        $discount = ($product['product_price']/100)*$product['discount'];
                        if($discount == $product['product_price']) {
                            $newPrice = 0;
                        }
                        else {
                            $newPrice = $product['product_price'] - $discount;
                        }
                    }

                    if ($newPrice < 0) {
                        $newPrice = 0;
                    }

                    $this->GetCartApi()->SetItemValue($rowId, 'discount_price', $newPrice);
                } elseif (isset($product['exists_order_coupon']) && isset($product['discount'])) {
                    $this->GetCartApi()->SetItemValue($rowId, 'discount_price', $product['product_price']);
                    $newPrice = 0;
                    if ($product['coupontype'] == 0) {
                        // It's a dollar discount
                        $newPrice = $product['product_price'] + $product['discount'];
                    }
                    else {
                        // It's a percentage discount
                        $newPrice = $product['product_price'] / (1- $product['discount'] / 100);
                    }
                    $this->GetCartApi()->SetItemValue($rowId, 'product_price', $newPrice);
                }
            }
           
            
			$orderSummary = $this->CalculateOrderSummary();

			//ronnie
			//$orderSummary['taxCost'];
			
			$defaultCurrency = GetDefaultCurrency();

			$email = '';
			if(isset($data['custconemail']) && $data['customerType'] == 'new') {
				$email = $data['custconemail'];
			}
			else if(isset($data['anonymousemail']) && $data['customerType'] == 'anonymous') {
				$email = $data['anonymousemail'];
			}
			
			/**********************************************************
				Code added by Mayank Jaitly for getting the logged user
				for adding his/her id as order owner.
			************************************************************/
			$loggeduser = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetUser();
			//////////  End of alteration

			$custid = $data['ordcustid'];
            $ordstatus = '';
            $query = $GLOBALS['ISC_CLASS_DB']->Query("SELECT * FROM [|PREFIX|]customers c, [|PREFIX|]customer_groups cg WHERE c.customerid = '$custid' AND cg.customergroupid = c.custgroupid AND cg.groupname = 'Walk In' ");
            if($GLOBALS['ISC_CLASS_DB']->CountResult($query) > 0) {
                $ordstatus = '10';
            }
            else {
                $ordstatus = $data['ordstatus'];
            }
            
            $billemail = $email;
            $shipemail = $email;
            if($data['customerType'] == 'anonymous') 
            {
            	if(isset($data['anonymousemail'])&& !empty($data['anonymousemail']))
            	{
            		 $billemail = $email;
            		 $shipemail = $email;
            	}
            	else 
            	{
	            	$billemail = $_POST['ordbillemail'];
	            	$shipemail = $_POST['ordshipemail'];
            	}
            }
			
			$newOrder = array(
				'paymentmethod'			=> $data['orderpaymentmodule'],
				'customerid'			=> $data['ordcustid'],
				'billingaddress'		=> $billingDetails,
				'ordbillemail'			=> $billemail,
				'ordshipemail'			=> $shipemail,
				'ordbillphone'			=> $billingDetails['shipphone'],
				'geoipcountry'			=> $billingDetails['shipcountry'],
				'geoipcountrycode'		=> GetCountryISO2ByName($billingDetails['shipcountry']),
				'vendorid'				=> $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId(),
				'giftcertificates'		=> $this->GetCartApi()->GetGiftCertificates(),
				'shippingcost'			=> $orderSummary['shippingCost'],
				'handlingcost'			=> $orderSummary['handlingCost'],
				'pending_token'			=> GenerateOrderToken(),
				'itemtotal'				=> $orderSummary['subtotal'],
				'taxcost'				=> $orderSummary['taxCost'],
				'taxrate'				=> $orderSummary['taxRate'],
				'taxname'				=> $orderSummary['taxName'],
				'giftcertificateamount'	=> $orderSummary['giftCertificateTotal'],
                'companygiftcertificateamount' => $orderSummary['companyGiftCertificateTotal'],
				'gatewayamount'			=> $orderSummary['adjustedTotalCost'],
				'totalincludestax'		=> $orderSummary['taxIncluded'],
				'shippingprovider'		=> $orderSummary['shippingMethod'],
				'shippingmodule'		=> $orderSummary['shippingModule'],
				'totalcost'				=> $orderSummary['total'],
				'ordstatus'				=> 0,
				'isdigitalorder'		=> (int)$this->GetCartApi()->AllProductsInCartAreIntangible(),
				'currencyid'			=> $defaultCurrency['currencyid'],
				'currencyexchangerate'	=> 0,
				'ordercomments'			=> @$data['ordcustmessage'],
				'ordnotes'				=> @$data['ordnotes'],
				'products'				=> $this->GetCartApi()->GetProductsInCart(),
				'ordtrackingno'			=> $data['ordtrackingno'],
				'orderowner' => 		$loggeduser['pk_userid']  #added by Mayank Jaitly
			);

			if(isset($data['ordbillsaveAddress'])) {
				$newOrder['billingaddress']['saveAddress'] = 1;
				if (gzte11(ISC_MEDIUMPRINT)) {
					$newOrder['billingaddress']['shipformsessionid'] = $GLOBALS['ISC_CLASS_FORM']->saveFormSession(FORMFIELDS_FORM_BILLING);
				}
			}

			if($newOrder['paymentmethod'] == 'manual') {
				$newOrder['paymentmethodname'] = GetLang('ManualPayment');
			}
			else if($newOrder['paymentmethod'] == 'giftcertificate') {
				$newOrder['giftcertificateamount'] = $orderSummary['total'];
			}
			else if($newOrder['paymentmethod'] == 'storecredit') {
				$newOrder['storecreditamount'] = $orderSummary['total'];
			}
			else if($newOrder['paymentmethod'] == 'custom') {
				$newOrder['paymentmethodname'] = $data['paymentField']['custom']['name'];
			}
			else if($newOrder['paymentmethod'] == 'paypal_admin') { // added new condition for paypal payment option - vikas
				$newOrder['paymentmethodname'] = GetLang('PaypalPayment');
			}
			else if($newOrder['paymentmethod'] == 'googlecheckout_admin') {
				$newOrder['paymentmethodname'] = GetLang('GooglePayment');
			}
			else if($newOrder['paymentmethod'] == 'creditcard') {
				$newOrder['paymentmethodname'] = GetLang('CreditCardPayment');
			}
			else if($newOrder['paymentmethod'] == 'cash') {
				$newOrder['paymentmethodname'] = GetLang('CashPayment');
			}

			if(!$this->GetCartApi()->AllProductsInCartAreIntangible()) {

				if(isset($data['shippingUseBilling']) && $data['shippingUseBilling'] == 1) {
					$newOrder['shippingaddress'] = $newOrder['billingaddress'];

				} else {
					$newOrder['shippingaddress'] = $shippingDetails;
					if (isset($data['ordshipsaveAddress']) && gzte11(ISC_MEDIUMPRINT)) {

						/**
						 * This is a bit tricky. We need to convert these shipping fields to use the billing
						 * field IDs when saving in the shipping_addresses table as they all use the billing
						 * fields on the frontend
						 */
						$shippingFields = $GLOBALS['ISC_CLASS_FORM']->getFormFields(FORMFIELDS_FORM_SHIPPING, true);
						$shippingKeys = array_keys($shippingFields);
						$shippingMap = $GLOBALS['ISC_CLASS_FORM']->mapAddressFieldList(FORMFIELDS_FORM_SHIPPING, $shippingKeys);
						$shippingSessData = array();

						foreach ($shippingMap as $fieldId => $newBillingId) {
							if ($shippingFields[$fieldId]->record['formfieldprivateid'] !== '') {
								continue;
							}

							$shippingSessData[$newBillingId] = $shippingFields[$fieldId]->getValue();
						}

						$newOrder['shippingaddress']['shipformsessionid'] = $GLOBALS['ISC_CLASS_FORM']->saveFormSessionManual($shippingSessData);
					}
				}

				if(isset($data['ordshipsaveAddress'])) {
					$newOrder['shippingaddress']['saveAddress'] = 1;
				}

			}

			if($orderId > 0) {
				$existingOrder = GetOrder($orderId);
				$newOrder['vendorid'] = $existingOrder['ordvendorid'];
				$newOrder['extraInfo'] = @unserialize($existingOrder['extrainfo']);
				//Alandy_2011-14-20 debug credit amount error! recalculate the gatewayamount,fetch the gatewayamount from profer order is wrong!
				//$newOrder['gatewayamount'] = $existingOrder['ordgatewayamount'];
				$newOrder['storecreditamount'] = $existingOrder['ordstorecreditamount'];
				$newOrder['currencyid'] = $existingOrder['ordcurrencyid'];
				$newOrder['currencyexchangerate'] = $existingOrder['ordcurrencyexchangerate'];
				$newOrder['orderid'] = $orderId;
				$newOrder['orddate'] = $existingOrder['orddate'];
				$newOrder['ordipaddress'] = $existingOrder['ordipaddress'];
			}

			/**
			 * Save the billing/shipping custom fields for the order
			 */
			if (gzte11(ISC_MEDIUMPRINT)) {
				if (isId($orderId) && isset($existingOrder['ordformsessionid']) && isId($existingOrder['ordformsessionid'])) {
					$GLOBALS['ISC_CLASS_FORM']->saveFormSession(array(FORMFIELDS_FORM_BILLING, FORMFIELDS_FORM_SHIPPING), true, $existingOrder['ordformsessionid']);
				} else {
					$formSessionId = $GLOBALS['ISC_CLASS_FORM']->saveFormSession(array(FORMFIELDS_FORM_BILLING, FORMFIELDS_FORM_SHIPPING));
					if (isId($formSessionId)) {
						$newOrder['ordformsessionid'] = $formSessionId;
					}
				}
			}
            
            // dada.wang 20120406 save cgc change
            $cgces = $this->GetCartApi()->Get('COMPANYGIFTCERTIFICATES');
            if (is_array($cgces) && !empty($cgces)) {
                $newOrder['companygiftcertificates'] = $cgces;
            }

			$entity = new ISC_ENTITY_ORDER();
			if(isset($existingOrder)) {
				$newOrder['adminflag'] = 1;
                
                //dada.wang 2012-04-10 if has gc or cgc was remove then use this function to remove it
                $this->RemoveGCAndCGC($newOrder);
                
				if(!$entity->edit($newOrder)) {
					$GLOBALS['ISC_CLASS_DB']->RollbackTransaction();
					return false;
				}
			}
			else {
				$newOrder['adminflag'] = 1;
				$data['orderid'] = $entity->add($newOrder);
				if(!$data['orderid']) {
					$GLOBALS['ISC_CLASS_DB']->RollbackTransaction();
					return false;
				}
                $newOrder['orderid'] = $data['orderid'];
			}

			// If one or more gift certificates were used we need to apply them to this order
			if($newOrder['giftcertificateamount'] > 0 && isset($newOrder['giftcertificates']) && !empty($newOrder['giftcertificates'])) {
				$usedCertificates = array();
				$GLOBALS['ISC_CLASS_GIFT_CERTIFICATES'] = GetClass('ISC_GIFTCERTIFICATES');
				$GLOBALS['ISC_CLASS_GIFT_CERTIFICATES']->ApplyGiftCertificatesToOrder($newOrder['orderid'], $newOrder['totalcost'], $newOrder['giftcertificates'], $usedCertificates);
			}

            // Add by NI_20100827_Jack
			// If one or more gift certificates were used we need to apply them to this order
			if($newOrder['companygiftcertificateamount'] > 0 && isset($newOrder['companygiftcertificates']) && !empty($newOrder['companygiftcertificates'])) {
				$usedCertificates = array();
				$GLOBALS['ISC_CLASS_COMPANY_GIFT_CERTIFICATES'] = GetClass('ISC_COMPANYGIFTCERTIFICATES');
				$GLOBALS['ISC_CLASS_COMPANY_GIFT_CERTIFICATES']->ApplyCompanyGiftCertificatesToOrder($newOrder['orderid'], $newOrder['totalcost'], $newOrder['companygiftcertificates'], $usedCertificates);
			}
			$GLOBALS['ISC_CLASS_DB']->CommitTransaction();

			// Did the payment method have any info it needs to save? Save it
			$provider = null;
			GetModuleById('checkout', $provider, $data['orderpaymentmodule']);
			if(is_object($provider) && method_exists($provider, 'SaveManualPaymentFields')) {
				$fields = $data['paymentField'][$data['orderpaymentmodule']];
				$provider->SaveManualPaymentFields(GetOrder($data['orderid'], false, false), $fields);
			}

			if($data['ordstatus'] != $newOrder['ordstatus']) {
				UpdateOrderStatus($data['orderid'], $data['ordstatus'], false);
			}

			// If we're emailing the customer about their order, send it now
			if(isset($data['emailinvoice']) && $data['emailinvoice'] == 1) {
				EmailInvoiceToCustomer($data['orderid']);
			}

			unset($_SESSION['ORDER_MANAGER'][$data['orderSession']]);
			
			/*************************************************************
					Alterations done by Mayank Jaitly on 28 June 2010
			**************************************************************/
				
				/*	
			// commented the below code as this is not needed.
				$customerYMMdata=array(
									   	'year' => $data['searchyear'],
										'make' => $data['searchmake'],
										'model' => MakeURLNormal($data['searchmodel']),
										'bed_size' =>$data['bedsize'],
										'cab_size' =>$data['cabsize']
										
									   );
										   
				$clarion_entity = new ISC_ADMIN_CLARION();
				$ymmID=$clarion_entity->fnSaveUserYMM($customerYMMdata,$data['ordcustid'],$_REQUEST['customerType'],$data['orderid']);
			*/		
				
			/***********************	End of Alteration		*********/
			
			/***************************************************************
				Code Added by Mayank Jaitly on 29 June 2010
			****************************************************************/
			// commented the below code as this is not needed.		
			//	$clarion_entity->fnUpdateOrderYMM($data['orderid'],$ymmID);
				
			/********************* End of code   **************************/ 
			
			
			return $data['orderid'];
		}

		/**
		 * Generate a grid/table containing all of the items in an order.
		 * Also generates an additional hidden row to use as the 'template'
		 * when the + icon to add a new item is clicked.
		 *
		 * @return string The generated grid of items in the order.
		 */
		public function GenerateOrderItemsGrid($orderTable=false)
		{
			$itemGrid = '';
			$orderItems = $this->GetCartApi()->GetProductsInCart($orderTable);
            
			if(empty($orderItems)) {
				$itemGrid .= $this->GenerateOrderItemRow(0);
			}

			foreach($orderItems as $rowId => $product) {
				//20100503 modifyed by alandy
				//var_dump($product, $GLOBALS['OrderSession']);exit;
				$product['vendorprefix'] = $this->GetProductVendorprefix($product['product_id']); // johnny 2011-08-24 add
				//alandy_2011-9-13 modify.
				$result = $this->GetOrderProductInfo($GLOBALS['OrderSession'], $product['product_id']);
				if($result['orddateshipped']){
					$product['shippingDate'] = "<strong>Last Shipping Date:</strong> ". $result['orddateshipped'];
					$product['isshippingDate'] = $result['orddateshipped'];
					$product['trackingNumber'] = "<strong>Tracking Number:</strong> ". $result['ordtrackingno'];
				}
				
                $itemGrid .= $this->GenerateOrderItemRow($rowId, $product, false, $product['is_reset_price']);
				//$itemGrid .= $this->GenerateOrderItemRow($rowId, $product);
			}

			$itemGrid .= $this->GenerateOrderItemRow('rowtemplate', array(), true);
			return $itemGrid;
		}

		/**
		 * Calculate all of the summary information to show below the list of items
		 * when editing/creating an order (totals, shipping etc)
		 *
		 * @param array If editing an order, the existing order information.
		 * @return array Array of summary details about the order.
		 */
		public function CalculateOrderSummary($order=array())
		{
			$existingOrder = true;
			if(empty($order)) {
				$order = $_REQUEST;
				$existingOrder = false;
			}

			$orderSummary = array(
				'total' => 0
			);

			$orderSummary['subtotal'] = $this->GetCartApi()->GetCartSubTotal(false, null, true, true); // No coupon codes
			$orderSummary['total'] += $orderSummary['subtotal'];

			$couponTotal = 0;
			foreach($this->GetCartApi()->GetAppliedCouponCodes() as $coupon) {
				/* The below line has been added coz, if more products are added and when coupon code is applied, the amount of coupon code would be increased with the number of products. so re-assigning coupontotal with discount amount. - Vikas 
				if($coupon['coupontype'] == 0) // if discount type is dollar, then set it else no need
				{
					$coupon['coupontotal'] = $coupon['discount'];
				}*/
                // dada.wang 2012-03-19 not subtract coupontotal
//				$orderSummary['total'] -= $coupon['coupontotal'];
			}

			if($orderSummary['total'] < 0) {
				$orderSummary['total'] = 0;
			}

			$orderSummary['wrappingCost'] = $this->GetCartApi()->GetWrappingCost();
			$orderSummary['total'] += $orderSummary['wrappingCost'];

			$shippingMethod = $this->GetCartApi()->Get('SHIPPING_METHOD');
			if(is_array($shippingMethod) && !empty($shippingMethod)) {
				$orderSummary['shippingCost'] = $shippingMethod['methodCost'];
				$orderSummary['shippingMethod'] = $shippingMethod['methodName'];
				$orderSummary['shippingModule'] = $shippingMethod['methodModule'];
				$orderSummary['handlingCost'] = $shippingMethod['handlingCost'];
			}
			else if($existingOrder) {
				$orderSummary['shippingCost'] = $order['ordshipcost'];
				$orderSummary['shippingMethod'] = $order['ordshipmethod'];
				$orderSummary['shippingModule'] = $order['ordershipmodule'];
				$orderSummary['handlingCost'] = $order['ordhandlingcost'];
			}
			else {
				//customerType
				$orderSummary['shippingCost'] = 0;
				$orderSummary['shippingMethod'] = '';
				$orderSummary['shippingModule'] = '';
				$orderSummary['handlingCost'] = 0;
			}

			$orderSummary['total'] += $orderSummary['shippingCost'];
			$orderSummary['total'] += $orderSummary['handlingCost'];

			// Set some default values incase tax isn't being applied
			$orderSummary['taxCost'] = 0;
			$orderSummary['taxIncluded'] = 0;
			$orderSummary['taxName'] = GetLang('Tax');
			$orderSummary['taxRate'] = 0;

			if($existingOrder) {
				$orderSummary['taxCost'] = $order['ordtaxtotal'];
				$orderSummary['taxIncluded'] = $order['ordtotalincludestax'];
				if ($order['ordtaxname'] != '') {
					$orderSummary['taxName'] = $order['ordtaxname'];
				}
				$orderSummary['taxRate'] = $order['ordtaxrate'];
			}
			// Need to calculate the tax
			else {
				$billingAddress = array(
					'shipzip' => '',
					'shipstate' => '',
					'shipcountry' => '',
				);
				$shippingAddress = $billingAddress;

				foreach(array_keys($billingAddress) as $field) {
					$fieldName = str_replace('ship', '', $field);
					if(isset($order['ordbill'.$fieldName])) {
						$billingAddress[$field] = $order['ordbill'.$fieldName];
					}
					if(isset($order['ordship'.$fieldName])) {
						$shippingAddress[$field] = $order['ordship'.$fieldName];
					}
					
				}
				//'State' => 'state',
				//'Country' => 'country',
				//ronnie			
				//$GLOBALS['BCK_shipcountryid']=$detailsVar['shipcountryid'];
				//$GLOBALS['BCK_shipstateid']=$detailsVar['shipstateid'];
				//$orderSummary['taxName'] = "kao-".$GLOBALS['BCK_shipcountryid'].$GLOBALS['BCK_shipstateid'];

				$customerClass = GetClass('ISC_CUSTOMER');
				$salesTaxData = $customerClass->GetSalesTaxRate($billingAddress, $shippingAddress);
				
				//2010-11-08 Ronnie add When calculating the ship infomation corresponding to no
				if(isset($GLOBALS['BCK_shipstateid'])){
					$billingAddress['shipstate']=$GLOBALS['BCK_shipstateid'];
					$billingAddress['shipcountry']=$GLOBALS['BCK_shipcountryid'];
					$shippingAddress=$billingAddress;
					$salesTaxData = $customerClass->GetSalesTaxRate($billingAddress, $shippingAddress);
				}else{
					//echo $billingAddress['ordbillstateid'].":".$shippingAddress['ordbillstateid'];
					//exit;
				}
				
				//$orderSummary['taxName'] = "ba";
				
				// Tax needs to be applied
				if($salesTaxData['tax_rate'] > 0) {
					$orderSummary['taxName'] = $salesTaxData['tax_name'];
					$orderSummary['taxRate'] = $salesTaxData['tax_rate'];

					$taxableTotal = 0;
					$cartProducts = $this->GetCartApi()->GetProductsInCart();
					foreach($cartProducts as $product) {
						if(!isset($product['data']) || $product['data']['prodtype'] != PT_GIFTCERTIFICATE && (!array_key_exists('prodistaxable', $product['data']) || $product['data']['prodistaxable'] == 1)) {
							$taxableTotal += ($product['product_price'] * $product['quantity']);
						}
					}
					$taxableTotal += $orderSummary['wrappingCost'];

					// Calculate based on the subtotal (cost of items) only
					if($salesTaxData['tax_based_on'] == 'subtotal') {
						$baseTotal = $taxableTotal;
					}
					// Calculating tax based on the subtotal + shipping (and also handling if it's included in the shipping)
					else {
						$baseTotal = $taxableTotal + $orderSummary['shippingCost'];
					}

					//2010-11-10 Ronnie modify ,Original calculate formula type is include,now is extra
					//$orderSummary['taxCost'] = ($baseTotal / (100 + $salesTaxData['tax_rate'])) * $salesTaxData['tax_rate'];
					//$orderSummary['taxCost']=$baseTotal* ($salesTaxData['tax_rate']/100);
					//totol - shipping cost = cut price
					$orderSummary['taxCost']=($orderSummary['total']-$orderSummary['shippingCost'])* ($salesTaxData['tax_rate']/100);
					
					// Calculate the tax
					if(GetConfig('PricesIncludeTax')) {
						$orderSummary['taxIncluded'] = 1;
					}
				}
			}

			if($orderSummary['taxIncluded'] == 0) {
				$orderSummary['total'] += $orderSummary['taxCost'];
				// ISC saves products with the taxes applied, so subtract the subtotal
				if(GetConfig('TaxTypeSelected') == 2) {
					$orderSummary['subtotal'] -= $orderSummary['taxCost'];
					$orderSummary['total'] -= $orderSummary['taxCost'];
				}
			}

			if($orderSummary['subtotal'] < 0) {
				$orderSummary['subtotal'] = 0;
			}

			if($orderSummary['total'] < 0) {
				$orderSummary['total'] = 0;
			}

			$orderSummary['adjustedTotalCost'] = $orderSummary['total'];

			$GLOBALS['GiftCertificates'] = '';
			$newGiftCertificateTotal = 0;
			$giftCertificateTotal = 0;
			foreach($this->GetCartApi()->GetGiftCertificates() as $certificate) {
                if (!isset($certificate['giftcertamountused'])) {
                    if($certificate['giftcertbalance'] > $orderSummary['adjustedTotalCost']) {
                        $certificate['giftcertamountused'] = $certificate['giftcertbalance'] - ($certificate['giftcertbalance'] - $orderSummary['adjustedTotalCost']);
                    }
                    else {
                        $certificate['giftcertamountused'] = $certificate['giftcertbalance'];
                    }
                }

				$giftCertificateTotal += $certificate['giftcertamountused'];
			}


			$orderSummary['giftCertificateTotal'] = $giftCertificateTotal;
			$orderSummary['storeCredit'] = 0;

			$orderSummary['adjustedTotalCost'] -= $orderSummary['giftCertificateTotal'];
			$orderSummary['adjustedTotalCost'] -= $orderSummary['storeCredit'];
            
            // Has the customer chosen one or more !!Company!! gift certificates to apply to this order? We need to adjust the total cost of the order to show what they need to pay.
            $certificates = $this->GetCartApi()->Get('COMPANYGIFTCERTIFICATES');
            $adjustedTotal = $orderSummary['adjustedTotalCost'];
            
            if (is_array($certificates)) {
                $giftCertificateTotal = 0;
                foreach ($certificates as $item) {
                    if (!isset($item['amountused'])) {
                        if ($item['cgcbalance'] > $orderSummary['adjustedTotalCost']) {
                            $item['amountused'] = $item['cgcbalance'] - ($item['cgcbalance'] - $orderSummary['adjustedTotalCost']);
                        } else {
                            $item['amountused'] = $item['cgcbalance'];
                        }
                    }

                    $giftCertificateTotal += $item['amountused'];
                    $adjustedTotal -= $item['amountused'];
                    if($adjustedTotal < 0) {
                        $adjustedTotal = 0;
                    }

                    $orderSummary['companyGiftCertificates'][] = $item;
                }

                // Set the adjusted cost of the order (what needs to be paid)
                $orderSummary['adjustedTotalCost'] = $adjustedTotal;
                $orderSummary['companyGiftCertificateTotal'] = $giftCertificateTotal;
            }
            
			if($orderSummary['adjustedTotalCost'] <= 0) {
				$orderSummary['adjustedTotalCost'] = 0;
			}
            
			return $orderSummary;
		}

		/**
		 * Generate a list of all of the payment providers available for processing
		 * manual orders.
		 *
		 * @param array Optionally, an array containing the existing order if we're editing one.
		 * @return string The generated HTML for the list of payment providers.
		 */
		public function GetPaymentProviderList($existingOrder=array())
		{
			$paymentMethodList = '';
			$availableModules = GetOfflineCheckoutModules();

			// If we have an existing order, we can add the payment method
			if(isset($existingOrder['orderpaymentmodule']) && !isset($availableModules[$existingOrder['orderpaymentmodule']]) && $existingOrder['orderpaymentmodule'] != 'custom' && isset($existingOrder['orderpaymentmethod'])) {
				if($existingOrder['orderpaymentmethod'] == 'giftcertificate') {
					$existingOrder['orderpaymentmodule'] = 'giftcertificate';
					$existingOrder['orderpaymentmethod'] = GetLang('GiftCertificates');
				}
				else if($existingOrder['orderpaymentmethod'] == 'storecredit') {
					$existingOrder['orderpaymentmodule'] = 'storecredit';
					$existingOrder['orderpaymentmethod'] = GetLang('StoreCredit');
				}
				$GLOBALS['PaymentMethodId'] = $existingOrder['orderpaymentmodule'];
				$GLOBALS['PaymentMethod'] = $existingOrder['orderpaymentmethod'];
				$GLOBALS['PaymentMethodChecked'] = 'checked="checked"';
				$GLOBALS['HidePaymentFields'] = 'display: none';
				$paymentMethodList .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('OrderPaymentMethod');
			}
			// Maybe this is a new order, show a fake 'Manual Payment' method
			else if(!isset($existingOrder['orderid']) || !isset($existingOrder['orderpaymentmodule']) || !$existingOrder['orderpaymentmodule'] || $existingOrder['orderpaymentmodule'] == 'manual' ) {
				/* -- Commented as client told to add new payment methods -- */
				/*
				$GLOBALS['PaymentMethodId'] = 'manual';
				$GLOBALS['PaymentMethod'] = GetLang('ManualPayment');
				$GLOBALS['PaymentMethodChecked'] = '';
				if(isset($existingOrder['orderpaymentmodule']) && $existingOrder['orderpaymentmodule'] != 'custom') {
					$GLOBALS['PaymentMethodChecked'] = 'checked="checked"';
				}
				$GLOBALS['HidePaymentFields'] = 'display: none';
				$paymentMethodList .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('OrderPaymentMethod');
				*/
				$GLOBALS['PaymentMethodOnClickEvent'] = "";
			}

			foreach($availableModules as $module) {
				$GLOBALS['PaymentMethodId'] = $module['object']->GetId();
				$GLOBALS['PaymentMethod'] = $module['object']->GetName();
				$GLOBALS['PaymentFields'] = '';
				$GLOBALS['HidePaymentFields'] = 'display: none';
				$GLOBALS['PaymentMethodChecked'] = '';

				$customPaymentFields = $module['object']->GetManualPaymentFields($existingOrder);
				if(isset($existingOrder['orderpaymentmodule']) && $module['id'] == $existingOrder['orderpaymentmodule']) {
					$GLOBALS['PaymentMethodChecked'] = 'checked="checked"';
					$GLOBALS['HidePaymentFields'] = '';
				}
				if(!empty($customPaymentFields)) {
					foreach($customPaymentFields as $name => $field) {
						if(!isset($field['value'])) {
							$field['value'] = '';
						}
						switch($field['type']) {
							case 'select':
								$changeEvent = '';
								if(isset($field['onchange'])) {
									$changeEvent = 'onchange="'.$field['onchange'].'"';
								}
								$fieldValue = '<select '.$changeEvent.'" class="Field250" name="paymentField['.$module['id'].']['.$name.']">';
								if(!is_array($field['options'])) {
									$fieldValue .= $field['options'];
								}
								else {
									foreach($field['options'] as $key => $val) {
										$sel = '';
										if($field['value'] == $key) {
											$sel = 'selected="selected"';
										}
										$fieldValue .= '<option value="'.isc_html_escape($key).'">'.isc_html_escape($val).'</option>';
									}
								}
								$fieldValue .= '</select>';
								break;
							case 'textarea':
								$fieldValue = '<textarea rows="4" class="Field250" name="paymentField['.$module['id'].']['.$name.']">'.isc_html_escape($field['value']).'</textarea>';
								break;
							case 'password':
								$fieldValue = '<input type="password" class="Field250" value="'.isc_html_escape($field['value']).'" name="paymentField['.$module['id'].']['.$name.']" />';
								break;
							case 'html':
								$fieldValue = $field['html'];
								break;
							case 'label':
								$fieldValue = isc_html_escape($field['value']);
								break;
							default:
								$fieldValue = '<input type="text" class="Field250" value="'.isc_html_escape($field['value']).'" name="paymentField['.$module['id'].']['.$name.']" />';
								break;
						}
						$GLOBALS['PaymentFields'] .= '
							<dt class="Field_'.$name.'"><span class="Required">&nbsp;</span> '.isc_html_escape($field['title']).':</dt>
							<dd class="Field_'.$name.'">'.$fieldValue.'</dd>
						';
					}
				}
				else {
					$GLOBALS['HidePaymentFields'] = 'display: none';
				}
				$paymentMethodList .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('OrderPaymentMethod');
			}

			/* --- Credit Card --- */
			if( !isset($existingOrder['orderpaymentmethod']) || $existingOrder['orderpaymentmethod'] != "Credit Card")
			{
				$GLOBALS['PaymentMethodId'] = 'creditcard';
				$GLOBALS['PaymentMethod'] = GetLang('CreditCardPayment');
				$GLOBALS['PaymentMethodChecked'] = '';
				if(isset($existingOrder['orderpaymentmodule']) && $existingOrder['orderpaymentmodule'] == 'creditcard' ) {
					$GLOBALS['PaymentMethodChecked'] = 'checked="checked"';
				}
				$GLOBALS['HidePaymentFields'] = 'display: none';
				$paymentMethodList .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('OrderPaymentMethod');
			}
			
			/* --- Paypal --- */
			if( !isset($existingOrder['orderpaymentmethod']) || $existingOrder['orderpaymentmethod'] != "Paypal")
			{
				$GLOBALS['PaymentMethodId'] = 'paypal_admin';
				$GLOBALS['PaymentMethod'] = GetLang('PaypalPayment');
				$GLOBALS['PaymentMethodChecked'] = '';
				if(isset($existingOrder['orderpaymentmodule']) && $existingOrder['orderpaymentmodule'] == 'paypal') {
					$GLOBALS['PaymentMethodChecked'] = 'checked="checked"';
				}
				$GLOBALS['HidePaymentFields'] = 'display: none';
				//$GLOBALS['PaymentMethodOnClickEvent'] = " onclick=\"alert('')\" ";
				$paymentMethodList .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('OrderPaymentMethod');
			}
			
			/* --- Google Checkout --- */
			if( !isset($existingOrder['orderpaymentmethod']) || $existingOrder['orderpaymentmethod'] != "Google Checkout")
			{
				$GLOBALS['PaymentMethodId'] = 'googlecheckout_admin';
				$GLOBALS['PaymentMethod'] = GetLang('GooglePayment');
				$GLOBALS['PaymentMethodChecked'] = '';
				if(isset($existingOrder['orderpaymentmodule']) && $existingOrder['orderpaymentmodule'] == 'googlecheckout' ) {
					$GLOBALS['PaymentMethodChecked'] = 'checked="checked"';
				}
				$GLOBALS['HidePaymentFields'] = 'display: none';
				$paymentMethodList .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('OrderPaymentMethod');
			}

			/* --- Cash --- */
			if( !isset($existingOrder['orderpaymentmethod']) || $existingOrder['orderpaymentmethod'] != "Cash")
			{
				$GLOBALS['PaymentMethodId'] = 'cash';
				$GLOBALS['PaymentMethod'] = GetLang('CashPayment');
				$GLOBALS['PaymentMethodChecked'] = '';
				if(isset($existingOrder['orderpaymentmodule']) && $existingOrder['orderpaymentmodule'] == 'cash' ) {
					$GLOBALS['PaymentMethodChecked'] = 'checked="checked"';
				}
				$GLOBALS['HidePaymentFields'] = 'display: none';
				$paymentMethodList .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('OrderPaymentMethod');
			}

			// Append a custom method to the end of the list
			$GLOBALS['PaymentMethodId'] = 'custom';
			$GLOBALS['PaymentMethod'] = GetLang('Custom');
			$GLOBALS['PaymentMethodChecked'] = '';
			if(isset($existingOrder['orderpaymentmodule']) && $existingOrder['orderpaymentmodule'] == 'custom') {
				$GLOBALS['PaymentMethodChecked'] = 'checked="checked"';
			}
			$GLOBALS['HidePaymentFields'] = 'display: none';
			$value = '';
			if(isset($existingOrder['paymentField']['custom']['name'])) {
				$value = isc_html_escape($existingOrder['paymentField']['custom']['name']);
			}
			else if(isset($existingOrder['orderpaymentmodule']) && $existingOrder['orderpaymentmodule'] == 'custom') {
				$value = isc_html_escape($existingOrder['orderpaymentmethod']);
			}
			$GLOBALS['PaymentFields'] = '
				<dt><span class="Required">*</span> '.GetLang('Name').':</dt>
				<dd><input type="text" class="Field250" name="paymentField[custom][name]" value="'.$value.'" /></dt>
			';
			$paymentMethodList .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('OrderPaymentMethod');
			return $paymentMethodList;
		}

		/**
		 * Generate the raw table show as the order summary (containing totals, shipping, tax etc)
		 *
		 * @param array The order summary, as generated by self::CalculateOrderSummary(). Generated if not supplied.
		 * @return string The generated summary table for this order.
		 */
		public function GenerateOrderSummaryTable($orderSummary=array())
		{
			if(empty($orderSummary)) {
				$orderSummary = $this->CalculateOrderSummary();
			}

			$GLOBALS['Subtotal'] = FormatPrice($orderSummary['subtotal']);

			$GLOBALS['CouponCodes'] = '';
			foreach($this->GetCartApi()->GetAppliedCouponCodes() as $coupon) {
				/* The below line has been added coz, if more products are added and when coupon code is applied, the amount of coupon code would be increased with the number of products. so re-assigning coupontotal with discount amount. - Vikas 
				if($coupon['coupontype'] == 0) // if discount type is dollar, then set it else no need
				{
					$coupon['coupontotal'] = $coupon['discount'];
				}*/
				$GLOBALS['CouponCode'] = isc_html_escape($coupon['couponcode']);
				$GLOBALS['CouponId'] =  $coupon['couponid'];
				$GLOBALS['CouponCodeAmount'] = FormatPrice($coupon['coupontotal']);
				$GLOBALS['CouponCodes'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('OrderSummaryCouponCode');
			}

			$GLOBALS['GiftWrappingTotal'] = FormatPrice($orderSummary['wrappingCost']);
			if($orderSummary['wrappingCost'] == 0) {
				$GLOBALS['HideGiftWrappingTotal'] = 'display: none';
			}

			$GLOBALS['ShippingCost'] = FormatPrice($orderSummary['shippingCost']);
			if(!$this->GetCartApi()->AllProductsInCartAreIntangible()) {
				$GLOBALS['ShippingMethod'] = isc_html_escape($orderSummary['shippingMethod']);
			}
			else {
				$GLOBALS['HideShipping'] = 'display: none';
			}

			$GLOBALS['HandlingCost'] = FormatPrice($orderSummary['handlingCost']);
			if($orderSummary['handlingCost'] == 0) {
				$GLOBALS['HideHandlingCost'] = 'display: none';
			}

			$GLOBALS['TaxName'] = isc_html_escape($orderSummary['taxName']);
			$GLOBALS['TaxCost'] = FormatPrice($orderSummary['taxCost']);

			if($orderSummary['taxIncluded'] == 0) {
				$GLOBALS['HideIncludedTaxCost'] = 'display: none';
			}
			else {
				$GLOBALS['HideTaxCost'] = 'display: none';
			}

			$GLOBALS['Total'] = FormatPrice($orderSummary['total']);

			$GLOBALS['GiftCertificates'] = $GLOBALS['CompanyGiftCertificates'] = '';

			$adjustedTotal = $orderSummary['total'];
			foreach($this->GetCartApi()->GetGiftCertificates() as $certificate) {
				$GLOBALS['GiftCertificateCode'] = isc_html_escape($certificate['giftcertcode']);
				$GLOBALS['GiftCertificateId'] = $certificate['giftcertid'];

                if (!isset($certificate['giftcertamountused'])) {
                    if($certificate['giftcertbalance'] > $adjustedTotal) {
                        $certificate['giftcertbalance'] = $certificate['giftcertbalance'] - $adjustedTotal;
                        $certificate['giftcertamountused'] = $certificate['giftcertbalance'] - ($certificate['giftcertbalance'] - $adjustedTotal);
                    }
                    else {
                        $certificate['giftcertamountused'] = $certificate['giftcertbalance'];
                        $certificate['giftcertbalance'] = 0;
                    }
                }
				
				$adjustedTotal -= $certificate['giftcertamountused'];

				$GLOBALS['GiftCertificateRemaining'] = FormatPrice($certificate['giftcertbalance']);
				$GLOBALS['CertificateAmountUsed'] = FormatPrice($certificate['giftcertamountused']);
				$GLOBALS['GiftCertificates'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('OrderSummaryGiftCertificate');
			}

			if($orderSummary['giftCertificateTotal'] == 0) {
				$GLOBALS['HideGiftCertificateTotal'] = 'display: none';
			}
			$GLOBALS['GiftCertificateTotal'] = FormatPrice($orderSummary['giftCertificateTotal']);

			if($orderSummary['storeCredit'] == 0) {
				$GLOBALS['HideStoreCredit'] = 'display: none';
			}
			$GLOBALS['StoreCreditTotal'] = FormatPrice($orderSummary['storeCredit']);

			if($orderSummary['adjustedTotalCost'] != $orderSummary['total']) {
				$GLOBALS['AdjustedTotalCost'] = FormatPrice($orderSummary['adjustedTotalCost']);
			}
			else {
				$GLOBALS['HideAdjustedTotal'] = 'display: none';
			}
            
            // dada.wang 20120406 for cgc summary
            if (isset($orderSummary['companyGiftCertificates']) && is_array($orderSummary['companyGiftCertificates'])) {
                foreach($orderSummary['companyGiftCertificates'] as $certificate) {
                    $GLOBALS['CompanyGiftCertificateCode'] = isc_html_escape($certificate['cgccode']);
                    $GLOBALS['CompanyGiftCertificateId'] = $certificate['cgcid'];

                    $GLOBALS['CompanyGiftCertificateRemaining'] = FormatPrice($certificate['cgcbalance']);
                    $GLOBALS['CompanyCertificateAmountUsed'] = FormatPrice($certificate['amountused']);
                    $GLOBALS['CompanyGiftCertificates'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('OrderSummaryCompanyGiftCertificate');
                }
            }
            
            if($orderSummary['companyGiftCertificateTotal'] == 0) {
				$GLOBALS['HideCompanyGiftCertificateTotal'] = 'display: none';
			}
            
			$GLOBALS['GompanyGiftCertificateTotal'] = FormatPrice($orderSummary['companyGiftCertificateTotal']);

			return $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('OrderSummaryTable');
		}

		/**
		 * Generate an individual row for the order items table.
		 *
		 * @param string The unique identifier for this row.
		 * @param array Array of details about the product for this row.
		 * @param boolean Set to true to hide this row by default.
		 * @return string The generated HTML row for this item.
		 */
		public function GenerateOrderItemRow($rowId, $product=array(), $hidden=false, $resetPrices=false)
		{
			static $first = true;
			static $publicWrappingOptions = null;

			if($hidden == true) {
				$GLOBALS['HideRow'] = 'display: none';
			}
			else {
				$GLOBALS['HideRow'] = '';
			}
			
			//2011-9-13 alandy add shipping data show.
			$GLOBALS['ShippingdataRow'] = '';
			

			if(is_null($publicWrappingOptions)) {
				$wrappingOptions = $GLOBALS['ISC_CLASS_DATA_STORE']->Read('GiftWrapping');
				if(empty($wrappingOptions)) {
					$publicWrappingOptions = false;
				}
				else {
					$publicWrappingOptions = true;
				}
			}

			if($first != true) {
				$GLOBALS['HideInsertTip'] = 'display: none';
			}
			$first = false;

			if(empty($product)) {
				$GLOBALS['CartItemId'] = $rowId;
				$GLOBALS['ProductCode'] = '';
				$GLOBALS['vendorprefix'] = '';
				$GLOBALS['shippingDate'] = '';
				$GLOBALS['isshippingDate'] = '';
				$GLOBALS['trackingNumber'] = '';
				$GLOBALS['ProductId'] = 0;
				$GLOBALS['ProductName'] = '';
				$GLOBALS['HideWrappingOptions'] = 'display: none';
				$GLOBALS['HideProductFields'] = 'display: none;';
				$GLOBALS['HideProductVariation'] = 'display: none;';
				$GLOBALS['ProductPrice'] = FormatPrice(0, false, false, true);
				$GLOBALS['ProductQuantity'] = 1;
				$GLOBALS['ProductTotal'] = FormatPrice(0);
				$GLOBALS['HideEventDate'] = 'display : none;';
				$GLOBALS['EventDate'] = '';
				$GLOBALS['ShippingdataRow']='';
                $GLOBALS['ResetPrice'] = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Reset_Price) ? "<input {$GLOBALS['ResetChecked']} value=\"{$GLOBALS['ResetStatus']}\" type='checkbox' name='cartItem[$rowId][resetPrice]' onclick='ResetPrice(this)'/>&nbsp;reset price" : '';
				
                return $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('OrderItem');
			}

			$GLOBALS['CartItemId'] = $rowId; //isc_html_escape($product['cartitemid']);

			// If the item in the cart is a gift certificate, we need to show a special type of row
			if (isset($product['type']) && $product['type'] == "giftcertificate") {
				$GLOBALS['ProductCode'] = GetLang('NA');
				$GLOBALS['ProductName'] = isc_html_escape($product['product_name']);
				$GLOBALS['ProductQuantity'] = (int)$product['quantity'];
				$GLOBALS['ProductPrice'] = FormatPrice($product['product_price']);
				$GLOBALS['ProductTotal'] = FormatPrice($product['product_price'] * $product['quantity']);
				return $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('OrderItemGiftCertificate');
			}
			// Normal product in the cart
			else {
                require_once ISC_BASE_PATH . '/lib/discountcalcs.php';
				
				/**********************************************************************
					Code altered by Mayank Jaitly on 05 July 2010
				/**********************************************************************/
					
				$GLOBALS['YMMYearTemp']=$product['year'];
				$GLOBALS['YMMMakeTemp']=$product['make'];
				$GLOBALS['YMMModelTemp']=$product['model'];
				$GLOBALS['YMMbedsizeTemp']=$product['bedsize'];
				$GLOBALS['YMMcabsizeTemp']=$product['cabsize'];			
			
				$GLOBALS['ProductId'] = $product['product_id'];
				$GLOBALS['ProductName'] = isc_html_escape($product['product_name']);
				$GLOBALS['ProductQuantity'] = (int)$product['quantity'];
				$GLOBALS['ProductCode'] = $product['product_code'];
				$GLOBALS['vendorprefix'] = $product['vendorprefix'] . '-';
				$GLOBALS['shippingDate'] = $product['shippingDate'];
				$GLOBALS['isshippingDate'] = $product['isshippingDate'];
				$GLOBALS['trackingNumber'] = $product['trackingNumber'];
				//alandy 2011-9-13 modify shipping date.
			
				if(isset($GLOBALS['isshippingDate']) && $GLOBALS['isshippingDate'] != '01/01/1900' && !empty($GLOBALS['shippingDate'])){
				  $GLOBALS['ShippingdataRow'] ="<div><div style='float:left; width:180px;'>".$GLOBALS['shippingDate']."</div><div style='float:left; width:400px; word-break:break-all; word-wrap:break-word;'>".$GLOBALS['trackingNumber']."</div></div>";
				}
				
				// Don't use the discount price here as we'll be showing the coupon codes
				// down below in the summary table
                $productPrice = (isset($product['discount_price']) && $product['discount_price'] < $product['product_price']) ? $product['discount_price'] : $product['product_price'];
				
                //20110503 alandy add resetprice.
                
			    if($resetPrices){
					$GLOBALS['PriceReadonly'] = '';
					$GLOBALS['ResetChecked'] = 'checked';
					$GLOBALS['ResetStatus'] = '1';
				}else{
					$GLOBALS['PriceReadonly'] = 'readonly class="Field50 ItemPrice ReadonlyText"';
					$GLOBALS['ResetChecked'] = '';
					$GLOBALS['ResetStatus'] = '0';
				}
				
				$GLOBALS['ProductPrice'] = FormatPrice($productPrice, false, false, true);
				$GLOBALS['ProductTotal'] = FormatPrice($productPrice*$product['quantity']);

				// Initialize the configurable product fields
				$GLOBALS['HideProductFields'] = 'display: none;';
				$GLOBALS['ProductFields'] = '';
				if(!empty($product['product_fields']) && is_array($product['product_fields'])) {
					$GLOBALS['HideProductFields'] = '';
					foreach($product['product_fields'] as $fieldId => $field) {
						switch($field['fieldType']) {
							case 'file':
								if(isset($field['fieldExisting'])) {
									$fileDirectory = 'configured_products';
								}
								else {
									$fileDirectory = 'configured_products_tmp';
								}
								$fieldValue = '<a href="'.GetConfig('ShopPath').'/'.GetConfig('ImageDirectory').'/'.$fileDirectory.'/'.$field['fileName'].'" target="_blank">'.isc_html_escape($field['fileOriginName']).'</a>';
								break;
							case 'checkbox':
								$fieldValue = GetLang('Checked');
								break;
							default:
								if(isc_strlen($field['fieldValue']) > 50) {
									$field['fieldValue'] = isc_substr($field['fieldValue'], 0, 50)." ..";
								}
								$fieldValue = isc_html_escape($field['fieldValue']);
								// browser is decoding the entities in the ajax response which prevents the row from loading so we need to double encode
								if(isset($_REQUEST['ajaxFormUpload'])) {
									$fieldValue = isc_html_escape($fieldValue);
								}
						}

						if(!trim($fieldValue)) {
							continue;
						}

						$GLOBALS['ProductFields'] .= '
							<dt>'.isc_html_escape($field['fieldName']).':</dt>
							<dd>'.$fieldValue.'</dd>
						';
					}
				}

				// Can this item be wrapped?
				$GLOBALS['HideWrappingOptions'] = 'display: none';
				if($product['data']['prodtype'] == PT_PHYSICAL && @$product['data']['prodwrapoptions'] != -1 && $publicWrappingOptions == true) {
					$GLOBALS['HideWrappingOptions'] = '';

					if(isset($product['wrapping'])) {
						$GLOBALS['GiftWrappingName'] = isc_html_escape($product['wrapping']['wrapname']);
						$GLOBALS['HideGiftWrappingAdd'] = 'display: none';
						$GLOBALS['HideGiftWrappingEdit'] = '';
						$GLOBALS['HideGiftWrappingPrice'] = '';
						$GLOBALS['GiftWrappingPrice'] = CurrencyConvertFormatPrice($product['wrapping']['wrapprice']);
					}
					else {
						$GLOBALS['GiftWrappingName'] = '';
						$GLOBALS['HideGiftWrappingAdd'] = '';
						$GLOBALS['HideGiftWrappingEdit'] = 'display: none';
						$GLOBALS['HideGiftWrappingPrice'] = 'display: none';
						$GLOBALS['GiftWrappingPrice'] = '';
					}
				}

				// Is this product a variation?
				$GLOBALS['ProductOptions'] = '';
				$GLOBALS['HideProductVariation'] = 'display: none';
				if(isset($product['options']) && !empty($product['options'])) {
					$comma = '';
					$GLOBALS['HideProductVariation'] = '';
					foreach($product['options'] as $name => $value) {
						if(!trim($name) || !trim($value)) {
							continue;
						}
						$GLOBALS['ProductOptions'] .= $comma.isc_html_escape($name).": ".isc_html_escape($value);
						$comma = ' / ';
					}
				}
				else if(isset($product['data']['prodvariationid']) && $product['data']['prodvariationid'] > 0) {
					$GLOBALS['HideProductVariation'] = '';
					$GLOBALS['ProductOptions'] = GetLang('xNone');
				}

				if (isset($product['data']['prodeventdaterequired']) && $product['data']['prodeventdaterequired']) {
					$GLOBALS['HideEventDate'] = '';
					$GLOBALS['EventDate'] = '<dl><dt>'.$product['data']['prodeventdatefieldname'].': </dt><dd>'.isc_date('jS M Y', $product['event_date']).'</dd></dl>';

				} else {
					$GLOBALS['HideEventDate'] = 'display : none;';
					$GLOBALS['EventDate'] = '';
				}
                
                $GLOBALS['ResetPrice'] = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Reset_Price) ? "<input {$GLOBALS['ResetChecked']} value=\"{$GLOBALS['ResetStatus']}\" type='checkbox' name='cartItem[{$GLOBALS['CartItemId']}][resetPrice]' onclick='ResetPrice(this)'/>&nbsp;reset price" : '';
				
				$this->setOtherinfo($product['data'], true);

				return $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('OrderItem');
			}
		}

		private function RefundOrder()
		{
			$message = '';
			$messageStaus = MSG_ERROR;
			$provider = null;

			if(!isset($_REQUEST['orderid'])) {
				return false;
			}

			$orderId = $_REQUEST['orderid'];
			$order = GetOrder($_REQUEST['orderid']);
			if(!isset($order['orderid'])) {
				return false;
			}


			/* Validate posted data*/
			$refundType = '';
			if(!isset($_REQUEST['refundType'])) {
				return false;
			}

			$refundType = $_REQUEST['refundType'];

			//preset the refund amount to the available amount of the order
			$refundAmt = $order['ordgatewayamount'] - $order['ordrefundedamount'];

			//refund partial amount
			if($refundType== 'partial') {
				//is refund amount specified
				if(!isset($_REQUEST['refundAmt']) || $_REQUEST['refundAmt'] == '') {
					$message = GetLang('EnterRefundAmount');
				}
				//is refund amount specified a valid format
				else if(!is_numeric($_REQUEST['refundAmt']) || $_REQUEST['refundAmt'] <= 0) {
					$message = GetLang('InvalidRefundAmountFormat');
				}
				//is refund amount larger than the original order amount
				else if($_REQUEST['refundAmt'] + $order['ordrefundedamount']  > $order['ordgatewayamount']) {
					$message = GetLang('InvalidRefundAmount');
				}
				else {
					$refundAmt = $_REQUEST['refundAmt'];
				}
			}

			//there is an error message
			if($message != '') {
				FlashMessage($message, $messageStatus, 'index.php?ToDo=viewOrders');
			}

			$transactionId = trim($order['ordpayproviderid']);
			if($transactionId == '') {
				$message = GetLang('OrderTranscationIDNotFound');
			}
			else if(!GetModuleById('checkout', $provider, $order['orderpaymentmodule'])) {
				$message = GetLang('PaymentMethodNotExist');
			}
			else if(!$provider->IsEnabled()) {
				$message = GetLang('PaymentProviderIsDisabled');
			}
			else if(!method_exists($provider, "DoRefund")) {
				$message = GetLang('RefundNotAvailable');
			}
			else {
				//still here, perform a delay capture
				if($provider->DoRefund($order, $message, $refundAmt)) {
					$messageStatus = MSG_SUCCESS;

					//update order status
					$orderStatus = ORDER_STATUS_REFUNDED;
					UpdateOrderStatus($order['orderid'], $orderStatus, true);
				}
			}
			FlashMessage($message, $messageStatus, 'index.php?ToDo=viewOrders');

			return $message;
		}

		/**
		 * Format an address for display in the control panel for an order or shipment.
		 *
		 * @param array An array of details about the address.
		 * @param boolean Set to false to not include a flag image for the address country.
		 * @return string The generated HTML of the formatted address.
		 */
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
         * Generate Random password -- Baskaran
         */
        function generatePassword() {
            $chars="ABCDEFGHJKLMNPQRSTUVWXYZ23456789abcdefghijkmnpqrstuvwxyz";
            $minchars=8;
            $maxchars=8;
            $escapecharplus=0;
            $repeat=mt_rand($minchars,$maxchars);
            while ($escapecharplus<$repeat)
            {
                $randomword.=$chars[mt_rand(1, strlen($chars)-1)];
                $escapecharplus+=1;
            }
            return $randomword;
        }
	
	//set product info when adding order
	public function setOtherinfo($product, $hardrefresh=false, $includeDropshipped=false){
		if($hardrefresh){
			if($includeDropshipped){
				$queryFormat = "SELECT p.jobberprice, p.prodinvtrack, p.prodcurrentinv, 
							b.brandname, b.dropshipped, b.shippingtime,
							bs.seriesname, bs.serieslogoimage, bs.dropshipped bsdropshipped,bs.shippingtime seriesshippingtime,
							IF(bs.dropshipped=1, bs.dropshipped, b.dropshipped) AS proddropshipped
						FROM [|PREFIX|]products p
						      INNER JOIN [|PREFIX|]brands b on p.prodbrandid = b.brandid
						      LEFT JOIN [|PREFIX|]brand_series AS bs ON bs.seriesid = p.brandseriesid 
						WHERE p.productid='%s'";
			}else{
				$queryFormat = "SELECT p.prodinvtrack, p.prodcurrentinv
						FROM [|PREFIX|]products p
						WHERE p.productid='%s'";
			}
			$result = $GLOBALS['ISC_CLASS_DB']->Query(sprintf($queryFormat, $product['productid']));
			$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
			
			if(!$row){
				return ;
			}else{
				$product = $row;
			}
		}

        	$GLOBALS['stockdropship']=$this->getStockDropship($product);
        	
        }
	
	//get in stock str
	public function getStockDropship($row){
      	
        	$stock = " In stock: N/A";
        	$ignoreDropshipped = false;
        	if(isset($row["prodinvtrack"]) && ($row["prodinvtrack"]==1) && isset($row['prodcurrentinv']))
        	{
        		if($row['prodcurrentinv'] > 0)
        		{
        			$stock = "In Stock:".$row['prodcurrentinv'];
        			$ignoreDropshipped = true;
        		}
        		else
        		{
        			$stock = "Sold Out";
        		}
        	}

        	if(isset($row["proddropshipped"]) && ($row["proddropshipped"]==1) && !$ignoreDropshipped){
        		
        		return $this->SetDropShip(true, $stock, $row);
        	}else{
        		return $stock;
        	}
        }
	
	private function SetDropShip($flag,$info,$row){
		//return $row['seriesname'].":".$row['bsdropshipped'].":".$row['dropshipped'];
		if(!$flag){return $info;}
		$shippingtime="";
		if($row['seriesname']!='' && $row['bsdropshipped']=='1'){
			$shippingtime=$row['seriesshippingtime'];
		}else if($row['dropshipped']=='1'){
			$shippingtime=$row['shippingtime'];
		}
		
		if($shippingtime==""){
		    $shippingtime = "24h";
		}
		
		$shippingtime=str_replace("24h","24 hours",$shippingtime);
		$shippingtime=str_replace("2d","2 business days",$shippingtime);
		$shippingtime=str_replace("3d","3 business days",$shippingtime);
		$shippingtime=str_replace("4d","4 business days",$shippingtime);
		$shippingtime=str_replace("1w","1 week",$shippingtime);
		return "Drop Ship: ".$shippingtime;
	}
	
	public function CheckProductExist($prodId, $prodCode, $prodName){
		
		$query = "SELECT count(0) as num from [|PREFIX|]products WHERE productid = $prodId and prodname = '$prodName' and prodcode = '$prodCode'";
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
		if( $row['num'] > 0) {
			return true;
		}else{
			return false;
		}
	}
	
	public function GetProductVendorprefix($prodId){
		$query = "SELECT prodvendorprefix from [|PREFIX|]products WHERE productid = $prodId";
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
		if( $row['prodvendorprefix']) {
			return $row['prodvendorprefix'];
		}else{
			return "";
		}
	}
	
	public function GetOrderProductInfo($orderId, $prodId){
		$query = "SELECT ordtrackingno, DATE_FORMAT(orddateshipped,'%d/%m/%Y') AS orddateshipped from [|PREFIX|]order_products WHERE orderorderid = $orderId and ordprodid = $prodId";
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
		if( $row) {
			return $row;
		}else{
			return "";
		}
	}
	//alandy_2012-3-28 add for search orderowner.
	public function GetOderOwner(){
		$tmp = array();
		$query = "select pk_userid,username from [|PREFIX|]users group by pk_userid order by username asc";
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)){
			if(!empty($row['username']) && $row['username'] != 'system') $tmp[] = $row;
		}
		
		return $tmp;
		
	}
    
    /**
     * dada.wang 2012-04-10 if has gc or cgc was remove then use this function to remove it
     */
    private function RemoveGCAndCGC(&$order) {
        $removeCGC = $this->GetCartApi()->Get('RemoveCGC');
        if ($removeCGC && is_array($removeCGC)) {
            if (!isset($order['extraInfo']['companygiftcertificates']) || !is_array($order['extraInfo']['companygiftcertificates'])) {
                $order['extraInfo']['companygiftcertificates'] = array();
            }
            $companyGiftcertificates = GetClass('ISC_ADMIN_COMPANY_GIFTCERTIFICATES');
            foreach ($removeCGC as $cgcId) {
                $companyGiftcertificates->RemoveAppliedCGCFromOrder($cgcId, $order['orderid']);
                unset($order['extraInfo']['companygiftcertificates'][$cgcId]);
                if (empty($order['extraInfo']['companygiftcertificates'])) {
                    unset($order['extraInfo']['companygiftcertificates']);
                }
            }
        }
        
        $removeGC = $this->GetCartApi()->Get('RemoveGC');
        if ($removeGC && is_array($removeGC)) {
            if (!isset($order['extraInfo']['giftcertificates']) || !is_array($order['extraInfo']['giftcertificates'])) {
                $order['extraInfo']['giftcertificates'] = array();
            }
            $giftcertificates = GetClass('ISC_ADMIN_GIFTCERTIFICATES');
            foreach ($removeGC as $gcId) {
                $giftcertificates->RemoveAppliedGCFromOrder($gcId, $order['orderid']);
                unset($order['extraInfo']['giftcertificates'][$gcId]);
                if (empty($order['extraInfo']['giftcertificates'])) {
                    unset($order['extraInfo']['giftcertificates']);
                }
            }
        }
        
        if ($removeCGC || $removeGC) {
            $orderSummary = $this->CalculateOrderSummary();
        
            $order['giftcertificates'] = $this->GetCartApi()->GetGiftCertificates();
            $order['companygiftcertificates'] = $this->GetCartApi()->Get('COMPANYGIFTCERTIFICATES');
            $order['giftcertificateamount']	= $orderSummary['giftCertificateTotal'];
            $order['companygiftcertificateamount'] = $orderSummary['companyGiftCertificateTotal'];
            $order['gatewayamount']	= $orderSummary['adjustedTotalCost'];
            $order['totalcost']	= $orderSummary['total'];
        }
    }
    
    public function GetOrderCompanyGiftCertificatesUsed(&$orderData) {
        $orderData['extrainfo'] = is_array($orderData['extrainfo']) ? $orderData['extrainfo'] : unserialize($orderData['extrainfo']);
        $companyGiftCertificates = array();
        
        if ($orderData['ordcompanygiftcertificateamount'] > 0 && isset($orderData['extrainfo']['companygiftcertificates']) && !empty($orderData['extrainfo']['companygiftcertificates'])) {
            foreach ($orderData['extrainfo']['companygiftcertificates'] as $item) {
                $companyGiftCertificates[$item['cgcid']] = array(
                    "cgccode" => $item['cgccode'],
                    "cgcid" => $item['cgcid'],
                    "cgcamount" => $item['cgcamount'],
                    "cgcbalance" => $item['cgcbalance'],
                    'amountused' => $orderData['ordcompanygiftcertificateamount']
                );
            }
        } else {
            $query = "
			SELECT
				g.cgccode,
				g.cgcid,
				g.cgcamount,
                g.cgcbalance,
                h.histbalanceused
			FROM
				[|PREFIX|]company_gift_certificate_history h
				LEFT JOIN [|PREFIX|]company_gift_certificates g ON g.cgcid	= h.histcgcid
			WHERE
				h.historderid = '".(int)$orderData['orderid']."' AND histbalanceused > 0";
            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);

            while($certificate = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                $companyGiftCertificates[$certificate['cgcid']] = array(
                    "cgccode" => $certificate['cgccode'],
                    "cgcid" => $certificate['cgcid'],
                    "cgcamount" => $certificate['cgcamount'],
                    "cgcbalance" => $certificate['cgcbalance'],
                    'amountused' => $certificate['histbalanceused']
                );
            }
        }
        return $companyGiftCertificates;
    }
    
    public function GetOrderGiftCertificatesUsed(&$orderData) {
        $orderData['extrainfo'] = is_array($orderData['extrainfo']) ? $orderData['extrainfo'] : unserialize($orderData['extrainfo']);
        $giftCertificates = array();
        
        if ($orderData['ordgiftcertificateamount'] > 0 && isset($orderData['extrainfo']['giftcertificates']) && !empty($orderData['extrainfo']['giftcertificates'])) {
            foreach ($orderData['extrainfo']['giftcertificates'] as $item) {
                $giftCertificates[$item['giftcertid']] = array(
                    "giftcertcode" => $item['giftcertcode'],
                    "giftcertid" => $item['giftcertid'],
                    "giftcertamount" => $item['giftcertamount'],
                    "giftcertbalance" => $item['giftcertbalance'],
                    "giftcertexpirydate" => '',
                    'giftcertamountused' => $orderData['ordgiftcertificateamount']
                );
            }
        } else {
            $query = "
			SELECT
				g.giftcertcode,
                g.giftcertamount,
				h.histgiftcertid,
				h.histbalanceused,
                h.histbalanceremaining
			FROM
				[|PREFIX|]gift_certificate_history h
				LEFT JOIN [|PREFIX|]gift_certificates g ON g.giftcertid	= h.histgiftcertid
			WHERE
				h.historderid = '".(int)$orderData['orderid']."' AND histbalanceused > 0";

            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
            
            while($certificate = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                $giftCertificates[$certificate['histgiftcertid']] = array(
                    "giftcertcode" => $certificate['giftcertcode'],
                    "giftcertid" => $certificate['histgiftcertid'],
                    "giftcertamount" => $certificate['giftcertamount'],
                    "giftcertbalance" => $certificate['histbalanceremaining'],
                    "giftcertexpirydate" => "",
                    'giftcertamountused' => $certificate['histbalanceused'],
                );
            }
        }
        return $giftCertificates;
    }
	
}
?>