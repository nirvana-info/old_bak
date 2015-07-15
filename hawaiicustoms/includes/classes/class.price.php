<?php

	class ISC_PRICE
	{

		private $_pricesort = "";
		private $_pricesortfield = "";
		private $_pricecategory = "";
		private $_pricecatpath = "";

		private $_pricenumproducts = 0;
		private $_pricepage = 0;
		private $_pricestart = 0;
		private $_pricenumpages = 0;
		private $_pricemin = 0;
		private $_pricemax = 0;
		private $_pricecatid = 0;

		private $_priceproducts = array();
		private $_pricetrails = array();
		public $Data = array();

		/**
		 * @var string A CSV list of the categories that products should be pulled from for this category.
		 */
		private $loadCats = '';

		public function __construct()
		{
			$this->_SetPriceData();
		}

		public function SetSortField($Field)
		{
			// Set the field that the results will be sorted by in the query
			$this->_pricesortfield = $Field;
		}

		public function GetSortField()
		{
			return $this->_pricesortfield;
		}

		public function SetSort()
		{
			// Pre-select the current sort order (if any)
			if (!isset($_GET['sort']) || empty($_GET['sort'])) {
				$_GET['sort'] = "priceasc";
			}

			switch ($_GET['sort']) {
				case "featured": {
					$GLOBALS['SortFeaturedSelected'] = 'selected="selected"';
					$this->SetSortField("p.prodsortorder desc");
					break;
				}
				case "newest": {
					$GLOBALS['SortNewestSelected'] = 'selected="selected"';
					$this->SetSortField("p.productid desc");
					break;
				}
				case "bestselling": {
					$GLOBALS['SortBestSellingSelected'] = 'selected="selected"';
					$this->SetSortField("p.prodnumsold desc");
					break;
				}
				case "alphaasc": {
					$GLOBALS['SortAlphaAsc'] = 'selected="selected"';
					$this->SetSortField("p.prodname asc");
					break;
				}
				case "alphadesc": {
					$GLOBALS['SortAlphaDesc'] = 'selected="selected"';
					$this->SetSortField("p.prodname desc");
					break;
				}
				case "avgcustomerreview": {
					$GLOBALS['SortAvgReview'] = 'selected="selected"';
					$this->SetSortField("prodavgrating desc");
					break;
				}
				case "pricedesc": {
					$GLOBALS['SortPriceDesc'] = 'selected="selected"';
					$this->SetSortField("p.prodcalculatedprice desc");
					break;

				}
				case "priceasc":
				default:
				{
					$GLOBALS['SortPriceAsc'] = 'selected="selected"';
					$this->SetSortField("p.prodcalculatedprice asc");
					$_GET['sort'] = "priceasc";
					break;
				}
			}

			$this->_pricesort = $_GET['sort'];
		}

		public function GetSort()
		{
			return $this->_pricesort;
		}

		private function _SetPriceData()
		{
			$pos = 0;
			$min = null;
			$max = null;
			$catid = null;
			$catpath = "";

			// Retrieve the query string variables. Can't use the $_GET array
			// because of SEO friendly links in the URL
			SetPGQVariablesManually();

			// Grab the page sort details
			$GLOBALS['URL'] = implode("/", $GLOBALS['PathInfo']);
			$this->SetSort();

			if (isset($_REQUEST['low']) && isset($_REQUEST['high']) && isset($_REQUEST['category']) && isset($_REQUEST['path'])) {
				$min = (int)$_REQUEST['low'];
				$max = (int)$_REQUEST['high'];
				$catid = (int)$_REQUEST['category'];
				$catpath = "/".$_REQUEST['path'];
			}
			else {
				$count = 1;
				// Get the min price, max price and category id
				foreach ($GLOBALS['PathInfo'] as $piece) {
					if (isc_strtolower($piece) == "price") {
						break;
					}

					$count++;
				}

				for ($i = $count; $i < count($GLOBALS['PathInfo']); $i++) {
					if ($pos == 0) {
						$min = (int)$GLOBALS['PathInfo'][$i];
					} else if ($pos == 1) {
						$max = (int)$GLOBALS['PathInfo'][$i];
					} else if ($pos == 2) {
						$catid = (int)$GLOBALS['PathInfo'][$i];
					} else if ($pos > 2) {
						$catpath .= "/" . $GLOBALS['PathInfo'][$i];
					}

					$pos++;
				}

				$catpath = preg_replace('#\.html$#', "", $catpath);
			}

			// Do we have bad data? If so, bail out!
			if (!(is_numeric($min) && is_numeric($max) && is_numeric($catid))) {
				ob_end_clean();
				header("Location:" . $GLOBALS['ShopPath']);
				die();
			}

			$this->SetMinPrice((int)$min);
			$this->SetMaxPrice((int)$max);
			$this->SetCatId($catid);

			$catpath = trim($catpath, "/");
			$this->SetCatPath($catpath);

			// Get the categories name
			$query = sprintf("select catname from [|PREFIX|]categories where categoryid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($this->GetCatId()));
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			if ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$this->_pricecategory = $row['catname'];
				$GLOBALS['CatName'] = $this->_pricecategory;
			}
			else {
				$GLOBALS['ISC_CLASS_404'] = GetClass('ISC_404');
				$GLOBALS['ISC_CLASS_404']->HandlePage();
				exit;
			}

			// Find the number of products in the category
			$this->loadCats = $this->GetCatId();

			// This product should show products from this category, but if there are none
			// show them from any child categories too
			if(GetConfig('CategoryListingMode') == 'emptychildren') {
				// Load up how many products there are in the current category, if none, load from children too
				$this->SetNumProducts();
				if($this->GetNumProducts() == 0) {
					$this->loadCats = trim(implode(',', $this->GetChildCategories()), ',');
				}
			}

			// Otherwise, this category shows products from itself + children
			else if(GetConfig('CategoryListingMode') == 'children') {
				$cats = $this->GetChildCategories();
				$cats[] = $this->GetCatId();
				$this->loadCats = trim(implode(',', array_unique($cats)), ',');
			}

			$this->SetNumProducts();

			$this->SetPage();
			$this->SetStart();
			$this->SetNumPages();

			// Setup the trail
			$this->SetTrails();

			// Load the products for this price range
			if ($this->GetNumProducts()) {
				$this->LoadProductsForPrice();
			}
		}

		public function SetMinPrice($Price)
		{
			$this->_pricemin = $Price;
			$GLOBALS['PriceMin'] = CurrencyConvertFormatPrice($this->_pricemin, true);
		}

		public function SetMaxPrice($Price)
		{
			$this->_pricemax = $Price;
			$GLOBALS['PriceMax'] = CurrencyConvertFormatPrice($this->_pricemax, true);
		}

		public function GetCatPath()
		{
			return $this->_pricecatpath;
		}

		public function SetCatPath($Path)
		{
			$this->_pricecatpath = $Path;
			$GLOBALS['CatPath'] = $Path;
		}

		public function SetTrails()
		{

			// Now that we have the categories we need to organize them
			// into an array and work out the category ID
			$arrCats = explode("/", $this->GetCatPath());

			// Replace all bad variables back in
			for ($i = 0; $i < count($arrCats); $i++) {
				$arrCats[$i] = MakeURLNormal($arrCats[$i]);
			}

			// The first category *MUST* have a parent ID of 0 or it's invalid
			$query = sprintf("select * from [|PREFIX|]categories where lower(catname) = '%s' and catparentid='0'", $GLOBALS['ISC_CLASS_DB']->Quote(isc_strtolower($arrCats[0])));
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			if ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$this->SetTrail(array($row['categoryid'], $row['catname']));

				// The root category is valid, try and loop through each category to find the ID of the last category in the set
				if (count($arrCats) > 1) {
					$parentCat = $row['categoryid'];

					for ($i = 1; $i < count($arrCats); $i++) {
						$query = sprintf("select * from [|PREFIX|]categories where lower(catname)='%s' and catparentid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote(isc_strtolower($arrCats[$i])), $GLOBALS['ISC_CLASS_DB']->Quote($parentCat));
						$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

						if ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
							$parentCat = $row['categoryid'];
							$this->Data = $row;
							$this->SetTrail(array($row['categoryid'], $row['catname']));
						} else {
							continue;
						}
					}
				}
				else {
					$this->Data = $row;
				}
			}
			else {
				$this->Data = $row;
			}

			$GLOBALS['CatTrail'] = $this->GetTrails();
		}

		public function SetTrail($trail)
		{
			$this->_pricetrails[] = $trail;
		}

		public function GetTrails()
		{
			return $this->_pricetrails;
		}

		// Workout the number of pages for products in this category
		public function SetNumPages()
		{
			$this->_pricenumpages = ceil($this->GetNumProducts() / GetConfig('CategoryProductsPerPage'));
		}

		public function GetNumPages()
		{
			return $this->_pricenumpages;
		}

		// Set the start record for the products query
		public function SetStart()
		{
			$start = 0;

			switch ($this->_pricepage) {
				case 1: {
					$start = 0;
					break;
				}
				// Page 2 or more
				default: {
					$start = ($this->GetPage() * GetConfig('CategoryProductsPerPage')) - GetConfig('CategoryProductsPerPage');
					break;
				}
			}

			$this->_pricestart = $start;
		}

		public function GetStart()
		{
			return $this->_pricestart;
		}

		public function SetNumProducts()
		{
			$catids = $this->GetProductCategoryIds();

			if (!$catids) {
				$this->_pricenumproducts = 0;
				return;
			}

			$query = "
				SELECT
					COUNT(DISTINCT ca.productid) AS numproducts
				FROM
					[|PREFIX|]categoryassociations ca
					INNER JOIN [|PREFIX|]products p USE INDEX (PRIMARY) ON (p.productid = ca.productid)
				WHERE
					ca.categoryid IN (" . $catids . ") AND
					p.prodvisible='1' AND
					p.prodcalculatedprice >= '" . $this->GetMinPrice() . "' AND
					p.prodcalculatedprice <= '" . $this->GetMaxPrice() . "' AND
					p.prodhideprice = 0
			";

			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
			$this->_pricenumproducts = $row['numproducts'];
		}

		public function GetNumProducts()
		{
			return $this->_pricenumproducts;
		}

		public function GetMinPrice()
		{
			return $this->_pricemin;
		}

		public function GetMaxPrice()
		{
			return $this->_pricemax;
		}

		public function GetCatId()
		{
			return $this->_pricecatid;
		}

		public function SetCatId($Id)
		{
			$this->_pricecatid = $Id;
			$GLOBALS['CatId'] = $this->GetCatId();
		}

		public function SetPage()
		{
			if (isset($_GET['page'])) {
				$this->_pricepage = abs((int)$_GET['page']);
			} else {
				$this->_pricepage = 1;
			}
		}

		public function GetPage()
		{
			return $this->_pricepage;
		}

		/**
		 * Get a CSV list of the categories that products should be pulled from for this category.
		 *
		 * @return string a CSV list of category IDs.
		 */
		public function GetProductCategoryIds()
		{
			return $this->loadCats;
		}

		// Load the products to show for this price, taking into account paging, filters, etc
		public function LoadProductsForPrice()
		{
			$query = "
				SELECT
					p.*,
					FLOOR(prodratingtotal / prodnumratings) AS prodavgrating,
					imageisthumb,
					imagefile,
					" . GetProdCustomerGroupPriceSQL() . "
				FROM
					(
						SELECT
							DISTINCT ca.productid,
							FLOOR(prodratingtotal / prodnumratings) AS prodavgrating
						FROM
							[|PREFIX|]categoryassociations ca
							INNER JOIN [|PREFIX|]products p ON p.productid = ca.productid
						WHERE
							p.prodvisible = 1 AND
							ca.categoryid IN (" . $this->GetProductCategoryIds() . ") AND
							p.prodcalculatedprice >= '".(int)$this->GetMinPrice()."' AND
							p.prodcalculatedprice <= '".(int)$this->GetMaxPrice()."'
						ORDER BY
							" . $this->GetSortField() . ", p.prodname ASC
						" . $GLOBALS['ISC_CLASS_DB']->AddLimit($this->GetStart(), GetConfig('CategoryProductsPerPage')) . "
					) AS ca
					INNER JOIN [|PREFIX|]products p ON p.productid = ca.productid
					LEFT JOIN [|PREFIX|]product_images pi ON (pi.imageisthumb = 1 AND p.productid = pi.imageprodid)
			";

			//$query .= $GLOBALS['ISC_CLASS_DB']->AddLimit($this->GetStart(), GetConfig('CategoryProductsPerPage'));
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$row['prodavgrating'] = (int)$row['prodavgrating'];
				$this->_priceproducts[] = $row;
			}
		}

		public function BuildTitle()
		{
			// Build an SEO-friendly page title
			$title = "";

			foreach ($this->GetTrails() as $trail) {
				$title .= sprintf("%s - ", $trail[1]);
			}

			$title = rtrim($title, "- ");
			$title .= sprintf(" (%s - %s)", $GLOBALS['PriceMin'], $GLOBALS['PriceMax']);
			$title .= sprintf(" - %s", $GLOBALS['StoreName']);

			return $title;
		}

		public function GetProducts(&$Ref)
		{
			$Ref = $this->_priceproducts;
		}

		public function HandlePage()
		{
			$this->ShowPrice();
		}

		public function ShowPrice()
		{
			$GLOBALS['CompareLink'] = CompareLink();
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetPageTitle($this->BuildTitle());
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("price");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}



		/**
		 * Get a CSV list of all of the child categories of the current category.
		 *
		 * @return string a CSV list of all of the child categories of the current category.
		 */
		public function GetChildCategories()
		{
			$categoryId = $this->GetCatId();
			$childCatsCache = $GLOBALS['ISC_CLASS_DATA_STORE']->Read('ChildCategories');

			// The cache has a cached version of the children for this category so just return it
			if(isset($childCatsCache[$categoryId])) {
				return explode(',', $childCatsCache[$categoryId]);
			}

			if(!is_array($childCatsCache)) {
				$childCatsCache = array();
			}

			$childCats = array();
			$query = "
				SELECT categoryid
				FROM [|PREFIX|]categories
				WHERE CONCAT(',', catparentlist, ',') LIKE '%,".(int)$categoryId.",%' AND categoryid!='".(int)$categoryId."'
			";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			while($child = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$childCats[] = $child['categoryid'];
			}
			$childCatsCache[$categoryId] = implode(',', $childCats);
			$GLOBALS['ISC_CLASS_DATA_STORE']->Save('ChildCategories', $childCatsCache);
			return $childCats;
		}

		public function GetCategoryAssociationSQL()
		{
			$productCategoryIds = $this->GetProductCategoryIds();

			if ($productCategoryIds == '') {
				return '';
			}

			$sql = "AND (
						SELECT ca.productid
						FROM  [|PREFIX|]categoryassociations ca
						WHERE ca.productid = p.productid AND ca.categoryid IN (" . $productCategoryIds . ")
						LIMIT 1
					)";

			return $sql;
		}
	}

?>