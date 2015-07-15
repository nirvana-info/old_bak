//#*****************************************************************************
//# Purpose: NCOA order
//# Author:  christie
//# Create Date: July 8, 2009
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

namespace SalesLeads360.Task.NCOA
{
    [TestFixture]
    public class NCOA_Register:NCOAOrder
    {
        [Test]
        public void PlaceNCOAOrder_Consumer()
        {

            NCOAOrders(browser, "c", "r");
            browser.Link("ctl00_ctl00_uxContent_ContentPlaceHolder1_BottomBtNext").Click();
            OrderPaymentInfo np = new OrderPaymentInfo();
            np.TestUserOrderPaymentInfo(browser);
        }

        [Test]
        public void PlaceNCOAOrder_Business()
        {
            NCOAOrders(browser, "b", "r");
            browser.Link("ctl00_ctl00_uxContent_ContentPlaceHolder1_BottomBtNext").Click();
            OrderPaymentInfo np = new OrderPaymentInfo();
            np.TestUserOrderPaymentInfo(browser);
        }

        [Test]
        public void PlaceNCOASaveCount_Consumer()
        {
            NCOAOrders(browser, "c", "r");
            browser.Link("ctl00_ctl00_uxContent_ContentPlaceHolder1_BottomBtSave").Click();
            SaveCount sc = new SaveCount();
            sc.NCOASavedCount("NCOASavedCountConsumer" + Date, browser);

        }


        [Test]
        public void PlaceNCOASaveCount_Business()
        {
            NCOAOrders(browser, "b", "r");
            browser.Link("ctl00_ctl00_uxContent_ContentPlaceHolder1_BottomBtSave").Click();
            SaveCount sc = new SaveCount();
            sc.NCOASavedCount("NCOASavedCountBusiness" + Date, browser);


        }

    }
}
