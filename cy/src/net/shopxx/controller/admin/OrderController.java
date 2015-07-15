/*
 * 
 * 
 * 
 */
package net.shopxx.controller.admin;

import java.io.IOException;
import java.math.BigDecimal;
import java.util.ArrayList;
import java.util.Date;
import java.util.HashMap;
import java.util.Iterator;
import java.util.List;
import java.util.Map;
import java.util.Set;

import javax.annotation.Resource;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import net.shopxx.Message;
import net.shopxx.Pageable;
import net.shopxx.entity.Admin;
import net.shopxx.entity.Area;
import net.shopxx.entity.CombineHis;
import net.shopxx.entity.DeliveryCorp;
import net.shopxx.entity.Member;
import net.shopxx.entity.Order;
import net.shopxx.entity.Order.OrderStatus;
import net.shopxx.entity.Order.PaymentStatus;
import net.shopxx.entity.Order.ShippingStatus;
import net.shopxx.entity.OrderItem;
import net.shopxx.entity.OrderSplitItem;
import net.shopxx.entity.Payment;
import net.shopxx.entity.Payment.Status;
import net.shopxx.entity.Payment.Type;
import net.shopxx.entity.PaymentMethod;
import net.shopxx.entity.Product;
import net.shopxx.entity.Refunds;
import net.shopxx.entity.Returns;
import net.shopxx.entity.ReturnsItem;
import net.shopxx.entity.Role;
import net.shopxx.entity.Shipping;
import net.shopxx.entity.ShippingItem;
import net.shopxx.entity.ShippingMethod;
import net.shopxx.entity.Sn;
import net.shopxx.service.AdminService;
import net.shopxx.service.AreaService;
import net.shopxx.service.DeliveryCorpService;
import net.shopxx.service.MailService;
import net.shopxx.service.OrderItemService;
import net.shopxx.service.OrderService;
import net.shopxx.service.PaymentMethodService;
import net.shopxx.service.ProductService;
import net.shopxx.service.ShippingMethodService;
import net.shopxx.service.SnService;
import net.shopxx.util.excel.ExportExcel;

import org.apache.commons.lang.StringUtils;
import org.apache.commons.lang.time.DateUtils;
import org.springframework.beans.BeanUtils;
import org.springframework.stereotype.Controller;
import org.springframework.ui.ModelMap;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.ResponseBody;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

/**
 * Controller - 订单
 * 
 * 
 * 
 */
@Controller("adminOrderController")
@RequestMapping("/admin/order")
public class OrderController extends BaseController {

	@Resource(name = "adminServiceImpl")
	private AdminService adminService;
	@Resource(name = "areaServiceImpl")
	private AreaService areaService;
	@Resource(name = "productServiceImpl")
	private ProductService productService;
	@Resource(name = "orderServiceImpl")
	private OrderService orderService;
	@Resource(name = "orderItemServiceImpl")
	private OrderItemService orderItemService;
	@Resource(name = "shippingMethodServiceImpl")
	private ShippingMethodService shippingMethodService;
	@Resource(name = "deliveryCorpServiceImpl")
	private DeliveryCorpService deliveryCorpService;
	@Resource(name = "paymentMethodServiceImpl")
	private PaymentMethodService paymentMethodService;
	@Resource(name = "snServiceImpl")
	private SnService snService;
    @Resource(name = "mailServiceImpl")
	private MailService mailService;

	/**
	 * 检查锁定
	 */
	@RequestMapping(value = "/check_lock", method = RequestMethod.POST)
	public @ResponseBody
	Message checkLock(Long id) {
		Order order = orderService.find(id);
		if (order == null) {
			return Message.warn("admin.common.invalid");
		}
		Admin admin = adminService.getCurrent();
		if (order.isLocked(admin)) {
			if (order.getOperator() != null) {
				return Message.warn("admin.order.adminLocked", order.getOperator().getUsername());
			} else {
				return Message.warn("admin.order.memberLocked");
			}
		} else {
			order.setLockExpire(DateUtils.addSeconds(new Date(), 20));
			order.setOperator(admin);
			orderService.update(order);
			return SUCCESS_MESSAGE;
		}
	}

