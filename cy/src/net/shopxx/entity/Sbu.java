package net.shopxx.entity;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.SequenceGenerator;
import javax.persistence.Table;

import org.hibernate.validator.constraints.Length;
import org.hibernate.validator.constraints.NotEmpty;

/**
 * Entity - 公司机构、单位
 * 
 * 
 * 
 */
@Entity
@Table(name = "xx_sbu")
@SequenceGenerator(name = "sequenceGenerator", sequenceName = "xx_sbu_sequence")
public class Sbu extends BaseEntity {

	/**
	 * 
	 */
	private static final long serialVersionUID = -2815844594402282840L;
	
	/** 名称 */
	private String name;
	
	/**
	 * 获取名称
	 * 
	 * @return 名称
	 */
	@NotEmpty
	@Length(max = 100)
	@Column(nullable = false, length = 100)
	public String getName() {
		return name;
	}

	/**
	 * 设置名称
	 * 
	 * @param name
	 *            名称
	 */
	public void setName(String name) {
		this.name = name;
	}
}
