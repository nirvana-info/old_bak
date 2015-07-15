<form enctype="multipart/form-data" action="index.php?ToDo=%%GLOBAL_FormAction%%" id="frmVariation" method="post">
<input type="hidden" name="variationId" id="productId" value="%%GLOBAL_VariationId%%">
<div class="BodyContainer">
	<table cellSpacing="0" cellPadding="0" width="100%" style="margin-left: 4px; margin-top: 8px;">
	<tr>
		<td class="Heading1">%%GLOBAL_Title%%</td>
	</tr>
	<tr>
		<td class="Intro">
			<p>%%LNG_ViewVariationsIntro%%</p>
			%%GLOBAL_Message%%
			<div class="MessageBox MessageBoxInfo" style="display: %%GLOBAL_HideVariationTestDataWarning%%;">%%LNG_ProductVariationTestDataWarning%%</div>
			<p>
				<input type="button" value="%%LNG_SaveAndExit%%" class="FormButton" onclick="SaveVariationForm()" />
				<input type="button" value="%%GLOBAL_SaveAndAddAnother%%" onclick="SaveVariationForm(true)" class="FormButton" style="width:130px" />
				<input type="reset" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()" />
			</p>
		</td>
	</tr>
	<tr>
		<td>
			<table width="100%" class="Panel">
				<tr>
					<td class="Heading2" colspan="2">%%LNG_VariationDetails%%</td>
				</tr>
				<tr style="%%GLOBAL_HideVendorOption%%">
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_Vendor%%:
					</td>
					<td>
						<span style="%%GLOBAL_HideVendorLabel%%">%%GLOBAL_CurrentVendor%%</span>
						<select name="vendor" id="vendor" class="Field250" style="%%GLOBAL_HideVendorSelect%%">
							%%GLOBAL_VendorList%%
						</select>
						<img style="%%GLOBAL_HideVendorSelect%%" onmouseout="HideHelp('vendorhelp');" onmouseover="ShowHelp('vendorhelp', '%%LNG_Vendor%%', '%%LNG_VariationVendorHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="vendorhelp"></div>
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span>&nbsp;%%LNG_VariationName%%:
					</td>
					<td>
						<input type="text" id="vname" name="vname" class="Field250" value="%%GLOBAL_VariationName%%">
						<img onmouseout="HideHelp('d1');" onmouseover="ShowHelp('d1', '%%LNG_VariationName%%', '%%LNG_VariationNameHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="d1"></div><br />
						<div style="color:gray; font-size:8pt; margin-bottom:5px">%%LNG_VariationNameExample%%</div>
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span>&nbsp;%%LNG_VariationOptions%%:
					</td>
					<td>
						<ul id="ProductVariationBox">
							%%GLOBAL_Variations%%
						</ul>
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;
					</td>
					<td>
						<br />
						<input type="button" value="%%LNG_SaveAndExit%%" class="FormButton" onclick="SaveVariationForm()" />
						<input type="button" value="%%GLOBAL_SaveAndAddAnother%%" onclick="SaveVariationForm(true);" class="FormButton" style="width:130px" />
						<input type="reset" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()" />
					</td>
				</tr>
			</table>
		</td>
	</tr>
	</table>
</div>
</form>

