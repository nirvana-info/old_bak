<tr class="GridRow" onmouseover="$(this).addClass('GrodRowOver');" onmouseout="$(this).removeClass('GridRowOver');">
	<td style="text-align: center;"><input type="checkbox" class="check" name="wrap[]" value="%%GLOBAL_WrapId%%" /></td>
	<td><img src="images/giftwrap.gif" alt="" /></td>
	<td>%%GLOBAL_WrapName%%</td>
	<td>%%GLOBAL_WrapPrice%%</td>
	<td style="text-align: center;"><img src="images/%%GLOBAL_WrapVisibleImage%%" alt="" /></td>
	<td>
		<a href="index.php?ToDo=editGiftWrap&amp;wrapId=%%GLOBAL_WrapId%%">%%LNG_Edit%%</a>
		<a href="index.php?ToDo=deleteGiftWrap&amp;wrap[]=%%GLOBAL_WrapId%%" onclick="return ConfirmDeleteWrap();">%%LNG_Delete%%</a>
	</td>
</tr>