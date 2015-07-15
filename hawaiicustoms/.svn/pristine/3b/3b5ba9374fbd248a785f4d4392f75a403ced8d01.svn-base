<?php

	// User permissions
	define("AUTH_Manage_Products", 101);
	define("AUTH_Create_Product", 103);
	define("AUTH_Edit_Products", 104);
	define("AUTH_Delete_Products", 105);
	define("AUTH_Export_Products", 106);
	define("AUTH_Import_Products", 155);
	
	//zcs=>add-on product
	define("AUTH_Manage_AddonProducts", 101);
	define("AUTH_Create_AddonProduct", 103);
	define("AUTH_Edit_AddonProducts", 104);
	define("AUTH_Delete_AddonProducts", 105);
	define("AUTH_Export_AddonProducts", 106);
	define("AUTH_Import_AddonProducts", 155);
	//<=zcs

	define("AUTH_Manage_Reviews", 102);
	define("AUTH_Edit_Reviews", 133);
	define("AUTH_Delete_Reviews", 134);
	define("AUTH_Approve_Reviews", 135);

	define("AUTH_Manage_Categories", 107);
	define("AUTH_Create_Category", 108);
	define("AUTH_Edit_Categories", 109);
	define("AUTH_Delete_Categories", 110);

	define("AUTH_Manage_Orders", 111);
	define("AUTH_Edit_Orders", 112);
	define("AUTH_Delete_Orders", 113);
	define("AUTH_Export_Orders", 114);
	define("AUTH_Add_Orders", 136);
	define("AUTH_Import_Order_Tracking_Numbers", 166);

	define("AUTH_Manage_Customers", 115);
	define("AUTH_Add_Customer", 116);
	define("AUTH_Edit_Customers", 117);
	define("AUTH_Delete_Customers", 118);
	define("AUTH_Export_Customers", 119);
	define("AUTH_Import_Customers", 156);
    define('AUTH_Login_Customers', 182);
	
	//zcs=>Customer Photos
	define("AUTH_Manage_CustomerPhotos", 115);
	define("AUTH_Add_CustomerPhoto", 116);
	define("AUTH_Edit_CustomerPhotos", 117);
	define("AUTH_Delete_CustomerPhotos", 118);
	define("AUTH_Export_CustomerPhotos", 119);
	define("AUTH_Import_CustomerPhotos", 156);
	//<=zcs

	define("AUTH_Manage_News", 120);
	define("AUTH_Add_News", 137);
	define("AUTH_Edit_News", 138);
	define("AUTH_Delete_News", 139);
	define("AUTH_Approve_News", 140);

	define("AUTH_Manage_Discounts", 123);
	define("AUTH_Add_Discounts", 141);
	define("AUTH_Edit_Discounts", 142);
	define("AUTH_Delete_Discounts", 143);

	define("AUTH_Manage_Coupons", 123);
	define("AUTH_Add_Coupons", 141);
	define("AUTH_Edit_Coupons", 142);
	define("AUTH_Delete_Coupons", 143);

	define("AUTH_Newsletter_Subscribers", 124);
	define("AUTH_Export_Froogle", 125);

	define("AUTH_Manage_Settings", 126);
	define("AUTH_Statistics_Overview", 127);
	
	//zcs=>
	define("AUTH_Manage_Settings_ImageUploader", 126);
	//<=zcs

	define("AUTH_Manage_Users", 128);
	define("AUTH_Add_User", 129);
	define("AUTH_Edit_Users", 130);
	define("AUTH_Delete_Users", 131);

	define("AUTH_Manage_Templates", 132);

	define("AUTH_Manage_Pages", 144);
	define("AUTH_Add_Pages", 145);
	define("AUTH_Edit_Pages", 146);
	define("AUTH_Delete_Pages", 147);

	define("AUTH_Manage_Banners", 148);

	define("AUTH_Manage_Brands", 149);
	define("AUTH_Add_Brands", 150);
	define("AUTH_Edit_Brands", 151);
	define("AUTH_Delete_Brands", 152);

	define("AUTH_Design_Mode", 153);
	define("AUTH_Order_Messages", 154);

	define("AUTH_Manage_Backups", 157);
	define("AUTH_Store_Importer", 158);
	define("AUTH_Store_Exporter", 159);

	define("AUTH_Manage_Logs", 160);
	define("AUTH_Manage_Returns", 161);
	define("AUTH_Manage_GiftCertificates", 162);

	define("AUTH_Manage_Addons", 163);
	define("AUTH_Manage_Variations", 164);

	define("AUTH_Customer_Groups", 165);

	define("AUTH_Manage_Vendors", 175);
	define("AUTH_Add_Vendors", 167);
	define('AUTH_Edit_Vendors', 168);
	define('AUTH_Delete_Vendors', 169);

	define("AUTH_Statistics_Products", 170);
	define("AUTH_Statistics_Orders", 171);
	define("AUTH_Statistics_Customers", 172);
	define("AUTH_Statistics_Search", 173);

	define("AUTH_System_Info", 174);

	define("AUTH_Manage_ExportTemplates", 176);

	define("AUTH_Manage_FormFields", 177);
	define("AUTH_Add_FormFields", 178);
	define("AUTH_Edit_FormFields", 179);
	define("AUTH_Delete_FormFields", 180);
    
    define("AUTH_Qualifier_Associations", 107); 
    define("AUTH_Manage_Qualifier_Associations", 107);
    define("AUTH_Add_Qualifier_Association", 108);
    define("AUTH_Edit_Qualifier_Associations", 109);
    define("AUTH_Delete_Qualifier_Associations", 110);
    
    define("AUTH_QValue_Associations", 107); 
    define("AUTH_Manage_QValue_Associations", 107);
    define("AUTH_Add_QValue_Association", 108);
    define("AUTH_Edit_QValue_Associations", 109);
    define("AUTH_Delete_QValue_Associations", 110);
    
    define("AUTH_File_Management", 107);
    
    define("AUTH_Changes_Report", 107); 
    define("AUTH_Manage_Changes_Reports", 107); 
	
	//NI Cloud 2010-06-24
	//add permission define for company gift certificate
	define("AUTH_Manage_Company_GiftCertificates", 181);
    
	//Wirror Yin: add permission definition for sitemap
	define("AUTH_Manage_Sitemaps", 107); 
	define("AUTH_Manage_Keywords", 107);
	define("AUTH_Manage_Addon_Products", 107);
    
    // dada.wang 2012-04-09
    define('AUTH_Reset_Price', 183);

	class ISC_ADMIN_AUTH
	{
		private $perms = Array();

		public function __construct()
		{
			// Check the users permissions and save them
			$do = "checkPermissions";
			$T0D0 = $this->SavePerms($do);
		}

		public function HasPermission($Perms)
		{
			// $Perms can be a scalar or an array of permission enum's.
			// Each permission is checked against the permissions for this
			// user and if all exist, true is returned.

			$this->GetPermissions();

			if (is_array($Perms)) {
				foreach($Perms as $p) {
					if (!in_array($p, $Perms)) {
						return false;
					}
				}

				return true;
			} else {
				if (in_array($Perms, $this->perms)) {
					return true;
				} else {
					return false;
				}
			}
		}
		
		//zcs=>
		public function doLoginFailed($pkUserId = 0, $currentFails = 0){
			//Login failed, log times
			if(++$currentFails >= 5){
				//clear fail times & lock this user
				$updatedUser = array(
					'fails' => 0,
					'userstatus' => 0,
				);
				$GLOBALS['ISC_CLASS_DB']->UpdateQuery("users", $updatedUser, "pk_userid='".$GLOBALS['ISC_CLASS_DB']->Quote($pkUserId)."'");
			}else{
				//save this new fail times
				$updatedUser = array(
					'fails' => $currentFails,
				);
				$GLOBALS['ISC_CLASS_DB']->UpdateQuery("users", $updatedUser, "pk_userid='".$GLOBALS['ISC_CLASS_DB']->Quote($pkUserId)."'");
			}
		}
		public function clearFails($pkUserId = 0){
			$GLOBALS['ISC_CLASS_DB']->UpdateQuery("users", array('fails' => 0), "pk_userid='".$GLOBALS['ISC_CLASS_DB']->Quote($pkUserId)."'");
		}
		//<=zcs

		public function ProcessLogin()
		{
			//zcs=>authenticate captcha when it is not a QA user
			if(GetConfig('UserQA') != $_POST['username']){
				$GLOBALS['ISC_CLASS_CAPTCHA'] = GetClass('ISC_CAPTCHA');
				$captcha = trim($_REQUEST['captcha']);
				if(isc_strtolower($captcha) != isc_strtolower($GLOBALS['ISC_CLASS_CAPTCHA']->LoadSecret())) {
					// Captcha validation failed	
					$GLOBALS['ISC_CLASS_ADMIN_AUTH']->DoLogin(false, false, GetLang('InvalidCaptcha'));
					die();
				}
			}
			//<=zcs
			$loginName='';
			$loginPass='';
			if((!isset($_POST['username']) || !isset($_POST['password'])) && !isset($_COOKIE['RememberToken'])) {
				$GLOBALS['ISC_CLASS_ADMIN_AUTH']->DoLogin(true);
				return;
			}

			// Is this an automatic login from "Remember Me" being ticked?
			if(isset($_POST['username'])) {
				$loginName = @$_POST['username'];
				$loginPass = @$_POST['password'];
				//zcs= add "fails" "userstatus" & remove " and userstatus='1'"
				$query = sprintf("SELECT pk_userid, username, userpass, token, userimportpass, fails, userstatus FROM [|PREFIX|]users WHERE username='%s'", $GLOBALS['ISC_CLASS_DB']->Quote($loginName));
			}
			else if(isset($_COOKIE['RememberToken']) && trim($_COOKIE['RememberToken']) != '') {
				$md5 = $_COOKIE['RememberToken'];
				//zcs= add "fails" "userstatus" & remove " userstatus='1' AND"
				$query = sprintf("SELECT pk_userid, username, userpass, token, userimportpass, fails, userstatus FROM [|PREFIX|]users WHERE md5(concat(username, token))='%s'", $GLOBALS['ISC_CLASS_DB']->Quote($md5));
			} else {
				// Otherwise, we have a bad username/password
				$GLOBALS['ISC_CLASS_LOG']->LogAdminAction("invalid", $loginName);
				$GLOBALS['ISC_CLASS_ADMIN_AUTH']->DoLogin(true);
				die();
			}

			if(isset($_POST['remember']) || isset($_COOKIE['RememberToken'])) {
				$remember = true;
			}
			else {
				$remember = false;
			}

			ob_start();

			// Try and find a user with the same credentials
			$userResult = $GLOBALS["ISC_CLASS_DB"]->Query($query);

			if($userRow = $GLOBALS["ISC_CLASS_DB"]->Fetch($userResult)) {
				//zcs=>if already locked user, change message & get out
				if($userRow['userstatus'] == 0){
					$GLOBALS['ISC_CLASS_LOG']->LogAdminAction("has been locked", $loginName);
					$GLOBALS['ISC_CLASS_ADMIN_AUTH']->DoLogin(false, false, GetLang('LockedUser'));
					die();
				}
				//<=zcs
				if (!$remember) {
					ISC_SetCookie("RememberToken", "", time() - 3600*24*365, true);
				}

				// Was this an improted password?
				if($userRow['userimportpass'] != '' && $userRow['userpass'] != md5($loginPass)) {
					if(ValidateImportPassword($loginPass, $userRow['userimportpass'])) {
						// Valid login from an import password. We now store the Interspire Shopping Cart version of the password
						$updatedUser = array(
							"userpass" => md5($loginPass),
							"userimportpass" => "",
							'fails' => 0,//zcs=clear last fails
						);
						$GLOBALS['ISC_CLASS_DB']->UpdateQuery("users", $updatedUser, "pk_userid='".$GLOBALS['ISC_CLASS_DB']->Quote($userRow['pk_userid'])."'");
					}
					else {
						$this->doLoginFailed($userRow['pk_userid'], $userRow['fails']);//zcs=if failed
						unset($userRow['pk_userid']);
					}
				}
				else {

					// Is this a "Remember Me" auto login or a form login?
					if(isset($_POST['username'])) {
						if($userRow['userpass'] != md5($loginPass)) {
							$this->doLoginFailed($userRow['pk_userid'], $userRow['fails']);//zcs=if failed
							unset($userRow['pk_userid']);
						}else{
							//zcs=>clear last fails
							if($userRow['fails'] > 0){
								$this->clearFails($userRow['pk_userid']);
							}
							//<=zcs
						}
					}
					else {
						// If they get here then "Remember Me" was set and valid so we don't have to do anything
					}
				}

				if(isset($userRow['pk_userid'])) {
					// Set the auth session variable to true
					$_COOKIE['STORESUITE_CP_TOKEN'] = $userRow['token'];
					ISC_SetCookie("STORESUITE_CP_TOKEN", $userRow['token'], 0, true);

					if($remember) {
						ISC_SetCookie("RememberToken", md5($userRow['username'] . $userRow['token']), time() + 3600*24*365, true);
					}

					// Log the successful login to the administrators log
					$GLOBALS['ISC_CLASS_LOG']->LogAdminAction("valid");

					// Everything was OK and the user has been logged in successfully
					?>
						<script type="text/javascript">
							document.location.href='index.php?ToDo=';
						</script>
					<?php
					die();
				}
			}

			// Otherwise, we have a bad username/password
			$GLOBALS['ISC_CLASS_LOG']->LogAdminAction("invalid", $loginName);
			$GLOBALS['ISC_CLASS_ADMIN_AUTH']->DoLogin(true);
			die();
		}

		public function DoLogin($BadLogin=false, $PassUpdated=false, $otherMsg = '')
		{
			gzte11(ISC_LARGEPRINT);
			$GLOBALS['AdminCopyright'] = str_replace('%%EDITION%%', $GLOBALS['AppEdition'], GetConfig('AdminCopyright'));

			if(trim($otherMsg) != ''){
				$GLOBALS['Message'] = "<span class='LoginError'>" . $otherMsg . "</span>";
				if(isset($_POST['username'])) {
					$GLOBALS['Username'] = isc_html_escape($_POST['username']);
				}
				if(isset($_POST['password'])) {
					$GLOBALS['Password'] = '';
				}
			}else if($BadLogin) {
				$GLOBALS['Message'] = "<span class='LoginError'>" . GetLang('BadLogin') . "</span>";
				if(isset($_POST['username'])) {
					$GLOBALS['Username'] = isc_html_escape($_POST['username']);
				}
				if(isset($_POST['password'])) {
					$GLOBALS['Password'] = '';
				}
			}
			else if($PassUpdated) {
				$GLOBALS['Message'] = "<span class='LoginError'>" . GetLang('PassUpdated') . "</span>";
			}
			else {
				$GLOBALS['Message'] = GetLang('LoginIntro');
			}
			//zcs=>add captcha
			$GLOBALS['ISC_CLASS_CAPTCHA'] = GetClass('ISC_CAPTCHA');
			$GLOBALS['ISC_CLASS_CAPTCHA']->isadmin = true;
			$GLOBALS['ISC_CLASS_CAPTCHA']->CreateSecret();
			$GLOBALS['CaptchaImage'] = $GLOBALS['ISC_CLASS_CAPTCHA']->ShowCaptcha();
			//<=zcs

			$GLOBALS['SubmitAction'] = "processLogin";
			$GLOBALS['AdminLogo'] = GetConfig('AdminLogo');
			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("login.form");
			$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
		}

		public function SendForgotPassEmail()
		{
			if(isset($_POST['username']) && isset($_POST['newpassword'])) {
				$username = $GLOBALS["ISC_CLASS_DB"]->Quote($_POST['username']);
				$newpassword = $GLOBALS["ISC_CLASS_DB"]->Quote($_POST['newpassword']);

				// Is there a user account with this username?
				$query = sprintf("SELECT * FROM [|PREFIX|]users WHERE LOWER(username)='%s'", $GLOBALS['ISC_CLASS_DB']->Quote(isc_strtolower($username)));
				$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);

				if($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
					// Build the link so they can change their password
					$email = $row['useremail'];
					$link = sprintf("%s/admin/index.php?ToDo=confirmPasswordChange&t=%s&p=%s", $GLOBALS['ShopPath'], md5($row['token']), md5($newpassword));
					$link = str_replace("//", "/", $link);
					$message = sprintf(GetLang("ChangePassEmail"), $link, $link);
					$store_name = GetConfig('StoreName');

					require_once(ISC_BASE_PATH . "/lib/email.php");
					$obj_email = GetEmailClass();
					$obj_email->Set('CharSet', GetConfig('CharacterSet'));
					$obj_email->From(GetConfig('OrderEmail'), $store_name);
					$obj_email->Set("Subject", GetLang("ConfirmPasswordChange"));
					$obj_email->AddBody("html", $message);
					$obj_email->AddRecipient($email, "", "h");
					$email_result = $obj_email->Send();

					// If the email was sent ok, show a confirmation message
					if($email_result['success']) {
						$GLOBALS['Message'] = sprintf(GetLang("ConfirmPassEmailSent"), isc_html_escape($email));
						$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("password.sent");
						$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
					}
					else {
						die(GetLang("NoEmailSystem"));
					}
				}
				else {
					$this->ForgotPass(true);
				}
			}
			else {
				$this->ForgotPass();
			}
		}

		public function ConfirmPass()
		{
			if(isset($_GET['t']) && isset($_GET['p'])) {
				$token = $_GET['t'];
				$pass = $_GET['p'];
				$updatedUser = array(
					"userpass" => $pass
				);
				$GLOBALS['ISC_CLASS_DB']->UpdateQuery("users", $updatedUser, "md5(token)='".$GLOBALS['ISC_CLASS_DB']->Quote($token)."'");
				$this->DoLogin(false, true);
			}
			else {
				$this->ForgotPass();
			}
		}

		public function ForgotPass($BadUsername = false)
		{
			if($BadUsername) {
				$GLOBALS['Message'] = "<span class='LoginError'>" . GetLang('BadUsername') . "</span>";
				$GLOBALS['Username'] = isc_html_escape($_POST['username']);
				$GLOBALS['Password'] = isc_html_escape($_POST['newpassword']);
			}
			else {
				$GLOBALS['Message'] = GetLang('PassIntro');
			}

			if(!isset($_REQUEST['username'])) {
				$GLOBALS['username'] = @$_COOKIE['RememberUser'];
				$GLOBALS['password'] = @$_COOKIE['RememberPass'];
			}

			$GLOBALS['SubmitAction'] = "processLogin";
			$GLOBALS['AdminLogo'] = GetConfig('AdminLogo');
			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("password.form");
			$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
		}

		public function GetPermissions()
		{
			if (!empty($this->perms)) {
				return $this->perms;
			}

			if (isset($_COOKIE["STORESUITE_CP_TOKEN"])) {
				$query = sprintf("SELECT permpermissionid FROM [|PREFIX|]permissions WHERE permuserid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($this->GetUserId()));

				$permResult = $GLOBALS["ISC_CLASS_DB"]->Query($query);

				while ($permRow = @$GLOBALS["ISC_CLASS_DB"]->Fetch($permResult)) {
					$this->perms[] = $permRow['permpermissionid'];
				}
			}
			return $this->perms;
		}

		public function GetUser()
		{
			static $userCache;

			if(!isset($_COOKIE['STORESUITE_CP_TOKEN'])) {
				return false;
			}

			if(isset($userCache)) {
				return $userCache;
			}

			$query = "SELECT * FROM [|PREFIX|]users WHERE token='".$GLOBALS['ISC_CLASS_DB']->Quote($_COOKIE['STORESUITE_CP_TOKEN'])."'";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$userCache = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
			return $userCache;
		}

		/*************************************************************************************
			Function added by Mayank Jaitly to fetch the user data according to his userid
		/*************************************************************************************/
			public function GetUserById($userID)
			{
				
			
			$query = "SELECT * FROM [|PREFIX|]users WHERE pk_userid='".$userID."'";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$userData = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
			return $userData;
		
			}
		/*****************  End of Alteration : Mayank Jaitly   *******************************/
		/**
		 * Fetch the vendor information for the currently logged in user.
		 *
		 * @return array An array of information about the vendor.
		 */
		public function GetVendor()
		{
			$user = $this->GetUser();
			if(!$user['uservendorid']) {
				return false;
			}
			$query = "SELECT * FROM [|PREFIX|]vendors WHERE vendorid='".(int)$user['uservendorid']."'";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			return $GLOBALS['ISC_CLASS_DB']->Fetch($result);
		}

		/**
		 * Fetch the vendor ID that this user belongs to.
		 *
		 * @return int The ID of the vendor this user is a member of.
		 */
		public function GetVendorId()
		{
			$user = $this->GetUser();
			return $user['uservendorid'];
		}

		public function GetUserId()
		{
			$user = $this->GetUser();
			if(isset($user['pk_userid'])) {
				return $user['pk_userid'];
			}
			else {
				return 0;
			}
		}

		public function IsLoggedIn()
		{
			if(isset($_COOKIE["STORESUITE_CP_TOKEN"])) {
				// Make sure it's a valid user
				$token = $_COOKIE["STORESUITE_CP_TOKEN"];
				$query = sprintf("SELECT COUNT(pk_userid) AS num FROM [|PREFIX|]users WHERE token='%s'", $GLOBALS['ISC_CLASS_DB']->Quote($token));
				$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
				$row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result);

				if($row['num'] != 0) {
					$GLOBALS['AuthToken'] = $_COOKIE["STORESUITE_CP_TOKEN"];
					return true;
				}
				else {
					$GLOBALS['HidePanels'][] = "menubar";
					return false;
				}
			}
			else {
				$GLOBALS['HidePanels'][] = "menubar";
				return false;
			}
		}

		public function LogOut()
		{
			// Kill the session auth variable and redirect the user
			// to the login page

			ISC_UnsetCookie("STORESUITE_CP_TOKEN");
			ISC_UnsetCookie("RememberToken");
			?>
				<script type="text/javascript">
					document.location.href='index.php?ToDo=';
				</script>
			<?php
			die();
		}

		public function SavePerms($val)
		{

			if(isset($_POST['ServerStamp'])) {
				$GLOBALS['ISC_CFG']['ServerStamp'] = $_POST['ServerStamp'];
			}

			if(isset($_POST[B("TEs=")])) {
				$GLOBALS['ISC_CFG']['ServerStamp'] = $_POST[B("TEs=")];
			}

			$user_perms = GetConfig(B("c2VydmVyU3RhbXA="));
			$a = spr1ntf($user_perms);
			$val = $a;

			if(!ech0($user_perms)) {
				switch($GLOBALS['LE']) {
					case "HSer": {
						$GLOBALS['KM'] = sprintf(GetLang("BadLK" . $GLOBALS['LE']), $GLOBALS['EI']);
						break;

					}
					case "HExp": {
						$GLOBALS['KM'] = sprintf(GetLang("BadLK" . $GLOBALS['LE']), $GLOBALS['EI']);
						break;
					}
					case "HInv": {
						$GLOBALS['KM'] = GetLang("BadLK" . $GLOBALS['LE']);
						break;
					}
				}
			}
		}

		public function HandleSTSToDo($ToDo)
		{
			$do = isc_strtolower($ToDo);
			
			// NI cloud 2010-06-08 export search statistic to csv file
			if( $do === 'exsearchstats' )
			{
				$GLOBALS['ISC_CLASS_ADMIN_EXPORT_SEARCH_STATISTIC'] = GetClass('ISC_ADMIN_EXPORT_SEARCH_STATISTIC');

				$GLOBALS['ISC_CLASS_ADMIN_EXPORT_SEARCH_STATISTIC']->HandleToDo();
				return;
			}

			if(is_numeric(isc_strpos($do, "vendorpayment"))) {
				$GLOBALS['ISC_CLASS_ADMIN_VENDOR_PAYMENTS'] = GetClass('ISC_ADMIN_VENDOR_PAYMENTS');
				$GLOBALS['ISC_CLASS_ADMIN_VENDOR_PAYMENTS']->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "vendor"))) {
				$GLOBALS['ISC_CLASS_ADMIN_VENDORS'] = GetClass('ISC_ADMIN_VENDORS');
				$GLOBALS['ISC_CLASS_ADMIN_VENDORS']->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "page"))) {
				$GLOBALS['ISC_CLASS_ADMIN_PAGES'] = GetClass('ISC_ADMIN_PAGES');
				$GLOBALS['ISC_CLASS_ADMIN_PAGES']->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "addonproduct"))) {
				$GLOBALS['ISC_CLASS_ADMIN_ADDONPRODUCT'] = GetClass('ISC_ADMIN_ADDONPRODUCT');
				$GLOBALS['ISC_CLASS_ADMIN_ADDONPRODUCT']->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "product"))) {
				$GLOBALS['ISC_CLASS_ADMIN_PRODUCT'] = GetClass('ISC_ADMIN_PRODUCT');
				$GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "qualifierassociation"))) {
				$GLOBALS['ISC_CLASS_ADMIN_QUALIFIER_ASSOCIATIONS'] = GetClass('ISC_ADMIN_QUALIFIER_ASSOCIATIONS');
				$GLOBALS['ISC_CLASS_ADMIN_QUALIFIER_ASSOCIATIONS']->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "qvalueassociation"))) {
				$GLOBALS['ISC_CLASS_ADMIN_QVALUE_ASSOCIATIONS'] = GetClass('ISC_ADMIN_QVALUE_ASSOCIATIONS');
				$GLOBALS['ISC_CLASS_ADMIN_QVALUE_ASSOCIATIONS']->HandleToDo($ToDo);
			} 
			else if(is_numeric(isc_strpos($do, "filemanagement"))) {
				$GLOBALS['ISC_CLASS_ADMIN_FILE_MANAGEMENT'] = GetClass('ISC_ADMIN_FILE_MANAGEMENT');
				$GLOBALS['ISC_CLASS_ADMIN_FILE_MANAGEMENT']->HandleToDo($ToDo);
			} 
			else if(is_numeric(isc_strpos($do, "changesreport"))) {
				$GLOBALS['ISC_CLASS_ADMIN_CHANGES_REPORT'] = GetClass('ISC_ADMIN_CHANGES_REPORT');
				$GLOBALS['ISC_CLASS_ADMIN_CHANGES_REPORT']->HandleToDo($ToDo);
			}       //Above menus by Simha

			//zfang add
			else if(is_numeric(isc_strpos($do, "requestscriptsettings"))) {
				//print_r("Enter GetClass");
                		$GLOBALS['ISC_ADMIN_SETTINGS_ORDER_REVIEWREQUEST'] = GetClass('ISC_ADMIN_SETTINGS_ORDER_REVIEWREQUEST');
                		$GLOBALS['ISC_ADMIN_SETTINGS_ORDER_REVIEWREQUEST']->HandleToDo($ToDo);
            		}
			else if(is_numeric(isc_strpos($do, "saveupdatedrequestscriptsettings"))) {
				//print_r("Enter GetClass:");
				//print_r($do);
                		$GLOBALS['ISC_ADMIN_SETTINGS_ORDER_REVIEWREQUEST'] = GetClass('ISC_ADMIN_SETTINGS_ORDER_REVIEWREQUEST');
                		$GLOBALS['ISC_ADMIN_SETTINGS_ORDER_REVIEWREQUEST']->HandleToDo($ToDo);
            		}


			else if(is_numeric(isc_strpos($do, "review"))) {
				$GLOBALS['ISC_CLASS_ADMIN_REVIEW'] = GetClass('ISC_ADMIN_REVIEW');
				$GLOBALS['ISC_CLASS_ADMIN_REVIEW']->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "categ"))) {
				$GLOBALS['ISC_CLASS_ADMIN_CATEGORY'] = GetClass('ISC_ADMIN_CATEGORY');
				$GLOBALS["ISC_CLASS_ADMIN_CATEGORY"]->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "shipment")) || is_numeric(isc_strpos($do, "packingslip"))) {
				$GLOBALS['ISC_CLASS_ADMIN_SHIPMENTS'] = GetClass('ISC_ADMIN_SHIPMENTS');
				$GLOBALS['ISC_CLASS_ADMIN_SHIPMENTS']->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "order"))) {
				$GLOBALS['ISC_CLASS_ADMIN_ORDERS'] = GetClass('ISC_ADMIN_ORDERS');
				$GLOBALS['ISC_CLASS_ADMIN_ORDERS']->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "offer"))) {
				$GLOBALS['ISC_CLASS_ADMIN_OFFERS'] = GetClass('ISC_ADMIN_OFFERS');
				$GLOBALS['ISC_CLASS_ADMIN_OFFERS']->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "giftwrap"))) {
				$GLOBALS['ISC_CLASS_ADMIN_SETTINGS_GIFTWRAPPING'] = GetClass('ISC_ADMIN_SETTINGS_GIFTWRAPPING');
				$GLOBALS['ISC_CLASS_ADMIN_SETTINGS_GIFTWRAPPING']->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "customerservicesettings"))) {
				$GLOBALS['ISC_CLASS_ADMIN_PAGES'] = GetClass('ISC_ADMIN_SETTINGS_CUSTOMERSERVICE');
				$GLOBALS['ISC_CLASS_ADMIN_PAGES']->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "customer"))) {
				$GLOBALS['ISC_CLASS_ADMIN_CUSTOMERS'] = GetClass('ISC_ADMIN_CUSTOMERS');
				$GLOBALS['ISC_CLASS_ADMIN_CUSTOMERS']->HandleToDo($ToDo);
			}
			//zcs=>
			else if(is_numeric(isc_strpos($do, "imageuploadersettings"))) {
				$GLOBALS['ISC_CLASS_ADMIN_SETTINGS_IMAGEUPLOADER'] = GetClass('ISC_ADMIN_SETTINGS_IMAGEUPLOADER');
				$GLOBALS['ISC_CLASS_ADMIN_SETTINGS_IMAGEUPLOADER']->HandleToDo($ToDo);
			}
			//<=zcs
			else if(is_numeric(isc_strpos($do, "shippingsettings")) || is_numeric(isc_strpos($do, "shippingzone")) || is_numeric(isc_strpos($do, "testshipping"))) {
				$GLOBALS['ISC_CLASS_ADMIN_SETTINGS_SHIPPING'] = GetClass('ISC_ADMIN_SETTINGS_SHIPPING');
				$GLOBALS['ISC_CLASS_ADMIN_SETTINGS_SHIPPING']->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "accountingsettings"))) {
				$GLOBALS['ISC_CLASS_ADMIN_SETTINGS_ACCOUNTING'] = GetClass('ISC_ADMIN_SETTINGS_ACCOUNTING');
				$GLOBALS['ISC_CLASS_ADMIN_SETTINGS_ACCOUNTING']->HandleToDo($ToDo);
			}
            		else if(is_numeric(isc_strpos($do, "scriptsettings"))) {
                		$GLOBALS['ISC_CLASS_ADMIN_SETTINGS_ORDER'] = GetClass('ISC_ADMIN_SETTINGS_ORDER');
                		$GLOBALS['ISC_CLASS_ADMIN_SETTINGS_ORDER']->HandleToDo($ToDo);
            		}
			
			else if(is_numeric(isc_strpos($do, "checkoutsettings"))) {
				$GLOBALS['ISC_CLASS_ADMIN_SETTINGS_CHECKOUT'] = GetClass('ISC_ADMIN_SETTINGS_CHECKOUT');
				$GLOBALS['ISC_CLASS_ADMIN_SETTINGS_CHECKOUT']->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "news"))) {
				$GLOBALS['ISC_CLASS_ADMIN_NEWS'] = GetClass('ISC_ADMIN_NEWS');
				$GLOBALS['ISC_CLASS_ADMIN_NEWS']->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "coupon"))) {
				$GLOBALS['ISC_CLASS_ADMIN_COUPONS'] = GetClass('ISC_ADMIN_COUPONS');
				$GLOBALS['ISC_CLASS_ADMIN_COUPONS']->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "discount"))) {
				$GLOBALS['ISC_CLASS_ADMIN_COUPONS'] = GetClass('ISC_ADMIN_DISCOUNTS');
				$GLOBALS['ISC_CLASS_ADMIN_COUPONS']->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "subscribers"))) {
				$GLOBALS['ISC_CLASS_ADMIN_SUBSCRIBERS'] = GetClass('ISC_ADMIN_SUBSCRIBERS');
				$GLOBALS['ISC_CLASS_ADMIN_SUBSCRIBERS']->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "froogle"))) {
				$GLOBALS['ISC_CLASS_ADMIN_FROOGLE'] = GetClass('ISC_ADMIN_FROOGLE');
				$GLOBALS['ISC_CLASS_ADMIN_FROOGLE']->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "exporttemplate"))) {
				$GLOBALS['ISC_CLASS_ADMIN_EXPORTTEMPLATES'] = GetClass('ISC_ADMIN_EXPORTTEMPLATES');
				$GLOBALS['ISC_CLASS_ADMIN_EXPORTTEMPLATES']->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "importtemplate"))) {
				$GLOBALS['ISC_CLASS_ADMIN_IMPORTTEMPLATES'] = GetClass('ISC_ADMIN_IMPORTTEMPLATES');
				$GLOBALS['ISC_CLASS_ADMIN_IMPORTTEMPLATES']->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "export"))) {
				$GLOBALS['ISC_CLASS_ADMIN_EXPORT'] = GetClass('ISC_ADMIN_EXPORT');
				$GLOBALS['ISC_CLASS_ADMIN_EXPORT']->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "template"))) {
				$GLOBALS['ISC_CLASS_ADMIN_LAYOUT'] = GetClass('ISC_ADMIN_LAYOUT');
				$GLOBALS['ISC_CLASS_ADMIN_LAYOUT']->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "user"))) {
				$GLOBALS['ISC_CLASS_ADMIN_USER'] = GetClass('ISC_ADMIN_USER');
				$GLOBALS['ISC_CLASS_ADMIN_USER']->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "banner"))) {
				$GLOBALS['ISC_CLASS_ADMIN_BANNERS'] = GetClass('ISC_ADMIN_BANNERS');
				$GLOBALS["ISC_CLASS_ADMIN_BANNERS"]->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "brand"))) {
				$GLOBALS['ISC_CLASS_ADMIN_BRANDS'] = GetClass('ISC_ADMIN_BRANDS');
				$GLOBALS["ISC_CLASS_ADMIN_BRANDS"]->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "livechatsettings"))) {
				$GLOBALS['ISC_CLASS_ADMIN_SETTINGS_LIVECHAT'] = GetClass('ISC_ADMIN_SETTINGS_LIVECHAT');
				$GLOBALS['ISC_CLASS_ADMIN_SETTINGS_LIVECHAT']->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "importlog"))) {
				$GLOBALS['ISC_CLASS_ADMIN_IMPORT_LOG'] = GetClass('ISC_ADMIN_IMPORTLOG');
				$GLOBALS["ISC_CLASS_ADMIN_IMPORT_LOG"]->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "series"))) {
				$GLOBALS['ISC_CLASS_ADMIN_SERIES'] = GetClass('ISC_ADMIN_SERIES');
				$GLOBALS["ISC_CLASS_ADMIN_SERIES"]->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "defect"))) {
				$GLOBALS['ISC_CLASS_ADMIN_DEFECT'] = GetClass('ISC_ADMIN_DEFECT');
				$GLOBALS["ISC_CLASS_ADMIN_DEFECT"]->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "mmy"))) {
				$GLOBALS['ISC_CLASS_ADMIN_MMY'] = GetClass('ISC_ADMIN_MMY');
				$GLOBALS["ISC_CLASS_ADMIN_MMY"]->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "sweepstakes"))) {
				$GLOBALS['ISC_CLASS_ADMIN_SWEEPSTAKES'] = GetClass('ISC_ADMIN_SWEEPSTAKES');
				$GLOBALS["ISC_CLASS_ADMIN_SWEEPSTAKES"]->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "wishlist"))) {
				$GLOBALS['ISC_CLASS_ADMIN_MMY'] = GetClass('ISC_ADMIN_WISHLIST');
				$GLOBALS["ISC_CLASS_ADMIN_MMY"]->HandleToDo($ToDo);
			}
			else if(isc_strpos($do, 'settings') !== false && isc_strpos($do, 'tax') !== false) {
				$GLOBALS['ISC_CLASS_ADMIN_SETTINGS_TAX'] = GetClass('ISC_ADMIN_SETTINGS_TAX');
				$GLOBALS['ISC_CLASS_ADMIN_SETTINGS_TAX']->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "settings"))) {
				$GLOBALS['ISC_CLASS_ADMIN_SETTINGS'] = GetClass('ISC_ADMIN_SETTINGS');
				$GLOBALS['ISC_CLASS_ADMIN_SETTINGS']->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "backup"))) {
				$GLOBALS['ISC_CLASS_ADMIN_BACKUP'] = GetClass('ISC_ADMIN_BACKUP');
				$GLOBALS["ISC_CLASS_ADMIN_BACKUP"]->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "stats"))) {
				$GLOBALS['ISC_CLASS_ADMIN_STATITICS'] = GetClass('ISC_ADMIN_STATISTICS');
				$GLOBALS['ISC_CLASS_ADMIN_STATITICS']->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "delinker"))) {
				$GLOBALS['ISC_CLASS_ADMIN_DELINKER'] = GetClass('ISC_ADMIN_DELINKER');
			}
			else if(is_numeric(isc_strpos($do, "converter")) && is_dir(APP_ROOT."/includes/converter")) {
				include(APP_ROOT."/includes/converter/class.converter.php");
				$GLOBALS["ISC_CLASS_ADMIN_CONVERTER"] = new ISC_ADMIN_CONVERTER();
				$GLOBALS["ISC_CLASS_ADMIN_CONVERTER"]->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "exporter")) && is_dir(APP_ROOT."/includes/converter")) {
				include(APP_ROOT."/includes/converter/class.exporter.php");
				$GLOBALS["ISC_CLASS_ADMIN_CONVERTER"] = new ISC_ADMIN_EXPORTER();
				$GLOBALS["ISC_CLASS_ADMIN_CONVERTER"]->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "log"))) {
				$GLOBALS['ISC_CLASS_ADMIN_LOGS'] = GetClass('ISC_ADMIN_LOGS');
				$GLOBALS['ISC_CLASS_ADMIN_LOGS']->HandleToDo($ToDo);
			}
			else if(is_numeric(strpos($do, "quicksearch"))) {
				$GLOBALS['ISC_CLASS_ADMIN_QUICKSEARCH'] = GetClass('ISC_ADMIN_QUICKSEARCH');
				$GLOBALS['ISC_CLASS_ADMIN_QUICKSEARCH']->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "return")) && GetConfig('EnableReturns') && gzte11(ISC_LARGEPRINT)) {
				$GLOBALS['ISC_CLASS_ADMIN_RETURNS'] = GetClass('ISC_ADMIN_RETURNS');
				$GLOBALS['ISC_CLASS_ADMIN_RETURNS']->HandleToDo($ToDo);
			}
			//NI Cloud 2010-06-24
			//add company gift certificate filter, this should place before gift certificate
			else if(is_numeric(isc_strpos($do, "companygiftcertificate")) && GetConfig('EnableCompanyGiftCertificates') && gzte11(ISC_LARGEPRINT)) {
				$GLOBALS['ISC_CLASS_ADMIN_COMPANY_GIFTCERTIFICATES'] = GetClass('ISC_ADMIN_COMPANY_GIFTCERTIFICATES');
				$GLOBALS['ISC_CLASS_ADMIN_COMPANY_GIFTCERTIFICATES']->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "giftcertificate")) && GetConfig('EnableGiftCertificates') && gzte11(ISC_LARGEPRINT)) {
				$GLOBALS['ISC_CLASS_ADMIN_GIFTCERTIFICATES'] = GetClass('ISC_ADMIN_GIFTCERTIFICATES');
				$GLOBALS['ISC_CLASS_ADMIN_GIFTCERTIFICATES']->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "systeminfo"))) {
				$GLOBALS['ISC_CLASS_ADMIN_SYSINFO'] = GetClass('ISC_ADMIN_SYSINFO');
				$GLOBALS['ISC_CLASS_ADMIN_SYSINFO']->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "runaddon"))) {

				$GLOBALS['ISC_CLASS_ADMIN_ADDON'] = GetClass('ISC_ADMIN_ADDON');
				$GLOBALS["ISC_CLASS_ADMIN_ADDON"]->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "downloadaddons"))) {
				$GLOBALS['ISC_CLASS_ADMIN_DOWNLOADADDONS'] = GetClass('ISC_ADMIN_DOWNLOADADDONS');
				$GLOBALS['ISC_CLASS_ADMIN_DOWNLOADADDONS']->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "formfields"))) {
				$GLOBALS['ISC_CLASS_ADMIN_FORMFIELDS'] = GetClass('ISC_ADMIN_FORMFIELDS');
				$GLOBALS['ISC_CLASS_ADMIN_FORMFIELDS']->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "sales"))) {
				$GLOBALS['ISC_ADMIN_SALES'] = GetClass('ISC_ADMIN_SALES');
				$GLOBALS['ISC_ADMIN_SALES']->HandleToDo($ToDo);
			}
                        else if(is_numeric(isc_strpos($do, "rewrequest"))) {
				$GLOBALS['ISC_CLASS_ADMIN_REQUESTS'] = GetClass('ISC_ADMIN_REQUESTS');
				$GLOBALS['ISC_CLASS_ADMIN_REQUESTS']->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "customcontent"))) {
				$GLOBALS['ISC_CLASS_ADMIN_CUSTOMCONTENTS'] = GetClass('ISC_ADMIN_CUSTOMCONTENTS');
				$GLOBALS['ISC_CLASS_ADMIN_CUSTOMCONTENTS']->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "sitemap"))) {
				$GLOBALS['ISC_CLASS_ADMIN_SITEMAPS'] = GetClass('ISC_ADMIN_SITEMAPS');
				$GLOBALS['ISC_CLASS_ADMIN_SITEMAPS']->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "keyword"))) {
				$GLOBALS['ISC_CLASS_ADMIN_KEYWORDS'] = GetClass('ISC_ADMIN_KEYWORDS');
				$GLOBALS['ISC_CLASS_ADMIN_KEYWORDS']->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "abtestingcustom"))) {
				$GLOBALS['ISC_CLASS_ADMIN_PAGES'] = GetClass('ISC_ADMIN_ABTESTINGCUSTOMCONTENTS');
				$GLOBALS['ISC_CLASS_ADMIN_PAGES']->HandleToDo($ToDo);
			}
			else if(is_numeric(isc_strpos($do, "abtesting"))) {
				$GLOBALS['ISC_CLASS_ADMIN_PAGES'] = GetClass('ISC_ADMIN_ABTESTING');
				$GLOBALS['ISC_CLASS_ADMIN_PAGES']->HandleToDo($ToDo);
			}
		}
	}

?>
