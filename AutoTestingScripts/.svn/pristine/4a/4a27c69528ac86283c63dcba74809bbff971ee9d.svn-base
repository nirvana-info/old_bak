//#*****************************************************************************
//# Purpose: User select order path.
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
    public class Selectorderpath
    {
        public void TestUserSelectorderpath(Browser browser,string orderpath)
        {
            browser.WaitUntilContainsText("Select Target Area(s)");
            Assert.IsTrue(browser.ContainsText("Select Target Area(s)"));
           
            //browser.Span(Find.ById("tab_bg_2")).ClickNoWait();
            browser.RadioButton(Find.ById(orderpath)).Checked = true;
            browser.Span(Find.ByText("Next")).Click();
            
        }
    }
}
