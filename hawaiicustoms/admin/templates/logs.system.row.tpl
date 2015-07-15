			<tr id="tr%%GLOBAL_LogId%%" class="GridRow" onmouseover="this.className='GridRowOver'" onmouseout="this.className='GridRow'">
				<td width="1">
					<input type="checkbox" class="DeleteCheck" name="delete[]" value="%%GLOBAL_LogId%%" />
				</td>
				<td width="1">
					<img src="images/log_%%GLOBAL_SeverityClass%%.gif" alt="" />
				</td>
				<td width="80" class="%%GLOBAL_SeverityClass%%">
					%%GLOBAL_Severity%%
				</td>
				<td align="center" style="width:15px">
					%%GLOBAL_ExpandLink%%
				</td>
				<td class="%%GLOBAL_SortedFieldTypeClass%%">
					%%GLOBAL_Type%%
				</td>
				<td class="%%GLOBAL_SortedFieldModuleClass%%">
					%%GLOBAL_Module%%
				</td>
				<td class="%%GLOBAL_SortedFieldSummaryClass%%">
					%%GLOBAL_Summary%%
				</td>
				<td width="150" class="%%GLOBAL_SortedFieldDateClass%%">
					%%GLOBAL_Date%%
				</td>
			</tr>
			<tr id="trQ%%GLOBAL_LogId%%" style="display:none">
				<td colspan="3">
					&nbsp;
				</td>
				<td colspan="4" id="tdQ%%GLOBAL_LogId%%" class="QuickView">
				</td>
				<td colspan="2">&nbsp;</td>
			</tr>