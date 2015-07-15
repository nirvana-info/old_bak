//#*****************************************************************************
//# Purpose: User select city.
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
    public class OrderSelectCity
    {
        public void TestUserOrderSelectCity(Browser browser)
        {
            browser.WaitUntilContainsText("Step 1: Select Target Area(s) - Cities");
            Assert.IsTrue(browser.ContainsText("Step 1: Select Target Area(s) - Cities"));




            browser.SelectList(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_lstCities")).Option(Find.ByValue("Abbeville:AL")).Select();
            browser.Link(Find.ByClass("bt_add")).Click();
            browser.SelectList(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_lstCities")).Option(Find.ByValue("Abernant:AL")).Select();
            browser.Link(Find.ByClass("bt_add")).Click();
            browser.SelectList(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_lstCities")).Option(Find.ByValue("Adamsville:AL")).Select();
            browser.Link(Find.ByClass("bt_add")).Click();
            browser.SelectList(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_lstCities")).Option(Find.ByValue("Addison:AL")).Select();
            browser.Link(Find.ByClass("bt_add")).Click();
            browser.SelectList(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_lstCities")).Option(Find.ByValue("Adger:AL")).Select();
            browser.Link(Find.ByClass("bt_add")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_BottomBtNext")).Click();


        }
    }
}
