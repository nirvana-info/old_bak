<?php
/**
 * This file deals with the white labeling of CongoWorld Shopping Cart.
 */

/**
 * The name of the product to be shown in several different places
 * in the control panel.
 */
$GLOBALS['ISC_CFG']['ProductName'] = 'CongoWorld Market Place';

/**
 * This variable is used in the page title of the pages in the control panel.
 *
 * Use %%EDITION%% to show the current edition of the product.
 */
$GLOBALS['ISC_CFG']['ControlPanelTitle'] = "CongoWorld Market Place Control Panel (%%EDITION%% Edition)";

/**
 * This is the text that is used at the bottom of every page in the control
 * panel. You are free to modify this text and even leave it blank.
 *
 * Use %%EDITION%% to show the current edition of the product that is being run.
 *
 * Used in: /admin/templates/pagefooter.tpl
 *     and: /admin/templates/pagefooter.install.tpl
 */
$GLOBALS['ISC_CFG']['AdminCopyright'] = 'Copyright '.date('Y').'&copy; LOF, Inc.';

/**
 * This variable is used in the template as %%GLOBAL_AdminLogo%%
 * It points to the logo used in the control panel. It contains the entire <img>
 * HTML tag so the width, height and any other attribute can be changed.
 *
 * The default location is: /admin/images/logo.gif but the path below is a
 * a relative path to that location, i.e. images/logo.gif
 *
 * Used in: /admin/templates/pageheader.tpl
 *     and: /admin/templates/pageheader.install.tpl
 */
$GLOBALS['ISC_CFG']['AdminLogo'] = '<img id="logo" src="images/logo.gif" border="0" />';

/**
 * The variable below allows you to change the text that's shown on in the popup shown when you login
 * to the control panel for the first time.
 */
$GLOBALS['ISC_LANG']['HomePopupIntroHelp'] = "Before you can begin accepting orders you first need to configure your store. The &quot;<em>Getting Started with CongoWorld Market Place</em>&quot; section on this page shows the simple steps you need to take to make sure your store is properly configured before you start accepting orders.";

/**
 * The variable below allows you to change the title that's shown for the "Getting Started" wizard
 * on the home page fo the control panel.
 */
$GLOBALS['ISC_LANG']['GettingStartedTitle'] = "Getting Started with CongoWorld Market Place";

/**
 * This option disables the "popular help articles" section on the home page of the control panel.
 *
 * Change the value below to "false" to not load the content in at all.
 */
$GLOBALS['ISC_CFG']['LoadPopularHelpArticles'] = true;

/**
 * The URL of the RSS feed to fetch for the "Popular Help Articles" feed.
 */
$GLOBALS['ISC_CFG']['HelpRSS'] = 'http://viewkb.com/rss.php?c=86&t=popular';

/**
 * The language variables used by the list of popular help articles.
 */
$GLOBALS['ISC_LANG']['PopularHelpArticles'] = "Top Help Articles";
$GLOBALS['ISC_LANG']['ViewKnowledgeBase'] = 'View Knowledge Base';

/**
 * The link that the "View Knowledge Base" button should point to
 */
$GLOBALS['ISC_CFG']['ViewKnowledgeBaseLink'] = 'javascript:LaunchHelp();';

/**
 * The link that the "Search Knowledge Base" form should post to. %query% should be used as the placeholder
 * for what the user enters in the search box. Leave empty to disable searching.
 */
$GLOBALS['ISC_CFG']['SearchKnowledgeBaseUrl'] = 'http://www.viewkb.com/search.php?searchOverride=86&tplHeader='.rawurlencode(GetConfig('ProductName')).'&q=%query%';

/**
 * The setting below will hide the store license key setting on the Settings > Store Settings page.
 * If disabled, the license key will manually need to be updated from the config/config.php file.
 */
$GLOBALS['ISC_CFG']['DisableLicenseKeyField'] = false;

/**
 * The setting below will hide the database details on the Settings > Store Settings page.
 * If disabled, these details will only be visible in the config/config.php file.
 */
$GLOBALS['ISC_CFG']['DisableDatabaseDetailFields'] = false;

