<?php

	/**
	*	Before the template parsing engine runs we will create a global list of banners
	*	for the selected page which will be "hooked" into the template system so they
	*	can be displayed on the site.
	**/
	class ISC_BANNER
	{

		function __construct()
		{

			// First up, which page are we on?
			$GLOBALS['Banners'] = array();
			$banners = array();
			$page = "";
			$page_type = "";

			if(isset($GLOBALS['ISC_CLASS_INDEX'])) {
				$page_type = 'home_page';
			}
			else if(isset($GLOBALS['ISC_CLASS_SEARCH']) || isset($GLOBALS['ISC_CLASS_NEWSEARCH'])) {
				$page_type = 'search_page';
			}
			else if(isset($GLOBALS['ISC_CLASS_BRANDS'])) {
				$page_type = 'brand_page';
			}
			else if(isset($GLOBALS['ISC_CLASS_CATEGORY'])) {
				$page_type = 'category_page';
			}else{
				$page_type = 'other';
			}

			// Save the page type globally so we can access it from the template engine
			$GLOBALS['PageType'] = $page_type;

			if($page_type != "") {
				$stamp = time();
				$query = sprintf("select * from [|PREFIX|]banners
						  where page IN ('%s', 'entire_site')
							and status='1'
							and (
								(datetype='always' and datefrom = 0 and dateto = 0)
								or (datetype='custom' and datefrom < %s and dateto > %s)
								or (datetype='weekly' and (locate(lower(dayname(curdate())), displayweekly)>0))
							)
						  order by bannerid",
						  $GLOBALS['ISC_CLASS_DB']->Quote($page_type),
						  $GLOBALS['ISC_CLASS_DB']->Quote($stamp),
						  $GLOBALS['ISC_CLASS_DB']->Quote($stamp));
				
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				
				$customerServiceTime = $this->GetCustomerServiceTime();
				
				//GMT to EST
				$timezoneAdjustment = GetConfig('StoreTimeZone');
				if(GetConfig('StoreDSTCorrection')) {
					++$timezoneAdjustment;
				}
				$timezoneAdjustment *= 3600;
				$currentTime = time() + $timezoneAdjustment;
				
				$now = array(
						'week' => date('w', $currentTime),
						'hour' => date('G', $currentTime),
						'min' => date('i', $currentTime)
					);
				$nowtime = $now['hour']*60 + $now['min'];
				$nowdate = ConvertDateToTime(date('m/d/Y', $currentTime));
				
				while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					
					if($row['showtime'] == 'entireday'){
						array_push($banners, $row);
					}else{
						
						foreach($customerServiceTime['holiday'] as $holiday){
							if($nowtime > $holiday['from'] && $nowtime < $holiday['to']){
								
								if($holiday['specialdate'] == $nowdate){
									array_push($banners, $row);
									break;
								}
							}
						}
						
						if(empty($banners)){
							if($now['week'] > 0 && $now['week'] < 6){
								if($nowtime > $customerServiceTime['weekday']['from'] && $nowtime < $customerServiceTime['weekday']['to']){
									array_push($banners, $row);
								}
							}
							
							if($now['week'] == 6){
								if($nowtime > $customerServiceTime['saturday']['from'] && $nowtime < $customerServiceTime['saturday']['to']){
									array_push($banners, $row);
								}
							}
							
							if($now['week'] == 0){
								if($nowtime > $customerServiceTime['sunday']['from'] && $nowtime < $customerServiceTime['sunday']['to']){
									array_push($banners, $row);
								}
							}
						}
					}
				}

				if($GLOBALS['ISC_CLASS_DB']->CountResult($result) > 0) {
					foreach($banners as $banner) {
						if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
							$banner['content'] = str_replace($GLOBALS['ShopPathNormal'], $GLOBALS['ShopPathSSL'], $banner['content']);
						}

						// Wrap the banner in a div which can be styled
						$banner['content'] = sprintf("%s<div class='Block BlockContent banner_%s_%s'>%s</div>", $banner['controlscript'], $banner['page'], $banner['location'], $banner['content']);

						switch($page_type) {
							case "other":
							case "home_page":
							case "search_page": {
								if($banner['location'] == "top" && !isset($GLOBALS['Banners']['top'])) {
									$GLOBALS['Banners']['top'] = $banner;
								}
								else if($banner['location'] == "bottom" && !isset($GLOBALS['Banners']['bottom'])) {
									$GLOBALS['Banners']['bottom'] = $banner;
								}
								break;
							}
							case "brand_page":
							case "category_page": {
								if($banner['location'] == "top" && !isset($GLOBALS['Banners'][$banner['catorbrandid']]['top'])) {
									$GLOBALS['Banners'][$banner['catorbrandid']]['top'] = $banner;
								}
								else if($banner['location'] == "bottom" && !isset($GLOBALS['Banners'][$banner['catorbrandid']]['bottom'])) {
									$GLOBALS['Banners'][$banner['catorbrandid']]['bottom'] = $banner;
								}
								break;
							}
						}
					}
				}
			}
			
		}
		
		function GetCustomerServiceTime(){
			$definedTimes = array();
			$query = $GLOBALS['ISC_CLASS_DB']->Query("SELECT * FROM [|PREFIX|]customer_services ORDER BY id asc");                    
			while($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($query)){
				if($row['daytype'] == 'holiday')
					$definedTimes[$row['daytype']][] = $row;
				else
					$definedTimes[$row['daytype']] = $row;
			}
			
			return $definedTimes;
		}
	}

?>