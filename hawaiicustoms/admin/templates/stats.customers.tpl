
	<form action="index.php?ToDo=viewCustStats" name="frmStats" id="frmStats" method="post">
	<input id="currentTab" name="currentTab" value="0" type="hidden">
	<div class="BodyContainer">
	<table cellSpacing="0" cellPadding="0" width="100%" style="margin-left: 4px; margin-top: 8px;">
	<tr>
		<td class="Heading1">%%LNG_CustomerStatistics%%</td>
	</tr>
	<tr>
		<td class="Intro">
			<p>%%LNG_CustomerStatsIntro%%</p>
			%%GLOBAL_Message%%
		</td>
	</tr>
	<tr>
		<td>
			<ul id="tabnav">
				<li><a href="#" class="active" id="tab0" onclick="ShowTab(0)">%%LNG_CustomersByDate%%</a></li>
				<li><a href="#" id="tab1" onclick="ShowTab(1)">%%LNG_RevenuePerCustomer%%</a></li>
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
			<div id="div0" style="padding-top:10px" class="text">
				<center>
					<strong><span style="display:%%GLOBAL_HideNoAdvancedStatsMessage%%; color:#CACACA"><br />(%%LNG_NoOrderData2Days%%)</span></strong>
				</center>
				<div id="flashcontent" style="width: 100%; clear: both;">
				</div>
				<script type="text/javascript" src="%%GLOBAL_ShopPath%%/admin/includes/amcharts/swfobject.js"></script>
				<script type="text/javascript">
					$(document).ready(function() {
						var so = new SWFObject("%%GLOBAL_ShopPath%%/admin/includes/amcharts/amline/amline.swf", "amline", "98%", "430", "8", "#FFFFFF");
						so.addVariable("path", "%%GLOBAL_ShopPath%%/admin/includes/amcharts/");
						so.addVariable("settings_file", escape("%%GLOBAL_ShopPath%%/admin/includes/amcharts/customersbydate.xml"));
						so.addVariable("data_file", escape("%%GLOBAL_ShopPath%%/admin/index.php?ToDo=custStatsByDateData&from=%%GLOBAL_OverviewFromStamp%%&to=%%GLOBAL_OverviewToStamp%%"));
						so.addVariable("preloader_color", "#000000");

						//zfang_20100625 Set mode: opaque
						so.addParam("wmode", "opaque");

						so.write("flashcontent");
					});
				</script>
				<div id="customersByDateGrid">
				</div>
			</div>
			<div id="div1" style="padding-top:10px; padding-left:10px" class="text">
				<div id="revenuePerCustomerGrid">
				</div>
			</div>

			</form>
		</td>
	</tr>
	</table>
	</div>

	<script type="text/javascript">

	var customersPerPage = 20;

	var customersByDateFromLink = false;
	var customersByDateCurrentPage = 1;
	var customersByDateSortField = '';
	var customersByDateSortOrder = '';

	var revenuePerCustomerLoaded = false;
	var revenuePerCustomerFromLink = false;
	var revenuePerCustomerCurrentPage = 1;
	var revenuePerCustomerSortField = '';
	var revenuePerCustomerSortOrder = '';

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
				$('#introText').html('%%LNG_CustomersByDateIntro%%');
				break;
			}
			case 1: {
				$('#introText').html('%%LNG_RevenuePerCustomerIntro%%');

				if(!revenuePerCustomerLoaded) {
					LoadRevenuePerCustomerGrid();
					revenuePerCustomerLoaded = true;
				}
				break;

			}
		}
	}

	function ChangeCustomersByDatePerPage(CustomersPerPage) {
		// Change how many customers are shown per page
		customersPerPage = CustomersPerPage;
		customersByDateCurrentPage = 1;
		customersByDateFromLink = true;
		LoadCustomersByDateGrid();
	}

	function ChangeCustomersByDatePage(Page) {
		// Change which page of customers we're viewing
		customersByDateCurrentPage = Page;
		customersByDateFromLink = true;
		LoadCustomersByDateGrid();
	}

	function SortCustomersByDate(field, order) {
		customersByDateSortField = field;
		customersByDateSortOrder = order;
		customersByDateFromLink = true;
		LoadCustomersByDateGrid();
	}

	function LoadCustomersByDateGrid() {
		// Load the customers and jump to a specific page
		jQuery.ajax({url: 'index.php?ToDo=custStatsByDateGrid&FromLink='+customersByDateFromLink+'&From=%%GLOBAL_FromStamp%%&To=%%GLOBAL_ToStamp%%&Page='+customersByDateCurrentPage+'&Show='+customersPerPage+'&SortBy='+customersByDateSortField+'&SortOrder='+customersByDateSortOrder,
			     success: function(data) {
				$('#customersByDateGrid').html(data)
			     }
			}
		);
	}

	function LoadRevenuePerCustomerGrid() {
		// Load revenue per customer
		jQuery.ajax({url: 'index.php?ToDo=custStatsByRevenueGrid&FromLink='+revenuePerCustomerFromLink+'&From=%%GLOBAL_FromStamp%%&To=%%GLOBAL_ToStamp%%&Page='+revenuePerCustomerCurrentPage+'&Show='+customersPerPage+'&SortBy='+revenuePerCustomerSortField+'&SortOrder='+revenuePerCustomerSortOrder,
			     success: function(data) {
				$('#revenuePerCustomerGrid').html(data)
			     }
			}
		);
	}

	function SortRevenuePerCustomer(field, order) {
		revenuePerCustomerSortField = field;
		revenuePerCustomerSortOrder = order;
		revenuePerCustomerFromLink = true;
		LoadRevenuePerCustomerGrid();
	}

	function ChangeRevenuePerCustomerPage(Page) {
		// Change which page of orders we're viewing
		revenuePerCustomerCurrentPage = Page;
		revenuePerCustomerFromLink = true;
		LoadRevenuePerCustomerGrid();
	}


	function ChangeCustomersByRevenuePerPage(CustomersPerPage) {
		// Change how many customers are shown per page
		customersPerPage = CustomersPerPage;
		revenuePerCustomerCurrentPage = 1;
		revenuePerCustomerFromLink = true;
		LoadRevenuePerCustomerGrid();
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
		// Load the customers table for the selected date range
		LoadCustomersByDateGrid();

	});

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
