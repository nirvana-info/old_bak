<?php

if (!defined('ISC_BASE_PATH')) {
	die(" ");
}

require_once(ISC_BASE_PATH."/lib/currency.php");

/**
 * Calculate the final product price. This function will calculate the final product price, including all the group/category/individual discounts
 *
 * @param array The product record array
 * @param boolean True to format price to the currency locale currency. Default is true
 * @param boolean True to convert price to the currency locale currency exchange rate. Default is true
 * @param boolean Set to true if we want to show a struck out version of the retail price if this product has one. Defaults to true
 * @return string The converted price
 */
// this function added by blessen 15-5-2009

function CalculateProductPrice_retail($product, $doLocaleFormat=true, $doCurrencyConvert=true, $strikeOutRetail=true)
{
	if (!GetConfig('ShowProductPrice') || $product['prodhideprice'] == 1) {
		return '';
	}

	$actualPrice = CalcRealPrice($product['prodprice'], $product['prodretailprice'], $product['prodsaleprice'], $product['prodistaxable']);
	$actualPrice = CalcProdCustomerGroupPrice($product, $actualPrice);

	// Calculate the actual price for this product in the current currency
	if($doCurrencyConvert == true) {
		$actualPrice = ConvertPriceToCurrency($actualPrice);
	}

	$output = '';

	if($doLocaleFormat) {
		// Does this product have a RRP?
		if ($actualPrice > 0 && $actualPrice < $product['prodretailprice'] && $strikeOutRetail == true) {
			$rrp = CalcProdCustomerGroupPrice($product, $product['prodretailprice']);
			$rrp = ConvertPriceToCurrency($product['prodretailprice']);

			// $output .= '<strike>'.FormatPrice($rrp).'</strike> ';
			$output .= FormatPrice($rrp);
		}
	}
 if ($actualPrice > 0 && $actualPrice > $product['prodretailprice'])
	{
	if ($product['prodsaleprice'] > 0 && $product['prodsaleprice'] < $product['prodprice']) {
		$output .= '<span class="SalePrice">'.FormatPrice($actualPrice).'</span>';
	} else {
		$output .= FormatPrice($actualPrice);
	}
	}
	return $output;
}

/**
 * Calculate the final product price. This function will calculate the final product price, including all the group/category/individual discounts
 *
 * @param array The product record array
 * @param boolean True to format price to the currency locale currency. Default is true
 * @param boolean True to convert price to the currency locale currency exchange rate. Default is true
 * @param boolean Set to true if we want to show a struck out version of the retail price if this product has one. Defaults to true
 * @return string The converted price
 */
// this function added by blessen 15-5-2009

function CalculateProductPriceRetail($product, $doLocaleFormat=true, $doCurrencyConvert=true, $strikeOutRetail=true)
{
    if (!GetConfig('ShowProductPrice') || $product['prodhideprice'] == 1) {
        return '';
    }

    $actualPrice = CalcRealPrice($product['prodprice'], $product['prodretailprice'], 0.0000, $product['prodistaxable']);
    $actualPrice = CalcProdCustomerGroupPrice($product, $actualPrice);

    // Calculate the actual price for this product in the current currency
    if($doCurrencyConvert == true) {
        $actualPrice = ConvertPriceToCurrency($actualPrice);
    }

    $output = '';

    if($doLocaleFormat) {
        // Does this product have a RRP?
        if ($actualPrice > 0 && $actualPrice < $product['prodretailprice'] && $strikeOutRetail == true) {
            $rrp = CalcProdCustomerGroupPrice($product, $product['prodretailprice']);
            $rrp = ConvertPriceToCurrency($product['prodretailprice']);

            // $output .= '<strike>'.FormatPrice($rrp).'</strike> ';
            $output .= FormatPrice($rrp);
        }
    }
 if ($actualPrice > 0 && $actualPrice > $product['prodretailprice'])
    {
        if ($product['prodsaleprice'] > 0 && $product['prodsaleprice'] < $product['prodprice']) {
            $output .= '<span class="SalePrice">'.FormatPrice($actualPrice).'</span>';
        } else {
            $output .= FormatPrice($actualPrice);
        }
    }
    return $actualPrice;
}

