<?php
CLASS ISC_SHIPPINGINFO_PANEL extends PANEL
{
	public function SetPanelSettings()
	{       
        if($GLOBALS['ISC_CLASS_PRODUCT']->IsPurchasingAllowed()) {
            if(!GetConfig('ShowProductShipping')) {
                $GLOBALS['HideShipping'] = 'none';
            } else if ($GLOBALS['ISC_CLASS_PRODUCT']->GetProductType() == PT_PHYSICAL) {
                if ($GLOBALS['ISC_CLASS_PRODUCT']->GetFixedShippingCost() != 0) {
                    // Is there a fixed shipping cost?
                    $GLOBALS['ShippingPrice'] = sprintf("%s %s", CurrencyConvertFormatPrice($GLOBALS['ISC_CLASS_PRODUCT']->GetFixedShippingCost()), GetLang('FixedShippingCost'));
                }
                else if ($GLOBALS['ISC_CLASS_PRODUCT']->HasFreeShipping()) {
                    // Does this product have free shipping?
                    $GLOBALS['ShippingPrice'] = GetLang('FreeShipping');
                }
                else {
                    // Shipping calculated at checkout
                    $GLOBALS['ShippingPrice'] = GetLang('CalculatedAtCheckout');
                }
            } else {
                $GLOBALS['ShippingPrice'] = GetLang('CalculatedAtCheckout');
            }
        }   
	}
}

?>