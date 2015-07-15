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
    public class Selectleadstype:TestBase
    {
        PublicPara v = new PublicPara();

        //public void TestUserSelectleadstype(string title)
        //{
        //    browser.WaitUntilContainsText("Don't see what you need?");
        //    Assert.IsTrue(browser.ContainsText("Don't see what you need?"));
        //    //browser.Span(Find.ById("tab_bg_2")).ClickNoWait();
        //    //browser.Div(Find.ByClass(list)).Click();
        //    browser.Link(Find.ByTitle(title)).Click();
            
        //}

        public void SelectDataSource(string Datasource)
        {

           
            if (Datasource == "c")
            {
                browser.RadioButton("ctl00_ctl00_uxContent_ContentPlaceHolder1_rbConsumer").Checked = true;
            }
            if (Datasource == "b")
            {
                browser.RadioButton("ctl00_ctl00_uxContent_ContentPlaceHolder1_rbBusiness").Checked = true;
            }

            if (Datasource == "o")
            {
                browser.RadioButton("ctl00_ctl00_uxContent_ContentPlaceHolder1_rbOccupant").Checked = true;
            }
            if (Datasource == "nh")
            {
                browser.RadioButton("ctl00_ctl00_uxContent_ContentPlaceHolder1_rbHomeowner").Checked = true;
            }
            if (Datasource == "nm")
            {
                browser.RadioButton("ctl00_ctl00_uxContent_ContentPlaceHolder1_rbNewMover").Checked = true;
            }


           browser.Link("ctl00_ctl00_uxContent_ContentPlaceHolder1_BottomBtNext").Click();
        }


    }
}
