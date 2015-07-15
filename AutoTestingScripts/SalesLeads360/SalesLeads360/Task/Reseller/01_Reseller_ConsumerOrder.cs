using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using SalesLeads360.Appshare.App01_HomePage;
using SalesLeads360.Appshare;
using System.Data;


namespace SalesLeads360.Task.Reseller
{
    [TestFixture]
    public class Reseller_ConsumerOrder:TestBase
    {


        [Test]
        public void R01_ConsumerOrderByZipCodes()
        {

            //userlogin
            Login login = new Login();
            login.userlogin(CountEmail, CountPW, browser);


            browser.Link("ctl00_ctl00_uxContent_ContentPlaceHolder1_BottomBtNext").Click();

            //select Order path
            Selectorderpath slp = new Selectorderpath();
            slp.TestUserSelectorderpath(browser, op0);

            //input zip codes
            Manualzipcode mzp = new Manualzipcode();
            mzp.TestUserManualzipcode(browser, zp1);


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

        [Test]
        public void R02_ConsumerOrderByRadiusAroundAddress()
        {
          

            browser.Link("ctl00_ctl00_uxContent_ContentPlaceHolder1_BottomBtNext").Click();

            //select Order path
            Selectorderpath slp = new Selectorderpath();
            slp.TestUserSelectorderpath(browser, op1);

            //input an address to choose by radius
            OrderSelectMapRadius om = new OrderSelectMapRadius();
            om.TestUserOrderSelectMapRadius(browser);
           


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


        
        [Test]

        public void R03_ConsumerOrderByCities()
        {



            browser.Link("ctl00_ctl00_uxContent_ContentPlaceHolder1_BottomBtNext").Click();
            
            //select Order path
            Selectorderpath slp = new Selectorderpath();
            slp.TestUserSelectorderpath(browser, op3);

            //select city
            OrderSelectCity osc = new OrderSelectCity();
            osc.TestUserOrderSelectCity(browser);

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
