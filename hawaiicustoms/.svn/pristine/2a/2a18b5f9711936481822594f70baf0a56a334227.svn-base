<?php

	CLASS ISC_HOMEFEATUREDPRODUCTS_PANEL extends PANEL
	{
		public function SetPanelSettings()
		{
			$count = 0;
			$GLOBALS['SNIPPETS']['HomeFeaturedProducts'] = '';

			if (GetConfig('HomeFeaturedProducts') > 0) {
				if(GetConfig('EnableProductReviews') == 0) {
					$GLOBALS['HideProductRating'] = "display: none";
				}

				$query = "
					SELECT p.*, FLOOR(prodratingtotal/prodnumratings) AS prodavgrating, imageisthumb, imagefile, ".GetProdCustomerGroupPriceSQL()."
					FROM [|PREFIX|]products p
					LEFT JOIN [|PREFIX|]product_images pi ON (p.productid=pi.imageprodid)
					WHERE p.prodfeatured = '1' AND p.prodvisible='1' AND (imageisthumb=1 OR ISNULL(imageisthumb))
					".GetProdCustomerGroupPermissionsSQL()."
					ORDER BY RAND()
				";
				$query .= $GLOBALS['ISC_CLASS_DB']->AddLimit(0, GetConfig('HomeFeaturedProducts'));

				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

				if($GLOBALS['ISC_CLASS_DB']->CountResult($result) > 0) {
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

						$GLOBALS['ProductId'] = $row['productid'];
						$GLOBALS['ProductName'] = isc_html_escape($row['prodname']);
						$GLOBALS['ProductLink'] = ProdLink($row['prodname']);

						// Determine the price of this product
						$GLOBALS['ProductPrice'] = CalculateProductPrice_retail($row);

						$GLOBALS['ProductRating'] = (int)$row['prodavgrating'];

						// Workout the product description
						$desc = strip_tags($row['proddesc']);

						if (isc_strlen($desc) < 120) {
							$GLOBALS['ProductSummary'] = $desc;
						} else {
							$GLOBALS['ProductSummary'] = isc_substr($desc, 0, 120) . "...";
						}

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

						$GLOBALS['SNIPPETS']['HomeFeaturedProducts'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("HomeFeaturedProductsItem");
					}
				} else {
					$this->DontDisplay = true;
					$GLOBALS['HideHomeFeaturedProductsPanel'] = "none";
				}
			} else {
				$this->DontDisplay = true;
				$GLOBALS['HideHomeFeaturedProductsPanel'] = "none";
			}
		}
	}

?>
