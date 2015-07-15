<table>
	<tr>
		<td class="FieldLabel">
			&nbsp;&nbsp;&nbsp;%%LNG_DownloadDescription%%:
		</td>
		<td>
			<input type="text" name="downloads[%%GLOBAL_DownloadId%%][downdescription]" id="DownloadDescription%%GLOBAL_DownloadId%%" value="%%GLOBAL_DownloadDescription%%" class="Field200" />
		</td>
	</tr>
	<tr>
		<td class="FieldLabel">
			&nbsp;&nbsp;&nbsp;%%LNG_ExpiresAfter%%:
		</td>
		<td>
			<input type="text" name="downloads[%%GLOBAL_DownloadId%%][downexpiresafter]" id="DownloadExpiresAfter%%GLOBAL_DownloadId%%" value="%%GLOBAL_ExpiresAfter%%" class="Field40" />
			<select name="downloads[%%GLOBAL_DownloadId%%][downexpiresrange]" id="DownloadExpiresRange%%GLOBAL_DownloadId%%">
				<option value="days">%%LNG_RangeDays%%</option>
				<option value="weeks" %%GLOBAL_RangWeeksSelected%%>%%LNG_RangeWeeks%%</option>
				<option value="months" %%GLOBAL_RangeMonthsSelected%%>%%LNG_RangeMonths%%</option>
				<option value="years" %%GLOBAL_RangeYearsSelected%%>%%LNG_RangeYears%%</option>
			</select>
			<img onmouseout="HideHelp('dlexpires%%GLOBAL_DownloadId%%');" onmouseover="ShowHelp('dlexpires%%GLOBAL_DownloadId%%', '%%LNG_ExpiresAfter%%', '%%LNG_ExpiresAfterHelp%%')" src="images/help.gif" width="24" height="16" border="0">
			<div style="display:none" id="dlexpires%%GLOBAL_DownloadId%%"></div>
		</td>
	</tr>
	<tr>
		<td class="FieldLabel">
			&nbsp;&nbsp;&nbsp;%%LNG_MaximumDownloads%%:
		</td>
		<td>
			<input type="text" name="downloads[%%GLOBAL_DownloadId%%][downmaxdownloads]" id="DownloadMaxDownloads%%GLOBAL_DownloadId%%" class="Field40" value="%%GLOBAL_MaxDownloads%%" />
			<img onmouseout="HideHelp('dldownloads%%GLOBAL_DownloadId%%');" onmouseover="ShowHelp('dldownloads%%GLOBAL_DownloadId%%', '%%LNG_MaximumDownloads%%', '%%LNG_MaximumDownloadsHelp%%')" src="images/help.gif" width="24" height="16" border="0">
			<div style="display:none" id="dldownloads%%GLOBAL_DownloadId%%"></div>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>
			<input type="button" value="%%LNG_SaveDownload%%" onclick="saveDownload();" class="SaveButton SmallButton" style="width: 90px;" />
			<input type="button" value="%%LNG_CancelEdit%%" onclick="cancelDownloadEdit();" class="CancelButton SmallButton" style="width: 60px" />
		</td>
	</tr>
</table>