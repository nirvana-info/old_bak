/*
 * 
 * 
 * 
 */
package net.shopxx.controller.shop.member;

import java.math.BigDecimal;
import java.util.ArrayList;
import java.util.Date;
import java.util.HashMap;
import java.util.HashSet;
import java.util.List;
import java.util.Map;
import java.util.Set;

import javax.annotation.Resource;

import net.shopxx.Message;
import net.shopxx.Pageable;
import net.shopxx.Setting;
import net.shopxx.controller.shop.BaseController;
import net.shopxx.entity.Cart;
import net.shopxx.entity.CartItem;
import net.shopxx.entity.CombineHis;
import net.shopxx.entity.Coupon;
import net.shopxx.entity.CouponCode;
import net.shopxx.entity.Member;
import net.shopxx.entity.Order;
import net.shopxx.entity.Order.OrderStatus;
import net.shopxx.entity.Order.PaymentStatus;
import net.shopxx.entity.OrderItem;
import net.shopxx.entity.OrderSplitItem;
import net.shopxx.entity.PaymentMethod;
import net.shopxx.entity.Receiver;
import net.shopxx.entity.Shipping;
import net.shopxx.entity.ShippingMethod;
import net.shopxx.plugin.PaymentPlugin;
import net.shopxx.service.AreaService;
import net.shopxx.service.CartService;
import net.shopxx.service.CouponCodeService;
import net.shopxx.service.MailService;
import net.shopxx.service.MemberService;
import net.shopxx.service.OrderItemService;
import net.shopxx.service.OrderService;
import net.shopxx.service.OrderSplitItemService;
import net.shopxx.service.PaymentMethodService;
import net.shopxx.service.PluginService;
import net.shopxx.service.ReceiverService;
import net.shopxx.service.ShippingMethodService;
import net.shopxx.service.ShippingService;
import net.shopxx.util.SettingUtils;

import org.apache.commons.lang.StringUtils;
import org.apache.commons.lang.time.DateUtils;
import org.springframework.stereotype.Controller;
import org.springframework.ui.ModelMap;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.ResponseBody;

/**
 * Controller - 会员中心 - 订单
 * 
 * 
 * 
 */
@Controller("shopMemberOrderController")
@RequestMapping("/member/order")
public class OrderController extends BaseController {

	/** 每页记录数 */
	private static final int PAGE_SIZE = 10;

	@Resource(name = "memberServiceImpl")
	private MemberService memberService;
	@Resource(name = "areaServiceImpl")
	private AreaService areaService;
	@Resource(name = "receiverServiceImpl")
	private ReceiverService receiverService;
	@Resource(name = "cartServiceImpl")
	private CartService cartService;
	@Resource(name = "paymentMethodServiceImpl")
	private PaymentMethodService paymentMethodService;
	@Resource(name = "shippingMethodServiceImpl")
	private ShippingMethodService shippingMethodService;
	@Resource(name = "couponCodeServiceImpl")
	private CouponCodeService couponCodeService;
	@Resource(name = "orderServiceImpl")
	private OrderService orderService;
	@Resource(name = "shippingServiceImpl")
	private ShippingService shippingService;
	@Resource(name = "pluginServiceImpl")
	private PluginService pluginService;
    @Resource(name = "mailServiceImpl")
    private MailService mailService;
    @Resource(name = "orderSplitItemServiceImpl")
    private OrderSplitItemService orderSplitItemService;
    @Resource(name = "orderItemServiceImpl")
	private OrderItemService orderItemService;

	/**
	 * 保存收货地址
	 */
	@RequestMapping(value = "/save_receiver", method = RequestMethod.POST)
	public @ResponseBody
	Map<String, Object> saveReceiver(Receiver receiver, Long areaId) {
		Map<String, Object> data = new HashMap<String, Object>();
		receiver.setArea(areaService.find(areaId));
		if (!isValid(receiver)) {
			data.put("message", ERROR_MESSAGE);
			return data;
		}
		Member member = memberService.getCurrent();
		if (Receiver.MAX_RECEIVER_COUNT != null && member.getReceivers().size() >= Receiver.MAX_RECEIVER_COUNT) {
			data.put("message", Message.error("shop.order.addReceiverCountNotAllowed", Receiver.MAX_RECEIVER_COUNT));
			return data;
		}
		receiver.setMember(member);
		receiverService.save(receiver);
		data.put("message", SUCCESS_MESSAGE);
		data.put("receiver", receiver);
		return data;
	}

