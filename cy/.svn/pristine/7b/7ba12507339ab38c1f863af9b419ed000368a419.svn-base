package net.shopxx.dao.impl;

import java.util.List;

import javax.persistence.FlushModeType;
import javax.persistence.NoResultException;
import javax.persistence.criteria.CriteriaBuilder;
import javax.persistence.criteria.CriteriaQuery;
import javax.persistence.criteria.Root;

import org.springframework.stereotype.Repository;

import net.shopxx.dao.DictDao;
import net.shopxx.entity.Dict;
import net.shopxx.entity.Order;
/**
 * Dao - 数据字典
 * 
 * 
 * 
 */
@Repository("dictDaoImpl")
public class DictDaoImpl extends BaseDaoImpl<Dict, Long> implements DictDao {

	public List<Dict> findListByType(String type) {
		CriteriaBuilder criteriaBuilder = entityManager.getCriteriaBuilder();
		CriteriaQuery<Dict> criteriaQuery = criteriaBuilder.createQuery(Dict.class);
		Root<Dict> root = criteriaQuery.from(Dict.class);
		criteriaQuery.select(root);
		criteriaQuery.where(criteriaBuilder.equal(root.get("type"), type));
		return super.findList(criteriaQuery, null, null, null, null);
	}
	
	public boolean valueExists(String type, String value){
		if (value == null) {
			return false;
		}
		String jpql = "select count(*) from Dict dict where lower(dict.type) = lower(:type) and lower(dict.value) = lower(:value)";
		Long count = entityManager.createQuery(jpql, Long.class).setFlushMode(FlushModeType.COMMIT).setParameter("type", type).setParameter("value", value).getSingleResult();
		return count > 0;
	}

}
