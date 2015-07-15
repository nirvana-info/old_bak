	<form action="index.php?ToDo=viewSearchStats" name="frmStats" id="frmStats" method="post">
	<input id="currentTab" name="currentTab" value="0" type="hidden">
	<div class="BodyContainer">
	<table cellSpacing="0" cellPadding="0" width="100%" style="margin-left: 4px; margin-top: 8px;">
	<tr>
		<td class="Heading1">Search Statistics</td>
	</tr>
	<tr>
		<td class="Intro">
			<p>%%LNG_StoreOverviewIntro%%</p>
			%%GLOBAL_Message%%
		</td>
	</tr>
	<tr>
		<td class="Intro">
			<div>
				<input type="button" name="clearSearchStats" value="Delete Statistics" onclick="clearStatsClick()" class="SmallButton" />
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<ul id="tabnav">
				<li><a href="#" class="active" id="tab0" onclick="ShowTab(0)">%%LNG_StatsOverview%%</a></li>
				<li><a href="#" id="tab1" onclick="ShowTab(1)">%%LNG_SearchStatsKeywordsResults%%</a></li>
				<li><a href="#" id="tab2" onclick="ShowTab(2)">%%LNG_SearchStatsKeywordsNoResults%%</a></li>
				<li><a href="#" id="tab3" onclick="ShowTab(3)">%%LNG_SearchStatsBestPerforming%%</a></li>
				<li><a href="#" id="tab4" onclick="ShowTab(4)">%%LNG_SearchStatsWorstPerforming%%</a></li>
				<li><a href="#" id="tab5" onclick="ShowTab(5)">%%LNG_SearchStatsCorrections%%</a></li>
			</ul>
		</td>
	</tr>
	<tr>
		<td>
			<br />
			<div id="introText" style="padding:0px 0px 5px 10px" class="Text"></div>
			<div style="padding:5px 0px 5px 10px" class="Text FloatLeft">
				<table border=0 cellspacing=0 cellpadding=0>
					<tr>
						<td style="background: #eee; padding: 3px 5px;" width="1">
							<img src="images/dateicon.gif" />
						</td>
						<td style="background: #eee;">Date Range:</td>
						<td style="background: #eee; padding: 3px 5px;" width="1">
								<select name="Calendar[DateType]" id="Calendar" class="CalendarSelect" onchange="doCustomDate(this, 7)">
