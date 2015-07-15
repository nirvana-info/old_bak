/*
 * 
 * 
 * 
 */
package net.shopxx.service.impl;

import java.math.BigDecimal;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;
import java.util.LinkedHashMap;
import java.util.List;
import java.util.Map;
import java.util.Set;

import javax.annotation.Resource;
import javax.persistence.LockModeType;

import net.shopxx.Filter;
import net.shopxx.Page;
import net.shopxx.Pageable;
import net.shopxx.Setting;
import net.shopxx.Setting.StockAllocationTime;
import net.shopxx.dao.CartDao;
import net.shopxx.dao.CombineHisDao;
import net.shopxx.dao.CouponCodeDao;
import net.shopxx.dao.DepositDao;
import net.shopxx.dao.MemberDao;
import net.shopxx.dao.MemberRankDao;
import net.shopxx.dao.OrderDao;
import net.shopxx.dao.OrderItemDao;
import net.shopxx.dao.OrderLogDao;
import net.shopxx.dao.OrderSplitItemDao;
import net.shopxx.dao.PaymentDao;
import net.shopxx.dao.ProductDao;
import net.shopxx.dao.ReceiverDao;
import net.shopxx.dao.RefundsDao;
import net.shopxx.dao.ReturnsDao;
import net.shopxx.dao.ShippingDao;
import net.shopxx.dao.SnDao;
import net.shopxx.entity.Admin;
import net.shopxx.entity.Cart;
import net.shopxx.entity.CartItem;
import net.shopxx.entity.CombineHis;
import net.shopxx.entity.Coupon;
import net.shopxx.entity.CouponCode;
import net.shopxx.entity.Deposit;
import net.shopxx.entity.GiftItem;
import net.shopxx.entity.Job;
import net.shopxx.entity.Member;
import net.shopxx.entity.MemberRank;
import net.shopxx.entity.Order;
import net.shopxx.entity.Order.OrderStatus;
import net.shopxx.entity.Order.PaymentStatus;
import net.shopxx.entity.Order.ShippingStatus;
import net.shopxx.entity.OrderItem;
import net.shopxx.entity.OrderLog;
import net.shopxx.entity.OrderLog.Type;
import net.shopxx.entity.OrderSplitItem;
import net.shopxx.entity.Payment;
import net.shopxx.entity.PaymentMethod;
import net.shopxx.entity.Product;
import net.shopxx.entity.Promotion;
import net.shopxx.entity.Receiver;
import net.shopxx.entity.Refunds;
import net.shopxx.entity.Returns;
import net.shopxx.entity.ReturnsItem;
import net.shopxx.entity.Shipping;
import net.shopxx.entity.ShippingItem;
import net.shopxx.entity.ShippingMethod;
import net.shopxx.entity.ShippingMethodDetail;
import net.shopxx.entity.Sn;
import net.shopxx.service.OrderService;
import net.shopxx.service.StaticService;
import net.shopxx.util.SettingUtils;

import org.apache.commons.lang.StringUtils;
import org.apache.commons.lang.time.DateUtils;
import org.apache.log4j.Logger;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;
import org.springframework.util.Assert;

/**
 * Service - 订单
 * 
 * 
 * 
 */
@Service("orderServiceImpl")
public class OrderServiceImpl extends BaseServiceImpl<Order, Long> implements OrderService {

	@Resource(name = "orderDaoImpl")
	private OrderDao orderDao;
	@Resource(name = "orderItemDaoImpl")
	private OrderItemDao orderItemDao;
	@Resource(name = "orderLogDaoImpl")
	private OrderLogDao orderLogDao;
	@Resource(name = "cartDaoImpl")
	private CartDao cartDao;
	@Resource(name = "couponCodeDaoImpl")
	private CouponCodeDao couponCodeDao;
	@Resource(name = "snDaoImpl")
	private SnDao snDao;
	@Resource(name = "memberDaoImpl")
	private MemberDao memberDao;
	@Resource(name = "memberRankDaoImpl")
	private MemberRankDao memberRankDao;
	@Resource(name = "productDaoImpl")
	private ProductDao productDao;
	@Resource(name = "depositDaoImpl")
	private DepositDao depositDao;
	@Resource(name = "paymentDaoImpl")
	private PaymentDao paymentDao;
	@Resource(name = "refundsDaoImpl")
	private RefundsDao refundsDao;
	@Resource(name = "shippingDaoImpl")
	private ShippingDao shippingDao;
	@Resource(name = "returnsDaoImpl")
	private ReturnsDao returnsDao;
	@Resource(name = "staticServiceImpl")
	private StaticService staticService;
	@Resource(name = "combineHisDaoImpl")
	private CombineHisDao combineHisDao;
	@Resource(name = "receiverDaoImpl")
	private ReceiverDao receiverDao;
	@Resource(name = "orderSplitItemDaoImpl")
	private OrderSplitItemDao orderSplitItemDao;

    private Logger log = Logger.getLogger(OrderServiceImpl.class);
    
	@Resource(name = "orderDaoImpl")
	public void setBaseDao(OrderDao orderDao) {
		super.setBaseDao(orderDao);
	}

	@Transactional(readOnly = true)
	public Order findBySn(String sn) {
		return orderDao.findBySn(sn);
	}

