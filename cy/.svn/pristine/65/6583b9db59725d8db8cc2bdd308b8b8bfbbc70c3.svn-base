<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>${message("shop.member.specialOrder.view")}</title>


<link href="${base}/resources/shop/css/common.css" rel="stylesheet" type="text/css" />
<link href="${base}/resources/shop/css/member.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="${base}/resources/shop/js/jquery.js"></script>
<script type="text/javascript" src="${base}/resources/shop/js/common.js"></script>
<style type="text/css">
div.member .order .top {
	height: 50px;
}
div.member .order .top .handle {
	width: 280px;
}
</style>
<script type="text/javascript">
$().ready(function() {

	[@flash_message /]

});
function submit_fun(){
	if(confirm("${message("shop.specialOrder.submitDialog")}")){
		$("#submitForm").submit();
	}
}
function delete_fun(){
	if(confirm("${message("shop.specialOrder.deleteDialog")}")){
		$("#deleteForm").submit();
	}
}
</script>
</head>
<body>
	[#assign current = "specialOrderList" /]
	[#include "/shop/include/header.ftl" /]
	<div class="container member">
		[#include "/shop/member/include/navigation.ftl" /]
		<div class="span18 last">
			<form id="submitForm" action="submit.jhtml" method="post">
				<input type="hidden" name="id" value="${specialOrders.id}" />
			</form>
			<form id="deleteForm" action="delete.jhtml" method="post">
				<input type="hidden" name="id" value="${specialOrders.id}" />
			</form>
			<div class="input order">
				<div class="title">${message("shop.member.specialOrder.view")}</div>
				<div class="top">
					<span>
						${message("shop.member.order.status")}: 
						<strong>
							[#if specialOrders.submitStatus==1 ]
								${message("specialOrder.approveStatus." + specialOrders.approveStatus )}
							[#else]
								${message("specialOrder.submitStatus." + specialOrders.submitStatus )}
							[/#if]
						</strong>
					</span>
					<span class="handle">
						[#if specialOrders.submitStatus==0 ]
							<a href="edit.jhtml?id=${specialOrders.id}" class="button">${message("shop.member.handle.edit")}</a>
							<a href="javascript:;" onclick="submit_fun()" class="button">${message("shop.member.submit")}</a>
							<a href="javascript:;" onclick="delete_fun()" class="button">${message("shop.member.handle.delete")}</a>
						[/#if]
					</span>
				</div>
				<table class="info">
					<tr>
						<th>
							Name:
						</th>
						<td>
							${specialOrders.name}&nbsp;
						</td>
					</tr>
					<tr>
						<th>
							Title:
						</th>
						<td>
							${specialOrders.title}&nbsp;
						</td>
					</tr>
					<tr>
						<th>
							Phone:
						</th>
						<td>
							${specialOrders.phone}&nbsp;
						</td>
					</tr>
					<tr>
						<th>
							FAX:
						</th>
						<td>
							${specialOrders.fax}&nbsp;
						</td>
					</tr>
					<tr>
						<th>
							E-Mail:
						</th>
						<td>
							${specialOrders.email}&nbsp;
						</td>
					</tr>
					<tr>
						<th>
							Contact me via:
						</th>
						<td>
							[#if specialOrders.contactMeVia!=null]
							${specialOrders.contactMeVia.label}
							[/#if]&nbsp;
						</td>
					</tr>
				</table>
				<table class="info">
					<tr>
						<th>
							Action:
						</th>
						<td>
							[#if specialOrders.action!=null ]
							${specialOrders.action.label}
							[/#if]&nbsp;
						</td>
					</tr>
				</table>
				<table class="info">
					<tr>
						<th>
							Event Name:
						</th>
						<td>
							${specialOrders.eventName}&nbsp;
						</td>
					</tr>
					<tr>
						<th>
							Event Type:
						</th>
						<td>
							[#if specialOrders.eventType!=null]
							${specialOrders.eventType.label}
							[/#if]&nbsp;
						</td>
					</tr>
					<tr>
						<th>
							Event Theme:
						</th>
						<td>
							${specialOrders.eventTheme}&nbsp;
						</td>
					</tr>
					<tr>
						<th>
							Budget:
						</th>
						<td>
							${specialOrders.budget}&nbsp;
						</td>
					</tr>
					<tr>
						<th>
							Event Date:
						</th>
						<td>
							${specialOrders.eventDate}&nbsp;
						</td>
					</tr>
					<tr>
						<th>
							Delivery Date:
						</th>
						<td>
							${specialOrders.deliveryDate}&nbsp;
						</td>
					</tr>
				</table>
				<table class="info">
					<tr>
						<th>
							Item Description:
						</th>
						<td>
							${specialOrders.itemDescription}&nbsp;
						</td>
					</tr>
					<tr>
						<th>
							Decoration Method:
						</th>
						<td>
							[#if specialOrders.decorationMethod!=null]
							${specialOrders.decorationMethod.label}
							[/#if]&nbsp;
						</td>
					</tr>
					<tr>
						<th>
							Logo:
						</th>
						<td>
							${specialOrders.logo}&nbsp;
						</td>
					</tr>
					<tr>
						<th>
							Colors:
						</th>
						<td>
							${specialOrders.colors}&nbsp;
						</td>
					</tr>
					<tr>
						<th>
							Sizes:
						</th>
						<td>
							${specialOrders.sizes}&nbsp;
						</td>
					</tr>
					<tr>
						<th>
							Qty:
						</th>
						<td>
							${specialOrders.qty}&nbsp;
						</td>
					</tr>
				</table>
				<table class="info">
					<tr>
						<th>
							Gift-Wrap:
						</th>
						<td>
							[#if specialOrders.giftWrap!=null]
							${specialOrders.giftWrap.label}
							[/#if]&nbsp;
						</td>
					</tr>
					<tr>
						<th>
							Thank-You Note:
						</th>
						<td>
							[#if specialOrders.thankYouNote!=null]
							${specialOrders.thankYouNote.label}
							[/#if]&nbsp;
						</td>
					</tr>
					<tr>
						<th>
							Thank-You Message:
						</th>
						<td>
							${specialOrders.thankYouMessage}&nbsp;
						</td>
					</tr>
				</table>
				<table class="info">
					<tr>
						<th>
							Special Instructions:
						</th>
						<td>
							${specialOrders.specialInstructions}&nbsp;
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	[#include "/shop/include/footer.ftl" /]
</body>
</html>