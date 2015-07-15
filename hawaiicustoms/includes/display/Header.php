<?php

	CLASS ISC_HEADER_PANEL extends PANEL
	{
		function SetPanelSettings()
		{
			// Are we using a text or image-based logo?
			$GLOBALS['HeaderLogo'] = FetchHeaderLogo();
		}
	}

?>