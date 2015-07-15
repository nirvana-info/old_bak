<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>${message("admin.shippingMethod.add")}</title>


<link href="${base}/resources/admin/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="${base}/resources/admin/js/jquery.js"></script>
<script type="text/javascript" src="${base}/resources/admin/js/jquery.tools.js"></script>
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
	//添加
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
		<a href="${base}/admin/common/index.jhtml">${message("admin.path.index")}</a> &raquo; ${message("admin.shippingMethod.add")}
	</div>
	<form id="inputForm" action="save.jhtml" method="post">
		<table class="input">
			<tr>
				<th>
					<span class="requiredField">*</span>${message("ShippingMethod.name")}:
				</th>
				<td>
					<input type="text" name="name" class="text" maxlength="200" />
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
							<option value="${deliveryCorp.id}">
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
					<input type="text" name="icon" class="text" maxlength="200" />
					<input type="button" id="browserButton" class="button" value="${message("admin.browser.select")}" />
				</td>
			</tr>
			<tr>
				<th>
					${message("admin.common.order")}:
				</th>
				<td>
					<input type="text" name="order" class="text" maxlength="9" />
				</td>
			</tr>
			<tr>
				<th>
					${message("ShippingMethod.description")}:
				</th>
				<td>
					<textarea id="editor" name="description" class="editor"></textarea>
				</td>
			</tr>
		</table>
		<table class="input hidden" id="methodTable">
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