<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 14-10-13
 * Time: 3:04pm
 */

require_once 'reference/*.php';

class FixPriceItem
{
    public $ApplicationData;//string
    public $AutoPay;//boolean
    public $BestOfferDetails;//object
    public $BuyerRequirementDetails;//object
    public $CategoryBasedAttributesPrefill;//boolean
    public $CategoryMappingAllowed;//boolean
    public $Charity;//object
    public $ConditionDescription;//string
    public $ConditionID;//int, need look for category specifically
    public $Country;//enum of CountryCodeType
    public $CrossBorderTrade;//array, This field is used by sellers who want their listing to be returned in the search results for other eBay sites. This feature is currently only supported by the US, UK, eBay Canada, and eBay Ireland sites.This field is used by sellers who want their listing to be returned in the search results for other eBay sites. This feature is currently only supported by the US, UK, eBay Canada, and eBay Ireland sites.
    public $Currency;//enum of CurrencyCodeType
    public $Description;//string, Max length: 500000
    public $DisableBuyerRequirements;//boolean
    public $DiscountPriceInfo;//object
    public $DispatchTimeMax;//int
    public $eBayNowEligible;//boolean
    public $GetItFast;//boolean
    public $GiftIcon;//boolean
    public $GiftServices;//enum of GiftServicesCodeType
    public $HitCounter;//enum of HitCounterCodeType
    public $IncludeRecommendations;//boolean
    public $InventoryTrackingMethod;//enum of InventoryTrackingMethodCodeType
    public $ItemCompatibilityList;//object
    public $ItemSpecifics;//object
    public $ListingCheckoutRedirectPreference;//object

    function __construct()
    {
        $this->BestOfferDetails = new BestOfferDetailsType();
        $this->BuyerRequirementDetails = new BuyerRequirementDetailsType();
        $this->Charity = new CharityType();
        $this->DiscountPriceInfo = new DiscountPriceInfoType();
        $this->ItemCompatibilityList = new ItemCompatibilityListType();
        $this->ItemSpecifics = new NameValueListArrayType();
        $this->ListingCheckoutRedirectPreference = new ListingCheckoutRedirectPreferenceType();
    }
}

class BestOfferDetailsType
{
    public $BestOfferEnabled;//boolean
}

class BuyerRequirementDetailsType
{
    public $LinkedPayPalAccount;//boolean
    public $MaximumBuyerPolicyViolations;//object
    public $MaximumItemRequirements;//object
    public $MaximumUnpaidItemStrikesInfo;//object
    public $MinimumFeedbackScore;//valid value -3, -2, -1
    public $ShipToRegistrationCountry;//boolean
    public $VerifiedUserRequirements;//object
    public $ZeroFeedbackScore;//boolean
    public $Charity;//object

    function __construct()
    {
        $this->MaximumBuyerPolicyViolations = new MaximumBuyerPolicyViolationType();
        $this->MaximumItemRequirements = new MaximumItemRequirementsType();
        $this->MaximumUnpaidItemStrikesInfo = new MaximumUnpaidItemStrikesInfoType();
        $this->VerifiedUserRequirements = new VerifiedUserRequirementsType();
    }
}

class MaximumBuyerPolicyViolationType
{
    public $Count;//int
    public $Period;//enum of PeriodCodeType
}

class MaximumItemRequirementsType
{
    public $MaximumItemCount;//int
    public $MinimumFeedbackScore;//int
}

class MaximumUnpaidItemStrikesInfoType
{
    public $Count;//int
    public $Period;//enum of PeriodCodeType
}

class VerifiedUserRequirementsType
{
    public $MinimumFeedbackScore;//int
    public $VerifiedUser;//boolean
}

class DiscountPriceInfoType
{
    public $MadeForOutletComparisonPrice;//double
    public $MinimumAdvertisedPrice;//double
    public $MinimumAdvertisedPriceExposure;//enum of MinimumAdvertisedPriceExposureCodeType
    public $OriginalRetailPrice;//double
    public $PricingTreatment;//enum of PricingTreatmentCodeType
    public $SoldOffeBay;//boolean
    public $SoldOneBay;//boolean
}

class ItemCompatibilityListType
{
    public $Compatibility;//array of object ItemCompatibilityType
    public $ReplaceAll;//boolean
}

class ItemCompatibilityType
{
    public $CompatibilityNotes;//string
    public $Delete;//boolean
    public $NameValueList;//array of NameValueListType
}

class NameValueListArrayType
{
    public $NameValueList;//array of NameValueListType
}

class ListingCheckoutRedirectPreferenceType
{
    public $ProStoresStoreName;//string
    public $SellerThirdPartyUsername;//string
}