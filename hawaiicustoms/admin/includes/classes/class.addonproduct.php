<?php

	/**
	* ISC_ADMIN_ADDONPRODUCT
	* Handles All Actions about Add-on Products
	*
	* @author Wirror Yin
	* @copyright Nirvana-info.
	* @date	20th May 2011
	*/

	class ISC_ADMIN_ADDONPRODUCT
	{
		private $addonProductEntity;
		private $productEntity;
		
		//zcs=>
		public function __construct(){
			$this->addonProductEntity = new ISC_ENTITY_ADDONPRODUCT();//zcs=
			$this->productEntity = new ISC_ENTITY_PRODUCT();//zcs=
		}
		//<=zcs
		public function HandleToDo($Do)
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('addon_products');
            
			switch (isc_strtolower($Do)) {
				case "createaddonproduct":
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Addon_Products)) {
						$GLOBALS['BreadcrumEntries'] = array(
							GetLang('Home') => "index.php",
							GetLang('AddonProducts') => "index.php?ToDo=viewAddonProducts",
							GetLang('CreateAddonProduct') => "index.php?ToDo=createAddonProduct",
						);

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->CreateAddonProductStep1();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}

					break;
				}
				//zcs=>
				case "createaddonproduct2":
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Addon_Products)) {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->CreateAddonProductStep2();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}

					break;
				}
				//<=zcs
				//zcs=>
				case "editaddonproduct":
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Addon_Products)) {
						$GLOBALS['BreadcrumEntries'] = array(
							GetLang('Home') => "index.php",
							GetLang('AddonProducts') => "index.php?ToDo=viewAddonProducts",
							GetLang('EditAddonProduct') => "index.php?ToDo=createAddonProduct",
						);
						
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->EditAddonProductStep1();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}

					break;
				}
				//<=zcs
				//zcs=>
				case "editaddonproduct2":
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Addon_Products)) {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->EditAddonProductStep2();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}

					break;
				}
				//<=zcs
				//zcs=>	
				case "updateaddonproductstatus":
				{
					if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Addon_Products)) {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->UpdateAddonProductStatus();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					}
					else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}

					break;
				}
				//<=zcs
				//zcs=>
				case "deleteaddonproducts":
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Addon_Products)) {

						$GLOBALS['BreadcrumEntries'] = array(
							GetLang('Home') => "index.php",
							GetLang('AddonProducts') => "index.php?ToDo=viewAddonProducts",
						);

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->DeleteAddonProducts();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				}
				//<=zcs
				default:
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Addon_Products)) {
						$GLOBALS['BreadcrumEntries'] = array(
							GetLang('Home') => "index.php",
							GetLang('AddonProducts') => "index.php?ToDo=viewAddonProducts",
						);
						//zcs=>
						if(isset($_REQUEST['searchQuery']) && trim($_REQUEST['searchQuery']) != ''){
							$GLOBALS['BreadcrumEntries']['View Add-on Products'] = "index.php?ToDo=viewAddonProducts";
						}
						
						if (!isset($_REQUEST['ajax']) || $_REQUEST['ajax'] != 1) {
							$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						}
						$this->ManageAddonProducts();
						if (!isset($_REQUEST['ajax']) || $_REQUEST['ajax'] != 1) {
							$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						}
						//<=zcs
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					
					break;
				}
			}
		}
		
		//zcs=>--------------------------------- Add-on Products-----------------------------------
		private function ManageAddonProducts($MsgDesc = '', $MsgStatus = ''){
			$numAddonProducts = 0;
			
			//zcs=>[CHOSEN 1]Show ALL, NO paging, NO sorting, HAS searching tip
			$GLOBALS['setSortOrder'] = 'true';
			// Fetch any results, place them in the data grid
			$GLOBALS['AddonProductDataGrid'] = $this->ManageAddonProductsGridOrderAll($numAddonProducts);
			if(isset($_GET['searchQuery']) && $_GET['searchQuery'] != ''){
				$GLOBALS['setSortOrder'] = 'false';
				$GLOBALS['NotifyMessage'] = MessageBox(GetLang('NoSortInSearchPage'), MSG_ERROR);
			}
			//<=zcs

			/*zcs=[CHOSEN 2]normalizing paging items
			// Fetch any results, place them in the data grid
			$GLOBALS['AddonProductDataGrid'] = $this->ManageAddonProductsGrid($numAddonProducts);
			*/
			
			// Was this an ajax based sort? Return the table now
			if (isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 1) {
				echo $GLOBALS['AddonProductDataGrid'];
				return;
			}
			
			$GLOBALS['ViewName'] = GetLang('AllAddonProducts');
			
			// Do we need to disable the delete button?
			if (!$GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Addon_Products) || $numAddonProducts == 0) {
				$GLOBALS['DisableDelete'] = "DISABLED";
			}
			
			$GLOBALS['AddonProductIntro'] = GetLang('ManageAddonProductsIntro');

			if ($numAddonProducts > 0) {
				if ($MsgDesc == "" && (isset($_REQUEST['searchQuery']) || isset($_GET['searchId']))) {
					if ($numAddonProducts == 1) {
						$MsgDesc = GetLang('AddonProductSearchResultsBelow1');
					}
					else {
						$MsgDesc = sprintf(GetLang('AddonProductSearchResultsBelowX'), $numAddonProducts);
					}

					$MsgStatus = MSG_SUCCESS;
				}
			}
			else {
				$GLOBALS['DisplayGrid'] = "none";
				if (count($_GET) > 1) {
					if ($MsgDesc == "") {
						$GLOBALS['Message'] = MessageBox(GetLang('NoAddonProductResults'), MSG_ERROR);
					}
				}
				else {
					// No actual custoemrs
					$GLOBALS['DisplaySearch'] = "none";
					$GLOBALS['Message'] = MessageBox(GetLang('NoAddonProducts'), MSG_INFO);
				}
			}

			if ($MsgDesc != "") {
				$GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
			}

			$flashMessages = GetFlashMessages();
			if(is_array($flashMessages) && !empty($flashMessages)) {
				$GLOBALS['Message'] = '';
				foreach($flashMessages as $flashMessage) {
					$GLOBALS['Message'] .= MessageBox($flashMessage['message'], $flashMessage['type']);
				}
			}

			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("addonproducts.manage");
			$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
		}
		
		//zcs=[CHOSEN 1]show all items to prepare for ordering, NO paging, NO sortOrder(only by "sequence DESC")
		private function ManageAddonProductsGridOrderAll(&$numAddonProducts){
			// Show a list of AddonProducts in a table
			$numAddonProducts = 0;
			$GLOBALS['AddonProductGrid'] = "";
			
			$GLOBALS['Query'] = isset($_GET['searchQuery']) ? $_GET['searchQuery'] : '';

			// Build the pagination and sort URL
			$searchURL = '';
			foreach($_GET as $k => $v) {
				if ($k == "sortField" || $k == "sortOrder" || $k == "page" || $k == "new" || $k == "ToDo" || $k == "SubmitButton1" || !$v) {
					continue;
				}
				$searchURL .= sprintf("&%s=%s", $k, urlencode($v));
			}

			// Get the results for the query, with "ALL","sequence DESC"
			$sortMap = array(
				'sequence' => 'DESC',
				'createtime' => 'DESC',
			);
			$addonProductResult = $this->_GetAddonProductList(0, $sortMap, $numAddonProducts, false);

			if ($numAddonProducts > 0) {
				while ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($addonProductResult)) {
					$GLOBALS['AddonProductId'] = (int) $row['id'];
					$GLOBALS['ProductId'] = (int) $row['p_id'];
					$GLOBALS['ProductUrl'] = sprintf("index.php?ToDo=editProduct&amp;productId=%d", (int) $row['p_id']);
					$GLOBALS['ProductName'] = isc_html_escape($row['p_name']);
					$GLOBALS['Description'] = isc_html_escape($row['description']);
					$GLOBALS['Price'] = FormatPrice($row['price'], false, false);
					switch($row['status']){
						case 0: // Inactive
						{
							if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Addon_Products)) {
								$GLOBALS['Status'] = sprintf("<a title='%s' href='index.php?ToDo=updateAddonProductStatus&amp;id=%d&amp;status=1'><img border='0' src='images/cross.gif'></a>", GetLang('AddonProductActiveTip'), $row['id']);
							} else {
								$GLOBALS['Status'] = "<img border='0' src='images/cross.gif'>";
							}

							break;
						}
						case 1: // Active
						{
							if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Addon_Products)) {
								$GLOBALS['Status'] = sprintf("<a title='%s' href='index.php?ToDo=updateAddonProductStatus&amp;id=%d&amp;status=0'><img border='0' src='images/tick.gif'></a>", GetLang('AddonProductInactiveTip'), $row['id']);
							} else {
								$GLOBALS['Status'] = "<img border='0' src='images/tick.gif'></a>";
							}

							break;
						}
					}
					$GLOBALS['CreateTime'] = $row['createtime'];
					
					$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("addonproducts.manage.row");
					$GLOBALS['AddonProductGrid'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
				}
			}

			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("addonproducts.manage.grid");
			return $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate(true);
		}
		
		/*//zcs=[CHOSEN 2]normalize items shown on, it has paging
		private function ManageAddonProductsGrid(&$numAddonProducts){
			// Show a list of AddonProducts in a table
			$page = 0;
			$start = 0;
			$numAddonProducts = 0;
			$numPages = 0;
			$GLOBALS['AddonProductGrid'] = "";
			$GLOBALS['Nav'] = "";
			$max = 0;
			
			$GLOBALS['Query'] = isset($_GET['searchQuery']) ? $_GET['searchQuery'] : '';

			if (isset($_REQUEST['sortOrder']) && $_REQUEST['sortOrder'] == "asc") {
				$sortOrder = "asc";
			}
			else {
				$sortOrder = "desc";
			}
			
			$validSortFields = array('p_name', 'price', 'status', 'createtime');
			if (isset($_REQUEST['sortField']) && in_array($_REQUEST['sortField'], $validSortFields)) {
				$sortField = $_REQUEST['sortField'];
				SaveDefaultSortField("ManageAddonProducts", $_REQUEST['sortField'], $sortOrder);
			} else {
				list($sortField, $sortOrder) = GetDefaultSortField("ManageAddonProducts", "createtime", $sortOrder);
			}

			if (isset($_GET['page'])) {
				$page = (int)$_GET['page'];
			}
			else {
				$page = 1;
			}
			// Build the pagination and sort URL
			$searchURL = '';
			foreach($_GET as $k => $v) {
				if ($k == "sortField" || $k == "sortOrder" || $k == "page" || $k == "new" || $k == "ToDo" || $k == "SubmitButton1" || !$v) {
					continue;
				}
				$searchURL .= sprintf("&%s=%s", $k, urlencode($v));
			}
			
			$sortURL = sprintf("%s&sortField=%s&sortOrder=%s", $searchURL, $sortField, $sortOrder);
			$GLOBALS['SortURL'] = $sortURL;

			// Limit the number of questions returned
			if ($page == 1) {
				$start = 1;
			}
			else {
				$start = ($page * ISC_PRODUCTS_PER_PAGE) - (ISC_PRODUCTS_PER_PAGE-1);
			}

			$start = $start-1;

			// Get the results for the query
			$addonProductResult = $this->_GetAddonProductList($start, array($sortField => $sortOrder), $numAddonProducts);

			$numPages = ceil($numAddonProducts / ISC_PRODUCTS_PER_PAGE);

			// Add the "(Page x of n)" label
			if ($numAddonProducts > ISC_PRODUCTS_PER_PAGE) {
				$GLOBALS['Nav'] = sprintf("(%s %d of %d) &nbsp;&nbsp;&nbsp;", GetLang('Page'), $page, $numPages);

				$GLOBALS['Nav'] .= BuildPagination($numAddonProducts, ISC_PRODUCTS_PER_PAGE, $page, sprintf("index.php?ToDo=viewAddonProducts%s", $sortURL));
			}
			else {
				$GLOBALS['Nav'] = "";
			}

			$GLOBALS['SortField'] = $sortField;
			$GLOBALS['SortOrder'] = $sortOrder;

			$sortLinks = array(
				"Product" => "p_name",
				'Price' => 'price',
				"Status" => "status",
				"CreateTime" => "createtime",
			);
			BuildAdminSortingLinks($sortLinks, "index.php?ToDo=viewAddonProducts&amp;".$searchURL."&amp;page=".$page, $sortField, $sortOrder);

			// Workout the maximum size of the array
			$max = $start + ISC_PRODUCTS_PER_PAGE;

			if ($max > $GLOBALS["ISC_CLASS_DB"]->CountResult($addonProductResult)) {
				$max = $GLOBALS["ISC_CLASS_DB"]->CountResult($addonProductResult);
			}

			if ($numAddonProducts > 0) {
				while ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($addonProductResult)) {
					$GLOBALS['AddonProductId'] = (int) $row['id'];
					$GLOBALS['ProductId'] = (int) $row['p_id'];
					$GLOBALS['ProductUrl'] = sprintf("index.php?ToDo=editProduct&amp;productId=%d", (int) $row['p_id']);
					$GLOBALS['ProductName'] = isc_html_escape($row['p_name']);
					$GLOBALS['Description'] = isc_html_escape($row['description']);
					$GLOBALS['Price'] = FormatPrice($row['price'], false, false);
					switch($row['status']){
						case 0: // Inactive
						{
							if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Addon_Products)) {
								$GLOBALS['Status'] = sprintf("<a title='%s' href='index.php?ToDo=updateAddonProductStatus&amp;id=%d&amp;status=1'><img border='0' src='images/cross.gif'></a>", GetLang('AddonProductActiveTip'), $row['id']);
							} else {
								$GLOBALS['Status'] = "<img border='0' src='images/cross.gif'>";
							}

							break;
						}
						case 1: // Active
						{
							if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Addon_Products)) {
								$GLOBALS['Status'] = sprintf("<a title='%s' href='index.php?ToDo=updateAddonProductStatus&amp;id=%d&amp;status=0'><img border='0' src='images/tick.gif'></a>", GetLang('AddonProductInactiveTip'), $row['id']);
							} else {
								$GLOBALS['Status'] = "<img border='0' src='images/tick.gif'></a>";
							}

							break;
						}
					}
					$GLOBALS['CreateTime'] = $row['createtime'];
					
					$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("addonproducts.manage.row");
					$GLOBALS['AddonProductGrid'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
				}
			}

			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("addonproducts.manage.grid");
			return $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate(true);
		}
		*/
		
		public function _GetAddonProductList($Start, $SortMap, &$NumAddonProducts, $AddLimit=true){
			$queryWhere = "";
			
			if (isset($_REQUEST['searchQuery']) && $_REQUEST['searchQuery'] != "") {
				// PostgreSQL is case sensitive for likes, so all matches are done in lower case
				$search_query = $GLOBALS['ISC_CLASS_DB']->QuoteEx(trim(isc_strtolower($_REQUEST['searchQuery'])));//zcs=Fix BUG,escape additional characters
				$queryWhere .= "
					AND (
						LOWER(prodname) LIKE '%" . $search_query . "%' OR
						price LIKE '%" . $search_query . "%' OR
						LOWER(description) LIKE '%" . $search_query . "%'
					)";
			}
			
			$query = "SELECT DISTINCT
				p.productid AS p_id, p.prodname AS p_name, 
				id, price, description, status, createtime 
				FROM
				[|PREFIX|]addon_products a
				LEFT JOIN
				[|PREFIX|]products p
				ON (a.productid=p.productid)
				WHERE 1=1 ".$queryWhere." GROUP BY a.id";

			$countQuery = "SELECT
				COUNT(a.id)
				FROM
				[|PREFIX|]addon_products a
				LEFT JOIN
				[|PREFIX|]products p
				ON (a.productid=p.productid)
				WHERE 1=1 ".$queryWhere." GROUP BY a.id";

			// Fetch the number of results we have
			$NumAddonProducts = $GLOBALS['ISC_CLASS_DB']->CountResult($countQuery);

			if ($SortMap) {
				$query .= " ORDER BY ";
				foreach($SortMap as $field => $order){
					$query .= " $field $order,";
				}
				$query = substr($query, 0, -1);
			}

			// Add the limit
			if ($AddLimit) {
				$query .= $GLOBALS["ISC_CLASS_DB"]->AddLimit($Start, ISC_PRODUCTS_PER_PAGE);
			}
			$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);

			return $result;
		}
		
		private function DeleteAddonProducts()
		{
			$queries = array();
			if (isset($_REQUEST['addonProducts'])) {
				$message = '';
				list($done, $deleted) = $this->addonProductEntity->multiDelete($_REQUEST['addonProducts']);
				if (!$done) {
					$err = $GLOBALS["ISC_CLASS_DB"]->GetErrorMsg();
					$message = empty($err) ? GetLang('AddonProductsDeletedFailed') : $err;
					//$this->ManageAddonProducts($err, MSG_ERROR);
				} else {
					$message = GetLang('AddonProductsDeletedSuccessfully');
					//$this->ManageAddonProducts(GetLang('AddonProductsDeletedSuccessfully'), MSG_SUCCESS);
				}
				$logdata['addonProductNum'] = count($deleted);
				$logdata['addonProductIDs'] = implode(',', $deleted);
				// Log this action
				$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($logdata);
				echo "<script language=\"javascript\">".
					"alert('".$message."');".
					"location.href='index.php?ToDo=viewAddonProducts';".
					"</script>";
				exit;
			}
			else {
				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Addon_Products)) {
					$this->ManageAddonProducts();
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
				}
			}
		}
		
		private function UpdateAddonProductStatus()
		{
			// Update the status of a AddonProduct with a simple query
			$addonProductId = (int)$_GET['id'];
			$status = (int)$_GET['status'];

			$updateAddonProduct = array(
				"status" => $status
			);
			
			$GLOBALS['ISC_CLASS_DB']->UpdateQuery("addon_products", $updateAddonProduct, "id='".$GLOBALS['ISC_CLASS_DB']->Quote($addonProductId)."'");
			if ($GLOBALS['ISC_CLASS_DB']->_Error == "") {
				if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Addon_Products)) {
					$query = sprintf("SELECT productid FROM [|PREFIX|]addon_products WHERE id='%d'", $addonProductId);
					$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
					$productId = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);

					// Log this action
					$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($addonProductId, $productId);

					$this->ManageAddonProducts(GetLang('AddonProductStatusSuccessfully'), MSG_SUCCESS);
				}
				else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('AddonProductStatusSuccessfully'), MSG_SUCCESS);
				}
			}
			else {
				$err = '';
				if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Addon_Products)) {
					$this->ManageAddonProducts(sprintf(GetLang('ErrAddonProductStatusNotChanged'), $err), MSG_ERROR);
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(sprintf(GetLang('ErrAddonProductStatusNotChanged'), $err), MSG_ERROR);
				}
			}
		}
		
		/**
		 * Get the Add-on Product data
		 *
		 * Method will either get the Add-on Product POST data if $addonProductId is null, or the database data if $addonProductId is not null
		 *
		 * @access private
		 * @param int $AddonProductId The optional Add-on Product ID. If supplied will return the Add-on Product POST data, else return data from the database
		 * @param bool $entitiesData TRUE to entities the data using isc_html_escape, FALSE to leave as is. Default is TRUE
		 * @return Void
		 */
		private function _GetAddonProductData($AddonProductId=null, $entitiesData=true)
		{
			$addonProduct = null;

			if (!isId($AddonProductId)) {
				// Get the data for this Add-on Product from the form. The arrays
				// index names will match the table field names exactly.

				$addonProduct = array();
				$addonProduct['id'] = 0;
				$addonProduct['productid'] = intval($_POST['addonProductProductId']);
				$addonProduct['productname'] = $_POST['addonProductProductName'];
				$addonProduct['price'] = $_POST['addonProductPrice'];
				$addonProduct['description'] = $_POST['addonProductDescription'];
				$addonProduct['status'] = intval($_POST['addonProductStatus']);
			} else {
				// Get the data for this Add-on Product from the database
				$query = "SELECT
					a.id AS id, price, description, status,
					p.productid AS productid, p.prodname AS productname
					FROM
					[|PREFIX|]addon_products a
					LEFT JOIN
					[|PREFIX|]products p
					ON(a.productid = p.productid)
					WHERE a.id='" . $GLOBALS['ISC_CLASS_DB']->Quote($AddonProductId) . "'";

				$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
				$addonProduct = $GLOBALS["ISC_CLASS_DB"]->Fetch($result);
			}
			
			$addonProduct['description'] = trim(isc_html_escape($addonProduct['description']));

			return $addonProduct;
		}
		
		/**
		 * Add a Add-on Product page
		 *
		 * Method will construct the add Add-on Product page
		 *
		 * @access public
		 * @param string $MsgDesc The optional message to display
		 * @param string $MsgStatus The optional status of the message
		 * @param bool $PreservePost TRUE to use the REQUEST variable, FALSE to read from the database. Default is FALSE
		 * @return Void
		 */
		public function CreateAddonProductStep1($MsgDesc = "", $MsgStatus = "", $PreservePost=false)
		{
			if ($MsgDesc != "") {
				$GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
			}

			$flashMessages = GetFlashMessages();
			if(is_array($flashMessages) && !empty($flashMessages)) {
				$GLOBALS['Message'] = '';
				foreach($flashMessages as $flashMessage) {
					$GLOBALS['Message'] .= MessageBox($flashMessage['message'], $flashMessage['type']);
				}
			}

			if (GetConfig('CurrencyLocation') == 'right') {
				$GLOBALS['CurrencyTokenLeft'] = '';
				$GLOBALS['CurrencyTokenRight'] = GetConfig('CurrencyToken');
			} else {
				$GLOBALS['CurrencyTokenLeft'] = GetConfig('CurrencyToken');
				$GLOBALS['CurrencyTokenRight'] = '';
			}

			if (isset($_REQUEST['currentTab'])) {
				$GLOBALS['CurrentTab'] = (int)$_REQUEST['currentTab'];
			} else {
				$GLOBALS['CurrentTab'] = 0;
			}
			
			$GLOBALS['Title'] = GetLang('CreateAddonProduct');
			$GLOBALS['Intro'] = GetLang('CreateAddonProductsIntro');
			$GLOBALS['FormAction'] = 'createAddonProduct2';

			if($PreservePost == true) {
				$addonProduct = $this->_GetAddonProductData(0);

				$GLOBALS['AddonProductProductId'] = $addonProduct['productid'];
				$GLOBALS['AddonProductProductName'] = $addonProduct['productname'];
				$GLOBALS['AddonProductPrice'] = FormatPrice($addonProduct['price'], false, false);
				$GLOBALS['AddonProductDescription'] = $addonProduct['description'];
				$addonProduct['status'] == 0 ? $GLOBALS['AddonProductStatusDisabled'] = 'selected="selected"' : $GLOBALS['AddonProductStatusEnabled'] = 'selected="selected"';
			}else{
				$GLOBALS['AddonProductPrice'] = FormatPrice(0, false, false);
			}
			
			$GLOBALS['SaveAndAddAnother'] = GetLang('SaveAndAddAnother');
			$GLOBALS['CancelMessage'] = GetLang('ConfirmCancelAddonProduct');
			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("addonproduct.form");
			$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
		}

		/**
		 * Add a Add-on product
		 *
		 * Method will add a add-on product from the add screen
		 *
		 * @access public
		 * @return Void
		 */
		public function CreateAddonProductStep2()
		{
			// Get the information from the form and add it to the database
			$StoreAddonProduct = array();
			$PostAddonProduct = $this->_GetAddonProductData(0, false);
			$err = "";

			if (!$this->_ValidateFormData($Error)) {
				return $this->CreateAddonProductStep1($Error, MSG_ERROR, true);
			}
			
			$StoreAddonProduct['productid'] = $PostAddonProduct['productid'];
			$StoreAddonProduct['price'] = FormatPrice($PostAddonProduct['price'], false, false);
			$StoreAddonProduct['description'] = trim($PostAddonProduct['description']);
			$StoreAddonProduct['status'] = intval($PostAddonProduct['status']);

			$addonProductId = $this->addonProductEntity->add($StoreAddonProduct);
			if (isId($addonProductId)) {
				// Log this action
				$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($addonProductId);

				if (isset($_POST['addanother'])) {
					$this->CreateAddonProductStep1(GetLang('AddonProductCreatedSuccessfully'), MSG_SUCCESS);
				} else {
					FlashMessage(GetLang('AddonProductCreatedSuccessfully'), MSG_SUCCESS, 'index.php?ToDo=viewAddonProducts');
				}
			} else {
				$this->CreateAddonProductStep1(sprintf(GetLang("AddonProductCreatedFailed"), $GLOBALS["ISC_CLASS_DB"]->GetErrorMsg()), MSG_ERROR, true);
			}
		}
		
		/**
		 * Edit page
		 *
		 * Method will construct the edit page
		 *
		 * @access public
		 * @param string $MsgDesc The optional message to display
		 * @param string $MsgStatus The optional status of the message
		 * @param bool $PreservePost TRUE to use the REQUEST variable, FALSE to read from the database. Default is FALSE
		 * @return Void
		 */
		public function EditAddonProductStep1($MsgDesc = "", $MsgStatus = "", $PreservePost=false)
		{
			if ($MsgDesc != "") {
				$GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
			}

			$flashMessages = GetFlashMessages();
			if(is_array($flashMessages) && !empty($flashMessages)) {
				$GLOBALS['Message'] = '';
				foreach($flashMessages as $flashMessage) {
					$GLOBALS['Message'] .= MessageBox($flashMessage['message'], $flashMessage['type']);
				}
			}

			// Show the form to edit
			$addonProductId = (int)$_GET['addonProductId'];

			// Make sure it exists
			if (!AddonProductExists($addonProductId)) {
				// doesn't exist
				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Addon_Products)) {
					$this->ManageAddonProducts(GetLang('AddonProductDoesntExist'), MSG_ERROR);
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
				}
				return;
			}
			
			if (GetConfig('CurrencyLocation') == 'right') {
				$GLOBALS['CurrencyTokenLeft'] = '';
				$GLOBALS['CurrencyTokenRight'] = GetConfig('CurrencyToken');
			} else {
				$GLOBALS['CurrencyTokenLeft'] = GetConfig('CurrencyToken');
				$GLOBALS['CurrencyTokenRight'] = '';
			}

			if ($PreservePost == true) {
				$addonProduct = $this->_GetAddonProductData(0);
			} else {
				$addonProduct = $this->_GetAddonProductData($addonProductId);
			}

			if (isset($_REQUEST['currentTab'])) {
				$GLOBALS['CurrentTab'] = (int)$_REQUEST['currentTab'];
			} else {
				$GLOBALS['CurrentTab'] = 0;
			}

			$GLOBALS['FormAction'] = "editaddonproduct2";
			$GLOBALS['AddonProductId'] = $addonProductId;
			$GLOBALS['Title'] = GetLang('EditAddonProduct');
			$GLOBALS['Intro'] = GetLang('EditAddonProductsIntro');
			$GLOBALS['AddonProductProductId'] = $addonProduct['productid'];
			$GLOBALS['AddonProductProductName'] = $addonProduct['productname'];
			$GLOBALS['AddonProductPrice'] = FormatPrice($addonProduct['price'], false, false);
			$GLOBALS['AddonProductDescription'] = $addonProduct['description'];
			$addonProduct['status'] == 0 ? $GLOBALS['AddonProductStatusDisabled'] = 'selected="selected"' : $GLOBALS['AddonProductStatusEnabled'] = 'selected="selected"';

			$GLOBALS['SaveAndAddAnother'] = GetLang('SaveAndContinueEditing');
			$GLOBALS['CancelMessage'] = GetLang('ConfirmCancelAddonProduct');
			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("addonproduct.form");
			$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
		}

		/**
		 * Edit
		 *
		 * Method will edit from the edit screen
		 *
		 * @access public
		 * @return Void
		 */
		public function EditAddonProductStep2()
		{
			// Get the information from the form and add it to the database
			$addonProductId = isc_html_escape((int)$_POST['addonProductId']);
			if (!AddonProductExists($addonProductId)) {
				// doesn't exist
				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Addon_Products)) {
					$this->ManageAddonProducts(GetLang('AddonProductDoesntExist'), MSG_ERROR);
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
				}
				return;
			}
			
			$StoreAddonProduct = array();
			$PostAddonProduct = $this->_GetAddonProductData(0, false);
			$Error = "";

			if (!$this->_ValidateFormData($Error)) {
				$_GET['addonProductId'] = (int)$_POST['addonProductId'];
				return $this->EditAddonProductStep1($Error, MSG_ERROR, true);
			}

			$StoreAddonProduct['id'] = $addonProductId;
			$StoreAddonProduct['productid'] = $PostAddonProduct['productid'];
			$StoreAddonProduct['price'] = FormatPrice($PostAddonProduct['price'], false, false);
			$StoreAddonProduct['description'] = trim($PostAddonProduct['description']);
			$StoreAddonProduct['status'] = intval($PostAddonProduct['status']);
			
			if ($this->addonProductEntity->edit($StoreAddonProduct)) {
				// Log this action
				$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($addonProductId);

				if (isset($_POST['addanother'])) {
					$_GET['addonProductId'] = $addonProductId;
					$this->EditAddonProductStep1(GetLang('AddonProductUpdatedSuccessfully'), MSG_SUCCESS);
				} else {
					FlashMessage(GetLang('AddonProductUpdatedSuccessfully'), MSG_SUCCESS, 'index.php?ToDo=viewAddonProducts');
				}
			} else {
				$_GET['addonProductId'] = $addonProductId;
				$this->EditAddonProductStep1(sprintf(GetLang("AddonProductUpdatedFailed"), $GLOBALS["ISC_CLASS_DB"]->GetErrorMsg()), MSG_ERROR);
			}
		}
		
		/**
		 * Validate input data
		 *
		 * Method will read the POST data and validate the data
		 *
		 * @access private
		 * @param string &$Error The referenced string to store any error messages to
		 * @return bool TRUE if the validation was successful, FALSE otherwise
		 */
		private function _ValidateFormData(&$Error = "")
		{
			if(strlen(trim($_POST['addonProductDescription'])) > 250){
				$Error = stripslashes(GetLang('AddonProductDescriptionExceeded'));
				return false;
			}
			
			if(!isId($_POST['addonProductProductId'])){
				$Error = stripslashes(GetLang('AddonProductProductRequired'));
				return false;
			}
			
			if(!$this->productEntity->exists($_POST['addonProductProductId'])){
				$Error = stripslashes(GetLang('AddonProductProductRequired'));
				return false;
			}

			return true;
		}
		//<=zcs----------------------------------------------------------------------------------------
	}

?>