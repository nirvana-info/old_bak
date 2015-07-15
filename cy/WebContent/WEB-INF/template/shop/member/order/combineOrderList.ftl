<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>${message("shop.member.order.view")}</title>


<link href="${base}/resources/shop/css/common.css" rel="stylesheet" type="text/css" />
<link href="${base}/resources/shop/css/member.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="${base}/resources/shop/js/jquery.js"></script>
<script type="text/javascript" src="${base}/resources/shop/js/common.js"></script>
<script type="text/javascript" src="${base}/resources/shop/layer-master/layer.js"></script>
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

//弹出详情
function showOrderItemList(orderId, orderNo){
	$.layer({
        type: 2,
        title: [
            'Combine Info', 
            'height:40px; color:#fff; border:none;' //customer config
        ], 
        border:[1],
        area: ['65%', '70%'],
        fadeIn: 300,
        iframe: {src: 'combineOrderItemList.jhtml?orderId='+orderId+'&sn='+orderNo},
	    close: function(index){ //右上角关闭回调
	    	layer.close(index);
	    }, 
	    end: function(){
	    } 
    })
} 

</script>
</head>
<body>
	<div id="dialogOverlay" class="dialogOverlay"></div>
	[#assign current = "orderList" /]
	[#include "/shop/include/header.ftl" /]
	<div class="container member">
		[#include "/shop/member/include/navigation.ftl" /]
		<div class="span18 last">
			<div class="input order">
				<div id="dialog" class="dialog">
					<div id="close" class="close"></div>
					<ul>
						<li>${message("shop.member.order.time")}</li>
						<li>${message("shop.member.order.content")}</li>
					</ul>
					<div id="deliveryContent" class="deliveryContent"></div>
				</div>
				<div class="title"><a href="view.jhtml?sn=${order.sn}">View Order</a> | View Combine List</div>
					<table class="orderItem">
						<tr>
							<th>Order Number</th>
							<th>Create Date</th>
							<th>Original Amount</th>
							<th>Amount</th>
							<th>Cost Saving</th>
							<th>Detail</th>
						</tr>
						[#list combineOrderList as combineOrder]
							<tr>
								<td>
									${combineOrder.sn}
								</td>
								<td>
									${combineOrder.createDate}
								</td>
								<td>
									[#if combineOrder.oldAmount??]${currency(combineOrder.oldAmount, true)}[#else]￥0.00[/#if]
								</td>
			                    <td>
			                        [#if combineOrder.amount??]${currency(combineOrder.amount, true)}[#else]￥0.00[/#if]
			                    </td>
			                    <td>
			                        [#if combineOrder.amount??]${currency(combineOrder.oldAmount-combineOrder.amount, true)}[#else]￥0.00[/#if]
			                    </td>
			                    <td>
			                    	[#if combineOrder.member.id==order.member.id]
			                        <a href="javascript:;" onclick="showOrderItemList(${combineOrder.id},${order.sn})" style="color: blue;">View</a>
			                        [#else]
			                       	<del>View</del>
			                        [/#if]
			                    </td>
							</tr>
						[/#list]
						[#if combineOrderList??]
							<tr>
								<td colspan="2" align="right">
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
			                    <td>
			                        	
			                    </td>
							</tr>
						[#else]
						[/#if]
					</table>
			</div>
		</div>
	</div>
	[#include "/shop/include/footer.ftl" /]
</body>
</html>