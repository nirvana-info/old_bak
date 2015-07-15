<?php

	CLASS ISC_SIDENEWSLETTERBOX_PANEL extends PANEL
	{
		function SetPanelSettings()
		{
			$output = "";
			$GLOBALS['SNIPPETS']['SideNewsletterBox'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("DefaultNewsletterSubscriptionForm");
		}
	}

?>