	/**
	 * 查看
	 */
	@RequestMapping(value = "/view", method = RequestMethod.GET)
	public String view(Long id, ModelMap model) {
		model.addAttribute("methods", Payment.Method.values());
		model.addAttribute("refundsMethods", Refunds.Method.values());
		model.addAttribute("paymentMethods", paymentMethodService.findAll());
		model.addAttribute("shippingMethods", shippingMethodService.findAll());
		model.addAttribute("deliveryCorps", deliveryCorpService.findAll());
		Order order=orderService.find(id);
		model.addAttribute("order", order);
		//combine log
		//判断订单是否已合并
		try
		{
			if(null!=order && order.getCombine()==true && null!=order.getCombineHisId()){
				List<OrderItem> list = orderItemService.getCombineOrderItemList(id);
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
		        model.put("combineOrderItemList", list);
		        model.put("isCombine", order.getCombine());
			}
		} catch (Exception e)
		{
			System.err.println("判处合并出错");
		}
		
		Admin admin = adminService.getCurrent();
		Set<Role> roles = admin.getRoles();
		//当前管理员所拥有的角色
		List<Long> roleIds = new ArrayList<Long>();
		for (Role role : roles) {
			roleIds.add(role.getId());
		}
		if (roleIds.contains(Long.valueOf(1)) || roleIds.contains(Long.valueOf(2))) { //超级管理员和订单管理员有权限审批订单
			model.addAttribute("hasAuthentyApprove", true);
		}else {
			model.addAttribute("hasAuthentyApprove", false);
		}
		return "/admin/order/view";
	}

	/**
	 * 确认
	 */
	@RequestMapping(value = "/confirm", method = RequestMethod.POST)
	public String confirm(Long id, RedirectAttributes redirectAttributes) {
		Order order = orderService.find(id);
		Admin admin = adminService.getCurrent();
		if (order != null && !order.isExpired() && order.getOrderStatus() == OrderStatus.unconfirmed && !order.isLocked(admin)) {
			orderService.confirm(order, admin);
			mailService.sendApproveMail(order);
			addFlashMessage(redirectAttributes, SUCCESS_MESSAGE);
		} else {
			addFlashMessage(redirectAttributes, Message.warn("admin.common.invalid"));
		}
		return "redirect:view.jhtml?id=" + id;
	}
	
	/**
	 * 订单列表上的确认
	 */
	@RequestMapping(value = "/listConfirm", method = RequestMethod.POST)
	public String listConfirm(Long id, RedirectAttributes redirectAttributes) {
		Order order = orderService.find(id);
		Admin admin = adminService.getCurrent();
		if (order != null && !order.isExpired() && order.getOrderStatus() == OrderStatus.unconfirmed && !order.isLocked(admin)) {
			orderService.confirm(order, admin);
            mailService.sendApproveMail(order);
			addFlashMessage(redirectAttributes, SUCCESS_MESSAGE);
		} else {
			addFlashMessage(redirectAttributes, Message.warn("admin.common.invalid"));
		}
		return "redirect:list.jhtml";
	}

	/**
	 * 完成
	 */
	@RequestMapping(value = "/complete", method = RequestMethod.POST)
	public String complete(Long id, RedirectAttributes redirectAttributes) {
		Order order = orderService.find(id);
		Admin admin = adminService.getCurrent();
		if (order != null && !order.isExpired() && order.getOrderStatus() == OrderStatus.confirmed && !order.isLocked(admin)) {
			orderService.complete(order, admin);
			addFlashMessage(redirectAttributes, SUCCESS_MESSAGE);
		} else {
			addFlashMessage(redirectAttributes, Message.warn("admin.common.invalid"));
		}
		return "redirect:view.jhtml?id=" + id;
	}

