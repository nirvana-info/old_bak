	<form action="index.php?ToDo=saveUpdatedKBSettings" name="frmKBSettings" id="frmKBSettings" method="post">
	<div class="BodyContainer">
	<table cellSpacing="0" cellPadding="0" width="100%" style="margin-left: 4px; margin-top: 8px;">
		<tr>
			<td class="Heading1">%%LNG_KBSettingsHeader%%</td>
		</tr>
		<tr>
			<td class="Intro">
				<div class="IntroItem">%%GLOBAL_KBSettingsIntro%%</div>
				%%GLOBAL_Message%%
			</td>
		</tr>
		<tr>
			<td>
				<input type="submit" value="%%LNG_Save%%" class="FormButton" />
				<input type="reset" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()" />
				<br /><br />
			</td>
		</tr>
		<tr>
			<td>
				<ul id="tabnav">
					<li><a href="#" class="active">%%LNG_KBSettings%%</a></li>
				</ul>
			</td>
		</tr>
		<tr>
			<td>
				<div id="div0" style="padding-top: 10px;">
					<table class="Panel">
						<tr>
						  <td class="Heading2" colspan=2>%%LNG_KBDetails%%</td>
						</tr>
						<tr>
							<td class="FieldLabel">&nbsp;</td>
							<td><img src="%%GLOBAL_KBLogo%%" alt="" /></td>
						</tr>
						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span>&nbsp;%%LNG_KBPath%%:
							</td>
							<td>
								<input type="text" name="KBPath" id="KBPath" class="Field200" value="%%GLOBAL_KBPath%%">
								<img onmouseout="HideHelp('d1');" onmouseover="ShowHelp('d1', '%%LNG_KBPath%%', '%%LNG_KBPathHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="d1"></div>
							</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span>&nbsp;%%LNG_KBContactFormIntegration%%:
							</td>
							<td>
								<input type="checkbox" name="KBContactFormIntegration" id="KBContactFormIntegration" value="ON" %%GLOBAL_IsARSIntegrated%%> <label for="KBContactFormIntegration">%%LNG_YesKBContactFormIntegration%%</label>
								<img onmouseout="HideHelp('d2');" onmouseover="ShowHelp('d2', '%%LNG_KBContactFormIntegration%%', '%%LNG_KBContactFormIntegrationHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="d2"></div>
								<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="LaunchHelp(712)">%%LNG_KBWhatIsActiveResponse%%</a>
							</td>
						</tr>
						<tr id="ARSFields" style="display:%%GLOBAL_HideARSFields%%">
							<td class="FieldLabel">
								&nbsp;
							</td>
							<td>
								<table border="0">
									<tr>
										<td valign="top">
											<img src="images/nodejoin.gif"/>&nbsp; %%LNG_IntegrateActiveResponseIntoThesePages%%:<br />
										</td>
									</tr>
									<tr>
										<td style="padding-left:28px">
											<select size="5" name="pageids[]" id="pageids" class="Field300 ISSelectReplacement" style="height:115" multiple>
												%%GLOBAL_CategoryOptions%%
											</select>
											<img onmouseout="HideHelp('d3');" onmouseover="ShowHelp('d3', '%%LNG_IntegrateActiveResponse%%', '%%LNG_IntegrateActiveResponseHelp%%')" src="images/help.gif" width="24" height="16" border="0">
											<div style="display:none" id="d3"></div>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</div>
				<table class="Panel">
					<tr>
						<td class="FieldLabel">&nbsp;</td>
						<td>
							<br /><input type="submit" name="SubmitButton2" value="%%LNG_Save%%" class="FormButton">
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

		function ConfirmCancel() {
			if(confirm('%%LNG_CancelKBMessage%%')) {
				document.location.href='index.php?ToDo=viewKBSettings';
			}
			else {
				return false;
			}
		}

		function NoContactPageMessage() {
			alert("%%LNG_NoContactPagesForActiveKB%%");
		}

		$('#KBContactFormIntegration').click(function() {
			if(this.checked && "%%GLOBAL_CanIntegrateARS%%" == "0") {
				alert("%%LNG_NoContactPagesForActiveKB%%");
				this.checked = false;
				$('#ARSFields').hide();
				return;
			}

			if(this.checked) {
				$('#ARSFields').show();
			}
			else {
				$('#ARSFields').hide();
			}
		});

		$('#frmKBSettings').submit(function() {
			if($('#KBPath').val().length <= 7) {
				alert('%%LNG_EnterActiveKBPath%%');
				$('#KBPath').focus();
				$('#KBPath').select();
				return false;
			}

			return true;

		});

		$(document).ready(function() {
			if(g('KBContactFormIntegration').checked) {
				$('#ARSFields').show();
			}
		});

	</script>
