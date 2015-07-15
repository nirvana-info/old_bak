package net.shopxx.service.impl;

import javax.annotation.Resource;

import net.shopxx.dao.SbuDao;
import net.shopxx.entity.Sbu;
import net.shopxx.service.SbuService;

import org.springframework.cache.annotation.CacheEvict;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;
/**
 * Service - 公司机构、单位
 * 
 * 
 * 
 */
@Service("sbuServiceImpl")
public class SbuServiceImpl extends BaseServiceImpl<Sbu, Long> implements SbuService {

	@Resource(name = "sbuDaoImpl")
	public void setBaseDao(SbuDao sbuDao) {
		super.setBaseDao(sbuDao);
	}

	@Override
	@Transactional
	@CacheEvict(value = "authorization", allEntries = true)
	public void save(Sbu sbu) {
		super.save(sbu);
	}

	@Override
	@Transactional
	@CacheEvict(value = "authorization", allEntries = true)
	public Sbu update(Sbu sbu) {
		return super.update(sbu);
	}

	@Override
	@Transactional
	@CacheEvict(value = "authorization", allEntries = true)
	public Sbu update(Sbu sbu, String... ignoreProperties) {
		return super.update(sbu, ignoreProperties);
	}

	@Override
	@Transactional
	@CacheEvict(value = "authorization", allEntries = true)
	public void delete(Long id) {
		super.delete(id);
	}

	@Override
	@Transactional
	@CacheEvict(value = "authorization", allEntries = true)
	public void delete(Long... ids) {
		super.delete(ids);
	}

	@Override
	@Transactional
	@CacheEvict(value = "authorization", allEntries = true)
	public void delete(Sbu sbu) {
		super.delete(sbu);
	}
}