	/**
	 * 取消
	 */
	@RequestMapping(value = "/cancel", method = RequestMethod.POST)
	public String cancel(Long id, RedirectAttributes redirectAttributes) {
		Order order = orderService.find(id);
		Admin admin = adminService.getCurrent();
		if (order != null && !order.isExpired() && order.getOrderStatus() == OrderStatus.unconfirmed && !order.isLocked(admin)) {
			orderService.cancel(order, admin);
            mailService.sendApproveMail(order);
			addFlashMessage(redirectAttributes, SUCCESS_MESSAGE);
		} else {
			addFlashMessage(redirectAttributes, Message.warn("admin.common.invalid"));
		}
		return "redirect:view.jhtml?id=" + id;
	}
	
	/**
	 * 订单列表之订单取消
	 */
	@RequestMapping(value = "/listCancel", method = RequestMethod.POST)
	public String listCancel(Long id, RedirectAttributes redirectAttributes) {
		Order order = orderService.find(id);
		Admin admin = adminService.getCurrent();
		if (order != null && !order.isExpired() && order.getOrderStatus() == OrderStatus.unconfirmed && !order.isLocked(admin)) {
			orderService.cancel(order, admin);
			mailService.sendApproveMail(order);
			addFlashMessage(redirectAttributes, SUCCESS_MESSAGE);
		} else {
			addFlashMessage(redirectAttributes, Message.warn("admin.common.invalid"));
		}
		return "redirect:list.jhtml";
	}

	/**
	 * 支付
	 */
	@RequestMapping(value = "/payment", method = RequestMethod.POST)
	public String payment(Long orderId, Long paymentMethodId, Payment payment, RedirectAttributes redirectAttributes) {
		Order order = orderService.find(orderId);
		payment.setOrder(order);
		PaymentMethod paymentMethod = paymentMethodService.find(paymentMethodId);
		payment.setPaymentMethod(paymentMethod != null ? paymentMethod.getName() : null);
		if (!isValid(payment)) {
			return ERROR_VIEW;
		}
		if (order.isExpired() || order.getOrderStatus() != OrderStatus.confirmed) {
			return ERROR_VIEW;
		}
		if (order.getPaymentStatus() != PaymentStatus.unpaid && order.getPaymentStatus() != PaymentStatus.partialPayment) {
			return ERROR_VIEW;
		}
		if (payment.getAmount().compareTo(new BigDecimal(0)) <= 0 || payment.getAmount().compareTo(order.getAmountPayable()) > 0) {
			return ERROR_VIEW;
		}
		Member member = order.getMember();
		if (payment.getMethod() == Payment.Method.deposit && payment.getAmount().compareTo(member.getBalance()) > 0) {
			return ERROR_VIEW;
		}
		Admin admin = adminService.getCurrent();
		if (order.isLocked(admin)) {
			return ERROR_VIEW;
		}
		payment.setSn(snService.generate(Sn.Type.payment));
		payment.setType(Type.payment);
		payment.setStatus(Status.success);
		payment.setFee(new BigDecimal(0));
		payment.setOperator(admin.getUsername());
		payment.setPaymentDate(new Date());
		payment.setPaymentPluginId(null);
		payment.setExpire(null);
		payment.setDeposit(null);
		payment.setMember(null);
		orderService.payment(order, payment, admin);
		addFlashMessage(redirectAttributes, SUCCESS_MESSAGE);
		return "redirect:view.jhtml?id=" + orderId;
	}

