//#*****************************************************************************
//# Purpose: User ladingbill  delivergoods search
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
    class ladbilldeliversearch
    {
        //public static string ladorderid;
        public void TestUserladbilldeliversearch(Browser browser, string url, string orderid)
        {
            browser.Link(Find.ByText("我要销售")).Click();
            browser.WaitUntilContainsText("请在左边的菜单选择您要进行的操作。 如有疑问，请点击下面相关链接查看操作流程图或查看交易指南");
            Assert.IsTrue(browser.ContainsText("请在左边的菜单选择您要进行的操作。 如有疑问，请点击下面相关链接查看操作流程图或查看交易指南"));

            browser.Link(Find.ByText("可发资源查询")).Click();
            browser.WaitUntilContainsText("可提资源查询");
            Assert.IsTrue(browser.ContainsText("可提资源查询"));
            //先清空

            browser.Button(Find.ById("ctl00_ContentPlaceHolder1_btnCleanDelivery")).ClickNoWait();
            /*
             //测试用
            string ss = "0904000070";
            int s1 = int.Parse(ss);
            int s2 = s1 + 1;
            string ss1 = s2.ToString();
            */
            //
            Thread.Sleep(1500);
            browser.TextField(Find.ById("ctl00_ContentPlaceHolder1_txtOrderCode")).TypeText(orderid);

            browser.Button(Find.ById("ctl00_ContentPlaceHolder1_Button1")).Click();

            //截取ID
            string l1 = browser.Span(Find.ByText("焊接用钢盘条")).Id;
            string l3 = l1.Trim().Substring(13, 4);

            browser.Link(Find.ById("a_order_" + l3)).Click();

            browser.Button(Find.ById("ctl00_ContentPlaceHolder1_NextStepBtn")).Click();

            browser.WaitUntilContainsText("在此页面中您可选择对此提单的处理方式，如无疑义，可点击创建提单完成");
            Assert.IsTrue(browser.ContainsText("在此页面中您可选择对此提单的处理方式，如无疑义，可点击创建提单完成"));
            browser.Table(Find.ById("ctl00_ContentPlaceHolder1_GridView1")).TableRow(Find.ByClass("RowBg")).WaitUntilExists(10);
            //Assert.AreEqual("xx",browser.Table(Find.ById("ctl00_ContentPlaceHolder1_GridView1")).TableRow(Find.ByClass("RowBg")).TableCells[1].Text);
            string ladorderid = browser.Table(Find.ById("ctl00_ContentPlaceHolder1_GridView1")).TableRow(Find.ByClass("RowBg")).TableCells[1].Text;

            browser.Button(Find.ById("ctl00_ContentPlaceHolder1_Button3")).Click();

            //发货单确认
            browser.Link(Find.ByText("发货单确认")).Click();
            browser.WaitUntilContainsText("提单管理");
            Assert.IsTrue(browser.ContainsText("提单管理"));

            WatiN.Core.DialogHandlers.ConfirmDialogHandler dh2 = new WatiN.Core.DialogHandlers.ConfirmDialogHandler();

            browser.AddDialogHandler(dh2);

            browser.Button(Find.ById("ctl00_ContentPlaceHolder1_GridView1_ctl02_ConfirmBtn")).ClickNoWait();
            dh2.WaitUntilExists(15);//
            dh2.OKButton.Click();//
            browser.RemoveDialogHandler(dh2);
        }
    }
}


