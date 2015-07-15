<?php
include(dirname(__FILE__) . "/init.php");

require_once(ISC_BASE_PATH."/lib/discountcalcs.php");

$GLOBALS['args'] = $argv;
/*$getval = print_r($argv , true);
$updatepricequery		=	"INSERT INTO [|PREFIX|]orderlogs (ordervalue) VALUES('$getval')"; 
$GLOBALS['ISC_CLASS_DB']->Query($updatepricequery);

exit;
*/
$GLOBALS['ISC_CLASS_UPDATEFINALPRICE'] = GetClass('ISC_UPDATEFINALPRICE'); 

exit;

$pricequery		=	"select	p.productid , c.categoryid , brandseriesid , categoryid , prodhideprice ,  prodistaxable , 
						prodprice , prodretailprice , prodsaleprice , prodcalculatedprice 
						from  [|PREFIX|]products p 
						inner join [|PREFIX|]categoryassociations c on p.productid = c.productid ";
$priceresult	=	$GLOBALS['ISC_CLASS_DB']->Query($pricequery);
while($pricerow		=	$GLOBALS['ISC_CLASS_DB']->Fetch($priceresult))
{
		$GLOBALS['ProductPrice'] =	CalculateProductPriceRetail($pricerow);

		$FinalPrice         =	$GLOBALS['ProductPrice'];  
		$SalePrice          =	$pricerow['prodsaleprice'];  

		$discounttype = 0;
		if((float)$SalePrice >0 && $SalePrice < $FinalPrice)
		{
			$DiscountPrice = $SalePrice;
		}
		else 
		{   
			$DiscountPrice = $FinalPrice;
			$DiscountPrice = CalculateDiscountPrice($FinalPrice, $DiscountPrice, $pricerow['categoryid'], $pricerow['brandseriesid'], $discounttype);                
			/*if($discounttype == 0)    {
				$DiscountPrice = $FinalPrice;
			}*/               
		}

		$updatepricequery		=	"	INSERT INTO [|PREFIX|]product_finalprice(productid,prodfinalprice,prodcatid,prodseriesid) 
									VALUES( ".$pricerow['productid']." , ".$DiscountPrice." , ".$pricerow['categoryid']." , ".$pricerow['brandseriesid']." ) 
									ON DUPLICATE KEY UPDATE prodcatid = ".$pricerow['productid'].", prodseriesid = ".$pricerow['brandseriesid'].", prodfinalprice = ".$DiscountPrice;
		$updatepriceresult		=	$GLOBALS['ISC_CLASS_DB']->Query($updatepricequery);

}

?>