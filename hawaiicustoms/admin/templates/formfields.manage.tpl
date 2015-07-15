
	<div class="BodyContainer">
		<input type="hidden" id="enableSortable" value="%%GLOBAL_FormFieldsIsSortable%%" />
		<table cellSpacing="0" cellPadding="0" width="100%" style="margin-left: 4px; margin-top: 8px;">
		<tr>
			<td class="Heading1">%%LNG_FormFieldsHeading%%</td>
		</tr>
		<tr>
			<td class="Intro">
				<p>%%LNG_FormFieldsIntro%%</p>
				<div id="FormFieldStatus">
					%%GLOBAL_Message%%
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<input type="hidden" id="CurrentFormFieldsFormId" name="CurrentFormFieldsFormId" value="%%GLOBAL_FormFieldsAccountFormId%%" />
				<ul id="FormFieldsSectionNav" class="tabnav">
					<li><a href="#" class="active" id="FormFieldsSection_%%GLOBAL_FormFieldsAccountFormId%%" onclick="ChangeFormFieldsTab(%%GLOBAL_FormFieldsAccountFormId%%);">%%GLOBAL_FormFieldsSectionAccount%%</a></li>
					<li><a href="#" id="FormFieldsSection_%%GLOBAL_FormFieldsAddressFormId%%" onclick="ChangeFormFieldsTab(%%GLOBAL_FormFieldsAddressFormId%%);">%%GLOBAL_FormFieldsSectionAddress%%</a></li>
				</ul>
			</td>
		</tr>
		<tr>
			<td class="EmptyRow">&nbsp;</td>
		</tr>
		<tr>
			<td>
				<button id="ViewsMenuButton" class="PopDownMenu FormButton FormFieldsMenuButton" style="display:%%GLOBAL_FormFieldsHideAddButton%%">%%LNG_FormFieldsAddField%% <img src="./images/arrow_blue.gif" alt="" /></button>
				 &nbsp; <input type="button" value="%%LNG_FormFieldsDeleteSelected%%" onclick="DeleteSelectedFormFields()" class="FormButton" style="width: auto; display:%%GLOBAL_FormFieldsHideDeleteButton%%" />
			</td>
		</tr>
		<tr>
			<td class="EmptyRow">&nbsp;</td>
		</tr>
		<tr>
			<td>
				<table class="GridPanel SortablePanel" cellspacing="0" cellpadding="0" border="0" style="width:100%;">
					<tr class="Heading3">
						<td align="center" style="width:18px;"><input type="checkbox" id="FormFieldDeleteCheckbox" onclick="TickFormFields(this.checked);"></td>
						<td>
							%%LNG_Name%%
						</td>
						<td style="width:17%;">
							%%LNG_Data%%
						</td>
						<td style="width:17%;">
							%%LNG_LastModified%%
						</td>
						<td style="width:17%;">
							%%LNG_Type%%
						</td>
						<td style="width:17%;">
							%%LNG_Action%%
						</td>
					</tr>
				</table>
				<div id="FormFieldsGrid">
					%%GLOBAL_FormFieldsGrid%%
				</div>
			</td>
		</tr>
		</table>
	</div>

	<div id="ViewsMenu" class="DropShadow DropDownMenu" style="display: none; width:150px">
		<div>
			%%GLOBAL_FormFieldsOptions%%
		</div>
	</div>

	<script type="text/javascript" src="../javascript/jquery/plugins/interface.js"></script>
	<script type="text/javascript" src="../javascript/jquery/plugins/inestedsortable.js"></script>
	<script type="text/javascript">

		function TickFormFields(ticked)
		{
			$('.FormFieldsIdx').each(
				function()
				{
					if (!this.disabled) {
						this.checked = ticked;
					}
				}
			);
		}

		function ChangeFormFieldsTab(formId)
		{
			if (formId == '' || isNaN(formId)) {
				return;
			}

			$('#FormFieldsSectionNav li a').each(
				function()
				{
					if ($(this).attr('id') == 'FormFieldsSection_' + formId) {
						$(this).attr('class', 'active');
						$('#CurrentFormFieldsFormId').val(formId);
					} else {
						$(this).attr('class', '');
					}
				}
			);

			$.ajax({
				url: 'remote.php',
				type: 'post',
				data: 'remoteSection=formfields&w=getFormFieldGrid&formId='+formId,
				success: ChangeFormFieldsTabCallback
			});
		}

		function ChangeFormFieldsTabCallback(data)
		{
			if ($('status', data).text() == '0') {
				return;
			}

			$('#FormFieldsGrid').html($('grid', data).text());

			InitFormFieldSortable();
		}

		function AddFormField(fieldType)
		{
			var formId = $('#CurrentFormFieldsFormId').val();

			if (fieldType == '' || formId == '' || isNaN(formId)) {
				return;
			}

			$.iModal({
				type: 'ajax',
				url: 'remote.php?remoteSection=formfields&w=addFieldSetupPopup&fieldType='+fieldType+'&formId='+formId,
				width: 600,
				onOpen:
					function()
					{
						$('#ModalContainer').show();
						InitFormFieldPopup();
					},
				onBeforeClose:
					function()
					{
						ChangeFormFieldsTab($('#CurrentFormFieldsFormId').val());
					}
			});
		}

		function EditFormField(fieldId, formId)
		{
			if (isNaN(fieldId) || isNaN(formId)) {
				return;
			}

			$.iModal({
				type: 'ajax',
				url: 'remote.php?remoteSection=formfields&w=getFieldSetupPopup&fieldId='+fieldId+'&formId='+formId,
				width: 600,
				onOpen:
					function()
					{
						$('#ModalContainer').show();
						InitFormFieldPopup();
					},
				onBeforeClose:
					function()
					{
						ChangeFormFieldsTab($('#CurrentFormFieldsFormId').val());
					}
			});
		}

		function CopyFormField(fieldId, formId)
		{
			if (isNaN(fieldId) || isNaN(formId)) {
				return;
			}

			$.iModal({
				type: 'ajax',
				url: 'remote.php?remoteSection=formfields&w=copyFieldSetupPopup&fieldId='+fieldId+'&formId='+formId,
				width: 600,
				onOpen:
					function()
					{
						$('#ModalContainer').show();
						InitFormFieldPopup();
					},
				onBeforeClose:
					function()
					{
						ChangeFormFieldsTab($('#CurrentFormFieldsFormId').val());
					}
			});
		}

		function DeleteSelectedFormFields()
		{
			var selectedIdx = [];
			var formId = $('#CurrentFormFieldsFormId').val();

			$('.FormFieldsIdx').each(
				function()
				{
					if (!this.disabled && this.checked) {
						selectedIdx[selectedIdx.length] = this.value;
					}
				}
			);

			if (selectedIdx.length < 1) {
				alert("%%LNG_FormFieldDeleteSelectedInvalid%%");
				return;
			}

			if (!confirm("%%LNG_FormFieldDeleteSelectedConfirm%%")) {
				return;
			}

			$.ajax({
				url: 'remote.php',
				type: 'post',
				data: 'remoteSection=formfields&w=deleteMultiField&fieldIdx='+selectedIdx.join(',')+'&formId='+formId,
				success: DeleteSelectedFormFieldsCallback
			});
		}

		function DeleteSelectedFormFieldsCallback(data)
		{
			if ($('status', data).text() == '1') {
				ChangeFormFieldsTab($('#CurrentFormFieldsFormId').val());
				$('#FormFieldDeleteCheckbox').attr('checked', false);
				display_success('FormFieldStatus', $('msg', data).text());
			} else {
				display_error('FormFieldStatus', $('msg', data).text());
			}
		}

		function DeleteFormField(fieldId, formId)
		{
			if (isNaN(fieldId) || isNaN(formId)) {
				return;
			}

			if (!confirm("%%LNG_FormFieldDeleteConfirm%%")) {
				return;
			}

			$.ajax({
				url: 'remote.php',
				type: 'post',
				data: 'remoteSection=formfields&w=deleteField&fieldId='+fieldId+'&formId='+formId,
				success: DeleteFormFieldCallback
			});
		}

		function DeleteFormFieldCallback(data)
		{
			var fieldId = $('fieldId', data).text();

			if ($('status', data).text() == '1') {
				ChangeFormFieldsTab($('#CurrentFormFieldsFormId').val());
				display_success('FormFieldStatus', $('msg', data).text());
			} else {
				display_error('FormFieldStatus', $('msg', data).text());
			}
		}

		function UpdateSortableFormField()
		{
			var idx = [];

			$('input.FormFieldsIdx').each(
				function()
				{
					idx[idx.length] = $(this).val();
				}
			);

			$.ajax({
				url: 'remote.php',
				type: 'post',
				data: {
						'remoteSection': 'formfields',
						'w': 'resortFormFieldGrid',
						'formId': $('#CurrentFormFieldsFormId').val(),
						'sortorder': idx.join(',')
					},
				success: function() { display_success('FormFieldStatus', "%%LNG_FormFieldReordered%%"); }
			});
		}

		function InitFormFieldSortable()
		{
			if ($('#enableSortable').val() == '') {
				return;
			}

			$('#FormFieldsGrid ul.SortableList').each(
				function()
				{
					$(this).sortable(
					{
						'accept': 'SortableRow',
						'containment': 'parent',
						'handle': '.sort-handle',
						'opacity': .8,
						'autoScroll': true,
						'helperclass': 'SortableRowHelper',
						'stop': UpdateSortableFormField
					});
				}
			);
		}

		$(document).ready(
			function()
			{
				InitFormFieldSortable();
			}
		);

	</script>