//#*****************************************************************************
//# Purpose: 2方订单全额付款
//# Author:  bobby
//# Create Date: April 13, 2009
//# Modify History: 

//#*****************************************************************************

using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using zjsteel.appshare.App01_HomePage;
using System.Threading;

namespace zjsteel.task.T001_2ndorder
{
    [TestFixture]
    public class test : SignIn
    {


        [Test]
        public void T01_test()
        {
            //平台登陆
            TestUserSignIn(UN1, PW1);
            browser.Link(Find.ById("ctl00_linkTrade")).Click();
            browser.WaitUntilContainsText("请在左边的菜单选择您要进行的操作。 如有疑问，请点击下面相关链接查看操作流程图或查看交易指南");
            Assert.IsTrue(browser.ContainsText("请在左边的菜单选择您要进行的操作。 如有疑问，请点击下面相关链接查看操作流程图或查看交易指南"));
            browser.Link(Find.ByText("我要销售")).Click();
            browser.WaitUntilContainsText("请在左边的菜单选择您要进行的操作。 如有疑问，请点击下面相关链接查看操作流程图或查看交易指南");
            Assert.IsTrue(browser.ContainsText("请在左边的菜单选择您要进行的操作。 如有疑问，请点击下面相关链接查看操作流程图或查看交易指南"));
            browser.Link(Find.ByText("资源数据维护")).Click();
            browser.WaitUntilContainsText("本页可进行已挂资源价格修改");
            Assert.IsTrue(browser.ContainsText("本页可进行已挂资源价格修改"));

            browser.CheckBox(Find.ByName("ckbLotMaster")).Checked = true;
            //browser.SelectList(Find.ById("ctl00_ContentPlaceHolder1_gvLotMaster_ctl02_ddlPricetype")).Option(Find.ByText(pricetype)).Select();
            browser.Button(Find.ById("ctl00_ContentPlaceHolder1_btnEditType")).Click();
            Thread.Sleep(15);
            browser.Frame(Find.ById("wheatmsg_ifrm")).SelectList(Find.ById("ddlPriceType")).Option(Find.ByValue("2")).Select();
            browser.Frame(Find.ById("wheatmsg_ifrm")).Button(Find.ById("btnYes")).Click();
            //Assert.AreEqual("xx", browser.Form(Find.ById("form1")).Span(Find.ById("lblSelect")).Text);
            //browser.Form(Find.ById("form1")).SelectList(Find.ById("ddlPriceType")).Option(Find.ByValue("2")).Select();
        }


    }
}
