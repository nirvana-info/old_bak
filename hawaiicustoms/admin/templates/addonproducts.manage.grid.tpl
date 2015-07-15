		<!-------nav---->
		<table class="GridPanel SortableGrid" cellspacing="0" cellpadding="0" border="0" id="IndexGrid" style="width:100%;">
			<tr align="right">
				<td style="padding:6px 0px 6px 0px" class="PagingNav">
					%%GLOBAL_Nav%%
				</td>
			</tr>
		</table>
		<!-------head---->
		<table class="GridPanel SortableGrid" cellspacing="0" cellpadding="0" border="0" style="width:100%;">
			<tr class="Heading3">
				<td width="5%" align="center"><input type="checkbox" onclick="ToggleDeleteBoxes(this.checked)"></td>
				<td width="30%">
					Product &nbsp;
					<!--zcs=
					%%GLOBAL_SortLinksProduct%%\
					-->
				</td>
				<td width="10%">
					Price &nbsp;
					<!--zcs=
					%%GLOBAL_SortLinksPrice%%
					-->
				</td>
				<td width="30%">
					Description &nbsp;
				</td>
				<td width="5%">
					Status &nbsp;
					<!--zcs=
					%%GLOBAL_SortLinksStatus%%
					-->
				</td>
				<td width="10%">
					Create Time &nbsp;
					<!--zcs=
					%%GLOBAL_SortLinksCreateTime%%
					-->
				</td>
				<td width="10%">
					%%LNG_Action%%
				</td>
			</tr>
		</table>
		<!--------body----->
		<ul id="SortList" class="SortableList">
			%%GLOBAL_AddonProductGrid%%
		</ul>
		<!-----foot---->
		<table class="GridPanel SortableGrid" cellspacing="0" cellpadding="0" border="0" style="width:100%;">
			<tr align="right">
				<td colspan="12" style="padding:6px 0px 6px 0px" class="PagingNav">
					%%GLOBAL_Nav%%
				</td>
			</tr>
		</table>