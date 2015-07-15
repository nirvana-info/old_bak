<?php

class RULE_PERCENTOFFITEMSINCAT extends ISC_RULE
{
	public $amount;
	public $catids;      
    public $minprice = 0;  
    public $discountpolicy = 0;   
	protected $vendorSupport = true;

	public function __Construct($amount=0, $catids=array())
	{
		parent::__construct();

		$this->amount = $amount;
		$this->catids = $catids;  

		$this->setName('PERCENTOFFITEMSINCAT');
		$this->displayName = GetLang($this->getName().'displayName');

		$this->addJavascriptValidation('amount', 'int', 0, 100);
		$this->addJavascriptValidation('catids', 'array');

		$this->addActionType('itemdiscount');
		$this->ruleType = 'Product';
	}

	public function initialize($data)
	{
		parent::initialize($data);

		$tmp = unserialize($data['configdata']);

		$this->amount = $tmp['var_amount'];
		$this->catids = $tmp['var_catids'];
        if(isset($tmp['var_discountpolicy']))    {
            $this->discountpolicy = $tmp['var_discountpolicy'];
        }
        if(isset($tmp['var_minprice']))    {
            $this->minprice = $tmp['var_minprice'];
        } 
	}

	public function initializeAdmin()
	{
		if (!empty($this->catids)) {
			$selectedCategories = explode(',', $this->catids);
		} else {
			$selectedCategories = array();
		}
        
		$GLOBALS['ISC_CLASS_ADMIN_CATEGORY'] = GetClass('ISC_ADMIN_CATEGORY');
		$GLOBALS['CategoryList'] = $GLOBALS["ISC_CLASS_ADMIN_CATEGORY"]->GetCategoryOptions($selectedCategories, "<option %s value='%d'>%s</option>", 'selected="selected"', " ", false);
        if(isset($this->discountpolicy))    {
            if($this->discountpolicy==0)    {
                $GLOBALS['SelectedSalePrice'] = "selected=\"selected\"";    
            }
            else    {
                $GLOBALS['SelectedCartPrice'] = "selected=\"selected\"";
            }
        }
		if (count($selectedCategories) < 1) {
			$GLOBALS['AllCategoriesSelected'] = "selected=\"selected\"";
		}
	}

	public function isTrue()
	{
		$GLOBALS['ISC_CLASS_CART'] = GetClass('ISC_CART');

		$cartProducts = $GLOBALS['ISC_CLASS_CART']->api->GetProductsInCart(true);
		$found = false;
        
		foreach ($cartProducts as $key=>$product) {

			$productCats = explode(",", $product['data']['categoryids']);
			$ruleCats = explode(",", $this->catids);
			foreach ($ruleCats as $catid) {
                if((float)$product['product_price'] >= (float)$this->minprice)    {
				    if (in_array($catid, $productCats) || $catid == 0) {

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
					    $found[] = $catid;
				    }
                }
			}
		}
        
		if (!empty($found)) {

			$catname = '';
			$catids = implode(',', $found);

			$query = "
					SELECT catname
					FROM [|PREFIX|]categories
					WHERE categoryid IN ($catids)
			";

			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			while($var = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$catname[] = $var['catname'];
			}
			if (isset($catname{1})) {
				$GLOBALS['ISC_CLASS_CART']->api->SetArrayPush('DISCOUNT_MESSAGES', sprintf(GetLang($this->getName().'DiscountMessagePlural'), $this->amount, implode(' and ',$catname)));
			} else {
				$GLOBALS['ISC_CLASS_CART']->api->SetArrayPush('DISCOUNT_MESSAGES', sprintf(GetLang($this->getName().'DiscountMessage'), $this->amount, implode(' and ',$catname)));
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