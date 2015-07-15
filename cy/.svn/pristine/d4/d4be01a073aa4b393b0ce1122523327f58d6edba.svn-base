<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Add Gift Requirement</title>


<link href="${base}/resources/shop/css/common.css" rel="stylesheet" type="text/css" />
<link href="${base}/resources/shop/css/member.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="${base}/resources/shop/js/jquery.js"></script>
<script type="text/javascript" src="${base}/resources/shop/js/jquery.lSelect.js"></script>
<script type="text/javascript" src="${base}/resources/shop/js/jquery.validate.js"></script>
<script type="text/javascript" src="${base}/resources/shop/js/common.js"></script>
<script type="text/javascript" src="${base}/resources/shop/datePicker/WdatePicker.js"></script>
<style type="text/css">
div.member table.input th {
	width: 30%;
}
.main-title{
	height: 30px;
	line-height: 30px;
	padding-left: 14px;
	margin-bottom: 10px;
	font-weight: bold;
	text-align: center;
}
.main-desc{
	height: auto;
	line-height: 20px;
	padding-left: 14px;
	margin-bottom: 10px;
	text-align: left;
}
</style>
<script type="text/javascript">
$().ready(function() {

	var $inputForm = $("#inputForm");
	
	[@flash_message /]
	
	// 表单验证
	$inputForm.validate({
		rules: {
			name: "required",
			phone: "required",
			email: {
				required: true,
				email: true
			},
			eventName: "required",
			itemDescription: "required"
		}
	});
	
});

