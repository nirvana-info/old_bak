<!--
* @author wilson.zeng
-->
	<form action="index.php?ToDo=saveImageUploaderSettings" name="frmImageUploaderSettings" id="frmImageUploaderSettings" method="post" onsubmit="return ValidateForm(CheckImageUploaderSettingsForm)">
		<div class="BodyContainer">
		<table cellSpacing="0" cellPadding="0" width="100%" style="margin-left: 4px; margin-top: 8px;">
		<tr>
			<td class="Heading1">%%LNG_ImageUploaderSettings%%</td>
		</tr>
		<tr>
			<td class="Intro">
				<p>%%LNG_ImageUploaderSettingsIntro%%</p>
				%%GLOBAL_Message%%
				<p>
					<input type="submit" value="%%LNG_Save%%" class="FormButton" />
					<input type="reset" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()" />
				</p>
			</td>
		</tr>
		<tr>
			<td>
				<ul id="tabnav">
					<li><a href="#" class="active" id="tab0" onclick="ShowTab(0)">%%LNG_GeneralSettings%%</a></li>
				</ul>
			</td>
		</tr>
		<tr>
			<td>
				<input id="currentTab" name="currentTab" value="0" type="hidden">
				<div id="div0" style="padding-top: 10px;">
					<table width="100%" class="Panel">
						<!-- johnny add for limit upload image size -->
						<tr>
							<td class="FieldLabel">
								&nbsp;&nbsp; <label for="StoreName">%%LNG_LimitCustomerUploadImageSize%%</label>
							</td>
							<td>
								<input type="text" name="LimitCustomerUploadImageSize" id="LimitCustomerUploadImageSize" value="%%GLOBAL_LimitCustomerUploadImageSize%%" class="Field20" /> MB
								<img onmouseout="HideHelp('help_LimitCustomerUploadImageSize');" onmouseover="ShowHelp('help_LimitCustomerUploadImageSize', '%%LNG_LimitCustomerUploadImageSize%%', '%%LNG_LimitCustomerUploadImageSizeHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
								<div style="display:none" id="help_LimitCustomerUploadImageSize"></div>
							</td>
						</tr>
						<!-- end -->
						<tr>
							<td class="FieldLabel">
								&nbsp;&nbsp; <label for="StoreName">%%LNG_LimitCustomerUploadImageNum%%</label>
							</td>
							<td>
								<input type="text" name="LimitCustomerUploadImageNum" id="LimitCustomerUploadImageNum" value="%%GLOBAL_LimitCustomerUploadImageNum%%" class="Field20" />
								<img onmouseout="HideHelp('help_LimitCustomerUploadImageNum');" onmouseover="ShowHelp('help_LimitCustomerUploadImageNum', '%%LNG_LimitCustomerUploadImageNum%%', '%%LNG_LimitCustomerUploadImageNumHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
								<div style="display:none" id="help_LimitCustomerUploadImageNum"></div>
							</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								&nbsp;&nbsp; <label for="StoreName">%%LNG_LimitCustomerUploadImagePerNum%%</label>
							</td>
							<td>
								<input type="text" name="LimitCustomerUploadImagePerNum" id="LimitCustomerUploadImagePerNum" value="%%GLOBAL_LimitCustomerUploadImagePerNum%%" class="Field20" />
								<img onmouseout="HideHelp('help_LimitCustomerUploadImagePerNum');" onmouseover="ShowHelp('help_LimitCustomerUploadImagePerNum', '%%LNG_LimitCustomerUploadImagePerNum%%', '%%LNG_LimitCustomerUploadImagePerNumHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
								<div style="display:none" id="help_LimitCustomerUploadImagePerNum"></div>
							</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								&nbsp;&nbsp; <label for="StoreName">%%LNG_LimitCustomerUploadImageFileType%%</label>
							</td>
							<td>
								%%GLOBAL_LimitCustomerUploadImageFileType%%
								<img onmouseout="HideHelp('help_LimitCustomerUploadImageFileType');" onmouseover="ShowHelp('help_LimitCustomerUploadImageFileType', '%%LNG_LimitCustomerUploadImageFileType%%', '%%LNG_LimitCustomerUploadImageFileTypeHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
								<div style="display:none" id="help_LimitCustomerUploadImageFileType"></div>
							</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								&nbsp;&nbsp; <label for="StoreName">%%LNG_ImageUploaderSettingsNotifyEmail%%</label>
							</td>
							<td>
								<input type="text" name="ImageUploaderSettingsNotifyEmail" id="ImageUploaderSettingsNotifyEmail" value="%%GLOBAL_ImageUploaderSettingsNotifyEmail%%" class="Field500" />
								<img onmouseout="HideHelp('help_ImageUploaderSettingsNotifyEmail');" onmouseover="ShowHelp('help_ImageUploaderSettingsNotifyEmail', '%%LNG_ImageUploaderSettingsNotifyEmail%%', '%%LNG_ImageUploaderSettingsNotifyEmailHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
								<div style="display:none" id="help_ImageUploaderSettingsNotifyEmail"></div>
							</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								&nbsp;&nbsp; <label for="StoreName">%%LNG_ImageUploaderSettingsInstructions%%</label>
							</td>
							<td>
								%%GLOBAL_ImageUploaderSettingsInstructions%%
								<!--zcs=>
								<img onmouseout="HideHelp('help_ImageUploaderSettingsInstructions');" onmouseover="ShowHelp('help_ImageUploaderSettingsInstructions', '%%LNG_ImageUploaderSettingsInstructions%%', '%%LNG_ImageUploaderSettingsInstructionsHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
								<div style="display:none" id="help_ImageUploaderSettingsInstructions"></div>
								<=zcs-->
							</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								&nbsp;&nbsp; <label for="StoreName">%%LNG_ImageUploaderSettingsAssignment%%</label>
							</td>
							<td>
								%%GLOBAL_ImageUploaderSettingsAssignment%%
								<!--zcs=>
								<img onmouseout="HideHelp('help_ImageUploaderSettingsAssignment');" onmouseover="ShowHelp('help_ImageUploaderSettingsAssignment', '%%LNG_ImageUploaderSettingsAssignment%%', '%%LNG_ImageUploaderSettingsAssignmentHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
								<div style="display:none" id="help_ImageUploaderSettingsAssignment"></div>
								<=zcs-->
							</td>
						</tr>
						<tr>
							<td width="200" class="FieldLabel">
								&nbsp;
							</td>
							<td>
								<input type="hidden" name="dopost" value="1" />
								<input class="FormButton" type="submit" value="%%LNG_Save%%">
								<input type="reset" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()" />
							</td>
						</tr>
				</table>
			</td>
		</tr>
		</table>
		</div>
	</form>

	<script type="text/javascript">

		function ConfirmCancel() {
			if(confirm("%%LNG_ConfirmCancelImageUploaderSettings%%")) {
				document.location.href = "index.php?ToDo=viewImageUploaderSettings";
			}
		}

		function CheckImageUploaderSettingsForm() {
			if(0){
				return false;
			}
			return true;
		}

	</script>