function CalculateProductPrice($product, $doLocaleFormat=true, $doCurrencyConvert=true, $strikeOutRetail=true)
{
	if (!GetConfig('ShowProductPrice') || $product['prodhideprice'] == 1) {
		return '';
	}

	$actualPrice = CalcRealPrice($product['prodprice'], $product['prodretailprice'], $product['prodsaleprice'], $product['prodistaxable']);
	$actualPrice = CalcProdCustomerGroupPrice($product, $actualPrice);

	// Calculate the actual price for this product in the current currency
	if($doCurrencyConvert == true) {
		$actualPrice = ConvertPriceToCurrency($actualPrice);
	}

	$output = '';

	if($doLocaleFormat) {
		// Does this product have a RRP?
		if ($actualPrice > 0 && $actualPrice < $product['prodretailprice'] && $strikeOutRetail == true) {
			$rrp = CalcProdCustomerGroupPrice($product, $product['prodretailprice']);
			$rrp = ConvertPriceToCurrency($product['prodretailprice']);

			$output .= '<strike>'.FormatPrice($rrp).'</strike> ';
		}
	}

	if ($product['prodsaleprice'] > 0 && $product['prodsaleprice'] < $product['prodprice']) {
		$output .= '<span class="SalePrice">'.FormatPrice($actualPrice).'</span>';
	} else {
		$output .= FormatPrice($actualPrice);
	}

	return $output;
}

/**
 * Determine the group based price for a particular product.
 *
 * @param array Array of information for the product.
 * @param string The price we want to fetch the adjusted value for.
 * @param int The group id to fetch the pricing for. If none specified, the current customers group is used.
 */
function CalcProdCustomerGroupPrice($product, $price, $groupId=null)
{

	// If the group is not passed, get the group for the current customer
	$GLOBALS['ISC_CLASS_CUSTOMER'] = GetClass('ISC_CUSTOMER');
	if($groupId === null && !defined('ISC_ADMIN_CP')) {
		$group = $GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerGroup();
	}
	else if($groupId === 0) {
		return $price;
	}
	else {
		$group = $GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerGroup($groupId);
	}

	// If here isn't a customer group then we just return the price we already had
	if(!is_array($group)) {
		return $price;
	}

	// Does this product have a custom price?
	if(isset($product['prodgroupdiscount']) && $product['prodgroupdiscount'] > 0) {
		return CalculateDiscount($price,$product['discountmethod'], $product['prodgroupdiscount']);
	}

	// Do we have a group price for any of the categories this product is in?
	$categories = explode(',', $product['prodcatids']);
	$discountPrice = 0;

	foreach($categories as $category) {
		$catDiscount = GetGroupCategoryDiscount($group['customergroupid'], $category);

		if(isset($catDiscount['discountAmount'])) {
			$currentDiscountPrice=CalculateDiscount($price, $catDiscount['discountMethod'], $catDiscount['discountAmount']);

			//get the lowest discount for the product
			if($discountPrice != 0) {
				$discountPrice = min($discountPrice, $currentDiscountPrice);
			} else {
				$discountPrice = $currentDiscountPrice;
			}
		}
	}

	if($discountPrice> 0) {
		return $discountPrice;
	}

	// Otherwise, if the group has a default discount then we use it
	if($group['discount'] > 0) {
	//	$price -= $price * ($group['discount'] / 100);


		$price = CalculateDiscount($price, $group['discountmethod'], $group['discount']);


		return $price;
	}

	return $price;
}

function CalculateDiscount($price, $discountMethod, $discount)
{
	//percentage discount
	if($discountMethod=='percent') {
		$price -= $price * ($discount / 100);
	}

	//price discount
	elseif($discountMethod=='price') {
		$price = $price - $discount;

	//fix price discount
	} elseif($discountMethod=='fixed') {
		$price = $discount;
	}

	if($price < 0) {
		$price = 0;
	}

	return $price;
}


function CalculateCustGroupDiscount($productId, $price, $custGroup=null)
{
	static $products = array();

	//apply customer group discount on top of the quantity discount
	if(!isset($products[$productId])) {
		$query = "
			SELECT p.*, ".GetProdCustomerGroupPriceSQL()."
			FROM [|PREFIX|]products p
			WHERE p.productid='".(int)$productId."'
		";
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		$products[$productId] = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
	}

	$price = CalcProdCustomerGroupPrice($products[$productId], $price, $custGroup);
	return $price;
}

