<?php

	class ISC_ACCOUNT
	{
		public function HandlePage()
		{
			$action = "";



			if (count($GLOBALS['PathInfo']) > 0 ){
				if (isset ($GLOBALS['PathInfo'][1])) {
					$_REQUEST['action'] = $GLOBALS['PathInfo'][1];
				}
				else
				{
					$_REQUEST['action'] = $GLOBALS['PathInfo'][0];
				}
			}
			if (isset($_REQUEST['action'])) {
				$action = isc_strtolower($_REQUEST['action']);
			}

			if (isset($_GET['from'])) {
				$_GET['from'] = str_replace(array("\n", "\r", "\r\n", "\t"), "", $_GET['from']);
				$_SESSION['LOGIN_REDIR'] = sprintf("%s/%s", $GLOBALS['ShopPath'], urldecode($_GET['from']));
			}

			if ($action === "download_item") {
				$this->DownloadOrderItem();
				return;
			}

			// Are they signed in?
			if (CustomerIsSignedIn()) {
				$GLOBALS['ISC_CLASS_CUSTOMER'] = GetClass('ISC_CUSTOMER');
				$customer = $GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerDataByToken();
				if ($customer['custstorecredit'] == 0) {
					$GLOBALS['HidePanels'][] = "SideAccountStoreCredit";
				}

				CheckReferrer(); // checking and assigning the back to search link

				switch ($action) {
					case "send_message": {
						$this->SendMessage();
						break;
					}
					case "save_new_shipping_address": {
						$this->SaveNewShippingAddress();
						break;
					}
					case "add_shipping_address": {
						$this->AddShippingAddress();
						break;
					}
					case "edit_shipping_address": {
						$this->EditShippingAddress();
						break;
					}
					case "update_new_shipping_address": {
						$this->SaveEditedShippingAddress();
						break;
					}
					case "delete_shipping_address": {
						$this->DeleteShippingAddress();
						break;
					}
					case "inbox": {
						$this->Inbox();
						break;
					}
					case "order_status": {
						$this->OrderStatus();
						break;
					}
					case "view_orders": {
						$this->ViewOrders();
						break;
					}
					case "view_order": {
						$this->ViewOrderDetails();
						break;
					}
					case "download_item": {
						$this->DownloadOrderItem();
						break;
					}
					case "print_invoice": {
						$this->PrintInvoice();
						break;
					}
					case "address_book": {
						$this->AddressBook();
						break;
					}
					case "account_details": {
						$this->EditAccount();
						break;
					}
					case "update_account": {
						$this->SaveAccountDetails();
						break;
					}
					case "recent_items": {
						$this->ShowRecentItems();
						break;
					}
					case "new_return": {
						$this->NewReturn();
						break;
					}
					case "save_new_return": {
						$this->SaveNewReturn();
						break;
					}
					case "view_returns": {
						$this->ShowReturns();
						break;
					}
					case "reorder": {
						$this->DoReorder();
						break;
					}case "uploadimages":{
						$this->UploadImages();
						break;
					}case "uploadimage":{
						$this->UploadImage();
						break;
					}
					case "showimage":{
						$this->ShowImage();
						break;
					}case "sendimageuploaderemail":{
						$this->sendImageUploaderEmail();
						break;
					}
					case "delete_image":{
						$this->DelImage();
						break;
					}
					default: {
						$this->MyAccountPage();
					}
				}
			}
			else {
				// Naughty naughty, you need to sign in to be here
				$this_page = urlencode(sprintf("account.php?action=%s", $action));
				ob_end_clean();

				if ($GLOBALS['EnableSEOUrls'] == 1) {
					
					header(sprintf("Location:%s/%s/%s", GetConfig('ShopPathNormal'), "login","account"));
				} else {
					header(sprintf("Location: %s/login.php?from=%s", $GLOBALS['ShopPath'], $this_page));
				}


				//header(sprintf("Location: %s/login.php?from=%s", $GLOBALS['ShopPath'], $this_page));
				die();
			}
		}

		/**
		*	Get all returns for this customer. If $OnlyCompletedReturns is true then we will only
		*	return orders whose status is completed/denied
		*/
		private function GetCustomerReturns(&$Result, $OnlyCompletedReturns = false)
		{

			if ($OnlyCompletedReturns) {
				$complete_filter = "and (retstatus='4' or retstatus='5')";
			} else {
				$complete_filter = "";
			}

			$query = sprintf("
				SELECT r.*, p.prodname AS currentprodname
				FROM [|PREFIX|]returns r
				LEFT JOIN [|PREFIX|]products p ON (p.productid=r.retprodid)
				WHERE retcustomerid='%d' %s
				ORDER BY retdaterequested DESC",
				$GLOBALS['ISC_CLASS_DB']->Quote($GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerId()), $complete_filter);
			$Result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		}

		/**
		* Show the returns/refunds a user has placed witht he store
		*/
		private function ShowReturns()
		{
			if (!gzte11(ISC_LARGEPRINT)) {
				ob_end_clean();
				header("Location: " . $GLOBALS['ShopPath']);
				die();
			}

			if (GetConfig('EnableReturns') == 0) {
				// Bad details
				ob_end_clean();
				header(sprintf("location:%s/account.php", $GLOBALS['ShopPath']));
				die();
			}

			$GLOBALS['SNIPPETS']['AccountReturns'] = "";
			$GLOBALS['AccountReturnItemList'] = "";

			$result = false;
			$this->GetCustomerReturns($result);

			// Are there any orders for this customer
			while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$GLOBALS['DateRequested'] = isc_date(GetConfig('DisplayDateFormat'), $row['retdaterequested']);
				$GLOBALS['ReturnId'] = $row['returnid'];

				switch ($row['retstatus']) {
					case 2:
						$status = "ReturnStatusReceived";
						break;
					case 3:
						$status = "ReturnStatusAuthorized";
						break;
					case 4:
						$status = "ReturnStatusRepaired";
						break;
					case 5:
						$status = "ReturnStatusRefunded";
						break;
					case 6:
						$status = 'ReturnStatusRejected';
						break;
					case 7:
						$status = 'ReturnStatusCancelled';
						break;
					default:
						$status = "ReturnStatusPending";
						break;
				}
				$GLOBALS['ReturnStatus'] = GetLang($status);

				if ($row['currentprodname']) {
					$GLOBALS['ReturnedProduct'] = "<a href='".ProdLink($row['currentprodname'])."'>".isc_html_escape($row['retprodname'])."</a>";
				}
				else {
					$GLOBALS['ReturnedProduct'] = isc_html_escape($row['retprodname']);
				}

				$GLOBALS['ReturnedProductOptions'] = '';
				if($row['retprodoptions'] != '') {
					$options = @unserialize($row['retprodoptions']);
					if(!empty($options)) {
						$GLOBALS['ReturnedProductOptions'] = " <small>(";
						$comma = '';
						foreach($options as $name => $value) {
							$GLOBALS['ReturnedProductOptions'] .= $comma.isc_html_escape($name).": ".isc_html_escape($value);
							$comma = ', ';
						}
						$GLOBALS['ReturnedProductOptions'] .= ")</small>";
					}
				}

				if ($row['retprodqty'] > 1) {
					$GLOBALS['ReturnedQuantity'] = $row['retprodqty'] . " x ";
				}
				else {
					$GLOBALS['ReturnedQuantity'] = "";
				}

				$GLOBALS['ReturnReason'] = isc_html_escape($row['retreason']);
				if ($row['retaction'] != "") {
					$GLOBALS['ReturnAction'] = isc_html_escape($row['retaction']);
					$GLOBALS['HideReturnAction'] = '';
				}
				else {
					$GLOBALS['ReturnAction'] = '';
					$GLOBALS['HideReturnAction'] = 'none';
				}

				$GLOBALS['ReturnComments'] = nl2br($row['retcomment']);

				if ($GLOBALS['ReturnComments'] == '') {
					$GLOBALS['HideReturnComment'] = 'none';
				}
				else {
					$GLOBALS['HideReturnComment'] = '';
				}

				$GLOBALS['SNIPPETS']['AccountReturns'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("AccountReturnItem");
				$GLOBALS['AccountReturnItemList'] = "";
			}

			if ($GLOBALS['SNIPPETS']['AccountReturns'] != "") {
				$GLOBALS['HideNoReturnsMessage'] = "none";
			}
			else {
				$GLOBALS['HideReturnsList'] = "none";
			}

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetPageTitle(sprintf("%s - %s", GetConfig('StoreName'), GetLang('YourReturns')));
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("account_returns");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}

		private function NewReturn($errors="")
		{
			if (!gzte11(ISC_LARGEPRINT)) {
				ob_end_clean();
				header("Location: " . $GLOBALS['ShopPath']);
				die();
			}

			if (!isset($_REQUEST['order_id']) || GetConfig('EnableReturns') == 0) {
				// Bad details
				ob_end_clean();
				header(sprintf("location:%s/account.php", $GLOBALS['ShopPath']));
				die();
			}

			// Fetch the order
			$query = sprintf("SELECT * FROM [|PREFIX|]orders WHERE orderid='%d' AND (ordstatus=2 OR ordstatus=10) AND ordcustid=%d", $GLOBALS['ISC_CLASS_DB']->Quote((int)$_REQUEST['order_id']), $GLOBALS['ISC_CLASS_DB']->Quote($GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerId()));
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
			$order = $row;

			$GLOBALS['OrderId'] = $row['orderid'];
			$GLOBALS['ISC_LANG']['SubmitNewReturn'] = sprintf(GetLang('SubmitNewReturn'), $row['orderid']);
			$GLOBALS['ISC_LANG']['OrderId'] = sprintf(GetLang('OrderId'), $row['orderid']);

			if (!$row['orderid']) {
				// Bad details
				ob_end_clean();
				header(sprintf("location:%s/account.php", $GLOBALS['ShopPath']));
				die();
			}
			$GLOBALS['SNIPPETS']['ReturnProducts'] = '';
			$count = 0;

			$return_products = array();
			$products = array();

			// Fetch the list of items in this order and the number that have already been returned
			$query = "
				SELECT COUNT(r.returnid) AS numreturned, ordprodqty, p. *
				FROM [|PREFIX|]order_products p
				LEFT JOIN [|PREFIX|]returns r ON (r.retorderid=p.orderorderid AND r.retprodid=p.ordprodid AND r.retprodvariationid=p.ordprodvariationid)
				WHERE p.orderorderid='".$order['orderid']."'
				GROUP BY p.ordprodid, p.ordprodvariationid, r.retprodid
			";
			// Fetch a list of items in this order that haven't already got a pending return request
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			while ($product = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$products[] = $product;
			}

			foreach ($products as $row) {
				$row['returnable'] = $row['ordprodqty'] - $row['numreturned'];
				if ($row['returnable'] <= 0) {
					continue;
				}
				if ($count++ % 2 != 0) {
					$GLOBALS['ItemClass'] = "OrderItem2";
				} else {
					$GLOBALS['ItemClass'] = "OrderItem1";
				}

				$GLOBALS['OrderProductId'] = $row['orderprodid'];
				$GLOBALS['ProductName'] = isc_html_escape($row['ordprodname']);
				$GLOBALS['ProductId'] = $row['ordprodid'];
				$GLOBALS['ProductPrice'] = CurrencyConvertFormatPrice($row['ordprodcost'], $order['ordcurrencyid'], $order['ordcurrencyexchangerate']);

				// If there were any options with the product, we need to show them too
				$GLOBALS['ProductOptions'] = '';
				if($row['ordprodoptions'] != '') {
					$options = @unserialize($row['ordprodoptions']);
					if(!empty($options)) {
						$GLOBALS['ProductOptions'] = "<br /><small>(";
						$comma = '';
						foreach($options as $name => $value) {
							$GLOBALS['ProductOptions'] .= $comma.isc_html_escape($name).": ".isc_html_escape($value);
							$comma = ', ';
						}
						$GLOBALS['ProductOptions'] .= ")</small>";
					}
				}

				// Remaining quantity that can be returned
				$GLOBALS['ProductQty'] = $row['returnable'];

				$GLOBALS['ProductQtySelect'] = '';
				for ($i = 0; $i <= $GLOBALS['ProductQty']; ++$i) {
					$GLOBALS['ProductQtySelect'] .= sprintf("<option value='%s'>%s</option>", $i, $i);
				}

				$GLOBALS['SNIPPETS']['ReturnProducts'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("AccountNewReturnItem");
			}

			$GLOBALS['HideReturnForm'] = "";
			if (!$GLOBALS['SNIPPETS']['ReturnProducts']) {
				if (!$errors) {
					$errors = GetLang('ReturnNoItems');
				}
				$GLOBALS['HideReturnForm'] = "none";
			}

			$GLOBALS['HideErrorMessage'] = 'none';
			if (is_array($errors)) {
				$errors = implode("<br />", $errors);
			}
			if ($errors != "") {
				$GLOBALS['HideErrorMessage'] = '';
				$GLOBALS['ErrorMessage'] = $errors;
			}

			// Generate a list of return reasons
			$GLOBALS['ReturnReasonsList'] = '';
			if (is_array(GetConfig('ReturnReasons'))) {
				foreach (GetConfig('ReturnReasons') as $reason) {
					$GLOBALS['ReturnReasonsList'] .= sprintf("<option value='%s'>%s</option>", $reason, $reason);
				}
			}

			// Generate a list of return actions if we have any
			$GLOBALS['ReturnActionsList'] = '';
			if (is_array(GetConfig('ReturnActions'))) {
				foreach (GetConfig('ReturnActions') as $action) {
					$GLOBALS['ReturnActionsList'] .= sprintf("<option value='%s'>%s</option>", $action, $action);
				}
			}

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetPageTitle(sprintf("%s - %s", GetConfig('StoreName'), GetLang('NewReturn')));
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("account_new_return");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}

		private function SaveNewReturn()
		{
			if (!gzte11(ISC_LARGEPRINT)) {
				ob_end_clean();
				header("Location: " . $GLOBALS['ShopPath']);
				die();
			}

			if (!isset($_REQUEST['order_id']) || GetConfig('EnableReturns') == 0) {
				// Bad details
				ob_end_clean();
				header(sprintf("location:%s/account.php", $GLOBALS['ShopPath']));
				die();
			}

			// Fetch the order
			$query = sprintf("SELECT * FROM [|PREFIX|]orders WHERE orderid='%d' AND (ordstatus=2 OR ordstatus=10) AND ordcustid=%d", $GLOBALS['ISC_CLASS_DB']->Quote((int)$_REQUEST['order_id']), $GLOBALS['ISC_CLASS_DB']->Quote($GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerId()));
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
			$order = $row;

			if (!$row['orderid']) {
				// Bad details
				ob_end_clean();
				header(sprintf("location:%s/account.php", $GLOBALS['ShopPath']));
				die();
			}

			$return_products = array();

			if(isset($_POST['return_qty'])) {
				$order_product_ids = '';
				foreach($_POST['return_qty'] as $orderprodid => $qty) {
					if($qty <= 0) {
						continue;
					}
					if($order_product_ids != '') {
						$order_product_ids .= ",";
					}
					$order_product_ids .= (int)$orderprodid;
				}

				// Fetch the list of items in this order and the number that have already been returned
				$query = "
					SELECT COUNT(r.returnid) AS numreturned, ordprodqty, p. *
					FROM [|PREFIX|]order_products p
					LEFT JOIN [|PREFIX|]returns r ON (r.retorderid=p.orderorderid AND r.retprodid=p.ordprodid AND r.retprodvariationid=p.ordprodvariationid)
					WHERE p.orderorderid='".$order['orderid']."' AND p.orderprodid IN (".$order_product_ids.")
					GROUP BY p.ordprodid, p.ordprodvariationid, r.retprodid
				";
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				while ($product = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					$returnable = $product['ordprodqty'] - $product['numreturned'];
					if($returnable <= 0 || $_POST['return_qty'][$product['orderprodid']] > $returnable) {
						// User is trying to return too many
						unset($_POST['return_qty']);
						continue;
					}
					$return_products[] = array(
						"retprodid" => $product['ordprodid'],
						"retprodname" => $product['ordprodname'],
						"retprodcost" => $product['ordprodcost'],
						"retprodqty" => $_POST['return_qty'][$product['orderprodid']],
						"retordprodid" => $product['orderprodid'],
						"retprodvariationid" => $product['ordprodvariationid'],
						"retprodoptions" => $product['ordprodoptions']
					);
				}
			}

			$errors = array();

			if (empty($return_products)) {
				$errors[] = GetLang('SelectOneMoreItemsReturn');
			}

			if (!isset($_POST['return_reason']) && $_POST['return_reason'] != "") {
				$errors[] = GetLang('SelectReturnReason');
			}

			if (!isset($_POST['return_action'])) {
				$_POST['return_action'] = '';
			}

			if (!isset($_POST['return_comments'])) {
				$_POST['return_comments'] = '';
			}

			if (is_array($errors) && !empty($errors)) {
				$this->NewReturn($errors);
			}
			// Everything looks good, so create the return
			else {
				$GLOBALS['ISC_CLASS_DB']->Query("START TRANSACTION");

				foreach ($return_products as $product) {
					$new_return = array(
						"retorderid" => (int)$_POST['order_id'],
						"retcustomerid" => (int)$GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerId(),
						"retprodid" => (int)$product['retprodid'],
						"retprodname" => $product['retprodname'],
						"retprodcost" => $product['retprodcost'],
						"retprodqty" => $product['retprodqty'],
						"retstatus" => 1,
						"retreason" => $_POST['return_reason'],
						"retaction" => $_POST['return_action'],
						"retdaterequested" => time(),
						"retcomment" => $_POST['return_comments'],
						"retuserid" => 0,
						"retreceivedcredit" => 0,
						"retordprodid" => $product['retordprodid'],
						"retstaffnotes" => "",
						"retprodvariationid" => $product['retprodvariationid'],
						"retprodoptions" => $product['retprodoptions']
					);
					$return_id = $GLOBALS['ISC_CLASS_DB']->InsertQuery("returns", $new_return);
				}

				// Successfully created the returns
				if ($GLOBALS['ISC_CLASS_DB']->GetErrorMsg() == "") {
					$GLOBALS['ISC_CLASS_DB']->Query("COMMIT");

					$GLOBALS['OrderId'] = $order['orderid'];
					$GLOBALS['ISC_LANG']['SubmitNewReturn'] = sprintf(GetLang('SubmitNewReturn'), $order['orderid']);
					$GLOBALS['ISC_LANG']['OrderId'] = sprintf(GetLang('OrderId'), $order['orderid']);

					$GLOBALS['ReturnInstructions'] = nl2br(GetConfig('ReturnInstructions'));

					if ($GLOBALS['ReturnInstructions'] == "") {
						$GLOBALS['HideReturnInstructions'] = "none";
					}

					$new_return['returnid'] = $return_id;

					require_once APP_ROOT."/admin/includes/classes/class.returns.php";
					$GLOBALS['ISC_CLASS_ADMIN_RETURNS'] = GetClass('ISC_ADMIN_RETURNS');

					// Do we need to notify the store owner?
					if (GetConfig('EmailOwnerOnReturn')) {
						$GLOBALS['ISC_CLASS_ADMIN_RETURNS']->SendNewReturnNotification($new_return, $return_products);
					}

					// Sending the customer a confirmation?
					if (GetConfig('SendReturnConfirmation')) {
						$GLOBALS['ISC_CLASS_ADMIN_RETURNS']->SendReturnConfirmation($new_return, $return_products);
					}

					$GLOBALS['ISC_LANG']['ReturnSubmittedInfo'] = sprintf(GetLang('ReturnSubmittedInfo'), $GLOBALS['StoreName']);

					$GLOBALS['ISC_CLASS_TEMPLATE']->SetPageTitle(sprintf("%s - %s", GetConfig('StoreName'), GetLang('NewReturn')));
					$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("account_saved_return");
					$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
				}

				// Failed to insert
				else {
					$errors[] = GetLang('ErrorSavingReturn');
					$this->NewReturn($errors);
					$GLOBALS['ISC_CLASS_DB']->Query("ROLLBACK");
				}
			}
		}


		/**
		*	Save the changes made to an existing shipping address
		*/
		private function SaveEditedShippingAddress()
		{
			if (isset($_POST['shipid'])) {

				$entity = new ISC_ENTITY_SHIPPING();
				$shippingData = $entity->get($_POST['shipid']);
				$fields = $GLOBALS['ISC_CLASS_FORM']->getFormFields(FORMFIELDS_FORM_ADDRESS, true);

				/**
				 * Validate the field input
				 */
				$errmsg = '';
				if (!$this->validateFieldData($fields, $errmsg)) {
					$_GET['address_id'] = $_POST['shipid'];
					return $this->EditShippingAddress($errmsg, MSG_ERROR);
				}

				$ShippingAddress = $this->parseFieldData($fields, $shippingData['shipformsessionid']);

				// Update the existing shipping address
				$ShippingAddress['shipid'] = (int)$_POST['shipid'];

				if ($entity->edit($ShippingAddress)) {
					if (isset($_SESSION['LOGIN_REDIR'])) {
						// Take them to the page they wanted
						$page = $_SESSION['LOGIN_REDIR'];
						unset($_SESSION['LOGIN_REDIR']);
						header(sprintf("Location: %s", $page));
					}
					else {
						// Take them to the my account page
						header(sprintf("Location: %s/account.php", $GLOBALS['ShopPath']));
					}
				}
				else {
					// Database error
					ob_end_clean();
					header(sprintf("location:%s/account.php", $GLOBALS['ShopPath']));
					die();
				}
			}
			else {
				// Bad details
				ob_end_clean();
				header(sprintf("location:%s/account.php", $GLOBALS['ShopPath']));
				die();
			}
		}

		/**
		*	Edit an existing shipping address
		*/
		private function EditShippingAddress($MsgDesc = "", $MsgStatus = "")
		{
			if (isset($_GET['address_id'])) {

				$GLOBALS['HideAddShippingAddressMessage'] = 'none';
				if ($MsgDesc !== '') {
					$GLOBALS['HideAddShippingAddressMessage'] = '';
					$GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
				}

				/**
				 * Grab from the request if we have message
				 */
				if ($MsgDesc !== '') {
					$GLOBALS['ShipCustomFields'] = $this->buildFieldData();
				} else {
					$GLOBALS['ShipCustomFields'] = $this->buildFieldData($_GET['address_id']);
				}

				if ($GLOBALS['ShipCustomFields'] !== '') {
					$GLOBALS['ShipId'] = (int)$_GET['address_id'];
					$GLOBALS['AddressFormFieldID'] = FORMFIELDS_FORM_ADDRESS;
					$GLOBALS['ShippingAddressFormAction'] = "update_new_shipping_address";
					$GLOBALS['ShippingAddressFormTitle'] = GetLang('EditShippingAddress');
					$GLOBALS['ShippingAddressFormIntro'] = GetLang('EditShippingAddressIntro');

					/**
					 * Load up any form field JS event data and any validation lang variables
					 */
					$GLOBALS['FormFieldRequiredJS'] = $GLOBALS['ISC_CLASS_FORM']->buildRequiredJS();

					$GLOBALS['ISC_CLASS_TEMPLATE']->SetPageTitle(GetConfig('StoreName') . " - " . GetLang('EditShippingAddress'));
					$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("shippingaddressform");
					$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
				}
				else {
					// Bad details or they don't own the shipping address
					ob_end_clean();
					header(sprintf("location:%s/account.php", $GLOBALS['ShopPath']));
					die();
				}
			}
			else {
				// Bad details
				ob_end_clean();
				header(sprintf("location:%s/account.php", $GLOBALS['ShopPath']));
				die();
			}
		}

		/**
		*	Add a new shipping address to the customer's account
		*/
		private function AddShippingAddress($MsgDesc = "", $MsgStatus = "")
		{
			$GLOBALS['HideAddShippingAddressMessage'] = 'none';
			if ($MsgDesc !== '') {
				$GLOBALS['HideAddShippingAddressMessage'] = '';
				$GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
			}

			$GLOBALS['ShipCustomFields'] = $this->buildFieldData();
			$GLOBALS['AddressFormFieldID'] = FORMFIELDS_FORM_ADDRESS;
			$GLOBALS['ShippingAddressFormAction'] = "save_new_shipping_address";
			$GLOBALS['ShippingAddressFormTitle'] = GetLang('AddShippingAddress');
			$GLOBALS['ShippingAddressFormIntro'] = GetLang('AddShippingAddressIntro');

			/**
			 * Load up any form field JS event data and any validation lang variables
			 */
			$GLOBALS['FormFieldRequiredJS'] = $GLOBALS['ISC_CLASS_FORM']->buildRequiredJS();

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetPageTitle(GetConfig('StoreName') . " - " . GetLang('AddShippingAddress'));
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("shippingaddressform");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}

		private function SaveNewShippingAddress()
		{
			$entity = new ISC_ENTITY_SHIPPING();
			$shippingData = $entity->get($_POST['shipid']);
			$fields = $GLOBALS['ISC_CLASS_FORM']->getFormFields(FORMFIELDS_FORM_ADDRESS, true);

			/**
			 * Validate the field input
			 */
			$errmsg = '';
			if (!$this->validateFieldData($fields, $errmsg)) {
				return $this->AddShippingAddress($errmsg, MSG_ERROR);
			}

			$ShippingAddress = $this->parseFieldData($fields);

			if (isset($ShippingAddress['shipfirstname']) && isset($ShippingAddress['shipaddress1'])) {
				$entity = new ISC_ENTITY_SHIPPING();
				if (isId($shippingid = $entity->add($ShippingAddress))) {
					if (isset($_SESSION['LOGIN_REDIR'])) {
						// Take them to the page they wanted
						$page = $_SESSION['LOGIN_REDIR'];
						unset($_SESSION['LOGIN_REDIR']);
						header(sprintf("Location: %s", $page));
					}
					else {
						// Take them to the my account page
						header(sprintf("Location: %s/account.php", $GLOBALS['ShopPath']));
					}
				}
				else {
					// Database error
					ob_end_clean();
					header(sprintf("location:%s/%s", $GLOBALS['ShopPath'], 'account.php?action=add_shipping_address'));
					die();
				}
			}
			else {
				// Bad details
				ob_end_clean();
				header(sprintf("location:%s/%s", $GLOBALS['ShopPath'], 'account.php?action=add_shipping_address'));
				die();
			}
		}

		/**
		*	Remove a shipping address from the shipping_addresses table
		*/
		private function DeleteShippingAddress()
		{
			if (isset($_GET['address_id'])) {

				$entity = new ISC_ENTITY_SHIPPING();
				if ($entity->delete($_GET['address_id'], $GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerId())) {
					if (isset($_SESSION['LOGIN_REDIR'])) {
						// Take them to the page they wanted
						$page = $_SESSION['LOGIN_REDIR'];
						unset($_SESSION['LOGIN_REDIR']);
						header(sprintf("Location: %s", $page));
					}
					else {
						// Take them to the my account page
						header(sprintf("Location: %s/account.php", $GLOBALS['ShopPath']));
					}
				}
				else {
					// Database error
					ob_end_clean();
					header(sprintf("location:%s/account.php", $GLOBALS['ShopPath']));
					die();
				}
			}
			else {
				// Bad details
				ob_end_clean();
				header(sprintf("location:%s/account.php", $GLOBALS['ShopPath']));
				die();
			}
		}

		/**
		*	Get the shipping address details for the selected record.
		*	Returns an array on success, false on failure.
		*/
		public function GetShippingAddress($addressId, $customerId=null)
		{
			static $shippingAddresses;

			if(isset($shippingAddresses[$addressId])) {
				return $shippingAddresses[$addressId];
			}

			$where = '';
			// Otherwise, we need to fetch it from the database
			if(!is_null($customerId)) {
				$where = " AND shipcustomerid='".(int)$customerId."'";
			}

			$query = "SELECT * FROM [|PREFIX|]shipping_addresses WHERE shipid='".(int)$addressId."' ".$where;
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$shippingAddresses[$addressId] = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
			return $shippingAddresses[$addressId];
		}

		/**
		 * Format/build a shipping address based on the passed aray of address details.
		 */
		public function FormatShippingAddress($address)
		{
			if(isset($address['shipid'])) {
				$GLOBALS['ShippingAddressId'] = $address['shipid'];
			}
			$GLOBALS['ShipFullName'] = isc_html_escape($address['shipfirstname'].' '.$address['shiplastname']);

			$GLOBALS['ShipCompany'] = '';
			if($address['shipcompany']) {
				$GLOBALS['ShipCompany'] = '<br />'.isc_html_escape($address['shipcompany']);
			}

			$GLOBALS['ShipAddressLine1'] = isc_html_escape($address['shipaddress1']);

			if($address['shipaddress2'] != "") {
				$GLOBALS['ShipAddressLine2'] = isc_html_escape($address['shipaddress2']);
			} else {
				$GLOBALS['ShipAddressLine2'] = '';
			}

			$GLOBALS['ShipSuburb'] = isc_html_escape($address['shipcity']);
			$GLOBALS['ShipState'] = isc_html_escape($address['shipstate']);
			$GLOBALS['ShipZip'] = isc_html_escape($address['shipzip']);
			$GLOBALS['ShipCountry'] = isc_html_escape($address['shipcountry']);

			if (isset($address['shipphone']) && $address['shipphone'] != "") {
				$GLOBALS['ShipPhone'] = isc_html_escape(sprintf("%s: %s", GetLang('Phone'), $address['shipphone']));
			}
			else {
				$GLOBALS['ShipPhone'] = "";
			}

			$addressText = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("AddressLabel");
			return $addressText;
		}

		/**
		*	Get an address from the database and return it as a formatted address
		*/
		public function GetAndFormatShippingAddressById($AddressId)
		{
			$address_text = "";
			$customer_id = $GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerId();

			$row = $this->GetShippingAddress($AddressId, $customer_id);
			return $this->FormatShippingAddress($row);
		}

		/**
		*	Get an address from the database and return it as an unformatted address
		*/
		public function GetUnformattedShippingAddressById($AddressId)
		{
			$address_text = "";
			$customer_id = $GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerId();
			$query = sprintf("select * from [|PREFIX|]shipping_addresses where shipid='%d' and shipcustomerid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($AddressId), $GLOBALS['ISC_CLASS_DB']->Quote($customer_id));
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			if ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {

				$GLOBALS['ShippingAddressId'] = $row['shipid'];
				$GLOBALS['ShipFullName'] = isc_html_escape($row['shipfirstname'].' '.$row['shiplastname']);

				$GLOBALS['ShipCompany'] = '';
				if($row['shipcompany']) {
					$GLOBALS['ShipCompany'] = "\n".isc_html_escape($row['shipcompany']);
				}

				$GLOBALS['ShipAddressLine1'] = isc_html_escape($row['shipaddress1']);

				if($row['shipaddress2'] != "") {
					$GLOBALS['ShipAddressLine2'] = isc_html_escape($row['shipaddress2']);
				} else {
					$GLOBALS['ShipAddressLine2'] = '';
				}

				$GLOBALS['ShipSuburb'] = isc_html_escape($row['shipcity']);
				$GLOBALS['ShipState'] = isc_html_escape($row['shipstate']);
				$GLOBALS['ShipZip'] = isc_html_escape($row['shipzip']);
				$GLOBALS['ShipCountry'] = isc_html_escape($row['shipcountry']);

				$address_text = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("UnformattedAddressLabel");
			}

			return $address_text;
		}

		/**
		*	Get an address from the database and return it as an unformatted address
		*/
		public function GetZipForShippingAddressById($AddressId)
		{
			$zip = "";
			$GLOBALS['ISC_CLASS_CUSTOMER'] = GetClass('ISC_CUSTOMER');
			$customer_id = $GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerId();
			$query = sprintf("select shipzip from [|PREFIX|]shipping_addresses where shipid='%d' and shipcustomerid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($AddressId), $GLOBALS['ISC_CLASS_DB']->Quote($customer_id));
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			if ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$zip = $row['shipzip'];
			}

			return $zip;
		}

		public function MyAccountPage()
		{
			$GLOBALS['ISC_LANG']['ViewMessagesDescription'] = sprintf(GetLang('ViewMessagesDescription'), $GLOBALS['StoreName']);
			$GLOBALS['ISC_LANG']['ViewOrderStatusDescription'] = sprintf(GetLang('ViewOrderStatusDescription'), $GLOBALS['StoreName']);
			$GLOBALS['ISC_LANG']['CompletedOrdersDescription'] = sprintf(GetLang('CompletedOrdersDescription'), $GLOBALS['StoreName']);
			$GLOBALS['ISC_LANG']['ReturnRequestsDescription'] = sprintf(GetLang('ReturnRequestsDescription'), $GLOBALS['StoreName']);
			$GLOBALS['ISC_LANG']['AddressBookDescription'] = sprintf(GetLang('AddressBookDescription'), $GLOBALS['StoreName']);
			$GLOBALS['ISC_LANG']['WishListDescription'] = sprintf(GetLang('WishListDescription'), $GLOBALS['StoreName']);
			$GLOBALS['ISC_LANG']['AccountDetailsDescription'] = sprintf(GetLang('AccountDetailsDescription'), $GLOBALS['StoreName']);
			$GLOBALS['ISC_LANG']['RecentlyViewedItemsDescription'] = sprintf(GetLang('RecentlyViewedItemsDescription'), $GLOBALS['StoreName']);

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetPageTitle(sprintf("%s - %s", GetConfig('StoreName'), GetLang('YourAccount')));
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("account");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}

		/**
		*	Get a list of all messages and display them
		*/
		private function Inbox($email = '')
		{
            $GLOBALS['Cusmsgemail'] = sprintf(GetLang('MessageSendSuccess'), $email); # Baskaran
			if (!gzte11(ISC_LARGEPRINT)) {
				ob_end_clean();
				header("Location: " . $GLOBALS['ShopPath']);
				die();
			}

			$GLOBALS['SNIPPETS']['AccountInboxMessage'] = "";
			$GLOBALS['SNIPPETS']['AccountInboxOrderItem'] = "";

			$order_ids_array = array();
			$query = sprintf("select orderid, orddate, ordtotalamount, ordcurrencyid, ordcurrencyexchangerate from [|PREFIX|]orders where ordcustid='%d' and ordstatus > 0 order by orderid desc", $GLOBALS['ISC_CLASS_DB']->Quote($GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerId()));
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$order_ids_array[] = $row['orderid'];
				$GLOBALS['OrderId'] = $row['orderid'];
				$GLOBALS['OrderItemMessage'] = sprintf(GetLang('OrderItemMessage'), $row['orderid'], isc_date(GetConfig('DisplayDateFormat'), $row['orddate']), CurrencyConvertFormatPrice($row['ordtotalamount'], $row['ordcurrencyid'], $row['ordcurrencyexchangerate']));
				$GLOBALS['SNIPPETS']['AccountInboxOrderItem'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("AccountInboxOrderItem");
			}

			$order_ids = implode("', '", $GLOBALS['ISC_CLASS_DB']->Quote($order_ids_array));

			if ($order_ids != "") {
				// They've placed at least one order
				if ($order_ids != "") {
					$query = sprintf("select * from [|PREFIX|]order_messages where messageorderid in ('%s') order by messageid asc", $order_ids);
					$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
                    # commented due to client requirement -- Baskaran                                                      
                    /*if ($GLOBALS['ISC_CLASS_DB']->CountResult($result) > 0) {  
						while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
							$GLOBALS['MessageSubject'] = isc_html_escape($row['subject']);
							$GLOBALS['MessageContent'] = nl2br(isc_html_escape($row['message']));
							$GLOBALS['MessageDate'] = isc_date(GetConfig('ExtendedDisplayDateFormat'), $row['datestamp']);

							if ($row['messagefrom'] == "customer") {
								$GLOBALS['Sender'] = GetLang('MessageYou');
								$GLOBALS['Icon'] = "1";
							}
							else {
								$GLOBALS['Sender'] = $GLOBALS['StoreName'];
								$GLOBALS['Icon'] = "2";
							}

							$GLOBALS['SNIPPETS']['AccountInboxMessage'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("AccountInboxMessage");
						}
					} 

					$GLOBALS['AccountInboxIntro'] = sprintf(GetLang('AccountInboxIntro1'), $GLOBALS['StoreName']);*/

					// Update all messages to "read"
					$UpdatedMessages =array(
						"messagestatus" => "read"
					);
					$GLOBALS['ISC_CLASS_DB']->UpdateQuery("order_messages", $UpdatedMessages, "messagefrom='admin' AND messageorderid IN ('".$order_ids."')");
				}

				/*if ($GLOBALS['SNIPPETS']['AccountInboxMessage'] == "") {
					// No messages, show a notification
					$GLOBALS['AccountInboxIntro'] = sprintf(GetLang('AccountInboxIntro2'), $GLOBALS['StoreName']);
				}*/

				$GLOBALS['HideNoOrderMessage'] = "none";
			}
			else {
				// No access to the inbox, they haven't placed an order
				$GLOBALS['HideInbox']= "none";
			}

			if (!isset($GLOBALS['HideMessageSuccess'])) {
				$GLOBALS['HideMessageSuccess'] = "none";
			}

			if (!isset($GLOBALS['HideMessageError'])) {
				$GLOBALS['HideMessageError'] = "none";
			}

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetPageTitle(sprintf("%s - %s", GetConfig('StoreName'), GetLang('Inbox')));
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("account_inbox");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}

		/**
		*	Save the new message to the order_messages table
		*/
		private function SendMessage()
		{

			if (!gzte11(ISC_LARGEPRINT)) {
				ob_end_clean();
				header("Location: " . $GLOBALS['ShopPath']);
				die();
			}

			if (isset($_POST['message_order_id']) && isset($_POST['message_subject']) && isset($_POST['message_content'])) {
				$message = $_POST['message_content'];
				$NewMessage = array(
					"messagefrom" => "customer",
					"subject" => $_POST['message_subject'],
					"message" => $message,
					"datestamp" => time(),
					"messageorderid" => (int)$_POST['message_order_id'],
					"messagestatus" => 'unread',
					"staffuserid" => 0,
					"isflagged" => 0
				);

				$GLOBALS['HideNoOrderMessage'] = "none";
				$GLOBALS['HideInboxMessage'] = "none";

                if ($GLOBALS['ISC_CLASS_DB']->InsertQuery("order_messages", $NewMessage)) {
                    # Added the following code to send a mail to admin what the customer send the order message -- Baskaran
                    $cid = $GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerId();
                    $query = $GLOBALS['ISC_CLASS_DB']->Query("SELECT * FROM [|PREFIX|]customers where customerid = '$cid'");
                    $row = $GLOBALS['ISC_CLASS_DB']->Fetch($query);
                    $ordId = (int)$_POST['message_order_id'];
                    
                    $ordquery = $GLOBALS['ISC_CLASS_DB']->Query("SELECT ordtotalamount, orddate FROM [|PREFIX|]orders where orderid = '$ordId'");
                    $orow = $GLOBALS['ISC_CLASS_DB']->Fetch($ordquery);
                    
                    $subject = "Order Mail";
                    $to = GetConfig('AdminEmail');
//                    $to = "baskaran.b@clariontechnologies.co.in";
                    
                    $msgsubject = $_POST['message_subject'];
                    $customerName = $row['custconfirstname']." ".$row['custconlastname'];
                    $cemail = $row['custconemail'];
                    $phonenumber = $row['custconphone'];
                    $orderNo = $ordId;
                    $totalAmt = $orow['ordtotalamount'];
                    $orderDate = date('m-d-Y', $orow['orddate']);
                    
                    $message = "<table cellpadding='2' cellspacing='2'><tr><td>Subject:</td><td colspan='5'>$msgsubject</td></tr><tr><td>Message:</td><td colspan='5'>$message</td></tr><tr><td colspan='6'>&nbsp;</td></tr><tr><td>Customer Name:</td><td>$customerName</td><td>Email:</td><td>$cemail</td><td>Phone Number:</td><td>$phonenumber</td></tr><tr><td>Order Number:</td><td>$orderNo</td><td>Total Amount:</td><td>$totalAmt</td><td>Order date:</td><td>$orderDate</td></tr><tr><td colspan='6'>Please see the <a href='http://test.congoworld.com/admin/index.php?ToDo=viewOrders'>order message</a> on the admin panel.</td></tr></table>";
                    require_once(ISC_BASE_PATH . "/lib/email.php");
                    $obj_email = GetEmailClass();
                    $obj_email->Set('CharSet', GetConfig('CharacterSet'));
                    $obj_email->From(GetConfig('OrderEmail'), $email);
    //                $obj_email->Set('ReplyTo', $email);
                    $obj_email->Set("Subject", $subject);
                    $obj_email->AddBody("html", $message);
                    $obj_email->AddRecipient($to, "", "h");
                    $email_result = $obj_email->Send();
                    
                    $GLOBALS['HideMessageSuccess'] = "";
                    $GLOBALS['HideMessageError'] = "none";
                }
				else {
					$GLOBALS['HideMessageError'] = "";
					$GLOBALS['HideMessageSuccess'] = "none";
				}

				$this->Inbox($cemail);
			}
		}

		/**
		*	Get all orders for this customer. If $OnlyCompletedOrders is true then we will only
		*	return orders whose ordstatus field is 2 or 10 (shipped or completed). If $NoIncompleteOrders
		*	is true then we will only return orders that have a valid status (ordstatus != 0)
		*/
		public function GetCustomerOrders(&$Result, $OnlyCompletedOrders = false, $NoIncompleteOrders = false)
		{
			$complete_filter = "";

			if ($OnlyCompletedOrders) {
				$complete_filter .= " and (ordstatus='2' or ordstatus='10') ";
			}

			if ($NoIncompleteOrders) {
				$complete_filter .= " and ordstatus != '0' ";
			}

			$query = "
				SELECT *,
				(SELECT statusdesc	FROM [|PREFIX|]order_status WHERE statusid=ordstatus) AS ordstatustext
				FROM [|PREFIX|]orders
				WHERE ordcustid='" . $GLOBALS['ISC_CLASS_DB']->Quote($GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerId()) . "' " . $complete_filter . "
				ORDER BY orderid DESC
			";
			$Result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		}

		/**
		*	Show a list of orders and the ability to download the product if it's a digital download
		*/
		private function OrderStatus()
		{

			$GLOBALS['SNIPPETS']['AccountOrderStatus'] = "";
			$result = false;
			$this->GetCustomerOrders($result, false, true);

			if ($GLOBALS['ISC_CLASS_DB']->CountResult($result) > 0) {
				while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					$GLOBALS['OrderDate'] = isc_date(GetConfig('DisplayDateFormat'), $row['orddate']);
					$GLOBALS['OrderId'] = $row['orderid'];
					$GLOBALS['OrderTotal'] = CurrencyConvertFormatPrice($row['ordtotalamount'], $row['ordcurrencyid'], $row['ordcurrencyexchangerate'], true);
					$GLOBALS['OrderStatus'] = $row['ordstatustext'];

					if ($row['ordshipmethod'] && $row['ordshipcost'] > 0) {
						$GLOBALS['ShippedWith'] = GetLang('ShippedWith') . " <strong><em>".$row['ordshipmethod']."</em></strong>";
					}
					else {
						$GLOBALS['ShippedWith'] = Getlang('ShippedWithFreeShipping');
					}

					$GLOBALS['OrderShipper'] = $row['ordshipmethod'];
					$GLOBALS['TrackURL'] = "";

					$GLOBALS['HidePaymentInstructions'] = "none";
					$GLOBALS['OrderInstructions'] = "";

					// Is the order status "awaiting payment"? If so show the payment instructions
					if ($row['ordstatus'] == 7) {
						$checkout_object = false;
						if (GetModuleById('checkout', $checkout_object, $row['orderpaymentmodule']) && $checkout_object->getpaymenttype("text") == "PAYMENT_PROVIDER_OFFLINE") {
							$GLOBALS['HidePaymentInstructions'] = "";
							$GLOBALS['OrderInstructions'] = nl2br(GetModuleVariable($row['orderpaymentmodule'], "helptext"));
						}
					}

					if ($row['ordtrackingno']) {
						$GLOBALS['HideTrackingText'] = "";
						$GLOBALS['OrderTrackingNo'] = isc_html_escape($row['ordtrackingno']);

						// Let's instantiate an object for the shipper
						$shipper_object = false;
						if ($row['ordershipmodule'] != "" && GetModuleById('shipping', $shipper_object, $row['ordershipmodule'])) {

							// Does it have a link to track the order?
							if ($shipper_object->GetTrackingLink() != "") {
								// Show the tracking link
								$GLOBALS['TrackURL'] = $shipper_object->GetTrackingLink($row['ordtrackingno']);
								$GLOBALS['HideTrackingLink'] = "";
							}
							else {
								// Hide the tracking link
								$GLOBALS['HideTrackingLink'] = "none";
							}
						}
						else {
							$GLOBALS['HideTrackingLink'] = "none";
						}
					}
					else {
						$GLOBALS['HideTrackingText'] = "none";
						$GLOBALS['HideTrackingLink'] = "none";
					}

					// If it's a digital order then no shipping details will be set
					if ($row['ordisdigital'] == 0) {
						$GLOBALS['Recipient'] = isc_html_escape($row['ordshipfirstname'].' '.$row['ordshiplastname']);
					} else {
						$GLOBALS['Recipient'] = isc_html_escape($row['ordbillfirstname'].' '.$row['ordbilllastname']);
					}

					// Get a list of products in the order
					$prod_result = false;
					$products = $this->GetProductsInOrder($row['orderid'], $prod_result);
					$GLOBALS['AccountOrderItemList'] = '';
					
					while ($prod_row = $GLOBALS['ISC_CLASS_DB']->Fetch($prod_result)) {
						$GLOBALS['ItemName'] = isc_html_escape($prod_row['ordprodname']);
						$GLOBALS['ItemQty'] = $prod_row['ordprodqty'];
						//var_dump($prod_row['orddateshipped']);
						//ALANDY 2011-9-13 MODIFY DATA FORMAT.
						if($prod_row['orddateshipped'] != '01/01/1900'  && !empty($prod_row['orddateshipped'])){
							$GLOBALS['ItemShipingDate']='<strong>'.GetLang('ShipingDate').'</strong>'.$prod_row['orddateshipped'];
							
						}else{
							$GLOBALS['ItemShipingDate'] = '';
							
						}
                       
                        $GLOBALS['ItemTrackingNo']= $prod_row['ordtrackingno']?'<strong>'.GetLang('TrackingNumber').'</strong>'.$prod_row['ordtrackingno']:'';
                       
						// Is it a downloadable item?
						if ($prod_row['ordprodtype'] == "digital" && OrderIsComplete($row['ordstatus'])) {
							$GLOBALS['DownloadItemEncrypted'] = $this->EncryptDownloadKey($prod_row['orderprodid'], $prod_row['ordprodid'], $row['orderid'], $row['ordtoken']);
							$GLOBALS['DownloadLink'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("AccountOrderItemDownloadLink");
						}
						else {
							$GLOBALS['DownloadLink'] = "";
						}

						$GLOBALS['Refunded'] = '';
						if ($prod_row['ordprodrefunded'] > 0) {
							if ($prod_row['ordprodrefunded'] == $prod_row['ordprodqty']) {
								$GLOBALS['StrikeStart'] = "<s>";
								$GLOBALS['StrikeEnd'] = "</s>";
								$GLOBALS['Refunded'] = '<span class="Refunded">'.GetLang('OrderProductRefunded').'</span>';
							}
							else {
								$GLOBALS['Refunded'] = '<span class="Refunded">'.sprintf(GetLang('OrderProductsRefundedX'), $prod_row['ordprodrefunded']).'</span>';
							}
						}

						// Were there one or more options selected?
						$GLOBALS['ProductOptions'] = '';
						if($prod_row['ordprodoptions'] != '') {
							$options = @unserialize($prod_row['ordprodoptions']);
							if(!empty($options)) {
								$GLOBALS['ProductOptions'] = "<br /><small>(";
								$comma = '';
								foreach($options as $name => $value) {
									$GLOBALS['ProductOptions'] .= $comma.isc_html_escape($name).": ".isc_html_escape($value);
									$comma = ', ';
								}
								$GLOBALS['ProductOptions'] .= ")</small>";
							}
						}
                        
						$GLOBALS['AccountOrderItemList'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("AccountOrderItemList");
					}

					if ($row['ordisdigital'] == "1") {
						$GLOBALS['HidePhysicalShipmentInfo'] = "none";
						$GLOBALS['HideDigitalShipmentInfo'] = "";
					}
					else {
						$GLOBALS['HideDigitalShipmentInfo'] = "none";
						$GLOBALS['HidePhysicalShipmentInfo'] = "";
					}

					if($row['ordonlygiftcerts']) {
						$GLOBALS['HideDigitalShipmentInfo'] = 'none';
					}

					// Hide the extra order information is the order isn't complete
					if (!OrderIsComplete($row['ordstatus'])) {
						$GLOBALS['DisableViewButton'] = "none";
						$GLOBALS['HideExtraOrderInfo'] = "none";
						$GLOBALS['HidePhysicalShipmentInfo'] = "none";
						$GLOBALS['HideDigitalShipmentInfo'] = "none";
					}
					else {
						$GLOBALS['DisableViewButton'] = "";
						$GLOBALS['HideExtraOrderInfo'] = "";
					}

					$GLOBALS['SNIPPETS']['AccountOrderStatus'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("AccountOrderStatusItem");
				}

				$GLOBALS['HideNoOrderStatusMessage'] = "none";
			}
			else {
				$GLOBALS['HideOrderStatusList'] = "none";
			}

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetPageTitle(sprintf("%s - %s", GetConfig('StoreName'), GetLang('OrderStatus')));
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("account_orderstatus");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}

		/**
		*	Return a list of items from the order_products table whose orderorderid field = $OrderId
		*/
		public function GetProductsInOrder($OrderId, &$Result)
		{
			//$query = sprintf("select orderprodid, ordprodid, ordprodname, ordprodtype, ordprodqty, ordprodrefunded, ordprodoptions, ordprodvariationid,ordtrackingno,DATE_FORMAT(orddateshipped,'%%d/%%m/%%Y') AS orddateshipped2 from [|PREFIX|]order_products where orderorderid='%f'", $GLOBALS['ISC_CLASS_DB']->Quote($OrderId));
			$query = "select orderprodid, ordprodid, ordprodname, ordprodtype, ordprodqty, ordprodrefunded, ordprodoptions, ordprodvariationid,ordtrackingno,DATE_FORMAT(orddateshipped,'%d/%m/%Y') AS orddateshipped from [|PREFIX|]order_products where orderorderid=".(int)$GLOBALS['ISC_CLASS_DB']->Quote($OrderId);
			
			$Result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		}

		private function ViewOrders()
		{
			$GLOBALS['SNIPPETS']['AccountOrders'] = "";
			$GLOBALS['AccountOrderItemList'] = "";

			$result = false;
			$this->GetCustomerOrders($result, true);

			// Are there any orders for this customer
			if ($GLOBALS['ISC_CLASS_DB']->CountResult($result) > 0) {
				while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					$GLOBALS['OrderDate'] = isc_date(GetConfig('DisplayDateFormat'), $row['orddate']);
					$GLOBALS['OrderId'] = $row['orderid'];
					$GLOBALS['OrderTotal'] = CurrencyConvertFormatPrice($row['ordtotalamount'], $row['ordcurrencyid'], $row['ordcurrencyexchangerate'], true);
					$GLOBALS['TrackURL'] = "";

					$GLOBALS['HidePaymentInstructions'] = "none";
					$GLOBALS['OrderInstructions'] = "";

					// If it's a digital order then no shipping details will be set
					if ($row['ordisdigital'] == 0) {
						$GLOBALS['Recipient'] = isc_html_escape($row['ordshipfirstname'].' '.$row['ordshiplastname']);
					} else {
						$GLOBALS['Recipient'] = isc_html_escape($row['ordbillfirstname'].' '.$row['ordbilllastname']);
					}

					// Is this an order for physical items and does it have a ship date?
					if ($row['orddateshipped'] != 0 && $row['ordisdigital'] == 0) {
						$GLOBALS['ShipDate'] = isc_date(GetConfig('DisplayDateFormat'), $row['orddateshipped']);
						$GLOBALS['HideShipDate'] = "";
					}
					else {
						$GLOBALS['ShipDate'] = "";
						$GLOBALS['HideShipDate'] = "none";
					}

					$GLOBALS['DisableReturnButton'] = "";

					if (!gzte11(ISC_LARGEPRINT)) {
						$GLOBALS['DisableReturnButton'] = "none";
					}

					if ($row['ordstatus'] == 4 || GetConfig('EnableReturns') == 0) {
						$GLOBALS['DisableReturnButton'] = "none";
					}

					// Get a list of products in the order
					$prod_result = false;
					$products = $this->GetProductsInOrder($row['orderid'], $prod_result);

					while ($prod_row = $GLOBALS['ISC_CLASS_DB']->Fetch($prod_result)) {
						$GLOBALS['ItemName'] = isc_html_escape($prod_row['ordprodname']);
						$GLOBALS['ItemQty'] = $prod_row['ordprodqty'];

						// Is it a downloadable item?
						if ($prod_row['ordprodtype'] == "digital" && OrderIsComplete($row['ordstatus'])) {
							$GLOBALS['DownloadItemEncrypted'] = $this->EncryptDownloadKey($prod_row['orderprodid'], $prod_row['ordprodid'], $row['orderid'], $row['ordtoken']);
							$GLOBALS['DownloadLink'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("AccountOrderItemDownloadLink");
						}
						else {
							$GLOBALS['DownloadLink'] = "";
						}

						$GLOBALS['Refunded'] = '';
						if ($prod_row['ordprodrefunded'] > 0) {
							if ($prod_row['ordprodrefunded'] == $prod_row['ordprodqty']) {
								$GLOBALS['StrikeStart'] = "<s>";
								$GLOBALS['StrikeEnd'] = "</s>";
								$GLOBALS['Refunded'] = '<span class="Refunded">'.GetLang('OrderProductRefunded').'</span>';
							}
							else {
								$GLOBALS['Refunded'] = '<span class="Refunded">'.sprintf(GetLang('OrderProductsRefundedX'), $prod_row['ordprodrefunded']).'</span>';
							}
						}

						// Were there one or more options selected?
						$GLOBALS['ProductOptions'] = '';
						if($prod_row['ordprodoptions'] != '') {
							$options = @unserialize($prod_row['ordprodoptions']);
							if(!empty($options)) {
								$GLOBALS['ProductOptions'] = "<br /><small>(";
								$comma = '';
								foreach($options as $name => $value) {
									$GLOBALS['ProductOptions'] .= $comma.isc_html_escape($name).": ".isc_html_escape($value);
									$comma = ', ';
								}
								$GLOBALS['ProductOptions'] .= ")</small>";
							}
						}

						$GLOBALS['AccountOrderItemList'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("AccountOrderItemList");
					}

					$GLOBALS['SNIPPETS']['AccountOrders'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("AccountOrderItem");
					$GLOBALS['AccountOrderItemList'] = "";
				}

				$GLOBALS['HideNoOrdersMessage'] = "none";
			}
			else {
				$GLOBALS['HideOrderList'] = "none";
			}

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetPageTitle(sprintf("%s - %s", GetConfig('StoreName'), GetLang('YourOrders')));
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("account_orders");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}

		/**
		*	Build an encrypted download key that links the client to download the product they purchased
		*/
		public function EncryptDownloadKey($ItemRecordId, $ProductId, $OrderId, $OrderToken, $DownloadId=0)
		{
			// The order token can't have a ',' in it.
			if (strpos($OrderToken, ',') !== false) {
				return false;
			}

			$data = ((int)$ItemRecordId).','.((int)$ProductId).','.((int)$OrderId).','.$OrderToken;

			if ($DownloadId > 0) {
				$data .= ','.((int)$DownloadId);
			}

			// Create some random "noise" text
			$gibberish = "";

			for ($i = 0; $i < rand(30, 50); $i++) {
				$gibberish .= chr(rand(48, 57));
			}
			$data .= ','.$gibberish;

			// Merge everything into a variable
			$data = base64_encode($data);
			return $data;
		}

		/**
		*	Decrypt the product download key
		*/
		public function DecryptDownloadKey($Data)
		{
			$data = base64_decode($Data);
			return $data;
		}

		/**
		*	Strem the product for download as defined by the values in the $_GET['data'] variable.
		*	The variable contains the item id, product id and order id which, if valid, will
		*	be used to find and then stream the file for the product to the customer
		*/
		private function DownloadOrderItem()
		{
			if (isset($_GET['data'])) {
				$data = $this->DecryptDownloadKey($_GET['data']);
				$data_vals = explode(",", $data);

				if (count($data_vals) >= 5) {
					$item_id = (int)$data_vals[0];
					$product_id = (int)$data_vals[1];
					$order_id = (int)$data_vals[2];
					$order_token = $data_vals[3];

					// Select the number of downloads for this order item
					$query = sprintf("
						select pd.downloadid, o.ordstatus
						from [|PREFIX|]product_downloads pd
						left join [|PREFIX|]order_products op on pd.productid=op.ordprodid
						inner join [|PREFIX|]orders o on op.orderorderid=o.orderid
						where pd.productid='%d' and o.orderid='%d' and op.orderprodid='%d'",
						$GLOBALS['ISC_CLASS_DB']->Quote($product_id), $GLOBALS['ISC_CLASS_DB']->Quote($order_id), $GLOBALS['ISC_CLASS_DB']->Quote($item_id)
					);

					$query .= " AND o.ordtoken = '".$GLOBALS['ISC_CLASS_DB']->Quote($order_token)."'";
					$query .= $GLOBALS['ISC_CLASS_DB']->AddLimit(0, 1);
					$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
					$product_downloads = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

					// We have a valid ordered product with downloads
					if ($product_downloads && OrderIsComplete($product_downloads['ordstatus'])) {
						// Downloading a particular file
						if (count($data_vals) == 6) {
							$download_id = (int)$data_vals[4];
							// Fetch the file we're downloading
							$query = sprintf("
								SELECT orddate, pd.downfile, od.numdownloads, od.downloadexpires, od.maxdownloads, ordstatus, pd.downexpiresafter, pd.downmaxdownloads, od.orddownid
								FROM [|PREFIX|]product_downloads pd
								INNER JOIN [|PREFIX|]products p ON pd.productid=p.productid
								LEFT JOIN [|PREFIX|]order_downloads od ON (od.orderid='%s' AND od.downloadid=pd.downloadid)
								INNER JOIN [|PREFIX|]orders o ON (o.orderid='%d')
								WHERE pd.downloadid='%d' AND p.productid='%d'",
								$GLOBALS['ISC_CLASS_DB']->Quote($order_id), $GLOBALS['ISC_CLASS_DB']->Quote($order_id), $GLOBALS['ISC_CLASS_DB']->Quote($download_id), $GLOBALS['ISC_CLASS_DB']->Quote($product_id)
							);

							$query .= " AND o.ordtoken = '".$GLOBALS['ISC_CLASS_DB']->Quote($order_token)."'";

							$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
							$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

							if ($row && OrderIsComplete($row['ordstatus'])) {
								// If there is no matching row in the order_downloads table for this download, we need to create it
								if(!$row['orddownid']) {
									// If this download has an expiry date, set it to now + expiry time
									$expiryDate = 0;
									if($row['downexpiresafter'] > 0) {
										$expiryDate = $row['orddate'] + $row['downexpiresafter'];
									}

									$newDownload = array(
										'orderid' => (int)$order_id,
										'downloadid' => (int)$download_id,
										'numdownloads' => 0,
										'downloadexpires' => $expiryDate,
										'maxdownloads' => $row['downmaxdownloads']
									);
									$row['maxdownloads'] = $row['downmaxdownloads'];
									$row['downloadexpires'] = $expiryDate;
									$GLOBALS['ISC_CLASS_DB']->InsertQuery('order_downloads', $newDownload);
								}
								$expired = false;
								// Have we reached the download limit for this item?
								if ($row['maxdownloads'] != 0 && $row['numdownloads'] >= $row['maxdownloads']) {
									$expired = true;
								}
								// Have we reached the expiry limit for this item?
								if ($row['downloadexpires'] > 0 && time() >= $row['downloadexpires']) {
									$expired = true;
								}

								// Download has expired
								if ($expired == true) {
									$GLOBALS['ErrorMessage'] = GetLang('DownloadItemExpired');
									$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("error");
									$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
									return;
								}
								$query = "
									UPDATE [|PREFIX|]order_downloads
									SET numdownloads=numdownloads + 1
									WHERE orderid='".(int)$order_id."' AND downloadid='".(int)$download_id."'
								";
								$GLOBALS['ISC_CLASS_DB']->Query($query);

								$filename = basename($row['downfile']);
								$filepath = realpath(ISC_BASE_PATH.'/' . GetConfig('DownloadDirectory')) . "/" . $row['downfile'];

								if (file_exists($filepath)) {
									// Strip the underscores and random numbers that are added when a file is uploaded
									$filename = preg_replace("#__[0-9]+#", "", $filename);

									ob_end_clean();
									@ini_set('max_execution_time', 0);
									header("Pragma: public");
									header("Expires: 0");
									header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
									header("Content-Type: application/force-download");
									header("Content-Type: application/octet-stream");
									header("Content-Type: application/download");
									header("Content-Disposition: attachment; filename=\"" . $filename . "\";");
									header("Content-Transfer-Encoding: binary");
									header("Content-Length: " . sprintf('%u', filesize($filepath)));
									$fp = fopen($filepath, "rb");
									while (!feof($fp)) {
										echo fread($fp, 16384);
										@flush();
									}
									fclose($fp);
									die();
								}
								else {
									// File doesn't exist
									$GLOBALS['ErrorMessage'] = GetLang('DownloadItemErrorMessage');
									$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("error");
									$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
								}
							}
							else {
								// Product doesn't exist or the download doesn't exist.
								$GLOBALS['ErrorMessage'] = GetLang('DownloadItemErrorMessage');
								$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("error");
								$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
							}
						}
						else {
							$GLOBALS['SNIPPETS']['AccountDownloadItemList'] = '';
							$query = sprintf("select prodname from [|PREFIX|]products where productid='%s'", $GLOBALS['ISC_CLASS_DB']->Quote($product_id));
							$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
							$prodName = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);
							$GLOBALS['DownloadTitle'] = sprintf(GetLang('ProductDownloads'), $prodName);
							$GLOBALS['DownloadIntro'] = sprintf(GetLang('ProductDownloadsIntro'), $prodName);

							// Show a listing of the downloadable files within this product
							$query = sprintf("
								select orddate, orderprodid, ordprodid, o.orderid, o.ordtoken, pd.downloadid, pd.downfile, pd.downname, pd.downfilesize, pd.downdescription, pd.downmaxdownloads, pd.downexpiresafter, od.numdownloads, od.maxdownloads, od.downloadexpires, od.orddownid, ordprodqty
								from [|PREFIX|]product_downloads pd
								left join [|PREFIX|]order_products op on pd.productid=op.ordprodid
								inner join [|PREFIX|]orders o on op.orderorderid=o.orderid
								left join [|PREFIX|]order_downloads od on od.downloadid=pd.downloadid and od.orderid=o.orderid
								where pd.productid='%d' and o.orderid='%d' and op.orderprodid='%d' order by downname",
								$product_id, $order_id, $item_id
							);

							$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
							while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
								$expired = false;
								$Color = $ExpiresDownloads = $ExpiresDays = $GLOBALS['ExpiryInfo'] = '';

								if(!$row['orddownid']) {
									$row['maxdownloads'] = $row['downmaxdownloads'];
									if($row['downexpiresafter'] > 0) {
										$row['downloadexpires'] = $row['downexpiresafter'] + $row['orddate'];
									}
								}
								else {

								}

								// Have we reached the expiry limit for this item?
								if ($row['downexpiresafter'] > 0) {
									$diff = $row['downloadexpires'];
									if ($row['downloadexpires'] <= time()) {
										$expired = true;
									}
									else {
										$remaining_days = ceil(($diff-time())/86400);
										if ($remaining_days > 0 && ($remaining_days % 365) == 0) {
											if ($remaining_days/365 > 1) {
												$ExpiresDays = number_format($remaining_days/365)." ".GetLang('YearsLower');
											} else {
												$ExpiresDays = number_format($remaining_days/365)." ".GetLang('YearLower');
											}
										}
										else if ($remaining_days > 0 && ($remaining_days % 30) == 0) {
											if ($remaining_days/30 > 1) {
												$ExpiresDays = number_format($remaining_days/30)." ".GetLang('MonthsLower');
											} else {
												$ExpiresDays = number_format($remaining_days/30)." ".GetLang('MonthLower');
											}
										}
										else if ($remaining_days > 0 && ($remaining_days % 7) == 0) {
											if ($remaining_days/7 > 1) {
												$ExpiresDays = number_format($remaining_days/7)." ".GetLang('WeeksLower');
											} else {
												$ExpiresDays = number_format($remaining_days/7)." ".GetLang('WeekLower');
											}
										}
										else {
											if ($remaining_days > 1) {
												$ExpiresDays = number_format($remaining_days)." ".GetLang('DaysLower');
											} else {
												$ExpiresDays = number_format($remaining_days)." ".GetLang('TodayLower');
												$Color = "DownloadExpiresToday";
											}
										}
									}
								}

								// Have we reached the download limit for this item?
								if ($row['maxdownloads'] > 0) {
									$remaining_downloads = $row['maxdownloads']-$row['numdownloads'];
									if ($remaining_downloads <= 0) {
										$expired = true;
									}
									else {
										$string = 'DownloadExpiresInX';
										if ($ExpiresDays) {
											$string .= 'Download';
										}
										else {
											$string .= 'Time';
										}
										if ($remaining_downloads != 1) {
											$string .= 's';
										}
										else {
											$Color = "DownloadExpiresToday";
										}
										$ExpiresDownloads = sprintf(GetLang($string), $remaining_downloads);
									}
								}

								$GLOBALS['DownloadColor'] = $Color;
								$GLOBALS['DownloadName'] = isc_html_escape($row['downname']);

								if ($expired == true) {
									$GLOBALS['DisplayDownloadExpired'] = '';
									$GLOBALS['DisplayDownloadLink'] = 'none';
								}
								else {
									$GLOBALS['DisplayDownloadExpired'] = 'none';
									$GLOBALS['DisplayDownloadLink'] = '';
									$GLOBALS['DownloadItemEncrypted'] = $this->EncryptDownloadKey($row['orderprodid'], $row['ordprodid'], $row['orderid'], $row['ordtoken'], $row['downloadid']);
									$GLOBALS['DownloadName'] = sprintf("<a href=\"%s/account.php?action=download_item&data=%s\">%s</a>", $GLOBALS['ShopPathSSL'], $GLOBALS['DownloadItemEncrypted'], $GLOBALS['DownloadName']);

									if ($ExpiresDays && $ExpiresDownloads) {
										$GLOBALS['ExpiryInfo'] = sprintf(GetLang('DownloadExpiresBoth'), $ExpiresDays, $ExpiresDownloads);
									}
									else if ($ExpiresDays) {
										$GLOBALS['ExpiryInfo'] = sprintf(GetLang('DownloadExpiresTime'), $ExpiresDays);
										if ($Color == "DownloadExpiresToday") {
											$GLOBALS['ExpiryInfo'] = GetLang('DownloadExpiresTimeToday');
										}
									}
									else if ($ExpiresDownloads) {
										$GLOBALS['ExpiryInfo'] = sprintf(GetLang('DownloadExpires'), $ExpiresDownloads);
									}
								}

								if($row['ordprodqty'] > 1) {
									$GLOBALS['DownloadName'] = $row['ordprodqty']. ' X '.$GLOBALS['DownloadName'];
								}

								$GLOBALS['DownloadSize'] = NiceSize($row['downfilesize']);
								$GLOBALS['DownloadDescription'] = isc_html_escape($row['downdescription']);
								$GLOBALS['OrderId'] = $row['orderid'];
								$GLOBALS['SNIPPETS']['AccountDownloadItemList'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("AccountDownloadItemList");
							}

							$GLOBALS['ISC_LANG']['OrderId'] = sprintf(GetLang('OrderId'), $order_id);

							$GLOBALS['ISC_CLASS_TEMPLATE']->SetPageTitle(sprintf("%s - %s", GetConfig('StoreName'), GetLang('DownloadItems')));
							$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("account_downloaditem");
							$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
						}
					}
					else {
						// This order does not have any downloadable products that exist
						$GLOBALS['ErrorMessage'] = GetLang('DownloadItemErrorMessage');
						$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("error");
						$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
					}
				}
				else {
					// Bad download details in the URL
					$GLOBALS['ErrorMessage'] = GetLang('DownloadItemErrorMessage');
					$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("error");
					$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
				}
			}
			else {
				$this->ViewOrders();
			}
		}

		/**
		*	Show the details of an order and allow them to print an invoice
		*/
		private function ViewOrderDetails()
		{
			$GLOBALS['SNIPPETS']['AccountOrderItemRow'] = "";
			$count = 0;

			if (isset($_GET['order_id']) && is_numeric($_GET['order_id'])) {
				$GLOBALS['FlassMessage'] = GetFlashMessageBoxes();

				// Retrieve the completed order that matches the customers user id
				$order_id = (int)$_GET['order_id'];
				$GLOBALS['OrderId'] = $order_id;

				$query = sprintf("select *, (select concat(custconfirstname, ' ', custconlastname) from [|PREFIX|]customers where customerid=ordcustid) as custname, (select statusdesc from [|PREFIX|]order_status where statusid=ordstatus) as ordstatustext from [|PREFIX|]orders where ordcustid='%d' and orderid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerId()), $order_id);

				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

				$GLOBALS['DisableReturnButton'] = "";

				if (!gzte11(ISC_LARGEPRINT)) {
					$GLBOALS['DisableReturnButton'] = "none";
				}

				if ($GLOBALS['ISC_CLASS_DB']->CountResult($result) == 0) {
					// No order or the user doesn't own the order
					$this->ViewOrders();
				}
				else {
					// The order is valid, display it
					$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
					$order = $row;
					$GLOBALS['OrderComments'] = '';

					if($row['ordcustmessage'] != '') {
						$GLOBALS['OrderComments'] = nl2br(isc_html_escape($row['ordcustmessage']));
					}
					else {
						$GLOBALS['HideOrderComments'] = 'display: none';
					}
					if(OrderIsComplete($row['ordstatus'])) {
						if (!gzte11(ISC_LARGEPRINT)) {
							$GLOBALS['DisableReturnButton'] = "none";
						}

						if ($row['ordstatus'] == 4 || GetConfig('EnableReturns') == 0) {
							$GLOBALS['DisableReturnButton'] = "none";
						}
						$GLOBALS['HideOrderStatus'] = "none";
						$orderComplete = true;
					}
					else {
						$GLOBALS['HideOrderStatus'] = '';
						$GLOBALS['OrderStatus'] = $row['ordstatustext'];
						$GLOBALS['DisableReturnButton'] = "none";
						$orderComplete = false;
					}

					//hide print order invoive if it's a incomplete order
					$GLOBALS['ShowOrderActions'] = '';
					if(!$row['ordstatus']) {
						$GLOBALS['ShowOrderActions'] = 'display:none';
					}

					$GLOBALS['OrderDate'] = isc_date(GetConfig('ExtendedDisplayDateFormat'), $row['orddate']);
					$GLOBALS['Recipient'] = isc_html_escape($row['custname']);

					$GLOBALS['OrderTotal'] = CurrencyConvertFormatPrice($row['ordtotalamount'], $row['ordcurrencyid'], $row['ordcurrencyexchangerate'], true);

					// Format the billing address
					$GLOBALS['ShipFullName'] = isc_html_escape($row['ordbillfirstname'].' '.$row['ordbilllastname']);

					$GLOBALS['ShipCompany'] = '';
					if($row['ordbillcompany']) {
						$GLOBALS['ShipCompany'] = '<br />'.isc_html_escape($row['ordbillcompany']);
					}

					$GLOBALS['ShipAddressLine1'] = isc_html_escape($row['ordbillstreet1']);

					if($row['ordbillstreet2'] != "") {
						$GLOBALS['ShipAddressLine2'] = isc_html_escape($row['ordbillstreet2']);
					} else {
						$GLOBALS['ShipAddressLine2'] = '';
					}

					$GLOBALS['ShipSuburb'] = isc_html_escape($row['ordbillsuburb']);
					$GLOBALS['ShipState'] = isc_html_escape($row['ordbillstate']);
					$GLOBALS['ShipZip'] = isc_html_escape($row['ordbillzip']);
					$GLOBALS['ShipCountry'] = isc_html_escape($row['ordbillcountry']);

					$GLOBALS['ShipPhone'] = "";
					$GLOBALS['BillingAddress'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("AddressLabel");

					// Is there a shipping address, or is it a digital download?
					if ($row['ordshipfirstname'] == "") {
						$GLOBALS['ShippingAddress'] = GetLang('NA');
					}
					else {
						$GLOBALS['ShipFullName'] = isc_html_escape($row['ordshipfirstname'].' '.$row['ordshiplastname']);

						$GLOBALS['ShipCompany'] = '';
						if($row['ordshipcompany']) {
							$GLOBALS['ShipCompany'] = '<br />'.isc_html_escape($row['ordshipcompany']);
						}

						$GLOBALS['ShipAddressLine1'] = isc_html_escape($row['ordshipstreet1']);

						if($row['ordshipstreet2'] != "") {
							$GLOBALS['ShipAddressLine2'] = isc_html_escape($row['ordshipstreet2']);
						} else {
							$GLOBALS['ShipAddressLine2'] = '';
						}

						$GLOBALS['ShipSuburb'] = isc_html_escape($row['ordshipsuburb']);
						$GLOBALS['ShipState'] = isc_html_escape($row['ordshipstate']);
						$GLOBALS['ShipZip'] = isc_html_escape($row['ordshipzip']);
						$GLOBALS['ShipCountry'] = isc_html_escape($row['ordshipcountry']);

						$GLOBALS['ShipPhone'] = "";
						$GLOBALS['ShippingAddress'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("AddressLabel");
					}

					$GLOBALS['OrderSubTotal'] = CurrencyConvertFormatPrice($row['ordsubtotal'], $row['ordcurrencyid'], $row['ordcurrencyexchangerate']);
					$GLOBALS['ShippingCost'] = CurrencyConvertFormatPrice($row['ordshipcost'], $row['ordcurrencyid'], $row['ordcurrencyexchangerate']);

					if ($row['ordhandlingcost'] == 0) {
						$GLOBALS['HideHandling'] = "none";
					}
					else {
						$GLOBALS['HideHandling'] = "";
						$GLOBALS['HandlingCost'] = CurrencyConvertFormatPrice($row['ordhandlingcost'], $row['ordcurrencyid'], $row['ordcurrencyexchangerate']);
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
							$GLOBALS['HideTax'] = 'none';
							$GLOBALS['SalesTaxName'] .= ' '.GetLang('IncludedInTotal');
						}
						else {
							$GLOBALS['HideTaxIncluded'] = 'none';
						}
						$GLOBALS['TaxCost'] = CurrencyConvertFormatPrice($row['ordtaxtotal'], $row['ordcurrencyid'], $row['ordcurrencyexchangerate']);
					}
					else {
						$GLOBALS['HideTax'] = "none";
						$GLOBALS['HideTaxIncluded'] = 'none';
					}

					$OrderProducts = array();
					$ProductIds = array();
					// Load up the items in this order
					$query = sprintf("select * from [|PREFIX|]order_products p, [|PREFIX|]orders o where p.orderorderid = o.orderid AND orderorderid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($order_id));
					$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
					$wrappingTotal = 0;

					//check if products are reorderable
					while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
						$OrderProducts[$row['orderprodid']] = $row;
						$ProductIds[] = $row['ordprodid'];
					}

					$UnreorderableProducts = $this->GetUnreorderableProducts($OrderProducts, $ProductIds);
					foreach ($OrderProducts as $row) {
						if ($count++ % 2 != 0) {
							$GLOBALS['ItemClass'] = "OrderItem2";
						} else {
							$GLOBALS['ItemClass'] = "OrderItem1";
						}

						$GLOBALS['OrderProductId'] = $row['orderprodid'];
						$GLOBALS['DisableReorder'] = '';

						$GLOBALS['ReorderMessage'] = "";
						$GLOBALS['HideItemMessage'] = 'display:none;';
						if(isset($UnreorderableProducts[$row['orderprodid']])) {
							$GLOBALS['DisableReorder'] = 'Disabled';
							$GLOBALS['ReorderMessage'] = $UnreorderableProducts[$row['orderprodid']];
							if(isset($_REQUEST['reorder']) && $_REQUEST['reorder']==1) {
								$GLOBALS['HideItemMessage'] = '';
							}
						}

						$GLOBALS['Qty'] = (int) $row['ordprodqty'];
						$GLOBALS['Name'] = isc_html_escape($row['ordprodname']);
						$GLOBALS['EventDate'] = '';

						if ($row['ordprodeventdate'] != 0) {
							$GLOBALS['EventDate'] = $row['ordprodeventname'] . ': '. isc_date('M jS Y', $row['ordprodeventdate']);
						}

						// Does the product still exist or has it been deleted?
						$prod_name = GetProdNameById($row['ordprodid']);

						if ($prod_name == "") {
							$GLOBALS['Link'] = "javascript:product_removed()";
							$GLOBALS['Target'] = "";
						}
						else {
							$GLOBALS['Link'] = ProdLink(GetProdNameById($row['ordprodid']));
							$GLOBALS['Target'] = "_blank";
						}

						$GLOBALS['DownloadsLink'] = '';
						if ($row['ordprodtype'] == "digital" && $orderComplete) {
							$GLOBALS['DownloadItemEncrypted'] = $this->EncryptDownloadKey($row['orderprodid'], $row['ordprodid'], $row['orderorderid'], $row['ordtoken']);
							$GLOBALS['DownloadsLink'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("AccountOrderItemDownloadLink");
						}

						$GLOBALS['StrikeStart'] = $GLOBALS['StrikeEnd'] = $GLOBALS['Refunded'] = '';
						if ($row['ordprodrefunded'] > 0) {
							if ($row['ordprodrefunded'] == $row['ordprodqty']) {
								$GLOBALS['StrikeStart'] = "<s>";
								$GLOBALS['StrikeEnd'] = "</s>";
								$GLOBALS['Refunded'] = '<span class="Refunded">'.GetLang('OrderProductRefunded').'</span>';
							}
							else {
								$GLOBALS['Refunded'] = '<span class="Refunded">'.sprintf(GetLang('OrderProductsRefundedX'), $row['ordprodrefunded']).'</span>';
							}
						}

						$itemTotal = $row['ordprodcost'] * ($row['ordprodqty'] - $row['ordprodrefunded']);
						$GLOBALS['Price'] = CurrencyConvertFormatPrice($itemTotal, $order['ordcurrencyid'], $order['ordcurrencyexchangerate']);
						if ($GLOBALS['Price'] === 0) {
							$GLOBALS['Price'] = "0.00";
						}

						// Were there one or more options selected?
						$GLOBALS['ProductOptions'] = '';
						if($row['ordprodoptions'] != '') {
							$options = @unserialize($row['ordprodoptions']);
							if(!empty($options)) {
								$GLOBALS['ProductOptions'] = "<br /><small class='OrderItemOptions'>(";
								$comma = '';
								foreach($options as $name => $value) {
									$GLOBALS['ProductOptions'] .= $comma.isc_html_escape($name).": ".isc_html_escape($value);
									$comma = ', ';
								}
								$GLOBALS['ProductOptions'] .= ")</small>";
							}
						}

						if($row['ordprodwrapcost'] > 0) {
							$wrappingTotal += $row['ordprodwrapcost'] * $row['ordprodqty'];
						}

						if($row['ordprodwrapname']) {
							$GLOBALS['GiftWrappingName'] = isc_html_escape($row['ordprodwrapname']);
							$GLOBALS['HideWrappingOptions'] = '';
						}
						else {
							$GLOBALS['GiftWrappingName'] = '';
							$GLOBALS['HideWrappingOptions'] = 'display: none';
						}

						$GLOBALS['SNIPPETS']['AccountOrderItemRow'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("AccountOrderItemRow");
					}
					if($wrappingTotal > 0) {
						$GLOBALS['GiftWrappingTotal'] = CurrencyConvertFormatPrice($wrappingTotal, $order['ordcurrencyid'], $order['ordcurrencyexchangerate']);
					}
					else {
						$GLOBALS['HideGiftWrappingTotal'] = 'display: none';
					}


					$GLOBALS['ISC_CLASS_TEMPLATE']->SetPageTitle(sprintf("%s - %s%d", GetConfig('StoreName'), GetLang('OrderIdHash'), $order_id));
					$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("account_order");
					$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
				}
			}
			else {
				$this->ViewOrders();
			}
		}

		/**
		*	Print an invoice for the selected order using the invoice_print template
		*/
		public function PrintInvoice()
		{

			$numProds = 0;
			$numDL = 0;
			$numPhy = 0;

			if (isset($_GET['order_id']) && is_numeric($_GET['order_id'])) {

				$GLOBALS['HeaderLogo'] = FetchHeaderLogo();

				$order_id = (int)$_GET['order_id'];
				$GLOBALS['StoreAddressFormatted'] = nl2br(GetConfig('StoreAddress'));

				$query = "SELECT o.*, CONCAT(c.custconfirstname, ' ', c.custconlastname) AS ordcustname, c.custconemail AS ordcustemail, c.custconphone AS ordcustphone
						  FROM [|PREFIX|]orders o
						  JOIN [|PREFIX|]customers c ON o.ordcustid = c.customerid
						  WHERE o.orderid = '".$GLOBALS['ISC_CLASS_DB']->Quote($order_id)."' AND o.ordcustid='" . $GLOBALS['ISC_CLASS_DB']->Quote($GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerId()) . "'";

				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

				if ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					$GLOBALS['InvoiceTitle'] = sprintf(GetLang('InvoiceTitle'), $order_id);
					$GLOBALS['ItemCost'] = CurrencyConvertFormatPrice($row['ordsubtotal'], $row['ordcurrencyid'], $row['ordcurrencyexchangerate']);
					$GLOBALS['ShippingCost'] = CurrencyConvertFormatPrice($row['ordshipcost'], $row['ordcurrencyid'], $row['ordcurrencyexchangerate']);

					// Is there a handling fee?
					if ($row['ordhandlingcost'] > 0) {
						$GLOBALS['HandlingCost'] = CurrencyConvertFormatPrice($row['ordhandlingcost'], $row['ordcurrencyid'], $row['ordcurrencyexchangerate']);
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
							$GLOBALS['HideSalesTaxIncluded'] = 'none';
						}
						$GLOBALS['SalesTax'] = CurrencyConvertFormatPrice($row['ordtaxtotal'], $row['ordcurrencyid'], $row['ordcurrencyexchangerate']);
					}
					else {
						$GLOBALS['HideSalesTax'] = "none";
						$GLOBALS['HideSalesTaxIncluded'] = 'none';
					}

					$GLOBALS['TotalCost'] = CurrencyConvertFormatPrice($row['ordtotalamount'], $row['ordcurrencyid'], $row['ordcurrencyexchangerate']);

					// Format the customer details
					$GLOBALS['CustomerName'] = isc_html_escape($row['ordcustname']);
					$GLOBALS['CustomerEmail'] = '';
					$GLOBALS['CustomerPhone'] = '';

					if ($row['ordcustemail'] != '') {
						$GLOBALS['CustomerEmail'] = '<span style="width: 55px; float:left;">' . GetLang('OrderInvoiceEmail') . ':</span> '. isc_html_escape($row['ordcustemail']);
					}
					if ($row['ordcustphone'] != '') {
						$GLOBALS['CustomerPhone'] = '<span style="width: 55px; float:left;">' . GetLang('OrderInvoicePhone') . ':</span> '. isc_html_escape($row['ordcustphone']);
					}

					$GLOBALS['CustomerDetails'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("InvoiceCustomerDetails");

					// Format the billing address
					$GLOBALS['ShipFullName'] = isc_html_escape($row['ordbillfirstname'].' '.$row['ordbilllastname']);

					$GLOBALS['ShipCompany'] = '';
					if($row['ordbillcompany']) {
						$GLOBALS['ShipCompany'] = '<br />'.isc_html_escape($row['ordbillcompany']);
					}

					$GLOBALS['ShipAddressLine1'] = isc_html_escape($row['ordbillstreet1']);

					if($row['ordbillstreet2'] != "") {
						$GLOBALS['ShipAddressLine2'] = isc_html_escape($row['ordbillstreet2']);
					} else {
						$GLOBALS['ShipAddressLine2'] = '';
					}

					$GLOBALS['ShipSuburb'] = isc_html_escape($row['ordbillsuburb']);
					$GLOBALS['ShipState'] = isc_html_escape($row['ordbillstate']);
					$GLOBALS['ShipZip'] = isc_html_escape($row['ordbillzip']);
					$GLOBALS['ShipCountry'] = isc_html_escape($row['ordbillcountry']);

					$GLOBALS['ShipPhone'] = "";
					$GLOBALS['BillingAddress'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("AddressLabel");

					// Is there a shipping address, or is it a digital download?
					if ($row['ordshipfirstname'] == "") {
						$GLOBALS['ShippingAddress'] = GetLang('NA');
					}
					else {
						$GLOBALS['ShipFullName'] = isc_html_escape($row['ordshipfirstname'].' '.$row['ordshiplastname']);

						$GLOBALS['ShipCompany'] = '';
						if($row['ordshipcompany']) {
							$GLOBALS['ShipCompany'] = '<br />'.isc_html_escape($row['ordshipcompany']);
						}

						$GLOBALS['ShipAddressLine1'] = isc_html_escape($row['ordshipstreet1']);

						if($row['ordshipstreet2'] != "") {
							$GLOBALS['ShipAddressLine2'] = isc_html_escape($row['ordshipstreet2']);
						} else {
							$GLOBALS['ShipAddressLine2'] = '';
						}

						$GLOBALS['ShipSuburb'] = isc_html_escape($row['ordshipsuburb']);
						$GLOBALS['ShipState'] = isc_html_escape($row['ordshipstate']);
						$GLOBALS['ShipZip'] = isc_html_escape($row['ordshipzip']);
						$GLOBALS['ShipCountry'] = isc_html_escape($row['ordshipcountry']);

						$GLOBALS['ShipPhone'] = "";
						$GLOBALS['ShippingAddress'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("AddressLabel");
					}

					// Get the products in the order
					$query = sprintf("select * from [|PREFIX|]order_products where orderorderid='%s'", $GLOBALS['ISC_CLASS_DB']->Quote($order_id));
					$pResult = $GLOBALS['ISC_CLASS_DB']->Query($query);

					$GLOBALS['ProductsTable'] = "";
					$wrappingTotal = 0;

					while ($pRow = $GLOBALS['ISC_CLASS_DB']->Fetch($pResult)) {
						$numProds++;

						if ($pRow['ordprodtype'] == 2) {
							$numDL++;
						}
						else {
							$numPhy++;

							if ($pRow['ordprodsku'] != "") {
								$sku = $pRow['ordprodsku'];
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

							$prodCost = CurrencyConvertFormatPrice($pRow['ordprodcost'], $row['ordcurrencyid'], $row['ordcurrencyexchangerate']);

							if($pRow['ordprodwrapcost'] > 0) {
								$wrappingTotal += $pRow['ordprodwrapcost'] * $pRow['ordprodqty'];
							}

							$giftOptions = '';
							if($pRow['ordprodwrapname']) {
								$giftOptions .= "<br /><small>".GetLang('GiftWrapping').": ".isc_html_escape($pRow['ordprodwrapname'])."</small>";
							}

							$GLOBALS['ProductsTable'] .= sprintf("

								<tr>
									<td>%s</td>
									<td>%s</td>
									<td>%s</td>
									<td>%s</td>
								</tr>

							", $pRow['ordprodqty'], $sku, isc_html_escape($pRow['ordprodname']).$pOptions.$giftOptions, $prodCost);
						}
					}

					if($wrappingTotal > 0) {
						$GLOBALS['GiftWrappingTotal'] = CurrencyConvertFormatPrice($wrappingTotal, $row['ordcurrencyid'], $row['ordcurrencyexchangerate']);
					}
					else {
						$GLOBALS['HideGiftwrappingTotal'] = 'display: none';
					}

					if ($numDL == $numProds) {
						$GLOBALS['CloseWindow'] = "1";
					}

					$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("invoice_print");
					$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
				}
				else {
					echo "<script type=\"text/javascript\">window.close();</script>";
				}
			}
			else {
				echo "<script type=\"text/javascript\">window.close();</script>";
			}
		}

		private function AddressBook()
		{

			$GLOBALS['FromURL'] = urlencode("account.php?action=address_book");
			$GLOBALS['HideAddressButton'] = "none";
			$GLOBALS['CheckoutShippingTitle'] = GetLang('YourAddressBook');
			$GLOBALS['CheckoutShippingIntro'] = sprintf("%s <a href='%s/account.php?action=add_shipping_address&amp;address_type=&amp;from=%s'>%s</a>", GetLang('AddressBookIntro1'), $GLOBALS['ShopPath'], $GLOBALS['FromURL'], GetLang('AddressBookIntro2'));

			// Show the list of available shipping addresses
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetPageTitle(GetConfig('StoreName') . " - " . GetLang('YourAddressBook'));
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("account_addressbook");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}

		/**
		*	Load the customer's details and return them in an array or false on error.
		*/
		public function GetAccountDetails()
		{

			// Get the id of the customer
			$customer_id = $GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerId();

			$query = sprintf("select * from [|PREFIX|]customers where customerid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($customer_id));
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			if ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				return $row;
			}
			else {
				return false;
			}
		}

		private function EditAccount($MessageText = "", $MessageStatus = -1)
		{

			// Have we just saved the account details? If so show the appropriate message box
			if ($MessageStatus == -1) {
				$GLOBALS['HideEditAccountErrorMessage'] = "none";
				$GLOBALS['HideEditAccountSuccessMessage'] = "none";
			}
			else if ($MessageStatus == MSG_SUCCESS) {
				$GLOBALS['HideEditAccountErrorMessage'] = "none";
				$GLOBALS['HideEditAccountIntroMessage'] = "none";
				$GLOBALS['StatusMessage'] = $MessageText;

			}
			else if ($MessageStatus == MSG_ERROR) {
				$GLOBALS['HideEditAccountSuccessMessage'] = "none";
				$GLOBALS['HideEditAccountIntroMessage'] = "none";
				$GLOBALS['StatusMessage'] = $MessageText;
			}

			// Load the account details for this user
			if ($customer_details = $this->GetAccountDetails()) {
				$GLOBALS['AccountFirstName'] = isc_html_escape($customer_details['custconfirstname']);
				$GLOBALS['AccountLastName'] = isc_html_escape($customer_details['custconlastname']);
				$GLOBALS['AccountCompanyName'] = isc_html_escape($customer_details['custconcompany']);
				$GLOBALS['AccountPhone'] = isc_html_escape($customer_details['custconphone']);
				$GLOBALS['AccountCurrentEmail'] = isc_html_escape($customer_details['custconemail']);
				$GLOBALS['EditAccountAccountFormFieldID'] = FORMFIELDS_FORM_ACCOUNT;
				$GLOBALS['AccountFields'] = '';

				if ($MessageStatus !== -1) {
					$fillPostedValues = true;
				} else {
					$fillPostedValues = false;
				}

				if (!$fillPostedValues && isId($customer_details['custformsessionid'])) {
					$fields = $GLOBALS['ISC_CLASS_FORM']->getFormFields(FORMFIELDS_FORM_ACCOUNT, false, $customer_details['custformsessionid']);
				} else {
					$fields = $GLOBALS['ISC_CLASS_FORM']->getFormFields(FORMFIELDS_FORM_ACCOUNT, $fillPostedValues);
				}

				$GLOBALS['AccountFields'] = '';

				foreach (array_keys($fields) as $fieldId) {

					/**
					 * Fill in the email address if we have just entered the page for the first time
					 */
					if (!$fillPostedValues && isc_strtolower($fields[$fieldId]->record['formfieldprivateid']) == 'emailaddress') {
						$fields[$fieldId]->setValue($customer_details['custconemail']);
					}

					/**
					 * Un-require the password and confirm password
					 */
					if (isc_strtolower($fields[$fieldId]->record['formfieldprivateid']) == 'password' || isc_strtolower($fields[$fieldId]->record['formfieldprivateid']) == 'confirmpassword') {
						$fields[$fieldId]->setRequired(false);
					}

					$GLOBALS['AccountFields'] .= $fields[$fieldId]->loadForFrontend() . "\n";
				}

				/**
				 * Load up any form field JS event data and any validation lang variables
				 */
				$GLOBALS['FormFieldRequiredJS'] = $GLOBALS['ISC_CLASS_FORM']->buildRequiredJS();

				// Show the list of available shipping addresses
				$GLOBALS['ISC_CLASS_TEMPLATE']->SetPageTitle(GetConfig('StoreName') . " - " . GetLang('YourAccountDetails'));
				$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("editaccount");
				$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
			}
			else {
				// Possible session timeout
				ob_end_clean();
				header(sprintf("Location:%s/account.php", $GLOBALS['ShopPath']));
				die();
			}
		}

		/**
		*	Save the edited account details back to the database
		*/
		public function SaveAccountDetails()
		{
			/**
			 * Customer Details
			 */
			$customerMap = array(
				'EmailAddress' => 'account_email',
				'Password' => 'account_password',
				'ConfirmPassword' => 'account_password_confirm'
			);

			$fields = $GLOBALS['ISC_CLASS_FORM']->getFormFields(FORMFIELDS_FORM_ACCOUNT, true);

			/**
			 * Validate the field input. Unset the password and confirm password fields first
			 */
			foreach (array_keys($fields) as $fieldId) {
				if (isc_strtolower($fields[$fieldId]->record['formfieldprivateid']) == 'password' || isc_strtolower($fields[$fieldId]->record['formfieldprivateid']) == 'confirmpassword') {
					$fields[$fieldId]->setRequired(false);
				}
			}

			$errmsg = '';
			if (!$this->validateFieldData($fields, $errmsg)) {
				return $this->EditAccount($errmsg, MSG_ERROR);
			}

			foreach(array_keys($fields) as $fieldId) {
				if (!array_key_exists($fields[$fieldId]->record['formfieldprivateid'], $customerMap)) {
					continue;
				}

				$_POST[$customerMap[$fields[$fieldId]->record['formfieldprivateid']]] = $fields[$fieldId]->GetValue();
			}

			$customer_id = $GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerId();
			$email_taken = false;
			$phone_invalid = false;
			$password_invalid = false;

			if (isset($_POST['account_firstname']) &&
			   isset($_POST['account_lastname']) &&
			   isset($_POST['account_companyname']) &&
			   isset($_POST['account_email']) &&
			   isset($_POST['account_phone']) &&
			   isset($_POST['account_password']) &&
			   isset($_POST['account_password_confirm'])) {

					// Are they updating their email address? If so is the new email address available?
					if ($GLOBALS['ISC_CLASS_CUSTOMER']->AccountWithEmailAlreadyExists($_POST['account_email'], $customer_id)) {
						$email_taken = true;
					}

					if (!$GLOBALS['ISC_CLASS_CUSTOMER']->ValidatePhoneNumber($_POST['account_phone'])) {
						$phone_invalid = true;
					}

					$pass1 = $_POST['account_password'];
					$pass2 = $_POST['account_password_confirm'];

					if ($pass1 . $pass2 !== '' && $pass1 !== $pass2) {
						$password_invalid = true;
					}

					if (!$email_taken && !$phone_invalid && !$password_invalid) {

						$UpdatedAccount = array(
							"customerid" => $customer_id,
							"firstname" => $_POST['account_firstname'],
							"lastname" => $_POST['account_lastname'],
							"company" => $_POST['account_companyname'],
							"email" => $_POST['account_email'],
							"phone" => $_POST['account_phone']
						);

						// Do we need to update the password?
						if ($pass1 == $pass2 && $pass1 != "") {
							$UpdatedAccount['password'] = $pass1;
						}

						$entity = new ISC_ENTITY_CUSTOMER();
						$existingCustomer = $entity->get($customer_id);

						/**
						 * Create/Update our form session data
						 */
						if (isId($existingCustomer['custformsessionid'])) {
							$GLOBALS['ISC_CLASS_FORM']->saveFormSession(FORMFIELDS_FORM_ACCOUNT, true, $existingCustomer['custformsessionid']);
						} else {
							$UpdatedAccount['custformsessionid'] = $GLOBALS['ISC_CLASS_FORM']->saveFormSession(FORMFIELDS_FORM_ACCOUNT);
						}

						if ($entity->edit($UpdatedAccount)) {
							$this->EditAccount(GetLang('AccountDetailsUpdatedSuccess'), MSG_SUCCESS);
						} else {
							$this->EditAccount(GetLang('AccountDetailsUpdatedFailed'), MSG_ERROR);
						}

					}
					else if ($email_taken) {
						// Email address is already taken
						$this->EditAccount(sprintf(GetLang('AccountUpdateEmailTaken'), $_POST['account_email']), MSG_ERROR);
					}
					else if ($phone_invalid) {
						// Phone number is invalid
						$this->EditAccount(sprintf(GetLang('AccountUpdateValidPhone'), $_POST['account_phone']), MSG_ERROR);
					}
					else if ($password_invalid) {
						$this->EditAccount(GetLang('AccountPasswordsDontMatch'), MSG_ERROR);
					}
			}
			else {
				ob_end_clean();
				header(sprintf("Location: %s/account.php", $GLOBALS['ShopPath']));
				die();
			}
		}

		/**
		*	Show a list of items that the customer has recently viewed by browsing our site
		*/
		private function ShowRecentItems()
		{

			$viewed = "";

			if (isset($_COOKIE['RECENTLY_VIEWED_PRODUCTS'])) {
				$viewed = $_COOKIE['RECENTLY_VIEWED_PRODUCTS'];
			} else if (isset($_SESSION['RECENTLY_VIEWED_PRODUCTS'])) {
				$viewed = $_SESSION['RECENTLY_VIEWED_PRODUCTS'];
			}

			if ($viewed != "") {
				$GLOBALS['HideNoRecentItemsMessage'] = "none";
				$GLOBALS['SNIPPETS']['AccountRecentItems'] = "";

				$viewed_products = array();
				$viewed_products = explode(",", $viewed);
				foreach ($viewed_products as $k => $p) {
					$viewed_products[$k] = (int) $p;
				}

				// Reverse the array so recently viewed products appear up top
				$viewed_products = array_reverse($viewed_products);

				// Hide the compare button if there's less than 2 products
				if (GetConfig('EnableProductComparisons') == 0 || count($viewed_products) < 2) {
					$GLOBALS['HideCompareItems'] = "none";
				}

				if (count($viewed_products) > 0) {
					if(GetConfig('EnableProductReviews') == 0) {
						$GLOBALS['HideProductRating'] = "display: none";
					}
					$query = "
						SELECT p.*, FLOOR(prodratingtotal/prodnumratings) AS prodavgrating, imageisthumb, imagefile, ".GetProdCustomerGroupPriceSQL()."
						FROM [|PREFIX|]products p
						LEFT JOIN [|PREFIX|]product_images pi ON (productid=pi.imageprodid AND imageisthumb=1)
						WHERE prodvisible='1' AND productid in ('".implode("','", $viewed_products)."')
						".GetProdCustomerGroupPermissionsSQL()."
					";
					$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
					if ($GLOBALS['ISC_CLASS_DB']->CountResult($result) > 0) {
						$GLOBALS['AlternateClass'] = '';
						while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
							if($GLOBALS['AlternateClass'] == 'Odd') {
								$GLOBALS['AlternateClass'] = 'Even';
							}
							else {
								$GLOBALS['AlternateClass'] = 'Odd';
							}

							$GLOBALS['ProductId'] = (int) $row['productid'];
							$GLOBALS['ProductName'] = isc_html_escape($row['prodname']);
							$GLOBALS['ProductLink'] = ProdLink($row['prodname']);
							$GLOBALS['ProductRating'] = (int)$row['prodavgrating'];

							// Determine the price of this product
							$GLOBALS['ProductPrice'] = CalculateProductPrice($row);

							$GLOBALS['ProductThumb'] = ImageThumb($row['imagefile'], ProdLink($row['prodname']));

							$GLOBALS['SNIPPETS']['AccountRecentItems'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("AccountRecentlyViewedProducts");
						}
					}
				}
				else {
					$GLOBALS['HideRecentItemList'] = "none";
				}
			}
			else {
				$GLOBALS['HideRecentItemList'] = "none";
			}

			$GLOBALS['CompareLink'] = CompareLink();

			// Show the list of available shipping addresses
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetPageTitle(GetConfig('StoreName') . " - " . GetLang('RecentlyViewedItems'));
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("account_recentitems");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}


		/**
		* Get the list of items in an order that are not re-orderable
		* @param array the item details in the order
		* @param array lists of product ids in the order
		*
		* @return array list of unreorderable products
		*/
		private function GetUnreorderableProducts($OrderProducts, $ProductIds)
		{
			$UnreorderableProducts = array();
			if(empty($OrderProducts) || empty($ProductIds)) {
				return $UnreorderableProducts;
			}

			$ValidProductIds = array();
			$ProductInventory = array();
			$ValidVariations = array();
			$ProductsRequireVariations = array();
			$ProdductWrapIDs = array();
			$ConfigFieldChangedProds = array();
			$GiftWrapIds = array();

			$orderProductIds = implode(',', array_unique($ProductIds));


			//Get giftwraping details
			$query = "SELECT wrapid FROM [|PREFIX|]gift_wrapping";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$GiftWrapIds[] = $row['wrapid'];
			}

			//Get the current product and product variation information for the ordered products
			$query = "SELECT p.productid, p.prodname, p.prodcurrentinv, p.prodinvtrack, p.prodoptionsrequired, p.prodwrapoptions, p.prodvariationid, p.prodeventdaterequired, p.prodeventdatelimited, p.prodeventdatelimitedtype,p.prodeventdatelimitedstartdate, p.prodvisible, p.prodallowpurchases,p.prodeventdatelimitedenddate, vc.vcenabled, vc.combinationid, vc.vcstock
						FROM [|PREFIX|]products p
						LEFT JOIN [|PREFIX|]product_variation_combinations vc
						ON vc.vcproductid = p.productid
						WHERE p.productid IN (".$orderProductIds.")";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			while($ProdDetail = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {

				if(!in_array($ProdDetail['productid'], $ValidProductIds)) {
					$ValidProductIds[] = $ProdDetail['productid'];

					$ProductInventory[$ProdDetail['productid']] = array(
											'currentinv' => $ProdDetail['prodcurrentinv'],
											'invtrack' => $ProdDetail['prodinvtrack']
										);

					if($ProdDetail['prodoptionsrequired'] == 1 && $ProdDetail['prodvariationid'] != 0) {
						$ProductsRequireVariations[] = $ProdDetail['productid'];
					}

					$ProductEventDate[$ProdDetail['productid']] = array(
								'Required' => $ProdDetail['prodeventdaterequired'],
								'LimitEnabled' => $ProdDetail['prodeventdatelimited'],
								'LimitType' => $ProdDetail['prodeventdatelimitedtype'],
								'StartDate' => $ProdDetail['prodeventdatelimitedstartdate'],
								'EndDate' => $ProdDetail['prodeventdatelimitedenddate']
					);
					//store giftwraping details
					$ProductWrapIDs[$ProdDetail['productid']] = $ProdDetail['prodwrapoptions'];
					$ProductVisibility[$ProdDetail['productid']] = $ProdDetail['prodvisible'];
					$ProductAllowPurchase[$ProdDetail['productid']] = $ProdDetail['prodallowpurchases'];
				}

				//ser prduct inventory data
				if($ProdDetail['prodinvtrack'] == 1) {
					if(!isset($ProductInventory[$ProdDetail['productid']])) {
						$ProductInventory[$ProdDetail['productid']] = array(
											'currentinv' => $ProdDetail['prodcurrentinv'],
											'invtrack' => $ProdDetail['prodinvtrack']
										);
					}
				} else if($ProdDetail['prodinvtrack'] == 2) {
						$ProductInventory[$ProdDetail['productid']]['invtrack'] = $ProdDetail['prodinvtrack'];
						$ProductInventory[$ProdDetail['productid']][$ProdDetail['combinationid']] = $ProdDetail['vcstock'];
				}

				if($ProdDetail['vcenabled']) {
					$ValidVariations[$ProdDetail['productid']][] = $ProdDetail['combinationid'];
				}


			}

			//for each ordered products, if the variation combinations is still a valid combination
			foreach ($OrderProducts as $OrderProduct) {
				//if the product doesn't exist or visible or allow purchase anymore
				if(!in_array($OrderProduct['ordprodid'], $ValidProductIds) || $ProductVisibility[$OrderProduct['ordprodid']] == 0 || $ProductAllowPurchase[$OrderProduct['ordprodid']] == 0) {
					$UnreorderableProducts[$OrderProduct['orderprodid']] = GetLang('ProductNotExist');
					continue;
				}

				//if gift wrapping option is invalid
				if(!$this->IsGiftWrappingValid($OrderProduct['ordprodwrapid'], $ProductWrapIDs[$OrderProduct['ordprodid']], $GiftWrapIds)) {
					$UnreorderableProducts[$OrderProduct['orderprodid']] = GetLang('GiftWrappingChanged');
					continue;
				}


				if(!$this->IsProductInStock($ProductInventory, $OrderProduct)) {
					$UnreorderableProducts[$OrderProduct['orderprodid']] = GetLang('ProductOutOfStock');
					continue;
				}

				if($this->HasProductVariationsChanged($OrderProduct, $ProductsRequireVariations, $ValidVariations)) {
					$UnreorderableProducts[$OrderProduct['orderprodid']] = GetLang('VariationCombinationChanged');
					continue;
				}

				if(!$this->IsEventDateValid($OrderProduct['ordprodeventdate'], $ProductEventDate[$OrderProduct['ordprodid']])) {
					$UnreorderableProducts[$OrderProduct['orderprodid']] = GetLang('EventDateChanged');
					continue;
				}
			}

			//Check the configurable fields for the products that have passed the previous checks
			$OrderableProducts = array_diff(array_keys($OrderProducts), $UnreorderableProducts);
			if(!empty($OrderableProducts)) {
				foreach($OrderableProducts as $OrdProdId) {
					$FurtherCheckingProducts[$OrdProdId] = $OrderProducts[$OrdProdId]['ordprodid'];
				}
				$ConfigFieldChangedProds = $this->GetConfigFieldsChangedProds($FurtherCheckingProducts);
			}
			$UnreorderableProducts = $UnreorderableProducts+$ConfigFieldChangedProds;
			return $UnreorderableProducts;
		}

		private function IsEventDateValid($OrdProdEventDate, $ProductEventDate)
		{
			//if evendate entered in the order, check if it's still valid
			if($OrdProdEventDate>0) {
				//no eventdate for this product anymore
				if($ProductEventDate['Required']==0) {
					return false;
				}
				switch ($ProductEventDate['LimitType']) {
					case '2': //if limit start date
						if($OrdProdEventDate<$ProductEventDate['StartDate']) {
							return false;
						}
						break;
					case '3': //if limit start date
						if($OrdProdEventDate>$ProductEventDate['EndDate']) {
							return false;
						}
						break;
					default://if limit between a date range
						if($OrdProdEventDate<$ProductEventDate['StartDate'] || $OrdProdEventDate>$ProductEventDate['EndDate']) {
							return false;
						}
						break;
				}

			// if evendate is not entered in the order, check if evendate is required
			} else {
				//if product event date is required
				if($ProductEventDate['Required']==1) {
					return false;
				}
			}
			return true;
		}

		private function IsGiftWrappingValid($OrdProdWrapId, $ProductWrapIDs, $GiftWrapIds)
		{

				if($OrdProdWrapId != 0) {

					switch ($ProductWrapIDs) {
						//product is not allowed to be gift wrapped
						case '-1': {
							return false;
						}
						//all gift wrapping options can be used for this item
						case '0': {
							if(!in_array($OrdProdWrapId, $GiftWrapIds)) {
								return false;
							}
							break;
						}
						//selected gift wrapping options can be used for this item
						default: {
							if(!in_array($OrdProdWrapId, explode(',', $ProductWrapIDs))) {
								return false;
							}
							break;
						}
					}
				}
				return true;
		}


		private function GetConfigFieldsChangedProds($OrderProducts)
		{
			$UnreorderableProducts = array();
			$ProductRequiredFields = array();
			$ProductFields = array();
			$OrdProdFields = array();
			$orderProductIds = implode(",", array_keys($OrderProducts));


			//Get the configurable field ids from the previous order for this product
			$query = "SELECT fieldid, productid,  ordprodid
						FROM [|PREFIX|]order_configurable_fields o
						WHERE o.ordprodid IN (".$orderProductIds.")";

			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$OrdProdFields[$row['ordprodid']]['productid'] = $row['productid'];
				$OrdProdFields[$row['ordprodid']]['ordprodfieldid'][] = $row['fieldid'];
			}

			$ProductIds = implode(",", $OrderProducts);
			$query = "SELECT productfieldid, fieldrequired,fieldprodid
						FROM [|PREFIX|]product_configurable_fields
						WHERE fieldprodid in (".$ProductIds.")";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$ProductFields[$row['fieldprodid']][] = $row['productfieldid'];
				//get required fields for product
				if($row['fieldrequired']==1) {
					$ProductRequiredFields[$row['fieldprodid']][] = $row['productfieldid'];
				}
			}

			foreach($OrderProducts as $OrdProdId => $ProductId) {
				//if the prodcut has got configurable fields
				if(isset($ProductFields[$ProductId]) && !empty($ProductFields[$ProductId])) {

					if(isset($OrdProdFields[$OrdProdId]['ordprodfieldid'])) {
						//if all fields that were entered in the previous order are valid
						$InvalidFields = array_diff($OrdProdFields[$OrdProdId]['ordprodfieldid'], $ProductFields[$ProductId]);
						if(!empty($InvalidFields)) {
							$UnreorderableProducts[$OrdProdId] = GetLang('VariationCombinationChanged');
							continue;
						}
					}

					//if required fields weren't entered in the previous order item
					if(isset($ProductRequiredFields[$ProductId])) {
						//if the product in the order has also got configurable fields
						if(isset($OrdProdFields[$OrdProdId]['ordprodfieldid'])) {
							$MissingRequiredFields = array_diff($ProductRequiredFields[$ProductId], $OrdProdFields[$OrdProdId]['ordprodfieldid']);

							if(!empty($MissingRequiredFields)) {
								$UnreorderableProducts[$OrdProdId] =  GetLang('VariationCombinationChanged');
								continue;
							}
						//if no configuarable fields have been entered for the product in the previous order.
						} else {
							$UnreorderableProducts[$OrdProdId] = GetLang('VariationCombinationChanged');
							continue;
						}
					}
				//if the product doesn't have any configurable fields but the ordered product has got entries for it.
				} elseif(isset($OrdProdFields[$OrdProdId]['ordprodfieldid']) && !empty($OrdProdFields[$OrdProdId]['ordprodfieldid'])) {
						$UnreorderableProducts[$OrdProdId] = GetLang('VariationCombinationChanged');
						continue;
				}
			}
			return $UnreorderableProducts;
		}

		private function IsProductInStock(&$ProductInventory, $OrderProduct)
		{
			//check inventory level if the inventory track on the main product
			if($ProductInventory[$OrderProduct['ordprodid']]['invtrack'] == 1){
				if($ProductInventory[$OrderProduct['ordprodid']]['currentinv'] < $OrderProduct['ordprodqty']) {
					return false;
				} else {
					$ProductInventory[$OrderProduct['ordprodid']]['currentinv'] -= $OrderProduct['ordprodqty'];
				}
			//Check product inventory for variation
			} else if($ProductInventory[$OrderProduct['ordprodid']]['invtrack'] == 2) {
				if(isset($ProductInventory[$OrderProduct['ordprodid']][$OrderProduct['ordprodvariationid']])) {
					$CurrentInv = $ProductInventory[$OrderProduct['ordprodid']][$OrderProduct['ordprodvariationid']];

					if($CurrentInv < $OrderProduct['ordprodqty']) {
						return false;
					} else {
						$ProductInventory[$OrderProduct['ordprodid']][$OrderProduct['ordprodvariationid']] -= $OrderProduct['ordprodqty'];
					}
				}
			}
			return true;
		}

		private function HasProductVariationsChanged($OrderProduct, $ProductsRequireVariations, $ValidVariations)
		{
			//if no variation is selected in the previous order, Check if the product has a force variation now
			if ($OrderProduct['ordprodvariationid'] == 0) {
				//if the product is one of the products that requires variaions, then it's not reorderable
				if (in_array($OrderProduct['ordprodid'], $ProductsRequireVariations)) {
					return true;
				}

			//otherwise variation is selected in the previous order, check if the variation is still valid
			} else {
				//if the ordered product variation id is a valid variation combination ID for the product
				if(!in_array($OrderProduct['ordprodvariationid'], $ValidVariations[$OrderProduct['ordprodid']])) {
					return true;
				}
			}
			return false;
		}

		/**
		* Check if any items in the order cannot be re-ordered
		* Redirect users to the order details page if some items cant be re-ordered
		* Add products to cart if all items can be re-ordered.
		*
		*/
		private function DoReorder()
		{
			$OrderId = $_REQUEST['order_id'];
			$ProductIds = array();

			// Load up the items in this order
			$query = "SELECT *
						FROM [|PREFIX|]orders o
						LEFT JOIN [|PREFIX|]order_products p
						ON p.orderorderid = o.orderid
						WHERE orderorderid=".(int)$OrderId;

			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			//check if products are reorderable
			while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$OrderProducts[$row['orderprodid']] = $row;
				$ProductIds[] = $row['ordprodid'];
			}
			$ProductIds = array_unique($ProductIds);
			$UnreorderableProducts = $this->GetUnreorderableProducts($OrderProducts, $ProductIds);
			$GLOBALS['ErrorMessage'] = '';
			if(!empty($UnreorderableProducts)) {
				FlashMessage(GetLang("ItemsCantBeReordered"), MSG_ERROR);
				ob_end_clean();
				header(sprintf("Location: %s/account.php?action=view_order&order_id=%s&reorder=1", $GLOBALS['ShopPath'], $OrderId));
			} else {
				ob_end_clean();
				header(sprintf("Location: %s/cart.php?action=addreorderitems&orderid=%s", $GLOBALS['ShopPath'], $OrderId));

			}
		}
		// add by johnny 2011-06-01 for mutil upload image
		
		function checkUpload(){
			if($_POST['starsubmit']){
				$captcha = trim($_POST['captcha']);
				$uploaderFirstName = trim($_POST['uploaderFirstName']);
				$uploaderLastName = trim($_POST['uploaderLastName']);
				$address1 = trim($_POST['address1']);
				$address2 = trim($_POST['address2']);
				if(isc_strtolower($captcha) == isc_strtolower($GLOBALS['ISC_CLASS_CAPTCHA']->LoadSecret())) {	
					// Captcha validation succeeded	
					$captcha_check = true;
				}else {	
					// Captcha validation failed	
					$captcha_check = false;
				}
				
				if(strlen($uploaderFirstName) <= 0 ) {
					$error_msg = 'Please enter your valid first name.';
					echo "<script>";
					echo "parent.error_msg = '$error_msg';";
					echo "parent.showErrorMessage();";
					echo "</script>";
				}elseif(strlen($uploaderLastName) <= 0 ) {
					$error_msg = 'Please enter your valid last name.';
					echo "<script>";
					echo "parent.error_msg = '$error_msg';";
					echo "parent.showErrorMessage();";
					echo "</script>";
				}elseif(strlen($address1) < 5) {
					$error_msg = 'Please enter your valid address.';
					echo "<script>";
					echo "parent.error_msg = '$error_msg';";
					echo "parent.showErrorMessage();";
					echo "</script>";
				}elseif(strlen($address2) < 5) {
					$error_msg = 'Please enter your valid address.';
					echo "<script>";
					echo "parent.error_msg = '$error_msg';";
					echo "parent.showErrorMessage();";
					echo "</script>";
				}elseif(!$captcha_check) {
					$error_msg = 'Invalid random character entry, please try again.';
					echo "<script>";
					echo "parent.error_msg = '$error_msg';";
					echo "parent.showErrorMessage();";
					echo "</script>";
				}else {
					echo "<script>";
					echo "parent.no_insert = 1;";
					echo "parent.error_msg = '';";
					echo "parent.start_upload();";
					echo "</script>";
				}
				exit();
			}
		}
		
		function pics_save($_FILES, $description, $firstName, $lastName, $address1, $address2){
			$description = trim($description);
			$firstName = trim($firstName);
			$lastName = trim($lastName);
			$address1 = trim($address1);
			$address2 = trim($address2);
			$tempFile = $_FILES['tmp_name'];
			$rootdir = ISC_BASE_PATH;
			//$allowpictypes = array(1, 2, 3, 6, 7, 8);
			$allowpictypestr = GetConfig('LimitCustomerUploadImageFileType');
			$allowpictypes = explode(',', $allowpictypestr);
			
			// get file ext
			$single_type = exif_imagetype($tempFile);
			$picExt = '';
			switch($single_type){
				case 1:
					$picExt = '.gif';
					break;
				case 2:
					$picExt = '.jpg';
					break;
				case 3:
					$picExt = '.png';
					break;
				case 4:
					$picExt = '.swf';
					break;
				case 6:
					$picExt = '.bmp';
					break;
				case 7:
					$picExt = '.tiff';
					break;
				case 8:
					$picExt = '.tiff';
					break;	
			}
			
			$allowCustomerUploadMaxNum = GetConfig('LimitCustomerUploadImageNum');
			$customerId = $GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerId();
			$imgNumQuery = "
				SELECT imagenum
				FROM [|PREFIX|]customers
				WHERE customerid='".(int)$customerId."'";	
			$imgNumResult = $GLOBALS['ISC_CLASS_DB']->Query($imgNumQuery);
			$imagenum = $GLOBALS['ISC_CLASS_DB']->FetchOne($imgNumResult);
			if(!in_array($single_type, $allowpictypes)){
			       $status = 0;
			       $message = "Invalid type of file!";
			       $errorCode = -1;
			}elseif(strlen($description) > 1000){
				$status = 0;
				$message = "Description should not surpass 1000 characters!";
				$errorCode = -2;
			}elseif(strlen($description) <= 0){
				$status = 0;
				$message = "You must enter a description for each image submitted!";
				$errorCode = -3;
			}elseif($imagenum >= $allowCustomerUploadMaxNum){
				$status = 0;
				$message = "You cannot upload more than $allowCustomerUploadMaxNum images.";
				$errorCode = -4;
			}  else {
				$targetPath = $rootdir . '/upload/' . date('ymd', time()) . '/';
				$fileName = time() . md5(mt_rand(0, 999999)) . $picExt; 
				$path = '/upload/' . date('ymd', time()) . '/' . $fileName;
				$targetFile = $rootdir . $path;
				mkdir(str_replace('//','/',$targetPath), 0755, true);       
				if(move_uploaded_file($tempFile, $targetFile)){
					$CustomerId = $GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerId();
					$NewPicture = array(
						"customerid" => $CustomerId,
						"path" => $path,
						"description" => $description,
						"filename" => $_FILES['name'],
						"dateline" => time(),
						"uploaderFirstName" => $firstName,
						"uploaderLastName" => $lastName,
						"address1" => $address1,
						"address2" => $address2
					);
					if($GLOBALS['ISC_CLASS_DB']->InsertQuery("pic", $NewPicture)){
						$query1 = "UPDATE [|PREFIX|]customers set imagenum = imagenum + 1 where customerid = '$CustomerId'";
						$result = $GLOBALS["ISC_CLASS_DB"]->Query($query1);
					}
					$status = 1;
					$errorCode = 0;
					$message = "Upload successfully";
				}	
			}
			//echo serialize(array("status" => $status, "errorCode" => $errorCode, "message" => $message));
			echo isc_json_encode(array("status" => $status, "errorCode" => $errorCode, "message" => $message));
			exit();
		}
		function UploadImages(){
			$GLOBALS['ISC_CLASS_CAPTCHA'] = GetClass('ISC_CAPTCHA');
			$this -> checkUpload();
			
			// save pic
			if($_POST['swfUpload']){
				$this -> pics_save($_FILES['Filedata'], $_POST['imageDesc'], $_POST['uploaderFirstName'], $_POST['uploaderLastName'], $_POST['address1'], $_POST['address2']);	
			}
			$this -> displayPage();
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetPageTitle(GetConfig('StoreName') . " - " . GetLang('Uploadimage'));
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("account_uploadimages");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();	
		}
		
		function sendImageUploaderEmail(){
			if($_POST['sendEmail']){
				$customerid = $GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerId();	
				$sql1 = "SELECT image_last_upload
					FROM [|PREFIX|]customers
					WHERE customerid='".(int)$customerid."'";
				$result1 = $GLOBALS['ISC_CLASS_DB']->Query($sql1);
				$uploadNum = $GLOBALS['ISC_CLASS_DB']->FetchOne($result1);
				
				if($uploadNum <= 0){
					// don't send email
					return false;
				}else{
					$subject = 'Upload Image Notification';
					$message = "$uploadNum photo(s) have just been uploaded to TruckChamp.com";
					$name = "Administrator";
					$to = GetConfig("ImageUploaderSettingsNotifyEmail");
					require_once(ISC_BASE_PATH . "/lib/email.php");
					$obj_email = GetEmailClass();
					$obj_email->Set('CharSet', GetConfig('CharacterSet'));
					$obj_email->From(GetConfig('OrderEmail'), $name);
					$obj_email->Set('ReplyTo', GetConfig('OrderEmail'));
					$obj_email->Set("Subject", $subject);
					$obj_email->AddBody("html", $message);
					$obj_email->AddRecipient($to, "", "h");
					$email_result = $obj_email->Send();
					if($email_result){
						$customerEntity = new ISC_ENTITY_CUSTOMER;
						$customerEntity->clearImageLastUpload($GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerId());
					}else{
						return false;
					}
				}
			}else{
				return false;
			}
		}
		
		// add by johnny 2011-05-19 for upload image
		function pic_save($FILE, $description, $firstName, $lastName, $address1, $address2){
			$description = trim($description);
			$firstName = trim($firstName);
			$lastName = trim($lastName);
			$address1 = trim($address1);
			$address2 = trim($address2);
			
			$allowFileSize = GetConfig("LimitCustomerUploadImageSize");
			//$allowpictypes = array(1, 2, 3, 6, 7, 8);
			$allowpictypestr = GetConfig('LimitCustomerUploadImageFileType');
			$allowpictypes = explode(',', $allowpictypestr);
			
			$single_type = exif_imagetype($FILE['tmp_name']);
			
			$customerId = $GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerId();
			$imgNumQuery = "
				SELECT imagenum
				FROM [|PREFIX|]customers
				WHERE customerid='".(int)$customerId."'";
				
			$imgNumResult = $GLOBALS['ISC_CLASS_DB']->Query($imgNumQuery);
			while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($imgNumResult)) {
				$imagenum = $row['imagenum'];
			}
			$allowCustomerUploadMaxNum = GetConfig('LimitCustomerUploadImageNum');
			if($imagenum >= $allowCustomerUploadMaxNum ){
				//$returnstr = 'You cannot upload more than 30 images. ';
				$returnstr = -1;
			}elseif(!in_array($single_type, $allowpictypes)){
				//$returnstr = 'Invalid type of file!';
				$returnstr = -2;
			}elseif($FILE['size'] > $allowFileSize*1024*1024){
				//$returnstr = 'File is larger than '.$allowFileSize.'MB! ';
				$returnstr = -3;
			}elseif(strlen($description) > 1000){
				//$returnstr = 'Description should not surpass 1000 characters! ';
				$returnstr = -4;
			}elseif(strlen($description) <= 0){
				//$returnstr = 'You must enter a description for each image submitted! ';
				$returnstr = -5;
			}else {
				$rootdir = ISC_BASE_PATH;
				
				if(!is_dir($rootdir . '/upload/' . date("ymd", time()))){
					mkdir($rootdir . '/upload/' . date("ymd", time()), 0777);
				}
				$fileType = explode('/', $FILE['type']);
				$path = '/upload/' . date("ymd", time()) . '/' . time() . md5(mt_rand(0, 999999)) . '.' . $fileType[1]; 
				if(move_uploaded_file($FILE['tmp_name'], $rootdir . $path)){
					$CustomerId = $GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerId();
					
					$NewPicture = array(
						"customerid" => $CustomerId,
						"path" => $path,
						"description" => $description,
						"filename" => $FILE['name'],
						"dateline" => time(),
						"uploaderFirstName" => $firstName,
						"uploaderLastName" => $lastName,
						"address1" => $address1,
						"address2" => $address2
					);
					if($GLOBALS['ISC_CLASS_DB']->InsertQuery("pic", $NewPicture)){
						$query1 = "UPDATE [|PREFIX|]customers set imagenum = imagenum + 1 where customerid = '$CustomerId'";
						$result = $GLOBALS["ISC_CLASS_DB"]->Query($query1);
						$returnstr = 'ok';
					}
				}
			}
			return $returnstr;
		}
		
		function displayPage(){
			$GLOBALS['ISC_CLASS_CUSTOMER'] = GetClass('ISC_CUSTOMER');
			$GLOBALS['CustomerId'] = $GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerId();
			$customerId = $GLOBALS['CustomerId'];
			
			$GLOBALS['ISC_CLASS_CAPTCHA']->CreateSecret();
			$GLOBALS['CaptchaImage'] = $GLOBALS['ISC_CLASS_CAPTCHA']->ShowCaptcha();
			
			$GLOBALS['COOKIE'] = base64_encode(serialize($_COOKIE));
			
			$query = "
				SELECT imagenum
				FROM [|PREFIX|]customers
				WHERE customerid='".(int)$customerId."'";
				
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$imagelist = $row['imagenum'];
			}
			
			$GLOBALS['allowUploadImageSize'] = GetConfig("LimitCustomerUploadImageSize");
			$GLOBALS['maxNum'] = GetConfig('LimitCustomerUploadImageNum');
			$GLOBALS['imagenum'] = $GLOBALS['maxNum'] - $imagelist;
			$GLOBALS['copyRight'] = base64_decode(GetConfig('ImageUploaderSettingsAssignment'));
			$GLOBALS['perMaxnum'] = GetConfig('LimitCustomerUploadImagePerNum');
			$GLOBALS['maxUploadImgNum'] = $GLOBALS['imagenum'] >= $GLOBALS['perMaxnum'] ? $GLOBALS['perMaxnum'] : $GLOBALS['imagenum'];
			// multi-image upload
			$allowpictypestr = GetConfig('LimitCustomerUploadImageFileType');
			$allowpictypes = explode(',', $allowpictypestr);
			$GLOBALS['allowpictypes'] = '';
			foreach($allowpictypes as $types){
				if($types == 1){
					$GLOBALS['allowpictypes'] .= '*.gif';
				}elseif($types == 2){
					$GLOBALS['allowpictypes'] .= '; *.jpeg; *.jpg';
				}elseif($types == 3){
					$GLOBALS['allowpictypes'] .= '; *.png';
				}elseif($types == 4){
					$GLOBALS['allowpictypes'] .= '; *.swf';
				}elseif($types == 6){
					$GLOBALS['allowpictypes'] .= '; *.bmp';
				}elseif($types == 7){
					$GLOBALS['allowpictypes'] .= '; *.tiff';
				}
			}
		}
		
		function UploadImage(){
			$GLOBALS['ISC_CLASS_CAPTCHA'] = GetClass('ISC_CAPTCHA');
			$this -> checkUpload();
			if($_POST['uploadsubmit']){
				//upload image
				$uploadfiles = $this -> pic_save($_FILES['attach'], $_POST['pic_desc'], $_POST['uploadFirstName'], $_POST['uploadLastName'], $_POST['address1'], $_POST['address2']);
				if($uploadfiles == 'ok') {
					$customerEntity = new ISC_ENTITY_CUSTOMER;
					$customerEntity->increaseImageLastUpload($GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerId());
					$uploadStat = 1;
				} else {
					$uploadStat = $uploadfiles;
				}
				echo "<script>";
				echo "parent.uploadStat = '$uploadStat';";
				echo "parent.upload();";
				echo "</script>";
				exit();
			}
			
			$this -> displayPage();

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetPageTitle(GetConfig('StoreName') . " - " . GetLang('Uploadimage'));
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("account_uploadimage");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}
		
		function ShowImage(){
			
			$GLOBALS['ISC_CLASS_CUSTOMER'] = GetClass('ISC_CUSTOMER');
			$GLOBALS['CustomerId'] = $GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerId();
			
			$customerId = $GLOBALS['CustomerId'];
			$query = "
				SELECT *
				FROM [|PREFIX|]customers
				WHERE customerid='".(int)$customerId."'";
				
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$imagelist = $row['imagenum'];
			}
			$GLOBALS['imagenum'] = GetConfig('LimitCustomerUploadImageNum') - $imagelist;
			$GLOBALS['Instructions'] = base64_decode(GetConfig('ImageUploaderSettingsInstructions'));//zcs=
			
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetPageTitle(GetConfig('StoreName') . " - " . GetLang('Uploadimage'));
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("account_showimage");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}
		
		function GetUploadImage($customerId=null){
			$imagelist = array();
	
			if(is_null($customerId)) {
				$GLOBALS['ISC_CLASS_CUSTOMER'] = GetClass('ISC_CUSTOMER');
				$customerId = $GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerId();
			}
			
			if(!$customerId) {
				return array();
			}
			
			$query = "
				SELECT *
				FROM [|PREFIX|]pic
				WHERE customerid='".(int)$customerId."' and deleted = 0";
				
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$imagelist[] = $row;
			}
			
			return $imagelist;
		}
		
		function CheckPermission($picid){
			// delete picture permission
			$query = "
				SELECT customerid
				FROM [|PREFIX|]pic
				WHERE picid='".(int)$picid."'";	
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$picowner = $row['customerid'];
			}
			
			$GLOBALS['ISC_CLASS_CUSTOMER'] = GetClass('ISC_CUSTOMER');
			$customerId = $GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerId();
			if($picowner == $customerId){
				return true;
			}else{
				return false;
			}
		}
		
		function DelImage(){
			$picid = $_GET['pic_id'];	
			$GLOBALS['ISC_CLASS_CUSTOMER'] = GetClass('ISC_CUSTOMER');
			$customerId = $GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerId();
			if($this -> CheckPermission($picid)){
				/*$query2 = "
					SELECT path
					FROM [|PREFIX|]pic
					WHERE picid='".(int)$picid."'";	
				$result2 = $GLOBALS['ISC_CLASS_DB']->Query($query2);
				$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result2);
				$picpath = $row['path'];
				*/
				$query = "UPDATE [|PREFIX|]pic set deleted = 1 where picid = '$picid'";
				$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
				$query1 = "UPDATE [|PREFIX|]customers set imagenum = imagenum - 1 where customerid = '$customerId'";
				$result1 = $GLOBALS["ISC_CLASS_DB"]->Query($query1);
				
				/*if($picpath) {
					@unlink(ISC_BASE_PATH . $picpath);
					$redirect = $GLOBALS["ShopPath"] . "/account/showimage";
					header("Location: $redirect");
				}*/
				$redirect = $GLOBALS["ShopPath"] . "/account/showimage";
				header("Location: $redirect");
			}else{
				// no permission to delete
				$redirect = $GLOBALS["ShopPath"] . "/account/showimage";
				header("Location: $redirect");
			}
		}

		/**
		 * Map and build the address form fields
		 *
		 * Method will call mapFieldData() to map the field data and then biuld each
		 * field HTML
		 *
		 * @access private
		 * @param array $fields The field list
		 * @param array $data The optional database record to map against
		 * @return string The constructed HTML on success, empty string on failure
		 */
		private function buildFieldData($addressId=0, $customerId=0)
		{
			$data = array();

			/**
			 * Do we have a valid address record ID?
			 */
			if (isId($addressId)) {

				/**
				 * We must also have a customer ID
				 */
				if (!isId($customerId)) {
					$customerId = $GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerId();
				}

				if (!isId($customerId)) {
					return '';
				}

				$entity = new ISC_ENTITY_SHIPPING();
				$data = $entity->get($addressId, $customerId);

				if (!$data) {
					return '';
				}
			}

			$getFromRequest = false;
			$getFromFormSessionId = '';

			if (isId($addressId) && isId($data['shipformsessionid'])) {
				$getFromFormSessionId = $data['shipformsessionid'];
			} else {
				$getFromRequest = true;
			}

			$fields = $GLOBALS['ISC_CLASS_FORM']->getFormFields(FORMFIELDS_FORM_ADDRESS, $getFromRequest, $getFromFormSessionId);

			/**
			 * OK, we got the fields, now we need to map the database record to it. This method has to
			 * be called as it also adds in the country and state options, so call this regardless
			 */
			if (!$this->mapFieldData($fields, $data)) {
				return '';
			}

			/**
			 * Remove the 'Save this address' option as this is for single page checkout only
			 */
			$html = '';
			foreach (array_keys($fields) as $fieldId) {
				if (isc_strtolower($fields[$fieldId]->record['formfieldprivateid']) == 'savethisaddress' || isc_strtolower($fields[$fieldId]->record['formfieldprivateid']) == 'shiptoaddress') {
					continue;
				}

				$html .= $fields[$fieldId]->loadForFrontend();
			}

			return $html;
		}

		/**
		 * Map the address form fields
		 *
		 * Method will map each database record element in $data to the corresponding field
		 * in $fields and set its value. Will also add in the country and state options
		 *
		 * @access private
		 * @param array &$fields The referenced field list
		 * @param array $data The optional database record to map against
		 * @return bool TRUE if the mapping was successful, FALSE if not
		 */
		private function mapFieldData(&$fields, $data=array())
		{
			if (!is_array($fields) || !is_array($data)) {
				return false;
			}

			$fieldMap = array(
				'FirstName' => 'firstname',
				'LastName' => 'lastname',
				'CompanyName' => 'company',
				'AddressLine1' => 'address1',
				'AddressLine2' => 'address2',
				'City' => 'city',
				'State' => 'state',
				'Country' => 'country',
				'Zip' => 'zip',
				'Phone' => 'phone'
			);

			$countryFieldId = '';
			$stateFieldId = '';

			foreach (array_keys($fields) as $fieldId) {
				if (!array_key_exists($fields[$fieldId]->record['formfieldprivateid'], $fieldMap)) {
					continue;
				}

				$key = 'ship' . $fieldMap[$fields[$fieldId]->record['formfieldprivateid']];

				if (array_key_exists($key, $data)) {
					$fields[$fieldId]->setValue($data[$key]);
				}

				if ($key == 'shipcountry') {
					$countryFieldId = $fieldId;
				} else if ($key == 'shipstate') {
					$stateFieldId = $fieldId;
				}
			}

			if ($countryFieldId) {
				$fields[$countryFieldId]->setOptions(array_values(GetCountryListAsIdValuePairs()));
				if ($fields[$countryFieldId]->getValue() == '') {
					$fields[$countryFieldId]->setValue(GetConfig('CompanyCountry'));
				}

				if (isId($stateFieldId)) {
					$fields[$countryFieldId]->addEventHandler('change', 'FormFieldEvent.SingleSelectPopulateStates', array('countryId' => $countryFieldId, 'stateId' => $stateFieldId));

					$countryId = GetCountryByName($fields[$countryFieldId]->getValue());
					$stateOptions = GetStateListAsIdValuePairs($countryId);

					if (is_array($stateOptions) && !empty($stateOptions)) {
						$fields[$stateFieldId]->setOptions($stateOptions);
					}
				}
			}

			return true;
		}

		/**
		 * Validate the submitted field data
		 *
		 * Method will run the validation for the submitted shipping field data
		 *
		 * @access private
		 * @param array $fields The fields to validate
		 * @param string &$errmsg The referenced variable to store the error message in
		 * @return bool TRUE if the validation was successful, FALSE if validation failed
		 */
		private function validateFieldData($fields, &$errmsg)
		{
			if (!is_array($fields)) {
				return false;
			}

			foreach (array_keys($fields) as $fieldId) {
				if (!$fields[$fieldId]->runValidation($errmsg)) {
					return false;
				}
			}

			return true;
		}

		/**
		 * Parse the submitted field data into an associative array
		 *
		 * Method will parse the submitted field data and convert it into an associative array
		 * that resembles the shipping_addresses table structure
		 *
		 * @access private
		 * @param array $fields The field list to parse from
		 * @param int $formSessionId The optional form session ID
		 * @return array The parsed array on success, FALSE on failure
		 */
		private function parseFieldData($fields, $formSessionId='')
		{
			if (!is_array($fields)) {
				return false;
			}

			$fieldMap = array(
				'FirstName' => 'firstname',
				'LastName' => 'lastname',
				'CompanyName' => 'company',
				'AddressLine1' => 'address1',
				'AddressLine2' => 'address2',
				'City' => 'city',
				'State' => 'state',
				'Country' => 'country',
				'Zip' => 'zip',
				'Phone' => 'phone'
			);

			$savedata = array();
			$countryFieldId = '';
			$stateFieldId = '';

			foreach (array_keys($fields) as $fieldId) {
				if (!array_key_exists($fields[$fieldId]->record['formfieldprivateid'], $fieldMap)) {
					continue;
				}

				$key = 'ship' . $fieldMap[$fields[$fieldId]->record['formfieldprivateid']];
				$savedata[$key] = isc_html_escape($fields[$fieldId]->getValue());

				if ($key == 'shipcountry') {
					$countryFieldId = $fieldId;
				} else if ($key == 'shipstate') {
					$stateFieldId = $fieldId;
				}
			}

			$savedata['shipcustomerid'] = $GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerId();

			/**
			 * Fill in the country and state IDs
			 */
			$savedata['shipcountryid'] = GetCountryByName($fields[$countryFieldId]->getValue());

			if (isId($savedata['shipcountryid'])) {
				$savedata['shipstateid'] = GetStateByName($fields[$stateFieldId]->getValue(), $savedata['shipcountryid']);
			} else {
				$savedata['shipstateid'] = 0;
			}

			/**
			 * Now save the form session record
			 */
			$formSessionId = $GLOBALS['ISC_CLASS_FORM']->saveFormSession(FORMFIELDS_FORM_ADDRESS, true, $formSessionId);

			if (isId($formSessionId)) {
				$savedata['shipformsessionid'] = $formSessionId;
			}

			return $savedata;
		}
	}


?>