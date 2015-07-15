<table id="OuterPanel" cellSpacing="0" cellPadding="0" width="95%">
	<tr>
		<td class="Heading1">
			%%GLOBAL_Title%%
		</td>
	</tr>
	<tr>
		<td class="Intro">
			<div>%%GLOBAL_Description%%</div>
		</td>
	</tr>
	<tr>
		<td class="Intro">
			<div>
				<div style="border: 1px solid #ccc; width: 300px; padding: 0px; margin: 0 auto; position: relative;">
					<div id="progressBarPercentage" style="margin: 0; padding: 0; background: url(images/progressbar.gif) no-repeat; height: 20px; width: 0%;">
						&nbsp;
					</div>
					<div style="position: absolute; top: -6px; left: 0; text-align: center; width: 300px; font-weight: bold;" id="progressPercent">&nbsp;</div>
				</div>
				<div id="progressBarStatus" style="text-align: center;">&nbsp;</div>
			</div>
		</td>
	</tr>
</table>
<script type="text/javascript">
	function UpdateProgress(status, percentage)
	{
		var f = document.getElementById('progressBarPercentage');
		f.style.width = parseInt(percentage) + "%";
		var f = document.getElementById('progressPercent');
		f.innerHTML = parseInt(percentage) + "%";
		var f = document.getElementById('progressBarStatus');
		f.innerHTML = status;
	}

	function ExportFinished()
	{
		self.parent.location = 'index.php?ToDo=Exporter&complete=1&random='+new Date().getTime();
	}
</script>
<!-- iframe which does all of the work -->
<iframe src="index.php?ToDo=runExporter&random=%%GLOBAL_Random%%" width="1" height="1" frameborder="0" border="0"></iframe>