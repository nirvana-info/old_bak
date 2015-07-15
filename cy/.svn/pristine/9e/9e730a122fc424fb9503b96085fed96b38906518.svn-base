/*
 * 
 * 
 * 
 */
package net.shopxx.service.impl;

import java.util.List;

import javax.annotation.Resource;

import net.shopxx.dao.OrderItemDao;
import net.shopxx.entity.OrderItem;
import net.shopxx.service.OrderItemService;

import org.springframework.stereotype.Service;

/**
 * Service - 订单项
 * 
 * 
 * 
 */
@Service("orderItemServiceImpl")
public class OrderItemServiceImpl extends BaseServiceImpl<OrderItem, Long> implements OrderItemService {

	@Resource(name = "orderItemDaoImpl")
	public void setBaseDao(OrderItemDao orderItemDao) {
		super.setBaseDao(orderItemDao);
	}
	
	@Resource(name = "orderItemDaoImpl")
	private OrderItemDao orderItemDao;
	
	//获取订单明细集合
	public List<OrderItem> getCombineOrderItemList(Long orderId){
		return orderItemDao.getCombineOrderItemList(orderId);
	}

}