//#*****************************************************************************
//# Purpose: User select order path. for new homemover
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
    public class OrderSelectDemo_NewMover
    {
        public void TestUserOrderSelectDemo4(Browser browser)
        {
            browser.WaitUntilContainsText("Define Target Audience");
            Assert.IsTrue(browser.ContainsText("Define Target Audience"));




            browser.SelectList(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_ltbDemVar")).Option(Find.ByValue("A")).Select();
            browser.Link(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_btAddDem")).Click();
            browser.Div(Find.ById("divWaiting")).WaitUntilRemoved();                                                             
            browser.Div("ListbarProfiles").Table("ListbarProfiles_Group_0_group").TableRow("ListbarProfiles_Group_0_items").Div("ListbarProfiles_0_Item_0").WaitUntilExists(20);

                                          
            browser.SelectList(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_ltbDemVar")).Option(Find.ByValue("B")).Select();
            browser.Link(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_btAddDem")).Click();
            browser.Div(Find.ById("divWaiting")).WaitUntilRemoved();

            browser.Div("ListbarProfiles").Table("ListbarProfiles_Group_0_group").TableRow("ListbarProfiles_Group_0_items").Div("ListbarProfiles_0_Item_1").WaitUntilExists(20);


            browser.SelectList(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_ltbDemVar")).Option(Find.ByValue("C")).Select();
            browser.Link(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_btAddDem")).Click();
            browser.Div(Find.ById("divWaiting")).WaitUntilRemoved();

            browser.Div("ListbarProfiles").Table("ListbarProfiles_Group_0_group").TableRow("ListbarProfiles_Group_0_items").Div("ListbarProfiles_0_Item_2").WaitUntilExists(20);

            browser.RadioButton(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_rb_phoneNothing")).Checked = true;
            browser.Span(Find.ByText("Next")).Click();
        }
    }
}
