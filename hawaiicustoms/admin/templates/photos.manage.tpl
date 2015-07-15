
	<div class="BodyContainer">
	<table id="Table13" cellSpacing="0" cellPadding="0" width="100%">
		<tr>
		<td class="Intro">
			<p>%%GLOBAL_PhotoIntro%%</p>
			<div id="PhotoStatus">
				%%GLOBAL_Message%%
			</div>
			<div style="background-color: rgb(244, 244, 244); display:none" class="MessageBox MessageBoxSuccess" id="CustomerGroupMessage"></div>
			<table id="IntroTable" cellspacing="0" cellpadding="0" width="100%">
			<tr>
			<td class="Intro" valign="top">
				<input type="button" name="IndexDeleteButton" value="%%LNG_DeleteSelected%%" id="IndexDeleteButton" class="SmallButton" onclick="ConfirmDeleteSelected()" %%GLOBAL_DisableDelete%% />
				<input type="button" name="IndexExportButton" value="%%LNG_ExportPhotos%%" id="IndexExportButton" class="SmallButton" style="width:160px; display: %%GLOBAL_HideExport%%" onclick="ExportPhotos()" %%GLOBAL_DisableExport%% />
				<input type="button" name="IndexSettingButton" value="Settings..." id="IndexSettingButton" class="SmallButton" onclick="location.href='index.php?ToDo=viewImageUploaderSettings';" />
			</td>
			<td class="SmallSearch" align="right">
				<table id="Table16" style="display:%%GLOBAL_DisplaySearch%%">
				<tr>
					<form action="index.php?ToDo=viewCustomerPhotos%%GLOBAL_SortURL%%" method="get" onsubmit="return ValidateForm(CheckSearchForm)">
					<input type="hidden" name="ToDo" value="viewCustomerPhotos">
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
			<form name="frmPhotos" id="frmPhotos" method="post" action="index.php?ToDo=deleteCustomerPhotos">
				<div class="GridContainer">
					%%GLOBAL_PhotoDataGrid%%
				</div>
			</form>
		</td></tr>
	</table>

	<div id="ViewsMenu" class="DropShadow DropDownMenu" style="display: none; width:200px">
			<ul>
				%%GLOBAL_CustomSearchOptions%%
			</ul>
			<hr />
			<ul>
				<li><a href="index.php?ToDo=createCustomerView" style="background-image:url('images/view_add.gif'); background-repeat:no-repeat; background-position:5px 5px; padding-left:28px">%%LNG_CreateANewView%%</a></li>
				<li style="display:%%GLOBAL_HideDeleteViewLink%%"><a onclick="$('#ViewsMenu').hide(); confirm_delete_custom_search('%%GLOBAL_CustomSearchId%%')" href="javascript:void(0)" style="background-image:url('images/view_del.gif'); background-repeat:no-repeat; background-position:5px 5px; padding-left:28px">%%LNG_DeleteThisView%%</a></li>
			</ul>
		</div>
	</div>

	</div>

	<script type="text/javascript" src="/javascript/jquery/jquery.extends.js"></script>
	<script type="text/javascript">

		var td = null;
		var ret = "";
		
		function ExportPhotos()
		{
			document.getElementById("frmPhotos").action = "%%GLOBAL_ExportAction%%";
			document.getElementById("frmPhotos").submit();
		}

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
			var fp = document.getElementById("frmPhotos").elements;
			var c = 0;

			for(i = 0; i < fp.length; i++)
			{
				if(fp[i].type == "checkbox" && fp[i].checked)
					c++;
			}

			if(c > 0)
			{
				if(confirm("%%LNG_ConfirmDeletePhotos%%"))
					document.getElementById("frmPhotos").submit();
			}
			else
			{
				alert("%%LNG_ChoosePhoto%%");
			}
		}

		function ToggleDeleteBoxes(Status) {
			var fp = document.getElementById("frmPhotos").elements;

			for(i = 0; i < fp.length; i++)
				fp[i].checked = Status;
		}

		function confirm_delete_custom_search(search_id) {
			if(confirm("%%LNG_ConfirmDeleteCustomSearch%%"))
				document.location.href = "index.php?ToDo=deleteCustomCustomerSearch&searchId="+search_id;
		}

		function updateStoreCredit(id) {
			var credit = $('#storecredit_'+id).val();
			var button = $('#save_storecredit_'+id);
			if(credit != "" && isNaN(priceFormat(credit))) {
				alert('%%LNG_SearchEnterValidStoreCredit%%');
				$('#storecredit_'+id).select();
				$('#storecredit_'+id).focus();
				return false;
			}
			button.val('...');
			button.attr('disabled', true);
			button.blur();
			$.ajax({
				url: 'remote.php?w=updateStoreCredit&customerId='+id+'&credit='+credit,
				success: function(response) {
					button.val('%%LNG_Save%%');
					button.attr('disabled', false);
				},
				error: function() {
					button.val('%%LNG_Save%%');
					button.attr('disabled', false);
				}
			});
		}

		function updateCustomerGroup(customerId, groupId, customerName, groupName) {
			$.ajax({
				url: 'remote.php?w=updateCustomerGroup&customerId='+customerId+'&groupId='+groupId,
				success: function(response) {
					if(response == "1") {
						if(groupId > 0) {
							$('#CustomerGroupMessage').text(customerName + ' is now a member of the ' + groupName + ' group.');
						}
						else {
							$('#CustomerGroupMessage').text(customerName + ' is no longer in a customer group.');
						}

						$('#CustomerGroupMessage').show('slow');
						window.setTimeout("$('#CustomerGroupMessage').hide('slow');", 5000);
					}
					else {
						alert('%%LNG_ErrorUpdatingCustomerGroup%%');
						document.location.reload();
					}
				},
				error: function() {
					alert('%%LNG_ErrorUpdatingCustomerGroup%%');
				}
			});
		}

		function viewOrderNotes(orderId)
		{
			if (isNaN(orderId)) {
				return false;
			}

			$.iModal({
				type: 'ajax',
				url: 'remote.php?remoteSection=customers&w=viewOrderNotes&orderId='+orderId,
				width: 600
			});
		}

	</script>
<script type="text/javascript" src="script/photos.js"></script>

<script type="text/javascript">
	lang.SavingNotes = "%%LNG_SavingNotes%%";
</script>