/**
 * The setting below will hide the store URL field on the Settings > Store Settings page.
 * If disabled, the store URL will manually need to be updated from the config/config.php file.
 */
$GLOBALS['ISC_CFG']['DisableStoreUrlField'] = false;

/**
 * The setting below will hide the product images and product downloads fields on the Settings > Store Settings page.
 * If disabled, the values of the fields will need to be manually updated from the config/config.php file.
 */
$GLOBALS['ISC_CFG']['DisablePathFields'] = false;

/**
 * The setting below will disable the 'Logging' tab on the Settings > Store Settings page.
 * If disabled, the values on this tab will need to be manually updated from the config/config.php file.
 */
$GLOBALS['ISC_CFG']['DisableLoggingSettingsTab'] = false;

/**
 * The setting below will disable the 'HTTP Proxy' settings on the Settings > Store Settings page.
 * If disabled, the values on this tab will need to be manually updated from the config/config.php file.
 */
$GLOBALS['ISC_CFG']['DisableProxyFields'] = false;

/**
 * The setting below will disable the 'System Information' page under the Tools menu. It will
 * also disable the 'view full system information' page that shows the PHP Info.
 */
$GLOBALS['ISC_CFG']['DisableSystemInfo'] = false;

/**
 * The setting below will disable the backup settings on the Settings > Store Settings page.
 * If disabled, the values on this tab will need to be manually updated from the config/config.php file.
 */
$GLOBALS['ISC_CFG']['DisableBackupSettings'] = false;

/**
 * The setting below will disable the store importer and exporter functionality on the Tools
 * menu.
 */
$GLOBALS['ISC_CFG']['DisableStoreImporters'] = false;

/**
 * The setting below allows certain types of store log entries to be hidden from store administrators.
 * Enter a comma separated list of the types of entries that should not be shown.
 * Example: php,sql would hide all PHP related errors and all database related errors.
 * Allowed values: general,payment,shipping,notification,ssnx,sql,php
 */
$GLOBALS['ISC_CFG']['HiddenStoreLogTypes'] = '';

/**
 * The two messages below are shown when an invalid license key or an expired license key is entered.
 */
$GLOBALS['ISC_LANG']['BadLKHInv'] = "Your license key is invalid. Please contact CongoWorld for a new key.";
$GLOBALS['ISC_LANG']['BadLKHExp'] = "Your license key expired on the %s. Please contact CongoWorld for a new key.";

/**
 * The messages below are shown when a user or product limit is reached based on the entered license key within the store.
 */
$GLOBALS['ISC_LANG']['ReachedUserLimitMsg'] = "You cannot add any more users to your store because you have reached your limit of %s users. To add additional users, you need to <a href='http://www.CongoWorld.com/shoppingcart/' target='_blank'>upgrade</a>.";
$GLOBALS['ISC_LANG']['ReachedProductLimitMsg'] = "You cannot add any more products to your store because you have reached your limit of %s products. To add additional products, you need to <a href='http://www.CongoWorld.com/shoppingcart/' target='_blank'>upgrade</a>.";

/**
 * The variable below allows you to disable the CongoWorld SendStudio integration.
 */
$GLOBALS['ISC_CFG']['DisableSendStudioIntegration'] = false;

/**
 * All of the language variables below are those used on the CongoWorld Email Marketer Integration page.
 */
