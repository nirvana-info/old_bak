
	<form action="index.php?ToDo=saveUpdatedAddonSettings" name="frmAddonSettings" id="frmAddonSettings" method="post" onsubmit="return ValidateForm(CheckAddonSettingsForm)">
		<div class="BodyContainer">
		<table cellSpacing="0" cellPadding="0" width="100%" style="margin-left: 4px; margin-top: 8px;">
		<tr>
			<td class="Heading1">%%LNG_AddonSettings%%</td>
		</tr>
		<tr>
			<td class="Intro">
				<p>%%LNG_AddonSettingsIntro%%</p>
				%%GLOBAL_Message%%
				<p>
					<input type="submit" value="%%LNG_Save%%" class="FormButton" />
					<input type="reset" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()" />
				</p>
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<ul id="tabnav">
					<li><a href="#" class="active" id="tab0" onclick="ShowTab(0)">%%LNG_GeneralSettings%%</a></li>
					<!-- li style="display:none"><a href="#" id="tab1" onclick="ShowTab(1)"></a></li -->
					%%GLOBAL_AddonTabs%%
				</ul>
			</td>
		</tr>
		<tr>
			<td>
				<input id="currentTab" name="currentTab" value="0" type="hidden">
				<div id="div0" style="padding-top: 10px;">
					<table width="100%" class="Panel">
						<tr>
							<td class="FieldLabel">
								<label for="storename">%%LNG_AddonPackages%%:</label>
							</td>
							<td class="PanelBottom">
								<select size="%%GLOBAL_AddonSelectBoxSize%%" multiple name="addonpackages[]" id="addonpackages" class="Field250 ISSelectReplacement">
									%%GLOBAL_AddonProviders%%
								</select>
								<img onmouseout="HideHelp('d5');" onmouseover="ShowHelp('d5', '%%LNG_AddonPackages%%', '%%LNG_AddonPackagesHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="d5"></div>
							</td>
						</tr>
					</table>
				</div>
				%%GLOBAL_AddonDivs%%
				<table border="0" cellspacing="0" cellpadding="2" width="100%" class="PanelPlain" id="SaveCancelBottom">
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
			</td>
		</tr>
		</table>
		</div>
	</form>

	<script type="text/javascript">

		var hide_buttons_on_tabs = '%%GLOBAL_TabIdsToHideButtonsFrom%%';

		function package_selected(package_id) {
			var ap = document.getElementById("addonpackages_old");

			for(i = 0; i < ap.options.length; i++) {
				if(ap.options[i].value == package_id && ap.options[i].selected)
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

			document.getElementById("div" + T).style.display = "";
			document.getElementById("tab" + T).className = "active";
			document.getElementById("currentTab").value = T;

			// Is this a tab on which we have to hide the save/cancel buttons
			if(hide_buttons_on_tabs.indexOf(T + '|') > -1) {
				$('#SaveCancelBottom').hide();
			}
			else {
				$('#SaveCancelBottom').show();
			}
		}

		function ConfirmCancel()
		{
			if(confirm("%%LNG_ConfirmCancelAddonsSettings%%"))
				document.location.href = "index.php?ToDo=viewAddonSettings";
		}

		function CheckAddonSettingsForm() {
			%%GLOBAL_AddonJavaScript%%
		}

		$(document).ready(function() {
			// Load the main addons settings tab by default
			ShowTab(%%GLOBAL_CurrentTab%%);
		});


	</script>
