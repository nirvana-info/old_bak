[#assign shiro=JspTaglibs["/WEB-INF/tld/shiro.tld"] /]
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>${message("admin.order.list")}</title>


<link href="${base}/resources/admin/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="${base}/resources/admin/js/jquery.js"></script>
<script type="text/javascript" src="${base}/resources/admin/js/common.js"></script>
<script type="text/javascript" src="${base}/resources/admin/js/list.js"></script>
<script type="text/javascript" src="${base}/resources/admin/layer-master/layer.js"></script>
<script type="text/javascript">
$().ready(function() {

	var $listForm = $("#listForm");
	var $filterSelect = $("#filterSelect");
	var $filterOption = $("#filterOption a");
	var $print = $("select[name='print']");
	var $export = $("select[name='export']");

	[@flash_message /]
	
	// 订单筛选
	$filterSelect.mouseover(function() {
		var $this = $(this);
		var offset = $this.offset();
		var $menuWrap = $this.closest("div.menuWrap");
		var $popupMenu = $menuWrap.children("div.popupMenu");
		$popupMenu.css({left: offset.left, top: offset.top + $this.height() + 2}).show();
		$menuWrap.mouseleave(function() {
			$popupMenu.hide();
		});
	});
	
	// 筛选选项
	$filterOption.click(function() {
		var $this = $(this);
		var $dest = $("#" + $this.attr("name"));
		if ($this.hasClass("checked")) {
			$dest.val("");
		} else {
			$dest.val($this.attr("val"));
		}
		$listForm.submit();
		return false;
	});
	
	// 打印选择
	$print.change(function() {
		var $this = $(this);
		if ($this.val() != "") {
			window.open($this.val());
		}
	});
	
	// 导出选择
	$export.change(function() {
		var $this = $(this);
		if ($this.val() != "") {
			$("#exportForm").find("input[name='id']").val($this.val());
			$("#exportForm").submit();
		}
	});

});
// 确认
function confirmOrder(obj){
	var $this = $(obj);
	var beginDate = getNowFormatDate(new Date("2015-01-01"));
	var endDate = getNowFormatDate(new Date());
	$("#confirmForm").find("input[name='id']").val($this.attr("orderid"));
	$.dialog({
		type: "warn",
		content: "${message("admin.order.confirmDialog")}",
		onOk: function() {
			$("#confirmForm").submit();
			//静态化商品页面
			$.ajax({
				url: "${base}/admin/static/build.jhtml",
				type: "POST",
				data: {buildType: "product" , beginDate: beginDate, endDate: endDate, first: 0, count: 9999},
				dataType: "json",
				cache: false,
				success: function(data) {
				}
			});
		}
	});
}
//日期格式输出yyyy-MM-dd
function getNowFormatDate(date) {
    var seperator1 = "-";
    var seperator2 = ":";
    var year = date.getFullYear();
    var month = date.getMonth() + 1;
    var strDate = date.getDate();
    if (month >= 1 && month <= 9) {
        month = "0" + month;
    }
    if (strDate >= 0 && strDate <= 9) {
        strDate = "0" + strDate;
    }
    var currentdate = year + seperator1 + month + seperator1 + strDate;
    return currentdate;
}
// 取消
function cancelOrder(obj){
	var $this = $(obj);
	$("#cancelForm").find("input[name='id']").val($this.attr("orderid"));
	$.dialog({
		type: "warn",
		content: "${message("admin.order.cancelDialog")}",
		onOk: function() {
			$("#cancelForm").submit();
		}
	});
}

function showSplitInfo(id){
	$.layer({
        type: 2,
        title: [
            '${message("admin.order.splitInfo")}', 
            'height:40px; color:#fff; border:none;' //customer config
        ], 
        border:[1],
        area: ['90%', '90%'],
        fadeIn: 300,
        iframe: {src: 'splitInfo.jhtml?orderId='+id},
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
	<div class="path">
		<a href="${base}/admin/common/index.jhtml">${message("admin.path.index")}</a> &raquo; ${message("admin.order.list")} <span>(${message("admin.page.total", page.total)})</span>
	</div>
	<form id="confirmForm" action="listConfirm.jhtml" method="post">
		<input type="hidden" name="id" value="" />
	</form>
	<form id="cancelForm" action="listCancel.jhtml" method="post">
		<input type="hidden" name="id" value="" />
	</form>
	<form id="exportForm" action="exportSplitInfo.jhtml" method="post">
		<input type="hidden" name="id" value="" />
	</form>
	<form id="listForm" action="list.jhtml" method="get">
		<input type="hidden" id="orderStatus" name="orderStatus" value="${orderStatus}" />
		<input type="hidden" id="paymentStatus" name="paymentStatus" value="${paymentStatus}" />
		<input type="hidden" id="shippingStatus" name="shippingStatus" value="${shippingStatus}" />
		<input type="hidden" id="hasExpired" name="hasExpired" value="[#if hasExpired??]${hasExpired?string("true", "false")}[/#if]" />
		<div class="bar">
			<div class="buttonWrap">
				<a href="javascript:;" id="deleteButton" class="iconButton disabled">
					<span class="deleteIcon">&nbsp;</span>${message("admin.common.delete")}
				</a>
				<a href="javascript:;" id="refreshButton" class="iconButton">
					<span class="refreshIcon">&nbsp;</span>${message("admin.common.refresh")}
				</a>
				<div class="menuWrap">
					<a href="javascript:;" id="filterSelect" class="button">
						${message("admin.order.filter")}<span class="arrow">&nbsp;</span>
					</a>
					<div class="popupMenu">
						<ul id="filterOption" class="check">
							<li>
								<a href="javascript:;" name="orderStatus" val="unconfirmed"[#if orderStatus == "unconfirmed"] class="checked"[/#if]>${message("Order.OrderStatus.unconfirmed")}</a>
							</li>
							<li>
								<a href="javascript:;" name="orderStatus" val="confirmed"[#if orderStatus == "confirmed"] class="checked"[/#if]>${message("Order.OrderStatus.confirmed")}</a>
							</li>
							<li>
								<a href="javascript:;" name="orderStatus" val="completed"[#if orderStatus == "completed"] class="checked"[/#if]>${message("Order.OrderStatus.completed")}</a>
							</li>
							<li>
								<a href="javascript:;" name="orderStatus" val="cancelled"[#if orderStatus == "cancelled"] class="checked"[/#if]>${message("Order.OrderStatus.cancelled")}</a>
							</li>
							<li class="separator">
								<a href="javascript:;" name="paymentStatus" val="unpaid"[#if paymentStatus == "unpaid"] class="checked"[/#if]>${message("Order.PaymentStatus.unpaid")}</a>
							</li>
							<li>
								<a href="javascript:;" name="paymentStatus" val="partialPayment"[#if paymentStatus == "partialPayment"] class="checked"[/#if]>${message("Order.PaymentStatus.partialPayment")}</a>
							</li>
							<li>
								<a href="javascript:;" name="paymentStatus" val="paid"[#if paymentStatus == "paid"] class="checked"[/#if]>${message("Order.PaymentStatus.paid")}</a>
							</li>
							<li>
								<a href="javascript:;" name="paymentStatus" val="partialRefunds"[#if paymentStatus == "partialRefunds"] class="checked"[/#if]>${message("Order.PaymentStatus.partialRefunds")}</a>
							</li>
							<li>
								<a href="javascript:;" name="paymentStatus" val="refunded"[#if paymentStatus == "refunded"] class="checked"[/#if]>${message("Order.PaymentStatus.refunded")}</a>
							</li>
							<li class="separator">
								<a href="javascript:;" name="shippingStatus" val="unshipped"[#if shippingStatus == "unshipped"] class="checked"[/#if]>${message("Order.ShippingStatus.unshipped")}</a>
							</li>
							<li>
								<a href="javascript:;" name="shippingStatus" val="partialShipment"[#if shippingStatus == "partialShipment"] class="checked"[/#if]>${message("Order.ShippingStatus.partialShipment")}</a>
							</li>
							<li>
								<a href="javascript:;" name="shippingStatus" val="shipped"[#if shippingStatus == "shipped"] class="checked"[/#if]>${message("Order.ShippingStatus.shipped")}</a>
							</li>
							<li>
								<a href="javascript:;" name="shippingStatus" val="partialReturns"[#if shippingStatus == "partialReturns"] class="checked"[/#if]>${message("Order.ShippingStatus.partialReturns")}</a>
							</li>
							<li>
								<a href="javascript:;" name="shippingStatus" val="returned"[#if shippingStatus == "returned"] class="checked"[/#if]>${message("Order.ShippingStatus.returned")}</a>
							</li>
							<li class="separator">
								<a href="javascript:;" name="hasExpired" val="true"[#if hasExpired?? && hasExpired] class="checked"[/#if]>${message("admin.order.hasExpired")}</a>
							</li>
							<li>
								<a href="javascript:;" name="hasExpired" val="false"[#if hasExpired?? && !hasExpired] class="checked"[/#if]>${message("admin.order.unexpired")}</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="menuWrap">
					<a href="javascript:;" id="pageSizeSelect" class="button">
						${message("admin.page.pageSize")}<span class="arrow">&nbsp;</span>
					</a>
					<div class="popupMenu">
						<ul id="pageSizeOption">
							<li>
								<a href="javascript:;"[#if page.pageSize == 10] class="current"[/#if] val="10">10</a>
							</li>
							<li>
								<a href="javascript:;"[#if page.pageSize == 20] class="current"[/#if] val="20">20</a>
							</li>
							<li>
								<a href="javascript:;"[#if page.pageSize == 50] class="current"[/#if] val="50">50</a>
							</li>
							<li>
								<a href="javascript:;"[#if page.pageSize == 100] class="current"[/#if] val="100">100</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="menuWrap">
				<div class="search">
					<span id="searchPropertySelect" class="arrow">&nbsp;</span>
					<input type="text" id="searchValue" name="searchValue" value="${page.searchValue}" maxlength="200" />
					<button type="submit">&nbsp;</button>
				</div>
				<div class="popupMenu">
					<ul id="searchPropertyOption">
						<li>
							<a href="javascript:;"[#if page.searchProperty == "sn"] class="current"[/#if] val="sn">${message("Order.sn")}</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<table id="listTable" class="list">
			<tr>
				<th class="check">
					<input type="checkbox" id="selectAll" />
				</th>
				<th>
					<a href="javascript:;" class="sort" name="sn">${message("Order.sn")}</a>
				</th>
				<th>
					<span>${message("Order.amount")}</span>
				</th>
				<th>
					<a href="javascript:;" class="sort" name="member">${message("Order.member")}</a>
				</th>
				<th class="hidden">
					<a href="javascript:;" class="sort" name="consignee">${message("Order.consignee")}</a>
				</th>
				<th class="hidden">
					<a href="javascript:;" class="sort" name="paymentMethodName">${message("Order.paymentMethodName")}</a>
				</th>
				<th>
					<a href="javascript:;" class="sort" name="shippingMethodName">${message("Order.shippingMethodName")}</a>
				</th>
				<th>
					<a href="javascript:;" class="sort" name="orderStatus">${message("Order.orderStatus")}</a>
				</th>
				<th class="hidden">
					<a href="javascript:;" class="sort" name="paymentStatus">${message("Order.paymentStatus")}</a>
				</th>
				<th class="hidden">
					<a href="javascript:;" class="sort" name="shippingStatus">${message("Order.shippingStatus")}</a>
				</th>
				<th>
					<a href="javascript:;" class="sort" name="combine">Combine or not</a>
				</th>
				<th>
					<a href="javascript:;" class="sort" name="createDate">${message("admin.common.createDate")}</a>
				</th>
				[@shiro.hasPermission name = "admin:print"]
					<th>
						<span>${message("admin.order.print")}</span>
					</th>
				[/@shiro.hasPermission]
				[@shiro.hasPermission name = "admin:print"]
					<th>
						<span>${message("admin.order.export")}</span>
					</th>
				[/@shiro.hasPermission]
				<th>
					<span>${message("admin.common.handle")}</span>
				</th>
			</tr>
			[#list page.content as order]
				<tr>
					<td>
						<input type="checkbox" name="ids" value="${order.id}" />
					</td>
					<td>
						${order.sn}
					</td>
					<td>
						${currency(order.amount, true)}
					</td>
					<td>
						${order.member.username}
					</td>
					<td class="hidden">
						${order.consignee}
					</td>
					<td class="hidden">
						${order.paymentMethodName}
					</td>
					<td>
						${order.shippingMethodName}
					</td>
					<td>
						${message("Order.OrderStatus." + order.orderStatus)}
						[#if order.expired]<span class="gray">(${message("admin.order.hasExpired")})</span>[/#if]
					</td>
					<td class="hidden">
						${message("Order.PaymentStatus." + order.paymentStatus)}
					</td>
					<td class="hidden">
						${message("Order.ShippingStatus." + order.shippingStatus)}
					</td>
					<td>
						[#if order.combine == true]
							Yes
						[#else]
							No
						[/#if]
					</td>
					<td>
						<span title="${order.createDate?string("yyyy-MM-dd HH:mm:ss")}">${order.createDate}</span>
					</td>
					[@shiro.hasPermission name = "admin:print"]
						<td>
							<select name="print">
								<option value="">${message("admin.common.choose")}</option>
								<option value="../print/order.jhtml?id=${order.id}">${message("admin.order.orderPrint")}</option>
								[#if order.splitItems?size>0]
								<option value="../print/splitInfo.jhtml?id=${order.id}">${message("admin.order.splitInfoPrint")}</option>
								[/#if]
								<option value="../print/product.jhtml?id=${order.id}">${message("admin.order.productPrint")}</option>
								<!--<option value="../print/shipping.jhtml?id=${order.id}">${message("admin.order.shippingPrint")}</option>
								<option value="../print/delivery.jhtml?orderId=${order.id}">${message("admin.order.deliveryPrint")}</option>-->
							</select>
						</td>
					[/@shiro.hasPermission]
					[@shiro.hasPermission name = "admin:print"]
						<td>
							<select name="export">
								<option value="">${message("admin.common.choose")}</option>
								[#if order.splitItems?size>0]
								<option value="${order.id}">${message("admin.order.splitInfoExport")}</option>
								[/#if]
							</select>
						</td>
					[/@shiro.hasPermission]
					<td>
						<a href="view.jhtml?id=${order.id}">[${message("admin.common.view")}]</a>
						<!--
						[#if !order.expired && order.orderStatus == "unconfirmed" && hasAuthentyApprove]
							<a href="edit.jhtml?id=${order.id}">[${message("admin.common.edit")}]</a>
						[#else]
							<span title="${message("admin.order.editNotAllowed")}">[${message("admin.common.edit")}]</span>
						[/#if]
						-->
						[#if !order.expired && order.orderStatus == "unconfirmed" && hasAuthentyApprove]
							<a href="javascript:" orderid="${order.id}" onclick="confirmOrder(this)">[${message("admin.order.confirm")}]</a>
							<a href="javascript:" orderid="${order.id}" onclick="cancelOrder(this)">[${message("admin.order.cancel")}]</a>
						[/#if]
						[#if order.splitItems?size>0]
						<a href="javascript:;" onclick="showSplitInfo(${order.id})">[${message("admin.order.splitInfo")}]</a>
						[/#if]
					</td>
				</tr>
			[/#list]
		</table>
		[@pagination pageNumber = page.pageNumber totalPages = page.totalPages]
			[#include "/admin/include/pagination.ftl"]
		[/@pagination]
	</form>
</body>
</html>