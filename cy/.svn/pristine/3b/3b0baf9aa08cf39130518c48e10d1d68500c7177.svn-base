/*
 * 
 * 
 * 
 */
package net.shopxx.dao.impl;

import java.util.Collections;
import java.util.Iterator;
import java.util.List;
import java.util.Set;

import javax.persistence.criteria.CriteriaBuilder;
import javax.persistence.criteria.CriteriaBuilder.In;
import javax.persistence.criteria.CriteriaQuery;
import javax.persistence.criteria.Predicate;
import javax.persistence.criteria.Root;

import net.shopxx.dao.OrderSplitItemDao;
import net.shopxx.entity.CartItem;
import net.shopxx.entity.OrderItem;
import net.shopxx.entity.OrderSplitItem;
import net.shopxx.entity.ShippingMethod;

import org.springframework.stereotype.Repository;

/**
 * Dao - 订单拆分项
 * 
 * 
 * 
 */
@Repository("orderSplitItemDaoImpl")
public class OrderSplitItemDaoImpl extends BaseDaoImpl<OrderSplitItem, Long> implements OrderSplitItemDao {

	@Override
	public List<OrderSplitItem> findListByCartItem(long cartItemId) {
		if (cartItemId == 0) {
			return Collections.<OrderSplitItem> emptyList();
		}
		CartItem cartItem = new CartItem();
		cartItem.setId(cartItemId);
		CriteriaBuilder criteriaBuilder = entityManager.getCriteriaBuilder();
		CriteriaQuery<OrderSplitItem> criteriaQuery = criteriaBuilder.createQuery(OrderSplitItem.class);
		Root<OrderSplitItem> root = criteriaQuery.from(OrderSplitItem.class);
		criteriaQuery.select(root);
		Predicate restrictions = criteriaBuilder.conjunction();
		restrictions = criteriaBuilder.and(restrictions, criteriaBuilder.equal(root.get("cartItem"), cartItem));
		criteriaQuery.where(restrictions);
		return super.findList(criteriaQuery, null, null, null, null);
	}

	@Override
	public List<OrderSplitItem> findListByOrderItem(long orderItemId) {
		if (orderItemId == 0) {
			return Collections.<OrderSplitItem> emptyList();
		}
		OrderItem orderItem = new OrderItem();
		orderItem.setId(orderItemId);
		CriteriaBuilder criteriaBuilder = entityManager.getCriteriaBuilder();
		CriteriaQuery<OrderSplitItem> criteriaQuery = criteriaBuilder.createQuery(OrderSplitItem.class);
		Root<OrderSplitItem> root = criteriaQuery.from(OrderSplitItem.class);
		criteriaQuery.select(root);
		criteriaQuery.where(criteriaBuilder.equal(root.get("orderItem"), orderItem));
		return super.findList(criteriaQuery, null, null, null, null);
	}

	@Override
	public int deleteSplitListByCartItem(Set<CartItem> cartItems) {
		String cartItemIds = "";
		for (CartItem cartItem : cartItems) {
			cartItemIds += ","+cartItem.getId();
		}
		if (cartItemIds.length()>0) {
			cartItemIds = cartItemIds.substring(1);
		}
		String sql = "delete from xx_order_split_item where cart_item in("+cartItemIds+")";
		return entityManager.createNativeQuery(sql.toString()).executeUpdate();
	}

	@SuppressWarnings({ "unchecked", "rawtypes" })
	@Override
	public String findExistsSplitProductIds(Set<CartItem> cartItems) {
		CriteriaBuilder criteriaBuilder = entityManager.getCriteriaBuilder();
		CriteriaQuery<OrderSplitItem> criteriaQuery = criteriaBuilder.createQuery(OrderSplitItem.class);
		Root<OrderSplitItem> root = criteriaQuery.from(OrderSplitItem.class);
		criteriaQuery.select(root);
		Predicate restrictions = criteriaBuilder.conjunction();
		if (cartItems.size()>0) {
			Iterator iterator = cartItems.iterator();
	        In in = criteriaBuilder.in(root.get("cartItem"));
	        while (iterator.hasNext()) {
	            in.value(iterator.next());
	        }
	        restrictions = in;
		}
		criteriaQuery.where(restrictions);
		List<OrderSplitItem> list = super.findList(criteriaQuery, null, null, null, null);
		String productIds = "";
		if(list.size()>0){
			for (OrderSplitItem orderSplitItem : list) {
				productIds += "," + orderSplitItem.getProduct().getId();
			}
			if (productIds.length()>0) {
				productIds = productIds.substring(1);
			}
		}
		return productIds;
	}
	
	@SuppressWarnings({ "unchecked", "rawtypes" })
	@Override
	public List<OrderSplitItem> findListByCartItem(Set<CartItem> cartItems){
		CriteriaBuilder criteriaBuilder = entityManager.getCriteriaBuilder();
		CriteriaQuery<OrderSplitItem> criteriaQuery = criteriaBuilder.createQuery(OrderSplitItem.class);
		Root<OrderSplitItem> root = criteriaQuery.from(OrderSplitItem.class);
		criteriaQuery.select(root);
		Predicate restrictions = criteriaBuilder.conjunction();
		if (cartItems.size()>0) {
			Iterator iterator = cartItems.iterator();
	        In in = criteriaBuilder.in(root.get("cartItem"));
	        while (iterator.hasNext()) {
	            in.value(iterator.next());
	        }
	        restrictions = in;
		}
		criteriaQuery.where(restrictions);
		return super.findList(criteriaQuery, null, null, null, null);
	}

}