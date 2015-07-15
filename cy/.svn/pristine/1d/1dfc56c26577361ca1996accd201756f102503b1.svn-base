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
import javax.persistence.JoinColumn;
import javax.persistence.ManyToOne;
import javax.persistence.SequenceGenerator;
import javax.persistence.Table;
import javax.persistence.Transient;
import javax.validation.constraints.NotNull;

/**
 * Entity - 定时器
 * 
 * 
 * 
 */
@Entity
@Table(name = "xx_combine_his")
@SequenceGenerator(name = "sequenceGenerator", sequenceName = "xx_combine_his_sequence")
public class CombineHis extends BaseEntity {

	private static final long serialVersionUID = -6565967051825794561L;


	/** 开始日期 */
	private String startDate;

	/** 结束日期 */
	private String endDate;
	
	private BigDecimal oldTotalAmount;
    
    private BigDecimal newTotalAmount;
    
    private Long createBy;
    
    private Long admin;
    
    public Long getAdmin()
	{
		return admin;
	}

	public void setAdmin(Long admin)
	{
		this.admin = admin;
	}

	@Transient
    public BigDecimal getCostSave() {
        return oldTotalAmount.subtract(newTotalAmount);
    }

    @Column(name = "start_date", nullable = false)
    public String getStartDate()
    {
        return startDate;
    }

    public void setStartDate(String startDate)
    {
        this.startDate = startDate;
    }

    @Column(name = "end_date", nullable = false)
    public String getEndDate()
    {
        return endDate;
    }

    public void setEndDate(String endDate)
    {
        this.endDate = endDate;
    }

    @Column(name = "old_total_amount", nullable = false)
    public BigDecimal getOldTotalAmount()
    {
        return oldTotalAmount;
    }

    public void setOldTotalAmount(BigDecimal oldTotalAmount)
    {
        this.oldTotalAmount = oldTotalAmount;
    }

    @Column(name = "new_total_amount", nullable = false)
    public BigDecimal getNewTotalAmount()
    {
        return newTotalAmount;
    }

    public void setNewTotalAmount(BigDecimal newTotalAmount)
    {
        this.newTotalAmount = newTotalAmount;
    }

    @Column(name = "create_by", nullable = false)
    public Long getCreateBy()
    {
        return createBy;
    }

    public void setCreateBy(Long createBy)
    {
        this.createBy = createBy;
    }
    
    /**
	 * 操作用户
	 */
	private String createUser;

	public String getCreateUser()
	{
		return createUser;
	}

	public void setCreateUser(String createUser)
	{
		this.createUser = createUser;
	}
}