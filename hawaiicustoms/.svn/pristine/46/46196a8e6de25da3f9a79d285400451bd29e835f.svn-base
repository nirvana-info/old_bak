<?php

	class ISC_ADMIN_CUSTOMCONTENTS
	{
		
		public function __construct()
		{
			
		}

		public function HandleToDo($Do)
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('categories');

			switch (isc_strtolower($Do))
			{
				case "listcatecustomcontents":
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Categories)) {
						$this->ListCustomPage();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				}
				case "showcatecustomcontent":
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Categories)) {
						$this->ShowCustomPage();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				}
				case "editcatecustomcontent":
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Categories)) {
						$this->EditCustomPage();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				}
				case "savecatecustomcontent":
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Categories)) {
						$this->SaveCustomPageItem();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				}
				case "updatecatecustomcontent":
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Categories)) {
						$this->UpdateCustomPageItem();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				}
				case "deletecatecustomcontent":
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Categories)) {
						$itemIds = $_GET['itemId'];
						$this->DeleteCustomPageItem($itemIds);
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				}
				case "deletecatecustomcontents":
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Categories)) {
						$itemIds = $_POST['itemIds'];
						$this->DeleteCustomPageItem($itemIds);
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				}
				case "prevcatecustomcontent":
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Categories)) {
						$this->PreviewCustomPageItem();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				}
				case "enablecatecustomcontent":
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Categories)) {
						$this->EnableCustomPageItem();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				}
				default:
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Categories)) {
						$this->ListCustomPage();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
				}
			}
		}
		
		public function EnableCustomPageItem(){

			if(!(isset($_POST['itemId']) && isset($_POST['enabled']))){
				exit;
			}
			
			$itemid = $_POST['itemId'];
			
			if($_POST['enabled'] == 'true'){
				$enabled = true;
			}else{
				$enabled = false;
			}
			
			// Start transaction
			$GLOBALS['ISC_CLASS_DB']->Query("START TRANSACTION");
	
			$updatedStatus = array(
				"enabled" => $enabled
			);

			// Update the status for this order review request
			if ($GLOBALS['ISC_CLASS_DB']->UpdateQuery("custom_products", $updatedStatus, "itemid='".$GLOBALS['ISC_CLASS_DB']->Quote($itemid)."'")) {
				// Log this action if we are in the control panel
				if (defined('ISC_ADMIN_CP')) {
					//$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($orderId, $statusName);
				}
			}
			// Was there an error? If not, commit
			if($GLOBALS['ISC_CLASS_DB']->Error() == "") {
				$GLOBALS['ISC_CLASS_DB']->Query("COMMIT");
			}else{
				exit;
			}
		}
		
		public function PreviewCustomPageItem()
		{
			if(isset($_GET["itemId"])) {
				$item = $this->GetCustomItemById($_GET["itemId"]);
				if($item != NULL)
					$itemdesc = $item['description'];
				echo $itemdesc;
			}
		}
		
		public function GetCustomItemById($itemId){
			$query = "SELECT * FROM [|PREFIX|]custom_products WHERE itemid='$itemId'";
            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
 
            //$returnObj = {};
            if($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)){
            	return $row;
            }else{
            	return NULL;
            }
		}
		
		public function DeleteCustomPageItem($itemIds)
		{
			if(is_array($itemIds))
				$items = implode("','", $itemIds);
			else
				$items = $itemIds;
			$this->DeleteCustomItems($items);
		}
		
		private function DeleteCustomItems($itemIds){
			$GLOBALS['ISC_CLASS_DB']->DeleteQuery('custom_products', "WHERE itemId IN ('".$itemIds."')");
			$err = $GLOBALS['ISC_CLASS_DB']->GetErrorMsg();

			if ($err != "") {
				//$this->ManageOrders($err, MSG_ERROR);
			} else {
				$GLOBALS['ISC_CLASS_DB']->Query("COMMIT");

				// Log this action
				//$GLOBALS['ISC_CLASS_LOG']->LogAdminAction(count($orderIds));

				$location= 'index.php?ToDo=listCateCustomContents&customContentId='.$_GET['contentId'].'&catId='.$_GET['catId'];
				header('Location: '.$location);
				exit;
			}
		}
		
		public function UpdateCustomPageItem()
		{
			$result = $this->_CommitCustomProducts($_POST['itemId']);
			if ($result) {
				// Log this action
				//$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($_POST['catname']);

				if(isset($_GET['AddAnother'])) {
					$location = 'index.php?ToDo=editCateCustomContent&itemId='.$_POST['itemId'].'&catId='.$_POST['catId'];
				}
				else {
					$location= 'index.php?ToDo=listCateCustomContents&customContentId='.$_POST['contentId'].'&catId='.$_POST['catId'];
				}

				header('Location: '.$location);
				exit;
			} else {
				//FlashMessage(sprintf(GetLang('CatNotSaved'), isc_html_escape($_POST['catname'])), MSG_ERROR, 'index.php?ToDo=createCategory');                
			}
		}
		
		public function SaveCustomPageItem()
		{
			$result = $this->_CommitCustomProducts();
            
			if ($result) {
				// Log this action
				//$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($_POST['catname']);

				if(isset($_GET['AddAnother'])) {
					$location = 'index.php?ToDo=showCateCustomContent&contentId='.$_POST['contentId'].'&catId='.$_POST['catId'];
				}
				else {
					$location= 'index.php?ToDo=listCateCustomContents&customContentId='.$_POST['contentId'].'&catId='.$_POST['catId'];
				}

				header('Location: '.$location);
				exit;
			} else {
				//FlashMessage(sprintf(GetLang('CatNotSaved'), isc_html_escape($_POST['catname'])), MSG_ERROR, 'index.php?ToDo=createCategory');                
			}
		}
		
		private function _CommitCustomProducts($ItemID = 0)
		{
			$itemdesc = '';
			if(isset($_POST["wysiwyg"])) {
				$itemdesc = ISC_ADMIN_PRODUCT::FormatWYSIWYGHTML($_POST['wysiwyg']);
			}
			
			$visiturl = GetConfig('ShopPath').'/';
			if(isset($_POST["categorybox"]) && $_POST["categorybox"] !=0){
				$visiturl .= MakeURLSafe(strtolower($_POST["categoryname"])).'/';
			}else{
				$_POST["categoryname"] = '';
			}
			if(isset($_POST["subcategorybox"]) && $_POST["subcategorybox"] !=0){
				$visiturl .= 'subcategory/'.MakeURLSafe(strtolower($_POST["subcategoryname"])).'/';
			}else{
				$_POST["subcategoryname"] = '';
			}
			if(isset($_POST["brandbox"]) && $_POST["brandbox"] !=0){
				$visiturl .= 'brand/'.MakeURLSafe(strtolower($_POST["brandname"])).'/';
			}else{
				$_POST["brandname"] = '';
			}
			if(isset($_POST["seriesbox"]) && $_POST["seriesbox"] !=0){
				$visiturl .= 'series/'.MakeURLSafe(strtolower($_POST["seriesname"])).'/';
			}else{
				$_POST["seriesname"] = '';
			}
			
			if(isset($_POST['ISSelectReplacement_productResults']) && is_array($_POST['ISSelectReplacement_productResults'])){
				if(count($_POST['ISSelectReplacement_productResults']) > 0){
					$productIds = implode(',',$_POST['ISSelectReplacement_productResults']);
				}else{
					$productIds = '-1';
				}
			}
			else
				$productIds = '0';
			
			$enabled = $_POST["enabled"]=='on' ? true : false;

			$customItem = array(
				'itemtitle' => $_POST['itemTitle'],
				'productids' => $productIds,
				'description' => $itemdesc,
				'enabled' => $enabled,
				'contentid' => $_POST['contentId'],
				'visiturl' => $visiturl,
				'catename' => $_POST["categoryname"],
				'subcatename' => $_POST["subcategoryname"],
				'brandname' => $_POST["brandname"],
				'seriesname' => $_POST["seriesname"],
				'categoryid' => $_POST["categorybox"],
				'subcategoryid' => $_POST["subcategorybox"],
				'brandid' => $_POST["brandbox"],
				'seriesid' => $_POST["seriesbox"]
			);
            
			if ($ItemID == 0) {
				$ItemID = $this->createCustomProducts($customItem) ;
				if($ItemID) {
					$GLOBALS['NewComtentPageId'] = $ItemID;
				}
			} else {
				$this->updateCustomProducts($ItemID, $customItem);
			}
			
			return true;
		}
		
		public function createCustomProducts($customItem)
		{
			return $GLOBALS['ISC_CLASS_DB']->InsertQuery('custom_products', $customItem);
		}
		
		public function updateCustomProducts($itemid, $customItem)
		{
			$GLOBALS['ISC_CLASS_DB']->Query("START TRANSACTION");
	
			// Update the status for this order review request
			if ($GLOBALS['ISC_CLASS_DB']->UpdateQuery("custom_products", $customItem, "itemid='".$GLOBALS['ISC_CLASS_DB']->Quote($itemid)."'")) {
				// Log this action if we are in the control panel
				if (defined('ISC_ADMIN_CP')) {
					//$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($orderId, $statusName);
				}
			}
			// Was there an error? If not, commit
			if ($GLOBALS['ISC_CLASS_DB']->Error() == "") {
				$GLOBALS['ISC_CLASS_DB']->Query("COMMIT");
				return true;
			}
			
			return false;
		}
		
		public function createCustomContens($customItem)
		{
			return $GLOBALS['ISC_CLASS_DB']->InsertQuery('custom_contents', $customItem);
		}
		
		private function ListCustomPage()
		{
			if(isset($_GET['customContentId']) && $_GET['customContentId']!=0){
				$contentId = $_GET['customContentId'];
			}else{
				$contentId = 0;
			}
			
			if(isset($_GET['catId']) && $_GET['catId']!=0){
				$catId = $_GET['catId'];
			}else{
				$catId = 0;
			}
			
			$GLOBALS["CreateCustomItemAction"] = "showCateCustomcontent&contentId=$contentId&catId=$catId";
			$GLOBALS["FormAction"] = "savecatecustomcontents";
			$GLOBALS["ContentId"] = $contentId;
			$GLOBALS["CatId"] = $catId;
			
            $query = "SELECT *
            		  FROM [|PREFIX|]custom_products cp 
            		  INNER JOIN [|PREFIX|]custom_contents cc on cc.contentid=cp.contentid
            		  WHERE cc.contentid=$contentId
            		  ORDER BY cp.displayorder ASC";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$GLOBALS['ItemId'] = $row['itemid'];
				$GLOBALS['ItemTitle'] = $row['itemtitle'];
				$GLOBALS['DisplayOrder'] = $row['displayorder'];
				/*
				$productIdArr = explode(',',$row['productids']);
				$GLOBALS['ProductsCount'] = in_array(0, $productIdArr) ? count($productIdArr) - 1 : count($productIdArr);
				if($GLOBALS['ProductsCount'] == 0)
					$GLOBALS['ProductsCount'] = 'All';
				*/
				if($row['enabled'])
					$GLOBALS['ItemEnabled'] = sprintf("<a href='javascript:void(0);' name='enableLink%s' class='enableLink'><img border='0' src='images/tick.gif' alt='tick' title='Click here to disable this item.'></a>", $row['itemid']);
				else
					$GLOBALS['ItemEnabled'] = sprintf("<a href='javascript:void(0);' name='enableLink%s' class='enableLink'><img border='0' src='images/cross.gif' alt='cross' title='Click here to enable this item.'></a>", $row['itemid']);
				
				$GLOBALS['ViewLink'] = sprintf("<a title='%s' href=\"javascript:PreviewCustomItem(%s)\" class=\"bodylink\">%s</a>", GetLang('PreviewCustomPageItem'), urlencode($row['itemid']), GetLang('Preview'));

				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Categories)) {
					$GLOBALS['EditLink'] = sprintf("<a title='%s' href=\"index.php?ToDo=editCateCustomContent&amp;itemId=%s&amp;contentId=%s&amp;catId=%s\" class=\"bodylink\">%s</a>", GetLang('EditCustomPageItem'), $row['itemid'], $contentId, $catId, GetLang('Edit'));
				} else {
					$GLOBALS['EditLink'] = sprintf("<a disabled class=\"bodylink\">%s</a>", GetLang('Edit'));
				}

				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Delete_Categories)) {
					$GLOBALS['DeleteLink'] = sprintf("<a title='%s' onclick='return deleteConfirm();' href=\"index.php?ToDo=deleteCateCustomContent&amp;itemId=%s&amp;contentId=%s&amp;catId=%s\" class=\"bodylink\">%s</a>", GetLang('DeleteCustomPageItem'), $row['itemid'], $contentId, $catId, GetLang('Delete'));
				} else {
					$GLOBALS['DeleteLink'] = sprintf("<a disabled class=\"bodylink\">%s</a>", GetLang('Delete'));
				}
				
				$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("category.custompage.row");
				$GLOBALS['CustomPageGrid'] .= $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate(true);
			}
			
			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("category.custompage.grid");
            $GLOBALS['CustomItemsGrid'] = $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate(true); 
			
			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("category.custompage.list");
			$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
		}
		
		private function ShowCustomPage()
		{
			$GLOBALS["FormAction"] = "savecatecustomcontent";
			$GLOBALS["ContentId"] = $_GET['contentId'];
			$GLOBALS["ShopPath"] = GetConfig('ShopPath');
			$GLOBALS["Enabled"] = true;
			$catId = isset($_GET['catId']) ? (int)$_GET['catId'] : 0;
			$GLOBALS["CatId"] = $catId;
			$GLOBALS["SubCatId"] = 0;
			$GLOBALS["BrandId"] = 0;
			$GLOBALS["SeriesId"] = 0;
			
			//wirror_20100728: add a html editor for the item products on edit category
			$wysiwygOptions = array(
				'id'		=> 'wysiwyg',
				'width'		=> '750px',
				'height'	=> '500px'
			);
			$GLOBALS['WYSIWYG'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor($wysiwygOptions);
			
			//$GLOBALS['ISC_CLASS_ADMIN_CATEGORIES'] = GetClass('ISC_ADMIN_CATEGORY'); 
			//$GLOBALS['RootCategoryOptions'] = $GLOBALS['ISC_CLASS_ADMIN_CATEGORIES']->GetFlatCategories($catId, "<option %s value='%d'>%s</option>", "selected=\"selected\"", 0);
			$GLOBALS['ISC_CLASS_ADMIN_CATEGORIES'] = GetClass('ISC_ADMIN_CATEGORY');
			include_once(ISC_BASE_PATH.'/lib/api/category.api.php');
			$category = new API_CATEGORY();
			$category->load($catId);
			$GLOBALS['RootCategoryOptions'] = sprintf("<option %s value='%d'>%s</option>", 'readonly', $category->categoryid, $category->catname);//$GLOBALS['ISC_CLASS_ADMIN_CATEGORIES']->GetFlatCategories($categoryid, "<option %s value='%d'>%s</option>", "selected=\"selected\"", 0);
			$GLOBALS['SubCategoryOptions'] = $GLOBALS['ISC_CLASS_ADMIN_CATEGORIES']->GetFlatCategories(0, "<option %s value='%d'>%s</option>", "selected=\"selected\"", $category->categoryid);
			
			$GLOBALS['ISC_CLASS_ADMIN_BRANDS'] = GetClass('ISC_ADMIN_BRANDS'); 
			$GLOBALS['BrandNameOptions'] = $GLOBALS["ISC_CLASS_ADMIN_BRANDS"]->GetBrandOptions(array(), "<option %s value='%d'>%s</option>", 'selected="selected"', " ", false);

			$_GET['category'] = $catId;
			$GLOBALS['ProductResults'] = $GLOBALS['ISC_CLASS_ADMIN_CATEGORIES']->GetProductOptions(array(), "<option %s value='%d'>%s</option>", 'selected="selected"', " ", false);
			
			$GLOBALS['SnippetCustomPageItem'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('CategoryCustomPageItem');
			
			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("category.custompage");
			$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
		}
		
		private function EditCustomPage()
		{
			if(isset($_GET["itemId"])) {
				$item = $this->GetCustomItemById($_GET["itemId"]);
				if($item != NULL){
					$GLOBALS["FormAction"] = "updatecatecustomcontent";
					$GLOBALS["CustomItemId"] = $_GET["itemId"];
					$GLOBALS["ContentId"] = $_GET['contentId'];
					$GLOBALS["VisitURL"] = $item['visiturl'];
					$GLOBALS["Enabled"] = $item['enabled'];
					$GLOBALS["ItemTitle"] = $item['itemtitle'];
					$categoryid = $item['categoryid'];
					$catename = $item['catename'];
					$subcategoryid = $item['subcategoryid'];
					$subcatename = $item['subcatename'];
					$brandid = $item['brandid'];
					$brandname= $item['brandname'];
					$seriesid = $item['seriesid'];
					$seriesname = $item['seriesname'];
					$GLOBALS["CatId"] = $categoryid;
					$GLOBALS["SubCatId"] = $subcategoryid;
					$GLOBALS["BrandId"] = $brandid;
					$GLOBALS["SeriesId"] = $seriesid;
					
					//wirror_20100728: add a html editor for the item products on edit category
					$wysiwygOptions = array(
						'id'		=> 'wysiwyg',
						'width'		=> '750px',
						'height'	=> '500px',
						'value'     => $item['description']
					);
					$GLOBALS['WYSIWYG'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor($wysiwygOptions);
					
					$GLOBALS['ISC_CLASS_ADMIN_CATEGORIES'] = GetClass('ISC_ADMIN_CATEGORY'); 
					include_once(ISC_BASE_PATH.'/lib/api/category.api.php');
					$category = new API_CATEGORY();
					$category->load($categoryid);
					$GLOBALS['RootCategoryOptions'] = sprintf("<option %s value='%d'>%s</option>", 'readonly', $category->categoryid, $category->catname);//$GLOBALS['ISC_CLASS_ADMIN_CATEGORIES']->GetFlatCategories($categoryid, "<option %s value='%d'>%s</option>", "selected=\"selected\"", 0);
					$GLOBALS['SubCategoryOptions'] = $GLOBALS['ISC_CLASS_ADMIN_CATEGORIES']->GetFlatCategories(0, "<option %s value='%d'>%s</option>", "selected=\"selected\"", $category->categoryid);
			
					$GLOBALS['ISC_CLASS_ADMIN_BRANDS'] = GetClass('ISC_ADMIN_BRANDS'); 
					$GLOBALS['BrandNameOptions'] = $GLOBALS["ISC_CLASS_ADMIN_BRANDS"]->GetBrandOptions(array($brandid), "<option %s value='%d'>%s</option>", 'selected="selected"', " ", false);
		
					//$GLOBALS['SubCategoryOptions'] = $subcatename == NULL ? "" : "<option value=\"$subcategoryid\" selected=\"selected\">$subcatename</option>";
					//$GLOBALS['SeriesNameOptions'] = $seriesname == NULL ? "" : "<option value=\"$seriesid\" selected=\"selected\">$seriesname</option>";
					
					$_GET['category'] = $categoryid;
					$_GET['subscategory'] = $subcategoryid;
				    $_GET['brand'] = $brandid;
				    $_GET['series'] = $seriesid;
					$GLOBALS['ProductResults'] = $GLOBALS['ISC_CLASS_ADMIN_CATEGORIES']->GetProductOptions(explode(',', $item['productids']), "<option %s value='%d'>%s</option>", 'selected="selected"', " ", false);
					
					$GLOBALS['SnippetCustomPageItem'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('CategoryCustomPageItem');
					
					$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("category.custompage");
					$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
				}
			}
		}
		
		private function GetProductOptions($productIds)
		{
			$retOptions = '';
			$query = "SELECT productid,prodname FROM [|PREFIX|]products WHERE productid IN ($productIds)";
            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
            while($rows = $GLOBALS['ISC_CLASS_DB']->Fetch($result)){
            	$retOptions .= "<option value=\"".$rows['productid']."\" selected=\"selected\">".$rows['prodname']."</option>";
            }
            
            return $retOptions;
		}
		
		public function GetProductIds($condArr){
			$products = array();

			// Make sure $SelectedProducts is an array
            if (!is_array($condArr)) {
                $condArr = array();
            }

			$query = "
				SELECT p.productid
				FROM [|PREFIX|]products p
			    LEFT JOIN [|PREFIX|]categoryassociations ca on ca.productid = p.productid 
				LEFT JOIN [|PREFIX|]categories c on c.categoryid = ca.categoryid and c.catvisible = 1 
				WHERE 1=1 
				AND p.prodvisible='1'
			";
			
			if(isset($condArr['category'])&&$condArr['category']!=0)
			{
				$query .= " AND c.catparentid=".$condArr['category'];
				if(isset($condArr['subscategory'])&&$condArr['subscategory']!=0)
				{
					$query .= " AND c.categoryid=".$condArr['subscategory'];
				}
			}
			
			if(isset($condArr['brand'])&&$condArr['brand']!=0)
			{
				$query .= " AND p.prodbrandid=".$condArr['brand'];
			}
			if(isset($condArr['series'])&&$condArr['series']!=0)
			{
				$query .= " AND p.brandseriesid=".$condArr['series'];
			}
			
			$query .= "
				GROUP BY productid
			    ORDER BY productid ASC					
			";

			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$products[] = $row['productid'];     
			}
			
			return $products;
		}
	}

?>
