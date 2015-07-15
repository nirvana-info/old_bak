/*
 * 
 * 
 * 
 */
package net.shopxx.dao.impl;

import java.math.BigDecimal;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Collections;
import java.util.Date;
import java.util.Iterator;
import java.util.List;
import java.util.Set;

import javax.annotation.Resource;
import javax.persistence.FlushModeType;
import javax.persistence.LockModeType;
import javax.persistence.NoResultException;
import javax.persistence.criteria.CriteriaBuilder;
import javax.persistence.criteria.CriteriaBuilder.In;
import javax.persistence.criteria.CriteriaQuery;
import javax.persistence.criteria.Predicate;
import javax.persistence.criteria.Root;

import net.shopxx.Filter;
import net.shopxx.Page;
import net.shopxx.Pageable;
import net.shopxx.dao.CombineHisDao;
import net.shopxx.dao.OrderDao;
import net.shopxx.entity.CombineHis;
import net.shopxx.entity.Job;
import net.shopxx.entity.Member;
import net.shopxx.entity.Order;
import net.shopxx.entity.Order.OrderStatus;
import net.shopxx.entity.Order.PaymentStatus;
import net.shopxx.entity.Order.ShippingStatus;
import net.shopxx.entity.OrderItem;
import net.shopxx.entity.Product;
import net.shopxx.service.MailService;

import org.springframework.stereotype.Repository;

/**
 * Dao - 订单
 * 
 * 
 * 
 */
@Repository("orderDaoImpl")
public class OrderDaoImpl extends BaseDaoImpl<Order, Long> implements OrderDao {

	@Resource(name = "combineHisDaoImpl")
	private CombineHisDao combineHisDao;
	
	@Resource(name = "mailServiceImpl")
	private MailService mailService;

	
	public Order findBySn(String sn) {
		if (sn == null) {
			return null;
		}
		String jpql = "select orders from Order orders where lower(orders.sn) = lower(:sn)";
		try {
			return entityManager.createQuery(jpql, Order.class).setFlushMode(FlushModeType.COMMIT).setParameter("sn", sn).getSingleResult();
		} catch (NoResultException e) {
			return null;
		}
	}

	public List<Order> findList(Member member, Integer count, List<Filter> filters, List<net.shopxx.Order> orders) {
		if (member == null) {
			return Collections.<Order> emptyList();
		}
		CriteriaBuilder criteriaBuilder = entityManager.getCriteriaBuilder();
		CriteriaQuery<Order> criteriaQuery = criteriaBuilder.createQuery(Order.class);
		Root<Order> root = criteriaQuery.from(Order.class);
		criteriaQuery.select(root);
		criteriaQuery.where(criteriaBuilder.equal(root.get("member"), member));
		return super.findList(criteriaQuery, null, count, filters, orders);
	}

	public Page<Order> findPage(Member member, Pageable pageable) {
		if (member == null) {
			return new Page<Order>(Collections.<Order> emptyList(), 0, pageable);
		}
		CriteriaBuilder criteriaBuilder = entityManager.getCriteriaBuilder();
		CriteriaQuery<Order> criteriaQuery = criteriaBuilder.createQuery(Order.class);
		Root<Order> root = criteriaQuery.from(Order.class);
		criteriaQuery.select(root);
		criteriaQuery.where(criteriaBuilder.equal(root.get("member"), member));
		return super.findPage(criteriaQuery, pageable);
	}

