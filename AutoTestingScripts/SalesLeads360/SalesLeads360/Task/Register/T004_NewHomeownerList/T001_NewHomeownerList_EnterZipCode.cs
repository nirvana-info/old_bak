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


namespace SalesLeads360.Task.Register.T004_NewHomeownerList
{
    [TestFixture]
    public class T001_NewHomeownerList_EnterZipCode : Selectleadstype
    {
        [Test]
        public void T01_Check_BusinessLeads_EnterZipCode()
        {
   
            //userlogin
            Login login = new Login();
            login.userlogin(CountEmail, CountPW, browser);

            ////select leads type
            //TestUserSelectleadstype(tt4);

            //select DataSource
            SelectDataSource("nh");

            //select order path
            Selectorderpath op = new Selectorderpath();
            op.TestUserSelectorderpath(browser, op0);

            //input zip code
            Manualzipcode mz = new Manualzipcode();
            mz.TestUserManualzipcode(browser,zp1);

            //select Demographic Options
            OrderSelectDemo_NewHomeowner osd = new OrderSelectDemo_NewHomeowner();
            osd.TestUserOrderSelectDemo3(browser);

            //select ordersearch result
            OrderSearchResults osr = new OrderSearchResults();
            osr.TestUserOrderSearchResults(browser);

            //order paymentinfo
            OrderPaymentInfo opi = new OrderPaymentInfo();
            opi.RegisterUserOrderPaymentInfo(browser);
        }
    }
}
