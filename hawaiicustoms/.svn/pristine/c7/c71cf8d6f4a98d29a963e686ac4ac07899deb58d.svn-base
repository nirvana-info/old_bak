<div style="padding: 0 15px 15px 15px;">
	<h2>%%LNG_NewsletterSubscribers%%</h2>
	<div id="exportIntro" style="display: %%GLOBAL_HideExportIntro%%">
		%%LNG_SubscribersListIntro%%
		<br /><br />
		<table border="0">
			<tr>
				<td width="1"><img src="images/subscriber.gif" height="16" width="16" hspace="5" alt="" /></td>
				<td><a href="#" onclick="StartSubscribersExport(); return false;"  style="color:#005FA3; font-weight:bold">%%LNG_GenerateSubscribersList%%</a></td>
			</tr>
		</table>
	</div>
	<div id="exportStatus" style="display: none;">
		%%LNG_SubscribersListGeneratingIntro%%
		<br /><br />
		<div style="border: 1px solid #ccc; width: 300px; padding: 0px; margin: 0 auto; position: relative;">
			<div id="subscriberProgressBarPercentage" style="margin: 0; padding: 0; background: url(images/progressbar.gif) no-repeat; height: 20px; width: 0%;">
				&nbsp;
			</div>
			<div style="position: absolute; top: 0; left: 0; text-align: center; width: 300px; font-weight: bold;" id="subscriberProgressPercent">&nbsp;</div>
		</div>
		<div id="subscriberProgressBarStatus" style="text-align: center; font-size: 11px; font-family: Tahoma;">%%LNG_GeneratingSubscribersList%%</div>
	</div>
	<div id="exportComplete" style="display: none;">
		%%LNG_SubscribersListGeneratedIntro%%
		<br />
		<br />
		<table border="0">
			<tr>
				<td width="1"><img src="images/save.gif" height="16" width="16" hspace="5" alt="" /></td>
				<td><a href="#" onclick="DownloadSubscribersList(); return false;"  style="color:#005FA3; font-weight:bold">%%LNG_DownloadSubscribersList%%</a></td>
			</tr>
		</table>
	</div>
	<div id="exportNoSubscribers" style="display: %%GLOBAL_HideNoSubscribers%%;">
	%%LNG_SubscribersListIntro%%
		<br /><br />
		<table border="0">
			<tr>
				<td width="1" valign="top"><img src="images/error.gif" height="16" width="16" hspace="5" alt="" /></td>
				<td style="font-weight: bold;">%%LNG_NoSubscribers%%</td>
			</tr>
		</table>
		<br />
	</div>
	<div style="float: right;">
		<input type="button" value="%%LNG_Close%%" onclick="CancelSubscribersExport()" class="FormButton" />
	</div>
</div>
<script type="text/javascript">
	function StartSubscribersExport() {
		$('#exportStatus').show();
		$('#exportIntro').hide();
		if(g('subscriberExportFrame')) {
			$('#subscriberExportFrame').remove();
		}
		$('#exportStatus').append('<iframe src="index.php?ToDo=exportSubscribers" border="0" frameborder="0" height="1" width="1" id="subscriberExportFrame"></iframe>');
	}

	function SubscribersExportError(msg) {
	//	tb_remove();
		alert(msg);
	}

	function UpdateSubscribersExportProgress(percentage) {
		$('#subscriberProgressBarPercentage').css('width', parseInt(percentage) + "%");
		$('#subscriberProgressPercent').html(parseInt(percentage) + "%");
	}

	function SubscribersExportComplete() {
		$('#exportStatus').hide();
		$('#exportComplete').show();
	}

	function CancelSubscribersExport() {
		if($('#exportStatus').css('display') != "none") {
			window.location = 'index.php?ToDo=cancelSubscribersExport';
		}
		else {
			tb_remove();
		}
	}

	function DownloadSubscribersList() {
		tb_remove();
		window.location = 'index.php?ToDo=downloadSubscribersExport';
	}
</script>
