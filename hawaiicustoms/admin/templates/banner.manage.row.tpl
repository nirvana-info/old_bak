<tr class="GridRow" onmouseover="this.className='GridRowOver'" onmouseout="this.className='GridRow'">
	<td align="center" style="width:25px">
		<input type="checkbox" name="banner[]" value="%%GLOBAL_BannerId%%">
	</td>
	<td align="center" style="width:18px;">
		<img src='images/banner.gif'>
	</td>
	<td class="%%GLOBAL_SortedFieldNameClass%%">
		%%GLOBAL_Name%%
	</td>
	<td class="%%GLOBAL_SortedFieldLocationClass%%">
		%%GLOBAL_Location%%
	</td>
	<td class="%%GLOBAL_SortedFieldDateClass%%">
		%%GLOBAL_Date%%
	</td>
	<td align="center" class="%%GLOBAL_SortedFieldStatusClass%%">
		%%GLOBAL_Visible%%
	</td>
	<td>
		<a title='%%LNG_EditThisBanner%%' class='Action' href='index.php?ToDo=editBanner&amp;bannerId=%%GLOBAL_BannerId%%'>%%LNG_Edit%%</a>
	</td>
</tr>