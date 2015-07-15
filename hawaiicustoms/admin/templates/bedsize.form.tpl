<form action="index.php?ToDo=%%GLOBAL_FormAction%%" id="frmProduct" onsubmit="return ValidateForm(CheckBedsizeForm)" method="post">
	<div class="BodyContainer">
	<table class="OuterPanel">
	  <tr>
		<td class="Heading1" id="tdHeading">%%LNG_AddBedsize%%</td>
		</tr>
		<tr>
		<td class="Intro">
			<p>%%LNG_ManageBedsizeIntro%%</p>
			%%GLOBAL_Message%%
			<p><input type="submit" name="SubmitButton1" value="%%LNG_Save%%" class="FormButton">&nbsp; <input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()"></p>
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
						<input type="text" id="irregular" name="irregular" class="Field200" value="">
						<img onmouseout="HideHelp('d1');" onmouseover="ShowHelp('d1', '%%LNG_Irregularvalue%%', '%%LNG_IrregularHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="d1"></div>
					</td>
				</tr>
                <tr>
                    <td class="FieldLabel">
                        <span class="Required">*</span>&nbsp;%%LNG_Generalizevalue%%:
                    </td>
                    <td>
                        <input type="text" id="generalize" name="generalize" class="Field200" value="">
                        <img onmouseout="HideHelp('d2');" onmouseover="ShowHelp('d2', '%%LNG_Generalizevalue%%', '%%LNG_GeneralizeHelp%%')" src="images/help.gif" width="24" height="16" border="0">
                        <div style="display:none" id="d2"></div>
                    </td>
                </tr>
			 </table>
			</td>
		</tr>
	</table>
	<p><input type="submit" name="SubmitButton1" value="%%LNG_Save%%" class="FormButton">&nbsp; <input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()"></p>
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