<script type="text/javascript">

	var variationForm = document.getElementById('frmVariation');
	var affectedVariations = [%%GLOBAL_AffectedVariations%%];

	function SaveVariationForm(addAnother)
	{
		var optionValueIdx = [];
		var addedNewValues = false;

		if (!CheckVariationForm()) {
			return;
		}

		if (addAnother == true) {
			var f = g('frmVariation');
			var d = document.createElement('input');
			d.type = 'hidden';
			d.name = 'addanother';
			d.value = '1';
			f.appendChild(d);
		}

		/**
		 * OK, the form is good. Now we need to get all the existing option value IDs
		 */
		$("#ProductVariationBox .VariationValueId").each(
			function() {
				if ($(this).val() !== '') {
					optionValueIdx[optionValueIdx.length] = $(this).val();
				} else {
					addedNewValues = true;
				}
			}
		);

		/**
		 * Have we deleted the values that would affect products that use this variation? If so then display a thickbox with all the
		 * affected products in it. From there they can decide wether to proceed or cancel
		 */
		if (affectedVariations.length > 0 && (addedNewValues == true || affectedVariations.length !== optionValueIdx.length)) {

			if (addedNewValues) {
				var actionType = 'add';
			} else {
				var actionType = 'edit';
			}

			$.iModal({
				type: 'ajax',
				url: 'remote.php?remoteSection=products&w=viewAffectedVariations&actionType=' + actionType + '&variationIdx=%%GLOBAL_VariationId%%&optionValueIdx=' + optionValueIdx.join(),
				width: 600
			});

		/**
		 * Else not then just submit the form
		 */
		} else {
			variationForm.submit();
			return;
		}
	}

	function ConfirmCancel() {
		if(confirm("%%LNG_ConfirmCancelVariation%%"))
			document.location.href = "index.php?ToDo=viewProductVariations";
	}

	function CheckVariationForm() {
		if($('#vname').val() == '') {
			alert('%%LNG_ProductVariationErrorNoVariationName%%');
			$('#vname').focus();
			return false;
		}

		var rowCount = 0;
		var rowPass = true;

		$("#ProductVariationBox .VariationRow").each(function() {

			var valueCount = 0;
			var valuePass = true;

			if ($(".VariationOptionName", this).val() == '') {
				alert(('%%LNG_ProductVariationErrorNoOptionName%%').replace(/%d/, (rowCount+1)));
				$(".VariationOptionName").focus();
				rowPass = false;
				return false;
			}

			$(".VariationValueName", this).each(function() {
				if ($(this).val() == '') {
					alert(('%%LNG_ProductVariationErrorNoOptionValue%%').replace(/%d/, (rowCount+1)));
					$(this).focus();
					valuePass = false;
					return false;
				}

				valueCount++;
			});

			if (!valuePass) {
				rowPass = false;
				return false;
			}

			if (valueCount <= 1) {
				alert(('%%LNG_ProductVariationErrorInvalidOptions%%').replace(/%d/, (rowCount+1)));
				$(".VariationValueName:first", this).focus();
				rowPass = false;
				return false;
			}

			rowCount++;
		});

		if (!rowPass) {
			return false;
		}

		if (rowCount == 0) {
			alert('%%LNG_ProductVariationErrorNoData%%');
			return false;
		}

		return true;
	}

	function GetNextColumnID()
	{
		var matches, nextId = 0;

		$("#ProductVariationBox .VariationColumn .VariationOptionName").each(
			function() {
				matches = this.name.match(/variationOptionName\[([0-9]+)\]/);
				if (matches) {
					nextId = Math.max(nextId, matches[1]);
				}
			}
		);

		nextId++;

		return nextId;
	}

	function getNextValueID(valueRow)
	{
		var matches, parentId, nextId = 0;

		$(".VariationValue .VariationValueName", valueRow).each(
			function() {
				matches = this.name.match(/variationOptionValue\[([0-9]+)\]\[([0-9]+)\]/);
				if (matches) {
					parentId = matches[1];
					nextId = Math.max(nextId, matches[2]);
				}
			}
		);

		nextId++;

		return {"nextId": nextId, "parentId": parentId};
	}

	function AddVariationRow(addButton)
	{
		/**
		 * Re-dispaly the delete button
		 */
		$("#ProductVariationBox .VariationRowDel").each(function() { $(this).show(); });

		var row = $(addButton.parentNode.parentNode).clone();
		var next = GetNextColumnID();

		/**
		 * Strip out all the un-needed value boxes and just leave one with no delete button
		 */
		var box = $(".VariationValues .VariationValue:first", row).clone();
		$(".VariationDel", box).each(function() { $(this).hide(); });
		$(".VariationValues", row).empty();
		$(".VariationValues", row).append(box);

		/**
		 * Assign the next id to the column input
		 */
		$(".VariationColumn .VariationOptionName", row).attr("name", "variationOptionName[" + next + "]");
		$(".VariationColumn .VariationOptionName", row).attr("id", "variationOptionName_" + next);
		$(".VariationColumn .VariationOptionName", row).val("");

		/**
		 * Next assign it to the value input
		 */
		$(".VariationValues .VariationValue .VariationValueName", row).attr("name", "variationOptionValue[" + next + "][0]");
		$(".VariationValues .VariationValue .VariationValueName", row).attr("id", "variationOptionValue_" + next + "_0");
		$(".VariationValues .VariationValue .VariationValueName", row).val("");
		$(".VariationValues .VariationValue .VariationValueId", row).attr("name", "variationOptionValueId[" + next + "][0]");
		$(".VariationValues .VariationValue .VariationValueId", row).attr("id", "variationOptionValueId_" + next + "_0");
		$(".VariationValues .VariationValue .VariationValueId", row).val("");
		$(".VariationValuesRank", row).attr("name", "variationOptionValuesRank[" + next + "]");
		$(".VariationValuesRank", row).attr("id", "variationOptionValuesRank_" + next);

		/**
		 * Add the sortable function as it gets removed somehow
		 */
		AddSortableToValuesDiv($(".VariationValues", row));

		/**
		 * Now we add it
		 */
		$(addButton.parentNode.parentNode).after(row);
		$(".VariationColumn .VariationOptionName", row).focus();
	}

	function DelVariationRow(delButton)
	{
		var parent = delButton.parentNode.parentNode.parentNode;
		var child = delButton.parentNode.parentNode;
		var total = 0;

		/**
		 * Only remove if there is more than one (failsafe)
		 */
		$(".VariationRow", parent).each(function() { total++; });
		if (total <= 1) {
			return false;
		}

		parent.removeChild(child);

		/**
		 * If we are now left with one value for this row then hide the delete button
		 */
		if (total == 2) {
			$(".VariationRow .VariationRowDel", parent).each(function() { $(this).hide(); });
		}
	}

	function AddVariationValue(addButton)
	{
		/**
		 * Re-dispaly the delete button
		 */
		$(".VariationValue .VariationDel", addButton.parentNode.parentNode).each(function() { $(this).show(); });

		var box = $(addButton.parentNode).clone();
		var next = getNextValueID(addButton.parentNode.parentNode);

		/**
		 * Assign the next id to the value input
		 */
		$(".VariationValueName", box).attr("name", "variationOptionValue[" + next.parentId + "][" + next.nextId + "]");
		$(".VariationValueName", box).attr("id", "variationOptionValue_" + next.parentId + "_" + next.nextId);
		$(".VariationValueId", box).attr("name", "variationOptionValueId[" + next.parentId + "][" + next.nextId + "]");
		$(".VariationValueId", box).attr("id", "variationOptionValueId_" + next.parentId + "_" + next.nextId);
		$("input", box).val("");

		$(addButton.parentNode).after(box);
		$("#variationOptionValue_" + next.parentId + "_" + next.nextId).focus();
	}

	function DelVariationValue(delButton)
	{
		var parent = delButton.parentNode.parentNode;
		var child = delButton.parentNode;
		var total = 0;

		/**
		 * Only remove if there is more than one (failsafe)
		 */
		$(".VariationValue", parent).each(function() { total++; });
		if (total <= 1) {
			return false;
		}

		parent.removeChild(child);

		/**
		 * If we are now left with one value for this row then hide the delete button
		 */
		if (total == 2) {
			$(".VariationValue .VariationDel", parent).each(function() { $(this).hide(); });
		}
	}

	function AddSortableToValuesDiv(div)
	{
		$(div).sortable(
			{
				"container": "parent"
			}
		);
	}

	function AddSortableToContainer()
	{
		$("#ProductVariationBox").sortable(
			{
				"container": "parent"
			}
		);
	}

	$(document).ready(
		function()
		{
			$("#ProductVariationBox .VariationValues").each(function() { AddSortableToValuesDiv(this); });
			AddSortableToContainer();
		}
	);

</script>
