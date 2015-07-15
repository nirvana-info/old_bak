<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 14-10-13
 * Time: 5:00pm
 */

class InventoryTrackingMethodCodeType {
    const CustomCode="CustomCode";//Reserved for internal or future use
    const ItemID="ItemID";//The seller prefers to track the listing by its eBay item ID. This is the default for all listings.
    const SKU="SKU";//The seller prefers to track the listing by their own SKU. When you track by SKU, it means you can pass your SKU instead of the eBay item ID in other calls that support SKU as an input field. If you choose SKU as your tracking preference for a listing, the value in Item.SKU must be unique across your active listings. You cannot create new listings with the same Item.SKU value while the listing is active (that is, until the existing listing with that SKU has ended). However, you can use ReviseInventoryStatus to update the quantity and/or price for the existing SKU as needed. When revising a listing where the InventoryTrackingMethod was set to SKU, you must pass in both the InventoryTrackingMethod tag (with the value set to SKU) and the SKU tag with the SKU value from your original listing.
} 