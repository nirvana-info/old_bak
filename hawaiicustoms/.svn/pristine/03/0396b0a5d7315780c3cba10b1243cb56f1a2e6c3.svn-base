<?php

	CLASS ISC_CARTHEADER_PANEL extends PANEL
	{
		public function SetPanelSettings()
		{

			$ShowCheckoutButton = false;
			if(isset($_SESSION['CART']['NUM_ITEMS']) && $_SESSION['CART']['NUM_ITEMS'] != 0) {
				foreach (GetAvailableModules('checkout', true, true) as $module) {
					if ($module['object']->disableNonCartCheckoutButtons) {
						$GLOBALS['HideCheckoutButton'] = 'display: none';
						$ShowCheckoutButton = false;
						break;
					}
					if (!method_exists($module['object'], 'GetCheckoutButton')) {
						$ShowCheckoutButton = true;
					}
				}
			}

			$GLOBALS['HideCheckoutButton'] = '';

			if (!$ShowCheckoutButton) {
				$GLOBALS['HideCheckoutButton'] = 'display: none';
			}

		}
	}

?>
