<?php
if (!defined('ISC_BASE_PATH')) {
	die();
}

require_once(ISC_BASE_PATH.'/lib/class.xml.php');

class ISC_REMOTE extends ISC_XML_PARSER
{
	public function __construct()
	{
		parent::__construct();
	}

	public function HandleToDo()
	{
		/**
		 * Convert the input character set from the hard coded UTF-8 to their
		 * selected character set
		 */
		convertRequestInput();

		$what = isc_strtolower(@$_REQUEST['w']);

		switch  ($what) {
			case "countrystates": {
				$this->GetCountryStates();
				break;
			}
			case "getstates": {
				$this->GetStateList();
				break;
			}
			case "getcountries": {
				$this->GetCountryList();
				break;
			}
			case "getexchangerate": {
				$this->GetExchangeRate();
				break;
			}
			case "expresscheckoutregister":
				$this->ExpressCheckoutRegister();
				break;
			case "expresscheckoutlogin":
				$this->ExpressCheckoutLogin();
				break;
			case "expresscheckoutgetaddressfields":
				$this->GetExpressCheckoutAddressFields();
				break;
			case "expresscheckoutgetshippers":
				if ($_SESSION['makeaoffer'] == "Yes")
				$this->GetExpressOfferShippers();
				else
				$this->GetExpressCheckoutShippers();
				break;
			case "expresscheckoutgetaddonproducts":
				$this->GetExpressCheckoutAddonProducts();
				break;
			case "expresscheckoutshowconfirmation":

				if ($_SESSION['makeaoffer'] == "Yes")
				$this->GetExpressOfferConfirmation();
				else
				$this->GetExpressCheckoutConfirmation();
					
				break;
			case "expresscheckoutloadpaymentform":
				if ($_SESSION['makeaoffer'] == "Yes")
				$this->GetExpressOfferPaymentForm();
				else
				$this->GetExpressCheckoutPaymentForm();
					
				break;
			case "getshippingquotes":
				$this->GetShippingQuotes();
				break;
			case 'selectgiftwrapping':
				$this->SelectGiftWrapping();
				break;
			case 'editconfigurablefieldsincart':
				$this->EditConfigurableFieldsInCart();
				break;
			case 'deleteuploadedfileincart':
				$this->DeleteUploadedFileInCart();
				break;
			case 'addproducts':
				$this->AddProductsToCart();
				break;
			case 'linker':
				$linker = GetClass("ISC_LINKER");
				$linker->HandleToDo();
				break;
			case 'checkcustomeremail': // johnny add
				$this->checkCustomerEmail();
				break;
			case 'checkproduct': // alandy_2011-12-26 add
				$this->checkproduct();
				break;
            case 'getproductpqvq':
                echo self::getProductPQVQ(); // dada 2012-03-14
                break;
		}
	}

	public function DeleteUploadedFileInCart()
	{
		if(!isset($_REQUEST['item']) || !isset($_REQUEST['field'])) {
			return false;
		}

		$itemId = $_REQUEST['item'];
		$fieldId = $_REQUEST['field'];

		if(isset($_SESSION['CART']['ITEMS'][$itemId]['product_fields'][$fieldId]['fileName'])) {
			$field = $_SESSION['CART']['ITEMS'][$itemId]['product_fields'];

			@unlink(ISC_BASE_PATH.'/'.GetConfig('ImageDirectory').'/configured_products/'.$field[$fieldId]['fileName']);

			foreach($field[$fieldId] as $key => $value) {
				unset($_SESSION['CART']['ITEMS'][$itemId]['product_fields'][$fieldId][$key]);
			}
			unset($_SESSION['CART']['ITEMS'][$itemId]['product_fields'][$fieldId]);
		}
	}

	public function EditConfigurableFieldsInCart()
	{
		if(!isset($_REQUEST['itemid'])) {
			return false;
		}

		$itemId = (int)$_REQUEST['itemid'];
		$output = '';
		$cartItem = $_SESSION['CART']['ITEMS'][$itemId];
		$cartItemFields = $_SESSION['CART']['ITEMS'][$itemId]['product_fields'];

		$GLOBALS['ItemId'] = $itemId;
		$GLOBALS['ISC_CLASS_PRODUCT'] = GetClass('ISC_PRODUCT');

		$GLOBALS['CartProductName'] = isc_html_escape($cartItem['product_name']);
		$fields = $GLOBALS['ISC_CLASS_PRODUCT']->GetProductFields($cartItem['product_id']);

		foreach($fields as $field) {

			$GLOBALS['ProductFieldType'] = isc_html_escape($field['type']);
			$GLOBALS['ProductFieldId'] = (int)$field['id'];
			$GLOBALS['ProductFieldName'] = isc_html_escape($field['name']);
			$GLOBALS['ProductFieldRequired'] = '';
			$GLOBALS['FieldRequiredClass'] = '';
			$GLOBALS['ProductFieldValue'] = '';
			$GLOBALS['ProductFieldFileValue'] = '';
			$GLOBALS['HideCartFileName'] = 'display: none';
			$GLOBALS['CheckboxFieldNameLeft'] = '';
			$GLOBALS['CheckboxFieldNameRight'] = '';
			$GLOBALS['HideDeleteFileLink'] = 'display: none';
			$GLOBALS['HideFileHelp'] = "display:none";

			$cartItemField = array(
					"fieldType" => '',
					"fieldName" => '',
					"fileType" => '',
					"fileOriginName" => '',
					"fileName" => '',
					"fieldValue" => '',
			);
			if(isset($cartItemFields[$field['id']])) {
				$cartItemField = $cartItemFields[$field['id']];
			}

			$snippetFile = 'ProductFieldInput';

			switch ($field['type']) {
				case 'textarea': {
					$GLOBALS['ProductFieldValue'] = isc_html_escape($cartItemField['fieldValue']);
					$snippetFile = 'ProductFieldTextarea';
					break;
				}
				case 'file': {
					$fieldValue = isc_html_escape($cartItemField['fileOriginName']);
					$GLOBALS['HideDeleteCartFieldFile'] = '';
					$GLOBALS['CurrentProductFile'] = $fieldValue;
					$GLOBALS['ProductFieldFileValue'] = $fieldValue;
					$GLOBALS['HideFileHelp'] = "";
					$GLOBALS['FileSize'] = NiceSize($field['fileSize']*1024);

					if($fieldValue != '') {
						$GLOBALS['HideCartFileName'] = '';
					}

					if(!$field['required']) {
						$GLOBALS['HideDeleteFileLink'] = '';
					}
					$GLOBALS['FileTypes'] = isc_html_escape($field['fileType']);
					break;
				}
				case 'checkbox': {
					$GLOBALS['CheckboxFieldNameLeft'] = $GLOBALS['ProductFieldName'];
					if($cartItemField['fieldValue'] == 'on') {
						$GLOBALS['ProductFieldValue'] = 'checked';
					}
					$snippetFile = 'ProductFieldCheckbox';
					break;
				}
				default: {
					$GLOBALS['ProductFieldValue'] = isc_html_escape($cartItemField['fieldValue']);
					break;
				}
			}

			if($field['required']) {
				$GLOBALS['ProductFieldRequired'] = '<span class="Required">*</span>';
				$GLOBALS['FieldRequiredClass'] = 'FieldRequired';
			}
			$output .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet($snippetFile);
		}
		$GLOBALS['SNIPPETS']['ProductFieldsList'] = $output;

		$editProductFields = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('CartEditProductFieldsForm');
		echo $GLOBALS['ISC_CLASS_TEMPLATE']->ParseSnippets($editProductFields, $GLOBALS['SNIPPETS']);
	}

