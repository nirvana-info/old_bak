<?php

	// Last Updated: 26th Dec 2011 @ 3:59 PM

	$GLOBALS['ISC_CFG']["isSetup"] = true;
	$GLOBALS['ISC_CFG']["Language"] = 'en';
	$GLOBALS['ISC_CFG']["AllowPurchasing"] = 1;
	$GLOBALS['ISC_CFG']["serverStamp"] = 'ISCEAgAAAAAyAAAACTF2Otv/X0UdT5aBOxr/R0';
	$GLOBALS['ISC_CFG']["HostingProvider"] = '';
	$GLOBALS['ISC_CFG']["UseWYSIWYG"] = 1;
	$GLOBALS['ISC_CFG']["UseSSL"] = 0;
	$GLOBALS['ISC_CFG']["dbType"] = 'mysql';
	$GLOBALS['ISC_CFG']["dbEncoding"] = 'UTF8';
	$GLOBALS['ISC_CFG']["dbServer"] = 'localhost';
	$GLOBALS['ISC_CFG']["dbUser"] = 'root';
	$GLOBALS['ISC_CFG']["dbPass"] = '3233';
	$GLOBALS['ISC_CFG']["dbDatabase"] = 'hawaii';
	$GLOBALS['ISC_CFG']["tablePrefix"] = 'isc_';
	$GLOBALS['ISC_CFG']["StoreName"] = 'HawaiiCustoms';
	$GLOBALS['ISC_CFG']["StoreAddress"] = 'USA';
	$GLOBALS['ISC_CFG']["LogoType"] = 'image';
	$GLOBALS['ISC_CFG']["StoreLogo"] = 'TC-button200x50.gif';
	$GLOBALS['ISC_CFG']["ShopPath"] = 'http://hawaiicustoms.localhost';
	$GLOBALS['ISC_CFG']["AppPath"] = '';
	$GLOBALS['ISC_CFG']["CharacterSet"] = 'UTF-8';
	$GLOBALS['ISC_CFG']["HomePagePageTitle"] = 'Quality Discount Truck Accessories and SUV Accessories - TruckChamp.';
	$GLOBALS['ISC_CFG']["MetaKeywords"] = 'Truck Accessories, SUV Accessories, Truck Accessory, Accessories for Trucks, Pickup Trucks, Nerf Bars, Step Bars, Tonneau Covers, Truck Bed Covers, History of Trucks, Hitches, Rubber Bed Mats, Cold Air Intakes, Grille Guards, Grille Inserts, Lighting, Ford truck, Chevy truck, Toyota truck, TruckChamp.';
	$GLOBALS['ISC_CFG']["MetaDesc"] = 'TruckChamp\'s Official Site offers great deals on nerf bars, tonneau covers, air filters, bed mats, hitches, and many other truck accessories.';
	$GLOBALS['ISC_CFG']["DownloadDirectory"] = 'product_downloads';
	$GLOBALS['ISC_CFG']["ImageDirectory"] = 'product_images';
	
    // Add by NI_20100901_Jack
    $GLOBALS['ISC_CFG']["cache_file_folder"] = '/var/tmp/tc_ymm';
    //Add by Jack 10:23 2010-8-24, For model issue in YMM selector
    //Default is 7day * 24h * 60min * 60sec = 604800
    $GLOBALS['ISC_CFG']["cache_file_expire_time"] = 0;
	//Added by Simha starts
	$GLOBALS['ISC_CFG']["InstallImageDirectory"] = 'install_images';
    $GLOBALS['ISC_CFG']["VideoDirectory"] = 'product_videos';
    $GLOBALS['ISC_CFG']["InstallVideoDirectory"] = 'install_videos';
	//Added by Simha ends
        
        //zcs=>
        $GLOBALS['ISC_CFG']["LimitCustomerLoginTimes"] = 10;
        //<=zcs
        //zcs=>
        $GLOBALS['ISC_CFG']["UserQA"] = '';
        //<=zcs
        //zcs=>
         $GLOBALS['ISC_CFG']["AddonProductShownNum"] = 12;
        //<=zcs
        
        //zcs=>---Image Uploader----
        $GLOBALS['ISC_CFG']["LimitCustomerUploadImageSize"] = 1;// johnny
        $GLOBALS['ISC_CFG']["LimitCustomerUploadImageNum"] = 10;//zcs=
        $GLOBALS['ISC_CFG']["LimitCustomerUploadImagePerNum"] = 4;//zcs=
        $GLOBALS['ISC_CFG']["LimitCustomerUploadImageFileType"] = '1,2,6';//zcs=
        $GLOBALS['ISC_CFG']["ImageUploaderSettingsInstructions"] = 'PHA+Jm5ic3A7PC9wPg0KPGRpdj4NCjxwPklOU1RSVUNUSU9OUyBGT1IgVVBMT0FESU5HIElNQUdFUzwvcD4NCjxwPjEuIFlvdSBzaG91bGQgdXBsb2FkIGEgbWluaW11bSAxMCBpbWFnZXMgZm9yIGVhY2ggcGFydCB5b3UmcnNxdW87cmUgdGFraW5nLiBUaGV5IHNob3VsZCBiZSBvZiBtdWx0aXBsZSBhbmdsZXMgYW5kIHNvbWUgdXAgY2xvc2UgYW5kIHNvbWUgdGhhdCBzaG93IHRoZSBwYXJ0IGFuZCBhIGdvb2QgcG9ydGlvbiBvZiB0aGUgdmVoaWNsZSAod2lkZSBhbmdsZSBzaG90cykuPC9wPg0KPHA+Mi4gTWFrZSBzdXJlIHlvdXIgY2FtZXJhIGlzIHNldCB0byB0YWtlIHBpY3R1cmVzIGF0IGEgaGlnaCByZXNvbHV0aW9uLiBJZiB5b3UgZG9uJnJzcXVvO3Qga25vdyBob3cgdG8gZG8gdGhpcywganVzdCBsb29rIHVwIGluc3RydWN0aW9ucyBmb3IgY2hhbmdpbmcgcmVzb2x1dGlvbiBzZXR0aW5ncyBvbmxpbmUgZm9yIHlvdXIgY2FtZXJhIGJyYW5kIGFuZCBtb2RlbCBudW1iZXIuPC9wPg0KPHA+My4gV2FzaCB5b3VyIHZlaGljbGUuIEl0IGRvZXNuJnJzcXVvO3QgbmVlZCB0byBiZSBzcG90bGVzcywgYnV0IGp1c3Qgbm90IHZpc2libHkgbXVkZHkgb3IgZGlydHkuPC9wPg0KPHA+NC4gQ2xpY2sgb24gdGhlIGxpbms6IEkgd2FudCB0byB1cGxvYWQgaW1hZ2UgLjwvcD4NCjxwPjUuIENsaWNrIG9uIEJyb3dzZSBhbmQgY2hvb3NlIGltYWdlIHlvdSB3YW50IHRvIHVwbG9hZC4gUmVwZWF0IGZvciBtb3JlIGltYWdlcy48L3A+DQo8cD42LiBGaWxsIGluIHRoZSBkZXNjcmlwdGlvbiBmb3IgZWFjaCBpbWFnZSwgcGx1cyB5b3VyIGZ1bGwgbmFtZSwgYWRkcmVzcywgYW5kIHRoZSByYW5kb20gY2hhcmFjdGVycywgdGhlbiBwcmVzcyB0aGUgU3VibWl0IGJ1dHRvbi48L3A+DQo8L2Rpdj4NCjxwPiZuYnNwOzwvcD4=';//zcs=
        $GLOBALS['ISC_CFG']["ImageUploaderSettingsNotifyEmail"] = 'iris.chen@nirvana-info.com,tianman2008@126.com';//zcs=
        $GLOBALS['ISC_CFG']["ImageUploaderSettingsAssignment"] = 'PHA+Jm5ic3A7PC9wPg0KPGRpdj4NCjxoMz5DT1BZUklHSFQgQVNTSUdOTUVOVDwvaDM+DQo8cD5CeSBwb3N0aW5nIG9yIHN1Ym1pdHRpbmcgdGhlIG1hdGVyaWFsIGlkZW50aWZpZWQgYmVsb3csIGFuZCBpbiBjb25zaWRlcmF0aW9uIGZvciBMLk8uRi4sIEluYy4gKGhlcmVpbmFmdGVyICJMT0YiKSBkaXNwbGF5aW5nIHRoZSBwb3N0ZWQgbWF0ZXJpYWwgb24gdGhlaXIgd2Vic2l0ZSBvciB3ZWJzaXRlcywgYW5kL29yIGZvciBvdGhlciBnb29kIGFuZCB2YWx1YWJsZSBjb25zaWRlcmF0aW9uLCB3aGljaCBtYXkgaW5jbHVkZSBidXQgaXMgbm90IG5lY2Vzc2FyaWx5IGxpbWl0ZWQgdG8gcmVkZWVtYWJsZSB2b3VjaGVycyBvciBnaWZ0IGNlcnRpZmljYXRlcyBvciBjb3Vwb25zLCB0aGUgcmVjZWlwdCBvZiB3aGljaCBpcyBoZXJlYnkgYWNrbm93bGVkZ2VkLCZuYnNwOzxzcGFuIHN0eWxlPSJ0ZXh0LWRlY29yYXRpb246IHVuZGVybGluZTsiPkkgaGVyZWJ5IGFzc2lnbiB0aGUgZW50aXJlIGNvcHlyaWdodCwgd2hldGhlciByZWdpc3RlcmVkIG9yIHVucmVnaXN0ZXJlZCwgYW5kIGFsbCBVbml0ZWQgU3RhdGVzIGNvcHlyaWdodCByZWdpc3RyYXRpb25zIHRoZXJlZm9yLCBpbmNsdWRpbmcsIGJ1dCBub3QgbGltaXRlZCB0bywgdGhlIHJpZ2h0IG9mIGZpcnN0IHB1YmxpY2F0aW9uIGluIGFsbCBjb3VudHJpZXMsIGFsbCBvdGhlciBjb21tb24gbGF3IGNvcHlyaWdodHMgaW4gYWxsIGNvdW50cmllcywgYWxsIHN0YXR1dG9yeSBjb3B5cmlnaHRzIGFuZCByZW5ld2FsIHJpZ2h0cyBpbiBhbGwgY291bnRyaWVzLCBhcyB3ZWxsIGFzIHRoZSByaWdodCB0byByZWdpc3RlciB0aGUgY29weXJpZ2h0cyBpbiBhbGwgY291bnRyaWVzIGFsbG93aW5nIG9yIHJlcXVpcmluZyByZWdpc3RyYXRpb24sIGFsbCByZXByb2R1Y3Rpb24gcmlnaHRzIGluIGFsbCBjb3VudHJpZXMsIGFsbCBvdGhlciByaWdodHMgdW5kZXIgc3RhdHV0b3J5IG9yIGNvbW1vbiBsYXcgY29weXJpZ2h0cyBpbiBhbGwgY291bnRyaWVzLCB0aGUgcmlnaHQgdG8gcmVjb3ZlciBmb3IgcGFzdCBpbmZyaW5nZW1lbnRzIHRoZXJlb2YgaW4gYWxsIGNvdW50cmllcywgYW5kIGFueSBhbmQgYWxsIHJpZ2h0cyB1bmRlciBhbnkgY2F1c2VzIG9mIGFjdGlvbiBoYXZpbmcgYWNjcnVlZCBoZXJldG9mb3JlIHdpdGggcmVzcGVjdCB0byBzdWNoIHJpZ2h0cyBpbiBhbGwgY291bnRyaWVzIHRvIHN1Y2ggcG9zdGVkIG9yIHN1Ym1pdHRlZCBtYXRlcmlhbC48L3NwYW4+PGJyIC8+SW4gYWRkaXRpb24sIEkgY29uZmlybSBhbmQgd2FycmFudCB0byBMT0YgdGhhdCBJIG93biB0aGUgY29weXJpZ2h0IGluIHRoZSBtYXRlcmlhbCBJIGFtIHBvc3RpbmcgYW5kIGhhdmUgdGhlIHJpZ2h0IG5lY2Vzc2FyeSB0byBhc3NpZ24gdGhlIGNvcHlyaWdodCB0aGVyZWluLCBhbmQgZnVydGhlciwgdGhhdCB0aGUgYXNzaWdubWVudCBpcyB1bmVuY3VtYmVyZWQgYnkgYW55IHRoaXJkIHBhcnR5IHJpZ2h0cy4gSSB1bmRlcnN0YW5kIGFuZCBhZ3JlZSB0aGF0LCBzaG91bGQgTE9GIGJlIG5vdGlmaWVkIHRoYXQgdGhlIG1hdGVyaWFsIHRoYXQgSSBzdWJtaXR0ZWQgYWxsZWdlZGx5IHZpb2xhdGVzIGEgdGhpcmQgcGFydHkncyBpbnRlbGxlY3R1YWwgcHJvcGVydHksIExPRiB3aWxsIHJlbW92ZSB0aGUgbWF0ZXJpYWwgZnJvbSBpdHMgd2Vic2l0ZShzKSB3aXRob3V0IG5vdGljZS4mbmJzcDs8YnIgLz5GdXJ0aGVyLCBJIGFncmVlIHRoYXQgdGhpcyBhc3NpZ25tZW50IGdpdmVzIExPRiB0aGUgcmlnaHQgdG8gcG9zdCBhbmQvb3IgdG8gbWFrZSBzdWNoIG1hdGVyaWFsIGF2YWlsYWJsZSBvbiBvdGhlciBMT0Ytb3duZWQgd2Vic2l0ZXMgYW5kIG9uIHdlYnNpdGVzIG93bmVkIGJ5IHRoaXJkIHBhcnRpZXMuPGJyIC8+SSBoZXJlYnkgd2FpdmUgYW55IGFuZCBhbGwgcmlnaHRzIG9mIGF0dHJpYnV0aW9uIGFuZCBpbnRlZ3JpdHkgb2YgdGhlIG1hdGVyaWFsIEkgYW0gc3VibWl0dGluZyBvciBwb3N0aW5nLCB3aGljaCBpcyBkZXNjcmliZWQgYWJvdmUsIGluY2x1ZGluZyB3YWl2ZXIgb2YgYW55OiAoaSkgcmlnaHQgdG8gY2xhaW0gYXV0aG9yc2hpcCBpbiB0aGUgbWF0ZXJpYWwgd2hlcmV2ZXIgZGlzcGxheWVkIGJ5IExPRiwgYW5kIChpaSkgcmlnaHQgdG8gcHJldmVudCBtb2RpZmljYXRpb24gb2YgdGhlIG1hdGVyaWFsIGluY2x1ZGluZyBjaGFuZ2VzIHRvIGNvbG9yaW5nIGFuZCBsaWdodGluZywgY3JvcHBpbmcsIGFuZCB0aGUgYWRkaXRpb24gb2YgdGV4dCBvciBpbWFnZXMgdG8gdGhlIG1hdGVyaWFsLjxiciAvPkkgd2FycmFudCB0aGF0IEkgaGF2ZSBub3QgcmVtb3ZlZCBvciBhbHRlcmVkIGFueSBjb3B5cmlnaHQgb3IgdHJhZGUgbWFyayBub3RpY2VzLCB3aGljaCBtYXkgYmUgYWZmaXhlZCB0byBvciBjb250YWluZWQgd2l0aGluIHRoZSBtYXRlcmlhbCBJIHN1Ym1pdCBvciBwb3N0LjxiciAvPkJ5IGVudGVyaW5nIG15IGZ1bGwgbmFtZSwgYWRkcmVzcywgYW5kIHRoZSBhYm92ZSBkZXNjcmlwdGlvbiwgYW5kIHNlbGVjdGluZyAnSSBBR1JFRSwgUExFQVNFIFNVQk1JVCcsIEkgaGVyZWJ5IGFncmVlIHRvIHRoZSBhc3NpZ25tZW50IHRlcm1zIHNldCBmb3J0aCBhYm92ZSwgYW5kIEkgZnVydGhlciB3YXJyYW50IHRoYXQgdGhlIGRlc2NyaXB0aW9uIEkgZW50ZXJlZCBhYm92ZSBpcyBhIHRydWUgYW5kIGFjY3VyYXRlIGRlc2NyaXB0aW9uIG9mIHRoZSBtYXRlcmlhbCB0aGF0IEkgYW0gc3VibWl0dGluZyBvciBwb3N0aW5nOjwvcD4NCjwvZGl2Pg0KPHA+Jm5ic3A7PC9wPg==';//zcs=
        //<=zcs---------------------
	
	$GLOBALS['ISC_CFG']["template"] = 'TruckChampFixed';
	$GLOBALS['ISC_CFG']["SiteColor"] = 'blue';
	$GLOBALS['ISC_CFG']["CurrencyToken"] = '$';
	$GLOBALS['ISC_CFG']["CurrencyLocation"] = 'left';
	$GLOBALS['ISC_CFG']["DecimalToken"] = '.';
	$GLOBALS['ISC_CFG']["DecimalPlaces"] = 2;
	$GLOBALS['ISC_CFG']["ThousandsToken"] = ',';

	// Physical Dimensions Settings
	$GLOBALS['ISC_CFG']["WeightMeasurement"] = 'LBS';
	$GLOBALS['ISC_CFG']["LengthMeasurement"] = 'Inches';
	$GLOBALS['ISC_CFG']["DimensionsDecimalToken"] = '.';
	$GLOBALS['ISC_CFG']["DimensionsDecimalPlaces"] = '2';
	$GLOBALS['ISC_CFG']["DimensionsThousandsToken"] = ',';

	$GLOBALS['ISC_CFG']["DisplayDateFormat"] = 'jS M Y';
	$GLOBALS['ISC_CFG']["ExportDateFormat"] = 'jS M Y';
	$GLOBALS['ISC_CFG']["ExtendedDisplayDateFormat"] = 'jS M Y @ g:i A';
	$GLOBALS['ISC_CFG']["AutoThumbSize"] = 150;
	$GLOBALS['ISC_CFG']["HomeFeaturedProducts"] = 100;
    $GLOBALS['ISC_CFG']["HomeFeaturedCategories"] = 100;
	$GLOBALS['ISC_CFG']["HomeNewProducts"] = 8;
	$GLOBALS['ISC_CFG']["HomeBlogPosts"] = 10;
	$GLOBALS['ISC_CFG']["CategoryProductsPerPage"] = 16;
	$GLOBALS['ISC_CFG']["CategoryListDepth"] = 1;
	$GLOBALS['ISC_CFG']["ProductReviewsPerPage"] = 10;
	$GLOBALS['ISC_CFG']["TagCloudsEnabled"] = 0;
	$GLOBALS['ISC_CFG']["ShowAddToCartQtyBox"] = 1;
	$GLOBALS['ISC_CFG']["CaptchaEnabled"] = 1;
	$GLOBALS['ISC_CFG']["ShowCartSuggestions"] = 0;
	$GLOBALS['ISC_CFG']["AdminEmail"] = 'customer_service@truckchamp.com';
	$GLOBALS['ISC_CFG']["OrderEmail"] = 'customer_service@truckchamp.com';
	$GLOBALS['ISC_CFG']['LowInventoryNotificationAddress'] = '';
	$GLOBALS['ISC_CFG']["ShowThumbsInCart"] = 1;
	$GLOBALS['ISC_CFG']["AutoApproveReviews"] = 0;
	$GLOBALS['ISC_CFG']["SearchSuggest"] = 1;
	$GLOBALS['ISC_CFG']["QuickSearch"] = 0;
	$GLOBALS['ISC_CFG']["TaxTypeSelected"] = 1;
	$GLOBALS['ISC_CFG']["PricesIncludeTax"] = 0;
	$GLOBALS['ISC_CFG']["DefaultTaxRateName"] = '';
	$GLOBALS['ISC_CFG']["DefaultTaxRate"] = 0;
	$GLOBALS['ISC_CFG']["DefaultTaxRateBasedOn"] = 'subtotal';
	$GLOBALS['ISC_CFG']["TaxConfigured"] = 1;
	$GLOBALS['ISC_CFG']["DesignMode"] = 0;

	// Shipping Settings
	$GLOBALS['ISC_CFG']["CompanyName"] = 'Truckchamp.com';
	$GLOBALS['ISC_CFG']["CompanyAddress"] = '1739 Cassopolis Street';
	$GLOBALS['ISC_CFG']["CompanyCity"] = 'Elkhart';
	$GLOBALS['ISC_CFG']["CompanyCountry"] = 'United States';
	$GLOBALS['ISC_CFG']["CompanyState"] = 'Indiana';
	$GLOBALS['ISC_CFG']["CompanyZip"] = '46514';
	$GLOBALS['ISC_CFG']['ShippingConfigured'] = true;

	// Checkout Settings
	$GLOBALS['ISC_CFG']["CheckoutMethods"] = 'checkout_authorizenet,checkout_googlecheckout';
	$GLOBALS['ISC_CFG']['CheckoutType'] = 'single';
	$GLOBALS['ISC_CFG']['GuestCheckoutEnabled'] = 1;
	$GLOBALS['ISC_CFG']['GuestCheckoutCreateAccounts'] = 1;

	$GLOBALS['ISC_CFG']["ShowThumbsInControlPanel"] = 1;
	$GLOBALS['ISC_CFG']["EnableSEOUrls"] = 1;
	$GLOBALS['ISC_CFG']['ShowInventory'] = 0;
	$GLOBALS['ISC_CFG']['StoreTimeZone'] = '-11';
	$GLOBALS['ISC_CFG']['StoreDSTCorrection'] = 0;
	$GLOBALS['ISC_CFG']['ShowDownloadTemplates'] = '1';
	$GLOBALS['ISC_CFG']['TagCartQuantityBoxes'] = 'dropdown';
	$GLOBALS['ISC_CFG']['AddToCartButtonPosition'] = 'middle';

	$GLOBALS['ISC_CFG']["RSSNewProducts"] = 1;
	$GLOBALS['ISC_CFG']["RSSPopularProducts"] = 1;
	$GLOBALS['ISC_CFG']["RSSCategories"] = 1;
	$GLOBALS['ISC_CFG']["RSSProductSearches"] = 1;
	$GLOBALS['ISC_CFG']["RSSLatestBlogEntries"] = 1;
	$GLOBALS['ISC_CFG']["RSSItemsLimit"] = 10;
	$GLOBALS['ISC_CFG']["RSSCacheTime"] = 60;
	$GLOBALS['ISC_CFG']["RSSSyndicationIcons"] = 1;

	$GLOBALS['ISC_CFG']['BackupsLocal'] = 1;
	$GLOBALS['ISC_CFG']['BackupsRemoteFTP'] = 0;
	$GLOBALS['ISC_CFG']['BackupsRemoteFTPHost'] = '';
	$GLOBALS['ISC_CFG']['BackupsRemoteFTPUser'] = '';
	$GLOBALS['ISC_CFG']['BackupsRemoteFTPPass'] = '';
	$GLOBALS['ISC_CFG']['BackupsRemoteFTPPath'] = '';
	$GLOBALS['ISC_CFG']['BackupsAutomatic'] = 0;
	$GLOBALS['ISC_CFG']['BackupsAutomaticMethod'] = 'local';
	$GLOBALS['ISC_CFG']['BackupsAutomaticDatabase'] = 0;
	$GLOBALS['ISC_CFG']['BackupsAutomaticImages'] = 0;
	$GLOBALS['ISC_CFG']['BackupsAutomaticDownloads'] = 0;

	$GLOBALS['ISC_CFG']["GoogleMapsAPIKey"] = '';
	$GLOBALS['ISC_CFG']["NotificationMethods"] = '';
	$GLOBALS['ISC_CFG']["CurrencyConfigured"] = 0;
	$GLOBALS['ISC_CFG']["CurrencyMethods"] = 'currency_webservicex';
	$GLOBALS['ISC_CFG']["DefaultCurrencyID"] = 1;
	$GLOBALS['ISC_CFG']["DefaultCurrencyRate"] = 1;

	$GLOBALS['ISC_CFG']["MailXMLAPIValid"] = '1';
	$GLOBALS['ISC_CFG']["MailXMLPath"] = 'http://www.truckchamp.com/em/xml.php';
	$GLOBALS['ISC_CFG']["MailXMLToken"] = '4d7fff191d0c4ff6bdf58dc424a4ec06e6f38f91';
	$GLOBALS['ISC_CFG']["MailUsername"] = 'admin';
	$GLOBALS['ISC_CFG']["UseMailerForNewsletter"] = 0;
	$GLOBALS['ISC_CFG']["UseMailerForOrders"] = 0;
	$GLOBALS['ISC_CFG']["MailNewsletterList"] = 0;
	$GLOBALS['ISC_CFG']["MailNewsletterCustomField"] = 0;
	$GLOBALS['ISC_CFG']["MailOrderList"] = 0;
	$GLOBALS['ISC_CFG']["MailOrderListAutoSubscribe"] = 0;
	$GLOBALS['ISC_CFG']["MailOrderFirstName"] = 0;
	$GLOBALS['ISC_CFG']["MailOrderLastName"] = 0;
	$GLOBALS['ISC_CFG']["MailOrderFullName"] = 0;
	$GLOBALS['ISC_CFG']["MailOrderZip"] = 0;
	$GLOBALS['ISC_CFG']["MailOrderCountry"] = 0;
	$GLOBALS['ISC_CFG']["MailOrderTotal"] = 0;
	$GLOBALS['ISC_CFG']["MailOrderPaymentMethod"] = 0;
	$GLOBALS['ISC_CFG']["MailOrderShippingMethod"] = 0;
	$GLOBALS['ISC_CFG']["MailAutomaticallyTickNewsletterBox"] = 1;
	$GLOBALS['ISC_CFG']["MailAutomaticallyTickOrderBox"] = 0;
	$GLOBALS['ISC_CFG']["UseMailAPIForUpdates"] = 0;
	$GLOBALS['ISC_CFG']["MailProductUpdatesListType"] = '';
	$GLOBALS['ISC_CFG']['ShowMailingListInvite'] = 1;

	$GLOBALS['ISC_CFG']["AnalyticsMethods"] = 'analytics_googleanalytics';

	$GLOBALS['ISC_CFG']['SystemLogging'] = 1;
	$GLOBALS['ISC_CFG']['HidePHPErrors'] = 0;
	$GLOBALS['ISC_CFG']['SystemLogTypes'] = 'general,payment,shipping,notification,ssnx,sql,php';
	$GLOBALS['ISC_CFG']['SystemLogSeverity'] = 'errors,warnings,success,notices';
	$GLOBALS['ISC_CFG']['SystemLogMaxLength'] = 0;
	$GLOBALS['ISC_CFG']['AdministratorLogging'] = 1;
	$GLOBALS['ISC_CFG']['AdministratorLogMaxLength'] = 0;
	$GLOBALS['ISC_CFG']['DebugMode'] = 1;

	$GLOBALS['ISC_CFG']['EnableReturns'] = 1;
	$GLOBALS['ISC_CFG']['ReturnReasons'] = array (
  0 => 'Received Wrong Product',
  1 => 'Wrong Product Ordered',
  2 => 'There Was A Problem With The Product',
);
	$GLOBALS['ISC_CFG']['ReturnActions'] = array (
  0 => 'Repair',
  1 => 'Replacement',
  2 => 'Store Credit',
);
	$GLOBALS['ISC_CFG']['ReturnCredits'] = 1;
	$GLOBALS['ISC_CFG']['ReturnInstructions'] = '';
	$GLOBALS['ISC_CFG']['EmailOwnerOnReturn'] = 1;
	$GLOBALS['ISC_CFG']['SendReturnConfirmation'] = 1;
	$GLOBALS['ISC_CFG']['NotifyOnReturnStatusChange'] = 1;

	$GLOBALS['ISC_CFG']['EnableGiftCertificates'] = 1;
	$GLOBALS['ISC_CFG']['GiftCertificateAmounts'] = array (
);
	$GLOBALS['ISC_CFG']['GiftCertificateCustomAmounts'] = 1;
	$GLOBALS['ISC_CFG']['GiftCertificateMinimum'] = 1;
	$GLOBALS['ISC_CFG']['GiftCertificateMaximum'] = 1000;
	$GLOBALS['ISC_CFG']['GiftCertificateExpiry'] = 864000;
	$GLOBALS['ISC_CFG']['GiftCertificateThemes'] = 'Birthday.html,Christmas.html,General.html';
	
	$GLOBALS['ISC_CFG']['EnableCompanyGiftCertificates'] = 1;
	$GLOBALS['ISC_CFG']['CompanyGiftCertificateExpiry'] = 604800;

    // Add by NI_20100901_Jack
    // Add by NI_20100831_Jack
    $GLOBALS['ISC_CFG']['CompanyGiftCertificateMinimum'] = 1;
    $GLOBALS['ISC_CFG']['CompanyGiftCertificateMaximum'] = 1000;
	$GLOBALS['ISC_CFG']['UpdateInventoryLevels'] = 1;
	$GLOBALS['ISC_CFG']['OrderStatusNotifications'] = '11,2,4';

	$GLOBALS['ISC_CFG']['AddonModules'] = '';

	$GLOBALS['ISC_CFG']['AKBIsConfigured'] = '0';
	$GLOBALS['ISC_CFG']['AKBPath'] = '';
	$GLOBALS['ISC_CFG']['ARSPageIds'] = '';
	$GLOBALS['ISC_CFG']['ARSIntegrated'] = '';

	$GLOBALS['ISC_CFG']['ShowProductPrice'] = 1;
	$GLOBALS['ISC_CFG']['ShowProductSKU'] = 1;
	$GLOBALS['ISC_CFG']['ShowProductWeight'] = 1;
	$GLOBALS['ISC_CFG']['ShowProductBrand'] = 1;
	$GLOBALS['ISC_CFG']['ShowProductShipping'] = 1;
	$GLOBALS['ISC_CFG']['ShowProductRating'] = 1;
	$GLOBALS['ISC_CFG']['ShowBestOffer'] = 1; 
	$GLOBALS['ISC_CFG']['ShowOnSale'] = 1;
	$GLOBALS['ISC_CFG']['DisplayPriceRange'] = 1;
	$GLOBALS['ISC_CFG']['ProductImageMode'] = 'popup';

	// DO NOT CHANGE THIS VARIABLE OR YOU WILL BREAK ORDERS
	$GLOBALS['ISC_CFG']["EncryptionToken"] = '929b00977e8c6a34da29d870b855b6ab';

	$GLOBALS['ISC_CFG']["EnableWishlist"] = 1;
	$GLOBALS['ISC_CFG']["EnableAccountCreation"] = 1;
	$GLOBALS['ISC_CFG']['EnableProductReviews'] = 1;
	$GLOBALS['ISC_CFG']['EnableProductComparisons'] = 0;
	$GLOBALS['ISC_CFG']["EnableOrderComments"] = 1;
	$GLOBALS['ISC_CFG']["EnableOrderTermsAndConditions"] = 0;
	$GLOBALS['ISC_CFG']["OrderTermsAndConditionsType"] = '';
	$GLOBALS['ISC_CFG']["OrderTermsAndConditionsLink"] = '';
	$GLOBALS['ISC_CFG']["OrderTermsAndConditions"] = '';

	// Logo Settings
	$GLOBALS['ISC_CFG']["LogoFields"] = array (
  0 => 'TruckChamp',
  1 => 'Example2',
);
	$GLOBALS['ISC_CFG']["ForceWebsiteTitleText"] = 0;
	$GLOBALS['ISC_CFG']['UseAlternateTitle'] = 1;
	$GLOBALS['ISC_CFG']['AlternateTitle'] = 'TruckChamp';
	$GLOBALS['ISC_CFG']['UsingLogoEditor'] = 0;
	$GLOBALS['ISC_CFG']['UsingTemplateLogo'] = 0;

	$GLOBALS['ISC_CFG']['AffiliateConversionTrackingCode'] = '';

	$GLOBALS['ISC_CFG']['GuestCustomerGroup'] = 0;
	$GLOBALS['ISC_CFG']['ForwardInvoiceEmails'] = '';

	// Mail Settings
	$GLOBALS['ISC_CFG']['MailUseSMTP'] = 0;
	$GLOBALS['ISC_CFG']['MailSMTPServer'] = '';
	$GLOBALS['ISC_CFG']['MailSMTPUsername'] = '';
	$GLOBALS['ISC_CFG']['MailSMTPPassword'] = '';
	$GLOBALS['ISC_CFG']['MailSMTPPort'] = '';

	// Curl Proxy Settings
	$GLOBALS['ISC_CFG']['HTTPProxyServer'] = '';
	$GLOBALS['ISC_CFG']['HTTPProxyPort'] = '';
	$GLOBALS['ISC_CFG']['HTTPSSLVerifyPeer'] = 0;

	// Digital Download Settings
	$GLOBALS['ISC_CFG']['DigitalOrderHandlingFee'] = 0;

	// Accounting Settings
	$GLOBALS['ISC_CFG']['AccountingMethods'] = '';

	// Live Chat Modules
	$GLOBALS['ISC_CFG']['LiveChatModules'] = 'livechat_liveperson';

	//Category and Brand image dimensions
	$GLOBALS['ISC_CFG']['CategoryPerRow'] = 4;
	$GLOBALS['ISC_CFG']['CategoryImageWidth'] = 120;
	$GLOBALS['ISC_CFG']['CategoryImageHeight'] = 120;
	$GLOBALS['ISC_CFG']['CategoryDefaultImage'] = '';
	$GLOBALS['ISC_CFG']['BrandPerRow'] = 3;
	$GLOBALS['ISC_CFG']['BrandImageWidth'] = 120;
	$GLOBALS['ISC_CFG']['BrandImageHeight'] = 120;
	$GLOBALS['ISC_CFG']['BrandDefaultImage'] = '';

	// Product Images
	$GLOBALS['ISC_CFG']['DefaultProductImage'] = 'template';

	//Display the 'Add to Cart' link on all the product panels
	$GLOBALS['ISC_CFG']['ShowAddToCartLink'] = 1;

	$GLOBALS['ISC_CFG']['CategoryListingMode'] = 'single';
	$GLOBALS['ISC_CFG']['CategoryDisplayMode'] = 'grid';
	$GLOBALS['ISC_CFG']['TagCloudMinSize'] = 80;
	$GLOBALS['ISC_CFG']['TagCloudMaxSize'] = 300;

	// Bulk Discounts
	$GLOBALS['ISC_CFG']['BulkDiscountEnabled'] = 1;

	$GLOBALS['ISC_CFG']['EnableProductTabs'] = 1;

	$GLOBALS['ISC_CFG']['MultipleShippingAddresses'] = 0;

	// Vendor Edition Settings
	$GLOBALS['ISC_CFG']['VendorLogoSize'] = '120x120';
	$GLOBALS['ISC_CFG']['VendorPhotoSize'] = '120x120';

	// The factoring dimension for a shipping quote (depth, height or width with default of depth)
	$GLOBALS['ISC_CFG']['ShippingFactoringDimension'] = 'depth';
?>