/**
 * Fetch the discount percentage for a particular customer group in a specific category. This will read
 * the data from the data store based on the passed group id.
 *
 * @param int The group ID to fetch the discount for.
 * @param int The category ID to fetch the discount for this group of.
 * @return string The discount that applies to this group.
 */
function GetGroupCategoryDiscount($groupId, $categoryId)
{
	$customerGroup = $GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerGroup($groupId);

	// If the group doesn't exist, it's a 0% discount of course!
	if(!isset($customerGroup['customergroupid'])) {
		return 0;
	}

	$groupCacheData = $GLOBALS['ISC_CLASS_DATA_STORE']->Read('CustomerGroupsCategoryDiscounts', false, $groupId);
	if(isset($groupCacheData[$categoryId])) {
		return $groupCacheData[$categoryId];
	}
	else {
		return 0;
	}
}
/**
 * Build a portion of the SQL query to be used in product queries to fetch out any pricing information for the each
 * product with the group that the current customer is in.
 *
 * @param mixed The group ID to build the SQL for. If null, the current customers group will be used. Otherwise, a group ID.
 * @param string The alias for the products table in the query. Defaults to 'p', but can be changed to whatever the query uses.
 * @return string The SQL to fetch the product pricing for this group.
 */
function GetProdCustomerGroupPriceSQL($groupId=null, $prodTable = 'p')
{
	// If the group is not passed, get the group for the current customer
	$GLOBALS['ISC_CLASS_CUSTOMER'] = GetClass('ISC_CUSTOMER');
	if($groupId === 0) {
		return '0 AS prodgroupdiscount';
	}
	if($groupId === null && !defined('ISC_ADMIN_CP')) {
		$group = $GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerGroup();
	}
	else {
		$group = $GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerGroup($groupId);
	}

	// If here isn't a customer group then we just return a simple query that returns 0 for the price
	if(!is_array($group)) {
		return '0 AS prodgroupdiscount';
	}

	else {
		return "(SELECT discountpercent FROM [|PREFIX|]customer_group_discounts disc WHERE disc.discounttype='PRODUCT' AND disc.customergroupid='".$group['customergroupid']."' AND disc.catorprodid=".$prodTable.".productid) AS prodgroupdiscount, (SELECT discountmethod FROM [|PREFIX|]customer_group_discounts disc WHERE disc.discounttype='PRODUCT' AND disc.customergroupid='".$group['customergroupid']."' AND disc.catorprodid=".$prodTable.".productid) AS discountmethod";
	}
}

/**
 * Generate an INNER JOIN SQL statement to be used to ensure a customer can only view products
 * in the categories they have permission to view.
 *
 * @param int The group ID to fetch the permissions SQL for. If null, the current group of the customer is used.
 * @return string The SQL to be appended to product queries to determine the list of viewable products.
 */
function GetProdCustomerGroupPermissionsSQL($groupId=null, $PrependAdd=true)
{
	// If the group is not passed, get the group for the current customer
	$GLOBALS['ISC_CLASS_CUSTOMER'] = GetClass('ISC_CUSTOMER');
	if($groupId == null) {
		$group = $GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerGroup();
	}
	else {
		$group = $GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerGroup($groupId);
	}

	// If here isn't a customer group then they have access
	if(!is_array($group)) {
		return '';
	}
	else if($group['categoryaccesstype'] == 'all') {
		return '';
	}
	else if ($group['categoryaccesstype'] == "none") {
		$categories[] = 0;
	}
	else {
		$categories = $group['accesscategories'];
	}

	$query = '(SELECT caperm.productid
				FROM  [|PREFIX|]categoryassociations caperm
				WHERE caperm.productid = p.productid AND caperm.categoryid IN (' . implode(",", $categories) . ')
				LIMIT 1)';

	if($PrependAdd) {
		return ' AND '.$query;
	} else {
		return $query;
	}
}

/**
 * Check if a customer group has access to a particular category.
 *
 * @param int The ID of the category to check the permissions for.
 * @param int The group ID to check for the category permissions. If null, the current customers group is used.
 * @return boolean True if the customer has access to the particular category, false if not.
 */
