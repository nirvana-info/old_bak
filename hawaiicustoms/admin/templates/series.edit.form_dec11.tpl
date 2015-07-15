<script type="text/javascript" src="script/select.js"></script>
<form enctype="multipart/form-data" action="index.php?ToDo=%%GLOBAL_FormAction%%" onSubmit="return ValidateForm(CheckForm)" name="frmAddBrand" method="post">
<input type="hidden" name="seriesId" value="%%GLOBAL_SeriesId%%">
<div class="BodyContainer">
	<table class="OuterPanel">
		<tr>
			<td class="Heading1">%%GLOBAL_SeriesTitle%%</td>
		</tr>
		<tr>
		<td class="Intro">
			<p>%%GLOBAL_SeriesIntro%%</p>
			%%GLOBAL_Message%%

		</td>
	</tr>

	<tr>
		<td>
			<div>
                <input type="submit" name="SubmitButton1" value="%%LNG_Saveandclose%%" class="FormButton">
                <input type="submit" name="SubmitButton2" value="%%LNG_SaveKeepedit%%" class="FormButton" style="width:135px" onclick="SaveandEdit()">
				<input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()"><br /><img src="images/blank.gif" width="1" height="10" />
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<table class="Panel">
            <input type="hidden" name="keepedit" value="" id="keepedit"> 
				<tr>
					<td class="Heading2" colspan=2>%%LNG_SeriesDetails%%</td>
				</tr>
                <tr>
                    <td class="FieldLabel">
                        <span class="Required">*</span>&nbsp;%%LNG_BrandName%%:
                    </td>
                    <td>
                        <select name="vendor" id="vendor" class="Field200" onchange="showSeries(this.value);" disabled="disabled">
                        %%GLOBAL_BrandName%%
                        </select>
                        <input type="hidden" name="hdnpage" id="hdnpage" value="1">
                        <img onmouseout="HideHelp('d1');" onmouseover="ShowHelp('d1', '%%LNG_BrandName%%', '%%LNG_BrandNameHelp%%')" src="images/help.gif" width="24" height="16" border="0">
                        <div style="display:none" id="d1"></div>
                    </td>
                </tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span>&nbsp;%%LNG_SeriesName%%:
					</td>
					<td>
						<input type="text" name="seriesName" id="seriesName" class="Field200" value="%%GLOBAL_SeriesName%%">
                        <img onmouseout="HideHelp('d2');" onmouseover="ShowHelp('d2', '%%LNG_SeriesName%%', '%%LNG_SeriesNameHelp%%')" src="images/help.gif" width="24" height="16" border="0">
                        <div style="display:none" id="d2"></div>
					</td>
				</tr>
				<tr>
                    <td class="FieldLabel">
                        &nbsp;&nbsp;&nbsp;%%LNG_SeiresImage%%:
                    </td>
                    <td>
                        <input type="file" id="seriesimagefile" name="seriesimagefile" class="Field" />
                        <img onmouseout="HideHelp('dimage');" onmouseover="ShowHelp('dimage', '%%LNG_SeiresImage%%', '%%LNG_SeriesImageHelp%%')" src="images/help.gif" width="24" height="16" border="0">
                        <div style="display:none" id="dimage"></div>%%GLOBAL_SeriesImageMessage%%
                    </td>
                </tr>
                <tr>
                    <td class="FieldLabel">
                        &nbsp;&nbsp;&nbsp;%%LNG_Content%%:
                    </td>
                    <td>
                        <textarea name="contents" id="contents" class="Field200" rows="5">%%GLOBAL_Contents%%</textarea>
                        <img onmouseout="HideHelp('d4');" onmouseover="ShowHelp('d4', '%%LNG_Content%%', '%%LNG_ContentHelp%%')" src="images/help.gif" width="24" height="16" border="0">
                        <div style="display:none" id="d4"></div>
                        </td>
                    </tr>
                    <tr>
                        <td  colspan="2">
                        <table cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td width="128px">
                                &nbsp;&nbsp;&nbsp;%%LNG_FeaturePoints%%:
                                </td>
                                <td>
                                &nbsp;&nbsp;&nbsp;%%LNG_Feature1%%:&nbsp;
                                </td>
                                <td>
                                    <input type="text" id="featurepoints1" name="featurepoints1" class="Field200" value="%%GLOBAL_FeaturePoints1%%">
                                    <img onmouseout="HideHelp('d5');" onmouseover="ShowHelp('d5', '%%LNG_FeaturePoints%%', '%%LNG_FeaturePointsHelp%%')" src="images/help.gif" width="24" height="16" border="0">
                                    <div style="display:none" id="d5"></div>
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>
                                &nbsp;&nbsp;&nbsp;%%LNG_Feature2%%:&nbsp;
                                </td>
                                <td>
                                    <input type="text" id="featurepoints2" name="featurepoints2" class="Field200" value="%%GLOBAL_FeaturePoints2%%">
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>
                                &nbsp;&nbsp;&nbsp;%%LNG_Feature3%%:&nbsp;
                                </td>
                                <td>
                                    <input type="text" id="featurepoints3" name="featurepoints3" class="Field200" value="%%GLOBAL_FeaturePoints3%%">
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>
                                &nbsp;&nbsp;&nbsp;%%LNG_Feature4%%:&nbsp;
                                </td>
                                <td>
                                    <input type="text" id="featurepoints4" name="featurepoints4" class="Field200" value="%%GLOBAL_FeaturePoints4%%">
                                </td>
                            </tr>
                        </table>
                        </td>
                    </tr> 
                    <tr>
                        <td class="FieldLabel">
                            &nbsp;&nbsp;&nbsp;%%LNG_Alternateseriesname%%:
                        </td>
                        <td>
                            <input type="text" id="seriesaltkeyword" name="seriesaltkeyword" class="Field200" value="%%GLOBAL_Seriesaltkeyword%%">
                            <img onmouseout="HideHelp('d6');" onmouseover="ShowHelp('d6', '%%LNG_Alternateseriesname%%', '%%LNG_FeaturePointsHelp%%')" src="images/help.gif" width="24" height="16" border="0">
                            <div style="display:none" id="d6"></div>

                        </td>
                    </tr>
			</table>
            <table width="100%" class="Panel">
                <tr>
                  <td class="Heading2" colspan=2>%%LNG_ProductDescription%%</td>
                </tr>
                <tr>
                    <td colspan="2">
                        %%GLOBAL_WYSIWYG%%
                    </td>
                </tr>
            </table>
		</td>
	</tr>
    <input type="hidden" name="hidvalue" id="hidvalue">
    <tr><td class="Gap" colspan="2"></td></tr> 
    <tr>
        <td>
            <input type="submit" name="SubmitButton1" value="%%LNG_Saveandclose%%" class="FormButton">
            <input type="submit" name="SubmitButton2" value="%%LNG_SaveKeepedit%%" class="FormButton" style="width:135px" onclick="SaveandEdit()">
            <input type="button" name="CancelButton2" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()">
        </td>
    </tr>   
</table>
</div>
</form>

<script type="text/javascript">

    function CheckForm() {
        var series = document.getElementById("seriesName");
        var simg = document.getElementById("seriesimagefile"); 
        var bid = document.getElementById("vendor");
        
        if(bid.selectedIndex == 0) {
            alert("%%LNG_SelectaBrand%%");
            bid.focus();
            return false;
        }   

        if(series.value == "") {
            alert("%%LNG_EnterSeries%%");
            series.focus();
            return false;
        }
        
        if(simg.value != "") {
            // Make sure it has a valid extension
            img = simg.value.split(".");
            ext = img[img.length-1].toLowerCase();

            if(ext != "jpeg" && ext != "jpg" && ext != "png" && ext != "gif") {
                alert("%%LNG_ChooseValidImage%%");
                simg.focus();
                simg.select();
                return false;
            }
        }
    }

    function ConfirmCancel()
    {
        if(confirm('%%GLOBAL_CancelMessage%%'))
            document.location.href='index.php?ToDo=viewBrands';
        else
            return false;
    }

    /*function SaveDescription() {
        document.getElementById('hidvalue').value = "1";
    } */
    
    function SaveandEdit()
    {
        document.getElementById('keepedit').value = 'keepedit';
    }
</script>