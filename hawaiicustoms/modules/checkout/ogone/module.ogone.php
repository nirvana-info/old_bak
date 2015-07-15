<?php
class CHECKOUT_OGONE extends ISC_CHECKOUT_PROVIDER
{
		protected $requiresSSL = false;

		public $_id = "checkout_ogone";

		protected $_currenciesSupported = array('EUR','GBP');

		public $_languagePrefix = 'Ogone';

	public function __construct()
	{
		// Setup the required variables for the Ogone checkout module
		parent::__construct();
		$this->_name = GetLang($this->_languagePrefix.'Name');
		$this->_image = "logo.gif";
		$this->_description = GetLang($this->_languagePrefix.'Desc');
		$this->_help = sprintf(GetLang($this->_languagePrefix.'Help'), $GLOBALS['ShopPath']);
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

		$this->_variables['pspid'] = array("name" => GetLang($this->_languagePrefix."Pspid"),
		   "type" => "textbox",
		   "help" => GetLang($this->_languagePrefix.'PspidHelp'),
		   "default" => "",
		   "required" => true
		);

		$this->_variables['signature'] = array("name" => GetLang($this->_languagePrefix."Signature"),
		   "type" => "password",
		   "help" => GetLang($this->_languagePrefix.'SignatureHelp'),
		   "default" => "",
		   "required" => true
		);

		$this->_variables['testmode'] = array("name" => GetLang($this->_languagePrefix."TestMode"),
		   "type" => "dropdown",
		   "help" => GetLang($this->_languagePrefix.'TestModeHelp'),
		   "default" => "no",
		   "required" => true,
		   "options" => array(GetLang($this->_languagePrefix.'TestModeNo') => 'NO',
						  GetLang($this->_languagePrefix.'TestModeYes') => 'YES'
			),
			"multiselect" => false
		);
	}

	public function TransferToProvider()
	{
		$amount = number_format($this->GetGatewayAmount() * 100, 0, '', '');
		$pspid = $this->GetValue("pspid");
		$signature = $this->GetValue("signature");

		if($this->GetValue("testmode") == "YES") {
			$ogone_url = "https://secure.ogone.com/ncol/test/orderstandard.asp";
		}
		else {
			$ogone_url = "https://secure.ogone.com/ncol/prod/orderstandard.asp";
		}

		$billingDetails = $this->GetBillingDetails();

		$currency = GetDefaultCurrency();

		$hiddenFields = array(
			// Ogone Details
			'orderID'		=> $this->GetCombinedOrderId(),
			'PSPID'			=> $pspid,
			'currency' 		=>	$currency['currencycode'],
			'language'		=> 'en_EN',
			'SHASign' 		=> sha1($this->GetCombinedOrderId().$amount.$currency['currencycode'].$pspid.$this->GetValue('signature')),
			'paramplus'		=> 'SessionToken=' . $_COOKIE['SHOP_ORDER_TOKEN'] . '_' . $_COOKIE['SHOP_SESSION_TOKEN'],

			// Order Details
			'cn' 			=> $billingDetails['ordbillfirstname'] . ' ' . $billingDetails['ordbilllastname'],
			'email'			=> $billingDetails['ordbillemail'],
			'owneraddress'	=> $billingDetails['ordbillstreet1'] . ' ' . $billingDetails['ordbillstreet2']  . ' ' . $billingDetails['ordbillsuburb'] . ' ' .  $billingDetails['ordbillstate'] . ' ' .  $billingDetails['ordbillcountry'],
			'ownerzip'		=> $billingDetails['ordbillzip'],
			'amount'		=> $amount,


			// Notification Details
			'declineurl' 	=> GetConfig('ShopPathSSL'),
			'exceptionurl'	=> GetConfig('ShopPathSSL'),
			'cancelurl'		=> GetConfig('ShopPathSSL').'/cart.php',
			'catalogurl' 	=> GetConfig('ShopPathSSL'),
			'homeurl' 		=> GetConfig('ShopPathSSL'),
			'notify_url'	=> GetConfig('ShopPathSSL').'/checkout.php?action=gateway_ping&provider='.$this->_id
		);

		$this->RedirectToProvider($ogone_url, $hiddenFields);
	}

	public function GetOrderToken()
	{
		return @$_COOKIE['SHOP_ORDER_TOKEN'];
	}


	public function VerifyOrderPayment()
	{
		if(isset($_COOKIE['SHOP_TOKEN']) && isset($_COOKIE['SHOP_ORDER_TOKEN'])) {
			// No pingback yet, so set something to show the customer
			if($this->GetOrderStatus() == ORDER_STATUS_INCOMPLETE) {
				$this->SetPaymentStatus(PAYMENT_STATUS_PENDING);
			}
			// Always return successful, pingback will do all the work
			return true;
		}
		else {
			// Bad order details
			$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('payment', $this->_name), GetLang('OgoneErrorInvalid'), __FUNCTION__);
			return false;
		}
	}

	public function ProcessGatewayPing()
	{
		try {
			if(!isset($_REQUEST['SessionToken'])) {
				exit;
			}

			$sessionToken = explode('_', $_REQUEST['SessionToken'], 2);

			$this->SetOrderData(LoadPendingOrdersByToken($sessionToken[0]));

			$amount = $_REQUEST['amount'];
			$currency = $_REQUEST['currency'];
			$storeCurrency = GetDefaultCurrency();
			$storeCurrency = $storeCurrency['currencycode'];

			if ($amount != $this->GetGatewayAmount() || $this->GetGatewayAmount() == 0) {
				exit;
			}

			if ($storeCurrency != $currency) {
				exit;
			}

			switch($_REQUEST['status']) {
				case '5':
					$newOrderStatus = ORDER_STATUS_AWAITING_FULFILLMENT;
					break;
				default :
					$newOrderStatus = ORDER_STATUS_DECLINED;
					break;
			}

			if($this->GetOrderStatus() == ORDER_STATUS_INCOMPLETE) {
				session_write_close();
				$session = new ISC_SESSION($sessionToken[1]);
				$orderClass = GetClass('ISC_ORDER');
				$orderClass->EmptyCartAndKillCheckout();
			}

			foreach($this->GetOrders() as $orderId => $order) {
				if($order['ordisdigital'] && $newOrderStatus == ORDER_STATUS_AWAITING_FULFILLMENT) {
					$status = ORDER_STATUS_COMPLETED;
				}
				UpdateOrderStatus($orderId, $newOrderStatus);
			}

			$updatedOrder = array(
				'ordpayproviderid' => $_REQUEST['payid'],
				'ordpaymentstatus' => 'captured',
			);

			$this->UpdateOrders($updatedOrder);

			$oldStatus = GetOrderStatusById($order['ordstatus']);

			if(!$oldStatus) {
				$oldStatus = 'Incomplete';
			}
			$newStatus = GetOrderStatusById($newOrderStatus);
			$extra = sprintf(GetLang('OgoneSuccessDetails'), $order['orderid'], $order['ordgatewayamount'], $_REQUEST['PAYID'], $_REQUEST['STATUS'], $newStatus, $oldStatus);
			$GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess(array('payment', $this->_name), GetLang('OgoneSuccess'), $extra);

		} catch(Exception $e)
		{
			$GLOBALS['ISC_CLASS_LOG']->LogSystemError($e->getMessage());
		}

		return true;
	}
}
?>
