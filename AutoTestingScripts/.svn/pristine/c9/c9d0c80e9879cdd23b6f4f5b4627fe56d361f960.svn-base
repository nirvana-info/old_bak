using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using SalesLeads360.Appshare.App01_HomePage;
using SalesLeads360.Appshare;

namespace SalesLeads360.Task.Reseller
{
    [TestFixture]
    public class Reseller_BusinessOrder:TestBase
    {
        [Test]
        public void T01_Check_BusinessLeads_EnterZipCode()
        {

            //userlogin
            Login login = new Login();
            login.userlogin(CountEmail, CountPW, browser);


            browser.RadioButton("ctl00_ctl00_uxContent_ContentPlaceHolder1_rbListType_1").Checked = true;
            browser.Link("ctl00_ctl00_uxContent_ContentPlaceHolder1_BottomBtNext").Click();

            ////select leads type
            //TestUserSelectleadstype(tt2);

            //select DataSource
            Selectleadstype ss = new Selectleadstype();
            ss.SelectDataSource("b");

            //select order path
            Selectorderpath op = new Selectorderpath();
            op.TestUserSelectorderpath(browser, op0);

            //input zip code
            Manualzipcode mz = new Manualzipcode();
            mz.TestUserManualzipcode(browser, zp1);

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
