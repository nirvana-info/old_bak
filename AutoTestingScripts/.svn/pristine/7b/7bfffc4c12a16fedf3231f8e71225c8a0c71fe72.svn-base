using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks.Spring5
{
    [TestFixture]
    public class S003_Prospect_Module : SignIn
    {
        [Test]
        public void T01_Prospect_ExploreZecco()
        {
            browser.GoTo(URL);
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxTopNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            //browser.Link(Find.ById("default")).Click();
            //verify access zecco page
            Assert.IsTrue(browser.ContainsText("Great Value – No Compromises"));
            Assert.AreEqual(browser.Title.Trim(), "Learn more about Zecco - low cost broker - Zecco Trading");
        }

        [Test]
        public void T02_Prospect_ExplorePricing_Stock()
        {
            browser.GoTo(URL);
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl01_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            //browser.Link(Find.ById("Pricing")).Click();
            //verify access pricing page
            Assert.IsTrue(browser.ContainsText("Low Cost Stock and Options Commissions for Traders"));
            Assert.IsTrue(browser.ContainsText("Online Stock and ETF Trades"));
        }

        [Test]
        public void T03_Prospect_ExplorePricing_Option()
        {
            browser.GoTo(URL);
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl01_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            //browser.Link(Find.ById("Pricing")).Click();
            //verify access pricing page
            Assert.IsTrue(browser.ContainsText("Low Cost Stock and Options Commissions for Traders"));
            browser.Link(Find.ById("options-tab")).Click();
            Assert.IsTrue(browser.ContainsText("Online Options Trades"));
        }

        [Test]
        public void T04_Prospect_ExplorePricing_Forex()
        {
            browser.GoTo(URL);
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl01_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            //browser.Link(Find.ById("Pricing")).Click();
            //verify access pricing page
            Assert.IsTrue(browser.ContainsText("Low Cost Stock and Options Commissions for Traders"));
            browser.Link(Find.ById("forex-tab")).Click();
            Assert.IsTrue(browser.ContainsText("Zecco Forex Plus"));
        }

        [Test]
        public void T05_Prospect_ExplorePricing_Margin()
        {
            browser.GoTo(URL);
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl01_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            //browser.Link(Find.ById("Pricing")).Click();
            //verify access pricing page
            Assert.IsTrue(browser.ContainsText("Low Cost Stock and Options Commissions for Traders"));
            browser.Link(Find.ById("margin-tab")).Click();
            Assert.IsTrue(browser.Link(Find.ByText("margin-tab")).Exists);
        }

        [Test]
        public void T06_Prospect_ExplorePricing_Other()
        {
            browser.GoTo(URL);
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl01_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            //browser.Link(Find.ById("Pricing")).Click();
            //verify access pricing page
            Assert.IsTrue(browser.ContainsText("Low Cost Stock and Options Commissions for Traders"));
            browser.Link(Find.ById("other-tab")).Click();
            Assert.IsTrue(browser.Link(Find.ByText("Fees")).Exists);
        }

        [Test]
        public void T07_Prospect_ExploreProducts()
        {
            browser.GoTo(URL);
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl02_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            //browser.Link(Find.ById("products")).Click();
            //verify access products page
            Assert.IsTrue(browser.ContainsText("Meet Your New Trading Center"));
            Assert.AreEqual(browser.Title.Trim(), "Trading Center Platform - Stock Charts & Research - Zecco Trading ");
        }

        [Test]
        public void T08_Prospect_ExploreStocks()
        {
            browser.GoTo(URL);
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl03_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            //browser.Link(Find.ById("online-stock-trading")).Click();
            //verify access stocks page
            Assert.IsTrue(browser.ContainsText("Unparalleled value for Active Online Stock Traders"));
            Assert.AreEqual(browser.Title.Trim(), "Online stock trading - $4.95 per stock trade - Zecco Trading");
        }

        [Test]
        public void T09_Prospect_ExploreOptions()
        {
            browser.GoTo(URL);
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl04_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            //browser.Link(Find.ById("online-options-trading")).Click();
            //verify access options page
            Assert.IsTrue(browser.ContainsText("One Powerful Options Trading Platform. One Seriously Low Price."));
            Assert.AreEqual(browser.Title.Trim(), "Online options trading - $4.95 per trade & $0.65 per contract - Zecco Trading");
        }

        [Test]
        public void T10_Prospect_ExploreForex()
        {
            browser.GoTo(URL);
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl05_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            //browser.Link(Find.ById("forex-currency-trading")).Click();
            //verify access Forex page
            Assert.IsTrue(browser.ContainsText("The Thrill of Forex and Precious Metals Trading"));
            Assert.AreEqual(browser.Title.Trim(), "Online Forex Trading - Open a Free Practice Forex Account - Zecco Forex");
        }

        [Test]
        public void T11_Prospect_ExploreIRAs()
        {
            browser.GoTo(URL);
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl06_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            //browser.Link(Find.ById("ira")).Click();
            //verify access IRAs page
            Assert.IsTrue(browser.ContainsText("Take Control of Retirement With A Free Stock Trading IRA"));
            Assert.AreEqual(browser.Title.Trim(), "Individual Retirement Accounts - No Minimum - Zecco Trading");
        }

        [Test]
        public void T12_Prospect_ExploreCommunity()
        {
            browser.GoTo(URL);
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl07_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            //browser.Link(Find.ById("community")).Click();
            //verify access Community page
            Assert.IsTrue(browser.ContainsText("Follow Star Performers in the ZeccoShare Community"));
        }

        [Test]
        public void T13_Prospect_ExploreTools()
        {
            browser.GoTo(URL);
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl08_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            //browser.Link(Find.ById("trading-tools")).Click();
            //verify access tools page
            Assert.IsTrue(browser.ContainsText("Trade with Ease Using Zecco's Free Stock Trading Tools"));
            Assert.AreEqual(browser.Title.Trim(), "Free stock trading tools - professional grade - Zecco Trading");
        }

        [Test]
        public void T14_Prospect_ExploreService()
        {
            browser.GoTo(URL);
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl09_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            //browser.Link(Find.ById("customer-service")).Click();
            //verify access service page
            Assert.IsTrue(browser.ContainsText("Fast, Friendly Service – Your Way"));
        }

        [Test]
        public void T15_Prospect_ExploreSecurity()
        {
            browser.GoTo(URL);
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl10_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            //browser.Link(Find.ById("security")).Click();
            //verify access security page
            Assert.IsTrue(browser.ContainsText("Is My Money Safe?"));
        }

        [Test]
        public void T16_Prospect_ExploreWhatsNew()
        {
            browser.GoTo(URL);
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl11_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            //verify access security page
            Assert.AreEqual(browser.Title.Trim(), "What's New at Zecco");
        }
    }
}
