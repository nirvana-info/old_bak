package net.shopxx.service;

import java.util.List;

import net.shopxx.entity.Dict;
/**
 * Service - 数据字典
 * 
 * 
 * 
 */
public interface DictService extends BaseService<Dict, Long>{

	List<Dict> findListByType(String type);
	
	boolean valueExists(String type, String value);
}
