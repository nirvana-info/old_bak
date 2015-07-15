//#*****************************************************************************
//# Purpose: The user login/loginout testing.
//# Author:  Christie Duan
//# Create Date: Jan 13, 2009
//# Modify History: 
//# Sep 18, 2009    Add ""
//# Dec 03, 2009    Remove ""
//# Dec 12, 2009    Remove ""
//#*****************************************************************************

using System;
using System.Collections.Generic;
using System.Text;
using WatiN.Core;
using NUnit.Framework;
using WatiN.Core.Interfaces;
using WatiN.Core.DialogHandlers;

namespace MaiaRegression.Check01_HomePage
{
    [TestFixture]
    public class Check01_001SignInOut:TestBase
    {
        [Test]

        public void SignIn()
        {
            browser.GoTo(targetHost);
            browser.Link(Find.ByClass("login-button login-signin")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxLoginForm_uxUserName")).Value = UserName;
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxLoginForm_uxPassword")).Value = PassWord;
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxLoginForm_uxSignIn")).Click();
            Assert.AreEqual(UserName, browser.Span(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxMemberLoginStatus_uxMemberLoginView_uxLoginName")).Text);
            //CheckPoint: UserName can be viewed in the bottom of the screen after login successfully.      
        }

        [Test]
        public void SignOut()
        {
            browser.Link(Find.ByClass("login-button login-signout")).Click();
            Assert.IsTrue(browser.Link(Find.ByClass("login-button login-signin")).Exists);
            //CheckPoint:Logout successfully, the Login button can be viewed. 

        }
    }
}
