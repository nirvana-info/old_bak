<script type="text/javascript">
var disableLoadingIndicator;
var CurrentVersion = '%%GLOBAL_TemplateVersion%%';

function ShowTab(T){
	i = 0;
	if('%%GLOBAL_HideMessageBox%%' == 'none'){
		$('#TemplateMsgBox').hide('normal');
	}

	while(document.getElementById("tab" + i) != null){
		document.getElementById("div" + i).style.display = "none";
		document.getElementById("tab" + i).className = "";
		i++;
	}

	document.getElementById("div" + T).style.display = "";
	document.getElementById("tab" + T).className = "active";
	document.getElementById("currentTab").value = T;
	SetCookie('templatesCurrentTab', T, 365);
}

function ToggleDesignMode(){
	jQuery.ajax({
		url: 'remote.php',
		type: 'POST',
		dataType: 'xml',
		data: {'w': 'ToggleDesignMode', 'value': $('#enableDesignMode').attr('checked')},
		success: function(xml) {
			if($('status', xml).text() == 1) {
				if($('#enableDesignMode').attr('checked') == true){
					display_message('%%LNG_DesignModeChangedEnabled%%', 'message');
				}else{
					display_message('%%LNG_DesignModeChangedDisabled%%', 'message');
				}
			}else{
				display_message($(xml).getXMLTag('message'), 'error');
			}
		}
		});
}

function get_random()
{
    var ranNum= Math.floor(Math.random()*105205);
    return ranNum;
}

function ChangeTemplateColor(link, preview, previewFull) {
	$(link).parents('div.TemplateBox').find('.previewImage').attr('src', preview);
	$(link).parents('div.TemplateBox').find('.previewImage').parents('a').attr('href', previewFull);
}

function DownloadTemplate(id, height, width) {
	tb_show('', 'index.php?ToDo=templateDownload&template='+id+'&height='+height+'&width='+width);
}

function TemplatePurchase(TemplateName){
		var w = screen.availWidth;
		var h = screen.availHeight;
		var l = (w/2) - 120;
		var t = (h/2) - 25;

%%GLOBAL_TemplatePurchaseCode%%

}

function PreviewNewTemplate(TemplateURL)
{
	var w = screen.availWidth;
	var h = screen.availHeight;
	var l =  100;
	var t = 85;
	var height = screen.availHeight * 0.8;
	var width = screen.availWidth * 0.8;

	TemplateURL = '%%GLOBAL_TemplatesPreviewPath%%' + TemplateURL;

	var win = window.open("%%GLOBAL_TemplateWebsite%%/"+TemplateURL, "preview", "width="+width+",height="+height+",top="+t+",left="+l);
	win.focus();
}


function LaunchEditor(){
	var win = window.open("designmode.php?ToDo=editFile&File=default.html&f=a");
	win.focus();
}

function CheckTemplateVersion(){
	// do the ajax request
	document.getElementById('TemplateVersionCheck').innerHTML = '<em>Checking Version...</em>';
	jQuery.ajax({ url: 'remote.php', type: 'POST', dataType: 'xml',
		data: {'w': 'checktemplateversion'},
		success: function(xml) {
			CheckTemplateVersionReturn(xml);
		}
	});
}

function CheckTemplateVersionReturn(xml){
	var  CurrentVersion = '%%GLOBAL_TemplateVersion%%';

	if($('status', xml).text() == 1){
		if($('version', xml).text() > CurrentVersion){
			document.getElementById('TemplateVersionCheck').innerHTML = '<img src="images/success.gif" align="absmiddle"> %%LNG_NewVersionAvailable%%'.replace('%%VERSION%%', $('version', xml).text());

			if ($.browser.msie){
				$('#TemplateVersionCheck').css("background-color","#99FF66");
			} else {
				$('#TemplateVersionCheck').show(0);
				$('#TemplateVersionCheck').css("background-color","#99FF66");
				$('#TemplateVersionCheck').animate({ backgroundColor: '#F9F9F9' }, { queue: true, duration: 1000 });
			}

			document.getElementById('TemplateVersionCheckButton').style.display = "none";
			document.getElementById('DownloadNewVersionButton').style.display = "";
		}else{
			document.getElementById('TemplateVersionCheck').innerHTML = '%%LNG_CurrentTemplateLatest%%';
		}
	}else {
		display_error('An Error has Occurred: ' + $('message', xml).text());
	}
}

