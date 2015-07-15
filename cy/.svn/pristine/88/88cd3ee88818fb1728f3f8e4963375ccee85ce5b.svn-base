<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>${message("admin.dict.add")}</title>


<link href="${base}/resources/admin/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="${base}/resources/admin/js/jquery.js"></script>
<script type="text/javascript" src="${base}/resources/admin/js/jquery.tools.js"></script>
<script type="text/javascript" src="${base}/resources/admin/js/jquery.validate.js"></script>
<script type="text/javascript" src="${base}/resources/admin/js/common.js"></script>
<script type="text/javascript" src="${base}/resources/admin/js/input.js"></script>
<style type="text/css">

</style>
<script type="text/javascript">
$().ready(function() {

	var $inputForm = $("#inputForm");
	
	[@flash_message /]
	
	// 表单验证
	$inputForm.validate({
		rules: {
			value: {
				required: true,
				minlength: 1,
				maxlength: 50
			},
			label: {
				required: true,
				minlength: 1,
				maxlength: 50
			},
			type: {
				required: true,
				minlength: 1,
				maxlength: 50
			},
			sort: {
				required: true,
				digits: true
			}
		}
	});
	
});
</script>
</head>
<body>
	<div class="path">
		<a href="${base}/admin/common/index.jhtml">${message("admin.path.index")}</a> &raquo; ${message("admin.dict.add")}
	</div>
	<form id="inputForm" action="save.jhtml" method="post">
		<table class="input tabContent">
			<tr>
				<th>
					<span class="requiredField">*</span>${message("Dict.value")}:
				</th>
				<td>
					<input type="text" name="value" class="text" maxlength="50" />
				</td>
			</tr>
			<tr>
				<th>
					<span class="requiredField">*</span>${message("Dict.label")}:
				</th>
				<td>
					<input type="text" id="label" name="label" class="text" maxlength="50" />
				</td>
			</tr>
			<tr>
				<th>
					<span class="requiredField">*</span>${message("Dict.type")}:
				</th>
				<td>
					<input type="text" name="type" class="text" maxlength="50" />
				</td>
			</tr>
			<tr>
				<th>
					${message("Dict.description")}:
				</th>
				<td>
					<input type="text" name="description" class="text" maxlength="200" value="" />
				</td>
			</tr>
			<tr>
				<th>
					<span class="requiredField">*</span>${message("Dict.sort")}:
				</th>
				<td>
					<input type="text" name="sort" class="text" maxlength="10" />
				</td>
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