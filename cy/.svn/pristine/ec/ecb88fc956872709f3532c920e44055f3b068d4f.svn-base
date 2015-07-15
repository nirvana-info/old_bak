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
</script>
</head>
<body>
	<form id="form" action="" method="post">
		<table id="listTable" class="list">
			<tr>
				<th class="check">
					No.
				</th>
				<th>
					<span>Product Number</span>
				</th>
				<th>
                    <span>Product Name</span>
				</th>
				<th>
                    <span>Orginal Price</span>
				</th>
				<th>
                    <span>Price</span>
				</th>
				<th>
                    <span>Quantity</span>
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
			</tr>
			[#list combineOrderItemList as orderItem]
				<tr>
					<td>
						${orderItem_index+1}
					</td>
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
					<td colspan="6" align="right">
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
			[#else]
			[/#if]
		</table>
	</form>
</body>
</html>