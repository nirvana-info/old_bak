	<div class="BodyContainer">
	<form method="post" action="index.php?ToDo=deleteBackups">
	<table id="Table13" cellSpacing="0" cellPadding="0" width="100%">
		<tr>
			<td class="Heading1">%%LNG_ManageLocalBackups%%</td>
		</tr>
		<tr>
		<td class="Intro">
			<p>%%LNG_ManageLocalBackupsIntro%%</p>
			%%GLOBAL_Message%%
			<table id="IntroTable" cellspacing="0" cellpadding="0" width="100%">
			<tr>
			<td class="Intro" valign="top" style="padding-bottom:10px">
				<input type="button" name="CreateBackup" value="%%LNG_CreateBackup%%..." onclick="createBackup()" class="SmallButton" />
				 &nbsp;
				<input type="submit" name="DeleteSelected" value="%%LNG_DeleteSelected%%" onclick="return deleteBackups()" class="SmallButton" %%GLOBAL_DisableDelete%% />
			</td>
			</tr>
			</table>
		</td>
		</tr>
		<tr>
		<td style="display: %%GLOBAL_DisplayGrid%%">
			<table class="GridPanel" cellspacing="0" cellpadding="0" border="0" id="IndexGrid" style="width:100%;">
			<tr class="Heading3">
				<td align="center"><input type="checkbox" onclick="$('.DeleteBackup').attr('checked', this.checked);"></td>
				<td>&nbsp;</td>
				<td width="50%" nowrap>
					%%LNG_BackupFileName%%
				</td>
				<td width="10%" nowrap align="right">
					%%LNG_BackupSize%%
				</td>
				<td nowrap>
					%%LNG_BackupMTime%%
				</td>
				<td nowrap>
					%%LNG_Action%%
				</td>

			</tr>
			%%GLOBAL_BackupGrid%%
			</table>
		</td></tr>
	</table>
	</form>
	</div>
	<script type="text/javascript">
		function createBackup() {
			window.location = 'index.php?ToDo=createBackup';
		}

		function deleteBackups() {
			if($(".DeleteBackup:checked").length == 0)
			{
				alert('%%LNG_NoBackupsSelected%%');
				return false;
			}

			// Otherwise confirm?
			if(confirm('%%LNG_ConfirmDeleteBackups%%'))
			{
				return true;
			}

			return false;
		}
	</script>