<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 14-10-13
 * Time: 4:53pm
 */

class PricingTreatmentCodeType {
    const CustomCode="CustomCode";//Reserved for future use.
    const MAP="MAP";//MAP stands for MinimumAdvertisedPrice
    const MFO="Valid";//MFO means stands for MadeForOutletComparisonPrice.
    const None="None";//None means neither STP nor MinimumAdvertisedPrice.
    const STP="STP";//STP stands for Strike Through Pricing.
} 