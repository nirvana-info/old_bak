package net.shopxx.service.impl;

import java.util.List;

import javax.annotation.Resource;

import net.shopxx.dao.DictDao;
import net.shopxx.entity.Dict;
import net.shopxx.service.DictService;

import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

@Service("dictServiceImpl")
public class DictServiceImpl extends BaseServiceImpl<Dict, Long> implements DictService {

	@Resource(name = "dictDaoImpl")
	private DictDao dictDao;
	
	@Resource(name = "dictDaoImpl")
	public void setDictDao(DictDao dictDao) {
		super.setBaseDao(dictDao);
	}

	@Transactional(readOnly = true)
	public List<Dict> findListByType(String type) {
		return dictDao.findListByType(type);
	}
	
	@Transactional(readOnly = true)
	public boolean valueExists(String type, String value){
		return dictDao.valueExists(type, value);
	}
	
}
