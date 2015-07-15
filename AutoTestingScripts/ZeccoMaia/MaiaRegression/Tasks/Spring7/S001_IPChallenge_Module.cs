using System.Collections.Generic;
using System.Text;
using WatiN.Core;
using NUnit.Framework;
using MaiaRegression.Appobjects;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks.Spring7
{
    [TestFixture]
    public class S001_IPChallenge_Module : SignIn
    {
        [Test]
        public void T01_IPChallenge_WithNoTrading()
        {
            TestUserSignInForIP(UN1, PW1, false, 2);
            if ((browser.Link(Find.ByText("Sign Out")).Exists) &&
                (browser.Div(Find.ById("topNavMemberDiv")).Text.Trim().ToLower() == UN1.ToLower()))
            {
                Assert.IsTrue(true);
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T02_IPChallenge_FirstSignIn()
        {
            TestUserSignInForIP("bsteel", "password", false, 2);
            if (browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxAnswer")).Exists == true)
            {
                Assert.IsTrue(true);
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T03_IPChallenge_IncorrectAnswer()
        {
            TestUserSignInForIP("bsteel", "password", false, 2);
            if (browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxAnswer")).Exists == true)
            {
                browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxAnswer")).TypeText("aaa");
                browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNext")).Click();

                Assert.IsTrue(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxErrorMessage")).Text.Contains("Sorry, the answer you provided is not correct."));
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T04_IPChallenge_CorrectAnswer()
        {
            TestUserSignInForIP("bsteel", "password", false, 2);
            if (browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxAnswer")).Exists == true)
            {
                browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxAnswer")).TypeText("aa");
                browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxRememberIP")).Checked = true;
                browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNext")).Click();
                if ((browser.Link(Find.ByText("Sign Out")).Exists) &&
                    (browser.Div(Find.ById("topNavMemberDiv")).Text.Trim().ToLower() == "bsteel"))
                {
                    Assert.IsTrue(true);
                }
                else
                {
                    Assert.IsTrue(false);
                }
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T05_IPChallenge_OnBlackList()
        {
            GotoAdmin();
            browser.Link(Find.ById("ctl00_uxMainContent_uxAddIpToBlackList")).Click();
            browser.Div(Find.ById("RadToolTipWrapper_ctl00_uxMainContent_uxAddBlackListToolTip")).TextField(Find.ById("ctl00_uxMainContent_uxNewIpAddress")).TypeText("192.168.0.243");
            browser.Div(Find.ById("RadToolTipWrapper_ctl00_uxMainContent_uxAddBlackListToolTip")).Button(Find.ById("ctl00_uxMainContent_uxYesButton")).Click();
            if (browser.Span(Find.ById("ctl00_uxMainContent_uxSuccessMessage")).Text != "Thanks! You have successfully added the ip address to black list.")
            {
                Assert.IsTrue(false);
                return;
            }
            if (browser.Link(Find.ById("ctl00_uxLoginView_uxLoginStatus")).Exists)
            {
                browser.Span(Find.ById("ctl00_uxSiteMapBreadCrumb")).Link(Find.ByText("Portal Admin")).Click();
                browser.Link(Find.ById("ctl00_uxLoginView_uxLoginStatus")).Click();
            }
            browser.GoTo(targetHost);
            browser.WaitForComplete();
            TestUserSignInForIP("bsteel", "password", false, 2);
            if (browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxAnswer")).Exists == true)
            {
                Assert.IsTrue(true);
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T06_IPChallenge_Exempt()
        {
            if (browser.Link(Find.ById("ctl00_uxLoginView_uxLoginStatus")).Exists)
            {
                browser.Span(Find.ById("ctl00_uxSiteMapBreadCrumb")).Link(Find.ByText("Portal Admin")).Click();
                browser.Link(Find.ById("ctl00_uxLoginView_uxLoginStatus")).Click();
            }
            browser.GoTo(URL);
            browser.WaitForComplete();
            TestUserSignInForIP("bsteel", "password", false, 2);
            if (browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxAnswer")).Exists == true)
            {
                browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxAnswer")).TypeText("aa");
                browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxRememberIP")).Checked = true;
                browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNext")).Click();
                if ((browser.Link(Find.ByText("Sign Out")).Exists) &&
                    (browser.Div(Find.ById("topNavMemberDiv")).Text.Trim().ToLower() == "bsteel"))
                {
                    GotoAdmin();
                    browser.TextField(Find.ById("ctl00_uxMainContent_uxKeyword")).TypeText("bsteel");
                    browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option(Find.ByText("UserName")).Select();
                    browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
                    browser.Link(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00_ctl04_uxViewLog")).WaitUntilExists(10);
                    browser.Link(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00_ctl04_uxViewLog")).Click();
                    browser.Div(Find.ById("ctl00_uxMainContent_uxListGridView")).WaitUntilExists(10);
                    Assert.IsTrue(browser.CheckBox(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00_ctl04_uxOnBlackList")).Checked);
                    Assert.IsTrue(browser.CheckBox(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00_ctl04_uxExemptBlackList")).Checked);
                }
                else
                {
                    Assert.IsTrue(false);
                }
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
            browser.Div(Find.ById("ctl00_uxMainContent_uxIPLoggingSearch")).Link(Find.ByText("IP Logging-Search")).Click();
            browser.WaitForComplete();
        }
    }
}
