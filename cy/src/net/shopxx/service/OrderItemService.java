/*
 * 
 * 
 * 
 */
package net.shopxx.service;

import java.util.List;

import net.shopxx.entity.OrderItem;

/**
 * Service - 订单项
 * 
 * 
 * 
 */
public interface OrderItemService extends BaseService<OrderItem, Long> {
	//获取订单明细集合
	public List<OrderItem> getCombineOrderItemList(Long orderId);
}