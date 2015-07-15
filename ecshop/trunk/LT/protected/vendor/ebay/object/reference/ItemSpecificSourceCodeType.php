<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 14-10-13
 * Time: 5:06pm
 */

class ItemSpecificSourceCodeType {
    const Attribute="Attribute";//The Item Specific was originally stored with eBay's system-defined (ID-based) attributes format. (For example, the seller used the AttributeSetArray node in AddItem at a time when the category supported Attributes.)
    const CustomCode="CustomCode";//Reserved for future use.
    const ItemSpecific="ItemSpecific";//The Item Specific was originally stored with custom Item Specifics fields. (For example, the seller used the ItemSpecifics node in AddItem.) This is the default setting if Source isn't returned.
    const Product="Product";//The Item Specific is prefilled from a product catalog. (For example, the seller used ExternalProductID or ProductID in AddItem.)
} 