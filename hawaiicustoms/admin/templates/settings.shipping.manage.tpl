	<form action="index.php?ToDo=saveUpdatedShippingSettings" name="frmShippingSettings" id="frmShippingSettings" method="post" onsubmit="return ValidateForm(CheckShippingSettingsForm)">
		<div class="BodyContainer">
		<table cellSpacing="0" cellPadding="0" width="100%" style="margin-left: 4px; margin-top: 8px;">
		<tr>
			<td class="Heading1">%%LNG_ShippingSettings%%</td>
		</tr>
		<tr>
			<td class="Intro">
				<p>%%LNG_ShippingSettingsIntro%%</p>
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
					<li><a href="#" class="active" id="tab0" onclick="ShowTab(0)">%%LNG_StoreLocation%%</a></li>
					<li><a href="#" id="tab1" onclick="ShowTab(1)">%%LNG_ShippingZones%%</a></li>
				</ul>
			</td>
		</tr>
		<tr>
			<td>
				<input id="currentTab" name="currentTab" value="%%GLOBAL_CurrentTab%%" type="hidden">
				<div id="div0">
					<table width="100%" class="Panel">
						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span> <label for="storename">%%LNG_CompanyName%%:</label>
							</td>
							<td>
								<input type="text" name="companyname" id="companyname" value="%%GLOBAL_CompanyName%%" class="Field250" />
								<img onmouseout="HideHelp('d1');" onmouseover="ShowHelp('d1', '%%LNG_CompanyName%%', '%%LNG_CompanyNameHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="d1"></div>
							</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span> <label for="storename">%%LNG_CompanyAddress%%:</label>
							</td>
							<td>
								<input type="text" name="companyaddress" id="companyaddress" value="%%GLOBAL_CompanyAddress%%" class="Field250" />
								<img onmouseout="HideHelp('d2');" onmouseover="ShowHelp('d2', '%%LNG_CompanyAddress%%', '%%LNG_CompanyAddressHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="d2"></div>
							</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span> <label for="storename">%%LNG_CompanyCity%%:</label>
							</td>
							<td>
								<input type="text" name="companycity" id="companycity" value="%%GLOBAL_CompanyCity%%" class="Field250" />
								<img onmouseout="HideHelp('d3');" onmouseover="ShowHelp('d3', '%%LNG_CompanyCity%%', '%%LNG_CompanyCityHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="d3"></div>
							</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span> <label for="storename">%%LNG_CompanyCountry%%:</label>
							</td>
							<td>
								<select name="companycountry" id="companycountry" class="Field250 " onchange="GetStates(this, 'companystate', 'companystate1')">
									%%GLOBAL_CountryList%%
								</select>
								<img onmouseout="HideHelp('d4');" onmouseover="ShowHelp('d4', '%%LNG_CompanyCountry%%', '%%LNG_CompanyCountryHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="d4"></div>
							</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span> <label for="storename">%%LNG_CompanyState%%:</label>
							</td>
							<td class="Field">
								<div id="statemessage" style="color:gray; display:%%GLOBAL_HideStateNote%%">-- %%LNG_ChooseCountryFirst%% --</div>
								<select style="display:%%GLOBAL_HideStateList%%" name="companystate" id="companystate" class="Field250">
									%%GLOBAL_StateList%%
								</select>
								<input style="display:%%GLOBAL_HideStateBox%%" type="text" name="companystate1" id="companystate1" class="Field250" value="%%GLOBAL_CompanyState%%" />
							</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span> <label for="storename">%%LNG_CompanyZip%%:</label>
							</td>
							<td class="PanelBottom">
								<input type="text" name="companyzip" id="companyzip" value="%%GLOBAL_CompanyZip%%" class="Field50" />
								<img onmouseout="HideHelp('d6');" onmouseover="ShowHelp('d6', '%%LNG_CompanyZip%%', '%%LNG_CompanyZipHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="d6"></div>
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
				</div>
				<div id="div1">
					%%GLOBAL_NoZonesMessage%%
					<p style="padding-bottom: 0; margin-bottom: 10px; margin-top: 10px;">
					<input type="button" name="ZoneAddButton" value="%%LNG_AddShippingZoneButton%%" class="SmallButton" onclick="document.location.href='index.php?ToDo=addShippingZone';" />
						<input type="button" name="ZoneDeleteButton" value="%%LNG_DeleteSelected%%" class="SmallButton" onclick="ConfirmDeleteSelected();" %%GLOBAL_DisableDelete%% />
					</p>
					<div class="GridContainer">
						%%GLOBAL_ZoneDataGrid%%
					</div>
				</div>
			</td>
		</tr>
		</table>
		</div>
	</form>

	<script type="text/javascript">

		var selDest = null;
		var otherBox = null;

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

		function GetStates(selObj, dest, stateTextBox)
		{
			var country = selObj.options[selObj.selectedIndex].value;
			var statemessage = document.getElementById("statemessage");

			selDest = document.getElementById(dest);
			otherBox = document.getElementById(stateTextBox);
			statemessage.style.display = "none";

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

		function ConfirmCancel()
		{
			if(confirm("%%LNG_ConfirmCancelShippingSettings%%"))
				document.location.href = "index.php?ToDo=viewShippingSettings";
		}

		function CheckShippingSettingsForm() {
			var companyname = g("companyname");
			var companyaddress = g("companyaddress");
			var companycity = g("companycity");
			var companycountry = g("companycountry");
			var companystate = g("companystate");
			var companystate1 = g("companystate1");
			var companyzip = g("companyzip");

			if(companyname.value == "") {
				ShowTab(0);
				alert("%%LNG_EnterCompanyName%%");
				companyname.focus();
				return false;
			}

			if(companyaddress.value == "") {
				ShowTab(0);
				alert("%%LNG_EnterCompanyAddress%%");
				companyaddress.focus();
				return false;
			}

			if(companycity.value == "") {
				ShowTab(0);
				alert("%%LNG_EnterCompanyCity%%");
				companycity.focus();
				return false;
			}

			if(companycountry.selectedIndex == 0) {
				ShowTab(0);
				alert("%%LNG_SelectCompanyCountry%%");
				companycountry.focus();
				return false;
			}

			if( (companystate.style.display == "" && companystate.selectedIndex == 0) || (companystate1.style.display == "" && companystate1.value == "") || (companystate.style.display == "none" && companystate1.style.display == "none") ) {
				ShowTab(0);
				alert("%%LNG_SelectEnterCompanyState%%");
				return false;
			}

			if(companyzip.value == "") {
				ShowTab(0);
				alert("%%LNG_EnterCompanyZip%%");
				companyzip.focus();
				return false;
			}

			return true;
		}

		function ConfirmDeleteSelected()
		{
			if(!$('.GridContainer input[type=checkbox].check:checked').length) {
				alert('%%LNG_SelectOneMoreZonesDelete%%');
				return false;
			}
			if(confirm('%%LNG_ConfirmDeleteZones%%')) {
				$('#frmShippingSettings').attr('action', 'index.php?ToDo=deleteShippingZones');
				$('#frmShippingSettings').attr('onsubmit', function() { return true});
				$('#frmShippingSettings').submit();
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

		// Load the main shipping settings tab by default
		ShowTab(%%GLOBAL_CurrentTab%%);
	</script>
