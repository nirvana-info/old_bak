<?php
include(dirname(__FILE__) . "/init.php");

if( isset($_GET['getymms']) ){
    $GLOBALS['ISC_YMMS'] = GetClass('ISC_YMMS');
    $redefine_search_output = $GLOBALS['ISC_YMMS']->GetYmmsForMyVehicleArea();
}elseif( isset($_GET['getymms2']) ){
    $GLOBALS['ISC_YMMS'] = GetClass('ISC_YMMS');
    $redefine_search_output = $GLOBALS['ISC_YMMS']->GetYmmsForMiddleInPage();
}elseif( isset($_GET['getymms3']) ){
    $GLOBALS['ISC_YMMS'] = GetClass('ISC_YMMS');
    $redefine_search_output = $GLOBALS['ISC_YMMS']->GetYmmsForDialogPage();
}elseif( isset($_REQUEST['autopopulate']) ){
$GLOBALS['ISC_CLASS_REDEFINE_SEARCH'] = GetClass('ISC_REDEFINE_SEARCH');  
	$redefine_search_output = $GLOBALS['ISC_CLASS_REDEFINE_SEARCH']->_GetYMMOptions();
}else{
    $GLOBALS['ISC_CLASS_REDEFINE_SEARCH'] = GetClass('ISC_REDEFINE_SEARCH');  
	$redefine_search_output = $GLOBALS['ISC_CLASS_REDEFINE_SEARCH']->_ProcessSearch();
}
echo $redefine_search_output;

?>