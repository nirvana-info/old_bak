<form method="post" action="#" onsubmit="Order.ApproveReview(); return false;" id="ReviewDetails">
	<input type="hidden" name="orderId" value="%%GLOBAL_OrderId%%" />
	<div id="ModalTitle">
		%%LNG_ViewReview%% | Order#%%GLOBAL_OrderId%% (%%GLOBAL_OrderDate%%)
	</div>
	<div id="ModalContent" style="min-height: 100px; max-height: 400px;">
		<p class="MessageBox MessageBoxInfo">%%LNG_ViewReviewIntro%%</p>
		<br />
		<table class="GridPanel ShipmentTable" cellspacing="0" cellpadding="0">
			<tr class="Heading3">
				<td>%%LNG_ReviewFromCustomer%%</td>
			</tr>
		</table>
		<br />
		<div style="max-height: 250px; overflow: auto;">
			<table cellspacing="5" cellpadding="0" border="0" width="100%">
				%%GLOBAL_ReviewContent%%
			</table>
		</div>
	</div>
	<div id="ModalButtonRow">
		<div class="FloatLeft"><input class="CloseButton" type="button" value="%%LNG_Close%%" onclick="$.modal.close();" /></div>
		<img src="images/loading.gif" alt="" style="display: none" class="LoadingIndicator" />
		<input type="submit" style="display:%%GLOBAL_ShowApprove%%" class="Submit SubmitButton" value="%%LNG_Approve%%" />
	</div>
</form>