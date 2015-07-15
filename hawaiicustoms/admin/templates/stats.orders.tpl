
	<form action="index.php?ToDo=viewOrdStats" name="frmStats" id="frmStats" method="post">
	<input id="currentTab" name="currentTab" value="0" type="hidden">
	<div class="BodyContainer">
	<table cellSpacing="0" cellPadding="0" width="100%" style="margin-left: 4px; margin-top: 8px;">
	<tr>
		<td class="Heading1">%%LNG_OrderStatistics%%</td>
	</tr>
	<tr>
		<td class="Intro">
			<p>%%LNG_OrderStatsIntro%%</p>
			%%GLOBAL_Message%%
		</td>
	</tr>
	<tr>
		<td>
			<ul id="tabnav">
				<li><a href="#" class="active" id="tab0" onclick="ShowTab(0)">%%LNG_OrdersByDate%%</a></li>
				<li><a href="#" id="tab1" onclick="ShowTab(1)">%%LNG_OrdersByNumSold%%</a></li>
				<li><a href="#" id="tab2" onclick="ShowTab(2)">%%LNG_OrdersByRevenue%%</a></li>
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
<td style="background: #eee;" class="dateField">
<span id=customDate7 style="display:none">&nbsp;
										%%GLOBAL_FromDatePicker%%
										<span class=body>%%LNG_To1%%</span>
										%%GLOBAL_ToDatePicker%%
									</span>&nbsp;
