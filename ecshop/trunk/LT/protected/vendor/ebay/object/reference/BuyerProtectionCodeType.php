<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 14-10-13
 * Time: 9:48pm
 */

class BuyerProtectionCodeType
{
    const CustomCode="CustomCode";//Reserved for internal or future use.
    const ItemEligible="ItemEligible";//This value indicates that the item is eligible for buyer protection.
    const ItemIneligible="ItemIneligible";//BThis value indicates that the item is ineligible for buyer protection. In many cases, the item is ineligible for buyer protection due to the category it is listed under.
    const ItemMarkedEligible="ItemMarkedEligible";//This value indicates that the eBay customer support has marked the item as eligible per special criteria.
    const ItemMarkedIneligible="ItemMarkedIneligible";//This value indicates that the eBay customer support has marked the item as ineligible per special criteria (e.g., seller's account closed).
    const NoCoverage="NoCoverage";//This value indicates that the item is ineligible for coverage under any buyer protection program.
}