			<table class="GridPanel SortableGrid AutoExpand" cellspacing="0" cellpadding="0" border="0" id="IndexGrid" style="width:100%;">
				<tr align="right">
					<td colspan="13" style="padding:6px 0px 6px 0px" class="PagingNav">
						%%GLOBAL_Nav%%
					</td>
				</tr>
			<tr class="Heading3">
				<td align="center"><input type="checkbox" onclick="ToggleDeleteBoxes(this.checked)"></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td nowrap>
					%%LNG_OrderId%% &nbsp;
					%%GLOBAL_SortLinksId%%
				</td>
				<td colspan="%%GLOBAL_CustomerNameSpan%%">
					%%LNG_Customer%% &nbsp;
					%%GLOBAL_SortLinksCust%%
				</td>
				<td nowrap>
					%%LNG_Date%% &nbsp;
					%%GLOBAL_SortLinksDate%%
				</td>
				<td>
					%%LNG_Status%% &nbsp;
					%%GLOBAL_SortLinksStatus%%
				</td>
				<td style="text-align: center; display: %%GLOBAL_HideOrderMessages%%" nowrap>
					%%LNG_NewMessages%% &nbsp;
					%%GLOBAL_SortLinksMessage%%
				</td>
				<td style="width:80px; text-align: center;">
					%%LNG_Total%% &nbsp;
					%%GLOBAL_SortLinksTotal%%
				</td>
				
				<td style="display: %%GLOBAL_HideCountry%%">
					&nbsp;
				</td>
				<td style="width:100px">
					%%LNG_Action%%
				</td>
			</tr>
			%%GLOBAL_OrderGrid%%
			<tr align="right">
				<td colspan="12" style="padding:6px 0px 6px 0px" class="PagingNav">
					%%GLOBAL_Nav%%
				</td>
			</tr>
		</table>
		<input type="hidden" id="CurrentPage" name="CurrentPage" value="%%GLOBAL_CurrentPage%%" />