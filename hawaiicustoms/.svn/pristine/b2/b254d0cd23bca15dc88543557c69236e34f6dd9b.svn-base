<?php
	require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'class.api.php');

	class API_CATEGORY extends API
	{
		// {{{ Class variables
		var $fields = array (
			'categoryid',
			'catname',
			'catdesc',
			'catparentid',
			'catviews',
			'catsort',
			'catpagetitle',
			'catmetakeywords',
			'catmetadesc',
			'catlayoutfile',
			'catparentlist',
			'catimagefile',
            'catdeptid',
            'cataltkeyword',
            'catuserid',
            'catvisible',
            'catcombine',
			'StartPrice',
			'EndPrice',
			'Productname',
            'categoryfooter',
			'controlscript',
			'trackingscript',
			'catimagealt',
			'cathoverimagefile',
			'featurepoints',
			'divdesc',
			'displayproducts',
			//wirror_20100804: add customcontentid & pagecontenttype fields to category
			'pagecontenttype',
			'customcontentid'
		);
		//wirror_20100804: add customcontentid & pagecontenttype fields to category
		var $customcontentid = 0;
		var $pagecontenttype = 0;
		var $categoryid = 0;
		var $catname = '';
		var $catdesc = '';
		var $catparentid = 0;
		var $catsort = 0;
		var $catviews = 0;
		var $catpagetitle = '';
		var $catmetakeywords = '';
		var $catmetadesc = '';
		var $catlayoutfile = '';
		var $catparentlist = '';
		var $catimagefile = '';
		var $catdeptid = '';
        var $cataltkeyword = '';
		var $catuserid = '';
        var $catvisible = '';
        var $catcombine = '';
		var $StartPrice = '';
        var $EndPrice = '';
		var $Productname = '';
        var $categoryfooter = '';
		var $controlscript = '';
        var $trackingscript = '';
		var $catimagealt = '';
		var $cathoverimagefile = '';
		var $featurepoints = '';
		var $divdesc = '';
		var $displayproducts = '';
		// }}}

		// {{{ setupDatabase()
		/**
		* Setup the connection to the database and some other database
		* properties
		*
		* @return void
		*/
		function setupDatabase()
		{
			$this->db = $GLOBALS['ISC_CLASS_DB'];
			$tableSuffix = 'categories';
			$this->table = '[|PREFIX|]'.$tableSuffix;
			$this->tablePrefix = '[|PREFIX|]';
		}
		// }}}

		/**
		* Create a new item in the database
		*
		* @return mixed false if failed to create, the id of the item otherwise
		*/
		function create()
		{
			$_POST['catparentlist'] = '';
			$_POST['catviews'] = 0;
			//if (!$this->CategoryExists($_POST['catparentid'], $_POST['catname'])) {
            if (!$this->CategoryExists($_POST['catparentid'], $_POST['catname']) && !$GLOBALS['ISC_CLASS_ADMIN_CATEGORY']->BrandSeriesDuplicationExists($_POST['catname'])) {  //Commented & Changed by Simha
            
				$CatId = parent::create();

				// If the save was successful, build the parent list
				if($CatId) {
					$parentList = $this->BuildParentList($CatId);
					$updatedCategory = array(
						"catparentlist" => $parentList
					);
					$GLOBALS['ISC_CLASS_DB']->UpdateQuery("categories", $updatedCategory, "categoryid='".$GLOBALS['ISC_CLASS_DB']->Quote($CatId)."'");
				}

				// If the category doesn't have a parent, rebuild the root categories cache
				if($_POST['catparentid'] == 0) {
					$GLOBALS['ISC_CLASS_DATA_STORE']->UpdateRootCategories();
				}

				// Rebuild the group pricing caches
				$GLOBALS['ISC_CLASS_DATA_STORE']->UpdateCustomerGroupsCategoryDiscounts();

				return $CatId;
			} else {
				//$this->error = sprintf(GetLang('apiCatAlreadyExists'), $_POST['catname']);
				$this->error = sprintf(GetLang('NameAlreadyExists'), $_POST['catname']); //Commented and changed by Simha
				
				return false;
			}
		}

		/**
		* delete
		* Delete a category, if $id is given and is positive then delete it and
		* delete any category associations it may have
		*
		* @param int $id The id of the category to delete
		*
		* @return bool Was the delete successful ?
		*/
		function delete($id=0)
		{
			if (!parent::delete()) {
				return false;
			}

			// Now need to fetch any child categories of this category and delete them too
			$parentStack = array();
			$parentStack[] = $id;
			$child_cats[] = $id;
			while(count($parentStack) > 0)
			{
				$parent = array_pop($parentStack);
				if($parent === false) {
					break;
				}
				$query = "SELECT catname, categoryid FROM ".$this->tablePrefix."categories WHERE catparentid='".$this->db->Quote((int)$parent)."'";
				$result = $this->db->Query($query);
				while($category = $this->db->Fetch($result)) {
					$child_cats[] = $category['categoryid'];
					$parentStack[] = $category['categoryid'];
				}
			}

			// Now we have a list of the child categories so delete them too
			$query = "DELETE FROM ".$this->tablePrefix."categories WHERE categoryid IN (".(implode(',', $child_cats)).")";
			$this->db->Query($query);

			// Delete any products in this category
			$this->DeleteCategoryProducts($child_cats);

			// If the category doesn't have a parent, rebuild the root categories cache
			$GLOBALS['ISC_CLASS_DATA_STORE']->UpdateRootCategories();

			// Rebuild the group pricing caches
			$GLOBALS['ISC_CLASS_DATA_STORE']->UpdateCustomerGroupsCategoryDiscounts();


			return true;
		}

		/**
		* Delete multiple categories in one database query, useful for bulk
		* actions
		*
		* @param $ids array The array of ids to delete.
		*
		* @return boolean Return true on successful deletion
		*/
		function multiDelete($ids=0)
		{
			if (!parent::multiDelete($ids)) {
				return false;
			}

			$ids = array_keys($ids);

			// Now need to fetch any child categories of this category and delete them too
			$parentStack = array();
			foreach($ids as $id) {
				$parentStack[] = $id;
				$child_cats[] = $id;
				while(count($parentStack) > 0) {
					$parent = array_pop($parentStack);
					if($parent === false) {
						break;
					}
					$query = "SELECT catname, categoryid FROM ".$this->tablePrefix."categories WHERE catparentid='".$this->db->Quote((int)$parent)."'";
					$result = $this->db->Query($query);
					while($category = $this->db->Fetch($result)) {
						$child_cats[] = $category['categoryid'];
						$parentStack[] = $category['categoryid'];
					}
				}
			}

			// Rebuild the group pricing caches
			$GLOBALS['ISC_CLASS_DATA_STORE']->UpdateCustomerGroupsCategoryDiscounts();

			// If the category doesn't have a parent, rebuild the root categories cache
			$GLOBALS['ISC_CLASS_DATA_STORE']->UpdateRootCategories();

			// Now we have a list of the child categories so delete them too
			$query = "DELETE FROM ".$this->tablePrefix."categories WHERE categoryid IN (".(implode(',', $child_cats)).")";
			$this->db->Query($query);

			// Delete any category associations we have
			$this->DeleteCategoryProducts($child_cats);
			return true;
		}

		/**
		 * DeleteCategoryProducts
		 * Delete any products associated with any of the listed categories
		 *
		 * @param array $ids Array of IDs for the categories being removed
		 */
		function DeleteCategoryProducts($ids)
		{
			if(!is_array($ids)) {
				$ids = array($ids);
			}

			// Delete any category associations
			$query = "DELETE FROM ".$this->tablePrefix."categoryassociations WHERE categoryid IN (".implode(",", $ids).")";
			$this->db->Query($query);

			// Now we check to see if there are any products without an associated category & remove them too
			$productIds = array();
			$query = "SELECT p.prodname, p.productid FROM ".$this->tablePrefix."products p LEFT JOIN ".$this->tablePrefix."categoryassociations ca ON (ca.productid=p.productid) WHERE ca.categoryid IS NULL";
			$result = $this->db->Query($query);
			while($product = $this->db->Fetch($result)) {
				$productIds[] = $product['productid'];
			}
			// Any products to delete?
			if(count($productIds) > 0) {
				$GLOBALS['ISC_CLASS_ADMIN_PRODUCT'] = GetClass('ISC_ADMIN_PRODUCT');
				$GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->DoDeleteProducts($productIds);
			}
		}

		/**
		* CategoryExists
		* Check to see if a category with a given name exists under a given
		* parent categoryid
		*
		* @param int $parentid The id of the parent
		* @param int $name The name of the category
		*
		* @return boolean Does the category exist or not ?
		*/
		function CategoryExists($parentid, $name)
		{
			if (!$this->is_positive_int($parentid)) {
				return false;
			}

			$query = "SELECT COUNT(*)
			FROM [|PREFIX|]categories
			WHERE catparentid='".$this->db->Quote($parentid)."'
			AND catname='".$this->db->Quote($name)."'";

			$result = $this->db->Query($query);

			$num = $this->db->FetchOne($result);

			if ($num > 0) {
				return true;
			} else {
				return false;
			}
		}

		/**
		* validate_categoryid
		*
		* Ensure the categoryid is a pos int
		*
		* @param string $var
		*
		* @return bool
		*/
		function validate_categoryid($var)
		{
			return $this->is_positive_int($var);
		}

		/**
		* validate_catname
		*
		* Ensure the name isn't empty or too long
		*
		* @param string $var
		*
		* @return bool
		*/
		function validate_catname($var)
		{
			if (empty($var)) {
				$this->error = GetLang('apiCatNameEmpty');
				return false;
			}

			if (isc_strlen($var) > 100) {
				$this->error = GetLang('apiCatNameLong');
				return false;
			}

			// Make sure a category cannot be renamed to have the same name
			// as an existing category at the same level
			if ($this->loaded) {
				if ($this->CategoryExists($this->parentid, $var)) {
					$this->error = GetLang('apiCatAlreadyExists');
					return false;
				}
			}

			return true;
		}

		/**
		* validate_catparentid
		*
		* Ensure the catparentid is a pos int
		*
		* @param string $var
		*
		* @return bool
		*/
		function validate_catparentid($var)
		{
			return $this->is_positive_int($var);
		}

		/**
		* validate_catviews
		*
		* Ensure the catviews is a pos int
		*
		* @param string $var
		*
		* @return bool
		*/
		function validate_catviews($var)
		{
			return $this->is_positive_int($var);
		}

		/**
		 * Build the parent list for a particular category.
		 *
		 * @param int The category ID
		 * @return string The build parent list
		 */
		function BuildParentList($catid)
		{
			static $catcache, $i;

			if(!$catcache) {
				$query = "SELECT categoryid, catparentid FROM [|PREFIX|]categories";
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					$catcache[$row['categoryid']] = $row;
				}
			}

			$trail = '';

			if(isset($catcache[$catid])) {
				$category = $catcache[$catid];
				if(isset($catcache[$category['catparentid']])) {
					$trail = $this->BuildParentList($category['catparentid']) . $trail;
				}
				if($trail != '') {
					$trail .= ',';
				}
				$trail .= $category['categoryid'];
			}
			return $trail;

		}
	}

?>