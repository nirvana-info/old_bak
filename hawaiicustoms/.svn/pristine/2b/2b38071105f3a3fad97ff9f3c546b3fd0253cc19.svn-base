	<form enctype="multipart/form-data" action="index.php?ToDo=importOrdertrackingnumbers&Step=2" onsubmit="return ValidateForm(CheckImportOrdertrackingnumberForm)" id="frmImport" method="post">
	<div class="BodyContainer">
		<table cellSpacing="0" cellPadding="0" width="100%" style="margin-left: 4px; margin-top: 8px;">
		<tr>
			<td class="Heading1">%%LNG_ImportOrdertrackingnumbersStep1%%</td>
		</tr>
		<tr>
			<td class="Intro">
				<p>%%LNG_ImportOrdertrackingnumbersStep1Desc%%</p>
				%%GLOBAL_Message%%
			</td>
		</tr>
		<tr>
			<td>
				<div>
					<input type="reset" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()" />
					<input type="submit" value="%%LNG_Next%% &raquo;" class="FormButton" />
				</div>
				<br />
			</td>
		</tr>

		<tr>
			<td>
			<table class="Panel">
				<tr>
				  <td class="Heading2" colspan=2>%%LNG_OrderStatusDetails%%</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">&nbsp;</span>&nbsp;%%LNG_UpdateOrderStatusTo%%
					</td>
					<td>
						<select id="updateOrderStatus" name="updateOrderStatus" class="Field">
							<option value="0">%%LNG_DoNotUpdate%%</option>
							<option value="1">%%LNG_Pending%%</option>
							<option value="7">%%LNG_AwaitingPayment%%</option>
							<option value="11">%%LNG_AwaitingFulfillment%%</option>
							<option value="9">%%LNG_AwaitingShipment%%</option>
							<option value="8">%%LNG_AwaitingPickup%%</option>
							<option value="3">%%LNG_PartiallyShipped%%</option>
							<option value="10">%%LNG_Completed%%</option>
							<option value="2" selected="selected">%%LNG_Shipped%%</option>
							<option value="5">%%LNG_Cancelled%%</option>
							<option value="6">%%LNG_Declined%%</option>
							<option value="4">%%LNG_Refunded%%</option>
						</select>
						<img onMouseOut="HideHelp('u1');" onMouseOver="ShowHelp('u1', '%%LNG_UpdateOrderStatus%%', '%%LNG_UpdateOrderStatusDesc%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="u1"></div>
					</td>
				</tr>
			</table>

			  <table class="Panel">
				<tr>
				  <td class="Heading2" colspan=2>%%LNG_ImportDetails%%</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">&nbsp;</span>&nbsp;%%LNG_ImportOverride%%
					</td>
					<td>
						<label><input type="checkbox" name="OverrideDuplicates" value="1" /> %%LNG_YesImportOverride%%</label>
						<img onMouseOut="HideHelp('a2');" onMouseOver="ShowHelp('a2', '%%LNG_ImportOverride%%', '%%LNG_ImportOverrideDesc%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="a2"></div>
					</td>
				</tr>
			</table>
			  <table class="Panel">
				<tr>
				  <td class="Heading2" colspan=2>%%LNG_ImportFileDetails%%</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span>&nbsp;%%LNG_ImportFile%%:
					</td>
					<td>
						<div>
							<label><input id="OrdertrackingnumberImportUseUpload" type="radio" name="useserver" value="0" checked="checked" onclick="ToggleSource();" /> %%LNG_ImportFileUpload%% %%LNG_ImportMaxSize%%</label>
							<img onMouseOut="HideHelp('d1');" onMouseOver="ShowHelp('d1', '%%LNG_ImportFileUpload%%', '%%LNG_ImportFileUploadDesc%%')" src="images/help.gif" width="24" height="16" border="0">
							<div style="display: none;" id="d1"></div>
						</div>
						<div id="OrdertrackingnumberImportUploadField" style="margin-left: 25px;">
							<input type="file" name="importfile" id="ImportFile" class="Field250" />
						</div>

						<div>
							<label><input id="OrdertrackingnumberImportUseServer" type="radio" name="useserver" value="1" onclick="ToggleSource();" /> %%LNG_ImportFileServer%%</label>
							<img onMouseOut="HideHelp('d2');" onMouseOver="ShowHelp('d2', '%%LNG_ImportFileServer%%', '%%LNG_ImportFileServerDesc%%')" src="images/help.gif" width="24" height="16" border="0">
							<div style="display: none;" id="d2"></div>
						</div>
						<div id="OrdertrackingnumberImportServerField" style="margin-left: 25px; display: none;">
							<select name="serverfile" id="ServerFile" class="Field250">
								<option value="">%%LNG_ImportChooseFile%%</option>
								%%GLOBAL_ServerFiles%%
							</select>
						</div>
						<div id="OrdertrackingnumberImportServerNoList" style="margin: 5px 0 0 25px; display: none; font-style: italic;" class="Field250">
							%%LNG_FieldNoServerFiles%%
						</div>
					</td>
				</tr>

				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span>&nbsp;%%LNG_ImportContainsHeaders%%
					</td>
					<td>
						<label><input type="checkbox" name="Headers" value="1" /> %%LNG_YesImportContainsHeaders%%</label>
						<img onMouseOut="HideHelp('d3');" onMouseOver="ShowHelp('d3', '%%LNG_ImportContainsHeaders%%', '%%LNG_ImportContainsHeadersDesc%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="d3"></div>
					</td>
				</tr>

				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span>&nbsp;%%LNG_ImportFieldSeparator%%:
					</td>
					<td>
						<input type="text" name="FieldSeparator" id="FieldSeparator" class="Field250" value="%%GLOBAL_FieldSeparator%%" />
						<img onMouseOut="HideHelp('d4');" onMouseOver="ShowHelp('d4', '%%LNG_ImportFieldSeparator%%', '%%LNG_ImportFieldSeparatorDesc%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="d4"></div>
					</td>
				</tr>

				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span>&nbsp;%%LNG_ImportFieldEnclosure%%:
					</td>
					<td>
						<input type="text" name="FieldEnclosure" id="FieldEnclosure" class="Field250" value='%%GLOBAL_FieldEnclosure%%' />
						<img onMouseOut="HideHelp('d5');" onMouseOver="ShowHelp('d5', '%%LNG_ImportFieldEnclosure%%', '%%LNG_ImportFieldEnclosureDesc%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="d5"></div>
					</td>
				</tr>
			</table>
			<table border="0" cellspacing="0" cellpadding="2" width="100%" class="PanelPlain">
				<tr>
					<td width="200" class="FieldLabel">
						&nbsp;
					</td>
					<td>
						<input type="reset" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()" />
						<input type="submit" value="%%LNG_Next%% &raquo;" class="FormButton" />
					</td>
				</tr>
			</table>
			</td>
		</tr>
		</table>
	</div>
	</form>

	<script type="text/javascript">
	function ConfirmCancel()
	{
		if(confirm('%%LNG_ConfirmCancelImport%%'))
			window.location = 'index.php?ToDo=manageordertrackingnumbers';
	}

	function CheckImportOrdertrackingnumberForm()
	{
		var f = document.getElementById('OrdertrackingnumberImportUseUpload');
		if(f.checked == true)
		{
			var f = document.getElementById('ImportFile');
			if(f.value == '')
			{
				alert('%%LNG_NoImportFile%%');
				f.focus();
				return false;
			}
		}
		else
		{
			var f = document.getElementById('ServerFile');
			if(f.value < 1)
			{
				alert('%%LNG_NoImportFile%%');
				f.focus();
				return false;
			}
		}

		var f = document.getElementById('FieldSeparator');
		if(f.value == '')
		{
			alert('%%LNG_NoImportFieldSeparator%%');
			f.focus();
			return false;
		}

		var f = document.getElementById('FieldEnclosure');
		if(f.value == '')
		{
			alert('%%LNG_NoImportFieldEnclosure%%');
			f.focus();
			return false;
		}
		return true;
	}

	function ToggleSource()
	{
		var file = document.getElementById('OrdertrackingnumberImportUseUpload');
		if(file.checked == true)
		{
			document.getElementById('OrdertrackingnumberImportUploadField').style.display = '';
			document.getElementById('OrdertrackingnumberImportServerField').style.display = 'none';
			document.getElementById('OrdertrackingnumberImportServerNoList').style.display = 'none';
		}
		else
		{
			document.getElementById('OrdertrackingnumberImportUploadField').style.display = 'none';
			if(document.getElementById('OrdertrackingnumberImportServerField').getElementsByTagName('SELECT')[0].options.length == 1)
			{
				document.getElementById('OrdertrackingnumberImportServerNoList').style.display = '';
			}
			else
			{
				document.getElementById('OrdertrackingnumberImportServerField').style.display = '';
			}
		}
	}
	</script>