	public Page<Order> findPage(OrderStatus orderStatus, PaymentStatus paymentStatus, ShippingStatus shippingStatus, Boolean hasExpired, Pageable pageable) {
		CriteriaBuilder criteriaBuilder = entityManager.getCriteriaBuilder();
		CriteriaQuery<Order> criteriaQuery = criteriaBuilder.createQuery(Order.class);
		Root<Order> root = criteriaQuery.from(Order.class);
		criteriaQuery.select(root);
		Predicate restrictions = criteriaBuilder.conjunction();
		if (orderStatus != null) {
			restrictions = criteriaBuilder.and(restrictions, criteriaBuilder.equal(root.get("orderStatus"), orderStatus));
		}
		if (paymentStatus != null) {
			restrictions = criteriaBuilder.and(restrictions, criteriaBuilder.equal(root.get("paymentStatus"), paymentStatus));
		}
		if (shippingStatus != null) {
			restrictions = criteriaBuilder.and(restrictions, criteriaBuilder.equal(root.get("shippingStatus"), shippingStatus));
		}
		if (hasExpired != null) {
			if (hasExpired) {
				restrictions = criteriaBuilder.and(restrictions, root.get("expire").isNotNull(), criteriaBuilder.lessThan(root.<Date> get("expire"), new Date()));
			} else {
				restrictions = criteriaBuilder.and(restrictions, criteriaBuilder.or(root.get("expire").isNull(), criteriaBuilder.greaterThanOrEqualTo(root.<Date> get("expire"), new Date())));
			}
		}
		criteriaQuery.where(restrictions);
		return super.findPage(criteriaQuery, pageable);
	}
	
	@SuppressWarnings({ "rawtypes", "unchecked" })
	public Page<Order> findPage(OrderStatus orderStatus, PaymentStatus paymentStatus, ShippingStatus shippingStatus, Boolean hasExpired, Pageable pageable, Set<Member> members) {
		CriteriaBuilder criteriaBuilder = entityManager.getCriteriaBuilder();
		CriteriaQuery<Order> criteriaQuery = criteriaBuilder.createQuery(Order.class);
		Root<Order> root = criteriaQuery.from(Order.class);
		criteriaQuery.select(root);
		Predicate restrictions = criteriaBuilder.conjunction();
		if (orderStatus != null) {
			restrictions = criteriaBuilder.and(restrictions, criteriaBuilder.equal(root.get("orderStatus"), orderStatus));
		}
		if (paymentStatus != null) {
			restrictions = criteriaBuilder.and(restrictions, criteriaBuilder.equal(root.get("paymentStatus"), paymentStatus));
		}
		if (shippingStatus != null) {
			restrictions = criteriaBuilder.and(restrictions, criteriaBuilder.equal(root.get("shippingStatus"), shippingStatus));
		}
		if (hasExpired != null) {
			if (hasExpired) {
				restrictions = criteriaBuilder.and(restrictions, root.get("expire").isNotNull(), criteriaBuilder.lessThan(root.<Date> get("expire"), new Date()));
			} else {
				restrictions = criteriaBuilder.and(restrictions, criteriaBuilder.or(root.get("expire").isNull(), criteriaBuilder.greaterThanOrEqualTo(root.<Date> get("expire"), new Date())));
			}
		}
		if (members.size()>0) { //根据会员过滤
			Iterator iterator = members.iterator();
	        In in = criteriaBuilder.in(root.get("member"));
	        while (iterator.hasNext()) {
	            in.value(iterator.next());
	        }
	        restrictions = in;
		}else{
			return new Page<Order>(new ArrayList<Order>(), 0, pageable);
		}
		criteriaQuery.where(restrictions);
		return super.findPage(criteriaQuery, pageable);
	}

