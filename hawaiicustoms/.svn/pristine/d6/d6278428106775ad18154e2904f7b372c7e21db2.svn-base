<?php

class RULE_PERCENTOFFITEMSINSERIES extends ISC_RULE
{
	public $amount;
	public $seriesids;
    public $minprice = 0;
    public $discountpolicy = 0;  
	protected $vendorSupport = true;

	public function __Construct($amount=0, $seriesids=array())
	{
		parent::__construct();

		$this->amount = $amount;
		$this->seriesids = $seriesids;           

		$this->setName('PERCENTOFFITEMSINSERIES');
		$this->displayName = GetLang($this->getName().'displayName');

		$this->addJavascriptValidation('amount', 'int', 0, 100);
		$this->addJavascriptValidation('seriesids', 'array');

		$this->addActionType('itemdiscount');
		$this->ruleType = 'Product';
	}

	public function initialize($data)
	{
		
        parent::initialize($data);

		$tmp = unserialize($data['configdata']);      
		$this->amount    = $tmp['var_amount'];
		$this->seriesids = $tmp['var_seriesids'];    
        
        if(isset($tmp['var_discountpolicy']))    {
            $this->discountpolicy = $tmp['var_discountpolicy'];
        }
           
        if(isset($tmp['var_minprice']))    {
            $this->minprice  = $tmp['var_minprice'];
        }
        if(isset($tmp['var_brandids']))    {
            $this->brandids = $tmp['var_brandids'];     
        }    
	}

	public function initializeAdmin()
	{
		if (!empty($this->seriesids)) {   
			$selectedSeries = explode(',', $this->seriesids);
            if(isset($this->brandids) && $this->brandids != '')    {
                $selectedBrands = explode(',', $this->brandids);     
            } 
            else    {
                $selectedBrands = array();
            }  
		} else {
			$selectedSeries = array();
            $selectedBrands = array();
		}

        if(isset($this->discountpolicy))    {
            if($this->discountpolicy==0)    {
                $GLOBALS['SelectedSalePrice'] = "selected=\"selected\"";    
            }
            else    {
                $GLOBALS['SelectedCartPrice'] = "selected=\"selected\"";
            }
        }
        
		$GLOBALS['ISC_CLASS_ADMIN_BRANDS'] = GetClass('ISC_ADMIN_BRANDS');  
        
        $GLOBALS['BrandsList'] = $GLOBALS["ISC_CLASS_ADMIN_BRANDS"]->GetBrandOptions($selectedBrands, "<option %s value='%d'>%s</option>", 'selected="selected"', " ", false);

		$GLOBALS['SeriesList'] = $GLOBALS["ISC_CLASS_ADMIN_BRANDS"]->GetSeriesOptions($selectedSeries, "<option %s value='%d'>%s</option>", 'selected="selected"', " ", false, $selectedBrands);

		if (count($selectedSeries) < 1) {
			$GLOBALS['AllSeriesSelected'] = "selected=\"selected\"";
		}
	}

	public function isTrue()
	{
		$GLOBALS['ISC_CLASS_CART'] = GetClass('ISC_CART');    
		$cartProducts = $GLOBALS['ISC_CLASS_CART']->api->GetProductsInCart(true);
		$found = false;

		foreach ($cartProducts as $key=>$product) {                              
            if((float)$product['product_price'] >= (float)$this->minprice)    {
			    $productSeries = explode(",", $product['data']['seriesids']);
			    $ruleSeries = explode(",", $this->seriesids);
			    foreach ($ruleSeries as $seriesid) {
				    if (in_array($seriesid, $productSeries)) {

					    /*if (isset($product['discount_price'])) {
						    $amount = $product['discount_price'] * ((int)$this->amount/100);
					    } else {*/
						    $amount = $product['product_price'] * ((int)$this->amount/100);
					    /*}*/

					    if ($amount < 0) {
						    $amount = 0;
					    }

					    $this->itemdiscount += $amount * $product['quantity']; 
					    $GLOBALS['ISC_CLASS_CART']->api->SetItemValue($key, 'discount_price', $product['product_price'] - $amount);
					    $found[] = $seriesid;
				    }
			    }
            }
		}
        
		if (!empty($found)) {

			$seriesname = '';
			$seriesids = implode(',', $found);

			$query = "
					SELECT seriesname
					FROM [|PREFIX|]brand_series
					WHERE seriesid IN ($seriesids)
			";

			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			while($var = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$seriesname[] = $var['seriesname'];
			}
			if (isset($seriesname{1})) {
				$GLOBALS['ISC_CLASS_CART']->api->SetArrayPush('DISCOUNT_MESSAGES', sprintf(GetLang($this->getName().'DiscountMessagePlural'), $this->amount, implode(' and ',$seriesname)));
			} else {
				$GLOBALS['ISC_CLASS_CART']->api->SetArrayPush('DISCOUNT_MESSAGES', sprintf(GetLang($this->getName().'DiscountMessage'), $this->amount, implode(' and ',$seriesname)));
			}
			return true;
		}


		return false;
	}

	public function haltReset()
	{
		return false;
	}


}


?>