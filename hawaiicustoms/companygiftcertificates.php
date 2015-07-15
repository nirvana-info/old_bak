<?php
	include(dirname(__FILE__)."/init.php");
	require(dirname(__FILE__).'/includes/classes/class.companygiftcertificates.php');
	$GLOBALS['ISC_CLASS_COMPANY_GIFT_CERTIFICATES'] = GetClass('ISC_COMPANYGIFTCERTIFICATES');
	$GLOBALS['ISC_CLASS_COMPANY_GIFT_CERTIFICATES']->HandlePage();
?>
