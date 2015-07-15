//#*****************************************************************************
//# Purpose: User verify bargain 
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
    public class verifybargain
    {
        public void TestUserverifylad(Browser browser)
        {
            browser.Link(Find.ById("ctl00_linkTrade")).Click();
            browser.WaitUntilContainsText("请在左边的菜单选择您要进行的操作。 如有疑问，请点击下面相关链接查看操作流程图或查看交易指南");
            Assert.IsTrue(browser.ContainsText("请在左边的菜单选择您要进行的操作。 如有疑问，请点击下面相关链接查看操作流程图或查看交易指南"));

            browser.Link(Find.ByText("我要销售")).Click();
            browser.WaitUntilContainsText("请在左边的菜单选择您要进行的操作");
            Assert.IsTrue(browser.ContainsText("请在左边的菜单选择您要进行的操作"));

            browser.Link(Find.ByText("我的议价信息")).Click();
            browser.WaitUntilContainsText("合同号");
            Assert.IsTrue(browser.ContainsText("合同号"));

            browser.Link(Find.ByText("议价")).Click();

            

            //WatiN.Core.DialogHandlers.ConfirmDialogHandler dh3 = new WatiN.Core.DialogHandlers.ConfirmDialogHandler();

            //browser.AddDialogHandler(dh3);

            browser.Button(Find.ById("ctl00_ContentPlaceHolder1_btnAccept")).ClickNoWait();
            //dh3.WaitUntilExists(15);//
            //dh3.OKButton.Click();//
            //browser.RemoveDialogHandler(dh3);

            //Thread.Sleep(2000);



        }
    }
}
