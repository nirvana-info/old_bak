<?php

	class TEMPLATE
	{
		// Private variables
		public $_tplName = "";

		private $_tplData = "";

		private $_tplPageTitle = "";

		private $_tplMetaKeywords = "";

		private $_tplMetaDescription = "";

		private $langVar = '';

		private $masterBaseDir = '';
		private $masterPanelDir = '';
		private $masterSnippetDir = '';

		/**
		* @var string $baseDir the Base directory to look for template files in
		*/
		public $baseDir = '';

		/**
		* @var string $panelDir The base panel template (layout files) directory
		*/
		public $panelDir = '';

		/**
		* @var string $snippetDir The base snippet directory
		*/
		public $snippetDir = '';

		/**
		* @var string the directory with the template panel php files in it
		*/
		public $panelPHPDir = '';

		/**
		* @var string the extension of templates in the $this->baseDir
		*/
		public $templateExt = 'html';

		/**
		* @var string $userAgent The user agent for requesting files if external
		* includes are used
		*/
		public $userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)';

		public $frontEnd = false;

		public $panelClassPrefix = PRODUCT_ID;

		/**
		* class constructor
		* @return void
		*/
		public function __construct($var)
		{
			$GLOBALS["SNIPPETS"] = array();

			$this->langVar = $var;

			if(!isset($GLOBALS["SNIPPETS"])) {
				$GLOBALS["SNIPPETS"] = array();
			}

			if(!isset($GLOBALS[$this->langVar])) {
				$GLOBALS[$this->langVar] = array();
			}

			// Setup default META data
			$this->SetMetaKeywords(GetConfig('MetaKeywords'));
			$this->SetMetaDescription(GetConfig('MetaDesc'));
		}

		public function FrontEnd()
		{
			$this->frontEnd = true;
			$this->ParseSettingsLangFile();
			$this->ParseCommonLangFile();
			$this->ParseFrontendLangFile();
			$this->ParseModuleLangFile();
		}

		public function ParseSettingsLangFile()
		{
			$settingsLangFile = dirname(__FILE__) . "/../../language/".GetConfig('Language')."/settings.ini";
			$this->ParseLangFile($settingsLangFile);
		}

		public function ParseCommonLangFile()
		{
			$commonLangFile = dirname(__FILE__) . "/../../language/".GetConfig('Language')."/common.ini";
			$this->ParseLangFile($commonLangFile);
		}

		public function ParseFrontendLangFile()
		{
			$frontLangFile = dirname(__FILE__) . "/../../language/".GetConfig('Language')."/front_language.ini";
			$this->ParseLangFile($frontLangFile);
		}

		public function ParseBackendLangFile()
		{
			$backLangFile = dirname(__FILE__) . "/../../language/".GetConfig('Language')."/admin/common.ini";
			$this->ParseLangFile($backLangFile);
		}

		public function ParseModuleLangFile()
		{
			$backLangFile = dirname(__FILE__) . "/../../language/".GetConfig('Language')."/module_language.ini";
			$this->ParseLangFile($backLangFile);
		}

		/**
		* sets the template base directory as well as some defaults
		*
		* @param string the base template directory
		*
		* @return void
		*/
		public function SetTemplateBase($dir)
		{
			if($this->frontEnd) {
				$this->baseDir		= $dir.'/'.GetConfig('template').'/';
				$this->panelDir		= $dir.'/'.GetConfig('template').'/'.'Panels/';
				$this->snippetDir	= $dir.'/'.GetConfig('template').'/'.'Snippets'.'/';

				$this->masterBaseDir = $dir.'/__master/';
				$this->masterPanelDir = $dir.'/__master/Panels';
				$this->masterSnippetDir = $dir.'/__master/Snippets/';
			}
			else {
				$this->baseDir		= $dir;
				$this->panelDir		= $dir.'/'.'Panels'.'/';
				$this->snippetDir	= $dir.'/'.'Snippets'.'/';
			}
		}

		/**
		* GetTemplateBase
		* Return the current template folder
		*
		* @return String
		*/
		public function GetTemplateBase()
		{
			return $this->baseDir;
		}

		/**
		* SetTemplate
		* Set the template to $TplName
		*
		* @param string $TplName the template name without the extension
		*
		* @return void
		*/
		public function SetTemplate($TplName)
		{
			$this->_tplName = $TplName;
		}

		/**
		* _GetTemplate
		* Returns the contents of a template if the template has been loaded
		*
		* @return string
		*/
		public function _GetTemplate()
		{
			return $this->_tplData;
		}

		/**
		* SetPageTitle
		* Set the title of the page
		*
		* @param string $title The title to set the page to
		*
		* @return void
		*/
		public function SetPageTitle($Title)
		{
			$this->_tplPageTitle = $Title;
		}

		public function SetMetaKeywords($Keywords)
		{
			$this->_tplMetaKeywords = $Keywords;
		}

		public function SetMetaDescription($Description)
		{
			$this->_tplMetaDescription = $Description;
		}

		/**
		* _GetPageTitle
		* Get the title of the page
		*
		* @return string The title of the page
		*/
		public function _GetPageTitle()
		{
			return $this->_tplPageTitle;
		}

		public function _GetMetaKeywords()
		{
			return $this->_tplMetaKeywords;
		}

		public function _GetMetaDescription()
		{
			return $this->_tplMetaDescription;
		}

		/**
		* ParseTemplate
		* Parse any special variables in the currently set template
		*
		* @param bool $return If true the template will be returned as a string
		* rather then echo'd
		* @param mixed $parsePage If set to false then load the template from the
		* disk otherwise $parsePage will be treated like the template contents
		*
		* @return mixed returns the parsed template if $return is true otherwise it
		* returns nothing
		*/
		public function ParseTemplate($return=false, $parsePage=false)
		{
			if (!$parsePage) {
				$this->_tplData = $this->_LoadTemplateFile();
			} else {
				$this->_tplData = $parsePage;
			}

			$this->_tplData = $this->_LangifyHTMLTag();
			$this->_tplData = $this->_ParsePanels();
			$this->_tplData = $this->_ParseIncludes();
			$this->_tplData = $this->_ParseBanners();

			$this->_tplData = $this->ParseSnippets($this->_tplData, $GLOBALS["SNIPPETS"]);
			$this->_tplData = $this->ParseGL($this->_tplData);
			$this->_tplData = $this->_ParseConstants();

			$template = $this->_GetTemplate();
			/*
			if($this->frontEnd) {
				$template .= '<script type="text/javascript">$("body").append("<div style=\'position: absolute; top: 0; background: green; padding: 4px 10px; color: white; font-size: 11px;\'>'.$this->_tplName.'.'.$this->templateExt.'</div>")</script>';
			} */
			
			$template=$this->transchar($template);
			
			if ($return) {
				return $template;
			} else {
				echo $template;
			}
		}

		/**
		* _LoadTemplateFile
		* Load the template from disk
		*
		* @return string The contents of the template file
		*/
		private function _LoadTemplateFile()
		{
			$tplData = "";

			if (!isset($this->_tplName)) {
				// No template name specified
				trigger_error(sprintf("%s", $GLOBALS[$this->langVar]['errNoTemplateNameSpecified']), E_USER_WARNING);
				return '';
			}

			$templatePath = $this->baseDir.'/'.$this->_tplName.'.'.$this->templateExt;
			if($this->masterBaseDir) {
				$masterPath = $this->masterBaseDir.'/'.$this->_tplName.'.'.$this->templateExt;
			}

			if(!file_exists($templatePath) && isset($masterPath) && file_exists($masterPath)) {
				$templatePath = $masterPath;
			}

			if(!file_exists($templatePath)) {
				trigger_error(sprintf(GetLang('errCouldntLoadTemplate'), $this->_tplName.'.'.$this->templateExt), E_USER_WARNING);
			}
			else {
				return file_get_contents($templatePath);
			}
		}

		/**
		* _ParseIncludes
		* Parse any includes in the template and insert the required data
		*
		* @return string The template with includes parsed in it
		*/
		private function _ParseIncludes()
		{
			// Parse out all of the panels in the template
			$tplData = $this->_GetTemplate();
			$matches = array();

			if (!isset($this->_tplName)) {
				// No template name specified
				trigger_error(sprintf("%s", $GLOBALS[$this->langVar]["errNoTemplateNameSpecified"]), E_USER_WARNING);
				return $tplData;
			}

			// Parse out the panel tokens in the template file

			preg_match_all("`(?siU)(%%Include.(.*)%%)`", $tplData, $matches);

			foreach ($matches[0] as $key=>$k) {
				$pattern1 = $k;
				$pattern2 = str_replace("%", "", $pattern1);
				$pattern2 = str_replace("Include.", "", $pattern2);
				ob_start();
				//pprint_r($_SERVER);
				if (strpos($pattern2, "http://") === 0) {

					// Is a URL
					$readSite = "";

					// Trick the site into thinking it a regular user as some sites stop'
					// other servers from taking files
					ini_set('user_agent', $this->userAgent);

					if ($openSite = fopen($pattern2,"r")) {
						while(!feof($openSite)) {
							$readSite .= fread($openSite, 4096);
						}
						fclose($openSite);
					}
					echo $readSite;
					//echo readfile($pattern2);
				} elseif (strpos("/",$pattern2) !== false) {
					// Has a path to the file
					include($pattern2);
				} else {
					// Must be in the root folder
					include(ISC_BASE_PATH . '/' . $pattern2);
				}

				$includeData = ob_get_contents();

				ob_end_clean();

				$tplData = str_replace($pattern1, $includeData, $tplData);
			}
			return $tplData;
		}

		/**
		* _ParseConstants
		* Parse any constants in the template, replacing them with their values
		*
		* @return string the template with it's constants parsed in it
		*/
		private function _ParseConstants()
		{
			$tplData = $this->_GetTemplate();

			if (!isset($this->_tplName)) {
				// No template name specified
				trigger_error(sprintf("%s", $GLOBALS[$this->langVar]['errNoTemplateNameSpecified']), E_USER_WARNING);
			}
			$title = $this->_GetPageTitle();
			$title = str_replace(array("<", ">"), array("&lt;", "&gt;"), $title);
			$tplData = str_replace("%%Page.WindowTitle%%", $title, $tplData);
			$tplData = str_replace("%%Page.MetaKeywords%%", isc_html_escape_spl($this->_GetMetaKeywords()), $tplData);
			$tplData = str_replace("%%Page.MetaDescription%%", isc_html_escape_spl($this->_GetMetaDescription()), $tplData);

			return $tplData;
		}

		/**
		* _ParsePanels
		* Parse any panels in the template, inserting the panel if required
		*
		* @param mixed $input if input is false load the template from disk otherwise
		* $input is treated like the contents of the template
		*
		* @return string The template with panels parsed in it
		*/
		private function _ParsePanels($input=false)
		{
			$matches = Array();

			// Parse out all of the panels in the template
			if (!$input) {
				$tplData = $this->_GetTemplate();
			} else {
				$tplData = $input;
			}

			if (!isset($this->_tplName)) {
				// No template name specified
				trigger_error(sprintf("%s", $GLOBALS[$this->langVar]["errNoTemplateNameSpecified"]), E_USER_WARNING);
			} else {


				$tplData = $this->Parse('Panel.', $tplData, 'GetPanelContent');
			}

			return $tplData;
		}

		/**
		* GetPanelContent
		* Get the contents for a given panel
		*
		* @param string $PanelId the name of the panel without the file extension
		*
		* @return string the html to put into the template to replace the keyword
		*/
		public function GetPanelContent($PanelId)
		{
			// Parse the PHP panel and return its content
			$panelData = "";

			$panelTemplate = $this->panelDir.'/'.$PanelId.'.html';
			if($this->masterPanelDir) {
				$masterPanelTemplate = $this->masterPanelDir.'/'.$PanelId.'.html';
			}
			$panelLogic = $this->panelPHPDir.$PanelId.'.php';

			// If the panel can be shown, show it
			if(!isset($GLOBALS["HidePanels"])) {
				$GLOBALS["HidePanels"] = array();
			}

			if(!in_array($PanelId, $GLOBALS["HidePanels"])) {
				if(!file_exists($panelTemplate) && isset($masterPanelTemplate) && file_exists($masterPanelTemplate)) {
					$panelTemplate = $masterPanelTemplate;
				}

				if(file_exists($panelTemplate)) {

					// Each panel has a generic panel parsing class. We will include
					// that file and parse the template
					$panelName = str_replace('Panel', '_Panel', $PanelId);

					if($this->frontEnd) {
						$panelClass = strtoupper(PRODUCT_ID.'_'.$panelName.'_PANEL');
					}
					else {
						$panelClass = $panelName;
					}

					if(file_exists($panelLogic)) {
						// Parse the PHP panel if it exists
						include_once($panelLogic);
						$objPanel = new $panelClass();
						$objPanel->SetHTMLFile($panelTemplate);

						// Otherwise we have to parse the actual panel
						$panelData = $objPanel->ParsePanel(sprintf("%s.%s", $this->_tplName, $this->templateExt));
					}
					else {
						$panelData = file_get_contents($panelTemplate);
					}

					$panelData = $this->ParseGL($panelData);
					$panelData = $this->ParseSnippets($panelData, $GLOBALS['SNIPPETS']);
				}
				else {
					return "<div>[Panel not found: '" . $PanelId . "']</div>";
				}

				if($panelData) {
					$panelData = $this->_ParsePanels($panelData);
				}
				else {
					$panelData = '';
				}
				/*
				if(preg_match('#^'.preg_quote('<div').'#i', trim($panelData))) {
					$closingTag = strpos($panelData, '>');
					$styleStart = stripos($panelData, 'style="');
					if($styleStart == false || $styleStart > $closingTag) {
						$panelData = preg_replace('#'.preg_quote('<div').'#i', '<div style="border: 1px dotted red;" title="Panels/'.$PanelId.'.html"', $panelData, 1);
					}
					else {
						$panelData = preg_replace('#style="#i', 'title="Panels/'.$PanelId.'.html" style="border: 1px dotted red;', $panelData, 1);
					}
				}
				else if($PanelId != 'HTMLHead') {
					$panelData = '<div style="border: 1px dotted red; clear: both;" title="Panels/'.$PanelId.'.html">'.$panelData.'</div>';
				}*/
				return $panelData;
			}
			else {
				return "";
			}
		}

		/**
		* GetSnippet
		* Load a snippet from disk
		*
		* @param string $PanelId The name of the snippet without the file extension
		*
		* @return string The snippet with global and language strings parsed from it
		*/
		public function GetSnippet($PanelId)
		{
			$snippetFile = $this->snippetDir.$PanelId.'.html';
			if($this->masterSnippetDir) {
				$masterSnippetFile = $this->masterSnippetDir.$PanelId.'.html';
			}

			if(file_exists($snippetFile)) {
				$snippetData = file_get_contents($snippetFile);
			}
			else if(isset($masterSnippetFile) && file_exists($masterSnippetFile)) {
				$snippetData = file_get_contents($masterSnippetFile);
			}
			// Otherwise, the snippet wasn't found
			else {
				$snippetData = "<div>[Snippet not found: '" . $PanelId . "']</div>";
			}

			return $this->ParseGL($snippetData);
		}

		/**
		* ParseSnippets
		* Parse the snippets from a template
		*
		* @param string $string the string to parse for snippets
		* @param mixed $snippets an array of snippets to parse
		*/
		public function ParseSnippets($string,$snippets)
		{

			$string = $this->Parse('SNIPPET_', $string, $snippets);

			// Make sure that if the replacement has a snippet in it that we replace
			// that but limit it to 3 replacement times in case there is a loop
			$limit = 3;
			while (strpos($string,"%%SNIPPET") !== false && $limit > 0) {
				$string = $this->ParseSnippets($string, $snippets);
				$limit--;
			}

			return $string;
		}

		/**
		* ParseGL
		* Parse global and language vars from a template/panel/snippet
		*
		* @param string $TemplateData The string to parse for vars
		*
		* @return string The string with the vars replaced
		*/
		public function ParseGL($TemplateData)
		{
			// Parse out global and language variables from template data and
			// return it. This is used from the generic panel class for each panel
			$tplData = $TemplateData;

			$dm = GetConfig('DesignMode');
			if(isset($dm) && GetConfig('DesignMode') == 1 && $this->frontEnd == 1) {
				static $dmLangEditing;
				if(!isset($dmLangEditing)) {
					// Include the Admin authorisation class
					$GLOBALS['ISC_CLASS_ADMIN_AUTH'] = GetClass('ISC_ADMIN_AUTH');
					if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->IsLoggedIn() && $GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Design_Mode)) {
						$dmLangEditing = true;
					}
					else {
						$dmLangEditing = false;
					}
				}
			}
			else {
				$dmLangEditing = false;
			}
			// If design mode is on, we need to do a lot of cool string replacement stuff
			if($dmLangEditing) {
				$badMatches = array();
				$scriptStart = 0;
				do {
					$scriptStart = stripos($tplData, "<script", $scriptStart);
					if($scriptStart === false) {
						break;
					}
					$scriptEnd = stripos($tplData, "</script>", $scriptStart);
					if($scriptEnd === false) {
						break;
					}
					$badMatches[] = substr($tplData, $scriptStart, $scriptEnd-$scriptStart);
					$tplData = substr_replace($tplData, "%%DM_LANG_EDIT%%", $scriptStart, $scriptEnd-$scriptStart);
				}
				while($scriptStart !== false);
				$valueStart = 0;
				$badMatches2 = array();
				do {
					$valueStart = stripos($tplData, "value=\"", $valueStart);
					if($valueStart === false) {
						break;
					}
					$valueEnd = stripos($tplData, "\"", $valueStart+8);
					if($valueEnd === false) {
						break;
					}
					$badMatches2[] = substr($tplData, $valueStart, $valueEnd-$valueStart+1);
					$tplData = substr_replace($tplData, "%%DM2_LANG_EDIT%%", $valueStart, $valueEnd-$valueStart+1);
				}
				while($valueStart !== false);
			}

			// Parse out the language pack variables in the template file
			preg_match_all("/(?siU)(%%LNG_[a-zA-Z0-9]{1,}%%)/", $tplData, $matches);
			foreach ($matches[0] as $key => $k) {
				$pattern1 = $k;
				$pattern2 = str_replace("%", "", $pattern1);
				$pattern2 = str_replace("LNG_", "", $pattern2);

				if($dmLangEditing == true) {
					if (isset($GLOBALS['ISC_LANG'][$pattern2])) {
						$lang_data = "<span id='lang_".$pattern2."' class='LNGString'>";
						$lang_data .= GetLang($pattern2)."</span>";
						$tplData = str_replace($pattern1, $lang_data, $tplData);
					}
				}
				else {
					if (isset($GLOBALS['ISC_LANG'][$pattern2])) {
						$tplData = str_replace($pattern1, GetLang($pattern2), $tplData);
					}
				}
			}

			if($dmLangEditing) {
				if(count($badMatches) > 0) {
					foreach($badMatches as $match) {
						preg_match_all("/(?siU)(%%LNG_[a-zA-Z0-9]{1,}%%)/", $match, $matches);
						foreach ($matches[0] as $key => $k) {
							$pattern1 = $k;
							$pattern2 = str_replace("%", "", $pattern1);
							$pattern2 = str_replace("LNG_", "", $pattern2);
							if (isset($GLOBALS['ISC_LANG'][$pattern2])) {
								$match = str_replace($pattern1, GetLang($pattern2), $match);
							}
						}
						$startPos = strpos($tplData, "%%DM_LANG_EDIT%%");
						$length = strlen("%%DM_LANG_EDIT%%");
						$tplData = substr_replace($tplData, $match, $startPos, $length);
					}
				}
				if(count($badMatches2) > 0) {
					foreach($badMatches2 as $match) {
						preg_match_all("/(?siU)(%%LNG_[a-zA-Z0-9]{1,}%%)/", $match, $matches);
						foreach ($matches[0] as $key => $k) {
							$pattern1 = $k;
							$pattern2 = str_replace("%", "", $pattern1);
							$pattern2 = str_replace("LNG_", "", $pattern2);
							if (isset($GLOBALS['ISC_LANG'][$pattern2])) {
								$match = str_replace($pattern1, GetLang($pattern2), $match);
							}
						}
						$startPos = strpos($tplData, "%%DM2_LANG_EDIT%%");
						$length = strlen("%%DM2_LANG_EDIT%%");
						$tplData = substr_replace($tplData, $match, $startPos, $length);
					}
				}

			}

			$tplData = $this->Parse("GLOBAL_", $tplData, $GLOBALS);

			return $tplData;
		}

		/**
		* Parse
		* Generic parsing function
		*
		* @param the prefix to search for
		* @param the text to parse
		* @param the associative array or function with the replacement
		* values in/returned by it
		*
		* @return string the parsed text
		*/
		public function Parse($prefix, $text, $replace)
		{
			$matches = array();
			$output = $text;

			// Parse out the language pack variables in the template file
			preg_match_all('/(?siU)(%%'.preg_quote($prefix).'[a-zA-Z0-9_\.]+%%)/', $output, $matches);

			foreach ($matches[0] as $key=>$k) {
				$pattern1 = $k;
				$pattern2 = str_replace('%', '', $pattern1);
				$pattern2 = str_replace($prefix.'', '', $pattern2);

				if (is_array($replace) && isset($replace[$pattern2])) {
					$output = str_replace($pattern1, $replace[$pattern2], $output);
				} elseif (is_string($replace) && method_exists($this, $replace)) {
					$result = $this->$replace($pattern2);
					$output = str_replace($pattern1, $result, $output);
				} else {
					$output = str_replace($pattern1, '', $output);
				}
			}
			return $output;
		}

		/**
		* GetAndParseFile
		* Load a file from the network and parse it for global and lang strings
		*
		* @param string $File The file on the server to parse
		*
		* @return string the data that has been loaded and parsed
		*/
		public function GetAndParseFile($File)
		{
			// need to check to make sure we aren't including the file twice
			if (!isset($GLOBAL['IncludedFiles'])) {
				$GLOBAL['IncludedFiles'] = array();
			}

			if (in_array($File,$GLOBAL['IncludedFiles'])) {
				return '';
			} else {
				$GLOBAL['IncludedFiles'][] = $File;
			}
			// Open a file, parse out tokens and return it
			$dir = dirname(__FILE__)."/../../";
			$file = realpath($dir.$File);

			$fdata = file_get_contents($file);

			$fdata = $this->ParseGL($fdata);

			return $fdata;
		}

		/**
		* Parse a lang file and store it's values in the $GLOBALS[$this->langVar]
		* array
		* @return void;
		*/
		public function ParseLangFile($file)
		{
			if (!file_exists($file)) {
				// Trigger an error -- has to be in English though
				// because we can't load the language file
				trigger_error(sprintf("The language file %s couldn't be opened.", $file), E_USER_WARNING);
			} else {
				// Parse the ArticleLive language file
				$vars = parse_ini_file($file);
				if (isset($GLOBALS[$this->langVar])) {
					$GLOBALS[$this->langVar] = array_merge($GLOBALS[$this->langVar], $vars);
				} else {
					$GLOBALS[$this->langVar] = $vars;
				}

				if (!is_array($GLOBALS[$this->langVar])) {
					// Couldn't load the language file
					trigger_error(sprintf("The language file %s couldn't be loaded.", $file), E_USER_WARNING);
				}
			}
		}

		/**
		* ParseBanners
		* Parse banners placeholders from a template file using the $GLOBALS["Banners"] array
		*
		* @param string $TemplateData The string to parse for vars
		*
		* @return string The string with the vars replaced
		*/
		private function _ParseBanners()
		{
			if(!isset($GLOBALS['ISC_CLASS_BANNER'])) {
				$GLOBALS['ISC_CLASS_BANNER'] = GetClass('ISC_BANNER');
			}

			// Parse out banner variables from template data and
			// return it. This is used specifically for Interspire Shopping Cart only
			$tplData = $this->_GetTemplate();

			// Are there any banners to include?
			if(isset($GLOBALS["PageType"]) && isset($GLOBALS["Banners"]) && is_array($GLOBALS["Banners"]) && count($GLOBALS["Banners"]) > 0) {
				switch($GLOBALS["PageType"]) {
					case "other":
					case "home_page":
					case "search_page": {
						// Is there a top template?
						if(isset($GLOBALS["Banners"]["top"])) {
							// Replace it out
							$tplData = str_replace("%%Banner.TopBanner%%", $GLOBALS["Banners"]["top"]["content"], $tplData);
						}
						else {
							// Replace it with nothing
							$tplData = str_replace("%%Banner.TopBanner%%", "", $tplData);
						}

						// Is there a bottom template?
						if(isset($GLOBALS["Banners"]["bottom"])) {
							// Replace it out
							$tplData = str_replace("%%Banner.BottomBanner%%", $GLOBALS["Banners"]["bottom"]["content"], $tplData);
						}
						else {
							$tplData = str_replace("%%Banner.BottomBanner%%", "", $tplData);
						}

						break;
					}
					case "category_page":
					case "brand_page": {

						// Are we on a category page or brand page?
						if($GLOBALS["PageType"] == "category_page") {
							$id = $GLOBALS["CatId"];
						}
						else {
							$id = $GLOBALS["BrandId"];
						}

						if(isset($GLOBALS["Banners"][$id])) {
							// Is there a top template?
							if(isset($GLOBALS["Banners"][$id]["top"])) {
								// Replace it out
								$tplData = str_replace("%%Banner.TopBanner%%", $GLOBALS["Banners"][$id]["top"]["content"], $tplData);
							}
							else {
								// Replace it with nothing
								$tplData = str_replace("%%Banner.TopBanner%%", "", $tplData);
							}

							if(isset($GLOBALS["Banners"][$id]["bottom"])) {
								// Replace it out
								$tplData = str_replace("%%Banner.BottomBanner%%", $GLOBALS["Banners"][$id]["bottom"]["content"], $tplData);
							}
							else {
								// Replace it with nothing
								$tplData = str_replace("%%Banner.BottomBanner%%", "", $tplData);
							}
						}
						else {
							// Replace the banners with nothing
							$tplData = str_replace("%%Banner.TopBanner%%", "", $tplData);
							$tplData = str_replace("%%Banner.BottomBanner%%", "", $tplData);
						}

						break;
					}
				}
			}
			else {
				// Replace the banners with nothing
				$tplData = str_replace("%%Banner.TopBanner%%", "", $tplData);
				$tplData = str_replace("%%Banner.BottomBanner%%", "", $tplData);
			}

			return $tplData;
		}

		public function Assign($k, $v)
		{
			$GLOBALS[$k] = $v;
		}

		/**
		 * _LangifyHTMLTag
		 * Convert the <html> tag in to it's equivilent for the language in use.
		 * Will switch text direction if necessary and add lang attributes to the head tag.
		 * Pass in the template to be converted.
		 *
		 * @param string The template contents.
		 */
		private function _LangifyHTMLTag()
		{
			$tplData = $this->_GetTemplate();

			if(isset($this->_DoneHead)) {
				return $tplData;
			}

			if(isc_strpos($tplData, "<html") !== false) {
				$this->_DoneHead = true;
			}
			else {
				return $tplData;
			}

			if(GetConfig('Language')) {
				if(function_exists('str_ireplace')) {
					$tplData = str_ireplace("<html", sprintf("<html xml:lang=\"%s\" lang=\"%s\"", GetConfig('Language'), GetConfig('Language')), $tplData);
				}
				else {
					$tplData = str_replace("<html", sprintf("<html xml:lang=\"%s\" lang=\"%s\"", GetConfig('Language'), GetConfig('Language')), $tplData);
				}
			}

			if(GetLang('RTL') == 1) {
				$tplData = str_ireplace("<html", "<html dir=\"rtl\"", $tplData);
				if($this->frontEnd) {
					$rtlCSSPath = $this->baseDir . "/" . GetConfig('template') . "/Styles/rtl.css";
					$rtlCSS = $GLOBALS['TPL_PATH'] . "/Styles/rtl.css";
				}
				else {
					$rtlCSSPath = $this->baseDir . "/../Styles/rtl.css";
					$rtlCSS = "Styles/rtl.css";
				}
				if(file_exists($rtlCSSPath)) {
					$GLOBALS['RTLStyles'] = sprintf('<link rel="stylesheet" type="text/css" href="%s" />', $rtlCSS);
				}
			}

			return $tplData;
		}
		
		//2011-3-25 Ronnie add , convert html char
		private function transchar($template){
			
			//var_dump($this->_GetPageTitle());
			if($this->_GetPageTitle()==""){return $template;}
			
			$start_st="%convert%";
			$end_st="%end_convert%";
			
			$whileflag=true;
			
			for($i=0;$whileflag;$i+=1){
				$p2=strpos($template,$end_st);
				$p1=strpos($template,$start_st);
				
				if($p2>0 && $p2>0){
					$tmp=substr($template,$p1,$p2-$p1+strlen($end_st));
						
					$tmp2=str_replace($end_st, "", $tmp);
					$tmp2=str_replace($start_st, "", $tmp2);
					$tmp2=str_replace("&gt;", ">", $tmp2);
					$tmp2=str_replace("&lt;", "<", $tmp2);
						
					//var_dump($tmp);
					//var_dump($tmp2);
						
					$template=str_replace($tmp, $tmp2, $template);
				}else{$whileflag=false;}
				if($i>20){$whileflag=false;}
			}
			return $template;
		}
		
	}
	
?>
