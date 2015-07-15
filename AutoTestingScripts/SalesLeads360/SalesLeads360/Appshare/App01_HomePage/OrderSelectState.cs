//#*****************************************************************************
//# Purpose: User select order by state.
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
    public class OrderSelectState
    {
        public void TestUserOrderSelectState(Browser browser)
        {
            browser.WaitUntilContainsText("Step 1: Select Target Area(s) - States");
            Assert.IsTrue(browser.ContainsText("Step 1: Select Target Area(s) - States"));

            browser.SelectList(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_lbState")).Option(Find.ByValue("AL")).Select();
            browser.Link(Find.ByClass("bt_add")).Click();
            browser.SelectList(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_lbState")).Option(Find.ByValue("AK")).Select();
            browser.Link(Find.ByClass("bt_add")).Click();
            browser.SelectList(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_lbState")).Option(Find.ByValue("AZ")).Select();
            browser.Link(Find.ByClass("bt_add")).Click();
            browser.SelectList(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_lbState")).Option(Find.ByValue("AR")).Select();
            browser.Link(Find.ByClass("bt_add")).Click();
            browser.SelectList(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_lbState")).Option(Find.ByValue("CA")).Select();
            browser.Link(Find.ByClass("bt_add")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_BottomBtNext")).Click();



        }
    }
}