	@Transactional(readOnly = true)
	public List<Order> findList(Member member, Integer count, List<Filter> filters, List<net.shopxx.Order> orders) {
		return orderDao.findList(member, count, filters, orders);
	}

	@Transactional(readOnly = true)
	public Page<Order> findPage(Member member, Pageable pageable) {
		return orderDao.findPage(member, pageable);
	}

	@Transactional(readOnly = true)
	public Page<Order> findPage(OrderStatus orderStatus, PaymentStatus paymentStatus, ShippingStatus shippingStatus, Boolean hasExpired, Pageable pageable) {
		return orderDao.findPage(orderStatus, paymentStatus, shippingStatus, hasExpired, pageable);
	}
	
	@Transactional(readOnly = true)
	public Page<Order> findPage(OrderStatus orderStatus, PaymentStatus paymentStatus, ShippingStatus shippingStatus, Boolean hasExpired, Pageable pageable, Set<Member> members) {
		return orderDao.findPage(orderStatus, paymentStatus, shippingStatus, hasExpired, pageable, members);
	}

	@Transactional(readOnly = true)
	public Long count(OrderStatus orderStatus, PaymentStatus paymentStatus, ShippingStatus shippingStatus, Boolean hasExpired) {
		return orderDao.count(orderStatus, paymentStatus, shippingStatus, hasExpired);
	}

	@Transactional(readOnly = true)
	public Long waitingPaymentCount(Member member) {
		return orderDao.waitingPaymentCount(member);
	}

	@Transactional(readOnly = true)
	public Long waitingShippingCount(Member member) {
		return orderDao.waitingShippingCount(member);
	}

	@Transactional(readOnly = true)
	public BigDecimal getSalesAmount(Date beginDate, Date endDate) {
		return orderDao.getSalesAmount(beginDate, endDate);
	}

	@Transactional(readOnly = true)
	public Integer getSalesVolume(Date beginDate, Date endDate) {
		return orderDao.getSalesVolume(beginDate, endDate);
	}

	public void releaseStock() {
		orderDao.releaseStock();
	}

