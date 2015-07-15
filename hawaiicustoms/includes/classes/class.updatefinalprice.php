<?php
        
	class ISC_UPDATEFINALPRICE
	{

		var $_priceqry = "";

		function __construct()
		{
			$source = isset($GLOBALS['args'][1]) ? $GLOBALS['args'][1] : '';
			$id = isset($GLOBALS['args'][2]) ? $GLOBALS['args'][2] : '';
			/*$getval = print_r($GLOBALS['args'], true);
			
			$getval = $GLOBALS['args'][0];
			$updatepricequery		=	"INSERT INTO [|PREFIX|]orderlogs (ordervalue) VALUES('$getval')"; 
			$GLOBALS['ISC_CLASS_DB']->Query($updatepricequery);
			*/
			//exit;
			
			switch ($source) {
				case "discount": {
					$_discountid = $id;
					$this->UpdateDiscountProducts($_discountid);
					break;
				}
				default: {
					$this->UpdateProductsfromImport();
				}
			}

		}

		function UpdateDiscountProducts($_discountid)
		{
			$getproductsqry		=	" select configdata from [|PREFIX|]isc_discounts where discountid = ".(int)$_discountid;
			$getproductsres		=	$GLOBALS['ISC_CLASS_DB']->Query($getproductsqry);
			$getproductsarr		=	$GLOBALS['ISC_CLASS_DB']->FetchOne($getproductsres);
			$subqry = "";
			if(isset($getproductsarr['configdata']))
			{
				$seriealizedata		=	unserialize($getproductsarr);
				
				if(isset($seriealizedata['var_catids']))
				{
					$subqry = " AND categoryid in ( ".$seriealizedata['var_catids']." ) ";
				}

				if(isset($seriealizedata['var_seriesids']))
				{
					$subqry = " AND brandseriesid in ( ".$seriealizedata['var_seriesids']." ) ";
				}
			}

			$this->_priceqry	=	"select p.productid , c.categoryid , brandseriesid , categoryid , prodhideprice ,  prodistaxable , 
										prodprice , prodretailprice , prodsaleprice , prodcalculatedprice 
										from  [|PREFIX|]products p 
										inner join [|PREFIX|]categoryassociations c on p.productid = c.productid where 1=1 ".$subqry;	
			
			$this->UpdateProducts();
		}

		function UpdateProductsfromImport()
		{
			$this->_priceqry	=	"select p.productid , c.categoryid , brandseriesid , categoryid , prodhideprice ,  prodistaxable , 
										prodprice , prodretailprice , prodsaleprice , prodcalculatedprice 
										from  [|PREFIX|]products p 
										inner join [|PREFIX|]categoryassociations c on p.productid = c.productid ";

			$this->UpdateProducts();
		}

		function UpdateProducts()
		{
			$productres			=	$GLOBALS['ISC_CLASS_DB']->Query($this->_priceqry);

			while($productarr = $GLOBALS['ISC_CLASS_DB']->Fetch($productres))
			{
					$GLOBALS['ProductPrice'] =	CalculateProductPriceRetail($productarr);

					$FinalPrice         =	$GLOBALS['ProductPrice'];  
					$SalePrice          =	$productarr['prodsaleprice'];  

					$discounttype = 0;
					if((float)$SalePrice >0 && $SalePrice < $FinalPrice)
					{
						$DiscountPrice = $SalePrice;
					}
					else 
					{   
						$DiscountPrice = $FinalPrice;
						$DiscountPrice = CalculateDiscountPrice($FinalPrice, $DiscountPrice, $productarr['categoryid'], $productarr['brandseriesid'], $discounttype);                
						/*if($discounttype == 0)    {
							$DiscountPrice = $FinalPrice;
						}*/               
					}

					$updatepricequery		=	"	INSERT INTO [|PREFIX|]product_finalprice(productid,prodfinalprice,prodcatid,prodseriesid) 
												VALUES( ".$productarr['productid']." , ".$DiscountPrice." , ".$productarr['categoryid']." , ".$productarr['brandseriesid']." ) 
												ON DUPLICATE KEY UPDATE prodcatid = ".$productarr['categoryid'].", prodseriesid = ".$productarr['brandseriesid'].", prodfinalprice = ".$DiscountPrice;
					$updatepriceresult		=	$GLOBALS['ISC_CLASS_DB']->Query($updatepricequery);
			}

		}

		
	}

?>