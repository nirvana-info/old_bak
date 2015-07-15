	<form enctype="multipart/form-data" action="index.php?ToDo=importCustomers&Step=2" onsubmit="return ValidateForm(CheckImportCustomerForm)" id="frmImport" method="post">
	<div class="BodyContainer">
		<table cellSpacing="0" cellPadding="0" width="100%" style="margin-left: 4px; margin-top: 8px;">
		<tr>
			<td class="Heading1">%%LNG_ImportCustomersStep1%%</td>
		</tr>
		<tr>
			<td class="Intro">
				<p>%%LNG_ImportCustomersStep1Desc%%</p>
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
				  <td class="Heading2" colspan=2>%%LNG_ImportDetails%%</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">&nbsp;</span>&nbsp;%%LNG_ImportOverride%%
					</td>
					<td>
						<label><input type="checkbox" name="OverrideDuplicates" value="1" /> %%LNG_YesImportOverride%%</label>
						<img onmouseout="HideHelp('a2');" onmouseover="ShowHelp('a2', '%%LNG_ImportOverride%%', '%%LNG_ImportOverrideDesc%%')" src="images/help.gif" width="24" height="16" border="0">
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
							<label><input id="CustomerImportUseUpload" type="radio" name="useserver" value="0" checked="checked" onclick="ToggleSource();" /> %%LNG_ImportFileUpload%% %%LNG_ImportMaxSize%%</label>
							<img onmouseout="HideHelp('d1');" onmouseover="ShowHelp('d1', '%%LNG_ImportFileUpload%%', '%%LNG_ImportFileUploadDesc%%')" src="images/help.gif" width="24" height="16" border="0">
							<div style="display: none;" id="d1"></div>
						</div>
						<div id="CustomerImportUploadField" style="margin-left: 25px;">
							<input type="file" name="importfile" id="ImportFile" class="Field250" />
						</div>

						<div>
							<label><input id="CustomerImportUseServer" type="radio" name="useserver" value="1" onclick="ToggleSource();" /> %%LNG_ImportFileServer%%</label>
							<img onmouseout="HideHelp('d2');" onmouseover="ShowHelp('d2', '%%LNG_ImportFileServer%%', '%%LNG_ImportFileServerDesc%%')" src="images/help.gif" width="24" height="16" border="0">
							<div style="display: none;" id="d2"></div>
						</div>
						<div id="CustomerImportServerField" style="margin-left: 25px; display: none;">
							<select name="serverfile" id="ServerFile" class="Field250">
								<option value="">%%LNG_ImportChooseFile%%</option>
								%%GLOBAL_ServerFiles%%
							</select>
						</div>
						<div id="CustomerImportServerNoList" style="margin: 5px 0 0 25px; display: none; font-style: italic;" class="Field250">
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
						<img onmouseout="HideHelp('d3');" onmouseover="ShowHelp('d3', '%%LNG_ImportContainsHeaders%%', '%%LNG_ImportContainsHeadersDesc%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="d3"></div>
					</td>
				</tr>

				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span>&nbsp;%%LNG_ImportFieldSeparator%%:
					</td>
					<td>
						<input type="text" name="FieldSeparator" id="FieldSeparator" class="Field250" value="%%GLOBAL_FieldSeparator%%" />
						<img onmouseout="HideHelp('d4');" onmouseover="ShowHelp('d4', '%%LNG_ImportFieldSeparator%%', '%%LNG_ImportFieldSeparatorDesc%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="d4"></div>
					</td>
				</tr>

				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span>&nbsp;%%LNG_ImportFieldEnclosure%%:
					</td>
					<td>
						<input type="text" name="FieldEnclosure" id="FieldEnclosure" class="Field250" value='%%GLOBAL_FieldEnclosure%%' />
						<img onmouseout="HideHelp('d5');" onmouseover="ShowHelp('d5', '%%LNG_ImportFieldEnclosure%%', '%%LNG_ImportFieldEnclosureDesc%%')" src="images/help.gif" width="24" height="16" border="0">
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
			window.location = 'index.php?ToDo=manageCustomers';
	}

	function CheckImportCustomerForm()
	{
		var f = document.getElementById('CustomerImportUseUpload');
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
		var file = document.getElementById('CustomerImportUseUpload');
		if(file.checked == true)
		{
			document.getElementById('CustomerImportUploadField').style.display = '';
			document.getElementById('CustomerImportServerField').style.display = 'none';
			document.getElementById('CustomerImportServerNoList').style.display = 'none';
		}
		else
		{
			document.getElementById('CustomerImportUploadField').style.display = 'none';
			if(document.getElementById('CustomerImportServerField').getElementsByTagName('SELECT')[0].options.length == 1)
			{
				document.getElementById('CustomerImportServerNoList').style.display = '';
			}
			else
			{
				document.getElementById('CustomerImportServerField').style.display = '';
			}
		}
	}
	</script>