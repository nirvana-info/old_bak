<?php

class CHECKOUT_2CHECKOUT extends ISC_CHECKOUT_PROVIDER
{
	/*
		The 2Checkout seller ID
	*/
	private $_sellerid = 0;

	/*
		The secret word to verify the order
	*/
	private $_secretword = "";

	/*
		Should the order be passed through in test mode?
	*/
	private $_testmode = "";

	/**
	 * @var boolean Does this provider support orders from more than one vendor?
	 */
	protected $supportsVendorPurchases = true;

	/**
	 * The constructor.
	 */
	public function __construct()
	{
		// Setup the required variables for the 2Checkout checkout module
		parent::__construct();
		$this->SetName(GetLang('2CheckoutName'));
		$this->SetImage("2checkout_logo.gif");
		$this->SetDescription(GetLang('2CheckoutDesc'));
		$this->SetHelpText(sprintf(GetLang('2CheckoutHelp'), $GLOBALS['ShopPathSSL']));
	}

	/**
	 * Set up the configuration options for this module.
	 */
	public function SetCustomVars()
	{

		$this->_variables['displayname'] = array("name" => "Display Name",
		   "type" => "textbox",
		   "help" => GetLang('DisplayNameHelp'),
		   "default" => $this->GetName(),
		   "required" => true
		);

		$this->_variables['sellerid'] = array("name" => "Seller ID",
		   "type" => "textbox",
		   "help" => GetLang('2CheckoutSellerIdHelp'),
		   "default" => "",
		   "required" => true
		);

		$this->_variables['secretword'] = array("name" => "Secret Word",
		   "type" => "password",
		   "help" => GetLang('2CheckoutSecretWordHelp'),
		   "default" => "",
		   "required" => true
		);

		$this->_variables['testmode'] = array("name" => "Test Mode",
		   "type" => "dropdown",
		   "help" => GetLang('2CheckoutTestModeHelp'),
		   "default" => "no",
		   "required" => true,
		   "options" => array(GetLang('2CheckoutTestModeNo') => "NO",
						  GetLang('2CheckoutTestModeYes') => "YES"
			),
			"multiselect" => false
		);
	}

	/**
	*	Redirect the customer to 2Checkout's site to enter their payment details
	*/
	public function TransferToProvider()
	{
		$total = $this->GetGatewayAmount();
		$this->_sellerid = trim($this->GetValue("sellerid"));
		$testmode_on = $this->GetValue("testmode");

		$orders = $this->GetOrders();
		list(,$order) = each($orders);

		$billingDetails = $this->GetBillingDetails();
		$shippingAddresses = $this->GetShippingAddresses();
		$shippingDetails = current($shippingAddresses);

		$hiddenFields = array(
			'id_type'				=> 1,
			'provider'				=> 'checkout_2checkout',
			'sid'					=> $this->_sellerid,
			'cart_order_id'			=> $order['orderid'],
			'isc_order_id'			=> $_COOKIE['SHOP_ORDER_TOKEN'],
			'fixed'					=> 'Y',
			'total'					=> number_format($total, 2, '.', ''),
			'sh_cost'				=> number_format($this->GetShippingCost(), 2, '.', ''),


			// Billing Details
			'card_holder_name'		=> $billingDetails['ordbillfirstname'].' '.$billingDetails['ordbilllastname'],
			'street_address'		=> $billingDetails['ordbillstreet1'],
			'city'					=> $billingDetails['ordbillsuburb'],
			'state'					=> $billingDetails['ordbillstate'],
			'zip'					=> $billingDetails['ordbillzip'],
			'country'				=> $billingDetails['ordbillcountry'],
			'phone'					=> $billingDetails['ordbillphone'],
			'email'					=> $billingDetails['ordbillemail'],

			// Shipping Details
			'ship_name'				=> $shippingDetails['ordshipfirstname'].' '.$shippingDetails['ordshiplastname'],
			'ship_street_address'	=> $shippingDetails['ordshipstreet1'],
			'ship_city'				=> $shippingDetails['ordshipsuburb'],
			'ship_state'			=> $shippingDetails['ordshipstate'],
			'ship_zip'				=> $shippingDetails['ordshipzip'],
			'ship_country'			=> $shippingDetails['ordshipcountry']
		);

		if($testmode_on == "YES") {
			$hiddenFields['demo']			= 'Y';
			$hiddenFields['cart_order_id']	= 1;
		}

		$orderIds = implode(',', array_keys($orders));

		$itemFields = '';
		// Get the items in the order
		$query = "
			SELECT *
			FROM [|PREFIX|]order_products
			WHERE orderorderid IN (".$orderIds.")
		";
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		$i = 0;
		while($product = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$fieldSuffix = '';
			if($i > 0) {
				$fieldSuffix = "_".$i;
			}

			if($product['ordprodtype'] == PT_DIGITAL) {
				$tangible = 'N';
			}
			else {
				$tangible = 'Y';
			}

			$hiddenFields['c_description'.$fieldSuffix] = substr($product['ordprodname'], 0, 254);
			$hiddenFields['c_prod'.$fieldSuffix]		= $product['ordprodid'].','.$product['ordprodqty'];
			$hiddenFields['c_name'.$fieldSuffix]		= substr($product['ordprodname'], 0, 128);
			$hiddenFields['c_price'.$fieldSuffix]		= number_format($product['ordprodcost'], 2, '.', '');
			$hiddenFields['c_tangible'.$fieldSuffix]	= $tangible;
			++$i;
		}

		$this->RedirectToProvider('https://www.2checkout.com/2co/buyer/purchase', $hiddenFields);
	}

