<form method="post" action="#" onsubmit="Order.SaveShipment(); return false;" id="ShipmentDetails">
	<input type="hidden" name="orderId" value="%%GLOBAL_OrderId%%" />
	<div id="ModalTitle">
		%%LNG_CreateShipmentFromOrder%% #%%GLOBAL_OrderId%% (%%GLOBAL_OrderDate%%)
	</div>
	<div id="ModalContent" style="min-height: 100px; max-height: 400px; overflow: auto;">
		<p class="MessageBox MessageBoxInfo">%%LNG_CreateShipmentIntro%%</p>
		<br />
		<table class="GridPanel ShipmentTable" cellspacing="0" cellpadding="0">
			<tr class="Heading3">
				<td>%%LNG_ShipmentProduct%%</td>
				<td style="width: 100px; text-align: center;">%%LNG_QtyToShip%%</td>
			</tr>
			%%GLOBAL_ProductList%%
		</table>
		<br />
		<strong style="color: #000">%%LNG_ShipmentOptions%%</strong>
		<table cellspacing="5" cellpadding="0" border="0" width="100%">
			<tr>
				<td class="FieldLabel">%%LNG_ShippingMethod%%:</td>
				<td>
					<input type="text" class="Field300" name="shipmethod" value="%%GLOBAL_ShippingMethod%%" />
				</td>
			</tr>

			<tr>
				<td class="FieldLabel">%%LNG_TrackingNumber%%:</td>
				<td>
					<input type="text" class="Field300" name="shiptrackno" value="%%GLOBAL_TrackingNumber%%" />
				</td>
			</tr>

			<tr>
				<td class="FieldLabel">%%LNG_ShipmentComments%%:</td>
				<td>
					<textarea name="shipcomments" cols="10" rows="4" class="Field300">%%GLOBAL_OrderComments%%</textarea>
				</td>
			</tr>

			<tr>
				<td class="FieldLabel">%%LNG_OrderStatus%%:</td>
				<td style="padding-top: 4px;"><label><input type="checkbox" name="ordstatus" value="1" checked="checked" /> %%LNG_UpdateOrderStatus%%</label></td>
			</tr>
		</table>
	</div>
	<div id="ModalButtonRow">
		<div class="FloatLeft"><input class="CloseButton" type="button" value="%%LNG_Close%%" onclick="$.modal.close();" /></div>
		<img src="images/loading.gif" alt="" style="display: none" class="LoadingIndicator" />
		<input type="submit" class="Submit SubmitButton" value="%%LNG_CreateShipment%%" />
	</div>
</form>