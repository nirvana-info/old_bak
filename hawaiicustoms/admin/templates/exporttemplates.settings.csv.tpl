<tr>
	<td class="Heading2" colspan="2">%%LNG_CSVSettingsTitle%%</td>
</tr>
<tr>
	<td class="FieldLabel">
		<span class="Required">*</span>&nbsp;%%LNG_FieldSeparator%%:
	</td>
	<td>
		<input type="text" id="FieldSeparator" name="CSV[FieldSeparator]" style="width: 50px;" maxlength="3" value="%%GLOBAL_SettingFieldSeparator%%" />
		<img onmouseout="HideHelp('dfieldSeparator');" onmouseover="ShowHelp('dfieldSeparator', '%%LNG_FieldSeparator%%', '%%LNG_FieldSeparatorHelp%%')" src="images/help.gif" width="24" height="16" border="0">
		<div style="display: none;" id="dfieldSeparator"></div>
	</td>
</tr>
<tr>
	<td class="FieldLabel">
		&nbsp;&nbsp;%%LNG_FieldEnclosure%%:
	</td>
	<td>
		<input type="text" id="FieldEnclosure" name="CSV[FieldEnclosure]" style="width: 50px;" maxlength="1" value="%%GLOBAL_SettingFieldEnclosure%%" />
		<img onmouseout="HideHelp('dfieldEnclosure');" onmouseover="ShowHelp('dfieldEnclosure', '%%LNG_FieldEnclosure%%', '%%LNG_FieldEnclosureHelp%%')" src="images/help.gif" width="24" height="16" border="0">
		<div style="display: none;" id="dfieldEnclosure"></div>
	</td>
</tr>
<tr>
	<td class="FieldLabel">
		&nbsp;&nbsp;%%LNG_IncludeHeader%%
	</td>
	<td>
		<label><input type="checkbox" id="IncludeHeader" name="CSV[IncludeHeader]" value="1" %%GLOBAL_SettingIncludeHeader%% />%%LNG_YesIncludeHeader%%</label>&nbsp;
		<img onmouseout="HideHelp('dincludeHeader');" onmouseover="ShowHelp('dincludeHeader', '%%LNG_IncludeHeader%%', '%%LNG_IncludeHeaderHelp%%')" src="images/help.gif" width="24" height="16" border="0">
		<div style="display: none;" id="dincludeHeader"></div>
	</td>
</tr>
<tr>
	<td class="FieldLabel">
		&nbsp;&nbsp;%%LNG_BlankLine%%
	</td>
	<td>
		<label><input type="checkbox" id="BlankLine" name="CSV[BlankLine]" value="1" %%GLOBAL_SettingBlankLine%% />%%LNG_YesBlankLine%%</label>&nbsp;
	</td>
</tr>
<tr>
	<td class="FieldLabel">
		&nbsp;&nbsp;%%LNG_SubItems%%
	</td>
	<td>
		<label><input type="checkbox" id="SubItems" name="CSV[SubItems]" value="1" %%GLOBAL_SettingSubItems%% />%%LNG_YesCombineSubItems%%</label>&nbsp;
		<img onmouseout="HideHelp('dsubItems');" onmouseover="ShowHelp('dsubItems', '%%LNG_SubItems%%', '%%LNG_CombineSubItemsHelp%%')" src="images/help.gif" width="24" height="16" border="0">
		<div style="display: none;" id="dsubItems"></div>
		<div style="margin-top: 3px; %%GLOBAL_DisplaySubItems%%" id="SubItemToggle">
			<img src="images/nodejoin.gif" style="vertical-align: middle;" />
			%%LNG_SubItemSeparator%%: <input type="text" id="SubItemSeparator" name="CSV[SubItemSeparator]" style="width: 50px;" maxlength="1" value="%%GLOBAL_SettingSubItemSeparator%%" />
			<img onmouseout="HideHelp('dsubItemSep');" onmouseover="ShowHelp('dsubItemSep', '%%LNG_SubItemSeparator%%', '%%LNG_SubItemSeparatorHelp%%')" src="images/help.gif" width="24" height="16" border="0">
			<div style="display: none;" id="dsubItemSep"></div>
		</div>
	</td>
</tr>
<tr>
	<td class="FieldLabel">
		&nbsp;&nbsp;%%LNG_LineEnding%%:
	</td>
	<td>
		<select class="Field100" name="CSV[LineEnding]" id="LineEnding">
			<option value="Windows" %%GLOBAL_SettingWindowsSelected%%>Windows</option>
			<option value="Unix" %%GLOBAL_SettingUnixSelected%%>Mac/Unix</option>
		</select>
	</td>
</tr>
<tr>
	<td class="FieldLabel">
		&nbsp;&nbsp;%%LNG_AltCustomers%%:
	</td>
	<td>
		<label><input type="checkbox" id="AltCustomers" name="CSV[AltCustomers]" value="1" %%GLOBAL_SettingAltCustomers%% />%%LNG_YesAltCustomers%%</label>&nbsp;
		<img onmouseout="HideHelp('daltcustomers');" onmouseover="ShowHelp('daltcustomers', '%%LNG_AltCustomers%%', '%%LNG_AltCustomersHelp%%')" src="images/help.gif" width="24" height="16" border="0">
		<div style="display: none;" id="daltcustomers"></div>
	</td>
</tr>

<script type="text/javascript">
	$("#SubItems").change(function() {
		$("#SubItemToggle").toggle();
	});
	if (!$("#SubItems").attr("checked")) {
		$("#SubItemToggle").toggle();
	}

	function ValidateCSV() {
		if ($('#FieldSeparator').val().length == 0 || ($('#FieldSeparator').val().length > 1 && $('#FieldSeparator').val().toLowerCase() != 'tab')) {
			alert('%%LNG_FieldSeparatorValidate%%');
			$('#FieldSeparator').focus();
			return false;
		}

		if ($('#FieldEnclosure').val().length == 0) {
			alert('%%LNG_FieldEnclosureValidate%%');
			$('#fieldEnclosure').focus();
			return false;
		}

		if ($('#SubItemSeparator').val().length == 0) {
			alert('%%LNG_SubItemSeparatorValidate%%');
			$('#SubItemSeparator').focus();
			return false;
		}
		else if ($('#SubItemSeparator').val() == $('#FieldSeparator').val()) {
			alert('%%LNG_SubItemSeparatorIsSame%%');
			$('#SubItemSeparator').focus();
			return false;
		}

		return true;
	}
</script>