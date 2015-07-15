//#*****************************************************************************
//# Purpose: User specia
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
    public class specialtylists
    {
        public void TestUserspecialtylists(Browser browser)
        {
            browser.WaitUntilContainsText("Please complete the short form below and a Data Specialist will follow up with you");
            Assert.IsTrue(browser.ContainsText("Please complete the short form below and a Data Specialist will follow up with you"));




            browser.TextField(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_ux_fir_name")).TypeText("bobby");

            browser.TextField(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_ux_last_name")).TypeText("wang");

            //browser.TextField(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_txt_user_addr")).TypeText("zhongshanbeiroad");

            //browser.TextField(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_txt_user_city")).TypeText("shanghai");

            //browser.SelectList(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_dl_user_state")).Option(Find.ByValue("AL")).Select();
            //browser.TextField(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_txt_user_zip")).TypeText("11111");

            browser.TextField(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_ux_phone")).TypeText("1111111111");
            browser.TextField(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_ux_phone")).Focus();

            browser.TextField(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_ux_email")).TypeText("bobby.wang@nirvana-info.com");
            browser.SelectList(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_uxHowMany")).Option(Find.ByValue("1,001 - 5,000")).Select();
            browser.SelectList(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_uxHowSoon")).Option(Find.ByValue("Immediately")).Select();
            browser.SelectList(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_uxInterest")).Option(Find.ByValue("Ailments")).Select();
            browser.TextField(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_uxTarget")).TypeText("test");
            browser.Image(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_ImageButton1")).Click();


            browser.WaitUntilContainsText("Thank you! We have received your request and we will follow up with you within the next business day");
            Assert.IsTrue(browser.ContainsText("Thank you! We have received your request and we will follow up with you within the next business day"));

        }
    }
}
