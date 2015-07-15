package net.shopxx.controller.shop.member;

import javax.annotation.Resource;

import net.shopxx.Message;
import net.shopxx.Pageable;
import net.shopxx.controller.shop.BaseController;
import net.shopxx.entity.Member;
import net.shopxx.entity.SpecialOrders;
import net.shopxx.service.DictService;
import net.shopxx.service.MemberService;
import net.shopxx.service.SpecialOrdersService;

import org.springframework.stereotype.Controller;
import org.springframework.ui.ModelMap;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

/**
 * Controller - Special Order
 * 
 * 
 * 
 */
@Controller("shopMemberSpecialOrderController")
@RequestMapping("/member/special_order")
public class SpecialOrdersController extends BaseController{

	/** 每页记录数 */
	private static final int PAGE_SIZE = 10;

	@Resource(name = "memberServiceImpl")
	private MemberService memberService;
	@Resource( name = "specialOrdersServiceImpl")
	private SpecialOrdersService specialOrdersService;
	@Resource( name = "dictServiceImpl")
	private DictService dictService;
	
	/**
	 * 列表
	 */
	@RequestMapping(value = "/list", method = RequestMethod.GET)
	public String list(Integer pageNumber, ModelMap model) {
		Member member = memberService.getCurrent();
		Pageable pageable = new Pageable(pageNumber, PAGE_SIZE);
		model.addAttribute("page", specialOrdersService.findPage(member, pageable));
		return "shop/member/special_order/list";
	}
	
	/**
	 * 查看
	 */
	@RequestMapping(value = "/view", method = RequestMethod.GET)
	public String view(Long id, ModelMap model) {
		SpecialOrders specialOrders = specialOrdersService.find(id);
		if (specialOrders == null) {
			return ERROR_VIEW;
		}
		model.addAttribute("specialOrders", specialOrders);
		return "shop/member/special_order/view";
	}
	
	/**
	 * 编辑
	 */
	@RequestMapping(value = "/edit", method = RequestMethod.GET)
	public String edit(Long id, ModelMap model) {
		SpecialOrders specialOrders = specialOrdersService.find(id);
		if (specialOrders == null) {
			return ERROR_VIEW;
		}
		model.addAttribute("contactMeVias", dictService.findListByType("Contact me via"));
		model.addAttribute("actions", dictService.findListByType("Action"));
		model.addAttribute("eventTypes", dictService.findListByType("Event Type"));
		model.addAttribute("decorationMethods", dictService.findListByType("Decoration Method"));
		model.addAttribute("giftWraps", dictService.findListByType("Gift-Wrap"));
		model.addAttribute("thankYouNotes", dictService.findListByType("Thank-You Note"));
		model.addAttribute("specialOrders", specialOrders);
		return "shop/member/special_order/edit";
	}
	
	/**
	 * 更新
	 */
	@RequestMapping(value = "/update", method = RequestMethod.POST)
	public String update(SpecialOrders specialOrders, RedirectAttributes redirectAttributes) {
		specialOrders.setMember(memberService.getCurrent());
		if (!isValid(specialOrders)) {
			return ERROR_VIEW;
		}
		SpecialOrders pSpecialOrders = specialOrdersService.find(specialOrders.getId());
		if (pSpecialOrders == null) {
			return ERROR_VIEW;
		}
		if (specialOrders.getEventType()!=null 
				&& (specialOrders.getEventType().getId()==null 
						|| specialOrders.getEventType().getId()==0)) {
			specialOrders.setEventType(null);
		}
		if (specialOrders.getDecorationMethod()!=null 
				&& (specialOrders.getDecorationMethod().getId()==null 
						|| specialOrders.getDecorationMethod().getId()==0)) {
			specialOrders.setDecorationMethod(null);
		}
		specialOrdersService.update(specialOrders, "member");
		addFlashMessage(redirectAttributes, SUCCESS_MESSAGE);
		return "redirect:list.jhtml";
	}
	
	/**
	 * 提交
	 */
	@RequestMapping(value = "/submit", method = RequestMethod.POST)
	public String submit(Long id, RedirectAttributes redirectAttributes) {
		SpecialOrders specialOrders = specialOrdersService.find(id);
		if (specialOrders != null && specialOrders.getId()>0) {
			specialOrdersService.submit(specialOrders);
			addFlashMessage(redirectAttributes, SUCCESS_MESSAGE);
		} else {
			addFlashMessage(redirectAttributes, Message.warn("shop.common.invalid"));
		}
		return "redirect:list.jhtml";
	}
	
	/**
	 * 删除
	 */
	@RequestMapping(value = "/delete", method = RequestMethod.POST)
	public String delete(Long id, RedirectAttributes redirectAttributes) {
		SpecialOrders specialOrders = specialOrdersService.find(id);
		if (specialOrders != null && specialOrders.getId()>0) {
			specialOrdersService.delete(specialOrders);
			addFlashMessage(redirectAttributes, SUCCESS_MESSAGE);
		} else {
			addFlashMessage(redirectAttributes, Message.warn("shop.common.invalid"));
		}
		return "redirect:list.jhtml";
	}
}
