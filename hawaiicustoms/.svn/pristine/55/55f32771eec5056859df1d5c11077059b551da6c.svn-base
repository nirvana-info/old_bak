<?php
     
    /**
     * Get Rule Module Info
     *
     * Retrieves a list of discount rules enabled by the customer
     *
     * @access public
     * @param string $type - The type of the rules
     * @return array Returns an array of initialized rules
     */
    function GetRuleModuleInfo($type='all')
    {
        static $cache = array();
        if(isset($cache[$type])) {
            return $cache[$type];
        }

        if ($type == 'all') {
            $query = "
            SELECT *
            FROM [|PREFIX|]discounts ORDER BY sortorder";
        }
        else {
            $query = "
            SELECT *
            FROM [|PREFIX|]discounts
            WHERE discountruletype='rule_".$type . "'
            ORDER BY sortorder";
        }

        $result = $GLOBALS['ISC_CLASS_DB']->Query($query);

        $DiscountInfo = array();

        while($var = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) { 
            if(($var['discountruletype']=='rule_percentoffitemsincat' || $var['discountruletype']=='rule_percentoffitemsinseries') && $var['discountenabled'])    {
                GetModuleByIdNew('rule', $object, $var['discountruletype']); 
                $DiscountInfo = initializeObj($var, $DiscountInfo);
            }
            
        }
        return $DiscountInfo;
    }

    $GLOBALS['DiscountRules'] = GetRuleModuleInfo(); 
      
    /**
     * Return the object of a module based on the passed ID.
     *
     * @param string The type of module that needs to be loaded.
     * @param object The object of the module, returned by reference.
     * @param string The ID of the module to load.
     * @return boolean True if successful, false if not.
     */
    function GetModuleByIdNew($type, &$returned_module, $id)
    {
        $valid_types = array (
            'accounting',
            'analytics',
            'checkout',
            'notification',
            'shipping',
            'currency',
            'livechat',
            'addon',
            'rule'
        );

        if (!in_array($type, $valid_types)) {
            return false;
        }
        return true;
    }

            
    function initializeObj($data, &$DiscountInfo)
    {    
        
        $tmp = unserialize($data['configdata']); 
        
        $amount = $tmp['var_amount'];    
        $minprice = $tmp['var_minprice'];        
        $DiscountInfoSub = array();
        $DiscountInfoSub['amount']  = $amount;
        $DiscountInfoSub['minprice']  = $minprice;
                                      
        if(isset($tmp['var_catids']))    {
            $catids = $tmp['var_catids'];
            $DiscountInfoSub['catids']  = $catids;
        } 
        else if(isset($tmp['var_seriesids']))   {
            $seriesids = $tmp['var_seriesids'];
            $DiscountInfoSub['seriesids']  = $seriesids;
        }                                        
        $DiscountInfo[] = $DiscountInfoSub;
        return $DiscountInfo;
    }

    function CalculateDiscountPrice($price, $discountprice, $categoryid, $seriesid)   {
        //Added by Simha for onsale addition
        $Rules = $GLOBALS['DiscountRules'];
        foreach($Rules as $Rule)   {  
            if((float)$price >= (float)$Rule['minprice'])    {
                if(isset($Rule['catids']))    { 
                    $discountprice = CalculateCatBasedDiscount($Rule, $price, $discountprice, $categoryid);    
                }
                elseif(isset($Rule['seriesids']))    {
                    $discountprice = CalculateSeriesBasedDiscount($Rule, $price, $discountprice, $seriesid);
                } 
                /*if($discountprice < $price)    {
                     return $discountprice;
                } */
            }
        }  
        return $discountprice;
    }
    
    function CalculateCatBasedDiscount($rule, $price, $discountprice, $categoryid)    { 
        $catids = explode(",", $rule['catids']); 
        foreach($catids as $catid) {
            if($catid == $categoryid) {
                if($discountprice < $price)    {
                    $discountamount = $discountprice * ((int)$rule['amount']/100); 
                }
                else    {
                    $discountamount = $price * ((int)$rule['amount']/100);
                }
                if ($discountprice < 0) {
                    $discountprice = 0;
                }
                $discountprice  = $price - $discountamount;  
            } 
        }      
        return $discountprice;
    }
    
    function CalculateSeriesBasedDiscount($rule, $price, $discountprice, $seriesid)    {
        $seriesids = explode(",", $rule['seriesids']); 
        foreach($seriesids as $sid) {
            if($sid == $seriesid) {
                if($discountprice < $price)    {  
                    $discountamount = $discountprice * ((int)$rule['amount']/100); 
                }
                else    {
                    $discountamount = $price * ((int)$rule['amount']/100); 
                }
                if ($discountprice < 0) {
                    $discountprice = 0;
                }
                $discountprice  = $price - $discountamount;  
            } 
        }      
        return $discountprice;
    }
    
    
    function IsDiscountAvailable($type, $id)   {
        //Added by Simha for onsale addition
        $Rules = $GLOBALS['DiscountRules'];
        foreach($Rules as $Rule)   {                           
            if(isset($Rule['catids']) && $type=='category')    {    
                $catids = explode(",", $Rule['catids']);
                if(in_array($id, $catids))    {
                   return true; 
                }   
            }
            elseif(isset($Rule['seriesids']) && $type=='series')    {                                      
                $seriesids = explode(",", $Rule['seriesids']);
                if(in_array($id, $seriesids))    {
                   return true; 
                }
            } 
        }  
        return false;
    }
    
        
?>
