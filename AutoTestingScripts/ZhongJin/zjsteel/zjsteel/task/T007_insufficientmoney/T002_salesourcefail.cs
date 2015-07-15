//#*****************************************************************************
//# Purpose: 金额不足
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
using zjsteel.appshare;
using System.Data.OracleClient;
using System.Data;

namespace zjsteel.task.T007_insufficientmoney
{
    [TestFixture]
    public class T002_salesourcefail:SignIn
    {
        [Test]
        public void T01_Check_salesourcefail()
        {
            //供应商用户登陆
            TestUserSignIn(UN4, PW4);

            //挂牌资源
            salesource sl = new salesource();
            sl.TestUsersales(browser, BS, LS, SZ, MT, MD, WT, PR, DT1, DT, SH3);

            browser.Link(Find.ByText("资源撤牌管理")).Click();
            browser.WaitUntilContainsText("本页可选择需要撤牌的资源，进行撤牌。");
            Assert.IsTrue(browser.ContainsText("本页可选择需要撤牌的资源，进行撤牌。"));
            Assert.IsTrue(browser.ContainsText("未查询到您想要的数据，请扩大您的查询范围。"));

            browser.Link(Find.ByText("资源挂牌")).Click();
            browser.WaitUntilContainsText("可选择以下两种上传方式");
            Assert.IsTrue(browser.ContainsText("可选择以下两种上传方式"));

            WatiN.Core.DialogHandlers.ConfirmDialogHandler dh = new WatiN.Core.DialogHandlers.ConfirmDialogHandler();

            browser.AddDialogHandler(dh);

            browser.Button(Find.ById("ctl00_ContentPlaceHolder1_deleteallbtn")).ClickNoWait();
            dh.WaitUntilExists(15);//

            dh.OKButton.Click();//
            dh.WaitUntilExists(15);

            dh.OKButton.Click();
            browser.RemoveDialogHandler(dh);
            browser.WaitUntilContainsText("未查询到您想要的数据");
            Assert.IsTrue(browser.ContainsText("未查询到您想要的数据"));

        }
    }
}
