<form action="index.php?ToDo=deleteVendors" name="frmVendors" id="frmVendors" method="post" onsubmit="return ConfirmDeleteSelected();">
	<div class="BodyContainer">
	<table cellSpacing="0" cellPadding="0" width="100%">
	<tr>
		<td class="Heading1">%%LNG_Vendors%%</td>
	</tr>
	<tr>
		<td class="Intro">
			<p>%%LNG_VendorsIntro%%</p>
			%%GLOBAL_Message%%
			<p>
				<input type="button" onclick="window.location='index.php?ToDo=addVendor';" value="%%LNG_AddVendor%%" class="SmallButton" />
				<input name="DeleteButton" type="submit" value="%%LNG_DeleteSelected%%" class="SmallButton" %%GLOBAL_DisableDelete%% />
			</p>
		</td>
	</tr>
	<tr>
		<td>
			<div class="GridContainer">
				%%GLOBAL_VendorDataGrid%%
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
			alert('%%LNG_SelectOneMoreVendorsDelete%%');
			return false;
		}
		if(confirm('%%LNG_ConfirmDeleteVendors%%')) {
			return true;
		}
		else {
			return false;
		}
	}
function ConfirmDeleteVendor()
    {
        if(confirm('%%LNG_ConfirmDeleteVendors%%')) {
            return true;
        }
        else {
            return false;
        }
    }    
</script>
