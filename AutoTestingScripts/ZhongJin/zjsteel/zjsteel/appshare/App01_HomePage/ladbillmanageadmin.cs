//#*****************************************************************************
//# Purpose: ladbillmanage--平台.
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
    class ladbillmanageadmin
    {
        public void TestUserladingbillmanageadmin(Browser browser, string url)
        {
            browser.Link(Find.ByText("提单管理")).Click();
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
