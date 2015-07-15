<form method="post" id="AdminLogForm" action="index.php?ToDo=systemLog" onsubmit="return SearchAdminLog(this)">
		<input type="hidden" name="AdminSortURL" id="AdminSortURL" value="index.php?ToDo=administratorLogGrid%%GLOBAL_SortURL%%" />
		<input type="hidden" name="CurrentTab" id="CurrentTab2" value="%%GLOBAL_CurrentTab%%" />
		<table id="AdminLogOptions" class="IntroTable" cellspacing="0" cellpadding="0" width="100%">
			<tr>
				<td class="Intro" style="padding-top: 10px;">
					<input type="button" name="IndexDeleteButton" value="%%LNG_DeleteSelected%%" id="IndexDeleteButton" class="SmallButton" onclick="ConfirmDeleteSelectedAdmin()" %%GLOBAL_DisableDelete%%  />
					<input type="button" name="DeleteAll" value="%%LNG_DeleteAll%%" class="SmallButton" onclick="ConfirmDeleteAllAdmin()" %%GLOBAL_DisableDelete%%  />
				</td>
				<td align="right" nowrap="nowrap" style="padding-top: 10px;">
					<select name="userid" id="adminUserId" onchange="SearchAdminLog(this)">
						<option value="0">%%LNG_AllAdministrators%%</option>
						%%GLOBAL_AdministratorList%%
					</select>
				</td>
				<td width="1" style="padding-left: 5px; padding-top: 10px;">
					<input id="SearchButton" type="image" border="0" style="vertical-align: middle;" src="images/searchicon.gif" name="SearchButton"/>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td align="right">
					<a href="index.php?ToDo=systemLog&amp;CurrentTab=1" onclick="ClearAdminSearchResults(this); return false;" style="display: %%GLOBAL_HideClearAdminResults%%" id="AdminSearchClearButton">%%LNG_ClearResults%%</a>
				</td>
				<td>&nbsp;</td>
			</tr>
		</table>
		<table class="GridPanel SortableGrid" cellspacing="1" cellpadding="2" border="0" id="AdminLogGrid" style="width:100%;">
			<tr align="right">
				<td colspan="6" style="padding:6px 0px 6px 0px" class="PagingNav">
					%%GLOBAL_Nav%%
				</td>
			</tr>

			<tr class="Heading3">
				<td align="center" width="1"><input type="checkbox" onclick="$(this).parents('form').find('input[type=checkbox]').attr('checked', this.checked);"></td>
				<td>&nbsp;</td>
				<td>
					%%LNG_Username%%
					%%GLOBAL_SortLinksName%%
				</td>
				<td>
					%%LNG_Action%%
				</td>
				<td>
					%%LNG_Date%%
					%%GLOBAL_SortLinksDate%%
				</td>
				<td nowrap="nowrap">
					%%LNG_IPAddress%%
					%%GLOBAL_SortLinksIP%%
				</td>
			</tr>
			%%GLOBAL_LogGrid%%
			<tr align="right">
				<td colspan="6" style="padding:6px 0px 6px 0px" class="PagingNav">
					%%GLOBAL_Nav%%
				</td>
			</tr>
		</table>
</form>