$GLOBALS['ISC_LANG']['MailSettings'] = 'Email Marketer Settings';
$GLOBALS['ISC_LANG']['MailIntegration'] = 'CongoWorld Email Marketer Integration';
$GLOBALS['ISC_LANG']['APIDetails'] = "CongoWorld Email Marketer API Details";
$GLOBALS['ISC_LANG']['MailXMLPath'] = 'Email Marketer XML Path';
$GLOBALS['ISC_LANG']['MailXMLPathHelp'] = "The path to CongoWorld Email Marketer\'s xml.php file which allows CongoWorld Shopping Cart to \'talk\' to CongoWorld Email Marketer via the API. See the help tips above for details on where to find this.";
$GLOBALS['ISC_LANG']['MailXMLToken'] = 'EMail Marketer XML Token';
$GLOBALS['ISC_LANG']['MailUsername'] = 'Email Marketer Username';
$GLOBALS['ISC_LANG']['MailAPIInitFailed'] = 'The CongoWorld Email Marketer XML token and/or username are incorrect. Double check them and try again.';
$GLOBALS['ISC_LANG']['MailAPIInitSuccess'] = 'The CongoWorld Email Marketer API has been enabled. Click the \'CongoWorld Email Marketer Integration\' tab below to configure email preferences for your store.';
$GLOBALS['ISC_LANG']['MailAPIIntegrationSuccess'] = 'Your CongoWorld Email Marketer integration preferences have been updated.';
$GLOBALS['ISC_LANG']['CaptureNewsletterSubscribers'] = 'Capture Newsletter Subscribers';
$GLOBALS['ISC_LANG']['YesCaptureNewsletterSubscribers'] = 'Yes, use CongoWorld Email Marketer to capture newsletter subscribers from my store';
$GLOBALS['ISC_LANG']['MailUsernameHelp'] = 'The username you use when logging into the CongoWorld Email Marketer control panel. This should be the same username for the account where you copied the XML token from.';
$GLOBALS['ISC_LANG']['MailXMLTokenHelp'] = "The XML token assigned to your CongoWorld Email Marketer account. See the help tips above for details on where to find this.";
$GLOBALS['ISC_LANG']['MailSettingsIntro'] = '<div class=\'AppNotice\'><img src=\'images/info.gif\' style=\'float:left; margin-right:5px; margin-bottom:30px\' /> <a style=\'color:#005FA3; font-weight:bold;\' href=http://www.CongoWorld.com/emailmarketer target=_blank>CongoWorld Email Marketer</a> is email marketing software that you can use to send newsletters, special offers and promotions via email. When integrated into your store, CongoWorld Email Marketer can automatically capture the details of people who signup for your newsletter. It can also capture customer details as they\'re placing an order, such as their name, email address, order total, country, etc. You can then send targeted emails to your customers and even follow up automatically with time-sensitive autoresponder emails which you can create and schedule in CongoWorld Email Marketer.</div><br />To enable CongoWorld Email Marketer integration in your store you need to follow a few simple steps, which are shown below:<ul><li>Purchase a copy of CongoWorld Email Marketer and install it.</li><li>Login to CongoWorld Email Marketer and click on the "User Accounts" link at the top of the page</li><li>Click "Edit" next to your account and go to the "User Permissions" tab</li><li>Tick the "Yes, allow this user to use the XML API" checkbox to enable XML API access for your account</li><li>Copy the "XML path", "XML token" values into their respective fields below</li><li>Enter the username that you use to login to your copy of CongoWorld Email Marketer in the "Username" field below</li><li>If you don\'t see the XML API details in your copy of CongoWorld Email Marketer then you need to upgrade to the latest version</li><li>Click the "Save" button in CongoWorld Email Marketer to save your account preferences</li><li>Click the "Save" button below and you will then be able to configure your email preferences</li></ul><em>Please note: <strong>You must be running CongoWorld Email Marketer 5.0 or above to integrate into your store.</strong> To check which version of CongoWorld Email Marketer you\'re running, login to your copy of CongoWorld Email Marketer, click the Tools menu and choose the System Information option. If you don\'t have this tab in your version then you need to upgrade before you can integrate CongoWorld Email Marketer into your store.</em>';
$GLOBALS['ISC_LANG']['MailSettingsIntroDone'] = 'Update your CongoWorld Email Marketer settings and integration preferences below.';
$GLOBALS['ISC_LANG']['InfoTipSendStudio'] = "For more help relating to integrating CongoWorld Email Marketer into your store, please see <a href='javascript:void(0)' onclick='LaunchHelpCategory(108);'>this section</a> of the help guide.";
$GLOBALS['ISC_LANG']['CaptureNewsletterSubscribersHelp'] = 'Would you like CongoWorld Email Marketer to automatically capture the details of people who subscribe to your newsletter from both the form on your web site and during the checkout process?<br /><br />If yes, tick this box and choose a mailing list where their email address will be saved to. Optionally, you can also choose a custom field where their first name should be saved to.';
$GLOBALS['ISC_LANG']['YesCaptureNewCustomers'] = 'Yes, use CongoWorld Email Marketer to capture new customer details from my store';
$GLOBALS['ISC_LANG']['CaptureNewsletterOrdersHelp'] = 'Would you like CongoWorld Email Marketer to automatically capture the details of people who place an order from your web site? If yes, tick this box and choose a mailing list where their email address will be added to. Optionally, you can also store their order details by choosing custom fields below.';
$GLOBALS['ISC_LANG']['EnterMailUsername'] = 'Please enter your CongoWorld Email Marketer account username.';
$GLOBALS['ISC_LANG']['ShowProductUpdateOptions'] = 'Show Product Update Options';
$GLOBALS['ISC_LANG']['YesShowProductUpdateOptions'] = 'Yes, use CongoWorld Email Marketer to let customers receive product updates via email';
$GLOBALS['ISC_LANG']['ShowProductUpdateOptionssHelp'] = 'Would you like customers to be able to sign up to receive product updates after they\\\'ve purchased from you? If yes, tick this box and you can choose which CongoWorld Email Marketer mailing list they should be added to.';
$GLOBALS['ISC_LANG']['TheNameOfTheProductHelp'] = "If you choose this option, the customer will be shown a list of products in their order along with a checkbox next to each product after their order is placed. For each checkbox they tick, they will be added to a separate product-specific mailing list. You need to create the mailing lists in CongoWorld Email Marketer first.<br /><br />For example, if your customer has ordered an iPod Nano and an iPhone, and they tick the boxes to receive updates to both products, they will be added to two separate mailing lists - one for the iPod Nano and one for the iPhone. In this case you should create two lists in CongoWorld Email Marketer - one called &quot;iPod Nano&quot; and one called &quot;iPhone&quot;. The names of the lists must match the exact name of the product.";
$GLOBALS['ISC_LANG']['TheCategoryOfTheProductHelp'] = "If you choose this option, the customer will be shown a list of products in their order along with a checkbox next to each product after their order is placed. For each checkbox they tick, they will be added to a separate category-specific mailing list. You will need to create the mailing lists in CongoWorld Email Marketer first.<br /><br />For example, if your customer has ordered an iPod Nano (whose category is MP3 Player) and an iPhone (whose category is Phones), and they tick the boxes to receive updates to both products, they will be added to two separate mailing lists - one for MP3 players and one for phones. In this case you should create two lists in CongoWorld Email Marketer - one called &quot;MP3 Players&quot; and one called &quot;Phones&quot;. The names of the lists must match the exact name of the category.";
$GLOBALS['ISC_LANG']['TheBrandOfTheProductHelp'] = "If you choose this option, the customer will be shown a list of products in their order along with a checkbox next to each product after their order is placed. For each checkbox they tick, they will be added to a separate brand-specific mailing list. You need to create the mailing lists in CongoWorld Email Marketer first.<br /><br />For example, if your customer has ordered an Apple iPod Nano and a Sony Cybershot digital camera, and they tick the boxes to receive updates to both products, they will be added to two separate mailing lists - one for Apple products and one for Sony products. In this case you should create two lists in CongoWorld Email Marketer - one called &quot;Apple&quot; and one called &quot;Sony&quot;. The names of the lists must match the exact brand names used in your store.";
$GLOBALS['ISC_CFG']['MailLogo'] = 'images/iem_logo.gif';

