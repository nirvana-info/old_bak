using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using Selenium;
using NUnit.Framework;

namespace Lof
{
    [TestFixture]
    public class TestBase
    {
        public ISelenium selenium = null;

        [TestFixtureSetUp]
        public void StartSelenium()
        {
            string platform = System.Configuration.ConfigurationManager.AppSettings["Platform"];
            selenium = new DefaultSelenium("localhost", 4444, platform, "http://www.google.com.hk/");

            selenium.Start();
            selenium.WindowMaximize();
        }

        [TestFixtureTearDown]
        public void StopSelenium()
        {
            //selenium.Stop();
        }
    }
}