	@Transactional(readOnly = true)
	public Order build(Cart cart, Receiver receiver, PaymentMethod paymentMethod, ShippingMethod shippingMethod, CouponCode couponCode, boolean isInvoice, String invoiceTitle, boolean useBalance, String memo) {
		Assert.notNull(cart);
		Assert.notNull(cart.getMember());
		Assert.notEmpty(cart.getCartItems());

		Order order = new Order();
		order.setShippingStatus(ShippingStatus.unshipped);
		order.setFee(new BigDecimal(0));
		order.setPromotionDiscount(cart.getDiscount());
		order.setCouponDiscount(new BigDecimal(0));
		order.setOffsetAmount(new BigDecimal(0));
		order.setPoint(cart.getEffectivePoint());
		order.setMemo(memo);
		order.setMember(cart.getMember());
		order.setTotalWeight(cart.getTotalWeight());
		order.setTotalVolume(cart.getTotalVolume());
		order.setCombine(cart.isCombine());

		if (receiver != null) {
			order.setConsignee(receiver.getConsignee());
			order.setAreaName(receiver.getAreaName());
			order.setAddress(receiver.getAddress());
			order.setZipCode(receiver.getZipCode());
			order.setPhone(receiver.getPhone());
			order.setArea(receiver.getArea());
		}

		if (!cart.getPromotions().isEmpty()) {
			StringBuffer promotionName = new StringBuffer();
			for (Promotion promotion : cart.getPromotions()) {
				if (promotion != null && promotion.getName() != null) {
					promotionName.append(" " + promotion.getName());
				}
			}
			if (promotionName.length() > 0) {
				promotionName.deleteCharAt(0);
			}
			order.setPromotion(promotionName.toString());
		}

		order.setPaymentMethod(paymentMethod);

		if (shippingMethod != null && paymentMethod != null && paymentMethod.getShippingMethods().contains(shippingMethod)) {
			ShippingMethodDetail shippingMethodDetail = new ShippingMethodDetail();
			if (shippingMethod.getDetails().size()>0) {
				for (ShippingMethodDetail item : shippingMethod.getDetails()) {
					if(receiver.getArea().getParent()!=null){
						if(receiver.getArea().getParent().getParent()!=null){
							if(item.getArea().getId()==receiver.getArea().getParent().getParent().getId()){
								shippingMethodDetail = item; break;
							}
						}else {
							if(item.getArea().getId()==receiver.getArea().getParent().getId()){
								shippingMethodDetail = item; break;
							}
						}
					}else {
						if(item.getArea().getId()==receiver.getArea().getId()){
							shippingMethodDetail = item; break;
						}
					}
				}
			}
			
			if (shippingMethodDetail!=null && shippingMethodDetail.getId()!=null) {
				
			}else {
				//没有匹配到
				order.setStatus(400);
				return order;
			}
			
			/**
			 * 保存每个收货地址对应的总运费、总重量、总体积
			 * key：对应收货地址id  value：数组对应三个值(总运费、总重量、总体积)
			 */
			Map<Long, BigDecimal[]> splitFreightData = new LinkedHashMap<Long, BigDecimal[]>();
			for (CartItem cartItem : cart.getCartItems()) {
				//这个很重要
				cartItem.setSplitItems(orderSplitItemDao.findListByCartItem(cartItem.getId()));
				if(cartItem.getSplitTotalQuantity()>0){ //拆分了
					//先统计拆分部分
					for (OrderSplitItem item : cartItem.getSplitItems()) {
						Receiver rece = item.getReceiver();
						if(splitFreightData.containsKey(rece.getId())){ //统计过则累加
							BigDecimal[] data = splitFreightData.get(rece.getId());
							data[1]=data[1].add(item.getWeight());
							data[2]=data[2].add(item.getVolume());
						}else { //没有统计过
							BigDecimal[] data = new BigDecimal[4];
							data[0]=new BigDecimal(0);
							data[1]=item.getWeight();
							data[2]=item.getVolume();
							data[3]=new BigDecimal(0);
							splitFreightData.put(rece.getId(), data);
						}
					}
					if(cartItem.getQuantity()>cartItem.getSplitTotalQuantity()){ 
						//部分未拆分的按照收货地址对应收费
						if (splitFreightData.containsKey(receiver.getId())) {
							BigDecimal[] data = splitFreightData.get(receiver.getId());
							data[1]=data[1].add(cartItem.getSurplusWeight());
							data[2]=data[2].add(cartItem.getSurplusVolume());
						}else {
							BigDecimal[] data = new BigDecimal[4];
							data[0]=new BigDecimal(0);
							data[1]=cartItem.getSurplusWeight();
							data[2]=cartItem.getSurplusVolume();
							data[3]=new BigDecimal(0);
							splitFreightData.put(receiver.getId(), data);
						}
					}
				}else { //没有拆分按照选择的订单收货地址对应配送方式的该城市计算该商品的运费
					if (splitFreightData.containsKey(receiver.getId())) {
						BigDecimal[] data = splitFreightData.get(receiver.getId());
						data[1]=data[1].add(cartItem.getWeight());
						data[2]=data[2].add(cartItem.getVolume());
					}else {
						BigDecimal[] data = new BigDecimal[4];
						data[0]=new BigDecimal(0);
						data[1]=cartItem.getWeight();
						data[2]=cartItem.getVolume();
						data[3]=new BigDecimal(0);
						splitFreightData.put(receiver.getId(), data);
					}
				}
			}
			BigDecimal freight = new BigDecimal(0);
			//循环去计算每个收货地址的运费（如果存在拆分则地址多个，没有拆分任然一个地址）
			for (Long receiverId : splitFreightData.keySet()) {
				BigDecimal[] data = splitFreightData.get(receiverId);
				Receiver splitReceiver = receiverDao.find(receiverId);
				ShippingMethodDetail splitShippingMethodDetail = new ShippingMethodDetail();
				for (ShippingMethodDetail item : shippingMethod.getDetails()) {
					if(splitReceiver.getArea().getParent()!=null){
						if(splitReceiver.getArea().getParent().getParent()!=null){
							if(item.getArea().getId()==splitReceiver.getArea().getParent().getParent().getId()){
								splitShippingMethodDetail = item; break;
							}
						}else {
							if(item.getArea().getId()==splitReceiver.getArea().getParent().getId()){
								splitShippingMethodDetail = item; break;
							}
						}
					}else {
						if(item.getArea().getId()==splitReceiver.getArea().getId()){
							splitShippingMethodDetail = item; break;
						}
					}
				}
				if (splitShippingMethodDetail!=null && splitShippingMethodDetail.getId()!=null) {
					
				}else {
					//没有匹配到
					order.setStatus(400);
					return order;
				}
				//开始计算
				BigDecimal freightItem = splitShippingMethodDetail.calculateFreight(data[1]);
				
				//判断德邦物流，计算体积费用
				if (shippingMethod.getDefaultDeliveryCorp().getCode().equals("debangwuliu")) {
					BigDecimal volumeFreight = splitShippingMethodDetail.calculateFreightByVolume(data[2]);
					data[3] = new BigDecimal(1); //1代表按照重量计算
					if (volumeFreight.compareTo(freightItem)==1) { //如果体积计算运费大于重量运费，则取体积计算
						freightItem = volumeFreight;
						data[3] = new BigDecimal(2); //2代表按照体积计算
					}
					order.getSplitFreightData().put(receiverId, data);
					BigDecimal totalVolume = data[2];
					//计算送货费
					if (totalVolume.doubleValue()<5) { //小于5立方米
						freightItem = freightItem.add(BigDecimal.valueOf(100));
					}else if (totalVolume.doubleValue()>=5 && totalVolume.doubleValue()<=15) { //在5立方米和15立方米之间
						freightItem = freightItem.add(BigDecimal.valueOf(200));
					}else if (totalVolume.doubleValue()>15) { //大于15立方米
						freightItem = freightItem.add(BigDecimal.valueOf(300));
					}
				}
				//每个收货地址对应的运费
				data[0] = freightItem;
				//累加总的运费
				freight = freight.add(freightItem);
			}//循环结束
			for (Promotion promotion : cart.getPromotions()) {
				if (promotion.getIsFreeShipping()) {
					freight = new BigDecimal(0);
					break;
				}
			}
			order.setFreight(freight);
			order.setShippingMethod(shippingMethod);
		} else {
			order.setFreight(new BigDecimal(0));
		}

		if (couponCode != null && cart.isCouponAllowed()) {
			couponCodeDao.lock(couponCode, LockModeType.PESSIMISTIC_WRITE);
			if (!couponCode.getIsUsed() && couponCode.getCoupon() != null && cart.isValid(couponCode.getCoupon())) {
				BigDecimal couponDiscount = cart.getEffectivePrice().subtract(couponCode.getCoupon().calculatePrice(cart.getQuantity(), cart.getEffectivePrice()));
				couponDiscount = couponDiscount.compareTo(new BigDecimal(0)) > 0 ? couponDiscount : new BigDecimal(0);
				order.setCouponDiscount(couponDiscount);
				order.setCouponCode(couponCode);
			}
		}

		List<OrderItem> orderItems = order.getOrderItems();
		for (CartItem cartItem : cart.getCartItems()) {
			if (cartItem != null && cartItem.getProduct() != null) {
				Product product = cartItem.getProduct();
				OrderItem orderItem = new OrderItem();
				//
				orderItem.setCartItem(cartItem);
				orderItem.setSn(product.getSn());
				orderItem.setName(product.getName());
				orderItem.setFullName(product.getFullName());
				orderItem.setPrice(cartItem.getPrice());
				orderItem.setOldPrice(cartItem.getEndPrice());
				orderItem.setWeight(product.getWeight());
				orderItem.setThumbnail(product.getThumbnail());
				orderItem.setIsGift(false);
				orderItem.setQuantity(cartItem.getQuantity());
				orderItem.setShippedQuantity(0);
				orderItem.setReturnQuantity(0);
				orderItem.setProduct(product);
				orderItem.setOrder(order);
				orderItem.setEndPrice(cartItem.getEndPrice());
				orderItems.add(orderItem);
			}
		}

		for (GiftItem giftItem : cart.getGiftItems()) {
			if (giftItem != null && giftItem.getGift() != null) {
				Product gift = giftItem.getGift();
				OrderItem orderItem = new OrderItem();
				orderItem.setSn(gift.getSn());
				orderItem.setName(gift.getName());
				orderItem.setFullName(gift.getFullName());
				orderItem.setPrice(new BigDecimal(0));
				orderItem.setWeight(gift.getWeight());
				orderItem.setThumbnail(gift.getThumbnail());
				orderItem.setIsGift(true);
				orderItem.setQuantity(giftItem.getQuantity());
				orderItem.setShippedQuantity(0);
				orderItem.setReturnQuantity(0);
				orderItem.setProduct(gift);
				orderItem.setOrder(order);
				orderItems.add(orderItem);
			}
		}

		Setting setting = SettingUtils.get();
		if (setting.getIsInvoiceEnabled() && isInvoice && StringUtils.isNotEmpty(invoiceTitle)) {
			order.setIsInvoice(true);
			order.setInvoiceTitle(invoiceTitle);
			order.setTax(order.calculateTax());
		} else {
			order.setIsInvoice(false);
			order.setTax(new BigDecimal(0));
		}

		if (useBalance) {
			Member member = cart.getMember();
			if (member.getBalance().compareTo(order.getAmount()) >= 0) {
				order.setAmountPaid(order.getAmount());
			} else {
				order.setAmountPaid(member.getBalance());
			}
		} else {
			order.setAmountPaid(new BigDecimal(0));
		}

		if (order.getAmountPayable().compareTo(new BigDecimal(0)) == 0) {
			order.setOrderStatus(OrderStatus.confirmed);
			order.setPaymentStatus(PaymentStatus.paid);
		} else if (order.getAmountPayable().compareTo(new BigDecimal(0)) > 0 && order.getAmountPaid().compareTo(new BigDecimal(0)) > 0) {
			order.setOrderStatus(OrderStatus.confirmed);
			order.setPaymentStatus(PaymentStatus.partialPayment);
		} else {
			order.setOrderStatus(OrderStatus.unconfirmed);
			order.setPaymentStatus(PaymentStatus.unpaid);
		}

		if (paymentMethod != null && paymentMethod.getTimeout() != null && order.getPaymentStatus() == PaymentStatus.unpaid) {
			order.setExpire(DateUtils.addMinutes(new Date(), paymentMethod.getTimeout()));
		}

		return order;
	}

