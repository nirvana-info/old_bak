<?php

	CLASS ISC_SIDEACCOUNTMENU_PANEL extends PANEL
	{
		public function SetPanelSettings()
		{

			$GLOBALS['ISC_CLASS_CUSTOMER'] = GetClass('ISC_CUSTOMER');
			$customerid = $GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerId();

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