<?php

	class ISC_CATEGORY
	{

		private $_catid = 0;
		private $_catnumproducts = 0;
		private $_catpage = 0;
		private $_catstart = 0;
		private $_catnumpages = 0;

		private $_catname = "";
		private $_catdesc = "";
		private $_catsort = "";
		private $_catsortfield = "";
		private $_catpath = "";
		private $_catlayoutfile = "";

		private $_catpagetitle = '';
		private $_catmetakeywords = '';
		private $_catmetadesc = '';

		private $_cattrails = array();
		private $_catproducts = array();

		/**
		 * @var string A CSV list of the categories that products should be pulled from for this category.
		 */
		private $loadCats = '';

		public $Data = array();

		public function __construct()
		{
			$GLOBALS['CatId'] = 0;
			$this->_catlayoutfile = "category";
		}

		/**
		 * Get the category ID for the category we're currently viewing.
		 *
		 * @return int The category ID.
		 */
		public function GetCategoryId()
		{
			return $this->_catid;
		}

		public function SetName($name)
		{
			$this->_catname = $name;
		}

		public function GetName()
		{
			return $this->_catname;
		}

		public function GetPageTitle()
		{
			return $this->_catpagetitle;
		}

		public function SetCatPageTitle($pagetitle)
		{
			$this->_catpagetitle = $pagetitle;
		}

		public function SetMetaKeywords($keywords)
		{
			$this->_catmetakeywords = $keywords;
		}

		public function SetMetaDesc($desc)
		{
			$this->_catmetadesc = $desc;
		}

		public function SetPage()
		{
			if (isset($_GET['page'])) {
				$this->_catpage = abs((int)$_GET['page']);
			} else {
				$this->_catpage = 1;
			}
		}

		public function GetPage()
		{
			return $this->_catpage;
		}

		// Workout the number of pages for products in this category
		public function SetNumPages()
		{
			if (GetConfig('CategoryProductsPerPage') > 0) {
				$this->_catnumpages = ceil($this->GetNumProducts() / GetConfig('CategoryProductsPerPage'));
			}
			else {
				$this->_catnumpages = 0;
			}
		}

		public function GetNumPages()
		{
			return $this->_catnumpages;
		}

		public function GetProducts(&$Ref)
		{
			$Ref = $this->_catproducts;
		}

		// Set the start record for the products query
		public function SetStart()
		{
			$start = 0;

			switch ($this->_catpage) {
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

			$this->_catstart = $start;
		}

		public function GetStart()
		{
			return $this->_catstart;
		}

		public function SetNumProducts()
		{
			$query = "
				SELECT
					COUNT(DISTINCT ca.productid) AS numproducts
				FROM
					[|PREFIX|]categoryassociations ca
					INNER JOIN [|PREFIX|]products p USE INDEX (PRIMARY) ON p.productid = ca.productid
				WHERE
					p.prodvisible = 1 AND
					ca.categoryid IN (" . $this->GetProductCategoryIds() . ")
					";

			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
			$this->_catnumproducts = $row['numproducts'];
		}

		public function GetNumProducts()
		{
			return $this->_catnumproducts;
		}

		public function SetDesc($desc)
		{
			if($desc == '<br>' || $desc == '<br />' || $desc == '<br/>') {
				$desc = '';
			}
			$this->_catdesc = $desc;
		}

		public function GetDesc()
		{
			return $this->_catdesc;
		}

		public function SetId($id = null)
		{
			if ($id != null && (int)$id > -1) {
				$this->_catid = (int)$id;
			}
		}

		public function SetTrail($trail)
		{
			$this->_cattrails[] = $trail;
		}

		public function GetTrail()
		{
			return $this->_cattrails;
		}

		public function GetId()
		{
			return $this->_catid;
		}

		public function SetSortField($Field)
		{
			// Set the field that the results will be sorted by in the query
			$this->_catsortfield = $Field;
		}

		public function GetSortField()
		{
			if (!$this->_catsortfield) {
				$this->_catsortfield = 'p.prodsortorder asc';
			}
			return $this->_catsortfield;
		}

		public function SetSort()
		{
			// Pre-select the current sort order (if any)
			if (isset($_GET['sort'])) {
				$sort = $_GET['sort'];
			} else {
				$sort = "featured";
			}
			$this->_catsort = $sort;

			switch ($sort) {
				case "featured": {
					$GLOBALS['SortFeaturedSelected'] = 'selected="selected"';
					$this->SetSortField("p.prodsortorder asc");
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
				case "priceasc": {
					$GLOBALS['SortPriceAsc'] = 'selected="selected"';
					$this->SetSortField("p.prodcalculatedprice asc");
					break;
				}
				case "pricedesc": {
					$GLOBALS['SortPriceDesc'] = 'selected="selected"';
					$this->SetSortField("p.prodcalculatedprice desc");
					break;
				}
			}
		}

		public function GetSort()
		{
			return $this->_catsort;
		}

		public function GetCatPath()
		{
			return $this->_catpath;
		}

		public function SetCatPath($Path)
		{
			$this->_catpath = $Path;
			$GLOBALS['CatPath'] = $Path;
		}

		public function GetLayoutFile()
		{
			if($this->_catlayoutfile == '') {
				$this->_catlayoutfile = 'category';
			}
			return $this->_catlayoutfile;
		}

		public function SetLayoutFile($File)
		{
			if ($File != "") {
				$this->_catlayoutfile = str_replace(array(".html", ".htm"), "", $File);
				if(!file_exists(ISC_BASE_PATH."/templates/".GetConfig('template')."/".$File)) {
					$this->_catlayoutfile = '';
				}
			}
		}

		public function SetCategoryData()
		{
			// Retrieve the query string variables. Can't use the $_GET array
			// because of SEO friendly links in the URL
			SetPGQVariablesManually();

			// Grab the page sort details
			if (isset($_REQUEST['category'])) {
				$GLOBALS['CategoryPath'] = isc_html_escape($_REQUEST['category']);
				$path = explode("/", $_REQUEST['category']);
			}
			else {
				$GLOBALS['URL'] = implode("/", $GLOBALS['PathInfo']);
				$path = $GLOBALS['PathInfo'];
				array_shift($path);
			}

			$this->SetSort();

			$this->SetCatPath($path);

			$arrCats = $this->_catpath;

			for ($i = 0; $i < count($arrCats); $i++) {
				$arrCats[$i] = MakeURLNormal($arrCats[$i]);
			}

			if (!isset($arrCats[0])) {
				$arrCats[0] = '';
			}

			// The first category *MUST* have a parent ID of 0 or it's invalid
			$query = "
				SELECT *
				FROM [|PREFIX|]categories
				WHERE LOWER(catname) ='".$GLOBALS['ISC_CLASS_DB']->Quote($arrCats[0])."' AND catparentid=0
			";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			if ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$this->SetTrail(array($row['categoryid'], $row['catname']));
				$this->SetId($row['categoryid']);
				$this->SetName($row['catname']);
				$this->SetDesc($row['catdesc']);
				$this->SetLayoutFile($row['catlayoutfile']);
				$this->SetCatPageTitle($row['catpagetitle']);
				$this->SetMetaKeywords($row['catmetakeywords']);
				$this->SetMetaDesc($row['catmetadesc']);

				// The root category is valid, try and loop through each category to find the ID of the last category in the set
				if (count($arrCats) > 1) {
					$parentCat = $row['categoryid'];

					for ($i = 1; $i < count($arrCats); $i++) {
						if(!$arrCats[$i]) {
							continue;
						}
						$query = "
							SELECT *
							FROM [|PREFIX|]categories
							WHERE LOWER(catname) ='".$GLOBALS['ISC_CLASS_DB']->Quote($arrCats[$i])."' AND catparentid='".(int)$parentCat."'
						";
						$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
						if ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
							$parentCat = $row['categoryid'];
							$this->Data = $row;
							$this->SetTrail(array($row['categoryid'], $row['catname']));
							$this->SetId($row['categoryid']);
							$this->SetName($row['catname']);
							$this->SetDesc($row['catdesc']);
							$this->SetLayoutFile($row['catlayoutfile']);
							$this->SetCatPageTitle($row['catpagetitle']);
							$this->SetMetaKeywords($row['catmetakeywords']);
							$this->SetMetaDesc($row['catmetadesc']);
						}
						else {
							continue;
						}
					}

					$this->SetId($parentCat);
				}
				else {
					$this->Data = $row;
					$this->SetId($row['categoryid']);
					$this->SetName($row['catname']);
					$this->SetDesc($row['catdesc']);
					$this->SetCatPageTitle($row['catpagetitle']);
					$this->SetMetaKeywords($row['catmetakeywords']);
					$this->SetMetaDesc($row['catmetadesc']);
				}
			}
			else {
				$this->Data = $row;
				$this->SetId(0);
				$this->SetName("");
				$this->SetDesc("");
			}

			if(!$this->_catid) {
				$GLOBALS['ISC_CLASS_404'] = GetClass('ISC_404');
				$GLOBALS['ISC_CLASS_404']->HandlePage();
				exit;
			}

			// Do we have permission to access this category?
			if(!CustomerGroupHasAccessToCategory($this->_catid)) {
				$noPermissionsPage = GetClass('ISC_403');
				$noPermissionsPage->HandlePage();
				exit;
			}

			$GLOBALS['CatTrail'] = $this->GetTrail();

			// Find the number of products in the category
			$this->loadCats = $this->GetId();

			// This product should show products from this category, but if there are none
			// show them from any child categories too
			if(GetConfig('CategoryListingMode') == 'emptychildren') {
				// Load up how many products there are in the current category, if none, load from children too
				$this->SetNumProducts();
				if($this->_catnumproducts == 0) {
					$this->loadCats = trim(implode(',', $this->GetChildCategories()), ',');
					$this->loadCats = rtrim($this->GetId().",".$this->loadCats, ',');
				}
			}

			// Otherwise, this category shows products from itself + children
			else if(GetConfig('CategoryListingMode') == 'children') {
				$cats = $this->GetChildCategories();
				$cats[] = $this->GetId();
				$this->loadCats = trim(implode(',', array_unique($cats)), ',');
			}

			$this->SetNumProducts();

			// Setup paging details
			$this->SetPage();
			$this->SetStart();
			$this->SetNumPages();

			// Load the products for the categories page
			$this->LoadProductsForPage();
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

		public function HandlePage()
		{
			$this->SetCategoryData();
			$this->ShowCategory();
		}

		public function BuildTitle()
		{
			// Build an SEO-friendly page title
			$title = "";
			if (trim($this->GetPageTitle()) != "") {
				$title = rtrim($this->GetPageTitle());
				return $title;
			}
			foreach ($this->GetTrail() as $trail) {
				$title .= sprintf("%s - ", $trail[1]);
			}
			$title = rtrim($title, ' -');
			$title .= sprintf(" - %s", GetConfig('StoreName'));
			return $title;
		}

		public function ShowCategory()
		{
			$GLOBALS['CatId'] = (int) $this->GetId();
			$GLOBALS['CatName'] = isc_html_escape($this->GetName());
			$GLOBALS['CatDesc'] = $this->GetDesc();

			$GLOBALS['CompareLink'] = CompareLink();

			// Do we need to add RSS feeds in for this category?
			if (!isset($GLOBALS['HeadRSSLinks'])) {
				$GLOBALS['HeadRSSLinks'] = '';
			}
			if (GetConfig('RSSCategories') != 0) {
				if (GetConfig('RSSNewProducts') != 0) {
					$GLOBALS['HeadRSSLinks'] .= GenerateRSSHeaderLink($GLOBALS['ShopPath']."/rss.php?categoryid=".$GLOBALS['CatId'], sprintf(GetLang('HeadRSSNewProductsCategory'), $GLOBALS['CatName']));
				}
				if (GetConfig('RSSPopularProducts') != 0) {
					$GLOBALS['HeadRSSLinks'] .= GenerateRSSHeaderLink($GLOBALS['ShopPath']."/rss.php?action=popularproducts&categoryid=".$GLOBALS['CatId'], sprintf(GetLang('HeadRSSPopularProductsCategory'), $GLOBALS['CatName']));
				}
			}

			if ($this->_catmetakeywords != "") {
				$GLOBALS['ISC_CLASS_TEMPLATE']->SetMetaKeywords($this->_catmetakeywords);
			}

			if ($this->_catmetadesc != "") {
				$GLOBALS['ISC_CLASS_TEMPLATE']->SetMetaDescription($this->_catmetadesc);
			}

			if(!$this->GetNumProducts()) {
				$GLOBALS['HideRightColumn'] = 'none';
				$GLOBALS['ExtraCategoryClass'] = 'Wide';
			}

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetPageTitle($this->BuildTitle());
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate($this->GetLayoutFile());
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}

		public function GetCatsInfo()
		{
			if (!isset($this->catsByPid) || !is_array($this->catsByPid)) {
				$query = "SELECT * FROM [|PREFIX|]categories ORDER BY catsort DESC, catname ASC";
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					$this->catsByPid[$row['catparentid']][] = $row['catparentid'];
					$this->catsById[$row['categoryid']] = $row;
				}
			}
		}

		// Load the products to show on this page, taking into account paging, filters, etc
		public function LoadProductsForPage()
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
							ca.categoryid IN (" . $this->GetProductCategoryIds() . ")
						ORDER BY
							" . $this->GetSortField() . ", p.prodname ASC
						" .	$GLOBALS['ISC_CLASS_DB']->AddLimit($this->GetStart(), GetConfig('CategoryProductsPerPage')) . "
					) AS ca
					INNER JOIN [|PREFIX|]products p ON p.productid = ca.productid
					LEFT JOIN [|PREFIX|]product_images pi ON (pi.imageisthumb = 1 AND p.productid = pi.imageprodid)
			";

			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$row['prodavgrating'] = (int)$row['prodavgrating'];
				$this->_catproducts[] = $row;
			}
		}

		/**
		 * Get a CSV list of all of the child categories of the current category.
		 *
		 * @return string a CSV list of all of the child categories of the current category.
		 */
		public function GetChildCategories()
		{
			$categoryId = $this->GetCategoryId();
			$childCatsCache = $GLOBALS['ISC_CLASS_DATA_STORE']->Read('ChildCategories');

			// The cache has a cached version of the children for this category so just return it
			if(isset($childCatsCache[$categoryId])) {
				return explode(',', $childCatsCache[$categoryId]);
			}

			if(!is_array($childCatsCache)) {
				$childCatsCache = array();
			}

			$childCats = array();
			$query = "SELECT categoryid FROM [|PREFIX|]categories WHERE CONCAT(',', catparentlist, ',') LIKE '%,".(int)$categoryId.",%' AND categoryid!='".(int)$categoryId."'";
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
