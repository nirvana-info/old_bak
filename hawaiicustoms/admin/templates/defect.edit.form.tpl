<form action="index.php?ToDo=%%GLOBAL_FormAction%%" name="frmDefect" method="post">
<input type="hidden" name="Id" value="%%GLOBAL_Id%%">
<div class="BodyContainer">
	<table class="OuterPanel">
		<tr>
			<td class="Heading1">%%GLOBAL_DefectTitle%%</td>
		</tr>
		<tr>
		<td class="Intro">
			<p>%%GLOBAL_DefectIntro%%</p>
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
					<td class="Heading2" colspan=2>%%LNG_DefectDetails%%</td>
				</tr>
                <tr>
                        <td class="FieldLabel">
                            &nbsp;&nbsp;&nbsp;%%LNG_UserName%%:
                        </td>
                        <td>
                            %%GLOBAL_Userid%%
                        </td>
                </tr>
                <tr>
                        <td class="FieldLabel">
                            &nbsp;&nbsp;&nbsp;%%LNG_Url%%:
                        </td>
                        <td>
                            %%GLOBAL_Url%%
                        </td>
                </tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_Description%%:
					</td>
					<td>
                        <label>%%GLOBAL_Description%%</label>
					</td>
				</tr>
                <tr>
                    <td class="FieldLabel">
                        &nbsp;&nbsp;&nbsp;%%LNG_Status%%:
                    </td>
                    <td>
                        <select name="status" id="status" class="Field150">
                            %%GLOBAL_Status%%
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="FieldLabel">
                        &nbsp;&nbsp;&nbsp;%%LNG_Comment%%:
                    </td>
                    <td>
                        <textarea name="comment" id="comment" rows="5" cols="40" class="Field350">%%GLOBAL_Comment%%</textarea>
                        <img onmouseout="HideHelp('d1');" onmouseover="ShowHelp('d1', '%%LNG_Comment%%', '%%GLOBAL_1%%')" src="images/help.gif" width="24" height="16" border="0">
                        <div style="display:none" id="d1"></div>
                    </td>
                </tr>
                <tr>
                    <td class="FieldLabel">
                        &nbsp;&nbsp;&nbsp;%%LNG_SubmitTime%%:
                    </td>
                    <td>
                        %%GLOBAL_SubmitTime%%
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

<script type="text/javascript">

    function ConfirmCancel()
    {
        if(confirm('%%GLOBAL_CancelMessage%%'))
            document.location.href='index.php?ToDo=manageDefect';
        else
            return false;
    }

</script>