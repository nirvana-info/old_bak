  <table class="Panel">
	<tr>
	  <td class="Heading2" colspan=2>%%LNG_ZenCartDetails%%</td>
	</tr>
	<tr>
		<td class="FieldLabel">
			<span class="Required">*</span>&nbsp;%%LNG_ZenCartLocation%%:
		</td>
		<td>
			<input type="text" name="path" class="Field250" id="ZenCartPath" value="%%GLOBAL_Path%%">
			<img onmouseout="HideHelp('zct_path')" onmouseover="ShowHelp('zct_path', '%%GLOBAL_HelpTitle%%', '%%LNG_ZenCartLocationHelp%%')" src="images/help.gif" width="24" height="16" border="0">
			<div style="display:none" id="zct_path"></div>
		</td>
	</tr>
</table>
<script type="text/javascript">
	function zencartCheckForm()
	{
		if($('#ZenCartPath').val() == ''  || $('#ZenCartPath').val() == 'http://') {
			alert('%%LNG_NoZenCartPath%%');
			$('#ZenCartPath').focus();
			$('#ZenCartPath').select();
			return false;
		}
		return true;
	}
</script>