	public Order create(Cart cart, Receiver receiver, PaymentMethod paymentMethod, ShippingMethod shippingMethod, CouponCode couponCode, boolean isInvoice, String invoiceTitle, boolean useBalance, String memo, Admin operator) {
		Assert.notNull(cart);
		Assert.notNull(cart.getMember());
		Assert.notEmpty(cart.getCartItems());
		Assert.notNull(receiver);
		Assert.notNull(paymentMethod);
		Assert.notNull(shippingMethod);

		Order order = build(cart, receiver, paymentMethod, shippingMethod, couponCode, isInvoice, invoiceTitle, useBalance, memo);

		order.setSn(snDao.generate(Sn.Type.order));
		if (paymentMethod.getMethod() == PaymentMethod.Method.online) {
			order.setLockExpire(DateUtils.addSeconds(new Date(), 20));
			order.setOperator(operator);
		}

		if (order.getCouponCode() != null) {
			couponCode.setIsUsed(true);
			couponCode.setUsedDate(new Date());
			couponCodeDao.merge(couponCode);
		}

		for (Promotion promotion : cart.getPromotions()) {
			for (Coupon coupon : promotion.getCoupons()) {
				order.getCoupons().add(coupon);
			}
		}

		Setting setting = SettingUtils.get();
		if (setting.getStockAllocationTime() == StockAllocationTime.order || (setting.getStockAllocationTime() == StockAllocationTime.payment && (order.getPaymentStatus() == PaymentStatus.partialPayment || order.getPaymentStatus() == PaymentStatus.paid))) {
			order.setIsAllocatedStock(true);
		} else {
			order.setIsAllocatedStock(false);
		}

		orderDao.persist(order);

		OrderLog orderLog = new OrderLog();
		orderLog.setType(Type.create);
		orderLog.setOperator(operator != null ? operator.getUsername() : null);
		orderLog.setOrder(order);
		orderLogDao.persist(orderLog);

		Member member = cart.getMember();
		if (order.getAmountPaid().compareTo(new BigDecimal(0)) > 0) {
			memberDao.lock(member, LockModeType.PESSIMISTIC_WRITE);
			member.setBalance(member.getBalance().subtract(order.getAmountPaid()));
			memberDao.merge(member);

			Deposit deposit = new Deposit();
			deposit.setType(operator != null ? Deposit.Type.adminPayment : Deposit.Type.memberPayment);
			deposit.setCredit(new BigDecimal(0));
			deposit.setDebit(order.getAmountPaid());
			deposit.setBalance(member.getBalance());
			deposit.setOperator(operator != null ? operator.getUsername() : null);
			deposit.setMember(member);
			deposit.setOrder(order);
			depositDao.persist(deposit);
		}

		if (setting.getStockAllocationTime() == StockAllocationTime.order || (setting.getStockAllocationTime() == StockAllocationTime.payment && (order.getPaymentStatus() == PaymentStatus.partialPayment || order.getPaymentStatus() == PaymentStatus.paid))) {
			for (OrderItem orderItem : order.getOrderItems()) {
				if (orderItem != null) {
					Product product = orderItem.getProduct();
					productDao.lock(product, LockModeType.PESSIMISTIC_WRITE);
					if (product != null && product.getStock() != null) {
						product.setAllocatedStock(product.getAllocatedStock() + (orderItem.getQuantity() - orderItem.getShippedQuantity()));
						productDao.merge(product);
						orderDao.flush();
						staticService.build(product);
					}
				}
			}
		}

		cartDao.remove(cart);
		return order;
	}

