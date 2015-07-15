/*
 * 
 * 
 * 
 */
package net.shopxx.service.impl;

import java.io.IOException;
import java.math.BigDecimal;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.Set;

import javax.annotation.Resource;
import javax.mail.MessagingException;
import javax.mail.internet.InternetAddress;
import javax.mail.internet.MimeMessage;
import javax.mail.internet.MimeUtility;
import javax.servlet.http.HttpServletRequest;

import net.shopxx.Principal;
import net.shopxx.Setting;
import net.shopxx.dao.AdminDao;
import net.shopxx.dao.MemberDao;
import net.shopxx.entity.AdminMember;
import net.shopxx.entity.Member;
import net.shopxx.entity.Order;
import net.shopxx.entity.OrderItem;
import net.shopxx.entity.ProductNotify;
import net.shopxx.entity.SafeKey;
import net.shopxx.service.MailService;
import net.shopxx.service.TemplateService;
import net.shopxx.util.SettingUtils;
import net.shopxx.util.SpringUtils;

import org.apache.commons.lang3.StringUtils;
import org.apache.log4j.Logger;
import org.springframework.core.task.TaskExecutor;
import org.springframework.mail.javamail.JavaMailSenderImpl;
import org.springframework.mail.javamail.MimeMessageHelper;
import org.springframework.stereotype.Service;
import org.springframework.ui.freemarker.FreeMarkerTemplateUtils;
import org.springframework.util.Assert;
import org.springframework.web.context.request.RequestAttributes;
import org.springframework.web.context.request.RequestContextHolder;
import org.springframework.web.context.request.ServletRequestAttributes;
import org.springframework.web.servlet.view.freemarker.FreeMarkerConfigurer;

import freemarker.template.Configuration;
import freemarker.template.Template;
import freemarker.template.TemplateException;

/**
 * Service - 邮件
 * 
 * 
 * 
 */
@Service("mailServiceImpl")
public class MailServiceImpl implements MailService {

	@Resource(name = "freeMarkerConfigurer")
	private FreeMarkerConfigurer freeMarkerConfigurer;
	@Resource(name = "javaMailSender")
	private JavaMailSenderImpl javaMailSender;
	@Resource(name = "taskExecutor")
	private TaskExecutor taskExecutor;
	@Resource(name = "templateServiceImpl")
	private TemplateService templateService;
    @Resource(name = "adminDaoImpl")
    private AdminDao adminDao;
    @Resource(name = "memberDaoImpl")
    private MemberDao memberDao;
    
    private Logger log = Logger.getLogger(MailServiceImpl.class);
    
    private static final String Gift_Company_Email = "ppggift@chengyee.com,steve.yang@chengyee.com,richard.sun@Nirvana-info.com";
    private static final String Finance_Email = "tong.wu@ppg.com,jake.omick@ppg.com,leo.xu@ppg.com,richard.sun@Nirvana-info.com";

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
	 * 添加邮件发送任务
	 * 
	 * @param mimeMessage
	 *            MimeMessage
	 */
	private void addSendTask(final MimeMessage mimeMessage) {
		try {
			taskExecutor.execute(new Runnable() {
				public void run() {
					javaMailSender.send(mimeMessage);
				}
			});
		} catch (Exception e) {
			e.printStackTrace();
		}
	}

