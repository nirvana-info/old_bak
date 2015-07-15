				  <table class="Panel">
					<tr>
					  <td class="Heading2" colspan=2>%%LNG_XCartDetails%%</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							<span class="Required">*</span>&nbsp;%%LNG_XCartLocation%%:
						</td>
						<td>
							<input type="text" name="xcart_path" class="Field250" id="XCartPath" value="%%GLOBAL_Path%%">
							<img onmouseout="HideHelp('xct_path')" onmouseover="ShowHelp('xct_path', '%%GLOBAL_HelpTitle%%', '%%LNG_XCartLocationHelp%%')" src="images/help.gif" width="24" height="16" border="0">
							<div style="display:none" id="xct_path"></div>
						</td>
					</tr>
				</table>
				<script type="text/javascript">
					function xcartCheckForm()
					{
						if($('#XCartPath').val() == '' || $('#XCartPath').val() == 'http://') {
							alert('%%LNG_NoXCartPath%%');
							$('#XCartPath').focus();
							$('#XCartPath').select();
							return false;
						}
						return true;
					}
				</script>
