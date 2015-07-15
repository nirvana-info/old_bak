//#*****************************************************************************
//# Purpose: User check discount.
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
    public class checkdiscount
    {
        public void TestUsercheckdiscount(Browser browser, string url, string material, string date1, string number)
        {
            browser.Link(Find.ById("ctl00_linkTrade")).Click();
            browser.WaitUntilContainsText("请在左边的菜单选择您要进行的操作。 如有疑问，请点击下面相关链接查看操作流程图或查看交易指南");
            Assert.IsTrue(browser.ContainsText("请在左边的菜单选择您要进行的操作。 如有疑问，请点击下面相关链接查看操作流程图或查看交易指南"));

            browser.Link(Find.ByText("我要采购")).Click();
            browser.WaitUntilContainsText("请在左边的菜单选择您要进行的操作。 如有疑问，请点击下面相关链接查看操作流程图或查看交易指南");
            Assert.IsTrue(browser.ContainsText("请在左边的菜单选择您要进行的操作。 如有疑问，请点击下面相关链接查看操作流程图或查看交易指南"));
            //采购
            browser.Link(Find.ByUrl(url + "SearchProduct.aspx")).Click();
            browser.WaitUntilContainsText("清空购物车");
            Assert.IsTrue(browser.ContainsText("清空购物车"));
            //查询资源
            browser.TextField(Find.ById("ctl00_ContentPlaceHolder1_txtSteel_Num")).TypeText(material + date1);
            browser.Button(Find.ById("ctl00_ContentPlaceHolder1_btnSearch1")).Click();
            //清空购物车
            WatiN.Core.DialogHandlers.ConfirmDialogHandler dh2 = new WatiN.Core.DialogHandlers.ConfirmDialogHandler();

            browser.AddDialogHandler(dh2);

            browser.Link(Find.ById("ctl00_ContentPlaceHolder1_linkClearCart")).ClickNoWait();
            dh2.WaitUntilExists(15);//
            dh2.OKButton.Click();//
            browser.RemoveDialogHandler(dh2);
            Thread.Sleep(1500);
            //点击该资源并购买

            browser.Image(Find.ByAlt("buy product")).Click();
            browser.TextField(Find.ByClass("cinput")).TypeText(number);
            browser.WaitUntilContainsText(number);
            Assert.IsTrue(browser.ContainsText(number));
            browser.Button(Find.ByClass("addBuyCartBtn")).Click();
            Thread.Sleep(1500);
            browser.WaitUntilContainsText("优惠后总额 900.00元");
            Assert.IsTrue(browser.ContainsText("优惠后总额 900.00元"));


        }
    }
}
