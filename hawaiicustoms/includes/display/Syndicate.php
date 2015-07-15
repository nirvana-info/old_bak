<?php

	CLASS ISC_SYNDICATE_PANEL extends PANEL
	{
		function SetPanelSettings()
		{
			if(GetConfig('RSSNewProducts') == 0) {
				$GLOBALS['ShowNewProductsFeed'] = "none";
			}
			else {
				$GLOBALS['ISC_LANG']['SyndicateNewProductsIntro'] = sprintf(GetLang('SyndicateNewProductsIntro'), GetConfig('RSSItemsLimit'), $GLOBALS['StoreName']);
				$GLOBALS['ISC_LANG']['SyndicateNewProductsRSS'] = sprintf(GetLang('SyndicateNewProductsRSS'), GetConfig('RSSItemsLimit'));
				$GLOBALS['ISC_LANG']['SyndicateNewProductsAtom'] = sprintf(GetLang('SyndicateNewProductsAtom'), GetConfig('RSSItemsLimit'));
			}

			if(GetConfig('RSSPopularProducts') == 0) {
				$GLOBALS['ShowPopularProductsFeed'] = "none";
			}
			else {
				$GLOBALS['ISC_LANG']['SyndicatePopularProductsIntro'] = sprintf(GetLang('SyndicatePopularProductsIntro'), GetConfig('RSSItemsLimit'), $GLOBALS['StoreName']);
				$GLOBALS['ISC_LANG']['SyndicatePopularProductsRSS'] = sprintf(GetLang('SyndicatePopularProductsRSS'), GetConfig('RSSItemsLimit'));
				$GLOBALS['ISC_LANG']['SyndicatePopularProductsAtom'] = sprintf(GetLang('SyndicatePopularProductsAtom'), GetConfig('RSSItemsLimit'));
			}

			if(GetConfig('RSSProductSearches') == 0) {
				$GLOBALS['ShowSearchFeed'] = "none";
			}
			else {
				$GLOBALS['ISC_LANG']['SyndicateSearchesIntro2'] = sprintf(GetLang('SyndicateSearchesIntro2'), $GLOBALS['StoreName']);
			}

			if(GetConfig('RSSLatestBlogEntries') == 0) {
				$GLOBALS['ShowNewsFeed'] = "none";
			}
			else {
				$GLOBALS['ISC_LANG']['SyndicateNewsIntro'] = sprintf(GetLang('SyndicateNewsIntro'), GetConfig('RSSItemsLimit'), $GLOBALS['StoreName']);
				$GLOBALS['ISC_LANG']['SyndicateNewsRSS'] = sprintf(GetLang('SyndicateNewsRSS'), GetConfig('RSSItemsLimit'));
				$GLOBALS['ISC_LANG']['SyndicateNewsAtom'] = sprintf(GetLang('SyndicateNewsAtom'), GetConfig('RSSItemsLimit'));
			}
		}
	}
?>