/*
 * 
 * 
 * 
 */
package net.shopxx.entity;

import java.math.BigDecimal;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.FetchType;
import javax.persistence.Lob;
import javax.persistence.ManyToOne;
import javax.persistence.SequenceGenerator;
import javax.persistence.Table;
import javax.persistence.Transient;
import javax.validation.constraints.Digits;
import javax.validation.constraints.Min;
import javax.validation.constraints.NotNull;

import net.shopxx.Setting;
import net.shopxx.util.ConvertToHtml;
import net.shopxx.util.HTMLSpirit;
import net.shopxx.util.SettingUtils;

import org.apache.commons.lang3.StringUtils;
import org.hibernate.validator.constraints.Length;

/**
 * Entity - 配送方式
 * 
 * 
 * 
 */
@Entity
@Table(name = "xx_shipping_method_detail")
@SequenceGenerator(name = "sequenceGenerator", sequenceName = "xx_shipping_method_detail_sequence")
public class ShippingMethodDetail extends BaseEntity {
	/**
	 * 
	 */
	private static final long serialVersionUID = 8760263942481831414L;

	/** 地区 */
	private Area area;
	
	/** 物流公司 */
	private ShippingMethod shippingMethod;

	/** 首重量 */
	private Integer firstWeight;

	/** 续重量 */
	private Integer continueWeight;

	/** 首重价格 */
	private BigDecimal firstPrice;

	/** 续重价格 */
	private BigDecimal continuePrice;
	
	/** 首体积量 */
	private Integer firstVolume;

	/** 续体积量 */
	private Integer continueVolume;

	/** 首体积价格 */
	private BigDecimal firstVolumePrice;

	/** 续体积价格 */
	private BigDecimal continueVolumePrice;

	/** 图标 */
	private String icon;

	/** 介绍 */
	private String description;
	
	/** 排序 */
	private Integer order;

	/**
	 * 获取物流公司
	 * 
	 * @return 物流公司
	 */
	@ManyToOne(fetch = FetchType.LAZY)
	public ShippingMethod getShippingMethod() {
		return shippingMethod;
	}

	/**
	 * 设置物流公司
	 * 
	 * @param area
	 *            物流公司
	 */
	public void setShippingMethod(ShippingMethod shippingMethod) {
		this.shippingMethod = shippingMethod;
	}
	
	/**
	 * 获取地区
	 * 
	 * @return 地区
	 */
	@ManyToOne(fetch = FetchType.LAZY)
	public Area getArea() {
		return area;
	}

	/**
	 * 设置地区
	 * 
	 * @param area
	 *            地区
	 */
	public void setArea(Area area) {
		this.area = area;
	}

	/**
	 * 获取首重量
	 * 
	 * @return 首重量
	 */
	@NotNull
	@Min(0)
	@Column(nullable = false)
	public Integer getFirstWeight() {
		return firstWeight;
	}

	/**
	 * 设置首重量
	 * 
	 * @param firstWeight
	 *            首重量
	 */
	public void setFirstWeight(Integer firstWeight) {
		this.firstWeight = firstWeight;
	}

	/**
	 * 获取续重量
	 * 
	 * @return 续重量
	 */
	@NotNull
	@Min(1)
	@Column(nullable = false)
	public Integer getContinueWeight() {
		return continueWeight;
	}

	/**
	 * 设置续重量
	 * 
	 * @param continueWeight
	 *            续重量
	 */
	public void setContinueWeight(Integer continueWeight) {
		this.continueWeight = continueWeight;
	}

	/**
	 * 获取首重价格
	 * 
	 * @return 首重价格
	 */
	@NotNull
	@Min(0)
	@Digits(integer = 12, fraction = 3)
	@Column(nullable = false, precision = 21, scale = 6)
	public BigDecimal getFirstPrice() {
		return firstPrice;
	}

	/**
	 * 设置首重价格
	 * 
	 * @param firstPrice
	 *            首重价格
	 */
	public void setFirstPrice(BigDecimal firstPrice) {
		this.firstPrice = firstPrice;
	}

	/**
	 * 获取续重价格
	 * 
	 * @return 续重价格
	 */
	@NotNull
	@Min(0)
	@Digits(integer = 12, fraction = 3)
	@Column(nullable = false, precision = 21, scale = 6)
	public BigDecimal getContinuePrice() {
		return continuePrice;
	}

	/**
	 * 设置续重价格
	 * 
	 * @param continuePrice
	 *            续重价格
	 */
	public void setContinuePrice(BigDecimal continuePrice) {
		this.continuePrice = continuePrice;
	}
	
	/**
	 * 获取首体积
	 * 
	 * @return 首体积
	 */
	@Min(0)
	@Column(nullable = false)
	public Integer getFirstVolume() {
		return firstVolume;
	}

