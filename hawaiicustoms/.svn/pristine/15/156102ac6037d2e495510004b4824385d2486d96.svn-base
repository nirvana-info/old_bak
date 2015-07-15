<form enctype="multipart/form-data" action="index.php?ToDo=%%GLOBAL_FormAction%%" onSubmit="return ValidateForm(CheckForm)" name="frmAddQualifierAssociation" method="post">    
<input type="hidden" name="qualifierassociationid" value="%%GLOBAL_QualifierAssociationId%%">
<!--<input type="hidden" name="oldQualifierAssociationName" value="%%GLOBAL_AssociationName%%">   -->
<div class="BodyContainer">
	<table class="OuterPanel">
		<tr>
			<td class="Heading1">%%GLOBAL_QualifierAssociationTitle%%</td>
		</tr>
		<tr>
		<td class="Intro">
			<p>%%GLOBAL_QualifierAssociationIntro%%</p>
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
					<td class="Heading2" colspan=2>%%LNG_QualifierAssociationDetails%%</td>
				</tr>
                <tr>
                    <td class="FieldLabel">
                        &nbsp;&nbsp;&nbsp;%%LNG_CategoryName%%:
                    </td>
                    <td>
                        <input type="text" id="categoryname" name="categoryname" readonly="readonly" class="Field400" value="%%GLOBAL_CategoryName%%" />
                        <!--<img onmouseout="HideHelp('metataghelp');" onmouseover="ShowHelp('metataghelp', '%%LNG_MetaKeywords%%', '%%LNG_MetaKeywordsHelp%%')" src="images/help.gif" width="24" height="16" border="0">
                        <div style="display:none" id="metataghelp"></div>-->
                    </td>
                </tr>
                <tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_QualifierDisplayName%%:
					</td>
					<td>
						<input type="text" id="qualifierdisplayname" name="qualifierdisplayname" readonly="readonly" class="Field400" value="%%GLOBAL_QualifierDisplayName%%" />
						<!--<img onmouseout="HideHelp('metataghelp');" onmouseover="ShowHelp('metataghelp', '%%LNG_PageTitle%%', '%%LNG_QualifierAssociationPageTitleHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="metataghelp"></div>-->
					</td>
				</tr>
                <tr>
                    <td class="FieldLabel">
                        &nbsp;&nbsp;&nbsp;%%LNG_AssociationDisplayName%%:
                    </td>
                    <td>
                        <input type="text" name="associationdisplayname" id="associationdisplayname" class="Field400" value="%%GLOBAL_AssociationDisplayName%%">
                    </td>
                </tr>
                <tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_AssociationComments%%:
					</td>
					<td>
						<textarea id="associationcomments" name="associationcomments" style="width:392px;">%%GLOBAL_AssociationComments%%</textarea>
						<!--<img onmouseout="HideHelp('metadeschelp');" onmouseover="ShowHelp('metadeschelp', '%%LNG_MetaDescription%%', '%%LNG_MetaDescriptionHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="metadeschelp"></div>-->
					</td>
				</tr>
                <tr>
                    <td class="FieldLabel">  
                        &nbsp;&nbsp;&nbsp;%%LNG_QualifierVisible%%:
                    </td>
                    <td>   
                        <select id="qualifier_visible" name="qualifier_visible" class="Field75">
                            <option %%GLOBAL_TrueVisible%% value="1">Visible</option>
                            <option %%GLOBAL_FalseVisible%% value="2">Not Visible</option>
                        </select>
                    </td>
                </tr>
			</table>

			<table class="Panel">
				<tr>
				  <td class="Heading2" colspan=2>%%LNG_QualifierAssociationImage%%</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_QualifierAssociationImage%%:
					</td>
					<td>
						<input type="file" id="associationimage" name="associationimage" class="Field" />
						<!--<img onmouseout="HideHelp('dimage');" onmouseover="ShowHelp('dimage', '%%LNG_QualifierAssociationImage%%', '%%LNG_QualifierAssociationImageHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="dimage"></div>-->
                        %%GLOBAL_QualifierAssociationImageMessage%%
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
		//var brands = document.getElementById("brandName");
		var bimg = document.getElementById("associationimage");

		/*if(brands.value == "") {
			alert("%%LNG_EnterQualifierAssociation%%");
			brands.focus();
			return false;
		}   */

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
			document.location.href='index.php?ToDo=viewQualifierAssociations';
		else
			return false;
	}

</script>
