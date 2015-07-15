<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td valign="top" width="50%" class="QuickViewPanel" style="padding-right: 10px;">
			<h5>%%LNG_ReturnDetails%%</h5>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td class="text" width="120" nowrap="nowrap" style="padding-right: 4px;">%%LNG_ReturnReason%%</td>
					<td class="text"><input type="text" value="%%GLOBAL_ReturnReason%%" class="Field200" style="width: 95%;" readonly="readonly" /></td>
				</tr>

				<tr>
					<td class="text" width="120" nowrap="nowrap" style="padding-right: 4px;">%%LNG_ReturnAction%%</td>
					<td class="text"><input type="text" value="%%GLOBAL_ReturnAction%%" class="Field200" style="width: 95%;" readonly="readonly" /></td>
				</tr>

				<tr>
					<td class="text" width="120" nowrap="nowrap" valign="top" style="padding-right: 4px;">%%LNG_CustomerComments%%</td>
					<td class="text"><textarea cols="10" rows="4" readonly="readonly" class="Field200" style="width: 95%;" >%%GLOBAL_CustomerComments%%</textarea></td>
				</tr>
			</table>
		</td>
		<td valign="top" style="padding-left: 15px;">
			<h5>%%LNG_StaffNotes%%</h5>
			<form id="ReturnNotes%%GLOBAL_ReturnId%%">
				<input type="hidden" name="returnId" value="%%GLOBAL_ReturnId%%" />
				<textarea cols="50" rows="6" class="Field250" style="width: 95%;" name="returnNotes">%%GLOBAL_StaffNotes%%</textarea>
				<div>
					<input type="button" value="%%LNG_Save%%" class="FormButton" onclick="UpdateReturnNotes(%%GLOBAL_ReturnId%%);" />
				</div>
			</form>
		</td>
	</tr>
</table>