<?php

	CLASS ISC_SIDECATEGORYSHOPBYPRICE_PANEL extends PANEL
	{
		public function SetPanelSettings()
		{
			$output = "";
			$lastend = 0;

			if(isset($GLOBALS['ISC_CLASS_CATEGORY'])) {
				$categorySql = $GLOBALS['ISC_CLASS_CATEGORY']->GetCategoryAssociationSQL();
			}
			else if(isset($GLOBALS['ISC_CLASS_PRICE'])) {
				$categorySql = $GLOBALS['ISC_CLASS_PRICE']->GetCategoryAssociationSQL();
			}

			$query = "
				SELECT
					MIN(prodcalculatedprice) AS pmin,
					MAX(prodcalculatedprice) AS pmax
				FROM
					[|PREFIX|]products p
				WHERE
					p.prodvisible='1' AND
					p.prodhideprice=0 "
					. $categorySql . "
				ORDER BY
					p.productid DESC
			";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			if ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$min = ceil($row['pmin']);
				$max = ceil($row['pmax']);

				// Is there enough of a variation to show a shop by price panel?
				if ($max - $min > $min) {
					$diff = (($max - $min) / 5);

					if($diff == 0) {
						$diff = 1;
					}

					for ($i = 0; $i < 5; $i++) {
						if ($lastend == 0) {
							$start = $min + ($diff * $i);
						} else {
							$start = $lastend;
						}

						$end = $start + $diff;

						if($end == $lastend) {
							break;
						}

						if ($lastend == 0) {
							$start = 0;
						}

						$lastend = $end;

						$start = round($start);
						$end = round($end);

						$GLOBALS['PriceLow'] = CurrencyConvertFormatPrice($start);
						$GLOBALS['PriceHigh'] = CurrencyConvertFormatPrice($end);

						if (is_array($GLOBALS['CatPath'])) {
							$GLOBALS['CatPath'] = implode("/", $GLOBALS['CatPath']);
						}

						$GLOBALS['PriceLink'] = PriceLink($start, $end, $GLOBALS['CatId'], $GLOBALS['CatPath']);

						$output .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("ShopByPriceItem");
					}
				}
				else {
					$GLOBALS['HideSideCategoryShopByPricePanel'] = "none";
					$this->DontDisplay = true;
				}
			}
			else {
				$GLOBALS['HideSideCategoryShopByPricePanel'] = "none";
				$this->DontDisplay = true;
			}

			$GLOBALS['SNIPPETS']['SideCategoryShopByPrice'] = $output;
		}
	}

?>