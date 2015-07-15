//#*****************************************************************************
//# Purpose: The SignUp function testing.
//# Author:  Christie Duan
//# Create Date: April 7, 2009
//# Modify History: 

//#*****************************************************************************

using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks.Spring1_2
{
    [TestFixture] 
    public class S001_SignIn_Module : SignIn
    {
        [Test]
        public void T01_Check_username_positive()
        {
            TestUserSignIn(UN, PW, false, 0);
            // check result
            checkPositive(UN);
        }

        [Test]
        public void T02_Check_username_negative_BadUsername()
        {
            //SignInBadUsername("badusername", PW);
            TestUserSignIn("badusername", PW, false, 0);
            // check appropriate error message
            String msg = browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDefaultLoginForm_uxErrorMessage")).Text.ToLower();
            Assert.IsTrue(msg.Contains("username") && msg.Contains("incorrect"));
        }

        [Test]
        public void T03_Check_username_negative_BadPassword()
        {
            //SignInBadPassword(UN, "badpassword");
            TestUserSignIn(UN, "badpassword", false, 0);
            // check appropriate error message
            String msg = browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDefaultLoginForm_uxErrorMessage")).Text.ToLower();
            Assert.IsTrue(msg.Contains("password") && msg.Contains("incorrect"));
        }

        [Test]
        public void T04_Check_username_negative_NoUsername()
        {
            browser.GoTo(targetHost);
            //SignInNoUsername("", PW);
            TestUserSignIn("", PW, false, 0);
            // check appropriate error message
            String msg = browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDefaultLoginForm_uxValidators")).Span(Find.ByClass("message-error")).Text.ToLower();
            Assert.IsTrue(msg.Contains("Oops! We could not process your request because of the following problems:".ToLower()));
        }

        [Test]
        public void T05_Check_username_negative_NoPassword()
        {
            browser.GoTo(targetHost);
            //SignInNoPassword(UN, "");
            TestUserSignIn(UN, "", false, 0);
            // check appropriate error message
            String msg = browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDefaultLoginForm_uxValidators")).Span(Find.ByClass("message-error")).Text.ToLower();
            Assert.IsTrue(msg.Contains("Oops! We could not process your request because of the following problems:".ToLower()));
        }
        
        [Test]
        public void T06_Check_username_positive_SignUp()
        {
            //SignInFromSignUp(UN, PW);
            TestUserSignInFromSignUp(UN, PW, false);
            //browser.GoTo(targetHost);
            System.Threading.Thread.Sleep(5000);
            if (browser.Frame(Find.ByName("uxLoadSavedAppsConfirmDialog")).Button("ctl00_DialogPlaceHolder_uxNoButton").Exists == true)
            {
                browser.Frame(Find.ByName("uxLoadSavedAppsConfirmDialog")).Button("ctl00_DialogPlaceHolder_uxNoButton").Click();
            }
            browser.Link(Find.ByText("Learn more about Zecco")).Click();
            browser.WaitForComplete();
            // check result
            checkPositive(UN);
        }

        [Test]
        public void T07_Check_username_negative_BadUsername_SignUp()
        {
            //SignInBadUsernameFromSignUp("badusername", PW);
            TestUserSignInFromSignUp("badusername", PW, false);
            // check appropriate error message
            String msg = browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDefaultLoginForm_uxErrorMessage")).Text.ToLower();
            Assert.IsTrue(msg.Contains("username") && msg.Contains("incorrect"));
        }

        [Test]
        public void T08_Check_username_negative_BadPassword_SignUp()
        {
            //SignInBadPasswordFromSignUp(UN, "badpassword");
            TestUserSignInFromSignUp(UN, "badpassword", false);
            // check appropriate error message
            String msg = browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDefaultLoginForm_uxErrorMessage")).Text.ToLower();
            Assert.IsTrue(msg.Contains("password") && msg.Contains("incorrect"));
        }

        [Test]
        public void T09_Check_username_negative_NoUsername_SignUp()
        {
            //SignInNoUsernameFromSignUp("", PW);
            TestUserSignInFromSignUp("", PW, false);
            // check appropriate error message
            String msg = browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDefaultLoginForm_uxValidators")).Divs[0].Spans[0].InnerHtml.ToLower();
            Assert.IsTrue(msg.Contains("You forgot to choose a username.".ToLower()));
        }

        [Test]
        public void T10_Check_username_negative_NoPassword_SignUp()
        {
            //SignInNoPasswordFromSignUp(UN, "");
            TestUserSignInFromSignUp(UN, "", false);
            // check appropriate error message
            String msg = browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDefaultLoginForm_uxValidators")).Divs[0].Spans[0].InnerHtml.ToLower();
            Assert.IsTrue(msg.Contains("You need to enter a password before we can proceed.".ToLower()));
        }

        [Test]
        public void T11_Check_username_RememberUsername()
        {
            TestUserSignIn(UN, PW, true, 2);

            System.Diagnostics.Process[] processList = System.Diagnostics.Process.GetProcessesByName("firefox");
            foreach (System.Diagnostics.Process process in processList)
            {
                process.Kill();
                // sleep to make sure process is killed
                System.Threading.Thread.Sleep(2000);
            }
            browser = new FireFox();
            browser.ShowWindow(WatiN.Core.Native.Windows.NativeMethods.WindowShowStyle.Maximize);
            browser.GoTo(targetHost);
            System.Threading.Thread.Sleep(2000);
            if (browser.Div(Find.ById("topNavMemberDiv")).Exists == true)
            {
                Assert.IsTrue(true);
            }
            else
            {
                
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T12_Check_username_Redirect()
        {
            if (browser.Link(Find.ByText("Sign Out")).Exists)
            {
                SignOut si = new SignOut();
                si.UserSignOut(browser);
            }
            browser.GoTo(targetHost + "/accountcenter.aspx");
            if (browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDefaultLoginForm_uxUserName")).Exists == false)
            {
                browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxLoginForm_uxUserName")).Value = UN;
                browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxLoginForm_uxPassword")).Value = PW;
                if ((browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxLoginForm_uxBetaAgreeToTerms")).Exists == true) &&
                    (browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxLoginForm_uxBetaAgreeToTerms")).Checked == false))
                {
                    browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxLoginForm_uxBetaAgreeToTerms")).Checked = true;
                }
                browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxLoginForm_uxSignIn")).Click();
            }
            else
            {
                TestUserSignIn(UN, PW, false, 0);
            }
            //browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxBreadcrumbTrail_uxTopLevel")).WaitUntilExists(20);
            if (browser.Url.Contains("accountcenter") == true)
            {
                Assert.IsTrue(true);
            }
            else
            {
                Assert.IsTrue(false);
            }
            
        }

        [Test]
        public void T13_Check_SignOut()
        {
            UserSignIn(UN, PW, false, 0);
            SignOut so = new SignOut();
            so.UserSignOut(browser);
            if (browser.Div(Find.ById("topNavMemberDiv")).Exists == false)
            {
                Assert.IsTrue(true);
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        private void checkPositive(String UserName)
        {
            //CheckPoint: UserName can be viewed in the top of the screen after login successfully.      
            Div div = browser.Div(Find.ById("topNavMemberDiv"));
            Assert.AreEqual(UserName.ToLower(), div.Text.Trim().ToLower());
        }
    }
}