	/**
	 *	Return the unique order token which was saved as a cookie pre-payment.
	 *
	 * @return string The order token.
	 */
	public function GetOrderToken()
	{
		return @$_REQUEST['isc_order_id'];
	}

	/**
	 * Verify the order was successful on the "Thank you" page.
	 */
	public function VerifyOrderPayment()
	{
		$this->_secretword = trim($this->GetValue("secretword"));
		$testmode_on = $this->GetValue("testmode");

		if(isset($_REQUEST['total']) && isset($_REQUEST['credit_card_processed']) && isset($_REQUEST['order_number']) && isset($_REQUEST['sid'])) {
			$total = $_REQUEST['total'];
			$cc_proc = $_REQUEST['credit_card_processed'];
			$vendor_id = $_REQUEST['sid'];
			$hash_2co = $_REQUEST['key'];

			if(isset($_REQUEST['demo']) && isc_strtoupper($_REQUEST['demo']) == "Y" && $testmode_on == "YES") {
				$order_no = 1;
			} else {
				$order_no = $_REQUEST['order_number'];
			}

			// Workout the hash, which is MD5(secret_word+vendor_number+order_number+total)
			$calc_hash = isc_strtoupper(md5(sprintf("%s%s%s%s", $this->_secretword, $vendor_id, $order_no, $total)));

			// The order total must match and the hash must match too
			if($this->GetGatewayAmount() == $total && $calc_hash == $hash_2co && $cc_proc == "Y") {
				$this->SetPaymentStatus(PAYMENT_STATUS_PAID);
				$GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess(array('payment', $this->GetName()), GetLang('2CheckoutSuccess'));
				return true;
			}
			else {
				$this->SetPaymentStatus(PAYMENT_STATUS_DECLINED);
				$errorMsg = sprintf(GetLang('2CheckoutErrorMismatchMsg'), $total, $this->GetGatewayAmount(), $hash_2co, $calc_hash, $cc_proc);
				$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('payment', $this->GetName()), GetLang('2CheckoutErrorMismatch'), $errorMsg);
				return false;
			}
		}
		else {
			$this->SetPaymentStatus(PAYMENT_STATUS_DECLINED);
			$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('payment', $this->GetName()), GetLang('2CheckoutErrorOrderId'));
			return false;
		}
	}
}

?>