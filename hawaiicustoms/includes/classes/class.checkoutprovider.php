<?php
require_once(dirname(__FILE__).'/class.module.php');

/**
* The Interspire Shopping Cart checkout provider base class, used by all checkout modules
*/

define("PAYMENT_PROVIDER_ONLINE", 1);
define("PAYMENT_PROVIDER_OFFLINE", 2);

class ISC_CHECKOUT_PROVIDER extends ISC_MODULE
{
	/**
	 * @var string The type of module this is.
	 */
	protected $type = 'checkout';

	/**
	 * @var integer The type of payment provider that this module offers (online or offline)
	 */
	protected $paymentType = PAYMENT_PROVIDER_ONLINE;

	/**
	 * @var integer If this payment module should force the status of an order to something other than the default, set it here.
	 */
	protected $forcedStatus = 0;

	/**
	 * @var boolean Disable the checkout links/buttons everywhere except on the main cart page
	 */
	public $disableNonCartCheckoutButtons = false;

	/**
	* @var boolean Show the provider in the list of providers on the checkout page (if there is more than 1)
	*/
	public $showOnConfirmPage = true;

	/**
	 * @var boolean Does this provider support orders from more than one vendor?
	 */
	protected $supportsVendorPurchases = false;

	/**
	 * @var boolean Does this provider support shipping to multiple addresses?
	 */
	protected $supportsMultiShipping = false;

	/**
	 * @var boolean True if this checkout module requires SSL or not. Defaults to false.
	 */
	protected $requiresSSL = false;

	/**
	 * @var int The payment status to return for this order.
	 */
	protected $paymentStatus = null;

	/**
	 * @var array An array of payment fields that can be shown when creating/editing an order via the control panel.
	 */
	protected $manualPaymentFields = array();

	/**
	 * @var array The details about the order(s) being passed to this checkout provider.
	 */
	private $orderData = array();

	/**
	 * Check if this payment module is accessible by the customer. This is useful for
	 * checking if, for example, the billing address of an order is a specific country.
	 *
	 * @return boolean True if accessible by the customer, false if not.
	 */
	public function IsAccessible()
	{
		return true;
	}

	/**
	 * Get the configured display name for this payment provider. Will read the 'displayname'
	 * setting for this module if it has one.
	 *
	 * @return string The display name for this module.
	 */
	public function GetDisplayName()
	{
		if($this->GetValue('displayname')) {
			return $this->GetValue('displayname');
		}
		else {
			return $this->GetName();
		}
	}

	/**
	 * Return the payment type for this module (either online or offline).
	 * Optionally as a string or number format.
	 *
	 * @param string What to return as. number for a numeric value, text for the text equivalent.
	 * @return mixed Integer if returning as a number, otherwise a string.
	 */
	public function GetPaymentType($returnAsWhat = "number")
	{
		// Kept for backwards compatibility
		if(isset($this->_paymenttype)) {
			$this->paymentType = $this->_paymenttype;
		}

		if($returnAsWhat == "number") {
			return $this->paymentType;
		}
		else if($returnAsWhat == "text") {
			if($this->paymentType == PAYMENT_PROVIDER_ONLINE) {
				return "PAYMENT_PROVIDER_ONLINE";
			}
			else {
				return "PAYMENT_PROVIDER_OFFLINE";
			}
		}
	}

	/**
	 * Checks if the payment module requires SSL to be enabled on the store or not.
	 *
	 * @return boolean True if SSL is required, false if not.
	 */
	public function RequiresSSL()
	{
		// For backwards compatibility, check if _requiresSSL is set.
		if(isset($this->_requiresSSL)) {
			return $this->_requiresSSL;
		}

		return $this->requiresSSL;
	}

