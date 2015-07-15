
	<form action="index.php?ToDo=createBackup2" id="frmBanner" method="post">
	<div class="BodyContainer">
	<table class="OuterPanel">
	  <tr>
		<td class="Heading1" id="tdHeading">%%LNG_CreateBackup%%</td>
		</tr>
		<tr>
		<td class="Intro">
			<p>%%LNG_CreateBackupIntro%%</p>
			%%GLOBAL_Message%%
			<p>
				<input type="submit" name="SubmitButton1" style="width:100px" value="%%LNG_StartBackup%%..." class="FormButton" onclick="StartBackup(); return false;">&nbsp; <input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()">
			</p>
		</td>
	  </tr>
		<tr>
			<td>
			  <table class="Panel">
				<tr>
				  <td class="Heading2" colspan=2>%%LNG_BackupSettings%%</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span>&nbsp;%%LNG_BackupMethod%%:
					</td>
					<td>
						<label style="display: %%GLOBAL_HideLocalMethod%%"><input type="radio" name="backupmethod" value="local" %%GLOBAL_LocalChecked%% /> %%LNG_BackupMethodLocal%%<br /></label>
						<label style="display: %%GLOBAL_HideFTPMethod%%"><input type="radio" name="backupmethod" value="ftp" %%GLOBAL_FTPChecked%% /> %%LNG_BackupMethodRemoteFTP%% (%%GLOBAL_RemoteFTPHost%%)</label>
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">&nbsp;</span>&nbsp;%%LNG_BackupDatabase%%
					</td>
					<td>
						<label><input type="checkbox" name="backupdb" value="1" checked="checked" onclick="ToggleDBBackup(this);" /> %%LNG_YesBackupDatabase%%</label>
						<img onmouseout="HideHelp('d1');" onmouseover="ShowHelp('d1', '%%LNG_BackupDatabase%%', '%%LNG_BackupDatabaseHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="d1"></div>
						<div id="DBBackupDetails" style="display: none;">
							<ul>
								<li>%%LNG_BackupDatabaseTableCount%% %%GLOBAL_TableCount%%</li>
								<li>%%LNG_BackupDatabaseRowCount%% %%GLOBAL_RowCount%%</li>
								<li>%%LNG_BackupDatabaseMaxRows%% %%GLOBAL_MaxRowCount%% (%%GLOBAL_MaxRowTable%%)</li>
								<li>%%LNG_BackupDatabaseMinRows%% %%GLOBAL_MinRowCount%% (%%GLOBAL_MinRowTable%%)</li>
							</ul>
						</div>
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">&nbsp;</span>&nbsp;%%LNG_BackupProductImages%%
					</td>
					<td>
						<label><input type="checkbox" name="backupimages" value="1" checked="checked" onclick="ToggleImageBackup(this);" /> %%LNG_YesBackupProductImages%%</label>
						<img onmouseout="HideHelp('d2');" onmouseover="ShowHelp('d2', '%%LNG_BackupProductImages%%', '%%LNG_BackupProductImagesHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="d2"></div>
						<div id="ImageBackupDetails" style="display: none;">
							<ul>
								<li>%%LNG_BackupProductImagesCount%% %%GLOBAL_ImageCount%%</li>
							</ul>
						</div>
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">&nbsp;</span>&nbsp;%%LNG_BackupDigitalProducts%%
					</td>
					<td>
						<label><input type="checkbox" name="backupdigitalproducts" value="1" checked="checked" onclick="ToggleDigitalBackup(this);" /> %%LNG_YesBackupDigitalProducts%%</label>
						<img onmouseout="HideHelp('d3');" onmouseover="ShowHelp('d3', '%%LNG_BackupDigitalProducts%%', '%%LNG_BackupDigitalProductsHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="d3"></div>
						<div id="DigitalBackupDetails" style="display: none;">
							<ul>
								<li>%%LNG_BackupDigitalProductsCount%% %%GLOBAL_DigitalProductCount%%</li>
							</ul>
						</div>
					</td>
				</tr>

				<tr>
					<td class="Gap">&nbsp;</td>
					<td class="Gap"><input type="submit" name="SubmitButton1" style="width:100px" value="%%LNG_StartBackup%%..." class="FormButton" onclick="StartBackup(); return false;">&nbsp; <input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()">
					</td>
				</tr>
				<tr><td class="Gap"></td></tr>
				<tr><td class="Gap"></td></tr>
				<tr><td class="Sep" colspan="2"></td></tr>
			 </table>
			</td>
		</tr>
	</table>

	</div>
	</form>

	<script type="text/javascript">
		function ToggleDBBackup(element)
		{
			if(element.checked == true) {
				document.getElementById('DBBackupDetails').style.display = '';
			}
			else {
				document.getElementById('DBBackupDetails').style.display = 'none';
			}
		}
		ToggleDBBackup(document.getElementsByTagName('input')[2]);

		function ToggleImageBackup(element)
		{
			if(element.checked == true) {
				document.getElementById('ImageBackupDetails').style.display = '';
			}
			else {
				document.getElementById('ImageBackupDetails').style.display = 'none';
			}
		}
		ToggleImageBackup(document.getElementsByTagName('input')[5]);

		function ToggleDigitalBackup(element)
		{
			if(element.checked == true) {
				document.getElementById('DigitalBackupDetails').style.display = '';
			}
			else {
				document.getElementById('DigitalBackupDetails').style.display = 'none';
			}
		}
		ToggleDigitalBackup(document.getElementsByTagName('input')[6]);

		function ConfirmCancel() {
			if(confirm("%%LNG_ConfirmCancelBackup%%"))
				document.location.href = "index.php?ToDo=viewBackups";
		}

		function StartBackup() {
			var inputs = document.getElementsByTagName('INPUT');
			var url = '';
			for(var i = 0; i < inputs.length; ++i) {
				if(inputs[i].type == "submit" || inputs[i].type == "button" || ((inputs[i].type == "checkbox" || inputs[i].type == "radio") && inputs[i].checked == false) || inputs[i].offsetHeight == 0) continue;
				url += '&'+inputs[i].name+'='+inputs[i].value;
			}
			tb_show('', 'index.php?ToDo=initBackup'+url+'&keepThis=true&TB_iframe=tue&height=250&width=400&modal=true', '');
		}
	</script>