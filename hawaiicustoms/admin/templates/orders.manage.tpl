	<div class="BodyContainer">

	<table id="Table13" cellSpacing="0" cellPadding="0" width="100%">
		<tr>
			<td class="Heading1">
				%%LNG_View%%: <a href="#" style="color:#005FA3" id="ViewsMenuButton" class="PopDownMenu">%%GLOBAL_ViewName%% <img width="8" height="5" src="images/arrow_blue.gif" border="0" /></a>
			</td>
		</tr>
		<tr>
		<td class="Intro">
			<p>%%GLOBAL_OrderIntro%%</p>
			<div id="OrdersStatus">
				%%GLOBAL_Message%%
			</div>
			<table id="IntroTable" cellspacing="0" cellpadding="0" width="100%">
			<tr>
			<td class="Intro" valign="top">
				%%GLOBAL_AddOrderButton%%
				<div style="display: %%GLOBAL_DisplayGrid%%">
					<select id="OrderActionSelect" name="OrderActionSelect" class="Field200">
						%%GLOBAL_OrderActionOptions%%
					</select>
					<input type="button" id="OrderActionButton" name="OrderActionButton" value="%%LNG_OrderActionButton%%" class="FormButton" style="width:40px;" onclick="HandleOrderAction()" />
				</div>
			</td>
			<td class="SmallSearch" align="right">
				<table id="Table16" style="display:%%GLOBAL_DisplaySearch%%">
				<form name="frmOrders" id="frmOrders" action="index.php?ToDo=viewOrders%%GLOBAL_SortURL%%" method="get">
				<tr>
					<input type="hidden" name="ToDo" value="viewOrders">
					<td class="text" nowrap align="right">
						<input name="searchQuery" id="searchQuery" type="text" value="%%GLOBAL_Query%%" id="SearchQuery" class="SearchBox" style="width:150px" />&nbsp;
						<input type="image" name="SearchButton" id="SearchButton" src="images/searchicon.gif" border="0"  style="padding-left: 10px; vertical-align: top;" />
					</td>
				</tr>
				<tr>
					<td nowrap>
						<a href="index.php?ToDo=searchOrders">%%LNG_AdvancedSearch%%</a>
						<span style="display:%%GLOBAL_HideClearResults%%">| <a id="SearchClearButton" href="index.php?ToDo=viewOrders">%%LNG_ClearResults%%</a></span>
					</td>
				</tr>
				</form>
				</table>
			</td>
			</tr>
			</table>
		</td>
		</tr>
		<tr>
		<td style="display: %%GLOBAL_DisplayGrid%%">
			<form name="frmOrders1" id="frmOrders1" method="post" action="index.php?ToDo=deleteOrders">
				<div class="GridContainer" id="GridContainer">
					%%GLOBAL_OrderDataGrid%%
				</div>
			</form>
		</td></tr>
	</table>
	</div>
		<div id="ViewsMenu" class="DropDownMenu DropShadow" style="display: none; width:200px">
				<ul>
					%%GLOBAL_CustomSearchOptions%%
				</ul>
				<hr />
				<ul>
					<li><a href="index.php?ToDo=createOrderView" style="background-image:url('images/view_add.gif'); background-repeat:no-repeat; background-position:5px 5px; padding-left:28px">%%LNG_CreateANewView%%</a></li>
					<li style="display:%%GLOBAL_HideDeleteViewLink%%"><a onclick="$('#ViewsMenu').hide(); confirm_delete_custom_search('%%GLOBAL_CustomSearchId%%')" href="javascript:void(0)" style="background-image:url('images/view_del.gif'); background-repeat:no-repeat; background-position:5px 5px; padding-left:28px">%%LNG_DeleteThisView%%</a></li>
				</ul>
			</div>
		</div>
		</div>
		</div>
	</div>

	<script type="text/javascript">

		var tok = "%%GLOBAL_AuthToken%%";
		var delete_orders_choose_message = "%%LNG_ChooseOrder%%";
		var print_orders_choose_message = "%%LNG_ChooseOrderInvoice%%";
		var confirm_delete_orders_message = "%%LNG_ConfirmDeleteOrders%%";
		var order_status_update_success_message = "%%LNG_OrderStatusUpdated%%";
		var failed_order_status_update_message = "%%LNG_OrderStatusUpdateFailed%%";
		var confirm_update_order_status_message = "%%LNG_ConfirmUpdateOrderStatus%%";
		var trackingno_update_success_message = "%%LNG_TrackingNoUpdated%%";
		var trackingno_update_failed_message = "%%LNG_TrackingNoUpdateFailed%%";
		var delete_custom_search_message = "%%LNG_ConfirmDeleteCustomSearch%%";
		var update_order_status_choose_message = "%%LNG_ChooseOrderUpdateStatus%%";
		var choose_action_option = "%%LNG_ChooseActionFirst%%";
		var send_orderReview_request_message = "%%LNG_ChooseSendOrdReviewReq%%";

		lang.ChooseOneMoreItemsToShip = "%%LNG_ChooseOneMoreItemsToShip%%";
		lang.ProblemCreatingShipment = "%%LNG_ProblemCreatingShipment%%";
		lang.SavingNotes = "%%LNG_SavingNotes%%";
		lang.ConfirmDelayCapture = "%%LNG_ConfirmDelayCapture%%";
		lang.ConfirmRefund = "%%LNG_ConfirmRefund%%";
		lang.ConfirmVoid = "%%LNG_ConfirmVoid%%";
		lang.SelectRefundType = "%%LNG_SelectRefundType%%";
		lang.EnterRefundAmount = "%%LNG_EnterRefundAmount%%";
		lang.InvalidRefundAmountFormat = "%%LNG_InvalidRefundAmountFormat%%";
		lang.ProblemApproveReview = "%%LNG_ProblemApproveReview%%";

		function ClearCreditCardDetails(orderid) {
			$.ajax({
				url: 'remote.php?w=ClearCreditCardDetails&orderId='+orderid,
				success: function() {
					$('#CCDetails_'+orderid).remove()
				}
			});
		}

		var ExportAction = "%%GLOBAL_ExportAction%%";
	</script>
	<script type="text/javascript" src="script/order.js"></script>