	/**
	 * 订单锁定
	 */
	@RequestMapping(value = "/lock", method = RequestMethod.POST)
	public @ResponseBody
	boolean lock(String sn) {
		Order order = orderService.findBySn(sn);
		if (order != null && memberService.getCurrent().equals(order.getMember()) && !order.isExpired() && !order.isLocked(null) && order.getPaymentMethod() != null && order.getPaymentMethod().getMethod() == PaymentMethod.Method.online && (order.getPaymentStatus() == PaymentStatus.unpaid || order.getPaymentStatus() == PaymentStatus.partialPayment)) {
			order.setLockExpire(DateUtils.addSeconds(new Date(), 20));
			order.setOperator(null);
			orderService.update(order);
			return true;
		}
		return false;
	}

	/**
	 * 检查支付
	 */
	@RequestMapping(value = "/check_payment", method = RequestMethod.POST)
	public @ResponseBody
	boolean checkPayment(String sn) {
		Order order = orderService.findBySn(sn);
		if (order != null && memberService.getCurrent().equals(order.getMember()) && order.getPaymentStatus() == PaymentStatus.paid) {
			return true;
		}
		return false;
	}

	/**
	 * 优惠券信息
	 */
	@RequestMapping(value = "/coupon_info", method = RequestMethod.POST)
	public @ResponseBody
	Map<String, Object> couponInfo(String code) {
		Map<String, Object> data = new HashMap<String, Object>();
		Cart cart = cartService.getCurrent();
		if (cart == null || cart.isEmpty()) {
			data.put("message", Message.warn("shop.order.cartNotEmpty"));
			return data;
		}
		if (!cart.isCouponAllowed()) {
			data.put("message", Message.warn("shop.order.couponNotAllowed"));
			return data;
		}
		CouponCode couponCode = couponCodeService.findByCode(code);
		if (couponCode != null && couponCode.getCoupon() != null) {
			Coupon coupon = couponCode.getCoupon();
			if (!coupon.getIsEnabled()) {
				data.put("message", Message.warn("shop.order.couponDisabled"));
				return data;
			}
			if (!coupon.hasBegun()) {
				data.put("message", Message.warn("shop.order.couponNotBegin"));
				return data;
			}
			if (coupon.hasExpired()) {
				data.put("message", Message.warn("shop.order.couponHasExpired"));
				return data;
			}
			if (!cart.isValid(coupon)) {
				data.put("message", Message.warn("shop.order.couponInvalid"));
				return data;
			}
			if (couponCode.getIsUsed()) {
				data.put("message", Message.warn("shop.order.couponCodeUsed"));
				return data;
			}
			data.put("message", SUCCESS_MESSAGE);
			data.put("couponName", coupon.getName());
			return data;
		} else {
			data.put("message", Message.warn("shop.order.couponCodeNotExist"));
			return data;
		}
	}

	/**
	 * 信息
	 */
	@RequestMapping(value = "/info", method = RequestMethod.GET)
	public String info(ModelMap model) {
		Cart cart = cartService.getCurrent();
		if (cart == null || cart.isEmpty()) {
			return "redirect:/cart/list.jhtml";
		}
		if (!isValid(cart)) {
			return ERROR_VIEW;
		}
		Order order = orderService.build(cart, null, null, null, null, false, null, false, null);
		List<ShippingMethod> shippingMethods = shippingMethodService.findAll();
		for (ShippingMethod shippingMethod : shippingMethods) {
			String productIds = orderSplitItemService.findExistsSplitProductIds(cart.getCartItems());
			shippingMethod.setProductIds(productIds);
		}
		for (OrderItem orderItem : order.getOrderItems()) {
			orderItem.setSplitItems(orderSplitItemService.findListByCartItem(orderItem.getCartItem().getId()));
		}
		model.addAttribute("order", order);
		model.addAttribute("cartToken", cart.getToken());
		model.addAttribute("paymentMethods", paymentMethodService.findAll());
		model.addAttribute("shippingMethods", shippingMethodService.findAll());
		return "/shop/member/order/info";
	}

