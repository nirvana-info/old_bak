<form action="index.php?ToDo=%%GLOBAL_FormAction%%" method="post" onsubmit="return ValidateForm(CheckMethodForm)">
	<input type="hidden" name="methodId" id="methodId" value="%%GLOBAL_MethodId%%" />
	<input type="hidden" name="zoneId" id="zoneId" value="%%GLOBAL_ZoneId%%" />
	<input type="hidden" name="currentTab" value="%%GLOBAL_CurrentTab%%" id="currentTab" />
	<div class="BodyContainer">
		<table class="OuterPanel">
			<tr>
				<td class="Heading1">%%GLOBAL_Title%%</td>
			</tr>

			<tr>
				<td class="Intro">
					<p>%%GLOBAL_Intro%%</p>
					%%GLOBAL_Message%%
					<p>
						<input type="submit" name="SubmitButton1" value="%%LNG_Save%%" class="FormButton" />&nbsp;
						<input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()" />
					</p>
				</td>
			</tr>

			<tr>
				<td>
					<table width="100%" class="Panel">
						<tr>
							<td class="Heading2" colspan="2">%%LNG_ShippingMethodSettings%%</td>
						</tr>

						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span> %%LNG_ShippingMethod%%:
							</td>
							<td>
								<div>%%GLOBAL_MethodBasedOn%%</div>
								<div style="%%GLOBAL_HideModuleSelect%%">
									<select name="methodmodule" id="methodmodule" class="Field200" size="10" onchange="UpdateModule($(this).val());">
										%%GLOBAL_ShippingProviders%%
									</select>
									<img onmouseout="HideHelp('methodmodule');" onmouseover="ShowHelp('methodmodule', '%%LNG_ShippingMethod%%', '%%LNG_ShippingMethodHelp%%')" src="images/help.gif" alt="" border="0" />
									<div style="display:none" id="methodmodule"></div>
								</div>
							</td>
						</tr>

						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span> %%LNG_DisplayName%%:
							</td>
							<td>
								<input type="text" onkeypress="updateUsingDefault();" name="methodname" id="methodname" class="Field200" value="%%GLOBAL_MethodName%%" />
								<img onmouseout="HideHelp('methodnamehelp');" onmouseover="ShowHelp('methodnamehelp', '%%LNG_DisplayName%%', '%%LNG_ShippingMethodDisplayNameHelp%%')" src="images/help.gif" alt="" border="0" />
								<div style="display:none" id="methodnamehelp"></div>
							</td>
						</tr>

						<tr id="HandlingSettings" style="%%GLOBAL_HideHandlingFee%%">
							<td class="FieldLabel">
								<span class="Required">&nbsp;</span> %%LNG_HandlingFee%%:
							</td>
							<td>
								%%GLOBAL_LeftCurrencyToken%%
								<input type="text" name="methodhandlingfee" id="methodhandlingfee" class="Field50" value="%%GLOBAL_HandlingFee%%" />
								%%GLOBAL_RightCurrencyToken%%
							</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span> %%LNG_EnableShippingMethod%%?
							</td>
							<td>
								<label><input type="checkbox" name="methodenabled" id="methodenbled" %%GLOBAL_MethodEnabledCheck%% /> %%LNG_YesEnableShippingMethod%%</label>
								<img onmouseout="HideHelp('enabledhelp');" onmouseover="ShowHelp('enabledhelp', '%%LNG_EnableShippingMethod%%?', '%%LNG_EnableShippingMethodHelp%%')" src="images/help.gif" alt="" border="0" />
								<div style="display:none" id="enabledhelp"></div>
							</td>
						</tr>
                        <tr>
							<td class="FieldLabel">
								<span class="Required">&nbsp;</span> %%LNG_DisplayMessage%%:
							</td>
							<td>
								%%GLOBAL_WYSIWYG1%%
							</td>
						</tr>
					</table>
					<br />
					<table width="100%" class="Panel" id="chooseMethodFirst" style="%%GLOBAL_HideChooseMethod%%">
						<tr>
							<td class="Heading2" colspan="2">%%LNG_ShippingSettings%%</td>
						</tr>

						<tr>
							<td colspan="2">
								<p class="MessageBox MessageBoxInfo">%%LNG_ChooseShippingMethodFirst%%</p>
							</td>
						</tr>
					</table>
					<div id="shippingMethodSettings">
						%%GLOBAL_ShippingModuleProperties%%
					</div>
					<table border="0" cellspacing="0" cellpadding="2" width="100%" class="PanelPlain">
						<tr>
							<td class="FieldLabel">&nbsp;</td>
							<td>
								<input type="submit" name="SubmitButton1" value="%%LNG_Save%%" class="FormButton" />&nbsp;
								<input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()" />
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
</form>
<script type="text/javascript">
	var usingDefault = 1;

	function updateUsingDefault()
	{
		usingDefault = 0;
	}

	function ConfirmCancel()
	{
		if(confirm('%%LNG_ConfirmCancel%%')) {
			window.location = 'index.php?ToDo=editShippingZone&zoneId=%%GLOBAL_ZoneId%%&currentTab=1';
		}
	}

function CheckMethodForm()
{
	if(!$('#methodId').val() && !$('#methodmodule').val()) {
		alert('%%LNG_SelectShippingMethod%%');
		$('#methodmodule').focus();
		return false;
	}

	if(!$('#methodname').val()) {
		alert('%%LNG_EnterShippingMethodName%%');
		$('#methodname').focus();
		return false;
	}

	if($('#HandlingSettings').css('display') != 'none') {
		if(isNaN(priceFormat($('#methodhandlingfee')))) {
			alert('%%LNG_EnterValidHandlingFee%%');
			$('#methodhandlingfee').select();
			return;
		}
	}

	if(typeof(ShipperValidation) != 'undefined' && ShipperValidation() == false) {
		return false;
	}

	return true;
}

%%GLOBAL_ShippingProviderErrors%%

function UpdateModule(module) {
	if(module == '' || module == null) {
		$('#chooseMethodFirst').show();
		$('#shippingMethodSettings *').remove();
		return;
	}

	// Is there a reason why this zone cannot be enabled?
	if(typeof(eval('providerErrors.'+module)) != 'undefined') {
		var errors = eval('providerErrors.'+module);
		alert(errors);
		$('#methodmodule').val('');
		return false;
	}

	$.ajax({
		url: 'remote.php',
		method: 'post',
		data: 'w=GetShippingModuleProperties&module='+module,
		success: function(data) {
			$('#shippingMethodSettings').html(data);
			$('#chooseMethodFirst').hide();
			ISSelectReplacement.on_load();
			if(usingDefault == 1) {
				$('#methodname').val($('#shippingMethodSettings #moduleName').html());
			}
		}
	});
}
</script>