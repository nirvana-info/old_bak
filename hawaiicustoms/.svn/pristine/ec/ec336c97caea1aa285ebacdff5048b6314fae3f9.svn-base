
	<div class="BodyContainer">
	<table id="Table13" cellSpacing="0" cellPadding="0" width="100%">
		<tr>
			<td class="Heading1">%%LNG_ViewChangesReport%%</td>
		</tr>
		<tr>
		<td class="Intro">
			<p>%%GLOBAL_ChangesReportIntro%%</p>
			%%GLOBAL_Message%%
			<!--<table id="IntroTable" cellspacing="0" cellpadding="0" width="100%">
			<tr>
			<td class="Intro" valign="top">
				<input type="button" name="IndexAddButton" value="%%LNG_AddBrand%%" id="IndexCreateButton" class="SmallButton" onclick="document.location.href='index.php?ToDo=addBrand'" /> &nbsp;<input type="button" name="IndexDeleteButton" value="%%LNG_DeleteSelected%%" id="IndexDeleteButton" class="SmallButton" onclick="ConfirmDeleteSelected()" %%GLOBAL_DisableDelete%% />
			</td>
			<td class="SmallSearch" align="right">
				<table id="Table16" style="display:%%GLOBAL_DisplaySearch%%">
				<tr>
					<form action="index.php?ToDo=viewBrands%%GLOBAL_SortURL%%" method="get" onSubmit="return ValidateForm(CheckSearchForm)">
					<input type="hidden" name="ToDo" value="viewBrands">
					<td nowrap>
						<input name="searchQuery" id="searchQuery" type="text" value="%%GLOBAL_Query%%" id="SearchQuery" class="Button" size="20" />&nbsp;
						<input type="image" name="SearchButton" style="padding-left: 10px; vertical-align: top;" id="SearchButton" src="images/searchicon.gif" border="0" />
					</td>
					</form>
				</tr>
				<tr>
					<td align="right" style="padding-right:55pt">
						%%GLOBAL_ClearSearchLink%%
					</td>
				</tr>
				<tr>
					<td></td>
				</tr>
				</table>
			</td>
			</tr>
			</table>-->
		</td>
		</tr>
        <tr>
        <td>
           <select name="days" onchange="loadReport(this.value)">
              <option value="15" selected="selected">Last 15 Days</option>
              <option value="30">Last 30 Days</option>   
           </select> 
        </td>
        </tr>
		<tr>
		<td style="display: %%GLOBAL_DisplayGrid%%">
			<form name="frmChangesReports" id="frmChangesReports" method="post" action="index.php?ToDo=deleteChangesReports">
				<div class="GridContainer">
					%%GLOBAL_ChangesReportDataGrid%%
				</div>
			</form>
		</td></tr>
	</table>
	</div>
    
    <script type="text/javascript">
        
        function loadReport(days) 
        {
            $('.GridContainer').load('%%GLOBAL_PageAdminLink%%/admin/index.php?ToDo=viewChangesReport&days='+days+'&ajax=1', '', function() {
                BindAjaxGridSorting();
            });
            return false;
        }
    
    </script>