	/**
	 * 退款
	 */
	@RequestMapping(value = "/refunds", method = RequestMethod.POST)
	public String refunds(Long orderId, Long paymentMethodId, Refunds refunds, RedirectAttributes redirectAttributes) {
		Order order = orderService.find(orderId);
		refunds.setOrder(order);
		PaymentMethod paymentMethod = paymentMethodService.find(paymentMethodId);
		refunds.setPaymentMethod(paymentMethod != null ? paymentMethod.getName() : null);
		if (!isValid(refunds)) {
			return ERROR_VIEW;
		}
		if (order.isExpired() || order.getOrderStatus() != OrderStatus.confirmed) {
			return ERROR_VIEW;
		}
		if (order.getPaymentStatus() != PaymentStatus.paid && order.getPaymentStatus() != PaymentStatus.partialPayment && order.getPaymentStatus() != PaymentStatus.partialRefunds) {
			return ERROR_VIEW;
		}
		if (refunds.getAmount().compareTo(new BigDecimal(0)) <= 0 || refunds.getAmount().compareTo(order.getAmountPaid()) > 0) {
			return ERROR_VIEW;
		}
		Admin admin = adminService.getCurrent();
		if (order.isLocked(admin)) {
			return ERROR_VIEW;
		}
		refunds.setSn(snService.generate(Sn.Type.refunds));
		refunds.setOperator(admin.getUsername());
		orderService.refunds(order, refunds, admin);
		addFlashMessage(redirectAttributes, SUCCESS_MESSAGE);
		return "redirect:view.jhtml?id=" + orderId;
	}

	/**
	 * 发货
	 */
	@RequestMapping(value = "/shipping", method = RequestMethod.POST)
	public String shipping(Long orderId, Long shippingMethodId, Long deliveryCorpId, Long areaId, Shipping shipping, RedirectAttributes redirectAttributes) {
		Order order = orderService.find(orderId);
		if (order == null) {
			return ERROR_VIEW;
		}
		for (Iterator<ShippingItem> iterator = shipping.getShippingItems().iterator(); iterator.hasNext();) {
			ShippingItem shippingItem = iterator.next();
			if (shippingItem == null || StringUtils.isEmpty(shippingItem.getSn()) || shippingItem.getQuantity() == null || shippingItem.getQuantity() <= 0) {
				iterator.remove();
				continue;
			}
			OrderItem orderItem = order.getOrderItem(shippingItem.getSn());
			if (orderItem == null || shippingItem.getQuantity() > orderItem.getQuantity() - orderItem.getShippedQuantity()) {
				return ERROR_VIEW;
			}
			if (orderItem.getProduct() != null && orderItem.getProduct().getStock() != null && shippingItem.getQuantity() > orderItem.getProduct().getStock()) {
				return ERROR_VIEW;
			}
			shippingItem.setName(orderItem.getFullName());
			shippingItem.setShipping(shipping);
		}
		shipping.setOrder(order);
		ShippingMethod shippingMethod = shippingMethodService.find(shippingMethodId);
		shipping.setShippingMethod(shippingMethod != null ? shippingMethod.getName() : null);
		DeliveryCorp deliveryCorp = deliveryCorpService.find(deliveryCorpId);
		shipping.setDeliveryCorp(deliveryCorp != null ? deliveryCorp.getName() : null);
		shipping.setDeliveryCorpUrl(deliveryCorp != null ? deliveryCorp.getUrl() : null);
		shipping.setDeliveryCorpCode(deliveryCorp != null ? deliveryCorp.getCode() : null);
		Area area = areaService.find(areaId);
		shipping.setArea(area != null ? area.getFullName() : null);
		if (!isValid(shipping)) {
			return ERROR_VIEW;
		}
		if (order.isExpired() || order.getOrderStatus() != OrderStatus.confirmed) {
			return ERROR_VIEW;
		}
		if (order.getShippingStatus() != ShippingStatus.unshipped && order.getShippingStatus() != ShippingStatus.partialShipment) {
			return ERROR_VIEW;
		}
		Admin admin = adminService.getCurrent();
		if (order.isLocked(admin)) {
			return ERROR_VIEW;
		}
		shipping.setSn(snService.generate(Sn.Type.shipping));
		shipping.setOperator(admin.getUsername());
		orderService.shipping(order, shipping, admin);
		addFlashMessage(redirectAttributes, SUCCESS_MESSAGE);
		return "redirect:view.jhtml?id=" + orderId;
	}