function DownloadNewVersion(){
	if(confirm('Important Note: By downloading this new template you will completely override your current template files which will *not* be recoverable. If you have made any modifcations to your current template then you should backup your current template before continuing.\n\nTo download this template, click \'OK\'. To keep the current version, click the \'Cancel\' button.')){
		if($.browser.msie){
			tb_show('', "index.php?ToDo=templatedownload&template=%%GLOBAL_CurrentTemplateName%%&height=80&width=280&PreviewImage=%%GLOBAL_CurrentTemplateImage%%");
		}else{
			tb_show('', "index.php?ToDo=templatedownload&template=%%GLOBAL_CurrentTemplateName%%&height=58&width=240&PreviewImage=%%GLOBAL_CurrentTemplateImage%%");
		}
		document.getElementById('TemplateVersionCheckButton').style.display = "";
		document.getElementById('DownloadNewVersionButton').style.display = "none";
	}
}

function CheckNewTemplates(){
	jQuery.ajax({ url: 'remote.php', type: 'POST', dataType: 'xml',
		data: {'w': 'checknewtemplates'},
		success: function(xml) {
			CheckNewTemplatesReturn(xml);
		}
	});
}

function display_message(text,type){
	if(type=='error'){
		display_error('TemplateMsgBox', text);
	} else {
		display_success('TemplateMsgBox', text);
	}
}

function CheckNewTemplatesReturn(xml){
	var message = $('message', xml).text();

	if($('status', xml).text() == 1){
		var templatelist = $('templatelist', xml).text();
		$('#TemplateGrid').html(templatelist);

		$('#DownloadTemplateIntro').fadeOut();
		$('#DownloadTemplateIntro').html(message);
		$('#DownloadTemplateIntro').fadeIn();

		$('#TemplateGrid').show(0);

		$('#DownloadButtonDiv').show(0);
		$('#DownloadButtonDiv').css("background-color","#99FF66");
		$('#DownloadButtonDiv').animate({ backgroundColor: '#FFFFFF' }, { queue: true, duration: 1000 });
		tb_remove();

	}else {
		tb_remove();
		document.getElementById('TemplateGrid').innerHTML = '<div id="noTemplatesMessage"><div class="Text">' + message + "</div></div>";
		tb_show('Download Templates', '#TB_inline?height=90&width=210&inlineId=noTemplatesMessage');
	}
}

