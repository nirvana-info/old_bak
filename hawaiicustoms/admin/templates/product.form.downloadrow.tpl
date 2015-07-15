									<tr id="download_%%GLOBAL_DownloadId%%" class="GridRow DownloadGridRow" onmouseover="if(this.className != 'QuickView') { this.oldClass = this.className; this.className='GridRowOver'; }" onmouseout="if(this.className != 'QuickView') { this.className=this.oldClass }">
										<td align="center" style="width:25px">
											<img src="images/download.gif" />
										</td>
										<td class="FileName" style="width: 40%">
											%%GLOBAL_DownloadName%%
										</td>
										<td class="FileSize" style="width: 100px;" align="right" nowrap="nowrap">
											%%GLOBAL_DownloadSize%%
										</td>
										<td align="right" nowrap="nowrap">
											%%GLOBAL_NumDownloads%%
										</td>
										<td class="MaxDownloads" style="width: 150px;" nowrap="nowrap">
											%%GLOBAL_MaxDownloads%%
										</td>
										<td class="ExpiresAfter" style="width: 150px;" nowrap="nowrap">
											%%GLOBAL_ExpiresAfter%%
										</td>
										<td style="width: 130px;" nowrap="nowrap">
											<a href="../%%GLOBAL_DownloadDirectory%%/%%GLOBAL_DownloadFile%%" target="_blank">%%LNG_ViewDownload%%</a>&nbsp;&nbsp;
											<a href="#" onclick="editDownload('%%GLOBAL_DownloadId%%'); return false;">%%LNG_Edit%%</a>&nbsp;&nbsp;<a href="#" onclick="return deleteDownload('%%GLOBAL_DownloadId%%'); return false;">%%LNG_Delete%%</a>
										</td>
									</tr>
									<tr id="download_edit_%%GLOBAL_DownloadId%%" style="display: none;">
										<td>&nbsp;</td>
										<td class="QuickView" colspan="3"></td>
										<td colspan="3">&nbsp;</td>
									</tr>