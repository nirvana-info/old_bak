<form method="post" id="LogForm" action="index.php?ToDo=systemLog" onsubmit="return SearchSystemLog(this);">
	<input type="hidden" name="SortURL" id="SortURL" value="index.php?ToDo=systemLogGrid%%GLOBAL_SortURL%%" />
	<input type="hidden" name="CurrentTab" id="CurrentTab1" value="%%GLOBAL_CurrentTab%%" />
	<table id="SystemLogOptions" class="IntroTable" cellspacing="0" cellpadding="0" width="100%">
		<tr>
			<td class="Intro" style="padding-top: 10px;">
				<input type="button" name="IndexDeleteButton" value="%%LNG_DeleteSelected%%" id="IndexDeleteButton" class="SmallButton" onclick="ConfirmDeleteSelected()" %%GLOBAL_DisableDelete%%  />
				<input type="button" name="DeleteAll" value="%%LNG_DeleteAll%%" class="SmallButton" onclick="ConfirmDeleteAll()" %%GLOBAL_DisableDelete%%  />
			</td>
			<td align="right" nowrap="nowrap" style="padding-top: 10px;">
				<select name="severity" id="logSeverity">
					<option value="0">%%LNG_LogAllSeverities%%</option>
					<option value="1" %%GLOBAL_Severity1Selected%%>%%LNG_LogSeverity1%%</option>
					<option value="2" %%GLOBAL_Severity2Selected%%>%%LNG_LogSeverity2%%</option>
					<option value="3" %%GLOBAL_Severity3Selected%%>%%LNG_LogSeverity3%%</option>
					<option value="4" %%GLOBAL_Severity4Selected%%>%%LNG_LogSeverity4%%</option>
				</select>
				&nbsp;
				<select name="logtype" id="logType">
					<option value="">%%LNG_LogAllTypes%%</option>
					%%GLOBAL_LogSearchTypeSelect%%
				</select>
				&nbsp;
				<input type="text" id="logSummary" class="Button" value="%%GLOBAL_SummaryValue%%" size="20" />
			</td>
			<td width="1" style="padding-left: 5px;">
				<input id="SearchButton" type="image" border="0" style="vertical-align: middle;" src="images/searchicon.gif" name="SearchButton" />
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="right">
				<a href="index.php?ToDo=systemLog" style="display: %%GLOBAL_HideClearResults%%" id="SearchClearButton" onclick="return ClearSystemResults(this);">%%LNG_ClearResults%%</a>
			</td>
			<td>&nbsp;</td>
		</tr>
	</table>
	<table class="GridPanel SortableGrid" cellspacing="1" cellpadding="2" border="0" style="width:100%;">
		<tr align="right">
			<td colspan="8" style="padding:6px 0px 6px 0px" class="PagingNav">
				%%GLOBAL_Nav%%
			</td>
		</tr>

		<tr class="Heading3">
			<td align="center" width="1"><input type="checkbox" onclick="$(this).parents('form').find('input[type=checkbox]').attr('checked', this.checked);"></td>
			<td colspan="2">
				%%LNG_LogSeverity%% &nbsp;
				%%GLOBAL_SortLinksSeverity%%
			</td>
			<td>&nbsp;</td>
			<td>
				%%LNG_LogType%% &nbsp;
				%%GLOBAL_SortLinksType%%
			</td>
			<td>
				%%LNG_LogModule%% &nbsp;
				%%GLOBAL_SortLinksModule%%
			</td>
			<td>
				%%LNG_LogSummary%% &nbsp;
				%%GLOBAL_SortLinksSummary%%
			</td>
			<td>
				%%LNG_Date%% &nbsp;
				%%GLOBAL_SortLinksDate%%
			</td>
		</tr>
		%%GLOBAL_LogGrid%%
		<tr align="right">
			<td colspan="8" style="padding:6px 0px 6px 0px" class="PagingNav">
				%%GLOBAL_Nav%%
			</td>
		</tr>
	</table>
</form>