	/**
	 * Check if this payment module is enabled or not.
	 *
	 * @return boolean True if enabled, false if not.
	 */
	public function CheckEnabled()
	{
		$checkout_methods = explode(",", GetConfig('CheckoutMethods'));
		if(in_array($this->GetId(), $checkout_methods)) {
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * Build a property/configuration sheet for this checkout module.
	 *
	 * @param string The ID of the tab.
	 * @return string The generated configuration page/sheet.
	 */
	public function GetPropertiesSheet($tabId)
	{

		$this->tabId = $tabId;

		$GLOBALS['CheckoutJavaScript'] = "";
		$GLOBALS['HelpText'] = $this->GetHelpText();
		$GLOBALS['HelpIcon'] = "success";
		$GLOBALS['Properties'] = "";
		$GLOBALS['CheckoutId'] = $this->GetName();
		$GLOBALS['PropertyBox'] = "";
		$GLOBALS['PropertyName'] = "";
		$GLOBALS['HelpTip'] = "";
		$GLOBALS['PanelBottom'] = "";
		$GLOBALS['FieldId'] = 0;
		$GLOBALS['Required'] = '';

		// If the payment provider requires SSL (such as eWay, because the credit card details are collected and sent)
		// then show a warning message if it isn't enabled

		if($this->RequiresSSL() && !GetConfig('UseSSL')) {
			$GLOBALS['HideSSLError'] = "";
		}
		else {
			$GLOBALS['HideSSLError'] = "none";
		}

		$mod_dir = str_replace($this->type.'_', '', $this->GetId());

		$GLOBALS['HideSelectAllLinks'] = 'display: none';

		// Add the logo
		$image = $this->GetImage();
		if ($image != "") {
			$GLOBALS['HelpTip'] = "";
			$GLOBALS['PropertyBox'] = sprintf("<img style='margin-top:5px' src='%s' />", $this->GetImage());
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("module.property");
			$GLOBALS['Properties'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
		}

		// Build the JavaScript to check the fields if required
		$GLOBALS['CheckoutJavaScript'] .= sprintf("
			if(checkout_selected('%s')) {
		", $this->GetId());

		$i = 0;
		$propertyCount = count($this->GetCustomVars());
		foreach($this->GetCustomVars() as $id=>$var) {
			$GLOBALS['PropertyBox'] = "";
			$GLOBALS['PropertyName'] = $var['name'] . ":";
			$GLOBALS['HelpTip'] = "";

			$GLOBALS['FieldId'] = $this->GetId().'_'.$id;


			if($var['required']) {
				$GLOBALS['Required'] = '<span class="Required">*</span>';
			}
			if($var['type'] == 'dropdown' && isset($var['multiselect']) && $var['multiselect'] == true) {
				$GLOBALS['HideSelectAllLinks'] = '';
			}
			else {
				$GLOBALS['HideSelectAllLinks'] = 'display: none';
			}

			$GLOBALS['PropertyBox'] = $this->_buildformitem($id, $var);
			$help_id = rand(1000,100000);

			++$i;
			$GLOBALS['PanelBottom'] = '';
			if($i == $propertyCount) {
				$GLOBALS['PanelBottom'] = "PanelBottom";
			}

			if($var['help'] != "") {
				$GLOBALS['HelpTip'] = sprintf("<img onmouseout=\"HideHelp('d%d')\" onmouseover=\"ShowHelp('d%d', '%s', '%s')\" src=\"images/help.gif\" width=\"24\" height=\"16\" border=\"0\"><div style=\"display:none\" id=\"d%d\"></div>", $help_id, $help_id, $var['name'], $var['help'], $help_id);
			}

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("module.property");
			$GLOBALS['Properties'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
		}
		$GLOBALS['CheckoutJavaScript'] .= $GLOBALS['ValidationJavascript'];
		$GLOBALS['CheckoutJavaScript'] .= "}";

		// Hide the heading of the property sheet if there aren't any properties
		if(count($this->GetCustomVars()) == 0) {
			$GLOBALS['HidePropSheet'] = "none";
		}
		else {
			$GLOBALS['HidePropSheet'] = "";
		}

		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("module.propertysheet");
		$sheet = $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
		return $sheet;
	}

	/**
	 * Redirect to a payment provider with the specified hidden form fields.
	 *
	 * @param string The URL to redirect to.
	 * @param array An array of form fields to POST, if any.
	 */
	protected function RedirectToProvider($url, $fields=array())
	{
		$formFields = '';
		foreach($fields as $name => $value) {
			$formFields .= "<input type=\"hidden\" name=\"".isc_html_escape($name)."\" value=\"".isc_html_escape($value)."\" />\n";
		}
		echo '
			<html>
			<head>
				<title>'.GetLang('Redirecting').'</title>
				<meta http-equiv="Content-Type" content="text/html; charset='.GetConfig('CharacterSet').'" />
			</head>
			<body>
			<form action="'.$url.'" method="post" style="margin-top: 50px; text-align: center;">
				<noscript><input type="submit" value="'.GetLang('ClickIfNotRedirected').'" /></noscript>
				<div id="ContinueButton" style="display: none;">
					<input type="submit" value="'.GetLang('ClickIfNotRedirected').'" />
				</div>
				'.$formFields.'
			</form>
			<script type="text/javascript">
				window.onload = function() {
					document.forms[0].submit();
					setTimeout(function() {
						document.getElementById("ContinueButton").style.display = "";
					}, 1000);
				}
			</script>
			</body>
			</html>
		';
		exit;
	}

	/**
	 * Redirect to the order confirmation page again, with an optional message.
	 *
	 * @param string The message, if we have one.
	 */
	protected function RedirectToOrderConfirmation($reason="")
	{
		if($reason) {
			$_SESSION['REDIRECT_TO_CONFIRMATION_MSG'] = $reason;
		}
		header("Location: ".$GLOBALS['ShopPathSSL']."/checkout.php?action=confirm_order");
		exit;
	}

	/**
	 * Returns the status that this checkout module should force orders to (if there is one)
	 *
	 * @return string The status to force orders to.
	 */
	public function GetForcedStatus()
	{
		return $this->forcedStatus;
	}

	/**
	 * Show any additional payment details/settings at the end of the checkout that
	 * this payment module requires (ie, payment receipt etc). If empty, nothing will be
	 * shown.
	 *
	 * @param array The array of order information.
	 * @return string Any additional data this payment provider may want to show
	 */
	public function DisplayPaymentDetails($order)
	{
		// By default, everything wants to show nothing (now that just sounds cool)
		return '';
	}

	/**
	 * Set the order data/details for the order going through the payment method.
	 * This is called internally, and passes a summary of all of the possible orders
	 * as well as each individual order.
	 *
	 * @param array An array of information about the order.
	 */
	public function SetOrderData($orderData)
	{
		$this->orderData = $orderData;
	}

	/**
	 * Verify that the payment for an order was successfully processed.
	 *
	 * @return boolean True if successful and the order is valid, false if not.
	 */
	public function VerifyOrderPayment()
	{
		return true;
	}

	/**
	 * Set the payment status of the order.
	 *
	 * @param int The payment status to set the orders to.
	 */
	protected function SetPaymentStatus($status)
	{
		$this->paymentStatus = $status;
	}

	/**
	 * Get the set payment status.
	 */
	public function GetPaymentStatus()
	{
		return $this->paymentStatus;
	}

	/**
	 * Return an array of all of the actual orders being processed by this payment
	 * gateway.
	 *
	 * @return array An array of the orders being processed.
	 */
	protected function GetOrders()
	{
		return $this->orderData['orders'];
	}

	/**
	 * Get the total amount that's being processed by this payment gateway.
	 * The ordgatewayamount column for every single order being processed will be the
	 * total for the entire order, so we simply return the amount for one of the orders
	 * being processed.
	 *
	 * @return string The amount to be processed by this checkout method.
	 */
	protected function GetGatewayAmount()
	{
		reset($this->orderData['orders']);
		$order = current($this->orderData['orders']);
		return $order['ordgatewayamount'];
	}

	/**
	 * Gets the total amount for shipping that's being processed by this gateway.
	 * Returns a totalled amount of the ordshipcost for each of the orders being
	 * processed.
	 *
	 * @return string The total amount of the shipping costs.
	 */
	protected function GetShippingCost()
	{
		$amount = 0;
		foreach($this->orderData['orders'] as $order) {
			$amount += $order['ordshipcost'];
		}
		return $amount;
	}

	/**
	 * Gets the total amount for handling that's being processed by this gateway.
	 * Returns a totalled amount of the ordhandlingcost for each of the orders being
	 * processed.
	 *
	 * @return string The total amount of the handling costs.
	 */
	protected function GetHandlingCost()
	{
		$amount = 0;
		foreach($this->orderData['orders'] as $order) {
			$amount += $order['ordhandlingcost'];
		}
		return $amount;
	}

	/**
	 * Gets the total amount for for tax that's being charged ON TOP of the subtotal by this gateway.
	 * Returns a totalled amount of the ordtaxcost for each of the orders being
	 * processed where the tax is NOT included.
	 *
	 * @return string The total amount of tax.
	 */
	protected function GetTaxCost()
	{
		$amount = 0;
		foreach($this->orderData['orders'] as $order) {
			if(!$order['ordtotalincludestax']) {
				$amount += $order['ordtaxtotal'];
			}
		}
		return $amount;
	}

	/**
	 * Get the total amount of all of the orders (before any gift certificates)
	 * or store credit etc are applied. Use GetGatewayAmount() to determine the amount
	 * to be charged via a payment gateway. Totals the amount from all active orders.
	 *
	 * @return string The total amount of all of the orders.
	 */
	protected function GetTotalAmount()
	{
		$amount = 0;
		foreach($this->orderData['orders'] as $order) {
			$amount += $order['ordtotalamount'];
		}
		return $amount;
	}

	/**
	 * Get the subtotal for all of the items in all of the orders.
	 *
	 * @return string The subtotal amount of all of the orders.
	 */
	protected function GetSubTotal()
	{
		$amount = 0;
		foreach($this->orderData['orders'] as $order) {
			$amount += $order['ordsubtotal'];
		}
		return $amount;
	}

	/**
	 * Check if all of the orders going through the payment gateway are digital.
	 *
	 * @return boolean True if all are digital orders.
	 */
	protected function IsDigitalOrder()
	{
		foreach($this->orderData['orders'] as $order) {
			if(!$order['ordisdigital']) {
				return false;
			}
		}
		return true;
	}

	/**
	 * Get the currency ID that these orders were placed in. This is used
	 * for showing currency localized amounts/prices. (All orders for a vendor order)
	 * will be placed in the same currency.
	 *
	 * @return integer The ID of the currency.
	 */
	protected function GetCurrency()
	{
		$order = current($this->orderData['orders']);
		return $order['ordcurrencyid'];
	}


	/**
	 * Get the id of the customer who placed these orders.
	 *
	 * @return string The customer id.
	 */
	protected function GetCustomerId()
	{
		$order = current($this->orderData['orders']);
		return $order['ordcustid'];
	}

	/**
	 * Get the IP address of the customer who placed these orders.
	 *
	 * @return string The IP address of the customer.
	 */
	protected function GetIpAddress()
	{
		$order = current($this->orderData['orders']);
		return $order['ordipaddress'];
	}

	/**
	 * Get the status of the orders being processed through the payment gateway.
	 * All statuses will be the same, so simply fetch for the first order and return that.
	 *
	 * @return int The order status.
	 */
	protected function GetOrderStatus()
	{
		$order = current($this->orderData['orders']);
		return $order['ordstatus'];
	}

	/**
	 * Return an array of all of the billing details (name, address etc)
	 * for these orders. The billing address for all orders will be the same
	 * (can't have split billing addresses) so we simply fetch for the current
	 * order and return that.
	 *
	 * @return array An array of billing details.
	 */
	protected function GetBillingDetails()
	{
		$details = array();
		reset($this->orderData['orders']);
		$order = current($this->orderData['orders']);
		foreach($order as $field => $value) {
			if(substr($field, 0, 7) == 'ordbill') {
				$details[$field] = $value;
			}
		}

		return $details;
	}

	/**
	 * Return an array of all of the shipping addresses/details for an order.
	 * Each order may have it's own shipping address, so we simply return an array
	 * that can possibly contain several shipping addresses (indexed by order ID)
	 *
	 * @return array An array of shipping addresses.
	 */
	protected function GetShippingAddresses()
	{
		$addresses = array();
		reset($this->orderData['orders']);
		foreach($this->orderData['orders'] as $order) {
			$address = array();
			foreach($order as $field => $value) {
			if(substr($field, 0, 7) == 'ordship') {
					$address[$field] = $value;
				}
			}
			$addresses[$order['orderid']] = $address;
		}
		return $addresses;
	}

	/**
	 * Update one or more orders in the database that are currently handled by
	 * this payment gateway. Also updates the internal cache of order information.
	 *
	 * @param array An array of fields to be updated.
	 * @param array Optionally an array of specific orders to update (otherwise, assumes all)
	 */
	protected function UpdateOrders($what, $orderIds=array())
	{
		if(empty($orderIds)) {
			$orderIds = array_keys($this->orderData['orders']);
		}
		else if(!is_array($orderIds)) {
			$orderIds = array($orderIds);
		}

		// Update the orders in the database
		$GLOBALS['ISC_CLASS_DB']->UpdateQuery('orders', $what, "orderid IN (".implode(',', $orderIds).")");

		// Now update the order info we have cached
		foreach(array_keys($this->orderData['orders']) as $orderId) {
			if(!in_array($orderId, $orderIds)) {
				continue;
			}
			$this->orderData['orders'][$orderId] = array_merge($this->orderData['orders'][$orderId], $what);
		}
	}

	/**
	 * Return the billing country for these orders. This method is also available
	 * if the pending orders are yet to be saved in the database.
	 *
	 * @return integer The billing country ID for the order.
	 */
	protected function GetBillingCountry()
	{
		// If we have an order loaded, we can simply use that
		if(!empty($this->orderData)) {
			$billingDetails = $this->GetBillingDetails();
			return $billingDetails['ordbillcountryid'];
		}

		// Order hasn't gone through the checkout yet
		$GLOBALS['ISC_CLASS_CHECKOUT'] = GetClass('ISC_CHECKOUT');
		$billingAddress = $GLOBALS['ISC_CLASS_CHECKOUT']->GetBillingAddress(true);
		if (is_array($billingAddress)) {
			return $billingAddress['shipcountryid'];
		}

		return false;
	}

	/**
	 * Checks if the current checkout module is compatible with vendor (split order)
	 * purchases.
	 *
	 * @return boolean True if compatible, false if not.
	 */
	public function IsVendorCompatible()
	{
		return (bool)$this->supportsVendorPurchases;
	}

	/**
	 * Checks if the current module is compatible with orders that have multiple
	 * shipping addresses.
	 *
	 * @return boolean True if compatible, false if not.
	 */
	public function IsMultiShippingCompatible()
	{
		return (bool)$this->supportsMultiShipping;
	}

	/**
	 * Creates a unique order id by combining all order ids together
	 *
	 * @return string A string of order ids.
	 */
	public function GetCombinedOrderId()
	{
		$orders = $this->GetOrders();

		if (!is_array($orders)) {
			return false;
		}

		ksort($orders);
		$combinedId = '';

		foreach ($orders as $order) {
			$combinedId .= $order['orderid'];

			if (isset($combinedId{30})) {
				$combinedId = substr($combinedId,0,30);
				break;
			}
		}

		return $combinedId;
	}

	/**
	 * Return a list of any manual payment fields that should be shown when creating/editing
	 * an order via the control panel, if any.
	 *
	 * @param array An array containing the details of the existing order, if any.
	 * @return array An array of manual payment fields.
	 */
	public function GetManualPaymentFields($existingOrder=array())
	{
		return $this->manualPaymentFields;
	}

	/**
	 *
	 * DEPRECATED VARIABLES/METHODS.
	 *
	*/

	/**
	 * Set the total for the order.
	 *
	 * @deprecated 4.0
	 * @see SetOrderData()
	 */
	public function SetTotal($total)
	{
	}

	/**
	 * Return the total for an order.
	 *
	 * @deprecated 4.0
	 * @see GetGatewayAmount()
	 */
	protected function GetTotal()
	{
		return $this->GetGatewayAmount();
	}
}

?>