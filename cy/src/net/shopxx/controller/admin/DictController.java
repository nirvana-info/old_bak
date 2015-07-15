/*
 * 
 * 
 * 
 */
package net.shopxx.controller.admin;

import javax.annotation.Resource;

import net.shopxx.Message;
import net.shopxx.Pageable;
import net.shopxx.entity.BaseEntity.Save;
import net.shopxx.entity.Dict;
import net.shopxx.service.DictService;

import org.apache.commons.lang.StringUtils;
import org.springframework.stereotype.Controller;
import org.springframework.ui.ModelMap;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.ResponseBody;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

/**
 * Controller - 数据字典
 * 
 * 
 * 
 */
@Controller("adminDictController")
@RequestMapping("/admin/dict")
public class DictController extends BaseController {

	@Resource(name = "dictServiceImpl")
	private DictService dictService;

	/**
	 * 检查类型对应的值是否存在
	 */
	@RequestMapping(value = "/check_value", method = RequestMethod.GET)
	public @ResponseBody
	boolean checkUsername(String type, String value) {
		if (StringUtils.isEmpty(value)) {
			return false;
		}
		if (dictService.valueExists(type, value)) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * 添加
	 */
	@RequestMapping(value = "/add", method = RequestMethod.GET)
	public String add(ModelMap model) {
		return "/admin/dict/add";
	}

	/**
	 * 保存
	 */
	@RequestMapping(value = "/save", method = RequestMethod.POST)
	public String save(Dict dict, RedirectAttributes redirectAttributes) {
		if (!isValid(dict, Save.class)) {
			return ERROR_VIEW;
		}
		if (dictService.valueExists(dict.getType(), dict.getValue())) {
			return ERROR_VIEW;
		}
		dictService.save(dict);
		addFlashMessage(redirectAttributes, SUCCESS_MESSAGE);
		return "redirect:list.jhtml";
	}

	/**
	 * 编辑
	 */
	@RequestMapping(value = "/edit", method = RequestMethod.GET)
	public String edit(Long id, ModelMap model) {
		model.addAttribute("dict", dictService.find(id));
		return "/admin/dict/edit";
	}

	/**
	 * 更新
	 */
	@RequestMapping(value = "/update", method = RequestMethod.POST)
	public String update(Dict dict, RedirectAttributes redirectAttributes) {
		if (!isValid(dict)) {
			return ERROR_VIEW;
		}
		Dict pDict = dictService.find(dict.getId());
		if (pDict == null) {
			return ERROR_VIEW;
		}
		dictService.update(dict);
		addFlashMessage(redirectAttributes, SUCCESS_MESSAGE);
		return "redirect:list.jhtml";
	}

	/**
	 * 列表
	 */
	@RequestMapping(value = "/list", method = RequestMethod.GET)
	public String list(Pageable pageable, ModelMap model) {
		model.addAttribute("page", dictService.findPage(pageable));
		return "/admin/dict/list";
	}

	/**
	 * 删除
	 */
	@RequestMapping(value = "/delete", method = RequestMethod.POST)
	public @ResponseBody
	Message delete(Long[] ids) {
		dictService.delete(ids);
		return SUCCESS_MESSAGE;
	}

}