	/**
	 * 设置首体积
	 * 
	 * @param firstVolume
	 *            首体积
	 */
	public void setFirstVolume(Integer firstVolume) {
		this.firstVolume = firstVolume;
	}

	/**
	 * 获取续体积
	 * 
	 * @return 续体积
	 */
	@Min(0)
	@Column(nullable = false)
	public Integer getContinueVolume() {
		return continueVolume;
	}

	/**
	 * 设置续体积
	 * 
	 * @param continueVolume
	 *            续体积
	 */
	public void setContinueVolume(Integer continueVolume) {
		this.continueVolume = continueVolume;
	}

	/**
	 * 获取首体积价格
	 * 
	 * @return 首体积价格
	 */
	@Min(0)
	@Digits(integer = 12, fraction = 3)
	@Column(nullable = false, precision = 21, scale = 6)
	public BigDecimal getFirstVolumePrice() {
		return firstVolumePrice;
	}

	/**
	 * 设置首体积价格
	 * 
	 * @param firstPrice
	 *            首体积价格
	 */
	public void setFirstVolumePrice(BigDecimal firstVolumePrice) {
		this.firstVolumePrice = firstVolumePrice;
	}

	/**
	 * 获取续体积价格
	 * 
	 * @return 续体积价格
	 */
	@Min(0)
	@Digits(integer = 12, fraction = 3)
	@Column(nullable = false, precision = 21, scale = 6)
	public BigDecimal getContinueVolumePrice() {
		return continueVolumePrice;
	}

	/**
	 * 设置续体积价格
	 * 
	 * @param continuePrice
	 *            续体积价格
	 */
	public void setContinueVolumePrice(BigDecimal continueVolumePrice) {
		this.continueVolumePrice = continueVolumePrice;
	}

	/**
	 * 获取图标
	 * 
	 * @return 图标
	 */
	@Length(max = 200)
	public String getIcon() {
		return icon;
	}

	/**
	 * 设置图标
	 * 
	 * @param icon
	 *            图标
	 */
	public void setIcon(String icon) {
		this.icon = icon;
	}

	/**
	 * 获取介绍
	 * 
	 * @return 介绍
	 */
	@Lob
	public String getDescription() {
		return description;
	}

	/**
	 * 设置介绍
	 * 
	 * @param description
	 *            介绍
	 */
	public void setDescription(String description) {
		this.description = description;
	}
	
	@Transient
	public String getDescriptionStr() {
		if (StringUtils.isNotEmpty(description)) {
			String descriptionStr = HTMLSpirit.delHTMLTag(ConvertToHtml
					.convertor(description));
			return descriptionStr;
		}
		return null;
	}

	/**
	 * 计算运费
	 * 
	 * @param weight
	 *            重量
	 * @return 运费
	 */
	@Transient
	public BigDecimal calculateFreight(BigDecimal weight) {
		Setting setting = SettingUtils.get();
		BigDecimal freight = new BigDecimal(0);
		if (weight != null) {
			if (BigDecimal.valueOf(getFirstWeight()).compareTo(weight)==1 || BigDecimal.valueOf(getFirstWeight()).compareTo(weight)==0 || getContinuePrice().compareTo(new BigDecimal(0)) == 0) {
				freight = getFirstPrice();
			} else {
				double contiuneWeightCount = Math.ceil((weight.subtract(BigDecimal.valueOf(getFirstWeight()))).doubleValue() / (double) getContinueWeight());
				freight = getFirstPrice().add(getContinuePrice().multiply(new BigDecimal(contiuneWeightCount)));
			}
		}
		return setting.setScale(freight);
	}
	
	/**
	 * 计算运费
	 * 
	 * @param volume
	 *            体积
	 * @return 运费
	 */
	@Transient
	public BigDecimal calculateFreightByVolume(BigDecimal volume) {
		Setting setting = SettingUtils.get();
		BigDecimal freight = new BigDecimal(0);
		if (volume != null) {
			if (BigDecimal.valueOf(getFirstVolume()).compareTo(volume) == 1 || BigDecimal.valueOf(getFirstVolume()).compareTo(volume) == 0 || getContinueVolumePrice().compareTo(new BigDecimal(0)) == 0) {
				freight = getFirstVolumePrice();
			} else {
				double contiuneVolumeCount = (volume.subtract(BigDecimal.valueOf(getFirstVolume()))).doubleValue() / (double) getContinueVolume();
				freight = getFirstVolumePrice().add(getContinueVolumePrice().multiply(new BigDecimal(contiuneVolumeCount)));
			}
		}
		return setting.setScale(freight);
	}
	
	/**
	 * 获取排序
	 * 
	 * @return 排序
	 */
	@Min(0)
	@Column(name = "orders")
	public Integer getOrder() {
		return order;
	}

	/**
	 * 设置排序
	 * 
	 * @param order
	 *            排序
	 */
	public void setOrder(Integer order) {
		this.order = order;
	}

}