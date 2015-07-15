<?php

CLASS ISC_PRICEPAGINGTOP_PANEL extends PANEL
{
	public function SetPanelSettings()
	{


		// Do we need to show paging, etc?
		if($GLOBALS['ISC_CLASS_PRICE']->GetNumProducts() > GetConfig('CategoryProductsPerPage')) {

			// Workout the paging data
			$GLOBALS['SNIPPETS']['PagingData'] = "";

			$num_pages_either_side_of_current = 5;

			$start = max($GLOBALS['ISC_CLASS_PRICE']->GetPage()-$num_pages_either_side_of_current,1);
			$end = min($GLOBALS['ISC_CLASS_PRICE']->GetPage()+$num_pages_either_side_of_current, $GLOBALS['ISC_CLASS_PRICE']->GetNumPages());

			for ($page = $start; $page <= $end; $page++) {
				if($page == $GLOBALS['ISC_CLASS_PRICE']->GetPage()) {
					$snippet = "PricePagingItemCurrent";
				}
				else {
					$snippet = "PricePagingItem";
				}

				$GLOBALS['PageLink'] = PriceLink($GLOBALS['ISC_CLASS_PRICE']->GetMinPrice(), $GLOBALS['ISC_CLASS_PRICE']->GetMaxPrice(), $GLOBALS['CatId'], $GLOBALS['ISC_CLASS_PRICE']->GetCatPath(), array("page" => $page, "sort" => $GLOBALS['ISC_CLASS_PRICE']->GetSort()));
				$GLOBALS['PageNumber'] = $page;
				$GLOBALS['SNIPPETS']['PagingData'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet($snippet);
			}

			// Parse the paging snippet
			if($GLOBALS['ISC_CLASS_PRICE']->GetPage() > 1) {
				// Do we need to output a "Previous" link?
				$GLOBALS['PrevLink'] = PriceLink($GLOBALS['ISC_CLASS_PRICE']->GetMinPrice(), $GLOBALS['ISC_CLASS_PRICE']->GetMaxPrice(), $GLOBALS['CatId'], $GLOBALS['ISC_CLASS_PRICE']->GetCatPath(), array("page" => $GLOBALS['ISC_CLASS_PRICE']->GetPage()-1,  "sort" => $GLOBALS['ISC_CLASS_PRICE']->GetSort()));
				$GLOBALS['SNIPPETS']['PricePagingPrevious'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("PricePagingPrevious");
			}

			if($GLOBALS['ISC_CLASS_PRICE']->GetPage() < $GLOBALS['ISC_CLASS_PRICE']->GetNumPages()) {
				// Do we need to output a "Next" link?
				$GLOBALS['NextLink'] = PriceLink($GLOBALS['ISC_CLASS_PRICE']->GetMinPrice(), $GLOBALS['ISC_CLASS_PRICE']->GetMaxPrice(), $GLOBALS['CatId'], $GLOBALS['ISC_CLASS_PRICE']->GetCatPath(), array("page" => $GLOBALS['ISC_CLASS_PRICE']->GetPage()+1,  "sort" => $GLOBALS['ISC_CLASS_PRICE']->GetSort()));
				$GLOBALS['SNIPPETS']['PricePagingNext'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("PricePagingNext");
			}

			$output = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("PricePaging");
			$output = $GLOBALS['ISC_CLASS_TEMPLATE']->ParseSnippets($output, $GLOBALS['SNIPPETS']);
			$GLOBALS['SNIPPETS']['PricePaging'] = $output;
		}

	}
}
?>