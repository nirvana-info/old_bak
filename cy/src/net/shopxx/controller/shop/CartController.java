/*
 * 
 * 
 * 
 */
package net.shopxx.controller.shop;

import java.math.BigDecimal;
import java.util.HashMap;
import java.util.Map;
import java.util.Set;
import java.util.UUID;

import javax.annotation.Resource;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import net.shopxx.Message;
import net.shopxx.entity.Cart;
import net.shopxx.entity.CartItem;
import net.shopxx.entity.Member;
import net.shopxx.entity.Product;
import net.shopxx.entity.ProductGradientPrice;
import net.shopxx.service.CartItemService;
import net.shopxx.service.CartService;
import net.shopxx.service.MemberService;
import net.shopxx.service.ProductService;
import net.shopxx.util.WebUtils;

import org.apache.commons.codec.digest.DigestUtils;
import org.apache.commons.lang.RandomStringUtils;
import org.springframework.stereotype.Controller;
import org.springframework.ui.ModelMap;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.ResponseBody;

/**
 * Controller - 购物车
 * 
 * 
 * 
 */
@Controller("shopCartController")
@RequestMapping("/cart")
public class CartController extends BaseController {

	@Resource(name = "memberServiceImpl")
	private MemberService memberService;
	@Resource(name = "productServiceImpl")
	private ProductService productService;
	@Resource(name = "cartServiceImpl")
	private CartService cartService;
	@Resource(name = "cartItemServiceImpl")
	private CartItemService cartItemService;

	/**
	 * 添加
	 */
	@RequestMapping(value = "/add", method = RequestMethod.POST)
	public @ResponseBody
	Message add(Long id, Integer quantity, HttpServletRequest request, HttpServletResponse response) {
		if (quantity == null || quantity < 1) {
			return ERROR_MESSAGE;
		}
		Product product = productService.find(id);
		if (product == null) {
			return Message.warn("shop.cart.productNotExsit");
		}
		if (!product.getIsMarketable()) {
			return Message.warn("shop.cart.productNotMarketable");
		}
		if (product.getIsGift()) {
			return Message.warn("shop.cart.notForSale");
		}

		Cart cart = cartService.getCurrent();
		Member member = memberService.getCurrent();

		if (cart == null) {
			cart = new Cart();
			cart.setKey(UUID.randomUUID().toString() + DigestUtils.md5Hex(RandomStringUtils.randomAlphabetic(30)));
			cart.setMember(member);
			cartService.save(cart);
		}

		if (Cart.MAX_PRODUCT_COUNT != null && cart.getCartItems().size() >= Cart.MAX_PRODUCT_COUNT) {
			return Message.warn("shop.cart.addCountNotAllowed", Cart.MAX_PRODUCT_COUNT);
		}

		if (cart.contains(product)) {
			CartItem cartItem = cart.getCartItem(product);
			if (CartItem.MAX_QUANTITY != null && cartItem.getQuantity() + quantity > CartItem.MAX_QUANTITY) {
				return Message.warn("shop.cart.maxCartItemQuantity", CartItem.MAX_QUANTITY);
			}
			if (product.getStock() != null && cartItem.getQuantity() + quantity > product.getAvailableStock()) {
				return Message.warn("shop.cart.productLowStock");
			}
			cartItem.add(quantity);
			quantity = cartItem.getQuantity();
			//
			//计算阶梯定价
			BigDecimal endPrice = product.getPrice();
			if(product.getGradientLists().size()>0){
				for(ProductGradientPrice gradientPrice:product.getGradientLists()){
					if(quantity>=gradientPrice.getStartQuantity() && quantity<=gradientPrice.getEndQuantity()){
						endPrice = gradientPrice.getPrice();
						break;
					}
				}
			}
			cartItem.setEndPrice(endPrice);
			cartItemService.update(cartItem);
		} else {
			if (CartItem.MAX_QUANTITY != null && quantity > CartItem.MAX_QUANTITY) {
				return Message.warn("shop.cart.maxCartItemQuantity", CartItem.MAX_QUANTITY);
			}
			if (product.getStock() != null && quantity > product.getAvailableStock()) {
				return Message.warn("shop.cart.productLowStock");
			}
			CartItem cartItem = new CartItem();
			cartItem.setQuantity(quantity);
			cartItem.setProduct(product);
			cartItem.setCart(cart);
			//计算阶梯定价
			BigDecimal endPrice = product.getPrice();
			if(product.getGradientLists().size()>0){
				for(ProductGradientPrice gradientPrice:product.getGradientLists()){
					if(quantity>=gradientPrice.getStartQuantity() && quantity<=gradientPrice.getEndQuantity()){
						endPrice = gradientPrice.getPrice();
						break;
					}
				}
			}
			cartItem.setEndPrice(endPrice);
			cartItemService.save(cartItem);
			cart.getCartItems().add(cartItem);
		}

		if (member == null) {
			WebUtils.addCookie(request, response, Cart.ID_COOKIE_NAME, cart.getId().toString(), Cart.TIMEOUT);
			WebUtils.addCookie(request, response, Cart.KEY_COOKIE_NAME, cart.getKey(), Cart.TIMEOUT);
		}
		return Message.success("shop.cart.addSuccess", cart.getQuantity(), currency(cart.getEndEffectivePrice(), true, false));
	}