	public void update(Order order, Admin operator) {
		Assert.notNull(order);

		Order pOrder = orderDao.find(order.getId());

		if (pOrder.getIsAllocatedStock()) {
			for (OrderItem orderItem : pOrder.getOrderItems()) {
				if (orderItem != null) {
					Product product = orderItem.getProduct();
					productDao.lock(product, LockModeType.PESSIMISTIC_WRITE);
					if (product != null && product.getStock() != null) {
						product.setAllocatedStock(product.getAllocatedStock() - (orderItem.getQuantity() - orderItem.getShippedQuantity()));
						productDao.merge(product);
						orderDao.flush();
						staticService.build(product);
					}
				}
			}
			for (OrderItem orderItem : order.getOrderItems()) {
				if (orderItem != null) {
					Product product = orderItem.getProduct();
					productDao.lock(product, LockModeType.PESSIMISTIC_WRITE);
					if (product != null && product.getStock() != null) {
						product.setAllocatedStock(product.getAllocatedStock() + (orderItem.getQuantity() - orderItem.getShippedQuantity()));
						productDao.merge(product);
						productDao.flush();
						staticService.build(product);
					}
				}
			}
		}

		orderDao.merge(order);

		OrderLog orderLog = new OrderLog();
		orderLog.setType(Type.modify);
		orderLog.setOperator(operator != null ? operator.getUsername() : null);
		orderLog.setOrder(order);
		orderLogDao.persist(orderLog);
	}

	public void confirm(Order order, Admin operator) {
		Assert.notNull(order);

		order.setOrderStatus(OrderStatus.confirmed);
		orderDao.merge(order);

		OrderLog orderLog = new OrderLog();
		orderLog.setType(Type.confirm);
		orderLog.setOperator(operator != null ? operator.getUsername() : null);
		orderLog.setOrder(order);
		orderLogDao.persist(orderLog);
	}

