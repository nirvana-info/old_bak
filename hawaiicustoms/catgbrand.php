<?php
include(dirname(__FILE__) . "/init.php");

$GLOBALS['ISC_CLASS_CATGBRANDINFO'] = GetClass('ISC_CATGBRANDINFO'); 
echo $GLOBALS['ISC_CLASS_CATGBRANDINFO']->GetInfo();
exit;

?>