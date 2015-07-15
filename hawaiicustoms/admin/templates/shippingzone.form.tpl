<form action="index.php?ToDo=%%GLOBAL_FormAction%%%%GLOBAL_VendorIdAdd%%" id="frmZone" method="post" onsubmit="return ValidateForm(CheckZoneForm)">
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
					<input type="submit" name="SubmitButton1" value="%%GLOBAL_NextButton%%" class="FormButton" />&nbsp;
					<input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()" />
				</p>
			</td>
		</tr>

		<tr>
			<td>
				<ul id="tabnav">
					<li><a href="#" class="active" id="tab0" onclick="ShowTab(0)">%%LNG_ZoneSettings%%</a></li>
					<li><a href="#" id="tab1" style="%%GLOBAL_HideShippingMethods%%" onclick="ShowTab(1)">%%LNG_ShippingMethods%%</a></li>
				</ul>
			</td>
		</tr>

		<tr>
			<td>
				<div id="div0">
					<table width="100%" class="Panel">
						<tr>
							<td class="Heading2" colspan="2">%%LNG_ShippingZoneSettings%%</td>
						</tr>

						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span> %%LNG_ShippingZoneName%%:
							</td>
							<td>
								<input type="text" name="zonename" id="zonename" class="Field200" value="%%GLOBAL_ZoneName%%" />
								<img onmouseout="HideHelp('zonenamehelp');" onmouseover="ShowHelp('zonenamehelp', '%%LNG_ShippingZoneName%%', '%%LNG_ShippingZoneNameHelp%%')" src="images/help.gif" alt="" border="0" />
								<div style="display:none" id="zonenamehelp"></div>
							</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span> %%LNG_ShippingZoneType%%:
							</td>
							<td>
								<div style="%%GLOBAL_HideDefaultZoneType%%">
									%%LNG_ShippingZoneTypeGlobal%%
								</div>
								<div id="ZoneTypeOptions" style="%%GLOBAL_HideZoneTypeFields%%">
								<label style="display: block;"><input type="radio" name="zonetype" id="zonetype_country" onclick="ChangeZoneType(this.value)" value="country" %%GLOBAL_TypeCountriesChecked%% /> %%LNG_ShippingZoneTypeCountry%%</label>
								<div id="ZoneTypeCountry" style="%%GLOBAL_HideZoneTypeCountry%%">
									<table>
										<tr>
											<td style="vertical-align: top;"><img src="images/nodejoin.gif" alt="" /></td>
											<td>
												<select name="zonetype_country_list[]" id="zonetype_country_list" size="15" multiple="multiple" class="Field250 ISSelectReplacement">
													%%GLOBAL_MultipleCountrySelect%%
												</select>
											</td>
										</tr>
									</table>
								</div>
								<label style="display: block;"><input type="radio" name="zonetype" id="zonetype_state" onclick="ChangeZoneType(this.value)" value="state" %%GLOBAL_TypeStatesChecked%% /> %%LNG_ShippingZoneTypeState%%</label>
								<div id="ZoneTypeStates" style="%%GLOBAL_HideZoneTypeStates%%">
									<table>
										<tr>
											<td rowspan="2" style="vertical-align: top;"><img src="images/nodejoin.gif" alt="" /></td>
											<td style="padding-top: 5px; vertical-align: top;">%%LNG_Countries%%:</td>
											<td>
												<select name="zonetype_states_country[]" id="StateCountries" size="10" multiple="multiple" class="Field250 ISSelectReplacement" onchange="UpdateZoneStateSelect(this)">
													%%GLOBAL_MultipleCountrySelect%%
												</select>
											</td>
										</tr>
										<tr>
											<td style="vertical-align: top;">%%LNG_States%%:</td>
											<td>
												<select name="zonetype_states[]" size="10" multiple="multiple" class="Field250 ISSelectReplacement" id="StateSelect" style="%%GLOBAL_HideStateSelect%%">
													%%GLOBAL_StateSelect%%
												</select>
												<div id="ZoneStateSelectNone" style="font-size: 20px; background: #fff; border: 1px solid #7F9DB9; font-weight: bold; color: #aaa; text-align: center; %%GLOBAL_HideStateSelectNone%%"><div style="padding-top: 40px; ">%%LNG_SelectOneOrMoreCountriesFirst%%</div></div>
											</td>
										</tr>
									</table>
								</div>
								<label style="display: block;"><input type="radio" name="zonetype" id="zonetype_zip" onclick="ChangeZoneType(this.value)" value="zip" %%GLOBAL_TypeZipChecked%% /> %%LNG_ShippingZoneTypeZip%%</label>
								<div id="ZoneTypePostCodes" style="%%GLOBAL_HideZoneTypePostCodes%%">
									<table>
										<tr>
											<td rowspan="2" style="vertical-align: top;"><img src="images/nodejoin.gif" alt="" /></td>
											<td>%%LNG_Country%%:</td>
											<td>
												<select name="zonetype_zip_country" id="zonetype_zip_country" class="Field250">
													%%GLOBAL_SingleCountrySelect%%
												</select>
											</td>
										</tr>
										<tr>
											<td style="vertical-align: top;">%%LNG_ZipPostCodes%%:</td>
											<td>
												<textarea name="zonetype_zip_list" id="zonetype_zip_list" class="Field250" rows="10" cols="10">%%GLOBAL_ZonePostCodes%%</textarea><br />
												%%LNG_ZipPostCodesPerLine%%<br />
												<a href='#' onclick='LaunchHelp(850); return false;' target="_blank">%%LNG_LearnMoreAboutEnteringPostCodes%%</a>
											</td>
										</tr>
									</table>
								</div>
								</div>
							</td>
						</tr>
						<tr style="%%GLOBAL_HideZoneEnabled%%">
							<td class="FieldLabel">
								<span class="Required">*</span> %%LNG_EnableShippingZone%%?
							</td>
							<td>
								<label><input type="checkbox" name="zoneenabled" id="zoneenabled" %%GLOBAL_ZoneEnabledCheck%% /> %%LNG_YesEnableShippingZone%%</label>
								<img onmouseout="HideHelp('zoneenabledhelp');" onmouseover="ShowHelp('zoneenabledhelp', '%%LNG_EnableShippingZone%%?', '%%LNG_EnableShippingZoneHelp%%')" src="images/help.gif" alt="" border="0" />
								<div style="display:none" id="zoneenabledhelp"></div>
							</td>
						</tr>
					</table>
					<br />
					<table width="100%" class="Panel">
						<tr>
							<td class="Heading2" colspan="2">%%LNG_FreeShippingAndHandlingSettings%%</td>
						</tr>

						<tr>
							<td class="FieldLabel">
								<span class="Required">&nbsp;</span>&nbsp;%%LNG_EnableFreeShipping%%?
							</td>
							<td>
								<label><input type="checkbox" name="zonefreeshipping" id="zonefreeshipping" value="1" onclick="ToggleFreeShipping(this.checked)" %%GLOBAL_FreeShippingChecked%% /> %%LNG_YesEnableFreeShipping%%</label>
								<img onmouseout="HideHelp('zonefreehelp');" onmouseover="ShowHelp('zonefreehelp', '%%LNG_EnableFreeShipping%%', '%%LNG_EnableFreeShippingHelp%%')" src="images/help.gif" alt="" border="0" />
								<div style="display:none" id="zonefreehelp"></div>
								<div id="FreeShippingOptions" style="%%GLOBAL_HideFreeShipping%%">
									<table>
										<tr>
											<td><img src="images/nodejoin.gif" alt="" /></td>
											<td>%%LNG_OrderTotalToQualify%%:</td>
											<td>
												%%GLOBAL_LeftCurrencyToken%%
												<input type="text" name="zonefreeshippingtotal" id="zonefreeshippingtotal" class="Field50" value="%%GLOBAL_FreeShippingTotal%%" />
												%%GLOBAL_RightCurrencyToken%%
											</td>
										</tr>
									</table>
								</div>
							</td>
						</tr>

						<tr>
							<td class="FieldLabel">
								<span class="Required">&nbsp;</span>&nbsp;%%LNG_HandlingFee%%:
							</td>
							<td>
								<label style="display: block;"><input type="radio" name="zonehandlingtype" value="none" onclick="ToggleHandlingType(this.value)" %%GLOBAL_HandlingNoneChecked%% /> %%LNG_DoNotApplyZoneHandling%%</label>
								<label style="display: block;"><input type="radio" name="zonehandlingtype" id="zonehandlingtype_global" value="global" onclick="ToggleHandlingType(this.value)" %%GLOBAL_HandlingGlobalChecked%% /> %%LNG_ApplyZoneHandling1%%</label>
								<div id="HandlingFeeGlobal" style="%%GLOBAL_HideHandlingFeeGlobal%%">
									<table>
										<tr>
											<td><img src="images/nodejoin.gif" alt="" /></td>
											<td>
												%%LNG_HandlingFee%%: %%GLOBAL_LeftCurrencyToken%%
												<input type="text" name="zonehandlingfee" id="zonehandlingfee" class="Field50" value="%%GLOBAL_HandlingFee%%" />
												%%GLOBAL_RightCurrencyToken%%
											</td>
										</tr>
									</table>
								</div>
								<label style="display: block;"><input type="radio" name="zonehandlingtype" value="module" onclick="ToggleHandlingType(this.value)" %%GLOBAL_HandlingOptionChecked%% /> %%LNG_ApplyZoneHandling2%%</label>
							</td>
						</tr>
						<tr class="HandlingHide" style="%%GLOBAL_HideHandlingSeparate%%">
							<td class="FieldLabel">
								&nbsp;&nbsp;%%LNG_ShowSeparately%%
							</td>
							<td class="PanelBottom">
								<input type="checkbox" name="zonehandlingseparate" id="zonehandlingseparate" value="1" %%GLOBAL_HandlingSeparateChecked%% /> <label for="zonehandlingseparate">%%LNG_YesShowSeparately%%</label>
								<img onmouseout="HideHelp('d10');" onmouseover="ShowHelp('d10', '%%LNG_ShowSeparately%%', '%%LNG_ShowSeparatelyHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="d10"></div>
							</td>
						</tr>

					</table>
						<table border="0" cellspacing="0" cellpadding="2" width="100%" class="PanelPlain">
						<tr>
							<td class="FieldLabel">&nbsp;</td>
							<td>
								<input type="submit" name="SubmitButton1" value="%%GLOBAL_NextButton%%" class="FormButton" />&nbsp;
								<input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()" />
							</td>
						</tr>
					</table>
				</div>

				<div id="div1" style="display: none;">
					<p class="Intro">
						%%LNG_ZoneShippingMethodsIntro%%
					</p>
					%%GLOBAL_MethodsMessage%%
					<p class="Intro">
						<input type="button" value="%%LNG_AddAShippingMethodButton%%" class="SmallButton Field150" onclick="window.location = 'index.php?ToDo=addShippingZoneMethod&amp;zoneId=%%GLOBAL_ZoneId%%';" />
						<input type="button" value="%%LNG_DeleteSelected%%" class="SmallButton" onclick="return ConfirmDeleteSelected();" %%GLOBAL_DisableDeleteMethods%% />
					</p>

					<table width="100%" class="GridPanel" cellspacing="0" cellpadding="0" style="%%GLOBAL_HideShippingMethodsGrid%%">
						<tr class="Heading3">
							<td style="text-align: center; width: 10px;"><input type="checkbox" onclick="$(this.parentForm).find('input:checkbox').not(':disabled').attr('checked', this.checked);" /></td>
							</td>
							<td style="width: 1px;">&nbsp;</td>
							<td>%%LNG_Name%%</td>
							<td>%%LNG_ShippingMethod%%</td>
							<td style="width: 50px; text-align: center;">%%LNG_Status%%</td>
							<td>%%LNG_Action%%</td>
						</tr>
						%%GLOBAL_ShippingZoneMethods%%
					</table>
				</div>
		</td>
	</tr>
	</table>
