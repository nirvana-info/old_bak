<form action="index.php" id="frmSearch" method="get" onsubmit="return ValidateForm(CheckSearchForm)">
	<input type="hidden" name="ToDo" value="searchShipmentsRedirect" />
	<div class="BodyContainer">
		<table class="OuterPanel">
		  <tr>
			<td class="Heading1" id="tdHeading">%%LNG_CreateNewShipmentsView%%</td>
			</tr>
			<tr>
			<td class="Intro">
				<p>%%LNG_ShipmentViewIntro%%</p>
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
					<tr>
						<td class="FieldLabel">
							<span class="Required">*</span>&nbsp;%%LNG_NameThisView%%:
						</td>
						<td>
							<input type="text" id="viewName" name="viewName" class="Field250" />
							<img onmouseout="HideHelp('d2');" onmouseover="ShowHelp('d2', '%%LNG_NameThisView%%', '%%LNG_NameThisShipmentsViewHelp%%')" src="images/help.gif" border="0" />
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
							<img onmouseout="HideHelp('d1');" onmouseover="ShowHelp('d1', '%%LNG_SearchKeywords%%', '%%LNG_SearchKeywordsShipmentHelp%%')" src="images/help.gif" width="24" height="16" border="0">
							<div style="display:none" id="d1"></div>
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
							&nbsp;&nbsp;&nbsp;%%LNG_ShipmentId%%:
						</td>
						<td>
							%%LNG_SearchFrom%% &nbsp;&nbsp;
							<input type="text" id="shipmentFrom" name="shipmentFrom" class="Field50" />
							%%LNG_SearchTo%% &nbsp;&nbsp;
							<input type="text" id="shipmentTo" name="shipmentTo" class="Field50" />
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp;&nbsp;%%LNG_ShipmentOrderId%%:
						</td>
						<td>
							%%LNG_SearchFrom%% &nbsp;&nbsp;
							<input type="text" id="orderFrom" name="orderFrom" class="Field50" />
							%%LNG_SearchTo%% &nbsp;&nbsp;
							<input type="text" id="orderTo" name="orderTo" class="Field50" />
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
							&nbsp;&nbsp;&nbsp;%%LNG_ShipDateRange%%:
						</td>
						<td>
							<select name="shipdateRange" id="shipdateRange" onchange="ToggleRange($(this).val())" class="Field250">
								<option value="">%%LNG_ChooseShipDate%%</option>
								<option value="today">%%LNG_Today%%</option>
								<option value="yesterday">%%LNG_Yesterday%%</option>
								<option value="day">%%LNG_Last24Hours%%</option>
								<option value="week">%%LNG_Last7Days%%</option>
								<option value="month">%%LNG_Last30Days%%</option>
								<option value="this_month">%%LNG_ThisMonth%%</option>
								<option value="this_year">%%LNG_ThisYear%%</option>
								<option value="custom">%%LNG_CustomPeriod%%</option>
							</select>
							<div id="shipdateRangeCustom" style="margin-left: 30px; margin-top: 10px;">
								%%LNG_SearchFrom%%
								<input class="plain" name="shipdateFrom" id="dc1" size="12" onfocus="this.blur()" readonly="readonly" />
								<a href="#" onclick="if(self.gfPop)gfPop.fStartPop(document.getElementById('dc1'),document.getElementById('dc2'));return false;">
									<img name="popcal" align="absmiddle" src="images/calbtn.gif" border="0" alt="" />
								</a>
								%%LNG_SearchTo%%
								<input class="plain" name="shipdateTo" id="dc2" size="12" onfocus="this.blur()" readonly="readonly" />
								<a href="#" onclick="if(self.gfPop)gfPop.fEndPop(document.getElementById('dc1'),document.getElementById('dc2'));return false;">
									<img name="popcal" align="absmiddle" src="images/calbtn.gif" border="0" alt="" />
								</a>
							</div>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp;&nbsp;%%LNG_OrderDateRange%%:
						</td>
						<td>
							<select name="shiporderdateRange" id="shiporderdateRange" onchange="ToggleOrderRange($(this).val())" class="Field250">
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
							<div id="shiporderdateRangeCustom" style="margin-left: 30px; margin-top: 10px;">
								%%LNG_SearchFrom%%
								<input class="plain" name="shiporderdateFrom" id="dc3" size="12" onfocus="this.blur()" readonly="readonly" />
								<a href="#" onclick="if(self.gfPop)gfPop.fStartPop(document.getElementById('dc3'),document.getElementById('dc4'));return false;">
									<img name="popcal" align="absmiddle" src="images/calbtn.gif" border="0" alt="" />
								</a>
								%%LNG_SearchTo%%
								<input class="plain" name="shiporderdateTo" id="dc4" size="12" onfocus="this.blur()" readonly="readonly" />
								<a href="#" onclick="if(self.gfPop)gfPop.fEndPop(document.getElementById('dc3'),document.getElementById('dc4'));return false;">
									<img name="popcal" align="absmiddle" src="images/calbtn.gif" border="0" alt="" />
								</a>
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
					  <td class="Heading2" colspan="2">%%LNG_SortOrder%%</td>
					</tr>
					<tr><td class="Gap"></td></tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp;&nbsp;%%LNG_SortOrder%%:
						</td>
						<td>
							<select name="sortField" class="Field120">
								<option value="shipmentid">%%LNG_ShipmentId%%</option>
								<option value="shipdate">%%LNG_DateShipped%%</option>
								<option value="shiporderid">%%LNG_ShipmentOrderId%%</option>
								<option value="shiporderdate">%%LNG_ShipmentOrderDate%%</option>
								<option value="shipfllname">%%LNG_ShippedTo%%</option>
							</select>
							in&nbsp;
							<select name="sortOrder" class="Field110">
							<option value="asc">%%LNG_AscendingOrder%%</option>
							<option value="desc">%%LNG_DescendingOrder%%</option>
						</td>
					</tr>
					<tr>
						<td class="Gap">&nbsp;</td>
						<td class="Gap">
							<input type="submit" value="%%LNG_Save%%" class="FormButton" />&nbsp;
							<input type="button" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()" />
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

	function ToggleRange(value)
	{
		if(value == 'custom') {
			$('#shipdateRangeCustom').show();
		}
		else {
			$('#shipdateRangeCustom').hide();
		}
	}

	function ToggleOrderRange(value)
	{
		if(value == 'custom') {
			$('#shiporderdateRangeCustom').show();
		}
		else {
			$('#shiporderdateRangeCustom').hide();
		}
	}

	$(document).ready(function() {
		ToggleRange($('#shipdateRange').val());
		ToggleOrderRange($('#shiporderdateRange').val());
	});

	function ConfirmCancel() {
		if(confirm("%%LNG_ConfirmCancelSearch%%"))
			window.location = "index.php?ToDo=viewShipments";
	}

	function CheckSearchForm() {
		if(!$('#viewName').val()) {
			alert('%%LNG_EnterViewName%%');
			$('#viewName').focus();
			return false;
		}

		if($('#shipmentFrom').val() != '' && isNaN($('#shipmentFrom').val())) {
			alert('%%LNG_SearchEnterValidShipmentId%%');
			$('#shipmentFrom').focus();
			$('#shipmentFrom').select();
			return false;
		}

		if($('#shipmentTo').val() != '' && isNaN($('#shipmentTo').val())) {
			alert('%%LNG_SearchEnterValidShipmentId%%');
			$('#shipmentTo').focus();
			$('#shipmentTo').select();
			return false;
		}

		if($('#orderFrom').val() != '' && isNaN($('#orderFrom').val())) {
			alert('%%LNG_SearchEnterValidOrderId%%');
			$('#orderFrom').focus();
			$('#orderFrom').select();
			return false;
		}

		if($('#orderTo').val() != '' && isNaN($('#orderTo').val())) {
			alert('%%LNG_SearchEnterValidOrderId%%');
			$('#orderTo').focus();
			$('#orderTo').select();
			return false;
		}

		return true;
	}
</script>