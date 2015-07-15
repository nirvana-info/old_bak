<script type="text/javascript">

var TextArray = Array(%%GLOBAL_TextArray%%);

function UpdateLogoImage(){

	$('body').css({'cursor': 'wait'});
	$('input').css({'cursor': 'wait'});
	var sendData = {'w': 'updatelogo', 'logo': $('#SelectedLogo').attr('value')};
	var i = 0;
	while(document.getElementById("ExtraText" + i) != null){
		sendData['ExtraText' + i] = document.getElementById("ExtraText" + i).value;
		i++;
	}

	jQuery.ajax({ url: 'remote.php', type: 'POST', dataType: 'xml',
		data: sendData,
		success: function(xml) {
			display_message('%%LNG_LogoOptionsSaved%% <a href="../" target="_blank">%%LNG_ViewSite%%</a>', 'success');
			$('#LogoImage').attr('src', "../%%GLOBAL_ImageDirectory%%/"+$('logoImage', xml).text()+"?"+get_random());
			$('#CurrentLogo').attr('src', "../%%GLOBAL_ImageDirectory%%/"+$('logoImage', xml).text()+"?"+get_random());
			$('#ImageTextReplacement').hide();
			$('#LogoImage').show();
			$('body').css({'cursor': 'auto'});
			$('input').css({'cursor': 'auto'});

		}
	});
}

function UpdateLogoOptionNone(){
	$('body').css({'cursor': 'wait'});
	$('input').css({'cursor': 'wait'});
	if($('#UseAlternateTitle').attr('checked') == true){
		var UseAlternateTitle = 'true';
	}else{
		var UseAlternateTitle = 'false';
	}

	var sendData = {'w': 'updatelogonone', 'AlternateTitle': $('#AlternateTitle').val(), 'UseAlternateTitle': UseAlternateTitle};

	jQuery.ajax({ url: 'remote.php', type: 'POST', dataType: 'xml',
		data: sendData,
		success: function(xml) {
			ToggleLogoFields('none');
			$('#CurrentLogo').attr('src', "images/nologo.gif");
			display_message('%%LNG_LogoOptionsSaved%% <a href="../" target="_blank">%%LNG_ViewSite%%</a>', 'success');
			$('body').css({'cursor': 'auto'});
			$('input').css({'cursor': 'auto'});
		}
	});
}
function ToggleLogoFields(option, initial){
	if (option == 'create' && !$('#LogoOptioncreate').attr('disabled')) {
		$('#LogoUpload').hide();
		$('#LogoText').hide();
		SelectLogo('[template]', $('#TemplateLogoFile').val(), $('#TemplateLogoFileNumFields').val()-1);
	} else if(option == 'upload') {
		$('#LogoImageOptions').hide();
		$('#LogoTextOptions').hide();
		$('#ButtonTable').hide();
		$('#LogoTextOptions').hide();
		$('#LogoUpload').show();
		$('#LogoText').hide();
	} else {
		$('#LogoImageOptions').hide();
		$('#LogoTextOptions').hide();
		$('#ButtonTable').hide();
		$('#LogoTextOptions').hide();
		$('#LogoUpload').hide();
		$('#LogoText').show();
	}
}


function SelectLogo(logoName, logoFileName, numTextFields){
	if("%%GLOBAL_HideLogoOptionsNoFont%%" == "none") {
		return;
	}
	$('#ButtonTable').css('display', '');
	$('#SelectedLogo').attr('value', logoName);
	$('#LogoTextOptionsDiv').show();
	var html = '';
	var thisText = '';
	var refreshImage = false;
	html = '<tr><td colspan="2" class="Heading2">Logo Designer</td></tr><tr><td class="FieldLabel">Selected Logo:</td><td style="padding: 5px;"><img id="PreviewLogoImage" src="../cache/logos/'+ logoFileName +'"></td></tr>';

	for(i=0;i<=numTextFields;i++) {
		if(typeof(TextArray[i]) == 'undefined'){
			thisText = 'Example' + (i+1);
		}
		else {
			thisText = TextArray[i];
			refreshImage = true;
		}
		html += '<tr><td class="FieldLabel">Text '+(i+1)+':</td><td align="left" valign="top"><input type="text" name="ExtraText'+i+'" id="ExtraText'+i+'" class="Field300" value="'+thisText+'"></td></tr>';
	}

	$('#LogoTextOptionsDiv').html('<table class="Panel" style="margin: 0; display: %%GLOBAL_HideLogoOptions%%" id="LogoTextOptions">'+html+'</table>');

	if(refreshImage){
		RefreshPreviewImage();
	}
}

function RefreshPreviewImage(){
	$('body').css({'cursor': 'wait'});
	$('input').css({'cursor': 'wait'});
	var sendData = {'w': 'previewlogo', 'logo': $('#SelectedLogo').attr('value')};
	var i = 0;
	while(document.getElementById("ExtraText" + i) != null){
		sendData['ExtraText' + i] = document.getElementById("ExtraText" + i).value;
		i++;
	}

	jQuery.ajax({ url: 'remote.php', type: 'POST', dataType: 'xml',
		data: sendData,
		success: function(xml) {
			$('#PreviewLogoImage').attr('src', "../cache/logos/"+$('logoImage', xml).text());
			$('body').css({'cursor': 'auto'});
			$('input').css({'cursor': 'auto'});
		}
	});
}

function CheckAlternateTitle(showBox){

	if(showBox){
		$('#AlternateTitle').attr('disabled', !showBox);
		$('#AlternateTextArea').show();
	}else{
		$('#AlternateTitle').attr('disabled', !showBox);
		$('#AlternateTextArea').hide();
	}
}

function ToggleLogoTypeFields(value) {
	$('#GenericLogoList').hide();
	$('#SelectALogo').hide();
}