	/**
	 * 计算
	 */
	@RequestMapping(value = "/calculate", method = RequestMethod.POST)
	public @ResponseBody
	Map<String, Object> calculate(
			Long receiverId, Long paymentMethodId, Long shippingMethodId, String code, @RequestParam(defaultValue = "false") Boolean isInvoice, String invoiceTitle, @RequestParam(defaultValue = "false") Boolean useBalance, String memo) {
		//获取当前用户的收货地址
		Receiver receiver = receiverService.find(receiverId);
		Map<String, Object> data = new HashMap<String, Object>();
		Cart cart = cartService.getCurrent();
		if (cart == null || cart.isEmpty()) {
			data.put("message", Message.error("shop.order.cartNotEmpty"));
			return data;
		}
		PaymentMethod paymentMethod = paymentMethodService.find(paymentMethodId);
		ShippingMethod shippingMethod = shippingMethodService.find(shippingMethodId);
		CouponCode couponCode = couponCodeService.findByCode(code);
		Order order = orderService.build(cart, receiver, paymentMethod, shippingMethod, couponCode, isInvoice, invoiceTitle, useBalance, memo);
		//如果没有匹配到配送方式下的城市配置
		if(order.getStatus()==400){
			data.put("message", Message.error("shop.order.shippingMethod.error"));
			return data;
		}
		if (order.getFreight().doubleValue()==0) {
			data.put("message", Message.error("shop.order.calculate.zero.alter"));
			return data;
		}
		String splitNum = "";
		for (CartItem cartItem : cart.getCartItems()) {
			cartItem.setSplitItems(orderSplitItemService.findListByCartItem(cartItem.getId()));
			int splitTotalQuantity = cartItem.getSplitTotalQuantity();
			//index依次是：拆分个数，已拆数量，未拆数量
			splitNum += ","+cartItem.getSplitItems().size()+"_"+splitTotalQuantity+"_"+(cartItem.getQuantity()-splitTotalQuantity);
		}
		if(splitNum.length()>0){
			splitNum = splitNum.substring(1);
		}
		data.put("splitNum", splitNum);
		data.put("message", SUCCESS_MESSAGE);
		data.put("quantity", order.getQuantity());
		data.put("price", order.getPrice());
		data.put("freight", order.getFreight());
		data.put("promotionDiscount", order.getPromotionDiscount());
		data.put("couponDiscount", order.getCouponDiscount());
		data.put("tax", order.getTax());
		data.put("amountPayable", order.getAmountPayable());
		return data;
	}
	
	@RequestMapping(value = "/orderSplitView", method = RequestMethod.GET)
	public String orderSplitView(String cartToken, long productId, ModelMap model) {
		Cart cart = cartService.getCurrent();
		CartItem cartItem = new CartItem();
		if (cart!=null && cart.getId()!=null) {
			for (CartItem item : cart.getCartItems()) {
				if (item.getProduct().getId()==productId) {
					cartItem = item; break;
				}
			}
		}
		String entityStr = memberService.getCurrent().getAttributeValue0();
		if(org.apache.commons.lang3.StringUtils.isNotBlank(entityStr)){
			entityStr = entityStr.replaceAll("\\[", "").replaceAll("\\]", "").replaceAll("\\\"", "");
			List<String> list = new ArrayList<String>();
			for (String str : entityStr.split(",")) {
				list.add(str);
			}
			model.addAttribute("entities", list);
			model.addAttribute("entityStr", entityStr);
		}else{
			model.addAttribute("entities", new ArrayList<String>());
		}
		String sbuStr = memberService.getCurrent().getAttributeValue1();
		if(org.apache.commons.lang3.StringUtils.isNotBlank(sbuStr)){
			sbuStr = sbuStr.replaceAll("\\[", "").replaceAll("\\]", "").replaceAll("\\\"", "");
			List<String> list = new ArrayList<String>();
			for (String str : sbuStr.split(",")) {
				list.add(str);
			}
			model.addAttribute("sbus", list);
			model.addAttribute("sbuStr", sbuStr);
		}else{
			model.addAttribute("sbus", new ArrayList<String>());
		}
		model.addAttribute("orderSplitItems", orderSplitItemService.findListByCartItem(cartItem.getId()));
		model.addAttribute("cartItem", cartItem);
		model.addAttribute("cartToken", cartToken);
		model.addAttribute("productId", productId);
		return "/shop/member/order/splitview";
	}
	