function CustomerGroupHasAccessToCategory($categoryId, $groupId=null)
{
	// If the group is not passed, get the group for the current customer
	$GLOBALS['ISC_CLASS_CUSTOMER'] = GetClass('ISC_CUSTOMER');
	if($groupId == null) {
		$group = $GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerGroup();
	}
	else {
		$group = $GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerGroup($groupId);
	}

	// If here isn't a customer group then they have access
	if(!is_array($group)) {
		return true;
	}

	switch ($group['categoryaccesstype']) {
		case "all":
			return true;
		case "specific":
			if (in_array($categoryId, $group['accesscategories'])) {
				return true;
			}
	}

	return false;
}

/**
 * Convert and format a price
 *
 * Function will convert and format a price. Function is a wrapper for FormatPrice and FormatCurrency
 *
 * @access public
 * @param float $price The price to convert and format
 * @param array $currency The currency record array. Default is the one stored within the currency session
 * @return string The converted and formatted price
 */
function CurrencyConvertFormatPrice($price, $currency=null, $exchangeRate=null, $includeCurrencyCode=false)
{
	$price = ConvertPriceToCurrency($price, $currency, $exchangeRate, null);
	return FormatPrice($price, false, true, false, $currency, $includeCurrencyCode);
}

/**
 * Format the price
 *
 * Function will format the price based on the currency record that is provided. The default currency record will be the
 * one stored in the current session
 *
 * @access public
 * @param float $price The price to format
 * @param array $currency The currency record. Default is the one stored within the currency session
 * @return string The formatted price
 */
function FormatPrice($price, $strip_decimals=false, $add_token=true, $strip_thousandsep=false, $currency=null, $includeCurrencyCode=false)
{
	if (is_null($currency)) {
		if(!isset($GLOBALS['CurrentCurrency'])) {
			$defaultCurrency = GetDefaultCurrency();
			$GLOBALS['CurrentCurrency'] = $defaultCurrency['currencyid'];
		}
		$currency = GetCurrencyById($GLOBALS['CurrentCurrency']);
	}

	if(!is_array($currency)) {
		$currency = GetCurrencyById($currency);
	}

	if(!isset($currency['currencyid'])) {
		$currency = GetDefaultCurrency();
	}

	if ($strip_thousandsep) {
		$currency['currencythousandstring'] = '';
	}

	$num = number_format($price, $currency['currencydecimalplace'], $currency['currencydecimalstring'], $currency['currencythousandstring']);
	// Do we strip decimal places? If so just return the whole number portion
	if ($strip_decimals) {
		$tmp = explode($currency['currencydecimalstring'], $num);
		$num = $tmp[0];
	}

	if ($add_token) {
		if (strtolower($currency['currencystringposition']) == "left") {
			$num = $currency['currencystring'] . $num;
		}
		else {
			$num = $num . $currency['currencystring'];
		}
	}

	if($includeCurrencyCode == true) {
		$num .= ' '.$currency['currencycode'];
	}

	return $num;
}

/**
 * Calculate the price adjustment for a variation of a product.
 *
 * @var decimal The base price of the product.
 * @var string The type of adjustment to be performed (empty, add, subtract, fixed)
 * @var decimal The value to be adjusted by
 * @return decimal The adjusted value
 */
function CalcProductVariationPrice($basePrice, $type, $difference, $product=null)
{
	switch (strtolower($type)) {
		case "fixed":
			$newPrice = $difference;
			break;
		case "add":
			$newPrice = $basePrice + $difference;
			break;
		case "subtract":
			$adjustedCost = $basePrice - $difference;
			if($adjustedCost <= 0) {
				$adjustedCost = 0;
			}
			$newPrice = $adjustedCost;
			break;
		default:
			$newPrice =$basePrice;
	}

	if(!is_null($product)) {
		$newPrice = CalcProdCustomerGroupPrice($product, $newPrice);
	}

	return $newPrice;
}

