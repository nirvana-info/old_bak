<?php

	class ISC_CART
	{

		private $pageTitle = "";
		private $badCouponCode = false;
		private $badCouponMessage = "";
		private $cartErrorMessage = "";

		/**
		 * @var int The ID of the item that was just added to the cart.
		 */
		public $newCartItem = 0;

		public $api = null;

		public function __construct()
		{
			if($GLOBALS['EnableSEOUrls'] == 1)
			{
				$url_array = split('/', strtolower($_SERVER['REQUEST_URI']));
				$searchlogid = $url_array[array_search('searchlogid', $url_array, true)+1];
			}
			else
			{
				$searchlogid = $_GET['SearchLogId'];
			}
			UpdateSearchLogforBestKeyWord($searchlogid);
			
			// Initialize the cart management API.
			$this->api = new ISC_CART_API();
			if(!isset($_SESSION['CART'])) {
				$_SESSION['CART'] = array();
			}
			$this->api->SetCartSession($_SESSION['CART']);

			// Setup the number of products in the cart which will be shown
			// on the header of every page of the site
			$this->SetNumItemsInCart();

			// Setup the page title
			$this->pageTitle = GetConfig('StoreName') . " - " . GetLang('ShoppingCart');

			// The default "Click here to keep shopping" text
			//commented by blessen
//			if ($this->api->GetNumItemsInCart() > 0) {
//				$GLOBALS['KeepShoppingText'] = GetLang('ClickHereToKeepShopping');
//				$GLOBALS['KeepShoppingLink'] = "javascript:history.go(-1)"; // $GLOBALS['ShopPath'];
//			} else {
//				$GLOBALS['KeepShoppingText'] = '';
//				$GLOBALS['KeepShoppingLink'] = ''; // $GLOBALS['ShopPath'];
//			}

			if (isset($_SESSION['JustAddedProduct']) && $_SESSION['JustAddedProduct'] != '') {
				// Get the category of the last product added to the store
				$query = sprintf("select c.categoryid, catname from [|PREFIX|]categoryassociations ca inner join [|PREFIX|]categories c on ca.categoryid=c.categoryid where ca.productid='%d' ", $GLOBALS['ISC_CLASS_DB']->Quote((int)$_SESSION['JustAddedProduct']));
				$query .= $GLOBALS['ISC_CLASS_DB']->AddLimit(0, 1);
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

				if ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					$GLOBALS['KeepShoppingLink'] = CatLinkNew($row['categoryid'], $row['catname']);
					$GLOBALS['KeepShoppingText'] = sprintf(GetLang('ClickHereToKeepShoppingCat'), isc_html_escape($row['catname']));
				}
				$_SESSION['JustAddedProduct'] = '';
			}

			// Special function used to reconvert currencies if the admin user changes the default currency while people currently have items in their cart
			RecompileOrderPrices();
		}

		public function SetNumItemsInCart()
		{
			$num_items = $this->api->GetNumItemsInCart();

			if ($num_items == 1) {
				$GLOBALS['CartItems'] = GetLang('OneItem');
			} else if ($num_items > 1) {
				$GLOBALS['CartItems'] = sprintf(GetLang('XItems'), $num_items);
			} else {
				$GLOBALS['CartItems'] = '';
			}
		}

		public function HandlePage()
		{
			$action = "";

			if (count($GLOBALS['PathInfo']) > 0 ){
				if (isset ($GLOBALS['PathInfo'][1])) {
					$_REQUEST['action'] = $GLOBALS['PathInfo'][1];
				}
				else
				{
					$_REQUEST['action'] = $GLOBALS['PathInfo'][0];
				}
			}

			if (isset($_REQUEST['action'])) {
				$action = isc_strtolower($_REQUEST['action']);
			}

            if (isset($_REQUEST['action1'])) {
                $this->ApplyCoupon(); 
            }
            
			$GLOBALS['AdditionalStylesheets'][] = GetConfig('AppPath').'/javascript/jquery/plugins/imodal/imodal.css';
			CheckReferrer(); // checking and assigning the back to search link

			//blessen
			$_SESSION['makeaoffer'] = "No";
			
			switch ($action) {
				case "add": {
					$this->AddToCart();
					break;
				}
				case "suggestions":
					$this->ShowSuggestiveCart();
					break;
				case "addcertificate": {
					$this->AddGiftCertificateToCart();
					break;
				}
				case "remove": {
					$this->RemoveFromCart();
					break;
				}
				case "update": {
					$this->UpdateInCart();
					break;
				}
				case "applyoff": {
					$this->ApplyOff();
					break;
				}
				case "applycoupon": {
					$this->ApplyCoupon();
					break;
				}
				case "applygiftcertificate": {
					$this->ApplyGiftCertificate();
					break;
				}
                // Add by NI_20100826_Jack
            	case "applycompanygiftcertificate": {
                    $this->ApplyCompanyGiftCertificate();
                    break;
                }
				case 'save_giftwrapping': {
					$this->SaveGiftWrapping();
					break;
				}
				case 'remove_giftwrapping': {
					$this->RemoveGiftWrapping();
					break;
				}
				case "removegiftcertificate": {
					$this->RemoveGiftCertificate();
                    break;
                }
                // Add by NI_20100826_Jack
                case "removecompanygiftcertificate": {
                    $this->RemoveCompanyGiftCertificate();
					break;
				}
				case "editproductfieldsincart": {
					$this->EditProductFieldsInCart();
					break;
				}
				case "removecoupon":
					$this->RemoveCoupon();
					break;
				case "addreorderitems":
					$this->AddReorderItems();
					break;
				default: {
					$this->ShowRegularCart();
				}
			}
		}

		/**
		 * Remove the gift wrapping preferences for a particular item in the cart.
		 */
		private function RemoveGiftWrapping()
		{
			if(isset($_REQUEST['item_id'])) {
				$this->api->RemoveGiftWrapping($_REQUEST['item_id']);
			}

			$_SESSION['CART']['MESSAGE'] = GetLang('GiftWrappingRemoved');
			unset($_SESSION['CHECKOUT']);
			ob_end_clean();
			header("Location: ".GetConfig('ShopPath').'/cart.php');
			exit;
		}

		/**
		 * Save the gift wrapping preferences for a particular item in the cart.
		 */
		private function SaveGiftWrapping()
		{
			if(!isset($_POST['item_id'])) {
				ob_end_clean();
				header("Location: ".GetConfig('ShopPath').'/cart.php');
				exit;
			}

			// Wrapping couldn't be applied so throw an error
			if(!$this->api->ApplyGiftWrapping($_POST['item_id'], $_POST['giftwraptype'], $_POST['giftwrapping'], $_POST['giftmessage'])) {
				$_SESSION['CART']['ERROR'] = implode('<br />', $this->api->GetErrors());
				ob_end_clean();
				header("Location: ".GetConfig('ShopPath').'/cart.php');
				exit;
			}

			// Otherwise, the wrapping has been applied
			$_SESSION['CART']['MESSAGE'] = GetLang('GiftWrappingApplied');
			unset($_SESSION['CHECKOUT']);
			ob_end_clean();
			header("Location: ".GetConfig('ShopPath').'/cart.php');
			exit;
		}

		/**
		* Edit the custom information of the items in cart.
		*
		*/
		private function EditProductFieldsInCart()
		{
			if(!isset($_REQUEST['item_id'])) {
				ob_end_clean();
				$this->ShowRegularCart();
				die();
			}

			$itemId = $_REQUEST['item_id'];

			$configurableFields = null;
			if(isset($_REQUEST['ProductFields']) || isset($_FILES['ProductFields'])) {
				$configurableFields = $this->BuildProductConfigurableFieldData();
			}


			if(!$this->api->UpdateItemConfiguration($itemId, $configurableFields)) {
				$this->cartErrorMessage = GetLang('CouldntProductFieldsUpdate').implode('<br />', $this->api->GetErrors());
				$this->ShowRegularCart();
				return;
			}

			ob_end_clean();
			$this->ShowRegularCart();
			die();
		}

		private function BuildProductConfigurableFieldData()
		{
			$configurableFields = array();
			if(isset($_REQUEST['ProductFields']) && is_array($_REQUEST['ProductFields'])) {
				$configurableFields = $_REQUEST['ProductFields'];
			}

			if(isset($_FILES['ProductFields']) && is_array($_FILES['ProductFields'])) {
				$fileFields = array_keys($_FILES['ProductFields']);
				foreach(array_keys($_FILES['ProductFields']['name']) as $fieldId) {
					$configurableFields[$fieldId] = array();
					foreach($fileFields as $field) {
						if(!isset($_FILES['ProductFields'][$field][$fieldId])) {
							continue;
						}
						$configurableFields[$fieldId][$field] = $_FILES['ProductFields'][$field][$fieldId];
					}
				}
			}
			return $configurableFields;
		}

		/**
		* Adds a simple product (no variations, configurable fields or events) to the cart
		*
		* @param mixed $product_id
		* @param mixed $qty
		*/
		public function AddSimpleProductToCart($product_id, $qty = 1)
		{
			$error = "";

			$query = "
				SELECT p.*, ".GetProdCustomerGroupPriceSQL()."
				FROM [|PREFIX|]products p
				WHERE p.productid='".(int)$product_id."'
			";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$product = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

			// Check that the customer has permisison to view this product
			$canView = false;
			$productCategories = explode(',', $product['prodcatids']);
			foreach($productCategories as $categoryId) {
				// Do we have permission to access this category?
				if(CustomerGroupHasAccessToCategory($categoryId)) {
					$canView = true;
				}
			}
			if($canView == false) {
				$_SESSION['AddProductErrorMessage'] = sprintf(GetLang("NoPermissionAddProduct"), $product["prodname"]);
				return false;
			}

			// Actually add the product to the cart
			$cartItemId = $this->api->AddItem($product_id, $qty);
			$this->newCartItem = $cartItemId;

			if($cartItemId === false) {
				$error = implode('\n', $this->api->GetErrors());
				if(!$error) {
					$error = GetLang('ProductUnavailableForPruchase');
				}
				$_SESSION['AddProductErrorMessage'] = $error;
				return false;
			}

			$this->api->UpdateCartInformation();

			return true;
		}

		private function AddToCart()
		{
			if(!isset($_REQUEST['product_id'])) {
				ob_end_clean();
				header(sprintf("Location: %s/cart.php", GetConfig('ShopPath')));
				die();
			}

			// First get the list of existing products in the cart
			$product_id = (int)$_REQUEST['product_id'];
			$GLOBALS['ProductJustAdded'] = $product_id;

			$query = "
				SELECT p.*, ".GetProdCustomerGroupPriceSQL()."
				FROM [|PREFIX|]products p
				WHERE p.productid='".(int)$product_id."'
			";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$product = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
			$GLOBALS['Product'] = &$product;

			// Check that the customer has permisison to view this product
			$canView = false;
			$productCategories = explode(',', $product['prodcatids']);
			foreach($productCategories as $categoryId) {
				// Do we have permission to access this category?
				if(CustomerGroupHasAccessToCategory($categoryId)) {
					$canView = true;
				}
			}
			if($canView == false) {
				$noPermissionsPage = GetClass('ISC_403');
				$noPermissionsPage->HandlePage();
				exit;
			}

			$variation = 0;
			if(isset($_REQUEST['variation_id']) && $_REQUEST['variation_id'] != 0) {
				$variation = (int)$_REQUEST['variation_id'];
			}
			// User added a variation but had javascript disabled
			else if(isset($_REQUEST['variation']) && is_array($_REQUEST['variation']) && $_REQUEST['variation'][1] != 0) {
				$variation = $_REQUEST['variation'];
			}

			$qty = 1;
			if(isset($_REQUEST['qty'])) {
				if(is_array($_REQUEST['qty'])) {
					$qty = (int)array_pop($_REQUEST['qty']);
				}
				else if($_REQUEST['qty'] > 0) {
					$qty = (int)$_REQUEST['qty'];
				}
			}

			$configurableFields = null;
			if(isset($_REQUEST['ProductFields']) || isset($_FILES['ProductFields'])) {
				$configurableFields = $this->BuildProductConfigurableFieldData();
			}

			$options = array();

			if (isset($_REQUEST['EventDate']['Day'])) {

				$result = true;

				$eventDate = isc_gmmktime(0, 0, 0, $_REQUEST['EventDate']['Mth'],$_REQUEST['EventDate']['Day'],$_REQUEST['EventDate']['Yr']);
				$eventName = $product['prodeventdatefieldname'];

				if ($product['prodeventdatelimitedtype'] == 1) {

					if ($eventDate < $product['prodeventdatelimitedstartdate'] || $eventDate > $product['prodeventdatelimitedenddate']) {
						$result = false;
					}

				} else if ($product['prodeventdatelimitedtype'] == 2) {
					if ($eventDate < $product['prodeventdatelimitedstartdate']) {

						$result = false;
					}

				} else if ($product['prodeventdatelimitedtype'] == 3) {
					if ($eventDate > $product['prodeventdatelimitedenddate']) {
						$result = false;
					}
				}

				if ($result == false) {
					$this->ShowRegularCart();
					return;
				}

				$options['EventDate'] = $eventDate;
				$options['EventName'] = $eventName;
			}


			// Actually add the product to the cart
//			$cartItemId = $this->api->AddItem($product_id, $qty, $variation, $configurableFields, null, $options);
			/* Baskaran */
             if(isset($_REQUEST['rdprod'])) {
                $compid = $_REQUEST['rdprod'];
            }
            else {
                $compid = -1;
            }
            
            $cartItemId = $this->api->AddItem($product_id, $qty, $variation, $configurableFields, null, $options, null, false,$compprod=$compid);
			/* Code Ends */

			$this->newCartItem = $cartItemId;

			if($cartItemId === false) {
				$this->cartErrorMessage = implode('<br />', $this->api->GetErrors());
				if(!$this->cartErrorMessage) {
					$this->cartErrorMessage = GetLang('ProductUnavailableForPruchase');
				}
				if($this->api->productLevelError == true) {
					$query = "
						SELECT prodname
						FROM [|PREFIX|]products
						WHERE productid='".(int)$product_id."'
					";
					$productName = $GLOBALS['ISC_CLASS_DB']->FetchOne($query);
					$_SESSION['ProductErrorMessage'] = $this->cartErrorMessage;
					ob_end_clean();
					header("Location: ".ProdLink($productName));
					exit;
				}
				$this->ShowRegularCart();
				return;
			}

            $this->api->ReapplyCouponsFromCart();//Added by Simha temp fix to avoid having multiple times coupon for same item
            $GLOBALS['ISC_CLASS_CART']->api->UpdateCartInformation();

			$_SESSION['JustAddedProduct'] = $product_id;

			// Are we redirecting to a specific location?
			if(isset($_REQUEST['returnUrl'])) {
				$redirectLocation = urldecode($_REQUEST['returnUrl']);
				$urlPieces = @parse_url($redirectLocation);
				$storeUrlPieces = @parse_url(GetConfig('ShopPath'));
				if(is_array($urlPieces) && isset($urlPieces['host'])) {
					$urlHost = str_replace('www.', '', isc_strtolower($urlPieces['host']));
					$storeHost = str_replace('www.', '', isc_strtolower($storeUrlPieces['host']));
					if($urlHost == $storeHost) {
						if(strpos($redirectLocation, '?') === false) {
							$redirectLocation .= '?';
						}
						else {
							$redirectLocation .= '&';
						}
						$redirectLocation .= 'justAddedProduct='.$product_id;
						ob_end_clean();
						header("Location: ".$redirectLocation);
						exit;
					}
				}
			}

			// Show the new contents of the cart
			if (GetConfig('ShowCartSuggestions')) {
				// If showing the suggestive cart, redirect them to that page
				ob_end_clean();
				header(sprintf("Location: %s/cart.php?action=suggestions&cartItem=%d", $GLOBALS['ShopPath'], $this->newCartItem));
				die();
			}
			else {
				// Redirect the user to the regular cart page
				ob_end_clean();
				header(sprintf("Location: %s/cart.php", $GLOBALS['ShopPath']));
				die();
			}
		}

		private function RemoveFromCart()
		{
			if(isset($_GET['item'])) {
				$this->api->RemoveItem($_GET['item']);
			}

			$GLOBALS['ISC_CLASS_CART']->api->UpdateCartInformation();

			ob_end_clean();
			header(sprintf("Location: %s/cart.php", $GLOBALS['ShopPath']));
			die();
		}

		private function UpdateInCart()
		{
			if(!isset($_REQUEST['qty']) || !is_array($_REQUEST['qty']) || empty($_REQUEST['qty']) || !isset($_SESSION['CART']['ITEMS'])) {
				ob_end_clean();
				header(sprintf("Location: %s/cart.php", $GLOBALS['ShopPath']));
				die();
			}

			// Just selected a shipping method - save accordingly
			if(isset($_REQUEST['selectedShippingMethod']) && isset($_SESSION['CART']['SHIPPING_QUOTES'])) {
				$shippingCost = 0;
				$handlingCost = 0;
				foreach ($_REQUEST['selectedShippingMethod'] as $vendorId => $shippingMethod) {
					// If an invalid quote was selected, skip it
					if (!isset($_SESSION['CART']['SHIPPING_QUOTES'][$vendorId][$shippingMethod])) {
						continue;
					}

					$quote = $_SESSION['CART']['SHIPPING_QUOTES'][$vendorId][$shippingMethod];
					$shippingCost += $quote['price'];
					$shippingDesc = $quote['description'];
					if(!empty($quote['handling']) && $quote['handling'] > 0) {
						$handlingCost += $quote['handling'];
					}
				}

				// Save a new cart hash
				$_SESSION['CART']['SHIPPING']['CART_HASH'] = $this->api->GenerateCartHash();

				// Save the shipping details
				$_SESSION['CART']['SHIPPING']['SHIPPING_COST'] = $shippingCost;

				if (count($_REQUEST['selectedShippingMethod']) > 1) {
					$shippingDesc = GetLang('ShippingMethodCombined');
				}
				$_SESSION['CART']['SHIPPING']['SHIPPING_PROVIDER'] = $shippingDesc;

				if($handlingCost > 0) {
					$_SESSION['CART']['SHIPPING']['HANDLING_FEE'] = $quote['handling'];
				}
				else {
					unset($_SESSION['CART']['SHIPPING']['HANDLING_FEE']);
				}
			}
			else {
				unset($_SESSION['CHECKOUT']);
			}
			foreach($_REQUEST['qty'] as $item => $qty) {
				//wirror_20110610
				$product = $this->api->GetProductInCart($item);
				if(isset($product['addon_product_id']) && $qty>10){
					$this->cartErrorMessage = "$product[product_name] is add-on product, you could add 10 at most.";
					$this->ShowRegularCart();
					die();
				}
				
				if($this->api->UpdateCartQuantity($item, $qty) === false) {
					$this->cartErrorMessage = implode('<br />', $this->api->GetErrors());
					$this->ShowRegularCart();
					die();
				}
			}

			$GLOBALS['ISC_CLASS_CART']->api->UpdateCartInformation();

			// A redirect here prevents the user from refreshing the page and breaking cart quantities
			ob_end_clean();
			header(sprintf("Location: %s/cart.php", $GLOBALS['ShopPath']));
			die();
		}

		private function ShowSuggestiveCart()
		{
			$productId = 0;
			if(isset($_REQUEST['cartItem'])) {
				$cartProduct = $this->api->GetProductInCart($_REQUEST['cartItem']);
				if(is_array($cartProduct)) {
					$this->newCartItem = $_REQUEST['cartItem'];
					$productId = $cartProduct['product_id'];
				}
			}

			if($productId == 0) {
				GetClass('ISC_404')->HandlePage();
				exit;
			}

			$query = sprintf("
				SELECT * FROM
				[|PREFIX|]products
				WHERE productid='%d'
			", $GLOBALS['ISC_CLASS_DB']->Quote($productId));

			$Result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$product = $GLOBALS['ISC_CLASS_DB']->Fetch($Result);
			$GLOBALS['Product'] = $product;

			$GLOBALS['ProductJustAdded'] = $productId;

			$this->SetCartValues();

			// Show the cart with "You May Also Like" product suggestions
			// and the actual cart on the right side of the page instead
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetPageTitle($this->GetPageTitle());
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("suggestive_cart");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}

		private function ShowRegularCart()
		{
			unset($_SESSION['IsCheckingOut']);

			// Updated the cart values
			$this->SetCartValues();

			$_SESSION['CHECKOUT'] = array();

			// Are gift certificates disabled?
			if (GetConfig('EnableGiftCertificates') == 0) {
				$GLOBALS['HidePanels'][] = "SideGiftCertificateCodeBox";
            }
            //Add by NI_20100826_Jack
	        // Are company gift certificates disabled?
            if (GetConfig('EnableCompanyGiftCertificates') == 0) {
                $GLOBALS['HidePanels'][] = "SideCompanyGiftCertificateCodeBox";
			}

			// If there wasn't a bad coupon code entered, then hide the message
			if ($this->badCouponCode) {
				$GLOBALS['BadCouponMessage'] = $this->badCouponMessage;

				if ($this->badCouponMessage == "") {
					$GLOBALS['BadCouponMessage'] = GetLang('InvalidCouponCode');
				}
			}
			else {
				$GLOBALS['HideCartBadCouponPanel'] = "none";
			}

			if (isset($_SESSION['CART']['ERROR'])) {
				$this->cartErrorMessage = $_SESSION['CART']['ERROR'];
				unset($_SESSION['CART']['ERROR']);
			}

			// Is there any sort of error message?
			if ($this->cartErrorMessage) {
				$GLOBALS['CartErrorMessage'] = $this->cartErrorMessage;
			}
			else {
				$GLOBALS['HideCartErrorMessage'] = "none";
			}

			if (isset($_SESSION['CART']['MESSAGE'])) {
				$GLOBALS['CartStatusMessage'] = $_SESSION['CART']['MESSAGE'];
				unset($_SESSION['CART']['MESSAGE']);
			}
			else {
				$GLOBALS['HideCartStatusMessage'] = "none";
			}

			// Was a coupon code applied successfully?
			if (!isset($_GET['coupon_applied'])) {
				// Nope, so hide the message
				$GLOBALS['HideCartCouponAppliedPanel'] = "none";
			}

			if ($this->api->GetNumProductsInCart() == 0) {
				$GLOBALS['HideCheckoutButton'] = "none";
			}

			// Show the regular shopping cart page
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetPageTitle($this->GetPageTitle());
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("cart");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}

		public function SetCartValues()
		{
			// Setup the default text for "subtotal" on the cart page
			$GLOBALS['CartTotalText'] = GetLang('Subtotal');
			$GLOBALS['CartSavedTotalText'] = GetLang('CartSavedTotalText');  //blessen
			$GLOBALS['AdjustedCartTotalText'] = GetLang('AdjustedSubtotal');

			// Setup the subtotal
			$GLOBALS['CartSubTotal'] = $GLOBALS['CartItemTotal'] = $this->api->GetCartSubTotal(false, null, true, true, true);
			$GLOBALS['CartSubTotalDiscount'] = $this->api->Get('SUBTOTAL_DISCOUNT');

			// Setup the pre-checkout shipping costs (if any)
			$this->SetupPreCheckoutShipping();

			// Setup the number of items to show along the "View Cart" link
			$this->SetNumItemsInCart();
		}

		public function InvalidateCartShippingCosts()
		{
			unset($_SESSION['CART']['SHIPPING']['SHIPPING_COST']);
			unset($_SESSION['CART']['SHIPPING']['SHIPPING_PROVIDER']);
			unset($_SESSION['CART']['SHIPPING']['HANDLING_FEE']);
			unset($_SESSION['CART']['SHIPPING_QUOTES']);
		}

		public function SetupPreCheckoutShipping()
		{
			$subtotal = $GLOBALS['CartSubTotal'];

			$_SESSION['CHECKOUT']['SUBTOTAL_COST'] =  $GLOBALS['CartSubTotal'];

			// Hide everything by default
			$GLOBALS['HideCartFreeShippingPanel'] = 'none';
			$GLOBALS['HideCartDiscountRulePanel'] = 'none';
			$GLOBALS['HideShoppingCartShippingCost'] = 'none';
			$GLOBALS['HideShoppingCartHandlingCost'] = 'none';
			$GLOBALS['HideShoppingCartShippingEstimator'] = 'display: none';
			$GLOBALS['HideShoppingCartImmediateDownload'] = 'none';

			// All products in the cart are digital downloads so the shipping doesn't apply
			if($this->api->AllProductsInCartAreIntangible()) {
				// Show the 'immediate download' text
				$GLOBALS['HideShoppingCartImmediateDownload'] = '';

				// If we have a handling fee set up for digital orders then we need to show it too
				if(GetConfig('DigitalOrderHandlingFee') > 0) {
					$_SESSION['CHECKOUT']['HANDLING_COST'] = GetConfig('DigitalOrderHandlingFee');
					$GLOBALS['HandlingCost'] = CurrencyConvertFormatPrice(GetConfig('DigitalOrderHandlingFee'));
					$GLOBALS['CartSubTotal'] += GetConfig('DigitalOrderHandlingFee');
					$GLOBALS['HideShoppingCartHandlingCost'] = '';
				}
				return;
			}

			$freeShippingQualified = false;
			$cartProducts = $this->api->GetProductsInCart();
			$freeShippingProductCount = 0;
			foreach($cartProducts as $product) {
				if ($product['data']['prodtype'] == PT_PHYSICAL && $product['data']['prodfreeshipping'] == 1) {
					++$freeShippingProductCount;
				}
			}

			$discountMessages = $this->api->Get('DISCOUNT_MESSAGES');

			if (!is_array($discountMessages)) {
				$discountMessages = array();
			}
			
			// 2011-06-30 johnny remove the same value in array 
			$discountMessages = array_unique($discountMessages);
			
			$GLOBALS['CartRuleMessage'] = '';

			foreach ($discountMessages as $message) {
				$GLOBALS['CartRuleMessage'] .= '<p class="InfoMessage">' . GetLang('DiscountCongratulations') . ' ';
				$GLOBALS['CartRuleMessage'] .= $message;
				$GLOBALS['CartRuleMessage'] .= '</p>';
			}

			// If all of the products in the cart have free shipping, then we automatically qualify
			if($freeShippingProductCount == count($cartProducts) || $this->api->GetCartFreeShipping()) {
				$GLOBALS['ShippingCost'] = GetLang('Free');
				$freeShippingQualified = true;
				$GLOBALS['HideCartFreeShippingPanel'] = "";
				$GLOBALS['FreeShippingMessage'] = GetLang('OrderQualifiesForFreeShipping');
				return;
			}

			// Show the estimation box
			$GLOBALS['HideShoppingCartShippingEstimator'] = '';

			// If we have a shipping zone already stored, we can show a little more
			if(isset($_SESSION['CART']['SHIPPING']['ZONE'])) {

				$zone = GetShippingZoneById($_SESSION['CART']['SHIPPING']['ZONE']);
				// The zone no longer exists
				if(!isset($zone['zoneid'])) {
					unset($_SESSION['CART']['SHIPPING']);
					return;
				}

				// If the contents of the cart have changed since their last known values (based off a unique hash of the cart contents)
				// then invalidate the shipping costs
				if(isset($_SESSION['CART']['SHIPPING']['CART_HASH']) && $this->api->GenerateCartHash() != $_SESSION['CART']['SHIPPING']['CART_HASH']) {
					// Remove any existing shipping costs
					$this->InvalidateCartShippingCosts();
				}

				// If we have a shipping cost saved, store it too
				if(isset($_SESSION['CART']['SHIPPING']['SHIPPING_COST'])) {
					$GLOBALS['HideShoppingCartShippingCost'] = '';
					if($_SESSION['CART']['SHIPPING']['SHIPPING_COST'] == 0) {
						$GLOBALS['ShippingCost'] = GetLang('Free');
					}
					else {
						$GLOBALS['ShippingCost'] = CurrencyConvertFormatPrice($_SESSION['CART']['SHIPPING']['SHIPPING_COST']);
						$subtotal += $_SESSION['CART']['SHIPPING']['SHIPPING_COST'];
						$GLOBALS['ShippingProvider'] = isc_html_escape($_SESSION['CART']['SHIPPING']['SHIPPING_PROVIDER']);
					}
				}

				// If there is a handling fee, we need to show it too
				if(isset($_SESSION['CART']['SHIPPING']['HANDLING_FEE']) && $_SESSION['CART']['SHIPPING']['HANDLING_FEE'] > 0) {
					$GLOBALS['HideShoppingCartHandlingCost'] = '';
					$GLOBALS['HandlingCost'] = CurrencyConvertFormatPrice($_SESSION['CART']['SHIPPING']['HANDLING_FEE']);
					$subtotal += $_SESSION['CART']['SHIPPING']['HANDLING_FEE'];
				}

				// This zone has free shipping set up. Do we qualify?
				if($zone['zonefreeshipping'] == 1) {
					$GLOBALS['HideCartFreeShippingPanel'] = "";

					// We don't have enough to qualify - but still show the "spend x more for free shipping" message
					if ($GLOBALS['CartSubTotal'] < $zone['zonefreeshippingtotal']) {
						$diff = CurrencyConvertFormatPrice($zone['zonefreeshippingtotal'] - $GLOBALS['CartSubTotal']);

						if ($zone['zonehandlingfee'] > 0 && !$zone['zonehandlingseparate']) {
							$GLOBALS['FreeShippingMessage'] = sprintf(GetLang('SpendXMoreXShipping'), $diff, CurrencyConvertFormatPrice($zone['zonehandlingfee']));
						}
						else {
							$GLOBALS['FreeShippingMessage'] = sprintf(GetLang('SpendXMoreFreeShipping'), $diff);
						}
					}
					// Otherwise we qualify for free shipping
					else {
						// Setup the shipping message - if a handling fee is to be applied, then they actually qualify for $X shipping, not free shipping
						if ($zone['zonehandlingfee'] > 0 && !$zone['zonehandlingseparate']) {
							$GLOBALS['FreeShippingMessage'] = sprintf(GetLang('OrderQualifiesForXShipping'), CurrencyConvertFormatPrice($zone['zonehandlingfee']));
						}
						else {
							$GLOBALS['FreeShippingMessage'] = GetLang('OrderQualifiesForFreeShipping');
						}
					}
				}
			}

			$selectedCountry = GetCountryIdByName(GetConfig('CompanyCountry'));
			$selectedState = 0;
			$selectedStateName = '';
			$zipCode = '';

			// Retain the country, stae and zip code selections if we have them
			if(isset($_SESSION['CART']['SHIPPING']['COUNTRY_ID'])) {
				$selectedCountry = (int)$_SESSION['CART']['SHIPPING']['COUNTRY_ID'];

				if(isset($_SESSION['CART']['SHIPPING']['STATE_ID'])) {
					$selectedState = (int)$_SESSION['CART']['SHIPPING']['STATE_ID'];
				}

				if(isset($_SESSION['CART']['SHIPPING']['STATE'])) {
					$selectedStateName = $_SESSION['CART']['SHIPPING']['STATE'];
				}

				if(isset($_SESSION['CART']['SHIPPING']['ZIP_CODE'])) {
					$GLOBALS['ShippingZip'] = isc_html_escape($_SESSION['CART']['SHIPPING']['ZIP_CODE']);
				}
			}

			$GLOBALS['ShippingCountryList'] = GetCountryList($selectedCountry);
			$GLOBALS['ShippingStateList'] = GetStateListAsOptions($selectedCountry, $selectedState);
			$GLOBALS['ShippingStateName'] = isc_html_escape($selectedStateName);

			// If there are no states for the country then hide the dropdown and show the textbox instead
			if (GetNumStatesInCountry($selectedCountry) == 0) {
				$GLOBALS['ShippingHideStateList'] = "none";
			}
			else {
				$GLOBALS['ShippingHideStateBox'] = "none";
			}
			$GLOBALS['CartSubTotal'] = $subtotal;
		}

		private function GetPageTitle()
		{
			return $this->pageTitle;
		}

    	public function ApplyCompanyGiftCertificate()
        {
            if(!isset($_REQUEST['companygiftcertificatecode'])) {
                ob_end_clean();
                header(sprintf("Location:%s/cart.php", $GLOBALS['ShopPath']));
                die();
            }
            if($this->api->ApplyCompanyGiftCertificate($_REQUEST['companygiftcertificatecode'])) {
                // If successful, throw the user back to their cart
                $_SESSION['CART']['MESSAGE'] = GetLang('CompanyGiftCertificateAppliedToCart');
            }
            else {
                $_SESSION['CART']['ERROR'] = implode('<br />', $this->api->GetErrors());
            }
            ob_end_clean();
            header(sprintf("Location:%s/cart.php", $GLOBALS['ShopPath']));
            die();
        }
		public function ApplyGiftCertificate()
		{
			if(!isset($_REQUEST['giftcertificatecode'])) {
				ob_end_clean();
				header(sprintf("Location:%s/cart.php", $GLOBALS['ShopPath']));
				die();
			}

			if($this->api->ApplyGiftCertificate($_REQUEST['giftcertificatecode'])) {
				// If successful, throw the user back to their cart
				$_SESSION['CART']['MESSAGE'] = GetLang('GiftCertificateAppliedToCart');
			}
			else {
				$_SESSION['CART']['ERROR'] = implode('<br />', $this->api->GetErrors());
			}
			ob_end_clean();
			header(sprintf("Location:%s/cart.php", $GLOBALS['ShopPath']));
			die();
		}

		private function RemoveGiftCertificate()
		{
			if(isset($_REQUEST['giftcertificateid'])) {
				$this->api->RemoveAppliedGiftCertificate($_REQUEST['giftcertificateid']);
			}

			// Throw the user back to their cart
			$_SESSION['CART']['MESSAGE'] = sprintf(GetLang('GiftCertificateRemovedFromCart'));

			ob_end_clean();
			header(sprintf("Location:%s/cart.php", $GLOBALS['ShopPath']));
			die();
		}

        // Add by NI_20100826_Jack
        private function RemoveCompanyGiftCertificate()
        {
            if(isset($_REQUEST['companygiftcertificateid'])) {
                $this->api->RemoveAppliedCompanyGiftCertificate($_REQUEST['companygiftcertificateid']);
            }
            // Throw the user back to their cart
            $_SESSION['CART']['MESSAGE'] = sprintf(GetLang('CompanyGiftCertificateRemovedFromCart'));
            ob_end_clean();
            header(sprintf("Location:%s/cart.php", $GLOBALS['ShopPath']));
            die();
        }
		private function ApplyOff()		
		{
				if($this->api->ApplyCoupon($_POST['couponcode'],$go)) {
					// Coupon code applied successfully
									$this->api->ApplyCoupon($_POST['couponcode'],$go);//Added by Simha temp fix to avoid having multiple times coupon for same item
					$GLOBALS['ISC_CLASS_CART']->api->UpdateCartInformation();   
					ob_end_clean();
					header(sprintf("Location:%s/cart.php?coupon_applied=true", $GLOBALS['ShopPath']));
					die();
				}else if($this->api->ApplyGiftCertificate($_POST['couponcode'])) {
					// If successful, throw the user back to their cart
					$_SESSION['CART']['MESSAGE'] = GetLang('GiftCertificateAppliedToCart');
					
				}else if($this->api->ApplyCompanyGiftCertificate($_POST['couponcode'])) {
          // If successful, throw the user back to their cart
					$_SESSION['CART']['MESSAGE'] = GetLang('CompanyGiftCertificateAppliedToCart');
				}
				ob_end_clean();
				header(sprintf("Location:%s/cart.php", $GLOBALS['ShopPath']));
				die();
		}
		private function ApplyCoupon()
		{
			if(!isset($_POST['couponcode'])) {
				$this->ShowRegularCart();
				return;
			}

			$go = 1; # $go assigned for to know the coupon code is coming from text box -- Baskaran            
			if($this->api->ApplyCoupon($_POST['couponcode'],$go)) {
				// Coupon code applied successfully
                $this->api->ApplyCoupon($_POST['couponcode'],$go);//Added by Simha temp fix to avoid having multiple times coupon for same item
				$GLOBALS['ISC_CLASS_CART']->api->UpdateCartInformation();   
				ob_end_clean();
				header(sprintf("Location:%s/cart.php?coupon_applied=true", $GLOBALS['ShopPath']));
				die();
			}
			else {
				$this->badCouponMessage = implode('<br />', $this->api->GetErrors());
				$this->badCouponCode = true;
				$this->ShowRegularCart();
			}
		}

		private function RemoveCoupon()
		{
			if (isset($_REQUEST['couponid'])) {
				$this->api->RemoveCouponCode($_REQUEST['couponid']);
				$GLOBALS['ISC_CLASS_CART']->api->UpdateCartInformation();

				// Throw the user back to their cart
				$_SESSION['CART']['MESSAGE'] = GetLang('CouponRemovedFromCart');
			}

			ob_end_clean();
			header(sprintf("Location:%s/cart.php", $GLOBALS['ShopPath']));
			die();
		}

		/**
		 * Calculate the shipping cost for an array of products in the cart to the specified address.
		 *
		 * @param array The shipping address (shipcountryid, shipstateid, shipzip) to fetch the available methods/quotes for.
		 * @param array Array containing the product information (generally from self::api::GetProductsInCart)
		 * @param int The vendor ID that the shipping zone should be fetched from.
		 * @return array An array of calculated shipping quotes.
		 */
		public function GetAvailableShippingMethodsForProducts($address, $products, $vendorId=0)
		{
			if(!is_array($address) || !is_array($products)) {
				return false;
			}

			// Fetch the shipping zone that this address belongs in
			$shippingZone = GetShippingZoneIdByAddress($address, $vendorId);
			$zone = GetShippingZoneById($shippingZone);

			$shippingQuotes = array();
			$shippableTotal = 0;
			$subTotal = 0;
			$fixedShippingCost = 0;
			$fixedShippingProducts = 0;
			$shippingQuoteProducts = array();
			$includesDigitalProducts = false;

			// Loop through the products and build an array of those that we can ship
			// also save the sub total so we can pass it to the shipping providers
			foreach($products as $k => $product) {
				// Skip over any invalid products
				if (!isset($product['data'])) {
					continue;
				}
				
				// Wirror_20110527: skip add-on product
				if(isset($product['addon_product_id'])){
					continue;
				}

				$quantity = (int)$product['quantity'];

				// Determine the actual price of the product that this customer is paying
				if (isset($product['discount_price'])) {
					$price = $product['discount_price'];
				}
				else if (isset($product['type']) && $product['type'] == "giftcertificate") {
					$price = $product['giftamount'];
				}
				else {
					$price = $product['original_price'];
				}
				if(isset($product['wrapping']['wrapprice'])) {
					$price += $product['wrapping']['wrapprice'];
				}
                
                $comptotal = 0;
                if($product['compitem'] == 1) {
                    for($x=0; $x<count($product['complementary']); $x++)   {
                        $comptotal += $product['complementary'][$x]['comp_original_price'] * $product['complementary'][$x]['quantity']; # Baskaran
                    }
                }
                
				$subTotal += ($quantity * $price) + $comptotal;
                
				if($product['data']['prodtype'] == PT_PHYSICAL && $product['data']['prodfixedshippingcost'] == 0) {
					$shippableTotal += ($quantity * $price) + $comptotal;
				}

				if ($product['data']['prodtype'] == PT_PHYSICAL && (!isset($product['data']['prodfreeshipping']) || $product['data']['prodfreeshipping'] != 1)) {
					if ($product['data']['prodfixedshippingcost'] > 0) {
						$fixedShippingCost += $product['data']['prodfixedshippingcost'] * $quantity;
						++$fixedShippingProducts;
					}
					else {
						$shippingQuoteProducts[$k] = $k;
					}
				}
				else if($product['data']['prodtype'] == PT_DIGITAL) {
					$includesDigitalProducts = true;
				}
			}

			// Now that we have all of the information we need, we can start calculating
			// shipping

			$zoneHandlingFee = 0;
			if($zone['zonehandlingtype'] == 'global' && $zone['zonehandlingseparate']) {
				$zoneHandlingFee = $zone['zonehandlingfee'];
				if($includesDigitalProducts) {
					$zoneHandlingFee += GetConfig('DigitalOrderHandlingFee');
				}
			}

			// Free shipping
			if(($zone['zonefreeshipping'] == 1 && $subTotal >= $zone['zonefreeshippingtotal']) || $this->api->GetCartFreeShipping(true)) {
				$adjustedPrice = $this->FactorInZoneHandling($shippingZone, 0, 0, $includesDigitalProducts);
				if($adjustedPrice > 0) {
					$freeShippingName = GetConfig('StoreName');
				}
				else {
					$freeShippingName = GetLang('FreeShipping');
				}
				$shippingQuotes[] = array(
					'description' => $freeShippingName,
					'price' => $adjustedPrice,
					'methodId' => -1,
					'module' => '',
					'handling' => $zoneHandlingFee
				);
			}

			// All products in the cart have a fixed shipping cost, just return that
			if($fixedShippingProducts == count($products) || empty($shippingQuoteProducts)) {
				$adjustedPrice = $this->FactorInZoneHandling($shippingZone, $fixedShippingCost, 0, $includesDigitalProducts);
				if($adjustedPrice > 0) {
					$shippingName = GetConfig('StoreName');
				}
				else {
					$shippingName = GetLang('FreeShipping');
				}
				$shippingQuotes = array();
				$shippingQuotes[] = array(
					'description' => $shippingName,
					'price' => $adjustedPrice,
					'methodId' => -1,
					'module' => '',
					'handling' => $zoneHandlingFee,
					'from' => 1,
				);
				print_r($shippingQuotes);
				return $shippingQuotes;
			}

			// Get any shipping methods available for this module
			$query = "
				SELECT *
				FROM [|PREFIX|]shipping_methods
				WHERE zoneid='".(int)$shippingZone."' AND methodenabled='1' AND methodvendorid='".(int)$zone['zonevendorid']."'
			";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			while($method = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				if($zone['zonehandlingtype'] == 'module' && $zone['zonehandlingseparate']) {
					$methodHandling = $method['methodhandlingfee'];
					if($includesDigitalProducts) {
						$methodHandling += GetConfig('DigitalOrderHandlingFee');
					}
				}
				else {
					$methodHandling = $zoneHandlingFee;
				}

				// Set up the shipping module behind this method
				$shippingModule = null;
				GetModuleById('shipping', $shippingModule, $method['methodmodule']);

				if(!is_object($shippingModule)) {
					continue;
				}

				$shippingModule->SetMethodId($method['methodid']);

				// Add each item to the shipping quote
				foreach($shippingQuoteProducts as $productId) {
					$cartProduct = $products[$productId];
					if (!isset($cartProduct['data'])) {
						continue;
					}
					$shippingModule->AddItem($cartProduct['data']['prodweight'],
						$cartProduct['data']['proddepth'],
						$cartProduct['data']['prodwidth'],
						$cartProduct['data']['prodheight'],
						$cartProduct['quantity'],
						$cartProduct['data']['prodname']
					);
				}

				// Set the destination settings
				$shippingModule->SetDestinationCountry($address['shipcountryid']);
				if(!isset($address['shipstate'])) {
					$address['shipstate'] = GetStateById($address['shipstateid']);
				}
				$shippingModule->SetDestinationState($address['shipstate']);
				$shippingModule->SetDestinationZip($address['shipzip']);
				$shippingModule->SetDestinationType("RES");

				// Set the subtotal
				$shippingModule->SetSubTotal($shippableTotal);

				// Get the available services for this shipping method
				$moduleQuotes = array();
				if(method_exists($shippingModule, 'GetServiceQuotes')) {
					$methodQuotes = $shippingModule->GetServiceQuotes();
					// Can't ship by this method - nothing was returned
					if($methodQuotes === false) {
						continue;
					}
					if(!is_array($methodQuotes)) {
						$methodQuotes = array($methodQuotes);
					}
					// For each of the returned quotes, add them to the quote stack
					foreach($methodQuotes as $quote) {
						if(!is_object($quote)) {
							$quote = $quote[0];
						}

						$shippingQuotes[] = array(
							'description' => $quote->GetDesc(true),
							'price' => $this->FactorInZoneHandling($zone['zoneid'], $quote->GetPrice()+$fixedShippingCost, $method['methodhandlingfee'], $includesDigitalProducts),
							'handling' => $methodHandling,
							'module' => $method['methodmodule'],
							'methodId' => $method['methodid'],
                            'display_message' => $method['display_message'],
						);
						print_r($shippingQuotes);

						// Get the transit time
						if($quote->GetTransit() != '' && $quote->GetTransit() != -1) {
							$shippingQuotes[count($shippingQuotes)-1]['transit'] = $quote->GetTransit();
						}
					}

				}
				// Flat rate modules - simply call GetQuote
				else {
					$err = '';
					$quote = $shippingModule->GetQuote($err);
					if($quote !== false) {
						$shippingQuotes[] = array(
							'description' => $method['methodname'],
							'price' => $this->FactorInZoneHandling($shippingZone, $quote->GetPrice()+$fixedShippingCost, $method['methodhandlingfee'], $includesDigitalProducts),
							'handling' => $methodHandling,
							'module' => $method['methodmodule'],
							'methodId' => $method['methodid'],
                            'display_message' => $method['display_message'],
                            'lower' => $quote->getLower(),
                            'upper' => $quote->getUpper()
						);
					}
				}
			}

			// Order the shipping quotes from least expensive to most expensiv
			uasort($shippingQuotes, array($this, 'SortShippingQuotes'));

			// Now return what we've got
			return $shippingQuotes;
		}

		/**
		 * User defined comparison function for sorting shipping quotes from
		 * least expensive to most expensive.
		 *
		 * @param array The first field to compare
		 * @param array The second field to compare
		 * @return int The sorting position for the two compared shipping quotes.
		 */
		private function SortShippingQuotes($a, $b)
		{
			if($a['price'] == $b['price']) {
				return 0;
			}
			else if($a['price'] < $b['price']) {
				return -1;
			}
			else {
				return 1;
			}
		}


		/**
		 * Get the available shipping methods for the customers cart to the specified address.
		 *
		 * @param array The shipping address (shipcountryid, shipstateid, shipzip) to fetch the available methods/quotes for.
		 * @return array An array of the returned shipping quotes.
		 */
		public function GetAvailableShippingMethods($address)
		{
			$shippingQuotes = array();

			$cartProducts = $this->api->GetProductsInCartByVendorforshipping();

			// Grab a list of all of the vendors that the products belong to
			$vendorIds = $this->api->GetCartVendorIds();
			$temp_vendor_id = $vendorIds[0];
			for($i=0;$i<count($vendorIds);$i++)
			{
				$vendorIds[$i] = $temp_vendor_id;
			}

			foreach($vendorIds as $vendorId) {
				// Get the products in the cart
				$products = $cartProducts[$vendorId];
				$shippingQuotes[$vendorId] = $this->GetAvailableShippingMethodsForProducts($address, $products, $vendorId);
			}

			return $shippingQuotes;
		}

		/**
		 * Factor in the handling fee for a shipping quote in a particular shipping zone.
		 *
		 * @param int The ID of the shipping zone this quote comes from.
		 * @param float The base shipping price to have handling factored in to.
		 * @param float The handling fee for this shipping method.
		 * @param boolean Set to true if this order contains digital items and we need to add on the digital handing
		 * @return float The adjusted price with handling factored in.
		 */
		public function FactorInZoneHandling($zoneId, $price, $methodHandling, $includeDigitalHandling=false)
		{
			$zone = GetShippingZoneById($zoneId);

			if(!is_array($zone)) {
				return $price;
			}
			else if($zone['zonehandlingseparate'] == 1) {
				return $price;
			}

			$digitalHandling = 0;
			if($includeDigitalHandling == true && GetConfig('DigitalOrderHandlingFee')) {
				$digitalHandling = GetConfig('DigitalOrderHandlingFee');
			}

			if($zone['zonehandlingtype'] == 'module') {
				return $price + $methodHandling + $digitalHandling;
			}
			else if($zone['zonehandlingtype'] == 'global') {
				return $price + $zone['zonehandlingfee'] + $digitalHandling;
			}
			else {
				return $price + $digitalHandling;
			}
		}

		private function ValidateReorder()
		{
			//check if the user is allowed to re-order the items
			if (isset($_REQUEST['orderid'])) {
				//check if customer is logged in
				$GLOBALS['ISC_CLASS_CUSTOMER'] = GetClass('ISC_CUSTOMER');
				$CustId = $GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerId();
				if (!$CustId) {
					$_SESSION['CART']['ERROR'] = GetLang('MustBeLoggedInToReorder');
					$this->ShowRegularCart();
					exit;
				}

				//check if the order was placed by the same customer
				$query = "Select ordcustid
							From [|PREFIX|]orders
							Where orderid = ".(int)$_REQUEST['orderid'];
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

				$OrdCustId = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);
				if($OrdCustId != $CustId) {
					$_SESSION['CART']['ERROR'] = GetLang('OrderWasntPlacedByYou');
					$this->ShowRegularCart();
					exit;
				}

			// if order Id is not specified
			} else {
				$_SESSION['CART']['ERROR'] = GetLang('InvalidOrderId');
				$this->ShowRegularCart();
				exit;
			}
		}


		private function AddReorderItems()
		{

			$this->ValidateReorder();

			if (isset($_REQUEST['reorderitem'])) {
				$OrdProdIds = implode(',', array_keys($_REQUEST['reorderitem']));
				$QueryWhere = "op.orderprodid IN (".$GLOBALS['ISC_CLASS_DB']->Quote($OrdProdIds).")";
			} else if (isset($_REQUEST['orderid'])) {
				$QueryWhere = "op.orderorderid = ".(int)$_REQUEST['orderid'];
			}


			$OrderItems = array();

			$query = "Select op.orderprodid, op.ordprodid, op.ordprodqty, op.ordprodvariationid, op.ordprodeventdate, op.ordprodeventname, op.ordprodwrapid,op.ordprodwrapmessage, ocf.textcontents, ocf.fieldid, ocf.filename, ocf.filetype, ocf.originalfilename, ocf.fieldname, ocf.fieldtype
						From [|PREFIX|]order_products op
						Left Join [|PREFIX|]order_configurable_fields ocf
						On op.orderprodid = ocf.ordprodid
						Where ".$QueryWhere;
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {

				if(!isset($OrderItems[$row['orderprodid']])) {
					$OrderItems[$row['orderprodid']] = array(
						'ProductId' => $row['ordprodid'],
						'Qty' => $row['ordprodqty'],
						'VariationId' => $row['ordprodvariationid'],
						'EventName' => $row['ordprodeventname'],
						'EventDate' => $row['ordprodeventdate'],
						'WrapId' => array('all'=>$row['ordprodwrapid']),
						'WrapMessage' => array('all'=>$row['ordprodwrapmessage'])
					);
				}


				//when product doesn't have any configuable options
				if(!isset($row['fieldid'])) {
					$OrderItems[$row['orderprodid']]['ConfigFields'] = array();
					continue;
				}

				// set up product configuable options
				$configFields = array();
				switch ($row['fieldtype']) {
					case "file": {
						$filePath = ISC_BASE_PATH.'/'.GetConfig('ImageDirectory').'/configured_products/'.$row['filename'];
						$fileTmpPath = ISC_BASE_PATH.'/'.GetConfig('ImageDirectory').'/configured_products_tmp/'.$row['filename'];

						//move configurable field files to the temp folder
						if(!@copy($filePath, $fileTmpPath)) {
							$this->cartErrorMessage = GetLang('ConfigurableFileCantBeMoved');
							$this->ShowRegularCart();
							return;
						}

 						$configFields = array(
							'fieldType' => $row['fieldtype'],
							'fieldName' => $row['fieldname'],
							'fileType' =>  $row['filetype'],
							'fileOriginName' => $row['originalfilename'],
							'fileName' => $row['filename']
						);
						break;
					}
					default:{
							$configFields = array(
								'fieldType' => $row['fieldtype'],
								'fieldName' => $row['fieldname'],
								'fieldValue' => $row['textcontents']
							);
					}
				}
				$OrderItems[$row['orderprodid']]['ConfigFields'][$row['fieldid']] = $configFields;
			}

			foreach($OrderItems as $OrdProdId => $item) {
				$options = array();
				if($item['EventName'] != '' &&  $item['EventDate'] != '') {
					$options = array(
						'EventName' =>  $item['EventName'],
						'EventDate' =>  $item['EventDate']
					);
				}

				// Actually add the product to the cart
				$cartItemId = $this->api->AddItem($item['ProductId'], $item['Qty'], $item['VariationId'], $item['ConfigFields'], null, $options, null, true);
				$this->newCartItem = $cartItemId;

				if(!$this->api->ApplyGiftWrapping($cartItemId, 'same', $item['WrapId'], $item['WrapMessage'])) {
					$_SESSION['CART']['ERROR'] = implode('<br />', $this->api->GetErrors());
					$this->ShowRegularCart();
					exit;
				}

				if($cartItemId === false) {
					$this->cartErrorMessage = implode('<br />', $this->api->GetErrors());
					if(!$this->cartErrorMessage) {
						$this->cartErrorMessage = GetLang('ProductUnavailableForPruchase');
					}
					if($this->api->productLevelError == true) {
						$query = "
							SELECT prodname
							FROM [|PREFIX|]products
							WHERE productid='".(int)$product_id."'
						";
						$productName = $GLOBALS['ISC_CLASS_DB']->FetchOne($query);
						$_SESSION['ProductErrorMessage'] = $this->cartErrorMessage;
						ob_end_clean();
						header("Location: ".ProdLink($productName));
						exit;
					}
					$this->ShowRegularCart();
					return;
				}
			}
            
			ob_end_clean();
			header(sprintf("Location: %s/cart.php", $GLOBALS['ShopPath']));
			die();
	 	}
	}

?>
