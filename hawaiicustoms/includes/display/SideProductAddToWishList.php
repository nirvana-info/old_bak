<?php

	CLASS ISC_SIDEPRODUCTADDTOWISHLIST_PANEL extends PANEL
	{
		function SetPanelSettings()
		{
			$GLOBALS['ProductId'] = $GLOBALS['ISC_CLASS_PRODUCT']->GetProductId();

			//temp script to shortern the product name

			$pid  = $GLOBALS['ISC_CLASS_PRODUCT']->GetProductId();
			$querytemp = "SELECT prodbrandid FROM  [|PREFIX|]products where productid = ".$pid."  ";
			$resulttemp = $GLOBALS['ISC_CLASS_DB']->Query($querytemp);
			$brand = $GLOBALS['ISC_CLASS_DB']->Fetch($resulttemp);

			if ($brand['prodbrandid'] == 37)
			{

				$query = "SELECT c.catname, c.catcombine FROM [|PREFIX|]categories 	c left join [|PREFIX|]categoryassociations ca on c.categoryid = ca.categoryid  left join [|PREFIX|]products p on ca.productid = p.productid where p.productid =  '".$GLOBALS['ISC_CLASS_PRODUCT']->GetProductId()."' ";
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				$cat = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

				if ($cat['catcombine'] != "")
				$GLOBALS['ProductName'] = $cat['catcombine']." Part Number ".isc_html_escape($GLOBALS['ISC_CLASS_PRODUCT']->GetSKU());
				else
				$GLOBALS['ProductName'] = $cat['catname']." Part Number ".isc_html_escape($GLOBALS['ISC_CLASS_PRODUCT']->GetSKU());
			}
			else
			{
				$GLOBALS['ProductName'] = isc_html_escape($GLOBALS['ISC_CLASS_PRODUCT']->GetProductName());
			}
			//temp script to shortern the product name
			//$GLOBALS['ProductName'] = $GLOBALS['ISC_CLASS_PRODUCT']->GetProductName();


			$wishLists = $this->LoadCustomerWishLists();
			$GLOBALS['WishLists'] = '';

			$i=0;
			foreach ($wishLists as $wishlist) {
				if ($i == 0) {
					$checked = 'checked';
				} else {
					$checked = '';
				}
				$GLOBALS['WishLists'] .= '<input type="radio" name="wishlistid" id="wishlistid'.(int)$wishlist['wishlistid'].'" value="'.(int)$wishlist['wishlistid'].'" '.$checked.' /> <label for="wishlistid'.(int)$wishlist['wishlistid'].'">'. isc_html_escape($wishlist['wishlistname']).'</label><br />';
				++$i;
			}
		}

		function LoadCustomerWishLists()
		{
			$wishLists = array();
			if(CustomerIsSignedIn()) {
				$GLOBALS['ISC_CLASS_CUSTOMER'] = GetClass('ISC_CUSTOMER');
				$customer_id = $GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerId();

				// get customer's wish list from database
				$query = "SELECT * FROM [|PREFIX|]wishlists WHERE customerid = ".$customer_id;
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					$wishLists[] = $row;
				}
			}
			return $wishLists;
		}
	}
?>