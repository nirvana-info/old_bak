package net.shopxx.dao;

import net.shopxx.Page;
import net.shopxx.Pageable;
import net.shopxx.entity.Member;
import net.shopxx.entity.SpecialOrders;

public interface SpecialOrdersDao extends BaseDao<SpecialOrders, Long>{

	Page<SpecialOrders> findPage(Member member, Pageable pageable);
	
	Page<SpecialOrders> findPage(String approveStatus, Pageable pageable);
}
