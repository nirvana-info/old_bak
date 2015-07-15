package net.shopxx.entity;

import java.math.BigDecimal;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.FetchType;
import javax.persistence.JoinColumn;
import javax.persistence.ManyToOne;
import javax.persistence.SequenceGenerator;
import javax.persistence.Table;
import javax.persistence.Transient;
import javax.validation.constraints.Min;
import javax.validation.constraints.NotNull;

import net.shopxx.util.excel.annotation.ExcelField;

import org.hibernate.annotations.NotFound;
import org.hibernate.annotations.NotFoundAction;
import org.hibernate.validator.constraints.Length;

import com.fasterxml.jackson.annotation.JsonProperty;

/**
 * Entity - 订单拆分项
 * 
 * 
 * 
 */
@Entity
@Table(name = "xx_order_split_item")
@SequenceGenerator(name = "sequenceGenerator", sequenceName = "xx_order_split_item_sequence")
public class OrderSplitItem extends BaseEntity {

	/**
	 * 
	 */
	private static final long serialVersionUID = -5846622116675605687L;

	private Integer quantity;
	private Integer ternalType;
	private String complantCode;
	/** 收货地址 */
	private Receiver receiver;
	/** 地区名称 */
	private String areaName;

	/** 地址 */
	private String address;
	private String sbu;
	private String entity;
	private Product product;
	private CartItem cartItem;
	/** 订单 */
	private Order order;
	private OrderItem orderItem;
	//运费计算方式
	private Integer calculationMethod;
	
	@ExcelField(title="Product Number", align=2, sort=20)
	@Transient
	public String getProductNumber(){
		return product.getSn();
	}
	
	@ExcelField(title="Product Name", align=2, sort=25)
	@Transient
	public String getProductName(){
		return product.getFullName();
	}

	@ExcelField(title="Quantity", align=2, sort=30)
	@JsonProperty
	@NotNull
	@Min(1)
	@Column(nullable = false)
	public Integer getQuantity() {
		return quantity;
	}

	public void setQuantity(Integer quantity) {
		this.quantity = quantity;
	}

	public Integer getTernalType() {
		return ternalType;
	}

	public void setTernalType(Integer ternalType) {
		this.ternalType = ternalType;
	}
	
	@ExcelField(title="Internal/External", align=2, sort=45)
	@Transient
	public String getTernalTypePrint() {
		if(ternalType == 1)
			return "internal";
		else 
			return "external";
	}

	@ExcelField(title="Complant code", align=2, sort=50)
	public String getComplantCode() {
		return complantCode;
	}

	public void setComplantCode(String complantCode) {
		this.complantCode = complantCode;
	}
	
	/**
	 * 获取地区
	 * 
	 * @return 收货地址
	 */
	@ManyToOne(fetch = FetchType.LAZY)
	public Receiver getReceiver() {
		return receiver;
	}

	/**
	 * 设置收货地址
	 * 
	 * @param receiver
	 *            收货地址
	 */
	public void setReceiver(Receiver receiver) {
		this.receiver = receiver;
	}
	
	@ExcelField(title="Receiver", align=2, sort=65)
	@Transient
	public String getReceiverConsignee(){
		return this.getReceiver().getConsignee();
	}
	
	@ExcelField(title="Ship to", align=2, sort=70)
	@Transient
	public String getFullAddress(){
		return this.getReceiver().getAreaName()+this.getReceiver().getAddress();
	}

	public String getAreaName() {
		return areaName;
	}

	public void setAreaName(String areaName) {
		this.areaName = areaName;
	}

	public String getAddress() {
		return address;
	}

	public void setAddress(String address) {
		this.address = address;
	}

	@ExcelField(title="SBU", align=2, sort=55)
	@Length(max = 200)
	public String getSbu() {
		return sbu;
	}

	public void setSbu(String sbu) {
		this.sbu = sbu;
	}

	@ExcelField(title="Entity", align=2, sort=60)
	@Length(max = 200)
	public String getEntity() {
		return entity;
	}

	public void setEntity(String entity) {
		this.entity = entity;
	}
	
	@ManyToOne(fetch = FetchType.LAZY)
	@JoinColumn(name = "product")
	@NotFound(action = NotFoundAction.IGNORE)
	public Product getProduct() {
		return product;
	}

	public void setProduct(Product product) {
		this.product = product;
	}

	@ManyToOne(fetch = FetchType.LAZY)
	public CartItem getCartItem() {
		return cartItem;
	}

	public void setCartItem(CartItem cartItem) {
		this.cartItem = cartItem;
	}

	@ManyToOne(fetch = FetchType.LAZY)
	@JoinColumn(name = "orders")
	public Order getOrder() {
		return order;
	}

	public void setOrder(Order order) {
		this.order = order;
	}

	@ManyToOne(fetch = FetchType.LAZY)
	public OrderItem getOrderItem() {
		return orderItem;
	}

	public void setOrderItem(OrderItem orderItem) {
		this.orderItem = orderItem;
	}
	
	public Integer getCalculationMethod() {
		return calculationMethod;
	}

	public void setCalculationMethod(Integer calculationMethod) {
		this.calculationMethod = calculationMethod;
	}
	
	@ExcelField(title="Calculation method", align=2, sort=75)
	@Transient
	public String getCalculationMethodPrint() {
		if(calculationMethod==1)
			return "Weight";
		else if (calculationMethod==2) 
			return "Volume";
		else 
			return "";
	}

	/**
	 * 获取商品重量
	 * 
	 * @return 商品重量
	 */
	@Transient
	@ExcelField(title="Total weight", align=2, sort=35)
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
	@ExcelField(title="Total volume", align=2, sort=40)
	public BigDecimal getVolume() {
		if (getProduct() != null && getProduct().getVolume() != null && getQuantity() != null) {
			return getProduct().getVolume().multiply(new BigDecimal(getQuantity()));
		} else {
			return new BigDecimal(0);
		}
	}

}
