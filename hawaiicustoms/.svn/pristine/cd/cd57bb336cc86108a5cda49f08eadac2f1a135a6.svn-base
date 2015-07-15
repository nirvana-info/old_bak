				  <table class="Panel">
					<tr>
					  <td class="Heading2" colspan=2>%%LNG_CubeCartDetails%%</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							<span class="Required">*</span>&nbsp;%%LNG_CubeCartLocation%%:
						</td>
						<td>
							<input type="text" name="cubecart4_path" class="Field250" id="CubeCart4Path" value="%%GLOBAL_Path%%">
							<img onmouseout="HideHelp('cube4_path')" onmouseover="ShowHelp('cube4_path', '%%LNG_CubeCartLocation%%', '%%GLOBAL_HelpTitle%%')" src="images/help.gif" width="24" height="16" border="0">
							<div style="display:none" id="cube4_path"></div>
						</td>
					</tr>
				</table>
				<script type="text/javascript">
					function cubecart4CheckForm()
					{
						if($('#CubeCart4Path').val() == '' || $('#CubeCart4Path').val() == 'http://') {
							alert('%%LNG_NoCubeCartPath%%');
							$('#CubeCart4Path').focus();
							$('#CubeCart4Path').select();
							return false;
						}
						return true;
					}
				</script>
