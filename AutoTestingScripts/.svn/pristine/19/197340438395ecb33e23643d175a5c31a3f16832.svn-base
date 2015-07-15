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

namespace SalesLeads360.Task.Register.T005_NewMoverList
{
    [TestFixture]
    public class T007_NewMoverList_EnterScfCode : Selectleadstype
    {
        [Test]
        public void T01_Check_NewMoverList_EnterScfCode()
        {
            //userlogin
            Login login = new Login();
            login.userlogin(CountEmail, CountPW, browser);

            ////select leads type
            //TestUserSelectleadstype(tt5);

            //select DataSource
            SelectDataSource("nm");

            //select order path
            Selectorderpath op = new Selectorderpath();
            op.TestUserSelectorderpath(browser, op6);

            //input zip code
            OrderSelectScf oss = new OrderSelectScf();
            oss.TestUserOrderSelectScf(browser, zp2);

            //select Demo4graphic Options
            OrderSelectDemo_NewMover osd = new OrderSelectDemo_NewMover();
            osd.TestUserOrderSelectDemo4(browser);

            //select ordersearch result
            OrderSearchResults osr = new OrderSearchResults();
            osr.TestUserOrderSearchResults(browser);

            //order paymentinfo
            OrderPaymentInfo opi = new OrderPaymentInfo();
            opi.RegisterUserOrderPaymentInfo(browser);
        }
    }
}
