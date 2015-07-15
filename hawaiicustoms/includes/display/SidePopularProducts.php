<?php

	CLASS ISC_SIDEPOPULARPRODUCTS_PANEL extends PANEL
	{
		public $cacheable = true;
		public $cacheId = "products.sidepopularproducts";

		public function SetPanelSettings()
		{
			$output = "";

			// If product ratings aren't enabled then we don't even need to load anything here
			if(GetConfig('EnableProductReviews') == 0) {
				$this->DontDisplay = true;
				return;
			}

			$query = "
				SELECT p.*, FLOOR(prodratingtotal/prodnumratings) AS prodavgrating, imageisthumb, imagefile, ".GetProdCustomerGroupPriceSQL()."
				FROM [|PREFIX|]products p
				LEFT JOIN [|PREFIX|]product_images pi ON (p.productid=pi.imageprodid AND pi.imageisthumb=1)
				WHERE prodvisible='1' AND prodratingtotal > 0
				".GetProdCustomerGroupPermissionsSQL()."
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

					$GLOBALS['ProductThumb'] = ImageThumb($row['imagefile'], ProdLink($row['prodname']));

					// Determine the price of this product
					$GLOBALS['ProductPrice'] = CalculateProductPrice($row);

					$GLOBALS['ProductRating'] = (int)$row['prodavgrating'];
					$output .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SidePopularProducts");
				}

				// Showing the syndication option?
				if(GetConfig('RSSPopularProducts') != 0 && GetConfig('RSSSyndicationIcons') != 0) {
					$GLOBALS['SNIPPETS']['SidePopularProductsFeed'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SidePopularProductsFeed");
				}
			}
			else {
				$GLOBALS['HideSidePopularProductsPanel'] = "none";
				$this->DontDisplay = true;
			}

			$GLOBALS['SNIPPETS']['SidePopularProducts'] = $output;
		}
	}

?>