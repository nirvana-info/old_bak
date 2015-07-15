using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks.SpringFunnel3.S001_ExploreEnhancements_Module
{
    [TestFixture]
    public class S001_ExploreEnhancements_Module_2 : SignIn
    {
        [Test]
        public void T01_ExploreEnhancements_Tools_ETFScreener()
        {
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl08_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Button(Find.ByText("ETF Screener")).Exists);
        }

        [Test]
        public void T02_ExploreEnhancements_Tools_ETFScreener_Video()
        {
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl08_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Image(Find.ByAlt("Video Tour")).Exists);
        }

        [Test]
        public void T03_ExploreEnhancements_Tools_OptionBuilder()
        {
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl08_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Button(Find.ByText("Options Strategy Builder")).Exists);
        }

        [Test]
        public void T04_ExploreEnhancements_Tools_OptionBuilder_Video()
        {
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl08_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Image(Find.ByAlt("Video Tour")).Exists);
        }


        [Test]
        public void T05_ExploreEnhancements_Tools_ResearchReport()
        {
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl08_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Button(Find.ByText("Quotes &amp; Research")).Exists);
        }

        [Test]
        public void T06_ExploreEnhancements_Tools_ResearchReport_Video()
        {
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl08_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Image(Find.ByAlt("Video Tour")).Exists);
        }

        [Test]
        public void T07_ExploreEnhancements_Tools_InteractiveCharts()
        {
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl08_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Button(Find.ByText("Quotes &amp; Research")).Exists);
        }

        [Test]
        public void T08_ExploreEnhancements_Tools_InteractiveCharts_Video()
        {
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl08_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Image(Find.ByAlt("Video Tour")).Exists);
        }

        [Test]
        public void T09_ExploreEnhancements_Tools_USMarket()
        {
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl08_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Button(Find.ByText("U.S. Markets Overview")).Exists);
        }

        [Test]
        public void T10_ExploreEnhancements_Tools_GainsKeeper()
        {
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl08_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Button(Find.ByText("Gainskeeper")).Exists);
        }

        [Test]
        public void T11_ExploreEnhancements_Tools_TradingDashboard()
        {
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl08_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Link(Find.ByText("Trading Dashboard Screenshot")).Exists);
        }

        [Test]
        public void T12_ExploreEnhancements_Tools_ZapTrade()
        {
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl08_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Button(Find.ByText("Zap Trade")).Exists);
        }

        [Test]
        public void T13_ExploreEnhancements_Tools_ZapTrade_Video()
        {
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl08_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Image(Find.ByAlt("Video Tour")).Exists);
        }

        [Test]
        public void T14_ExploreEnhancements_Tools_ZeccoSreamer()
        {
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl08_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Button(Find.ByText("Zecco Streamer")).Exists);
        }

        [Test]
        public void T15_ExploreEnhancements_Tools_ZeccoSreamer_Video()
        {
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl08_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Image(Find.ByAlt("Video Tour")).Exists);
        }

        [Test]
        public void T16_ExploreEnhancements_Tools_AlertCenter()
        {
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl08_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Button(Find.ByText("Alerts Center")).Exists);
        }

        [Test]
        public void T17_ExploreEnhancements_Tools_Newsletters()
        {
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl08_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Link(Find.ByText("View previous newsletters")).Exists);
        }

        [Test]
        public void T18_ExploreEnhancements_Stocks_TryStreamer_Video()
        {
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl03_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Image(Find.ByAlt("Video Tour")).Exists);
        }

        [Test]
        public void T19_ExploreEnhancements_Stocks_TryStreamer()
        {
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl03_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Button(Find.ByValue("Try Streamer")).Exists);
        }

        [Test]
        public void T20_ExploreEnhancements_Stocks_FreeDownload_Video()
        {
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl03_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Image(Find.ByAlt("Video Tour")).Exists);
        }

        [Test]
        public void T21_ExploreEnhancements_Stocks_FreeDownload()
        {
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl03_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Button(Find.ByValue("Free Download")).Exists);
        }
    }
}
