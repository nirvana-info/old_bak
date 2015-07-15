<?php

	CLASS ISC_FOOTER_PANEL extends PANEL
	{
		public function SetPanelSettings()
		{
			// Show "All prices are in [currency code]"
			$currency = GetCurrencyById($GLOBALS['CurrentCurrency']);
			if(is_array($currency) && $currency['currencycode']) {
				$GLOBALS['AllPricesAreInCurrency'] = sprintf(GetLang('AllPricesAreInCurrency'), isc_html_escape($currency['currencyname']), isc_html_escape($currency['currencycode']));
			}

			if(GetConfig('DebugMode') == 1) {
				$end_time = microtime_float();
				$GLOBALS['ScriptTime'] = number_format($end_time - ISC_START_TIME, 4);
				$GLOBALS['QueryCount'] = $GLOBALS['ISC_CLASS_DB']->NumQueries;
				if (function_exists('memory_get_peak_usage')) {
					$GLOBALS['MemoryPeak'] = "Memory usage peaked at ".NiceSize(memory_get_peak_usage(true));
				} else {
					$GLOBALS['MemoryPeak'] = '';
				}

				if (isset($_REQUEST['debug'])) {
					$GLOBALS['QueryList'] = "<ol class='QueryList' style='font-size: 13px;'>\n";
					foreach($GLOBALS['ISC_CLASS_DB']->QueryList as $query) {
						$GLOBALS['QueryList'] .= "<li style='line-height: 1.4; margin-bottom: 4px;'>".isc_html_escape($query['Query'])." &mdash; <em>".number_format($query['ExecutionTime'], 4)."seconds</em></li>\n";
					}
					$GLOBALS['QueryList'] .= "</ol>";
				}
				$GLOBALS['DebugDetails'] = "<p>Page built in ".$GLOBALS['ScriptTime']."s with ".$GLOBALS['QueryCount']." queries. ".$GLOBALS['MemoryPeak']."</p>";
			}
			else {
				$GLOBALS['DebugDetails'] = '';
			}

			// Do we have any live chat service code to show in the footer
			$modules = GetConfig('LiveChatModules');
			if(!empty($modules)) {
				$liveChatClass = GetClass('ISC_LIVECHAT');
				$GLOBALS['LiveChatFooterCode'] = $liveChatClass->GetPageTrackingCode('footer');
			}

			// Load our whitelabel file for the front end
			require_once ISC_BASE_PATH.'/includes/whitelabel.php';

			// Load the configuration file for this template
			$poweredBy = 0;
			require_once ISC_BASE_PATH.'/templates/'.GetConfig('template').'/config.php';
			if(isset($GLOBALS['TPL_CFG']['PoweredBy'])) {
				if(!isset($GLOBALS['ISC_CFG']['TemplatePoweredByLines'][$GLOBALS['TPL_CFG']['PoweredBy']])) {
					$GLOBALS['TPL_CFG']['PoweredBy'] = 0;
				}
				$poweredBy = $GLOBALS['TPL_CFG']['PoweredBy'];
			}

			// Showing the powered by?
			$GLOBALS['PoweredBy'] = '';
			if($GLOBALS['ISC_CFG']['DisableFrontEndPoweredBy'] == false && isset($GLOBALS['ISC_CFG']['TemplatePoweredByLines'][$poweredBy])) {
				$GLOBALS['PoweredBy'] = $GLOBALS['ISC_CFG']['TemplatePoweredByLines'][$poweredBy];
			}
		}
	}

?>