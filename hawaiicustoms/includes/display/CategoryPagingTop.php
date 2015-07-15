<?php

CLASS ISC_CATEGORYPAGINGTOP_PANEL extends PANEL
{
	public function SetPanelSettings()
	{


		// Do we need to show paging, etc?
		if($GLOBALS['ISC_CLASS_CATEGORY']->GetNumProducts() > GetConfig('CategoryProductsPerPage')) {

			// Workout the paging data
			$GLOBALS['SNIPPETS']['PagingData'] = "";

			$num_pages_either_side_of_current = 5;

			$start = max($GLOBALS['ISC_CLASS_CATEGORY']->GetPage()-$num_pages_either_side_of_current,1);
			$end = min($GLOBALS['ISC_CLASS_CATEGORY']->GetPage()+$num_pages_either_side_of_current, $GLOBALS['ISC_CLASS_CATEGORY']->GetNumPages());

			for ($page = $start; $page <= $end; $page++) {
				if($page == $GLOBALS['ISC_CLASS_CATEGORY']->GetPage()) {
					$snippet = "CategoryPagingItemCurrent";
				}
				else {
					$snippet = "CategoryPagingItem";
				}

				$GLOBALS['PageLink'] = CatLink($GLOBALS['CatId'], $GLOBALS['ISC_CLASS_CATEGORY']->GetName(), false, array("page" => $page, "sort" => $GLOBALS['ISC_CLASS_CATEGORY']->GetSort()));
				$GLOBALS['PageNumber'] = $page;
				$GLOBALS['SNIPPETS']['PagingData'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet($snippet);
			}

			// Parse the paging snippet
			if($GLOBALS['ISC_CLASS_CATEGORY']->GetPage() > 1) {
				// Do we need to output a "Previous" link?
				$GLOBALS['PrevLink'] = CatLink($GLOBALS['CatId'], $GLOBALS['ISC_CLASS_CATEGORY']->GetName(), false, array("page" => $GLOBALS['ISC_CLASS_CATEGORY']->GetPage()-1, "sort" => $GLOBALS['ISC_CLASS_CATEGORY']->GetSort()));
				$GLOBALS['SNIPPETS']['CategoryPagingPrevious'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("CategoryPagingPrevious");
			}

			if($GLOBALS['ISC_CLASS_CATEGORY']->GetPage() < $GLOBALS['ISC_CLASS_CATEGORY']->GetNumPages()) {
				// Do we need to output a "Next" link?
				$GLOBALS['NextLink'] = CatLink($GLOBALS['CatId'], $GLOBALS['ISC_CLASS_CATEGORY']->GetName(), false, array("page" => $GLOBALS['ISC_CLASS_CATEGORY']->GetPage()+1, "sort" => $GLOBALS['ISC_CLASS_CATEGORY']->GetSort()));
				$GLOBALS['SNIPPETS']['CategoryPagingNext'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("CategoryPagingNext");
			}

			$output = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("CategoryPaging");
			$output = $GLOBALS['ISC_CLASS_TEMPLATE']->ParseSnippets($output, $GLOBALS['SNIPPETS']);
			$GLOBALS['SNIPPETS']['CategoryPaging'] = $output;
		}

	}
}
?>