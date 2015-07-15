<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>%%GLOBAL_ControlPanelTitle%%</title>
	<meta http-equiv="Content-Type" content="text/html; charset=%%GLOBAL_CharacterSet%%" />
	<meta name="robots" content="noindex, nofollow" />
	<style type="text/css">
		@import url("Styles/styles.css");
		@import url('Styles/tabmenu.css');
		@import url("Styles/iselector.css");
		@import url('../javascript/jquery/plugins/imodal/imodal.css');
		@import url('Styles/iconsearchbox.css');
		%%GLOBAL_AdditionalStylesheets%%
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
<!--	<script type="text/javascript" src="../javascript/iselector.js"></script>-->
<!-- TodoPage variable comes from class.engine file -->
    %%GLOBAL_TodoPage%%
	<script type="text/javascript" src="../javascript/thickbox.js"></script>
	<script type="text/javascript" src="../javascript/jquery/plugins/shiftcheckbox.js"></script>
	<script type="text/javascript" src="../javascript/jquery/plugins/ui.core.js"></script>
	<script type="text/javascript" src="../javascript/jquery/plugins/imodal/imodal.js"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			jQuery.shiftcheckbox.init();
		});
		config.ProductName = '%%GLOBAL_ProductName%%';
		var ThousandsToken = '%%GLOBAL_ThousandsToken%%';
		var DecimalToken = '%%GLOBAL_DecimalToken%%';
		var DimensionsThousandsToken = '%%GLOBAL_DimensionsThousandsToken%%';
		var DimensionsDecimalToken = '%%GLOBAL_DimensionsDecimalToken%%';
	</script>


	<link rel="stylesheet" href="Styles/thickbox.css" type="text/css" media="screen" />      
    <link rel="stylesheet" href="Styles/timePicker.css" type="text/css" media="screen" />
	<script type="text/javascript">
		var url = 'remote.php';
	</script>
	%%GLOBAL_RTLStyles%% 
</head>

<body>
<div id="AjaxLoading"><img src="images/ajax-loader.gif" />&nbsp; %%LNG_LoadingPleaseWait%%</div>
%%GLOBAL_WarningNotices%%
<div class="Header">
	<div class="logo">
		<a href="index.php">%%GLOBAL_AdminLogo%%</a>
	</div>

	<div class="textlinks">
		%%GLOBAL_textLinks%%
	</div>

	<div class="LoggedInAs">
		%%GLOBAL_CurrentlyLoggedInAs%%
	</div>
</div>

<div class="menuBar">


	<div class="ControlPanelSearchBar">
		<form method="post" action="index.php?ToDo=quickSearch">
			<input id="quicksearch" onfocus="$(this).addClass('QuickSearchFocused'); if(!$(this).data('custom')) { $(this).val(''); }" onblur="if($(this).val()) { $(this).data('custom', 1); return; } $(this).removeClass('QuickSearchFocused'); if(!$(this).val()) { $(this).val('%%LNG_QuickSearchValue%%'); $(this).data('custom', 0); }" name="query" type="text" value="%%LNG_QuickSearchValue%%" />
		</form>
	</div>
	%%Panel.menubar%%
</div>

<div class="ContentContainer">
	<div class="Breadcrumb" style="%%GLOBAL_HideBreadcrumb%%">
		%%GLOBAL_BreadcrumbTrail%%
	</div>

	%%GLOBAL_InfoTip%%
