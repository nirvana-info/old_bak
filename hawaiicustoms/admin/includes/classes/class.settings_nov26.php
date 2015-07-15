<?php
	class ISC_ADMIN_SETTINGS
	{
		public $all_vars = array (
			'AllowPurchasing',
			'Language',
			'serverStamp',
			'HostingProvider',
			'UseWYSIWYG',
			'UseSSL',
			'dbType',
			'dbEncoding',
			'dbServer',
			'dbUser',
			'dbPass',
			'dbDatabase',
			'tablePrefix',
			'StoreName',
			'StoreAddress',
			'LogoType',
			'StoreLogo',
			'ShopPath',
			'AppPath',
			'CharacterSet',
			'HomePagePageTitle',
			'MetaKeywords',
			'MetaDesc',
			'DownloadDirectory',
			'ImageDirectory',
            'InstallImageDirectory', 
            'VideoDirectory',
            'InstallVideoDirectory', 
			'template',
			'SiteColor',
			'CurrencyToken',
			'CurrencyLocation',
			'DecimalToken',
			'DecimalPlaces',
			'ThousandsToken',
			'WeightMeasurement',
			'LengthMeasurement',
			'DisplayDateFormat',
			'ExportDateFormat',
			'ExtendedDisplayDateFormat',
			'AutoThumbSize',
			'HomeFeaturedProducts',
            'HomeFeaturedCategories',
			'HomeNewProducts',
			'HomeBlogPosts',
			'CategoryProductsPerPage',
			'CategoryListDepth',
			'ProductReviewsPerPage',
			'TagCloudsEnabled',
			'ShowAddToCartQtyBox',
			'CaptchaEnabled',
			'ShowCartSuggestions',
			'AdminEmail',
			'OrderEmail',
			'LowInventoryNotificationAddress',
			'ShowThumbsInCart',
			'AutoApproveReviews',
			'SearchSuggest',
			'QuickSearch',
			'TaxTypeSelected',
			'PricesIncludeTax',
			'DefaultTaxRate',
			'DefaultTaxRateName',
			'DefaultTaxRateBasedOn',
			'TaxConfigured',
			'DesignMode',
			'CompanyName',
			'CompanyAddress',
			'CompanyCity',
			'CompanyCountry',
			'CompanyState',
			'CompanyZip',
			'CheckoutMethods',
			'ShowThumbsInControlPanel',
			'EnableSEOUrls',
			'ShowInventory',
			'StoreTimeZone',
			'StoreDSTCorrection',
			'ShowDownloadTemplates',
			'RSSNewProducts',
			'RSSPopularProducts',
			'RSSCategories',
			'RSSProductSearches',
			'RSSLatestBlogEntries',
			'RSSItemsLimit',
			'RSSCacheTime',
			'RSSSyndicationIcons',
			'BackupsLocal',
			'BackupsRemoteFTP',
			'BackupsRemoteFTPHost',
			'BackupsRemoteFTPUser',
			'BackupsRemoteFTPPass',
			'BackupsRemoteFTPPath',
			'BackupsAutomatic',
			'BackupsAutomaticMethod',
			'BackupsAutomaticDatabase',
			'BackupsAutomaticImages',
			'BackupsAutomaticDownloads',
			'GoogleMapsAPIKey',
			'NotificationMethods',
			'CurrencyMethods',
			'CurrencyConfigured',
			'DefaultCurrencyID',
			'DefaultCurrencyRate',
			'MailXMLPath',
			'MailXMLToken',
			'MailUsername',
			'UseMailerForNewsletter',
			'UseMailerForOrders',
			'MailNewsletterList',
			'MailNewsletterCustomField',
			'MailXMLAPIValid',
			'MailOrderList',
			'MailOrderFirstName',
			'MailOrderLastName',
			'MailOrderFullName',
			'MailOrderZip',
			'MailOrderCountry',
			'MailOrderTotal',
			'MailOrderPaymentMethod',
			'MailOrderShippingMethod',
			'MailAutomaticallyTickNewsletterBox',
			'MailAutomaticallyTickOrderBox',
			'UseMailAPIForUpdates',
			'MailProductUpdatesListType',
			'AnalyticsMethods',
			'SystemLogging',
			'HidePHPErrors',
			'SystemLogTypes',
			'SystemLogSeverity',
			'SystemLogMaxLength',
			'AdministratorLogging',
			'AdministratorLogMaxLength',
			'DebugMode',
			'EnableReturns',
			'ReturnReasons',
			'ReturnActions',
			'ReturnCredits',
			'ReturnInstructions',
			'EmailOwnerOnReturn',
			'SendReturnConfirmation',
			'NotifyOnReturnStatusChange',
			'EnableGiftCertificates',
			'GiftCertificateAmounts',
			'GiftCertificateCustomAmounts',
			'GiftCertificateMinimum',
			'GiftCertificateMaximum',
			'GiftCertificateExpiry',
			'GiftCertificateThemes',
			'UpdateInventoryLevels',
			'OrderStatusNotifications',
			'AddonModules',
			'AKBIsConfigured',
			'AKBPath',
			'ARSPageIds',
			'ARSIntegrated',
			'ShowProductPrice',
			'ShowProductSKU',
			'ShowProductWeight',
			'ShowProductBrand',
			'ShowProductShipping',
			'ShowProductRating',
            'ShowBestOffer',
            'ShowOnSale',
			'EncryptionToken',
			'EnableWishlist',
			'EnableAccountCreation',
			'EnableOrderComments',
			'EnableOrderTermsAndConditions',
			'OrderTermsAndConditionsType',
			'OrderTermsAndConditions',
			'OrderTermsAndConditionsLink',
			'EnablePersistentShoppingCart',
			'PersistentShoppingCartAmount',
			'PersistentShoppingCartType',
			'EnableProductReviews',
			'EnableProductComparisons',
			'LogoFields',
			'ForceWebsiteTitleText',
			'UseAlternateTitle',
			'AlternateTitle',
			'UsingTemplateLogo',
			'UsingLogoEditor',
			'TagCartQuantityBoxes',
			'AddToCartButtonPosition',
			'AffiliateConversionTrackingCode',
			'GuestCustomerGroup',
			'ForwardInvoiceEmails',
			'MailUseSMTP',
			'MailSMTPServer',
			'MailSMTPUsername',
			'MailSMTPPassword',
			'MailSMTPPort',
			'HTTPProxyServer',
			'HTTPProxyPort',
			'HTTPSSLVerifyPeer',
			'DimensionsDecimalToken',
			'DimensionsThousandsToken',
			'DimensionsDecimalPlaces',
			'MailOrderListAutoSubscribe',
			'DigitalOrderHandlingFee',
			'ShippingConfigured',
			'ProductImageMode',
			'CategoryDisplayMode',
			'CheckoutType',
			'GuestCheckoutEnabled',
			'GuestCheckoutCreateAccounts',
			'AccountingMethods',
			'QuickBooksPassword',
			'QuickBooksUsername',
			'QuickBooksFileID',
			'LiveChatModules',
			'CategoryPerRow',
			'CategoryImageWidth',
			'CategoryImageHeight',
			'CategoryDefaultImage',
			'BrandPerRow',
			'BrandImageWidth',
			'BrandImageHeight',
			'BrandDefaultImage',
			'ShowMailingListInvite',
			'ShowAddToCartLink',
			'CategoryListingMode',
			'TagCloudMinSize',
			'TagCloudMaxSize',
			'BulkDiscountEnabled',
			'EnableProductTabs',
			'MultipleShippingAddresses',
			'VendorLogoSize',
			'VendorPhotoSize',
			'ShippingFactoringDimension',
			'DefaultProductImage',
		);

		public $timezones = array (
			'-11' => 'Minus1100',
			'-10' => 'Minus1000',
			'-9' => 'Minus900',
			'-8' => 'Minus800',
			'-7' => 'Minus700',
			'-6' => 'Minus600',
			'-5' => 'Minus500',
			'-4' => 'Minus400',
			'-3.5' => 'Minus330',
			'-3' => 'Minus300',
			'-2' => 'Minus200',
			'-1' => 'Minus100',
			'0' => '000',
			'1' => '100',
			'2' => '200',
			'3' => '300',
			'3.5' => '330',
			'4' => '400',
			'4.5' => '430',
			'5' => '500',
			'5.5' => '530',
			'6' => '600',
			'7' => '700',
			'8' => '800',
			'9' => '900',
			'9.5' => '930',
			'10' => '1000',
			'11' => '1100',
			'12' => '1200',
		);

		/**
		 * The constructor.
		 */
		public function __construct()
		{
			if(!gzte11(ISC_LARGEPRINT)) {
				$GLOBALS[base64_decode('SGlkZVN0YWZmTG9ncw==')] = "none";
			}

			if (isset($_REQUEST['currentTab'])) {
				$GLOBALS['CurrentTab'] = (int)$_REQUEST['currentTab'];
			} else {
				$GLOBALS['CurrentTab'] = 0;
			}
		}

		public function HandleToDo($Do)
		{

			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('settings');
			if (isc_strtolower($Do) === 'settingsfooterimage') {
				$this->ManageClickSettings();
				return;
			}

			if (!$GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Settings)) {
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
				return;
			}

			$GLOBALS['BreadcrumEntries'] = array (
				GetLang('Home') => "index.php",
				GetLang('Settings') => "index.php?ToDo=viewSettings",
			);

			switch (isc_strtolower($Do))
			{
				case "saveupdatedaffiliatesettings":
				{
					$GLOBALS['BreadcrumEntries'][GetLang('AffiliateSettings')] = "index.php?ToDo=viewAffiliateSettings";
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->SaveUpdatedAffiliateSettings();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					break;
				}
				case "viewaffiliatesettings":
				{
					$GLOBALS['BreadcrumEntries'][GetLang('AffiliateSettings')] = "index.php?ToDo=viewAffiliateSettings";
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->ManageAffiliateSettings();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					break;
				}
				case "saveupdatedmappingsettings":
				{
					$GLOBALS['BreadcrumEntries'][GetLang('AffiliateSettings')] = "index.php?ToDo=viewAffiliateSettings";
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->SaveUpdatedMappingSettings();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					break;
				}
				case "viewmappingsettings":
				{
					$GLOBALS['BreadcrumEntries'][GetLang('AffiliateSettings')] = "index.php?ToDo=viewAffiliateSettings";
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->ManageMappingSettings();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					break;
				}
				/* Baskaran Added starts */
                case "viewbedsizesettings":
                {
                    $GLOBALS['BreadcrumEntries'][GetLang('ManageBedsize')] = "index.php?ToDo=viewBedsizeSettings";
                    if(!isset($_GET['ajax']))    {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                    }
                    $this->ManageBedsize();
                    if(!isset($_GET['ajax']))    {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                    }
                    break;
                }
                case "createbedsizesettings":
                {
                    $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('ManageBedsize') => "index.php?ToDo=viewBedsizeSettings", GetLang('AddBedsize') => "index.php?ToDo=createBedsizesettings");
                    $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                    $this->CreateBedsize();
                    $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                    break;
                }
                case "savebedsizesettings":
                {
                    $GLOBALS['BreadcrumEntries'][GetLang('ManageBedsize')] = "index.php?ToDo=viewBedsizeSettings";
                    $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                    $this->saveBedsize();
                    $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                    break;
                }
                case "editbedsizesettings":
                {
                    $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('ManageBedsize') => "index.php?ToDo=viewBedsizeSettings", GetLang('EditBedsize') => "index.php?ToDo=editBedsizesettings");
                    $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                    $this->editbedsize();
                    $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                    break;
                }
                case "saveeditedbedsizesettings":
                {
                    $GLOBALS['BreadcrumEntries'][GetLang('ManageBedsize')] = "index.php?ToDo=viewBedsizeSettings";
                    $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                    $this->SaveEditedBedsize();
                    $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                    break;
                }
                case "deletebedsizesettings":
                {
                    $GLOBALS['BreadcrumEntries'][GetLang('ManageBedsize')] = "index.php?ToDo=viewBedsizeSettings";
                    $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                    $this->deleteBedsize();
                    $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                    break;
                }
                case "viewcabsizesettings":
                {
                    $GLOBALS['BreadcrumEntries'][GetLang('ManageBedsize')] = "index.php?ToDo=viewCabsizeSettings";
                    if(!isset($_GET['ajax']))    {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                    }
                    $this->ManageCabsize();
                    if(!isset($_GET['ajax']))    {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                    }
                    break;
                }
                case "createcabsizesettings":
                {
                    $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('ManageCabsize') => "index.php?ToDo=viewCabsizeSettings", GetLang('AddCabsize') => "index.php?ToDo=createCabsizesettings");
                    $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                    $this->CreateCabsize();
                    $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                    break;
                }
                case "savecabsizesettings":
                {
                    $GLOBALS['BreadcrumEntries'][GetLang('ManageCabsize')] = "index.php?ToDo=viewBedsizeSettings";
                    $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                    $this->saveCabsize();
                    $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                    break;
                }
                case "editcabsizesettings":
                {
                    $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('ManageCabsize') => "index.php?ToDo=viewCabsizeSettings", GetLang('EditCabsize') => "index.php?ToDo=editCabsizesettings");
                    $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                    $this->editcabsize();
                    $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                    break;
                }
                case "saveeditedcabsizesettings":
                {
                    $GLOBALS['BreadcrumEntries'][GetLang('ManageCabsize')] = "index.php?ToDo=viewBedsizeSettings";
                    $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                    $this->SaveEditedCabsize();
                    $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                    break;
                }
                case "deletecabsizesettings":
                {
                    $GLOBALS['BreadcrumEntries'][GetLang('ManageCabsize')] = "index.php?ToDo=viewBedsizeSettings";
                    $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                    $this->deleteCabsize();
                    $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                    break;
                }
                /* Baskaran Added ends */
				case "saveupdatedkbsettings":
				{
					$GLOBALS['BreadcrumEntries'][GetLang('KBSettings')] = "index.php?ToDo=viewKBSettings";
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->SaveUpdatedKBSettings();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					break;
				}
				case "viewkbsettings":
				{
					$GLOBALS['BreadcrumEntries'][GetLang('KBSettings')] = "index.php?ToDo=viewKBSettings";
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->ManageKBSettings();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					break;
				}
				case "saveupdatedanalyticssettings":
				{
					$GLOBALS['BreadcrumEntries'][GetLang('AnalyticsSettings')] = "index.php?ToDo=viewAnalyticsSettings";
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->SaveUpdatedAnalyticsSettings();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					break;
				}
				case "viewanalyticssettings":
				{
					$GLOBALS['BreadcrumEntries'][GetLang('AnalyticsSettings')] = "index.php?ToDo=viewAnalyticsSettings";
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->ManageAnalyticsSettings();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					break;
				}
				case "saveupdatedmailsettings":
				{
					$GLOBALS['BreadcrumEntries'][GetLang('MailSettings')] = "index.php?ToDo=viewMailSettings";
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->SaveUpdatedMailSettings();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					break;
				}
				case "viewmailsettings":
				{
					$GLOBALS['BreadcrumEntries'][GetLang('MailSettings')] = "index.php?ToDo=viewMailSettings";
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->ManageMailSettings();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					break;
				}
				case "testnotificationmethodsettings":
				{
					$this->TestNotificationMethod();
					break;
				}
				case "saveupdatednotificationsettings":
				{
					$GLOBALS['BreadcrumEntries'][GetLang('NotificationSettings')] = "index.php?ToDo=viewNotificationSettings";
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->SaveUpdatedNotificationSettings();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					break;
				}
				case "viewnotificationsettings":
				{
					$GLOBALS['BreadcrumEntries'][GetLang('NotificationSettings')] = "index.php?ToDo=viewNotificationSettings";
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->ManageNotificationSettings();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					break;
				}
				case "saveupdatedsettings":
				{
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->SaveUpdatedSettings();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					break;
				}
				case "viewcurrencysettings":
				{
					$GLOBALS['BreadcrumEntries'][GetLang('CurrencySettings')] = "index.php?ToDo=viewCurrencySettings";
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->ManageCurrencySettings();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					break;
				}
				case "settingsaddcurrency":
				{
					$GLOBALS['BreadcrumEntries'][GetLang('CurrencySettings')] = "index.php?ToDo=viewCurrencySettings";
					$GLOBALS['BreadcrumEntries'][GetLang('AddCurrency')] = "index.php?ToDo=settingsAddCurrency";
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->AddCurrency();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					break;
				}
				case "settingssavenewcurrency":
				{
					$GLOBALS['BreadcrumEntries'][GetLang('CurrencySettings')] = "index.php?ToDo=viewCurrencySettings";
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->SaveNewCurrency();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					break;
				}
				case "settingsdeletecurrencies":
				{
					$GLOBALS['BreadcrumEntries'][GetLang('CurrencySettings')] = "index.php?ToDo=viewCurrencySettings";
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->DeleteCurrencies();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					break;
				}
				case "settingseditcurrency":
				{
					$GLOBALS['BreadcrumEntries'][GetLang('CurrencySettings')] = "index.php?ToDo=viewCurrencySettings";
					$GLOBALS['BreadcrumEntries'][GetLang('EditCurrency')] = "index.php?ToDo=settingsEditCurrency";
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->EditCurrency();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					break;
				}
				case "settingseditcurrencystatus":
				{
					$GLOBALS['BreadcrumEntries'][GetLang('CurrencySettings')] = "index.php?ToDo=viewCurrencySettings";

					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->UpdateCurrencyStatus();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					break;
				}
				case "settingssaveupdatedcurrency":
				{
					$GLOBALS['BreadcrumEntries'][GetLang('CurrencySettings')] = "index.php?ToDo=viewCurrencySettings";
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->SaveUpdatedCurrency();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					break;
				}
				case "settingssavecurrencysettings":
				{
					$GLOBALS['BreadcrumEntries'][GetLang('CurrencySettings')] = "index.php?ToDo=viewCurrencySettings";
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->SaveUpdatedCurrencySettings();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					break;
				}
				case "settingssetasdefaultcurrency":
				{
					$GLOBALS['BreadcrumEntries'][GetLang('CurrencySettings')] = "index.php?ToDo=viewCurrencySettings";
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->SaveSetAsDefaultCurrency();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					break;
				}
				case "settingsupdateprices":
				{
					$this->UpdateProductPrices();
					break;
				}
				case "saveupdatedreturnssettings":
				{
					if (!gzte11(ISC_LARGEPRINT)) {
						exit;
					}
					$GLOBALS['BreadcrumEntries'][GetLang('ReturnsSettings')] = "index.php?ToDo=viewReturnsSettings";

					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->SaveUpdatedReturnsSettings();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();

					break;
				}
				case "viewreturnssettings":
				{
					if (!gzte11(ISC_LARGEPRINT)) {
						exit;
					}

					$GLOBALS['BreadcrumEntries'][GetLang('ReturnsSettings')] = "index.php?ToDo=viewReturnsSettings";

					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->ManageReturnsSettings();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					break;
				}
				case "saveupdatedgiftcertificatesettings":
				{
					if (!gzte11(ISC_LARGEPRINT)) {
						exit;
					}

					$this->SaveUpdatedGiftCertificateSettings();
					break;
				}
				case "viewgiftcertificatesettings":
				{
					if (!gzte11(ISC_LARGEPRINT)) {
						exit;
					}

					$GLOBALS['BreadcrumEntries'][GetLang('GiftCertificateSettings')] = "index.php?ToDo=viewGiftCertificateSettings";
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->ManageGiftCertificateSettings();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					break;
				}
				case "viewaddonsettings":
				{
					$GLOBALS['BreadcrumEntries'][GetLang('AddonSettings')] = "index.php?ToDo=viewAddonSettings";
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->ManageAddonSettings();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					break;
				}
				case "saveupdatedaddonsettings":
				{
					$GLOBALS['BreadcrumEntries'][GetLang('AddonSettings')] = "index.php?ToDo=viewAddonSettings";
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->SaveUpdatedAddonSettings();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					break;
				}
				default:
				{
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->ManageSettings();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
				}
			}
		}

		private function SaveUpdatedGiftCertificateSettings()
		{
			$boolean = array (
				'EnableGiftCertificates',
				'GiftCertificateCustomAmounts',
			);

			foreach ($boolean as $var) {
				if (isset($_POST[$var]) && $_POST[$var] == 1) {
					$GLOBALS['ISC_NEW_CFG'][$var] = 1;
				} else {
					$GLOBALS['ISC_NEW_CFG'][$var] = 0;
				}
			}

			$positive_ints = array (
				'GiftCertificateMinimum',
				'GiftCertificateMaximum',
			);

			foreach ($positive_ints as $var) {
				if (isset($_POST[$var]) && (int) $_POST[$var] > 0) {
					$GLOBALS['ISC_NEW_CFG'][$var] = (int) $_POST[$var];
				} else {
					$GLOBALS['ISC_NEW_CFG'][$var] = 0;
				}
			}

			if (isset($_POST['GiftCertificateExpiry']) && isset($_POST['EnableGiftCertificateExpiry'])) {
				if ($_POST['GiftCertificateExpiryRange'] == "years") {
					$_POST['GiftCertificateExpiry'] *= 365;
				} else if ($_POST['GiftCertificateExpiryRange'] == "months") {
					$_POST['GiftCertificateExpiry'] *= 30;
				} else if ($_POST['GiftCertificateExpiryRange'] == "weeks") {
					$_POST['GiftCertificateExpiry'] *= 7;
				}
				$GLOBALS['ISC_NEW_CFG']['GiftCertificateExpiry'] = $_POST['GiftCertificateExpiry'] * 86400;
			}
			else {
				$GLOBALS['ISC_NEW_CFG']['GiftCertificateExpiry'] = 0;
			}

			// Get a list of the enabled gift certificate themes
			// TODO: validate that all the themes are valid filenames
			$_POST['GiftCertificateThemes'] = array_map('trim', $_POST['GiftCertificateThemes']);
			$GLOBALS['ISC_NEW_CFG']['GiftCertificateThemes'] = implode(',', $_POST['GiftCertificateThemes']);

			$amounts = preg_split("#\s+#", $_POST['GiftCertificateAmounts'], -1, PREG_SPLIT_NO_EMPTY);
			$PredefinedAmounts = array();
			foreach ($amounts as $amount) {
				if (CNumeric($amount) > 0 && trim($amount) != "") {
					$PredefinedAmounts[] = trim(CNumeric($amount));
				}
			}
			// GiftCertificateAmounts is var_exported in CommitSettings so no need to addslashes here
			$GLOBALS['ISC_NEW_CFG']['GiftCertificateAmounts'] = $PredefinedAmounts;

			if ($this->CommitSettings($messages)) {
				// Log this action
				$GLOBALS['ISC_CLASS_LOG']->LogAdminAction();
				FlashMessage(GetLang('GiftCertificateSettingsSavedSuccessfully'), MSG_SUCCESS, 'index.php?ToDo=viewGiftCertificateSettings');
			} else {
				FlashMessage(sprintf(GetLang('GiftCertificateSettingsNotSaved'), $messages), MSG_ERROR, 'index.php?ToDo=viewGiftCertificateSettings');
			}
		}

		private function ManageGiftCertificateSettings($messages=array())
		{
			$GLOBALS['Message'] = GetFlashMessageBoxes();

			// Get the list of predefined amounts that are enabled and format them
			if (is_array(GetConfig('GiftCertificateAmounts'))) {
				$gift_cert_amounts = GetConfig('GiftCertificateAmounts');
				$gift_cert_amounts = array_map('FormatPrice', $gift_cert_amounts);
				$GLOBALS['GiftCertificateAmountsArea'] = implode("\r\n", $gift_cert_amounts);
			}

			// Get a listing of the available themes
			$availableThemes = scandir(APP_ROOT."/../templates/__gift_themes");
			$enabledThemes = explode(",", GetConfig('GiftCertificateThemes'));
			$GLOBALS['ThemeOptions'] = '';
			$GLOBALS['ThemePreviews'] = '';
			foreach ($availableThemes as $id => $theme) {
				// Strip off anything after the period
				$themeName = explode(".html", $theme);
				if ($themeName[0] == $theme) {
					continue;
				}
				$themeName = $themeName[0];

				$sel = '';
				if (in_array($theme, $enabledThemes)) {
					$sel = 'checked="checked"';
				}
				$GLOBALS['ThemeOptions'] .= sprintf("<label><input type='checkbox' name='GiftCertificateThemes[]' value='%s' %s /> %s <a style='color: gray;' href='#' onclick='UpdateGiftCertificatePreview(%d, \"%s\"); return false;'>(Preview)</a></label><br />", $theme, $sel, $themeName, $id, $themeName);

				// Does a preview image exist?
				$previewFile = "../templates/__gift_themes/".$themeName.".jpg";
				if (file_exists(APP_ROOT . "/" . $previewFile)) {
					$GLOBALS['ThemePreviews'] .= sprintf("<img src='%s' alt='' style='display: none; border: 1px solid #000;' id='ThemePreview_%d' />", $previewFile, $id);
				}
			}

			// Are gift certificates enabled?
			if (GetConfig('EnableGiftCertificates') == 1) {
				$GLOBALS['IsEnableGiftCertificates'] = "checked=\"checked\"";
			}

			// Can customers enter their own amount for the gift certificates?
			if (GetConfig('GiftCertificateCustomAmounts') == 1) {
				$GLOBALS['IsGiftCertificateCustomAmounts'] = "checked=\"checked\"";
				$GLOBALS['HideSelectAmounts'] = "none";
			}
			else {
				$GLOBALS['IsGiftCertificateSelectAmounts'] = "checked=\"checked\"";
				$GLOBALS['HideCustomAmounts'] = "none";
			}

			$GLOBALS['GiftCertificateMinimum'] = GetConfig('GiftCertificateMinimum');
			$GLOBALS['GiftCertificateMaximum'] = GetConfig('GiftCertificateMaximum');

			// Are gift certificates set to expire after a certain time period?
			if (GetConfig('GiftCertificateExpiry') > 0) {
				$GLOBALS['IsGiftCertificateExpiry'] = "checked=\"checked\"";
				if (GetConfig('GiftCertificateExpiry')) {
					$days = GetConfig('GiftCertificateExpiry')/86400;
					if (($days % 365) == 0) {
						$GLOBALS['ExpiresAfter'] = $days/365;
						$GLOBALS['RangeYearsSelected'] = "selected=\"selected\"";
					}
					else if (($days % 30) == 0) {
						$GLOBALS['ExpiresAfter'] = $days/30;
						$GLOBALS['RangeMonthsSelected'] = "selected=\"selected\"";
					}
					else if (($days % 7) == 0) {
						$GLOBALS['ExpiresAfter'] = $days/7;
						$GLOBALS['RageWeeksSelected'] = "selected=\"selected\"";
					}
					else {
						$GLOBALS['ExpiresAfter'] = $days;
					}
				}
			}

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("settings.giftcertificates.manage");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}

		private function SaveUpdatedReturnsSettings()
		{
			// Get the return reasons the user entered and convert them to an array.
			$returnreasons = explode("\n", $_POST['returnreasons']);
			$ReturnReasons = array();
			foreach ($returnreasons as $reason) {
				if (!trim($reason)) {
					continue;
				}

				$ReturnReasons[] = trim($reason);
			}
			// ReturnReasons is var_exported in CommitSettings so no need to addslashes here
			$GLOBALS['ISC_NEW_CFG']['ReturnReasons'] = $ReturnReasons;

			// Get the return actions the user entered and convert them to an array.
			$returnactions = explode("\n", $_POST['returnactions']);
			$ReturnActions = array();
			foreach ($returnactions as $action) {
				if (!trim($action)) {
					continue;
				}

				$ReturnActions[] = trim($action);
			}
			// ReturnActions is var_exported in CommitSettings so no need to addslashes here
			$GLOBALS['ISC_NEW_CFG']['ReturnActions'] = $ReturnActions;

			$boolean = array (
				'enablereturns'			=> 'EnableReturns',
				'returncredits'			=> 'ReturnCredits',
				'returnotifyowner'		=> 'EmailOwnerOnReturn',
				'returnnotifycustomer'	=> 'SendReturnConfirmation',
				'returnnotifystatus'	=> 'NotifyOnReturnStatusChange',
			);

			foreach ($boolean as $post_var => $config_var) {
				if (isset($_POST[$post_var]) && $_POST[$post_var] == 1) {
					$GLOBALS['ISC_NEW_CFG'][$config_var] = 1;
				} else {
					$GLOBALS['ISC_NEW_CFG'][$config_var] = 0;
				}
			}

			// Incoming return instructions?
			if (isset($_POST['returninstructions']) && $_POST['returninstructions'] != '') {
				$GLOBALS['ISC_NEW_CFG']['ReturnInstructions'] = trim($_POST['returninstructions']);
			}
			else {
				$GLOBALS['ISC_NEW_CFG']['ReturnInstructions'] = '';
			}

			$messages = array();

			if ($this->CommitSettings($messages)) {
				// Log this action
				$GLOBALS['ISC_CLASS_LOG']->LogAdminAction();
				FlashMessage(GetLang('ReturnsSettingsSavedSuccessfully'), MSG_SUCCESS, 'index.php?ToDo=viewReturnsSettings');
			} else {
				FlashMessage(sprintf(GetLang('ReturnsSettingsNotSaved'), $messages), MSG_ERROR, 'index.php?ToDo=viewReturnsSettings');
			}
		}

		private function ManageReturnsSettings($messages=array())
		{

			$GLOBALS['Message'] = GetFlashMessageBoxes();

			foreach ($this->all_vars as $var) {
				if (is_string(GetConfig($var)) || is_numeric(GetConfig($var))) {
					$GLOBALS[$var] = isc_html_escape(GetConfig($var));
				} elseif (is_array(GetConfig($var))) {
					$GLOBALS[$var.'Area'] = isc_html_escape(implode("\r\n", GetConfig($var)));
				}
			}

			// Are returns enabled?
			if (GetConfig('EnableReturns')) {
				$GLOBALS['IsEnableReturns'] = "checked=\"checked\"";
			}

			// Can store credits be issued?
			if (GetConfig('ReturnCredits')) {
				$GLOBALS['IsReturnCredits'] = "checked=\"checked\"";
			}

			if (GetConfig('EmailOwnerOnReturn')) {
				$GLOBALS['IsReturnNotifyOwner'] = "checked=\"checked\"";
			}

			if (GetConfig('SendReturnConfirmation')) {
				$GLOBALS['IsReturnNotifyCustomer'] = "checked=\"checked\"";
			}

			if (GetConfig('NotifyOnReturnStatusChange')) {
				$GLOBALS['IsReturnNotifyStatusChange'] = "checked=\"checked\"";
			}

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("settings.returns.manage");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}

        public function FormatWYSIWYGHTML($HTML)
        {

            if(GetConfig('UseWYSIWYG')) {
                return $HTML;
            }
            else {
                // We need to sanitise all the line feeds first to 'nl'
                $HTML = SanatiseStringToUnix($HTML);

                // Now we can use nl2br()
                $HTML = nl2br($HTML);

                // But we still need to strip out the new lines as nl2br doesn't really 'replace' the new lines, it just inserts <br />before it
                $HTML = str_replace("\n", "", $HTML);

                // Fix up new lines and block level elements.
                $HTML = preg_replace("#(</?(?:html|head|body|div|p|form|table|thead|tbody|tfoot|tr|td|th|ul|ol|li|div|p|blockquote|cite|hr)[^>]*>)\s*<br />#i", "$1", $HTML);
                $HTML = preg_replace("#(&nbsp;)+(</?(?:html|head|body|div|p|form|table|thead|tbody|tfoot|tr|td|th|ul|ol|li|div|p|blockquote|cite|hr)[^>]*>)#i", "$2", $HTML);
                return $HTML;
            }
        }
        
		private function SaveUpdatedSettings()
		{
			if($_SERVER['REQUEST_METHOD'] != 'POST') {
				$this->ManageSettings();
				return;
			}

            /* Baskaran */
                $WYSIWYG = $this->FormatWYSIWYGHTML($_POST['wysiwyg']);
                $WYSIWYG1 = $this->FormatWYSIWYGHTML($_POST['wysiwyg1']);
                $WYSIWYG2 = $this->FormatWYSIWYGHTML($_POST['wysiwyg2']);
                
                $editor1 = array("value"=>$WYSIWYG);
                $GLOBALS['ISC_CLASS_DB']->UpdateQuery("display", $editor1, "messageid = '1'");
                
                $editor2 = array("value"=>$WYSIWYG1);
                $GLOBALS['ISC_CLASS_DB']->UpdateQuery("display", $editor2, "messageid = '2'");

                $editor3 = array("value"=>$WYSIWYG2);
                $GLOBALS['ISC_CLASS_DB']->UpdateQuery("display", $editor3, "messageid = '3'");
            /* Ends here */
            
			$boolean = array (
				'UseWYSIWYG',
				'AllowPurchasing',
				'ShowInventory',
				'ShowThumbsInControlPanel',
				'TagCloudsEnabled',
				'ShowAddToCartQtyBox',
				'CaptchaEnabled',
				'ShowCartSuggestions',
				'ShowThumbsInCart',
				'AutoApproveReviews',
				'SearchSuggest',
				'QuickSearch',
				'UseSSL',
				'RSSNewProducts',
				'RSSPopularProducts',
				'RSSCategories',
				'RSSProductSearches',
				'RSSLatestBlogEntries',
				'RSSSyndicationIcons',
				'StoreDSTCorrection',
				'ShowInventory',
				'MailAutomaticallyTickNewsletterBox',
				'MailAutomaticallyTickOrderBox',
				'SystemLogging',
				'AdministratorLogging',
				'DebugMode',
				'EnableWishlist',
				'EnableAccountCreation',
				'EnableProductReviews',
				'EnableProductComparisons',
				'ShowProductPrice',
				'ShowProductSKU',
				'ShowProductWeight',
				'ShowProductBrand',
				'ShowProductShipping',
				'ShowProductRating',
                'ShowBestOffer',
                'ShowOnSale',  
				'HidePHPErrors',
				'HTTPSSLVerifyPeer',
				'ShowMailingListInvite',
				'ShowAddToCartLink',
				'BulkDiscountEnabled',
				'EnableProductTabs',
			);

			foreach ($boolean as $var) {
				if (isset($_POST[$var]) && ($_POST[$var] == 1 || $_POST[$var] === "ON")) {
					$GLOBALS['ISC_NEW_CFG'][$var] = 1;
				} else {
					$GLOBALS['ISC_NEW_CFG'][$var] = 0;
				}
			}

			$positive_ints = array (
				'AutoThumbSize',
				'HomeFeaturedProducts',
                'HomeFeaturedCategories',
				'HomeNewProducts',
				'HomeBlogPosts',
				'CategoryProductsPerPage',
				'CategoryListDepth',
				'ProductReviewsPerPage',
				'RSSItemsLimit',
				'RSSCacheTime',
				'EnableSEOUrls',
				'SystemLogMaxLength',
				'AdministratorLogMaxLength',
				'GuestCustomerGroup',
				'CategoryPerRow',
				'CategoryImageWidth',
				'CategoryImageHeight',
				'BrandPerRow',
				'BrandImageWidth',
				'BrandImageHeight',
				'TagCloudMinSize',
				'TagCloudMaxSize'
			);

			foreach ($positive_ints as $var) {
				if (isset($_POST[$var]) && (int) $_POST[$var] > 0) {
					$GLOBALS['ISC_NEW_CFG'][$var] = (int) $_POST[$var];
				} else {
					$GLOBALS['ISC_NEW_CFG'][$var] = 0;
				}
			}

			$strings = array (
				'ShopPath',
				'StoreName',
				'StoreAddress',
				'serverStamp',
				'CharacterSet',
				'DownloadDirectory',
				'ImageDirectory',
                'InstallImageDirectory',
                'VideoDirectory',
                'InstallVideoDirectory',
				'HomePagePageTitle',
				'MetaKeywords',
				'MetaDesc',
				'AdminEmail',
				'OrderEmail',
				'DisplayDateFormat',
				'ExportDateFormat',
				'ExtendedDisplayDateFormat',
				'GoogleMapsAPIKey',
				'ForwardInvoiceEmails',
				'HTTPProxyPort',
				'HTTPProxyServer',
				'DimensionsDecimalToken',
				'DimensionsThousandsToken',
				'DimensionsDecimalPlaces',
			);

			foreach ($strings as $var) {
				if (isset($_POST[$var]) && is_string($_POST[$var])) {
					$GLOBALS['ISC_NEW_CFG'][$var] = $_POST[$var];
				}
			}

			$enums = array (
				'WeightMeasurement' => array ('LBS', 'KGS', 'Ounces', 'Grams', 'Tonnes'),
				'LengthMeasurement' => array ('Inches', 'Centimeters'),
				'StoreTimeZone' => array_keys($this->timezones),
				'Language' => $this->GetAvailableLanguagesArray(),
				'TagCartQuantityBoxes' => array ('dropdown', 'textbox'),
				'AddToCartButtonPosition' => array ('middle', 'side'),
				'ProductImageMode' => array ('popup', 'lightbox'),
				'CategoryListingMode' => array('single', 'emptychildren', 'children'),
				'CategoryDisplayMode' => array('grid', 'list'),
				'ShippingFactoringDimension' => array('depth', 'height', 'width'),
			);

			foreach ($enums as $var => $possible_vals) {
				if (isset($_POST[$var]) && in_array($_POST[$var], $possible_vals)) {
					$GLOBALS['ISC_NEW_CFG'][$var] = $_POST[$var];
				} else {
					$GLOBALS['ISC_NEW_CFG'][$var] = $possible_vals[0];
				}
			}

			$uploads = array(
				'CategoryDefaultImage',
				'BrandDefaultImage',
			);

			if($_POST['DefaultProductImage'] == 'custom') {
				$uploads[] = 'DefaultProductImageCustom';
			}

			foreach ($uploads as $var) {
				$imageLocation = GetConfig($var);

				if (array_key_exists($var, $_FILES) && file_exists($_FILES[$var]['tmp_name'])) {
					$ext = GetFileExtension($_FILES[$var]['name']);
					$imageLocation = GetConfig('ImageDirectory').'/' . $var . '.' . $ext;
					move_uploaded_file($_FILES[$var]['tmp_name'], ISC_BASE_PATH . '/'.$imageLocation);

					// Attempt to change the permissions on the file
					isc_chmod(ISC_BASE_PATH . '/'.$imageLocation, ISC_WRITEABLE_FILE_PERM);
				}

				if (array_key_exists('Del' . $var, $_REQUEST) && $_REQUEST['Del' . $var]) {
					@unlink(ISC_BASE_PATH . GetConfig($var));
					$imageLocation = '';
				}

				$GLOBALS['ISC_NEW_CFG'][$var] = $imageLocation;
			}

			switch($_POST['DefaultProductImage']) {
				case 'custom':
					$GLOBALS['ISC_NEW_CFG']['DefaultProductImage'] = $GLOBALS['ISC_NEW_CFG']['DefaultProductImageCustom'];
					unset($GLOBALS['ISC_NEW_CFG']['DefaultProductImageCustom']);
					break;
				case 'template':
					$GLOBALS['ISC_NEW_CFG']['DefaultProductImage'] = 'template';
					break;
				default:
					$GLOBALS['ISC_NEW_CFG']['DefaultProductImage'] = '';
			}

			// Backup Settings
			if (gzte11(ISC_MEDIUMPRINT)) {
				$boolean = array (
					'BackupsLocal',
					'BackupsRemoteFTP',
					'BackupsAutomatic',
					'BackupsAutomaticDatabase',
					'BackupsAutomaticImages',
					'BackupsAutomaticDownloads',
				);

				foreach ($boolean as $var) {
					if (isset($_POST[$var]) && ($_POST[$var] == 1 || $_POST[$var] === "ON")) {
						$GLOBALS['ISC_NEW_CFG'][$var] = 1;
					} else {
						$GLOBALS['ISC_NEW_CFG'][$var] = 0;
					}
				}

				$strings = array (
					'BackupsRemoteFTPHost',
					'BackupsRemoteFTPUser',
					'BackupsRemoteFTPPass',
					'BackupsRemoteFTPPath',
				);

				foreach ($strings as $var) {
					if (isset($_POST[$var]) && is_string($_POST[$var])) {
						$GLOBALS['ISC_NEW_CFG'][$var] = $_POST[$var];
					}
				}

				$enums = array (
					'BackupsAutomaticMethod' => array ('ftp', 'local'),
				);

				foreach ($enums as $var => $possible_vals) {
					if (isset($_POST[$var]) && in_array($_POST[$var], $possible_vals)) {
						$GLOBALS['ISC_NEW_CFG'][$var] = $_POST[$var];
					} else {
						$GLOBALS['ISC_NEW_CFG'][$var] = $possible_vals[0];
					}
				}
			}

			// Newsletter Settings
			if (isset($_POST['SystemLogTypes'])) {
				$GLOBALS['ISC_NEW_CFG']['SystemLogTypes'] = implode(",", $_POST['SystemLogTypes']);
			} else {
				$GLOBALS['ISC_NEW_CFG']['SystemLogTypes'] = '';
			}

			if (isset($_POST['SystemLogSeverity'])) {
				$GLOBALS['ISC_NEW_CFG']['SystemLogSeverity'] = implode(",", $_POST['SystemLogSeverity']);
			} else {
				$GLOBALS['ISC_NEW_CFG']['SystemLogSeverity'] = '';
			}

			if(isset($_POST['LowInventoryEmails']) && $_POST['LowInventoryEmails'] == 1) {
				$GLOBALS['ISC_NEW_CFG']['LowInventoryNotificationAddress'] = $_POST['LowInventoryNotificationAddress'];
			}
			else {
				$GLOBALS['ISC_NEW_CFG']['LowInventoryNotificationAddress'] = '';
			}

			if(isset($_POST['ForwardInvoiceEmailsCheck']) && $_POST['ForwardInvoiceEmailsCheck'] == 1) {
				$GLOBALS['ISC_NEW_CFG']['ForwardInvoiceEmails'] = $_POST['ForwardInvoiceEmails'];
			}
			else {
				$GLOBALS['ISC_NEW_CFG']['ForwardInvoiceEmails'] = '';
			}

			// Email Server Settings
			$GLOBALS['ISC_NEW_CFG']['MailUseSMTP'] = 0;
			$GLOBALS['ISC_NEW_CFG']['MailSMTPServer'] = '';
			$GLOBALS['ISC_NEW_CFG']['MailSMTPUsername'] = '';
			$GLOBALS['ISC_NEW_CFG']['MailSMTPPassword'] = '';
			$GLOBALS['ISC_NEW_CFG']['MailSMTPPort'] = '';

			if(isset($_POST['MailUseSMTP']) && $_POST['MailUseSMTP'] == 1) {
				$GLOBALS['ISC_NEW_CFG']['MailUseSMTP'] = 1;

				$GLOBALS['ISC_NEW_CFG']['MailSMTPServer'] = $_POST['MailSMTPServer'];
				if(isset($_POST['MailSMTPUsername'])) {
					$GLOBALS['ISC_NEW_CFG']['MailSMTPUsername'] = $_POST['MailSMTPUsername'];
				}
				if(isset($_POST['MailSMTPPassword'])) {
					$GLOBALS['ISC_NEW_CFG']['MailSMTPPassword'] = $_POST['MailSMTPPassword'];
				}
				if(isset($_POST['MailSMTPPort'])) {
					$GLOBALS['ISC_NEW_CFG']['MailSMTPPort'] = $_POST['MailSMTPPort'];
				}
			}

			if(isset($_POST['VendorPhotoUploading'])) {
				$GLOBALS['ISC_NEW_CFG']['VendorPhotoSize'] = (int)$_POST['VendorPhotoSizeW'].'x'.(int)$_POST['VendorPhotoSizeH'];
			}
			else {
				$GLOBALS['ISC_NEW_CFG']['VendorPhotoSize'] = '';
			}

			if(isset($_POST['VendorLogoUploading'])) {
				$GLOBALS['ISC_NEW_CFG']['VendorLogoSize'] = (int)$_POST['VendorLogoSizeW'].'x'.(int)$_POST['VendorLogoSizeH'];
			}
			else {
				$GLOBALS['ISC_NEW_CFG']['VendorLogoSize'] = '';
			}

			// Remove any settings that have been disabled so they can't be adjusted by the end user
			$disabledFields = array(
				'DisableLicenseKeyField' => array(
					'serverStamp'
				),
				'DisableStoreUrlField' => array(
					'ShopPath'
				),
				'DisablePathFields' => array(
					'DownloadDirectory',
					'ImageDirectory'
				),
				'DisableLoggingSettingsTab' => array(
					'SystemLogging',
					'HidePHPErrors',
					'SystemLogTypes',
					'SystemLogSeverity',
					'SystemLogMaxLength',
					'AdministratorLogging',
					'AdministratorLogMaxLength'
				),
				'DisableProxyFields' => array(
					'HTTPProxyServer',
					'HTTPProxyPort',
					'HTTPSSLVerifyPeer'
				),
				'DisableBackupSettings' => array(
					'BackupsLocal',
					'BackupsRemoteFTP',
					'BackupsRemoteFTPHost',
					'BackupsRemoteFTPUser',
					'BackupsRemoteFTPPass',
					'BackupsRemoteFTPPath',
					'BackupsAutomatic',
					'BackupsAutomaticMethod',
					'BackupsAutomaticDatabase',
					'BackupsAutomaticImages',
					'BackupsAutomaticDownloads'
				)
			);
			foreach($disabledFields as $setting => $fields) {
				if(GetConfig($setting) == true) {
					foreach($fields as $field) {
						unset($GLOBALS['ISC_NEW_CFG'][$field]);
					}
				}
			 }

			$messages = array();

			if ($this->CommitSettings($messages)) {
				// Log this action
				$GLOBALS['ISC_CLASS_LOG']->LogAdminAction();
				FlashMessage(GetLang('SettingsSavedSuccessfully'), MSG_SUCCESS, 'index.php?ToDo=viewSettings&currentTab='.((int) $_POST['currentTab']));
			} else {
				FlashMessage(sprintf(GetLang('SettingsNotSaved'), $messages), MSG_ERROR, 'index.php?ToDo=viewSettings&currentTab='.((int) $_POST['currentTab']));
			}
		}

		public function CommitSettings(&$messages=array())
		{
			// If the shop path has changed normalize it and set the app path too
			if (isset($GLOBALS['ISC_NEW_CFG']['ShopPath'])) {
				$shop_path_parts = parse_url($GLOBALS['ISC_NEW_CFG']['ShopPath']);

				if(!isset($shop_path_parts['scheme'])) {
					$shop_path_parts['scheme'] = 'http';
				}

				if (!isset($shop_path_parts['path'])) {
					$shop_path_parts['path'] = '';
				}
				$shop_path_parts['path'] = rtrim($shop_path_parts['path'], '/');

				// Workout the Shop Path
				$GLOBALS['ISC_NEW_CFG']['ShopPath'] = $shop_path_parts['scheme'].'://'.$shop_path_parts['host'];
				if (isset($shop_path_parts['port']) && $shop_path_parts['port'] != '80') {
					$GLOBALS['ISC_NEW_CFG']['ShopPath'] .= ':'.$shop_path_parts['port'];
				}
				$GLOBALS['ISC_NEW_CFG']['ShopPath'] .= $shop_path_parts['path'];

				// Work out the AppPath automatically
				$GLOBALS['ISC_NEW_CFG']['AppPath'] = $shop_path_parts['path'];
			}

			if (!isset($GLOBALS['ISC_NEW_CFG'])) {
				$GLOBALS['ISC_NEW_CFG'] = array();
			}

			$directories = array(
				'ImageDirectory' => 'product_images',
                'InstallImageDirectory' => 'install_images',
                'VideoDirectory' => 'product_videos',
                'InstallVideoDirectory' => 'install_videos',
				'DownloadDirectory' => 'product_downloads'
			);		//New directories of index 1,2,3 added by Simha
			foreach($directories as $directory => $default) {
				if(isset($GLOBALS['ISC_NEW_CFG'][$directory])) {
					$newDirectory = ISC_BASE_PATH.'/'.$GLOBALS['ISC_NEW_CFG'][$directory];
					if(!$GLOBALS['ISC_NEW_CFG'][$directory] || !is_dir($newDirectory)) {
						$GLOBALS['ISC_NEW_CFG'][$directory] = $default;
					}
				}
			}

			if(!isset($GLOBALS['ISC_NEW_CFG']['ShopPath'])) {
				$GLOBALS['ISC_CFG']['ShopPath'] = GetConfig('ShopPathNormal');
			}

			$GLOBALS['ISC_SAVE_CFG'] = array_merge($GLOBALS['ISC_CFG'], $GLOBALS['ISC_NEW_CFG']);

			// Save the var_exported vars in the globals array temporarily for saving
			foreach ($this->all_vars as $var) {
				if (!array_key_exists($var, $GLOBALS['ISC_SAVE_CFG'])) {
					$GLOBALS[$var] = "null";
				} else {
					$GLOBALS[$var] = var_export($GLOBALS['ISC_SAVE_CFG'][$var], true);
				}
			}

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("config.file");
			$config_data = $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);

			$setting_string = "<" . "?php\n\n";
			$setting_string .= "\t// Last Updated: ".isc_date("jS M Y @ g:i A") . "\n";
			$setting_string .= $config_data;
			$setting_string .= "?" . ">";

			if (!defined("ISC_CONFIG_FILE") || !defined("ISC_CONFIG_BACKUP_FILE")) {
				die("Config sanity check failed");
			}

			// Try to copy the current config file to a backup file
			if (!@copy(ISC_CONFIG_FILE, ISC_CONFIG_BACKUP_FILE)) {
				isc_chmod(ISC_CONFIG_BACKUP_FILE, ISC_WRITEABLE_FILE_PERM);
				$messages = array(GetLang('CouldntBackupConfig') => MSG_INFO);
			}

			// Try to write to the config file
			if (is_writable(ISC_CONFIG_FILE)) {
				if ($fp = @fopen(ISC_CONFIG_FILE, "wb+")) {
					if (@fwrite($fp, $setting_string)) {
						$prevCatListDepth = GetConfig('CategoryListDepth');
						// Include the config file again to initialize the new values
						include(ISC_CONFIG_FILE);

						if (isset($GLOBALS['ISC_NEW_CFG']['CategoryListDepth']) && $GLOBALS['ISC_NEW_CFG']['CategoryListDepth'] != $prevCatListDepth) {
							$GLOBALS['ISC_CLASS_DATA_STORE']->UpdateRootCategories();
						}

						return true;
					}
					else {
						$this->error = GetLang('CouldntSaveConfig');
						return false;
					}
				}
				else {
					$this->error = GetLang('CouldntSaveConfig');
					return false;
				}
			}
			else {
				$this->error = GetLang('CouldntSaveConfig');
				return false;
			}
		}

		private function ManageSettings($messages=array())
		{

			if(!gzte11(ISC_HUGEPRINT)) {
				$GLOBALS['HideVendorOptions'] = 'display: none';
			}

			$GLOBALS['Message'] = GetFlashMessageBoxes();

			if (GetConfig('UseWYSIWYG')) {
				$GLOBALS['IsWYSIWYGEnabled'] = 'checked="checked"';
			}

			if (GetConfig('ShowThumbsInControlPanel')) {
				$GLOBALS['IsProductThumbnailsEnabled'] = 'checked="checked"';
			}

			if (GetConfig('DesignMode')) {
				$GLOBALS['IsDesignMode'] = 'checked="checked"';
			}

			if (GetConfig('UseSSL')) {
				$GLOBALS['IsSSLEnabled'] = 'checked="checked"';
			}

			if(GetConfig('AllowPurchasing')) {
				$GLOBALS['IsPurchasingEnabled'] = 'checked="checked"';
			}

			switch(GetConfig('WeightMeasurement')) {
				case 'LBS':
					$GLOBALS['IsPounds'] = 'selected="selected"';
					break;
				case 'Ounces':
					$GLOBALS['IsOunces'] = 'selected="selected"';
					break;
				case 'KGS':
					$GLOBALS['IsKilos'] = 'selected="selected"';
					break;
				case 'Grams':
					$GLOBALS['IsGrams'] = 'selected="selected"';
					break;
				case 'Tonnes':
					$GLOBLAS['IsTonnes'] = 'selected="selected"';
			}

			if (GetConfig('LengthMeasurement') == "Inches") {
				$GLOBALS['IsInches'] = 'selected="selected"';
			} else {
				$GLOBALS['IsCentimeters'] = 'selected="selected"';
			}

			$GLOBALS['ShippingFactoringDimensionDepthSelected'] = '';
			$GLOBALS['ShippingFactoringDimensionHeightSelected'] = '';
			$GLOBALS['ShippingFactoringDimensionWidthSelected'] = '';

			switch (GetConfig('ShippingFactoringDimension')) {
				case 'height':
					$GLOBALS['ShippingFactoringDimensionHeightSelected'] = 'selected="selected"';
					break;
				case 'width':
					$GLOBALS['ShippingFactoringDimensionWidthSelected'] = 'selected="selected"';
					break;
				case 'depth':
				default:
					$GLOBALS['ShippingFactoringDimensionDepthSelected'] = 'selected="selected"';
					break;
			}

			if (GetConfig('TagCartQuantityBoxes') == "dropdown") {
				$GLOBALS['IsDropdown'] = 'selected="selected"';
			} else {
				$GLOBALS['IsTextbox'] = 'selected="selected"';
			}

			if (GetConfig('AddToCartButtonPosition') == "middle") {
				$GLOBALS['IsMiddle'] = 'selected="selected"';
			} else {
				$GLOBALS['IsSide'] = 'selected="selected"';
			}

			if (GetConfig('TagCloudsEnabled')) {
				$GLOBALS['IsTagCloudsEnabled'] = 'checked="checked"';
			}

			if (GetConfig('BulkDiscountEnabled')) {
				$GLOBALS['IsBulkDiscountEnabled'] = 'checked="checked"';
			}

			if (GetConfig('EnableProductTabs')) {
				$GLOBALS['IsProductTabsEnabled'] = 'checked="checked"';
			}

			if (GetConfig('ShowAddToCartQtyBox')) {
				$GLOBALS['IsShownAddToCartQtyBox'] = 'checked="checked"';
			}

			if (GetConfig('CaptchaEnabled')) {
				$GLOBALS['IsCaptchaEnabled'] = 'checked="checked"';
			}

			if(GetConfig('StoreDSTCorrection')) {
				$GLOBALS['IsDSTCorrectionEnabled'] = "checked=\"checked\"";
			}

			if (GetConfig('ShowCartSuggestions')) {
				$GLOBALS['IsShowCartSuggestions'] = 'checked="checked"';
			}

			if (GetConfig('ShowThumbsInCart')) {
				$GLOBALS['IsShowThumbsInCart'] = 'checked="checked"';
			}

			if (GetConfig('TagCloudsEnabled')) {
				$GLOBALS['IsTagCloudsEnabled'] = 'checked="checked"';
			}

			if (GetConfig('ShowAddToCartQtyBox')) {
				$GLOBALS['IsShownAddToCartQtyBox'] = 'checked="checked"';
			}

			if (GetConfig('AutoApproveReviews')) {
				$GLOBALS['IsAutoApproveReviews'] = 'checked="checked"';
			}

			if (GetConfig('SearchSuggest')) {
				$GLOBALS['IsSearchSuggest'] = 'checked="checked"';
			}

			if (GetConfig('QuickSearch')) {
				$GLOBALS['IsQuickSearch'] = 'checked="checked"';
			}

			if (GetConfig('ShowInventory')) {
				$GLOBALS['IsShowInventory'] = 'checked="checked"';
			}
            /* Baskaran */
            $displayresult = $GLOBALS["ISC_CLASS_DB"]->Query("SELECT * FROM [|PREFIX|]display");
            $value = array();
            while($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($displayresult)){
                $value[] = $row['value'];
            }
            $wysiwygOptions = array(
                    'id'        => 'wysiwyg',
                    'width'        => '60%',
                    'height'    => '350px',
                    'value'        => $value[0]
                ); 
            $wysiwygOptions1 = array(
                    'id'        => 'wysiwyg1',
                    'width'        => '60%',
                    'height'    => '350px',
                    'value'        => $value[1]
                );                                                                                                
            $wysiwygOptions2 = array(
                    'id'        => 'wysiwyg2',
                    'width'        => '60%',
                    'height'    => '350px',
                    'value'        => $value[2]
                );                                                                                                
            $GLOBALS['WYSIWYG'] =  GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor($wysiwygOptions);
            $GLOBALS['WYSIWYG1'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor1($wysiwygOptions1);
            $GLOBALS['WYSIWYG2'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor1($wysiwygOptions2);
            /* Ends here */
			// Bulk Discount Settings
			if (GetConfig('BulkDiscountEnabled')) {
				$GLOBALS['IsBulkDiscountEnabled'] = 'checked="checked"';
			}

			if (GetConfig('EnableProductTabs')) {
				$GLOBALS['IsProductTabsEnabled'] = 'checked="checked"';
			}

			// RSS Settings
			if (GetConfig('RSSNewProducts')) {
				$GLOBALS['IsRSSNewProductsEnabled'] = 'checked="checked"';
			}

			if (GetConfig('RSSPopularProducts')) {
				$GLOBALS['IsRSSPopularProductsEnabled'] = 'checked="checked"';
			}

			if (GetConfig('RSSCategories')) {
				$GLOBALS['IsRSSCategoriesEnabled'] = 'checked="checked"';
			}

			if (GetConfig('RSSProductSearches')) {
				$GLOBALS['IsRSSProductSearchesEnabled'] = 'checked="checked"';
			}

			if (GetConfig('RSSLatestBlogEntries')) {
				$GLOBALS['IsRSSLatestBlogEntriesEnabled'] = 'checked="checked"';
			}

			if (GetConfig('RSSSyndicationIcons')) {
				$GLOBALS['IsRSSSyndicationIconsEnabled'] = 'checked="checked"';
			}

			// Backup Settings
			if (GetConfig('BackupsLocal')) {
				$GLOBALS['IsBackupsLocalEnabled'] = 'checked="checked"';
			}

			if (GetConfig('BackupsRemoteFTP')) {
				$GLOBALS['IsBackupsRemoteFTPEnabled'] = 'checked="checked"';
			}

			if (GetConfig('BackupsAutomatic')) {
				$GLOBALS['IsBackupsAutomaticEnabled'] = 'checked="checked"';
			}

			if (GetConfig('HTTPSSLVerifyPeer')) {
				$GLOBALS['IsHTTPSSLVerifyPeerEnabled'] = 'checked="checked"';
			}

			if(GetConfig('ShowMailingListInvite')) {
				$GLOBALS['IsShowMailingListInvite'] = 'checked="checked"';
			}

			if (strpos(strtolower(PHP_OS), 'win') === 0) {
				$binary = 'php.exe';
				$path_to_php = Which($binary);
			} else {
				// Check if there is a separate PHP 5 binary first
				foreach(array('php5', 'php') as $phpBin) {
					$path_to_php = Which($phpBin);
					if($path_to_php !== '') {
						break;
					}
				}
			}

			if ($path_to_php === '' && strpos(strtolower(PHP_OS), 'win') === 0) {
				$path_to_php = 'php.exe';
			} elseif ($path_to_php === '') {
				$path_to_php = 'php';
			}

			$GLOBALS['BackupsAutomaticPath'] = $path_to_php.' -f ' . realpath(ISC_BASE_PATH . "/admin")."/cron-backup.php";

			if (GetConfig('BackupsAutomaticMethod') == "ftp") {
				$GLOBALS['IsBackupsAutomaticMethodFTP'] = 'selected="selected"';
			} else {
				$GLOBALS['IsBackupsAutomaticMethodLocal'] = 'selected="selected"';
			}

			if (GetConfig('BackupsAutomaticDatabase')) {
				$GLOBALS['IsBackupsAutomaticDatabaseEnabled'] = 'checked="checked"';
			}

			if (GetConfig('BackupsAutomaticImages')) {
				$GLOBALS['IsBackupsAutomaticImagesEnabled'] = 'checked="checked"';
			}

			if (GetConfig('BackupsAutomaticDownloads')) {
				$GLOBALS['IsBackupsAutomaticDownloadsEnabled'] = 'checked="checked"';
			}

			$GLOBALS['LanguageOptions'] = $this->GetLanguageOptions(GetConfig('Language'));

			if (!function_exists('ftp_connect')) {
				$GLOBALS['FTPBackupsHide'] = "none";
			}

			$GLOBALS['TimeZoneOptions'] = $this->GetTimeZoneOptions(GetConfig('StoreTimeZone'));

			$query = sprintf("select version() as version");
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
			$GLOBALS['dbVersion'] = $row['version'];

			// Hide the special offers tickbox if Interspire Email Marketer isn't integrated
			if (!(GetConfig('MailXMLAPIValid') && GetConfig('UseMailerForOrders') && GetConfig('MailOrderList') > 0)) {
				$GLOBALS['HideSpecialOffersBox'] = "none";
			}

			if (GetConfig('MailAutomaticallyTickNewsletterBox')) {
				$GLOBALS['IsNewsletterBoxTicked'] = 'checked="checked"';
			}

			if (GetConfig('MailAutomaticallyTickOrderBox')) {
				$GLOBALS['IsOrderBoxTicked'] = 'checked="checked"';
			}

			// Logging Settings
			if (GetConfig('SystemLogging')) {
				$GLOBALS['IsSystemLoggingEnabled'] = "checked=\"checked\"";
			}

			if(GetConfig('DebugMode')) {
				$GLOBALS['IsDebugModeEnabled'] = "checked=\"checked\"";
			}

			if (GetConfig('SystemLogTypes')) {
				$types = explode(",", GetConfig('SystemLogTypes'));
				if (in_array('general', $types)) {
					$GLOBALS['IsGeneralLoggingEnabled'] = "selected=\"selected\"";
				}
				if (in_array('payment', $types)) {
					$GLOBALS['IsPaymentLoggingEnabled'] = "selected=\"selected\"";
				}
				if (in_array('shipping', $types)) {
					$GLOBALS['IsShippingLoggingEnabled'] = "selected=\"selected\"";
				}
				if (in_array('notification', $types)) {
					$GLOBALS['IsNotificationLoggingEnabled'] = "selected=\"selected\"";
				}
				if (in_array('ssnx', $types)) {
					$GLOBALS['IsSendStudioLoggingEnabled'] = "selected=\"selected\"";
				}
				if (in_array('sql', $types)) {
					$GLOBALS['IsSQLLoggingEnabled'] = "selected=\"selected\"";
				}
				if (in_array('php', $types)) {
					$GLOBALS['IsPHPLoggingEnabled'] = "selected=\"selected\"";
				}
			}

			if (GetConfig('SystemLogSeverity')) {
				$severities = explode(",", GetConfig('SystemLogSeverity'));
				if (in_array('errors', $severities)) {
					$GLOBALS['IsLoggingSeverityErrors'] = "selected=\"selected\"";
				}
				if (in_array('warnings', $severities)) {
					$GLOBALS['IsLoggingSeverityWarnings'] = "selected=\"selected\"";
				}
				if (in_array('notices', $severities)) {
					$GLOBALS['IsLoggingSeverityNotices'] = "selected=\"selected\"";
				}
				if (in_array('success', $severities)) {
					$GLOBALS['IsLoggingSeveritySuccesses'] = "selected=\"selected\"";
				}
				if (in_array('debug', $severities)) {
					$GLOBALS['IsLoggingSeverityDebug'] = "selected=\"selected\"";
				}
			}


			if (GetConfig('EnableSEOUrls') == 2) {
				$GLOBALS['IsEnableSEOUrlsAuto'] = "selected=\"selected\"";
			}
			else if (GetConfig('EnableSEOUrls') == 1) {
				$GLOBALS['IsEnableSEOUrlsEnabled'] = "selected=\"selected\"";
			}
			else {
				$GLOBALS['IsEnableSEOUrlsDisabled'] = "selected=\"selected\"";
			}

			if (!gzte11(ISC_MEDIUMPRINT)) {
				$GLOBALS['HideBackupSettings'] = "none";
			}

			if (GetConfig('AdministratorLogging')) {
				$GLOBALS['IsAdministratorLoggingEnabled'] = "checked=\"checked\"";
			}

			if(GetConfig('HidePHPErrors')) {
				$GLOBALS['IsHidePHPErrorsEnabled'] = "checked=\"checked\"";
			}

			if(GetConfig('EnableWishlist')) {
				$GLOBALS['IsWishlistEnabled'] = "checked=\"checked\"";
			}

			if(GetConfig('EnableAccountCreation')) {
				$GLOBALS['IsEnableAccountCreation'] = "checked=\"checked\"";
			}

			if(GetConfig('EnableProductReviews')) {
				$GLOBALS['IsEnableProductReviews'] = "checked=\"checked\"";
			}

			if(GetConfig('EnableProductComparisons')) {
				$GLOBALS['IsEnableProductComparisons'] = "checked=\"checked\"";
			}

			// Product display settings
			if(GetConfig('ShowProductPrice')) {
				$GLOBALS['IsProductPriceShown'] = 'CHECKED';
			}

			if(GetConfig('ShowProductSKU')) {
				$GLOBALS['IsProductSKUShown'] = 'CHECKED';
			}

			if(GetConfig('ShowProductWeight')) {
				$GLOBALS['IsProductWeightShown'] = 'CHECKED';
			}

			if(GetConfig('ShowProductBrand')) {
				$GLOBALS['IsProductBrandShown'] = 'CHECKED';
			}

			if(GetConfig('ShowProductShipping')) {
				$GLOBALS['IsProductShippingShown'] = 'CHECKED';
			}

			if(GetConfig('ShowProductRating')) {
				$GLOBALS['IsProductRatingShown'] = 'CHECKED';
			}

            if(GetConfig('ShowBestOffer')) {
                $GLOBALS['IsBestOfferShown'] = 'CHECKED';
            }

            if(GetConfig('ShowOnSale')) {
                $GLOBALS['IsOnSaleShown'] = 'CHECKED';
            }

			if(GetConfig('ShowAddToCartLink')) {
				$GLOBALS['IsAddToCartLinkShown'] = 'CHECKED';
			}

			if(GetConfig('LowInventoryNotificationAddress') != '') {
				$GLOBALS['LowInventoryEmailsEnabledCheck'] = "checked=\"checked\"";
			}
			else {
				$GLOBALS['HideLowInventoryNotification'] = "none";
			}

			if(GetConfig('ForwardInvoiceEmails') != '') {
				$GLOBALS['ForwardInvoiceEmailsCheck'] = "checked=\"checked\"";
			}
			else {
				$GLOBALS['HideForwardInvoiceEmails'] = 'none';
			}

			if(GetConfig('MailUseSMTP')) {
				$GLOBALS['HideMailSMTPSettings'] = '';
				$GLOBALS['MailUseSMTPChecked'] = "checked=\"checked\"";
			}
			else {
				$GLOBALS['HideMailSMTPSettings'] = 'none';
				$GLOBALS['MailUsePHPChecked'] = "checked=\"checked\"";
			}

			if (GetConfig('ProductImageMode') == "lightbox") {
				$GLOBALS['ProductImageModeLightbox'] = 'selected="selected"';
			} else {
				$GLOBALS['ProductImageModePopup'] = 'selected="selected"';
			}

			if (GetConfig('CategoryDisplayMode') == "grid") {
				$GLOBALS['CategoryDisplayModeGrid'] = 'selected="selected"';
			}
			else {
				$GLOBALS['CategoryDisplayModeList'] = 'selected="selected"';
			}

			if (GetConfig('CategoryDefaultImage') !== '') {
				$GLOBALS['CatImageDefaultSettingMessage'] = sprintf(GetLang('CatImageDefaultSettingDesc'), GetConfig('ShopPath') . '/' . GetConfig('CategoryDefaultImage'), GetConfig('CategoryDefaultImage'));
			} else {
				$GLOBALS['CatImageDefaultSettingMessage'] = sprintf(GetLang('BrandImageDefaultSettingNoDeleteDesc'), GetConfig('ShopPath') . '/templates/' . GetConfig('template') . '/images/CategoryDefault.gif', 'templates/' . GetConfig('template') . '/images/CategoryDefault.gif');
			}

			if (GetConfig('BrandDefaultImage') !== '') {
				$GLOBALS['BrandImageDefaultSettingMessage'] = sprintf(GetLang('BrandImageDefaultSettingDesc'), GetConfig('ShopPath') . '/' . GetConfig('BrandDefaultImage'), GetConfig('BrandDefaultImage'));
			} else {
				$GLOBALS['BrandImageDefaultSettingMessage'] = sprintf(GetLang('BrandImageDefaultSettingNoDeleteDesc'), GetConfig('ShopPath') . '/templates/' . GetConfig('template') . '/images/BrandDefault.gif', 'templates/' . GetConfig('template') . '/images/BrandDefault.gif');
			}

			$GLOBALS['HideCurrentDefaultProductImage'] = 'display: none';
			switch(GetConfig('DefaultProductImage')) {
				case 'template':
					$GLOBALS['DefaultProductImageTemplateChecked'] = 'checked="checked"';
					break;
				case '':
					$GLOBALS['DefaultProductImageNoneChecked'] = 'checked="checked"';
					break;
				default:
					$GLOBALS['DefaultProductImageCustomChecked'] = 'checked="checked"';
					$GLOBALS['HideCurrentDefaultProductImage'] = '';
					$GLOBALS['DefaultProductImage'] = GetConfig('DefaultProductImage');
			}

			if (GetConfig('CategoryListingMode') == 'children') {
				$GLOBALS['CategoryListModeChildren'] = "checked=\"checked\"";
			}
			else if (GetConfig('CategoryListingMode') == 'emptychildren') {
				$GLOBALS['CategoryListModeEmptyChildren'] = "checked=\"checked\"";
			}
			else {
				$GLOBALS['CategoryListModeSingle'] = "checked=\"checked\"";
			}

			// Get a list of the customer groups
			$query = 'SELECT * FROM [|PREFIX|]customer_groups ORDER BY groupname ASC';
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$GLOBALS['CustomerGroupOptions'] = '';
			while($group = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				if(GetConfig('GuestCustomerGroup') == $group['customergroupid']) {
					$sel = 'selected="selected"';
				}
				else {
					$sel = '';
				}
				$GLOBALS['CustomerGroupOptions'] .= "<option value=\"".$group['customergroupid']."\" ".$sel.">".isc_html_escape($group['groupname'])."</option>";
			}

			// Workout the HTTPS URL
			$GLOBALS['CompleteStorePath'] = fix_url($_SERVER['PHP_SELF']);
			$GLOBALS['HTTPSUrl'] = str_replace("http://", "https://", isc_strtolower($GLOBALS['ShopPath']));

			$GLOBALS['HideVendorSettings'] = 'display: none';
			if(gzte11(ISC_HUGEPRINT)) {
				$GLOBALS['HideVendorSettings'] = '';
			}

			if(GetConfig('VendorLogoSize')) {
				$logoDimensions = explode('x', GetConfig('VendorLogoSize'));
				$GLOBALS['VendorLogoSizeW'] = (int)$logoDimensions[0];
				$GLOBALS['VendorLogoSizeH'] = (int)$logoDimensions[1];
				$GLOBALS['HideVendorLogoUploading'] = '';
				$GLOBALS['VendorLogoUploadingChecked'] = 'checked="checked"';
			}
			else {
				$GLOBALS['HideVendorLogoUploading'] = 'display: none';
			}

			if(GetConfig('VendorPhotoSize')) {
				$photoDimensions = explode('x', GetConfig('VendorPhotoSize'));
				$GLOBALS['VendorPhotoSizeW'] = (int)$photoDimensions[0];
				$GLOBALS['VendorPhotoSizeH'] = (int)$photoDimensions[1];
				$GLOBALS['HideVendorPhotoUploading'] = '';
				$GLOBALS['VendorPhotoUploadingChecked'] = 'checked="checked"';
			}
			else {
				$GLOBALS['HideVendorPhotoUploading'] = 'display: none';
			}

			foreach ($this->all_vars as $var) {
				if (is_string(GetConfig($var)) || is_numeric(GetConfig($var))) {
					$GLOBALS[$var] = isc_html_escape(GetConfig($var));
				}
			}

			if(GetConfig('DisableDatabaseDetailFields')) {
				$GLOBALS['dbType'] = '';
				$GLOBALS['dbServer'] = '';
				$GLOBALS['dbUser'] = '';
				$GLOBALS['dbPass'] = '';
				$GLOBALS['dbDatabase'] = '';
				$GLOBALS['tablePrefix'] = '';
				$GLOBALS['HideDatabaseDetails'] = 'display: none';
			}

			if(GetConfig('DisableLicenseKeyField')) {
				$GLOBALS['serverStamp'] = 'N/A';
				$GLOBALS['HideLicenseKey'] = 'display: none';
			}

			if(GetConfig('DisablePathFields')) {
				$GLOBALS['HidePathFields'] = 'display: none';
			}

			if(GetConfig('DisableStoreUrlField')) {
				$GLOBALS['HideStoreUrlField'] = 'display: none';
			}

			if(GetConfig('DisableLoggingSettingsTab')) {
				$GLOBALS['HideLoggingSettingsTab'] = 'display: none';
			}

			if(GetConfig('DisableProxyFields')) {
				$GLOBALS['HideProxyFields'] = 'display: none';
			}

			if(GetConfig('DisableBackupSettings')) {
				$GLOBALS['HideBackupSettings'] = 'none';
			}

			$GLOBALS['ShopPath'] = GetConfig('ShopPathNormal');

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("settings.manage");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();

		}

		private function ManageCurrencySettings($messages=array())
		{
			$GLOBALS['Message'] = GetFlashMessageBoxes();

			// Select the first available currency module to be used for auto updating the exchange rate
			if (count($currModules = explode(",", GetConfig("CurrencyMethods")))) {
				$GLOBALS['SelectedCurrencyModuleId'] = $currModules[0];
				$GLOBALS['UpdateExchageRateButton'] = '<input type="button" name="IndexUpdateButton" value="'. GetLang('CurrencyUpdateSelectedExchangeRate') . '" id="IndexUpdateButton" class="SmallButton" style="width:200px;" onclick="ConfirmUpdateSelectedExchangeRate()" />';
			}
			else {
				$GLOBALS['SelectedCurrencyModuleId'] = "0";
				$GLOBALS['UpdateExchageRateButton'] = "";
			}

			// Our default options
			$GLOBALS['DefaultTab'] = 0;
			$GLOBALS['CurrencyTabs'] = '<li><a href="#" id="tab0" onclick="ShowTab(0)">' . GetLang('CurrencyOptions') . '</a></li>';

			// Get our selected currency converts list
			$GLOBALS['ConverterProviders'] = $this->_getCurrencyConvertersAsOptions();

			// What's the path for the exchange rate update cron?
			if (strpos(strtolower(PHP_OS), 'win') === 0) {
				$binary = 'php.exe';
			} else {
				$binary = 'php';
			}

			$path_to_php = Which($binary);
			if ($path_to_php === '' && strpos(strtolower(PHP_OS), 'win') === 0) {
				$path_to_php = 'php.exe';
			} elseif ($path_to_php === '') {
				$path_to_php = 'php';
			}
			$GLOBALS['ExchangeRatePath'] = $path_to_php.' -f ' . realpath(ISC_BASE_PATH.'/admin/') . "/cron-updateexchangerates.php";

			// Get our list of currencies
			$GLOBALS['CurrencyGrid'] = "";
			$GLOBALS['CurrencyIntro'] = GetLang('CurrencyIntro');

			// Apply any special messages that need modifying
			$GLOBALS['CurrencySetAsDefaultMessage'] = sprintf(GetLang('CurrencySetAsDefaultMessage'), GetLang('CurrencySetAsDefaultOptYes'), GetLang('CurrencySetAsDefaultOptYesPrice'));

			// Apply our Popup variables
			$GLOBALS['PopupID'] = "CurrencyPopup";
			$GLOBALS['PopupDisplay'] = "none";
			$GLOBALS['PopupTools'] = "";
			$GLOBALS['PopupImgDisplay'] = "none";
			$GLOBALS['PopupImgSrc'] = "images/1x1.gif";  //IMPORTANT!!! Set any source!
			$GLOBALS['PopupHeader'] = GetLang('CurrencySetAsDefaultTitle');

			$GLOBALS['PopupContent'] = sprintf(GetLang('CurrencySetAsDefaultMessage'), GetLang('CurrencySetAsDefaultOptYes'), GetLang('CurrencySetAsDefaultOptYesPrice')) . '</p><p>';
			$GLOBALS['PopupContent'] .= '<input type="button" value="' . isc_html_escape(GetLang('CurrencySetAsDefaultOptYes')) . '" id="CurrencyPopupButtonYes" class="Field150" />';
			$GLOBALS['PopupContent'] .= '<input type="button" value="' . isc_html_escape(GetLang('CurrencySetAsDefaultOptYesPrice')) . '" id="CurrencyPopupButtonYesPrice" class="Field150" />';
			$GLOBALS['PopupContent'] .= '<input type="button" value="' . isc_html_escape(GetLang('CurrencySetAsDefaultOptNo')) . '" id="CurrencyPopupButtonNo" class="Field150" />';

			// Get our currency list
			$currencyResult = $this->_getCurrencyList();

			if ($GLOBALS['ISC_CLASS_DB']->CountResult($currencyResult) > 0) {
				while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($currencyResult)) {

					$GLOBALS['CurrencyId'] = (int)$row['currencyid'];
					$GLOBALS['CurrencyName'] = isc_html_escape($row['currencyname']);
					$GLOBALS['CurrencyCode'] = isc_html_escape($row['currencycode']);
					$GLOBALS['CurrencyRate'] = FormatPrice($row['currencyexchangerate'], false, true, false, $row, false);

					if ($row['currencyisdefault']) {
						$GLOBALS['ClassName'] = "GridRowSel";
						$GLOBALS['DeleteStatus'] = " disabled='disabled'";
						$GLOBALS['CurrencyName'] .= " <span style='margin-left:10px; font-size:0.8em; font-weight:bold;'>(".GetLang('lowerDefault').")</span>";
						$defaultStyle = " style='color:#666666;'";
					}
					else {
						$GLOBALS['ClassName'] = "GridRow";
						$GLOBALS['DeleteStatus'] = "";
						$defaultStyle = "";
					}

					if ($row['currencyisdefault'] && $row['currencystatus'] == 1) {
						$GLOBALS['Status'] = "<img border='0' src='images/tick.gif' alt='tick'>";
					}
					else if ($row['currencystatus'] == 1) {
						$GLOBALS['Status'] = "<a title='" . GetLang('CurrencyStatusDisable') . "' href='index.php?ToDo=settingsEditCurrencyStatus&amp;currencyId=" . $row['currencyid'] . "&amp;status=0'><img border='0' src='images/tick.gif' alt='tick'></a>";
					}
					else {
						$GLOBALS['Status'] = "<a title='" . GetLang('CurrencyStatusEnable') . "' href='index.php?ToDo=settingsEditCurrencyStatus&amp;currencyId=" . $row['currencyid'] . "&amp;status=1'><img border='0' src='images/cross.gif' alt='cross'></a>";
					}

					$GLOBALS['CurrencyLinks'] = "<a title='" . GetLang('CurrencyEdit') . "' href='index.php?ToDo=settingsEditCurrency&amp;currencyId=" . $row['currencyid'] . "'>" . GetLang('Edit') . "</a>";
					$GLOBALS['CurrencyLinks'] .= "&nbsp;&nbsp;&nbsp;&nbsp;";

					// Default record should not be able to set as default again
					if ($row['currencyisdefault']) {
						$GLOBALS['CurrencyLinks'] .= "<span style='color:#666666;'>" . GetLang('CurrencySetAsDefault') . "</span>";
					}
					else {
						$GLOBALS['CurrencyLinks'] .= "<a href='#' title='" . GetLang('CurrencySetAsDefault') . "' onclick='return ConfirmSetAsDefault(" . $row['currencyid'] . ");'>" . GetLang('CurrencySetAsDefault') . "</a>";
					}

					$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("currency.manage.row");
					$GLOBALS['CurrencyGrid'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
				}
			}
			else {
				// There are no currencies in the database
				$GLOBALS['DisableDelete'] = "style='display:none'";
				$GLOBALS['DisplayGrid'] = "none";
				$GLOBALS['CurrencyOptionsMessage'] = MessageBox(GetLang('NoCurrencies'), MSG_INFO);
				$GLOBALS['ShowCurrencyTableHeaders'] = 'none';
			}

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("settings.currency.manage");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}

		private function _getCurrencyConvertersAsOptions()
		{
			// Get a list of all available currency converters as <option> tags
			$converters = GetAvailableModules('currency');
			$output = "";

			foreach ($converters as $converter) {
				$sel = '';
				if($converter['enabled']) {
					$sel = 'selected="selected"';
				}
				$output .= sprintf("<option %s value='%s'>%s</option>", $sel, $converter['id'], $converter['name']);
			}

			return $output;
		}

		private function _getCurrencyList()
		{
			$query = "SELECT * FROM [|PREFIX|]currencies ORDER BY currencyisdefault DESC, currencyname ASC";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			return $result;
		}

		private function _getCurrencyConverterAsItems($selectedConverterCode=null, $defaultManualSelect=true)
		{
			if (is_null($selectedConverterCode) && $defaultManualSelect) {
				$selected = 'checked="checked"';
			}
			else {
				$selected = '';
			}

			$converters = GetAvailableModules('currency');
			$convertorList = '<input ' . $selected . ' type="radio" name="currencyconverter" id="currencyconvertermanual" value="" onclick="toggleExchangeConverter(\'manual\');" />'
						   . '<label for="currencyconvertermanual">' . GetLang('CurrencyConverterManual') . '</label><br />';

			foreach ($converters as $converter) {

				if (!$converter['enabled']) {
					continue;
				}

				if ($selectedConverterCode == $converter['id']) {
					$selected = 'checked="checked"';
					$hide = 'inline';
				}
				else {
					$selected = '';
					$hide = 'none';
				}

				$labelValue = sprintf(GetLang('CurrencyConverterAuto'), $converter['object']->geturl(), isc_html_escape($converter['name']));
				$convertorList .= '<input ' . $selected . ' type="radio" name="currencyconverter" id="currencyconverter' . $converter['id'] . '" value="' . $converter['id'] . '" '
								. ' onclick="toggleExchangeConverter(\'' . addslashes($converter['id']) . '\');"/>'
								. '<label for="currencyconverter' . $converter['id'] . '">' . $labelValue . '</label>'
								. '<div style="display:' . $hide . '; margin-left:10px;" id="currencyconverterupdate' . $converter['id'] . '">'
								. '<input type="button" name="currencyconverterupdate" class="FormButton" value="' . GetLang('CurrencyConverterUpdate') . '" '
								. ' onclick="getExchangeRate(\'' . addslashes($converter['id']) . '\');" /></div>'
								. '<br />';
			}

			return $convertorList;
		}

		private function _getCurrencyOriginOptions($countryid=null, $regionid=null)
		{
			$html	= '<optgroup id="currencyorigintype-region" label="' . isc_html_escape(GetLang('CurrencyRegions')) . '">';
			$html	.= GetRegionList($regionid, false, "AllRegions", 0, true);
			$html	.= '</optgroup>';
			$html	.= '<optgroup id="currencyorigintype-country" label="' . isc_html_escape(GetLang('CurrencyCountries')) . '">';
			$html	.= GetCountryList($countryid, false, "AllCountries", 0, true);
			$html	.= '</optgroup>';

			return $html;
		}

		private function AddCurrency()
		{
			$currency = GetDefaultCurrency();

			$GLOBALS['FormAction'] = "SettingsSaveNewCurrency";
			$GLOBALS['CurrencyTitle'] = GetLang('AddCurrency');
			$GLOBALS['CancelMessage'] = GetLang('CancelAddCurrency');
			$GLOBALS['OriginList'] = $this->_getCurrencyOriginOptions();
			$GLOBALS['ConverterList'] = $this->_getCurrencyConverterAsItems();
			$GLOBALS['CurrencyConverterBox'] = sprintf(GetLang('CurrencyConverterBox'), $currency['currencycode']);
			$GLOBALS['CurrencyExchangeRateHelp'] = sprintf(GetLang('CurrencyExchangeRateHelp'), $currency['currencycode'], GetConfig('DefaultCurrencyRate'));

			// Add some default options
			$GLOBALS['CurrencyEnabled'] = ' checked="checked"';
			$GLOBALS['CurrencyString'] = GetLang('InstallDefaultCurrencyString');
			$GLOBALS['CurrencyDecimalString'] = GetLang('InstallDefaultCurrencyDecimalString');
			$GLOBALS['CurrencyThousandString'] = GetLang('InstallDefaultCurrencyThousandString');
			$GLOBALS['CurrencyDecimalPlace'] = GetLang('InstallDefaultCurrencyDecimalPlace');

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("currency.form");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}

		private function GetCurrencyDataFromPost()
		{
			$data = array(
				'currencyname' => $_POST['currencyname'],
				'currencycode' => isc_strtoupper($_POST['currencycode']),
				'currencyconvertercode' => $_POST['currencyconverter'],
				'currencyexchangerate' => $_POST['currencyexchangerate'],
				'currencystringposition' => isc_strtoupper($_POST['currencystringposition']),
				'currencystring' => $_POST['currencystring'],
				'currencydecimalstring' => $_POST['currencydecimalstring'],
				'currencythousandstring' => $_POST['currencythousandstring'],
				'currencydecimalplace' => $_POST['currencydecimalplace'],
				'currencylastupdated' => time()
			);

			if (strtolower($_POST['currencyorigintype']) == "country") {
				$data['currencycouregid'] = null;
				$data['currencycountryid'] = $_POST["currencyorigin"];
			} else if (strtolower($_POST['currencyorigintype']) == "region") {
				$data['currencycouregid'] = $_POST["currencyorigin"];
				$data['currencycountryid'] = null;
			}

			if (isset($_POST['currencystatus'])) {
				$data['currencystatus'] = 1;
			}
			else {
				$data['currencystatus'] = 0;
			}

			return $data;
		}

		private function SaveNewCurrency()
		{
			$pass = true;
			$message = "";
			$data = $this->GetCurrencyDataFromPost();

			// Is there already a currency setup for the selected code?
			if (!$this->CurrencyCheck($data, $message)) {
				$this->ManageCurrencySettings(array(sprintf(GetLang('CurrencyNotAdded'), $message) => MSG_ERROR));
				exit;
			}

			// We must be able to start a transaction
			if (!$GLOBALS['ISC_CLASS_DB']->StartTransaction()) {
				$pass = false;
				$message = $GLOBALS['ISC_CLASS_DB']->Error();
			}

			if ($pass) {
				$GLOBALS['ISC_CLASS_DB']->InsertQuery("currencies", $data, true);
			}

			if ($pass && $GLOBALS['ISC_CLASS_DB']->Error() != "") {
				$GLOBALS['ISC_CLASS_DB']->RollbackTransaction();
				$message = $GLOBALS['ISC_CLASS_DB']->Error();
				$pass = false;
			}

			// Mark this as configured if we haven't yet
			if ($pass && !GetConfig('CurrencyConfigured')) {
				$GLOBALS['ISC_NEW_CFG']['CurrencyConfigured'] = 1;
				$pass = (bool)$this->CommitSettings($messages);
			}

			if ($pass) {
				$GLOBALS['ISC_CLASS_DB']->CommitTransaction();

				// Update the cached currency list
				$GLOBALS['ISC_CLASS_DATA_STORE']->UpdateCurrencies();

				$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($GLOBALS['ISC_CLASS_DB']->LastId(), $data['currencyname'] . ' ('. $data['currencycode'] . ')');
				$this->ManageCurrencySettings(array(GetLang('CurrencyAddedSuccessfully') => MSG_SUCCESS));
			}
			else {
				$message = $GLOBALS['ISC_CLASS_DB']->GetErrorMsg();
				$GLOBALS['ISC_CLASS_DB']->RollbackTransaction();
				$this->ManageCurrencySettings(array(sprintf(GetLang('CurrencyNotAdded'), $message) => MSG_ERROR));
			}
		}

		private function CurrencyCheck($data, &$message)
		{
			$isDefault = false;
			if (array_key_exists("currencyid", $_REQUEST) && isId($_REQUEST['currencyid']) && $_REQUEST['currencyid'] == GetConfig("DefaultCurrencyID")) {
				$isDefault = true;
			}

			// General check to see if the required fields were entered
			$requiredFields = array(
				'currencyname'				=> GetLang('EnterCurrencyName'),
				'currencycode'				=> GetLang('EnterCurrencyCode'),
				'currencyexchangerate'		=> GetLang('EnterCurrencyExchangeRate'),
				'currencystringposition'	=> GetLang('EnterCurrencyStringPosition'),
				'currencystring'			=> GetLang('EnterCurrencyString'),
				'currencydecimalstring'		=> GetLang('EnterCurrencyDecimalString'),
				'currencythousandstring'	=> GetLang('EnterCurrencyThousandString'),
				'currencydecimalplace'		=> GetLang('EnterCurrencyDecimalPlace')
			);

			if ($isDefault) {
				unset($requiredFields['currencyexchangerate']);
			}

			foreach ($requiredFields as $key => $err) {
				if (!array_key_exists($key, $data) || strlen($data[$key]) == 0) {
					$message = $err;
					return false;
				}
			}

			if (!isId($data["currencycountryid"]) && !isId($data["currencycouregid"])) {
				$message = GetLang('EnterCurrencyOrigin');
				return false;
			}

			if (!preg_match('/^[a-z]{3}$/i', $data['currencycode'])) {
				$message = GetLang('InvalidCurrencyCode');
				return false;
			}

			if (!$isDefault && !is_numeric($data['currencyexchangerate'])) {
				$message = GetLang('InvalidCurrencyExchangeRate');
				return false;
			}

			$oneChar = array(
				"currencydecimalstring"		=> GetLang('InvalidCurrencyDecimalString'),
				"currencythousandstring"	=> GetLang('InvalidCurrencyThousandString')
			);

			foreach ($oneChar as $key => $err) {
				if (isc_strlen($data[$key]) > 1 || preg_match("/[0-9]+/", $data[$key])) {
					$message = $err;
					return false;
				}
			}

			if ($data['currencydecimalstring'] == $data['currencythousandstring']) {
				$message = GetLang('InvalidCurrencyStringMatch');
				return false;
			}

			// Check to see if we already have this one setup
			$query = "SELECT currencycode FROM [|PREFIX|]currencies WHERE currencycode='".$GLOBALS['ISC_CLASS_DB']->Quote(isc_strtoupper($data['currencycode']))."' AND ";

			if (isId($data['currencycountryid'])) {
				$query .= " currencycountryid='".(int)$data['currencycountryid']."'";
			} else if (isId($data['currencycouregid'])) {
				$query .= " currencycouregid='".(int)$data['currencycouregid']."'";
			}

			if (array_key_exists("currencyid", $_REQUEST) && isId($_REQUEST['currencyid'])) {
				$query .= " AND currencyid != '" . (int)$_REQUEST['currencyid']."'";
			}

			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			if($GLOBALS['ISC_CLASS_DB']->FetchOne($result, 'currencycode')) {
				$message = GetLang('CurrencyAlreadySetup');
				return false;
			}

			return true;
		}

		private function SaveUpdatedCurrencySettings()
		{
			// Delete existing module configuration
			$GLOBALS['ISC_CLASS_DB']->DeleteQuery('module_vars', "WHERE modulename LIKE 'currency\_%'");

			$converterproviders = '';
			if (isset($_POST['converterproviders'])) {
				$converterproviders = implode(",", $_POST['converterproviders']);
			}
			$enabledStack = $_POST['converterproviders'];

			// Push everything to globals and save
			$GLOBALS['ISC_NEW_CFG']['CurrencyMethods'] = $converterproviders;

			$messages = array();
			if ($this->CommitSettings($messages)) {
				// Now get all currency variables (they are in an array from $_POST)
				foreach($enabledStack as $module_id) {
					if (!GetModuleById('currency', $module, $module_id)) {
						continue;
					}

					$vars = array();
					if (isset($_POST[$module_id])) {
						$vars = $_POST[$module_id];
					}

					$module->SaveModuleSettings($vars);
				}

				if ($GLOBALS['ISC_CLASS_DB']->Error() == "") {
					// Log this action
					$GLOBALS['ISC_CLASS_LOG']->LogAdminAction();

					FlashMessage(GetLang('CurrencySettingsSavedSuccessfully'), MSG_SUCCESS, 'index.php?ToDo=viewCurrencySettings');
				} else {
					FlashMessage(GetLang('CurrencySettingsNotSaved'), MSG_ERROR, 'index.php?ToDo=viewCurrencySettings');
				}
			} else {
				FlashMessage(GetLang('CurrencySettingsNotSaved'), MSG_ERROR, 'index.php?ToDo=viewCurrencySettings');
			}
		}

		private function DeleteCurrencies()
		{
			if (isset($_POST['currencies']) && count($currenciesIdx = array_filter($_POST['currencies'], "isId")) > 0) {
				$currenciesIdx = implode(",", $GLOBALS['ISC_CLASS_DB']->Quote($currenciesIdx));

				// Delete the currency
				if(!$GLOBALS['ISC_CLASS_DB']->DeleteQuery('currencies', "WHERE currencyid IN (".$currenciesIdx.") AND currencyisdefault='0'")) {
					$this->ManageCurrencySettings(array($GLOBALS['ISC_CLASS_DB']->GetErrorMsg() => MSG_ERROR));
				} else {
					// Update the cached currency list
					$GLOBALS['ISC_CLASS_DATA_STORE']->UpdateCurrencies();

					// Log this action
					$GLOBALS['ISC_CLASS_LOG']->LogAdminAction(count($currenciesIdx));
					$this->ManageCurrencySettings();
				}
			}
			else {
				$this->ManageCurrencySettings();
			}
		}

		private function EditCurrency()
		{
			$currency = GetDefaultCurrency();

			$GLOBALS['FormAction'] = "SettingsSaveUpdatedCurrency";
			$GLOBALS['CurrencyTitle'] = GetLang('EditCurrency');
			$GLOBALS['CancelMessage'] = GetLang('CancelEditCurrency');
			$GLOBALS['CurrencyConverterBox'] = sprintf(GetLang('CurrencyConverterBox'), $currency['currencycode']);
			$GLOBALS['CurrencyExchangeRateHelp'] = sprintf(GetLang('CurrencyExchangeRateHelp'), $currency['currencycode'], GetConfig('DefaultCurrencyRate'));
			$GLOBALS['OriginListSize'] = ' size="2"';

			if (isset($_GET['currencyId'])) {
				$currencyId = (int)$_GET['currencyId'];
				$query = "SELECT * FROM [|PREFIX|]currencies WHERE currencyid='".$currencyId."'";
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

				$GLOBALS['hiddenFields'] = sprintf("<input type='hidden' name='currencyid' value='%d' />", $currencyId);

				if ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					$GLOBALS['CurrencyName'] = isc_html_escape($row['currencyname']);
					$GLOBALS['CurrencyCode'] = isc_html_escape($row['currencycode']);
					$GLOBALS['CurrencyString'] = isc_html_escape($row['currencystring']);
					$GLOBALS['CurrencyDecimalString'] = isc_html_escape($row['currencydecimalstring']);
					$GLOBALS['CurrencyThousandString'] = isc_html_escape($row['currencythousandstring']);
					$GLOBALS['CurrencyDecimalPlace'] = isc_html_escape($row['currencydecimalplace']);
					$GLOBALS['CurrencyExchangeRate'] = isc_html_escape((float)$row['currencyexchangerate']);
					$GLOBALS['ConverterList'] = $this->_getCurrencyConverterAsItems($row['currencyconvertercode']);
					$GLOBALS['OriginListSize'] = '';

					if (strtolower($row['currencystringposition']) == "left") {
						$GLOBALS['CurrencyLocationIsLeft'] = 'selected="selected"';
					} else {
						$GLOBALS['CurrencyLocationIsRight'] = 'selected="selected"';
					}

					if (isId($row['currencycountryid'])) {
						$GLOBALS['CurrencyOriginType'] = "country";
					} else if (isId($row['currencycouregid'])) {
						$GLOBALS['CurrencyOriginType'] = "region";
					}

					$GLOBALS['OriginList'] = $this->_getCurrencyOriginOptions($row['currencycountryid'], $row['currencycouregid']);

					if ($row['currencystatus'] == 1) {
						$GLOBALS['CurrencyEnabled'] = 'checked="checked"';
					}

					if ($row['currencyisdefault']) {
						$GLOBALS['HideOnDefault'] = " style='display:none;'";
					}

					$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("currency.form");
					$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
				}
				else {
					$this->ManageCurrencySettings();
				}
			}
			else {
				$this->ManageCurrencySettings();
			}
		}

		private function UpdateCurrencyStatus()
		{
			if (isset($_GET['currencyId']) && isset($_GET['status'])) {
				$currencyId = (int)$_GET['currencyId'];
				$status = (int)$_GET['status'];

				$updatedCurrency = array(
					"currencystatus" => $status
				);
				if($GLOBALS['ISC_CLASS_DB']->UpdateQuery("currencies", $updatedCurrency, "currencyid='".$GLOBALS['ISC_CLASS_DB']->Quote($currencyId)."'", true)) {
					$query = sprintf("SELECT currencyname FROM [|PREFIX|]currencies WHERE currencyid='%d'", $currencyId);
					$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
					$currName = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);

					// Update the cached currency list
					$GLOBALS['ISC_CLASS_DATA_STORE']->UpdateCurrencies();

					// Log this action
					$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($currencyId, $currName);

					FlashMessage(GetLang('CurrencyStatusSuccessfully'), MSG_SUCCESS, 'index.php?ToDo=viewCurrencySettings');
				} else {
					$err = $GLOBALS['ISC_CLASS_DB']->GetErrorMsg();
					FlashMessage(sprintf(GetLang('CurrencyErrStatusNotChanged'), $err), MSG_ERROR, 'index.php?ToDo=viewCurrencySettings');
				}
			}
		}

		private function SaveUpdatedCurrency()
		{
			$pass = true;
			$message = "";
			$data = $this->GetCurrencyDataFromPost();

			// Pop off some fields if this is a default record as we don't want them to modify them
			if ($_POST['currencyid'] == GetConfig('DefaultCurrencyID')) {
				unset($data['currencyconvertercode']);
				unset($data['currencyexchangerate']);
				unset($data['currencystatus']);
			}

			// We must be able to start a transaction
			if (!$GLOBALS['ISC_CLASS_DB']->StartTransaction()) {
				$pass = false;
				$message = $GLOBALS['ISC_CLASS_DB']->Error();
			}

			// Is there already a currency setup for the selected code?
			if (!$this->CurrencyCheck($data, $message)) {
				$pass = false;
			}

			if ($pass) {
				$GLOBALS['ISC_CLASS_DB']->UpdateQuery("currencies", $data, "currencyid='".$GLOBALS['ISC_CLASS_DB']->Quote((int)$_POST['currencyid'])."'", true);
			}

			if ($pass && $GLOBALS['ISC_CLASS_DB']->Error() != "") {
				$message = $GLOBALS['ISC_CLASS_DB']->Error();
				$pass = false;
			}

			// Are we setting this currency as the default?
			if ($pass && array_key_exists("setCurrencyAsDefault", $_POST) && $_POST['setCurrencyAsDefault'] && !$this->setDefaultCurrency($_POST['currencyid'], $message)) {
				$pass = false;
			}

			// If we were editing the default currency then recompile the settings again
			if ($pass && $_POST['currencyid'] == GetConfig('DefaultCurrencyID')) {
				$GLOBALS['ISC_NEW_CFG']['CurrencyToken']	= (string)$data['currencystring'];
				$GLOBALS['ISC_NEW_CFG']['CurrencyLocation']	= strtolower($data['currencystringposition']);
				$GLOBALS['ISC_NEW_CFG']['DecimalToken']		= (string)$data['currencydecimalstring'];
				$GLOBALS['ISC_NEW_CFG']['DecimalPlaces']	= (int)$data['currencydecimalplace'];
				$GLOBALS['ISC_NEW_CFG']['ThousandsToken']	= (string)$data['currencythousandstring'];

				$pass = (bool)$this->CommitSettings($messages);
			}

			if ($pass) {
				$GLOBALS['ISC_CLASS_DB']->CommitTransaction();
				$GLOBALS['ISC_CLASS_LOG']->LogAdminAction((int)$_POST['currencyid'], $data['currencyname'] . ' ('. $data['currencycode'] . ')');

				// Update the cached currency list
				$GLOBALS['ISC_CLASS_DATA_STORE']->UpdateCurrencies();

				// Mark this as configured if we haven't yet
				if (!GetConfig('CurrencyConfigured')) {
					$GLOBALS['ISC_NEW_CFG']['CurrencyConfigured'] = 1;
					$this->CommitSettings($messages);
				}


				FlashMessage(GetLang('CurrencyUpdatedSuccessfully'), MSG_SUCCESS, 'index.php?ToDo=viewCurrencySettings');
			}
			else {
				$GLOBALS['ISC_CLASS_DB']->RollbackTransaction();
				FlashMessage(sprintf(GetLang('CurrencyNotUpdated'), $message), MSG_ERROR, 'index.php?ToDo=viewCurrencySettings');
			}
		}

		private function SaveSetAsDefaultCurrency()
		{
			$pass = true;
			$message = "";

			if (!array_key_exists("currencyId", $_REQUEST) || !isId($_REQUEST['currencyId'])) {
				$pass = false;
			}

			if(isset($_REQUEST['updatePrice']) && $_REQUEST['updatePrice'] == 1) {
				$updatePrices = true;
			}
			else {
				$updatePrices = false;
			}

			if ($pass && !$this->setDefaultCurrency($_REQUEST['currencyId'], $message, $updatePrices)) {
				$pass = false;
			}

			if ($pass) {

				// Update the cached currency list
				$GLOBALS['ISC_CLASS_DATA_STORE']->UpdateCurrencies();

				$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($_REQUEST['currencyId']);
				$this->ManageCurrencySettings(array(GetLang('CurrencySetAsDefaultSuccessfully') => MSG_SUCCESS));
			}
			else {
				$this->ManageCurrencySettings(array(sprintf(GetLang('CurrencyNotSetAsDefault'), $message) => MSG_ERROR));
			}
		}

		private function setDefaultCurrency($currencyId, &$message, $updatePrices=false)
		{
			$query = "SELECT * FROM [|PREFIX|]currencies WHERE currencyid='".(int)$currencyId."'";
			if (!isId($currencyId) || !($result = $GLOBALS['ISC_CLASS_DB']->Query($query)) || !($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result))) {
				$messages[] = GetLang('CurrencyNotSetToDefault');
				return false;
			}

			$query = "
				UPDATE [|PREFIX|]currencies
				SET currencyexchangerate = IF(currencyid <> ". $currencyId . ", (currencyexchangerate / " . (string)$row['currencyexchangerate'] . "), 1),
				currencyisdefault = IF(currencyid <> ". $currencyId . ", 0, 1), currencystatus = 1, currencylastupdated = UNIX_TIMESTAMP()
			";
			$GLOBALS['ISC_CLASS_DB']->Query($query);
			if ($GLOBALS['ISC_CLASS_DB']->Error() != "") {
				$message = $GLOBALS['ISC_CLASS_DB']->Error();
				return false;
			}

			$GLOBALS['ISC_CLASS_DB']->StartTransaction();

			if($updatePrices == true) {
				// Now the delicate part of updating all the product prices
				$query = "
					UPDATE [|PREFIX|]products
					SET prodprice = (prodprice * " . (string)$row['currencyexchangerate'] . "), prodcostprice = (prodcostprice * " . (string)$row['currencyexchangerate'] . "),
					prodretailprice = (prodretailprice * " . (string)$row['currencyexchangerate'] . "), prodsaleprice = (prodsaleprice * " . (string)$row['currencyexchangerate'] . "),
					prodcalculatedprice = (prodcalculatedprice * " . (string)$row['currencyexchangerate'] . ")
					";
				$GLOBALS['ISC_CLASS_DB']->Query($query);

				if ($GLOBALS['ISC_CLASS_DB']->Error() != "") {
					$message = $GLOBALS['ISC_CLASS_DB']->Error();
					return false;
				}

				// Don't forget our product variations
				$query = "
					UPDATE [|PREFIX|]product_variation_combinations
					SET vcprice = (vcprice * " . (string)$row['currencyexchangerate'] . ")
					";
				$GLOBALS['ISC_CLASS_DB']->Query($query);

				if ($GLOBALS['ISC_CLASS_DB']->Error() != "") {
					$message = $GLOBALS['ISC_CLASS_DB']->Error();
					return false;
				}

				// Also any store credit for all customers
				$query = "
					UPDATE [|PREFIX|]customers
					SET custstorecredit = (custstorecredit * " . (string)$row['currencyexchangerate'] . ")
					";
				$GLOBALS['ISC_CLASS_DB']->Query($query);

				if ($GLOBALS['ISC_CLASS_DB']->Error() != "") {
					$message = $GLOBALS['ISC_CLASS_DB']->Error();
					return false;
				}

				// Plus any of the product discounts
				$query = "
					UPDATE [|PREFIX|]product_discounts
					SET discountamount = (discountamount * " . (string)$row['currencyexchangerate'] . ")
					WHERE discounttype = 'price' OR discounttype = 'fixed'
					";
				$GLOBALS['ISC_CLASS_DB']->Query($query);

				if ($GLOBALS['ISC_CLASS_DB']->Error() != "") {
					$message = $GLOBALS['ISC_CLASS_DB']->Error();
					return false;
				}
			}

			// Save our new currency settings
			$GLOBALS['ISC_NEW_CFG']['DefaultCurrencyID']	= (int)$row['currencyid'];
			$GLOBALS['ISC_NEW_CFG']['CurrencyToken']		= (string)$row['currencystring'];
			$GLOBALS['ISC_NEW_CFG']['CurrencyLocation']		= strtolower($row['currencystringposition']);
			$GLOBALS['ISC_NEW_CFG']['DecimalToken']			= (string)$row['currencydecimalstring'];
			$GLOBALS['ISC_NEW_CFG']['DecimalPlaces']		= (int)$row['currencydecimalplace'];
			$GLOBALS['ISC_NEW_CFG']['ThousandsToken']		= (string)$row['currencythousandstring'];

			if($this->CommitSettings($messages)) {
				$GLOBALS['ISC_CLASS_DB']->CommitTransaction();
				return true;
			}
			else {
				$GLOBALS['ISC_CLASS_DB']->RollbackTransaction();
				return false;
			}
		}

		public function UpdateProductPrices()
		{
			$this->_UpdateProductPrices();
			FlashMessage(GetLang('ProductPricesUpdated'), MSG_SUCCESS, 'index.php?ToDo=viewTaxSettings');
		}

		public function _UpdateProductPrices()
		{
			// Update the price of each and every product in the database
			$query = "select productid, prodprice, prodretailprice, prodsaleprice, prodistaxable from [|PREFIX|]products";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				// Workout the calculated price for this product as it will be displayed
				$calcprice = CalcRealPrice($row['prodprice'], $row['prodretailprice'], $row['prodsaleprice'], $row['prodistaxable']);
				// Run an update query
				$updatedProduct = array(
					"prodcalculatedprice" => $calcprice
				);
				$GLOBALS['ISC_CLASS_DB']->UpdateQuery("products", $updatedProduct, "productid='".$GLOBALS['ISC_CLASS_DB']->Quote($row['productid'])."'");
			}

			// Log this action
			$GLOBALS['ISC_CLASS_LOG']->LogAdminAction();
		}

		private function ManageNotificationSettings($messages=array())
		{
			$GLOBALS['Message'] = GetFlashMessageBoxes();

			$GLOBALS['NotificationJavaScript'] = "";
			$GLOBALS['NotificationProviders'] = $this->GetNotificationProvidersAsOptions();

			// Which notification modules are enabled?
			$notifications = GetEnabledNotificationModules();

			$GLOBALS['NotificationTabs'] = "";
			$GLOBALS['NotificationDivs'] = "";
			$count = 2;

			// Setup each notification module with its own tab
			foreach ($notifications as $notification) {
				$GLOBALS['NotificationTabs'] .= sprintf('<li><a href="#" id="tab%d" onclick="ShowTab(%d)">%s</a></li>', $count, $count, $notification['name']);
				$GLOBALS['NotificationDivs'] .= sprintf('<div id="div%d" style="padding-top: 10px;">%s</div>', $count, $notification['object']->getpropertiessheet($count));
				$count++;
			}

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("settings.notifications.manage");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}

		private function GetNotificationProvidersAsOptions()
		{
			// Get a list of all available notification providers as <option> tags
			$notifications = GetAvailableModules('notification');
			$output = "";

			foreach ($notifications as $notification) {
				$sel = '';
				if($notification['enabled']) {
					$sel = 'selected="selected"';
				}
				$output .= sprintf("<option %s value='%s'>%s</option>", $sel, $notification['id'], $notification['name']);
			}

			return $output;
		}

		private function SaveUpdatedNotificationSettings()
		{
			// Delete existing module configuration
			$GLOBALS['ISC_CLASS_DB']->DeleteQuery('module_vars', "WHERE modulename LIKE 'notification\_%'");

			$enabledStack = array();
			$messages = array();

			if(isset($_POST['notificationproviders'])) {
				// Can the selected payment modules be enabled?
				foreach ($_POST['notificationproviders'] as $provider) {
					GetModuleById('notification', $module, $provider);
					if (is_object($module)) {
					// Is this notification provider supported on this server?
						if($module->IsSupported() == false) {
							$errors = $module->GetErrors();
							foreach($errors as $error) {
								FlashMessage($error, MSG_ERROR);
							}
							continue;
						}

						// Otherwise, this notification provider is fine, so add it to the stack of enabled
						$enabledStack[] = $provider;
					}
				}
			}

			$notificationproviders = implode(",", $enabledStack);

			// Push everything to globals and save
			$GLOBALS['ISC_NEW_CFG']['NotificationMethods'] = $notificationproviders;

			if ($this->CommitSettings($messages)) {
				// Now get all notification variables (they are in an array from $_POST)
				foreach($enabledStack as $module_id) {
					$vars = array();
					if(isset($_POST[$module_id])) {
						$vars = $_POST[$module_id];
					}
					GetModuleById('notification', $module, $module_id);
					$module->SaveModuleSettings($vars);
				}

				// Rebuild the cache of the notification module variables
				$GLOBALS['ISC_CLASS_DATA_STORE']->UpdateNotificationModuleVars();

				if ($GLOBALS['ISC_CLASS_DB']->Error() == "") {
					// Log this action
					$GLOBALS['ISC_CLASS_LOG']->LogAdminAction();
					FlashMessage(GetLang('NotificationSettingsSavedSuccessfully'), MSG_SUCCESS, 'index.php?ToDo=viewNotificationSettings');
				} else {
					FlashMessage(GetLang('NotificationSettingsNotSaved'), MSG_ERROR, 'index.php?ToDo=viewNotificationSettings');
				}
			} else {
				FlashMessage(GetLang('NotificationSettingsNotSaved'), MSG_ERROR, 'index.php?ToDo=viewNotificationSettings');
			}
		}

		private function TestNotificationMethod()
		{
			$notifier = null;

			if (isset($_GET['module'])) {
				$module = $_GET['module'];

				if (GetModuleById('notification', $notifier, $module)) {
					$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("module.pageheader");
					$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
					$notifier->TestNotificationForm();
					$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("module.pagefooter");
					$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
				}
			}
		}

		private function ManageMailSettings($messages=array())
		{
			$GLOBALS['Message'] = GetFlashMessageBoxes();

			foreach ($this->all_vars as $var) {
				if (is_string(GetConfig($var)) || is_numeric(GetConfig($var))) {
					$GLOBALS[$var] = isc_html_escape(GetConfig($var));
				}
			}

			$num_lists = 0;
			$GLOBALS['NewsletterMailingLists'] = "";

			// Has the XML been tested and validated?
			if (GetConfig('MailXMLAPIValid')) {
				$GLOBALS['MailSettingsIntro'] = GetLang('MailSettingsIntroDone');
				$GLOBALS['ShowIntegrationTab'] = "1";
				$GLOBALS['ISC_CLASS_ADMIN_SENDSTUDIO'] = GetClass('ISC_ADMIN_SENDSTUDIO');
				$GLOBALS['NewsletterMailingLists'] = $GLOBALS['ISC_CLASS_ADMIN_SENDSTUDIO']->GetAvailableMailingListsAsOptions("", $num_lists);

				// If there aren't any lists we'll hide the dropdown
				if ($num_lists == 0) {
					$GLOBALS['HideLists'] = "1";
				}

				if(GetConfig('MailOrderListAutoSubscribe')) {
					$GLOBALS['MailOrderListAutoSubscribeChecked'] = 'checked="checked"';
				}

				// Default to product name updates if none are selected
				if(!GetConfig('UseMailAPIForUpdates')) {
					$GLOBALS['ProductUpdatesByName'] = 'checked="checked"';
				}
				else {
					switch(GetConfig('MailProductUpdatesListType')) {
						case "PRODUCT_NAME": {
							$GLOBALS['ProductUpdatesByName'] = 'checked="checked"';
							break;
						}
						case "PRODUCT_CATEGORY": {
							$GLOBALS['ProductUpdatesByCategory'] = 'checked="checked"';
							break;
						}
						case "PRODUCT_BRAND": {
							$GLOBALS['ProductUpdatesByBrand'] = 'checked="checked"';
							break;
						}
					}
				}
			}
			else {
				// Show the long detailed help guide
				$GLOBALS['MailSettingsIntro'] = GetLang('MailSettingsIntro');
			}

			$GLOBALS['MailLogo'] = GetConfig('MailLogo');

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("settings.mail.manage");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}

		private function SaveUpdatedMailSettings()
		{
			$messages = array();

			if (isset($_POST['MailXMLPath']) && isset($_POST['MailXMLToken']) && isset($_POST['MailUsername'])) {
				$xml_path = $_POST['MailXMLPath'];
				$xml_token = $_POST['MailXMLToken'];
				$api_user = $_POST['MailUsername'];

				$xml = "<xmlrequest>
							<username>" . $api_user . "</username>
							<usertoken>" . $xml_token . "</usertoken>
							<requesttype>authentication</requesttype>
							<requestmethod>xmlapitest</requestmethod>
							<details>
							</details>
						</xmlrequest>";

					$xml = urlencode($xml);

				// Let's make sure the path is valid before enabling the XML API
				$result = PostToRemoteFileAndGetResponse($xml_path, "xml=" . $xml);

				$response = @simplexml_load_string($result);
				if(!is_object($response)) {
					$GLOBALS['MailXMLAPIValid'] = 0;
				}

				// We expect the response to contain SUCCESS - no point using XML to validate when we can do a string comparison
				if (is_numeric(isc_strpos(isc_strtoupper($result), "<STATUS>SUCCESS</STATUS>"))) {
					$GLOBALS['ISC_NEW_CFG']['MailXMLAPIValid'] = "1";
					$GLOBALS['ISC_NEW_CFG']['MailXMLPath'] = $_POST['MailXMLPath'];
					$GLOBALS['ISC_NEW_CFG']['MailXMLToken'] = $_POST['MailXMLToken'];
					$GLOBALS['ISC_NEW_CFG']['MailUsername'] = $_POST['MailUsername'];
				}
				else {
					$GLOBALS['ISC_NEW_CFG']['MailXMLAPIValid'] = "0";
					$GLOBALS['ISC_NEW_CFG']['MailXMLPath'] = "";
					$GLOBALS['ISC_NEW_CFG']['MailXMLToken'] = "";
					$GLOBALS['ISC_NEW_CFG']['MailUsername'] = "";
					$GLOBALS['ISC_NEW_CFG']['MailAutomaticallyTickNewsletterBox'] = 0;
					$GLOBALS['ISC_NEW_CFG']['MailAutomaticallyTickOrderBox'] = 0;

					// Was an error message returned?
					if(isset($response->errormessage)) {
						$message = strval($response->errormessage);
						if(isc_strtolower(trim($message)) != "invalid details") {
							$messages[$message] = MSG_ERROR;
						}
					}
				}

				// Are we capturing subscribers from the newsletter form?
				if (isset($_POST['UseMailAPIForNewsletters'])) {
					$GLOBALS['ISC_NEW_CFG']['UseMailerForNewsletter'] = 1;
					$GLOBALS['ISC_NEW_CFG']['MailNewsletterList'] = (int)$_POST['MailNewsletterList'];
					$GLOBALS['ISC_NEW_CFG']['MailNewsletterCustomField'] = (int)@$_POST['MailNewsletterCustomField'];
				}
				else {
					$GLOBALS['ISC_NEW_CFG']['UseMailerForNewsletter'] = 0;
					$GLOBALS['ISC_NEW_CFG']['MailNewsletterList'] = 0;
					$GLOBALS['ISC_NEW_CFG']['MailNewsletterCustomField'] = 0;
				}

				// Are we capturing subscribers for customers?
				if (isset($_POST['UseMailAPIForOrders'])) {
					$GLOBALS['ISC_NEW_CFG']['UseMailerForOrders'] = 1;
					$GLOBALS['ISC_NEW_CFG']['MailOrderList'] = (int)$_POST['MailOrderList'];
					$GLOBALS['ISC_NEW_CFG']['MailOrderFirstName'] = (int)@$_POST['MailOrderFirstName'];
					$GLOBALS['ISC_NEW_CFG']['MailOrderLastName'] = (int)@$_POST['MailOrderLastName'];
					$GLOBALS['ISC_NEW_CFG']['MailOrderFullName'] = (int)@$_POST['MailOrderFullName'];
					$GLOBALS['ISC_NEW_CFG']['MailOrderZip'] = (int)@$_POST['MailOrderZip'];
					$GLOBALS['ISC_NEW_CFG']['MailOrderCountry'] = (int)@$_POST['MailOrderCountry'];
					$GLOBALS['ISC_NEW_CFG']['MailOrderTotal'] = (int)@$_POST['MailOrderTotal'];
					$GLOBALS['ISC_NEW_CFG']['MailOrderPaymentMethod'] = (int)@$_POST['MailOrderPaymentMethod'];
					$GLOBALS['ISC_NEW_CFG']['MailOrderShippingMethod'] = (int)@$_POST['MailOrderShippingMethod'];
					$GLOBALS['ISC_NEW_CFG']['MailOrderListAutoSubscribe'] = (int)@$_POST['MailOrderListAutoSubscribe'];
				}
				else {
					$GLOBALS['ISC_NEW_CFG']['UseMailerForOrders'] = 0;
					$GLOBALS['ISC_NEW_CFG']['MailOrderList'] = 0;
					$GLOBALS['ISC_NEW_CFG']['MailOrderFirstName'] = 0;
					$GLOBALS['ISC_NEW_CFG']['MailOrderLastName'] = 0;
					$GLOBALS['ISC_NEW_CFG']['MailOrderFullName'] = 0;
					$GLOBALS['ISC_NEW_CFG']['MailOrderZip'] = 0;
					$GLOBALS['ISC_NEW_CFG']['MailOrderCountry'] = 0;
					$GLOBALS['ISC_NEW_CFG']['MailOrderTotal'] = 0;
					$GLOBALS['ISC_NEW_CFG']['MailOrderPaymentMethod'] = 0;
					$GLOBALS['ISC_NEW_CFG']['MailOrderShippingMethod'] = 0;
					$GLOBALS['ISC_NEW_CFG']['MailOrderListAutoSubscribe'] = 0;
				}

				// Are we showing product updates?
				if(isset($_POST['UseMailAPIForUpdates'])) {
					$GLOBALS['ISC_NEW_CFG']['UseMailAPIForUpdates'] = 1;
					$GLOBALS['ISC_NEW_CFG']['MailProductUpdatesListType'] = $_POST['MailProductUpdatesListType'];
				}
				else {
					$GLOBALS['ISC_NEW_CFG']['UseMailAPIForUpdates'] = 0;
					$GLOBALS['ISC_NEW_CFG']['MailProductUpdatesListType'] = "";
				}

				// Update the settings
				if ($this->CommitSettings($messages)) {

					if (GetConfig('MailXMLAPIValid')) {
						if ($GLOBALS['CurrentTab'] == 0) {
							$success_var = "MailAPIInitSuccess";
						}
						else {
							$success_var = "MailAPIIntegrationSuccess";
						}

						// Log this action
						$GLOBALS['ISC_CLASS_LOG']->LogAdminAction();

						$messages = array_merge(array(GetLang($success_var) => MSG_SUCCESS), $messages);

						foreach($messages as $message => $type) {
							FlashMessage($message, $type);
						}

						header("Location: index.php?ToDo=viewMailSettings");
						exit;
					}
					else {
						$GLOBALS['ISC_NEW_CFG']['MailXMLPath'] = $_POST['MailXMLPath'];
						$GLOBALS['ISC_NEW_CFG']['MailXMLToken'] = $_POST['MailXMLToken'];
						$GLOBALS['ISC_NEW_CFG']['MailUsername'] = $_POST['MailUsername'];

						$messages = array_merge(array(GetLang('MailAPIInitFailed') => MSG_ERROR), $messages);

						foreach($messages as $message => $type) {
							FlashMessage($message, $type);
						}

						header("Location: index.php?ToDo=viewMailSettings");
						exit;
					}
				} else {
					$messages = array_merge(array(GetLang('SettingsNotSaved') => MSG_ERROR), $messages);

					foreach($messages as $message => $type) {
						FlashMessage($message, $type);
					}

					header("Location: index.php?ToDo=viewMailSettings");
					exit;
				}
			}
			else {
				header("Location: index.php?ToDo=viewMailSettings");
				exit;
			}
		}

		public function ManageClickSettings()
		{
			ob_end_clean();
			$img = "";
			if (ech0(GetConfig('serverStamp'))) {
				$fp = fopen(dirname(__FILE__) . "/../../images/blank.gif", "rb");
				while (!feof($fp)) {
					$img .= fgets($fp, 1024);
				}
				fclose($fp);
				header("Content-Type:image/gif");
				echo $img;
			}
			else {
				echo time();
			}
			die();
		}

		private function ManageAnalyticsSettings($messages=array())
		{
			$GLOBALS['Message'] = GetFlashMessageBoxes();

			$GLOBALS['AnalyticsJavaScript'] = "";
			$GLOBALS['AnalyticsProviders'] = $this->GetAnalyticsPackagesAsOptions();

			// Which analytics modules are enabled?
			$packages = GetAvailableModules('analytics', true);
			$GLOBALS['AnalyticsTabs'] = "";
			$GLOBALS['AnalyticsDivs'] = "";
			$count = 2;

			// Setup each analytics module with its own tab
			foreach ($packages as $package) {
				$GLOBALS['AnalyticsTabs'] .= sprintf('<li><a href="#" id="tab%d" onclick="ShowTab(%d)">%s</a></li>', $count, $count, $package['name']);
				$GLOBALS['AnalyticsDivs'] .= sprintf('<div id="div%d" style="padding-top: 10px;">%s</div>', $count, $package['object']->getpropertiessheet($count));

				$count++;
			}

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("settings.analytics.manage");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}

		private function SaveUpdatedAnalyticsSettings()
		{
			// Delete existing module configuration
			$GLOBALS['ISC_CLASS_DB']->DeleteQuery('module_vars', "WHERE modulename LIKE 'analytics\_%'");

			$enabledStack = array();
			$messages = array();

			// Can the selected payment modules be enabled?
			foreach ($_POST['analyticsproviders'] as $provider) {
				GetModuleById('analytics', $module, $provider);
				if (is_object($module)) {
				// Is this analytics provider supported on this server?
					if($module->IsSupported() == false) {
						$errors = $module->GetErrors();
						foreach($errors as $error) {
							FlashMessage($error, MSG_ERROR);
						}
						continue;
					}

					// Otherwise, this analytics provider is fine, so add it to the stack of enabled
					$enabledStack[] = $provider;
				}
			}

			$analyticsproviders = implode(",", $enabledStack);

			// Push everything to globals and save
			$GLOBALS['ISC_NEW_CFG']['AnalyticsMethods'] = $analyticsproviders;

			if ($this->CommitSettings($messages)) {
				// Now get all analytics variables (they are in an array from $_POST)
				foreach($enabledStack as $module_id) {
					$vars = array();
					if(isset($_POST[$module_id])) {
						$vars = $_POST[$module_id];
					}
					GetModuleById('analytics', $module, $module_id);
					$module->SaveModuleSettings($vars);
				}

				// Rebuild the cache of the analytics module variables
				$GLOBALS['ISC_CLASS_DATA_STORE']->UpdateAnalyticsModuleVars();

				if ($GLOBALS['ISC_CLASS_DB']->Error() == "") {
					// Log this action
					$GLOBALS['ISC_CLASS_LOG']->LogAdminAction();
					FlashMessage(GetLang('AnalyticsSettingsSavedSuccessfully'), MSG_SUCCESS, 'index.php?ToDo=viewAnalyticsSettings');
				}
				else {
					FlashMessage(GetLang('AnalyticsSettingsNotSaved'), MSG_ERROR, 'index.php?ToDo=viewAnalyticsSettings');
				}
			} else {
				FlashMessage(GetLang('AnalyticsSettingsNotSaved'), MSG_ERROR, 'index.php?ToDo=viewAnalyticsSettings');
			}
		}

		private function GetAnalyticsPackagesAsOptions()
		{

			// Get a list of all available analytics modules as <option> tags
			$analytics = GetAvailableModules('analytics');
			$output = "";

			foreach ($analytics as $package) {
				$sel = '';
				if($package['enabled']) {
					$sel = 'selected="selected"';
				}
				$output .= sprintf("<option %s value='%s'>%s</option>", $sel, $package['id'], $package['name']);
			}

			return $output;
		}

		private function GetAddonPackagesAsOptions()
		{

			// Get a list of all available addon modules as <option> tags
			$addons = GetAvailableAddonModules();
			$output = "";

			foreach ($addons as $package) {
				$sel = '';
				if($package['enabled']) {
					$sel = 'selected="selected"';
				}
				$output .= sprintf("<option %s value='%s'>%s</option>", $sel, $package['id'], $package['name']);
			}

			return $output;
		}

		private function ManageAddonSettings()
		{
			$GLOBALS['Message'] = GetFlashMessageBoxes();

			$numAvailableAddons = count(GetAvailableAddonModules());

			if ($numAvailableAddons == 0) {
				$GLOBALS['ErrorTitle'] = GetLang('NoAddonPackages');
				$GLOBALS['Message'] = MessageBox(GetLang('SeeAddonPackages'), MSG_INFO);
				$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("error");
				$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
			}
			else {
				$GLOBALS['AddonJavaScript'] = "";
				$GLOBALS['AddonProviders'] = $this->GetAddonPackagesAsOptions();

				$GLOBALS['AddonSelectBoxSize'] = min($numAvailableAddons*4, 12);

				// Which addon modules are enabled?
				$packages = GetEnabledAddonModules();
				$GLOBALS['AddonTabs'] = "";
				$GLOBALS['AddonDivs'] = "";
				$count = 1;

				// Setup each addon module with its own tab
				foreach ($packages as $package) {
					$package['object']->init();
					$GLOBALS['AddonTabs'] .= sprintf('<li><a href="#" id="tab%d" onclick="ShowTab(%d)">%s</a></li>', $count, $count, $package['name']);
					$GLOBALS['AddonDivs'] .= sprintf('<div id="div%d" style="padding-top: 10px;">%s</div>', $count, $package['object']->getpropertiessheet($count));
					$count++;
				}

				if (isset($GLOBALS['TabIdsToHideButtonsFrom'])) {
					$GLOBALS['TabIdsToHideButtonsFrom'] = preg_replace("/,$/", "", $GLOBALS['TabIdsToHideButtonsFrom']);
				}

				$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("settings.addons.manage");
				$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
			}
		}

		private function SaveUpdatedAddonSettings()
		{
			// Delete existing module configuration
			$GLOBALS['ISC_CLASS_DB']->DeleteQuery('module_vars', "WHERE modulename LIKE 'addon\_%'");

			$enabledStack = array();
			$messages = array();

			// Can the selected addons be enabled?
			if (!isset($_POST['addonpackages']) || !is_array($_POST['addonpackages'])) {
				$_POST['addonpackages'] = array();
			}

			foreach ($_POST['addonpackages'] as $package) {
				$id = explode('_', $package, 2);
				GetAddonsModule($module, $id[1]);

				if (is_object($module)) {
				// Is this addon supported on this server?
					if($module->IsSupported() == false) {
						$errors = $module->GetErrors();
						foreach($errors as $error) {
							FlashMessage($error, MSG_ERROR);
						}
						continue;
					}

					// Otherwise, this addon is fine, so add it to the stack of enabled
					$enabledStack[] = 'addon_'.$id[1];
				}
			}

			$addonpackages = implode(",", $enabledStack);

			// Push everything to globals and save
			$GLOBALS['ISC_NEW_CFG']['AddonModules'] = $addonpackages;

			$messages = array();

			if ($this->CommitSettings($messages)) {
				// Now get all addon variables (they are in an array from $_POST)
				foreach($enabledStack as $module_id) {
					$vars = array();
					if(isset($_POST[$module_id])) {
						$vars = $_POST[$module_id];
					}

					GetModuleById('addon', $module, $module_id);
					$module->SaveModuleSettings($vars);
				}

				$tab = 0;
				if(isset($_POST['currentTab'])) {
					$tab = (int)$_POST['currentTab'];
				}

				if ($GLOBALS['ISC_CLASS_DB']->Error() == "") {
					// Log this action
					$GLOBALS['ISC_CLASS_LOG']->LogAdminAction();

					// Redirect them so that any new modules appear in the menu straight away
					$success = true;
					$message = GetLang('AddonSettingsSavedSuccessfully');
				}
				else {
					$success = false;
					$message = GetLang('AddonSettingsNotSaved');
				}
			}
			else {
					$success = false;
					$message = GetLang('AddonSettingsNotSaved');
			}

			if($success == true) {
				$msgType = MSG_SUCCESS;
			}
			else {
				$msgType = MSG_ERROR;
			}

			// Rebuild the cache of the addon module variables
			$GLOBALS['ISC_CLASS_DATA_STORE']->UpdateAddonModuleVars();

			FlashMessage($message, $msgType, 'index.php?ToDo=viewAddonSettings');
		}

		/**
		* Get a list of html options for use in a timezone list
		*
		* @param string the current timezone
		*
		* @return string The options for the timezones
		*/
		public function GetTimeZoneOptions($current='')
		{
			$option_template = '<option value="%1$s">%2$s</option>';
			$option_selected_template = '<option value="%1$s" selected="selected">%2$s</option>';

			$output = '';

			foreach ($this->timezones as $value => $zone) {
				if ($value != $current) {
					$output .= sprintf($option_template, $value, isc_html_escape(GetLang('TimeZone_'.$zone)));
				} else {
					$output .= sprintf($option_selected_template, $value, isc_html_escape(GetLang('TimeZone_'.$zone)));
				}
			}
			return $output;
		}

		private function ManageKBSettings($messages=array())
		{
			require_once(dirname(__FILE__) . "/class.pages.php");

			$GLOBALS['Message'] = GetFlashMessageBoxes();

			foreach ($this->all_vars as $var) {
				if (is_string(GetConfig($var)) || is_numeric(GetConfig($var))) {
					$GLOBALS[$var] = isc_html_escape(GetConfig($var));
				}
			}

			$GLOBALS['ISC_CLASS_ADMIN_PAGES'] = GetClass('ISC_ADMIN_PAGES');

			// Has ActiveKB been integrated?
			if (GetConfig('AKBIsConfigured')) {
				$GLOBALS['KBPath'] = GetConfig('AKBPath');
				$GLOBALS['CategoryOptions'] = $GLOBALS['ISC_CLASS_ADMIN_PAGES']->GetContactPagesAsOptions(explode(",", GetConfig('ARSPageIds')));

				if(GetConfig('ARSIntegrated') && strlen($GLOBALS['CategoryOptions']) != 0) {
					$GLOBALS['IsARSIntegrated'] = 'checked="checked"';
				}
			}
			else {
				$GLOBALS['KBPath'] = "http://";
				$GLOBALS['CategoryOptions'] = $GLOBALS['ISC_CLASS_ADMIN_PAGES']->GetContactPagesAsOptions();
			}

			$GLOBALS['KBSettingsIntro'] = sprintf(GetLang('KBSettingsIntro'), $GLOBALS['ShopPath'], $GLOBALS['ShopPath']);
			$GLOBALS['HideARSFields'] = "none";

			// If there aren't any contact pages yet we'll tell them they have to create one first
			if($GLOBALS['CategoryOptions'] == "") {
				$GLOBALS['CanIntegrateARS'] = "0";
			}

			$GLOBALS['KBLogo'] = GetConfig('KBLogo');

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("settings.kb.manage");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}

		private function SaveUpdatedKBSettings()
		{
			$GLOBALS['ISC_NEW_CFG']['AKBPath'] = "";
			$GLOBALS['ISC_NEW_CFG']['ARSPageIds'] = 0;
			$GLOBALS['ISC_NEW_CFG']['ARSIntegrated'] = 0;

			$messages = array();

			if(isset($_POST['KBPath'])) {
				$kb_path = $_POST['KBPath'];
				$kb_path = str_replace("index.php", "", $kb_path);
				$kb_path = rtrim($kb_path, '/');
				$GLOBALS['ISC_NEW_CFG']['AKBPath'] = $kb_path;

				// Are we integrating it into any contact pages?
				if(isset($_POST['KBContactFormIntegration']) && $_POST['KBContactFormIntegration'] == "ON" && isset($_POST['pageids']) && is_array($_POST['pageids'])) {
					$GLOBALS['ISC_NEW_CFG']['ARSPageIds'] = implode(",", $_POST['pageids']);
					$GLOBALS['ISC_NEW_CFG']['ARSIntegrated'] = true;
				}

				$GLOBALS['ISC_NEW_CFG']['AKBIsConfigured'] = true;

				if($this->CommitSettings()) {
					$messages = array_merge(array(GetLang('AKBSettingsSavedSuccessfully') => MSG_SUCCESS), $messages);
				}
				else {
					$messages = array_merge(array(GetLang('AKBSettingsNotSaved') => MSG_ERROR), $messages);
				}

				$this->ManageKBSettings($messages);
			}
			else {
				$this->ManageKBSettings();
			}
		}

		/**
		 * Get the languages available for use as an array
		 *
		 * @return array An array with the 2 letter character codes as the values
		 **/
		public function GetAvailableLanguagesArray()
		{
			$langdir = ISC_BASE_PATH.'/language';
			$skip = Array (
				'.',
				'..',
				'CVS',
				'.svn',
			);
			$langs = array();

			$dh = opendir($langdir);
			while (($file = readdir($dh)) !== false) {
				if (in_array($file, $skip)) {
					continue;
				}

				if (!is_dir($langdir.'/'.$file)) {
					continue;
				}

				if (!is_file($langdir.'/'.$file.'/settings.ini')) {
					continue;
				}

				if (strlen($file) != 2) {
					continue;
				}

				$langs[] = $file;
			}
			return $langs;
		}

		/**
		* Get the list of options to show on the settings page
		*
		* @param string $selected The currently selected directory
		*
		* @return string The html options
		*/
		public function GetLanguageOptions($selected='en')
		{
			$output = '';
			$option_format = '<option value="%s"%s>%s</option>'."\n";

			// Full list of languages and their native names available at
			// http://en.wikipedia.org/wiki/List_of_ISO_639-1_codes

			$available_langs = $this->GetAvailableLanguagesArray();

			foreach ($available_langs as $lang) {
				$settings = parse_ini_file(ISC_BASE_PATH.'/language/'.$lang.'/settings.ini');

				$native_name = $settings['native_name'];

				if ($lang == $selected) {
					$sel = ' selected';
				} else {
					$sel = '';
				}
				$output .= sprintf($option_format, $lang, $sel, isc_html_escape($native_name));
			}
			return $output;
		}

		/**
		* Allow the user to enter their affiliate tracking code which will be placed on the finishorder.php page
		*
		* @return Void
		*/
		private function ManageAffiliateSettings($messages=array())
		{
			$GLOBALS['Message'] = GetFlashMessageBoxes();

			$GLOBALS['AffiliateConversionTrackingCode'] = GetConfig("AffiliateConversionTrackingCode");
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("settings.affiliates.manage");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}

		/**
		* Save the updated affiliate conversion tracking code to the config file
		*
		* @return Void
		*/
		private function SaveUpdatedAffiliateSettings()
		{
			$messages = array();

			if (isset($_POST['AffiliateConversionTrackingCode'])) {
				$GLOBALS['ISC_NEW_CFG']['AffiliateConversionTrackingCode'] = $_POST['AffiliateConversionTrackingCode'];

				if ($this->CommitSettings($messages)) {
					// Log this action
					$GLOBALS['ISC_CLASS_LOG']->LogAdminAction();
					FlashMessage(GetLang('AffiliateSettingsSavedSuccessfully'), MSG_SUCCESS, 'index.php?ToDo=viewAffiliateSettings');
				}
				else {
					FlashMessage(sprintf(GetLang('AffiliateSettingsNotSaved'), $messages), MSG_ERROR, 'index.php?ToDo=viewAffiliateSettings');
				}
			}
			else {
				$this->ManageAffiliateSettings();
			}
		}

