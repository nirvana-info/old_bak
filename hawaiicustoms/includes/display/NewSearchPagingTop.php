<?php

	CLASS ISC_NEWSEARCHPAGINGTOP_PANEL extends PANEL
	{
		function SetPanelSettings()
		{
			$output= '';
			if($GLOBALS['ISC_CLASS_NEWSEARCH']->GetNumResults() > 0) {
				// Do we need to show paging, etc?
				if($GLOBALS['ISC_CLASS_NEWSEARCH']->GetNumResults() > GetConfig('CategoryProductsPerPage')) {
					// Workout the paging data
					$GLOBALS['SNIPPETS']['PagingData'] = "";

					$num_pages_either_side_of_current = 5;

					$start = max($GLOBALS['ISC_CLASS_NEWSEARCH']->GetPage()-$num_pages_either_side_of_current,1);
					$end = min($GLOBALS['ISC_CLASS_NEWSEARCH']->GetPage()+$num_pages_either_side_of_current, $GLOBALS['ISC_CLASS_NEWSEARCH']->GetNumPages());

				
					for ($page = $start; $page <= $end; $page++) {
						if($page == $GLOBALS['ISC_CLASS_NEWSEARCH']->GetPage()) {
							$snippet = "CategoryPagingItemCurrent";
						}
						else {
							$snippet = "CategoryPagingItem";
						}

						$GLOBALS['PageLink'] = SearchLink($GLOBALS['ISC_CLASS_NEWSEARCH']->GetQuery(), $page);
						$GLOBALS['PageNumber'] = $page;
						$GLOBALS['SNIPPETS']['PagingData'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet($snippet);
					}

					// Parse the paging snippet
					if($GLOBALS['ISC_CLASS_NEWSEARCH']->GetPage() > 1) {
						// Do we need to output a "Previous" link?
						$GLOBALS['PrevLink'] = SearchLink($GLOBALS['ISC_CLASS_NEWSEARCH']->GetQuery(), $GLOBALS['ISC_CLASS_NEWSEARCH']->GetPage()-1);
						$GLOBALS['SNIPPETS']['CategoryPagingPrevious'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("CategoryPagingPrevious");
					}

					if($GLOBALS['ISC_CLASS_NEWSEARCH']->GetPage() < $GLOBALS['ISC_CLASS_NEWSEARCH']->GetNumPages()) {
						// Do we need to output a "Next" link?
						$GLOBALS['NextLink'] = SearchLink($GLOBALS['ISC_CLASS_NEWSEARCH']->GetQuery(), $GLOBALS['ISC_CLASS_NEWSEARCH']->GetPage()+1);
						$GLOBALS['SNIPPETS']['CategoryPagingNext'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("CategoryPagingNext");
					}

					$output = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("CategoryPaging");
					$output = $GLOBALS['ISC_CLASS_TEMPLATE']->ParseSnippets($output, $GLOBALS['SNIPPETS']);

					$GLOBALS['SNIPPETS']['SearchPaging'] = $output;
				}
			}
			else {
				// No search results were found
				$GLOBALS['HideSearchResults'] = "none";
			}
		}
	}
?>