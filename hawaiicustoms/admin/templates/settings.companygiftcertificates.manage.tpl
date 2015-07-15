	<form action="index.php?ToDo=saveUpdatedCompanyGiftCertificateSettings" name="frmGiftCertificateSettings" id="frmGiftCertificateSettings" method="post" onsubmit="return ValidateForm(CheckGiftCertificateSettingsForm)">
		<div class="BodyContainer">
		<table cellSpacing="0" cellPadding="0" width="100%" style="margin-left: 4px; margin-top: 8px;">
		<tr>
			<td class="Heading1">%%LNG_GiftCertificateSettings%%</td>
		</tr>
		<tr>
			<td class="Intro">
				<p>%%LNG_GiftCertificateSettingsIntro%%</p>
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
						<td class="Heading2" colspan="2">%%LNG_CompanyGiftCertificateSettings%%</td>
					</tr>

					<tr>
						<td class="FieldLabel" style="width:200px;">
							%%LNG_EnableCompanyGiftCertificates%%
						</td>
						<td>
							<label><input type="checkbox" name="EnableGiftCertificates" id="EnableGiftCertificates" value="1" %%GLOBAL_IsEnableGiftCertificates%% onclick="ToggleGiftCertificatesStatus(this.checked)" /> %%LNG_YesEnableGiftCertificates%%</label>
							<img onmouseout="HideHelp('gifts1');" onmouseover="ShowHelp('gifts1', '%%LNG_EnableGiftCertificates%%', '%%LNG_EnableCompanyGiftCertificatesHelp%%')" src="images/help.gif" width="24" height="16" border="0">
							<div style="display:none" id="gifts1"></div>
						</td>
					</tr>

					<tr class="HideOnDisabled">
						<td class="FieldLabel PanelBottom">
							%%LNG_CompanyGiftCertificateExpiry%%:
						</td>
						<td style="padding-left: 25px;" class="PanelBottom">
							<label><input type="checkbox" name="EnableGiftCertificateExpiry" id="EnableGiftCertificateExpiry" value="1" onclick="if(this.checked == true) { $('#EnableExpiryOptions').show(); } else { $('#EnableExpiryOptions').hide(); }" %%GLOBAL_IsGiftCertificateExpiry%% /> %%LNG_YesEnableCompanyGiftCertificateExpiry%%</label>

							<img onmouseout="HideHelp('gifts5');" onmouseover="ShowHelp('gifts5', '%%LNG_CompanyGiftCertificateExpiry%%', '%%LNG_CompanyGiftCertificateExpiryHelp%%')" src="images/help.gif" width="24" height="16" border="0">
							<div style="display:none" id="gifts5"></div>

							<div id="EnableExpiryOptions">
								<img src="images/nodejoin.gif" style="vertical-align: middle;" />
								%%LNG_CompanyGiftCertificateExpiryOptions%%
								<input type="text" name="GiftCertificateExpiry" id="GiftCertificateExpiry" value="%%GLOBAL_ExpiresAfter%%" class="Field40" />
								<select name="GiftCertificateExpiryRange" id="GiftCertificateExpiryRange">
									<option value="days">%%LNG_RangeDays%%</option>
									<option value="weeks" %%GLOBAL_RangWeeksSelected%%>%%LNG_RangeWeeks%%</option>
									<option value="months" %%GLOBAL_RangeMonthsSelected%%>%%LNG_RangeMonths%%</option>
									<option value="years" %%GLOBAL_RangeYearsSelected%%>%%LNG_RangeYears%%</option>
								</select>
							</div>

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
		function CheckGiftCertificateSettingsForm() {
			if($('enablereturns').get().checked == true && $('#returnreasons').val() == "") {
				alert('%%LNG_EnterReturnReason%%');
				$('#returnreasons').focus();
				$('#returnreasons').select();
				return false;
			}

			return true;
		}

		function ToggleGiftCertificateCustomAmounts(status) {
			if(status == true) {
				$('#EnableCustomAmountOptions').show();
			}
			else {
				$('#EnableCustomAmountOptions').hide();
			}
		}

		function ToggleGiftCertificatesStatus(status) {
			if(status == true) {
				$('.HideOnDisabled').show();
			}
			else {
				$('.HideOnDisabled').hide();
			}
		}

		function UpdateGiftCertificatePreview(id, name) {
			if(g('ThemePreview_'+id)) {
				$('#ThemePreview img').hide();
				$('#ThemePreview #ThemePreview_'+id).show();
				$('#ThemePreview div').html('%%LNG_GiftCertificateViewingPreview%%'.replace('%s', name));
			}
			else {
				$('#ThemePreview img').hide();
				$('#ThemePreview .NoPreview').show();
				$('#ThemePreview div').html('');
			}
		}

		$(document).ready(function() {
			if ($('#EnableGiftCertificates').attr('checked') == true) {
				$('.HideOnDisabled').show();
			} else {
				$('.HideOnDisabled').hide();
			}

			if ($('#EnableGiftCertificateExpiry').attr('checked') == true) {
				$('#EnableExpiryOptions').show();
			}
			else {
				$('#EnableExpiryOptions').hide();
			}
		});

	</script>
