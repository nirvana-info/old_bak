<?php


	CLASS ISC_SIDECATEGORYTOPSELLERS_PANEL extends PANEL
	{
		public $cacheable = true;
		public $cacheId = "categories.products.sidetopsellers";

		public function __construct()
		{
			$this->cacheId .= ".".$GLOBALS['CatId'];
		}

		public function SetPanelSettings()
		{
			$count = 1;
			$output = "";

			if(GetConfig('EnableProductReviews') == 0) {
				$GLOBALS['HideProductRating'] = "display: none";
			}

			if(isset($GLOBALS['ISC_CLASS_CATEGORY'])) {
				$categorySql = $GLOBALS['ISC_CLASS_CATEGORY']->GetCategoryAssociationSQL();
			}
			else if(isset($GLOBALS['ISC_CLASS_PRICE'])) {
				$categorySql = $GLOBALS['ISC_CLASS_PRICE']->GetCategoryAssociationSQL();
			}

			$query = "
				SELECT p.*, FLOOR(prodratingtotal/prodnumratings) AS prodavgrating, imageisthumb, imagefile, ".GetProdCustomerGroupPriceSQL()."
				FROM [|PREFIX|]products p
				LEFT JOIN [|PREFIX|]product_images pi ON (p.productid=pi.imageprodid)
				WHERE p.prodnumsold > '0' AND p.prodvisible='1' AND (imageisthumb=1 OR ISNULL(imageisthumb)) ".$categorySql."
				ORDER BY p.prodnumsold DESC
			";
			$query .= $GLOBALS['ISC_CLASS_DB']->AddLimit(0, 5);

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

					if($count == 1) {
						$snippet = "SideTopSellersFirst";
					}
					else {
						$snippet = "SideTopSellers";
					}

					$GLOBALS['ProductThumb'] = ImageThumb($row['imagefile'], ProdLink($row['prodname']));
					$GLOBALS['ProductId'] = $row['productid'];
					$GLOBALS['ProductNumber'] = $count++;
					$GLOBALS['ProductName'] = isc_html_escape($row['prodname']);
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

					$GLOBALS['ProductRating'] = (int)$row['prodavgrating'];
					$output .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet($snippet);
				}
			}
			else {
				$GLOBALS['HideSideCategoryTopSellersPanel'] = "none";
				$this->DontDisplay = true;
			}

			$GLOBALS['SNIPPETS']['SideTopSellers'] = $output;
		}
	}

?>
