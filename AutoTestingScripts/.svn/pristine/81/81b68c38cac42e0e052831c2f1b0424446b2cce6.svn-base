using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks.Spring3
{
    [TestFixture]
    public class S004_GainsKeeper_Module : SignIn
    {
        [Test]
        public void T01_GainsKeeper_NoAccountVisit()
        {
            UserSignIn(UN1, PW1, false, 0);
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
            //browser.Span(Find.ByText("Trading")).Click();
            //browser.Link(Find.ByTitle("Trading Marketing")).Click();
            Assert.IsTrue(browser.Link(Find.ByText("Open a new trading account")).Exists);
        }

        [Test]
        public void T02_GainsKeeper_NeverAccessTrial()
        {
            UserSignIn(UN2, PW2, false, 3);
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
            //browser.Span(Find.ByText("TOOLS")).Click();
            //browser.Link(Find.ByTitle("Tax")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxTradingGainsKeeper")).Click();
            Assert.IsTrue(browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxGainsKeeperStatus_uxStart")).Exists);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxGainsKeeperStatus_uxStart")).Click();
            browser.WaitForComplete();
            Assert.IsTrue(browser.Link(Find.ByText("Powered by GainsKeeper")).Exists);
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
        }

        [Test]
        public void T03_GainsKeeper_ToSubscribe()
        {
            UserSignIn(UN3, PW3, false, 4);
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
            browser.WaitForComplete();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxTradingGainsKeeper")).Click();
            Assert.IsTrue(browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxGainsKeeperStatus_uxSubscriptionButton_uxSubscribe")).Exists);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxGainsKeeperStatus_uxSubscriptionButton_uxSubscribe")).Click();
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Url.Contains("www.sandbox.paypal.com"));
            browser.Back();
            browser.Back();
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
        }

        [Test]
        public void T04_GainsKeeper_Subscribed()
        {
            this.NavigatePortfolio();
            Assert.IsTrue(browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxGainsKeeperStatus_uxCotinueGK")).Exists);
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
        }

        [Test]
        public void T05_GainsKeeper_ViewSubscriptionStatus()
        {
            this.NavigatePortfolio();
            Assert.IsTrue(browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxCancelGKSubscriptionLink")).Exists);
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
        }

        [Test]
        public void T06_GainsKeeper_Expired()
        {
            UserSignIn("test22", "password", false, 3);
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
            browser.WaitForComplete();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxGainsKeeperLink")).Click();
            Assert.IsTrue(browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxGainsKeeperStatus_uxSubscriptionButton_uxSubscribe")).Exists);
        }

        [Test]
        public void T07_GainsKeeper_Cancel()
        {
            this.NavigatePortfolio();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxCancelGKSubscriptionLink")).WaitUntilExists(10);
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxCancelGKSubscriptionLink")).Click();
            Assert.IsTrue(browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxConfirm")).Exists);
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
        }

        [Test]
        public void T08_GainsKeeper_ModifySetting()
        {
            this.NavigatePortfolio();
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxGainsKeeperStatus_uxCotinueGK")).Click();
        }

        [Test]
        public void T09_GainsKeeper_FSRSeeSubscriptionStatus()
        {
            this.FSRProc();
            Assert.IsTrue(browser.Table(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00")).Exists);
        }

        [Test]
        public void T10_GainsKeeper_FSRDeactiveAccess()
        {
            this.FSRProc();
            browser.Link(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00_ctl04_uxEditSubscription")).Click();
            Assert.IsTrue(browser.Link(Find.ById("ctl00_uxMainContent_uxDeactiveSubscription")).Exists);
        }

        [Test]
        public void T11_GainsKeeper_FSRGrantComplimentary()
        {
            this.FSRProc();
            browser.Link(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00_ctl04_uxEditSubscription")).Click();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxRadDatePicker_dateInput_text")).TypeText(DateTime.Now.AddMonths(2).ToString("yyyy-MM-dd"));
            if (browser.CheckBox(Find.ById("ctl00_uxMainContent_uxComplimentary")).Checked == false)
            {
                browser.CheckBox(Find.ById("ctl00_uxMainContent_uxComplimentary")).Checked = true;
            }
            browser.Button(Find.ById("ctl00_uxMainContent_uxSave")).Click();
            Assert.AreEqual(browser.Span(Find.ById("ctl00_uxMainContent_uxSuccessMessage")).Text, "Thanks! You have successfully updated the member subscription.");
        }

        private void NavigatePortfolio()
        {
            UserSignIn(UN, PW, false, 4);
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
            browser.WaitForComplete();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxGainsKeeperLink")).Click();
        }

        private void FSRProc()
        {
            if (browser.Link(Find.ByText("Sign Out")).Exists)
            {
                SignOut si = new SignOut();
                si.UserSignOut(browser);
            }
            if (browser.Link(Find.ById("ctl00_uxLoginView_uxLoginStatus")).Exists)
            {
                browser.Span(Find.ById("ctl00_uxSiteMapBreadCrumb")).Link(Find.ByText("Portal Admin")).Click();
                browser.Link(Find.ById("ctl00_uxLoginView_uxLoginStatus")).Click();
            }
            browser.GoTo(AdminUrl);
            browser.TextField(Find.ById("ctl00_uxMainContent_uxLogin_UserName")).WaitUntilExists(10);
            browser.TextField(Find.ById("ctl00_uxMainContent_uxLogin_UserName")).TypeText(UN3);
            browser.TextField(Find.ById("ctl00_uxMainContent_uxLogin_Password")).TypeText(PW3);
            browser.Button(Find.ById("ctl00_uxMainContent_uxLogin_LoginButton")).Click();
            browser.WaitForComplete();
            browser.Link(Find.ByText("GainsKeeper-Search")).Click();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxKeyword")).WaitUntilExists(10);
            browser.TextField(Find.ById("ctl00_uxMainContent_uxKeyword")).TypeText(UN2);
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
        }
    }
}