	public void complete(Order order, Admin operator) {
		Assert.notNull(order);

		Member member = order.getMember();
		memberDao.lock(member, LockModeType.PESSIMISTIC_WRITE);

		if (order.getShippingStatus() == ShippingStatus.partialShipment || order.getShippingStatus() == ShippingStatus.shipped) {
			member.setPoint(member.getPoint() + order.getPoint());
			for (Coupon coupon : order.getCoupons()) {
				couponCodeDao.build(coupon, member);
			}
		}

		if (order.getShippingStatus() == ShippingStatus.unshipped || order.getShippingStatus() == ShippingStatus.returned) {
			CouponCode couponCode = order.getCouponCode();
			if (couponCode != null) {
				couponCode.setIsUsed(false);
				couponCode.setUsedDate(null);
				couponCodeDao.merge(couponCode);

				order.setCouponCode(null);
				orderDao.merge(order);
			}
		}

		member.setAmount(member.getAmount().add(order.getAmountPaid()));
		if (!member.getMemberRank().getIsSpecial()) {
			MemberRank memberRank = memberRankDao.findByAmount(member.getAmount());
			if (memberRank != null && memberRank.getAmount().compareTo(member.getMemberRank().getAmount()) > 0) {
				member.setMemberRank(memberRank);
			}
		}
		memberDao.merge(member);

		if (order.getIsAllocatedStock()) {
			for (OrderItem orderItem : order.getOrderItems()) {
				if (orderItem != null) {
					Product product = orderItem.getProduct();
					productDao.lock(product, LockModeType.PESSIMISTIC_WRITE);
					if (product != null && product.getStock() != null) {
						product.setAllocatedStock(product.getAllocatedStock() - (orderItem.getQuantity() - orderItem.getShippedQuantity()));
						productDao.merge(product);
						orderDao.flush();
						staticService.build(product);
					}
				}
			}
			order.setIsAllocatedStock(false);
		}

		for (OrderItem orderItem : order.getOrderItems()) {
			if (orderItem != null) {
				Product product = orderItem.getProduct();
				productDao.lock(product, LockModeType.PESSIMISTIC_WRITE);
				if (product != null) {
					Integer quantity = orderItem.getQuantity();
					Calendar nowCalendar = Calendar.getInstance();
					Calendar weekSalesCalendar = DateUtils.toCalendar(product.getWeekSalesDate());
					Calendar monthSalesCalendar = DateUtils.toCalendar(product.getMonthSalesDate());
					if (nowCalendar.get(Calendar.YEAR) != weekSalesCalendar.get(Calendar.YEAR) || nowCalendar.get(Calendar.WEEK_OF_YEAR) > weekSalesCalendar.get(Calendar.WEEK_OF_YEAR)) {
						product.setWeekSales((long) quantity);
					} else {
						product.setWeekSales(product.getWeekSales() + quantity);
					}
					if (nowCalendar.get(Calendar.YEAR) != monthSalesCalendar.get(Calendar.YEAR) || nowCalendar.get(Calendar.MONTH) > monthSalesCalendar.get(Calendar.MONTH)) {
						product.setMonthSales((long) quantity);
					} else {
						product.setMonthSales(product.getMonthSales() + quantity);
					}
					product.setSales(product.getSales() + quantity);
					product.setWeekSalesDate(new Date());
					product.setMonthSalesDate(new Date());
					productDao.merge(product);
					orderDao.flush();
					staticService.build(product);
				}
			}
		}

		order.setOrderStatus(OrderStatus.completed);
		order.setExpire(null);
		orderDao.merge(order);

		OrderLog orderLog = new OrderLog();
		orderLog.setType(Type.complete);
		orderLog.setOperator(operator != null ? operator.getUsername() : null);
		orderLog.setOrder(order);
		orderLogDao.persist(orderLog);
	}

	public void cancel(Order order, Admin operator) {
		Assert.notNull(order);

		CouponCode couponCode = order.getCouponCode();
		if (couponCode != null) {
			couponCode.setIsUsed(false);
			couponCode.setUsedDate(null);
			couponCodeDao.merge(couponCode);

			order.setCouponCode(null);
			orderDao.merge(order);
		}

		if (order.getIsAllocatedStock()) {
			for (OrderItem orderItem : order.getOrderItems()) {
				if (orderItem != null) {
					Product product = orderItem.getProduct();
					productDao.lock(product, LockModeType.PESSIMISTIC_WRITE);
					if (product != null && product.getStock() != null) {
						product.setAllocatedStock(product.getAllocatedStock() - (orderItem.getQuantity() - orderItem.getShippedQuantity()));
						productDao.merge(product);
						orderDao.flush();
						staticService.build(product);
					}
				}
			}
			order.setIsAllocatedStock(false);
		}

		order.setOrderStatus(OrderStatus.cancelled);
		order.setExpire(null);
		orderDao.merge(order);

		OrderLog orderLog = new OrderLog();
		orderLog.setType(Type.cancel);
		orderLog.setOperator(operator != null ? operator.getUsername() : null);
		orderLog.setOrder(order);
		orderLogDao.persist(orderLog);
	}

