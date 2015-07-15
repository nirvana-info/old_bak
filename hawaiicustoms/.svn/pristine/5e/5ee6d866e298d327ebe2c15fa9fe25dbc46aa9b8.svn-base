<?php
	class CHECKOUT_IDEAL_RABO extends ISC_CHECKOUT_PROVIDER
	{
		/*
			The iDeal store number
		*/
		private $_merchantid = "";


		/*
			Should the order be passed through in test mode?
		*/
		private $_testmode = "";

		/*
		 * Check if this checkout module can be enabled or not.
		 *
		 * @return boolean True if this module is supported on this install, false if not.
		 */
		public function IsSupported()
		{
			$query = "Select currencycode from [|PREFIX|]currencies Where currencyid = '".$GLOBALS['ISC_CLASS_DB']->Quote(GetConfig('DefaultCurrencyID'))."'";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$currencycode = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);

			if ($currencycode != 'EUR') {
				$this->SetError(GetLang('iDealOnlySupportEuro'));
			}

			if($this->HasErrors()) {
				return false;
			}
			else {
				return true;
			}
		}


		/*
			Checkout class constructor
		*/
		public function __construct()
		{

			// Setup the required variables for the iDeal Connect checkout module
			parent::__construct();
			$this->_name = GetLang('iDealName');
			$this->_image = "ideal_logo.jpg";
			$this->_description = GetLang('iDealDesc');
			$this->_help = sprintf(GetLang('iDealHelp'), $GLOBALS['ShopPathSSL'], $GLOBALS['ShopPathSSL'], $GLOBALS['ShopPathSSL']);

			$this->_file = basename(__FILE__);
		}

		/**
		* Custom variables for the checkout module. Custom variables are stored in the following format:
		* array(variable_id, variable_name, variable_type, help_text, default_value, required, [variable_options], [multi_select], [multi_select_height])
		* variable_type types are: text,number,password,radio,dropdown
		* variable_options is used when the variable type is radio or dropdown and is a name/value array.
		*/
		public function setcustomvars()
		{
			$this->_variables['displayname'] = array("name" => GetLang('DisplayName'),
			   "type" => "textbox",
			   "help" => GetLang('DisplayNameHelp'),
			   "default" => $this->getname(),
			   "savedvalue" => array(),
			   "required" => true
			);

			$this->_variables['merchantid'] = array("name" => GetLang('iDealMerchantID'),
			   "type" => "textbox",
			   "help" => GetLang('iDealMerchantIDHelp'),
			   "default" => "",
			   "savedvalue" => array(),
			   "required" => true
			);

			$this->_variables['secretkey'] = array("name" => GetLang('iDealSecretKey'),
			   "type" => "textbox",
			   "help" => GetLang('iDealSecretKeyHelp'),
			   "default" => "",
			   "savedvalue" => array(),
			   "required" => true
			);

			$this->_variables['testmode'] = array("name" => GetLang('TestMode'),
			   "type" => "dropdown",
			   "help" => GetLang("iDealTestModeHelp"),
			   "default" => "no",
			   "savedvalue" => array(),
			   "required" => true,
			   "options" => array(GetLang("iDealTestModeNo") => "NO",
							  GetLang("iDealTestModeYes") => "YES"
				),
				"multiselect" => false
			);
		}

		/**
		*	Redirect the customer to iDeal's site to enter their payment details
		*/
		public function transfertoprovider()
		{

			$total = $this->gettotal()*100;

			$this->_merchantid = $this->GetValue("merchantid");
			$secretkey = $this->GetValue("secretkey");
			$testmode_on = $this->GetValue("testmode");

			$validUntil = date("Y-m-d\TG:i:s\Z",strtotime ("+1 week"));

			// Load the pending order
			$order = LoadPendingOrderByToken($_COOKIE['SHOP_ORDER_TOKEN']);
			$itemString = '';
			$orderItems = $_SESSION['CART']['ITEMS'];
			foreach ($orderItems as $item) {
				$itemNumber = $item['product_id'];
				$itemDescription = $item['product_name'];
				$itemQuantity = $item['quantity'];
				$itemPrice = $item['product_price']*100;
				$itemString .= $itemNumber.$itemDescription.$itemQuantity.$itemPrice;
			 }

			$hashString = $secretkey. $this->_merchantid . "0"  . $total . $order['orderid'] . "ideal" . $validUntil. $itemString;

			$clean_hashString = HTML_entity_decode($hashString);

			$not_allowed = array("\t", "\n", "\r", " ");
			$clean_hashString = str_replace($not_allowed, "",$clean_hashString);

			$clean_hashString = sha1($clean_hashString);

			$shipping_cost = $order['ordshipcost']+$order['ordhandlingcost'];

			if($testmode_on == "YES") {
					$ideal_url = "https://idealtest.rabobank.nl/ideal/mpiPayInitRabo.do";
			} else {
					$ideal_url = "https://ideal.rabobank.nl/ideal/mpiPayInitRabo.do";
			}
			?>
				<html>
					<head>
						<title><?php echo GetLang('RedirectingToiDeal'); ?></title>
					</head>

					<body onload="document.forms[0].submit()">
						<a href="javascript:void(0)" onclick="document.forms[0].submit()" style="color:gray; font-size:12px"><?php echo GetLang('ClickIfNotRedirected'); ?></a>
						<form name="ideal" id="ideal" action="<?php echo $ideal_url; ?>" method="post">

							<INPUT type="hidden" NAME="merchantID" value="<?php echo $this->_merchantid;?>">
							<INPUT type="hidden" NAME="subID" value="0">
							<INPUT type="hidden" NAME="amount" VALUE="<?php echo $total;?>" >
							<INPUT type="hidden" NAME="purchaseID" VALUE="<?php echo $order['orderid'];?>">
							<INPUT type="hidden" NAME="currency" VALUE="EUR">
							<INPUT type="hidden" NAME="hash" size="50" VALUE="<?php echo $clean_hashString;?>">
							<INPUT type="hidden" NAME="paymentType" VALUE="ideal">
							<INPUT type="hidden" NAME="validUntil" VALUE="<?php echo $validUntil;?>">
							<INPUT type="hidden" NAME="urlCancel" VALUE="<?php echo $GLOBALS['ShopPathSSL'];?>/cart.php">
							<INPUT type="hidden" NAME="urlSuccess" VALUE="<?php echo $GLOBALS['ShopPathSSL'];?>/finishorder.php?status=success">
							<INPUT type="hidden" NAME="urlError" VALUE="<?php echo $GLOBALS['ShopPathSSL'];?>/finishorder.php?status=fail">

					<?php

						if ($shipping_cost != 0) {
					?>
							<INPUT type="hidden" NAME="itemNumber0" VALUE="0">
							<INPUT type="hidden" NAME="itemDescription0"  size="32" VALUE="<?php echo GetLang("ShippingCost"); ?>">
							<INPUT type="hidden" NAME="itemQuantity0" VALUE="1">
							<INPUT type="hidden" NAME="itemPrice0" VALUE="<?php echo $shipping_cost*100; ?>">
					<?
						}

						$i = 1;
						foreach ($orderItems as $item) {
							$itemSubtotal = $item['quantity']*$item['product_price'];
					?>
							<INPUT type="hidden" NAME="itemNumber<?php echo $i;?>" VALUE="<?php echo (int)$item['product_id'];?>">
							<INPUT type="hidden" NAME="itemDescription<?php echo $i;?>"  size="32" VALUE="<?php echo isc_html_escape($item['product_name']);?>">
							<INPUT type="hidden" NAME="itemQuantity<?php echo $i;?>" VALUE="<?php echo (int)$item['quantity'];?>">
							<INPUT type="hidden" NAME="itemPrice<?php echo $i;?>" VALUE="<?php echo $item['product_price']*100;?>">
					<?php
							$i++;
						}
					?>

						</form>
					</body>
				</html>
			<?php
			exit;
		}

		/**
		*	Return the unique order token which was saved as a cookie pre-payment
		*/
		public function getordertoken()
		{
			return @$_COOKIE['SHOP_ORDER_TOKEN'];
		}

		/**
		*	Verify the order by posting back to iDeal.
		*/
		public function verifyorder(&$PendingOrder)
		{
			if ($_REQUEST['status'] == 'success') {
				$PendingOrder['paymentstatus'] = 1;
				$GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess(array('payment', $this->GetName()), GetLang('iDealSuccess'));
				return true;
			} else {
				$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('payment', $this->GetName()), GetLang('iDealInvalidMsg'));
				return false;
			}
		}
	}

?>