	public Long count(OrderStatus orderStatus, PaymentStatus paymentStatus, ShippingStatus shippingStatus, Boolean hasExpired) {
		CriteriaBuilder criteriaBuilder = entityManager.getCriteriaBuilder();
		CriteriaQuery<Order> criteriaQuery = criteriaBuilder.createQuery(Order.class);
		Root<Order> root = criteriaQuery.from(Order.class);
		criteriaQuery.select(root);
		Predicate restrictions = criteriaBuilder.conjunction();
		if (orderStatus != null) {
			restrictions = criteriaBuilder.and(restrictions, criteriaBuilder.equal(root.get("orderStatus"), orderStatus));
		}
		if (paymentStatus != null) {
			restrictions = criteriaBuilder.and(restrictions, criteriaBuilder.equal(root.get("paymentStatus"), paymentStatus));
		}
		if (shippingStatus != null) {
			restrictions = criteriaBuilder.and(restrictions, criteriaBuilder.equal(root.get("shippingStatus"), shippingStatus));
		}
		if (hasExpired != null) {
			if (hasExpired) {
				restrictions = criteriaBuilder.and(restrictions, root.get("expire").isNotNull(), criteriaBuilder.lessThan(root.<Date> get("expire"), new Date()));
			} else {
				restrictions = criteriaBuilder.and(restrictions, criteriaBuilder.or(root.get("expire").isNull(), criteriaBuilder.greaterThanOrEqualTo(root.<Date> get("expire"), new Date())));
			}
		}
		criteriaQuery.where(restrictions);
		return super.count(criteriaQuery, null);
	}

	public Long waitingPaymentCount(Member member) {
		CriteriaBuilder criteriaBuilder = entityManager.getCriteriaBuilder();
		CriteriaQuery<Order> criteriaQuery = criteriaBuilder.createQuery(Order.class);
		Root<Order> root = criteriaQuery.from(Order.class);
		criteriaQuery.select(root);
		Predicate restrictions = criteriaBuilder.conjunction();
		restrictions = criteriaBuilder.and(restrictions, criteriaBuilder.notEqual(root.get("orderStatus"), OrderStatus.completed), criteriaBuilder.notEqual(root.get("orderStatus"), OrderStatus.cancelled));
		restrictions = criteriaBuilder.and(restrictions, criteriaBuilder.or(criteriaBuilder.equal(root.get("paymentStatus"), PaymentStatus.unpaid), criteriaBuilder.equal(root.get("paymentStatus"), PaymentStatus.partialPayment)));
		restrictions = criteriaBuilder.and(restrictions, criteriaBuilder.or(root.get("expire").isNull(), criteriaBuilder.greaterThanOrEqualTo(root.<Date> get("expire"), new Date())));
		if (member != null) {
			restrictions = criteriaBuilder.and(restrictions, criteriaBuilder.equal(root.get("member"), member));
		}
		criteriaQuery.where(restrictions);
		return super.count(criteriaQuery, null);
	}

	public Long waitingShippingCount(Member member) {
		CriteriaBuilder criteriaBuilder = entityManager.getCriteriaBuilder();
		CriteriaQuery<Order> criteriaQuery = criteriaBuilder.createQuery(Order.class);
		Root<Order> root = criteriaQuery.from(Order.class);
		criteriaQuery.select(root);
		Predicate restrictions = criteriaBuilder.conjunction();
		restrictions = criteriaBuilder.and(restrictions, criteriaBuilder.notEqual(root.get("orderStatus"), OrderStatus.completed), criteriaBuilder.notEqual(root.get("orderStatus"), OrderStatus.cancelled), criteriaBuilder.equal(root.get("paymentStatus"), PaymentStatus.paid), criteriaBuilder.equal(root.get("shippingStatus"), ShippingStatus.unshipped));
		restrictions = criteriaBuilder.and(restrictions, criteriaBuilder.or(root.get("expire").isNull(), criteriaBuilder.greaterThanOrEqualTo(root.<Date> get("expire"), new Date())));
		if (member != null) {
			restrictions = criteriaBuilder.and(restrictions, criteriaBuilder.equal(root.get("member"), member));
		}
		criteriaQuery.where(restrictions);
		return super.count(criteriaQuery, null);
	}