</div>
</form>
<script type="text/javascript">
	function CheckZoneForm()
	{
		if($('#frmZone').attr('action').indexOf('deleteShippingZoneMethods') != -1) {
			return true;
		}

		if(!$('#zonename').val()) {
			alert('%%LNG_EnterShippingZoneName%%');
			$('#zonename').focus();
			return false;
		}

		// If not editing the default, need to check the zone type
		if($('#ZoneTypeOptions').css('display') != 'none') {
			if($('#zonetype_country').attr('checked') == true) {
				if(g('zonetype_country_list').selectedIndex == -1) {
					alert('%%LNG_SelectOneMoreZoneCountries%%');
					$('#zonetype_country_list').focus();
					return false;
				}
			}
			else if($('#zonetype_state').attr('checked') == true) {
				if(g('StateCountries').selectedIndex == -1 || g('StateSelect').selectedIndex == -1) {
					alert('%%LNG_SelectOneMoreZoneStates%%');
					$('#StateSelect').focus();
					return false;
				}
			}
			else if($('#zonetype_zip').attr('checked') == true) {
				if($('#zonetype_zip_country').val() < 1) {
					alert('%%LNG_SelectZoneZipCountry%%');
					$('#zonetype_zip_country').focus();
					return false;
				}

				if(!$('#zonetype_zip_list').val()) {
					alert('%%LNG_EnterOneMoreZoneZipCodes%%');
					$('#zonetype_zip_list').focus();
					return false;
				}
			}
			else {
				alert('%%LNG_SelectZoneType%%');
				return false;
			}
		}

		if($('#zonefreeshipping').attr('checked') == true) {
			if(isNaN(priceFormat($('#zonefreeshippingtotal').val()))) {
				alert('%%LNG_EnterValidFreeShippingTotal%%');
				$('#zonefreeshippingtotal').select();
				return false;
			}
		}

		if($('#zonehandlingtype_global').attr('checked') == true) {
			if(isNaN(priceFormat($('#zonehandlingfee')))) {
				alert('%%LNG_EnterValidHandlingFee%%');
				$('#zonehandlingfee').select();
				return;
			}
		}
		return true;
	}

	function UpdateZoneStateSelect()
	{
		var options = document.getElementById('StateCountries').options;
		var selectedCount = 0;
		for(var i = 0; i < options.length; ++i) {
			var option = options[i];
			var countryId = option.value;
			if(option.selected == true) {
				if($('#StateSelect .country'+countryId).length == 0) {
					LoadZoneCountryStates(countryId, option.innerHTML);
				}
				++selectedCount;
			}
			else {
				$('#StateSelect .country'+countryId).remove();
				$('#StateSelect_old .country'+countryId).remove();
			}
		}

		if(selectedCount == 0) {
			$('#ZoneStateSelectNone').css({width: $('#StateSelect').width(), height: $('#StateSelect').height()});
			$('#StateSelect').hide();
			$('#ZoneStateSelectNone').show();
		}
		else {
			$('#StateSelect').show();
			$('#ZoneStateSelectNone').hide();
		}
	}

	function LoadZoneCountryStates(countryId, countryName) {
		// Load this country in
		$.ajax({
			url: 'remote.php?w=countryStates&c='+countryId,
			method: 'GET',
			success: function(response) {
				var options = '';
				if(response != '') {
					states = response.split("~");
					for(i = 0; i < states.length; i++) {
						vals = states[i].split("|");
						if(states[i].length > 0) {
							options += '<option value="'+countryId+'-'+vals[1]+'">'+vals[0]+'</option>';
						}
					}
				}
				var data = '<option value="'+countryId+'-0">-- %%LNG_AllStatesProvinces%% --</option>' + options;
				if(document.getElementById('StateSelect_old')) {
					$('#StateSelect').remove();
					$('#StateSelect_old').attr('id', 'StateSelect');
				}
				$('#StateSelect').append('<optgroup class="country'+countryId+'" label="'+countryName+'">'+data+'</optgroup>');
				$('#StateSelect').css({display: 'block'});
				ISSelectReplacement.replace_select(document.getElementById('StateSelect'));
				ISSelectReplacement.scrollToItem('zonetype_states', countryId+'-0', 1);
			}
		});
	}

	function ToggleHandlingType(type)
	{
		if(type == 'global') {
			$('#HandlingFeeGlobal').show();
		}
		else {
			$('#HandlingFeeGlobal').hide();
		}

		if(type == 'none') {
			$('.HandlingHide').hide();
		}
		else {
			$('.HandlingHide').show();
		}
	}

	function ToggleFreeShipping(state)
	{
		if(state) {
			$('#FreeShippingOptions').show();
		}
		else {
			$('#FreeShippingOptions').hide();
		}
	}

	function ChangeZoneType(type)
	{
		switch(type) {
			case "state":
				$('#ZoneStateSelectNone').css({width: $('#StateSelect').css('width'), height: $('#StateSelect').css('height')});
				$('#ZoneTypeCountry').hide();
				$('#ZoneTypeStates').show();
				$('#ZoneTypePostCodes').hide();
				break;
			case "zip":
				$('#ZoneTypeCountry').hide();
				$('#ZoneTypeStates').hide();
				$('#ZoneTypePostCodes').show();
				break;
			default:
				$('#ZoneTypeCountry').show();
				$('#ZoneTypeStates').hide();
				$('#ZoneTypePostCodes').hide();
		}
	}

	function ConfirmCancel()
	{
		if(confirm('%%LNG_ConfirmCancel%%')) {
			if('%%GLOBAL_CurrentVendor%%' != 0) {
				window.location = 'index.php?ToDo=editVendor&vendorId=%%GLOBAL_CurrentVendor%%&currentTab=1';
			}
			else {
				window.location = 'index.php?ToDo=viewShippingSettings&currentTab=1';
			}
		}

		return false;
	}

	function ShowTab(T)
	{
		i = 0;
		while (document.getElementById("tab" + i) != null) {
			document.getElementById("div" + i).style.display = "none";
			document.getElementById("tab" + i).className = "";
			i++;
		}

		document.getElementById("div" + T).style.display = "";
		document.getElementById("tab" + T).className = "active";
		document.getElementById("currentTab").value = T;
	}

	function ConfirmDeleteSelected()
	{
		if(!$('.GridPanel input[type=checkbox].check:checked').length) {
			alert('%%LNG_SelectOneMoreShippingMethodsDelete%%');
			return false;
		}
		if(confirm('%%LNG_ConfirmDeleteShippingMethods%%')) {
			$('#frmZone').attr('action', 'index.php?ToDo=deleteShippingZoneMethods');
			$('#frmZone').submit();
		}
		else {
			return false;
		}
	}

	$(document).ready(function() {
		if($('#currentTab').val()) {
			ShowTab($('#currentTab').val());
		}
	});
</script>