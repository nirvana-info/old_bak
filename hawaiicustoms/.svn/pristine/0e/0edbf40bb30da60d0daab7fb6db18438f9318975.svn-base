<?php

	CLASS ISC_HTMLHEAD_PANEL extends PANEL
	{
		public function SetPanelSettings()
		{
			// Do we have any live chat service code to show in the header?
			$modules = GetConfig('LiveChatModules');
			if(!empty($modules)) {
				$liveChatClass = GetClass('ISC_LIVECHAT');
				$GLOBALS['LiveChatCode'] = $liveChatClass->GetPageTrackingCode('header');
				$GLOBALS['LiveChatCodeEnabled'] = '';
			} else {
				$GLOBALS['LiveChatCodeEnabled'] = 'display:none';
			}

			$GLOBALS['TrackingCode'] = '';

			// Get the visitor tracking Javascript
			$tracker = GetClass('ISC_VISITOR');
			$GLOBALS['TrackingCode'] .= $tracker->GetTrackingJavascript();

			$GLOBALS['CharacterSet'] = GetConfig('CharacterSet');

			// Are quick searches enabled?
			if(GetConfig('QuickSearch') != 0) {
				$GLOBALS['QuickSearchJS'] = sprintf("<script type=\"text/javascript\" src=\"%s/javascript/quicksearch.js\"></script>", GetConfig('AppPath'));
			}

			$GLOBALS['AdvancedSearch'] = $GLOBALS['ShopPath']."/search.php?mode=advanced";
			if(isset($GLOBALS['ISC_CLASS_SEARCH'])) {
			$GLOBALS['AdvancedSearch'] = "javascript:ToggleSearchForm()";
			$GLOBALS['HideAdvancedLink'] = "none";
			}

			// Any additional stylesheets to include?
			$GLOBALS['Stylesheets'] = '';
			if(isset($GLOBALS['AdditionalStylesheets'])) {
				foreach($GLOBALS['AdditionalStylesheets'] as $stylesheet) {
					$GLOBALS['Stylesheets'] .= '<link href="'.$stylesheet.'" type="text/css" rel="stylesheet" />';
				}
			}

			// Including javascript and css files for redefine search in search page
			//$GLOBALS['Stylesheets'] .= '<link href="'.$GLOBALS['AppPath'].'/javascript/search_js/thickbox.css" type="text/css" rel="stylesheet" /><script type="text/javascript" src="'.$GLOBALS['AppPath'].'/javascript/search_js/jquery-latest.js"></script><script type="text/javascript" src="'.$GLOBALS['AppPath'].'/javascript/search_js/thickbox.js"></script>';

			// Are site wide RSS feeds enabled?
			if(!isset($GLOBALS['HeadRSSLinks'])) {
				$GLOBALS['HeadRSSLinks'] = '';
			}
			/*-- Changed the below 3 $GLOBALS['ShopPathNormal'] to $GLOBALS['ShopPath'] as we need to modify for https - By clarion --*/
			if(GetConfig('RSSLatestBlogEntries') != 0) {
				$GLOBALS['HeadRSSLinks'] .= GenerateRSSHeaderLink($GLOBALS['ShopPath']."/rss.php?action=newblogs", GetLang('HeadRSSLatestNews'));
			}

			if(GetConfig('RSSNewProducts') != 0) {
				$GLOBALS['HeadRSSLinks'] .= GenerateRSSHeaderLink($GLOBALS['ShopPath']."/rss.php", GetLang('HeadRSSNewProducts'));
			}

			if(GetConfig('RSSPopularProducts') != 0) {
				$GLOBALS['HeadRSSLinks'] .= GenerateRSSHeaderLink($GLOBALS['ShopPath']."/rss.php?action=popularproducts", GetLang('HeadRSSPopularProducts'));
			}

			/* Added the below code for applying Canonical Link - starts */
			
			$currentURL = trim($_SERVER['REQUEST_URI'],"/");
			if(preg_match("/\.html/",$_SERVER['REQUEST_URI']))
			{
				$currentURL = preg_replace('/(.+\.html)(.*)/', '$1',$currentURL);
			}
			else if(preg_match("/\.php/",$_SERVER['REQUEST_URI']))
			{
				$currentURL = preg_replace('/(.+\.php)(.*)/', '$1',$currentURL);
			}
			else if(preg_match("/\/orderby/",$_SERVER['REQUEST_URI']))
			{
				$currentURL = preg_replace('/(\/orderby)(.*)/', '',$currentURL);
			}
			//2010-11-18 Ronnie modify,Canonical Link
			//$GLOBALS['HeadCanonicalLink'] = $GLOBALS['ShopPath']."/".$currentURL;
			$GLOBALS['HeadCanonicalLink'] = $this->CreateCanonicalLink($currentURL);
			
			
			/* ---- ends ---- */

			// Do we need to include the script for design mode?
			if(GetConfig('DesignMode') && isset($_COOKIE['STORESUITE_CP_TOKEN'])) {
				// Include the Admin authorisation class
				$GLOBALS['ISC_CLASS_ADMIN_AUTH'] = GetClass('ISC_ADMIN_AUTH');
				if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->IsLoggedIn() && $GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Design_Mode)) {
					$GLOBALS['DesignModeStyleSheet'] = sprintf("<link href=\"%s/lib/designmode/designmode.css\" type=\"text/css\" rel=\"stylesheet\" />", $GLOBALS['AppPath']);

					$GLOBALS['DesignModeScriptTag'] = sprintf("<script src=\"%s/lib/designmode/designmode.js\" type=\"text/javascript\"></script>\n<script type=\"text/javascript\">DesignMode.template_page = '%s';</script>", $GLOBALS['AppPath'], $GLOBALS['ISC_CLASS_TEMPLATE']->_tplName.".html");
				}
			}

			// Include the tracking code for each analytics module
			$GLOBALS['TrackingCode'] .= GetTrackingCodeForAllPackages();
		}
		
		//2010-11-18 Ronnie add ,Create Canonical Link
		public function CreateCanonicalLink($currentURL){
			if($currentURL=="") return $GLOBALS['ShopPath'];
			//echo "123".$GLOBALS['OriginalSearchQuery'];
			if($GLOBALS['RedefinedSearchQuery']!='')return $GLOBALS['ShopPath'];
			
			$URL="";
			$URLSortArray = array (
    			'category'  => '',
				'subcategory'  => '',
				'brand'  => '',
				'series'  => '',
				'year'  => '',
				'make'  => '',
				'model'  => ''
			);
			
			$SplitUrl=spliti("/",$currentURL);
			//echo($currentURL);
			//var_dump($SplitUrl);
			
			$addstr="";
			if (count($SplitUrl)>3){$addstr="/";}
			
			//Split array to Sorted array,and remove from url string
			foreach ($SplitUrl as $key => $value1){
				//echo $value1;
				foreach ($URLSortArray as $key2 => $value2){
					//echo $value2['Text'];
					if($value1==$key2){
						//echo $key2.$SplitUrl[$key+1];
						$URLSortArray[$key2]=$key2."/".$SplitUrl[$key+1];//."/".$SplitUrl[$key+1];
						$currentURL=str_replace($addstr.$URLSortArray[$key2], "", $currentURL);
					}
				}
			}
			
			//ech0($currentURL);
			
			//var_dump($URLSortArray);
			$first=false;
			
			//find first
			foreach ($URLSortArray as $key => $value){
				if($SplitUrl[0]==$key){
					$first=true;
				}
			}
			
			//put first to Sorted array,and remove from url string
			if(!$first && $URLSortArray['category']==''){$URLSortArray['category']="category/".$SplitUrl[0];$currentURL=str_replace($SplitUrl[0], "", $currentURL);}
			elseif(!$first && $URLSortArray['brand']==''){$URLSortArray['brand']="brand/".$SplitUrl[0];$currentURL=str_replace($SplitUrl[0], "", $currentURL);}
			
			//var_dump($URLSortArray);
			
			//Merged Sorted array
			foreach ($URLSortArray as $key => $value){
				if($value!=""){
					$URL=$URL."/".$value;
				}
			}		
			
			//Replace first parameter
			$URL=str_replace("/category/", "", $URL);
			if($URLSortArray['category']==''&&$URLSortArray['brand']!=''){$URL=str_replace("/brand/", "", $URL);}
			
			//Replace url string
			$currentURL=str_replace("/category/".$URLSortArray['category'], "", $currentURL);
			$currentURL=str_replace("/brand/".$URLSortArray['brand'], "", $currentURL);
			
			$addstr="";
			if(!$first){$addstr="/";}
			//echo strtolower($GLOBALS['ShopPath']."/".$URL.$currentURL);
			
			//Merge URL and unremove
			return strtolower($GLOBALS['ShopPath'].$addstr.$URL.$currentURL);
		}
		
	}

?>