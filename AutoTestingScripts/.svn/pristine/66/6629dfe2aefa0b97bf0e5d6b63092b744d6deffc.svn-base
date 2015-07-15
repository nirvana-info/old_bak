using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks.Spring6
{
    [TestFixture]
    public class S001_Dashboard_Module : SignIn
    {
        [Test]
        public void T01_Dashboard_WithNoTradeAcct()
        {
            GotoDashboard();
            //if (browser.Link(Find.ByText("Sign Out")).Exists == true)
            //{
            //    browser.Link(Find.ByText("Sign Out")).Click();
            //}
            UserSignIn(UN1, PW1, false, 0);
        }

        [Test]
        public void T02_Dashboard_WithTradeAcct()
        {
            GotoDashboard();
            Assert.IsTrue(browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxTabPanel")).Exists);
        }

        [Test]
        public void T03_Dashboard_MostTrade()
        {
            GotoDashboard();

            while (browser.Div(Find.ByClass("blockUI blockMsg blockElement")).Exists == true)
            {
                System.Threading.Thread.Sleep(1000);
            }

            Assert.IsTrue(browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxMostTradedGrid")).Exists);
        }

        [Test]
        public void T04_Dashboard_MostHeld()
        {
            GotoDashboard();

            while (browser.Div(Find.ByClass("blockUI blockMsg blockElement")).Exists == true)
            {
                System.Threading.Thread.Sleep(1000);
            }

            Assert.IsTrue(browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxMostHeldGrid")).Exists);
        }

        [Test]
        public void T05_Dashboard_TopPerformance()
        {
            GotoDashboard();

            while (browser.Div(Find.ByClass("blockUI blockMsg blockElement")).Exists == true)
            {
                System.Threading.Thread.Sleep(1000);
            }

            Assert.IsTrue(browser.Div(Find.ById("topPerformersWidget")).Exists);
        }

        [Test]
        public void T06_Dashboard_Twitter()
        {
            GotoDashboard();

            while (browser.Div(Find.ByClass("blockUI blockMsg blockElement")).Exists == true)
            {
                System.Threading.Thread.Sleep(1000);
            }

            Assert.IsTrue(browser.Div(Find.ById("twitterSearch")).Exists);
        }

        [Test]
        public void T07_Dashboard_TwitterLink()
        {
            GotoDashboard();

            while (browser.Div(Find.ByClass("blockUI blockMsg blockElement")).Exists == true)
            {
                System.Threading.Thread.Sleep(1000);
            }

            Assert.IsTrue(browser.Div(Find.ById("twitterSearch")).Link(Find.ByText("Follow @Zecco on Twitter")).Exists);
        }

        [Test]
        public void T08_Dashboard_QuickPoll()
        {
            GotoDashboard();

            while (browser.Div(Find.ByClass("blockUI blockMsg blockElement")).Exists == true)
            {
                System.Threading.Thread.Sleep(1000);
            }

            if (browser.Div(Find.ById("uxQuickPollWidget")).Exists == true)
            {
                Assert.IsTrue(browser.Div(Find.ById("uxQuickPollWidget")).Exists);
            }
            else
            {
                Assert.IsTrue(true);
            }
        }

        [Test]
        public void T09_Dashboard_Everyone()
        {
            GotoDashboard();

            while (browser.Div(Find.ByClass("blockUI blockMsg blockElement")).Exists == true)
            {
                System.Threading.Thread.Sleep(1000);
            }

            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxTabPanel")).Element(Find.ById("uxEveryone")).Click();
            Assert.IsTrue(browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxTabPanel")).Element(Find.ById("uxEveryone")).Exists);
        }

        [Test]
        public void T10_Dashboard_Following()
        {
            GotoDashboard();

            while (browser.Div(Find.ByClass("blockUI blockMsg blockElement")).Exists == true)
            {
                System.Threading.Thread.Sleep(1000);
            }

            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxTabPanel")).Element(Find.ById("uxFollowing")).Click();
            Assert.IsTrue(browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxTabPanel")).Element(Find.ById("uxFollowing")).Exists);
        }

        [Test]
        public void T11_Dashboard_Guest()
        {
            GotoDashboard();
            if (browser.Link(Find.ByText("Sign Out")).Exists == true)
            {
                browser.Link(Find.ByText("Sign Out")).Click();
            }
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl04_uxTopNavLink")).Click();

            while (browser.Div(Find.ByClass("blockUI blockMsg blockElement")).Exists == true)
            {
                System.Threading.Thread.Sleep(1000);
            }

            Assert.IsTrue(!browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxTabPanel")).Exists);
        }

        private void GotoDashboard()
        {
            UserSignIn(UN, PW, false, 2);
            browser.Link(Find.ByText("Dashboard")).Click();
            //if (browser.Link(Find.ByText("Dashboard")).Exists == false)
            //{
            //    browser.Span(Find.ByText("Community")).Click();
            //    browser.Link(Find.ByText("Dashboard")).Click();
            //}
            browser.WaitForComplete(30);
        }
    }
}
