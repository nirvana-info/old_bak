[#assign shiro=JspTaglibs["/WEB-INF/tld/shiro.tld"] /]
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>${message("admin.specialOrder.list")}</title>


<link href="${base}/resources/admin/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="${base}/resources/admin/js/jquery.js"></script>
<script type="text/javascript" src="${base}/resources/admin/js/common.js"></script>
<script type="text/javascript" src="${base}/resources/admin/js/list.js"></script>
<script type="text/javascript">
$().ready(function() {

	var $listForm = $("#listForm");
	var $filterSelect = $("#filterSelect");
	var $filterOption = $("#filterOption a");

	[@flash_message /]
	
	// 订单筛选
	$filterSelect.mouseover(function() {
		var $this = $(this);
		var offset = $this.offset();
		var $menuWrap = $this.closest("div.menuWrap");
		var $popupMenu = $menuWrap.children("div.popupMenu");
		$popupMenu.css({left: offset.left, top: offset.top + $this.height() + 2}).show();
		$menuWrap.mouseleave(function() {
			$popupMenu.hide();
		});
	});
	
	// 筛选选项
	$filterOption.click(function() {
		var $this = $(this);
		var $dest = $("#" + $this.attr("name"));
		if ($this.hasClass("checked")) {
			$dest.val("");
		} else {
			$dest.val($this.attr("val"));
		}
		$listForm.submit();
		return false;
	});
	
});
// 确认
function confirmSpecialOrder(obj){
	var $this = $(obj);
	$("#confirmForm").find("input[name='id']").val($this.attr("specialOrderid"));
	$.dialog({
		type: "warn",
		content: "${message("admin.specialOrder.confirmDialog")}",
		onOk: function() {
			$("#confirmForm").submit();
		}
	});
}
// 拒绝
function cancelSpecialOrder(obj){
	var $this = $(obj);
	$("#cancelForm").find("input[name='id']").val($this.attr("specialOrderid"));
	$.dialog({
		type: "warn",
		content: "${message("admin.specialOrder.cancelDialog")}",
		onOk: function() {
			$("#cancelForm").submit();
		}
	});
}
</script>
</head>
<body>
	<div class="path">
		<a href="${base}/admin/common/index.jhtml">${message("admin.path.index")}</a> &raquo; ${message("admin.specialOrder.list")} <span>(${message("admin.page.total", page.total)})</span>
	</div>
	<form id="confirmForm" action="confirm.jhtml" method="post">
		<input type="hidden" name="id" value="" />
	</form>
	<form id="cancelForm" action="cancel.jhtml" method="post">
		<input type="hidden" name="id" value="" />
	</form>
	<form id="listForm" action="list.jhtml" method="get">
		<input type="hidden" id="approveStatus" name="approveStatus" value="${approveStatus}" />
		<div class="bar">
			<div class="buttonWrap">
				<a href="javascript:;" id="refreshButton" class="iconButton">
					<span class="refreshIcon">&nbsp;</span>${message("admin.common.refresh")}
				</a>
				<div class="menuWrap">
					<a href="javascript:;" id="filterSelect" class="button">
						${message("admin.specialOrder.filter")}<span class="arrow">&nbsp;</span>
					</a>
					<div class="popupMenu">
						<ul id="filterOption" class="check">
							<li>
								<a href="javascript:;" name="approveStatus" val="0"[#if approveStatus == 0] class="checked"[/#if]>${message("specialOrder.approveStatus.0")}</a>
							</li>
							<li>
								<a href="javascript:;" name="approveStatus" val="1"[#if approveStatus == 1] class="checked"[/#if]>${message("specialOrder.approveStatus.1")}</a>
							</li>
							<li>
								<a href="javascript:;" name="approveStatus" val="2"[#if approveStatus == 2] class="checked"[/#if]>${message("specialOrder.approveStatus.2")}</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="menuWrap">
					<a href="javascript:;" id="pageSizeSelect" class="button">
						${message("admin.page.pageSize")}<span class="arrow">&nbsp;</span>
					</a>
					<div class="popupMenu">
						<ul id="pageSizeOption">
							<li>
								<a href="javascript:;"[#if page.pageSize == 10] class="current"[/#if] val="10">10</a>
							</li>
							<li>
								<a href="javascript:;"[#if page.pageSize == 20] class="current"[/#if] val="20">20</a>
							</li>
							<li>
								<a href="javascript:;"[#if page.pageSize == 50] class="current"[/#if] val="50">50</a>
							</li>
							<li>
								<a href="javascript:;"[#if page.pageSize == 100] class="current"[/#if] val="100">100</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="menuWrap">
				<div class="search">
					<span id="searchPropertySelect" class="arrow">&nbsp;</span>
					<input type="text" id="searchValue" name="searchValue" value="${page.searchValue}" maxlength="200" />
					<button type="submit">&nbsp;</button>
				</div>
				<div class="popupMenu">
					<ul id="searchPropertyOption">
						<li>
							<a href="javascript:;"[#if page.searchProperty == "name"] class="current"[/#if] val="name">Name</a>
						</li>
						<li>
							<a href="javascript:;"[#if page.searchProperty == "phone"] class="current"[/#if] val="phone">Phone</a>
						</li>
						<li>
							<a href="javascript:;"[#if page.searchProperty == "email"] class="current"[/#if] val="email">E-Mail</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<table id="listTable" class="list">
			<tr>
				<th>
					<a href="javascript:;" class="sort" name="name">Name</a>
				</th>
				<th>
					<a href="javascript:;" class="sort" name="title">Title</a>
				</th>
				<th>
					<a href="javascript:;" class="sort" name="phone">Phone</a>
				</th>
				<th>
					<a href="javascript:;" class="sort" name="fax">FAX</a>
				</th>
				<th>
					<a href="javascript:;" class="sort" name="email">E-Mail</a>
				</th>
				<th>
					<span>Contact me via</span>
				</th>
				<th>
					<span>Action</span>
				</th>
				<th>
					<a href="javascript:;" class="sort" name="eventName">Event Name</a>
				</th>
				<th>
					<span>Event Type</span>
				</th>
				<th>
					<a href="javascript:;" class="sort" name="approveStatus">${message("admin.specialOrder.status")}</a>
				</th>
				<th>
					<a href="javascript:;" class="sort" name="createDate">${message("admin.common.createDate")}</a>
				</th>
				<th>
					<span>${message("admin.common.handle")}</span>
				</th>
			</tr>
			[#list page.content as item]
				<tr>
					<td>
						${item.name}
					</td>
					<td>
						${item.title}
					</td>
					<td>
						${item.phone}
					</td>
					<td>
						${item.fax}
					</td>
					<td>
						${item.email}
					</td>
					<td>
						[#if item.contactMeVia !=null ]
						${item.contactMeVia.label}
						[/#if]
					</td>
					<td>
						[#if item.action !=null ]
						${item.action.label}
						[/#if]
					</td>
					<td>
						${item.eventName}
					</td>
					<td>
						[#if item.eventType !=null ]
						${item.eventType.label}
						[/#if]
					</td>
					<td>
						${message("specialOrder.approveStatus." + item.approveStatus )}
					</td>
					<td>
						<span title="${item.modifyDate?string("yyyy-MM-dd HH:mm:ss")}">${item.modifyDate}</span>
					</td>
					<td>
						<a href="view.jhtml?id=${item.id}">[${message("admin.common.view")}]</a>
						[#if item.approveStatus==0]
							<a href="javascript:" specialOrderid="${item.id}" onclick="confirmSpecialOrder(this)">[${message("specialOrder.approveStatus.1")}]</a>
							<a href="javascript:" specialOrderid="${item.id}" onclick="cancelSpecialOrder(this)">[${message("specialOrder.approveStatus.2")}]</a>
						[/#if]
					</td>
				</tr>
			[/#list]
		</table>
		[@pagination pageNumber = page.pageNumber totalPages = page.totalPages]
			[#include "/admin/include/pagination.ftl"]
		[/@pagination]
	</form>
</body>
</html>