/**
 * The variable below allows you to disable the CongoWorld Knowledge Manager integration.
 */
$GLOBALS['ISC_CFG']['DisableKnowledgeManagerIntegration'] = false;

/**
 * All of the language variables below are used for the CongoWorld Knowledge Manager integration.
 */
$GLOBALS['ISC_LANG']['KBSettings'] = 'Knowledge Manager';
$GLOBALS['ISC_LANG']['KBSettingsHeader'] = "CongoWorld Knowledge Manager";
$GLOBALS['ISC_LANG']['KBSettingsIntroDone'] = 'Update your CongoWorld Knowledge Manager settings and integration preferences below.';
$GLOBALS['ISC_LANG']['KBSettingsIntro'] = '<div class=\'AppNotice\'><img src=\'images/info.gif\' style=\'float:left; margin-right:5px; margin-bottom:30px\' /> <a style=\'color:#005FA3; font-weight:bold;\' href=http://www.CongoWorld.com/knowledgemanager target=_blank>CongoWorld Knowledge Manager</a> is knowledge base &amp; FAQ software that you can use to provide your customers with answers to common questions about orders, shipping, returns, etc. Most customers want to learn about your store\'s policies, etc before they buy, and a knowledge base is a great way to give them answers to their questions. When integrated into your store, CongoWorld Knowledge Manager will look the same as your store and will show up as a link on your store\'s navigation menu.</div>To enable CongoWorld Knowledge Manager integration in your store you need to follow a few simple steps, which are shown below:<ul><li>Purchase a copy of CongoWorld Knowledge Manager and install it.</li><li>Login to CongoWorld Knowledge Manager and click on the "Settings" link at the top of the page</li><li>Under the "Site Settings" section, change the template to "CongoWorldShoppingCart"</li><li>Paste this into the "Template Header URL" field: <strong>%s/top.php</strong></li><li>Paste this into the "Template Footer URL" field: <strong>%s/bottom.php</strong></li><li>Click the "Save" button in CongoWorld Knowledge Manager to update your settings</li><li>Click the "Website Content" tab above and choose the "Create a Web Page" link</li><li>Type a title for the page (such as "FAQ" or "Help") into the "Page Title" field</li><li>Choose the "Link to another website or document" page type</li><li>Enter the URL of where CongoWorld Knowledge Manager is installed (such as http://www.yoursite.com/kb) in the "Link" field</li><li>Click the "Save" button</li><li>View your store and when you click on the "FAQ" or "Help" page which you just created, your knowledge base will be shown</li><li>Optionally you can also integrate CongoWorld Knowledge Manager&#39;s <em>Active Response System</em> into your store by filling out the form below</li></ul>';
$GLOBALS['ISC_LANG']['KBDetails'] = 'Knowledge Manager Integration Details';
$GLOBALS['ISC_LANG']['KBPath'] = 'Knowledge Manager Path';
$GLOBALS['ISC_LANG']['KBPathHelp'] = 'The full URL to where your copy of CongoWorld Knowledge Manager is installed, such as http://www.yoursite.com/knowledgemanager. Do not include a trailing slash or index.php on the end of the URL.';
$GLOBALS['ISC_LANG']['KBContactFormIntegration'] = 'Contact Form Integration';
$GLOBALS['ISC_LANG']['YesKBContactFormIntegration'] = 'Yes, integrate CongoWorld Knowledge Manager&#39;s <em>Active Response System</em> into my contact form';
$GLOBALS['ISC_LANG']['KBContactFormIntegrationHelp'] = 'Do you want to integrate CongoWorld Knowledge Manager\\\'s <em>Active Response System</em> into any pages in your store that are setup as a contact form? If yes, tick this box and you can choose which page(s) to integrate it into.';
$GLOBALS['ISC_LANG']['IntegrateActiveResponseHelp'] = "Which web pages in your store do you want to integrate CongoWorld Knowledge Manager\'s <em>Active Response System</em> into? The pages listed here are the ones you\'ve created whose page type is \'<em>Allow people to send questions/comments via a contact form</em>\'.<br /><br />You can create another web page by choosing the \'Create a Web Page\' option from the Website Content tab above.";
$GLOBALS['ISC_LANG']['NoContactPagesForActiveKB'] = "Before you can integrate CongoWorld Knowledge Manager's Active Response System you need to create at least one contact page. To create a contact page, click the 'Create a Web Page' link under the 'Website Content' tab above and choose the contact page option.";
$GLOBALS['ISC_LANG']['EnterActiveKBPath'] = 'Please enter the full URL to your copy of CongoWorld Knowledge Manager, such as http://www.yoursite.com/knowledgemanager';
$GLOBALS['ISC_LANG']['AKBSettingsSavedSuccessfully'] = 'Your CongoWorld Knowledge Manager settings have been saved successfully.';
$GLOBALS['ISC_LANG']['AKBSettingsNotSaved'] = 'Your CongoWorld Knowledge Manager settings couldn&#39;t be saved. Make sure your config/config.php file is writable and try again.';
$GLOBALS['ISC_LANG']['KBWhatIsActiveResponse'] = "What is CongoWorld Knowledge Manager's Active Response System?";
$GLOBALS['ISC_CFG']['KBLogo'] = 'images/ikm_logo.gif';

