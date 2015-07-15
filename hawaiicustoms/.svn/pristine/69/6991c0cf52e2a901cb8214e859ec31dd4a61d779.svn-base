
	<div class="BodyContainer">
	<table id="Table13" cellSpacing="0" cellPadding="0" width="100%">
		<tr>
			<td class="Heading1">%%GLOBAL_ViewOrderMessages%%</td>
		</tr>
		<tr>
		<td class="Intro">
			<p>%%GLOBAL_MessageIntro%%</p>
			%%GLOBAL_Message%%
			<table id="IntroTable" cellspacing="0" cellpadding="0" width="100%">
				<tr>
					<td class="Intro" valign="top">
						<input type="button" name="IndexAddButton" value="%%LNG_CreateMessage%%..." id="IndexCreateButton" class="SmallButton" onclick="document.location.href='index.php?ToDo=createOrderMessage&amp;orderId=%%GLOBAL_OrderId%%'" />
						&nbsp;<input type="button" name="IndexDeleteButton" value="%%LNG_DeleteSelected%%" id="IndexDeleteButton" class="SmallButton" onclick="ConfirmDeleteSelected()" %%GLOBAL_DisableDelete%% />
						&nbsp;<input type="button" name="IndexReturnButton" value="%%LNG_ViewOrders%%" class="SmallButton" onclick="document.location.href='index.php?ToDo=viewOrders'" />
					</td>
				</tr>
			</table>
			<br />
		</td>
		</tr>
		<tr>
		<td style="display: %%GLOBAL_DisplayGrid%%">
			<form name="frmMessages" id="frmMessages" method="post" action="index.php?ToDo=deleteOrderMessages">
			<input type="hidden" name="orderId" value="%%GLOBAL_OrderId%%">
			<table class="GridPanel" cellspacing="0" cellpadding="0" border="0" id="IndexGrid" style="width:100%;">
			<tr class="Heading3">
				<td width="25" align="center"><input type="checkbox" onclick="ToggleDeleteBoxes(this.checked)"></td>
				<td width="25">&nbsp;</td>
				<td width="25">&nbsp;</td>
				<td>
					%%LNG_MessageSubject%%
				</td>
				<td>
					%%LNG_OrderMessage%%
				</td>
				<td>
					%%LNG_OrderFrom%%
				</td>
				<td>
					%%LNG_OrderDate%%
				</td>
				<td nowrap>
					%%LNG_OrderStatus%%
				</td>
				<td style="width:100px;">
					%%LNG_Action%%
				</td>
			</tr>
			%%GLOBAL_MessageGrid%%
		</table>
		</form>
		</td></tr>
	</table>
	</div>

	<script type="text/javascript">

		function ToggleDeleteBoxes(Status)
		{
			var fp = document.getElementById("frmMessages").elements;

			for(i = 0; i < fp.length; i++)
				fp[i].checked = Status;
		}

		function ConfirmDeleteSelected() {

			var fp = document.getElementById("frmMessages").elements;
			var c = 0;

			for(i = 0; i < fp.length; i++)
			{
				if(fp[i].type == "checkbox" && fp[i].checked)
					c++;
			}

			if(c > 0)
			{
				if(confirm("%%LNG_ConfirmDeleteMessages%%"))
					document.getElementById("frmMessages").submit();
			}
			else
			{
				alert("%%LNG_ChooseMessages%%");
			}
		}

	</script>