	public void payment(Order order, Payment payment, Admin operator) {
		Assert.notNull(order);
		Assert.notNull(payment);

		orderDao.lock(order, LockModeType.PESSIMISTIC_WRITE);

		payment.setOrder(order);
		paymentDao.merge(payment);
		if (payment.getMethod() == Payment.Method.deposit) {
			Member member = order.getMember();
			memberDao.lock(member, LockModeType.PESSIMISTIC_WRITE);
			member.setBalance(member.getBalance().subtract(payment.getAmount()));
			memberDao.merge(member);

			Deposit deposit = new Deposit();
			deposit.setType(operator != null ? Deposit.Type.adminPayment : Deposit.Type.memberPayment);
			deposit.setCredit(new BigDecimal(0));
			deposit.setDebit(payment.getAmount());
			deposit.setBalance(member.getBalance());
			deposit.setOperator(operator != null ? operator.getUsername() : null);
			deposit.setMember(member);
			deposit.setOrder(order);
			depositDao.persist(deposit);
		}

		Setting setting = SettingUtils.get();
		if (!order.getIsAllocatedStock() && setting.getStockAllocationTime() == StockAllocationTime.payment) {
			for (OrderItem orderItem : order.getOrderItems()) {
				if (orderItem != null) {
					Product product = orderItem.getProduct();
					productDao.lock(product, LockModeType.PESSIMISTIC_WRITE);
					if (product != null && product.getStock() != null) {
						product.setAllocatedStock(product.getAllocatedStock() + (orderItem.getQuantity() - orderItem.getShippedQuantity()));
						productDao.merge(product);
						orderDao.flush();
						staticService.build(product);
					}
				}
			}
			order.setIsAllocatedStock(true);
		}

		order.setAmountPaid(order.getAmountPaid().add(payment.getAmount()));
		order.setFee(payment.getFee());
		order.setExpire(null);
		if (order.getAmountPaid().compareTo(order.getAmount()) >= 0) {
			order.setOrderStatus(OrderStatus.confirmed);
			order.setPaymentStatus(PaymentStatus.paid);
		} else if (order.getAmountPaid().compareTo(new BigDecimal(0)) > 0) {
			order.setOrderStatus(OrderStatus.confirmed);
			order.setPaymentStatus(PaymentStatus.partialPayment);
		}
		orderDao.merge(order);

		OrderLog orderLog = new OrderLog();
		orderLog.setType(Type.payment);
		orderLog.setOperator(operator != null ? operator.getUsername() : null);
		orderLog.setOrder(order);
		orderLogDao.persist(orderLog);
	}

	public void refunds(Order order, Refunds refunds, Admin operator) {
		Assert.notNull(order);
		Assert.notNull(refunds);

		orderDao.lock(order, LockModeType.PESSIMISTIC_WRITE);

		refunds.setOrder(order);
		refundsDao.persist(refunds);
		if (refunds.getMethod() == Refunds.Method.deposit) {
			Member member = order.getMember();
			memberDao.lock(member, LockModeType.PESSIMISTIC_WRITE);
			member.setBalance(member.getBalance().add(refunds.getAmount()));
			memberDao.merge(member);

			Deposit deposit = new Deposit();
			deposit.setType(Deposit.Type.adminRefunds);
			deposit.setCredit(refunds.getAmount());
			deposit.setDebit(new BigDecimal(0));
			deposit.setBalance(member.getBalance());
			deposit.setOperator(operator != null ? operator.getUsername() : null);
			deposit.setMember(member);
			deposit.setOrder(order);
			depositDao.persist(deposit);
		}

		order.setAmountPaid(order.getAmountPaid().subtract(refunds.getAmount()));
		order.setExpire(null);
		if (order.getAmountPaid().compareTo(new BigDecimal(0)) == 0) {
			order.setPaymentStatus(PaymentStatus.refunded);
		} else if (order.getAmountPaid().compareTo(new BigDecimal(0)) > 0) {
			order.setPaymentStatus(PaymentStatus.partialRefunds);
		}
		orderDao.merge(order);

		OrderLog orderLog = new OrderLog();
		orderLog.setType(Type.refunds);
		orderLog.setOperator(operator != null ? operator.getUsername() : null);
		orderLog.setOrder(order);
		orderLogDao.persist(orderLog);
	}

	public void shipping(Order order, Shipping shipping, Admin operator) {
		Assert.notNull(order);
		Assert.notNull(shipping);
		Assert.notEmpty(shipping.getShippingItems());

		orderDao.lock(order, LockModeType.PESSIMISTIC_WRITE);

		Setting setting = SettingUtils.get();
		if (!order.getIsAllocatedStock() && setting.getStockAllocationTime() == StockAllocationTime.ship) {
			for (OrderItem orderItem : order.getOrderItems()) {
				if (orderItem != null) {
					Product product = orderItem.getProduct();
					productDao.lock(product, LockModeType.PESSIMISTIC_WRITE);
					if (product != null && product.getStock() != null) {
						product.setAllocatedStock(product.getAllocatedStock() + (orderItem.getQuantity() - orderItem.getShippedQuantity()));
						productDao.merge(product);
						orderDao.flush();
						staticService.build(product);
					}
				}
			}
			order.setIsAllocatedStock(true);
		}

		shipping.setOrder(order);
		shippingDao.persist(shipping);
		for (ShippingItem shippingItem : shipping.getShippingItems()) {
			OrderItem orderItem = order.getOrderItem(shippingItem.getSn());
			if (orderItem != null) {
				Product product = orderItem.getProduct();
				productDao.lock(product, LockModeType.PESSIMISTIC_WRITE);
				if (product != null) {
					if (product.getStock() != null) {
						product.setStock(product.getStock() - shippingItem.getQuantity());
						if (order.getIsAllocatedStock()) {
							product.setAllocatedStock(product.getAllocatedStock() - shippingItem.getQuantity());
						}
					}
					productDao.merge(product);
					orderDao.flush();
					staticService.build(product);
				}
				orderItemDao.lock(orderItem, LockModeType.PESSIMISTIC_WRITE);
				orderItem.setShippedQuantity(orderItem.getShippedQuantity() + shippingItem.getQuantity());
			}
		}
		if (order.getShippedQuantity() >= order.getQuantity()) {
			order.setShippingStatus(ShippingStatus.shipped);
			order.setIsAllocatedStock(false);
		} else if (order.getShippedQuantity() > 0) {
			order.setShippingStatus(ShippingStatus.partialShipment);
		}
		order.setExpire(null);
		orderDao.merge(order);

		OrderLog orderLog = new OrderLog();
		orderLog.setType(Type.shipping);
		orderLog.setOperator(operator != null ? operator.getUsername() : null);
		orderLog.setOrder(order);
		orderLogDao.persist(orderLog);
	}

