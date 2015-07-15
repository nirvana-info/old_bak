/*
 * 
 * 
 * 
 */
package net.shopxx.entity;

import java.math.BigDecimal;
import java.util.ArrayList;
import java.util.List;
import java.util.Map;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.FetchType;
import javax.persistence.JoinColumn;
import javax.persistence.ManyToOne;
import javax.persistence.SequenceGenerator;
import javax.persistence.Table;
import javax.persistence.Transient;
import javax.validation.constraints.Digits;
import javax.validation.constraints.Min;

import net.shopxx.Setting;
import net.shopxx.util.SettingUtils;

/**
 * Entity - 购物车项
 * 
 * 
 * 
 */
@Entity
@Table(name = "xx_cart_item")
@SequenceGenerator(name = "sequenceGenerator", sequenceName = "xx_cart_item_sequence")
public class CartItem extends BaseEntity {

	private static final long serialVersionUID = 2979296789363163144L;

	/** 最大数量 */
	public static final Integer MAX_QUANTITY = 10000;

	/** 数量 */
	private Integer quantity;

	/** 商品 */
	private Product product;

	/** 购物车 */
	private Cart cart;

	/** 临时商品价格 */
	private BigDecimal tempPrice;

	/** 临时赠送积分 */
	private Long tempPoint;
	
	/** 交易价 */
	private BigDecimal endPrice;
	
	private List<OrderSplitItem> splitItems = new ArrayList<OrderSplitItem>();

	/**
	 * 获取数量
	 * 
	 * @return 数量
	 */
	@Column(nullable = false)
	public Integer getQuantity() {
		return quantity;
	}

	/**
	 * 设置数量
	 * 
	 * @param quantity
	 *            数量
	 */
	public void setQuantity(Integer quantity) {
		this.quantity = quantity;
	}

	/**
	 * 获取商品
	 * 
	 * @return 商品
	 */
	@ManyToOne(fetch = FetchType.LAZY)
	@JoinColumn(nullable = false, updatable = false)
	public Product getProduct() {
		return product;
	}

	/**
	 * 设置商品
	 * 
	 * @param product
	 *            商品
	 */
	public void setProduct(Product product) {
		this.product = product;
	}

	/**
	 * 获取购物车
	 * 
	 * @return 购物车
	 */
	@ManyToOne(fetch = FetchType.LAZY)
	@JoinColumn(nullable = false)
	public Cart getCart() {
		return cart;
	}

	/**
	 * 设置购物车
	 * 
	 * @param cart
	 *            购物车
	 */
	public void setCart(Cart cart) {
		this.cart = cart;
	}

	/**
	 * 获取临时商品价格
	 * 
	 * @return 临时商品价格
	 */
	@Transient
	public BigDecimal getTempPrice() {
		if (tempPrice == null) {
			return getSubtotal();
		}
		return tempPrice;
	}

	/**
	 * 设置临时商品价格
	 * 
	 * @param tempPrice
	 *            临时商品价格
	 */
	@Transient
	public void setTempPrice(BigDecimal tempPrice) {
		this.tempPrice = tempPrice;
	}

	/**
	 * 获取临时赠送积分
	 * 
	 * @return 临时赠送积分
	 */
	@Transient
	public Long getTempPoint() {
		if (tempPoint == null) {
			return getPoint();
		}
		return tempPoint;
	}

	/**
	 * 设置临时赠送积分
	 * 
	 * @param tempPoint
	 *            临时赠送积分
	 */
	@Transient
	public void setTempPoint(Long tempPoint) {
		this.tempPoint = tempPoint;
	}

	/**
	 * 获取赠送积分
	 * 
	 * @return 赠送积分
	 */
	@Transient
	public long getPoint() {
		if (getProduct() != null && getProduct().getPoint() != null && getQuantity() != null) {
			return getProduct().getPoint() * getQuantity();
		} else {
			return 0L;
		}
	}

	/**
	 * 获取商品重量
	 * 
	 * @return 商品重量
	 */
	@Transient
	public BigDecimal getWeight() {
		if (getProduct() != null && getProduct().getWeight() != null && getQuantity() != null) {
			return getProduct().getWeight().multiply(new BigDecimal(getQuantity()));
		} else {
			return new BigDecimal(0);
		}
	}
	
	/**
	 * 获取商品体积
	 * 
	 * @return 商品体积
	 */
	@Transient
	public BigDecimal getVolume() {
		if (getProduct() != null && getProduct().getVolume() != null && getQuantity() != null) {
			return getProduct().getVolume().multiply(new BigDecimal(getQuantity()));
		} else {
			return new BigDecimal(0);
		}
	}