</script>

	<div class="BodyContainer">
	<table class="OuterPanel">
		<tr>
			<td class="Heading1">%%LNG_ManageTemplates%%</td>
		</tr>
		<tr>
		<td class="Intro">
			<p>%%GLOBAL_LayoutIntro%%</p>
			<p id="TemplateMsgBox">%%GLOBAL_Message%%</p>
		</td>
		</tr>
		<tr>
		<td class="Intro"><br />
			<form action="index.php" method="get">
			<input type="hidden" name="ToDo" value="viewTemplates">
		<ul id="tabnav">
				<li><a href="javascript:ShowTab(0)" class="active" id="tab0">%%LNG_TemplateSettings%%</a></li>
				<li><a href="javascript:ShowTab(1)" id="tab1" style="display: %%GLOBAL_HideDownloadTab%%">%%LNG_DownloadTemplates%%</a></li>
				<li><a href="javascript:ShowTab(2)" id="tab2">%%LNG_LogoSettings%%</a></li>
				<li><a href="javascript:ShowTab(3)" id="tab3">%%LNG_DesignMode%%</a></li>
				<li><a href="javascript:ShowTab(4)" id="tab4">%%LNG_EmailTemplates%%</a></li>
		</ul>
			<input id="currentTab" name="currentTab" value="%%GLOBAL_ShowTab%%" type="hidden">
			</form>

		</td>
		</tr>
		<tr>
		<td>

		<div id="div0">
		<div class="Text">
			<div style="padding: 10px 0px 10px 10px">%%LNG_TemplateChoiceIntro%%</div>
		</div>
		<p class="MessageBox MessageBoxInfo" style="%%GLOBAL_HideSafeModeMessage%%; margin-top: 10px;">%%LNG_TemplateDownloadingSafeModeEnabled%%</p>

	 	<table class="Panel">
			<tr>
			  <td class="Heading2" colspan='2'>%%LNG_CurrentTemplate%%</td>
			</tr>
			<tr>
				<td align="left" width="200" style="padding:5px 5px 5px 10px;">
					<a href='%%GLOBAL_ShopPath%%/templates/%%GLOBAL_CurrentTemplateName%%/Previews/%%GLOBAL_CurrentTemplateImage%%' class="thickbox"><img src="thumb.php?tpl=%%GLOBAL_CurrentTemplateName%%&color=%%GLOBAL_CurrentTemplateImage%%" border="0" id="CurrentTemplateImage"></a>
				</td>
				<td align="left" valign="top"  style="padding:5px 5px 5px 10px;">
					<div class="TemplateHeading" id="CurrentTemplateHeading">%%GLOBAL_CurrentTemplateNameProper%% (%%GLOBAL_CurrentTemplateColor%%) - Version %%GLOBAL_TemplateVersion%%</div>
					<div id="TemplateFilesLocated">%%LNG_TemplateFilesLocated%%%%GLOBAL_CurrentTemplateName%%</div><br />

					<input type="button" value="%%LNG_BrowseTemplateFiles%%" class="SmallButton" class="Button" onclick="LaunchEditor();">	<input type="Button" class="SmallButton" onclick="CheckTemplateVersion();" value="%%LNG_CheckNewVersion%%"  id="TemplateVersionCheckButton"> <input type="Button" class="SmallButton" onclick="DownloadNewVersion();" value="%%LNG_DownloadNewVersion%%"  id="DownloadNewVersionButton" style="display:none; font-weight: bold;"> <input type="Button" class="SmallButton" onclick="window.open('%%GLOBAL_TemplatesOrderCustomURL%%')" value="%%LNG_OrderCustomTemplate%%" style="display:%%HideOrderCustomTemplate%%;"><br /><br />
					<div id="TemplateVersionCheck"></div>
				</td>
			</tr>
	 </table><br />

	<table class="Panel" style="margin:0px;">
		<tr>
		  <td class="Heading2" colspan='2'>%%LNG_ChooseTemplate%%</td>
		</tr>
		<tr>
			<td align="left" style=" padding-left: 10px;">
				%%LNG_TplPerPage%%:
				<select name="PerPage" class="Field" onchange="ChangePaging(this, 'viewTemplates', '%%GLOBAL_PageNumber%%');">
					<option value="10" %%GLOBAL_PerPage10Selected%%>10</option>
					<option value="20" %%GLOBAL_PerPage20Selected%%>20</option>
					<option value="50" %%GLOBAL_PerPage50Selected%%>50</option>
					<option value="100" %%GLOBAL_PerPage100Selected%%>100</option>
				</select>
			</td>

			<td align="right"  style=" padding-right: 10px;">
				%%GLOBAL_Nav%%
			</td>
		</tr>
 	</table>
	 <div style="text-align: center;clear:both;">
		%%GLOBAL_TemplateListMap%%
	</div>
	<table class="Panel" style="clear: both; margin:0px;">
		<tr>
			<td align="right"  style=" padding-right: 10px;">
				%%GLOBAL_Nav%%
			</td>
		</tr>
	</table>
</div>
<!-- divider -->
		<div id="div1" style="display:none">
			<p class="MessageBox MessageBoxInfo" style="%%GLOBAL_HideSafeModeMessage%%; margin-top: 10px;">%%LNG_TemplateDownloadingSafeModeEnabled%%</p>

<div class="Text" id="DownloadTemplateIntro" style="padding: 10px 0px 10px 10px">
	<div id="DownloadTemplateIntroMsg" style="display:%%GLOBAL_HideDownloadMessage%%"><a href="javascript:CheckNewTemplates()">%%LNG_ClickToDownload%%</a>. %%LNG_DownloadTemplateIntro%%</div>
	<div style="display:%%GLOBAL_HideNoZLib%%">%%GLOBAL_NoZLibMessage%%</div>
</div>


	 <div style="padding: 10px 0px 5px 10px; display: none;" class="Text" id="DownloadTemplateMessage"></div>
<form method=post action="" id="frmTemplates">
	 <div style="text-align: center; display: inline; clear:both;" id="TemplateGrid">
	%%GLOBAL_TemplateGrid%%
