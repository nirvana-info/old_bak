<?php

	include(dirname(__FILE__)."/init.php");
	$GLOBALS['ISC_CLASS_ORDER'] = GetClass('ISC_MAKEAOFFER');
	$GLOBALS['ISC_CLASS_ORDER']->HandlePage();
?>
