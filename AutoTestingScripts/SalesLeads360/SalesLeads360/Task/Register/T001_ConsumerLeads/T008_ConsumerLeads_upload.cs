//#*****************************************************************************
//# Purpose: upload zip code
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

namespace SalesLeads360.Task.Register.T001_ConsumerLeads
{
    [TestFixture]
    public class T008_ConsumerLeads_upload : Selectleadstype
    {
        [Test]
        public void T01_Check_ConsumerLeads_upload()
        {
            
            //userlogin
            Login login = new Login();
            login.userlogin(CountEmail, CountPW, browser);

            ////select leads type
            //TestUserSelectleadstype(tt1);

            //select DataSource
            SelectDataSource("c");

            //select order path
            Selectorderpath op = new Selectorderpath();
            op.TestUserSelectorderpath(browser, op7);

            //upload zip code
            OrderGeoZipUpload ogzu = new OrderGeoZipUpload();
            ogzu.TestUserOrderGeoZipUpload(browser);

            //select Demographic Options
            OrderSelectDemo_Consumer osd = new OrderSelectDemo_Consumer();
            osd.TestUserOrderSelectDemo(browser);

            //select ordersearch result
            OrderSearchResults osr = new OrderSearchResults();
            osr.TestUserOrderSearchResults(browser);

            //order paymentinfo
            OrderPaymentInfo opi = new OrderPaymentInfo();
            opi.RegisterUserOrderPaymentInfo(browser);

        }
    }
}
