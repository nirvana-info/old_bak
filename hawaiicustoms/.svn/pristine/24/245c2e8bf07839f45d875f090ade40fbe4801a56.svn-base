<?php

	if (!defined('ISC_BASE_PATH')) {
		die();
	}

	require_once(ISC_BASE_PATH.'/lib/class.xml.php');

	class ISC_ADMIN_REMOTE extends ISC_XML_PARSER
	{
		public function __construct()
		{
			parent::__construct();
		}

		public function HandleToDo()
		{
			/**
			 * Convert the input character set from the hard coded UTF-8 to their
			 * selected character set
			 */
			convertRequestInput();

			$what = isc_strtolower(@$_REQUEST['w']);

			switch  ($what) {
				case 'getpageparentoptions':
					$this->GetPageParentOptions();
					break;
				case "getshippingmoduleproperties":
					$this->GetShippingModuleProperties();
					break;
				case "getrulemoduleproperties":
					$this->GetRuleModuleProperties();
					break;
				case "multicountrystates":
					$this->GetMultiCountryStates();
					break;
				case "saveversion":
					$this->SaveVersion();
					break;
				case "testsmtpsettings":
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Settings)) {
						$this->TestSMTPSettings();
					}
				break;
				case "updatecustomergroup":
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Edit_Customers)) {
						$this->UpdateCustomerGroup();
					}
					break;
				case "clearcreditcarddetails":
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Orders)) {
						$this->ClearCreditCardDetails();
					}
					break;
				case "getvariationcombinations": {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Create_Product)) {
						$this->GetVariationCombinationsTable();
					}
					break;
				}
				case "customfieldsformailinglist": {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Newsletter_Subscribers)) {
						$this->GetCustomFieldsForMailingList();
					}
					break;
				}
				case "textcustomfieldsformailinglist": {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Newsletter_Subscribers)) {
						$this->GetTextCustomFieldsForMailingList();
					}
					break;
				}
				case "relatedproducts": {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Products)) {
						$this->GetRelatedProducts();
					}
					break;
				}
				case "inventorylevels": {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Products)) {
						$this->GetInventoryLevels();
					}
					break;
				}
				case "orderquickview": {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Orders)) {
						$this->GetOrderQuickView();
					}
					break;
				}
				case "countrystates": {
					$this->GetCountryStates();
					break;
				}
				case "addorderprodsearch": {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Orders)) {
						$this->GetMatchingProducts();
					}
					break;
				}
				case "customerorders": {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Orders)) {
						$this->GetCustomerOrders();
					}
					break;
				}
				case "updateorderstatus": {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Edit_Orders)) {
						$this->UpdateOrderStatus();
					}
					break;
				}
				case "updatetrackingno": {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Edit_Orders)) {
						$this->UpdateTrackingNo();
					}
					break;
				}
				case "updateperproductinventorylevels": {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Edit_Products)) {
						$this->UpdatePerProductInventoryLevels();
					}
					break;
				}
				case "updateperoptioninventorylevels": {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Edit_Products)) {
						$this->UpdatePerOptionInventoryLevels();
					}
					break;
				}
				case "testftpsettings": {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Backups)) {
						$this->TestFTPSettings();
					}
					break;
				}
				case "checknewtemplates": {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Templates)) {
						$this->CheckNewTemplates();
					}
					break;
				}
				case "downloadtemplatefile": {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Templates)) {
						$this->DownloadTemplateFile();
					}
					break;
				}
				case "checktemplatekey": {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Templates)) {
						$this->CheckTemplateKey();
					}
					break;
				}
				case "checktemplateversion": {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Templates)) {
						$this->CheckTemplateVersion();
					}
					break;
				}
				case "saveproductdownload": {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Products)) {
						$this->SaveProductDownload();
					}
					break;
				}
				case "deleteproductdownload": {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Products)) {
						$this->DeleteProductDownload();
					}
					break;
				}
				case "editproductdownload": {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Products)) {
						$this->EditProductDownload();
					}
					break;
				}
				case "updatepageorders": {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Pages)) {
						$this->UpdatePageOrders();
					}
					break;
				}
				case "updatecategoryorders": {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Categories)) {
						$this->UpdateCategoryOrders();
					}
					break;
				}
				case "updateseriesorders": {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Categories)) {
						$this->UpdateSeriesOrders();
					}
					break;
				}
				case "updatediscountorder": {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Pages)) {
						$this->UpdateDiscountOrder();
					}
					break;
				}
				case "savequickcategory": {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Categories)) {
						$this->SaveNewQuickCategory();
					}
					break;
				}
				case "approvereviews": {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Reviews)) {
						$this->ApproveReviews();
					}
					break;
				}
				case "disapprovereviews": {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Reviews)) {
						$this->DisapproveReviews();
					}
					break;
				}
				case "deletereviews": {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Reviews)) {
						$this->DeleteReviews();
					}
					break;
				}
				case "popupproductsearch": {
					$this->PopupProductSearch();
					break;
				}
				case "popupproductsort": {
					$this->PopupProductSort();
					break;
				}
                case "popupproductlist": {
                    $this->PopupProductList();
                    break;
                }
				case "loginfoquickview": {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Products)) {
						$this->LogInfoQuickView();
					}
					break;
				}
				case "generateapikey": {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Edit_Users)
					|| $GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Add_User)) {
						$this->GenerateNewAPIKey();
					}
					break;
				}
				case "returnquickview": {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Returns)) {
						$this->ReturnQuickView();
					}
					break;
				}
				case "updatereturnnotes": {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Returns)) {
						$this->UpdateReturnNotes();
					}
					break;
				}
				case "updatereturnstatus": {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Returns)) {
						$this->UpdateReturnStatus();
					}
					break;
				}
				case "updatestorecredit": {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Returns)) {
						$this->UpdateStoreCredit();
					}
					break;
				}
				case "giftcertificatequickview": {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_GiftCertificates)) {
						$this->GiftCertificateQuickView();
					}
					break;
				}
				case "updategiftcertificatestatus": {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_GiftCertificates)) {
						$this->UpdateGiftCertificateStatus();
					}
					break;
				}
				case "toggledesignmode": {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Templates)) {
						$this->ToggleDesignMode();
					}
					break;
				}
				case "updatelanguage": {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Templates)) {
						$this->UpdateLanguage();
					}
					break;
				}
				case "validateaddonkey": {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Addons)) {
						$this->CheckAddonKey();
					}
					break;
				}
				case "downloadaddonzip": {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Addons)) {
						$this->DownloadAddonZip();
					}
					break;
				}
				case "getemailtemplate": {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Templates)) {
						$this->GetEmailTemplate();
					}
					break;
				}
				case "updateemailtemplate": {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Templates)) {
						$this->UpdateEmailTemplate();
					}
					break;
				}
				case "useproductserverfile": {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Edit_Products)
					|| $GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Add_Products)) {
						$this->UseProductServerFile();
					}
					break;
				}
				case "updatelogo":
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Templates)) {
						$this->UpdateLogo();
						die();
						break;
					}
				case "previewlogo":
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Templates)) {
						$this->PreviewLogo();
						die();
						break;
					}
				case 'updatelogonone':
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Templates)) {
						$this->UpdateLogoNone();
						die();
						break;
					}
				case "checknewlogos":
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Templates)) {
						$this->CheckNewLogos();
						die();
						break;
					}
				case "downloadlogofile":
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Templates)) {
						$this->DownloadLogoFile();
						die();
						break;
					}
					break;
				case "getexchangerate":
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Settings)) {
						$this->getExchangeRate();
						die();
						break;
					}
					break;
				case "updateexchangerate":
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Settings)) {
						$this->UpdateExchangeRate();
						die();
						break;
					}
					break;
				case "updatetemplatefields":
					$this->UpdateTemplateFields();
					break;
				case "getstates":
					$this->GetStateList();
					break;
			}
		}

		private function GetPageParentOptions()
		{
			if(!isset($_REQUEST['pageId'])) {
				exit;
			}

			if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
				$vendorId = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId();
			}
			else if(isset($_REQUEST['vendorId'])) {
				$vendorId = (int)$_REQUEST['vendorId'];
			}
			else {
				$vendorId = 0;
			}

			$pages = GetClass('ISC_ADMIN_PAGES');
			echo $pages->GetParentPageOptions(0, $_REQUEST['pageId'], $vendorId);
			exit;
		}

		private function GetShippingModuleProperties()
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('settings.shipping');
			GetModuleById('shipping', $shippingModule, $_REQUEST['module']);
			if(!is_object($shippingModule)) {
				exit;
			}
			$shippingModule->SetMethodId(0);
			echo $shippingModule->GetPropertiesSheet(0);
			echo "<span style=\"display: none;\" id=\"moduleName\">".$shippingModule->GetName()."</span>";
			echo "<script type=\"text/javascript\"> function ShipperValidation() { ".$GLOBALS['ShippingJavaScript']." return true; }</script>";
			exit;
		}

		private function GetRuleModuleProperties()
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('discounts');

			$module = explode('_',$_REQUEST['module']);

			GetModuleById('rule', $ruleModule, $module[1]);

			if(!is_object($ruleModule)) {
				exit;
			}

			$ruleModule->initializeAdmin();

			echo $ruleModule->ParseTemplate('module.'.$module[1]);
			exit;
		}


		/**
		 * Save the version number of the latest ISC release to the data cache.
		 */
		private function SaveVersion()
		{
			if(!isset($_REQUEST['v'])) {
				exit;
			}

			$updatedVersion = array(
				'latest' => $_REQUEST['v'],
				'lastCheck' => time()
			);
			$GLOBALS['ISC_CLASS_DATA_STORE']->Save('LatestVersion', $updatedVersion);
			echo '1';
			exit;
		}

		/**
		 * Test the SMTP settings from the settings page.
		 *
		 */
		private function TestSMTPSettings()
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('settings');
			$subject = sprintf(GetLang('TestSendingSubject'), GetConfig('StoreName'));
			$text = sprintf(GetLang('TestSendingEmail'), GetConfig('StoreName'));
			if(!isset($_POST['AdminEmail'])) {
				$tags[] = $this->MakeXMLTag('status',0);
				$tags[] = $this->MakeXMLTag('message', GetLang('EnterAdminEmail'));
				$this->SendXMLHeader();
				$this->SendXMLResponse($tags);
				die();
			}
			else {
				$preview_email = $_POST['AdminEmail'];
			}

			require_once(ISC_BASE_PATH . "/lib/email.php");
			$email_api = GetEmailClass();

			$email_api->Set('SMTPServer', $_POST['MailSMTPServer']);
			if(isset($_POST['MailSMTPUsername']) && !empty($_POST['MailSMTPUsername'])) {
				$email_api->Set('SMTPUsername', $_POST['MailSMTPUsername']);
			}

			if(isset($_POST['MailSMTPPassword']) && !empty($_POST['MailSMTPPassword'])) {
				$email_api->Set('SMTPPassword', $_POST['MailSMTPPassword']);
			}

			if(isset($_POST['MailSMTPPort']) && !empty($_POST['MailSMTPPort'])) {
				$email_api->Set('SMTPPort', $_POST['MailSMTPPort']);
			}

			$email_api->Set('Subject', $subject);
			$email_api->Set('FromAddress', $preview_email);
			$email_api->Set('ReplyTo', $preview_email);
			$email_api->Set('BounceAddress', $preview_email);

			$email_api->AddBody('text', $text);

			$email_api->AddRecipient($preview_email, '', 't');
			$send_result = $email_api->Send();

			if (isset($send_result['success']) && $send_result['success'] > 0) {
				$tags[] = $this->MakeXMLTag('status', 1);
				$tags[] = $this->MakeXMLTag('message', sprintf(GetLang('TestEmailSent'), $_POST['AdminEmail']));
			}
			else {
				$failure = array_shift($send_result['fail']);
				$msg = sprintf(GetLang('TestEmailNotSent'), $preview_email, $failure[1]);
				$tags[] = $this->MakeXMLTag('status',1);
				$tags[] = $this->MakeXMLTag('message', $msg);
			}
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
			die();
		}

		/**
		* UpdateCustomerGroup
		* Update the custgroupid field which is the group that the customer belongs to
		*
		* @return Int 1 on success, 0 on failure
		*/
		private function UpdateCustomerGroup()
		{
			if (isset($_REQUEST['customerId']) && isset($_REQUEST['groupId'])) {
				$entity = new ISC_ENTITY_CUSTOMER();

				if ($entity->editGroup($_REQUEST['customerId'], $_REQUEST['groupId'])) {
					print 1;
				} else {
					print 0;
				}
			}
		}

		/**
		 * Remove the credit card details from a particular order.
		 *
		 * @return void
		 */
		private function ClearCreditCardDetails()
		{
			$query = "SELECT orderid, extrainfo FROM [|PREFIX|]orders WHERE orderid='".$GLOBALS['ISC_CLASS_DB']->Quote((int)$_REQUEST['orderId'])."'";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$order = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
			if(!isset($order['orderid']) || !$order['orderid']) {
				exit;
			}

			$extraInfo = @unserialize($order['extrainfo']);
			if(is_array($extraInfo)) {
				unset($extraInfo['cc_ccno']);
				unset($extraInfo['cc_cvv2']);
				unset($extraInfo['cc_name']);
				unset($extraInfo['cc_ccaddress']);
				unset($extraInfo['cc_cczip']);
				unset($extraInfo['cc_cctype']);
				unset($extraInfo['cc_ccexpm']);
				unset($extraInfo['cc_ccexpy']);

				if(isset($extraInfo['cc_issueno'])) {
					unset($extraInfo['cc_issueno']);
				}

				if(isset($extraInfo['cc_issuedatey'])) {
					unset($extraInfo['cc_issuedatey']);
					unset($extraInfo['cc_issuedatem']);
					unset($extraInfo['cc_issuedated']);
				}

				$updatedOrder = array(
					"extrainfo" => serialize($extraInfo)
				);
				$GLOBALS['ISC_CLASS_DB']->UpdateQuery("orders", $updatedOrder, "orderid='".$order['orderid']."'");
				echo 1;
			}

			exit;
		}

		/**
		* Updates the language file. Used by design mode
		*
		* @return void
		*/
		private function UpdateLanguage()
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('layout');
			$name	= str_replace("lang_", "", $_REQUEST['LangName']);
			$value	= $_REQUEST['NewValue'];
			/*$value = str_replace(array("\n","\r"), "", $value);*/
			$value = str_replace('"', "&quot;", $value);

			$content = file_get_contents(ISC_BASE_PATH."/language/".GetConfig('Language')."/front_language.ini");
			$frontLang = parse_ini_file(ISC_BASE_PATH."/language/".GetConfig('Language')."/front_language.ini");

			$replacement = $name . ' = "' . str_replace('$', '\$', $value) . '"';
			$replace = preg_replace("#^\s*".preg_quote($name, "#")."\s*=\s*\"".preg_quote(@$frontLang[$name], "#").'"\s*$#im', $replacement, $content);

			if(file_put_contents(ISC_BASE_PATH."/language/".GetConfig('Language')."/front_language.ini", $replace)) {
				$tags[] = $this->MakeXMLTag('status',1);
				$tags[] = $this->MakeXMLTag('newvalue', $value, true);
			}else {
				$tags[] = $this->MakeXMLTag('status',0);
				$tags[] = $this->MakeXMLTag('message', GetLang('UpdateLanguage'));
			}

			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
			die();
		}

		/**
		 * Toggle design mode
		 *
		 * @return void
		 **/
		private function ToggleDesignMode()
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('settings');

			if($_POST['value'] == 'true') {
				$value = 1;
			}else {
				$value = 0;
			}

			$GLOBALS['ISC_NEW_CFG']['DesignMode'] = $value;

			$settings = GetClass('ISC_ADMIN_SETTINGS');
			if ($settings->CommitSettings()) {
				$tags[] = $this->MakeXMLTag('status', 1);
			}else {
				$tags[] = $this->MakeXMLTag('status',0);
				$tags[] = $this->MakeXMLTag('message', $settings->error);
			}

			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
			die();
		}

		/**
		 * Update the status of a gift certificate from the manage page
		 *
		 * @return void
		 **/
		private function UpdateGiftCertificateStatus()
		{
			if(!isset($_REQUEST['giftCertificateId'])) {
				exit;
			}
			$query = sprintf("SELECT * FROM [|PREFIX|]gift_certificates WHERE giftcertid='%d'", $_REQUEST['giftCertificateId']);
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$certificate = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
			if(!$certificate['giftcertid']) {
				exit;
			}

			$updatedStatus = array(
				"giftcertstatus" => (int)$_REQUEST['status']
			);

			if($_REQUEST['status'] == 2) {
				// Are gift certificates set to expire?
				if(GetConfig('GiftCertificateExpiry') > 0) {
					$expiry = time() + GetConfig('GiftCertificateExpiry');
				}
				else {
					$expiry = 0;
				}
				$updatedStatus['giftcertexpirydate'] = $expiry;
			}
			$GLOBALS['ISC_CLASS_DB']->UpdateQuery("gift_certificates", $updatedStatus, "giftcertid='".$GLOBALS['ISC_CLASS_DB']->Quote($certificate['giftcertid'])."'");
			echo 1;
			exit;
		}

		/**
		 * Show the quick view for gift certificates
		 *
		 * @return void
		 **/
		private function GiftCertificateQuickView()
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('giftcertificates');
			if(!isset($_REQUEST['giftCertificateId'])) {
				exit;
			}

			$query = sprintf("SELECT * FROM [|PREFIX|]gift_certificates WHERE giftcertid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($_REQUEST['giftCertificateId']));
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$certificate = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

			// Fetch out the history for this gift certificate
			$query = "
				SELECT h.*, CONCAT(c.custconfirstname, ' ', c.custconlastname) AS customername
				FROM [|PREFIX|]gift_certificate_history h
				LEFT JOIN [|PREFIX|]customers c ON (c.customerid=h.histcustomerid)
				WHERE h.histgiftcertid='" . $certificate['giftcertid'] . "'
				ORDER BY historddate ASC";

			$GLOBALS['Message'] = isc_html_escape($certificate['giftcertmessage']);
			$GLOBALS['FromEmail'] = isc_html_escape($certificate['giftcertfromemail']);
			$GLOBALS['FromName'] = isc_html_escape($certificate['giftcertfrom']);
			$GLOBALS['ToEmail'] = isc_html_escape($certificate['giftcerttoemail']);
			$GLOBALS['ToName'] = isc_html_escape($certificate['giftcertto']);

			$GLOBALS['GiftCertificateHistory'] = '';

			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$GLOBALS['CustomerName'] = isc_html_escape($row['customername']);
				$GLOBALS['CustomerId'] = (int) $row['histcustomerid'];
				$GLOBALS['OrderId'] = (int) $row['historderid'];
				$GLOBALS['OrderDate'] = CDate($row['historddate']);
				$GLOBALS['BalanceUsed'] = FormatPrice($row['histbalanceused']);
				$GLOBALS['BalanceRemaining'] = FormatPrice($row['histbalanceremaining']);

				$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("giftcertificate.quickview.item");
				$GLOBALS['GiftCertificateHistory'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
			}

			if($GLOBALS['GiftCertificateHistory'] == '') {
				$GLOBALS['GiftCertificateHistory'] = sprintf('<div style="padding-left: 10px;">%s</div>', GetLang('GiftCertificateNotUsed'));
			}

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("giftcertificate.quickview");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}

		/**
		 * Update the store credit for a customer
		 *
		 * @return void
		 **/
		private function UpdateStoreCredit()
		{
			if(!isset($_REQUEST['customerId'])) {
				exit;
			}

			$query = sprintf("SELECT customerid, custstorecredit FROM [|PREFIX|]customers WHERE customerid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($_REQUEST['customerId']));
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$customer = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

			if($customer['customerid'] == 0) {
				exit;
			}

			$updatedCustomer = array(
				"custstorecredit" => DefaultPriceFormat($_REQUEST['credit'])
			);
			$GLOBALS['ISC_CLASS_DB']->UpdateQuery("customers", $updatedCustomer, "customerid='".$GLOBALS['ISC_CLASS_DB']->Quote($customer['customerid'])."'");

			// Log the credit change
			$creditChange = CFloat($_REQUEST['credit'] - $customer['custstorecredit']);
			if($creditChange != 0) {
				$creditLog = array(
					"customerid" => (int) $customer['customerid'],
					"creditamount" => $creditChange,
					"credittype" => "adjustment",
					"creditdate" => time(),
					"creditrefid" => 0,
					"credituserid" => $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetUserId(),
					"creditreason" => ""
				);
				$GLOBALS['ISC_CLASS_DB']->InsertQuery("customer_credits", $creditLog);
			}
			echo 1;
			exit;
		}

		/**
		 * Update the return status for an order
		 *
		 * @return void
		 **/
		private function UpdateReturnStatus()
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('returns');
			if(!isset($_REQUEST['returnId'])) {
				exit;
			}

			$SQL = "SELECT r.*, o.ordcurrencyid, o.ordcurrencyexchangerate \n"
				 . "  FROM [|PREFIX|]returns r \n"
				 . "       JOIN [|PREFIX|]orders o ON r.retorderid = o.orderid \n"
				 . " WHERE r.returnid = " . (int)$_REQUEST['returnId'];

			$result = $GLOBALS['ISC_CLASS_DB']->Query($SQL);
			$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

			if(!$row['returnid']) {
				exit;
			}

			// Do we have permission to alter this return?
			if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() && $row['retvendorid'] != $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
				exit;
			}

			$GLOBALS['ISC_CLASS_ADMIN_RETURNS'] = GetClass('ISC_ADMIN_RETURNS');
			if($GLOBALS['ISC_CLASS_ADMIN_RETURNS']->UpdateReturnStatus($row, $_REQUEST['status'])) {
				echo 1;
			}
			exit;
		}

		/**
		 * Update the staff only notes for a return
		 *
		 * @return void
		 **/
		private function UpdateReturnNotes()
		{
			if(!isset($_REQUEST['returnId'])) {
				exit;
			}

			$query = sprintf("SELECT * FROM [|PREFIX|]returns WHERE returnid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($_REQUEST['returnId']));
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

			if(!$row['returnid']) {
				exit;
			}

			// Do we have permission to alter this return?
			if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() && $row['retvendorid'] != $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
				exit;
			}

			$updatedReturn = array(
				"retstaffnotes" => $_POST['returnNotes']
			);
			$GLOBALS['ISC_CLASS_DB']->UpdateQuery("returns", $updatedReturn, "returnid='".$GLOBALS['ISC_CLASS_DB']->Quote($row['returnid'])."'");
			echo 1;
			exit;
		}

		/**
		 * Display the quick view for a return
		 *
		 * @return void
		 **/
		private function ReturnQuickView()
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('returns');
			if(!isset($_REQUEST['returnId'])) {
				exit;
			}

			$query = sprintf("SELECT * FROM [|PREFIX|]returns WHERE returnid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($_REQUEST['returnId']));
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

			// Do we have permission to view this return?
			if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() && $row['retvendorid'] != $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
				exit;
			}


			$GLOBALS['ReturnReason'] = isc_html_escape($row['retreason']);

			if(!$row['retaction']) {
				$row['retaction'] = GetLang('NA');
			}

			$GLOBALS['ReturnAction'] = isc_html_escape($row['retaction']);
			$GLOBALS['ReturnId'] = (int) $row['returnid'];
			$GLOBALS['StaffNotes'] = isc_html_escape($row['retstaffnotes']);
			if(!$row['retcomment']) {
				$row['retcomment'] = GetLang('NA');
			}
			$GLOBALS['CustomerComments'] = isc_html_escape($row['retcomment']);

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("return.quickview");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}

		/**
		 * Show the quick view for a log entry
		 *
		 * @return void
		 **/
		private function LogInfoQuickView()
		{
			if(!isset($_REQUEST['logid'])) {
				exit;
			}

			$query = sprintf("SELECT logmsg FROM [|PREFIX|]system_log WHERE logid='%d'", (int)$_REQUEST['logid']);
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$msg = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);

			echo $msg;
			exit;
		}

		/**
		 * Show the select a product popup page on the create a coupon page
		 *
		 * @return void
		 **/
		private function PopupProductSearch()
		{
			if(isset($_REQUEST['category']) && $_REQUEST['category'] == 0) {
				unset($_REQUEST['category']);
			}

			if(isset($_REQUEST['category']) && $_REQUEST['category'] != 0) {

				$_SESSION['radiotype'] = "category";
				$_SESSION['lastselcatid'] = $_REQUEST['category'];

			}

			if(!isset($_REQUEST['searchQuery']) && !isset($_REQUEST['category'])) {
				$tags[] = $this->MakeXMLTag('status', 0);
				$tags[] = $this->MakeXMLTag('message', GetLang('ProductSelectEnterTerms'), true);
			}
			else {
				if(isset($_REQUEST['category'])) {
					$_REQUEST['category'] = array($_REQUEST['category']);
				}
				$ResultCount = 0;
				$GLOBALS['ISC_CLASS_ADMIN_PRODUCT'] = GetClass('ISC_ADMIN_PRODUCT');
				$products = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_GetProductList(0, 'p.prodname', 'asc', $ResultCount, 'p.productid,p.prodname,p.prodprice,p.prodsaleprice,p.prodretailprice,p.prodconfigfields,p.prodvariationid,p.prodtype,p.prodcode,p.prodistaxable,p.prodeventdaterequired', false);

				if($ResultCount == 0) {
					$tags[] = $this->MakeXMLTag('status', 0);
					if(isset($_REQUEST['searchQuery'])) {
						$tags[] = $this->MakeXMLTag('message', GetLang('ProductSelectNoProducts'), true);
					} else {
						$tags[] = $this->MakeXMLTag('message', GetLang('ProductSelectNoProductsCategory'), true);
					}
				}
				else {
					$results = '';
					$tags[] = $this->MakeXMLTag('status', 1);

					while($product = $GLOBALS['ISC_CLASS_DB']->Fetch($products)) {
						$actualPrice = CalcRealPrice($product['prodprice'], $product['prodretailprice'], $product['prodsaleprice'], $product['prodistaxable']);
						$actualPrice = CalcProdCustomerGroupPrice($product, $actualPrice);
						$isConfigurable = false;
						if($product['prodvariationid'] != 0 || $product['prodconfigfields'] != 0 || $product['prodeventdaterequired'] == 1) {
							$isConfigurable = true;
						}
						$results .= '
							<product>
								<productId>'.$product['productid'].'</productId>
								<productName><![CDATA['.$product['prodname'].']]></productName>
								<productPrice>'.FormatPrice($actualPrice, false, false, true).'</productPrice>
								<productCode><![CDATA['.$product['prodcode'].']]></productCode>
								<productType>'.$product['prodtype'].'</productType>
								<productConfigurable>'.(int)$isConfigurable.'</productConfigurable>
							</product>
						';
					}
					$tags[] = $this->MakeXMLTag('results', $results);
				}
			}
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
			die();
		}


