
	<div class="BodyContainer">
	<form name="frmCurrency" id="frmCurrency" method="post" action="index.php?ToDo=settingsSaveCurrencySettings" onsubmit="return ValidateForm(CheckCurrencyForm);">
	<input type="hidden" name="currentTab" id="currentTab" value="0" />
	<table id="Table13" cellSpacing="0" cellPadding="0" width="100%">
		<tr>
			<td class="Heading1">%%LNG_Currency%%</td>
		</tr>
		<tr>
			<td class="Intro">
				<p>%%GLOBAL_CurrencyIntro%%</p>
				%%GLOBAL_Message%%
			</td>
		</tr>
		<tr>
			<td>
				<ul id="tabnav">
					%%GLOBAL_CurrencyTabs%%
					<li><a href="#" class="active" id="tab1" onclick="ShowTab(1)">%%LNG_CurrencyRateSettings%%</a></li>
				</ul>
			</td>
		</tr>
		<tr>
		<td>
			<div id="div0" style="padding-top: 10px;">
				<table class="GridPanel" cellspacing="0" cellpadding="0" border="0" style="width:100%;">
				<tr>
					<td colspan="7" class="EmptyRow">%%GLOBAL_CurrencyOptionsMessage%%</td>
				</tr>
				<tr>
					<td colspan="7" class="EmptyRow" style="padding: 2px;"></td>
				</tr>
				<tr>
					<td colspan="7">
						<input type="button" name="IndexAddButton" value="%%LNG_AddCurrency%%..." id="IndexCreateButton" class="SmallButton" onclick="document.location.href='index.php?ToDo=settingsAddCurrency'" /> &nbsp;
						<input type="button" name="IndexDeleteButton" value="%%LNG_DeleteSelected%%" id="IndexDeleteButton" class="SmallButton" onclick="ConfirmDeleteSelected()" %%GLOBAL_DisableDelete%% /> &nbsp;
						%%GLOBAL_UpdateExchageRateButton%%
					</td>
				</tr>
				<tr>
					<td colspan="7" class="EmptyRow">&nbsp;</td>
				</tr>
				<tr class="Heading3" style="display: %%GLOBAL_ShowCurrencyTableHeaders%%">
					<td align="center" style="width:18px"><input type="checkbox" onclick="ToggleDeleteBoxes(this.checked)"></td>
					<td>&nbsp;</td>
					<td>
						%%LNG_CurrencyName%%
					</td>
					<td>
						%%LNG_Currency%%
					</td>
					<td>
						%%LNG_ExchangeRate%%
					</td>
					<td style="width:70px;">
						%%LNG_Status%%
					</td>
					<td style="width:120px;">
						%%LNG_Action%%
					</td>
				</tr>
				%%GLOBAL_CurrencyGrid%%
				</table>
			</div>

			<div id="div1" style="padding-top: 10px;">
				<table width="100%" class="Panel">
					<tr>
						<td class="Heading2" colspan="2">%%LNG_ExchangeRateSettings%%</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							<label for="converterproviders">%%LNG_CurrencyMethods%%:</label>
						</td>
						<td class="PanelBottom">
							<select size="8" multiple name="converterproviders[]" id="converterproviders" class="Field250 ISSelectReplacement">
								%%GLOBAL_ConverterProviders%%
							</select>
							<img onmouseout="HideHelp('d1');" onmouseover="ShowHelp('d1', '%%LNG_CurrencyMethods%%', '%%LNG_CurrencyMethodsHelp%%')" src="images/help.gif" width="24" height="16" border="0">
							<div style="display:none" id="d1"></div>
						</td>
					</tr>
					<tr>
						<td colspan="2" class="EmptyRow">
							&nbsp;
						</td>
					</tr>
					<tr>
						<td class="Heading2" colspan="2">%%LNG_AutomaticExchangeRateUpdates%%</td>
					</tr>
					<tr>
						<td colspan="2">
							<p class="HelpInfo">%%LNG_AutomaticExchangeRateUpdatesHelp%%</p>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							<label for="cronpath">%%LNG_ExchangeRateCronCommand%%:</label>
						</td>
						<td class="PanelBottom">
							<input type="text" class="Field250" name="cronpath" id="cronpath" value="%%GLOBAL_ExchangeRatePath%%" />
							<img onmouseout="HideHelp('d2');" onmouseover="ShowHelp('d2', '%%LNG_ExchangeRateCronCommand%%', '%%LNG_ExchangeRateCronCommandHelp%%')" src="images/help.gif" width="24" height="16" border="0">
							<div style="display:none" id="d2"></div>
						</td>
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
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>

	</table>
	</form>
	</div>

	<script type="text/javascript">

		var updateExchageRateSequency = new Array();
		var PopupPositioned           = false;

		function ToggleDeleteBoxes(Status)
		{
			var fp = document.getElementById("frmCurrency").getElementsByTagName('input');

			for (var i=0; i < fp.length; i++)
			{
				if (!fp[i].getAttribute('disabled'))
					fp[i].checked = Status;
			}
		}

		function getSelected()
		{
			var inputs = document.getElementById("frmCurrency").getElementsByTagName('input');
			var nodes  = new Array();

			for (var i=0; i<inputs.length; i++)
			{
				if (inputs[i].type == "checkbox" && inputs[i].name == "currencies[]" && inputs[i].checked)
					nodes[nodes.length] = inputs[i];
			}

			return nodes
		}

		function hasSelected()
		{
			var nodes = getSelected();
			return nodes.length > 0;
		}

		function ConfirmDeleteSelected()
		{
			if (hasSelected())
			{
				if (confirm("%%LNG_ConfirmDeleteCurrency%%")) {
					$('#frmCurrency').attr('action', 'index.php?ToDo=settingsDeleteCurrencies');
					document.getElementById("frmCurrency").submit();
				}
			}
			else
			{
				alert("%%LNG_ChooseCurrencyDelete%%");
			}
		}

		function ConfirmUpdateSelectedExchangeRate()
		{
			var nodes = getSelected();

			if (nodes.length > 0)
			{
				if (confirm("%%LNG_ConfirmUpdateCurrencyExchangeRate%%")) {

					/**
					 * A quick hack to remove the status nodes from previous updates
					 */
					var spans  = document.getElementById("frmCurrency").getElementsByTagName('span');
					var substr = "currencyexchangeratestatus-";

					for (var i=(spans.length-1); i>=0; i--)
					{
						if (spans[i].id.substring(0, substr.length) == substr)
						{
							var parent = spans[i].parentNode;
							parent.removeChild(spans[i]);
						}
					}

					/**
					 * This is the main part to update the exchage rates. It simulates a cascading affect
					 */
					updateExchageRateSequency = new Array();

					for (var i=0; i<nodes.length; i++)
						updateExchageRateSequency[updateExchageRateSequency.length] = nodes[i].value;

					updateExchangeRate(updateExchageRateSequency[0], 0);
				}
			}
			else
			{
				alert("%%LNG_ChooseCurrencyUpdate%%");
			}
		}

		function updateExchangeRate(id, seq)
		{
			$.ajax({
				url     : url,
				data    : "w=updateExchangeRate&cid=%%GLOBAL_SelectedCurrencyModuleId%%&currencyid=" + id + "&seq=" + seq,
				async   : true,
				cache   : false,
				success : ProcessData
			});
		}

		function ProcessData(data)
		{
			eval('var data = ' + data);

			var currencyExchangeRateNode = document.getElementById("currencyexchangerate-" + data.id);
			var statusNode               = document.createElement("span");
			var text, colour;

			statusNode.id                = "currencyexchangeratestatus-" + data.id;
			statusNode.style.marginLeft  = "10px";
			statusNode.style.fontSize    = "0.8em";
			statusNode.style.fontWeight  = "bold";

			switch (data.status)
			{
				case 0:
					colour = "green";
					text   = "(%%LNG_CurrencyExchangeRateUpdateSuccess%%)";

					currencyExchangeRateNode.innerHTML = data.newRate;

					break;
				case 2:
					colour = "blue";
					text   = "(%%LNG_CurrencyExchangeRateUpdateInvalid%%)";
					break;
				case 1:
				default:
					colour = "red";
					text   = "(%%LNG_CurrencyExchangeRateUpdateFailed%%)";
					break;

			}

			statusNode.style.color = colour;
			statusNode.appendChild(document.createTextNode(text));
			currencyExchangeRateNode.appendChild(statusNode);

			/**
			 * Leave this as a timeout function as jquery will only display the animated ajax gif for one interation, not all the others
			 */
			if (data.seq < (updateExchageRateSequency.length - 1))
				window.setTimeout("updateExchangeRate(" + updateExchageRateSequency[data.seq+1] + ", " + (data.seq+1) + ");", 1);
		}

		function ConfirmCancel()
		{
			if(confirm("%%LNG_ConfirmCancelCurrencySettings%%")) {
				document.location.href = "index.php?ToDo=viewCurrencySettings";
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

		function CheckCurrencyForm()
		{
			if ($("#currencytype2").attr('checked')) {
				if (isNaN(priceFormat($("#DefaultCurrency").val())) || $("#DefaultCurrency").val() < 0) {
					alert("%%LNG_EnterACurrency%%");
					$("#DefaultCurrency").focus();
					$("#DefaultCurrency").select();
					return false;
				}
			}
			return true;
		}

		function ConfirmSetAsDefault(currencyId)
		{
			$("#%%GLOBAL_PopupID%%ButtonYes").click(function() { location.href = "index.php?ToDo=settingsSetAsDefaultCurrency&currencyId=" + currencyId + "&updatePrice=0" });
			$("#%%GLOBAL_PopupID%%ButtonYesPrice").click(function() { location.href = "index.php?ToDo=settingsSetAsDefaultCurrency&currencyId=" + currencyId + "&updatePrice=1" });
			$("#%%GLOBAL_PopupID%%ButtonNo").click(function() { $("#%%GLOBAL_PopupID%%").hide("slow"); });

			if (!PopupPositioned)
			{
				$("#%%GLOBAL_PopupID%%").css("left", (($(window).width() - $("#%%GLOBAL_PopupID%%").width()) / 2) + "px");
				$("#%%GLOBAL_PopupID%%").css("top", (($(window).height() - $("#%%GLOBAL_PopupID%%").height()) / 2) + "px");
				PopupPositioned = true;
			}

			$("#%%GLOBAL_PopupID%%").show("slow", function() { $("#%%GLOBAL_PopupID%%ButtonYes").focus(); });
		}

		$(document).ready(function() {
			ShowTab(%%GLOBAL_DefaultTab%%);
		});

	</script>

	%%Panel.popup%%