<?php
/**
 * Vendor's featured items panel.
 *
 * Shows a listing of featured items as defined by the vendor.
 * as well as the 'view all items' block
 */
class ISC_VENDORFEATUREDITEMS_PANEL extends PANEL
{
	/**
	 * Set the panel settings.
	 */
	public function SetPanelSettings()
	{
		if(GetConfig('HomeFeaturedProducts') <= 0) {
			$this->DontDisplay = true;
			return false;
		}

		$GLOBALS['SNIPPETS']['VendorFeaturedItems'] = '';

		if(GetConfig('EnableProductReviews') == 0) {
			$GLOBALS['HideProductRating'] = "display: none";
		}

		$cVendor = GetClass('ISC_VENDORS');
		$vendor = $cVendor->GetVendor();

		$query = "
			SELECT p.*, FLOOR(prodratingtotal/prodnumratings) AS prodavgrating, imageisthumb, imagefile, ".GetProdCustomerGroupPriceSQL()."
			FROM [|PREFIX|]products p
			LEFT JOIN [|PREFIX|]product_images pi ON (p.productid=pi.imageprodid AND imageisthumb=1)
			WHERE p.prodvisible='1' AND p.prodvendorid='".(int)$vendor['vendorid']."'
			".GetProdCustomerGroupPermissionsSQL()."
			ORDER BY p.prodvendorfeatured DESC, RAND()
		";
		$query .= $GLOBALS['ISC_CLASS_DB']->AddLimit(0, GetConfig('HomeFeaturedProducts'));
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

			if (isId($row['prodvariationid']) || trim($row['prodconfigfields'])!='' || $row['prodeventdaterequired'] == 1) {
				$GLOBALS['ProductURL'] = ProdLink($row['prodname']);
				$GLOBALS['ProductAddText'] = GetLang('ProductChooseOptionLink');
			} else {
				$GLOBALS['ProductURL'] = CartLink($row['productid']);
				$GLOBALS['ProductAddText'] = GetLang('ProductAddToCartLink');
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

			$GLOBALS['SNIPPETS']['VendorFeaturedItems'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("VendorFeaturedItemsItem");
		}

		$GLOBALS['VendorProductsLink'] = VendorProductsLink($vendor);

		if(!$GLOBALS['SNIPPETS']['VendorFeaturedItems']) {
			$this->DontDisplay = true;
		}
	}
}

?>
