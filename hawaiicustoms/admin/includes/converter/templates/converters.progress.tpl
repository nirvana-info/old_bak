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
			<div style="text-align: center;"><input type="button" value="Cancel" class="SmallButton" onclick="Cancel()" /></div>
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

	function Cancel()
	{
		if(confirm('%%LNG_ConfirmCancelModule%%'))
		{
			self.parent.tb_remove();
			self.parent.location = 'index.php?ToDo=cancelConverterModule&random='+new Date().getTime();
		}
	}

	function ImportFinished()
	{
		self.parent.location = 'index.php?ToDo=converter&complete=1&random='+new Date().getTime();
	}
</script>
<!-- iframe which does all of the work -->
<iframe src="index.php?ToDo=runConverter&random=%%GLOBAL_Random%%" width="1" height="1" frameborder="0" border="0"></iframe>