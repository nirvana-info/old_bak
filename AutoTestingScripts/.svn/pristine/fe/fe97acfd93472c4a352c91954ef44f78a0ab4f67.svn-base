//#*****************************************************************************
//# Purpose: User select order paymentinfo
//# Author:  bobby
//# Create Date: apr 27, 2009
//# Modify History: 
//# 
//#*****************************************************************************

using System;
using System.Collections.Generic;
using System.Text;
using WatiN.Core;
using NUnit.Framework;
using WatiN.Core.Interfaces;
using WatiN.Core.DialogHandlers;
using SalesLeads360.Appshare;

namespace SalesLeads360.Appshare.App01_HomePage
{
    public class OrderPaymentInfo:PublicPara
    {
        public void TestUserOrderPaymentInfo(Browser browser)
        {
            browser.WaitUntilContainsText("Step 4: Enter Payment Information");
            Assert.IsTrue(browser.ContainsText("Step 4: Enter Payment Information"));



            browser.TextField(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_txt_user_firstname")).TypeText("christie");

            browser.TextField(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_txt_user_lastname")).TypeText("Test");

            browser.TextField(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_txt_user_addr")).TypeText("zhongshanbeiroad");

            browser.TextField(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_txt_user_city")).TypeText("shanghai");

            browser.SelectList(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_dl_user_state")).Option(Find.ByValue("AL")).Select();
            browser.TextField(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_txt_user_zip")).TypeText("11111");

            browser.TextField(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_ux_phone")).Value="1111111111";
            browser.TextField(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_ux_phone")).Focus();
            //browser.TextField(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_ux_phone")).DoubleClick();

            browser.TextField(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_txt_user_email")).TypeText("christie.duan@nirvana-info.com");

            browser.TextField(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_txt_order_description")).TypeText("ordertest");
            browser.CheckBox(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_chbAgreement")).Checked = true;
            browser.CheckBox(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_chb_contactinfo")).Checked = true;
            browser.SelectList(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_dl_pay_year")).Option("2011").Select();

            browser.TextField(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_txt_pay_account")).TypeText("4111111111111111");

            browser.TextField(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_txt_pay_cid")).TypeText("111");
            browser.Link(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_BottomBtNext")).Click();

            browser.WaitUntilContainsText("Your Order Is Complete");
            Assert.IsTrue(browser.ContainsText("Your Order Is Complete"));

        }

        public void RegisterUserOrderPaymentInfo(Browser browser)
        {
            browser.WaitUntilContainsText("Step 4: Enter Payment Information");

            browser.TextField(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_txt_user_firstname")).TypeText("christie");

            browser.TextField(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_txt_user_lastname")).TypeText("Test");

            browser.TextField(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_txt_user_addr")).TypeText("zhongshanbeiroad");

            browser.TextField(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_txt_user_city")).TypeText("shanghai");

            browser.SelectList(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_dl_user_state")).Option(Find.ByValue("AL")).Select();
            browser.TextField(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_txt_user_zip")).TypeText("11111");

            browser.TextField(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_ux_phone")).TypeText("1111111111");
            //browser.TextField(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_ux_phone")).DoubleClick();
            browser.TextField(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_ux_phone")).Focus();

            browser.TextField(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_txt_user_email")).TypeText("christie.duan@nirvana-info.com");

            browser.TextField(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_txt_order_description")).TypeText("ordertest"+Date);
            browser.CheckBox(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_chbAgreement")).Checked = true;
            browser.CheckBox(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_chb_contactinfo")).Checked = true;
            browser.SelectList(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_dl_pay_year")).Option("2011").Select();

            browser.TextField(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_txt_pay_account")).TypeText("4111111111111111");

            browser.TextField(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_txt_pay_cid")).TypeText("111");
            browser.Link(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_BottomBtNext")).Click();


            browser.WaitUntilContainsText("Your Order Is Complete");
            Assert.IsTrue(browser.ContainsText("Your Order Is Complete"));

        }
    }
}
