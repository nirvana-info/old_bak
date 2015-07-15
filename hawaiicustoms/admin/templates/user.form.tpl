
	<form enctype="multipart/form-data" action="index.php?ToDo=%%GLOBAL_FormAction%%" onsubmit="return ValidateForm(CheckUserForm)" id="frmUser" method="post">
	<input type="hidden" name="userId" value="%%GLOBAL_UserId%%">
	<div class="BodyContainer">
	<table class="OuterPanel">
	  <tr>
		<td class="Heading1" id="tdHeading">%%GLOBAL_Title%%</td>
		</tr>
		<tr>
		<td class="Intro">
			<p>%%LNG_UserIntro%%</p>
			%%GLOBAL_Message%%
			<p>
				<input type="submit" name="SaveButton1" value="%%LNG_Save%%" class="FormButton">&nbsp;
				<input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()">
			</p>
		</td>
	  </tr>
		<tr>
			<td>
			  <table class="Panel">
				<tr>
				  <td class="Heading2" colspan=2>%%LNG_NewUserDetails%%</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span>&nbsp;%%LNG_Username%%:
					</td>
					<td>
						<input type="text" id="username" name="username" class="Field250" autocomplete="off" value="%%GLOBAL_Username%%" %%GLOBAL_DisableUser%%>
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						%%GLOBAL_PassReq%%&nbsp;%%LNG_UserPass%%:
					</td>
					<td>
						<input type="password" id="userpass" name="userpass" class="Field250" autocomplete="off" value="%%GLOBAL_UserPass%%">
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						%%GLOBAL_PassReq%%&nbsp;%%LNG_UserPass1%%:
					</td>
					<td>
						<input type="password" id="userpass1" name="userpass1" class="Field250" autocomplete="off" value="%%GLOBAL_UserPass%%">
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span>&nbsp;%%LNG_UserEmail%%:
					</td>
					<td>
						<input type="text" id="useremail" name="useremail" class="Field250" value="%%GLOBAL_UserEmail%%">
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_UserFirstName%%:
					</td>
					<td>
						<input type="text" id="userfirstname" name="userfirstname" class="Field250" value="%%GLOBAL_UserFirstName%%">
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_UserLastName%%:
					</td>
					<td>
						<input type="text" id="userlastname" name="userlastname" class="Field250" value="%%GLOBAL_UserLastName%%">
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_UserStatus%%:
					</td>
					<td>
						<select id="userstatus" name="userstatus" class="Field250" %%GLOBAL_DisableStatus%%>
							<option value="1" %%GLOBAL_Active1%%>%%LNG_UserActive%%</option>
							<option value="0" %%GLOBAL_Active0%%>%%LNG_UserInactive%%</option>
						</select>
						<img onmouseout="HideHelp('d1');" onmouseover="ShowHelp('d1', '%%LNG_UserStatus%%', '%%LNG_UserStatusHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="d1"></div><br />
					</td>
				</tr>
				<tr style="%%GLOBAL_HideVendorOptions%%">
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_Vendor%%:
					</td>
					<td>
						<div style="%%GLOBAL_HideVendorSelect%%">
							<select id="uservendorid" name="uservendorid" class="Field250">
								<option value="">%%LNG_UserNoVendor%%</option>
								%%GLOBAL_VendorList%%
							</select>
							<img onmouseout="HideHelp('uservendorhelp');" onmouseover="ShowHelp('uservendorhelp', '%%LNG_Vendor%%', '%%LNG_VendorHelp%%')" src="images/help.gif" width="24" height="16" border="0">
							<div style="display:none" id="uservendorhelp"></div>
						</div>
						<div style="%%GLOBAL_HideVendorLabel%%">
							%%GLOBAL_Vendor%%
						</div>
					</td>
				</tr>
				<tr><td class="Gap"></td></tr>
				<tr><td class="Sep" colspan="2"></td></tr>
			 </table>
			</td>
		</tr>
		<tr>
			<td>
			  <table class="Panel">
				<tr>
				  <td class="Heading2" colspan=2>%%LNG_Permissions%%</td>
				</tr>
			</table>
			<table class="Panel">
				<tr>
					<td colspan="2">
						<p class="HelpInfo">
							%%LNG_PermissionsHelp1%% <a href="javascript:void(0)" onclick="LaunchHelp(686)">%%LNG_PermissionsHelp2%%</a>.
						</p>
					</td>
				</tr>
			</table>
			<table class="Panel">
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_UserRole%%:
					</td>
					<td>
						<select name="userrole" class="Field250" onchange="UpdateRole(this.options[this.selectedIndex].value)" %%GLOBAL_DisablePermissions%%>
							%%GLOBAL_UserRoleOptions%%
						</select>
						<img onmouseout="HideHelp('userrolehelp');" onmouseover="ShowHelp('userrolehelp', '%%LNG_UserRole%%', '%%LNG_UserRoleHelp%%')" src="images/help.gif" alt="" />
						<div style="display:none" id="userrolehelp"></div>
					</td>
				</tr>
				<tr class="PermissionSelects">
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_SalesStaffPermissions%%:<br />&nbsp;&nbsp;&nbsp;(<a onclick="SetupSalesStaffPermissions(true)" href="javascript:void(0)">%%LNG_SelectAll%%</a> / <a onclick="SetupSalesStaffPermissions(false)" href="javascript:void(0)">%%LNG_UnselectAll%%</a>)
					</td>
					<td>
						<select name="permissions[staff][]" id="permissions_sales" multiple="multiple" size="13" class="Field250 ISSelectReplacement permission_select" %%GLOBAL_DisablePermissions%%>
							<option value="111" class="vendor_role vendoradmin_role" %%GLOBAL_Selected_111%%> %%LNG_ManageOrders%%</option>
							<option value="112" class="vendor_role vendoradmin_role" %%GLOBAL_Selected_112%%> %%LNG_EditOrders%%</option>
							<option value="136" class="vendor_role vendoradmin_role" %%GLOBAL_Selected_136%%> %%LNG_AddOrders%%</option>

							<option value="161" class="vendor_role vendoradmin_role" %%GLOBAL_Selected_161%%> %%LNG_ManageReturns%%</option>

							<option value="115" class="vendor_role vendoradmin_role" %%GLOBAL_Selected_115%%> %%LNG_ManageCustomers%%</option>
							<option value="117" %%GLOBAL_Selected_117%%> %%LNG_EditCustomers%%</option>

							<option value="102" class="vendor_role vendoradmin_role" %%GLOBAL_Selected_102%%> %%LNG_ManageReviews%%</option>
							<option value="133" class="vendor_role vendoradmin_role" %%GLOBAL_Selected_133%%> %%LNG_EditReviews%%</option>
							<option value="134" class="vendor_role vendoradmin_role" %%GLOBAL_Selected_134%%> %%LNG_DeleteReviews%%</option>
							<option value="135" class="vendor_role vendoradmin_role" %%GLOBAL_Selected_135%%> %%LNG_ApproveReviews%%</option>

							<option value="123" %%GLOBAL_Selected_123%%> %%LNG_ManageCoupons%%</option>
							<option value="142" %%GLOBAL_Selected_142%%> %%LNG_EditCoupons%%</option>
							<option value="141" %%GLOBAL_Selected_141%%> %%LNG_AddCoupons%%</option>
							<option value="143" %%GLOBAL_Selected_143%%> %%LNG_DeleteCoupons%%</option>

							<option value="144" class="vendor_role vendoradmin_role" %%GLOBAL_Selected_144%%> %%LNG_ManagePages%%</option>
							<option value="145" class="vendor_role vendoradmin_role" %%GLOBAL_Selected_145%%> %%LNG_CreatePages%%</option>
							<option value="146" class="vendor_role vendoradmin_role" %%GLOBAL_Selected_146%%> %%LNG_EditPages%%</option>
							<option value="147" class="vendor_role vendoradmin_role" %%GLOBAL_Selected_147%%> %%LNG_DeletePages%%</option>
							<option value="148" %%GLOBAL_Selected_148%%> %%LNG_ManageBanners%%</option>
							<option value="162" %%GLOBAL_Selected_162%%> %%LNG_ManageGiftCertificates%%</option>
                            <option value="183" %%GLOBAL_Selected_183%%> %%LNG_ResetPrice%%</option>
						</select>
					</td>
				</tr>
				<tr class="PermissionSelects">
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_SalesManagerPermissions%%:<br />&nbsp;&nbsp;&nbsp;(<a onclick="SetupSalesManagerPermissions(true)" href="javascript:void(0)">%%LNG_SelectAll%%</a> / <a onclick="SetupSalesManagerPermissions(false)" href="javascript:void(0)">%%LNG_UnselectAll%%</a>)
					</td>
					<td>
						<select name="permissions[manager][]" id="permissions_manager" multiple="multiple" size="13" class="Field250 ISSelectReplacement permission_select" %%GLOBAL_DisablePermissions%%>
							<option value="101" class="vendor_role vendoradmin_role" %%GLOBAL_Selected_101%%> %%LNG_ManageProducts%%</option>
							<option value="103" class="vendor_role vendoradmin_role" %%GLOBAL_Selected_103%%> %%LNG_CreateProducts%%</option>
							<option value="104" class="vendor_role vendoradmin_role" %%GLOBAL_Selected_104%%> %%LNG_EditProducts%%</option>
							<option value="105" class="vendor_role vendoradmin_role" %%GLOBAL_Selected_105%%> %%LNG_DeleteProducts%%</option>
							<option value="106" class="vendor_role vendoradmin_role" %%GLOBAL_Selected_106%%> %%LNG_ExportProducts1%%</option>
							<option value="164" class="vendor_role vendoradmin_role" %%GLOBAL_Selected_164%%> %%LNG_ProductVariations%%</option>

							<option value="107" %%GLOBAL_Selected_107%%> %%LNG_ManageCategories%%</option>
							<option value="108" %%GLOBAL_Selected_108%%> %%LNG_CreateCategories%%</option>
							<option value="109" %%GLOBAL_Selected_109%%> %%LNG_EditCategories%%</option>
							<option value="110" %%GLOBAL_Selected_110%%> %%LNG_DeleteCategories%%</option>

							<option value="114" class="vendor_role vendoradmin_role" %%GLOBAL_Selected_114%%> %%LNG_ExportOrders%%</option>
							<option value="113" class="vendor_role vendoradmin_role" %%GLOBAL_Selected_113%%> %%LNG_DeleteOrders%%</option>
							<option value="154" class="vendor_role vendoradmin_role" %%GLOBAL_Selected_154%%> %%LNG_OrderMessages%%</option>

							<option value="116" %%GLOBAL_Selected_116%%> %%LNG_AddCustomers%%</option>
							<option value="118" %%GLOBAL_Selected_118%%> %%LNG_DeleteCustomers%%</option>
							<option value="119" %%GLOBAL_Selected_119%%> %%LNG_ExportCustomers%%</option>

							<option value="120" %%GLOBAL_Selected_120%%> %%LNG_ManageNews%%</option>
							<option value="137" %%GLOBAL_Selected_137%%> %%LNG_AddNews%%</option>
							<option value="138" %%GLOBAL_Selected_138%%> %%LNG_EditNews%%</option>
							<option value="140" %%GLOBAL_Selected_140%%> %%LNG_ApproveNews%%</option>
							<option value="139" %%GLOBAL_Selected_139%%> %%LNG_DeleteNews%%</option>

							<option value="125" %%GLOBAL_Selected_125%%> %%LNG_CreateFroogleFeed%%</option>

							<option value="149" %%GLOBAL_Selected_149%%> %%LNG_ManageBrands%%</option>
							<option value="150" %%GLOBAL_Selected_150%%> %%LNG_AddBrands%%</option>
							<option value="152" %%GLOBAL_Selected_152%%> %%LNG_EditBrands%%</option>
							<option value="151" %%GLOBAL_Selected_151%%> %%LNG_DeleteBrands%%</option>

							<option value="124" %%GLOBAL_Selected_124%%> %%LNG_ExportSubscribers%%</option>

							<option value="127" %%GLOBAL_Selected_127%%> %%LNG_ViewStatistics%%: %%LNG_StoreOverview%%</option>
							<option value="170" class="vendoradmin_role" %%GLOBAL_Selected_170%%> %%LNG_ViewStatistics%%: %%LNG_ProductStatistics%%</option>
							<option value="171" class="vendoradmin_role" %%GLOBAL_Selected_171%%> %%LNG_ViewStatistics%%: %%LNG_OrderStatistics%%</option>
							<option value="172" %%GLOBAL_Selected_172%%> %%LNG_ViewStatistics%%: %%LNG_CustomerStatistics%%</option>
							<option value="173" %%GLOBAL_Selected_123%%> %%LNG_ViewStatistics%%: %%LNG_SearchStatistics%%</option>

							<option value="176" class="vendoradmin_role" %%GLOBAL_Selected_176%%> %%LNG_ManageExportTemplates%%</option>
							<option value="181" %%GLOBAL_Selected_181%%> %%LNG_ManageCompanyGiftCertificate%%</option>
						</select>
					</td>
				</tr>
				<tr class="PermissionSelects">
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_SystemAdministratorPermissions%%:<br />&nbsp;&nbsp;&nbsp;(<a onclick="SetupSiteAdminPermissions(true)" href="javascript:void(0)">%%LNG_SelectAll%%</a> / <a onclick="SetupSiteAdminPermissions(false)" href="javascript:void(0)">%%LNG_UnselectAll%%</a>)
					</td>
					<td>
						<select name="permissions[admin][]" id="permissions_admin" multiple="multiple" size="13" class="Field250 ISSelectReplacement permission_select" %%GLOBAL_DisablePermissions%%>
							<option value="128" class="vendoradmin_role" %%GLOBAL_Selected_128%%> %%LNG_ManageUsers%%</option>
							<option value="129" class="vendoradmin_role" %%GLOBAL_Selected_129%%> %%LNG_AddUsers%%</option>
							<option value="130" class="vendoradmin_role" %%GLOBAL_Selected_130%%> %%LNG_EditUsers%%</option>
							<option value="131" class="vendoradmin_role" %%GLOBAL_Selected_131%%> %%LNG_DeleteUsers%%</option>
                            <option value="182" class="vendoradmin_role" %%GLOBAL_Selected_182%%> %%LNG_LoginCustomer%%</option>
                            
							<option value="175" %%GLOBAL_Selected_175%%> %%LNG_ManageVendors%%</option>
							<option value="167" %%GLOBAL_Selected_167%%> %%LNG_AddVendors%%</option>
							<option value="168" %%GLOBAL_Selected_168%%> %%LNG_EditVendors%%</option>
							<option value="169" %%GLOBAL_Selected_169%%> %%LNG_DeleteVendors%%</option>

							<option value="177" %%GLOBAL_Selected_177%%> %%LNG_ManageFormFields%%</option>
							<option value="178" %%GLOBAL_Selected_178%%> %%LNG_AddFormFields%%</option>
							<option value="179" %%GLOBAL_Selected_179%%> %%LNG_EditFormFields%%</option>
							<option value="180" %%GLOBAL_Selected_180%%> %%LNG_DeleteFormFields%%</option>

							<option value="126" %%GLOBAL_Selected_126%%> %%LNG_ManageSettings%%</option>

							<option value="155" class="vendoradmin_role" %%GLOBAL_Selected_155%%> %%LNG_ImportProducts%%</option>

							<option value="156" %%GLOBAL_Selected_156%%> %%LNG_ImportCustomers%%</option>

							<option value="166" class="vendoradmin_role" %%GLOBAL_Selected_166%%> %%LNG_ImportOrdertrackingnumbers%%</option>

							<option value="157" %%GLOBAL_Selected_157%%> %%LNG_ViewBackups%%</option>

							<option value="158" %%GLOBAL_Selected_158%%> %%LNG_StoreImporter%%</option>
							<option value="159" %%GLOBAL_Selected_159%%> %%LNG_StoreExporter%%</option>

							<option value="132" %%GLOBAL_Selected_132%%> %%LNG_ManageTemplates%%</option>
							<option value="153" %%GLOBAL_Selected_153%%> %%LNG_DesignMode%%</option>
							<option value="160" %%GLOBAL_Selected_160%%> %%LNG_StoreLogs%%</option>
							<option value="163" %%GLOBAL_Selected_163%%> %%LNG_Addons%%</option>

							<option value="165" %%GLOBAL_Selected_165%%> %%LNG_CustomerGroups%%</option>
							<option value="174" %%GLOBAL_Selected_174%%> %%LNG_SystemInfo%%</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp; <label for="StoreName">%%LNG_EnableXMLAPI%%?</label>
					</td>
					<td>
						<input type="checkbox" name="userapi" id="userapi" value="ON" %%GLOBAL_IsXMLAPI%% /> <label for="userapi">%%LNG_YesEnableXMLAPI%%</label>
						<img onmouseout="HideHelp('xmlapi');" onmouseover="ShowHelp('xmlapi', '%%LNG_EnableXMLAPI%%', '%%LNG_EnableXMLAPIHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="xmlapi"></div><br />
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" onclick="LaunchHelp(683)" style="color:gray">%%LNG_WhatIsXMLAPI%%</a><br/><br />
						<table cellspacing="0" cellpadding="2" border="0" class="panel" style="display: block;" id="sectionXMLToken" style="display:none">
							<tr>
								<td width="90">
									<img width="20" height="20" src="images/nodejoin.gif"/>&nbsp; %%LNG_XMLPath%%:
								</td>
								<td>
									<input type="text" readonly="" class="Field250" value="%%GLOBAL_XMLPath%%" id="xmlpath" name="xmlpath"/><img onmouseout="HideHelp('xmlpathhelp');" onmouseover="ShowHelp('xmlpathhelp', '%%LNG_XMLPath%%', '%%LNG_XMLPathHelp%%')" src="images/help.gif" width="24" height="16" border="0">
									<div style="display:none" id="xmlpathhelp"></div>
								</td>
							</tr>
							<tr>
								<td width="90">
									<img width="20" height="20" src="images/blank.gif"/>&nbsp; %%LNG_XMLToken%%:
								</td>
								<td>
									<input type="text" onfocus="select(this);" readonly="" class="Field250" value="%%GLOBAL_XMLToken%%" id="xmltoken" name="xmltoken"/> <img onmouseout="HideHelp('xmltokenhelp');" onmouseover="ShowHelp('xmltokenhelp', '%%LNG_XMLToken%%', '%%LNG_XMLTokenHelp%%')" src="images/help.gif" width="24" height="16" border="0">
									<div style="display:none" id="xmltokenhelp"></div>
								</td>
							</tr>
							<tr>
								<td>
									&nbsp;
								</td>
								<td>
									<a style="color: gray;" href="javascript:void(0)" id="regenlink">%%LNG_RegenerateToken%%</a>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				%%GLOBAL_StoreCreditPermission%%
				<tr>
					<td class="Gap">&nbsp;</td>
					<td class="Gap">
						<input type="submit" name="SaveButton2" value="%%LNG_Save%%" class="FormButton">&nbsp;
						<input type="button" name="CancelButton2" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()">
					</td>
				</tr>
				<tr><td class="Gap"></td></tr>
				<tr><td class="Gap"></td></tr>
				<tr><td class="Sep" colspan="2"></td></tr>
			 </table>
			</td>
		</tr>

	</table>

	</div>
	</form>

	<script type="text/javascript">
		function UpdateRole(role)
		{
			// Start our selections
			if(role == 'admin') {
				SetupSalesStaffPermissions(true);
				SetupSalesManagerPermissions(true);
				SetupSiteAdminPermissions(true);
			}
			else if(role == 'manager') {
				SetupSalesStaffPermissions(true);
				SetupSalesManagerPermissions(true);
				SetupSiteAdminPermissions(false);
			}
			else if(role == 'sales') {
				SetupSalesStaffPermissions(true);
				SetupSalesManagerPermissions(false);
				SetupSiteAdminPermissions(false);
			}
			else {
				// Revert all permissions
				SetupSalesStaffPermissions(false);
				SetupSalesManagerPermissions(false);
				SetupSiteAdminPermissions(false);

				// Now reselect based on the role
				$('.permission_select .'+role+'_role input').attr('checked', false);
				$('.permission_select .'+role+'_role input').trigger('click');
			}
		}

		function ConfirmCancel()
		{
			if(confirm("%%LNG_ConfirmCancelUser%%"))
				document.location.href = "index.php?ToDo=viewUsers";
		}

		function CheckUserForm()
		{
			var un = document.getElementById("username");
			var up1 = document.getElementById("userpass");
			var up2 = document.getElementById("userpass1");
			var ue = document.getElementById("useremail");

			if(un.value == "")
			{
				alert("%%LNG_UserEnterUsername%%");
				un.focus();
				return false;
			}

			if("%%GLOBAL_Adding%%" == "1")
			{
				if(up1.value == "")
				{
					alert("%%LNG_UserEnterPassword%%");
					up1.focus();
					return false;
				}

				if(up1.value != up2.value)
				{
					alert("%%LNG_UserPasswordsDontMatch%%");
					up2.focus();
					up2.select();
					return false;
				}
			}
			else
			{
				if( (up1.value != "" || up2.value != "") && (up1.value != up2.value))
				{
					alert("%%LNG_UserPasswordsDontMatch%%");
					up2.focus();
					up2.select();
					return false;
				}
			}

			if(ue.value.indexOf(".") == -1 || ue.value.indexOf("@") == -1)
			{
				alert("%%LNG_UserInvalidEmail%%");
				ue.focus();
				ue.select();
				return false;
			}

			if(!HasSelectedPermissions('sales') && !HasSelectedPermissions('manager') && !HasSelectedPermissions('admin')) {
				$('#permissions_sales').focus();
				alert("%%LNG_UserNoPermissions%%");
				return false;
			}

			// Everything is OK
			return true;
		}

		function HasSelectedPermissions(type) {
			if(g('permissions_'+type+'_old')) {
				var f = $('#permissions_'+type+'_old').val();
			}
			else {
				var f = $('#permissions_'+type).val();
			}
			return f;
		}

		function SetupSalesStaffPermissions(Status)
		{
			if(g('permissions_sales_old')) {
				if(g('permissions_sales_old').disabled != true) {
					$('#permissions_sales input').attr('checked', !Status);
					$('#permissions_sales input').trigger('click');
				}
			}
			else {
				$('#permissions_sales option').attr('selected', Status);
			}
		}

		function SetupSalesManagerPermissions(Status)
		{
			if(g('permissions_manager_old')) {
				if(g('permissions_manager_old').disabled != true) {
					$('#permissions_manager input').attr('checked', !Status);
					$('#permissions_manager input').trigger('click');
				}
			}
			else {
				$('#permissions_manager option').attr('selected', Status);
			}
		}

		function SetupSiteAdminPermissions(Status)
		{
			if(g('permissions_admin_old')) {
				if(g('permissions_admin_old').disabled != true) {
					$('#permissions_admin input').attr('checked', !Status);
					$('#permissions_admin input').trigger('click');
				}
			}
			else {
				$('#permissions_admin option').attr('selected', Status);
			}
		}

		function ToggleAPI(State) {
			if(State) {
				$('#sectionXMLToken').show();
			}
			else {
				$('#sectionXMLToken').hide();
			}
		}

		function RegenerateToken() {
			$.get("%%GLOBAL_ShopPath%%/admin/remote.php?w=generateAPIKey", null, function(data) { $('#xmltoken').val(data); } );
		}

		$(document).ready(function() {
			if("%%GLOBAL_IsXMLAPI%%" == 'checked="checked"') {
				ToggleAPI(true);
			}
			else {
				ToggleAPI(false);
			}
		});

		$('#userapi').click(function() {
			if($('#userapi').attr('checked')) {
				ToggleAPI(true);
				if($('#xmltoken').val() == '') {
					RegenerateToken();
				}
			}
			else {
				ToggleAPI(false);
			}
		});

		$('#regenlink').click(function() {
			RegenerateToken();
		});

	</script>
