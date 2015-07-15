//#*****************************************************************************
//# Purpose: User select county.
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
    public class OrderSelectGeoType
    {
        public void TestUserOrderSelectGeoType(Browser browser)
        {
            browser.WaitUntilContainsText("Step 1: Select Target Area(s) - Counties");
            Assert.IsTrue(browser.ContainsText("Step 1: Select Target Area(s) - Counties"));




            browser.SelectList(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_lbCounties")).Option(Find.ByValue("Autauga:AL:AL001:01001")).Select();
            browser.Link(Find.ByClass("bt_add")).Click();
            browser.SelectList(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_lbCounties")).Option(Find.ByValue("Baldwin:AL:AL003:01003")).Select();
            browser.Link(Find.ByClass("bt_add")).Click();
            browser.SelectList(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_lbCounties")).Option(Find.ByValue("Barbour:AL:AL005:01005")).Select();
            browser.Link(Find.ByClass("bt_add")).Click();
            browser.SelectList(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_lbCounties")).Option(Find.ByValue("Bibb:AL:AL007:01007")).Select();
            browser.Link(Find.ByClass("bt_add")).Click();
            browser.SelectList(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_lbCounties")).Option(Find.ByValue("Blount:AL:AL009:01009")).Select();
            browser.Link(Find.ByClass("bt_add")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_BottomBtNext")).Click();


        }
    }
}
