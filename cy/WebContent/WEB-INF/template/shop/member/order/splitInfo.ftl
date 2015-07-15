<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>${message("orderItem.product.split.view")}</title>


<link href="${base}/resources/shop/css/common.css" rel="stylesheet" type="text/css" />
<link href="${base}/resources/shop/css/member.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="${base}/resources/shop/js/jquery.js"></script>
<script type="text/javascript" src="${base}/resources/shop/js/jquery.tools.js"></script>
<script type="text/javascript" src="${base}/resources/shop/js/jquery.validate.js"></script>
<script type="text/javascript" src="${base}/resources/shop/js/common.js"></script>
<style>
div.container {
	width: 809px;
	margin: 0px auto;
}
div.container .span18 {
	width: 809px;
}
div.member div.list{
	border: none;
}
.splitOrder{
	height: 20px;
	line-height: 20px;
	vertical-align: middle;
}
.splitOrder label{
	font-weight: bold;	
}
.span24_1 {
	margin-right: 0px;
	margin-top: 20px;
}
.submit {
	padding: 14px;
	color: #ffffff;
	background-color: #0078AF;
}
.bottom {
	height: 30px;
	line-height: 30px;
	margin-bottom: 10px;
	text-align: right;
	overflow: hidden;
	border: 1px dotted #e4e4e4;
	background-color: #fdfdfd;
}
.bottom  p {
	line-height: 30px;
	margin-left: 30px;
	position: absolute;
}
.submit:hover {
	color: #ffffff;
	text-decoration: none;
}
div.member div.list p {
	padding: 0px 0px;
	color: #999999;
	text-align: center;
}
.back {
	margin-right: 10px;
}
.titleMess{
	float: left;
	width: 220px;
}
</style>
<script type="text/javascript">
$().ready(function() {
	
	[@flash_message /]
	
});
</script>
</head>
<body>
	<div class="container member">
		<div class="span18 last">
			<div class="list">
				<br/>
				<div class="splitOrder">
					<div class="titleMess"><label>${message("shop.order.product")}：</label>${orderItem.product.name}</div>
					<div class="titleMess"><label>${message("Product.weight")}：</label>${orderItem.weight}</div>
					<div class="titleMess"><label>${message("shop.order.price")}：</label>${currency(orderItem.endPrice, true)}</div>
				</div>
				<div class="splitOrder">
					<div class="titleMess"><label>${message("shop.order.quantity")}：</label>${orderItem.quantity}</div>
					<div class="titleMess"><label>${message("Product.volume")}：</label>${orderItem.volume}</div>
				</div>
				<br/>
				<table class="list" id="splitTable">
					<tr>
						<th>
							Quantity
						</th>
						<th>
							Internal/External
						</th>
						<th>
							Complant code
						</th>
						<th>
							SBU
						</th>
						<th>
							Entity
						</th>
						<th>
							Receiver
						</th>
						<th>
							Ship to
						</th>
						<th>
							Calculation method
						</th>
					</tr>
					[#list orderItem.splitItems as splitItem]
					<tr>
						<td>
						${splitItem.quantity}
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
			</div>
		</div>
	</div>
</body>
</html>