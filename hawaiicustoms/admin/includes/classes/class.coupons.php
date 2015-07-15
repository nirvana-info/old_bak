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
				case "searchcoupons":
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
				,"Type" => "c.coupongeneratetype"
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
			
			//2010-11-23 Ronnie add,link sort cond
			$otc=isset($_REQUEST['generatetype'])?"&generatetype=1":"";
			BuildAdminSortingLinks($sortLinks, "index.php?ToDo=viewCoupons".$otc."&amp;page=".$page, $sortField, $sortOrder);

			
			//$GLOBALS['SortLinksName'] = str_ireplace("viewCoupons", "viewCoupons".$otc, $GLOBALS['SortLinksName']);
			
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
						//2010-11-23 Ronnie modify , add generatetype
						/*if ($row['couponenabled'] == 1) {
							$GLOBALS['Enabled'] = sprintf("<a title='%s' href='index.php?ToDo=editCouponEnabled&amp;couponId=%d&amp;enabled=0'><img border='0' src='images/tick.gif'></a>", GetLang('ClickToDisableCoupon'), $row['couponid']);
						} else {
							$GLOBALS['Enabled'] = sprintf("<a title='%s' href='index.php?ToDo=editCouponEnabled&amp;couponId=%d&amp;enabled=1'><img border='0' src='images/cross.gif'></a>", GetLang('ClickToEnableCoupon'), $row['couponid']);
						}*/
						if ($row['couponenabled'] == 1) {
							$GLOBALS['Enabled'] = sprintf("<a title='%s' href='index.php?ToDo=editCouponEnabled%s&amp;couponId=%d&amp;enabled=0'><img border='0' src='images/tick.gif'></a>", GetLang('ClickToDisableCoupon'), isset($_REQUEST['generatetype'])?"&generatetype=1":"",$row['couponid']);
						} else {
							$GLOBALS['Enabled'] = sprintf("<a title='%s' href='index.php?ToDo=editCouponEnabled%s&amp;couponId=%d&amp;enabled=1'><img border='0' src='images/cross.gif'></a>", GetLang('ClickToEnableCoupon'), isset($_REQUEST['generatetype'])?"&generatetype=1":"",$row['couponid']);
						}
						
						//2010-11-03 Ronnie Modify System Can't Edit
						if($row['coupongeneratetype']!='0'){
							$GLOBALS['EditCouponLink']= "";
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
					
					//2010-11-03 Ronnie
					$GLOBALS['Type'] = $row['coupongeneratetype'];
					/*if($row['coupongeneratetype']=="0"){
						$GLOBALS['Type'] = "Manual Generate";
					}else{
						$GLOBALS['Type'] = "System Generate";
					}*/
					
					
					$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("coupons.manage.row");
					$GLOBALS['CouponGrid'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
				}
				$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("coupons.manage.grid");
				return $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
			}
		}

		private function ManageCoupons($MsgDesc = "", $MsgStatus = "")
		{
			//2010-11-23 Ronnie add,generatetype
			if(!isset($_SESSION['CouponGeType'])) $_SESSION['CouponGeType']=0;
			else{
				if(isset($_REQUEST['generatetype'])){
					$_SESSION['CouponGeType']=$_REQUEST['generatetype'];
				}
			}
			$GLOBALS['CouponGeType']=sprintf("<a id='CouponGeType' title='Click here to view unique coupon codes' href='index.php?ToDo=viewCoupons&generatetype=1'>%s</a>","View Unique Coupon Codes");
			if($_SESSION['CouponGeType']==1){
				$GLOBALS['CouponGeType']=sprintf("<a id='CouponGeType' title='Click here to view coupon code' href='index.php?ToDo=viewCoupons&generatetype=0''>%s</a>","View Coupon Codes");
			}			
			
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
			$query = "SELECT * FROM [|PREFIX|]coupons c where 1=1 ";
			$countQuery = "SELECT COUNT(*) FROM [|PREFIX|]coupons where 1=1 ";
			//search Query Ronnie
			if(isset($_REQUEST['searchQuery']) && $_REQUEST['searchQuery']!=''){
				$otherquery=sprintf(" and ( (%s<>'0' and c.%s='%s') or (%s<>0 and c.%s='%s') or (%s<>0 and c.%s='%s') ) ","couponcode","couponcode",$_REQUEST['searchQuery'],"customerid","customerid",$_REQUEST['searchQuery'],"orderid","orderid",$_REQUEST['searchQuery']);
				$query.=$otherquery;
				$countQuery=str_replace("c.", "", $countQuery.$otherquery);
				$GLOBALS["Query"]=$_REQUEST['searchQuery'];
			}

			//2010-11-23 Ronnie add,default is no system generate
			$otherquery2=" and coupongeneratetype='0'";
			if($_SESSION['CouponGeType']==1){
				$otherquery2=" and coupongeneratetype='1'";
			}
			$query.=$otherquery2;
			$countQuery.=$otherquery2;

			$query .="ORDER BY ".$SortField." ".$SortOrder;

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

			$GLOBALS['TdId'] = 0;
			$GLOBALS['promourlval'] = '';
			$GLOBALS['promoidval'] = 0;
			$GLOBALS['PromoTitle'] = "Promotional URL:";
			$GLOBALS['PromotionalURL'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('PromotionalURL');

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
    private function SaveCouponSettings(){
	
        $templateid = $_POST['templateid'];
        $emailid = $_POST['emailid'];  

        //cat - sub cat saving start				
        $catids = array_unique(explode(",",str_replace(" ","",$_POST['catids'])));
        array_pop($catids);
        $comma_separated_cats = implode(",", $catids);

        $subids = array_unique(explode(",",str_replace(" ","",$_POST['subids'])));
        array_pop($subids);
        $comma_separated_subcats = implode(",", $subids);

        // 2011-05-24 johnny add ' where offer = 'yes' ' and $GLOBALS["ISC_CLASS_DB"]->Query()
        $sql1 = " update [|PREFIX|]categories set offer = 'no' where offer = 'yes' ";
        $GLOBALS["ISC_CLASS_DB"]->Query($sql1);

        $sql1 = " update [|PREFIX|]categories set offer = 'yes' where categoryid in (".$comma_separated_cats.") and catparentid = 0 ";
        $GLOBALS["ISC_CLASS_DB"]->Query($sql1);

        $sql2 = " update [|PREFIX|]categories set offer = 'yes' where categoryid in (".$comma_separated_subcats.") and  catparentid in (".$comma_separated_cats.") ";
        $GLOBALS["ISC_CLASS_DB"]->Query($sql2);

        $sqlQueryCat = "update [|PREFIX|]categories c inner join 
                (
                    select t3.catparentid, sum(cnt) flag
                    from 
                    (
                        select t1.catparentid, t1.categoryid, t2.categoryid categoryid2, 
                        case when t2.categoryid is null then 0 else 1 end cnt
                        from
                        (
                        select catparentid, categoryid from isc_categories
                        where catparentid in (".$comma_separated_cats.")
                        ) t1 left join
                        (
                        select categoryid from isc_categories
                        where categoryid in (".$comma_separated_subcats.")
                        ) t2
                        on t1.categoryid = t2.categoryid
                    ) t3
                    group by t3.catparentid having sum(cnt) = 0
                ) tmp
                on c.catparentid = tmp.catparentid or c.categoryid = tmp.catparentid
                set offer = 'yes'";
        $GLOBALS["ISC_CLASS_DB"]->Query($sqlQueryCat);

        //2011-3-22 Ronnie add, Call best price
        $catids3 = array_unique(explode(",",str_replace(" ","",$_POST['catids3'])));
        array_pop($catids3);
        $comma_separated_cats3 = implode(",", $catids3);

        $subids3 = array_unique(explode(",",str_replace(" ","",$_POST['subids3'])));
        array_pop($subids3);
        $comma_separated_subcats3 = implode(",", $subids3);

        // 2011-05-24 johnny add ' where offer = 'yes' ' and $GLOBALS["ISC_CLASS_DB"]->Query()
        $sql1 = " update [|PREFIX|]categories set callbestprice = 'no' where callbestprice = 'yes' ";
        $GLOBALS["ISC_CLASS_DB"]->Query($sql1);
        /*$sql1 = " update [|PREFIX|]categories set callbestprice = 'yes' where categoryid in (".$comma_separated_cats3.") and catparentid = 0 ";
        $GLOBALS["ISC_CLASS_DB"]->Query($sql1);
        $sql2 = " update [|PREFIX|]categories set callbestprice = 'yes' where categoryid in (".$comma_separated_subcats3.") and  catparentid in (".$comma_separated_cats3.") ";
        $GLOBALS["ISC_CLASS_DB"]->Query($sql2);

        foreach ($catids3 as $key => $value) {
            $query1 = " SELECT GROUP_CONCAT( `categoryid` ) AS all_categoryid FROM [|PREFIX|]categories where catparentid =  ".$value."  GROUP BY `catparentid` ";
            $result1 = $GLOBALS['ISC_CLASS_DB']->Query($query1);
            $row1 = $GLOBALS["ISC_CLASS_DB"]->Fetch($result1);
            $all_categoryid = $row1['all_categoryid'];
            $all_categoryid_array = array_unique(explode(",", $all_categoryid));
            $result = array_intersect($subids3, $all_categoryid_array);
            if (count($result) == 0)
            {
                $sql2 = " update isc_categories set callbestprice = 'yes' where catparentid =  ".$value." ";
                mysql_query($sql2);
            }
        }
        */
        $sql2 = " update [|PREFIX|]categories set callbestprice = 'yes' where categoryid in (".$comma_separated_cats3.") and catparentid = 0 ";
        $GLOBALS["ISC_CLASS_DB"]->Query($sql2);
        $sql3 = " update [|PREFIX|]categories set callbestprice = 'yes' where categoryid in (".$comma_separated_subcats3.") and  catparentid in (".$comma_separated_cats3.") ";
        $GLOBALS["ISC_CLASS_DB"]->Query($sql3);

        $sqlQueryCat = "update [|PREFIX|]categories c inner join 
                (
                    select t3.catparentid, sum(cnt) flag
                    from 
                    (
                        select t1.catparentid, t1.categoryid, t2.categoryid categoryid2, 
                        case when t2.categoryid is null then 0 else 1 end cnt
                        from
                        (
                        select catparentid, categoryid from isc_categories
                        where catparentid in (".$comma_separated_cats3.")
                        ) t1 left join
                        (
                        select categoryid from isc_categories
                        where categoryid in (".$comma_separated_subcats3.")
                        ) t2
                        on t1.categoryid = t2.categoryid
                    ) t3
                    group by t3.catparentid having sum(cnt) = 0
                ) tmp
                on c.catparentid = tmp.catparentid or c.categoryid = tmp.catparentid
                set callbestprice = 'yes'";
        $GLOBALS["ISC_CLASS_DB"]->Query($sqlQueryCat);

        // deal with brand
        $brandids3 = array_unique(explode(",",str_replace(" ","",$_POST['brandids3'])));
        array_pop($brandids3);
        $comma_separated_brandids3 = implode(",", $brandids3);

        $seriesids3 = array_unique(explode(",",str_replace(" ","",$_POST['seriesids3'])));
        array_pop($seriesids3);
        $comma_separated_seriesids3 = implode(",", $seriesids3);

        $sql1 = " update [|PREFIX|]brands set callbestprice = 'no' where callbestprice = 'yes' ";
        $GLOBALS["ISC_CLASS_DB"]->Query($sql1);

        $sql1 = " update [|PREFIX|]brands set callbestprice = 'yes' where  brandid in (".$comma_separated_brandids3.") ";
        $GLOBALS["ISC_CLASS_DB"]->Query($sql1);

        $sql2 = " update [|PREFIX|]brand_series set callbestprice = 'no' where callbestprice = 'yes'";
        $GLOBALS["ISC_CLASS_DB"]->Query($sql2);
        
        $sql2 = " update [|PREFIX|]brand_series set callbestprice = 'yes' where seriesid in (".$comma_separated_seriesids3.") and brandid in (".$comma_separated_brandids3.")";
        $GLOBALS["ISC_CLASS_DB"]->Query($sql2);
        $sqlQueryBrandOffer = "update [|PREFIX|]brand_series t4 inner join
                    (
                        select t3.brandid, sum(cnt) flag
                    from (
                        select t1.brandid, t2.seriesid, t2.brandid brandid2, 
                        case when t2.seriesid is null then 0 else 1 end cnt
                        from
                        (SELECT brandid FROM isc_brands WHERE brandid in (".$comma_separated_brandids3.")) t1 
                        left join
                        (SELECT seriesid, brandid FROM isc_brand_series WHERE seriesid in (".$comma_separated_seriesids3.")) t2
                        on t1.brandid = t2.brandid) t3
                    group by t3.brandid having sum(cnt) = 0
                    ) tmp
                    on t4.brandid = tmp.brandid
                    set callbestprice = 'yes'";
        $GLOBALS["ISC_CLASS_DB"]->Query($sqlQueryBrandOffer);
        //cat - sub cat saving end	

        //brand - series saving start	
        $brandids = array_unique(explode(",",str_replace(" ","",$_POST['brandids'])));
        array_pop($brandids);
        $comma_separated_brandids = implode(",", $brandids);

        $seriesids = array_unique(explode(",",str_replace(" ","",$_POST['seriesids'])));
        array_pop($seriesids);
        $comma_separated_seriesids = implode(",", $seriesids);

        $sql1 = " update [|PREFIX|]brands set offer = 'no' where offer = 'yes'";
        $GLOBALS["ISC_CLASS_DB"]->Query($sql1);

        $sql1 = " update [|PREFIX|]brands set offer = 'yes' where  brandid in (".$comma_separated_brandids.") ";
        $GLOBALS["ISC_CLASS_DB"]->Query($sql1);

        $sql2 = " update [|PREFIX|]brand_series set offer = 'no' where offer = 'yes'";
        $GLOBALS["ISC_CLASS_DB"]->Query($sql2);

        $sql2 = " update [|PREFIX|]brand_series set offer = 'yes' where seriesid in (".$comma_separated_seriesids.") and brandid in (".$comma_separated_brandids.")";
        $GLOBALS["ISC_CLASS_DB"]->Query($sql2);
        $sqlQueryBrandOffer = "update [|PREFIX|]brand_series t4 inner join
                    (
                        select t3.brandid, sum(cnt) flag
                    from (
                        select t1.brandid, t2.seriesid, t2.brandid brandid2, 
                        case when t2.seriesid is null then 0 else 1 end cnt
                        from
                        (SELECT brandid FROM isc_brands WHERE brandid in (".$comma_separated_brandids.")) t1 
                        left join
                        (SELECT seriesid, brandid FROM isc_brand_series WHERE seriesid in (".$comma_separated_seriesids.")) t2
                        on t1.brandid = t2.brandid) t3
                    group by t3.brandid having sum(cnt) = 0
                    ) tmp
                    on t4.brandid = tmp.brandid
                    set offer = 'yes'";
        $GLOBALS["ISC_CLASS_DB"]->Query($sqlQueryBrandOffer);

        //brand - series saving end

        $WYSIWYG = $this->FormatWYSIWYGHTML($_POST['wysiwyg']);
        $WYSIWYG1 = $this->FormatWYSIWYGHTML($_POST['wysiwyg1']);  
        $WYSIWYG2 = $this->FormatWYSIWYGHTML($_POST['wysiwyg2']);  
        $WYSIWYG3 = $this->FormatWYSIWYGHTML($_POST['wysiwyg3']);  

        $GLOBALS['ISC_CLASS_DB']->DeleteQuery('coupon_settings', ' where 1');
        $insertCouponSettings = array();

        if (isset($_POST['popupmessage']['catids'])) {
            foreach ($_POST['popupmessage']['catids'] as $catid => $message) {
                $insertCouponSettings[] = array(
                    "title_msg" => $WYSIWYG,
                    "header_msg" => $WYSIWYG1,
                    "footer_msg" => $WYSIWYG2,
                    "email_template" => $WYSIWYG3,
                    "emailids" => $emailid,
                    "popupmessage" => empty($message) ? '' : substr($message, 0, 490),
                    "displayfor" => $_POST['displayfor'],
                    'catid' => $catid,
                    'display_script' => $_POST['displayScript']['catids'][$catid]
                );
            }
        }
        if (isset($_POST['popupmessage']['brandids'])) {
            foreach ($_POST['popupmessage']['brandids'] as $brandid => $message) {
                $insertCouponSettings[] = array(
                    "title_msg" => $WYSIWYG,
                    "header_msg" => $WYSIWYG1,
                    "footer_msg" => $WYSIWYG2,
                    "email_template" => $WYSIWYG3,
                    "emailids" => $emailid,
                    "popupmessage" => empty($message) ? '' : substr($message, 0, 490),
                    "displayfor" => $_POST['displayfor'],
                    'brandid' => $brandid,
                    'display_script' => $_POST['displayScript']['brandids'][$brandid]
                );
            }
        }

        foreach ($insertCouponSettings as $set) {
            $GLOBALS['ISC_CLASS_DB']->InsertQuery('coupon_settings', $set);
        }
        
        header("location:index.php?ToDo=Couponssettings"."&tab=".$_POST['currentTab']);
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
			//echo $query;
			$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
			if ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
				$RefArray = $row;
			}
			$GLOBALS['templateid'] = $RefArray['templateid'];
			$GLOBALS['emailids'] = $RefArray['emailids'];
			
			//2011-3-28 Ronnie add
			if($RefArray['displayfor']=="entireday")
			{
				$GLOBALS['entireday_Checked'] = 'checked="checked"';
			}elseif($RefArray['displayfor']=="customerservice"){
				$GLOBALS['customerservicehours_Checked'] = 'checked="checked"';
			}

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
			$GLOBALS['catids3'] = '';
			$GLOBALS['subids3'] = '';
			$GLOBALS['brandids3']  = '';
			$GLOBALS['seriesids3']  = '';

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



			$queryc = " SELECT count(categoryid) as cntcat   FROM [|PREFIX|]categories where  catparentid	 =  ".$row['categoryid'] ." ";
			$resultc = $GLOBALS['ISC_CLASS_DB']->Query($queryc);
			$rowc = $GLOBALS["ISC_CLASS_DB"]->Fetch($resultc);

			$c=0;
			$temp = '';
			$temptable1 = '';
			$query1 = " SELECT `categoryid` , `catname`   FROM [|PREFIX|]categories where offer = 'yes' and catparentid	 =  ".$row['categoryid'] ." order by catname ASC ";
			$result1 = $GLOBALS['ISC_CLASS_DB']->Query($query1);
			while ($row1 = $GLOBALS["ISC_CLASS_DB"]->Fetch($result1))
				{
				$c++;
				$temptable1.= $row1['catname']." , ";
				$GLOBALS['subids'].=  $row1['categoryid'].", " ;
				$temp.= $row1['categoryid'].", " ;
				}
			if (mysql_num_rows($result1) == 0 or $rowc['cntcat'] == $c) 
			{
				$temptable1 = "All Subcategories";
				$GLOBALS['subids'] = str_replace($temp, "", $GLOBALS['subids']);
			}
			$temptable.=$temptable1. "</div></td></tr>";
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

			$querys = " SELECT count(*) as cntseries FROM [|PREFIX|]brand_series where brandid = ".$row['brandid']." ";
			$results = $GLOBALS['ISC_CLASS_DB']->Query($querys);
			$rows = $GLOBALS["ISC_CLASS_DB"]->Fetch($results);


			$query1 = " SELECT seriesid , seriesname   FROM [|PREFIX|]brand_series where offer = 'yes' and brandid = ".$row['brandid']." order by seriesname asc";
			$result1 = $GLOBALS['ISC_CLASS_DB']->Query($query1);
			$b=0;
			$temp = '';
			$temptable1 = '';
			while ($row1 = $GLOBALS["ISC_CLASS_DB"]->Fetch($result1))
				{
				$b++;
				$temptable1.= $row1['seriesname']." , ";
				$GLOBALS['seriesids'].=  $row1['seriesid'].", " ;
				$temp.= $row1['seriesid'].", " ;
				}
				if (mysql_num_rows($result1) == 0 or $b == $rows['cntseries']) 
				{
					$temptable1 = "All Series";
					$GLOBALS['seriesids'] = str_replace($temp, "", $GLOBALS['seriesids']);
				}
				$temptable.=$temptable1. "</div></td></tr>";

		}

	$temptable.= '</table>';
    $GLOBALS['div_content']	= $temptable;
    
    $temptable = '';
	
	//retrive cat - subcat info from data base
	$query2 = " SELECT `categoryid` , `catname`   FROM [|PREFIX|]categories where callbestprice = 'yes' and catparentid	 = 0  order by catname ASC ";
	$result2 = $GLOBALS['ISC_CLASS_DB']->Query($query2);
	while ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result2))
		{
			$GLOBALS['catids3'].= $row['categoryid'].", " ;
			$temptable.= '<tr id = '.$row['categoryid'].'>	<td><a href="javascript:deleteRow3('.$row['categoryid'].',\'dataTable3\')">Remove</a>  </td>';

			$temptable.= "<td>".$row['catname']."</td>";
			$temptable.= "<td><div id=\"sub3_".$row['categoryid']."\">";



			$queryc = " SELECT count(categoryid) as cntcat   FROM [|PREFIX|]categories where  catparentid	 =  ".$row['categoryid'] ." ";
			$resultc = $GLOBALS['ISC_CLASS_DB']->Query($queryc);
			$rowc = $GLOBALS["ISC_CLASS_DB"]->Fetch($resultc);

			$c=0;
			$temp = '';
			$temptable1 = '';
			$query1 = " SELECT `categoryid` , `catname`   FROM [|PREFIX|]categories where callbestprice = 'yes' and catparentid	 =  ".$row['categoryid'] ." order by catname ASC ";
			$result1 = $GLOBALS['ISC_CLASS_DB']->Query($query1);
			//var_dump( mysql_num_rows($result1));
			while ($row1 = $GLOBALS["ISC_CLASS_DB"]->Fetch($result1))
				{
				$c++;
				$temptable1.= $row1['catname']." , ";
				$GLOBALS['subids3'].=  $row1['categoryid'].", " ;
				$temp.= $row1['categoryid'].", " ;
				}
			if (mysql_num_rows($result1) == 0 or $rowc['cntcat'] == $c) 
			{
				$temptable1 = "All Subcategories";
				$GLOBALS['subids3'] = str_replace($temp, "", $GLOBALS['subids3']);
			}
			$temptable.=$temptable1. "</div></td>";
            $query = "SELECT popupmessage,display_script FROM [|PREFIX|]coupon_settings WHERE catid={$row['categoryid']} LIMIT 1";
            $GLOBALS['ISC_CLASS_DB']->FreeResult($result1);
            $couponSettings = $GLOBALS["ISC_CLASS_DB"]->Fetch($GLOBALS['ISC_CLASS_DB']->Query($query));
            $temptable .= '<td style="width:30%;"><textarea name="popupmessage[catids][' . $row['categoryid'] . ']" style="width: 100%;">' . ($couponSettings ? $couponSettings['popupmessage'] : '') . '</textarea></td>';
            $temptable .= '<td style="width:30%;"><textarea name="displayScript[catids][' . $row['categoryid'] . ']" style="width: 100%;">' . ($couponSettings ? $couponSettings['display_script'] : '') . '</textarea></td>';
            $temptable .= '</tr>';
		}
        
	//retrive brand - series info from data base
	
	$query2 = " SELECT brandid ,   	brandname   FROM [|PREFIX|]brands where callbestprice = 'yes'  order by brandname asc";
	$result2 = $GLOBALS['ISC_CLASS_DB']->Query($query2);
	while ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result2))
		{
			$GLOBALS['brandids3'].= $row['brandid'].", " ;
			$temptable.= '<tr id = '.$row['brandid'].'>	<td><a href="javascript:deletebrand3('.$row['brandid'].',\'dataTable3\')">Remove</a>  </td>';
			$temptable.= "<td>".$row['brandname']."</td>";
			$temptable.= "<td><div id=\"ser3_".$row['brandid']."\">";

			$querys = " SELECT count(*) as cntseries FROM [|PREFIX|]brand_series where brandid = ".$row['brandid']." ";
			$results = $GLOBALS['ISC_CLASS_DB']->Query($querys);
			$rows = $GLOBALS["ISC_CLASS_DB"]->Fetch($results);
            

			$query1 = " SELECT seriesid , seriesname   FROM [|PREFIX|]brand_series where callbestprice = 'yes' and brandid = ".$row['brandid']." order by seriesname asc";
			$result1 = $GLOBALS['ISC_CLASS_DB']->Query($query1);
			$b=0;
			$temp = '';
			$temptable1 = '';
			while ($row1 = $GLOBALS["ISC_CLASS_DB"]->Fetch($result1))
				{
				$b++;
				$temptable1.= $row1['seriesname']." , ";
				$GLOBALS['seriesids3'].=  $row1['seriesid'].", " ;
				$temp.= $row1['seriesid'].", " ;
				}
				if (mysql_num_rows($result1) == 0 or $b == $rows['cntseries']) 
				{
					$temptable1 = "All Series";
					$GLOBALS['seriesids3'] = str_replace($temp, "", $GLOBALS['seriesids3']);
				}
				$temptable.=$temptable1. "</div></td>";
               
                $query = "SELECT popupmessage,display_script FROM [|PREFIX|]coupon_settings WHERE brandid={$row['brandid']} LIMIT 1";
                $GLOBALS['ISC_CLASS_DB']->FreeResult($result1);
                $couponSettings = $GLOBALS["ISC_CLASS_DB"]->Fetch($GLOBALS['ISC_CLASS_DB']->Query($query));
                $temptable .= '<td style="width:30%;"><textarea name="popupmessage[brandids][' . $row['brandid'] . ']" style="width: 100%;">' . ($couponSettings ? $couponSettings['popupmessage'] : '') . '</textarea></td>';
                $temptable .= '<td style="width:30%;"><textarea name="displayScript[brandids][' . $row['brandid'] . ']" style="width: 100%;">' . ($couponSettings ? $couponSettings['display_script'] : '') . '</textarea></td>';
                $temptable .= '</tr>';
		}

            $GLOBALS['div_content3']	= $temptable;
    
			$GLOBALS['PopupMessage']	= $RefArray['popupmessage'];


			$GLOBALS['SelectedProducts'] = '';
			$GLOBALS['ProductIds'] = '';
			$query = "SELECT productid, prodname FROM [|PREFIX|]products WHERE offer = 'yes' ORDER BY prodname ASC";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$GLOBALS['SelectedProducts'] .= sprintf("<option value='%d'>%s</option>", $row['productid'], $row['prodname']);
				$GLOBALS['ProductIds'] .= $row['productid'].",";
			}
			$GLOBALS['ProductIds'] = isc_substr($GLOBALS['ProductIds'], 0, -1);

			$GLOBALS['tab']=0;
			if(isset($_REQUEST['tab'])){
				$GLOBALS['tab']=$_REQUEST['tab'];
			}
			
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
//				$_POST['couponexpires'] = ConvertDateToTime($_POST['couponexpires']); -- commented due to, it saving the date as selected date with 00:00:00. Its wrong, so we have added manual expiration time -- Baskaran
                $vals = explode("/", $_POST['couponexpires']);
                $mktime = mktime(23, 59, 59, $vals[0], $vals[1], $vals[2]);
                $_POST['couponexpires'] = $mktime;
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
				$this->SavePromotionalURL($CouponId,'add');
			}
			else {
				$coupon->load($CouponId);
				$coupon->save();
				$this->SavePromotionalURL($CouponId,'edit');
			}

			if(!$coupon->error) {
				// Log this action
				$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($CouponId, $_POST['couponcode']);
			}

			return $coupon->error;
		}

		private function SavePromotionalURL($couponid,$type)
		{
			$_POST['promotionidhidden'] = isset($_POST['promotionidhidden']) ? $_POST['promotionidhidden'] : array();
			$_POST['promotionurl'] = isset($_POST['promotionurl']) ? $_POST['promotionurl'] : array();

			if($type == 'edit')
			{
				$existing_pid = array();
				$delids = array();
				$cc_query = "select group_concat(srno) as promoids from [|PREFIX|]promocouponassoc where couponid = $couponid ";
				$cc_result = $GLOBALS['ISC_CLASS_DB']->Query($cc_query);
				$cc_array = $GLOBALS['ISC_CLASS_DB']->Fetch($cc_result);
				
				if(isset($cc_array['promoids']))
				{
					$existing_pid = explode(",",$cc_array['promoids']);
				}
				
				$delids = array_diff($existing_pid,$_POST['promotionidhidden']);

				if(!empty($delids))
				{
					$del_qry = "DELETE from [|PREFIX|]promocouponassoc where srno in (".implode(",",$delids).")";
					$GLOBALS['ISC_CLASS_DB']->Query($del_qry);
				}
				
			}

			foreach( $_POST['promotionidhidden'] as $key => $val )
			{
				if($val == 0)
				{
					if(trim($_POST['promotionurl'][$key]) != '')
					{
						$query = "INSERT into [|PREFIX|]promocouponassoc(couponid,promotional_url) values( $couponid, '".$GLOBALS['ISC_CLASS_DB']->Quote($_POST['promotionurl'][$key])."')";
						$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
					}
				}
				else
				{
					if(trim($_POST['promotionurl'][$key]) != '')
					{
						$query = "update [|PREFIX|]promocouponassoc set promotional_url = '".$GLOBALS['ISC_CLASS_DB']->Quote($_POST['promotionurl'][$key])."' where srno = ".$val;
						$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
					}
					else
					{
						$del_qry = "DELETE from [|PREFIX|]promocouponassoc where srno = $val";
						$GLOBALS['ISC_CLASS_DB']->Query($del_qry);
					}
				}
			}
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
					//if($arrData['couponappliestovalues'] == "0") { Commented for '0' value not selected --Baskaran
					if(in_array('0', $sel_cats)) {
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

				/* Promotional URL functionality */

				$html = "";
				$cc_query = "select srno , promotional_url from [|PREFIX|]promocouponassoc where couponid = $couponId order by srno ";
				$cc_result = $GLOBALS['ISC_CLASS_DB']->Query($cc_query);
				$i = 0;
				$GLOBALS['PromoTitle'] = "Promotional URL:";
				while($cc_array = $GLOBALS['ISC_CLASS_DB']->Fetch($cc_result))
				{
					$GLOBALS['TdId'] = $i++;
					$GLOBALS['promourlval'] = $cc_array['promotional_url'];
					$GLOBALS['promoidval'] = $cc_array['srno'];
					$html .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('PromotionalURL');
					$GLOBALS['PromoTitle'] = "";
				}
				
				if($html != "")
				{
					$GLOBALS['PromotionalURL'] = $html;
				}
				else
				{
					$GLOBALS['TdId'] = 0;
					$GLOBALS['promourlval'] = '';
					$GLOBALS['promoidval'] = 0;
					$GLOBALS['PromotionalURL'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('PromotionalURL');
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