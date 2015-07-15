
	<div class="BodyContainer">
	<form action="index.php?ToDo=deleteCustomerGroups" id="frmCustomerGroups" name="frmCustomerGroups" method="post" onSubmit="return ValidateForm(ConfirmDeleteSelected)">
	<table id="Table13" cellSpacing="0" cellPadding="0" width="100%">
		<tr>
			<td class="Heading1">%%LNG_CustomerGroups%%</td>
		</tr>
		<tr>
			<td class="Intro">
				<p>%%LNG_CustomerGroupsIntro%%</p>
				%%GLOBAL_Message%%
			</td>
		</tr>
		<tr>
		<td>
			<table class="GridPanel" cellspacing="0" cellpadding="0" border="0" style="width:100%;">
				<tr>
					<td colspan="7">
						<input type="button" name="IndexAddButton" value="%%LNG_CreateACustomerGroup%%..." id="IndexCreateButton" class="SmallButton" onclick="document.location.href='index.php?ToDo=createCustomerGroup'" style="width:160px" /> &nbsp;
						<input type="submit" name="IndexDeleteButton" value="%%LNG_DeleteSelected%%" id="IndexDeleteButton" class="SmallButton" %%GLOBAL_DisableDelete%% />
					</td>
				</tr>
				<tr>
					<td colspan="7" class="EmptyRow">&nbsp;</td>
				</tr>
				%%GLOBAL_CustomerGroupsDataGrid%%
			</table>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>

	</table>
	</form>
	</div>

	<script type="text/javascript">

		function ToggleDeleteBoxes(Status)
		{
			var fp = document.getElementById("frmCustomerGroups").getElementsByTagName('input');

			for (var i=0; i < fp.length; i++)
			{
				if (!fp[i].getAttribute('disabled'))
					fp[i].checked = Status;
			}
		}

		function ConfirmDeleteSelected()
		{
			var fp = document.getElementById("frmCustomerGroups").elements;
			var c = 0;

			for(i = 0; i < fp.length; i++)
			{
				if(fp[i].type == "checkbox" && fp[i].checked)
					c++;
			}

			if(c > 0)
			{
				if(confirm("%%LNG_ConfirmDeleteCustomerGroups%%")) {
					return true;
				}
				else {
					return false;
				}
			}
			else
			{
				alert("%%LNG_ChooseCustomerGroup%%");
				return false;
			}
		}

	</script>

