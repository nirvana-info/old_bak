[#assign shiro=JspTaglibs["/WEB-INF/tld/shiro.tld"] /]
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>${message("admin.order.combineList")}</title>


<link href="${base}/resources/admin/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="${base}/resources/admin/js/jquery.js"></script>
<script type="text/javascript" src="${base}/resources/admin/js/common.js"></script>
<script type="text/javascript" src="${base}/resources/admin/js/list.js"></script>
<script type="text/javascript" src="${base}/resources/admin/datePicker/WdatePicker.js"></script>
<script type="text/javascript" src="${base}/resources/shop/layer-master/layer.js"></script>
<script type="text/javascript">
$().ready(function() {

});

// 确认
function confirmOrder(obj){
	var $this = $(obj);
	$("#confirmForm").find("input[name='id']").val($this.attr("orderid"));
	$.dialog({
		type: "warn",
		content: "${message("admin.order.confirmDialog")}",
		onOk: function() {
			$("#confirmForm").submit();
		}
	});
}

function showSplitInfo(id){
	$.layer({
        type: 2,
        title: [
            'Combine Order List', 
            'height:40px; color:#fff; border:none;' //customer config
        ], 
        border:[1],
        area: ['90%', '90%'],
        fadeIn: 300,
        iframe: {src: 'combineOrderList.jhtml?combineHisId='+id},
	    close: function(index){ //右上角关闭回调
	    	layer.close(index);
	    }, 
	    end: function(){//终极销毁回调
	    	
	    } 
    })
}

function formSubmit(){
	var endDate=$("#endDate").val();
	if(endDate==""){
		alert("请选择时间!");
		return;
	}
	$("#form").submit();
}
</script>

</head>
<body>
	<form id="form" action="combineOrder.jhtml" method="post">
        <table class="input">
            <tr>
                <th>
                    ${message("Order.combine.startDate")}
                </th>
                <td>
                	[#if endDate??]
                	${endDate}
                	<input type="hidden" value="${endDate}" name="startDate" />
                	[#else]
                	<input name="startDate" id="startDate" type="text" onClick="WdatePicker({lang:'en',dateFmt:'yyyy-MM-dd HH:mm:ss'})" style="font: 12px tahoma, Arial, Verdana, sans-serif;" />
                	[/#if]
                </td>
            </tr>
            <tr>
                <th>
                    ${message("Order.combine.endDate")}
                </th>
                <td>
                    <input id="endDate" name="endDate" type="text" onClick="WdatePicker({lang:'en',dateFmt:'yyyy-MM-dd HH:mm:ss',maxDate:'%y-%M-%d %H:%m:%s',minDate:'[#if endDate??]${endDate}[#else]#F{$dp.$D(\'startDate\')}[/#if]'})" style="font: 12px tahoma, Arial, Verdana, sans-serif;" />
                </td>
            </tr>
            <tr>
                <th>
                    
                </th>
                <td>
                	<input type="button" class="button" value="${message("admin.common.combine")}" onclick="formSubmit();" />
                	[#if combineHisId??]You saved RMB <font color="red"><a href="javascript:showSplitInfo('${combineHisId}')" style="color: red;">${currency(costSave, true)}</a></font> for PPG through combining the order.[/#if]
                </td>
            </tr>
        </table>
	       
		<table id="listTable" class="list">
			<tr>
				<th class="check">
					No.
				</th>
				<th>
					<span>${message("Order.combine.startDate")}</span>
				</th>
				<th>
                    <span>${message("Order.combine.endDate")}</span>
				</th>
				<th>
                    <span>${message("Order.combine.oldTotalAmount")}</span>
				</th>
				<th>
                    <span>${message("Order.combine.newTotalAmount")}</span>
				</th>
                <th>
                    <span>${message("Order.combine.costSave")}</span>
                </th>
				<!--<th>
					<span>${message("Order.combine.handler")}</span>
				</th>-->
			</tr>
			[#list combineList as combineHis]
				<tr>
					<td>
						${combineHis_index+1}
					</td>
					<td>
						${combineHis.startDate}
					</td>
					<td>
						${combineHis.endDate}
					</td>
                    <td>
                        ${currency(combineHis.oldTotalAmount, true)}
                    </td>
                    <td>
                        ${currency(combineHis.newTotalAmount, true)}
                    </td>
                    <td>
                        <a href="javascript:;" onclick="showSplitInfo('${combineHis.id}')" style="color: blue;">${currency(combineHis.oldTotalAmount-combineHis.newTotalAmount, true)}</a>
                    </td>
                    <!--<td>
                        [#if combineHis.createBy??]${combineHis.createBy}[#else]System[/#if]
                    </td>-->
				</tr>
			[/#list]
		</table>
	</form>

</body>
</html>