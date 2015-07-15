<?php

	/*******************************************\
	*                                           *
	*  Generic Interspire Shopping Cart Panel Parsing Class   *
	*                                           *
	\*******************************************/

	CLASS ISC_PRICEHEADING_PANEL extends PANEL
	{
		public function SetPanelSettings()
		{
			$GLOBALS['ISC_CLASS_PRICE'] = GetClass('ISC_PRICE');

			if($GLOBALS['ISC_CLASS_PRICE']->GetNumProducts() > 1) {
				// Parse the sort select box snippet
				if($GLOBALS['EnableSEOUrls'] == 1) {
					$GLOBALS['URL'] = PriceLink($GLOBALS['ISC_CLASS_PRICE']->GetMinPrice(), $GLOBALS['ISC_CLASS_PRICE']->GetMaxPrice(), $GLOBALS['CatId'], $GLOBALS['ISC_CLASS_PRICE']->GetCatPath());
				}
				else {
					$GLOBALS['URL'] = $GLOBALS['ShopPath']."/price.php";
					$hiddenFields = array(
						"low" => isc_html_escape($GLOBALS['ISC_CLASS_PRICE']->GetMinPrice()),
						"high" => isc_html_escape($GLOBALS['ISC_CLASS_PRICE']->GetMaxPrice()),
						"category" => (int) $GLOBALS['CatId'],
						"path" => isc_html_escape($GLOBALS['ISC_CLASS_PRICE']->GetCatPath())
					);
					$GLOBALS['HiddenSortField'] = '';
					foreach($hiddenFields as $name => $field) {
						$GLOBALS['HiddenSortField'] .= "<input type=\"hidden\" name=\"".$name."\" value=\"".$field."\" />";
					}
				}

				$GLOBALS['SNIPPETS']['CategorySortBox'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("CategorySortBox");
			}
		}
	}

?>
