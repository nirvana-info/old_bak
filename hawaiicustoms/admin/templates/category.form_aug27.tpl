
			<script type="text/javascript">

				function ConfirmCancel()
                {
                    var deptid = document.getElementById("catdeptid").value;
                    if(confirm('%%GLOBAL_CancelMessage%%'))
                    {
                        if(deptid != '') {
                            document.location.href='index.php?ToDo=viewCategories&deptid='+deptid;
                        }
                        else {
                            document.location.href='index.php?ToDo=viewCategories';
                        }
                    }
                    else
                    {
                        return false;
                    }
                }

				function CheckForm()
				{
					var catname = document.getElementById("catname");
					var cp = document.getElementById("catparentid");
					var cs = document.getElementById("catsort");
					var ci = document.getElementById("catimagefile");
                    var catid = document.getElementById("catdeptid1");

					if(catname.value == "") {
						alert("%%LNG_NoCategoryName%%");
						catname.focus();
						catname.select();
						return false;
					}

					if(cp.selectedIndex == -1) {
						alert("%%LNG_NoParentCategory%%");
						cp.focus();
						return false;
					}

					if(isNaN(cs.value) || cs.value == "") {
						alert("%%LNG_NoCatSortOrder%%");
						cs.focus();
						cs.select();
						return false;
					}
                    if(catid.selectedIndex == 0) {
                        alert("%%LNG_SelectaDepartment%%");
                        catid.focus();
                        return false;
                    }
					if(ci.value != "") {
						// Make sure it has a valid extension
						img = ci.value.split(".");
						ext = img[img.length-1].toLowerCase();

						if(ext != "jpg" && ext != "png" && ext != "gif") {
							alert("%%LNG_ChooseValidImage%%");
							ci.focus();
							ci.select();
							return false;
						}
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
	                		$('#tab1').css('display', '');
	                		var curHref = document.location.href;
	                		var reg = new RegExp(/^[\s\S]*#$/g);
	                		if(reg.test(curHref)){
	                			curHref = curHref.substr(0, curHref.length-1);
	                		}
							document.location.href = curHref + "#";
	                	}else{
	                		$('#tab1').css('display', 'none');
	                	}
	                });
	                
	                $("#tabnav > li a").click(function(){
	                	var T = this.id.replace("tab", "");
	                	setTab(T);
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
		                    if(confirm('%%GLOBAL_CancelMessage%%'))
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
						<li><a href="#" style="display:none" id="tab1">%%LNG_CustomContent%%</a></li>
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
								<span class="Required">*</span>&nbsp;%%LNG_CatName%%:
							</td>
							<td>
								<input type="text" name="catname" id="catname" class="Field750" value="%%GLOBAL_CategoryName%%">
								<input type="hidden" name="catuserid" id="catuserid" value="%%GLOBAL_catuserid%%">
				                                <input type="hidden" name="catvisible" id="catvisible" value="%%GLOBAL_catvisible%%">
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
							<span class="Required">*</span>&nbsp;%%LNG_CatPageContent%%:
						    </td>
						    <td>
						    <select name="catpagecontent" id="catpagecontent" class="Field100">
							    %%GLOBAL_ContentOptions%%
							</select>
							<img onmouseout="HideHelp('cd14');" onmouseover="ShowHelp('cd14', '%%LNG_CatPageContent%%', '%%LNG_CatPageContentHelp%%')" src="images/help.gif" width="24" height="16" border="0">
							<div style="display:none" id="cd14"></div>
						    </td>
						</tr> 
						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span>&nbsp;%%LNG_CatParentCategory%%:
							</td>
							<td>
<!--								<select size="5" name="catparentid" id="catparentid" class="Field750" style="height:115" onchange="HandleRootCategory();SelectDept();">-->
                                %%GLOBAL_CategorySelect%%
								%%GLOBAL_CategoryOptions%%
								</select>
								<img onmouseout="HideHelp('d1');" onmouseover="ShowHelp('d1', '%%LNG_CatParentCategory%%', '%%LNG_CatParentCategoryHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="d1"></div>
							</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								&nbsp;&nbsp;&nbsp;%%LNG_TemplateLayoutFile%%:
							</td>
							<td>
								<select name="catlayoutfile" id="catlayoutfile" class="Field750">
									%%GLOBAL_LayoutFiles%%
								</select>
								<img onmouseout="HideHelp('templatelayout');" onmouseover="ShowHelp('templatelayout', '%%LNG_TemplateLayoutFile%%', '%%LNG_CategoryTemplateLayoutFileHelp1%%%%GLOBAL_template%%%%LNG_CategoryTemplateLayoutFileHelp2%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="templatelayout"></div>
							</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span>&nbsp;%%LNG_CatSort%%:
							</td>
							<td>
								<input type="text" name="catsort" id="catsort" class="Field" size="5" value="%%GLOBAL_CategorySort%%">
								<img onmouseout="HideHelp('d2');" onmouseover="ShowHelp('d2', '%%LNG_CatSort%%', '%%LNG_CatSortHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="d2"></div>
							</td>
						</tr>
			                        <!-- Baskaran added starts--> 
						<tr>
						    <td class="FieldLabel">
							<span class="Required">*</span>&nbsp;%%LNG_CatDepartment%%:
						    </td>
						    <td>
						    <select name="catdeptid1" id="catdeptid1" class="Field100" %%GLOBAL_disabledept%% onchange="deptid();">
							    %%GLOBAL_CatDepartment%%
							</select>
                            <input type="hidden" id="catdeptid" name="catdeptid" value="%%GLOBAL_CatDeptid%%">
							<img onmouseout="HideHelp('d4');" onmouseover="ShowHelp('d4', '%%LNG_CatDepartment%%', '%%LNG_CatDepartmentHelp%%')" src="images/help.gif" width="24" height="16" border="0">
							<div style="display:none" id="d4"></div>
						    </td>
						</tr> 
<tr>
<td class="FieldLabel">
	&nbsp;&nbsp;%%LNG_StartPrice%%:
</td>
<td>
	$<input type="text" name="StartPrice" id="StartPrice" class="Field" size="5" value="%%GLOBAL_StartPrice%%">
	<img onmouseout="HideHelp('d10');" onmouseover="ShowHelp('d10', '%%LNG_StartPrice%%', '%%LNG_StartPriceHelp%%')" src="images/help.gif" width="24" height="16" border="0">
	<div style="display:none" id="d10"></div>
</td>
</tr>

<tr>
<td class="FieldLabel">
	&nbsp;&nbsp;%%LNG_EndPrice%%:
</td>
<td>
	$<input type="text" name="EndPrice" id="EndPrice" class="Field" size="5" value="%%GLOBAL_EndPrice%%">

	<img onmouseout="HideHelp('d11');" onmouseover="ShowHelp('d11', '%%LNG_EndPrice%%', '%%LNG_EndPriceHelp%%')" src="images/help.gif" width="24" height="16" border="0">
	<div style="display:none" id="d11"></div>
</td>
</tr>



                        <tr id="combinedtext" style="display: %%GLOBAL_ShowHidecatCombine%%">
                            <td class="FieldLabel">    
                                &nbsp;&nbsp;&nbsp;%%LNG_Combined%%:
                            </td>
                            <td>
                                <input type="text" class="Field" name="catcombine" id="catcombine" value="%%GLOBAL_catcombine%%">
                                <img onmouseout="HideHelp('d5');" onmouseover="ShowHelp('d5', '%%LNG_Combined%%', '%%LNG_CombinedHelp%%')" src="images/help.gif" width="24" height="16" border="0">
                                <div style="display:none" id="d5"></div>
                            </td>
                        </tr>
			<tr>
				<td class="FieldLabel">
					&nbsp;&nbsp;%%LNG_DisplayProducts%%:
				</td>
				<td align="left">
					<input type="checkbox" name="displayproducts" id="displayproducts" %%GLOBAL_DisplayProducts%% >&nbsp;%%LNG_DisplayProductsDes%%
					<img onmouseout="HideHelp('displayproducthelp');" onmouseover="ShowHelp('displayproducthelp', '%%LNG_DisplayProducts%%', '%%LNG_DisplayProductsDes%%')" src="images/help.gif" width="24" height="16" border="0">
					<div style="display:none" id="displayproducthelp"></div>
                            </td>
                        </tr>                       
						<!-- Baskaran added ends--> 

					</table>
					<table width="100%" class="Panel">
						<tr>
						  <td class="Heading2" colspan=2>%%LNG_CatImage%%</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								&nbsp;&nbsp;&nbsp;%%LNG_CatImage%%:
							</td>
							<td>
								<input type="file" id="catimagefile" name="catimagefile" class="Field"  />  <!--%%GLOBAL_DisableFileUpload%%-->
								<img onmouseout="HideHelp('d3');" onmouseover="ShowHelp('d3', '%%LNG_CatImage%%', '%%LNG_CatImageHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="d3"></div>
								<!--<span id="HideImageUploadMessage" style="display: %%GLOBAL_ShowFileUploadMessage%%;">%%LNG_CatHideImageUploadMessage%%</span>-->
								<span id="OptionImageUploadMessage">%%GLOBAL_CatImageMessage%%</span>
							</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								&nbsp;&nbsp;&nbsp;%%LNG_CatImageAlt%%:
							</td>
							<td>
								<input type = "text" name = "catimagealt" class ="Field250" value="%%GLOBAL_CatImageAlt%%">
								<img onmouseout="HideHelp('d6');" onmouseover="ShowHelp('d6', '%%LNG_CatImageAlt%%', '%%LNG_CatImageAltHelp%%')" src="images/help.gif" width="24" height="16" border="0">
				                                <div style="display:none" id="d6"></div>
							</td>
						</tr>
						<tr>
						  <td class="Heading2" colspan=2>%%LNG_CatHoverImage%%</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								&nbsp;&nbsp;&nbsp;%%LNG_CatHoverImage%%:
							</td>
							<td>
								<input type="file" id="cathoverimagefile" name="cathoverimagefile" class="Field"  />  <!--%%GLOBAL_DisableFileUpload%%-->
								<img onmouseout="HideHelp('d14');" onmouseover="ShowHelp('d14', '%%LNG_CatHoverImage%%', '%%LNG_CatImageHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="d14"></div>
								<!--<span id="HideImageUploadMessage" style="display: %%GLOBAL_ShowFileUploadMessage%%;">%%LNG_CatHideImageUploadMessage%%</span>-->
								<span id="OptionImageUploadMessage">%%GLOBAL_CatHoverImageMessage%%</span>
							</td>
						</tr>
					</table>
					<table width="100%" class="Panel">
						<tr>
						  <td class="Heading2" colspan=2>%%LNG_SearchEngineOptimization%%</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								&nbsp;&nbsp;&nbsp;%%LNG_PageTitle%%:
							</td>
							<td>
								<input type="text" id="catpagetitle" name="catpagetitle" class="Field750" value="%%GLOBAL_CategoryPageTitle%%" />
								<img onmouseout="HideHelp('pagetitlehelp');" onmouseover="ShowHelp('pagetitlehelp', '%%LNG_PageTitle%%', '%%LNG_CategoryPageTitleHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="pagetitlehelp"></div>
							</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								&nbsp;&nbsp;&nbsp;%%LNG_MetaKeywords%%:
							</td>
							<td>
								<input type="text" id="catmetakeywords" name="catmetakeywords" class="Field750" value="%%GLOBAL_CategoryMetaKeywords%%" />
								<img onmouseout="HideHelp('metataghelp');" onmouseover="ShowHelp('metataghelp', '%%LNG_MetaKeywords%%', '%%LNG_MetaKeywordsHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="metataghelp"></div>
							</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								&nbsp;&nbsp;&nbsp;%%LNG_MetaDescription%%:
							</td>
							<td>
								<input type="text" id="catmetadesc" name="catmetadesc" class="Field750" value="%%GLOBAL_CategoryMetaDesc%%" />
								<img onmouseout="HideHelp('metadeschelp');" onmouseover="ShowHelp('metadeschelp', '%%LNG_MetaDescription%%', '%%LNG_MetaDescriptionHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="metadeschelp"></div>
							</td>
						</tr>
						<!-- Baskaran added starts-->
						<tr>
						    <td class="FieldLabel">
							&nbsp;&nbsp;&nbsp;%%LNG_AltKeyword%%:
						    </td>
						    <td>
							<input type="text" id="cataltkeyword" name="cataltkeyword" class="Field750" value="%%GLOBAL_AltKeyword%%" />
							<img onmouseout="HideHelp('cataltkeywordhelp');" onmouseover="ShowHelp('cataltkeywordhelp', '%%LNG_AltKeyword%%', '%%LNG_AltkeywordHelp%%')" src="images/help.gif" width="24" height="16" border="0">
							<div style="display:none" id="cataltkeywordhelp"></div>
						    </td>
						</tr>                        
						<!-- Baskaran added ends-->
					  </table>
					  <!-- Added by Simha -->
                      <table width="100%" class="Panel">
                        <tr>
                          <td class="Heading2" colspan=2>%%LNG_AssociateQualifiers%%</td>
                        </tr>
                        <tr>
                            <td class="FieldLabel">
                                %%LNG_Qualifiers%%:
                            </td>
                            <td>
                                <select size="5" id="qualifiers" name="qualifiers[]" class="Field400 ISSelectReplacement" multiple="multiple" style="height: 140px;">
                                %%GLOBAL_QualifierOptions%%
                                </select>
                                <img onmouseout="HideHelp('q3');" onmouseover="ShowHelp('q3', '%%LNG_AssociateQualifiers%%', '%%LNG_AssociateQualifiersHelp%%')" src="images/help.gif" width="24" height="16" border="0">
                                <div style="display:none" id="q3"></div>
                            </td>
                        </tr>
                        
<tr>
<td class="Heading2" colspan=2>%%LNG_Productname%%</td>
</tr>                        
<tr>
<td class="FieldLabel">
%%LNG_SelectProductname%%:
</td>
<td>
<select size="5" id="Productname" name="Productname[]" class="Field400 ISSelectReplacement" multiple="multiple" style="height: 140px;">
%%GLOBAL_Productname%%
 </select>
<img onmouseout="HideHelp('q30');" onmouseover="ShowHelp('q30', '%%LNG_SelectProductname%%', '%%LNG_ProductnameHelp%%')" src="images/help.gif" width="24" height="16" border="0">
<div style="display:none" id="q30"></div>
</td>
</tr>
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
			<tr>
                        <td class="Heading2" colspan=2>%%LNG_OtherCatgDesc%%</td>
                        </tr>                        
                        <tr>
                            <td class="FieldLabel">
                                &nbsp;&nbsp;&nbsp;%%LNG_FeaturePoints%%:
                            </td>
                            <td>
                                %%GLOBAL_WYSIWYG2%%
                            </td>
                        </tr>
			<tr>
                            <td class="FieldLabel">
                                &nbsp;&nbsp;&nbsp;%%LNG_DivDesc%%:
                            </td>
                            <td>
                                %%GLOBAL_WYSIWYG3%%
                            </td>
                        </tr>
						<tr>
							<td class="FieldLabel">&nbsp;</td>
							<td>
								<input type="submit" value="%%LNG_SaveAndExit%%" class="FormButton" />
								<input type="submit" value="%%GLOBAL_SaveAndAddAnother%%" name="AddAnother" class="FormButton" style="width:130px" />
								<input type="button" name="CancelButton2" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()">
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