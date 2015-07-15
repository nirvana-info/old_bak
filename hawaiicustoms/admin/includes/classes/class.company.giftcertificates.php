<?php
class ISC_ADMIN_COMPANY_GIFTCERTIFICATES
{
	public $_customSearch = array();

	public function __construct()
	{		
		//initial for breadcrumb 
		$GLOBALS["ISC_LANG"]['CompanyGiftCertificates'] = "Company Gift Certificates";
		$GLOBALS["ISC_LANG"]['CreateCompanyGiftCertificates'] = "Creatre a Company Gift Certificates";
		$GLOBALS["ISC_LANG"]['EditCompanyGiftCertificate'] = "Edit Company Gift Certificates";
	}

	public function HandleToDo($Do)
	{
		if(!gzte11(ISC_LARGEPRINT)) {
			exit;
		}
		//$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('giftcertificates');
        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('company.giftcertificates'); // Add by NI_20100827_Jack
		switch (isc_strtolower($Do))
		{
			case "deletecompanygiftcertificates":
				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Company_GiftCertificates)) {

					$GLOBALS['BreadcrumEntries'] = array(
						$GLOBALS["ISC_LANG"]['Home'] => "index.php",
						$GLOBALS["ISC_LANG"]['CompanyGiftCertificates'] => "index.php?ToDo=viewCompanyGiftCertificates"
					);

					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->DeleteCompanyGiftCertificates();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
				}
				break;
			case "createcompanygiftcertificate":
				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Company_GiftCertificates)) {

					$GLOBALS['BreadcrumEntries'] = array(
						$GLOBALS["ISC_LANG"]['Home'] => "index.php",
						$GLOBALS["ISC_LANG"]['CompanyGiftCertificates'] => "index.php?ToDo=viewCompanyGiftCertificates",
						$GLOBALS["ISC_LANG"]['CreateCompanyGiftCertificates'] => "index.php?ToDo=createCompanyGiftCertificates"
					);

					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->CreateCompanyGiftCertificates();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
				}
				break;
			case "editcompanygiftcertificate":
				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Company_GiftCertificates)) {

					$GLOBALS['BreadcrumEntries'] = array(
						$GLOBALS["ISC_LANG"]['Home'] => "index.php",
						$GLOBALS["ISC_LANG"]['CompanyGiftCertificates'] => "index.php?ToDo=viewCompanyGiftCertificates",
						$GLOBALS["ISC_LANG"]['EditCompanyGiftCertificate'] => "index.php?ToDo=editCompanyGiftCertificate"
					);

					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->EditCompanyGiftCertificate();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
				}
				break;
			case "editcompanygiftcertificate2":
				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Company_GiftCertificates)) 
				{
					$GLOBALS['BreadcrumEntries'] = array(
						$GLOBALS["ISC_LANG"]['Home'] => "index.php",
						$GLOBALS["ISC_LANG"]['CompanyGiftCertificates'] => "index.php?ToDo=viewCompanyGiftCertificates"
					);

					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->EditCompanyGiftCertificate2();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
				}
				break;
			case "createcompanygiftcertificate2":
				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Company_GiftCertificates)) 
				{
					$GLOBALS['BreadcrumEntries'] = array(
						$GLOBALS["ISC_LANG"]['Home'] => "index.php",
						$GLOBALS["ISC_LANG"]['CompanyGiftCertificates'] => "index.php?ToDo=viewCompanyGiftCertificates"
					);

					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->CreateCompanyGiftCertificates2();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
				}
				break;
			case "viewcompanygiftcertificatespopup":
					if(isset($_POST['cgcId'])) 
						$this->Sendmailagain($_POST['cgcId']);
					else
						$this->PreviewCompanyGiftCertificate();
				break;
			default:
				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Company_GiftCertificates)) {
					
					$GLOBALS['BreadcrumEntries'] = array(
							$GLOBALS["ISC_LANG"]['Home'] => "index1.php",
							$GLOBALS["ISC_LANG"]['CompanyGiftCertificates'] => "index.php?ToDo=viewCompanyGiftCertificates"
						);
          
          ob_start();
					if(!isset($_REQUEST['ajax'])) {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					}
					$this->ManageGiftCertificates();
					if(!isset($_REQUEST['ajax'])) {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					}
          $buffer = ob_get_contents();
          ob_clean();
          $search = array(
              '<link rel="stylesheet" href="Styles/ui.datepicker.css" type="text/css" media="screen" />',
              '<script type="text/javascript" src="../javascript/jquery/plugins/jquery.ui.datepicker.js"></script>'
          );
          $replace = array('', '');
          
          echo str_replace($search, $replace, $buffer);
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
		$GLOBALS['CompanyGiftCertificatesGrid'] = "";
		$GLOBALS['Nav'] = "";
		$catList = "";
		$max = 0;

		if(isset($_REQUEST['sortOrder']) && $_REQUEST['sortOrder'] == "asc") {
			$sortOrder = "asc";
		}
		else {
			$sortOrder = "desc";
		}

		$validSortFields = array('cgcid', 'cgcname', 'cgccode', 'cgcto', 'cgcfrom', 'cgccustid', 'cgcamount', 'cgcbalance', 'cgcstatus', 'cgcpurchasedate', 'cgcexpiry', 'customername');
		if(isset($_REQUEST['sortField']) && in_array($_REQUEST['sortField'], $validSortFields)) {
			$sortField = $_REQUEST['sortField'];
			SaveDefaultSortField("ManageCompanyGiftCertificates", $_REQUEST['sortField'], $sortOrder);
		} else {
			list($sortField, $sortOrder) = GetDefaultSortField("ManageCompanyGiftCertificates", "cgcid", $sortOrder);
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
			$start = ($page * ISC_COMPANY_GIFTCERTIFICATES_PER_PAGE) - (ISC_COMPANY_GIFTCERTIFICATES_PER_PAGE-1);
		}

		$start = $start-1;

		// Get the results for the query
		$certificateResult = $this->_GetCompanyGiftCertificatesList($start, $sortField, $sortOrder, $numGiftCertificates);

		$numPages = ceil($numGiftCertificates / ISC_COMPANY_GIFTCERTIFICATES_PER_PAGE);

		// Add the "(Page x of n)" label
		if($numGiftCertificates > ISC_COMPANY_GIFTCERTIFICATES_PER_PAGE) {
			$GLOBALS['Nav'] = sprintf("(%s %d of %d) &nbsp;&nbsp;&nbsp;", GetLang('Page'), $page, $numPages);
			$GLOBALS['Nav'] .= BuildPagination($numGiftCertificates, ISC_COMPANY_GIFTCERTIFICATES_PER_PAGE, $page, sprintf("index.php?ToDo=viewCompanyGiftCertificates%s", $sortURL));
		}
		else {
			$GLOBALS['Nav'] = "";
      $GLOBALS['CurrentPageLink'] = "index.php?ToDo=viewCompanyGiftCertificates";
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
			"Id" => "cgcid",
			"CertificateAmount" => "cgcamount",
			"CertificateBalance" => "cgcbalance",
			"CertificateName" => "cgcname",
			"PurchaseDate" => "cgcpurchasedate",
			"Status" => "cgcstatus",
			"Code" => "cgccode",
			"Cust" => "customername"
		);
		BuildAdminSortingLinks($sortLinks, "index.php?ToDo=viewCompanyGiftCertificates&amp;page=".$page, $sortField, $sortOrder);


		$GLOBALS['GiftCertificateStatusList'] = $this->GetCompanyGiftCertificateStatusOptions();

		// Display the gift certificates
		while ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($certificateResult)) {
			$GLOBALS['cgcId'] = (int) $row['cgcid'];
			$GLOBALS['cgcCode'] = isc_html_escape($row['cgccode']);
			$GLOBALS['cgcTo'] = isc_html_escape($row['cgcto']);
			$GLOBALS['cgcToEmail'] = isc_html_escape($row['cgctoemail']);
			$GLOBALS['cgcAmount'] = FormatPrice($row['cgcamount']).' / '.FormatPrice($row['cgcbalance']);
			$GLOBALS['cgcBalance'] = FormatPrice($row['cgcbalance']);	
			$GLOBALS['cgcName'] = isc_html_escape($row['cgcname']);

			if(count(explode('$', $row['cgcto']))>1)
				$GLOBALS['cgcTos'] = isc_html_escape(str_replace('$', ', ', $row['cgcto']));
			else
				$GLOBALS['cgcTos'] = isc_html_escape($row['cgcto']);
			
			$GLOBALS['cgcPurchaseDate'] = isc_date(GetConfig('DisplayDateFormat'), $row['cgcpurchasedate']);
			if($row['cgcexpirydate'] != 0) {
				$GLOBALS['cgcPurchaseDate'] .= ' / '.isc_date(GetConfig('DisplayDateFormat'), $row['cgcexpirydate']);
			}
			else {
				$GLOBALS['cgcPurchaseDate'] .= ' / '.GetLang('GiftCertificateExpireNA');
			}

			// Something of this gift certificate has been sent so we need to show the expand icon
			if($row['cgcbalance'] != $row['cgcamount']) {
				$GLOBALS['ExpandIcon'] = '+';
			}
			else {
				$GLOBALS['ExpandIcon'] = '';
			}

			$GLOBALS['cgcStatusOptions'] = $this->GetCompanyGiftCertificateStatusOptions($row['cgcstatus']);
			if( ($row['cgcstatus'] == 3 || $row['cgcstatus'] == 4) && ! ($row['cgcsended']))
			{
//				$GLOBALS['cgcAction'] = "<a href='index.php?ToDo=editCompanyGiftCertificate&cgcid=".$row['cgcid']."' >Edit</a>";
			}
			else
			{
				$GLOBALS['cgcAction'] = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			}
            $GLOBALS['cgcsendedval'] = $row['cgcsended'];
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("company.giftcertificates.manage.row");
			$GLOBALS['cgcGrid'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
		}

		$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("company.giftcertificates.manage.grid");
		return $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate(true);
	}

	private function ManageGiftCertificates($MsgDesc = "", $MsgStatus = "")
	{
		$GLOBALS['HideClearResults'] = "none";
		$status = array();
		$num_custom_searches = 0;
		
		$GLOBALS['ViewCGCs'] ='test name';

		// Fetch any results, place them in the data grid
		$GLOBALS['CompanyGiftCertificatesDataGrid'] = $this->ManageGiftCertificatesGrid($numCertificates);

		// Was this an ajax based sort? Return the table now
		if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 1) {
			echo $GLOBALS['CompanyGiftCertificatesDataGrid'];
			return;
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
				$GLOBALS['Message'] = MessageBox(GetLang('NoCompanyGiftCertificates'), MSG_SUCCESS);
				$GLOBALS['DisplaySearch'] = "none";
			}
			$GLOBALS['DisableDelete'] = "disabled=\"disabled\"";
		}

		if($MsgDesc != "") {
			$GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
		}

		$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("company.giftcertificates.manage");
		$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();

	}

	private function _GetCompanyGiftCertificatesList($Start, $SortField, $SortOrder, &$NumGiftCertificates)
	{
		// Return a a MySQL result for a query about gift certificates.
		$fields = "g.*, CONCAT(c.custconfirstname, ' ', c.custconlastname) AS customername";

		$countQuery = "SELECT COUNT(cgcid) FROM [|PREFIX|]company_gift_certificates g ";
        if($_GET["orderId"]){
            $countQuery .= " left join [|PREFIX|]company_gift_certificate_history h on(g.cgcid=h.histcgcid) where h.historderid=".$_GET["orderId"];
        }
		$result = $GLOBALS["ISC_CLASS_DB"]->Query($countQuery);
		$NumGiftCertificates = $GLOBALS["ISC_CLASS_DB"]->FetchOne($result);

		$queryWhere .= sprintf(" order by %s %s", $SortField, $SortOrder);

		// Add the limit
		$queryWhere .= $GLOBALS["ISC_CLASS_DB"]->AddLimit($Start, ISC_COMPANY_GIFTCERTIFICATES_PER_PAGE);

		$query = sprintf("SELECT %s FROM [|PREFIX|]company_gift_certificates g LEFT JOIN [|PREFIX|]customers c ON (g.cgccustid=c.customerid) ", $fields);
        if($_GET["orderId"]){
            $query .= " left join [|PREFIX|]company_gift_certificate_history h on(g.cgcid=h.histcgcid) where h.historderid=".$_GET["orderId"];
        }
        $query .= sprintf(" %s", $queryWhere);

		$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
		return $result;
	}

	private function DeleteCompanyGiftCertificates()
	{
		if(isset($_POST['certificates'])) {
			$certificateIds = implode("','", $GLOBALS['ISC_CLASS_DB']->Quote($_POST['certificates']));
            // Delete " and cgcstatus <> 1 " by NI_20100901_Jack
            // Because there is no Pending status in cgc
			$query = sprintf("DELETE FROM [|PREFIX|]company_gift_certificates WHERE cgcid IN ('%s')", $certificateIds);
			$GLOBALS['ISC_CLASS_DB']->Query($query);

			$query = sprintf("DELETE FROM [|PREFIX|]company_gift_certificate_history WHERE histcgcid IN ('%s')", $certificateIds);
			$GLOBALS['ISC_CLASS_DB']->Query($query);

			// Log this action
			$GLOBALS['ISC_CLASS_LOG']->LogAdminAction(count($_POST['certificates']));

			$this->ManageGiftCertificates(GetLang('CompanyGiftCertificatesDeleted'), MSG_SUCCESS);
		} else {
			if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Company_GiftCertificates)) {
				$this->ManageGiftCertificates();
			} else {
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
			}
		}
	}
	
	private function CreateCompanyGiftCertificates()
	{
		$GLOBALS['Title'] = GetLang('CreateCompanyGiftCertificate');
		$GLOBALS['Intro'] = GetLang('CreateCompanyGiftCertificateIntro');
		$GLOBALS['FormAction'] = "createCompanyGiftCertificate2";
		$GLOBALS['Enabled'] = 'checked="checked"';
		$GLOBALS['AllCategoriesSelected'] = "selected=\"selected\"";
		$GLOBALS['UsedForCat'] = 'checked="checked"';
		$GLOBALS['cgcCode'] = GenerateCouponCode();

		$GLOBALS['ISC_CLASS_ADMIN_CATEGORY'] = GetClass('ISC_ADMIN_CATEGORY');
		$GLOBALS['CategoryList'] = $GLOBALS["ISC_CLASS_ADMIN_CATEGORY"]->GetCategoryOptions(array(), "<option %s value='%d'>%s</option>", 'selected="selected"', "- ", false);
		$GLOBALS['ToggleUsedFor'] = "ToggleUsedFor(0);";
		$GLOBALS['HideCouponCode'] = "none";
		$GLOBALS['MaxUses'] = '';
		$GLOBALS['recipientcount'] = 1;

		$GLOBALS['CurrencyToken'] = GetConfig('CurrencyToken');

		if (GetConfig('CurrencyLocation') == 'right') {
			$GLOBALS['CurrencyTokenLeft'] = '';
			$GLOBALS['CurrencyTokenRight'] = GetConfig('CurrencyToken');
		} else {
			$GLOBALS['CurrencyTokenLeft'] = GetConfig('CurrencyToken');
			$GLOBALS['CurrencyTokenRight'] = '';
		}
		
		// Get a list of the gift certificate themes
		$themes = @scandir(dirname(__FILE__)."/../../../templates/__gift_themes/");
		//$enabledThemes = explode(",", GetConfig('GiftCertificateThemes'));
        $enabledThemes = $this->getEnabledThemes();
		
		$GLOBALS['GiftCertificateThemes'] = '';
		if(count($enabledThemes) == 1) {
			$GLOBALS['HideThemeSelect'] = "none";
		}
		foreach($enabledThemes as $theme) {
			// Just double check this theme still actually exists
			if(in_array($theme, $themes)) {
				$themeName = preg_replace('#\.html$#i', "", $theme);
				$sel = '';
				if((isset($_POST['certificate_theme']) && $_POST['certificate_theme'] == $theme) || count($enabledThemes) == 1) {
					$sel = 'checked="checked"';
					$GLOBALS['SelectedCertificateTheme'] = $theme;
				}
				$GLOBALS['GiftCertificateThemes'] .= sprintf('<label><input type="radio" class="themeCheck" name="certificate_theme" value="%s" %s /> %s</label><br />', $theme, $sel, $themeName);
			}
		}

		if(!GetConfig('GiftCertificateThemes')) {
			$GLOBALS['HideErrorMessage'] = '';
			$GLOBALS['ErrorMessage'] = GetLang('NoGiftCertificateThemes');
			$GLOBALS['HideGiftCertificateForm'] = "none";
		}
		
		// Is there a minimum and maximum limit? Firstly convert them to our selected currency
		$GLOBALS['GiftCertificateMinimum'] = ConvertPriceToCurrency(GetConfig('CompanyGiftCertificateMinimum'));
		$GLOBALS['GiftCertificateMaximum'] = ConvertPriceToCurrency(GetConfig('CompanyGiftCertificateMaximum'));

		$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("company.giftcertificates.form");
		$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
	}
	
	private function CreateCompanyGiftCertificates2()
	{			
		$error = $this->_CommitCompanyGiftCertificate();
		if (empty($error)) {
			if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Company_GiftCertificates)) {
				$this->ManageGiftCertificates(GetLang('CompanyGiftCertificateCreatedSuccessfully'), MSG_SUCCESS);
			} else {
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('CompanyGiftCertificateCreatedSuccessfully'), MSG_SUCCESS);
			}
		} else {
			if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Company_GiftCertificates)) {
				$this->ManageGiftCertificates(sprintf(GetLang('ErrCompanyGiftCertificateNotCreated'), $error), MSG_ERROR);
			} else {
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(sprintf(GetLang('ErrCompanyGiftCertificateNotCreated'), $error), MSG_ERROR);
			}
		}
	}
	
	private function _CommitCompanyGiftCertificate($cgcId=0)
	{

		$_POST['cgcappliesto'] = $_POST['usedfor'];	
		if($_POST['cgcappliesto'] == "categories") {
			// Applies to categories
			$_POST['cgcappliestovalues'] = implode(",", array_map('intval', $_POST['catids']));
		}
		else {
			// Applies to products
			$_POST['cgcappliestovalues'] = implode(',', array_map('intval', explode(',', $_POST['prodids'])));
		}

		if (!empty($_POST['cgcexpires'])) {
			//$_POST['cgcexpires'] = ConvertDateToTime($_POST['cgcexpires']); comment by NI_20100901_Jack  make it same with coupon
            $vals = explode("/", $_POST['cgcexpires']);
            $mktime = mktime(23, 59, 59, $vals[0], $vals[1], $vals[2]);
            $_POST['cgcexpires'] = $mktime;
		} else {
			$_POST['cgcexpires'] = 0;
		}

		if (!isset($_POST['cgccode']) || empty($_POST['cgccode'])) {
			$_POST['cgccode'] = GenerateCouponCode();
		}

		if (isset($_POST['cgcenabled'])) {
			$_POST['cgcenabled'] = 1;
		} else {
			$_POST['cgcenabled'] = 0;
		}
		$_POST['cgcminpurchase'] = DefaultPriceFormat($_POST['cgcminpurchase']);
		$_POST['cgcamount'] = DefaultPriceFormat($_POST['cgcamount']);
        $_POST['cgcbalance'] = DefaultPriceFormat($_POST['cgcbalance']);
		
		for( $i=1; $i <= $_POST['recipientcount']; $i++)
		{
            if(empty($_POST['to_name_'.$i]) && empty($_POST['to_email_'.$i]))
                continue;
			if( $i == 1 or (empty($_POST['to_name']) and empty($_POST['to_email'])))
			{
				$_POST['to_name'] .= $_POST['to_name_'.$i];
				$_POST['to_email'] .= $_POST['to_email_'.$i];
			}
			else
			{
				$_POST['to_name'] .= '$'.$_POST['to_name_'.$i];
				$_POST['to_email'] .= '$'.$_POST['to_email_'.$i];
			}
		}
		
		if( $cgcId == 0 )
		{
			//check if code or name already exist
			$query = sprintf("select * from [|PREFIX|]company_gift_certificates where cgccode = '%s'", $_POST['cgccode']);
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			if($GLOBALS['ISC_CLASS_DB']->CountResult($result) > 0)
			{
				return GetLang('CompanyGiftCertificateCodeExists');
			}
			
			//new cgc
			$query = sprintf("insert into [|PREFIX|]company_gift_certificates (
					cgccode, cgcto, cgctoemail, 
					cgccustid, cgcamount, cgcbalance, cgcenabled, cgcmessage, 
					cgcname, cgcappliesto, cgcappliestovalues, cgcminpurchase, cgctemplate, 
					cgcexpirydate, cgcpurchasedate, cgcstatus) VALUES
					('%s', '%s', '%s', 
					%s, %s, %s, %s, '%s', 
					'%s', '%s', '%s', %s, '%s', 
					%s, %s, 2);",
					 $_POST['cgccode'], $_POST['to_name'], $_POST['to_email'],
					 0, $_POST['cgcamount'], $_POST['cgcbalance'], $_POST['cgcenabled'], $_POST['message'], 
					 $_POST['cgcname'], $_POST['cgcappliesto'], $_POST['cgcappliestovalues'], (int)$_POST['cgcminpurchase'], $_POST['certificate_theme'], 
					 $_POST['cgcexpires'], time());
			
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			
			if( $result == false )
				return GetLang('CompanyGiftCertificateInsertError');
			else
				return;
		}
		else
		{
			//check if code or name already exist
			$query = sprintf("select * from [|PREFIX|]company_gift_certificates where cgccode = '%s' and cgcid <> %s ", $_POST['cgccode'],$cgcId);

			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			if($GLOBALS['ISC_CLASS_DB']->CountResult($result) > 0)
			{
				return GetLang('CompanyGiftCertificateCodeExists');
			}
			
			//check balance			
			
			$query = sprintf("UPDATE [|PREFIX|]company_gift_certificates SET 
					cgccode = '%s', cgcto = '%s',cgctoemail = '%s',cgcamount = %s,cgcbalance = %s,
					cgcenabled = %s,cgcmessage = '%s',cgcname = '%s',cgcappliesto = '%s',cgcappliestovalues = '%s',
					cgcminpurchase = %s,cgctemplate = '%s',cgcexpirydate = %s WHERE cgcid = %s;", 
					$_POST['cgccode'], $_POST['to_name'], $_POST['to_email'], $_POST['cgcamount'], $_POST['cgcbalance'],
					$_POST['cgcenabled'], $_POST['message'],$_POST['cgcname'], $_POST['cgcappliesto'], $_POST['cgcappliestovalues'],
					$_POST['cgcminpurchase'], $_POST['certificate_theme'],$_POST['cgcexpires'],$cgcId);

			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			
			if( $result == false )
				return GetLang('ErrCompanyGiftCertificateNotUpdated');
			else
				return;
		}
	}

	private function GetCompanyGiftCertificateStatusOptions($selected=0)
	{
		$certificateStatuses = array(
			2 => "Active",
			3 => "Disabled",
			4 => "Expired"
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
			$statuses .= sprintf('<option value="%d" %s>%s</option>', $id, $sel, $status);
		}
		return $statuses;
	}
	
	private function EditCompanyGiftCertificate()
	{
		// Show the form to edit a news
		$cgcId = (int) $_GET['cgcid'];
        $GLOBALS['AmountReadOnly'] = 'readonly';
		$arrData = array();
		$sel_cats = array();

		if (GetConfig('CurrencyLocation') == 'right') {
			$GLOBALS['CurrencyTokenLeft'] = '';
			$GLOBALS['CurrencyTokenRight'] = GetConfig('CurrencyToken');
		} else {
			$GLOBALS['CurrencyTokenLeft'] = GetConfig('CurrencyToken');
			$GLOBALS['CurrencyTokenRight'] = '';
		}
		
		$GLOBALS['CurrencyToken'] = GetConfig('CurrencyToken');
		
		$this->_GetCGCData($cgcId, $arrData);

		if (count($arrData)>0) {
			if( $arrData['cgcstatus'] == 2 || $arrData['cgcsended'])
			{
				$this->ManageGiftCertificates(GetLang('CompanyGiftCertificateCanNotEdit'), MSG_ERROR);
				return;
			}
			$GLOBALS['Title'] = GetLang('EditCompanyGiftCertificate');
			$GLOBALS['Intro'] = GetLang('EditCompanyGiftCertificateIntro');
			$GLOBALS['FormAction'] = "editCompanyGiftCertificate2";
			$GLOBALS['cgcCode'] = isc_html_escape($arrData['cgccode']);
			$GLOBALS['cgcName'] = isc_html_escape($arrData['cgcname']);
			
			//applies to
			if($arrData['cgcappliesto'] == "categories") {
				// Show the categories list
				$GLOBALS['UsedForCat'] = 'checked="checked"';
				$GLOBALS['ToggleUsedFor'] = "ToggleUsedFor(0);";
				$sel_cats = explode(",", $arrData['cgcappliestovalues']);
				if($arrData['cgcappliestovalues'] == "0") {
					$GLOBALS['AllCategoriesSelected'] = "selected=\"selected\"";
				}
			}
			else {
				// Show the products textbox
				$GLOBALS['ToggleUsedFor'] = "ToggleUsedFor(1);";
				$GLOBALS['UsedForProd'] = 'checked="checked"';

				// Select a list of the products that this coupon is active for
				if($arrData['cgcappliestovalues'] != "") {
					$GLOBALS['SelectedProducts'] = '';
					$GLOBALS['ProductIds'] = '';
					$query = sprintf("SELECT productid, prodname FROM [|PREFIX|]products WHERE productid IN (%s) ORDER BY prodname ASC", $arrData['cgcappliestovalues']);
					$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
					while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
						$GLOBALS['SelectedProducts'] .= sprintf("<option value='%d'>%s</option>", $row['productid'], $row['prodname']);
						$GLOBALS['ProductIds'] .= $row['productid'].",";
					}
					$GLOBALS['ProductIds'] = isc_substr($GLOBALS['ProductIds'], 0, -1);
				}
			}
			$GLOBALS['ISC_CLASS_ADMIN_CATEGORY'] = GetClass('ISC_ADMIN_CATEGORY');
			$GLOBALS['CategoryList'] = $GLOBALS["ISC_CLASS_ADMIN_CATEGORY"]->GetCategoryOptions($sel_cats, "<option %s value='%d'>%s</option>", "selected=\"selected\"", "- ", false);
			
			if ($arrData['cgcminpurchase'] == 0) {
				$GLOBALS['MinPurchase'] = 0;
			} else {
				$GLOBALS['MinPurchase'] = CPrice($arrData['cgcminpurchase']);
			}
			if ($arrData['cgcexpirydate'] > 0) {
				$GLOBALS['ExpiryDate'] = isc_date("m/d/Y", $arrData['cgcexpirydate'], 0); 
			}
			if ($arrData['cgcenabled'] == 1) {
				$GLOBALS['Enabled'] = 'checked="checked"';
			}
			if( isset($arrData['cgcamount']) ) {
				$GLOBALS['Amount'] = CPrice($arrData['cgcamount']);
			}
			if( isset($arrData['cgcbalance']) ) {
				$GLOBALS['Balance'] = CPrice($arrData['cgcbalance']);
			}
			if( $arrData['cgcto'] )
				$GLOBALS['to_name'] = $arrData['cgcto'];		
			if( $arrData['cgctoemail'] )
				$GLOBALS['to_email'] = $arrData['cgctoemail'];	
			
			$to_name = explode('$', $arrData['cgcto']);
			$to_email = explode('$', $arrData['cgctoemail']);
			
			$GLOBALS['recipientcount'] = count($to_name);

			if( $GLOBALS['recipientcount'] <= 0 )
				$GLOBALS['recipientcount'] = 1;
			
			$GLOBALS['to_name_1'] = $to_name[0];
			$GLOBALS['to_email_1'] = $to_email[0];
			
			if( count($to_name) > 1 )
			{
				for( $i = 1; $i < count($to_name); $i++ )
				{
					$GLOBALS['recipient_other'] .= "<p id=\"recipient_" . ($i+1) ."\">Name:<input type=\"text\" class=\"Textbox Field200\" value=\"".$to_name[($i)]."\" id=\"to_name_".($i+1)."\" name=\"to_name_".($i+1)."\" onkeyup=\"getCustomerNameandEmail('to_name_result_".($i+1)."', ".($i+1).", this.value)\" >&nbsp;&nbsp;Email:<input type=\"text\" class=\"Textbox Field200\" value=\"".$to_email[($i)]."\" id=\"to_email_".($i+1)."\" name=\"to_email_".($i+1)."\">" . '<a href="#" onclick="deleteRecipient(' . ($i+1) . ');return false;">delete</a>' . "<div id=\"to_name_result_".($i+1)."\" name=\"to_name_result_1".($i+1)."\" class=\"ProductSearchResults  returnname\" ></div></p>";
				}
			}
				
			$GLOBALS['CompanyGiftCertificateMessage'] = $arrData['cgcmessage'];
			
			//theme
			// Get a list of the gift certificate themes
			$themes = @scandir(dirname(__FILE__)."/../../../templates/__gift_themes/");
			//$enabledThemes = explode(",", GetConfig('GiftCertificateThemes'));
            $enabledThemes = $this->getEnabledThemes();
			$GLOBALS['GiftCertificateThemes'] = '';
			if(count($enabledThemes) == 1) {
				$GLOBALS['HideThemeSelect'] = "none";
			}
			foreach($enabledThemes as $theme) {
				// Just double check this theme still actually exists
				if(in_array($theme, $themes)) {
					$themeName = preg_replace('#\.html$#i', "", $theme);
					$sel = '';
					if((isset($arrData['cgctemplate']) && $arrData['cgctemplate'] == $theme) || count($enabledThemes) == 1) {
						$sel = 'checked="checked"';
						$GLOBALS['SelectedCertificateTheme'] = $theme;
					}
					$GLOBALS['GiftCertificateThemes'] .= sprintf('<label><input type="radio" class="themeCheck" name="certificate_theme" value="%s" %s /> %s</label><br />', $theme, $sel, $themeName);
				}
			}
	
			if(!GetConfig('GiftCertificateThemes')) {
				$GLOBALS['HideErrorMessage'] = '';
				$GLOBALS['ErrorMessage'] = GetLang('NoGiftCertificateThemes');
				$GLOBALS['HideGiftCertificateForm'] = "none";
			}
			
			$GLOBALS['cgcId'] = (int) $arrData['cgcid'];
            // Add NI_20100901_Jack
            $GLOBALS['GiftCertificateMinimum'] = ConvertPriceToCurrency(GetConfig('CompanyGiftCertificateMinimum'));
            $GLOBALS['GiftCertificateMaximum'] = ConvertPriceToCurrency(GetConfig('CompanyGiftCertificateMaximum'));
			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("company.giftcertificates.form");
			$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();	
		}
		else {
			// The coupon doesn't exist
			if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Company_GiftCertificates)) {
				$this->ManageGiftCertificates(GetLang('CompanyGiftCertificateDoesntExist'), MSG_ERROR);
			} else {
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
			}
		}
	}
	
	private function _GetCGCData($cgcId = 0, &$RefArray)
	{
		if( $cgcId == 0 )
		{
			unset($RefArray);
			return;
		}
		else
		{
			$query = sprintf("select * from [|PREFIX|]company_gift_certificates where cgcid='%s'", $cgcId);
			$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
			if ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
				$RefArray = $row;
			}
		}
	}
	
	private function EditCompanyGiftCertificate2()
	{
		if (isset($_POST['cgcId']) && $_POST['cgcId'] != "")
		{
			$error = $this->_CommitCompanyGiftCertificate($_POST['cgcId']);
		}
		else
		{
			$error = GetLang('InvalidCompanyGiftCertificate');
		}
		if (empty($error)) {
			if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Company_GiftCertificates)) {
				$this->ManageGiftCertificates(GetLang('CompanyGiftCertificateUpdatedSuccessfully'), MSG_SUCCESS);
			} else {
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('CompanyGiftCertificateUpdatedSuccessfully'), MSG_SUCCESS);
			}
		} else {
			if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Company_GiftCertificates)) {
				$this->ManageGiftCertificates(sprintf(GetLang('ErrCompanyGiftCertificateNotUpdated'), $error), MSG_ERROR);
			} else {
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(sprintf(GetLang('ErrCompanyGiftCertificateNotUpdated'), $error), MSG_ERROR);
			}
		}
	}

	// functions added by blessen
	private function Sendmailagain($orderId)
	{
		
		$this->ActivateGiftCertificates($orderId);

     	$sendmsg  = '<BR><BR><div align="center">The Company Gift Certificate has been sent to the Recipient</div><BR><BR><BR>';
	 	echo $sendmsg.= '<div align="center"><A href="javascript: self.close ()">Close this Window</A></div>';
	}

	// Show a preview of a gift certificate before purchasing added by bmb

	private function PreviewCompanyGiftCertificate()
	{
		if(!isset($_REQUEST['certificate_theme'])) {
			$_REQUEST['certificate_theme'] = 'General';
		}

		$_REQUEST['certificate_theme'] = basename($_REQUEST['certificate_theme']);
		$giftid =  $_REQUEST['id'];

		$query = "SELECT * FROM [|PREFIX|]company_gift_certificates WHERE cgcid = '".$giftid."'  ";
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		$certificate = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
	
		//$certificate['giftcertamount'] = ConvertPriceToDefaultCurrency($certificate['giftcertamount']);
		
		echo $this->GenerateCompanyGiftCertificate($certificate,'preview');
		die();
	}

	public function GenerateCompanyGiftCertificate($certificate,$type)
	{

		if(!isset($certificate['cgctemplate']) || $certificate['cgctemplate'] == "") {
			$certificate['cgctemplate'] = 'General';
		}

		$certificate['cgctemplate'] = basename($certificate['cgctemplate']);

		// The selected gift certificate does not exist - just use the first enabled theme
		if(!$certificate['cgctemplate'] || !file_exists(dirname(__FILE__)."/../../../templates/__gift_themes/" . $certificate['cgctemplate'])) {
			//$enabledThemes = explode(",", GetConfig('GiftCertificateThemes'));
            $enabledThemes = $this->getEnabledThemes();
			$certificate['cgctemplate'] = $enabledThemes[0];
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

		$certificate['cgctemplate'] = str_replace(".html", "", $certificate['cgctemplate']);

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
//		if(count(explode('$', $certificate['cgcto']))>1)
//			$GLOBALS['GiftCertificateTo'] = isc_html_escape(str_replace('$', ', ', $certificate['cgcto']));
//		else
//			$GLOBALS['GiftCertificateTo'] = isc_html_escape($certificate['cgcto']);
        //$tmp_cgcto_array = explode('$',$certificate['cgcto']);
        //$GLOBALS['GiftCertificateTo'] = isc_html_escape($tmp_cgcto_array[0]);
        //$GLOBALS['GiftCertificateFrom'] = GetLang('CompanyGiftCertificateFrom');
        //d($GLOBALS['GiftCertificateFrom']);
		//$GLOBALS['GiftCertificateToEmail'] = isc_html_escape($certificate['cgctoemail']);
		$GLOBALS['GiftCertificateAmount'] = CurrencyConvertFormatPrice($certificate['cgcamount']);
		$GLOBALS['GiftCertificateMessage'] = isc_html_escape($certificate['cgcmessage']);
		$GLOBALS['GiftCertificateCode'] = isc_html_escape($certificate['cgccode']);
		if(isset($certificate['cgcexpirydate']) && $certificate['cgcexpirydate'] != 0) {
			$GLOBALS['GiftCertificateExpiryInfo'] = sprintf(GetLang('GiftCertificateExpiresOn'), CDate($certificate['cgcexpirydate']));
		}
		else {
			$GLOBALS['GiftCertificateExpiryInfo'] = '';
		}

        $GLOBALS['CGCAPPLYTO'] = '';
        if($certificate['cgcappliesto'] == 'categories'){
            $GLOBALS['CGCAPPLYTO'] .= GetLang('Categories').":<br>";
            if($certificate['cgcappliestovalues'] == '0') {
                    $GLOBALS['CGCAPPLYTO'] .= GetLang('AllCategory');
            }else{
                if(!empty($certificate['cgcappliestovalues'])){
                    $query = sprintf("SELECT GROUP_CONCAT(catname ORDER BY catname ASC SEPARATOR '<br>') as catnamestr FROM [|PREFIX|]categories WHERE catparentid in (%s)", $GLOBALS['ISC_CLASS_DB']->Quote($certificate['cgcappliestovalues']));
                    $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
                    if ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
                        $GLOBALS['CGCAPPLYTO'] .= $row['prodnamestr'];
                        $GLOBALS['CGCAPPLYTO'] .= $row['catnamestr'];
                    }
                }
            }
        }else{
            $GLOBALS['CGCAPPLYTO'] .= GetLang('Products').":<br>";
            if(!empty($certificate['cgcappliestovalues'])){
                $query = sprintf("select GROUP_CONCAT(prodname ORDER BY prodname ASC SEPARATOR '<br>') as prodnamestr from [|PREFIX|]products where productid in(%s)", $GLOBALS['ISC_CLASS_DB']->Quote($certificate['cgcappliestovalues']));
                $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
                if ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
                    $GLOBALS['CGCAPPLYTO'] .= $row['prodnamestr'];
                }
            }
        }
		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate($tplPath."../__gift_themes/CGC_".$certificate['cgctemplate']);

		$body_str = $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);

        $tmpstr = '';
        if($certificate['cgcsended']){
            $tmpstr = 'Resend Company Gift Certificate';
        }else{
            $tmpstr = 'Send Company Gift Certificate';
        }
		$resentform = '<BR><div align ="center"><FORM METHOD=POST ACTION="index.php?ToDo=viewCompanyGiftcertificatesPopup" name="f1"><INPUT TYPE="hidden" name="cgcId" value ='.$certificate['cgcid'].'><INPUT TYPE="submit" name = "sendmail" value = "'.$tmpstr.'">	</FORM></div>';

		if ($type == 'preview') 	$body_str.= $resentform;

		$GLOBALS['ISC_CLASS_TEMPLATE']->templateExt = $oldExt;
		return $body_str;
	}

	public function ActivateGiftCertificates($orderId)
	{
		$certificateUpdates = array();
		// Select all of the inactive gift certificates for this order
		$query = sprintf("SELECT * FROM [|PREFIX|]company_gift_certificates WHERE cgcid='%d' ", $GLOBALS['ISC_CLASS_DB']->Quote($orderId));
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		while($certificate = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$certificateUpdates[] = $certificate['cgcid'];

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


		if(!$giftCertificate['cgctoemail']) {
			return;
		}

		$mail_body = $this->GenerateCompanyGiftCertificate($giftCertificate,'mail');



		if(!isset($GLOBALS['ShopPathNormal'])) {
			$GLOBALS['ShopPathNormal'] = $GLOBALS['ShopPath'];
		}

		// Build the email
		$narray = explode('$',$giftCertificate['cgcto']);
		$earray = explode('$',$giftCertificate['cgctoemail']);
		for($i=0; $i<count($narray);$i++)
		{
			if( !preg_match("/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/", $earray[$i]) ){
				continue;
            }
			$GLOBALS['ToName'] = isc_html_escape($narray[$i]);
			$GLOBALS['FromName'] = GetLang('CompanyGiftCertificateFrom');
			$GLOBALS['FromEmail'] = GetConfig('AdminEmail');
			$GLOBALS['Amount'] = FormatPrice($giftCertificate['cgcamount']);
			$GLOBALS['Intro'] = sprintf(GetLang('CompanyGiftCertificateEmailIntro'), $GLOBALS['FromName'], $GLOBALS['FromEmail'], $GLOBALS['Amount'], $GLOBALS['ShopPathNormal'], $GLOBALS['StoreName']);
			$GLOBALS['ISC_LANG']['CompanyGiftCertificateEmailInstructions'] = sprintf(GetLang('CompanyGiftCertificateEmailInstructions'), $GLOBALS['ShopPathNormal']);
			$GLOBALS['ISC_LANG']['GiftCertificateFrom'] = sprintf(GetLang('GiftCertificateFrom'), $GLOBALS['StoreName'], $GLOBALS['FromName']);
			if($giftCertificate['cgcexpirydate'] != 0) {
				$expiry = CDate($giftCertificate['cgcexpirydate']);
				$GLOBALS['GiftCertificateExpiryInfo'] = sprintf(GetLang('CompanyGiftCertificateEmailExpiry'), $expiry);
			}

			$emailTemplate = FetchEmailTemplateParser();
			$emailTemplate->SetTemplate("company_giftcertificate_email");
			$message = $emailTemplate->ParseTemplate(true);
			//$giftCertificate['giftcerttoemail'] = 'blessen.babu@clariontechnologies.co.in,navya.karnam@clariontechnologies.co.in,wenhuang07@gmail.com,lou@lofinc.net';
			// Create a new email API object to send the email
			$store_name = GetConfig('StoreName');
			$subject = sprintf(GetLang('CompanyGiftCertificateEmailSubject'), $GLOBALS['FromName'], $store_name);
			require_once(ISC_BASE_PATH . "/lib/email.php");
			$obj_email = GetEmailClass();
			$obj_email->Set('CharSet', GetConfig('CharacterSet'));
			$obj_email->From(GetConfig('AdminEmail'), $store_name);
			$obj_email->Set('Subject', $subject);
			$obj_email->AddBody("html", $message);
			$obj_email->AddRecipient($earray[$i], "", "h");
			$obj_email->AddAttachmentData($mail_body, GetLang('CompanyGiftCertificate') . ' #' . $giftCertificate['cgcid'].".html");
            $updatedCert = array(
                "cgcsended" => 1
            );
            if(GetConfig('CompanyGiftCertificateExpiry') > 0 and $giftCertificate['cgcexpirydate'] == 0){
                $expiry = time() + GetConfig('CompanyGiftCertificateExpiry');
                $updatedCert['cgcexpirydate'] = $expiry;
            }
            $tmpres = $GLOBALS['ISC_CLASS_DB']->UpdateQuery("company_gift_certificates", $updatedCert, "cgcid='".$GLOBALS['ISC_CLASS_DB']->Quote($giftCertificate['cgcid'])."'");

			$email_result = $obj_email->Send();
		}

	}
    // Add by NI_20100903_Jack
    // Exclude CGC themes
    private function getEnabledThemes(){
        $enabledThemes = explode(",", GetConfig('GiftCertificateThemes'));
        $enabledThemesTmp = array();
        foreach($enabledThemes as $itemstmp){
            if(preg_match("/^CGC/",$itemstmp)){
                continue;
            }
            $enabledThemesTmp[] = $itemstmp;
        }
        $enabledThemes = $enabledThemesTmp;
        return $enabledThemes;
    }
    
    public function RemoveAppliedCGCFromOrder($cgcId, $orderId) {
        $sql = sprintf("SELECT histcgcid,histbalanceused FROM [|PREFIX|]company_gift_certificate_history h WHERE histcgcid=%d AND h.historderid=%d", $cgcId, $orderId);
               
        $cgc = $GLOBALS['ISC_CLASS_DB']->Fetch($GLOBALS['ISC_CLASS_DB']->Query($sql));

        if ($cgc && $cgc['histbalanceused'] > 0) {
            $GLOBALS['ISC_CLASS_DB']->Query("UPDATE [|PREFIX|]company_gift_certificates SET cgcbalance = cgcbalance +{$cgc['histbalanceused']} WHERE cgcid={$cgc['histcgcid']}");
        }
        
        $GLOBALS['ISC_CLASS_DB']->DeleteQuery('company_gift_certificate_history', "WHERE histcgcid=$cgcId AND historderid=$orderId");
    }

}
?>