	public void send(String smtpFromMail, String smtpHost, Integer smtpPort, String smtpUsername, String smtpPassword, String toMail, String subject, String templatePath, Map<String, Object> model, boolean async) {
		Assert.hasText(smtpFromMail);
		Assert.hasText(smtpHost);
		Assert.notNull(smtpPort);
		Assert.hasText(smtpUsername);
		Assert.hasText(smtpPassword);
		Assert.hasText(toMail);
		Assert.hasText(subject);
		Assert.hasText(templatePath);
		try {
			Setting setting = SettingUtils.get();
			Configuration configuration = freeMarkerConfigurer.getConfiguration();
			Template template = configuration.getTemplate(templatePath);
			String text = FreeMarkerTemplateUtils.processTemplateIntoString(template, model);
			javaMailSender.setHost(smtpHost);
			javaMailSender.setPort(smtpPort);
			javaMailSender.setUsername(smtpUsername);
			javaMailSender.setPassword(smtpPassword);
			MimeMessage mimeMessage = javaMailSender.createMimeMessage();
			MimeMessageHelper mimeMessageHelper = new MimeMessageHelper(mimeMessage, false, "utf-8");
			mimeMessageHelper.setFrom(MimeUtility.encodeWord(SpringUtils.getMessage("PPG Gift Purchase")) + " <" + smtpFromMail + ">");
			mimeMessageHelper.setSubject(subject);
			if (toMail.indexOf(",") > -1) {
                List<InternetAddress> list = new ArrayList<InternetAddress>();
                String[] median = toMail.split(",");
                for (int i = 0; i < median.length; i++) {
                    list.add(new InternetAddress(median[i]));
                }
			    InternetAddress[] address = (InternetAddress[])list.toArray(new InternetAddress[list.size()]);
	            mimeMessageHelper.setTo(address);
			} else {
	            mimeMessageHelper.setTo(toMail);
			}
			mimeMessageHelper.setText(text, true);
			if (async) {
				addSendTask(mimeMessage);
			} else {
				javaMailSender.send(mimeMessage);
			}
		} catch (TemplateException e) {
			e.printStackTrace();
		} catch (IOException e) {
			e.printStackTrace();
		} catch (MessagingException e) {
			e.printStackTrace();
		}
	}

	public void send(String toMail, String subject, String templatePath, Map<String, Object> model, boolean async) {
		Setting setting = SettingUtils.get();
		send(setting.getSmtpFromMail(), setting.getSmtpHost(), setting.getSmtpPort(), setting.getSmtpUsername(), setting.getSmtpPassword(), toMail, subject, templatePath, model, async);
	}

	public void send(String toMail, String subject, String templatePath, Map<String, Object> model) {
		Setting setting = SettingUtils.get();
		send(setting.getSmtpFromMail(), setting.getSmtpHost(), setting.getSmtpPort(), setting.getSmtpUsername(), setting.getSmtpPassword(), toMail, subject, templatePath, model, true);
	}

	public void send(String toMail, String subject, String templatePath) {
		Setting setting = SettingUtils.get();
		send(setting.getSmtpFromMail(), setting.getSmtpHost(), setting.getSmtpPort(), setting.getSmtpUsername(), setting.getSmtpPassword(), toMail, subject, templatePath, null, true);
	}

	public void sendTestMail(String smtpFromMail, String smtpHost, Integer smtpPort, String smtpUsername, String smtpPassword, String toMail) {
		Setting setting = SettingUtils.get();
		String subject = SpringUtils.getMessage("admin.setting.testMailSubject", SpringUtils.getMessage("PPG Gift Purchase"));
		net.shopxx.Template testMailTemplate = templateService.get("testMail");
		send(smtpFromMail, smtpHost, smtpPort, smtpUsername, smtpPassword, toMail, subject, testMailTemplate.getTemplatePath(), null, false);
	}

	public void sendFindPasswordMail(String toMail, String username, SafeKey safeKey) {
		Setting setting = SettingUtils.get();
		Map<String, Object> model = new HashMap<String, Object>();
		model.put("username", username);
		model.put("safeKey", safeKey);
		String subject = SpringUtils.getMessage("shop.password.mailSubject", SpringUtils.getMessage("PPG Gift Purchase"));
		net.shopxx.Template findPasswordMailTemplate = templateService.get("findPasswordMail");
		send(toMail, subject, findPasswordMailTemplate.getTemplatePath(), model);
	}

	public void sendProductNotifyMail(ProductNotify productNotify) {
		Setting setting = SettingUtils.get();
		Map<String, Object> model = new HashMap<String, Object>();
		model.put("productNotify", productNotify);
		String subject = SpringUtils.getMessage("admin.productNotify.mailSubject", SpringUtils.getMessage("PPG Gift Purchase"));
		net.shopxx.Template productNotifyMailTemplate = templateService.get("productNotifyMail");
		send(productNotify.getEmail(), subject, productNotifyMailTemplate.getTemplatePath(), model);
	}