/**
 * This option disables the ability to download addons via the control panel.
 * When disabled, addons can still be run, just not downloaded.
 */
$GLOBALS['ISC_CFG']['DisableAddonDownloading'] = false;

/**
 * The XML file where a list of available addons for download is stored.
 */

$GLOBALS['ISC_CFG']['AddonXMLFile'] = 'http://www.CongoWorld.com/shoppingcart/_addonlist.php';

/**
 * The file which validates addon license keys
 */

$GLOBALS['ISC_CFG']["AddonLicenseURL"] = "http://www.CongoWorld.com/shoppingcart/_addonlicencecheck.php";

/**
 * The file which streams the addons zip file back
 */

$GLOBALS['ISC_CFG']["AddonStreamURL"] = "http://www.CongoWorld.com/shoppingcart/_addonstream.php";

/**
 * The following variables control the URL and paths for the template
 * downloading from the control panel. This is already private labelled and will
 * usually never need to be changed
 */

$GLOBALS['ISC_CFG']['TemplateURL'] = "http://www.buildertemplates.com/isc/templates/listTemplates.php?version=%%VERSION%%";
$GLOBALS['ISC_CFG']['TemplateInfoURL'] = "http://www.buildertemplates.com/isc/templates/getInfo.php?template=%%TEMPLATE%%&version=%%VERSION%%";
$GLOBALS['ISC_CFG']['TemplateVerifyURL'] = "http://www.buildertemplates.com/isc/templates/verifyDownload.php?template=%%TEMPLATE%%&key=%%KEY%%&host=%%HOST%%&version=%%VERSION%%";
$GLOBALS['ISC_CFG']['TemplateStreamURL'] = "http://www.buildertemplates.com/isc/templates/streamZip.php?template=%%TEMPLATE%%&key=%%KEY%%&host=%%HOST%%&version=%%VERSION%%";
$GLOBALS['ISC_CFG']['TemplateVersionURL'] = "http://www.buildertemplates.com/isc/templates/versionCheck.php?template=%%TEMPLATE%%&version=%%VERSION%%";
$GLOBALS['ISC_CFG']["TemplatesOrderCustomURL"] = "http://www.CongoWorld.com/shoppingcart/custom_design.php";

