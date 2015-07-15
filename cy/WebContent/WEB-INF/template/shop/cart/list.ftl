<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>${message("shop.cart.title")}</title>


<link href="${base}/resources/shop/css/common.css" rel="stylesheet" type="text/css" />
<link href="${base}/resources/shop/css/cart.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="${base}/resources/shop/js/jquery.js"></script>
<script type="text/javascript" src="${base}/resources/shop/js/common.js"></script>
<script type="text/javascript">
$().ready(function() {

	var $quantity = $("input[name='quantity']");
	var $increase = $("span.increase");
	var $decrease = $("span.decrease");
	var $delete = $("a.delete");
	var $giftItems = $("#giftItems");
	var $promotion = $("#promotion");
	var $effectivePoint = $("#effectivePoint");
	var $effectivePrice = $("#effectivePrice");
	var $endEffectivePrice = $("#endEffectivePrice");
	var $totalWeight = $("#totalWeight");
	var $totalVolume = $("#totalVolume");
	var $clear = $("#clear");
	var $deleteSelect = $("a.deleteSelect");
	var $submit = $("#submit");
	var $gradientArr = new Array();
	var $hasGradientPrice=false;
	var timeouts = {};
	var $selectAll = $("#selectAll");
	//封装阶梯定价
	[@compress single_line = true]
	[#if cart?? && cart.cartItems?has_content]
		[#list cart.cartItems as cartItem]
			[#if cartItem.product.gradientLists?has_content]
				$hasGradientPrice = true;
				[#list cartItem.product.gradientLists as gradient]
					var item = new Object();
					item.id = "${cartItem.id}";
					item.startQuantity = "${gradient.startQuantity}";
					var endQuantityNum = ${gradient.endQuantity};
					if(endQuantityNum==0){
						endQuantityNum=99999999;
					}
					item.endQuantity = endQuantityNum;
					item.price = "${gradient.price}";
					$gradientArr.push(item);
				[/#list]
				var buyNum = ${cartItem.quantity};
				calculationPrice(${cartItem.id},buyNum);
			[/#if]
		[/#list]
	[/#if]
	[/@compress]
	
	//根据数量计算最终价格
	function calculationPrice(citemId,num){
		for(var i=0;i<$gradientArr.length;i++){
			if($gradientArr[i].id==citemId){
				var startQuantity = $gradientArr[i].startQuantity;
				var endQuantity = $gradientArr[i].endQuantity;
				var price = $gradientArr[i].price;
				if(num>=parseInt(startQuantity) && num<=parseInt(endQuantity)){
					$("#"+citemId+" .newPrice").text(currency(price, true));
					$("."+citemId+" .subtotal").text(currency(price*num, true));
					break;
				}
			}
		}
	}
	
	// 初始数量
	$quantity.each(function() {
		var $this = $(this);
		$this.data("value", $this.val());
	});
	
	// 数量
	$quantity.keypress(function(event) {
		var key = event.keyCode ? event.keyCode : event.which;
		if ((key >= 48 && key <= 57) || key==8) {
			return true;
		} else {
			return false;
		}
	});
	
	// 增加数量
	$increase.click(function() {
		var lowQuantity = $(this).parent().siblings("input:eq(0)").val();//起购数量
		var $quantity = $(this).parent().siblings("input:eq(1)");
		var quantity = $quantity.val();
		if (/^\d*[1-9]\d*$/.test(quantity)) {
			$quantity.val(parseInt(quantity) + 1);
		} else {
			$quantity.val(1);
		}
		edit($quantity);
	});
	
	// 减少数量
	$decrease.click(function() {
		var lowQuantity = $(this).parent().siblings("input:eq(0)").val();//起购数量
		var $quantity = $(this).parent().siblings("input:eq(1)");
		var quantity = $quantity.val();
		if (/^\d*[1-9]\d*$/.test(quantity) && parseInt(quantity) > 1) {
			if(parseInt(quantity)<=parseInt(lowQuantity)){
				$.message("warn", "${message("shop.product.lowQuantityWarn")}:<span class='custom'>"+lowQuantity+"</span>");
				$quantity.val(lowQuantity);
			}else{
				$quantity.val(parseInt(quantity) - 1);
			}
		} else {
			$quantity.val(lowQuantity);
		}
		edit($quantity);
	});
	
	// 编辑数量
	$quantity.bind("input propertychange change", function(event) {
		//if (event.type != "propertychange" || event.originalEvent.propertyName == "value") {
		//	var lowQuantity = $(this).siblings("input").val();//起购数量
		//	var quantity = $(this).val();
		//	if(parseInt(quantity)<parseInt(lowQuantity)){
		//		$(this).val(lowQuantity);
		//	}
		//	edit($(this));
		//}
	});
	
	//编辑数量后，鼠标失去焦点时触发
	$quantity.bind("blur", function(event) {
		var inputNum = $(this).val();
		var lowQuantity = $(this).siblings("input").val();//起购数量
		if(parseInt(inputNum)<parseInt(lowQuantity)){
			$.message("warn", "${message("shop.product.lowQuantityWarn")}:<span class='custom'>"+lowQuantity+"</span>");
			$(this).val(lowQuantity);
		}
		edit($(this));
	});
	
	// 编辑数量
	function edit($quantity) {
		var quantity = $quantity.val();
		if (/^\d*[1-9]\d*$/.test(quantity)) {
			var $tr = $quantity.closest("tr");
			var id = $tr.find("input[name='id']").val();
			clearTimeout(timeouts[id]);
			timeouts[id] = setTimeout(function() {
				$.ajax({
					url: "edit.jhtml",
					type: "POST",
					data: {id: id, quantity: quantity},
					dataType: "json",
					cache: false,
					beforeSend: function() {
						$submit.prop("disabled", true);
					},
					success: function(data) {
						if (data.message.type == "success") {
							$quantity.data("value", quantity);
							$tr.find("span.subtotal").text(currency(data.finalSubtotal, true));
							calculationPrice(id,quantity);
							if (data.giftItems != null && data.giftItems.length > 0) {
								$giftItems.html('<dt>${message("shop.cart.gift")}:<\/dt>');
								$.each(data.giftItems, function(i, giftItem) { 
									$giftItems.append('<dd><a href="${base}' + giftItem.gift.path + '" title="' + giftItem.gift.fullName + '" target="_blank">' + giftItem.gift.fullName.substring(0, 50) + ' * ' + giftItem.quantity + '<\/a><\/dd>');
								});
								$giftItems.show();
							} else {
								$giftItems.hide();
							}
							if (data.promotions != null && data.promotions.length > 0) {
								var promotionName = "";
								$.each(data.promotions, function(i, promotion) { 
									promotionName += promotion.name + " ";
								});
								$promotion.text(promotionName);
							} else {
								$promotion.empty();
							}
							if (!data.isLowStock) {
								$tr.find("span.lowStock").remove();
							}
							$effectivePoint.text(data.effectivePoint);
							$effectivePrice.text(currency(data.effectivePrice, true, false));
							$endEffectivePrice.text(currency(data.endEffectivePrice, true, false));
							$totalWeight.text(currency(data.totalWeight));
							$totalVolume.text(data.totalVolume);
						} else if (data.message.type == "warn") {
							$.message(data.message);
							$quantity.val($quantity.data("value"));
						} else if (data.message.type == "error") {
							$.message(data.message);
							$quantity.val($quantity.data("value"));
							setTimeout(function() {
								location.reload(true);
							}, 3000);
						}
					},
					complete: function() {
						$submit.prop("disabled", false);
					}
				});
			}, 500);
		} else {
			$quantity.val($quantity.data("value"));
		}
	}

	// 删除
	$delete.click(function() {
		if (confirm("${message("shop.dialog.deleteConfirm")}")) {
			var $this = $(this);
			var $tr = $this.closest("tr");
			var id = $tr.find("input[name='id']").val();
			clearTimeout(timeouts[id]);
			$.ajax({
				url: "delete.jhtml",
				type: "POST",
				data: {id: id},
				dataType: "json",
				cache: false,
				beforeSend: function() {
					$submit.prop("disabled", true);
				},
				success: function(data) {
					if (data.message.type == "success") {
						if (data.quantity > 0) {
							$tr.remove();
							if (data.giftItems != null && data.giftItems.length > 0) {
								$giftItems.html('<dt>${message("shop.cart.gift")}:<\/dt>');
								$.each(data.giftItems, function(i, giftItem) { 
									$giftItems.append('<dd><a href="${base}' + giftItem.gift.path + '" title="' + giftItem.gift.fullName + '" target="_blank">' + giftItem.gift.fullName.substring(0, 50) + ' * ' + giftItem.quantity + '<\/a><\/dd>');
								});
								$giftItems.show();
							} else {
								$giftItems.hide();
							}
							if (data.promotions != null && data.promotions.length > 0) {
								var promotionName = "";
								$.each(data.promotions, function(i, promotion) { 
									promotionName += promotion.name + " ";
								});
								$promotion.text(promotionName);
							} else {
								$promotion.empty();
							}
							$effectivePoint.text(data.effectivePoint);
							$effectivePrice.text(currency(data.effectivePrice, true, false));
							$endEffectivePrice.text(currency(data.endEffectivePrice, true, false));
							$totalWeight.text(currency(data.totalWeight));
							$totalVolume.text(data.totalVolume);
						} else {
							location.reload(true);
						}
					} else {
						$.message(data.message);
						setTimeout(function() {
							location.reload(true);
						}, 3000);
					}
				},
				complete: function() {
					$submit.prop("disabled", false);
				}
			});
		}
		return false;
	});
	
	//删除选择
	$deleteSelect.click(function() {
		var $checkedIds = $("#listTable input[name='ids']:enabled:checked");
		if($checkedIds.length==0){
			return false;
		}
		if (confirm("${message("shop.dialog.deleteConfirm")}")) {
			var $this = $(this);
			$.ajax({
				url: "deleteSelect.jhtml",
				type: "POST",
				data: $checkedIds.serialize(),
				dataType: "json",
				cache: false,
				success: function(message) {
					$.message(message);
					setTimeout(function() {
						location.reload(true);
					}, 500);
				}
			});
		}
		return false;
	});
	
	// 清空
	$clear.click(function() {
		if (confirm("${message("shop.dialog.clearConfirm")}")) {
			$.each(timeouts, function(i, timeout) {
				clearTimeout(timeout);
			});
			$.ajax({
				url: "clear.jhtml",
				type: "POST",
				dataType: "json",
				cache: false,
				success: function(data) {
					location.reload(true);
				}
			});
		}
		return false;
	});
	
	// 提交
	$submit.click(function() {
		if (!$.checkLogin()) {
			$.redirectLogin("${base}/cart/list.jhtml", "${message("shop.cart.accessDenied")}");
			return false;
		}
	});
	
	//全选反选
	$selectAll.click( function() {
		var $this = $(this);
		var $enabledIds = $("#listTable input[name='ids']:enabled");
		if ($this.prop("checked")) {
			$enabledIds.prop("checked", true);
			if ($enabledIds.filter(":checked").size() > 0) {
				$deleteButton.removeClass("disabled");
				$contentRow.addClass("selected");
			} else {
				$deleteButton.addClass("disabled");
			}
		} else {
			$enabledIds.prop("checked", false);
			$deleteButton.addClass("disabled");
			$contentRow.removeClass("selected");
		}
	});
	
});
</script>
</head>
<body>
	[#include "/shop/include/header.ftl" /]
	<div class="container cart">
		<div class="span24">
			<div class="step step1">
				<ul>
					<li class="current">${message("shop.cart.step1")}</li>
					<li>${message("shop.cart.step2")}</li>
					<li>${message("shop.cart.step3")}</li>
				</ul>
			</div>
			[#if cart?? && cart.cartItems?has_content]
				<table style="border:1px solid #B0CDE0" id="listTable">
					<tr>
						<th></th>
						<th>${message("shop.cart.image")}</th>
						<th>${message("shop.order.productSn")}</th>
						<th>${message("shop.product.features")}</th>
						<th>${message("Product.weight")}<br/>(g/pcs)</th>
						<th>${message("Product.volume")}<br/>(cubic meter/pcs)</th>
						<th>${message("shop.cart.price")}</th>
						<th>${message("shop.cart.quantity")}</th>
						<th>${message("shop.cart.subtotal")}</th>
						<th>${message("shop.cart.handle")}</th>
					</tr>
					[#list cart.cartItems as cartItem]
						<tr>
							<td width="20">
								<input name="ids" value="${cartItem.id}" type="checkbox">
							</td>
							<td width="60">
								<input type="hidden" name="id" value="${cartItem.id}" />
								<img src="[#if cartItem.product.thumbnail??]${cartItem.product.thumbnail}[#else]${setting.defaultThumbnailProductImage}[/#if]" alt="${cartItem.product.name}" />
							</td>
							<td>
								${message("shop.product.name")}:<br>${cartItem.product.name}<br>#${cartItem.product.sn}
							</td>
							<td>
								[#if cartItem.product.parameterValue?has_content]
									[#list cartItem.product.productCategory.parameterGroups as parameterGroups]
										[#list parameterGroups.parameters as parameter]
											[#if cartItem.product.parameterValue.get(parameter)??]
												${parameter.name}:${cartItem.product.parameterValue.get(parameter)}<br>
											[/#if]
										[/#list]
									[/#list]
								[/#if]
							</td>
							<td class="hidden">
								<a href="${base}${cartItem.product.path}" title="${cartItem.product.fullName}" target="_blank">${abbreviate(cartItem.product.fullName, 60, "...")}</a>
								[#if cartItem.isLowStock]
									<span class="red lowStock">[${message("shop.cart.lowStock")}]</span>
								[/#if]
							</td>
							<td class="${cartItem.id}">
								${cartItem.product.weight}${cartItem.product.unit}
							</td>
							<td class="${cartItem.id}">
								${cartItem.product.volume}
							</td>
							<td id="${cartItem.id}">
								<span class="newPrice">${currency(cartItem.endPrice, true)}</span>
							</td>
							<td class="quantity" width="90">
								<input type="hidden" name="lowQuantity" id="lowQuantity" value="${cartItem.product.lowQuantity}" />
								<input type="text" name="quantity" value="${cartItem.quantity}" maxlength="4" onpaste="return false;" />
								<div>
									<span class="increase">&nbsp;</span>
									<span class="decrease">&nbsp;</span>
								</div>
							</td>
							<td width="90" class="${cartItem.id}">
								<span class="subtotal">${currency(cartItem.finalSubtotal, true)}</span>
							</td>
							<td>
								<a href="javascript:;" class="delete">${message("shop.cart.delete")}</a>
							</td>
						</tr>
					[/#list]
				</table>
				<dl id="giftItems"[#if !cart.giftItems?has_content] class="hidden"[/#if]>
					[#if cart.giftItems?has_content]
						<dt>${message("shop.cart.gift")}:</dt>
						[#list cart.giftItems as giftItem]
							<dd>
								<a href="${base}${giftItem.gift.path}" title="${giftItem.gift.fullName}" target="_blank">${abbreviate(giftItem.gift.fullName, 60, "...")} * ${giftItem.quantity}</a>
							</dd>
						[/#list]
					[/#if]
				</dl>
				<div class="total hidden">
					<em id="promotion">
						[#list cart.promotions as promotion]
							${promotion.name}
						[/#list]
					</em>
					<!-- jackie.liu [@current_member]
						[#if !currentMember??]
							<em>
								${message("shop.cart.promotionTips")}
							</em>
						[/#if]
					[/@current_member]
					${message("shop.cart.effectivePoint")}: <em id="effectivePoint">${cart.effectivePoint}</em>-->
				</div>
				<div class="bottom">
					<p><a href="javascript:;" id="deleteSelect" class="deleteSelect">${message("shop.cart.delete")}</a></p>
					<a href="javascript:;" class="showWeight"><span style="color:#666">${message("shop.product.totalWeight")}:</span><strong id="totalWeight" style="font-size:16px;color:#2B7FB0">${currency(cart.totalWeight)}</strong><span style="color:#666"> g</span></a>
					<a href="javascript:;" class="showVolume"><span style="color:#666">${message("shop.product.totalVolume")}:</span><strong id="totalVolume" style="font-size:16px;color:#2B7FB0">${cart.totalVolume}</strong><span style="color:#666"> cubic meter</span></a>
					<a href="javascript:;" class="showAmount"><span style="color:#666">Total(With carriage):</span><strong id="endEffectivePrice" style="font-size:16px;color:#2B7FB0">${currency(cart.endEffectivePrice, true)}</strong></a>
					<a href="javascript:;" id="clear" class="clear">${message("shop.cart.clear")}</a>
					<a href="${base}/member/order/info.jhtml" id="submit" class="submit">${message("shop.cart.submit")}</a>
				</div>
			[#else]
				<p>
					<a href="${base}/">${message("shop.cart.empty")}</a>
				</p>
			[/#if]
		</div>
	</div>
	[#include "/shop/include/footer.ftl" /]
</body>
</html>