$(document).ready(function() {
	ToggleLogoTypeFields('%%GLOBAL_LogoTypeSelected%%');
	ToggleLogoFields('%%GLOBAL_LogoImageSelected%%', true);
	$('#LogoOption%%GLOBAL_LogoImageSelected%%').attr('checked', 'checked');
	CheckAlternateTitle($('#UseAlternateTitle').attr('checked'));
});

</script>
<input type="hidden" id="TemplateLogoFile" value="%%GLOBAL_TemplateLogoFile%%" />
<input type="hidden" id="TemplateLogoFileNumFields" value="%%GLOBAL_TemplateLogoFileNumFields%%" />

					<div class="Intro" style="padding: 10px 0px 10px 10px;">%%LNG_LogoIntro%%</div>
			<table class="Panel">
				<tr>
					<td class="Heading2" colspan='2'>%%LNG_LogoSettings%%</td>
				</tr>
				<tr>
					<td align="left" class="FieldLabel PanelBottom" valign="top">%%LNG_IWantToLogo%%:</td>
					<td class="PanelBottom">
						<input type="radio" name="LogoOption" value="none" checked="" id="LogoOptionnone" onclick="ToggleLogoFields(this.value);" /> <label for="LogoOptionnone">%%LNG_LogoOptionText%%</label><br />
						<input type="radio" name="LogoOption" value="create" checked="" id="LogoOptioncreate" onclick="ToggleLogoFields(this.value);" %%GLOBAL_DisableTemplateOption%% /> <label for="LogoOptioncreate">%%LNG_LogoOptionGenerate%%</label><br />
						<input type="radio" name="LogoOption" value="upload" checked="" id="LogoOptionupload" onclick="ToggleLogoFields(this.value);" /> <label for="LogoOptionupload">%%LNG_LogoOptionUpload%%</label><br />
					</td>
				</tr>
			 </table>
			 <br/>
			 <table class="Panel" style="display: %%GLOBAL_HideLogoOptions%%" id="CurrentSiteLogo">
				<tr>
				  <td class="Heading2" colspan='2'>%%LNG_CurrentSiteLogo%%</td>
				</tr>
				<tr id="CurrentLogoRow" style="display: %%GLOBAL_HideCurrentLogo%%">
					<td class="FieldLabel PanelBottom" valign="top">
						%%LNG_CurrentSiteLogo%%:
					</td>
					<td align="left" valign="top" class="PanelBottom" style="padding-top: 10px;">
						<img src="%%GLOBAL_CurrentLogo%%" id="CurrentLogo">
					</td>
				</tr>
			</table><br/>

<input type="hidden" name="SelectedLogo" id="SelectedLogo" value="none" />

<div id="LogoTextOptionsDiv" style="display: %%GLOBAL_HideLogoOptionsNoFont%%">
	<table class="Panel" style="margin:0px; display: %%GLOBAL_HideLogoOptions%%" id="LogoTextOptions">
	</table>
</div>

<table class="Panel" style="margin:0px; display: none" id="ButtonTable">
					<tr>
					<td class="FieldLabel">&nbsp;</td>
					<td align="left" valign="top" class="PanelBottom">
					<input type="button" value="Refresh Preview Image" class="SmallButton" onclick="RefreshPreviewImage();" />
					<input type="button" value="Save Logo Image" class="SmallButton" onclick="UpdateLogoImage();" />
					</td>
				</tr>
			</table>


			<form method="post" action="index.php?ToDo=TemplateUploadLogo" enctype="multipart/form-data">
			<table class="Panel" style="margin:0px; display: %%GLOBAL_HideLogoUpload%%" id="LogoUpload">
				<tr>
					<td class="Heading2" colspan='2'>%%LNG_LogoUpload%%</td>
				</tr>
				<tr>
					<td class="FieldLabel PanelBottom">
						%%LNG_SelectLogoUpload%%:
					</td>
					<td class="PanelBottom">
						<input type="file" name="LogoFile" id="LogoFile" class="Field" value="" /> <input type="submit" value="Upload Logo Image" class="SmallButton" />
					</td>
				</tr>
			</table>
			</form>
			<table class="Panel" style="margin:0px; display: %%GLOBAL_HideLogoUpload%%" id="LogoText">
				<tr>
					<td class="Heading2" colspan='2'>%%LNG_LogoText%%</td>
				</tr>
				<tr>
					<td class="FieldLabel" valign="top">
						%%LNG_IWantToLogo%%:
					</td>
					<td>

						<input type="radio" name="UseAlternateTitle" value="no" id="UseWebsiteTitle" onclick="CheckAlternateTitle(false);" %%GLOBAL_AlternateNotChecked%%> <label for="UseWebsiteTitle">%%LNG_LogoUseTitle%%</label><br/>
						<input type="radio" name="UseAlternateTitle" value="yes" id="UseAlternateTitle" onclick="CheckAlternateTitle(true);" %%GLOBAL_AlternateChecked%%> <label for="UseAlternateTitle">%%LNG_LogoUseAlternate%%</label><br/>
						<div id="AlternateTextArea" style="display: none"><img src="images/nodejoin.gif" width="20" height="20" align="absmiddle"> <input type="text" name="AlternateTitle" id="AlternateTitle" class="Field250" value="%%GLOBAL_AlternateTitle%%"></div>

					</td>
				</tr>
				<tr>
					<td class="FieldLabel PanelBottom">
					</td>
					<td class="PanelBottom" style="padding-top: 10px;">
					<input type="button" value="%%LNG_Save%%" id="LogoUpdateButton" style="width: 80px;" class="SmallButton" onclick="UpdateLogoOptionNone();" />
					</td>
				</tr>
			</table>
			<br />


