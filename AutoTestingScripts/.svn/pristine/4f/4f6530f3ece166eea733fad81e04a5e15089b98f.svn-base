using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks.SpringFunnel3.S001_ExploreEnhancements_Module
{
    [TestFixture]
    public class S001_ExploreEnhancements_Module_3 : SignIn
    {
        [Test]
        public void T01_ExploreEnhancements_Stocks_AlertCenter()
        {
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl03_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Link(Find.ByValue("Alerts Center")).Exists);
        }

        [Test]
        public void T02_ExploreEnhancements_Stocks_GainsKeeper()
        {
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl03_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Link(Find.ByValue("Gainskeeper")).Exists);
        }

        [Test]
        public void T03_ExploreEnhancements_Options_OptionOrderEntry()
        {
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl04_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Link(Find.ByText("Options Order Entry")).Exists);
        }

        [Test]
        public void T04_ExploreEnhancements_Options_StrategyBuilder()
        {
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl04_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Button(Find.ByText("Strategy Builder")).Exists);
        }

        [Test]
        public void T05_ExploreEnhancements_Options_QR()
        {
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl04_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Button(Find.ByText("Quotes &amp; Research")).Exists);
        }

        [Test]
        public void T06_ExploreEnhancements_Options_FindStrategy()
        {
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl04_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Button(Find.ByText("Find a Strategy")).Exists);
        }

        [Test]
        public void T07_ExploreEnhancements_Tracking_WhyZecco()
        {
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl00_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            browser.Image(Find.ByAlt("open an account")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Url.Contains("promo=explore-why-zecco"));
        }

        [Test]
        public void T08_ExploreEnhancements_Tracking_Pricing()
        {
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl01_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            browser.Image(Find.ByAlt("open an account")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Url.Contains("promo=explore-pricing"));
        }

        [Test]
        public void T09_ExploreEnhancements_Tracking_Products()
        {
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl02_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            browser.Image(Find.ByAlt("open an account")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Url.Contains("promo=explore-products"));
        }

        [Test]
        public void T10_ExploreEnhancements_Tracking_Stocks()
        {
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl03_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            browser.Image(Find.ByAlt("open an account")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Url.Contains("promo=explore-stocks"));
        }

        [Test]
        public void T11_ExploreEnhancements_Tracking_Options()
        {
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl04_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            browser.Image(Find.ByAlt("open an account")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Url.Contains("promo=explore-options"));
        }

        [Test]
        public void T12_ExploreEnhancements_Tracking_IRAs()
        {
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl06_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            browser.Image(Find.ByAlt("open an account")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Url.Contains("promo=explore-ira"));
        }

        [Test]
        public void T13_ExploreEnhancements_Tracking_Community()
        {
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl07_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            browser.Image(Find.ByAlt("open an account")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Url.Contains("promo=explore-community"));
        }

        [Test]
        public void T14_ExploreEnhancements_Tracking_Tools()
        {
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl08_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            browser.Image(Find.ByAlt("open an account")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Url.Contains("promo=explore-tools"));
        }

        [Test]
        public void T15_ExploreEnhancements_Tracking_Service()
        {
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl09_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            browser.Image(Find.ByAlt("open an account")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Url.Contains("promo=explore-service"));
        }

        [Test]
        public void T16_ExploreEnhancements_Tracking_Security()
        {
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl10_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            browser.Image(Find.ByAlt("open an account")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Url.Contains("promo=explore-security"));
        }
    }
}
