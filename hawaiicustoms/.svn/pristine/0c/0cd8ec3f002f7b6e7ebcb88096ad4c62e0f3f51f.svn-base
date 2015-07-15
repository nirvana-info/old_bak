<?php
CLASS ISC_SIDEPRODUCTALSOBOUGHT_PANEL extends PANEL
{
	public function SetPanelSettings()
	{
		$GLOBALS['AlsoBoughtProductListing'] = '';
		$query = "
			SELECT ordprodid
			FROM [|PREFIX|]order_products
			WHERE orderorderid IN (SELECT orderorderid FROM [|PREFIX|]order_products WHERE ordprodid='".$GLOBALS['ISC_CLASS_PRODUCT']->GetProductId()."') AND ordprodid != ".$GLOBALS['ISC_CLASS_PRODUCT']->GetProductId()."
			GROUP BY ordprodid
			ORDER BY COUNT(ordprodid) DESC
		";
		$query .= $GLOBALS['ISC_CLASS_DB']->AddLimit(0, 10);
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

		$productIds = array();
		while($product = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$productIds[] = $product['ordprodid'];
		}

		if(empty($productIds)) {
			$this->DontDisplay = true;
			return;
		}

		if(GetConfig('EnableProductReviews') == 0) {
			$GLOBALS['HideProductRating'] = "display: none";
		}
		$query = "
			SELECT p.*, FLOOR(p.prodratingtotal/p.prodnumratings) AS prodavgrating, i.imagefile, i.imageisthumb, ".GetProdCustomerGroupPriceSQL()."
			FROM [|PREFIX|]products p
			LEFT JOIN [|PREFIX|]product_images i ON (p.productid = i.imageprodid AND i.imageisthumb=1)
			WHERE p.prodvisible='1' AND p.productid IN (".implode(',', $productIds).")
			".GetProdCustomerGroupPermissionsSQL()."
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
			$GLOBALS['ProductPrice'] = CalculateProductPrice($row);

			$GLOBALS['ProductThumb'] = ImageThumb($row['imagefile'], ProdLink($row['prodname']));

			$GLOBALS['AlsoBoughtProductListing'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideProductAlsoBoughtItem");
		}
		if(!$GLOBALS['AlsoBoughtProductListing']) {
			$this->DontDisplay = true;
		}
	}
}
?>