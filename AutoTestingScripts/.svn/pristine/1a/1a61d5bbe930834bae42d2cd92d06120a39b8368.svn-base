//#*****************************************************************************
//# Purpose: User login check.
//# Author:  Christie Duan
//# Create Date: Mar 10, 2009
//# Modify History: 
//#*****************************************************************************

using System;
using WatiN.Core;
using NUnit.Framework;
using MaiaRegression.Appobjects;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.TestCases._01_HomePage
{
    //#*****************************************************************************
    //# Purpose: This class inherit from SignIn class, Define SignOut Checkpoint.
    //# Author:  Christie
    //# Last Modify: Mar 10, 2009
    //#*****************************************************************************

    public class Check001_SignIn : SignIn
    {
        public void SignIn(String UserName, String PassWord)
        {
            TestUserSignIn(UserName, PassWord, false, 0);
            // check result
            checkPositive(UserName);
        }

        public void SignInRemember(String UserName, String PassWord)
        {
            TestUserSignIn(UserName, PassWord, true, 0);
            // reopen 
            browser.Reopen();
            browser.GoTo(targetHost);
            // check result
            checkPositive(UserName);
        }

        public void SignInBadUsername(String UserName, String PassWord)
        {
            TestUserSignIn(UserName, PassWord, false, 0);
            // check appropriate error message
            String msg = browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxLoginForm_uxErrorMessage")).Text.ToLower();
            Assert.IsTrue(msg.Contains("username") && msg.Contains("incorrect"));
        }

        public void SignInBadPassword(String UserName, String PassWord)
        {
            TestUserSignIn(UserName, PassWord, false, 0);
            // check appropriate error message
            String msg = browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxLoginForm_uxErrorMessage")).Text.ToLower();
            Assert.IsTrue(msg.Contains("password") && msg.Contains("incorrect"));
        }

        public void SignInNoUsername(String UserName, String PassWord)
        {
            TestUserSignIn(UserName, PassWord, false, 0);
            // check appropriate error message
            String msg = browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxLoginForm_uxValidators")).Divs[0].Spans[0].InnerHtml.ToLower();
            Assert.IsTrue(msg.Contains("Oops! We could not process your request because of the following problems:".ToLower()));
        }

        public void SignInNoPassword(String UserName, String PassWord)
        {
            TestUserSignIn(UserName, PassWord, false, 0);
            // check appropriate error message
            String msg = browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxLoginForm_uxValidators")).Divs[0].Spans[0].InnerHtml.ToLower();
            Assert.IsTrue(msg.Contains("Oops! We could not process your request because of the following problems:".ToLower()));
        }

        public void SignInFromSignUp(String UserName, String PassWord)
        {
            TestUserSignInFromSignUp(UserName, PassWord, false);
            browser.GoTo(targetHost);
            // check result
            checkPositive(UserName);
        }

        public void SignInRememberFromSignUp(String UserName, String PassWord)
        {
            TestUserSignInFromSignUp(UserName, PassWord, true);
            // reopen 
            //browser.Reopen();
            browser.GoTo(targetHost);
            // check result
            checkPositive(UserName);
        }

        public void SignInBadUsernameFromSignUp(String UserName, String PassWord)
        {
            TestUserSignInFromSignUp(UserName, PassWord, false);
            // check appropriate error message
            String msg = browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDefaultLoginForm_uxErrorMessage")).Text.ToLower();
            Assert.IsTrue(msg.Contains("username") && msg.Contains("incorrect"));
        }

        public void SignInBadPasswordFromSignUp(String UserName, String PassWord)
        {
            TestUserSignInFromSignUp(UserName, PassWord, false);
            // check appropriate error message
            String msg = browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDefaultLoginForm_uxErrorMessage")).Text.ToLower();
            Assert.IsTrue(msg.Contains("password") && msg.Contains("incorrect"));
        }

        public void SignInNoUsernameFromSignUp(String UserName, String PassWord)
        {
            TestUserSignInFromSignUp(UserName, PassWord, false);
            // check appropriate error message
            String msg = browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDefaultLoginForm_Validator1")).Divs[0].Spans[0].InnerHtml.ToLower();
            Assert.IsTrue(msg.Contains("You forgot to choose a username.".ToLower()));
        }

        public void SignInNoPasswordFromSignUp(String UserName, String PassWord)
        {
            TestUserSignInFromSignUp(UserName, PassWord, false);
            // check appropriate error message
            String msg = browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDefaultLoginForm_Validator1")).Divs[0].Spans[0].InnerHtml.ToLower();
            Assert.IsTrue(msg.Contains("You need to enter a password before we can proceed.".ToLower()));
        }

        private void checkPositive(String UserName)
        {
            //CheckPoint: UserName can be viewed in the top of the screen after login successfully.      
            Div div = browser.Div(Find.ById("topNavMemberDiv"));
            Assert.AreEqual(UserName.ToLower(), div.Text.Trim().ToLower());
        }
    }
}
