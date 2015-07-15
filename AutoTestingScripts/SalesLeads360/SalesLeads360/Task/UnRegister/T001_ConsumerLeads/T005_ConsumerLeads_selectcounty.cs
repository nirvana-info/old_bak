//#*****************************************************************************
//# Purpose: select county 
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

namespace SalesLeads360.Task.UnRegister.T001_ConsumerLeads
{
    [TestFixture]
    public class T005_ConsumerLeads_selectcounty : Selectleadstype
    {
        [Test]
        public void T01_Check_ConsumerLeads_selectcounty()
        {
            ////select leads type
            //TestUserSelectleadstype(tt1);
            browser.GoTo(targetHost + "sl360");

            //browser.Link("aMainMenu0").Click();

            //select DataSource
            //SelectDataSource("c");

            browser.TableCell("tab_bg_1").Click();
            browser.Link(Find.ByTitle("Start using our consumer leads mailing list now!")).ClickNoWait();

            //select order path
            Selectorderpath op = new Selectorderpath();
            op.TestUserSelectorderpath(browser, op4);

            //input zip code
            OrderSelectGeoType osgt = new OrderSelectGeoType();
            osgt.TestUserOrderSelectGeoType(browser);

            //select Demographic Options
            OrderSelectDemo_Consumer osd = new OrderSelectDemo_Consumer();
            osd.TestUserOrderSelectDemo(browser);

            //select ordersearch result
            OrderSearchResults osr = new OrderSearchResults();
            osr.TestUserOrderSearchResults(browser);

            //order paymentinfo
            OrderPaymentInfo opi = new OrderPaymentInfo();
            opi.TestUserOrderPaymentInfo(browser);
        }
    }
}