	/**
	 * 退货
	 */
	@RequestMapping(value = "/returns", method = RequestMethod.POST)
	public String returns(Long orderId, Long shippingMethodId, Long deliveryCorpId, Long areaId, Returns returns, RedirectAttributes redirectAttributes) {
		Order order = orderService.find(orderId);
		if (order == null) {
			return ERROR_VIEW;
		}
		for (Iterator<ReturnsItem> iterator = returns.getReturnsItems().iterator(); iterator.hasNext();) {
			ReturnsItem returnsItem = iterator.next();
			if (returnsItem == null || StringUtils.isEmpty(returnsItem.getSn()) || returnsItem.getQuantity() == null || returnsItem.getQuantity() <= 0) {
				iterator.remove();
				continue;
			}
			OrderItem orderItem = order.getOrderItem(returnsItem.getSn());
			if (orderItem == null || returnsItem.getQuantity() > orderItem.getShippedQuantity() - orderItem.getReturnQuantity()) {
				return ERROR_VIEW;
			}
			returnsItem.setName(orderItem.getFullName());
			returnsItem.setReturns(returns);
		}
		returns.setOrder(order);
		ShippingMethod shippingMethod = shippingMethodService.find(shippingMethodId);
		returns.setShippingMethod(shippingMethod != null ? shippingMethod.getName() : null);
		DeliveryCorp deliveryCorp = deliveryCorpService.find(deliveryCorpId);
		returns.setDeliveryCorp(deliveryCorp != null ? deliveryCorp.getName() : null);
		Area area = areaService.find(areaId);
		returns.setArea(area != null ? area.getFullName() : null);
		if (!isValid(returns)) {
			return ERROR_VIEW;
		}
		if (order.isExpired() || order.getOrderStatus() != OrderStatus.confirmed) {
			return ERROR_VIEW;
		}
		if (order.getShippingStatus() != ShippingStatus.shipped && order.getShippingStatus() != ShippingStatus.partialShipment && order.getShippingStatus() != ShippingStatus.partialReturns) {
			return ERROR_VIEW;
		}
		Admin admin = adminService.getCurrent();
		if (order.isLocked(admin)) {
			return ERROR_VIEW;
		}
		returns.setSn(snService.generate(Sn.Type.returns));
		returns.setOperator(admin.getUsername());
		orderService.returns(order, returns, admin);
		addFlashMessage(redirectAttributes, SUCCESS_MESSAGE);
		return "redirect:view.jhtml?id=" + orderId;
	}

	/**
	 * 编辑
	 */
	@RequestMapping(value = "/edit", method = RequestMethod.GET)
	public String edit(Long id, ModelMap model) {
		model.addAttribute("paymentMethods", paymentMethodService.findAll());
		model.addAttribute("shippingMethods", shippingMethodService.findAll());
		model.addAttribute("order", orderService.find(id));
		return "/admin/order/edit";
	}

	/**
	 * 订单项添加
	 */
	@RequestMapping(value = "/order_item_add", method = RequestMethod.POST)
	public @ResponseBody
	Map<String, Object> orderItemAdd(String productSn) {
		Map<String, Object> data = new HashMap<String, Object>();
		Product product = productService.findBySn(productSn);
		if (product == null) {
			data.put("message", Message.warn("admin.order.productNotExist"));
			return data;
		}
		if (!product.getIsMarketable()) {
			data.put("message", Message.warn("admin.order.productNotMarketable"));
			return data;
		}
		if (product.getIsOutOfStock()) {
			data.put("message", Message.warn("admin.order.productOutOfStock"));
			return data;
		}
		data.put("sn", product.getSn());
		data.put("fullName", product.getFullName());
		data.put("price", product.getPrice());
		data.put("weight", product.getWeight());
		data.put("isGift", product.getIsGift());
		data.put("message", SUCCESS_MESSAGE);
		return data;
	}

