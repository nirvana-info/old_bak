<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 14-10-13
 * Time: 9:29
pm */

require_once 'reference/CurrencyCodeType.php';
require_once 'reference/BuyerProtectionCodeType.php';

class item
{
    public $ApplicationData;//string, Returns custom, application-specific data associated with the item. The data you specify is stored by eBay with the item for your own reference, but it is not used by eBay in any way.
    public $AutoPay;//boolean, To create a requirement that a buyer pays immediately (through PayPal or PaisaPay) for an auction (Buy It Now only) or fixed-price item, the seller can include and set the AutoPay field to 'true' for an Add/Revise/Relist API call.
    public $BuyerGuaranteePrice;//float
    public $BuyerGuaranteePrice_currencyID;//enum of CurrencyCodeType
    public $BuyerProtection;//enum of BuyerProtectionCodeType
    public $BuyItNowPrice;//float
    public $BuyItNowPrice_currencyID;//enum of CurrencyCodeType
    public $Charity;//object of CharityType
    public $ConditionDescription;//string, This string field is used by the seller to more clearly describe the condition of items that are not brand new.
    public $ConditionDisplayName;//string, Max length: 50, The human-readable label for the item condition. Display names are localized for the site on which they're listed (not necessarily the site on which they're viewed).
    public $ConditionID;//int
    public $Country;//enum of CountryCodeType
    public $CrossBorderTrade;//array of string
    public $Currency;

    static $paramtypesmap = array(
        "ApplicationData" => "string",
        "AutoPay" => "boolean",
        "BuyerGuaranteePrice" => "float",
        "BuyerGuaranteePrice_currencyID" => "CurrencyCodeType",
        "BuyerProtection" => "BuyerProtectionCodeType",
        "BuyItNowPrice" => "float",
        "BuyItNowPrice_currencyID" => "CurrencyCodeType",
        "Charity" => "CharityType",
        "ConditionDescription" => "string",
        "ConditionDisplayName" => "string",
        "ConditionID" => "integer",
        "Country" => "CountryCodeType",
        "CrossBorderTrade" => "string[]",
        "Currency" => "CurrencyCodeType",
    );

    /*function __construct()
    {
        $this->Charity = new CharityType();
    }*/
}