<?php

	CLASS ISC_HOMESALEPRODUCTS_PANEL extends PANEL
	{
		public function SetPanelSettings()
		{
			$count = 0;
			$GLOBALS['SNIPPETS']['HomeSaleProducts'] = '';

			if (GetConfig('HomeNewProducts') == 0) {
				$this->DontDisplay = true;
				return;
			}

			if(GetConfig('EnableProductReviews') == 0) {
				$GLOBALS['HideProductRating'] = "display: none";
			}

			$query = "
				SELECT p.*, FLOOR(prodratingtotal/prodnumratings) AS prodavgrating, imageisthumb, imagefile, ".GetProdCustomerGroupPriceSQL()."
				FROM [|PREFIX|]products p
				LEFT JOIN [|PREFIX|]product_images pi ON (p.productid=pi.imageprodid)
				WHERE p.prodsaleprice != 0 AND p.prodsaleprice < p.prodprice AND p.prodvisible='1' AND (imageisthumb=1 OR ISNULL(imageisthumb))
				".GetProdCustomerGroupPermissionsSQL()."
				ORDER BY RAND()
			";
			$query .= $GLOBALS['ISC_CLASS_DB']->AddLimit(0, GetConfig('HomeNewProducts'));
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

				$GLOBALS['ProductId'] = $row['productid'];
				$GLOBALS['ProductName'] = isc_html_escape($row['prodname']);
				$GLOBALS['ProductLink'] = ProdLink($row['prodname']);

				// Determine the price of this product
				$originalPrice = CalcRealPrice(CalcProdCustomerGroupPrice($row, $row['prodprice']), 0, 0, $row['prodistaxable']);
				$GLOBALS['OriginalProductPrice'] = CurrencyConvertFormatPrice($originalPrice);
				$GLOBALS['ProductPrice'] = CalculateProductPrice($row);

				$GLOBALS['ProductRating'] = (int)$row['prodavgrating'];

				// Workout the product description
				$desc = strip_tags($row['proddesc']);
				if (isc_strlen($desc) < 120) {
					$GLOBALS['ProductSummary'] = $desc;
				} else {
					$GLOBALS['ProductSummary'] = isc_substr($desc, 0, 120) . "...";
				}

				$GLOBALS['ProductThumb'] = ImageThumb($row['imagefile'], ProdLink($row['prodname']));

				$GLOBALS['SNIPPETS']['HomeSaleProducts'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("HomeSaleProductsItem");
				if(!$GLOBALS['SNIPPETS']['HomeSaleProducts']) {
					$this->DontDisplay = true;
					return;
				}
			}
		}
	}

?>