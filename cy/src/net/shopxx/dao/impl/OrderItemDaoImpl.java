/*
 * 
 * 
 * 
 */
package net.shopxx.dao.impl;

import java.util.List;

import net.shopxx.dao.OrderItemDao;
import net.shopxx.entity.OrderItem;

import org.springframework.stereotype.Repository;

/**
 * Dao - 订单项
 * 
 * 
 * 
 */
@Repository("orderItemDaoImpl")
public class OrderItemDaoImpl extends BaseDaoImpl<OrderItem, Long> implements OrderItemDao {
	//获取订单明细集合
	public List<OrderItem> getCombineOrderItemList(Long orderId) {
		String jpql="from OrderItem where order.id=:orderId";
		List<OrderItem> list = entityManager.createQuery(jpql, OrderItem.class).setParameter("orderId", orderId).getResultList();
		return list;
	}
}