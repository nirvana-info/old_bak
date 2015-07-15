<div class="BodyContainer">
	<table cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<td class="Heading1">
			%%LNG_View%%: <a href="#" style="color: #005FA3" id="ViewsMenuButton" class="PopDownMenu">%%GLOBAL_ViewName%%
				<img width="8" height="5" src="images/arrow_blue.gif" border="0" />
			</a>
		</td>
	</tr>
	<tr>
		<td class="Intro" colspan="2">
			<p>%%LNG_ShipmentsIntro%%</p>
			%%GLOBAL_Message%%
		</td>
	</tr>
	<tr>
		<td class="Intro">
			<p>
				<input type="button" value="%%LNG_DeleteSelected%%" onclick="return Shipments.DeleteSelected();" class="SmallButton" %%GLOBAL_DisableDelete%% />
				<input type="button" value="%%LNG_ExportTheseShipments%%" onclick="Shipments.Export()" class="SmallButton" %%GLOBAL_DisableExport%% />
			</p>
		</td>
		<td class="SmallSearch" align="right">
			<form action="index.php?ToDo=viewShipments%%GLOBAL_SortURL%%" method="get">
				<table style="%%GLOBAL_DisplaySearch%%">
					<tr>
						<td class="text" nowrap align="right">
							<input name="searchQuery" id="searchQuery" type="text" value="%%GLOBAL_Query%%" id="SearchQuery" class="SearchBox" style="width:150px" />&nbsp;
							<input type="image" name="SearchButton" id="SearchButton" src="images/searchicon.gif" border="0"  style="padding-left: 10px; vertical-align: top;" />
						</td>
					</tr>
					<tr>
						<td nowrap="nowrap">
							<a href="index.php?ToDo=searchShipments">%%LNG_AdvancedSearch%%</a>
							<span style="%%GLOBAL_HideClearResults%%">
								| <a id="SearchClearButton" href="index.php?ToDo=viewShipments">%%LNG_ClearResults%%</a>
							</span>
						</td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
	<tr style="%%GLOBAL_DisplayGrid%%">
		<td colspan="2">
			<form method="post" id="shipmentsForm" action="index.php?ToDo=deleteShipments">
				<div class="GridContainer" id="GridContainer">
					%%GLOBAL_ShipmentDataGrid%%
				</div>
			</form>
		</td>
	</tr>
	</table>
</div>

<!-- Begin Custom Views Menu -->
<div id="ViewsMenu" class="DropDownMenu DropShadow" style="display: none; width:200px">
	<ul>
		%%GLOBAL_CustomViews%%
	</ul>
	<hr />
	<ul>
		<li>
			<a href="index.php?ToDo=createShipmentView" style="background-image:url('images/view_add.gif'); background-repeat:no-repeat; background-position:5px 5px; padding-left:28px">
				%%LNG_CreateANewView%%
			</a>
		</li>
		<li style="%%GLOBAL_HideDeleteViewLink%%">
			<a onclick="$('#ViewsMenu').hide(); Shipments.DeleteView('%%GLOBAL_CustomViewId%%'); return false;" href="#" style="background-image:url('images/view_del.gif'); background-repeat:no-repeat; background-position:5px 5px; padding-left:28px">
				%%LNG_DeleteThisView%%
			</a>
		</li>
	</ul>
</div>
<!-- End Custom Views Menu -->

<!-- Begin Export Shipments Box -->
<div id="exportBox" style="display: none">
	<div class="ModalTitle">
		%%LNG_Export%% %%GLOBAL_ViewName%%
	</div>
	<div class="ModalContent">
		<p>%%LNG_ExportThickBoxIntro%%</p>
		<p>%%LNG_ChooseAFileFormat%%</p>

		<table border="0">
			<tr>
				<td><img width="16" height="16" hspace="5" src="images/exportCsv.gif" /></td>
				<td><a onclick="$.modal.close()" href="index.php?ToDo=exportShipments&amp;format=csv%%GLOBAL_SortURL%%" style="color:#005FA3; font-weight:bold">%%LNG_ExportCSV%%</a></td>
			</tr>
			<tr>
				<td><img width="16" height="16" hspace="5" src="images/exportXml.gif" /></td>
				<td><a onclick="$.modal.close()" href="index.php?ToDo=exportShipments&amp;format=xml%%GLOBAL_SortURL%%" style="color:#005FA3; font-weight:bold">%%LNG_ExportXML%%</a></td>
			</tr>
		</table>
	</div>
	<div class="ModalButtonRow">
		<input type="button" class="Submit" value="%%LNG_Cancel%%" onclick="$.modal.close()" />
	</div>
</div>
<!-- End Export Shipments Box -->

<script type="text/javascript" src="script/shipments.js"></script>
<script type="text/javascript">
	lang.ConfirmDeleteCustomSearch = '%%LNG_ConfirmDeleteCustomSearch%%';
	lang.ConfirmDeleteShipments = "%%LNG_ConfirmDeleteShipments%%";
	lang.SelectOneMoreShipmentsDelete = "%%LNG_SelectOneMoreShipmentsDelete%%";
</script>