	public void returns(Order order, Returns returns, Admin operator) {
		Assert.notNull(order);
		Assert.notNull(returns);
		Assert.notEmpty(returns.getReturnsItems());

		orderDao.lock(order, LockModeType.PESSIMISTIC_WRITE);

		returns.setOrder(order);
		returnsDao.persist(returns);
		for (ReturnsItem returnsItem : returns.getReturnsItems()) {
			OrderItem orderItem = order.getOrderItem(returnsItem.getSn());
			if (orderItem != null) {
				orderItemDao.lock(orderItem, LockModeType.PESSIMISTIC_WRITE);
				orderItem.setReturnQuantity(orderItem.getReturnQuantity() + returnsItem.getQuantity());
			}
		}
		if (order.getReturnQuantity() >= order.getShippedQuantity()) {
			order.setShippingStatus(ShippingStatus.returned);
		} else if (order.getReturnQuantity() > 0) {
			order.setShippingStatus(ShippingStatus.partialReturns);
		}
		order.setExpire(null);
		orderDao.merge(order);

		OrderLog orderLog = new OrderLog();
		orderLog.setType(Type.returns);
		orderLog.setOperator(operator != null ? operator.getUsername() : null);
		orderLog.setOrder(order);
		orderLogDao.persist(orderLog);
	}

	@Override
	public void delete(Order order) {
		if (order.getIsAllocatedStock()) {
			for (OrderItem orderItem : order.getOrderItems()) {
				if (orderItem != null) {
					Product product = orderItem.getProduct();
					productDao.lock(product, LockModeType.PESSIMISTIC_WRITE);
					if (product != null && product.getStock() != null) {
						product.setAllocatedStock(product.getAllocatedStock() - (orderItem.getQuantity() - orderItem.getShippedQuantity()));
						productDao.merge(product);
						orderDao.flush();
						staticService.build(product);
					}
				}
			}
		}
		super.delete(order);
	}

	@Override
    public List<CombineHis> findCombinePage() {
	    return orderDao.findCombinePage();
	}
	
    /**
     * 定时合并订单
     */
    @Override
    public void combineOrder() {
        // 取定时任务
        Job jobPara = new Job();
        jobPara.setModule("combine_order");
        List<Job> jobs = orderDao.findJob(jobPara);
        Calendar cal = Calendar.getInstance();
        int day = cal.get(Calendar.DAY_OF_MONTH);
        int combineStartday = 0;
        int combineEndDay = 0;
        for (Job job : jobs) {
            if (job.getTriggeringDate() != day) {
                combineStartday = job.getTriggeringDate();
            } else {
                if (combineStartday == 0) {
                    combineStartday = jobs.get(jobs.size() - 1).getTriggeringDate();
                    combineEndDay = day;
                } else {
                    combineEndDay = day;
                }
                break;
            }
        }
        if (combineEndDay == 0) return;
        combineOrder(combineStartday, combineEndDay, null, null);
    }
    
    @Override
    public int combineOrder(Integer combineStartday, Integer combineEndDay, String startDate, String endDate) {

        Calendar cal = Calendar.getInstance();
        /*int hour = cal.get(Calendar.HOUR_OF_DAY);
        int minute = cal.get(Calendar.MINUTE);
        int second = cal.get(Calendar.SECOND);*/
        
        
        //SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd");
        cal.set(Calendar.DAY_OF_MONTH, combineEndDay);
        //String endDate = sdf.format(cal.getTime()) + " "+hour+":"+minute+":"+second+"";
        
        if (combineStartday > combineEndDay) {
            cal.add(Calendar.MONTH, -1);
        }
        cal.set(Calendar.DAY_OF_MONTH, combineStartday);
        //String startDate = sdf.format(cal.getTime()) + " 00:00:00";
        
        /**合并订单开始*/
        log.info("合并订单开始,时间范围:" + startDate + ">>" + endDate);
        int combineHisId = orderDao.combineOrder(startDate, endDate);
        //log.info("合并订单结束,更新条数：" + combineHisId);
        
        
        return combineHisId;
    }
    
  //获取合并订单后的价格
  	public List<Object> getOrderPrice(String startDate, String endDate){
  		return orderDao.getOrderPrice(startDate, endDate);
  	}

	@Override
	public List<Order> getCombineOrderList(String startDate, String endDate)
	{
		return orderDao.getCombineOrderList(startDate, endDate);
	}

	@Override
	public CombineHis getCombineHisByModifyDate(String modifyDate) {
		return combineHisDao.findByModifyDate(modifyDate);
	}

	@Override
	public CombineHis getLastCombine()
	{
		return combineHisDao.getLastCombine();
	}
	
	@Override
	//通过combineHisId查下订单集合
	public List<Order> getCombineOrderList(Integer combineHisId){
		return orderDao.getCombineOrderList(combineHisId);
	}
}