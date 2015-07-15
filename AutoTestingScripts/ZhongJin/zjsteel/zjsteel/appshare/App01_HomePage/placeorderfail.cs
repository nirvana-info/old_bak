﻿//#*****************************************************************************
//# Purpose: User placeorder.fail
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
    public class placeorderfail
    {
        
        public void TestUserplaceorderfail(Browser browser, string url, string material, string date1, string number, string ordertype, string button)
        {
            //#*****************************************************************************
            //# Purpose: define User placeorder  fail function.
            //# Author:  bobby
            //# Last Modify: apr 13, 2009
            //#*****************************************************************************

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
            //点击pop出来的确认对话框
            WatiN.Core.DialogHandlers.ConfirmDialogHandler dh = new WatiN.Core.DialogHandlers.ConfirmDialogHandler();

            browser.AddDialogHandler(dh);

            browser.Link(Find.ById("ctl00_ContentPlaceHolder1_linkBuildOrders")).ClickNoWait();
            dh.WaitUntilExists(15);//
            dh.OKButton.Click();//
            browser.RemoveDialogHandler(dh);

            //自动分单
            browser.WaitUntilContainsText("系统自动分单");
            Assert.IsTrue(browser.ContainsText("系统自动分单"));

            browser.SelectList(Find.ById("ctl00_ContentPlaceHolder1_dlPreviewList_ctl00_cmbPurcharseordertype")).Option(Find.ByText(ordertype)).Select();

            //点击pop出来的确认对话框
            WatiN.Core.DialogHandlers.ConfirmDialogHandler dh1 = new WatiN.Core.DialogHandlers.ConfirmDialogHandler();

            browser.AddDialogHandler(dh1);

            browser.Button(Find.ById("ctl00_ContentPlaceHolder1_btnBuld")).ClickNoWait();
            dh1.WaitUntilExists(3);//
            dh1.OKButton.Click();//
            browser.RemoveDialogHandler(dh1);

            //意向订单
            browser.WaitUntilContainsText("选择需要的订单，生成意向订单");
            Assert.IsTrue(browser.ContainsText("选择需要的订单，生成意向订单"));
            browser.RadioButton(Find.ByName("radionSelect")).Checked = true;
            string orderid2 = browser.Table(Find.ById("ctl00_ContentPlaceHolder1_GridView1")).TableRow(Find.ByClass("RowBg")).TableCells[1].Text;

            orderid2 = orderid2.Trim().Substring(0, 10);

            //意向订单-->订单生效
            //这个要参数化
            browser.Button(Find.ById(button)).Click();

            //确定

            //提货功能暂时只能自提，选择功能先关闭
            //ie.Frame(Find.ById("wheatmsg_ifrm")).SelectList(Find.ById("selTransport")).Option(Find.ByValue("2")).Select();

            WatiN.Core.DialogHandlers.ConfirmDialogHandler dh3 = new WatiN.Core.DialogHandlers.ConfirmDialogHandler();

            browser.AddDialogHandler(dh3);

            browser.Frame(Find.ById("wheatmsg_ifrm")).Button(Find.ById("btnYes")).ClickNoWait();
            dh3.WaitUntilExists(15);//
            dh3.OKButton.Click();//
            
            dh3.WaitUntilExists(15);//
            dh3.OKButton.Click();//
            browser.RemoveDialogHandler(dh3);

            Thread.Sleep(2000);

            browser.Link(Find.ByText("合同生效配款")).Click();
            browser.WaitUntilContainsText("合同生效配款");
            Assert.IsTrue(browser.ContainsText("合同生效配款"));

            Assert.IsFalse(browser.ContainsText(orderid2));

        }
    }
}
