/*
 * 
 * 
 * 
 */
package net.shopxx.dao;

import java.util.List;
import java.util.Set;

import net.shopxx.entity.CartItem;
import net.shopxx.entity.OrderSplitItem;

/**
 * Dao - 订单拆分项
 * 
 * 
 * 
 */
public interface OrderSplitItemDao extends BaseDao<OrderSplitItem, Long> {

	public List<OrderSplitItem> findListByCartItem(long cartItemId);
	
	public List<OrderSplitItem> findListByCartItem(Set<CartItem> cartItems);
	
	public List<OrderSplitItem> findListByOrderItem(long orderItemId);
	
	public int deleteSplitListByCartItem(Set<CartItem> cartItems);
	
	public String findExistsSplitProductIds(Set<CartItem> cartItems);
}