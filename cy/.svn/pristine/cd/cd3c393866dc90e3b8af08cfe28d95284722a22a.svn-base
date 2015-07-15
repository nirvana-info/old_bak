package net.shopxx.service.impl;

import javax.annotation.Resource;

import net.shopxx.Page;
import net.shopxx.Pageable;
import net.shopxx.dao.SpecialOrdersDao;
import net.shopxx.entity.Member;
import net.shopxx.entity.SpecialOrders;
import net.shopxx.service.SpecialOrdersService;

import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;
import org.springframework.util.Assert;
/**
 * Service - Special Order
 * 
 * 
 * 
 */
@Service("specialOrdersServiceImpl")
public class SpecialOrdersServiceImpl extends BaseServiceImpl<SpecialOrders, Long> implements SpecialOrdersService{

	@Resource(name = "specialOrdersDaoImpl")
	private SpecialOrdersDao specialOrdersDao;
	@Resource(name = "specialOrdersDaoImpl")
	public void setSpecialOrdersDao(SpecialOrdersDao specialOrdersDao) {
		super.setBaseDao(specialOrdersDao);
	}

	public void submit(SpecialOrders bean) {
		Assert.notNull(bean);
		bean.setSubmitStatus(1);
		specialOrdersDao.merge(bean);
	}

	public void confirm(SpecialOrders bean) {
		Assert.notNull(bean);
		bean.setApproveStatus(1);
		specialOrdersDao.merge(bean);
	}

	public void cancel(SpecialOrders bean) {
		Assert.notNull(bean);
		bean.setApproveStatus(2);
		specialOrdersDao.merge(bean);
	}

	@Transactional(readOnly = true)
	public Page<SpecialOrders> findPage(Member member, Pageable pageable) {
		return specialOrdersDao.findPage(member, pageable);
	}
	
	@Transactional(readOnly = true)
	public Page<SpecialOrders> findPage(String approveStatus, Pageable pageable){
		return specialOrdersDao.findPage(approveStatus, pageable);
	}
}
