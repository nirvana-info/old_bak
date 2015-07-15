/*
 * 
 * 
 * 
 */
package net.shopxx.dao;

import net.shopxx.entity.CombineHis;

/**
 * Dao - 合并订单历史
 */
public interface CombineHisDao extends BaseDao<CombineHis, Long> {
	CombineHis findByModifyDate(String modifyDate);
	
	//获取最后一条合并记录
	public CombineHis getLastCombine();
}