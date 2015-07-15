using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks.SpringPreProdA
{
    [TestFixture]
    public class S001_SecurityUpgrade_Module : SignIn
    {
        [Test]
        public void T01_SecurityUpgrade_Incorrect9SignIn()
        {
            for (int i = 0; i < 9; i++)
            {
                UserSignIn(UN1, "wrong", false, 2);
                System.Threading.Thread.Sleep(2000);
            }
            UserSignIn(UN1, PW1, false, 2);
            browser.WaitForComplete();
            Assert.IsTrue(browser.Div(Find.ById("topNavMemberDiv")).Exists);
        }

        [Test]
        public void T02_SecurityUpgrade_Incorrect10SignIn()
        {
            for (int i = 0; i < 10; i++)
            {
                UserSignIn(UN1, "wrong", false, 2);
                System.Threading.Thread.Sleep(2000);
            }
            Assert.IsTrue(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDefaultLoginForm_uxErrorMessage")).Text.Contains("exceeded the maximum allowed number"));
            UserSignIn(UN1, PW1, false, 2);
            Assert.IsTrue(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDefaultLoginForm_uxErrorMessage")).Text.Contains("exceeded the maximum allowed number"));
        }

        [Test]
        public void T03_SecurityUpgrade_UnlockByAdmin()
        {
            GotoAdmin();
            browser.Div(Find.ById("ctl00_uxMainContent_uxManageUsers")).Link(Find.ByText("Manage Users")).Click();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).WaitUntilExists(10);
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).TypeText(UN1);
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option(Find.ByValue("UserName")).Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
            browser.WaitForComplete();

            browser.Table(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00")).TableRows[1].TableCells[5].Link(Find.ByText("Edit")).Click();
            browser.Link(Find.ByText("Reset Member Password")).WaitUntilExists(10);
            browser.Link(Find.ByText("Reset Member Password")).Click();
            browser.Frames[0].Forms[0].TextField(Find.ById("ctl00_ContentPlaceHolder1_uxNewPassword")).TypeText(PW1);
            browser.Frames[0].Forms[0].TextField(Find.ById("ctl00_ContentPlaceHolder1_uxConfirmPassword")).TypeText(PW1);
            browser.Frames[0].Forms[0].Button(Find.ById("ctl00_ContentPlaceHolder1_uxSave")).Click();

            Assert.IsTrue(browser.Span(Find.ById("ctl00_uxMainContent_uxSuccess")).Text.Contains("Reset member operation success"));

            browser.Span(Find.ById("ctl00_uxSiteMapBreadCrumb")).Link(Find.ByText("Portal Admin")).Click();
            browser.Link(Find.ById("ctl00_uxLoginView_uxLoginStatus")).Click();
        }

        [Test]
        public void T04_SecurityUpgrade_Incorrect9Answer()
        {
            browser.GoTo(URL);
            TestUserSignInForIP(UN2, PW2, false, 2);
            if (browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxAnswer")).Exists == true)
            {
                for (int i = 0; i < 9; i++)
                {
                    browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxAnswer")).TypeText("wrong");
                    browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNext")).Click();
                    System.Threading.Thread.Sleep(2000);
                }
                browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxAnswer")).TypeText("aa");
                browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNext")).Click();
                browser.WaitForComplete();
                Assert.IsTrue(browser.Div(Find.ById("topNavMemberDiv")).Exists);
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T05_SecurityUpgrade_Incorrect10Answer()
        {
            TestUserSignInForIP(UN2, PW2, false, 2);
            if (browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxAnswer")).Exists == true)
            {
                for (int i = 0; i < 10; i++)
                {
                    browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxAnswer")).TypeText("wrong");
                    browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNext")).Click();
                    System.Threading.Thread.Sleep(2000);
                }
                Assert.IsTrue(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDefaultLoginForm_uxErrorMessage")).Text.Contains("exceeded the maximum allowed number"));
            }
            else
            {
                Assert.IsTrue(false);
            }
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
        }
    }
}
