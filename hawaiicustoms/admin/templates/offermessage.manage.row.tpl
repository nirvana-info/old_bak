

	<tr id="tr%%GLOBAL_MessageId%%" class="GridRow" onmouseover="this.className='GridRowOver'" onmouseout="this.className='GridRow'">

		<td width="25" align="center"><input type="checkbox" name="messages[]" value="%%GLOBAL_MessageId%%"></td>

		<td width="25" align="center">

			<img src="images/message.gif">

		</td>

		<td width="25" align="center">

			<img src="images/messageflag.gif" style="display:%%GLOBAL_HideFlag%%">&nbsp;

		</td>

		<td>

			<div style="margin-left:20px">%%GLOBAL_Subject%%</div>

		</td>

		<td>

			%%GLOBAL_OrderMessage%%

		</td>

		<td>

			%%GLOBAL_OrderFrom%%

		</td>

		<td>

			%%GLOBAL_MessageDate%%

		</td>

		<td nowrap>

			%%GLOBAL_MessageStatus%%

		</td>

		<td>

			<a title="%%LNG_EditMessage%%" href="%%GLOBAL_ShopPath%%/admin/index.php?ToDo=editOfferMessage&amp;orderId=%%GLOBAL_OrderId%%&amp;messageId=%%GLOBAL_MessageId%%">%%LNG_Edit%%</a>&nbsp;&nbsp;&nbsp;

			<a title="%%LNG_FlagMessage%%" href="%%GLOBAL_ShopPath%%/admin/index.php?ToDo=flagOfferMessage&amp;flagState=%%GLOBAL_FlagState%%&amp;orderId=%%GLOBAL_OrderId%%&amp;messageId=%%GLOBAL_MessageId%%">%%GLOBAL_FlagText%%</a>

		</td>

	</tr>

