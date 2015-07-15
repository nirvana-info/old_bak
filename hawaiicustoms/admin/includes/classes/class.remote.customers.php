<?php

	if (!defined('ISC_BASE_PATH')) {
		die();
	}

	require_once(ISC_BASE_PATH.'/lib/class.xml.php');

	class ISC_ADMIN_REMOTE_CUSTOMERS extends ISC_XML_PARSER
	{
		public function __construct()
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('customers');
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

			switch ($what) {
				case "getselectedstates":
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Customers) || $GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Add_Customer)) {
						$this->getSelectedStates();
					}
					exit;
					break;

				case "checkemailuniqueness":
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Customers) || $GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Add_Customer)) {
						$this->checkEmailUniqueness();
					}
					exit;
					break;
				case 'viewcustomernotes':
					$this->ViewCustomerNotes();
					break;
				case 'savecustomernotes':
					$this->SaveCustomerNotes();
					break;
				case 'viewordernotes':
					$this->ViewOrderNotes();
					break;
				case 'saveordernotes':
					$this->SaveOrderNotes();
					break;
				//zcs=>
				case 'viewphotonotes':
					$this->ViewPhotoNotes();
					break;
				case 'savephotonotes':
					$this->SavePhotoNotes();
					break;
				case 'getphotonotes':
					$this->GetPhotoNotes();
					break;
				//<=zcs
			}
		}

		private function SaveCustomerNotes()
		{
			if(!isset($_REQUEST['customerId'])) {
				exit;
			}

			$query = "
				SELECT customerid, custconfirstname, custconlastname
				FROM [|PREFIX|]customers
				WHERE customerid='".(int)$_REQUEST['customerId']."'
			";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$customer = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
			if(!isset($customer['customerid'])) {
				exit;
			}

			$updatedCustomer = array(
				'custnotes' => urldecode($_REQUEST['custnotes'])
			);

			if(!$GLOBALS['ISC_CLASS_DB']->UpdateQuery("customers", $updatedCustomer, "customerid='".(int)$_REQUEST['customerId']."'")) {
				exit;
			}

			$message = sprintf(GetLang('CustomerNotesSuccessMsg'), $customer['custconfirstname'].' '.$customer['custconlastname']);
			$tags[] = $this->MakeXMLTag('status', 1);
			$tags[] = $this->MakeXMLTag('message', $message, true);
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
			exit;
		}

		private function ViewCustomerNotes()
		{
			if(!isset($_REQUEST['customerId']) || ! isId($_REQUEST['customerId'])) {
				exit;
			}

			// Grab the notes
			$query = "
				SELECT custnotes
				FROM [|PREFIX|]customers
				WHERE customerid='".(int)$_REQUEST['customerId']."'
			";
			$GLOBALS['CustomerNotes'] = isc_html_escape($GLOBALS['ISC_CLASS_DB']->FetchOne($query));
			$GLOBALS['CustomerId'] = (int)$_REQUEST['customerId'];

			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("customers.notes.popup");
			$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
		}

		private function SaveOrderNotes()
		{
			if (!isset($_REQUEST['orderId'])) {
				exit;
			}

			$order = GetOrder($_REQUEST['orderId']);
			if (!isset($order['orderid'])) {
				exit;
			}

			$updatedOrder = array(
				'ordnotes' => urldecode($_REQUEST['ordnotes'])
			);

			if (!$GLOBALS['ISC_CLASS_DB']->UpdateQuery("orders", $updatedOrder, "orderid='".(int)$_REQUEST['orderId']."'")) {
				exit;
			}

			$message = sprintf(GetLang('OrderNotesSuccessMsg'), $order['orderid']);
			$tags[] = $this->MakeXMLTag('status', 1);
			$tags[] = $this->MakeXMLTag('message', $message, true);
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
			exit;
		}

		private function ViewOrderNotes()
		{
			if (!isset($_REQUEST['orderId']) || ! isId($_REQUEST['orderId'])) {
				exit;
			}

			// Load the order
			$order = GetOrder($_REQUEST['orderId']);
			if (!$order || ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() && $order['ordvendorid'] != $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId())) {
				exit;
			}

			$GLOBALS['OrderID'] = $order['orderid'];
			$GLOBALS['OrderNotes'] = isc_html_escape($order['ordnotes']);
			$GLOBALS['ThankYouID'] = 'CustomerStatus';

			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("orders.notes.popup");
			$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
		}
		
		//zcs=>-----------------------Photo Notes--------------------------
		private function ViewPhotoNotes()
		{
			if(!isset($_REQUEST['photoId']) || ! isId($_REQUEST['photoId'])) {
				exit;
			}

			// Grab the notes
			$query = "
				SELECT adminnote
				FROM [|PREFIX|]pic
				WHERE picid='".(int)$_REQUEST['photoId']."'
			";
			$GLOBALS['PhotoNotes'] = isc_html_escape($GLOBALS['ISC_CLASS_DB']->FetchOne($query));
			$GLOBALS['PhotoId'] = (int)$_REQUEST['photoId'];

			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("photos.notes.popup");
			$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
		}
		private function SavePhotoNotes()
		{
			if(!isset($_REQUEST['photoId'])) {
				exit;
			}

			$query = "
				SELECT picid, filename
				FROM [|PREFIX|]pic
				WHERE picid='".(int)$_REQUEST['photoId']."'
			";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$photo = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
			if(!isset($photo['picid'])) {
				exit;
			}
			
			//limit characters to 250 length
			if(mb_strlen($_REQUEST['photonotes']) > 250){
				$tags[] = $this->MakeXMLTag('status', 0);
				$tags[] = $this->MakeXMLTag('message', GetLang('PhotoExceededCharacter'), true);
				$this->SendXMLHeader();
				$this->SendXMLResponse($tags);
				exit;
			}
			
			$updatedPhoto = array(
				'adminnote' => urldecode($_REQUEST['photonotes'])
			);

			if(!$GLOBALS['ISC_CLASS_DB']->UpdateQuery("pic", $updatedPhoto, "picid='".(int)$_REQUEST['photoId']."'")) {
				exit;
			}

			$message = sprintf(GetLang('PhotoNotesSuccessMsg'), $photo['filename']);
			$tags[] = $this->MakeXMLTag('status', 1);
			$tags[] = $this->MakeXMLTag('message', $message, true);
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
			exit;
		}
		private function GetPhotoNotes()
		{
			if(!isset($_REQUEST['photoId']) || ! isId($_REQUEST['photoId'])) {
				exit;
			}

			// Grab the notes
			$query = "
				SELECT adminnote
				FROM [|PREFIX|]pic
				WHERE picid='".(int)$_REQUEST['photoId']."'
			";
			$PhotoNotes = isc_html_escape($GLOBALS['ISC_CLASS_DB']->FetchOne($query));
			$PhotoId = (int)$_REQUEST['photoId'];

			if($PhotoNotes != '' && $PhotoId > 0){
				$tags[] = $this->MakeXMLTag('status', 1);
				$tags[] = $this->MakeXMLTag('photoid', $PhotoId, true);
				$tags[] = $this->MakeXMLTag('notes', $PhotoNotes, true);
			}else{
				$tags[] = $this->MakeXMLTag('status', 0);
			}
			
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
			exit;
		}
		//<=zcs-----------------------------------------------------------------

		private function getSelectedStates()
		{
			if (!array_key_exists('countryId', $_POST) || !isId($_POST['countryId'])) {
				$tags[] = $this->MakeXMLTag('status', 0);
				$tags[] = $this->MakeXMLTag('ismultiple', 0);
				$tags[] = $this->MakeXMLTag('message', GetLang('CustomerAddressEditInvalid'));
				$this->SendXMLHeader();
				$this->SendXMLResponse($tags);
				exit;
			}

			$html = '';
			$result = $GLOBALS['ISC_CLASS_DB']->Query("SELECT * FROM [|PREFIX|]country_states WHERE statecountry = " . (int)$_POST['countryId']);
			while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$html .= '<option value="' . $row['stateid'] . '">' . isc_html_escape($row['statename']) . '</option>';
			}

			if ($html == '') {
				$ismultiple = false;
			} else {
				$html = '<option value="0">' . GetLang('ChooseCustState') . '</option>' . $html;
				$ismultiple = true;
			}

			$tags[] = $this->MakeXMLTag('status', 1);
			$tags[] = $this->MakeXMLTag('ismultiple', $ismultiple);
			$tags[] = $this->MakeXMLTag('message', $html, true);
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
		}

		private function checkEmailUniqueness()
		{
			if (!array_key_exists('email', $_POST)) {
				$tags[] = $this->MakeXMLTag('result', 0);
				$tags[] = $this->MakeXMLTag('message', MessageBox(GetLang('CustomerEmailUniqueCheckErrorMissing'), MSG_ERROR), true);
				$this->SendXMLHeader();
				$this->SendXMLResponse($tags);
				exit;
			}

			if (strpos($_POST['email'], '@') === false || strpos($_POST['email'], '.') === false) {
				$tags[] = $this->MakeXMLTag('result', 0);
				$tags[] = $this->MakeXMLTag('message', MessageBox(GetLang('CustomerEmailInvalue'), MSG_ERROR), true);
				$this->SendXMLHeader();
				$this->SendXMLResponse($tags);
				exit;
			}

			$query = "SELECT * FROM [|PREFIX|]customers WHERE custconemail = '" . $GLOBALS['ISC_CLASS_DB']->Quote($_POST['email']) . "'";
			if (array_key_exists('customerId', $_POST) && isId($_POST['customerId'])) {
				$query .= " AND customerid != " . (int)$_POST['customerId'];
			}

			if ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($GLOBALS['ISC_CLASS_DB']->Query($query))) {
				$tags[] = $this->MakeXMLTag('result', 0);
				$tags[] = $this->MakeXMLTag('message', MessageBox(GetLang('CustomerEmailUniqueCheckFailed'), MSG_ERROR), true);
				$this->SendXMLHeader();
				$this->SendXMLResponse($tags);
				exit;

			} else {
				$tags[] = $this->MakeXMLTag('result', 1);
				$tags[] = $this->MakeXMLTag('message', MessageBox(GetLang('CustomerEmailUniqueCheckSuccess'), MSG_SUCCESS), true);
				$this->SendXMLHeader();
				$this->SendXMLResponse($tags);
				exit;
			}
		}
	}
?>