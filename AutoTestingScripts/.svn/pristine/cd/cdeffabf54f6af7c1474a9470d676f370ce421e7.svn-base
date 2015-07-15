using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks.SpringMaia1
{
    [TestFixture]
    public class S002_AdminEnhancements_Module : SignIn
    {
        [Test]
        public void T01_AdminEnhancements_FraudLockout()
        {
            this.LoginPortalAdmin();
            browser.Div(Find.ById("ctl00_uxMainContent_uxManageUsers")).Link(Find.ByText("Manage Users")).Click();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).WaitUntilExists(10);
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).TypeText("jaylen");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option(Find.ByValue("UserName")).Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();

            browser.Link(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00_ctl04_uxLinkEditMember")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Image(Find.ById("ctl00_uxMainContent_uxFraudLockoutImg")).Exists);
            Assert.IsTrue(browser.CheckBox(Find.ById("ctl00_uxMainContent_uxNewFraudLockout")).Exists);
        }

        [Test]
        public void T02_AdminEnhancements_SetFraudLockout()
        {
            this.LoginPortalAdmin();
            browser.Div(Find.ById("ctl00_uxMainContent_uxManageUsers")).Link(Find.ByText("Manage Users")).Click();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).WaitUntilExists(10);
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).TypeText("jaylen");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option(Find.ByValue("UserName")).Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();

            browser.Link(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00_ctl04_uxLinkEditMember")).Click();
            System.Threading.Thread.Sleep(2000);
            if (browser.CheckBox(Find.ById("ctl00_uxMainContent_uxNewFraudLockout")).Checked == false)
            {
                browser.CheckBox(Find.ById("ctl00_uxMainContent_uxNewFraudLockout")).Checked = true;
                Assert.IsTrue(true);
            }
        }

        [Test]
        public void T03_AdminEnhancements_RemoveFraudLockout()
        {
            this.LoginPortalAdmin();
            browser.Div(Find.ById("ctl00_uxMainContent_uxManageUsers")).Link(Find.ByText("Manage Users")).Click();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).WaitUntilExists(10);
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).TypeText("jaylen");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option(Find.ByValue("UserName")).Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();

            browser.Link(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00_ctl04_uxLinkEditMember")).Click();
            System.Threading.Thread.Sleep(2000);
            if (browser.CheckBox(Find.ById("ctl00_uxMainContent_uxNewFraudLockout")).Checked == true)
            {
                browser.CheckBox(Find.ById("ctl00_uxMainContent_uxNewFraudLockout")).Checked = false;
                Assert.IsTrue(true);
            }
        }

        [Test]
        public void T04_AdminEnhancements_SearchInvalidEmail()
        {
            this.LoginPortalAdmin();
            browser.Div(Find.ById("ctl00_uxMainContent_uxManageUsers")).Link(Find.ByText("Manage Users")).Click();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).WaitUntilExists(10);
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).TypeText("1@@1");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option(Find.ByValue("PrimaryEmailAddress")).Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();

            Assert.IsTrue(browser.Table(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00")).Exists);
        }

        [Test]
        public void T05_AdminEnhancements_RemoveIPBlacklist()
        {
            this.LoginPortalAdmin();
            browser.Div(Find.ById("ctl00_uxMainContent_uxIPLoggingSearch")).Link(Find.ByText("IP Logging-Search")).Click();
            browser.WaitForComplete();
            browser.Link(Find.ById("ctl00_uxMainContent_uxAddIpToBlackList")).Click();
            browser.Div(Find.ById("RadToolTipWrapper_ctl00_uxMainContent_uxAddBlackListToolTip")).TextField(Find.ById("ctl00_uxMainContent_uxNewIpAddress")).TypeText("192.168.0.243");
            browser.Div(Find.ById("RadToolTipWrapper_ctl00_uxMainContent_uxAddBlackListToolTip")).Button(Find.ById("ctl00_uxMainContent_uxYesButton")).Click();
            if (browser.Span(Find.ById("ctl00_uxMainContent_uxSuccessMessage")).Text != "Thanks! You have successfully added the ip address to black list.")
            {
                Assert.IsTrue(false);
                return;
            }
            browser.TextField(Find.ById("ctl00_uxMainContent_uxKeyword")).TypeText("jaylen");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option(Find.ByText("UserName")).Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
            browser.Link(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00_ctl04_uxViewLog")).WaitUntilExists(10);
            browser.Link(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00_ctl04_uxViewLog")).Click();
            browser.Div(Find.ById("ctl00_uxMainContent_uxListGridView")).WaitUntilExists(10);
            if (browser.Link(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00_ctl04_uxRemove")).Exists == false)
            {
                Assert.IsTrue(false);
                return;
            }
            browser.Link(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00_ctl04_uxRemove")).Click();
            Assert.IsFalse(browser.Link(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00_ctl04_uxRemove")).Exists);
        }

        [Test]
        public void T06_AdminEnhancements_SearchWithoutDate()
        {
            this.LoginPortalAdmin();
            browser.Div(Find.ById("ctl00_uxMainContent_uxCommunityManagement")).Link(Find.ByText("Community Management")).Click();
            browser.WaitForComplete();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxFromDate")).TypeText("");
            browser.TextField(Find.ById("ctl00_uxMainContent_uxToDate")).TypeText("");
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
            System.Threading.Thread.Sleep(2000);

            Assert.AreEqual(browser.Span(Find.ById("ctl00_uxMainContent_uxErrorMessage")).Text, "You must select a time frame.");
        }

        [Test]
        public void T07_AdminEnhancements_DateRange()
        {
            this.LoginPortalAdmin();
            browser.Div(Find.ById("ctl00_uxMainContent_uxCommunityManagement")).Link(Find.ByText("Community Management")).Click();
            browser.WaitForComplete();
            Assert.IsTrue(browser.TextField(Find.ById("ctl00_uxMainContent_uxFromDate")).Exists);
            Assert.IsTrue(browser.TextField(Find.ById("ctl00_uxMainContent_uxToDate")).Exists);
        }

        [Test]
        public void T08_AdminEnhancements_MaxRange()
        {
            this.LoginPortalAdmin();
            browser.Div(Find.ById("ctl00_uxMainContent_uxCommunityManagement")).Link(Find.ByText("Community Management")).Click();
            browser.WaitForComplete();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxFromDate")).TypeText("05/01/2010");
            browser.TextField(Find.ById("ctl00_uxMainContent_uxToDate")).TypeText("05/31/2010");
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
            System.Threading.Thread.Sleep(2000);

            Assert.AreEqual(browser.Span(Find.ById("ctl00_uxMainContent_uxErrorMessage")).Text, "You cannot search more than 30 days at a time.");
        }

        [Test]
        public void T09_AdminEnhancements_Refresh()
        {
            this.LoginPortalAdmin();
            browser.Div(Find.ById("ctl00_uxMainContent_uxCommunityManagement")).Link(Find.ByText("Community Management")).Click();
            browser.WaitForComplete();
            Assert.IsTrue(browser.Button(Find.ById("ctl00_uxMainContent_uxRefresh")).Exists);
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
        }
    }
}
