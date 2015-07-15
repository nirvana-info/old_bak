<?php

	/**

		----------------------------------------------------------------------------------------

		If you are seeing this message in your web browser, it means PHP has not been setup
		or enabled on your web server. Enable PHP from your web hosting control panel or contact
		your web host to enable it for you.

		----------------------------------------------------------------------------------------
*/





	include(dirname(__FILE__)."/init.php");

	/* Added the below condition to redirect to the specified address */

	$current_url = $GLOBALS['ShopPath'].$_SERVER['REQUEST_URI'];
	$current_url = rtrim($current_url,"/");

	$check_url_qry = "select * from [|PREFIX|]redirect_pages where source_url='".$current_url."' OR source_url='".$current_url."/'";
	$check_url_res = $GLOBALS['ISC_CLASS_DB']->Query($check_url_qry); 
	$check_url_rows = $GLOBALS['ISC_CLASS_DB']->CountResult($check_url_res);
	if($check_url_rows > 0)
	{
		$check_url_arr = $GLOBALS['ISC_CLASS_DB']->Fetch($check_url_res);
		header("Location: ".$check_url_arr['destination_url']);
		die();
	}

	// Visitor tracking Javascript
	if(isset($_REQUEST['action'])) {
		if($_REQUEST['action'] == "tracking_script") {
			$visitor = GetClass('ISC_VISITOR');
			$visitor->OutputTrackingJavascript();
		}
		else if($_REQUEST['action'] == "track_visitor") {
			$visitor = GetClass('ISC_VISITOR');
			$visitor->TrackVisitor();
		}
	}
    RedirectToHTTP();
	/**
	 * Index.php does something special - it passes off all requests
	 * to a worker function which decide on the page that should be
	 * shown.
	 */
	RewriteIncomingRequest();
?>
