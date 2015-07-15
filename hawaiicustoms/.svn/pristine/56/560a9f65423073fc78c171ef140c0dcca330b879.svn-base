
	<div class="BodyContainer">
	<form name="frmTaxRates" id="frmTaxRates" method="post" action="index.php?ToDo=settingsSaveTaxSettings" onsubmit="return ValidateForm(CheckTaxRateForm);">
	<input type="hidden" name="currentTab" id="currentTab" value="0" />
	<input type="hidden" name="pricesalreadyincludetax" value="%%GLOBAL_PricesIncludeTax%%" />
	<input type="hidden" name="taxtypeselected" id="taxtypeselected" value="%%GLOBAL_TaxTypeSelected%%" />
	<table id="Table13" cellSpacing="0" cellPadding="0" width="100%">
		<tr>
			<td class="Heading1">%%LNG_TaxRates%%</td>
		</tr>
		<tr>
			<td class="Intro">
				<p>%%GLOBAL_TaxIntro%%</p>
				%%GLOBAL_Message%%
			</td>
		</tr>
		<tr>
			<td>
				<ul id="tabnav">
					<li><a href="#" class="active" id="tab0" onclick="ShowTab(0)">%%LNG_GeneralSettings%%</a></li>
					%%GLOBAL_TaxTabs%%
				</ul>
			</td>
		</tr>
		<tr>
		<td>
			<div id="div0" style="padding-top: 10px;">
			<div style="padding:0px 0px 5px 10px" class="Text"></div>
			<table id="IntroTable" cellspacing="0" cellpadding="0" width="100%">
			<tr>
				<td class="Heading2" colspan="2">%%LNG_ConfigureTaxRates%%</td>
			</tr>
			<tr>
				<td class="FieldLabel">
					<span class="Required">*</span> %%LNG_TaxSettings%%:
				</td>
				<td class="Intro" valign="top">
					<label for="taxtype3"><input type="radio" name="TaxType" id="taxtype3" value="0" onclick="$('#DefaultTaxDiv').hide(); $('#DefaultTaxRate').val(''); $('#DefaultTaxRateName').val('');" %%GLOBAL_NoTaxChecked%% /> %%LNG_DontApplyTax%%</label><br/>
					<label for="taxtype1"><input type="radio" name="TaxType" id="taxtype1" value="1" onclick="$('#DefaultTaxDiv').hide(); " %%GLOBAL_LocationSpecificTaxChecked%% /> %%LNG_TaxRelativeToLocation%%</label><br/>
					<label for="taxtype2"><input type="radio" name="TaxType"
					id="taxtype2" value="2" onclick="$('#DefaultTaxDiv').show();
					$('#DefaultTaxRateName').select(); " %%GLOBAL_DefaultTaxRateChecked%% /> %%LNG_FlatTaxAllProducts%%</label><br/>
				</td>
			</tr>
			<tr>
			<td colspan="2">
					<table class="GridPanel" cellspacing="0" cellpadding="0" border="0" id="DefaultTaxDiv" style="width:100%; margin-top: 5px; display: %%GLOBAL_HideGlobalTax%% ">
						<tr>
							<td class="FieldLabel">
								&nbsp;</label>
							</td>
							<td align="left" valign="top">
								<table border="0">
									<tr>
										<td><img src="images/nodejoin.gif" alt="" /></td>
										<td align="left" width="100" nowrap="nowrap"><label for="DefaultTaxRateName">%%LNG_DefaultTaxRateName%%:</label></td>
										<td>
											<input type="text" name="DefaultTaxRateName" id="DefaultTaxRateName" value="%%GLOBAL_DefaultTaxRateName%%" class="Field250" %%GLOBAL_TaxRateDisabled%% />
											<img onmouseout="HideHelp('tname');" onmouseover="ShowHelp('tname', '%%LNG_DefaultTaxRateName%%', '%%LNG_DefaultTaxRateNameHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
											<div style="display:none" id="tname"></div>
										</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>
											%%LNG_BasedOn%%:
										</td>
										<td>
											<select name="DefaultTaxRateBasedOn" id="taxratebasedon" class="Field250">
												<option %%GLOBAL_BasedOnSubTotal%% value="subtotal">%%LNG_OrderSubTotal%%</option>
												<option %%GLOBAL_BasedOnSubTotalAndShipping%% value="subtotal_and_shipping">%%LNG_OrderSubTotalAndShipping%%</option>
											</select>
											<img onmouseout="HideHelp('d3');" onmouseover="ShowHelp('d3', '%%LNG_BasedOn%%', '%%LNG_BasedOnHelp%%')" src="images/help.gif" width="24" height="16" border="0">
											<div style="display:none" id="d3"></div>
										</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td align="left">
											<label for="DefaultTaxRate">%%LNG_DefaultTaxRate%%:</label>
										</td>
										<td align="left" valign="top">
											<input type="text" name="DefaultTaxRate" id="DefaultTaxRate" value="%%GLOBAL_DefaultTaxRate%%" class="Field40" %%GLOBAL_TaxRateDisabled%% />%
											<img onmouseout="HideHelp('d16');" onmouseover="ShowHelp('d16', '%%LNG_DefaultTaxRate%%', '%%LNG_DefaultTaxRateHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
											<div style="display:none" id="d16"></div>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
			</td>
			</tr>
			<tr>
				<td class="FieldLabel">
					&nbsp;&nbsp; <label for="PricesIncludeTax">%%LNG_PricesIncludeTax%%</label>
				</td>
				<td>
					<label><input type="checkbox" name="PricesIncludeTax" id="PricesIncludeTax" value="0" %%GLOBAL_PricesIncludeTaxChecked%% /> %%LNG_YesPricesIncludeTax%%</label>
					<img onmouseout="HideHelp('inctax');" onmouseover="ShowHelp('inctax', '%%LNG_PricesIncludeTax%%', '%%LNG_PricesIncludeTaxHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
					<div style="display:none" id="inctax"></div>
				</td>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td class="FieldLabel">&nbsp;</td>
				<td valign="top">
					<input type="submit" value="%%LNG_Save%%" class="FormButton" />
					<input type="reset" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()" />
				</td>
			</tr>
			</table>
			</div>

			<div id="div1" style="padding-top: 10px; display: none;">
			<table class="GridPanel" cellspacing="0" cellpadding="0" border="0" style="width:100%;">
			<tr>
				<td colspan="7" class="EmptyRow">%%GLOBAL_TaxOptionsMessage%%</td>
			</tr>
			<tr>
				<td colspan="7" class="EmptyRow" style="padding: 2px;"></td>
			</tr>
			<tr>
				<td colspan="7">
					<input type="button" name="IndexAddButton" value="%%LNG_AddTaxRate%%..." id="IndexCreateButton" class="SmallButton" onclick="document.location.href='index.php?ToDo=settingsAddTaxRate'" /> &nbsp;<input type="button" name="IndexDeleteButton" value="%%LNG_DeleteSelected%%" id="IndexDeleteButton" class="SmallButton" onclick="ConfirmDeleteSelected()" %%GLOBAL_DisableDelete%% />
				</td>
			</tr>
			<tr>
				<td colspan="7" class="EmptyRow">&nbsp;</td>
			</tr>
			<tr class="Heading3" style="display: %%GLOBAL_ShowTaxTableHeaders%%">
				<td align="center" style="width:18px"><input type="checkbox" onclick="ToggleDeleteBoxes(this.checked)"></td>
				<td>&nbsp;</td>
				<td>
					%%LNG_TaxName%%
				</td>
				<td>
					%%LNG_TaxRate%%
				</td>
				<td>
					%%LNG_AppliesTo%%
				</td>
				<td style="width:70px;">
					%%LNG_Status%%
				</td>
				<td style="width:80px;">
					%%LNG_Action%%
				</td>
			</tr>
			%%GLOBAL_TaxGrid%%
			</table>
			</div>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>

	</table>
	</form>
	</div>

	<script type="text/javascript">

		function ToggleDeleteBoxes(Status)
		{
			var fp = document.getElementById("frmTaxRates").elements;

			for(i = 0; i < fp.length; i++)
				fp[i].checked = Status;
		}

		function ConfirmDeleteSelected()
		{
			var fp = document.getElementById("frmTaxRates").elements;
			var c = 0;

			for(i = 0; i < fp.length; i++)
			{
				if (fp[i].type == "checkbox" && fp[i].checked) {
					c++;
				}
			}

			if(c > 0)
			{
				if(confirm("%%LNG_ConfirmDeleteTaxRates%%")) {
					$('#frmTaxRates').attr('action', 'index.php?ToDo=settingsDeleteTaxRates');
					document.getElementById("frmTaxRates").submit();
				}
			}
			else
			{
				alert("%%LNG_ChooseTaxRates%%");
			}
		}

		function ConfirmCancel()
		{
			if(confirm("%%LNG_ConfirmCancelTaxSettings%%")) {
				document.location.href = "index.php?ToDo=viewTaxSettings";
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

		function CheckTaxRateForm()
		{
			if ($("#taxtype2").attr('checked')) {
				if (isNaN(priceFormat($("#DefaultTaxRate").val())) || $("#DefaultTaxRate").val() < 0) {
					alert("%%LNG_EnterATaxRate%%");
					$("#DefaultTaxRate").focus();
					$("#DefaultTaxRate").select();
					return false;
				}
			}
			return true;
		}

		$(document).ready(function() {
			ShowTab(%%GLOBAL_DefaultTab%%);
		});

	</script>

