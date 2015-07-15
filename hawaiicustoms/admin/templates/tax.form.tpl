
	<form action="index.php?ToDo=%%GLOBAL_FormAction%%" onsubmit="return ValidateForm(CheckForm)" name="frmAddTaxRate" method="post">
	%%GLOBAL_hiddenFields%%
	<div class="BodyContainer">
	<table class="OuterPanel">
		  <tr>
			<td class="Heading1">%%GLOBAL_TaxRateTitle%%</td>
			</tr>
			<tr>
			<td class="Intro">
				<p>%%LNG_TaxRateIntro%%</p>
				%%GLOBAL_Message%%
			</td>
		  </tr>
		  <tr>
			    <td>
					<div>
						<input type="submit" name="SubmitButton1" value="%%LNG_Save%%" class="FormButton">
						<input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()"><br /><img src="images/blank.gif" width="1" height="10" /></div>
				</td>
			  </tr>
				<tr>
					<td>
					  <table class="Panel">
						<tr>
						  <td class="Heading2" colspan=2>%%LNG_TaxRateDetails%%</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span>&nbsp;%%LNG_TaxName%%:
							</td>
							<td>
								<input type="text" name="taxratename" id="taxratename" class="Field250" value="%%GLOBAL_TaxRateName%%" />
								<img onmouseout="HideHelp('d1');" onmouseover="ShowHelp('d1', '%%LNG_TaxName%%', '%%LNG_TaxNameHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="d1"></div>
							</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span>&nbsp;%%LNG_BasedOn%%:
							</td>
							<td>
								<select name="taxratebasedon" id="taxratebasedon" class="Field250">
									<option %%GLOBAL_BasedOnSubTotal%% value="subtotal">%%LNG_OrderSubTotal%%</option>
									<option %%GLOBAL_BasedOnSubTotalAndShipping%% value="subtotal_and_shipping">%%LNG_OrderSubTotalAndShipping%%</option>
								</select>
								<img onmouseout="HideHelp('d3');" onmouseover="ShowHelp('d3', '%%LNG_BasedOn%%', '%%LNG_BasedOnHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="d3"></div>
							</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span>&nbsp;%%LNG_ApplyTo%%:
							</td>
							<td>
								<select size="15" name="taxratecountry" id="taxratecountry" class="Field250" onchange="GetStates(this, 'taxratestates')">
									%%GLOBAL_CountryList%%
								</select>
								<img onmouseout="HideHelp('d4');" onmouseover="ShowHelp('d4', '%%LNG_ApplyTo%%', '%%LNG_ApplyToHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="d4"></div>
							</td>
						</tr>
						<tr id="trstates" style="display:%%GLOBAL_HideStateList%%">
							<td class="FieldLabel">
								&nbsp;
							</td>
							<td>
								<select multiple size="10" name="taxratestates[]" id="taxratestates" class="Field250 ISSelectReplacement">
									%%GLOBAL_StateList%%
								</select>
								<img onmouseout="HideHelp('d6');" onmouseover="ShowHelp('d6', '%%LNG_ApplyTo%%', '%%LNG_ApplyToStateHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="d6"></div>
							</td>
						</tr>
							<tr>
								<td class="FieldLabel">
									<span class="Required">*</span>&nbsp;%%LNG_TaxedAddress%%:
								</td>
								<td>
									<select name="taxaddress" id="taxaddress" class="Field250">
										<option %%GLOBAL_TaxAddressBilling%% value="billing">%%LNG_TaxedAddressBilling%%</option>
										<option %%GLOBAL_TaxAddressShipping%% value="shipping">%%LNG_TaxedAddressShipping%%</option>
									</select>
									<img onmouseout="HideHelp('taxaddress_help');" onmouseover="ShowHelp('taxaddress_help', '%%LNG_TaxedAddress%%', '%%LNG_TaxedAddressHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
									<div style="display:none" id="taxaddress_help"></div>
								</td>
							</tr>
						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span>&nbsp;%%LNG_TaxRate%%:
							</td>
							<td>
								<input type="text" name="taxratepercent" id="taxratepercent" class="Field50" value="%%GLOBAL_TaxRatePercent%%" />%
								<img onmouseout="HideHelp('d2');" onmouseover="ShowHelp('d2', '%%LNG_TaxRate%%', '%%LNG_TaxRateHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="d2"></div>
							</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span>&nbsp;%%LNG_TaxEnabled%%
							</td>
							<td>
								<input %%GLOBAL_TaxEnabled%% type="checkbox" name="taxratestatus" id="taxratestatus" /> <label for="taxratestatus">%%LNG_YesTaxEnabled%%</label>
								<img onmouseout="HideHelp('d5');" onmouseover="ShowHelp('d5', '%%LNG_TaxEnabled%%', '%%LNG_TaxEnabledHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="d5"></div>
							</td>
						</tr>
						<tr>
							<td class="FieldLabel">&nbsp;</td>
							<td>
								<input type="submit" name="SubmitButton2" value="%%LNG_Save%%" class="FormButton">
								<input type="button" name="CancelButton2" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()">
							</td>
						</tr>
						<tr><td class="Gap"></td></tr>
					 </table>
					</td>
				</tr>
			</table>
		</div>
	</form>

	<script type="text/javascript">

		function CheckForm() {
			var taxratename = document.getElementById("taxratename");
			var taxratepercent = document.getElementById("taxratepercent");

			if(taxratename.value == "") {
				alert("%%LNG_EnterTaxRateName%%");
				taxratename.focus();
				return false;
			}

			if(isNaN(priceFormat(taxratepercent.value)) || taxratepercent.value == "") {
				alert("%%LNG_EnterValidTaxRate%%");
				taxratepercent.focus();
				taxratepercent.select();
				return false;
			}

			return true;
		}

		function ConfirmCancel()
		{
			if(confirm('%%GLOBAL_CancelMessage%%'))
				document.location.href='index.php?ToDo=viewTaxSettings';
			else
				return false;
		}

		function GetStates(selObj, dest)
		{
			var country = selObj.options[selObj.selectedIndex].value;
			if(g(dest+'_old')) {
				selDest = document.getElementById(dest+'_old');
			}
			else {
				selDest = document.getElementById(dest);
			}

			// Get all of the states for this country
			DoCallback("w=countryStates&c="+country);
		}

		function ProcessData(html)
		{
			states = html.split("~");
			numStates = 0;

			if(html != "") {
				document.getElementById("trstates").style.display = "";
				selDest.options.length = 0;
				selDest.options[selDest.options.length] = new Option("%%LNG_AllStates%%", 0);

				for(i = 0; i < states.length; i++)
				{
					vals = states[i].split("|");

					if(states[i].length > 0) {
						selDest.options[selDest.options.length] = new Option(vals[0], vals[1]);
						numStates++;
					}
				}

				selDest.selectedIndex = 0;
				if(g('taxratestates_old')) {
					g('taxratestates').parentNode.removeChild(g('taxratestates'));
					g('taxratestates_old').id = 'taxratestates';
					ISSelectReplacement.replace_select(g('taxratestates'));
				}
				$('#taxratestates').show();
			}
			else {
				document.getElementById("trstates").style.display = "none";
			}
		}


	</script>
