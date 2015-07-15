<script type="text/javascript">
function PurchaseTemplate(TemplateName){
		var w = screen.availWidth;
		var h = screen.availHeight;
		var l = (w/2) - 120;
		var t = (h/2) - 25;
		%%GLOBAL_TemplatePurchaseCode%%
}

function InsertLicense(){
	var key = document.getElementById('lKey').value;
	if(key == ''){
		alert('%%LNG_NoKeyEntered%%');
	}else{
		// do the ajax request
		jQuery.ajax({
			url: 'remote.php',
			data: 'w=checktemplatekey&template=%%GLOBAL_TemplateName%%&key='+$('#lKey').val(),
			dataType: 'xml',
			type: 'POST',
			success: InsertLicenseReturn
		});
	}
}

function InsertLicenseReturn(data){
	if(data.getElementsByTagName('status')[0].firstChild.nodeValue == 1){
		DownloadFile();
	}else{
		alert(data.getElementsByTagName('message')[0].firstChild.nodeValue);
	}
}

function DownloadFile(){
	// do the ajax request
	jQuery.ajax({
		url: 'remote.php',
		data: 'w=downloadtemplatefile&template=%%GLOBAL_TemplateName%%&key='+$('#lKey').val(),
		type: 'POST',
		dataType: 'xml',
		success: DownloadFileReturn
	});

	$("#TB_ajaxContent").animate({height: '58px'}, 100);
	document.getElementById('ContentDiv').innerHTML = '<center><fieldset>	<legend id="legendText">%%GLOBAL_DownloadPleaseWait%%</legend> <div id="contentDiv">		<img src="images/loadingAnimation.gif" > </div></fieldset></center>';
}

function DownloadFileReturn(data){
	if(data.getElementsByTagName('status')[0].firstChild.nodeValue == 1){
		$('#dl_' + data.getElementsByTagName('template')[0].firstChild.nodeValue).hide('normal');
	}else {

	}

	$("#ContentDiv").fadeOut("normal");
	$("#TB_ajaxContent").animate({height: '120px'}, 100);

	// message can be a success or error message
	document.getElementById('ContentDiv').innerHTML = '<fieldset>	<legend id="legendText">%%LNG_DownloadComplete%%</legend><div class="Text"style="text-align: center;">' + data.getElementsByTagName('message')[0].firstChild.nodeValue + '<br/><br/><input type="button" class="Button" value="OK" accesskey="O" onclick="tb_remove();document.location.href=\'index.php?ToDo=viewTemplates\';" style="width: 50px"></div></fieldset>';

	$("#ContentDiv").fadeIn("normal");
}
</script>
<div id="ContentDiv">
	<fieldset>
		<legend>%%LNG_WouldLikeToPurchase%%</legend>
		<div class="Text">%%GLOBAL_Message%%</div>
		<center><input type="button" onclick="javascript:PurchaseTemplate('%%GLOBAL_TemplateName%%');" value="%%LNG_PurchaseTemplate%% %%GLOBAL_TemplateAmount%%" class="SmallButton"></center>
	</fieldset>

	<br/>

	<fieldset>
		<legend>%%LNG_IAlreadyPurchased%%</legend>
		<div class="Text" >%%LNG_EnterLicense%%:</div>
		<input type="text" name="lKey" id="lKey" class="Field"  style="width: 135px"><input type="button" onclick="javascript:InsertLicense();" value="%%LNG_OkKey%%" class="SmallButton" style="width: 120px">
	</fieldset>
</div>