	/**
	 * 计算
	 */
	@RequestMapping(value = "/calculate", method = RequestMethod.POST)
	public @ResponseBody
	Map<String, Object> calculate(Order order, Long areaId, Long paymentMethodId, Long shippingMethodId) {
		Map<String, Object> data = new HashMap<String, Object>();
		for (Iterator<OrderItem> iterator = order.getOrderItems().iterator(); iterator.hasNext();) {
			OrderItem orderItem = iterator.next();
			if (orderItem == null || StringUtils.isEmpty(orderItem.getSn())) {
				iterator.remove();
			}
		}
		order.setArea(areaService.find(areaId));
		order.setPaymentMethod(paymentMethodService.find(paymentMethodId));
		order.setShippingMethod(shippingMethodService.find(shippingMethodId));
		if (!isValid(order)) {
			data.put("message", Message.warn("admin.common.invalid"));
			return data;
		}
		Order pOrder = orderService.find(order.getId());
		if (pOrder == null) {
			data.put("message", Message.error("admin.common.invalid"));
			return data;
		}
		for (OrderItem orderItem : order.getOrderItems()) {
			if (orderItem.getId() != null) {
				OrderItem pOrderItem = orderItemService.find(orderItem.getId());
				if (pOrderItem == null || !pOrder.equals(pOrderItem.getOrder())) {
					data.put("message", Message.error("admin.common.invalid"));
					return data;
				}
				Product product = pOrderItem.getProduct();
				if (product != null && product.getStock() != null) {
					if (pOrder.getIsAllocatedStock()) {
						if (orderItem.getQuantity() > product.getAvailableStock() + pOrderItem.getQuantity()) {
							data.put("message", Message.warn("admin.order.lowStock"));
							return data;
						}
					} else {
						if (orderItem.getQuantity() > product.getAvailableStock()) {
							data.put("message", Message.warn("admin.order.lowStock"));
							return data;
						}
					}
				}
			} else {
				Product product = productService.findBySn(orderItem.getSn());
				if (product == null) {
					data.put("message", Message.error("admin.common.invalid"));
					return data;
				}
				if (product.getStock() != null && orderItem.getQuantity() > product.getAvailableStock()) {
					data.put("message", Message.warn("admin.order.lowStock"));
					return data;
				}
			}
		}
		Map<String, Object> orderItems = new HashMap<String, Object>();
		for (OrderItem orderItem : order.getOrderItems()) {
			orderItems.put(orderItem.getSn(), orderItem);
		}
		order.setFee(pOrder.getFee());
		order.setPromotionDiscount(pOrder.getPromotionDiscount());
		order.setCouponDiscount(pOrder.getCouponDiscount());
		order.setAmountPaid(pOrder.getAmountPaid());
		data.put("weight", order.getWeight());
		data.put("price", order.getPrice());
		data.put("quantity", order.getQuantity());
		data.put("amount", order.getAmount());
		data.put("orderItems", orderItems);
		data.put("message", SUCCESS_MESSAGE);
		return data;
	}

