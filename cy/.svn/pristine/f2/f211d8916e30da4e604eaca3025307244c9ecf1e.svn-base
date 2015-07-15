[#assign shiro=JspTaglibs["/WEB-INF/tld/shiro.tld"] /]
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>${message("admin.order.combineList")}</title>


<link href="${base}/resources/admin/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="${base}/resources/admin/js/jquery.js"></script>
<script type="text/javascript" src="${base}/resources/admin/js/common.js"></script>
<script type="text/javascript" src="${base}/resources/admin/js/list.js"></script>
<script type="text/javascript" src="${base}/resources/admin/datePicker/WdatePicker.js"></script>
<script type="text/javascript" src="${base}/resources/shop/layer-master/layer.js"></script>
<script type="text/javascript">
$().ready(function() {

	[@flash_message /]
	
	// 订单筛选
	/*
	$filterSelect.mouseover(function() {
		var $this = $(this);
		var offset = $this.offset();
		var $menuWrap = $this.closest("div.menuWrap");
		var $popupMenu = $menuWrap.children("div.popupMenu");
		$popupMenu.css({left: offset.left, top: offset.top + $this.height() + 2}).show();
		$menuWrap.mouseleave(function() {
			$popupMenu.hide();
		});
	});*/

});
// 确认
function confirmOrder(obj){
	var $this = $(obj);
	$("#confirmForm").find("input[name='id']").val($this.attr("orderid"));
	$.dialog({
		type: "warn",
		content: "${message("admin.order.confirmDialog")}",
		onOk: function() {
			$("#confirmForm").submit();
		}
	});
}


function showSplitInfo(id,sn){
	$.layer({
        type: 2,
        title: [
            'Order Number：'+sn, 
            'height:40px; color:#fff; border:none;' //customer config
        ], 
        border:[1],
        area: ['90%', '90%'],
        fadeIn: 300,
        iframe: {src: 'combineOrderItemList.jhtml?orderId='+id},
	    close: function(index){ //右上角关闭回调
	    	layer.close(index);
	    }, 
	    end: function(){//终极销毁回调
	    	
	    } 
    })
}
</script>
</head>
<body>
	<form id="form" action="combineOrder.jhtml" method="post">
		<table id="listTable" class="list">
			<tr>
				<th class="check">
					No.
				</th>
				<th>
					<span>Order Number</span>
				</th>
				<th>
                    <span>Create Date</span>
				</th>
				<th>
                    <span>Orginal Amount</span>
				</th>
				<th>
                    <span>Amount</span>
				</th>
                <th>
                    <span>Cost Saving</span>
                </th>
				<th>
					<span>Detail</span>
				</th>
			</tr>
			[#list combineOrderList as order]
				<tr>
					<td>
						${order_index+1}
					</td>
					<td>
						${order.sn}
					</td>
					<td>
						${order.createDate}
					</td>
					<td>
						[#if order.oldAmount??]${currency(order.oldAmount, true)}[#else]￥0.00[/#if]
					</td>
                    <td>
                        [#if order.amount??]${currency(order.amount, true)}[#else]￥0.00[/#if]
                    </td>
                    <td>
                        [#if order.amount??]${currency(order.oldAmount-order.amount, true)}[#else]￥0.00[/#if]
                    </td>
                    <td>
                        <a href="javascript:;" onclick="showSplitInfo('${order.id}','${order.sn}')" style="color: blue;">View</a>
                    </td>
				</tr>
			[/#list]
			[#if combineOrderList??]
				<tr>
					<td colspan="3" align="right">
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
                        &nbsp;
                    </td>
				</tr>
			[#else]
			[/#if]
		</table>
	</form>
</body>
</html>