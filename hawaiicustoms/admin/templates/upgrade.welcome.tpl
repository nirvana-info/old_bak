<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11">
<html>
<head>
	<title>%%LNG_UpgradeInterspireShoppingCart%%</title>
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
	<style>
		h3 { font-size:13px; }
	</style>
	<script type="text/javascript">
		var url = 'remote.php';
		var critical_errors = "%%GLOBAL_CriticalErrors%%";
	</script>
	<script type="text/javascript" src="../javascript/jquery.js"></script>
	<script type="text/javascript" src="script/menudrop.js"></script>
	<script type="text/javascript" src="../javascript/thickbox.js"></script>
	<script type="text/javascript" src="script/common.js"></script>
	<script type="text/javascript" src="script/install.js"></script>
	<script type="text/javascript" src="../javascript/iselector.js"></script>
	<link rel="stylesheet" href="Styles/thickbox.css" type="text/css" media="screen" />
</head>

<body>
	<div id="box">
		<br /><br /><br /><br />
		<table><tr><td style="border:solid 2px #DDD; padding:20px; background-color:#FFF; width:450px">
		<table>
		  <tr>
			<td class="Heading1">
				<img src="images/logo.jpg" />
			</td>
		  </tr>
		  <tr>
			<td style="padding:10px 0px 5px 0px">
				<div style="display: %%GLOBAL_HideUpgradeWelcome%%">
					<strong>%%LNG_UpgradeInterspireShoppingCart%%</strong>
					<div style="%%GLOBAL_HideUpgradeWarning%%" class="MessageBox MessageBoxInfo">
						%%GLOBAL_UpgradeWarning%%
					</div>
					<p>%%GLOBAL_UpgradeFromTo%%</p>
					<p>%%LNG_UpgradeWelcomeStart%%</p>
					<p>
						<label><input type="checkbox" name="sendServerDetails" id="sendServerDetails" value="1" checked="checked" style="vertical-align: middle;" /> %%LNG_SendServerDetails%%</label>
						<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" onclick="alert('%%LNG_ServerDetailsInfo%%')" style="color:gray">%%LNG_WhatWillBeSent%%</a>
					</p>

					<input type="button" value="%%LNG_StartUpgrade%%" onclick="RunUpgrade()" class="FormButton Field100" />
				</div>
				<div style="display: %%GLOBAL_HideUpgradeContinue%%">
					<strong>%%LNG_UpgradeInterspireShoppingCart%%</strong>
					<p>%%LNG_UpgradeContinueWelcome%%</p>
					<input type="button" value="%%LNG_ContinueUpgrade%%" onclick="RunUpgrade()" class="Field100" />
				</div>
				<div style="display: %%GLOBAL_HideUpgradeErrors%%">
					<strong>%%LNG_UpgradeInterspireShoppingCart%%</strong>
					<p>%%GLOBAL_UpgradeFromTo%%</p>
					<p><strong style="color: red;">%%LNG_OopsUpgradePreChecks%%</strong></p>
					<ul>
						%%GLOBAL_UpgradeErrors%%
					</ul>
					<p>%%LNG_UpgradePreChecksRetry%%</p>
					<input type="button" value="%%LNG_Retry%%" onclick="document.location.reload()" class="Field100" />
				</div>

			</td>
		  </tr>
		</table>
		</td></tr></table>
		<div style="padding:10px; margin-bottom:20px; text-align:center">%%GLOBAL_Copyright%%</div>
	</div>
	<script type="text/javascript">
	function RunUpgrade() {
		var urlAppend = '';
		if($('#sendServerDetails:checked').val()) {
			urlAppend = '&sendServerDetails=1';
		}
		tb_show('', 'index.php?ToDo=showUpgradeFrame'+urlAppend+'&keepThis=true&TB_iframe=true&height=230&width=400&modal=true&random='+new Date().getTime(), '');
	}
	</script>
	%%GLOBAL_HiddenImage%%
</body>
</html>