private function PopupProductSort()
		{


		if (isset($_SESSION['lastselcatid']))
			{
		$_REQUEST['category'] = $_SESSION['lastselcatid'];
		$catid = $_SESSION['lastselcatid'];
			}

		$sorttype =  $_REQUEST['type'];

        if ($_SESSION['order'] == "asc")
			$_SESSION['order'] = "desc";
		else
			$_SESSION['order'] = "asc";



			if(isset($_REQUEST['category']) && $_REQUEST['category'] == 0) {
				unset($_REQUEST['category']);
			}

			
				if(isset($_REQUEST['category'])) {
					$_REQUEST['category'] = array($_REQUEST['category']);
				}

				$ResultCount = 0;
				$GLOBALS['ISC_CLASS_ADMIN_PRODUCT'] = GetClass('ISC_ADMIN_PRODUCT');

				


if ($_SESSION['radiotype'] ==  "series")
			{

$seriesid = $_SESSION['lastselseriesid'];
$brandid = $_SESSION['lastselbrandid'];

$sortquery = "SELECT c.catname , s.seriesname,  p.productid, p.prodname, p.prodprice, p.prodsaleprice,  p.prodretailprice, p.prodconfigfields, p.prodvariationid,p.prodtype, p.prodcode, p.prodistaxable, p.prodeventdaterequired FROM [|PREFIX|]products p INNER JOIN [|PREFIX|]categoryassociations ca ON p.productid = ca.productid  INNER JOIN [|PREFIX|]categories c ON c.categoryid = ca.categoryid left JOIN [|PREFIX|]brand_series s ON s.seriesid = p.brandseriesid	where brandseriesid in (".$seriesid.") and prodbrandid = '".$brandid."' ORDER BY ".$sorttype." ".$_SESSION['order']." ";


			}
			else
			{

$sortquery = "SELECT c.catname , s.seriesname,  p.productid, p.prodname, p.prodprice, p.prodsaleprice,  p.prodretailprice, p.prodconfigfields, p.prodvariationid,p.prodtype,p.prodcode,p.prodistaxable,p.prodeventdaterequired FROM 	( SELECT DISTINCT ca.productid, ca.categoryid FROM [|PREFIX|]categoryassociations ca 	INNER JOIN [|PREFIX|]products p ON p.productid = ca.productid WHERE ca.categoryid IN (".$catid.")   ) AS ca INNER JOIN [|PREFIX|]products p ON p.productid = ca.productid INNER JOIN [|PREFIX|]categories c ON c.categoryid = ca.categoryid left JOIN [|PREFIX|]brand_series s ON s.seriesid = p.brandseriesid	ORDER BY ".$sorttype." ".$_SESSION['order']." ";

			}
$resultsortquery = $GLOBALS['ISC_CLASS_DB']->Query($sortquery);
$ResultCount = mysql_num_rows($resultsortquery);
$products = $resultsortquery;

			
				if($ResultCount == 0) {
					$tags[] = $this->MakeXMLTag('status', 0);
					if(isset($_REQUEST['searchQuery'])) {
						$tags[] = $this->MakeXMLTag('message', GetLang('ProductSelectNoProducts'), true);
					} else {
						$tags[] = $this->MakeXMLTag('message', GetLang('ProductSelectNoProductsCategory'), true);
					}
				}
				else {
					$results = '';
					$tags[] = $this->MakeXMLTag('status', 1);

					while($product = $GLOBALS['ISC_CLASS_DB']->Fetch($products)) {
						$actualPrice = CalcRealPrice($product['prodprice'], $product['prodretailprice'], $product['prodsaleprice'], $product['prodistaxable']);
						$actualPrice = CalcProdCustomerGroupPrice($product, $actualPrice);
						$isConfigurable = false;
						if($product['prodvariationid'] != 0 || $product['prodconfigfields'] != 0 || $product['prodeventdaterequired'] == 1) {
							$isConfigurable = true;
						}
						$results .= '
							<product>
								<productId>'.$product['productid'].'</productId>
								<productName><![CDATA['.$product['prodname'].']]></productName>
								<catName><![CDATA['.$product['catname'].']]></catName>
								<seriesName><![CDATA['.$product['seriesname'].']]></seriesName>
								<productPrice>'.FormatPrice($actualPrice, false, false, true).'</productPrice>
								<productCode><![CDATA['.$product['prodcode'].']]></productCode>
								<productType>'.$product['prodtype'].'</productType>
								<productConfigurable>'.(int)$isConfigurable.'</productConfigurable>
							</product>
						';
					}
					$tags[] = $this->MakeXMLTag('results', $results);
				}
			
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
			die();
		}
		

        /* Function added for to get the products by selecing the brand and series -- Baskaran */
        private function PopupProductList()
        {
           /* if(isset($_REQUEST['seriesid']) && $_REQUEST['category'] == 0) {
                unset($_REQUEST['category']);
            }  */
             $seriesid = rtrim($_REQUEST['seriesid'],",");
            $brandid = $_REQUEST['brandid'];

			$_SESSION['radiotype'] = "series";
			$_SESSION['lastselseriesid'] = $seriesid;
			$_SESSION['lastselbrandid'] = $brandid;



            if(!isset($_REQUEST['seriesid'])) {
                $tags[] = $this->MakeXMLTag('status', 0);
                $tags[] = $this->MakeXMLTag('message', GetLang('ProductSelectEnterTerms'), true);
            }
            else {
                if(isset($_REQUEST['seriesid'])) {
                    $_REQUEST['seriesid'] = array($_REQUEST['seriesid']);
                }
                $ResultCount = 0;
                $GLOBALS['ISC_CLASS_ADMIN_PRODUCT'] = GetClass('ISC_ADMIN_PRODUCT');

                $products = $GLOBALS["ISC_CLASS_DB"]->Query("SELECT * FROM [|PREFIX|]products where brandseriesid in (".$seriesid.")  and prodbrandid = '$brandid'");
                $ResultCount = $GLOBALS["ISC_CLASS_DB"]->CountResult($products);
                if($ResultCount == 0) {
                    $tags[] = $this->MakeXMLTag('status', 0);
                    if(isset($_REQUEST['searchQuery'])) {
                        $tags[] = $this->MakeXMLTag('message', GetLang('ProductSelectNoProducts'), true);
                    } else {
                        $tags[] = $this->MakeXMLTag('message', GetLang('ProductSelectNoProductsBrands'), true);
                    }
                }
                else {
                    $results = '';
                    $tags[] = $this->MakeXMLTag('status', 1);

                    while($product = $GLOBALS['ISC_CLASS_DB']->Fetch($products)) {
                        $actualPrice = CalcRealPrice($product['prodprice'], $product['prodretailprice'], $product['prodsaleprice'], $product['prodistaxable']);
                        $actualPrice = CalcProdCustomerGroupPrice($product, $actualPrice);
                        $isConfigurable = false;
                        if($product['prodvariationid'] != 0 || $product['prodconfigfields'] != 0 || $product['prodeventdaterequired'] == 1) {
                            $isConfigurable = true;
                        }
                        $results .= '
                            <product>
                                <productId>'.$product['productid'].'</productId>
                                <productName><![CDATA['.$product['prodname'].']]></productName>
                                <productPrice>'.FormatPrice($actualPrice, false, false, true).'</productPrice>
                                <productCode><![CDATA['.$product['prodcode'].']]></productCode>
                                <productType>'.$product['prodtype'].'</productType>
                                <productConfigurable>'.(int)$isConfigurable.'</productConfigurable>
                            </product>
                        ';
                    }
                    $tags[] = $this->MakeXMLTag('results', $results);
                }
            }
            $this->SendXMLHeader();
            $this->SendXMLResponse($tags);
            die();
        }
        
		/**
		 * Update the sort order of the categories when they are reordered
		 *
		 * @return void
		 **/
		private function UpdateCategoryOrders()
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('categories');

			$this->_BuildCategoryOrders($_POST['CategoryList']);

			// Update the data store
			$GLOBALS['ISC_CLASS_DATA_STORE']->UpdateRootCategories();

			// Also make sure that all the root categories do NOT have any images assoiated with them
			$GLOBALS['ISC_CLASS_ADMIN_CATEGORY'] = GetClass('ISC_ADMIN_CATEGORY');
			$GLOBALS['ISC_CLASS_ADMIN_CATEGORY']->RemoveRootImages();

			$tags[] = $this->MakeXMLTag('status', 1);
			$tags[] = $this->MakeXMLTag('message', GetLang('CategoryOrdersUpdated'), true);
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
			die();
		}

		private function UpdateDiscountOrder()
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('discounts');

			$this->_BuildDiscountOrder($_POST['sortorder']);

			$tags[] = $this->MakeXMLTag('status', 1);
			$tags[] = $this->MakeXMLTag('message', GetLang('DiscountOrdersUpdated'), true);
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
			die();
		}

		private function _BuildDiscountOrder($list, $parent=0, $parents=array())
		{
			$idx = explode(',', $list);

			if (!is_array($idx) || empty($idx)) {
				exit;
			}

			$sort = 1;
			foreach ($idx as $fieldId) {
				$GLOBALS['ISC_CLASS_DB']->UpdateQuery("discounts", array("sortorder"=>$sort++), "discountid='".$fieldId."'");
			}
		}


		/**
		 * Automatically set the sortorder of the categories when they are dragged so they are displayed in the correct order
		 *
		 * @return void
		 **/
		private function _BuildCategoryOrders($list, $parent=0, $parents=array())
		{
			if(!is_array($list)) {
				return;
			}

			foreach($list as $order => $category) {
				$myParents = $parents;
				$myParents[] = $category['id'];
				$parentList = implode(",", $myParents);
				$updatedCategory = array(
					"catsort" => $order+1,
					"catparentid" => $parent,
					"catparentlist" => $parentList
				);
				$GLOBALS['ISC_CLASS_DB']->UpdateQuery("categories", $updatedCategory, "categoryid='".$GLOBALS['ISC_CLASS_DB']->Quote((int)$category['id'])."'");
				if(isset($category['children'])) {
					$this->_BuildCategoryOrders($category['children'], $category['id'], $myParents);
				}
			}
		}

		private function UpdateSeriesOrders()
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('brands');
			//echo "<pre>";
			//echo $_REQUEST['item'];
			

			$query2 = "SELECT count(*) as cnt FROM [|PREFIX|]brand_series ";
			$result2 = $GLOBALS['ISC_CLASS_DB']->Query($query2);
			$row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result2);
			$perpage =  $row['cnt'];
			

			for ($i = 1; $i <= $perpage; $i++) {


				if (isset($_POST['SeriesList_'.$i.'']))
								{
					
				$this->_BuildSeriesOrders($_POST['SeriesList_'.$i.'']);


				
								}
			}

			//   $('ul.SortableList').NestedSortable(                         

			$tags[] = $this->MakeXMLTag('status', 1);
			$tags[] = $this->MakeXMLTag('message', GetLang('SeriesOrdersUpdated'), true);
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
			die();
		}

		private function _BuildSeriesOrders($list, $parent=0, $parents=array())
		{
			if(!is_array($list)) {
				return;
			}
			foreach($list as $order => $category) {
					$updatedCategory = array(
					"seriessort" => $order+1
					
				);
				$GLOBALS['ISC_CLASS_DB']->UpdateQuery("brand_series", $updatedCategory, "seriesid='".$GLOBALS['ISC_CLASS_DB']->Quote((int)$category['id'])."'");
				
			}
		}


		/**
		* Updates the order of fields in an export template
		*
		**/
		private function UpdateTemplateFields()
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('exporttemplates');

			$field_type = $_REQUEST['l'];

			$template_id = $_REQUEST["tempId"];

			$templates = GetClass('ISC_ADMIN_EXPORTTEMPLATES');
			try {
				$template = $templates->GetTemplate($template_id);

				if ($template['builtin']) {
					die();
				}
			}
			catch (Exception $ex) {
				die();
			}

			require_once(APP_ROOT . "/includes/exporter/class.exportfiletype.factory.php");

			$type = ISC_ADMIN_EXPORTFILETYPE_FACTORY::GetExportFileType($field_type);
			$fields = $type->LoadFields();

			foreach ($_POST[$field_type . "FieldList"] as $order => $field) {
				$field_id = substr($field, strpos($field, "-") + 1);

				if (!isset($fields[$field_id])) {
					continue;
				}

				//check if field exists
				$query = "SELECT exporttemplatefieldid FROM [|PREFIX|]export_template_fields WHERE fieldid = '" . $GLOBALS['ISC_CLASS_DB']->Quote($field_id) . "' AND fieldtype = '" . $GLOBALS['ISC_CLASS_DB']->Quote($field_type) . "' AND exporttemplateid = '" . $GLOBALS['ISC_CLASS_DB']->Quote($template_id) . "'";
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

				if ($GLOBALS['ISC_CLASS_DB']->CountResult($result)) {
					$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

					// update existing field
					$query = "UPDATE [|PREFIX|]export_template_fields SET sortorder = $order WHERE exporttemplatefieldid = " . $row['exporttemplatefieldid'];
					$GLOBALS['ISC_CLASS_DB']->Query($query);
				}
				else {
					// create field
					 $field_array = array(
						"exporttemplateid"	=> $template_id,
						"fieldid"			=> $field_id,
						"fieldtype"			=> $field_type,
						"fieldname"			=> $fields[$field_id]['label'],
						"includeinexport"	=> 0,
						"sortorder"			=> $order
					);

					$GLOBALS['ISC_CLASS_DB']->InsertQuery('export_template_fields', $field_array);
				}

				$query = "UPDATE [|PREFIX|]export_template_fields SET sortorder = $order WHERE fieldid = '" . $GLOBALS['ISC_CLASS_DB']->Quote($field_id) . "' AND fieldtype = '" . $GLOBALS['ISC_CLASS_DB']->Quote($field_type) . "' AND exporttemplateid = '" . $GLOBALS['ISC_CLASS_DB']->Quote($template_id) . "'";
				$GLOBALS['ISC_CLASS_DB']->Query($query);
			}

			$tags[] = $this->MakeXMLTag('status', 1);
			$tags[] = $this->MakeXMLTag('message', sprintf(GetLang('FieldOrderUpdated'), $field_type), true);
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
			die();
		}

		/**
		 * Update the sort order of the pages
		 *
		 * @return void
		 **/
		private function UpdatePageOrders()
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('pages');
			$this->_BuildPageOrders($_POST['PageList']);

			// Update the data store
			$GLOBALS['ISC_CLASS_DATA_STORE']->UpdatePages();

			$tags[] = $this->MakeXMLTag('status', 1);
			$tags[] = $this->MakeXMLTag('message', GetLang('PageOrdersUpdated'), true);
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
			die();
		}

		/**
		 * Automatically set the sortorder of the pages when they are dragged so they are displayed in the correct order
		 *
		 * @return void
		 **/
		private function _BuildPageOrders($list, $parent=0, $parents=array())
		{
			if(!is_array($list)) {
				return;
			}

			foreach($list as $order => $page) {
				$myParents = $parents;
				$myParents[] = $page['id'];
				$parentList = implode(",", $myParents);
				$updatedPage = array(
					"pagesort" => $order+1,
					"pageparentid" => $parent,
					"pageparentlist" => $parentList
				);
				$GLOBALS['ISC_CLASS_DB']->UpdateQuery("pages", $updatedPage, "pageid='".$GLOBALS['ISC_CLASS_DB']->Quote((int)$page['id'])."'");
				if(isset($page['children'])) {
					$this->_BuildPageOrders($page['children'], $page['id'], $myParents);
				}
			}
		}

		/**
		 * Bulk approve reviews from the manage reviews page
		 *
		 * @return void
		 **/
		private function ApproveReviews()
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('reviews');
			$GLOBALS['ISC_CLASS_ADMIN_REVIEW'] = GetClass('ISC_ADMIN_REVIEW');
			$err = '';
			$msg = $GLOBALS['ISC_CLASS_ADMIN_REVIEW']->DoApproveReviews($_POST['reviews'], $err);
			if($err != "") {
				$tags[] = $this->MakeXMLTag('status', 0);
				$tags[] = $this->MakeXMLTag('message', $err, true);
			}
			else {
				$tags[] = $this->MakeXMLTag('status', 1);
				$tags[] = $this->MakeXMLTag('message', $msg, true);

				// Log this action
				$GLOBALS['ISC_CLASS_LOG']->LogAdminAction(count($_POST['reviews']));
				$numReviews = 0;
				$grid = $GLOBALS['ISC_CLASS_ADMIN_REVIEW']->ManageReviewsGrid($numReviews);
				if($numReviews > 0) {
					$tags[] = $this->MakeXMLTag('grid', $grid, true);
				}
			}
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
			exit;
		}

		/**
		 * Bulk dis-approve reviews from the manage reviews page
		 *
		 * @return void
		 **/
		private function DisapproveReviews()
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('reviews');
			$GLOBALS['ISC_CLASS_ADMIN_REVIEW'] = GetClass('ISC_ADMIN_REVIEW');
			$err = '';
			$msg = $GLOBALS['ISC_CLASS_ADMIN_REVIEW']->DoDisapproveReviews($_POST['reviews'], $err);
			if($err != "") {
				$tags[] = $this->MakeXMLTag('status', 0);
				$tags[] = $this->MakeXMLTag('message', $err, true);
			}
			else {
				$tags[] = $this->MakeXMLTag('status', 1);
				$tags[] = $this->MakeXMLTag('message', $msg, true);

				// Log this action
				$GLOBALS['ISC_CLASS_LOG']->LogAdminAction(count($_POST['reviews']));
				$numReviews = 0;
				$grid = $GLOBALS['ISC_CLASS_ADMIN_REVIEW']->ManageReviewsGrid($numReviews);
				if($numReviews > 0) {
					$tags[] = $this->MakeXMLTag('grid', $grid, true);
				}
			}
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
			exit;
		}

		/**
		 * Bulk delete reviews from the manage reviews page
		 *
		 * @return void
		 **/
		private function DeleteReviews()
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('reviews');
			$GLOBALS['ISC_CLASS_ADMIN_REVIEW'] = GetClass('ISC_ADMIN_REVIEW');
			$err = '';
			$msg = $GLOBALS['ISC_CLASS_ADMIN_REVIEW']->DoDeleteReviews($_POST['reviews'], $err);
			if($err != "") {
				$tags[] = $this->MakeXMLTag('status', 0);
				$tags[] = $this->MakeXMLTag('message', $err, true);
			}
			else {
				$tags[] = $this->MakeXMLTag('status', 1);
				$tags[] = $this->MakeXMLTag('message', $msg, true);

				// Log this action
				$GLOBALS['ISC_CLASS_LOG']->LogAdminAction(count($_POST['reviews']));

				$numReviews = 0;
				$grid = $GLOBALS['ISC_CLASS_ADMIN_REVIEW']->ManageReviewsGrid($numReviews);
				if($numReviews > 0) {
					$tags[] = $this->MakeXMLTag('grid', $grid, true);
				}
			}
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
			exit;
		}

		/**
		 * Allow the quick creation of a new category from the create product page
		 *
		 * @return void
		 **/
		private function SaveNewQuickCategory()
		{
			include_once(APP_ROOT."/../lib/api/category.api.php");

			$_POST['catpagetitle'] = '';
			$_POST['catmetakeywords'] = '';
			$_POST['catmetadesc'] = '';
			$_POST['catlayoutfile'] = '';
			$_POST['catsort'] = 0;
			$_POST['catimagefile'] = '';

			$category = new API_CATEGORY();
			$CatID = $category->create();
			if($category->error) {
				$tags[] = $this->MakeXMLTag('status', 0);
				$tags[] = $this->MakeXMLTag('message', $category->error, true);
			}
			else {
				$tags[] = $this->MakeXMLTag('status', 1);

				// Log this action
				$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($CatID, $_POST['catname']);

				if(isset($_POST['selectedcats']) && is_array($_POST['selectedcats'])) {
					array_walk($_POST['selectedcats'], 'intval');
				}
				else {
					$_POST['selectedcats'] = array();
				}
				$_POST['selectedcats'][] = $CatID;
				$selectedCategories = $_POST['selectedcats'];
				require_once(dirname(__FILE__) . "/class.category.php");
				$GLOBALS['ISC_CLASS_ADMIN_CATEGORY'] = GetClass('ISC_ADMIN_CATEGORY');
				$categories = sprintf("<select size=\"5\" id=\"category\" name=\"category[]\" class=\"Field400 ISSelectReplacement\" style=\"height:140px;\" multiple>%s</select>", $GLOBALS['ISC_CLASS_ADMIN_CATEGORY']->GetCategoryOptions($selectedCategories, "<option %s value='%d'>%s</option>", 'selected="selected"', "", false));
				$tags[] = $this->MakeXMLTag('catid', $CatID, true);
				$tags[] = $this->MakeXMLTag('categories', $categories, true);
			}
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
			exit;
		}

		/**
		 * Save a product download file for a digital product on the server from the add/edit product page
		 *
		 * @return void
		 **/
		private function SaveProductDownload()
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('products');

			$GLOBALS['ISC_CLASS_ADMIN_PRODUCT'] = GetClass('ISC_ADMIN_PRODUCT');
			$err = '';
			$_REQUEST['downdescription'] = urldecode($_REQUEST['downdescription']);
			if($GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->SaveProductDownload($err)) {
				if(isset($_REQUEST['downloadid'])) {
					$GLOBALS['ISC_LANG']['ProductDownloadUploaded'] = GetLang('ProductDownloadSaved');
				}
				if(isset($_REQUEST['productId'])) {
					$grid = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->GetDownloadsGrid($_REQUEST['productId']);
				}
				else {
					$grid = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->GetDownloadsGrid(0, $_REQUEST['productHash']);
				}
				$tags[] = $this->MakeXMLTag('status', 1);
				$tags[] = $this->MakeXMLTag('message', GetLang('ProductDownloadUploaded'), true);
				$tags[] = $this->MakeXMLTag('grid', $grid, true);
			}
			else {
				$tags[] = $this->MakeXMLTag('status', 0);
				$tags[] = $this->MakeXMLTag('message', $err, true);
			}
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
			die();
		}

		/**
		 * Delete a product download file for a digital product on the server from the add/edit product page
		 *
		 * @return void
		 **/
		private function DeleteProductDownload()
		{
			$GLOBALS['ISC_CLASS_ADMIN_PRODUCT'] = GetClass('ISC_ADMIN_PRODUCT');
			$GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->DeleteProductDownload($_REQUEST['downloadid']);
			$tags[] = $this->MakeXMLTag('status', 1);
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
			die();
		}

		/**
		 * Edit a product download file for a digital product on the server from the add/edit product page
		 *
		 * @return void
		 **/
		private function EditProductDownload()
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('products');

			$query = sprintf("select * from [|PREFIX|]product_downloads where downloadid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($_REQUEST['downloadid']));
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

			if (!$row) {
				die();
			}

			$GLOBALS['DownloadId'] = (int) $row['downloadid'];
			$GLOBALS['DownloadName'] = isc_html_escape($row['downname']);
			$GLOBALS['DownloadDescription'] = isc_html_escape($row['downdescription']);
			$GLOBALS['MaxDownloads'] = (int) $row['downmaxdownloads'];

			if($row['downexpiresafter']) {
				$days = $row['downexpiresafter']/86400;
				if(($days % 365) == 0) {
					$GLOBALS['ExpiresAfter'] = $days/365;
					$GLOBALS['RangeYearsSelected'] = "selected=\"selected\"";
				}
				else if(($days % 30) == 0) {
					$GLOBALS['ExpiresAfter'] = $days/30;
					$GLOBALS['RangeMonthsSelected'] = "selected=\"selected\"";
				}
				else if(($days % 7) == 0) {
					$GLOBALS['ExpiresAfter'] = $days/7;
					$GLOBALS['RageWeeksSelected'] = "selected=\"selected\"";
				}
				else {
					$GLOBALS['ExpiresAfter'] = $days;
				}
			}

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("product.form.download.edit");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}

		private function PreviewLogo()
		{
			GetLib('logomaker/class.logomaker');

			$logoPath = ISC_BASE_PATH."/templates/".GetConfig('template')."/logo/";
			$configFile = $logoPath.'config.php';
			$logoName = GetConfig('template');

			if(!file_exists($configFile)) {
				$tags = array();
				$tags[] = $this->MakeXMLTag('status', 0);
				$tags[] = $this->MakeXMLTag('message', 'Config file for '.$logoName.' doesn\'t exist');
				$this->SendXMLHeader();
				$this->SendXMLResponse($tags);
				die();
			}

			require $configFile;
			$className = $logoName .'_logo';
			$tmpClass = new $className;
			$logoImage = $logoName.'.'.$tmpClass->FileType;

			if(isset($_POST['ExtraText0'])) {
				$fields = array();
				$name = 'ExtraText0';
				$i = 0;
				while(isset($_POST[$name])) {
					if($_POST[$name]) {
						$tmpClass->Text[$i] = $_POST[$name];
					}
					$i++;
					$name = 'ExtraText'.$i;
				}
			}

			$logoData = $tmpClass->GenerateLogo();
			ClearTmpLogoImages();
			$imageFile = 'tmp_'.$logoName.'_'.rand(5,10000).'.png';
			file_put_contents(ISC_BASE_PATH . '/cache/logos/'.$imageFile, $logoData);
			$tags = array();
			$tags[] = $this->MakeXMLTag('status', 1);
			$tags[] = $this->MakeXMLTag('logoImage', $imageFile);
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
			die();
		}

		private function UpdateLogo()
		{
			$tpl = GetClass('ISC_ADMIN_LAYOUT');
			$textArray = array();

			$fields = array();
			if(isset($_POST['ExtraText0'])) {
				$name = 'ExtraText0';
				$i = 0;
				while(isset($_POST[$name])) {
					$fields[] = $_POST[$name];
					$i++;
					$name = 'ExtraText'.$i;
				}
			}

			$imageFile = $tpl->BuildLogo($_REQUEST['logo'], $fields);

			if(!$imageFile) {
				$tags = array();
				$tags[] = $this->MakeXMLTag('status', 0);
				$tags[] = $this->MakeXMLTag('message', 'Config file for '.$logoName.' doesn\'t exist');
				$this->SendXMLHeader();
				$this->SendXMLResponse($tags);
				die();
			}

			$tags = array();
			$tags[] = $this->MakeXMLTag('status', 1);
			$tags[] = $this->MakeXMLTag('logoImage', $imageFile);
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
			die();
		}

		private function UpdateLogoNone()
		{
			$s = GetClass('ISC_ADMIN_SETTINGS');

			$GLOBALS['ISC_NEW_CFG']['LogoType'] = "text";

			$GLOBALS['ISC_NEW_CFG']['UsingLogoEditor'] = 0;
			$GLOBALS['ISC_NEW_CFG']['UsingTemplateLogo'] = 0;

			if($_POST['UseAlternateTitle'] == 'true') {
				$GLOBALS['ISC_NEW_CFG']['UseAlternateTitle'] = 1;
				$GLOBALS['ISC_NEW_CFG']['AlternateTitle'] = $_POST['AlternateTitle'];
			}
			else {
				$GLOBALS['ISC_NEW_CFG']['UseAlternateTitle'] = 0;
				$GLOBALS['ISC_NEW_CFG']['AlternateTitle'] = '';
			}
			$s->CommitSettings();

			$tags = array();
			$tags[] = $this->MakeXMLTag('status', 1);
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
			die();
		}

		/**
		 * Check for new templates available for download
		 *
		 * @return void
		 **/
		private function CheckNewTemplates()
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('layout');
			$tpl = GetClass('ISC_ADMIN_LAYOUT');
			$tpl->CheckDownloadTemplates();

			if ($GLOBALS['NumNew'] > 0) {
				$tags[] = $this->MakeXMLTag('status', 1);
				$tags[] = $this->MakeXMLTag('message', $GLOBALS['NewTemplateIntro'], true);
				$tags[] = $this->MakeXMLTag('templatelist', $GLOBALS['TemplateGrid'] , true);
			} else {
				$tags[] = $this->MakeXMLTag('status', 0);
				$tags[] = $this->MakeXMLTag('message', $GLOBALS['NewTemplateIntro'], true);
			}
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
			die();
		}

		/**
		 * Download a new template zip file on the store design page
		 *
		 * @return void
		 **/
		private function DownloadTemplateFile()
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('layout');
			$tpl = GetClass('ISC_ADMIN_LAYOUT');
			$tpl->DownloadNewTemplates2();

			if(!isset($GLOBALS['ErrorMessage']) || $GLOBALS['ErrorMessage'] == "") {
				$tags[] = $this->MakeXMLTag('status', 1);
				$tags[] = $this->MakeXMLTag('message', GetLang("TemplatesDownloadedOK"), true);
				$tags[] = $this->MakeXMLTag('template', $_REQUEST['template'], true);
			}else {
				$tags[] = $this->MakeXMLTag('status', 0);
				$tags[] = $this->MakeXMLTag('message', $GLOBALS['ErrorMessage'], true);
				$tags[] = $this->MakeXMLTag('template', $_REQUEST['template'], true);
			}
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
			die();
		}

		/**
		 * Check to make sure a template is the latest version
		 *
		 * @return void
		 **/
		private function CheckTemplateVersion()
		{
			GetLib('class.remoteopener');
			$opener = new connect_remote();
			$tpl = GetClass('ISC_ADMIN_LAYOUT');
			$url = $tpl->BuildTemplateURL($GLOBALS['ISC_CFG']['TemplateVersionURL'], array(
				"template" => GetConfig('template'),
				"version" => PRODUCT_VERSION_CODE
			));
			// Get a list of available templates
			$version = '';
			if ($opener->Open($url, $version)) {
				if(isc_strtolower(isc_substr($version, 0, 5)) != "error") {
					// success
					$tags[] = $this->MakeXMLTag('status', 1);
					if ($version === '') {
						$verson = 0;
					}
					$tags[] = $this->MakeXMLTag('version', $version);
				}else {
					// there was a problem
					$tags[] = $this->MakeXMLTag('status', 0);
					$tags[] = $this->MakeXMLTag('message', $version);
				}
			}else {
				// there was a problem
				$tags[] = $this->MakeXMLTag('status', 0);
				$tags[] = $this->MakeXMLTag('message', 'Unable to open remote site for version checking');
			}
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
			die();
		}

		/**
		 * Check that the license key is valid for a commerical template
		 *
		 * @return void
		 **/
		private function CheckTemplateKey()
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('layout');
			GetLib('class.remoteopener');

			$opener = new connect_remote();

			// Get the information about this template from the remote server
			$host = base64_encode($_SERVER['HTTP_HOST']);
			$urlBits = array(
				'template' => urlencode($_REQUEST['template']),
				'key' => urlencode($_POST['templateKey']),
				'host' => $host
			);

			$url = $this->BuildTemplateURL($GLOBALS['ISC_CFG']['TemplateVerifyURL'], $urlBits);

			$response = PostToRemoteFileAndGetResponse($url);

			// A remote connection couldn't be established
			if($response === null) {
				exit;
			}

			$templateXML = @simplexml_load_string($response);
			if(!is_object($templateXML)) {
				exit;
			}

			$GLOBALS['ErrorMessage'] = '';
			if(isset($templateXML->error)) {
				switch(strval($this->error)) {
					case "invalid":
						$GLOBALS['ErrorMessage'] = GetLang('InvalidKey');
						return false;
					case "invalid_domain":
						$GLOBALS['ErrorMessage'] = GetLang('InvalidKeyDomain');
						return false;
					case "invalid_tpl":
						$GLOBALS['ErrorMessage'] = GetLang('InvalidKeyTemplate');
						return false;
					case "invalid_tpl2":
						$GLOBALS['ErrorMessage'] = GetLang('InvalidKeyTemplate2');
						return false;
					default:
						$GLOBALS['ErrorMessage'] = GetLang('InvalidTemplate');
						return false;
				}
			}

			if($GLOBALS['ErrorMessage'] == '') {
				$tags[] = $this->MakeXMLTag('status', 1);
			}
			else {
				$tags[] = $this->MakeXMLTag('status', 0);
				$tags[] = $this->MakeXMLTag('message', $GLOBALS['ErrorMessage']);
			}

			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
			die();
		}

		/**
		 * Get the related products when you pick a category on the add/edit a product page if you are manually specifying related products
		 *
		 * @return void
		 **/
		private function GetRelatedProducts()
		{
			$output = "";
			$cat = (int)$_REQUEST['c'];

			$query = sprintf("select * from [|PREFIX|]categoryassociations ca inner join [|PREFIX|]products p on ca.productid=p.productid where ca.categoryid='%d' order by p.prodname", $GLOBALS['ISC_CLASS_DB']->Quote($cat));
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$output .= sprintf("%d~~~%s|||", $row['productid'], $row['prodname']);
			}

			echo $output;
		}

		/**
		 * Show the inventory management quick view on the manage products page if inventory tracking is on for a product
		 *
		 * @return void
		 **/
		private function GetInventoryLevels()
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('products');

			if(isset($_REQUEST['p']) && isset($_REQUEST['i']) && isset($_REQUEST['v']) && isset($_REQUEST['t'])) {
				$prodId = (int)$_REQUEST['p'];
				$invType = (int)$_REQUEST['i'];
				$variationId = (int)$_REQUEST['v'];
				$combinations = array();

				// First determine if inventory tracking is by product or by option
				if ($invType == 1) {
					// Simply query the products table for current and low stock levels
					$query = sprintf("select prodcurrentinv, prodlowinv from [|PREFIX|]products where productid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($prodId));
					$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

					if($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
						printf("<b style='font-size:13px; padding-bottom:5px'>%s</strong>", GetLang("UpdateInventoryLevels"));
						echo "<table border='0'>";
						echo "<tr>";
						echo "<td valign='top'><img src='images/nodejoin.gif' style='padding-top:5px' /></td>";
						printf("<td>%s:</td>", GetLang("CurrentStock"));
						printf("<td><input type='text' size='3' value='%d' name='stock_level_%d' id='stock_level_%d' /></td>", $row['prodcurrentinv'], $prodId, $prodId);
						echo "</tr>";
						echo "<tr>";
						echo "<td>";
						printf("<td>%s:</td>", GetLang("LowStockLevel"));
						printf("<td><input type='text' size='3' value='%d' name='stock_level_notify_%d' id='stock_level_notify_%d' /></td>", $row['prodlowinv'], $prodId, $prodId);
						echo "</tr>";
						echo "</table>";
						printf("<input class='StockButton' type='button' value='%s' onclick='UpdateStockLevel(%d, 0)' style='margin-left:110px' />&nbsp; <img src='images/ajax-blank.gif' id='loading%d' />", GetLang("Save"), $prodId, $prodId);
					}
				} else {
					$optionIds = array();

					// Fetch out the variation combinations for this product
					$query = "SELECT * FROM [|PREFIX|]product_variation_combinations WHERE vcproductid='".$prodId."'";
					$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
					while($combination = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
						$combinations[] = $combination;
						$optionIds = array_merge($optionIds, explode(",", $combination['vcoptionids']));
					}

					$optionIds = array_unique($optionIds);

					// Now fetch out the options we need to get
					if(!empty($optionIds)) {
						$optionIds = implode(",", $optionIds);
						// Get the combination options
						$variations = array();
						$query = "SELECT * FROM [|PREFIX|]product_variation_options WHERE voptionid IN (".$optionIds.")";
						$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
						while($variation = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
							$variations[$variation['voptionid']] = array($variation['voname'], $variation['vovalue']);
						}
					}

					printf("<b style='font-size:13px'>%s</strong><div style='padding:20px 20px 0px 20px'>", GetLang("UpdateInventoryLevels"));

					foreach($combinations as $row) {
						$output = "";
						$options = explode(",", $row['vcoptionids']);

						foreach($options as $option) {
							$output .= isc_html_escape($variations[$option][0]) . ": " . isc_html_escape($variations[$option][1]) . ", ";
						}

						$output = trim($output, ', ');
						echo "<strong><em>" . $output . "</em></strong>";
						echo "<br />";
						echo "<table border='0' style='padding-bottom:10px'>";
						echo "<tr>";
						echo "<td valign='top'><img src='images/nodejoin.gif' style='padding-top:5px' /></td>";
						printf("<td>%s:</td>", GetLang("CurrentStock"));
						printf("<td><input type='text' size='3' value='%d' name='stock_level_%d_%d' id='stock_level_%d_%d' /></td>", $row['vcstock'], $prodId, $row['combinationid'], $prodId, $row['combinationid']);
						echo "</tr>";
						echo "<tr>";
						echo "<td>";
						printf("<td>%s:</td>", GetLang("LowStockLevel"));
						printf("<td><input type='text' size='3' value='%d' name='stock_level_%d_%d' id='stock_level_notify_%d_%d' /></td>", $row['vclowstock'], $prodId, $row['combinationid'], $prodId, $row['combinationid']);
						echo "</tr>";
						echo "</table>";
					}

					echo "</div>";
					printf("<input class='StockButton' type='button' value='%s' onclick='UpdateStockLevel(%d, 1)' style='margin-left:130px' />&nbsp; <img src='images/ajax-blank.gif' id='loading%d' />", GetLang('Save'), $prodId, $prodId);
				}
			}
		}

		/**
		 * Display the configurable product fields in order's quick view
		 *
		 * @param int $orderProdId Order product item id
		 * @param int $orderId order id
		 * @return void
		 **/
		private function GetOrderProductsFieldsRow($fields)
		{
			if(empty($fields)) {
				return '';
			}

			$productFields = '';

			$productFields .= "<tr><td height='18' class='text' colspan='2'><div style='padding-left: 20px;'><strong>".GetLang('ConfigurableFields').":</strong><br /><dl class='HorizontalFormContainer'>";

			foreach($fields as $field) {
				$fieldValue = '';
				$fieldName = $field['fieldname'];
				switch($field['fieldtype']) {
					// the field is a file, add a link to the file name
					case 'file':
						$fieldValue = "<a target='_blank' href='".$GLOBALS['ShopPath']."/viewfile.php?orderprodfield=".$field['orderfieldid']."' >".isc_html_escape($field['originalfilename'])."</a>";
						break;
					case 'checkbox':
						$fieldValue = GetLang('Checked');
						break;
					default:
						if(isc_strlen($field['textcontents'])>50) {
							$fieldValue = isc_html_escape(isc_substr($field['textcontents'], 0, 50))." <a href='#' onclick='Order.LoadOrderProductFieldData(".$field['orderid']."); return false;'><i> ".GetLang('More')."</i></a>";
						} else {
							$fieldValue = isc_html_escape($field['textcontents']);
						}
						break;
				}

				if($fieldValue != '') {
					$productFields .= "<dt>".isc_html_escape($fieldName).":</dt>";
					$productFields .= "<dd>".$fieldValue."</dd>";
				}
			}

			$productFields .= "</dl></div></td></tr>";
			return $productFields;
		}

		/**
		 * Display the quick view for an order
		 *
		 * @return void
		 **/
		public function GetOrderQuickView()
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('orders');

			// Output a quick view for this order to be used on the manage orders page
			$orderId = (int) $_REQUEST['o'];
			$GLOBALS["OrderId"] = $orderId;

			// Get the details for this order from the database
			$query = "
				SELECT o.*, CONCAT(custconfirstname, ' ', custconlastname) AS custname, custconemail, custconphone, s.zonename AS shippingzonename,
				(SELECT COUNT(messageid) FROM [|PREFIX|]order_messages WHERE messageorderid=orderid AND messagestatus='unread') AS numunreadmessages
				FROM [|PREFIX|]orders o
				LEFT JOIN [|PREFIX|]customers c ON (c.customerid=o.ordcustid)
				LEFT JOIN [|PREFIX|]shipping_zones s ON (s.zoneid=o.ordshippingzoneid)
				WHERE o.orderid='".$GLOBALS['ISC_CLASS_DB']->Quote($orderId)."'
			";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			if ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				// If this user is a vendor, do they have permission to acess this order?
				if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() && $row['ordvendorid'] != $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
					exit;
				}

				$GLOBALS['OrderDate'] = isc_date("d M Y H:i:s",$row['orddate']);
				$GLOBALS['ISC_CLASS_ADMIN_ORDERS'] = GetClass('ISC_ADMIN_ORDERS');
				$GLOBALS['OrderStatusOptions'] = $GLOBALS['ISC_CLASS_ADMIN_ORDERS']->GetOrderStatusOptions($row['ordstatus']);
				$GLOBALS['TrackingNo'] = $row['ordtrackingno'];
				$GLOBALS['NumMessages'] = $row['numunreadmessages'];

				if($row["numunreadmessages"] == 0) {
					$GLOBALS["HideMessages"] = "none";
				}

				if(!gzte11(ISC_LARGEPRINT)) {
					$GLOBALS["HideMessageItems"] = "none";
				}

				$row['custname'] = isc_html_escape(trim($row['custname']));

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
				$GLOBALS['BillingAddress'] = ISC_ADMIN_ORDERS::BuildOrderAddressDetails($addressDetails);

				$GLOBALS['BillingEmail'] = '';
				$GLOBALS['BillingPhone'] = '';
				$GLOBALS['ShippingEmail'] = '';
				$GLOBALS['ShippingPhone'] = '';

				// For the iPhone's "Map This" feature
				$GLOBALS['OneLineBillingAddress'] = trim(isc_html_escape($row['ordbillstreet1'] . ' ' . $row['ordbillstreet2'] . ' ' . $row['ordbillsuburb'] . ' ' . $row['ordbillstate'] . ' ' . $row['ordbillzip'] . ' ' . $row['ordbillcountry']));
				$GLOBALS['OneLineShippingAddress'] = trim(isc_html_escape($row['ordshipstreet1'] . ' ' . $row['ordshipstreet2'] . ' ' . $row['ordshipsuburb'] . ' ' . $row['ordshipstate'] . ' ' . $row['ordshipzip'] . ' ' . $row['ordshipcountry']));

				// This customer still exists, use their most recent email address and phone number
				if($row['custname'] != '') {
					$GLOBALS['BillingEmail'] = sprintf('<a href="mailto:%s" target="_blank">%s</a>', urlencode($row['custconemail']), isc_html_escape($row['custconemail']));
					$GLOBALS['ShippingEmail'] = sprintf('<a href="mailto:%s" target="_blank">%s</a>', urlencode($row['custconemail']), isc_html_escape($row['custconemail']));

					if ($row['ordbillphone'] != '') {
						$GLOBALS['BillingPhone'] = isc_html_escape($row['ordbillphone']);
					} else {
						$GLOBALS['BillingPhone'] = isc_html_escape($row['custconphone']);
					}

					if ($row['ordshipphone'] != '') {
						$GLOBALS['ShippingPhone'] = isc_html_escape($row['ordshipphone']);
					} else {
						$GLOBALS['ShippingPhone'] = isc_html_escape($row['custconphone']);
					}
				}
				// Customer has been removed but we still have the email address and phone number from when they placed their order
				else if($row['ordbillphone'] != '' || $row['ordbillemail'] != '' || $row['ordshipphone'] != '' || $row['ordshipemail'] != '') {
					$GLOBALS['BillingEmail'] = sprintf('<a href="mailto:%s" target="_blank">%s</a>', $row['ordbillemail'], $row['ordbillemail']);
					$GLOBALS['BillingPhone'] = isc_html_escape($row['ordbillphone']);
					$GLOBALS['ShippingEmail'] = sprintf('<a href="mailto:%s" target="_blank">%s</a>', $row['ordshipemail'], $row['ordshipemail']);
					$GLOBALS['ShippingPhone'] = isc_html_escape($row['ordshipphone']);
				}

				if ($GLOBALS['BillingPhone'] === '') {
					$GLOBALS['BillingPhone'] = GetLang('NA');
				}
				if ($GLOBALS['BillingEmail'] === '') {
					$GLOBALS['BillingEmail'] = GetLang('NA');
				}
				if ($GLOBALS['ShippingPhone'] === '') {
					$GLOBALS['ShippingPhone'] = GetLang('NA');
				}
				if ($GLOBALS['ShippingEmail'] === '') {
					$GLOBALS['ShippingEmail'] = GetLang('NA');
				}

				$GLOBALS['PaymentMethod'] = array();

				if($row['orderpaymentmethod'] == '') {
					$row['orderpaymentmethod'] = "N/A";
				}

				if($row['orderpaymentmethod'] != "storecredit" && $row['orderpaymentmethod'] != "giftcertificate") {
					if($row['ordgatewayamount']) {
						$row['orderpaymentmethod'] .= " (". FormatPriceInCurrency($row['ordgatewayamount'], $row['orddefaultcurrencyid']).")";
					}
					else {
						$row['orderpaymentmethod'] .= " (". FormatPriceInCurrency($row['ordtotalamount'], $row['orddefaultcurrencyid']).")";
					}

					// Does the payment method have any extra info to show?
					$provider = null;
					$GLOBALS['ExtraInfo'] = '';
					if(GetModuleById('checkout', $provider, $row['orderpaymentmodule'])) {
						if(method_exists($provider, "DisplayPaymentDetails")) {
							$GLOBALS['ExtraInfo'] = $provider->DisplayPaymentDetails($row);
						}
					}

					$GLOBALS['PaymentMethod'][] = $row['orderpaymentmethod'];
				}
				if($row['ordstorecreditamount'] > 0) {
					$GLOBALS['PaymentMethod'][] = GetLang('PaymentStoreCredit') . " (".FormatPriceInCurrency($row['ordstorecreditamount'], $row['orddefaultcurrencyid']) . ")";
				}

				if($row['ordgiftcertificateamount'] > 0 && gzte11(ISC_LARGEPRINT)) {
					$GLOBALS['PaymentMethod'][] = sprintf(GetLang('PaymentGiftCertificates'), $row['orderid']) . " (".FormatPriceInCurrency($row['ordgiftcertificateamount'], $row['orddefaultcurrencyid']) . ")";
				}

				$GLOBALS['IPAddress'] = $row['ordipaddress'];

				$GLOBALS['PaymentMethod'] = implode("<br />", $GLOBALS['PaymentMethod']);

				$GLOBALS['HideShippingZone'] = 'display: none';

				if ($row['ordpayproviderid'] != '') {
					$GLOBALS['TransactionId'] = $row['ordpayproviderid'];
				} else {
					$GLOBALS['TransactionId'] = GetLang('NA');
					$GLOBALS['HideTransactionId'] = 'display: none';
				}

				$extraArray = @unserialize($row['extrainfo']);
				$paymentMessage = '';
				if(isset($extraArray['payment_message']) && $extraArray['payment_message']!= '') {
					$paymentMessage = "<br />".isc_html_escape($extraArray['payment_message']);
				}

				if (isset($row['ordpaymentstatus']) && $row['ordpaymentstatus'] != '') {
					$GLOBALS['PaymentStatus'] = ucfirst($row['ordpaymentstatus']).$paymentMessage;
				}
				else {
					$GLOBALS['PaymentStatus'] = GetLang('NA');
					if($paymentMessage) {
						$GLOBALS['PaymentStatus'] .= $paymentMessage;
					}
					else {
						$GLOBALS['HidePaymentStatus'] = 'display: none';
					}
				}

				$GLOBALS['CouponsUsed'] = '';
				$GLOBALS['HideCouponsUsed'] = 'display: none';

				// Get the products in the order
				$query = "SELECT o.*
					FROM [|PREFIX|]order_coupons o
					WHERE ordcouporderid='" . $orderId . "'";

				$coupons = $GLOBALS['ISC_CLASS_DB']->Query($query);
                $allcoupons = array();
                $couponcode = '';
				while($coupon = $GLOBALS['ISC_CLASS_DB']->Fetch($coupons)) {
                    $allcoupons[] = $coupon;
                    if($couponcode != $coupon['ordcouponcode'])    {  
                        $couponcode = $coupon['ordcouponcode'];
					    $GLOBALS['CouponsUsed'] .= $coupon['ordcouponcode'] . ',';
					    $GLOBALS['HideCouponsUsed'] = '';
                        $CoupDetails  = "Coupon Code : ".$coupon['ordcouponcode']."<br />";
                        if($coupon['ordcoupontype']==0)    {
                            $CoupDetails  .= "Coupon Amount : ".FormatPriceInCurrency($coupon['ordcouponamount'], $row['orddefaultcurrencyid'])."<br />"; 
                        }
                        else    {
                            $CoupDetails  .= "Coupon Amount : ".$coupon['ordcouponamount']."%<br />";
                        }
                        //$CoupDetails .= "Coupon Name : ".$coupon['ordcouponcode'];
                        $GLOBALS['CouponsUsedDetails']   .= $CoupDetails;
                    }
				}


				// If it's a digital order then we don't need to show the shipping details
				if ($row['ordisdigital'] == 0) {
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
					$GLOBALS['ShippingAddress'] = ISC_ADMIN_ORDERS::BuildOrderAddressDetails($addressDetails);

					if ($row['ordshipmethod'] != "") {
						$GLOBALS['ShippingMethod'] = isc_html_escape($row['ordshipmethod']);
					} else {
						$GLOBALS['ShippingMethod'] = GetLang('NA');
					}

					if($row['ordshippingzoneid'] != 0) {
						$GLOBALS['HideShippingZone'] = '';
						if($row['shippingzonename']) {
							$GLOBALS['ShippingZone'] = "<a href=\"index.php?ToDo=editShippingZone&amp;zoneId=".$row['ordshippingzoneid']."\">".isc_html_escape($row['shippingzonename'])."</a>";
							$GLOBALS['ShippingZoneNoLink'] = isc_html_escape($row['shippingzonename']);
						}
						else {
							$GLOBALS['ShippingZone'] = isc_html_escape($row['shippingzonename']);
						}
					}

					$GLOBALS['ShippingCost'] = FormatPriceInCurrency($row['ordshipcost'], $row['orddefaultcurrencyid']);
				}
				else {
					$GLOBALS['HideShippingPanel'] = "none";
				}

				$GLOBALS['HideVendor'] = 'display: none';
				/*                                                              //if.. loop Commented by Simha to hide vendors
                if(gzte11(ISC_HUGEPRINT) && $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() == 0 && $row['ordvendorid'] > 0) {
					$GLOBALS['HideVendor'] = '';
					$vendorCache = $GLOBALS['ISC_CLASS_DATA_STORE']->Read('Vendors');
					if(isset($vendorCache[$row['ordvendorid']])) {
						$vendor = $vendorCache[$row['ordvendorid']];
						$GLOBALS['VendorName'] = isc_html_escape($vendor['vendorname']);
						$GLOBALS['VendorId'] = $vendor['vendorid'];
						$GLOBALS['HideVendor'] = '';
					}
				}
                */
				$prodFieldsArray=$GLOBALS['ISC_CLASS_ADMIN_ORDERS']->GetOrderProductFieldsData($orderId);

				// Get the products in the order
				$query = "
					SELECT o.*, p.prodname
					FROM [|PREFIX|]order_products o
					LEFT JOIN [|PREFIX|]products p ON (p.productid=o.ordprodid)
					WHERE orderorderid='" . $orderId . "'
					ORDER BY ordprodname";

				$pResult = $GLOBALS['ISC_CLASS_DB']->Query($query);

				$GLOBALS['ProductsTable'] = "<table width=\"95%\" align=\"center\" border=\"0\" cellspacing=0 cellpadding=0>";

				// Add a notice about the order containing only digitally downloadable products
				if($row['ordisdigital'] == 1) {
					$GLOBALS['ProductsTable'] .= sprintf("

						<tr>
							<td style=\"padding:5px; background-color:lightyellow\" width=\"100%%\" class=\"text\" colspan=\"2\">
								%s
							</td>
						</tr>
						<tr>
							<td colspan=\"2\">&nbsp;</td>
						</tr>
					", GetLang('DigitalOrderNotice'));
				}
				$wrappingTotal = 0;
				while($pRow = $GLOBALS['ISC_CLASS_DB']->Fetch($pResult)) {
					$sku = "";

					if($pRow['ordprodsku'] != "") {
						$sku = "<br /><em>" . isc_html_escape($pRow['ordprodsku']) . "</em>";
					}

					$sStart = $sEnd = '';
					$refunded = '';
					$shippedLabel = '';
					if($pRow['ordprodqtyshipped'] > 0) {
						$shippedLabel = '<div class="Shipped">'.sprintf(GetLang('OrderProductsShippedX'), $pRow['ordprodqtyshipped']).'</div>';
					}

					if($pRow['ordprodrefunded'] > 0) {
						if($pRow['ordprodrefunded'] == $pRow['ordprodqty']) {
							$sStart = "<del>";
							$sEnd = "</del>";
							$refunded = '<div class="Refunded">'.GetLang('OrderProductRefunded').'</span>';
						}
						else {
							$refunded = '<div class="Refunded">'.sprintf(GetLang('OrderProductsRefundedX'), $pRow['ordprodrefunded']).'</div>';
						}
						$cost = $pRow['ordprodcost'] * ($pRow['ordprodqty'] - $pRow['ordprodrefunded']);
					}
					else {
						$cost = $pRow['ordprodcost'] * $pRow['ordprodqty'];
					}

					if($pRow['prodname']) {
						$pRow['ordprodname'] = "<a href='".ProdLink($pRow['prodname'])."' target='_blank'>".isc_html_escape($pRow['ordprodname'])."</a>";
					}

					$pOptions = '';
					if($pRow['ordprodoptions'] != '') {
						$options = @unserialize($pRow['ordprodoptions']);
						if(!empty($options)) {
							$pOptions = "<blockquote style=\"padding-left: 10px; margin: 0;\">";
							$comma = '';
							foreach($options as $name => $value) {
								$pOptions .= $comma.isc_html_escape($name).": ".isc_html_escape($value);
								$comma = '<br />';
							}
							$pOptions .= "</blockquote>";
						}
					}
                    
                    $prodYMMInfo = '';
                    
                    /*
                    if($pRow['mmyinfo'] != '') {
                        $YMMOptions = @unserialize($pRow['mmyinfo']);
                        if(!empty($YMMOptions)) {
                            $prodYMMInfo = "<blockquote style=\"padding-left: 0px; margin: 0;\">";
                            $prodYMMInfo .= $YMMOptions['year']."&nbsp;".$YMMOptions['make']."&nbsp;".$YMMOptions['model'];
                            $prodYMMInfo .= "</blockquote>";
                        }
                    }
                    */
                    
                    if($pRow['ordyear'] != '' || $pRow['ordmake'] != '' || $pRow['ordmodel'] != '')    {
                        $prodYMMInfo = "<blockquote style=\"padding-left: 0px; margin: 0;\">";
                        $prodYMMInfo .= $pRow['ordyear']."&nbsp;".$pRow['ordmake']."&nbsp;".$pRow['ordmodel'];
                        $prodYMMInfo .= "</blockquote>"; 
                    }
                    if(count($allcoupons))    {                       //$pRow['ordoriginalprice'] < $pRow['ordprodcost'] 
                        if($pRow['ordoriginalprice'] > $pRow['ordprodcost'])    { 
                            $prodYMMInfo .= "<blockquote style=\"padding-left: 0px; margin: 0;\">";
                            $origPrice    = $pRow['ordoriginalprice'];                          
                            $prodYMMInfo .= '<u>Original Price : '. FormatPriceInCurrency($origPrice, $row['orddefaultcurrencyid'])."<br />";
                            $DiscountAmt = number_format($pRow['ordoriginalprice'] - $pRow['ordprodcost'], 2);  
                            $prodYMMInfo .= 'Discount : '.FormatPriceInCurrency($DiscountAmt, $row['orddefaultcurrencyid'])."</u>";  
                            $prodYMMInfo .= "</blockquote>"; 
                        }       
                    }

					if($pRow['ordprodwrapcost'] > 0) {
						$wrappingTotal += $pRow['ordprodwrapcost'] * $pRow['ordprodqty'];
					}

					$giftOptions = '';
					if($pRow['ordprodwrapname']) {
						$giftOptions .= "<tr><td height='18' class='QuickGiftWrapping text' colspan='2'><div>";
						$giftOptions .= GetLang('GiftWrapping').": ".isc_html_escape($pRow['ordprodwrapname']);
						$giftOptions .= " [<a href='#' onclick=\"\$.iModal({type: 'ajax', url: 'remote.php?remoteSection=orders&w=viewGiftWrappingDetails&orderprodid=".$pRow['orderprodid']."'}); return false;\">".GetLang('ViewDetails')."</a>]";
						$giftOptions .= "</div></td></tr>";
					}

					$prodFields= '';
					if(isset($prodFieldsArray[$pRow['orderprodid']])) {
						$prodFields = $this->GetOrderProductsFieldsRow($prodFieldsArray[$pRow['orderprodid']]);
					}

					$eventDate='';
					if ($pRow['ordprodeventdate'] != null) {
						$eventDate = '<tr><td style="padding:5px 0px 5px 15px;">'.$pRow['ordprodeventname'] . ': ' . isc_date('jS M Y', $pRow['ordprodeventdate']) . '</tr>';
					}

					$itemDetails = '';
					if($shippedLabel || $refunded) {
						$itemDetails = "<tr><td class='text' colspan='2' style='padding-left: 20px;'>";
						$itemDetails .= $shippedLabel.$refunded;
						$itemDetails .= '</td></tr>';
					}

					$GLOBALS['ProductsTable'] .= "
						<tr>
							<td style=\"padding-left:12px; padding-top:5px\" width=\"70%\" class=\"text\">".$sStart.$pRow['ordprodqty']." x ".$pRow['ordprodname'].$sEnd.$sku.$pOptions.$prodYMMInfo."</td>
							<td class=\"text\" width=\"30%%\" align=\"right\">".FormatPriceInCurrency($cost, $row['orddefaultcurrencyid'])."</td>
						</tr>
						".$giftOptions.$eventDate.$prodFields.$itemDetails."
					";
				}

				$GLOBALS['ProductsTable'] .= "<tr><td colspan='2'><hr noshade size='1'></td></tr>";

				$GLOBALS['ProductsTable'] .= sprintf("<tr><td height='18' class='text' align='right'>%s:</td><td class='text' align='right'>%s</td></tr>", GetLang('SubTotal'), FormatPriceInCurrency($row['ordsubtotal'], $row['orddefaultcurrencyid']));

				if($wrappingTotal > 0) {
					$GLOBALS['ProductsTable'] .= sprintf("<tr><td height='18' class='text' align='right'>%s:</td><td class='text' align='right'>%s</td></tr>", GetLang('GiftWrapping'), FormatPriceInCurrency($wrappingTotal, $row['orddefaultcurrencyid']));
				}

				// Do we need to show a shipping cost?
				if($row['ordshipmethod'] != "" && $row['ordshipcost'] > 0) {
					$GLOBALS['ProductsTable'] .= sprintf("<tr><td height='18' class='text' align='right'>%s:</td><td class='text' align='right'>%s</td></tr>", GetLang('Shipping'), FormatPriceInCurrency($row['ordshipcost'], $row['orddefaultcurrencyid']));
				}

				// Do we need to show a handling fee?
				if($row['ordhandlingcost'] > 0) {
					$GLOBALS['ProductsTable'] .= sprintf("<tr><td height='18' class='text' align='right'>%s:</td><td class='text' align='right'>%s</td></tr>", GetLang('Handling'), FormatPriceInCurrency($row['ordhandlingcost'], $row['orddefaultcurrencyid']));
				}

				if ($row['orddateshipped'] > 0) {
					$GLOBALS['ShippingDate'] = isc_date(GetConfig('DisplayDateFormat'), $row['orddateshipped']);
				} else {
					$GLOBALS['ShippingDate'] = GetLang('NA');
				}

				// Do we need to show sales tax?
				if($row['ordtaxtotal'] > 0 && $row['ordtotalincludestax'] == 0) {
					if($row['ordtaxname']) {
						$taxName = isc_html_escape($row['ordtaxname']);
					}
					else {
						$taxName = GetLang('SalesTax');
					}
					$GLOBALS['ProductsTable'] .= sprintf("<tr><td height='18' class='text' align='right'>%s:</td><td class='text' align='right'>%s</td></tr>", $taxName, FormatPriceInCurrency($row['ordtaxtotal'], $row['orddefaultcurrencyid']));
				}

				$GLOBALS['ProductsTable'] .= sprintf("<tr><td height='18' class='QuickTotal text' align='right'>%s:</td><td class='QuickTotal text' align='right'>%s</td></tr>", GetLang('Total'), FormatPriceInCurrency($row['ordtotalamount'], $row['orddefaultcurrencyid']));

				// Do we need to show sales tax that was already included in the totals? We show it after the order total
				if($row['ordtaxtotal'] > 0 && $row['ordtotalincludestax'] == 1) {
					if($row['ordtaxname']) {
						$taxName = isc_html_escape($row['ordtaxname']);
					}
					else {
						$taxName = GetLang('SalesTax');
					}
					$taxName .= ' '.GetLang('IncludedInTotal');
					$GLOBALS['ProductsTable'] .= sprintf("<tr><td height='18' class='text' align='right'>%s:</td><td class='text' align='right'>%s</td></tr>", $taxName, FormatPrice($row['ordtaxtotal']));
				}

				if (isset($row['ordpaymentstatus'])) {
					if ($row['ordpaymentstatus'] == 'refunded' || $row['ordpaymentstatus'] == 'partially refunded') {
						$GLOBALS['ProductsTable'] .= '<tr><td class="text" align="right" height="18">'.GetLang('Refunded').':</td><td class="text" align="right">'.FormatPriceInCurrency($row['ordrefundedamount'], $row['orddefaultcurrencyid']).'</td></tr>';
					}
				}

				$GLOBALS['ProductsTable'] .= "</table>";

				$GLOBALS['OrderComments'] = '';
				if (trim($row['ordcustmessage']) != '') {
					$GLOBALS['OrderComments'] = nl2br(isc_html_escape($row['ordcustmessage']));
				}
				else {
					$GLOBALS['HideOrderComments'] = 'display: none';
				}

				/**
				 * Order form field
				 */
				$GLOBALS['HideBillingFormFields'] = '';
				$GLOBALS['HideShippingFormFields'] = '';
				$GLOBALS['BillingFormFields'] = '';
				$GLOBALS['ShippingFormFields'] = '';

				$billingFields = array();
				$shippingFields = array();

				if (gzte11(ISC_MEDIUMPRINT) && isId($row['ordformsessionid'])) {
					$billingFields = $GLOBALS['ISC_CLASS_FORM']->getSavedSessionData($row['ordformsessionid'], array(), FORMFIELDS_FORM_BILLING, true);
					$shippingFields = $GLOBALS['ISC_CLASS_FORM']->getSavedSessionData($row['ordformsessionid'], array(), FORMFIELDS_FORM_SHIPPING, true);
				}

				/**
				 * Do we have the correct version?
				 */
				if (!gzte11(ISC_MEDIUMPRINT)) {
					$GLOBALS['HideBillingFormFields'] = 'none';
					$GLOBALS['HideShippingFormFields'] = 'none';

				/**
				 * OK, we're allow to
				 */
				} else {

					/**
					 * Lets do the billing first. Do we have any?
					 */
					if (empty($billingFields)) {
						$GLOBALS['HideBillingFormFields'] = 'none';
					} else {
						$GLOBALS['BillingFormFields'] = $this->buildOrderFormFields($billingFields);
					}

					/**
					 * Now the shipping
					 */
					if (empty($billingFields)) {
						$GLOBALS['HideShippingFormFields'] = 'none';
					} else {
						$GLOBALS['ShippingFormFields'] = $this->buildOrderFormFields($shippingFields);
					}
				}

				$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("order.quickview");
				$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
			} else {
				echo GetLang('OrderDetailsNotFound');
			}
		}

		private function GetMultiCountryStates()
		{
			echo GetMultiCountryStateOptions(array((int)$_REQUEST['c']));
			exit;
		}

		/**
		 * Display a list of states for a given country
		 *
		 * @return void
		 **/
		private function GetCountryStates()
		{
			$country = $_REQUEST['c'];
			if(IsId($country)) {
				$countryId = $country;
			}
			else {
				$countryId = GetCountryIdByName($country);
			}

			if(isset($_REQUEST['s']) && GetStateByName($_REQUEST['s'], $countryId)) {
				$state = $_REQUEST['s'];
			}
			else {
				$state = '';
			}

			if(isset($_REQUEST['format']) && $_REQUEST['format'] == 'options') {
				echo GetStateListAsOptions($country, $state, false, '', '', false, true);
			}
			else {
				echo GetStateList((int)$country);
			}
		}

		/**
		 * Display a summary of all the orders for a given customer
		 *
		 * @return void
		 **/
		private function GetCustomerOrders()
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('customers');

			$custId = (int) $_REQUEST['c'];

			// Get the details for the orders from the database
			$query = "
				SELECT o.*, c.custconemail
				FROM [|PREFIX|]orders o
				LEFT JOIN [|PREFIX|]customers c ON (c.customerid=o.ordcustid)
				WHERE ordcustid='".(int)$custId."' AND ordstatus != 0
			";
			if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
				$query .= " AND ordvendorid='".(int)$GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()."'";
			}
			$query .= "ORDER BY orderid DESC";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				// Output the details of the order
				$GLOBALS['OrderId'] = (int) $row['orderid'];
				$GLOBALS['OrderStatus'] = GetOrderStatusById($row['ordstatus']);
				$GLOBALS['OrderTotal'] = FormatPrice($row['ordtotalamount']);
				$GLOBALS['OrderDate'] = CDate($row['orddate']);
				$GLOBALS['OrderViewLink'] = '<a href="#" onclick="viewOrderNotes(' . $row['orderid'] . '); return false;">' . GetLang('CustomerOrderListNotesLink') . '</a>';

				$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("customer.quickorder");
				$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();

				// The email is used by the view all orders button
				$GLOBALS['Email'] = isc_html_escape($row['custconemail']);
				$GLOBALS['CustomerId'] = $row['ordcustid'];
			}
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("customer.quickorderall");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}

		/**
		 * Update the order status of a specific order from the manage orders page
		 *
		 * @return void
		 **/
		private function UpdateOrderStatus()
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('orders');

			if(isset($_REQUEST['o']) && isset($_REQUEST['s'])) {
				$order_id = (int)$_REQUEST['o'];
				$status = (int)$_REQUEST['s'];

				$order = GetOrder($order_id);
				if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() && $order['ordvendorid'] != $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
					echo 0;
					exit;
				}

				if (UpdateOrderStatus($order_id, $status)) {
					echo 1;
				} else {
					echo 0;
				}
			}
			else {
				echo 0;
			}

			exit;
		}

		/**
		 * Update the tracking number of an order from the manage orders page
		 *
		 * @return void
		 **/
		private function UpdateTrackingNo()
		{
			if(isset($_REQUEST['o']) && isset($_REQUEST['tn'])) {
				$order_id = (int)$_REQUEST['o'];

				$order = GetOrder($order_id);
				if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() && $order['ordvendorid'] != $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
					echo 0;
					exit;
				}

				$trackingno = $GLOBALS['ISC_CLASS_DB']->Quote($_REQUEST['tn']);

				$updatedOrder = array(
					"ordtrackingno" => $_REQUEST['tn'],
				);

				if ($GLOBALS['ISC_CLASS_DB']->UpdateQuery("orders", $updatedOrder, "orderid='".$GLOBALS['ISC_CLASS_DB']->Quote($order_id)."'")) {
					echo "1";
				} else {
					echo "0";
				}

				// If the checkout module that was used for an order is still enabled and has a function
				// to handle a status change, then call that function
				$valid_checkout_modules = GetAvailableModules('checkout', true, true);
				$valid_checkout_module_ids = array();
				foreach ($valid_checkout_modules as $valid_module) {
					$valid_checkout_module_ids[] = $valid_module['id'];
				}

				$query = "SELECT *
				FROM [|PREFIX|]orders
				WHERE orderid = '".$GLOBALS['ISC_CLASS_DB']->Quote($order_id)."'";
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				$order = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

				if (in_array($order['orderpaymentmodule'], $valid_checkout_module_ids)) {
					GetModuleById('checkout', $checkout_module, $order['orderpaymentmodule']);
					if (method_exists($checkout_module, 'HandleUpdateTrackingNum')) {
						call_user_func(array($checkout_module, 'HandleUpdateTrackingNum'), $order_id, $trackingno);
					}
				}

				// Log this action
				$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($order_id, $trackingno);
			}
		}

		/**
		*	Update the inventory levels for a product that has no options
		*/
		private function UpdatePerProductInventoryLevels()
		{
			if(!gzte11(ISC_MEDIUMPRINT)) {
				echo 0;
				exit;
			}

			if(isset($_REQUEST['p']) && isset($_REQUEST['c']) && isset($_REQUEST['l'])) {
				$product_id = (int)$_REQUEST['p'];
				$current_stock_level = (int)$_REQUEST['c'];
				$low_stock_level = (int)$_REQUEST['l'];

				$updatedProduct = array(
					"prodcurrentinv" => $current_stock_level,
					"prodlowinv" => $low_stock_level
				);
				if($GLOBALS['ISC_CLASS_DB']->UpdateQuery("products", $updatedProduct, "productid='".$GLOBALS['ISC_CLASS_DB']->Quote($product_id)."'")) {
					$query = sprintf("SELECT prodname FROM [|PREFIX|]products WHERE productid='%d'", $product_id);
					$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
					$prodName = $GLOBALS['ISC_CLASS_DB']->FetchOne($query);

					// Log this action
					$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($product_id, $product_id, $current_stock_level, $low_stock_level);

					echo "1";
				}
				else {
					echo "0";
				}
			}
		}

		/**
		*	Update the inventory levels for a product that has options
		*/
		private function UpdatePerOptionInventoryLevels()
		{
			if(!gzte11(ISC_MEDIUMPRINT)) {
				echo 0;
				exit;
			}

			if(isset($_REQUEST['i'])) {
				$inventory_data = $_REQUEST['i'];
				$inventory_levels = array();
				$queries = array();
				$done = array();
				$total_stock_units = 0;
				$total_low_units = 0;
				$product_id = 0;

				parse_str($inventory_data, $inv_array);

				// Execute all of the queries in a transaction
				$GLOBALS['ISC_CLASS_DB']->Query("start transaction");

				foreach($inv_array as $k=>$v) {
					$tmp = explode("_", $k);
					$id = (int)$tmp[count($tmp)-1];
					$inventory_levels[$id] = array();

					if(!in_array($id, $done)) {
						$product_id = (int)$tmp[count($tmp)-2];
						$current = (int)$inv_array["stock_level_" . $product_id . "_" . $id];
						$low = (int)$inv_array["stock_level_notify_" . $product_id . "_" . $id];

						$updatedLevels = array(
							"vcstock" => $current,
							"vclowstock" => $low
						);
						$GLOBALS['ISC_CLASS_DB']->UpdateQuery("product_variation_combinations", $updatedLevels, "combinationid='".$GLOBALS['ISC_CLASS_DB']->Quote((int)$id)."'");

						// Increment the number of total units in stock
						$total_stock_units += $current;
						$total_low_units += $low;

						// Mark this particular product option as done
						array_push($done, $id);
					}
				}

				// Log this action
				$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($product_id, $product_id, $total_stock_units, $total_low_units);

				// Finally we need to update the prodcurrentinv field in the products table
				$updatedProduct = array(
					"prodcurrentinv" => $total_stock_units
				);
				$GLOBALS['ISC_CLASS_DB']->UpdateQuery("products", $updatedProduct, "productid='".$GLOBALS['ISC_CLASS_DB']->Quote($product_id)."'");

				$err = $GLOBALS['ISC_CLASS_DB']->GetErrorMsg();
				if($err == "") {
					// No error, commit the transaction
					$GLOBALS['ISC_CLASS_DB']->Query("commit");
					echo "1";
				} else {
					// Something went wrong, rollback
					$GLOBALS['ISC_CLASS_DB']->Query("rollback");
					echo "0";
				}
			}
		}

		/**
		 * Checks if the user entered FTP settings are valid or not.
		*/
		private function TestFTPSettings()
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('settings');

			if (!function_exists("ftp_connect")) {
				exit;
			}

			@list($host, $port) = @explode(":", $_POST['host']);
			if(!$host) {
				exit;
			}
			if(!$port) {
				$port = 21;
			}
			if(!isset($_POST['user']) || !isset($_POST['pass'])) {
				exit;
			}

			$ftpcon = @ftp_connect($host, $port, 10);
			if(!$ftpcon) {
				echo sprintf('alert("%s"); $("#BackupsRemoteFTPHost").focus(); $("#BackupsRemoteFTPHost").select();', GetLang('BackupFTPBadServer'));
				exit;
			}

			$login = @ftp_login($ftpcon, $_POST['user'], $_POST['pass']);
			if(!$login) {
				echo sprintf('alert("%s"); $("#BackupsRemoteFTPUser").focus(); $("#BackupsRemoteFTPUser").select();', GetLang('BackupFTPBadUser'));
				exit;
			}

			if(isset($_POST['path']) && $_POST['path'] != "" && !@ftp_chdir($ftpcon, $_POST['path'])) {
				echo sprintf('alert("%s"); $("#BackupsRemoteFTPPath").focus(); $("#BackupsRemoteFTPPath").select();', GetLang('BackupFTPBadPath'));
				exit;
			}

			// All is well, let the user know
			echo sprintf('alert("%s");', GetLang('BackupFTPSuccess'));
			exit;
		}

		/**
		* Return a list of text custom fields for a Interspire Email Marketer mailing list
		*/
		private function GetTextCustomFieldsForMailingList()
		{
			if(isset($_REQUEST['list'])) {
				$list = $_REQUEST['list'];
				$GLOBALS['ISC_CLASS_ADMIN_SENDSTUDIO'] = GetClass('ISC_ADMIN_SENDSTUDIO');
				echo $GLOBALS['ISC_CLASS_ADMIN_SENDSTUDIO']->GetAvailableCustomFieldsForList($list, "text");
			}
		}

		/**
		* Return a list of custom fields for a Interspire Email Marketer mailing list
		*/
		private function GetCustomFieldsForMailingList()
		{
			if(isset($_REQUEST['list'])) {
				$list = $_REQUEST['list'];
				$GLOBALS['ISC_CLASS_ADMIN_SENDSTUDIO'] = GetClass('ISC_ADMIN_SENDSTUDIO');
				echo $GLOBALS['ISC_CLASS_ADMIN_SENDSTUDIO']->GetAvailableCustomFieldsForList($list);
			}
		}

		/**
		* Generate a new API key for the XML API
		*/
		private function GenerateNewAPIKey()
		{
			echo isc_html_escape(sha1(rand(1, 65535) . time() . microtime()));
		}

		/**
		* CheckAddonKey
		* Check if a valid addon key has been specified when trying to download an addon
		*/
		private function CheckAddonKey()
		{
			$url = GetConfig('AddonLicenseURL') . '?key=' . str_replace("+", "%2B", urlencode($_REQUEST['key'])) .'&h='.base64_encode(urlencode($_SERVER['HTTP_HOST']));
			$result = PostToRemoteFileAndGetResponse($url);
			echo $result;
		}

		/**
		* DownloadAddonZip
		* Download the zip file for the license and extract it
		*
		* @return Void
		*/
		private function DownloadAddonZip()
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('addons');

			if(!isset($_REQUEST['key']) && !isset($_REQUEST['prodId'])) {
				exit;
			}

			if(isset($_REQUEST['prodId'])) {
				$url = GetConfig('AddonStreamURL') . '?prodId='.(int)$_REQUEST['prodId'];
			}
			else {
				$key = $_REQUEST['key'];
				$url = GetConfig('AddonStreamURL') . '?key=' . str_replace("+", "%2B", urlencode($key)) .'&h='.base64_encode(urlencode($_SERVER['HTTP_HOST']));
			}

			$zip = PostToRemoteFileAndGetResponse($url);
			if(strlen($zip) > 0) {
				// Save the zip file to a temporary file in the cache folder which is writable
				$cache_path = realpath(ISC_BASE_PATH."/cache/");
				if(is_writable($cache_path)) {
					$temp_file = $cache_path . "/addon_" . rand(1, 100000) . ".zip";

					if($fp = fopen($temp_file, "wb")) {
						if(fwrite($fp, $zip)) {
							fclose($fp);

							// Is the addons folder writable?
							$addon_path = realpath(ISC_BASE_PATH."/addons/");

							if(is_writable($addon_path)) {
								// Try to extract the zip to the addons folder
								Getlib('class.zip');

								$archive = new PclZip($temp_file);
								if($archive->extract(PCLZIP_OPT_PATH, $addon_path) == 0) {
									// The unzipping failed
									echo GetLang("AddonUnzipFailed");
								}
								else {
									// The unzip was successful
									echo "success";
									$GLOBALS['ISC_CLASS_LOG']->LogAdminAction();
								}

								// Remove the temporary zip file
								unlink($temp_file);
							}
							else {
								echo GetLang("AddonFolderNotWritable");
							}
						}
						else {
							echo GetLang("AddonTempFolderNotWritable");
						}
					}
					else {
						echo GetLang("AddonTempFolderNotWritable");
					}
				}
				else {
					echo GetLang("AddonTempFolderNotWritable");
				}
			}
			else {
				echo GetLang("AddonDownloadZipFailed");
			}
		}

		/**
		 * Get the edit email template wysiwyg under store design
		 *
		 * @return void
		 **/
		private function GetEmailTemplate()
		{
			if(isset($_REQUEST['file']) && isset($_REQUEST['id'])) {
				$id = (int)$_REQUEST['id'];
				$file = $_REQUEST['file'];
				$file_data = "";

				if(!is_numeric(strpos($file, "/")) && !is_numeric(strpos($file, "/"))) {
					if($fp = @fopen(ISC_EMAIL_TEMPLATES_DIRECTORY . "/" . $file, "rb")) {
						while(!feof($fp)) {
							$file_data .= fgets($fp, 4096);
						}

						fclose($fp);
						$wysiwygOptions = array(
							'id'			=> 'wysiwyg_'.$id,
							'width'			=> '100%',
							'height'		=> '500px',
							'value'			=> $file_data,
							'editorOnly'	=> true,
							'delayLoad'		=> true,
						);
						$editor = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor($wysiwygOptions);
						echo "<div style='margin:10px'>" . $editor . "</div>";
					}
				}
			}
		}

		/**
		 * Update an email template that has been edited via the store design section of the control panel
		 *
		 * @return void
		 * @author /bin/bash: niutil: command not found
		 **/
		private function UpdateEmailTemplate()
		{
			$status = "failed";

			if(isset($_REQUEST['file']) && isset($_REQUEST['html'])) {
				$file = $_REQUEST['file'];
				$html = $_REQUEST['html'];

				if(!is_numeric(strpos($file, "/")) && !is_numeric(strpos($file, "/"))) {
					// Try to write the file
					$email_file = ISC_EMAIL_TEMPLATES_DIRECTORY . "/" . $file;

					if(file_exists($email_file) && is_writable($email_file)) {
						if($fp = @fopen($email_file, "wb")) {
							if(@fwrite($fp, $html)) {
								@fclose($fp);
								$status = "success";
							}
						}
					}
				}
			}

			echo $status;
		}

		/**
		* GetVariationCombinationsTable
		* Get a list of option combinations and return them as a table
		*
		* @return Void
		*/
		private function GetVariationCombinationsTable()
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('products');

			$GLOBALS['HeaderRows'] = "";
			$GLOBALS['VariationRows'] = "";
			$options = array();
			$option_ids = array();
			$i = 0;

			if(isset($_GET['v']) && is_numeric($_GET['v']) && isset($_GET['inv']) && is_numeric($_GET['inv'])) {
				$vid = (int)$_GET['v'];
				$inv = (bool)$_GET['inv'];
				$query = sprintf("SELECT DISTINCT(voname) FROM [|PREFIX|]product_variation_options WHERE vovariationid='%d' ORDER BY vooptionsort", $vid);
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

				while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					$GLOBALS['HeaderRows'] .= sprintf("<td>%s</td>", isc_html_escape($row['voname']));
					$options[$row['voname']] = array();
					$option_ids[$row['voname']] = array();
				}

				// Now get all of the variation combinations
				$query = sprintf("SELECT * FROM [|PREFIX|]product_variation_options WHERE vovariationid='%d' ORDER BY vooptionsort, vovaluesort", $vid);
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

				while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					$options[$row['voname']][] = $row['vovalue'];
					$option_ids[$row['voname']][] = (int) $row['voptionid'];
				}

				// Get the variation combinations as text, such as #red#small#modern
				$GLOBALS['variation_data'] = array();
				$GLOBALS['VariationRows'] = "";
				GetCombinationText('', $options);
				$GLOBALS['variation_combinations'] = $GLOBALS['variation_data'];

				// Get the variation combinations ID's, such as #145#185#195
				$GLOBALS['variation_data'] = array();
				GetCombinationText('', $option_ids);
				$GLOBALS['variation_combination_ids'] = $GLOBALS['variation_data'];

				// Setup a counter
				$count = 0;

				// Loop through the variation combination ID's and output them as hidden fields
				foreach($GLOBALS['variation_combination_ids'] as $k=>$combo) {
					$GLOBALS['VariationRows'] .= sprintf("	<input name='options[$count][variationcombination]' type='hidden' value='%s' /></td>", $combo);
					++$count;
				}

				// Reset the counter
				$count = 0;

				// Now loop through all of the options and output the combinations
				foreach($GLOBALS['variation_combinations'] as $k=>$combo) {
					$GLOBALS['VariationRows'] .= "<tr onmouseout=\"this.className='GridRow'\" onmouseover=\"this.className='GridRowOver'\" class=\"GridRow\">";
					$GLOBALS['VariationRows'] .= "	<td style='width:30px; padding-left:5px'><img src='images/variation.gif' width='16' height='16' /></td>";
					$GLOBALS['VariationRows'] .= "	<td style='padding-left:4px'><input name='options[$count][enabled]' type='checkbox' checked='checked' value='ON' /></td>";

					$combo = preg_replace("/^#/", "", $combo);
					$combos = explode("#", $combo);

					foreach($combos as $c) {
						$GLOBALS['VariationRows'] .= sprintf("	<td>%s</td>", isc_html_escape($c));
					}

					$GLOBALS['VariationRows'] .= "	<td><input name='options[$count][sku]' type='text' class='Field50' /></td>";

					$GLOBALS['VariationRows'] .= sprintf("	<td><select class='PriceDrop' name='options[$count][pricediff]' onchange=\"if(this.selectedIndex>0) { $(this).parent().find('span').show(); $(this).parent().find('span input').focus(); $(this).parent().find('span input').select(); } else { $(this).parent().find('span').hide(); } \"><option value=''>%s</option><option value='add'>%s</option><option value='subtract'>%s</option><option value='fixed'>%s</option></select> <span style='display:none'>%s <input name='options[$count][price]' type='text' class='Field50 PriceBox' style='width:40px' /> %s</span></td>", GetLang("NoChange"), GetLang("VariationAdd"), GetLang("VariationSubtract"), GetLang("VariationFixed"), $GLOBALS['CurrencyTokenLeft'], $GLOBALS['CurrencyTokenRight']);

					$GLOBALS['VariationRows'] .= sprintf("	<td><select class='WeightDrop' name='options[$count][weightdiff]' onchange=\"if(this.selectedIndex>0) { $(this).parent().find('span').show(); $(this).parent().find('span input').focus(); $(this).parent().find('span input').select(); } else { $(this).parent().find('span').hide(); } \"><option value=''>%s</option><option value='add'>%s</option><option value='subtract'>%s</option><option value='fixed'>%s</option></select> <span style='display:none'><input name='options[$count][weight]' type='text' class='Field50 WeightBox' style='width:40px' /> %s</span></td>", GetLang("NoChange"), GetLang("VariationAdd"), GetLang("VariationSubtract"), GetLang("VariationFixed"), GetConfig('WeightMeasurement'));

					$GLOBALS['VariationRows'] .= "	<td><input name='options[$count][image]' type='file' class='Field150 OptionImage' /></td>";


					// Is inventory tracking enabled for variations?
					if($inv) {
						$InventoryFieldsHide = "display: auto;";
					}
					else {
						$InventoryFieldsHide = "display: none;";
					}

					if($inv) {
						$GLOBALS['VariationRows'] .= "	<td class=\"VariationStockColumn\" style=\"".$InventoryFieldsHide."\"><input name='options[$count][currentstock]' type='text' class='Field50 StockLevel' value='0' /></td>";
						$GLOBALS['VariationRows'] .= "	<td class=\"VariationStockColumn\" style=\"".$InventoryFieldsHide."\"><input name='options[$count][lowstock]' type='text' class='Field50 LowStockLevel' value='0' /></td>";
					}

					$GLOBALS['VariationRows'] .= "</tr>";
					$count++;
				}

				if(!$inv) {
					$GLOBALS['HideInv'] = "none";
				}

				$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("products.variation.combination");
				echo $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
			}
		}

		/**
		* Used by add/edit a product to add a file for a digital download from the import directory
		*
		* @return string Either "success" or "failure"
		*/
		private function UseProductServerFile()
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('products');

			$tags = array();
			$err = false;

			// The file has to be a valid import file
			$p = GetClass('ISC_ADMIN_PRODUCT');
			$valid_files = $p->_GetImportFilesArray();
			if (!in_array($_REQUEST['serverfile'], $valid_files)) {
				$err = GetLang('InvalidFileName');
			}

			if ($err === false && $p->SaveProductDownload($err)) {
				$_REQUEST['downdescription'] = urldecode($_REQUEST['downdescription']);

				if (isset($_REQUEST['productId'])) {
					$grid = $p->GetDownloadsGrid($_REQUEST['productId']);
				} else {
					$grid = $p->GetDownloadsGrid(0, $_REQUEST['productHash']);
				}

				$tags[] = $this->MakeXMLTag('status', 1);
				$tags[] = $this->MakeXMLTag('message', GetLang('ProductDownloadSaved'), true);
				$tags[] = $this->MakeXMLTag('grid', $grid, true);

			} else {
				$tags[] = $this->MakeXMLTag('status', 0);
				$tags[] = $this->MakeXMLTag('message', $err, true);
			}

			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
			die();
		}

		/**
		 * Get the exchange rate of a currency
		 *
		 * Method will call the selected currency application based in the currency converter ID $cid and return the exchange rate based on the currency code $ccode.
		 *
		 * @access public
		 * @return null
		 */
		public function GetExchangeRate()
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('settings');

			if (!array_key_exists("cid", $_REQUEST)
				|| !GetModuleById("currency", $module, $_REQUEST['cid'])) {
				print "{'status':false, 'rate':null, 'message':'". GetLang("CurrencyProviderRequestUnavailable") . "'};";
				exit;
			}
			else if (!array_key_exists("ccode", $_REQUEST)) {
				print "{'status':false, 'rate':null, 'message':'". GetLang("ErrorEnterCurrencyCodeForConverter") . "'};";
				exit;
			}

			// Call Currency application and get the exchange rate
			if (($rate = $module->GetExchangeRateUsingBase($_REQUEST['ccode'])) === false) {
				$messages =$module->GetErrors();
				$message = implode(',', $messages);
				print "{'status':false, 'rate':null, 'message':'" . $message . "'};";
			}
			else {
				print "{'status':true, 'rate':'" . (string)$rate . "', 'message':'" . addslashes(sprintf(GetLang('CurrencyModuleSuccessMessage'), $rate)) . "'};";
			}

			exit;
		}

		/**
		 * Update the exchange rate of a currency
		 *
		 * Method will automatically update the exchange rate currency corresponding to the currency id $currencyid
		 *
		 * @access public
		 * @return null
		 */
		public function UpdateExchangeRate()
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('settings');

			$currModules = explode(",", GetConfig("CurrencyMethods"));

			if (!isset($_REQUEST['cid']) || !isset($_REQUEST['currencyid'])) {
				print "{'id': " . ((int) $_REQUEST['currencyid']) . ", 'status':1, 'newRate':null, 'seq': " . ((int) $_REQUEST['seq']) . "};";
				exit;
			}

			$module = null;
			GetModuleById("currency", $module, $_REQUEST['cid']);

			if ($module === null || $module === false) {
				print "{'id': " . ((int) $_REQUEST['currencyid']) . ", 'status':1, 'newRate':null, 'seq': " . ((int) $_REQUEST['seq']) . "};";
				exit;
			}

			$query = "SELECT *
			FROM [|PREFIX|]currencies
			WHERE currencyid = '" . $GLOBALS['ISC_CLASS_DB']->Quote($_REQUEST['currencyid'])."'";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

			if ($row == false) {
				print "{'id': " . ((int) $_REQUEST['currencyid']) . ", 'status':1, 'newRate':null, 'seq': " . ((int) $_REQUEST['seq']) . "};";
				exit;
			}

			$rate = $module->GetExchangeRateUsingBase($row['currencycode']);

			if ($rate === false) {
				$messages = $module->GetErrors();
				$message = $messages[0];
				if ($message == GetLang("CurrencyProviderRequestUnavailable")) {
					print "{'id': " . ((int) $_REQUEST['currencyid']) . ", 'status':1, 'newRate':null, 'seq': " . ((int) $_REQUEST['seq']) . "};";
				} else {
					print "{'id': " . ((int) $_REQUEST['currencyid']) . ", 'status':2, 'newRate':null, 'seq': " . ((int) $_REQUEST['seq']) . "};";
				}
			} else {
				$data = array();
				$data['currencyexchangerate'] = $rate;
				$data["currencylastupdated" ] = time();

				$GLOBALS['ISC_CLASS_DB']->UpdateQuery("currencies", $data, "currencyid='".$GLOBALS['ISC_CLASS_DB']->Quote((int)$_REQUEST['currencyid'])."'");

				$GLOBALS['ISC_CLASS_DATA_STORE']->UpdateCurrencies();

				print "{'id': " . ((int) $_REQUEST['currencyid']) . ", 'status':0, 'newRate':'" . (string)FormatPrice($rate, false, true, false, $row, false) . "', 'seq': " . ((int) $_REQUEST['seq']) . "};";
			}
			exit;
		}

		private function GetStateList()
		{
			$remote = GetClass('ISC_REMOTE');
			return $remote->GetStateList();
		}

		private function buildOrderFormFields($widgetData)
		{
			if (!is_array($widgetData)) {
				return '';
			}

			$html = '';

			foreach ($widgetData as $data) {
				$data['label'] = trim($data['label']);
				$data['label'] = isc_html_escape($data['label']);

				if (substr($data['label'], -1) !== ':' && substr($data['label'], -1) !== '?') {
					$data['label'] .= ':';
				}

				if (is_array($data['value'])) {
					$data['value'] = array_map('isc_html_escape', $data['value']);
					$data['value'] = implode('<br />', $data['value']);
				} else {
					$data['value'] = isc_html_escape($data['value']);
				}

				$GLOBALS['FormFieldLabel'] = isc_html_escape($data['label']);
				$GLOBALS['FormFieldValue'] = $data['value'];

				$html .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('OrderFormFields');
			}

			return $html;
		}
	}

	/**
	* GetCombinationText
	* Get all possible option combinations and return them as a string of arrays, such as #red#small#retro or #red#small#modern
	*
	* @param String $string The format to arrange combinations in
	* @param String $traits The array of combinations to iterate through
	* @param Int $i The position of the iteration
	* @return Void
	*/
	function GetCombinationText($string, $traits, $i=0)
	{
		$keys = array_keys($traits);

		if($i >= count($traits)) {
			$GLOBALS['variation_data'][] = trim($string);
		}
		else {
			foreach($traits[$keys[$i]] as $trait) {
				GetCombinationText("$string#$trait", $traits, $i + 1);
			}
		}
	}

	/**
	* GetCombinationIds
	* Get all possible option combinations and return them as an ID of arrays, such as #143#223#154 or #192#121#175
	*
	* @param String $string The format to arrange combinations in
	* @param String $traits The array of combinations to iterate through
	* @param Int $i The position of the iteration
	* @return Void
	*/
	function GetCombinationIds($string, $traits, $i=0)
	{
		$keys = array_keys($traits);

		if($i >= count($traits)) {
			$GLOBALS['variation_data'][] = trim($string);
		}
		else {
			foreach($traits[$keys[$i]] as $trait) {
				GetCombinationText("$string#$trait", $traits, $i + 1);
			}
		}
	}
?>
