package net.shopxx.util;

/**
 * html convert
 * @author jackie.liu
 * @version 2014-12-18
 */
public class ConvertToHtml {

	public static String convertor(String content){
		return content.replaceAll("&lt;", "<").replaceAll("&gt;", ">")
				.replaceAll("&quot;", "\"");
	}
}