	/**
	 * 列表
	 */
	@RequestMapping(value = "/list", method = RequestMethod.GET)
	public String list(ModelMap model) {
		model.addAttribute("cart", cartService.getCurrent());
		return "/shop/cart/list";
	}

	/**
	 * 编辑
	 */
	@RequestMapping(value = "/edit", method = RequestMethod.POST)
	public @ResponseBody
	Map<String, Object> edit(Long id, Integer quantity) {
		Map<String, Object> data = new HashMap<String, Object>();
		if (quantity == null || quantity < 1) {
			data.put("message", ERROR_MESSAGE);
			return data;
		}
		Cart cart = cartService.getCurrent();
		if (cart == null || cart.isEmpty()) {
			data.put("message", Message.error("shop.cart.notEmpty"));
			return data;
		}
		CartItem cartItem = cartItemService.find(id);
		Set<CartItem> cartItems = cart.getCartItems();
		if (cartItem == null || cartItems == null || !cartItems.contains(cartItem)) {
			data.put("message", Message.error("shop.cart.cartItemNotExsit"));
			return data;
		}
		if (CartItem.MAX_QUANTITY != null && quantity > CartItem.MAX_QUANTITY) {
			data.put("message", Message.warn("shop.cart.maxCartItemQuantity", CartItem.MAX_QUANTITY));
			return data;
		}
		Product product = cartItem.getProduct();
		if (product.getStock() != null && quantity > product.getAvailableStock()) {
			data.put("message", Message.warn("shop.cart.productLowStock"));
			return data;
		}
		//计算阶梯定价
		BigDecimal endPrice = product.getPrice();
		if(product.getGradientLists().size()>0){
			for(ProductGradientPrice gradientPrice:product.getGradientLists()){
				if(quantity>=gradientPrice.getStartQuantity() && quantity<=gradientPrice.getEndQuantity()){
					endPrice = gradientPrice.getPrice();
					break;
				}
			}
		}
		cartItem.setEndPrice(endPrice);
		cartItem.setQuantity(quantity);
		cartItemService.update(cartItem);

		data.put("message", SUCCESS_MESSAGE);
		data.put("subtotal", cartItem.getSubtotal());
		data.put("finalSubtotal", cartItem.getFinalSubtotal());
		data.put("isLowStock", cartItem.getIsLowStock());
		data.put("quantity", cart.getQuantity());
		data.put("effectivePoint", cart.getEffectivePoint());
		data.put("effectivePrice", cart.getEffectivePrice());
		data.put("endEffectivePrice", cart.getEndEffectivePrice());
		data.put("totalWeight", cart.getTotalWeight());
		data.put("totalVolume", cart.getTotalVolume());
		data.put("promotions", cart.getPromotions());
		data.put("giftItems", cart.getGiftItems());
		return data;
	}

	/**
	 * 删除
	 */
	@RequestMapping(value = "/delete", method = RequestMethod.POST)
	public @ResponseBody
	Map<String, Object> delete(Long id) {
		Map<String, Object> data = new HashMap<String, Object>();
		Cart cart = cartService.getCurrent();
		if (cart == null || cart.isEmpty()) {
			data.put("message", Message.error("shop.cart.notEmpty"));
			return data;
		}
		CartItem cartItem = cartItemService.find(id);
		Set<CartItem> cartItems = cart.getCartItems();
		if (cartItem == null || cartItems == null || !cartItems.contains(cartItem)) {
			data.put("message", Message.error("shop.cart.cartItemNotExsit"));
			return data;
		}
		cartItems.remove(cartItem);
		cartItemService.delete(cartItem);

		data.put("message", SUCCESS_MESSAGE);
		data.put("quantity", cart.getQuantity());
		data.put("effectivePoint", cart.getEffectivePoint());
		data.put("effectivePrice", cart.getEffectivePrice());
		data.put("endEffectivePrice", cart.getEndEffectivePrice());
		data.put("totalWeight", cart.getTotalWeight());
		data.put("totalVolume", cart.getTotalVolume());
		data.put("promotions", cart.getPromotions());
		data.put("isLowStock", cart.getIsLowStock());
		return data;
	}
	
	/**
	 * 删除选择
	 */
	@RequestMapping(value = "/deleteSelect", method = RequestMethod.POST)
	public @ResponseBody
	Message deleteSelect(Long[] ids) {
		if (ids != null) {
			for (Long id : ids) {
				CartItem cartItem = cartItemService.find(id);
				if (cartItem == null) {
					return Message.error("shop.cart.deleteExistNotAllowed",cartItem.getProduct().getName());
				}
			}
			cartItemService.delete(ids);
		}
		return SUCCESS_MESSAGE;
	}

	/**
	 * 清空
	 */
	@RequestMapping(value = "/clear", method = RequestMethod.POST)
	public @ResponseBody
	Message clear() {
		Cart cart = cartService.getCurrent();
		cartService.delete(cart);
		return SUCCESS_MESSAGE;
	}

}