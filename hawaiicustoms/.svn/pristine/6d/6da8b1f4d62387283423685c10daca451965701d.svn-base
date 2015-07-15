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
				case "savecouponsettings":
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Add_Coupons)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Coupons') => "index.php?ToDo=viewCoupons");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->SaveCouponSettings();
						//$this->CouponSettings();
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
				case "couponssettings":
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Delete_Coupons)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Coupons') => "index.php?ToDo=viewCoupons");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->CouponSettings();
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
						$GLOBALS['Date'] = CDateWithoutCorrection($row['couponexpires']);  
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
public function FormatWYSIWYGHTML($HTML)
		{

			if(GetConfig('UseWYSIWYG')) {
				return $HTML;
			}
			else {
				// We need to sanitise all the line feeds first to 'nl'
				$HTML = SanatiseStringToUnix($HTML);

				// Now we can use nl2br()
				$HTML = nl2br($HTML);

				// But we still need to strip out the new lines as nl2br doesn't really 'replace' the new lines, it just inserts <br />before it
				$HTML = str_replace("\n", "", $HTML);

				// Fix up new lines and block level elements.
				$HTML = preg_replace("#(</?(?:html|head|body|div|p|form|table|thead|tbody|tfoot|tr|td|th|ul|ol|li|div|p|blockquote|cite|hr)[^>]*>)\s*<br />#i", "$1", $HTML);
				$HTML = preg_replace("#(&nbsp;)+(</?(?:html|head|body|div|p|form|table|thead|tbody|tfoot|tr|td|th|ul|ol|li|div|p|blockquote|cite|hr)[^>]*>)#i", "$2", $HTML);
				return $HTML;
			}
		}
Private function SaveCouponSettings()
		{
			
			    $templateid = $_POST['templateid'];
				$radiocat = $_POST['radiocat'];
				$radiobrand = $_POST['radiobrand'];
				$Category = $_POST['Category'];
				$SubCategory = $_POST['SubCategory'];
				$BrandList = $_POST['BrandList'];      
                $SeriesList = $_POST['SeriesList'];  
				$emailid = $_POST['emailid'];  

				//cat - sub cat saving start				
	    		$catids = array_unique(explode(",", $_POST['catids']));
				array_pop($catids);
				$comma_separated_cats = implode(",", $catids);

				$subids = array_unique(explode(",", $_POST['subids']));
				array_pop($subids);
				$comma_separated_subcats = implode(",", $subids);

				$sql1 = " update isc_categories set offer = 'no' ";
				mysql_query($sql1);

				$sql1 = " update isc_categories set offer = 'yes' where categoryid in (".$comma_separated_cats.") and catparentid = 0 ";
				mysql_query($sql1);
				
				$sql2 = " update isc_categories set offer = 'yes' where categoryid in (".$comma_separated_subcats.") and  catparentid in (".$comma_separated_cats.") ";
				mysql_query($sql2);
				//cat - sub cat saving end	
		
				//brand - series saving start	
				$brandids = array_unique(explode(",", $_POST['brandids']));
				array_pop($brandids);
				$comma_separated_brandids = implode(",", $brandids);

				$seriesids = array_unique(explode(",", $_POST['seriesids']));
				array_pop($seriesids);
				$comma_separated_seriesids = implode(",", $seriesids);

				$sql1 = " update isc_brands set offer = 'no' ";
				mysql_query($sql1);

				$sql1 = " update isc_brands set offer = 'yes' where  brandid in (".$comma_separated_brandids.") ";
				mysql_query($sql1);

				$sql2 = " update isc_brand_series set offer = 'no' ";
				mysql_query($sql2);

				$sql2 = " update isc_brand_series set offer = 'yes' where seriesid in (".$comma_separated_seriesids.") and brandid in (".$comma_separated_brandids.")";
				mysql_query($sql2);
				//brand - series saving end


				$WYSIWYG = $this->FormatWYSIWYGHTML($_POST['wysiwyg']);
				$WYSIWYG1 = $this->FormatWYSIWYGHTML($_POST['wysiwyg1']);  
				$WYSIWYG2 = $this->FormatWYSIWYGHTML($_POST['wysiwyg2']);  
				$WYSIWYG3 = $this->FormatWYSIWYGHTML($_POST['wysiwyg3']);  
               
				$newField = array(
						"title_msg" => $WYSIWYG,
						"header_msg" => $WYSIWYG1,
						"footer_msg" => $WYSIWYG2,
						"email_template" => $WYSIWYG3,
						"emailids" => $emailid
				
					);

					$GLOBALS['ISC_CLASS_DB']->UpdateQuery("coupon_settings", $newField, "  	templateid='".(int)$templateid."'");
					header("location:index.php?ToDo=Couponssettings");
					exit;
					
				}
			

public function fillthecombo($id,$combo,$table,$sel,$condition)
        {

			$temp = "";
			$query = "SELECT ".$id." ,".$combo." FROM [|PREFIX|]".$table.$condition." order by ".$combo." asc ";
			 $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			 while ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
			$temp.= "<option  value = '".$row[$id]."' ";
			if ($sel == $row[$combo]) $temp.=" selected";
			$temp.= ">".$row[$combo]."</option><BR>";
							
			 }
			

		return $temp;
		}




private function CouponSettings()
		{

			$year = "";
			$query = sprintf("select * from [|PREFIX|]coupon_settings LIMIT 0,1 ");
			$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
			if ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
				$RefArray = $row;
			}
			$GLOBALS['templateid'] = $RefArray['templateid'];
			$GLOBALS['emailids'] = $RefArray['emailids'];




			$GLOBALS['Title'] = GetLang('Makepagehead');
			$GLOBALS['Intro'] = GetLang('MakepageIntro');
			$GLOBALS['FormAction'] = "savecouponsettings";
			$GLOBALS['Enabled'] = 'checked="checked"';
			$GLOBALS['AllCategoriesSelected'] = "selected=\"selected\"";
			$GLOBALS['UsedForCat'] = 'checked="checked"';

