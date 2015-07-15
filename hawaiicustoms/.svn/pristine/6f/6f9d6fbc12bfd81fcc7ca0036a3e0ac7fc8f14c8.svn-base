<?php

	CLASS ISC_SIDEPRODUCTRECENTLYVIEWED_PANEL extends PANEL
	{
		public function SetPanelSettings()
		{

			$viewed = "";

			if(isset($_COOKIE['RECENTLY_VIEWED_PRODUCTS'])) {
				$viewed = $_COOKIE['RECENTLY_VIEWED_PRODUCTS'];
			}
			else if(isset($_SESSION['RECENTLY_VIEWED_PRODUCTS'])) {
				$viewed = $_SESSION['RECENTLY_VIEWED_PRODUCTS'];
			}

			$GLOBALS['CompareLink'] = CompareLink();

			if($viewed != "") {

				// Hide the top selling products panel from the cart page
				$GLOBALS['HideSideTopSellersPanel'] = "none";

				$output = "";
				$viewed_products = array();
				$viewed_products = explode(",", $viewed);

				foreach ($viewed_products as $k => $p) {
					$viewed_products[$k] = (int) $p;
				}

				// Reverse the array so recently viewed products appear up top
				$viewed_products = array_reverse($viewed_products);

				// Hide the compare button if there's less than 2 products
				if(GetConfig('EnableProductComparisons') == 0 || count($viewed_products) < 2) {
					$GLOBALS['HideSideProductRecentlyViewedCompare'] = "none";
				}

				if(!empty($viewed_products)) {

					if(GetConfig('EnableProductReviews') == 0) {
						$GLOBALS['HideProductRating'] = "display: none";
					}

					$query = "
						SELECT p.*, prodratingtotal/prodnumratings AS prodavgrating, i.imagefile, i.imageisthumb, ".GetProdCustomerGroupPriceSQL()."
						FROM [|PREFIX|]products p
						LEFT JOIN [|PREFIX|]product_images i ON (p.productid = i.imageprodid AND i.imageisthumb=1)
						WHERE prodvisible='1' AND productid IN ('".implode("','", $viewed_products)."')
					";
					$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

					if($GLOBALS['ISC_CLASS_DB']->CountResult($result) > 0) {
						while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
							$recently_viewed_products[] = $row;
						}

						$GLOBALS['AlternateClass'] = '';
						foreach($viewed_products as $product_id) {
							foreach($recently_viewed_products as $row) {
								if($product_id == $row['productid']) {

									if($GLOBALS['AlternateClass'] == 'Odd') {
										$GLOBALS['AlternateClass'] = 'Even';
									}
									else {
										$GLOBALS['AlternateClass'] = 'Odd';
									}

									$GLOBALS['ProductThumb'] = ImageThumb($row['imagefile'], ProdLink($row['prodname']));

									$GLOBALS['ProductCartQuantity'] = '';
									if(isset($GLOBALS['CartQuantity'.$row['productid']])) {
										$GLOBALS['ProductCartQuantity'] = (int)$GLOBALS['CartQuantity'.$row['productid']];
									}

									$GLOBALS['ProductId'] = (int) $row['productid'];

									//temp script to shortern the product name
									if ($row['prodbrandid'] == 37)
									{

										$query = "SELECT c.catname, c.catcombine FROM [|PREFIX|]categories 	c left join [|PREFIX|]categoryassociations ca on c.categoryid = ca.categoryid  left join [|PREFIX|]products p on ca.productid = p.productid where p.productid =  '".$row['productid']."' ";
										$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
										$cat = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

										if ($cat['catcombine'] != "")
										$GLOBALS['ProductName'] = $cat['catcombine']." Part Number ".isc_html_escape($row['prodcode']);
										else
										$GLOBALS['ProductName'] = $cat['catname']." Part Number ".isc_html_escape($row['prodcode']);
									}
									else
									{
										$GLOBALS['ProductName'] = isc_html_escape($row['prodname']);
									}
									//temp script to shortern the product name
									
									
									//$GLOBALS['ProductName'] = isc_html_escape($row['prodname']);



									$GLOBALS['ProductLink'] = ProdLink($row['prodname']);

									// Determine the price of this product
									$GLOBALS['ProductPrice'] = CalculateProductPrice_retail($row);

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

									$GLOBALS['ProductRating'] = $this->getRoundValue((float)$row['prodavgrating']);
									$output .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideRecentlyViewedProducts");
								}
							}
						}
					}
					else {
						$GLOBALS['HideRecentlyViewedProductsPanel'] = "none";
						$this->DontDisplay = true;
					}
				}
				else {
					$GLOBALS['HideRecentlyViewedProductsPanel'] = "none";
					$this->DontDisplay = true;
				}

				$GLOBALS['SNIPPETS']['SideProductRecentlyViewed'] = $output;
			}
			else {
				// Cookies aren't working, hide the panel
				$GLOBALS['HideRecentlyViewedProductsPanel'] = "none";
				$this->DontDisplay = true;
			}
		}
		
		
	 //process num,return int,int+0.5.
        // just show the right rating images.
        private function getRoundValue($num)
        {
        	$i = floor($num);
        	$r = $num-$i;
        	if($r <0.3)
        	{
        		return $i;
        	}
        	else if($r >0.7)
        	{
        		return round($num);
        	}
        	else 
        	{
        		return $i + 0.5;
        	}
        }
	}

?>
