<?php
/**
 * Show a tag cloud of all of the available product tags or show the
 * products for an individual tag.
 */
class ISC_TAGS
{
	/**
	 * @var array If viewing a tag, the array of information about the tag.
	 */
	private $tag = false;

	/**
	 * @var boolean True if we're viewing a tag cloud rather than a particular tag.
	 */
	private $showAll = false;

	/**
	 * @var array An array of products within the current tag.
	 */
	private $products = array();

	/**
	 * @var int The number of products assigned to a particular tag.
	 */
	private $numProducts = 0;

	/**
	 * @var int The starting position (offset) for the products we're browsing in a tag.
	 */
	private $productStart = 0;

	/**
	 * @var string The current sort order of products in the current tag.
	 */
	private $sort = 'featured';

	/**
	 * @var string The current database 'order by' column & order.
	 */
	private $sortField = 'p.prodfeatured DESC';

	/**
	 * @var int The current page we're viewing.
	 */
	private $page = 1;

	/**
	 * @var int The number of product pages for the current tag.
	 */
	private $pageCount = 1;

	/**
	 * Handle the incoming page request.
	 */
	public function HandlePage()
	{
		$this->SetTagData();
		if($this->showAll == false) {
			$this->ShowTag();
		}
		else {
			$this->ShowTagCloud();
		}
	}

	/**
	 * Show the products associated with a particular tag.
	 */
	public function ShowTag()
	{
		$GLOBALS['HidePanels'][] = 'ProductTagCloud';
		$GLOBALS['BreadCrumbs'] = array(
			array(
				'name' => GetLang('ProductTagCloud'),
				'link' => TagLink()
			),
			array(
				'name' => $this->tag['tagname'],
			)
		);
		$title = sprintf(GetLang('ProductsTaggedWith'), isc_html_escape($this->tag['tagname']));
		$GLOBALS['ISC_CLASS_TEMPLATE']->SetPageTitle(GetConfig('StoreName').' - '.$title);
		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("tags");
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
	}

	/**
	 * Show a listing of all of the available tags sorted by weight.
	 */
	public function ShowTagCloud()
	{
		$GLOBALS['HidePanels'][] = 'TagProducts';
		$GLOBALS['BreadCrumbs'] = array(
			array(
				'name' => GetLang('ProductTagCloud'),
				'link' => TagLink()
			)
		);
		$GLOBALS['ISC_CLASS_TEMPLATE']->SetPageTitle(GetConfig('StoreName').' - '.GetLang('ProductTagCloud'));
		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("tags");
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
	}

	/**
	 * Set the incoming information about the page we're viewing from the request.
	 */
	private function SetTagData()
	{
		if(isset($_REQUEST['tagid'])) {
			$this->tag = $this->LoadTagById($_REQUEST['tagid']);
			$this->showAll = false;
		}
		else if(isset($GLOBALS['PathInfo'][1]) && $GLOBALS['PathInfo'][1] != '') {
			$this->tag = $this->LoadTagByFriendlyName($GLOBALS['PathInfo'][1]);
			$this->showAll = false;
		}
		else {
			$this->showAll = true;
		}

		// Showing the contents of a particular tag
		if($this->showAll == false) {
			if(!is_array($this->tag)) {
				$GLOBALS['ISC_CLASS_404'] = GetClass('ISC_404');
				$GLOBALS['ISC_CLASS_404']->HandlePage();
			}

			if(isset($_REQUEST['sort'])) {
				$this->SetSortField($_REQUEST['sort']);
			}

			if(isset($_REQUEST['page'])) {
				$this->SetPage($_REQUEST['page']);
			}

			$this->LoadProductsForTag();
		}
	}

	/**
	 * Set the field to sort the products in a particular tag by.
	 *
	 * @param string The name of the field to sort by.
	 */
	private function SetSortField($field)
	{
		$this->sort = $field;

		switch($field) {
			case 'newest':
				$this->sortField = 'p.productid DESC';
				$GLOBALS['SortNewestSelected'] = 'selected="selected"';
				break;
			case 'bestselling':
				$this->sortField = 'p.prodnumsold DESC';
				$GLOBALS['SortBestSellingSelected'] = 'selected="selected"';
				break;
			case 'alphaasc':
				$this->sortField = 'p.prodname ASC';
				$GLOBALS['SortAlphaAsc'] = 'selected="selected"';
				break;
			case 'alphadesc':
				$this->sortField = 'p.prodname DESC';
				$GLOBALS['SortAlphaDesc'] = 'selected="selected"';
				break;
			case 'avgcustomerreview':
				$this->sortField = 'prodavgrating DESC';
				$GLOBALS['SortAvgReview'] = 'selected="selected"';
				break;
			case 'priceasc':
				$this->sortField = 'p.prodcalculatedprice ASC';
				$GLOBALS['SortPriceAsc'] = 'selected="selected"';
				break;
			case 'pricedesc';
				$this->sortField = 'p.prodcalculatedprice DESC';
				$GLOBALS['SortPriceDesc'] = 'selected="selected"';
				break;
			default:
				$this->sortField = 'p.prodfeatured DESC';
				$this->sort = 'featured';
				$GLOBALS['SortFeaturedSelected'] = 'selected="selected"';
				break;
		}
	}

