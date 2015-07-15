package net.shopxx.dao.impl;

import java.util.Collections;

import javax.persistence.criteria.CriteriaBuilder;
import javax.persistence.criteria.CriteriaQuery;
import javax.persistence.criteria.Predicate;
import javax.persistence.criteria.Root;

import net.shopxx.Page;
import net.shopxx.Pageable;
import net.shopxx.dao.SpecialOrdersDao;
import net.shopxx.entity.Member;
import net.shopxx.entity.SpecialOrders;

import org.apache.commons.lang3.StringUtils;
import org.springframework.stereotype.Repository;

/**
 * Dao - Special Order
 * 
 * 
 * 
 */
@Repository("specialOrdersDaoImpl")
public class SpecialOrdersDaoImpl extends BaseDaoImpl<SpecialOrders, Long> implements SpecialOrdersDao{

	public Page<SpecialOrders> findPage(Member member, Pageable pageable) {
		if (member == null) {
			return new Page<SpecialOrders>(Collections.<SpecialOrders> emptyList(), 0, pageable);
		}
		CriteriaBuilder criteriaBuilder = entityManager.getCriteriaBuilder();
		CriteriaQuery<SpecialOrders> criteriaQuery = criteriaBuilder.createQuery(SpecialOrders.class);
		Root<SpecialOrders> root = criteriaQuery.from(SpecialOrders.class);
		criteriaQuery.select(root);
		criteriaQuery.where(criteriaBuilder.equal(root.get("member"), member));
		return super.findPage(criteriaQuery, pageable);
	}
	
	public Page<SpecialOrders> findPage(String approveStatus, Pageable pageable){
		CriteriaBuilder criteriaBuilder = entityManager.getCriteriaBuilder();
		CriteriaQuery<SpecialOrders> criteriaQuery = criteriaBuilder.createQuery(SpecialOrders.class);
		Root<SpecialOrders> root = criteriaQuery.from(SpecialOrders.class);
		criteriaQuery.select(root);
		Predicate restrictions = criteriaBuilder.conjunction();
		restrictions = criteriaBuilder.and(restrictions, criteriaBuilder.equal(root.get("submitStatus"), Integer.valueOf(1)));
		if (StringUtils.isNotBlank(approveStatus)) {
			restrictions = criteriaBuilder.and(restrictions, criteriaBuilder.equal(root.get("approveStatus"), Integer.valueOf(approveStatus)));
		}
		criteriaQuery.where(restrictions);
		return super.findPage(criteriaQuery, pageable);
	}
}
