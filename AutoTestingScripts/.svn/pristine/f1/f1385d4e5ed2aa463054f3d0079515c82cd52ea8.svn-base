//#*****************************************************************************
//# Purpose: User orderdiscount cancel
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
    public class canceldiscont
    {

        public void TestUsercanceldiscont(Browser browser,string raid,string raname)
        {
            browser.Link(Find.ByText("平台管理")).Click();
            browser.WaitUntilContainsText("请在左边的菜单选择您要进行的操作。 如有疑问，请点击下面相关链接查看操作流程图或查看交易指南");
            Assert.IsTrue(browser.ContainsText("请在左边的菜单选择您要进行的操作。 如有疑问，请点击下面相关链接查看操作流程图或查看交易指南"));

            browser.Link(Find.ByText("销售折扣管理")).Click();
            browser.WaitUntilContainsText("折扣设置");
            Assert.IsTrue(browser.ContainsText("折扣设置"));
            

            //状态生效
            
            browser.RadioButton(Find.ById(raid)).Checked = true;


            WatiN.Core.DialogHandlers.ConfirmDialogHandler dh4 = new WatiN.Core.DialogHandlers.ConfirmDialogHandler();

            browser.AddDialogHandler(dh4);

            browser.Button(Find.ById("ctl00_ContentPlaceHolder1_btnDelete")).ClickNoWait();
            dh4.WaitUntilExists(15);//
            dh4.OKButton.Click();//
            
            browser.RemoveDialogHandler(dh4);
            Thread.Sleep(1000);
            Assert.IsFalse(browser.ContainsText(raname));
            
        }
    }
}
