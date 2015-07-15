
	<tr class="GridRow" onmouseover="this.className='GridRowOver'" onmouseout="this.className='GridRow'">
		<td align="center" style="width:25px">
			<input type="checkbox" name="news[]" value="%%GLOBAL_NewsId%%">
		</td>
		<td align="center" style="width:18px">
			<img src="images/news.gif" width="12" height="15" />
		</td>
		<td width="550" class="%%GLOBAL_SortedFieldTitleClass%%">
			%%GLOBAL_Title%%
		</td>
		<td style="width:250px" class="%%GLOBAL_SortedFieldDateClass%%">
			%%GLOBAL_Date%%
		</td>
		<td align="center" class="%%GLOBAL_SortedFieldVisibleClass%%">
			%%GLOBAL_Visible%%
		</td>
		<td>
			%%GLOBAL_EditNewsLink%%&nbsp;&nbsp;&nbsp;
			<a title='%%LNG_PreviewNewsPost%%' href="javascript:PreviewNews(%%GLOBAL_NewsId%%)">%%LNG_PreviewNews%%</a>
		</td>
	</tr>