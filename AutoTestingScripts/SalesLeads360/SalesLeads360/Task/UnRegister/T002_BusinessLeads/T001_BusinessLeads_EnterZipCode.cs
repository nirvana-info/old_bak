//#*****************************************************************************
//# Purpose: enter zipcode
//# Author:  bobby
//# Create Date: April 27, 2009
//# Modify History: 

//#*****************************************************************************

using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using SalesLeads360.Appshare.App01_HomePage;
using SalesLeads360.Appshare;

using System.Data;


namespace SalesLeads360.Task.UnRegister.T002_BusinessLeads
{
    [TestFixture]
    public class T001_BusinessLeads_EnterZipCode : Selectleadstype
    {
        [Test]
        public void T01_Check_BusinessLeads_EnterZipCode()
        {
            ////select leads type
            //TestUserSelectleadstype(tt2);
            browser.GoTo(targetHost + "sl360");

            //browser.Link("aMainMenu0").Click();

            //select DataSource
            //SelectDataSource("b");

            browser.TableCell("tab_bg_2").Click();
            browser.Link(Find.ByTitle("Start using our business leads mailing list now!")).ClickNoWait();

            //select order path
            Selectorderpath op = new Selectorderpath();
            op.TestUserSelectorderpath(browser, op0);

            //input zip code
            Manualzipcode mz = new Manualzipcode();
            mz.TestUserManualzipcode(browser,zp1);

            //select Demographic Options
            OrderSelectDemo_Business osd = new OrderSelectDemo_Business();
            osd.TestUserOrderSelectDemo1(browser);

            //select ordersearch result
            OrderSearchResults osr = new OrderSearchResults();
            osr.TestUserOrderSearchResults(browser);

            //order paymentinfo
            OrderPaymentInfo opi = new OrderPaymentInfo();
            opi.TestUserOrderPaymentInfo(browser);
        }
    }
}
