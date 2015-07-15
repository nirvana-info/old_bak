
    <form action="index.php?ToDo=viewSalesStats" name="frmStats" id="frmStats" method="post">
    <input id="currentTab" name="currentTab" value="0" type="hidden">
    <div class="BodyContainer">
    <table cellSpacing="0" cellPadding="0" width="100%" style="margin-left: 4px; margin-top: 8px;">
    <tr>
        <td class="Heading1">Sales Statistics</td>
    </tr>
    <tr>
        <td class="Intro">
            <p>Orders according to their respective are shown below. Click the plus icon next to an order to see its complete details.</p>
            %%GLOBAL_Message%%
        </td>
    </tr>
    <tr>
        <td>
            <ul id="tabnav">
                <li><a href="#" class="active" id="tab0" onclick="ShowTab(0)">Overview</a></li>
                <li><a href="#" id="tab1" onclick="ShowTab(1)">Sales by user</a></li>
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
                        <td style="background: #eee; padding: 3px 5px;"><input type="submit" value="Go" class="Text" /></td>
                    </tr>
                </table>
            </div>
            <div id="div0" style="padding-top:10px; padding-left:10px" class="text">
                <div id="OverviewNumGrid">
                </div>
            </div>
            <div id="div1" style="padding-top:10px; padding-left:10px" class="text">
            <img src="images/vendor.gif">&nbsp;Select User :
                <select id="vendorId" name="vendorId" onchange="submitForm();">
                    %%GLOBAL_VendorList%%
                </select>
                <!--Show By:
                <select id="showby" name="showby" onchange="submitForm();">    
                    <option value="products" %%GLOBAL_ProdSel%%>Products</option>
                    <option value="category" %%GLOBAL_CatSel%% selected="selected">Category</option>
                    <option value="subcategory" %%GLOBAL_SubcatSel%%>Subcategory</option>
                    <option value="brand" %%GLOBAL_BrandSel%%>Brand</option> 
                    <option value="series" %%GLOBAL_SeriesSel%%>Series</option>      
                </select>-->
                <div id="salesByNumViewsGrid">
                </div>
            </div>
            </form>
        </td>
    </tr>
    </table>
    </div>

    
<!--<div class="BodyContainer">
  <table id="Table13" cellSpacing="0" cellPadding="0" width="100%">
    <tr>
      <td><ul id="tabnav">
          <li><a href="#"  id="tab0" class="active" onclick="ShowTab(0)">Overview</a></li>
          <li><a href="#" id="tab1"  onclick="ShowTab(1)">Sales by user</a></li>
        </ul></td>
    </tr>
    <tr>
      <td style="height:30px;"></td>
    </tr>
    <tr>
        <form method="post" action="index.php?ToDo=viewSalesStats" name="frmSales">
        <td>
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
                <td style="background: #eee; padding: 3px 5px;"><input type="submit" value="Go" class="dateField" /></td>
            </tr>
        </table>
        </td>
        </form>
    </tr>
    <tr>
      <td colspan="20" width="100%">
      
      <div id="div0">        
      %%GLOBAL_UserDataGrid%%
        <div id="OverviewNumGrid">
        </div>
        </div>
        <div id="div1" style="display:none">
        
        <table width="100%">
          <tr>
            <td class="Heading1"> Current User : <a href="#" style="color:#005FA3">%%GLOBAL_CurrentVendor%%</a> </td>
          </tr>
          <tr>
            <td class="Intro"><p>%%LNG_OrderInfoSales%%</p>
              <div id="OrdersStatus"> %%GLOBAL_Message%% </div>
              <table id="IntroTable" cellspacing="0" cellpadding="0" width="100%" border="0">
                <tr>
                  <td class="SmallSearch" align="left"><table id="Table16" style="display:%%GLOBAL_DisplaySearch%%">
                      <form name="frmOrders" id="frmOrders" action="index.php?ToDo=viewOrders%%GLOBAL_SortURL%%" method="get">
                        <tr>
                          <input type="hidden" name="ToDo" value="viewSales">
			  <input type="hidden" name="From" value="%%GLOBAL_FromStamp%%">
                              %%GLOBAL_VendorList%%
                            </select></td>
                          <td><input type="submit" value="Fetch" class="FormButton"  />
                            <input type="hidden" name="CurrentVendor" value="%%GLOBAL_CurrentVendor%%" />
                          </td>
                        </tr>
                      </form>
                    </table></td>
                </tr>
                <tr>
                  <td style="display: %%GLOBAL_DisplayGrid%%"><form name="frmOrders1" id="frmOrders1" method="post" action="index.php?ToDo=deleteOrders">
                      <div class="GridContainer" id="GridContainer"> %%GLOBAL_OrderDataGrid%% </div>
                      <input id="currentTab" name="currentTab" value="0" type="hidden">
                    </form></td>
                </tr>
              </table></td>
          </tr>
        </table>
        </div>
        
        </td>
    </tr>
  </table>
