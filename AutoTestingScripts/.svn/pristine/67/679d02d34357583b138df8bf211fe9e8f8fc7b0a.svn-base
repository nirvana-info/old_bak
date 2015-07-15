using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks._2010Spring4
{
    [TestFixture]
    public class S001_PrivacyPolicy_Module : SignIn
    {
        [Test]
        public void T01_PrivacyPolicy_PrivacySettingPage()
        {
            UserSignIn(UN, PW, false, 3);
            browser.GoTo(URL + "/privacy-settings.aspx");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxbtnSave")).WaitUntilExists();
            Assert.IsTrue(browser.Image(Find.ById("Branding")).Exists);
            Assert.AreEqual(browser.Title.Trim(), "Privacy Settings");
        }

        [Test]
        public void T02_PrivacyPolicy_PrivacySettingBody()
        {
            UserSignIn(UN, PW, false, 3);
            browser.GoTo(URL + "/privacy-settings.aspx");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxbtnSave")).WaitUntilExists();
            Assert.IsTrue(browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxBreadcrumbTrail_uxTopLevel")).Exists);
        }

        [Test]
        public void T03_PrivacyPolicy_FormLink()
        {
            UserSignIn(UN, PW, false, 3);
            browser.GoTo(URL + "/privacy-settings.aspx");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxbtnSave")).WaitUntilExists();
            Assert.IsTrue(browser.Link(Find.ByText("privacy policy")).Exists);
        }

        [Test]
        public void T04_PrivacyPolicy_CreditWorthiness()
        {
            UserSignIn(UN, PW, false, 3);
            browser.GoTo(URL + "/privacy-settings.aspx");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxbtnSave")).WaitUntilExists();
            Assert.IsTrue(browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNotShareCreditworthiness")).Exists);
        }

        [Test]
        public void T05_PrivacyPolicy_PersonalInfo()
        {
            UserSignIn(UN, PW, false, 3);
            browser.GoTo(URL + "/privacy-settings.aspx");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxbtnSave")).WaitUntilExists();
            Assert.IsTrue(browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNotSharePersonalInfo")).Exists);
        }

        [Test]
        public void T06_PrivacyPolicy_OptIn()
        {
            UserSignIn(UN, PW, false, 3);
            browser.Link(Find.ByText("Manage email and alerts settings")).Click();
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSaveChange")).WaitUntilExists(20);
            browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNotificationList_uxMarketingEmailsCheckbox")).Checked = true;
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSaveChange")).Click();
            System.Threading.Thread.Sleep(2000);

            browser.GoTo(URL + "/privacy-settings.aspx");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxbtnSave")).WaitUntilExists();
            Assert.IsTrue(!browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNotShareCreditworthiness")).Checked);
            Assert.IsTrue(!browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNotSharePersonalInfo")).Checked);
        }

        [Test]
        public void T07_PrivacyPolicy_OptOutCreditWorthiness()
        {
            UserSignIn(UN, PW, false, 3);
            browser.GoTo(URL + "/privacy-settings.aspx");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxbtnSave")).WaitUntilExists();
            browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNotShareCreditworthiness")).Checked = true;
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxbtnSave")).Click();
            System.Threading.Thread.Sleep(2000);

            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxBreadcrumbTrail_uxTopLevel")).Click();
            browser.Link(Find.ByText("Manage email and alerts settings")).Click();
            Assert.IsTrue(!browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNotificationList_uxMarketingEmailsCheckbox")).Checked);
        }

        [Test]
        public void T08_PrivacyPolicy_OptOutPersonalInfo()
        {
            UserSignIn(UN, PW, false, 3);
            browser.GoTo(URL + "/privacy-settings.aspx");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxbtnSave")).WaitUntilExists();
            browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNotSharePersonalInfo")).Checked = true;
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxbtnSave")).Click();
            System.Threading.Thread.Sleep(2000);

            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxBreadcrumbTrail_uxTopLevel")).Click();
            browser.Link(Find.ByText("Manage email and alerts settings")).Click();
            Assert.IsTrue(!browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNotificationList_uxMarketingEmailsCheckbox")).Checked);
        }

        [Test]
        public void T09_PrivacyPolicy_AdminCreditWorthiness()
        {
            this.GotoAdmin();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).WaitUntilExists(10);
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).TypeText("tonyleachsf");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option(Find.ByValue("UserName")).Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
            browser.WaitForComplete();
            browser.Table(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00")).TableRows[1].TableCells[5].Link(Find.ByText("Edit")).Click();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSave")).WaitUntilExists();
            Assert.IsTrue(browser.CheckBox(Find.ById("ctl00_uxMainContent_uxNewIsAllowsSharingCreditworthiness")).Exists);
        }

        [Test]
        public void T10_PrivacyPolicy_AdminPersonalInfo()
        {
            this.GotoAdmin();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).WaitUntilExists(10);
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).TypeText("tonyleachsf");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option(Find.ByValue("UserName")).Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
            browser.WaitForComplete();
            browser.Table(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00")).TableRows[1].TableCells[5].Link(Find.ByText("Edit")).Click();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSave")).WaitUntilExists();
            Assert.IsTrue(browser.CheckBox(Find.ById("ctl00_uxMainContent_uxNewIsAllowsSharingPersonalInfo")).Exists);
        }

        [Test]
        public void T11_PrivacyPolicy_AdminOptIn()
        {
            this.GotoAdmin();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).WaitUntilExists(10);
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).TypeText("tonyleachsf");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option(Find.ByValue("UserName")).Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
            browser.WaitForComplete();
            browser.Table(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00")).TableRows[1].TableCells[5].Link(Find.ByText("Edit")).Click();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSave")).WaitUntilExists();

            browser.CheckBox(Find.ById("ctl00_uxMainContent_uxNewIsAcceptingMarketingEmail")).Checked = true;
            System.Threading.Thread.Sleep(1000);
            Assert.IsTrue(browser.CheckBox(Find.ById("ctl00_uxMainContent_uxNewIsAllowsSharingCreditworthiness")).Checked);
            Assert.IsTrue(browser.CheckBox(Find.ById("ctl00_uxMainContent_uxNewIsAllowsSharingPersonalInfo")).Checked);
        }

        [Test]
        public void T12_PrivacyPolicy_AdminOptOutCreditWorthiness()
        {
            this.GotoAdmin();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).WaitUntilExists(10);
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).TypeText("tonyleachsf");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option(Find.ByValue("UserName")).Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
            browser.WaitForComplete();
            browser.Table(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00")).TableRows[1].TableCells[5].Link(Find.ByText("Edit")).Click();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSave")).WaitUntilExists();

            browser.CheckBox(Find.ById("ctl00_uxMainContent_uxNewIsAllowsSharingCreditworthiness")).Checked = false;
            System.Threading.Thread.Sleep(1000);
            Assert.IsTrue(!browser.CheckBox(Find.ById("ctl00_uxMainContent_uxNewIsAcceptingMarketingEmail")).Checked);
        }

        [Test]
        public void T13_PrivacyPolicy_AdminOptOutPersonalInfo()
        {
            this.GotoAdmin();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).WaitUntilExists(10);
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).TypeText("tonyleachsf");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option(Find.ByValue("UserName")).Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
            browser.WaitForComplete();
            browser.Table(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00")).TableRows[1].TableCells[5].Link(Find.ByText("Edit")).Click();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSave")).WaitUntilExists();

            browser.CheckBox(Find.ById("ctl00_uxMainContent_uxNewIsAllowsSharingPersonalInfo")).Checked = false;
            System.Threading.Thread.Sleep(1000);
            Assert.IsTrue(!browser.CheckBox(Find.ById("ctl00_uxMainContent_uxNewIsAcceptingMarketingEmail")).Checked);
        }

        [Test]
        public void T14_PrivacyPolicy_UpdateAdmin2Portal()
        {
            this.GotoAdmin();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).WaitUntilExists(10);
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).TypeText("tonyleachsf");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option(Find.ByValue("UserName")).Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
            browser.WaitForComplete();
            browser.Table(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00")).TableRows[1].TableCells[5].Link(Find.ByText("Edit")).Click();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSave")).WaitUntilExists();
            browser.CheckBox(Find.ById("ctl00_uxMainContent_uxNewIsAllowsSharingCreditworthiness")).Checked = true;
            browser.CheckBox(Find.ById("ctl00_uxMainContent_uxNewIsAllowsSharingPersonalInfo")).Checked = true;
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
            browser.GoTo(URL + "/privacy-settings.aspx");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxbtnSave")).WaitUntilExists();
            Assert.IsTrue(!browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNotShareCreditworthiness")).Exists);
            Assert.IsTrue(!browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNotSharePersonalInfo")).Exists);
        }

        [Test]
        public void T15_PrivacyPolicy_UpdatePortal2Admin()
        {
            UserSignIn(UN, PW, false, 3);
            browser.GoTo(URL + "/privacy-settings.aspx");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxbtnSave")).WaitUntilExists();
            browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNotShareCreditworthiness")).Checked = true;
            browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNotSharePersonalInfo")).Checked = true;
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxbtnSave")).Click();
            System.Threading.Thread.Sleep(2000);

            this.GotoAdmin();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).WaitUntilExists(10);
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).TypeText("tonyleachsf");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option(Find.ByValue("UserName")).Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
            browser.WaitForComplete();
            browser.Table(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00")).TableRows[1].TableCells[5].Link(Find.ByText("Edit")).Click();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSave")).WaitUntilExists();
            Assert.IsTrue(!browser.CheckBox(Find.ById("ctl00_uxMainContent_uxNewIsAllowsSharingCreditworthiness")).Checked);
            Assert.IsTrue(!browser.CheckBox(Find.ById("ctl00_uxMainContent_uxNewIsAllowsSharingPersonalInfo")).Checked);
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
