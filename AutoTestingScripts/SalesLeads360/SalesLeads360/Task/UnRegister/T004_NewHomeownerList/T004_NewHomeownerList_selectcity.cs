//#*****************************************************************************
//# Purpose: select city 
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

namespace SalesLeads360.Task.UnRegister.T004_NewHomeownerList
{
    [TestFixture]
    public class T004_NewHomeownerList_selectcity : Selectleadstype
    {
        [Test]
        public void T01_Check_NewHomeownerList_selectcity()
        {
            ////select leads type
            //TestUserSelectleadstype(tt4);
            browser.GoTo(targetHost + "sl360");
            //browser.Link("aMainMenu0").Click();

            //select DataSource
            //SelectDataSource("b");

            browser.TableCell("tab_bg_4").Click();
            browser.Link(Find.ByTitle("Start using our new homeowner leads mailing list now!")).ClickNoWait();

            //select order path
            Selectorderpath op = new Selectorderpath();
            op.TestUserSelectorderpath(browser, op3);

            //input zip code
            OrderSelectCity osc = new OrderSelectCity();
            osc.TestUserOrderSelectCity(browser);

            //select Demographic Options
            OrderSelectDemo_NewHomeowner osd = new OrderSelectDemo_NewHomeowner();
            osd.TestUserOrderSelectDemo3(browser);

            //select ordersearch result
            OrderSearchResults osr = new OrderSearchResults();
            osr.TestUserOrderSearchResults(browser);

            //order paymentinfo
            OrderPaymentInfo opi = new OrderPaymentInfo();
            opi.TestUserOrderPaymentInfo(browser);
        }
    }
}
