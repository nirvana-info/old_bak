<?php
class ISC_ADMIN_IMPORTFILETYPE_PRODUCTS extends ISC_ADMIN_IMPORTFILETYPE
{
	protected $type_name = "products";
	protected $type_icon = "product.gif";
	protected $type_idfield = "p.productid";
	protected $type_viewlink = "index.php?ToDo=viewProducts";

	protected $handlecats = false;
	protected $handlevars = false;

	protected $options; // variation options cache

	private $tableName = '[|PREFIX|]products p';



	public function GetFields()
	{
		$fields = array(
			"productName"			=> array("dbfield" => "prodname"),
			"productBrand"			=> array("dbfield" => "brandname"),
			"productDesc"			=> array("dbfield" => "proddesc", "format" => "text"),
			"productTaxable"		=> array("dbfield" => "prodistaxable", "format" => "bool"),
			"productCostPrice"		=> array("dbfield" => "prodcostprice", "format" => "number"),
			"productRetailPrice"	=> array("dbfield" => "prodretailprice", "format" => "number"),
			"productSalePrice"		=> array("dbfield" => "prodsaleprice", "format" => "number"),
			"productCalculatedPrice"=> array("dbfield" => "prodcalculatedprice", "format" => "number"),
			"productShippingPrice"	=> array("dbfield" => "prodfixedshippingcost", "format" => "number"),
			"productFreeShipping"	=> array("dbfield" => "prodfreeshipping", "format" => "bool"),
			"productWarranty"		=> array("dbfield" => "prodwarranty"),
			"productWeight"			=> array("dbfield" => "prodweight"),
			"productWidth"			=> array("dbfield" => "prodwidth"),
			"productHeight"			=> array("dbfield" => "prodheight"),
			"productDepth"			=> array("dbfield" => "proddepth"),
			"Category"	=> array("dbfield" => "p.productid"),
			"SubCategory"	=> array("dbfield" => "p.productid")			
			
		);

 

$fields["prodvendorprefix"] = array("dbfield" => "prodvendorprefix");
$fields["jobberprice"] = array("dbfield" => "jobberprice");
$fields["mapprice"] = array("dbfield" => "mapprice");
$fields["unilateralprice"] = array("dbfield" => "unilateralprice");

$fields["ourcost"] = array("dbfield" => "ourcost");
$fields["package_length"] = array("dbfield" => "package_length");
$fields["package_height"] = array("dbfield" => "package_height");
$fields["package_weight"] = array("dbfield" => "package_weight");

$fields["SeriesName"] = array("dbfield" => "brandseriesid");
$fields["future_retail_price"] = array("dbfield" => "future_retail_price");
$fields["future_jobber_price"] = array("dbfield" => "future_jobber_price");
$fields["Vendor"] = array("dbfield" => "prodvendorid");

$fields["ProdInstruction"] = array("dbfield" => "prod_instruction");
$fields["InstructionFile"] = array("dbfield" => "instruction_file");
$fields["Article"] = array("dbfield" => "prod_article");
$fields["ArticleFile"] = array("dbfield" => "article_file");
$fields["InstallVideos"] = array("dbfield" => "p.productid");
$fields["ProductVideos"] = array("dbfield" => "p.productid");
$fields["InstallImages"] = array("dbfield" => "p.productid");
$fields["AudioClips"] = array("dbfield" => "p.productid");
$fields["ProductImages"] = array("dbfield" => "p.productid");

$fields["Make"] = array("dbfield" => "p.productid");
$fields["Model"] = array("dbfield" => "p.productid");
$fields["Submodel"] = array("dbfield" => "p.productid");
$fields["StartYear"] = array("dbfield" => "p.productid");
$fields["EndYear"] = array("dbfield" => "p.productid");
$fields["PartNumber"] = array("dbfield" => "p.productid");



//$query = "SELECT * FROM [|PREFIX|]import_variations";
//$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
//$columns = mysql_num_fields($result); 
//for($i = 2; $i < $columns; $i++) { 
//		$temp = mysql_field_name($result,$i); 
// 		$fields[$temp] = array("dbfield" => $temp);
//} 


return $fields;
	}

	
	protected function GetQuery($columns, $where, $vendorid)
	{
		
		if ($vendorid) {
			if ($where) {
				$where .= " AND ";
			}
			$where .= "p.prodvendorid = '" . $vendorid . "'";
		}

		if ($where) {
			$where = " WHERE " . $where;
		}

if (isset($_SESSION['searchresults'])) 
			{
				$where = $_SESSION['searchresults'];
			}


$columns = str_replace("prodcode AS prodcode", "iv.prodcode AS prodcode", $columns);
//$columns = str_replace("videoprodid AS videoprodid", "iv.videoprodid AS videoprodid", $columns);
//LEFT JOIN [|PREFIX|]install_videos inv ON p.productid = inv.videoprodid




if ($columns != "") $columns =  $columns." , ";

	 $query = "
			SELECT "
				. $columns . "
				prodvendorid,
				(SELECT GROUP_CONCAT(ca.categoryid SEPARATOR ',') FROM [|PREFIX|]categoryassociations ca WHERE p.productid = ca.productid) AS categoryids
			FROM
				(
					SELECT
						DISTINCT ca.productid
					FROM
						[|PREFIX|]categoryassociations ca
						INNER JOIN [|PREFIX|]products p ON p.productid = ca.productid
									" . $where . "
				) AS ca
				INNER JOIN [|PREFIX|]products p ON p.productid = ca.productid
				LEFT JOIN [|PREFIX|]import_variations iv ON p.productid = iv.productid	LEFT JOIN [|PREFIX|]brands b ON b.brandid = p.prodbrandid ";


	return $query;




	}

