<?php
class ISC_ADMIN_GIFTCERTIFICATES
{
	public $_customSearch = array();

	public function __construct()
	{
		// Initialise custom searches functionality
		require_once(dirname(__FILE__).'/class.customsearch.php');
		$GLOBALS['ISC_CLASS_ADMIN_CUSTOMSEARCH'] = new ISC_ADMIN_CUSTOMSEARCH('giftcertificates');
	}

	public function HandleToDo($Do)
	{
		if(!gzte11(ISC_LARGEPRINT)) {
			exit;
		}
		$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('giftcertificates');
		switch (isc_strtolower($Do))
		{
			case "creategiftcertificateview":
				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_GiftCertificates)) {

					$GLOBALS['BreadcrumEntries'] = array(
						$GLOBALS["ISC_LANG"]['Home'] => "index.php",
						$GLOBALS["ISC_LANG"]['GiftCertificates'] => "index.php?ToDo=viewGiftCertificates",
						$GLOBALS["ISC_LANG"]['CreateGiftCertificateView'] => "index.php?ToDo=createGiftCertificateView"
					);

					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->CreateView();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
				}
				break;
			case "deletecustomgiftcertificatesearch":
				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_GiftCertificates)) {

					$GLOBALS['BreadcrumEntries'] = array(
						$GLOBALS["ISC_LANG"]['Home'] => "index.php",
						$GLOBALS["ISC_LANG"]['GiftCertificates'] => "index.php?ToDo=viewGiftCertificates"
					);

					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->DeleteCustomSearch();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
				}
				break;
			case "customgiftcertificatesearch":
				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_GiftCertificates)) {
					$GLOBALS['BreadcrumEntries'] = array(
						$GLOBALS["ISC_LANG"]['Home'] => "index.php",
						$GLOBALS["ISC_LANG"]['GiftCertificates'] => "index.php?ToDo=viewGiftCertificates",
						$GLOBALS["ISC_LANG"]['CustomView'] => "index.php?ToDo=customGiftCertificateSearch"
					);

					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->CustomSearch();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
				}
				break;
			case "searchgiftcertificatesredirect":
				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_GiftCertificates)) {

					$GLOBALS['BreadcrumEntries'] = array(
						$GLOBALS["ISC_LANG"]['Home'] => "index.php",
						$GLOBALS["ISC_LANG"]['GiftCertificates'] => "index.php?ToDo=viewGiftCertificates",
						$GLOBALS["ISC_LANG"]['SearchResults'] => "index.php?ToDo=searchGiftCertificates"
					);

					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->SearchGiftCertificatesRedirect();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
				}
				break;
			case "searchgiftcertificates":
				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_GiftCertificates)) {

					$GLOBALS['BreadcrumEntries'] = array(
						$GLOBALS["ISC_LANG"]['Home'] => "index.php",
						$GLOBALS["ISC_LANG"]['GiftCertificates'] => "index.php?ToDo=viewGiftCertificates",
						$GLOBALS["ISC_LANG"]['SearchGiftCertificates'] => "index.php?ToDo=searchGiftCertificates"
					);

					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->SearchGiftCertificates();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
				}
				break;
			case "deletegiftcertificates":
				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_GiftCertificates)) {

					$GLOBALS['BreadcrumEntries'] = array(
						$GLOBALS["ISC_LANG"]['Home'] => "index.php",
						$GLOBALS["ISC_LANG"]['GiftCertificates'] => "index.php?ToDo=viewGiftCertificates"
					);

					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->DeleteGiftCertificates();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
				}
				break;
			case "viewgiftcertificatespopup":
					if(isset($_POST['orderId'])) 
					$this->Sendmailagain($_POST['orderId']);
					else
					$this->PreviewGiftCertificate();
				break;
			default:
				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_GiftCertificates)) {
					if(isset($_GET['searchQuery'])) {
						$GLOBALS['BreadcrumEntries'] = array(
							$GLOBALS["ISC_LANG"]['Home'] => "index.php",
							$GLOBALS["ISC_LANG"]['GiftCertificates'] => "index.php?ToDo=viewGiftCertificates",
							$GLOBALS["ISC_LANG"]['SearchResults'] => "index.php?ToDo=viewGiftCertificates"
						);
					}
					else {
						$GLOBALS['BreadcrumEntries'] = array(
							$GLOBALS["ISC_LANG"]['Home'] => "index.php",
							$GLOBALS["ISC_LANG"]['GiftCertificates'] => "index.php?ToDo=viewGiftCertificates"
						);
					}

					if(!isset($_REQUEST['ajax'])) {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					}
					$this->ManageGiftCertificates();
					if(!isset($_REQUEST['ajax'])) {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					}
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
				}
		}
	}

	private function ManageGiftCertificatesGrid(&$numGiftCertificates)
	{
		// Show a list of products in a table
		$page = 0;
		$start = 0;
		$numPages = 0;
		$GLOBALS['GiftCertificatesGrid'] = "";
		$GLOBALS['Nav'] = "";
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

		$validSortFields = array('giftcertid', 'giftcertcode', 'giftcertto', 'giftcertfrom', 'giftcertcustid', 'giftcertamount', 'giftcertbalance', 'giftcertstatus', 'giftcertpurchasedate', 'giftcertexpiry', 'customername');
		if(isset($_REQUEST['sortField']) && in_array($_REQUEST['sortField'], $validSortFields)) {
			$sortField = $_REQUEST['sortField'];
			SaveDefaultSortField("ManageGiftCertificates", $_REQUEST['sortField'], $sortOrder);
		} else {
			list($sortField, $sortOrder) = GetDefaultSortField("ManageGiftCertificates", "giftcertid", $sortOrder);
		}

		if(isset($_GET['page'])) {
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

		// Limit the number of gift certificates returned
		if ($page == 1) {
			$start = 1;
		} else {
			$start = ($page * ISC_GIFTCERTIFICATES_PER_PAGE) - (ISC_GIFTCERTIFICATES_PER_PAGE-1);
		}

		$start = $start-1;

		// Get the results for the query
		$certificateResult = $this->_GetGiftCertificatesList($start, $sortField, $sortOrder, $numGiftCertificates);

		$numPages = ceil($numGiftCertificates / ISC_GIFTCERTIFICATES_PER_PAGE);

		// Add the "(Page x of n)" label
		if($numGiftCertificates > ISC_GIFTCERTIFICATES_PER_PAGE) {
			$GLOBALS['Nav'] = sprintf("(%s %d of %d) &nbsp;&nbsp;&nbsp;", GetLang('Page'), $page, $numPages);
			$GLOBALS['Nav'] .= BuildPagination($numGiftCertificates, ISC_GIFTCERTIFICATES_PER_PAGE, $page, sprintf("index.php?ToDo=viewGiftCertificates%s", $sortURL));
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
		$GLOBALS['SearchQuery'] = $query;
		$GLOBALS['SortField'] = $sortField;
		$GLOBALS['SortOrder'] = $sortOrder;

		$sortLinks = array(
			"Id" => "giftcertid",
			"CertificateAmount" => "giftcertamount",
			"CertificateBalance" => "giftcertbalance",
			"PurchaseDate" => "giftcertpurchasedate",
			"Status" => "giftcertstatus",
			"Code" => "giftcertcode",
			"Cust" => "customername"
		);
		BuildAdminSortingLinks($sortLinks, "index.php?ToDo=viewGiftCertificates&amp;page=".$page, $sortField, $sortOrder);


		$GLOBALS['GiftCertificateStatusList'] = $this->GetGiftCertificateStatusOptions();

		// Display the gift certificates
		while ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($certificateResult)) {
			$GLOBALS['GiftCertificateId'] = (int) $row['giftcertid'];
			$GLOBALS['GiftCertificateCode'] = isc_html_escape($row['giftcertcode']);
			$GLOBALS['GiftCertificateTo'] = isc_html_escape($row['giftcertto']);
			$GLOBALS['GiftCertificateToEmail'] = isc_html_escape($row['giftcerttoemail']);
			$GLOBALS['GiftCertificateFrom'] = isc_html_escape($row['giftcertfrom']);
			$GLOBALS['GiftCertificateFromEmail'] = isc_html_escape($row['giftcertfromemail']);
			$GLOBALS['GiftCertificateCustomerId'] = (int) $row['giftcertcustid'];
			$GLOBALS['GiftCertificateCustomerName'] = isc_html_escape($row['customername']);
			$GLOBALS['GiftCertificateAmount'] = FormatPrice($row['giftcertamount']);
			$GLOBALS['GiftCertificateBalance'] = FormatPrice($row['giftcertbalance']);
			$GLOBALS['GiftCertificatePurchaseDate'] = isc_date(GetConfig('DisplayDateFormat'), $row['giftcertpurchasedate']);
			if($row['giftcertexpirydate'] != 0) {
				$GLOBALS['GiftCertificateExpiryDate'] = isc_date(GetConfig('DisplayDateFormat'), $row['giftcertexpirydate']);
			}
			else {
				$GLOBALS['GiftCertificateExpiryDate'] = GetLang('NA');
			}

			// Something of this gift certificate has been sent so we need to show the expand icon
			if($row['giftcertbalance'] != $row['giftcertamount']) {
				$GLOBALS['ExpandIcon'] = '+';
			}
			else {
				$GLOBALS['ExpandIcon'] = '';
			}

			$GLOBALS['GiftCertificateStatusOptions'] = $this->GetGiftCertificateStatusOptions($row['giftcertstatus']);

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("giftcertificates.manage.row");
			$GLOBALS['GiftCertificatesGrid'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
		}
		$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("giftcertificates.manage.grid");
		return $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate(true);
	}

	private function ManageGiftCertificates($MsgDesc = "", $MsgStatus = "")
	{
		$GLOBALS['HideClearResults'] = "none";
		$status = array();
		$num_custom_searches = 0;

		// Fetch any results, place them in the data grid
		$GLOBALS['GiftCertificatesDataGrid'] = $this->ManageGiftCertificatesGrid($numCertificates);

		// Was this an ajax based sort? Return the table now
		if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 1) {
			echo $GLOBALS['GiftCertificatesDataGrid'];
			return;
		}

		if(isset($this->_customSearch['searchname'])) {
			$GLOBALS['ViewName'] = $this->_customSearch['searchname'];
		}
		else {
			$GLOBALS['ViewName'] = GetLang('AllGiftCertificates');
			$GLOBALS['HideDeleteViewLink'] = "none";
		}

		if(isset($_REQUEST['searchQuery']) || isset($_GET['searchId'])) {
			$GLOBALS['HideClearResults'] = "";
		}

		if($numCertificates > 0) {
			if($MsgDesc == "" && (isset($_REQUEST['searchQuery']) || isset($_GET['searchId']))) {
				if($numCertificates == 1) {
					$MsgDesc = GetLang('GiftCertificateSearchResultsBelow1');
				}
				else {
					$MsgDesc = sprintf(GetLang('GiftCertificateSearchResultsBelowX'), $numCertificates);
				}

				$MsgStatus = MSG_SUCCESS;
			}
		}

		// Get the custom search as option fields
		$GLOBALS['CustomSearchOptions'] = $GLOBALS['ISC_CLASS_ADMIN_CUSTOMSEARCH']->GetSearchesAsOptions(@$_GET['searchId'], $num_custom_searches, "AllGiftCertificates", "viewGiftCertificates", "customGiftCertificateSearch");

		if(!isset($_REQUEST['searchId'])) {
			$GLOBALS['HideDeleteCustomSearch'] = "none";
		} else {
			$GLOBALS['CustomSearchId'] = (int)$_REQUEST['searchId'];
		}

		// No gift certificatess
		if($numCertificates == 0) {
			$GLOBALS['DisplayGrid'] = "none";

			// Performing a search of some kind
			if(count($_GET) > 1) {
				if ($MsgDesc == "") {
					$GLOBALS['Message'] = MessageBox(GetLang('NoGiftCertificateResults'), MSG_ERROR);
				}
			} else {
				$GLOBALS['Message'] = MessageBox(GetLang('NoGiftCertificates'), MSG_SUCCESS);
				$GLOBALS['DisplaySearch'] = "none";
			}
			$GLOBALS['DisableDelete'] = "disabled=\"disabled\"";
		}

		if($MsgDesc != "") {
			$GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
		}

		$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("giftcertificates.manage");
		$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();

	}

	private function _GetGiftCertificatesList($Start, $SortField, $SortOrder, &$NumGiftCertificates)
	{
		// Return a a MySQL result for a query about gift certificates.
		$fields = "g.*, CONCAT(c.custconfirstname, ' ', c.custconlastname) AS customername";

		// Are there any search parameters?
		$queryWhere = " WHERE 1=1 and ";
		$innerJoin = '';

		if(isset($_REQUEST['searchQuery']) && $_REQUEST['searchQuery'] != "") {
			$search_query = $GLOBALS['ISC_CLASS_DB']->Quote($_REQUEST['searchQuery']);
			$queryWhere .= sprintf("(giftcertid='%d' OR giftcertcode LIKE '%%%s%%') and ", $GLOBALS['ISC_CLASS_DB']->Quote($search_query), $GLOBALS['ISC_CLASS_DB']->Quote($search_query));
		}

		if(isset($_REQUEST['orderId']) && $_REQUEST['orderId'] != 0) {
			$fields = "DISTINCT(giftcertid), " . $fields;
			$queryWhere .= sprintf("historderid='%d' and ", $GLOBALS['ISC_CLASS_DB']->Quote($_REQUEST['orderId']));
			$innerJoin = "INNER JOIN [|PREFIX|]gift_certificate_history h ON (h.histgiftcertid=giftcertid)";
		}

		if(isset($_REQUEST['toEmail']) && $_REQUEST['toEmail'] != "") {
			$to_email = $GLOBALS['ISC_CLASS_DB']->Quote($_REQUEST['toEmail']);
			$queryWhere .= sprintf("giftcerttoemail LIKE '%%%s%%') and ( ", $GLOBALS['ISC_CLASS_DB']->Quote($to_email), $GLOBALS['ISC_CLASS_DB']->Quote($to_email));
		}

		if(isset($_REQUEST['fromEmail']) && $_REQUEST['fromEmail'] != "") {
			$from_email = $GLOBALS['ISC_CLASS_DB']->Quote($_REQUEST['fromEmail']);
			$queryWhere .= sprintf("giftcertfromemail LIKE '%%%s%%') and ( ", $GLOBALS['ISC_CLASS_DB']->Quote($from_email), $GLOBALS['ISC_CLASS_DB']->Quote($from_email));
		}

		if(isset($_REQUEST['customerId']) && $_REQUEST['customerId'] != "") {
			$customer_id = (int)$_REQUEST['customerId'];
			$queryWhere .= sprintf("giftcertcustid='%d' and ", $GLOBALS['ISC_CLASS_DB']->Quote($customer_id));
		}

		if(isset($_REQUEST['certificateStatus']) && $_REQUEST['certificateStatus'] != "") {
			$certificate_status = (int)$_REQUEST['certificateStatus'];
			$queryWhere .= sprintf("giftcertstatus='%d' and ", $GLOBALS['ISC_CLASS_DB']->Quote($certificate_status));
		}

		if(isset($_REQUEST['certificateFrom']) && isset($_REQUEST['certificateTo']) && $_REQUEST['certificateFrom'] != "" && $_REQUEST['certificateTo'] != "") {
			$certificate_from = (int)$_REQUEST['certificateFrom'];
			$certificate_to = (int)$_REQUEST['certificateTo'];
			$queryWhere .= sprintf("(giftcertid >= '%d' and giftcertid <= '%d') and ", $GLOBALS['ISC_CLASS_DB']->Quote($certificate_from), $GLOBALS['ISC_CLASS_DB']->Quote($certificate_to));
		}
		else if(isset($_REQUEST['certificateFrom']) && $_REQUEST['certificateFrom'] != "") {
			$certificate_from = (int)$_REQUEST['certificateFrom'];
			$queryWhere .= sprintf("giftcertid >= '%d' and ", $GLOBALS['ISC_CLASS_DB']->Quote($certificate_from));
		}
		else if(isset($_REQUEST['certificateTo']) && $_REQUEST['certificateTo'] != "") {
			$certificate_to = (int)$_REQUEST['certificateTo'];
			$queryWhere .= sprintf("giftcertid <= '%d' and ", $GLOBALS['ISC_CLASS_DB']->Quote($certificate_to));
		}

		if(isset($_REQUEST['amountFrom']) && isset($_REQUEST['amountTo']) && $_REQUEST['amountFrom'] != "" && $_REQUEST['amountTo'] != "") {
			$amount_from = FormatPrice($_REQUEST['amountFrom']);
			$amount_to = FormatPrice($_REQUEST['amountTo']);
			$queryWhere .= sprintf("(giftcertamount >= '%d' and giftcertamount <= '%d') and ", $GLOBALS['ISC_CLASS_DB']->Quote($amount_from), $GLOBALS['ISC_CLASS_DB']->Quote($amount_to));
		}
		else if(isset($_REQUEST['amountFrom']) && $_REQUEST['amountFrom'] != "") {
			$amount_from = FormatPrice($_REQUEST['amountFrom']);
			$queryWhere .= sprintf("giftcertamount >= '%d' and ", $GLOBALS['ISC_CLASS_DB']->Quote($amount_from));
		}
		else if(isset($_REQUEST['amountTo']) && $_REQUEST['amountTo'] != "") {
			$amount_to = FormatPrice($_REQUEST['amountTo']);
			$queryWhere .= sprintf("giftcertamount <= '%d' and ", $GLOBALS['ISC_CLASS_DB']->Quote($amount_to));
		}

		if(isset($_REQUEST['balanceFrom']) && isset($_REQUEST['balanceTo']) && $_REQUEST['balanceFrom'] != "" && $_REQUEST['balanceTo'] != "") {
			$balance_from = FormatPrice($_REQUEST['balanceFrom']);
			$balance_to = FormatPrice($_REQUEST['balanceTo']);
			$queryWhere .= sprintf("(giftcertbalance >= '%d' and giftcertbalance <= '%d') and ", $GLOBALS['ISC_CLASS_DB']->Quote($balance_from), $GLOBALS['ISC_CLASS_DB']->Quote($balance_to));
		}
		else if(isset($_REQUEST['balanceFrom']) && $_REQUEST['balanceFrom'] != "") {
			$balance_from = FormatPrice($_REQUEST['balanceFrom']);
			$queryWhere .= sprintf("giftcertbalance >= '%d' and ", $GLOBALS['ISC_CLASS_DB']->Quote($balance_from));
		}
		else if(isset($_REQUEST['balanceTo']) && $_REQUEST['balanceTo'] != "") {
			$balance_to = FormatPrice($_REQUEST['balanceTo']);
			$queryWhere .= sprintf("giftcertbalance <= '%d' and ", $GLOBALS['ISC_CLASS_DB']->Quote($balance_to));
		}

		// Limit results to a particular date range
		if(isset($_REQUEST['dateRange']) && $_REQUEST['dateRange'] != "") {
			$range = $_REQUEST['dateRange'];
			switch($range) {
				// Gift Certificates purchased within the last day
				case "today":
					$from_stamp = mktime(0, 0, 0, isc_date("m"), isc_date("d"), isc_date("Y"));
					break;
				// Gift Certificates purchased in the last 2 days
				case "yesterday":
					$from_stamp = mktime(0, 0, 0, isc_date("m"), isc_date("d")-1, isc_date("Y"));
					$to_stamp = mktime(0, 0, 0, isc_date("m"), isc_date("d")-1, isc_date("Y"));
					break;
				// Gift Certificates purchased in the last 24 hours
				case "day":
					$from_stamp = time()-60*60*24;
					break;
				// Gift Certificates purchased in the last 7 days
				case "week":
					$from_stamp = time()-60*60*24*7;
					break;
				// Gift Certificates purchased in the last 30 days
				case "month":
					$from_stamp = time()-60*60*24*30;
					break;
				// Gift Certificates purchased this month
				case "this_month":
					$from_stamp = mktime(0, 0, 0, isc_date("m"), 1, isc_date("Y"));
					break;
				// Gift Certificates purchased this year
				case "this_year":
					$from_stamp = mktime(0, 0, 0, 1, 1, isc_date("Y"));
					break;
				// Custom date
				default:
					if(isset($_REQUEST['fromDate']) && $_REQUEST['fromDate'] != "") {
						$from_date = $_REQUEST['fromDate'];
						$from_data = explode("/", $from_date);
						$from_stamp = mktime(0, 0, 0, $from_data[0], $from_data[1], $from_data[2]);
					}
					if(isset($_REQUEST['toDate']) && $_REQUEST['toDate'] != "") {
						$to_date = $_REQUEST['toDate'];
						$to_data = explode("/", $to_date);
						$to_stamp = mktime(0, 0, 0, $to_data[0], $to_data[1], $to_data[2]);
					}
			}

			if(isset($from_stamp)) {
				$queryWhere .= sprintf("giftcertpurchasedate >= '%d' and ", $GLOBALS['ISC_CLASS_DB']->Quote($from_stamp));
				unset($from_stamp);
			}
			if(isset($to_stamp)) {
				$queryWhere .= sprintf("giftcertpurchasedate <= '%d' and ", $GLOBALS['ISC_CLASS_DB']->Quote($to_stamp));
				unset($to_stamp);
			}
		}

		// Limit results to a particular date range
		if(isset($_REQUEST['expiryRange']) && $_REQUEST['expiryRange'] != "") {
			$range = $_REQUEST['expiryRange'];
			switch($range) {
				// Gift certificates that expired within the last day
				case "today":
					$from_stamp = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
					break;
				// Gift certificates that expired in the last 2 days
				case "yesterday":
					$from_stamp = mktime(0, 0, 0, date("m"), date("d")-1, date("Y"));
					$to_stamp = mktime(0, 0, 0, date("m"), date("d")-1, date("Y"));
					break;
				case "tomorrow":
					$from_stamp = mktime(0, 0, 0, date("m"), date("d")+1, date("Y"));
					$to_stamp = mktime(0, 0, 0, date("m"), date("d")+1, date("Y"));
					break;
				// Gift certificates that expired in the last 24 hours
				case "day":
					$from_stamp = time()-60*60*24;
					break;
				// Gift certificates that expire in the next 7 days
				case "week":
					$from_stamp = time()+60*60*24*7;
					break;
				// Gift certificates that expire in the next 30 days
				case "month":
					$from_stamp = time()+60*60*24*30;
					break;
				// Gift certificates that expired this month
				case "this_month":
					$from_stamp = mktime(0, 0, 0, date("m"), 1, date("Y"));
					break;
				// Gift certificates that expire next month
				case "next_month":
					$from_stamp = mktime(0, 0, 0, date("m")+1, 1, date("Y"));
					break;
				//Gift certificates that expired this year
				case "this_year":
					$from_stamp = mktime(0, 0, 0, 1, 1, date("Y"));
					break;
				//Gift certificates that expire next year
				case "next_year":
					$from_stamp = mktime(0, 0, 0, 1, 1, date("Y")+1);
					break;

				// Custom date
				default:
					if(isset($_REQUEST['expiryFromDate']) && $_REQUEST['expiryFromDate'] != "") {
						$from_date = $_REQUEST['expiryFromDate'];
						$from_data = explode("/", $from_date);
						$from_stamp = mktime(0, 0, 0, $from_data[0], $from_data[1], $from_data[2]);
					}
					if(isset($_REQUEST['expiryToDate']) && $_REQUEST['expiryToDate'] != "") {
						$to_date = $_REQUEST['expiryToDate'];
						$to_data = explode("/", $to_date);
						$to_stamp = mktime(0, 0, 0, $to_data[0], $to_data[1], $to_data[2]);
					}
			}

			if(isset($from_stamp)) {
				$queryWhere .= sprintf("giftcertexpirydate >= '%d' and ", $GLOBALS['ISC_CLASS_DB']->Quote($from_stamp));
			}
			if(isset($to_stamp)) {
				$queryWhere .= sprintf("giftcertexpirydate <= '%d' and ", $GLOBALS['ISC_CLASS_DB']->Quote($to_stamp));
			}
		}

		// Strip out a trailing "or" if there is one
		$queryWhere= preg_replace('#and $#si', "", $queryWhere);

		$countQuery = sprintf("SELECT COUNT(giftcertid) FROM [|PREFIX|]gift_certificates g %s %s", $innerJoin, $queryWhere);
		$result = $GLOBALS["ISC_CLASS_DB"]->Query($countQuery);
		$NumGiftCertificates = $GLOBALS["ISC_CLASS_DB"]->FetchOne($result);

		$queryWhere .= sprintf(" order by %s %s", $SortField, $SortOrder);

		// Add the limit
		$queryWhere .= $GLOBALS["ISC_CLASS_DB"]->AddLimit($Start, ISC_GIFTCERTIFICATES_PER_PAGE);

		$query = sprintf("SELECT %s FROM [|PREFIX|]gift_certificates g %s LEFT JOIN [|PREFIX|]customers c ON (g.giftcertcustid=c.customerid) %s", $fields, $innerJoin, $queryWhere);

		$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
		return $result;
	}

	private function DeleteGiftCertificates()
	{
		if(isset($_POST['certificates'])) {
			$certificateIds = implode("','", $GLOBALS['ISC_CLASS_DB']->Quote($_POST['certificates']));
			$query = sprintf("DELETE FROM [|PREFIX|]gift_certificates WHERE giftcertid IN ('%s')", $certificateIds);
			$GLOBALS['ISC_CLASS_DB']->Query($query);

			$query = sprintf("DELETE FROM [|PREFIX|]gift_certificate_history WHERE histgiftcertid IN ('%s')", $certificateIds);
			$GLOBALS['ISC_CLASS_DB']->Query($query);

			// Log this action
			$GLOBALS['ISC_CLASS_LOG']->LogAdminAction(count($_POST['certificates']));

			$this->ManageGiftCertificates(GetLang('GiftCertificatesDeleted'), MSG_SUCCESS);
		} else {
			if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_GiftCertificates)) {
				$this->ManageGiftCertificates();
			} else {
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
			}
		}
	}

	private function SearchGiftCertificates()
	{
		$GLOBALS['GiftCertificateStatusOptions'] = $this->GetGiftCertificateStatusOptions();
		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("giftcertificates.search");
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
	}

	/**
	*	This function checks to see if the user wants to save the search details as a custom search,
	*	and if they do one is created. They are then forwarded onto the search results
	*/
	private function SearchGiftCertificatesRedirect()
	{

		// Are we saving this as a custom search?
		if(isset($_GET['viewName']) && $_GET['viewName'] != '') {
			$search_id = $GLOBALS['ISC_CLASS_ADMIN_CUSTOMSEARCH']->SaveSearch($_GET['viewName'], $_GET);

			if($search_id > 0) {

				// Log this action
				$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($search_id, $_GET['viewName']);

				ob_end_clean();
				header(sprintf("Location:index.php?ToDo=customGiftCertificateSearch&searchId=%d&new=true", $search_id));
				exit;
			}
			else {
				$this->ManageGiftCertificates(sprintf(GetLang('ViewAlreadExists'), $_GET['viewName']), MSG_ERROR);
			}
		}
		// Plain search
		else {
			$this->ManageGiftCertificates();
		}
	}

	/**
	*	Load a custom search
	*/
	private function CustomSearch()
	{

		$this->_customSearch = $GLOBALS['ISC_CLASS_ADMIN_CUSTOMSEARCH']->LoadSearch($_GET['searchId']);
		$_REQUEST = array_merge($_REQUEST, $this->_customSearch['searchvars']);

		if(isset($_REQUEST['new'])) {
			$this->ManageGiftCertificates(GetLang('CustomSearchSaved'), MSG_SUCCESS);
		} else {
			$this->ManageGiftCertificates();
		}
	}

	private function DeleteCustomSearch()
	{

		if($GLOBALS['ISC_CLASS_ADMIN_CUSTOMSEARCH']->DeleteSearch($_GET['searchId'])) {
			// Log this action
			$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($_GET['searchId']);

			$this->ManageGiftCertificates(GetLang('DeleteCustomSearchSuccess'), MSG_SUCCESS);
		}
		else {
			$this->ManageGiftCertificates(GetLang('DeleteCustomSearchFailed'), MSG_ERROR);
		}
	}

	/**
	*	Create a view for returns. Uses the same form as searching but puts the
	*	name of the view at the top and it's mandatory instead of optional.
	*/
	private function CreateView()
	{
		$GLOBALS['GiftCertificateStatusOptions'] = $this->GetGiftCertificateStatusOptions();
		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("giftcertificates.view");
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
	}

	private function GetGiftCertificateStatusOptions($selected=0)
	{
		$certificateStatuses = array(
			1 => "GiftCertificateStatusPending",
			2 => "GiftCertificateStatusActive",
			3 => "GiftCertificateStatusDisabled",
			4 => "GiftCertificateStatusExpired"
		);

		if (GetConfig('CurrencyLocation') == 'right') {
			$GLOBALS['CurrencyTokenLeft'] = '';
			$GLOBALS['CurrencyTokenRight'] = GetConfig('CurrencyToken');
		} else {
			$GLOBALS['CurrencyTokenLeft'] = GetConfig('CurrencyToken');
			$GLOBALS['CurrencyTokenRight'] = '';
		}

		$statuses = '';
		foreach($certificateStatuses as $id => $status) {
			$sel = '';
			if($id == $selected) {
				$sel = 'selected="selected"';
			}
			$statuses .= sprintf('<option value="%d" %s>%s</option>', $id, $sel, GetLang($status));
		}
		return $statuses;
	}

	// functions added by blessen
	private function Sendmailagain($orderId)
	{
		
		$this->ActivateGiftCertificates($orderId);

     $sendmsg  = '<BR><BR><div align="center">The Gift certifates has been send to the Recipient</div><BR><BR><BR>';
	 echo $sendmsg.= '<div align="center"><A href="javascript: self.close ()">Close this Window</A></div>';
	}

	// Show a preview of a gift certificate before purchasing added by bmb

	private function PreviewGiftCertificate()
	{

		
		if(!isset($_REQUEST['certificate_theme'])) {
			$_REQUEST['certificate_theme'] = 'General';
		}

		$_REQUEST['certificate_theme'] = basename($_REQUEST['certificate_theme']);
		$giftid =  $_REQUEST['id'];

		$query = "SELECT * FROM [|PREFIX|]gift_certificates WHERE giftcertid = '".$giftid."'  ";
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		$certificate = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

	
		//$certificate['giftcertamount'] = ConvertPriceToDefaultCurrency($certificate['giftcertamount']);
		
		echo $this->GenerateGiftCertificate($certificate,'preview');
		die();
	}

	public function GenerateGiftCertificate($certificate,$type)
	{
		$giftid =  $_REQUEST['id'];

		if(!isset($certificate['giftcerttemplate']) || $certificate['giftcerttemplate'] == "") {
			$certificate['giftcerttemplate'] = 'General';
		}

		$certificate['giftcerttemplate'] = basename($certificate['giftcerttemplate']);

		// The selected gift certificate does not exist - just use the first enabled theme
		if(!$certificate['giftcerttemplate'] || !file_exists(APP_ROOT."/templates/__gift_themes/" . $certificate['giftcerttemplate'])) {
			$enabledThemes = explode(",", GetConfig('GiftCertificateThemes'));
			$certificate['giftcertemplate'] = $enabledThemes[0];
		}

		$oldExt = $GLOBALS['ISC_CLASS_TEMPLATE']->templateExt;
		$GLOBALS['ISC_CLASS_TEMPLATE']->templateExt = "html";

		if(defined("ISC_ADMIN_CP")) {
			$tplPath = "../../templates/".GetConfig('template')."/";
			//$snippetPath = "../".$tplPath . "/Snippets/";
		}
		else {
			$tplPath = '';
			//$snippetPath = '';
		}

		$certificate['giftcerttemplate'] = str_replace(".html", "", $certificate['giftcerttemplate']);

		if(!isset($GLOBALS['ShopPathNormal'])) {
			$GLOBALS['ShopPathNormal'] = $GLOBALS['ShopPath'];
		}

		// Fetch the store logo or store title
		if(GetConfig('UseAlternateTitle')) {
			$text = GetConfig('AlternateTitle');
		}
		else {
			$text = GetConfig('StoreName');
		}

		//echo "<pre>";
		//print_r($text);

		$text = explode(" ", $text, 2);
		$text[0] = "<span class=\"Logo1stWord\">".$text[0]."</span>";
		$GLOBALS['LogoText'] = implode(" ", $text);

		$snippetPath = "../../../templates/__master/Snippets/";

		$GLOBALS['HeaderLogo'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet($snippetPath."LogoText");

		$GLOBALS['CharacterSet']=GetConfig('CharacterSet');
		$GLOBALS['GiftCertificateTo'] = isc_html_escape($certificate['giftcertto']);
		$GLOBALS['GiftCertificateToEmail'] = isc_html_escape($certificate['giftcerttoemail']);
		$GLOBALS['GiftCertificateFrom'] = isc_html_escape($certificate['giftcertfrom']);
		$GLOBALS['GiftCertificateFromEmail'] = isc_html_escape($certificate['giftcertfromemail']);
		$GLOBALS['GiftCertificateAmount'] = CurrencyConvertFormatPrice($certificate['giftcertamount']);
		$GLOBALS['GiftCertificateMessage'] = isc_html_escape($certificate['giftcertmessage']);
		$GLOBALS['GiftCertificateCode'] = isc_html_escape($certificate['giftcertcode']);
		if(isset($certificate['giftcertexpirydate']) && $certificate['giftcertexpirydate'] != 0) {
			$GLOBALS['GiftCertificateExpiryInfo'] = sprintf(GetLang('GiftCertificateExpiresOn'), CDate($certificate['giftcertexpirydate']));
		}
		else {
			$GLOBALS['GiftCertificateExpiryInfo'] = '';
		}

		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate($tplPath."../__gift_themes/".$certificate['giftcerttemplate']);
		$certificate = $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);

		$resentform = '<BR><div align ="center"><FORM METHOD=POST ACTION="index.php?ToDo=viewGiftcertificatesPopup" name="f1"><INPUT TYPE="hidden" name="orderId" value ='.$giftid.'><INPUT TYPE="submit" name = "sendmail" value = "Resend Certificate">	</FORM></div>';

		if ($type == 'preview') 	$certificate.= $resentform;

		$GLOBALS['ISC_CLASS_TEMPLATE']->templateExt = $oldExt;
		return $certificate;
	}