</div>
<div id="ViewsMenu" class="DropDownMenu DropShadow" style="display: none; width:200px">
  <ul>
    %%GLOBAL_CustomSearchOptions%%
  </ul>
  <hr />
  <ul>
    <li><a href="index.php?ToDo=createOrderView" style="background-image:url('images/view_add.gif'); background-repeat:no-repeat; background-position:5px 5px; padding-left:28px">%%LNG_CreateANewView%%</a></li>
    <li style="display:%%GLOBAL_HideDeleteViewLink%%"><a onclick="$('#ViewsMenu').hide(); confirm_delete_custom_search('%%GLOBAL_CustomSearchId%%')" href="javascript:void(0)" style="background-image:url('images/view_del.gif'); background-repeat:no-repeat; background-position:5px 5px; padding-left:28px">%%LNG_DeleteThisView%%</a></li>
  </ul>
</div> -->

	<script type="text/javascript">
    var productsPerPage = 20;
    
    var overviewNumLoaded = false;
    var overviewNumCurrentPage = 1;
    var overviewNumSortField = '';
    var overviewNumSortOrder = '';
    
    var salesViewsLoaded = false;
    var salesByNumViewsCurrentPage = 1;
    var salesByNumViewsSortField = '';
    var salessByNumViewsSortOrder = '';
    
		%%GLOBAL_AJAXVALUE%%
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
					$('#dateBlock .dateField').show();
					$('#dateBlock').show();
                    if(!overviewNumLoaded) {
                        LoadOverviewNumGrid();
                        overviewNumLoaded = true;
                    }
					break;
				}
				case 1: {
					$('#dateBlock .dateField').show();
					$('#dateBlock').show();
                    if(!salesViewsLoaded) {
                        LoadSalesbyUserGrid();
                        salesViewsLoaded = true;
                    }
					break;
				}
			}
		}
        /**/
        function LoadOverviewNumGrid() {
            jQuery.ajax({url: 'index.php?ToDo=overviewynumgridstats&From=%%GLOBAL_FromStamp%%&To=%%GLOBAL_ToStamp%%&Page='+overviewNumCurrentPage+'&Show='+productsPerPage+'&SortBy='+overviewNumSortField+'&SortOrder='+overviewNumSortOrder,
                     success: function(data) {
                    $('#OverviewNumGrid').html(data);
                     }
                }
            );
        }
        function ChangeSalesByUserPage(Page) {
            // Change which page of orders we're viewing
            overviewNumCurrentPage = Page;
            LoadOverviewNumGrid();
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
        
        function LoadSalesbyUserGrid() {
            var vendorId = document.getElementById('vendorId').value;
            jQuery.ajax({url: 'index.php?ToDo=salesStatsviewsGridstats&From=%%GLOBAL_FromStamp%%&To=%%GLOBAL_ToStamp%%&Page='+salesByNumViewsCurrentPage+'&Show='+productsPerPage+'&SortBy='+salesByNumViewsSortField+'&SortOrder='+salessByNumViewsSortOrder+'&vendorId='+vendorId,
                     success: function(data) {
                    $('#salesByNumViewsGrid').html(data);
                     }
                }
            );
        }
        
        function ChangeSalesViewsPage(Page) {
            // Change which page of orders we're viewing
            salesByNumViewsCurrentPage = Page;
            LoadSalesbyUserGrid();
        }
        
        function SortSalesByNumViews(field, order) {
            salesByNumViewsSortField = field;
            salessByNumViewsSortOrder = order;
            LoadSalesbyUserGrid();
        }
        
        function submitForm()   {                               
            LoadSalesbyUserGrid();
        }
	
        /**/

	$(function() {
            $('input.datepicker').datepicker({
                changeMonth: true,
                changeYear: true,
                closeAtTop: false,
                mandatory: true
            });
            doCustomDate(document.getElementById('Calendar'), 7);
        })

	</script>