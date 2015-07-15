using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks.SpringTech1
{
    [TestFixture]
    public class S005_OutageAdmin_Module : SignIn
    {
        [Test]
        public void T01_OutageAdmin_EnableTrading()
        {
            this.LoginPortalAdmin();
            Assert.IsTrue(browser.RadioButton(Find.ById("ctl00_uxMainContent_uxOutagesRepeater_ctl00_uxOutageEnable_0")).Exists);
        }

        [Test]
        public void T02_OutageAdmin_DisableTrading()
        {
            this.LoginPortalAdmin();
            Assert.IsTrue(browser.RadioButton(Find.ById("ctl00_uxMainContent_uxOutagesRepeater_ctl00_uxOutageEnable_1")).Exists);
        }

        [Test]
        public void T03_OutageAdmin_EnableOLA()
        {
            this.LoginPortalAdmin();
            Assert.IsTrue(browser.RadioButton(Find.ById("ctl00_uxMainContent_uxOutagesRepeater_ctl01_uxOutageEnable_0")).Exists);
        }

        [Test]
        public void T04_OutageAdmin_DisableOLA()
        {
            this.LoginPortalAdmin();
            Assert.IsTrue(browser.RadioButton(Find.ById("ctl00_uxMainContent_uxOutagesRepeater_ctl01_uxOutageEnable_1")).Exists);
        }

        [Test]
        public void T05_OutageAdmin_Save()
        {
            this.LoginPortalAdmin();
            Assert.IsTrue(browser.Button(Find.ById("ctl00_uxMainContent_uxSave")).Exists);
        }

        [Test]
        public void T06_OutageAdmin_Cancel()
        {
            this.LoginPortalAdmin();
            Assert.IsTrue(browser.Button(Find.ById("ctl00_uxMainContent_uxCancel")).Exists);
        }

        [Test]
        public void T07_OutageAdmin_TradingEnableCheck()
        {
            this.LoginPortalAdmin();
            browser.RadioButton(Find.ById("ctl00_uxMainContent_uxOutagesRepeater_ctl00_uxOutageEnable_0")).Checked = true;
            browser.Button(Find.ById("ctl00_uxMainContent_uxSave")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.AreEqual(browser.Span(Find.ById("ctl00_uxMainContent_uxMessageSuccess")).Text, "You have successfully updated outages setting.");
        }

        [Test]
        public void T08_OutageAdmin_TradingDisableCheck()
        {
            this.LoginPortalAdmin();
            browser.RadioButton(Find.ById("ctl00_uxMainContent_uxOutagesRepeater_ctl00_uxOutageEnable_1")).Checked = true;
            browser.Button(Find.ById("ctl00_uxMainContent_uxSave")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.AreEqual(browser.Span(Find.ById("ctl00_uxMainContent_uxMessageSuccess")).Text, "You have successfully updated outages setting.");
        }

        [Test]
        public void T09_OutageAdmin_OLAEnableCheck()
        {
            this.LoginPortalAdmin();
            browser.RadioButton(Find.ById("ctl00_uxMainContent_uxOutagesRepeater_ctl01_uxOutageEnable_0")).Checked = true;
            browser.Button(Find.ById("ctl00_uxMainContent_uxSave")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.AreEqual(browser.Span(Find.ById("ctl00_uxMainContent_uxMessageSuccess")).Text, "You have successfully updated outages setting.");
        }

        [Test]
        public void T10_OutageAdmin_OLADisableCheck()
        {
            this.LoginPortalAdmin();
            browser.RadioButton(Find.ById("ctl00_uxMainContent_uxOutagesRepeater_ctl01_uxOutageEnable_1")).Checked = true;
            browser.Button(Find.ById("ctl00_uxMainContent_uxSave")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.AreEqual(browser.Span(Find.ById("ctl00_uxMainContent_uxMessageSuccess")).Text, "You have successfully updated outages setting.");
        }

        private void LoginPortalAdmin()
        {
            // if there already have a user login, do logout first
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
            browser.WaitForComplete();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxLogin_UserName")).TypeText(UN3);
            browser.TextField(Find.ById("ctl00_uxMainContent_uxLogin_Password")).TypeText(PW3);
            browser.Button(Find.ById("ctl00_uxMainContent_uxLogin_LoginButton")).Click();
            browser.WaitForComplete();
            browser.Div(Find.ById("ctl00_uxMainContent_uxOutages")).Link(Find.ByText("Outages Admin")).Click();
            browser.WaitForComplete();
        }
    }
}
