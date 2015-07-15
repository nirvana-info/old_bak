<?php

	require_once('lib/pay.php');
	require_once('lib/simplepayclient.php');

	class CHECKOUT_SIMPLEPAY extends ISC_CHECKOUT_PROVIDER
	{
		public $_id = "checkout_simplepay";

		/*
			Does this payment provider require SSL?
		*/
		protected $requiresSSL = false;
		protected $_currenciesSupported = array('USD');

		private $_languagePrefix = 'SimplePay';

		/*
			Checkout class constructor
		*/
		public function __construct()
		{
			// Setup the required variables for the SimplePay checkout module
			parent::__construct();

			$this->_name = GetLang('SimplePayName');
			$this->_image = "apmark_180x110.jpg";
			$this->_description = GetLang('SimplePayDesc');
			$this->_help = sprintf(GetLang($this->_languagePrefix.'Help'), $GLOBALS['ShopPath']);	// Help Message
			$this->_height = 0;

		}

		public function IsSupported()
		{
			$currencycode = GetDefaultCurrency();
			$currencycode = $currencycode['currencycode'];

			if (!in_array($currencycode, $this->_currenciesSupported)) {
				$this->SetError(GetLang($this->_languagePrefix.'CurrecyNotSupported'));
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
			$this->_variables['displayname'] = array("name" => GetLang($this->_languagePrefix.'DisplayName'),
			   "type" => "textbox",
			   "help" => GetLang('DisplayNameHelp'),
			   "default" => $this->GetName(),
			   "required" => true
			);

			$this->_variables['accessid'] = array("name" => GetLang($this->_languagePrefix.'AccessId'),
			   "type" => "textbox",
			   "help" => GetLang($this->_languagePrefix.'AccessIdHelp'),
			   "default" => "",
			   "required" => true
			);

			$this->_variables['secretkey'] = array("name" => GetLang($this->_languagePrefix.'SecretKey'),
			   "type" => "password",
			   "help" => GetLang($this->_languagePrefix.'SecretKeyHelp'),
			   "default" => "",
			   "required" => true
			);

			$this->_variables['testmode'] = array("name" => GetLang($this->_languagePrefix.'TestMode'),
			   "type" => "dropdown",
			   "help" => GetLang($this->_languagePrefix.'TestModeHelp'),
			   "default" => "no",
			   "required" => true,
			   "options" => array(GetLang($this->_languagePrefix.'TestModeNo') => "NO",
							  GetLang($this->_languagePrefix.'TestModeYes') => "YES"
				),
				"multiselect" => false
			);
		}

		/**
		*	Redirect the customer to SimplePay's site to enter their payment details
		*/
		public function TransferToProvider()
		{
			$client = new SIMPLEPAY_CLIENT($this->GetValue('accessid'),
		                                    $this->GetValue('secretkey'),
		                                    $this->GetValue('testmode') == "YES");

			$simplePay = new SIMPLEPAY_PAY();
			$simplePay->setDescription('Order from Shopping Cart');
			$simplePay->setReferenceId($this->GetCombinedOrderId());
			$simplePay->setAmount('USD '.round($this->GetGatewayAmount(),2));
			$client->pay($simplePay);
			die();
		}

			/**
			*	Return the unique order token which was saved as a cookie pre-payment
			*/
		public function GetOrderToken()
		{
			return @$_REQUEST['sessionId'];
		}

		public function VerifyOrderPayment()
		{
			$status 		= $_REQUEST['status'];
			$orderid 		= $_REQUEST['referenceId'];
			$hash 			= $_REQUEST['hash'];
			$sessionId 		= $_REQUEST['sessionId'];
			$amazonAmount	= $_REQUEST['transactionAmount'];
			$operation 		= $_REQUEST['operation'];
			$paymentMethod 	= $_REQUEST['paymentMethod'];

			$buyerEmail = '';

			if (isset($_REQUEST['buyerEmail'])) {
				$buyerEmail = $_REQUEST['buyerEmail'];
			}
			$transactionId = '';

			if (isset($_REQUEST['transactionId'])) {
				$transactionId = $_REQUEST['transactionId'];
			}

			$amount = explode(' ', $amazonAmount);
			$amount = $amount[1];

			if (!isset($amount)) {
				$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('payment', $this->GetName()), GetLang($this->_languagePrefix.'InvalidAmount'), $amount);
			}

			if ($orderid != $this->GetCombinedOrderId() || $operation != 'pay' || $sessionId != $_COOKIE['SHOP_ORDER_TOKEN'] || $amount != $this->GetGatewayAmount()) {
				$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('payment', $this->GetName()), GetLang($this->_languagePrefix.'ErrorMismatch'));
				return false;
			}

			if (md5($this->GetValue("accessid").$this->GetValue("secretkey").$orderid.$sessionId.$amazonAmount) != $hash) {
				$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('payment', $this->GetName()), GetLang($this->_languagePrefix.'ErrorMismatch'));
				return false;
			}

			if (!($status == 'PS' || $status == 'PI')) {
				$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('payment', $this->GetName()), sprintf(GetLang($this->_languagePrefix.'ErrorMismatch'), $status), GetLang($this->_languagePrefix.'ResponseCodes'));
				return false;
			}

			$extraInfo = serialize(array('Amazon Email'=>$buyerEmail, 'Payment Method'=>$paymentMethod));

			$updatedOrder = array(
				'ordpayproviderid' => $transactionId,
				'ordpaymentstatus' => 'captured',
				'extrainfo' => $extraInfo
			);

			$this->UpdateOrders($updatedOrder);

			$this->SetPaymentStatus(PAYMENT_STATUS_PAID);
			$GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess(array('payment', $this->GetName()), sprintf(GetLang($this->_languagePrefix.'Success'), $this->GetCombinedOrderId()));
			return true;


		}
	}

?>