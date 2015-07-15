
<form action="index.php?ToDo=%%GLOBAL_FormAction%%" onSubmit="return ValidateForm(CheckForm);" name="frmAddBrand" method="post">
%%GLOBAL_hiddenFields%%
<div class="BodyContainer">
<table class="OuterPanel">
	  <tr>
		<td class="Heading1">%%GLOBAL_BrandTitle%%</td>
		</tr>
		<tr>
		<td class="Intro">
			<p>%%GLOBAL_BrandIntro%%</p>
			%%GLOBAL_Message%%
		</td>
	  </tr>

	  <tr>
		    <td>
				<div>
					<input type="submit" name="SubmitButton1" value="%%LNG_Save%%" class="FormButton">
					<input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()"><br /><img src="images/blank.gif" width="1" height="10" /></div>
			</td>
		  </tr>
			<tr>
				<td>
				  <table class="Panel">
					<tr>
					  <td class="Heading2" colspan=2>%%LNG_BrandDetails%%</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							<span class="Required">*</span>&nbsp;%%LNG_BrandNames%%:
						</td>
						<td>
							<textarea name="brands" id="brands" class="Field250" rows="5" value=""></textarea>
							<img onmouseout="HideHelp('d1');" onmouseover="ShowHelp('d1', '%%LNG_BrandNames%%', '%%LNG_BrandNamesHelp%%')" src="images/help.gif" width="24" height="16" border="0">
							<div style="display:none" id="d1"></div>

						</td>
					</tr>
                    <tr>
                        <td class="FieldLabel">
                            &nbsp;&nbsp;&nbsp;%%LNG_Altkeyword%%:
                        </td>
                        <td>
                            <input type="text" id="brandaltkeyword" name="brandaltkeyword" class="Field200" value="" />
                            <img onmouseout="HideHelp('d2');" onmouseover="ShowHelp('d2', '%%LNG_Altkeyword%%', '%%GLOBAL_1%%')" src="images/help.gif" width="24" height="16" border="0">
                            <div style="display:none" id="d2"></div>
                        </td>
                    </tr>
                    <tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_DisplayProducts%%:
					</td>
					<td align="left">
						<input type="checkbox" name="DisplayProducts" id="DisplayProducts" %%GLOBAL_DisplayProducts%% >&nbsp;%%LNG_DisplayProductsDes%%
						<img onmouseout="HideHelp('d15');" onmouseover="ShowHelp('d15', '%%LNG_DisplayProducts%%', '%%LNG_DisplayProductsDes%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="d15"></div>
					</td>
			</tr>
				</table>
			<table class="Panel">
				<tr>
					<td class="FieldLabel">&nbsp;</td>
					<td>
						<input type="submit" name="SubmitButton2" value="%%LNG_Save%%" class="FormButton">
						<input type="button" name="CancelButton2" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()">
					</td>
				</tr>
				<tr><td class="Gap"></td></tr>
		 </table>
		</td>
	</tr>
</table>
</div>
</form>

<script type="text/javascript">

	function CheckForm() {
		var brands = document.getElementById("brands");

		if(brands.value == "") {
			alert("%%LNG_EnterBrands%%");
			brands.focus();
			return false;
		}

		return true;
	}

	function ConfirmCancel()
	{
		if(confirm('%%GLOBAL_CancelMessage%%'))
			document.location.href='index.php?ToDo=viewBrands';
		else
			return false;
	}

</script>
