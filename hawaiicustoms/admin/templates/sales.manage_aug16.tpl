
<div class="BodyContainer">
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
        <form method="post" action="index.php?ToDo=viewSales" name="frmSales">
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
                          <td>Select User : <select name="searchQuery" id="searchQuery">
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
</div>

	<script type="text/javascript">
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
					break;
				}
				case 1: {
					$('#dateBlock .dateField').hide();
					$('#dateBlock').hide();
					break;
				}
			}
		}

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