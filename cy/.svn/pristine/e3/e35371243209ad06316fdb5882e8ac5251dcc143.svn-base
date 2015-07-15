package net.shopxx.entity;

import java.util.Date;

import javax.persistence.Entity;
import javax.persistence.FetchType;
import javax.persistence.JoinColumn;
import javax.persistence.ManyToOne;
import javax.persistence.SequenceGenerator;
import javax.persistence.Table;
import javax.validation.constraints.NotNull;

@Entity
@Table(name = "xx_special_orders")
@SequenceGenerator(name = "sequenceGenerator", sequenceName = "xx_special_orders_sequence")
public class SpecialOrders extends BaseEntity {

	/**
	 * 
	 */
	private static final long serialVersionUID = -4685157233829390568L;
	/**
	 * 会员
	 */
	private Member member;
	/**
	 * 
	 */
	private String name;
	/**
	 * 
	 */
	private String title;
	/**
	 * 
	 */
	private String phone;
	/**
	 * 
	 */
	private String fax;
	/**
	 * 
	 */
	private String email;
	/**
	 * 
	 */
	private Dict contactMeVia;
	/**
	 * 
	 */
	private Dict action;
	/**
	 * 
	 */
	private String eventName;
	/**
	 * 
	 */
	private Dict eventType;
	/**
	 * 
	 */
	private String eventTheme;
	/**
	 * 
	 */
	private String budget;
	/**
	 * 
	 */
	private Date eventDate;
	/**
	 * 
	 */
	private Date deliveryDate;
	/**
	 * 
	 */
	private String itemDescription;
	/**
	 * 
	 */
	private Dict decorationMethod;
	/**
	 * 
	 */
	private String logo;
	/**
	 * 
	 */
	private String colors;
	/**
	 * 
	 */
	private String sizes;
	/**
	 * 
	 */
	private String qty;
	/**
	 * 
	 */
	private Dict giftWrap;
	/**
	 * 
	 */
	private Dict thankYouNote;
	/**
	 * 
	 */
	private String thankYouMessage;
	/**
	 * 
	 */
	private String specialInstructions;
	/**
	 * 
	 */
	private int submitStatus; //0草稿，1已提交
	/**
	 * 
	 */
	private int approveStatus; //0未审批，1通过，2拒绝
	
	@NotNull
	@ManyToOne(fetch = FetchType.LAZY)
	@JoinColumn(nullable = false)
	public Member getMember() {
		return member;
	}

	public void setMember(Member member) {
		this.member = member;
	}
	
	public String getName() {
		return name;
	}

	public void setName(String name) {
		this.name = name;
	}

	public String getTitle() {
		return title;
	}

	public void setTitle(String title) {
		this.title = title;
	}

	public String getPhone() {
		return phone;
	}

	public void setPhone(String phone) {
		this.phone = phone;
	}

	public String getFax() {
		return fax;
	}

	public void setFax(String fax) {
		this.fax = fax;
	}

	public String getEmail() {
		return email;
	}

	public void setEmail(String email) {
		this.email = email;
	}

	@ManyToOne(fetch = FetchType.LAZY)
	@JoinColumn(nullable = false)
	public Dict getContactMeVia() {
		return contactMeVia;
	}

	public void setContactMeVia(Dict contactMeVia) {
		this.contactMeVia = contactMeVia;
	}

	@ManyToOne(fetch = FetchType.LAZY)
	@JoinColumn(nullable = false)
	public Dict getAction() {
		return action;
	}

	public void setAction(Dict action) {
		this.action = action;
	}

	public String getEventName() {
		return eventName;
	}

	public void setEventName(String eventName) {
		this.eventName = eventName;
	}

	@ManyToOne(fetch = FetchType.LAZY)
	@JoinColumn(nullable = false)
	public Dict getEventType() {
		return eventType;
	}

	public void setEventType(Dict eventType) {
		this.eventType = eventType;
	}

	public String getEventTheme() {
		return eventTheme;
	}

	public void setEventTheme(String eventTheme) {
		this.eventTheme = eventTheme;
	}

	public String getBudget() {
		return budget;
	}

	public void setBudget(String budget) {
		this.budget = budget;
	}

	public Date getEventDate() {
		return eventDate;
	}

	public void setEventDate(Date eventDate) {
		this.eventDate = eventDate;
	}

	public Date getDeliveryDate() {
		return deliveryDate;
	}

	public void setDeliveryDate(Date deliveryDate) {
		this.deliveryDate = deliveryDate;
	}

	public String getItemDescription() {
		return itemDescription;
	}

	public void setItemDescription(String itemDescription) {
		this.itemDescription = itemDescription;
	}

	@ManyToOne(fetch = FetchType.LAZY)
	@JoinColumn(nullable = false)
	public Dict getDecorationMethod() {
		return decorationMethod;
	}

	public void setDecorationMethod(Dict decorationMethod) {
		this.decorationMethod = decorationMethod;
	}

	public String getLogo() {
		return logo;
	}

	public void setLogo(String logo) {
		this.logo = logo;
	}

	public String getColors() {
		return colors;
	}

	public void setColors(String colors) {
		this.colors = colors;
	}

	public String getSizes() {
		return sizes;
	}

	public void setSizes(String sizes) {
		this.sizes = sizes;
	}

	public String getQty() {
		return qty;
	}

	public void setQty(String qty) {
		this.qty = qty;
	}

	@ManyToOne(fetch = FetchType.LAZY)
	@JoinColumn(nullable = false)
	public Dict getGiftWrap() {
		return giftWrap;
	}

	public void setGiftWrap(Dict giftWrap) {
		this.giftWrap = giftWrap;
	}

	@ManyToOne(fetch = FetchType.LAZY)
	@JoinColumn(nullable = false)
	public Dict getThankYouNote() {
		return thankYouNote;
	}

	public void setThankYouNote(Dict thankYouNote) {
		this.thankYouNote = thankYouNote;
	}

	public String getThankYouMessage() {
		return thankYouMessage;
	}

	public void setThankYouMessage(String thankYouMessage) {
		this.thankYouMessage = thankYouMessage;
	}

	public String getSpecialInstructions() {
		return specialInstructions;
	}

	public void setSpecialInstructions(String specialInstructions) {
		this.specialInstructions = specialInstructions;
	}

	public int getSubmitStatus() {
		return submitStatus;
	}

	public void setSubmitStatus(int submitStatus) {
		this.submitStatus = submitStatus;
	}

	public int getApproveStatus() {
		return approveStatus;
	}

	public void setApproveStatus(int approveStatus) {
		this.approveStatus = approveStatus;
	}

}
