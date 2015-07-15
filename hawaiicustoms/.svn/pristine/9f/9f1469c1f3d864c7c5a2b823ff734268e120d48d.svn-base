
	<tr id="tr%%GLOBAL_PhotoId%%" class="GridRow" onmouseover="this.className='GridRowOver'" onmouseout="this.className='GridRow'">
		<td align="center" style="width:25px">
			<input type="checkbox" name="photos[]" value="%%GLOBAL_PhotoId%%">
		</td>
		<td>
			<img class="adjust-image" original_selector="#img_%%GLOBAL_PhotoId%%" src="images/ajax-loader.gif" data="%%GLOBAL_Path%%" width="16" height="16" />
		</td>
		<td colspan="1" class="%%GLOBAL_SortedFieldDescriptionClass%%">
			%%GLOBAL_Description%%
		</td>
		<td class="%%GLOBAL_SortedFieldNameClass%%">
			<a href="%%GLOBAL_CustomerUrl%%">%%GLOBAL_Name%%</a>
		</td>
		<td colspan="1">
			%%GLOBAL_UploaderName%%
		</td>
		<td>
			%%GLOBAL_Address%%
		</td>
		<td colspan="2" class="%%GLOBAL_SortedFieldDateClass%%">
			%%GLOBAL_Date%%
		</td>
		<td colspan="2" class="%%GLOBAL_SortedFieldCommentClass%%" id="notes_%%GLOBAL_PhotoId%%">
			%%GLOBAL_Comment%%
		</td>
		<td class="%%GLOBAL_SortedFieldDeletedClass%%">
			%%GLOBAL_Deleted%%
		</td>
		<td colspan="2">
			<div id="img_%%GLOBAL_PhotoId%%" style="display:none;">
				<!--<a href="%%GLOBAL_Path%%" target="_blank">-->
					<img src="%%GLOBAL_Path%%" />
				<!--</a>-->
			</div>
			<a href="#" class="%%GLOBAL_HasNotesClass%% ViewNotesLink" onclick="Photos.ViewPhoto('%%GLOBAL_PhotoId%%'); return false;">View</a>
			<a href="#" class="%%GLOBAL_HasNotesClass%% ViewNotesLink" onclick="Photos.ViewNotes('%%GLOBAL_PhotoId%%'); return false;">Comment</a>
			<a href="index.php?ToDo=deleteCustomerPhotos&photos[]=%%GLOBAL_PhotoId%%" class="%%GLOBAL_HasNotesClass%% ViewNotesLink" onclick="return confirm('%%LNG_ConfirmDeletePhoto%%');">Delete</a>
		</td>
	</tr>
