<?php

class GOOGLE_CHECKOUT_HANDLER
{
	// The Interspire Checkout Module (checkout_googlecheckout)
	private $module = null;

	// The google response object
	private $response = null;

	// The google request object
	private $request = null;

	// A shortcut for logging in this class
	private $logtype = null;

	/**
	 * The constructor. If you pass in xml_response then it will automatically call HandleRequest for you too
	 *
	 * @return void
	 **/
	public function __construct($xml_response = null)
	{
		// If the google checkout module is not enabled and configured we don't need to do anything
		GetModuleById('checkout', $this->module, 'checkout_googlecheckout');

		if (!$this->module) {
			$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('payment', 'checkout_googlecheckout'), 'Google checkout not configured.');
			die();
		}

		$this->logtype = array('payment', $this->module->_name);

		require_once(dirname(__FILE__).'/library/googleresponse.php');
		$this->response = new GoogleResponse($this->module->GetValue('merchantid'), $this->module->GetValue('merchanttoken'));

		if ($xml_response !== null) {
			$this->HandleRequest($xml_response);
		}
	}

	/**
	 * Handle an xml request and perform actions based on the type of request
	 *
	 * @param string the raw xml request
	 *
	 * @return void
	 **/
	public function HandleRequest($xml_response)
	{
		list($root, $data) = $this->response->GetParsedXML($xml_response);
		$this->response->SetMerchantAuthentication($this->module->GetValue('merchantid'), $this->module->GetValue('merchanttoken'));
		$status = $this->response->HttpAuthentication();
		if(!$status) {
			$GLOBALS['ISC_CLASS_LOG']->LogSystemError($this->logtype, sprintf(GetLang('GoogleCheckoutHandlerInvalidAuth'), isc_html_escape(GetIp())));
			die();
		}

		$this->module->DebugLog($xml_response);

		$GLOBALS['ISC_CLASS_LOG']->LogSystemDebug($this->logtype, 'Authenticated request of type '.isc_html_escape($root).' recieved.');

		switch ($root) {
			case "request-received":
			case "error":
			case "diagnosis":
			case "checkout-redirect":
			{
				break;
			}
			case "new-order-notification":
			{
				$this->module->cartid = $data[$root]['shopping-cart']['merchant-private-data']['VALUE'];

				$GLOBALS['ISC_CLASS_LOG']->LogSystemDebug($this->logtype, 'New order notification recieved for cart id: '.isc_html_escape($this->module->cartid));

				$this->CreateOrder();

				$this->response->SendAck();
				break;
			}
			case "order-state-change-notification":
			{
				$this->HandleStateChange($data[$root]);
				$this->response->SendAck();
				break;
			}
			case "charge-amount-notification":
			{
				$this->HandleAmountNotification($root, $data);
				$this->response->SendAck();
				break;
			}
			case "chargeback-amount-notification":
			{
				$this->HandleAmountNotification($root, $data);
				$this->response->SendAck();
				break;
			}
			case "refund-amount-notification":
			{
				$this->HandleAmountNotification($root, $data);
				$this->response->SendAck();
				break;
			}
			case "risk-information-notification":
			{
				$GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess($this->logtype, GetLang('GoogleCheckoutHandlerGotRiskInfo'));
				$this->ProcessRiskInformation($data[$root]);
				$this->response->SendAck();
				break;
			}
			case 'merchant-calculation-callback':
			{
				$this->HandleMerchantCallback($data);
				break;
			}
			default:
			{
				$this->response->SendBadRequestStatus("Invalid or not supported Message");
				break;
			}
		}
	}

	/**
	 * Handle the merchant-calculations-callback request from google. This is for calculating post checkout
	 * adjustments to the order total such as tax, shipping , gift certificates and coupon codes
	 *
	 * @param Array $data The parsed array of data representing the google request
	 *
	 * @return void
	 **/
	private function HandleMerchantCallback($data)
	{
		$root = 'merchant-calculation-callback';

		$this->LoadCart($data[$root]['shopping-cart']['merchant-private-data']['VALUE']);

		include_once(dirname(__FILE__).'/library/googlemerchantcalculations.php');
		include_once(dirname(__FILE__).'/library/googleresult.php');

		$currency = GetDefaultCurrency();

		$merchant_calc = new GoogleMerchantCalculations($currency['currencycode']);

		$addresses = $this->get_arr_result($data[$root]['calculate']['addresses']['anonymous-address']);
		foreach($addresses as $curr_address) {
			$curr_id		= $curr_address['id'];
			$country		= $curr_address['country-code']['VALUE'];
			$city			= $curr_address['city']['VALUE'];
			$region			= $curr_address['region']['VALUE'];
			$postal_code	= $curr_address['postal-code']['VALUE'];

			// Loop through each shipping method if merchant-calculated shipping
			// support is to be provided
			if(isset($data[$root]['calculate']['shipping']['method'])) {
				$shipping = $this->get_arr_result($data[$root]['calculate']['shipping']['method']);
				foreach($shipping as $curr_ship) {
					$costs = $this->CalculateShippingCost($curr_address);

					$name = $curr_ship['name'];

					$zoneInfo = $costs['zone'];
					unset($costs['zone']);

					$merchant_result = new GoogleResult($curr_id);

					$costs = current($costs);

					$found = false;
					$price = 0;

					foreach ($costs as $key => $cost) {
						if ($zoneInfo['zoneid'] == 1) {
							$shipping_name = $cost['description'];
						} else {
							$shipping_name = $cost['description']. ' ('.$zoneInfo['zonename'].')';
						}

						if ($name != $shipping_name) {
							continue;
						}
						//Compute the price for this shipping method and address id
						if (isset($cost['price'])) {
							$price = $cost['price'];
						}

						$merchant_result->SetShippingDetails($name, $price, 'true');

						$found = true;
						break;
					}

					if (!$found) {
						$merchant_result->SetShippingDetails($name, $price, 'false');
					}

					if($data[$root]['calculate']['tax']['VALUE'] == "true") {
						//Compute tax for this address id and shipping type
						$amount = $this->RecalculateTax($data, $price, $name);
						$merchant_result->SetTaxable(true);
						$merchant_result->SetTaxDetails($amount);
					}

					if(isset($data[$root]['calculate']['merchant-code-strings']['merchant-code-string'])) {
						$codes = $this->get_arr_result($data[$root]['calculate']['merchant-code-strings']['merchant-code-string']);
						foreach($codes as $curr_code) {
							$giftcert = $this->ValidateGiftCertificate($curr_code['code'], $data);
							if ($giftcert === false) {
								$coupons = $this->ValidateCouponCode($curr_code['code'], $data);
								$merchant_result->AddCoupons($coupons);
							} else {
								$merchant_result->AddGiftCertificates($giftcert);
							}
						}
					}
					$merchant_calc->AddResult($merchant_result);
				}
			} else {
				$merchant_result = new GoogleResult($curr_id);

				if($data[$root]['calculate']['tax']['VALUE'] == "true") {
					//Compute tax for this address id and shipping type
					$amount = $this->RecalculateTax($data, 0, '');
					$merchant_result->SetTaxable(true);
					$merchant_result->SetTaxDetails($amount);
				}
				if(isset($data[$root]['calculate']['merchant-code-strings']['merchant-code-string'])) {
					$codes = $this->get_arr_result($data[$root]['calculate']['merchant-code-strings']['merchant-code-string']);
					foreach($codes as $curr_code) {
						$giftcert = $this->ValidateGiftCertificate($curr_code['code'], $data);
						if ($giftcert === false) {
							$coupons = $this->ValidateCouponCode($curr_code['code'], $data);
							$merchant_result->AddCoupons($coupons);
						} else {
							$merchant_result->AddGiftCertificates($giftcert);
						}
					}
				}
				$merchant_calc->AddResult($merchant_result);
			}
		}

		$this->module->DebugLog($merchant_calc->GetXML());

		$this->response->ProcessMerchantCalculations($merchant_calc);
	}

	/**
	 * Calculate the tax based on the anonymised address information provided by google
	 *
	 * @param array $data The data representing the google request
	 *
	 * @return void
	 **/
	private function RecalculateTax($data, $amount, $provider)
	{

		$root = 'merchant-calculation-callback';

		foreach ($data[$root]['calculate']['addresses'] as $data_address) {
			$address['shipcity'] = $data_address['city']['VALUE'];
			$address['shipzip'] = $data_address['postal-code']['VALUE'];

			$address['shipcountryid'] = GetCountryIdByISO2($data_address['country-code']['VALUE']);
			$address['shipcountry'] = GetCountryById($address['shipcountryid']);

			$address['shipstateid'] = GetStateByAbbrev($data_address['region']['VALUE'], $address['shipcountryid']);
			$address['shipstate'] = GetStateById($address['shipstateid']);

			$_SESSION['CHECKOUT']['SHIPPING'][0][0] = array("COST"=>$amount, "PROVIDER"=>$provider);
			$_SESSION['CHECKOUT']['SHIPPING_ADDRESS'] = $address;
			$_SESSION['CHECKOUT']['BILLING_ADDRESS'] = $address;

			$GLOBALS['ISC_CLASS_CHECKOUT'] = GetClass('ISC_CHECKOUT');
			$orderSummary = $GLOBALS['ISC_CLASS_CHECKOUT']->CalculateOrderSummary();

			return $orderSummary['taxCost'];
		}
	}

	/**
	 * Calculate the shipping cost for the current order based on the address
	 *
	 * @param array $address The ISC format address array
	 *
	 * @return array
	 **/
	private function CalculateShippingCost($address)
	{
		$shippingDetails = $this->GetAddressFromResponse($address);

		// What shipping zone do we fall under?
		$shippingZoneId = GetShippingZoneIdByAddress($shippingDetails);

		// Save the shipping zone in the session
		$_SESSION['CHECKOUT']['SHIPPING_ZONE'] = $shippingZoneId;

		// Now we have the zone, what available shipping methods do we have?
		$methods = $GLOBALS['ISC_CLASS_CART']->GetAvailableShippingMethods($shippingDetails);
		$methods['zone'] = GetShippingZoneById($shippingZoneId);
		return $methods;
	}

	/**
	 * Revert the session to a previous cart's session
	 *
	 * @param string $cartid The previous session id
	 *
	 * @return void
	 **/
	public function LoadCart($cartid)
	{
		// Load the session that the user had when they were checking out
		session_write_close();
		$session = new ISC_SESSION($cartid);

		if (!isset($_SESSION['CHECKOUT'])) {
			$GLOBALS['ISC_CLASS_LOG']->LogSystemError($this->logtype, sprintf(GetLang('GoogleCheckoutHandlerCantLoadCart'), isc_html_escape($cartid)));
			return;
		}

		$error = '';

		// Load up all of the data for the items in the cart
		$GLOBALS['ISC_CLASS_CART'] = GetClass('ISC_CART');
	}

	/**
	 * Check that a gift certificate is valid to apply
	 *
	 * @param string $code The gift certificate code
	 * @param array $data The google request array
	 *
	 * @return mixed The google gift certificate if is valid, otherwise false
	 **/
	private function ValidateGiftCertificate($code, $data)
	{
		$root = 'merchant-calculation-callback';

		$giftcert = new GoogleGiftcerts("false", $code, 0, GetLang('BadGiftCertificate'));

		if (isc_strlen($code) == GIFT_CERTIFICATE_LENGTH && gzte11(ISC_LARGEPRINT)) {
			$error = '';

			$cart = GetClass('ISC_CART');
			if($cart->api->ApplyGiftCertificate($code)) {
				$certificates = $cart->api->GetGiftCertificates();
				foreach ($certificates as $certid => $certificate) {
					if ($certificate['giftcertcode'] == $code) {
						break;
					}
				}
				// If successful return a valid coupon
				$giftcert = new GoogleGiftcerts('true', $code, $certificate['giftcertamount'], sprintf(GetLang('GiftCertificateAppliedToCart'), $certificate['giftcertcode'], GetConfig('CurrencyToken') . $certificate['giftcertbalance']));
			}
			else {
				$GLOBALS['CheckoutErrorMsg'] = implode("\n", $cart->api->GetErrors());
				$giftcert = new GoogleGiftcerts("false", $code, 0, $error);
			}
		} else {
			return false;
		}
		return $giftcert;
	}

	/**
	 * Check that a coupon code is valid to apply
	 *
	 * @param string $code The coupon code
	 * @param array $data The google request array
	 *
	 * @return object A google coupon
	 **/
	private function ValidateCouponCode($code, $data)
	{
		$error = '';
		$root = 'merchant-calculation-callback';

		static $numCouponsApplied = 0;

		$numCouponsApplied++;

		if ($numCouponsApplied > 1) {
			$invalid_coupon = new GoogleCoupons("false", $code, 0, 'You can only apply 1 coupon code');
			return $invalid_coupon;
		}

		$coupon_result = $GLOBALS['ISC_CLASS_CART']->api->ApplyCoupon($code);

		if (!$coupon_result) {
			$error = implode("\n", $GLOBALS['ISC_CLASS_CART']->api->GetErrors());
			$invalid_coupon = new GoogleCoupons("false", $code, 0, $error);
			return $invalid_coupon;
		}

		$products = $GLOBALS['ISC_CLASS_CART']->api->GetProductsInCart();

		$discount_total = 0;
		$normal_total = 0;

		foreach ($products as $product) {
			if (!isset($product['discount_price'])) {
				continue;
			}
			$discount_total += $product['discount_price'];
			$normal_total += $product['quantity'] * $product['product_price'];
		}
		$coupon_amount = $normal_total - $discount_total;

		$coupon = new GoogleCoupons('true', $code, $coupon_amount, $this->GetCouponName($code));

		//Update this data as required to set whether the coupon is valid, the code and the amount
		return $coupon;
	}

	/**
	 * Get the name of a valid coupon code
	 *
	 * @param string A valid coupon id
	 *
	 * @return String The name of the coupon
	 **/
	public function GetCouponName($couponid)
	{
		$query = "SELECT couponname
		FROM [|PREFIX|]coupons
		WHERE couponcode='".$GLOBALS['ISC_CLASS_DB']->Quote($couponid)."'";
		$name = $GLOBALS['ISC_CLASS_DB']->FetchOne($query);

		return $name;
	}

	/**
	 * Handle an amaount notification for things like charging, refunds etc
	 *
	 * @param string $root The root node of the request
	 * @param array $data The google request array
	 *
	 * @return void
	 **/
	private function HandleAmountNotification($root, $data)
	{
		$googleid = $data[$root]['google-order-number']['VALUE'];
		$orderid = $this->GetOrderIdByGoogleId($googleid);

		$transaction = GetClass('ISC_TRANSACTION');

		switch ($root) {
			case 'charge-amount-notification':
			{
				$amount = $data[$root]['total-charge-amount']['VALUE'];
				$currency = $data[$root]['total-charge-amount']['currency'];
				$message = sprintf(GetLang('GoogleCheckoutTransactionCharge'), FormatPrice($amount), $currency, $orderid);
				$status = TRANS_STATUS_CHARGED;
				break;
			}
			case 'chargeback-amount-notification':
			{
				$amount = $data[$root]['total-chargeback-amount']['VALUE'];
				$currency = $data[$root]['total-chargeback-amount']['currency'];
				$message = sprintf(GetLang('GoogleCheckoutTransactionChargeback'), FormatPrice($amount), $currency, $orderid);
				$status = TRANS_STATUS_CHARGEBACK;

				UpdateOrderStatus($orderid, ORDER_STATUS_CANCELLED, false, true);
				$GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess($this->logtype, sprintf(GetLang('GoogleCheckoutOrderStatusUpdated'), $orderid, GetOrderStatusById(ORDER_STATUS_CANCELLED)));
				break;
			}
			case 'refund-amount-notification':
			{
				$amount = $data[$root]['total-refund-amount']['VALUE'];
				$currency = $data[$root]['total-refund-amount']['currency'];
				$message = sprintf(GetLang('GoogleCheckoutTransactionRefund'), FormatPrice($amount), $currency, $orderid);
				$status = TRANS_STATUS_REFUND;
				UpdateOrderStatus($orderid, ORDER_STATUS_REFUNDED, false, true);
				$GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess($this->logtype, sprintf(GetLang('GoogleCheckoutOrderStatusUpdated'), $orderid, GetOrderStatusById(ORDER_STATUS_REFUNDED)));

				break;
			}
			default:
			{
				$amount = 0;
				$currency = '';
				$message = sprintf(GetLang('GoogleCheckoutTransactionUnknownAmountNotification'), isc_html_escape(print_r($data, true)));
				$status = TRANS_STATUS_ERROR;
				break;
			}
		}

		$transData = array (
			'providerid'		=> 'checkout_googlecheckout',
			'transactiondate'	=> time(),
			'transactionid'		=> $googleid,
			'orderid'			=> $orderid,
			'message'			=> $message,
			'amount'			=> $amount,
			'status'			=> $status,
		);

		$transactionid = $transaction->Create($transData);

		$this->module->DebugLog("Transaction #".$transactionid." created successfully (".$message.")");
	}

	/**
	 * In case the XML API contains multiple open tags with the same value, then invoke this function and perform
	 * a foreach on the resultant array. This takes care of cases when there is only one unique tag or multiple tags.
	 * Examples of this are "anonymous-address", "merchant-code-string" from the merchant-calculations-callback API
	 *
	 * @param string The node
	 *
	 * @return array
	 **/
	private function get_arr_result($child_node)
	{
		$result = array();
		if(isset($child_node)) {
			if($this->is_associative_array($child_node)) {
				$result[] = $child_node;
			}
			else {
				foreach($child_node as $curr_node) {
					$result[] = $curr_node;
				}
			}
		}
		return $result;
	}

	/**
	 * Returns true if a given variable represents an associative array
	 *
	 * @param mixed $var The variable to check if it is an associative array
	 *
	 * @return boolean
	 **/
	private function is_associative_array($var)
	{
		return is_array($var) && !is_numeric(implode('', array_keys($var)));
	}

	/**
	 * Find the ISC order id based on a Google order Id
	 *
	 * @param string The google id
	 *
	 * @return string or false the ISC order id or false if none was found
	 **/
	private function GetOrderIdByGoogleId($googleid)
	{
		static $maps = array();

		if (isset($maps[$googleid])) {
			return $maps[$googleid];
		}

		$query = "SELECT orderid FROM [|PREFIX|]orders WHERE ordpayproviderid = '".$GLOBALS['ISC_CLASS_DB']->Quote($googleid)."'";
		$orderid = $GLOBALS['ISC_CLASS_DB']->FetchOne($query);

		$maps[$googleid] = $orderid;

		if ($orderid === false) {
			$GLOBALS['ISC_CLASS_LOG']->LogSystemError($this->logtype, sprintf(GetLang('GoogleCheckoutMissingOrder'), isc_html_escape($googleid)));
			return false;
		}
		return $orderid;
	}

	/**
	 * Process a risk information notification request
	 *
	 * @param array $data The google request array
	 *
	 * @return void
	 **/
	private function ProcessRiskInformation($data)
	{
		$googleid = $data['google-order-number']['VALUE'];
		$orderid = $this->GetOrderIdByGoogleId($googleid);
		if ($orderid === false) {
			return;
		}

		$approveProtected = (bool) ($this->module->GetValue('autoapproveprotected') === 'YES');

		if ($data['risk-information']['eligible-for-protection']['VALUE'] == 'true' && $approveProtected) {
			UpdateOrderStatus($orderid, ORDER_STATUS_AWAITING_FULFILLMENT, false, true);
		}

		// We only get the customers actual ip when we get the risk information so make sure we update the order with it
		UpdateOrderIpAddress($orderid, $data['risk-information']['ip-address']['VALUE']);
	}

	/**
	 * Handle a change of fulfillment state of an order
	 *
	 * @param array $data The google request array
	 *
	 * @return void
	 **/
	private function HandleFulfillmentStateChange($data)
	{
		$googleid = $data['google-order-number']['VALUE'];

		$orderid = $this->GetOrderIdByGoogleId($googleid);
		if ($orderid === false) {
			return;
		}

		$new_fulfillment_state = $data['new-fulfillment-order-state']['VALUE'];

		switch($new_fulfillment_state) {
			case 'PROCESSING':
			{
				UpdateOrderStatus($orderid, ORDER_STATUS_AWAITING_FULFILLMENT, false, true);
				$GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess($this->logtype, sprintf(GetLang('GoogleCheckoutOrderStatusUpdated'), $orderid, GetOrderStatusById(ORDER_STATUS_AWAITING_FULFILLMENT)));
				break;
			}
			case 'DELIVERED':
			{
				$order = GetOrder($orderid, false);
				if (!OrderIsComplete($order['ordstatus'])) {
					$this->module->debuglog($order);
					UpdateOrderStatus($orderid, ORDER_STATUS_SHIPPED, false, true);
					$GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess($this->logtype, sprintf(GetLang('GoogleCheckoutOrderStatusUpdated'), $orderid, GetOrderStatusById(ORDER_STATUS_SHIPPED)));
				}

				break;
			}
			case 'WILL_NOT_DELIVER':
			{
				UpdateOrderStatus($orderid, ORDER_STATUS_CANCELLED, false, true);
				$GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess($this->logtype, sprintf(GetLang('GoogleCheckoutOrderStatusUpdated'), $orderid, GetOrderStatusById(ORDER_STATUS_CANCELLED)));
				break;
			}
			default:
			break;
		}
	}

	/**
	 * Handle a change of financial state of an order
	 *
	 * @param array $data The google request array
	 *
	 * @return void
	 **/
	private function HandleFinancialStateChange($data)
	{
		$googleid = $data['google-order-number']['VALUE'];

		$orderid = $this->GetOrderIdByGoogleId($googleid);
		if ($orderid === false) {
			return;
		}

		$new_financial_state = $data['new-financial-order-state']['VALUE'];

		switch($new_financial_state) {
			case 'REVIEWING':
			{
				UpdateOrderStatus($orderid, ORDER_STATUS_PENDING, false, true);
				$GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess($this->logtype, sprintf(GetLang('GoogleCheckoutOrderStatusUpdated'), $orderid, GetOrderStatusById(ORDER_STATUS_PENDING)));
				break;
			}
			case 'CHARGEABLE':
			{
				UpdateOrderStatus($orderid, ORDER_STATUS_AWAITING_PAYMENT, false, true);
				$GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess($this->logtype, sprintf(GetLang('GoogleCheckoutOrderStatusUpdated'), $orderid, GetOrderStatusById(ORDER_STATUS_AWAITING_PAYMENT)));
				break;
			}
			case 'CHARGING':
			{
				// We don't need to do anything on our end when Google is midway through charging an order
				break;
			}
			case 'CHARGED':
			{
				$order = GetOrder($orderid, false);

				if (!OrderIsComplete($order['ordstatus'])) {
					$this->module->debuglog($order);

					if ($order['ordisdigital'] == 1) {
						UpdateOrderStatus($orderid, ORDER_STATUS_COMPLETED, true, true);
						$GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess($this->logtype, sprintf(GetLang('GoogleCheckoutOrderStatusUpdated'), $orderid, GetOrderStatusById(ORDER_STATUS_COMPLETED)));
					}
					else {
						$status = $this->GetValue('orderchargestatus');
						if(!$status) {
							$status = ORDER_STATUS_AWAITING_FULFILLMENT;
						}
						UpdateOrderStatus($orderid, $status, false, true);
						$GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess($this->logtype, sprintf(GetLang('GoogleCheckoutOrderStatusUpdated'), $orderid, GetOrderStatusById($status)));
					}
				}
				break;
			}
			case 'PAYMENT_DECLINED':
			{
				UpdateOrderStatus($orderid, ORDER_STATUS_DECLINED, false, true);
				$GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess($this->logtype, sprintf(GetLang('GoogleCheckoutOrderStatusUpdated'), $orderid, GetOrderStatusById(ORDER_STATUS_DECLINED)));
				break;
			}
			case 'CANCELLED':
			{
				UpdateOrderStatus($orderid, ORDER_STATUS_CANCELLED, false, true);
				$GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess($this->logtype, sprintf(GetLang('GoogleCheckoutOrderStatusUpdated'), $orderid, GetOrderStatusById(ORDER_STATUS_CANCELLED)));
				break;
			}
			case 'CANCELLED_BY_GOOGLE':
			{
				UpdateOrderStatus($orderid, ORDER_STATUS_CANCELLED, false, true);
				$GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess($this->logtype, sprintf(GetLang('GoogleCheckoutOrderStatusUpdated'), $orderid, GetOrderStatusById(ORDER_STATUS_CANCELLED)));
				break;
			}
			default:
			break;
		}
	}

	/**
	 * Handle a change of state of an order. Usually it will be just a financial or fullfillment state change
	 * however it technically could be both at once
	 *
	 * @param array $data The google request array
	 *
	 * @return void
	 **/
	private function HandleStateChange($data)
	{
		$new_financial_state = $data['new-financial-order-state']['VALUE'];
		$new_fulfillment_order = $data['new-fulfillment-order-state']['VALUE'];

		$old_financial_state = $data['previous-financial-order-state']['VALUE'];
		$old_fulfillment_order = $data['previous-fulfillment-order-state']['VALUE'];

		if ($new_financial_state !== $old_financial_state) {
			$this->HandleFinancialStateChange($data);
		}
		if ($new_fulfillment_order !== $old_fulfillment_order) {
			$this->HandleFulfillmentStateChange($data);
		}
	}

	/**
	 * Create a new order in ISC based on a new-order-notification from google
	 *
	 * @return void
	 **/
	private function CreateOrder()
	{
		$this->LoadCart($this->module->cartid);

		$pendingOrder = $this->CalculateOrder();

		$cartItems = $GLOBALS['ISC_CLASS_CART']->api->GetProductsInCart();

		$checkoutSession = $_SESSION['CHECKOUT'];
		$pendingData = $checkoutSession['PENDING_DATA'];

		// Get a list of the vendors for all of the items in the cart, and loop through them
		// to build all of the pending orders
		$cartContent = $GLOBALS['ISC_CLASS_CHECKOUT']->BreakdownCartByAddressVendor();

		$vendorOrderInfo = array();
		foreach($cartContent as $vendorId => $addresses) {
			foreach($addresses as $addressId => $products) {
				$allDigital = 1;
				$productArray = array();
				foreach($products as $cartItemId => $product) {
					// A physical product, mark as so
					if ($product['data']['prodtype'] == PT_PHYSICAL) {
						$allDigital = 0;
					}
					// Mark the quantity of this item
					$productArray[$cartItemId] = $product['quantity'];
				}
				$vendorInfo = $pendingData['VENDORS'][$vendorId.'_'.$addressId];
				$vendorData = array(
					'itemtotal' => $vendorInfo['ITEM_TOTAL'],
					'taxcost' => $vendorInfo['TAX_COST'],
					'totalcost' => $vendorInfo['ORDER_TOTAL'],
					'shippingcost' => $_SESSION['CHECKOUT']['SHIPPING'][$vendorId.'_0']['COST'],
					'handlingcost' => $_SESSION['CHECKOUT']['SHIPPING'][$vendorId.'_0']['HANDLING'],
					'shippingprovider' => $_SESSION['CHECKOUT']['SHIPPING'][$vendorId.'_0']['PROVIDER'],
					'shippingmodule' => $_SESSION['CHECKOUT']['SHIPPING'][$vendorId.'_0']['MODULE'],
					'isdigitalorder' => $allDigital,
					'products' => $productArray,
				);

				// Shipping zones can be configured per vendor, so we need to be sure
				// to pass this along correctly too
				if(isset($vendorInfo['SHIPPING_ZONE'])) {
					$shippingZone = GetShippingZoneById($vendorInfo['SHIPPING_ZONE']);
					if(is_array($shippingZone)) {
						$vendorData['ordshippingzoneid'] = $shippingZone['zoneid'];
						$vendorData['ordshippingzone'] = $shippingZone['zonename'];
					}
				}

				$vendorOrderInfo[$vendorId.'_'.$addressId] = $vendorData;
			}
		}

		$this->module->DebugLog($vendorData);

		// Work out the cost of the order, shipping etc
		$pendingOrder['ipaddress'] = '';
		$pendingOrder['vendorinfo'] = $vendorOrderInfo;

		$pendingToken = CreateOrder($pendingOrder, $cartItems);

		if ($pendingToken === false) {
			$GLOBALS['ISC_CLASS_LOG']->LogSystemError($this->logtype, sprint(GetLang('GoogleCheckoutMissingCart'), isc_html_escape($this->module->cartid)));
			return;
		}

		$order = LoadPendingOrderByToken($pendingToken);

		$googleid = $this->response->data['new-order-notification']['google-order-number']['VALUE'];

		$this->SendGoogleNewOrderId($googleid, $order['orderid']);

		$updatedOrder = array(
			'ordpayproviderid' => $googleid,
			'ordpaymentstatus' => 'captured'
		);

		$this->module->DebugLog($order);

		$orderIds = array($order['orderid']);

		// Update the orders in the database
		$GLOBALS['ISC_CLASS_DB']->UpdateQuery('orders', $updatedOrder, "orderid IN (".implode(',', $orderIds).")");

		$completed = CompletePendingOrder($pendingToken, ORDER_STATUS_PENDING, false);

		if ($this->response->data['new-order-notification']['buyer-marketing-preferences']['email-allowed']['VALUE'] == 'true') {
			$this->SubscribeCustomerToLists($order['orderid']);
		}

		if (!$completed) {
			$GLOBALS['ISC_CLASS_LOG']->LogSystemError($this->logtype, sprintf(GetLang('GoogleCheckoutCantCompleteOrder'), isc_html_escape($pendingToken), isc_html_escape(var_export($completed, true))));
			return;
		}

		$orderClass = GetClass('ISC_ORDER');
		$orderClass->EmptyCartAndKillCheckout();

		$GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess($this->logtype, sprintf(GetLang('GoogleCheckoutOrderCreated'), (int) $order['orderid'], isc_html_escape($googleid)));
	}

	/**
	 * Calculate the order details and populate the necessary session fields so we can call CreateOrder()
	 *
	 * @return void
	 **/
	public function CalculateOrder()
	{
		if ($GLOBALS['ISC_CLASS_CART']->api->AllProductsInCartAreIntangible()) {
			$all_digital_downloads = 1;
		}
		else {
			$all_digital_downloads = 0;
		}

		$GLOBALS['ISC_CLASS_CHECKOUT'] = GetClass('ISC_CHECKOUT');
		$orderSummary = $GLOBALS['ISC_CLASS_CHECKOUT']->CalculateOrderSummary();

		$this->module->DebugLog($orderSummary);

		$product_array = $GLOBALS['ISC_CLASS_CART']->api->GetProductsInCart(true);

		$itemTotal = 0;

		foreach ($product_array as $k => $product) {
			$itemTotal += $product['product_price'] * $product['quantity'];
		}

		if (isset($this->response->data[$this->response->root]['order-adjustment']['shipping']['merchant-calculated-shipping-adjustment'])) {
			$shipping = $this->response->data[$this->response->root]['order-adjustment']['shipping']['merchant-calculated-shipping-adjustment'];
		} else {
			$shipping = array (
				'shipping-cost' => array (
					'VALUE' => 0
				),
				'shipping-name' => array (
					'VALUE' => ''
				),
			);
		}

		$shippingCost = $shipping['shipping-cost']['VALUE'];

		$vendorIds = $GLOBALS['ISC_CLASS_CART']->api->GetCartVendorIds();
		$vendorIds = array_pop($vendorIds);

		$_SESSION['CHECKOUT']['PENDING_DATA']['VENDORS'][$vendorIds.'_0'] = array();

		// The cost of shipping
		$_SESSION['CHECKOUT']['SHIPPING'][$vendorIds.'_0']['COST'] = $shippingCost;

		// The handling cost
		$_SESSION['CHECKOUT']['SHIPPING'][$vendorIds.'_0']['HANDLING'] = 0;

		// The name of the tax being applied
		$_SESSION['CHECKOUT']['PENDING_DATA']['TAX_NAME'] = $orderSummary['taxName'];

		// The dollar value of the tax being applied
		$_SESSION['CHECKOUT']['PENDING_DATA']['VENDORS'][$vendorIds.'_0']['TAX_COST'] = $orderSummary['taxCost'];
		$_SESSION['CHECKOUT']['PENDING_DATA']['TAX_COST'] = $orderSummary['taxCost'];

		// The rate the tax is being applied at as a percentage (0-100)
		$_SESSION['CHECKOUT']['PENDING_DATA']['TAX_RATE'] = $orderSummary['taxRate'];

		// Is the tax already being included in the price of the products 0/1
		$_SESSION['CHECKOUT']['PENDING_DATA']['TAX_INCLUDED'] = $orderSummary['taxIncluded'];

		$orderTotal = $itemTotal + $shippingCost;

		if (!$orderSummary['taxIncluded'] && !(GetConfig('TaxTypeSelected') == 2)) {
			$orderTotal += $orderSummary['taxCost'];
		}

		// The total of the order including items, shipping, handling and tax
		$_SESSION['CHECKOUT']['PENDING_DATA']['VENDORS'][$vendorIds.'_0']['ORDER_TOTAL'] = $orderTotal;
		$_SESSION['CHECKOUT']['PENDING_DATA']['VENDORS'][$vendorIds.'_0']['ITEM_TOTAL'] = $itemTotal;

		$_SESSION['CHECKOUT']['PENDING_DATA']['ORDER_TOTAL'] = $orderTotal;

		//$GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess($this->logtype, 'response details '.print_r($this->response, true));

		// The shipping address array
		$_SESSION['CHECKOUT']['SHIPPING_ADDRESS'] = $this->GetAddressFromResponse($this->response->data[$this->response->root]['buyer-shipping-address']);

		// The billing address array
		$_SESSION['CHECKOUT']['BILLING_ADDRESS'] = $this->GetAddressFromResponse($this->response->data[$this->response->root]['buyer-billing-address']);

		// The english name of the provider
		$_SESSION['CHECKOUT']['SHIPPING'][$vendorIds.'_0']['PROVIDER'] = $shipping['shipping-name']['VALUE'];

		// The id of the provider
		$_SESSION['CHECKOUT']['SHIPPING'][$vendorIds.'_0']['MODULE'] = $this->GetShippingProviderModuleByName($shipping['shipping-name']['VALUE']);

		$shippingZoneId = GetShippingZoneIdByAddress($_SESSION['CHECKOUT']['SHIPPING_ADDRESS']);
		$shippingZone = GetShippingZoneById($shippingZoneId);

		// The amount of store credit being applied to the order
		$creditDiscount = 0;

		// The name of the gift certificates being applied
		$giftCertificates = '';

		$giftCertificateDiscount = 0;

		// The total amount of all the gift certs being applied
		$_SESSION['CHECKOUT']['PENDING_DATA']['GIFTCERTIFICATE_AMOUNT'] = $giftCertificateDiscount;

		// The amount being sent to the checkout gateway (order total - gift certifcate discounts - store credit discounts)
		$_SESSION['CHECKOUT']['PENDING_DATA']['GATEWAY_AMOUNT'] = $orderTotal - $creditDiscount - $giftCertificateDiscount;

		//$GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess($this->logtype, 'checkout before creating the pending order '.print_r($_SESSION['CHECKOUT'], true));

		// Now that we're here, we have everything we need to create the pending order.
		// Create it and store it. We hard code the geoip information since google will be
		// making the request
		$selectedCurrency = GetCurrencyById($GLOBALS['CurrentCurrency']);

		$pendingOrder = array (
			'customertoken'			=> '',
			'customerid'			=> 0,
			'itemtotal'				=> $orderSummary['itemTotal'],
			'shippingcost'			=> $_SESSION['CHECKOUT']['SHIPPING'][$vendorIds.'_0']['COST'],
			'handlingcost'			=> $_SESSION['CHECKOUT']['SHIPPING'][$vendorIds.'_0']['HANDLING'],
			'taxname'				=> $_SESSION['CHECKOUT']['PENDING_DATA']['TAX_NAME'],
			'taxcost'				=> $_SESSION['CHECKOUT']['PENDING_DATA']['VENDORS'][$vendorIds.'_0']['TAX_COST'],
			'taxrate'				=> $_SESSION['CHECKOUT']['PENDING_DATA']['TAX_RATE'],
			'totalincludestax'		=> $_SESSION['CHECKOUT']['PENDING_DATA']['TAX_INCLUDED'],
			'totalcost'				=> $_SESSION['CHECKOUT']['PENDING_DATA']['ORDER_TOTAL'],
			'shippingaddress'		=> $_SESSION['CHECKOUT']['SHIPPING_ADDRESS'],
			'billingaddress'		=> $_SESSION['CHECKOUT']['BILLING_ADDRESS'],
			'shippingprovider'		=> $_SESSION['CHECKOUT']['SHIPPING'][$vendorIds.'_0']['PROVIDER'],
			'shippingmodule'		=> $_SESSION['CHECKOUT']['SHIPPING'][$vendorIds.'_0']['MODULE'],
			'paymentmethod'			=> 'checkout_googlecheckout',
			'isdigitalorder'		=> (int) $all_digital_downloads,
			'storecreditamount'		=> $creditDiscount,
			'giftcertificateamount'	=> $_SESSION['CHECKOUT']['PENDING_DATA']['GIFTCERTIFICATE_AMOUNT'],
			'giftcertificates'		=> $giftCertificates,
			'gatewayamount'			=> $_SESSION['CHECKOUT']['PENDING_DATA']['GATEWAY_AMOUNT'],
			'currencyid'			=> $selectedCurrency['currencyid'],
			'currencyexchangerate'	=> $selectedCurrency['currencyexchangerate'],
			'ordshippingzoneid'		=> $shippingZoneId,
			'ordshippingzone'		=> $shippingZone['zonename'],
		);

		return $pendingOrder;
	}

	/**
	 * Get's the shipping provider module id from a name
	 *
	 * @param string $name The name to get the shipping module id for
	 *
	 * @return string
	 **/
	public function GetShippingProviderModuleByName($name)
	{
		// $cost['description']. ' ('.$zoneInfo['zonename'].')'

		$shipping_zones = GetShippingZoneInfo();


		foreach ($shipping_zones as $shipping_zone) {
			if (!isset($shipping_zone['methods']) || !is_array($shipping_zone['methods'])) {
				continue;
			}

			foreach ($shipping_zone['methods'] as $shipping_method) {
				if ($shipping_method['methodname'] == $name) {
					// Check for static method names
					return $shipping_method['methodmodule'];
				}

				if ($shipping_method['methodname']. ' ('.$shipping_zone['zonename'].')' == $name) {
					// Check for static method names
					return $shipping_method['methodmodule'];
				}

				foreach (array_keys($shipping_method['vars']) as $shipping_var) {
					$test_name = $shipping_method['methodname'].' '.$shipping_var;
					if ($test_name == $name) {
						// Check for real time shipping names
						return $shipping_method['methodmodule'];
					}
				}
			}

		}

		return $name;
	}

	/**
	 * Convert a google request format address to an ISC format address
	 *
	 * @param array $top The google formatted address array
	 *
	 * @return array The ISC format address
	 **/
	public function GetAddressFromResponse($top)
	{
		include_once(ISC_BASE_PATH.'/lib/shipping.php');

		$countryid = GetCountryIdByISO2($top['country-code']['VALUE']);

		$address = array (
			'shipcity'		=> $top['city']['VALUE'],
			'shipstate'		=> GetStateNameByAbbrev($top['region']['VALUE'], $countryid),
			'shipzip'		=> $top['postal-code']['VALUE'],
			'shipcountry'	=> GetCountryById($countryid),
			'shipcountryid' => $countryid,
			'shipstateid'	=> GetStateByAbbrev($top['region']['VALUE'], $countryid),
		);

		// If we don't have the contact name then this is an anonymous request so we dont have any of the
		// other personally identifyable information
		if (isset($top['contact-name']['VALUE'])) {

			$name = $top['contact-name']['VALUE'];
			$name = explode(' ', $name, 2);

			$address['shipfirstname']	= $name[0];
			$address['shiplastname']	= $name[1];
			$address['shipaddress1']	= $top['address1']['VALUE'];
			$address['shipaddress2']	= $top['address2']['VALUE'];
			$address['shipcompany']		= $top['company-name']['VALUE'];
			$address['shipemail']		= $top['email']['VALUE'];
			$address['shipphone']		= $top['phone']['VALUE'];
		}

		return $address;
	}

	/**
	 * Subscribe a customer to newsletter and other lists based on their order
	 * if they have opted in to them
	 *
	 * @param array $orderRow An array that is ready to be passed to CreateOrder()
	 *
	 * @return void
	 */
	public function SubscribeCustomerToLists($orderid)
	{
		$orderRow = $this->LoadOrderRow($orderid);

		if ($orderRow === false) {
			return;
		}

		// No point trying to subscribe them if we don't have an email to subscribe them with
		if (trim($orderRow['ordbillemail']) == '') {
			return;
		}

		// If the customer didn't opt in, stop immediately
		if ($this->response->data['new-order-notification']['buyer-marketing-preferences']['email-allowed']['VALUE'] != 'true') {
			return;
		}

		// Should we add them to our newsletter mailing list?
		$this->SubscribeCustomerToNewsletter($orderRow['ordbillemail'], $orderRow['ordbillfirstname']);

		// Should we add them to our special offers & discounts mailing list?
		$this->SubscribeCustomerToOtherLists($orderRow);
	}

	/**
	 * Subscribe a customer to newsletter if they have opted in to them
	 *
	 * @param string $email The customers email
	 * @param string $first_name The customers first name
	 *
	 * @return void
	 */
	public function SubscribeCustomerToNewsletter($email, $first_name)
	{
		// If the customer didn't opt in, stop immediately
		if ($this->response->data['new-order-notification']['buyer-marketing-preferences']['email-allowed']['VALUE'] != 'true') {
			return;
		}

		if(GetConfig('MailXMLAPIValid') && GetConfig('UseMailerForNewsletter') && GetConfig('MailNewsletterList') > 0) {
			// Add them to the Interspire Email Marketer list
			$GLOBALS['ISC_CLASS_ADMIN_SENDSTUDIO'] = GetClass('ISC_ADMIN_SENDSTUDIO');
			$result = $GLOBALS['ISC_CLASS_ADMIN_SENDSTUDIO']->AddSubscriberToNewsletter($first_name, $email);
			if(isset($result['status']) && $result['status'] == "fail") {
				$GLOBALS['ISC_CLASS_LOG']->LogSystemError('ssnx', GetLang('SendStudioErrorNewsletter'), $result['message']);
			}
		}
		else {
			$GLOBALS['ISC_CLASS_SUBSCRIBE'] = GetClass('ISC_SUBSCRIBE');
			$result = $GLOBALS['ISC_CLASS_SUBSCRIBE']->AddSubscriberToNewsletter($first_name, $email);
		}
	}

	/**
	 * Subscribe a customer to any other lists based on their order if they have opted in to them
	 *
	 * @param array $orderRow An array that is ready to be passed to CreateOrder()
	 *
	 * @return void
	 */
	public function SubscribeCustomerToOtherLists($orderRow)
	{
		// If the customer didn't opt in, stop immediately
		if ($this->response->data['new-order-notification']['buyer-marketing-preferences']['email-allowed']['VALUE'] != 'true') {
			return;
		}

		if(GetConfig('MailXMLAPIValid') && GetConfig('UseMailerForNewsletter') && GetConfig('MailNewsletterList') > 0) {
			// Add them to the Interspire Email Marketer orders list
			$GLOBALS['ISC_CLASS_ADMIN_SENDSTUDIO'] = GetClass('ISC_ADMIN_SENDSTUDIO');
			$result = $GLOBALS['ISC_CLASS_ADMIN_SENDSTUDIO']->AddSubscriberToOrderList($orderRow);
			if(isset($result['status']) && $result['status'] == "fail") {
				$GLOBALS['ISC_CLASS_LOG']->LogSystemError('ssnx', GetLang('SendStudioErrorOrderList'), $result['message']);
			}
			else if(isset($result['status'])) {
				$GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess('ssnx', $result['message']);
			}
		}
	}

	/**
	 * Get an order row so we can add the person to any applicable mailing lists
	 *
	 * @param string The order id
	 *
	 * @return array The order row array
	 **/
	public function LoadOrderRow($orderid)
	{
		if (!is_numeric($orderid) || $orderid <= 0) {
			return false;
		}

		$query = "SELECT o.*,
			(select sum(ordprodqty) from [|PREFIX|]order_products where orderorderid=orderid) as numitems
			FROM [|PREFIX|]orders o
			WHERE orderid='".$GLOBALS['ISC_CLASS_DB']->Quote($orderid)."'";

		$row = $GLOBALS['ISC_CLASS_DB']->FetchRow($query);
		$row['custfirstname'] = $row['ordbillfirstname'];
		$row['custlastname'] = $row['ordbilllastname'];
		$row['custemail'] = $row['ordbillemail'];

		return $row;
	}

	/**
	 * Send google a Shopping Cart Id to associate with the google id
	 *
	 * @return void
	 **/
	public function SendGoogleNewOrderId($googleid, $orderid)
	{
		$request_result = $this->module->request->SendMerchantOrderNumber($googleid, $orderid);
	}

}