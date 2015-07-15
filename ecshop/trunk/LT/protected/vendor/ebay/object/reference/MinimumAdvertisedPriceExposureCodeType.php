<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 14-10-13
 * Time: 4:51pm
 */

class MinimumAdvertisedPriceExposureCodeType
{
    const CustomCode="CustomCode";//Reserved for future use.
    const DuringCheckout="DuringCheckout";//DuringCheckout specifies that the discounted price must be shown on the eBay checkout flow page.
    const None="None";//None means the discount price is not shown via either PreCheckout nor DuringCheckout.
    const PreCheckout="PreCheckout";//PreCheckout specifies that the buyer must click a link (or a button) to navigate to a separate page (or window) that displays the discount price. eBay displays the discounted item price in a pop-up window.
} 