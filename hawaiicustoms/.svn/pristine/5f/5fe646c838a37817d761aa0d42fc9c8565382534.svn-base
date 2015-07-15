	<form action="index.php?ToDo=saveUpdatedGiftCertificateSettings" name="frmGiftCertificateSettings" id="frmGiftCertificateSettings" method="post" onsubmit="return ValidateForm(CheckGiftCertificateSettingsForm)">
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
						<td class="Heading2" colspan="2">%%LNG_GiftCertificateSettings%%</td>
					</tr>

					<tr>
						<td class="FieldLabel">
							%%LNG_EnableGiftCertificates%%
						</td>
						<td>
							<label><input type="checkbox" name="EnableGiftCertificates" id="EnableGiftCertificates" value="1" %%GLOBAL_IsEnableGiftCertificates%% onclick="ToggleGiftCertificatesStatus(this.checked)" /> %%LNG_YesEnableGiftCertificates%%</label>
							<img onmouseout="HideHelp('gifts1');" onmouseover="ShowHelp('gifts1', '%%LNG_EnableGiftCertificates%%', '%%LNG_EnableGiftCertificatesHelp%%')" src="images/help.gif" width="24" height="16" border="0">
							<div style="display:none" id="gifts1"></div>
						</td>
					</tr>

					<tr class="HideOnDisabled">
						<td class="FieldLabel">
							%%LNG_GiftCertificateAmounts%%:
						</td>
						<td style="padding-left: 25px;">
							<label><input type="radio" name="GiftCertificateCustomAmounts" id="GiftCertificateCustomAmountsNo"  onclick="$('#AmountsSelect').show();  $('#AmountsRange').hide();" value="0" %%GLOBAL_IsGiftCertificateSelectAmounts%% /> %%LNG_GiftCertificateSelectAmounts%%</label><br />
							<div id="AmountsSelect" style="display: %%GLOBAL_HideSelectAmounts%%">
								<img src="images/nodejoin.gif" style="vertical-align: top;" />
								<textarea name="GiftCertificateAmounts" id="GiftCertificateAmounts" class="Field250" rows="6">%%GLOBAL_GiftCertificateAmountsArea%%</textarea>
								<img onmouseout="HideHelp('gifts2');" onmouseover="ShowHelp('gifts2', '%%LNG_GiftCertificateAmounts%%', '%%LNG_GiftCertificateAmountsHelp%%')" src="images/help.gif" width="24" height="16" border="0" style="vertical-align: top;" />
								<div style="display:none" id="gifts2"></div>
							</div>
							<label><input type="radio" onclick="$('#AmountsSelect').hide(); $('#AmountsRange').show();" name="GiftCertificateCustomAmounts" id="GiftCertificateCustomAmounts" value="1" %%GLOBAL_IsGiftCertificateCustomAmounts%% />%%LNG_GiftCertificateCustomAmounts%%</label>
							<div id="AmountsRange" style="display: %%GLOBAL_HideCustomAmounts%%">
								<img src="images/nodejoin.gif" style="vertical-align: middle;" />
								%%LNG_GiftCertificateMinAmount%% %%GLOBAL_CurrencyTokenLeft%% <input type="text" name="GiftCertificateMinimum" id="GiftCertificateMinimum" value="%%GLOBAL_GiftCertificateMinimum%%" class="Field40" /> %%GLOBAL_CurrencyTokenRight%%
								&nbsp;&nbsp;&nbsp;
								%%LNG_GiftCertificateMaxAmount%% %%GLOBAL_CurrencyTokenLeft%% <input type="text" name="GiftCertificateMaximum" id="GiftCertificateMaximum" value="%%GLOBAL_GiftCertificateMaximum%%" class="Field40" /> %%GLOBAL_CurrencyTokenRight%%
							</div>
						</td>
					</tr>

					<tr class="HideOnDisabled">
						<td class="FieldLabel PanelBottom">
							%%LNG_GiftCertificateExpiry%%:
						</td>
						<td style="padding-left: 25px;" class="PanelBottom">
							<label><input type="checkbox" name="EnableGiftCertificateExpiry" id="EnableGiftCertificateExpiry" value="1" onclick="if(this.checked == true) { $('#EnableExpiryOptions').show(); } else { $('#EnableExpiryOptions').hide(); }" %%GLOBAL_IsGiftCertificateExpiry%% /> %%LNG_YesEnableGiftCertificateExpiry%%</label>

							<img onmouseout="HideHelp('gifts5');" onmouseover="ShowHelp('gifts5', '%%LNG_GiftCertificateExpiry%%', '%%LNG_GiftCertificateExpiryHelp%%')" src="images/help.gif" width="24" height="16" border="0">
							<div style="display:none" id="gifts5"></div>

							<div id="EnableExpiryOptions">
								<img src="images/nodejoin.gif" style="vertical-align: middle;" />
								%%LNG_GiftCertificateExpiryOptions%%
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

				<table width="100%" class="Panel HideOnDisabled">
					<tr>
						<td class="Heading2" colspan="2">%%LNG_GiftCertificateSettings%%</td>
					</tr>

					<tr>
						<td class="FieldLabel PanelBottom">
							%%LNG_GiftCertificateThemes%%:
						</td>
						<td style="padding-left: 25px; padding-top: 10px;" class="PanelBottom">
							<div style="float: left; width: 170px;">
								%%GLOBAL_ThemeOptions%%
							</div>
							<div id="ThemePreview" style="margin-top: 2px; width: 350px; float: left; height: 133px;">
								<img src="images/gift_certificate_preview.jpg" alt="" class="NoPreview" style="border: 1px solid #000;" />
								%%GLOBAL_ThemePreviews%%
								<div style="padding-top: 3px; color: gray; font-style: italic; text-align: center; font-size: 11px;">&nbsp;</div>
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
