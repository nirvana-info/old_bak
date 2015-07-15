using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks.SpringFunnel3
{
    [TestFixture]
    public class S002_EmailUnsubscribes_Module : SignIn
    {
        [Test]
        public void T01_EmailUnsubscribes_PortalMarketing()
        {
            UserSignIn(UN, PW, false, 3);
            browser.WaitForComplete();
            browser.Link(Find.ByText("Manage email and alerts settings")).Click();
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSaveChange")).WaitUntilExists(20);
            Assert.IsTrue(browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNotificationList_uxMarketingEmailsCheckbox")).Exists);
        }

        [Test]
        public void T02_EmailUnsubscribes_PortalSurvey()
        {
            UserSignIn(UN, PW, false, 3);
            browser.WaitForComplete();
            browser.Link(Find.ByText("Manage email and alerts settings")).Click();
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSaveChange")).WaitUntilExists(20);
            Assert.IsTrue(browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNotificationList_uxUserSurveysCheckbox")).Exists);
        }

        [Test]
        public void T03_EmailUnsubscribes_PortalAlerts()
        {
            UserSignIn(UN, PW, false, 3);
            browser.WaitForComplete();
            browser.Link(Find.ByText("Manage email and alerts settings")).Click();
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSaveChange")).WaitUntilExists(20);
            Assert.IsTrue(browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNotificationList_uxAlertsCheckbox")).Exists);
        }

        [Test]
        public void T04_EmailUnsubscribes_PortalCustomerMessage()
        {
            UserSignIn(UN, PW, false, 3);
            browser.WaitForComplete();
            browser.Link(Find.ByText("Manage email and alerts settings")).Click();
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSaveChange")).WaitUntilExists(20);
            Assert.IsTrue(browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNotificationList_uxServiceCheckBox")).Exists);
        }

        [Test]
        public void T05_EmailUnsubscribes_PortalStatements()
        {
            UserSignIn(UN, PW, false, 3);
            browser.WaitForComplete();
            browser.Link(Find.ByText("Manage email and alerts settings")).Click();
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSaveChange")).WaitUntilExists(20);
            Assert.IsTrue(browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNotificationList_uxStatements")).Exists);
        }

        [Test]
        public void T06_EmailUnsubscribes_PortalConfirmations()
        {
            UserSignIn(UN, PW, false, 3);
            browser.WaitForComplete();
            browser.Link(Find.ByText("Manage email and alerts settings")).Click();
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSaveChange")).WaitUntilExists(20);
            Assert.IsTrue(browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNotificationList_uxConfirmations")).Exists);
        }

        [Test]
        public void T07_EmailUnsubscribes_SaveSuccess()
        {
            UserSignIn(UN, PW, false, 3);
            browser.WaitForComplete();
            browser.Link(Find.ByText("Manage email and alerts settings")).Click();
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSaveChange")).WaitUntilExists(20);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSaveChange")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSuccessMessage")).Exists);
        }

        [Test]
        public void T08_EmailUnsubscribes_AdminMarketing()
        {
            this.GotoAdmin();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).WaitUntilExists(10);
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).TypeText("tonyleachsf");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option(Find.ByValue("UserName")).Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
            browser.WaitForComplete();
            browser.Table(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00")).TableRows[1].TableCells[5].Link(Find.ByText("Edit")).Click();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSave")).WaitUntilExists();
            Assert.IsTrue(browser.CheckBox(Find.ById("ctl00_uxMainContent_uxNewIsAcceptingMarketingEmail")).Exists);
        }

        [Test]
        public void T09_EmailUnsubscribes_AdminSurvey()
        {
            this.GotoAdmin();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).WaitUntilExists(10);
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).TypeText("tonyleachsf");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option(Find.ByValue("UserName")).Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
            browser.WaitForComplete();
            browser.Table(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00")).TableRows[1].TableCells[5].Link(Find.ByText("Edit")).Click();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSave")).WaitUntilExists();
            Assert.IsTrue(browser.CheckBox(Find.ById("ctl00_uxMainContent_uxNewIsAcceptingSurveyEmail")).Exists);
        }

        [Test]
        public void T10_EmailUnsubscribes_AdminAlerts()
        {
            this.GotoAdmin();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).WaitUntilExists(10);
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).TypeText("tonyleachsf");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option(Find.ByValue("UserName")).Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
            browser.WaitForComplete();
            browser.Table(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00")).TableRows[1].TableCells[5].Link(Find.ByText("Edit")).Click();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSave")).WaitUntilExists();
            Assert.IsTrue(browser.CheckBox(Find.ById("ctl00_uxMainContent_uxNewIsAcceptingCommunityAlerts")).Exists);
        }

        [Test]
        public void T11_EmailUnsubscribes_AdminCustomerMessage()
        {
            this.GotoAdmin();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).WaitUntilExists(10);
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).TypeText("tonyleachsf");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option(Find.ByValue("UserName")).Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
            browser.WaitForComplete();
            browser.Table(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00")).TableRows[1].TableCells[5].Link(Find.ByText("Edit")).Click();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSave")).WaitUntilExists();
            Assert.IsTrue(browser.CheckBox(Find.ById("ctl00_uxMainContent_uxNewIsAcceptingServiceEmail")).Exists);
        }

        [Test]
        public void T12_EmailUnsubscribes_AdminStatements()
        {
            this.GotoAdmin();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).WaitUntilExists(10);
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).TypeText("tonyleachsf");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option(Find.ByValue("UserName")).Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
            browser.WaitForComplete();
            browser.Table(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00")).TableRows[1].TableCells[5].Link(Find.ByText("Edit")).Click();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSave")).WaitUntilExists();
            Assert.IsTrue(browser.Element(Find.ById("ctl00_uxMainContent_uxStatementsHolder")).Exists);
        }

        [Test]
        public void T13_EmailUnsubscribes_AdminConfirmations()
        {
            this.GotoAdmin();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).WaitUntilExists(10);
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).TypeText("tonyleachsf");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option(Find.ByValue("UserName")).Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
            browser.WaitForComplete();
            browser.Table(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00")).TableRows[1].TableCells[5].Link(Find.ByText("Edit")).Click();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSave")).WaitUntilExists();
            Assert.IsTrue(browser.Element(Find.ById("ctl00_uxMainContent_uxConfirmationsHolder")).Exists);
        }

        [Test]
        public void T14_EmailUnsubscribes_UpdatePortal2Admin()
        {
            if (browser.Link(Find.ById("ctl00_uxLoginView_uxLoginStatus")).Exists)
            {
                browser.Span(Find.ById("ctl00_uxSiteMapBreadCrumb")).Link(Find.ByText("Portal Admin")).Click();
                browser.Link(Find.ById("ctl00_uxLoginView_uxLoginStatus")).Click();
            }
            browser.GoTo(URL);
            browser.WaitForComplete();

            UserSignIn(UN, PW, false, 3);
            browser.Link(Find.ByText("Manage email and alerts settings")).Click();
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSaveChange")).WaitUntilExists(20);
            browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNotificationList_uxMarketingEmailsCheckbox")).Checked = true;
            browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNotificationList_uxUserSurveysCheckbox")).Checked = true;
            browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNotificationList_uxAlertsCheckbox")).Checked = true;
            browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNotificationList_uxServiceCheckBox")).Checked = true;
            browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNotificationList_uxStatements")).Checked = true;
            browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNotificationList_uxConfirmations")).Checked = true;
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSaveChange")).Click();
            System.Threading.Thread.Sleep(2000);

            this.GotoAdmin();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).WaitUntilExists(10);
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).TypeText("tonyleachsf");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option(Find.ByValue("UserName")).Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
            browser.WaitForComplete();
            browser.Table(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00")).TableRows[1].TableCells[5].Link(Find.ByText("Edit")).Click();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSave")).WaitUntilExists();
            Assert.IsTrue(browser.CheckBox(Find.ById("ctl00_uxMainContent_uxNewIsAcceptingMarketingEmail")).Checked);
            Assert.IsTrue(browser.CheckBox(Find.ById("ctl00_uxMainContent_uxNewIsAcceptingSurveyEmail")).Checked);
            Assert.IsTrue(browser.CheckBox(Find.ById("ctl00_uxMainContent_uxNewIsAcceptingCommunityAlerts")).Checked);
            Assert.IsTrue(browser.CheckBox(Find.ById("ctl00_uxMainContent_uxNewIsAcceptingServiceEmail")).Checked);
            Assert.IsTrue(browser.CheckBox(Find.ById("ctl00_uxMainContent_uxStatementsHolder")).Checked);
            Assert.IsTrue(browser.CheckBox(Find.ById("ctl00_uxMainContent_uxConfirmationsHolder")).Checked);
        }

        [Test]
        public void T15_EmailUnsubscribes_UpdateAdmin2Portal()
        {
            this.GotoAdmin();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).WaitUntilExists(10);
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).TypeText("tonyleachsf");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option(Find.ByValue("UserName")).Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
            browser.WaitForComplete();
            browser.Table(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00")).TableRows[1].TableCells[5].Link(Find.ByText("Edit")).Click();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSave")).WaitUntilExists();
            browser.CheckBox(Find.ById("ctl00_uxMainContent_uxNewIsAcceptingMarketingEmail")).Checked = false;
            browser.CheckBox(Find.ById("ctl00_uxMainContent_uxNewIsAcceptingSurveyEmail")).Checked = false;
            browser.CheckBox(Find.ById("ctl00_uxMainContent_uxNewIsAcceptingCommunityAlerts")).Checked = false;
            browser.CheckBox(Find.ById("ctl00_uxMainContent_uxNewIsAcceptingServiceEmail")).Checked = false;
            browser.CheckBox(Find.ById("ctl00_uxMainContent_uxStatementsHolder")).Checked = false;
            browser.CheckBox(Find.ById("ctl00_uxMainContent_uxConfirmationsHolder")).Checked = false;
            browser.Button(Find.ById("ctl00_uxMainContent_uxSave")).Click();
            System.Threading.Thread.Sleep(2000);

            if (browser.Link(Find.ById("ctl00_uxLoginView_uxLoginStatus")).Exists)
            {
                browser.Span(Find.ById("ctl00_uxSiteMapBreadCrumb")).Link(Find.ByText("Portal Admin")).Click();
                browser.Link(Find.ById("ctl00_uxLoginView_uxLoginStatus")).Click();
            }
            browser.GoTo(URL);
            browser.WaitForComplete();

            UserSignIn(UN, PW, false, 3);
            browser.Link(Find.ByText("Manage email and alerts settings")).Click();
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSaveChange")).WaitUntilExists(20);
            Assert.IsTrue(!browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNotificationList_uxMarketingEmailsCheckbox")).Checked);
            Assert.IsTrue(!browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNotificationList_uxUserSurveysCheckbox")).Checked);
            Assert.IsTrue(!browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNotificationList_uxAlertsCheckbox")).Checked);
            Assert.IsTrue(!browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNotificationList_uxServiceCheckBox")).Checked);
            Assert.IsTrue(!browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNotificationList_uxStatements")).Checked);
            Assert.IsTrue(!browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNotificationList_uxConfirmations")).Checked);
        }

        private void GotoAdmin()
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
            browser.Div(Find.ById("ctl00_uxMainContent_uxManageUsers")).Link(Find.ByText("Manage Users")).Click();
            browser.WaitForComplete();
        }
    }
}