	public BigDecimal getSalesAmount(Date beginDate, Date endDate) {
		CriteriaBuilder criteriaBuilder = entityManager.getCriteriaBuilder();
		CriteriaQuery<BigDecimal> criteriaQuery = criteriaBuilder.createQuery(BigDecimal.class);
		Root<Order> root = criteriaQuery.from(Order.class);
		criteriaQuery.select(criteriaBuilder.sum(root.<BigDecimal> get("amountPaid")));
		Predicate restrictions = criteriaBuilder.conjunction();
		restrictions = criteriaBuilder.and(restrictions, criteriaBuilder.equal(root.get("orderStatus"), OrderStatus.completed));
		if (beginDate != null) {
			restrictions = criteriaBuilder.and(restrictions, criteriaBuilder.greaterThanOrEqualTo(root.<Date> get("createDate"), beginDate));
		}
		if (endDate != null) {
			restrictions = criteriaBuilder.and(restrictions, criteriaBuilder.lessThanOrEqualTo(root.<Date> get("createDate"), endDate));
		}
		criteriaQuery.where(restrictions);
		return entityManager.createQuery(criteriaQuery).setFlushMode(FlushModeType.COMMIT).getSingleResult();
	}

	public Integer getSalesVolume(Date beginDate, Date endDate) {
		CriteriaBuilder criteriaBuilder = entityManager.getCriteriaBuilder();
		CriteriaQuery<Integer> criteriaQuery = criteriaBuilder.createQuery(Integer.class);
		Root<Order> root = criteriaQuery.from(Order.class);
		criteriaQuery.select(criteriaBuilder.sum(root.join("orderItems").<Integer> get("shippedQuantity")));
		Predicate restrictions = criteriaBuilder.conjunction();
		restrictions = criteriaBuilder.and(restrictions, criteriaBuilder.equal(root.get("orderStatus"), OrderStatus.completed));
		if (beginDate != null) {
			restrictions = criteriaBuilder.and(restrictions, criteriaBuilder.greaterThanOrEqualTo(root.<Date> get("createDate"), beginDate));
		}
		if (endDate != null) {
			restrictions = criteriaBuilder.and(restrictions, criteriaBuilder.lessThanOrEqualTo(root.<Date> get("createDate"), endDate));
		}
		criteriaQuery.where(restrictions);
		return entityManager.createQuery(criteriaQuery).setFlushMode(FlushModeType.COMMIT).getSingleResult();
	}

	public void releaseStock() {
		String jpql = "select orders from Order orders where orders.isAllocatedStock = :isAllocatedStock and orders.expire is not null and orders.expire <= :now";
		List<Order> orders = entityManager.createQuery(jpql, Order.class).setParameter("isAllocatedStock", true).setParameter("now", new Date()).getResultList();
		if (orders != null) {
			for (Order order : orders) {
				if (order != null && order.getOrderItems() != null) {
					for (OrderItem orderItem : order.getOrderItems()) {
						if (orderItem != null) {
							Product product = orderItem.getProduct();
							if (product != null) {
								entityManager.lock(product, LockModeType.PESSIMISTIC_WRITE);
								product.setAllocatedStock(product.getAllocatedStock() - (orderItem.getQuantity() - orderItem.getShippedQuantity()));
							}
						}
					}
					order.setIsAllocatedStock(false);
				}
			}
		}
	}
	
	@Override
	public List<CombineHis> findCombinePage() {
	    String jpql = "from CombineHis his order by his.endDate desc ";
	    //String jpql = "select his.*,a.username as createUser from xx_combine_his his left join xx_admin a on his.create_by=a.id order by his.end_date desc ";
        List<CombineHis> combines = entityManager.createQuery(jpql, CombineHis.class).getResultList();
        return combines;
	}
	
	@Override
	public List<Job> findJob(Job job) {
	    String jpql = "select Job from Job job where job.module = :module order by job.triggeringDate";
        List<Job> jobs = entityManager.createQuery(jpql, Job.class).setParameter("module", job.getModule()).getResultList();
	    return jobs;
	}
	
