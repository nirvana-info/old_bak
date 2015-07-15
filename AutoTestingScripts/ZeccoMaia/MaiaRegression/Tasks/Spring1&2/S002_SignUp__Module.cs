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
using MaiaRegression.Appobjects;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks.Spring1_2
{
    [TestFixture]
    public class S002_SignUp__Module:SignUp
    {
        [Test]
        public void T01_SignUp_CheckUsernameAvailability_Positive()
        {
            NavigateToSignup(browser);
            CheckUserAvailable("Test"+Date);
        }

        [Test]
        public void T02_SignUp_CheckUsernameAvailability_Negative()
        {
            //NavigateToSignup(browser);
            //CheckUserAvailable(UN);
            //Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Sorry, the username '" + UN + "' is not available."));
            //Assert.IsTrue(browser.Div(Find.ByClass("inline-success")).Text.Contains("Sorry, we were unable to check whether this username is available"));
        }

        [Test]
        public void T03_SignUp_Positive()
        {
            //NavigateToSignup(browser);
            //UserSignUp("Auto3" + Date, "Test*123456", "Test*123456", "Auto1" + Date + "@nirvana-info.com", "Auto1" + Date + "@nirvana-info.com", 1, 1);
            //browser.WaitForComplete();
            //browser.Link(Find.ByText("Learn more about Zecco")).Click();
            //checkPositive("Auto3" + Date);
        }

        [Test]
        public void T04_SignUp_Negative_DuplicateUsername()
        {
            NavigateToSignup(browser);
            UserSignUp(UN, "Test*123456", "Test*123456", "christie.duan@nirvana-info.com", "christie.duan@nirvana-info.com ", 1, 1);
            Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Sorry, the username '" + UN + "' is not available."));
         }

        [Test]
        public void T05_SignUp_Negative_TooShortUsername()
        {
            NavigateToSignup(browser);
            UserSignUp("t", "Test*123456", "Test*123456", "christie.duan@nirvana-info.com", "christie.duan@nirvana-info.com ", 1, 1);
            Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Your username must be 3-16 characters and contain no special characters."));
        }

        [Test]
        public void T07_SignUp_Negative_SpecialCharUsername()
        {
            NavigateToSignup(browser);
            //UserSignUp("********", "Test*123456", "Test*123456", "christie.duan@nirvana-info.com", "christie.duan@nirvana-info.com ", 1, 1);
            CheckUserAvailable("********");
            Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("contain no special characters."));
        }

        [Test]
        public void T08_SignUp_Negative_RestrictedUsername()
        {
            NavigateToSignup(browser);
            //UserSignUp("admin", "Test*123456", "Test*123456", "christie.duan@nirvana-info.com", "christie.duan@nirvana-info.com ", 1, 1);
            CheckUserAvailable("admin");
            Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Sorry, your username cannot contain restricted words."));
        }

        [Test]
        public void T09_SignUp_Negative_MissingUsername()
        {
            NavigateToSignup(browser);
            UserSignUp("", "Test*123456", "Test*123456", "christie.duan@nirvana-info.com", "christie.duan@nirvana-info.com ", 1, 1);
            Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Please provide your desired username."));
        }

        [Test]
        public void T10_SignUp_Negative_MissingEmail()
        {
            NavigateToSignup(browser);
            UserSignUp("Test" + Date, "Test*123456", "Test*123456", "", "christie.duan@nirvana-info.com", 1, 1);
            Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Oops! Please enter your email address."));
        }

        [Test]
        public void T11_SignUp_Negative_EmailNotMatch()
        {
            NavigateToSignup(browser);
            UserSignUp("Test", "Test*123456", "Test*123456", "christie.duan@nirvana-info.com", "123@info.com", 1, 1);
            Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Your email and email confirmation do not match."));
        }

        [Test]
        public void T12_SignUp_Negative_InvalidEmail()
        {
            NavigateToSignup(browser);
            UserSignUp("Test1" + Date, "Test*123456", "Test*123456", "Auto1" + Date + "@nirvana-info.com", "Auto1" + Date + "@nirvana-info.com", 1, 1);
            Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("has been used already. Please use a different email address"));
        }

        [Test]
        public void T13_SignUp_Negative_MatchPasswordInvalid()
        {
            NavigateToSignup(browser);
            UserSignUp("Test1" + Date, "Test*123456", "Test*", "christie.duan@nirvana-info.com", "christie.duan@nirvana-info.com", 1, 1);
            Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Your passwords do not match."));
        }

        [Test]
        public void T14_SignUp_Negative_MatchPassword()
        {
            NavigateToSignup(browser);
            UserSignUp("Test1" + Date, "Test*123456", "Test*1234", "christie.duan@nirvana-info.com", "christie.duan@nirvana-info.com", 1, 1);
            Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Your passwords do not match."));
        }

        [Test]
        public void T15_SignUp_Negative_TooShortPassword()
        {
            NavigateToSignup(browser);
            UserSignUp("Test" + Date, "T*1", "T*1", "christie.duan@nirvana-info.com", "christie.duan@nirvana-info.com", 1, 1);
            Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Your password is not strong enough."));
        }

        [Test]
        public void T16_SignUp_Negative_PasswordLacksUpperCase()
        {
            NavigateToSignup(browser);
            UserSignUp("Test" + Date, "test*123456", "test*123456", "Test@nirvana.com", "Test@nirvana.com", 1, 1);
            Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Your password is not strong enough"));
        }

        [Test]
        public void T17_SignUp_Negative_PasswordLacksLowerCase()
        {
            NavigateToSignup(browser);
            UserSignUp("Lower" + Date, "TEST*123456", "TEST*123456", "Test1@nirvana.com", "Test1@nirvana.com", 1, 1);
            Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Your password is not strong enough"));
        }

        [Test]
        public void T18_SignUp_Negative_PasswordMissing()
        {
            NavigateToSignup(browser);
            UserSignUp("Test" + Date, "", "Test*123456", "Test@nirvana.com", "Test@nirvana.com", 1, 1);
            Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Please provide your desired password."));
        }

        [Test]
        public void T19_SignUp_Negative_ConfirmPasswordMissing()
        {
            NavigateToSignup(browser);
            UserSignUp("Test" + Date, "Test*123456", "", "Test@nirvana.com", "Test@nirvana.com", 1, 0);
            Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Oops! You need to confirm your password before we can proceed."));
        }

        [Test]
        public void T20_SignUp_SecurityQuestionNotAnswered()
        {
            NavigateToSignup(browser);
            UserSignUp("Test" + Date, "Test*123456", "Test*123456", "Test@nirvana.com", "Test@nirvana.com", 0, 1);
            Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("For added security, please choose a security question."));
        }

        private void checkPositive(String UserName)
        {
            //CheckPoint: UserName can be viewed in the top of the screen after login successfully.   
            Div div = browser.Div(Find.ById("topNavMemberDiv"));
            Assert.AreEqual(UserName.ToLower(), div.Text.Trim().ToLower());
        }
    }
}
