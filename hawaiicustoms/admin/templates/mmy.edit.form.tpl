<form action="index.php?ToDo=%%GLOBAL_FormAction%%" onSubmit="return ValidateForm(CheckForm)" name="frmAddBrand" method="post">
<input type="hidden" name="Id" value="%%GLOBAL_Id%%">
<div class="BodyContainer">
	<table class="OuterPanel">
		<tr>
			<td class="Heading1">%%GLOBAL_MMYTitle%%</td>
		</tr>
		<tr>
		<td class="Intro">
			<p>%%GLOBAL_MMYIntro%%</p>
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
					<td class="Heading2" colspan=2>%%LNG_MMYDetails%%</td>
				</tr>
                <tr>
                        <td class="FieldLabel">
                            <span class="Required">*</span>&nbsp;%%LNG_Year%%:
                        </td>
                        <td>
                            <input type="text" name="year" id="year" class="Field200" value="%%GLOBAL_Year%%">
                            <img onmouseout="HideHelp('d1');" onmouseover="ShowHelp('d1', '%%LNG_Year%%', '%%GLOBAL_1%%')" src="images/help.gif" width="24" height="16" border="0">
                            <div style="display:none" id="d1"></div>
                        </td>
                </tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span>&nbsp;%%LNG_Make%%:
					</td>
					<td>
						<input type="text" name="make" id="make" class="Field200" value="%%GLOBAL_Make%%">
                            <img onmouseout="HideHelp('d2');" onmouseover="ShowHelp('d2', '%%LNG_Make%%', '%%GLOBAL_1%%')" src="images/help.gif" width="24" height="16" border="0">
                            <div style="display:none" id="d2"></div>
					</td>
				</tr>
                <tr>
                    <td class="FieldLabel">
                        <span class="Required">*</span>&nbsp;%%LNG_Model%%:
                    </td>
                    <td>
                        <input type="text" name="model" id="model" class="Field200" value="%%GLOBAL_Model%%">
                            <img onmouseout="HideHelp('d3');" onmouseover="ShowHelp('d3', '%%LNG_Model%%', '%%GLOBAL_1%%')" src="images/help.gif" width="24" height="16" border="0">
                            <div style="display:none" id="d3"></div>
                    </td>
                </tr>
                <tr>
                    <td class="FieldLabel">
                        &nbsp;&nbsp;&nbsp;%%LNG_SubModel%%:
                    </td>
                    <td>
                        <input type="text" name="submodel" id="submodel" class="Field200" value="%%GLOBAL_SubModel%%">
                        <img onmouseout="HideHelp('d4');" onmouseover="ShowHelp('d4', '%%LNG_SubModel%%', '%%GLOBAL_1%%')" src="images/help.gif" width="24" height="16" border="0">
                        <div style="display:none" id="d4"></div>
                    </td>
                </tr>
                <tr>
                    <td class="FieldLabel">
                        &nbsp;&nbsp;&nbsp;%%LNG_Cabsize%%:
                    </td>
                    <td>     
                        <input type="hidden" name="cid" id="cid" value="%%GLOBAL_Cid%%">
                        <input type="text" name="cabsize" id="cabsize" class="Field200" value="%%GLOBAL_Cabsize%%">
                        <img onmouseout="HideHelp('d5');" onmouseover="ShowHelp('d5', '%%LNG_Cabsize%%', '%%GLOBAL_1%%')" src="images/help.gif" width="24" height="16" border="0">
                        <div style="display:none" id="d5"></div>
                    </td>
                </tr>
                <tr>
                    <td class="FieldLabel">
                        &nbsp;&nbsp;&nbsp;%%LNG_Bedsize%%:
                    </td>
                    <td>
                        <input type="text" name="bedsize" id="bedsize" class="Field200" value="%%GLOBAL_Bedsize%%">
                        <img onmouseout="HideHelp('d6');" onmouseover="ShowHelp('d6', '%%LNG_Bedsize%%', '%%GLOBAL_1%%')" src="images/help.gif" width="24" height="16" border="0">
                        <div style="display:none" id="d6"></div>
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

    function CheckForm() {
        var year = document.getElementById("year");
        var make = document.getElementById("make");
        var model = document.getElementById("model");
        
        if(year.value == "") {
            alert("%%LNG_Enteryear%%");
            year.focus();
            return false;
        }
        if(isNaN(year.value)) {
            alert("%%LNG_Entervalidyear%%");
            year.focus();
            return false;
        }
        if(year.value < 1001) {
            alert("%%LNG_Entervalidyear%%");
            year.focus();
            return false;
        }
        if(make.value == "") {
            alert("%%LNG_Entermake%%");
            make.focus();
            return false;
        }
        if(model.value == "") {
            alert("%%LNG_Entermodel%%");
            model.focus();
            return false;
        }
    }

    function ConfirmCancel()
    {
        if(confirm('%%GLOBAL_CancelMessage%%'))
            document.location.href='index.php?ToDo=viewMMY';
        else
            return false;
    }

</script>