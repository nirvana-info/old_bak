/*
 * 
 * 
 * 
 */
package net.shopxx.controller.shop;

import java.math.BigDecimal;
import java.util.Date;
import java.util.Set;

import javax.annotation.Resource;
import javax.validation.ConstraintViolation;
import javax.validation.Validator;

import net.shopxx.DateEditor;
import net.shopxx.HtmlCleanEditor;
import net.shopxx.Message;
import net.shopxx.Setting;
import net.shopxx.template.directive.FlashMessageDirective;
import net.shopxx.util.SettingUtils;
import net.shopxx.util.SpringUtils;

import org.springframework.web.bind.WebDataBinder;
import org.springframework.web.bind.annotation.InitBinder;
import org.springframework.web.context.request.RequestAttributes;
import org.springframework.web.context.request.RequestContextHolder;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

/**
 * Controller - 基类
 * 
 * 
 * 
 */
public class BaseController {

	/** 错误视图 */
	protected static final String ERROR_VIEW = "/shop/common/error";

	/** 错误消息 */
	protected static final Message ERROR_MESSAGE = Message.error("shop.message.error");

	/** 成功消息 */
	protected static final Message SUCCESS_MESSAGE = Message.success("shop.message.success");

	/** "验证结果"参数名称 */
	private static final String CONSTRAINT_VIOLATIONS_ATTRIBUTE_NAME = "constraintViolations";

	@Resource(name = "validator")
	private Validator validator;

	/**
	 * 数据绑定
	 * 
	 * @param binder
	 *            WebDataBinder
	 */
	@InitBinder
	protected void initBinder(WebDataBinder binder) {
		binder.registerCustomEditor(String.class, new HtmlCleanEditor(true, true));
		binder.registerCustomEditor(Date.class, new DateEditor(true));
	}

	/**
	 * 数据验证
	 * 
	 * @param target
	 *            验证对象
	 * @param groups
	 *            验证组
	 * @return 验证结果
	 */
	protected boolean isValid(Object target, Class<?>... groups) {
		Set<ConstraintViolation<Object>> constraintViolations = validator.validate(target, groups);
		if (constraintViolations.isEmpty()) {
			return true;
		} else {
			RequestAttributes requestAttributes = RequestContextHolder.currentRequestAttributes();
			requestAttributes.setAttribute(CONSTRAINT_VIOLATIONS_ATTRIBUTE_NAME, constraintViolations, RequestAttributes.SCOPE_REQUEST);
			return false;
		}
	}

	/**
	 * 数据验证
	 * 
	 * @param type
	 *            类型
	 * @param property
	 *            属性
	 * @param value
	 *            值
	 * @param groups
	 *            验证组
	 * @return 验证结果
	 */
	protected boolean isValid(Class<?> type, String property, Object value, Class<?>... groups) {
		Set<?> constraintViolations = validator.validateValue(type, property, value, groups);
		if (constraintViolations.isEmpty()) {
			return true;
		} else {
			RequestAttributes requestAttributes = RequestContextHolder.currentRequestAttributes();
			requestAttributes.setAttribute(CONSTRAINT_VIOLATIONS_ATTRIBUTE_NAME, constraintViolations, RequestAttributes.SCOPE_REQUEST);
			return false;
		}
	}

	/**
	 * 货币格式化
	 * 
	 * @param amount
	 *            金额
	 * @param showSign
	 *            显示标志
	 * @param showUnit
	 *            显示单位
	 * @return 货币格式化
	 */
	protected String currency(BigDecimal amount, boolean showSign, boolean showUnit) {
		Setting setting = SettingUtils.get();
		String price = setting.setScale(amount).toString();
		//千分位截取
		price = interceptPrice(price);
		if (showSign) {
			price = setting.getCurrencySign() + price;
		}
		if (showUnit) {
			price += setting.getCurrencyUnit();
		}
		return price;
	}
	
	/**
	 * 千分位截取
	 * @param price
	 * @return
	 */
	private String interceptPrice(String price) {
		String price1 = price.split("\\.")[0];//整数部分
		String price2 = price.split("\\.")[1];//小数部分
		String endPrice = "";//最终结果
		int len = price1.length();//整数部分长度
		String ys = len%3+"";//整数部分对3取余的长度
		if(!ys.equals("0")){
			endPrice = ","+price1.substring(0,Integer.valueOf(ys));
		}
		price1 = price1.substring(Integer.valueOf(ys));//此部分正好被3整除
		for(int i=0;i<len/3;i++){
			endPrice += ","+price1.substring(i*3,3*(i+1));
		}
		endPrice = endPrice+"."+price2;
		endPrice = endPrice.substring(1);
		return endPrice;
	}

	/**
	 * 获取国际化消息
	 * 
	 * @param code
	 *            代码
	 * @param args
	 *            参数
	 * @return 国际化消息
	 */
	protected String message(String code, Object... args) {
		return SpringUtils.getMessage(code, args);
	}

	/**
	 * 添加瞬时消息
	 * 
	 * @param redirectAttributes
	 *            RedirectAttributes
	 * @param message
	 *            消息
	 */
	protected void addFlashMessage(RedirectAttributes redirectAttributes, Message message) {
		if (redirectAttributes != null && message != null) {
			redirectAttributes.addFlashAttribute(FlashMessageDirective.FLASH_MESSAGE_ATTRIBUTE_NAME, message);
		}
	}

}