	/**
	 * 更新
	 */
	@RequestMapping(value = "/update", method = RequestMethod.POST)
	public String update(Order order, Long areaId, Long paymentMethodId, Long shippingMethodId, RedirectAttributes redirectAttributes) {
		for (Iterator<OrderItem> iterator = order.getOrderItems().iterator(); iterator.hasNext();) {
			OrderItem orderItem = iterator.next();
			if (orderItem == null || StringUtils.isEmpty(orderItem.getSn())) {
				iterator.remove();
			}
		}
		order.setArea(areaService.find(areaId));
		order.setPaymentMethod(paymentMethodService.find(paymentMethodId));
		order.setShippingMethod(shippingMethodService.find(shippingMethodId));
		if (!isValid(order)) {
			return ERROR_VIEW;
		}
		Order pOrder = orderService.find(order.getId());
		if (pOrder == null) {
			return ERROR_VIEW;
		}
		if (pOrder.isExpired() || pOrder.getOrderStatus() != OrderStatus.unconfirmed) {
			return ERROR_VIEW;
		}
		Admin admin = adminService.getCurrent();
		if (pOrder.isLocked(admin)) {
			return ERROR_VIEW;
		}
		if (!order.getIsInvoice()) {
			order.setInvoiceTitle(null);
			order.setTax(new BigDecimal(0));
		}
		for (OrderItem orderItem : order.getOrderItems()) {
			if (orderItem.getId() != null) {
				OrderItem pOrderItem = orderItemService.find(orderItem.getId());
				if (pOrderItem == null || !pOrder.equals(pOrderItem.getOrder())) {
					return ERROR_VIEW;
				}
				Product product = pOrderItem.getProduct();
				if (product != null && product.getStock() != null) {
					if (pOrder.getIsAllocatedStock()) {
						if (orderItem.getQuantity() > product.getAvailableStock() + pOrderItem.getQuantity()) {
							return ERROR_VIEW;
						}
					} else {
						if (orderItem.getQuantity() > product.getAvailableStock()) {
							return ERROR_VIEW;
						}
					}
				}
				BeanUtils.copyProperties(pOrderItem, orderItem, new String[] { "price", "quantity" });
				if (pOrderItem.getIsGift()) {
					orderItem.setPrice(new BigDecimal(0));
				}
			} else {
				Product product = productService.findBySn(orderItem.getSn());
				if (product == null) {
					return ERROR_VIEW;
				}
				if (product.getStock() != null && orderItem.getQuantity() > product.getAvailableStock()) {
					return ERROR_VIEW;
				}
				orderItem.setName(product.getName());
				orderItem.setFullName(product.getFullName());
				if (product.getIsGift()) {
					orderItem.setPrice(new BigDecimal(0));
				}
				orderItem.setWeight(product.getWeight());
				orderItem.setThumbnail(product.getThumbnail());
				orderItem.setIsGift(product.getIsGift());
				orderItem.setShippedQuantity(0);
				orderItem.setReturnQuantity(0);
				orderItem.setProduct(product);
				orderItem.setOrder(pOrder);
			}
		}
		order.setSn(pOrder.getSn());
		order.setOrderStatus(pOrder.getOrderStatus());
		order.setPaymentStatus(pOrder.getPaymentStatus());
		order.setShippingStatus(pOrder.getShippingStatus());
		order.setFee(pOrder.getFee());
		order.setPromotionDiscount(pOrder.getPromotionDiscount());
		order.setCouponDiscount(pOrder.getCouponDiscount());
		order.setAmountPaid(pOrder.getAmountPaid());
		order.setPromotion(pOrder.getPromotion());
		order.setExpire(pOrder.getExpire());
		order.setLockExpire(null);
		order.setIsAllocatedStock(pOrder.getIsAllocatedStock());
		order.setOperator(null);
		order.setMember(pOrder.getMember());
		order.setCouponCode(pOrder.getCouponCode());
		order.setCoupons(pOrder.getCoupons());
		order.setOrderLogs(pOrder.getOrderLogs());
		order.setDeposits(pOrder.getDeposits());
		order.setPayments(pOrder.getPayments());
		order.setRefunds(pOrder.getRefunds());
		order.setShippings(pOrder.getShippings());
		order.setReturns(pOrder.getReturns());

		orderService.update(order, admin);
		addFlashMessage(redirectAttributes, SUCCESS_MESSAGE);
		return "redirect:list.jhtml";
	}

	/**
	 * 列表
	 */
	@RequestMapping(value = "/list", method = RequestMethod.GET)
	public String list(OrderStatus orderStatus, PaymentStatus paymentStatus, ShippingStatus shippingStatus, Boolean hasExpired, Pageable pageable, ModelMap model) {
		model.addAttribute("orderStatus", orderStatus);
		model.addAttribute("paymentStatus", paymentStatus);
		model.addAttribute("shippingStatus", shippingStatus);
		model.addAttribute("hasExpired", hasExpired);
		Admin admin = adminService.getCurrent();
		Set<Role> roles = admin.getRoles();
		//当前管理员所拥有的角色
		List<Long> roleIds = new ArrayList<Long>();
		for (Role role : roles) {
			roleIds.add(role.getId());
		}
		if (!roleIds.contains(Long.valueOf(1)) && roleIds.contains(Long.valueOf(2))) { //仅拥有订单管理员权限，只查询订单管理员关联的会员订单
			model.addAttribute("page", orderService.findPage(orderStatus, paymentStatus, shippingStatus, hasExpired, pageable, admin.getMembers()));
		}else {
			model.addAttribute("page", orderService.findPage(orderStatus, paymentStatus, shippingStatus, hasExpired, pageable));
		}
		if (roleIds.contains(Long.valueOf(1)) || roleIds.contains(Long.valueOf(2))) { //超级管理员和订单管理员有权限审批订单
			model.addAttribute("hasAuthentyApprove", true);
		}else {
			model.addAttribute("hasAuthentyApprove", false);
		}
		
		return "/admin/order/list";
	}

