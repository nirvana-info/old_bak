using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks.Spring3
{
    [TestFixture]
    public class S002_IPLogging_Module : SignIn
    {
        [Test]
        public void T01_IPLogging_ListCustomer()
        {
            this.LoginPortalAdmin();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxKeyword")).TypeText("tonyleachsf");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option(Find.ByValue("1")).Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();

            Assert.IsTrue(browser.Table(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00")).Exists);
            //browser.Link(Find.ById("ctl00_uxMainContent_uxExportToCSV")).Click();
        }

        [Test]
        public void T02_IPLogging_CustomerView()
        {
            this.LoginPortalAdmin();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxKeyword")).TypeText("tonyleachsf");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option(Find.ByValue("1")).Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();

            browser.Link(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00_ctl04_uxViewLog")).Click();
            Assert.IsTrue(browser.ContainsText("First Use Date"));
        }

        [Test]
        public void T03_IPLogging_ListHistory()
        {
            this.LoginPortalAdmin();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxKeyword")).TypeText("tonyleachsf");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option(Find.ByValue("1")).Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
        }

        [Test]
        public void T04_IPLogging_HistoryView()
        {
            this.LoginPortalAdmin();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxKeyword")).TypeText("tonyleachsf");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option(Find.ByValue("1")).Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
            browser.Link(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00_ctl04_uxViewLog")).Click();

            browser.Link(Find.ByText("Auth Log")).Click();
            Assert.IsTrue(browser.ContainsText("Auth Success?"));
        }

        [Test]
        public void T05_IPLogging_ListAccountByIPAddr()
        {
            this.LoginPortalAdmin();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxKeyword")).TypeText("192.168.0.243");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option(Find.ByValue("2")).Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
            Assert.IsTrue(browser.Table(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00")).Exists);
        }

        [Test]
        public void T06_IPLogging_IPAddrView()
        {
            this.LoginPortalAdmin();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxKeyword")).TypeText("192.168.0.243");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option(Find.ByValue("2")).Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
            browser.Link(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00_ctl04_uxViewLog")).Click();

            browser.Link(Find.ByText("Auth Log")).Click();
            Assert.IsTrue(browser.ContainsText("Auth Success?"));
        }

        [Test]
        public void T07_IPLogging_NegativeTable()
        {
            this.LoginPortalAdmin();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxKeyword")).TypeText("a");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option(Find.ByValue("1")).Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();

            for (int i = 0; i < browser.Table(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00")).TableBodies[0].TableRows.Count; i++)
            {
                if (string.IsNullOrEmpty(browser.Table(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00")).TableBodies[0].TableRows[i].TableCells[1].Text.Trim()) == true)
                {
                    Assert.IsTrue(false);
                    return;
                }
            }
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
            browser.Div(Find.ById("ctl00_uxMainContent_uxIPLoggingSearch")).Link(Find.ByText("IP Logging-Search")).Click();
            browser.WaitForComplete();
        }
    }
}
