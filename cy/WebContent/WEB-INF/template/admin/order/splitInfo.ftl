<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>${message("admin.order.view")}</title>


<link href="${base}/resources/admin/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="${base}/resources/admin/js/jquery.js"></script>
<script type="text/javascript" src="${base}/resources/admin/js/jquery.tools.js"></script>
<script type="text/javascript" src="${base}/resources/admin/js/jquery.validate.js"></script>
<script type="text/javascript" src="${base}/resources/admin/js/jquery.lSelect.js"></script>
<script type="text/javascript" src="${base}/resources/admin/js/common.js"></script>
<script type="text/javascript" src="${base}/resources/admin/js/input.js"></script>
<script type="text/javascript">
$().ready(function() {

	[@flash_message /]
	
});
</script>
</head>
<body>
	<table class="input tabContent">
		<tr class="title">
			<th style="width: 130px;">
				${message("OrderItem.sn")}
			</th>
			<th style="width: 150px;">
				${message("OrderItem.name")}
			</th>
			<th style="width: 130px;">
				Quantity
			</th>
			<th style="width: 130px;">
				Total weight
			</th>
			<th style="width: 130px;">
				Total volume
			</th>
			<th style="width: 130px;">
				Internal/External
			</th>
			<th style="width: 130px;">
				Complant code
			</th>
			<th style="width: 130px;">
				SBU
			</th>
			<th style="width: 130px;">
				Entity
			</th>
			<th style="width: 130px;">
				Receiver
			</th>
			<th style="width: 300px;">
				Ship to
			</th>
			<th style="width: 130px;">
				Calculation method
			</th>
		</tr>
		[#list order.splitItems as splitItem]
			<tr>
				<td>
					${splitItem.orderItem.sn}
				</td>
				<td width="400">
					<span title="${splitItem.orderItem.fullName}">${abbreviate(splitItem.orderItem.fullName, 50, "...")}</span>
					[#if splitItem.orderItem.isGift]
						<span class="red">[${message("admin.order.gift")}]</span>
					[/#if]
				</td>
				<td>
					${splitItem.quantity}
				</td>
				<td>
					${currency(splitItem.weight)}
				</td>
				<td>
					${splitItem.volume}
				</td>
				<td>
					[#if splitItem.ternalType == 1]
					internal
					[#else]
					external
					[/#if]
				</td>
				<td>
					${splitItem.complantCode}
				</td>
				<td>
					${splitItem.sbu}
				</td>
				<td>
					${splitItem.entity}
				</td>
				<td>
					${splitItem.receiver.consignee}
				</td>
				<td>
					${splitItem.receiver.areaName}${splitItem.receiver.address}
				</td>
				<td>
					[#if splitItem.calculationMethod == 1]
						Weight
					[/#if]
					[#if splitItem.calculationMethod == 2]
						Volume
					[/#if]
				</td>
			</tr>
		[/#list]
	</table>
</body>
</html>