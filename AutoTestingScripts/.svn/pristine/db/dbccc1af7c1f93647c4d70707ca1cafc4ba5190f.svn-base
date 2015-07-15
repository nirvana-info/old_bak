//#*****************************************************************************
//# Purpose: User select leads type.
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
    public class Selectsitmap : TestBase
    {
        PublicPara v = new PublicPara();

        public void TestUserSelectsitmap()
        {
            browser.WaitUntilContainsText("Don't see what you need?");
            Assert.IsTrue(browser.ContainsText("Don't see what you need?"));
            //browser.Span(Find.ById("tab_bg_2")).ClickNoWait();
            

            //browser.Link(Find.ByTitle(title)).Click();
            browser.Link(Find.ByText("Site Map")).Click();
            browser.WaitUntilContainsText("Home > Site Map ");
            Assert.IsTrue(browser.ContainsText("Home > Site Map "));
            browser.Link(Find.ByText("Specialty Lists")).Click();
        }
    }
}