	@Override
	public int combineOrder(String startDate, String endDate) {
	    int combineHisId = 0;
	    // 取得合并后产品的阶梯价格
	    StringBuffer sql = new StringBuffer();
	    sql.append("select ");
	    sql.append("   gp.product,gp.price ");
	    sql.append("FROM ");
	    sql.append("    xx_gradient_price gp ");
	    sql.append("    inner join ( ");
	    sql.append("    select ");
	    sql.append("        ords.product,sum(quantity) quantity ");
	    sql.append("    from  ");
	    sql.append("        xx_order ord INNER join xx_order_item ords on ord.id=ords.orders ");
        sql.append("    where ord.modify_date BETWEEN :startDate and :endDate and ord.combine=1 and ord.order_status=1 and ord.combine_his_id is null ");
	    sql.append("    group by ords.product) oi ");
	    sql.append("    on gp.product = oi.product and oi.quantity BETWEEN gp.start_quantity and gp.end_quantity ");
        List<?> itemProducts = entityManager.createNativeQuery(sql.toString()).setParameter("startDate", startDate).setParameter("endDate", endDate).getResultList();
        if (itemProducts == null || itemProducts.size() == 0) {
            return 0;
        }
        
        String orderIds="";
        for (Object obj : itemProducts) {
            Object[] objs = (Object[])obj;
            sql.delete(0, sql.length());
            // 取得可更新的订单明细
            sql.append("select ords.id as ordItemId,ord.id as ordId ");
            sql.append("from xx_order ord INNER join xx_order_item ords on ord.id=ords.orders ");
            sql.append("where ord.modify_date BETWEEN :startDate and :endDate and ords.product=:product and ord.combine=1 and ord.order_status=1 and ord.combine_his_id is null");
            List<?> itemIds = entityManager.createNativeQuery(sql.toString())
                    .setParameter("startDate", startDate)
                    .setParameter("endDate", endDate)
                    .setParameter("product", objs[0].toString())
                    .getResultList();
            if (itemIds != null && itemIds.size() > 0) {
                String ids = "";
                for (Object obj2 : itemIds) {
                	Object[] objs2 = (Object[])obj2;
                    ids += "," + objs2[0];
                    if(orderIds.indexOf(objs2[1].toString())==-1){
                    	orderIds += "," + objs2[1];
                    }
                }
                // 更新产品价格
                sql.delete(0, sql.length());
                sql.append("update xx_order_item ");
                sql.append("set end_price=" + objs[1].toString() + ",modify_date=now()");
                sql.append(" where id in (" + ids.substring(1) + ")");
                entityManager.createNativeQuery(sql.toString()).executeUpdate();
            }
        }
        
        
        
        BigDecimal newTotalPrice=new BigDecimal(0);
        BigDecimal oldTotalPrice=new BigDecimal(0);
        BigDecimal newPrice=new BigDecimal(0);
        BigDecimal oldPrice=new BigDecimal(0);
        BigDecimal quantity=new BigDecimal(1);
        List<Object> objects = getOrderPrice(startDate, endDate);
        
        if(null!=objects && objects.size()>0){
        	for (Object obj : objects) {
                Object[] objs = (Object[])obj;
                if(objs[1]!=null){
        			newPrice = (BigDecimal) objs[1];
        		}
        		if(objs[0]!=null){
        			oldPrice = (BigDecimal) objs[0];
        		}
        		if(objs[2]!=null){
        			quantity = (BigDecimal) objs[2];
        		}
        		
        		newTotalPrice = newTotalPrice.add(newPrice.multiply(quantity));
        		oldTotalPrice = oldTotalPrice.add(oldPrice.multiply(quantity));
            }
        }
    	
    	//插入CombinHis Table
  		CombineHis combineHis=new CombineHis();
  		combineHis.setStartDate(startDate);
  		
  		//判定最后合并日期
  		Order comBineUnconfirmedOrder = getCombineUnconfirmedOrder(startDate, endDate);
  		if(null!=comBineUnconfirmedOrder){
  			DateFormat fmt = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
  			combineHis.setEndDate(fmt.format(comBineUnconfirmedOrder.getModifyDate()));
  		}else{
  			combineHis.setEndDate(endDate);
  		}
  		
  		combineHis.setCreateDate(new Date());
  		combineHis.setModifyDate(new Date());
  		combineHis.setCreateBy(1l);
  		combineHis.setCreateUser("");
  		combineHis.setNewTotalAmount(newTotalPrice);
  		combineHis.setOldTotalAmount(oldTotalPrice);
  		combineHis.setAdmin(0l);
  		combineHisDao.persist(combineHis);
        
  		//更新order表
  		if(null!=orderIds && !"".equals(orderIds)){
  			CombineHis combineHis2=combineHisDao.getLastCombine();
  			combineHisId=combineHis2.getId().intValue();
  			if(null!=combineHis2){
  				String sql2="update xx_order set combine_his_id=" + combineHis2.getId() + " where id in (" + orderIds.substring(1) + ")";
                entityManager.createNativeQuery(sql2).executeUpdate();
  			}
  		}
  		
  		//发送邮件
  		String jpql="from Order o where o.id in (" + orderIds.substring(1) + ")";
		List<Order> orderList = entityManager.createQuery(jpql, Order.class).getResultList();
		mailService.sendCombineMail(orderList);
  		
        return combineHisId;
	}
	