	/**
	 * Load the information about a specific tag based on it's 'friendly name'
	 *
	 * @param string The tag friendly name to load the information for.
	 * @return array An array of information about the tag.
	 */
	private function LoadTagByFriendlyName($friendlyName)
	{
		$query = "
			SELECT *
			FROM [|PREFIX|]product_tags
			WHERE tagfriendlyname='".$GLOBALS['ISC_CLASS_DB']->Quote($friendlyName)."'
			LIMIT 1
		";
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		$tag = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
		if(!isset($tag['tagid'])) {
			return false;
		}

		return $tag;
	}

	/**
	 * Load the information about a specific tag based on it's  ID.
	 *
	 * @param int The tag ID.
	 * @return array An array of information about the tag.
	 */
	private function LoadTagById($id)
	{
		$query = "
			SELECT *
			FROM [|PREFIX|]product_tags
			WHERE tagid='".(int)$id."'
		";
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		$tag = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
		if(!isset($tag['tagid'])) {
			return false;
		}

		return $tag;
	}

	/**
	 * Get the tag ID.
	 *
	 * @return int The ID of the tag.
	 */
	public function GetTagId()
	{
		return $this->tag['tagid'];
	}

	/**
	 * Get the name of the tag.
	 *
	 * @return string The name of the tag.
	 */
	public function GetTagName()
	{
		return $this->tag['tagname'];
	}

	/**
	 * Get the friendly name (used in SEF urls) of the tag.
	 *
	 * @param string The friendly name of the tag.
	 */
	public function GetTagFriendlyName()
	{
		return $this->tag['tagfriendlyname'];
	}

	/**
	 * Get the number of the current page we're viewing.
	 *
	 * @return int The current page number.
	 */
	public function GetPage()
	{
		return $this->page;
	}

	/**
	 * Get the number of pages for all of the products in a particular tag.
	 *
	 * @return int The number of pages.
	 */
	public function GetNumPages()
	{
		return $this->pageCount;
	}

	/**
	 * Get the current sort order for products in this tag.
	 *
	 * @return string The sort order.
	 */
	public function GetSort()
	{
		return $this->sort;
	}

	/**
	 * Get the number of products in this particular tag.
	 *
	 * @return int The number of products in this tag.
	 */
	public function GetNumProducts()
	{
		return $this->numProducts;
	}

	/**
	 * Set the current page number we're viewing for products in this tag.
	 *
	 * @param int The page number.
	 */
	private function SetPage($page)
	{
		if(!isId($page)) {
			$page = 1;
		}

		$this->page = $page;
		$this->productStart = ($page * GetConfig('CategoryProductsPerPage')) - GetConfig('CategoryProductsPerPage');
	}

	/**
	 * Load a list of products in the current tag that we're viewing.
	 */
	private function LoadProductsForTag()
	{
		if(!is_array($this->tag)) {
			return false;
		}

		$query = "
			SELECT COUNT(p.productid) AS numproducts
			FROM [|PREFIX|]products p
			INNER JOIN [|PREFIX|]product_tagassociations ta ON (ta.productid=p.productid AND ta.tagid='".(int)$this->tag['tagid']."')
			WHERE prodvisible='1'
			".GetProdCustomerGroupPermissionsSQL()."
		";
		$this->numProducts = $GLOBALS['ISC_CLASS_DB']->FetchOne($query);
		$this->pageCount = ceil($this->numProducts / GetConfig('CategoryProductsPerPage'));

		// For some reason the tag could has become out of sync for this tag, we need to reset it
		if($this->numProducts != $this->tag['tagcount']) {
			$updatedTag = array(
				'tagcount' => $this->numProducts
			);
			$GLOBALS['ISC_CLASS_DB']->UpdateQuery('product_tags', $updatedTag, "tagid='".(int)$this->tag['tagid']."'");
		}

		// Now load the actual products for this tag
		$query = "
				SELECT p.*, FLOOR(prodratingtotal/prodnumratings) AS prodavgrating, imageisthumb, imagefile, ".GetProdCustomerGroupPriceSQL()."
				FROM [|PREFIX|]products p
				LEFT JOIN [|PREFIX|]product_images pi ON (p.productid=pi.imageprodid AND imageisthumb=1)
				INNER JOIN [|PREFIX|]product_tagassociations ta ON (ta.productid=p.productid AND ta.tagid='".(int)$this->tag['tagid']."')
				WHERE prodvisible='1'
				".GetProdCustomerGroupPermissionsSQL()."
				ORDER BY ".$this->sortField.", prodname ASC
			";
			$query .= $GLOBALS['ISC_CLASS_DB']->AddLimit($this->productStart, GetConfig('CategoryProductsPerPage'));
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$row['prodavgrating'] = (int)$row['prodavgrating'];
				$this->products[] = $row;
			}
		}

		/**
		 * Get a list of the loaded products for this particular tag.
		 *
		 * @return array An array of products for this tag.
		 */
		public function GetProducts()
		{
			return $this->products;
		}
	}
?>
