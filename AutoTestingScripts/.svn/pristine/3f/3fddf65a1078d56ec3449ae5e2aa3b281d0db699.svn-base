using System;
using System.Collections.Generic;
using System.Text;
using WatiN.Core;
using NUnit.Framework;
using MaiaRegression.Appobjects.App01_HomePage;


namespace MaiaRegression.Tasks.Spring1_2
{
    [TestFixture]
    public class S007_ChangePassword_Module : SignIn
    {
        [Test]
        public void T01_ChangePassword_NavigatefromSettings()
        {
            UserSignIn(UN1,PW1,false,0);
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
            browser.Link(Find.ByText("Change password")).WaitUntilExists(10);
            Assert.IsTrue(browser.ContainsText("Change password"));
        }

        [Test]
        public void T02_ChangePassword_Positive()
        {
            UserSignIn(UN1, PW1, false, 0);
            ChangePassWord(PW1,"Test123456*","Test123456*");
            Assert.IsTrue(browser.ContainsText("You have successfully changed your Zecco password. You will receive an email confirming the password change shortly."));
            //SignOut so = new SignOut();
            //so.UserSignOut(browser);
            UserSignIn(UN1, "Test123456*", false, 0);
            Assert.AreEqual(UN1, browser.Div(Find.ById("topNavMemberDiv")).Text.Trim());
            //New password work.
            ChangePassWord("Test123456*", PW1, PW1);
            Assert.IsTrue(browser.ContainsText("You have successfully changed your Zecco password. You will receive an email confirming the password change shortly."));
        }

        [Test]
        public void T03_ChangePassword_Negative_IncorrectCurrentPassword()
        {
            UserSignIn(UN1, PW1, false, 0);
            ChangePassWord("Test", "Test123456*", "Test123456*");
            Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("The password you entered does not match our records."));
        }

        [Test]
        public void T04_ChangePassword_Negative_NewPasswordUnmatchInvalid()
        {
            UserSignIn(UN1, PW1, false, 0);
            ChangePassWord(PW1, "Test123456*", "Test");
            Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Your password is not strong enough"));
        }

        [Test]
        public void T05_ChangePassword_Negative_NewPasswordUnmatch()
        {
            UserSignIn(UN1, PW1, false, 0);
            ChangePassWord(PW1, "Test123456*", "Test1234*");
            Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Your passwords do not match."));
        }

        [Test]
        public void T06_ChangePassword_Negative_NewPasswordTooShort()
        {
            UserSignIn(UN1, PW1, false, 0);
            ChangePassWord(PW1, "Te1*", "Te1*");
            Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Your password is not strong enough"));
        }

        [Test]
        public void T07_ChangePassword_Negative_NewPasswordLacksUppercase()
        {
            UserSignIn(UN1, PW1, false, 0);
            ChangePassWord(PW1, "test123456*", "test123456*");
            Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Your password is not strong enough"));
        }

        [Test]
        public void T08_ChangePassword_Negative_NewPasswordLacksLowercase()
        {
            UserSignIn(UN1, PW1, false, 0);
            ChangePassWord(PW1, "TEST123456*", "TEST123456*");
            Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Your password is not strong enough"));
        }

        [Test]
        public void T10_ChangePassword_Negative_OmitCurrentPassword()
        {
            UserSignIn(UN1, PW1, false, 0);
            ChangePassWord("", "Test123456*", "Test123456*");
            Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("You need to enter your password before we can proceed."));
        }

        [Test]
        public void T11_ChangePassword_Negative_OmitNewPassword()
        {
            UserSignIn(UN1, PW1, false, 0);
            ChangePassWord(PW1, "", "Test123456*");
            Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("You need to enter a new password before we can proceed."));
        }

        [Test]
        public void T12_ChangePassword_Negative_OmitConfirmedPassword()
        {
            UserSignIn(UN1, PW1, false, 0);
            ChangePassWord(PW1, "Test123456*", "");
            Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Oops! You need to confirm your password before we can proceed."));
        }

        [Test]
        public void T13_ChangePassword_SpecChar()
        {
            string pwd1 = "Pa1~!@#$%^&*()";
            string pwd2 = "Pa1_-+={[}]|\\";
            string pwd3 = "Pa1:;\"'<,>.?/";
            UserSignIn(UN1, PW1, false, 0);
            ChangePassWord(PW1, pwd1, pwd1);
            if (browser.ContainsText("You have successfully changed your Zecco password. You will receive an email confirming the password change shortly.") == false)
            {
                Assert.IsTrue(false);
                return;
            }

            ChangePassWord(pwd1, pwd2, pwd2);
            if (browser.ContainsText("You have successfully changed your Zecco password. You will receive an email confirming the password change shortly.") == false)
            {
                Assert.IsTrue(false);
                return;
            }

            ChangePassWord(pwd2, pwd3, pwd3);
            if (browser.ContainsText("You have successfully changed your Zecco password. You will receive an email confirming the password change shortly.") == false)
            {
                Assert.IsTrue(false);
                return;
            }

            ChangePassWord(pwd3, PW1, PW1);
            if (browser.ContainsText("You have successfully changed your Zecco password. You will receive an email confirming the password change shortly.") == false)
            {
                Assert.IsTrue(false);
                return;
            } 
        }

        private void ChangePassWord(String CurrentPassword, String NewPassword, String NewPasswordConfirmed)
        {
            if (browser.Link(Find.ByText("Change password")).Exists == false)
            {
                browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
                browser.Link(Find.ById("uxAccountCenter")).Click();
            }
            browser.Link(Find.ByText("Change password")).WaitUntilExists(10);
            browser.Link(Find.ByText("Change password")).Click();
            browser.TextField("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxCurrentPassword").WaitUntilExists(10);
            browser.TextField("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxCurrentPassword").TypeText(CurrentPassword);
            browser.TextField("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNewPassword").TypeText(NewPassword);
            browser.TextField("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxConfirmPassword").TypeText(NewPasswordConfirmed);

            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxContinue")).Click();
        }
    }
}