	public function SelectGiftWrapping()
	{
		$GLOBALS['ISC_CLASS_CART'] = GetClass('ISC_CART');
		$cartProducts = $GLOBALS['ISC_CLASS_CART']->api->GetProductsInCart();

		if(!isset($_REQUEST['itemId']) || !isset($cartProducts[$_REQUEST['itemId']])) {
			exit;
		}

		$cartProduct = $cartProducts[$_REQUEST['itemId']];

		$GLOBALS['GiftWrappingTitle'] = sprintf(GetLang('GiftWrappingForX'), isc_html_escape($cartProduct['product_name']));
		$GLOBALS['ProductName'] = $cartProduct['product_name'];
		$GLOBALS['ItemId'] = $_REQUEST['itemId'];

		// Get the available gift wrapping options for this product
		if($cartProduct['data']['prodwrapoptions'] == -1) {
			exit;
		}
		else if($cartProduct['data']['prodwrapoptions'] == 0) {
			$giftWrapWhere = "wrapvisible='1'";
		}
		else {
			$wrapOptions = implode(',', array_map('intval', explode(',', $cartProduct['data']['prodwrapoptions'])));
			$giftWrapWhere = "wrapid IN (".$wrapOptions.")";
		}
		$query = "
				SELECT *
				FROM [|PREFIX|]gift_wrapping
				WHERE ".$giftWrapWhere."
				ORDER BY wrapname ASC
			";
		$wrappingOptions = array();
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		while($wrap = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$wrappingOptions[$wrap['wrapid']] = $wrap;
		}

		// This product is already wrapped, select the existing value
		$selectedWrapping = 0;
		$GLOBALS['GiftWrapMessage'] = '';
		if(isset($cartProduct['wrapping'])) {
			$selectedWrapping = $cartProduct['wrapping']['wrapid'];
		}

		if(isset($cartProduct['wrapping']['wrapmessage'])) {
			$GLOBALS['GiftWrapMessage'] = isc_html_escape($cartProduct['wrapping']['wrapmessage']);
		}

		$GLOBALS['HideGiftWrapMessage'] = 'display: none';

		// Build the list of wrapping options
		$GLOBALS['WrappingOptions'] = '';
		$GLOBALS['GiftWrapPreviewLinks'] = '';
		foreach($wrappingOptions as $option) {
			$sel = '';
			if($selectedWrapping == $option['wrapid']) {
				$sel = 'selected="selected"';
				if($option['wrapallowcomments']) {
					$GLOBALS['HideGiftWrapMessage'] = '';
				}
			}
			$classAdd = '';
			if($option['wrapallowcomments']) {
				$classAdd = 'AllowComments';
			}

			if($option['wrappreview']) {
				$classAdd .= ' HasPreview';
				$previewLink = GetConfig('ShopPath').'/'.GetConfig('ImageDirectory').'/'.$option['wrappreview'];
				if($sel) {
					$display = '';
				}
				else {
					$display = 'display: none';
				}
				$GLOBALS['GiftWrapPreviewLinks'] .= '<a id="GiftWrappingPreviewLink'.$option['wrapid'].'" class="GiftWrappingPreviewLinks" target="_blank" href="'.$previewLink.'" style="'.$display.'">'.GetLang('Preview').'</a>';
			}

			$GLOBALS['WrappingOptions'] .= '<option class="'.$classAdd.'" value="'.$option['wrapid'].'" '.$sel.'>'.isc_html_escape($option['wrapname']).' ('.CurrencyConvertFormatPrice($option['wrapprice']).')</option>';
		}

		if($cartProduct['quantity'] > 1) {
			$GLOBALS['ExtraClass'] = 'PL40';
			$GLOBALS['GiftWrapModalClass'] = 'SelectGiftWrapMultiple';
			$GLOBALS['SNIPPETS']['GiftWrappingOptions'] = '';
			for($i = 1; $i <= $cartProduct['quantity']; ++$i) {
				$GLOBALS['GiftWrappingId'] = $i;
				$GLOBALS['SNIPPETS']['GiftWrappingOptions'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('GiftWrappingWrapOptions');
			}
		}
		else {
			$GLOBALS['HideSplitWrappingOptions'] = 'display: none';
		}

		$GLOBALS['HideWrappingTitle']		= 'display: none';
		$GLOBALS['HideWrappingSeparator']	= 'display: none';
		$GLOBALS['GiftWrappingId'] = 'all';
		$GLOBALS['SNIPPETS']['GiftWrappingOptionsSingle'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('GiftWrappingWrapOptions');

		$selectWrapping = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('SelectGiftWrapping');
		echo $GLOBALS['ISC_CLASS_TEMPLATE']->ParseSnippets($selectWrapping, $GLOBALS['SNIPPETS']);
	}

	/**
	 * Validate the registration information for a customer registering an account using the express checkout.
	 *
	 * @param boolean Set to true to simply return true instead of spitting out a success message.
	 */
	private function ExpressCheckoutRegister($return=false)
	{
		//alandy.
		$GLOBALS['ISC_CLASS_CUSTOMER'] = GetClass('ISC_CUSTOMER');

		// Check that a customer doesn't already exist with this email address
		if(!isset($_POST['billing_EmailAddress']) || $_POST['billing_EmailAddress'] == '') {
			$tags[] = $this->MakeXMLTag('status', 0);
			$tags[] = $this->MakeXMLTag('message', GetLang('AccountEnterValidEmail'), true);
			$tags[] = $this->MakeXMLTag('focus', '#account_email');
			$tags[] = $this->MakeXMLTag('step', 'BillingAddress');
		}else{
			//alandy 2011-5-26 modify.
			$_SESSION['CHECKOUT']['account_email']=$_POST['billing_EmailAddress'];
		}
		
		/*else if ($GLOBALS['ISC_CLASS_CUSTOMER']->AccountWithEmailAlreadyExists($_POST['billing_EmailAddress'])) {
		 $tags[] = $this->MakeXMLTag('status', 0);
		 $tags[] = $this->MakeXMLTag('message', sprintf(GetLang('AccountUpdateEmailTaken'), $_POST['billing_EmailAddress']), true);
		 $tags[] = $this->MakeXMLTag('focus', '#account_email');
		 $tags[] = $this->MakeXMLTag('step', 'BillingAddress');
			} */

		if(!empty($tags)) {
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
			exit;
		}

		if($return) {
			return;
		}
		else {
			$tags[] = $this->MakeXMLTag('status', 1);
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
			exit;
		}
	}

	/**
	 * Fetch the address entry fields for a guest when using the express checkout.
	 */
	private function GetExpressCheckoutAddressFields()
	{
		$GLOBALS['ISC_CLASS_CHECKOUT'] = GetClass('ISC_CHECKOUT');

		// If the customer was logged in - they've just said they're checking out anonymously so log them out
		$GLOBALS['ISC_CLASS_CUSTOMER'] = GetClass('ISC_CUSTOMER');
		$GLOBALS['ISC_CLASS_CUSTOMER']->Logout(true);

		$tags[] = $this->MakeXMLTag('status', 1);
		$tags[] = $this->MakeXMLTag('billingContents', $GLOBALS['ISC_CLASS_CHECKOUT']->ExpressCheckoutChooseAddress('billing'), true);
		$tags[] = $this->MakeXMLTag('shippingContents', $GLOBALS['ISC_CLASS_CHECKOUT']->ExpressCheckoutChooseAddress('shipping'), true);
		$this->SendXMLHeader();
		$this->SendXMLResponse($tags);
		die();
	}

	/**
	 * Check a customers entered credentials when logging in via the express checkout.
	 */
	private function ExpressCheckoutLogin()
	{
		// Attempt to log the customer in
		$GLOBALS['ISC_CLASS_CUSTOMER'] = GetClass('ISC_CUSTOMER');
		//zcs=>
		$checkResult = $GLOBALS['ISC_CLASS_CUSTOMER']->CheckLogin(true);
		if(intval($checkResult) == -1){
			$tags[] = $this->MakeXMLTag('status', 0);
			$loginLink = '#';
			$onClick = '$("#checkout_type_register").click(); $("#CreateAccountButton").click(); return false;';
			$tags[] = $this->MakeXMLTag('message', sprintf(GetLang('LockedCustomer'), $loginLink, $onClick), true);
			$tags[] = $this->MakeXMLTag('errorContainer', '#CheckoutLoginError');
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
			die();
		}else if(!$checkResult) {
		//<=zcs
			$tags[] = $this->MakeXMLTag('status', 0);
			$loginLink = '#';
			$onClick = '$("#checkout_type_register").click(); $("#CreateAccountButton").click(); return false;';
			$tags[] = $this->MakeXMLTag('message', sprintf(GetLang('CheckoutBadLoginDetails'), $loginLink, $onClick), true);
			$tags[] = $this->MakeXMLTag('errorContainer', '#CheckoutLoginError');
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
			die();
		}

		// Otherwise, the customer is now logged in and can continue the checkout
		$GLOBALS['ISC_CLASS_CHECKOUT'] = GetClass('ISC_CHECKOUT');
		
		//alandy_20110526 for the init guest flag.
		$GLOBALS['Hasemailflag']="no";
		$GLOBALS['Hasemailflag2']="no";
		$_SESSION['Haslogin']=1;
				

		$tags[] = $this->MakeXMLTag('status', 1);
		$tags[] = $this->MakeXMLTag('billingContents', $GLOBALS['ISC_CLASS_CHECKOUT']->ExpressCheckoutChooseAddress('billing'), true);
		$tags[] = $this->MakeXMLTag('shippingContents', $GLOBALS['ISC_CLASS_CHECKOUT']->ExpressCheckoutChooseAddress('shipping'), true);
		$this->SendXMLHeader();
		$this->SendXMLResponse($tags);
		die();
	}

	/**
	 * Generate the payment form for a payment provider (credit card manual, etc) and display it for the express checkout.
	 */
	private function GetExpressCheckoutPaymentForm()
	{
		$GLOBALS['ISC_CLASS_CHECKOUT'] = GetClass('ISC_CHECKOUT');

		// Attempt to create the pending order with the selected details
		$pendingResult = $GLOBALS['ISC_CLASS_CHECKOUT']->SavePendingOrder();

		// There was a problem creating the pending order
		if(!is_array($pendingResult)) {
			$tags[] = $this->MakeXMLTag('status', 0);
			$tags[] = $this->MakeXMLTag('step', 'Confirmation');
			$tags[] = $this->MakeXMLTag('message', GetLang('ProblemCreatingOrder'), true);
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
			exit;
		}

		// There was a problem creating the pending order but we have an actual error message
		if(isset($pendingResult['error'])) {
			$tags[] = $this->MakeXMLTag('status', 0);
			$tags[] = $this->MakeXMLTag('step', 'Confirmation');
			$tags[] = $this->MakeXMLTag('message', $pendingResult['error'], true);
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
			exit;
		}

		// Otherwise, the gateway want's to do something
		if($pendingResult['provider']->GetPaymentType() == PAYMENT_PROVIDER_ONLINE || method_exists($pendingResult['provider'], 'ShowPaymentForm')) {
			if($pendingResult['provider']->GetPaymentType() !== PAYMENT_PROVIDER_ONLINE) {
				$pendingResult['showPaymentForm'] = $pendingResult['provider']->ShowPaymentForm();
			}

			// If we have a payment form to show then show that
			if(isset($pendingResult['showPaymentForm']) && $pendingResult['showPaymentForm']) {
				$tags[] = $this->MakeXMLTag('status', 1);
				$tags[] = $this->MakeXMLTag('paymentContents', $pendingResult['provider']->ShowPaymentForm(), true);
				$this->SendXMLHeader();
				$this->SendXMLResponse($tags);
			}
		}
		exit;
	}

	/**
	 * Validate an incoming shipping or billing address checking for missing fields and showing error
	 * messages where necessary. Returns a structured address array if the passed address is valid.
	 *
	 * @param string The type of address to validate (billing or shipping)
	 * @return array An array of information about the address if valid.
	 */
	private function GetExpressCheckoutAddressData($type)
	{
		// Check to see if our state is required for the selected country
		$stateRequired = false;
		if (isset($_POST[$type.'_country']) && isId($_POST[$type.'_country']) && (!isset($_POST[$type . '_state']) || !$_POST[$type . '_state'])) {
			$query = $GLOBALS['ISC_CLASS_DB']->Query("SELECT COUNT(*) AS Total FROM [|PREFIX|]country_states WHERE statecountry='" . (int)$_POST[$type.'_country'] . "'");
			if (($total = $GLOBALS['ISC_CLASS_DB']->FetchOne($query, 'Total')) > 0) {
				$stateRequired = true;
			}
		}

		$addressVars = array(
				'shipfirstname' => array(
					'field' => $type.'_FirstName',
					'required' => true,
					'message' => GetLang('EnterShippingFirstName')
		),
				'shiplastname' => array(
					'field' => $type.'_LastName',
					'required' => true,
					'message' => GetLang('EnterShippingLastName')
		),
				'shipcompany' => array(
					'field' => $type.'_CompanyName',
					'required' => false,
		),
				'shipaddress1' => array(
					'field' => $type.'_AddressLine1',
					'required' => true,
					'message' => GetLang('EnterShippingAddress')
		),
				'shipaddress2' => array(
					'field' => $type.'_AddressLine2',
					'required' => false,
		),
				'shipcity' => array(
					'field' => $type.'_City',
					'required' => true,
					'message' => GetLang('EnterShippingCity')
		),
				'shipstate' => array(
					'field' => $type.'_State',
					'required' => $stateRequired,
					'message' => GetLang('EnterShippingState')
		),
				'shipzip' => array(
					'field' => $type.'_Zip',
					'required' => true,
					'message' => GetLang('EnterShippingZip')
		),
				'shipcountry' => array(
					'field' => $type.'_Country',
					'required' => true,
					'message' => GetLang('EnterShippingCountry')
		),
				'shipphone' => array(
					'field' => $type.'_Phone',
					'required' => true,
					'message' => GetLang('EnterShippingPhone')
		),
		);

		if($type == 'billing' && !CustomerIsSignedIn()) {
			$addressVars['shipemail'] = array(
					'field' => 'billing_EmailAddress',
					'required' => true,
					'message' => GetLang('AccountEnterValidEmail')
			);
		}

		$addressData = array();
		$step = ucfirst($type).'Address';

		foreach($addressVars as $field => $fieldInfo) {
			$postField = $fieldInfo['field'];
			// If this field is required and it hasn't been passed then we need to spit out an error
			if($fieldInfo['required'] == true && (!isset($_POST[$postField]) || !$_POST[$postField])) {
				$tags[] = $this->MakeXMLTag('status', 0);
				$tags[] = $this->MakeXMLTag('step', $step);
				$tags[] = $this->MakeXMLTag('focus', '#'.$postField);
				$tags[] = $this->MakeXMLTag('message', $fieldInfo['message']);
				$this->SendXMLHeader();
				$this->SendXMLResponse($tags);
				exit;
			}

			// If the state field, we also need to get the ID of the state and save it too
			if($field == 'shipstate') {
				$stateInfo = GetStateInfoByName($_POST[$postField]);
				$addressData['shipstate'] = $_POST[$postField];
				if ($stateInfo) {
					$addressData['shipstateid'] = $stateInfo['stateid'];
				} else {
					$addressData['shipstateid'] = 0;
				}
				continue;
			}
			else if($field == 'shipcountry') {
				$addressData['shipcountry'] = $_POST[$postField];
				$addressData['shipcountryid'] = GetCountryByName($_POST[$postField]);
				if (!isId($addressData['shipcountryid'])) {
					$addressData['shipcountryid'] = 0;
				}
				continue;
			}
			$addressData[$field] = $_POST[$postField];
		}

		$addressData['shipdestination'] = 'residential';

		// OK, we've got everything we want, we can just return it now
		return $addressData;

	}

	/**
	 * Generate the order confirmation message and save the pending order for a customer checking out via the
	 * express checkout
	 */
	private function GetExpressCheckoutConfirmation()
	{
		$GLOBALS['ISC_CLASS_CHECKOUT'] = GetClass('ISC_CHECKOUT');
		$GLOBALS['ISC_CLASS_CART'] = GetClass('ISC_CART');

		// If the customer is not logged in and guest checkout is enabled, then don't go any further
		if(!CustomerIsSignedIn() && !GetConfig('GuestCheckoutEnabled') && !isset($_POST['createAccount'])) {
			$tags[] = $this->MakeXMLTag('status', 0);
			$tags[] = $this->MakeXMLTag('step', 'AccountDetails');
			$tags[] = $this->MakeXMLTag('message', GetLang('GuestCheckoutDisabledError'));
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
			exit;
		}
		
		if(!$GLOBALS['ISC_CLASS_CHECKOUT']->AddAddonProductsToCart()){
			$tags[] = $this->MakeXMLTag('status', 0);
			$tags[] = $this->MakeXMLTag('step', 'AddonProducts');
			$tags[] = $this->MakeXMLTag('message', GetLang('UnableAddAddonProducts'));
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
			exit;
		}

		$confirmation = $GLOBALS['ISC_CLASS_CHECKOUT']->GenerateExpressCheckoutConfirmation();

		$tags[] = $this->MakeXMLTag('status', 1);
		$tags[] = $this->MakeXMLTag('confirmationContents', $confirmation, true);
		$this->SendXMLHeader();
		$this->SendXMLResponse($tags);
		exit;
	}
	
	private function CheckShippingAddress(){
		
		// If the customer is creating an account, validate their account creation
		if(isset($_POST['createAccount'])) {
			$this->ExpressCheckoutRegister(true);
		}
		
		// Using a new billing address
		if(isset($_REQUEST['billingType']) && $_REQUEST['billingType'] == 'new') {
			// Loop through all of the address fields and build the address to save with the order
			$addressData = $this->GetExpressCheckoutAddressData('billing');

			if(isset($_POST['billing_SaveThisAddress'])) {
				$addressData['saveAddress'] = true;
			}

			// Set aside any of the custom fields if we have any
			if (isset($_POST['custom']) && is_array($_POST['custom'])) {
				// We need to split it up between customer and billing custom data

				$accountFields = $GLOBALS['ISC_CLASS_FORM']->getFormFields(FORMFIELDS_FORM_ACCOUNT);
				$accountData = array();
				$billingData = array();

				foreach (array_keys($_POST['custom']) as $fieldId) {
					if (array_key_exists($fieldId, $accountFields)) {
						$accountData[$fieldId] = $_POST['custom'][$fieldId];
					} else {
						$billingData[$fieldId] = $_POST['custom'][$fieldId];
					}
				}

				if (!empty($accountData)) {
					$GLOBALS['ISC_CLASS_CHECKOUT']->SetCustomFieldData('customer', $accountData);
				}

				if (!empty($billingData)) {
					$GLOBALS['ISC_CLASS_CHECKOUT']->SetCustomFieldData('billing', $billingData);
				}
			}

			if(!$GLOBALS['ISC_CLASS_CHECKOUT']->SetOrderBillingAddress($addressData)) {
				$tags[] = $this->MakeXMLTag('status', 0);
				$tags[] = $this->MakeXMLTag('step', 'BillingAddress');
				$tags[] = $this->MakeXMLTag('message', GetLang('UnableSaveOrderBillingAddress'));
				$this->SendXMLHeader();
				$this->SendXMLResponse($tags);
				exit;
			}
		}else {
			// If we're here, we need to save the details the customer entered in the session
			if(!$GLOBALS['ISC_CLASS_CHECKOUT']->SetOrderBillingAddress($_REQUEST['billingAddressId'])) {
				$tags[] = $this->MakeXMLTag('status', 0);
				$tags[] = $this->MakeXMLTag('step', 'BillingAddress');
				$tags[] = $this->MakeXMLTag('message', GetLang('UnableSaveOrderBillingAddress'));
				$this->SendXMLHeader();
				$this->SendXMLResponse($tags);
				exit;
			}
		}

		if(!$GLOBALS['ISC_CLASS_CART']->api->AllProductsInCartAreIntangible()) {
			// If the shipping provider couldn't be saved with the order show an error message
			$checkout = GetClass('ISC_CHECKOUT');
			$cartContent = $checkout->BreakdownCartByAddressVendorforshipping();
			foreach($cartContent as $vendorId => $addresses) {
				foreach(array_keys($addresses) as $addressId) {
					if(!isset($_REQUEST['selectedShippingMethod'][$vendorId][$addressId]) || !$GLOBALS['ISC_CLASS_CHECKOUT']->SetOrderShippingProvider($vendorId, $addressId, $_REQUEST['selectedShippingMethod'][$vendorId][$addressId])) {
						$tags[] = $this->MakeXMLTag('status', 0);
						$tags[] = $this->MakeXMLTag('step', 'ShippingProvider');
						//$tags[] = $this->MakeXMLTag('providers', $this->GetExpressCheckoutShippers(false));
						$tags[] = $this->MakeXMLTag('message', GetLang('UnableSaveOrderShippingMethod'));
						$this->SendXMLHeader();
						$this->SendXMLResponse($tags);
						exit;
					}
				}
			}
		}
		
	}
	
	/**
	 * Generate a list of add-on products for a customer checking out via the express checkout.
	 */
	private function GetExpressCheckoutAddonProducts(){
		$GLOBALS['ISC_CLASS_CHECKOUT'] = GetClass('ISC_CHECKOUT');
		$GLOBALS['ISC_CLASS_CART'] = GetClass('ISC_CART');

		// If the customer is not logged in and guest checkout is enabled, then don't go any further
		if(!CustomerIsSignedIn() && !GetConfig('GuestCheckoutEnabled') && !isset($_POST['createAccount'])) {
			$tags[] = $this->MakeXMLTag('status', 0);
			$tags[] = $this->MakeXMLTag('step', 'AccountDetails');
			$tags[] = $this->MakeXMLTag('message', GetLang('GuestCheckoutDisabledError'));
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
		}
		
		$this->CheckShippingAddress();
		
		$addon_products = $GLOBALS['ISC_CLASS_CHECKOUT']->GenerateExpressCheckoutAddonProducts();
		
		if(false !== $addon_products){
			$tags[] = $this->MakeXMLTag('status', 1);
			$tags[] = $this->MakeXMLTag('confirmationContents', $addon_products, true);
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
		}else{
			$tags[] = $this->MakeXMLTag('status', 0);
			$tags[] = $this->MakeXMLTag('step', 'ShippingProvider');
			$tags[] = $this->MakeXMLTag('message', GetLang('UnableSaveOrderShippingMethod'));
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
		}
		exit;
	}

	/**
	 * Generate a list of shipping methods/providers for a customer checking out via the express checkout.
	 */
	private function GetExpressCheckoutShippers($ajax = true)
	{
		// Now we have the zone, what available shipping methods do we have?
		$checkout = GetClass('ISC_CHECKOUT');
		$cart = GetClass('ISC_CART');

		if(!$cart->api->AllProductsInCartAreIntangible() && $ajax) {
			// Using a new shipping address
			if(isset($_REQUEST['shippingType']) && $_REQUEST['shippingType'] == 'new') {
				$addressData = $this->GetExpressCheckoutAddressData('shipping');

				if(isset($_POST['shipping_SaveThisAddress']) && $_POST['shipping_SaveThisAddress'] !== '') {
					$addressData['saveAddress'] = true;
				}
				$addressId = 0;

				// Set aside any of the custom fields if we have any
				if (isset($_POST['custom']) && is_array($_POST['custom'])) {

					/**
					 * We need to map this into the billing fields as we are assuming that any
					 * address is using the billing fields in the frontend
					 */
					$shippingKeys = array_keys($_POST['custom']);
					$fieldAddressMap = $GLOBALS['ISC_CLASS_FORM']->mapAddressFieldList(FORMFIELDS_FORM_SHIPPING, $shippingKeys);
					$shippingSessData = array();

					foreach ($fieldAddressMap as $field => $newBillingId) {
						$shippingSessData[$newBillingId] = $_POST['custom'][$field];
					}

					$checkout->SetCustomFieldData('shipping', $shippingSessData);
				}

				if(!$checkout->SetOrderShippingAddress($addressData)) {
					$tags[] = $this->MakeXMLTag('status', 0);
					$tags[] = $this->MakeXMLTag('step', 'ShippingAddress');
					$tags[] = $this->MakeXMLTag('message', GetLang('UnableSaveOrderShippingAddress'));
					$this->SendXMLHeader();
					$this->SendXMLResponse($tags);
					exit;
				}
			}
			// Otherwise we've selected an existing address to use
			else {
				if(!isset($_REQUEST['shippingAddressId']) || !$checkout->SetOrderShippingAddress($_REQUEST['shippingAddressId'])) {
					$tags[] = $this->MakeXMLTag('status', 0);
					$tags[] = $this->MakeXMLTag('step', 'ShippingAddress');
					$tags[] = $this->MakeXMLTag('message', GetLang('UnableSaveOrderShippingAddress'));
					$this->SendXMLHeader();
					$this->SendXMLResponse($tags);
					exit;
				}
				else {
					$addressId = $_REQUEST['shippingAddressId'];
				}
			}
		}

		$availableMethods = $checkout->GetCheckoutShippingMethods();

		if(empty($availableMethods)) {
			$tags[] = $this->MakeXMLTag('status', 0);
			$tags[] = $this->MakeXMLTag('step', 'ShippingAddress');
			$tags[] = $this->MakeXMLTag('message', GetLang('UnableToShipToAddressSingle'), true);
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
			exit;
		}

		$hideItemList = false;
		if(count($availableMethods) == 1 && count(current($availableMethods)) == 1) {
			$GLOBALS['HideVendorTitle'] = 'display: none';
			$GLOBALS['HideVendorItems'] = 'display: none';
			$hideItemList = true;
		}

		$hasTransit = false;
		$GLOBALS['ShippingQuotes'] = '';
		$orderShippingAddresses = $checkout->GetOrderShippingAddresses();
			//$vendors = $cart->api->GetCartVendorIds();
			$vendors = $checkout->GetCheckoutVendorIds();
		$vendors = array(0 => $vendors[0]);
		foreach($vendors as $i => $vendorId) {
			$GLOBALS['VendorId'] = $vendorId;
			if($vendorId != 0) {
				$vendorCache = $GLOBALS['ISC_CLASS_DATA_STORE']->Read('Vendors');
				$vendor = $vendorCache[$vendorId];
				$GLOBALS['VendorName'] = isc_html_escape($vendor['vendorname']);
			}
			else {
				$GLOBALS['VendorName'] = GetConfig('StoreName');
			}

			$shippingDestinations = $availableMethods[$vendorId];
			if(count($shippingDestinations) == 1 && !isset($_SESSION['CHECKOUT']['SPLIT_SHIPPING'])) {
				$GLOBALS['HideAddressLine'] = 'display: none';
			}
			else {
				$GLOBALS['HideAddressLine'] = '';
			}
			
			// add by mike,if $shippingDestinations is not an array,cause php warnings
			if(!is_array($shippingDestinations))
			{
				continue;
			}

			$textItemList = '';

			foreach($shippingDestinations as $addressId => $shippingInfo) {
				if(isset($vendors[$i+1]) || isset($shippingDestinations[$addressId+1])) {
					$GLOBALS['HideHorizontalRule'] = '';
				}
				else {
					$GLOBALS['HideHorizontalRule'] = 'display: none';
				}

				$GLOBALS['AddressId'] = $addressId;
				// If no methods are available, this order can't progress so show an error
				if(empty($shippingInfo['quotes'])) {
					$GLOBALS['HideNoShippingProviders'] = '';
					$GLOBALS['HideShippingProviderList'] = 'none';
					$hideItemList = false;
				}

				$GLOBALS['ItemList'] = '';
				if(!$hideItemList) {
					foreach($shippingInfo['items'] as $product) {
						// Only show physical items
						if($product['data']['prodtype'] != PT_PHYSICAL) {
							continue;
						}
						$textItemList .= $product['quantity'].' x '.$product['product_name']."\n";
						$GLOBALS['ProductQuantity'] = $product['quantity'];
						$GLOBALS['ProductName'] = isc_html_escape($product['product_name']);

						$GLOBALS['HideGiftWrapping'] = 'display: none';
						$GLOBALS['HideGiftMessagePreview'] = 'display: none';
						$GLOBALS['GiftWrappingName'] = '';
						$GLOBALS['GiftMessagePreview'] = '';
						if(isset($product['wrapping']['wrapname'])) {
							$GLOBALS['HideGiftWrapping'] = '';
							$GLOBALS['GiftWrappingName'] = isc_html_escape($product['wrapping']['wrapname']);
							if(isset($product['wrapping']['wrapmessage'])) {
								if(isc_strlen($product['wrapping']['wrapmessage']) > 30) {
									$product['wrapping']['wrapmessage'] = substr($product['wrapping']['wrapmessage'], 0, 27).'...';
								}
								$GLOBALS['GiftMessagePreview'] = isc_html_escape($product['wrapping']['wrapmessage']);
								if($product['wrapping']['wrapmessage']) {
									$GLOBALS['HideGiftMessagePreview'] = '';
								}
							}
						}

						$GLOBALS['ItemList'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('ShippingQuoteProduct');
					}
				}

				// If no methods are available, this order can't progress so show an error
				if(empty($shippingInfo['quotes'])) {
					$tags[] = $this->MakeXMLTag('status', 0);
					$tags[] = $this->MakeXMLTag('step', 'ShippingAddress');
					$textItemList = rtrim($textItemList, "\n");
					$tags[] = $this->MakeXMLTag('message', GetLang('AjaxUnableToShipToAddress')."\n\n".$textItemList, true);
					$this->SendXMLHeader();
					$this->SendXMLResponse($tags);
					exit;
				}

				if(!$GLOBALS['HideAddressLine']) {
					$address = $orderShippingAddresses[$addressId];
					$addressLine = array(
					$address['shipfirstname'].' '.$address['shiplastname'],
					$address['shipcompany'],
					$address['shipaddress1'],
					$address['shipaddress2'],
					$address['shipcity'],
					$address['shipstate'],
					$address['shipzip'],
					$address['shipcountry']
					);

					// Please see self::GenerateShippingSelect below.
					$addressLine = array_filter($addressLine, array($checkout, 'FilterAddressFields'));
					$GLOBALS['AddressLine'] = isc_html_escape(implode(', ', $addressLine));
				}
				else {
					$GLOBALS['AddressLine'] = '';
				}

				// Now build a list of the actual available quotes
				$GLOBALS['ShippingProviders'] = '';
				foreach($shippingInfo['quotes'] as $quoteId => $method) {
					$GLOBALS['ShipperName'] = isc_html_escape($method['description']);
//					$GLOBALS['ShippingPrice'] = CurrencyConvertFormatPrice($method['price']);
                    
                    /*
					if($GLOBALS['ShippingPrice'] == "$14.95")
					{
						$GLOBALS['ShipperName'] = "Shipping Charge $14.95 (Flat Rate Ground Shipping In Continental USA For Orders Less Than $99 - See <a onclick=\"ShowPopupCustom('shipping.html','615','600'); return false;\" rel=\"nofollow\" href=\"".$GLOBALS['ShopPath']."/shipping.html\">Shipping</a> Policy)";
						$GLOBALS['ShippingPrice'] = "";
					}
					else if($GLOBALS['ShippingPrice'] == "$0.00")
					{
						$GLOBALS['ShipperName'] = "Shipping Charge $0.00 (Free Ground Shipping In Continental USA For All Orders! - See <a onclick=\"ShowPopupCustom('shipping.html','615','600'); return false;\" rel=\"nofollow\" href=\"".$GLOBALS['ShopPath']."/shipping.html\">Shipping</a> Policy)";
						$GLOBALS['ShippingPrice'] = "";
					}
                     */
                    
                    if (isset($method['display_message']) && !empty($method['display_message'])) {
                        $replace = array(
                            CurrencyConvertFormatPrice($method['price']),
                            CurrencyConvertFormatPrice($method['lower']),
                            CurrencyConvertFormatPrice($method['upper'])
                        );
                        $GLOBALS['ShipperName'] = str_replace(array('%p', '%l', '%u'), $replace, $method['display_message']);
                    } elseif ($method['price'] > 0) {
                        $GLOBALS['ShipperName'] = str_replace('%p', CurrencyConvertFormatPrice($method['price']), "Shipping Charge %p (Free Ground Shipping In Continental USA For All Orders! - See <a onclick=\"ShowPopupCustom('shipping.html','615','600'); return false;\" rel=\"nofollow\" href=\"".$GLOBALS['ShopPath']."/shipping.html\">Shipping</a> Policy)");
                    } else {
                        $GLOBALS['ShipperName'] = "Shipping Charge $0.00 (Free Ground Shipping In Continental USA For All Orders! - See <a onclick=\"ShowPopupCustom('shipping.html','615','600'); return false;\" rel=\"nofollow\" href=\"".$GLOBALS['ShopPath']."/shipping.html\">Shipping</a> Policy)";
                    }
                    
                    
					$GLOBALS['ShippingQuoteId'] = $quoteId;
					$GLOBALS['ShippingData'] = $GLOBALS['ShippingQuoteId'];

					if(isset($method['transit'])) {
						$hasTransit = true;

						$days = $method['transit'];

						if ($days == 0) {
							$transit = GetLang("SameDay");
						}
						else if ($days == 1) {
							$transit = GetLang('NextDay');
						}
						else {
							$transit = sprintf(GetLang('Days'), $days);
						}

						$GLOBALS['TransitTime'] = $transit;
						$GLOBALS['TransitTime'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('CartShippingTransitTime');
					}
					else {
						$GLOBALS['TransitTime'] = "";
					}
					$GLOBALS['ShippingProviders'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("ExpressCheckoutShippingMethod");
				}

				// Add it to the list
				$GLOBALS['ShippingQuotes'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('ShippingQuote');
				$_SESSION['CHECKOUT']['SHIPPING_QUOTES'][$vendorId][$addressId] = $shippingInfo['quotes'];
			}
		}

		if ($hasTransit) {
			$GLOBALS['DeliveryDisclaimer'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('CartShippingDeliveryDisclaimer');
		}



		$GLOBALS['ExpressCheckoutSelectShippingProviderLabel'] = GetLang('ExpressCheckoutSelectShippingProvider');


		$methodList = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('ExpressCheckoutChooseShipper');
		
		if($ajax){
			$tags[] = $this->MakeXMLTag('status', 1);
			$tags[] = $this->MakeXMLTag('providerContents', $methodList, true);
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
		}else{
			return $methodList;
		}
	}

	/**
	 * Retrieve a list of shipping quotes for a customer estimating their shipping on the 'View Cart' page.
	 */
	private function GetShippingQuotes()
	{
		if(!isset($_POST['countryId'])) {
			exit;
		}

		unset($_SESSION['SHIPPING']);

		// Determine which shipping zone we're in
		$address = array(
				'shipcountryid' => (int)$_POST['countryId'],
				'shipstateid' => '',
				'shipzip' => ''
				);

				$_SESSION['CART']['SHIPPING']['COUNTRY_ID'] = (int)$_POST['countryId'];

				if(isset($_POST['stateId'])) {
					$address['shipstateid'] = (int)$_POST['stateId'];
					$_SESSION['CART']['SHIPPING']['STATE_ID'] = (int)$_POST['stateId'];
				}

				if(isset($_POST['zipCode'])) {
					$address['shipzip'] = $_POST['zipCode'];
					$_SESSION['CART']['SHIPPING']['ZIP_CODE'] = $_POST['zipCode'];
				}

				// What shipping zone do we fall under?
				$shippingZone = GetShippingZoneIdByAddress($address);

				$_SESSION['CART']['SHIPPING']['ZONE'] = $shippingZone;

				// Now we have the zone, what available shipping methods do we have?
				$cart = GetClass('ISC_CART');
				$vendorMethods = $cart->GetAvailableShippingMethods($address);

				$cartProducts = $cart->api->GetProductsInCartByVendorforshipping();

				$GLOBALS['ShippingQuotes'] = '';

				// If there's only one vendor, don't show the vendor titles
				$GLOBALS['HideVendorDetails'] = '';
				$hideItemList = false;
				if(count($cartProducts) == 1) {
					$hideItemList = true;
					$GLOBALS['HideVendorDetails'] = 'display: none';
					$GLOBALS['ShippingQuotesListNote'] = '';
					$GLOBALS['HideShippingQuotesListNote'] = 'display: none';
					$GLOBALS['VendorShippingQuoteClass'] = '';
				}
				else {
					$GLOBALS['ShippingQuotesListNote'] = GetLang('ShippingQuotesListNote');
					$GLOBALS['HideShippingQuotesListNote'] = '';
					$GLOBALS['VendorShippingQuoteClass'] = 'VendorShipping';
				}

				$hasTransit = false;

				foreach($vendorMethods as $vendorId => $methods) {
					if(empty($methods)) {
						//echo GetLang('UnableEstimateShipping'); // commented this line as client told to change the message
						echo GetLang('UnableEstimateShippingInCart');
						exit;
					}
					$GLOBALS['VendorId'] = $vendorId;
					$vendorCache = $GLOBALS['ISC_CLASS_DATA_STORE']->Read('Vendors');

					if($vendorId != 0) {
						$vendorCache = $GLOBALS['ISC_CLASS_DATA_STORE']->Read('Vendors');
						$vendor = $vendorCache[$vendorId];
						$GLOBALS['VendorName'] = isc_html_escape($vendor['vendorname']);
					}
					else {
						$GLOBALS['VendorName'] = GetConfig('StoreName');
					}

					$GLOBALS['ShippingQuoteRow'] = '';

					foreach($methods as $quoteId => $method) {
						$GLOBALS['ShipperName'] = isc_html_escape($method['description']);
						$GLOBALS['ShippingPrice'] = CurrencyConvertFormatPrice($method['price']);
						$GLOBALS['ShippingQuoteId'] = $quoteId;

						$GLOBALS['ShippingItemList'] = '';
						$GLOBALS['HideShippingItemList'] = 'display: none';
						if(!$hideItemList && !empty($cartProducts[$vendorId])) {
							$GLOBALS['HideShippingItemList'] = '';
							foreach($cartProducts[$vendorId] as $product) {
								if($product['data']['prodtype'] != PT_PHYSICAL) {
									continue;
								}
								$GLOBALS['ProductQuantity'] = $product['quantity'];
								$GLOBALS['ProductName'] = isc_html_escape($product['product_name']);
								$GLOBALS['ShippingItemList'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('EstimatedShippingQuoteProduct');
							}
						}

						if(isset($method['transit'])) {
							$hasTransit = true;

							$days = $method['transit'];

							if ($days == 0) {
								$transit = GetLang("SameDay");
							}
							else if ($days == 1) {
								$transit = GetLang('NextDay');
							}
							else {
								$transit = sprintf(GetLang('Days'), $days);
							}

							$GLOBALS['TransitTime'] = $transit;
							$GLOBALS['TransitTime'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('CartShippingTransitTime');
						}
						else {
							$GLOBALS['TransitTime'] = "";
						}

						$GLOBALS['ShippingQuoteRow'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('CartShippingQuoteRow');
					}
					$GLOBALS['ShippingQuotes'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('EstimatedShippingQuote');

					// For good measure (and validation on the server side!) we store the list of quotes we got
					$_SESSION['CART']['SHIPPING_QUOTES'][$vendorId] = $methods;
				}

				if ($hasTransit) {
					$GLOBALS['DeliveryDisclaimer'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('CartShippingDeliveryDisclaimer');
				}

				echo $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('EstimatedShippingQuoteList');
	}

	private function GetCountryStates()
	{
		$country = $_REQUEST['c'];
		echo GetStateList($country);
	}

	private function GetExchangeRate()
	{
		if (!array_key_exists("currencyid", $_REQUEST)
		|| !($result = $GLOBALS['ISC_CLASS_DB']->Query("SELECT * FROM [|PREFIX|]currencies WHERE currencyid = " . $_REQUEST['currencyid']))
		|| !($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result))) {
			exit;
		}

		print $row['currencyexchangerate'];
		exit;
	}

	public function GetStateList()
	{
		if (!array_key_exists('countryName', $_POST) || $_POST['countryName'] == '') {
			$tags[] = $this->MakeXMLTag('status', 0);
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
			exit;
		}

		$tags[] = $this->MakeXMLTag('status', 1);
		$tags[] = '<options>';

		$query = "SELECT statename
						FROM [|PREFIX|]countries c
							JOIN [|PREFIX|]country_states s ON c.countryid = s.statecountry
						WHERE c.countryname='" . $GLOBALS['ISC_CLASS_DB']->Quote($_POST['countryName']) . "'
						ORDER BY statename ASC";

		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$tags[] = '<option>';
			$tags[] = $this->MakeXMLTag('name', $row['statename'], true);
			$tags[] = '</option>';
		}

		$tags[] = '</options>';
		$this->SendXMLHeader();
		$this->SendXMLResponse($tags);
		exit;
	}

	private function GetCountryList()
	{
		$tags[] = $this->MakeXMLTag('status', 1);
		$tags[] = '<options>';

		$result = $GLOBALS['ISC_CLASS_DB']->Query("SELECT * FROM [|PREFIX|]countries ORDER BY countryname ASC");
		while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$tags[] = '<option>';
			$tags[] = $this->MakeXMLTag('name', $row['countryname'], true);
			$tags[] = '</option>';
		}

		$tags[] = '</options>';
		$this->SendXMLHeader();
		$this->SendXMLResponse($tags);
		exit;
	}

	/**
		* Handles adding products from the list display mode
		*
		*/
	private function AddProductsToCart()
	{
		$response = array();

		if (isset($_REQUEST['products'])) {
			$cart = GetClass('ISC_CART');

			$products = explode("&", $_REQUEST["products"]);

			foreach ($products as $product) {
				list($id, $qty) = explode("=", $product);
				if (!$cart->AddSimpleProductToCart($id, $qty)) {
					$response["error"] = $_SESSION['ProductErrorMessage'];
				}
			}
		}

		echo isc_json_encode($response);
		exit;
	}

	private function GetExpressOfferConfirmation()
	{

		$GLOBALS['ISC_CLASS_FINALIZEOFFER'] = GetClass('ISC_FINALIZEOFFER');
		$GLOBALS['ISC_CLASS_MAKEAOFFER'] = GetClass('ISC_MAKEAOFFER');

		// If the customer is not logged in and guest checkout is enabled, then don't go any further
		if(!CustomerIsSignedIn() && !GetConfig('GuestCheckoutEnabled') && !isset($_POST['createAccount'])) {
			$tags[] = $this->MakeXMLTag('status', 0);
			$tags[] = $this->MakeXMLTag('step', 'AccountDetails');
			$tags[] = $this->MakeXMLTag('message', GetLang('GuestCheckoutDisabledError'));
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
		}

		// If the customer is creating an account, validate their account creation
		if(isset($_POST['createAccount'])) {
			$this->ExpressCheckoutRegister(true);
		}

		// Using a new billing address
		if(isset($_REQUEST['billingType']) && $_REQUEST['billingType'] == 'new') {
			// Loop through all of the address fields and build the address to save with the order
			$addressData = $this->GetExpressCheckoutAddressData('billing');

			if(isset($_POST['billing_SaveThisAddress'])) {
				$addressData['saveAddress'] = true;
			}

			// Set aside any of the custom fields if we have any
			if (isset($_POST['custom']) && is_array($_POST['custom'])) {
				// We need to split it up between customer and billing custom data

				$accountFields = $GLOBALS['ISC_CLASS_FORM']->getFormFields(FORMFIELDS_FORM_ACCOUNT);
				$accountData = array();
				$billingData = array();

				foreach (array_keys($_POST['custom']) as $fieldId) {
					if (array_key_exists($fieldId, $accountFields)) {
						$accountData[$fieldId] = $_POST['custom'][$fieldId];
					} else {
						$billingData[$fieldId] = $_POST['custom'][$fieldId];
					}
				}

				if (!empty($accountData)) {
					$GLOBALS['ISC_CLASS_FINALIZEOFFER']->SetCustomFieldData('customer', $accountData);
				}

				if (!empty($billingData)) {
					$GLOBALS['ISC_CLASS_FINALIZEOFFER']->SetCustomFieldData('billing', $billingData);
				}
			}

			if(!$GLOBALS['ISC_CLASS_FINALIZEOFFER']->SetOrderBillingAddress($addressData)) {
				$tags[] = $this->MakeXMLTag('status', 0);
				$tags[] = $this->MakeXMLTag('step', 'BillingAddress');
				$tags[] = $this->MakeXMLTag('message', GetLang('UnableSaveOrderBillingAddress'));
				$this->SendXMLHeader();
				$this->SendXMLResponse($tags);
				exit;
			}
		}
		else {
			// If we're here, we need to save the details the customer entered in the session
			if(!$GLOBALS['ISC_CLASS_FINALIZEOFFER']->SetOrderBillingAddress($_REQUEST['billingAddressId'])) {
				$tags[] = $this->MakeXMLTag('status', 0);
				$tags[] = $this->MakeXMLTag('step', 'BillingAddress');
				$tags[] = $this->MakeXMLTag('message', GetLang('UnableSaveOrderBillingAddress'));
				$this->SendXMLHeader();
				$this->SendXMLResponse($tags);
				exit;
			}
		}

		if(!$GLOBALS['ISC_CLASS_MAKEAOFFER']->api->AllProductsInCartAreIntangible()) {
			// If the shipping provider couldn't be saved with the order show an error message
			$checkout = GetClass('ISC_FINALIZEOFFER');
			$cartContent = $checkout->BreakdownCartByAddressVendorforshipping();
			foreach($cartContent as $vendorId => $addresses) {
				foreach(array_keys($addresses) as $addressId) {
					if(!isset($_REQUEST['selectedShippingMethod'][$vendorId][$addressId]) || !$GLOBALS['ISC_CLASS_FINALIZEOFFER']->SetOrderShippingProvider($vendorId, $addressId, $_REQUEST['selectedShippingMethod'][$vendorId][$addressId])) {
						$tags[] = $this->MakeXMLTag('status', 0);
						$tags[] = $this->MakeXMLTag('step', 'ShippingAddress');
						$tags[] = $this->MakeXMLTag('message', GetLang('UnableSaveOrderShippingAddress'));
						$this->SendXMLHeader();
						$this->SendXMLResponse($tags);
						exit;
					}
				}
			}
		}
		$confirmation = $GLOBALS['ISC_CLASS_FINALIZEOFFER']->GenerateExpressCheckoutConfirmation();

		$tags[] = $this->MakeXMLTag('status', 1);
		$tags[] = $this->MakeXMLTag('confirmationContents', $confirmation, true);
		$this->SendXMLHeader();
		$this->SendXMLResponse($tags);
		exit;
	}
	private function GetExpressOfferPaymentForm()
	{
		$GLOBALS['ISC_CLASS_FINALIZEOFFER'] = GetClass('ISC_FINALIZEOFFER');

		// Attempt to create the pending order with the selected details
		$pendingResult = $GLOBALS['ISC_CLASS_FINALIZEOFFER']->SavePendingOrder();

		// There was a problem creating the pending order
		if(!is_array($pendingResult)) {
			$tags[] = $this->MakeXMLTag('status', 0);
			$tags[] = $this->MakeXMLTag('step', 'Confirmation');
			$tags[] = $this->MakeXMLTag('message', GetLang('ProblemCreatingOrder'), true);
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
			exit;
		}

		// There was a problem creating the pending order but we have an actual error message
		if(isset($pendingResult['error'])) {
			$tags[] = $this->MakeXMLTag('status', 0);
			$tags[] = $this->MakeXMLTag('step', 'Confirmation');
			$tags[] = $this->MakeXMLTag('message', $pendingResult['error'], true);
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
			exit;
		}

		// Otherwise, the gateway want's to do something
		if($pendingResult['provider']->GetPaymentType() == PAYMENT_PROVIDER_ONLINE || method_exists($pendingResult['provider'], 'ShowPaymentForm')) {
			if($pendingResult['provider']->GetPaymentType() !== PAYMENT_PROVIDER_ONLINE) {
				$pendingResult['showPaymentForm'] = $pendingResult['provider']->ShowPaymentForm();
			}

			// If we have a payment form to show then show that
			if(isset($pendingResult['showPaymentForm']) && $pendingResult['showPaymentForm']) {
				$tags[] = $this->MakeXMLTag('status', 1);
				$tags[] = $this->MakeXMLTag('paymentContents', $pendingResult['provider']->ShowPaymentForm(), true);
				$this->SendXMLHeader();
				$this->SendXMLResponse($tags);
			}
		}
		exit;
	}

	private function GetExpressOfferShippers()
	{



		// Now we have the zone, what available shipping methods do we have?
		$checkout = GetClass('ISC_FINALIZEOFFER');
		$cart = GetClass('ISC_MAKEAOFFER');

		
		if(!$cart->api->AllProductsInCartAreIntangible()) {
			
			// Using a new shipping address
			if(isset($_REQUEST['shippingType']) && $_REQUEST['shippingType'] == 'new') {
				$addressData = $this->GetExpressCheckoutAddressData('shipping');

				if(isset($_POST['shipping_SaveThisAddress']) && $_POST['shipping_SaveThisAddress'] !== '') {
					$addressData['saveAddress'] = true;
				}
				$addressId = 0;

				// Set aside any of the custom fields if we have any
				if (isset($_POST['custom']) && is_array($_POST['custom'])) {

					/**
					 * We need to map this into the billing fields as we are assuming that any
					 * address is using the billing fields in the frontend
					 */
					$shippingKeys = array_keys($_POST['custom']);
					$fieldAddressMap = $GLOBALS['ISC_CLASS_FORM']->mapAddressFieldList(FORMFIELDS_FORM_SHIPPING, $shippingKeys);
					$shippingSessData = array();

					foreach ($fieldAddressMap as $field => $newBillingId) {
						$shippingSessData[$newBillingId] = $_POST['custom'][$field];
					}

					$checkout->SetCustomFieldData('shipping', $shippingSessData);
				}

				if(!$checkout->SetOrderShippingAddress($addressData)) {
					
					$tags[] = $this->MakeXMLTag('status', 0);
					$tags[] = $this->MakeXMLTag('step', 'ShippingAddress');
					$tags[] = $this->MakeXMLTag('message', GetLang('UnableSaveOrderShippingAddress'));
					$this->SendXMLHeader();
					$this->SendXMLResponse($tags);
					exit;
				}
			}
			// Otherwise we've selected an existing address to use
			else {
				if(!isset($_REQUEST['shippingAddressId']) || !$checkout->SetOrderShippingAddress($_REQUEST['shippingAddressId'])) {
					$tags[] = $this->MakeXMLTag('status', 0);
					$tags[] = $this->MakeXMLTag('step', 'ShippingAddress');
					$tags[] = $this->MakeXMLTag('message', GetLang('UnableSaveOrderShippingAddress'));
					$this->SendXMLHeader();
					$this->SendXMLResponse($tags);
					exit;
				}
				else {
					$addressId = $_REQUEST['shippingAddressId'];
				}
			}
		}

		$availableMethods = $checkout->GetCheckoutShippingMethods();

		if(empty($availableMethods)) {
			$tags[] = $this->MakeXMLTag('status', 0);
			$tags[] = $this->MakeXMLTag('step', 'ShippingAddress');
			$tags[] = $this->MakeXMLTag('message', GetLang('UnableToShipToAddressSingle'), true);
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
			exit;
		}

		$hideItemList = false;
		if(count($availableMethods) == 1 && count(current($availableMethods)) == 1) {
			$GLOBALS['HideVendorTitle'] = 'display: none';
			$GLOBALS['HideVendorItems'] = 'display: none';
			$hideItemList = true;
		}

			$hasTransit = false;
			$GLOBALS['ShippingQuotes'] = '';
			$orderShippingAddresses = $checkout->GetOrderShippingAddresses();
			$vendors = $cart->api->GetCartVendorIds();
			$vendors = array(0 => $vendors[0]);
			foreach($vendors as $i => $vendorId) {
				$GLOBALS['VendorId'] = $vendorId;
				if($vendorId != 0) {
					$vendorCache = $GLOBALS['ISC_CLASS_DATA_STORE']->Read('Vendors');
					$vendor = $vendorCache[$vendorId];
					$GLOBALS['VendorName'] = isc_html_escape($vendor['vendorname']);
				}
				else {
					$GLOBALS['VendorName'] = GetConfig('StoreName');
				}

				$shippingDestinations = $availableMethods[$vendorId];
				if(count($shippingDestinations) == 1 && !isset($_SESSION['CHECKOUT']['SPLIT_SHIPPING'])) {
					$GLOBALS['HideAddressLine'] = 'display: none';
				}
				else {
					$GLOBALS['HideAddressLine'] = '';
				}

			$textItemList = '';

			foreach($shippingDestinations as $addressId => $shippingInfo) {
				
				if(isset($vendors[$i+1]) || isset($shippingDestinations[$addressId+1])) {
					$GLOBALS['HideHorizontalRule'] = '';
				}
				else {
					$GLOBALS['HideHorizontalRule'] = 'display: none';
				}

				$GLOBALS['AddressId'] = $addressId;
				// If no methods are available, this order can't progress so show an error
				if(empty($shippingInfo['quotes'])) {
					$GLOBALS['HideNoShippingProviders'] = '';
					$GLOBALS['HideShippingProviderList'] = 'none';
					$hideItemList = false;
				}

				$GLOBALS['ItemList'] = '';
				if(!$hideItemList) {
					foreach($shippingInfo['items'] as $product) {
						// Only show physical items
						if($product['data']['prodtype'] != PT_PHYSICAL) {
							continue;
						}
						$textItemList .= $product['quantity'].' x '.$product['product_name']."\n";
						$GLOBALS['ProductQuantity'] = $product['quantity'];
						$GLOBALS['ProductName'] = isc_html_escape($product['product_name']);

						$GLOBALS['HideGiftWrapping'] = 'display: none';
						$GLOBALS['HideGiftMessagePreview'] = 'display: none';
						$GLOBALS['GiftWrappingName'] = '';
						$GLOBALS['GiftMessagePreview'] = '';
						if(isset($product['wrapping']['wrapname'])) {
							$GLOBALS['HideGiftWrapping'] = '';
							$GLOBALS['GiftWrappingName'] = isc_html_escape($product['wrapping']['wrapname']);
							if(isset($product['wrapping']['wrapmessage'])) {
								if(isc_strlen($product['wrapping']['wrapmessage']) > 30) {
									$product['wrapping']['wrapmessage'] = substr($product['wrapping']['wrapmessage'], 0, 27).'...';
								}
								$GLOBALS['GiftMessagePreview'] = isc_html_escape($product['wrapping']['wrapmessage']);
								if($product['wrapping']['wrapmessage']) {
									$GLOBALS['HideGiftMessagePreview'] = '';
								}
							}
						}

						$GLOBALS['ItemList'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('ShippingQuoteProduct');
					}
				}

				// If no methods are available, this order can't progress so show an error
				if(empty($shippingInfo['quotes'])) {
					$tags[] = $this->MakeXMLTag('status', 0);
					$tags[] = $this->MakeXMLTag('step', 'ShippingAddress');
					$textItemList = rtrim($textItemList, "\n");
					$tags[] = $this->MakeXMLTag('message', GetLang('AjaxUnableToShipToAddress')."\n\n".$textItemList, true);
					$this->SendXMLHeader();
					$this->SendXMLResponse($tags);
					exit;
				}

				if(!$GLOBALS['HideAddressLine']) {
					$address = $orderShippingAddresses[$addressId];
					$addressLine = array(
					$address['shipfirstname'].' '.$address['shiplastname'],
					$address['shipcompany'],
					$address['shipaddress1'],
					$address['shipaddress2'],
					$address['shipcity'],
					$address['shipstate'],
					$address['shipzip'],
					$address['shipcountry']
					);

					// Please see self::GenerateShippingSelect below.
					$addressLine = array_filter($addressLine, array($checkout, 'FilterAddressFields'));
					$GLOBALS['AddressLine'] = isc_html_escape(implode(', ', $addressLine));
				}
				else {
					$GLOBALS['AddressLine'] = '';
				}

				// Now build a list of the actual available quotes
				$GLOBALS['ShippingProviders'] = '';
				foreach($shippingInfo['quotes'] as $quoteId => $method) {
					$GLOBALS['ShipperName'] = isc_html_escape($method['description']);
					$GLOBALS['ShippingPrice'] = CurrencyConvertFormatPrice($method['price']);
					$GLOBALS['ShippingQuoteId'] = $quoteId;
					$GLOBALS['ShippingData'] = $GLOBALS['ShippingQuoteId'];

					if(isset($method['transit'])) {
						$hasTransit = true;

						$days = $method['transit'];

						if ($days == 0) {
							$transit = GetLang("SameDay");
						}
						else if ($days == 1) {
							$transit = GetLang('NextDay');
						}
						else {
							$transit = sprintf(GetLang('Days'), $days);
						}

						$GLOBALS['TransitTime'] = $transit;
						$GLOBALS['TransitTime'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('CartShippingTransitTime');
					}
					else {
						$GLOBALS['TransitTime'] = "";
					}
					$GLOBALS['ShippingProviders'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("ExpressCheckoutShippingMethod");
				}

				// Add it to the list
				$GLOBALS['ShippingQuotes'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('ShippingQuote');
				$_SESSION['CHECKOUT']['SHIPPING_QUOTES'][$vendorId][$addressId] = $shippingInfo['quotes'];
			}
		}

		if ($hasTransit) {
			$GLOBALS['DeliveryDisclaimer'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('CartShippingDeliveryDisclaimer');
		}

		$GLOBALS['ExpressCheckoutSelectShippingProviderLabel'] = GetLang('ExpressCheckoutSelectShippingProviderOffer');

		$methodList = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('ExpressCheckoutChooseShipper');

		$tags[] = $this->MakeXMLTag('status', 1);
		$tags[] = $this->MakeXMLTag('providerContents', $methodList, true);
		$this->SendXMLHeader();
		$this->SendXMLResponse($tags);
	}

	private function ExpressRemoveCouponcode() {
		$couponid = $_REQUEST['couponid'];
		$GLOBALS['ISC_CLASS_CART'] = GetClass('ISC_CART');
		$GLOBALS['ISC_CLASS_CART']->api->RemoveCouponCode($couponid);
		$GLOBALS['ISC_CLASS_CART']->api->UpdateCartInformation();
		$GLOBALS['HideCheckoutSuccess'] = '';
		$GLOBALS['CheckoutSuccessMsg'] = GetLang('CouponRemovedFromCart');

		$GLOBALS['ISC_CLASS_CHECKOUT'] = GetClass('ISC_CHECKOUT');
		$confirmation = $GLOBALS['ISC_CLASS_CHECKOUT']->GenerateExpressCheckoutConfirmation();
		$tags[] = $this->MakeXMLTag('status', 1);
		$tags[] = $this->MakeXMLTag('confirmationContents', $confirmation, true);
		$this->SendXMLHeader();
		$this->SendXMLResponse($tags);
		exit;
	}
	
	// johnny add
	private function checkCustomerEmail(){
		$email = trim($_REQUEST['email']);
		$query = "SELECT count(*) from [|PREFIX|]customers WHERE isguest = 0 AND custconemail = '".$email."'";
		$count = $GLOBALS['ISC_CLASS_DB']->FetchOne($GLOBALS['ISC_CLASS_DB']->Query($query));
		if($count == 0){
			echo 1;
		}else{
			echo 0;
		}
		exit;
	}
	
	// alandy add
	private function checkproduct(){
		$return_data = array();
		$productid = (int)trim($_REQUEST['productid']);
		
		//if not all to purchase product,then stop customer to buy!
		$prodallowpurchases = (int)$this->get_product_prodallowpurchases($productid);
		$return_data['CartURL'] = NewCartLink($productid,1);
		if($prodallowpurchases == 0){
			$return_data['prodallowpurchase'] = "Sorry, this product is not for sale now.";
		}else{
			$return_data = $this->CheckProductAttribute($productid);
			
		}
		
		echo json_encode($return_data);
		exit;
	}
	
	function get_product_prodallowpurchases($productid=0){
		$result = 0 ;
		$sql = "select prodallowpurchases from [|PREFIX|]products where productid=".$productid;
		
		$query = $GLOBALS['ISC_CLASS_DB']->Query($sql);
		$result = $GLOBALS['ISC_CLASS_DB']->Fetch($query);
		
		return $result['prodallowpurchases'];
	}
	
	private function get_product_attribute($productid=0){

		$sql = "select p.prodname as prodname,b.brandname as brandname,s.seriesname as seriesname
			from [|PREFIX|]products p 
			left join  [|PREFIX|]brands b on p.prodbrandid = b.brandid
			left join  [|PREFIX|]brand_series s on p.brandseriesid = s.seriesid
			where p.productid = ".$productid;
		$query = $GLOBALS['ISC_CLASS_DB']->Query($sql);
		$result = $GLOBALS['ISC_CLASS_DB']->Fetch($query);
		return $result;
	}
	
	private function get_product_importVariation($productid=0,$where = ''){
		$result = array();
		if(!empty($where)){
			$where = " and ".$where;
		}
		$sql = "select prodstartyear,prodendyear,prodmodel,prodsubmodel,prodmake
			from [|PREFIX|]import_variations
			where productid = ".$productid.
			$where;
		$query = $GLOBALS['ISC_CLASS_DB']->Query($sql);
		while($rs = $GLOBALS['ISC_CLASS_DB']->Fetch($query)){
			$result[] = $rs;
		}
		
		return $result;
	}
	
	public function getCategoryNameByProductid($productid){
		$sql = "select 	categoryid from [|PREFIX|]categoryassociations where productid=	".$productid;
		$query = $GLOBALS['ISC_CLASS_DB']->Query($sql);
		
		while($rs = $GLOBALS['ISC_CLASS_DB']->Fetch($query)){
			$sql = "select catname,	catparentid from [|PREFIX|]categories where categoryid=".$rs['categoryid'];
			$query = $GLOBALS['ISC_CLASS_DB']->Query($sql);
			
			while($col = $GLOBALS['ISC_CLASS_DB']->Fetch($query)){
				if($col['catparentid'] == 0){
					return $col['catname'];
				}else{
					$sql = "select catname from [|PREFIX|]categories where categoryid=".$col['catparentid'];
					$query = $GLOBALS['ISC_CLASS_DB']->Query($sql);
					
					while($subcol = $GLOBALS['ISC_CLASS_DB']->Fetch($query)){
						
						return $subcol['catname'];
					}
				}
			}
		}
		return false;
	}
	
	public function getCategorySearchLinkByProductid($productid){
		$catgorySearchLink = '';
		$sql = "select 	categoryid from [|PREFIX|]categoryassociations where productid=	".$productid;
		$query = $GLOBALS['ISC_CLASS_DB']->Query($sql);

		while($rs = $GLOBALS['ISC_CLASS_DB']->Fetch($query)){
			$sql = "select catname,	catparentid from [|PREFIX|]categories where categoryid=".$rs['categoryid'];
			$query = $GLOBALS['ISC_CLASS_DB']->Query($sql);
				
			while($col = $GLOBALS['ISC_CLASS_DB']->Fetch($query)){
				if($col['catparentid'] == 0){
					$catgorySearchLink = MakeURLSafe($col['catname']);
				}else{
					$sql = "select catname from [|PREFIX|]categories where categoryid=".$col['catparentid'];
					$query = $GLOBALS['ISC_CLASS_DB']->Query($sql);
						
					while($pcol = $GLOBALS['ISC_CLASS_DB']->Fetch($query)){

						$catgorySearchLink = MakeURLSafe($pcol['catname']).'/subcategory/'.MakeURLSafe($col['catname']);
					}
				}
			}
		}
		return $catgorySearchLink;
	}
	/*
	// alandy_2011-12-21 add.
	 * return:productid#prodname#brandname#seriesname#
	 */
	private function CheckProductAttribute($productid=0){
		//first compare cookie YMM WITH product YMM.
		$data = array();
		$tmp = array();
		$catuniversal = 0;
		$query_string = "";
		$search_string = "";
		$search_prefix = $GLOBALS['ShopPathNormal'].'/';
		$year = "";
		$make = "";
		$model = "";
		$product_string = " productid = ".$productid;
		$url = $_SERVER['REQUEST_URI'];
		$url = ltrim($url,'/');
		$url_arr = explode("/", $url);
		$catname_link = $GLOBALS['ShopPathNormal'];
		$data['showApplication'] = false;
		
		//fetch product attribute.
		$result = $this->get_product_attribute($productid);
		//fetch product catgory name.
		$catname= $this->getCategoryNameByProductid($productid);
		$categorySearchLink = $this->getCategorySearchLinkByProductid($productid);
		
		if($catname){
			$data['categoryname'] = $catname;
			$data['catname'] = MakeURLSafe($catname);
			$catname_link .= '/'.$data['catname'];
			//$data['catname_link'] = $GLOBALS['ShopPathNormal'].'/'.$data['catname'];
		}
		
		if($categorySearchLink){
			//join category search.ex:categoryname/subcategory/subcategoryname
			$search_prefix .= $categorySearchLink;
		}
		
		$data['cartURL'] = NewCartLink($productid,1);
		$data['productid'] = $productid;
		$data['popup'] = '';
		
		//Firstly,fetch this product attibute.
		if(!empty($result)){

			$data['prodname'] = $result['prodname'];
			$data['brandname'] = $result['brandname'];
			$data['seriesname'] = $result['seriesname'];
				
			$search_string .= "/brand/".MakeURLSafe($result['brandname']);
			$search_string .= "/series/".MakeURLSafe($result['seriesname']);

		}else{
			$data['prodname'] = '';
			$data['brandname'] = '';
			$data['seriesname'] = '';
		}
        //search prefix.
		if(!empty($search_string)){
			$search_prefix .= $search_string;
			
		}
		$data['search_prefix'] = $search_prefix;
		
		//fetch cookie year.
		if(isset($_COOKIE['last_search_selection']['year'])){
			$year = $_COOKIE['last_search_selection']['year'];
			if($year != 'ALL' && (int)$year > 1950){
				$query_string .= " and prodstartyear <= '".$year."' and prodendyear >= '".$year."'";
				$search_string .= "/year/".$year;
				$catname_link .= "/year/".$year;
			}
		}
		
		//fetch cookie make.
		if(isset($_COOKIE['last_search_selection']['make'])){
			$make = $_COOKIE['last_search_selection']['make'];
			if($make != 'NON-SPEC VEHICLE' && !empty($make)){
				$query_string .= " and prodmake = '".$make."'";
				$search_string .= "/make/".$make;
				$catname_link .= "/make/".$make;
			}
		}
		
		//fetch cookie model.
		if(isset($_COOKIE['last_search_selection']['model'])){
			$model = $_COOKIE['last_search_selection']['model'];
			if($model != 'ALL' && !empty($model)){
				$query_string .= " and prodmodel = '".$model."'";
				$search_string .= "/model/".$model;
				$catname_link .= "/model/".$model;
			}
		}
		
		if($year && $make && $model){
			$data['detailimg'] = 1;
		}
		
		$data['catname_link'] = $catname_link;
		
		if(!$year != 'ALL' && (int)($year > 1950)){
			$data['year'] = $year;
			
		}
	  
		if($make != 'NON-SPEC VEHICLE' && !empty($make)){
			$data['make'] = $make;
		}
	  
		if($model != 'ALL' && !empty($model)){
			$data['model'] = $model;
		}
		//return ymm selecter.
		$impv = $this->get_product_importVariation($productid);
		
		if(!empty($impv)){
			foreach($impv as $row){
				
				if($row['prodstartyear'] > 0){
					$tmp['prodstartyear'][] = $row['prodstartyear'];
				}

				if($row['prodendyear'] > 0){
					$tmp['prodendyear'][] = $row['prodendyear'];
				}
				
				if($row['prodmake'] != 'ALL' && !empty($row['prodmake'])){
					$tmp['prodmake'][] = $row['prodmake'];
				}
				
				if($row['prodmodel'] != 'ALL' && !empty($row['prodmodel'])){
					$tmp['prodmodel'][] = $row['prodmodel'];
				}
				
				//catuniversial.
				if($row['prodstartyear'] == 'All' || $row['prodendyear'] == 'All' || $row['prodmake'] == 'NON-SPEC VEHICLE' || $row['prodmodel'] == 'All'){
					$catuniversal = 1;
					break;
				}
			}
			
						
			if($catuniversal == 0){
				//alandy_2012-3-6 modify.
				if(isset($tmp['prodstartyear']) && !empty($tmp['prodstartyear'])){
					$tmp['prodstartyear'] = min(array_unique($tmp['prodstartyear']));
				}else{
					$tmp['prodstartyear'] = 0;
				}
				
				if(isset($tmp['prodendyear']) && !empty($tmp['prodendyear'])){
					$tmp['prodendyear'] = max(array_unique($tmp['prodendyear']));
				}else{
					$tmp['prodendyear'] = 0;
				}
				
				//auto select model by year+make.
				//2012-3-19 add.
				 if(!empty($year) && !empty($make)){
				 $where = "prodstartyear <='".$year."' and prodendyear >='".$year."' and prodmake='".$make."' ";

				 	$ymm = $this->get_product_importVariation($productid,$where);
				 	if(!empty($ymm)){
						unset($tmp['prodmodel']);
						foreach($ymm as $row){
							$tmp['prodmodel'][] = $row['prodmodel'];
						}
					}
				}
				
				$tmp['prodmake'] = array_unique($tmp['prodmake']);
				$tmp['prodmodel'] = array_unique($tmp['prodmodel']);
				sort($tmp['prodmake']);
				sort($tmp['prodmodel']);

				$data['year_option'][0] = "<option value=''>--select year--</option>";
				for($i=$tmp['prodendyear'];$i>=$tmp['prodstartyear'];$i--){
					$selected = "";
					if($i == $year) $selected = "selected";
					$data['year_option'][] = "<option value='".$i."' ".$selected.">".$i."</option>";

				}
					
				$data['make_option'][0] = "<option value=''>--select make--</option>";
				foreach($tmp['prodmake'] as $val){
					$selected = "";
					if(strtolower($val) == strtolower($make)){
						$selected = "selected";
					}
					$data['make_option'][] = "<option value='".MakeURLSafe(strtolower($val))."' $selected >".$val."</option>";

				}
					
				$data['model_option'][0] = "<option value=''>--select model--</option>";
				foreach($tmp['prodmodel'] as $val){
					$selected = "";
					if(strtolower($val) == strtolower($model)){
						$selected = "selected";
					}
					$data['model_option'][] = "<option value='".strtoupper($val)."' ".$selected.">".$val."</option>";

				}
					
			}else{ //universial product.
				$data['year_option'][0] = "<option value=''>ALL</option>";
				$data['make_option'][0] = "<option value=''>NON-SPEC VEHICLE</option>";
				$data['model_option'][0] = "<option value=''>ALL</option>";
			}
			
		}
		
		$GLOBALS['ISC_CLASS_PRODUCT_PQVQ'] = GetClass('ISC_PRODUCT');

		$data['vehicle_research'] = $GLOBALS['ShopPathNormal'].'/'.$search_string;
        
        // dada.wang 2012-03-14 where ymm is complete then show pq/vq
        if (isset($_COOKIE['last_search_selection']) && !empty($_COOKIE['last_search_selection']['make']) && !empty($_COOKIE['last_search_selection']['year']) && !empty($_COOKIE['last_search_selection']['model'])) {
            $data['pqvq'] = $GLOBALS['ISC_CLASS_PRODUCT_PQVQ']->GetProductPQVQHtml($productid,$query_string);
        } else {
            $data['pqvq'] = '';
        }
		
		$data['query_string'] = $query_string;
		//$product_string .= $query_string;

		$subcategory = isset($_SESSION['searchterms']['subcategory']) ? $_SESSION['searchterms']['subcategory'] : '';

		$model = $_COOKIE['last_search_selection']['model'];

		if($catuniversal == 0){ //non catuniversial.
			$data['vehicle'] = trim($year." ".ucwords($make)." ".ucwords($model));
			if(!empty($product_string)){
				//first,look if this product has variations
				$sql = "select id from [|PREFIX|]import_variations where ".$product_string;
				$query=$GLOBALS['ISC_CLASS_DB']->Query($sql);
				$result = $GLOBALS['ISC_CLASS_DB']->Fetch($query);
				if($result && !empty($result)){ //has variations.
					
					//second,look productid+ymm is exist.
					$product_string .= $query_string;
					$sql = "select id from [|PREFIX|]import_variations where ".$product_string;
						
					$query=$GLOBALS['ISC_CLASS_DB']->Query($sql);
					$result = $GLOBALS['ISC_CLASS_DB']->Fetch($query);
						
					if($result && !empty($result)){
						if(empty($year) || empty($make) || empty($model)){
							//ymm not complete.
							$data['popup'] = "2";
						}else{
							if(empty($qpvq_search)){
								$data['popup'] = '4';
							}
						}

					}else{
						//Scenario 1: not match product attribute.
						$data['popup'] = "1";
					}
				}else{
					$data['ymmisselect'] = '1';
					unset($data['popup']);
				}
					
			}else{
				//return '';
			}
		}else{
			$data['popup'] = '4';
			$data['vehicle'] = "This is a Universal Part and fits all vehicles."; //KATE CHANGE: "Universal Vehicle.";
		}
		
		//if product don't have ymm or  was catuniversal product,didn't show application dialog.
		if(!empty($impv) && $catuniversal == 0){
			$data['showApplication'] = true;
		}
		return $data;
	}
    
    public static function getProductPQVQ($productId = 0, $year = 0, $make = '', $model = '') {
        if (isset($_REQUEST['productId'])) {
            $productId = (int)$_REQUEST['productId'];
        }
        if (empty($make) && isset($_REQUEST['make']) && !empty($_REQUEST['make'])) {
            $make = $_REQUEST['make'];
        }
        if (empty($model) && isset($_REQUEST['model']) && !empty($_REQUEST['model'])) {
            $model = $_REQUEST['model'];
        }
        if (!$year && isset($_REQUEST['year']) && !empty($_REQUEST['year'])) {
            $year = (int)$_REQUEST['year'];
        }
        if ($productId) {
            $where = array();
            if ($make) {
                $where[] = sprintf("UPPER(prodmake)='%s'", strtoupper($make));
            }
            if ($model) {
                $where[] = sprintf("UPPER(prodmodel)='%s'", strtoupper($model));
            }
            if ($year) {
                $where[] = sprintf("(prodstartyear <= %d AND prodendyear >= %d)", $year, $year);
            }
            if (count($where) > 2) {
                return ISC_PRODUCT::GetProductPQVQHtml($productId, !empty($where) ? ' AND ' . implode(' AND ', $where) : '');
            }
        }
    }

}

?>
