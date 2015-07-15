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
	<form action="index.php?ToDo=sendPassEmail" method="post" name="frmForgotPass" id="frmForgotPass">
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
				  <td nowrap style="padding:0px 10px 0px 10px">%%LNG_NewPassword%%:</td>
				  <td>
					<input type="password" name="newpassword" id="newpassword" class="Field150" value="%%GLOBAL_Password%%">
				  </td>
				</tr>
				  <tr>
					<td>&nbsp;</td>
					<td>
					  <input type="submit" name="SubmitButton" value="%%LNG_SendEmail%%" class="FormButton">
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

		$('#frmForgotPass').submit(function() {
			if($('#username').val() == '') {
				alert('%%LNG_NoUsername%%');
				$('#username').focus();
				return false;
			}

			if($('#newpassword').val() == '') {
				alert('%%LNG_NoNewPassword%%');
				$('#newpassword').focus();
				return false;
			}
			// Everything is OK
			return true;
		});

		function sizeBox() {
			var w = $(window).width();
			var h = $(window).height();
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