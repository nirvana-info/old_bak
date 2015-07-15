using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using Selenium;
using NUnit.Framework;
using System.Threading;

namespace CWAdmin
{
    [TestFixture]
    public class TestBase : PublicPara
    {
        public ISelenium selenium = null;
        private StringBuilder verificationErrors;

        [TestFixtureSetUp]
        public void StartSelenium()
        {
            verificationErrors = new StringBuilder();          

            string platform = System.Configuration.ConfigurationManager.AppSettings["Platform"];
            this.URL = System.Configuration.ConfigurationManager.AppSettings["TestURL"];
            //get un/pw from db
            //this.UN = "";
            //this.PW = "";

            selenium = new DefaultSelenium("localhost", 4444, platform, this.URL);
            //selenium = new DefaultSelenium("localhost", 4444, "*firefox3 C:\\Program Files\\Mozilla Firefox\\firefox.exe", "http://dev.lofinc.net");
            selenium.Start();
            Thread.Sleep(5000);
            selenium.WindowMaximize();

            selenium.SetTimeout("0");
            selenium.Open("/admin/");
            this.selenium.WaitForPageToLoad("5000");
        }

        [TestFixtureTearDown]
        public void StopSelenium()
        {
            //selenium.Stop();
        }
    }
}
