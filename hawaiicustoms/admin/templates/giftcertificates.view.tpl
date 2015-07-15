	<form enctype="multipart/form-data" action="index.php" id="frmSearch" method="get" onsubmit="return ValidateForm(CheckViewForm)">
	<input type="hidden" name="ToDo" value="searchGiftCertificatesRedirect" />
	<div class="BodyContainer">
	<table class="OuterPanel">
	  <tr>
		<td class="Heading1" id="tdHeading">%%LNG_CreateNewGiftCertificatesView%%</td>
		</tr>
		<tr>
		<td class="Intro">
			<p>%%LNG_GiftCertificateViewIntro%%</p>
			%%GLOBAL_Message%%
			<p><input type="submit" name="SubmitButton1" value="%%LNG_Save%%" class="FormButton">&nbsp; <input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()"></p>
		</td>
	  </tr>
		<tr>
			<td>
			  <table class="Panel">
				<tr>
				  <td class="Heading2" colspan=2>%%LNG_ViewDetails%%</td>
				</tr>
				<tr><td class="Gap"></td></tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span>&nbsp;%%LNG_NameThisView%%:
					</td>
					<td>
						<input type="text" id="viewName" name="viewName" class="Field250">
						<img onmouseout="HideHelp('d2');" onmouseover="ShowHelp('d2', '%%LNG_NameThisView%%', '%%LNG_NameThisGiftCertificatesViewHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="d2"></div>
					</td>
				</tr>
				<tr><td class="Gap" colspan="2"></td></tr>
			 </table>
			</td>
		</tr>
		<tr>
			<td>
			  <table class="Panel">
				<tr>
				  <td class="Heading2" colspan=2>%%LNG_AdvancedSearch%%</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_SearchKeywords%%:
					</td>
					<td>
						<input type="text" id="searchQuery" name="searchQuery" class="Field250">
						<img onmouseout="HideHelp('d1');" onmouseover="ShowHelp('d1', '%%LNG_SearchKeywords%%', '%%LNG_SearchKeywordsGiftCertificateHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="d1"></div>
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_GiftCertificateStatus%%:
					</td>
					<td>
						<select id="certificateStatus" name="certificateStatus" class="Field250">
							<option value="">%%LNG_ChooseAGiftCertificateStatus%%</option>
							%%GLOBAL_GiftCertificateStatusOptions%%
						</select>
					</td>
				</tr>
				<tr><td class="Gap" colspan="2"></td></tr>
			 </table>
			</td>
		</tr>
		<tr>
			<td>
			  <table class="Panel">
				<tr>
				  <td class="Heading2" colspan=2>%%LNG_SearchByRange%%</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_GiftCertificateId%%:
					</td>
					<td>
						%%LNG_SearchFrom%% &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="certificateFrom" name="certificateFrom" class="Field50"> %%LNG_SearchTo%%
						&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="certificateTo" name="certificateTo" class="Field50">
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_GiftCertificateAmount%%:
					</td>
					<td>
						%%LNG_SearchFrom%% &nbsp;%%GLOBAL_CurrencyTokenLeft%%&nbsp;<input type="text" id="amountFrom" name="amountFrom" class="Field50"> %%GLOBAL_CurrencyTokenRight%% %%LNG_SearchTo%%
						&nbsp;%%GLOBAL_CurrencyTokenLeft%%&nbsp;<input type="text" id="amountTo" name="amountTo" class="Field50"> %%GLOBAL_CurrencyTokenRight%%
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_GiftCertificateBalance%%:
					</td>
					<td>
						%%LNG_SearchFrom%% &nbsp;%%GLOBAL_CurrencyTokenLeft%%&nbsp;<input type="text" id="balanceFrom" name="balanceFrom" class="Field50"> %%GLOBAL_CurrencyTokenRight%% %%LNG_SearchTo%%
						&nbsp;%%GLOBAL_CurrencyTokenLeft%%&nbsp;<input type="text" id="balanceTo" name="balanceTo" class="Field50"> %%GLOBAL_CurrencyTokenRight%%
					</td>
				</tr>
				<tr><td class="Gap" colspan="2"></td></tr>
			 </table>
			</td>
		</tr>
		<tr>
			<td>
			  <table class="Panel">
				<tr>
				  <td class="Heading2" colspan=2>%%LNG_SearchByDate%%</td>
				</tr>
				<tr><td class="Gap"></td></tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_GiftCertificatePurchaseDate%%:
					</td>
					<td>
						<select name="dateRange" id="dateRange" onchange="ToggleRange()" class="Field250">
							<option value="">%%LNG_ChooseGiftCertificateDate%%</option>
							<option value="today">%%LNG_Today%%</option>
							<option value="yesterday">%%LNG_Yesterday%%</option>
							<option value="day">%%LNG_Last24Hours%%</option>
							<option value="week">%%LNG_Last7Days%%</option>
							<option value="month">%%LNG_Last30Days%%</option>
							<option value="this_month">%%LNG_ThisMonth%%</option>
							<option value="this_year">%%LNG_ThisYear%%</option>
							<option value="custom">%%LNG_CustomPeriod%%</option>
						</select>
						<div id="dateRangeCustom" style="margin-left: 30px; margin-top: 10px;">
							%%LNG_SearchFrom%% <input class="plain" name="fromDate" id="dc1" size="12" onfocus="this.blur()" readonly><a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fStartPop(g('dc1'),g('dc2'));return false;" HIDEFOCUS><img name="popcal" align="absmiddle" src="images/calbtn.gif" width="34" height="22" border="0" alt=""></a>
							%%LNG_SearchTo%% <input class="plain" name="toDate" id="dc2" size="12" onfocus="this.blur()" readonly><a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fEndPop(g('dc1'),g('dc2'));return false;" HIDEFOCUS><img name="popcal" align="absmiddle" src="images/calbtn.gif" width="34" height="22" border="0" alt=""></a>
						</div>
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_ExpiryDateRange%%:
					</td>
					<td>
						<select name="expiryRange" id="expiryRange" onchange="ToggleExpiryRange()" class="Field250">
							<option value="">%%LNG_ChooseGiftCertificateExpiryDate%%</option>
							<option value="today">%%LNG_Today%%</option>
							<option value="tomorrow">%%LNG_Yesterday%%</option>
							<option value="week">%%LNG_Next7Days%%</option>
							<option value="month">%%LNG_Next30Days%%</option>
							<option value="this_month">%%LNG_ThisMonth%%</option>
							<option value="next_month">%%LNG_NextMonth%%</option>
							<option value="this_year">%%LNG_ThisYear%%</option>
							<option value="next_year">%%LNG_NextYear%%</option>
							<option value="custom">%%LNG_CustomPeriod%%</option>
						</select>
						<div id="expiryRangeCustom" style="margin-left: 30px; margin-top: 10px;">
							%%LNG_SearchFrom%% <input class="plain" name="expiryFromDate" id="dc3" size="12" onfocus="this.blur()" readonly><a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fStartPop(g('dc3'),g('dc4'));return false;" HIDEFOCUS><img name="popcal" align="absmiddle" src="images/calbtn.gif" width="34" height="22" border="0" alt=""></a>
							%%LNG_SearchTo%% <input class="plain" name="expiryToDate" id="dc4" size="12" onfocus="this.blur()" readonly><a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fEndPop(g('dc3'),g('dc4'));return false;" HIDEFOCUS><img name="popcal" align="absmiddle" src="images/calbtn.gif" width="34" height="22" border="0" alt=""></a>
						</div>
					</td>
				</tr>
				<tr><td class="Gap" colspan="2"></td></tr>
			 </table>
			</td>
		</tr>
		<tr>
			<td>
			  <table class="Panel">
				<tr>
				  <td class="Heading2" colspan=2>%%LNG_SortOrder%%</td>
				</tr>
				<tr><td class="Gap"></td></tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_SortOrder%%:
					</td>
					<td>
						<select name="sortField" class="Field120">
							<option value="giftcertid">%%LNG_GiftCertificateId%%</option>
							<option value="giftcertcode">%%LNG_GiftCertificateCode%%</option>
							<option value="customername">%%LNG_GiftCertificatePurchasedBy%%</option>
							<option value="giftcertamount">%%LNG_GiftCertificateAmount%%</option>
							<option value="giftcertbalance">%%LNG_GiftCertificateBalance%%</option>
							<option value="giftcertdatepurchased">%%LNG_GiftCertificatePurchaseDate%%</option>
							<option value="giftcertstatus">%%LNG_GiftCertificateStatus%%</option>
						</select>
						in&nbsp;
						<select name="sortOrder" class="Field110">
						<option value="asc">%%LNG_AscendingOrder%%</option>
						<option value="desc">%%LNG_DescendingOrder%%</option>
					</td>
				</tr>
				<tr>
					<td class="Gap">&nbsp;</td>
					<td class="Gap"><input type="submit" name="SubmitButton1" value="%%LNG_Save%%" class="FormButton">&nbsp; <input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()">
					</td>
				</tr>
				<tr><td class="Gap" colspan="2"></td></tr>
				<tr><td class="Gap" colspan="2"></td></tr>
				<tr><td class="Sep" colspan="2"></td></tr>

			 </table>
			</td>
		</tr>
	</table>
	<iframe width=132 height=142 name="gToday:contrast:agenda.js" id="gToday:contrast:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;"></iframe>
	</div>
	</form>

	<script type="text/javascript">

		function ToggleRange()
		{
			var range = g('dateRange');
			if($('#dateRange').val() == "custom") {
				$('#dateRangeCustom').show();
			}
			else
			{
				$('#dateRangeCustom').hide();
			}
		}

		function ToggleExpiryRange()
		{
			var range = g('expiryRange');
			if($('#expiryRange').val() == "custom") {
				$('#expiryRangeCustom').show();
			}
			else
			{
				$('#expiryRangeCustom').hide();
			}
		}

		ToggleRange();
		ToggleExpiryRange();

		function ConfirmCancel() {
			if(confirm("%%LNG_ConfirmCancelSearch%%")) {
				history.go(-1);
			}
		}

		function CheckViewForm() {
			if($('#viewName').val() == "") {
				alert("%%LNG_EnterViewName%%");
				$('#viewName').focus();
				return false;
			}

			if($('#certificateFrom').val() != "" && isNaN($('#certificateFrom').val())) {
				alert("%%LNG_SearchEnterValidCertificateId%%");
				$('#certificateFrom').focus();
				$('#certificateFrom').select();
				return false;
			}

			if($('#certificateTo').val() != "" && isNaN($('#certificateTo').val())) {
				alert("%%LNG_SearchEnterValidCertificateId%%");
				$('#certificateTo').focus();
				$('#certificateTo').select();
				return false;
			}

			if($('#amountFrom').val() != "" && isNaN($('#amountFrom').val())) {
				alert("%%LNG_SearchEnterValidAmount%%");
				$('#amountFrom').focus();
				$('#amountFrom').select();
				return false;
			}

			if($('#amountTo').val() != "" && isNaN($('#amountTo').val())) {
				alert("%%LNG_SearchEnterValidAmount%%");
				$('#amountTo').focus();
				$('#amountTo').select();
				return false;
			}

			if($('#balanceFrom').val() != "" && isNaN($('#balanceFrom').val())) {
				alert("%%LNG_SearchEnterValidBalance%%");
				$('#balanceFrom').focus();
				$('#balanceFrom').select();
				return false;
			}

			if($('#balanceTo').val() != "" && isNaN($('#balanceTo').val())) {
				alert("%%LNG_SearchEnterValidBalance%%");
				$('#balanceTo').focus();
				$('#balanceTo').select();
				return false;
			}

			if($('#dateRange').val() == "custom" && $('#d1').val() == $('#d2').val()) {
				alert("%%LNG_SearchChooseDifferentDates%%");
				return false;
			}

			if($('#expiryRange').val() == "custom" && $('#d3').val() == $('#d4').val()) {
				alert("%%LNG_SearchChooseDifferentExpiryDates%%");
				return false;
			}

			return true;
		}

	</script>
