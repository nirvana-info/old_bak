<?php
CLASS ISC_PRICEBREADCRUMB_PANEL extends PANEL
{
	public function SetPanelSettings()
	{
		// Output breadcrumb trail
		$GLOBALS['SNIPPETS']['CatTrail'] = "";
		$baseLink = sprintf("%s/categories", $GLOBALS['ShopPath']);
		$count = 0;
		foreach($GLOBALS['CatTrail'] as $trail) {
			$baseLink .= "/" . MakeURLSafe($trail[1]);
			$GLOBALS['CatTrailName'] = $trail[1];
			$GLOBALS['CatTrailLink'] = $baseLink;
			$GLOBALS['SNIPPETS']['CatTrail'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("BreadcrumbItem");
		}
	}
}
?>