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
<script type="text/javascript" src="${base}/resources/shop/layer-master/layer.js"></script>
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
	
	var $orderSplitForm = $("#orderSplitForm");
	var $addNewSplit = $("#addNewSplit");
	var $splitTable = $("#splitTable");
	var detailsIndex = ${(orderSplitItems?size)!"0"};
	var $submit = $("#submit");
	
	[@flash_message /]
	
	$addNewSplit.click(function() {
		var totalSplitQuantity = 0;
		var quantity = ${cartItem.quantity};
		$(".quantity").each(function(){
			totalSplitQuantity += parseInt($(this).val());
		});
		var surplusSplitQuantity = quantity-totalSplitQuantity;
		[@compress single_line = true]
			var trHtml = 
			'<tr>
				<td>
					<input type="hidden" id="id_'+detailsIndex+'" name="splitItems['+detailsIndex+'].id" value="0"/>
					<input type="hidden" id="cartItem_'+detailsIndex+'" name="splitItems['+detailsIndex+'].cartItem.id" value="${cartItem.id}"/>
							<input type="hidden" id="product_'+detailsIndex+'" name="splitItems['+detailsIndex+'].product.id" value="${productId}"/>
					<input type="text" class="quantity" id="quantity_'+detailsIndex+'" name="splitItems['+detailsIndex+'].quantity" value="'+surplusSplitQuantity+'" style="width: 90px;" />
				</td>
				<td>
					<input type="radio" id="ternalType_'+detailsIndex+'_1" name="splitItems['+detailsIndex+'].ternalType" checked="checked" value="1" onchange="ternalChange(this, '+detailsIndex+')" />internal
					<input type="radio" id="ternalType_'+detailsIndex+'_2" name="splitItems['+detailsIndex+'].ternalType" value="2" onchange="ternalChange(this, '+detailsIndex+')" />external
				</td>
				<td>
					<input type="text" class="hidden" id="complantCode_'+detailsIndex+'" name="splitItems['+detailsIndex+'].complantCode" value="" style="width: 90px;" />
				</td>
				<td>
					<select class="receiver" id="receiver_'+detailsIndex+'" name="splitItems['+detailsIndex+'].receiver.id" style="width:180px" >
						[#list member.receivers as receiver]
							<option value="${receiver.id}">${receiver.consignee}：${receiver.areaName}${receiver.address}</option>
						[/#list]
					</select>
				</td>
				<td>
					<select id="sbu_${item_index}" name="splitItems['+detailsIndex+'].sbu" style="width:90px" >
						[#list sbus as sbu]
							<option value="${sbu}">${sbu}</option>
						[/#list]
					</select>
				</td>
				<td>
					<select id="entity_${item_index}" name="splitItems['+detailsIndex+'].entity" style="width:90px" >
						[#list entities as entity]
							<option value="${entity}">${entity}</option>
						[/#list]
					</select>
				</td>
				<td>
					<a href="javascript:;" class="delete" onclick="deleteSplit(this, 0)">${message("shop.cart.delete")}</a>
				</td>
			</tr>';
		[/@compress]
		$splitTable.append(trHtml);
		detailsIndex ++;
	});
	
	$submit.click(function() {
		$orderSplitForm.submit();
	});
	
	$.validator.addClassRules({
		quantity: {
			required: true,
			min: 1,
			decimal: {
				integer: 12,
				fraction: 6
			}
		},
		complantCode: {
			required: true
		},
		receiver: {
			required: true
		}
	});
	
	// 表单验证
	$orderSplitForm.validate({
		rules: {
		},
		messages: {
		},
		submitHandler: function(form) {
			if($(".quantity").length==0){
				$.message("warn", "${message("shop.order.split.nodata")}");
				return;
			}else{
				var totalSplitQuantity = 0;
				var quantity = ${cartItem.quantity};
				$(".quantity").each(function(){
					totalSplitQuantity += parseInt($(this).val());
				});
				if(totalSplitQuantity!=quantity){
					$.message("warn", "${message("shop.order.split.max")}"+quantity+".");
					return;
				}
			}
			$.ajax({
				url: "orderSplit/save.jhtml",
				type: "POST",
				data: $orderSplitForm.serialize(),
				dataType: "json",
				cache: false,
				beforeSend: function() {
					$submit.prop("disabled", true);
				},
				success: function(data) {
					if (data.type == "success") {
						$.message("success", data.content);
						setTimeout(function() {
							document.location='orderSplitView.jhtml?cartToken=${cartToken}&productId=${productId}';
						}, 1000);
					} else {
						$.message("warn", data.content);
					}
				},
				complete: function() {
					$submit.prop("disabled", false);
				}
			});
		}
	});
});

function ternalChange(obj, index){
	var endPrice = ${cartItem.endPrice};
	if($(obj).val()=="2" && endPrice>155){
		$("#complantCode_"+index).show();
		$("#complantCode_"+index).addClass("complantCode");
	}else{
		$("#complantCode_"+index).val("");
		$("#complantCode_"+index).hide();
		$("#complantCode_"+index).removeClass("complantCode");
	}
}

function deleteSplit(obj, splitId){
	if(confirm("${message("shop.order.split.delete.confirm")}")){
		if(splitId==0){
			$(obj).parent().parent().remove();
		}else{
			//异步删除该条已经保存的拆分
			$.ajax({
				url: "cancelSplit.jhtml",
				type: "POST",
				data: "splitId="+splitId,
				dataType: "json",
				cache: false,
				success: function(data) {
					if (data.type == "success") {
						$.message("success", data.content);
						$(obj).parent().parent().remove();
					} else {
						$.message("warn", data.content);
					}
				}
			});
		}
	}
}
</script>
</head>
<body>
	<div class="container member">
		<div class="span18 last">
			<div class="list">
				<br/>
				<div class="splitOrder">
					<div class="titleMess"><label>${message("shop.order.product")}：</label>${cartItem.product.name}</div>
					<div class="titleMess"><label>${message("Product.weight")}：</label>${cartItem.weight}</div>
					<div class="titleMess"><label>${message("shop.order.price")}：</label>${currency(cartItem.endPrice, true)}</div>
				</div>
				<div class="splitOrder">
					<div class="titleMess"><label>${message("shop.order.quantity")}：</label>${cartItem.quantity}</div>
					<div class="titleMess"><label>${message("Product.volume")}：</label>${cartItem.volume}</div>
				</div>
				<div class="splitOrder">
					<div class="titleMess"><label>SBU：</label>${sbuStr}</div>
					<div class="titleMess"><label>Entity：</label>${entityStr}</div>
				</div>
				<br/>
				<form id="orderSplitForm" action="orderSplit/save.jhtml" method="post">
				<input type="hidden" name="cartItemId" value="${cartItem.id}"/>
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
							Ship to
						</th>
						<th>
							SBU
						</th>
						<th>
							Entity
						</th>
						<th>
							Action
						</th>
					</tr>
					[#list orderSplitItems as item]
					<tr>
						<td>
							<input type="hidden" id="id_${item_index}" name="splitItems[${item_index}].id" value="${item.id}"/>
							<input type="hidden" id="cartItem_${item_index}" name="splitItems[${item_index}].cartItem.id" value="${cartItem.id}"/>
							<input type="hidden" id="product_${item_index}" name="splitItems[${item_index}].product.id" value="${productId}"/>
							<input type="text" class="quantity" id="quantity_${item_index}" name="splitItems[${item_index}].quantity" value="${item.quantity}" style="width: 90px;" />
						</td>
						<td>
							<input type="radio" id="ternalType_${item_index}_1" name="splitItems[${item_index}].ternalType" [#if item.ternalType == 1]checked[/#if] value="1" onclick="ternalChange(this, ${item_index})" />internal
							<input type="radio" id="ternalType_${item_index}_2" name="splitItems[${item_index}].ternalType" [#if item.ternalType == 2]checked[/#if] value="2" onclick="ternalChange(this, ${item_index})" />external
						</td>
						<td>
							<input type="text" [#if (item.ternalType == 2 && cartItem.endPrice <= 155) || (item.ternalType == 1)]class="hidden"[/#if] id="complantCode_${item_index}" name="splitItems[${item_index}].complantCode" value="${item.complantCode}" style="width: 90px;"/>
						</td>
						<td>
							<select class="receiver" id="receiver_${item_index}" name="splitItems[${item_index}].receiver.id" style="width:180px" >
								[#list member.receivers as receiver]
									<option value="${receiver.id}"[#if item.receiver.id==receiver.id] selected="selected"[/#if]>${receiver.consignee}：${receiver.areaName}${receiver.address}</option>
								[/#list]
							</select>
						</td>
						<td>
							<select id="sbu_${item_index}" name="splitItems[${item_index}].sbu" style="width:90px" >
								[#list sbus as sbu]
									<option value="sbu"[#if item.sbu==sbu] selected="selected"[/#if]>${sbu}</option>
								[/#list]
							</select>
						</td>
						<td>
							<select id="entity_${item_index}" name="splitItems[${item_index}].entity" style="width:90px" >
								[#list entities as entity]
									<option value="entity"[#if item.entity==entity] selected="selected"[/#if]>${entity}</option>
								[/#list]
							</select>
						</td>
						<td>
							<a href="javascript:;" class="delete" onclick="deleteSplit(this, ${item.id})">${message("shop.cart.delete")}</a>
						</td>
					</tr>
					[/#list]
				</table>
				<div class="span24_1">
					<div class="bottom">
						<p><a href="javascript:;" id="addNewSplit" class="add">Add</a></p>
						<a href="javascript:;" id="submit" class="submit">${message("shop.order.submit")}</a>
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>