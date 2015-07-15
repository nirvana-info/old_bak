	<form enctype="multipart/form-data" action="index.php?ToDo=%%GLOBAL_FormAction%%" id="frmNews" method="post" onSubmit="return CheckDiscountRuleForm()">
	<input type="hidden" id="discountId" name="discountId" value="%%GLOBAL_DiscountId%%">
	<div id="discountWrapper">
	<div class="BodyContainer">
	<table class="OuterPanel">
	  <tr>
		<td class="Heading1" id="tdHeading">%%GLOBAL_Title%%</td>
		</tr>
		<tr>
		<td class="Intro">
			<p>%%GLOBAL_Intro%%</p>
			%%GLOBAL_Message%%
			<p><input type="submit" name="SubmitButton1" value="%%LNG_Save%%" class="FormButton">&nbsp; <input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()"></p>
		</td>
	  </tr>
		<tr>
			<td>
			  <table class="Panel">
				<tr>
				  <td class="Heading2" colspan=2>%%LNG_NewDiscountDetails%%</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">* </span>%%LNG_DiscountFormRuleName%%
					</td>
					<td>
						<input type="text" id="discountname" name="discountname" class="Field250" value="%%GLOBAL_DiscountName%%" />
						<br />
						<div class="aside" style="color:Gray; margin-bottom:10px">(Such as 'Free shipping on orders over $200'. This name is for your reference only)</div>
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_DiscountFormEnabled%%
					</td>
				<td class="PanelBottom">
						<label><input type="checkbox" name="enabled" id="enabled" value="1" %%GLOBAL_DiscountEnabledCheck%%>%%LNG_DiscountFormEnabledDescription%%</input></label>
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_DiscountFormRuleExpires%%
					</td>
				<td class="PanelBottom">
						<label> <input type="checkbox" name="discountruleexpires" id="discountruleexpires"  %%GLOBAL_DiscountExpiryCheck%% onclick="if(this.checked) { $('.DiscountExpiryFields').show(); } else { $('.DiscountExpiryFields').hide(); }" value="1" /> %%LNG_DiscountFormRuleExpiresDescription%%</label>
						<div style="display:none" id="rulexpires"></div>
						<div style="margin-top: 3px; padding-left:20px; %%GLOBAL_DiscountExpiryFields%%" class="DiscountExpiryFields">
							<img src="images/nodejoin.gif" style="vertical-align: middle; float:left;" /><div  style="float:left">
							<label><input name="discountruleexpiresuses" id="discountruleexpiresuses"  %%GLOBAL_DiscountMaxUsesCheck%% type="checkbox" onclick="$('#discountruleexpiresusesamount').attr('readonly', !$('#discountruleexpiresusesamount').attr('readonly'));"></input> %%LNG_DiscountFormUsesExpire%%</label><input name="discountruleexpiresusesamount" id="discountruleexpiresusesamount" class="Field50" %%GLOBAL_DiscountMaxUsesDisabled%% value="%%GLOBAL_DiscountMaxUses%%" onclick="$('#discountruleexpiresusesamount').attr('readonly', false);$('#discountruleexpiresuses').attr('checked', true);" /> %%LNG_DiscountFormUses%%<br />
							<label><input id="discountruleexpiresdate" name="discountruleexpiresdate"  %%GLOBAL_DiscountExpiryDateCheck%% type="checkbox"></input> %%LNG_DiscountFormDateExpire%%<input name="discountruleexpiresdateamount" id="discountruleexpiresdateamount" class="Field70" %%GLOBAL_DiscountExpiryDateDisabled%% value="%%GLOBAL_DiscountExpiryDate%%" onclick="$('#discountruleexpiresdate').attr('checked', true);if(self.gfPop)gfPop.fStartPop(document.getElementById('discountruleexpiresdateamount'),document.getElementById('dc2'));return false;" ></input></label><a href="javascript:void(0)" onclick="$('#discountruleexpiresdate').attr('checked', true);if(self.gfPop)gfPop.fStartPop(document.getElementById('discountruleexpiresdateamount'),document.getElementById('dc2'));return false;" HIDEFOCUS><img name="popcal" align="absmiddle" src="images/dateicon.gif" border="0" alt=""></a></div>