$GLOBALS['Category'] = $this->fillthecombo('categoryid','catname', 'categories',$year," where catparentid = 0 ",'Categories');
 //$GLOBALS['SubCategory'] = $this->fillthecombo('categoryid','catname', 'categories',$year," where catparentid != 0 ",'Sub Categories');

$GLOBALS['BrandList'] = $this->fillthecombo('brandid','brandname', 'brands',$year,"  ",'Brand');
//$GLOBALS['SeriesList'] = $this->fillthecombo('seriesid','seriesname', 'brand_series',$year,"  ",'Series');


				$wysiwygOptions = array(
					'id'		=> 'wysiwyg',
					'width'		=> '50%',
					'height'	=> '250px',
					'value'		=> $RefArray['title_msg']
				);

				$wysiwygOptions1 = array(
					'id'		=> 'wysiwyg1',
					'width'		=> '50%',
					'height'	=> '250px',
					'value'		=> $RefArray['header_msg']
				);

               $wysiwygOptions2 = array(
					'id'		=> 'wysiwyg2',
					'width'		=> '50%',
					'height'	=> '250px',
					'value'		=> $RefArray['footer_msg']
				);
				$wysiwygOptions3 = array(
					'id'		=> 'wysiwyg3',
					'width'		=> '50%',
					'height'	=> '250px',
					'value'		=> $RefArray['email_template']
				);


			$GLOBALS['WYSIWYG'] =  GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor($wysiwygOptions);
			$GLOBALS['WYSIWYG1'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor1($wysiwygOptions1);
			$GLOBALS['WYSIWYG2'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor1($wysiwygOptions2);
			$GLOBALS['WYSIWYG3'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor1($wysiwygOptions3);

			$GLOBALS['ISC_CLASS_ADMIN_CATEGORY'] = GetClass('ISC_ADMIN_CATEGORY');
			//$GLOBALS['CategoryList'] = $GLOBALS["ISC_CLASS_ADMIN_CATEGORY"]->GetCategoryOptions(array(), "<option %s value='%d'>%s</option>", 'selected="selected"', "- ", false);
			$GLOBALS['ToggleUsedFor'] = "ToggleUsedFor(0);";
			$GLOBALS['HideCouponCode'] = "none";
			$GLOBALS['catids'] = '';
			$GLOBALS['subids'] = '';
			$GLOBALS['brandids']  = '';
			$GLOBALS['seriesids']  = '';

	$temptable = '<table width="520" border="0" id="dataTable">   ';

	//retrive cat - subcat info from data base
	$query2 = " SELECT `categoryid` , `catname`   FROM [|PREFIX|]categories where offer = 'yes' and catparentid	 = 0  order by catname ASC ";
	$result2 = $GLOBALS['ISC_CLASS_DB']->Query($query2);
	while ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result2))
		{
			$GLOBALS['catids'].= $row['categoryid'].", " ;
			$temptable.= '<tr id = '.$row['categoryid'].'>	<td><a href="javascript:deleteRow('.$row['categoryid'].',\'dataTable\')">Remove</a>  </td>';

			$temptable.= "<td>".$row['catname']."</td>";
			$temptable.= "<td><div id=\"sub_".$row['categoryid']."\">";
			$query1 = " SELECT `categoryid` , `catname`   FROM [|PREFIX|]categories where offer = 'yes' and catparentid	 =  ".$row['categoryid'] ." order by catname ASC ";
			$result1 = $GLOBALS['ISC_CLASS_DB']->Query($query1);
			while ($row1 = $GLOBALS["ISC_CLASS_DB"]->Fetch($result1))
				{
				$temptable.= $row1['catname']." , ";
				$GLOBALS['subids'].=  $row1['categoryid'].", " ;
				}
			if (mysql_num_rows($result1) == 0 ) $temptable.= "All Subcategories";
			$temptable.= "</div></td></tr>";

		}

	//retrive brand - series info from data base
	$query2 = " SELECT brandid ,   	brandname   FROM [|PREFIX|]brands where offer = 'yes'  order by brandname asc";
	$result2 = $GLOBALS['ISC_CLASS_DB']->Query($query2);
	while ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result2))
		{
			$GLOBALS['brandids'].= $row['brandid'].", " ;
			$temptable.= '<tr id = '.$row['brandid'].'>	<td><a href="javascript:deletebrand('.$row['brandid'].',\'dataTable\')">Remove</a>  </td>';
			$temptable.= "<td>".$row['brandname']."</td>";
			$temptable.= "<td><div id=\"ser_".$row['brandid']."\">";

			$query1 = " SELECT seriesid , seriesname   FROM [|PREFIX|]brand_series where offer = 'yes' and brandid = ".$row['brandid']." order by seriesname asc";
			$result1 = $GLOBALS['ISC_CLASS_DB']->Query($query1);
			while ($row1 = $GLOBALS["ISC_CLASS_DB"]->Fetch($result1))
				{
				$temptable.= $row1['seriesname']." , ";
				$GLOBALS['seriesids'].=  $row1['seriesid'].", " ;
				}
			if (mysql_num_rows($result1) == 0 ) $temptable.= "All Series";
			$temptable.= "</div></td></tr>";

		}

	$temptable.= '</table>';
    $GLOBALS['div_content']	= $temptable;




			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("couponsettings.form");
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
					$GLOBALS['ExpiryDate'] = isc_date("m/d/Y", $arrData['couponexpires'], 0);   
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