<?php

class ISC_404
{
	function HandlePage()
	{
		// Send the 404 status headers
		header("HTTP/1.1 404 Not Found");

		// Simply show the 404 page
		$GLOBALS['ISC_CLASS_TEMPLATE']->SetPageTitle(GetConfig('StoreName')." - ".GetLang('NotFound'));
		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("404");
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
	}
}

?>