	@RequestMapping(value = "/orderSplit/save", method = RequestMethod.POST)
	public @ResponseBody
	Message saveOrderSplit(Order order) {
		for (OrderSplitItem splitItem : order.getSplitItems()) {
			if(splitItem.getReceiver()==null) continue;
			splitItem.setReceiver(receiverService.find(splitItem.getReceiver().getId()));
			splitItem.setAreaName(splitItem.getReceiver().getAreaName());
			splitItem.setAddress(splitItem.getReceiver().getAddress());
			if(splitItem.getId()==0) {
				splitItem.setId(null);
				orderSplitItemService.save(splitItem);
			}else {
				orderSplitItemService.update(splitItem);	
			}
		}
		return SUCCESS_MESSAGE;
	}
	
	@RequestMapping(value = "/cancelSplit", method = RequestMethod.POST)
	public @ResponseBody Message cancelSplit(
		@RequestParam(value="splitId", required=false, defaultValue="0")long splitId,
		@RequestParam(value="productId", required=false, defaultValue="0")long productId
			){
		//删除单条拆分
		if(splitId>0){
			orderSplitItemService.delete(splitId);
		}else{
			//删除订单cartItem对应的所有拆分
			Cart cart = cartService.getCurrent();
			Set<CartItem> cartItems = cart.getCartItems();
			if(productId>0){
				Set<CartItem> newList = new HashSet<CartItem>();
				for (CartItem cartItem : cartItems) {
					if(cartItem.getProduct().getId()==productId){
						newList.add(cartItem);
						cartItems = newList;
						break;
					}
				}
			}
			orderSplitItemService.deleteSplitListByCartItem(cartItems);
		}
		return SUCCESS_MESSAGE;
	}

	/**
	 * 创建
	 */
	@RequestMapping(value = "/create", method = RequestMethod.POST)
	public @ResponseBody
	Message create(String cartToken, Long receiverId, Boolean isCombine, Long paymentMethodId, Long shippingMethodId, String code, @RequestParam(defaultValue = "false") Boolean isInvoice, String invoiceTitle, @RequestParam(defaultValue = "false") Boolean useBalance, String memo) {
		Cart cart = cartService.getCurrent();
		cart.setCombine(isCombine);
		if (cart == null || cart.isEmpty()) {
			return Message.warn("shop.order.cartNotEmpty");
		}
		if (!StringUtils.equals(cart.getToken(), cartToken)) {
			return Message.warn("shop.order.cartHasChanged");
		}
		if (cart.getIsLowStock()) {
			return Message.warn("shop.order.cartLowStock");
		}
		Receiver receiver = receiverService.find(receiverId);
		if (receiver == null) {
			return Message.error("shop.order.receiverNotExsit");
		}
		PaymentMethod paymentMethod = paymentMethodService.find(paymentMethodId);
		if (paymentMethod == null) {
			return Message.error("shop.order.paymentMethodNotExsit");
		}
		ShippingMethod shippingMethod = shippingMethodService.find(shippingMethodId);
		if (shippingMethod == null) {
			return Message.error("shop.order.shippingMethodNotExsit");
		}
		if (!paymentMethod.getShippingMethods().contains(shippingMethod)) {
			return Message.error("shop.order.deliveryUnsupported");
		}
		CouponCode couponCode = couponCodeService.findByCode(code);
		Order order = orderService.create(cart, receiver, paymentMethod, shippingMethod, couponCode, isInvoice, invoiceTitle, useBalance, memo, null);
		//更新拆分数据对应的orderId, orderItemId
		List<OrderSplitItem> splitItems = orderSplitItemService.findListByCartItem(cart.getCartItems());
		for (OrderSplitItem orderSplitItem : splitItems) {
			orderSplitItem.setOrder(order);
			for (OrderItem orderItem : order.getOrderItems()) {
				if(orderItem.getProduct().getId()==orderSplitItem.getProduct().getId()){
					orderSplitItem.setOrderItem(orderItem); break;
				}
			}
			for (Long receId : order.getSplitFreightData().keySet()) {
				if(receId == orderSplitItem.getReceiver().getId()){
					BigDecimal[] data = order.getSplitFreightData().get(receId);
					orderSplitItem.setCalculationMethod(data[3].intValue());
				}
			}
			orderSplitItemService.update(orderSplitItem);
		}
		mailService.sendPurchaseOrderMail(order);
		return Message.success(order.getSn());
	}

