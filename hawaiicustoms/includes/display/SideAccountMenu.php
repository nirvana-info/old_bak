<?php

	CLASS ISC_SIDEACCOUNTMENU_PANEL extends PANEL
	{
		public function SetPanelSettings()
		{

			$GLOBALS['ISC_CLASS_CUSTOMER'] = GetClass('ISC_CUSTOMER');
			$customerid = $GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerId();
			
			
	if ($GLOBALS['EnableSEOUrls'] == 1)
			{
$GLOBALS['account_inbox'] = "account/inbox";
$GLOBALS['account_order_status'] = "account/order_status";
$GLOBALS['account_view_orders'] = "account/view_orders";
$GLOBALS['account_view_returns'] = "account/view_returns";
$GLOBALS['account_address_book'] = "account/address_book";
$GLOBALS['wishlist'] = "wishlist";
$GLOBALS['account_account_details'] = "account/account_details";
$GLOBALS['account_recent_items'] = "account/recent_items";
$GLOBALS['account_reports'] = "account/reports";
$GLOBALS['account_uploadimage'] = "account/uploadimage";
$GLOBALS['account_uploadimages'] = "account/uploadimages";
$GLOBALS['account_showimage'] = "account/showimage";
$GLOBALS['account_logout'] = "logout";

			}
			else
			{
$GLOBALS['account_inbox'] = "account.php?action=inbox";
$GLOBALS['account_order_status'] = "account.php?action=order_status";
$GLOBALS['account_view_orders'] = "account.php?action=view_orders";
$GLOBALS['account-view_returns'] = "account.php?action=view_returns";
$GLOBALS['account_address_book'] = "account.php?action=address_book";
$GLOBALS['wishlist'] = "wishlist.php";
$GLOBALS['account_account_details'] = "account.php?action=account_details";
$GLOBALS['account_recent_items'] = "account.php?action=recent_items";
$GLOBALS['account_reports'] = "account.php?action=reports";
$GLOBALS['account_uploadimage'] = "account.php?action=uploadimage";
$GLOBALS['account_uploadimages'] = "account.php?action=uploadimages";
$GLOBALS['account_showimage'] = "account.php?action=showimage";
$GLOBALS['account_logout'] = "account.php?action=logout";

			}


			if(gzte11(ISC_LARGEPRINT)) {
				// Get the number of new messages for this customer
				$order_ids = "";

				$query = sprintf("select orderid from [|PREFIX|]orders where ordcustid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($customerid));
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

				while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					$order_ids .= sprintf("%s,", $row['orderid']);
				}

				$order_ids = rtrim($order_ids, ",");
				if($order_ids != "") {
					$query = sprintf("select count(messageid) as num from [|PREFIX|]order_messages where messageorderid in (%s) and messagefrom='admin' and messagestatus='unread'", $GLOBALS['ISC_CLASS_DB']->Quote($order_ids));
					$GLOBALS['NumNewMessages'] = $GLOBALS['ISC_CLASS_DB']->FetchOne($query);
				}
				else {
					$GLOBALS['NumNewMessages'] = 0;
				}
			}
			else {
				$GLOBALS['HideMessagesMenu'] = "none";
			}

			// Do we want to show or hide the return requests menu item?
			if(gzte11(ISC_LARGEPRINT) && GetConfig('EnableReturns') == 1) {
				$query = sprintf("SELECT returnid FROM [|PREFIX|]returns WHERE retcustomerid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($customerid));
				if(!$GLOBALS['ISC_CLASS_DB']->FetchOne($query)) {
					$GLOBALS['HideReturnRequestsMenu'] = "none";
				}
			}
			else {
				$GLOBALS['HideReturnRequestsMenu'] = 'none';
			}

			// How many products are in their wish list?
			$query = sprintf("select count(wishlistid) as num from [|PREFIX|]wishlists where customerid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($customerid));
			$GLOBALS['NumWishListItems'] = $GLOBALS['ISC_CLASS_DB']->FetchOne($query);
		}
	}

?>