	/**
	 * 删除
	 */
	@RequestMapping(value = "/delete", method = RequestMethod.POST)
	public @ResponseBody
	Message delete(Long[] ids) {
		if (ids != null) {
			Admin admin = adminService.getCurrent();
			for (Long id : ids) {
				Order order = orderService.find(id);
				if (order != null && order.isLocked(admin)) {
					return Message.error("admin.order.deleteLockedNotAllowed", order.getSn());
				}
			}
			orderService.delete(ids);
		}
		return SUCCESS_MESSAGE;
	}

    /**
     * 查询combine历史
     */
    @RequestMapping(value = "/combineList")
	public String combineList(ModelMap model) {
    	List<CombineHis> list = orderService.findCombinePage();
    	if (list != null && list.size() > 0) {
    		model.put("costSave", list.get(0).getOldTotalAmount().subtract(list.get(0).getNewTotalAmount()));
    		model.put("endDate", list.get(0).getEndDate());
    	}
        model.put("combineList", list);
	    return "/admin/order/combineList";
	}
    
    /**
     * 手工合并订单
     */
    @RequestMapping(value = "/combineOrder")
	public String combineOrder(ModelMap model, String startDate, String endDate) {
    	Integer startDay=0;
    	Integer endDay=0;
    	if(null!=startDate && !"".equals(startDate)){
    		startDay=Integer.parseInt(startDate.substring(8, 10));
    	}
    	if(null!=endDate && !"".equals(endDate)){
    		endDay=Integer.parseInt(endDate.substring(8, 10));
    	}
    	
    	int combineHisId = orderService.combineOrder(startDay, endDay, startDate, endDate);
        //model.put("startDay", startDate);
        //model.put("endDay", endDate);
        model.put("combineHisId", combineHisId==0?null:combineHisId);
	    return combineList(model);
	}
    
    /**
     * 查询combine order list
     */
    @RequestMapping(value = "/combineOrderList")
	public String combineOrderList(ModelMap model, Integer combineHisId) {//String startDate, String endDate
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
	    return "/admin/order/combineOrderList";
	}
    
    /**
     * 查询combine order item list
     * @param orderId 
     */
    @RequestMapping(value = "/combineOrderItemList")
	public String combineOrderItemList(ModelMap model, Long orderId) {
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
        model.put("combineOrderItemList", list);
	    return "/admin/order/combineOrderItemList";
	}
    
    /**
	 * 查看
	 */
	@RequestMapping(value = "/splitInfo", method = RequestMethod.GET)
	public String splitInfo(long orderId, ModelMap model) {
		Order order = orderService.find(orderId);
		if (order == null) {
			return ERROR_VIEW;
		}
		model.addAttribute("order", order);
		return "/admin/order/splitInfo";
	}
	
	@RequestMapping(value = "/exportSplitInfo", method = RequestMethod.POST)
	public String exportSplitInfo(long id, HttpServletRequest request, HttpServletResponse response){
		Order order = orderService.find(id);
        String fileName = order.getSn()+"_"+net.shopxx.util.DateUtils.getDate("yyyyMMddHHmmss")+".xlsx"; 
		try {
			new ExportExcel("Order No. "+order.getSn()+" split list", OrderSplitItem.class).setDataList(order.getSplitItems()).write(response, fileName).dispose();
			return null;
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		return "/admin/order/list";
	}

}