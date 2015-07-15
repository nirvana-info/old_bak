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
using System.Threading;

namespace SalesLeads360.Appshare.App01_HomePage
{
    public class OrderSelectDemo_Consumer
    {
        public void TestUserOrderSelectDemo(Browser browser)
        {
            browser.WaitUntilContainsText("Define Target Audience");
            Assert.IsTrue(browser.ContainsText("Define Target Audience"));

            //browser.SelectList(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_ltbDemCat")).Option(Find.ByText("Estimated Income")).Select();


          /*  browser.SelectList(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_ltbDemCat")).Option(Find.ByValue("3$$alvionacxiom30_DateOfBirthU")).Select();
            browser.TextField(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_uxInputLower")).TypeText("012008");
            browser.TextField(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_uxInputUpper")).TypeText("012009");
            browser.Link(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_btAddDem")).Click();*/
            
            //browser.Div(Find.ById("divWaiting")).WaitUntilRemoved();
           // browser.Div("ListbarProfiles").Table("ListbarProfiles_Group_0_group").TableRow("ListbarProfiles_Group_0_items").Div("ListbarProfiles_0_Item_0").WaitUntilExists(20);

            browser.SelectList(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_ltbDemCat")).Option(Find.ByValue("0$$alvionacxiom30_AgeOfIndividual")).Select();
            browser.Link(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_btAddDem")).Click();

            browser.SelectList(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_ltbDemVar")).Option(Find.ByValue("20")).Select();
            browser.Link(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_btAddDem")).Click();
            
            browser.SelectList(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_ltbDemVar")).Option(Find.ByValue("22")).Select();
            browser.Link(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_btAddDem")).Click();
            
            browser.SelectList(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_ltbDemVar")).Option(Find.ByValue("24")).Select();
            browser.Link(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_btAddDem")).Click();
            
            browser.SelectList(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_ltbDemVar")).Option(Find.ByValue("26")).Select();
            browser.Link(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_btAddDem")).Click();
            //browser.Div(Find.ById("divWaiting")).WaitUntilRemoved();

            browser.Div("ListbarProfiles").Table("ListbarProfiles_Group_0_group").TableRow("ListbarProfiles_Group_0_items").Div("ListbarProfiles_0_Item_0").WaitUntilExists(20);


           /* browser.SelectList(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_ltbDemCat")).Option(Find.ByValue("0$$alvionacxiom30_CreditCardUser")).Select();
            browser.Link(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_btAddDem")).Click();
            browser.Div(Find.ById("divWaiting")).WaitUntilRemoved();
            browser.Div("ListbarProfiles").Table("ListbarProfiles_Group_1_group").TableRow("ListbarProfiles_Group_1_items").Div("ListbarProfiles_1_Item_0").WaitUntilExists(20);*/
           // browser.Div("ListbarProfiles").Table("ListbarProfiles_Group_2_group").TableRow("ListbarProfiles_Group_2_items").Div("ListbarProfiles_2_Item_0").WaitUntilExists(20);


            browser.RadioButton(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_rb_phoneNothing")).Checked = true;
            browser.Span(Find.ByText("Next")).Click();
        }
    }
}
