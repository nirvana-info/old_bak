<form action="index.php?ToDo=%%GLOBAL_FormAction%%" onSubmit="return ValidateForm(CheckBedsizeForm)" method="post">
<input type="hidden" name="bedId" value="%%GLOBAL_bedId%%">
<div class="BodyContainer">
	<table class="OuterPanel">
		<tr>
			<td class="Heading1">%%LNG_EditBedsize%%</td>
		</tr>
		<tr>
		<td class="Intro">
			<p>%%LNG_ManageBedsizeIntro%%</p>
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
					<td class="Heading2" colspan=2>%%LNG_BedsizeDetails%%</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span>&nbsp;%%LNG_Irregularvalue%%:
					</td>
					<td>
						<input type="text" name="irregular" id="irregular" class="Field200" value="%%GLOBAL_IrregularEdit%%" readonly="true">
                        <img onmouseout="HideHelp('d1');" onmouseover="ShowHelp('d1', '%%LNG_Irregularvalue%%', '%%LNG_IrregularHelp%%')" src="images/help.gif" width="24" height="16" border="0">
                        <div style="display:none" id="d1"></div>                        
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span>&nbsp;%%LNG_Generalizevalue%%: 
					</td>
					<td>
						<input type="text" id="generalize" name="generalize" class="Field200" value="%%GLOBAL_GeneralizeEdit%%" />
						<img onmouseout="HideHelp('d2');" onmouseover="ShowHelp('d2', '%%LNG_Generalizevalue%%', '%%LNG_GeneralizeHelp%%')" src="images/help.gif" width="24" height="16" border="0">
                        <div style="display:none" id="d2"></div>
					</td>
				</tr>
			</table>
        </td>
    </tr>
    <tr>
        <td>
            &nbsp;
        </td>
    </tr>
	<tr>
		<td>
            <div>
		    <input type="submit" name="SubmitButton2" value="%%LNG_Save%%" class="FormButton">
			<input type="button" name="CancelButton2" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()">
            </div>
		</td>
	</tr>
</table>
</div>
</form>

<script>
function ConfirmCancel() {  
        if(confirm("%%LNG_ConfirmCancelBedsize%%"))
        document.location.href = "index.php?ToDo=viewBedsizeSettings";
    }
    
function CheckBedsizeForm() {   
    if($('#irregular').val() == '') 
    {
        alert('%%LNG_IrregularEnter%%');
        $('#irregular').select();
        return false;
    }
    if($('#generalize').val() == '') 
    {
        alert('%%LNG_GeneralizeEnter%%');
        $('#generalize').select();
        return false;
    }
 }    
</script>
