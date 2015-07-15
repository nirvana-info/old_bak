
	<form enctype="multipart/form-data" action="index.php?ToDo=%%GLOBAL_FormAction%%" onsubmit="return ValidateForm(CheckNewsForm)" id="frmNews" method="post">
	<input type="hidden" name="newsId" value="%%GLOBAL_NewsId%%">
	<div class="BodyContainer">
	<table class="OuterPanel">
	  <tr>
		<td class="Heading1" id="tdHeading">%%GLOBAL_Title%%</td>
		</tr>
		<tr>
		<td class="Intro">
			<p>%%GLOBAL_Intro%%</p>
			%%GLOBAL_Message%%
			<p><input type="submit" name="SubmitButton1" value="%%LNG_Save%%" class="FormButton">&nbsp; <input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()"></p>
		</td>
	  </tr>
		<tr>
			<td>
			  <table class="Panel">
			  	<tr>
				  <td class="Heading2" colspan=2>%%LNG_NewNewsDetails%%</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span>&nbsp;%%LNG_NewsTitle%%:
					</td>
					<td>
						<input type="text" id="newstitle" name="newstitle" class="Field400" value="%%GLOBAL_NewsTitle%%">
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_Visible%%:
					</td>
					<td>
						<input type="checkbox" id="newsvisible" name="newsvisible" value="1" %%GLOBAL_NewsVisible%%> <label for="newsvisible">%%LNG_YesNewsVisible%%</label>
					</td>
				</tr>
				<tr>
					<td colspan="2" class="Gap"></td>
				</tr>
				<tr>
					<td colspan="2" class="Gap"></td>
				</tr>
				<tr>
				  <td class="Heading2" colspan=2>%%LNG_PostContent%%</td>
				</tr>
				<tr>
					<td colspan="2" style="padding-top:5px">
						%%GLOBAL_WYSIWYG%%
					</td>
				</tr>
				<tr>
					<td class="Gap" colspan="2"><input type="submit" name="SubmitButton1" value="%%LNG_Save%%" class="FormButton">&nbsp; <input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()">
					</td>
				</tr>
				<tr><td class="Gap"></td></tr>
				<tr><td class="Gap"></td></tr>
				<tr><td class="Sep" colspan="2"></td></tr>
			 </table>
			</td>
		</tr>
	</table>

	</div>
	</form>

	<script type="text/javascript">

		function ConfirmCancel()
		{
			if(confirm("%%LNG_ConfirmCancelNews%%"))
				document.location.href = "index.php?ToDo=viewNews";
		}

		function CheckNewsForm()
		{
			var title = g("newstitle");

			if(g("wysiwyg"))
				var wysiwyg = g("wysiwyg"); // Text area
			else
				var wysiwyg = g("wysiwyg_html"); // DevEdit

			if(IsWysiwygEditorEmpty(wysiwyg.value))
			{
				alert("%%LNG_EnterNewsContent%%");
				return false;
			}

			if(title.value == "")
			{
				alert("%%LNG_EnterNewsTitle%%");
				title.focus();
				return false;
			}

			// Everything is OK
			return true;
		}

	</script>