	/**
	 * 支付
	 */
	@RequestMapping(value = "/payment", method = RequestMethod.GET)
	public String payment(String sn, ModelMap model) {
		Order order = orderService.findBySn(sn);
		if (order == null || !memberService.getCurrent().equals(order.getMember()) || order.isExpired() || order.getPaymentMethod() == null) {
			return ERROR_VIEW;
		}
		if (order.getPaymentMethod().getMethod() == PaymentMethod.Method.online) {
			List<PaymentPlugin> paymentPlugins = pluginService.getPaymentPlugins(true);
			if (!paymentPlugins.isEmpty()) {
				PaymentPlugin defaultPaymentPlugin = paymentPlugins.get(0);
				if (order.getPaymentStatus() == PaymentStatus.unpaid || order.getPaymentStatus() == PaymentStatus.partialPayment) {
					model.addAttribute("fee", defaultPaymentPlugin.calculateFee(order.getAmountPayable()));
					model.addAttribute("amount", defaultPaymentPlugin.calculateAmount(order.getAmountPayable()));
				}
				model.addAttribute("defaultPaymentPlugin", defaultPaymentPlugin);
				model.addAttribute("paymentPlugins", paymentPlugins);
			}
		}
		model.addAttribute("order", order);
		return "/shop/member/order/payment";
	}

	/**
	 * 计算支付金额
	 */
	@RequestMapping(value = "/calculate_amount", method = RequestMethod.POST)
	public @ResponseBody
	Map<String, Object> calculateAmount(String paymentPluginId, String sn) {
		Map<String, Object> data = new HashMap<String, Object>();
		Order order = orderService.findBySn(sn);
		PaymentPlugin paymentPlugin = pluginService.getPaymentPlugin(paymentPluginId);
		if (order == null || !memberService.getCurrent().equals(order.getMember()) || order.isExpired() || order.isLocked(null) || order.getPaymentMethod() == null || order.getPaymentMethod().getMethod() == PaymentMethod.Method.offline || paymentPlugin == null || !paymentPlugin.getIsEnabled()) {
			data.put("message", ERROR_MESSAGE);
			return data;
		}
		data.put("message", SUCCESS_MESSAGE);
		data.put("fee", paymentPlugin.calculateFee(order.getAmountPayable()));
		data.put("amount", paymentPlugin.calculateAmount(order.getAmountPayable()));
		return data;
	}

	/**
	 * 列表
	 */
	@RequestMapping(value = "/list", method = RequestMethod.GET)
	public String list(Integer pageNumber, ModelMap model) {
		Member member = memberService.getCurrent();
		Pageable pageable = new Pageable(pageNumber, PAGE_SIZE);
		model.addAttribute("page", orderService.findPage(member, pageable));
		return "shop/member/order/list";
	}

	/**
	 * 查看
	 */
	@RequestMapping(value = "/view", method = RequestMethod.GET)
	public String view(String sn, ModelMap model) {
		Order order = orderService.findBySn(sn);
		if (order == null) {
			return ERROR_VIEW;
		}
		Member member = memberService.getCurrent();
		if (!member.getOrders().contains(order)) {
			return ERROR_VIEW;
		}
		model.addAttribute("order", order);
		return "shop/member/order/view";
	}

	/**
	 * 取消
	 */
	@RequestMapping(value = "/cancel", method = RequestMethod.POST)
	public @ResponseBody
	Message cancel(String sn) {
		Order order = orderService.findBySn(sn);
		if (order != null && memberService.getCurrent().equals(order.getMember()) && !order.isExpired() && order.getOrderStatus() == OrderStatus.unconfirmed && order.getPaymentStatus() == PaymentStatus.unpaid) {
			if (order.isLocked(null)) {
				return Message.warn("shop.member.order.locked");
			}
			orderService.cancel(order, null);
			return SUCCESS_MESSAGE;
		}
		return ERROR_MESSAGE;
	}

