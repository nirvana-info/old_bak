<?php
	class CHECKOUT_LINKPOINTCONNECT extends ISC_CHECKOUT_PROVIDER
	{
		/*
			The LinkPoint store number
		*/
		private $_storenumber = "";


		/*
			Should the order be passed through in test mode?
		*/
		private $_testmode = "";

		/*
			Checkout class constructor
		*/
		public function __construct()
		{
			// Setup the required variables for the LinkPoint Connect checkout module
			parent::__construct();
			$this->_name = GetLang('LinkPointConnectName');
			$this->_image = "linkpoint_logo.jpg";
			$this->_description = GetLang('LinkPointConnectDesc');
			$this->_help = sprintf(GetLang('LinkPointConnectHelp'), $GLOBALS['ShopPathSSL'], $GLOBALS['ShopPathSSL'], $GLOBALS['ShopPathSSL']);
		}

		/**
		* Custom variables for the checkout module. Custom variables are stored in the following format:
		* array(variable_id, variable_name, variable_type, help_text, default_value, required, [variable_options], [multi_select], [multi_select_height])
		* variable_type types are: text,number,password,radio,dropdown
		* variable_options is used when the variable type is radio or dropdown and is a name/value array.
		*/
		public function SetCustomVars()
		{

			$this->_variables['displayname'] = array("name" => GetLang('DisplayName'),
			   "type" => "textbox",
			   "help" => GetLang('DisplayNameHelp'),
			   "default" => $this->GetName(),
			   "required" => true
			);

			$this->_variables['storenumber'] = array("name" => GetLang('LinkPointStoreNumber'),
			   "type" => "textbox",
			   "help" => GetLang('LinkPointConnectStoreNumberHelp'),
			   "default" => "",
			   "required" => true
			);

			$this->_variables['gatewayprovider'] = array("name" => GetLang('GatewayProvider'),
			   "type" => "dropdown",
			   "help" => GetLang('LinkPointConnectGatewayProviderHelp'),
			   "default" => "lp",
			   "required" => true,
				"options" => array(GetLang('LinkPointConnectGatewayProvider1') => "lp",
							  GetLang('LinkPointConnectGatewayProvider2') => "yp"),
				"multiselect" => false
			);

			$this->_variables['transactiontype'] = array("name" => GetLang('TransactionType'),
			   "type" => "dropdown",
			   "help" => GetLang("LinkPointConnectTransactionTypeHelp"),
			   "default" => "sale",
			   "required" => true,
			   "options" => array(GetLang("LinkPointConnectTransactionTypeSale") => "sale",
							  GetLang("LinkPointConnectTransactionTypePreauth") => "preauth"
				),
				"multiselect" => false
			);

			$this->_variables['testmode'] = array("name" => GetLang('TestMode'),
			   "type" => "dropdown",
			   "help" => GetLang("LinkPointConnectTestModeHelp"),
			   "default" => "no",
			   "required" => true,
			   "options" => array(GetLang("LinkPointConnectTestModeNo") => "NO",
							  GetLang("LinkPointConnectTestModeYes") => "YES"
				),
				"multiselect" => false
			);
		}

		/**
		*	Redirect the customer to LinkPointConnect's site to enter their payment details
		*/
		public function TransferToProvider()
		{
			$pendingdata = $_SESSION['CHECKOUT']['PENDING_DATA'];
			$itemcost = $this->GetSubTotal();
			$shippingcost = $this->GetShippingCost() + $this->GetHandlingCost();
			$taxcost = $this->GetTaxCost();

			$total = $this->GetGatewayAmount();

			$this->_storenumber = $this->GetValue("storenumber");
			$transactiontype = $this->GetValue("transactiontype");
			$testmode_on = $this->GetValue("testmode");
			$gatewayprovider = $this->GetValue("gatewayprovider");

			if($testmode_on == "YES") {
				if ($gatewayprovider == 'lp') {
					$linkpointconnect_url = "https://staging.linkpt.net/lpc/servlet/lppay";
				} else {
					$linkpointconnect_url = "https://www.staging.yourpay.com/lpcentral/servlet/lppay";
				}
			} else {
				if ($gatewayprovider == 'lp') {
					$linkpointconnect_url = "https://www.linkpointcentral.com/lpc/servlet/lppay";
				} else {
					$linkpointconnect_url = "https://secure.linkpt.net/lpcentral/servlet/lppay";
				}
			}

			// Load the pending order
			$order = LoadPendingOrderByToken($_COOKIE['SHOP_ORDER_TOKEN']);

			$bcountry = GetCountryISO2ById($order['ordbillcountryid']);
			$scountry = GetCountryISO2ById($order['ordshipcountryid']);

			// Fetch the customer details
			$query = sprintf("SELECT * FROM [|PREFIX|]customers WHERE customerid='%s'", $GLOBALS['ISC_CLASS_DB']->Quote($order['ordcustid']));
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$customer = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

			$phone = $customer['custconphone'];
			$phone = preg_replace("#[^\+0-9]+#", "", $phone);

			//if it's us, we need to have find the us state code
			if($bcountry == "US") {
				$bstate = GetStateISO2ById($order['ordbillstateid']);
				$bstate_name='bstate';
			} else {
				$bstate = $order['ordbillstate'];
				$bstate_name='bstate2';
			}

			if($scountry == "US") {
				$sstate = GetStateISO2ById($order['ordshipstateid']);
				$sstate_name='sstate';
			} else {
				$sstate = $order['ordshipstate'];
				$sstate_name='sstate2';
			}


			?>
				<html>
					<head>
						<title><?php echo GetLang('RedirectingToLinkPointConnect'); ?></title>
					</head>

					<body onload="document.forms[0].submit()">
						<a href="javascript:void(0)" onclick="document.forms[0].submit()" style="color:gray; font-size:12px"><?php echo GetLang('ClickIfNotRedirected'); ?></a>
						<form name="linkpointconnect" id="linkpointconnect" action="<?php echo $linkpointconnect_url; ?>" method="post">
							<input type="hidden" name="mode" value="fullpay">
							<input type="hidden" name="chargetotal" value="<?php echo $total;?>">
							<input type="hidden" name="tax" value="<?php echo $taxcost;?>">
							<input type="hidden" name="shipping" value="<?php echo $shippingcost;?>">
							<input type="hidden" name="subtotal" value="<?php echo $itemcost;?>">



							<input type="hidden" name="storename" value="<?php echo $this->_storenumber;?>">
							<input type="hidden" name="txntype" value="<?php echo $transactiontype;?>">

							<input type="hidden" name="bname" value="<?php echo isc_html_escape($order['ordbillfirstname'].' '.$order['ordbilllastname']); ?>" />
							<input type="hidden" name="email" value="<?php echo isc_html_escape($customer['custconemail']); ?>" />
							<input type="hidden" name="phone" value="<?php echo $phone; ?>" />


							<input type="hidden" name="baddr1" value="<?php echo isc_html_escape($order['ordbillstreet1']); ?>" />
							<input type="hidden" name="baddr2" value="<?php echo isc_html_escape($order['ordbillstreet2']); ?>" />
							<input type="hidden" name="bcountry" value="<?php echo isc_html_escape($bcountry); ?>" />
							<input type="hidden" name="bzip" value="<?php echo isc_html_escape($order['ordbillzip']); ?>" />
							<input type="hidden" name="bcity" value="<?php echo isc_html_escape($order['ordbillsuburb']); ?>" />
							<input type="hidden" name="<?php echo isc_html_escape($bstate_name);?>" value="<?php echo isc_html_escape($bstate); ?>" />


							<input type="hidden" name="sname" value="<?php echo isc_html_escape($order['ordshipfirstname'].' '.$order['ordshiplastname']); ?>" />
							<input type="hidden" name="saddr1" value="<?php echo isc_html_escape($order['ordshipstreet1']); ?>" />
							<input type="hidden" name="saddr2" value="<?php echo isc_html_escape($order['ordshipstreet2']); ?>" />
							<input type="hidden" name="scountry" value="<?php echo isc_html_escape($scountry); ?>" />
							<input type="hidden" name="szip" value="<?php echo isc_html_escape($order['ordshipzip']); ?>" />
							<input type="hidden" name="scity" value="<?php echo isc_html_escape($order['ordshipsuburb']); ?>" />
							<input type="hidden" name="<?php echo isc_html_escape($sstate_name);?>" value="<?php echo isc_html_escape($sstate); ?>" />


						</form>
					</body>
				</html>
			<?php
			exit;
		}

		/**
		*	Return the unique order token which was saved as a cookie pre-payment
		*/
		public function GetOrderToken()
		{
			return @$_COOKIE['SHOP_ORDER_TOKEN'];
		}

		/**
		*	Verify the order by posting back to LinkPointConnect.
		*/
		public function VerifyOrder(&$PendingOrder)
		{
			if ($_REQUEST['status'] == 'APPROVED') {
				$transactiontype = $this->GetValue("transactiontype");
				if ($transactiontype == 'preauth') {
					$PendingOrder['paymentstatus'] = 2;
				} elseif ($transactiontype == 'sale') {
					$PendingOrder['paymentstatus'] = 1;
				}
				$successMsg = sprintf(GetLang('LinkPointConnectSuccess'),$PendingOrder['orderid']);
				$GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess(array('payment', $this->GetName()), $successMsg);
				return true;
			} else {
				$failmsg = sprintf(GetLang('LinkPointConnectInvalidMsg'), $_REQUEST['failReason']);
				$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('payment', $this->GetName()), $failmsg);
				return false;
			}
		}
	}

?>