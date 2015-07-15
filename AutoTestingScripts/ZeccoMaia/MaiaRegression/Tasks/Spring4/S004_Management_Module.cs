using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks.Spring4
{
    [TestFixture]
    public class S004_Management_Module : SignIn
    {
        [Test]
        public void T01_Management_ManageUser()
        {
            this.LoginPortalAdmin();
            browser.Div(Find.ById("ctl00_uxMainContent_uxManageUsers")).Link(Find.ByText("Manage Users")).Click();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).WaitUntilExists(10);
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).TypeText("tonyleachsf");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option(Find.ByValue("UserName")).Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();

            Assert.IsTrue(browser.Table(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00")).Exists);
        }

        [Test]
        public void T02_Management_ManageUserPassword()
        {
            this.LoginPortalAdmin();
            browser.Div(Find.ById("ctl00_uxMainContent_uxManageUsers")).Link(Find.ByText("Manage Users")).Click();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).WaitUntilExists(10);
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).TypeText("tonyleachsf");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option(Find.ByValue("UserName")).Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
            browser.WaitForComplete();

            browser.Table(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00")).TableRows[1].TableCells[5].Link(Find.ByText("Edit")).Click();
            browser.WaitForComplete();

            Assert.IsTrue(browser.Link(Find.ByText("Reset Member Password")).Exists);
        }

        [Test]
        public void T03_Management_FormManage()
        {
            this.LoginPortalAdmin();
            browser.Div(Find.ById("ctl00_uxMainContent_uxFormsAdministration")).Link(Find.ByText("Forms Administration")).Click();
            browser.WaitForComplete();

            Assert.IsTrue(browser.Table(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00")).Exists);
        }

        [Test]
        public void T04_Management_NewBlast()
        {
            this.LoginPortalAdmin();
            browser.Div(Find.ById("ctl00_uxMainContent_uxNewBlastMessage")).Link(Find.ByText("New Blast Message")).Click();

            Assert.IsTrue(browser.Button(Find.ByClass("submit-button")).Exists);
        }

        [Test]
        public void T05_Management_NewBlastCreate()
        {
            this.LoginPortalAdmin();
            browser.Div(Find.ById("ctl00_uxMainContent_uxNewBlastMessage")).Link(Find.ByText("New Blast Message")).Click();

            browser.TextField(Find.ById("ctl00_uxMainContent_uxAccount")).TypeText("LwBzAG0AeABudzBe9xVOMbrjjy6kEagANATdwY2HRdA78kfrHSlzfA== ");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxMessageType")).Option(Find.ByValue("134")).Select();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxSubject")).TypeText("ddpg title");
            browser.TextField(Find.ById("ctl00_uxMainContent_uxMessageText")).TypeText("ddpg message");
            browser.Button(Find.ByClass("submit-button")).Click();

            Assert.AreEqual(browser.Div(Find.ById("ctl00_uxMainContent_divSuccess")).Text, "Send Blast Message Success");
        }

        [Test]
        public void T06_Management_SelectRoles()
        {
            this.LoginPortalAdmin();
            browser.Div(Find.ById("ctl00_uxMainContent_uxManageUsers")).Link(Find.ByText("Manage Users")).Click();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).WaitUntilExists(10);
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).TypeText("tonyleachsf");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option(Find.ByValue("UserName")).Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();

            browser.Link(Find.ByText("Roles")).Click();
            browser.Frames[0].Form(Find.ById("form1")).Button(Find.ById("uxSave")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Frames[0].Form(Find.ById("form1")).Span(Find.ById("uxSuccess")).Text.Contains("Thanks"));
        }

        [Test]
        public void T07_Management_NegativeTable()
        {
            this.LoginPortalAdmin();
            browser.Div(Find.ById("ctl00_uxMainContent_uxManageUsers")).Link(Find.ByText("Manage Users")).Click();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).WaitUntilExists(10);
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).TypeText("tonyleachsf");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option(Find.ByValue("UserName")).Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();

            for (int i = 0; i < browser.Table(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00")).TableBodies[0].TableRows.Count; i++)
            {
                if (string.IsNullOrEmpty(browser.Table(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00")).TableBodies[0].TableRows[i].TableCells[2].Text.Trim()) == true)
                {
                    Assert.IsTrue(false);
                    return;
                }
            }
        }

        [Test]
        public void T08_Management_SearchPensonAcct()
        {
            this.LoginPortalAdmin();
            browser.Div(Find.ById("ctl00_uxMainContent_uxManageUsers")).Link(Find.ByText("Manage Users")).Click();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).WaitUntilExists(10);
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).TypeText("71142269");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option(Find.ByValue("PensonAccountNumber")).Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();

            Assert.IsTrue(browser.Table(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00")).Exists);
        }

        [Test]
        public void T09_Management_SearchEmail()
        {
            this.LoginPortalAdmin();
            browser.Div(Find.ById("ctl00_uxMainContent_uxManageUsers")).Link(Find.ByText("Manage Users")).Click();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).WaitUntilExists(10);
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).TypeText("qatestuser");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option(Find.ByValue("PrimaryEmailAddress")).Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();

            Assert.IsTrue(browser.Table(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00")).Exists);
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
