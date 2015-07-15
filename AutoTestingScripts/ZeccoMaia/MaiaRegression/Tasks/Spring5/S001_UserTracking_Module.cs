using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks.Spring5
{
    [TestFixture]
    public class S001_UserTracking_Module : SignIn
    {
        [Test]
        public void T01_UserTracking_SearchDate()
        {
            this.GotoReport();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxRetrieveFrom_dateInput_text")).TypeText("7/1/2009");
            browser.TextField(Find.ById("ctl00_uxMainContent_uxRetrieveTo_dateInput_text")).TypeText("7/1/2010");
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
            browser.Div(Find.ById("ctl00_uxMainContent_uxListGridView")).WaitUntilExists(10);
            Assert.IsTrue(browser.Div(Find.ById("ctl00_uxMainContent_uxListGridView")).Exists);
        }

        [Test]
        public void T02_UserTracking_SearchMemberID()
        {
            this.GotoReport();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUserID")).TypeText("40855");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option("MemberID").Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
            browser.Div(Find.ById("ctl00_uxMainContent_uxListGridView")).WaitUntilExists(10);
            Assert.IsTrue(browser.Div(Find.ById("ctl00_uxMainContent_uxListGridView")).Exists);
        }

        [Test]
        public void T03_UserTracking_SearchPromo()
        {
            this.GotoReport();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxPromo")).TypeText("promo");
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
            browser.Div(Find.ById("ctl00_uxMainContent_uxListGridView")).WaitUntilExists(10);
            Assert.IsTrue(browser.Div(Find.ById("ctl00_uxMainContent_uxListGridView")).Exists);
        }

        [Test]
        public void T04_UserTracking_SearchChannel()
        {
            this.GotoReport();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxChannel")).TypeText("channel");
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
            browser.Div(Find.ById("ctl00_uxMainContent_uxListGridView")).WaitUntilExists(10);
            Assert.IsTrue(browser.Div(Find.ById("ctl00_uxMainContent_uxListGridView")).Exists);
        }

        [Test]
        public void T05_UserTracking_SearchReferrer()
        {
            this.GotoReport();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxReferrer")).TypeText("referrer");
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
            browser.Div(Find.ById("ctl00_uxMainContent_uxListGridView")).WaitUntilExists(10);
            Assert.IsTrue(browser.Div(Find.ById("ctl00_uxMainContent_uxListGridView")).Exists);
        }

        [Test]
        public void T06_UserTracking_Pixel()
        {
            this.GotoReport();
            browser.Back();
            browser.Div(Find.ById("ctl00_uxMainContent_uxListContent")).Link(Find.ByText("List Content")).Click();
            browser.Link(Find.ByText("Create New Content")).Click();
            browser.WaitForComplete(10);
            Assert.IsTrue(browser.SelectList(Find.ById("ctl00_uxMainContent_uxContentTypeDropdown")).Option("Tracking Pixel").Exists);
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxContentTypeDropdown")).Option("Tracking Pixel").Select();
            string Ti = DateTime.Now.ToShortTimeString();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxContentNameText")).TypeText("pixel" + Ti);
            browser.Button(Find.ById("ctl00_uxMainContent_uxSaveContentButton")).Click();
            browser.Link(Find.ByText("Content Editor")).Click();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxSearchText")).TypeText("pixel" + Ti);
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearchButton")).Click();
            Assert.AreEqual("pixel" + Ti, browser.TableRow(Find.ById("ctl00_uxMainContent_uxContentsGridView_ctl00__0")).TableCells[1].Text);
        }

        [Test]
        public void T07_UserTracking_NegativeTable()
        {
            this.GotoReport();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUserID")).TypeText("40855");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option("MemberID").Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
            browser.Div(Find.ById("ctl00_uxMainContent_uxListGridView")).WaitUntilExists(10);
            
            for (int i = 0; i < browser.Table(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00")).TableBodies[0].TableRows.Count; i++)
            {
                if (string.IsNullOrEmpty(browser.Table(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00")).TableBodies[0].TableRows[i].TableCells[0].Text) == true)
                {
                    Assert.IsTrue(false);
                    return;
                }
            }
        }

        private void GotoReport()
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
            browser.Div(Find.ById("ctl00_uxMainContent_uxReports")).Link(Find.ByText("Marketing Reports")).Click();
            browser.WaitForComplete();
        }
    }
}
