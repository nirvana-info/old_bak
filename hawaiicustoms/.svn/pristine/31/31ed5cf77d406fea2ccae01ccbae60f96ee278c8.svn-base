<form action="index.php?ToDo=%%GLOBAL_FormAction%%" id="frmProductGroup" onsubmit="return ValidateForm(CheckCabsizeForm)" method="post">
	<div class="BodyContainer">
	<table class="OuterPanel">
	  <tr>
		<td class="Heading1" id="tdHeading">%%LNG_AddCabsize%%</td>
		</tr>
		<tr>
		<td class="Intro">
			<p>%%LNG_ManageCabsizeIntro%%</p>
			%%GLOBAL_Message%%
			<p><input type="submit" name="SubmitButton1" value="%%LNG_Save%%" class="FormButton">&nbsp; <input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()"></p>
		</td>
	  </tr>
		<tr>
			<td>
			  <table class="Panel">
				<tr>
				  <td class="Heading2" colspan=2>%%LNG_CabsizeDetails%%</td>
				</tr>
                <tr>
                    <td class="FieldLabel">
                        <span class="Required">*</span>&nbsp;%%LNG_Prodstartyear%%:
                    </td>
                    <td>
                        <input type="text" id="prodstartyear" name="prodstartyear" class="Field100" value="">
                        <img onmouseout="HideHelp('d1');" onmouseover="ShowHelp('d1', '%%LNG_Prodstartyear%%', '%%LNG_ProdstartyearHelp%%')" src="images/help.gif" width="24" height="16" border="0">
                        <div style="display:none" id="d1"></div>
                    </td>
                </tr>
                <tr>
                    <td class="FieldLabel">
                        <span class="Required">*</span>&nbsp;%%LNG_Prodendyear%%:
                    </td>
                    <td>
                        <input type="text" id="prodendyear" name="prodendyear" class="Field100" value="">
                        <img onmouseout="HideHelp('d2');" onmouseover="ShowHelp('d2', '%%LNG_Prodendyear%%', '%%LNG_ProdendyearHelp%%')" src="images/help.gif" width="24" height="16" border="0">
                        <div style="display:none" id="d2"></div>
                    </td>
                </tr>
                <tr>
                    <td class="FieldLabel">
                        <span class="Required">*</span>&nbsp;%%LNG_Prodmake%%:
                    </td>
                    <td>
                        <input type="text" id="prodmake" name="prodmake" class="Field200" value="">
                        <img onmouseout="HideHelp('d3');" onmouseover="ShowHelp('d3', '%%LNG_Prodmake%%', '%%LNG_ProdmakeHelp%%')" src="images/help.gif" width="24" height="16" border="0">
                        <div style="display:none" id="d3"></div>
                    </td>
                </tr>
                <tr>
                    <td class="FieldLabel">
                        <span class="Required">*</span>&nbsp;%%LNG_Prodmodel%%:
                    </td>
                    <td>
                        <input type="text" id="prodmodel" name="prodmodel" class="Field200" value="">
                        <img onmouseout="HideHelp('d4');" onmouseover="ShowHelp('d4', '%%LNG_Prodmodel%%', '%%LNG_ProdmodelHelp%%')" src="images/help.gif" width="24" height="16" border="0">
                        <div style="display:none" id="d4"></div>
                    </td>
                </tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span>&nbsp;%%LNG_Irregularvalue%%:
					</td>
					<td>
						<input type="text" id="irregular" name="irregular" class="Field200" value="">
						<img onmouseout="HideHelp('d5');" onmouseover="ShowHelp('d5', '%%LNG_Irregularvalue%%', '%%LNG_IrregularHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="d5"></div>
					</td>
				</tr>
                <tr>
                    <td class="FieldLabel">
                        <span class="Required">*</span>&nbsp;%%LNG_Generalizevalue%%:
                    </td>
                    <td>
                        <input type="text" id="generalize" name="generalize" class="Field200" value="">
                        <img onmouseout="HideHelp('d6');" onmouseover="ShowHelp('d6', '%%LNG_Generalizevalue%%', '%%LNG_GeneralizeHelp%%')" src="images/help.gif" width="24" height="16" border="0">
                        <div style="display:none" id="d6"></div>
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
        if(confirm("%%LNG_ConfirmCancelCabsize%%"))
        document.location.href = "index.php?ToDo=viewCabsizeSettings";
    }
    
function CheckCabsizeForm() {   
    if($('#prodstartyear').val() == '') 
    {
        alert('%%LNG_ProdstartyearEnter%%');
        $('#prodstartyear').select();
        return false;
    }
    if($('#prodendyear').val() == '') 
    {
        alert('%%LNG_ProdendyearEnter%%');
        $('#prodendyear').select();
        return false;
    }
    if($('#prodmake').val() == '') 
    {
        alert('%%LNG_ProdmakeEnter%%');
        $('#prodmake').select();
        return false;
    }
    if($('#prodmodel').val() == '') 
    {
        alert('%%LNG_ProdmodelEnter%%');
        $('#prodmodel').select();
        return false;
    }
    if($('#irregular').val() == '') 
    {
        alert('%%LNG_IrregularcabEnter%%');
        $('#irregular').select();
        return false;
    }
    if($('#generalize').val() == '') 
    {
        alert('%%LNG_GeneralizecabEnter%%');
        $('#generalize').select();
        return false;
    }
 }    
</script>