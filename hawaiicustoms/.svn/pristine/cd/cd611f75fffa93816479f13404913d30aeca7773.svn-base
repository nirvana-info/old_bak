<form enctype="multipart/form-data" action="index.php?ToDo=%%GLOBAL_FormAction%%" onSubmit="return ValidateForm(CheckForm)" name="frmAddBrand" method="post">
<input type="hidden" name="brandId" value="%%GLOBAL_BrandId%%">
<input type="hidden" name="oldBrandName" value="%%GLOBAL_BrandName%%">
<div class="BodyContainer">
	<table class="OuterPanel">
		<tr>
			<td class="Heading1">%%GLOBAL_BrandTitle%%</td>
		</tr>
		<tr>
		<td class="Intro">
			<p>%%GLOBAL_BrandIntro%%</p>
			%%GLOBAL_Message%%

		</td>
	</tr>

	<tr>
		<td>
			<div>
				<input type="submit" name="SubmitButton1" value="%%LNG_Save%%" class="FormButton">
				<input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()"><br /><img src="images/blank.gif" width="1" height="10" />
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<table class="Panel">
				<tr>
					<td class="Heading2" colspan=2>%%LNG_BrandDetails%%</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span>&nbsp;%%LNG_BrandName%%:
					</td>
					<td>
						<input type="text" name="brandName" id="brandName" class="Field250" value="%%GLOBAL_BrandName%%">
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_PageTitle%%:
					</td>
					<td>
						<input type="text" id="brandPageTitle" name="brandPageTitle" class="Field400" value="%%GLOBAL_BrandPageTitle%%" />
						<img onmouseout="HideHelp('metataghelp');" onmouseover="ShowHelp('metataghelp', '%%LNG_PageTitle%%', '%%LNG_BrandPageTitleHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="metataghelp"></div>
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_MetaKeywords%%:
					</td>
					<td>
						<input type="text" id="brandMetaKeywords" name="brandMetaKeywords" class="Field400" value="%%GLOBAL_BrandMetaKeywords%%" />
						<img onmouseout="HideHelp('metataghelp');" onmouseover="ShowHelp('metataghelp', '%%LNG_MetaKeywords%%', '%%LNG_MetaKeywordsHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="metataghelp"></div>
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_MetaDescription%%:
					</td>
					<td>
						<input type="text" id="brandMetaDesc" name="brandMetaDesc" class="Field400" value="%%GLOBAL_BrandMetaDesc%%" />
						<img onmouseout="HideHelp('metadeschelp');" onmouseover="ShowHelp('metadeschelp', '%%LNG_MetaDescription%%', '%%LNG_MetaDescriptionHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="metadeschelp"></div>
					</td>
				</tr>
                <tr>
                    <td class="FieldLabel">
                        &nbsp;&nbsp;&nbsp;%%LNG_Altkeyword%%:
                    </td>
                    <td>
                        <input type="text" id="brandaltkeyword" name="brandaltkeyword" class="Field200" value="%%GLOBAL_BrandAltkeyword%%" />
                        <img onmouseout="HideHelp('d2');" onmouseover="ShowHelp('d2', '%%LNG_Altkeyword%%', '%%GLOBAL_1%%')" src="images/help.gif" width="24" height="16" border="0">
                        <div style="display:none" id="d2"></div>
                    </td>
                </tr>
                <tr>
                    <td>
                        &nbsp;&nbsp;&nbsp;%%LNG_BrandDescription%%:
                    </td>
                    <td>    
                        %%GLOBAL_WYSIWYG1%%
                    </td>
                </tr>
			</table>

			<table class="Panel">
				<tr>
				  <td class="Heading2" colspan=2>%%LNG_BrandImage%%</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_BrandImage%%:
					</td>
					<td>
						<input type="file" id="brandimagefile" name="brandimagefile" class="Field" />
						<img onmouseout="HideHelp('dimage');" onmouseover="ShowHelp('dimage', '%%LNG_BrandImage%%', '%%LNG_BrandImageHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="dimage"></div>%%GLOBAL_BrandImageMessage%%
					</td>
				</tr>
			</table>

			<table class="Panel">


				<tr>


					<td class="FieldLabel">&nbsp;</td>


					<td>
						<input type="submit" name="SubmitButton2" value="%%LNG_Save%%" class="FormButton">
						<input type="button" name="CancelButton2" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()">
					</td>
				</tr>
				<tr><td class="Gap"></td></tr>
			</table>
		</td>
	</tr>
</table>
</div>
</form>

<script type="text/javascript">

	function CheckForm() {
		var brands = document.getElementById("brandName");
		var bimg = document.getElementById("brandimagefile");

		if(brands.value == "") {
			alert("%%LNG_EnterBrand%%");
			brands.focus();
			return false;
		}

		if(bimg.value != "") {
			// Make sure it has a valid extension
			img = bimg.value.split(".");
			ext = img[img.length-1].toLowerCase();

			if(ext != "jpg" && ext != "png" && ext != "gif") {
				alert("%%LNG_ChooseValidImage%%");
				bimg.focus();
				bimg.select();
				return false;
			}
		}

		return true;
	}

	function ConfirmCancel()
	{
		if(confirm('%%GLOBAL_CancelMessage%%'))
			document.location.href='index.php?ToDo=viewBrands';
		else
			return false;
	}

</script>
