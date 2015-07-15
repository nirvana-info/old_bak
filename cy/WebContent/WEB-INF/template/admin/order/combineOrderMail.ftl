<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>PPG Combine Order</title>

<style type="text/css">

</style>
</head>
<body>
    <div style="font-family:Arial;">&nbsp;&nbsp;&nbsp;&nbsp;${tips}</div>
    [#if approvalUrl??]
    <div style="font-family:Arial;">&nbsp;&nbsp;&nbsp;&nbsp;${approvalUrl}</div>
    <div style="font-family:Arial;">&nbsp;&nbsp;&nbsp;&nbsp;${foot}</div>
    [/#if]
    <br>
    
    <div class="container order">
        <div style="width:80%">
            <div style="font-family:Arial">
                Order Id: ${order.sn}
            </div>
        	<table border=1 cellspacing=0 style="width:100%;font-family:Arial;">
                <tr>
					<th class="check">
						No.
					</th>
					<th>
						<span>Product Number</span>
					</th>
					<th>
	                    <span>Product Name</span>
					</th>
					<th>
	                    <span>Orginal Price</span>
					</th>
					<th>
	                    <span>Price</span>
					</th>
					<th>
	                    <span>Quantity</span>
					</th>
					<th>
	                    <span>Orginal Amount</span>
					</th>
					<th>
	                    <span>Amount</span>
					</th>
	                <th>
	                    <span>Cost Saving</span>
	                </th>
				</tr>
                [#list order.orderItems as orderItem]
                    <tr>
						<td>
							${orderItem_index+1}
						</td>
						<td>
							${orderItem.sn}
						</td>
						<td>
							${orderItem.name}
						</td>
						<td>
							[#if orderItem.oldPrice??]${currency(orderItem.oldPrice, true)}[#else]￥0.00[/#if]
						</td>
	                    <td>
	                        [#if orderItem.endPrice??]${currency(orderItem.endPrice, true)}[#else]￥0.00[/#if]
	                    </td>
	                    <td>
							${orderItem.quantity}
						</td>
						<td>
							[#if orderItem.oldPrice??]${currency(orderItem.oldPrice*orderItem.quantity, true)}[#else]￥0.00[/#if]
						</td>
	                    <td>
	                        [#if orderItem.endPrice??]${currency(orderItem.endPrice*orderItem.quantity, true)}[#else]￥0.00[/#if]
	                    </td>
	                    <td>
	                        [#if orderItem.oldPrice??]${currency((orderItem.oldPrice-orderItem.endPrice)*orderItem.quantity, true)}[#else]￥0.00[/#if]
	                    </td>
					</tr>
                [/#list]
                [#if order.orderItems??]
					<tr>
						<td colspan="6" align="right">
							Total：&nbsp;&nbsp;&nbsp;
						</td>
						<td>
							[#if oldPrice??]${currency(oldPrice, true)}[#else]￥0.00[/#if]
						</td>
	                    <td>
	                        [#if nowPrice??]${currency(nowPrice, true)}[#else]￥0.00[/#if]
	                    </td>
	                    <td>
	                       	[#if costSave??]${currency(costSave, true)}[#else]￥0.00[/#if]
	                    </td>
					</tr>
				[#else]
				[/#if]
            </table>
            <ul class="statistic" style="line-height: 30px;text-align: right;">
                <li style="padding: 0px;margin: 0px;border: 0px none;outline: 0px none;">
                    <span>
                        ${message("shop.order.freight")}: <em id="freight" style="color: #F60;font-style: normal;">${currency(order.freight, true)}</em>
                    </span>
                </li>
                <li style="padding: 0px;margin: 0px;border: 0px none;outline: 0px none;">
                    <span>
                        ${message("shop.order.amountPayable")}: <strong id="amountPayable" style="color: #EF0101;font-size: 14px;">${currency(order.amountPayable, true, false)}</strong>
                    </span>
                </li>
            </ul>
       </div>
    </div>
</body>
</html>