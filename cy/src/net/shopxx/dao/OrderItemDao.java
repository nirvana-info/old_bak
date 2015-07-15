/*
 * 
 * 
 * 
 */
package net.shopxx.dao;

import java.util.List;

import net.shopxx.entity.OrderItem;

/**
 * Dao - 订单项
 * 
 * 
 * 
 */
public interface OrderItemDao extends BaseDao<OrderItem, Long> {
	//获取订单明细集合
	public List<OrderItem> getCombineOrderItemList(Long orderId);
}