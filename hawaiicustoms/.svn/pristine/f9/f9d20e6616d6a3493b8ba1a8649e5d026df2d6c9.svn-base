
			<script type="text/javascript">

			function ConfirmCancel()
			{
			    if(confirm('%%LNG_CancelEditCategory%%'))
			    {
				    document.location.href='index.php?ToDo=viewABTesting';
				}
			}

			function CheckForm()
			{
				var pagetitle = document.getElementById("pagetitle");
                var cp = document.getElementById("catparentid");
				var pn = document.getElementById("pagename");

				if(pagetitle.value == "") {
					alert("%%LNG_EnterPageTitle%%");
					pagetitle.focus();
					return false;
				}
                
                if(pn.value == "") {
                    alert("%%LNG_EnterPageName%%");
                    pn.focus();
                    return false;
                }

				if(cp.selectedIndex == 0) {
					alert("%%LNG_NoParentCategory%%");
                    pagetitle.select();
					cp.focus();
					return false;
				}
				// Everything is OK, return true
				return true;
			}

			function HandleRootCategory()
			{
				if ($('#catparentid').val() == 0) {
					/*document.getElementById('catimagefile').disabled = true;
					$('#HideImageUploadMessage').show();
					$('#OptionImageUploadMessage').hide();*/
					document.getElementById('combinedtext').style.display = 'none';
				} else {
					/*document.getElementById('catimagefile').disabled = false;
					$('#HideImageUploadMessage').hide();
					$('#OptionImageUploadMessage').show();*/
					document.getElementById('combinedtext').style.display = '';  
				}
			}

			/* To select dept when category changes -- Baskaran */
			function SelectDept() {
				    if ($('#catparentid').val() == 0) {
					$('#catdeptid1').attr('selectedIndex',0);
					$('#catdeptid1').attr('disabled','');
					$('#catdeptid').val( $('#catdeptid1').val());
				    }
				    else {
					var id = $('#catparentid').val();
					var phpUrl = 'getdept.php';
					$.ajax(
					{
					    url: phpUrl,
					    type: 'GET', 
					    cache: false,
					    dataType: 'text',
					    data: { catid: id },
					    error: function(){
						//  alert('Error loading XML document');
					    },
					    success: function(html)
					    {
					     $('#catdeptid1').attr('selectedIndex',html);
					     $('#catdeptid1').attr('disabled','disable');
					     $('#catdeptid').val( $('#catdeptid1').val()); 
					    }
					}
					);
				    }
			}
                
			function deptid() {
			    $('#catdeptid').val( $('#catdeptid1').val());
			}
                
			//wirror_20100728: add tabs on this page
			var loadedDiv1 = false;
			$(function(){
				$("#catpagecontent").change(function(){
					if(this.value == 1)
					{
						//$('#tab1').css('display', '');
						var curHref = document.location.href;
						var reg = new RegExp(/^[\s\S]*#$/g);
						if(reg.test(curHref)){
							curHref = curHref.substr(0, curHref.length-1);
						}
						document.location.href = curHref + "#";
					}else{
						//$('#tab1').css('display', 'none');
					}
				});
	                
				$("#tabnav > li a").click(function(){
					var T = this.id.replace("tab", "");
					if( $('#pageId').val() == '' && T == 1){
						alert('The category need to be created first!');
					}else{
						setTab(T);
					}
				});
	                
				function setTab(T){
	                		var i = 0;
					while (document.getElementById("tab" + i) != null) {
						$('#div'+i).hide();
						$('.buttonGroup'+i).hide();
						$('#tab'+i).removeClass('active');
						 ++i;
					} 
						
					$('#div'+T).show();
					$('.buttonGroup'+T).show();
					$('#tab'+T).addClass('active');
					$('#currentTab').val(T); 
						
					if(T == 1 && !loadedDiv1){
						var iframeContent = "<iframe id=\"custompageFrm\" src=\"index.php?ToDo=%%GLOBAL_CustomPageAction%%\" width=\"100%\" height=\"840px\" frameborder=\"no\" border=\"0\" scrolling=\"no\"></iframe>";
						ShowLoadingIndicator();
						$('#div'+T).html(iframeContent);
						$('#custompageFrm').load(HideLoadingIndicator);
						loadedDiv1 = true;
					}
	                }
	                
	                $('.buttonGroup1 > input').click(function(){
	                	if(this.name == 'CancelButton1'){//$('.buttonGroup1 > input:last/:last-child')
	                		var iframePage = $('#custompageFrm').contents().find('#frmContents').length==0 ? 0 : 1;
					if(confirm('%%LNG_CancelEditCategory%%'))
					{
						if(iframePage != 0) {
						    setTab(0);
						}else{
						    $('#custompageFrm')[0].contentWindow.location.href = "index.php?ToDo=%%GLOBAL_CustomPageAction%%";
						}
					}
					else
					{
						return false;
					}
	                	}else{
	                		if(this.name == 'AddAnother'){
	                			$('#custompageFrm').contents().find('form').attr('action', $('#custompageFrm').contents().find('form').attr('action')+'&AddAnother=1');
	                		}
	                		
	                		$('#custompageFrm').contents().find("select").each(function(){
	                			if(this.id != 'productResults_old'){
	                				$('#custompageFrm').contents().find('#'+this.id.replace('box','name')).val($(this).find("option:selected").text());
	                			}
	                		});
	                		
	                		var itemTitle = $('#custompageFrm').contents().find('#itemTitle').val();
	                		var categorySel = $('#custompageFrm').contents().find('#categorybox').val();
	                		var urlSel = $('#custompageFrm').contents().find('#visitURL').val();
	                		if(categorySel != 0 && urlSel.length > 0 && itemTitle.length > 0){
	                			$(window.document).scrollTop(0);
	                			$('#custompageFrm').contents().find('form')[0].submit();
	                		}else{
	                			alert('%%LNG_CustomValidMessage%%');
	                		}
	                	}
	                });
	                
	                $('#tab'+$('#catpagecontent').val()).show();

                });
			</script>

			<form enctype="multipart/form-data" action="index.php?ToDo=%%GLOBAL_FormAction%%" onsubmit="return ValidateForm(CheckForm)" name="frmAddCategory" method="post">
			%%GLOBAL_hiddenFields%%
			<input type="hidden" name="currentTab" value="currentTab"/>
			<input type="hidden" name="pageId" id="pageId" value="%%GLOBAL_PageId%%"/>
			<input type="hidden" name="customContentId" id="customContentId" value="%%GLOBAL_customContentId%%"/>
			<div class="BodyContainer">
			<table class="OuterPanel">
			  <tr>
				<td class="Heading1">%%GLOBAL_CatTitle%%</td>
				</tr>
				<tr>
				<td class="Intro">
					<p>%%GLOBAL_CatIntro%%</p>
					%%GLOBAL_Message%%
				</td>
			  </tr>
			  <tr>
				<td>
					<div class="buttonGroup0">
						<input type="submit" value="%%LNG_SaveAndExit%%" class="FormButton" />
						<input type="submit" value="%%GLOBAL_SaveAndAddAnother%%" name="AddAnother" class="FormButton" style="width:130px" />						
						<input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()">
						<br /><img src="images/blank.gif" width="1" height="10" />
					</div>
					<div class="buttonGroup1" style="display:none">
						<input type="button" name="Add" value="%%LNG_SaveAndExit%%" class="FormButton" />
						<!--input type="button" name="AddAnother" value="%%GLOBAL_SaveAndAddAnother%%" class="FormButton" style="width:130px" /-->						
						<input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton">
						<br /><img src="images/blank.gif" width="1" height="10" />
					</div>
				</td>
			  </tr>
			  <tr>
				<td>
					<ul id="tabnav">
						<li><a href="#" class="active" id="tab0">%%LNG_CatDetails%%</a></li>
						<li><a href="#" id="tab1">%%LNG_CustomContent%%</a></li>
					</ul>
				</td>
			</tr>
			<tr>
				<td>
				<div id="div0">
					<table class="Panel">
						<tr>
						  <td class="Heading2" colspan=2>%%LNG_CatDetails%%</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span>&nbsp;%%LNG_PageTitle%%:
							</td>
							<td>
								<input type="text" id="pagetitle" name="pagetitle" class="Field400" value="%%GLOBAL_PageTitle%%">
								<img onmouseout="HideHelp('d1');" onmouseover="ShowHelp('d1', '%%LNG_PageTitle%%', '%%LNG_PageTitleHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="d1"></div><br />
							</td>
						</tr>
						<tr>
						    <td class="FieldLabel">
							<span class="Required">*</span>&nbsp;%%LNG_PageName%%:
						    </td>
						    <td>
							<input type="text" id="pagename" name="pagename" class="Field400" value="%%GLOBAL_PageName%%">
							<img onmouseout="HideHelp('d6');" onmouseover="ShowHelp('d6', '%%LNG_PageName%%', '%%LNG_PageNameHelp%%')" src="images/help.gif" width="24" height="16" border="0">
							<div style="display:none" id="d6"></div><br />
						    </td>
						</tr>
						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span>&nbsp;%%LNG_CatParentCategory%%:
							</td>
							<td>
								<!--<select size="5" name="catparentid" id="catparentid" class="Field750" style="height:115" onchange="HandleRootCategory();SelectDept();">-->
								%%GLOBAL_CategorySelect%%
								%%GLOBAL_CategoryOptions%%
								</select>
							</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								&nbsp;&nbsp;&nbsp;%%LNG_CatDesc%%:
							</td>
							<td>
								%%GLOBAL_WYSIWYG%%
							</td>
						</tr>
						<tr>
						    <td class="FieldLabel">
							&nbsp;&nbsp;&nbsp;%%LNG_CatPageContent%%:
						    </td>
						    <td>
						    <select name="catpagecontent" id="catpagecontent" class="Field100">
							    %%GLOBAL_ContentOptions%%
							</select>
							<img onmouseout="HideHelp('cd14');" onmouseover="ShowHelp('cd14', '%%LNG_CatPageContent%%', '%%LNG_CatPageContentHelp%%')" src="images/help.gif" width="24" height="16" border="0">
							<div style="display:none" id="cd14"></div>
						    </td>
						</tr> 	
					</table>
					<table width="100%" class="Panel">
						<tr>
						 <td class="Heading2" colspan=2>%%LNG_CategoryFooter%%</td>
						</tr>                        
						<tr>
						    <td class="FieldLabel">
							&nbsp;&nbsp;&nbsp;%%LNG_CatFooter%%:
						    </td>
						    <td>
							%%GLOBAL_WYSIWYG1%%
						    </td>
						</tr>
						<tr >
							<td class="Heading2" colspan=2>%%LNG_TrackingCode%%</td>
						</tr>
						<tr>
						    <td class="FieldLabel">
							&nbsp;&nbsp;&nbsp;%%LNG_ControlScript%%:
						    </td>
						    <td>
							<textarea rows="8" cols="75" name="controlscript" id="controlscript">%%GLOBAL_ControlScript%%</textarea>
						    </td>
						</tr>
						<tr>
						    <td class="FieldLabel">
							&nbsp;&nbsp;&nbsp;%%LNG_TrackingScript%%:
						    </td>
						    <td>
							<textarea  rows="8" cols="75" name="trackingscript" id="trackingscript">%%GLOBAL_TrackingScript%%</textarea>
						    </td>
						</tr>
						<tr><td class="Gap"></td></tr>
					</table>
				</div>
				<div id="div1" style="display:none">
				</div>
				</td>
				</tr>
			<tr>
			    <td>
					<div class="buttonGroup0">
						<img src="images/blank.gif" width="1" height="10" /><br />
						<input type="submit" value="%%LNG_SaveAndExit%%" class="FormButton" />
						<input type="submit" value="%%GLOBAL_SaveAndAddAnother%%" name="AddAnother" class="FormButton" style="width:130px" />						
						<input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()">
					</div>
					<div class="buttonGroup1" style="display:none">
						<img src="images/blank.gif" width="1" height="10" /><br />
						<input type="button" name="Add" value="%%LNG_SaveAndExit%%" class="FormButton" />
						<!--input type="button" name="AddAnother" value="%%GLOBAL_SaveAndAddAnother%%" class="FormButton" style="width:130px" /-->						
						<input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton"">
					</div>
				</td>
			</tr>
		</table>
	</div>
</form>