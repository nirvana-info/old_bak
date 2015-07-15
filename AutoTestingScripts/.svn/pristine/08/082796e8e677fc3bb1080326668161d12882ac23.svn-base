using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks._2010Spring6
{
    [TestFixture]
    public class S007_ForexMetaTrader_Module : SignIn
    {
        [Test]
        public void T01_ForexMetaTrader_Navigation()
        {
            browser.GoTo(URL);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl05_uxSubNavRepeater_ctl03_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.AreEqual(browser.Link(Find.ByTitle("Meta")).Text.Trim(), "MetaTrader");
            Assert.AreEqual(browser.Link(Find.ByTitle("Trade Forex on MT4")).Text.Trim(), "Trade Forex on MT4");
            Assert.AreEqual(browser.Link(Find.ByTitle("MetaTrader Platform")).Text.Trim(), "MetaTrader Platform");
        }

        [Test]
        public void T02_ForexMetaTrader_MetaTrader4Page()
        {
            browser.GoTo(URL);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl05_uxSubNavRepeater_ctl03_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Image(Find.ByAlt("Zecco logo")).Src.Contains("/logo_forex.jpg"));
            Assert.AreEqual(browser.Title.Trim(), "ForexMetaTrader 4 Platform - Zecco Forex");
            Assert.IsTrue(browser.Div(Find.ByClass("breadcrumb container")).Exists);
            Assert.IsTrue(browser.Image(Find.BySrc("https://zecco.s3.amazonaws.com/images/forex/button_open_metatrader_on.gif")).Exists);
        }

        [Test]
        public void T03_ForexMetaTrader_MT4PricingPage()
        {
            browser.GoTo(URL);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl05_uxSubNavRepeater_ctl03_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ByTitle("Trade Forex on MT4")).Click();
            Assert.IsTrue(browser.Image(Find.ByAlt("Zecco logo")).Src.Contains("/logo_forex.jpg"));
            Assert.AreEqual(browser.Title.Trim(), "MetaTraderForex Pricing – Zecco Forex");
            Assert.IsTrue(browser.Div(Find.ByClass("breadcrumb container")).Exists);
            Assert.IsTrue(browser.Link(Find.ByTitle("Pricing")).Exists);
            browser.Link(Find.ByTitle("Pricing")).Click();
            Assert.IsTrue(browser.Link(Find.ByTitle("Expert Advisors")).Exists);
            browser.Link(Find.ByTitle("Expert Advisors")).Click();
            Assert.IsTrue(browser.Link(Find.ByTitle("MetaCharts")).Exists);
            browser.Link(Find.ByTitle("MetaCharts")).Click();
            Assert.IsTrue(browser.Image(Find.BySrc("https://zecco.s3.amazonaws.com/images/forex/button_open_metatrader_on.gif")).Exists);
        }

        [Test]
        public void T04_ForexMetaTrader_PlatformsPage()
        {
            browser.GoTo(URL);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl05_uxSubNavRepeater_ctl03_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ByTitle("MetaTrader Platform")).Click();
            Assert.IsTrue(browser.Image(Find.ByAlt("Zecco logo")).Src.Contains("/logo_forex.jpg"));
            Assert.AreEqual(browser.Title.Trim(), "MetaTraderMobile – MetaTrader 4 – Zecco Forex");
            Assert.IsTrue(browser.Div(Find.ByClass("breadcrumb container")).Exists);
            Assert.IsTrue(browser.Link(Find.ByTitle("Pricing")).Exists);
            Assert.IsTrue(browser.Image(Find.BySrc("https://zecco.s3.amazonaws.com/images/forex/button_open_metatrader_on.gif")).Exists);
        }

        [Test]
        public void T05_ForexMetaTrader_FTMobilePage()
        {
            browser.GoTo(URL);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl05_uxSubNavRepeater_ctl02_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Link(Find.ByTitle("ForexTrader Mobile")).Exists);
            browser.Link(Find.ByTitle("ForexTrader Mobile")).Click();
            Assert.IsTrue(browser.Image(Find.ByAlt("Zecco logo")).Src.Contains("/logo_forex.jpg"));
            Assert.AreEqual(browser.Title.Trim(), "Mobile Forex Trading and Research – Zecco Forex");
            Assert.IsTrue(browser.Div(Find.ByClass("breadcrumb container")).Exists);
            Assert.IsTrue(browser.Link(Find.ByText("www.zecco.com/forex")).Exists);
        }

        [Test]
        public void T06_ForexMetaTrader_FTDownload()
        {
            browser.GoTo(URL);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl05_uxSubNavRepeater_ctl05_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ByTitle("Download Center")).Click();
            Assert.IsTrue(browser.ContainsText("Zecco Forex MetaTrader 4"));
            Assert.IsTrue(browser.Link(Find.ByText("Details")).Exists);
            Assert.IsTrue(browser.Link(Find.ByText("Download")).Exists);
        }

        [Test]
        public void T07_ForexMetaTrader_MTAccountCenter()
        {
            browser.GoTo(URL);
            UserSignIn(UN, PW, false, 3);
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(20);
            browser.Link(Find.ById("uxAccountCenter")).Click();
            Assert.IsTrue(browser.Link(Find.ByText("My Forex Account")).Exists);
            Assert.IsTrue(browser.Link(Find.ByText("My MetaTrader Account")).Exists);
        }

        [Test]
        public void T08_ForexMetaTrader_PracticeSignUp()
        {
            browser.GoTo(URL);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl05_uxSubNavRepeater_ctl03_uxSubNavLink")).Click();
            browser.Div(Find.ByClass("matetradersignup-box")).WaitUntilExists(20);
            browser.TextField(Find.ById("forex_first_name")).TypeText("kevin");
            browser.TextField(Find.ById("forex_last_name")).TypeText("mei");
            browser.SelectList(Find.ById("forex_country")).Option(Find.ByValue("United States")).Select();
            browser.SelectList(Find.ById("forex_state")).Option(Find.ByValue("Alabama")).Select();
            browser.TextField(Find.ById("forex_phone")).TypeText("9874563210");
            browser.TextField(Find.ById("forex_email")).TypeText("kevin1985@001.com");
            browser.Button(Find.BySrc("https://zecco.s3.amazonaws.com/images/forex/button_open_practice_account_on.gif")).Click();
        }

        [Test]
        public void T09_ForexMetaTrader_PracticeThankYou()
        {
            //It should be from sign up
            browser.GoTo(URL + "/forex/metatrader/practice-confirmation.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Image(Find.ByAlt("Zecco logo")).Src.Contains("/logo_forex.jpg"));
            Assert.AreEqual(browser.Title.Trim(), "Practice Account Confirmation – Zecco Forex");
            Assert.IsTrue(browser.Div(Find.ByClass("breadcrumb container")).Exists);
            Assert.IsTrue(browser.ContainsText("Thank You"));
            Assert.IsTrue(browser.Image(Find.BySrc("https://zecco.s3.amazonaws.com/images/forex/button_download_metatrader_on.gif")).Exists);
        }
    }
}