/**
        * @ Edited by Simha
        */
        private function ManageMappingSettings($messages=array())
        {
            $GLOBALS['Message'] = GetFlashMessageBoxes();

            //$GLOBALS['AffiliateConversionTrackingCode'] = GetConfig("AffiliateConversionTrackingCode");  

            $mapping_data = "";

            /*$sql = " SELECT * FROM isc_import_variations  "; 
            $query = mysql_query($sql); 
            $columns = mysql_num_fields($query); 
            for($i = 2; $i < $columns; $i++) { 
                $temp = mysql_field_name($query,$i);  
                if (substr($temp,0,2) == "VQ" || substr($temp,0,2) == "PQ")
                {    
                    $query1 = "SELECT *  FROM [|PREFIX|]qualifier_names where column_name = '".$temp."' ";
                    $result1 = $GLOBALS['ISC_CLASS_DB']->Query($query1);
                    $row1 = $GLOBALS['ISC_CLASS_DB']->Fetch($result1);   
                    $mapping_data.= "<tr><td>".$temp." : </td><td><input type='text' size='25' value='".$row1['display_names']."' name=".$temp." id=".$temp." /></td></tr>";  
                }
            }*/ 
            //Above comment and new change by Simha
            $query = " SELECT column_name, display_names FROM [|PREFIX|]qualifier_names where column_name LIKE 'PQ%' OR column_name LIKE 'VQ%' ORDER BY column_name"; 
            $result = $GLOBALS['ISC_CLASS_DB']->Query($query); 
            
            while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {    
                $mapping_data.= "<tr><td>".$row['column_name']." : </td><td><input type='text' size='25' value='".$row['display_names']."' name=".$row['column_name']." id=".$row['column_name']." /></td></tr>";  
            } 

            $GLOBALS['mapping_data'] = $mapping_data;  
            $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("settings.mapping.manage");
            $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
        }
        /**
        * @ Edited by Simha
        */
        private function SaveUpdatedMappingSettings()
        {
            $messages = array();  
            foreach ($_POST as $key=>$val)
            {
                if ($val != "")
                {
                    $query = "update  [|PREFIX|]qualifier_names set `display_names` =   '".$val."' , `last_updated` = now()  where `column_name` =  '".$key."'";
                    $result = $GLOBALS['ISC_CLASS_DB']->Query($query);  
                    if (mysql_affected_rows() == 0 )
                    { 
                        $query2 = "insert into  [|PREFIX|]qualifier_names (`column_name`, `display_names`,`last_updated`) values ('".$key."' , '".$val."' ,  now()  ) ";
                        $result2 = $GLOBALS['ISC_CLASS_DB']->Query($query2);
                    }
                }  
            } 
            
            $this->SaveNewMapping();                         
        
            FlashMessage(GetLang('MappingSettingsSavedSuccessfully'), MSG_SUCCESS, 'index.php?ToDo=viewMappingSettings');
            
        }
        
        /**
        * @Added by Simha 
        * To add new mappings from post vars
        */
        private function SaveNewMapping()   
        {
            //print_r($_POST['qualifiers']);exit;
            for($i=0; $i<count($_POST['qualifiers']); $i++)
            {
                if(substr($_POST['qualifiers'][$i],0,2) == "VQ" || substr($_POST['qualifiers'][$i],0,2) == "PQ" )    { 
                    $query = "INSERT INTO [|PREFIX|]qualifier_names (`column_name`, `display_names`,`last_updated`) values ('".$_POST['qualifiers'][$i]."' , '".$_POST['qualifiervalue'][$i]."' ,  NOW()) ";
                    $result = $GLOBALS['ISC_CLASS_DB']->Query($query);   
                }   
                //
            }     
        }

		/** Baskaran Added starts
        * View list of irregular and generalize words
        *
        */
        private function ManageBedsize() {
            $GLOBALS['Message'] = GetFlashMessageBoxes(); 
            
            $numBed = 0;
            $GLOBALS['BedsizeDataGrid'] = $this->ManageBedsizeGrid($numBed);
            if(isset($_GET['ajax']) && $_GET['ajax']==1) 
            {
                echo $GLOBALS['BedsizeDataGrid']; 
                return;
            }
            
            if($numBed == 0) {
                $GLOBALS['DisplayGrid'] = "none";
                $GLOBALS['Message'] = MessageBox(GetLang('NoBedsizeResults'), MSG_SUCCESS);
            }
            
            $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("bedsize.manage");
            $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
            
            
        }
        
        private function CreateBedsize() {
            $GLOBALS['Message'] = GetFlashMessageBoxes(); 
            $GLOBALS['FormAction'] = "saveBedsizesettings";
            $GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("bedsize.form");
            $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
        }
        
        private function saveBedsize() {
            $irregular = $_POST['irregular'];
            $newbedsize = array(
                            "irregular_value" => $irregular,
                            "generalize_value" => $_POST['generalize'],
                            );
            $query = sprintf("select * from [|PREFIX|]bedsize_translation where irregular_value='%s'", $GLOBALS['ISC_CLASS_DB']->Quote($irregular));
            $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
            $cnt = $GLOBALS["ISC_CLASS_DB"]->CountResult($result);
            if($cnt != 1) {
                $GLOBALS['ISC_CLASS_DB']->InsertQuery("bedsize_translation", $newbedsize);
                FlashMessage(GetLang('BedsizeSavedSuccessfully'), MSG_SUCCESS, 'index.php?ToDo=viewBedsizeSettings');
            }
            else {
                FlashMessage(GetLang('BedsizeAlreadyExist'), MSG_ERROR, 'index.php?ToDo=createBedsizesettings');
            }
        }
        
        private function editbedsize($MsgDesc = "", $MsgStatus = "") {
            if(isset($_GET['bedId'])) {
                
                if ($MsgDesc != "") {
                    $GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
                }
                
                $bedId = (int)$_GET['bedId'];
                $query = sprintf("select * from [|PREFIX|]bedsize_translation where id='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($bedId));
                $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
                
                if($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) { 
                    $GLOBALS['bedId'] = $row['id'];
                    $GLOBALS['IrregularEdit'] = isc_html_escape($row['irregular_value']);
                    $GLOBALS['GeneralizeEdit'] = isc_html_escape($row['generalize_value']);
                    $GLOBALS['FormAction'] = "SaveEditedBedsizesettings"; 

                    $GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("bedsize.edit.form");
                    $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
                }
                else {
                    ob_end_clean();
                    header("Location: index.php?ToDo=viewBedsizeSettings");
                    die();
                }

            }
            else {
                ob_end_clean();
                header("Location: index.php?ToDo=viewBedsizeSettings");
                die();
            }                
        }
        
        private function SaveEditedBedsize()
        {                                              
            if(isset($_POST['irregular'])) {
                $bedId = (int)$_POST['bedId'];
                $irregular = $_POST['irregular'];
                $generalize = $_POST['generalize'];
                
               /* $query = sprintf("select * from [|PREFIX|]bedsize_translation where id='%d'", $bedId);
                $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
                $row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result);  */
                $updatedBedsize = array(
                    "irregular_value" => $irregular,
                    "generalize_value" => $generalize
                );
                $GLOBALS['ISC_CLASS_DB']->UpdateQuery("bedsize_translation", $updatedBedsize, "id='".$GLOBALS['ISC_CLASS_DB']->Quote($bedId)."'");
                if($GLOBALS["ISC_CLASS_DB"]->GetErrorMsg() == "") {
                    FlashMessage(GetLang('BedsizeSavedSuccessfully'), MSG_SUCCESS,'index.php?ToDo=viewBedsizeSettings');
                }
                else {
                    FlashMessage(sprintf(GetLang('UpdateBedsizeError'), $GLOBALS["ISC_CLASS_DB"]->GetErrorMsg()), MSG_ERROR,'index.php?ToDo=viewBedsizeSettings');
                }                
                
            }
            else {
                ob_end_clean();
                header("Location: index.php?ToDo=viewBedsizeSettings");
                die();
            }
        }
        
        private function deleteBedsize() {
            $bedId = $_GET['bedId'];
            $GLOBALS['ISC_CLASS_DB']->DeleteQuery('bedsize_translation', "WHERE id = '$bedId'");
            if($GLOBALS["ISC_CLASS_DB"]->GetErrorMsg() == "") {
                FlashMessage(GetLang('BedsizeDeletedSuccessfully'), MSG_SUCCESS,'index.php?ToDo=viewBedsizeSettings');
            }
            else {
                FlashMessage(sprintf(GetLang('UpdateBedsizeError'), $GLOBALS["ISC_CLASS_DB"]->GetErrorMsg()), MSG_ERROR,'index.php?ToDo=viewBedsizeSettings');
            }                
        }
        
        private function ManageBedsizeGrid(&$numBed) {
            // Show a list of news in a table
            $page = 0;
            $start = 0;
            $numBed = 0;
            $numPages = 0;
            $GLOBALS['BedsizeGrid'] = ''; 
            $GLOBALS['Nav'] = "";
            $max = 0;
            $searchURL = '';

            if (isset($_GET['searchQuery'])) {
                $query = $_GET['searchQuery'];
                $GLOBALS['Query'] = $query;
                $searchURL .'searchQuery='.urlencode($query);
            } else {
                $query = "";
                $GLOBALS['Query'] = "";
            }

            if (isset($_GET['sortOrder']) && $_GET['sortOrder'] == 'desc') {
                $sortOrder = 'desc';
            } else {
                $sortOrder = "asc";
            }

            $sortLinks = array(
                "Irregularvalue" => "b.irregular_value",
                "Generalizevalue" => "b.generalize_value",
            );

            if (isset($_GET['sortField']) && in_array($_GET['sortField'], $sortLinks)) {
                $sortField = $_GET['sortField'];
                SaveDefaultSortField("ManageBedsize", $_REQUEST['sortField'], $sortOrder);
            }
            else {
                list($sortField, $sortOrder) = GetDefaultSortField("ManageBedsize", "b.irregular_value", $sortOrder);
            }

            if (isset($_GET['page'])) {
                $page = (int)$_GET['page'];
            }
            else {
                $page = 1;
            }

            $sortURL = sprintf("&sortField=%s&sortOrder=%s", $sortField, $sortOrder);
            $GLOBALS['SortURL'] = $sortURL;

            // Limit the number of brands returned
            if ($page == 1) {
                $start = 1;
            }
            else {
                $start = ($page * ISC_BEDSIZE_PER_PAGE) - (ISC_BEDSIZE_PER_PAGE-1);
            }

            $start = $start-1;

            // Get the results for the query
            $bedsizeResult = $this->_GetBedsizeList($start, $sortField, $sortOrder, $numBed);
            $numPages = ceil($numBed / ISC_BEDSIZE_PER_PAGE);

            // Workout the paging navigation
            if($numBed > ISC_BEDSIZE_PER_PAGE) {
                $GLOBALS['Nav'] = sprintf("(%s %d of %d) &nbsp;&nbsp;&nbsp;", GetLang('Page'), $page, $numPages);

                $GLOBALS['Nav'] .= BuildPagination($numBed, ISC_BEDSIZE_PER_PAGE, $page, sprintf("index.php?ToDo=viewBedsizeSettings%s", $sortURL));
            }
            else {
                $GLOBALS['Nav'] = "";
            }

            $GLOBALS['SearchQuery'] = $query;
            $GLOBALS['SortField'] = $sortField;
            $GLOBALS['SortOrder'] = $sortOrder;

            BuildAdminSortingLinks($sortLinks, "index.php?ToDo=viewBedsizeSettings&amp;".$searchURL."&amp;page=".$page, $sortField, $sortOrder);


            // Workout the maximum size of the array
            $max = $start + ISC_BEDSIZE_PER_PAGE;

            if ($max > count($bedsizeResult)) {
                $max = count($bedsizeResult);
            }

            if($numBed > 0) {
            while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($bedsizeResult)) {
                $GLOBALS['Irregularvalue'] = isc_html_escape($row['irregular_value']);
                $GLOBALS['Generalizevalue'] = isc_html_escape($row['generalize_value']);
                $GLOBALS['EditBedsizeLink'] = sprintf("<a title='%s' class='Action' href='index.php?ToDo=editBedsizesettings&amp;bedId=%d'>%s</a>", GetLang('Edit'), $row['id'], GetLang('Edit'));
                $GLOBALS['DeleteBedsizeLink'] = sprintf("<a title='%s' class='Action' href='#' onclick=deletebedid(%d)>%s</a>", GetLang('Delete'), $row['id'], GetLang('Delete'));                
                
                $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("bedsize.manage.row");
                $GLOBALS['BedsizeGrid'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true); 
            }
            $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("bedsize.manage.grid");
            return $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
            }  
        }
        
        public function _GetBedsizeList($Start, $SortField, $SortOrder, &$NumResults)
        {
            // Return an array containing details about bedsize.

            // PostgreSQL is case sensitive for likes, so all matches are done in lower case
            $query = "SELECT * FROM [|PREFIX|]bedsize_translation b";

            $countQuery = "SELECT COUNT(*) FROM [|PREFIX|]bedsize_translation b";

            $queryWhere = ' WHERE 1=1 ';

            $query .= $queryWhere;
            $countQuery .= $queryWhere;

            $result = $GLOBALS['ISC_CLASS_DB']->Query($countQuery);
            $NumResults = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);

            if($NumResults > 0) {
                $query .= " ORDER BY ".$SortField." ".$SortOrder;

                // Add the limit
                $query .= $GLOBALS["ISC_CLASS_DB"]->AddLimit($Start, ISC_BEDSIZE_PER_PAGE);
                $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
                return $result;
            }
            else {
                return false;
            }
        }
        
        /** 
        * View list of irregular and generalize words
        *
        */
        private function ManageCabsize() {
            $GLOBALS['Message'] = GetFlashMessageBoxes(); 
            
            $numCab = 0;
            $GLOBALS['CabsizeDataGrid'] = $this->ManageCabsizeGrid($numCab);
            if(isset($_GET['ajax']) && $_GET['ajax']==1) 
            {
                echo $GLOBALS['CabsizeDataGrid']; 
                return;
            }
            
            if($numCab == 0) {
                $GLOBALS['DisplayGrid'] = "none";
                $GLOBALS['Message'] = MessageBox(GetLang('NoCabsizeResults'), MSG_SUCCESS);
            }
            
            $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("cabsize.manage");
            $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
            
            
        }
        
        private function CreateCabsize() {
            $GLOBALS['Message'] = GetFlashMessageBoxes();
            $GLOBALS['FormAction'] = "saveCabsizesettings";
            $GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("cabsize.form");
            $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
        }
        
        private function saveCabsize() {
            $prodstartyear = $_POST['prodstartyear'];
            $prodendyear = $_POST['prodendyear'];
            $prodmake = $_POST['prodmake'];
            $prodmodel = $_POST['prodmodel'];
            $irregular_value = $_POST['irregular'];
            $generalize_value = $_POST['generalize'];

            $newcabsize = array(
                            "prodstartyear" => $prodstartyear,
                            "prodendyear" => $prodendyear,
                            "prodmake" => $prodmake,
                            "prodmodel" => $prodmodel,
                            "irregular_value" => $irregular_value,
                            "generalize_value" => $generalize_value,
                            );
            $query = "select * from [|PREFIX|]cabsize_translation where prodstartyear = '".$prodstartyear."' and prodendyear = '".$prodendyear."' and prodmake = '".$prodmake."' and prodmodel = '".$prodmodel."' and irregular_value='".$irregular_value."' and generalize_value = '".$generalize_value."' ";
            $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
            $cnt = $GLOBALS["ISC_CLASS_DB"]->CountResult($result);
            if($cnt != 1) {
                $GLOBALS['ISC_CLASS_DB']->InsertQuery("cabsize_translation", $newcabsize);
                FlashMessage(GetLang('CabsizeSavedSuccessfully'), MSG_SUCCESS, 'index.php?ToDo=viewCabsizeSettings');
            }
            else {
                FlashMessage(GetLang('CabsizeAlreadyExists'), MSG_ERROR, 'index.php?ToDo=createCabsizesettings');                
            }
        }
        
        private function editcabsize($MsgDesc = "", $MsgStatus = "") {
            if(isset($_GET['cabId'])) {
                
                if ($MsgDesc != "") {
                    $GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
                }
                
                $cabId = (int)$_GET['cabId'];
                $query = sprintf("select * from [|PREFIX|]cabsize_translation where id='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($cabId));
                $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
                
                if($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) { 
                    $GLOBALS['cabId'] = $row['id'];
                    $GLOBALS['ProdstartyearEdit'] = isc_html_escape($row['prodstartyear']);
                    $GLOBALS['ProdendyearEdit'] = isc_html_escape($row['prodendyear']);
                    $GLOBALS['ProdmakeEdit'] = isc_html_escape($row['prodmake']);
                    $GLOBALS['ProdmodelEdit'] = isc_html_escape($row['prodmodel']);
                    $GLOBALS['IrregularEdit'] = isc_html_escape($row['irregular_value']);
                    $GLOBALS['GeneralizeEdit'] = isc_html_escape($row['generalize_value']);
                    $GLOBALS['FormAction'] = "SaveEditedCabsizesettings"; 

                    $GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("cabsize.edit.form");
                    $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
                }
                else {
                    ob_end_clean();
                    header("Location: index.php?ToDo=viewCabsizeSettings");
                    die();
                }

            }
            else {
                ob_end_clean();
                header("Location: index.php?ToDo=viewCabsizeSettings");
                die();
            }                
        }
        
        private function SaveEditedCabsize()
        {                                              
            if(isset($_POST['irregular'])) {
                $cabId = (int)$_POST['cabId'];
                $prodstartyear = $_POST['prodstartyear'];
                $prodendyear = $_POST['prodendyear'];
                $prodmake = $_POST['prodmake'];
                $prodmodel = $_POST['prodmodel'];
                $irregular = $_POST['irregular'];
                $generalize = $_POST['generalize'];
                
               /* $query = sprintf("select * from [|PREFIX|]bedsize_translation where id='%d'", $bedId);
                $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
                $row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result);  */
                $updatedCabsize = array(
                    "generalize_value" => $generalize
                );
                $GLOBALS['ISC_CLASS_DB']->UpdateQuery("cabsize_translation", $updatedCabsize, "id='".$GLOBALS['ISC_CLASS_DB']->Quote($cabId)."'");
                mysql_query("UPDATE isc_import_variations set cabsize_generalname = '".$generalize."' where prodstartyear='".$prodstartyear."' and prodendyear = '".$prodendyear."' and prodmake = '".$prodmake."' and prodmodel = '".$prodmodel."' and VQcabsize = '".$irregular."' ");
                if($GLOBALS["ISC_CLASS_DB"]->GetErrorMsg() == "") {
                    FlashMessage(GetLang('CabsizeSavedSuccessfully'), MSG_SUCCESS,'index.php?ToDo=viewCabsizeSettings');
                }
                else {
                    FlashMessage(sprintf(GetLang('UpdateCabsizeError'), $GLOBALS["ISC_CLASS_DB"]->GetErrorMsg()), MSG_ERROR,'index.php?ToDo=viewCabsizeSettings');
                }                
                
            }
            else {
                ob_end_clean();
                header("Location: index.php?ToDo=viewCabsizeSettings");
                die();
            }
        }
        
        private function deleteCabsize() {
            $cabId = $_GET['cabId'];
            $GLOBALS['ISC_CLASS_DB']->DeleteQuery('cabsize_translation', "WHERE id = '$cabId'");
            if($GLOBALS["ISC_CLASS_DB"]->GetErrorMsg() == "") {
                FlashMessage(GetLang('CabsizeDeletedSuccessfully'), MSG_SUCCESS,'index.php?ToDo=viewCabsizeSettings');
            }
            else {
                FlashMessage(sprintf(GetLang('UpdateCabsizeError'), $GLOBALS["ISC_CLASS_DB"]->GetErrorMsg()), MSG_ERROR,'index.php?ToDo=viewCabsizeSettings');
            }                
        }
        
        private function ManageCabsizeGrid(&$numCab) {
            // Show a list of news in a table
            $page = 0;
            $start = 0;
            $numCab = 0;
            $numPages = 0;
            $GLOBALS['CabsizeGrid'] = ''; 
            $GLOBALS['Nav'] = "";
            $max = 0;
            $searchURL = '';

            if (isset($_GET['searchQuery'])) {
                $query = $_GET['searchQuery'];
                $GLOBALS['Query'] = $query;
                $searchURL .'searchQuery='.urlencode($query);
            } else {
                $query = "";
                $GLOBALS['Query'] = "";
            }

            if (isset($_GET['sortOrder']) && $_GET['sortOrder'] == 'desc') {
                $sortOrder = 'desc';
            } else {
                $sortOrder = "asc";
            }

            $sortLinks = array(
                "Irregularvalue" => "c.irregular_value",
                "Generalizevalue" => "c.generalize_value",
            );

            if (isset($_GET['sortField']) && in_array($_GET['sortField'], $sortLinks)) {
                $sortField = $_GET['sortField'];
                SaveDefaultSortField("ManageCabsize", $_REQUEST['sortField'], $sortOrder);
            }
            else {
                list($sortField, $sortOrder) = GetDefaultSortField("ManageCabsize", "c.irregular_value", $sortOrder);
            }

            if (isset($_GET['page'])) {
                $page = (int)$_GET['page'];
            }
            else {
                $page = 1;
            }

            $sortURL = sprintf("&sortField=%s&sortOrder=%s", $sortField, $sortOrder);
            $GLOBALS['SortURL'] = $sortURL;

            // Limit the number of brands returned
            if ($page == 1) {
                $start = 1;
            }
            else {
                $start = ($page * ISC_CABSIZE_PER_PAGE) - (ISC_CABSIZE_PER_PAGE-1);
            }

            $start = $start-1;

            // Get the results for the query
            $cabsizeResult = $this->_GetCabsizeList($start, $sortField, $sortOrder, $numCab);
            $numPages = ceil($numCab / ISC_CABSIZE_PER_PAGE);

            // Workout the paging navigation
            if($numCab > ISC_CABSIZE_PER_PAGE) {
                $GLOBALS['Nav'] = sprintf("(%s %d of %d) &nbsp;&nbsp;&nbsp;", GetLang('Page'), $page, $numPages);

                $GLOBALS['Nav'] .= BuildPagination($numCab, ISC_CABSIZE_PER_PAGE, $page, sprintf("index.php?ToDo=viewCabsizeSettings%s", $sortURL));
            }
            else {
                $GLOBALS['Nav'] = "";
            }

            $GLOBALS['SearchQuery'] = $query;
            $GLOBALS['SortField'] = $sortField;
            $GLOBALS['SortOrder'] = $sortOrder;

            BuildAdminSortingLinks($sortLinks, "index.php?ToDo=viewCabsizeSettings&amp;".$searchURL."&amp;page=".$page, $sortField, $sortOrder);


            // Workout the maximum size of the array
            $max = $start + ISC_CABSIZE_PER_PAGE;

            if ($max > count($cabsizeResult)) {
                $max = count($cabsizeResult);
            }

            if($numCab > 0) {
            while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($cabsizeResult)) {
                $GLOBALS['Prodstartyear'] = isc_html_escape($row['prodstartyear']);
                $GLOBALS['Prodendyear'] = isc_html_escape($row['prodendyear']);
                $GLOBALS['Prodmake'] = isc_html_escape($row['prodmake']);
                $GLOBALS['Prodmodel'] = isc_html_escape($row['prodmodel']);
                $GLOBALS['Irregularvalue'] = isc_html_escape($row['irregular_value']);
                $GLOBALS['Generalizevalue'] = isc_html_escape($row['generalize_value']);
                $GLOBALS['EditCabsizeLink'] = sprintf("<a title='%s' class='Action' href='index.php?ToDo=editCabsizesettings&amp;cabId=%d'>%s</a>", GetLang('Edit'), $row['id'], GetLang('Edit'));
                $GLOBALS['DeleteCabsizeLink'] = sprintf("<a title='%s' class='Action' href='#' onclick=deleteCabid(%d)>%s</a>", GetLang('Delete'), $row['id'], GetLang('Delete'));                
                
                $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("cabsize.manage.row");
                $GLOBALS['CabsizeGrid'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true); 
            }
            $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("cabsize.manage.grid");
            return $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
            }  
        }
        
        public function _GetCabsizeList($Start, $SortField, $SortOrder, &$NumResults)
        {
            // Return an array containing details about bedsize.

            // PostgreSQL is case sensitive for likes, so all matches are done in lower case
            $query = "SELECT * FROM [|PREFIX|]cabsize_translation c";

            $countQuery = "SELECT COUNT(*) FROM [|PREFIX|]cabsize_translation c";

            $queryWhere = ' WHERE 1=1 ';

            $query .= $queryWhere;
            $countQuery .= $queryWhere;

            $result = $GLOBALS['ISC_CLASS_DB']->Query($countQuery);
            $NumResults = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);

            if($NumResults > 0) {
                $query .= " ORDER BY ".$SortField." ".$SortOrder;

                // Add the limit
                $query .= $GLOBALS["ISC_CLASS_DB"]->AddLimit($Start, ISC_CABSIZE_PER_PAGE);
                $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
                return $result;
            }
            else {
                return false;
            }
        }
        /* Baskaran Added ends*/
	}
?>