package net.shopxx.util;

import java.util.regex.Matcher;
import java.util.regex.Pattern;
/**
 * 处理html类
 * @author jackie.liu
 * @version 2014-12-18
 */
public class HTMLSpirit {    
	private static final String regEx_script = "<script[^>]*?>[\\s\\S]*?<\\/script>"; // 定义script的正则表达式
	private static final String regEx_style = "<style[^>]*?>[\\s\\S]*?<\\/style>"; // 定义style的正则表达式
	private static final String regEx_html = "<[^>]+>"; // 定义HTML标签的正则表达式

	public static String delHTMLTag(String htmlStr) {
		Pattern p_script = Pattern.compile(regEx_script,
				Pattern.CASE_INSENSITIVE);
		Matcher m_script = p_script.matcher(htmlStr);
		htmlStr = m_script.replaceAll(""); // 过滤script标签
		Pattern p_style = Pattern
				.compile(regEx_style, Pattern.CASE_INSENSITIVE);
		Matcher m_style = p_style.matcher(htmlStr);
		htmlStr = m_style.replaceAll(""); // 过滤style标签
		Pattern p_html = Pattern.compile(regEx_html, Pattern.CASE_INSENSITIVE);
		Matcher m_html = p_html.matcher(htmlStr);
		htmlStr = m_html.replaceAll(""); // 过滤html标签
		Pattern pattern = Pattern.compile("[\\n]");
	    Matcher re = pattern.matcher(htmlStr);
	    htmlStr = re.replaceAll("");
		return htmlStr.trim(); // 返回文本字符串
	}
	
	/**      
	 * 
	 * @Title : filterNumber      * 
	 * @Type : FilterStr      * 
	 * @date : 2014年3月12日 下午7:23:03      * 
	 * @Description : 过滤出数字      * 
	 * @param str      * 
	 * @return      
	 */
	public static String filterNumber(String number) {
		number = number.replaceAll("[^(0-9)]", "");
		return number;
	}

	/**      
	 * *       * 
	 * @Title : filterAlphabet      * 
	 * @Type : FilterStr      * 
	 * @date : 2014年3月12日 下午7:28:54      * 
	 * @Description : 过滤出字母      * 
	 * @param alph      * 
	 * @return      *
	 */
	public static String filterAlphabet(String alph) {
		alph = alph.replaceAll("[^(A-Za-z)]", "");
		return alph;
	}

	/**      
	 * *       * 
	 * @Title : filterChinese      * 
	 * @Type : FilterStr      * 
	 * @date : 2014年3月12日 下午9:12:37      * 
	 * @Description : 过滤出中文      * 
	 * @param chin      * 
	 * @return      *
	 */
	public static String filterChinese(String chin) {
		chin = chin.replaceAll("[^(\\u4e00-\\u9fa5)]", "");
		return chin;
	}

	/**      
	 * *       * 
	 * @Title : filter      * 
	 * @Type : FilterStr      * 
	 * @date : 2014年3月12日 下午9:17:22      * 
	 * @Description : 过滤出字母、数字和中文      * 
	 * @param character      * 
	 * @return      *
	 */
	public static String filter(String character) {
		character = character.replaceAll("[^(a-zA-Z0-9\\u4e00-\\u9fa5)]", "");
		return character;
	}

	/**      
	 * * 
	 * @Title : main      * 
	 * @Type : FilterStr      * 
	 * @date : 2014年3月12日 下午7:18:22      * 
	 * @Description :       * 
	 * @param args      *
	 */
	public static void main(String[] args) {
		/**          * 声明字符串you          */
		String you = "^&^&^you123$%$%你好";
		/**          * 调用过滤出数字的方法          */
		you = filterNumber(you);
		/**          * 打印结果          */
		System.out.println("过滤出数字：" + you);
		/**          * 声明字符串hai          */
		String hai = "￥%……4556ahihdjsadhj$%$%你好吗wewewe";
		/**          * 调用过滤出字母的方法          */
		hai = filterAlphabet(hai);
		/**          * 打印结果          */
		System.out.println("过滤出字母：" + hai);
		/**          * 声明字符串dong          */
		String dong = "$%$%$张三34584yuojk李四@#￥#%%￥……%&";
		/**          * 调用过滤出中文的方法          */
		dong = filterChinese(dong);
		/**          * 打印结果          */
		System.out.println("过滤出中文：" + dong);
		/**          * 声明字符串str          */
		String str = "$%$%$张三34584yuojk李四@#￥#%%￥……%&";
		/**          * 调用过滤出字母、数字和中文的方法          */
		str = filter(str);
		/**          * 打印结果          */
		System.out.println("过滤出字母、数字和中文：" + str);
	}   
}