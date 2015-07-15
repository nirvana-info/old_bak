<?php

	include(dirname(__FILE__) . "/init.php");
	$GLOBALS['ISC_CLASS_INSTALL_IMAGE'] = GetClass('ISC_INSTALLIMAGE');   
	$GLOBALS['ISC_CLASS_INSTALL_IMAGE']->HandlePage();

?>
