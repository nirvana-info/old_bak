
	<form enctype="multipart/form-data" action="index.php?ToDo=%%GLOBAL_FormAction%%" onsubmit="return ValidateForm(CheckMessageForm)" id="frmMessage" method="post">
	<input type="hidden" name="orderId" value="%%GLOBAL_OrderId%%">
	<input type="hidden" name="messageId" value="%%GLOBAL_MessageId%%">
	<div class="BodyContainer">
	<table class="OuterPanel">
	  <tr>
		<td class="Heading1" id="tdHeading">%%GLOBAL_Title%%</td>
		</tr>
		<tr>
		<td class="Intro">
			<p>%%GLOBAL_Intro%%</p>
			%%GLOBAL_Message%%
			<p><input type="submit" name="SubmitButton1" value="%%GLOBAL_ButtonAction%%" class="FormButton">&nbsp; <input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()"></p>
		</td>
	  </tr>
		<tr>
			<td>
			  <table class="Panel">
				<tr>
				  <td class="Heading2" colspan=2>%%LNG_MessageDetails%%</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span>&nbsp;%%GLOBAL_MessageToFrom%%:
					</td>
					<td>
						<input type="text" id="customer" name="customer" class="Field400" value="%%GLOBAL_MessageTo%%" readonly disabled style="background-color:#EBEBE4; border:solid 1px #7F9DB9">
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span>&nbsp;%%LNG_MessageSubject%%:
					</td>
					<td>
						<input type="text" id="subject" name="subject" class="Field400" value="%%GLOBAL_MessageSubject%%">
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span>&nbsp;%%LNG_MessageContent%%:
					</td>
					<td>
						<textarea id="message" name="message" class="Field400" rows="7">%%GLOBAL_MessageContent%%</textarea>
					</td>
				</tr>
				<tr>
					<td class="Gap">&nbsp;</td>
					<td class="Gap"><input type="submit" name="SubmitButton1" value="%%GLOBAL_ButtonAction%%" class="FormButton">&nbsp; <input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()">
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

		function CheckMessageForm() {
			var subject = document.getElementById("subject");
			var message = document.getElementById("message");

			if(subject.value == "") {
				alert("%%LNG_EnterMessageSubject%%");
				subject.focus();
				return false;
			}

			if(message.value == "") {
				alert("%%LNG_EnterMessageContent%%");
				message.focus();
				return false;
			}

			return true;
		}

		function ConfirmCancel()
		{
			if(confirm("%%LNG_ConfirmCancelMessage%%"))
				document.location.href = "index.php?ToDo=viewOrderMessages&orderId=%%GLOBAL_OrderId%%";
		}

	</script>
