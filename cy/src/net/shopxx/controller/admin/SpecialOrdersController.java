package net.shopxx.controller.admin;

import javax.annotation.Resource;

import net.shopxx.Message;
import net.shopxx.Pageable;
import net.shopxx.entity.SpecialOrders;
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
@Controller("adminSpecialOrderController")
@RequestMapping("/admin/special_order")
public class SpecialOrdersController extends BaseController{

	@Resource( name = "specialOrdersServiceImpl")
	private SpecialOrdersService specialOrdersService;
	
	
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
		return "admin/special_order/view";
	}
	
	/**
	 * 列表
	 */
	@RequestMapping(value = "/list", method = RequestMethod.GET)
	public String list(String approveStatus, Pageable pageable, ModelMap model) {
		model.addAttribute("approveStatus", approveStatus);
		model.addAttribute("page", specialOrdersService.findPage(approveStatus, pageable));
		return "/admin/special_order/list";
	}
	
	/**
	 * 通过
	 */
	@RequestMapping(value = "/confirm", method = RequestMethod.POST)
	public String confirm(Long id, RedirectAttributes redirectAttributes) {
		SpecialOrders specialOrders = specialOrdersService.find(id);
		if (specialOrders != null && specialOrders.getId()>0) {
			specialOrdersService.confirm(specialOrders);
			addFlashMessage(redirectAttributes, SUCCESS_MESSAGE);
		} else {
			addFlashMessage(redirectAttributes, Message.warn("admin.common.invalid"));
		}
		return "redirect:list.jhtml";
	}
	
	/**
	 * 拒绝
	 */
	@RequestMapping(value = "/cancel", method = RequestMethod.POST)
	public String cancel(Long id, RedirectAttributes redirectAttributes) {
		SpecialOrders specialOrders = specialOrdersService.find(id);
		if (specialOrders != null && specialOrders.getId()>0) {
			specialOrdersService.cancel(specialOrders);
			addFlashMessage(redirectAttributes, SUCCESS_MESSAGE);
		} else {
			addFlashMessage(redirectAttributes, Message.warn("admin.common.invalid"));
		}
		return "redirect:list.jhtml";
	}
}
