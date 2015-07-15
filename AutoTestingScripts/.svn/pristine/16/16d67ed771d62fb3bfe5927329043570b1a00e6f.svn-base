//#*****************************************************************************
//# Purpose: User select order path. for business
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

namespace SalesLeads360.Appshare.App01_HomePage
{
    public class OrderSelectDemo_Business
    {
        public void TestUserOrderSelectDemo1(Browser browser)
        {
            browser.WaitUntilContainsText("Step 2: Define Target Audience");
            Assert.IsTrue(browser.ContainsText("Step 2: Define Target Audience"));

            //browser.SelectList(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_ltbDemCat")).Option(Find.ByText("Estimated Income")).Select();


            browser.CheckBox(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_chbAllHousehold")).Checked=true;
            browser.Span(Find.ByText("Next")).Click();
        }
    }
}
