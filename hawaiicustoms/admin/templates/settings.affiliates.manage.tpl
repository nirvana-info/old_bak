
	<form action="index.php?ToDo=saveUpdatedAffiliateSettings" name="frmAffiliateSettings" id="frmAffiliateSettings" method="post" onsubmit="return ValidateForm(CheckAffiliateSettingsForm)">
		<div class="BodyContainer">
		<table cellSpacing="0" cellPadding="0" width="100%" style="margin-left: 4px; margin-top: 8px;">
		<tr>
			<td class="Heading1">%%LNG_AffiliateSettings%%</td>
		</tr>
		<tr>
			<td class="Intro">
				<p>%%LNG_AffiliateSettingsIntro%%</p>
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
						<tr>
							<td class="FieldLabel">
								<label for="storename">%%LNG_AffiliateConversionTrackingCode%%:</label>
							</td>
							<td class="PanelBottom">
								<textarea name="AffiliateConversionTrackingCode" id="AffiliateConversionTrackingCode" rows="10" class="Field400 ISSelectReplacement">%%GLOBAL_AffiliateConversionTrackingCode%%</textarea>
								<img onmouseout="HideHelp('d1');" onmouseover="ShowHelp('d1', '%%LNG_AffiliateConversionTrackingCode%%', '%%LNG_AffiliateConversionTrackingCodeHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="d1"></div>
								<div style="padding-top:2px">
									<a href="#" onclick="LaunchHelp(805)" style="color:gray">%%LNG_AffiliateHowPass%%</a>
								</div>
							</td>
						</tr>
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

		function ConfirmCancel() {
			if(confirm("%%LNG_ConfirmCancelAffiliateSettings%%")) {
				document.location.href = "index.php?ToDo=viewAffiliateSettings";
			}
		}

		function CheckAffiliateSettingsForm() {
			// Show an alert if the affiliate tracking code doesn't contain %%ORDER_AMOUNT%%
			if($('#AffiliateConversionTrackingCode').val() != '' && $('#AffiliateConversionTrackingCode').val().indexOf('%%ORDER_AMOUNT%%') == -1) {
				if(confirm('--- Your Affiliate Tracking Code Is Invalid ---\n\nYou haven\'t setup placeholders to pass back the order\'s total amount. Without these your affiliate tracking program wont show correct order amounts for your affiliates. Click the \'How do I pass order details back to my affiliate program?\' link for a guide on how to do it.\n\nClick OK to save anyway or click Cancel to change your conversion tracking code.')) {
					return true;
				}
				else {
					return false;
				}
			}

			return true;
		}

	</script>
