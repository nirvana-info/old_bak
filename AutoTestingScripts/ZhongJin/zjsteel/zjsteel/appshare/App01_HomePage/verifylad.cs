//#*****************************************************************************
//# Purpose: User verify ladbill ID.
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
    public class verifylad
    {
        
        public void TestUserverifylad(Browser browser,string ladid,string ladpw)
        {
            browser.Link(Find.ById("ctl00_linkTrade")).Click();
            browser.WaitUntilContainsText("请在左边的菜单选择您要进行的操作。 如有疑问，请点击下面相关链接查看操作流程图或查看交易指南");
            Assert.IsTrue(browser.ContainsText("请在左边的菜单选择您要进行的操作。 如有疑问，请点击下面相关链接查看操作流程图或查看交易指南"));

            browser.Link(Find.ByText("我要销售")).Click();
            browser.WaitUntilContainsText("请在左边的菜单选择您要进行的操作");
            Assert.IsTrue(browser.ContainsText("请在左边的菜单选择您要进行的操作"));

            browser.Link(Find.ByText("提货验证")).Click();
            browser.WaitUntilContainsText("请正确输入您的提单号和密钥");
            Assert.IsTrue(browser.ContainsText("请正确输入您的提单号和密钥"));

            browser.TextField(Find.ById("ctl00_ContentPlaceHolder1_txtdDeliverycode")).TypeText(ladid);
            browser.TextField(Find.ById("ctl00_ContentPlaceHolder1_txtPassWord")).TypeText(ladpw);

            
            browser.Button(Find.ById("ctl00_ContentPlaceHolder1_Button1")).Click();
            //确认订单
            WatiN.Core.DialogHandlers.ConfirmDialogHandler dh = new WatiN.Core.DialogHandlers.ConfirmDialogHandler();

            browser.AddDialogHandler(dh);

            browser.Button(Find.ById("ctl00_ContentPlaceHolder1_btnConfirm")).ClickNoWait();

            //dh.WaitUntilExists(1);//
            //dh.OKButton.Click();//
            browser.RemoveDialogHandler(dh);
            
          
            
        }

    }
}
