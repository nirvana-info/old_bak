<?php

require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'entity.base.php');

class ISC_ENTITY_PRODUCT extends ISC_ENTITY_BASE
{
	protected $tableName;
	protected $primaryKeyName;
	protected $customKeyName;
	protected $searchFields;

	public function __construct()
	{
		parent::__construct();

		$this->tableName = 'products';
		$this->primaryKeyName = 'productid';
		$this->customKeyName = '';
		$this->searchFields = array(
				'productid',
				'prodname',
				'prodcode'
		);
	}

	/**
	 * Parse the product data
	 *
	 * Method will parse the product data to be inserted into the database
	 *
	 * @access private
	 * @param array &$input The input data
	 * @return NULL
	 */
	private function parsedata(&$input)
	{



		// Workout the calculated price for this product as it will be displayed
		$input['prodcalculatedprice'] = CalcRealPrice($input['prodprice'], $input['prodretailprice'], $input['prodsaleprice'], $input['prodistaxable']);

		// If inventory tracking is on a product option basis, then product options are required
		if ($input['prodinvtrack'] == 2) {
			$input['prodoptionsrequired'] = 1;
		}

		// If we are importing and don't have any variations
		if (!array_key_exists('prodvariationid', $input)) {
			$input['prodvariationid'] = 0;
		}

		if (!array_key_exists('prodallowpurchases', $input)) {
			$input['prodallowpurchases'] = 1;
			$input['prodhideprice'] = 0;
			$input['prodcallforpricinglabel'] = '';
		}

		if (!array_key_exists('prodhideprice', $input)) {
			$input['prodhideprice'] = 0;
		}

		if (!array_key_exists('prodcallforpricinglabel', $input)) {
			$input['prodcallforpricinglabel'] = '';
		}

		//if (array_key_exists('prodcats', $input)) {
		//	$input['prodcatids'] = implode(',', $input['prodcats']);
		//} else {
			//$input['prodcatids'] = '';
		//}

		if (isset($input['prodcats']) and $input['prodcats'] != "") {
			$input['prodcatids'] = implode(',', $input['prodcats']);
		} else {
			$input['prodcatids'] = '';
		}

		if(!isset($input['prodvendorid'])) {
			$input['prodvendorid'] = 0;
		}

		if(isset($input['prodtags']) && $input['prodtags'] != '') {
			$input['prodhastags'] = 1;
		}
		else {
			$input['prodhastags'] = 0;
		}

		if(!isset($input['prodvendorfeatured'])) {
			$input['prodvendorfeatured'] = 0;
		}

		if(!isset($input['prodwrapoptions'])) {
			$input['prodwrapoptions'] = 0;
		}

		if (!isset($input['prodeventdatefieldname'])) {
			$input['prodeventdaterequired'] = 0;
			$input['prodeventdatefieldname'] = '';
			$input['prodeventdatelimited'] = 0;
			$input['prodeventdatelimitedtype'] = 0;
			$input['prodeventdatelimitedstartdate'] = 0;
			$input['prodeventdatelimitedenddate'] = 0;
		}

		$id = null;
		if (array_key_exists('productid', $input)) {
			$id = $input['productid'];
		}
		$input = array(
			'prodname' => $input['prodname'],
			'prodtype' => $input['prodtype'],
			'prodcode' => $input['prodcode'],
			'proddesc' => $input['proddesc'],
			'prodmfg' => $input['prodmfg'],
			'prodsearchkeywords' => $input['prodsearchkeywords'],
			'prodalternates' => $input['prodalternates'],
			'prodavailability' => $input['prodavailability'],
			'prodprice' => $input['prodprice'],
			'prodcostprice' => $input['prodcostprice'],
			'prodretailprice' => $input['prodretailprice'],
			'prodsaleprice' => $input['prodsaleprice'],
			'prodcalculatedprice' => $input['prodcalculatedprice'],
			'prodistaxable' => $input['prodistaxable'],
			'prodsortorder' => $input['prodsortorder'],
			'prodvisible' => $input['prodvisible'],
			'prodfeatured' => $input['prodfeatured'],
			'prodvendorfeatured' => (int)$input['prodvendorfeatured'],
			'prodrelatedproducts' => $input['prodrelatedproducts'],
			'prodinvtrack' => $input['prodinvtrack'],
			'prodcurrentinv' => $input['prodcurrentinv'],
			'prodlowinv' => $input['prodlowinv'],
			'prodoptionsrequired' => $input['prodoptionsrequired'],
			'prodwarranty' => $input['prodwarranty'],
			'prodweight' => $input['prodweight'],
			'prodwidth' => $input['prodwidth'],
			'prodheight' => $input['prodheight'],
			'proddepth' => $input['proddepth'],
			'prodfixedshippingcost' => $input['prodfixedshippingcost'],
			'prodfreeshipping' => $input['prodfreeshipping'],
			'prodbrandid' => $input['prodbrandid'],
			'prodpagetitle' => $input['prodpagetitle'],
			'prodmetakeywords' => $input['prodmetakeywords'],
			'prodmetadesc' => $input['prodmetadesc'],
			'prodlayoutfile' => $input['prodlayoutfile'],
			'prodvariationid' => $input['prodvariationid'],
			'prodallowpurchases' => $input['prodallowpurchases'],
			'prodhideprice' => $input['prodhideprice'],
			'prodcallforpricinglabel' => $input['prodcallforpricinglabel'],
			'prodcatids' => $input['prodcatids'],
			'prodlastmodified' => time(),
			'prodvendorid' => (int)$input['prodvendorid'],
			'prodhastags' => $input['prodhastags'],
			'prodwrapoptions' => $input['prodwrapoptions'],
			'prodeventdaterequired' => $input['prodeventdaterequired'],
			'prodeventdatefieldname' => $input['prodeventdatefieldname'],
			'prodeventdatelimited' => $input['prodeventdatelimited'],
			'prodeventdatelimitedtype' => $input['prodeventdatelimitedtype'],
			'prodeventdatelimitedstartdate' => $input['prodeventdatelimitedstartdate'],
			'prodeventdatelimitedenddate' => $input['prodeventdatelimitedenddate'],
			'prodmyobasset'	=> $input['prodmyobasset'],
			'prodmyobincome' => $input['prodmyobincome'],
			'prodmyobexpense' => $input['prodmyobexpense'],
			'prodpeachtreegl' => $input['prodpeachtreegl'],
			'prodvendorprefix' => $input['prodvendorprefix'],
			'proddescfeature' => $input['proddescfeature'],
			'jobberprice' => $input['jobberprice'],
			'mapprice' => $input['mapprice'],
			'unilateralprice' => $input['unilateralprice'],
			'alternativecategory' => $input['alternativecategory'],
			'complementaryitems' => $input['complementaryitems'],
			'complementaryupcharge' => $input['complementaryupcharge'],
			'ourcost' => $input['ourcost'],
            'package_length' => $input['package_length'],
			'package_width' => $input['package_width'],
			'package_height' => $input['package_height'],
			'package_weight' => $input['package_weight'],
			'brandseriesid' => $input['brandseriesid'],
            'future_retail_price' => $input['future_retail_price'],
			'future_jobber_price' => $input['future_jobber_price'],
			'prod_instruction' => $input['prod_instruction'],
			'prod_article' => $input['prod_article'],
            'skubarcode' => $input['skubarcode'],
			'price_log' => $input['price_log'],
            'SKU_last_update_time' => $input['SKU_last_update_time'],
			'price_update_time' => $input['price_update_time'],
			'install_time' => $input['install_time'],
			'testdata' => $input['testdata']
			);

		if (!is_null($id)) {
			$input['productid'] = $id;
		}
	}

