
	<div class="BodyContainer">
    <table id="Table13" cellSpacing="0" cellPadding="0" width="100%">  
        <tr>
            <td class="Heading1">%%LNG_CabsizeViewMMY%%</td>
        </tr>
		<tr>
		<td class="Intro">
			<p>%%GLOBAL_MMYIntro%%</p>
			%%GLOBAL_Message%%<BR>
			<table id="IntroTable" cellspacing="0" cellpadding="0" width="100%">
			<tr>
			    <td class="Intro" valign="top" style="display: %%GLOBAL_DisplayYMM%%">
				    <input type="button" name="IndexAddButton" value="%%LNG_AddMMY%%..." id="IndexCreateButton" class="SmallButton" onclick="document.location.href='index.php?ToDo=addMmy'" /> 
			    </td>
                <td style="display: %%GLOBAL_DisplayDownload%%">
                    %%GLOBAL_download%%
                    <a href="index.php?ToDo=dloadfilemmy">Click to Download the list of YMM Cab/Bed size</a>
                </td>
			</tr>
			<FORM METHOD=POST ACTION="index.php?ToDo=viewMMY&upload=yes" name ="f2" enctype="multipart/form-data">
            <tr>
                <td><a href="index.php?ToDo=viewEngineMMY">Go to %%LNG_EngineMMY%% Page</a></td> 
		<td>Upload new YMM data <img onmouseout="HideHelp('d1');" onmouseover="ShowHelp('d1', '%%LNG_ThumbnailImage2%%', '%%LNG_ThumbnailImageHelp1%%')" src="images/help.gif" width="24" height="16" border="0"
		><div style="display:none" id="d1"></div><INPUT TYPE="file" NAME="uploadymm">&nbsp;<INPUT TYPE="submit" value="Upload">
		
	  </td>
            </tr>
	     <!-- <tr>
                <td>Upload new YMM data <img onmouseout="HideHelp('d2');" onmouseover="ShowHelp('d2', '%%LNG_ThumbnailImage1%%', '%%LNG_ThumbnailImageHelp1%%')" src="images/help.gif" width="24" height="16" border="0"><div style="display:none" id="d2"></div><INPUT TYPE="file" NAME="uploadymm">&nbsp;</td>
		
		<td>Upload new Engine data &nbsp;<img onmouseout="HideHelp('d3');" onmouseover="ShowHelp('d3', '%%LNG_ThumbnailImage3%%', '%%LNG_ThumbnailImageHelp3%%')" src="images/help.gif" width="24" height="16" border="0"><div style="display:none" id="d3"></div>&nbsp;
		<INPUT TYPE="file" NAME="uploadengine"></td>
            </tr> -->
	    </FORM>

			</table>
		</td>
		</tr>
<td>
<FORM METHOD=POST ACTION="index.php?ToDo=viewMMY" name ="f1">
<TABLE>
			
<TR>
	<TD>%%GLOBAL_yearlist%%</TD>
	<TD>%%GLOBAL_makelist%%</TD>
	<TD>%%GLOBAL_modellist%%</TD>
	<TD>%%GLOBAL_submodellist%%</TD>
	<TD>%%GLOBAL_cabsizelist%%</TD>
	<TD>%%GLOBAL_bedsizellist%%</TD>
	<TD > <input type="submit" name="filter" value="Filter" /></TD>
	
</TR>
</TABLE>
</FORM>
</td>
		<tr>
		<td style="display: %%GLOBAL_DisplayGrid%%">
			<div class="GridContainer">
				%%GLOBAL_MMYDataGrid%%
			</div>
		</td></tr>
	</table>
	</div>           
    <script>
function deletemmyid(id,cab,bed) {


     if(confirm("%%LNG_ConfirmDeleteMMY%%")) {
        document.location.href = "index.php?ToDo=deleteMMY&Id="+id+"&cab="+cab+"&bed="+bed;
    }
}
</script>