</div>
</form>
		</div>

		<div id="div2" style="display:none">
		<!-- Start Logo Editor Tab -->
			%%GLOBAL_LogoTab%%
		<!-- End Logo Editor Tab -->
		</div>
		<div id="div3" style="display:none">
			<div class="Text" style="padding: 10px 0px 10px 10px">
			%%LNG_DesignModeIntro%%
				<ul>
					<li>%%LNG_DesignModeIntro2%%</li>
					<li>%%LNG_DesignModeIntro3%%</li>
					<li>%%LNG_DesignModeIntro4%%</li>
					<!--<li><a href="#" class="thickbox">%%LNG_DesignModeIntro5%%</a></li>-->
				</ul>
			</div>
			 <table class="Panel" style="margin:0px;">
					<tr>
					  <td class="Heading2" colspan='2'>%%LNG_ToggleDesignMode%%</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp;&nbsp;%%LNG_EnableDesignMode%%
						</td>
						<td>
							<input type="checkbox" name="DesignMode" id="enableDesignMode" value="ON" %%GLOBAL_DesignModeChecked%%> <label for="enableDesignMode">%%LNG_YesEnableDesignMode%%</label>
						</td>
					</tr>
					<tr><td class="Gap"></td></tr>
			 </table>
			 <div style="padding-left: 192px; margin-top: 10px;"><input type="submit" name="SaveButton1" value="%%LNG_Save%%" class="FormButton" onclick="ToggleDesignMode(); return false;"></div>

		</div>
		<div id="div4" style="display:none">
			<div class="Text" style="padding: 10px 0px 10px 10px">
				%%LNG_EmailTemplatesIntro%%<br /><br />
				<table class="GridPanel SortableGrid AutoExpand" cellspacing="0" cellpadding="0" border="0" id="IndexGrid" style="width:100%;">
					<tr class="Heading3">
						<td>&nbsp;</td>
						<td>%%LNG_ETFileName%%</td>
						<td>%%LNG_ETFileSize%%</td>
						<td>%%LNG_ETLastUpdated%%</td>
						<td>%%LNG_Action%%</td>
					</tr>
					%%GLOBAL_EmailTemplatesGrid%%
				</table>
			</div>
		</div>
		</td></tr>
	</table>
	</div>
	<div style="display: none" id="templateSelectedMessage"></div>

	<script type="text/javascript" defer>

		var DisplayTab = 0;
		var ForceTab = '%%GLOBAL_ForceTab%%';

		if(ForceTab.length > 0){
			DisplayTab = ForceTab;
		}

		DisplayTab = parseInt(DisplayTab);

		if(DisplayTab > -1){
			ShowTab(DisplayTab);
		}

		function edit_template(trID, tplfile) {
			$('#edit_'+trID).show();
			
			// Load the contents of the file
			jQuery.ajax({
				url: 'remote.php',
				type: 'POST',
				dataType: 'text',
				data: {'w': 'getEmailTemplate', 'file': tplfile, 'id': trID},
				success: function(txt) {
					$('#edit_box_'+trID).html(txt);
					if(typeof(tinyMCE) != 'undefined') {
						eval('LoadEditor_wysiwyg_'+trID+'()');
					}
				}
			});
		}

		function edit_hide(trID) {
			if(confirm("%%LNG_ETHideEdit%%")) {
				$('#edit_'+trID).hide();
			}
		}

		function save_edit(trID, tplfile) {
			if(typeof(tinyMCE) != 'undefined') {
				var html = tinyMCE.get('wysiwyg_'+trID).getContent();
			}
			else {
				var html = eval("wysiwyg_"+trID).getHTMLContent();
			}

			// Save the contents of the file
			jQuery.ajax({
				url: 'remote.php',
				type: 'POST',
				dataType: 'text',
				data: {'w': 'updateEmailTemplate', 'file': tplfile, 'html': html},
				success: function(status) {
					if(status == "success") {
						msg = "%%LNG_EmailTemplateUpdated%%";
					}
					else {
						msg = "%%LNG_EmailTemplateUpdateFailed%%";
					}

					alert(msg);
				}
			});
		}

	</script>
	<div style="display: none;">
		%%GLOBAL_TemporaryEditor%%
	</div>