public function ActivateGiftCertificates($orderId)
	{
	

		$certificateUpdates = array();
		// Select all of the inactive gift certificates for this order
		$query = sprintf("SELECT * FROM [|PREFIX|]gift_certificates WHERE giftcertid='%d' ", $GLOBALS['ISC_CLASS_DB']->Quote($orderId));
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		while($certificate = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$certificateUpdates[] = $certificate['giftcertid'];

			// Send the gift certificate to the recipient
			$this->SendGiftCertificateEmail($certificate);
		}

		
	}

	/**
	 * Email a gift certificate to a defined recipient.
	 * This function will email a gift certificate to a recipient. It generates the gift certificate from
	 * the selected template and attaches it to the gift certificate email.
	 */
	public function SendGiftCertificateEmail($giftCertificate)
	{


		if(!$giftCertificate['giftcerttoemail']) {
			return;
		}

		$certificate = $this->GenerateGiftCertificate($giftCertificate,'mail');


		if(!isset($GLOBALS['ShopPathNormal'])) {
			$GLOBALS['ShopPathNormal'] = $GLOBALS['ShopPath'];
		}

		// Build the email
		$GLOBALS['ToName'] = isc_html_escape($giftCertificate['giftcertto']);
		$GLOBALS['FromName'] = isc_html_escape($giftCertificate['giftcertfrom']);
		$GLOBALS['FromEmail'] = isc_html_escape($giftCertificate['giftcertfromemail']);
		$GLOBALS['Amount'] = FormatPrice($giftCertificate['giftcertamount']);
		$GLOBALS['Intro'] = sprintf(GetLang('GiftCertificateEmailIntro'), $GLOBALS['FromName'], $GLOBALS['FromEmail'], $GLOBALS['Amount'], $GLOBALS['ShopPathNormal'], $GLOBALS['StoreName']);
		$GLOBALS['ISC_LANG']['GiftCertificateEmailInstructions'] = sprintf(GetLang('GiftCertificateEmailInstructions'), $GLOBALS['ShopPathNormal']);
		$GLOBALS['ISC_LANG']['GiftCertificateFrom'] = sprintf(GetLang('GiftCertificateFrom'), $GLOBALS['StoreName'], isc_html_escape($giftCertificate['giftcertfrom']));
		if($giftCertificate['giftcertexpirydate'] != 0) {
			$expiry = CDate($giftCertificate['giftcertexpirydate']);
			$GLOBALS['GiftCertificateExpiryInfo'] = sprintf(GetLang('GiftCertificateEmailExpiry'), $expiry);
		}

		$emailTemplate = FetchEmailTemplateParser();
		$emailTemplate->SetTemplate("giftcertificate_email");
		$message = $emailTemplate->ParseTemplate(true);
		$giftCertificate['giftcerttoemail'] = 'blessen.babu@clariontechnologies.co.in,navya.karnam@clariontechnologies.co.in,wenhuang07@gmail.com,lou@lofinc.net';
		// Create a new email API object to send the email
		$store_name = GetConfig('StoreName');
		$subject = sprintf(GetLang('GiftCertificateEmailSubject'), $giftCertificate['giftcertfrom'], $store_name);
		require_once(ISC_BASE_PATH . "/lib/email.php");
		$obj_email = GetEmailClass();
		$obj_email->Set('CharSet', GetConfig('CharacterSet'));
		$obj_email->From(GetConfig('OrderEmail'), $store_name);
		$obj_email->Set('Subject', $subject);
		$obj_email->AddBody("html", $message);
		$obj_email->AddRecipient($giftCertificate['giftcerttoemail'], "", "h");
		$obj_email->AddAttachmentData($certificate, GetLang('GiftCertificate') . ' #' . $giftCertificate['giftcertid'].".html");
		$email_result = $obj_email->Send();
	}



}
?>
