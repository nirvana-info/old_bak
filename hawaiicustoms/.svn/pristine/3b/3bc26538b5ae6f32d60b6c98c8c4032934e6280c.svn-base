<?php

	class ISC_CUSTOMER
	{
		public function HandlePage()
		{
			$action = "";

			if (count($GLOBALS['PathInfo']) > 0 ){
				if (isset ($GLOBALS['PathInfo'][1])) {
					$_REQUEST['action'] = $GLOBALS['PathInfo'][1];
				}
				else
				{
					$_REQUEST['action'] = $GLOBALS['PathInfo'][0];
				}
			}

			if (isset($_REQUEST['action'])) {
				$action = isc_strtolower($_REQUEST['action']);
			}

			switch ($action)
			{
				case "change_password": {
					$this->SaveNewPassword();
					break;
				}
				case "send_password_email": {
					$this->SendPasswordEmail();
					break;
				}
				case "reset_password": {
					$this->ResetPassword();
					break;
				}
				case "check_login": {
					$this->CheckLogin();
					break;
				}
				case "save_new_account": {
					$this->CreateAccountStep2();
					break;
				}
				case "create_account": {
					$this->CreateAccountStep1();
					break;
				}
				case "logout": {
					$this->Logout();
					break;
				}
				default: {
					$this->ShowLoginPage();
				}
			}
		}
		
		//zcs=>
		public function doLoginFailed($customerid = 0, $currentFails = 0){
			//Login failed, log times
			$limit = intval(GetConfig('LimitCustomerLoginTimes'));
			if($limit == 0){
				return true;//do nothing
			}
			if(++$currentFails >= $limit){
				//clear fail times & lock this user
				$updated_customer = array(
					'fails' => 0,
					'status' => 0,
				);
				$GLOBALS['ISC_CLASS_DB']->UpdateQuery("customers", $updated_customer, "customerid='".$GLOBALS['ISC_CLASS_DB']->Quote($customerid)."'");
			}else{
				//save this new fail times
				$updated_customer = array(
					'fails' => $currentFails,
				);
				$GLOBALS['ISC_CLASS_DB']->UpdateQuery("customers", $updated_customer, "customerid='".$GLOBALS['ISC_CLASS_DB']->Quote($customerid)."'");
			}
		}
		public function clearFails($customerid = 0){
			$GLOBALS['ISC_CLASS_DB']->UpdateQuery("customers", array('fails' => 0), "customerid='".$GLOBALS['ISC_CLASS_DB']->Quote($customerid)."'");
		}
		//<=zcs

		/**
		 * Attempt to log the customer in to the store.
		 *
		 * @param boolean Set to true to not show any error messages but return true or false depending on if the login was successful or not.
		 * @return boolean True if the login was successful.
		 */
		public function CheckLogin($silent=false)
		{
			if (isset($_POST['login_email']) && isset($_POST['login_pass'])) {
				$email = $GLOBALS['ISC_CLASS_DB']->Quote($_POST['login_email']);
				$pass = $GLOBALS['ISC_CLASS_DB']->Quote($_POST['login_pass']);
				//zcs= add "status , fails"
				$query = sprintf("select customerid, custpassword, customertoken, custimportpassword, status, fails from [|PREFIX|]customers where isguest = 0 AND custconemail='%s'", $GLOBALS['ISC_CLASS_DB']->Quote($email), $GLOBALS['ISC_CLASS_DB']->Quote($pass));
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				if ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					//zcs=>
					if(intval($row['status']) == 0){
						//locked user
						if(!$silent){
							$this->ShowLoginPage("LockedCustomer", 1);
						}
						return -1;//FLAG: locked!
					}
					//<=zcs

					// Was this an imported password?
					if ($row['custimportpassword'] != '' && $row['custpassword'] != md5($_POST['login_pass'])) {

						if (ValidImportPassword($_POST['login_pass'], $row['custimportpassword'])) {
							// Valid login from an import password. We now store the Interspire Shopping Cart version of the password
							$updated_customer = array(
								"custpassword" => md5($_POST['login_pass']),
								"custimportpassword" => ""
							);
							$GLOBALS['ISC_CLASS_DB']->UpdateQuery("customers", $updated_customer, "customerid='".$GLOBALS['ISC_CLASS_DB']->Quote($row['customerid'])."'");
						}
						else {
							$this->doLoginFailed($row['customerid'], $row['fails']);//zcs=increase fail times
							unset($row['customerid']);
						}
					}
					// Normal user, passwords don't match
					else if ($row['custpassword'] != md5($_POST['login_pass'])) {
						$this->doLoginFailed($row['customerid'], $row['fails']);//zcs=increase fail times
						unset($row['customerid']);
					}


					// Login was OK, set the token as a cookie
					if (isset($row['customerid']) && $row['customerid'] != 0) {
						//zcs=>clear last fails
						if($row['fails'] > 0){
							$this->clearFails($row['customerid']);
						}
						//<=zcs
						return $this->LoginCustomer($row, $silent);
					}
				}

				// Bad login credentials
				if($silent == true) {

					return false;
				}
				else {
					$this->ShowLoginPage("BadLoginDetails", 1);
				}

			}
			else {
				ob_end_clean();
				header(sprintf("Location: %s/login.php", $GLOBALS['ShopPath']));
				die();
			}
		}

		/**
		 * Login a customer based upon either their customer ID or record array
		 *
		 * @param mixed Either the customer's ID or record array.
		 * @param boolean Set to true to not show any error messages but return true or false depending on if the login was successful or not.
		 * @return boolean True if the login was successful.
		 */
		public function LoginCustomerById($ClientRecord, $silent=false)
		{
			if (!isId($ClientRecord) && !is_array($ClientRecord)) {
				return false;
			}

			return $this->LoginCustomer($ClientRecord, $silent);
		}

		/**
		 * Private function used for loggin in a customer
		 *
		 * @param mixed Either the customer's ID or record array.
		 * @param boolean Set to true to not show any error messages but return true or false depending on if the login was successful or not.
		 * @return boolean True if the login was successful.
		 */
		private function LoginCustomer($ClientRecord, $silent=false)
		{
			if (isId($ClientRecord)) {
				$ClientRecord = $GLOBALS['ISC_CLASS_DB']->Fetch($GLOBALS['ISC_CLASS_DB']->Query("SELECT * FROM [|PREFIX|]customers WHERE customerid=" . (int)$ClientRecord));
			}

			if (!is_array($ClientRecord)) {
				return false;
			}

			@ob_end_clean();

			if(!trim($ClientRecord['customertoken'])) {
				$custToken = GenerateCustomerToken();
				$updated_customer_token = array(
					"customertoken" => $custToken
				);
				$GLOBALS['ISC_CLASS_DB']->UpdateQuery("customers", $updated_customer_token, "customerid='".$GLOBALS['ISC_CLASS_DB']->Quote($ClientRecord['customerid'])."'");
				$ClientRecord['customertoken'] = $custToken;
			}


            /* Added to know the browser Baskaran */
            $agent = $_SERVER['HTTP_USER_AGENT'];
            $ub = '';
            if(preg_match('/MSIE/i',$agent))
            {
                $ub = "ie";
            }
            elseif(preg_match('/Firefox/i',$agent))
            {
                $ub = "firefox";
            }
            else if(preg_match('/Chrome/i',$agent))
            {
            	$ub = "chrome";
            }
            else
            {
                $ub = "ie";
            }              
            
            # To set the expire date for a cookie depending upon the browser -- Baskaran
            
            $expiredate = '';
            if($ub == 'ie')
            {
                $expiredate = 0;
            }
            else if($ub == "chrome")
            {
            	 $expiredate = 0;
            }                   
            else
            {
                $expiredate = "";
            } 
            /* Ends here */
                        
//			ISC_SetCookie("SHOP_TOKEN", $ClientRecord['customertoken'], time()+(3600*24*7), true);
            ISC_SetCookie("SHOP_TOKEN", $ClientRecord['customertoken'], 0, true);
            

			// Make the cookie accessible via PHP as well
			$_COOKIE['SHOP_TOKEN'] = $ClientRecord['customertoken'];
			if($silent == true) {
				return true;
			}

			if (isset($_SESSION['LOGIN_REDIR']) && $_SESSION['LOGIN_REDIR'] != '') {
				// Take them to the page they wanted
				$page = $_SESSION['LOGIN_REDIR'];
				unset($_SESSION['LOGIN_REDIR']);
				header(sprintf("Location: %s", $page));
			}
			else {
				// Take them to the "My Account" page
				header(sprintf("Location: %s/account.php", $GLOBALS['ShopPathNormal']));
			}

			die();
		}

		/**
		*	Does an account the this email address already exist?
		*/
		public function AccountWithEmailAlreadyExists($Email, $customerId=0, $isguest=0)
		{
			// johnny add ---- filter guest account
			$query = "SELECT COUNT(custconemail) AS num
						FROM [|PREFIX|]customers
						WHERE isguest = $isguest AND LOWER(custconemail)='" . $GLOBALS['ISC_CLASS_DB']->Quote(isc_strtolower($Email)) . "'";

			if (isId($customerId)) {
				$query .= " AND customerid != " . (int)$customerId;
			}

			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

			if ($row['num'] == 0) {
				return false;
			} else {
				return true;
			}
		}

		/**
		 * Parse out the phone number
		 *
		 * Method will parse out all the numbers within a string
		 *
		 * @access public
		 * @param string $number The phone number to validate
		 * @return string The numbers within a string
		 */
		public function ParsePhoneNumber($number)
		{
			if (preg_match_all("/[0-9]+/", $number, $matches)) {
				return implode("", $matches[0]);
			}

			return "";
		}

		/**
		 * Validate the phone number
		 *
		 * Method will validate the phone number.
		 *
		 * @access public
		 * @param string $number The phone number to validate
		 * @return bool true if the phone number is valid, false otherwise
		 */
		public function ValidatePhoneNumber($number)
		{
			return strlen($this->parsePhoneNumber($number)) >= 3;
		}

		private function CreateAccountStep2()
		{
			$savedataDetails = array(

				/**
				 * Customer Details
				 */
				FORMFIELDS_FORM_ACCOUNT => array(
					'EmailAddress' => 'email',
					'Password' => 'password',
					'ConfirmPassword' => 'confirmpassword',
					'FirstName' => 'firstname',
					'LastName' => 'lastname',
					'CompanyName' => 'company',
					'Phone' => 'phone',
				),

				/**
				 * Shipping Details
				 */
				FORMFIELDS_FORM_ADDRESS => array(
					'FirstName' => 'shipfirstname',
					'LastName' => 'shiplastname',
					'CompanyName' => 'shipcompany',
					'AddressLine1' => 'shipaddress1',
					'AddressLine2' => 'shipaddress2',
					'City' => 'shipcity',
					'State' => 'shipstate',
					'Country' => 'shipcountry',
					'Zip' => 'shipzip',
					'Phone' => 'shipphone',
					'BuildingType' => 'shipdestination'
				)
			);

			/**
			 * Validate and map submitted field data in one loop
			 */
			$fields = $GLOBALS['ISC_CLASS_FORM']->getFormFields(FORMFIELDS_FORM_ACCOUNT, true);
			$fields += $GLOBALS['ISC_CLASS_FORM']->getFormFields(FORMFIELDS_FORM_ADDRESS, true);
			$customerData = array();
			$shippingData = array();
			$password = '';
			$confirmPassword = '';

			foreach (array_keys($fields) as $fieldId) {

				/**
				 * Validate
				 */
				$errmsg = '';
				if (!$fields[$fieldId]->runValidation($errmsg)) {
					return $this->CreateAccountStep1($errmsg);
				}

				foreach ($savedataDetails as $type => $map) {

					/**
					 * Are we in the customer section or the shipping?
					 */
					if ($type == FORMFIELDS_FORM_ACCOUNT) {
						$referencedData =& $customerData;
					} else {
						$referencedData =& $shippingData;
					}

					/**
					 * We're only interested in the private custom fields here
					 */
					if (array_key_exists($fields[$fieldId]->record['formfieldprivateid'], $map)) {
						$label = $map[$fields[$fieldId]->record['formfieldprivateid']];
						$referencedData[$label] = $fields[$fieldId]->getValue();

						/**
						 * Store the values somewhere if this is a apssword/confirm-password field
						 */
						if ($fields[$fieldId]->record['formfieldprivateid'] == 'Password') {
							$password = $referencedData[$label];
						} else if ($fields[$fieldId]->record['formfieldprivateid'] == 'ConfirmPassword') {
							$confirmPassword = $referencedData[$label];
						}
					}
				}
			}

			/**
			 * Clean up some of the data
			 */
			if (isset($shippingData['shipstate'])) {
				$state = GetStateInfoByName($shippingData['shipstate']);
				if ($state) {
					$shippingData['shipstateid'] = $state['stateid'];
				} else {
					$shippingData['shipstateid'] = '';
				}
			}
			if (isset($shippingData['shipcountry'])) {
				$countryId = GetCountryByName($shippingData['shipcountry']);
				if (isId($countryId)) {
					$shippingData['shipcountryid'] = $countryId;
				} else {
					$shippingData['shipcountryid'] = '';
				}
			}
			if (isset($shippingData['shipdestination'])) {
				$data = $fields[$fieldId]->getValue();
				if (isc_strtolower($shippingData[$label]) == 'house') {
					$shippingData[$label] = 'residential';
				} else {
					$shippingData[$label] = 'commercial';
				}
			}

			$customerData["shipping_address"] = $shippingData;
			
			$captcha = '';
			if(isset($_POST['captcha'])) {
				$captcha = $_POST['captcha'];
			}
			$captcha_check = true;
			// Do we need to check captcha?
			if(GetConfig('CaptchaEnabled')) {
				$GLOBALS['ISC_CLASS_CAPTCHA'] = GetClass('ISC_CAPTCHA');
				if(isc_strtolower($captcha) == isc_strtolower($GLOBALS['ISC_CLASS_CAPTCHA']->LoadSecret())) {
					// Captcha validation succeeded
					$captcha_check = true;
				}
				else {
					// Captcha validation failed
					$captcha_check = false;
				}
			}
			
			if(!$captcha_check)
			{
				$this->CreateAccountStep1(GetLang("CaptchaCodeError"));
				die();
			}			
			

			// Does an account with this email address already exist?
			if ($this->AccountWithEmailAlreadyExists(trim($customerData['email']))) {
				$this->CreateAccountStep1("already_exists");
			}
			// Else is the provided phone number valid?
			else if (!$this->ValidatePhoneNumber($customerData['phone'])) {
				$this->CreateAccountStep1("invalid_number");
			}
			// Else the passwords don't match
			else if ($password !== $confirmPassword) {
				$this->CreateAccountStep1("invalid_passwords");
			}
			else {
				// Create the user account in the database
				$token = GenerateCustomerToken();
				/* Added for to get customer group id, and save for new customer -- Baskaran */
                $result = $GLOBALS['ISC_CLASS_DB']->Query("select customergroupid from [|PREFIX|]customer_groups where isdefault = '1'");
                $groupid = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
                if($GLOBALS['ISC_CLASS_DB']->CountResult($result) > '0') {
                    $customerData['customergroupid'] = $groupid['customergroupid'];
                }
                else {
                    $customerData['customergroupid'] = 0;
                }
                /* code ends */
				$customerData['token'] = $token;
				$_SESSION['FROM_REG'] = 0;
				$customerId = $this->CreateCustomerAccount($customerData);
				
				/* delete the guest account with the same email
				if ($this->AccountWithEmailAlreadyExists(trim($customerData['email']), 0, 1)) {
					$cusquery = "SELECT customerid
						FROM [|PREFIX|]customers
						WHERE isguest = 1 AND LOWER(custconemail)='" . $GLOBALS['ISC_CLASS_DB']->Quote(isc_strtolower(trim($customerData['email']))) . "'";
					$cusresult = $GLOBALS['ISC_CLASS_DB']->Query($cusquery);
					$cusrow = $GLOBALS['ISC_CLASS_DB']->Fetch($cusresult);
					$custId = $cusrow['customerid'];
					$entity = new ISC_ENTITY_CUSTOMER();
					$entity->delete($custId);
				}*/
				
				if (isId($customerId)) {

					// The account was created, let's log them in automatically
					$this->LoginCustomerById($customerId, true);

					// Show the "thank you for registering" page
					if (isset($_SESSION['LOGIN_REDIR']) && $_SESSION['LOGIN_REDIR'] != '') {
						$GLOBALS['Continue'] = GetLang('ClickHereToContinue');
						$GLOBALS['ContinueLink'] = urldecode($_SESSION['LOGIN_REDIR']);
						$_SESSION['FROM_REG'] = 1;
					}
					// User has just registered (not in the middle of an order - click here to visit your account)
					else {
						$GLOBALS['Continue'] = GetLang('ClickHereContinueShopping');
						$GLOBALS['ContinueLink'] = $GLOBALS['ShopPath'];
					}
					$GLOBALS['ISC_LANG']['CreateAccountThanksIntro'] = sprintf(GetLang('CreateAccountThanksIntro'), $GLOBALS['StoreName'], isc_html_escape($customerData['email']));
					$GLOBALS['ISC_CLASS_TEMPLATE']->SetPageTitle(GetConfig('StoreName') . " - " . GetLang('CreateAccountThanks'));

					if (!isset($_SESSION['IsCheckingOut'])) {
						// Take them to the default thank you page if they aren't checking out
						$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("createaccount_thanks");
						$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
					}
					else {

						/**
						 * This is an order so take them straight to the shipping provider page. Also save the
						 * shipping address here as we will need the custom fields
						 */
						if (isset($_SESSION['CHECKOUT']['IS_SPLIT_SHIPPING']) && $_SESSION['CHECKOUT']['IS_SPLIT_SHIPPING'] == true) {
							header("Location: " . $GLOBALS['ShopPath'] . "/checkout.php?action=multiple");
						}
						else {
							header("Location: " . $GLOBALS['ShopPath'] . "/checkout.php");
						}

					}

					die();
				}
				else {
					// Couldn't create the account
					$this->CreateAccountStep1("database_error");
				}
			}
		}

		/**
		 * Actually create a customer account in the database.
		 *
		 * @param array An array of details about the customer.
		 * @param boolean True if a welcome email should be sent out to the customer.
		 * @param boolean True if this account is being created invisibily for the customer via the checkout.
		 * @return int The customer ID if successful.
		 */
		public function CreateCustomerAccount($Customer, $Email=true, $checkoutAccount=false)
		{
			/**
			 * If we are successful then save all the non-private custom fields. Only if we
			 * are NOT a single page checkout account
			 */
			if(!isset($_SESSION['CHECKOUT']['CREATE_ACCOUNT']) || GetConfig('CheckoutType') !== 'single') {
				$accountFormSessionId = $GLOBALS['ISC_CLASS_FORM']->saveFormSession(FORMFIELDS_FORM_ACCOUNT);

				if (isId($accountFormSessionId)) {
					$Customer['custformsessionid'] = $accountFormSessionId;
				}

				if (isset($Customer['shipping_address'])) {
					$shippingFormSessionId = $GLOBALS['ISC_CLASS_FORM']->saveFormSession(FORMFIELDS_FORM_ADDRESS);

					if (isId($shippingFormSessionId)) {
						$Customer['shipping_address']['shipformsessionid'] = $shippingFormSessionId;
					}
				}
			}

			$entity = new ISC_ENTITY_CUSTOMER();
			$customerId = $entity->add($Customer);

			if (!isId($customerId)) {
				return;
			}

			// Do we want to email this custome a copy of their registration details?
			if ($Email == true) {
				$emailTemplate = FetchEmailTemplateParser();

				$GLOBALS['FirstName'] = isc_html_escape($Customer['firstname']);
				$GLOBALS['Email'] = isc_html_escape($Customer['email']);
				$GLOBALS['Password'] = isc_html_escape($Customer['password']);

				if($checkoutAccount) {
					$GLOBALS['ISC_LANG']['ThanksForRegisteringAtIntro'] = sprintf(GetLang('CheckoutAccountCreatedIntro'), $GLOBALS['StoreName']);
					$subject = GetLang('CheckoutAccountCreatedSubject');
					$GLOBALS['ISC_LANG']['THanksForRegisteringAt'] = GetLang('CheckoutAccountCreatedSubject');
				}
				else {
					$GLOBALS['ISC_LANG']['ThanksForRegisteringAtIntro'] = sprintf(GetLang('ThanksForRegisteringAtIntro'), $GLOBALS['StoreName']);
					$subject = GetLang('ThanksForRegisteringAt');
				}
				$GLOBALS['ISC_LANG']['ThanksForRegisteringEmailLogin'] = sprintf(GetLang('ThanksForRegisteringEmailLogin'), $GLOBALS['ShopPathSSL']."/account.php", $GLOBALS['ShopPathSSL']."/account.php", $GLOBALS['ShopPathSSL']."/account.php");

				$emailTemplate->SetTemplate("createaccount_email");
				$message = $emailTemplate->ParseTemplate(true);

				// Create a new email API object to send the email
				$store_name = GetConfig('StoreName');

				require_once(ISC_BASE_PATH . "/lib/email.php");
				$obj_email = GetEmailClass();
				$obj_email->Set('CharSet', GetConfig('CharacterSet'));
				$obj_email->From(GetConfig('OrderEmail'), $store_name);
				$obj_email->Set("Subject", $subject . $store_name);
				$obj_email->AddBody("html", $message);
				$obj_email->AddRecipient($Customer['email'], "", "h");
				$email_result = $obj_email->Send();
			}

			return $customerId;
		}

		/**
		*	Show the create account form. If $AlreadyExists is true then
		*	they've tried to create an account with an existing email address
		*/
		private function CreateAccountStep1($Error = "")
		{
			$fillPostedValues = false;
			if ($Error != "") {
				$fillPostedValues = true;
				$GLOBALS['HideCreateAccountIntroMessage'] = "none";
			}

			$fields = $GLOBALS['ISC_CLASS_FORM']->getFormFields(FORMFIELDS_FORM_ACCOUNT, $fillPostedValues);
			$fields += $GLOBALS['ISC_CLASS_FORM']->getFormFields(FORMFIELDS_FORM_ADDRESS, $fillPostedValues);

			/**
			 * Get any selected country and state
			 */
			$countryName = GetConfig('CompanyCountry');
			$stateFieldId = 0;
			foreach (array_keys($fields) as $fieldId) {
				if (isc_strtolower($fields[$fieldId]->record['formfieldprivateid']) == 'state') {
					$stateFieldId = $fieldId;
				} else if (isc_strtolower($fields[$fieldId]->record['formfieldprivateid']) == 'country' && $fields[$fieldId]->getValue() !== '') {
					$countryName = $fields[$fieldId]->getValue();
				}
			}

			/**
			 * Compile the fields. Also set the country and state dropdowns while we are here
			 */
			$GLOBALS['CreateAccountEmailPassword'] = '';
			$GLOBALS['CreateAccountDetails'] = '';
			$GLOBALS['CreateAccountAccountFormFieldID'] = FORMFIELDS_FORM_ACCOUNT;
			$GLOBALS['CreateAccountShippingFormFieldID'] = FORMFIELDS_FORM_ADDRESS;

			$compiledFields = null;
			$accountFields = array();
			$shippingFields = array();

			/**
			 * These are used for error reporting
			 */
			$emailAddress = '';
			$phoneNo = '';

			foreach (array_keys($fields) as $fieldId) {
				if (isc_strtolower($fields[$fieldId]->record['formfieldprivateid']) == 'emailaddress') {
					$emailAddress = $fields[$fieldId]->getValue();
				}

				if (isc_strtolower($fields[$fieldId]->record['formfieldprivateid']) == 'phone') {
					$phoneNo = $fields[$fieldId]->getValue();
				}

				if (isc_strtolower($fields[$fieldId]->record['formfieldprivateid']) == 'country') {
					$fields[$fieldId]->setOptions(array_values(GetCountryListAsIdValuePairs()));

					if ($countryName !== '') {
						$fields[$fieldId]->setValue($countryName);
					}

					$fields[$fieldId]->addEventHandler('change', 'FormFieldEvent.SingleSelectPopulateStates', array('countryId' => $fieldId, 'stateId' => $stateFieldId));

				} else if (isc_strtolower($fields[$fieldId]->record['formfieldprivateid']) == 'state' && $countryName !== '') {
					$countryId = GetCountryByName($countryName);
					$stateOptions = GetStateListAsIdValuePairs($countryId);
					if (is_array($stateOptions) && !empty($stateOptions)) {
						$fields[$fieldId]->setOptions($stateOptions);
					}
				}

				/**
				 * We don't want this in the address (its only for single page checkout)
				 */
				if (isc_strtolower($fields[$fieldId]->record['formfieldprivateid']) == 'savethisaddress' || isc_strtolower($fields[$fieldId]->record['formfieldprivateid']) == 'shiptoaddress') {
					continue;
				}

				/**
				 * If this is a password field then remove that 'leave blank' label
				 */
				if ($fields[$fieldId]->getFieldType() == 'password') {
					$fields[$fieldId]->setLeaveBlankLabel(false);
				}

				/**
				 * Separate out the fields
				 */
				if ($fields[$fieldId]->record['formfieldformid'] == FORMFIELDS_FORM_ACCOUNT) {
					$GLOBALS['CreateAccountEmailPassword'] .= $fields[$fieldId]->loadForFrontend();
				} else {
					$GLOBALS['CreateAccountDetails'] .= $fields[$fieldId]->loadForFrontend();
				}
			}

			if ($Error == "already_exists") {
				// The email address is taken, they have to choose another one
				$GLOBALS['ErrorMessage'] = sprintf(GetLang('AccountEmailTaken'), isc_html_escape($emailAddress));
			}
			else if ($Error == "invalid_number") {
				// The phone number is invalid
				$GLOBALS['ErrorMessage'] = sprintf(GetLang('AccountEnterValidPhone'), isc_html_escape($phoneNo));
			}
			else if ($Error == "invalid_passwords") {
				// The passwords do not match
				$GLOBALS['ErrorMessage'] = GetLang('AccountPasswordsDontMatch');
			}
			else if ($Error == "database_error") {
				// A database error occured while creating the account
				$GLOBALS['ErrorMessage'] = GetLang('AccountInternalError');
			}
			else if ($Error !== '') {
				// Some other error while validating the field data. Should already be escaped
				$GLOBALS['ErrorMessage'] = $Error;
			}
			else {
				$GLOBALS['HideCreateAccountErrorMessage'] = "none";
			}

			// Get the id of the customer
			$GLOBALS['ISC_CLASS_CUSTOMER'] = GetClass('ISC_CUSTOMER');
			$customer_id = $GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerId();

			/**
			 * Load up any form field JS event data and any validation lang variables
			 */
			$GLOBALS['FormFieldRequiredJS'] = $GLOBALS['ISC_CLASS_FORM']->buildRequiredJS();
			
			// Is captcha enabled?
			if (GetConfig('CaptchaEnabled') == false) {
				$GLOBALS['HideReviewCaptcha'] = "none";
			}
			else {
				// Generate the captcha image
				$GLOBALS['ISC_CLASS_CAPTCHA'] = GetClass('ISC_CAPTCHA');
				$GLOBALS['ISC_CLASS_CAPTCHA']->CreateSecret();
				$GLOBALS['CaptchaImage'] = $GLOBALS['ISC_CLASS_CAPTCHA']->ShowCaptcha();
			}

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetPageTitle(GetConfig('StoreName') . " - " . GetLang('CreateAccount'));
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("createaccount");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}

		/**
		*	Show the account login page
		*/
		public function ShowLoginPage($Message = "", $MessageStatus = 0, $MessageIsString = false)
		{
			if (isset($_GET['from'])) {
				$Message = "LoginToAccessThatPage";
				$_SESSION['LOGIN_REDIR'] = sprintf("%s/%s", $GLOBALS['ShopPath'], urldecode($_GET['from']));
			}
			else {
				$_SESSION['LOGIN_REDIR'] = '';
			}

			// Do we need to show a message?
			if ($Message != "") {
				if ($MessageIsString) {
					$GLOBALS['LoginMessage'] = $Message;
				} else {
					$GLOBALS['LoginMessage'] = GetLang($Message);
				}
			}
			else {
				// Hide the error box
				$GLOBALS['HideLoginMessage'] = "none";
			}

			// Is it a critical message?
			if($MessageStatus == 1) {
				$GLOBALS['MessageClass'] = "ErrorMessage";
			} else {
				$GLOBALS['MessageClass'] = "SuccessMessage";
			}

			// Show the login page
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetPageTitle(GetConfig('StoreName') . " - " . GetLang('Login'));
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("login");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}

		/**
		*	Show the reset password form
		*/
		private function ResetPassword($Error = "")
		{

			if ($Error == "bad_email") {
				// There's no account with that email address
				$GLOBALS['ErrorMessage'] = sprintf(GetLang('ForgotPasswordBadEmail'), isc_html_escape($_POST['email']));
			}
			else if ($Error == "invalid_link") {
				// The link in the email is invalid
				$GLOBALS['ErrorMessage'] = GetLang('ForgotPasswordInvalidLink');
			}
			else if ($Error == "internal_error") {
				// There was a database error
				$GLOBALS['ErrorMessage'] = GetLang('ForgotPasswordInternalErrror');
			}
			else {
				$GLOBALS['HideForgotPasswordError'] = "none";
			}

			// Show the reset password page
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetPageTitle(GetConfig('StoreName') . " - " . GetLang('ForgotPassword'));
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("forgotpassword");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}

		/**
		*	Send the email to confirm the change
		*/
		private function SendPasswordEmail()
		{
			/*
				Include the email API class
			*/

			if (isset($_POST['email'])) {
				$email = trim($_POST['email']);

				// Does an account with the email address exist?
				if ($this->AccountWithEmailAlreadyExists($email)) {
					// Is the current password right?
					$query = sprintf("select customerid, customertoken from [|PREFIX|]customers where isguest = 0 AND lower(custconemail)='%s'", $GLOBALS['ISC_CLASS_DB']->Quote(isc_strtolower($email)));
					$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

					if ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {

						// The account exists, let's create a new temporary token to be used to verify the email that will be sent
						$customer_id = $row['customerid'];
						$storeRandom = md5(uniqid(mt_rand(), true) . $_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR'] . $_SERVER['REQUEST_TIME']);
						$linkRandom = CustomerHashCreate($storeRandom, $customer_id);
						$UpdatedCustomer = array(
							"customerpasswordresettoken" => $storeRandom,
							"customerpasswordresetemail" => $email,
						);

						if ($GLOBALS['ISC_CLASS_DB']->UpdateQuery("customers", $UpdatedCustomer, "customerid='".$GLOBALS['ISC_CLASS_DB']->Quote($customer_id)."'")) {
							// Send the email
							$data = sprintf("c=%d&t=%s", $customer_id, $linkRandom);
							$link = sprintf("%s/login.php?action=change_password&%s", $GLOBALS['ShopPath'], $data);
							$store_name = GetConfig('StoreName');
							$email_message = sprintf(GetLang('ForgotPassEmailMessage'), $store_name, $link, $link);

							// Create a new email API object to send the email
							require_once(ISC_BASE_PATH . "/lib/email.php");
							$obj_email = GetEmailClass();
							$obj_email->Set('CharSet', GetConfig('CharacterSet'));
							$obj_email->From(GetConfig('OrderEmail'), $store_name);
							$obj_email->Set("Subject", sprintf(GetLang('ForgotPassEmailSubject'), $store_name));
							$obj_email->AddBody("html", $email_message);
							$obj_email->AddRecipient($email, "", "h");
							$email_result = $obj_email->Send();

							// If the email was sent ok, show a confirmation message
							if ($email_result['success']) {
								$this->ShowLoginPage("ForgotPassEmailSent");
							}
							else {
								// Email error
								$this->ResetPassword("internal_error");
							}
						}
						else {
							// Database error
							$this->ResetPassword("internal_error");
						}
					}
					else {
						// Bad password
						$this->ResetPassword("bad_password");
					}
				}
				else {
					// No account with that email address
					$this->ResetPassword("bad_email");
				}
			}
			else {
				$this->ResetPassword();
			}
		}

		/**
		*	Save the new password for the customer's account
		*/
		private function SaveNewPassword()
		{

			if (isset($_GET['c']) && isset($_GET['t'])) {

				$customerId = (int)isc_html_escape($_GET['c']);
				$customerHash = isc_html_escape($_GET['t']);

				$query = "SELECT *
							FROM [|PREFIX|]customers
							WHERE customerid=" . $customerId;
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				$customer = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

				// Can't find them in the database
				if (!isId($customerId) || !$customer) {
					return $this->ResetPassword("invalid_link", 1);
				}

				// Also check to see if our salted string matches this customer
				if (!CustomerHashCheck($customerHash, $customer['customerpasswordresettoken'], $customerId)) {
					return $this->ResetPassword("invalid_link", 1);
				}

				// OK, all the arguments are cool. Now we generate a password for them
				$password = GenerateReadablePassword();

				$updateData = array(
					'custpassword' => md5($password),
					'customerpasswordresettoken' => '',
					'customerpasswordresetemail' => '',
				);

				if ($GLOBALS['ISC_CLASS_DB']->UpdateQuery('customers', $updateData, 'customerid=' . $customerId) === false) {
					return $this->ResetPassword("internal_error", 1);
				}

				// Send the email
				$store_name = GetConfig('StoreName');
				$email_message = sprintf(GetLang('ForgotPasswordEmailConfirmed'), $store_name, $password);

				// Create a new email API object to send the email
				require_once(ISC_BASE_PATH . "/lib/email.php");
				$obj_email = GetEmailClass();
				$obj_email->Set('CharSet', GetConfig('CharacterSet'));
				$obj_email->From(GetConfig('OrderEmail'), $store_name);
				$obj_email->Set("Subject", sprintf(GetLang('ForgotPasswordEmailConfirmedSubject'), $store_name));
				$obj_email->AddBody("html", $email_message);
				$obj_email->AddRecipient($customer['customerpasswordresetemail'], "", "h");
				$email_result = $obj_email->Send();

				if ($email_result['success']) {
					return $this->ShowLoginPage(sprintf(GetLang('ForgotPasswordChanged'), $customer['customerpasswordresetemail']), 0, true);
				} else {
					return $this->ResetPassword("internal_error", 1);
				}
			} else {
				$this->ShowLoginPage();
			}
		}

		/**
		 * Log the current customer out of the store.
		 *
		 * @param boolean Set to true to do a silent logout (not redirect the customer, etc). Defaults to false.
		 */
		public function Logout($silent=false)
		{
			ISC_UnsetCookie("SHOP_TOKEN");
			unset($_COOKIE['SHOP_TOKEN']);

			//alandy modify.
			unset($_SESSION['Haslogin']);

			// If performing a silent logout, just stop here and return
			if($silent == true) {
				return true;
			}

			$GLOBALS['LoginOrLogoutLink'] = "login.php";
			if (strtolower(GetConfig('CustomerFunctionality')) == 'login') {
				$GLOBALS['LoginOrLogoutText'] = sprintf(GetLang('SignIn'), $GLOBALS['ShopPath']);
			} else {
				$GLOBALS['LoginOrLogoutText'] = sprintf(GetLang('SignInOrCreateAccount'), $GLOBALS['ShopPath'], $GLOBALS['ShopPath']);
			}
			$this->ShowLoginPage("LoggedOutSuccessfully");
		}

		/**
		* Get the ID of the customer based on the STORE_TOKEN cookie
		*/
		public function GetCustomerId()
		{
			if (isset($_COOKIE['SHOP_TOKEN'])) {
				$shop_token = $_COOKIE['SHOP_TOKEN'];
				return $this->GetCustomerIdByToken($shop_token);
			}

			return 0;
		}

		/**
		* Fetch all of the information from the customers table for the current customer
		*/
		public function GetCustomerDataByToken($Token="")
		{
			static $customerCache;
			$customer_id = 0;

			if($Token == '' && isset($_COOKIE['SHOP_TOKEN'])) {
				$shop_token = $_COOKIE['SHOP_TOKEN'];
			}
			else {
				$shop_token = $Token;
			}

			if($shop_token=='') {
				return false;
			}

			// Been cached already? Return that
			if(isset($customerCache[$shop_token])) {
				return $customerCache[$shop_token];
			}

			$query = sprintf("select * from [|PREFIX|]customers where customertoken='%s'", $GLOBALS['ISC_CLASS_DB']->Quote($shop_token));
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$customerCache[$shop_token] = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

			return $customerCache[$shop_token];
		}

		/**
		* Get the ID of the customer based on the token
		*/
		public function GetCustomerIdByToken($Token)
		{
			$customer = $this->GetCustomerDataByToken($Token);
			if(is_array($customer)) {
				return $customer['customerid'];
			}

			return 0;
		}

		/**
		*	Return a list of shipping addresses for this customer as an arary
		*/
		public function GetCustomerShippingAddresses($customerId=null)
		{
			$addresses = array();

			if(is_null($customerId)) {
				$customerId = $this->GetCustomerId();
			}

			if(!$customerId) {
				return array();
			}

			$query = "
				SELECT *
				FROM [|PREFIX|]shipping_addresses
				WHERE shipcustomerid='".(int)$customerId."'
				ORDER BY shiplastused DESC
			";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$row['shipfullname'] = trim($row['shipfirstname'].' '.$row['shiplastname']);
				$addresses[$row['shipid']] = $row;
			}

			return $addresses;
		}

		/**
		*	Return the customer's email address
		*/
		public function GetCustomerEmailAddress()
		{
			$email = "";
			$customer_id = $this->GetCustomerId();

			if ($customer_id > 0) {
				$query = sprintf("select custconemail from [|PREFIX|]customers where customerid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($customer_id));
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

				if ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					$email = $row['custconemail'];
				}
			}

			return $email;
		}

		/**
		*	Return an entire profile for a customer based on an id. If no ID specified, fetches the details for the current customer.
		*/
		public function GetCustomerInfo($customer_id=0)
		{
			if ($customer_id == 0) {
				$customer_id = $this->GetCustomerId();
			}

			if ($customer_id > 0) {
				$query = sprintf("select * from [|PREFIX|]customers where customerid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($customer_id));
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				if ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					return $row;
				}
			}
			return false;
		}

		/**
		 * Return the amount of store credit a particular customer has.
		 *
		 * @param int The customer ID to fetch the amount of credit for. If not provided, the current customer is used.
		 * @return float The amount of store credit the customer has.
		 */
		public function GetCustomerStoreCredit($customerid=0)
		{
			if ($customerid == 0) {
				$customerid = $this->GetCustomerId();
			}

			if ($customerid > 0) {
				$query = sprintf("SELECT custstorecredit FROM [|PREFIX|]customers WHERE customerid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($customerid));
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

				if ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					$credit = $row['custstorecredit'];
				}
			}

			return $credit;
		}

		/**
		 * Get a particular customer group based on the group Id. If null, the group of the current customer is fetched.
		 *
		 * @param int The customer group id to fetch the group information for.
		 * @param array Information regarding the customer group.
		 */
		public function GetCustomerGroup($groupId=null)
		{
			$group = false;
			$getDefaultGroup = false;
			if(is_null($groupId) && !defined('ISC_ADMIN_CP')) {
				$customer = $this->GetCustomerDataByToken();

				// Customer isn't logged in - they're a guest. They get the default for guests
				if(!$customer['customerid']) {
					if(GetConfig('GuestCustomerGroup') != 0) {
						$customer['custgroupid'] = GetConfig('GuestCustomerGroup');
					}
					else {
						return false;
					}
				}
				$groupId = $customer['custgroupid'];
				if($customer['custgroupid'] == 0) {
					$getDefaultGroup = true;
				}
			}

			$groupCache = $GLOBALS['ISC_CLASS_DATA_STORE']->Read('CustomerGroups');
			if($getDefaultGroup) {
				if(!isset($groupCache['default'])) {
					return false;
				}
				$group = $groupCache[$groupCache['default']];
			}
			else if(isset($groupCache[$groupId])) {
				$group = $groupCache[$groupId];
			}

			return $group;
		}

		/**
		 * Get the sales tax information regarding the passed billing & shipping details.
		 *
		 * @param mixed Either an integer with the billing address or an array of details about the address.
		 * @param mixed Either an integer with the shipping address or an array of details about the address.
		 * @return array Array of information containing the tax data. (name, rate, based on etc)
		 */
		public function GetSalesTaxRate($billingAddress, $shippingAddress=0)
		{
			// Setup the array which will be returned
			$taxData = array(
				"tax_name" => "",
				"tax_rate" => 0,
				"tax_based_on" => "",
				"tax_id" => 0
			);

			// If tax is being applied globally, just return that
			if(GetConfig('TaxTypeSelected') == 2) {
				$basedOn = 'subtotal';
				if(GetConfig('DefaultTaxRateBasedOn')) {
					$basedOn = GetConfig('DefaultTaxRateBasedOn');
				}
				$taxData['tax_name'] = GetConfig('DefaultTaxRateName');
				$taxData['tax_rate'] = GetConfig('DefaultTaxRate');
				$taxData['tax_based_on'] = $basedOn;
				return $taxData;
			}

			$GLOBALS['ISC_CLASS_ACCOUNT'] = GetClass('ISC_ACCOUNT');
			$countryIds = array();
			$stateIds = array();
			if(!is_array($billingAddress)) {
				$billingAddress = $GLOBALS['ISC_CLASS_ACCOUNT']->GetShippingAddress($billingAddress);
			}

			if(!is_array($shippingAddress) && $shippingAddress > 0) {
				$shippingAddress = $GLOBALS['ISC_CLASS_ACCOUNT']->GetShippingAddress($shippingAddress);
			}

			// A billing address is required for every order. If we don't have one then there's no point in proceeding
			if(!is_array($billingAddress)) {
				return $taxData;
			}

			if(!isset($billingAddress['shipcountryid'])) {
				$billingAddress['shipcountryid'] = GetCountryIdByName($billingAddress['shipcountry']);
			}
			if(!isset($billingAddress['shipstateid'])) {
				$billingAddress['shipstateid'] = GetStateByName($billingAddress['shipstate'], $billingAddress['shipcountryid']);
			}

			if(is_array($shippingAddress)) {
				if(!isset($shippingAddress['shipcountryid'])) {
					$shippingAddress['shipcountryid'] = GetCountryIdByName($shippingAddress['shipcountry']);
				}
				if(!isset($shippingAddress['shipstateid'])) {
					$shippingAddress['shipstateid'] = GetStateByName($shippingAddress['shipstate'], $shippingAddress['shipcountryid']);
				}
			}

			// Do we have a matching state based tax rule?
			if($billingAddress['shipstateid'] || (is_array($shippingAddress) && $shippingAddress['shipstateid'])) {
				$query = "
					SELECT *
					FROM [|PREFIX|]tax_rates
					WHERE (1=0
				";
				if($billingAddress['shipstateid']) {
					$query .= " OR (taxaddress='billing' AND taxratecountry='".(int)$billingAddress['shipcountryid']."' AND taxratestates LIKE '%%,".(int)$billingAddress['shipstateid'].",%%')";
				}

				if(is_array($shippingAddress) && $shippingAddress['shipstateid']) {
					$query .= " OR (taxaddress='shipping' AND taxratecountry='".(int)$shippingAddress['shipcountryid']."' AND taxratestates LIKE '%%,".(int)$shippingAddress['shipstateid'].",%%')";
				}
				$query .= ") AND taxratestatus='1'";
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
				if(is_array($row)) {
					$taxData = array(
						'tax_name' =>		$row['taxratename'],
						'tax_rate' =>		$row['taxratepercent'],
						'tax_based_on' =>	$row['taxratebasedon'],
						'tax_id' =>		$row['taxrateid']
					);
					return $taxData;
				}
			}

			// Maybe we've got a matching country based rule
			$query = "
				SELECT *
				FROM [|PREFIX|]tax_rates
				WHERE (1=0 OR (taxratecountry='".(int)$billingAddress['shipcountryid']."' AND taxaddress='billing')
			";
			if(is_array($shippingAddress) && $shippingAddress['shipcountryid']) {
				$query .= " OR (taxratecountry='".(int)$shippingAddress['shipcountryid']."' AND taxaddress='shipping')";
			}
			$query .= ") AND taxratestatus='1' AND taxratestates = ',0,'";

			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
			if(is_array($row)) {
				$taxData = array(
					'tax_name' =>		$row['taxratename'],
					'tax_rate' =>		$row['taxratepercent'],
					'tax_based_on' =>	$row['taxratebasedon'],
					'tax_id' =>		$row['taxrateid']
				);
				return $taxData;
			}

			// Otherwise, if we still have nothing, perhaps we have a rule that applies to all countries
			$query = "
				SELECT *
				FROM [|PREFIX|]tax_rates
				WHERE taxratecountry='0' AND taxratestatus='1'
			";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
			if(is_array($row)) {
				$taxData = array(
					'tax_name' =>		$row['taxratename'],
					'tax_rate' =>		$row['taxratepercent'],
					'tax_based_on' =>	$row['taxratebasedon'],
					'tax_id' =>		$row['taxrateid']
				);
				return $taxData;
			}

			// Still here? Just return nothing!
			return $taxData;
		}
		
		
	
		
	}

?>