	//获取合并订单后的价格
	public List<Object> getOrderPrice(String startDate, String endDate) {
	    String sql="select ords.old_price as oldPrice,ords.end_price as endPrice,sum(ords.quantity) as quantity from xx_order ord INNER join xx_order_item ords on ord.id=ords.orders where ord.modify_date BETWEEN :startDate and :endDate and ord.combine=1 and ord.order_status=1 and ord.combine_his_id is null GROUP BY ords.name";
	    List<Object> objects = entityManager.createNativeQuery(sql.toString()).setParameter("startDate", startDate).setParameter("endDate", endDate).getResultList();
        return objects;
	}
	
	
	//获取合并订单集合(弃用)
	public List<Order> getCombineOrderList(String startDate, String endDate) {
		
		//String jpql="from Order o where o.modifyDate BETWEEN :startDate and :endDate order by o.modifyDate desc";
		String jpql="select o.* from xx_order o where o.modify_date BETWEEN :startDate and :endDate and combine=1 and o.combine_his_id is not null order by o.modify_date desc";
		//List<Order> comBineOrderList = (List<Order>) entityManager.createNativeQuery(sql.toString()).getResultList();
		List<Order> comBineOrderList = entityManager.createNativeQuery(jpql, Order.class).setParameter("startDate", startDate).setParameter("endDate", endDate).getResultList();
		return comBineOrderList;
	}
	
	//通过combineHisId查下订单集合
	public List<Order> getCombineOrderList(Integer combineHisId) {
		
		String jpql="select o.* from xx_order o where combine=1 and o.combine_his_id = :combineHisId order by o.modify_date desc";
		List<Order> comBineOrderList = entityManager.createNativeQuery(jpql, Order.class).setParameter("combineHisId", combineHisId).getResultList();
		return comBineOrderList;
	}
	
	//获取在合并时间段内的待审核的最小更新日期订单订单
		public Order getCombineUnconfirmedOrder(String startDate, String endDate) {
			Order comBineOrder=null;
			try
			{
				String jpql="select o.* from xx_order o where o.modify_date BETWEEN :startDate and :endDate and combine=1 and o.order_status!=1 and o.combine_his_id is null order by o.modify_date limit 1";
				comBineOrder = (Order) entityManager.createNativeQuery(jpql, Order.class).setParameter("startDate", startDate).setParameter("endDate", endDate).getSingleResult();
			} catch (Exception e)
			{
				return null;
			}
			return comBineOrder;
		}

}