%%GLOBAL_CalendarDateTypeOptions%%
</select>
						</td>
						<td style="background: #eee;">
							<span id=customDate7 style="display:none">&nbsp;
										%%GLOBAL_FromDatePicker%%
										<span class=body>%%LNG_To1%%</span>
										%%GLOBAL_ToDatePicker%%
									</span>&nbsp;
						</td>
						<td style="background: #eee; padding: 3px 5px;"><input type="submit" value="Go" class="Text" /></td>
					</tr>
				</table>
			</div>
			<div id="div0" style="padding-top:10px">
				<table width="100%" border="0" class="text" style="padding-left:10px; clear: both;">
					<tr>
						<td valign=top width="250" nowrap>
							<div class="MidHeading" style="width:100%"><img src="images/order.gif" align="absMiddle">&nbsp;%%LNG_OverviewSearchSummary%%</div>
							<ul class="Text">
								<li>%%LNG_OverviewNoSearches%%: %%GLOBAL_OverviewNumSearches%%</li>
								<li>%%LNG_OverviewMostSearchesDay%%: %%GLOBAL_OverviewMostSearchesDay%%</li>
								<li>%%LNG_OverviewAvgSearchesDay%%: %%GLOBAL_OverviewAverageSearchesDay%%</li>
								<li>%%LNG_OverviewPopularTermsResults%%: %%GLOBAL_OverviewMostPopularTerms%%</li>
								<li>%%LNG_OverviewPopularTermsNoResults%%: %%GLOBAL_OverviewMostPopularTermsNoResults%%</li>
							</ul>
						</td>
						<td width="100%" align="center">
							<div style="display: %%GLOBAL_HideChart%%">
								<strong>%%GLOBAL_ChartTitle%%</strong>
								<div id="flashcontent" style="clear: both; width: 100%;">
								</div>
								<script type="text/javascript" src="includes/amcharts/swfobject.js"></script>
								<script type="text/javascript">
									$(document).ready(function() {
										var so = new SWFObject("%%GLOBAL_ShopPath%%/admin/includes/amcharts/ampie.swf", "ampie", "100%", "430", "8", "#FFFFFF");
										so.addVariable("path", "%%GLOBAL_ShopPath%%/admin/includes/amcharts/");
										so.addVariable("settings_file", escape("%%GLOBAL_ShopPath%%/admin/includes/amcharts/searchoverview.xml"));
										so.addVariable("data_file", escape("%%GLOBAL_ShopPath%%/admin/index.php?ToDo=searchStatsOverviewData&from=%%GLOBAL_OverviewFromStamp%%&to=%%GLOBAL_OverviewToStamp%%"));
										so.addVariable("preloader_color", "#000000");

										//zfang_20100625 Set mode: opaque
										so.addParam("wmode", "opaque");

										so.write("flashcontent");
									});
								</script>
							</div>
						</td>
					</tr>
				</table>
			</div>
			<div id="div1" style="padding-top:10px; padding-left:10px" class="text">
				<div id="keywordsWithResultsGrid">
				</div>
			</div>
			<div id="div2" style="padding-top:10px; padidng-left:10px" class="text">
				<div id="keywordsWithoutResultsGrid">
				</div>
			</div>
			<div id="div3" style="padding-top:10px; padding-left:10px" class="text">
				<div id="bestPerformingKeywordsGrid">
				</div>
			</div>
			<div id="div4" style="padding-top:10px; padding-left:10px" class="text">
				<div id="worstPerformingKeywordsGrid">
				</div>
			</div>
			<div id="div5" style="padding-top:10px; padding-left:10px" class="text">
				<div id="searchCorrectionsGrid">
				</div>
			</div>
			</form>
		</td>
	</tr>
	</table>
	</div>

	<script type="text/javascript">

	var resultsPerPage = 20;

	var keywordsWithResultsLoaded = false;
	var keywordsWithResultsFromLink = false;
	var keywordsWithResultsCurrentPage = 1;
	var keywordsWithResultsSortField = '';
	var keywordsWithResultsSortOrder = '';

	var keywordsWithoutResultsLoaded = false;
	var keywordsWithoutResultsFromLink = false;
	var keywordsWithoutResultsCurrentPage = 1;
	var keywordsWithoutResultsSortField = '';
	var keywordsWithoutResultsSortOrder = '';

	var bestPerformingKeywordsLoaded = false;
	var bestPerformingKeywordsFromLink = false;
	var bestPerformingKeywordsCurrentPage = 1;
	var bestPerformingKeywordsSortField = '';
	var bestPerformingKeywordsSortOrder = '';

	var worstPerformingKeywordsLoaded = false;
	var worstPerformingKeywordsFromLink = false;
	var worstPerformingKeywordsCurrentPage = 1;
	var worstPerformingKeywordsSortField = '';
	var worstPerformingKeywordsSortOrder = '';

	var searchCorrectionsLoaded = false;
	var searchCorrectionsFromLink = false;
	var searchCorrectionsCurrentPage = 1;
	var searchCorrectionsSortField = '';
	var searchCorrectionsSortOrder = '';

	function ShowTab(T) {

		i = 0;

		while (document.getElementById("tab" + i) != null) {
			document.getElementById("div" + i).style.display = "none";
			document.getElementById("tab" + i).className = "";
			i++;
		}

		document.getElementById("div" + T).style.display = "";
		document.getElementById("tab" + T).className = "active";
		document.getElementById("currentTab").value = T;

		// What should the intro text be?
		switch(T) {
			case 0: {
				$('#introText').html('%%LNG_StatsSearchOverviewIntro1%%');
				break;
			}
			case 1: {
				$('#introText').html('%%LNG_StatsSearchOverviewIntro2%%');

				if(!keywordsWithResultsLoaded) {
					LoadKeywordsWithResultsGrid();
					keywordsWithResultsLoaded = true;
				}
				break;
			}
			case 2: {
				$('#introText').html('%%LNG_StatsSearchOverviewIntro3%%');

				if(!keywordsWithoutResultsLoaded) {
					LoadKeywordsWithoutResultsGrid();
					keywordsWithoutResultsLoaded = true;
				}
				break;
			}
			case 3: {
				$('#introText').html('%%LNG_StatsSearchOverviewIntro4%%');

				if(!bestPerformingKeywordsLoaded) {
					LoadBestPerformingKeywordsGrid();
					bestPerformingKeywordsLoaded = true;
				}
				break;
			}
			case 4: {
				$('#introText').html('%%LNG_StatsSearchOverviewIntro5%%');

				if(!worstPerformingKeywordsLoaded) {
					LoadWorstPerformingKeywordsGrid();
					worstPerformingKeywordsLoaded = true;
				}
				break;
			}
			case 5: {
				$('#introText').html('%%LNG_StatsSearchOverviewIntro6%%');

				if(!searchCorrectionsLoaded) {
					LoadSearchCorrectionsGrid();
					searchCorrectionsLoaded = true;
				}
				break;
			}
		}
	}

	function ChangeKeywordsWithResultsPerPage(ResultsPerPage) {
		// Change how many results are shown per page
		resultsPerPage = ResultsPerPage;
		keywordsWithResultsCurrentPage = 1;
		keywordsWithResultsFromLink = true;
		LoadKeywordsWithResultsGrid();
	}

	function ChangeKeywordsWithResultsPage(Page) {
		// Change which page of results we're viewing
		keywordsWithResultsCurrentPage = Page;
		keywordsWithResultsFromLink = true;
		LoadKeywordsWithResultsGrid();
	}

	function SortKeywordsWithResults(field, order) {
		keywordsWithResultsSortField = field;
		keywordsWithResultsSortOrder = order;
		keywordsWithResultsFromLink = true;
		LoadKeywordsWithResultsGrid();
	}

	function LoadKeywordsWithResultsGrid() {
		// Load the search keywords with results and jump to a specific page
		jQuery.ajax({url: 'index.php?ToDo=searchStatsWithResultsGrid&FromLink='+keywordsWithResultsFromLink+'&From=%%GLOBAL_FromStamp%%&To=%%GLOBAL_ToStamp%%&Page='+keywordsWithResultsCurrentPage+'&Show='+resultsPerPage+'&SortBy='+keywordsWithResultsSortField+'&SortOrder='+keywordsWithResultsSortOrder,
			     success: function(data) {
				$('#keywordsWithResultsGrid').html(data)
			     }
			}
		);
	}

	function ChangeKeywordsWithoutResultsPerPage(ResultsPerPage) {
		// Change how many results are shown per page
		resultsPerPage = ResultsPerPage;
		keywordsWithoutResultsCurrentPage = 1;
		keywordsWithoutResultsFromLink = true;
		LoadKeywordsWithoutResultsGrid();
	}

	function ChangeKeywordsWithoutResultsPage(Page) {
		// Change which page of results we're viewing
		keywordsWithoutResultsCurrentPage = Page;
		keywordsWithoutResultsFromLink = true;
		LoadKeywordsWithoutResultsGrid();
	}

	function SortKeywordsWithoutResults(field, order) {
		keywordsWithoutResultsSortField = field;
		keywordsWithoutResultsSortOrder = order;
		keywordsWithoutResultsFromLink = true;
		LoadKeywordsWithoutResultsGrid();
	}

	function LoadKeywordsWithoutResultsGrid() {
		// Load the search keywords without results and jump to a specific page
		jQuery.ajax({url: 'index.php?ToDo=searchStatsWithoutResultsGrid&FromLink='+keywordsWithoutResultsFromLink+'&From=%%GLOBAL_FromStamp%%&To=%%GLOBAL_ToStamp%%&Page='+keywordsWithoutResultsCurrentPage+'&Show='+resultsPerPage+'&SortBy='+keywordsWithoutResultsSortField+'&SortOrder='+keywordsWithoutResultsSortOrder,
			     success: function(data) {
				$('#keywordsWithoutResultsGrid').html(data)
			     }
			}
		);
	}

	function ChangeBestPerformingKeywordsPerPage(ResultsPerPage) {
		// Change how many results are shown per page
		resultsPerPage = ResultsPerPage;
		bestPerformingKeywordsCurrentPage = 1;
		bestPerformingKeywordsFromLink = true;
		LoadBestPerformingKeywordsGrid();
	}

	function ChangeBestPerformingKeywordsPage(Page) {
		// Change which page of results we're viewing
		bestPerformingKeywordsCurrentPage = Page;
		bestPerformingKeywordsFromLink = true;
		LoadBestPerformingKeywordsGrid();
	}

	function SortBestPerformingKeywords(field, order) {
		bestPerformingKeywordsSortField = field;
		bestPerformingKeywordsSortOrder = order;
		bestPerformingKeywordsFromLink = true;
		LoadBestPerformingKeywordsGrid();
	}

	function LoadBestPerformingKeywordsGrid() {
		// Load the best performing search keywords and jump to a specific page
		jQuery.ajax({url: 'index.php?ToDo=searchStatsBestPerformingGrid&FromLink='+bestPerformingKeywordsFromLink+'&From=%%GLOBAL_FromStamp%%&To=%%GLOBAL_ToStamp%%&Page='+bestPerformingKeywordsCurrentPage+'&Show='+resultsPerPage+'&SortBy='+bestPerformingKeywordsSortField+'&SortOrder='+bestPerformingKeywordsSortOrder,
			     success: function(data) {
				$('#bestPerformingKeywordsGrid').html(data)
			     }
			}
		);
	}

	function ChangeWorstPerformingKeywordsPerPage(ResultsPerPage) {
		// Change how many results are shown per page
		resultsPerPage = ResultsPerPage;
		worstPerformingKeywordsCurrentPage = 1;
		worstPerformingKeywordsFromLink = true;
		LoadWorstPerformingKeywordsGrid();
	}

	function ChangeWorstPerformingKeywordsPage(Page) {
		// Change which page of results we're viewing
		worstPerformingKeywordsCurrentPage = Page;
		worstPerformingKeywordsFromLink = true;
		LoadWorstPerformingKeywordsGrid();
	}

	function SortWorstPerformingKeywords(field, order) {
		worstPerformingKeywordsSortField = field;
		worstPerformingKeywordsSortOrder = order;
		worstPerformingKeywordsFromLink = true;
		LoadWorstPerformingKeywordsGrid();
	}

	function LoadWorstPerformingKeywordsGrid() {
		// Load the worst performing search keywords and jump to a specific page
		jQuery.ajax({url: 'index.php?ToDo=searchStatsWorstPerformingGrid&FromLink='+worstPerformingKeywordsFromLink+'&From=%%GLOBAL_FromStamp%%&To=%%GLOBAL_ToStamp%%&Page='+worstPerformingKeywordsCurrentPage+'&Show='+resultsPerPage+'&SortBy='+worstPerformingKeywordsSortField+'&SortOrder='+worstPerformingKeywordsSortOrder,
			     success: function(data) {
				$('#worstPerformingKeywordsGrid').html(data)
			     }
			}
		);
	}

	function ChangeSearchCorrectionsPerPage(ResultsPerPage) {
		// Change how many results are shown per page
		resultsPerPage = ResultsPerPage;
		searchCorrectionsCurrentPage = 1;
		searchCorrectionsFromLink = true;
		LoadSearchCorrectionsGrid();
	}

	function ChangeSearchCorrectionsPage(Page) {
		// Change which page of results we're viewing
		searchCorrectionsCurrentPage = Page;
		searchCorrectionsFromLink = true;
		LoadSearchCorrectionsGrid();
	}

	function SortSearchCorrections(field, order) {
		searchCorrectionsSortField = field;
		searchCorrectionsSortOrder = order;
		searchCorrectionsFromLink = true;
		LoadSearchCorrectionsGrid();
	}


	function LoadSearchCorrectionsGrid() {
		// Load the search corrections grid for the page we're viewing
		jQuery.ajax({url: 'index.php?ToDo=searchStatsCorrectionsGrid&FromLink='+searchCorrectionsFromLink+'&From=%%GLOBAL_FromStamp%%&To=%%GLOBAL_ToStamp%%&Page='+searchCorrectionsCurrentPage+'&Show='+resultsPerPage+'&SortBy='+searchCorrectionsSortField+'&SortOrder='+searchCorrectionsSortOrder,
			     success: function(data) {
				$('#searchCorrectionsGrid').html(data)
			     }
			}
		);
	}


	$(document).ready(function() {

		ShowTab(%%GLOBAL_CurrentTab%%);

		// Which date range is selected?
		var current_date = '%%GLOBAL_CurrentDate%%';
		var Calendar = g('Calendar');

		for(i = 0; i < Calendar.options.length; i++) {
			if(Calendar.options[i].value == current_date) {
				Calendar.options[i].selected = true;
				break;
			}
		}

		// Is it custom? If so, show the custom date ranges
		if(current_date == 'Custom') {
			doCustomDate(g('Calendar'), 7);
		}
	});

	function clearStatsClick()
	{
		if(confirm('%%LNG_ConfirmDeleteSearchStats%%'))
			window.location = 'index.php?ToDo=clearSearchStats';
	}
		// zfang_20100623 Poping up datepicker widget
		$(function() {
			$('input.datepicker').datepicker({
				changeMonth: true,
				changeYear: true,
				closeAtTop: false,
				mandatory: true
			});
			doCustomDate(document.getElementById('Calendar'), 7);
		});

	</script>
