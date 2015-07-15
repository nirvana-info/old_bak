//#*****************************************************************************
//# Purpose: User halfpay.
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
    public class halfpay
    {
        
        public void TestUserhalfpay(Browser browser, string pay)
        {
            browser.Link(Find.ByText("定金提货配款")).Click();
            browser.WaitUntilContainsText("定金提货配款");
            Assert.IsTrue(browser.ContainsText("定金提货配款"));
            //截取订单号码
            Thread.Sleep(1000);
            
            browser.Button(Find.ByClass("btnStyle")).Click();
            browser.WaitUntilContainsText("双击配款行即可完成或取消配款金额选择");
            Assert.IsTrue(browser.ContainsText("双击配款行即可完成或取消配款金额选择"));


            browser.TextField(Find.ById("txtPay_" + pay)).DoubleClick();
            browser.Button(Find.ById("ctl00_ContentPlaceHolder1_btnallocation")).Click();

            browser.WaitUntilContainsText("按钮完成本次配款，或点击");
            Assert.IsTrue(browser.ContainsText("按钮完成本次配款，或点击"));
            browser.Button(Find.ById("ctl00_ContentPlaceHolder1_btncomplete")).Click();

        }
    }
}
