			<table class="GridPanel SortableGrid AutoExpand" cellspacing="0" cellpadding="0" border="0" id="IndexGrid" style="width:100%;">
			<tr>
				<td colspan="11">
					<table class="LetterSort" cellspacing="2" cellpadding="0" border="0">
						<tr>
							%%GLOBAL_LetterSortGrid%%
						</tr>
					</table>
				</td>
			</tr>
			<tr align="right">
				<td colspan="11" style="padding:6px 0px 6px 0px" class="PagingNav">
					%%GLOBAL_Nav%%   %%GLOBAL_GOTO%%
				</td>
			</tr>
			<tr class="Heading3">
				<td align="center"><input type="checkbox" onclick="ToggleDeleteBoxes(this.checked)"></td>
				<td>&nbsp;</td>
				<td style="display: %%GLOBAL_HideInventoryOptions%%">
					&nbsp;
				</td>
				<td class="ImageField">%%LNG_Image%%</td>
				<td>
					%%LNG_ProductSKU%% &nbsp;
					%%GLOBAL_SortLinksCode%%
				</td>
				<td style="width: 95px; display: %%GLOBAL_HideInventoryOptions%%">
					<span class="HelpText" onmouseout="HideQuickHelp(this);" onmouseover="ShowQuickHelp(this, '%%LNG_StockLevel%%', '%%LNG_StockLevelHelp%%');">%%LNG_StockLevel%%</span> &nbsp;
					%%GLOBAL_SortLinksStock%%
				</td>
				<td colspan="%%GLOBAL_ProductNameSpan%%">
					%%LNG_ProductName%% &nbsp;
					%%GLOBAL_SortLinksName%%
				</td>
				<td width="70" style="text-align: right;">
					%%LNG_ProductPrice%% &nbsp;
					%%GLOBAL_SortLinksPrice%%
				</td>
				<td width="70" nowrap="nowrap">
					%%LNG_ProductVisible%% &nbsp;
					%%GLOBAL_SortLinksVisible%%
				</td>
				<td width="80" nowrap="nowrap">
					%%LNG_ProductFeatured%% &nbsp;
					%%GLOBAL_SortLinksFeatured%%
				</td>
				<td style="width:70px;">
					%%LNG_Action%%
				</td>
			</tr>
			%%GLOBAL_ProductGrid%%
			<tr align="right">
				<td colspan="11" style="padding:6px 0px 6px 0px" class="PagingNav">
					%%GLOBAL_Nav%%  %%GLOBAL_GOTO1%%
				</td>
			</tr>
		</table>

		<SCRIPT LANGUAGE="JavaScript">
				
		function go(value)
		{


		var temp1;
		
		temp1 = 'index.php?ToDo=viewProducts&sortField=productid&sortOrder=desc&page=';
		temp1 += value;
		
		$('#gotopage').attr('href', temp1);	

		}
		

		function go1(value)
		{


		var temp1;
		
		temp1 = 'index.php?ToDo=viewProducts&sortField=productid&sortOrder=desc&page=';
		temp1 += value;
		
		$('#gotopage1').attr('href', temp1);	

		}
		</SCRIPT>