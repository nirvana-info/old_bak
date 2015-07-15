
	<form enctype="multipart/form-data" action="index.php" id="frmSearch" method="get" onsubmit="return ValidateForm(CheckSearchForm)">
	<input type="hidden" name="ToDo" value="searchCustomersRedirect" />
	<div class="BodyContainer">
	<table class="OuterPanel">
	  <tr>
		<td class="Heading1" id="tdHeading">%%LNG_SearchCustomers%%</td>
		</tr>
		<tr>
		<td class="Intro">
			<p>%%LNG_SearchCustomersIntro%%</p>
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
						<img onmouseout="HideHelp('d1');" onmouseover="ShowHelp('d1', '%%LNG_SearchKeywords%%', '%%LNG_SearchKeywordsCustHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="d1"></div>
					</td>
				</tr>

				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_CustPhone%%:
					</td>
					<td>
						<input type="text" id="phone" name="phone" class="Field250">
					</td>
				</tr>

				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_CustCountry%%:
					</td>
					<td>
						<select name="country" id="country" class="Field250" onchange="GetStates(this, 'state', 'state_1')">
							<option value="">%%LNG_ChooseCustCountry%%</option>
							%%GLOBAL_CountryList%%
						</select>
					</td>
				</tr>

				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_CustState%%:
					</td>
					<td>
						<select style="display:%%GLOBAL_HideStateList%%" name="state" id="state" class="Field250">
							%%GLOBAL_StateList%%
						</select>
						<input style="display:%%GLOBAL_HideStateBox%%" type="text" name="state_1" id="state_1" value="%%GLOBAL_AddressState%%" class="Field250" />
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
						&nbsp;&nbsp;&nbsp;%%LNG_CustomerID%%:
					</td>
					<td>
						%%LNG_SearchFrom%% &nbsp;&nbsp;<input type="text" id="idFrom" name="idFrom" class="Field50"> %%LNG_SearchTo%%
						 &nbsp;&nbsp;<input type="text" id="idTo" name="idTo" class="Field50">
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_NumberOfOrders%%:
					</td>
					<td>
						%%LNG_SearchFrom%% &nbsp;&nbsp;<input type="text" id="ordersFrom" name="ordersFrom" class="Field50"> %%LNG_SearchTo%%
						 &nbsp;&nbsp;<input type="text" id="ordersTo" name="ordersTo" class="Field50">
					</td>
				</tr>

				<tr style="display: %%GLOBAL_HideStoreCredit%%">
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_StoreCredit%%:
					</td>
					<td>
						%%LNG_SearchFrom%% %%GLOBAL_CurrencyTokenLeft%%<input type="text" id="storeCreditFrom" name="storeCreditFrom" class="Field50" /> %%GLOBAL_CurrencyTokenRight%%
						%%LNG_SearchTo%% %%GLOBAL_CurrencyTokenLeft%%<input type="text" id="storeCreditTo" name="storeCreditTo" class="Field50" /> %%GLOBAL_CurrencyTokenRight%%
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
						&nbsp;&nbsp;&nbsp;%%LNG_DateJoined%%:
					</td>
					<td>
						<select name="dateRange" id="dateRange" onchange="ToggleRange()" class="Field250">
							<option value="">%%LNG_ChooseRegDate%%</option>
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
				<tr><td class="Gap" colspan="2"></td></tr>
			 </table>
			</td>
		</tr>
		<tr style="display: %%GLOBAL_HideCustomerGroups%%">
			<td>
			  <table class="Panel">
				<tr>
				  <td class="Heading2" colspan=2>%%LNG_SearchByGroup%%</td>
				</tr>
				<tr><td class="Gap"></td></tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_CustomerGroup%%:
					</td>
					<td>
						<select name="custGroupId" id="custGroupId" class="Field250">
							<option value="">%%LNG_ChooseACustomerGroup%%</option>
							%%GLOBAL_CustomerGroups%%
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
				  <td class="Heading2" colspan=2>%%LNG_SortOrder%%</td>
				</tr>
				<tr><td class="Gap"></td></tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_SortOrder%%:
					</td>
					<td>
						<select name="sortField" class="Field120">
							<option value="customerid">%%LNG_CustID%%</option>
							<option value="custconlastname">%%LNG_CustLastName%%</option>
							<option value="custconfirstname">%%LNG_CustFirstName%%</option>
							<option value="custconemail">%%LNG_Email%%</option>
							<option value="custconphone">%%LNG_Phone%%</option>
							<option value="custconcompany">%%LNG_CustCompany%%</option>
							<option value="custdatejoined">%%LNG_CustDateCreated%%</option>
							<option value="numorders">%%LNG_NumOrders%%</option>
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
			 </table>
			</td>
		</tr>
	</table>
	<iframe width=132 height=142 name="gToday:contrast:agenda.js" id="gToday:contrast:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;"></iframe>
	</div>
	</form>

	<script type="text/javascript" src="%%GLOBAL_ShopPath%%/javascript/callback.js"></script>

	<script type="text/javascript">
		function GetStates(selObj, dest, stateTextBox)
		{
			var country = selObj.options[selObj.selectedIndex].value;

			selDest = document.getElementById(dest);
			otherBox = document.getElementById(stateTextBox);
			DoCallback("w=countryStates&c="+country);
		}

		function ResetStates(ShowChoose)
		{
			selDest.options.length = 0;

			if(ShowChoose)
				selDest.options[selDest.options.length] = new Option("%%LNG_ChooseState%%", "");
		}

		function ProcessData(html)
		{
			ResetStates(true);
			states = html.split("~");
			numStates = 0;

			for(i = 0; i < states.length; i++)
			{
				vals = states[i].split("|");

				if(states[i].length > 0) {
					selDest.options[selDest.options.length] = new Option(vals[0], vals[1]);
					numStates++;
				}
			}

			// If there are no states then hide the state dropdown list
			if(numStates == 0) {
				selDest.style.display = "none";
				otherBox.style.display = "";
			}
			else {
				selDest.style.display = "";
				otherBox.style.display = "none";
			}
		}

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
				document.location.href = "index.php?ToDo=viewCustomers";
		}

		function CheckSearchForm() {
			var ordersFrom = document.getElementById("ordersFrom");
			var ordersTo = document.getElementById("ordersTo");

			if(ordersFrom.value != "" && isNaN(ordersFrom.value)) {
				alert("%%LNG_SearchEnterValidordersId%%");
				ordersFrom.focus();
				ordersFrom.select();
				return false;
			}

			if(ordersTo.value != "" && isNaN(ordersTo.value)) {
				alert("%%LNG_SearchEnterValidordersId%%");
				ordersTo.focus();
				ordersTo.select();
				return false;
			}

			var storeCreditFrom = document.getElementById("storeCreditFrom");
			var storeCreditTo = document.getElementById("storeCreditTo");

			if(storeCreditFrom.value != "" && isNaN(priceFormat(storeCreditFrom.value))) {
				alert("%%LNG_SearchEnterValidStoreCredit%%");
				storeCreditFrom.focus();
				storeCreditFrom.select();
				return false;
			}

			if(storeCreditTo.value != "" && isNaN(priceFormat(storeCreditTo.value))) {
				alert("%%LNG_SearchEnterValidStoreCredit%%");
				storeCreditTo.focus();
				storeCreditTo.select();
				return false;
			}

			return true;
		}

	</script>
