
	<form action="index.php?ToDo=viewStats" name="frmStats" id="frmStats" method="post">
	<input id="currentTab" name="currentTab" value="0" type="hidden">
	<div class="BodyContainer">
	<table cellSpacing="0" cellPadding="0" width="100%" style="margin-left: 4px; margin-top: 8px;">
	<tr>
		<td class="Heading1">%%LNG_StoreOverview%%</td>
	</tr>
	<tr>
		<td class="Intro">
			<p>%%LNG_StoreOverviewIntro%%</p>
			%%GLOBAL_Message%%
		</td>
	</tr>
	<tr>
		<td>
			<ul id="tabnav">
				<li><a href="#" class="active" id="tab0" onclick="ShowTab(0)">%%LNG_StoreSnapshot%%</a></li>
				<li><a href="#" id="tab1" onclick="ShowTab(1)">%%LNG_Top20Customers%%</a></li>
				<li><a href="#" id="tab2" onclick="ShowTab(2)">%%LNG_BestSellingProducts%%</a></li>
				<li><a href="#" id="tab3" onclick="ShowTab(3)">%%LNG_OrderLocations%%</a></li>
			</ul>
		</td>
	</tr>
	<tr>
		<td>
			<br />
			<div id="introText" style="padding:0px 0px 5px 10px" class="Text"></div>
			<div style="padding:5px 0px 5px 10px" class="Text">
				<form name="customDateForm" method="post" action="index.php?Page=stats&Action=ProcessCalendar&SubAction=List&NextAction=ViewSummary&list=11" style="margin: 0px;">
					<table border=0 cellspacing=0 cellpadding=0>
						<tr>
							<td style="background: #eee; padding: 3px 5px;" width="1">
								<img src="images/dateicon.gif" />
							</td>
							<td style="background: #eee;">Date Range:</td>
							<td style="background: #eee; padding: 3px 5px;" width="1">
								<select name="Calendar[DateType]" id="Calendar" class="CalendarSelect" onchange="doCustomDate(this, 7)">
									<option value="Today">%%LNG_Today%%</option>
									<option value="Yesterday">%%LNG_Yesterday%%</option>
									<option value="Last24Hours">%%LNG_Last24Hours%%</option>
									<option value="Last7Days">%%LNG_Last7Days%%</option>
									<option value="Last30Days">%%LNG_Last30Days%%</option>
									<option value="ThisMonth">%%LNG_ThisMonth%%</option>
									<option value="LastMonth">%%LNG_LastMonth%%</option>
									<option value="AllTime" SELECTED>%%LNG_AllTime%%</option>
									<option value="Custom">%%LNG_Custom%%</option>
								</select>
							</td>
							<td style="background: #eee;">
								<span id=customDate7 style="display:none">&nbsp;
								<select name="Calendar[From][Day]" class="CalendarSelectSmall" style="margin-bottom:3px">
									%%GLOBAL_OverviewFromDays%%
								</select>
								<select name="Calendar[From][Mth]" class="CalendarSelectSmall" style="margin-bottom:3px">
									%%GLOBAL_OverviewFromMonths%%
								</select>
								<select name="Calendar[From][Yr]" class="CalendarSelectSmall" style="margin-bottom:3px">
									%%GLOBAL_OverviewFromYears%%
								</select>
								<span class=body>%%LNG_To1%%</span>
								<select name="Calendar[To][Day]" class="CalendarSelectSmall" style="margin-bottom:3px">
									%%GLOBAL_OverviewToDays%%
								</select>
								<select name="Calendar[To][Mth]" class="CalendarSelectSmall" style="margin-bottom:3px">
									%%GLOBAL_OverviewToMonths%%
								</select>
								<select name="Calendar[To][Yr]" class="CalendarSelectSmall" style="margin-bottom:3px">
									%%GLOBAL_OverviewToYears%%
								</select>
								</span>&nbsp;
							</td>
							<td style="background: #eee; padding: 3px 5px;"><input type="submit" value="Go" class="Text" /></td>
						</tr>
					</table>
				</form>
			</div>
			<div id="div0" style="padding-top:10px">
				<table width="100%" border="0" class="text" style="padding-left:10px">
					<tr>
						<td valign=top width="250" nowrap>
							<div class="MidHeading" style="width:100%"><img src="images/order.gif" align="absMiddle">&nbsp;Order Summary</div>
							<ul class="Text">
								<li>%%LNG_TotalRevenue%%: %%GLOBAL_OverviewOrderTotal%%</li>
								<li>%%LNG_UniqueVisitors%%: %%GLOBAL_OverviewUniqueVisitors%%</li>
								<li>%%LNG_CompletedOrders%%: %%GLOBAL_OverviewOrderCount%%</li>
								<li>%%LNG_ConversionRate%%: %%GLOBAL_OverviewConversionRate%%</li>
							</ul>
						</td>
						<td width="100%" align="center">
							<strong>%%GLOBAL_ChartTitle%% <span style="display:%%GLOBAL_HideNoAdvancedStatsMessage%%; color:#CACACA"><br />(%%LNG_NoOrderData2Days%%)</span></strong>
							<div id="flashcontent">

							</div>
							<script type="text/javascript" src="includes/amcharts/swfobject.js"></script>
							<script type="text/javascript">
								$(document).ready(function() {
									var so = new SWFObject("%%GLOBAL_ShopPath%%/admin/includes/amcharts/amline/amline.swf", "amline", "98%", "430", "8", "#FFFFFF");
									so.addVariable("path", "%%GLOBAL_ShopPath%%/admin/includes/amcharts/");
									so.addVariable("wmode", "transparent");
									so.addVariable("settings_file", escape("%%GLOBAL_ShopPath%%/admin/includes/amcharts/overviewgeneral.xml"));
									so.addVariable("data_file", escape("%%GLOBAL_ShopPath%%/admin/index.php?ToDo=overviewStatsData&from=%%GLOBAL_OverviewFromStamp%%&to=%%GLOBAL_OverviewToStamp%%"));
									so.addVariable("preloader_color", "#000000");
									so.write("flashcontent");
								});
							</script>
						</td>
					</tr>
				</table>
			</div>
			<div id="div1" style="padding-top:10px; padding-left:10px">
				<table border="0" cellspacing="0" cellpadding="0" width="100%" class="text">
					<tr>
						<td width="40%" valign="top">
							%%GLOBAL_TopCustomersGrid%%
						</td>
						<td width="60%" valign="top">

							<div id="flashcontent1" style="width: 100%; border: solid 0px black; display:%%GLOBAL_HideTop20CustomersChart%%">

							</div>
							<script type="text/javascript" src="includes/amcharts/swfobject.js"></script>
							<script type="text/javascript">
								$(document).ready(function() {
									var so = new SWFObject("%%GLOBAL_ShopPath%%/admin/includes/amcharts/ampie.swf", "ampie", "100%", "400", "8", "#FFFFFF");
									so.addVariable("path", "%%GLOBAL_ShopPath%%/admin/includes/amcharts/");
									so.addVariable("settings_file", escape("%%GLOBAL_ShopPath%%/admin/includes/amcharts/top20customers.xml"))
									so.addVariable("data_file", escape("%%GLOBAL_ShopPath%%/admin/index.php?ToDo=overviewStatsTop20CustData&from=%%GLOBAL_OverviewFromStamp%%&to=%%GLOBAL_OverviewToStamp%%"));
									so.addVariable("preloader_color", "#999999");
									so.write("flashcontent1");
								});
							</script>
						</td>
					</tr>
				</table>
			</div>
			<div id="div2" style="padding-top:10px; padidng-left:10px">
				<table border="0" cellspacing="0" cellpadding="0" width="100%" class="text" style="padding-left:10px">
					<tr>
						<td width="40%" valign="top">
							%%GLOBAL_TopProductsGrid%%
						</td>
						<td width="60%" valign="top">

							<div id="flashcontent2" style="width: 100%; border: solid 0px black; display:%%GLOBAL_HideTop20ProductsChart%%">

							</div>
							<script type="text/javascript">
								//<![CDATA[
								$(document).ready(function() {
									var so = new SWFObject("%%GLOBAL_ShopPath%%/admin/includes/amcharts/ampie.swf", "ampie", "100%", "400", "8", "#FFFFFF");
									so.addVariable("path", "%%GLOBAL_ShopPath%%/admin/includes/amcharts/");
									so.addVariable("settings_file", escape("%%GLOBAL_ShopPath%%/admin/includes/amcharts/top20products.xml"))
									so.addVariable("data_file", escape("%%GLOBAL_ShopPath%%/admin/index.php?ToDo=overviewStatsTop20Prods&from=%%GLOBAL_OverviewFromStamp%%&to=%%GLOBAL_OverviewToStamp%%"));
									so.addVariable("preloader_color", "#999999");
									so.write("flashcontent2");
								});
								//]]>
							</script>
						</td>
					</tr>
				</table>
			</div>

			<div id="div3" style="padding-top:10px; padding-left:10px">
				<iframe id="orderMap" style="width:100%; height:600px; border:0px" frameborder="none"></iframe>
			</div>
			</form>
		</td>
	</tr>
	</table>
	</div>

	<script type="text/javascript">

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
				$('#introText').html('%%GLOBAL_IntroText0%%');
				break;

			}
			case 1: {
				$('#introText').html('%%GLOBAL_IntroText1%%');
				break;

			}
			case 2: {
				$('#introText').html('%%GLOBAL_IntroText2%%');
				break;

			}
			case 3: {
				$('#introText').html('%%GLOBAL_IntroText3%%');
				if(g('orderMap').src == '' && "%%GLOBAL_GoogleMapsAPIKey%%" != "") {
					g('orderMap').src = "index.php?ToDo=overviewStatsOrdLocationChart&from=%%GLOBAL_FromStamp%%&to=%%GLOBAL_ToStamp%%";
				}
				break;
			}
		}
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

	</script>
