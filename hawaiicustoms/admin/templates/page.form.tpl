
	<form enctype="multipart/form-data" action="index.php?ToDo=%%GLOBAL_FormAction%%" onSubmit="return ValidateForm(CheckPageForm);" id="frmNews" method="post">
	<input type="hidden" name="pageId" id="pageId" value="%%GLOBAL_PageId%%">
	<div class="BodyContainer">
	<table class="OuterPanel">
		<tr>
			<td class="Heading1" id="tdHeading">%%GLOBAL_Title%%</td>
		</tr>
		<tr>
			<td class="Intro">
				<p>%%LNG_PageIntro%%</p>
				%%GLOBAL_Message%%
			</td>
		</tr>
		<tr>
			<td style="padding-bottom:8px">
				<input type="submit" value="%%LNG_SaveAndExit%%" class="FormButton" />
				<input type="submit" name="addAnother2" value="%%GLOBAL_SaveAndAddAnother%%" class="FormButton" style="width:130px" />
				<input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel();" />
			</td>
		</tr>
		<tr>
			<td>
			  <table class="Panel">
				<tr>
				  <td class="Heading2" colspan=2>%%LNG_PageType1%%</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_PageType%%:
					</td>
					<td>
						<input onclick="SwitchType(0)" type="radio" id="pagetype_0" name="pagetype" value="0" %%GLOBAL_SelType0%%> <label for="pagetype_0">%%LNG_NormalPage%%</label><br />
						<input onclick="SwitchType(1)" type="radio" id="pagetype_1" name="pagetype" value="1" %%GLOBAL_SelType1%%> <label for="pagetype_1">%%LNG_ExternalLink%%</label><br />
						<input onclick="SwitchType(2)" type="radio" id="pagetype_2" name="pagetype" value="2" %%GLOBAL_SelType2%%> <label for="pagetype_2">%%LNG_RSSPage%%</label><br />
						<input onclick="SwitchType(3)" type="radio" id="pagetype_3" name="pagetype" value="3" %%GLOBAL_SelType3%%> <label for="pagetype_3">%%LNG_ContactPage%%</label>
					</td>
				</tr>
				<tr>
				  <td colspan="2" class="Gap"></td>
				</tr>
				<tr>
				  <td colspan="2" class="Gap"></td>
				</tr>
				<tr>
				  <td class="Heading2" colspan=2>%%LNG_NewPagesDetails%%</td>
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
                        &nbsp;%%LNG_PageName%%:
                    </td>
                    <td>
                        <input type="text" id="pagename" name="pagename" class="Field400" value="%%GLOBAL_PageName%%">
                        <img onmouseout="HideHelp('d6');" onmouseover="ShowHelp('d6', '%%LNG_PageName%%', '%%LNG_PageNameHelp%%')" src="images/help.gif" width="24" height="16" border="0">
                        <div style="display:none" id="d6"></div><br />
                    </td>
                </tr>
                
                
				<tr style="%%GLOBAL_HideVendorOption%%">
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_Vendor%%:
					</td>
					<td>
						<span style="%%GLOBAL_HideVendorLabel%%">%%GLOBAL_CurrentVendor%%</span>
						<select name="vendor" id="vendor" class="Field400" style="%%GLOBAL_HideVendorSelect%%" onchange="ToggleVendor($(this).val());">
							%%GLOBAL_VendorList%%
						</select>
						<img style="%%GLOBAL_HideVendorSelect%%" onmouseout="HideHelp('vendorhelp');" onmouseover="ShowHelp('vendorhelp', '%%LNG_Vendor%%', '%%LNG_PageVendorHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="vendorhelp"></div>
					</td>
				</tr>
				<tr class="HideIfNotPage PageContent">
					<td class="FieldLabel">
						<span class="Required">*</span>&nbsp;%%LNG_PageContent%%:
					</td>
					<td>
						%%GLOBAL_WYSIWYG%%
					</td>
				</tr>
				<tr class="HideIfPage">
					<td class="FieldLabel">
						<span class="Required">*</span>&nbsp;%%LNG_Link%%:
					</td>
					<td>
						<input type="text" id="pagelink" name="pagelink" class="Field400" value="%%GLOBAL_PageLink%%">
						<img onmouseout="HideHelp('d7');" onmouseover="ShowHelp('d7', '%%LNG_Link%%', '%%LNG_PageLinkHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="d7"></div><br />
					</td>
				</tr>
				<tr class="HideIfRSS">
					<td class="FieldLabel">
						<span class="Required">*</span>&nbsp;%%LNG_RSSFeed%%:
					</td>
					<td>
						<input type="text" id="pagefeed" name="pagefeed" class="Field400" value="%%GLOBAL_PageFeed%%">
						<img onmouseout="HideHelp('d8');" onmouseover="ShowHelp('d8', '%%LNG_RSSFeed%%', '%%LNG_RSSFeedHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="d8"></div><br />
					</td>
				</tr>
				<tr class="HideIfContact">
					<td class="FieldLabel">
						<span class="Required">*</span>&nbsp;%%LNG_EmailQuestionsTo%%:
					</td>
					<td>
						<input type="text" id="pageemail" name="pageemail" class="Field200" value="%%GLOBAL_PageEmail%%">
						<img onmouseout="HideHelp('d10');" onmouseover="ShowHelp('d10', '%%LNG_EmailQuestionsTo%%', '%%LNG_EmailQuestionsToHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="d10"></div><br />
					</td>
				</tr>
				<tr class="HideIfContact">
					<td class="FieldLabel">
						<span class="Required">*</span>&nbsp;%%LNG_ShowTheseFields%%:
					</td>
					<td>
						<input type="checkbox" id="contactfield1" name="contactfields[]" value="ON" checked="checked" disabled="disabled"> <label for="contactfield1">%%LNG_ContactEmail%%</label><br />
						<input type="checkbox" id="contactfield2" name="contactfields[]" value="ON" checked="checked" disabled="disabled"> <label for="contactfield2">%%LNG_ContactQuestion%%</label><br />
						<input type="checkbox" id="contactfield3" name="contactfields[fullname]" value="fullname" %%GLOBAL_IsContactFullName%%> <label for="contactfield3">%%LNG_ContactName%%</label><br />
						<input type="checkbox" id="contactfield4" name="contactfields[companyname]" value="companyname" %%GLOBAL_IsContactCompanyName%%> <label for="contactfield4">%%LNG_ContactCompanyName%%</label><br />
						<input type="checkbox" id="contactfield5" name="contactfields[phone]" value="phone" %%GLOBAL_IsContactPhone%%> <label for="contactfield5">%%LNG_ContactPhone%%</label><br />
						<input type="checkbox" id="contactfield6" name="contactfields[orderno]" value="orderno" %%GLOBAL_IsContactOrderNo%%> <label for="contactfield6">%%LNG_ContactOrderNo%%</label><br />
						<input type="checkbox" id="contactfield7" name="contactfields[rma]" value="rma" %%GLOBAL_IsContactRMA%%> <label for="contactfield7">%%LNG_ContactRMANo%%</label>
						<img onmouseout="HideHelp('d9');" onmouseover="ShowHelp('d9', '%%LNG_ShowTheseFields%%', '%%LNG_ShowTheseFieldsHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="d9"></div><br />
					</td>
				</tr>
				<tr>
				  <td colspan="2" class="Gap"></td>
				</tr>
				<tr>
				  <td colspan="2" class="Gap"></td>
				</tr>
				<tr>
				  <td class="Heading2" colspan=2>%%LNG_NavigationMenuOptions%%</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_NavigationMenu%%:
					</td>
					<td>
						<input type="checkbox" id="pagestatus" name="pagestatus" value="ON" %%GLOBAL_Visible%%> <label for="pagestatus">%%LNG_YesPageVisible%%</label>
						<img onmouseout="HideHelp('d6');" onmouseover="ShowHelp('d6', '%%LNG_NavigationMenu%%', '%%LNG_PageNavigationMenuHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="d6"></div><br />
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_ParentPage%%:
					</td>
					<td>
						<select id="pageparentid" name="pageparentid" class="Field400" size="5">
							<option SELECTED value='0'>-- %%LNG_NoParentPage%% --</option>
							%%GLOBAL_ParentPageOptions%%
						</select>
						<img onmouseout="HideHelp('d2');" onmouseover="ShowHelp('d2', '%%LNG_ParentPage%%', '%%LNG_ParentPageHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="d2"></div><br />
					</td>
				</tr>
				<tr>
				  <td colspan="2" class="Gap"></td>
				</tr>
				<tr>
				  <td colspan="2" class="Gap"></td>
				</tr>
				<tr>
				  <td class="Heading2" colspan=2>%%LNG_AdvancedPageOptions%%</td>
				</tr>
				<tr class="HideIfLink">
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_MetaKeywords%%:
					</td>
					<td>
						<input type="text" id="pagekeywords" name="pagekeywords" class="Field400" value="%%GLOBAL_PageKeywords%%">
						<img onmouseout="HideHelp('d3');" onmouseover="ShowHelp('d3', '%%LNG_MetaKeywords%%', '%%LNG_MetaKeywordsHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="d3"></div><br />
					</td>
				</tr>
				<tr class="HideIfLink">
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_MetaDescription%%:
					</td>
					<td>
						<input type="text" id="pagedesc" name="pagedesc" class="Field400" value="%%GLOBAL_PageDesc%%">
						<img onmouseout="HideHelp('d4');" onmouseover="ShowHelp('d4', '%%LNG_MetaDescription%%', '%%LNG_MetaDescriptionHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="d4"></div><br />
					</td>
				</tr>
				<tr class="HideIfLink PageContent">
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_TemplateLayoutFile%%:
					</td>
					<td>
						<select name="pagelayoutfile" id="pagelayoutfile" class="Field400">
							%%GLOBAL_LayoutFiles%%
						</select>
						<img onmouseout="HideHelp('templatelayout');" onmouseover="ShowHelp('templatelayout', '%%LNG_TemplateLayoutFile%%', '%%LNG_PageTemplateLayoutFileHelp1%%%%GLOBAL_template%%%%LNG_PageTemplateLayoutFileHelp2%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="templatelayout"></div>
					</td>
				</tr>
				<tr class="HideIfLink">
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_DisplayAsHomePage%%?
					</td>
					<td>
						<input type="checkbox" id="pageishomepage" name="pageishomepage" value="ON" %%GLOBAL_IsHomePage%%> <label for="pageishomepage">%%LNG_YesDisplayAsHomePage%%</label>
						<img onmouseout="HideHelp('d11');" onmouseover="ShowHelp('d11', '%%LNG_DisplayAsHomePage%%', '%%LNG_DisplayAsHomePageHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="d11"></div><br />
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_PageCustomersOnly%%?
					</td>
					<td>
						<input type="checkbox" id="pagecustomersonly" name="pagecustomersonly" value="1" %%GLOBAL_IsCustomersOnly%%> <label for="pagecustomersonly">%%LNG_YesRestrictToCustomersOnly%%</label>
						<img onmouseout="HideHelp('d14');" onmouseover="ShowHelp('d14', '%%LNG_PageCustomersOnly%%', '%%LNG_PageCustomersOnlyHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="d14"></div><br />
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_SortOrder%%:
					</td>
					<td>
						<input type="text" id="pagesort" name="pagesort" class="Field" size="5" value="%%GLOBAL_PageSort%%">
						<img onmouseout="HideHelp('d5');" onmouseover="ShowHelp('d5', '%%LNG_SortOrder%%', '%%LNG_SortOrderHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="d5"></div><br />
					</td>
				</tr>
                
                <tr >    <td class="Heading2" colspan=2>%%LNG_TrackingCode%%</td>
                        </tr>
                        <tr>
                            <td class="FieldLabel">
                                &nbsp;&nbsp;&nbsp;%%LNG_ControlScript%%:
                            </td>
                            <td>
                                <textarea rows="8" cols="75" name="controlscript" id="controlscript">%%GLOBAL_controlscript%%</textarea>
                            </td>
                        </tr>
                        <tr>
                            <td class="FieldLabel">
                                &nbsp;&nbsp;&nbsp;%%LNG_TrackingScript%%:
                            </td>
                            <td>
                                <textarea  rows="8" cols="75" name="trackingscript" id="trackingscript">%%GLOBAL_trackingscript%%</textarea>
                            </td>
                        </tr>
				<tr>
					<td class="Gap">&nbsp;</td>
					<td class="Gap">
						<input type="submit" value="%%LNG_SaveAndExit%%" class="FormButton" />
						<input type="submit" name="addAnother" value="%%GLOBAL_SaveAndAddAnother%%" class="FormButton" style="width:130px" />
						<input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()">
					</td>
				</tr>
				<tr><td class="Gap"></td></tr>
				<tr><td class="Gap"></td></tr>
				<tr><td class="Sep" colspan="2"></td></tr>
			 </table>
			</td>
		</tr>
	</table>

	</div>
	</form>

	<script type="text/javascript">
		parentOptions = new Array();
		function ConfirmCancel()
		{
			if(confirm("%%LNG_ConfirmCancelPage%%"))
				document.location.href = "index.php?ToDo=viewPages";
		}

		function ToggleVendor(vendorId)
		{
			if(typeof(parentOptions[vendorId]) != 'undefined') {
				$('#pageparentid').find('option:gt(0)').remove();
				$('#pageparentid').append(parentOptions[vendorId]);
				return;
			}
			$('#pageparentid').attr('disabled', true);
			$.ajax({
				url: 'remote.php?w=getPageParentOptions',
				data: {
					pageId: $('#pageId').val(),
					vendorId: vendorId,
					parentId: $('#pageparentid').val()
				},
				success: function(data) {
					parentOptions[vendorId] = data;
					$('#pageparentid').attr('disabled', false);
					$('#pageparentid').find('option:gt(0)').remove();
					$('#pageparentid').append(parentOptions[vendorId]);
				}
			});
		}

		function CheckPageForm()
		{
			var pt0 = g("pagetype_0");
			var pt1 = g("pagetype_1");
			var pt2 = g("pagetype_2");
			var pt3 = g("pagetype_3");
			var pagetitle = g("pagetitle");
			var pagelink = g("pagelink");
			var pagefeed = g("pagefeed");
			var pageemail = g("pageemail");

			if(pagetitle.value == "")
			{
				alert("%%LNG_EnterPageTitle%%");
				pagetitle.focus();
				return false;
			}

			if(pt1.checked)
			{
				if(pagelink.value == "" || pagelink.value == "http://")
				{
					alert("%%LNG_EnterPageLink%%");
					pagelink.focus();
					pagelink.select();
					return false;
				}
			}
			else if(pt2.checked)
			{
				if(pagefeed.value == "" || pagefeed.value == "http://")
				{
					alert("%%LNG_EnterPageFeed%%");
					pagefeed.focus();
					pagefeed.select();
					return false;
				}
			}
			else if(pt3.checked) {
				if(IsWysiwygEditorEmpty(content.value))
				{
					alert("%%LNG_EnterPageContent%%");
					return false;
				}

				if(pageemail.value && pageemail.value.indexOf("@") == -1 || pageemail.value.indexOf(".") == -1) {
					alert("%%LNG_EnterPageEmail%%");
					pageemail.focus();
					pageemail.select();
					return false;
				}
			}

			// Everything is OK
			return true;
		}

		function SwitchType(PageType)
		{
			if(PageType == 0) { // Content page
				$('.HideIfPage').hide();
				$('.HideIfNotPage').show();
				$('.HideIfLink').show();
				$('.HideIfNotLink').show();
				$('.HideIfRSS').hide();
				$('.HideIfContact').hide();
				$('#pagetype_0').attr('checked', 'true');
			}
			else if(PageType == 1) { // Link page
				$('.HideIfPage').show();
				$('.HideIfNotPage').hide();
				$('.HideIfLink').hide();
				$('.HideIfNotLink').hide();
				$('.HideIfRSS').hide();
				$('.HideIfContact').hide();
				$('#pagetype_1').attr('checked', 'true');
			}
			else if(PageType == 2) { // RSS page
				$('.HideIfPage').hide();
				$('.HideIfNotPage').hide();
				$('.HideIfLink').show();
				$('.HideIfNotLink').show();
				$('.HideIfRSS').show();
				$('.HideIfContact').hide();
				$('#pagetype_2').attr('checked', 'true');
			}
			else if(PageType == 3) { // Contact page
				$('.HideIfPage').hide();
				$('.HideIfNotPage').hide();
				$('.HideIfLink').show();
				$('.HideIfNotLink').show();
				$('.HideIfRSS').hide();
				$('.HideIfContact').show();
				$('.PageContent').show();
				$('#pagetype_3').attr('checked', 'true');
			}
		}

		$(document).ready(function() {
			%%GLOBAL_SetupType%%
		});

	</script>
