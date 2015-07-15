<table class="Panel" style="width:100%" id="optionGrid">
	<thead>
		<tr class="Heading3">
			<td></td>
			<td><span class="HelpText" onmouseout="HideQuickHelp(this);" onmouseover="ShowQuickHelp(this, '%%LNG_EnableDisableAll%%', '%%LNG_EnableDisableAllHelp%%');"><input type='checkbox' checked='checked' onclick="$('#optionGrid').find('input[type=checkbox]').attr('checked', this.checked)" /></span></td>
			%%GLOBAL_HeaderRows%%
			<td>%%LNG_SKU%%</td>
			<td><span class="HelpText" onmouseout="HideQuickHelp(this);" onmouseover="ShowQuickHelp(this, '%%LNG_VariationPrice%%', '%%LNG_VariationPriceHelp%%');">%%LNG_VariationPrice%%</span></td>
			<td><span class="HelpText" onmouseout="HideQuickHelp(this);" onmouseover="ShowQuickHelp(this, '%%LNG_VariationWeight%%', '%%LNG_VariationWeightHelp%%');">%%LNG_VariationWeight%%</span></td>
			<td><span class="HelpText" onmouseout="HideQuickHelp(this);" onmouseover="ShowQuickHelp(this, '%%LNG_Image%%', '%%LNG_VariationImageHelp%%');">%%LNG_Image%%</span></td>
			<td style="display:%%GLOBAL_HideInv%%" class="VariationStockColumn"><span class="HelpText" onmouseout="HideQuickHelp(this);" onmouseover="ShowQuickHelp(this, '%%LNG_StockLevel%%', '%%LNG_StockLevelHelp%%');">%%LNG_StockLevel%%</span></td>
			<td style="display:%%GLOBAL_HideInv%%" class="VariationStockColumn"><span class="HelpText" onmouseout="HideQuickHelp(this);" onmouseover="ShowQuickHelp(this, '%%LNG_LowStockLevel%%', '%%LNG_LowStockLevelHelp%%');">%%LNG_LowStockLevel%%</span></td>
		</tr>
	</thead>
	<tbody>
		%%GLOBAL_VariationRows%%
	</tbody>
</table>
