<?php
$link = mysql_connect('localhost', 'webtc', 'cDReuq3#');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
$db_selected = mysql_select_db('tc_store', $link);

$vendor_array = array();
$qry = "select vendorprefix from isc_vendors where vendorprefix is NOT NULL OR vendorprefix != ''";
$res = mysql_query($qry) or die('hi');
while($arr = mysql_fetch_array($res))
{
	$vendor_array[] = strtoupper($arr['vendorprefix']);
}

$rejected_vendor = array();
$product_code = array();
$rejected_but_exist_product_code = array();
$qry1 = "select * from test_fb";
$res1 = mysql_query($qry1) or die('hi1');
while($arr1 = mysql_fetch_array($res1))
{
	$allsku = $arr1['sku'];
	$prefix = strtoupper(substr($allsku, 0, 3));  
	$sku = substr($allsku,3);
	
	if(in_array($prefix,$vendor_array))
	{
		$product_qry = "select productid from isc_products where prodvendorprefix = '$prefix' and prodcode = '$sku'";
		$product_res = mysql_query($product_qry);
		if(mysql_num_rows($product_res) == 1)
		{
			$product_arr = mysql_fetch_array($product_res);
			$review_qry = "insert into isc_reviews(revproductid,revrating,revtext,revstatus,revprodsku,revprodvendorprefix) values('".$product_arr['productid']."', '".$arr1['rating']."', '".$arr1['comments']."' ,1 ,'".$sku."' ,'".$prefix."')";
			mysql_query($review_qry);
			
		}
		else
		{
			$product_code[] = $sku;
			$product_sku_qry = "select productid from isc_products where prodcode = '$sku'";
			$product_sku_res = mysql_query($product_sku_qry);
			if(mysql_num_rows($product_sku_res) == 1)
			{
				$rejected_but_exist_product_code[] = $sku;
			}
		}
	}
	else
	{
		$rejected_vendor[] = $prefix;
	}
}
$rejected_vendor = array_unique($rejected_vendor);

echo "<br>----- Vendors Rejected ------<br>";
print_r($rejected_vendor);

echo "<br><br>----- SKU Rejected ------<br>";
print_r($product_code);

echo "<br><br>----- SKU Rejected But Exist ------<br>";
print_r($rejected_but_exist_product_code);


?>