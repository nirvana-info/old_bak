using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks.SpringFunnel3.S001_ExploreEnhancements
{
    [TestFixture]
    public class S001_ExploreEnhancements_Module_1 : SignIn
    {
        [Test]
        public void T01_ExploreEnhancements_003_Video()
        {
            browser.GoTo(URL + "/homepages/003.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Element(Find.ById("myObject1")).Exists);
        }

        [Test]
        public void T02_ExploreEnhancements_003_DefaultTab()
        {
            browser.GoTo(URL + "/homepages/003.aspx");
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ById("default-tab")).Click();
            Assert.IsTrue(browser.Element(Find.ById("myObject1")).Exists);
        }

        [Test]
        public void T03_ExploreEnhancements_003_TradingTab()
        {
            browser.GoTo(URL + "/homepages/003.aspx");
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ById("trading-tab")).Click();
            Assert.IsTrue(browser.Element(Find.ById("myObject1")).Exists);
        }

        [Test]
        public void T04_ExploreEnhancements_003_ToolsTab()
        {
            browser.GoTo(URL + "/homepages/003.aspx");
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ById("tools-tab")).Click();
            Assert.IsTrue(browser.Element(Find.ById("myObject1")).Exists);
        }

        [Test]
        public void T05_ExploreEnhancements_003_ServiceTab()
        {
            browser.GoTo(URL + "/homepages/003.aspx");
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ById("service-tab")).Click();
            Assert.IsTrue(browser.Element(Find.ById("myObject1")).Exists);
        }

        [Test]
        public void T06_ExploreEnhancements_003_OffersTab()
        {
            browser.GoTo(URL + "/homepages/003.aspx");
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ById("offers-tab")).Click();
            Assert.IsTrue(browser.Div(Find.ById("offers-poster")).Exists);
        }

        [Test]
        public void T07_ExploreEnhancements_003_ActiveTrader()
        {
            browser.GoTo(URL + "/homepages/003.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Link(Find.ByClass("online-stock-trading")).Exists);
        }

        [Test]
        public void T08_ExploreEnhancements_003_OptionsTrader()
        {
            browser.GoTo(URL + "/homepages/003.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Link(Find.ByClass("online-options-trading")).Exists);
        }

        [Test]
        public void T09_ExploreEnhancements_003_ForexTrader()
        {
            browser.GoTo(URL + "/homepages/003.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Link(Find.ByClass("forex-currency-trading")).Exists);
        }

        [Test]
        public void T10_ExploreEnhancements_003_StockTrades()
        {
            browser.GoTo(URL + "/homepages/003.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Link(Find.ByClass("submitBtn")).Exists);
        }

        [Test]
        public void T11_ExploreEnhancements_003_TransferRefund()
        {
            browser.GoTo(URL + "/homepages/003.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Link(Find.ByClass("submitBtn")).Exists);
        }

        [Test]
        public void T12_ExploreEnhancements_003_ReferFriend()
        {
            browser.GoTo(URL + "/homepages/003.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Link(Find.ByClass("submitBtn")).Exists);
        }

        [Test]
        public void T13_ExploreEnhancements_003_ReferFriendForex()
        {
            browser.GoTo(URL + "/homepages/003.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Link(Find.ByClass("submitBtn")).Exists);
        }

        [Test]
        public void T14_ExploreEnhancements_004_FishEyes()
        {
            browser.GoTo(URL + "/homepages/004.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Div(Find.ById("explore-dock-container")).Exists);
        }

        [Test]
        public void T15_ExploreEnhancements_Service_Video()
        {
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl09_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Element(Find.ById("myObject1")).Exists);
        }

        [Test]
        public void T16_ExploreEnhancements_Tools_Title()
        {
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl08_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.AreEqual(browser.Title.Trim(), "Stock and Options Trading Tools");
        }

        [Test]
        public void T17_ExploreEnhancements_Tools_StockScreener()
        {
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl08_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Button(Find.ByText("Stock Screener")).Exists);
        }

        [Test]
        public void T18_ExploreEnhancements_Tools_StockScreener_Video()
        {
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl08_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Image(Find.ByAlt("Video Tour")).Exists);
        }

        [Test]
        public void T19_ExploreEnhancements_Tools_MutualFundScreener()
        {
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl08_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Button(Find.ByText("Mutual Fund Screener")).Exists);
        }

        [Test]
        public void T20_ExploreEnhancements_Tools_MutualFundScreener_Video()
        {
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl08_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Image(Find.ByAlt("Video Tour")).Exists);
        }
    }
}
