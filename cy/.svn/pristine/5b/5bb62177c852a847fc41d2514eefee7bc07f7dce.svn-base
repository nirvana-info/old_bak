<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>${message("admin.shippingMethod.edit")}</title>


<link href="${base}/resources/admin/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="${base}/resources/admin/js/jquery.js"></script>
<script type="text/javascript" src="${base}/resources/admin/js/jquery.tools.js"></script>
<script type="text/javascript" src="${base}/resources/admin/js/jquery.lSelect.js"></script>
<script type="text/javascript" src="${base}/resources/admin/js/jquery.validate.js"></script>
<script type="text/javascript" src="${base}/resources/admin/editor/kindeditor.js"></script>
<script type="text/javascript" src="${base}/resources/admin/js/common.js"></script>
<script type="text/javascript" src="${base}/resources/admin/js/input.js"></script>
<script type="text/javascript">
$().ready(function() {

	var $inputForm = $("#inputForm");
	var $browserButton = $("#browserButton");
	var $addNewMethod = $("#addNewMethod");
	var detailsIndex = ${(shippingMethod.details?size)!"0"};
	var $methodTable = $("#methodTable");
	var $deleteMethod = $("#deleteMethod");
	var $areaId = $("#areaId");
	
	[@flash_message /]
	
	// 地区选择
	$areaId.lSelect({
		url: "${base}/admin/common/area.jhtml"
	});
	
	$browserButton.browser();
	
	// 表单验证
	$inputForm.validate({
		rules: {
			name: "required",
			firstWeight: {
				required: true,
				digits: true
			},
			continueWeight: {
				required: true,
				integer: true,
				min: 1
			},
			firstPrice: {
				required: true,
				min: 0,
				decimal: {
					integer: 12,
					fraction: ${setting.priceScale}
				}
			},
			continuePrice: {
				required: true,
				min: 0,
				decimal: {
					integer: 12,
					fraction: ${setting.priceScale}
				}
			},
			firstVolume: {
				required: true,
				digits: true
			},
			continueVolume: {
				required: true,
				integer: true,
				min: 0
			},
			firstVolumePrice: {
				required: true,
				min: 0,
				decimal: {
					integer: 12,
					fraction: ${setting.priceScale}
				}
			},
			continueVolumePrice: {
				required: true,
				min: 0,
				decimal: {
					integer: 12,
					fraction: ${setting.priceScale}
				}
			},
			order: "digits"
		}
	});
	
	$addNewMethod.click(function() {
		[@compress single_line = true]
			var trHtml = 
			'<tr>
				<td>
					<input style="width:80px" type="text" name="details['+detailsIndex+'].firstWeight" class="text" maxlength="9" />
				</td>
				<td>
					<input style="width:80px" type="text" name="details['+detailsIndex+'].continueWeight" class="text" maxlength="9" />
				</td>
				<td>
					<input style="width:80px" type="text" name="details['+detailsIndex+'].firstPrice" class="text" maxlength="16" />
				</td>
				<td>
					<input style="width:80px" type="text" name="details['+detailsIndex+'].continuePrice" class="text" maxlength="16" />
				</td>
				<td>
					<input style="width:80px" type="text" name="details['+detailsIndex+'].firstVolume" class="text" maxlength="9"/>
				</td>
				<td>
					<input style="width:80px" type="text" name="details['+detailsIndex+'].continueVolume" class="text" maxlength="9"/>
				</td>
				<td>
					<input style="width:80px" type="text" name="details['+detailsIndex+'].firstVolumePrice" class="text" maxlength="16" />
				</td>
				<td>
					<input style="width:80px" type="text" name="details['+detailsIndex+'].continueVolumePrice" class="text" maxlength="16" />
				</td>
				<td>
					<select name="details['+detailsIndex+'].area.id" style="width:100px">
						[#list areaList as area]
							<option value="${area.id}" style="width:100px">${area.name}</option>
						[/#list]
					</select>
				</td>
				<td>
					<a href="javascript:;" id="deleteMethod">[${message("admin.common.delete")}]</a>
				</td>
			</tr>';
		[/@compress]
		$methodTable.append(trHtml);
		detailsIndex ++;
	});
	
	//删除配送
	$deleteMethod.live("click", function() {
		var $this = $(this);
		$.dialog({
			type: "warn",
			content: "${message("admin.dialog.deleteConfirm")}",
			onOk: function() {
				$this.closest("tr").remove();
			}
		});
	});
	
});
</script>
</head>
<body>
	<div class="path">
		<a href="${base}/admin/common/index.jhtml">${message("admin.path.index")}</a> &raquo; ${message("admin.shippingMethod.edit")}
	</div>
	<form id="inputForm" action="update.jhtml" method="post">
		<input type="hidden" name="id" value="${shippingMethod.id}" />
		<table class="input">
			<tr>
				<th>
					<span class="requiredField">*</span>${message("ShippingMethod.name")}:
				</th>
				<td>
					<input type="text" name="name" class="text" value="${shippingMethod.name}" maxlength="200" />
				</td>
			</tr>
			<tr>
				<th>
					${message("ShippingMethod.defaultDeliveryCorp")}:
				</th>
				<td>
					<select name="defaultDeliveryCorpId">
						<option value="">${message("admin.common.choose")}</option>
						[#list deliveryCorps as deliveryCorp]
							<option value="${deliveryCorp.id}" [#if deliveryCorp == shippingMethod.defaultDeliveryCorp] selected="selected"[/#if]>
								${deliveryCorp.name}
							</option>
						[/#list]
					</select>
				</td>
			</tr>
			<tr>
				<th>
					${message("ShippingMethod.icon")}:
				</th>
				<td>
					<input type="text" name="icon" class="text" value="${shippingMethod.icon}" maxlength="200" />
					<input type="button" id="browserButton" class="button" value="${message("admin.browser.select")}" />
					[#if shippingMethod.icon??]
						<a href="${shippingMethod.icon}" target="_blank">${message("admin.common.view")}</a>
					[/#if]
				</td>
			</tr>
			<tr>
				<th>
					${message("admin.common.order")}:
				</th>
				<td>
					<input type="text" name="order" class="text" value="${shippingMethod.order}" maxlength="9" />
				</td>
			</tr>
			<!--目前物流存在子项，暂时隐藏下面的信息
				<tr>
					<th>
						<span class="requiredField">*</span>${message("ShippingMethod.firstWeight")}:
					</th>
					<td>
						<input type="text" name="firstWeight" class="text" value="${shippingMethod.firstWeight}" maxlength="9" title="${message("admin.shippingMethod.weightTitle")}" />
					</td>
				</tr>
				<tr>
					<th>
						<span class="requiredField">*</span>${message("ShippingMethod.continueWeight")}:
					</th>
					<td>
						<input type="text" name="continueWeight" class="text" value="${shippingMethod.continueWeight}" maxlength="9" title="${message("admin.shippingMethod.weightTitle")}" />
					</td>
				</tr>
				<tr>
					<th>
						<span class="requiredField">*</span>${message("ShippingMethod.firstPrice")}:
					</th>
					<td>
						<input type="text" name="firstPrice" class="text" value="${shippingMethod.firstPrice}" maxlength="16" />
					</td>
				</tr>
				<tr>
					<th>
						<span class="requiredField">*</span>${message("ShippingMethod.continuePrice")}:
					</th>
					<td>
						<input type="text" name="continuePrice" class="text" value="${shippingMethod.continuePrice}" maxlength="16" />
					</td>
				</tr>
				<tr>
					<th>
						<span class="requiredField">*</span>${message("ShippingMethod.firstVolume")}:
					</th>
					<td>
						<input type="text" name="firstVolume" class="text" value="${shippingMethod.firstVolume}" maxlength="9" title="${message("admin.shippingMethod.volumeTitle")}" />
					</td>
				</tr>
				<tr>
					<th>
						<span class="requiredField">*</span>${message("ShippingMethod.continueVolume")}:
					</th>
					<td>
						<input type="text" name="continueVolume" class="text" value="${shippingMethod.continueVolume}" maxlength="9" title="${message("admin.shippingMethod.volumeTitle")}" />
					</td>
				</tr>
				<tr>
					<th>
						<span class="requiredField">*</span>${message("ShippingMethod.firstVolumePrice")}:
					</th>
					<td>
						<input type="text" name="firstVolumePrice" class="text" value="${shippingMethod.firstVolumePrice}" maxlength="16" />
					</td>
				</tr>
				<tr>
					<th>
						<span class="requiredField">*</span>${message("ShippingMethod.continueVolumePrice")}:
					</th>
					<td>
						<input type="text" name="continueVolumePrice" class="text" value="${shippingMethod.continueVolumePrice}" maxlength="16" />
					</td>
				</tr>
				<tr>
					<th colspan="2">
						${message("ShippingMethod.description")}:
					</th>
					<td colspan="8">
						<textarea id="editor" name="description" class="editor">${shippingMethod.description?html}</textarea>
					</td>
					<td colspan="2"></td>
				</tr>
			-->
		</table>
		<table class="input" id="methodTable">
			<colgroup>
				<col width="9%"/><col width="9%"/><col width="9%"/><col width="9%"/><col width="9%"/>
				<col width="9%"/><col width="9%"/><col width="9%"/><col width="9%"/><col width="9%"/>
			</colgroup>
			<tr>
				<td colspan="2">
					<a href="javascript:;" id="addNewMethod" class="button">Add</a>
				</td>
				<td colspan="10"></td>
			</tr>
			<tr class="title">
				<th>
					${message("ShippingMethod.firstWeight")}
				</th>
				<th>
					${message("ShippingMethod.continueWeight")}
				</th>
				<th>
					${message("ShippingMethod.firstPrice")}
				</th>
				<th>
					${message("ShippingMethod.continuePrice")}
				</th>
				<th>
					${message("ShippingMethod.firstVolume")}
				</th>
				<th>
					${message("ShippingMethod.continueVolume")}
				</th>
				<th>
					${message("ShippingMethod.firstVolumePrice")}
				</th>
				<th>
					${message("ShippingMethod.continueVolumePrice")}
				</th>
				<th>
					Area
				</th>
				<th>
					${message("admin.common.handle")}
				</th>
			</tr>
			[#list shippingMethod.details as detail]
			<tr>
				<td>
					<input type="hidden" name="details[${detail_index}].id" value="${detail.id}" />
					<input style="width:80px" type="text" name="details[${detail_index}].firstWeight" class="text" value="${detail.firstWeight}" maxlength="9" title="${message("admin.shippingMethod.weightTitle")}" />
				</td>
				<td>
					<input style="width:80px" type="text" name="details[${detail_index}].continueWeight" class="text" value="${detail.continueWeight}" maxlength="9" title="${message("admin.shippingMethod.weightTitle")}" />
				</td>
				<td>
					<input style="width:80px" type="text" name="details[${detail_index}].firstPrice" class="text" value="${detail.firstPrice}" maxlength="16" />
				</td>
				<td>
					<input style="width:80px" type="text" name="details[${detail_index}].continuePrice" class="text" value="${detail.continuePrice}" maxlength="16" />
				</td>
				<td>
					<input style="width:80px" type="text" name="details[${detail_index}].firstVolume" class="text" value="${detail.firstVolume}" maxlength="9" title="${message("admin.shippingMethod.volumeTitle")}" />
				</td>
				<td>
					<input style="width:80px" type="text" name="details[${detail_index}].continueVolume" class="text" value="${detail.continueVolume}" maxlength="9" title="${message("admin.shippingMethod.volumeTitle")}" />
				</td>
				<td>
					<input style="width:80px" type="text" name="details[${detail_index}].firstVolumePrice" class="text" value="${detail.firstVolumePrice}" maxlength="16" />
				</td>
				<td>
					<input style="width:80px" type="text" name="details[${detail_index}].continueVolumePrice" class="text" value="${detail.continueVolumePrice}" maxlength="16" />
				</td>
				<td>
					<select name="details[${detail_index}].area.id" style="width:100px">
						[#list areaList as area]
							<option value="${area.id}"[#if area==detail.area] selected="selected"[/#if] style="width:100px">${area.name}</option>
						[/#list]
					</select>
				</td>
				<td>
					<a href="javascript:;" id="deleteMethod">[${message("admin.common.delete")}]</a>
				</td>
			</tr>
			[/#list]
		</table>
		<table class="input">
			<tr>
				<th>
					&nbsp;
				</th>
				<td>
					<input type="submit" class="button" value="${message("admin.common.submit")}" />
					<input type="button" class="button" value="${message("admin.common.back")}" onclick="location.href='list.jhtml'" />
				</td>
			</tr>
		</table>
	</form>
</body>
</html>