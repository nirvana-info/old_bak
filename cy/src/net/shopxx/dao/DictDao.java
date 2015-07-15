package net.shopxx.dao;

import java.util.List;

import net.shopxx.entity.Dict;
/**
 * Dao - 数据字典
 * 
 * 
 * 
 */
public interface DictDao extends BaseDao<Dict, Long> {
	
	List<Dict> findListByType(String type);
	
	boolean valueExists(String type, String value);
}