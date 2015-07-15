/*
 * 
 * 
 * 
 */
package net.shopxx.service.impl;

import java.util.List;
import java.util.Set;

import javax.annotation.Resource;

import net.shopxx.dao.OrderSplitItemDao;
import net.shopxx.entity.CartItem;
import net.shopxx.entity.OrderSplitItem;
import net.shopxx.service.OrderSplitItemService;

import org.springframework.stereotype.Service;

/**
 * Service - 订单拆分项
 * 
 * 
 * 
 */
@Service("orderSplitItemServiceImpl")
public class OrderSplitItemServiceImpl extends BaseServiceImpl<OrderSplitItem, Long> implements OrderSplitItemService {

	@Resource(name = "orderSplitItemDaoImpl")
	private OrderSplitItemDao orderSplitItemDao;
	
	@Resource(name = "orderSplitItemDaoImpl")
	public void setBaseDao(OrderSplitItemDao orderSplitItemDao) {
		super.setBaseDao(orderSplitItemDao);
	}

	@Override
	public List<OrderSplitItem> findListByCartItem(long cartItemId) {
		return orderSplitItemDao.findListByCartItem(cartItemId);
	}

	@Override
	public List<OrderSplitItem> findListByOrderItem(long orderItemId) {
		return orderSplitItemDao.findListByOrderItem(orderItemId);
	}
	
	@Override
	public int deleteSplitListByCartItem(Set<CartItem> cartItems){
		return orderSplitItemDao.deleteSplitListByCartItem(cartItems);
	}

	@Override
	public String findExistsSplitProductIds(Set<CartItem> cartItems) {
		return orderSplitItemDao.findExistsSplitProductIds(cartItems);
	}

	@Override
	public List<OrderSplitItem> findListByCartItem(Set<CartItem> cartItems) {
		return orderSplitItemDao.findListByCartItem(cartItems);
	}

}