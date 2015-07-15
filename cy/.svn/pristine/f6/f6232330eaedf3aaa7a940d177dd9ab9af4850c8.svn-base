package net.shopxx.controller.admin;

import java.util.ArrayList;
import java.util.HashSet;
import java.util.List;

import javax.annotation.Resource;

import net.shopxx.Page;
import net.shopxx.Pageable;
import net.shopxx.entity.Admin;
import net.shopxx.entity.AdminMember;
import net.shopxx.entity.Member;
import net.shopxx.entity.Role;
import net.shopxx.service.AdminService;
import net.shopxx.service.MemberService;
import net.shopxx.service.RoleService;

import org.apache.commons.codec.digest.DigestUtils;
import org.apache.commons.lang.StringUtils;
import org.springframework.stereotype.Controller;
import org.springframework.ui.ModelMap;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

/**
 * Controller - 管理员与会员关系维护（仅为订单管理员角色的管理员）
 * 
 * 
 * 
 */
@Controller("adminAdminMemberController")
@RequestMapping("/admin/admin_member")
public class AdminMemberController extends BaseController{

	@Resource(name = "adminServiceImpl")
	private AdminService adminService;
	@Resource(name = "roleServiceImpl")
	private RoleService roleService;
	@Resource(name = "memberServiceImpl")
	private MemberService memberService;
	
	/**
	 * 列表
	 */
	@RequestMapping(value = "/list", method = RequestMethod.GET)
	public String list(Pageable pageable, ModelMap model) {
		pageable.setPageSize(9999);
		Page<Admin> page = adminService.findPage(pageable);
		List<Admin> newList = new ArrayList<Admin>();
		for (Admin admin : page.getContent()) {
			if (admin.getRoles().size()>0) {
				for (Role role : admin.getRoles()) {
					if(role.getId()==2){
						newList.add(admin);
					}
				}
			}
		}
		page = new Page<Admin>(newList, newList.size(), pageable);
		model.addAttribute("page", page);
		return "/admin/admin_member/list";
	}
	
	/**
	 * 编辑
	 */
	@RequestMapping(value = "/edit", method = RequestMethod.GET)
	public String edit(Long id, ModelMap model) {
		Admin admin = adminService.find(id);
		model.addAttribute("roles", roleService.findAll());
		List<Member> members = memberService.findList(admin.getId());
		List<Member> newMembers = new ArrayList<Member>();
		if (admin!=null && admin.getAdminMembers().size()>0) {
			for (AdminMember bean : admin.getAdminMembers()) {
				newMembers.add(bean.getMember());
			}
			for (Member member : members) {
				if (!newMembers.contains(member)) {
					newMembers.add(member);
				}
			}
		}else {
			newMembers = members;
		}
		model.addAttribute("members", newMembers);
		model.addAttribute("admin", admin);
		return "/admin/admin_member/edit";
	}
	
	/**
	 * 更新
	 */
	@RequestMapping(value = "/update", method = RequestMethod.POST)
	public String update(Admin admin, Long[] roleIds, Long[] memberIds, RedirectAttributes redirectAttributes) {
		admin.setRoles(new HashSet<Role>(roleService.findList(roleIds)));
		if (!isValid(admin)) {
			return ERROR_VIEW;
		}
		Admin pAdmin = adminService.find(admin.getId());
		if (pAdmin == null) {
			return ERROR_VIEW;
		}
		//封装会员维护信息
		List<AdminMember> adminMembers = new ArrayList<AdminMember>();
		if(memberIds!=null){
			for (Long memberId : memberIds) {
				AdminMember bean = new AdminMember();
				bean.setAdmin(admin);
				Member member = new Member();
				member.setId(memberId);
				bean.setMember(member);
				adminMembers.add(bean);
			}
		}
		admin.setAdminMembers(new HashSet<AdminMember>(adminMembers));
		if (StringUtils.isNotEmpty(admin.getPassword())) {
			admin.setPassword(DigestUtils.md5Hex(admin.getPassword()));
		} else {
			admin.setPassword(pAdmin.getPassword());
		}
		if (pAdmin.getIsLocked() && !admin.getIsLocked()) {
			admin.setLoginFailureCount(0);
			admin.setLockedDate(null);
		} else {
			admin.setIsLocked(pAdmin.getIsLocked());
			admin.setLoginFailureCount(pAdmin.getLoginFailureCount());
			admin.setLockedDate(pAdmin.getLockedDate());
		}
		adminService.update(admin, "username", "loginDate", "loginIp", "orders");
		addFlashMessage(redirectAttributes, SUCCESS_MESSAGE);
		return "redirect:list.jhtml";
	}
}
