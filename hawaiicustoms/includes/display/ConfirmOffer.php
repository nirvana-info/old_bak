<?php
CLASS ISC_CONFIRMOFFER_PANEL extends PANEL
{
	function SetPanelSettings()
	{
		// How did they get here without a billing address?
		if (!isset($_SESSION['CHECKOUT']['BILLING_ADDRESS'])) {
			ob_end_clean();
			header(sprintf("location:%s/checkout.php?action=choose_billing_address", $GLOBALS['ShopPath']));
			die();
		}
		$GLOBALS['ISC_CLASS_CHECKOUT'] = GetClass('ISC_FINALIZEOFFER');
		$GLOBALS['ISC_CLASS_CHECKOUT']->BuildOrderConfirmation();
	}
}

?>
