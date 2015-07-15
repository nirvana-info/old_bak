
	<form action="index.php?ToDo=viewProdStats" name="frmStats" id="frmStats" method="post">
	<input id="currentTab" name="currentTab" value="0" type="hidden">
	<div class="BodyContainer">
	<table cellSpacing="0" cellPadding="0" width="100%" style="margin-left: 4px; margin-top: 8px;">
	<tr>
		<td class="Heading1">%%LNG_ProductStatistics%%</td>
	</tr>
	<tr>
		<td class="Intro">
			<p>%%LNG_ProductStatsIntro%%</p>
			%%GLOBAL_Message%%
		</td>
	</tr>
	<tr>
		<td>
			<ul id="tabnav">
				<li><a href="#" class="active" id="tab0" onclick="ShowTab(0)">%%LNG_ProductsByNumberSold%%</a></li>
				<li><a href="#" id="tab1" onclick="ShowTab(1)">%%LNG_MostViewedProducts%%</a></li>
				<li style="display: %%GLOBAL_HideInventoryTab%%;"><a href="#" id="tab2" onclick="ShowTab(2)">%%LNG_InventoryReport%%</a></li>
			</ul>
		</td>
	</tr>
	<tr>
		<td>
			<br />
			<div id="introText" style="padding:0px 0px 5px 10px" class="Text"></div>
			<div id="dateBlock" style="padding:5px 0px 5px 10px" class="Text FloatLeft">
				<table border=0 cellspacing=0 cellpadding=0>
					<tr>
						<td style="background: #eee; padding: 3px 5px;" width="1" class="dateField">
							<img src="images/dateicon.gif" />
						</td>
						<td style="background: #eee;" class="dateField">Date Range:</td>
						<td style="background: #eee; padding: 3px 5px;" width="1" class="dateField">
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
						<td style="background: #eee;" class="dateField">
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
			<div id="div0" style="padding-top:10px; padding-left:10px" class="text">
				<div id="productsByNumSoldGrid">
				</div>
			</div>
			<div id="div1" style="padding-top:10px; padding-left:10px" class="text">
				<div id="productsByNumViewsGrid">
				</div>
			</div>
			<div id="div2" style="padding-top:10px; padding-left:10px; display: %%GLOBAL_HideInventoryTab%%;" class="text">
				<div id="productsByInventoryGrid">
				</div>
			</div>
			</form>
		</td>
	</tr>
	</table>
	</div>

	<script type="text/javascript">

		var productsPerPage = 20;

		var productsByNumSoldCurrentPage = 1;
		var productsByNumSoldLoaded = false;
		var productsByNumSoldSortField = '';
		var productsByNumSoldSortOrder = '';

		var productsByNumViewsCurrentPage = 1;
		var productsByNumViewsLoaded = false;
		var productsByNumViewsSortField = '';
		var productsByNumViewsSortOrder = '';

		var productsByInventoryCurrentPage = 1;
		var productsByInventoryLoaded = false;
		var productsByInventorySortField = '';
		var productsByInventorySortOrder = '';

		var showProductInventory = '%%GLOBAL_ShowInventoryGrid%%';

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
					$('#introText').html('%%LNG_ProductsByNumSoldIntro%%');
					$('#dateBlock .dateField').show();
					if(!productsByNumSoldLoaded) {
						LoadProductsByNumSoldGrid();
						productsByNumSoldLoaded = true;
					}
					break;
				}
				case 1: {
					$('#introText').html('%%LNG_ProductsByNumViewsIntro%%');
					$('#dateBlock .dateField').hide();
					if(!productsByNumViewsLoaded) {
						LoadProductsByNumViewsGrid();
						productsByNumViewsLoaded = true;
					}
				}
				case 2: {
					if (showProductInventory !== '1') {
						break;
					}
					
					$('#introText').html('%%LNG_ProductsByInventoryIntro%%');
					$('#dateBlock .dateField').hide();
					if(!productsByInventoryLoaded) {
						LoadProductsByInventoryGrid();
						productsByInventoryLoaded = true;
					}
				}
			}
		}

		function ChangeProductsByNumSoldPerPage(ProductsPerPage) {
			// Change how many products are shown per page
			productsPerPage = ProductsPerPage;
			productsByNumSoldCurrentPage = 1;
			LoadProductsByNumSoldGrid();
		}

		function ChangeProductsByNumSoldPage(Page) {
			// Change which page of orders we're viewing
			productsByNumSoldCurrentPage = Page;
			LoadProductsByNumSoldGrid();
		}

		function SortProductsByNumSold(field, order) {
			productsByNumSoldSortField = field;
			productsByNumSoldSortOrder = order;
			LoadProductsByNumSoldGrid();
		}

		function ChangeProductsByNumViewsPerPage(ProductsPerPage) {
			// Change how many products are shown per page
			productsPerPage = ProductsPerPage;
			productsByNumViewsCurrentPage = 1;
			LoadProductsByNumViewsGrid();
		}

		function ChangeProductsByNumViewsPage(Page) {
			// Change which page of orders we're viewing
			productsByNumViewsCurrentPage = Page;
			LoadProductsByNumViewsGrid();
		}

		function SortProductsByNumViews(field, order) {
			productsByNumViewsSortField = field;
			productsByNumViewsSortOrder = order;
			LoadProductsByNumViewsGrid();
		}

		function ChangeProductsByInventoryPerPage(ProductsPerPage) {
			// Change how many products are shown per page
			productsPerPage = ProductsPerPage;
			productsByInventoryCurrentPage = 1;
			LoadProductsByInventoryGrid();
		}

		function ChangeProductsByInventoryPage(Page) {
			// Change which page of orders we're viewing
			productsByInventoryCurrentPage = Page;
			LoadProductsByInventoryGrid();
		}

		function SortProductsByInventory(field, order) {
			productsByInventorySortField = field;
			productsByInventorySortOrder = order;
			LoadProductsByInventoryGrid();
		}

		function LoadProductsByNumSoldGrid() {

			jQuery.ajax({url: 'index.php?ToDo=prodStatsByNumSoldGrid&vendorId=%%GLOBAL_VendorId%%&From=%%GLOBAL_FromStamp%%&To=%%GLOBAL_ToStamp%%&Page='+productsByNumSoldCurrentPage+'&Show='+productsPerPage+'&SortBy='+productsByNumSoldSortField+'&SortOrder='+productsByNumSoldSortOrder,
					 success: function(data) {
					$('#productsByNumSoldGrid').html(data);
					 }
				}
			);
		}

		function LoadProductsByNumViewsGrid() {

			jQuery.ajax({url: 'index.php?ToDo=prodStatsByNumViewsGrid&vendorId=%%GLOBAL_VendorId%%&Page='+productsByNumViewsCurrentPage+'&Show='+productsPerPage+'&SortBy='+productsByNumViewsSortField+'&SortOrder='+productsByNumViewsSortOrder,
					 success: function(data) {
					$('#productsByNumViewsGrid').html(data);
					 }
				}
			);
		}

		function LoadProductsByInventoryGrid() {
			if (showProductInventory !== '1') {
				return;
			}

			jQuery.ajax({url: 'index.php?ToDo=prodStatsByInventoryGrid&vendorId=%%GLOBAL_VendorId%%&Page='+productsByInventoryCurrentPage+'&Show='+productsPerPage+'&SortBy='+productsByInventorySortField+'&SortOrder='+productsByInventorySortOrder,
					 success: function(data) {
					$('#productsByInventoryGrid').html(data);
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

	</script>