<iframe width=132 height=142 name="gToday:contrast:agenda.js" id="gToday:contrast:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;"></iframe>
								<input type="text" id="dc2" name="dc2" style="display:none">
						</div>
					</td>
				</tr>

				<tr style="padding-bottom:10px;">
					<td class="FieldLabel">
						<span class="Required">* </span>%%LNG_DiscountFormRuleType%%
					</td>
					<td>
						%%GLOBAL_RuleList%%
					</td>
				</tr>
			</table>

			<table border="0" cellspacing="0" cellpadding="2" width="100%" class="PanelPlain">
				<tr>
					<td width="200" class="FieldLabel">
						&nbsp;
					</td>
					<td>
						<input type="submit" value="%%LNG_Save%%" class="FormButton" />
						<input type="button" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()" />
					</td>
				</tr>
			</table>

			</td>
		</tr>
	</table>

	</div>
	</div>
	</form>



	<script type="text/javascript">

		var previous = %%GLOBAL_CurrentRule%%;

		function ConfirmCancel()
		{
			if(confirm("%%LNG_ConfirmCancelDiscount%%"))
				document.location.href = "index.php?ToDo=viewDiscounts";
		}

		function VendorSupport() {
				alert('%%LNG_DiscountVendorWarning%%');
		}

		function UpdateModule(module, vendor) {

			if (%%GLOBAL_Vendor%% && !vendor) {
				$('#'+module).attr('checked', false);
				$('#'+previous).attr('checked', true);
				alert('%%LNG_DiscountVendorWarning%%');
				return;
			}

			previous = module;

			if(module == '' || module == null) {
				return;
			}

			$.ajax({
				url: 'remote.php',
				method: 'post',
				data: 'w=GetRuleModuleProperties&module='+module,
				success: function(data) {
					$('.ruleWrapper').hide();
					$('.ruleSettings').html('');
					$('#ruleSettings'+module).html(data);
					$('#ruleWrapper'+module).show();
					$('.discountFirst').focus();

				}
			});
		}

		function CheckDiscountRuleForm()
		{
			var discountname = document.getElementById("discountname");
			var discountruleexpires = document.getElementById("discountruleexpires");
			var discountruleexpiresuses = document.getElementById("discountruleexpiresuses");
			var discountruleexpiresusesamount = document.getElementById("discountruleexpiresusesamount");
			var discountruleexpiresdate = document.getElementById("discountruleexpiresdate");
			var discountruleexpiresdateamount = document.getElementById("discountruleexpiresdateamount");
			var enabled = document.getElementById("enabled");

			var type = document.getElementsByName("RuleType");

			if(discountname.value == "") {
				alert("%%LNG_EnterDiscountName%%");
				discountname.focus();
				return false;
			}

			if (discountruleexpires.checked) {
				if (discountruleexpiresuses.checked) {
					if (isNaN(discountruleexpiresusesamount.value)) {
						alert("%%LNG_EnterDiscountExpiresUsesAmount%%");
						discountruleexpiresusesamount.focus();
						discountruleexpiresusesamount.select();
						return false;
					}
				}

				if (discountruleexpiresdate.checked) {
					if (discountruleexpiresdateamount.value == '' || new Date(discountruleexpiresdateamount.value) == 'Invalid Date') {
						alert("%%LNG_EnterDiscountExpiresDateAmount%%");
						discountruleexpiresdateamount.focus();
						discountruleexpiresdateamount.select();
						return false;
					}
				}
			}
			var checked = false;
			for (var i = 0; i < type.length; i++) {
				if (type[i].checked) {

					var response = eval(type[i].id + '();');

					checked = true;

					if (response != true)
						return response;

					break;
				}
			}

			if (!checked) {
				alert("%%LNG_EnterDiscountSelectRule%%");
				return false;
			}

			return true;
		}

		%%GLOBAL_DiscountJavascriptValidation%%

	</script>
