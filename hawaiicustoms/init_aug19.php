<?php
	require_once(dirname(__FILE__).'/lib/init.php');

	define("APP_ROOT", dirname(__FILE__));

	define("SEARCH_SIMPLE", 0);
	define("SEARCH_ADVANCED", 1);

	if (GetConfig('isSetup') === false) {
		if (file_exists(ISC_CONFIG_BACKUP_FILE)) {
			if(RevertToBackupConfig()) {
				header("Location: ".$_SERVER['PHP_SELF']);
			}
			else {
				echo "Your <strong>config/config.php</strong> file is not writeable and cannot be restored to a previously backed up version. Please change the file permissions of this file so that it is writeable (CHMOD 757, 777 etc)";
				exit;
			}
		} else {
			header("Location: admin/");
			die();
		}
	}

	$GLOBALS['PathInfo'] = array();
	$GLOBALS['RewriteRules'] = array(
		"index" => array(
			"class" => "class.index.php",
			"name" => "ISC_INDEX",
			"global" => "ISC_CLASS_INDEX"
		),
		"store" => array(
			"class" => "class.index.php",
			"name" => "ISC_INDEX",
			"global" => "ISC_CLASS_INDEX"
		),
		"shop" => array(
			"class" => "class.index.php",
			"name" => "ISC_INDEX",
			"global" => "ISC_CLASS_INDEX"
		),
		"products" => array(
			"class" => "class.product.php",
			"name" => "ISC_PRODUCT",
			"global" => "ISC_CLASS_PRODUCT"
		),
		"pages" => array(
			"class" => "class.page.php",
			"name" => "ISC_PAGE",
			"global" => "ISC_CLASS_PAGE"
		),
		"categories" => array(
			"class" => "class.category.php",
			"name" => "ISC_CATEGORY",
			"global" => "ISC_CLASS_CATEGORY"
		),
		"brands" => array(
			"class" => "class.brands.php",
			"name" => "ISC_BRANDS",
			"global" => "ISC_CLASS_BRANDS"
		),
		"price" => array(
			"class" => "class.price.php",
			"name" => "ISC_PRICE",
			"global" => "ISC_CLASS_PRICE"
		),
		"news" => array(
			"class" => "class.news.php",
			"name" => "ISC_NEWS",
			"global" => "ISC_CLASS_NEWS"
		),
		"compare" => array(
			"class" => "class.compare.php",
			"name" => "ISC_COMPARE",
			"global" => "ISC_CLASS_COMPARE"
		),
		"404" => array(
			"class" => "class.404.php",
			"name" => "ISC_404",
			"global" => "ISC_CLASS_404"
		),
		"tags" => array(
			"class" => "class.tags.php",
			"name" => "ISC_TAGS",
			"global" => "ISC_CLASS_TAGS"
		),
		"vendors" => array(
			"class" => "class.vendors.php",
			"name" => "ISC_VENDORS",
			"global" => "ISC_CLASS_VENDORS"
		),
        "productimages" => array(
            "class" => "class.productimage.php",
            "name" => "ISC_PRODUCTIMAGE",
            "global" => "ISC_CLASS_PRODUCTIMAGE"
        ),
        "installimages" => array(
            "class" => "class.installimage.php",
            "name" => "ISC_INSTALLIMAGE",
            "global" => "ISC_CLASS_INSTALLIMAGE"
        ),
        "productvideos" => array(
            "class" => "class.productvideo.php",
            "name" => "ISC_PRODUCTVIDEO",
            "global" => "ISC_CLASS_PRODUCTVIDEO"
        ),
        "installvideos" => array(
            "class" => "class.installvideo.php",
            "name" => "ISC_INSTALLVIDEO",
            "global" => "ISC_CLASS_INSTALLVIDEO"
        ),
        "productaudios" => array(
            "class" => "class.productaudio.php",
            "name" => "ISC_PRODUCTAUDIO",
            "global" => "ISC_CLASS_PRODUCTAUDIO"
        ),
        "search" => array(
            "class" => "class.search.php",
            "name" => "ISC_SEARCH",
            "global" => "ISC_CLASS_SEARCH"
        ) ,
        "account" => array(
            "class" => "class.account.php",
            "name" => "ISC_ACCOUNT",
            "global" => "ISC_CLASS_ACCOUNT"
        ) ,
        "login" => array(
            "class" => "class.customer.php",
            "name" => "ISC_CUSTOMER",
            "global" => "ISC_CLASS_CUSTOMER"
        ) ,
        "wishlist" => array(
            "class" => "class.wishlist.php",
            "name" => "ISC_WISHLIST",
            "global" => "ISC_CLASS_WISHLIST"
        ) ,
        "defectreport" => array(
            "class" => "class.wishlist.php",
            "name" => "ISC_DEFECTREPORT",
            "global" => "ISC_CLASS_DEFECTREPORT"
        ) ,
        "giftcertificates" => array(
            "class" => "class.giftcertificates.php",
            "name" => "ISC_GIFTCERTIFICATES",
            "global" => "ISC_CLASS_GIFTCERTIFICATES"
        ) ,
        "cart" => array(
            "class" => "class.cart.php",
            "name" => "ISC_CART",
            "global" => "ISC_CLASS_CART"
        ) 
		,
        "pages" => array(
            "class" => "class.page.php",
            "name" => "ISC_PAGE",
            "global" => "ISC_CLASS_PAGE"
        )
        ,
        "sweepstakes" => array(
            "class" => "class.sweepstakes.php",
            "name" => "ISC_SWEEPSTAKES",
            "global" => "ISC_CLASS_SWEEPSTAKES"
        )
        ,
        "clearance" => array(
            "class" => "class.clearance.php",
            "name" => "ISC_CLEARANCE",
            "global" => "ISC_CLASS_CLEARANCE"
        ) 
	,
	"order" => array(
            "class" => "class.order.php",
            "name" => "ISC_ORDER",
            "global" => "ISC_CLASS_ORDER"
        )  
	);

	$GLOBALS['RewriteURLBase'] = '';

	// Initialise our session
	require_once(ISC_BASE_PATH . "/includes/classes/class.session.php");
	$GLOBALS['ISC_CLASS_SESSION'] = new ISC_SESSION();

	// Is purchasing disabled in the store?
	if(!GetConfig("AllowPurchasing")) {
		$GLOBALS['HidePurchasingOptions'] = "none";
	}

	// Are prices disabled in the store?
	if(!GetConfig("ShowProductPrice")) {
		$GLOBALS['HideCartOptions'] = "none";
	}

	// Is the wishlist disabled in the store?
	if(!GetConfig("EnableWishlist")) {
		$GLOBALS['HideWishlist'] = "none";
	}

	// Is account creation disabled in the store?
	if(!GetConfig("EnableAccountCreation")) {
		$GLOBALS['HideAccountOptions'] = "none";
	}

	// Setup our currency. If we don't have one in our session then get/set our currency based on our geoIP location
	SetupCurrency();

	// Do we need to show the cart contents side box at all?
	if(!isset($_SESSION['CART']['ITEMS']) || count($_SESSION['CART']['ITEMS']) == 0) {
		$GLOBALS['HidePanels'][] = "SideCartContents";
	}

	// Include the template's config file
	require_once(ISC_BASE_PATH . "/templates/" . GetConfig('template') . "/config.php");

	$GLOBALS['TPL_PATH'] = GetConfig("ShopPath") . "/" . "templates" . "/" . GetConfig("template");
	$GLOBALS['ISC_CLASS_TEMPLATE'] = new TEMPLATE("ISC_LANG");
	$GLOBALS['ISC_CLASS_TEMPLATE']->FrontEnd();
	$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplateBase(ISC_BASE_PATH . "/templates");
	$GLOBALS['ISC_CLASS_TEMPLATE']->panelPHPDir = ISC_BASE_PATH . "/includes/display/";
	$GLOBALS['ISC_CLASS_TEMPLATE']->templateExt = "html";
	$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate(GetConfig("template"));

	$GLOBALS['ISC_CLASS_VISITOR'] = GetClass('ISC_VISITOR');

	if(isset($GLOBALS['ShowStoreUnavailable'])) {
		$GLOBALS['ErrorMessage'] = GetLang('StoreUnavailable');
		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("error");
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		exit;
	}

	// Set the default page title
	$GLOBALS['ISC_CLASS_TEMPLATE']->SetPageTitle(GetConfig('StoreName'));

	// Get the number of items in the cart if any
	if(isset($_SESSION['CART']['NUM_ITEMS'])) {
		$num_items = $_SESSION['CART']['NUM_ITEMS'];
		foreach($_SESSION['CART']['ITEMS'] as $item) {
			if(!isset($item['product_id'])) {
				continue;
			}
			$GLOBALS['CartQuantity'.$item['product_id']] = $item['quantity'];
		}
		if ($num_items == 1) {
			$GLOBALS['CartItems'] = GetLang('OneItem');
		} else if ($num_items > 1) {
			$GLOBALS['CartItems'] = sprintf(GetLang('XItems'), $num_items);
		} else {
			$GLOBALS['CartItems'] = '';
		}
	}

    if(isset($num_items) && $num_items>0)    {
        $GLOBALS['CartTotalQuantity'] = '('.(string)$num_items.')'; 
    }
    else    {
        $GLOBALS['CartTotalQuantity'] = ''; 
    }
    

?>
