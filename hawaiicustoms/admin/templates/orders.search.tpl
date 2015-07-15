
	<form enctype="multipart/form-data" action="index.php" id="frmSearch" method="get" onsubmit="return ValidateForm(CheckSearchForm)">
	<input type="hidden" name="ToDo" value="searchOrdersRedirect" />
	<div class="BodyContainer">
	<table class="OuterPanel">
	  <tr>
		<td class="Heading1" id="tdHeading">%%LNG_SearchOrders%%</td>
		</tr>
		<tr>
		<td class="Intro">
			<p>%%LNG_SearchOrdersIntro%%</p>
			%%GLOBAL_Message%%
			<p><input type="submit" name="SubmitButton1" value="%%LNG_Search%%" class="FormButton">&nbsp; <input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()"></p>
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
						<img onmouseout="HideHelp('d1');" onmouseover="ShowHelp('d1', '%%LNG_SearchKeywords%%', '%%LNG_SearchKeywordsOrderHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="d1"></div>
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_OrderStatus1%%:
					</td>
					<td>
						<select id="orderStatus" name="orderStatus" class="Field250">
							<option value="">%%LNG_ChooseAnOrderStatus%%</option>
							%%GLOBAL_OrderStatusOptions%%
						</select>
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_PaymentMethod%%:
					</td>
					<td>
						<select id="paymentMethod" name="paymentMethod" class="Field250">
							<option value="">%%LNG_ChooseAPaymentMethod%%</option>
							%%GLOBAL_OrderPaymentOptions%%
						</select>
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_ShippingMethod%%:
					</td>
					<td>
						<select id="shippingMethod" name="shippingMethod" class="Field250">
							<option value="">%%LNG_ChooseAShippingMethod%%</option>
							%%GLOBAL_OrderShippingOptions%%
						</select>
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_CouponCode%%:
					</td>
					<td>
						<input type="text" name="couponCode" class="Field250" />
						<img onmouseout="HideHelp('couponcode');" onmouseover="ShowHelp('couponcode', '%%LNG_CouponCode%%', '%%LNG_OrderCouponCodeHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="couponcode"></div>
					</td>
				</tr>
				<!-- alandy_2012-3-28 add -->
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_OderOwner%%:
					</td>
					<td>
						<select id="orderOwner" name="orderOwner" class="Field250">
							<option value="">%%LNG_ChooseOderOwner%%</option>
							%%GLOBAL_OrderOwnerOptions%%
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
						&nbsp;&nbsp;&nbsp;%%LNG_OrderID%%:
					</td>
					<td>
						%%LNG_SearchFrom%% &nbsp;&nbsp;<input type="text" id="orderFrom" name="orderFrom" class="Field50"> %%LNG_SearchTo%%
						&nbsp;&nbsp;<input type="text" id="orderTo" name="orderTo" class="Field50">
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_OrderTotal%%:
					</td>
					<td>
						%%LNG_SearchFrom%% %%GLOBAL_CurrencyTokenLeft%%<input type="text" id="totalFrom" name="totalFrom" class="Field50"> %%GLOBAL_CurrencyTokenRight%% %%LNG_SearchTo%%
						%%GLOBAL_CurrencyTokenLeft%%<input type="text" id="totalTo" name="totalTo" class="Field50"> %%GLOBAL_CurrencyTokenRight%%
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
						&nbsp;&nbsp;&nbsp;%%LNG_DateRange%%:
					</td>
					<td>
						<select name="dateRange" id="dateRange" onchange="ToggleRange()" class="Field250">
							<option value="">%%LNG_ChooseOrderDate%%</option>
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
							%%LNG_SearchFrom%% <input class="plain" name="fromDate" id="dc1" size="12" onfocus="this.blur()" readonly><a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fStartPop(document.getElementById('dc1'),document.getElementById('dc2'));return false;" HIDEFOCUS><img name="popcal" align="absmiddle" src="images/calbtn.gif" width="34" height="22" border="0" alt=""></a>
							%%LNG_SearchTo%% <input class="plain" name="toDate" id="dc2" size="12" onfocus="this.blur()" readonly><a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fEndPop(document.getElementById('dc1'),document.getElementById('dc2'));return false;" HIDEFOCUS><img name="popcal" align="absmiddle" src="images/calbtn.gif" width="34" height="22" border="0" alt=""></a>
						</div>
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_SearchByDateType%%:
					</td>
					<td>
						<label><input name="SearchByDate" value="0" type="radio" checked="checked" />%%LNG_SearchByOrderDate%%</label><br />
						<label><input name="SearchByDate" value="1" type="radio" />%%LNG_SearchByEventDate%%</label><br />
						<label><input name="SearchByDate" value="2" type="radio" />%%LNG_SearchByOrderAndEventDate%%</label>
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
							<option value="orderid">%%LNG_OrderId%%</option>
							<option value="custname">%%LNG_Customer%%</option>
							<option value="orddate">%%LNG_Date%%</option>
							<option value="ordstats">%%LNG_Status%%</option>
							<option value="newmessages">%%LNG_NewMessages%%</option>
							<option value="ordtotalamount">%%LNG_Total%%</option>
						</select>
						in&nbsp;
						<select name="sortOrder" class="Field110">
						<option value="asc">%%LNG_AscendingOrder%%</option>
						<option value="desc">%%LNG_DescendingOrder%%</option>
					</td>
				</tr>
				<tr>
					<td class="Gap">&nbsp;</td>
					<td class="Gap"><input type="submit" name="SubmitButton1" value="%%LNG_Search%%" class="FormButton">&nbsp; <input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()">
					</td>
				</tr>
				<tr><td class="Gap" colspan="2"></td></tr>
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
			var range = document.getElementById('dateRange');
			if(range.options[range.selectedIndex].value == "custom")
			{
				document.getElementById('dateRangeCustom').style.display = '';
			}
			else
			{
				document.getElementById('dateRangeCustom').style.display = 'none';
			}
		}

		ToggleRange();

		function ConfirmCancel() {
			if(confirm("%%LNG_ConfirmCancelSearch%%"))
				document.location.href = "index.php?ToDo=viewOrders";
		}

		function CheckSearchForm() {
			var orderFrom = document.getElementById("orderFrom");
			var orderTo = document.getElementById("orderTo");
			var totalFrom = document.getElementById("totalFrom");
			var totalTo = document.getElementById("totalTo");
			var fromDate = document.getElementById("dc1");
			var toDate = document.getElementById("dc2");

			if(orderFrom.value != "" && isNaN(orderFrom.value)) {
				alert("%%LNG_SearchEnterValidOrderId%%");
				orderFrom.focus();
				orderFrom.select();
				return false;
			}

			if(orderTo.value != "" && isNaN(orderTo.value)) {
				alert("%%LNG_SearchEnterValidOrderId%%");
				orderTo.focus();
				orderTo.select();
				return false;
			}

			if(totalFrom.value != "" && isNaN(priceFormat(totalFrom.value))) {
				alert("%%LNG_SearchEnterValidTotal%%");
				totalFrom.focus();
				totalFrom.select();
				return false;
			}

			if(totalTo.value != "" && isNaN(priceFormat(totalTo.value))) {
				alert("%%LNG_SearchEnterValidTotal%%");
				totalTo.focus();
				totalTo.select();
				return false;
			}

			if(fromDate.value != "" && fromDate.value == toDate.value) {
				alert("%%LNG_SearchChooseDifferentDates%%");
				return false;
			}

			return true;
		}

	</script>
