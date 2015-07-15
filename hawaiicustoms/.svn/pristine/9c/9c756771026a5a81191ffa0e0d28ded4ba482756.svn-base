<?php
CLASS ISC_PRODUCTVENDORSOTHERPRODUCTS_PANEL extends PANEL
{
	public function SetPanelSettings()
	{
		if(!gzte11(ISC_HUGEPRINT) || $GLOBALS['ISC_CLASS_PRODUCT']->GetProductVendor() === false) {
			$this->DontDisplay = true;
			return false;
		}

		$vendor = $GLOBALS['ISC_CLASS_PRODUCT']->GetProductVendor();
		$GLOBALS['SNIPPETS']['VendorsOtherProducts'] = '';

		if(GetConfig('EnableProductReviews') == 0) {
			$GLOBALS['HideProductRating'] = "display: none";
		}

		$query = "
			SELECT p.*, FLOOR(p.prodratingtotal/p.prodnumratings) AS prodavgrating, i.imagefile, i.imageisthumb, ".GetProdCustomerGroupPriceSQL()."
			FROM [|PREFIX|]products p
			LEFT JOIN [|PREFIX|]product_images i ON (p.productid = i.imageprodid AND i.imageisthumb=1)
			WHERE p.prodvisible='1' AND p.prodvendorid='".(int)$vendor['vendorid']."' AND p.productid!='".(int)$GLOBALS['ISC_CLASS_PRODUCT']->GetProductId()."'
			".GetProdCustomerGroupPermissionsSQL()."
			ORDER BY p.prodvendorfeatured DESC, RAND() DESC
		";
		$query .= $GLOBALS['ISC_CLASS_DB']->AddLimit(0, 9);
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

		$productsDone = 0;
		$hasMore = false;
		$GLOBALS['AlternateClass'] = '';
		while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			++$productsDone;
			if($productsDone == 9) {
				$hasMore = true;
				break;
			}
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

		 	$GLOBALS['SNIPPETS']['VendorsOtherProducts'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("ProductVendorsOtherProductsItem");
		}

		if(!$GLOBALS['SNIPPETS']['VendorsOtherProducts']) {
			$this->DontDisplay = true;
		}

		$GLOBALS['VendorProductsLink'] = VendorProductsLink($vendor);
		if($hasMore == true) {
			$GLOBALS['HideViewAllLink'] = '';
		}
		else {
			$GLOBALS['HideViewAllLink'] = 'display: none';
		}
	}
}
?>