	/**
	 * Add a product
	 *
	 * Method will add a product to the database
	 *
	 * @access public
	 * @param array $input The product details
	 * @return int The product record ID on success, FALSE otherwise
	 */
	public function add($input)
	{
		$this->parsedata($input);

		$input['proddateadded'] = time();

		if (!isId($id = $GLOBALS['ISC_CLASS_DB']->InsertQuery("products", $input))) {
			return false;
		}

		$this->createServiceRequest('product', 'add', $id, 'product_create');

		return $id;
	}

	/**
	 * Edit a product
	 *
	 * Method will edit a product's details
	 *
	 * @access public
	 * @param array $input The product's details
	 * @return bool TRUE if the product exists and the details were updated successfully, FALSE oterwise
	 */
	public function edit($input)
	{
		if (!array_key_exists('productid', $input) || !isId($input['productid'])) {
			return false;
		}

		$this->parsedata($input);

		if ($GLOBALS['ISC_CLASS_DB']->UpdateQuery("products", $input, "productid='" . (int)$input['productid'] . "'") === false) {
			return false;
		}

		$this->createServiceRequest('product', 'edit', $input['productid'], 'product_edit');

		return true;
	}

	/**
	 * Edit a product with the batch imported
	 *
	 * Method is used by the batch importer the edit the products details
	 *
	 * @access public
	 * @param array $input The product's details
	 * @return bool TRUE if the product exists and the details were updated successfully, FALSE oterwise
	 */
	public function bulkEdit($input)
	{
		if (!array_key_exists('productid', $input) || !isId($input['productid'])) {
			return false;
		}

		if ($GLOBALS['ISC_CLASS_DB']->UpdateQuery("products", $input, "productid='" . (int)$input['productid'] . "'") === false) {
			return false;
		}

		$this->createServiceRequest('product', 'edit', (int)$input['productid'], 'product_edit');

		return true;
	}

