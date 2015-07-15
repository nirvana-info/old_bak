<?php
class ISC_LINKER {
	public function HandleToDo()
	{
		if (!isset($_GET['d'])) {
			return;
		}

		switch ($_GET['d']) {
			case "categories":
				$this->GetCategories();
				break;
			case "brands":
				$this->GetBrands();
				break;
			case "pages":
				$this->GetPages();
				break;
			case "products":
				$this->GetProducts();
				break;
		}
	}

	private function GetCategories()
	{
		header('Content-type: text/xml');
		// Return a list of categories
		echo '<?xml version="1.0"?>';
		echo '<results>';
		$GLOBALS['ISC_CLASS_ADMIN_CATEGORY'] = GetClass('ISC_ADMIN_CATEGORY');
		$categories = $GLOBALS['ISC_CLASS_ADMIN_CATEGORY']->getCats("");
		foreach($categories as $catid => $catname) {
			$catpadding = substr_count($catname, '&nbsp') * 6;
			if($catpadding > 0) {
				$catpadding = sprintf('padding="%d"', $catpadding);
			}
			else {
				$catpadding = '';
			}
			$catname = preg_replace('/^(&nbsp;)*/', '', $catname);
			$catname = preg_replace('/(&nbsp;)*$/', '', $catname);
			$catlink = CatLink($catid, $catname);
			echo sprintf('<result title="%s" icon="images/category.gif" catid="%s" %s>%s</result>', $catname, $catid, $catpadding, $catlink);
		}
		echo '</results>';
	}

	private function GetBrands()
	{
		header('Content-type: text/xml');
		echo '<?xml version="1.0"?>';
		echo '<results>';

		$hasBrands = false;
		$query = "SELECT * FROM [|PREFIX|]brands ORDER BY brandname ASC";
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			echo sprintf('<result title="%s" icon="images/brand.gif">%s</result>', isc_html_escape($row['brandname']), BrandLink($row['brandname']));
			$hasBrands = true;
		}
		if(!$hasBrands) {
			echo "<error>".GetLang('DevEditLinkerNoBrands')."</error>";
		}
		echo '</results>';
	}

	private function GetPages()
	{
		header('Content-type: text/xml');
		echo '<?xml version="1.0"?>';
		echo '<results>';

		$GLOBALS['ISC_CLASS_ADMIN_AUTH'] = GetClass('ISC_ADMIN_AUTH');
		$GLOBALS['ISC_CLASS_ADMIN_PAGES'] = GetClass('ISC_ADMIN_PAGES');

		$pages = $GLOBALS['ISC_CLASS_ADMIN_PAGES']->_getPagesArray();

		//$GLOBALS['ISC_CLASS_LOG']->LogSystemDebug('php', 'array', var_export($pages, true));

		if(!count($pages)) {
			echo "<error>".GetLang('DevEditLinkerNoPages')."</error>";
		}
		else {
			foreach ($pages as $page) {
				if($page['pagetype'] != 1) {
					$pageLink = PageLink($page['pageid'], $page['pagetitle']);
				}
				else {
					$pageLink = $page['pagelink'];
				}

				echo sprintf('<result title="%s" icon="images/page.gif" padding="' . (($page['depth'] * 18) + 6) . '">%s</result>', isc_html_escape($page['pagetitle']), $pageLink);
			}
		}

		echo '</results>';
	}

	private function GetProducts()
	{
		header('Content-type: text/xml');
		echo '<?xml version="1.0"?>';
		echo '<results>';

		if(!isset($_REQUEST['searchQuery']) && !isset($_REQUEST['category']) || (isset($_REQUEST['searchQuery']) && isc_strlen($_REQUEST['searchQuery']) <= 3)) {
			echo "<error>".GetLang('DevEditLinkerEnterSearchTerms')."</error>";
		}
		else {
			$_REQUEST['category'] = array($_REQUEST['category']);
			$ResultCount = 0;
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE'] = GetClass('ISC_ADMIN_ENGINE');
			$GLOBALS['ISC_CLASS_ADMIN_AUTH'] = GetClass('ISC_ADMIN_AUTH');
			$GLOBALS['ISC_CLASS_ADMIN_PRODUCT'] = GetClass('ISC_ADMIN_PRODUCT');
			$products = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_GetProductList(0, 'prodname', 'asc', $ResultCount, 'p.productid,p.prodname', false);

			if($ResultCount == 0) {
				if(isset($_REQUEST['searchQuery'])) {
					echo "<error>".GetLang('DevEditLinkerNoProducts')."</error>";
				}
				else {
					echo "<error>".GetLang('DevEditLinkerNoCategoryProducts')."</error>";
				}
			}
			else {
				while($product = $GLOBALS['ISC_CLASS_DB']->Fetch($products)) {
					echo sprintf('<result title="%s" icon="images/product.gif">%s</result>', isc_html_escape($product['prodname']), ProdLink($product['prodname']));
				}
			}
		}
		echo '</results>';
	}

}
?>