	public function GetListColumns()
	{
		$columns = array(
			"ID",
			"SKU",
			"Name",
			"Price",
			"Visible",
			"Featured"
		);

		return $columns;
	}

	public function GetListSortLinks()
	{
		$sortLinks = array(
			"ID" => "productid",
			"SKU" => "prodcode",
			"Name" => "prodname",
			"Price" => "prodprice",
			"Visible" => "prodvisible",
			"Featured" => "prodfeatured"
		);

		return $sortLinks;
	}

	public function GetListQuery($where, $vendorid, $sortField, $sortOrder)
	{
		SetupCurrency();

		if ($vendorid) {
			if ($where) {
				$where .= " AND ";
			}
			$where .= "p.prodvendorid = '" . $vendorid . "'";
		}

		if ($where) {
			$where = "WHERE " . $where;
		}

		$query = "
				SELECT
					p.productid,
					p.prodcode,
					p.prodname,
					p.prodprice,
					p.prodvisible,
					p.prodfeatured
				FROM
					(
						SELECT
							DISTINCT ca.productid
						FROM
							[|PREFIX|]categoryassociations ca
							INNER JOIN [|PREFIX|]products p ON p.productid = ca.productid
							INNER JOIN [|PREFIX|]product_search ps ON p.productid = ps.productid
							LEFT JOIN [|PREFIX|]brands b ON b.brandid = p.prodbrandid
							" . $where . "
						ORDER BY
							" . $sortField . " " . $sortOrder . "
					) AS ca
					INNER JOIN [|PREFIX|]products p ON p.productid = ca.productid
				";

		return $query;
	}

	public function GetListCountQuery($where, $vendorid)
	{
		if ($vendorid) {
			if ($where) {
				$where .= " AND ";
			}
			$where .= "p.prodvendorid = '" . $vendorid . "'";
		}

		if ($where) {
			$where = "WHERE " . $where;
		}

		$query = "
				SELECT
					COUNT(DISTINCT p.productid) AS ListCount
				FROM
					[|PREFIX|]categoryassociations ca
					INNER JOIN [|PREFIX|]products p ON p.productid = ca.productid
					INNER JOIN [|PREFIX|]product_search ps ON p.productid = ps.productid
					LEFT JOIN [|PREFIX|]brands b ON b.brandid = p.prodbrandid
				" . $where;

		return $query;
	}

	public function GetListRow($row)
	{
		$new_row['ID'] = $row['productid'];
		$new_row['SKU'] = $row['prodcode'];
		$new_row['Name'] = $row['prodname'];
		$new_row['Price'] = FormatPriceInCurrency($row['prodprice']);
		if ($row['prodvisible']) {
			$new_row['Visible'] = '<img src="images/tick.gif" alt="tick"/>';
		}
		else {
			$new_row['Visible'] = '<img src="images/cross.gif" alt="cross"/>';
		}

		if ($row['prodfeatured']) {
			$new_row['Featured'] = '<img src="images/tick.gif" alt="tick"/>';
		}
		else {
			$new_row['Featured'] = '<img src="images/cross.gif" alt="cross"/>';
		}

		return $new_row;
	}

	protected function BuildWhereFromFields($search_fields)
	{
		$class = GetClass('ISC_ADMIN_PRODUCT');

		$res = $class->BuildWhereFromVars($search_fields);
		$where = $res['query'];

		// strip AND from beginning and end of statement
		$where = preg_replace("/^( ?AND )?|( AND ?)?$/i", "", $where);

		return $where;
	}

	public function HasPermission()
	{
		return $GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Export_Products);
	}
}
?>
