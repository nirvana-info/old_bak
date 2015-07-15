<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>${message("shop.password.mailTitle")}</title>

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
                    <th width="15%" style="font-family:Arial;">${message("shop.order.image")}</th>
                    <th width="40%" style="font-family:Arial;">${message("shop.order.product")}</th>
                    <th width="15%" style="font-family:Arial;">${message("shop.order.price")}</th>
                    <th width="15%" style="font-family:Arial;">${message("shop.order.quantity")}</th>
                    <th width="15%" style="font-family:Arial;">${message("shop.order.subTotal")}</th>
                </tr>
                [#list order.orderItems as orderItem]
                    <tr>
                        <td style="text-align:center;font-family:Arial;">
                            <img style="width:60px;height:60px;" src="[#if orderItem.product.thumbnail??]${orderItem.product.thumbnail}[#else]${setting.defaultThumbnailProductImage}[/#if]" alt="${orderItem.product.name}" />
                        </td>
                        <td style="font-family:Arial">
                            <a href="${base}${orderItem.product.path}" title="${orderItem.product.fullName}" target="_blank">${abbreviate(orderItem.product.fullName, 50, "...")}</a>
                            [#if orderItem.isGift]
                                <span class="red">[${message("shop.order.gift")}]</span>
                            [/#if]
                        </td>
                        <td style="text-align:left;font-family:Arial;">
                            [#if !orderItem.isGift]
                                [#if orderItem.product==orderItem.endPrice]
                                    ${currency(orderItem.price, true)}
                                [#else]
                                    ${currency(orderItem.endPrice, true)}
                                [/#if]
                            [#else]
                                -
                            [/#if]
                        </td>
                        <td style="text-align:left;font-family:Arial;">
                            ${orderItem.quantity}
                        </td>
                        <td style="text-align:left;font-family:Arial;">
                            [#if !orderItem.isGift]
                                [#if orderItem.subtotal==orderItem.finalSubtotal]
                                    ${currency(orderItem.subtotal, true)}
                                [#else]
                                    ${currency(orderItem.finalSubtotal, true)}
                                [/#if]
                            [#else]
                                -
                            [/#if]
                        </td>
                    </tr>
                [/#list]
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