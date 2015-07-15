	<form action="index.php?ToDo=saveUpdatedReturnsSettings" name="frmReturnsSettings" id="frmReturnsSettings" method="post" onsubmit="return ValidateForm(CheckReturnsSettingsForm)">
		<div class="BodyContainer">
		<table cellSpacing="0" cellPadding="0" width="100%" style="margin-left: 4px; margin-top: 8px;">
		<tr>
			<td class="Heading1">%%LNG_ReturnsSettings%%</td>
		</tr>
		<tr>
			<td class="Intro">
				<p>%%LNG_ReturnsSettingsIntro%%</p>
				%%GLOBAL_Message%%
				<p>
				<input type="submit" value="%%LNG_Save%%" class="FormButton" />
				<input type="reset" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()" />
				</p>
			</td>
		</tr>
		<tr>
			<td>
				<table width="100%" class="Panel">
					<tr>
						<td class="Heading2" colspan="2">%%LNG_ReturnsSettings%%</td>
					</tr>

					<tr>
						<td class="FieldLabel">
							%%LNG_EnableReturnsSystem%%
						</td>
						<td>
							<label><input type="checkbox" name="enablereturns" id="enablereturns" value="1" %%GLOBAL_IsEnableReturns%% onclick="ToggleReturnsStatus(this.checked)" /> %%LNG_YesEnableReturnsSystem%%</label>
							<img onmouseout="HideHelp('returns1');" onmouseover="ShowHelp('returns1', '%%LNG_EnableReturnsSystem%%', '%%LNG_EnableReturnsHelp%%')" src="images/help.gif" width="24" height="16" border="0">
							<div style="display:none" id="returns1"></div>
						</td>
					</tr>

					<tr class="HideOnDisabled">
						<td class="FieldLabel">
							%%LNG_ReturnInstructions%%:
						</td>
						<td style="padding-left: 25px;">
							<textarea name="returninstructions" id="returninstructions" class="Field300" rows="6">%%GLOBAL_ReturnInstructions%%</textarea>
							<img onmouseout="HideHelp('returns2');" onmouseover="ShowHelp('returns2', '%%LNG_ReturnInstructions%%', '%%LNG_ReturnInstructionsHelp%%')" src="images/help.gif" width="24" height="16" border="0">
							<div style="display:none" id="returns2"></div>
						</td>
					</tr>

					<tr class="HideOnDisabled">
						<td class="FieldLabel">
							%%LNG_ReturnReasons%%:
						</td>
						<td style="padding-left: 25px;">
							<textarea name="returnreasons" id="returnreasons" class="Field300" rows="6">%%GLOBAL_ReturnReasonsArea%%</textarea>
							<img onmouseout="HideHelp('returns3');" onmouseover="ShowHelp('returns3', '%%LNG_ReturnReasons%%', '%%LNG_ReturnReasonsHelp%%')" src="images/help.gif" width="24" height="16" border="0">
							<div style="display:none" id="returns3"></div>
						</td>
					</tr>

					<tr class="HideOnDisabled">
						<td class="FieldLabel">
							%%LNG_ReturnActions%%:
						</td>
						<td style="padding-left: 25px;">
							<textarea name="returnactions" id="returnactions" class="Field300" rows="6">%%GLOBAL_ReturnActionsArea%%</textarea>
							<img onmouseout="HideHelp('returns4');" onmouseover="ShowHelp('returns4', '%%LNG_ReturnActions%%', '%%LNG_ReturnActionsHelp%%')" src="images/help.gif" width="24" height="16" border="0">
							<div style="display:none" id="returns4"></div>
						</td>
					</tr>

					<tr class="HideOnDisabled PanelBottom">
						<td class="FieldLabel">
							%%LNG_ReturnCredits%%
						</td>
						<td style="padding-left: 25px;">
							<label><input type="checkbox" name="returncredits" id="returncredits" value="1" %%GLOBAL_IsReturnCredits%% /> %%LNG_YesEnableReturnCredits%%</label>
							<img onmouseout="HideHelp('returns5');" onmouseover="ShowHelp('returns5', '%%LNG_ReturnCredits%%', '%%LNG_ReturnCreditsHelp%%')" src="images/help.gif" width="24" height="16" border="0">
							<div style="display:none" id="returns5"></div>
						</td>
					</tr>
				</table>

				<table width="100%" class="Panel HideOnDisabled">
					<tr>
						<td class="Heading2" colspan="2">%%LNG_ReturnsNotifications%%</td>
					</tr>

					<tr>
						<td class="FieldLabel">
							%%LNG_NotifyOnReturn%%:
						</td>
						<td>
							<label><input type="checkbox" name="returnotifyowner" id="returnotifyowner" value="1" %%GLOBAL_IsReturnNotifyOwner%% /> %%LNG_YesEnableReturnNotifyOwner%%</label><br />
							<label><input type="checkbox" name="returnnotifycustomer" id="returnnotifycustomer" value="1" %%GLOBAL_IsReturnNotifyCustomer%% /> %%LNG_YesEnableReturnNotifyCustomer%%</label><br />
							<label><input type="checkbox" name="returnnotifystatus" id="returnnotifystatus" value="1" %%GLOBAL_IsReturnNotifyStatusChange%% /> %%LNG_YesEnableReturnNotifyStatusChange%%</label><br />
						</td>
					</tr>
				</table>
				<table border="0" cellspacing="0" cellpadding="2" width="100%" class="PanelPlain">
					<tr>
						<td width="200" class="FieldLabel">
							&nbsp;
						</td>
						<td>
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
		function CheckReturnsSettingsForm() {
			if($('enablereturns').get().checked == true && $('#returnreasons').val() == "") {
				alert('%%LNG_EnterReturnReason%%');
				$('#returnreasons').focus();
				$('#returnreasons').select();
				return false;
			}

			return true;
		}

		function ToggleReturnsStatus(status) {
			if(status == true) {
				$('.HideOnDisabled').show();
			}
			else {
				$('.HideOnDisabled').hide();
			}
		}

		$(document).ready(function () {
			if ($('#enablereturns').attr('checked') == true) {
				$('.HideOnDisabled').show();
			} else {
				$('.HideOnDisabled').hide();
			}
		});
	</script>
