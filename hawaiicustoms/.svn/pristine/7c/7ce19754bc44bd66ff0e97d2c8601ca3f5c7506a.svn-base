<?php

	require_once(dirname(__FILE__).'/class.module.php');

	/**
	* The Interspire Shopping Cart analytics base class, used by all analytics modules
	*/
	class ISC_ANALYTICS extends ISC_MODULE
	{
		/**
		* @var string $type The type of module this is
		*/
		protected $type = 'analytics';

		/**
		 * @var array The details about the order(s) being passed when generating conversion tracking code.
		 */
		private $orderData = array();

		protected function CheckEnabled()
		{
			$analytics_methods = explode(",", GetConfig('AnalyticsMethods'));
			if(in_array($this->GetId(), $analytics_methods)) {
				return true;
			}
			else {
				return false;
			}
		}

		/*
			Return a HTML-formatted list of properties for this analytics module
		*/
		public function GetPropertiesSheet($tab_id)
		{

			$this->tabId = $tab_id;

			$GLOBALS['JavaScript'] = "";
			$GLOBALS['HelpText'] = $this->gethelptext();
			$GLOBALS['HelpIcon'] = "success";
			$GLOBALS['Properties'] = "";
			$GLOBALS['PackageId'] = $this->GetName();

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
			$GLOBALS['AnalyticsJavaScript'] .= sprintf("
				if(package_selected('%s')) {
			", $this->GetId());

			foreach($this->GetCustomVars() as $id=>$var) {
				$GLOBALS['PropertyBox'] = "";
				$GLOBALS['PropertyName'] = $var['name'] . ":";
				$GLOBALS['HelpTip'] = "";

				$GLOBALS['FieldId'] = $this->GetId().'_'.$id;

				if($var['type'] == 'dropdown' && isset($var['multiselect']) && $var['multiselect'] == true) {
					$GLOBALS['HideSelectAllLinks'] = '';
				}
				else {
					$GLOBALS['HideSelectAllLinks'] = 'display: none';
				}

				$GLOBALS['PropertyBox'] = $this->_buildformitem($id, $var);
				$help_id = rand(1000,100000);

				if($var['help'] != "") {
					$GLOBALS['HelpTip'] = sprintf("<img onmouseout=\"HideHelp('d%d')\" onmouseover=\"ShowHelp('d%d', '%s', '%s')\" src=\"images/help.gif\" width=\"24\" height=\"16\" border=\"0\"><div style=\"display:none\" id=\"d%d\"></div>", $help_id, $help_id, $var['name'], $var['help'], $help_id);
				}

				$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("module.property");
				$GLOBALS['Properties'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
			}

			$GLOBALS['AnalyticsJavaScript'] .= $GLOBALS['ValidationJavascript'];
			$GLOBALS['AnalyticsJavaScript'] .= "}";

			// First check if the analytics provider is configured.
			// If it is, there wil be an entry in the module_vars table
			// with the variable name 'is_setup'

			$query = sprintf("select count(variableid) as is_setup from [|PREFIX|]module_vars where modulename='%s' and variablename='is_setup' and variableval='1'", $GLOBALS['ISC_CLASS_DB']->Quote($this->GetId()));
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

			if(count($this->GetCustomVars()) == 0) {
				// Hide the heading of the property sheet if there aren't any properties
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
		 * Return the tracking code for this analytics module.
		 *
		 * @return string The tracking code.
		 */
		public function GetTrackingCode()
		{
			return $this->GetValue('trackingcode');
		}

		/**
		 * Return the order conversion tracking code for this analytics module.
		 *
		 * @return string The tracking code.
		 */
		public function GetConversionCode()
		{
			return '';
		}

		/**
		 * Set the order data/details that will be used for generating conversion tracking code.
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
		 * Return an array of all of the actual orders being processed by this analytics
		 * module.
		 *
		 * @return array An array of the orders being processed.
		 */
		protected function GetOrders()
		{
			return $this->orderData['orders'];
		}

		/**
		 * Get the total amount that's being processed by this analytics module.
		 * The ordgatewayamount column for every single order being processed will be the
		 * total for the entire order, so we simply return the amount for one of the orders
		 * being processed.
		 *
		 * @return string The amount to be processed by this checkout method.
		 */
		protected function GetGatewayAmount()
		{
			$order = current($this->orderData['orders']);
			return $order['ordgatewayamount'];
		}

		/**
		 * Gets the total amount for shipping that's being processed by this analytics module.
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
		 * Gets the total amount for handling that's being processed by this analytics module.
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
		 * Gets the total amount for for tax that's being charged ON TOP of the subtotal by this analytics module.
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
		 * or store credit etc are applied.
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
		 * Get the status of the orders being processed.
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
	}

?>
