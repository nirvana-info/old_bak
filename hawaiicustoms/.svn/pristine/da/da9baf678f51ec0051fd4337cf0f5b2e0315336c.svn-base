<?php

	class ISC_ADMIN_COUPONS
	{
		public function HandleToDo($Do)
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('coupons');
			switch (isc_strtolower($Do)) {
				case "editcouponenabled":
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Coupons)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Coupons') => "index.php?ToDo=viewCoupons");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->EditEnabled();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
				break;
				case "editcoupon2":
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Coupons)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Coupons') => "index.php?ToDo=viewCoupons");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->EditCouponStep2();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
				break;
				case "editcoupon":
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Coupons)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Coupons') => "index.php?ToDo=viewCoupons", GetLang('EditCoupon') => "index.php?ToDo=editCoupon");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->EditCouponStep1();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
				break;
				case "createcoupon2":
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Add_Coupons)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Coupons') => "index.php?ToDo=viewCoupons");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->CreateCouponStep2();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
				break;
				case "createcoupon":
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Add_Coupons)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Coupons') => "index.php?ToDo=viewCoupons", GetLang('CreateCoupon') => "index.php?ToDo=createCoupon");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->CreateCouponStep1();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
				break;
				case "deletecoupons":
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Delete_Coupons)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Coupons') => "index.php?ToDo=viewCoupons");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->DeleteCoupons();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
				break;
				default:
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Coupons)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Coupons') => "index.php?ToDo=viewCoupons");

						if(!isset($_REQUEST['ajax'])) {
							$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						}

						$this->ManageCoupons();

						if(!isset($_REQUEST['ajax'])) {
							$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						}
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
			}
		}

		private function ManageCouponsGrid(&$numCoupons)
		{
			// Show a list of coupons in a table
			$page = 0;
			$start = 0;
			$numCoupons = 0;
			$numPages = 0;
			$GLOBALS['CouponGrid'] = "";
			$GLOBALS['Nav'] = "";
			$max = 0;

			if (isset($_GET['sortOrder']) && $_GET['sortOrder'] == 'desc') {
				$sortOrder = 'desc';
			} else {
				$sortOrder = "asc";
			}

			$sortLinks = array(
				"Name" => "c.couponname",
				"Coupon" => "c.couponcode",
				"Discount" => "c.couponamount",
				"Expiry" => "c.couponexpires",
				"NumUses" => "c.couponnumuses",
				"Enabled" => "c.couponenabled"
			);

			if (isset($_GET['sortField']) && in_array($_GET['sortField'], $sortLinks)) {
				$sortField = $_GET['sortField'];
				SaveDefaultSortField("ManageCoupons", $_REQUEST['sortField'], $sortOrder);
			} else {
				list($sortField, $sortOrder) = GetDefaultSortField("ManageCoupons", "c.couponid", $sortOrder);
			}

			if (isset($_GET['page'])) {
				$page = (int)$_GET['page'];
			} else {
				$page = 1;
			}
			$sortURL = sprintf("&sortField=%s&sortOrder=%s", $sortField, $sortOrder);

			$GLOBALS['SortURL'] = $sortURL;

			// Limit the number of questions returned
			if ($page == 1) {
				$start = 1;
			} else {
				$start = ($page * ISC_COUPONS_PER_PAGE) - (ISC_COUPONS_PER_PAGE-1);
			}
			$start = $start-1;

			// Get the results for the query
			$couponResult = $this->_GetCouponList($start, $sortField, $sortOrder, $numCoupons);

			$numPages = ceil($numCoupons / ISC_COUPONS_PER_PAGE);

			if($numCoupons > ISC_COUPONS_PER_PAGE) {
				$GLOBALS['Nav'] = sprintf("(%s %d of %d) &nbsp;&nbsp;&nbsp;", GetLang('Page'), $page, $numPages);
				$GLOBALS['Nav'] .= BuildPagination($numCoupons, ISC_COUPONS_PER_PAGE, $page, sprintf("index.php?ToDo=viewCoupons%s", $sortURL));
			}
			else {
				$GLOBALS['Nav'] = "";
			}

			$GLOBALS['SortField'] = $sortField;

			BuildAdminSortingLinks($sortLinks, "index.php?ToDo=viewCoupons&amp;page=".$page, $sortField, $sortOrder);

			$max = $start + ISC_COUPONS_PER_PAGE;
			if ($max > count($couponResult)) {

				$max = count($couponResult);

			}
			if ($numCoupons > 0) {
				// Display the coupons
				while ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($couponResult)) {
					$GLOBALS['Name'] = isc_html_escape($row['couponname']);
					$GLOBALS['CouponId'] = (int) $row['couponid'];
					$GLOBALS['Coupon'] = isc_html_escape($row['couponcode']);

					if ($row['coupontype'] == 0) {
						// Dollar value coupon code
						$GLOBALS['Discount'] = sprintf("%s", FormatPrice($row['couponamount']));
					} else {
						// Percentage value coupon code
						$GLOBALS['Discount'] = sprintf("%s%%", number_format($row['couponamount'], GetConfig('DecimalPlaces'), GetConfig('DecimalToken'), GetConfig('ThousandsToken')) );
					}

					if ($row['couponexpires'] > 0) {
						$GLOBALS['Date'] = CDate($row['couponexpires']);
					} else {
						$GLOBALS['Date'] = GetLang('NA');

					}

					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Coupons)) {
						$GLOBALS['EditCouponLink'] = sprintf("<a title='%s' class='Action' href='index.php?ToDo=editCoupon&amp;couponId=%d'>%s</a>", GetLang('CouponEdit'), $row['couponid'], GetLang('Edit'));
						if ($row['couponenabled'] == 1) {
							$GLOBALS['Enabled'] = sprintf("<a title='%s' href='index.php?ToDo=editCouponEnabled&amp;couponId=%d&amp;enabled=0'><img border='0' src='images/tick.gif'></a>", GetLang('ClickToDisableCoupon'), $row['couponid']);
						} else {
							$GLOBALS['Enabled'] = sprintf("<a title='%s' href='index.php?ToDo=editCouponEnabled&amp;couponId=%d&amp;enabled=1'><img border='0' src='images/cross.gif'></a>", GetLang('ClickToEnableCoupon'), $row['couponid']);
						}

					} else {
						$GLOBALS['EditCouponLink'] = sprintf("<a class='Action' disabled>%s</a>", GetLang('Edit'));
						if ($row['couponenabled'] == 1) {
							$GLOBALS['Enabled'] = '<img border="0" src="images/tick.gif" alt="tick" />';
						} else {
							$GLOBALS['Enabled'] = '<img border="0" src="images/cross.gif" alt="cross" />';
						}

					}
					$GLOBALS['NumUses'] = number_format($row['couponnumuses']);
					$GLOBALS['ViewOrdersLink'] = '';
					if($row['couponnumuses'] > 0) {
						$GLOBALS['ViewOrdersLink'] = sprintf("&nbsp;&nbsp;&nbsp;<a href='index.php?ToDo=viewOrders&amp;couponCode=%s' title='%s'>%s</a>", $row['couponcode'], GetLang('ViewOrdersWithCoupon'), GetLang('ViewOrders'));
					}

					$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("coupons.manage.row");
					$GLOBALS['CouponGrid'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
				}
				$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("coupons.manage.grid");
				return $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
			}
		}

		private function ManageCoupons($MsgDesc = "", $MsgStatus = "")
		{
			$numCoupons = 0;
			// Fetch any results, place them in the data grid
			$GLOBALS['CouponsDataGrid'] = $this->ManageCouponsGrid($numCoupons);

			// Was this an ajax based sort? Return the table now
			if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 1) {
				echo $GLOBALS['CouponsDataGrid'];
				return;
			}

			if ($MsgDesc != "") {
				$GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);

			}

			// Do we need to disable the delete button?
			if (!$GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Delete_Coupons) || $numCoupons == 0) {
				$GLOBALS['DisableDelete'] = "DISABLED";
			}

			if($numCoupons == 0) {
				// There are no coupons in the database
				$GLOBALS['DisplayGrid'] = "none";
				$GLOBALS['DisplaySearch'] = "none";
				$GLOBALS['Message'] = MessageBox(GetLang('NoCoupons'), MSG_SUCCESS);
			}

			$GLOBALS['CouponIntro'] = GetLang('ManageCouponIntro');

			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("coupons.manage");
			$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
		}

		private function _GetCouponList($Start, $SortField, $SortOrder, &$NumResults)
		{
			$query = "SELECT * FROM [|PREFIX|]coupons c ORDER BY ".$SortField." ".$SortOrder;
			$countQuery = "SELECT COUNT(*) FROM [|PREFIX|]coupons";

			$result = $GLOBALS['ISC_CLASS_DB']->Query($countQuery);
			$NumResults = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);

			$query .= $GLOBALS["ISC_CLASS_DB"]->AddLimit($Start, ISC_COUPONS_PER_PAGE);
			$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
			return $result;
		}

		private function DeleteCoupons()
		{
			if (isset($_POST['coupon'])) {
				$couponids = implode(",", array_map('intval', $_POST['coupon']));

				$query = sprintf("delete from [|PREFIX|]coupons where couponid in (%s)", $couponids);
				$GLOBALS["ISC_CLASS_DB"]->Query($query);

				$err = $GLOBALS["ISC_CLASS_DB"]->Error();
				if ($err != "") {
					// Log this action
					$GLOBALS['ISC_CLASS_LOG']->LogAdminAction(count($_POST['coupon']));

					$this->ManageCoupons($err, MSG_ERROR);
				} else {
					$this->ManageCoupons(GetLang('CouponsDeletedSuccessfully'), MSG_SUCCESS);
				}
			} else {
				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Coupons)) {
					$this->ManageCoupons();
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
				}
			}
		}

		private function CreateCouponStep1()
		{
			$GLOBALS['Title'] = GetLang('CreateCoupon');
			$GLOBALS['Intro'] = GetLang('CreateCouponIntro');
			$GLOBALS['FormAction'] = "createCoupon2";
			$GLOBALS['Enabled'] = 'checked="checked"';
			$GLOBALS['AllCategoriesSelected'] = "selected=\"selected\"";
			$GLOBALS['UsedForCat'] = 'checked="checked"';
			$GLOBALS['CouponCode'] = GenerateCouponCode();

			$GLOBALS['ISC_CLASS_ADMIN_CATEGORY'] = GetClass('ISC_ADMIN_CATEGORY');
			$GLOBALS['CategoryList'] = $GLOBALS["ISC_CLASS_ADMIN_CATEGORY"]->GetCategoryOptions(array(), "<option %s value='%d'>%s</option>", 'selected="selected"', "- ", false);
			$GLOBALS['ToggleUsedFor'] = "ToggleUsedFor(0);";
			$GLOBALS['HideCouponCode'] = "none";
			$GLOBALS['MaxUses'] = '';

			$GLOBALS['CurrencyToken'] = GetConfig('CurrencyToken');

			if (GetConfig('CurrencyLocation') == 'right') {
				$GLOBALS['CurrencyTokenLeft'] = '';
				$GLOBALS['CurrencyTokenRight'] = GetConfig('CurrencyToken');
			} else {
				$GLOBALS['CurrencyTokenLeft'] = GetConfig('CurrencyToken');
				$GLOBALS['CurrencyTokenRight'] = '';
			}

			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("coupon.form");
			$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();

		}

		private function _GetCouponData($CouponId = 0, &$RefArray)
		{
			if ($CouponId == 0) {
				$RefArray['couponid'] = 0;
				$RefArray['coupontype'] = $_POST['coupontype'];
				$RefArray['couponamount'] = (int)$_POST['couponamount'];
				$RefArray['couponminpurchase'] = CFloat($_POST['couponminpurchase']);
				$RefArray['couponmaxuses'] = (int)$_POST['couponmaxuses'];
				if ($_POST['couponexpires'] != "") {
						$RefArray['couponexpires'] = ConvertDateToTime($_POST['couponexpires']);

				} else {
					$RefArray['couponexpires'] = 0;
				}
				if (isset($_POST['couponenabled'])) {
					$RefArray['couponenabled'] = 1;
				} else {
					$RefArray['couponenabled'] = 0;
				}
				if (isset($_POST['couponcode']) && $_POST['couponcode'] != "") {
					$RefArray['couponcode'] = $_POST['couponcode'];
				} else {
					$RefArray['couponcode'] = GenerateCouponCode();
				}
			} else {
				// Get the data for this coupon code from the database
				$query = sprintf("select * from [|PREFIX|]coupons where couponid='%s'", $GLOBALS['ISC_CLASS_DB']->Quote($CouponId));
				$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
				if ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
					$RefArray = $row;
				}
			}
		}

		private function CreateCouponStep2()
		{
			$error = $this->_CommitCoupon();
			if (empty($error)) {
				if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Coupons)) {
					$this->ManageCoupons(GetLang('CouponCreatedSuccessfully'), MSG_SUCCESS);
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('CouponCreatedSuccessfully'), MSG_SUCCESS);
				}
			} else {
				if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Coupons)) {
					$this->ManageCoupons(sprintf(GetLang('ErrCouponNotCreated'), $error), MSG_ERROR);
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(sprintf(GetLang('ErrCouponNotCreated'), $error), MSG_ERROR);
				}
			}
		}

		private function _CommitCoupon($CouponId=0)
		{
			include_once(ISC_BASE_PATH.'/lib/api/coupon.api.php');
			$coupon = new API_COUPON();

			$_POST['couponappliesto'] = $_POST['usedfor'];
			if($_POST['couponappliesto'] == "categories") {
				// Applies to categories
				$_POST['couponappliestovalues'] = implode(",", array_map('intval', $_POST['catids']));
			}
			else {
				// Applies to products
				$_POST['couponappliestovalues'] = implode(',', array_map('intval', explode(',', $_POST['prodids'])));
			}

			if (!empty($_POST['couponexpires'])) {
				$_POST['couponexpires'] = ConvertDateToTime($_POST['couponexpires']);
			} else {
				$_POST['couponexpires'] = 0;
			}

			if (!isset($_POST['couponcode']) || empty($_POST['couponcode'])) {
				$_POST['couponcode'] = GenerateCouponCode();
			}

			if (isset($_POST['couponenabled'])) {
				$_POST['couponenabled'] = 1;
			} else {
				$_POST['couponenabled'] = 0;
			}
			$_POST['couponminpurchase'] = str_replace(GetConfig('CurrencyToken'), "", $_POST['couponminpurchase']);

			if (isset($_POST['couponmaxuses'])) {
				$_POST['couponmaxuses'] = (int)$_POST['couponmaxuses'];
			} else {
				$_POST['couponmaxuses'] = 0;
			}

			if($CouponId == 0) {
				$CouponId = $coupon->create();
			}
			else {
				$coupon->load($CouponId);
				$coupon->save();
			}

			if(!$coupon->error) {
				// Log this action
				$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($CouponId, $_POST['couponcode']);
			}

			return $coupon->error;
		}

		private function EditCouponStep1()
		{
			// Show the form to edit a news
			$couponId = (int) $_GET['couponId'];
			$arrData = array();
			$sel_cats = array();

			if (GetConfig('CurrencyLocation') == 'right') {
				$GLOBALS['CurrencyTokenLeft'] = '';
				$GLOBALS['CurrencyTokenRight'] = GetConfig('CurrencyToken');
			} else {
				$GLOBALS['CurrencyTokenLeft'] = GetConfig('CurrencyToken');
				$GLOBALS['CurrencyTokenRight'] = '';
			}

			$GLOBALS['CurrencyToken'] = GetConfig('CurrencyToken');

			if (CouponExists($couponId)) {
				$this->_GetCouponData($couponId, $arrData);
				$GLOBALS['Title'] = GetLang('EditCoupon');
				$GLOBALS['Intro'] = GetLang('EditCouponIntro');
				$GLOBALS['FormAction'] = "editCoupon2";
				$GLOBALS['CouponCode'] = isc_html_escape($arrData['couponcode']);
				$GLOBALS['CouponName'] = isc_html_escape($arrData['couponname']);
				$GLOBALS['MaxUses'] = (int) $arrData['couponmaxuses'];
				if($GLOBALS['MaxUses'] > 0) {
					$GLOBALS['MaxUsesChecked'] = 'checked="checked"';
				}
				else {
					$GLOBALS['MaxUsesHide'] = 'none';
				}
				if($arrData['couponappliesto'] == "categories") {
					// Show the categories list
					$GLOBALS['ToggleUsedFor'] = "ToggleUsedFor(0);";
					$sel_cats = explode(",", $arrData['couponappliestovalues']);
					if($arrData['couponappliestovalues'] == "0") {
						$GLOBALS['AllCategoriesSelected'] = "selected=\"selected\"";
					}
				}
				else {
					// Show the products textbox
					$GLOBALS['ToggleUsedFor'] = "ToggleUsedFor(1);";

					// Select a list of the products that this coupon is active for
					if($arrData['couponappliestovalues'] != "") {
						$GLOBALS['SelectedProducts'] = '';
						$GLOBALS['ProductIds'] = '';
						$query = sprintf("SELECT productid, prodname FROM [|PREFIX|]products WHERE productid IN (%s) ORDER BY prodname ASC", $arrData['couponappliestovalues']);
						$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
						while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
							$GLOBALS['SelectedProducts'] .= sprintf("<option value='%d'>%s</option>", $row['productid'], $row['prodname']);
							$GLOBALS['ProductIds'] .= $row['productid'].",";
						}
						$GLOBALS['ProductIds'] = isc_substr($GLOBALS['ProductIds'], 0, -1);
					}
				}
				$GLOBALS['ISC_CLASS_ADMIN_CATEGORY'] = GetClass('ISC_ADMIN_CATEGORY');
				$GLOBALS['CategoryList'] = $GLOBALS["ISC_CLASS_ADMIN_CATEGORY"]->GetCategoryOptions($sel_cats, "<option %s value='%d'>%s</option>", "selected=\"selected\"", "- ", false);
				if ($arrData['coupontype'] == 1) {
					$GLOBALS['SelDiscount1'] = "selected=\"selected\"";
				} else {
					$GLOBALS['SelDiscount2'] = "selected=\"selected\"";
				}
				$GLOBALS['DiscountAmount'] = $arrData['couponamount'];
				if ($arrData['couponminpurchase'] == 0) {
					$GLOBALS['MinPurchase'] = 0;
				} else {
					$GLOBALS['MinPurchase'] = CPrice($arrData['couponminpurchase']);
				}
				if ($arrData['couponexpires'] > 0) {
					$GLOBALS['ExpiryDate'] = isc_date("m/d/Y", $arrData['couponexpires']);
				}
				if ($arrData['couponenabled'] == 1) {
					$GLOBALS['Enabled'] = 'checked="checked"';
				}

				$GLOBALS['CouponId'] = (int) $arrData['couponid'];
				$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("coupon.form");
				$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();

			}
			else {
				// The coupon doesn't exist
				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Coupons)) {
					$this->ManageCoupons(GetLang('CouponDoesntExist'), MSG_ERROR);
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
				}
			}
		}

		private function EditCouponStep2()
		{
			// Get the information from the form and add it to the database
			$couponId = (int) $_POST['couponId'];
			$error = $this->_CommitCoupon($couponId);

			// Commit the values to the database
			if (empty($error)) {
				if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Coupons)) {
					$this->ManageCoupons(GetLang('CouponUpdatedSuccessfully'), MSG_SUCCESS);
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('CouponUpdatedSuccessfully'), MSG_SUCCESS);
				}
			} else {
				if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Coupons)) {
					$this->ManageCoupons(sprintf(GetLang('ErrCouponNotUpdated'), $error), MSG_ERROR);
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(sprintf(GetLang('ErrCouponNotUpdated'), $error), MSG_ERROR);
				}
			}
		}

		private function EditEnabled()
		{
			// Update the status of a coupon with a simple query
			$couponId = (int) $_GET['couponId'];
			include_once(ISC_BASE_PATH.'/lib/api/coupon.api.php');
			$coupon = new API_COUPON();
			$coupon->load($couponId);
			if ($coupon->updateField('couponenabled', (int) $_GET['enabled'])) {
				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Coupons)) {
					$this->ManageCoupons(GetLang('CouponEnabledSuccessfully'), MSG_SUCCESS);
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('CouponEnabledSuccessfully'), MSG_SUCCESS);
				}
			} else {
				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Coupons)) {
					$this->ManageCoupons(sprintf(GetLang('ErrCouponEnabledNotChanged'), $coupon->error), MSG_ERROR);
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(sprintf(GetLang('ErrCouponEnabledNotChanged'), $coupon->error), MSG_ERROR);
				}
			}
		}
	}
?>