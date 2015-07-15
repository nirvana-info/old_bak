<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11">
<html>
<head>
	<title>%%LNG_ControlPanel%%</title>
	<meta http-equiv="Content-Type" content="text/html; charset=%%GLOBAL_CharacterSet%%" />
	<meta name="robots" content="noindex, nofollow" />
	<style type="text/css">
		@import url("Styles/styles.css");
		@import url('Styles/tabmenu.css');
		@import url("Styles/iselector.css");
	</style>
	<link rel="SHORTCUT ICON" href="favicon.ico" />
	<!--[if IE]>
	<style type="text/css">
		@import url("Styles/ie.css");
	</style>
	<![endif]-->
	<script type="text/javascript" src="../javascript/jquery.js"></script>
	<script type="text/javascript" src="script/menudrop.js"></script>
	<script type="text/javascript" src="script/common.js"></script>
	<script type="text/javascript" src="../javascript/iselector.js"></script>
	<script type="text/javascript" src="../javascript/thickbox.js"></script>
	<link rel="stylesheet" href="Styles/thickbox.css" type="text/css" media="screen" />
	<script type="text/javascript">
		var url = 'remote.php';
	</script>
</head>

<body>
	<form action="%%GLOBAL_ShopPath%%/admin/index.php?ToDo=%%GLOBAL_SubmitAction%%" method="post" name="frmLogin" id="frmLogin">
	<div id="box">
		<table><tr><td style="border:solid 2px #DDD; padding:20px; background-color:#FFF; width:300px">
		<table>
		  <tr>
			<td class="Heading1">
				<a href="index.php">%%GLOBAL_AdminLogo%%</a>
			</td>
		  </tr>
		  <tr>
			<td style="padding:10px 0px 5px 0px">%%GLOBAL_Message%%</td>
		  </tr>
		  <tr>
			<td>
				<table>
				<tr>
				  <td nowrap style="padding:0px 10px 0px 10px">%%LNG_UsernameLabel%%</td>
				  <td>
					<input type="text" name="username" id="username" class="Field150" value="%%GLOBAL_Username%%">
				  </td>
				</tr>
				<tr>
				  <td nowrap style="padding:0px 10px 0px 10px">%%LNG_PasswordLabel%%</td>
				  <td>
					<input type="password" name="password" id="password" class="Field150" value="%%GLOBAL_Password%%">
				  </td>
				</tr>
				<!--zcs=>-->
				<tr valign="top">
				    <td nowrap style="padding:0px 10px 0px 10px">%%LNG_CaptchaLabel%%</td>
				    <td><input class="Field150" type="text" name="captcha" id="captcha" /><br />%%GLOBAL_CaptchaImage%%</td>
				</tr>
				<!--<=zcs-->
				<tr>
				  <td nowrap>&nbsp;</td>
				  <td>&nbsp;<input type="checkbox" name="remember" id="remember" value="ON" style="margin-left:-0px"> <label for="remember">%%LNG_RememberMe%%</label>
				  </td>
				</tr>
				  <tr>
					<td>&nbsp;</td>
					<td>
					  <input type="submit" name="SubmitButton" value="%%LNG_Login%%" class="FormButton">
					  <br />%%LNG_ForgotPassLink%%
					</td>
				  </tr>
				  <tr><td class="Gap"></td></tr>
			  </table>
			</td>
		  </tr>
		</table>
		</td></tr></table>
	</div>
	</form>

	<script type="text/javascript">

		$('#frmLogin').submit(function() {
			var f = document.frmLogin;

			if(f.username.value == '')
			{
				alert('%%LNG_NoUsername%%');
				f.username.focus();
				f.username.select();
				return false;
			}

			if(f.password.value == '')
			{
				alert('%%LNG_NoPassword%%');
				f.password.focus();
				f.password.select();
				return false;
			}
			
			if(f.captcha.value == '')
			{
				alert('%%LNG_NoCaptcha%%');
				f.captcha.focus();
				f.captcha.select();
				return false;
			}

			// Everything is OK
			return true;
		});

		function sizeBox() {
			var w = $(window).width();
			var h = document.getElementsByTagName('html')[0].clientHeight
			$('#box').css('position', 'absolute');
			$('#box').css('top', h/2-($('#box').height()/2)-50);
			$('#box').css('left', w/2-($('#box').width()/2));
		}

		$(document).ready(function() {
			sizeBox();
			$('#username').focus();
		});

		$(window).resize(function() {
			sizeBox();
		});

	</script>

</body>
</html>