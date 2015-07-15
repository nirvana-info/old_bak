<?php

	/*
		Include the XMLize xml class
	*/
	require_once(ISC_BASE_PATH."/includes/classes/class.xmlize.php");

	/**
	* This is the USPS shipping module for Interspire Shopping Cart. To enable
	* USPS in Interspire Shopping Cart login to the control panel and click the
	* Settings -> Shipping Settings tab in the menu.
	*/
	class SHIPPING_USPS extends ISC_SHIPPING
	{

		/**
		* Variables for the USPS shipping module
		*/

		/*
			The users USPS account username
		*/
		private $_username = "";

		/*
			The UPS service to ship with
		*/
		private $_service = "";

		/*
			The UPS container type
		*/
		private $_container = "";

		/*
			The size of the package
		*/
		private $_size = "";

		/*
			The origin country ISO code for UPS shipments
		*/
		private $_origincountry = "";

		/*
			The origin country zip for UPS shipments
		*/
		private $_originzip = "";

		/*
			The destination country ISO code for UPS shipments
		*/
		private $_destcountry = "";

		/*
			The destination country zip for UPS shipments
		*/
		private $_destzip = "";

		/*
			Which USPS API do we use? Domestic or international?
		*/
		private $_api = "RateV3";

		/*
			Width of priority large packages
		*/
		private $_prioritywidth = 0;

		/*
			Length of priority large packages
		*/
		private $_prioritylength = 0;

		/*
			Height of priority large packages
		*/
		private $_priorityheight = 0;

		/*
			Girth of priority large packages
		*/
		private $_prioritygirth = 0;

		/*
			Various shipping settings that are USPS specific
		*/
		private $_expressmailcontainertype = "";
		private $_expressmailpackagesize = "";
		private $_firstclasscontainertype = "";
		private $_firstclasspackagesize = "";
		private $_prioritycontainertype = "";
		private $_prioritypackagesize = "";
		private $_parcelpostmachpackagesize = "";
		private $_bpmpackagesize = "";
		private $_librarypackagesize = "";
		private $_mediapackagesize = "";

		/**
		* remaps country name differences for usps
		*/
		private $_mapcountries = array(
			"United Kingdom" => "United Kingdom (Great Britain)"
		);

		/**
		* These are the service ID's for each international service.
		* The response from USPS for an international quote contains one of these ID's.
		* Using these ID's to enable or disable a specific service.
		*
		* @var array service types
		*/
		private $internationalTypes = array(
			'ExpressMailIntl'		=> array('1', '10'),
			'PriorityMailIntl'		=> array('2', '8', '9', '11'),
			'GlobalExpress' 		=> array('4', '5', '6', '7', '12'),
			'FirstClassMailIntl' 	=> array('13', '14', '15')
		);

		/**
		* Functions for the USPS shipping module
		*/

		/*
			Shipping class constructor
		*/
		public function __construct()
		{
			// Setup the required variables for the USPS shipping module
			parent::__construct();
			$this->_name = GetLang('USPSName');
			$this->_image = "usps_logo.gif";
			$this->_description = GetLang('USPSDesc');
			$this->_help = GetLang('USPSHelp');
			$this->_height = 390;

			// USPS is only available in USA
			$this->_countries = array("United States");
		}

		/*
		 * Check if this shipping module can be enabled or not.
		 *
		 * @return boolean True if this module is supported on this install, false if not.
		 */
		public function IsSupported()
		{
			if(!function_exists("curl_exec")) {
				$this->SetError(GetLang('USPSNoCurl'));
			}

			if(!$this->HasErrors()) {
				return false;
			}
			else {
				return true;
			}
		}

		/**
		* Custom variables for the shipping module. Custom variables are stored in the following format:
		* array(variable_id, variable_name, variable_type, help_text, default_value, required, [variable_options], [multi_select], [multi_select_height])
		* variable_type types are: text,number,password,radio,dropdown
		* variable_options is used when the variable type is radio or dropdown and is a name/value array.
		*/
		public function SetCustomVars()
		{
			$this->_variables['username'] = array(
				"name" => GetLang('USPSUsername'),
				"type" => "textbox",
				"help" => GetLang('USPSUsernameHelp'),
				"default" => "",
				"required" => true
			);

			$this->_variables['servertype'] = array(
				"name" => GetLang('USPSServer'),
				"type" => "dropdown",
				"help" => GetLang('USPSServerTypeHelp'),
				"default" => "",
				"required" => true,
				"options" => array(
								GetLang('USPSServerType1') => "test",
								GetLang('USPSServerType2') => "production"
							),
				"multiselect" => false
			);

			$this->_variables['domesticsettings'] = array(
				"name" => "<strong>" . GetLang('USPSDomesticSettings') . "</strong>",
				"type" => "blank",
				"help" => ""
			);

			$this->_variables['expressmailsettings'] = array(
				"name" => "&nbsp;&nbsp;&nbsp;<strong>" . GetLang('USPSExpressMailSettings') . "</strong>",
				"type" => "blank",
				"help" => ""
			);

			$this->_variables['expressmailstatus'] = array(
				"name" => "&nbsp;&nbsp;&nbsp;" . GetLang('Status'),
				"type" => "dropdown",
				"help" => "",
				"default" => "disabled",
				"required" => false,
				"options" => array(
								GetLang('Enabled') => "enabled",
								GetLang('Disabled') => "disabled"
							),
				"multiselect" => false
			);

			$this->_variables['expressmailpackagesize'] = array(
				"name" => "&nbsp;&nbsp;&nbsp;" . GetLang('USPSPackageSize'),
				"type" => "dropdown",
				"help" => "",
				"default" => "",
				"required" => false,
				"options" => array(
								GetLang('USPSRegular') => "R",
								GetLang('USPSLarge') => "L"
							),
				"multiselect" => false
			);

			$this->_variables['expressmailcontainertype'] = array(
				"name" => "&nbsp;&nbsp;&nbsp;" . GetLang('USPSContainerType'),
				"type" => "dropdown",
				"help" => "",
				"default" => "",
				"required" => false,
				"options" => array(
					GetLang('USPSCustomContainer') => '',
					GetLang('USPSFlatRateEnvelope') => "F"
				),
				"multiselect" => false
			);

			$this->_variables['expressmailweightlimit'] = array(
				"name" => "&nbsp;&nbsp;&nbsp;" . GetLang('USPSWeightLimit'),
				"type" => "label",
				"help" => "",
				"label" => "70 lbs"
			);

			$this->_variables['firstclasssettings'] = array(
				"name" => "&nbsp;&nbsp;&nbsp;<strong>" . GetLang('USPSFirstClassSettings') . "</strong>",
				"type" => "blank",
				"help" => ""
			);

			$this->_variables['firstclassstatus'] = array(
				"name" => "&nbsp;&nbsp;&nbsp;" . GetLang('Status'),
				"type" => "dropdown",
				"help" => "",
				"default" => "disabled",
				"required" => false,
				"options" => array(
								GetLang('Enabled') => "enabled",
								GetLang('Disabled') => "disabled"
							),
				"multiselect" => false
			);

			$this->_variables['firstclasspackagesize'] = array(
				"name" => "&nbsp;&nbsp;&nbsp;" . GetLang('USPSPackageSize'),
				"type" => "dropdown",
				"help" => "",
				"default" => "",
				"required" => false,
				"options" => array(
								GetLang('USPSRegular') => "R",
								GetLang('USPSLarge') => "L"
							),
				"multiselect" => false
			);

			$this->_variables['firstclassweightlimit'] = array(
				"name" => "&nbsp;&nbsp;&nbsp;" . GetLang('USPSWeightLimit'),
				"type" => "label",
				"help" => "",
				"label" => "0.75 lbs"
			);

			$this->_variables['prioritymailsettings'] = array(
				"name" => "&nbsp;&nbsp;&nbsp;<strong>" . GetLang('USPSPriorityMailSettings') . "</strong>",
				"type" => "blank",
				"help" => ""
			);

			$this->_variables['prioritymailstatus'] = array(
				"name" => "&nbsp;&nbsp;&nbsp;" . GetLang('Status'),
				"type" => "dropdown",
				"help" => "",
				"default" => "disabled",
				"required" => false,
				"options" => array(
								GetLang('Enabled') => "enabled",
								GetLang('Disabled') => "disabled"
							),
				"multiselect" => false
			);

			$this->_variables['prioritymailpackagesize'] = array(
				"name" => "&nbsp;&nbsp;&nbsp;" . GetLang('USPSPackageSize'),
				"type" => "dropdown",
				"help" => "",
				"default" => "",
				"required" => false,
				"options" => array(
								GetLang('USPSRegular') => "R",
								GetLang('USPSLarge') => "L"
							),
				"multiselect" => false
			);

			$this->_variables['prioritymailcontainertype'] = array(
				"name" => "&nbsp;&nbsp;&nbsp;" . GetLang('USPSContainerType'),
				"type" => "dropdown",
				"help" => "",
				"default" => "",
				"required" => false,
				"options" => array(
					GetLang('USPSCustomContainer') => '',
					GetLang('USPSFlatRateEnvelope') => "F",
					GetLang('USPSFlatRateBox') => "B"
				),
				"multiselect" => false
			);

			$this->_variables['prioritymailweightlimit'] = array(
				"name" => "&nbsp;&nbsp;&nbsp;" . GetLang('USPSWeightLimit'),
				"type" => "label",
				"help" => "",
				"label" => "70 lbs"
			);

			$this->_variables['parcelpostmachinablesettings'] = array(
				"name" => "&nbsp;&nbsp;&nbsp;<strong>" . GetLang('USPSParcelPostSettings') . "</strong>",
				"type" => "blank",
				"help" => ""
			);

			$this->_variables['parcelpostmachinablestatus'] = array(
				"name" => "&nbsp;&nbsp;&nbsp;" . GetLang('Status'),
				"type" => "dropdown",
				"help" => "",
				"default" => "disabled",
				"required" => false,
				"options" => array(
								GetLang('Enabled') => "enabled",
								GetLang('Disabled') => "disabled"
							),
				"multiselect" => false
			);

			$this->_variables['parcelpostmachinablepackagesize'] = array(
				"name" => "&nbsp;&nbsp;&nbsp;" . GetLang('USPSPackageSize'),
				"type" => "dropdown",
				"help" => "",
				"default" => "",
				"required" => false,
				"options" => array(
								GetLang('USPSRegular') => "R",
								GetLang('USPSLarge') => "L",
								GetLang('USPSOversize') => "O"
							),
				"multiselect" => false
			);

			$this->_variables['parcelpostmachinableweightlimit'] = array(
				"name" => "&nbsp;&nbsp;&nbsp;" . GetLang('USPSWeightLimit'),
				"type" => "label",
				"help" => "",
				"label" => "70 lbs"
			);

			$this->_variables['bpmsettings'] = array(
				"name" => "&nbsp;&nbsp;&nbsp;<strong>" . GetLang('USPSBPMSettings') . "</strong>",
				"type" => "blank",
				"help" => ""
			);

			$this->_variables['bpmstatus'] = array(
				"name" => "&nbsp;&nbsp;&nbsp;" . GetLang('Status'),
				"type" => "dropdown",
				"help" => "",
				"default" => "disabled",
				"required" => false,
				"options" => array(
								GetLang('Enabled') => "enabled",
								GetLang('Disabled') => "disabled"
							),
				"multiselect" => false
			);

			$this->_variables['bpmpackagesize'] = array(
				"name" => "&nbsp;&nbsp;&nbsp;" . GetLang('USPSPackageSize'),
				"type" => "dropdown",
				"help" => "",
				"default" => "",
				"required" => false,
				"options" => array(
								GetLang('USPSRegular') => "R",
								GetLang('USPSLarge') => "L"
							),
				"multiselect" => false
			);


			$this->_variables['bpmweightlimit'] = array(
				"name" => "&nbsp;&nbsp;&nbsp;" . GetLang('USPSWeightLimit'),
				"type" => "label",
				"help" => "",
				"label" => "15 lbs"
			);

			$this->_variables['librarysettings'] = array(
				"name" => "&nbsp;&nbsp;&nbsp;<strong>" . GetLang('USPSLibrarySettings') . "</strong>",
				"type" => "blank",
				"help" => ""
			);

			$this->_variables['librarystatus'] = array(
				"name" => "&nbsp;&nbsp;&nbsp;" . GetLang('Status'),
				"type" => "dropdown",
				"help" => "",
				"default" => "disabled",
				"required" => false,
				"options" => array(
								GetLang('Enabled') => "enabled",
								GetLang('Disabled') => "disabled"
							),
				"multiselect" => false
			);

			$this->_variables['librarypackagesize'] = array(
				"name" =>"&nbsp;&nbsp;&nbsp;" .  GetLang('USPSPackageSize'),
				"type" => "dropdown",
				"help" => "",
				"default" => "",
				"required" => false,
				"options" => array(
					GetLang('USPSRegular') => "R",
					GetLang('USPSLarge') => "L"
				),
				"multiselect" => false
			);


			$this->_variables['libraryweightlimit'] = array(
				"name" => "&nbsp;&nbsp;&nbsp;" . GetLang('USPSWeightLimit'),
				"type" => "label",
				"help" => "",
				"label" => "70 lbs"
			);

			$this->_variables['mediasettings'] = array(
				"name" => "&nbsp;&nbsp;&nbsp;<strong>" . GetLang('USPSMediaSettings') . "</strong>",
				"type" => "blank",
				"help" => ""
			);

			$this->_variables['mediastatus'] = array(
				"name" => "&nbsp;&nbsp;&nbsp;" . GetLang('Status'),
				"type" => "dropdown",
				"help" => "",
				"default" => "disabled",
				"required" => false,
				"options" => array(
						GetLang('Enabled') => "enabled",
						GetLang('Disabled') => "disabled"
					),
				"multiselect" => false
			);

			$this->_variables['mediapackagesize'] = array(
				"name" => "&nbsp;&nbsp;&nbsp;" . GetLang('USPSPackageSize'),
				"type" => "dropdown",
				"help" => "",
				"default" => "",
				"required" => false,
				"options" => array(
								GetLang('USPSRegular') => "R",
								GetLang('USPSLarge') => "L"
							),
				"multiselect" => false
			);


			$this->_variables['mediaweightlimit'] = array(
				"name" => "&nbsp;&nbsp;&nbsp;" . GetLang('USPSWeightLimit'),
				"type" => "label",
				"help" => "",
				"label" => "70 lbs"
			);

			// international methods
			$this->_variables['internationalsettings'] = array(
				"name" => "<strong>" . GetLang("USPSInternationalSettings") . "</strong>",
				"type" => "blank",
				"help" => ""
			);

			foreach ($this->internationalTypes as $typeName => $type) {
				$options = array();
				foreach ($type as $service) {
					$options[GetLang('USPSIntlService_' . $service)] = $service;
				}

				$this->_variables[$typeName] = array(
					'name' => GetLang('USPS' . $typeName),
					'type' => 'dropdown',
					'required' => false,
					'help' => '',
					'options' => $options,
					'multiselect' => true,
					'multiselectheight' => count($type) * 3
				);
			}
		}

		/**
		* Test the shipping method by displaying a simple HTML form
		*/
		public function TestQuoteForm()
		{
			// Which countries has the user chosen to ship orders to?
			$GLOBALS['Countries'] = GetCountryList("United States");

			$GLOBALS['Image'] = $this->_image;

			$GLOBALS['WeightUnit'] = GetConfig('WeightMeasurement');
			$GLOBALS['LengthUnit'] = GetConfig('LengthMeasurement');

			$this->ParseTemplate("module.usps.test");
		}

		/**
		* Get the shipping quote and display it in a form
		*/
		public function TestQuoteResult()
		{
			$api = "";
			$pounds = 0;
			$ounces = 0;

			// Add a single test item - no dimensions needed for UPS
			$this->additem($_POST['delivery_weight']);

			// Setup all of the shipping variables
			$this->_username = $this->GetValue("username");
			$this->_origincountry = GetConfig('CompanyCountry');
			$this->_originzip = GetConfig('CompanyZip');
			if ($_POST['destination_type'] == "domestic") {
				$this->_service = $_POST['delivery_type'];
				$this->_destcountry = GetConfig('CompanyCountry');
			}
			else {
				$this->_service = $_POST['intl_delivery_type'];
				$this->_destcountry = GetCountryById($_POST['delivery_country']);
			}
			$this->_destzip = $_POST['delivery_zip'];

			$this->_expressmailcontainertype = $_POST['shipping_usps_expressmailcontainertype'];
			$this->_expressmailpackagesize = $_POST['shipping_usps_expressmailpackagesize'];
			$this->_firstclasscontainertype = $_POST['shipping_usps_firstclasscontainertype'];
			$this->_firstclasspackagesize = $_POST['shipping_usps_firstclasspackagesize'];
			$this->_prioritycontainertype = $_POST['shipping_usps_prioritycontainertype'];
			$this->_prioritypackagesize = $_POST['shipping_usps_prioritypackagesize'];
			$this->_parcelpostmachpackagesize = $_POST['shipping_usps_parcelpostmachpackagesize'];
			$this->_bpmpackagesize = $_POST['shipping_usps_bpmpackagesize'];
			$this->_librarypackagesize = $_POST['shipping_usps_librarypackagesize'];
			$this->_mediapackagesize = $_POST['shipping_usps_mediapackagesize'];

			// Is this a priority large package?
			if(is_numeric($_POST['shipping_usps_prioritywidth']) && is_numeric($_POST['shipping_usps_prioritylength']) && is_numeric($_POST['shipping_usps_priorityheight'])) {
				$this->_prioritywidth = $_POST['shipping_usps_prioritywidth'];
				$this->_prioritylength = $_POST['shipping_usps_prioritylength'];
				$this->_priorityheight = $_POST['shipping_usps_priorityheight'];
				$this->_prioritygirth = $_POST['shipping_usps_prioritygirth'];
			}

			// Next actually retrieve the quote
			$err = "";
			$result = $this->GetQuote();

			if(!is_object($result) && !is_array($result)) {
				$GLOBALS['Color'] = "red";
				$GLOBALS['Status'] = GetLang('StatusFailed');
				$GLOBALS['Label'] = GetLang('ShipErrorMessage');
				$GLOBALS['Message'] = implode('<br />', $this->GetErrors());
			}
			else {
				$GLOBALS['Color'] = "green";
				$GLOBALS['Status'] = GetLang('StatusSuccess');
				$GLOBALS['Label'] = GetLang('ShipQuotePrice');

				// Get each available shipping option and display it
				$GLOBALS['Message'] = "";

				if(!is_array($result)) {
					$result = array($result);
				}

				foreach($result as $quote) {
					if(count($result) > 1) {
						$GLOBALS['Message'] .= "<li>";
					}

					$GLOBALS['Message'] .= $quote->getdesc(false) . " - $" . number_format($quote->getprice(), GetConfig('DecimalPlaces')) . " USD";

					if(count($result) > 1) {
						$GLOBALS['Message'] .= "</li>";
					}
				}
			}

			$GLOBALS['Image'] = $this->_image;
			$this->ParseTemplate("module.usps.testresult");
		}

		private function GetQuote()
		{
			// The following array will be returned to the calling function.
			// It will contain at least one ISC_SHIPPING_QUOTE object if
			// the shipping quote was successful.

			$usps_quote = array();

			$origincountry = $this->GetCountry($this->_origincountry);
			$destcountry = $this->GetCountry($this->_destcountry);

			// Is this an international quote?
			if($origincountry != $destcountry) {
				$this->_api = "IntlRate";
			} else {
				$this->_api = "RateV3";
			}

			// Build the start of the USPS XML query - password can be anything but empty
			$usps_xml = sprintf("<%sRequest USERID=\"%s\">", $this->_api, $this->_username);
			$usps_xml .= "<Package ID=\"0\">";

			// Which server are we shipping with?
			if($this->_service == "PARCEL") {
				$usps_xml .= "<Service>PARCEL</Service>";
			}
			else {
				$usps_xml .= sprintf("<Service>%s</Service>", $this->_service);
			}

			if($this->_service == "FIRST CLASS" || $this->_service == "PARCEL") {
				$usps_xml .= "<FirstClassMailType>PARCEL</FirstClassMailType>";
			}

			// get the amount of pounds
			$fractional_pounds = ConvertWeight($this->_weight, 'pounds');
			$pounds = floor($fractional_pounds);
			// get the amount of ounces for the fractional remainder
			$ounces = round(ConvertWeight($fractional_pounds - $pounds, 'ounces', 'pounds'), 3);

			$weight_xml = sprintf("<Pounds>%s</Pounds>", $pounds);
			$weight_xml .= sprintf("<Ounces>%s</Ounces>", $ounces);

			// Must output weight before mailtype for international
			if($this->_api == "IntlRate") {
				$usps_xml .= $weight_xml;
			}

			if($this->_api == "IntlRate") {
				$usps_xml .= "<MailType>Package</MailType>";
				$usps_xml .= sprintf("<Country>%s</Country>", $destcountry);
			}
			else {
				$usps_xml .= sprintf("<ZipOrigination>%s</ZipOrigination>", $this->_originzip);
				$usps_xml .= sprintf("<ZipDestination>%s</ZipDestination>", $this->_destzip);
			}

			// Must output weight after mailtype for domestic
			if($this->_api != "IntlRate") {
				$usps_xml .= $weight_xml;
			}

			// Which container to use depends on which method was chosen
			switch($this->_service) {
				case "EXPRESS": {
					$this->_container = $this->_expressmailcontainertype;
					$this->_size = $this->_expressmailpackagesize;
					break;
				}
				case "FIRST CLASS": {
					$this->_container = $this->_firstclasscontainertype;
					$this->_size = $this->_firstclasspackagesize;
					break;
				}
				case "PRIORITY": {
					$this->_container = $this->_prioritycontainertype;
					$this->_size = $this->_prioritypackagesize;
					break;
				}
				case "PARCEL": {
					$this->_size = $this->_parcelpostmachpackagesize;
					break;
				}
				case "BPM": {
					$this->_size = $this->_bpmpackagesize;
					break;
				}
				case "LIBRARY": {
					$this->_size = $this->_librarypackagesize;
					break;
				}
				case "MEDIA": {
					$this->_size = $this->_mediapackagesize;
					break;
				}
			}

			$this->_container = $this->GetContainerType($this->_container);

			$this->_size = $this->GetContainerSize($this->_size);

			$usps_xml .= sprintf("<Container>%s</Container>", $this->_container);
			$usps_xml .= sprintf("<Size>%s</Size>", $this->_size);

			if($this->_service == "PRIORITY" && $this->_size == "LARGE") {
				$usps_xml .= sprintf("<Width>%s</Width>", number_format(ConvertLength($this->_prioritywidth, "in"),2));
				$usps_xml .= sprintf("<Length>%s</Length>", number_format(ConvertLength($this->_prioritylength, "in"),2));
				$usps_xml .= sprintf("<Height>%s</Height>", number_format(ConvertLength($this->_priorityheight, "in"),2));

				if($this->_prioritygirth > 0) {
					$usps_xml .= sprintf("<Girth>%s</Girth>", ConvertLength($this->_prioritygirth, "in"));
				}
			}

			// Add the Machinable element if it's a parcel post
			if($this->_service == "PARCEL") {
				$usps_xml .= "<Machinable>true</Machinable>";
			}

			$usps_xml .= "</Package>";
			$usps_xml .= sprintf("</%sRequest>", $this->_api);

			// If it's an international quote then we'll strip out
			// the service, container and size elements
			if($this->_api == "IntlRate") {
				$usps_xml = preg_replace("#<Service>(.*)</Service>#si", "", $usps_xml);
				$usps_xml = preg_replace("#<Container>(.*)</Container>#si", "", $usps_xml);
				$usps_xml = preg_replace("#<Size>(.*)</Size>#si", "", $usps_xml);
				$usps_xml = preg_replace("#<Width>(.*)</Width>#si", "", $usps_xml);
				$usps_xml = preg_replace("#<Length>(.*)</Length>#si", "", $usps_xml);
				$usps_xml = preg_replace("#<Height>(.*)</Height>#si", "", $usps_xml);
				$usps_xml = preg_replace("#<Girth>(.*)</Girth>#si", "", $usps_xml);
				$usps_xml = preg_replace("#<FirstClassMailType>(.*)</FirstClassMailType>#si", "", $usps_xml);
				$usps_xml = preg_replace("#<Machinable>(.*)</Machinable>#si", "", $usps_xml);
			}

			// Connect to USPS to retrieve a live shipping quote
			$result = "";
			$valid_quote = false;

			// Should we test on the test or production server?
			$usps_mode = $this->GetValue("servertype");

			if($usps_mode == "test") {
				$usps_url = "http://testing.shippingapis.com/ShippingAPITest.dll?";
			} else {
				$usps_url = "http://production.shippingapis.com/ShippingAPI.dll?";
			}

			$post_vars = implode("&", array (
											"API=$this->_api",
											"XML=$usps_xml"
										)
			);

			if(function_exists("curl_exec")) {
				// Use CURL if it's available
				$ch = @curl_init($usps_url);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $post_vars);
				curl_setopt($ch, CURLOPT_TIMEOUT, 60);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

				// Setup the proxy settings if there are any
				if (GetConfig('HTTPProxyServer')) {
					curl_setopt($ch, CURLOPT_PROXY, GetConfig('HTTPProxyServer'));
					if (GetConfig('HTTPProxyPort')) {
						curl_setopt($ch, CURLOPT_PROXYPORT, GetConfig('HTTPProxyPort'));
					}
				}

				if (GetConfig('HTTPSSLVerifyPeer') == 0) {
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				}

				$result = curl_exec($ch);

				if($result != "") {
					$valid_quote = true;
				}
			}

			$this->DebugLog($result);

			if($valid_quote) {
				// Was the user authenticated?
				if(is_numeric(isc_strpos($result, "Authorization failure"))) {
					$this->SetError(GetLang('USPSAuthError'));
					return false;
				}
				else {
					$xml = xmlize($result);
					// Are we dealing with a domestic or international shipment?
					if(isset($xml['RateV3Response'])) {
						// Domestic
						if(is_numeric(isc_strpos($result, "Error"))) {
							// Bad quote
							$this->SetError($xml['RateV3Response']["#"]['Package'][0]["#"]['Error'][0]["#"]['Description'][0]["#"]);
							return false;
						}
						else {
							// Create a quote object
							$quote = new ISC_SHIPPING_QUOTE($this->GetId(), $this->GetDisplayName(), $xml['RateV3Response']["#"]['Package'][0]["#"]['Postage'][0]["#"]['Rate'][0]["#"], $xml['RateV3Response']["#"]['Package'][0]["#"]['Postage'][0]["#"]['MailService'][0]["#"]);
							return $quote;
						}
					}
					else if(isset($xml['IntlRateResponse'])) {
						// International
						if(is_numeric(isc_strpos($result, "Error"))) {
							// Bad quote
							$this->SetError($xml['IntlRateResponse']["#"]['Package'][0]["#"]['Error'][0]["#"]['Description'][0]["#"]);
							return false;
						}
						else {
							// Success
							$QuoteList = array();
							$USPSServices = $xml['IntlRateResponse']["#"]['Package'][0]["#"]['Service'];

							// get the list of enabled services
							$services = $this->GetIntlServices($this->_service);

							foreach ($USPSServices as $Service) {
								$serviceId = $Service['@']['ID'];
								// check if this service is enabled
								if (!in_array($serviceId, $services)) {
									continue;
								}

								// Create a quote object
								$quote = new ISC_SHIPPING_QUOTE($this->GetId(), $this->GetDisplayName(), $Service["#"]['Postage'][0]["#"], GetLang('USPSIntlService_' . $serviceId));
								//save quotes in an array
								$QuoteList[] = $quote;
							}

							return $QuoteList;
						}
					}
					else if(isset($xml['Error'])) {
						// Error
						$this->SetError($xml['Error']["#"]['Description'][0]["#"]);
						return false;
					}
				}
			}
			else {
				// Couldn't get to USPS
				$this->SetError(GetLang('USPSOpenError'));
				return false;
			}
		}

		public function GetServiceQuotes()
		{
			$QuoteList = array();

			// Set the USPS-specific variables
			$api = "";
			$pounds = 0;
			$ounces = 0;

			// Setup all of the shipping variables
			$this->_username = $this->GetValue("username");
			$this->_origincountry = GetConfig('CompanyCountry');
			$this->_originzip = GetConfig('CompanyZip');
			$this->_destcountry = $this->_destination_country['country_name'];
			$this->_destzip = $this->_destination_zip;

			if($this->_origincountry != $this->_destcountry) {

				// Next actually retrieve the quote
				$result = $this->GetQuote();
				if(is_array($result) && !empty($result)) {
					$QuoteList = $result;
				}
				else {
					foreach($this->GetErrors() as $error) {
						$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('shipping', $this->GetName()), $this->_service.": " .GetLang('ShippingQuoteError'), $error);
					}
				}
				return $QuoteList;
			}


			// Is express mail enabled?
			if($this->GetValue("expressmailstatus") == "enabled") {
				$this->_service = "EXPRESS";
				$this->_expressmailcontainertype = $this->GetValue("expressmailcontainertype");
				$this->_expressmailpackagesize = $this->GetValue("expressmailpackagesize");

				// Next actually retrieve the quote
				$result = $this->GetQuote();
				if(is_object($result)) {
					$QuoteList[] = $result;
				}
				else {
					foreach($this->GetErrors() as $error) {
						$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('shipping', $this->GetName()), $this->_service.": " .GetLang('ShippingQuoteError'), $error);
					}
				}
			}

			// Is first class enabled?
			if($this->GetValue("firstclassstatus") == "enabled") {
				$this->_service = "FIRST CLASS";
				$this->_firstclasscontainertype = "F";
				$this->_firstclasspackagesize = $this->GetValue("firstclasspackagesize");

				// Next actually retrieve the quote
				$result = $this->GetQuote();
				if(is_object($result)) {
					$QuoteList[] = $result;
				}
				else {
					foreach($this->GetErrors() as $error) {
						$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('shipping', $this->GetName()), $this->_service.": " .GetLang('ShippingQuoteError'), $error);
					}
				}
			}

			// Is priority mail enabled?
			if($this->GetValue("prioritymailstatus") == "enabled") {
				$this->_service = "PRIORITY";
				$this->_prioritycontainertype = $this->GetValue("prioritymailcontainertype");
				$this->_prioritypackagesize = $this->GetValue("prioritymailpackagesize");

				// If it's a large box we need to specify dimensions
				if($this->_prioritypackagesize == "L") {
					$this->_prioritycontainertype = "R";
					$dimensions = $this->getcombinedshipdimensions();
					$this->_prioritywidth = $dimensions['width'];
					$this->_prioritylength = $dimensions['length'];
					$this->_priorityheight = $dimensions['height'];
				}

				// Next actually retrieve the quote
				$result = $this->GetQuote();
				if(is_object($result)) {
					$QuoteList[] = $result;
				}
				else {
					foreach($this->GetErrors() as $error) {
						$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('shipping', $this->GetName()), $this->_service.": " .GetLang('ShippingQuoteError'), $error);
					}
				}
			}

			// Is parcel post (machinable) enabled?
			if($this->GetValue("parcelpostmachinablestatus") == "enabled") {
				$this->_service = "PARCEL";
				$this->_parcelpostmachpackagesize = $this->GetValue("parcelpostmachinablepackagesize");

				// Next actually retrieve the quote
				$result = $this->GetQuote();
				if(is_object($result)) {
					$QuoteList[] = $result;
				}
				else {
					foreach($this->GetErrors() as $error) {
						$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('shipping', $this->GetName()), $this->_service.": " .GetLang('ShippingQuoteError'), $error);
					}
				}
			}

			// Is BPM enabled?
			if($this->GetValue("bpmstatus") == "enabled") {
				$this->_service = "BPM";
				$this->_bpmpackagesize = $this->GetValue("bpmpackagesize");

				// Next actually retrieve the quote
				$result = $this->GetQuote();
				if(is_object($result)) {
					$QuoteList[] = $result;
				}
				else {
					foreach($this->GetErrors() as $error) {
						$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('shipping', $this->GetName()), $this->_service.": " .GetLang('ShippingQuoteError'), $error);
					}
				}
			}

			// Is library enabled?
			if($this->GetValue("librarystatus") == "enabled") {
				$this->_service = "LIBRARY";
				$this->_librarypackagesize = $this->GetValue("librarypackagesize");

				// Next actually retrieve the quote
				$result = $this->GetQuote();
				if(is_object($result)) {
					$QuoteList[] = $result;
				}
				else {
					foreach($this->GetErrors() as $error) {
						$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('shipping', $this->GetName()), $this->_service.": " .GetLang('ShippingQuoteError'), $error);
					}
				}
			}

			// Is media enabled?
			if($this->GetValue("mediastatus") == "enabled") {
				$this->_service = "MEDIA";
				$this->_mediapackagesize = $this->GetValue("mediapackagesize");

				// Next actually retrieve the quote
				$result = $this->GetQuote();
				if(is_object($result)) {
					$QuoteList[] = $result;
				}
				else {
					foreach($this->GetErrors() as $error) {
						$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('shipping', $this->GetName()), $this->_service.": " .GetLang('ShippingQuoteError'), $error);
					}
				}
			}
			return $QuoteList;
		}

		private function GetContainerType($container)
		{
			$result = '';

			switch($container) {
				case "F": {
					$result = "FLAT RATE ENVELOPE";
					break;
				}
				case "B": {
					$result = "FLAT RATE BOX";
					break;
				}
				case "R": {
					$result = "RECTANGULAR";
					break;
				}
				case "N": {
					$result = "NONRECTANGULAR";
					break;
				}
			}

			return $result;
		}

		private function GetContainerSize($size)
		{
			$result = '';

			switch($size) {
				case "R": {
					$result = "REGULAR";
					break;
				}
				case "L": {
					$result = "LARGE";
					break;
				}
				case "O": {
					$result = "OVERSIZE";
					break;
				}
			}

			return $result;
		}


		/**
		 * Get a human readable list of of the delivery methods available for the shipping module
		 *
		 * @return array
		 **/
		public function GetAvailableDeliveryMethods()
		{
			$methods = array();

			// Is express mail enabled ?
			if ($this->GetValue("expressmailstatus") == "enabled") {
				$method = "EXPRESS ".$this->GetContainerType($this->GetValue("expressmailcontainertype"));
				$methods[] = $method;
			}

			// Is first class enabled?
			if ($this->GetValue("firstclassstatus") == "enabled") {
				$method = "FIRST CLASS ".$this->GetContainerSize($this->GetValue("firstclasspackagesize"));
				$methods[] = $method;
			}

			// Is priority mail enabled?
			if ($this->GetValue("prioritymailstatus") == "enabled") {
				$method = "PRIORITY ".$this->GetContainerType($this->GetValue("prioritymailcontainertype"));
				$methods[] = $method;
			}

			// Is parcel post (machinable) enabled?
			if ($this->GetValue("parcelpostmachinablestatus") == "enabled") {
				$method = "PARCEL ".$this->GetContainerSize($this->GetValue("parcelpostmachinablepackagesize"));
				$methods[] = $method;
			}

			// Is BPM enabled?
			if ($this->GetValue("bpmstatus") == "enabled") {
				$method = "BPM ";
				$methods[] = $method;
			}

			// Is library enabled?
			if ($this->GetValue("librarystatus") == "enabled") {
				$method = "LIBRARY ".$this->GetContainerSize($this->GetValue("librarypackagesize"));
				$methods[] = $method;
			}

			// Is media enabled?
			if ($this->GetValue("mediastatus") == "enabled") {
				$method = "MEDIA ".$this->GetContainerSize($this->GetValue("mediapackagesize"));
				$methods[] = $method;
			}

			// Get the international services
			$intlServices = $this->GetIntlServices();
			foreach ($intlServices as $service) {
				$methods[] = GetLang('USPSIntlService_' . $service);
			}

			$displayName = $this->GetDisplayName();

			foreach ($methods as $key => $method) {
				$methods[$key] = $displayName.' ('.$method.')';
			}

			return $methods;
		}

		public function GetTrackingLink($trackingNumber = "")
		{
			return "http://trkcnfrm1.smi.usps.com/PTSInternetWeb/InterLabelInquiry.do?strOrigTrackNum=" . urlencode($trackingNumber);
		}

		/**
		* Gets the correct country name for use by USPS. Returns a remapped country if it exists, otherwise returns passed in country
		*
		* @param string country name
		* @return string country name
		*/
		private function GetCountry($country)
		{
			if (isset($this->_mapcountries[$country])) {
				return $this->_mapcountries[$country];
			}

			return $country;
		}

		/**
		* Gets an array of enabled international services
		*
		* @return array enabled services
		*/
		private function GetIntlServices($service = "")
		{
			$services = array();
			foreach ($this->internationalTypes as $typeName => $type) {
				if ($service != "" && $typeName != $service) {
					continue;
				}

				$deliveryTypes = $this->GetValue($typeName);
				if($deliveryTypes != '') {
					if (is_array($deliveryTypes)) {
						$services = array_merge($deliveryTypes, $services);
					} else {
						$services[] = $deliveryTypes;
					}
				}
			}

			return $services;
		}

	}

?>
