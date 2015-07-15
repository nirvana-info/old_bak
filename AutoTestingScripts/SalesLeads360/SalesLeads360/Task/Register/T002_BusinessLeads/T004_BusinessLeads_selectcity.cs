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

namespace SalesLeads360.Task.Register.T002_BusinessLeads
{
    [TestFixture]
    public class T004_BusinessLeads_selectcity : Selectleadstype
    {
        [Test]
        public void T01_Check_BusinessLeads_selectcity()
        {
            //userlogin
            Login login = new Login();
            login.userlogin(CountEmail, CountPW, browser);

            ////select leads type
            //TestUserSelectleadstype(tt2);

            //select DataSource
            SelectDataSource("b");

            //select order path
            Selectorderpath op = new Selectorderpath();
            op.TestUserSelectorderpath(browser, op3);

            //input zip code
            OrderSelectCity osc = new OrderSelectCity();
            osc.TestUserOrderSelectCity(browser);

            //select Demographic Options
            OrderSelectDemo_Business osd = new OrderSelectDemo_Business();
            osd.TestUserOrderSelectDemo1(browser);

            //select ordersearch result
            OrderSearchResults osr = new OrderSearchResults();
            osr.TestUserOrderSearchResults(browser);

            //order paymentinfo
            OrderPaymentInfo opi = new OrderPaymentInfo();
            opi.RegisterUserOrderPaymentInfo(browser);

        }
    }
}
