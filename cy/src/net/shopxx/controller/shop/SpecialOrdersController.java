package net.shopxx.controller.shop;

import javax.annotation.Resource;

import net.shopxx.entity.BaseEntity.Save;
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
@Controller("shopSpecialOrderController")
@RequestMapping("/special_order")
public class SpecialOrdersController extends BaseController{

	@Resource(name = "memberServiceImpl")
	private MemberService memberService;
	@Resource( name = "specialOrdersServiceImpl")
	private SpecialOrdersService specialOrdersService;
	@Resource( name = "dictServiceImpl")
	private DictService dictService;
	
	/**
	 * 添加
	 */
	@RequestMapping(value = "/add", method = RequestMethod.GET)
	public String add(ModelMap model) {
		model.addAttribute("contactMeVias", dictService.findListByType("Contact me via"));
		model.addAttribute("actions", dictService.findListByType("Action"));
		model.addAttribute("eventTypes", dictService.findListByType("Event Type"));
		model.addAttribute("decorationMethods", dictService.findListByType("Decoration Method"));
		model.addAttribute("giftWraps", dictService.findListByType("Gift-Wrap"));
		model.addAttribute("thankYouNotes", dictService.findListByType("Thank-You Note"));
		return "/shop/special_order/add";
	}
	
	/**
	 * 保存
	 */
	@RequestMapping(value = "/save", method = RequestMethod.POST)
	public String save(SpecialOrders specialOrders, RedirectAttributes redirectAttributes) {
		Member member = memberService.getCurrent();
		specialOrders.setMember(member);
		if (!isValid(specialOrders, Save.class)) {
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
		specialOrdersService.save(specialOrders);
		addFlashMessage(redirectAttributes, SUCCESS_MESSAGE);
		return "redirect:add.jhtml";
	}
}