    public void sendPurchaseOrderMail(Order order) {
        log.info("发送采购邮件开始-------------------");
        RequestAttributes requestAttributes = RequestContextHolder.currentRequestAttributes();
        if (requestAttributes != null) {
            HttpServletRequest request = ((ServletRequestAttributes) requestAttributes).getRequest();
            Principal principal = (Principal) request.getSession().getAttribute(Member.PRINCIPAL_ATTRIBUTE_NAME);
            Long userId = principal.getId();
            Member member = principal != null ? memberDao.find(userId) : null;
            if (member != null) {
                
                Map<String, Object> model = new HashMap<String, Object>();
                model.put("order", order);
                net.shopxx.Template purchaseOrderMailTemplate = templateService.get("purchaseOrderMail");
                Set<AdminMember> adminMembers = member.getAdminMembers();
                if (adminMembers != null) {
                    for (AdminMember adminMember : adminMembers) {  
                    	String approvalEmail = adminMember.getAdmin().getEmail();
                    	if (StringUtils.isNotBlank(approvalEmail)) {
                            // 发审批人
                            log.info("发送审批人开始-------------------");
                            model.put("tips", SpringUtils.getMessage("order.application.approval.tips",member.getEmail()));
                            model.put("foot", SpringUtils.getMessage("order.application.approval.foot"));
                            model.put("approvalUrl", SpringUtils.getMessage("order.application.approval.url"));
                            send(approvalEmail, SpringUtils.getMessage("order.application.approval.subject", member.getEmail()), purchaseOrderMailTemplate.getTemplatePath(), model);
                            log.info("发送审批人结束-------------------");
                        }
                    }
                }
                
                // 发采购人
                log.info("发送采购人开始-------------------");
                model.put("tips", SpringUtils.getMessage("order.application.purchase.tips",member.getEmail()));
                send(member.getEmail(), SpringUtils.getMessage("order.application.purchase.subject",member.getEmail()), purchaseOrderMailTemplate.getTemplatePath(), model);
                log.info("发送采购人结束-------------------");
                
                /*if (StringUtils.isNotBlank(approvalEmail)) {
                    // 发审批人
                    log.info("发送审批人开始-------------------");
                    model.put("tips", SpringUtils.getMessage("order.application.approval.tips",member.getEmail()));
                    model.put("foot", SpringUtils.getMessage("order.application.approval.foot"));
                    model.put("approvalUrl", SpringUtils.getMessage("order.application.approval.url"));
                    send(approvalEmail, SpringUtils.getMessage("order.application.approval.subject", member.getEmail()), purchaseOrderMailTemplate.getTemplatePath(), model);
                    log.info("发送审批人结束-------------------");
                }*/
                
                Setting setting = SettingUtils.get();
                String giftCompanyEmail = Gift_Company_Email;//setting.getGiftCompanyEmail();
                if (StringUtils.isNotBlank(giftCompanyEmail)) {
                    // 发礼品公司
                    log.info("发送礼品公司开始-------------------");
                    model.put("tips", SpringUtils.getMessage("order.application.purchase.tips",member.getEmail()));
                    send(giftCompanyEmail, SpringUtils.getMessage("order.application.purchase.subject",member.getEmail()), purchaseOrderMailTemplate.getTemplatePath(), model);
                    log.info("发送礼品公司开始-------------------");
                }
                
            }
        }
        log.info("发送采购邮件结束-------------------");
    }

