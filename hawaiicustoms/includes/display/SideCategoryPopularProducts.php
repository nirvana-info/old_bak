<?php

	CLASS ISC_SIDECATEGORYPOPULARPRODUCTS_PANEL extends PANEL
	{
		public $cacheable = true;
		public $cacheId = "categories.products.sidepopularproducts";

		public function __construct()
		{
			$this->cacheId .= ".".$GLOBALS['CatId'];
		}

		public function SetPanelSettings()
		{
			$output = "";

			// If product ratings aren't enabled then we don't even need to load anything here
			if(GetConfig('EnableProductReviews') == 0) {
				$this->DontDisplay = true;
				return;
			}

			if(isset($GLOBALS['ISC_CLASS_CATEGORY'])) {
				$categorySql = $GLOBALS['ISC_CLASS_CATEGORY']->GetCategoryAssociationSQL();
			}
			else if(isset($GLOBALS['ISC_CLASS_PRICE'])) {
				$categorySql = $GLOBALS['ISC_CLASS_PRICE']->GetCategoryAssociationSQL();
			}

			$query = "
				SELECT p.*, FLOOR(prodratingtotal/prodnumratings) AS prodavgrating, ".GetProdCustomerGroupPriceSQL()."
				FROM [|PREFIX|]products p
				WHERE p.prodvisible='1' AND prodratingtotal > '0' ".$categorySql."
				ORDER BY prodavgrating DESC
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

					$GLOBALS['ProductId'] = $row['productid'];
					$GLOBALS['ProductName'] = isc_html_escape($row['prodname']);
					$GLOBALS['ProductLink'] = ProdLink($row['prodname']);
					$GLOBALS['ProductRating'] = (int)$row['prodavgrating'];

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

					$output .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideCategoryPopularProducts");
				}

				// Showing the syndication option?
				if(GetConfig('RSSPopularProducts') != 0 && GetConfig('RSSCategories') != 0 && GetConfig('RSSSyndicationIcons') != 0) {
					$GLOBALS['ISC_LANG']['CategoryPopularProductsFeed'] = sprintf(GetLang('CategoryPopularProductsFeed'), isc_html_escape($GLOBALS['CatName']));
					$GLOBALS['SNIPPETS']['SideCategoryPopularProductsFeed'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideCategoryPopularProductsFeed");
				}
			}
			else {
				$GLOBALS['HideSideCategoryPopularProductsPanel'] = "none";
				$this->DontDisplay = true;
			}

			$GLOBALS['SNIPPETS']['SideCategoryPopularProducts'] = $output;
		}
	}

?>
