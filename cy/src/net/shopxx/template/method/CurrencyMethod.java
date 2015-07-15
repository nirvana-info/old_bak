/*
 * 
 * 
 * 
 */
package net.shopxx.template.method;

import java.math.BigDecimal;
import java.util.List;

import net.shopxx.Setting;
import net.shopxx.util.SettingUtils;

import org.apache.commons.lang.StringUtils;
import org.springframework.stereotype.Component;

import freemarker.template.SimpleScalar;
import freemarker.template.TemplateMethodModel;
import freemarker.template.TemplateModelException;

/**
 * 模板方法 - 货币格式化
 * 
 * 
 * 
 */
@Component("currencyMethod")
public class CurrencyMethod implements TemplateMethodModel {

	@SuppressWarnings("rawtypes")
	public Object exec(List arguments) throws TemplateModelException {
		if (arguments != null && !arguments.isEmpty() && arguments.get(0) != null && StringUtils.isNotEmpty(arguments.get(0).toString())) {
			boolean showSign = false;
			boolean showUnit = false;
			if (arguments.size() == 2) {
				if (arguments.get(1) != null) {
					showSign = Boolean.valueOf(arguments.get(1).toString());
				}
			} else if (arguments.size() > 2) {
				if (arguments.get(1) != null) {
					showSign = Boolean.valueOf(arguments.get(1).toString());
				}
				if (arguments.get(2) != null) {
					showUnit = Boolean.valueOf(arguments.get(2).toString());
				}
			}
			Setting setting = SettingUtils.get();
			BigDecimal amount = new BigDecimal(arguments.get(0).toString());
			String price = setting.setScale(amount).toString();
			//千分位截取
			price = interceptPrice(price);
			if (showSign) {
				price = setting.getCurrencySign() + price;
			}
			if (showUnit) {
				price += setting.getCurrencyUnit();
			}
			return new SimpleScalar(price);
		}
		return null;
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

}