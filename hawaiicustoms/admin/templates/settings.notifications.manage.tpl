
	<form action="index.php?ToDo=saveUpdatedNotificationSettings" name="frmNotificationSettings" id="frmNotificationSettings" method="post" onsubmit="return ValidateForm(CheckNotificationSettingsForm)">
		<div class="BodyContainer">
		<table cellSpacing="0" cellPadding="0" width="100%" style="margin-left: 4px; margin-top: 8px;">
		<tr>
			<td class="Heading1">%%LNG_NotificationSettings%%</td>
		</tr>
		<tr>
			<td class="Intro">
				<p>
					%%LNG_NotificationSettingsIntro%%
				</p>
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
					%%GLOBAL_NotificationTabs%%
				</ul>
			</td>
		</tr>
		<tr>
			<td>
				<form action="index.php?ToDo=saveUpdatedNotificationSettings" name="frmNotificationSettings" id="frmNotificationSettings" method="post">
				<input id="currentTab" name="currentTab" value="0" type="hidden">
				<div id="div0" style="padding-top: 10px;">
					<table width="100%" class="Panel">
						<tr>
							<td class="Heading2" colspan="2">%%LNG_NotificationSettings%%</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								<label for="storename">%%LNG_NotificationMethods%%:</label>
							</td>
							<td class="PanelBottom">
								<select size="8" multiple name="notificationproviders[]" id="notificationproviders" class="Field250 ISSelectReplacement">
									%%GLOBAL_NotificationProviders%%
								</select>
								<img onmouseout="HideHelp('d1');" onmouseover="ShowHelp('d1', '%%LNG_NotificationMethods%%', '%%LNG_NotificationMethodsHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="d1"></div>
							</td>
						</tr>

					</table>
				</div>
				<div id="div1" style="padding-top: 10px;">


				</div>
				%%GLOBAL_NotificationDivs%%
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
				</form>
			</td>
		</tr>
		</table>
		</div>
	</form>

	<script type="text/javascript">

		function ShowTab(T) {
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

		function ConfirmCancel() {
			if(confirm("%%LNG_ConfirmCancelNotificationSettings%%"))
				document.location.href = "index.php?ToDo=viewNotificationSettings";
		}

		function notification_selected(notification_id) {
			var np = document.getElementById("notificationproviders_old");

			for(i = 0; i < np.options.length; i++) {
				if(np.options[i].value == notification_id && np.options[i].selected)
					return true;
			}

			return false;
		}

		function CheckNotificationSettingsForm() {

			%%GLOBAL_NotificationJavaScript%%
			return true;
		}

		// Load the main notification settings tab by default
		ShowTab(%%GLOBAL_CurrentTab%%);

	</script>