function saveDraft_fun(){
	$("#submitStatus").val(0);
	if(confirm("${message("shop.specialOrder.saveDraftDialog")}")){
		$("#inputForm").submit();
	}
}
function submit_fun(){
	$("#submitStatus").val(1);
	if(confirm("${message("shop.specialOrder.submitDialog")}")){
		$("#inputForm").submit();
	}
}
</script>
</head>
<body>
	[#include "/shop/include/header.ftl" /]
	<div class="container member">
		<div class="input">
			<div class="main-title">Add Gift Requirement</div>
			<div  class="main-desc">
				Can't find what you're looking for? Need ideas for an upcoming meeting or special event? Let our experienced staff of creative specialists help! Just complete the form below, and submit it to us. You will be contacted within 1 business day with answers and new ideas!
			</div>
			<form id="inputForm" action="save.jhtml" method="post">
				<input type="hidden" id="submitStatus" name="submitStatus" value="0"/>
				<table class="input">
					<tr>
						<th colspan="2" style="text-align: left;">
							<div class="title">Customer Info</div>
						</th>
					</tr>
					<tr>
						<th>
							<span class="requiredField_blue">*</span>Name: 
						</th>
						<td>
							<input type="text" name="name" class="text" maxlength="200" />
						</td>
					</tr>
					<tr>
						<th>
							Title: 
						</th>
						<td>
							<input type="text" name="title" class="text" maxlength="200" />
						</td>
					</tr>
					<tr>
						<th>
							<span class="requiredField_blue">*</span>Phone: 
						</th>
						<td>
							<input type="text" name="phone" class="text" maxlength="200" />
						</td>
					</tr>
					<tr>
						<th>
							FAX: 
						</th>
						<td>
							<input type="text" name="fax" class="text" maxlength="200" />
						</td>
					</tr>
					<tr>
						<th>
							<span class="requiredField_blue">*</span>E-Mail: 
						</th>
						<td>
							<input type="text" name="email" class="text" maxlength="200" />
						</td>
					</tr>
					<tr>
						<th>
							Contact me via:
						</th>
						<td>
							[#list contactMeVias as item]
							<input type="radio" name="contactMeVia.id" value="${item.id}" />${item.label}
							[/#list]
						</td>
					</tr>
					<tr>
						<th colspan="2" style="text-align: left;">
							<div class="title">Requested Action</div>
						</th>
					</tr>
					<tr>
						<th>
							Action:
						</th>
						<td>
							[#list actions as item]
							<input type="radio" name="action.id" value="${item.id}" />${item.label}
							[/#list]
						</td>
					</tr>
					<tr>
						<th colspan="2" style="text-align: left;">
							<div class="title">Purpose / Event</div>
						</th>
					</tr>
					<tr>
						<th>
							<span class="requiredField_blue">*</span>Event Name: 
						</th>
						<td>
							<input type="text" name="eventName" class="text" maxlength="200" />
						</td>
					</tr>
					<tr>
						<th>
							Event Type: 
						</th>
						<td>
							<select name="eventType.id">
								<option value="">Select an Event Type</option>
								[#list eventTypes as item]
								<option value="${item.id}">${item.label}</option>
								[/#list]
							</select>
						</td>
					</tr>
					<tr>
						<th>
							Event Theme: 
						</th>
						<td>
							<input type="text" name="eventTheme" class="text" maxlength="200" />
						</td>
					</tr>
					<tr>
						<th>
							Budget: 
						</th>
						<td>
							<input type="text" name="budget" class="text" maxlength="200" />
						</td>
					</tr>
					<tr>
						<th>
							Event Date: 
						</th>
						<td>
							<input type="text" name="eventDate" class="text Wdate" onfocus="WdatePicker();" maxlength="200" />
						</td>
					</tr>
					<tr>
						<th>
							Delivery Date: 
						</th>
						<td>
							<input type="text" name="deliveryDate" class="text Wdate" onfocus="WdatePicker();" maxlength="200" />
						</td>
					</tr>
					<tr>
						<th colspan="2" style="text-align: left;">
							<div class="title">Merchandise</div>
						</th>
					</tr>
					<tr>
						<th>
							<span class="requiredField_blue">*</span>Item Description: 
						</th>
						<td>
							<input type="text" name="itemDescription" class="text" maxlength="200" />
						</td>
					</tr>
					<tr>
						<th>
							Decoration Method: 
						</th>
						<td>
							<select name="decorationMethod.id">
								<option value="">Select one</option>
								[#list decorationMethods as item]
								<option value="${item.id}">${item.label}</option>
								[/#list]
							</select>
						</td>
					</tr>
					<tr>
						<th>
							Logo: 
						</th>
						<td>
							<input type="text" name="logo" class="text" maxlength="200" />
						</td>
					</tr>
					<tr>
						<th>
							Colors: 
						</th>
						<td>
							<input type="text" name="colors" class="text" maxlength="200" />
						</td>
					</tr>
					<tr>
						<th>
							Sizes: 
						</th>
						<td>
							<input type="text" name="sizes" class="text" maxlength="200" />
						</td>
					</tr>
					<tr>
						<th>
							Qty: 
						</th>
						<td>
							<input type="text" name="qty" class="text" maxlength="200" />
						</td>
					</tr>
					<tr>
						<th colspan="2" style="text-align: left;">
							<div class="title">Packaging Options</div>
						</th>
					</tr>
					<tr>
						<th>
							Gift-Wrap:
						</th>
						<td>
							[#list giftWraps as item]
							<input type="checkbox" name="giftWrap.id" value="${item.id}" />${item.label}
							[/#list]
						</td>
					</tr>
					<tr>
						<th>
							Include Thank-You Note:
						</th>
						<td>
							[#list thankYouNotes as item]
							<input type="checkbox" name="thankYouNote.id" value="${item.id}" />${item.label}
							[/#list]
						</td>
					</tr>
					<tr>
						<th>
							Thank-You Message: 
						</th>
						<td>
							<textarea name="thankYouMessage" class="text" maxlength="500"></textarea>
						</td>
					</tr>
					<tr>
						<th colspan="2" style="text-align: left;">
							<div class="title">Comments / Special Instructions</div>
						</th>
					</tr>
					<tr>
						<th>
							Special Instructions: 
						</th>
						<td>
							<textarea name="specialInstructions" class="text" maxlength="500"></textarea>
						</td>
					</tr>
					<tr>
						<td colspan="2" style="text-align: center;">
							<input type="button" class="button" value="${message("shop.specialOrders.saveDraft")}" onclick="saveDraft_fun()" />
							<input type="button" class="button" value="${message("shop.specialOrders.submit")}" onclick="submit_fun()"/>
							<input type="reset" class="button" value="${message("shop.specialOrders.reset")}" />
						</td>
					</tr>
				</table>
			</form>
		</div>
	</div>
	[#include "/shop/include/footer.ftl" /]
</body>
</html>