/*
 * 
 * 
 * 
 */
package net.shopxx.entity;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.SequenceGenerator;
import javax.persistence.Table;

/**
 * Entity - 定时器
 * 
 * 
 * 
 */
@Entity
@Table(name = "xx_job")
@SequenceGenerator(name = "sequenceGenerator", sequenceName = "xx_job_sequence")
public class Job extends BaseEntity {

	private static final long serialVersionUID = -6565967051825794561L;


	/** 模块名称 */
	private String module;

	/** 触发日 */
	private Integer triggeringDate;

	/**
	 * 获取模块名称
	 * 
	 * @return 模块名称
	 */
	@Column(name = "module", nullable = false)
	public String getModule() {
		return module;
	}

	/**
	 * 设置模块名称
	 * 
	 * @param key
	 *            模块名称
	 */
	public void setModule(String module) {
		this.module = module;
	}


    /**
     * 获取模块名称
     * 
     * @return 模块名称
     */
    @Column(name = "triggering_date", nullable = false)
    public Integer getTriggeringDate() {
        return triggeringDate;
    }

    /**
     * 设置触发日
     * 
     * @param triggeringDate
     *            触发日
     */
    public void setTriggeringDate(Integer triggeringDate) {
        this.triggeringDate = triggeringDate;
    }
    
    
}