/**
 * TemplateMarkup
 * If you want a markup on the template prices increase this value.
 * 1.00 = 100% (normal price)
 * E.g. to make it 125% change this to 1.25
 * Notes: - Templates can not be offered at a reduced cost. If the number is less
 *          than 1.00 it is reset to 1.00.
 *        - If you change this, change the value of AllowTemplatePurchase below
 *          to 0 (zero) otherwise the user will see the original price on our
 *          website.
 */
$GLOBALS['ISC_CFG']['TemplateMarkup'] = 1.00;

/**
 * AllowTemplatePurchase
 * If you don't want the purchase to go through the CongoWorld website change
 * this value to 0 (zero).
 * If you change the value of TemplateMarkup, change this setting also.
 * If this setting is set to zero, the user will be told that the paid templates
 * are not avaialbe for direct down but instead to contact their System
 * Administrator to purchase the template. You then arrange payment and purchase
 * the template yourself from our website.
 */
$GLOBALS['ISC_CFG']['AllowTemplatePurchase'] = 0;

/**
 * DisableTemplateDownloading
 * If you want to just outright remove all options, links, buttons and text related
 * to downloading new templates, set this value to 1 (one).
 */
$GLOBALS['ISC_CFG']['DisableTemplateDownloading'] = 0;

/**
 * The setting below allows the "Product Edition:" row on the Tools > System Information
 * page to be disabled.
 */
