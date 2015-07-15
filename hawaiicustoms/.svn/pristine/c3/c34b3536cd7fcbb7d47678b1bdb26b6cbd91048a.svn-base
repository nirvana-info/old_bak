
	<form action="index.php?ToDo=saveUpdatedScriptSettings" name="frmScriptSettings" id="frmScriptSettings" method="post" onsubmit="return ValidateForm(CheckScriptSettingsForm)">
		<div class="BodyContainer">
		<table cellSpacing="0" cellPadding="0" width="100%" style="margin-left: 4px; margin-top: 8px;">
		<tr>
			<td class="Heading1">%%LNG_OrderSettings%%</td>
		</tr>
		<tr>
			<td class="Intro">
				<p>%%LNG_OrderSettingsIntro%%</p>
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
					<li><a href="#" class="active" id="tab0" onclick="ShowTab(0)">%%LNG_OrderSettings%%</a></li>
					<li style="display:none"><a href="#" id="tab1" onclick="ShowTab(1)"></a></li>
					%%GLOBAL_OrderTabs%%
				</ul>
			</td>
		</tr>
		<tr>
			<td>
				<form action="index.php?ToDo=saveUpdatedScriptSettings" name="frmOrderSettings" id="frmOrderSettings" method="post">
				<input id="currentTab" name="currentTab" value="0" type="hidden">
				<div id="div0" style="padding-top: 10px;">
					<table width="100%" class="Panel">
						<tr class="" style="">     
                            <td nowrap="" class="FieldLabel">
                                <span class="Required">*</span> <label for="StoreName">Campaign Code:</label>
                            </td>
                            <td class="">
                                <textarea rows="7" id="campaigncode" name="campaigncode" class="Field250">%%GLOBAL_CampaignCode%%</textarea><div id="d11390" style="display: none;"/>
                            </td>
                        </tr>
                        <tr class="" style="">
                            <td nowrap="" class="FieldLabel">
                                <span class="Required">*</span><label for="StoreName">Order Complete Message:</label>
                            </td>
                            <td class="">
                                <textarea rows="7" id="ordercompletemsg" name="ordercompletemsg" class="Field250">%%GLOBAL_OrderCompleteMsg%%</textarea>
                                <div id="d11390" style="display: none;"/>
                            </td>
                        </tr>
					</table>
				</div>
				<div id="div1" style="padding-top: 10px;"> 
				</div>               
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
			if(g('orderproviders_old')) {
				var cp = g('orderproviders_old');
			}
			else {
				var cp = document.getElementById("orderproviders");
			}			var selected = [];
			for(i = 0; i < cp.options.length; i++) {
				if(cp.options[i].selected) {
					selected[selected.length] = cp.options[i].value;
				}
			}

			return selected;
		}

		function order_selected(order_id) {
			var selected = get_selected();
			for(i = 0; i < cp.selected; i++) {
				if(selected[i] == order_id)
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

		function CheckOrderSettingsForm() {
			var selected = get_selected();

			if (selected.length > 0 && "%%GLOBAL_SSLIsConfigured%%" != "1") {
				alert("%%LNG_QuickBooksRequireSSLError%%");
				return false;
			}

			%%GLOBAL_OrderJavaScript%%
		}

		function ConfirmCancel() {
			if(confirm('%%LNG_CancelOrderMessage%%')) {
				document.location.href='index.php?ToDo=viewScriptSettings';
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



