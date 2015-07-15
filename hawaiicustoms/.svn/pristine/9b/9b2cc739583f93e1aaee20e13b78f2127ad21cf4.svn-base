<form enctype="multipart/form-data" action="index.php?ToDo=%%GLOBAL_FormAction%%" onSubmit="return ValidateForm(CheckForm)" name="frmAddQValueAssociation" method="post">    
<input type="hidden" name="qvalueassociationid" value="%%GLOBAL_QValueAssociationId%%">
<!--<input type="hidden" name="oldQValueAssociationName" value="%%GLOBAL_AssociationName%%">   -->
<div class="BodyContainer">
	<table class="OuterPanel">
		<tr>
			<td class="Heading1">%%GLOBAL_QValueAssociationTitle%%</td>
		</tr>
		<tr>
		<td class="Intro">
			<p>%%GLOBAL_QValueAssociationIntro%%</p>
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
					<td class="Heading2" colspan=2>%%LNG_QValueAssociationDetails%%</td>
				</tr>
                <tr>
                    <td class="FieldLabel">
                        &nbsp;&nbsp;&nbsp;%%LNG_CategoryName%%:
                    </td>
                    <td>
                        <!--<input type="text" id="categoryname" name="categoryname" readonly="readonly" class="Field400" value="%%GLOBAL_CategoryName%%" /> -->
                        <!--<select name="category" id="category" class="Field400" onchange="loadQualifiers(this.value);">
                                %%GLOBAL_CategoryOptions%%
                        </select> -->
                        <select size="1" name="category" id="category" class="Field400" style="height:115"  onchange="loadQualifiers(this.value);">
                        %%GLOBAL_CategoryOptions%%
                        </select>
                        <!--<img onmouseout="HideHelp('metataghelp');" onmouseover="ShowHelp('metataghelp', '%%LNG_MetaKeywords%%', '%%LNG_MetaKeywordsHelp%%')" src="images/help.gif" width="24" height="16" border="0">
                        <div style="display:none" id="metataghelp"></div>-->
                    </td>
                </tr>
                <tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_QualifierName%%:
					</td>
					<td>
                        <div id="qualifiers">                                                                        
                            %%GLOBAL_QualifierOptions%%   
                        <div>
						<!--<img onmouseout="HideHelp('metataghelp');" onmouseover="ShowHelp('metataghelp', '%%LNG_PageTitle%%', '%%LNG_QValueAssociationPageTitleHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="metataghelp"></div>-->
					</td>
				</tr>
                <tr>
                    <td class="FieldLabel">
                        &nbsp;&nbsp;&nbsp;%%LNG_QValueName%%:
                    </td>
                    <td>
                        <div id="qvalues">
                              %%GLOBAL_QValueOptions%%  
                        <div>
                        <!--<img onmouseout="HideHelp('metataghelp');" onmouseover="ShowHelp('metataghelp', '%%LNG_PageTitle%%', '%%LNG_QValueAssociationPageTitleHelp%%')" src="images/help.gif" width="24" height="16" border="0">
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
						<input type="text" id="associationcomments" name="associationcomments" class="Field400" value="%%GLOBAL_AssociationComments%%" />
						<!--<img onmouseout="HideHelp('metadeschelp');" onmouseover="ShowHelp('metadeschelp', '%%LNG_MetaDescription%%', '%%LNG_MetaDescriptionHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="metadeschelp"></div>-->
					</td>
				</tr>
			</table>

			<table class="Panel">
				<tr>
				  <td class="Heading2" colspan=2>%%LNG_QValueAssociationImage%%</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_QValueAssociationImage%%:
					</td>
					<td>
						<input type="file" id="associationimage" name="associationimage" class="Field" />
						<!--<img onmouseout="HideHelp('dimage');" onmouseover="ShowHelp('dimage', '%%LNG_QValueAssociationImage%%', '%%LNG_QValueAssociationImageHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="dimage"></div>-->
                        %%GLOBAL_QValueAssociationImageMessage%%
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
			alert("%%LNG_EnterQValueAssociation%%");
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
			document.location.href='index.php?ToDo=viewQValueAssociations';
		else
			return false;
	}
    
    function loadQualifiers(catid)   
    {
         //$('#qualifiers').load("qualifiers.php?catid="+catid);
         $('#qualifiers').load("index.php?ToDo=printQualifiersQValueAssociations&catid="+catid+"&ajax=1"); 
    }
    
    function loadQValues(qualifierid)   
    {
         var catid = document.getElementById('category').value;
         //$('#qvalues').load("qvalues.php?catid="+catid+'&qualifierid='+qualifierid);
         $('#qvalues').load("index.php?ToDo=printQValuesQValueAssociations&catid="+catid+'&qualifierid='+qualifierid+"&ajax=1");   
    }

</script>
