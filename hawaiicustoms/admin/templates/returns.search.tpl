	<form enctype="multipart/form-data" action="index.php" id="frmSearch" method="get" onsubmit="return ValidateForm(CheckSearchForm)">
	<input type="hidden" name="ToDo" value="searchReturnsRedirect" />
	<div class="BodyContainer">
	<table class="OuterPanel">
	  <tr>
		<td class="Heading1" id="tdHeading">%%LNG_SearchReturns%%</td>
		</tr>
		<tr>
		<td class="Intro">
			<p>%%LNG_SearchReturnsIntro%%</p>
			%%GLOBAL_Message%%
			<p><input type="submit" name="SubmitButton1" value="%%LNG_Save%%" class="FormButton">&nbsp; <input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()"></p>
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
						<img onmouseout="HideHelp('d1');" onmouseover="ShowHelp('d1', '%%LNG_SearchKeywords%%', '%%LNG_SearchKeywordsReturnHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="d1"></div>
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_ReturnStatus%%:
					</td>
					<td>
						<select id="orderStatus" name="orderStatus" class="Field250">
							<option value="">%%LNG_ChooseAReturnStatus%%</option>
							%%GLOBAL_ReturnStatusOptions%%
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
						&nbsp;&nbsp;&nbsp;%%LNG_ReturnId%%:
					</td>
					<td>
						%%LNG_SearchFrom%% &nbsp;&nbsp;<input type="text" id="returnFrom" name="returnFrom" class="Field50"> %%LNG_SearchTo%%
						&nbsp;&nbsp;<input type="text" id="returnTo" name="returnTo" class="Field50">
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
							%%LNG_SearchFrom%% <input class="plain" name="fromDate" id="dc1" size="12" onfocus="this.blur()" readonly><a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fStartPop(g('dc1'),g('dc2'));return false;" HIDEFOCUS><img name="popcal" align="absmiddle" src="images/calbtn.gif" width="34" height="22" border="0" alt=""></a>
							%%LNG_SearchTo%% <input class="plain" name="toDate" id="dc2" size="12" onfocus="this.blur()" readonly><a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fEndPop(g('dc1'),g('dc2'));return false;" HIDEFOCUS><img name="popcal" align="absmiddle" src="images/calbtn.gif" width="34" height="22" border="0" alt=""></a>
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
							<option value="returnid">%%LNG_ReturnId%%</option>
							<option value="custname">%%LNG_Customer%%</option>
							<option value="retdaterequested">%%LNG_Date%%</option>
							<option value="retstatus">%%LNG_Status%%</option>
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

		ToggleRange();

		function ConfirmCancel() {
			if(confirm("%%LNG_ConfirmCancelSearch%%")) {
				history.go(-1);
			}
		}

		function CheckSearchForm() {
			if($('#returnFrom').val() != "" && isNaN($('#returnFrom').val())) {
				alert("%%LNG_SearchEnterValidOrderId%%");
				orderFrom.focus();
				orderFrom.select();
				return false;
			}

			if($('#returnTo').val() != "" && isNaN($('#returnTo').val())) {
				alert("%%LNG_SearchEnterValidOrderId%%");
				orderTo.focus();
				orderTo.select();
				return false;
			}

			if($('#fromDate').val() == "custom" && $('#d1').val() == $('#d2').val()) {
				alert("%%LNG_SearchChooseDifferentDates%%");
				return false;
			}

			return true;
		}

	</script>