</td>
						<td style="background: #eee; padding: 3px 5px; %%GLOBAL_HideVendorList%%" width="1">
							<img src="images/vendor.gif" />
						</td>
						<td style="background: #eee; %%GLOBAL_HideVendorList%%">%%LNG_Vendor%%:</td>
						<td style="background: #eee; padding: 3px 5px; %%GLOBAL_HideVendorList%%" width="1">
							<select name="vendorId">
								%%GLOBAL_VendorSelect%%
							</select>
						</td>
						<td style="background: #eee; padding: 3px 5px;"><input type="submit" value="Go" class="Text" /></td>
					</tr>
				</table>
			</div>
			<div id="div0" style="padding-top:10px" class="text">
				<center>
					<strong>%%GLOBAL_ByDateChartTitle%% <span style="display:%%GLOBAL_HideNoAdvancedStatsMessage%%; color:#CACACA"><br />(%%LNG_NoOrderData2Days%%)</span></strong>
				</center>
				<div id="flashcontent" style="width: 100%; clear: both;">

				</div>
				<script type="text/javascript" src="includes/amcharts/swfobject.js"></script>
				<script type="text/javascript">
					$(document).ready(function() {
						var so = new SWFObject("%%GLOBAL_ShopPath%%/admin/includes/amcharts/amline/amline.swf", "amline", "98%", "430", "8", "#FFFFFF");
						so.addVariable("path", "%%GLOBAL_ShopPath%%/admin/includes/amcharts/");
						so.addVariable("settings_file", escape("%%GLOBAL_ShopPath%%/admin/includes/amcharts/overviewgeneral.xml"));
						so.addVariable("data_file", escape("%%GLOBAL_ShopPath%%/admin/index.php?ToDo=overviewStatsData&from=%%GLOBAL_OverviewFromStamp%%&to=%%GLOBAL_OverviewToStamp%%&vendorId=%%GLOBAL_VendorId%%"));
						so.addVariable("preloader_color", "#000000");
						
						//zfang_20100625 Set mode: opaque
						so.addParam("wmode", "opaque");

						so.write("flashcontent");
					});
				</script>
				<div id="ordersByDateGrid">
				</div>
			</div>
			<div id="div1" style="padding-top:10px; padding-left:10px" class="text">
				<div id="ordersByItemsSoldGrid">
				</div>
			</div>
			<div id="div2" style="padding-top:10px; padidng-left:10px; clear: both;" class="text">
				<table width="100%" border="0">
					<tr>
						<td width="30%" valign="top" class="text">
							<div id="ordersByRevenueGrid">
							</div>
						</td>
						<td width="70%" valign="top" nowrap style="padding-left:10px" class="text">
							<center>
								<strong>%%GLOBAL_ByRevenueChartTitle%%</strong>
							</center>
							<div id="flashcontent1" style="width: 100%; clear: both;">
							</div>
							<script type="text/javascript">
								$(document).ready(function() {
									var so = new SWFObject("includes/amcharts/ampie.swf", "ampie", "100%", "600", "8", "#FFFFFF");
									so.addVariable("path", "includes/amcharts/");
									so.addVariable("settings_file", escape("includes/amcharts/ordersbyrevenue.xml"));
									so.addVariable("data_file", escape("index.php?ToDo=ordStatsByRevenueData&from=%%GLOBAL_OverviewFromStamp%%&to=%%GLOBAL_OverviewToStamp%%&vendorId=%%GLOBAL_VendorId%%"));
									so.addVariable("preloader_color", "#000000");

									//zfang_20100625 Set mode: opaque
									so.addParam("wmode", "opaque");

									so.write("flashcontent1");
								});
							</script>
						</td>
					</tr>
				</table>
			</div>

			</form>
		</td>
	</tr>
	</table>
	</div>

	<script type="text/javascript">

		var ordersPerPage = 20;

		var ordersByDateCurrentPage = 1;
		var ordersByDateFromLink = false;
		var ordersByDateSortField = '';
		var ordersByDateSortOrder = '';

		var ordersByItemsSoldCurrentPage = 1;
		var ordersByItemsSoldFromLink = false;
		var ordersByItemsSoldLoaded = false;
		var ordersByItemsSoldSortField = '';
		var ordersByItemsSoldSortOrder = '';

		var ordersByRevenueLoaded = false;

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
					$('#introText').html('%%LNG_OrdersByDateIntro%%');
					break;
				}
				case 1: {
					$('#introText').html('%%LNG_OrdersByItemsSoldIntro%%');

					if(!ordersByItemsSoldLoaded) {
						LoadOrdersByItemsSoldGrid();
						ordersByItemsSoldLoaded = true;
					}
					break;

				}
				case 2: {
					$('#introText').html('%%LNG_OrdersByRevenueIntro%%');

					if(!ordersByRevenueLoaded) {
						LoadOrdersByRevenueGrid();
						ordersByRevenueLoaded = true;
					}
					break;

				}
			}
		}

		function ChangeOrdersByDatePerPage(OrdersPerPage) {
			// Change how many orders are shown per page
			ordersPerPage = OrdersPerPage;
			ordersByDateCurrentPage = 1;
			ordersByDateFromLink = true;
			LoadOrdersByDateGrid();
		}

		function ChangeOrdersByDatePage(Page) {
			// Change which page of orders we're viewing
			ordersByDateCurrentPage = Page;
			ordersByDateFromLink = true;
			LoadOrdersByDateGrid();
		}

		function SortOrdersByDate(field, order) {
			ordersByDateSortField = field;
			ordersByDateSortOrder = order;
			ordersByDateFromLink = true;
			LoadOrdersByDateGrid();
		}

		function LoadOrdersByDateGrid() {
		
			// Load the orders and jump to a specific page
		
			jQuery.ajax({url: 'index.php?ToDo=ordStatsByDateGrid&FromLink='+ordersByDateFromLink+'&vendorId=%%GLOBAL_VendorId%%&From=%%GLOBAL_FromStamp%%&To=%%GLOBAL_ToStamp%%&Page='+ordersByDateCurrentPage+'&Show='+ordersPerPage+'&SortBy='+ordersByDateSortField+'&SortOrder='+ordersByDateSortOrder,
					 success: function(data) {
					$('#ordersByDateGrid').html(data)
					 }
				}
			);
		}

		function LoadOrdersByItemsSoldGrid() {
			// Load orders by items sold
			jQuery.ajax({url: 'index.php?ToDo=ordStatsByItemsSoldGrid&FromLink='+ordersByItemsSoldFromLink+'&vendorId=%%GLOBAL_VendorId%%&From=%%GLOBAL_FromStamp%%&To=%%GLOBAL_ToStamp%%&Page='+ordersByItemsSoldCurrentPage+'&Show='+ordersPerPage+'&SortBy='+ordersByItemsSoldSortField+'&SortOrder='+ordersByItemsSoldSortOrder,
					 success: function(data) {
					$('#ordersByItemsSoldGrid').html(data)
					 }
				}
			);
		}

		function LoadOrdersByRevenueGrid() {
			// Load orders by revenue
			jQuery.ajax({url: 'index.php?ToDo=ordStatsByRevenueGrid&vendorId=%%GLOBAL_VendorId%%&From=%%GLOBAL_FromStamp%%&To=%%GLOBAL_ToStamp%%',
					 success: function(data) {
					$('#ordersByRevenueGrid').html(data)
					 }
				}
			);
		}

		function ChangeOrdersByItemsSoldPerPage(OrdersPerPage) {
			// Change how many orders are shown per page
			ordersPerPage = OrdersPerPage;
			ordersByItemsSoldCurrentPage = 1;
			ordersByItemsSoldFromLink = true;
			LoadOrdersByItemsSoldGrid();
		}

		function ChangeOrdersByItemsSoldPage(Page) {
			// Change which page of orders we're viewing
			ordersByItemsSoldCurrentPage = Page;
			ordersByItemsSoldFromLink = true;
			LoadOrdersByItemsSoldGrid();
		}

		function SortOrdersByItemsSold(field, order) {
			ordersByItemsSoldSortField = field;
			ordersByItemsSoldSortOrder = order;
			ordersByItemsSoldFromLink = true;
			LoadOrdersByItemsSoldGrid();
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

			// Load the orders table for the selected date range
			LoadOrdersByDateGrid();
		});

		// zfang_20100622 Poping up datepicker widget
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
