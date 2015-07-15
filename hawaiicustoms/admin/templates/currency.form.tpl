
	<form action="index.php?ToDo=%%GLOBAL_FormAction%%" onsubmit="return ValidateForm(CheckForm)" name="frmAddCurrency" method="post">
	<input type="hidden" name="setCurrencyAsDefault" id="setCurrencyAsDefault" value="" />
	%%GLOBAL_hiddenFields%%
	<div class="BodyContainer">
	<table class="OuterPanel">
		  <tr>
			<td class="Heading1">%%GLOBAL_CurrencyTitle%%</td>
			</tr>
			<tr>
			<td class="Intro">
				<p>%%LNG_CurrencyIntro%%</p>
				%%GLOBAL_Message%%
			</td>
		  </tr>
		  <tr>
			    <td>
					<div>
						<input type="submit" name="SubmitButton1" value="%%LNG_Save%%" class="FormButton" />
						<input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()" /><br /><img src="images/blank.gif" width="1" height="10" /></div>
				</td>
			  </tr>
				<tr>
					<td>
					  <table class="Panel">
						<tr>
						  <td class="Heading2" colspan=2>%%LNG_CurrencyDetails%%</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span>&nbsp;%%LNG_CurrencyName%%:
							</td>
							<td>
								<input type="text" name="currencyname" id="currencyname" class="Field250" value="%%GLOBAL_CurrencyName%%" />
								<img onmouseout="HideHelp('currname');" onmouseover="ShowHelp('currname', '%%LNG_CurrencyName%%', '%%LNG_CurrencyNameHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="currname"></div>
							</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span>&nbsp;%%LNG_CurrencyOrigin%%:
							</td>
							<td>
								<select name="currencyorigin" id="currencyorigin" class="Field250" onchange="toggleOrigin();" size="10">
									%%GLOBAL_OriginList%%
								</select>
								<input type="hidden" id="currencyorigintype" name="currencyorigintype" value="%%GLOBAL_CurrencyOriginType%%" />
								<img onmouseout="HideHelp('currorigin');" onmouseover="ShowHelp('currorigin', '%%LNG_CurrencyOrigin%%', '%%LNG_CurrencyOriginHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="currorigin"></div>
							</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span>&nbsp;%%LNG_CurrencyCode%%:
							</td>
							<td>
								<input maxlength="3" type="text" name="currencycode" id="currencycode" class="Field50" value="%%GLOBAL_CurrencyCode%%" />
								<img onmouseout="HideHelp('currcode');" onmouseover="ShowHelp('currcode', '%%LNG_CurrencyCode%%', '%%LNG_CurrencyCodeHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="currcode"></div>
							</td>
						</tr>
						<tr %%GLOBAL_HideOnDefault%%>
							<td class="FieldLabel">
								<span class="Required">*</span>&nbsp;%%LNG_CurrencyExchangeRate%%:
							</td>
							<td>
								%%GLOBAL_ConverterList%%
							</td>
						</tr>
						<tr %%GLOBAL_HideOnDefault%%>
							<td class="FieldLabel">
								&nbsp;
							</td>
							<td>
								<div id="currencyexchangeratediv"><img src="images/nodejoin.gif" align="left" />&nbsp;%%GLOBAL_CurrencyConverterBox%%<input type="text" id="currencyexchangerate" name="currencyexchangerate" value="%%GLOBAL_CurrencyExchangeRate%%" class="Field50"/>
								<img onmouseout="HideHelp('currexrate');" onmouseover="ShowHelp('currexrate', '%%LNG_CurrencyExchangeRate%%', '%%GLOBAL_CurrencyExchangeRateHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="currexrate"></div></div>
							</td>
						</tr>
						<tr %%GLOBAL_HideOnDefault%%>
							<td class="FieldLabel">
								&nbsp;&nbsp;&nbsp;%%LNG_CurrencyEnabled%%
							</td>
							<td>
								<input %%GLOBAL_CurrencyEnabled%% type="checkbox" name="currencystatus" id="currencystatus" /> <label for="currencystatus">%%LNG_YesCurrencyEnabled%%</label>
								<img onmouseout="HideHelp('currstatus');" onmouseover="ShowHelp('currstatus', '%%LNG_CurrencyEnabled%%', '%%LNG_CurrencyEnabledHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="currstatus"></div>
							</td>
						</tr>
						<tr>
							<td colspan="2" class="EmptyRow" style="height:15px">
								&nbsp;
							</td>
						</tr>
						<tr>
							<td class="Heading2" colspan=2>%%LNG_CurrencyDisplay%%</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span> <label for="currencystringposition">%%LNG_CurrencyStringPosition%%:</label>
							</td>
							<td>
								<select name="currencystringposition" id="currencystringposition" class="Field50">
									<option value="left"%%GLOBAL_CurrencyLocationIsLeft%%>%%LNG_Left%%</option>
									<option value="right"%%GLOBAL_CurrencyLocationIsRight%%>%%LNG_Right%%</option>
								</select>
								<img onmouseout="HideHelp('currstrpos');" onmouseover="ShowHelp('currstrpos', '%%LNG_CurrencyStringPosition%%', '%%LNG_CurrencyStringPositionHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
								<div style="display:none" id="currstrpos"></div>
							</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span> <label for="currencystring">%%LNG_CurrencyString%%:</label>
							</td>
							<td>
								<input type="text" name="currencystring" id="currencystring" value="%%GLOBAL_CurrencyString%%" class="Field40" />
								<img onmouseout="HideHelp('currtoken');" onmouseover="ShowHelp('currtoken', '%%LNG_CurrencyString%%', '%%LNG_CurrencyStringHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
								<div style="display:none" id="currtoken"></div>
							</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span> <label for="currencydecimalstring">%%LNG_CurrencyDecimalString%%:</label>
							</td>
							<td>
								<input type="text" name="currencydecimalstring" id="currencydecimalstring" value="%%GLOBAL_CurrencyDecimalString%%" class="Field40" maxlength="1" />
								<img onmouseout="HideHelp('currdectoken');" onmouseover="ShowHelp('currdectoken', '%%LNG_CurrencyDecimalString%%', '%%LNG_CurrencyDecimalStringHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
								<div style="display:none" id="currdectoken"></div>
							</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span> <label for="currencythousandstring">%%LNG_CurrencyThousandString%%:</label>
							</td>
							<td>
								<input type="text" name="currencythousandstring" id="currencythousandstring" value="%%GLOBAL_CurrencyThousandString%%" class="Field40" maxlength="1" />
								<img onmouseout="HideHelp('currthousandstr');" onmouseover="ShowHelp('currthousandstr', '%%LNG_CurrencyThousandString%%', '%%LNG_CurrencyThousandStringHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
								<div style="display:none" id="currthousandstr"></div>
							</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span> <label for="currencydecimalplace">%%LNG_CurrencyDecimalPlace%%:</label>
							</td>
							<td class="PanelBottom">
								<input type="text" name="currencydecimalplace" id="currencydecimalplace" value="%%GLOBAL_CurrencyDecimalPlace%%" class="Field40" />
								<img onmouseout="HideHelp('currdecplace');" onmouseover="ShowHelp('currdecplace', '%%LNG_CurrencyDecimalPlace%%', '%%LNG_CurrencyDecimalPlaceHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
								<div style="display:none" id="currdecplace"></div>
							</td>
						</tr>
					 </table>
					</td>
				</tr>
			</table>
			<table border="0" cellspacing="0" cellpadding="2" width="100%" class="PanelPlain">
				<tr>
					<td width="200" class="FieldLabel">
						&nbsp;
					</td>
					<td>
						<input type="submit" value="%%LNG_Save%%" class="FormButton" />
						<input type="reset" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()" />
					</td>
				</tr>
			</table>
		</div>
	</form>

	<script type="text/javascript">

		$(document).ready(function() {
			$('#currencyname').focus();
		});

		function toggleOrigin()
		{
			var origin = document.getElementById("currencyorigin");
			var id     = $(origin.options[origin.selectedIndex]).parent().attr("id");

			if (matches = id.match(/^currencyorigintype\-([a-z]+)$/i))
				$("#currencyorigintype").val(matches[1]);
		}

		function checkCurrencyCode(code)
		{
			var regexp = /^[a-z]{3}$/i;
			return regexp.test(code);
		}

		function toggleExchangeConverter(id)
		{
			var currentCurrencyNode = document.getElementById("currencyconverter" + id);
			var otherCurrencyNodes  = currentCurrencyNode.parentNode.getElementsByTagName("INPUT");

			for (var i in otherCurrencyNodes)
			{
				if (otherCurrencyNodes[i].type == "radio" && otherCurrencyNodes[i].id !== "currencyconvertermanual")
					document.getElementById("currencyconverterupdate" + otherCurrencyNodes[i].value).style.display = "none";
			}

			if (id !== "manual")
				document.getElementById("currencyconverterupdate" + id).style.display = "inline";
		}

		function getExchangeRate(id)
		{
			if (!checkCurrencyCode($("#currencycode").val()))
			{
				alert("%%LNG_ErrorEnterCurrencyCodeForConverter%%");
				$("#currencycode").focus();
				return false;
			}
			$.ajax({
				type   : "POST",
				url    : url,
				data   : "w=getExchangeRate&cid=" + id + "&ccode="+ $("#currencycode").val(),
				success: processExchangeRate
				});
		}

		function processExchangeRate(data)
		{
			eval('var data = ' + data);
			if (!data.status)
			{
				alert(data.message);
				$("#currencycode").focus();
				return false;
			}

			$("#currencyexchangerate").val(data.rate);
			alert(data.message);
			return true;
		}

		function CheckForm()
		{
			var checkElements = new Array(
				{"name": "currencyname", "err": "%%LNG_EnterCurrencyName%%"},
				{"name": "currencyorigin", "err": "%%LNG_EnterCurrencyOrigin%%"},
				{"name": "currencycode", "err": "%%LNG_EnterCurrencyCode%%"},
				{"name": "currencyexchangerate", "err": "%%LNG_EnterCurrencyExchangeRate%%"},
				{"name": "currencystringposition", "err": "%%LNG_EnterCurrencyStringPosition%%"},
				{"name": "currencystring", "err": "%%LNG_EnterCurrencyString%%"},
				{"name": "currencydecimalstring", "err": "%%LNG_EnterCurrencyDecimalString%%"},
				{"name": "currencythousandstring", "err": "%%LNG_EnterCurrencyThousandString%%"},
				{"name": "currencydecimalplace", "err": "%%LNG_EnterCurrencyDecimalPlace%%"}
			);

			for (var i=0; i<checkElements.length; i++)
			{
				if ($("#" + checkElements[i].name).val() == "" || $("#" + checkElements[i].name).val() == null)
				{
					alert(checkElements[i].err);
					$("#" + checkElements[i].name).focus();
					return false;
				}
			}

			if (isNaN(priceFormat($("#currencyexchangerate").val())))
			{
				alert("%%LNG_InvalidCurrencyExchangeRate%%");
				$("#currencyexchangerate").focus();
				return false;
			}

			if (!checkCurrencyCode($("#currencycode").val()))
			{
				alert("%%LNG_InvalidCurrencyCode%%");
				$("#currencycode").focus();
				return false;
			}

			if (isNaN(parseInt($("#currencydecimalplace").val())))
			{
				alert("%%LNG_InvalidCurrencyDecimalPlace%%");
				$("#currencydecimalplace").focus();
				return false;
			}

			var oneCharElements = new Array(
				{"name": "currencydecimalstring", "err": "%%LNG_InvalidCurrencyDecimalString%%"},
				{"name": "currencythousandstring", "err": "%%LNG_InvalidCurrencyThousandString%%"}
			);

			for (var i=0; i<oneCharElements.length; i++)
			{
				if ($("#" + oneCharElements[i].name).val().length > 1 || (/\d+/).test($("#" + oneCharElements[i].name).val()))
				{
					alert(oneCharElements[i].err);
					$("#" + oneCharElements[i].name).focus();
					return false;
				}
			}

			if ($("#currencydecimalstring").val() == $("#currencythousandstring").val())
			{
				alert("%%LNG_InvalidCurrencyStringMatch%%");
				$("#currencydecimalplace").focus();
				return false;
			}

			return true;
		}

		function ConfirmCancel()
		{
			if(confirm('%%GLOBAL_CancelMessage%%'))
				document.location.href='index.php?ToDo=viewCurrencySettings';
			else
				return false;
		}

	</script>
