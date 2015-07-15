<?php

	CLASS ISC_SUGGESTIVECARTCONTENT_PANEL extends PANEL
	{
		public function SetPanelSettings()
		{

			$count = 0;
			$prod_ids = array();
			$output = "";

			$GLOBALS['SuggestedProductListing'] = "";

			// Hide the "compare" checkbox for each product
			$GLOBALS['HideCompareItems'] = "none";

			// Make sure the query doesn't return the product we're adding to
			// the cart or any other products in the cart for that matter
			$GLOBALS['ISC_CLASS_CART'] = GetClass('ISC_CART');
			$ignore_prod_list = $GLOBALS['ISC_CLASS_CART']->api->GetProductsInCartCSV();
			if($ignore_prod_list == "") {
				$ignore_prod_list = 0;
			}
			$query = "
				SELECT ordprodid
				FROM [|PREFIX|]order_products
				WHERE orderorderid IN (
					SELECT orderorderid FROM [|PREFIX|]order_products WHERE ordprodid='".(int)$GLOBALS['ProductJustAdded']."'
				) AND ordprodid NOT IN (".$ignore_prod_list.")
				GROUP BY ordprodid
				ORDER BY COUNT(ordprodid) DESC
			";
			$query .= $GLOBALS['ISC_CLASS_DB']->AddLimit(0, 9);
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			// Get the list of suggested product id's
			while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$prod_ids[] = $row['ordprodid'];
			}

			$suggest_prod_ids = implode(",", $prod_ids);

			$remaining_places = 9-count($prod_ids);
			// If there aren't enough products to suggest, we will get
			// the popular products (based on reviews) instead

			// If there aren't enough suggested products, fetch related products for this item
			if($remaining_places > 0) {
				require_once(APP_ROOT."/includes/classes/class.product.php");
				$related = GetRelatedProducts($GLOBALS['Product']['productid'], $GLOBALS['Product']['prodname'], $GLOBALS['Product']['prodrelatedproducts']);

				// Any returned products? add them to the list
				$relatedProducts = explode(",", $related);
				// Limit the number of products to the # of empty spaces we have
				for($i = 0; $i <= $remaining_places; ++$i) {
					if(!isset($relatedProducts[$i]) || $relatedProducts[$i] == "") {
						break;
					}

					if(!in_array($relatedProducts[$i], $prod_ids) && !@in_array($relatedProducts[$i], $ignore_prod_list)) {
						$prod_ids[] = $relatedProducts[$i];
					}

				}

				$remaining_places = 9-count($prod_ids);
				$suggest_prod_ids = implode(",", $prod_ids);
			}
			// Still don't have enough? Fetch popular products
			if($remaining_places > 0) {
				if(!$suggest_prod_ids) {
					$suggest_prod_ids = 0;
				}

				$query = sprintf("select productid, floor(prodratingtotal/prodnumratings) as prodavgrating from [|PREFIX|]products where productid not in (%s) and productid not in (%s) and prodvisible='1' order by prodavgrating desc", $suggest_prod_ids, $ignore_prod_list);
				$query .= $GLOBALS['ISC_CLASS_DB']->AddLimit(0, $remaining_places);
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

				// Is there at least one product to suggest?
				while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					$prod_ids[] = $row['productid'];
				}

				$suggest_prod_ids = implode(",", $prod_ids);
			}

			// If there are *still* no products to suggest, just show them
			// the normal shopping cart view instead

			if(!empty($prod_ids)) {
				// Get a list of products that were ordered at the
				// same time as the product that was just added to the cart
				if(!$suggest_prod_ids) {
					$suggest_prod_ids = 0;
				}

				if(GetConfig('EnableProductReviews') == 0) {
					$GLOBALS['HideProductRating'] = "display: none";
				}

				$query = "
					SELECT p.*, FLOOR(prodratingtotal/prodnumratings) AS prodavgrating, imageisthumb, imagefile, ".GetProdCustomerGroupPriceSQL()."
					FROM [|PREFIX|]products p
					LEFT JOIN [|PREFIX|]product_images pi ON (p.productid=pi.imageprodid)
					WHERE p.productid IN (".$suggest_prod_ids.") AND p.prodvisible='1' AND (imageisthumb=1 OR ISNULL(imageisthumb))
					".GetProdCustomerGroupPermissionsSQL()."
					ORDER BY prodnumsold DESC, prodratingtotal DESC
				";
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

				$GLOBALS['AlternateClass'] = '';
				while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					if($GLOBALS['AlternateClass'] == 'Odd') {
						$GLOBALS['AlternateClass'] = 'Even';
					}
					else {
						$GLOBALS['AlternateClass'] = 'Odd';
					}

					$GLOBALS['ProductCartQuantity'] = '';
					if(isset($GLOBALS['CartQuantity'.$row['productid']])) {
						$GLOBALS['ProductCartQuantity'] = (int)$GLOBALS['CartQuantity'.$row['productid']];
					}

					$GLOBALS['ProductId'] = (int) $row['productid'];
					$GLOBALS['ProductName'] = isc_html_escape($row['prodname']);
					$GLOBALS['ProductLink'] = ProdLink($row['prodname']);
					$GLOBALS['ProductRating'] = (int)$row['prodavgrating'];

					// Determine the price of this product
					$GLOBALS['ProductPrice'] = CalculateProductPrice_retail($row);

					$GLOBALS['ProductThumb'] = ImageThumb($row['imagefile'], ProdLink($row['prodname']));

					if (isId($row['prodvariationid']) || trim($row['prodconfigfields'])!='' || $row['prodeventdaterequired'] == 1) {
						$GLOBALS['ProductURL'] = ProdLink($row['prodname']);
						$GLOBALS['ProductAddText'] = GetLang('ProductChooseOptionLink');
					} else {
						//$GLOBALS['ProductURL'] = CartLink($row['productid']);
							$GLOBALS['ProductURL'] = ProdLink($row['prodname']);
						//blessen
							if (intval($row['prodretailprice']) <= 0 )
							{
								$GLOBALS['ProductAddText'] = GetLang('ProductAddToCartLink');
							}
							else
							{
								$GLOBALS['ProductAddText'] = GetLang('ProductAddToCartLink1');
							}
							//blessen
						//$GLOBALS['ProductAddText'] = GetLang('ProductAddToCartLink');
					}

					if (CanAddToCart($row) && GetConfig('ShowAddToCartLink')) {
						$GLOBALS['HideActionAdd'] = '';
					} else {
						$GLOBALS['HideActionAdd'] = 'none';
					}

					$GLOBALS['HideProductVendorName'] = 'display: none';
					$GLOBALS['ProductVendor'] = '';
					if(GetConfig('ShowProductVendorNames') && $row['prodvendorid'] > 0) {
						$vendorCache = $GLOBALS['ISC_CLASS_DATA_STORE']->Read('Vendors');
						if(isset($vendorCache[$row['prodvendorid']])) {
							$GLOBALS['ProductVendor'] = '<a href="'.VendorLink($vendorCache[$row['prodvendorid']]).'">'.isc_html_escape($vendorCache[$row['prodvendorid']]['vendorname']).'</a>';
							$GLOBALS['HideProductVendorName'] = '';
						}
					}

					$GLOBALS['SuggestedProductListing'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("CategoryProductsItem");
				}
			}

			if(!$GLOBALS['SuggestedProductListing']) {
				ob_end_clean();
				header("Location:cart.php");
				die();
			}
		}
	}

?>