$GLOBALS['ISC_CFG']['DisableSystemInfoEdition'] = false;

/**
 * The variable below controls the URL "Upgrade" link on the  Tools > System Information
 */
$GLOBALS['ISC_CFG']['SystemInfoEditionUpgradeLink'] = "http://www.CongoWorld.com/shoppingcart/";

/**
 * The setting below allows the version check box on the home page of the control panel
 * to be disabled.
 */
$GLOBALS['ISC_CFG']['DisableVersionCheck'] = false;

/**
 * The variables below control the text that is shown in the version check box when a
 * new version is available or the store is already running the latest version.
 */
$GLOBALS['ISC_LANG']['NewVersionAvailable'] = "CongoWorld Market Place <span class='LatestVersionNumber'>%s</span> is now available. (Hide this and remind me again <a href='#' rel='1' class='HideLink'>tomorrow</a>, <a href='#' rel='7' class='HideLink'>in a week</a> or <a href='#' class='HideLink'>not until next version</a>)";

/**
 * The variables below are used for the Store Importers / Store Exporters.
 */
$GLOBALS['ISC_LANG']['ConverterDeleteStoreMsg'] = "Delete everything in my CongoWorld Shopping Cart store first";
$GLOBALS['ISC_LANG']['ConverterDeleteStoreHelp'] = "If you tick this option all orders, customers, products, etc (except your current admin user account) will be deleted from your CongoWorld Shopping Cart store *before* the import wizard starts.";
$GLOBALS['ISC_LANG']['ConverterConfirmDeleteStore'] = "Are you sure you want to delete everything from your CongoWorld Shopping Cart store before importing? Click OK to proceed with the import or Cancel if you\'ve changed your mind.";
$GLOBALS['ISC_LANG']['ConverterDeletingStore'] = "Removing content from your CongoWorld Shopping Cart store...";
$GLOBALS['ISC_LANG']['DeletingCurrentStoreStatusTitle'] = "Removing CongoWorld Shopping Cart Content";
$GLOBALS['ISC_LANG']['DeletingCurrentStoreStatusDesc'] = "The content from your CongoWorld Shopping Cart store is currently being removed...";

/**
 * The setting below allows the 'Help' link in the control panel top menu
 * to be removed.
 */
$GLOBALS['ISC_CFG']['HideHelpLink'] = false;

/**
 * The setting below allows you to hide the "Learn more about using CongoWorld Market Place Shopping Cart Section" on the dashboard.
 */
$GLOBALS['ISC_CFG']['HideLearnMoreAboutUsing'] = false;

/**
 * The title for the "Learn more about using..." section if it is to be shown.
 */
$GLOBALS['ISC_LANG']['LearnMoreAboutUsing'] = 'Learn more about using CongoWorld Market Place';

/**
 * Settings for the first link to be shown in the "Learn more about using.." section.
 */
$GLOBALS['ISC_CFG']['LearnMoreAboutUsing1Class'] = 'DashboardLearnWatchVideo';
$GLOBALS['ISC_CFG']['LearnMoreAboutUsing1Title'] = 'Watch the getting started videos';
$GLOBALS['ISC_CFG']['LearnMoreAboutUsing1Url'] = '#';

/**
 * Settings for the second link to be shown in the "Learn more about using.." section.
 */
$GLOBALS['ISC_CFG']['LearnMoreAboutUsing2Class'] = 'DashboardLearnGuide';
$GLOBALS['ISC_CFG']['LearnMoreAboutUsing2Title'] = 'Read our getting started guide';
$GLOBALS['ISC_CFG']['LearnMoreAboutUsing2Url'] = '#';

/**
 * Trial expiry message shown on the dashboard if this is a trial/evaluation copy.
 */
$GLOBALS['ISC_LANG']['TrialExpiresInXDays'] = 'Your free trial copy of CongoWorld Market Place expires in %s days. <a href="http://www.CongoWorld.com/shoppingcart/pricing.php" target="_blank">Click here for information on upgrading.</a>';

?>
