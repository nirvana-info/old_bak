<?php
date_default_timezone_set('America/Chicago');
//ini_set("display_errors", 0);
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set("max_execution_time", 0);
//echo ini_get("max_execution_time"); 
set_time_limit(0); 
define("FT_INSIMAGE", 1003); 
define("FT_VIDEO", 1004); 
define("FT_INSVIDEO", 1005); 

class ISC_ADMIN_PRODUCT
	{
		public $_customSearch = array();

		/**
		 * The constructor.
		 */
		public function __construct()
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('products');

			// Initialise custom searches functionality
			require_once(dirname(__FILE__).'/class.customsearch.php');
			$GLOBALS['ISC_CLASS_ADMIN_CUSTOMSEARCH'] = new ISC_ADMIN_CUSTOMSEARCH('products');
			$GLOBALS['WeightMeasurement'] = GetConfig('WeightMeasurement');
			$GLOBALS['LengthMeasurement'] = GetConfig('LengthMeasurement');

		}

		public function HandleToDo($Do)
		{
			switch (isc_strtolower($Do)) {
				case "deleteproductvariations":
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Variations)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Products') => "index.php?ToDo=viewProducts", GetLang("ProductVariations") => "index.php?ToDo=viewProductVariations", GetLang('DeleteProductVariation') => "index.php?ToDo=deleteProductVariation");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->DeleteVariations();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				case "editproductvariation2":
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Variations)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Products') => "index.php?ToDo=viewProducts", GetLang("ProductVariations") => "index.php?ToDo=viewProductVariations", GetLang('EditProductVariation') => "index.php?ToDo=editProductVariation");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->EditVariationStep2();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				case "editproductvariation":
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Variations)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Products') => "index.php?ToDo=viewProducts", GetLang("ProductVariations") => "index.php?ToDo=viewProductVariations", GetLang('EditProductVariation') => "index.php?ToDo=editProductVariation");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->EditVariationStep1();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				case "addproductvariation2":
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Variations)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Products') => "index.php?ToDo=viewProducts", GetLang("ProductVariations") => "index.php?ToDo=viewProductVariations", GetLang('AddProductVariation') => "index.php?ToDo=addProductVariation");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->AddVariationStep2();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				case "addproductvariationoption":
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Variations)) {
						$this->AddVariationOptionStep1();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				case "addproductvariation":
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Variations)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Products') => "index.php?ToDo=viewProducts", GetLang("ProductVariations") => "index.php?ToDo=viewProductVariations", GetLang('AddProductVariation') => "index.php?ToDo=addProductVariation");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->AddVariationStep1();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				case "viewproductvariations":
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Variations)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Products') => "index.php?ToDo=viewProducts", GetLang('ProductVariations') => "index.php?ToDo=viewProductVariations");

						if(!isset($_REQUEST['ajax'])) {
							$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						}

						$this->ViewVariations();

						if(!isset($_REQUEST['ajax'])) {
							$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						}

						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				case "savebulkeditproducts":
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Products) && gzte11(ISC_LARGEPRINT)) {

						if(isset($_POST['addanother'])) {
							$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Products') => "index.php?ToDo=viewProducts", GetLang('EditProduct') => "index.php?ToDo=editProduct");
						}
						else {
							$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Products') => "index.php?ToDo=viewProducts");
							if (GetSession('productsearch') > 0) {
								if (!isset($_GET['searchId'])) {
									$_GET['searchId'] = GetSession('productsearch');
									$_REQUEST['searchId'] = GetSession('productsearch');
								}

								if ($_GET['searchId'] > 0) {
									$GLOBALS['BreadcrumEntries'] = array_merge($GLOBALS['BreadcrumEntries'], array(GetLang('CustomView') => "index.php?ToDo=customProductSearch"));
								}
							}
						}

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->BulkEditProductsStep2();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				case "bulkeditproducts":
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Products) && gzte11(ISC_LARGEPRINT)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Products') => "index.php?ToDo=viewProducts", GetLang('BulkEditProducts1') => "index.php?ToDo=bulkEditProducts");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->BulkEditProductsStep1();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				case "createproductview":
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Products)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Products') => "index.php?ToDo=viewProducts", GetLang('CreateProductView') => "index.php?ToDo=createProductView");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->CreateView();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				case "importproducts":
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Import_Products)) {
						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Products') => "index.php?ToDo=viewProducts", GetLang('ImportProducts') => "index.php?ToDo=importProducts");
						$this->ImportProducts();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				case "editproduct2":
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Products)) {

						if(isset($_POST['addanother'])) {
							$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Products') => "index.php?ToDo=viewProducts", GetLang('EditProduct') => "index.php?ToDo=editProduct");
						}
						else {
							$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Products') => "index.php?ToDo=viewProducts");
							if (GetSession('productsearch') > 0) {
								if (!isset($_GET['searchId'])) {
									$_GET['searchId'] = GetSession('productsearch');
									$_REQUEST['searchId'] = GetSession('productsearch');
								}

								if ($_GET['searchId'] > 0) {
									$GLOBALS['BreadcrumEntries'] = array_merge($GLOBALS['BreadcrumEntries'], array(GetLang('CustomView') => "index.php?ToDo=customProductSearch"));
								}
							}
						}

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->EditProductStep2();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				case "editproduct":
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Products)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Products') => "index.php?ToDo=viewProducts", GetLang('EditProduct') => "index.php?ToDo=editProduct");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->EditProductStep1();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				case "editproductvisibility":
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Products)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Products') => "index.php?ToDo=viewProducts");

						if(!isset($_REQUEST['ajax'])) {
							$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						}

						$this->EditVisibility();

						if(!isset($_REQUEST['ajax'])) {
							$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						}

						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				case "editproductfeatured":
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Products)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Products') => "index.php?ToDo=viewProducts");

						if(!isset($_REQUEST['ajax'])) {
							$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						}

						$this->EditFeatured();

						if(!isset($_REQUEST['ajax'])) {
							$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						}

						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				case "deleteproducts":
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Delete_Products)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Products') => "index.php?ToDo=viewProducts");
						if (GetSession('productsearch') > 0) {
							if (!isset($_GET['searchId'])) {
								$_GET['searchId'] = GetSession('productsearch');
								$_REQUEST['searchId'] = GetSession('productsearch');
							}

							if ($_GET['searchId'] > 0) {
								$GLOBALS['BreadcrumEntries'] = array_merge($GLOBALS['BreadcrumEntries'], array(GetLang('CustomView') => "index.php?ToDo=customProductSearch"));
							}
						}

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->DeleteProducts();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				case "addproduct2":
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Create_Product)) {

						if(isset($_POST['addanother'])) {
							$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Products') => "index.php?ToDo=viewProducts", GetLang('AddProduct') => "index.php?ToDo=addProduct");
						}
						else {
							$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Products') => "index.php?ToDo=viewProducts");
							if (GetSession('productsearch') > 0) {
								if (!isset($_GET['searchId'])) {
									$_GET['searchId'] = GetSession('productsearch');
									$_REQUEST['searchId'] = GetSession('productsearch');
								}

								if ($_GET['searchId'] > 0) {
									$GLOBALS['BreadcrumEntries'] = array_merge($GLOBALS['BreadcrumEntries'], array(GetLang('CustomView') => "index.php?ToDo=customProductSearch"));
								}
							}
						}

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->AddProductStep2();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				case "addproduct":
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Create_Product)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Products') => "index.php?ToDo=viewProducts", GetLang('AddProduct') => "index.php?ToDo=addProduct");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->AddProductStep1();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				case "deletecustomproductsearch":
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Products)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Products') => "index.php?ToDo=viewProducts");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->DeleteCustomSearch();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				case "customproductsearch":
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Products)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Products') => "index.php?ToDo=viewProducts", GetLang('CustomView') => "index.php?ToDo=customProductSearch");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->CustomSearch();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				case "searchproductsredirect":
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Products)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Products') => "index.php?ToDo=viewProducts", GetLang('SearchResults') => "index.php?ToDo=searchProducts");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->SearchProductsRedirect();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				case "searchproducts":
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Products)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Products') => "index.php?ToDo=viewProducts", GetLang('SearchProducts') => "index.php?ToDo=searchProducts");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->SearchProducts();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				case "popupproductselect":
					$this->PopupProductSelect();
					break;
                    case "deleteproductsearchresults":                
                    if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Delete_Products)) {

                        $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Products') => "index.php?ToDo=viewProducts");
                        if (GetSession('productsearch') > 0) {
                            if (!isset($_GET['searchId'])) {
                                $_GET['searchId'] = GetSession('productsearch');
                                $_REQUEST['searchId'] = GetSession('productsearch');
                            }

                            if ($_GET['searchId'] > 0) {
                                $GLOBALS['BreadcrumEntries'] = array_merge($GLOBALS['BreadcrumEntries'], array(GetLang('CustomView') => "index.php?ToDo=customProductSearch"));
                            }
                        }

                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();  
                        $this->DeleteSearchResults();
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        die();
                    } else {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
                    }
                    break;
				case "copyproduct":
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Create_Product)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Products') => "index.php?ToDo=viewProducts", GetLang('CopyProduct') => "index.php?ToDo=copyProduct");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->CopyProductStep1();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				case "copyproduct2":
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Create_Product)) {

						if(isset($_POST['addanother'])) {
							$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Products') => "index.php?ToDo=viewProducts", GetLang('CopyProduct') => "index.php?ToDo=addProduct");
						}
						else {
							$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Products') => "index.php?ToDo=viewProducts");
							if (GetSession('productsearch') > 0) {
								if (!isset($_GET['searchId'])) {
									$_GET['searchId'] = GetSession('productsearch');
									$_REQUEST['searchId'] = GetSession('productsearch');
								}

								if ($_GET['searchId'] > 0) {
									$GLOBALS['BreadcrumEntries'] = array_merge($GLOBALS['BreadcrumEntries'], array(GetLang('CustomView') => "index.php?ToDo=customProductSearch"));
								}
							}
						}

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->CopyProductStep2();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				default:
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Products)) {

						if(isset($_GET['searchQuery'])) {
							$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Products') => "index.php?ToDo=viewProducts", GetLang('SearchResults') => "index.php?ToDo=viewProducts");
						}
						else {
							$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Products') => "index.php?ToDo=viewProducts");
						}

						if (GetSession('productsearch') > 0) {
							if (!isset($_GET['searchId'])) {
								$_GET['searchId'] = GetSession('productsearch');
								$_REQUEST['searchId'] = GetSession('productsearch');
							}

							if ($_GET['searchId'] > 0) {
								$GLOBALS['BreadcrumEntries'] = array_merge($GLOBALS['BreadcrumEntries'], array(GetLang('CustomView') => "index.php?ToDo=customProductSearch"));
							}
						}

						if (!isset($_REQUEST['ajax'])) {
							$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						}

						if (GetSession('productsearch') > 0) {
							$this->CustomSearch();
						} else {
							UnsetSession('productsearch');
							$this->ManageProducts();
						}
						if (!isset($_REQUEST['ajax'])) {
							$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						}
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
			}
		}

		public function _GetPopupCategoryList($parentid=0, $prefix='')
		{
			$subs = array();

			// If we don't have any data get it from the db
			$GLOBALS['ISC_CLASS_ADMIN_CATEGORY'] = GetClass('ISC_ADMIN_CATEGORY');
			$GLOBALS['ISC_CLASS_ADMIN_CATEGORY']->getCatsInfo();
			if (empty($GLOBALS['ISC_CLASS_ADMIN_CATEGORY']->tree->nodesByPid)) {
				$parentid = 0;
			}

			if (!isset($GLOBALS['ISC_CLASS_ADMIN_CATEGORY']->tree->nodesByPid[$parentid])) {
				return '';
			}

			$cats = '';

			// Create the formatted array
			foreach ($GLOBALS['ISC_CLASS_ADMIN_CATEGORY']->tree->nodesByPid[$parentid] as $k => $catid) {
				$cat = $GLOBALS['ISC_CLASS_ADMIN_CATEGORY']->catsById[$catid];
				$cats .= sprintf("<li onclick='if(this.parentNode.previousItem) { this.parentNode.previousItem.className = \"\"; } this.className=\"active\"; var current_category = %s; this.parentNode.previousItem = this; ProductSelect.LoadLinks(\"category=%d\");'>%s<img src='images/category.gif' alt='' style='vertical-align: middle' /> %s</li>", $cat['categoryid'], $cat['categoryid'], $prefix, isc_html_escape($cat['catname']));
				$cats .= $this->_GetPopupCategoryList($cat['categoryid'], $prefix.'&nbsp;&nbsp;&nbsp;&nbsp;');
			}
			return $cats;
		}

        public function BrandList($brandid = 0)
        {
           // $options = '<option value="0">'.GetLang('SelectDept').'</option>';
           $options = '';
            $query = "select * from [|PREFIX|]brands ORDER BY brandname ASC";
            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
            while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                $sel = '';
                if($brandid == $row['brandid']) {
                    $sel = 'selected="selected"';
                }
                $options .= '<option value='.(int)$row['brandid'].' '.$sel.'>'.$row['brandname'].'</option>';
            }
            return $options;
        }
        
		public function PopupProductSelect()
		{
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("pageheader.popup");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();

			$GLOBALS['Callbacks'] = '';
			$callbacks = array(
				'selectCallback',
				'removeCallback',
				'closeCallback',
				'getSelectedCallback'
			);
			foreach($callbacks as $function) {
				if(isset($_REQUEST[$function])) {
					$GLOBALS['Callbacks'] .= 'ProductSelect.'.$function.' = window.opener.'.$_REQUEST[$function].';';
				}
			}

			$GLOBALS['ParentProductSelect'] = $_REQUEST['ProductSelect'];
			$GLOBALS['ParentProductList'] = $_REQUEST['ProductList'];

			if(isset($_REQUEST['FocusOnClose'])) {
				$GLOBALS['FocusOnClose'] = isc_html_escape($_REQUEST['FocusOnClose']);
			}

			if(isset($_REQUEST['single']) && $_REQUEST['single'] == 1) {
				$GLOBALS['ProductSelectSingle'] = 1;
			}
			else {
				$GLOBALS['ProductSelectSingle'] = 0;
			}

			// Get a listing of all of the categories
			$GLOBALS['CategorySelect'] = $this->_GetPopupCategoryList();
            $GLOBALS['BrandSelect'] = $this->BrandList(); # Baskaran

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("products.popupselect");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("pagefooter.popup");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}

		/**
		* Check if php has the gd module available
		*
		* @return boolean
		*/
		public function HasGD()
		{
			// Check whether PHP's GD image library is installed. This is used
			// for creating image thumbnails on the fly
			return (int)extension_loaded("gd");
		}

		public function _AutoGenerateThumb($ImageName, $Size="thumb", $OverrideExisting=false, $FileType=FT_IMAGE)
		{
			// Takes the filename of an image already uploaded into the
			// image directory, generates a thumbnal from it, stores it
			// in the image directory and returns its name

			if($FileType==FT_INSIMAGE)    {
                $imgFile = realpath(ISC_BASE_PATH."/" . GetConfig('InstallImageDirectory'));
            }
            else    {
                $imgFile = realpath(ISC_BASE_PATH."/" . GetConfig('ImageDirectory'));          
            }
            $imgFile .= "/" . $ImageName;

			if ($ImageName == '' || !file_exists($imgFile)) {
				return false;
			}

			// A list of thumbnails too
			$tmp = explode(".", $imgFile);
			$ext = isc_strtolower($tmp[count($tmp)-1]);

			// If overriding the existing image, set the output filename to the input filename
			//Large and medium size images by Simha
			if($Size=='large')    {
                $thumbFileName = $ImageName;
            }
            else if($Size=='medium')    {
                $thumbFileName = GenRandFileName($ImageName, $Size); 
            }
            else if($OverrideExisting == true) {
				$thumbFileName = $ImageName;
			}
			else {
				$thumbFileName = GenRandFileName($ImageName, $Size);
			}

			$attribs = @getimagesize($imgFile);
			$width = $attribs[0];
			$height = $attribs[1];

			if(!is_array($attribs)) {
				return false;
			}

			// Check if we have enough available memory to create this image - if we don't, attempt to bump it up
			setImageFileMemLimit($imgFile);

			if($FileType==FT_INSIMAGE)    {                                                   
                $thumbFile = realpath(ISC_BASE_PATH."/" . GetConfig('InstallImageDirectory'));
            }
            else    {
                $thumbFile = realpath(ISC_BASE_PATH."/" . GetConfig('ImageDirectory'));          
            }
			$thumbFile .= "/" . $thumbFileName;

			if ($ext == "jpg") {
				$srcImg = @imagecreatefromjpeg($imgFile);
			} else if($ext == "gif") {
				$srcImg = @imagecreatefromgif($imgFile);
				if(!function_exists("imagegif")) {
					$gifHack = 1;
				}
			} else {
				$srcImg = @imagecreatefrompng($imgFile);
			}

			if(!$srcImg) {
				return false;
			}

			$srcWidth = @imagesx($srcImg);
			$srcHeight = @imagesy($srcImg);
			
			//Large and medium size images by Simha
			if($Size=='large')    {
                $AutoThumbSize = 700;
            } else if($Size=='medium')    {
                $AutoThumbSize = 70;
            } else if($Size == "tiny") {
				$AutoThumbSize = ISC_TINY_THUMB_SIZE;
			} else {
				$AutoThumbSize = GetConfig('AutoThumbSize');
			}

			// This thumbnail is smaller than the Interspire Shopping Cart dimensions, simply copy the image and return
			if($srcWidth <= $AutoThumbSize && $srcHeight <= $AutoThumbSize) {
				@imagedestroy($srcImg);
				if($OverrideExisting == false) {
					@copy($imgFile, $thumbFile);
				}
				return $thumbFileName;
			}

			// Make sure the thumb has a constant height
			$thumbWidth = $width;
			$thumbHeight = $height;

			if($width > $AutoThumbSize) {
				$thumbWidth = $AutoThumbSize;
				$thumbHeight = ceil(($height*(($AutoThumbSize*100)/$width))/100);
				$height = $thumbHeight;
				$width = $thumbWidth;
			}

			if($height > $AutoThumbSize) {
				$thumbHeight = $AutoThumbSize;
				$thumbWidth = ceil(($width*(($AutoThumbSize*100)/$height))/100);
			}

			$thumbImage = @imagecreatetruecolor($thumbWidth, $thumbHeight);
			if($ext == "gif" && !isset($gifHack)) {
				$colorTransparent = @imagecolortransparent($srcImg);
				@imagepalettecopy($srcImg, $thumbImage);
				@imagecolortransparent($thumbImage, $colorTransparent);
				@imagetruecolortopalette($thumbImage, true, 256);
			}
			else if($ext == "png") {
				@ImageColorTransparent($thumbImage, @ImageColorAllocate($thumbImage, 0, 0, 0));
				@ImageAlphaBlending($thumbImage, false);
			}

			@imagecopyresampled($thumbImage, $srcImg, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $srcWidth, $srcHeight);

			if ($ext == "jpg") {
				@imagejpeg($thumbImage, $thumbFile, 100);
			} else if($ext == "gif") {
				if(isset($gifHack) && $gifHack == true) {
					$thumbFile = isc_substr($thumbFile, 0, -3)."jpg";
					@imagejpeg($thumbImage, $thumbFile, 100);
				}
				else {
					@imagegif($thumbImage, $thumbFile);
				}
			} else {
				@imagepng($thumbImage, $thumbFile);
			}

			@imagedestroy($thumbImage);
			@imagedestroy($srcImg);

			// Change the permissions on the thumbnail file
			isc_chmod($thumbFile, ISC_WRITEABLE_FILE_PERM);

			return $thumbFileName;
		}

// this function is added by blessen
public function _AutoGenerateInsThumb($ImageName, $Size="thumb", $OverrideExisting=false)
		{
			// Takes the filename of an image already uploaded into the
			// image directory, generates a thumbnal from it, stores it
			// in the image directory and returns its name

			$imgFile = realpath(ISC_BASE_PATH."/install_images");
			$imgFile .= "/" . $ImageName;

			if ($ImageName == '' || !file_exists($imgFile)) {
				return false;
			}

			// A list of thumbnails too
			$tmp = explode(".", $imgFile);
			$ext = isc_strtolower($tmp[count($tmp)-1]);

			// If overriding the existing image, set the output filename to the input filename
			//Large and medium size images by Simha
			if($Size=='large')    {
                $thumbFileName = $ImageName;
            }
            else if($Size=='medium')    {
                $thumbFileName = GenRandFileName($ImageName, $Size); 
            }
            else if($OverrideExisting == true) {
				$thumbFileName = $ImageName;
			}
			else {
				$thumbFileName = GenRandFileName($ImageName, $Size);
			}

			$attribs = @getimagesize($imgFile);
			$width = $attribs[0];
			$height = $attribs[1];

			if(!is_array($attribs)) {
				return false;
			}

			// Check if we have enough available memory to create this image - if we don't, attempt to bump it up
			setImageFileMemLimit($imgFile);

			$thumbFile = realpath(ISC_BASE_PATH."/install_images");
			$thumbFile .= "/" . $thumbFileName;

			if ($ext == "jpg") {
				$srcImg = @imagecreatefromjpeg($imgFile);
			} else if($ext == "gif") {
				$srcImg = @imagecreatefromgif($imgFile);
				if(!function_exists("imagegif")) {
					$gifHack = 1;
				}
			} else {
				$srcImg = @imagecreatefrompng($imgFile);
			}

			if(!$srcImg) {
				return false;
			}

			$srcWidth = @imagesx($srcImg);
			$srcHeight = @imagesy($srcImg);
			
			//Large and medium size images by Simha
			if($Size=='large')    {
                $AutoThumbSize = 800;
            } else if($Size=='medium')    {
                $AutoThumbSize = 70;
            } else if($Size == "tiny") {
				$AutoThumbSize = ISC_TINY_THUMB_SIZE;
			} else {
				$AutoThumbSize = GetConfig('AutoThumbSize');
			}

			// This thumbnail is smaller than the Interspire Shopping Cart dimensions, simply copy the image and return
			if($srcWidth <= $AutoThumbSize && $srcHeight <= $AutoThumbSize) {
				@imagedestroy($srcImg);
				if($OverrideExisting == false) {
					@copy($imgFile, $thumbFile);
				}
				return $thumbFileName;
			}

			// Make sure the thumb has a constant height
			$thumbWidth = $width;
			$thumbHeight = $height;

			if($width > $AutoThumbSize) {
				$thumbWidth = $AutoThumbSize;
				$thumbHeight = ceil(($height*(($AutoThumbSize*100)/$width))/100);
				$height = $thumbHeight;
				$width = $thumbWidth;
			}

			if($height > $AutoThumbSize) {
				$thumbHeight = $AutoThumbSize;
				$thumbWidth = ceil(($width*(($AutoThumbSize*100)/$height))/100);
			}

			$thumbImage = @imagecreatetruecolor($thumbWidth, $thumbHeight);
			if($ext == "gif" && !isset($gifHack)) {
				$colorTransparent = @imagecolortransparent($srcImg);
				@imagepalettecopy($srcImg, $thumbImage);
				@imagecolortransparent($thumbImage, $colorTransparent);
				@imagetruecolortopalette($thumbImage, true, 256);
			}
			else if($ext == "png") {
				@ImageColorTransparent($thumbImage, @ImageColorAllocate($thumbImage, 0, 0, 0));
				@ImageAlphaBlending($thumbImage, false);
			}

			@imagecopyresampled($thumbImage, $srcImg, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $srcWidth, $srcHeight);

			if ($ext == "jpg") {
				@imagejpeg($thumbImage, $thumbFile, 100);
			} else if($ext == "gif") {
				if(isset($gifHack) && $gifHack == true) {
					$thumbFile = isc_substr($thumbFile, 0, -3)."jpg";
					@imagejpeg($thumbImage, $thumbFile, 100);
				}
				else {
					@imagegif($thumbImage, $thumbFile);
				}
			} else {
				@imagepng($thumbImage, $thumbFile);
			}

			@imagedestroy($thumbImage);
			@imagedestroy($srcImg);

			// Change the permissions on the thumbnail file
			isc_chmod($thumbFile, ISC_WRITEABLE_FILE_PERM);

			return $thumbFileName;
		}






		public function _GetImageData($ProductId = 0, $ProductHash = '')
        
        {
            // Gets the images for a product. If $ProductId is 0 then
            // the data is retrieved from the form. If not, it is retrieved
            // from the product_images table.

            $i = 1;
            $j = 1;
            $ImageArray = array();

            if($ProductId == 0 && $ProductHash == '') {
                // Get the data for the images from the form.
                $ImageArray['numImages']    = 0;
                $ImageArray['numInsImages'] = 0;
                
                for ($i = 1; $i <= 10; $i++) {
                    $ImageArray["image" . $i] = $this->_StoreFileAndReturnId("prodImage" . $i, FT_IMAGE);   
                    $ImageArray["image" . $i] = $this->_AutoGenerateThumb($ImageArray["image" . $i], "large");
                    $ImageArray["thumb" . $i] = $this->_AutoGenerateThumb($ImageArray["image" . $i], "medium"); 
                    if($ImageArray["image" . $i] != "") {
                        $ImageArray['numImages']++;
                    }
                    
                    //For the Install Images
                    $ImageArray["insimage" . $i] = $this->_StoreFileAndReturnId("installImage" . $i, FT_INSIMAGE);   
                    $ImageArray["insimage" . $i] = $this->_AutoGenerateThumb($ImageArray["insimage" . $i], "large",false,FT_INSIMAGE);
                    $ImageArray["insthumb" . $i] = $this->_AutoGenerateThumb($ImageArray["insimage" . $i], "medium",false,FT_INSIMAGE); 
                    if($ImageArray["insimage" . $i] != "") {
                        $ImageArray['numInsImages']++;
                    }
                    
                }
                  
                // If GD is installed, do we need to auto-generate the thumbnail or has it been uploaded?
                if ($this->HasGD()) {     
                    if(isset($_POST['prodGenThumb']) && $_FILES['prodThumb1']['name'] == "") {
                        // We will auto-generate a thumbnail from the first image
                        if($ImageArray['image1'] != "") {
                            $ImageArray['thumb'] = $this->_AutoGenerateThumb($ImageArray['image1']);

                            // Generate a "tiny" image as well for those with GD
                            $ImageArray['tiny'] = $this->_AutoGenerateThumb($ImageArray['image1'], "tiny");

                        }
                        else if(isset($_POST['productId']) && !empty($_POST['productId'])) {
                            $query = "SELECT imagefile FROM [|PREFIX|]product_images WHERE imageprodid='".(int)$_POST['productId']."' AND imageisthumb=0 ORDER BY imagesort ASC";
                            $query .= $GLOBALS['ISC_CLASS_DB']->AddLimit(0, 1);
                            $existingImage = $GLOBALS['ISC_CLASS_DB']->FetchOne($query);
                            $ImageArray['thumb'] = $this->_AutoGenerateThumb($existingImage);

                            // Generate a "tiny" image as well for those with GD
                            $ImageArray['tiny'] = $this->_AutoGenerateThumb($existingImage, "tiny");
                        }

                    } else {       
                        // Get the thumbnail image that they uploaded
                        $ImageArray['thumb'] = $this->_StoreFileAndReturnId("prodThumb1", FT_IMAGE);
                        $ImageArray['tiny'] = $this->_AutoGenerateThumb($ImageArray['thumb'], "tiny");
                    }
                } else {       
                    // Get the thumbnail image that they uploaded
                    $ImageArray['thumb'] = $this->_StoreFileAndReturnId("prodThumb2", FT_IMAGE);
                    $ImageArray['tiny'] = $this->_AutoGenerateThumb($ImageArray['thumb'], "tiny");
                }        
            }
            else {
                // Get the data for this product from the database
                if (isId($ProductId)) {
                    $where = "imageprodid=" . (int)$ProductId;
                } else {
                    $where = "imageprodhash='" . $GLOBALS['ISC_CLASS_DB']->Quote($ProductHash) . "'";
                }

                $ImageArray['numImages'] = 0;
                $query = "select * from [|PREFIX|]product_images where " . $where . " order by imagesort, imageisthumb desc";
                $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
               
                while ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {      
                    if ($row['imageisthumb'] == 0) {
                        $ImageArray["image" . $i] = $row['imagefile'];   
                        $ImageArray["id" . $i++] = $row['imageid'];
                        $ImageArray['numImages']++;
                    } else if ($row['imageisthumb'] == 3) {      
                        $ImageArray["thumb" . $i] = $row['imagefile'];                     
                    } else if($row['imageisthumb'] == 2) {
                        $ImageArray['tiny'] = $row['imagefile'];
                    } else if($row['imageisthumb'] == 1) {
                        $ImageArray['thumb'] = $row['imagefile'];
                    }
                }  
                //For install images
                $ImageArray['numInsImages'] = 0;
                $query = "select * from [|PREFIX|]install_images where " . $where . " order by imagesort, imageisthumb desc";
                $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);

                while ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
                    if ($row['imageisthumb'] == 0) {
                        $ImageArray["insimage" . $j] = $row['imagefile'];
                        $ImageArray["insid" . $j++] = $row['imageid'];
                        $ImageArray['numInsImages']++;
                    } else if ($row['imageisthumb'] == 3) {
                        $ImageArray["insthumb" . $j] = $row['imagefile'];
                    }
                }
            }          
            return $ImageArray;
        }

        public function _GetVideoData($ProductId = 0, $ProductHash = '')

        {
            // Gets the videos for a product. If $ProductId is 0 then
            // the data is retrieved from the form. If not, it is retrieved
            // from the product_videos table.

            $i = 1; 
            $m = 1;                
            $VideoArray = array();

            if($ProductId == 0) {
                // Get the data for the videos(URLs) from the form.
                $VideoArray['numVideos']    = 0;    
                $AllVideos = $_POST['prodVideo']; 
                foreach($AllVideos as $val)   {
                    $VideoArray["video" . $i] =  $val;
                    $VideoArray['numVideos']++;
                    $i++;
                }
                // Get the data for the install videos(URLs) from the form.   
                $VideoArray['numInsVideos']    = 0;    
                $AllInsVideos = $_POST['insVideo']; 
                
                foreach($AllInsVideos as $val)   {
                    $VideoArray["insvideo" . $m] =  $val;
                    $VideoArray['numInsVideos']++;
                    $m++;
                }
            }
            else {
                // Get the data for this product from the database  
                $where = "videoprodid=" . (int)$ProductId . " AND videotype=1";

                $VideoArray['numVideos'] = 0;
                $query = "select * from [|PREFIX|]product_videos where " . $where . " order by videosort asc";
                $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
               
                while ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {  
                    $VideoArray["video" . $i]               = $row['videofile'];      
                    $VideoArray["addedtime" . $i]           = $row['videoaddedtime'];
                    $VideoArray["isdownloaded" . $i]        = $row['isdownloaded'];
                    $VideoArray["systemvideofile" . $i]     = $row['systemvideofile'];   
                    $VideoArray["videoupdatedtime" . $i]    = $row['videoupdatedtime']; 
                    $VideoArray["id" . $i++]                = $row['videoid'];                       
                    $VideoArray['numVideos']++;  
                }
                
                // Get the data for this install video of the product from the database  
                $where = "videoprodid=" . (int)$ProductId . " AND videotype=1";

                $VideoArray['numInsVideos'] = 0;
                $query = "select * from [|PREFIX|]install_videos where " . $where . " order by videosort asc";
                $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
               
                while ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {  
                    $VideoArray["insvideo" . $m]               = $row['videofile'];      
                    $VideoArray["insaddedtime" . $m]           = $row['videoaddedtime'];
                    $VideoArray["insisdownloaded" . $m]        = $row['isdownloaded'];
                    $VideoArray["inssystemvideofile" . $m]     = $row['systemvideofile'];    
                    $VideoArray["insvideoupdatedtime" . $m]    = $row['videoupdatedtime'];   
                    $VideoArray["insid" . $m++]                = $row['videoid'];                       
                    $VideoArray['numInsVideos']++;  
                }
            }                     
            return $VideoArray;
        }
        
        //Added by Simha
        public function _GetUserVideoData($ProductId = 0, $ProductHash = '')

        {
            // Gets the videos for a product. If $ProductId is 0 then
            // the data is retrieved from the form. If not, it is retrieved
            // from the product_videos table.

            $i = 1;
            $m = 1;
            $UserVideoArray = array();

            if($ProductId == 0) {
                // Get the data for the videos from the form.
                $UserVideoArray['numUserVideos']  = 0;       
                
                $AllUserVideos = $_FILES['userVideo']['name']; 
                
                foreach($AllUserVideos as $key => $val)   {
                    $UserVideoArray["uservideo" . $i] =  $this->_StoreVideoAndReturnId('userVideo', ($i-1), FT_VIDEO);
                    $UserVideoArray['numUserVideos']++;
                    $i++;
                }
                
                // Get the data for the user install videos from the form.
                $UserVideoArray['numUserInsVideos']  = 0;       
                
                $AllUserInsVideos = $_FILES['userInsVideo']['name']; 
                
                foreach($AllUserInsVideos as $key => $val)   {
                    $UserVideoArray["userinsvideo" . $m] =  $this->_StoreVideoAndReturnId('userInsVideo', ($m-1), FT_INSVIDEO);
                    $UserVideoArray['numUserInsVideos']++;
                    $m++;
                }
                                              
            }
            else {
                // Get the data for this product from the database  
                $where = "videoprodid=" . (int)$ProductId . " AND videotype=2";

                $UserVideoArray['numUserVideos'] = 0;
                $query = "select * from [|PREFIX|]product_videos where " . $where . " order by videosort asc";
                $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
               
                while ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {  
                    $UserVideoArray["uservideo" . $i]           = $row['videofile'];      
                    $UserVideoArray["addedtime" . $i]           = $row['videoaddedtime'];
                    $UserVideoArray["isdownloaded" . $i]        = $row['isdownloaded'];
                    $UserVideoArray["systemvideofile" . $i]     = $row['systemvideofile'];   
                    $UserVideoArray["uservideoid" . $i++]       = $row['videoid'];                       
                    $UserVideoArray['numUserVideos']++;  
                }
                
                // Get the data for this product install videos  from the database  
                $where = "videoprodid=" . (int)$ProductId . " AND videotype=2";

                $UserVideoArray['numUserInsVideos'] = 0;
                $query = "select * from [|PREFIX|]install_videos where " . $where . " order by videosort asc";
                $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
               
                while ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {  
                    $UserVideoArray["userinsvideo" . $m]           = $row['videofile'];      
                    $UserVideoArray["insaddedtime" . $m]           = $row['videoaddedtime'];
                    $UserVideoArray["insisdownloaded" . $m]        = $row['isdownloaded'];
                    $UserVideoArray["inssystemvideofile" . $m]     = $row['systemvideofile'];   
                    $UserVideoArray["userinsvideoid" . $m++]       = $row['videoid'];                       
                    $UserVideoArray['numUserInsVideos']++;  
                }
                
            }           
            return $UserVideoArray;
        }
        
		public function _GetCustomFieldData($ProductId = 0, &$RefArray = array())
		{
			// Gets the custom fields of a product. If $ProductId is 0 then
			// the data is retrieved from the form. If not, it is retrieved
			// from the custom fields table. Returns the data to the array
			// referenced by the $RefArray variable.

			if ($ProductId == 0) {
				// Get the data for this product from the form.
				if (array_key_exists("customFieldName", $_POST)) {
					foreach (array_keys($_POST["customFieldName"]) as $key) {
						if ($_POST["customFieldName"][$key] != "") {

							if (!isset($_POST["customFieldValue"][$key])) {
								$val = "";
							} else {
								$val = $_POST["customFieldValue"][$key];
							}

							$RefArray[] = array(
								"name" => $_POST["customFieldName"][$key],
								"value" => $val
							);
						}
					}
				}
			} else {
				// Get the data for this product from the database
				$query = sprintf("select * from [|PREFIX|]product_customfields where fieldprodid='%d' Order by fieldid ASC", $GLOBALS['ISC_CLASS_DB']->Quote($ProductId));
				$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);

				while ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
					$RefArray[] = array(
						"name" => $row['fieldname'],
						"value" => $row['fieldvalue']
					);
				}
			}
		}


		/**
		*get snippet for the configurable product field
		*
		*@param $field data  of a configurable product field
		*
		*@return string html of the field
		*/
		Private function _GetProductFieldRow($field = array())
		{
			$GLOBALS['ProductFieldId'] = (int)$field['id'];

			$GLOBALS['ProductFieldName'] = GetLang('FieldName');
			$GLOBALS['FieldNameClass'] = 'FieldHelp';
			if(trim($field['name']) != '') {
				$GLOBALS['ProductFieldName'] = isc_html_escape($field['name']);
				$GLOBALS['FieldNameClass'] = '';
			}
			$GLOBALS['ProductFieldType'] = isc_html_escape($field['type']);

			$GLOBALS['ProductFieldFileType'] = GetLang('FieldFileType');
			$GLOBALS['FileTypeClass'] = 'FieldHelp';
			if(trim($field['fileType'])!='') {
				$GLOBALS['ProductFieldFileType'] = isc_html_escape($field['fileType']);
				$GLOBALS['FileTypeClass'] = '';
			}

			$GLOBALS['ProductFieldFileSize'] = GetLang('FieldFileSize');
			$GLOBALS['FileSizeClass'] = 'FieldHelp';
			if(trim($field['fileSize']) != '') {
				$GLOBALS['ProductFieldFileSize'] = isc_html_escape($field['fileSize']);
				$GLOBALS['FileSizeClass'] = '';
			}
			$GLOBALS['ProductFieldLabelNumber'] = $GLOBALS['ProductFieldKey'] + 1;

			if($field['required']==1) {
				$GLOBALS['ProductFieldRequired'] = 'checked';
			} else {
				$GLOBALS['ProductFieldRequired'] = '';
			}

			$GLOBALS['ProductFieldTypeText'] = '';
			$GLOBALS['ProductFieldTypeTextarea'] = '';
			$GLOBALS['ProductFieldTypeFile'] = '';
			$GLOBALS['ProductFieldTypeCheckbox'] = '';
			$GLOBALS['HideFieldFileType'] = 'display: none';

			switch($GLOBALS['ProductFieldType']) {
				case 'text': {
					$GLOBALS['ProductFieldTypeText'] = 'Selected';
					break;
				}
				case 'textarea': {
					$GLOBALS['ProductFieldTypeTextarea'] = 'Selected';
					break;
				}
				case 'file': {
					$GLOBALS['HideFieldFileType'] = '';
					$GLOBALS['ProductFieldTypeFile'] = 'Selected';
					break;
				}
				case 'checkbox': {
					$GLOBALS['ProductFieldTypeCheckbox'] = 'Selected';
					break;
				}
			}

			if (!$GLOBALS['ProductFieldKey']) {
				$GLOBALS['HideProductFieldDelete'] = 'none';
			} else {
				$GLOBALS['HideProductFieldDelete'] = '';
			}

			return $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('ProductFields');
		}

		/**
		* create configurable products fields section on products page
		*
		* @param int $productId product id
		* @param bool $CopyProduct, is this for coping a product
		* @return string html of the configurable products fields section
		*/
		Private function _GetProductFieldsLayout($productId = 0, $CopyProduct = false)
		{
			$arrProductFields = array();
			$productFields = '';
			$GLOBALS['ProductFieldKey'] = 0;
			$GLOBALS['ProductFieldNumber'] = 1;

			$this->_GetProductFieldData($productId, $arrProductFields, $CopyProduct);
			if (!empty($arrProductFields)) {
				foreach ($arrProductFields as $f) {
					$productFields .= $this->_GetProductFieldRow($f);
					$GLOBALS['ProductFieldNumber']++;
					$GLOBALS['ProductFieldKey']++;
				}
			}
			if($GLOBALS['ProductFieldKey'] == 0) {
				$GLOBALS['FieldLastKey'] = 1;
			} else {
				$GLOBALS['FieldLastKey'] = $GLOBALS['ProductFieldKey'];
			}
			//create one empty row if there isn't any field
			if ($productFields=='') {
				$field = array('name'=>'', 'type'=>'', 'fileType'=>'', 'fileSize'=>'', 'required'=>'', 'id'=>0);
				$productFields .= $this->_GetProductFieldRow($field);
			}
			return $productFields;
		}

		/**
		* valid configurable product fields
		*
		* @param array $ProductFields configurable fields data
		*
		* @return String form validation message
		*/
		private function _ValidateProductFields($ProductFields)
		{
			if(empty($ProductFields)) {
				return '';
			}
			foreach ($ProductFields as $field) {
				if($field['name'] == '' && ($field['type'] != 'text' || $field['required']==1)) {
					return GetLang('EnterProductFieldName');
				}

				if($field['type'] == 'file' && $field['fileType'] == '') {
					return GetLang('EnterProductFieldFileType');
				}

				if($field['type'] == 'file' && $field['fileSize'] == '') {
					return GetLang('EnterProductFieldFileSize');
				}
			}
			return '';
		}

		/**
		* Gets the configurable product fields of a product. If $ProductId is 0 then
		* the data is retrieved from the form. If not, it is retrieved
		* from the custom fields table. Returns the data to the array
		* referenced by the $RefArray variable.
		*
		* @param int $ProductId product id
		* @param array $RefArray fields data
		* @param bool $CopyProduct if this is called to copy a product, then the field id shouldn't be set, it should be treated as a new field
		*/
		private function _GetProductFieldData($ProductId = 0, &$RefArray = array(), $CopyProduct = false)
		{
			if ($ProductId == 0) {
				// Get the data for this product from the form.
				if (isset($_POST['productFieldName'])) {
					if(is_array($_POST['productFieldName'])) {
						foreach ($_POST['productFieldName'] as $key => $name) {
							if (trim($name) != "") {
								$type = 'text';
								$required = 0;
								$fileType = '';
								$fileSize = 0;
								if (isset($_POST["productFieldType"][$key])) {
									$type = $_POST["productFieldType"][$key];
									if($type=='file') {
										if(isset($_POST["productFieldFileType"][$key])) {
											$fileType = $_POST["productFieldFileType"][$key];
										}
										if (isset($_POST["productFieldFileSize"][$key])) {
											$fileSize = $_POST["productFieldFileSize"][$key];
										}
									}
								}

								if (isset($_POST["productFieldRequired"][$key])) {
									$required = 1;
								}

								$RefArray[] = array(
									"id"		=> $_POST["productFieldId"][$key],
									"name"		=> $name,
									"type"		=> $type,
									"fileType"	=> $fileType,
									"fileSize"	=> $fileSize,
									"required"	=> $required
								);
							}
						}
					}
				}
			} else {
				// Get the data for this product from the database
				$query = "select * from [|PREFIX|]product_configurable_fields where fieldprodid='".$GLOBALS['ISC_CLASS_DB']->Quote($ProductId)."' Order by fieldsortorder ASC";
				$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);

				while ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {

					//if this is to copy a product, then the field id should be set to 0 to trigger a insertion for the new field when save it.
					if($CopyProduct) {
						$productFieldId = 0;

					//otherwise this is editing a product
					} else {
						$productFieldId = $row['productfieldid'];
					}

					$RefArray[] = array(
						"id"		=> $productFieldId,
						"name"		=> $row['fieldname'],
						"type"		=> $row['fieldtype'],
						"fileType"	=> $row['fieldfiletype'],
						"fileSize"	=> $row['fieldfilesize'],
						"required"	=> $row['fieldrequired']
					);
				}
			}
		}

		/**
		* save configurable product fields details in database
		*
		* @param array $ProductFields product fields data
		* @param int $prodId Product id
		*
		*/
		Private function _SaveProductFields($ProductFields, $prodId)
		{
			//get current field ids from data base
			$result = $GLOBALS['ISC_CLASS_DB']->Query("SELECT productfieldid FROM [|PREFIX|]product_configurable_fields WHERE fieldprodid='".(int) $prodId."'");

			$unaffectedFields = array();
			while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$unaffectedFields[] = $row['productfieldid'];
			}

			$productFieldIDs = array();
			if (!empty($ProductFields)) {
				$sortOrder = 1;
				foreach ($ProductFields as $field) {

					if ($field['name'] === GetLang('FieldName') || $field['fileType'] === GetLang('FieldFileType') || $field['fileSize'] === GetLang('FieldFileSize')) {
						continue;
					}

					$newField = array(
						"fieldprodid" => $prodId,
						"fieldname" => $field['name'],
						"fieldtype" => $field['type'],
						"fieldfiletype" => $field['fileType'],
						"fieldfilesize" => $field['fileSize'],
						"fieldrequired" => $field['required'],
						"fieldsortorder" => $sortOrder
					);

					//if this is a existing field, update it
					if(isset($field['id']) && $field['id'] > 0) {
						//remove the field id from unaffected fields because it's been updated
						if(in_array($field['id'], $unaffectedFields)) {
							$key = array_search($field['id'], $unaffectedFields);
							unset($unaffectedFields[$key]);
						}
						$GLOBALS['ISC_CLASS_DB']->UpdateQuery("product_configurable_fields", $newField, "productfieldid='".(int)$field['id']."'");
						$productFieldIDs[] = (int)$field['id'];
					}
					//if this is a new field, insert it
					else {
						$newFieldId = $GLOBALS['ISC_CLASS_DB']->InsertQuery("product_configurable_fields", $newField);
						$productFieldIDs[] = $newFieldId;
					}
					$sortOrder++;
				}
			}

			if(!empty($unaffectedFields)) {
				$fields = implode("','", $unaffectedFields);
				$GLOBALS['ISC_CLASS_DB']->Query("DELETE FROM [|PREFIX|]product_configurable_fields WHERE  productfieldid in ('".$fields."')");
			}

			$updateArray = array(
					"prodconfigfields" => implode(",", $productFieldIDs),
			);
			$GLOBALS['ISC_CLASS_DB']->UpdateQuery("products", $updateArray, "productid=".(int)$prodId);
		}

		/**
		 * Return the field label
		 *
		 * Method will construct the field lable so words and numbers can be in different language. The label will be used in the sprintf() function
		 * so there must be a '%s' to be replaced with the field number
		 *
		 * @access public
		 * @param int $key the current number
		 * @param string The field label to do the sprintf() with
		 * @return The replaced field label
		 */
		public function GetFieldLabel($key, $label)
		{
			$parts = str_split($key);
			$number = '';

			foreach ($parts as $part) {
				$number .= GetLang('Number' . $part);
			}

			return sprintf($label, $number);
		}

		/**
		 * Get the discount rules HTML
		 *
		 * Method will return the discount rules HTML for the discount panel
		 *
		 * @access private
		 * @param int $productId The optional product. Default will look in the POST
		 * @return string The discount rules HTML
		 */
		private function GetDiscountRules($productId=0)
		{
			$discounts = $this->GetDiscountRulesData($productId, true);
			$GLOBALS['DiscountRules'] = '';
			$GLOBALS['DiscountRulesKey'] = 0;

			if (!empty($discounts)) {
				foreach ($discounts as $discount) {

					// Type reset
					$GLOBALS['DiscountRulesTypePriceSelected'] = '';
					$GLOBALS['DiscountRulesTypePercentSelected'] = '';
					$GLOBALS['DiscountRulesTypeFixedSelected'] = '';

					$GLOBALS['DiscountRulesType' . ucfirst(isc_strtolower($discount['type'])) . 'Selected'] = "SELECTED";
					$GLOBALS['DiscountRulesQuantityMin'] = isc_html_escape($discount['quantitymin']);
					$GLOBALS['DiscountRulesQuantityMax'] = isc_html_escape($discount['quantitymax']);
					$GLOBALS['DiscountRulesAmount'] = $discount['amount'];
					$GLOBALS['DiscountRulesLabel'] = $this->GetFieldLabel(($GLOBALS['DiscountRulesKey']+1), GetLang('DiscountRulesField'));
					$GLOBALS['DiscountRulesAmountPrefix'] = '';
					$GLOBALS['DiscountRulesAmountPostfix'] = '';

					// Now for the funky part of displaying either the percentage or their default currency symbol
					if (isc_strtolower($discount['type']) == 'percent') {
						$GLOBALS['DiscountRulesAmountPrefix'] = '%';
					} else {
						if (GetConfig('CurrencyLocation') == 'left') {
							$GLOBALS['DiscountRulesAmountPrefix'] = GetConfig('CurrencyToken');
						} else {
							$GLOBALS['DiscountRulesAmountPostfix'] = GetConfig('CurrencyToken');
						}
					}

					// Now assign the different line endings
					if (isc_strtolower(isc_html_escape($discount['type'])) == 'fixed') {
						$GLOBALS['DiscountRulesLineEnding'] = GetLang('DiscountRulesForEachItem');
					} else {
						$GLOBALS['DiscountRulesLineEnding'] = GetLang('DiscountRulesOffEachItem');
					}

					$GLOBALS['DiscountRules'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('DiscountRules');

					$GLOBALS['DiscountRulesKey']++;
				}
			}
			else {
				// Show an empty discount rule if no rules are defined
				$GLOBALS['DiscountRulesTypePriceSelected'] = 'SELECTED';
				$GLOBALS['DiscountRulesTypePercentSelected'] = '';
				$GLOBALS['DiscountRulesTypeFixedSelected'] = '';
				$GLOBALS['DiscountRulesQuantityMin'] = '';
				$GLOBALS['DiscountRulesQuantityMax'] = '';
				$GLOBALS['DiscountRulesAmount'] = '';
				$GLOBALS['DiscountRulesLabel'] = $this->GetFieldLabel(($GLOBALS['DiscountRulesKey']+1), GetLang('DiscountRulesField'));
				$GLOBALS['DiscountRulesAmountPrefix'] = GetConfig('CurrencyToken');
				$GLOBALS['DiscountRulesAmountPostfix'] = '';
				$GLOBALS['DiscountRulesLineEnding'] = GetLang('DiscountRulesOffEachItem');
				$GLOBALS['DiscountRules'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('DiscountRules');
			}

			return $GLOBALS['DiscountRules'];
		}

		/**
		 * Get the discount rules
		 *
		 * Method will return the discount rules either from the POST or from the database
		 *
		 * @access private
		 * @param int $productId The optional product ID associated with the discount rules. Will default to 0 (retrieve from POST)
		 * @param bool $removeEmptyRows TRUE to remove any empty records, FALSE to keep them in. Only used on the POST request. Default is FALSE
		 * @return array The array of discount rules
		 */
		private function GetDiscountRulesData($productId=0, $removeEmptyRows=false)
		{
			$discount = array();

			// Get the data from the POST
			if (!isId($productId)) {
				if (array_key_exists("discountRulesType", $_POST)) {
					foreach (array_keys($_POST["discountRulesType"]) as $key) {

						if (!isset($_POST["discountRulesQuantityMin"][$key]) || $_POST["discountRulesQuantityMin"][$key] == '') {
							$quantitymin = '';
						} else {
							$quantitymin = $_POST["discountRulesQuantityMin"][$key];
						}

						if (!isset($_POST["discountRulesQuantityMax"][$key]) || $_POST["discountRulesQuantityMax"][$key] == '') {
							$quantitymax = '';
						} else {
							$quantitymax = $_POST["discountRulesQuantityMax"][$key];
						}

						if (!isset($_POST["discountRulesAmount"][$key]) || $_POST["discountRulesAmount"][$key] == '') {
							$amount = '';
						} else {
							$amount = $_POST["discountRulesAmount"][$key];
						}

						// Check for any empties
						if ($removeEmptyRows && $quantitymin == '' && $quantitymax == '' && $amount == '') {
							continue;
						}

						$discount[] = array(
							"type" => $_POST["discountRulesType"][$key],
							"quantitymin" => $quantitymin,
							"quantitymax" => $quantitymax,
							"amount" => $amount,
						);
					}
				}

			// Else get it from the database
			} else {

				// Order it by quantity. Looks a bit weird because zeros are astrixes
				$query = "
					SELECT *
					FROM [|PREFIX|]product_discounts
					WHERE discountprodid = " . (int)$productId . "
					ORDER BY IF(discountquantitymax > discountquantitymin, discountquantitymax, discountquantitymin) ASC
				";

				$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);

				while ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
					// If the min and max quantities are 0 then convert them to astrixes
					if (!isId($row['discountquantitymin'])) {
						$row['discountquantitymin'] = '*';
					}

					if (!isId($row['discountquantitymax'])) {
						$row['discountquantitymax'] = '*';
					}

					// If the type is a percent then it must be an integer
					if ($row['discounttype'] == 'percent') {
						$row['discountamount'] = (int)$row['discountamount'];
					}
					else {
						// Convert the price to their default currency format if we are a price type
						$row['discountamount'] = FormatPrice($row['discountamount'], false, false);
					}

					$discount[] = array(
						"type" => $row['discounttype'],
						"quantitymin" => $row['discountquantitymin'],
						"quantitymax" => $row['discountquantitymax'],
						"amount" => $row['discountamount'],
					);
				}
			}

			return $discount;
		}

		/**
		 * Validate discount rules data
		 *
		 * Method will validate all the discount rules POST data
		 *
		 * @access private
		 * @param string &$error The referenced string to store the error in, if any were found
		 * @return bool TRUE if POST data is valid, FALSE if there were errors
		 */
		private function ValidateDiscountRulesData(&$error)
		{
			$discounts = $this->GetDiscountRulesData(0);

			// Check to see if we have anything to validate
			if (empty($discounts)) {
				return true;
			}

			// Variable to check for overlapping
			$overlap = array(
						0 => array(),
						1 => array()
						);

			// This is to check for the previous quantities
			$prevMax = null;

			// OK, we have some, now check each rule
			foreach ($discounts as $key => $discount) {

				// Check first to see if these are empty records. If so then just continue
				if ($discount['quantitymin'] == '' && $discount['quantitymax'] == '' && $discount['amount'] == '') {
					continue;
				}

				if ($discount['quantitymin'] == '') {
					$error = sprintf(GetLang('DiscountRulesQuantityMinRequired'), $key+1);
					return false;
				}

				if (!isId($discount['quantitymin']) && $discount['quantitymin'] !== '*') {
					$error = sprintf(GetLang('DiscountRulesQuantityMinInvalid'), $key+1);
					return false;
				}

				if ($discount['quantitymax'] == '') {
					$error = sprintf(GetLang('DiscountRulesQuantityMaxRequired'), $key+1);
					return false;
				}

				if (!isId($discount['quantitymax']) && $discount['quantitymax'] !== '*') {
					$error = sprintf(GetLang('DiscountRulesQuantityMaxInvalid'), $key+1);
					return false;
				}

				// Check to see if the min is still lower than the maximum quantity
				if ($discount['quantitymin'] !== '*' && $discount['quantitymax'] !== '*' && $discount['quantitymin'] > $discount['quantitymax']) {
					$error = sprintf(GetLang('DiscountRulesQuantityMinHigher'), $key+1);
					return false;
				}

				// Both min and max values cannot be astrix
				if ($discount['quantitymin'] == '*' && $discount['quantitymax'] == '*') {
					$error = sprintf(GetLang('DiscountRulesQuantityBothAstrix'), $key+1);
					return false;
				}

				// Check to see if the previous max and current min quantities are both astrixes
				if (!is_null($prevMax) && $prevMax == '*' && $discount['quantitymin'] == '*') {
					$error = sprintf(GetLang('DiscountRulesQuantityMinPrevMaxAstrix'), $key+1);
					return false;
				}

				// Check for overlapping
				if ($discount['quantitymin'] !== '*' && CheckNumericOverlapping($discount['quantitymin'], $overlap) == 1) {
					$error = sprintf(GetLang('DiscountRulesQuantityMinOverlap'), $key+1);
					return false;
				}
				if ($discount['quantitymax'] !== '*' && CheckNumericOverlapping($discount['quantitymin'], $overlap) == 1) {
					$error = sprintf(GetLang('DiscountRulesQuantityMinOverlap'), $key+1);
					return false;
				}

				// Check those values for our next loop
				if ($discount['quantitymin'] !== '*') {
					$overlap[0][] = $discount['quantitymin'];
				} else {
					$overlap[0][] = '';
				}

				if ($discount['quantitymax'] !== '*') {
					$overlap[1][] = $discount['quantitymax'];
				} else {
					$overlap[1][] = '';
				}

				$type = isc_strtolower(isc_html_escape($discount['type']));

				// Do we have the currect type?
				if ($type !== 'price' && $type !== 'percent' && $type !== 'fixed') {
					$error = sprintf(GetLang('DiscountRulesTypeInvalid'), $key+1);
					return false;
				}

				if ($discount['amount'] == '') {
					$error = sprintf(GetLang('DiscountRulesAmountRequired'), $key+1);
					return false;
				}

				// Do we have a valit price/percentage?
				if (!isId($discount['amount']) && CPrice($discount['amount']) == '') {
					$error = sprintf(GetLang('DiscountRulesAmountInvalid'), $key+1);
					return false;
				}

				// Now we do some checking compared againt the product price
				switch ($type) {
					case 'price':
						if ($discount['amount'] >= $_POST['prodPrice']) {
							$error = sprintf(GetLang('DiscountRulesAmountPriceInvalid'), $key+1);
							return false;
						}
						break;

					case 'percent':
						if ((int)$discount['amount'] >= 100) {
							$error = sprintf(GetLang('DiscountRulesAmountPercentInvalid'), $key+1);
							return false;
						} else if (strpos($discount['amount'], '.') !== false) {
							$error = sprintf(GetLang('DiscountRulesAmountPercentIsFloat'), $key+1);
							return false;
						}
						break;

					case 'fixed':
						if ($discount['amount'] >= $_POST['prodPrice']) {
							$error = sprintf(GetLang('DiscountRulesAmountFixedInvalid'), $key+1);
							return false;
						}
						break;
				}

				// Store value to be used as previous value next time
				$prevMax = $discount['quantitymax'];
			}

			return true;
		}

		/**
		*	If the editor is disabled then we'll see if we need to run
		*	nl2br on the text if it doesn't contain any HTML tags
		*/
		public function FormatWYSIWYGHTML($HTML)
		{

			if(GetConfig('UseWYSIWYG')) {
				return $HTML;
			}
			else {
				// We need to sanitise all the line feeds first to 'nl'
				$HTML = SanatiseStringToUnix($HTML);

				// Now we can use nl2br()
				$HTML = nl2br($HTML);

				// But we still need to strip out the new lines as nl2br doesn't really 'replace' the new lines, it just inserts <br />before it
				$HTML = str_replace("\n", "", $HTML);

				// Fix up new lines and block level elements.
				$HTML = preg_replace("#(</?(?:html|head|body|div|p|form|table|thead|tbody|tfoot|tr|td|th|ul|ol|li|div|p|blockquote|cite|hr)[^>]*>)\s*<br />#i", "$1", $HTML);
				$HTML = preg_replace("#(&nbsp;)+(</?(?:html|head|body|div|p|form|table|thead|tbody|tfoot|tr|td|th|ul|ol|li|div|p|blockquote|cite|hr)[^>]*>)#i", "$2", $HTML);
				return $HTML;
			}
		}

		public function _GetProductData($ProductId = 0, &$RefArray = array())
		{
			// Gets the details of a product. If $ProductId is 0 then
			// the data is retrieved from the form. If not, it is retrieved
			// from the products table. Returns the data to the array
			// referenced by the $RefArray variable.

			if ($ProductId == 0) {
				// Get the data for this product from the form. The arrays
				// index names will match the table field names exactly.




				$RefArray['productid'] = 0;
				$RefArray['prodhash'] = $_POST['productHash'];
				$RefArray['prodname'] = $_POST['prodName'];
				$RefArray['prodcats'] = $_POST['category'];
				$RefArray['prodtype'] = $_POST['prodtype'];
				$RefArray['prodcode'] = $_POST['prodCode'];      
                $RefArray['skubarcode'] = $_POST['skubarcode'];  
				$RefArray['productVariationExisting'] = $_POST['productVariationExisting'];

				if(isset($_POST["wysiwyg_html"])) {
					$RefArray['proddesc'] = $this->FormatWYSIWYGHTML($_POST["wysiwyg_html"]);
					$RefArray['prodmfg'] = $this->FormatWYSIWYGHTML($_POST["wysiwyg_html"]);
					$RefArray['prod_instruction'] = $this->FormatWYSIWYGHTML($_POST["wysiwyg_html"]);
					$RefArray['prod_article'] = $this->FormatWYSIWYGHTML($_POST["wysiwyg_html"]);
                    $RefArray['proddescfeature'] = $this->FormatWYSIWYGHTML($_POST["wysiwyg_html"]);
				}
				else {
					$RefArray['proddesc'] = $this->FormatWYSIWYGHTML($_POST['wysiwyg']);
	//blessen
					$RefArray['prodmfg'] = $this->FormatWYSIWYGHTML($_POST['wysiwyg1']);  
					$RefArray['prod_instruction'] = $this->FormatWYSIWYGHTML($_POST['wysiwyg3']);  
					$RefArray['prod_article'] = $this->FormatWYSIWYGHTML($_POST['wysiwyg4']);  
                    $RefArray['proddescfeature'] = $this->FormatWYSIWYGHTML($_POST['wysiwyg5']);  
				}
/*
$tempart = $this->_StoreInsArtFileAndReturnId('instruction_file', 'instruction_file');
$ins_path =  "../instruction_file/".$_SESSION['temp_instruction_file'];

if ($tempart  == "")
	{
		if ($_POST['delete_instruction_file'] == 1)
		{
		$RefArray['instruction_file'] = "";
        @unlink($ins_path);
		}
		else
		$RefArray['instruction_file'] = $_SESSION['temp_instruction_file'];
	}
else
	{
$RefArray['instruction_file'] = $tempart;
@unlink($ins_path);
	} 
*/
/*
$tempins = $this->_StoreInsArtFileAndReturnId('article_file', 'article_file');
$ins_path =  "../article_file/".$_SESSION['temp_article_file'];
if ($tempins  == "")
	{

		if ($_POST['delete_article_file'] == 1)
		{
		$RefArray['article_file'] = "";
		@unlink($ins_path);
		}
		else
		$RefArray['article_file'] = $_SESSION['temp_article_file'];
	}
else
	{
$RefArray['article_file'] = $tempins;
@unlink($ins_path);
	} */


				
				$RefArray['prodpagetitle'] = $_POST['prodPageTitle'];
				$RefArray['prodsearchkeywords'] = $_POST['prodSearchKeywords'];
				$RefArray['prodavailability'] = $_POST['prodAvailability'];
				$RefArray['prodprice'] = DefaultPriceFormat($_POST['prodPrice']);
				$RefArray['prodcostprice'] = DefaultPriceFormat($_POST['prodCostPrice']);
				$RefArray['prodretailprice'] = DefaultPriceFormat($_POST['prodRetailPrice']);
				$RefArray['prodsaleprice'] = DefaultPriceFormat($_POST['prodSalePrice']);
				$RefArray['prodsortorder'] = (int)$_POST['prodSortOrder'];


				/*Baskaran Added Starts*/
                $RefArray['price_log'] = DefaultPriceFormat($_POST['prodPrice']);
                $RefArray['jobberprice'] = $_POST['jobberprice'];
                $RefArray['mapprice'] = $_POST['mapprice'];
                $RefArray['unilateralprice'] = $_POST['unilateralprice'];
				$RefArray['comp_type'] = $_POST['comp_type'];
                $RefArray['ourcost'] = $_POST['ourcost'];
                $RefArray['package_length'] = $_POST['packagelength'];
                $RefArray['package_width'] = $_POST['packagewidth'];
                $RefArray['package_height'] = $_POST['packageheight'];
                $RefArray['package_weight'] = $_POST['packageweight'];
                $RefArray['brandseriesid'] = $_POST['productseries'];
                $RefArray['future_retail_price'] = $_POST['futureretailprice'];
                $RefArray['future_jobber_price'] = $_POST['futurejobberprice'];
                
                /*Baskaran Ends Starts*/     


				if(isset($_POST['prodIsTaxable'])) {
					$RefArray['prodistaxable'] = (int)$_POST['prodIsTaxable'];
				}
				else {
					$RefArray['prodistaxable'] = 0;
				}

				$RefArray['prodwrapoptions'] = 0;
				if(isset($_POST['prodwraptype'])) {
					switch($_POST['prodwraptype']) {
						case 'custom':
							$RefArray['prodwrapoptions'] = implode(",", array_map('intval', $_POST['prodwrapoptions']));
							break;
						case 'none':
							$RefArray['prodwrapoptions'] = -1;
					}
				}

				if (isset($_POST['prodVisible'])) {
					$RefArray['prodvisible'] = 1;
				} else {
					$RefArray['prodvisible'] = 0;
				}

				// Only store admins can set the store featured status of an item
				if (isset($_POST['prodFeatured']) && !$GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
					$RefArray['prodfeatured'] = 1;
				}
				else if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() > 0 && isset($_POST['productId']) && $_POST['productId'] > 0) {
					$this->_GetProductData($_POST['productId'], $existingProduct);
					$RefArray['prodfeatured'] = $existingProduct['prodfeatured'];
				}
				else {
					$RefArray['prodfeatured'] = 0;
				}

				// Anyone can set the vendor featured status
				if (isset($_POST['prodvendorfeatured'])) {
					$RefArray['prodvendorfeatured'] = 1;
				}
				else {
					$RefArray['prodvendorfeatured'] = 0;
				}

				$RefArray['prodhideprice'] = 0;
				$RefArray['prodcallforpricinglabel'] = '';
				if(isset($_POST['prodAllowPurchasing'])) {
					$RefArray['prodallowpurchases'] = 1;
				}
				else {
					$RefArray['prodallowpurchases'] = 0;
					if(isset($_POST['prodHidePrices'])) {
						$RefArray['prodhideprice'] = 1;
					}
					if(isset($_POST['prodCallForPricingLabel'])) {
						$RefArray['prodcallforpricinglabel'] = $_POST['prodCallForPricingLabel'];
					}
				}

				if(isset($_POST['prodRelatedAuto'])) {
					$RefArray['prodrelatedproducts'] = -1;	// Auto detected
				}
				else {
					if(isset($_POST['prodRelatedProducts'])) {
						$RefArray['prodrelatedproducts'] = implode(",", array_map('intval', $_POST['prodRelatedProducts']));
					}
					else {
						$RefArray['prodrelatedproducts'] = "";
					}
				}

				$RefArray['prodinvtrack'] = (int)$_POST['prodInvTrack'];

				// Is the inventory tracking per product? If so, get the
				// current and low stock level counts. If not, they are zero.

				if ($RefArray['prodinvtrack'] == 1) {
					$RefArray['prodcurrentinv'] = $_POST['prodCurrentInv'];
					$RefArray['prodlowinv'] = $_POST['prodLowInv'];
				} else {
					$RefArray['prodcurrentinv'] = 0;
					$RefArray['prodlowinv'] = 0;
				}

				$RefArray['prodtags'] = $_POST['prodTags'];

				$RefArray['prodweight'] = DefaultDimensionFormat($_POST['prodWeight']);
				$RefArray['prodwidth'] = DefaultDimensionFormat($_POST['prodWidth']);
				$RefArray['prodheight'] = DefaultDimensionFormat($_POST['prodHeight']);
				$RefArray['proddepth'] = DefaultDimensionFormat($_POST['prodDepth']);
				$RefArray['prodfixedshippingcost'] = DefaultPriceFormat($_POST['prodFixedCost']);
//blessen
				$RefArray['prodwarranty'] = $this->FormatWYSIWYGHTML($_POST['wysiwyg2']);  

				$RefArray['prodpagetitle'] = $_POST['prodPageTitle'];
				// Handle the META keywords
				$RefArray['prodmetakeywords'] = $_POST['prodMetaKeywords'];
				$RefArray['prodmetadesc'] = $_POST['prodMetaDesc'];

				if (isset($_POST['prodFreeShipping'])) {
					$RefArray['prodfreeshipping'] = 1;
				} else {
					$RefArray['prodfreeshipping'] = 0;
				}

				if (isset($_POST['prodOptionsRequired'])) {
					$RefArray['prodoptionsrequired'] = 1;
				} else {
					$RefArray['prodoptionsrequired'] = 0;
				}

                // Workout the brand of the product
                $RefArray['prodbrandid'] = (int)$_POST['brandbox'];
                $RefArray['brandseriesid'] = $_POST['productseries']; # To get selected series id -- Baskaran

                $RefArray['prodlayoutfile'] = $_POST['prodlayoutfile'];

				$RefArray['prodeventdaterequired'] = 0;
				$RefArray['prodeventdatefieldname'] = '';
				$RefArray['prodeventdatelimited'] = 0;
				$RefArray['prodeventdatelimitedtype'] = 0;
				$RefArray['prodeventdatelimitedstartdate'] = 0;
				$RefArray['prodeventdatelimitedenddate'] = 0;

				if (isset($_POST['EventDateRequired'])) {
					$RefArray['prodeventdaterequired'] = true;
				}
				if (isset($_POST['EventDateFieldName'])) {
					$RefArray['prodeventdatefieldname'] = $_POST['EventDateFieldName'];
				}
				if (isset($_POST['LimitDates'])) {
					$RefArray['prodeventdatelimited'] = true;
				}
				if (isset($_POST['LimitDatesSelect'])) {
					$RefArray['prodeventdatelimitedtype'] = (int)$_POST['LimitDatesSelect'];

					switch ($RefArray['prodeventdatelimitedtype']) {
						case 1:
							$cal = $_POST['Calendar1'];
							$RefArray['prodeventdatelimitedstartdate'] = isc_gmmktime(0, 0, 0, (int)$cal['From']['Mth'],(int)$cal['From']['Day'],(int)$cal['From']['Yr']);
							$RefArray['prodeventdatelimitedenddate'] = isc_gmmktime(0, 0, 0, (int)$cal['To']['Mth'],(int)$cal['To']['Day'],(int)$cal['To']['Yr']);
						break;

						case 2:
							$cal = $_POST['Calendar2'];
							$RefArray['prodeventdatelimitedstartdate'] = isc_gmmktime(0, 0, 0, (int)$cal['From']['Mth'],(int)$cal['From']['Day'],(int)$cal['From']['Yr']);
						break;

						case 3:
							$cal = $_POST['Calendar3'];
							$RefArray['prodeventdatelimitedenddate'] = isc_gmmktime(0, 0, 0, (int)$cal['To']['Mth'],(int)$cal['To']['Day'],(int)$cal['To']['Yr']);
						break;
					}
				}

				// The ID of the variation the product is using
				if(isset($_POST['variationId']) && is_numeric($_POST['variationId'])) {
					$RefArray['prodvariationid'] = (int)$_POST['variationId'];
				}
				else {
					$RefArray['prodvariationid'] = 0;
				}

				$RefArray['prodvendorid'] = 0;
				if(gzte11(ISC_HUGEPRINT)) {
					$vendorData = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendor();
					// User is assigned to a vendor so any products they create must be too
					if(isset($vendorData['vendorid'])) {
						$RefArray['prodvendorid'] = $vendorData['vendorid'];
					}
					else if(isset($_POST['vendor'])) {
						$RefArray['prodvendorid'] = (int)$_POST['vendor'];
					}
				}
                /* Added for to get the vendor prefixt -- Baskaran */
                $queryprefix = $GLOBALS["ISC_CLASS_DB"]->Query("SELECT vendorprefix FROM [|PREFIX|]vendors where vendorid = '".$RefArray['prodvendorid']."' LIMIT 0,1");
                if($rowprefix = $GLOBALS["ISC_CLASS_DB"]->Fetch($queryprefix)) {
                    $RefArray['prodvendorprefix'] = $rowprefix['vendorprefix'];
                }
                else {
                    $RefArray['prodvendorprefix'] = '';
                }
                /* Ends here */
				$RefArray['prodmyobasset'] = $_POST['prodMYOBAsset'];
				$RefArray['prodmyobincome'] = $_POST['prodMYOBIncome'];
				$RefArray['prodmyobexpense'] = $_POST['prodMYOBExpense'];
				$RefArray['prodpeachtreegl'] = $_POST['prodPeachtreeGL'];
			} else {
				// Get the data for this product from the database
				$query = sprintf("select * from [|PREFIX|]products where productid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($ProductId));
				$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);

				if ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
					$RefArray = $row;
				}

                //$_SESSION['temp_article_file'] = $RefArray['article_file'];
                //$_SESSION['temp_instruction_file'] = $RefArray['instruction_file'];


				// Get the categories that this product appears in
				$RefArray['prodcats'] = array();
				$query = sprintf("select categoryid from [|PREFIX|]categoryassociations where productid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($ProductId));
				$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);

				while ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
					$RefArray['prodcats'][] = $row['categoryid'];
				}

				// Are there any related products?
				if ($RefArray['prodrelatedproducts'] != "") {
					$query = sprintf("select productid, prodname from [|PREFIX|]products where productid in (%s)", $RefArray['prodrelatedproducts']);
					$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);

					while ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
						$RefArray['prodrelated'][] = array($row['productid'], $row['prodname']);
					}
				}

				// Fetch any tags as a CSV list
				$query = "
					SELECT t.tagname
					FROM [|PREFIX|]product_tagassociations a
					INNER JOIN [|PREFIX|]product_tags t ON (t.tagid=a.tagid)
					WHERE a.productid='".(int)$ProductId."'
				";
				$RefArray['prodtags'] = '';
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					$RefArray['prodtags'] .= $row['tagname'].', ';
				}
				$RefArray['prodtags'] = rtrim($RefArray['prodtags'], ', ');
			}
		}

		
        public function _StoreFileAndReturnId($FileName, $FileType)
        {
            // This function takes a file name as its arguement and stores
            // this file in the /downloads or /images directory depending
            // on the $FileType enumeration value

            
            if ($FileType == FT_INSIMAGE) {
                $dir = GetConfig('InstallImageDirectory');
            }
            else if ($FileType == FT_DOWNLOAD) {
                $dir = GetConfig('DownloadDirectory');
            }
            else {
                $dir = GetConfig('ImageDirectory');
            }

            if (is_array($_FILES[$FileName]) && $_FILES[$FileName]['name'] != "") {
                // If it's an image, make sure it's a valid image type
                if ($FileType == FT_IMAGE && isc_strtolower(isc_substr($_FILES[$FileName]['type'], 0, 5)) != "image") {
                    return "";
                }

                if (is_dir(sprintf("../%s", $dir))) {
                    // Images and downloads will be stored within a directory randomly chosen from a-z.
                    $randomDir = strtolower(chr(rand(65, 90)));
                    if(!is_dir("../".$dir."/".$randomDir)) {
                        if(!@mkdir("../".$dir."/".$randomDir, 0777)) {
                            $randomDir = '';
                        }
                    }

                    // Clean up the incoming file name a bit
					$_FILES[$FileName]['name'] = urldecode($_FILES[$FileName]['name']);  //blessen
                    $_FILES[$FileName]['name'] = preg_replace("#[^\w.]#i", "_", $_FILES[$FileName]['name']);
                    $_FILES[$FileName]['name'] = preg_replace("#_{1,}#i", "_", $_FILES[$FileName]['name']);

                    $randomFileName = GenRandFileName($_FILES[$FileName]['name']);
                    $fileName = $randomDir . "/" . $randomFileName;
                    $dest = realpath(ISC_BASE_PATH."/" . $dir);
                    while(file_exists($dest."/".$fileName)) {
                        $fileName = basename($randomFileName);
                        $fileName = substr_replace($randomFileName, "-".rand(0, 10000000000), strrpos($randomFileName, "."), 0);
                        $fileName = $randomDir . "/" . $fileName;
                    }
                    $dest .= "/".$fileName;

                    if(move_uploaded_file($_FILES[$FileName]["tmp_name"], $dest)) {
                        isc_chmod($dest, ISC_WRITEABLE_FILE_PERM);
                        // The file was moved successfully
                        return $fileName;
                    }
                    else {
                        // Couldn't move the file, maybe the directory isn't writable?
                        return "";
                    }
                } else {
                    // The directory doesn't exist
                    return "";
                }
            } else {
                // The file doesn't exist in the $_FILES array
                return "";
            }
        }


        //Added by Simha for uploading videos
        public function _StoreVideoAndReturnId($FileName, $FileIndex, $FileType)
        {
            // This function takes a file name as its arguement and stores
            // this file in the /downloads or /images directory depending
            // on the $FileType enumeration value

            if ($FileType == FT_INSVIDEO) {
                $dir = GetConfig('InstallVideoDirectory');
            }
            else {
                $dir = GetConfig('VideoDirectory');
            }         
            
            if (is_array($_FILES[$FileName]) && $_FILES[$FileName]['name'][$FileIndex] != "") {  
                if (is_dir(sprintf("../%s", $dir))) {
                    // Images and downloads will be stored within a directory randomly chosen from a-z.
                    $randomDir = strtolower(chr(rand(65, 90)));
                    if(!is_dir("../".$dir."/".$randomDir)) {
                        if(!@mkdir("../".$dir."/".$randomDir, 0777)) {
                            $randomDir = '';
                        }
                    }

                    // Clean up the incoming file name a bit
                    $_FILES[$FileName]['name'][$FileIndex] = preg_replace("#[^\w.]#i", "_", $_FILES[$FileName]['name'][$FileIndex]);
                    $_FILES[$FileName]['name'][$FileIndex] = preg_replace("#_{1,}#i", "_", $_FILES[$FileName]['name'][$FileIndex]);

                    $randomFileName = GenRandFileName($_FILES[$FileName]['name'][$FileIndex]);
                    $fileName = $randomDir . "/" . $randomFileName;
                    $dest = realpath(ISC_BASE_PATH."/" . $dir);
                    while(file_exists($dest."/".$fileName)) {
                        $fileName = basename($randomFileName);
                        $fileName = substr_replace($randomFileName, "-".rand(0, 10000000000), strrpos($randomFileName, "."), 0);
                        $fileName = $randomDir . "/" . $fileName;
                    }
                    $dest .= "/".$fileName;

                    if(move_uploaded_file($_FILES[$FileName]['tmp_name'][$FileIndex], $dest)) {
                        isc_chmod($dest, ISC_WRITEABLE_FILE_PERM);
                        //ini_set("display_errors", 1);
                        $fileName = $this->fileConversion($fileName, $FileType);  
                        //exit;
                        // The file was moved successfully   
                        return $fileName;
                    }
                    else {         
                        // Couldn't move the file, maybe the directory isn't writable?
                        return "";
                    }
                } else {
                    // The directory doesn't exist
                    return "";
                }
            } else {                              
                // The file doesn't exist in the $_FILES array
                return "";
            }
        }

        

		public function _StoreInsArtFileAndReturnId($FileName,$fname)
		{
		
			$dir = $fname;
				
			if (is_array($_FILES[$FileName]) && $_FILES[$FileName]['name'] != "") {
				// If it's an image, make sure it's a valid image type
				if (isc_strtolower(isc_substr($_FILES[$FileName]['name'],  -3)) != "pdf") {
					return "";
				}



				if (!is_dir(sprintf("../%s", $dir))) {
						
					
						@mkdir("../".$dir, 0777);
							
				}

					// Clean up the incoming file name a bit
					$_FILES[$FileName]['name'] = preg_replace("#[^\w.]#i", "_", $_FILES[$FileName]['name']);
					$_FILES[$FileName]['name'] = preg_replace("#_{1,}#i", "_", $_FILES[$FileName]['name']);

					$randomFileName = GenRandFileName($_FILES[$FileName]['name']);
					$dest = realpath(ISC_BASE_PATH."/" . $dir);
					$dest .= "/".$randomFileName;

					if(move_uploaded_file($_FILES[$FileName]["tmp_name"], $dest)) {
						isc_chmod($dest, ISC_WRITEABLE_FILE_PERM);
						// The file was moved successfully
						return $randomFileName;
					}
					else {
						// Couldn't move the file, maybe the directory isn't writable?
						return "";
					}
				
			} else {
				// The file doesn't exist in the $_FILES array
				return "";
			}
		}


		/**
		* Get a list of files in the product_downloads/import directory which can be associated
		* with the product as download file
		*
		* @return string The html for the options
		*/
		public function _GetImportFilesOptions()
		{
			$files = $this->_GetImportFilesArray();
			$format = '<option value="%1$s">%1$s</option>'."\n";
			$output = '';
			if (is_array($files)) {
				foreach ($files as $file) {
					$output .= sprintf($format, isc_html_escape($file));
				}
			}
			return $output;
		}

		/**
		* Get a list of files in the product_downloads/import directory which can be associated
		* with the product as download file
		*
		* @return string The array of file names
		*/
		public function _GetImportFilesArray()
		{
			if(!is_dir(ISC_BASE_PATH.'/'.GetConfig('DownloadDirectory').'/import')) {
				return;
			}
			$files = scandir(ISC_BASE_PATH.'/'.GetConfig('DownloadDirectory').'/import');
			$ignore_files = array ('.', '..', '.svn', 'CVS', 'Thumbs.db');
			$files = array_diff($files, $ignore_files);
			return $files;
		}

		public function _CommitProduct($ProductId, &$Data, &$Images, &$Videos, &$UserVideos, &$Variations, &$CustomFields, $DiscountRules=array(), &$Err = null, &$ProductFields=array(), $isImport=false)
		{
			// Commit the details for the product to the database
			$query = "";
			$err = null;
			$searchData = array(
				"prodname" => $Data['prodname'],
				"prodcode" => $Data['prodcode'],
				"proddesc" => $Data['proddesc'],
				"prodsearchkeywords" => $Data['prodsearchkeywords']
			);
             


			/* Baskaran Added starts*/
            $column = "SHOW COLUMNS FROM [|PREFIX|]import_variations WHERE field LIKE 'VQ%' or field LIKE 'PQ%'";
            $rescol = $GLOBALS["ISC_CLASS_DB"]->Query($column); 
            $colname = '';
            $col = '';
            while($field = $GLOBALS['ISC_CLASS_DB']->Fetch($rescol)) {
                $col[] = $field['Field'];
            }
            foreach($col as $cname) {
                    $a[$cname] = addslashes($_POST[$cname]);
            }
            $impData = array(
                "prodstartyear" => $_POST['prodstartyear'],
                "prodendyear" => $_POST['prodendyear'],
                "prodmodel" => addslashes($_POST['prodmodel']),
                "prodsubmodel" => addslashes($_POST['prodsubmodel']),
                "prodmake" => addslashes($_POST["prodmake"]),
                "prodcode" => addslashes($_POST["prodcode1"])
            );  
            

//Update complementary product.  blessen


 foreach($_POST["comphidden"] as $key => $value) {

			if ($value != "")
			{


					$comData = array(
					  "complementaryitems" => isc_html_escape(trim($value))
					);  

					$query4 = "SELECT id  FROM [|PREFIX|]application_data  WHERE variationid = '".$key."' limit 0,1 ";
					$result2 = $GLOBALS['ISC_CLASS_DB']->Query($query4);
					$NumRows = $GLOBALS['ISC_CLASS_DB']->CountResult($result2); 
					if ($NumRows > 0)
					{
					
					$GLOBALS['ISC_CLASS_DB']->UpdateQuery("application_data", $comData, "variationid = '$key' ");

					}
					else
					{
					
						$comData = array(
						"complementaryitems" => isc_html_escape(trim($value)),
						"variationid" => $key,
						"productid" => $ProductId
						 ); 
						$GLOBALS['ISC_CLASS_DB']->InsertQuery("application_data", $comData);

					}
			}
 }





            //Code for product change report   --- Simha
            if ($ProductId != 0) {     
                $isContentChangeAdded = $this->MakeChangesReport($ProductId, $Data, $impData, $a);                
            }
            //Code for product change report   --- Simha
             
            $merge = array_merge($impData,$a); 
            if($_POST['hdnname'] == 'hdnsave') {
                $id = $_POST['editproduct'];  
                
                $GLOBALS['ISC_CLASS_DB']->UpdateQuery("import_variations", $merge, "id = '$id' and productid='".$ProductId."'");
            }
            /* Baskaran Added ends*/
			// Start the transaction
			$GLOBALS["ISC_CLASS_DB"]->Query("start transaction");
			$updateImageQuery = "";
            

	if ($ProductId == 0) {
				// Add the date this product was modified
				$entity = new ISC_ENTITY_PRODUCT();
				$prodId	= $entity->add($Data);

				$GLOBALS['NewProductId'] = $prodId;

				// ---- Build the query for the product_search table ----
				$searchData['productid'] = $prodId;
		$GLOBALS['ISC_CLASS_DB']->InsertQuery("product_search", $searchData);
               
                //Instruction File Changed by Simha
                if($_FILES['instruction_file']['name'] != "" && $_POST['delete_instruction_file'] != 1)    {
                    $tempart = $this->_StoreInsArtFileAndReturnId('instruction_file', 'instruction_file');   
                    $newInstructionFile = array(
                        "instructionprodid" => $prodId,
                        "instructionfile" => $tempart,
                        "instructiontype" => 2
                    );
                    $GLOBALS['ISC_CLASS_DB']->InsertQuery("instruction_files", $newInstructionFile);
                    
                }
                elseif($_POST['delete_instruction_file'] == 1)    {    
                    $ins_path =  "../instruction_file/".$_SESSION['temp_instruction_file'];
                    $query = "DELETE FROM [|PREFIX|]instruction_files WHERE instructionprodid='".$GLOBALS['ISC_CLASS_DB']->Quote($prodId)."'";
                    $GLOBALS['ISC_CLASS_DB']->Query($query);
                    @unlink($ins_path);
                }
                
                //Article File Changed by Simha
                if($_FILES['article_file']['name'] != "" && $_POST['delete_article_file'] != 1)    {
                    $tempart = $this->_StoreInsArtFileAndReturnId('article_file', 'article_file');   
                    $newArticleFile = array(
                        "articleprodid" => $prodId,
                        "articlefile" => $tempart,
                        "articletype" => 2
                    );
                    $GLOBALS['ISC_CLASS_DB']->InsertQuery("article_files", $newArticleFile);
                    
                }
                elseif($_POST['delete_article_file'] == 1)    {    
                    $ins_path =  "../article_file/".$_SESSION['temp_article_file'];
                    $query = "DELETE FROM [|PREFIX|]article_files WHERE articleprodid='".$GLOBALS['ISC_CLASS_DB']->Quote($prodId)."'";
                    $GLOBALS['ISC_CLASS_DB']->Query($query);
                    @unlink($ins_path);
                }
                  
				// Build the queries for the images table -----
				if(isset($Images) && !empty($Images)) {
					$imageSort = array();
					// First clear out any product images that already exist (in case of a previous import etc)
					$query = "DELETE FROM [|PREFIX|]product_images
					WHERE imageprodid='".$GLOBALS['ISC_CLASS_DB']->Quote($prodId)."'";
					$GLOBALS['ISC_CLASS_DB']->Query($query);

					// First clear out any install images that already exist (in case of a previous import etc)
					//For install images by Simha
                    $query = "DELETE FROM [|PREFIX|]install_images
                    WHERE imageprodid='".$GLOBALS['ISC_CLASS_DB']->Quote($prodId)."'";
                    $GLOBALS['ISC_CLASS_DB']->Query($query);

					// Next, try and add the full sized images
					for ($i = 1; $i <= 10; $i++) {
						if (isset($Images["image" . $i]) && $Images["image" . $i] != "") {
							// Store the image reference in the images table
							$newImage = array(
								"imageprodid" => $prodId,
								"imagefile" => $Images['image'.$i],
								"imageisthumb" => 0,
								"imagesort" => $i
							);
							$GLOBALS['ISC_CLASS_DB']->InsertQuery("product_images", $newImage);

							//Medium size change by Simha
							// Store the image thumb reference in the images table
                            $newThumb = array(
                                "imageprodid" => $prodId,
                                "imagefile" => $Images['thumb'.$i],
                                "imageisthumb" => 3,
                                "imagesort" => $i
                            );
                            $GLOBALS['ISC_CLASS_DB']->InsertQuery("product_images", $newThumb);

							$imageSort[] = $i;
						}
						
						
                        //Install Images by Simha
                        if (isset($Images["insimage" . $i]) && $Images["insimage" . $i] != "") {
                            // Store the image reference in the images table
                            $newImage = array(
                                "imageprodid" => $prodId,
                                "imagefile" => $Images['insimage'.$i],
                                "imageisthumb" => 0,
                                "imagesort" => $i
                            );
                            $GLOBALS['ISC_CLASS_DB']->InsertQuery("install_images", $newImage);
                            // Store the image reference in the images table
                            $newThumb = array(
                                "imageprodid" => $prodId,
                                "imagefile" => $Images['insthumb'.$i],
                                "imageisthumb" => 3,
                                "imagesort" => $i
                            );        
                            $GLOBALS['ISC_CLASS_DB']->InsertQuery("install_images", $newThumb);
                            //$imageSort[] = $i;
                        }  

					}

					if (!empty($imageSort)) {
						$updateImageQuery .= " AND imagesort not in (".implode(",", $imageSort).")";
					}

					// Now the query for the thumbnail image
					if (isset($Images['thumb']) && !empty($Images['thumb'])) {
						$thumbImage = array(
							"imageprodid" => $prodId,
							"imagefile" => $Images['thumb'],
							"imageisthumb" => 1
						);
						$GLOBALS['ISC_CLASS_DB']->InsertQuery("product_images", $thumbImage);
						if($Images['thumb'] != '') {
							$updateImageQuery .= " AND imageisthumb!=1";
						}
					}

					// And finally query for the tiny thumbnail image
					if (isset($Images['tiny']) && !empty($Images['tiny'])) {
						$tinyImage = array(
							"imageprodid" => $prodId,
							"imagefile" => $Images['tiny'],
							"imageisthumb" => 2
						);
						$GLOBALS['ISC_CLASS_DB']->InsertQuery("product_images", $tinyImage);

						if($Images['tiny'] != '') {
							$updateImageQuery .= " AND imageisthumb!=2";
						}
					}
				}
				// Set some $_GET variables so the newest product appears at the top of the list
				$_GET['sortField'] = "productid";
				$_GET['sortOrder'] = "desc";
		// add the product info to the products_statistics -- Mingxing
		
		$query = sprintf("SELECT * FROM [|PREFIX|]products_statistics WHERE LOWER(prodcode)='%s' and LOWER(prodvendorprefix) = '".$Data['prodvendorprefix']."'  ", $GLOBALS['ISC_CLASS_DB']->Quote(isc_strtolower($Data['prodcode'])));
		$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
		if($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
			$statisticsdb = array(
							"productid" => $prodId,
							"prodname" => $Data['prodname'],
							"proddesc" => $Data['proddesc'],
							"prodvendorid" => $Data['prodvendorid'],
							"enable" => '1'
			);
			$GLOBALS['ISC_CLASS_DB']->UpdateQuery("products_statistics", $statisticsdb, "LOWER(prodcode)='".$GLOBALS['ISC_CLASS_DB']->Quote(isc_strtolower($Data['prodcode']))."' and LOWER(prodvendorprefix) = '".$Data['prodvendorprefix']."'  ");
			$query = sprintf("update [|PREFIX|]products set prodnumviews='".$row['prodnumviews']."', prodnumsold='".$row['prodnumsold']."', prodratingtotal='".$row['prodratingtotal']."', prodnumratings='".$row['prodnumratings']."'   where  productid='".$GLOBALS['ISC_CLASS_DB']->Quote($prodId)."'");
			$GLOBALS['ISC_CLASS_DB']->Query($query);
		}
		else {
			$statisticsdb = array(
							"productid" => $prodId,
							"prodname" => $Data['prodname'],
							"proddesc" => $Data['proddesc'],
							"prodcode" => $Data['prodcode'],
							"prodvendorprefix" =>$Data['prodvendorprefix'],
							"prodvendorid" => $Data['prodvendorid']
			);
			$GLOBALS['ISC_CLASS_DB']->InsertQuery("products_statistics", $statisticsdb);
		}
		
		
		//end -- Mingxing
                // Build the queries for the videos table -----
                if(isset($Videos) && !empty($Videos)) {
                    $videoSort = array();
                    // First clear out any product videos that already exist (in case of a previous import etc)
                    $query = "DELETE FROM [|PREFIX|]product_videos
                    WHERE videoprodid='".$GLOBALS['ISC_CLASS_DB']->Quote($prodId)."' AND videotype='1'";
                    $GLOBALS['ISC_CLASS_DB']->Query($query);
                    
                    // Next, try and add the videos
                    for ($i = 1; $i <= 10; $i++) {
                        if (isset($Videos["video" . $i]) && $Videos["video" . $i] != "") {     
                            
                            $NewLink = $this->FormatLink($Videos['video'.$i], 1);  
                            if($NewLink != "invalid")    {                                  
                                $SystemVideoPath = $this->DownloadVideo($NewLink); 
                                if($SystemVideoPath != 'failed')    {
                                    $IsDownloaded = 2; 
                                }
                                else    {
                                    $IsDownloaded = 3;
                                }
                            }
                            else    {
                                $SystemVideoPath = "";
                                $IsDownloaded = 4;
                            }
                            
                            // Store the video reference in the videos table
                            $newVideo = array(
                                "videoprodid" => $prodId,
                                "videofile" => $Videos['video'.$i], 
                                "videotype" => 1, 
                                "videosort" => $i,
                                "videoaddedtime" => date("Y-m-d H:i:s"),
                                "systemvideofile" => $SystemVideoPath,
                                "videoupdatedtime" => date("Y-m-d H:i:s"),
                                "isdownloaded" => $IsDownloaded  
                            );
                            $GLOBALS['ISC_CLASS_DB']->InsertQuery("product_videos", $newVideo);   
                            $videoSort[] = $i;
                        }                    
                    }
                    
                    //Install Videos
                    $insVideoSort = array();
                    // First clear out any product videos that already exist (in case of a previous import etc)
                    $query = "DELETE FROM [|PREFIX|]install_videos
                    WHERE videoprodid='".$GLOBALS['ISC_CLASS_DB']->Quote($prodId)."' AND videotype='1'";
                    $GLOBALS['ISC_CLASS_DB']->Query($query);
                                        
                    // Next, try and add the videos
                    for ($i = 1; $i <= 10; $i++) {
                        if (isset($Videos["insvideo" . $i]) && $Videos["insvideo" . $i] != "") {
                                                        
                            $NewLink = $this->FormatLink($Videos['insvideo'.$i], 1);  
                            if($NewLink != "invalid")    {                                  
                                $SystemVideoPath = $this->DownloadVideo($NewLink); 
                                if($SystemVideoPath != 'failed')    {
                                    $IsDownloaded = 2; 
                                }
                                else    {
                                    $IsDownloaded = 3;
                                }
                            }
                            else    {
                                $SystemVideoPath = "";
                                $IsDownloaded = 4;
                            }
                                                        
                            // Store the video reference in the videos table
                            $newInsVideo = array(
                                "videoprodid" => $prodId,
                                "videofile" => $Videos['insvideo'.$i], 
                                "videotype" => 1, 
                                "videosort" => $i,
                                "videoaddedtime" => date("Y-m-d H:i:s"),
                                "systemvideofile" => $SystemVideoPath,
                                "videoupdatedtime" => date("Y-m-d H:i:s"),
                                "isdownloaded" => $IsDownloaded
                            );                   
                            $GLOBALS['ISC_CLASS_DB']->InsertQuery("install_videos", $newInsVideo);   
                            $insVideoSort[] = $i;
                        }
                    }        
                }      
                #### Block of codes Added by Simha Ends 
                
                #### Block of codes user videos Added by Simha
                // Build the queries for the user videos table -----
                if(isset($UserVideos) && !empty($UserVideos)) {
                    $userVideoSort = array();
                    // First clear out any product videos that already exist (in case of a previous import etc)
                    $query = "DELETE FROM [|PREFIX|]product_videos
                    WHERE videoprodid='".$GLOBALS['ISC_CLASS_DB']->Quote($prodId)."' AND videotype='2'";
                    $GLOBALS['ISC_CLASS_DB']->Query($query);
                    
                    // Next, try and add the full sized videos
                    for ($i = 1; $i <= 10; $i++) {
                        if (isset($UserVideos["uservideo" . $i]) && $UserVideos["uservideo" . $i] != "") {
                            // Store the video reference in the videos table
                            $newUserVideo = array(
                                "videoprodid" => $prodId,
                                "videofile" => $UserVideos['uservideo'.$i], 
                                "videotype" => 2, 
                                "videosort" => $i,
                                "videoaddedtime" => date("Y-m-d H:i:s"),
                                "isdownloaded" => 0,
                                "systemvideofile" => ''
                            );                   
                            $GLOBALS['ISC_CLASS_DB']->InsertQuery("product_videos", $newUserVideo);   
                            $userVideoSort[] = $i;
                        }                    
                    }
                    
                    $userInsVideoSort = array();
                    // First clear out any product videos that already exist (in case of a previous import etc)
                    $query = "DELETE FROM [|PREFIX|]install_videos
                    WHERE videoprodid='".$GLOBALS['ISC_CLASS_DB']->Quote($prodId)."' AND videotype='2'";
                    $GLOBALS['ISC_CLASS_DB']->Query($query);
                    
                    // Next, try and add the full sized videos
                    for ($i = 1; $i <= 10; $i++) {
                        if (isset($UserVideos["userinsvideo" . $i]) && $UserVideos["userinsvideo" . $i] != "") {
                            // Store the video reference in the videos table
                            $newUserInsVideo = array(
                                "videoprodid" => $prodId,
                                "videofile" => $UserVideos['userinsvideo'.$i], 
                                "videotype" => 2, 
                                "videosort" => $i,
                                "videoaddedtime" => date("Y-m-d H:i:s"),
                                "isdownloaded" => 0,
                                "systemvideofile" => ''
                            );                   
                            $GLOBALS['ISC_CLASS_DB']->InsertQuery("install_videos", $newUserInsVideo);   
                            $userInsVideoSort[] = $i;
                        }                    
                    }
                    
                }      
                #### Block of codes Added by Simha Ends
                
				// Save the product tags
				$this->SaveProductTags($Data['prodtags'], $prodId, true);
			}
			else {
				// Update the existing products details
				$prodId	= $Data['productid'] = (int)$ProductId;    


		        $query_price = "select  price_log, price_update_time from [|PREFIX|]products where productid ='$prodId'";
                $result_price = $GLOBALS["ISC_CLASS_DB"]->Query($query_price);
                $row_price = $GLOBALS["ISC_CLASS_DB"]->Fetch($result_price);
                $pricelog = $row_price['price_log'];             
		        $pricelogtime = $row_price['price_update_time'];

                $splitprice = split(',',$pricelog);
                $cntprice = count($splitprice);
                $cnt = $cntprice - 1;
                $oldprice = $splitprice[$cnt];

                if($oldprice != $Data['prodprice']) {
                    $Data['price_log'] =  $pricelog.",".$Data['prodprice'];  
           	        $Data['price_update_time'] = date('Y-m-d H:i:s');   
                }
                else {
                     $Data['price_log'] =  $pricelog;
                     $Data['price_update_time'] = $pricelogtime;
                }

                $Data['SKU_last_update_time'] = date('Y-m-d H:i:s');   
	            
                
				$entity = new ISC_ENTITY_PRODUCT();
                
				$entity->edit($Data);
                
				// Update the search data
				$GLOBALS['ISC_CLASS_DB']->UpdateQuery("product_search", $searchData, "productid='".$GLOBALS['ISC_CLASS_DB']->Quote($prodId)."'");
                
				if (isset($Data['prodcats']) && $Data['prodcats'] != null) {
					// Remove the existing category associations
					$query = sprintf("DELETE FROM [|PREFIX|]categoryassociations WHERE productid='%d'", $prodId);
					$GLOBALS['ISC_CLASS_DB']->Query($query);
				}
				
				// add the product info to the products_statistics -- Mingxing
				$statisticsdb = array(
									"prodname" => $Data['prodname'],
									"proddesc" => $Data['proddesc'],
									"prodcode" => $Data['prodcode'],
									"prodvendorprefix" =>$Data['prodvendorprefix'],
									"prodvendorid" => $Data['prodvendorid']
								);
				$GLOBALS['ISC_CLASS_DB']->UpdateQuery("products_statistics", $statisticsdb, "productid='".$GLOBALS['ISC_CLASS_DB']->Quote($prodId)."'");
				$query = sprintf("update [|PREFIX|]products set prodnumviews='".$row['prodnumviews']."', prodnumsold='".$row['prodnumsold']."', prodratingtotal='".$row['prodratingtotal']."', prodnumratings='".$row['prodnumratings']."'   where  productid='".$GLOBALS['ISC_CLASS_DB']->Quote($prodId)."'");
				$GLOBALS['ISC_CLASS_DB']->Query($query);
				//end -- Mingxing
                
                //Instruction file Changed by Simha
                if($_FILES['instruction_file']['name'] != "" && $_POST['delete_instruction_file'] != 1)    {
                    $ins_path =  "../instruction_file/".$_SESSION['temp_instruction_file'];
                    $query = "DELETE FROM [|PREFIX|]instruction_files WHERE instructionprodid='".$GLOBALS['ISC_CLASS_DB']->Quote($prodId)."'";
                    $GLOBALS['ISC_CLASS_DB']->Query($query);
                    @unlink($ins_path);
                    $tempart = $this->_StoreInsArtFileAndReturnId('instruction_file', 'instruction_file');   
                    $newInstructionFile = array(
                        "instructionprodid" => $prodId,
                        "instructionfile" => $tempart,
                        "instructiontype" => 2
                    );
                    $GLOBALS['ISC_CLASS_DB']->InsertQuery("instruction_files", $newInstructionFile);
                     $isContentChanged = 1;
                   
                }
                elseif($_POST['delete_instruction_file'] == 1)    {    
                    $ins_path =  "../instruction_file/".$_SESSION['temp_instruction_file'];
                    $query = "DELETE FROM [|PREFIX|]instruction_files WHERE instructionprodid='".$GLOBALS['ISC_CLASS_DB']->Quote($prodId)."'";
                    $GLOBALS['ISC_CLASS_DB']->Query($query);
                    @unlink($ins_path);
                     $isContentChanged = 1;
                }
                  
                //Article File  Changed by Simha  
                if($_FILES['article_file']['name'] != "" && $_POST['delete_article_file'] != 1)    {
                    $ins_path =  "../article_file/".$_SESSION['temp_article_file'];
                    $query = "DELETE FROM [|PREFIX|]article_files WHERE articleprodid='".$GLOBALS['ISC_CLASS_DB']->Quote($prodId)."'";
                    $GLOBALS['ISC_CLASS_DB']->Query($query);
                    @unlink($ins_path);
                    $tempart = $this->_StoreInsArtFileAndReturnId('article_file', 'article_file');   
                    $newArticleFile = array(
                        "articleprodid" => $prodId,
                        "articlefile" => $tempart,
                        "articletype" => 2
                    );
                    $GLOBALS['ISC_CLASS_DB']->InsertQuery("article_files", $newArticleFile);
                    $isContentChanged = 1;
                }
                elseif($_POST['delete_article_file'] == 1)    {    
                    $ins_path =  "../article_file/".$_SESSION['temp_article_file'];
                    $query = "DELETE FROM [|PREFIX|]article_files WHERE articleprodid='".$GLOBALS['ISC_CLASS_DB']->Quote($prodId)."'";
                    $GLOBALS['ISC_CLASS_DB']->Query($query);
                    @unlink($ins_path);
                    $isContentChanged = 1;
                }
              
				// Build the queries for the images table -----

				if(isset($Images) && !empty($Images)) {
					$currImages = $this->_GetImageData($prodId);
					$newImages = $this->_GetImageData();

					for($i = 1; $i <= 10; $i++) {

						if($_FILES["prodImage" . $i]['name'] == "") {
							// Do nothing -- leave the existing image
						}
						else if(isc_strtolower($_FILES["prodImage" . $i]['name']) == "none" && $i > 1) {
							// Remove the existing image
							unset($currImages["image" . $i]);
							unset($currImages["thumb" . $i]);				//For thumb by Simha
                            $isContentChanged = 1;
						} else {
							// It's a new image
							$currImages["image" . $i] = $Images["image" . $i];
                            $currImages["thumb" . $i] = $Images["thumb" . $i];  //For thumb by Simha
                            $isContentChanged = 1;
						}

						//For Install image by Simha
						
                        if($_FILES["installImage" . $i]['name'] == "") {
                            // Do nothing -- leave the existing image
                        }
                        else if(isc_strtolower($_FILES["installImage" . $i]['name']) == "none" && $i > 1) {
                            //Remove the existing image
                            unset($currImages["insimage" . $i]);
                            unset($currImages["insthumb" . $i]);
                            $isContentChanged = 1;
                        } else {
                            //It's a new image
                            $currImages["insimage" . $i] = $Images["insimage" . $i];
                            $currImages["insthumb" . $i] = $Images["insthumb" . $i];
                            $isContentChanged = 1;
                        }
                        
					}
					// Now the query for the thumbnail image
					if ($Images['thumb'] != "") {
						$currImages['thumb'] = $Images['thumb'];
					}

					if (isset($Images['tiny']) && $Images['tiny'] != "") {
						$currImages['tiny'] = $Images['tiny'];
					}


					// Build the query to delete current images -----
					$query = sprintf("delete from [|PREFIX|]product_images where imageprodid='%d'", $prodId);
					$GLOBALS['ISC_CLASS_DB']->Query($query);
					
                    // Build the query to delete current install images -----
                    $query = sprintf("delete from [|PREFIX|]install_images where imageprodid='%d'", $prodId);
                    $GLOBALS['ISC_CLASS_DB']->Query($query);    
                    
					for ($i = 1; $i <= 10; $i++) {
						if (isset($currImages["image" . $i])) {
							if( !isset($currImages["id" . $i]) || (isset($currImages["id" . $i]) && !isset($_POST["delete_image_" . $currImages["id" . $i]])) ) {
								$newImage = array(
									"imageprodid" => $prodId,
									"imagefile" => $currImages['image'.$i],
									"imageisthumb" => 0,
									"imagesort" => $i
								);
								$GLOBALS['ISC_CLASS_DB']->InsertQuery("product_images", $newImage);
								
								//Add thumbnail for each image
                                $newThumb = array(
                                    "imageprodid" => $prodId,
                                    "imagefile" => $currImages['thumb'.$i],
                                    "imageisthumb" => 3,                //new status of thumb for each images
                                    "imagesort" => $i
                                );     
                                  
                                $GLOBALS['ISC_CLASS_DB']->InsertQuery("product_images", $newThumb);

							}
                            if(isset($_POST["delete_image_" . $currImages["id" . $i]]))     {
                                $isContentChanged = 1;
                            }    
						}

						//Install Images by Simha
                        if (isset($currImages["insimage" . $i])) {
                            if( !isset($currImages["insid" . $i]) || (isset($currImages["insid" . $i]) && !isset($_POST["delete_insimage_" . $currImages["insid" . $i]])) ) {
                                $newImage = array(
                                    "imageprodid" => $prodId,
                                    "imagefile" => $currImages['insimage'.$i],
                                    "imageisthumb" => 0,
                                    "imagesort" => $i
                                );          
                                $GLOBALS['ISC_CLASS_DB']->InsertQuery("install_images", $newImage);
                                
                                //Add thumbnail for each image
                                $newThumb = array(
                                    "imageprodid" => $prodId,
                                    "imagefile" => $currImages['insthumb'.$i],
                                    "imageisthumb" => 3,                            //new status of thumb for each images
                                    "imagesort" => $i
                                );   
                                
                                $GLOBALS['ISC_CLASS_DB']->InsertQuery("install_images", $newThumb);   
                            }
                            
                            if(isset($_POST["delete_insimage_" . $currImages["insid" . $i]]))    {
                                $isContentChanged = 1;
                            }
                            
                        } 
					}
					// Add the thumbnail image
					// Now the query for the thumbnail image
					if(!isset($_POST['delete_image_thumb'])) {
						$thumbImage = array(
							"imageprodid" => $prodId,
							"imagefile" => $currImages['thumb'],
							"imageisthumb" => 1
						);
						$GLOBALS['ISC_CLASS_DB']->InsertQuery("product_images", $thumbImage);

						// And finally query for the tiny thumbnail image
						if(isset($currImages['tiny'])) {
							$tinyImage = array(
								"imageprodid" => $prodId,
								"imagefile" => $currImages['tiny'],
								"imageisthumb" => 2
							);
							$GLOBALS['ISC_CLASS_DB']->InsertQuery("product_images", $tinyImage);
						}
					}
				}

                #### Block of codes Added by Simha for Video  ######  
                // Build the queries for the videos table -----  
                if(isset($Videos) && !empty($Videos)) {
                    $currVideos = $this->_GetVideoData($prodId); 
                    $newVideos = $this->_GetVideoData();      
                                  
                    for($i = 0; $i <= 9; $i++) {

                        if(@$_POST["prodVideo"][$i] == "") {
                            //Do nothing -- leave the existing video
                        }
                        else if(isc_strtolower($_POST["prodVideo"][$i]) == "none" && $i > 1) {
                            //Remove the existing video
                            unset($currVideos["video" . ($i+1)]);
                            $isContentChanged = 1;
                        } else {   
                            
                            $NewLink = $this->FormatLink($Videos['video'.($i+1)], 1);  
                            
                            if($NewLink != "invalid")    {                                  
                                $SystemVideoPath = $this->DownloadVideo($NewLink); 
                                if($SystemVideoPath != 'failed')    {
                                    $IsDownloaded = 2; 
                                }
                                else    {
                                    $IsDownloaded = 3;
                                }
                            }
                            else    {
                                $SystemVideoPath = "";
                                $IsDownloaded = 4;
                            }      
                            
                            //It's a new video
                            $currVideos["video" . ($i+1)]               = $Videos["video" . ($i+1)];
                            $currVideos["addedtime" . ($i+1)]           = date("Y-m-d H:i:s");     
                            $currVideos["systemvideofile" . ($i+1)]     = $SystemVideoPath;
                            $currVideos["videoupdatedtime" . ($i+1)]    = date("Y-m-d H:i:s"); 
                            $currVideos["isdownloaded" . ($i+1)]        = $IsDownloaded;
                            $isContentChanged = 1;
                        }
                            
                        //For install videos
                        if(@$_POST["insVideo"][$i] == "") {
                            //Do nothing -- leave the existing video
                        }
                        else if(isc_strtolower($_POST["insVideo"][$i]) == "none" && $i > 1) {
                            //Remove the existing video
                            unset($currVideos["insvideo" . ($i+1)]);
                            $isContentChanged = 1; 
                        } else {
                            
                            $NewLink = $this->FormatLink($Videos['insvideo'.($i+1)], 1);  
                            if($NewLink != "invalid")    {                                  
                                $SystemVideoPath = $this->DownloadVideo($NewLink, FT_INSVIDEO); 
                                if($SystemVideoPath != 'failed')    {
                                    $IsDownloaded = 2; 
                                }
                                else    {
                                    $IsDownloaded = 3;
                                }
                            }
                            else    {
                                $SystemVideoPath = "";
                                $IsDownloaded = 4;
                            }
                            
                            //It's a new video
                            $currVideos["insvideo" . ($i+1)]                = $Videos["insvideo" . ($i+1)];
                            $currVideos["insaddedtime" . ($i+1)]            = date("Y-m-d H:i:s");  
                            $currVideos["inssystemvideofile" . ($i+1)]      = $SystemVideoPath;
                            $currVideos["insvideoupdatedtime" . ($i+1)]     = date("Y-m-d H:i:s");   
                            $currVideos["insisdownloaded" . ($i+1)]         = $IsDownloaded; 
                            
                            $isContentChanged = 1;
                            
                        }
                        
                    }
                    
                    // Build the query to delete current videos -----
                    $query = sprintf("delete from [|PREFIX|]product_videos where videoprodid='%d' AND videotype='1'", $prodId);
                    $GLOBALS['ISC_CLASS_DB']->Query($query);
                    
                    for ($i = 1; $i <= 10; $i++) {
                        if (isset($currVideos["video" . $i])) {
                            if( !isset($currVideos["id" . $i]) || (isset($currVideos["id" . $i]) && !isset($_POST["delete_video_" . $currVideos["id" . $i]])) ) {
                                $newVideo = array(
                                    "videoprodid" => $prodId,
                                    "videofile" => $currVideos['video'.$i],
                                    "videotype" => 1,
                                    "videosort" => $i,
                                    "videoaddedtime" => $currVideos['addedtime'.$i],
                                    "isdownloaded" => $currVideos["isdownloaded" . $i],
                                    "systemvideofile" => $currVideos["systemvideofile" . $i]
                                );
                                $GLOBALS['ISC_CLASS_DB']->InsertQuery("product_videos", $newVideo);  
                            }
                        }             
                    }     
                }
                 
                // Build the query to delete current install videos -----
                $query = sprintf("delete from [|PREFIX|]install_videos where videoprodid='%d' AND videotype='1'", $prodId);
                $GLOBALS['ISC_CLASS_DB']->Query($query);
                
                for ($i = 1; $i <= 10; $i++) {
                    if (isset($currVideos["insvideo" . $i])) {
                        if( !isset($currVideos["insid" . $i]) || (isset($currVideos["insid" . $i]) && !isset($_POST["delete_insvideo_" . $currVideos["insid" . $i]])) ) {
                            $newVideo = array(
                                "videoprodid" => $prodId,
                                "videofile" => $currVideos['insvideo'.$i],
                                "videotype" => 1,
                                "videosort" => $i,
                                "videoaddedtime" => $currVideos['insaddedtime'.$i],
                                "isdownloaded" => $currVideos["insisdownloaded" . $i],
                                "systemvideofile" => $currVideos["inssystemvideofile" . $i]
                            );
                            $GLOBALS['ISC_CLASS_DB']->InsertQuery("install_videos", $newVideo);  
                        }
                        
                        if(isset($_POST["delete_insvideo_" . $currVideos["insid" . $i]]))   {
                            $isContentChanged = 1;
                        }
                    }
                }
                
                #### Block of codes Added by Simha Ends #####
                
                #### Block of codes for user video Added by Simha  ######    
                // Build the queries for the videos table -----  
                if(isset($UserVideos) && !empty($UserVideos)) {
                    $currUserVideos = $this->_GetUserVideoData($prodId); 
                    //$newUserVideos = $this->_GetUserVideoData();     
                    $newUserVideos = $UserVideos;
                    
                    for($i = 0; $i <= 9; $i++) {   
                        if(@$_FILES["userVideo"]['name'][$i] == "") {
                            //Do nothing -- leave the existing video
                        }
                        else if(isc_strtolower($_FILES["userVideo"]['name'][$i]) == "none" && $i > 1) {
                            //Remove the existing video
                            unset($currUserVideos["video" . ($i+1)]);
                            $isContentChanged = 1;
                        } else {
                            //It's a new video
                            $currUserVideos["uservideo" . ($i+1)]       = $UserVideos["uservideo" . ($i+1)];
                            $currUserVideos["addedtime" . ($i+1)]       = date("Y-m-d H:i:s");   
                            $currUserVideos["isdownloaded" . ($i+1)]    = 0;
                            $isContentChanged = 1;
                        }
                        
                        //Added by Simha for user install videos
                        if(@$_FILES["userInsVideo"]['name'][$i] == "") {
                            //Do nothing -- leave the existing video
                        }
                        else if(isc_strtolower($_FILES["userInsVideo"]['name'][$i]) == "none" && $i > 1) {
                            //Remove the existing video
                            unset($currUserVideos["insvideo" . ($i+1)]);
                            $isContentChanged = 1;
                        } else {
                            //It's a new video
                            $currUserVideos["userinsvideo" . ($i+1)]       = $UserVideos["userinsvideo" . ($i+1)];
                            $currUserVideos["insaddedtime" . ($i+1)]       = date("Y-m-d H:i:s");   
                            $currUserVideos["insisdownloaded" . ($i+1)]    = 0;
                            $isContentChanged = 1;
                        }
                              
                    }
                    
                    // Build the query to delete current videos -----
                    $query = sprintf("delete from [|PREFIX|]product_videos where videoprodid='%d' AND videotype='2'", $prodId);
                    $GLOBALS['ISC_CLASS_DB']->Query($query);      
                    
                    for ($i = 1; $i <= 10; $i++) {                    
                        if (isset($currUserVideos["uservideo" . $i])) {
                            if( !isset($currUserVideos["uservideoid" . $i]) || (isset($currUserVideos["uservideoid" . $i]) && !isset($_POST["delete_uservideo_" . $currUserVideos["uservideoid" . $i]])) ) {
                                $newUserVideo = array(
                                    "videoprodid" => $prodId,
                                    "videofile" => $currUserVideos['uservideo'.$i],
                                    "videotype" => 2,
                                    "videosort" => $i,
                                    "videoaddedtime" => $currUserVideos['addedtime'.$i],
                                    "isdownloaded" => $currUserVideos["isdownloaded" . $i],
                                    "systemvideofile" => $currUserVideos["systemvideofile" . $i]
                                );                                
                                $GLOBALS['ISC_CLASS_DB']->InsertQuery("product_videos", $newUserVideo);  
                            }
                            if(isset($_POST["delete_uservideo_" . $currUserVideos["uservideoid" . $i]]))
                            {
                                 $isContentChanged = 1;
                            }
                        }             
                    }
                    
                    // Build the query to delete current user install videos -----
                    $query = sprintf("delete from [|PREFIX|]install_videos where videoprodid='%d' AND videotype='2'", $prodId);
                    $GLOBALS['ISC_CLASS_DB']->Query($query);
                    
                    for ($i = 1; $i <= 10; $i++) {                    
                        if (isset($currUserVideos["userinsvideo" . $i])) {
                            if( !isset($currUserVideos["userinsvideoid" . $i]) || (isset($currUserVideos["userinsvideoid" . $i]) && !isset($_POST["delete_userinsvideo_" . $currUserVideos["userinsvideoid" . $i]])) ) {
                                $newUserInsVideo = array(
                                    "videoprodid" => $prodId,
                                    "videofile" => $currUserVideos['userinsvideo'.$i],
                                    "videotype" => 2,
                                    "videosort" => $i,
                                    "videoaddedtime" => $currUserVideos['insaddedtime'.$i],
                                    "isdownloaded" => $currUserVideos["insisdownloaded" . $i],
                                    "systemvideofile" => $currUserVideos["inssystemvideofile" . $i]
                                );
                                $GLOBALS['ISC_CLASS_DB']->InsertQuery("install_videos", $newUserInsVideo);  
                                
                            }
                        
                            if(isset($_POST["delete_userinsvideo_" . $currUserVideos["userinsvideoid" . $i]]))  {
                                 $isContentChanged = 1;
                            }
                            
                        }
                    }
                             
                }
                
                
                if($isContentChanged && !$isContentChangeAdded)    {
                    $query = "INSERT INTO `isc_changes_report`(`changeprodid`,`changetype`,`changedtime`) VALUES ('$ProductId','content',NOW())";
                    $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
                }
                
                
                #### Block of codes for user video Added by Simha Ends #####
                
				// Save the product tags
				$this->SaveProductTags($Data['prodtags'], $ProductId, false);

				if($_POST['hdnname'] == 'hdnsave') {
                    header("Location: index.php?ToDo=editProduct&productId=$prodId");
                    exit;
                }
			}
            
			// Build the queries for the category associations table -----
			$accessibleCategories = array();
			if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
				$vendorInfo = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendor();
				if($vendorInfo['vendoraccesscats']) {
					$accessibleCategories = explode(',', $vendorInfo['vendoraccesscats']);
				}
			}
			if(isset($Data['prodcats'])) {
				foreach ($Data['prodcats'] as $cat) {
					// If this user doesn't have permission to place products in this category, skip over it
					if(!empty($accessibleCategories) && !in_array($cat, $accessibleCategories)) {
						continue;
					}

					if ($cat != -2)
					{
						$newAssociation = array(
							"productid" => $prodId,
							"categoryid" => $cat
						);
						$GLOBALS['ISC_CLASS_DB']->InsertQuery("categoryassociations", $newAssociation);
					}
				}
			}
            
			/**
			 * Was this product commited from the batch importer? If so then exit now or we'll ruin all the other product linked tables
			 */
			if ($isImport) {
				if($GLOBALS["ISC_CLASS_DB"]->GetErrorMsg() == "") {
					// The product was commited successfully, commit the transaction
					$GLOBALS["ISC_CLASS_DB"]->Query("commit");
					return true;
				}
				else {
					// The product commit failed
					$GLOBALS["ISC_CLASS_DB"]->Query("rollback");
					return false;
				}
			}

			// Build the queries for the product variation combinations table -----
			$sumCurrent = 0;
			$sumLow = 0;
              
			/**
			 * Associated any hashed variations with the new product ID
			 */
			if (isset($Data['prodhash']) && $Data['prodhash'] !== '') {
				$savedata = array(
					'vcproductid' => $prodId,
					'vcproducthash' => ''
				);

				$GLOBALS['ISC_CLASS_DB']->UpdateQuery('product_variation_combinations', $savedata, "vcproducthash='" . $GLOBALS['ISC_CLASS_DB']->Quote($Data['prodhash']) . "'");
			}

			if(isset($Data['prodvariationid']) && $Data['prodvariationid'] != 0 && isset($Variations) && is_array($Variations)) {
				// Are we updating an existing variation, or creating a totally new one?
				if($Data['productVariationExisting'] == $Data['prodvariationid']) {
					// We're updating an existing variation
					foreach($Variations as $Variation) {
						// First up, do we need to delete the image?
						if($Variation['vcimage'] == "REMOVE") {
							// Yes, get the image details
							$query = sprintf("SELECT vcimage, vcthumb FROM [|PREFIX|]product_variation_combinations WHERE combinationid='%d'", $Variation['combinationid']);
							$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);

							if($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
								@unlink(APP_ROOT."/../".GetConfig('ImageDirectory')."/".$row['vcimage']);
								@unlink(APP_ROOT."/../".GetConfig('ImageDirectory')."/".$row['vcthumb']);
							}
						}

						// Now update the record
						$updatedCombo = array(
							"vcproductid" => $prodId,
							"vcvariationid" => $Variation['vcvariationid'],
							"vcenabled" => $Variation['vcenabled'],
							"vcoptionids" => $Variation['vcoptionids'],
							"vcsku" => $Variation['vcsku'],
							"vcpricediff" => $Variation['vcpricediff'],
							"vcprice" => $Variation['vcprice'],
							"vcweightdiff" => $Variation['vcweightdiff'],
							"vcweight" => $Variation['vcweight'],
							"vcstock" => $Variation['vcstock'],
							"vclowstock" => $Variation['vclowstock']
						);

						// Only update the images if they've changed
						if($Variation['vcimage'] == "REMOVE") {
							$updatedCombo['vcimage'] = "";
							$updatedCombo['vcthumb'] = "";
						}
						else if($Variation['vcimage'] != "") {
							$updatedCombo['vcimage'] = $Variation['vcimage'];
							$updatedCombo['vcthumb'] = $Variation['vcthumb'];
						}

						$GLOBALS['ISC_CLASS_DB']->UpdateQuery("product_variation_combinations", $updatedCombo, "combinationid='".$GLOBALS['ISC_CLASS_DB']->Quote($Variation['combinationid'])."'");
						$sumCurrent += $Variation['vcstock'];
						$sumLow += $Variation['vclowstock'];
					}
				}
				else {
					// If it's an existing product then we need to delete all of the variation combinations, images, etc
					if($Data['productVariationExisting'] > 0) {
						$this->_DeleteVariationCombinationsForProduct($prodId);
					}

					// We're adding a new variation
					foreach($Variations as $Variation) {
						$newCombo = array(
							"vcproductid" => $prodId,
							"vcvariationid" => $Variation['vcvariationid'],
							"vcenabled" => $Variation['vcenabled'],
							"vcoptionids" => $Variation['vcoptionids'],
							"vcsku" => $Variation['vcsku'],
							"vcpricediff" => $Variation['vcpricediff'],
							"vcprice" => $Variation['vcprice'],
							"vcweightdiff" => $Variation['vcweightdiff'],
							"vcweight" => $Variation['vcweight'],
							"vcimage" => $Variation['vcimage'],
							"vcthumb" => $Variation['vcthumb'],
							"vcstock" => $Variation['vcstock'],
							"vclowstock" => $Variation['vclowstock']
						);
						$GLOBALS['ISC_CLASS_DB']->InsertQuery("product_variation_combinations", $newCombo);
						$sumCurrent += $Variation['vcstock'];
						$sumLow += $Variation['vclowstock'];
					}
				}

				// If the inventory tracking is happening per product variation then we need to add
				// the current and low stock level sums to the products table
				if ($Data['prodinvtrack'] == 2) {
					$updatedProduct = array(
						"prodcurrentinv" => $sumCurrent,
						"prodlowinv" => $sumLow
					);
					$GLOBALS['ISC_CLASS_DB']->UpdateQuery("products", $updatedProduct,  "productid='".$GLOBALS['ISC_CLASS_DB']->Quote($prodId)."'");
				}
			}
			else {
				// If it's an existing product then we need to delete all of the variation combinations, images, etc
				if($prodId > 0) {
					$this->_DeleteVariationCombinationsForProduct($prodId);
				}
			}
            
			// Build the queries for the custom fields table -----
			$GLOBALS['ISC_CLASS_DB']->Query("DELETE FROM [|PREFIX|]product_customfields WHERE fieldprodid='".$GLOBALS['ISC_CLASS_DB']->Quote((int) $prodId)."'");
			if (!empty($CustomFields)) {
				foreach ($CustomFields as $c) {
					$newField = array(
						"fieldprodid" => $prodId,
						"fieldname" => $c['name'],
						"fieldvalue" => $c['value']
					);
					$GLOBALS['ISC_CLASS_DB']->InsertQuery("product_customfields", $newField);
				}
			}

			$this->_SaveProductFields($ProductFields, $prodId);

			// Upload any product downloads if we have them
			if(isset($_FILES) && isset($_FILES['newdownload']) && isset($_FILES['newdownload']['name']) && $_FILES['newdownload']['name'] != '') {
				$this->SaveProductDownload($err);
			}

			// Associate any product images and downloads which were uploaded earlier with this product
			if(isset($Data['prodhash']) && $Data['prodhash'] !== '') {
				$updateImages = array(
					"imageprodid" => $prodId,
					"imageprodhash" => ''
				);
				$GLOBALS['ISC_CLASS_DB']->UpdateQuery("product_images", $updateImages, "imageprodhash='".$GLOBALS['ISC_CLASS_DB']->Quote($Data['prodhash'])."'".$updateImageQuery);

				$updatedDownloads = array(
					"productid" => $prodId,
					"prodhash" => ''
				);
				$GLOBALS['ISC_CLASS_DB']->UpdateQuery("product_downloads", $updatedDownloads, "prodhash='".$GLOBALS['ISC_CLASS_DB']->Quote($Data['prodhash'])."'");
			}

			// Now we add our discount rules
			$GLOBALS['ISC_CLASS_DB']->DeleteQuery('product_discounts', 'WHERE discountprodid=' . (int)$prodId);

			// If we have variations then do not process them
			if((!isset($Data['prodvariationid']) || !isId($Data['prodvariationid'])) && empty($Variations)) {
				foreach ($DiscountRules as $rule) {

					// If the min and max quantities are astrixes then convert them to 0
					if ($rule['quantitymin'] == '*') {
						$rule['quantitymin'] = 0;
					}

					if ($rule['quantitymax'] == '*') {
						$rule['quantitymax'] = 0;
					}

					// Change the type of the amount, just in case
					if (isc_strtolower($rule['type']) == 'percent') {
						$rule['amount'] = (int)$rule['amount'];
					} else {
						$rule['amount'] = (float)$rule['amount'];
					}

					$newRule = array(
						'discountprodid' => (int)$prodId,
						'discountquantitymin' => (int)$rule['quantitymin'],
						'discountquantitymax' => (int)$rule['quantitymax'],
						'discounttype' => isc_strtolower($rule['type']),
						'discountamount' => DefaultPriceFormat($rule['amount'])
					);

					$GLOBALS['ISC_CLASS_DB']->InsertQuery('product_discounts', $newRule);
				}
			}                
            
			if($GLOBALS["ISC_CLASS_DB"]->GetErrorMsg() == "") {
				// The product was commited successfully, commit the transaction
				$GLOBALS["ISC_CLASS_DB"]->Query("commit");                 
				return true;
			}
			else {
                $Err .= $GLOBALS["ISC_CLASS_DB"]->GetErrorMsg();  
				// The product commit failed
				$GLOBALS["ISC_CLASS_DB"]->Query("rollback");
				return false;
			}
		}

	//this function added by blessen only for import

	public function _CommitImportProduct($ProductId, &$Data, &$Images, &$Variations, &$CustomFields, $DiscountRules=array(), &$Err = null, &$ProductFields=array(), $isImport=false)
		{
			// Commit the details for the product to the database
			$query = "";
			$err = null;
			$searchData = array(
				"prodname" => $Data['prodname'],
				"prodcode" => $Data['prodcode'],
				"proddesc" => $Data['proddesc'],
				"prodsearchkeywords" => $Data['prodsearchkeywords']
			);

			// Start the transaction
			$GLOBALS["ISC_CLASS_DB"]->Query("start transaction");
			$updateImageQuery = "";

			if ($ProductId == 0) {
				// Add the date this product was modified
				$entity = new ISC_ENTITY_PRODUCT();
				$prodId	= $entity->add($Data);

				$GLOBALS['NewProductId'] = $prodId;

				// ---- Build the query for the product_search table ----
				$searchData['productid'] = $prodId;
				$GLOBALS['ISC_CLASS_DB']->InsertQuery("product_search", $searchData);

				// Build the queries for the images table -----
				if(isset($Images) && !empty($Images)) {
					$imageSort = array();
					// First clear out any product images that already exist (in case of a previous import etc)
					$query = "DELETE FROM [|PREFIX|]product_images
					WHERE imageprodid='".$GLOBALS['ISC_CLASS_DB']->Quote($prodId)."'";
					$GLOBALS['ISC_CLASS_DB']->Query($query);

					// Next, try and add the full sized images
					for ($i = 1; $i <= 5; $i++) {
						if (isset($Images["image" . $i]) && $Images["image" . $i] != "") {
							// Store the image reference in the images table
							$newImage = array(
								"imageprodid" => $prodId,
								"imagefile" => $Images['image'.$i],
								"imageisthumb" => 0,
								"imagesort" => $i
							);
							$GLOBALS['ISC_CLASS_DB']->InsertQuery("product_images", $newImage);
							$imageSort[] = $i;
						}
					}

					if (!empty($imageSort)) {
						$updateImageQuery .= " AND imagesort not in (".implode(",", $imageSort).")";
					}

					// Now the query for the thumbnail image
					if (isset($Images['thumb']) && !empty($Images['thumb'])) {
						$thumbImage = array(
							"imageprodid" => $prodId,
							"imagefile" => $Images['thumb'],
							"imageisthumb" => 1
						);
						$GLOBALS['ISC_CLASS_DB']->InsertQuery("product_images", $thumbImage);
						if($Images['thumb'] != '') {
							$updateImageQuery .= " AND imageisthumb!=1";
						}
					}

					// And finally query for the tiny thumbnail image
					if (isset($Images['tiny']) && !empty($Images['tiny'])) {
						$tinyImage = array(
							"imageprodid" => $prodId,
							"imagefile" => $Images['tiny'],
							"imageisthumb" => 2
						);
						$GLOBALS['ISC_CLASS_DB']->InsertQuery("product_images", $tinyImage);

						if($Images['tiny'] != '') {
							$updateImageQuery .= " AND imageisthumb!=2";
						}
					}
				}
				// Set some $_GET variables so the newest product appears at the top of the list
				$_GET['sortField'] = "productid";
				$_GET['sortOrder'] = "desc";

				// Save the product tags
				$this->SaveProductTags($Data['prodtags'], $prodId, true);
			}
			else {
				// Update the existing products details
				$prodId	= $Data['productid'] = (int)$ProductId;
				$entity = new ISC_ENTITY_PRODUCT();
				$entity->edit($Data);

				// Update the search data
				$GLOBALS['ISC_CLASS_DB']->UpdateQuery("product_search", $searchData, "productid='".$GLOBALS['ISC_CLASS_DB']->Quote($prodId)."'");

				if (isset($Data['prodcats']) && $Data['prodcats'] != null) {
					// Remove the existing category associations
					$query = sprintf("DELETE FROM [|PREFIX|]categoryassociations WHERE productid='%d'", $prodId);
					$GLOBALS['ISC_CLASS_DB']->Query($query);
				}

				// Build the queries for the images table -----

				if(isset($Images) && !empty($Images)) {
					$currImages = $this->_GetImageData($prodId);
					$newImages = $this->_GetImageData();

					for($i = 1; $i <= 5; $i++) {

						if($_FILES["prodImage" . $i]['name'] == "") {
							// Do nothing -- leave the existing image
						}
						else if(isc_strtolower($_FILES["prodImage" . $i]['name']) == "none" && $i > 1) {
							// Remove the existing image
							unset($currImages["image" . $i]);
						} else {
							// It's a new image
							$currImages["image" . $i] = $Images["image" . $i];
						}
					}
					// Now the query for the thumbnail image
					if ($Images['thumb'] != "") {
						$currImages['thumb'] = $Images['thumb'];
					}

					if (isset($Images['tiny']) && $Images['tiny'] != "") {
						$currImages['tiny'] = $Images['tiny'];
					}


					// Build the query to delete current images -----
					$query = sprintf("delete from [|PREFIX|]product_images where imageprodid='%d'", $prodId);
					$GLOBALS['ISC_CLASS_DB']->Query($query);

					for ($i = 1; $i <= 5; $i++) {
						if (isset($currImages["image" . $i])) {
							if( !isset($currImages["id" . $i]) || (isset($currImages["id" . $i]) && !isset($_POST["delete_image_" . $currImages["id" . $i]])) ) {
								$newImage = array(
									"imageprodid" => $prodId,
									"imagefile" => $currImages['image'.$i],
									"imageisthumb" => 0,
									"imagesort" => $i
								);
								$GLOBALS['ISC_CLASS_DB']->InsertQuery("product_images", $newImage);
							}
						}
					}
					// Add the thumbnail image
					// Now the query for the thumbnail image
					if(!isset($_POST['delete_image_thumb'])) {
						$thumbImage = array(
							"imageprodid" => $prodId,
							"imagefile" => $currImages['thumb'],
							"imageisthumb" => 1
						);
						$GLOBALS['ISC_CLASS_DB']->InsertQuery("product_images", $thumbImage);

						// And finally query for the tiny thumbnail image
						if(isset($currImages['tiny'])) {
							$tinyImage = array(
								"imageprodid" => $prodId,
								"imagefile" => $currImages['tiny'],
								"imageisthumb" => 2
							);
							$GLOBALS['ISC_CLASS_DB']->InsertQuery("product_images", $tinyImage);
						}
					}
				}

				// Save the product tags
				$this->SaveProductTags($Data['prodtags'], $ProductId, false);
			}

			// Build the queries for the category associations table -----
			$accessibleCategories = array();
			if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
				$vendorInfo = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendor();
				if($vendorInfo['vendoraccesscats']) {
					$accessibleCategories = explode(',', $vendorInfo['vendoraccesscats']);
				}
			}
			if(isset($Data['prodcats']) and $Data['prodcats'] != "") {
				foreach ($Data['prodcats'] as $cat) {
					// If this user doesn't have permission to place products in this category, skip over it
					if(!empty($accessibleCategories) && !in_array($cat, $accessibleCategories)) {
						continue;
					}
					$newAssociation = array(
						"productid" => $prodId,
						"categoryid" => $cat
					);
					$GLOBALS['ISC_CLASS_DB']->InsertQuery("categoryassociations", $newAssociation);
				}
			}

			/**
			 * Was this product commited from the batch importer? If so then exit now or we'll ruin all the other product linked tables
			 */
			if ($isImport) {
				if($GLOBALS["ISC_CLASS_DB"]->GetErrorMsg() == "") {
					// The product was commited successfully, commit the transaction
					$GLOBALS["ISC_CLASS_DB"]->Query("commit");
					return true;
				}
				else {
					// The product commit failed
					$GLOBALS["ISC_CLASS_DB"]->Query("rollback");
					return false;
				}
			}

			// Build the queries for the product variation combinations table -----
			$sumCurrent = 0;
			$sumLow = 0;

			/**
			 * Associated any hashed variations with the new product ID
			 */
			if (isset($Data['prodhash']) && $Data['prodhash'] !== '') {
				$savedata = array(
					'vcproductid' => $prodId,
					'vcproducthash' => ''
				);

				$GLOBALS['ISC_CLASS_DB']->UpdateQuery('product_variation_combinations', $savedata, "vcproducthash='" . $GLOBALS['ISC_CLASS_DB']->Quote($Data['prodhash']) . "'");
			}

			if(isset($Data['prodvariationid']) && $Data['prodvariationid'] != 0 && isset($Variations) && is_array($Variations)) {
				// Are we updating an existing variation, or creating a totally new one?
				if($Data['productVariationExisting'] == $Data['prodvariationid']) {
					// We're updating an existing variation
					foreach($Variations as $Variation) {
						// First up, do we need to delete the image?
						if($Variation['vcimage'] == "REMOVE") {
							// Yes, get the image details
							$query = sprintf("SELECT vcimage, vcthumb FROM [|PREFIX|]product_variation_combinations WHERE combinationid='%d'", $Variation['combinationid']);
							$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);

							if($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
								@unlink(APP_ROOT."/../".GetConfig('ImageDirectory')."/".$row['vcimage']);
								@unlink(APP_ROOT."/../".GetConfig('ImageDirectory')."/".$row['vcthumb']);
							}
						}

						// Now update the record
						$updatedCombo = array(
							"vcproductid" => $prodId,
							"vcvariationid" => $Variation['vcvariationid'],
							"vcenabled" => $Variation['vcenabled'],
							"vcoptionids" => $Variation['vcoptionids'],
							"vcsku" => $Variation['vcsku'],
							"vcpricediff" => $Variation['vcpricediff'],
							"vcprice" => $Variation['vcprice'],
							"vcweightdiff" => $Variation['vcweightdiff'],
							"vcweight" => $Variation['vcweight'],
							"vcstock" => $Variation['vcstock'],
							"vclowstock" => $Variation['vclowstock']
						);

						// Only update the images if they've changed
						if($Variation['vcimage'] == "REMOVE") {
							$updatedCombo['vcimage'] = "";
							$updatedCombo['vcthumb'] = "";
						}
						else if($Variation['vcimage'] != "") {
							$updatedCombo['vcimage'] = $Variation['vcimage'];
							$updatedCombo['vcthumb'] = $Variation['vcthumb'];
						}

						$GLOBALS['ISC_CLASS_DB']->UpdateQuery("product_variation_combinations", $updatedCombo, "combinationid='".$GLOBALS['ISC_CLASS_DB']->Quote($Variation['combinationid'])."'");
						$sumCurrent += $Variation['vcstock'];
						$sumLow += $Variation['vclowstock'];
					}
				}
				else {
					// If it's an existing product then we need to delete all of the variation combinations, images, etc
					if($Data['productVariationExisting'] > 0) {
						$this->_DeleteVariationCombinationsForProduct($prodId);
					}

					// We're adding a new variation
					foreach($Variations as $Variation) {
						$newCombo = array(
							"vcproductid" => $prodId,
							"vcvariationid" => $Variation['vcvariationid'],
							"vcenabled" => $Variation['vcenabled'],
							"vcoptionids" => $Variation['vcoptionids'],
							"vcsku" => $Variation['vcsku'],
							"vcpricediff" => $Variation['vcpricediff'],
							"vcprice" => $Variation['vcprice'],
							"vcweightdiff" => $Variation['vcweightdiff'],
							"vcweight" => $Variation['vcweight'],
							"vcimage" => $Variation['vcimage'],
							"vcthumb" => $Variation['vcthumb'],
							"vcstock" => $Variation['vcstock'],
							"vclowstock" => $Variation['vclowstock']
						);
						$GLOBALS['ISC_CLASS_DB']->InsertQuery("product_variation_combinations", $newCombo);
						$sumCurrent += $Variation['vcstock'];
						$sumLow += $Variation['vclowstock'];
					}
				}

				// If the inventory tracking is happening per product variation then we need to add
				// the current and low stock level sums to the products table
				if ($Data['prodinvtrack'] == 2) {
					$updatedProduct = array(
						"prodcurrentinv" => $sumCurrent,
						"prodlowinv" => $sumLow
					);
					$GLOBALS['ISC_CLASS_DB']->UpdateQuery("products", $updatedProduct,  "productid='".$GLOBALS['ISC_CLASS_DB']->Quote($prodId)."'");
				}
			}
			else {
				// If it's an existing product then we need to delete all of the variation combinations, images, etc
				if($prodId > 0) {
					$this->_DeleteVariationCombinationsForProduct($prodId);
				}
			}

			// Build the queries for the custom fields table -----
			$GLOBALS['ISC_CLASS_DB']->Query("DELETE FROM [|PREFIX|]product_customfields WHERE fieldprodid='".$GLOBALS['ISC_CLASS_DB']->Quote((int) $prodId)."'");
			if (!empty($CustomFields)) {
				foreach ($CustomFields as $c) {
					$newField = array(
						"fieldprodid" => $prodId,
						"fieldname" => $c['name'],
						"fieldvalue" => $c['value']
					);
					$GLOBALS['ISC_CLASS_DB']->InsertQuery("product_customfields", $newField);
				}
			}

			$this->_SaveProductFields($ProductFields, $prodId);

			// Upload any product downloads if we have them
			if(isset($_FILES) && isset($_FILES['newdownload']) && isset($_FILES['newdownload']['name']) && $_FILES['newdownload']['name'] != '') {
				$this->SaveProductDownload($err);
			}

			// Associate any product images and downloads which were uploaded earlier with this product
			if(isset($Data['prodhash']) && $Data['prodhash'] !== '') {
				$updateImages = array(
					"imageprodid" => $prodId,
					"imageprodhash" => ''
				);
				$GLOBALS['ISC_CLASS_DB']->UpdateQuery("product_images", $updateImages, "imageprodhash='".$GLOBALS['ISC_CLASS_DB']->Quote($Data['prodhash'])."'".$updateImageQuery);

				$updatedDownloads = array(
					"productid" => $prodId,
					"prodhash" => ''
				);
				$GLOBALS['ISC_CLASS_DB']->UpdateQuery("product_downloads", $updatedDownloads, "prodhash='".$GLOBALS['ISC_CLASS_DB']->Quote($Data['prodhash'])."'");
			}

			// Now we add our discount rules
			$GLOBALS['ISC_CLASS_DB']->DeleteQuery('product_discounts', 'WHERE discountprodid=' . (int)$prodId);

			// If we have variations then do not process them
			if((!isset($Data['prodvariationid']) || !isId($Data['prodvariationid'])) && empty($Variations)) {
				foreach ($DiscountRules as $rule) {

					// If the min and max quantities are astrixes then convert them to 0
					if ($rule['quantitymin'] == '*') {
						$rule['quantitymin'] = 0;
					}

					if ($rule['quantitymax'] == '*') {
						$rule['quantitymax'] = 0;
					}

					// Change the type of the amount, just in case
					if (isc_strtolower($rule['type']) == 'percent') {
						$rule['amount'] = (int)$rule['amount'];
					} else {
						$rule['amount'] = (float)$rule['amount'];
					}

					$newRule = array(
						'discountprodid' => (int)$prodId,
						'discountquantitymin' => (int)$rule['quantitymin'],
						'discountquantitymax' => (int)$rule['quantitymax'],
						'discounttype' => isc_strtolower($rule['type']),
						'discountamount' => DefaultPriceFormat($rule['amount'])
					);

					$GLOBALS['ISC_CLASS_DB']->InsertQuery('product_discounts', $newRule);
				}
			}

			if($GLOBALS["ISC_CLASS_DB"]->GetErrorMsg() == "") {
				// The product was commited successfully, commit the transaction
				$GLOBALS["ISC_CLASS_DB"]->Query("commit");
				return true;
			}
			else {
				// The product commit failed
				$GLOBALS["ISC_CLASS_DB"]->Query("rollback");
				return false;
			}
		}

		//this function added by blessen only for import













		public function DoDeleteProducts($ids)
		{
			if(!is_array($ids)) {
				$ids = array($ids);
			}

			foreach ($ids as $key=>$id) {
				if (!is_numeric($id) || $id<=0) {
					unset($ids[$key]);
				}
			}

			// Start a transaction
			$GLOBALS["ISC_CLASS_DB"]->Query("start transaction");

			// The products and related data will be removed from the following tables:
			//
			//     - Products
			//     - CategoryAssociations
			//     - Product_CustomFields
			//     - Product_Images
			//     - Product_Variation_Combinations
			//     - Product_Downloads
			//		- product_configurable_fields
// added by blessen
// -isc_qalifiers
// - isc_import_variations


			// What we do here is feed the list of product IDs in to a query with the vendor applied so that way
			// we're sure we're only deleting products this user has permission to delete.
			$prodids = implode("','", array_map('intval', $ids));
			$vendorId = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId();
			
			if($vendorId > 0) {
				$query = "
					SELECT productid
					FROM [|PREFIX|]products
					WHERE productid IN ('".$prodids."') AND prodvendorid='".(int)$vendorId."'
				";
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				$prodids = array(0);
				while($product = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					$prodids[] = $product['productid'];
				}
				
				$prodids = implode("','", array_map('intval', $prodids));
			}
			//echo "productid = ".implode(' OR productid=',$ids);exit;



			// Build a list of queries to execute
			$queries[] = sprintf("delete from [|PREFIX|]categoryassociations where productid in ('%s')", $prodids);
			$queries[] = sprintf("delete from [|PREFIX|]product_customfields where fieldprodid in ('%s')", $prodids);
			$queries[] = sprintf("delete from [|PREFIX|]reviews where revproductid in ('%s')", $prodids);
			$queries[] = sprintf("delete from [|PREFIX|]product_search where productid in ('%s')", $prodids);
			$queries[] = sprintf("delete from [|PREFIX|]product_words where productid in ('%s')", $prodids);
			$queries[] = sprintf("delete from [|PREFIX|]product_images where imageprodid in ('%s')", $prodids);
			$queries[] = sprintf("delete from [|PREFIX|]product_downloads where productid in ('%s')", $prodids);
			$queries[] = sprintf("delete from [|PREFIX|]wishlist_items where productid in ('%s')", $prodids);
			$queries[] = sprintf("delete from [|PREFIX|]product_configurable_fields where fieldprodid in ('%s')", $prodids);

//added by blessen
			
			$queries[] = sprintf("delete from [|PREFIX|]qualifier_value where pid in ('%s')", $prodids);
			$queries[] = sprintf("delete from [|PREFIX|]import_variations where productid in ('%s')", $prodids);
			$queries[] = sprintf("delete from [|PREFIX|]install_images where imageprodid in ('%s')", $prodids);
			$queries[] = sprintf("delete from [|PREFIX|]install_videos where videoprodid  in ('%s')", $prodids);
			$queries[] = sprintf("delete from [|PREFIX|]product_videos where videoprodid in ('%s')", $prodids);
			$queries[] = sprintf("delete from [|PREFIX|]audio_clips where audioprodid in ('%s')", $prodids);
	        $queries[] = sprintf("delete from [|PREFIX|]instruction_files where instructionprodid in ('%s')", $prodids);
	        $queries[] = sprintf("delete from [|PREFIX|]article_files where articleprodid in ('%s')", $prodids);
			$queries[] = sprintf("delete from [|PREFIX|]application_data where productid in ('%s')", $prodids);

//added by blessen


			//Added by vikas for deleting from product finalprice table
			$queries[] = sprintf("delete from [|PREFIX|]product_finalprice where productid in ('%s')", $prodids);

			// Delete the product images from the file system
			$query = sprintf("select imagefile from [|PREFIX|]product_images where imageprodid in ('%s')", $prodids);
			
			//update the products_statistics, disable the items in the table for the statistics(not display)
			$queries[] = sprintf("update [|PREFIX|]products_statistics set enable=0 where productid in ('%s')", $prodids);

			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				@unlink(APP_ROOT."/../".GetConfig('ImageDirectory')."/".$row['imagefile']);
			}
			// Delete the install images from the file system
			$query = sprintf("select imagefile from [|PREFIX|]install_images where imageprodid in ('%s')", $prodids);

			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				@unlink(APP_ROOT."/../install_images/".$row['imagefile']);
			}
            /*
            // Delete the product videos from the file system
            $query = sprintf("select videofile, videotype, systemvideofile from [|PREFIX|]product_videos where videoprodid in ('%s') AND ((videotype != 1) || (videotype = 1 AND isdownloaded=2))", $prodids);

            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
            while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                if($row['videotype'] == 1)    {
                    $filename = $row['systemvideofile'];
                }
                else    {
                    $filename = $row['videofile']; 
                }
                @unlink(APP_ROOT."/../".GetConfig('VideoDirectory')."/".$filename);
            }    
            
            // Delete the install videos from the file system
            $query = sprintf("select videofile, videotype, systemvideofile from [|PREFIX|]install_videos where videoprodid in ('%s') AND ((videotype != 1) || (videotype = 1 AND isdownloaded=2))", $prodids);

            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
            while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                if($row['videotype'] == 1)    {
                    $filename = $row['systemvideofile'];
                }
                else    {
                    $filename = $row['videofile']; 
                }
                @unlink(APP_ROOT."/../".GetConfig('InstallVideoDirectory')."/".$filename);
            }    
            */
            
            $query = sprintf("select instructionfile, instructiontype, systeminstructionfile from [|PREFIX|]instruction_files where instructionprodid in ('%s') AND ((instructiontype != 1) || (instructiontype = 1 AND isdownloaded=2))", $prodids);

            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
            while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                if($row['instructiontype'] == 1)    {
                    $filename = $row['systeminstructionfile'];
                }
                else    {
                    $filename = $row['instructionfile']; 
                }
                @unlink(APP_ROOT."/../instruction_file/".$filename);
            }    
            
            // Delete the install videos from the file system
            $query = sprintf("select articlefile, articletype, systemarticlefile from [|PREFIX|]article_files where articleprodid in ('%s') AND ((articletype != 1) || (articletype = 1 AND isdownloaded=2))", $prodids);

            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
            while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                if($row['articletype'] == 1)    {
                    $filename = $row['systemarticlefile'];
                }
                else    {
                    $filename = $row['articlefile']; 
                }
                @unlink(APP_ROOT."/../article_file/".$filename);
            } 
            
			// Delete the product downloads from the file system
			$query = sprintf("select downfile from [|PREFIX|]product_downloads where productid in ('%s')", $prodids);
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				@unlink(APP_ROOT."/../".GetConfig('DownloadDirectory')."/".$row['downfile']);
			}

			$vc_queries = $this->_DeleteVariationCombinationsForProduct($prodids, true);
			$queries = array_merge($vc_queries, $queries);

			// Delete the product record here so we can keep a record of what was deleted for the accounting modules
			$entity = new ISC_ENTITY_PRODUCT();
			$entity->multiDelete($ids);

			foreach ($queries as $query) {
				$GLOBALS["ISC_CLASS_DB"]->Query($query);
			}
			$err = $GLOBALS["ISC_CLASS_DB"]->GetErrorMsg();
            
			if($err != "") {
				// Queries failed, rollback
				$GLOBALS["ISC_CLASS_DB"]->Query("rollback");
				return false;
			}
			else {
				// Query was a success
				$GLOBALS["ISC_CLASS_DB"]->Query("commit");
				return true;
			}
		}

		/**
		* _DeleteVariationCombinationsForProduct
		* Delete variation combinations for a product, including the images
		*
		* @param String $ProductIds The id(s) of the products to delete varations for in CSV, such as 105,106
		* @param Boolean $ReturnQueries If true, the queries will be returned as an array. If false, they will be ran instead.
		* @return String
		*/
		public function _DeleteVariationCombinationsForProduct($ProductIds, $ReturnQueries=false)
		{
			$queries = array();

			// Delete the product combination images from the file system
			$query = sprintf("select vcimage, vcthumb from [|PREFIX|]product_variation_combinations WHERE vcproductid in ('%s')", $ProductIds);
			$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);

			while($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
				if($row['vcimage'] != "") {
					@unlink(APP_ROOT."../".GetConfig('ImageDirectory')."/".$row['vcimage']);
				}

				if($row['vcthumb'] != "") {
					@unlink(APP_ROOT."../".GetConfig('ImageDirectory')."/".$row['vcthumb']);
				}
			}

			// Now delete the entries in the product_variation_combinations table
			$queries[] = sprintf("delete from [|PREFIX|]product_variation_combinations where vcproductid in ('%s')", $ProductIds);

			if($ReturnQueries) {
				return $queries;
			}
			else {
				$GLOBALS["ISC_CLASS_DB"]->Query($queries[0]);
			}
		}

		public function DeleteProducts()
		{
			$queries = array();

			if(isset($_POST['products'])) {
				if(!$this->DoDeleteProducts($_POST['products'])) {
					$err = $GLOBALS["ISC_CLASS_DB"]->GetErrorMsg();
					$this->ManageProducts($err, MSG_ERROR);
				}
				else {
					// Log this action
					$GLOBALS['ISC_CLASS_LOG']->LogAdminAction(count($_POST['products']));

					$this->ManageProducts(GetLang('ProductsDeletedSuccessfully'), MSG_SUCCESS);
				}
			}
			else {
				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Products)) {
					$this->ManageProducts();
				}
				else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
				}
			}
		}

		public function EditVisibility()
		{
			// Update the visibility of a product with a simple query

			$prodId = (int)$_GET['prodId'];
			$visible = (int)$_GET['visible'];

			$query = sprintf("SELECT prodname, prodvendorid FROM [|PREFIX|]products WHERE productid='%d'", $prodId);
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$product = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

			// Does this user have permission to toggle the visibility for this product?
			if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() && $product['prodvendorid'] != $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
				echo 0;
				exit;
			}

			// Log this action
			$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($prodId, $product['prodname']);

			$updatedProduct = array(
				"prodvisible" => $visible
			);
			$GLOBALS['ISC_CLASS_DB']->UpdateQuery("products", $updatedProduct, "productid='".$GLOBALS['ISC_CLASS_DB']->Quote($prodId)."'");

			unset($_REQUEST['visible']);
			unset($_GET['visible']);

			if ($GLOBALS["ISC_CLASS_DB"]->Error() == "") {
				if(isset($_REQUEST['ajax'])) {
					echo 1;
					exit;
				}

				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Products)) {
					$this->ManageProducts(GetLang('ProductVisibleSuccessfully'), MSG_SUCCESS);
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('ProductVisibleSuccessfully'), MSG_SUCCESS);
				}
			} else {
				if(isset($_REQUEST['ajax'])) {
					echo 0;
					exit;
				}
				$err = '';
				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Products)) {
					$this->ManageProducts(sprintf(GetLang('ErrVisibilityNotChanged'), $err), MSG_ERROR);
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(sprintf(GetLang('ErrVisibilityNotChanged'), $err), MSG_ERROR);
				}
			}
		}

		public function EditFeatured()
		{
			// Update the visibility of a product with a simple query

			$prodId = (int)$_GET['prodId'];
			$featured = (int)$_GET['featured'];

			$query = sprintf("SELECT prodname, prodvendorid FROM [|PREFIX|]products WHERE productid='%d'", $prodId);
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$product = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

			// Does this user have permission to toggle the featured status for this product?
			if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() && $product['prodvendorid'] != $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
				echo 0;
				exit;
			}

			// Log this action
			$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($prodId, $product['prodname']);

			if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
				$featuredColumn = 'prodvendorfeatured';
			}
			else {
				$featuredColumn = 'prodfeatured';
			}

			$updatedProduct = array(
				$featuredColumn => $featured
			);
			$GLOBALS['ISC_CLASS_DB']->UpdateQuery("products", $updatedProduct, "productid='".$GLOBALS['ISC_CLASS_DB']->Quote($prodId)."'");

			unset($_REQUEST['featured']);
			unset($_GET['featured']);

			if ($GLOBALS["ISC_CLASS_DB"]->Error() == "") {
				if(isset($_REQUEST['ajax'])) {
					echo 1;
					exit;
				}
				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Products)) {
					$this->ManageProducts(GetLang('ProductVisibleSuccessfully'), MSG_SUCCESS);
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('ProductVisibleSuccessfully'), MSG_SUCCESS);
				}
			} else {
				if(isset($_REQUEST['ajax'])) {
					echo 0;
					exit;
				}
				$err = '';
				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Products)) {
					$this->ManageProducts(sprintf(GetLang('ErrVisibilityNotChanged'), $err), MSG_ERROR);
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(sprintf(GetLang('ErrVisibilityNotChanged'), $err), MSG_ERROR);
				}
			}
		}

		public function ManageProductsGrid(&$numProducts)
		{
			// Show a list of products in a table
			$page = 0;
			$start = 0;
			$numProducts = 0;
			$numPages = 0;
			$GLOBALS['ProductGrid'] = "";
			$GLOBALS['Nav'] = "";
			$max = 0;

			// Is this a custom search?
			if(isset($_GET['searchId'])) {
				$this->_customSearch = $GLOBALS['ISC_CLASS_ADMIN_CUSTOMSEARCH']->LoadSearch($_GET['searchId']);
				$_REQUEST = array_merge($_REQUEST, (array)$this->_customSearch['searchvars']);
				// Override custom search sort fields if we have a requested field
				if(isset($_GET['sortField'])) {
					$_REQUEST['sortField'] = $_GET['sortField'];
				}
				if(isset($_GET['sortOrder'])) {
					$_REQUEST['sortOrder'] = $_GET['sortOrder'];
				}
			}

			if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
				$featuredColumn = 'prodvendorfeatured';
			}
			else {
				$featuredColumn = 'prodfeatured';
			}

			$validSortFields = array('productid', 'prodcode', 'currentinv', 'prodname', 'prodcalculatedprice', 'prodvisible', $featuredColumn);

			if(isset($_REQUEST['sortOrder']) && $_REQUEST['sortOrder'] == "asc") {
				$sortOrder = "asc";
			}
			else {
				$sortOrder = "desc";
			}

			if(isset($_REQUEST['sortField']) && in_array($_REQUEST['sortField'], $validSortFields)) {
				$sortField = $_REQUEST['sortField'];
				SaveDefaultSortField("ManageProducts", $_REQUEST['sortField'], $sortOrder);
			} else {
				list($sortField, $sortOrder) = GetDefaultSortField("ManageProducts", "productid", $sortOrder);
			}


			if(isset($_GET['page'])) {
				$page = (int)$_GET['page'];
			}
			else {
				$page = 1;
			}

			if(isset($_GET['filterCategory']) && $_GET['filterCategory'] == "-1") {
				$GLOBALS['FilterLow'] = "selected=\"selected\"";
			}

			if(isset($_GET['filterCategory'])) {
				$filterCat = (int)$_GET['filterCategory'];
			}
			else {
				$filterCat = 0;
			}

			if(!gzte11(ISC_MEDIUMPRINT)) {
				$GLOBALS['ProductNameSpan'] = 3;
				$GLOBALS['HideInventoryOptions'] = 'none';
			}
			else {
				$GLOBALS['HideInventoryOptions'] = '';
			}

			// Build the pagination and sort URL
			$searchURL = '';
			foreach($_GET as $k => $v) {
				if($k == "sortField" || $k == "sortOrder" || $k == "page" || $k == "new" || $k == "ToDo" || $k == "SubmitButton1" || $k == "ISSelectReplacement_category" || (!$v && $v !== '0')) {
					continue;
				}
				if(is_array($v)) {
					foreach($v as $v2) {
						$searchURL .= sprintf("&%s[]=%s", $k, urlencode($v2));
					}
				}
				else {
					$searchURL .= sprintf("&%s=%s", $k, urlencode($v));
				}
			}

			// Build the letter sorting
			$letterURL = sprintf("%s&amp;sortField=%s&amp;sortOrder=%s", preg_replace("#&letter=[a-zA-Z0-9\-]{1,2}#i", "", $searchURL), $sortField, $sortOrder);
			$GLOBALS['LetterURL'] = $letterURL;
			$extra = '';
			if(isset($_REQUEST['letter']) && $_REQUEST['letter'] == "0-9") {
				$extra = 'ActiveLetter';
			}
			$GLOBALS['LetterSortGrid'] = sprintf('<td width="3%%"><a href="index.php?ToDo=viewProducts%s&amp;letter=0-9" title="%s" class="SortLink %s">#</a></td>', $letterURL, sprintf(GetLang('ViewProductsLetter'), '0-9'), $extra);
			$letters = preg_split('%,\s+%s', GetLang('Alphabet'));
			foreach ($letters as $letter) {
				$extra = '';
				if (isset($_REQUEST['letter']) && $_REQUEST['letter'] == $letter) {
					$extra = 'ActiveLetter';
				}
				$GLOBALS['LetterSortGrid'] .= sprintf('<td width="3%%"><a href="index.php?ToDo=viewProducts%s&amp;letter=%s" title="%s" class="SortLink %s">%s</a></td>', $letterURL, $letter, sprintf(GetLang('ViewProductsLetter'), isc_strtoupper($letter)), $extra, isc_strtoupper($letter));
			}
			$letter = GetLang('Clear');
			$GLOBALS['LetterSortGrid'] .= sprintf('<td width="3%%"><a href="index.php?ToDo=viewProducts%s" class="SortLink">%s</a></td>', $letterURL, $letter, $letter);

			$sortURL = sprintf("%s&amp;sortField=%s&amp;sortOrder=%s", $searchURL, $sortField, $sortOrder);
			$GLOBALS['SortURL'] = $sortURL;

			// Limit the number of questions returned
			if($page == 1) {
				$start = 1;
			}
			else {
				$start = ($page * ISC_PRODUCTS_PER_PAGE) - (ISC_PRODUCTS_PER_PAGE-1);
			}

			$start = $start-1;

			// Get the results for the query
			$product_result = $this->_GetProductList($start, $sortField, $sortOrder, $numProducts);
			$numPages = ceil($numProducts / ISC_PRODUCTS_PER_PAGE);

			// Add the "(Page x of n)" label
			if($numProducts > ISC_PRODUCTS_PER_PAGE) {
				$GLOBALS['Nav'] = sprintf("(%s %d of %d) &nbsp;&nbsp;&nbsp;", GetLang('Page'), $page, $numPages);

				$GLOBALS['Nav'] .= BuildPagination($numProducts, ISC_PRODUCTS_PER_PAGE, $page, sprintf("index.php?ToDo=viewProducts%s", $sortURL));
			}
			else {
				$GLOBALS['Nav'] = "";
			}

			if (isset($_REQUEST['searchQuery'])) {
				$query = $_REQUEST['searchQuery'];
			} else {
				$query = '';
			}
            
            //Create Identity for each search result     
            if(isset($_GET['searchQuery']))    {       
                $_SESSION['SesDelIdentity'] = $GLOBALS['DelIdentity'] = $_GET['searchQuery'].rand(1000, 9999);  
            }
            else    {
                unset($_SESSION['SesDelIdentity']);
            }             
            
			$GLOBALS['Nav'] = preg_replace('# \|$#',"", $GLOBALS['Nav']);
			$GLOBALS['SearchQuery'] = isc_html_escape($query);
			$GLOBALS['SortField'] = $sortField;
			$GLOBALS['SortOrder'] = $sortOrder;

			if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
				$featuredColumn = 'prodvendorfeatured';
			}
			else {
				$featuredColumn = 'prodfeatured';
			}

			$sortLinks = array(
				"Code" => "prodcode",
				"Stock" => "currentinv",
				"Name" => "prodname",
				"Price" => "prodcalculatedprice",
				"Visible" => "prodvisible",
				"Featured" => $featuredColumn
			);

			BuildAdminSortingLinks($sortLinks, "index.php?ToDo=viewProducts&amp;".$searchURL."&amp;page=".$page, $sortField, $sortOrder);


			// Workout the maximum size of the array
			$max = $start + ISC_PRODUCTS_PER_PAGE;

			if ($max > $numProducts) {
				$max = $numProducts;
			}

			if($numProducts > 0) {
				// Display the products
				while($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($product_result)) {
					if ($row['prodcode'] == "") {
						$GLOBALS['SKU'] = GetLang('NA');
					} else {
						$GLOBALS['SKU'] = isc_html_escape($row['prodcode']);
					}

					$GLOBALS['ProductId'] = (int)$row['productid'];
					$GLOBALS['Name'] = sprintf("<a title='%s' class='Action' href='%s' target='_blank'>%s</a>", GetLang('ProductView'), ProdLink($row['prodname']), isc_html_escape($row['prodname']));

					// Do we need to show product thumbnails?
					if(GetConfig('ShowThumbsInControlPanel')) {
						if($row['tinythumb'] != "") {
							$GLOBALS['ProductImage'] = sprintf("<img src='%s/%s/%s' />", $GLOBALS['ShopPath'], GetConfig('ImageDirectory'), $row['tinythumb']);
						}
						else {
							$GLOBALS['ProductImage'] = sprintf("<div class='NoThumb'>%s<br />%s<br />%s</div>", GetLang('NoImage1'), GetLang('NoImage2'), GetLang('NoImage3'));
						}
					}
					else {
						// Use JavaScript to hide the thumbnail field
						$GLOBALS['HideThumbnailField'] = "1";
					}

					$GLOBALS['Price'] = FormatPrice($row['prodcalculatedprice']);
					$GLOBALS['StockExpand'] = "&nbsp;";
					$GLOBALS['LowStockStyle'] = "";

					if ($row['prodinvtrack'] == 0) {
						$GLOBALS['StockInfo'] = GetLang('NA');
					} else if($row['prodinvtrack'] > 0) {

						$GLOBALS['StockExpand'] = sprintf("<a href=\"#\" onclick=\"ShowStock('%d', '%d', '%d'); return false;\"><img id=\"expand%d\" src=\"images/plus.gif\" align=\"left\"  class=\"ExpandLink\" width=\"19\" height=\"16\" title=\"%s\" border=\"0\"></a>", $row['productid'], $row['prodinvtrack'], $row['prodvariationid'], $row['productid'], GetLang('ClickToViewStock'));

						if($row['prodlowinv'] > 0) {
							$percent = ceil(($row['currentinv'] / ($row['prodlowinv'] * 2)) * 100);
						} else {
							$percent = ceil(($row['currentinv'] / (1 * 2)) * 100);
						}

						if($percent > 100) {
							$percent = 100;
						}

						if($percent > 75) {
							$stockClass = 'InStock';
							$orderMore = GetLang('SNo');
						}
						else if($percent > 50) {
							$stockClass = 'StockWarning';
							$orderMore = GetLang('Soon');
						}
						else {
							$stockClass = 'LowStock';
							$orderMore = GetLang('SYes');
						}
						$width = ceil(($percent/100)*72);

						$stockInfo = sprintf(GetLang('CurrentStockLevel').': %s<br />'.GetLang('LowStockLevel1').': %s<br />'.GetLang('OrderMore').': '.$orderMore, $row['currentinv'], $row['prodlowinv'], $orderMore);

						$GLOBALS['StockInfo'] = sprintf("<div class=\"StockLevelIndicator\" onmouseover=\"ShowQuickHelp(this, '%s', '%s')\" onmouseout=\"HideQuickHelp(this)\"><span class=\"%s\" style=\"width: %spx\"></span></div>", GetLang('StockLevel'), $stockInfo, $stockClass, $width);
					}

					// If they have permission to edit products, they can change
					// the visibility status of a product by clicking on the icon

					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Products)) {
						if ($row['prodvisible'] == 1) {
							$GLOBALS['Visible'] = sprintf("<a title='%s' href='index.php?ToDo=editProductVisibility&amp;prodId=%d&amp;visible=0' onclick=\"quickToggle(this, 'visible'); return false;\"><img border='0' src='images/tick.gif' alt='tick'></a>", GetLang('ClickToHide'), $row['productid']);
						} else {
							$GLOBALS['Visible'] = sprintf("<a title='%s' href='index.php?ToDo=editProductVisibility&amp;prodId=%d&amp;visible=1' onclick=\"quickToggle(this, 'visible'); return false;\"><img border='0' src='images/cross.gif' alt='cross'></a>", GetLang('ClickToShow'), $row['productid']);
						}
					} else {
						if ($row['prodvisible'] == 1) {
							$GLOBALS['Visible'] = '<img border="0" src="images/tick.gif" alt="tick">';
						} else {
							$GLOBALS['Visible'] = '<img border="0" src="images/cross.gif" alt="cross">';
						}
					}

					// If they have permission to edit products, they can change
					// the featured status of a product by clicking on the icon

					if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
						$featuredColumn = 'prodvendorfeatured';
					}
					else {
						$featuredColumn = 'prodfeatured';
					}

					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Products)) {
						if ($row[$featuredColumn] == 1) {
							$GLOBALS['Featured'] = sprintf("<a title='%s' href='index.php?ToDo=editProductFeatured&amp;prodId=%d&amp;featured=0' onclick=\"quickToggle(this, 'featured'); return false;\"><img border='0' src='images/tick.gif' alt='tick'></a>", GetLang('ClickToHide'), $row['productid']);
						} else {
							$GLOBALS['Featured'] = sprintf("<a title='%s' href='index.php?ToDo=editProductFeatured&amp;prodId=%d&amp;featured=1' onclick=\"quickToggle(this, 'featured'); return false;\"><img border='0' src='images/cross.gif' alt='cross'></a>", GetLang('ClickToShow'), $row['productid']);
						}
					} else {
						if ($row[$featuredColumn] == 1) {
							$GLOBALS['Featured'] = '<img border="0" src="images/tick.gif" alt="tick">';
						} else {
							$GLOBALS['Featured'] = '<img border="0" src="images/cross.gif" alt="cross">';
						}
					}

					// Workout the edit link -- do they have permission to do so?
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Products)) {
						$GLOBALS['EditProductLink'] = sprintf("<a title='%s' class='Action' href='index.php?ToDo=editProduct&amp;productId=%d'>%s</a>", GetLang('ProductEdit'), $row['productid'], GetLang('Edit'));
					} else {
						$GLOBALS['EditProductLink'] = sprintf("<a class='Action' disabled>%s</a>", GetLang('Edit'));
					}


//blessen goto
$GLOBALS['GOTO'] = '<INPUT TYPE="text" NAME="page_no" size="2" id="page_no" onkeyup="go(this.value);"> &nbsp;<a href="#" id="gotopage");>Go to page</a>';


$GLOBALS['GOTO1'] = '<INPUT TYPE="text" NAME="page_no1" size="2" id="page_no1" onkeyup="go1(this.value);"> &nbsp;<a href="#" id="gotopage1");>Go to page</a>';

					$GLOBALS['CopyProductLink'] = "<a title='".GetLang('ProductCopy')."' class='Action' href='index.php?ToDo=copyProduct&amp;productId=".$row['productid']."'>".GetLang('Copy')."</a>";

					$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("product.manage.row");
					$GLOBALS['ProductGrid'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
				}

			}
			if($GLOBALS['ProductGrid'] == '') {
				if(isset($_REQUEST['letter'])) {
					$GLOBALS['ProductGrid'] = sprintf('<tr>
						<td colspan="11" style="padding:10px"><em>%s</em></td>
					</tr>', sprintf(GetLang('LetterSortNoResults'), isc_strtoupper($_REQUEST['letter'])));
				}
			}
			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("products.manage.grid");
			return $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate(true);
		}

		public function ManageProducts($MsgDesc = "", $MsgStatus = "")
		{

        # Used to clear the HTML Editor image upload folder name Baskaran
            $_SESSION['congobrand'] = '';
            $_SESSION['congoseries'] = '';


//blessen


if (isset($_GET['testdata']) and $_GET['testdata'] == "no")
{
    unset($_SESSION['testmode']); 
}
 if ((isset($_GET['testdata']) and $_GET['testdata']=="yes") ||  isset($_SESSION['testmode']))       
{
     $GLOBALS['HideExportResults'] = "None";
     $GLOBALS['HideBulkExportButton'] = "None";
     $GLOBALS['HideExport'] = "None";
     $GLOBALS['ExportProductslan'] = "Show All Products";
     $GLOBALS['ShowtTestData'] = "index.php?ToDo=viewProducts&testdata=no";
     $_SESSION['testmode'] = "yes";
}
else                                                        
{           
	$vendorcondition = "";     
    if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
		$vendorcondition .= " and prodvendorid = '" . $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() ;
	}

    $query = sprintf("SELECT productid  FROM [|PREFIX|]products where testdata = 'Yes'  ".$vendorcondition." ");
    $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
       
    if ($GLOBALS["ISC_CLASS_DB"]->CountResult($result) > 0)
	{
        $GLOBALS['ExportProductslan'] = "Show only test products";
        $GLOBALS['ShowtTestData'] = "index.php?ToDo=viewProducts&testdata=yes";
        $GLOBALS['HideTestData'] = "";
    }
    else
    {
         $GLOBALS['HideTestData'] = "None";
         unset($_SESSION['testmode']);  
    } 
    
}

//blessen







			$GLOBALS['HideClearResults'] = "none";
			$catList = "";
			$numProducts = 0;

			// Fetch any results, place them in the data grid
			$GLOBALS['ProductDataGrid'] = $this->ManageProductsGrid($numProducts);

			// Was this an ajax based sort? Return the table now
			if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 1) {
				echo $GLOBALS['ProductDataGrid'];
				return;
			}

			if(isset($this->_customSearch['searchname'])) {
				$GLOBALS['ViewName'] = $this->_customSearch['searchname'];
			}
			else {
				$GLOBALS['ViewName'] = GetLang('AllProducts');
				$GLOBALS['HideDeleteViewLink'] = "none";
			}

			$num_custom_searches = 0;

			if (!isset($_REQUEST['searchId'])) {
				$_REQUEST['searchId'] = 0;
			}

			// Get the custom search as option fields
			$GLOBALS['CustomSearchOptions'] = $GLOBALS['ISC_CLASS_ADMIN_CUSTOMSEARCH']->GetSearchesAsOptions(@$_REQUEST['searchId'], $num_custom_searches, "AllProducts", "viewProducts", "customProductSearch");

			if(isset($_REQUEST['searchQuery'])) {
				$GLOBALS['HideClearResults'] = "";
			}

			if (!isset($_REQUEST['searchId']) || (int) $_REQUEST['searchId'] <= 0) {
				$GLOBALS['HideDeleteCustomSearch'] = "none";
			} else {
				$GLOBALS['CustomSearchId'] = (int)$_REQUEST['searchId'];
			}

			// Do we need to disable the delete button?
			if (!$GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Delete_Products) || $numProducts == 0) {
				$GLOBALS['DisableDelete'] = "DISABLED";
			}

			// Do we need to disable the expory button?
			if (!$GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Export_Products) || $numProducts == 0) {
				$GLOBALS['DisableExport'] = "DISABLED";
			}

			$GLOBALS['ProductIntro'] = GetLang('ManageProductsIntro');

			if($numProducts > 0) {
				if($MsgDesc == "" && (isset($_REQUEST['searchQuery']) || (isset($_GET['searchId']) && $_GET['searchId'] > 0))) {
					if($numProducts == 1) {
						$MsgDesc = GetLang('ProductSearchResultsBelow1');
					}
					else {
						$MsgDesc = sprintf(GetLang('ProductSearchResultsBelowX'), $numProducts);
					}

					$MsgStatus = MSG_SUCCESS;
				}
			}
			else {
				$GLOBALS['DisplayGrid'] = "none";
				if(count($_GET) > 1) {
					if($MsgDesc == "") {
						$GLOBALS['Message'] = MessageBox(GetLang('NoProductResults'), MSG_ERROR);
					}
				}
				else {
					// No actual custoemrs
					$GLOBALS['DisplaySearch'] = "none";
					$GLOBALS['Message'] = MessageBox(GetLang('NoProducts'), MSG_SUCCESS);
				}
			}

			if(!gzte11(ISC_MEDIUMPRINT)) {
				$GLOBALS[base64_decode('SGlkZUV4cG9ydA==')] = "none";
			}

			if(!gzte11(ISC_LARGEPRINT)) {
				$GLOBALS[base64_decode("SGlkZUJ1bGtFeHBvcnRCdXR0b24=")] = "none";
			}
            $GLOBALS['Message'] = '';
			if ($MsgDesc != "") {
				$GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
			}

			$flashMessages = GetFlashMessages();
			if(is_array($flashMessages) || !empty($flashMessages)) {
				$GLOBALS['Message'] .= '';   //Concatenation dot(.) added by Simha  to get error message from function parameter as well
				foreach($flashMessages as $flashMessage) {
					$GLOBALS['Message'] .= MessageBox($flashMessage['message'], $flashMessage['type']);
				}
			}

			// Do we have permission to bulk edit products?
			if(!$GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Products)) {
				$GLOBALS['DisableBulkEdit'] = "DISABLED='DISABLED'";
			}

//blessen

$GLOBALS['HideExportResults'] = "";			
if (!isset($_GET['searchQuery'])) $GLOBALS['HideExportResults'] = "None";
$GLOBALS['ExportResults'] = "";
$GLOBALS['ExportResults'] = "index.php?ToDo=startExport&t=products";
if (!isset($_GET['searchQuery'])) $GLOBALS['HideDeleteResults'] = "None";       
//blessen

			$GLOBALS['ExportAction'] = "index.php?ToDo=startExport&t=products";
			if (isset($GLOBALS['CustomSearchId']) && $GLOBALS['CustomSearchId'] != '0') {
				$GLOBALS['ExportAction'] .= "&searchId=" . $GLOBALS['CustomSearchId'];
				$GLOBALS['ExportResults'] .= "&searchId=" . $GLOBALS['CustomSearchId'];
			}
			else {
				$query_params = explode('&', $_SERVER['QUERY_STRING']);
				$params = array();
				$ignore = array("ToDo");
				foreach ($query_params as $param) {
					$arr = explode("=", $param);
					if (!in_arrayi($arr[0], $ignore)) {
						$params[$arr[0]] = $arr[1];
					}
				}

				if (count($params)) {
					$GLOBALS['ExportAction'] .= "&" . http_build_query($params);
					$GLOBALS['ExportResults'] .= "&" . http_build_query($params)."&results=1";
				}
			}

			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("products.manage");
			$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
		}

		public function _GetChildCats($parent=0)
		{
			static $called;
			if($called == false) {
				$this->tree = new Tree();
				$query = sprintf("SELECT * FROM [|PREFIX|]categories");
				$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
				while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					$this->tree->nodesByPid[(int) $row['catparentid']][] = (int) $row['categoryid'];
				}
				$called = true;
			}

			$children = array();

			if(!@is_array($this->tree->nodesByPid[$parent])) {
				return $children;
			}

			foreach($this->tree->nodesByPid[$parent] as $categoryid) {
				$children[] = $categoryid;
				// Fetch nested children
				if(@is_array($this->tree->nodesByPid[$categoryid])) {
					$children = array_merge($children, $this->_GetChildCats($categoryid));
				}
			}

			return $children;
		}

		public function _GetProductList($Start, $SortField, $SortOrder, &$NumProducts, $fields='', $AddLimit=true, $exportPrimaryImage=false)
		{
			// Return an array containing details about products.
			// Takes into account search and advanced search values too.

			if($fields == '') {
				$fields = "p.productid, p.prodname, p.prodvariationid, p.prodprice, prodinvtrack, p.prodcode, p.proddesc, IF(prodinvtrack = 0, 0, prodcurrentinv) AS currentinv, prodvisible, prodlowinv, prodcalculatedprice, p.prodfeatured, p.prodvendorfeatured, t.imagefile AS tinythumb, p.prodistaxable ";
			}

			$joinQuery = '';
			$queryWhere = '';

			$searchData = $this->BuildWhereFromVars($_REQUEST);
			$queryWhere = $searchData['query'];
			$joinQuery = $searchData['join'];
			$categorySearch = $searchData['categorySearch'];

			// Only fetch products which belong to the current vendor
			if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
				$queryWhere .= "prodvendorid = '" . $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() . "' AND ";
			}

			if($queryWhere) {
				$queryWhere = "WHERE " . $queryWhere . " 1=1";
				$_SESSION['searchresults'] =  $queryWhere;  //blessen
			}

//blessen
$testdatasel = '';
if (isset($_SESSION['testmode']))  $testdatasel = " and p.testdata = 'Yes' ";
if ($queryWhere == "" and isset($_SESSION['testmode'])) $testdatasel = " where p.testdata = 'Yes' ";

//blessen
			// Fetch the number of results
			if ($categorySearch) {
				$countQuery = "
					SELECT
						COUNT(DISTINCT p.productid)
					FROM
						[|PREFIX|]categoryassociations ca
						INNER JOIN [|PREFIX|]products p ON p.productid = ca.productid
						" . $joinQuery . "
					" . $queryWhere.$testdatasel;
                    
                $delQuery = "
                    SELECT
                        DISTINCT p.productid
                    FROM
                        [|PREFIX|]categoryassociations ca
                        INNER JOIN [|PREFIX|]products p ON p.productid = ca.productid
                        " . $joinQuery . "
                    " . $queryWhere.$testdatasel;
			}
			else {
				$countQuery = "
					SELECT
						COUNT(p.productid)
					FROM
						[|PREFIX|]products p
						" . $joinQuery . "
					" . $queryWhere.$testdatasel;
                    
                $delQuery = "
                    SELECT
                        p.productid
                    FROM
                        [|PREFIX|]products p
                        " . $joinQuery . "
                    " . $queryWhere.$testdatasel;
			}
            
			$result = $GLOBALS['ISC_CLASS_DB']->Query($countQuery);
			$NumProducts = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);

            //To delete search results            
            $_SESSION['delQuery']               = $delQuery;  
            $GLOBALS['DelProductsCount']        = $_SESSION['productsCount']  = $NumProducts;
            $GLOBALS['ConfirmDeleteSearchResults']  = sprintf(GetLang("ConfirmDeleteSearchResults"), $GLOBALS['DelProductsCount']);

			// Construct the product query
			$limit = "";
			if($AddLimit) {
				$limit = $GLOBALS["ISC_CLASS_DB"]->AddLimit($Start, ISC_PRODUCTS_PER_PAGE);
			}

			if ($categorySearch) {
				$query = "
					SELECT
						" . $fields . "
					FROM
						(
							SELECT
								DISTINCT ca.productid
							FROM
								[|PREFIX|]categoryassociations ca
								INNER JOIN [|PREFIX|]products p ON p.productid = ca.productid "
								. $joinQuery
								. $queryWhere .$testdatasel. "
							ORDER BY
								" . $SortField . " " . $SortOrder . $limit . "
						) AS ca
						INNER JOIN [|PREFIX|]products p ON p.productid = ca.productid
						LEFT JOIN [|PREFIX|]product_images t ON (t.imageisthumb='2' and t.imageprodid=p.productid)
					";

				// Load the thumbnail
				if($exportPrimaryImage == true) {
					$query .= " LEFT JOIN [|PREFIX|]product_images pi ON (pi.imageisthumb='0' AND pi.imageprodid=p.productid AND pi.imagesort=1)";
				}
			}
			else {

				// Load the thumbnail
				if($exportPrimaryImage == true) {
					$joinQuery .= " LEFT JOIN [|PREFIX|]product_images pi ON (pi.imageisthumb='0' AND pi.imageprodid=p.productid AND pi.imagesort=1)";
				}

				$query = "
					SELECT
						" . $fields . "
					FROM
						[|PREFIX|]products p
						LEFT JOIN [|PREFIX|]product_images t ON (t.imageisthumb='2' and t.imageprodid=p.productid) "
						. $joinQuery
						. $queryWhere . $testdatasel. "
					ORDER BY "
						. $SortField . " " . $SortOrder . $limit;

			}

			$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
			return $result;
		}

		public function BuildWhereFromVars($array)
		{
			$queryWhere = "";
			$joinQuery = "";

			// Are we selecting a specific product?
			if(isset($array['productId']) && $array['productId'] != '') {
				$queryWhere .= " p.productid = '" . $array['productId'] . "' AND ";
				// dont need to build a where if only one product searched
				return array("query" => $queryWhere, "join" => $joinQuery);
			}

			// If we're searching by category, we need to completely
			// restructure the search query - so do that first
			$categorySearch = false;
			$categoryIds = array(); 
            
			if(isset($array['category']) && is_array($array['category'])) {
                    
                if(count(array_unique($array['category'])) > 1 && $array['category'][0]==0)    {
                    unset($array['category'][0]);
                }                                       //Added by Simha
                 
				foreach($array['category'] as $categoryId) {
					// All categories were selected, so don't continue
					
                    if($categoryId == 0) {
						$categorySearch = false;
						break;
					}
                               //Commented by Simha

					$categoryIds[] = (int)$categoryId;

					// If searching sub categories automatically, fetch & tack them on
					if(isset($array['subCats']) && $array['subCats'] == 1) {
						$categoryIds = array_merge($categoryIds, $this->_GetChildCats($categoryId));
					}
				}

				$categoryIds = array_unique($categoryIds);
				if(!empty($categoryIds)) {
					$categorySearch = true;
				}
			}      
            //print_r($array['category']);exit;
            
			if($categorySearch == true) {
				$queryWhere .= "ca.categoryid IN (" . implode(',', $categoryIds) . ") AND ";
			}

			if(isset($array['searchQuery']) && $array['searchQuery'] != "") {
				// Perform a full text based search on the products search table
				$search_query = isc_strtolower($array['searchQuery']);

				$fulltext_fields = array("ps.prodname", "ps.prodcode");
				$queryWhere .= "(" . $GLOBALS["ISC_CLASS_DB"]->FullText($fulltext_fields, $search_query, true);
				$queryWhere .= "OR lower(ps.prodname) like '%" . $GLOBALS['ISC_CLASS_DB']->Quote($search_query) . "%' ";
				$queryWhere .= "OR lower(ps.prodcode) = '" . $GLOBALS['ISC_CLASS_DB']->Quote($search_query) . "' ";
				$queryWhere .= "OR p.productid='" . (int)$search_query . "') AND ";

				// Add the join for the fulltext column
				$joinQuery .= " INNER JOIN [|PREFIX|]product_search ps ON p.productid=ps.productid ";
			}

			if(isset($array['letter']) && $array['letter'] != '') {
				$letter = chr(ord($array['letter']));
				if($array['letter'] == '0-9') {
					$queryWhere .= " p.prodname NOT REGEXP('^[a-zA-Z]') AND ";
				}
				else if(isc_strlen($letter) == 1) {
					$queryWhere .= " p.prodname LIKE '".$GLOBALS['ISC_CLASS_DB']->Quote($letter)."%' AND ";
				}
			}

			if(isset($array['soldFrom']) && isset($array['soldTo']) && $array['soldFrom'] != "" && $array['soldTo'] != "") {
				$sold_from = (int)$array['soldFrom'];
				$sold_to = (int)$array['soldTo'];
				$queryWhere .= sprintf("(prodnumsold >= '%d' and prodnumsold <= '%d') and ", $sold_from, $sold_to);
			}

			else if(isset($array['soldFrom']) && $array['soldFrom'] != "") {
				$sold_from = (int)$array['soldFrom'];
				$queryWhere .= sprintf("prodnumsold >= '%d' and ", $sold_from);
			}
			else if(isset($array['soldTo']) && $array['soldTo'] != "") {
				$sold_to = (int)$array['soldTo'];
				$queryWhere .= sprintf("prodnumsold <= '%d' and ", $sold_to);
			}

			if(isset($array['priceFrom']) && $array['priceFrom'] != "" && isset($array['priceTo']) && $array['priceTo'] != "") {
				$price_from = (int)$array['priceFrom'];
				$price_to = (int)$array['priceTo'];
				$queryWhere .= sprintf(" prodcalculatedprice >= '%s' and prodcalculatedprice <= '%s' and ", $price_from, $price_to);
			}
			else if(isset($array['priceFrom']) && $array['priceFrom'] != "") {
				$price_from = (int)$array['priceFrom'];
				$queryWhere .= sprintf(" prodcalculatedprice >= '%s' and ", $price_from);
			}
			else if(isset($array['priceTo']) && $array['priceTo'] != "") {
				$price_to = (int)$array['priceTo'];
				$queryWhere .= sprintf(" prodcalculatedprice <= '%s' and ", $price_to);
			}

			if(isset($array['inventoryFrom']) && $array['inventoryFrom'] != "" && isset($array['inventoryTo']) && $array['inventoryTo'] != "") {
				$inventory_from =(int)$array['inventoryFrom'];
				$inventory_to = (int)$array['inventoryTo'];
				$queryWhere .= sprintf("prodcurrentinv >= '%s' and prodcurrentinv <= '%s' and ", $inventory_from, $inventory_to);
			}
			else if(isset($array['inventoryFrom']) && $array['inventoryFrom'] != "") {
				$inventory_from =(int) $array['inventoryFrom'];
				$queryWhere .= sprintf("prodcurrentinv >= '%s' and ", $inventory_from);
			}
			else if(isset($array['inventoryTo']) && $array['inventoryTo'] != "") {
				$inventory_to = (int)$array['inventoryTo'];
				$queryWhere .= sprintf("prodcurrentinv <= '%s' and ", $inventory_to);
			}

			if (isset($array['inventoryLow']) && $array['inventoryLow'] != 0) {
				$lowVarInvProdIds = array();
				$inventoryLowVarQuery = "SELECT DISTINCT(vcproductid) FROM [|PREFIX|]product_variation_combinations WHERE vcstock<=vclowstock AND vclowstock > 0";
				$result = $GLOBALS['ISC_CLASS_DB']->Query($inventoryLowVarQuery);
				while ($lowVarInventory = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					$lowVarInvProdIds[]=$lowVarInventory['vcproductid'];
				}
				$queryWhere .= "(prodcurrentinv <= prodlowinv AND prodlowinv > 0 AND prodinvtrack=1) OR ( prodinvtrack=2 AND productid in ('".implode('\',\'', $lowVarInvProdIds)."')) AND ";
			}

			if(isset($array['brand']) && $array['brand'] != "") {
				$brand = (int)$array['brand'];
				$queryWhere .= sprintf("prodbrandid = '%d' AND ", $brand);
			}

			// Product visibility
			if(isset($array['visibility'])) {
				if($array['visibility'] == 1) {
					$queryWhere .= "prodvisible=1 AND ";
				}
				else if($array['visibility'] === '0') {
					$queryWhere .= "prodvisible=0 AND ";
				}
			}

			// Featured products?
			if(isset($array['featured'])) {
				if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
					$featuredColumn = 'prodvendorfeatured';
				}
				else {
					$featuredColumn = 'prodfeatured';
				}

				if($array['featured'] == 1) {
					$queryWhere .= $featuredColumn."=1 AND ";
				}
				else if($_REQUEST['featured'] === '0') {
					$queryWhere .= $featuredColumn."=0 AND ";
				}
			}

			// Free shipping
			if(isset($_REQUEST['freeShipping'])) {
				if($_REQUEST['freeShipping'] == 1) {
					$queryWhere .= "prodfreeshipping=1 AND ";
				}
				else if($_REQUEST['freeShipping'] === '0') {
					$queryWhere .= "prodfreeshipping=0 AND ";
				}
			}

			return array("query" => $queryWhere, "join" => $joinQuery, "categorySearch" => $categorySearch);
		}

		public function AddProductStep2()
		{
        # Used to clear the HTML Editor image upload folder name Baskaran
            $_SESSION['congobrand'] = '';
            $_SESSION['congoseries'] = '';

			/*if($message = strtokenize($_REQUEST, '#')) {
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoError(GetLang(B('UmVhY2hlZFByb2R1Y3RMaW1pdA==')), $message, MSG_ERROR);
				exit;
			}*/

			// Get the information from the form and add it to the database
			$arrData = array();
			$arrImages = array();
            $arrVideos = array();                                   //Added by Simha     
            $arrUserVideos = array();                               //Added by Simha
			$arrCustomFields = array();
			$arrVariations = array();
			$err = "";

			$this->_GetProductData(0, $arrData);
			$arrImages = $this->_GetImageData();
            $arrVideos = $this->_GetVideoData();                    //Added by Simha
            $arrUserVideos = $this->_GetUserVideoData();            //Added by Simha
			$this->_GetCustomFieldData(0, $arrCustomFields);
			$this->_GetVariationData(0, $arrVariations);
			$this->_GetProductFieldData(0, $arrProductFields);
			$discount = $this->GetDiscountRulesData(0, true);

			$productFieldsError = $this->_ValidateProductFields($arrProductFields);
			if($productFieldsError != '') {
				$this->AddProductStep1($productFieldsError, MSG_ERROR);
				return;
			}

			$downloadError = '';
			if (isset($_FILES['newdownload']) && isset($_FILES['newdownload']['tmp_name']) && $_FILES['newdownload']['tmp_name'] != '') {
				if (!$this->SaveProductDownload($downloadError)) {
					$this->AddProductStep1($downloadError, MSG_ERROR);
					return;
				}
			}

			// Does a product with the same name already exist?
			$query = "SELECT productid FROM [|PREFIX|]products WHERE lower(prodname)='".$GLOBALS['ISC_CLASS_DB']->Quote($arrData['prodname'])."'";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$existingProduct = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

			if($existingProduct['productid']) {
				$this->AddProductStep1(GetLang('ProductWithSameNameExists'), MSG_ERROR, true);
				return;
			}
            
            if($_SERVER['CONTENT_LENGTH'] > 100*1024*1024) {
                $this->AddProductStep1("You cannot upload files with total size more than 100MB", MSG_ERROR, true);
                return;
            }
            /* Check whether the vendor prefix has value in the vendor table -- Baskaran */
            $queryprefix = $GLOBALS['ISC_CLASS_DB']->Query("SELECT vendorprefix FROM [|PREFIX|]vendors WHERE vendorid = '".$arrData['prodvendorid']."' LIMIT 0,1 ");
            $existingProduct = $GLOBALS['ISC_CLASS_DB']->Fetch($queryprefix);
            $vendorprefix = $existingProduct['vendorprefix'];
            if($existingProduct['vendorprefix'] == '') {
                $this->AddProductStep1(GetLang('ProductWithoutVendorprefix'), MSG_ERROR, true);
                return;
            }
            /* Ends here */
            // Does a product with the same name already exist?
            $query = "SELECT productid FROM [|PREFIX|]products WHERE prodcode='".$arrData['prodcode']."' AND (prodvendorprefix = '' OR prodvendorprefix = '".$vendorprefix."')";
            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
            $existingProduct = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

            if($existingProduct['productid']) {
                $this->AddProductStep1('Product With Same SKU Exists', MSG_ERROR, true);  //GetLang('ProductWithSameSKUExists')
                return;
            }  
            
			// Validate out discount rules
			if (!empty($discount) && !$this->ValidateDiscountRulesData($error)) {
				$GLOBALS['CurrentTab'] = 7;
				$this->AddProductStep1($error, MSG_ERROR, true);
				return;
			}

			// Commit the values to the database
			if ($this->_CommitProduct(0, $arrData, $arrImages, $arrVideos, $arrUserVideos, $arrVariations, $arrCustomFields, $discount, $err, $arrProductFields)) {

			// calling the background process to update the price of the products
				$this->UpdatePriceInBackground($GLOBALS['NewProductId']);

				// Log this action
				$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($GLOBALS['NewProductId'], $arrData['prodname']);

				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Products)) {
					// Save the words to the product_words table for search spelling suggestions
					$this->SaveProductWords($arrData['prodname'], $GLOBALS['NewProductId'], "adding");
					if(isset($_POST['addanother'])) {
						FlashMessage(GetLang('ProductAddedSuccessfully'), MSG_SUCCESS);
						header("Location: index.php?ToDo=addProduct");
						exit;
					}
                    else if(isset($_POST['addview'])) {
                        $link = ProdLink($arrData['prodname']);    
                        echo "<script language=\"javascript\">\n"; 
                        echo "var link = \"$link\"\n";
                        echo "window.open(link)\n";
                        echo "window.location.href='index.php?ToDo=viewProducts';\n"; 
                        echo "</script>\n";
                        FlashMessage(GetLang('ProductAddedSuccessfully'), MSG_SUCCESS); 
                        exit; 
                    }
					else {
						FlashMessage(GetLang('ProductAddedSuccessfully'), MSG_SUCCESS);
						header("Location: index.php?ToDo=viewProducts");
						exit;
					}
				} else {
					FlashMessage(GetLang('ProductAddedSuccessfully'), MSG_SUCCESS);
					header("Location: index.php");
					exit;
				}
			} else {
				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Products)) {
                    /*echo "x".$err."y";
                    exit; */
					FlashMessage(sprintf(GetLang('ErrProductNotAdded'), $err), MSG_ERROR);
					header("Location: index.php?ToDo=addProduct");
					exit;
				} else {     
					FlashMessage(sprintf(GetLang('ErrProductNotAdded'), $err), MSG_ERROR);
					header("Location: index.php");
					exit;
				}
			}
		}

		public function AddProductStep1($MsgDesc = "", $MsgStatus = "", $PreservePost=false)
		{
			/*if($message = strtokenize($_REQUEST, '#')) {
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoError(GetLang(B('UmVhY2hlZFByb2R1Y3RMaW1pdA==')), $message, MSG_ERROR);
				exit;
			}*/

            /* Baskaran starts*/
            $user = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetUser();
            $userrole = $user['userrole'];
            if($userrole != 'admin') {
                $GLOBALS['hideradio'] = 'none';
            }
            else {
                $GLOBALS['hideradio'] = '';
            }
            /* Baskaran ends*/
            
			if ($MsgDesc != "") {
				$GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
			} else {
				$flashMessages = GetFlashMessages();
				if(is_array($flashMessages)) {
					$GLOBALS['Message'] = '';
					foreach($flashMessages as $flashMessage) {
						$GLOBALS['Message'] .= MessageBox($flashMessage['message'], $flashMessage['type']);
					}
				}
			}

			if (GetConfig('CurrencyLocation') == 'right') {
				$GLOBALS['CurrencyTokenLeft'] = '';
				$GLOBALS['CurrencyTokenRight'] = GetConfig('CurrencyToken');
			} else {
				$GLOBALS['CurrencyTokenLeft'] = GetConfig('CurrencyToken');
				$GLOBALS['CurrencyTokenRight'] = '';
			}

			// Delete any uploaded product downloads which are not attached to a product and older than 24h
			$query = sprintf("select downloadid, downfile from [|PREFIX|]product_downloads where downdateadded<'%d' and productid=0", time()-86400);
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$dlids = array();
			while($download = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				@unlink(APP_ROOT."../".GetConfig('DownloadDirectory')."/".$download['downfile']);
				$dlids[] = $download['downloadid'];
			}
			if(count($dlids) > 0) {
				$query = sprintf("delete from [|PREFIX|]product_downloads where downloadid in (%s)", implode(",", $dlids));
				$GLOBALS['ISC_CLASS_DB']->Query($query);
			}

			$GLOBALS['ServerFiles'] = $this->_GetImportFilesOptions();

			$GLOBALS['ISC_CLASS_ADMIN_CATEGORY'] = GetClass('ISC_ADMIN_CATEGORY');

			if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
				$GLOBALS['HideStoreFeatured'] = 'display: none';
			}
			else if(!gzte11(ISC_HUGEPRINT)) {
				$GLOBALS['HideVendorFeatured'] = 'display: none';
			}


			// Set the global variables for the select boxes
			$from_stamp = isc_gmmktime(0, 0, 0, isc_date("m"), isc_date("d"), isc_date("Y"));
			$to_stamp = isc_gmmktime(0, 0, 0, isc_date("m")+1, isc_date("d"), isc_date("Y"));

			$from_day = isc_date("d", $from_stamp);
			$from_month = isc_date("m", $from_stamp);
			$from_year = isc_date("Y", $from_stamp);

			$to_day = isc_date("d", $to_stamp);
			$to_month = isc_date("m", $to_stamp);
			$to_year = isc_date("Y", $to_stamp);

			$GLOBALS['OverviewFromDays'] = $this->_GetDayOptions($from_day);
			$GLOBALS['OverviewFromMonths'] = $this->_GetMonthOptions($from_month);
			$GLOBALS['OverviewFromYears'] = $this->_GetYearOptions($from_year);

			$GLOBALS['OverviewToDays'] = $this->_GetDayOptions($to_day);
			$GLOBALS['OverviewToMonths'] = $this->_GetMonthOptions($to_month);
			$GLOBALS['OverviewToYears'] = $this->_GetYearOptions($to_year);


			if($PreservePost == true) {
				$this->_GetProductData(0, $arrData);
				$arrImages = $this->_GetImageData();
				$this->_GetCustomFieldData(0, $arrCustomFields);

				$GLOBALS["ProdType_" . $arrData['prodtype']] = 'checked="checked"';
				$GLOBALS['ProdType'] = $arrData['prodtype'] - 1;
				$GLOBALS['ProdCode'] = isc_html_escape($arrData['prodcode']);

				$GLOBALS['ProdName'] = isc_html_escape($arrData['prodname']);

				$visibleCategories = array();
				if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
					$vendorData = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendor();
					if($vendorData['vendoraccesscats']) {
						$visibleCategories = explode(',', $vendorData['vendoraccesscats']);
					}
				}

                /* In the below line GetCategoryOptions() is changed to GetCategoryOptionsProduct() for not allowing user 
                to add product to main category if it has sub category  -- Baskaran */
				$GLOBALS['CategoryOptions'] = $GLOBALS["ISC_CLASS_ADMIN_CATEGORY"]->GetCategoryOptionsProduct($arrData['prodcats'], "<option %s value='%d' id='category_old%d'>%s</option>", "selected=\"selected\"", "", false, '', $visibleCategories);
				$GLOBALS['RelatedCategoryOptions'] = $GLOBALS["ISC_CLASS_ADMIN_CATEGORY"]->GetCategoryOptions(0, "<option %s value='%d'>%s</option>", "selected=\"selected\"", "- ", false);

				$wysiwygOptions = array(
					'id'		=> 'wysiwyg',
					'width'		=> '60%',
					'height'	=> '350px',
					'value'		=> $arrData['proddesc']
				);
//blessen
				$wysiwygOptions1 = array(
					'id'		=> 'wysiwyg1',
					'width'		=> '60%',
					'height'	=> '350px',
					'value'		=> $arrData['prodmfg']
				);

               $wysiwygOptions2 = array(
					'id'		=> 'wysiwyg2',
					'width'		=> '60%',
					'height'	=> '350px',
					'value'		=> $arrData['prodwarranty']
				);

				$wysiwygOptions3 = array(
					'id'		=> 'wysiwyg3',
					'width'		=> '60%',
					'height'	=> '350px',
					'value'		=> $arrData['prod_instruction']
				);

				$wysiwygOptions4 = array(
					'id'		=> 'wysiwyg4',
					'width'		=> '60%',
					'height'	=> '350px',
					'value'		=> $arrData['prod_article']
				);
                      
                $wysiwygOptions5 = array(
                    'id'        => 'wysiwyg5',
                    'width'        => '60%',
                    'height'    => '350px',
                    'value'        => $arrData['proddescfeature']
                );

				$GLOBALS['WYSIWYG'] =  GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor($wysiwygOptions);
				$GLOBALS['WYSIWYG1'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor1($wysiwygOptions1);
				$GLOBALS['WYSIWYG2'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor1($wysiwygOptions2);
				$GLOBALS['WYSIWYG3'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor1($wysiwygOptions3);
				$GLOBALS['WYSIWYG4'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor1($wysiwygOptions4);
                $GLOBALS['WYSIWYG5'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor1($wysiwygOptions5);    



				//$GLOBALS['instruction_file'] = "Current Instruction file : ".$arrData['instruction_file'];
				//$GLOBALS['article_file'] = "Current Article file : ".$arrData['article_file'];

				$GLOBALS['ProdSearchKeywords'] = $arrData['prodsearchkeywords'];
				$GLOBALS['ProdAvailability'] = $arrData['prodavailability'];
				$GLOBALS['ProdPrice'] = number_format($arrData['prodprice'], GetConfig('DecimalPlaces'), GetConfig('DecimalToken'), "");

				if (CFloat($arrData['prodcostprice']) > 0) {
					$GLOBALS['ProdCostPrice'] = number_format($arrData['prodcostprice'], GetConfig('DecimalPlaces'), GetConfig('DecimalToken'), "");
				}

				if (CFloat($arrData['prodretailprice']) > 0) {
					$GLOBALS['ProdRetailPrice'] = number_format($arrData['prodretailprice'], GetConfig('DecimalPlaces'), GetConfig('DecimalToken'), "");
				}

				if (CFloat($arrData['prodsaleprice']) > 0) {
					$GLOBALS['ProdSalePrice'] = number_format($arrData['prodsaleprice'], GetConfig('DecimalPlaces'), GetConfig('DecimalToken'), "");
				}

				$GLOBALS['ProdSortOrder'] = $arrData['prodsortorder'];

				if ($arrData['prodvisible'] == 1) {
					$GLOBALS['ProdVisible'] = "checked";
				}

				if ($arrData['prodfeatured'] == 1) {
					$GLOBALS['ProdFeatured'] = "checked";
				}

				if($arrData['prodvendorfeatured'] == 1) {
					$GLOBALS['ProdVendorFeatured'] = 'checked="checked"';
				}

				if($arrData['prodistaxable'] == 1) {
					$GLOBALS['ProdIsTaxable'] = "checked";
				}

				if($arrData['prodallowpurchases'] == 1) {
					$GLOBALS['ProdAllowPurchases'] = 'checked="checked"';
				}
				else {
					if($arrData['prodhideprice'] == 1) {
						$GLOBALS['ProdHidePrice'] = 'checked="checked"';
					}
				}

				$GLOBALS['ProdCallForPricing'] = isc_html_escape(@$arrData['prodCallForPricingLabel']);
//blessen
				//$GLOBALS['ProdWarranty'] = $arrData['prodwarranty'];
				//$GLOBALS['prod_instruction'] = $arrData['prod_instruction'];
				//$GLOBALS['prod_article'] = $arrData['prod_article'];


				$GLOBALS['ProdWeight'] = number_format($arrData['prodweight'], GetConfig('DimensionsDecimalPlaces'), GetConfig('DimensionsDecimalToken'), "");

				if (CFloat($arrData['prodwidth']) > 0) {
					$GLOBALS['ProdWidth'] = number_format($arrData['prodwidth'], GetConfig('DimensionsDecimalPlaces'), GetConfig('DimensionsDecimalToken'), "");
				}

				if (CFloat($arrData['prodheight']) > 0) {
					$GLOBALS['ProdHeight'] = number_format($arrData['prodheight'], GetConfig('DimensionsDecimalPlaces'), GetConfig('DimensionsDecimalToken'), "");
				}

				if (CFloat($arrData['proddepth']) > 0) {
					$GLOBALS['ProdDepth'] = number_format($arrData['proddepth'], GetConfig('DimensionsDecimalPlaces'), GetConfig('DimensionsDecimalToken'), "");
				}

				if (CFloat($arrData['prodfixedshippingcost']) > 0) {
					$GLOBALS['ProdFixedShippingCost'] = number_format($arrData['prodfixedshippingcost'], GetConfig('DecimalPlaces'), GetConfig('DecimalToken'), "");
				}

				if ($arrData['prodfreeshipping'] == 1) {
					$GLOBALS['FreeShipping'] = 'checked="checked"';
				}

				if($arrData['prodrelatedproducts'] == -1) {
					$GLOBALS['IsProdRelatedAuto'] = 'checked="checked"';
				}
				else if(isset($arrData['prodrelated'])) {
					$GLOBALS['RelatedProductOptions'] = "";

					foreach ($arrData['prodrelated'] as $r) {
						$GLOBALS['RelatedProductOptions'] .= sprintf("<option value='%d'>%s</option>", $r[0], $r[1]);
					}
				}

				$GLOBALS['WrappingOptions'] = $this->BuildGiftWrappingSelect(explode(',', $arrData['prodwrapoptions']));
				$GLOBALS['HideGiftWrappingOptions'] = 'display: none';
				if($arrData['prodwrapoptions'] == 0) {
					$GLOBALS['WrappingOptionsDefaultChecked'] = 'checked="checked"';
				}
				else if($arrData['prodwrapoptions'] == -1) {
					$GLOBALS['WrappingOptionsNoneChecked'] = 'checked="checked"';
				}
				else {
					$GLOBALS['HideGiftWrappingOptions'] = '';
					$GLOBALS['WrappingOptionsCustomChecked'] = 'checked="checked"';
				}

				$GLOBALS['CurrentStockLevel'] = $arrData['prodcurrentinv'];
				$GLOBALS['LowStockLevel'] = $arrData['prodlowinv'];
				$GLOBALS["InvTrack_" . $arrData['prodinvtrack']] = 'checked="checked"';

				if ($arrData['prodinvtrack'] == 1) {
					$GLOBALS['OptionButtons'] = "ToggleProductInventoryOptions(true);";
				} else {
					$GLOBALS['OptionButtons'] = "ToggleProductInventoryOptions(false);";
				}


				if ($arrData['prodoptionsrequired'] == 1) {
					$GLOBALS['ProdOptionRequired'] = 'checked="checked"';
				}

				if ($arrData['prodtype'] == 1) {
					$GLOBALS['HideProductInventoryOptions'] = "none";
				}

				if (GetConfig('PricesIncludeTax')) {
					$GLOBALS['PriceMsg'] = GetLang('IncTax');
				} else {
					$GLOBALS['PriceMsg'] = GetLang('ExTax');
				}

				$GLOBALS['CustomFields'] = '';
				$GLOBALS['CustomFieldKey'] = 0;

				if (!empty($arrCustomFields)) {
					foreach ($arrCustomFields as $f) {
						$GLOBALS['CustomFieldName'] = isc_html_escape($f['name']);
						$GLOBALS['CustomFieldValue'] = isc_html_escape($f['value']);
						$GLOBALS['CustomFieldLabel'] = $this->GetFieldLabel(($GLOBALS['CustomFieldKey']+1), GetLang('CustomField'));

						if (!$GLOBALS['CustomFieldKey']) {
							$GLOBALS['HideCustomFieldDelete'] = 'none';
						} else {
							$GLOBALS['HideCustomFieldDelete'] = '';
						}

						$GLOBALS['CustomFields'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('CustomFields');

						$GLOBALS['CustomFieldKey']++;
					}
				}

				// Add one more custom field
				$GLOBALS['CustomFieldName'] = '';
				$GLOBALS['CustomFieldValue'] = '';
				$GLOBALS['CustomFieldLabel'] = $this->GetFieldLabel(($GLOBALS['CustomFieldKey']+1), GetLang('CustomField'));

				if (!$GLOBALS['CustomFieldKey']) {
					$GLOBALS['HideCustomFieldDelete'] = 'none';
				} else {
					$GLOBALS['HideCustomFieldDelete'] = '';
				}

				$GLOBALS['CustomFields'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('CustomFields');

				// Get the brands as select options
				$GLOBALS['ISC_CLASS_ADMIN_BRANDS'] = GetClass('ISC_ADMIN_BRANDS');
				$GLOBALS['BrandNameOptions'] = $GLOBALS['ISC_CLASS_ADMIN_BRANDS']->GetBrandsAsOptions($arrData['prodbrandid']);

				// Get a list of all layout files
				$layoutFile = 'product.html';
				if($arrData['prodlayoutfile']) {
					$layoutFile = $arrData['prodlayoutfile'];
				}
				$GLOBALS['LayoutFiles'] = GetCustomLayoutFilesAsOptions("product.html", $layoutFile);

				$GLOBALS['ProdPageTitle'] = $arrData['prodpagetitle'];
				$GLOBALS['ProdMetaKeywords'] = $arrData['prodmetakeywords'];
				$GLOBALS['ProdMetaDesc'] = $arrData['prodmetadesc'];
			}
			else {
				$Cats = array();
				$Description = GetLang('TypeProductDescHere');
				$Description_manu = GetLang('TypeManuDescHere');  //blessen
				$Description_war = GetLang('TypeWarDescHere');  //blessen
				$Description_ins = GetLang('TypeProductInstruction');  //blessen
				$Description_art = GetLang('TypeProductArticle');  //blessen
                $Description_featuredpoints = GetLang('TypeFeaturedPoints');  //blessen
				$GLOBALS['ProdType'] = 0;
				$GLOBALS["ProdType_1"] = 'checked="checked"';
				$GLOBALS['HideFile'] = "none";

				$visibleCategories = array();
				if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
					$vendorData = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendor();
					if($vendorData['vendoraccesscats']) {
						$visibleCategories = explode(',', $vendorData['vendoraccesscats']);
					}
				}
                /* In the below line GetCategoryOptions() is changed to GetCategoryOptionsProduct() for not allowing user 
                to add product to main category if it has sub category  -- Baskaran */
				$GLOBALS['CategoryOptions'] = $GLOBALS["ISC_CLASS_ADMIN_CATEGORY"]->GetCategoryOptionsProduct($Cats, "<option %s value='%d' id='category_old%d'>%s</option>", "selected=\"selected\"", "", false, '', $visibleCategories);
				$GLOBALS['RelatedCategoryOptions'] = $GLOBALS["ISC_CLASS_ADMIN_CATEGORY"]->GetCategoryOptions($Cats, "<option %s value='%d'>%s</option>", "selected=\"selected\"", "- ", false);
//blessen
				$wysiwygOptions = array(
					'id'		=> 'wysiwyg',
					'width'		=> '60%',
					'height'	=> '350px',
					'value'		=> $Description
				);

				$wysiwygOptions1 = array(
					'id'		=> 'wysiwyg1',
					'width'		=> '60%',
					'height'	=> '350px',
					'value'		=> $Description_manu
				);

				$wysiwygOptions2 = array(
					'id'		=> 'wysiwyg2',
					'width'		=> '60%',
					'height'	=> '350px',
					'value'		=> $Description_war
				);

$wysiwygOptions3 = array(
					'id'		=> 'wysiwyg3',
					'width'		=> '60%',
					'height'	=> '350px',
					'value'		=> $Description_ins
				);
$wysiwygOptions4 = array(
					'id'		=> 'wysiwyg4',
					'width'		=> '60%',
					'height'	=> '350px',
					'value'		=> $Description_art
				);     
                $wysiwygOptions5 = array(
                    'id'        => 'wysiwyg5',
                    'width'        => '60%',
                    'height'    => '350px',
                    'value'        => $Description_featuredpoints
                );
                
				$GLOBALS['WYSIWYG'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor($wysiwygOptions);
				$GLOBALS['WYSIWYG1'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor1($wysiwygOptions1);
				$GLOBALS['WYSIWYG2'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor1($wysiwygOptions2);
				$GLOBALS['WYSIWYG3'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor1($wysiwygOptions3);
				$GLOBALS['WYSIWYG4'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor1($wysiwygOptions4);
                $GLOBALS['WYSIWYG5'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor1($wysiwygOptions5);

				$GLOBALS['ProdVisible'] = "checked";
				$GLOBALS['ProdSortOrder'] = 0;
				$GLOBALS['AutoGenThumb'] = 'checked="checked"';
				$GLOBALS["InvTrack_0"] = 'checked="checked"';
				$GLOBALS['HideProductInventoryOptions'] = "none";
				$GLOBALS['CurrentStockLevel'] = 0;
				$GLOBALS['LowStockLevel'] = 0;
				$GLOBALS['OptionButtons'] = "ToggleProductInventoryOptions(false);";
				$GLOBALS['ExistingDownload'] = "false";
				$GLOBALS['HideUplaodThumbField'] = "none";
				$GLOBALS['IsProdRelatedAuto'] = 'checked="checked"';
				$GLOBALS['ProdIsTaxable'] = "checked";

				$GLOBALS['ProdAllowPurchases'] = 'checked="checked"';
				$GLOBALS['ProdCallForPricingLabel'] = GetLang('ProductCallForPricingDefault');

				// Get the brands as select options
				$GLOBALS['ISC_CLASS_ADMIN_BRANDS'] = GetClass('ISC_ADMIN_BRANDS');
				$GLOBALS['BrandNameOptions'] = $GLOBALS['ISC_CLASS_ADMIN_BRANDS']->GetBrandsAsOptions();

				$GLOBALS['CustomFieldKey'] = 0;
				$GLOBALS['CustomFieldName'] = '';
				$GLOBALS['CustomFieldValue'] = '';
				$GLOBALS['CustomFieldLabel'] = $this->GetFieldLabel(($GLOBALS['CustomFieldKey']+1), GetLang('CustomField'));
				$GLOBALS['HideCustomFieldDelete'] = 'none';
				$GLOBALS['CustomFields'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('CustomFields');

				$GLOBALS['WrappingOptions'] = $this->BuildGiftWrappingSelect();
				$GLOBALS['WrappingOptionsDefaultChecked'] = 'checked="checked"';
			}

			$GLOBALS['ProductFields'] = $this->_GetProductFieldsLayout(0);
            # Used to clear the HTML Editor image upload folder name Baskaran
            $_SESSION['congobrand'] = '';
            $_SESSION['congoseries'] = '';


			if(!gzte11(ISC_HUGEPRINT)) {
				$GLOBALS['HideVendorOption'] = 'display: none';
			}
			else {
				$vendorData = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendor();
				if(isset($vendorData['vendorid'])) {
					$GLOBALS['HideVendorSelect'] = 'display: none';
					$GLOBALS['CurrentVendor'] = isc_html_escape($vendorData['vendorname']);
                    $_SESSION['congobrand'] = $vendorData['vendorid'];
				}
				else {
					$GLOBALS['HideVendorLabel'] = 'display: none';
					if($PreservePost) {
						$GLOBALS['VendorList'] = $this->BuildVendorSelect($_POST['vendor']);
                        $_SESSION['congobrand'] = $_POST['vendor'];
					}
					else {
						$GLOBALS['VendorList'] = $this->BuildVendorSelect();
					}
				}
			}

			// Does this store have any categories?
			if(isset($GLOBALS['ISC_CLASS_ADMIN_CATEGORY']->catsById) && count($GLOBALS['ISC_CLASS_ADMIN_CATEGORY']->catsById) == 0) {
				$GLOBALS['NoCategoriesJS'] = 'true';
			}

			$GLOBALS['FormType'] = "AddingProduct";
			$GLOBALS['FormAction'] = "addProduct2";
			$GLOBALS['Title'] = GetLang('AddProductTitle');
			$GLOBALS['Intro'] = GetLang('AddProductIntro');

			$GLOBALS['ProductWeightHelp'] = sprintf(GetLang('ProductWeightHelp'), GetConfig('WeightMeasurement'));
			$GLOBALS['ProductWidthHelp'] = sprintf(GetLang('ProductWidthHelp'), isc_strtolower(GetConfig('LengthMeasurement')));
			$GLOBALS['ProductHeightHelp'] = sprintf(GetLang('ProductHeightHelp'), isc_strtolower(GetConfig('LengthMeasurement')));
			$GLOBALS['ProductDepthHelp'] = sprintf(GetLang('ProductDepthHelp'), isc_strtolower(GetConfig('LengthMeasurement')));

			$GLOBALS['HideMoreImages'] = "none";
            $GLOBALS['HideMoreInsImages'] = "none";  

			$GLOBALS['CurrentTab'] = 0;

			if(GetConfig('PricesIncludeTax')) {
				$GLOBALS['PriceMsg'] = GetLang('IncTax');
			}
			else {
				$GLOBALS['PriceMsg'] = GetLang('ExTax');
			}

			if($this->HasGD()) {
				$GLOBALS['ShowGDThumb'] = "";
				$GLOBALS['ShowNoGDThumb'] = "none";
			}
			else {
				$GLOBALS['ShowGDThumb'] = "none";
				$GLOBALS['ShowNoGDThumb'] = "";
			}

			if(!gzte11(ISC_MEDIUMPRINT)) {
				$GLOBALS['HideInventoryOptions'] = "none";
			}
			else {
				$GLOBALS['HideInventoryOptions'] = '';
			}

			$GLOBALS['ISC_LANG']['MaxUploadSize'] = sprintf(GetLang('MaxUploadSize'), GetMaxUploadSize());
			if(isset($_REQUEST['productHash'])) {
				// Get a list of any downloads associated with this product
				$GLOBALS['DownloadsGrid'] = $this->GetDownloadsGrid(0, $_REQUEST['productHash']);
				if($GLOBALS['DownloadsGrid'] == '') {
					$GLOBALS['DisplayDownloaadGrid'] = "none";
					$GLOBALS['DisplayDownloadUploadGap'] = 'none';
				}
				$GLOBALS['ProductHash'] = $_REQUEST['productHash'];
			}
			else {
				$GLOBALS['DisplayDownloaadGrid'] = "none";
				$GLOBALS['DisplayDownloadUploadGap'] = 'none';
				$GLOBALS['ProductHash'] = md5(time().uniqid(rand(), true));
			}

			// Get a list of all layout files
			$GLOBALS['LayoutFiles'] = GetCustomLayoutFilesAsOptions("product.html");

			// By default we have no variation selected
			$GLOBALS['IsNoVariation'] = 'checked="checked"';
			$GLOBALS['HideVariationList'] = "none";

			// If there are no variations then disable the option to choose one
			$numVariations = 0;
			$GLOBALS['VariationOptions'] = $this->GetVariationsAsOptions($numVariations);

			if($numVariations == 0) {
				$GLOBALS['VariationDisabled'] = "DISABLED";
				$GLOBALS['VariationColor'] = "#CACACA";
			}

			// By default we set variations to NO
			$GLOBALS['IsNoVariation'] = 'checked="checked"';

			// By default we set product options required to YES
			$GLOBALS['OptionsRequired'] = 'checked="checked"';

			// Display the discount rules
			$GLOBALS['DiscountRules'] = $this->GetDiscountRules(0);

			$GLOBALS['EventDateFieldName'] = GetLang('EventDateDefault');

			// Hide if we are not enabled
			if (!GetConfig('BulkDiscountEnabled')) {
				$GLOBALS['HideDiscountRulesWarningBox'] = '';
				$GLOBALS['DiscountRulesWarningText'] = GetLang('DiscountRulesNotEnabledWarning');
				$GLOBALS['DiscountRulesWithWarning'] = 'none';

			// Also hide it if this product has variations
			} else if (isset($arrData['prodvariationid']) && isId($arrData['prodvariationid'])) {
				$GLOBALS['HideDiscountRulesWarningBox'] = '';
				$GLOBALS['DiscountRulesWarningText'] = GetLang('DiscountRulesVariationWarning');
				$GLOBALS['DiscountRulesWithWarning'] = 'none';
			} else {
				$GLOBALS['HideDiscountRulesWarningBox'] = 'none';
				$GLOBALS['DiscountRulesWithWarning'] = '';
			}

			$GLOBALS['DiscountRulesEnabled'] = (int)GetConfig('BulkDiscountEnabled');

			if(!$GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Create_Category)) {
				$GLOBALS['HideCategoryCreation'] = 'display: none';
			}

            $GLOBALS['columncount'] = 1;
			$GLOBALS['SaveAndAddAnother'] = GetLang('SaveAndAddAnother');
			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("product.form");
			$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
		}

		/**
		* GetVariationsAsOptions
		* Get a list of variations as <OPTION>tags
		*
		* @param Int $NumVariations A reference variable to pass back how many variations there are
		* @param Int $Selected The ID of the variation to select
		* @return String
		*/
		public function GetVariationsAsOptions(&$NumVariations, $Selected=0)
		{
			$queryWhere = '';
			// Only fetch variations which belong to the current vendor
			if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
				$queryWhere .= " AND vvendorid='".(int)$GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()."'";
			}

			$query = "
				SELECT variationid, vname
				FROM [|PREFIX|]product_variations
				WHERE 1=1
			";
			$query .= $queryWhere;
			$query .= "ORDER BY vname ASC";
			$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
			$NumVariations = $GLOBALS["ISC_CLASS_DB"]->CountResult($result);
			$options = "";

			while($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
				if($row['variationid'] == $Selected) {
					$sel = 'selected="selected"';
				}
				else {
					$sel = "";
				}

				$options .= sprintf("<option value='%d' %s>%s</option>", $row['variationid'], $sel, isc_html_escape($row['vname']));
			}

			return $options;
		}

		public function EditProductStep2()
		{
            
            # Used to clear the HTML Editor image upload folder name Baskaran
            $_SESSION['congobrand'] = '';
            $_SESSION['congoseries'] = '';

			// Get the information from the form and add it to the database
			$prodId = (int)$_POST['productId'];
			$arrData = array();
			$arrImages = array();
            $arrVideos = array();                                                      //Added by Simha
            $arrUserVideos = array();                                                  //Added by Simha
			$arrCustomFields = array();
			$arrVariations = array();
			$err = "";

            if($_SERVER['CONTENT_LENGTH'] > 100*1024*1024) {     
                $this->EditProductStep1("You cannot upload files with total size more than 100MB", MSG_ERROR, false);
                return;
            }
            
			$this->_GetProductData($prodId, $existingData);
			$this->_GetProductData(0, $arrData);
			$arrImages = $this->_GetImageData();
            $arrVideos = $this->_GetVideoData();                                    //Added by Simha 
            $arrUserVideos = $this->_GetUserVideoData();                            //Added by Simha 
            
			$this->_GetCustomFieldData(0, $arrCustomFields);
			$this->_GetVariationData(0, $arrVariations);
			$this->_GetProductFieldData(0, $arrProductFields);

			//validate product fields
			$productFieldsError = $this->_ValidateProductFields($arrProductFields);
			if($productFieldsError != '') {
				$this->EditProductStep1($productFieldsError, MSG_ERROR, true);
				return;
			}

            if($_SERVER['CONTENT_LENGTH'] > 100*1024*1024) {
                $this->EditProductStep1("You cannot upload files with total size more than 100MB", MSG_ERROR, true);
                return;
            }
            
			$discount = $this->GetDiscountRulesData(0, true);

			// Does this user have permission to edit this product?
			if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() && $existingData['prodvendorid'] != $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
				FlashMessage(GetLang('Unauthorized'), MSG_ERROR, 'index.php?ToDo=viewProducts');
			}

			$downloadError = '';
			if (isset($_FILES['newdownload']) && isset($_FILES['newdownload']['tmp_name']) && $_FILES['newdownload']['tmp_name'] != '') {
				if (!$this->SaveProductDownload($downloadError)) {
					$this->EditProductStep1($downloadError, MSG_ERROR);
					return;
				}
			}

			// Does a product with the same name already exist?
			$query = "SELECT productid FROM [|PREFIX|]products WHERE lower(prodname)='".$GLOBALS['ISC_CLASS_DB']->Quote($arrData['prodname'])."' AND productid!='".$prodId."'";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$existingProduct = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

			if($existingProduct['productid']) {
				$this->EditProductStep1(GetLang('ProductWithSameNameExists'), MSG_ERROR, true);
				return;
			}
            /* Checks whether the vendor prefix has the value -- Baskaran */
            $queryprefix = $GLOBALS['ISC_CLASS_DB']->Query("SELECT vendorprefix FROM [|PREFIX|]vendors WHERE vendorid = '".$arrData['prodvendorid']."' LIMIT 0,1 ");
            $existingProduct = $GLOBALS['ISC_CLASS_DB']->Fetch($queryprefix);
            if($existingProduct['vendorprefix'] == '') {
                $this->EditProductStep1(GetLang('ProductWithoutVendorprefix'), MSG_ERROR, true);
                return;
            }
            /* Ends here */
			// Validate out discount rules
			if (!empty($discount) && !$this->ValidateDiscountRulesData($error)) {
				$_POST['currentTab'] = 7;
				$this->EditProductStep1($error, MSG_ERROR, true);
				return;
			}

			// Commit the values to the database
			if ($this->_CommitProduct($prodId, $arrData, $arrImages, $arrVideos, $arrUserVideos, $arrVariations, $arrCustomFields, $discount, $err, $arrProductFields)) {
			
				// calling the background process to update the price of the products
				$this->UpdatePriceInBackground($prodId);

				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Products)) {

					// Log this action
					$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($prodId, $arrData['prodname']);

					// Save the words to the product_words table for search spelling suggestions
					$this->SaveProductWords($arrData['prodname'], $prodId, "editing");

					if(isset($_POST['addanother'])) {
						$_GET['productId'] = $prodId;
						$this->EditProductStep1(GetLang('ProductUpdatedSuccessfully'), MSG_SUCCESS);
					}
                    else if(isset($_POST['addview'])) {
                        $link = ProdLink($arrData['prodname']);
                        echo "<script language=\"javascript\">\n"; 
                        echo "var link = \"$link\"\n";
                        echo "window.open(link)\n";
                        echo "window.location.href='index.php?ToDo=viewProducts';\n"; 
                        echo "</script>\n";
                        exit; 
                    }
					else {
						FlashMessage(GetLang('ProductUpdatedSuccessfully'), MSG_SUCCESS);
						header("Location: index.php?ToDo=viewProducts");
						exit;
					}
				} else {
					FlashMessage(GetLang('ProductUpdatedSuccessfully'), MSG_SUCCESS);
					header("Location: index.php");
					exit;
				}
			} else {
				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Products)) {
					$this->ManageProducts(sprintf(GetLang('ErrProductNotUpdated'), $err), MSG_ERROR);
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(sprintf(GetLang('ErrProductNotUpdated'), $err), MSG_ERROR);
				}
			}
		}

		public function EditProductStep1($MsgDesc = "", $MsgStatus = "", $PreservePost=false)
		{
			if ($MsgDesc != "") {
				$GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
			}

			// Show the form to edit a product
            if(isset($_REQUEST['productId']))    {
			    $prodId = (int)$_REQUEST['productId'];
            }
            else    {
                $prodId             = (int)$_SESSION['productId'];
                $_POST['productId'] = $prodId; 
                $_GET['productId']  = $prodId;
            }

			$z = 0;
            $_SESSION['productId'] = $prodId;
            /*if($_SESSION['productId'] != '') {
                $prodId = $_SESSION['productId']
            }
            else {
                $_SESSION['productId'] = $prodId; 
            }*/
            
            /* Baskaran starts*/
            $user = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetUser();
            $userrole = $user['userrole'];
            if($userrole != 'admin') {
                $GLOBALS['hideradio'] = 'none';
            }
            else {
                $GLOBALS['hideradio'] = '';
            }
            /* Baskaran ends*/
            
			$arrData = array();
			$arrImages = array();
            $arrVideos = array();    
            $arrUserVideos = array(); 
			$arrCustomFields = array();

			if (GetConfig('CurrencyLocation') == 'right') {
				$GLOBALS['CurrencyTokenLeft'] = '';
				$GLOBALS['CurrencyTokenRight'] = GetConfig('CurrencyToken');
			} else {
				$GLOBALS['CurrencyTokenLeft'] = GetConfig('CurrencyToken');
				$GLOBALS['CurrencyTokenRight'] = '';
			}

			$GLOBALS['ServerFiles'] = $this->_GetImportFilesOptions();

			$GLOBALS['ISC_CLASS_ADMIN_CATEGORY'] = GetClass('ISC_ADMIN_CATEGORY');

			// Make sure the product exists
			if (ProductExists($prodId)) {
				$this->_GetProductData($prodId, $arrData);

                $query = "select instructionfile, instructiontype, systeminstructionfile from [|PREFIX|]instruction_files where instructionprodid='".$GLOBALS['ISC_CLASS_DB']->Quote($prodId)."' AND (instructionfile LIKE '%.pdf%' || systeminstructionfile LIKE '%.pdf%')";
                $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
                $_SESSION['temp_instruction_file'] = "";
                if ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {  
                    if($row['systeminstructionfile'] != "" && $row['systeminstructionfile'] != null)  {
                        $_SESSION['temp_instruction_file'] = $row['systeminstructionfile'];
                    }
                    else {
                        $_SESSION['temp_instruction_file'] = $row['instructionfile'];
                    }
                }
                
                $query = "select articlefile, articletype, systemarticlefile from [|PREFIX|]article_files where articleprodid='".$GLOBALS['ISC_CLASS_DB']->Quote($prodId)."' AND (articlefile LIKE '%.pdf%' || systemarticlefile LIKE '%.pdf%')";
                $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
                $_SESSION['temp_article_file'] = "";
                if ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {  
                    if($row['systemarticlefile'] != "" && $row['systemarticlefile'] != null)  {
                        $_SESSION['temp_article_file'] = $row['systemarticlefile'];
                    }
                    else {
                        $_SESSION['temp_article_file'] = $row['articlefile'];
                    }
                }
                
				// Does this user have permission to edit this product?
				if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() && $arrData['prodvendorid'] != $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
					FlashMessage(GetLang('Unauthorized'), MSG_ERROR, 'index.php?ToDo=viewProducts');
				}

				$arrImages = $this->_GetImageData($prodId);
                $arrVideos = $this->_GetVideoData($prodId); 
                $arrUserVideos = $this->_GetUserVideoData($prodId);

				if($PreservePost == true) {
					$this->_GetProductData(0, $arrData);
					$arrImages = $this->_GetImageData();                
					$this->_GetCustomFieldData(0, $arrCustomFields);
					$GLOBALS['ProductFields'] = $this->_GetProductFieldsLayout(0);
				} else {
					$this->_GetCustomFieldData($prodId, $arrCustomFields);
					$arrImages = $this->_GetImageData($prodId);
					$GLOBALS['ProductFields'] = $this->_GetProductFieldsLayout($prodId);
				}

				if(isset($_POST['currentTab'])) {
					$GLOBALS['CurrentTab'] = (int)$_POST['currentTab'];
				}
				else {
					$GLOBALS['CurrentTab'] = 0;
				}

				$GLOBALS['FormAction'] = "editProduct2";
				$GLOBALS['ProductId'] = $prodId;
				$GLOBALS['Title'] = GetLang('EditProductTitle');
				$GLOBALS['Intro'] = GetLang('EditProductIntro');
				$GLOBALS["ProdType_" . $arrData['prodtype']] = 'checked="checked"';
				$GLOBALS['ProdType'] = $arrData['prodtype'] - 1;
				$GLOBALS['ProdCode'] = isc_html_escape($arrData['prodcode']);
				$GLOBALS['ProdHash'] = '';

				$GLOBALS['ProdTags'] = isc_html_escape($arrData['prodtags']);


				$GLOBALS['ProdName'] = isc_html_escape($arrData['prodname']);
				$visibleCategories = array();
				if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
					$vendorData = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendor();
					if($vendorData['vendoraccesscats']) {
						$visibleCategories = explode(',', $vendorData['vendoraccesscats']);
					}
				}

                /* In the below line GetCategoryOptions() is changed to GetCategoryOptionsProduct() for not allowing user 
                to add product to main category if it has sub category  -- Baskaran */
				$GLOBALS['CategoryOptions'] = $GLOBALS["ISC_CLASS_ADMIN_CATEGORY"]->GetCategoryOptionsProduct($arrData['prodcats'], "<option %s value='%d' id='category_old%d'>%s</option>", "selected=\"selected\"", "", false, '', $visibleCategories);
				$GLOBALS['RelatedCategoryOptions'] = $GLOBALS["ISC_CLASS_ADMIN_CATEGORY"]->GetCategoryOptions(0, "<option %s value='%d'>%s</option>", "selected=\"selected\"", "- ", false);
//blessen
				$wysiwygOptions = array(
					'id'		=> 'wysiwyg',
					'width'		=> '60%',
					'height'	=> '350px',
					'value'		=> $arrData['proddesc']
				);

				$wysiwygOptions1 = array(
					'id'		=> 'wysiwyg1',
					'width'		=> '60%',
					'height'	=> '350px',
					'value'		=> $arrData['prodmfg']
				);

				$wysiwygOptions2 = array(
					'id'		=> 'wysiwyg2',
					'width'		=> '60%',
					'height'	=> '350px',
					'value'		=> $arrData['prodwarranty']
				);
				$wysiwygOptions3 = array(
					'id'		=> 'wysiwyg3',
					'width'		=> '60%',
					'height'	=> '350px',
					'value'		=> $arrData['prod_instruction']
				);
				$wysiwygOptions4 = array(
					'id'		=> 'wysiwyg4',
					'width'		=> '60%',
					'height'	=> '350px',
					'value'		=> $arrData['prod_article']
				);  
                $wysiwygOptions5 = array(
                    'id'        => 'wysiwyg5',
                    'width'        => '60%',
                    'height'    => '350px',
                    'value'        => $arrData['proddescfeature']
                );
                
				$GLOBALS['WYSIWYG'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor($wysiwygOptions);
				$GLOBALS['WYSIWYG1'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor1($wysiwygOptions1);
				$GLOBALS['WYSIWYG2'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor1($wysiwygOptions2);
				$GLOBALS['WYSIWYG3'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor1($wysiwygOptions3);
				$GLOBALS['WYSIWYG4'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor1($wysiwygOptions4);
                $GLOBALS['WYSIWYG5'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor1($wysiwygOptions5);

				$GLOBALS['ProdMfg'] = $arrData['prodmfg']; /* added by vikas-clarion, for storing manufacturer data */



				$pos1 = stripos($_SESSION['temp_instruction_file'], "http://");

				if ($pos1 === false) {
					$ins_path =  "../instruction_file/".$_SESSION['temp_instruction_file'];
				} else {
					$ins_path = $_SESSION['temp_instruction_file'];
				}


				$pos2 = stripos($_SESSION['temp_article_file'], "http://");

				if ($pos2 === false) {
					 $art_path =  "../article_file/".$_SESSION['temp_article_file'];
				} else {
					 $art_path = $_SESSION['temp_article_file'];
				}

				if ($_SESSION['temp_instruction_file'] != "")
				$GLOBALS['instruction_file'] = '<label><input type="checkbox" value="1" name="delete_instruction_file" id="delete_instruction_file" /> Delete Current Instruction file</label> <a href="'.$ins_path.'" target="_blank">'.$_SESSION['temp_instruction_file'].'</a>';
				else
				$GLOBALS['instruction_file'] = "No Instruction file Found ";

				if ($_SESSION['temp_article_file'] != "")
				$GLOBALS['article_file'] = '<label><input type="checkbox" value="1" name="delete_article_file" id="delete_article_file" /> Delete Current Article file </label> <a href="'.$art_path.'" target="_blank">'.$_SESSION['temp_article_file'].'</a>';
				else
				$GLOBALS['article_file'] =  "No Article file Found ";

				



				$GLOBALS['ProdSearchKeywords'] = isc_html_escape($arrData['prodsearchkeywords']);
				$GLOBALS['ProdAvailability'] = isc_html_escape($arrData['prodavailability']);
				$GLOBALS['ProdPrice'] = number_format($arrData['prodprice'], GetConfig('DecimalPlaces'), GetConfig('DecimalToken'), "");


				/*Baskaran Added Starts*/
				$GLOBALS['pricelogupdatetime'] = $arrData['price_update_time'];     
                $GLOBALS['Skubarcode'] = $arrData['skubarcode'];                         //Added by Simha
                $GLOBALS['Skucreationtime'] = $arrData['SKU_creation_time'];
                $GLOBALS['Skulastupdatetime'] = $arrData['SKU_last_update_time'];
                $GLOBALS['PriceLog'] = $arrData['price_log'];
                $GLOBALS['Jobberprice'] = $arrData['jobberprice'];
                $GLOBALS['Mapprice'] = $arrData['mapprice'];
                $GLOBALS['Unilateralprice'] = $arrData['unilateralprice'];

				$GLOBALS['single'] = '';
				$GLOBALS['multiple'] = '';
				if ($arrData['comp_type'] == 0)
                $GLOBALS['single'] = 'Checked';
				else
				 $GLOBALS['multiple'] = 'Checked';


                $GLOBALS['Ourcost'] = $arrData['ourcost'];
                $GLOBALS['Packagelength'] = $arrData['package_length'];
                $GLOBALS['Packagewidth'] = $arrData['package_width'];
                $GLOBALS['Packageheight'] = $arrData['package_height'];
                $GLOBALS['Packageweight'] = $arrData['package_weight'];
                $GLOBALS['Productseries'] = $this->Seriesname($arrData['prodbrandid'],$arrData['brandseriesid']);
                $GLOBALS['Futureretailprice'] = $arrData['future_retail_price'];
                $GLOBALS['Futurejobberprice'] = $arrData['future_jobber_price'];
                $GLOBALS['ProductVariationList'] = $this->BuildProductVariation(0,$prodId); 

			
                $display = "select * from [|PREFIX|]qualifier_names ";
				 $displayresult = $GLOBALS["ISC_CLASS_DB"]->Query($display);
				 $displayname1 = array();
				 while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($displayresult)) {
				   $displayname1[$row["column_name"]] = $row["display_names"];
				  }  


				
				$html = '<tr>';
				$i = 0;
                $col = array();
				$categoryid = implode(",", $arrData['prodcats']);
                $column = "SELECT DISTINCT(qn.column_name) FROM [|PREFIX|]qualifier_associations qa INNER JOIN [|PREFIX|]qualifier_names qn ON qa.qualifierid = qn.qid and qa.categoryid in ($categoryid)";
                $rescol = $GLOBALS["ISC_CLASS_DB"]->Query($column); 
                while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($rescol)) {

                    $value = $row["column_name"];
					$col[] = $row["column_name"];
					if ($displayname1[$value] != "") $displayname = $displayname1[$value];
						else
						$displayname = $value;

						$html .= '<td class="FieldLabel">&nbsp;&nbsp;&nbsp;'.$displayname.':</td>';
						 $html .= '<td><input type="text" id="'.$value.'" name="'.$value.'" class="Field150" value="" readonly="true"></td>';		  
						$i++;
						 if (($i%2) == 0) $html.="</tr><tr>";
	                }  
	
 					$html.= '</tr>';
				 


                    $cntdisplay = $i;
                    $d = "var column = new Array();\n";
                    foreach($col as $key_column => $name) {
                        $quote = '"';
                        $d .= "column['".$key_column."'] = ".$quote.$name.$quote.";\n";
                    }
                    
                    $GLOBALS['columnname'] = $d;
                    $GLOBALS["vqhtml"] = $html;
                
                $GLOBALS['columncount'] = count($col);
//                echo $html;exit;

				$comphidden = '';  //blessen

                $Impvar = $this->importvaritaion($prodId);
                if(!empty($Impvar)) {
                    $a  = "var improd = new Array();\n"; 
                    foreach($Impvar as $key => $value) {
                        $a .= "var item = new Array();\n";
                        foreach($value as $k => $v)   {
                            $q = '"';
                             $item = "item['".$k."'] = ".$q.$v.$q.";\n";
                             $a .= $item;
                        }      
                        $a .= "improd['".$value['id']."'] = item;";

						$comphidden.= '<INPUT TYPE="hidden" name = "comphidden['.$value['id'].']" id = "comphidden['.$value['id'].']"  >';  //blessen
                    }
                    $GLOBALS['Impvariation'] = $a;            
                }
				
				/*Baskaran Added Ends*/

				// blessen
				$appdata = $this->applicationdata($prodId);
				 $temp  = "var comp = new Array();\n"; 
							
				 foreach($appdata as $key => $value) {
					
					$comp = str_replace("'","\'", htmlspecialchars_decode($value['complementaryitems']));
					$comp = str_replace("\n","",$comp);
					//$comp = strip_tags($comp);

						 $varid = $value['variationid']	;
                         $temp.= "comp['".$varid."'] = '".$comp."';\n";
					                       
                    }
				
				
				$GLOBALS['Complementaryitems'] = $temp;
				$GLOBALS['Complementaryhidden'] = $comphidden;

				if (CFloat($arrData['prodcostprice']) > 0) {
					$GLOBALS['ProdCostPrice'] = number_format($arrData['prodcostprice'], GetConfig('DecimalPlaces'), GetConfig('DecimalToken'), "");
				}

				if (CFloat($arrData['prodretailprice']) > 0) {
					$GLOBALS['ProdRetailPrice'] = number_format($arrData['prodretailprice'], GetConfig('DecimalPlaces'), GetConfig('DecimalToken'), "");
				}

				if (CFloat($arrData['prodsaleprice']) > 0) {
					$GLOBALS['ProdSalePrice'] = number_format($arrData['prodsaleprice'], GetConfig('DecimalPlaces'), GetConfig('DecimalToken'), "");
				}

				$GLOBALS['ProdSortOrder'] = $arrData['prodsortorder'];

				if ($arrData['prodvisible'] == 1) {
					$GLOBALS['ProdVisible'] = "checked";
				}

				if ($arrData['prodfeatured'] == 1) {
					$GLOBALS['ProdFeatured'] = "checked";
				}

				if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
					$GLOBALS['HideStoreFeatured'] = 'display: none';
				}
				else if(!gzte11(ISC_HUGEPRINT) || !$arrData['prodvendorid']) {
					$GLOBALS['HideVendorFeatured'] = 'display: none';
				}

				if($arrData['prodvendorfeatured'] == 1) {
					$GLOBALS['ProdVendorFeatured'] = 'checked="checked"';
				}

				if($arrData['prodistaxable'] == 1) {
					$GLOBALS['ProdIsTaxable'] = 'checked';
				}

				if($arrData['prodallowpurchases'] == 1) {
					$GLOBALS['ProdAllowPurchases'] = 'checked="checked"';
				}
				else {
					if($arrData['prodhideprice'] == 1) {
						$GLOBALS['ProdHidePrice'] = 'checked="checked"';
					}
					$GLOBALS['ProdCallForPricingLabel'] = isc_html_escape($arrData['prodcallforpricinglabel']);
				}

				$GLOBALS['MoreImages'] = "MoreImages();";
				$GLOBALS['MoreInsImages'] = "MoreInsImages();";    

				
                for ($i = 1; $i <= $arrImages['numImages']; $i++) {
                    $image = sprintf("../%s/%s", GetConfig('ImageDirectory'), $arrImages["image" . $i]);
                    $GLOBALS['ImageMessage'.$i] = '';
                    if(isset($arrImages['id'.$i])) {
                        $GLOBALS['ImageMessage'.$i] = '<label><input type="checkbox" value="1" name="delete_image_'.$arrImages['id'.$i].'" id="delete_image_'.$arrImages['id'.$i].'" /> '.GetLang('EditImageFileDelete').'</label> <a href="'.$image.'" target="_blank">'.$arrImages['image'.$i].'</a>';
                    }
                }
                
                for ($i = 1; $i <= $arrImages['numInsImages']; $i++) {
                    $image = sprintf("../%s/%s", GetConfig('InstallImageDirectory'), $arrImages["insimage" . $i]);
                    $GLOBALS['ImageInsMessage'.$i] = '';
                    if(isset($arrImages['insid'.$i])) {
                        $GLOBALS['ImageInsMessage'.$i] = '<label><input type="checkbox" value="1" name="delete_insimage_'.$arrImages['insid'.$i].'" id="delete_insimage_'.$arrImages['insid'.$i].'" /> '.GetLang('EditImageFileDelete').'</label> <a href="'.$image.'" target="_blank">'.$arrImages['insimage'.$i].'</a>';
                    }
                }
                
                $GLOBALS['ExistingVideos'] = ''; 
                //Added by Simha for Video    
                for ($i = 1; $i <= $arrVideos['numVideos']; $i++) {     
                    $GLOBALS['VideoMessage'.$i] = '';  
                    if(isset($arrVideos['id'.$i])) {
                        $GLOBALS['VideoMessage'.$i] = '<label><input type="checkbox" value="1" name="delete_video_'.$arrVideos['id'.$i].'" id="delete_video_'.$i.'" /> '.GetLang('EditVideoFileDelete').'</label>&nbsp;&nbsp;'.$arrVideos['video'.$i].'';
                        if($arrVideos['isdownloaded'.$i]==2 || $arrVideos['isdownloaded'.$i]==3)    {
                              $GLOBALS['VideoMessage'.$i] .= " <b>File : ".$arrVideos['systemvideofile'.$i]." - ".$arrVideos['isdownloaded'.$i]."</b>";
                        }
                    }
                    if($i > 1)    {
                    $GLOBALS['ExistingVideos'] .= '<div class="irow ExpandLink"><div style="height: 27px;"><input type="text" name="prodVideo[]" class="Field"/><span>'.$GLOBALS['VideoMessage'.$i].'</span></div></div>';
                    }
                }        
                
                $GLOBALS['ExistingInsVideos'] = ''; 
                //Added by Simha for Video    
                for ($i = 1; $i <= $arrVideos['numInsVideos']; $i++) {
                    $GLOBALS['InsVideoMessage'.$i] = '';  
                    if(isset($arrVideos['insid'.$i])) {
                        $GLOBALS['InsVideoMessage'.$i] = '<label><input type="checkbox" value="1" name="delete_insvideo_'.$arrVideos['insid'.$i].'" id="delete_insvideo_'.$i.'" /> '.GetLang('EditVideoFileDelete').'</label>&nbsp;&nbsp;'.$arrVideos['insvideo'.$i].'';
                        if($arrVideos['insisdownloaded'.$i]==2 || $arrVideos['insisdownloaded'.$i]==3)    {
                              $GLOBALS['InsVideoMessage'.$i] .= " <b>File : ".$arrVideos['inssystemvideofile'.$i]." - ".$arrVideos['insisdownloaded'.$i]."</b>";
                        }
                    }
                    if($i > 1)    {
                    $GLOBALS['ExistingInsVideos'] .= '<div class="irow ExpandLink"><div style="height: 27px;"><input type="text" name="insVideo[]" class="Field"/><span>'.$GLOBALS['InsVideoMessage'.$i].'</span></div></div>';
                    }
                }            
                
                $GLOBALS['ExistingUserVideos'] = ''; 
                
                //Added by Simha for User Video    
                for ($i = 1; $i <= $arrUserVideos['numUserVideos']; $i++) {     
                    $GLOBALS['UserVideoMessage'.$i] = '';  
                    if(isset($arrUserVideos['uservideoid'.$i])) {
                        $GLOBALS['UserVideoMessage'.$i] = '<label><input type="checkbox" value="1" name="delete_uservideo_'.$arrUserVideos['uservideoid'.$i].'" id="delete_uservideo_'.$i.'" /> '.GetLang('EditVideoFileDelete').'</label>&nbsp;&nbsp;'.$arrUserVideos['uservideo'.$i].'';
                    }
                    if($i > 1)    {
                    $GLOBALS['ExistingUserVideos'] .= '<div class="irow ExpandLink"><div style="height: 27px;"><input type="file" name="userVideo[]" class="Field"/><span>'.$GLOBALS['UserVideoMessage'.$i].'</span></div></div>';
                    }
                }            
                
                $GLOBALS['ExistingUserInsVideos'] = '';         
                
                //Added by Simha for User Install Video    
                for ($i = 1; $i <= $arrUserVideos['numUserInsVideos']; $i++) {     
                    $GLOBALS['UserInsVideoMessage'.$i] = '';  
                    if(isset($arrUserVideos['userinsvideoid'.$i])) {
                        $GLOBALS['UserInsVideoMessage'.$i] = '<label><input type="checkbox" value="1" name="delete_userinsvideo_'.$arrUserVideos['userinsvideoid'.$i].'" id="delete_userinsvideo_'.$i.'" /> '.GetLang('EditVideoFileDelete').'</label>&nbsp;&nbsp;'.$arrUserVideos['userinsvideo'.$i].'';
                    }
                    if($i > 1)    {
                        $GLOBALS['ExistingUserInsVideos'] .= '<div class="irow ExpandLink"><div style="height: 27px;"><input type="file" name="userInsVideo[]" class="Field"/><span>'.$GLOBALS['UserInsVideoMessage'.$i].'</span></div></div>';
                    }
                }  
                

				if(isset($arrImages['thumb'])) {
					$thumb = sprintf("../%s/%s", GetConfig('ImageDirectory'), $arrImages['thumb']);
					$GLOBALS['ThumbMessage'] = '<label><input type="checkbox" value="1" name="delete_image_thumb" id="delete_image_thumb" /> '.GetLang('EditImageFileDelete').'</label> <a href="'.$thumb.'" target="_blank">'.$arrImages['thumb'].'</a>';
				}
//blessen  error may come if wysiwyg editor is disabled from admin panel

				//$GLOBALS['ProdWarranty']  = $arrData['prodwarranty'];
				//$GLOBALS['prod_instruction'] = $arrData['prod_instruction'];
				//$GLOBALS['prod_article'] = $arrData['prod_article'];

				$GLOBALS['ProdWeight'] = number_format($arrData['prodweight'], GetConfig('DimensionsDecimalPlaces'), GetConfig('DimensionsDecimalToken'), "");

				if (CFloat($arrData['prodwidth']) > 0) {
					$GLOBALS['ProdWidth'] = number_format($arrData['prodwidth'], GetConfig('DimensionsDecimalPlaces'), GetConfig('DimensionsDecimalToken'), "");
				}

				if (CFloat($arrData['prodheight']) > 0) {
					$GLOBALS['ProdHeight'] = number_format($arrData['prodheight'], GetConfig('DimensionsDecimalPlaces'), GetConfig('DimensionsDecimalToken'), "");
				}

				if (CFloat($arrData['proddepth']) > 0) {
					$GLOBALS['ProdDepth'] = number_format($arrData['proddepth'], GetConfig('DimensionsDecimalPlaces'), GetConfig('DimensionsDecimalToken'), "");
				}

				if (CFloat($arrData['prodfixedshippingcost']) > 0) {
					$GLOBALS['ProdFixedShippingCost'] = number_format($arrData['prodfixedshippingcost'], GetConfig('DecimalPlaces'), GetConfig('DecimalToken'), "");
				}

				if ($arrData['prodfreeshipping'] == 1) {
					$GLOBALS['FreeShipping'] = 'checked="checked"';
				}

				if($arrData['prodrelatedproducts'] == -1) {
					$GLOBALS['IsProdRelatedAuto'] = 'checked="checked"';
				}
				else if(isset($arrData['prodrelated'])) {
					$GLOBALS['RelatedProductOptions'] = "";

					foreach ($arrData['prodrelated'] as $r) {
						$GLOBALS['RelatedProductOptions'] .= sprintf("<option value='%d'>%s</option>", (int) $r[0], isc_html_escape($r[1]));
					}
				}

				$GLOBALS['CurrentStockLevel'] = $arrData['prodcurrentinv'];
				$GLOBALS['LowStockLevel'] = $arrData['prodlowinv'];
				$GLOBALS["InvTrack_" . $arrData['prodinvtrack']] = 'checked="checked"';

				if ($arrData['prodinvtrack'] == 1) {
					$GLOBALS['OptionButtons'] = "ToggleProductInventoryOptions(true);";
				} else {
					$GLOBALS['OptionButtons'] = "ToggleProductInventoryOptions(false);";
				}

				if ($arrData['prodoptionsrequired'] == 1) {
					$GLOBALS['OptionsRequired'] = 'checked="checked"';
				}

				if ($arrData['prodtype'] == 1) {
					$GLOBALS['HideProductInventoryOptions'] = "none";
				}

				$GLOBALS['EnterOptionPrice'] = sprintf(GetLang('EnterOptionPrice'), GetConfig('CurrencyToken'), GetConfig('CurrencyToken'));
				$GLOBALS['EnterOptionWeight'] = sprintf(GetLang('EnterOptionWeight'), GetConfig('WeightMeasurement'));
				$GLOBALS['HideCustomFieldLink'] = "none";

				if (GetConfig('PricesIncludeTax')) {
					$GLOBALS['PriceMsg'] = GetLang('IncTax');
				} else {
					$GLOBALS['PriceMsg'] = GetLang('ExTax');
				}

				$GLOBALS['ProductFields'] = $this->_GetProductFieldsLayout($prodId);

				$GLOBALS['CustomFields'] = '';
				$GLOBALS['CustomFieldKey'] = 0;

				if (!empty($arrCustomFields)) {
					foreach ($arrCustomFields as $f) {
						$GLOBALS['CustomFieldName'] = isc_html_escape($f['name']);
						$GLOBALS['CustomFieldValue'] = isc_html_escape($f['value']);
						$GLOBALS['CustomFieldLabel'] = $this->GetFieldLabel(($GLOBALS['CustomFieldKey']+1), GetLang('CustomField'));

						if (!$GLOBALS['CustomFieldKey']) {
							$GLOBALS['HideCustomFieldDelete'] = 'none';
						} else {
							$GLOBALS['HideCustomFieldDelete'] = '';
						}

						$GLOBALS['CustomFields'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('CustomFields');

						$GLOBALS['CustomFieldKey']++;
					}
				}

				// Add one more custom field
				$GLOBALS['CustomFieldName'] = '';
				$GLOBALS['CustomFieldValue'] = '';
				$GLOBALS['CustomFieldLabel'] = $this->GetFieldLabel(($GLOBALS['CustomFieldKey']+1), GetLang('CustomField'));

				if (!$GLOBALS['CustomFieldKey']) {
					$GLOBALS['HideCustomFieldDelete'] = 'none';
				} else {
					$GLOBALS['HideCustomFieldDelete'] = '';
				}

				$GLOBALS['CustomFields'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('CustomFields');

				if ($this->HasGD()) {
					$GLOBALS['ShowGDThumb'] = "";
					$GLOBALS['ShowNoGDThumb'] = "none";
				} else {
					$GLOBALS['ShowGDThumb'] = "none";
					$GLOBALS['ShowNoGDThumb'] = "";
				}

				$GLOBALS['ProductHash'] = '';

				// Get a list of any downloads associated with this product
				$GLOBALS['DownloadsGrid'] = $this->GetDownloadsGrid($prodId);
				$GLOBALS['ISC_LANG']['MaxUploadSize'] = sprintf(GetLang('MaxUploadSize'), GetMaxUploadSize());
				if($GLOBALS['DownloadsGrid'] == '') {
					$GLOBALS['DisplayDownloaadGrid'] = "none";
				}

				// Get the brands as select options
				$GLOBALS['ISC_CLASS_ADMIN_BRANDS'] = GetClass('ISC_ADMIN_BRANDS');
				$GLOBALS['BrandNameOptions'] = $GLOBALS['ISC_CLASS_ADMIN_BRANDS']->GetBrandsAsOptions($arrData['prodbrandid']);
				$GLOBALS['SaveAndAddAnother'] = GetLang('SaveAndContinueEditing');

				// Get a list of all layout files
				$layoutFile = 'product.html';
				if($arrData['prodlayoutfile'] != '') {
					$layoutFile = $arrData['prodlayoutfile'];
				}
				$GLOBALS['LayoutFiles'] = GetCustomLayoutFilesAsOptions("product.html", $layoutFile);

				$GLOBALS['ProdPageTitle'] = isc_html_escape($arrData['prodpagetitle']);
				$GLOBALS['ProdMetaKeywords'] = isc_html_escape($arrData['prodmetakeywords']);
				$GLOBALS['ProdMetaDesc'] = isc_html_escape($arrData['prodmetadesc']);
				$GLOBALS['SaveAndAddAnother'] = GetLang('SaveAndContinueEditing');

				if(!gzte11(ISC_MEDIUMPRINT)) {
					$GLOBALS['HideInventoryOptions'] = "none";
				}
				else {
					$GLOBALS['HideInventoryOptions'] = '';
				}

				// Does this product have a variation assigned to it?
				$GLOBALS['ProductVariationExisting'] = $arrData['prodvariationid'];

				if($arrData['prodvariationid'] > 0) {
					$GLOBALS['IsYesVariation'] = 'checked="checked"';
				}
				else {
					$GLOBALS['IsNoVariation'] = 'checked="checked"';
					$GLOBALS['HideVariationList'] = "none";
					$GLOBALS['HideVariationCombinationList'] = "none";
				}

				// If there are no variations then disable the option to choose one
				$numVariations = 0;
				$GLOBALS['VariationOptions'] = $this->GetVariationsAsOptions($numVariations, $arrData['prodvariationid']);

				if($numVariations == 0) {
					$GLOBALS['VariationDisabled'] = "DISABLED";
					$GLOBALS['VariationColor'] = "#CACACA";
					$GLOBALS['IsNoVariation'] = 'checked="checked"';
					$GLOBALS['IsYesVariation'] = "";
					$GLOBALS['HideVariationCombinationList'] = "none";
				}
				else {
					// Load the variation combinations
					if($arrData['prodinvtrack'] == 2) {
						$show_inv_fields = true;
					}
					else {
						$show_inv_fields = false;
					}

					$GLOBALS['VariationCombinationList'] = $this->_LoadVariationCombinationsTable($arrData['prodvariationid'], $show_inv_fields, $arrData['productid']);
				}

				$GLOBALS['WrappingOptions'] = $this->BuildGiftWrappingSelect(explode(',', $arrData['prodwrapoptions']));
				$GLOBALS['HideGiftWrappingOptions'] = 'display: none';
				if($arrData['prodwrapoptions'] == 0) {
					$GLOBALS['WrappingOptionsDefaultChecked'] = 'checked="checked"';
				}
				else if($arrData['prodwrapoptions'] == -1) {
					$GLOBALS['WrappingOptionsNoneChecked'] = 'checked="checked"';
				}
				else {
					$GLOBALS['HideGiftWrappingOptions'] = '';
					$GLOBALS['WrappingOptionsCustomChecked'] = 'checked="checked"';
				}
                
                # Used to clear the HTML Editor image upload folder name Baskaran
                $_SESSION['congobrand'] = '';
                $_SESSION['congoseries'] = '';

				if(!gzte11(ISC_HUGEPRINT)) {
					$GLOBALS['HideVendorOption'] = 'display: none';
				}
				else {
					$vendorData = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendor();
					if(isset($vendorData['vendorid'])) {
						$GLOBALS['HideVendorSelect'] = 'display: none';
						$GLOBALS['CurrentVendor'] = isc_html_escape($vendorData['vendorname']);
                        $_SESSION['congobrand'] = $vendorData['vendorid'];
					}
					else {
						$GLOBALS['HideVendorLabel'] = 'display: none';
						$GLOBALS['VendorList'] = $this->BuildVendorSelect($arrData['prodvendorid']);
                        $GLOBALS['Vendorhdnid'] = $arrData['prodvendorid'];
                        $_SESSION['congobrand'] = $arrData['prodvendorid'];
					}
				}

				// Display the discount rules
				if ($PreservePost == true) {
					$GLOBALS['DiscountRules'] = $this->GetDiscountRules(0);
				} else {
					$GLOBALS['DiscountRules'] = $this->GetDiscountRules($prodId);
				}

				// Hide if we are not enabled
				if (!GetConfig('BulkDiscountEnabled')) {
					$GLOBALS['HideDiscountRulesWarningBox'] = '';
					$GLOBALS['DiscountRulesWarningText'] = GetLang('DiscountRulesNotEnabledWarning');
					$GLOBALS['DiscountRulesWithWarning'] = 'none';

				// Also hide it if this product has variations
				} else if (isset($arrData['prodvariationid']) && isId($arrData['prodvariationid'])) {
					$GLOBALS['HideDiscountRulesWarningBox'] = '';
					$GLOBALS['DiscountRulesWarningText'] = GetLang('DiscountRulesVariationWarning');
					$GLOBALS['DiscountRulesWithWarning'] = 'none';
				} else {
					$GLOBALS['HideDiscountRulesWarningBox'] = 'none';
					$GLOBALS['DiscountRulesWithWarning'] = '';
				}

				$GLOBALS['DiscountRulesEnabled'] = (int)GetConfig('BulkDiscountEnabled');

				if(!$GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Create_Category)) {
					$GLOBALS['HideCategoryCreation'] = 'display: none';
				}

				$GLOBALS['EventDateFieldName'] = $arrData['prodeventdatefieldname'];

				if ($GLOBALS['EventDateFieldName'] == null) {
					$GLOBALS['EventDateFieldName'] = GetLang('EventDateDefault');
				}

				if ($arrData['prodeventdaterequired'] == 1) {
					$GLOBALS['EventDateRequired'] = 'checked="checked"';
					$from_stamp = $arrData['prodeventdatelimitedstartdate'];
					$to_stamp = $arrData['prodeventdatelimitedenddate'];
				} else {
					$from_stamp = isc_gmmktime(0, 0, 0, isc_date("m"), isc_date("d"), isc_date("Y"));
					$to_stamp = isc_gmmktime(0, 0, 0, isc_date("m")+1, isc_date("d"), isc_date("Y"));
				}
				if ($arrData['prodeventdatelimited'] == 1) {
					$GLOBALS['LimitDates'] = 'checked="checked"';
				}

				$GLOBALS['LimitDateOption1'] = '';
				$GLOBALS['LimitDateOption2'] = '';
				$GLOBALS['LimitDateOption3'] = '';

				switch ($arrData['prodeventdatelimitedtype']) {

					case 1 :
						$GLOBALS['LimitDateOption1'] = 'selected="selected"';
					break;
					case 2 :
						$GLOBALS['LimitDateOption2'] = 'selected="selected"';
					break;
					case 3 :
						$GLOBALS['LimitDateOption3'] = 'selected="selected"';
					break;
				}

				// Set the global variables for the select boxes

				$from_day = isc_date("d", $from_stamp);
				$from_month = isc_date("m", $from_stamp);
				$from_year = isc_date("Y", $from_stamp);

				$to_day = isc_date("d", $to_stamp);
				$to_month = isc_date("m", $to_stamp);
				$to_year = isc_date("Y", $to_stamp);

				$GLOBALS['OverviewFromDays'] = $this->_GetDayOptions($from_day);
				$GLOBALS['OverviewFromMonths'] = $this->_GetMonthOptions($from_month);
				$GLOBALS['OverviewFromYears'] = $this->_GetYearOptions($from_year);

				$GLOBALS['OverviewToDays'] = $this->_GetDayOptions($to_day);
				$GLOBALS['OverviewToMonths'] = $this->_GetMonthOptions($to_month);
				$GLOBALS['OverviewToYears'] = $this->_GetYearOptions($to_year);

				$GLOBALS['ProdMYOBAsset'] = isc_html_escape($arrData['prodmyobasset']);
				$GLOBALS['ProdMYOBIncome'] = isc_html_escape($arrData['prodmyobincome']);
				$GLOBALS['ProdMYOBExpense'] = isc_html_escape($arrData['prodmyobexpense']);

				$GLOBALS['ProdPeachtreeGL'] = isc_html_escape($arrData['prodpeachtreegl']);

				$GLOBALS['SaveAndAddAnother'] = GetLang('SaveAndContinueEditing');
				$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("product.form");
				$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
			} else {
				// The product doesn't exist
				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Products)) {
					$this->ManageProducts(GetLang('ProductDoesntExist'), MSG_ERROR);
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
				}
			}
		}

		protected function _GetDayOptions($Selected=0)
		{
			$output = "";

			for($i = 1; $i <= 31; $i++) {
				if($Selected == $i) {
					$sel = 'selected="selected"';
				}
				else {
					$sel = "";
				}

				$output .= sprintf("<option value='%d' %s>%s</option>", $i, $sel, $i);
			}

			return $output;
		}

		/**
			*	Return a list of months as option tags
			*/
		protected function _GetMonthOptions($Selected=0)
		{
			$output = "";

			for($i = 1; $i <= 12; $i++) {
				if($Selected == $i) {
					$sel = 'selected="selected"';
				}
				else {
					$sel = "";
				}

				$stamp = isc_gmmktime(0, 0, 0, $i, 1, 2000);
				$month = isc_date("M", $stamp);
				$output .= sprintf("<option value='%d' %s>%s</option>", $i, $sel, $month);
			}

			return $output;
		}

		/**
			*	Return a list of years as option tags
			*/
		protected function _GetYearOptions($Selected=0)
		{

			$output = "";

			for($i = isc_date("Y"); $i <= isc_date("Y")+5; $i++) {
				if($Selected == $i) {
					$sel = 'selected="selected"';
				}
				else {
					$sel = "";
				}

				$output .= sprintf("<option value='%d' %s>%s</option>", $i, $sel, $i);
			}

			return $output;
		}

		// Get a list of downloads associated with a particular product.
		public function GetDownloadsGrid($productId=0, $productHash='')
		{
			if($productId > 0) {
				$where = sprintf("pd.productid='%d'", $productId);
			}
			else {
				$where = sprintf("pd.prodhash='%s'", $productHash);
			}

			$query = sprintf("
				select pd.*, sum(od.numdownloads) as numdownloads
				from [|PREFIX|]product_downloads pd
				left join [|PREFIX|]order_downloads od on (od.downloadid=pd.downloadid)
				where %s
				group by pd.downloadid", $where);
			$grid = '';

			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$GLOBALS['DownloadId'] = $row['downloadid'];
				$GLOBALS['DownloadFile'] = $row['downfile'];
				$GLOBALS['NumDownloads'] = number_format($row['numdownloads']);
				$GLOBALS['DownloadName'] = $row['downname'];
				if($row['downdescription']) {
					$GLOBALS['DownloadName'] = sprintf("<span onmouseover=\"ShowQuickHelp(this, '%s', '%s');\" onmouseout=\"HideQuickHelp(this);\" class=\"HelpText\">%s</span>", $GLOBALS['DownloadName'], str_replace("'", "\\'", $row['downdescription']), $GLOBALS['DownloadName']);
				}
				$GLOBALS['DownloadSize'] = NiceSize($row['downfilesize']);
				if($row['downmaxdownloads'] == 0) {
					$GLOBALS['MaxDownloads'] = GetLang('Unlimited');
				}
				else {
					$GLOBALS['MaxDownloads'] = $row['downmaxdownloads'];
				}
				if($row['downexpiresafter']) {
					$days = $row['downexpiresafter']/86400;
					if(($days % 365) == 0) {
						$GLOBALS['ExpiresAfter'] = number_format($days/365)." ".GetLang('YearsLower');
					}
					else if(($days % 30) == 0) {
						$GLOBALS['ExpiresAfter'] = number_format($days/30)." ".GetLang('MonthsLower');
					}
					else if(($days % 7) == 0) {
						$GLOBALS['ExpiresAfter'] = number_format($days/7)." ".GetLang('WeeksLower');
					}
					else {
						$GLOBALS['ExpiresAfter'] = number_format($days)." ".GetLang('DaysLower');
					}
				}
				else {
					$GLOBALS['ExpiresAfter'] = GetLang('Never');
				}

				$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("product.form.downloadrow");
				$grid .= $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate(true);
			}
			return $grid;
		}

		// Save a new or modified product download in the database.
		public function SaveProductDownload(&$err)
		{
			if (!isset($_REQUEST['downmaxdownloads'])) {
				$_REQUEST['downmaxdownloads'] = 0;
			}

			if (!isset($_REQUEST['downexpiresafter'])) {
				$_REQUEST['downexpiresafter'] = 0;
			}

			if (isset($_REQUEST['downexpiresrange'])) {
				if ($_REQUEST['downexpiresrange'] == "years") {
					$_REQUEST['downexpiresafter'] *= 365;
				} else if ($_REQUEST['downexpiresrange'] == "months") {
					$_REQUEST['downexpiresafter'] *= 30;
				} else if($_REQUEST['downexpiresrange'] == "weeks") {
					$_REQUEST['downexpiresafter'] *= 7;
				}
			}

			$filename = '';
			$filesize = 0;

			// Saving a new download
			if (!isset($_REQUEST['downloadid']) || $_REQUEST['downloadid'] == 0) {
				// Are we picking a file from the server to use instead of uploading one
				// directly from the browser ?
				if (isset($_REQUEST['serverfile'])) {

					// Is the file name valid ?
					$valid_files = $this->_GetImportFilesArray();
					if (!in_array($_REQUEST['serverfile'], $valid_files)) {
						$err = GetLang('InvalidFileName');
						return false;
					}

					$dirs = range('a', 'z');

					$downfile = $dirs[array_rand($dirs)].'/'.$_REQUEST['serverfile'];

					$source = ISC_BASE_PATH.'/'.GetConfig('DownloadDirectory').'/import/'.$_REQUEST['serverfile'];
					$dest = ISC_BASE_PATH.'/'.GetConfig('DownloadDirectory').'/'.$downfile;

					// We use sprintf here to avoid a bug with 32bit platforms and files > 2GB
					$filesize = sprintf("%u", filesize($source));

					// If the file is larger than 20 megabytes then move the file
					if ($filesize > 20 * 1024 * 1024) {
						if (!rename($source, $dest)) {
							return false;
						}
					}
					// If the file is smaller than 20 megabytes then copy the file (since it is probably safter to do this)
					else {
						if (!copy($source, $dest)) {
							return false;
						}
					}
					$filename = $_REQUEST['serverfile'];
					$filesize = filesize($dest);
				} else {
					if(!isset($_FILES['newdownload'])) {
						$err = GetLang('UploadErrorIniSize');
						return false;
					}

					if($_FILES['newdownload']['tmp_name'] == '' || $_FILES['newdownload']['size'] == 0) {
						$err = GetLang('UploadFailed');
						return false;
					}

					if($_FILES['newdownload']['error'] > 0) {
						switch($_FILES['newdownload']['error'])
						{
							case UPLOAD_ERR_INI_SIZE:
								$err = GetLang('UploadErrorIniSize');
								break;
							case UPLOAD_ERR_FORM_SIZE:
								$err = GetLang('UploadErrorFormSize');
								break;
							case UPLOAD_ERR_PARTIAL:
								$err = GetLang('UploadErrorPartial');
								break;
							case UPLOAD_ERR_NO_FILE:
								$err = GetLang('UploadErrorNoFile');
								break;
							case UPLOAD_ERR_NO_TMP_DIR:
								$err = GetLang('UploadErrorNoTmp');
								break;
							case UPLOAD_ERR_CANT_WRITE:
								$err = GetLang('UploadErrorCantWrite');
								break;
							case UPLOAD_ERR_CANT_WRITE:
								$err = GetLang('UploadErrorExtension');
								break;
						}
						return false;
					}
					$downfile = $this->_StoreFileAndReturnId("newdownload", FT_DOWNLOAD);
					if (!$downfile) {
						$err = GetLang('UploadErrorCantWrite');
						return false;
					}

					$filename = $_FILES['newdownload']['name'];
					$filesize = $_FILES['newdownload']['size'];

				}

				if(isset($_REQUEST['productId']) && $_REQUEST['productId'] != 0) {
					$productId = (int)$_REQUEST['productId'];
					$productHash = '';
				}
				else {
					$productId = '0';
					$productHash = $_REQUEST['productHash'];
				}

				$newDownload = array(
					"downfile" => $downfile,
					"productid" => $productId,
					"prodhash" => $productHash,
					"downdateadded" => time(),
					"downmaxdownloads" => (int)$_REQUEST['downmaxdownloads'],
					"downexpiresafter" => (int)$_REQUEST['downexpiresafter']*86400,
					"downname" => $filename,
					"downfilesize" => (int) $filesize,
					"downdescription" => $_REQUEST['downdescription']
				);
				$downloadid = $GLOBALS['ISC_CLASS_DB']->InsertQuery("product_downloads", $newDownload);

				$query = sprintf("SELECT prodname FROM [|PREFIX|]products WHERE productid='%d'", $productId);
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				$prodName = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);

				// Log this action
				$GLOBALS['ISC_CLASS_LOG']->LogAdminAction("created", $downloadid, $filename, $productId, $prodName);
			}
			// Updating an existing download
			else {
				$downloadid = (int)$_REQUEST['downloadid'];
				$updatedDownload = array(
					"downdescription" => $_REQUEST['downdescription'],
					"downmaxdownloads" => (int)$_REQUEST['downmaxdownloads'],
					"downexpiresafter" => (int)$_REQUEST['downexpiresafter']*86400
				);
				$GLOBALS['ISC_CLASS_DB']->UpdateQuery("product_downloads", $updatedDownload, "downloadid='".$GLOBALS['ISC_CLASS_DB']->Quote($downloadid)."'");

				$query = sprintf("SELECT p.prodname, p.productid, d.downname FROM [|PREFIX|]product_downloads d, [|PREFIX|]products p WHERE d.downloadid='%d' AND p.productid=d.productid", $downloadid);
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				$product = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
				// Log this action
				$GLOBALS['ISC_CLASS_LOG']->LogAdminAction("updated", $downloadid, $product['downname'], $product['productid'], $product['prodname']);
			}
			return true;
		}

		// Delete a download from a particular product.
		public function DeleteProductDownload()
		{
			if(!isset($_REQUEST['downloadid'])) {
				return false;
			}

			$downloadid = (int)$_REQUEST['downloadid'];

			$query = sprintf("SELECT p.prodname, p.productid, d.downname, d.downfile, p.prodvendorid FROM [|PREFIX|]product_downloads d, [|PREFIX|]products p WHERE d.downloadid='%d' AND p.productid=d.productid", $downloadid);
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$download = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

			// Does this user have permission to edit this product?
			if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() && $download['prodvendorid'] != $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
				return false;
			}

			// Log this action
			$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($downloadid, $download['downname'], $download['productid'], $download['prodname']);

			// Remove the file from the file system
			if($download) {
				@unlink(GetConfig('DownloadDirectory') . "/" . $download['downfile']);
			}

			// Delete from the database
			$query = sprintf("delete from [|PREFIX|]product_downloads where downloadid='%d'", $downloadid);
			$GLOBALS['ISC_CLASS_DB']->Query($query);
			return true;
		}

		/**
		*	Build a word list from a product name to store in the product_words table.
		*	These will be used along with pSpell to provide search suggestions on the front end.
		*	This avoids needing to save a custom dictionary for technical words which will always
		*	trip off the spell checker. For example "mp3 player" returns 'did you mean "mp player"'
		*	which is incorrect, as MP3 is a common word. Any word that's searched for that's in
		*	the product_words table will not be checked against the spell checker.
		**/
		public function SaveProductWords($ProductName, $ProductId, $AddingOrEditing)
		{
			// If search suggestions aren't enabled, don't try to build the list of product words
			if(!GetConfig('SearchSuggest')) {
				return true;
			}

			$words_to_save = array();
			$words = preg_split("#[(\s|\(|\)\/)]+#", $ProductName);
			$pspell_installed = false;
			if(function_exists('pspell_new')) {
				$pspell_installed = true;
			}

			// Create a pSpell object if it's installed
			if($pspell_installed) {
				$spell = @pspell_new("en");
			}

			foreach($words as $word) {
				if(isc_strlen(trim($word)) > 2) {
					// Can we spell check against the word?
					if($pspell_installed && $spell) {
						if(!@pspell_check($spell, $word)) {
							$suggestions = @pspell_suggest($spell, $word);

							// If any suggestions are returned then the word generally misspelled
							if(count($suggestions) > 0) {
								array_push($words_to_save, isc_strtolower($word));
							}
						}
					}
					else {
						// pSpell isn't installed so we'll go ahead and add the word anyway
						array_push($words_to_save, isc_strtolower($word));
					}
				}
			}

			// If we're editing an existing product then we'll remove the words already in the product_words table
			if($AddingOrEditing == "editing") {
				$query = sprintf("delete from [|PREFIX|]product_words where productid='%d'", $ProductId);
				$GLOBALS['ISC_CLASS_DB']->Query($query);
			}

			// Add the words to the product_words table
			foreach($words_to_save as $word) {
				$newWord = array(
					"word" => $word,
					"productid" => $ProductId
				);
				$GLOBALS['ISC_CLASS_DB']->InsertQuery("product_words", $newWord);
			}
		}

		public function SearchProducts()
		{
			$GLOBALS['ISC_CLASS_ADMIN_CATEGORY'] = GetClass('ISC_ADMIN_CATEGORY');
			$GLOBALS['CategoryOptions'] = $GLOBALS["ISC_CLASS_ADMIN_CATEGORY"]->GetCategoryOptions("", "<option %s value='%d'>%s</option>", "selected=\"selected\"", "", false);

			$GLOBALS['ISC_CLASS_ADMIN_BRANDS'] = GetClass('ISC_ADMIN_BRANDS');
			$GLOBALS['BrandNameOptions'] = $GLOBALS['ISC_CLASS_ADMIN_BRANDS']->GetBrandsAsOptions();

			if (GetConfig('CurrencyLocation') == 'right') {
				$GLOBALS['CurrencyTokenLeft'] = '';
				$GLOBALS['CurrencyTokenRight'] = GetConfig('CurrencyToken');
			} else {
				$GLOBALS['CurrencyTokenLeft'] = GetConfig('CurrencyToken');
				$GLOBALS['CurrencyTokenRight'] = '';
			}

			if(!gzte11(ISC_MEDIUMPRINT)) {
				$GLOBALS['HideInventoryOptions'] = "none";
			}

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("products.search");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}

		/**
		*	This function checks to see if the user wants to save the search details as a custom search,
		*	and if they do one is created. They are then forwarded onto the search results
		*/
		public function SearchProductsRedirect()
		{

			// Format prices back to the western standard
			if($_GET['priceFrom'] != "") {
				$_GET['priceFrom'] = $_REQUEST['priceFrom'] = DefaultPriceFormat($_GET['priceFrom']);
			}

			if($_GET['priceTo'] != "") {
				$_GET['priceTo'] = $_REQUEST['priceTo'] = DefaultPriceFormat($_GET['priceTo']);
			}

			// Are we saving this as a custom search?
			if(isset($_GET['viewName']) && $_GET['viewName'] != '') {
				if(isset($_GET['ISSelectReplacement_category'])) {
					unset($_GET['ISSelectReplacement_category']);
				}

				$search_id = $GLOBALS['ISC_CLASS_ADMIN_CUSTOMSEARCH']->SaveSearch($_GET['viewName'], $_GET);

				if($search_id > 0) {
					// Log this action
					$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($search_id, $_GET['viewName']);   
					ob_end_clean();
					header(sprintf("Location:index.php?ToDo=customProductSearch&searchId=%d&new=true", $search_id));
					exit;
				}
				else {
					$this->ManageProducts(sprintf(GetLang('ViewAlreadExists'), isc_html_escape($_GET['viewName'])), MSG_ERROR);
				}

			}
			// Plain search
			else {
                $this->ManageProducts();
			}
		}

		/**
		*	Load a custom search
		*/
		public function CustomSearch()
		{
			SetSession('productsearch', (int) $_GET['searchId']);

			if ($_GET['searchId'] > 0) {
				$this->_customSearch = $GLOBALS['ISC_CLASS_ADMIN_CUSTOMSEARCH']->LoadSearch($_GET['searchId']);
				$_REQUEST = array_merge($_REQUEST, $this->_customSearch['searchvars']);
			}

			if (isset($_REQUEST['new'])) {
				$this->ManageProducts(GetLang('CustomSearchSaved'), MSG_SUCCESS);
			} else {
				$this->ManageProducts();
			}
		}

		public function DeleteCustomSearch()
		{
			if($GLOBALS['ISC_CLASS_ADMIN_CUSTOMSEARCH']->DeleteSearch($_GET['searchId'])) {
				// Log this action
				$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($_GET['searchId']);

				$this->ManageProducts(GetLang('DeleteCustomSearchSuccess'), MSG_SUCCESS);
			}
			else {
				$this->ManageProducts(GetLang('DeleteCustomSearchFailed'), MSG_ERROR);
			}
		}

		public function ImportProducts()
		{
			require_once dirname(__FILE__)."/class.batch.importer.php";
			$importer = new ISC_BATCH_IMPORTER_PRODUCTS();
		}

		/**
		*	Create a view for products. Uses the same form as searching but puts the
		*	name of the view at the top and it's mandatory instead of optional.
		*/
		public function CreateView()
		{
			$GLOBALS['ISC_CLASS_ADMIN_CATEGORY'] = GetClass('ISC_ADMIN_CATEGORY');

			$visibleCategories = array();
			if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
				$vendorData = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendor();
				if($vendorData['vendoraccesscats']) {
					$visibleCategories = explode(',', $vendorData['vendoraccesscats']);
				}
			}

			$GLOBALS['CategoryOptions'] = $GLOBALS["ISC_CLASS_ADMIN_CATEGORY"]->GetCategoryOptions("", "<option %s value='%d'>%s</option>", "selected=\"selected\"", "", false, '', $visibleCategories);

			$GLOBALS['ISC_CLASS_ADMIN_BRANDS'] = GetClass('ISC_ADMIN_BRANDS');
			$GLOBALS['BrandNameOptions'] = $GLOBALS['ISC_CLASS_ADMIN_BRANDS']->GetBrandsAsOptions();

			$GLOBALS['OrderPaymentOptions'] = "";
			$GLOBALS['OrderShippingOptions'] = "";

			if (GetConfig('CurrencyLocation') == 'right') {
				$GLOBALS['CurrencyTokenLeft'] = '';
				$GLOBALS['CurrencyTokenRight'] = GetConfig('CurrencyToken');
			} else {
				$GLOBALS['CurrencyTokenLeft'] = GetConfig('CurrencyToken');
				$GLOBALS['CurrencyTokenRight'] = '';
			}

			if(!gzte11(ISC_MEDIUMPRINT)) {
				$GLOBALS['HideInventoryOptions'] = "none";
			}

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("products.view");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}

		/**
		* BulkEditProductsStep1
		* Show the form to bulk edit at least two products
		*
		* @return Void
		*/
		public function BulkEditProductsStep1($MsgDesc = "", $MsgStatus = "")
		{
			$GLOBALS['ProductList'] = "";
			$GLOBALS['ProductIds'] = "";

			if ($MsgDesc != "") {
				$GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
			}

			$GLOBALS['ISC_CLASS_ADMIN_CATEGORY'] = GetClass('ISC_ADMIN_CATEGORY');

			if(isset($_POST['products']) && is_array($_POST['products'])) {
				$product_ids = implode(",", array_map('intval', $_POST['products']));

				$visibleCategories = array();
				if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
					$vendorData = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendor();
					if($vendorData['vendoraccesscats']) {
						$visibleCategories = explode(',', $vendorData['vendoraccesscats']);
					}
				}

				if(strlen($product_ids) > 0) {
					// Only fetch products this user can actually edit
					$vendorRestriction = '';
					if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
						$vendorRestriction = " AND prodvendorid='".(int)$GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()."'";
					}

					$query = sprintf("
						SELECT productid, prodname, prodprice, prodfreeshipping, prodvisible, prodfeatured, prodvendorfeatured, prodbrandid,
						(SELECT brandname FROM [|PREFIX|]brands WHERE brandid=prodbrandid) as prodbrand
						FROM [|PREFIX|]products p
						WHERE productid IN (%s) ".$vendorRestriction,
						$product_ids
					);

					$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);

					while($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
						$GLOBALS['ProductIds'] .= $row['productid'] . ",";
						$GLOBALS['ProductId'] = $row['productid'];
						$GLOBALS['ProductName'] = isc_html_escape($row['prodname']);
						$GLOBALS['ProductBrand'] = isc_html_escape($row['prodbrand']);
						$GLOBALS['ProductBrandId'] = $row['prodbrandid'];
						$GLOBALS['ProductExistingBrand'] = $row['prodbrand'];
						$GLOBALS['ProductExistingBrandId'] = $row['prodbrandid'];

						$GLOBALS['ProductVisible'] = '';
						if($row['prodvisible']) {
							$GLOBALS['ProductVisible'] = 'checked="checked"';
						}

						$GLOBALS['ProductFeatured'] = '';
						if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() > 0) {
							$featuredColumn = 'prodvendorfeatured';
						}
						else {
							$featuredColumn = 'prodfeatured';
						}
						if($row[$featuredColumn]) {
							$GLOBALS['ProductFeatured'] = 'checked="checked"';
						}

						$GLOBALS['ProductFreeShipping'] = '';
						if($row['prodfreeshipping']) {
							$GLOBALS['ProductFreeShipping'] = 'checked="checked"';
						}

						$GLOBALS['ProductPrice'] = number_format($row['prodprice'], GetConfig('DecimalPlaces'), GetConfig('DecimalToken'), "");

						// Load the product categories
						$cquery = sprintf("SELECT categoryid FROM [|PREFIX|]categoryassociations ca WHERE ca.productid=%d", $row['productid']);
						$cresult = $GLOBALS["ISC_CLASS_DB"]->Query($cquery);
						$cats = array();

						while($crow = $GLOBALS["ISC_CLASS_DB"]->Fetch($cresult)) {
							array_push($cats, $crow['categoryid']);
						}

						// Get the product categories list
//						$GLOBALS['ProductCategories'] = $GLOBALS["ISC_CLASS_ADMIN_CATEGORY"]->GetCategoryOptions($cats, "<option %s value='%d'>%s</option>", "selected=\"selected\"", "", false, '', $visibleCategories);
                        $prodid = $row['productid'].'_';
                        $prodid1 = $row['productid'];
                        $GLOBALS['ProductCategories'] = $GLOBALS["ISC_CLASS_ADMIN_CATEGORY"]->GetCategoryOptionsProduct($cats, "<option %s value='%d' id='category_$prodid%d'>%s</option>", "selected=\"selected\"", "", false, '', $visibleCategories);
						$GLOBALS['ProductExistingCategories'] = implode(",", $cats);

						$GLOBALS['ProductList'] .= $GLOBALS["ISC_CLASS_TEMPLATE"]->GetSnippet("BulkEditItem");
					}

					$GLOBALS['ProductIds'] = preg_replace("/,$/", "", $GLOBALS['ProductIds']);
					$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("product.bulkedit.form");
					$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
				}
				else {
					$this->ManageProducts();
				}
			}
			else {
				$this->ManageProducts();
			}
		}

		/**
		* BulkEditProductsStep2
		* Save the changes made on the bulk editing page
		*
		* @return Void
		*/
		public function BulkEditProductsStep2()
		{
			if(isset($_POST["product_ids"])) {
				$product_ids = explode(",", $_POST["product_ids"]);

				// Only fetch products this user can actually edit
				$vendorRestriction = '';
				if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
					$vendorRestriction = " AND prodvendorid='".(int)$GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()."'";
				}

				// Load the existing products
				$existingProducts = array();
				$query = "SELECT * FROM [|PREFIX|]products WHERE productid IN (".implode(",", $GLOBALS['ISC_CLASS_DB']->Quote($product_ids)).") ".$vendorRestriction;
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				while($product = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					$existingProducts[$product['productid']] = $product;
				}

				foreach($product_ids as $product_id) {
					$prodname =			$_POST["prodname_" . $product_id];
					$prodprice =		DefaultPriceFormat($_POST["prodprice_" . $product_id]);
					$prodbrand =		$_POST["prodbrand_" . $product_id];
					$prodbrandold =		$_POST["existing_brand_" . $product_id];
					$prodbrandid =		$_POST["existing_brand_id_" . $product_id];
					$prodcats =			$_POST["category_" . $product_id];
					$prodcatsold =		$_POST["existing_categories_" . $product_id];

					$prodfeatured = 0;
					if(isset($_POST['prodfeatured_'.$product_id])) {
						$prodfeatured = 1;
					}

					$prodvisible = 0;
					if(isset($_POST['prodvisible_'.$product_id])) {
						$prodvisible = 1;
					}

					$prodfreeshipping = 0;
					if(isset($_POST['prodfreeshipping_'.$product_id])) {
						$prodfreeshipping = 1;
					}

					$prodCatsCSV = implode(",", $prodcats);

					// Calculate the new price of the product
					$existingProduct = $existingProducts[$product_id];
					$prodcalculatedprice = CalcRealPrice($prodprice, $existingProduct['prodretailprice'], $existingProduct['prodsaleprice'], $existingProduct['prodistaxable']);

					// Do we need to update the categories?
					if($prodCatsCSV != $prodcatsold) {
						$GLOBALS["ISC_CLASS_DB"]->DeleteQuery("categoryassociations", sprintf("WHERE productid='%d'", $product_id));

						// Add the new category associations
						foreach($prodcats as $cat_id) {
							$ca = array("productid" => $product_id,
										"categoryid" => $cat_id
							);
							$GLOBALS['ISC_CLASS_DB']->InsertQuery("categoryassociations", $ca);
						}
					}

					// Do we need to update the brand?
					if($prodbrand != $prodbrandold) {

						if($prodbrand != "") {
							// Is it an existing brand?
							$bquery = sprintf("SELECT brandid FROM [|PREFIX|]brands WHERE lower(brandname)='%s'", strtolower($prodbrand));
							$bresult = $GLOBALS["ISC_CLASS_DB"]->Query($bquery);

							if($brow = $GLOBALS["ISC_CLASS_DB"]->Fetch($bresult)) {
								// It's an existing brand
								$brand_id = $brow['brandid'];
							}
							else {
								// It's a new brand, let's add it
								$ba = array("brandname" => $prodbrand);
								$GLOBALS['ISC_CLASS_DB']->InsertQuery("brands", $ba);
								$brand_id = $GLOBALS["ISC_CLASS_DB"]->LastId();
							}
						}
						else {
							// Delete the brand
							$brand_id = 0;
						}
					}
					else {
						// The brand hasn't been changed
						$brand_id = $prodbrandid;
					}

					if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() > 0) {
						$featuredColumn = 'prodvendorfeatured';
					}
					else {
						$featuredColumn = 'prodfeatured';
					}

					// Update the product details
					$pa = array("productid" => $product_id,
								"prodname" => $prodname,
								"prodprice" => $prodprice,
								"prodcalculatedprice" => $prodcalculatedprice,
								$featuredColumn => $prodfeatured,
								"prodvisible" => $prodvisible,
								"prodfreeshipping" => $prodfreeshipping,
								"prodbrandid" => $brand_id,
								"prodcatids" => $prodCatsCSV

					);

					$entity = new ISC_ENTITY_PRODUCT();
					$entity->bulkEdit($pa);

					// Save the words to the product_words table for search spelling suggestions
					$this->SaveProductWords($prodname, $product_id, "editing");
				}

				// Update product pricing
				$GLOBALS['ISC_CLASS_ADMIN_SETTINGS'] = GetClass('ISC_ADMIN_SETTINGS');
				$GLOBALS['ISC_CLASS_ADMIN_SETTINGS']->_UpdateProductPrices();

				// Do we want to keep editing or return to the products list?
				if(isset($_POST['keepediting'])) {
					$_POST['products'] = $product_ids;
					$this->BulkEditProductsStep1(GetLang("BulkEditUpdatedSuccessfully"), MSG_SUCCESS);
				}
				else {
					$this->ManageProducts(GetLang("BulkEditUpdatedSuccessfully"), MSG_SUCCESS);

				}
			}
			else {
				$this->ManageProducts();
			}
		}

		/**
		* ViewVariations
		* Show a list of all available product variations
		*
		* @return Void
		*/
		public function ViewVariations($MsgDesc = "", $MsgStatus = "")
		{

			$GLOBALS['VariationDataGrid'] = $this->_GetVariationGrid($num_variations);

			// Was this an ajax based sort? Return the table now
			if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 1) {
				echo $GLOBALS['VariationDataGrid'];
				return;
			}

			// Disable the delete button if there aren't any variations
			if($num_variations == 0) {
				$GLOBALS['DisableDelete'] = "DISABLED='DISABLED'";
				$GLOBALS['DisplayGrid'] = "none";
				$MsgDesc = GetLang("NoProductVariations");
				$MsgStatus = MSG_INFO;
			}

			if($MsgDesc != "") {
				$GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
			}

			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("products.variations.manage");
			$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
		}

		/**
		* _GetVariationGrid
		* Get all of the product variations from the database and return them as a grid
		*
		* @param Int $NumVariations A reference variable to store the number of variations found
		* @return String
		*/
		public function _GetVariationGrid(&$NumVariations)
		{

			// Show a list of variations in a table
			$page = 0;
			$start = 0;
			$numVariations = 0;
			$numPages = 0;
			$GLOBALS['VariationsGrid'] = "";
			$GLOBALS['Nav'] = "";
			$max = 0;

			$validSortFields = array('vname', 'vnumoptions');

			if(isset($_REQUEST['sortOrder']) && $_REQUEST['sortOrder'] == "asc") {
				$sortOrder = "asc";
			}
			else {
				$sortOrder = "desc";
			}

			if(isset($_REQUEST['sortField']) && in_array($_REQUEST['sortField'], $validSortFields)) {
				$sortField = $_REQUEST['sortField'];
				SaveDefaultSortField("ViewProductVariations", $_REQUEST['sortField'], $sortOrder);
			} else {
				list($sortField, $sortOrder) = GetDefaultSortField("ViewProductVariations", "vname", $sortOrder);
			}

			if(isset($_GET['page'])) {
				$page = (int)$_GET['page'];
			}
			else {
				$page = 1;
			}

			// Build the pagination and sort URL
			$searchURL = '';
			foreach($_GET as $k => $v) {
				if($k == "sortField" || $k == "sortOrder" || $k == "page" || $k == "new" || $k == "ToDo" || $k == "SubmitButton1" || !$v) {
					continue;
				}
				if(is_array($v)) {
					foreach($v as $v2) {
						$searchURL .= sprintf("&%s[]=%s", $k, urlencode($v2));
					}
				}
				else {
					$searchURL .= sprintf("&%s=%s", $k, urlencode($v));
				}
			}

			$sortURL = sprintf("%s&amp;sortField=%s&amp;sortOrder=%s", $searchURL, $sortField, $sortOrder);
			$GLOBALS['SortURL'] = $sortURL;

			// Limit the number of questions returned
			if($page == 1) {
				$start = 1;
			}
			else {
				$start = ($page * ISC_PRODUCTS_PER_PAGE) - (ISC_PRODUCTS_PER_PAGE-1);
			}

			$start = $start-1;

			// Get the results for the query
			$variation_result = $this->_GetVariationList($start, $sortField, $sortOrder, $numVariations);
			$numPages = ceil($numVariations / ISC_PRODUCTS_PER_PAGE);
			$NumVariations = $numVariations;

			// Add the "(Page x of n)" label
			if($numVariations > ISC_PRODUCTS_PER_PAGE) {
				$GLOBALS['Nav'] = sprintf("(%s %d of %d) &nbsp;&nbsp;&nbsp;", GetLang('Page'), $page, $numPages);

				$GLOBALS['Nav'] .= BuildPagination($numVariations, ISC_PRODUCTS_PER_PAGE, $page, sprintf("index.php?ToDo=viewProductVariations%s", $sortURL));
			}
			else {
				$GLOBALS['Nav'] = "";
			}

			$GLOBALS['Nav'] = preg_replace('# \|$#',"", $GLOBALS['Nav']);
			$GLOBALS['SortField'] = $sortField;
			$GLOBALS['SortOrder'] = $sortOrder;
			$sortLinks = array(
				"Name" => "vname",
				"Options" => "vnumoptions",
			);

			BuildAdminSortingLinks($sortLinks, "index.php?ToDo=viewProductVariations&amp;".$searchURL."&amp;page=".$page, $sortField, $sortOrder);

			// Workout the maximum size of the array
			$max = $start + ISC_PRODUCTS_PER_PAGE;

			if ($max > $numVariations) {
				$max = $numVariations;
			}

			if($numVariations > 0) {
				// Display the products
				while($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($variation_result)) {
					$GLOBALS['VariationId'] = (int) $row['variationid'];
					$GLOBALS['Name'] = isc_html_escape($row['vname']);
					if(gzte11(ISC_HUGEPRINT) && $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() == 0 && $row['vendorname']) {
						$GLOBALS['Name'] .= ' <small><strong>('.GetLang('Vendor').': '.$row['vendorname'].')</strong></small>';
					}
					$GLOBALS['NumOptions'] = (int) $row['vnumoptions'];
					$GLOBALS['Edit'] = '<a class="Action" href="index.php?ToDo=editProductVariation&amp;variationId=' . $row['variationid'] . '" title="' . GetLang('ProductVariationEdit') . '">' . GetLang('Edit') . '</a>';
					$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("product.variations.manage.row");
					$GLOBALS['VariationsGrid'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
				}

			}

			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("products.variations.manage.grid");
			return $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate(true);
		}

		public function _GetVariationList($Start, $SortField, $SortOrder, &$NumVariations, $fields='', $AddLimit=true)
		{
			// Return an array containing details about variations.
			if($fields == '') {
				$fields = " *, v.vendorname AS vendorname ";
			}

			$queryWhere = '';

			// Only fetch variations which belong to the current vendor
			if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
				$queryWhere .= " AND vvendorid='".(int)$GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()."'";
			}

			$countQuery = "SELECT COUNT(variationid) FROM [|PREFIX|]product_variations WHERE 1=1 ".$queryWhere;

			$query = "
				SELECT ".$fields."
				FROM [|PREFIX|]product_variations p
				LEFT JOIN [|PREFIX|]vendors v ON (v.vendorid=p.vvendorid)
				WHERE 1=1
			";
			$query .= $queryWhere;

			// Fetch the number of results
			$result = $GLOBALS['ISC_CLASS_DB']->Query($countQuery);
			$NumVariations = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);

			// Add the sorting options
			$query .= sprintf("order by %s %s", $SortField, $SortOrder);

			// Add the limit
			if($AddLimit) {
				$query .= $GLOBALS["ISC_CLASS_DB"]->AddLimit($Start, ISC_PRODUCTS_PER_PAGE);
			}

			$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
			return $result;
		}

		/**
		* AddVariationStep1
		* The form to add a product variation with options to the store
		*
		* @return Void
		*/
		public function AddVariationStep1($MsgDesc = "", $MsgStatus = "", $PreservePost=false)
		{
			if($MsgDesc != "") {
				$GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
			}

			$GLOBALS['FormAction'] = "addProductVariation2";
			$GLOBALS['Title'] = GetLang("AddProductVariation");
			$GLOBALS['SaveAndAddAnother'] = GetLang("SaveAndAddAnother");

			if (!array_key_exists('variationId', $_POST)) {
				$GLOBALS['VariationName'] = isc_html_escape(GetLang('ProductVariationTestDataName'));
			} else if (array_key_exists('vname', $_POST)) {
				$GLOBALS['VariationName'] = isc_html_escape($_POST['vname']);
			}

			if (array_key_exists('variationId', $_POST)) {
				$GLOBALS['HideVariationTestDataWarning'] = 'none';
			}

			if(!gzte11(ISC_HUGEPRINT)) {
				$GLOBALS['HideVendorOption'] = 'display: none';
			}
			else {
				$vendorData = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendor();
				if(isset($vendorData['vendorid'])) {
					$GLOBALS['HideVendorSelect'] = 'display: none';
					$GLOBALS['CurrentVendor'] = isc_html_escape($vendorData['vendorname']);
				}
				else {
					$GLOBALS['HideVendorLabel'] = 'display: none';
					$GLOBALS['VendorList'] = $this->BuildVendorSelect();
				}
			}

			/**
			 * Display the test data only when they have entered the variation admin for the first time
			 */
			if (!array_key_exists('variationId', $_POST)) {
				$variationData = $this->GetVariationTestData();
			} else {
				$variationData = $this->GetVariationData(0);
			}

			$GLOBALS['Variations'] = $this->BuildVariationCreate($variationData);

			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("products.variation.form");
			echo $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
		}

		/**
		* AddVariationStep2
		* Save the details of the variation to the database
		*
		* @return Void
		*/
		public function AddVariationStep2()
		{
			$data = $this->GetVariationData(0);

			/**
			 * Validate our data
			 */
			if (!$this->ValidateVariationData($data, $error)) {
				return $this->AddVariationStep1($error, MSG_ERROR, true);
			}

			/**
			 * Add our new variation record
			 */
			$variationId = $this->SaveVariationData($data);

			/**
			 * Did we get any errors?
			 */
			if (!isId($variationId)) {
				return $this->AddVariationStep1(sprintf(GetLang("ErrorWhenAddingVariation"), $GLOBALS["ISC_CLASS_DB"]->GetErrorMsg()), MSG_ERROR, true);
			}

			if (isset($_POST['addanother'])) {
				$_POST = array('variationId' => '');
				$this->AddVariationStep1(GetLang("VariationAddedSuccessfully"), MSG_SUCCESS);
			} else {
				$this->ViewVariations(GetLang("VariationAddedSuccessfully"), MSG_SUCCESS);
			}
		}

		/**
		* EditVariationStep1
		* The form to edit a product variation with options to the store
		*
		* @return Void
		*/
		public function EditVariationStep1($MsgDesc = "", $MsgStatus = "", $PreservePost=false)
		{
			if($MsgDesc != "") {
				$GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
			}

			$variationId = null;
			if (isset($_GET['variationId'])) {
				$variationId = (int)$_GET['variationId'];
			}

			if (!$GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Products)) {
				return $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
			}

			/**
			 * Get our variation data. If we couldn't get it then display an error
			 */
			if ($PreservePost) {
				$variationData = $this->GetVariationData(0);
			} else {
				$variationData = $this->GetVariationData($variationId);
			}

			if (!isId($variationId) || !$variationData) {
				return $this->ViewVariations(GetLang('ProductVariationErrorDoesNotExists'), MSG_ERROR);
			}

			/**
			 * We need to have a list of all the variation options that are in use by products
			 */
			$affected = array();
			$result = $GLOBALS['ISC_CLASS_DB']->Query("SELECT vcoptionids FROM [|PREFIX|]product_variation_combinations WHERE vcvariationid = " . (int)$variationId);
			while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$tmpVariations = explode(',', $row['vcoptionids']);
				$affected = array_merge($affected, $tmpVariations);
			}

			$affected = array_unique($affected);
			$GLOBALS['AffectedVariations'] = implode(',', $affected);

			$GLOBALS['FormAction'] = "editProductVariation2";
			$GLOBALS['Title'] = GetLang("EditProductVariation");
			$GLOBALS['VariationName'] = $variationData['name'];
			$GLOBALS['VariationId'] = $variationData['id'];
			$GLOBALS['SaveAndAddAnother'] = GetLang("SaveAndContinueEditing");
			$GLOBALS['HideVariationTestDataWarning'] = 'none';

			if(!gzte11(ISC_HUGEPRINT)) {
				$GLOBALS['HideVendorOption'] = 'display: none';
			}
			else {
				$vendorData = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendor();
				if(isset($vendorData['vendorid'])) {
					$GLOBALS['HideVendorSelect'] = 'display: none';
					$GLOBALS['CurrentVendor'] = isc_html_escape($vendorData['vendorname']);
				}
				else {
					$GLOBALS['HideVendorLabel'] = 'display: none';
					$GLOBALS['VendorList'] = $this->BuildVendorSelect();
				}
			}

			$GLOBALS['Variations'] = $this->BuildVariationCreate($variationData);

			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("products.variation.form");
			print $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
		}

		/**
		* EditVariationStep2
		* Save the details of the variation to the database
		*
		* @return Void
		*/
		public function EditVariationStep2()
		{
			$variationId = null;
			if (isset($_POST['variationId'])) {
				$variationId = (int)$_POST['variationId'];
			}

			if (!$GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Products)) {
				return $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
			}

			/**
			 * Get our variation data. If we couldn't get it then display an error
			 */
			$variationData = $this->GetVariationData(0);

			if (!isId($variationId) || !$variationData) {
				return $this->ViewVariations(GetLang('ProductVariationErrorDoesNotExists'), MSG_ERROR);
			}

			/**
			 * Validate our data
			 */
			if (!$this->ValidateVariationData($variationData, $error)) {
				$_GET['variationId'] = $variationId;
				return $this->EditVariationStep1($error, MSG_ERROR, true);
			}

			/**
			 * Add our new variation record
			 */
			$rtn = $this->SaveVariationData($variationData);

			/**
			 * Did we get any errors?
			 */
			if (!$rtn) {
				$_GET['variationId'] = $variationId;
				return $this->EditVariationStep1(sprintf(GetLang("ErrorWhenUpdatingVariation"), $GLOBALS["ISC_CLASS_DB"]->GetErrorMsg()), MSG_ERROR, true);
			}

			if (isset($_POST['addanother'])) {
				$_GET['variationId'] = $variationId;
				$this->EditVariationStep1(GetLang("VariationUpdatedSuccessfully"), MSG_SUCCESS);
			} else {
				$this->ViewVariations(GetLang("VariationUpdatedSuccessfully"), MSG_SUCCESS);
			}
		}

		/**
		 * Save the variation information
		 *
		 * Method will save the variation information to the database. Will look in the $data array for the variation ID to see if it is an update
		 * or a new record
		 *
		 * @access private
		 * @param array $data The variation information to save
		 * @return mixed Either the new variation ID if successfully added, TRUE if successfully updated, FALSE otherwise
		 */
		private function SaveVariationData($data)
		{
			/**
			 * Do we have any data to insert/update?
			 */
			if (!is_array($data) || empty($data)) {
				return false;
			}

			$variation = null;

			if (isId($data['id'])) {
				$result = $GLOBALS['ISC_CLASS_DB']->Query("SELECT * FROM [|PREFIX|]product_variations WHERE variationid = " . (int)$data['id']);
				$variation = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
			}

			/**
			 * Check to see if we were given a proper variation ID
			 */
			if (isId($data['id']) && !is_array($variation)) {
				return false;
			}

			/**
			 * Start our transaction. If that dies then bail
			 */
			if ($GLOBALS["ISC_CLASS_DB"]->StartTransaction() === false) {
				return false;
			}

			$savedata = array(
						'vname' => $data['name'],
						'vnumoptions' => count($data['options']),
			);

			/**
			 * Assign our vendor ID
			 */
			if (gzte11(ISC_HUGEPRINT)) {
				// User is assigned to a vendor so any variations they create must be too
				if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
					$savedata['vvendorid'] = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId();
				} else if(isId($data['vendor'])) {
					$savedata['vvendorid'] = (int)$data['vendor'];
				}
			}

			/**
			 * Add/Update the variation record
			 */
			if (!isId($data['id'])) {
				$rtn = $GLOBALS['ISC_CLASS_DB']->InsertQuery('product_variations', $savedata);
				$data['id'] = $rtn;
			} else {
				$rtn = $GLOBALS['ISC_CLASS_DB']->UpdateQuery('product_variations', $savedata, "variationid=" . (int)$data['id']);
			}

			if ($rtn === false) {
				return false;
			}

			/**
			 * Now to add/edit the options. These options are in order.
			 */
			$optionPos = 0;
			$deleteCombo = false;
			$groupedValues = array();
			foreach ($data['options'] as $option) {

				$optionPos++;
				$valuePos = 0;
				$addValues = array();
				$editValues = array();
				$origOptionName = '';
				$newOptionName = '';

				foreach ($option['values'] as $value) {
					$valuePos ++;
					$savedata = array(
						'vovariationid' => (int)$data['id'],
						'voname' => $option['name'],
						'vovalue' => $value['name'],
						'vooptionsort' => (int)$optionPos,
						'vovaluesort' => (int)$valuePos,
					);

					/**
					 * Are we updating or adding
					 */
					if (!isset($value['valueid']) || !isId($value['valueid'])) {
						$rtn = $GLOBALS['ISC_CLASS_DB']->InsertQuery('product_variation_options', $savedata);
						$addValues[] = (int)$rtn;
					} else {

						/**
						 * If we are updating then we need to make sure that option name is the same for all the values within that option
						 */
						if ($origOptionName == '') {
							$result = $GLOBALS['ISC_CLASS_DB']->Query("SELECT voname FROM [|PREFIX|]product_variation_options WHERE voptionid = " . (int)$value['valueid']);
							$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
							$origOptionName = isc_html_escape($row['voname']);
							$newOptionName = $savedata['voname'];
						}

						$editValues[] = (int)$value['valueid'];
						$rtn = $GLOBALS['ISC_CLASS_DB']->UpdateQuery('product_variation_options', $savedata, 'voptionid=' . (int)$value['valueid']);
					}

					if ($rtn === false) {
						$GLOBALS['ISC_CLASS_DB']->RollbackTransaction();
						return false;
					}
				}

				$groupedValues = array_merge($groupedValues, $editValues, $addValues);
				$groupedValues = array_unique($groupedValues);

				/**
				 * If our variation already exists and we have added a new value then delete all combinations for it
				 */
				if (is_array($variation) && !empty($addValues)) {
					$deleteCombo = true;
				}

				/**
				 * Update our new option name if we have to
				 */
				if ($origOptionName !== '') {
					$savedata = array(
						'voname' => $newOptionName
					);

					$rtn = $GLOBALS['ISC_CLASS_DB']->UpdateQuery("product_variation_options", $savedata, "vovariationid=" . (int)$data['id']  . " AND voname='" . $GLOBALS['ISC_CLASS_DB']->Quote($origOptionName) . "'");
					if ($rtn === false) {
						$GLOBALS['ISC_CLASS_DB']->RollbackTransaction();
						return false;
					}
				}
			}

			/**
			 * OK, we have all the option values, now we remove any combinations that were using any deleted option values. Again, only do this for existing variations and also
			 * too only do this if $deleteCombo is FALSE!!!
			 */
			if (is_array($variation) && !$deleteCombo) {

				/**
				 * First, run a query to see which options (grouped option values) are to be deleted
				 */
				$query = "SELECT voname, GROUP_CONCAT(voptionid) AS vovalues, COUNT(*) AS vototal, SUM(IF(voptionid IN(" . implode(',', $groupedValues) . "), 0, 1)) AS vodelete
							FROM [|PREFIX|]product_variation_options
							GROUP BY voname";

				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {

					$tmpValues = explode(',', $row['vovalues']);
					$deleteComboIdx = array();

					/**
					 * Was the entire option deleted?
					 */
					if ($row['vototal'] == $row['vodelete']) {

						/**
						 * We keep a record of what we removed because when we remove one option from the combination then we'll also create duplicate combinations
						 */
						$duplicatRecords = array();

						/**
						 * Loop through all the combinations and remove that option while still keeping that combination
						 */
						$sResult = $GLOBALS['ISC_CLASS_DB']->Query("SELECT combinationid, vcoptionids FROM [|PREFIX|]product_variation_combinations WHERE vcvariationid=" . (int)$data['id']);
						while ($sRow = $GLOBALS['ISC_CLASS_DB']->Fetch($sResult)) {
							$tmpCobmo = explode(',', $sRow['vcoptionids']);
							$tmpCount = count($tmpCobmo);

							foreach ($tmpValues as $findValue) {
								$foundKey = array_search($findValue, $tmpCobmo);
								if ($foundKey !== false) {
									unset($tmpCobmo[$foundKey]);
								}
							}

							/**
							 * Do we need to do anything?
							 */
							if ($tmpCount !== count($tmpCobmo)) {

								/**
								 * Build the key to check for duplicates
								 */
								$duplicateKey = $tmpCobmo;
								sort($duplicateKey);
								$duplicateKey = implode('-', $duplicateKey);

								/**
								 * Check our duplicate record. If we are in then mark it to be deleted
								 */
								if (array_key_exists($duplicateKey, $duplicatRecords)) {
									$deleteComboIdx[] = (int)$sRow['combinationid'];

								/**
								 * Else we update it
								 */
								} else {
									$duplicatRecords[$duplicateKey] = true;
									sort($tmpCobmo);
									$rtn = $GLOBALS['ISC_CLASS_DB']->UpdateQuery('product_variation_combinations', array('vcoptionids' => implode(',', $tmpCobmo)), 'combinationid = ' . (int)$sRow['combinationid']);

									if ($rtn === false) {
										$GLOBALS['ISC_CLASS_DB']->RollbackTransaction();
										return false;
									}
								}
							}
						}

					/**
					 * Else we just delete those combinations that use these values IF some values were deleted. Store the combinationid to an array so we can just use one delete query
					 */
					} else if ($row['vodelete'] > 0) {
						$sResult = $GLOBALS['ISC_CLASS_DB']->Query("SELECT combinationid, vcoptionids FROM [|PREFIX|]product_variation_combinations WHERE vcvariationid=" . (int)$data['id']);

						while ($sRow = $GLOBALS['ISC_CLASS_DB']->Fetch($sResult)) {
							$tmpCobmo = explode(',', $sRow['vcoptionids']);
							$removeCombo = false;

							foreach ($tmpCobmo as $id) {
								if (!in_array($id, $groupedValues)) {
									$removeCombo = true;
									break;
								}
							}

							if ($removeCombo) {
								$deleteComboIdx[] = (int)$sRow['combinationid'];
							}
						}
					}

					/**
					 * Delete any combinations if we have to
					 */
					if (!empty($deleteComboIdx)) {
						$rtn = $GLOBALS['ISC_CLASS_DB']->DeleteQuery('product_variation_combinations', 'WHERE combinationid IN(' . implode(',', $deleteComboIdx) . ')');
						if ($rtn === false) {
							$GLOBALS['ISC_CLASS_DB']->RollbackTransaction();
							return false;
						}
					}
				}

			/**
			 * Else we delete all combinations that are using this variation IF this variation has had some extra values added
			 */
			} else if ($deleteCombo) {
				$rtn = $GLOBALS['ISC_CLASS_DB']->DeleteQuery('product_variation_combinations', 'WHERE vcvariationid=' . (int)$data['id']);
				if ($rtn === false) {
					$GLOBALS['ISC_CLASS_DB']->RollbackTransaction();
					return false;
				}

				$rtn = $GLOBALS['ISC_CLASS_DB']->UpdateQuery('products', array('prodvariationid' => '0'), 'prodvariationid=' . (int)$data['id']);
				if ($rtn === false) {
					$GLOBALS['ISC_CLASS_DB']->RollbackTransaction();
					return false;
				}
			}

			/**
			 * Now we delete all values that were removed. Only do this for existing variations as it is pretty usless on new variations
			 */
			if (is_array($variation)) {

				$extraWhere = '';
				if (!empty($groupedValues)) {
					$extraWhere = " AND voptionid NOT IN(" . implode(',', $groupedValues) . ")";
				}

				$rtn = $GLOBALS['ISC_CLASS_DB']->DeleteQuery("product_variation_options", "WHERE vovariationid=" . (int)$data['id'] . $extraWhere);
				if ($rtn === false) {
					$GLOBALS['ISC_CLASS_DB']->RollbackTransaction();
					return false;
				}
			}

			/**
			 * Now we try commiting this. If we get an error here then just bail
			 */
			if ($GLOBALS['ISC_CLASS_DB']->CommitTransaction() === false) {
				$GLOBALS['ISC_CLASS_DB']->RollbackTransaction();
				return false;
			}

			/**
			 * All is good, now return something to say so
			 */
			if ($variation) {
				return true;
			} else {
				return $data['id'];
			}
		}

		/**
		 * Built the variation form
		 *
		 * Function will build the sortable HTML form used for filling in the variation data
		 *
		 * @access private
		 * @param array $data The optional data to build from. Should be the return from GetVariationData()
		 * @return string The variation HTML form
		 */
		private function BuildVariationCreate($data=array())
		{
			/**
			 * A fallback for adding the essential information
			 */
			if (!is_array($data) || empty($data) || !array_key_exists('options', $data) || empty($data['options'])) {
				$data = array(
							array(
								'index' => 0,
								'name' => '',
								'values' => array(
												array(
														'index' => 0,
														'valueid' => '',
														'name' => '',
													)
												)
										)
							);
			} else {
				$data = $data['options'];
			}

			/**
			 * Now to build the rows. Firstly see if we should hide the option row delete button
			 */
			if (count($data) <= 1) {
				$GLOBALS['HideRowDelete'] = 'none';
			}

			$rows = '';

			foreach ($data as $row) {

				if (array_key_exists('values', $row) && is_array($row['values'])) {
					$values = '';

					/**
					 * Should we hide the value delete button?
					 */
					if (count($row['values']) <= 1) {
						$GLOBALS['HideOptionDelete'] = 'none';
					}
					foreach ($row['values'] as $value) {

						$GLOBALS['VariationOptionRankId'] = isc_html_escape($row['index']);
						$GLOBALS['VariationValueRankId'] = $value['index'];

						if (array_key_exists('valueid', $value)) {
							$GLOBALS['VariationValueId'] = isc_html_escape($value['valueid']);
						}

						if (array_key_exists('name', $value)) {
							$GLOBALS['VariationValue'] = isc_html_escape($value['name']);
						}

						$values .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('ProductVariationValue');
					}

					$GLOBALS['ProductVariationValue'] = $values;
				}

				$GLOBALS['VariationOptionRankId'] = isc_html_escape($row['index']);
				$GLOBALS['VariationOptionName'] = isc_html_escape($row['name']);
				$rows .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('ProductVariationRow');
			}

			return $rows;
		}

		/**
		 * Validate the submitted variation form data
		 *
		 * Method will validate the submitted variation form data
		 *
		 * @access private
		 * @param array $data The variation data to validate
		 * @param string &$error The referenced string to store the error in, if any were found
		 * @return bool TRUE if POST data is valid, FALSE if there were errors
		 */
		private function ValidateVariationData($data, &$error)
		{
			/**
			 * Do we have anything to validate?
			 */
			if (empty($data) || $data['name'] == '') {
				$error = GetLang("ProductVariationErrorNoVariationName");
				return false;
			}

			/**
			 * Check to see if this variation name is unique
			 */
			$query = "SELECT * FROM [|PREFIX|]product_variations WHERE vname='" . $GLOBALS['ISC_CLASS_DB']->Quote($data['name']) . "'";
			if (isId($data['id'])) {
				$query .= " AND variationid != " . (int)$data['id'];
			}

			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			if ($GLOBALS['ISC_CLASS_DB']->CountResult($result)) {
				$error = GetLang("ProductVariationErrorNameNotUnique");
				return false;
			}

			/**
			 * Do we have any options?
			 */
			if (!array_key_exists('options', $data) || empty($data['options'])) {
				$error = GetLang('ProductVariationErrorNoData');
				return false;
			}

			$pos=0;
			$optionNames = array();
			foreach ($data['options'] as $rowIndex => $row) {
				$pos++;

				if ($row['name'] == '') {
					$error = sprintf(GetLang('ProductVariationErrorNoOptionName'), $pos);
					return false;
				} else if (count($row['values']) <= 1) {
					$error = sprintf(GetLang('ProductVariationErrorInvalidOptions'), $pos);
					return false;
				}

				$validateUniqueIdx = array();

				foreach ($row['values'] as $value) {
					if (isset($value['valueid']) && isId($value['valueid'])) {
						$validateUnique[] = (int)$value['valueid'];
					}
				}

				/**
				 * Check to see if each of our option names are unique
				 */
				foreach ($optionNames as $id => $name) {
					if ($name == $row['name']) {
						$error = sprintf(GetLang('ProductVariationErrorOptionNameNotUnique'), $pos, ($id+1));
						return false;
					}
				}

				$optionNames[] = $row['name'];
			}

			return true;
		}

		/**
		 * Get the posted variation data
		 *
		 * Method will return the posted variation data
		 *
		 * @access private
		 * @param int $variationId The optional variation to load from the database. Default is 0 (load from POST)
		 * @return array The posted variation data
		 */
		private function GetVariationData($variationId=0)
		{
			$data = array();

			/**
			 * Load from database
			 */
			if (isId($variationId)) {
				$result = $GLOBALS['ISC_CLASS_DB']->Query("SELECT * FROM [|PREFIX|]product_variations WHERE variationid=" . (int)$variationId);
				$variation = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

				if (!$variation) {
					return $data;
				}

				$data['id'] = (int)$variation['variationid'];
				$data['name'] = $variation['vname'];
				$data['vendor'] = (int)$variation['vvendorid'];
				$data['options'] = array();

				/**
				 * Now get the options
				 */
				$currentOption = null;
				$result = $GLOBALS['ISC_CLASS_DB']->Query("SELECT * FROM [|PREFIX|]product_variation_options WHERE vovariationid=" . (int)$variationId . " ORDER BY vooptionsort, vovaluesort");

				while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {

					/**
					 * Check to see if we are still using the same option
					 */
					if (is_null($currentOption) || $currentOption !== $row['voname']) {
						$optionKey = count($data['options']);
						$valueKey = 0;
						$currentOption = $row['voname'];
						$data['options'][$optionKey] = array(
										'index' => $optionKey,
										'name' => $row['voname'],
										'values ' => array(),
						);
					}

					/**
					 * Add the option
					 */
					$data['options'][$optionKey]['values'][$valueKey] = array(
										'valueid' => $row['voptionid'],
										'index' => $valueKey,
										'name' => $row['vovalue']
					);

					$valueKey++;
				}

			/**
			 * Else load from POST
			 */
			} else {

				$data = array(
					'options' => array()
				);

				if (array_key_exists('variationId', $_POST)) {
					$data['id'] = (int)$_POST['variationId'];
				}

				if (array_key_exists('vname', $_POST)) {
					$data['name'] = $_POST['vname'];
				}

				if (array_key_exists('vendor', $_POST)) {
					$data['vendor'] = $_POST['vendor'];
				}

				/**
				 * Go get our options. Bail if we do not have any
				 */
				if (!array_key_exists('variationOptionName', $_POST) || !is_array($_POST['variationOptionName'])) {
					return $data;
				}

				$options = array();
				foreach ($_POST['variationOptionName'] as $optionId => $optionVal) {

					/**
					 * Start our record
					 */
					$optionKey = count($options);
					$options[$optionKey] = array(
							'index' => $optionId,
							'name' => trim($optionVal),
							'values' => array()
					);

					/**
					 * Do we have any values at all?
					 */
					if (!isset($_POST['variationOptionValue'][$optionId]) || !is_array($_POST['variationOptionValue'][$optionId])) {
						continue;
					}

					foreach ($_POST['variationOptionValue'][$optionId] as $valueId => $valueVal) {

						$valueKey = count($options[$optionKey]['values']);

						$options[$optionKey]['values'][$valueKey] = array(
											'index' => $valueId,
											'name' => trim($valueVal)
						);

						if (isset($_POST['variationOptionValueId'][$optionId][$valueId]) && isId($_POST['variationOptionValueId'][$optionId][$valueId])) {
							$options[$optionKey]['values'][$valueKey]['valueid'] = (int)$_POST['variationOptionValueId'][$optionId][$valueId];
						}
					}
				}

				/**
				 * Add our options to our return data array
				 */
				$data['options'] = $options;
			}

			return $data;
		}

		/**
		 * Get default variation options
		 *
		 * Method will return the default variations when adding in a new variation. Basically some test data
		 *
		 * @access private
		 * return array The default variation test data
		 */
		private function GetVariationTestData()
		{
			$testdata = array(
						'options' => array()
						);

			$testdata['options'][] = array(
					'index' => 0,
					'name' => GetLang('ProductVariationTestDataOptionColour'),
					'values' => array(
									array(
										'index' => 0,
										'name' => GetLang('ProductVariationTestDataValueColourRed')
									),
									array(
										'index' => 1,
										'name' => GetLang('ProductVariationTestDataValueColourBlue')
									),
									array(
										'index' => 2,
										'name' => GetLang('ProductVariationTestDataValueColourPurple')
									),
									array(
										'index' => 3,
										'name' => GetLang('ProductVariationTestDataValueColourOrange')
									)
								)
						);

			$testdata['options'][] = array(
					'index' => 1,
					'name' => GetLang('ProductVariationTestDataOptionSize'),
					'values' => array(
									array(
										'index' => 0,
										'name' => GetLang('ProductVariationTestDataValueSizeSmall')
									),
									array(
										'index' => 1,
										'name' => GetLang('ProductVariationTestDataValueSizeMedium')
									),
									array(
										'index' => 2,
										'name' => GetLang('ProductVariationTestDataValueSizeLarge')
									),
									array(
										'index' => 3,
										'name' => GetLang('ProductVariationTestDataValueSizeXLarge')
									)
								)
						);

			$testdata['options'][] = array(
					'index' => 2,
					'name' => GetLang('ProductVariationTestDataOptionStyle'),
					'values' => array(
									array(
										'index' => 0,
										'name' => GetLang('ProductVariationTestDataValueStyleModern')
									),
									array(
										'index' => 1,
										'name' => GetLang('ProductVariationTestDataValueStyleClassic')
									)
								)
						);

			return $testdata;
		}

		/**
		* _LoadVariation
		* Load the details of a product variation from the product_variations table
		*
		* @param Int $VariationId The id of the variation to load
		* @return Array containing the variation details on success, false on failure
		*/
		public function _LoadVariation($VariationId)
		{
			$query = sprintf("SELECT * FROM [|PREFIX|]product_variations WHERE variationid='%d'", $VariationId);
			$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);

			if($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
				return $row;
			}
			else {
				return false;
			}
		}

		/**
		* _LoadVariationOptions
		* Load a list of options for a variation
		*
		* @param Int $VariationId The id of the variation to load options for
		* @return String containing the variation details on success, false on failure
		*/
		public function _LoadVariationOptions($VariationId)
		{
			$query = sprintf("SELECT * FROM [|PREFIX|]product_variation_options WHERE vovariationid='%d'", $VariationId);
			$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
			$options = "";
			$names_done = array();

			if($GLOBALS["ISC_CLASS_DB"]->CountResult($result) > 0) {
				while($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
					if(!in_array($row['voname'], $names_done)) {
						$options .= "\n" . $row['voname'] . ":";
						$names_done[] = $row['voname'];
					}

					$options .= $row['vovalue'] . ",";
				}

				$options = str_replace(",\n", "", $options);
				$options = preg_replace("/,$/", "", $options);
				return $options;
			}
			else {
				return false;
			}
		}

		/**
		* DeleteVariations
		* Delete one/more product variations from the database
		*
		* @return Void
		*/
		public function DeleteVariations()
		{
			if(isset($_POST['variations']) && is_array($_POST['variations'])) {

				foreach ($_POST['variations'] as $k => $v) {
					$_POST['variations'][$k] = (int) $v;
				}

				// What we do here is feed the list of product IDs in to a query with the vendor applied so that way
				// we're sure we're only deleting variations this user has permission to delete.
				$variation_ids = implode("','", array_map('intval', $_POST['variations']));
				$vendorId = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId();
				if($vendorId > 0) {
					$query = "
						SELECT variationid
						FROM [|PREFIX|]product_variations
						WHERE variationid IN ('".$variation_ids."') AND vvendorid='".(int)$vendorId."'
					";
					$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
					$variation_ids = '';
					while($variation = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
						$variation_ids .= $variation['variationid'].',';
					}
					$variation_ids = rtrim($variation_ids, ',');
				}
				$GLOBALS["ISC_CLASS_DB"]->StartTransaction();

				// Delete the variation
				$GLOBALS["ISC_CLASS_DB"]->DeleteQuery("product_variations", sprintf("WHERE variationid IN('%s')", $variation_ids));

				// Delete the variation combinations
				$GLOBALS["ISC_CLASS_DB"]->DeleteQuery("product_variation_combinations", sprintf("WHERE vcvariationid IN('%s')", $variation_ids));

				// Delete the variation options
				$GLOBALS["ISC_CLASS_DB"]->DeleteQuery("product_variation_options", sprintf("WHERE vovariationid IN('%s')", $variation_ids));

				// Update the products that use this variation to not use any at all
				$GLOBALS["ISC_CLASS_DB"]->UpdateQuery("products", array("prodvariationid" => "0"), "prodvariationid IN('" . $variation_ids . "')");

				if($GLOBALS["ISC_CLASS_DB"]->GetErrorMsg() == "") {
					$GLOBALS["ISC_CLASS_DB"]->CommitTransaction();
					$this->ViewVariations(GetLang("VariationDeletedSuccessfully"), MSG_SUCCESS);
				}
				else {
					$GLOBALS["ISC_CLASS_DB"]->RollbackTransaction();
					$this->ViewVariations(sprintf(GetLang("ErrorWhenDeletingVariation"), $GLOBALS["ISC_CLASS_DB"]->GetErrorMsg()), MSG_ERROR);
				}
			}
			else {
				$this->ViewVariations();
			}
		}

		/**
		 * Copy variation combination data from one product to another product
		 *
		 * Method will duplicate all the variation combination data, imcluding images, to either a product ID or a product hash
		 *
		 * @access private
		 * @param int $fromProductId The product to duplciate the variations from
		 * @param int $toProductId The optional product ID to duplicate the variations to. This will delete all existing variations!
		 * @param string $toProductHash The optional product hash to duplicate the variations to. This will delete all existing variations!
		 * @return bool TRUE if all the variation combinations were duplicated successfully, FALSE if not
		 */
		private function _CopyVariationData($fromProductId, $toProductId=0, $toProductHash='')
		{
			if (!isId($fromProductId)) {
				print 'Step 1';
				return false;
			}

			/**
			 * Must either have a product ID or a hash string
			 */
			if (!isId($toProductId) && $toProductHash == '') {
				print 'Step 2';
				return false;
			}

			/**
			 * Delete all previous variations for the 'to' product as we really do not want to mix them up
			 */
			if (isId($toProductId)) {
				$rtn = $GLOBALS['ISC_CLASS_DB']->DeleteQuery('product_variation_combinations', "WHERE vcproductid=" . (int)$toProductId);
			} else {
				$rtn = $GLOBALS['ISC_CLASS_DB']->DeleteQuery('product_variation_combinations', "WHERE vcproducthash='" . $GLOBALS['ISC_CLASS_DB']->Quote($toProductHash) . "'");
			}

			if ($rtn === false) {
				return false;
			}

			$dir = GetConfig('ImageDirectory');
			$result = $GLOBALS['ISC_CLASS_DB']->Query("SELECT * FROM [|PREFIX|]product_variation_combinations WHERE vcproductid=" . (int)$fromProductId);
			while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {

				$newImage = '';
				$newThumb = '';

				/**
				 * Copy the images if we have to
				 */
				if ($row['vcimage'] !== '') {
					$origImage = realpath(ISC_BASE_PATH . '/' . $dir . '/' . $row['vcimage']);
					$newImage = $this->_CopyImages($origImage);
				}

				/**
				 * Also the thumb
				 */
				if ($row['vcthumb'] !== '') {
					$origThumb = realpath(ISC_BASE_PATH . '/' . $dir . '/' . $row['vcthumb']);
					$newThumb = $this->_CopyImages($origThumb);
				}

				/**
				 * Now store the record
				 */
				$savedata = $row;
				$savedata['vcimage'] = $newImage;
				$savedata['vcthumb'] = $newThumb;
				unset($savedata['combinationid']);

				if (isId($toProductId)) {
					$savedata['vcproductid'] = (int)$toProductId;
					$savedata['vcproducthash'] = '';
				} else {
					unset($savedata['vcproductid']);
					$savedata['vcproducthash'] = $toProductHash;
				}

				$GLOBALS['ISC_CLASS_DB']->InsertQuery('product_variation_combinations', $savedata);
			}

			return true;
		}

		/**
		* _GetVariationData
		* Load the variation data for a product either from the form or database
		*
		* @param Int $ProductId The ID of the product to load variations for. 0 if it's a new product
		* @param String $RefArray The array to store the variation details in
		* @return Void
		*/
		public function _GetVariationData($ProductId = 0, &$RefArray = array())
		{
			if($ProductId == 0) {
				// First, do we even have a variation selected?
				if(isset($_POST['variationId']) && is_numeric($_POST['variationId']) && isset($_POST['options'])) {
					foreach($_POST['options'] as $option_counter => $option) {
						$tmp = array();

						// The combination ID hasn't been assigned yet
						if(isset($option['id'])) {
							$tmp['combinationid'] = $option['id'];
						}
						else {
							$tmp['combinationid'] = 0;
						}

						// The product ID hasn't been assigned yet
						$tmp['vcproductid'] = 0;

						// The variation id
						$tmp['vcvariationid'] = (int)$_POST['variationId'];

						// Is the combination enabled?
						$tmp['vcenabled'] = 0;
						if(isset($option['enabled'])) {
							$tmp['vcenabled'] = 1;
						}

						// The variation option combination
						$ids = preg_replace("/^#/", "", $option['variationcombination']);
						$ids = str_replace("#", ",", $ids);
						$tmp['vcoptionids'] = $ids;

						// The product option's SKU
						$tmp['vcsku'] = $option['sku'];

						// The price difference type
						$tmp['vcpricediff'] = $option['pricediff'];

						// The price difference or fixed price
						$tmp['vcprice'] = DefaultPriceFormat($option['price']);

						// The weight difference type
						$tmp['vcweightdiff'] = $option['weightdiff'];

						// The weight difference or fixed weight
						$tmp['vcweight'] = DefaultDimensionFormat($option['weight']);

						// The image for this product option (if it's set)
						if($this->_IsValidVariationImage($option_counter)) {
							$tmp['vcimage'] = $this->_StoreOptionImageAndReturnId($option_counter);
						}
						else {
							// Do we need to remove the image?
							if(isset($option['delimage'])) {
								$tmp['vcimage'] = "REMOVE";
							}
							else {
								$tmp['vcimage'] = "";
							}
						}

						// The thumbnail image for this product option
						if($tmp['vcimage'] != "") {
							$tmp['vcthumb'] = $this->_AutoGenerateThumb($tmp['vcimage']);
						}
						else {
							$tmp['vcthumb'] = "";
						}

						// The current stock level
						if(isset($option['currentstock'])) {
							$tmp['vcstock'] = (int)$option['currentstock'];
						}
						else {
							$tmp['vcstock'] = 0;
						}

						// The low stock level
						if(isset($option['lowstock'])) {
							$tmp['vclowstock'] = (int)$option['lowstock'];
						}
						else {
							$tmp['vclowstock'] = 0;
						}

						// Push the option to the stack
						array_push($RefArray, $tmp);
					}
				}
			}
		}

		/**
		* _IsValidVariationImage
		* Checks to see if a particular file in the $_FILES array is valid
		* in context of being a product option's image
		*
		* @param Int $OptionCounter The ID of the image to check
		* @return Boolean
		*/
		public function _IsValidVariationImage($OptionCounter)
		{
			if(isset($_FILES['options']['name'][$OptionCounter]['image']) &&
			   $_FILES['options']['name'][$OptionCounter]['image'] != "" &&
			   strtolower(substr($_FILES['options']['type'][$OptionCounter]['image'], 0, 5)) == "image" &&
			   $_FILES['options']['error'][$OptionCounter]['image'] == 0 &&
			   $_FILES['options']['size'][$OptionCounter]['image'] > 0
			) {
				return true;
			}
			else {
				return false;
			}
		}

		/**
		* _StoreOptionImageAndReturnId
		* Works the same way as the _StoreFileAndReturnId function except there's a few changes because of the way images for options are retrieved from the $_FILES array
		*
		* @param Int $OptionFileId The ID of the option whose image should be saved
		* @return String Empty on failure, the new filename on success
		*/
		public function _StoreOptionImageAndReturnId($OptionFileId)
		{
			// This function takes a file name as its arguement and stores
			// this file in the /downloads or /images directory depending
			// on the $FileType enumeration value

			$dir = GetConfig('ImageDirectory');

			if(is_dir(sprintf("../%s", $dir))) {
				// Images are stored within a directory randomly chosen from a-z.
				$randomDir = strtolower(chr(rand(65, 90)));
				if(!is_dir("../".$dir."/".$randomDir)) {
					if(!@mkdir("../".$dir."/".$randomDir, 0777)) {
						$randomDir = '';
					}
				}

				// Clean up the incoming file name a bit
				$_FILES['options']['name'][$OptionFileId]['image'] = preg_replace("#[^\w.]#i", "_", $_FILES['options']['name'][$OptionFileId]['image']);
				$_FILES['options']['name'][$OptionFileId]['image'] = preg_replace("#_{1,}#i", "_", $_FILES['options']['name'][$OptionFileId]['image']);

				$randomFileName = GenRandFileName($_FILES['options']['name'][$OptionFileId]['image']);
				$fileName = $randomDir . "/" . $randomFileName;
				$dest = realpath(ISC_BASE_PATH.'/' . $dir);

				while(file_exists($dest."/".$fileName)) {
					$fileName = basename($randomFileName);
					$fileName = substr_replace($randomFileName, "-".rand(0, 10000000000), strrpos($randomFileName, "."), 0);
					$fileName = $randomDir . "/" . $fileName;
				}
				$dest .= "/".$fileName;

				if(move_uploaded_file($_FILES['options']['tmp_name'][$OptionFileId]['image'], $dest)) {
					isc_chmod($dest, ISC_WRITEABLE_FILE_PERM);
					// The file was moved successfully
					return $fileName;
				}
				else {
					// Couldn't move the file, maybe the directory isn't writable?
					return "";
				}
			} else {
				// The directory doesn't exist
				return "";
			}
		}

		/*
		* _LoadVariationCombinationsTable
		* Create and output the table that contains all combinations of options for a product variation
		*
		* @param Int $VariationId The variation which contains the combinations to load
		* @param Boolean $ShowInventoryFields Whether to include the "Stock Level" and "Low Stock Level" fields in the table
		* @param Int $ProductId The optional ID of the products saved option combinations that should be used to pre-populate the fields
		* @return Void
		*/
		public function _LoadVariationCombinationsTable($VariationId, $ShowInventoryFields, $ProductId=0, $ProductHash='')
		{
			$GLOBALS['HeaderRows'] = "";
			$GLOBALS['VariationRows'] = "";
			$options = array();
			$option_ids = array();
			$i = 0;

			$query = sprintf("SELECT DISTINCT(voname) FROM [|PREFIX|]product_variation_options WHERE vovariationid='%d' ORDER BY vooptionsort, vovaluesort", $VariationId);
			$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);

			while($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
				$GLOBALS['HeaderRows'] .= sprintf("<td>%s</td>", isc_html_escape($row['voname']));
				$options[$row['voname']] = array();
				$option_ids[$row['voname']] = array();
			}

			// Now get all of the variation combinations
			$query = sprintf("SELECT * FROM [|PREFIX|]product_variation_options WHERE vovariationid='%d' ORDER BY vooptionsort, vovaluesort", $VariationId);
			$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);

			while($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
				$options[$row['voname']][] = $row['vovalue'];
				$option_ids[$row['voname']][] = $row['voptionid'];
			}

			// Get the variation combinations as text, such as #red#small#modern
			$GLOBALS["variation_data"] = array();
			$GLOBALS['VariationRows'] = "";
			$this->GetCombinationText('', $options);
			$GLOBALS["variation_combinations"] = $GLOBALS["variation_data"];

			// Get the variation combinations ID's, such as #145#185#195
			$GLOBALS["variation_data"] = array();
			$this->GetCombinationText('', $option_ids);
			$GLOBALS["variation_combination_ids"] = $GLOBALS["variation_data"];

			// Setup a counter
			$count = 0;

			// Loop through the variation combination ID's and output them as hidden fields
			foreach($GLOBALS["variation_combination_ids"] as $k=>$combo) {
				$GLOBALS['VariationRows'] .= sprintf("	<input name='options[$count][variationcombination]' type='hidden' value='%s' /></td>", $combo);
				++$count;
			}

			// Reset the counter
			$count = 0;

			// Now loop through all of the options and output the combinations
			if(count($GLOBALS["variation_combinations"]) > 0 && $GLOBALS["variation_combinations"][0] != "") {
				foreach($GLOBALS["variation_combinations"] as $k=>$combo) {

					// Set the default values
					$enabled = 'checked="checked"';
					$sku = "";
					$add_p_checked = $subtract_p_checked = $fixed_p_checked = "";
					$show_price = "none";
					$price = "";
					$add_w_checked = $subtract_w_checked = $fixed_w_checked = "";
					$show_weight = "none";
					$weight = "";

					if (isId($ProductId) || $ProductHash !== '') {
						// Get the variation combination's existing details from the product_variation_combinations table
						$combo_ids = preg_replace("/^#/", "", $GLOBALS["variation_combination_ids"][$count]);
						$combo_ids = str_replace("#", ",", $combo_ids);

						$query = "SELECT * FROM [|PREFIX|]product_variation_combinations WHERE vcoptionids='" . $GLOBALS['ISC_CLASS_DB']->Quote($combo_ids) . "' AND ";
						if (isId($ProductId)) {
							$query .= "vcproductid=" . (int)$ProductId;
						} else {
							$query .= "vcproducthash='" . $GLOBALS['ISC_CLASS_DB']->Quote($ProductHash) . "'";
						}
						$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);

						// Are there any option details?
						if($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
							if($row['vcenabled'] == 1) {
								$enabled = 'checked="checked"';
							}
							else {
								$enabled = "";
							}

							$sku = $row['vcsku'];

							$add_p_checked = $subtract_p_checked = $fixed_p_checked = "";
							$show_price = "none";
							$price = "";

							switch($row['vcpricediff']) {
								case "add": {
									$add_p_checked = 'selected="selected"';
									$show_price = "";
									$price = FormatPrice($row['vcprice'], false, false);
									break;
								}
								case "subtract": {
									$subtract_p_checked = 'selected="selected"';
									$show_price = "";
									$price = FormatPrice($row['vcprice'], false, false);
									break;
								}
								case "fixed": {
									$fixed_p_checked = 'selected="selected"';
									$show_price = "";
									$price = FormatPrice($row['vcprice'], false, false);
									break;
								}
							}

							$add_w_checked = $subtract_w_checked = $fixed_w_checked = "";
							$show_weight = "none";
							$weight = "";

							switch($row['vcweightdiff']) {
								case "add": {
									$add_w_checked = 'selected="selected"';
									$show_weight = "";
									$weight = FormatWeight($row['vcweight'], false);
									$show_weight = "";
									break;
								}
								case "subtract": {
									$subtract_w_checked = 'selected="selected"';
									$show_weight = "";
									$weight = FormatWeight($row['vcweight'], false);
									$show_weight = "";
									break;
								}
								case "fixed": {
									$fixed_w_checked = 'selected="selected"';
									$show_weight = "";
									$weight = FormatWeight($row['vcweight'], false);
									$show_weight = "";
									break;
								}
							}
						}
					}

					$GLOBALS['VariationRows'] .= sprintf("<input type='hidden' name='options[$count][id]' value='%d' />", $row['combinationid']);
					$GLOBALS['VariationRows'] .= "<tr class=\"GridRow\" onmouseover=\"this.className='GridRowOver'\" onmouseout=\"this.className='GridRow'\">";
					$GLOBALS['VariationRows'] .= "	<td style='width:30px; padding-left:5px'><img src='images/variation.gif' width='16' height='16' /></td>";
					$GLOBALS['VariationRows'] .= sprintf("	<td style='padding-left:4px'><input name='options[$count][enabled]' type='checkbox' %s value='ON' /></td>", $enabled);

					$combo = preg_replace("/^#/", "", $combo);
					$combos = explode("#", $combo);

					foreach($combos as $c) {
						$GLOBALS['VariationRows'] .= sprintf("	<td>%s</td>", isc_html_escape($c));
					}

					$GLOBALS['VariationRows'] .= sprintf("	<td><input name='options[$count][sku]' type='text' class='Field50' value='%s' /></td>", isc_html_escape($sku));

					$GLOBALS['VariationRows'] .= sprintf("	<td>
																<select class='PriceDrop' name='options[$count][pricediff]' onchange=\"if(this.selectedIndex>0) { $(this).parent().find('span').show(); $(this).parent().find('span input').focus(); $(this).parent().find('span input').select(); } else { $(this).parent().find('span').hide(); } \">
																	<option value=''>%s</option>
																	<option %s value='add'>%s</option>
																	<option %s value='subtract'>%s</option>
																	<option %s value='fixed'>%s</option>
																</select>
																<span style='display:%s'>
																	%s <input name='options[$count][price]' type='text' class='Field50 PriceBox' style='width:40px' value='%s' /> %s
																</span>
															</td>", GetLang("NoChange"), $add_p_checked, GetLang("VariationAdd"), $subtract_p_checked, GetLang("VariationSubtract"), $fixed_p_checked, GetLang("VariationFixed"), $show_price, $GLOBALS['CurrencyTokenLeft'], $price, $GLOBALS['CurrencyTokenRight']);

					$GLOBALS['VariationRows'] .= sprintf("	<td>
																<select class='WeightDrop' name='options[$count][weightdiff]' onchange=\"if(this.selectedIndex>0) { $(this).parent().find('span').show(); $(this).parent().find('span input').focus(); $(this).parent().find('span input').select(); } else { $(this).parent().find('span').hide(); } \">
																	<option value=''>%s</option>
																	<option %s value='add'>%s</option>
																	<option %s value='subtract'>%s</option>
																	<option %s value='fixed'>%s</option>
																</select>
																<span style='display:%s'>
																	<input name='options[$count][weight]' type='text' class='Field50 WeightBox' style='width:40px' value='%s' /> %s
																</span>
															</td>", GetLang("NoChange"), $add_w_checked, GetLang("VariationAdd"), $subtract_w_checked, GetLang("VariationSubtract"), $fixed_w_checked, GetLang("VariationFixed"), $show_weight, $weight, GetConfig('WeightMeasurement'));

					$GLOBALS['VariationRows'] .= "	<td><input name='options[$count][image]' type='file' class='Field150 OptionImage' />";

					if($row['vcimage'] != "") {
						$GLOBALS['VariationRows'] .= sprintf("	<br /><input name='options[$count][delimage]' id='variation_delete_image_$count' type='checkbox' value='ON' /> <label for='variation_delete_image_$count'>%s</label> %s <a href='%s' target='_blank'>%s</a>", GetLang("DeleteVariationImage"), GetLang("Currently"), sprintf("%s/%s/%s", $GLOBALS['ShopPath'], GetConfig('ImageDirectory'), $row['vcimage']), $row['vcimage']);
					}

					$GLOBALS['VariationRows'] .= "	</td>";

					// Is inventory tracking enabled for variations?
					if($ShowInventoryFields) {
						$InventoryFieldsHide = "display: auto;";
					}
					else {
						$InventoryFieldsHide = "display: none;";
					}

					$GLOBALS['VariationRows'] .= sprintf("	<td class=\"VariationStockColumn\" style=\"".$InventoryFieldsHide."\"><input name='options[$count][currentstock]' type='text' class='Field50 StockLevel' value='%d' /></td>", $row['vcstock']);
					$GLOBALS['VariationRows'] .= sprintf("	<td class=\"VariationStockColumn\" style=\"".$InventoryFieldsHide."\"><input name='options[$count][lowstock]' type='text' class='Field50 LowStockLevel' value='%d' /></td>", $row['vclowstock']);

					$GLOBALS['VariationRows'] .= "</tr>";
					$count++;
				}
			}

			if(!$ShowInventoryFields) {
				$GLOBALS['HideInv'] = "none";
			}

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("products.variation.combination");
			return $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
		}

		/**
		* GetCombinationText
		* Get all possible option combinations and return them as a string of arrays, such as #red#small#retro or #red#small#modern
		*
		* @param String $string The format to arrange combinations in
		* @param String $traits The array of combinations to iterate through
		* @param Int $i The position of the iteration
		* @return Void
		*/
		public function GetCombinationText($string, $traits, $i=0)
		{
			$keys = array_keys($traits);

			if($i >= count($traits)) {
				$GLOBALS["variation_data"][] = trim($string);
			}
			else {
				foreach($traits[$keys[$i]] as $trait) {
					$this->GetCombinationText("$string#$trait", $traits, $i + 1);
				}
			}
		}

		/**
		* GetCombinationIds
		* Get all possible option combinations and return them as an ID of arrays, such as #143#223#154 or #192#121#175
		*
		* @param String $string The format to arrange combinations in
		* @param String $traits The array of combinations to iterate through
		* @param Int $i The position of the iteration
		* @return Void
		*/
		public function GetCombinationIds($string, $traits, $i=0)
		{
			$keys = array_keys($traits);

			if($i >= count($traits)) {
				$GLOBALS["variation_data"][] = trim($string);
			}
			else {
				foreach($traits[$keys[$i]] as $trait) {
					$this->GetCombinationText("$string#$trait", $traits, $i + 1);
				}
			}
		}

		public function CopyProductStep2()
		{
			/*if($message = strtokenize($_REQUEST, '#')) {
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoError(GetLang(B('UmVhY2hlZFByb2R1Y3RMaW1pdA==')), $message, MSG_ERROR);
				exit;
			}*/

			$prodId = (int)$_POST['originalProductId'];

			// Get the information from the form and add it to the database
			$arrData = array();
			$arrImages = array();
			$arrCustomFields = array();
			$arrVariations = array();
			$err = "";

			$this->_GetProductData(0, $arrData);
			$this->_GetCustomFieldData(0, $arrCustomFields);
			$this->_GetVariationData(0, $arrVariations);
			$this->_GetProductFieldData(0, $arrProductFields);

			$arrImages = $this->_GetImageData(0);
			$orgVarImages = $this->_LoadVariationImages($prodId);
			$discount = $this->GetDiscountRulesData(0, true);

			$downloadError = '';
			if (isset($_FILES['newdownload']) && isset($_FILES['newdownload']['tmp_name']) && $_FILES['newdownload']['tmp_name'] != '') {
				if (!$this->SaveProductDownload($downloadError)) {
					$this->CopyProductStep1($downloadError, MSG_ERROR, false, $prodId);
					return;
				}
			}

			// Does a product with the same name already exist?
			$query = "SELECT productid FROM [|PREFIX|]products WHERE lower(prodname)='".$GLOBALS['ISC_CLASS_DB']->Quote(isc_strtolower($arrData['prodname']))."'";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$existingProduct = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

			if($existingProduct['productid']) {
				return $this->CopyProductStep1(GetLang('ProductWithSameNameExists'), MSG_ERROR, true, $prodId);
			}

			// Validate out discount rules
			if (!empty($discount) && !$this->ValidateDiscountRulesData($error)) {
				$_POST['currentTab'] = 7;
				$this->CopyProductStep1($error, MSG_ERROR, true, $prodId);
				return;
			}

			// Commit the values to the database
			if ($this->_CommitProduct(0, $arrData, $arrImages, $arrVideos, $arrUserVideos, $arrVariations, $arrCustomFields, $discount, $err, $arrProductFields)) {

				// calling the background process to update the price of the products
				$this->UpdatePriceInBackground($GLOBALS['NewProductId']);

				// Log this action
				$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($GLOBALS['NewProductId'], $arrData['prodname']);

				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Products)) {
					// Save the words to the product_words table for search spelling suggestions
					$this->SaveProductWords($arrData['prodname'], $GLOBALS['NewProductId'], "adding");
					if(isset($_POST['addanother'])) {
						FlashMessage(GetLang('ProductAddedSuccessfully'), MSG_SUCCESS);
						header("Location: index.php?ToDo=addProduct");
						exit;
					}
					else {
						FlashMessage(GetLang('ProductAddedSuccessfully'), MSG_SUCCESS);
						header("Location: index.php?ToDo=viewProducts");
						exit;
					}
				} else {
					FlashMessage(GetLang('ProductAddedSuccessfully'), MSG_SUCCESS);
					header("Location: index.php");
					exit;
				}
			} else {
				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Products)) {
					FlashMessage(sprintf(GetLang('ErrProductNotAdded'), $err), MSG_ERROR);
					header("Location: index.php?ToDo=addProduct");
					exit;
				} else {
					FlashMessage(sprintf(GetLang('ErrProductNotAdded'), $err), MSG_ERROR);
					header("Location: index.php");
					exit;
				}
			}
		}

		public function CopyProductStep1($MsgDesc = "", $MsgStatus = "", $PreservePost=false, $OriginalProductID=0)
		{
			if ($MsgDesc != "") {
				$GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
			}

			// Show the form to edit a product
			if (isset($_REQUEST['productId']) && isId($_REQUEST['productId'])) {
				$OriginalProductID = $_REQUEST['productId'];
			}

			$prodId = $OriginalProductID;
			$z = 0;
			$arrData = array();
			$arrImages = array();
			$arrCustomFields = array();

			if (GetConfig('CurrencyLocation') == 'right') {
				$GLOBALS['CurrencyTokenLeft'] = '';
				$GLOBALS['CurrencyTokenRight'] = GetConfig('CurrencyToken');
			} else {
				$GLOBALS['CurrencyTokenLeft'] = GetConfig('CurrencyToken');
				$GLOBALS['CurrencyTokenRight'] = '';
			}

			$GLOBALS['ServerFiles'] = $this->_GetImportFilesOptions();

			$GLOBALS['ISC_CLASS_ADMIN_CATEGORY'] = GetClass('ISC_ADMIN_CATEGORY');

			// Make sure the product exists
			if (ProductExists($prodId)) {

				if($PreservePost == true) {
					$this->_GetProductData(0, $arrData);
					$this->_GetCustomFieldData(0, $arrCustomFields);
					$GLOBALS['ProductFields'] = $this->_GetProductFieldsLayout(0, true);

					// Restore the hash
					$GLOBALS['ProductHash'] = $arrData['prodhash'];
				} else {
					$this->_GetProductData($prodId, $arrData);
					$this->_GetCustomFieldData($prodId, $arrCustomFields);
					$GLOBALS['ProductFields'] = $this->_GetProductFieldsLayout($prodId, true);

					// Generate the hash
					$GLOBALS['ProductHash'] = md5(time().uniqid(rand(), true));

					// We'll need to duplicate (copy) the thumbnail, images and download files here
					$this->_CopyProductImages($prodId, 0, $GLOBALS['ProductHash']);
					$this->_CopyDownloads($prodId, 0, $GLOBALS['ProductHash']);

					$arrData['prodname'] = GetLang('CopyOf') . $arrData['prodname'];
				}

				// Does this user have permission to edit this product?
				if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() && $arrData['prodvendorid'] != $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
					FlashMessage(GetLang('Unauthorized'), MSG_ERROR, 'index.php?ToDo=viewProducts');
				}

				$arrImages = $this->_GetImageData(0, $GLOBALS['ProductHash']);

				if(isset($_POST['currentTab'])) {
					$GLOBALS['CurrentTab'] = (int)$_POST['currentTab'];
				}
				else {
					$GLOBALS['CurrentTab'] = 0;
				}

				$GLOBALS['FormAction'] = 'copyProduct2';
				$GLOBALS['Title'] = GetLang('CopyProductTitle');
				$GLOBALS['Intro'] = GetLang('CopyProductIntro');
				$GLOBALS["ProdType_" . $arrData['prodtype']] = 'checked="checked"';
				$GLOBALS['ProdType'] = $arrData['prodtype'] - 1;
				$GLOBALS['ProdCode'] = isc_html_escape($arrData['prodcode']);
				$GLOBALS['ProdName'] = isc_html_escape($arrData['prodname']);
				$GLOBALS['OriginalProductId'] = $OriginalProductID;

				$visibleCategories = array();
				if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
					$vendorData = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendor();
					if($vendorData['vendoraccesscats']) {
						$visibleCategories = explode(',', $vendorData['vendoraccesscats']);
					}
				}
//				$GLOBALS['CategoryOptions'] = $GLOBALS['ISC_CLASS_ADMIN_CATEGORY']->GetCategoryOptions($arrData['prodcats'], "<option %s value='%d'>%s</option>", "selected='selected'", "", false, '', $visibleCategories);
                $GLOBALS['CategoryOptions'] = $GLOBALS['ISC_CLASS_ADMIN_CATEGORY']->GetCategoryOptionsProduct($arrData['prodcats'], "<option %s value='%d' id='category_old%d'>%s</option>", "selected='selected'", "", false, '', $visibleCategories);
				$GLOBALS['RelatedCategoryOptions'] = $GLOBALS['ISC_CLASS_ADMIN_CATEGORY']->GetCategoryOptions(0, "<option %s value='%d'>%s</option>", "selected='selected'", "- ", false);
//blessen
				$wysiwygOptions = array(
					'id'		=> 'wysiwyg',
					'width'		=> '60%',
					'height'	=> '350px',
					'value'		=> $arrData['proddesc']
				);

				$wysiwygOptions1 = array(
					'id'		=> 'wysiwyg1',
					'width'		=> '60%',
					'height'	=> '350px',
					'value'		=> $arrData['prodmfg']
				);

				$wysiwygOptions2 = array(
					'id'		=> 'wysiwyg2',
					'width'		=> '60%',
					'height'	=> '350px',
					'value'		=> $arrData['prodwarranty']
				);
				$GLOBALS['WYSIWYG'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor($wysiwygOptions);
				$GLOBALS['WYSIWYG1'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor1($wysiwygOptions1);
				$GLOBALS['WYSIWYG2'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor1($wysiwygOptions2);

				$GLOBALS['ProdSearchKeywords'] = isc_html_escape($arrData['prodsearchkeywords']);
				$GLOBALS['ProdAvailability'] = isc_html_escape($arrData['prodavailability']);
				$GLOBALS['ProdPrice'] = number_format($arrData['prodprice'], GetConfig('DecimalPlaces'), GetConfig('DecimalToken'), "");

				if (CFloat($arrData['prodcostprice']) > 0) {
					$GLOBALS['ProdCostPrice'] = number_format($arrData['prodcostprice'], GetConfig('DecimalPlaces'), GetConfig('DecimalToken'), "");
				}

				if (CFloat($arrData['prodretailprice']) > 0) {
					$GLOBALS['ProdRetailPrice'] = number_format($arrData['prodretailprice'], GetConfig('DecimalPlaces'), GetConfig('DecimalToken'), "");
				}

				if (CFloat($arrData['prodsaleprice']) > 0) {
					$GLOBALS['ProdSalePrice'] = number_format($arrData['prodsaleprice'], GetConfig('DecimalPlaces'), GetConfig('DecimalToken'), "");
				}

				$GLOBALS['ProdSortOrder'] = $arrData['prodsortorder'];

				if ($arrData['prodvisible'] == 1) {
					$GLOBALS['ProdVisible'] = "checked";
				}

				if ($arrData['prodfeatured'] == 1) {
					$GLOBALS['ProdFeatured'] = "checked";
				}

				if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
					$GLOBALS['HideStoreFeatured'] = 'display: none';
				}
				else if(!gzte11(ISC_HUGEPRINT) || !$arrData['prodvendorid']) {
					$GLOBALS['HideVendorFeatured'] = 'display: none';
				}

				if($arrData['prodvendorfeatured'] == 1) {
					$GLOBALS['ProdVendorFeatured'] = 'checked="checked"';
				}

				if($arrData['prodistaxable'] == 1) {
					$GLOBALS['ProdIsTaxable'] = 'checked';
				}

				if($arrData['prodallowpurchases'] == 1) {
					$GLOBALS['ProdAllowPurchases'] = 'checked="checked"';
				}
				else {
					if($arrData['prodhideprice'] == 1) {
						$GLOBALS['ProdHidePrice'] = 'checked="checked"';
					}
					$GLOBALS['ProdCallForPricingLabel'] = isc_html_escape($arrData['prodcallforpricinglabel']);
				}

				$GLOBALS['MoreImages'] = "MoreImages();";

				for ($i = 1; $i <= $arrImages['numImages']; $i++) {
					$image = sprintf("../%s/%s", GetConfig('ImageDirectory'), $arrImages["image" . $i]);

					if ($i == 1) {
						$GLOBALS["ImageMessage" . $i] = sprintf(GetLang('EditImageDesc'), $image, $arrImages["image" . $i]);
					} else {
						$GLOBALS["ImageMessage" . $i] = sprintf(GetLang('EditImageDesc2'), $arrImages["id" . $i], $arrImages["id" . $i], $arrImages["id" . $i], $image, $arrImages["image" . $i], $arrImages["id" . $i]);
					}
				}

				if(isset($arrImages['thumb'])) {
					$thumb = sprintf("../%s/%s", GetConfig('ImageDirectory'), $arrImages['thumb']);
					$GLOBALS['ThumbMessage'] = sprintf(GetLang('EditImageDesc'), $thumb, $arrImages['thumb']);
				}
//blessen
				
				//$GLOBALS['ProdWarranty'] = $arrData['prodwarranty'];
				//$GLOBALS['prod_instruction'] = $arrData['prod_instruction'];
				//$GLOBALS['prod_article'] = $arrData['prod_article'];

				$GLOBALS['ProdWeight'] = number_format($arrData['prodweight'], GetConfig('DecimalPlaces'), GetConfig('DecimalToken'), "");

				if (CFloat($arrData['prodwidth']) > 0) {
					$GLOBALS['ProdWidth'] = number_format($arrData['prodwidth'], GetConfig('DecimalPlaces'), GetConfig('DecimalToken'), "");
				}

				if (CFloat($arrData['prodheight']) > 0) {
					$GLOBALS['ProdHeight'] = number_format($arrData['prodheight'], GetConfig('DecimalPlaces'), GetConfig('DecimalToken'), "");
				}

				if (CFloat($arrData['proddepth']) > 0) {
					$GLOBALS['ProdDepth'] = number_format($arrData['proddepth'], GetConfig('DecimalPlaces'), GetConfig('DecimalToken'), "");
				}

				if (CFloat($arrData['prodfixedshippingcost']) > 0) {
					$GLOBALS['ProdFixedShippingCost'] = number_format($arrData['prodfixedshippingcost'], GetConfig('DecimalPlaces'), GetConfig('DecimalToken'), "");
				}

				if ($arrData['prodfreeshipping'] == 1) {
					$GLOBALS['FreeShipping'] = 'checked="checked"';
				}

				if($arrData['prodrelatedproducts'] == -1) {
					$GLOBALS['IsProdRelatedAuto'] = 'checked="checked"';
				}
				else if(isset($arrData['prodrelated'])) {
					$GLOBALS['RelatedProductOptions'] = "";

					foreach ($arrData['prodrelated'] as $r) {
						$GLOBALS['RelatedProductOptions'] .= sprintf("<option value='%d'>%s</option>", (int) $r[0], isc_html_escape($r[1]));
					}
				}

				$GLOBALS['ProdTags'] = $arrData['prodtags'];

				$GLOBALS['CurrentStockLevel'] = $arrData['prodcurrentinv'];
				$GLOBALS['LowStockLevel'] = $arrData['prodlowinv'];
				$GLOBALS["InvTrack_" . $arrData['prodinvtrack']] = 'checked="checked"';

				$GLOBALS['WrappingOptions'] = $this->BuildGiftWrappingSelect(explode(',', $arrData['prodwrapoptions']));
				$GLOBALS['HideGiftWrappingOptions'] = 'display: none';
				if($arrData['prodwrapoptions'] == 0) {
					$GLOBALS['WrappingOptionsDefaultChecked'] = 'checked="checked"';
				}
				else if($arrData['prodwrapoptions'] == -1) {
					$GLOBALS['WrappingOptionsNoneChecked'] = 'checked="checked"';
				}
				else {
					$GLOBALS['HideGiftWrappingOptions'] = '';
					$GLOBALS['WrappingOptionsCustomChecked'] = 'checked="checked"';
				}

				if ($arrData['prodinvtrack'] == 1) {
					$GLOBALS['OptionButtons'] = "ToggleProductInventoryOptions(true);";
				} else {
					$GLOBALS['OptionButtons'] = "ToggleProductInventoryOptions(false);";
				}

				if ($arrData['prodoptionsrequired'] == 1) {
					$GLOBALS['OptionsRequired'] = 'checked="checked"';
				}

				if ($arrData['prodtype'] == 1) {
					$GLOBALS['HideProductInventoryOptions'] = "none";
				}

				$GLOBALS['EnterOptionPrice'] = sprintf(GetLang('EnterOptionPrice'), GetConfig('CurrencyToken'), GetConfig('CurrencyToken'));
				$GLOBALS['EnterOptionWeight'] = sprintf(GetLang('EnterOptionWeight'), GetConfig('WeightMeasurement'));
				$GLOBALS['HideCustomFieldLink'] = "none";

				if (GetConfig('PricesIncludeTax')) {
					$GLOBALS['PriceMsg'] = GetLang('IncTax');
				} else {
					$GLOBALS['PriceMsg'] = GetLang('ExTax');
				}

				$GLOBALS['CustomFields'] = '';
				$GLOBALS['CustomFieldKey'] = 0;

				if (!empty($arrCustomFields)) {
					foreach ($arrCustomFields as $f) {
						$GLOBALS['CustomFieldName'] = isc_html_escape($f['name']);
						$GLOBALS['CustomFieldValue'] = isc_html_escape($f['value']);
						$GLOBALS['CustomFieldLabel'] = $this->GetFieldLabel(($GLOBALS['CustomFieldKey']+1), GetLang('CustomField'));

						if (!$GLOBALS['CustomFieldKey']) {
							$GLOBALS['HideCustomFieldDelete'] = 'none';
						} else {
							$GLOBALS['HideCustomFieldDelete'] = '';
						}

						$GLOBALS['CustomFields'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('CustomFields');

						$GLOBALS['CustomFieldKey']++;
					}
				}

				// Add one more custom field
				$GLOBALS['CustomFieldName'] = '';
				$GLOBALS['CustomFieldValue'] = '';
				$GLOBALS['CustomFieldLabel'] = $this->GetFieldLabel(($GLOBALS['CustomFieldKey']+1), GetLang('CustomField'));

				if (!$GLOBALS['CustomFieldKey']) {
					$GLOBALS['HideCustomFieldDelete'] = 'none';
				} else {
					$GLOBALS['HideCustomFieldDelete'] = '';
				}

				$GLOBALS['CustomFields'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('CustomFields');

				if ($this->HasGD()) {
					$GLOBALS['ShowGDThumb'] = "";
					$GLOBALS['ShowNoGDThumb'] = "none";
				} else {
					$GLOBALS['ShowGDThumb'] = "none";
					$GLOBALS['ShowNoGDThumb'] = "";
				}

				// Get a list of any downloads associated with this product
				$GLOBALS['DownloadsGrid'] = $this->GetDownloadsGrid(0, $GLOBALS['ProductHash']);
				$GLOBALS['ISC_LANG']['MaxUploadSize'] = sprintf(GetLang('MaxUploadSize'), GetMaxUploadSize());
				if($GLOBALS['DownloadsGrid'] == '') {
					$GLOBALS['DisplayDownloaadGrid'] = "none";
				}

				// Get the brands as select options
				$GLOBALS['ISC_CLASS_ADMIN_BRANDS'] = GetClass('ISC_ADMIN_BRANDS');
				$GLOBALS['BrandNameOptions'] = $GLOBALS['ISC_CLASS_ADMIN_BRANDS']->GetBrandsAsOptions($arrData['prodbrandid']);
				$GLOBALS['SaveAndAddAnother'] = GetLang('SaveAndAddAnother');

				// Get a list of all layout files
				$layoutFile = 'product.html';
				if($arrData['prodlayoutfile'] != '') {
					$layoutFile = $arrData['prodlayoutfile'];
				}
				$GLOBALS['LayoutFiles'] = GetCustomLayoutFilesAsOptions("product.html", $layoutFile);

				$GLOBALS['ProdPageTitle'] = isc_html_escape($arrData['prodpagetitle']);
				$GLOBALS['ProdMetaKeywords'] = isc_html_escape($arrData['prodmetakeywords']);
				$GLOBALS['ProdMetaDesc'] = isc_html_escape($arrData['prodmetadesc']);
				$GLOBALS['SaveAndAddAnother'] = GetLang('SaveAndAddAnother');

				if(!gzte11(ISC_MEDIUMPRINT)) {
					$GLOBALS['HideInventoryOptions'] = "none";
				}
				else {
					$GLOBALS['HideInventoryOptions'] = '';
				}

				// Does this product have a variation assigned to it?
				$GLOBALS['ProductVariationExisting'] = $arrData['prodvariationid'];

				if($arrData['prodvariationid'] > 0) {
					$GLOBALS['IsYesVariation'] = 'checked="checked"';
				}
				else {
					$GLOBALS['IsNoVariation'] = 'checked="checked"';
					$GLOBALS['HideVariationList'] = "none";
					$GLOBALS['HideVariationCombinationList'] = "none";
				}

				// If there are no variations then disable the option to choose one
				$numVariations = 0;
				$GLOBALS['VariationOptions'] = $this->GetVariationsAsOptions($numVariations, $arrData['prodvariationid']);

				if($numVariations == 0) {
					$GLOBALS['VariationDisabled'] = "DISABLED";
					$GLOBALS['VariationColor'] = "#CACACA";
					$GLOBALS['IsNoVariation'] = 'checked="checked"';
					$GLOBALS['IsYesVariation'] = "";
					$GLOBALS['HideVariationCombinationList'] = "none";
				}
				else {
					// Load the variation combinations
					if($arrData['prodinvtrack'] == 2) {
						$show_inv_fields = true;
					}
					else {
						$show_inv_fields = false;
					}

					/**
					 * We'll need to duplicate the variation combinations here if we are NOT preserving the post
					 */
					if (!$PreservePost) {
						$this->_CopyVariationData($arrData['productid'], 0, $GLOBALS['ProductHash']);
					}

					$GLOBALS['VariationCombinationList'] = $this->_LoadVariationCombinationsTable($arrData['prodvariationid'], $show_inv_fields, 0, $GLOBALS['ProductHash']);
				}

				if(!gzte11(ISC_HUGEPRINT)) {
					$GLOBALS['HideVendorOption'] = 'display: none';
				}
				else {
					$vendorData = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendor();
					if(isset($vendorData['vendorid'])) {
						$GLOBALS['HideVendorSelect'] = 'display: none';
						$GLOBALS['CurrentVendor'] = isc_html_escape($vendorData['vendorname']);
					}
					else {
						$GLOBALS['HideVendorLabel'] = 'display: none';
						$GLOBALS['VendorList'] = $this->BuildVendorSelect($arrData['prodvendorid']);
					}
				}

				// Display the discount rules
				if ($PreservePost == true) {
					$GLOBALS['DiscountRules'] = $this->GetDiscountRules($prodId);
				} else {
					$GLOBALS['DiscountRules'] = $this->GetDiscountRules(0);
				}

				// Hide if we are not enabled
				if (!GetConfig('BulkDiscountEnabled')) {
					$GLOBALS['HideDiscountRulesWarningBox'] = '';
					$GLOBALS['DiscountRulesWarningText'] = GetLang('DiscountRulesNotEnabledWarning');
					$GLOBALS['DiscountRulesWithWarning'] = 'none';

				// Also hide it if this product has variations
				} else if (isset($arrData['prodvariationid']) && isId($arrData['prodvariationid'])) {
					$GLOBALS['HideDiscountRulesWarningBox'] = '';
					$GLOBALS['DiscountRulesWarningText'] = GetLang('DiscountRulesVariationWarning');
					$GLOBALS['DiscountRulesWithWarning'] = 'none';
				} else {
					$GLOBALS['HideDiscountRulesWarningBox'] = 'none';
					$GLOBALS['DiscountRulesWithWarning'] = '';
				}

				$GLOBALS['DiscountRulesEnabled'] = (int)GetConfig('BulkDiscountEnabled');

				$GLOBALS['EventDateFieldName'] = $arrData['prodeventdatefieldname'];

				if ($GLOBALS['EventDateFieldName'] == null) {
					$GLOBALS['EventDateFieldName'] = GetLang('EventDateDefault');
				}

				if ($arrData['prodeventdaterequired'] == 1) {
					$GLOBALS['EventDateRequired'] = 'checked="checked"';
					$from_stamp = $arrData['prodeventdatelimitedstartdate'];
					$to_stamp = $arrData['prodeventdatelimitedenddate'];
				} else {
					$from_stamp = isc_gmmktime(0, 0, 0, isc_date("m"), isc_date("d"), isc_date("Y"));
					$to_stamp = isc_gmmktime(0, 0, 0, isc_date("m")+1, isc_date("d"), isc_date("Y"));
				}
				if ($arrData['prodeventdatelimited'] == 1) {
					$GLOBALS['LimitDates'] = 'checked="checked"';
				}

				$GLOBALS['LimitDateOption1'] = '';
				$GLOBALS['LimitDateOption2'] = '';
				$GLOBALS['LimitDateOption3'] = '';

				switch ($arrData['prodeventdatelimitedtype']) {

					case 1 :
						$GLOBALS['LimitDateOption1'] = 'selected="selected"';
					break;
					case 2 :
						$GLOBALS['LimitDateOption2'] = 'selected="selected"';
					break;
					case 3 :
						$GLOBALS['LimitDateOption3'] = 'selected="selected"';
					break;
				}

				// Set the global variables for the select boxes

				$from_day = isc_date("d", $from_stamp);
				$from_month = isc_date("m", $from_stamp);
				$from_year = isc_date("Y", $from_stamp);

				$to_day = isc_date("d", $to_stamp);
				$to_month = isc_date("m", $to_stamp);
				$to_year = isc_date("Y", $to_stamp);

				$GLOBALS['OverviewFromDays'] = $this->_GetDayOptions($from_day);
				$GLOBALS['OverviewFromMonths'] = $this->_GetMonthOptions($from_month);
				$GLOBALS['OverviewFromYears'] = $this->_GetYearOptions($from_year);

				$GLOBALS['OverviewToDays'] = $this->_GetDayOptions($to_day);
				$GLOBALS['OverviewToMonths'] = $this->_GetMonthOptions($to_month);
				$GLOBALS['OverviewToYears'] = $this->_GetYearOptions($to_year);

				if(!$GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Create_Category)) {
					$GLOBALS['HideCategoryCreation'] = 'display: none';
				}

				$GLOBALS['SaveAndAddAnother'] = GetLang('SaveAndAddAnother');
				$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("product.form");
				$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
			} else {
				// The product doesn't exist
				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Products)) {
					$this->ManageProducts(GetLang('ProductDoesntExist'), MSG_ERROR);
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
				}
			}
		}


		/**
		* get the variation image paths for a product
		* @param int $prodId
		*
		* return array array of variation images.
		*/
		public function _LoadVariationImages($prodId)
		{
			$varImages = array();
			$query = "SELECT vcoptionids, vcimage, vcthumb FROM [|PREFIX|]product_variation_combinations WHERE vcproductid='".$prodId."'";
			$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);

			// Are there any option details?
			while($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
				$varImages[$row['vcoptionids']] = array(
														'vcimage' => $row['vcimage'],
														'vcthumb' => $row['vcthumb']
													);
			}
			return $varImages;
		}


		/**
		* copy a product image to another random directory
		*
		* @param string $imagePath, the path to the origin image
		*
		* return string path to the new image
		*/
		public function _CopyImages($imagePath)
		{
			//check if the original file exist
			if (!file_exists($imagePath)) {
				return '';
			}

			$dir = GetConfig('ImageDirectory');
			$dest = realpath(ISC_BASE_PATH."/" . $dir);

			$randomDir = strtolower(chr(rand(65, 90)));
			if(!is_dir("../".$dir."/".$randomDir)) {
				if(!@mkdir("../".$dir."/".$randomDir, 0777)) {
					$randomDir = '';
				}
			}

			$fileName = preg_replace('/^.*\//', '', $imagePath);

			//check is filename exsits in the dest directory, rename file name if exsits
			if (file_exists($dest.$randomDir.'/'.$fileName)) {
				$fileName = basename($randomFileName);
				$fileName = substr_replace($randomFileName, "-".rand(0, 10000000000), strrpos($randomFileName, "."), 0);
			}
			$newPath = $dest.'/'.$randomDir.'/'.$fileName;

			//cppy file to new directory
			if (copy($imagePath, $newPath)) {
				return $randomDir.'/'.$fileName;
			} else {
				return '';
			}
		}

		/**
		 * Copy the product images
		 *
		 * Method will copy the existing product images for the product $fromProdctId
		 *
		 * @access public
		 * @param int $fromProdctId The product to copy images from
		 * @param int $toProductId The optional product to copy the images to
		 * @param string $toProductHash The optional product hash to copy the images to
		 * @return void
		 */
		public function _CopyProductImages($fromProdctId, $toProductId=0, $toProductHash='')
		{
			$total = 0;
			$imgDir = realpath(ISC_BASE_PATH."/" . GetConfig('ImageDirectory'));
			$result = $GLOBALS['ISC_CLASS_DB']->Query("SELECT * FROM [|PREFIX|]product_images WHERE imageprodid='" . $GLOBALS['ISC_CLASS_DB']->Quote($fromProdctId) . "'");

			while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {

				if (($imgfile = $this->_CopyImages($imgDir . '/' . $row['imagefile'])) == '') {
					continue;
				}

				$newImage = array(
					"imagefile" => $imgfile,
					"imageisthumb" => (int)$row['imageisthumb'],
					"imagesort" => (int)$row['imagesort'],
				);

				if (isId($toProductId)) {
					$newImage['imageprodid'] = $toProductId;
					$newImage['imageprodhash'] = '';
				} else {
					$newImage['imageprodid'] = '0';
					$newImage['imageprodhash'] = $toProductHash;
				}

				if ($GLOBALS['ISC_CLASS_DB']->InsertQuery("product_images", $newImage)) {
					$total++;
				}
			}
		}

		public function _CopyDownloads($fromProdctId, $toProductId=0, $toProductHash='')
		{
			$total = 0;
			$imgDir = realpath(ISC_BASE_PATH."/" . GetConfig('DownloadDirectory'));
			$result = $GLOBALS['ISC_CLASS_DB']->Query("SELECT * FROM [|PREFIX|]product_downloads WHERE productid='" . $GLOBALS['ISC_CLASS_DB']->Quote($fromProdctId) . "'");

			while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {

				if (($downfile = $this->_CopyImages($imgDir . '/' . $row['downfile'])) == '') {
					continue;
				}

				$newDownload = array(
					"downfile" => $downfile,
					"downdateadded" => time(),
					"downmaxdownloads" => (int)$row['downmaxdownloads'],
					"downexpiresafter" => (int)$row['downexpiresafter'],
					"downname" => $row['downname'],
					"downfilesize" => (int)$row['downfilesize'],
					"downdescription" => $row['downdescription']
				);

				if (isId($toProductId)) {
					$newDownload['productid'] = $toProductId;
					$newDownload['prodhash'] = '';
				} else {
					$newDownload['productid'] = '0';
					$newDownload['prodhash'] = $toProductHash;
				}

				if ($GLOBALS['ISC_CLASS_DB']->InsertQuery("product_downloads", $newDownload)) {
					$total++;
				}
			}

			return $total;
		}

		/**
		 * Build a list of vendors that can be chosen for a product.
		 *
		 * @param int The vendor ID to select, if any.
		 * @return string The HTML options for the select box of vendors.
		 */
		private function BuildVendorSelect($selectedVendor=0)
		{
			$options = '<option value="0">'.GetLang('ProductNoVendor').'</option>';
			$query = "
				SELECT vendorid, vendorname
				FROM [|PREFIX|]vendors
				ORDER BY vendorname ASC
			";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			while($vendor = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$sel = '';
				if($selectedVendor == $vendor['vendorid']) {
					$sel = 'selected="selected"';
				}
				$options .= '<option value='.(int)$vendor['vendorid'].' '.$sel.'>'.isc_html_escape($vendor['vendorname']).'</option>';
			}
			return $options;
		}

		/**
		 * Build a list of gift wrapping options to select per product.
		 *
		 * @param array An array of gift wrapping options that should be selected.
		 * @return string The HTML options for the select box of gift wrapping options.
		 */
		private function BuildGiftWrappingSelect($selected=array())
		{
			$query = "
				SELECT wrapname, wrapprice, wrapid
				FROM [|PREFIX|]gift_wrapping
				ORDER BY wrapname ASC
			";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$options = '';
			while($wrap = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$sel = '';
				if(in_array($wrap['wrapid'], $selected)) {
					$sel = 'selected="selected"';
				}
				$options .= '<option value='.(int)$wrap['wrapid'].' '.$sel.'>'.isc_html_escape($wrap['wrapname']).'</option>';
			}
			return $options;
		}

		/**
		 * Save the tags a product has been tagged with in the database.
		 *
		 * @param string A CSV list of tags to be associated with the product.
		 * @param int The product ID to associate the tags with.
		 * @param boolean True if this is a new product, false if not (new products mean we don't need to delete existing tags etc)
		 * @return boolean True if successful, false if not.
		 */
		public function SaveProductTags($tags, $productId, $newProduct=false)
		{
			// Split up the tags and make them unique
			$tags = explode(',', $tags);
			foreach($tags as $k => $tag) {
				if(!trim($tag) || isc_strlen($tag) == 2) {
					unset($tags[$k]);
					continue;
				}
				$tags[$k] = trim($tags[$k]);
			}

			// No tags & away we go!
			if($newProduct && empty($tags)) {
				return false;
			}

			$uniqueTags = array_unique(array_map('isc_strtolower', $tags));
			$tagList = array();
			foreach(array_keys($uniqueTags) as $k) {
				$tagList[] = trim($tags[$k]);
			}
			$uniqueTags = array_values($uniqueTags);

			// Get a list of the tags that this product already has
			$existingTags = array();
			$productTagIds = array();

			if($newProduct == false) {
				$query = "
					SELECT a.tagid, t.tagname, t.tagcount
					FROM [|PREFIX|]product_tagassociations a
					INNER JOIN [|PREFIX|]product_tags t ON (t.tagid=a.tagid)
					WHERE a.productid='".(int)$productId."'
				";
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				while($tag = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					$existingTags[$tag['tagid']] = $tag;
				}
			}

			// Now attempt to establish which of these tags already exist and which we need to create
			$query = "
				SELECT tagid, tagname
				FROM [|PREFIX|]product_tags
				WHERE LOWER(tagname) IN ('".implode("','", array_map(array($GLOBALS['ISC_CLASS_DB'], 'Quote'), $tagList))."')
			";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			while($tag = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				// This tag exists but the product doesn't have it already, so we need to tag it
				$productTagIds[] = $tag['tagid'];

				if(!isset($existingTags[$tag['tagid']])) {
					$tagsToMark[] = $tag['tagid'];
				}

				// Remove the tag from the list of what we need to create
				$keyId = array_search(strtolower($tag['tagname']), $uniqueTags);
				if($keyId !== false) {
					unset($tagList[$keyId], $uniqueTags[$keyId]);
				}
			}

			// What's left in the array is now what we need to create, so go ahead and create those tags
			foreach($tagList as $tag) {
				$tagId = $this->CreateProductTag($tag);
				$productTagIds[] = $tagId;
				$tagsToMark[] = $tagId;
			}

			// Update the tag count for all of the tags - so now that current + 1 products have this tag
			if(!empty($tagsToMark)) {
				$query = "
					UPDATE [|PREFIX|]product_tags
					SET tagcount=tagcount+1
					WHERE tagid IN (".implode(',', $tagsToMark).")
				";
				$GLOBALS['ISC_CLASS_DB']->Query($query);
			}

			// Now delete any tag associations
			if($newProduct == false) {
				$deletedTags = array_diff(array_keys($existingTags), $productTagIds);
				if(!empty($deletedTags)) {
					$GLOBALS['ISC_CLASS_DB']->DeleteQuery('product_tagassociations', "WHERE tagid IN (".implode(',', $deletedTags).") AND productid='".(int)$productId."'");

					// Delete any existing tags where they were only previously associated with one product, as now they're associated with 0
					$GLOBALS['ISC_CLASS_DB']->DeleteQuery('product_tags', "WHERE tagid IN (".implode(',', $deletedTags).") AND tagcount=1");

					$query = "
						UPDATE [|PREFIX|]product_tags
						SET tagcount=tagcount-1
						WHERE tagid IN (".implode(',', $deletedTags).")
					";
					$GLOBALS['ISC_CLASS_DB']->Query($query);
				}
			}

			// And finally, insert all of the new tag associations
			$insertValues = '';
			if(!empty($tagsToMark)) {
				foreach($tagsToMark as $tagId) {
					$insertValues .= "('".$tagId."', '".$productId."'), ";
				}
				$insertValues = rtrim($insertValues, ', ');
				$GLOBALS['ISC_CLASS_DB']->Query("
					INSERT INTO [|PREFIX|]product_tagassociations
					(tagid, productid)
					VALUES
					".$insertValues
				);
			}

			return true;
		}

		/**
		 * Create a product tag with a unique "friendly name" in the database.
		 *
		 * @param string The name of the tag to create.
		 * @return int The ID of the tag we've just created.
		 */
		private function CreateProductTag($tag)
		{
			$friendlyName = isc_strtolower(trim($tag));
			$friendlyName = preg_replace("#\s#", "-", $friendlyName);
			$friendlyName = preg_replace("#([^a-zA-Z0-9-_])#", "", $friendlyName);
			$friendlyName = preg_replace("#\-{2,}#", '', $friendlyName);

			// If a friendly name couldn't be generated then we store the tag ID as the friendly name.
			if(!$friendlyName) {
				$newTag = array(
					'tagname' => $tag
				);
				$tagId = $GLOBALS['ISC_CLASS_DB']->InsertQuery('product_tags', $newTag);
				$updatedTag = array(
					'tagfriendlyname' => $tagId
				);
				$GLOBALS['ISC_CLASS_DB']->UpdateQuery('product_tags', $updatedTag, "tagid='".(int)$tagId."'");
				return $tagId;
			}
			// Otherwise, generate a friendly ID
			else {
				$friendlyCount = 0;
				$currentFriendlyName = $friendlyName;
				do {
					$query = "
						SELECT tagid
						FROM [|PREFIX|]product_tags
						WHERE tagfriendlyname='".$GLOBALS['ISC_CLASS_DB']->Quote($currentFriendlyName)."'
					";
					$exists = $GLOBALS['ISC_CLASS_DB']->FetchOne($query);
					if($exists) {
						++$friendlyCount;
						$currentFriendlyName = $friendlyName.$friendlyCount;
					}
					// Found a place, insert and then get out asap!
					else {
						$newTag = array(
							'tagname' => $tag,
							'tagfriendlyname' => $currentFriendlyName
						);
						$tagId = $GLOBALS['ISC_CLASS_DB']->InsertQuery('product_tags', $newTag);
						return $tagId;
					}
				} while($exists);
			}
		}

		/*Baskaran Added Starts*/
		/**
         * Build a list of variation that can be chosen for a product.
         *
         * @param int The product ID to select, if any.
         * @return string The HTML options for the select box of vendors.
         */
        private function BuildProductVariation($selectedProduct=0,$pid)
        {
            $options = '<option value="0">'.GetLang('SelectProduct').'</option>';
            $query = "
                SELECT id, prodmodel
                FROM [|PREFIX|]import_variations where productid = '$pid'
                ORDER BY id ASC
            ";
            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
            while($vproduct = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                $sel = '';
                if($selectedProduct == $vproduct['id']) {
                    $sel = 'selected="selected"';
                }
                $options .= '<option value='.(int)$vproduct['id'].' '.$sel.'>'.$vproduct['id'].'</option>';
            }
            return $options;
        }
        
        private function importvaritaion($prodId) {
            $query = "select * from [|PREFIX|]import_variations where productid = '$prodId'";
            $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);    
            $variation = '';
            while($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
                $variation[] = $row;
            }
            return $variation;      
        }

		private function applicationdata($prodId) {
            $query = "select * from [|PREFIX|]application_data where productid = '$prodId'";
            $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);    
            $variation = '';
            while($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
                $variation[] = $row;
            }
            return $variation;      
        }


        private function Seriesname($selectedBrand=0,$selectedSeries=0)
        {
            $options = '';
            $query = "SELECT * FROM [|PREFIX|]brand_series where brandid = '$selectedBrand' ORDER BY seriesname ASC";
            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
            while($series = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                $sel = '';
                if($selectedSeries == $series['seriesid']) {
                    $sel = 'selected="selected"';
                }
                $options .= '<option value='.(int)$series['seriesid'].' '.$sel.'>'.isc_html_escape($series['seriesname']).'</option>';
            }
            return $options;
        }

		/* Baskaran Added Ends*/
        
        ###Added by Simha
        
        private function DownloadVideo($url, $FileType=FT_VIDEO){
            include(ISC_BASE_PATH . "/livevideos/phptube.php");
            include(ISC_BASE_PATH . "/livevideos/functions.php");    
            @clearstatcache();
            @ini_set('output_buffering','off'); // output buffer fix
            @ini_set('max_execution_time',0); // time limit fix 
            @ini_set('memory_limit', '1024M'); // memory problem fix
            //error_reporting(1);
            @ignore_user_abort(1);
            @set_time_limit(0);
            //@ob_end_clean();
            @ob_implicit_flush(TRUE);
            
             
            $pattern = getPatternFromUrl($url);
                        
            if ($FileType == FT_INSVIDEO) {
                $dir = GetConfig('InstallVideoDirectory');
            }
            else {
                $dir = GetConfig('VideoDirectory');
            }         
            
            if (is_dir(sprintf("../%s", $dir))) {
                // Images and downloads will be stored within a directory randomly chosen from a-z.
                $randomDir = strtolower(chr(rand(65, 90)));
                if(!is_dir("../".$dir."/".$randomDir)) {
                    if(!@mkdir("../".$dir."/".$randomDir, 0777)) {
                        $randomDir = '';
                    }
                }
            }
            
            $patternName = $pattern.".flv"; 
            //
            
            $randomFileName = GenRandFileName($patternName);
            $fileName = $randomDir . "/" . $randomFileName;
            $dest = realpath(ISC_BASE_PATH."/" . $dir);
            while(file_exists($dest."/".$fileName)) {
                $fileName = basename($randomFileName);
                $fileName = substr_replace($randomFileName, "-".rand(0, 10000000000), strrpos($randomFileName, "."), 0);
                $fileName = $randomDir . "/" . $fileName;
            }
            $dest .= "/".$fileName;
            
            $tube = new PHPTube ();
            $flv_http_path = $tube->download($pattern);   
            $data = file_get_contents($flv_http_path);   
            file_put_contents($dest, $data);  
            return $fileName; 
            if(filesize($dest)>0)    {
                return $fileName;
            }
            else    {
                return "failed";
            }  
        } 
        
        //Get Youtube URL in desired format
        public function FormatLink($link, $format='0') {
            $isyoutube = strrpos($link, "youtube");
            if($isyoutube === false)    {
                 return $status = "invalid";
            }
            else    {
                $str_pos = strrpos($link, "/v/");
                if($str_pos !==false)    {
                      $you_code = substr($link, $str_pos+3, 11);
                }  
                else    {
                    $str_pos  = strrpos($link, "?v=");
                    $you_code = substr($link, $str_pos+3, 11);
                } 
                if(strlen($you_code)==11)    {
                    if($format=='0')    {                                        
                        $you_link = 'http://www.youtube.com/v/'.$you_code;
                    }
                    else    {
                        $you_link = 'http://www.youtube.com/watch?v='.$you_code;
                    }
                    return $you_link;
                }
                else    {
                    return $status = "invalid";
                }
            } 
        } 
                
        public function fileConversion($fileName, $FileType)   {  
            
            
            if ($FileType == FT_INSVIDEO) {
                $dir = GetConfig('InstallVideoDirectory');
            }
            else {
                $dir = GetConfig('VideoDirectory');
            }         
            
            $SOURCE_VIDEO_PATH      = ISC_BASE_PATH."/".$dir;           
            
            $desFileName            = substr_replace($fileName, ".flv", strrpos($fileName, "."));     
            $sourceFile             = $SOURCE_VIDEO_PATH."/".$fileName;  
            $changed                = $SOURCE_VIDEO_PATH."/".$desFileName;
            
            if($fileName == $desFileName)    {
                 return $fileName;
            }
                    
            $original               = $this->get_vid_dim($sourceFile);
            
            if(!empty($original['width']) && !empty($original['height']))
            {
                $target = $this->get_dimensions($original['width'],$original['height'],640,480,true);
                        
                $command = '/usr/bin/ffmpeg -i ' . $sourceFile . ' -ab 96k -b 128k -ar 44100 -s ' . $target['width'] . 'x' . $target['height'];
                $command .= (!empty($target['padtop']) ? ' -padtop ' . $target['padtop'] : '');
                $command .= (!empty($target['padbottom']) ? ' -padbottom ' . $target['padbottom'] : '');
                $command .= (!empty($target['padleft']) ? ' -padleft ' . $target['padleft'] : '');
                $command .= (!empty($target['padright']) ? ' -padright ' . $target['padright'] : '');
                $command .= ' '.$changed.' 2>&1';

                exec($command,$output,$status);
                
                if($status == 0 || $status == 1)
                {
                    // Success    
                    //echo 'Woohoo!';
                    return $desFileName;
                }
                else
                {
                    // Error.  $output has the details
                    //echo '<pre>',join('\n',$output),'</pre>';
                    return $fileName;    
                }
            }
            
        }
        
        public function get_vid_dim($file)
        {
            $command = '/usr/bin/ffmpeg -i ' . escapeshellarg($file) . ' 2>&1';
            
            $dimensions = array();
            exec($command,$output,$status);  
             
            if (!preg_match('/Stream #(?:[0-9\.]+)(?:.*)\: Video: (?P<videocodec>.*) (?P<width>[0-9]*)x(?P<height>[0-9]*)/',implode('\n',$output),$matches))
            {
                preg_match('/Could not find codec parameters \(Video: (?P<videocodec>.*) (?P<width>[0-9]*)x(?P<height>[0-9]*)\)/',implode('\n',$output),$matches);
            }
            if(!empty($matches['width']) && !empty($matches['height']))
            {
                $dimensions['width'] = $matches['width'];
                $dimensions['height'] = $matches['height'];
            }
            return $dimensions;
        }
        
        public function get_dimensions($original_width,$original_height,$target_width,$target_height,$force_aspect)
        {
            if(!isset($force_aspect))
            {
                $force_aspect = true;
            }
            // Array to be returned by this function
            $target = array();
            // Target aspect ratio (width / height)
            $aspect = $target_width / $target_height;
            // Target reciprocal aspect ratio (height / width)
            $raspect = $target_height / $target_width;

            if($original_width/$original_height !== $aspect)
            {
                // Aspect ratio is different
                if($original_width/$original_height > $aspect)
                {
                        // Width is the greater of the two dimensions relative to the target dimensions
                        if($original_width < $target_width)
                        {
                                // Original video is smaller.  Scale down dimensions for conversion
                                $target_width = $original_width;
                                $target_height = round($raspect * $target_width);
                        }
                        // Calculate height from width
                        $original_height = round($original_height / $original_width * $target_width);
                        $original_width = $target_width;
                        if($force_aspect)
                        {
                                // Pad top and bottom
                                $dif = round(($target_height - $original_height) / 2);
                                $target['padtop'] = $dif;
                                $target['padbottom'] = $dif;
                        }
                }
                else
                {
                        // Height is the greater of the two dimensions relative to the target dimensions
                        if($original_height < $target_height)
                        {
                                // Original video is smaller.  Scale down dimensions for conversion
                                $target_height = $original_height;
                                $target_width = round($aspect * $target_height);
                        }
                        //Calculate width from height
                        $original_width = round($original_width / $original_height * $target_height);
                        $original_height = $target_height;
                        if($force_aspect)
                        {
                                // Pad left and right
                                $dif = round(($target_width - $original_width) / 2);
                                $target['padleft'] = $dif;
                                $target['padright'] = $dif;
                        }
                }
            }
            else
            {
                // The aspect ratio is the same
                if($original_width !== $target_width)
                {
                        if($original_width < $target_width)
                        {
                                // The original video is smaller.  Use its resolution for conversion
                                $target_width = $original_width;
                                $target_height = $original_height;
                        }
                        else
                        {
                                // The original video is larger,  Use the target dimensions for conversion
                                $original_width = $target_width;
                                $original_height = $target_height;
                        }
                }
            }
            
            $target['width'] = $original_width;
            $target['height'] = $original_height;
            
            return $target;
        }  
         
        public function DeleteSearchResults()   {
             $SearchKey         = trim(@$_SESSION['SesDelIdentity']);  
             $curkey            = trim($_GET['DelIdentity']);
             $productsCount     = @$_SESSION['productsCount'];
             $DelProductsCount  = $_GET['DelProductsCount'];
             
             if(($SearchKey != $curkey) || ($DelProductsCount != $productsCount))   {
                $this->ManageProducts();
                return '';
             }
             
             /*
             $SubQuery  = "SELECT p.productid FROM [|PREFIX|]products p 
                             LEFT JOIN [|PREFIX|]product_images t ON (t.imageisthumb='2' and t.imageprodid=p.productid) 
                             INNER JOIN [|PREFIX|]product_search ps ON p.productid=ps.productid    
                             WHERE 
                             ";
            
            $fulltext_fields = array("ps.prodname", "ps.prodcode");
            $queryWhere  = "(" . $GLOBALS["ISC_CLASS_DB"]->FullText($fulltext_fields, $SearchKey, true);
            $queryWhere .= "OR lower(ps.prodname) like '%" . $GLOBALS['ISC_CLASS_DB']->Quote($SearchKey) . "%' ";
            $queryWhere .= "OR lower(ps.prodcode) = '" . $GLOBALS['ISC_CLASS_DB']->Quote($SearchKey) . "' ";
            $queryWhere .= "OR p.productid='" . (int)$SearchKey . "')";  
            */
            
            //Get Product ids to be deleted                         
            $query          = $_SESSION['delQuery']; 
            $result         = $GLOBALS["ISC_CLASS_DB"]->Query($query);
            $prodids        = array();
            while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {  
                 //
                 $prodids[]  = $row['productid']; 
            }
            
            if(count($prodids)!= $productsCount)    {
                 $this->ManageProducts();
                 return '';
            }

            if(!$this->DoDeleteProducts($prodids)) {
                $err = $GLOBALS["ISC_CLASS_DB"]->GetErrorMsg();
                $this->ManageProducts($err, MSG_ERROR);
            }
            else {
                // Log this action
                $GLOBALS['ISC_CLASS_LOG']->LogAdminAction(count($prodids));     
                $this->ManageProducts(GetLang('ProductsDeletedSuccessfully'), MSG_SUCCESS);
            }
            
            /*
            $prodids = implode(",", $prodids);

            $query_del = "DELETE from [|PREFIX|]products where productid IN ($prodids)";
            $result_app = $GLOBALS["ISC_CLASS_DB"]->Query($query_del);     
            */
            //$this->ManageProducts(GetLang('ProductsDeletedSuccessfully'), MSG_SUCCESS);
            
        }
        
        public function MakeChangesReport($ProductId, $Data, $impData, $ImportContentData)  {
             
            $isPriceChanged         = 0;
            $isApplicationChanged   = 0;  
            $isContentChanged       = 0; 
            $Data['productid'] = (int)$ProductId;
            //For Content report in product change report    
            $ContentArray = $Data;   
            
            unset($ContentArray['prodprice'], $ContentArray['price_log'], $ContentArray['price_update_time'], $ContentArray['SKU_last_update_time']);
            
            unset($ContentArray['prodhash'], $ContentArray['prodcats'], $ContentArray['productVariationExisting'], $ContentArray['prodtags']);    //Not in product table 

            foreach($ContentArray as $key => $value)   { 
                $ContentColumns .= $key.","; 
            }                 
            
            $ContentColumns = trim($ContentColumns, ",");
            
            $query_cont = "select $ContentColumns from [|PREFIX|]products where productid ='$ProductId'";
            $result_cont = $GLOBALS["ISC_CLASS_DB"]->Query($query_cont);
            while ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result_cont)) {   
                $prevcontent = $row;
            }
            
            if($ContentArray != $prevcontent)   {
                 $isContentChanged = 1;
            }
            
            //For Content report in product change report  Ends
            
            //For Price report in product change report
            
            $query_price = "select prodprice from [|PREFIX|]products where productid ='$ProductId'";
            $result_price = $GLOBALS["ISC_CLASS_DB"]->Query($query_price);
            while ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result_price)) {   
                $prevprice = $row['prodprice'];
            }
            if($prevprice != $Data['prodprice'])    {
                $isPriceChanged = 1;
            }                                                      
            //For Price report in product change report  Ends 
            
            /**
            * @desc For Import variation table 
            * To find content and the application changes
            */
                                                                  
            if($_POST['hdnname'] == 'hdnsave') {
                
                $id = $_POST['editproduct'];  
                
                //For Application report in product change report  
                $newapplication = $impData;
                
                unset($newapplication['prodcode']);
                
                $query_app = "select prodstartyear, prodendyear, prodmodel, prodsubmodel, prodmake from [|PREFIX|]import_variations where productid ='$ProductId' AND id = '$id' ";
                $result_app = $GLOBALS["ISC_CLASS_DB"]->Query($query_app);
                while ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result_app)) {   
                    $prevapplication = $row;
                }
                
                if($newapplication != $prevapplication)   {
                     $isApplicationChanged = 1;
                }
                //For Application report in product change report Ends
                
                //For Content report in product change report          
                
                $ImportContentData['prodcode'] = $_POST['prodcode1'];        //Important!    needs to be changed to 'prodcode'
            
                foreach($ImportContentData as $key => $value)   { 
                    $ImportContentColumns .= $key.","; 
                }                 
                
                $ImportContentColumns = trim($ImportContentColumns, ",");
                
                
                $query_con = "select $ImportContentColumns from [|PREFIX|]import_variations where productid ='$ProductId' AND id = '$id' ";
                $result_con = $GLOBALS["ISC_CLASS_DB"]->Query($query_con);
                while ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result_con)) {   
                    $previmportcontent = $row;
                }
                /*echo "<pre>";
                echo count($ImportContentData);
                echo count($previmportcontent); 
                print_r($ImportContentData);
                print_r($previmportcontent);
                echo "<br /><br />";
                echo $isContentChanged;
                exit; */
                if($ImportContentData != $previmportcontent)   {
                     $isContentChanged = 1;
                }
                //For Content report in product change report Ends
                
            }    
            
            if($isContentChanged)    {
                $query = "INSERT INTO `isc_changes_report`(`changeprodid`,`changetype`,`changedtime`) VALUES ('$ProductId','content',NOW())";
                $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
            }
             
            if($isPriceChanged)    {
                $query = "INSERT INTO `isc_changes_report`(`changeprodid`,`changetype`,`changedtime`) VALUES ('$ProductId','price',NOW())";
                $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
            }
             
            if($isApplicationChanged)    {
                $query = "INSERT INTO `isc_changes_report`(`changeprodid`,`changetype`,`changedtime`) VALUES ('$ProductId','application',NOW())";
                $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
            }
            return $isContentChanged;               
        }

		/*
			The below function updates the price of the product through background process.
			param1 : product	(	This string is used to to know the type	)
			param2 : productid 	(	This is used to update the product of this id	)
		*/

		public function UpdatePriceInBackground($productId)	{
				
				exec("/usr/bin/php ../updatefinalprice.php product $productId > logs1 &#038;");

		}
        
	}

?>