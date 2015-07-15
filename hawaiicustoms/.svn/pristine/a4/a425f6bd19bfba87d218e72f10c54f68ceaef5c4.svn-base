<table id="OuterPanel" cellSpacing="0" cellPadding="0" width="100%">
	<tr>
		<td class="Heading1">
			%%LNG_ImportInProgress%%
		</td>
	</tr>
	<tr>
		<td class="Intro">
			<div class="IntroItem">
				<div>
					<div style="position: relative;border: 1px solid #ccc; width: 300px; padding: 0px; margin: 0 auto;">
						<div id="progressBarPercentage" style="margin: 0; padding: 0; background: url(images/progressbar.gif) no-repeat; height: 20px; width: 0%;">
							&nbsp;
						</div>
						<div style="position: absolute; top: 2px; left: 0; text-align: center; width: 300px; font-weight: bold;" id="progressPercent">&nbsp;</div>
					</div>
					<div id="progressBarStatus" style="text-align: center;">&nbsp;</div>
				</div>
			</div>
			<div id="report">%%GLOBAL_Report%%</div>
		</td>
	</tr>
</table>
<script type="text/javascript">
	function UpdateImportStatus(status, percentage)
	{
		var f = document.getElementById('progressBarPercentage');
		f.style.width = parseInt(percentage) + "%";
		var f = document.getElementById('progressPercent');
		f.innerHTML = parseInt(percentage) + "%";
		var f = document.getElementById('progressBarStatus');
		f.innerHTML = status;
	}

	function UpdateImportStatusReport(report)
	{
		document.getElementById('report').innerHTML = report;
	}
</script>
<!-- iframe which does all of the work -->
<iframe src="index.php?ToDo=import%%GLOBAL_Type%%&amp;Step=4&amp;ImportSession=%%GLOBAL_ImportSession%%" width="1" height="1" frameborder="0" border="0"></iframe>