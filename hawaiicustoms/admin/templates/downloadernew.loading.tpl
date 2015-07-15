<center><fieldset>
	<legend id="legendText">%%GLOBAL_DownloadPleaseWait%%</legend>
	<div id="contentDiv">
		<img src="images/loadingAnimation.gif" >
	</div>
</fieldset></center>
<script type="text/javascript">

	// <![CDATA[
	function HideDownloadThickBox()
	{
		tb_remove();
		document.location.href='index.php?ToDo=viewTemplates&forceCheck=1';
	}

	function DownloadFileReturn(data){
		if(data.getElementsByTagName('status')[0].firstChild.nodeValue == 1){
			$('#dl_' + data.getElementsByTagName('template')[0].firstChild.nodeValue).hide('normal');
		}
		$("#contentDiv").fadeOut("normal");
		$("#TB_ajaxContent").animate({height: '120px'}, 100);
		document.getElementById('contentDiv').innerHTML = '<div class="Text">' + data.getElementsByTagName('message')[0].firstChild.nodeValue + '<br/><br/><input type="button" class="Button" value="OK" accesskey="O" onclick="HideDownloadThickBox();" style="width: 50px"></div>';
		document.getElementById('legendText').innerHTML = '%%LNG_DownloadComplete%%';
		$("#contentDiv").fadeIn("normal");
	}

	function DownloadFile(){
		// do the ajax request
		jQuery.ajax({
			url: 'remote.php',
			data: 'w=downloadtemplatefile&template=%%GLOBAL_TemplateId%%',
			type: 'POST',
			dataType: 'xml',
			success: DownloadFileReturn
		});
	}

	window.setTimeout('DownloadFile()', 1000);
	//]]>

</script>
