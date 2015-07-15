<style>input { font-size:12px; }</style>
<div id="ContentDiv" style="margin-top:5px">
	<div style="%%GLOBAL_HideAddonPurchaseForm%%">
		<fieldset>
			<legend>%%LNG_WouldLikeToPurchaseAddon%%</legend>
			<div class="Text">%%GLOBAL_AddonPurchaseText%%</div>
			<center><input type="button" onclick="window.open('%%GLOBAL_BuyLink%%')" value="%%LNG_PurchaseAddon%%" class="Button" style="margin-top:10px"></center>
		</fieldset>
		<br/>
		<fieldset>
			<legend>%%LNG_AlreadyPaidAddon%%</legend>
			<div class="Text" style="margin-bottom:10px">%%LNG_EnterAddonLicenseKey%%</div>
			<input type="text" name="key" id="key" class="Field" style="width: 120px">
			<input type="button" onclick="DownloadAddon();" value="%%LNG_DownloadAddon%%" class="Button" style="width: 120px">
		</fieldset>
	</div>
</div>

<script type="text/javascript">

	var addon_key = '';

	function DownloadAddon() {
		addon_key = $('#key').val();

		if(addon_key == '') {
			alert('%%LNG_AddonNoKey%%');
			$('#key').focus();
		}
		else {
			jQuery.ajax({
				url: 'remote.php',
				type: 'POST',
				dataType: 'text',
				data: {'w': 'validateAddonKey', 'key': addon_key},
				success: function(response) {
					if(response == '1') {
						ShowDownloadingAddon();
					}
					else {
						alert('%%LNG_AddonInvalidKey%%');
						$('#key').focus();
						$('#key').select();
					}
				}
			});
		}
	}

	function StreamAddon() {
		if('%%GLOBAL_ProductPrice%%' == 0) {
			var sendData = {'w': 'downloadAddonZip', 'prodId' : '%%GLOBAL_AddonId%%'};
		}
		else {
			var sendData = {'w': 'downloadAddonZip', 'key': 	addon_key};
		}

		jQuery.ajax({
			url: 'remote.php',
			type: 'POST',
			dataType: 'text',
			data: sendData,
			success: function(response) {

				tb_remove();

				if(response == 'success') {
					// The addon was downloaded and installed
					document.location.href = 'index.php?ToDo=viewDownloadAddons&newDownloaded=true';
				}
				else {
					// Something went wrong
					alert(response);
				}
			}
		});
	}

	function ShowDownloadingAddon()
	{
		prod_id = "%%GLOBAL_AddonId%%";
		$("#TB_window").animate({height: '90px'}, 100);
		document.getElementById('ContentDiv').innerHTML = '<center><fieldset><legend id="legendText">%%LNG_DownloadingAddonPleaseWait%%</legend><div id="contentDiv"><img src="images/loadingAnimation.gif"></div></fieldset></center>';
		StreamAddon();
	}

	if(1 == '%%GLOBAL_ForceAddonDownload%%') {
		ShowDownloadingAddon();
	}

</script>
