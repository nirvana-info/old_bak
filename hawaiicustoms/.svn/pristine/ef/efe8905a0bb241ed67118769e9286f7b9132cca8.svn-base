<div class="BodyContainer">
	<table cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<td class="Heading1">%%LNG_VendorPayments%%</td>
	</tr>
	<tr>
		<td class="Intro" colspan="2">
			<p>%%LNG_VendorPaymentsIntro%%</p>
			%%GLOBAL_Message%%
		</td>
	</tr>
	<tr>
		<td class="Intro">
			<p>
				<input type="button" value="%%LNG_AddVendorPayment%%" onclick="window.location = 'index.php?ToDo=addVendorPayment';" class="SmallButton" %%GLOBAL_DisableAdd%% />
				<input type="button" value="%%LNG_DeleteSelected%%" onclick="return VendorPayments.DeleteSelected();" class="SmallButton" %%GLOBAL_DisableDelete%% />
				<input type="button" value="%%LNG_ExportThesePayments%%" onclick="VendorPayments.Export()" class="SmallButton" %%GLOBAL_DisableExport%% />
			</p>
		</td>
		<td class="SmallSearch" align="right">
			<form action="index.php?ToDo=viewVendorPayments%%GLOBAL_SortURL%%" method="post">
				<table style="%%GLOBAL_DisplaySearch%%">
					<tr>
						<td class="text" nowrap="nowrap" align="right">
							<select name="vendorId">
								<option value="">%%LNG_ChooseAVendor%%</option>
								%%GLOBAL_VendorList%%
							&nbsp;
							<input type="image" name="SearchButton" id="SearchButton" src="images/searchicon.gif" border="0"  style="padding-left: 10px; vertical-align: top;" />
						</td>
					</tr>
					<tr>
						<td nowrap="nowrap">
							<span style="%%GLOBAL_HideClearResults%%">
								<a id="SearchClearButton" href="index.php?ToDo=viewVendorPayments">%%LNG_ClearResults%%</a>
							</span>
						</td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
	<tr style="%%GLOBAL_DisplayGrid%%">
		<td colspan="2">
			<form method="post" id="paymentsForm" action="index.php?ToDo=deleteVendorPayments">
				<div class="GridContainer" id="GridContainer">
					%%GLOBAL_PaymentDataGrid%%
				</div>
			</form>
		</td>
	</tr>
	</table>
</div>

<!-- Begin Export Vendor Payments Box -->
<div id="exportBox" style="display: none">
	<div class="ModalTitle">
		%%LNG_Export%% %%LNG_VendorPayments%%
	</div>
	<div class="ModalContent">
		<p>%%LNG_ExportThickBoxIntro%%</p>
		<p>%%LNG_ChooseAFileFormat%%</p>

		<table border="0">
			<tr>
				<td><img width="16" height="16" hspace="5" src="images/exportCsv.gif" /></td>
				<td><a onclick="$.modal.close()" href="index.php?ToDo=exportVendorPayments&amp;format=csv%%GLOBAL_SortURL%%" style="color:#005FA3; font-weight:bold">%%LNG_ExportCSV%%</a></td>
			</tr>
			<tr>
				<td><img width="16" height="16" hspace="5" src="images/exportXml.gif" /></td>
				<td><a onclick="$.modal.close()" href="index.php?ToDo=exportVendorPayments&amp;format=xml%%GLOBAL_SortURL%%" style="color:#005FA3; font-weight:bold">%%LNG_ExportXML%%</a></td>
			</tr>
		</table>
	</div>
	<div class="ModalButtonRow">
		<input type="button" class="Submit" value="%%LNG_Cancel%%" onclick="$.modal.close()" />
	</div>
</div>
<!-- End Export Vendor Payments Box -->

<script type="text/javascript" src="script/vendor.payments.js"></script>
<script type="text/javascript">
	lang.ConfirmDeleteVendorPayments = "%%LNG_ConfirmDeleteVendorPayments%%";
	lang.SelectOneMoreVendorPaymentsDelete = "%%LNG_SelectOneMoreVendorPaymentsDelete%%";
</script>