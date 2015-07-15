using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks.SpringTech1
{
    [TestFixture]
    public class S001_ZapTrade_Module : SignIn
    {
        [Test]
        public void T01_ZapTrade_FeaturedTool()
        {
            UserSignIn(UN, PW, false, 2);
            browser.WaitForComplete();
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl03_uxTopNavLink")).Click();
            browser.WaitForComplete();
            Assert.IsTrue(browser.ContainsText("Featured Tool") && browser.ContainsText("Zap Trade"));
        }

        [Test]
        public void T02_ZapTrade_TradingTool()
        {
            UserSignIn(UN, PW, false, 2);
            browser.WaitForComplete();
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl03_uxTopNavLink")).Click();
            browser.WaitForComplete();
            Assert.IsTrue(browser.Link(Find.ByText("trading tool")).Exists);
        }

        [Test]
        public void T03_ZapTrade_VideoImage()
        {
            UserSignIn(UN, PW, false, 2);
            browser.WaitForComplete();
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl03_uxTopNavLink")).Click();
            browser.WaitForComplete();
            Assert.IsTrue((browser.Div(Find.ByClass("box accountcenterbox center")).Image(Find.ByAlt("Zecco Streamer Tour")).Exists) && 
                (browser.Div(Find.ByClass("box accountcenterbox center")).Image(Find.ByAlt("Zecco Streamer Tour")).Src.
                Contains("https://zecco.s3.amazonaws.com/images/icon_video_zap_trade.jpg")));
        }

        [Test]
        public void T04_ZapTrade_ZapTradeTour()
        {
            UserSignIn(UN, PW, false, 2);
            browser.WaitForComplete();
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl03_uxTopNavLink")).Click();
            browser.WaitForComplete();
            Assert.IsTrue(browser.Link(Find.ByText("Zap Trade Tour")).Exists);
        }

        [Test]
        public void T05_ZapTrade_Download()
        {
            UserSignIn(UN, PW, false, 2);
            browser.WaitForComplete();
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl03_uxTopNavLink")).Click();
            browser.WaitForComplete();
            browser.Link(Find.ByText("trading tool")).Click();
            Assert.IsTrue(browser.Link(Find.ById("uxDownloadInstall")).Exists);
        }

        [Test]
        public void T06_ZapTrade_Terms()
        {
            UserSignIn(UN, PW, false, 2);
            browser.WaitForComplete();
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl03_uxTopNavLink")).Click();
            browser.WaitForComplete();
            browser.Link(Find.ByText("trading tool")).Click();
            browser.WaitForComplete();
            Assert.IsTrue(browser.CheckBox(Find.ById("uxUnderstandTerms")).Exists);
            browser.CheckBox(Find.ById("uxUnderstandTerms")).Checked = true;
            browser.CheckBox(Find.ById("uxUnderstandTerms")).Checked = false;
            Assert.IsTrue(browser.Link(Find.ById("uxDownloadInstall")).Images[0].Src.Contains("https://zecco.s3.amazonaws.com/images/button_download_install_inactive.gif"));
        }

        [Test]
        public void T07_ZapTrade_TermsError()
        {
            UserSignIn(UN, PW, false, 2);
            browser.WaitForComplete();
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl03_uxTopNavLink")).Click();
            browser.WaitForComplete();
            browser.Link(Find.ByText("trading tool")).Click();
            browser.WaitForComplete();
            browser.CheckBox(Find.ById("uxUnderstandTerms")).Checked = true;
            browser.CheckBox(Find.ById("uxUnderstandTerms")).Checked = false;
            Assert.IsTrue(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxUnderstandTermsError")).Text
                .Contains("You must confirm you agree to the Zap Trade software license before you can download"));
        }

        [Test]
        public void T08_ZapTrade_BrowserText()
        {
            UserSignIn(UN, PW, false, 2);
            browser.WaitForComplete();
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl03_uxTopNavLink")).Click();
            browser.WaitForComplete();
            browser.Link(Find.ByText("trading tool")).Click();
            browser.WaitForComplete();
            Assert.IsTrue(browser.Link(Find.ByText("Firefox")).Exists);
        }

        [Test]
        public void T09_ZapTrade_FAQRef()
        {
            UserSignIn(UN, PW, false, 2);
            browser.WaitForComplete();
            browser.Link(Find.ById("uxHelpCenter")).Click();
            browser.WaitForComplete();
            Assert.IsTrue(browser.Link(Find.ByText("Zap Trade")).Exists);
        }

        [Test]
        public void T10_ZapTrade_ZapTradeHome()
        {
            UserSignIn(UN, PW, false, 2);
            browser.WaitForComplete();
            browser.Link(Find.ById("uxHelpCenter")).Click();
            browser.WaitForComplete();
            Assert.IsTrue(browser.Link(Find.ByText("Zap Trade")).Exists);
            browser.WaitForComplete();
            Assert.IsTrue(browser.Link(Find.ByText("Go to Download & Install")).Exists);
        }
    }
}
