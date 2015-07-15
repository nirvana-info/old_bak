
	<form action="index.php?ToDo=saveUpdatedAccountingSettings" name="frmAccountingSettings" id="frmAccountingSettings" method="post" onsubmit="return ValidateForm(CheckAccountingSettingsForm)">
		<div class="BodyContainer">
		<table cellSpacing="0" cellPadding="0" width="100%" style="margin-left: 4px; margin-top: 8px;">
		<tr>
			<td class="Heading1">%%LNG_AccountingSettings%%</td>
		</tr>
		<tr>
			<td class="Intro">
				<p>%%LNG_AccountingSettingsIntro%%</p>
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
					<li style="display:none"><a href="#" id="tab1" onclick="ShowTab(1)"></a></li>
					%%GLOBAL_AccountingTabs%%
				</ul>
			</td>
		</tr>
		<tr>
			<td>
				<form action="index.php?ToDo=saveUpdatedAccountingSettings" name="frmAccountingSettings" id="frmAccountingSettings" method="post">
				<input id="currentTab" name="currentTab" value="0" type="hidden">
				<div id="div0" style="padding-top: 10px;">
					<table width="100%" class="Panel">
						<tr>
							<td class="Heading2" colspan="2">%%LNG_AccountingSettings%%</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								<label for="storename">%%LNG_AccountingMethods%%:</label>
							</td>
							<td class="PanelBottom">
								<select size="11" multiple="multiple" name="accountingproviders[]" id="accountingproviders" class="Field300 ISSelectReplacement">
									%%GLOBAL_AccountingProviders%%
								</select>
								<img onmouseout="HideHelp('d1');" onmouseover="ShowHelp('d1', '%%LNG_AccountingMethods%%', '%%LNG_AccountingMethodsHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="d1"></div>
							</td>
						</tr>
					</table>
				</div>
				<div id="div1" style="padding-top: 10px;">


				</div>
				%%GLOBAL_AccountingDivs%%
				<table border="0" cellspacing="0" cellpadding="2" width="100%" class="PanelPlain" id="BottomButtons">
					<tr>
						<td width="200" class="FieldLabel">
							&nbsp;
						</td>
						<td>
							<input class="FormButton" type="submit" value="Save">
							<input type="reset" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()" />
						</td>
					</tr>
				</table>
				</form>
			</td>
		</tr>
		</table>
		</div>
	</form>

	<script type="text/javascript">

		function get_selected() {
			if(g('accountingproviders_old')) {
				var cp = g('accountingproviders_old');
			}
			else {
				var cp = document.getElementById("accountingproviders");
			}			var selected = [];
			for(i = 0; i < cp.options.length; i++) {
				if(cp.options[i].selected) {
					selected[selected.length] = cp.options[i].value;
				}
			}

			return selected;
		}

		function accounting_selected(accounting_id) {
			var selected = get_selected();
			for(i = 0; i < cp.selected; i++) {
				if(selected[i] == accounting_id)
					return true;
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

			if (parseInt(T) !== 0) {
				$('#BottomButtons').hide();
			} else {
				$('#BottomButtons').show();
			}

			document.getElementById("div" + T).style.display = "";
			document.getElementById("tab" + T).className = "active";
			document.getElementById("currentTab").value = T;
		}

		function CheckAccountingSettingsForm() {
			var selected = get_selected();

			if (selected.length > 0 && "%%GLOBAL_SSLIsConfigured%%" != "1") {
				alert("%%LNG_QuickBooksRequireSSLError%%");
				return false;
			}

			%%GLOBAL_AccountingJavaScript%%
		}

		function ConfirmCancel() {
			if(confirm('%%LNG_CancelAccountingMessage%%')) {
				document.location.href='index.php?ToDo=viewAccountingSettings';
			}
			else {
				return false;
			}
		}

		// Load the main shipping settings tab by default
		ShowTab(%%GLOBAL_CurrentTab%%);

		// Do onload stuff here
		$(document).ready(function () { %%GLOBAL_AccountExtraJS%% });

	</script>



