using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks._2010Spring6
{
    [TestFixture]
    public class S002_MobileMarketingPages_Module : SignIn
    {
        [Test]
        public void T01_MobileMarketingPages_Explore()
        {
            browser.GoTo(URL);
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl08_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.ContainsText("Zecco Mobile Lite"));
            Assert.IsTrue(browser.Button(Find.ByText("Zecco Mobile Lite")).Exists);
        }

        [Test]
        public void T02_MobileMarketingPages_WhatsNew()
        {
            browser.GoTo(URL);
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxSubNavRepeater_ctl11_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Link(Find.ByText("Zecco Mobile Lite FAQs")).Exists);
            Assert.IsTrue(browser.Image(Find.BySrc("https://zecco.s3.amazonaws.com/images/quotes_research/button_free_download_on.gif")).Exists);
            Assert.IsTrue(browser.Div(Find.ById("uxWhats_Tabs")).Exists);
            Assert.IsTrue(browser.Div(Find.ById("zecco-mibile")).Exists);
            Assert.IsTrue(browser.Div(Find.ById("zap_trade")).Exists);
            Assert.IsTrue(browser.Div(Find.ById("free_stream")).Exists);
            Assert.IsTrue(browser.Div(Find.ById("advanced_research")).Exists);
            Assert.IsTrue(browser.Div(Find.ById("stock_etf_screener")).Exists);
            Assert.IsTrue(browser.Div(Find.ById("options_research")).Exists);
            Assert.IsTrue(browser.Div(Find.ById("faster_experience")).Exists);
        }

        [Test]
        public void T03_MobileMarketingPages_Tools()
        {
            browser.GoTo(URL);
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl03_uxSubNavRepeater_ctl00_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Image(Find.BySrc("https://zecco.s3.amazonaws.com/images/explore/tools_mobile.png")).Exists);
            Assert.IsTrue(browser.ContainsText("Zecco Mobile Lite"));
        }

        [Test]
        public void T04_MobileMarketingPages_ToolsNav()
        {
            browser.GoTo(URL);
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl03_uxSubNavRepeater_ctl01_uxSubNavLink")).Exists);
        }

        [Test]
        public void T05_MobileMarketingPages_LandingPage()
        {
            browser.GoTo(URL);
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl03_uxSubNavRepeater_ctl01_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Image(Find.BySrc("https://zecco.s3.amazonaws.com/images/mobile/mobile_thumb01.gif")).Exists);
            Assert.IsTrue(browser.Image(Find.BySrc("https://zecco.s3.amazonaws.com/images/mobile/mobile_thumb02.gif")).Exists);
            Assert.IsTrue(browser.Image(Find.BySrc("https://zecco.s3.amazonaws.com/images/mobile/mobile_thumb03.gif")).Exists);
            Assert.IsTrue(browser.Image(Find.BySrc("https://zecco.s3.amazonaws.com/images/mobile/mobile_thumb04.gif")).Exists);
            Assert.IsTrue(browser.Image(Find.BySrc("https://zecco.s3.amazonaws.com/images/mobile/mobile_thumb05.gif")).Exists);
            Assert.IsTrue(browser.Image(Find.BySrc("https://zecco.s3.amazonaws.com/images/mobile/mobile_thumb06.gif")).Exists);
            Assert.IsTrue(browser.Image(Find.BySrc("https://zecco.s3.amazonaws.com/images/mobile/mobile_thumb07.gif")).Exists);
        }

        [Test]
        public void T06_MobileMarketingPages_FAQs()
        {
            browser.GoTo(URL);
            browser.Button(Find.ById("uxHelpCenter")).WaitUntilExists(20);
            browser.Button(Find.ById("uxHelpCenter")).Click();
            browser.Link(Find.ByText("Zecco Mobile Lite")).WaitUntilExists(20);
            browser.Link(Find.ByText("Zecco Mobile Lite")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.ContainsText("Zecco Mobile Lite, Explained"));
            Assert.AreEqual(browser.Title.Trim(), "Zecco Mobile Lite, Explained");
        }
    }
}