	/**
	 * 物流动态
	 */
	@RequestMapping(value = "/delivery_query", method = RequestMethod.GET)
	public @ResponseBody
	Map<String, Object> deliveryQuery(String sn) {
		Map<String, Object> data = new HashMap<String, Object>();
		Shipping shipping = shippingService.findBySn(sn);
		Setting setting = SettingUtils.get();
		if (shipping != null && shipping.getOrder() != null && memberService.getCurrent().equals(shipping.getOrder().getMember()) && StringUtils.isNotEmpty(setting.getKuaidi100Key()) && StringUtils.isNotEmpty(shipping.getDeliveryCorpCode()) && StringUtils.isNotEmpty(shipping.getTrackingNo())) {
			data = shippingService.query(shipping);
		}
		return data;
	}
	
	/**
     * 查询某订单对应的combine下的所有订单列表
     */
	@RequestMapping(value = "/combineOrderList")
	public String combineOrderList(String sn, String modifyDate, Integer combineHisId, ModelMap model) {
		//获取此订单对应的combineHis实体
		/*CombineHis combineHis = orderService.getCombineHisByModifyDate(modifyDate);
		if(combineHis==null) combineHis = new CombineHis();*/
		//获取combineHis中的订单Lists
    	List<Order> list = orderService.getCombineOrderList(combineHisId);
    	if (list != null && list.size() > 0) {
    		BigDecimal oldPrice=new BigDecimal(0);
    		BigDecimal nowPrice=new BigDecimal(0);
    		BigDecimal costSave=new BigDecimal(0);
    		for (int i = 0; i < list.size(); i++)
			{
    			Order order=list.get(i);
    			if(null!=order.getOldAmount()){
    				oldPrice=oldPrice.add(order.getOldAmount());
    			}
    			if(null!=order.getAmount()){
    				nowPrice=nowPrice.add(order.getAmount());
    			}
			}
    		costSave=oldPrice.subtract(nowPrice);
    		model.put("oldPrice", oldPrice);
    		model.put("nowPrice", nowPrice);
    		model.put("costSave", costSave);
    	}
        model.put("combineOrderList", list);
        model.addAttribute("order", orderService.findBySn(sn));
        return "shop/member/order/combineOrderList";
	}
	
	/**
     * 查询combine order item list
     * @param orderId 
     */
    @RequestMapping(value = "/combineOrderItemList")
	public String combineOrderItemList(String sn, Long orderId, ModelMap model) {
    	List<OrderItem> list = orderItemService.getCombineOrderItemList(orderId);
    	if (list != null && list.size() > 0) {
    		BigDecimal oldPrice=new BigDecimal(0);
    		BigDecimal nowPrice=new BigDecimal(0);
    		BigDecimal costSave=new BigDecimal(0);
    		for (int i = 0; i < list.size(); i++)
			{
    			OrderItem orderItem=list.get(i);
    			if(null!=orderItem.getOldPrice()){
    				oldPrice=oldPrice.add(orderItem.getOldPrice().multiply(new BigDecimal(orderItem.getQuantity())));
    			}
    			if(null!=orderItem.getEndPrice()){
    				nowPrice=nowPrice.add(orderItem.getEndPrice().multiply(new BigDecimal(orderItem.getQuantity())));
    			}
			}
    		costSave=oldPrice.subtract(nowPrice);
    		model.put("oldPrice", oldPrice);
    		model.put("nowPrice", nowPrice);
    		model.put("costSave", costSave);
    	}
    	model.addAttribute("order", orderService.findBySn(sn));
        model.put("combineOrderItemList", list);
	    return "/shop/member/order/combineOrderItemList";
	}

	/**
	 * 查看
	 */
	@RequestMapping(value = "/splitInfo", method = RequestMethod.GET)
	public String splitInfo(long orderId, long orderItemId, ModelMap model) {
		Order order = orderService.find(orderId);
		if (order == null) {
			return ERROR_VIEW;
		}
		OrderItem orderItem = new OrderItem();
		for (OrderItem item : order.getOrderItems()) {
			if (item.getId() == orderItemId) {
				orderItem = item; break;
			}
		}
		if (orderItem == null || orderItem.getId()==null) {
			return ERROR_VIEW;
		}
		model.addAttribute("orderItem", orderItem);
		return "shop/member/order/splitInfo";
	}

}