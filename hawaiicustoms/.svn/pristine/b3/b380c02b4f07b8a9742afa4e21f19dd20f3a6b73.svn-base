				  <table class="Panel">
					<tr>
					  <td class="Heading2" colspan=2>%%LNG_OsCommerceDetails%%</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							<span class="Required">*</span>&nbsp;%%LNG_OsCommerceLocation%%:
						</td>
						<td>
							<input type="text" name="osc_path" class="Field250" id="OsCommercePath" value="%%GLOBAL_Path%%">
							<img onmouseout="HideHelp('osc_path')" onmouseover="ShowHelp('osc_path', '%%GLOBAL_HelpTitle%%', '%%LNG_OsCommerceLocationHelp%%')" src="images/help.gif" width="24" height="16" border="0">
							<div style="display:none" id="osc_path"></div>
						</td>
					</tr>
				</table>
				<script type="text/javascript">
					function oscommerceCheckForm()
					{
						if($('#OsCommercePath').val() == ''  || $('#OsCommercePath').val() == 'http://') {
							alert('%%LNG_NoOsCommercePath%%');
							$('#OsCommercePath').focus();
							$('#OsCommercePath').select();
							return false;
						}
						return true;
					}
				</script>
