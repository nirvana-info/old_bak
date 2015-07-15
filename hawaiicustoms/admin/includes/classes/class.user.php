<?php

	class ISC_ADMIN_USER
	{
		/**
		 * @var array An array of permissions that vendors are allowed to adjust.
		 */
		private $vendorOnlyPermissions = array(
			AUTH_Manage_Orders,
			AUTH_Edit_Orders,
			AUTH_Add_Orders,
			AUTH_Manage_Returns,
			AUTH_Manage_Customers,
			AUTH_Manage_Reviews,
			AUTH_Edit_Reviews,
			AUTH_Delete_Reviews,
			AUTH_Approve_Reviews,
			AUTH_Manage_Pages,
			AUTH_Add_Pages,
			AUTH_Edit_Pages,
			AUTH_Delete_Pages,
			AUTH_Manage_Products,
			AUTH_Create_Product,
			AUTH_Edit_Products,
			AUTH_Delete_Products,
			AUTH_Export_Products,
			AUTH_Manage_Variations,
			AUTH_Export_Orders,
			AUTH_Delete_Orders,
			AUTH_Order_Messages,
			AUTH_Statistics_Products,
			AUTH_Statistics_Orders,
			AUTH_Manage_Users,
			AUTH_Add_User,
			AUTH_Edit_Users,
			AUTH_Delete_Users,
			AUTH_Order_Messages,
			AUTH_Import_Order_Tracking_Numbers,
			AUTH_Manage_ExportTemplates
		);

		public function HandleToDo($Do)
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('users');

			switch(isc_strtolower($Do)) {
				case "copyuser":
				{
					if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Add_User)) {
						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Users') => "index.php?ToDo=viewUsers", GetLang('CopyUser') => "index.php?ToDo=copyUser");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->CopyUser();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					}
					else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}

					break;
				}
				case "edituser2":
				{
					if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Edit_Users)) {
						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Users') => "index.php?ToDo=viewUsers");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->EditUserStep2();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					}
					else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}

					break;
				}
				case "edituser":
				{
					if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Edit_Users)) {
						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Users') => "index.php?ToDo=viewUsers", GetLang('EditUser1') => "index.php?ToDo=editeUser");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->EditUserStep1();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					}
					else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}

					break;
				}
				case "createuser2":
				{
					if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Add_User)) {
						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Users') => "index.php?ToDo=viewUsers");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->AddUserStep2();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					}
					else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}

					break;
				}
				case "createuser":
				{
					if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Add_User)) {
						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Users') => "index.php?ToDo=viewUsers", GetLang('CreateUser') => "index.php?ToDo=createUser");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->AddUserStep1();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					}
					else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}

					break;
				}
				case "updateuserstatus":
				{
					if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Edit_Users)) {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->UpdateUserStatus();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					}
					else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}

					break;
				}
				case "deleteusers":
				{
					if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Delete_Users)) {
						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Users') => "index.php?ToDo=viewUsers");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->DeleteUsers();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					}
					else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}

					break;
				}
				default:
				{
					if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Users)) {
						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Users') => "index.php?ToDo=viewUsers");

						if(!isset($_REQUEST['ajax'])) {
							$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						}

						$this->ManageUsers();

						if(!isset($_REQUEST['ajax'])) {
							$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						}
					}
					else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
				}
			}
		}

		private function ManageUsersGrid(&$numUsers)
		{
			// Show a list of news in a table
			$page = 0;
			$start = 0;
			$numUsers = 0;
			$numPages = 0;
			$GLOBALS['UserGrid'] = "";
			$GLOBALS['Nav'] = "";
			$max = 0;

			if(isset($_GET['sortOrder']) && $_GET['sortOrder'] == 'desc') {
				$sortOrder = 'desc';
			}
			else {
				$sortOrder = "asc";
			}

			$sortLinks = array(
				"User" => "username",
				"Name" => "name",
				"Email" => "useremail",
				"Status" => "userstatus",
				"Vendor" => "vendorname"
			);

			if(isset($_GET['sortField']) && in_array($_GET['sortField'], $sortLinks)) {
				$sortField = $_GET['sortField'];
				SaveDefaultSortField("ManageUsers", $_REQUEST['sortField'], $sortOrder);
			}
			else {
				list($sortField, $sortOrder) = GetDefaultSortField("ManageUsers", "username", $sortOrder);
			}

			if(isset($_GET['page'])) {
				$page = (int)$_GET['page'];
			} else {
				$page = 1;
			}

			$sortURL = sprintf("&sortField=%s&sortOrder=%s", $sortField, $sortOrder);
			$GLOBALS['SortURL'] = $sortURL;

			// Limit the number of questions returned
			if($page == 1) {
				$start = 1;
			} else {
				$start = ($page * ISC_USERS_PER_PAGE) - (ISC_USERS_PER_PAGE-1);
			}

			$start = $start-1;

			// Get the results for the query
			$userResult = $this->_GetUserList($start, $sortField, $sortOrder, $numUsers);
			$numPages = ceil($numUsers / ISC_USERS_PER_PAGE);

			// Add the "(Page x of n)" label
			if($numUsers > ISC_USERS_PER_PAGE) {
				$GLOBALS['Nav'] = sprintf("(%s %d of %d) &nbsp;&nbsp;&nbsp;", GetLang('Page'), $page, $numPages);
				$GLOBALS['Nav'] .= BuildPagination($numUsers, ISC_USERS_PER_PAGE, $page, sprintf("index.php?ToDo=viewUsers%s", $sortURL));
			}
			else {
				$GLOBALS['Nav'] = "";
			}

			$GLOBALS['Nav'] = rtrim($GLOBALS['Nav'], ' |');
			$GLOBALS['SortField'] = $sortField;
			$GLOBALS['SortOrder'] = $sortOrder;

			$GLOBALS['HideVendorColumn'] = 'display: none';
			if(gzte11(ISC_HUGEPRINT) && !$GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
				$GLOBALS['HideVendorColumn'] = '';
			}

			BuildAdminSortingLinks($sortLinks, "index.php?ToDo=viewUsers&amp;page=".$page, $sortField, $sortOrder);

				// Workout the maximum size of the array
			$max = $start + ISC_USERS_PER_PAGE;

			if($max > count($userResult)) {
				$max = count($userResult);
			}

			if($numUsers > 0) {
				// Display the news
				while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($userResult)) {
					$GLOBALS['UserId'] = (int) $row['pk_userid'];

					if($row['vendorname']) {
						$GLOBALS['Vendor'] = "<a href='index.php?ToDo=editVendor&amp;vendorId=".$row['uservendorid']."'>".isc_html_escape($row['vendorname'])."</a>";
					}
					else {
						$GLOBALS['Vendor'] = GetLang('NA');
					}

					if($row['pk_userid'] == 1 || $row['username'] == "admin") {
						$GLOBALS['CheckDisabled'] = "DISABLED";
					} else {
						$GLOBALS['CheckDisabled'] = "";
					}

					if($row['name'] == " ") {
						$GLOBALS['Name'] = GetLang('NA');
					} else {
						$GLOBALS['Name'] = isc_html_escape($row['name']);
					}

					$GLOBALS['Username'] = isc_html_escape($row['username']);

					if(!$row['useremail']) {
						$GLOBALS['Email'] = GetLang('NA');
					}
					else {
						$GLOBALS['Email'] = sprintf("<a href='mailto:%s'>%s</a>", urlencode($row['useremail']), isc_html_escape($row['useremail']));
					}

					switch($row['userstatus'])
					{
						case 0: // Inactive
						{
							if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Edit_Users)) {
								$GLOBALS['Status'] = sprintf("<a title='%s' href='index.php?ToDo=updateUserStatus&amp;userId=%d&amp;status=1'><img border='0' src='images/cross.gif'></a>", GetLang('UserActiveTip'), $row['pk_userid']);
							} else {
								$GLOBALS['Status'] = "<img border='0' src='images/cross.gif'>";
							}

							break;
						}
						case 1: // Active
						{
							if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Edit_Users) && !($row['pk_userid'] == 1) ) {
								$GLOBALS['Status'] = sprintf("<a title='%s' href='index.php?ToDo=updateUserStatus&amp;userId=%d&amp;status=0'><img border='0' src='images/tick.gif'></a>", GetLang('UserInactiveTip'), $row['pk_userid']);
							} else {
								$GLOBALS['Status'] = "<img border='0' src='images/tick.gif'></a>";
							}

							break;
						}
					}

					// Can this account be edited?
					if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Edit_Users)) {
						$GLOBALS['EditUserLink'] = sprintf("<a title='%s' class='Action' href='index.php?ToDo=editUser&amp;userId=%d'>%s</a>", GetLang('EditUser'), $row['pk_userid'], GetLang('Edit'));
					}
					else {
						$GLOBALS['EditUserLink'] = sprintf("<a class='Action' disabled>%s</a>", GetLang('Edit'));
					}

					// Can this account be copied?
					if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Add_User)) {
						$GLOBALS['CopyUserLink'] = sprintf("<a title='%s' class='Action' href='index.php?ToDo=copyUser&amp;userId=%d'>%s</a>", GetLang('CopyUser'), $row['pk_userid'], GetLang('Copy'));
					}
					else {
						$GLOBALS['CopyUserLink'] = sprintf("<a class='Action' disabled>%s</a>", GetLang('Copy'));
					}


					$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("user.manage.row");
					$GLOBALS['UserGrid'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
				}
				$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("user.manage.grid");
				return $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
			}
		}

		public function ManageUsers($MsgDesc = "", $MsgStatus = "", $PendingUser = false)
		{
			// Fetch any results, place them in the data grid
			$numUsers = 0;
			$GLOBALS['UserDataGrid'] = $this->ManageUsersGrid($numUsers, $PendingUser);

			// Was this an ajax based sort? Return the table now
			if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 1) {
				echo $GLOBALS['UserDataGrid'];
				return;
			}

			if($MsgDesc != "") {
				$GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
			}

			// Do we need to disable the delete button?
			if(!$GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Delete_Users) || $numUsers == 0) {
				$GLOBALS['DisableDelete'] = "DISABLED";
			}

			$GLOBALS['UserIntro'] = GetLang('ManageUserIntro');

			if($numUsers == 0) {
				// There are no users in the database
				$GLOBALS['DisplayGrid'] = "none";
			}

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("user.manage");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}

		public function _GetUserList($Start, $SortField, $SortOrder, &$NumResults)
		{
			$queryWhere = '';
			if(isset($_REQUEST['vendorId'])) {
				$queryWhere .= " AND uservendorid='".(int)$_REQUEST['vendorId']."'";
			}

			if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
				$queryWhere .= " AND uservendorid='".(int)$GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()."'";
			}

			$query = "
				SELECT u.*, v.vendorname, CONCAT(userfirstname, ' ', userlastname) AS name
				FROM [|PREFIX|]users u
				LEFT JOIN [|PREFIX|]vendors v ON (u.uservendorid=v.vendorid)
			";

			$query .= "WHERE 1=1 ".$queryWhere;
			$query .= "ORDER BY ".$SortField." ".$SortOrder;
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$NumResults = $GLOBALS['ISC_CLASS_DB']->CountResult($result);

			// Add the limit
			$query .= $GLOBALS['ISC_CLASS_DB']->AddLimit($Start, ISC_USERS_PER_PAGE);

			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			return $result;
		}

		private function DeleteUsers()
		{
			if(isset($_POST['users'])) {
				$userids = implode(",", array_map('intval', $_POST['users']));
				$vendorRestriction = '';
				if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
					$vendorRestriction = " AND uservendorid='".(int)$GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()."'";
				}
				$query = sprintf("delete from [|PREFIX|]users where pk_userid in (%s) and pk_userid!=1".$vendorRestriction, $userids);
				$GLOBALS['ISC_CLASS_DB']->Query($query);
				$err = $GLOBALS['ISC_CLASS_DB']->_Error;

				if($err != "") {
					$this->ManageUsers($err, MSG_ERROR);
				} else {

					// Log this action
					$GLOBALS['ISC_CLASS_LOG']->LogAdminAction(count($_POST['users']));

					$this->ManageUsers(GetLang('UsersDeletedSuccessfully'), MSG_SUCCESS);
				}
			}
			else {
				if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Users)) {
					$this->ManageUsers();
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
				}
			}
		}

		private function UpdateUserStatus()
		{
			// Update the status of a user with a simple query
			$userId = (int)$_GET['userId'];
			$status = (int)$_GET['status'];

			$updatedUser = array(
				"userstatus" => $status
			);
			$vendorRestriction = '';
			if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
				$vendorRestriction = " AND uservendorid='".(int)$GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()."'";
			}
			$GLOBALS['ISC_CLASS_DB']->UpdateQuery("users", $updatedUser, "pk_userid='".$GLOBALS['ISC_CLASS_DB']->Quote($userId)."'".$vendorRestriction);
			if ($GLOBALS['ISC_CLASS_DB']->_Error == "") {
				if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Users)) {
					$query = sprintf("SELECT username FROM [|PREFIX|]users WHERE pk_userid='%d'", $userId);
					$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
					$userName = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);

					// Log this action
					$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($userId, $userName);

					$this->ManageUsers(GetLang('UserStatusSuccessfully'), MSG_SUCCESS);
				}
				else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('UserStatusSuccessfully'), MSG_SUCCESS);
				}
			}
			else {
				$err = '';
				if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Users)) {
					$this->ManageUsers(sprintf(GetLang('ErrUserStatusNotChanged'), $err), MSG_ERROR);
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(sprintf(GetLang('ErrUserStatusNotChanged'), $err), MSG_ERROR);
				}
			}
		}

		private function AddUserStep1()
		{
			if($message = str_strip($_REQUEST, '#')) {
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoError(GetLang(B('UmVhY2hlZFVzZXJMaW1pdA==')), $message, MSG_ERROR);
				exit;
			}

			$GLOBALS['FormAction'] = "createUser2";
			$GLOBALS['Title'] = GetLang('CreateUser');
			$GLOBALS['PassReq'] = "<span class='Required'>*</span>";
			$GLOBALS['Adding'] = 1;
			$GLOBALS['XMLPath'] = sprintf("%s/xml.php", $GLOBALS['ShopPath']);

			if(!gzte11(ISC_HUGEPRINT)) {
				$GLOBALS['HideVendorOptions'] = 'display: none';
			}
			else {
				if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
					$vendorDetails = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendor();
					$GLOBALS['HideVendorSelect'] = 'display: none';
					$GLOBALS['Vendor'] = $vendorDetails['vendorname'];
					$GLOBALS['HideAdminoptions'] = 'display: none';
				}
				else {
					$GLOBALS['VendorList'] = $this->GetVendorList();
					$GLOBALS['HideVendorLabel'] = 'display: none';
				}
			}

			$constants = get_defined_constants();
            $defaultFalseAuth = array(
                'AUTH_Login_Customers',
                'AUTH_Reset_Price'
            );
			foreach($constants as $constant=>$v) {
				if(is_numeric(strpos($constant, "AUTH_")) && strpos($constant, "AUTH_") == 0 && !in_array($constant, $defaultFalseAuth)) {
					$GLOBALS["Selected_" . $v] = "selected='selected'";
				}
			}

			if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
				$role = 'vendor';
			}
			else {
				$role = 'admin';
			}
			$GLOBALS['UserRoleOptions'] = $this->GetUserRoleOptions($role);

			$GLOBALS['UserRoleSelectedAdmin'] = 'selected="selected"';
			$GLOBALS['HidePermissionSelects'] = 'display: none';

			/* Added below condition for applying store credit permission - vikas */
			$loggeduser = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetUser();
			
			$GLOBALS['StoreCreditActive0'] = 'selected="selected"';
			if( $loggeduser['pk_userid'] != 1 )
			{
				$GLOBALS['StoreCreditDisable'] = " disabled=\"\" ";
			}
			
			$GLOBALS['StoreCreditPermission'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("StoreCreditPerm");

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("user.form");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}

		private function AddUserStep2()
		{
			if($message = str_strip($_REQUEST, '#')) {
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoError(GetLang(B('UmVhY2hlZFVzZXJMaW1pdA==')), $message, MSG_ERROR);
				exit;
			}

			// Get the information from the form and add it to the database
			$arrData = array();
			$arrPerms = array();
			$err = "";

			$this->_GetUserData(0, $arrData);
			$this->_GetPermissionData(0, $arrPerms);

			// Make sure the selected username is available
			if($this->_UsernameIsAvailable($arrData['username'])) {
				// The username is available, commit the data
				if($this->_CommitUser(0, $arrData, $arrPerms, $err)) {
					// Log this action
					$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($arrData['username']);

					if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Users)) {
						$this->ManageUsers(GetLang('UserAddedSuccessfully'), MSG_SUCCESS);
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('UserAddedSuccessfully'), MSG_SUCCESS);
					}
				}
				else {
					if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Users)) {
						$this->ManageUsers(sprintf(GetLang('ErrUserNotAdded'), $err), MSG_ERROR);
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(sprintf(GetLang('ErrUserNotAdded'), $err), MSG_ERROR);
					}
				}
			}
			else {
				// The selected username is taken
				if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Users)) {
					$this->ManageUsers(sprintf(GetLang('ErrUsernameTaken'), isc_html_escape($arrData['username'])), MSG_ERROR);
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(sprintf(GetLang('ErrUsernameTaken'), $err), MSG_ERROR);
				}
			}
		}

		private function _GenerateUserPass()
		{
			// Generate a random string which is used as a password during the installer
			$token = "";

			for($i = 0; $i < rand(8, 12); $i++) {
				if(rand(1, 2) == 1) {
					$token .= chr(rand(65, 90));
				} else {
					$token .= chr(rand(48, 57));
				}
			}

			return $token;
		}

		public function _GenerateUserToken()
		{
			// Generate a random string which is used to store user credentials in the session
			$token = "";

			for($i = 0; $i < rand(20, 40); $i++) {
				if(rand(1, 2) == 1) {
					$token .= chr(rand(65, 90));
				} else {
					$token .= chr(rand(48, 57));
				}
			}

			return $token;
		}

		public function _CommitUser($UserId, &$Data, &$Perms, &$Err)
		{
			// Commit the details for the user account to the database
			$queries = array();
			$query = "";
			$err = null;

			if($UserId == 0) {
				// ----- Build the query for the user table -----

				$newUser = array(
					"username" => $Data['username'],
					"userpass" => $Data['userpass'],
					"userfirstname" => $Data['userfirstname'],
					"userlastname" => $Data['userlastname'],
					"userstatus" => (int)$Data['userstatus'],
					"useremail" => $Data['useremail'],
					"token" => $this->_GenerateUserToken(),
					"usertoken" => $Data['usertoken'],
					"userapi" => $Data['userapi'],
					'userrole' => $Data['userrole'],
					"userstorecreditperm" => (int)$Data['userstorecreditperm'] // added condition for applying store credit permission - vikas
				);

				if(gzte11(ISC_HUGEPRINT)) {
					$newUser['uservendorid'] = $Data['uservendorid'];
				}

				$UserId = $GLOBALS['ISC_CLASS_DB']->InsertQuery("users", $newUser);

				// Now build the permissions queries
				foreach($Perms as $p) {
					// Skip any permissions we don't have access to adjust
					if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() > 0 && !in_array($p, $this->vendorOnlyPermissions)) {
						continue;
					}
					$newPermission = array(
						"permuserid" => $UserId,
						"permpermissionid" => $p
					);
					$GLOBALS['ISC_CLASS_DB']->InsertQuery("permissions", $newPermission);
				}
			}
			else {
				$this->_GetUserData($UserId, $existingUser);
				$updatedUser = array(
					"usertoken" => $Data['usertoken'],
					"userapi" => $Data['userapi'],
					"userfirstname" => $Data['userfirstname'],
					"userlastname" => $Data['userlastname'],
					"useremail" => $Data['useremail']
				);

				if (isset($Data['userstatus'])) {
					$updatedUser['userstatus'] = (int)$Data['userstatus'];//zcs=
				}

				/* Added below condition for applying store credit permission - vikas */
				if (isset($Data['userstorecreditperm'])) {
					$updatedUser['userstorecreditperm'] = (int)$Data['userstorecreditperm'];
				}

				if(isset($Data['userrole'])) {
					$updatedUser['userrole'] = $Data['userrole'];
				}

				if(gzte11(ISC_HUGEPRINT) && $UserId > 1) {
					$updatedUser['uservendorid'] = $Data['uservendorid'];
				}

				// Update the existing news post details. Firstly check the userId.
				// If it's 1 we're updating the super admin account
				if($UserId >= 1) {
					$updatedUser['username'] = $Data['username'];
				}

				// Does the user want to change the password?
				if(isset($Data['userpass']) && $Data['userpass'] != "") {
					$updatedUser['userpass'] = $Data['userpass'];
				}

				$GLOBALS['ISC_CLASS_DB']->UpdateQuery("users", $updatedUser, "pk_userid='".$GLOBALS['ISC_CLASS_DB']->Quote($UserId)."'");

				// Setup the permissions queries for non super admin users only
				if($UserId != 1 && $updatedUser['username'] != "admin") {
					$query = sprintf("delete from [|PREFIX|]permissions where permuserid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($UserId));
					$GLOBALS['ISC_CLASS_DB']->Query($query);

					// Now build the permissions queries
					foreach($Perms as $p) {
						// Skip any permissions we don't have access to adjust
						if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() > 0 && !in_array($p, $this->vendorOnlyPermissions)) {
							continue;
						}
						$newPermission = array(
							"permuserid" => $UserId,
							"permpermissionid" => $p
						);
						$GLOBALS['ISC_CLASS_DB']->InsertQuery("permissions", $newPermission);
					}
				}
			}

			$err = $GLOBALS['ISC_CLASS_DB']->_Error;
			$Err = $err;

			if(is_null($err) || $err == "") {
				return true;
			} else {
				return false;
			}
		}

		private function _UsernameIsAvailable($Username)
		{
			$Username = isc_strtolower($Username);
			$query = sprintf("select pk_userid from [|PREFIX|]users where lower(username)='%s'", $GLOBALS['ISC_CLASS_DB']->Quote($Username));
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			if ($GLOBALS['ISC_CLASS_DB']->CountResult($result) == 0) {
				return true;
			} else {
				return false;
			}
		}

		private function _GetPermissionData($UserId, &$RefArray)
		{
			// Get the permissions for this user
			if ($UserId == 0) {
				// Get the user permissions from the form
				if(isset($_POST['permissions']) && is_array($_POST['permissions'])) {
					foreach($_POST['permissions'] as $type) {
						foreach($type as $p) {
							$RefArray[] = $p;
						}
					}
					sort($RefArray, SORT_NUMERIC);
				}
			} else {
				$query = sprintf("select * from [|PREFIX|]permissions where permuserid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($UserId));
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

				while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					$RefArray[] = $row['permpermissionid'];
				}
			}
		}

		private function _GetUserData($UserId, &$RefArray)
		{
			// Get the data for the user and return it
			if ($UserId == 0) {
				// Get the details for the user from the form
				if (isset($_POST['userId']) && is_numeric($_POST['userId'])) {
					$RefArray['pk_userid'] = $_POST['userId'];
				} else {
					$RefArray['pk_userid'] = 0;
				}

				if (isset($_POST['username'])) {
					$RefArray['username'] = $_POST['username'];
				}

				if(isset($_POST['userpass']) && $_POST['userpass'] != '') {
					$RefArray['userpass'] = md5($_POST['userpass']);
				}

				$RefArray['useremail'] = $_POST['useremail'];
				$RefArray['userfirstname'] = $_POST['userfirstname'];
				$RefArray['userlastname'] = $_POST['userlastname'];

				if (isset($_POST['userstatus'])) {
					$RefArray['userstatus'] = $_POST['userstatus'];
				}

				if (isset($_POST['userstorecreditperm'])) {
					$RefArray['userstorecreditperm'] = $_POST['userstorecreditperm'];
				}

				if(isset($_POST['userrole'])) {
					$RefArray['userrole'] = $_POST['userrole'];
				}

				if(isset($_POST['userapi'])) {
					$RefArray['userapi'] = 1;
					$RefArray['usertoken'] = $_POST['xmltoken'];
				}
				else {
					$RefArray['userapi'] = 0;
					$RefArray['usertoken'] = $_POST['xmltoken'];
				}

				$RefArray['uservendorid'] = 0;
				if(gzte11(ISC_HUGEPRINT)) {
					if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
						$RefArray['uservendorid'] = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId();
					}
					else {
						$RefArray['uservendorid'] = (int)$_POST['uservendorid'];
					}
				}
			}
			else {
				// Get the details from the database
				$query = sprintf("select * from [|PREFIX|]users where pk_userid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($UserId));
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

				if($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					$RefArray = $row;
				}
			}
		}

		private function EditUserStep1()
		{
			// Show the form to edit a news
			$userId = (int)$_GET['userId'];
			$arrData = array();
			$arrPerms = array();

			if(UserExists($userId)) {
				$this->_GetUserData($userId, $arrData);
				$this->_GetPermissionData($userId, $arrPerms);

				// Does this user have permission to edit this user?
				if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() && $arrData['uservendorid'] != $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
					FlashMessage(GetLang('Unauthorized'), MSG_ERROR, 'index.php?ToDo=viewUsers');
				}

				$GLOBALS['Username'] = isc_html_escape($arrData['username']);
				$GLOBALS['UserEmail'] = isc_html_escape($arrData['useremail']);
				$GLOBALS['UserFirstName'] = isc_html_escape($arrData['userfirstname']);
				$GLOBALS['UserLastName'] = isc_html_escape($arrData['userlastname']);

				$GLOBALS['XMLPath'] = sprintf("%s/xml.php", $GLOBALS['ShopPath']);
				$GLOBALS['XMLToken'] = isc_html_escape($arrData['usertoken']);

				if(!gzte11(ISC_HUGEPRINT)) {
					$GLOBALS['HideVendorOptions'] = 'display: none';
				}
				else {
					if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
						$vendorDetails = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendor();
						$GLOBALS['HideVendorSelect'] = 'display: none';
						$GLOBALS['Vendor'] = $vendorDetails['vendorname'];
						$GLOBALS['HideAdminoptions'] = 'display: none';
					}
					else {
						$GLOBALS['VendorList'] = $this->GetVendorList($arrData['uservendorid']);
						$GLOBALS['HideVendorLabel'] = 'display: none';
					}
				}

				if($arrData['userapi'] == "1") {
					$GLOBALS['IsXMLAPI'] = 'checked="checked"';
				}

				if($arrData['userstatus'] == 0) {
					$GLOBALS['Active0'] = 'selected="selected"';
				} else {
					$GLOBALS['Active1'] = 'selected="selected"';
				}

				// Setup the permission check boxes
				foreach($arrPerms as $k=>$v) {
					$GLOBALS["Selected_" . $v] = "selected='selected'";
				}

				if($arrData['userrole'] && $arrData['userrole'] != 'custom') {
					$GLOBALS['HidePermissionSelects'] = 'display: none';
				}

				// If the user is the super admin we need to disable some fields
				if($userId == 1 || $arrData['username'] == "admin") {
					$GLOBALS['DisableUser'] = "DISABLED";
					$GLOBALS['DisableStatus'] = "DISABLED";
					$GLOBALS['DisableUserType'] = "DISABLED";
					$GLOBALS['DisablePermissions'] = "DISABLED";
					$GLOBALS['HideVendorOptions'] = 'display: none';
				}

				$GLOBALS['UserRoleOptions'] = $this->GetUserRoleOptions($arrData['userrole'], $arrData['uservendorid']);

				$GLOBALS['UserId'] = (int) $userId;
				$GLOBALS['FormAction'] = "editUser2";
				$GLOBALS['Title'] = GetLang('EditUser1');
				$GLOBALS['PassReq'] = "&nbsp;&nbsp;";

				/* Added below condition for applying store credit permission - vikas */
				$loggeduser = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetUser();
				
				if((int)$arrData['userstorecreditperm'] == 0) {
					$GLOBALS['StoreCreditActive0'] = 'selected="selected"';
				} else {
					$GLOBALS['StoreCreditActive1'] = 'selected="selected"';
				}

				if( $userId == 1 || $loggeduser['pk_userid'] != 1 )
				{
					$GLOBALS['StoreCreditDisable'] = " disabled=\"\" ";
				}

				$GLOBALS['StoreCreditPermission'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("StoreCreditPerm");

				$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("user.form");
				$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
			}
			else {
				// The news post doesn't exist
				if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Users)) {
					$this->ManageUsers(GetLang('UserDoesntExist'), MSG_ERROR);
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
				}
			}
		}

		private function EditUserStep2()
		{
			// Get the information from the form and add it to the database
			$userId = $_POST['userId'];
			$arrData = array();
			$arrPerms = array();
			$err = "";
			$arrUserData = array();

			$this->_GetUserData($userId, $arrUserData);

			// Does this user have permission to edit this user?
			if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() && $arrUserData['uservendorid'] != $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
				FlashMessage(GetLang('Unauthorized'), MSG_ERROR, 'index.php?ToDo=viewUsers');
			}

			$this->_GetUserData(0, $arrData);
			if($arrUserData['pk_userid'] == 1 || $arrUserData['username'] == "admin") {
				$arrData['username'] = "admin";
			}

			$this->_GetPermissionData(0, $arrPerms);

			// Commit the values to the database
			if($this->_CommitUser($userId, $arrData, $arrPerms, $err)) {
				// Log this action
				if(!isset($arrData['username'])) {
					$arrData['username'] = 'admin';
				}

				$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($userId, $arrData['username']);

				if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Users)) {
					$this->ManageUsers(GetLang('UserUpdatedSuccessfully'), MSG_SUCCESS);
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('UserUpdatedSuccessfully'), MSG_SUCCESS);
				}
			}
			else {
				if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Users)) {
					$this->ManageUsers(sprintf(GetLang('ErrUserNotUpdated'), $err), MSG_ERROR);
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(sprintf(GetLang('ErrUserNotUpdated'), $err), MSG_ERROR);
				}
			}
		}

		private function GetUserRoleOptions($selectedRole='custom', $vendorId=0)
		{
			$userRoles = array();
			if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() == 0) {
				$userRoles['sales'] = GetLang('UserRoleSales');
				$userRoles['manager'] = GetLang('UserRoleManager');
			}

			if(gzte11(ISC_HUGEPRINT)) {
				$userRoles['vendor'] = GetLang('UserRoleVendor');
				$userRoles['vendoradmin'] = GetLang('UserRoleVendorAdmin');
			}

			if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() == 0) {
				$userRoles['admin'] = GetLang('UserRoleAdmin');
				$userRoles['custom'] = GetLang('UserRoleCustom');
			}

			$roleList = '';
			foreach($userRoles as $role => $label) {
				$sel = '';
				if($selectedRole == $role) {
					$sel = 'selected="selected"';
				}
				$roleList .= '<option value="'.$role.'" '.$sel.'>'.isc_html_escape($label).'</option>';
			}
			return $roleList;

		}

		private function CopyUser()
		{
			if($message = str_strip($_REQUEST, '#')) {
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoError(GetLang(B('UmVhY2hlZFVzZXJMaW1pdA==')), $message, MSG_ERROR);
				exit;
			}

			$userId = $_GET['userId'];
			$arrData = array();
			$arrPerms = array();

			$this->_GetUserData($userId, $arrData);

			// Does this user have permission to edit this user?
			if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() && $arrUserData['uservendorid'] != $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
				FlashMessage(GetLang('Unauthorized'), MSG_ERROR, 'index.php?ToDo=viewUsers');
			}

			$this->_GetPermissionData($userId, $arrPerms);

			// Setup the permission check boxes
			foreach($arrPerms as $k=>$v) {
				$GLOBALS["Selected_" . $v] = "selected='selected'";
			}

			$GLOBALS['Username'] = "";
			$GLOBALS['UserEmail'] = $arrData['useremail'];
			$GLOBALS['UserFirstName'] = $arrData['userfirstname'];
			$GLOBALS['UserLastName'] = $arrData['userlastname'];

			if($arrData['userstatus'] == 0) {
				$GLOBALS['Active0'] = 'selected="selected"';
			} else {
				$GLOBALS['Active1'] = 'selected="selected"';
			}

			// Setup the permission check boxes
			foreach($arrPerms as $k=>$v) {
				$GLOBALS["Check_" . $v] = 'checked="checked"';
			}

			if($arrData['userrole'] && $arrData['userrole'] != 'custom') {
				$GLOBALS['HidePermissionSelects'] = 'display: none';
			}

			if(!gzte11(ISC_HUGEPRINT)) {
				$GLOBALS['HideVendorOptions'] = 'display: none';
			}
			else {
				if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
					$vendorDetails = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendor();
					$GLOBALS['HideVendorSelect'] = 'display: none';
					$GLOBALS['Vendor'] = $vendotDetails['vendorname'];
				}
				else {
					$GLOBALS['VendorList'] = $this->GetVendorList($arrData['uservendorid']);
					$GLOBALS['HideVendorLabel'] = 'display: none';
				}
			}

			$GLOBALS['UserRoleOptions'] = $this->GetUserRoleOptions($arrData['userrole'], $arrData['uservendorid']);

			$GLOBALS['FormAction'] = "createUser2";
			$GLOBALS['Title'] = GetLang('CopyUser');
			$GLOBALS['PassReq'] = "<span class='Required'>*</span>";
			$GLOBALS['Adding'] = 1;
			$GLOBALS['UserId'] = "";

			/* Added below condition for applying store credit permission - vikas */
			$loggeduser = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetUser();
			
			if((int)$arrData['userstorecreditperm'] == 0) {
				$GLOBALS['StoreCreditActive0'] = 'selected="selected"';
			} else {
				$GLOBALS['StoreCreditActive1'] = 'selected="selected"';
			}

			if( $loggeduser['pk_userid'] != 1 )
			{
				$GLOBALS['StoreCreditDisable'] = " disabled=\"\" ";
			}
			
			$GLOBALS['StoreCreditPermission'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("StoreCreditPerm");

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("user.form");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}

		public function GetVendorList($selected=0)
		{
			$list = '';
			$query = "SELECT vendorname, vendorid FROM [|PREFIX|]vendors ORDER BY vendorname ASC";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			while($vendor = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$sel = '';
				if($selected == $vendor['vendorid']) {
					$sel = 'selected="selected"';
				}
				$list .= '<option value="'.$vendor['vendorid'].'" '.$sel.'>'.isc_html_escape($vendor['vendorname']).'</option>';
			}
			return $list;
		}
	}

?>