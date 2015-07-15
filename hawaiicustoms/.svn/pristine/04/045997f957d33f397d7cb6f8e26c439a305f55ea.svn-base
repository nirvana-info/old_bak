<form action="index.php?ToDo=%%GLOBAL_FormAction%%" id="frmVendor" method="post" onsubmit="return ValidateForm(CheckVendorForm)" enctype="multipart/form-data">
	<input type="hidden" name="vendorId" id="vendorId" value="%%GLOBAL_VendorId%%" />
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
					<input type="submit" name="SaveButton1" value="%%LNG_SaveAndExit%%" class="FormButton" />
					<input type="submit" name="SaveAddAnotherButton1" value="%%GLOBAL_SaveAndAddAnother%%" name="addAnother" class="FormButton" style="width:130px" />
					<input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()" />				</p>
			</td>
		</tr>

		<tr>
			<td>
				<ul id="tabnav">
					<li><a href="#" class="active" id="tab0" onclick="ShowTab(0)">%%LNG_VendorInformation%%</a></li>
					<li style="%%GLOBAL_HideShipping%%"><a href="#" id="tab1" onclick="ShowTab(1)">%%LNG_VendorShipping%%</a></li>
				</ul>
				<div id="div0">
					<table width="100%" class="Panel">
						<tr>
							<td class="Heading2" colspan="2">%%LNG_VendorProfile%%</td>
						</tr>

						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span> %%LNG_VendorName%%:
							</td>
							<td>
								<input type="text" name="vendorname" id="vendorname" class="Field250" value="%%GLOBAL_VendorName%%" />
								<img onmouseout="HideHelp('vendornamehelp');" onmouseover="ShowHelp('vendornamehelp', '%%LNG_VendorName%%', '%%LNG_VendorNameHelp%%')" src="images/help.gif" alt="" border="0" />
								<div style="display:none" id="vendornamehelp"></div>
							</td>
						</tr>

						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span> %%LNG_VendorPhone%%:
							</td>
							<td>
								<input type="text" name="vendorphone" id="vendorphone" class="Field250" value="%%GLOBAL_VendorPhone%%" />
								<img onmouseout="HideHelp('vendorphonehelp');" onmouseover="ShowHelp('vendorphonehelp', '%%LNG_VendorPhone%%', '%%LNG_VendorPhoneHelp%%')" src="images/help.gif" alt="" border="0" />
								<div style="display:none" id="vendorphonehelp"></div>
							</td>
						</tr>

						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span> <label for="vendorzip">%%LNG_VendorEmail%%:</label>
							</td>
							<td class="PanelBottom">
								<input type="text" name="vendoremail" id="vendoremail" value="%%GLOBAL_VendorEmail%%" class="Field250" />
								<img onmouseout="HideHelp('vendoremailhelp');" onmouseover="ShowHelp('vendoremailhelp', '%%LNG_VendorEmail%%', '%%LNG_VendorEmailHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="vendoremailhelp"></div>
							</td>
						</tr>

						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span> <label for="vendoraddress">%%LNG_VendorAddress%%:</label>
							</td>
							<td>
								<input type="text" name="vendoraddress" id="vendoraddress" value="%%GLOBAL_VendorAddress%%" class="Field250" />
								<img onmouseout="HideHelp('vendoraddresshelp');" onmouseover="ShowHelp('vendoraddresshelp', '%%LNG_CompanyAddress%%', '%%LNG_CompanyAddressHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="vendoraddresshelp"></div>
							</td>
						</tr>

						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span> <label for="vendorcity">%%LNG_VendorCity%%:</label>
							</td>
							<td>
								<input type="text" name="vendorcity" id="vendorcity" value="%%GLOBAL_VendorCity%%" class="Field250" />
								<img onmouseout="HideHelp('vendorcityhelp');" onmouseover="ShowHelp('vendorcityhelp', '%%LNG_VendorCity%%', '%%LNG_VendorCityHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="vendorcityhelp"></div>
							</td>
						</tr>

						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span> <label for="vendorcountry">%%LNG_VendorCountry%%:</label>
							</td>
							<td>
								<select name="vendorcountry" id="vendorcountry" class="Field250 " onchange="GetStates(this, 'vendorstate', 'vendorstate1')">
									%%GLOBAL_CountryList%%
								</select>
								<img onmouseout="HideHelp('vendorcountryhelp');" onmouseover="ShowHelp('vendorcountryhelp', '%%LNG_VendorCountry%%', '%%LNG_VendorCountryHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="vendorcountryhelp"></div>
							</td>
						</tr>

						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span> <label for="vendorstate">%%LNG_VendorState%%:</label>
							</td>
							<td class="Field">
								<select style="%%GLOBAL_HideStateList%%" name="vendorstate" id="vendorstate" class="Field250">
									<option value="">%%LNG_ChooseState%%</option>
									%%GLOBAL_StateList%%
								</select>
								<input style="%%GLOBAL_HideStateBox%%" type="text" name="vendorstate1" id="vendorstate1" class="Field250" value="%%GLOBAL_VendorState%%" />
							</td>
						</tr>

						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span> <label for="vendorzip">%%LNG_VendorZip%%:</label>
							</td>
							<td class="PanelBottom">
								<input type="text" name="vendorzip" id="vendorzip" value="%%GLOBAL_VendorZip%%" class="Field50" />
								<img onmouseout="HideHelp('vendorziphelp');" onmouseover="ShowHelp('vendorziphelp', '%%LNG_VendorZip%%', '%%LNG_VendorZipHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="vendorziphelp"></div>
							</td>
						</tr>

						<tr style="%%GLOBAL_HideLogoUpload%%">
							<td class="FieldLabel">
								<span class="Required">&nbsp;</span>
								<label for="vendorlogo">%%LNG_VendorLogo%%:</label>
							</td>
							<td>
								<input type="file" name="vendorlogo" id="vendorlogo" />
								<img onmouseout="HideHelp('vendorlogohelp');" onmouseover="ShowHelp('vendorlogohelp', '%%LNG_VendorLogo%%', '%%LNG_VendorLogoHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
								<div style="display:none" id="vendorlogohelp"></div>
								<span style="%%GLOBAL_HideCurrentVendorLogo%%">
									<label><input name='deletevendorlogo' id='deletevendorlogo' type='checkbox' value='1' /> %%LNG_DeleteCurrentImage%%</label> <a href="%%GLOBAL_CurrentVendorLogoLink%%" target="_blank">%%GLOBAL_CurrentVendorLogo%%</a>
								</span>
							</td>
						</tr>

						<tr style="%%GLOBAL_HidePhotoUpload%%">
							<td class="FieldLabel">
								<span class="Required">&nbsp;</span>
								<label for="vendorphoto">%%LNG_VendorPhoto%%:</label>
							</td>
							<td>
								<input type="file" name="vendorphoto" id="vendorphoto" />
								<img onmouseout="HideHelp('vendorphotohelp');" onmouseover="ShowHelp('vendorphotohelp', '%%LNG_VendorPhoto%%', '%%LNG_VendorPhotoHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
								<div style="display:none" id="vendorphotohelp"></div>
								<span style="%%GLOBAL_HideCurrentVendorPhoto%%">
									<label><input name='deletevendorphoto' id='deletevendorphoto' type='checkbox' value='1' /> %%LNG_DeleteCurrentImage%%</label> <a href="%%GLOBAL_CurrentVendorPhotoLink%%" target="_blank">%%GLOBAL_CurrentVendorPhoto%%</a>
								</span>
							</td>
						</tr>

						<tr>
							<td class="FieldLabel" valign="top">
								<span class="Required">&nbsp;</span> <label for="ForwardInvoiceEmails">%%LNG_ForwardInvoiceEmails%%:</label>
							</td>
							<td class="PanelBottom">
								<label> <input type="checkbox" name="forwardvendoremails" onclick="if(this.checked) { $('.ForwardInvoiceEmailsToggle').show(); } else { $('.ForwardInvoiceEmailsToggle').hide(); }" value="1" %%GLOBAL_VendorForwardInvoices%% /> %%LNG_YesEnableForwardInvoiceEmails%%</label>
								<img onmouseout="HideHelp('invoiceemailshelp');" onmouseover="ShowHelp('invoiceemailshelp', '%%LNG_ForwardInvoiceEmails%%', '%%LNG_ForwardInvoiceEmailsHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
								<div style="display:none" id="invoiceemailshelp"></div>
								<div style="margin-top: 3px; %%GLOBAL_HideForwardInvoiceEmails%%" class="ForwardInvoiceEmailsToggle">
									<img src="images/nodejoin.gif" style="vertical-align: middle;" />
									<input type="text" name="vendororderemail" id="vendororderemail" class="Field250" value="%%GLOBAL_VendorOrderEmail%%" /><br />
									<span class="Disabled" style='text-decoration: none; padding-left: 25px;'>%%LNG_ForwardOrderInvoicesDesc%%</span>
								</div>
							</td>
						</tr>
						<tr style="%%GLOBAL_HidePermissions%%" id="VendorProfitMarginFields">
							<td class="FieldLabel">
								<span class="Required">*</span> <label for="vendorprofitmargin">%%LNG_VendorProfitMargin%%:</label>
							</td>
							<td class="PanelBottom">
								<input type="text" name="vendorprofitmargin" id="vendorprofitmargin" value="%%GLOBAL_VendorProfitMargin%%" class="Field50" />
								<img onmouseout="HideHelp('vendorprofitmarginhelp');" onmouseover="ShowHelp('vendorprofitmarginhelp', '%%LNG_VendorProfitMargin%%', '%%LNG_VendorProfitMarginHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
								<div style="display:none" id="vendorprofitmarginhelp"></div>
							</td>
						</tr>
                        <tr style="%%GLOBAL_HidePermissions%%" id="VendorPrefixFields">
                            <td class="FieldLabel">
                                <span class="Required">*</span> <label for="vendorprefix">%%LNG_VendorPrefix%%:</label>
                            </td>
                            <td class="PanelBottom">
                                <input type="text" name="vendorprefix" id="vendorprefix" value="%%GLOBAL_VendorPrefix%%" class="Field250"/>  
                            </td>
                        </tr>
					</table>
					<table width="100%" class="Panel" style="%%GLOBAL_HidePermissions%%">
						<tr>
							<td class="Heading2" colspan="2">%%LNG_VendorPermissions%%</td>
						</tr>
						<tr>
							<td class="FieldLabel" valigbn="top">%%LNG_CategoryPermissions%%:</td>
							<td class="PanelBottom">
								<input type="checkbox" name="vendorlimitcats" id="vendorlimitcats" %%GLOBAL_AccessAllCategories%% /> <label for="vendorlimitcats">%%LNG_VendorAccessAllAccess%%</label>
								<span id="accesscatssel" style="%%GLOBAL_HideAccessCategories%%">(<a href="#" id="selectAllCats">%%LNG_SelectAll%%</a> / <a href="#" id="unselectAllCats">%%LNG_UnselectAll%%</a>)</span>
								<img onmouseout="HideHelp('d4');" onmouseover="ShowHelp('d4', '%%LNG_CategoryPermissions%%', '%%LNG_CategoryPermissionsHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
								<div style="display:none" id="d4"></div><br />
								<div style="padding-top:5px; %%GLOBAL_HideAccessCategories%%" id="accesscategorylist">
									<img src="images/nodejoin.gif" width="20" height="20" style="float:left; margin-right: 5px"/>
									<select size="5" id="vendoraccesscats" name="vendoraccesscats[]" class="Field400 ISSelectReplacement" multiple="multiple" style="height: 140px">
									%%GLOBAL_AccessCategoryOptions%%
									</select>
								</div>
							</td>
						</tr>
					</table>
					<table width="100%" class="Panel">
						<tr>
							<td class="Heading2" colspan="2">%%LNG_VendorBio%%</td>
						</tr>
						<tr>
							<td colspan="2">%%GLOBAL_WYSIWYG%%</td>
						</tr>
					</table>
				</div>
				<div id="div1" style="display: none">
					<table width="100%" class="Panel">
						<tr>
							<td class="Heading2" colspan="2">%%LNG_VendorShipping%%</td>
						</tr>

						<tr>
							<td class="FieldLabel">
								%%LNG_VendorShipping%%:
							</td>
							<td>
								<label style="display: block;"><input type="radio" onclick="ToggleShipping(this.value)" name="vendorshipping" value="0" %%GLOBAL_VendorShippingDefault%% /> %%LNG_VendorShippingStoreDefault%%</label>
								<div id="StoreShippingMethods" style="%%GLOBAL_HideStoreMethodsList%%">
									<img src="images/nodejoin.gif" alt="" class="FloatLeft" />
									%%GLOBAL_StoreShippingMethods%%
								</div>

								<label style="display: block;"><input type="radio" onclick="ToggleShipping(this.value)" name="vendorshipping" value="1" %%GLOBAL_VendorShippingCustom%% /> %%LNG_VendorShippingCustom%%</label>
								<div id="ShippingZonesToggle" style="%%GLOBAL_HideShippingZonesGrid%%">
									<div id="ShippingNotConfigured" style="%%GLOBAL_HideShippingNotConfigured%%">
										<img src="images/nodejoin.gif" alt="" class="FloatLeft"/>
										<div class="FloatLeft" style="width: 600px;">
											<p class="InfoTip" style="margin-top: 3px; background-position: 10px 10px">%%LNG_VendorShippingCustomIntro%%</p>
										</div>
									</div>
								</div>
							</td>
						</tr>
					</table>

					<div id="ShippingZonesGrid" style="%%GLOBAL_HideShippingZonesGrid%%">
						<p style="padding-bottom: 0; margin-bottom: 10px; margin-top: 10px;">
						<input type="button" name="ZoneAddButton" value="%%LNG_AddShippingZoneButton%%" class="SmallButton" onclick="document.location.href='index.php?ToDo=addShippingZone&vendorId=%%GLOBAL_VendorId%%';" />
							<input type="button" name="ZoneDeleteButton" value="%%LNG_DeleteSelected%%" class="SmallButton" onclick="ConfirmDeleteSelectedZones();" %%GLOBAL_DisableDeleteZones%% />
						</p>
						%%GLOBAL_NoZonesMessage%%
						<div class="GridContainer" style="%%GLOBAL_DisplayZoneGrid%%">
							%%GLOBAL_ShippingZonesGrid%%
						</div>
					</div>
				</div>
				<table border="0" cellspacing="0" cellpadding="2" width="100%" class="PanelPlain">
					<tr>
						<td>
							<input type="submit" name="SaveButton2" value="%%LNG_SaveAndExit%%" class="FormButton" />
							<input type="submit" name="SaveAddAnotherButton2" value="%%GLOBAL_SaveAndAddAnother%%" name="addAnother" class="FormButton" style="width:130px" />
							<input type="button" name="CancelButton2" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()" />
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div>
</form>
<script type="text/javascript">
	function ToggleShipping(value)
	{
		if(value == 1) {
			if($('#ShippingNotConfigured').css('display') != 'none') {
				$('#ShippingZonesToggle').show();
			}
			else {
				$('#ShippingZonesGrid').show();
			}
			$('#StoreShippingMethods').hide();
		}
		else {
			$('#ShippingZonesGrid').hide();
			$('#StoreShippingMethods').show();
			$('#ShippingZonesToggle').hide();
		}
	}
	function CheckVendorForm()
	{
		if($('#frmVendor').attr('action').indexOf('deleteVendorPages') != -1) {
			return true;
		}

		if(!$('#vendorname').val()) {
			alert('%%LNG_EnterVendorName%%');
			$('#vendorname').focus();
			return false;
		}

		if(!$('#vendorphone').val()) {
			alert('%%LNG_EnterVendorPhone%%');
			$('#vendorphone').focus();
			return false;
		}

		if($('#vendoremail').val().indexOf('@') == -1) {
			alert('%%LNG_EnterVendorEmail%%');
			$('#vendoremail').focus();
			return false;
		}

		if(!$('#vendoraddress').val()) {
			alert('%%LNG_EnterVendorAddress%%');
			$('#vendoraddress').focus();
			return false;
		}

		if(!$('#vendorcity').val()) {
			alert('%%LNG_EnterVendorCity%%');
			$('#vendorcity').focus();
			return false;
		}

		if(!$('#vendorcountry').val()) {
			alert('%%LNG_EnterVendorCountry%%');
			$('#vendorcountry').focus();
			return false;
		}

		if($('#vendorstate').css('display') != 'none' && !$('#vendorstate').val()) {
			alert('%%LNG_EnterVendorState%%');
			$('#vendorstate').focus();
			return false;
		}

		if(!$('#vendorzip').val()) {
			alert('%%LNG_EnterVendorZip%%');
			$('#vendorzip').focus();
			return false;
		}

		imageExtensions = 'jpg,jpeg,jpe,gif,png';
		if($('#vendorlogo').val()) {
			ext = $('#vendorlogo').val().replace(/^.*\./, '').toLowerCase();
			if(imageExtensions.toLowerCase().replace(' ', '').indexOf(ext) == -1) {
				alert('%%LNG_ChooseValidVendorLogo%%');
				$('#vendorlogo').select().focus();
				return false;
			}
		}

		if($('#vendorphoto').val()) {
			ext = $('#vendorphoto').val().replace(/^.*\./, '').toLowerCase();
			if(imageExtensions.toLowerCase().replace(' ', '').indexOf(ext) == -1) {
				alert('%%LNG_ChooseValidVendorPhoto%%');
				$('#vendorphoto').select().focus();
				return false;
			}
		}

		if($('#VendorProfitMarginFields').css('display') != 'none' && (isNaN(priceFormat($('#vendorprofitmargin').val())) || priceFormat($('#vendorprofitmargin').val()) < 0)) {
			alert('%%LNG_EnterVendorProfitMargin%%');
			$('#vendorprofitmargin').select().focus();
			return false;
		}
        if(!$('#vendorprefix').val()) {
            alert('%%LNG_EnterVendorprefix%%');
            $('#vendorprefix').focus();
            return false;
        }
		if(g('wysiwyg')) {
			var content = g('wysiwyg').value;
		}
		else if(g('wysiwyg_html')) {
			var content = g('wysiwyg_html').value;
		}

		if(IsWysiwygEditorEmpty(content)) {
			alert("%%LNG_EnterVendorBio%%");
			return false;
		}
		return true;
	}


	function ConfirmCancel()
	{
		if(confirm('%%LNG_ConfirmCancel%%')) {
			if('%%GLOBAL_CurrentVendor%%' != 0) {
				window.location = 'index.php';
			}
			else {
				window.location = 'index.php?ToDo=viewVendors&currentTab=1';
			}
		}

		return false;
	}

	function ConfirmDeleteSelectedZones()
	{
		if(!$('#ShippingZonesGrid .GridContainer input[type=checkbox].check:checked').length) {
			alert('%%LNG_SelectOneMoreZonesDelete%%');
			return false;
		}
		if(confirm('%%LNG_ConfirmDeleteZones%%')) {
			$('#frmVendor').attr('action', 'index.php?ToDo=deleteShippingZones');
			$('#frmVendor').attr('onsubmit', function() { return true});
			$('#frmVendor').submit();
		}
		else {
			return false;
		}
	}

	function ConfirmDeleteZone() {
		if(confirm('%%LNG_ConfirmDeleteZone%%')) {
			return true;
		}

		return false;
	}

	function GetStates(selObj, dest, stateTextBox)
	{
		var country = selObj.options[selObj.selectedIndex].value;

		selDest = document.getElementById(dest);
		otherBox = document.getElementById(stateTextBox);

		if(country == "")
		{
			ResetStates(false);
			selObj.focus();
		}
		else
		{
			// Get all of the states for this country
			//dataMode = 1;
			DoCallback("w=countryStates&c="+country);
		}
	}

	function ResetStates(ShowChoose)
	{
		selDest.options.length = 0;

		if(ShowChoose)
			selDest.options[selDest.options.length] = new Option("%%LNG_ChooseState%%", "");
	}

	function ProcessData(html)
	{
		ResetStates(true);
		states = html.split("~");
		numStates = 0;

		for(i = 0; i < states.length; i++)
		{
			vals = states[i].split("|");

			if(states[i].length > 0) {
				selDest.options[selDest.options.length] = new Option(vals[0], vals[1]);
				numStates++;
			}
		}

		// If there are no states then hide the state dropdown list
		if(numStates == 0) {
			selDest.style.display = "none";
			otherBox.style.display = "";
		}
		else {
			selDest.style.display = "";
			otherBox.style.display = "none";
		}
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

	$(document).ready(function() {
		if($('#currentTab').val()) {
			ShowTab($('#currentTab').val());
		}

		// Show or hide the access categories list as required
		$('#vendorlimitcats').click(function() {
			if((this).checked) {
				$('#accesscategorylist').hide();
				$('#accesscatssel').hide();
			}
			else {
				$('#accesscategorylist').show();
				$('#accesscatssel').show();
			}
		});

		// Select all access categories
		$('#selectAllCats').click(function() {
			if(g('vendoraccesscats_old')) {
				if(g('vendoraccesscats_old').disabled != true) {
					$('#vendoraccesscats input').attr('checked', false);
					$('#vendoraccesscats input').trigger('click');
				}
			}
			else {
				$('#vendoraccesscats option').attr('selected', true);
			}
			return false;
		});

		$('#unselectAllCats').click(function() {
			if(g('vendoraccesscats_old')) {
				if(g('vendoraccesscats_old').disabled != true) {
					$('#vendoraccesscats input').attr('checked', true);
					$('#vendoraccesscats input').trigger('click');
				}
			}
			else {
				$('#vendoraccesscats option').attr('selected', false);
			}
			return false;
		});
	});
</script>