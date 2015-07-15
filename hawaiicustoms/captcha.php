<?php
	$adminstr = $_REQUEST['isadmin'] ? '/admin' : '';
	include(dirname(__FILE__).$adminstr."/init.php");
	include(dirname(__FILE__) . "/includes/classes/class.captcha.php");
	$GLOBALS['ISC_CLASS_CAPTCHA'] = GetClass('ISC_CAPTCHA');
	$GLOBALS['ISC_CLASS_CAPTCHA']->OutputImage();
?>
