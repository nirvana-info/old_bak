/*
 * 
 * 
 * 
 */
package net.shopxx.dao.impl;

import javax.persistence.FlushModeType;
import javax.persistence.NoResultException;

import net.shopxx.dao.CombineHisDao;
import net.shopxx.entity.CombineHis;

import org.springframework.stereotype.Repository;

/**
 * Dao - 合并订单历史
 */
@Repository("combineHisDaoImpl")
public class CombineHisDaoImpl extends BaseDaoImpl<CombineHis, Long> implements CombineHisDao {

	@Override
	public CombineHis findByModifyDate(String modifyDate) {
		if (modifyDate == null) {
			return null;
		}
		String jpql = "select combineHis from CombineHis combineHis where '"+modifyDate+"' between combineHis.startDate and combineHis.endDate";
		try {
			return entityManager.createQuery(jpql, CombineHis.class).setFlushMode(FlushModeType.COMMIT).getSingleResult();
		} catch (NoResultException e) {
			return null;
		}
	}
	
	//获取最后一条合并记录
	public CombineHis getLastCombine(){
		String jpql = "select * from xx_combine_his order by create_date desc limit 1";
		CombineHis combineHis = null;
		try
		{
			combineHis = (CombineHis)entityManager.createNativeQuery(jpql, CombineHis.class).getSingleResult();
		} catch (Exception e)
		{
			return null;
		}
		return combineHis;
	}
}