<form action="index.php?ToDo=deleteGiftWrap" name="frmGiftWrap" id="frmGiftWrap" method="post" onsubmit="return ConfirmDeleteSelected();">
	<div class="BodyContainer">
	<table cellSpacing="0" cellPadding="0" width="100%">
	<tr>
		<td class="Heading1">%%LNG_GiftWrappingSettings%%</td>
	</tr>
	<tr>
		<td class="Intro">
			<p>%%LNG_GiftWrappingIntro%%</p>
			%%GLOBAL_Message%%
			<p>
				<input type="button" onclick="window.location='index.php?ToDo=addGiftWrap';" value="%%LNG_AddGiftWrap%%" class="SmallButton" />
				<input type="submit" value="%%LNG_DeleteSelected%%" class="SmallButton" %%GLOBAL_DisableDelete%% />
			</p>
		</td>
	</tr>
	<tr>
		<td>
			<div class="GridContainer">
				%%GLOBAL_GiftWrapDataGrid%%
			</div>
		</td>
	</tr>
	</table>
	</div>
</form>

<script type="text/javascript">
	function ConfirmDeleteSelected()
	{
		if(!$('.GridContainer input[type=checkbox].check:checked').length) {
			alert('%%LNG_SelectOneMoreGiftWrapDelete%%');
			return false;
		}
		if(confirm('%%LNG_ConfirmDeleteGiftWrap%%')) {
			return true;
		}
		else {
			return false;
		}
	}

	function ConfirmDeleteWrap()
	{
		if(confirm('%%LNG_ConfirmDeleteGiftWrap%%')) {
			return true;
		}

		return false;
	}
</script>
