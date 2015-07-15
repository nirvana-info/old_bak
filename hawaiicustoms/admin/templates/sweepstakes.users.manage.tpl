
	<div class="BodyContainer">
    <table id="Table13" cellSpacing="0" cellPadding="0" width="100%">  
        <tr>
            <td class="Heading1">%%LNG_SweepstakesUsers%%</td>
        </tr>
		<tr>
		<td class="Intro">
			<p>%%GLOBAL_SweepstakesUsersIntro%%</p>
			%%GLOBAL_Message%%<BR>
			<table id="IntroTable" cellspacing="0" cellpadding="0" width="100%">
			<tr>
			    <td class="Intro" valign="top" style="display: %%GLOBAL_DisplaySweepstakes%%">
				    <input type="button" name="IndexAddButton" value="%%LNG_AddSweepstakesUsers%%..." id="IndexCreateButton" class="SmallButton" onclick="document.location.href='index.php?ToDo=addViewerSweepstakes'" /> &nbsp;&nbsp;&nbsp;
                    <input type="button" value="%%LNG_GoToSweepstakes%%" class="SmallButton" onclick="document.location.href='index.php?ToDo=viewSweepstakes'">
                </td>
			</tr>
			</table>
		</td>
		</tr>
<td>
</td>
		<tr>
		<td style="display: %%GLOBAL_DisplayGrid%%">
			<div class="GridContainer">
				%%GLOBAL_SweepstakesUsersDataGrid%%
			</div>
		</td></tr>
	</table>
	</div>           
    <script>
function deleteSweepstakesUsersid(id) {
     if(confirm("%%LNG_ConfirmDeleteUsersSweepstakes%%")) {
        document.location.href = "index.php?ToDo=deleteViewSweepstakes&sid="+id;
    }
}
</script>