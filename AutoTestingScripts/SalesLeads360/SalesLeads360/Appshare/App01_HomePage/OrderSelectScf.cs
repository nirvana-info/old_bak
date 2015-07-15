//#*****************************************************************************
//# Purpose: User input scf 
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
    public class OrderSelectScf
    {
        public void TestUserOrderSelectScf(Browser browser, string zipcode)
        {
            browser.WaitUntilContainsText("Step 1: Select Target Area(s) - SCF Codes");
            Assert.IsTrue(browser.ContainsText("Step 1: Select Target Area(s) - SCF Codes"));


            browser.TextField(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_uxScf1")).TypeText(zipcode);
            browser.Span(Find.ByText("Next")).Click();

        }
    }
}
