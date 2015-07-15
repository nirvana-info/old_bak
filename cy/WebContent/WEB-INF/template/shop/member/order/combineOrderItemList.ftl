<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>${message("shop.member.order.view")}</title>


<link href="${base}/resources/shop/css/common.css" rel="stylesheet" type="text/css" />
<link href="${base}/resources/shop/css/member.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="${base}/resources/shop/js/jquery.js"></script>
<script type="text/javascript" src="${base}/resources/shop/js/common.js"></script>
<script type="text/javascript">
$().ready(function() {

	var $dialogOverlay = $("#dialogOverlay");
	var $dialog = $("#dialog");
	var $close = $("#close");
	var $deliveryContent = $("#deliveryContent");
	var $cancel = $("#cancel");
	var $deliveryQuery = $("a.deliveryQuery");

	[@flash_message /]
	
	// 订单取消
	$cancel.click(function() {
		if (confirm("${message("shop.member.order.cancelConfirm")}")) {
			$.ajax({
				url: "cancel.jhtml?sn=${order.sn}",
				type: "POST",
				dataType: "json",
				cache: false,
				success: function(message) {
					if (message.type == "success") {
						location.reload(true);
					} else {
						$.message(message);
					}
				}
			});
		}
		return false;
	});
	
	// 物流动态
	$deliveryQuery.click(function() {
		var $this = $(this);
		$.ajax({
			url: "delivery_query.jhtml?sn=" + $this.attr("sn"),
			type: "GET",
			dataType: "json",
			cache: true,
			beforeSend: function() {
				$dialog.show();
				$dialogOverlay.show();
				$deliveryContent.html("${message("shop.member.order.loading")}");
			},
			success: function(data) {
				if (data.data != null) {
					var html = '<table>';
					$.each(data.data, function(i, item) {
						html += '<tr><th>' + item.time + '<\/th><td>' + item.context + '<\/td><\/tr>';
					});
					html += '<\/table>';
					$deliveryContent.html(html);
				} else {
					$deliveryContent.text(data.message);
				}
			}
		});
		return false;
	});
	
	// 关闭物流动态
	$close.click(function() {
		$dialog.hide();
		$dialogOverlay.hide();
	});

});
</script>
</head>
<body>
	<div id="dialogOverlay" class="dialogOverlay"></div>
	<div class="member">
		<div class="span18 last">
			<div class="input order" style="border: 0px solid #B0CDE0;padding: 10px 10px 10px;">
					<table class="orderItem">
						<tr>
							<th>Product Number</th>
							<th>Product Name</th>
							<th>Orginal Price</th>
							<th>Price</th>
							<th>Quantity</th>
							<th>Orginal Amount</th>
							<th>Amount</th>
							<th>Cost Saving</th>
						</tr>
						[#list combineOrderItemList as orderItem]
							<tr>
								<td>
									${orderItem.sn}
								</td>
								<td>
									${orderItem.name}
								</td>
								<td>
									[#if orderItem.oldPrice??]${currency(orderItem.oldPrice, true)}[#else]￥0.00[/#if]
								</td>
			                    <td>
			                        [#if orderItem.endPrice??]${currency(orderItem.endPrice, true)}[#else]￥0.00[/#if]
			                    </td>
			                    <td>
									${orderItem.quantity}
								</td>
								<td>
									[#if orderItem.oldPrice??]${currency(orderItem.oldPrice*orderItem.quantity, true)}[#else]￥0.00[/#if]
								</td>
			                    <td>
			                        [#if orderItem.endPrice??]${currency(orderItem.endPrice*orderItem.quantity, true)}[#else]￥0.00[/#if]
			                    </td>
			                    <td>
			                        [#if orderItem.oldPrice??]${currency((orderItem.oldPrice-orderItem.endPrice)*orderItem.quantity, true)}[#else]￥0.00[/#if]
			                    </td>
							</tr>
						[/#list]
						[#if combineOrderItemList??]
							<tr>
								<td colspan="5" align="right">
									Total：&nbsp;&nbsp;&nbsp;
								</td>
								<td>
									[#if oldPrice??]${currency(oldPrice, true)}[#else]￥0.00[/#if]
								</td>
			                    <td>
			                        [#if nowPrice??]${currency(nowPrice, true)}[#else]￥0.00[/#if]
			                    </td>
			                    <td>
			                       	[#if costSave??]${currency(costSave, true)}[#else]￥0.00[/#if]
			                    </td>
							</tr>
						[/#if]
					</table>
			</div>
		</div>
	</div>
</body>
</html>