function CalcRealPrice($price, $retailprice=0, $saleprice=0, $istaxable=0)
{
	// Calculate the real price for this product based on tax, sale price, etc

	// Do we need to add tax to the price? We only do this if prices don't include tax and we have tax set up on a GLOBAL level
	if (!GetConfig('PricesIncludeTax') && GetConfig('TaxTypeSelected') == 2 && $istaxable) {
		$price += ($price/100 * GetConfig('DefaultTaxRate'));
	}

	// Is this product on sale?
	if ($saleprice > 0) {
		if (!GetConfig('PricesIncludeTax') && GetConfig('TaxTypeSelected') == 2 && $istaxable) {
			$price = $saleprice + ($saleprice/100 * GetConfig('DefaultTaxRate'));
		} else {
			$price = $saleprice;
		}
	}

	return $price;
}


/**
* DefaultPriceFormat
* Convert a localized price (such as 45,99) to the standard western format of 45.99 for storage in the database
*
* @param Float $Price The price to convert
* @return Float
*/
function DefaultPriceFormat($Val)
{
	$regex = "#[^0-9";
	$regex .= "\\" . GetConfig('DecimalToken');
	$regex .= "\\" . GetConfig('ThousandsToken');
	$regex .= "]+#i";

	$Val = preg_replace($regex, "", $Val);
	$Val = str_replace(GetConfig('ThousandsToken'), "", $Val);
	$Val = str_replace(GetConfig('DecimalToken'), ".", $Val);
	$Val = number_format($Val, GetConfig('DecimalPlaces'), ".", "");
	return $Val;
}

function CPrice($Val)
{
	$val = CFloat($Val);
	$val = number_format($val, GetConfig('DecimalPlaces'), GetConfig('DecimalToken'), GetConfig('ThousandsToken'));
	return $val;
}

/**
 * Get a bulk discount record by quantity
 *
 * Function will return a bulk discount record based upon the quantity
 *
 * @access public
 * @param int $productId The product ID
 * @param int $quantity The quantity amount of products purchased
 * @param bool $overrideEnabled Set to TRUE to override the BulkDiscountEnabled config setting. Default is TRUE
 * @return array The bulk discount record on success, FALSE otherwise
 */
function GetBulkDiscountByQuantity($productId, $quantity, $overrideEnabled=true)
{
	// Check to see if we are set to do this
	if (!GetConfig('BulkDiscountEnabled') && !$overrideEnabled) {
		return false;
	}

	$discounts = array();
	$query = "
		SELECT *
		FROM [|PREFIX|]product_discounts
		WHERE discountprodid='".(int)$productId."'
		ORDER BY IF(discountquantitymax = 0, discountquantitymin, discountquantitymax)
	";
	$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
	while($discount = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
		$discounts[] = $discount;
	}

	if (empty($discounts)) {
		return false;
	}

	// Are we in one of our discount ranges? Firstly we need to fill in the blanks due to '0' being wildcards
	for ($i=0; $i<count($discounts); $i++) {

		// Check for the min quantity
		if ($discounts[$i]['discountquantitymin'] == 0) {
			if ($i > 0) {
				$discounts[$i]['discountquantitymin'] = $discounts[$i-1]['discountquantitymax']+1;
			} else {
				$discounts[$i]['discountquantitymin'] = 0;
			}
		}

		// Check for the max quantity
		if ($discounts[$i]['discountquantitymax'] == 0) {
			for ($j=$i+1; $j<count($discounts); $j++) {
				if ($discounts[$j]['discountquantitymin'] > 0) {
					$discounts[$i]['discountquantitymax'] = $discounts[$j]['discountquantitymin']-1;
					break;
				}
				if ($discounts[$j]['discountquantitymax'] > 0) {
					$discounts[$i]['discountquantitymax'] = $discounts[$j]['discountquantitymax']-1;
					break;
				}
			}

			// If we couldn't find any either then invent the unlimited number or assign -1
			if ($discounts[$i]['discountquantitymax'] == 0) {
				$discounts[$i]['discountquantitymax'] = -1;
			}
		}
	}

	// OK we have our filtered ranges, now we see if our quantity is in there
	foreach ($discounts as $discount) {
		if ($quantity >= $discount['discountquantitymin'] && ($quantity <= $discount['discountquantitymax'] || $discount['discountquantitymax'] == -1)) {
			return $discount;
		}
	}

	return false;
}

?>