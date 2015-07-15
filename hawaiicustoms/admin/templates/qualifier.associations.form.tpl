<form action="index.php?ToDo=%%GLOBAL_FormAction%%" onSubmit="return ValidateForm(CheckForm);" name="frmAddQualifierAssociation" method="post">
%%GLOBAL_hiddenFields%%
<div class="BodyContainer">
<table class="OuterPanel">
	  <tr>
		<td class="Heading1">%%GLOBAL_QualifierAssociationTitle%%</td>
		</tr>
		<tr>
		<td class="Intro">
			<p>%%GLOBAL_QualifierAssociationIntro%%</p>
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
					  <td class="Heading2" colspan=2>%%LNG_QualifierAssociationDetails%%</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							<span class="Required">*</span>&nbsp;%%LNG_QualifierAssociationNames%%:
						</td>
						<td>
							<textarea name="brands" id="brands" class="Field250" rows="5" value=""></textarea>
							<img onmouseout="HideHelp('d1');" onmouseover="ShowHelp('d1', '%%LNG_QualifierAssociationNames%%', '%%LNG_QualifierAssociationNamesHelp%%')" src="images/help.gif" width="24" height="16" border="0">
							<div style="display:none" id="d1"></div>

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
			alert("%%LNG_EnterQualifierAssociations%%");
			brands.focus();
			return false;
		}

		return true;
	}

	function ConfirmCancel()
	{
		if(confirm('%%GLOBAL_CancelMessage%%'))
			document.location.href='index.php?ToDo=viewQualifierAssociations';
		else
			return false;
	}

</script>
