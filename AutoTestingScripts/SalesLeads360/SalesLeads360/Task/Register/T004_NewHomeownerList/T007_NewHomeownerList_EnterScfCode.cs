//#*****************************************************************************
//# Purpose: enter scf code
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
    public class T007_NewHomeownerList_EnterScfCode : Selectleadstype
    {
        [Test]
        public void T01_Check_NewHomeownerList_EnterScfCode()
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
            op.TestUserSelectorderpath(browser, op6);

            //input zip code
            OrderSelectScf oss = new OrderSelectScf();
            oss.TestUserOrderSelectScf(browser, zp2);

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
