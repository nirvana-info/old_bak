package net.shopxx.entity;

import javax.persistence.Entity;
import javax.persistence.SequenceGenerator;
import javax.persistence.Table;

@Entity
@Table(name = "xx_dict")
@SequenceGenerator(name = "sequenceGenerator", sequenceName = "xx_dict_sequence")
public class Dict extends BaseEntity {

	/**
	 * 
	 */
	private static final long serialVersionUID = 347000876832716067L;

	/**
	 * 字典标签
	 */
	private String label;
	/**
	 * 字典值
	 */
	private String value;
	/**
	 * 字典类型
	 */
	private String type;
	/**
	 * 字典描述
	 */
	private String description;
	/**
	 * 字典排序号
	 */
	private int sort;
	
	public Dict(){
		super();
		this.sort = 10;
	}

	public String getLabel() {
		return label;
	}

	public void setLabel(String label) {
		this.label = label;
	}

	public String getValue() {
		return value;
	}

	public void setValue(String value) {
		this.value = value;
	}

	public String getType() {
		return type;
	}

	public void setType(String type) {
		this.type = type;
	}

	public String getDescription() {
		return description;
	}

	public void setDescription(String description) {
		this.description = description;
	}

	public int getSort() {
		return sort;
	}

	public void setSort(int sort) {
		this.sort = sort;
	}

}
