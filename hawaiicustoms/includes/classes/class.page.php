<?php

	if (!defined('ISC_BASE_PATH')) {
		die();
	}

	require_once(ISC_BASE_PATH.'/lib/xml.php');

	class ISC_PAGE
	{

		private $_pageid = 0;
		private $_pagetype = 0;
		private $_pagetitle = "";
		private $_pagefeed = "";
		private $_pagecontent = "";
		private $_pagekeywords = "";
		private $_pagedesc = "";
		private $_pagelayoutfile = "";
		private $_pageparentlist = "";
		private $_pagerow = null;

		public function __construct($PageId=0, $IsHomePage=false, $PageRow=null)
		{
			if(!defined("ISC_ADMIN_CP")) {
				$this->_SetPageData($PageId, $IsHomePage, $PageRow);
			}
		}

		public function LoadPredefinedPages($content)
		{
			if(is_numeric(isc_strpos($content, "%%Syndicate%%"))) {
				if (!isset($GLOBALS['syndicateText'])) {
					$GLOBALS['syndicateText'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetPanelContent("Syndicate");
				}
				$content = str_replace("%%Syndicate%%", $GLOBALS['syndicateText'], $content);
			}
			return $content;
		}

		/**
		*	Load up the details for the page to be displayed. If $IsHomePage is true
		*	then we're loading a page to display instead of the home page.
		*/
		public function _SetPageData($PageId=0, $IsHomePage=false, $PageRow=null)
		{
			if(!$IsHomePage) {
				if($PageId == 0) {

				//blessen
					if (count($GLOBALS['PathInfo']) > 0 ){
						if (isset ($GLOBALS['PathInfo'][1])) {
							$_REQUEST['pageid'] = $GLOBALS['PathInfo'][1];
						}
						else
						{
							$_REQUEST['pageid'] = $GLOBALS['PathInfo'][0];
						}

						if (!is_numeric($_REQUEST['pageid']))
						{
                        $pagename = $_REQUEST['pageid'];
						$query = "SELECT pageid FROM [|PREFIX|]pages WHERE LOWER(pagename)='".$GLOBALS['ISC_CLASS_DB']->Quote(isc_strtolower($pagename))."' ";
						$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
						$row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result);
						$_REQUEST['pageid']  = $row['pageid'];
						}


					}
					if(isset($_REQUEST['pageid'])) {
						$_REQUEST['page_id'] = $_REQUEST['pageid'];
					}
					if(isset($_REQUEST['page_id'])) {
						$pageid = (int)$_REQUEST['page_id'];
						$query = sprintf("select * from [|PREFIX|]pages where pageid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($pageid));
					}
					else if(isset($GLOBALS['PathInfo'][1])) {
						$page = preg_replace('#\.html$#i', '', $GLOBALS['PathInfo'][1]);
						$page = $GLOBALS['ISC_CLASS_DB']->Quote(MakeURLNormal($page));
						$query = sprintf("select * from [|PREFIX|]pages where pagetitle='%s'", $page);
					}
					else {
						ob_end_clean();
						header("Location: ".GetConfig('ShopPath').'/index.php');
						exit;
					}
				}
				else {
					$query = sprintf("select * from [|PREFIX|]pages where pageid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($PageId));
				}

				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

				if($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					$row['pagecontent'] = $this->LoadPredefinedPages($row['pagecontent']);
					$GLOBALS['ActivePage'] = $row['pageid'];
					$this->_pageid = $row['pageid'];
					$this->_pagetype = $row['pagetype'];
					$this->_pagetitle = $row['pagetitle'];
					$this->_pagefeed = $row['pagefeed'];
					$this->_pagecontent = $row['pagecontent'];
					$this->_pagekeywords = $row['pagekeywords'];
					$this->_pagedesc = $row['pagedesc'];
					$this->_pageparentlist = $row['pageparentlist'];

			//blessen
			$GLOBALS['CategoryTrackingCodeTop'] = isset($row['controlscript']) ? $row['controlscript'] : '';
			$GLOBALS['CategoryTrackingCodeBottom'] = isset($row['trackingscript']) ? $row['trackingscript'] : '';


					$this->_pagerow = &$row;
					if($row['pagelayoutfile'] != '') {
						$File = str_replace(array(".html", ".htm"), "", $row['pagelayoutfile']);
						if(!file_exists(ISC_BASE_PATH."/templates/".GetConfig('template')."/".$row['pagelayoutfile']) || $row['pagelayoutfile'] == 'page.html') {
							if($row['pagevendorid'] > 0) {
								$this->_pagelayoutfile = 'vendor_page';
							}
							else {
								$this->_pagelayoutfile = 'page';
							}
						}
						else {
							$this->_pagelayoutfile = $File;
						}
					}
					else {
						if($row['pagevendorid'] > 0) {
							$this->_pagelayoutfile = 'vendor_page';
						}
						else {
							$this->_pagelayoutfile = 'page';
						}
					}

					// If the customer is not logged in and this page is set to customers only, then show an error message
					$GLOBALS['ISC_CLASS_CUSTOMER'] = GetClass('ISC_CUSTOMER');
					if($row['pagecustomersonly'] == 1 && !$GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerId()) {
						$GLOBALS['ErrorMessage'] = sprintf(GetLang('ForbiddenToAccessPage'), $GLOBALS['ShopPathNormal']);
						$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("error");
						$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
						exit;
					}
				}
			}
			else {
				$row = $PageRow;
				$row['pagecontent'] = $this->LoadPredefinedPages($row['pagecontent']);
				$this->_pageid = $row['pageid'];
				$this->_pagetype = $row['pagetype'];
				$this->_pagetitle = $row['pagetitle'];
				$this->_pagefeed = @$row['pagefeed'];
				$this->_pagecontent = $row['pagecontent'];
				$this->_pagekeywords = $row['pagekeywords'];
				$this->_pagedesc = $row['pagedesc'];
				$this->_pageparentlist = $row['pageparentlist'];
				$this->_pagelayoutfile = $row['pagelayoutfile'];
				$this->_pagerow = &$row;
			}
		}

		public function GetPageId()
		{
			return $this->_pageid;
		}

		public function GetPageTitle()
		{
			return $this->_pagetitle;
		}

		public function GetPageParentList()
		{
			return $this->_pageparentlist;
		}

		public function HandlePage()
		{
			$action = "";
			if(isset($_REQUEST['action'])) {
				$action = isc_strtolower($_REQUEST['action']);
			}

			switch($action) {
				case "sendcontactform": {
					$this->SendContactForm();
					break;
				}
				default: {
					$this->ShowPage();
				}
			}
		}

		public function ShowPage()
		{
			if($this->_pageid > 0) {
				$GLOBALS['PageTitle'] = $this->_pagetitle;

				// What kind of page is it?
				if($this->_pagetype == 0) {
					// It's a normal page
					$GLOBALS['PageContent'] = $this->_pagecontent;
				}
				else if($this->_pagetype == 2) {
					// It's an RSS feed
					$feed = $this->_LoadFeed($this->_pagefeed, 0, 600, md5($this->_pagetitle . $this->_pagefeed));

					if($feed) {
						$GLOBALS['PageContent'] = $feed;
					}
					else {
						$GLOBALS['PageContent'] = sprintf(GetLang('ErrLoadingRSSFeed'), $this->_pagefeed);
					}
				}
				else if($this->_pagetype == 3) {
					// It's a contact form
					$GLOBALS['PageContent'] = $this->_ContactForm();
				}
				else {
					ob_end_clean();
					header("Location:" . $GLOBALS['ShopPath']);
					die();
				}

				if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
					$GLOBALS['PageContent'] = str_replace($GLOBALS['ShopPathNormal'], $GLOBALS['ShopPathSSL'], $GLOBALS['PageContent']);
				}

				$this->_pagelayoutfile = str_ireplace(".html", "", $this->_pagelayoutfile);

				if($this->_pagekeywords != "") {
					$GLOBALS['ISC_CLASS_TEMPLATE']->SetMetaKeywords($this->_pagekeywords);
				}

				if($this->_pagedesc != "") {
					$GLOBALS['ISC_CLASS_TEMPLATE']->SetMetaDescription($this->_pagedesc);
				}

				$GLOBALS['ISC_CLASS_TEMPLATE']->SetPageTitle($this->_pagetitle);
				$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate($this->_pagelayoutfile);
				$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
			}
			else {
				ob_end_clean();
				header("Location: " . $GLOBALS['ShopPath']);
				die();
			}
		}

		/**
		*	Load up an RSS feed, parse its contents and return it.
		*/
		public function _LoadFeed($FeedURL, $NumEntries=0, $CacheTime=0, $FeedId="", $RSSFeedSnippet="", $helpLinks = false)
		{
			$reload = true;
			if($CacheTime > 0) {
				if($FeedId != "") {
					$FeedID = md5($FeedURL);
				}
				$reload = false;
				if(!is_dir(ISC_BASE_PATH."/cache/feeds")) {
					@mkdir(ISC_BASE_PATH."/cache/feeds/", 0777);
				}
				// Using a cached version that hasn't expired yet
				if(file_exists(ISC_BASE_PATH."/cache/feeds/".$FeedId) && filemtime(ISC_BASE_PATH."/cache/feeds/".$FeedId) > time()-$CacheTime) {
					$contents = file_get_contents(ISC_BASE_PATH."/cache/feeds/".$FeedId);
					// Cache was bad, recreate
					if(!$contents) {
						$reload = true;
					}
				}
				else {
					$reload = true;
				}
			}

			if ($reload === true) {
				$contents = PostToRemoteFileAndGetResponse($FeedURL);
				// Do we need to cache this version?
				if ($CacheTime > 0 && $contents != "") {
					@file_put_contents(ISC_BASE_PATH."/cache/feeds/".$FeedId, $contents);
				}
			}

			$output = "";
			$count = 0;

			// Could not load the feed, return an error
			if(!$contents) {
				return false;
			}


			if($xml = SimpleXML_Load_String($contents)) {
				$rss = new ISC_XML();
				$entries = $rss->ParseRSS($xml);

				foreach($entries as $entry) {
					$GLOBALS['RSSTitle'] = $entry['title'];
					$GLOBALS['RSSDescription'] = $entry['description'];
					$GLOBALS['RSSLink'] = $entry['link'];

					if ($RSSFeedSnippet != "") {
						if ($helpLinks) {
							preg_match('#/questions/([0-9]+)/#si', $entry['link'], $matches);
							if (!empty($matches)) {
								$GLOBALS['RSSLink'] = $matches[1];
							}
						}
						$output .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet($RSSFeedSnippet);
					} else {
						$output .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("PageRSSItem");
					}

					if($NumEntries > 0 && ++$count >= $NumEntries) {
						break;
					}
				}

				return $output;
			}
			else {
				return false;
			}
		}

		/**
		*	Build a contact form to include along with the page content
		*/
		public function _ContactForm()
		{

			// Load the captcha class
			$GLOBALS['ISC_CLASS_CAPTCHA'] = GetClass('ISC_CAPTCHA');

			// Did captcha fail?
			if(!empty($_POST)) {
				$GLOBALS['ContactName'] = isc_html_escape($_POST['contact_fullname']);
				$GLOBALS['ContactEmail'] = isc_html_escape($_POST['contact_email']);
				$GLOBALS['ContactCompanyName'] = isc_html_escape($_POST['contact_companyname']);
				$GLOBALS['ContactPhone'] = isc_html_escape($_POST['contact_phone']);
				$GLOBALS['ContactOrderNo'] = isc_html_escape($_POST['contact_orderno']);
				$GLOBALS['ContactRMA'] = isc_html_escape($_POST['contact_rma']);
				$GLOBALS['ContactQuestion'] = isc_html_escape($_POST['contact_question']);
				$GLOBALS['ContactFormError'] = GetLang('BadContactFormCaptcha');
			}
			else {
				// Hide the captcha error message
				$GLOBALS['HideFormError'] = "none";
			}

			// Which fields should we include in the form?
			$fields = $this->_pagerow['pagecontactfields'];

			if(!is_numeric(isc_strpos($fields, "fullname"))) {
				$GLOBALS['HideFullName'] = "none";
			}

			if(!is_numeric(isc_strpos($fields, "companyname"))) {
				$GLOBALS['HideCompanyName'] = "none";
			}

			if(!is_numeric(isc_strpos($fields, "phone"))) {
				$GLOBALS['HidePhone'] = "none";
			}

			if(!is_numeric(isc_strpos($fields, "orderno"))) {
				$GLOBALS['HideOrderNo'] = "none";
			}

			if(!is_numeric(isc_strpos($fields, "rma"))) {
				$GLOBALS['HideRMANo'] = "none";
			}

			$GLOBALS['PageId'] = $this->_pageid;

			if(GetConfig('CaptchaEnabled') == 0) {
				$GLOBALS['HideCaptcha'] = "none";
			}
			else {
				$GLOBALS['ISC_CLASS_CAPTCHA']->CreateSecret();
				$GLOBALS['CaptchaImage'] = $GLOBALS['ISC_CLASS_CAPTCHA']->ShowCaptcha();
			}

			$output = $this->_pagecontent;
			$output .= "<p />";

			// Do we need to integrate ActiveKB's ARS into this page?
			if(GetConfig('AKBIsConfigured') && GetConfig('ARSIntegrated') && in_array($this->_pageid, explode(",", GetConfig('ARSPageIds')))) {
				$GLOBALS['AKBPath'] = isc_html_escape(GetConfig('AKBPath'));
				$GLOBALS['ARSPanel'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetPanelContent("ActiveKB_ARS");
			}

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("page_contact_form");
			$output .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
			return $output;
		}

		/**
		*	Send a contact form from a page
		*/
		public function SendContactForm()
		{
			// If the pageid or captcha is not set then just show the page and exit
			if (!isset($_POST['page_id']) || !isset($_POST['captcha'])) {
				$this->ShowPage();
				return;
			}

			// Load the captcha class
			$GLOBALS['ISC_CLASS_CAPTCHA'] = GetClass('ISC_CAPTCHA');

			// Load the form variables
			$page_id = (int)$_POST['page_id'];
			$this->_SetPageData($page_id);

			$captcha = $_POST['captcha'];

			if(GetConfig('CaptchaEnabled') == 0) {
				$captcha_check = true;
			}
			else {
				if(isc_strtolower($captcha) == isc_strtolower($GLOBALS['ISC_CLASS_CAPTCHA']->LoadSecret())) {
					// Captcha validation succeeded
					$captcha_check = true;
				}
				else {
					// Captcha validation failed
					$captcha_check = false;
				}
			}

			if($captcha_check) {
				// Valid captcha, let's send the form. The template used for the contents of the
				// email is page_contact_email.html
				$from = @$_POST['contact_fullname'];
				$GLOBALS['PageTitle'] = $this->_pagetitle;
				$GLOBALS['FormFieldList'] = "";

				$emailTemplate = FetchEmailTemplateParser();

				// Which fields should we include in the form?
				$fields = $this->_pagerow['pagecontactfields'];

				if(is_numeric(isc_strpos($fields, "fullname"))) {
					$GLOBALS['FormField'] = GetLang('ContactName');
					$GLOBALS['FormValue'] = isc_html_escape($_POST['contact_fullname']);
					$GLOBALS['FormFieldList'] .= $emailTemplate->GetSnippet("ContactFormField");
				}

				$GLOBALS['FormField'] = GetLang('ContactEmail');
				$GLOBALS['FormValue'] = isc_html_escape($_POST['contact_email']);
				$GLOBALS['FormFieldList'] .= $emailTemplate->GetSnippet("ContactFormField");

				if(is_numeric(isc_strpos($fields, "companyname"))) {
					$GLOBALS['FormField'] = GetLang('ContactCompanyName');
					$GLOBALS['FormValue'] = isc_html_escape($_POST['contact_companyname']);
					$GLOBALS['FormFieldList'] .= $emailTemplate->GetSnippet("ContactFormField");
				}

				if(is_numeric(isc_strpos($fields, "phone"))) {
					$GLOBALS['FormField'] = GetLang('ContactPhone');
					$GLOBALS['FormValue'] = isc_html_escape($_POST['contact_phone']);
					$GLOBALS['FormFieldList'] .= $emailTemplate->GetSnippet("ContactFormField");
				}

				if(is_numeric(isc_strpos($fields, "orderno"))) {
					$GLOBALS['FormField'] = GetLang('ContactOrderNo');
					$GLOBALS['FormValue'] = isc_html_escape($_POST['contact_orderno']);
					$GLOBALS['FormFieldList'] .= $emailTemplate->GetSnippet("ContactFormField");
				}

				if(is_numeric(isc_strpos($fields, "rma"))) {
					$GLOBALS['FormField'] = GetLang('ContactRMANo');
					$GLOBALS['FormValue'] = isc_html_escape($_POST['contact_rma']);
					$GLOBALS['FormFieldList'] .= $emailTemplate->GetSnippet("ContactFormField");
				}

				$GLOBALS['Question'] = nl2br(isc_html_escape($_POST['contact_question']));

				$GLOBALS['ISC_LANG']['ContactPageFormSubmitted'] = sprintf(GetLang('ContactPageFormSubmitted'), $GLOBALS['PageTitle']);

				$emailTemplate->SetTemplate("page_contact_email");
				$message = $emailTemplate->ParseTemplate(true);

				// Send the email
				require_once(ISC_BASE_PATH . "/lib/email.php");
				$obj_email = GetEmailClass();
				$obj_email->Set('CharSet', GetConfig('CharacterSet'));
				$obj_email->From($_POST['contact_email'], $from);
				$obj_email->ReplyTo = $_POST['contact_email'];
				$obj_email->Set("Subject", GetLang('ContactPageFormSubmitted'));
				$obj_email->AddBody("html", $message);
				$obj_email->AddRecipient($this->_pagerow['pageemail'], "", "h");
				$email_result = $obj_email->Send();

				// If the email was sent ok, show a confirmation message
				$GLOBALS['MessageTitle'] = $GLOBALS['PageTitle'];

				if($email_result['success']) {
					$GLOBALS['MessageIcon'] = "IcoInfo";
					$GLOBALS['MessageText'] = sprintf(GetLang('PageFormSent'), $GLOBALS['ShopPath']);
				}
				else {
					// Email error
					$GLOBALS['MessageIcon'] = "IcoError";
					$GLOBALS['MessageText'] = GetLang('PageFormNotSent');
				}

				$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("message");
				$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
			}
			else {
				// Bad captcha, take them back to the form
				$this->ShowPage();
			}
		}
	}

?>
