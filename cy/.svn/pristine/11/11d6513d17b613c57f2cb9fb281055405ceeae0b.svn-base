<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>${message("admin.specialOrder.view")}</title>


<link href="${base}/resources/admin/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="${base}/resources/admin/js/jquery.js"></script>
<script type="text/javascript" src="${base}/resources/admin/js/jquery.tools.js"></script>
<script type="text/javascript" src="${base}/resources/admin/js/jquery.validate.js"></script>
<script type="text/javascript" src="${base}/resources/admin/js/jquery.lSelect.js"></script>
<script type="text/javascript" src="${base}/resources/admin/js/common.js"></script>
<script type="text/javascript" src="${base}/resources/admin/js/input.js"></script>
<script type="text/javascript">
$().ready(function() {

	var $confirmForm = $("#confirmForm");
	var $cancelForm = $("#cancelForm");
	var $confirmButton = $("#confirmButton");
	var $cancelButton = $("#cancelButton");
	
	[@flash_message /]
	
	// 通过
	$confirmButton.click(function() {
		var $this = $(this);
		$.dialog({
			type: "warn",
			content: "${message("admin.order.confirmDialog")}",
			onOk: function() {
				$confirmForm.submit();
			}
		});
	});
	
	// 取消
	$cancelButton.click(function() {
		var $this = $(this);
		$.dialog({
			type: "warn",
			content: "${message("admin.order.cancelDialog")}",
			onOk: function() {
				$cancelForm.submit();
			}
		});
	});

});
</script>
</head>
<body>
	<form id="confirmForm" action="confirm.jhtml" method="post">
		<input type="hidden" name="id" value="${specialOrders.id}" />
	</form>
	<form id="cancelForm" action="cancel.jhtml" method="post">
		<input type="hidden" name="id" value="${specialOrders.id}" />
	</form>
	<div class="path">
		<a href="${base}/admin/common/index.jhtml">${message("admin.path.index")}</a> &raquo; ${message("admin.specialOrder.view")}
	</div>
	<table class="input tabContent">
		[#if specialOrders.approveStatus==0]
		<tr>
			<td>
				&nbsp;
			</td>
			<td>
				<input type="button" id="confirmButton" class="button" value="${message("specialOrder.approveStatus.1")}"[#if specialOrders.approveStatus!=0] disabled="disabled"[/#if] />
				<input type="button" id="cancelButton" class="button" value="${message("specialOrder.approveStatus.2")}"[#if specialOrders.approveStatus!=0] disabled="disabled"[/#if] />
			</td>
			<td>
				&nbsp;
			</td>
			<td>
				&nbsp;
			</td>
		</tr>
		[/#if]
		<tr>
			<th>
				Name:
			</th>
			<td width="360">
				${specialOrders.name}
			</td>
			<th>
				${message("admin.common.createDate")}:
			</th>
			<td>
				${specialOrders.modifyDate?string("yyyy-MM-dd HH:mm:ss")}
			</td>
		</tr>
		<tr>
			<th>
				Title:
			</th>
			<td>
				${specialOrders.title}
			</td>
			<th>
				Phone:
			</th>
			<td>
				${specialOrders.phone}
			</td>
		</tr>
		<tr>
			<th>
				Fax:
			</th>
			<td>
				${specialOrders.fax}
			</td>
			<th>
				E-Mail:
			</th>
			<td>
				${specialOrders.email}
			</td>
		</tr>
		<tr>
			<th>
				Contact me via:
			</th>
			<td>
				[#if specialOrders.contactMeVia!=null]
				${specialOrders.contactMeVia.label}
				[/#if]
			</td>
			<th>
				Action:
			</th>
			<td>
				[#if specialOrders.action!=null]
				${specialOrders.action.label}
				[/#if]
			</td>
		</tr>
		<tr>
			<th>
				Event Name:
			</th>
			<td>
				${specialOrders.eventName}
			</td>
			<th>
				Event Type:
			</th>
			<td>
				[#if specialOrders.eventType!=null]
				${specialOrders.eventType.label}
				[/#if]
			</td>
		</tr>
		<tr>
			<th>
				Event Theme:
			</th>
			<td>
				${specialOrders.eventTheme}
			</td>
			<th>
				Budget:
			</th>
			<td>
				${specialOrders.budget}
			</td>
		</tr>
		<tr>
			<th>
				Event Date:
			</th>
			<td>
				${specialOrders.eventDate}
			</td>
			<th>
				Delivery Date:
			</th>
			<td>
				${specialOrders.deliveryDate}
			</td>
		</tr>
		<tr>
			<th>
				Item Description:
			</th>
			<td>
				${specialOrders.itemDescription}
			</td>
			<th>
				Decoration Method:
			</th>
			<td>
				[#if specialOrders.decorationMethod!=null]
				${specialOrders.decorationMethod.label}
				[/#if]
			</td>
		</tr>
		<tr>
			<th>
				Logo:
			</th>
			<td>
				${specialOrders.logo}
			</td>
			<th>
				Colors:
			</th>
			<td>
				${specialOrders.colors}
			</td>
		</tr>
		<tr>
			<th>
				Sizes:
			</th>
			<td>
				${specialOrders.sizes}
			</td>
			<th>
				Qty:
			</th>
			<td>
				${specialOrders.qty}
			</td>
		</tr>
		<tr>
			<th>
				Gift-Wrap:
			</th>
			<td>
				[#if specialOrders.giftWrap!=null]
				${specialOrders.giftWrap.label}
				[/#if]
			</td>
			<th>
				Thank-You Note:
			</th>
			<td>
				[#if specialOrders.thankYouNote!=null]
				${specialOrders.thankYouNote.label}
				[/#if]
			</td>
		</tr>
		<tr>
			<th>
				Thank-You Message:
			</th>
			<td>
				${specialOrders.thankYouMessage}
			</td>
			<th>
				Special Instructions:
			</th>
			<td>
				${specialOrders.specialInstructions}
			</td>
		</tr>
	</table>
	<table class="input">
		<tr>
			<th>
				&nbsp;
			</th>
			<td>
				<input type="button" class="button" value="${message("admin.common.back")}" onclick="location.href='list.jhtml'" />
			</td>
		</tr>
	</table>
</body>
</html>