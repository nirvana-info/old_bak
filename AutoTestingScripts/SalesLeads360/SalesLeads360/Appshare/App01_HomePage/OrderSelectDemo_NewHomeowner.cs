//#*****************************************************************************
//# Purpose: User select order path. for new homeowner
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
    public class OrderSelectDemo_NewHomeowner
    {
        public void TestUserOrderSelectDemo3(Browser browser)
        {
            browser.WaitUntilContainsText("Define Target Audience");
            Assert.IsTrue(browser.ContainsText("Define Target Audience"));

            //browser.SelectList(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_ltbDemCat")).Option(Find.ByText("Estimated Income")).Select();


            browser.CheckBox(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_chbAllHousehold")).Checked = true;
            browser.Div(Find.ById("divWaiting")).WaitUntilRemoved();
            browser.RadioButton(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_rb_phoneNothing")).Checked = true;
            browser.Span(Find.ByText("Next")).Click();
        }
    }
}
