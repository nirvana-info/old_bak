<?php

	class ISC_ADMIN_ENGINE
	{
		public $stylesheets = array();

		public function HandlePage()
		{
			// Should we redirect to the setup script?
			if (GetConfig('isSetup') == false) {
				header("Location: index.php");
				die();
			}

			if (isset($_REQUEST['ToDo'])) {
				$ToDo = $_REQUEST['ToDo'];
			} else {
				$ToDo = "";
			}

			if (isset($_COOKIE['RememberToken']) && !isset($_GET['ToDo']) && !isset($_COOKIE['logout'])) {
				$_POST['remember'] = "1";
				$GLOBALS['ISC_CLASS_ADMIN_AUTH']->ProcessLogin();
				die();
			} else {
				if (!isset($_COOKIE["STORESUITE_CP_TOKEN"]) && $ToDo != "processLogin" && $ToDo != "forgotPass" && $ToDo != "sendPassEmail" && $ToDo != "confirmPasswordChange" && $ToDo != "firstTimeLogin" && $ToDo != "drawLogo") {
					unset($_COOKIE['logout']);
					$GLOBALS['ISC_CLASS_ADMIN_AUTH']->DoLogin();
					die();
				}
			}

			// Get the permissions for this user
			$arrPermissions = $GLOBALS["ISC_CLASS_ADMIN_AUTH"]->GetPermissions();

			switch ($ToDo) {
				case 'processLogin':
					$GLOBALS['ISC_CLASS_ADMIN_AUTH']->ProcessLogin();
					break;
				case 'forgotPass':
					$GLOBALS['ISC_CLASS_ADMIN_AUTH']->ForgotPass();
					break;
				case 'confirmPasswordChange':
					$GLOBALS['ISC_CLASS_ADMIN_AUTH']->ConfirmPass();
					break;
				case 'sendPassEmail':
					$GLOBALS['ISC_CLASS_ADMIN_AUTH']->SendForgotPassEmail();
					break;
				case 'logOut':
					$GLOBALS['ISC_CLASS_ADMIN_AUTH']->LogOut();
					break;
				case 'HelpRSS':
					$this->LoadHelpRSS();
					break;
				default:
				{
					if (!in_arrays($ToDo)) {
						// No permissions? Log them out and throw them to the login page
						if (empty($arrPermissions)) {
							$GLOBALS['ISC_CLASS_ADMIN_AUTH']->LogOut();
							die();
						}

						if (!empty($ToDo)) {
							$GLOBALS['ISC_CLASS_ADMIN_AUTH']->HandleSTSToDo($ToDo);
						}
						else {
							$class = GetClass('ISC_ADMIN_INDEX');
							$class->HandleToDo();
						}
					}
				}
			}
		}

		/**
		* Load the help RSS feed to show on the home page
		*
		* @return void
		*/
		public function LoadHelpRSS()
		{
			if(!GetConfig('LoadPopularHelpArticles')) {
				exit;
			}

			$GLOBALS['ISC_CLASS_PAGE'] = GetClass('ISC_PAGE');
			$contents = $GLOBALS['ISC_CLASS_PAGE']->_LoadFeed(GetConfig('HelpRSS'), 5, 86400, "admin-help.xml","PageRSSItemHelp", true);

			if ($contents === false) {
				echo GetLang('ErrorLoadingFeed');
				return;
			}

			echo "<ul>";
			echo $contents;
			echo "</ul>";
		}



		/**
		* Display the home page
		*
		* @param string $MsgDesc The text of the message to display
		* @param integer $MsgStatus The type of message (MSG_ERROR, MSG_INFO, MSG_SUCCESS)
		*
		* @return void
		*/
		public function DoHomePage($MsgDesc = "", $MsgStatus = "")
		{
			if($MsgDesc) {
				FlashMessage($MsgDesc, $MsgStatus);
			}

			ob_end_clean();
			header('Location: index.php');
			exit;
		}

		public function DoError($MsgTitle = "", $MsgDesc = "", $MsgStatus = "")
		{
			if ($MsgTitle == "") {
				$GLOBALS['ErrorTitle'] = GetLang('Error');
			}
			else {
				$GLOBALS['ErrorTitle'] = $MsgTitle;
			}
			$GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
			$this->PrintHeader();
			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("error");
			$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
			$this->PrintFooter();
		}

		public function PrintHeader()
		{
			if (isset($this->DoneHeader)) {
				return;
			}

			if(isset($GLOBALS['LKN']) && $GLOBALS['LKN']) {
				$GLOBALS['WarningNotices'] = '<p class="WarningNotice">'.GetLang('ControlPanelLKNWarning').'</p>';
			}

			if(defined('CONTROL_PANEL_WARNING_MSG') && CONTROL_PANEL_WARNING_MSG != '') {
				$GLOBALS['WarningNotices'] = '<p class="WarningNotice">'.CONTROL_PANEL_WARNING_MSG.'</p>';
			}

			$this->DoneHeader = true;

			$GLOBALS['AdditionalStylesheets'] = '';
			foreach($this->stylesheets as $stylesheet) {
				$GLOBALS['AdditionalStylesheets'] .= "@import url('".$stylesheet."');";
			}

			$GLOBALS['textLinks'] = "";
			$GLOBALS['menuRow'] = "";
			$GLOBALS['menuScript'] = "";
			$GLOBALS['menuTable'] = "";

			$user = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetUser();

			$GLOBALS['CurrentlyLoggedInAs'] = sprintf(GetLang('CurrentlyLoggedInAs'), isc_html_escape($user['username']));

			if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->IsLoggedIn()) {
				// Get an array of permissions for the selected user
				$arrPermissions = $GLOBALS["ISC_CLASS_ADMIN_AUTH"]->GetPermissions();

				$GLOBALS['textLinks'] = "<div class='MenuText'>";

				if(gzte11(ISC_HUGEPRINT)) {
					$usersMenu = array(
						'text' => GetLang('Users'),
						'show' => in_array(AUTH_Manage_Users, $arrPermissions) || in_array(AUTH_Manage_Vendors, $arrPermissions),
						'items' => array(
							array(
								'link' => 'index.php?ToDo=viewUsers',
								'text' => GetLang('Users'),
								'show' => in_array(AUTH_Manage_Users, $arrPermissions)
							),
							array(
								'link' => 'index.php?ToDo=viewVendors',
								'text' => GetLang('Vendors'),
								'show' => in_array(AUTH_Manage_Vendors, $arrPermissions) && !$GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()
							),
							array(
								'link' => 'index.php?ToDo=editVendor&vendorId='.$GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId(),
								'text' => GetLang('VendorProfile'),
								'show' => $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()
							),
						)
					);
				}
				else {
					$usersMenu = array(
						'link' => 'index.php?ToDo=viewUsers',
						'text' => GetLang('Users'),
						'show' => in_array(AUTH_Manage_Users, $arrPermissions)
					);
				}
				$menuItems = array(
					'mnuHome' => array(
						'link' => 'index.php',
						'text' => GetLang('Home')
					),
					'mnuAddons' => array(
						'link' => 'index.php?ToDo=viewDownloadAddons',
						'text' => GetLang('Addons'),
						'show' => in_array(AUTH_Manage_Addons, $arrPermissions),
						'items' => array(
							array(
								'link' => 'index.php?ToDo=viewDownloadAddons',
								'text' => GetLang('ViewAddons'),
							),
							array(
								'link' => 'index.php?ToDo=viewAddonSettings',
								'text' => GetLang('AddonSettings'),
							),
						)
					),
					'mnuTemplates' => array(
						'link' => 'index.php?ToDo=viewTemplates',
						'text' => GetLang('Templates'),
						'show' => in_array(AUTH_Manage_Templates, $arrPermissions)
					),
					'mnuUsers' => $usersMenu,
					'mnuTools' => array(
						'link' => '',
						'text' => GetLang('Tools'),
						'items' => array(
							array(
								'link' => 'index.php?ToDo=viewBackups',
								'text' => GetLang('ViewBackups'),
								'show' => (!GetConfig('DisableBackupSettings') && in_array(AUTH_Manage_Backups, $arrPermissions) && gzte11(ISC_MEDIUMPRINT))
							),
							array(
								'link' => 'index.php?ToDo=viewFormFields',
								'text' => GetLang('FormFields'),
								'show' => (in_array(AUTH_Manage_FormFields, $arrPermissions) || in_array(AUTH_Add_FormFields, $arrPermissions)) && gzte11(ISC_MEDIUMPRINT)
							),
							array(
								'link' => 'index.php?ToDo=viewVendorPayments',
								'text' => GetLang('VendorPayments'),
								'show' => in_array(AUTH_Manage_Vendors, $arrPermissions) && gzte11(ISC_HUGEPRINT)
							),
							array(
								'break' => true
							),
							array(
								'link' => 'index.php?ToDo=Converter',
								'text' => GetLang('StoreImporter'),
								'show' => (!GetConfig('DisableStoreImporters') && in_array(AUTH_Store_Importer, $arrPermissions) && file_exists(APP_ROOT."/includes/converter/class.converter.php"))
							),
							array(
								'link' => 'index.php?ToDo=Exporter',
								'text' => GetLang('StoreExporter'),
								'show' => (!GetConfig('DisableStoreImporters') && in_array(AUTH_Store_Exporter, $arrPermissions) && file_exists(APP_ROOT."/includes/converter/class.exporter.php"))
							),
							array(
								'break' => true
							),
							array(
								'link' => 'index.php?ToDo=viewExportTemplates',
								'text' => GetLang('ExportTemplates'),
								'show' => gzte11(ISC_MEDIUMPRINT)
							),
							array(
								'link' => 'index.php?ToDo=viewImportTemplates',
								'text' => GetLang('ImportTemplates'),
								'show' => gzte11(ISC_MEDIUMPRINT)
							),
							array(
								'break' => true
							),
							array(
								'link' => 'index.php?ToDo=systemLog',
								'text' => GetLang('StoreLogs'),
								'show' => in_array(AUTH_Manage_Logs, $arrPermissions)
							),
							array(
								'link' => 'index.php?ToDo=systemInfo',
								'text' => GetLang('SystemInfo'),
								'show' => in_array(AUTH_System_Info, $arrPermissions) && !GetConfig('DisableSystemInfo')
							),
                            array(
                                'break' => true
                            ),
                            array(
                                'link' => 'index.php?ToDo=manageDefect',
                                'text' => GetLang('ManageDefect'),
                                'show' => in_array(AUTH_System_Info, $arrPermissions) && !GetConfig('DisableSystemInfo')
                            ),
						)
					),
					'mnuSettings' => array(
						'link' => '',
						'text' => GetLang('Settings'),
						'show' => in_array(AUTH_Manage_Settings, $arrPermissions),
						'items' => array(
							array(
								'link' => 'index.php?ToDo=viewSettings',
								'text' => GetLang('StoreSettings')
							),
							array(
								'link' => 'index.php?ToDo=viewShippingSettings',
								'text' => GetLang('ShippingSettings')
							),
							array(
								'link' => 'index.php?ToDo=viewTaxSettings',
								'text' => GetLang('TaxSettings')
							),
							array(
								'link' => 'index.php?ToDo=viewCurrencySettings',
								'text' => GetLang('CurrencySettings')
							),
							array(
								'link' => 'index.php?ToDo=viewCheckoutSettings',
								'text' => GetLang('CheckoutSettings')
							),
							array(
								'link' => 'index.php?ToDo=viewAccountingSettings',
								'text' => GetLang('AccountingSettings'),
								'show' => gzte11(ISC_MEDIUMPRINT)
							),
                            array(
                                'link' => 'index.php?ToDo=viewScriptSettings',
                                'text' => GetLang('OrderSettings'),
                                'show' => gzte11(ISC_MEDIUMPRINT)
                            ),
							array(
								'break' => true
							),
							array(
								'link' => 'index.php?ToDo=viewGiftCertificateSettings',
								'text' => GetLang('GiftCertificateSettings'),
								'show' => gzte11(ISC_LARGEPRINT)
							),
							array(
								'link' => 'index.php?ToDo=viewAnalyticsSettings',
								'text' => GetLang('AnalyticsSettings')
							),
							array(
								'link' => 'index.php?ToDo=viewAffiliateSettings',
								'text' => GetLang('AffiliateSettings')
							),
							array(
								'link' => 'index.php?ToDo=viewNotificationSettings',
								'text' => GetLang('NotificationSettings')
							),
							array(
								'link' => 'index.php?ToDo=viewLiveChatSettings',
								'text' => GetLang('LiveChatSettings')
							),
							array(
								'link' => 'index.php?ToDo=viewReturnsSettings',
								'text' => GetLang('ReturnsSettings'),
								'show' => gzte11(ISC_LARGEPRINT)
							),
							array(
								'link' => 'index.php?ToDo=viewGiftWrapping',
								'text' => GetLang('GiftWrappingSettings'),
							),
							array(
								'break' => true,
								'show' => (!GetConfig('DisableSendStudioIntegration') || !GetConfig('DisableKnowledgeManagerIntegration'))
							),
							array(
								'link' => 'index.php?ToDo=viewMailSettings',
								'text' => GetLang('MailSettings'),
								'show' => !GetConfig('DisableSendStudioIntegration')
							),
							array(
								'link' => 'index.php?ToDo=viewKBSettings',
								'text' => GetLang('KBSettings'),
								'show' => !GetConfig('DisableKnowledgeManagerIntegration')
							),
							array(
								'break' => true
							),
                            array(
                                'link' => 'index.php?ToDo=viewBedsizeSettings',
                                'text' => GetLang('ManageBed'),
                            )
						)
					),
					'mnuLogout' => array(
						'link' => 'index.php?ToDo=logOut',
						'text' => GetLang('Logout')
					),
					'mnuViewStore' => array(
						'link' => '../index.php',
						'target' => '_blank',
						'text' => GetLang('ViewStore')
					),
					'mnuHelp' => array(
						'link' => 'javascript:LaunchHelp()',
						'text' => GetLang('Help'),
						'show' => !GetConfig('HideHelpLink')
					),

				);

				// Now that we've loaded the default menu, let's check if there are any addons we need to load
				$this->_LoadAddons($menuItems);

				$first = true;
				foreach($menuItems as $id => $menuDetails) {
					$hasItems = false;
					if(isset($menuDetails['show']) && !$menuDetails['show']) {
						continue;
					}
					if(!isset($menuDetails['items'])) {
						$hasItems = true;
						$target = '';
						if (isset($menuDetails['target'])) {
							$target = ' target="'.$menuDetails['target'].'"';
						}
						$menuContent = '<a href="'.$menuDetails['link'].'" class="MenuText"'.$target.'>'.$menuDetails['text'].'</a>';
					}
					else {
						$menuContent = '<a href="#" class="PopDownMenu MenuText" id="'.$id.'MenuButton">'.$menuDetails['text'].'<img src="images/arrow_down_white.gif" border="0" /></a>';
						$menuContent .= '<div id="'.$id.'Menu" class="DropDownMenu DropShadow" style="display: none; width: 140px;"><ul>';
						$insertBreak = '';
						$hasChildren = false;
						foreach($menuDetails['items'] as $k => $subMenuItem) {
							if(isset($subMenuItem['show']) && !$subMenuItem['show']) {
								continue;
							}
							if(isset($subMenuItem['break'])) {
								if($hasChildren && isset($menuDetails['items'][$k+1])) {
									$insertBreak = '<li class="Break"><hr /></li>';
								}
								if(!isset($subMenuItem['text'])) {
									continue;
								}
							}
							$hasItems = true;
							$hasChildren = true;
							// Add the sub menu item to the menu
							$menuContent .= $insertBreak;
							$insertBreak = '';
							$menuContent .= '<li><a href="'.$subMenuItem['link'].'" class="MenuTextDrop">'.$subMenuItem['text'].'</a></li>';
						}
						$menuContent .= "</ul></div>\n";
					}
					if($hasItems) {
						if(!$first) {
							$GLOBALS['textLinks'] .= '|';
						}
						$GLOBALS['textLinks'] .= $menuContent."\n";
					}
					$first = false;
				}

				$GLOBALS['textLinks'] .= '</div>';

				// Tell them who they're logged in as
				if (isset($_COOKIE['userId']) && is_numeric($_COOKIE['userId'])) {
					$user = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetUser();
					$GLOBALS['textLinks'] .= '<br /><div class="LoggedInAs">' . sprintf(GetLang('LoggedInAs'), $user['username']) . '</div>';
				}

				// Build the menu tabs
				$GLOBALS['menuRow'] = $this->_BuildTabMenu();
			}

			else {
				$GLOBALS['menuRow'] = "<tr><td colspan=3 height=\"33\">&nbsp;</td></tr>";
			}

			// Build the breadcrumb trail
			$GLOBALS['BreadcrumbTrail'] = $this->_BuildBreadcrumbTrail();

			if(!$GLOBALS['BreadcrumbTrail']) {
				$GLOBALS['HideBreadcrumb'] = 'display: none';
			}

			// Is there an info tip to be shown on this page?
			if (isset($GLOBALS['InfoTip'])) {
				$GLOBALS['InfoTip'] = sprintf("<p class=\"InfoTip\">%s</p>", $GLOBALS['InfoTip']);
			}

			if(!ech0(GetConfig('serverStamp'))) {
				$GLOBALS['RTLStyles'] = "<script type=\"text/javascript\">var in_app = true;</script>";
			}

			$GLOBALS['AdminLogo'] = GetConfig('AdminLogo');
			$GLOBALS['ControlPanelTitle'] = str_ireplace('%%EDITION%%', $GLOBALS['AppEdition'], GetConfig('ControlPanelTitle'));

			$GLOBALS['ProductName'] = addslashes(GetConfig('ProductName'));

            # For the pages, add/edit products and bulk edit products we are sending adminiselector files. -- Baskaran
            
            $TodoPage = '';
            if (isset($_REQUEST['ToDo'])) {
                $TodoPage = $_REQUEST['ToDo'];
            } else {
                $TodoPage = "";
            }
            if($TodoPage == 'editProduct' || $TodoPage == 'addProduct' || $TodoPage == 'bulkEditProducts') {
                $GLOBALS['TodoPage'] = '<script type="text/javascript" src="../javascript/adminiselector.js"></script>';
            }
            else {
                $GLOBALS['TodoPage'] = '<script type="text/javascript" src="../javascript/iselector.js"></script>';
            }
            # Ends here            
			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("pageheader");
			$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
		}

		public function PrintFooter()
		{
			if(GetConfig('DebugMode') == 1) {
				$end_time = microtime_float();
				$GLOBALS['ScriptTime'] = number_format($end_time - ISC_START_TIME, 4);
				$GLOBALS['QueryCount'] = $GLOBALS['ISC_CLASS_DB']->NumQueries;
				if (function_exists('memory_get_peak_usage')) {
					$GLOBALS['MemoryPeak'] = "Memory usage peaked at ".NiceSize(memory_get_peak_usage(true));
				} else {
					$GLOBALS['MemoryPeak'] = '';
				}

				if (isset($_REQUEST['debug'])) {
					echo "<ol class='QueryList' style='font-size: 13px;'>\n";
					foreach ($GLOBALS['ISC_CLASS_DB']->QueryList as $query) {
						echo "<li style='line-height: 1.4; margin-bottom: 4px;'>".isc_html_escape($query['Query'])." &mdash; <em>".number_format($query['ExecutionTime'], 4)."seconds</em></li>\n";
					}
					echo "</ol>";
				}
				$GLOBALS['DebugDetails'] = "<p>Page built in ".$GLOBALS['ScriptTime']."s with ".$GLOBALS['QueryCount']." queries. ".$GLOBALS['MemoryPeak']."</p>";
			}
			else {
				$GLOBALS['DebugDetails'] = '';
			}
			$GLOBALS['AdminCopyright'] = str_replace('%%EDITION%%', $GLOBALS['AppEdition'], GetConfig('AdminCopyright'));

			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("pagefooter");
			$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
		}

		/**
		*	Each page/action that wants to display a breadcrum trail needs to create
		*	a $GLOBALS['BreadcrumbEntries'] array with each of the breadcrumb levels.
		*	For example, if I was on the add product page it would be:
		*
		*	$GLOBALS['BreadcrumEntries'] = array("Home" => "index.php", "Products" => "index.php?ToDo=viewProducts", "Add Product" => "index.php?ToDo=addProduct");
		*
		*	As you can see, the last entry doesn't need the URL because that's the page you're on
		*/
		private function _BuildBreadcrumbTrail()
		{
			$trail = "";
			$count = 0;

			if (isset($GLOBALS['BreadcrumEntries']) && is_array($GLOBALS['BreadcrumEntries'])) {
				foreach ($GLOBALS['BreadcrumEntries'] as $k=>$v) {
					if ($count++ < count($GLOBALS['BreadcrumEntries'])-1) {
						$trail .= sprintf("<a href='%s'>%s</a> &gt; ", $v, $k);
					} else {
						$trail .= $k;
					}
				}
			}

			return $trail;
		}

		/**
		* _LoadAddons
		* Load menu options for any enabled addon modules
		*
		* @param Array $MenuItems A reference to all of the menu items
		* @return Array
		*/
		private function _LoadAddons(&$MenuItems)
		{
			$enabled_addons = GetSetupAddonsModules();
			$arrPermissions = $GLOBALS["ISC_CLASS_ADMIN_AUTH"]->GetPermissions();
			foreach($enabled_addons as $addon) {
				foreach($addon['object']->menuItems as $menuItem) {
					// Menu item doesn't exist
					if(!isset($MenuItems[$menuItem['location']])) {
						continue;
					}

					$parentMenu = &$MenuItems[$menuItem['location']];
					if(!isset($parentMenu['items'])) {
						$parentMenu['items'] = array();
					}

					$insertBreak = false;
					if(isset($menuItem['break']) && $menuItem['break'] == true) {
						$insertBreak = true;
					}

					$menuItemPermissions = true;
					if($addon['object']->GetPermissionId() && !in_array($addon['object']->GetPermissionId(), $arrPermissions)) {
						$menuItemPermissions = false;
					}

					if(!isset($menuItem['link'])) {
						$menuItem['link'] = 'index.php?ToDo=runAddon&addon=' . $addon['object']->GetId();
					}

					if(!isset($menuItem['description'])) {
						$menuItem['description'] = '';
					}

					if(!isset($menuItem['icon'])) {
						$menuItem['icon'] = '';
					}

					$addonMenu = array(
						'text' => $menuItem['text'],
						'icon' => $menuItem['icon'],
						'help' => $menuItem['description'],
						'link' => $menuItem['link'],
						'show' => $menuItemPermissions,
						'is_addon' => true,
						'break' => $insertBreak
					);

					$parentMenu['items'][] = $addonMenu;
				}
			}
		}

		/**
		* _BuildTabMenu
		* Build the menu of tabs that appears at the top of the control panel
		*
		* @return String
		*/
		private function _BuildTabMenu()
		{

			$menu = "";

			// Get an array of permissions for the selected user
			$arrPermissions = $GLOBALS["ISC_CLASS_ADMIN_AUTH"]->GetPermissions();

			$show_manage_products = in_array(AUTH_Manage_Products, $arrPermissions)
				|| in_array(AUTH_Manage_Reviews, $arrPermissions)
				|| in_array(AUTH_Create_Product, $arrPermissions)
				|| in_array(AUTH_Import_Products, $arrPermissions);

			$show_manage_categories = in_array(AUTH_Manage_Categories, $arrPermissions)
				|| in_array(AUTH_Create_Category, $arrPermissions);

			$show_manage_orders = in_array(AUTH_Manage_Orders, $arrPermissions)
				|| in_array(AUTH_Add_Orders, $arrPermissions)
				|| in_array(AUTH_Export_Orders, $arrPermissions)
				|| in_array(AUTH_Manage_Returns, $arrPermissions);

			$show_import_tracking_number = in_array(AUTH_Manage_Orders, $arrPermissions)
				&& in_array(AUTH_Import_Order_Tracking_Numbers, $arrPermissions)
				&& gzte11(ISC_MEDIUMPRINT);

			$show_manage_customers = in_array(AUTH_Manage_Customers, $arrPermissions)
				|| in_array(AUTH_Add_Customer, $arrPermissions)
				|| in_array(AUTH_Import_Customers, $arrPermissions);

			// If Interspire Email Marketer is integrated and setup to handle newsletter subscribers then we'll take them
			// to the login page. If not we'll just export from the subscribers table in CSV format
			if (GetConfig('MailXMLAPIValid') && GetConfig('UseMailerForNewsletter') && GetConfig('MailNewsletterList') > 0) {
				$mailer_link = str_replace("xml.php", "admin", GetConfig('MailXMLPath'));
				$subscriber_link = sprintf("javascript:LaunchMailer('%s')", $mailer_link);
				$subscriber_class = '';
			} else {
				$subscriber_link = "index.php?ToDo=exportSubscribersIntro&height=260&width=400";
				$subscriber_class = 'thickbox';
			}

			$menuItems = array (
				'mnuOrders' => array (
					'match' => array('order', 'shipment'),
					'items' => array(
						array (
							'text' => GetLang('ViewOrders'),
							'help' => GetLang('ViewOrdersMenuHelp'),
							'icon' => 'order.gif',
							'link' => 'index.php?ToDo=viewOrders',
							'show' => $show_manage_orders,
						),
						array (
							'text' => GetLang('AddAnOrder'),
							'help' => GetLang('AddOrderMenuHelp'),
							'icon' => 'order_add.gif',
							'link' => 'index.php?ToDo=addOrder',
							'show' => in_array(AUTH_Add_Orders, $arrPermissions),
						),
						array (
							'text' => GetLang('SearchOrders'),
							'help' => GetLang('SearchOrdersMenuHelp'),
							'icon' => 'find.gif',
							'link' => 'index.php?ToDo=searchOrders',
							'show' => $show_manage_orders,
						),
						array (
							'text' => GetLang('ExportOrdersMenu'),
							'help' => GetLang('ExportOrdersMenuHelp'),
							'icon' => 'export.gif',
							'link' => 'index.php?ToDo=startExport&t=orders',
							'show' => in_array(AUTH_Export_Orders, $arrPermissions) && gzte11(ISC_MEDIUMPRINT)
						),
						array(
							'text' => GetLang('ViewShipments'),
							'help' => GetLang('ViewShipmentsHelp'),
							'icon' => 'shipments.gif',
							'link' => 'index.php?ToDo=viewShipments',
							'show' => $show_manage_orders
						),
						array (
							'text' => GetLang('ViewReturns'),
							'help' => GetLang('ViewReturnsMenuHelp'),
							'icon' => 'return.gif',
							'link' => 'index.php?ToDo=viewReturns',
							'show' => in_array(AUTH_Manage_Returns, $arrPermissions) && GetConfig('EnableReturns') && gzte11(ISC_LARGEPRINT),
						),
						array (
							'text' => GetLang('ImportOrdertrackingnumbers'),
							'help' => GetLang('ImportOrdertrackingnumbersMenuHelp'),
							'icon' => 'import.gif',
							'link' => 'index.php?ToDo=importOrdertrackingnumbers',
							'show' => $show_import_tracking_number,
						),
					),
				),
				'mnuCustomers' => array (
					'match' => 'customer',
					'items' => array(
						array (
							'text' => GetLang('ViewCustomers'),
							'help' => GetLang('ViewCustomersMenuHelp'),
							'icon' => 'customer.gif',
							'link' => 'index.php?ToDo=viewCustomers',
							'show' => $show_manage_customers,
						),
						array (
							'text' => GetLang('AddCustomers'),
							'help' => GetLang('AddCustomersMenuHelp'),
							'icon' => 'customers_add.gif',
							'link' => 'index.php?ToDo=addCustomer',
							'show' => in_array(AUTH_Add_Customer, $arrPermissions),
						),
						array (
							'text' => GetLang('CustomerGroups'),
							'help' => GetLang('CustomerGroupsMenuHelp'),
							'icon' => 'customer_group.gif',
							'link' => 'index.php?ToDo=viewCustomerGroups',
							'show' => in_array(AUTH_Customer_Groups, $arrPermissions) && gzte11(ISC_MEDIUMPRINT),
						),
						array (
							'text' => GetLang('SearchCustomers'),
							'help' => GetLang('SearchCustomersMenuHelp'),
							'icon' => 'find.gif',
							'link' => 'index.php?ToDo=searchCustomers',
							'show' => $show_manage_customers,
						),
						array (
							'text' => GetLang('ImportCustomers'),
							'help' => GetLang('ImportCustomersMenuHelp'),
							'icon' => 'import.gif',
							'link' => 'index.php?ToDo=importCustomers',
							'show' => in_array(AUTH_Import_Customers, $arrPermissions),
						),
						array (
							'text' => GetLang('ExportCustomersMenu'),
							'help' => GetLang('ExportCustomersMenuHelp'),
							'icon' => 'export.gif',
							'link' => 'index.php?ToDo=startExport&t=customers',
							'show' => in_array(AUTH_Export_Customers, $arrPermissions) && gzte11(ISC_MEDIUMPRINT)
						),
						array (
							'text' => GetLang('WishListCustomers'),
							'help' => GetLang('WishListCustomersMenuHelp'),
							'icon' => 'customers_add.gif',
							'link' => 'index.php?ToDo=wishlist',
							'show' => in_array(AUTH_Add_Customer, $arrPermissions),
						),
					),
				),
				'mnuProducts' => array (
					'match' => array('product', 'review', 'categor'),
					'items' => array(
						array (
							'text' => GetLang('ViewProducts'),
							'help' => GetLang('ViewProductsMenuHelp'),
							'icon' => 'product.gif',
							'link' => 'index.php?ToDo=viewProducts',
							'show' => $show_manage_products,
						),
						array (
							'text' => GetLang('AddProduct'),
							'help' => GetLang('AddProductMenuHelp'),
							'icon' => 'product_add.gif',
							'link' => 'index.php?ToDo=addProduct',
							'show' => in_array(AUTH_Create_Product, $arrPermissions),
						),
						array (
							'text' => GetLang('ViewCategories'),
							'help' => GetLang('ViewCategoriesMenuHelp'),
							'icon' => 'category.gif',
							'link' => 'index.php?ToDo=viewCategories',
							'show' => $show_manage_categories,
						),
						array (
							'text' => GetLang('ProductVariations'),
							'help' => GetLang('ProductVariationsMenuHelp'),
							'icon' => 'product_variation.gif',
							'link' => 'index.php?ToDo=viewProductVariations',
							'show' => in_array(AUTH_Manage_Variations, $arrPermissions),
						),
						array (
							'text' => GetLang('SearchProducts'),
							'help' => GetLang('SearchProductsMenuHelp'),
							'icon' => 'find.gif',
							'link' => 'index.php?ToDo=searchProducts',
							'show' => $show_manage_products,
						),
						array (
							'text' => GetLang('ImportProducts'),
							'help' => GetLang('ImportProductsMenuHelp'),
							'icon' => 'import.gif',
							'link' => 'index.php?ToDo=importProducts',
							'show' => in_array(AUTH_Import_Products, $arrPermissions),
						),
						array (
							'text' => GetLang('ExportProductsMenu'),
							'help' => GetLang('ExportProductsMenuHelp'),
							'icon' => 'export.gif',
							'link' => 'index.php?ToDo=startExport&t=products',
							'show' => in_array(AUTH_Export_Products, $arrPermissions) && gzte11(ISC_MEDIUMPRINT)
						),
						array (
							'text' => GetLang('ManageReviews'),
							'help' => GetLang('ViewReviewsMenuHelp'),
							'icon' => 'comment_view.gif',
							'link' => 'index.php?ToDo=viewReviews',
							'show' => in_array(AUTH_Manage_Reviews, $arrPermissions),
						),
                         array (
                            'text' => GetLang('SettingsNew'),
                            'help' => GetLang('SettingsHelp'),
                            'icon' => 'product_add.gif',
                            'link' => '#',
                            'show' => in_array(AUTH_Manage_Brands, $arrPermissions),
                            'items' => array(
                                array (
                                    'text' => GetLang('ValidMMY'),
                                    'help' => GetLang('ViewMMYHelp'),
                                    'icon' => 'brand_menu.gif',
                                    'link' => 'index.php?ToDo=viewMMY',
                                    'show' => in_array(AUTH_Manage_Brands, $arrPermissions),
                                ),
                                array (
                                    'text' => GetLang('QualifierAssociations'),
                                    'help' => GetLang('QualifierAssociationsHelp'),
                                    'icon' => 'category.gif',
                                    'link' => 'index.php?ToDo=viewQualifierAssociations',
                                    'show' => in_array(AUTH_Qualifier_Associations, $arrPermissions),
                                ),
                                array (
                                    'text' => GetLang('QValueAssociations'),
                                    'help' => GetLang('QValueAssociationsHelp'),
                                    'icon' => 'category.gif',
                                    'link' => 'index.php?ToDo=viewQValueAssociations',
                                    'show' => in_array(AUTH_QValue_Associations, $arrPermissions),
                                ),
                            ),
                        ),
						array (
							'text' => GetLang('ViewBrands'),
							'help' => GetLang('ViewBrandsHelp'),
							'icon' => 'brand_menu.gif',
							'link' => 'index.php?ToDo=viewBrands',
							'show' => in_array(AUTH_Manage_Brands, $arrPermissions),
						),
						array (
							'text' => GetLang('ImportLog'),
							'help' => GetLang('ImportLogHelp'),
							'icon' => 'import.gif',
							'link' => 'index.php?ToDo=viewImportlog',
							'show' => in_array(AUTH_Import_Products, $arrPermissions),
						),
                        array (
                            'text' => GetLang('FileManagement'),
                            'help' => GetLang('FileManagementHelp'),
                            'icon' => 'category.gif',
                            'link' => 'index.php?ToDo=viewFileManagement',
                            'show' => in_array(AUTH_QValue_Associations, $arrPermissions),
                        ),
                        array (
                            'text' => GetLang('ChangesReport'),
                            'help' => GetLang('ChangesReportHelp'),
                            'icon' => 'category.gif',
                            'link' => 'index.php?ToDo=viewChangesReport',
                            'show' => in_array(AUTH_Changes_Report, $arrPermissions),
                        ),
					),
				),
				'mnuContent' => array (
					'match' => array('news', 'page'),
					'ignore' => array('vendor'),
					'items' => array(
						array (
							'text' => GetLang('ViewNews'),
							'help' => GetLang('ViewNewsMenuHelp'),
							'icon' => 'news.gif',
							'link' => 'index.php?ToDo=viewNews',
							'show' => in_array(AUTH_Manage_News, $arrPermissions),
						),
						array (
							'text' => GetLang('AddNews'),
							'help' => GetLang('AddNewsMenuHelp'),
							'icon' => 'news_add.gif',
							'link' => 'index.php?ToDo=addNews',
							'show' => in_array(AUTH_Manage_News, $arrPermissions),
						),
						array (
							'text' => GetLang('ViewWebPages'),
							'help' => GetLang('ViewWebPagesMenuHelp'),
							'icon' => 'page.gif',
							'link' => 'index.php?ToDo=viewPages',
							'show' => in_array(AUTH_Manage_Pages, $arrPermissions),
						),
						array (
							'text' => GetLang('CreateAWebPage'),
							'help' => GetLang('CreateWebPageMenuHelp'),
							'icon' => 'page_add.gif',
							'link' => 'index.php?ToDo=createPage',
							'show' => in_array(AUTH_Manage_Pages, $arrPermissions),
						),
					),
				),
				'mnuPromotions' => array (
					'match' => array('coupon', 'banner', 'discount', 'giftcertificates'),
					'items' => array(
						array (
							'text' => GetLang('ViewBanners'),
							'help' => GetLang('ViewBannersMenuHelp'),
							'icon' => 'banner.gif',
							'link' => 'index.php?ToDo=viewBanners',
							'show' => in_array(AUTH_Manage_Banners, $arrPermissions),
						),
						array (
							'text' => GetLang('ViewCoupons'),
							'help' => GetLang('ViewCouponsMenuHelp'),
							'icon' => 'coupon.gif',
							'link' => 'index.php?ToDo=viewCoupons',
							'show' => in_array(AUTH_Manage_Coupons, $arrPermissions),
						),
						array (
							'text' => GetLang('CouponsSettings'),
							'help' => GetLang('CouponsSettingsMenuHelp'),
							'icon' => 'coupon.gif',
							'link' => 'index.php?ToDo=Couponssettings',
							'show' => in_array(AUTH_Manage_Coupons, $arrPermissions),
						),
						array (
							'text' => GetLang('ViewDiscounts'),
							'help' => GetLang('ViewDiscountsMenuHelp'),
							'icon' => 'discountrule.gif',
							'link' => 'index.php?ToDo=viewDiscounts',
							'show' => in_array(AUTH_Manage_Discounts, $arrPermissions) && gzte11(ISC_MEDIUMPRINT),
						),
						array (
							'text' => GetLang('ViewGiftCertificates'),
							'help' => GetLang('ViewGiftCertificatesMenuHelp'),
							'icon' => 'giftcertificate.gif',
							'link' => 'index.php?ToDo=viewGiftCertificates',
							'show' => in_array(AUTH_Manage_GiftCertificates, $arrPermissions) && gzte11(ISC_LARGEPRINT),
						),
						array (
							'text' => GetLang('NewsletterSubscribers'),
							'help' => GetLang('ViewSubscribersMenuHelp'),
							'icon' => 'subscriber.gif',
							'link' => $subscriber_link,
							'class' => $subscriber_class,
							'show' => in_array(AUTH_Newsletter_Subscribers, $arrPermissions),
						),
						array (
							'text' => GetLang('CreateFroogleFeed'),
							'help' => GetLang('GoogleProductsFeedMenuHelp'),
							'icon' => 'google.gif',
							'link' => 'index.php?ToDo=exportFroogleIntro&height=260&width=400',
							'class' => 'thickbox',
							'show' => in_array(AUTH_Export_Froogle, $arrPermissions),
						),
					),
				),
				'mnuStatistics' => array (
					'match' => 'stats',
					'items' => array(
						array (
							'text' => GetLang('StoreOverview'),
							'help' => GetLang('StoreOverviewMenuHelp'),
							'icon' => 'stats_overview.gif',
							'link' => 'index.php?ToDo=viewStats',
							'show' => in_array(AUTH_Statistics_Overview, $arrPermissions),
						),
						array (
							'text' => GetLang('OrderStatistics'),
							'help' => GetLang('OrderStatsMenuHelp'),
							'icon' => 'stats_orders.gif',
							'link' => 'index.php?ToDo=viewOrdStats',
							'show' => in_array(AUTH_Statistics_Orders, $arrPermissions),
						),
						array (
							'text' => GetLang('ProductStatistics'),
							'help' => GetLang('ProductStatsMenuHelp'),
							'icon' => 'stats_products.gif',
							'link' => 'index.php?ToDo=viewProdStats',
							'show' => in_array(AUTH_Statistics_Products, $arrPermissions),
						),
						array (
							'text' => GetLang('CustomerStatistics'),
							'help' => GetLang('CustomerStatsMenuHelp'),
							'icon' => 'stats_customers.gif',
							'link' => 'index.php?ToDo=viewCustStats',
							'show' => in_array(AUTH_Statistics_Customers, $arrPermissions),
						),
						array (
							'text' => GetLang('SearchStatistics'),
							'help' => GetLang('SearchStatsHelp'),
							'icon' => 'stats_search.gif',
							'link' => 'index.php?ToDo=viewSearchStats',
							'show' => in_array(AUTH_Statistics_Search, $arrPermissions),
						),
					),
				),
			);

			// Now that we've loaded the default menu, let's check if there are any addons we need to load
			$this->_LoadAddons($menuItems);

			$imagesDir = dirname(__FILE__).'/../../images';

			$menu = "\n".'<div id="headerMenu">'."\n".'<ul>'."\n";
			foreach ($menuItems as $image => $link) {

				// By default we wont highlight this tab
				$highlight_tab = false;

				if ($link['match'] && isset($_REQUEST['ToDo'])) {
					// If the URI matches the "match" index, we'll highlight the tab

					$page = @isc_strtolower($_REQUEST['ToDo']);

					if(isset($GLOBALS['HighlightedMenuItem']) && $GLOBALS['HighlightedMenuItem'] == $image) {
						$highlight_tab = true;
					}

					// Does it need to match mutiple words?
					if (is_array($link['match'])) {
						foreach ($link['match'] as $match_it) {
							if ($match_it == "") {
								continue;
							}

							if (is_numeric(isc_strpos($page, isc_strtolower($match_it)))) {
								$highlight_tab = true;
							}
						}
					} else {
						if (is_numeric(isc_strpos($page, $link['match']))) {
							$highlight_tab = true;
						}
					}

					if(isset($link['ignore']) && is_array($link['ignore'])) {
						foreach($link['ignore'] as $ignore) {
							if(isc_strpos($page, strtolower($ignore)) !== false) {
								$highlight_tab = false;
							}
						}
					}
				}

				// If the menu has sub menus, display them
				if (is_array($link['items'])) {

					$first = true;
					$shown = false;

					foreach ($link['items'] as $id => $sub) {
						if (is_numeric($id)) {
							// If the child is forbidden by law, hide it
							if (@!$sub['show']) {
								continue;
							} else {
								$shown = true;
							}
							// If its the first born, give it an image
							if ($first) {
								$menu .= '<li class="dropdown';

								if ($highlight_tab) {
									$menu .= ' dropselected';

								}

								$menu .= '"><a href="'.$sub['link'].'">';
								$class = $image;
								if ($highlight_tab) {
									$image.= "On";
								}
								$filename = $imagesDir. DIRECTORY_SEPARATOR . $image . '.gif';

								if (file_exists($filename)) {
									list($width, $height, $type, $attr) = getimagesize($filename);
									$menu .= '<img '.$attr.' src="images/'.$image.'.gif" border="0" style="padding-right:2px" />';
								} else {
									$menu .= $image;
								}
								$menu .= '</a>'."\n";
								if (count($link) > 1) {
									$menu .= '<ul>'."\n";
								}
								$first = false;
							}
							// If it's not an only child, don't show the first item as a child
							if (count($link) > 1) {
								$extraclass = '';
								if (isset($sub['class'])) {
									$extraclass = $sub['class'];
								}
								// Is there help text set for this item?
								if (isset($sub['help'])) {
									if(isset($sub['is_addon'])) {
										$icon = $sub['icon'];
									}
									else {
										$icon = "images/" . $sub['icon'];
									}

                                    if(@is_array($sub['items']))         {
                                        $subsub = $this->GetSubSub($sub);  
                                    }
                                    else    {
                                        $subsub = '';
                                    }   
									$menu .= '<li><a style="background-image: url('.$icon.');" class="menu_'.$class.' '.$extraclass.'" href="'.$sub['link'].'" onclick="closeMenu()"><strong>'.$sub['text'].'</strong><span>'.$sub['help'].'</span></a>'.$subsub.'</li>'."\n";
								} else {
									$menu .= '<li><a class="menu_'.$class.' '.$extraclass.'" href="'.$sub['link'].'">'.$sub['text'].'</a></li>'."\n";
								}
							}
						}
					}

					if ($shown) {
						if (count($link) > 1) {
							$menu .= '</ul>'."\n";
						}
						$menu .= '</li>'."\n";
					}
				}
			}

			$menu .= '</ul></div>'."\n";
			return $menu;
		}

		/**
		 * Load an admin language file with the specified name.
		 *
		 * @param string The name of the language file to load. (no extension)
		 */
		public function LoadLangFile($name)
		{
			$file = ISC_BASE_PATH.'/language/'.GetConfig('Language').'/admin/'.$name.'.ini';
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseLangFile($file);
		}
        
        /* Added by Simha for creating the sub menu of a sub menu*/
        public function GetSubSub($link) {
            // If the menu has sub menus, display them   
            $menu = '<ul class="submenu" style="display:none;width: 255px;margin-top:-61px;position:absolute;margin-left:256px;padding-left:0px ">'."\n";   
            $class = 'mnuProducts';  
            foreach ($link['items'] as $id => $sub) {     
                // If it's not an only child, don't show the first item as a child
                if (count($link) > 1) {
                    $extraclass = '';
                    if (isset($sub['class'])) {
                        $extraclass = $sub['class'];
                    }
                    // Is there help text set for this item?
                    if (isset($sub['help'])) {
                        if(isset($sub['is_addon'])) {
                            $icon = $sub['icon'];
                        }
                        else {
                            $icon = "images/" . $sub['icon'];
                        }  
                        $menu .= '<li><a style="background-image: url('.$icon.');" class="menu_'.$class.' '.$extraclass.'" href="'.$sub['link'].'" onclick="closeMenu()"><strong>'.$sub['text'].'</strong><span>'.$sub['help'].'</span></a></li>'."\n";
                    } else {
                        $menu .= '<li><a class="menu_'.$class.' '.$extraclass.'" href="'.$sub['link'].'">'.$sub['text'].'</a></li>'."\n";
                    }
                }
            }
            $menu .= '</ul>'."\n";      
            return $menu;
        }
        /* Ends here*/
	}

?>