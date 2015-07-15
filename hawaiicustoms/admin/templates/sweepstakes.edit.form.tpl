<form action="index.php?ToDo=%%GLOBAL_FormAction%%" onSubmit="return ValidateForm(CheckForm)" name="frmAddBrand" method="post" enctype="multipart/form-data">
<input type="hidden" name="sid" value="%%GLOBAL_sid%%">
<div class="BodyContainer">
	<table class="OuterPanel">
		<tr>
			<td class="Heading1">%%GLOBAL_SweepstakesTitle%%</td>
		</tr>
		<tr>
		<td class="Intro">
			<p>%%GLOBAL_SweepstakesIntro%%</p>
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
					<td class="Heading2" colspan=2>%%LNG_SweepstakesDetails%%</td>
				</tr>
                <tr>
                        <td class="FieldLabel">
                            <span class="Required">*</span>&nbsp;%%LNG_Name%%:
                        </td>
                        <td>
                            <input type="text" name="name" id="name" class="Field200" value="%%GLOBAL_Name%%">
                            <img onmouseout="HideHelp('d1');" onmouseover="ShowHelp('d1', '%%LNG_Name%%', '%%GLOBAL_1%%')" src="images/help.gif" width="24" height="16" border="0">
                            <div style="display:none" id="d1"></div>
                        </td>
                </tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_Title%%:
					</td>
					<td>
						<input type="text" name="title" id="title" class="Field200" value="%%GLOBAL_Title%%">
                            <img onmouseout="HideHelp('d2');" onmouseover="ShowHelp('d2', '%%LNG_Title%%', '%%GLOBAL_1%%')" src="images/help.gif" width="24" height="16" border="0">
                            <div style="display:none" id="d2"></div>
					</td>
				</tr>
                <tr>
                    <td class="FieldLabel">
                        &nbsp;&nbsp;&nbsp;%%LNG_BrowserTitle%%:
                    </td>
                    <td>
                        <input type="text" name="browsertitle" id="browsertitle" class="Field200" value="%%GLOBAL_BrowserTitle%%">
                            <img onmouseout="HideHelp('d10');" onmouseover="ShowHelp('d10', '%%LNG_BrowserTitle%%', '%%GLOBAL_1%%')" src="images/help.gif" width="24" height="16" border="0">
                            <div style="display:none" id="d10"></div>
                    </td>
                </tr>
                <tr>
                    <td class="FieldLabel">
                        &nbsp;&nbsp;&nbsp;%%LNG_Description%%:
                    </td>
                    <td>
                        %%GLOBAL_WYSIWYG%%
                    </td>
                </tr>
                <tr>
                    <td class="FieldLabel">
                        &nbsp;&nbsp;&nbsp;%%LNG_SuccessMessage%%:
                    </td>
                    <td>
                        %%GLOBAL_WYSIWYG1%%
                    </td>
                </tr>
                <tr>
                    <td class="FieldLabel">
                        &nbsp;&nbsp;&nbsp;%%LNG_StartDate%%:
                    </td>
                    <td>
                        <input class="plain" id="startdate" name="startdate" value="%%GLOBAL_StartDate%%" size="12" onfocus="this.blur()" readonly><a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fStartPop(document.getElementById('startdate'),document.getElementById('dc2'));return false;" HIDEFOCUS><img name="popcal" align="absmiddle" src="images/calbtn.gif" width="34" height="22" border="0" alt=""></a>
                            <img onmouseout="HideHelp('d3');" onmouseover="ShowHelp('d3', '%%LNG_StartDate%%', '%%GLOBAL_1%%')" src="images/help.gif" width="24" height="16" border="0">
                            <div style="display:none" id="d3"></div>
                    </td>
                </tr>
                <tr>
                    <td class="FieldLabel">
                        &nbsp;&nbsp;&nbsp;%%LNG_EndDate%%:
                    </td>
                    <td>
                        <input class="plain" id="enddate" name="enddate" value="%%GLOBAL_EndDate%%" size="12" onfocus="this.blur()" readonly><a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fStartPop(document.getElementById('enddate'),document.getElementById('dc2'));return false;" HIDEFOCUS><img name="popcal" align="absmiddle" src="images/calbtn.gif" width="34" height="22" border="0" alt=""></a>
                        <img onmouseout="HideHelp('d4');" onmouseover="ShowHelp('d4', '%%LNG_EndDate%%', '%%GLOBAL_1%%')" src="images/help.gif" width="24" height="16" border="0">
                        <div style="display:none" id="d4"></div>
                    </td>
                </tr>
                <tr>
                    <td class="FieldLabel">
                        &nbsp;&nbsp;&nbsp;%%LNG_Comments%%:
                    </td>
                    <td>
                        <textarea name="comments" id="comments" rows="5" cols="50">%%GLOBAL_Comments%%</textarea>
                            <img onmouseout="HideHelp('d7');" onmouseover="ShowHelp('d7', '%%LNG_Comments%%', '%%GLOBAL_1%%')" src="images/help.gif" width="24" height="16" border="0">
                            <div style="display:none" id="d7"></div>
                    </td>
                </tr>
			</table>
		</td>
	</tr>
    <tr><td class="Gap" colspan="2"></td></tr> 
    <tr>
        <td>
            <input type="submit" name="SubmitButton2" value="%%LNG_Save%%" class="FormButton">
            <input type="button" name="CancelButton2" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()">
        </td>
    </tr>   
</table>
</div>
</form>
<iframe width=132 height=142 name="gToday:contrast:agenda.js" id="gToday:contrast:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;"></iframe>
    <input type="text" id="dc2" name="dc2" style="display:none">

<script type="text/javascript">

    function CheckForm() {
        var name = document.getElementById("name");
        var sdate = document.getElementById("startdate");
        var edate = document.getElementById("enddate");

        if(name.value == "") {
            alert("%%LNG_Entername%%");
            name.focus();
            return false;
        }
        
        if(edate.value < sdate.value) {
            alert("Start date should be earlier to the end date");
            edate.focus();
            return false;
        }

    }

    function ConfirmCancel()
    {
        if(confirm('%%GLOBAL_CancelMessage%%'))
            document.location.href='index.php?ToDo=viewSweepstakes';
        else
            return false;
    }

</script>