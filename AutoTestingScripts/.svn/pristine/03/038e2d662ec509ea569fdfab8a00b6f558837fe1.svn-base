//#*****************************************************************************
//# Purpose: ladbillmanage.
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
    class ladbillmanage
    {
        public void TestUserladingbillmanage(Browser browser, string url)
        {
            browser.Link(Find.ByText("提单管理")).Click();
            browser.WaitUntilContainsText("提单管理");
            Assert.IsTrue(browser.ContainsText("提单管理"));
            browser.Button(Find.ById("ctl00_ContentPlaceHolder1_GridView1_ctl02_btnPrint")).Click();
            
        }
    }
}
