//#*****************************************************************************
//# Purpose: User input zip code
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
    public class Manualzipcode
    {
        public void TestUserManualzipcode(Browser browser, string zipcode)
        {
            browser.WaitUntilContainsText("Select Target Area(s) - Zip Codes");
            Assert.IsTrue(browser.ContainsText("Select Target Area(s) - Zip Codes"));


            browser.TextField(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_uxZip1")).TypeText(zipcode);
            browser.Span(Find.ByText("Next")).Click();

        }
    }
}
