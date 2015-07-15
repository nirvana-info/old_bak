<?php

	class CHECKOUT_SECURETRADING extends ISC_CHECKOUT_PROVIDER
	{
		protected $requiresSSL = false;

		public $_id = "checkout_securetrading";

		protected $_currenciesSupported = array('USD','GBP');
		public $_languagePrefix = 'SecureTrading';

		/*
			Checkout class constructor
		*/
		public function __construct()
		{
			// Setup the required variables for the Secure Trading checkout module
			parent::__construct();
			$this->_name = GetLang($this->_languagePrefix.'Name');
			$this->_image = "secure_trading.gif";
			$this->_description = GetLang($this->_languagePrefix.'Desc');
			$this->_help = sprintf(GetLang($this->_languagePrefix.'Help'), $GLOBALS['ShopPath'], $GLOBALS['ShopPath']);	// Help Message
			$this->_height = 0;
		}

		public function IsSupported()
		{
			$currency = GetDefaultCurrency();

			// Check if the default currency is supported by the payment gateway
			if (!in_array($currency['currencycode'], $this->_currenciesSupported)) {
				$this->SetError(sprintf(GetLang($this->_languagePrefix.'CurrecyNotSupported'), implode(',',$this->_currenciesSupported)));
			}

			if($this->HasErrors()) {
				return false;
			}
			else {
				return true;
			}
		}

		/**
		* Custom variables for the checkout module. Custom variables are stored in the following format:
		* array(variable_id, variable_name, variable_type, help_text, default_value, required, [variable_options], [multi_select], [multi_select_height])
		* variable_type types are: text,number,password,radio,dropdown
		* variable_options is used when the variable type is radio or dropdown and is a name/value array.
		*/
		public function SetCustomVars()
		{
			$this->_variables['displayname'] = array("name" => GetLang($this->_languagePrefix."DisplayName"),
			 "type" => "textbox",
			 "help" => GetLang('DisplayNameHelp'),
			 "default" => $this->GetName(),
			 "required" => true
			);

			$this->_variables['MerchantId'] = array("name" => GetLang($this->_languagePrefix."MerchantId"),
			 "type" => "textbox",
			 "help" => GetLang($this->_languagePrefix.'MerchantIdHelp'),
			 "default" => '',
			 "required" => true
			);
			$this->_variables['MerchantEmail'] = array("name" => GetLang($this->_languagePrefix."MerchantEmail"),
			 "type" => "textbox",
			 "help" => GetLang($this->_languagePrefix.'MerchantEmailHelp'),
			 "default" => '',
			 "required" => true
			);
			$this->_variables['CallbackId'] = array("name" => GetLang($this->_languagePrefix."CallbackId"),
			 "type" => "textbox",
			 "help" => GetLang($this->_languagePrefix.'CallbackIdHelp'),
			 "default" => '',
			 "required" => true
			);
			$this->_variables['SecretWord'] = array("name" => GetLang($this->_languagePrefix."SecretWord"),
			 "type" => "textbox",
			 "help" => GetLang($this->_languagePrefix.'SecretWordHelp'),
			 "default" => '',
			 "required" => true
			);
		}

		public function TransferToProvider($error=null, $ordertoken=null)
		{
			$url = 'https://securetrading.net/authorize/process.cgi';
			$currency = GetDefaultCurrency();
			$currency = $currency['currencycode'];

			$billingDetails = $this->GetBillingDetails();

			$merchantid = $this->GetValue('MerchantId');
			$merchantemail = $this->GetValue('MerchantEmail');
			$callbackid = $this->GetValue('CallbackId');

			$amount = number_format($this->GetGatewayAmount()*100, 0, '','');

			$stform['merchant'] = $merchantid;
			$stform['orderref'] = $this->GetCombinedOrderId();
			$stform['orderinfo'] = sprintf(GetLang($this->_languagePrefix.'YourOrderFromX'), $GLOBALS['StoreName']);
			$stform['amount'] = $amount;
			$stform['currency'] = $currency;
			$stform['merchantemail'] = $merchantemail;
			$stform['callbackurl'] = $callbackid;
			$stform['failureurl'] = $callbackid;
			$stform['formref'] = $callbackid;
			$stform['customeremail'] = $billingDetails['ordbillemail'];
			$stform['settlementday'] = 1;

			if ($ordertoken) {
				$stform['ordertoken'] = $ordertoken;
			} else {
				$stform['ordertoken'] = $_COOKIE['SHOP_ORDER_TOKEN'];
			}

			$stform['hash'] = md5($this->GetValue('SecretWord').$this->GetCombinedOrderId().$merchantid.$amount.$currency);

			$stform['name'] = $billingDetails['ordbillfirstname'] . ' '. $billingDetails['ordbilllastname'];
			$stform['address'] = $billingDetails['ordbillstreet1'] . ' '. $billingDetails['ordbillstreet2'];
			$stform['town'] = $billingDetails['ordbillsuburb'];
			$stform['county'] = $billingDetails['ordbillstate'];
			$stform['postcode'] = $billingDetails['ordbillzip'];

			$stform['country'] = $billingDetails['ordbillcountry'];
			$stform['telephone'] = $billingDetails['ordbillphone'];
			$stform['email'] = $billingDetails['ordbillemail'];

			if ($error) {
				$stform['error'] = $error;
			}

			header('Location: ' . $url . '?'. http_build_query($stform));
		}

		public function ProcessGatewayPing()
		{
			if (!isset($_POST['ordertoken'])) {
				$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('payment', $this->GetName()), GetLang($this->_languagePrefix.'ErrorInvalid'));
				return false;
			}

			$this->SetOrderData(LoadPendingOrdersByToken($_POST['ordertoken']));

			if (!isset($_POST['hash']) || !isset($_POST['amount']) ||  !isset($_POST['currency']) ||
			 !isset($_POST['orderref']) ||  !isset($_POST['ordertoken'])) {
				$this->TransferToProvider('Card Details Invalid',$_POST['ordertoken']);
			 }

			if ($_POST['hash'] != md5($this->GetValue('SecretWord').$_POST['orderref'].$this->GetValue('MerchantId').$_POST['amount'].$_POST['currency'])) {
				$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('payment', $this->GetName()), GetLang($this->_languagePrefix.'ErrorInvalid'));
				return false;
			}

			$updatedOrder = array(
				'ordpayproviderid' => $_REQUEST['streference'],
				'ordpaymentstatus' => 'captured',
			);

			$this->UpdateOrders($updatedOrder);

			foreach($this->GetOrders() as $orderId => $order) {
				$status = ORDER_STATUS_AWAITING_FULFILLMENT;
				// If it's a digital order & awaiting fulfillment, automatically complete it
				if($order['ordisdigital']) {
					$status = ORDER_STATUS_COMPLETED;
				}
				UpdateOrderStatus($orderId, $status);
			}

			$GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess(array('payment', $this->GetName()), GetLang($this->_languagePrefix.'Success'));

			header ('Location: ' . $GLOBALS['ShopPath'] . '/finishorder.php');

			return true;
		}

		public function VerifyOrderPayment()
		{
			if(isset($_COOKIE['SHOP_TOKEN']) && isset($_COOKIE['SHOP_ORDER_TOKEN'])) {
				// This order is still incomplete, IPN notification hasn't been received yet, so the payment status is pending
				if($this->GetOrderStatus() == ORDER_STATUS_INCOMPLETE) {
					$this->SetPaymentStatus(PAYMENT_STATUS_PENDING);
				}
				// Always return successful, the IPN pingback will actually validate the order and do all of the magic
				return true;
			}
			else {
				// Bad order details
				$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('payment', $this->GetName()), GetLang('PayPalErrorInvalid'), __FUNCTION__);
				return false;
			}
		}

	}

?>