	/**
	 * Delete a product
	 *
	 * Method will delete a product
	 *
	 * @access public
	 * @param int $productid The product ID
	 * @return bool TRUE if the product was deleted successfully, FASLE otherwise
	 */
	public function delete($productid)
	{
		if (!isId($productid) || !($input = $GLOBALS['ISC_CLASS_DB']->Fetch($GLOBALS['ISC_CLASS_DB']->Query("SELECT * FROM [|PREFIX|]products WHERE productid='" . (int)$productid . "'")))) {
			return false;
		}

		if ($GLOBALS['ISC_CLASS_DB']->Query("DELETE FROM [|PREFIX|]products WHERE productid='" . (int)$productid . "'") !== false) {

			/**
			 * Create the spool file
			 */
			$input['isactive'] = 0;

			$this->createServiceRequest('product', 'edit', $input, 'product_delete');
			return true;
		}

		return false;
	}

	/**
	 * Delete multiple products
	 *
	 * Method will delete multiple products
	 *
	 * @access public
	 * @param array $productids The array containing the IDs of the products to delete
	 * @return bool TRUE if the products were all deleted, FASLE otherwise
	 */
	public function multiDelete($productids)
	{
		if (!is_array($productids)) {
			return false;
		}

		$productids = array_filter($productids, 'isId');

		foreach ($productids as $productid) {
			$this->delete($productid);
		}

		return true;
	}

	/**
	 * Does product exists?
	 *
	 * Method will return TRUE/FLSE depending if the product exists
	 *
	 * @access public
	 * @param int $productid The product ID
	 * @return bool TRUE if the product exists, FALASE otherwise
	 */
	public function exists($productid)
	{
		if (!isId($productid) || !ProductExists($productid)) {
			return false;
		}

		return true;
	}

	/**
	 * Get the product record
	 *
	 * Method will return the product record
	 *
	 * @access public
	 * @param int $productId The product ID
	 * @return array The product array on success, NULL if no record could be found, FALSE on error
	 */
	public function get($productId)
	{
		if (!isId($productId)) {
			return false;
		}

		$result = $GLOBALS['ISC_CLASS_DB']->Query("SELECT * FROM [|PREFIX|]products WHERE productid=" . (int)$productId);
		if (!($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result))) {
			return null;
		}

		return $row;
	}
}

?>
