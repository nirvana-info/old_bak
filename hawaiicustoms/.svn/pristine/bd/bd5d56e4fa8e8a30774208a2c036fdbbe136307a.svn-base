<div style="padding: 0 15px 15px 15px;">
	<h2>%%LNG_FroogleFeed%%</h2>
	<div id="exportIntro" style="display: %%GLOBAL_HideExportIntro%%">
		%%LNG_FroogleFeedIntro%%
		<br /><br />
		<table border="0">
			<tr>
				<td width="1"><img src="images/froogle.gif" height="16" width="16" hspace="5" alt="" /></td>
				<td><a href="#" onclick="StartFroogleExport(); return false;"  style="color:#005FA3; font-weight:bold">%%LNG_GenerateFroogleFeed%%</a></td>
			</tr>
		</table>
	</div>
	<div id="exportStatus" style="display: none;">
		%%LNG_FroogleFeedGeneratingIntro%%
		<br /><br />
		<div style="border: 1px solid #ccc; width: 300px; padding: 0px; margin: 0 auto; position: relative;">
			<div id="froogleProgressBarPercentage" style="margin: 0; padding: 0; background: url(images/progressbar.gif) no-repeat; height: 20px; width: 0%;">
				&nbsp;
			</div>
			<div style="position: absolute; top: 0; left: 0; text-align: center; width: 300px; font-weight: bold;" id="froogleProgressPercent">&nbsp;</div>
		</div>
		<div id="froogleProgressBarStatus" style="text-align: center; font-size: 11px; font-family: Tahoma;">%%LNG_GeneratingFroogleFeed%%</div>
	</div>
	<div id="exportComplete" style="display: none;">
		%%LNG_FroogleFeedGeneratedIntro%%
		<br />
		<br />
		<table border="0">
			<tr>
				<td width="1"><img src="images/save.gif" height="16" width="16" hspace="5" alt="" /></td>
				<td><a href="#" onclick="DownloadFroogleFeed(); return false;"  style="color:#005FA3; font-weight:bold">%%LNG_DownloadFroogleFeed%%</a></td>
			</tr>
		</table>
	</div>
	<div id="exportNoProducts" style="display: %%GLOBAL_HideNoProducts%%;">
	%%LNG_FroogleFeedIntro%%
		<br /><br />
		<table border="0">
			<tr>
				<td width="1" valign="top"><img src="images/error.gif" height="16" width="16" hspace="5" alt="" /></td>
				<td style="font-weight: bold;">%%LNG_NoFroogleProducts%%</td>
			</tr>
		</table>
		<br />
	</div>
	<div style="float: right;">
		<input type="button" value="%%LNG_Close%%" onclick="CancelFroogleExport()" class="text" />
	</div>
</div>
<script type="text/javascript">
	function StartFroogleExport() {
		$('#exportStatus').show();
		$('#exportIntro').hide();
		if(g('froogleExportFrame')) {
			$('#froogleExportFrame').remove();
		}
		$('#exportStatus').append('<iframe src="index.php?ToDo=exportFroogle" border="0" frameborder="0" height="1" width="1" id="froogleExportFrame"></iframe>');
	}

	function FroogleExportError(msg) {
	//	tb_remove();
		alert(msg);
	}

	function UpdateFroogleExportProgress(percentage) {
		$('#froogleProgressBarPercentage').css('width', parseInt(percentage) + "%");
		$('#froogleProgressPercent').html(parseInt(percentage) + "%");
	}

	function FroogleExportComplete() {
		$('#exportStatus').hide();
		$('#exportComplete').show();
	}

	function CancelFroogleExport() {
		if($('#exportStatus').css('display') != "none") {
			window.location = 'index.php?ToDo=cancelFroogleExport';
		}
		else {
			tb_remove();
		}
	}

	function DownloadFroogleFeed() {
		tb_remove();
		window.location = 'index.php?ToDo=downloadFroogleExport';
	}
</script>