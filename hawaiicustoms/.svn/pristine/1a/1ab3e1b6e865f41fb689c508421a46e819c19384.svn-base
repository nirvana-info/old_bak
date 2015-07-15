<?php

	class ISC_BRANDS
	{

		private $_brand = "";
		private $_brandsort = "";
		private $_brandsortfield = "";
		private $_brandname = '';

		private $_brandid = 0;
		private $_brandnumproducts = 0;
		private $_brandpage = 0;
		private $_brandstart = 0;
		private $_brandnumpages = 0;

		private $_brandpagetitle = '';
		private $_brandmetakeywords = '';
		private $_brandmetadesc = '';

		private $_allbrands = false;

		private $_brandproducts = array();

		public function __construct()
		{
			$this->_SetBrandData();
		}

		public function SetSortField($Field)
		{
			// Set the field that the results will be sorted by in the query
			$this->_brandsortfield = $Field;
		}

		public function GetSortField()
		{
			return $this->_brandsortfield;
		}

		public function SetSort()
		{
			// Pre-select the current sort order (if any)
			if (!isset($_GET['sort']) || $_GET['sort'] === '') {
				$_GET['sort'] = "featured";
			}

			$this->_brandsort = $_GET['sort'];

			switch ($_GET['sort']) {

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
				case "featured":
				default:
				{
					$GLOBALS['SortFeaturedSelected'] = 'selected="selected"';
					$this->SetSortField("p.prodsortorder desc");
					break;
				}

			}
		}

		public function GetSort()
		{
			return $this->_brandsort;
		}

		public function _SetBrandData()
		{

			// Retrieve the query string variables. Can't use the $_GET array
			// because of SEO friendly links in the URL
			SetPGQVariablesManually();

			// Grab the page sort details
			$GLOBALS['URL'] = implode("/", $GLOBALS['PathInfo']);
			$this->SetSort();

			if (isset($_REQUEST['brand'])) {
				$brand = $_REQUEST['brand'];
			}
			else {
				if (isset($GLOBALS['PathInfo'][1])) {
					$brand = preg_replace('#\.html\??.*$#i', "", $GLOBALS['PathInfo'][1]);
				} else {
					$brand = '';
				}
			}

			$brand = MakeURLNormal($brand);

			// Get the link to the "all brands" page
			$GLOBALS['AllBrandsLink'] = BrandLink();

			// Get the Id of the brand
			$query = sprintf("select * from [|PREFIX|]brands where brandname='%s'", $GLOBALS['ISC_CLASS_DB']->Quote($brand));
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			if ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				// Store the brand name
				$this->SetBrand($brand);

				$this->SetBrandName($row['brandname']);

				// Store the brand Id
				$this->SetId($row['brandid']);

				$this->SetBrandPageTitle($row['brandpagetitle']);
				// Store brand meta details
				$this->SetMetaKeywords($row['brandmetakeywords']);
				$this->SetMetaDesc($row['brandmetadesc']);
			}

			$this->SetNumProducts();
			$this->SetPage();
			$this->SetStart();
			$this->SetNumPages();

			// Load the products for the brand
			$this->LoadProductsForBrand();
		}

		public function SetBrand($Brand)
		{
			$this->_brand = $Brand;
		}

		public function SetBrandName($BrandName)
		{
			$this->_brandname = $BrandName;
		}

		public function GetBrandName()
		{
			return $this->_brandname;
		}

		public function GetBrand()
		{
			return $this->_brand;
		}

		public function SetId($BrandId)
		{
			$this->_brandid = $BrandId;
		}

		public function GetId()
		{
			return $this->_brandid;
		}

		public function GetPageTitle()
		{
			return $this->_brandpagetitle;
		}

		public function SetBrandPageTitle($pagetitle)
		{
			$this->_brandpagetitle = $pagetitle;
		}

		public function SetMetaKeywords($Keywords)
		{
			$this->_brandmetakeywords = $Keywords;
		}

		public function SetMetaDesc($Desc)
		{
			$this->_brandmetadesc = $Desc;
		}

		public function SetPage()
		{
			if (isset($_GET['page'])) {
				$this->_brandpage = abs((int)$_GET['page']);
			} else {
				$this->_brandpage = 1;
			}
		}

		public function GetPage()
		{
			return $this->_brandpage;
		}

		// Workout the number of pages for products in this category
		public function SetNumPages()
		{
			$this->_brandnumpages = ceil($this->GetNumProducts() / GetConfig('CategoryProductsPerPage'));
		}

		public function GetNumPages()
		{
			return $this->_brandnumpages;
		}

		// Set the start record for the products query
		public function SetStart()
		{
			$start = 0;

			switch ($this->_brandpage) {
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

			$this->_brandstart = $start;
		}

		public function GetStart()
		{
			return $this->_brandstart;
		}

		public function SetNumProducts()
		{
			if ($this->GetId() > 0) {
				$query = "
					SELECT COUNT(productid) AS numproducts
					FROM [|PREFIX|]products p
					WHERE prodbrandid='" . $GLOBALS['ISC_CLASS_DB']->Quote($this->GetId()) . "' AND prodvisible='1'
					" . GetProdCustomerGroupPermissionsSQL() . "
					";
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
				$this->_brandnumproducts = $row['numproducts'];
			}
		}

		public function GetNumProducts()
		{
			return $this->_brandnumproducts;
		}

		// Load the products to show for this brand, taking into account paging, filters, etc
		public function LoadProductsForBrand()
		{
			$query = "
				SELECT p.*, FLOOR(prodratingtotal/prodnumratings) AS prodavgrating, imageisthumb, imagefile, ".GetProdCustomerGroupPriceSQL()."
				FROM [|PREFIX|]products p
				LEFT JOIN [|PREFIX|]product_images pi ON (p.productid=pi.imageprodid)
				WHERE prodbrandid='".(int)$this->GetId()."' AND prodvisible='1' AND (imageisthumb=1 OR ISNULL(imageisthumb))
				".GetProdCustomerGroupPermissionsSQL()."
				ORDER BY ".$this->GetSortField().", prodname ASC
			";
			$query .= $GLOBALS['ISC_CLASS_DB']->AddLimit($this->GetStart(), GetConfig('CategoryProductsPerPage'));
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$row['prodavgrating'] = (int)$row['prodavgrating'];
				$this->_brandproducts[] = $row;
			}
		}

		public function BuildTitle()
		{
			// use preset page title if it exsits
			if (trim($this->GetPageTitle()) != "") {
				$title = $this->GetPageTitle();
			// Build an SEO-friendly page title
			} elseif ($this->GetBrand() != "") {
				$title = sprintf("%s %s - %s", $this->GetBrand(), GetLang('Products'), GetConfig('StoreName'));
			} else {
				$title = sprintf("%s %s", GetConfig('StoreName'), GetLang('Brands'));
			}

			return $title;
		}

		public function GetProducts(&$Ref)
		{
			$Ref = $this->_brandproducts;
		}

		public function HandlePage()
		{
			$this->ShowBrand();
		}

		public function ShowingAllBrands()
		{
			return $this->_allbrands;
		}

		public function ShowBrand()
		{
			$GLOBALS['BrandId'] = $this->GetId();
			$GLOBALS['BrandName'] = $this->GetBrand();

			$GLOBALS['CompareLink'] = CompareLink();

			if ($this->GetBrand() == "") {
				$GLOBALS['TrailBrandName'] = GetLang('AllBrands');
				$this->_allbrands = true;
			} else {
				$GLOBALS['TrailBrandName'] = isc_html_escape($this->GetBrand());
			}

			if ($this->_brandmetakeywords != "") {
				$GLOBALS['ISC_CLASS_TEMPLATE']->SetMetaKeywords($this->_brandmetakeywords);
			}

			if ($this->_brandmetadesc != "") {
				$GLOBALS['ISC_CLASS_TEMPLATE']->SetMetaDescription($this->_brandmetadesc);
			}

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetPageTitle($this->BuildTitle());
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("brands");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}

		/**
		*	Get a list of all brands as <option> tags
		*/
		public function GetBrandsAsOptions($SelectedBrand=0)
		{
			$query = "select * from [|PREFIX|]brands order by brandname asc";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$output = "";

			while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				if ($SelectedBrand == $row['brandid']) {
					$sel = 'selected="selected"';
				} else {
					$sel = "";
				}

				$output .= sprintf("<option value='%d' %s>%s</option>", $row['brandid'], $sel, $row['brandname']);
			}

			return $output;
		}
	}

?>