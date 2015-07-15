<?php
	exit(0);//zcs=
	include(dirname(__FILE__) . "/init.php");
	$GLOBALS['ISC_CLASS_INSTALL_IMAGE'] = GetClass('ISC_OFFER');   
	$GLOBALS['ISC_CLASS_INSTALL_IMAGE']->HandlePage();

?>
