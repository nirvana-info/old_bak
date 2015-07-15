
	<div class="BodyContainer">
    <table id="Table13" cellSpacing="0" cellPadding="0" width="100%">  
        <tr>
            <td class="Heading1">%%LNG_CabsizeViewMMY%%</td>
        </tr>
		<tr>
		<td class="Intro">
			<p>%%GLOBAL_MMYIntro%%</p>
			%%GLOBAL_Message%%
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
            <tr>
                <td><a href="index.php?ToDo=viewEngineMMY">%%LNG_EngineMMY%%</a></td>
            </tr>
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
function deletemmyid(id) {
     if(confirm("%%LNG_ConfirmDeleteMMY%%")) {
        document.location.href = "index.php?ToDo=deleteMMY&Id="+id;
    }
}
</script>