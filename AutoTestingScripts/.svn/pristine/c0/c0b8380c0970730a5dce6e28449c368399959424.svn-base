//#*****************************************************************************
//# Purpose: User fullpay.
//# Author:  bobby
//# Create Date: apr 13, 2009
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
using zjsteel.appshare;
using System.Threading;

namespace zjsteel.appshare.App01_HomePage
{
    public class fullpay
    {
        public static string orderid;
        public void TestUserfullpay(Browser browser,string pay)
        {
            browser.Link(Find.ByText("合同生效配款")).Click();
            browser.WaitUntilContainsText("合同生效配款");
            Assert.IsTrue(browser.ContainsText("合同生效配款"));
            //截取订单号码
            Thread.Sleep(1500);
            string l1 = browser.Button(Find.ByClass("btnStyle")).GetAttributeValue("onclick");
            string l3 = l1.Trim().Substring(19, 10);
            orderid = l3;
            browser.Button(Find.ByClass("btnStyle")).Click();
            browser.WaitUntilContainsText("双击配款行即可完成或取消配款金额选择");
            Assert.IsTrue(browser.ContainsText("双击配款行即可完成或取消配款金额选择"));

            
            browser.TextField(Find.ById("txtPay_"+pay)).DoubleClick();
            browser.Button(Find.ById("ctl00_ContentPlaceHolder1_btnallocation")).Click();

            browser.WaitUntilContainsText("按钮完成本次配款，或点击");
            Assert.IsTrue(browser.ContainsText("按钮完成本次配款，或点击"));
            browser.Button(Find.ById("ctl00_ContentPlaceHolder1_btncomplete")).Click();
            
        }
    }
}
