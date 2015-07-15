//#*****************************************************************************
//# Purpose: User select order path. for occ
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
    public class OrderSelectDemo_Occupant
    {
        public void TestUserOrderSelectDemo2(Browser browser)
        {
            browser.WaitUntilContainsText("Define Target Audience");
            Assert.IsTrue(browser.ContainsText("Define Target Audience"));

            
            browser.Span(Find.ByText("Next")).Click();
        }
    }
}
