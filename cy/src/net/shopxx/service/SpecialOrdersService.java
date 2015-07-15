package net.shopxx.service;

import net.shopxx.Page;
import net.shopxx.Pageable;
import net.shopxx.entity.Member;
import net.shopxx.entity.SpecialOrders;

public interface SpecialOrdersService extends BaseService<SpecialOrders, Long> {

	void submit(SpecialOrders bean);
	
	void confirm(SpecialOrders bean);
	
	void cancel(SpecialOrders bean);
	
	Page<SpecialOrders> findPage(Member member, Pageable pageable);
	
	Page<SpecialOrders> findPage(String approveStatus, Pageable pageable);
}
