<?php
/**
 * Show a listing of products belonging to a specific vendor.
 */
CLASS ISC_VENDORPRODUCTS_PANEL extends PANEL
{
	/**
	 * Set the panel settings.
	 */
	public function SetPanelSettings()
	{
		$cVendor = GetClass('ISC_VENDORS');
		$vendor = $cVendor->GetVendor();

		$GLOBALS['VendorId'] = $vendor['vendorid'];
		$GLOBALS['VendorName'] = $vendor['vendorname'];

		// Set the field we're sorting results by
		if(isset($_REQUEST['sort'])) {
			$sort = $_REQUEST['sort'];
		}
		else {
			$sort = '';
		}

		switch($sort) {
			case 'newest':
				$sortField = 'p.productid DESC';
				$GLOBALS['SortNewestSelected'] = 'selected="selected"';
				break;
			case 'bestselling':
				$sortField = 'p.prodnumsold DESC';
				$GLOBALS['SortBestSellingSelected'] = 'selected="selected"';
				break;
			case 'alphaasc':
				$sortField = 'p.prodname ASC';
				$GLOBALS['SortAlphaAsc'] = 'selected="selected"';
				break;
			case 'alphadesc':
				$sortField = 'p.prodname DESC';
				$GLOBALS['SortAlphaDesc'] = 'selected="selected"';
				break;
			case 'avgcustomerreview':
				$sortField = 'prodavgrating DESC';
				$GLOBALS['SortAvgReview'] = 'selected="selected"';
				break;
			case 'priceasc':
				$sortField = 'p.prodcalculatedprice ASC';
				$GLOBALS['SortPriceAsc'] = 'selected="selected"';
				break;
			case 'pricedesc';
				$sortField = 'p.prodcalculatedprice DESC';
				$GLOBALS['SortPriceDesc'] = 'selected="selected"';
				break;
			default:
				$sortField = 'p.prodvendorfeatured DESC';
				$sort = 'featured';
				$GLOBALS['SortFeaturedSelected'] = 'selected="selected"';
				break;
		}

		// If we're viewing a certain page, fetch our starting position
		if(isset($_REQUEST['page']) && IsId($_REQUEST['page'])) {
			$page = (int)$_REQUEST['page'];
			$start = ($page * GetConfig('CategoryProductsPerPage')) - GetConfig('CategoryProductsPerPage');
		}
		else {
			$page = 1;
			$start = 0;
		}

		// Count the number of products that belong in this vendor
		$query = "
			SELECT COUNT(p.productid) AS numproducts
			FROM [|PREFIX|]products p
			".GetProdCustomerGroupPermissionsSQL()."
			WHERE p.prodvisible='1' AND p.prodvendorid='".(int)$vendor['vendorid']."'
		";
		$numProducts = $GLOBALS['ISC_CLASS_DB']->FetchOne($query);
		$numPages = ceil($numProducts / GetConfig('CategoryProductsPerPage'));

		// Now load the actual products for this vendor
		$query = "
				SELECT p.*, FLOOR(prodratingtotal/prodnumratings) AS prodavgrating, imageisthumb, imagefile, ".GetProdCustomerGroupPriceSQL()."
				FROM [|PREFIX|]products p
				LEFT JOIN [|PREFIX|]product_images pi ON (p.productid=pi.imageprodid AND imageisthumb=1)
				WHERE prodvisible='1' AND p.prodvendorid='".(int)$vendor['vendorid']."'
				ORDER BY ".$sortField.", prodname ASC
			";
		$query .= $GLOBALS['ISC_CLASS_DB']->AddLimit($start, GetConfig('CategoryProductsPerPage'));
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

		$GLOBALS['SNIPPETS']['VendorProducts'] = '';

		if(GetConfig('EnableProductReviews') == 0) {
			$GLOBALS['HideProductRating'] = "display: none";
		}

		// Should we show the compare button?
		if(GetConfig('EnableProductComparisons') == 0 || $numProducts < 2) {
			$GLOBALS['HideCompareItems'] = "none";
		}
		else {
			$GLOBALS['CompareLink'] = CompareLink();
		}

		$GLOBALS['AlternateClass'] = '';
		while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
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
			$GLOBALS['ProductRating'] = (int) $row['prodavgrating'];

			// Determine the price of this product
			$GLOBALS['ProductPrice'] = CalculateProductPrice($row);

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

			$GLOBALS['SNIPPETS']['VendorProducts'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("VendorProductsItem");
		}

		// Does paging need to be shown?
		if($numProducts > GetConfig('CategoryProductsPerPage')) {
			$GLOBALS['SNIPPETS']['PagingData'] = "";

			$numEitherSide = 5;
			$start = max($page-$numEitherSide,1);
			$end = min($page+$numEitherSide, $numPages);

			for($i = $start; $i <= $end; $i++) {
				if ($i == $page) {
					$snippet = "CategoryPagingItemCurrent";
				}
				else {
					$snippet = "CategoryPagingItem";
				}

				$pageData = array(
					'page' => $i,
					'sort' => $sort
				);
				$GLOBALS['PageLink'] = VendorProductsLink($vendor, $pageData);
				$GLOBALS['PageNumber'] = $i;
				$GLOBALS['SNIPPETS']['PagingData'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet($snippet);
			}

			// Do we need to output a "Previous" link?
			if($page > 1) {
				$pageData = array(
					'page' => $page-1,
					'sort' => $sort
				);
				$GLOBALS['PrevLink'] = VendorProductsLink($vendor, $pageData);
				$GLOBALS['SNIPPETS']['CategoryPagingPrevious'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("CategoryPagingPrevious");
			}

			// Do we need to output a "Next" link?
			if($page < $numPages) {
				$pageData = array(
					'page' => $page+1,
					'sort' => $sort
				);
				$GLOBALS['NextLink'] = VendorProductsLink($vendor, $pageData);
				$GLOBALS['SNIPPETS']['CategoryPagingNext'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("CategoryPagingNext");
			}

			$output = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("CategoryPaging");
			$output = $GLOBALS['ISC_CLASS_TEMPLATE']->ParseSnippets($output, $GLOBALS['SNIPPETS']);
			$GLOBALS['SNIPPETS']['ProductPaging'] = $output;
		}

		// Parse the sort select box snippet
		if($numProducts > 1) {

			// Parse the sort select box snippet
			if($GLOBALS['EnableSEOUrls'] == 1 && $vendor['vendorfriendlyname']) {
				$GLOBALS['URL'] = VendorProductsLink($vendor);
			}
			else {
				$GLOBALS['URL'] = $GLOBALS['ShopPath']."/vendors.php";
				$GLOBALS['HiddenSortField'] = "<input type=\"hidden\" name=\"vendorid\" value=\"".(int)$vendor['vendorid']."\" />";
				$GLOBALS['HiddenSortField'] .= "<input type=\"hidden\" name=\"action\" value=\"products\" />";
			}

			$GLOBALS['SNIPPETS']['CategorySortBox'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("CategorySortBox");
		}
	}
}

?>