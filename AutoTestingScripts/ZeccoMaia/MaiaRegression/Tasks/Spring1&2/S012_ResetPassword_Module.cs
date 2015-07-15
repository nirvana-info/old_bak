using System;
using System.Collections.Generic;
using System.Text;
using WatiN.Core;
using NUnit.Framework;
using MaiaRegression.Appobjects;
using MaiaRegression.Appobjects.App01_HomePage;


namespace MaiaRegression.Tasks.Spring1_2
{
    [TestFixture]
    public class S012_ResetPassword_Module : SignIn
    {
        [Test]
        public void T01_ResetPassword_PositiveEmailAddress()
        {
            if (browser.Link(Find.ByText("Sign Out")).Exists)
            {
                SignOut so = new SignOut();
                so.UserSignOut(browser);
            }
            browser.Link(Find.ByClass("login-button login-signin")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxLoginForm_uxResetPasswordLink")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxEmailAddressOrUserNameInput")).WaitUntilExists(10);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxEmailAddressOrUserNameInput")).TypeText("QATestUser01@zecco.net");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSendEmail")).Click();
            Assert.IsTrue(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSuccessMessage")).Text.Contains("Thanks! You should receive an email shortly with a link to reset your Zecco password."));
        }

        [Test]
        public void T02_ResetPassword_PositiveUserName()
        {
            this.CommonProc_1();
            this.CommonProc_2("tonyleachsf");
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSuccessMessage")).WaitUntilExists(10);
            Assert.IsTrue(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSuccessMessage")).Text.Contains("Thanks! You should receive an email shortly with a link to reset your Zecco password."));
        }

        [Test]
        public void T03_ResetPassword_NegativeBlanks()
        {
            this.CommonProc_1();
            this.CommonProc_2("");
            browser.Div(Find.ByClass("inline-error")).WaitUntilExists(10);
            Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Oops! Please enter your username or email address."));
        }

        [Test]
        public void T04_ResetPassword_NegativeNoMatchEmail()
        {
            this.CommonProc_1();
            this.CommonProc_2("ddpg@ddpg.com");
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxErrorMessageForEmailAddress")).WaitUntilExists(10);
            Assert.IsTrue(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxErrorMessageForEmailAddress")).Text.Contains("Sorry, we were unable to locate that entry in our records."));
        }

        [Test]
        public void T05_ResetPassword_NegativeNoMatchUserName()
        {
            this.CommonProc_1();
            this.CommonProc_2("ddpgddpg");
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxErrorMessageForEmailAddress")).WaitUntilExists(10);
            Assert.IsTrue(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxErrorMessageForEmailAddress")).Text.Contains("Sorry, we were unable to locate that entry in our records."));
        }

        //[Test]
        //public void T06_ResetPassword_NegativeFailSecQst()
        //{
        //    //this.CommonProc_1();
        //    //this.CommonProc_2("zhuojunzzj");
        //    this.CommonProc_3();
        //    this.CommonProc_4("ddpgddpg");
        //    browser.Div(Find.ByClass("inline-error")).WaitUntilExists(10);
        //    Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Oops! The answer you provided does not match our record."));
        //}

        //[Test]
        //public void T07_ResetPassword_NegativeBlankSecQst()
        //{
        //    //this.CommonProc_1();
        //    //this.CommonProc_2("zhuojunzzj");
        //    this.CommonProc_3();
        //    this.CommonProc_4("");
        //    browser.Div(Find.ByClass("inline-error")).WaitUntilExists(10);
        //    Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Oops! You need to enter security answer before we can proceed."));
        //}

        //[Test]
        //public void T08_ResetPassword_InvalidShortPwd()
        //{
        //    //this.CommonProc_1();
        //    //this.CommonProc_2("zhuojunzzj");
        //    this.CommonProc_3();
        //    this.CommonProc_4("transparent");
        //    this.CommonProc_5("a", "a", "a");
        //    browser.Div(Find.ByClass("inline-error")).WaitUntilExists(10);
        //    Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Your password must contain 8-16 characters and include a number, an uppercase letter, and a lowercase letter."));
        //}

        //[Test]
        //public void T10_ResetPassword_InvalidAllLowerPwd()
        //{
        //    //this.CommonProc_1();
        //    //this.CommonProc_2("zhuojunzzj");
        //    this.CommonProc_3();
        //    this.CommonProc_4("transparent");
        //    this.CommonProc_5("abcdefghij!", "abcdefghij", "abcdefghij");
        //    browser.Div(Find.ByClass("inline-error")).WaitUntilExists(10);
        //    Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Oops! Your password must include one uppercase letter, one lowercase letter, and one number."));
        //}

        //[Test]
        //public void T11_ResetPassword_InvalidNoLowerPwd()
        //{
        //    //this.CommonProc_1();
        //    //this.CommonProc_2("zhuojunzzj");
        //    this.CommonProc_3();
        //    this.CommonProc_4("transparent");
        //    this.CommonProc_5("ABCDEFGHIJ!", "ABCDEFGHIJ", "abcdefghij");
        //    browser.Div(Find.ByClass("inline-error")).WaitUntilExists(10);
        //    Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Oops! Your password must include one uppercase letter, one lowercase letter, and one number."));
        //}

        //[Test]
        //public void T12_ResetPassword_InvalidNoSpecChar()
        //{
        //    //this.CommonProc_1();
        //    //this.CommonProc_2("zhuojunzzj");
        //    this.CommonProc_3();
        //    this.CommonProc_4("transparent");
        //    this.CommonProc_5("ABCDEfghij", "ABCDEfghij", "transparent");
        //    browser.Div(Find.ByClass("inline-error")).WaitUntilExists(10);
        //    Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Oops! Your password must include one uppercase letter, one lowercase letter, and one number."));
        //}

        //[Test]
        //public void T14_ResetPassword_ConfirmMisMatch()
        //{
        //    //this.CommonProc_1();
        //    //this.CommonProc_2("zhuojunzzj");
        //    this.CommonProc_3();
        //    this.CommonProc_4("transparent");
        //    this.CommonProc_5("Fsj180263", "Fsj1802631", "transparent");
        //    browser.Div(Find.ByClass("inline-error")).WaitUntilExists(10);
        //    Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Oops! Your password and password confirmation do not match."));
        //}

        //[Test]
        //public void T15_ResetPassword_NoConfirm()
        //{
        //    //this.CommonProc_1();
        //    //this.CommonProc_2("zhuojunzzj");
        //    this.CommonProc_3();
        //    this.CommonProc_4("transparent");
        //    this.CommonProc_5("Fsj180263", "", "transparent");
        //    browser.Div(Find.ByClass("inline-error")).WaitUntilExists(10);
        //    Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Oops! You need to confirm your password before we can proceed."));
        //}

        //[Test]
        //public void T16_ResetPassword_NoNewPwd()
        //{
        //    //this.CommonProc_1();
        //    //this.CommonProc_2("zhuojunzzj");
        //    this.CommonProc_3();
        //    this.CommonProc_4("transparent");
        //    this.CommonProc_5("", "Fsj1802631", "transparent");
        //    browser.Div(Find.ByClass("inline-error")).WaitUntilExists(10);
        //    Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("You need to enter a new password before we can proceed."));
        //}

        //[Test]
        //public void T17_ResetPassword_NoSecAns()
        //{
        //    //this.CommonProc_1();
        //    //this.CommonProc_2("zhuojunzzj");
        //    this.CommonProc_3();
        //    this.CommonProc_4("transparent");
        //    this.CommonProc_5("Fsj180263", "Fsj180263", "");
        //    browser.Div(Find.ByClass("inline-error")).WaitUntilExists(10);
        //    Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Oops! You need to enter security answer before we can proceed."));
        //}

        #region CommonPart
        private void CommonProc_1()
        {
            //sign in page
            if (browser.Link(Find.ByText("Sign Out")).Exists)
            {
                SignOut so = new SignOut();
                so.UserSignOut(browser);
            }
            browser.Link(Find.ByClass("login-button login-signin")).Click();
        }

        private void CommonProc_2(string mailOruid)
        {
            //fill in the email|username and continue
            browser.WaitForComplete();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxLoginForm_uxResetPasswordLink")).WaitUntilExists(10);
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxLoginForm_uxResetPasswordLink")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxEmailAddressOrUserNameInput")).WaitUntilExists(10);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxEmailAddressOrUserNameInput")).TypeText(mailOruid);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSendEmail")).Click();

        }

        private void CommonProc_3()
        {
            //check the mail and click that link
            //Browser brow = new IE("http://partnerpage.google.com/nirvana-info.com");
            //brow.Link(Find.ByName("Sign in")).WaitUntilExists(10);
            //brow.Link(Find.ByName("Sign in")).Click();
            //brow.TextField(Find.ByName("Email")).TypeText("");
            //brow.TextField(Find.ByName("Passwd")).TypeText("");
            //brow.Button(Find.ByName("signIn")).Click();
            //brow.Link(Find.ById("m_1_link")).Click();
            //brow.Link(Find.ByText("ZeccoPassword Reset Notification")).Click();
            //brow.Link(Find.ByText("click here")).Click();
            browser.GoTo(URL + "/resetpasswordsecurity.aspx?Code=02fc70ac-4c5a-4e4a-9973-eca7c35aff39");
        }

        private void CommonProc_4(string sqans)
        {
            //fill in the sec qst ans
            browser.WaitForComplete();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSecurityQuestionPrompt")).WaitUntilExists(10);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSecurityQuestionPrompt")).TypeText(sqans);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNext")).Click();
        }

        private void CommonProc_5(string pwd1, string pwd2, string sqans)
        {
            //fill in the pwd, confirm pwd and sec qst ans
            browser.WaitForComplete();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNewPassword")).WaitUntilExists(10);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNewPassword")).TypeText(pwd1);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxConfirmPassword")).TypeText(pwd2);
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSecurityQuestionList")).Option("What was the color of your first car?").Select();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSecurityAnswerFromList")).TypeText(sqans);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNext")).Click();
        }
        #endregion
    }
}
