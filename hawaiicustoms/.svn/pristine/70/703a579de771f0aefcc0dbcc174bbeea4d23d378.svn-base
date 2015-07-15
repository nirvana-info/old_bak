<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11">
<html>
<head>
	<title>%%LNG_ControlPanel%%</title>
	<meta name="viewport" content="width=320; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"/>
	<style type="text/css" media="screen">@import "templates/iphone/iui/iui.css";</style>
	<script type="application/x-javascript" src="templates/iphone/iui/iui.js"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=%%GLOBAL_CharacterSet%%" />
	<meta name="robots" content="noindex, nofollow" />
</head>

<body>
    <div class="toolbar">
        <h1 id="pageTitle"></h1>
    </div>
    <div id="Login" title="%%LNG_LoginBelow%%" class="panel" selected="true">
	<fieldset>
	<form action="index.php?ToDo=%%GLOBAL_SubmitAction%%" class="dialog" onsubmit="return CheckLoginForm()" method="post">
	    <div class="row">
                <label>%%LNG_Username%%</label>
                <input type="text" name="username" id="username" value="%%GLOBAL_Username%%"/>
            </div>
            <div class="row">
                <label>%%LNG_Password%%</label>
                <input type="password" name="password" id="password" value="%%GLOBAL_Password%%"/>
            </div>
	</fieldset>
    	<input type="submit" value="%%LNG_Login%%" style="margin-top:-10px" />
	</form>
    </div>

    <script type="text/javascript">

	function CheckLoginForm() {
		var u = document.getElementById("username");
		var p = document.getElementById("password");

		if(u.value == "") {
			alert('%%LNG_NoUsername%%');
			u.focus();
			return false;
		}

		if(p.value == "") {
			alert('%%LNG_NoPassword%%');
			p.focus();
			return false;
		}

		// Everything is OK
		return true;
	}

    </script>

</body>
</html>