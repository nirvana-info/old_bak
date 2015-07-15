
	<div class="BodyContainer">
	<table id="Table13" cellSpacing="0" cellPadding="0" width="100%">
		<tr>
			<td class="Heading1">%%LNG_ViewProductVariations%%</td>
		</tr>
		<tr>
		<td class="Intro">
			<p>%%LNG_ViewVariationsIntro%%</p>
			%%GLOBAL_Message%%
			<table id="IntroTable" cellspacing="0" cellpadding="0" width="100%">
			<tr>
				<td class="Intro" valign="top">
					<input type="button" name="IndexAddButton" value="%%LNG_AddProductVariation%%..." id="IndexCreateButton" class="SmallButton" onclick="document.location.href='index.php?ToDo=addProductVariation'" style="width:160px" /> &nbsp;<input type="button" name="IndexDeleteButton" value="%%LNG_DeleteSelected%%" id="IndexDeleteButton" class="SmallButton" onclick="ConfirmDeleteSelected()" %%GLOBAL_DisableDelete%% />
				</td>
			</tr>
			</table>
		</td>
		</tr>
	</table>
	<table cellspacing="0" cellpadding="0" width="100%">
		<tr>
		<td style="display:%%GLOBAL_DisplayGrid%%">
			<form name="frmVariations" id="frmVariations" method="post" action="index.php?ToDo=deleteProductVariations">
				<div class="GridContainer">
					%%GLOBAL_VariationDataGrid%%
				</div>
			</form>
		</td></tr>
	</table>
	</div>

	<script type="text/javascript">

		var variationForm = document.getElementById('frmVariations');

		function ConfirmDeleteSelected() {
			var fp = variationForm.elements;
			var selected = [];

			for(i = 0; i < fp.length; i++) {
				if(fp[i].type == "checkbox" && fp[i].checked)
					selected[selected.length] = fp[i].value;
			}

			if(selected.length > 0) {

				/**
				 * Display a thickbox with all the affected products in it. From there they can decide wether to proceed or cancel
				 */
				$.iModal({
					type: 'ajax',
					url: 'remote.php?remoteSection=products&w=viewAffectedVariations&actionType=delete&variationIdx=' + selected.join(),
					width: 600
				});

			} else {
				alert("%%LNG_ChooseVariations%%");
			}
		}

		function ToggleDeleteBoxes(Status) {
			var fp = document.getElementById("frmVariations").elements;

			for(i = 0; i < fp.length; i++) {
				fp[i].checked = Status;
			}
		}

	</script>
