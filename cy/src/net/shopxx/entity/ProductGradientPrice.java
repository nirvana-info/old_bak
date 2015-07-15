package net.shopxx.entity;

import java.io.Serializable;
import java.math.BigDecimal;
import java.util.Date;

import javax.persistence.Column;
import javax.persistence.Embeddable;
import javax.persistence.Transient;
import javax.validation.constraints.Min;

/**
 * Entity - 商品阶梯定价
 */

@Embeddable
public class ProductGradientPrice implements Serializable {

	private static final long serialVersionUID = 1L;
	
	/** 阶梯价档次名称 */
	private String title;
	
	/** 阶段最小数量*/
	private Integer startQuantity;
	
	/** 阶段最大数量*/
	private Integer endQuantity;
	
	/** 售价 */
	private BigDecimal price;

	/** 排序 */
	private Integer order;
	
	/** 状态 */
	private Integer status;
	
	/** 有效起日 */
	private Date startDate;
	
	/** 有效止日 */
	private Date endDate;
	
	/** 创建日期 */
	private Date createDate;
	
	public String getTitle() {
		return title;
	}

	public void setTitle(String title) {
		this.title = title;
	}
	
	public Integer getStartQuantity() {
		return startQuantity;
	}

	public void setStartQuantity(Integer startQuantity) {
		this.startQuantity = startQuantity;
	}

	public Integer getEndQuantity() {
		if(endQuantity==null){
			endQuantity = 0;
		}
		return endQuantity;
	}

	public void setEndQuantity(Integer endQuantity) {
		this.endQuantity = endQuantity;
	}

	public BigDecimal getPrice() {
		return price;
	}

	public void setPrice(BigDecimal price) {
		this.price = price;
	}

	@Min(0)
	@Column(name = "orders")
	public Integer getOrder() {
		return order;
	}

	public void setOrder(Integer order) {
		this.order = order;
	}

	public Integer getStatus() {
		return status;
	}

	public void setStatus(Integer status) {
		this.status = status;
	}

	public Date getStartDate() {
		return startDate;
	}

	public void setStartDate(Date startDate) {
		this.startDate = startDate;
	}

	public Date getEndDate() {
		return endDate;
	}

	public void setEndDate(Date endDate) {
		this.endDate = endDate;
	}

	public Date getCreateDate() {
		return createDate;
	}

	public void setCreateDate(Date createDate) {
		this.createDate = createDate;
	}
	@Transient
	public String getNumScope() {
		String numScope = this.getStartQuantity()+"";
		if(this.getEndQuantity()==null || this.getEndQuantity()==0){
			numScope = "≥"+this.getStartQuantity();
		}else{
			numScope = this.getStartQuantity()+"~"+this.getEndQuantity();
		}
		return numScope;
	}
	
}
