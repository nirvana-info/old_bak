
	<div class="BodyContainer">
	<table id="Table13" cellSpacing="0" cellPadding="0" width="100%">
		<tr>
			<td class="Heading1">
				<!--zcs=>
				%%LNG_View%%: <a href="#" style="color:#005FA3" id="ViewsMenuButton" class="PopDownMenu">%%GLOBAL_ViewName%% <img width="8" height="5" src="images/arrow_blue.gif" border="0" /></a>
				<=zcs-->
				%%LNG_View%%: <a href="#" style="color:#005FA3" id="ViewsMenuButton">%%GLOBAL_ViewName%%</a>
			</td>
		</tr>
		<tr>
		<td class="Intro">
			<p>%%GLOBAL_AddonProductIntro%%</p>
			<div id="NotifyMessage">
				%%GLOBAL_NotifyMessage%%
			</div>
			<div id="AddonProductStatus">
				%%GLOBAL_Message%%
			</div>
			<div style="background-color: rgb(244, 244, 244); display:none" class="MessageBox MessageBoxSuccess" id="CustomerGroupMessage"></div>
			<table id="IntroTable" cellspacing="0" cellpadding="0" width="100%">
			<tr>
			<td class="Intro" valign="top">
				<input type="button" name="IndexAddButton" value="%%LNG_CreateAddonProduct%%..." id="IndexCreateButton" class="SmallButton" onclick="document.location.href='index.php?ToDo=CreateAddonProduct'" /> &nbsp;
				<input type="button" name="IndexDeleteButton" value="%%LNG_DeleteSelected%%" id="IndexDeleteButton" class="SmallButton" onclick="ConfirmDeleteSelected()" %%GLOBAL_DisableDelete%% />
			</td>
			<td class="SmallSearch" align="right">
				<table id="Table16" style="display:%%GLOBAL_DisplaySearch%%">
				<tr>
					<form action="index.php?ToDo=viewCustomerAddonProducts%%GLOBAL_SortURL%%" method="get" onsubmit="return ValidateForm(CheckSearchForm)">
					<input type="hidden" name="ToDo" value="viewCustomerAddonProducts">
					<td nowrap>
						<input name="searchQuery" id="searchQuery" type="text" value="%%GLOBAL_Query%%" id="SearchQuery" class="Button" size="20" />&nbsp;

						<input type="image" name="SearchButton" style="padding-left: 10px; vertical-align: top;" id="SearchButton" src="images/searchicon.gif" border="0" />
					</td>
					</form>
				</tr>
				<tr>
					<td></td>
				</tr>
				</table>
			</td>
			</tr>
			</table>
		</td>
		</tr>
		<tr>
		<td style="display: %%GLOBAL_DisplayGrid%%">
			<form name="frmAddonProducts" id="frmAddonProducts" method="post" action="index.php?ToDo=deleteAddonProducts">
				<div class="GridContainer">
					%%GLOBAL_AddonProductDataGrid%%
				</div>
			</form>
		</td></tr>
	</table>

	<div id="ViewsMenu" class="DropShadow DropDownMenu" style="display: none; width:200px">
			<!--zcs=>
			<ul>
				%%GLOBAL_CustomSearchOptions%%
			</ul>
			<hr />
			<ul>
				<li><a href="index.php?ToDo=createCustomerView" style="background-image:url('images/view_add.gif'); background-repeat:no-repeat; background-position:5px 5px; padding-left:28px">%%LNG_CreateANewView%%</a></li>
				<li style="display:%%GLOBAL_HideDeleteViewLink%%"><a onclick="$('#ViewsMenu').hide(); confirm_delete_custom_search('%%GLOBAL_CustomSearchId%%')" href="javascript:void(0)" style="background-image:url('images/view_del.gif'); background-repeat:no-repeat; background-position:5px 5px; padding-left:28px">%%LNG_DeleteThisView%%</a></li>
			</ul>
			<=zcs-->
		</div>
	</div>
	
	<script type="text/javascript" src="../javascript/jquery/plugins/interface.js"></script>
	<script type="text/javascript" src="../javascript/jquery/plugins/inestedsortable.js"></script>
	<script type="text/javascript">

		var td = null;
		var ret = "";

		function CheckSearchForm() {
			var query = document.getElementById("searchQuery");

			if(query.value == "")
			{
				alert("%%LNG_EnterSearchTerm%%");
				query.focus();
				return false;
			}

			return true;
		}

		function ConfirmDeleteSelected() {
			var fp = document.getElementById("frmAddonProducts").elements;
			var c = 0;

			for(i = 0; i < fp.length; i++)
			{
				if(fp[i].type == "checkbox" && fp[i].checked)
					c++;
			}

			if(c > 0)
			{
				if(confirm("%%LNG_ConfirmDeleteAddonProducts%%"))
					document.getElementById("frmAddonProducts").submit();
			}
			else
			{
				alert("%%LNG_ChooseAddonProduct%%");
			}
		}

		function ToggleDeleteBoxes(Status) {
			var fp = document.getElementById("frmAddonProducts").elements;

			for(i = 0; i < fp.length; i++)
				fp[i].checked = Status;
		}
		
		//zcs=>-------------------sort order-------------------------
		var updatingSortables = false;
		var updateTimeout = null;
		function CreateSortableList() {
			$('#SortList').NestedSortable({
				accept: 'SortableRow',
				noNestingClass: 'SortableRow',
				helperclass: 'SortableRowHelper',
				opacity: .8,
				onChange: function(serialized) {
					updatingSortables = true;
					if(updateTimeout != null) window.clearTimeout(updateTimeout);
					$.ajax({
						url: 'remote.php?w=updateAddonProductOrders',
						type: 'POST',
						dataType: 'xml',
						data: serialized[0].hash,
						success: function(response) {
							var status = $('status', response).text();
							var message = $('message', response).text();
							if(status == 0) {
								display_error('CategoriesStatus', message);
							}
							else {
								display_success('CategoriesStatus', message);
							}
							if(document.all) {
								// IE has problems here - it breaks on sortable lists so for now we just
								// refresh the current page
								window.location.reload();
							}
						}
					});

				},
				onStop: function() {
					if(document.all && updatingSortables == false) {
						// IE has problems here - it breaks on sortable lists so for now we just
						// refresh the current page
						updateTimeout = window.setTimeout(function() { window.location.reload(); }, 100);
					}
				},
				autoScroll: true
			}).find('tr').css('cursor', 'move');
		}
		$(document).ready(function()
		{
			%%GLOBAL_setSortOrder%% && CreateSortableList();
		});
		//<=zcs---------------------------------------------------
	</script>
