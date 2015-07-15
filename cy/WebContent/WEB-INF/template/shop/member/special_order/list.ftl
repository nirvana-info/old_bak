<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>${message("specialOrder.list")}</title>


<link href="${base}/resources/shop/css/common.css" rel="stylesheet" type="text/css" />
<link href="${base}/resources/shop/css/member.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="${base}/resources/shop/js/jquery.js"></script>
<script type="text/javascript" src="${base}/resources/shop/js/common.js"></script>
<script type="text/javascript">
$().ready(function() {
	
	[@flash_message /]

});
</script>
</head>
<body>
	[#assign current = "specialOrderList" /]
	[#include "/shop/include/header.ftl" /]
	<div class="container member">
		[#include "/shop/member/include/navigation.ftl" /]
		<div class="span18 last">
			<div class="list">
				<div class="title">${message("specialOrder.list")}</div>
				<table class="list">
					<tr>
						<th>
							Name
						</th>
						<th>
							Phone
						</th>
						<th>
							E-Mail
						</th>
						<th>
							Event Name
						</th>
						<th>
							Item Description
						</th>
						<th>
							${message("shop.member.order.status")}
						</th>
						<th>
							${message("shop.member.handle")}
						</th>
					</tr>
					[#list page.content as item]
						<tr[#if !item_has_next] class="last"[/#if]>
							<td>
								${item.name}
							</td>
							<td>
								${item.phone}
							</td>
							<td>
								${item.email}
							</td>
							<td>
								${item.eventName}
							</td>
							<td>
								${item.itemDescription}
							</td>
							<td>
								[#if item.submitStatus==1 ]
									${message("specialOrder.approveStatus." + item.approveStatus )}
								[#else]
									${message("specialOrder.submitStatus." + item.submitStatus )}
								[/#if]
							</td>
							<td>
								<a href="view.jhtml?id=${item.id}">[${message("shop.member.handle.view")}]</a>
								[#if item.submitStatus==0]
								<a href="edit.jhtml?id=${item.id}">[${message("shop.member.handle.edit")}]</a>
								[/#if]
							</td>
						</tr>
					[/#list]
				</table>
				[#if !page.content?has_content]
					<p>${message("shop.member.noResult")}</p>
				[/#if]
			</div>
			[@pagination pageNumber = page.pageNumber totalPages = page.totalPages pattern = "?pageNumber={pageNumber}"]
				[#include "/shop/include/pagination.ftl"]
			[/@pagination]
		</div>
	</div>
	[#include "/shop/include/footer.ftl" /]
</body>
</html>