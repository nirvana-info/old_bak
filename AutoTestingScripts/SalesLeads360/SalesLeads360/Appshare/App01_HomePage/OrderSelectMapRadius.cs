//#*****************************************************************************
//# Purpose: User select order mapradius.
//# Author:  bobby
//# Create Date: apr 27, 2009
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
using SalesLeads360.Appshare;
using System.Threading;

namespace SalesLeads360.Appshare.App01_HomePage
{
    public class OrderSelectMapRadius
    {
        public void TestUserOrderSelectMapRadius(Browser browser)
        {
            browser.WaitUntilContainsText("Step 1: Select Target Area(s) - Radius around Address");
            Assert.IsTrue(browser.ContainsText("Step 1: Select Target Area(s) - Radius around Address"));




            browser.TextField(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_tbAddr")).TypeText("New York");
            browser.WaitUntilContainsText("10017");

            browser.TextField(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_tbRadius")).TypeText("0");
            browser.TextField(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_tbRadius")).TypeText("5");
            Thread.Sleep(1000);
            browser.WaitUntilContainsText("5");
            Thread.Sleep(1000);
            browser.Button(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_btSearch")).Click();
            Thread.Sleep(1000);
            browser.Link(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_lbtNext")).Click();

        }
    }
}
