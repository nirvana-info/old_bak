<?php

	class CHECKOUT_BPAY extends ISC_CHECKOUT_PROVIDER
	{

		/*
			Does this payment provider require SSL?
		*/
		public $requiresSSL = false;

		/*
			The help text that will be displayed post-checkout
		*/
		public $_paymenthelp = "";

		/**
		 * @var boolean Does this provider support orders from more than one vendor?
		 */
		protected $supportsVendorPurchases = true;

		/**
		 * @var boolean Does this provider support shipping to multiple addresses?
		 */
		protected $supportsMultiShipping = true;

		/*
			Checkout class constructor
		*/
		public function __construct()
		{
			// Setup the required variables for the BPAY checkout module
			parent::__construct();
			$this->_name = GetLang('BPAYName');
			$this->_description = GetLang('BPAYDesc');
			$this->_image = "BPAY_logo.gif";
			$this->_help = GetLang('BPAYHelp');
			$this->_height = 0;

			// This is an offline payment method
			$this->paymentType = PAYMENT_PROVIDER_OFFLINE;
		}

		/**
		 * Check if this checkout method is accessible by the current customer.
		 * Useful for checking things such as available countries etc.
		 *
		 * @return boolean True if accessible, false if not.
		 */
		public function IsAccessible()
		{
			$availableCountries = $this->GetValue('availablecountries');

			if(!is_array($availableCountries)) {
				$availableCountries = array($availableCountries);
			}

			// Always available if we're in the control panel
			if(defined('ISC_ADMIN_CP')) {
				return true;
			}

			// Available in all countries
			if(in_array('all', $availableCountries)) {
				return true;
			}

			// Otherwise we need to check against the billing address
			$billingCountry = $this->GetBillingCountry();
			if($billingCountry === false) {
				return true;
			}
			// We're in the available countries - return true
			else if(in_array($billingCountry, $availableCountries)) {
				return true;
			}
			// Not available here, return false.
			else {
				return false;
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

			$this->_variables['displayname'] = array("name" => GetLang('BPAYDisplayName'),
			   "type" => "textbox",
			   "help" => GetLang('DisplayNameHelp'),
			   "default" => $this->GetName(),
			   "required" => true
			);

			$this->_variables['billercode'] = array("name" => GetLang('BPAYBillerCode'),
			   "type" => "textbox",
			   "help" => GetLang('BPAYBillerCodeHelp'),
			   "default" => "",
			   "required" => true,
			);

			$this->_variables['availablecountries'] = array("name" => GetLang('BPAYAvailableCountries'),
			   "type" => "dropdown",
			   "help" => GetLang('BPAYAvailableCountriesHelp'),
			   "default" => "all",
			   "required" => true,
			   "options" => GetCountryListAsNameValuePairs(),
				"multiselect" => true
			);
		}

		/**
		*	Return the BPAY details needed to pay for the order
		*/
		public function getofflinepaymentmessage()
		{
			// We can only pass one of the orders for the reference code, so pass the first one in the stack
			$orders = $this->GetOrders();
			list(,$order) = each($orders);

			$billercode = $this->GetValue("billercode");
			$billhtml = "<div style = 'width: 300px; position: relative; top: -30px; left: -25px;'>
							<div class='FloatLeft'>
								<img src='".$GLOBALS['ShopPath']."/modules/checkout/bpay/images/BPAY_logo.gif'>
							</div>
							<div class='FloatRight' style='padding: 10px; width: 120px; height:43px; border: 1px #151B54 solid; color: #151B54; font-size: 13px;'><strong>Biller Code: </strong>".$billercode."
								<strong>Ref: </strong>".str_pad($order['orderid'],10,0,STR_PAD_LEFT).
							"</div>
						</div>";
			return $billhtml;
		}
	}
?>