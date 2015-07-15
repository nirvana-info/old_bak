<?php

	CLASS ISC_PRODUCTTABS_PANEL extends PANEL
	{
		public function SetPanelSettings()
		{
			if(GetConfig('EnableProductTabs') == 0) {
				$GLOBALS['HideSectionSeparator'] = '';
				$this->DontDisplay = true;
				return;
			}
			$GLOBALS['HideSectionSeparator'] = 'display:none;';
		}
	}
?>