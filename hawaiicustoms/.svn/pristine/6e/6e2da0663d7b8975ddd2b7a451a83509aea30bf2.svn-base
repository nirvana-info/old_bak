<table width="100%" cellspacing="0" cellpadding="0" class="DashboardPanel" style="display: %%GLOBAL_HideOrdersGraph%%">
	<tr>
		<td class="Heading2">
			<div class="PanelHeader" id="HomeOrdersVisitorsTitle">%%LNG_OrdersAndVisitors7Days%%</div>
		</td>
	</tr>
	<tr>
		<td class="PanelContent">
			<div id="flashcontent"></div>
			<script type="text/javascript">
				$(document).ready(function() {
					var so = new SWFObject("%%GLOBAL_ShopPath%%/admin/includes/amcharts/amline/amline.swf", "amline", "98%", "430", "8", "#FFFFFF");
					so.addVariable("path", "%%GLOBAL_ShopPath%%/admin//includes/amcharts/");
					so.addVariable("wmode", "transparent");
					so.addVariable("settings_file", escape("%%GLOBAL_ShopPath%%/admin//includes/amcharts/overviewgeneral.xml"));
					so.addVariable("data_file", escape("%%GLOBAL_ShopPath%%/admin//index.php?ToDo=overviewStatsData&from=%%GLOBAL_FromStamp%%&to=%%GLOBAL_ToStamp%%"));
					so.addVariable("preloader_color", "#000000");
					so.write("flashcontent");
				});
			</script>
		</td>
	</tr>
</table>