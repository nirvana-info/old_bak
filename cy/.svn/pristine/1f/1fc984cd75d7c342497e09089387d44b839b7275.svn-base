package net.shopxx.entity;

import javax.persistence.Entity;
import javax.persistence.FetchType;
import javax.persistence.JoinColumn;
import javax.persistence.ManyToOne;
import javax.persistence.SequenceGenerator;
import javax.persistence.Table;
import javax.validation.constraints.NotNull;

@Entity
@Table(name = "xx_admin_member")
@SequenceGenerator(name = "sequenceGenerator", sequenceName = "xx_admin_member_sequence")
public class AdminMember extends BaseEntity{

	/**
	 * 
	 */
	private static final long serialVersionUID = 4218697752624713846L;
	
	/**
	 * 管理员
	 */
	private Admin admin;
	/**
	 * 会员
	 */
	private Member member;

	@NotNull
	@ManyToOne(fetch = FetchType.LAZY)
	@JoinColumn(nullable = false)
	public Admin getAdmin() {
		return admin;
	}

	public void setAdmin(Admin admin) {
		this.admin = admin;
	}

	@NotNull
	@ManyToOne(fetch = FetchType.LAZY)
	@JoinColumn(nullable = false)
	public Member getMember() {
		return member;
	}

	public void setMember(Member member) {
		this.member = member;
	}

}
