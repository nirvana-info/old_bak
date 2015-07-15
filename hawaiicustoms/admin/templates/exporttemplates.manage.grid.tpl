<table class="GridPanel" cellspacing="0" cellpadding="0" border="0" style="width: 100%; margin-bottom: 10px;">
	<tr class="Heading3">
		<td align="center" style="%%GLOBAL_HideCheckAll%%"><input type="checkbox" onclick="ToggleDeleteBoxes(this.checked)"></td>
		<td>&nbsp;</td>
		<td>
			%%LNG_ExportTemplateTitle%% &nbsp;
			%%GLOBAL_SortLinksTitle%%
		</td>
		<td>
			<span class="HelpText" onmouseout="HideQuickHelp(this);" onmouseover="ShowQuickHelp(this, '%%LNG_TemplateType%%', '%%LNG_TemplateTypeHelp%%');">%%LNG_TemplateType%%</span>&nbsp;
			%%GLOBAL_SortLinksType%%
		</td>
		<td %%GLOBAL_HideVendorColumn%%>
			%%GLOBAL_VendorLabel%% &nbsp;
			%%GLOBAL_SortLinksVendor%%
		</td>
		<td style="width:100px;">
			%%LNG_Action%% &nbsp;
			%%GLOBAL_SortLinksAction%%
		</td>
	</tr>
	%%GLOBAL_ExportTemplateGridData%%
</table>