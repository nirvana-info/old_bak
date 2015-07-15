<?php

	CLASS ISC_HOMEBOTTOMPROMOTION_PANEL extends PANEL
	{
		var $_placementid = "promo_homepage_bottom_image";

		function SetPanelSettings()
		{
			$output = "";
			$query = sprintf("select * from [|PREFIX|]promotions where placementid='%s'", $GLOBALS['ISC_CLASS_DB']->Quote($this->_placementid));
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			if($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$output = sprintf("<a href='%s'><img id='HomeBottomAd' src='%s/promotion_images/%s' /></a>", $row['link'], $GLOBALS['ShopPath'], $row['image']);
			}

			$GLOBALS['SNIPPETS']['HomeBottomPromotion'] = $output;
		}
	}

?>