	/**
	 * 获取价格
	 * 
	 * @return 价格
	 */
	@Transient
	public BigDecimal getPrice() {
		Setting setting = SettingUtils.get();
//		if(this.endPrice != null){
//			return setting.setScale(this.endPrice);
//		}
		if (getProduct() != null && getProduct().getPrice() != null) {
			if (getCart() != null && getCart().getMember() != null && getCart().getMember().getMemberRank() != null) {
				MemberRank memberRank = getCart().getMember().getMemberRank();
				Map<MemberRank, BigDecimal> memberPrice = getProduct().getMemberPrice();
				if (memberPrice != null && !memberPrice.isEmpty()) {
					if (memberPrice.containsKey(memberRank)) {
						return setting.setScale(memberPrice.get(memberRank));
					}
				}
				if (memberRank.getScale() != null) {
					return setting.setScale(getProduct().getPrice().multiply(new BigDecimal(memberRank.getScale())));
				}
			}
			return setting.setScale(getProduct().getPrice());
		} else {
			return new BigDecimal(0);
		}
	}
	
	/**
	 * 获取成交价格
	 * 
	 * @return 成交价格
	 */
	@Transient
	public BigDecimal getFinalPrice() {
		Setting setting = SettingUtils.get();
		if(this.endPrice != null){
			return setting.setScale(this.endPrice);
		}
		if (getProduct() != null && getProduct().getPrice() != null) {
			if (getCart() != null && getCart().getMember() != null && getCart().getMember().getMemberRank() != null) {
				MemberRank memberRank = getCart().getMember().getMemberRank();
				Map<MemberRank, BigDecimal> memberPrice = getProduct().getMemberPrice();
				if (memberPrice != null && !memberPrice.isEmpty()) {
					if (memberPrice.containsKey(memberRank)) {
						return setting.setScale(memberPrice.get(memberRank));
					}
				}
				if (memberRank.getScale() != null) {
					return setting.setScale(getProduct().getPrice().multiply(new BigDecimal(memberRank.getScale())));
				}
			}
			return setting.setScale(getProduct().getPrice());
		} else {
			return new BigDecimal(0);
		}
	}

	/**
	 * 获取小计
	 * 
	 * @return 小计
	 */
	@Transient
	public BigDecimal getSubtotal() {
		if (getQuantity() != null) {
			return getPrice().multiply(new BigDecimal(getQuantity()));
		} else {
			return new BigDecimal(0);
		}
	}
	
	/**
	 * 获取最终成交价小计
	 * 
	 * @return 最终成交价小计
	 */
	@Transient
	public BigDecimal getFinalSubtotal() {
		if (getQuantity() != null) {
			return getFinalPrice().multiply(new BigDecimal(getQuantity()));
		} else {
			return new BigDecimal(0);
		}
	}

	/**
	 * 获取是否库存不足
	 * 
	 * @return 是否库存不足
	 */
	@Transient
	public boolean getIsLowStock() {
		if (getQuantity() != null && getProduct() != null && getProduct().getStock() != null && getQuantity() > getProduct().getAvailableStock()) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * 增加商品数量
	 * 
	 * @param quantity
	 *            数量
	 */
	@Transient
	public void add(int quantity) {
		if (quantity > 0) {
			if (getQuantity() != null) {
				setQuantity(getQuantity() + quantity);
			} else {
				setQuantity(quantity);
			}
		}
	}

	@Min(0)
	@Digits(integer = 12, fraction = 3)
	@Column(precision = 21, scale = 6)
	public BigDecimal getEndPrice() {
		return endPrice;
	}

	public void setEndPrice(BigDecimal endPrice) {
		this.endPrice = endPrice;
	}
	
	@Transient
	public List<OrderSplitItem> getSplitItems() {
		return splitItems;
	}

	public void setSplitItems(List<OrderSplitItem> splitItems) {
		this.splitItems = splitItems;
	}
	
	/**
	 * 拆分的总数量
	 * @return
	 */
	@Transient
	public Integer getSplitTotalQuantity(){
		if (getSplitItems().size()>0) {
			Integer totalQuantity = 0;
			for (OrderSplitItem item : getSplitItems()) {
					totalQuantity += item.getQuantity();
			}
			return totalQuantity;
		}else {
			return 0;
		}
	}
	
	/**
	 * 剩余总重量
	 * @return
	 */
	@Transient
	public BigDecimal getSurplusWeight(){
		if(getProduct().getWeight()==null) return new BigDecimal(0);
		return getWeight().subtract(getProduct().getWeight().multiply(new BigDecimal(getSplitTotalQuantity())));
	}
	
	/**
	 * 剩余总体积
	 * @return
	 */
	@Transient
	public BigDecimal getSurplusVolume(){
		if(getProduct().getVolume()==null) return new BigDecimal(0);
		return getVolume().subtract(getProduct().getVolume().multiply(new BigDecimal(getSplitTotalQuantity())));
	}

}