    public void sendApproveMail(Order order) {

        log.info("发送审批邮件开始-------------------");
        Map<String, Object> model = new HashMap<String, Object>();
        model.put("order", order);
        net.shopxx.Template purchaseOrderMailTemplate = templateService.get("purchaseOrderMail");
        
        Member member = order.getMember();
        if (member == null) return;
        String status = null;
        String textStatus = null;
        if (Order.OrderStatus.confirmed.equals(order.getOrderStatus())) {
            status = SpringUtils.getMessage("order.orderstatus.confirmed");
            textStatus = SpringUtils.getMessage("order.orderstatus.approved");
        } else if (Order.OrderStatus.cancelled.equals(order.getOrderStatus())) {
            status = SpringUtils.getMessage("order.orderstatus.cancel");
            textStatus = SpringUtils.getMessage("order.orderstatus.cancel");
        }
        
        // 发采购人
        log.info("发送采购人开始-------------------");
        model.put("tips", SpringUtils.getMessage("order.Approved.tips", member.getEmail(), textStatus));
        send(member.getEmail(), SpringUtils.getMessage("order.Approved.subject", member.getEmail(), status), purchaseOrderMailTemplate.getTemplatePath(), model);
        
        //Setting setting = SettingUtils.get();
        String giftCompanyEmail = Gift_Company_Email;//setting.getGiftCompanyEmail();
        // 发礼品公司
        if (StringUtils.isNotBlank(giftCompanyEmail)) {
            log.info("发送礼品公司开始-------------------");
            send(giftCompanyEmail, SpringUtils.getMessage("order.Approved.subject", member.getEmail(), status), purchaseOrderMailTemplate.getTemplatePath(), model);
        }

        // 审批通过发财务或管理人员
        if (Order.OrderStatus.confirmed.equals(order.getOrderStatus())) {
            log.info("发送财务或管理人员开始-------------------");
            String financeEmail = Finance_Email;//setting.getFinanceEmail();
            if (StringUtils.isNotBlank(giftCompanyEmail)) {
                send(financeEmail, SpringUtils.getMessage("order.Approved.subject", member.getEmail(), status), purchaseOrderMailTemplate.getTemplatePath(), model);
            }
        }

        log.info("发送审批邮件结束-------------------");
                
    }
    
    public void sendCombineMail(List<Order> orderList) {
        log.info("发送合并订单邮件开始-------------------");
        for (int i = 0; i < orderList.size(); i++)
		{
        	Order order=orderList.get(i);
        	Map<String, Object> model = new HashMap<String, Object>();
            net.shopxx.Template purchaseOrderMailTemplate = templateService.get("combineOrderMail");
        	model.put("order", order);
        	
        	List<OrderItem> list = order.getOrderItems();
        	BigDecimal totalCostSave=new BigDecimal(0);
        	if (list != null && list.size() > 0) {
        		BigDecimal oldPrice=new BigDecimal(0);
        		BigDecimal nowPrice=new BigDecimal(0);
        		BigDecimal costSave=new BigDecimal(0);
        		for (int j = 0; j < list.size(); j++)
    			{
        			OrderItem orderItem=list.get(j);
        			if(null!=orderItem.getOldPrice()){
        				oldPrice=oldPrice.add(orderItem.getOldPrice().multiply(new BigDecimal(orderItem.getQuantity())));
        			}
        			if(null!=orderItem.getEndPrice()){
        				nowPrice=nowPrice.add(orderItem.getEndPrice().multiply(new BigDecimal(orderItem.getQuantity())));
        			}
    			}
        		costSave=oldPrice.subtract(nowPrice);
        		model.put("oldPrice", oldPrice);
        		model.put("nowPrice", nowPrice);
        		model.put("costSave", costSave);
        		totalCostSave = totalCostSave.add(costSave);
        	}
        	
        	Member member = memberDao.find(order.getMember().getId());
        	model.put("tips", SpringUtils.getMessage("order.combine.subject", order.getSn(), interceptPrice(totalCostSave.toString())));
            send(member.getEmail(), SpringUtils.getMessage("order.combine.subject", order.getSn(), interceptPrice(totalCostSave.toString())), purchaseOrderMailTemplate.getTemplatePath(), model);
            //发送给财务和管理员
            model.put("tips", SpringUtils.getMessage("order.combine.approvers.administrators.subject", order.getSn(), member.getEmail(), interceptPrice(totalCostSave.toString())));
            send(Finance_Email, SpringUtils.getMessage("order.combine.approvers.administrators.subject", order.getSn(), member.getEmail(), interceptPrice(totalCostSave.toString())), purchaseOrderMailTemplate.getTemplatePath(), model);
            //send("41254534@qq.com", SpringUtils.getMessage("order.Approved.subject", member.getEmail()), templateService.get("purchaseOrderMail").getTemplatePath(), model);
		}
        log.info("发送合并订单邮件结束-------------------");
                
    }

}