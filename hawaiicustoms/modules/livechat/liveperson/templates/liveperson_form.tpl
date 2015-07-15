<div style="margin-top: -20px; height:85%">
	<h2>%%LNG_LivePersonCreateAccount%%</h2>
	<p class="Intro">%%LNG_LivePersonCreateAccountIntro%%</p>
	<form method="get" action="http://server.iad.liveperson.net/hc/" onsubmit="return ValidateLivePersonForm();">
		<input type="hidden" name="cmd" value="oemRegisterNewUser" />
		<input type="hidden" name="oem" value="LA" />
		<input type="hidden" name="varId" value="4970" />
		<input type="hidden" name="siteClass" value="3" />
		<input type="hidden" name="url" value="%%GLOBAL_ShopPathNormal%%" />
		<input type="hidden" name="returnUrl" value="%%GLOBAL_ShopPathNormal%%/admin/index.php?ToDo=liveChatSettingsCallback&amp;module=livechat_liveperson&amp;func=PerformLivePersonRegistration" />
		<table class="Panel">
			<tr>
				<td class="FieldLabel">
					<span class="Required">*</span>&nbsp;%%LNG_Username%%:
				</td>
				<td>
					<input type="text" name="user" id="lp_username" class="Field200" value="%%GLOBAL_CurrentUser%%" autocomplete="off" />
				</td>
			</tr>
			<tr>
				<td class="FieldLabel">
					<span class="Required">*</span>&nbsp;%%LNG_Password%%:
				</td>
				<td>
					<input type="password" name="password" id="lp_password" class="Field200" autocomplete="off" />
				</td>
			</tr>
			<tr>
				<td class="FieldLabel">
					<span class="Required">*</span>&nbsp;%%LNG_EmailAddress%%:
				</td>
				<td>
					<input type="text" name="email" id="lp_email" class="Field200" value="%%GLOBAL_CurrentEmail%%" autocomplete="off" />
				</td>
			</tr>
			<tr>
				<td class="FieldLabel">
					<span class="Required">*</span>&nbsp;%%LNG_LivePersonPosition%%:
				</td>
				<td>
					<select name="lp_position" id="lp_position" class="Field200">
						<option value='panel'>%%LNG_LivePersonPositionSide%%</option>
						<option value='header'>%%LNG_LivePersonPositionHeader%%</option>
					</select>
				</td>
			</tr>
		</table>
		<table class="PanelPlain">
			<tr>
				<td class="FieldLabel">&nbsp;</td>
				<td><input type="submit" value="%%LNG_LivePersonCreateAccount%%" class="FormButton" style="width:110px" /> <input type="button" value="%%LNG_Cancel%%" onclick="window.parent.tb_remove()" class="FormButton" /></td>
			</tr>
		</table>
	</form>
</div>
<script type="text/javascript">
function ValidateLivePersonForm()
{
	if(!$('#lp_username').val()) {
		alert('Please enter the username to use for your LivePerson account');
		$('#lp_username').focus();
		return false;
	}

	if(!$('#lp_password').val()) {
		alert('Please enter the password to use for your LivePerson account');
		$('#lp_password').focus();
		return false;
	}

	if($('#lp_email').val().indexOf('@') == -1) {
		alert('Please enter the email address to use for your LivePerson account');
		$('#lp_email').focus();
		return false;
	}
	window.parent.UpdatePosition($('#lp_position').val());
	return true;
}
</script>