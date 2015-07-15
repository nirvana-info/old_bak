using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks._2010Spring6
{
    [TestFixture]
    public class S008_YearlyPasswordReset_Module : SignIn
    {
        [Test]
        public void T01_YearlyPasswordReset_SecurityUpdate()
        {
            UserSignIn(UN_PwdRst, PW_PwdRst_Old, false, 2);
            Assert.IsTrue(browser.Image(Find.ByAlt("Zecco logo")).Src.Contains("/logo_zecco.jpg"));
            Assert.AreEqual(browser.Title.Trim(), "Security Updates Required");
            Assert.IsTrue(browser.ContainsText("Security Updates Required"));
            Assert.IsTrue(browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNewPassword")).Exists);
            Assert.IsTrue(browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxConfirmPassword")).Exists);
            Assert.IsTrue(browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSecurityQuestionList")).Exists);
            Assert.IsTrue(browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSecurityAnswerFromList")).Exists);
            Assert.IsTrue(browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNext")).Exists);
            Assert.IsTrue(browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxRemindMeLater")).Exists);
        }

        [Test]
        public void T03_YearlyPasswordReset_EmptySubmit()
        {
            UserSignIn(UN_PwdRst, PW_PwdRst_Old, false, 2);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNewPassword")).TypeText("");
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxConfirmPassword")).TypeText("");
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSecurityAnswerFromList")).TypeText("");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNext")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.ContainsText("We are sorry, some of the answers below are incomplete."));
            Assert.IsTrue(browser.ContainsText("Please provide your desired password."));
            Assert.IsTrue(browser.ContainsText("Please provide your desired password."));
            Assert.IsTrue(browser.ContainsText("Please provide an answer to your selected security question."));
        }

        [Test]
        public void T03_YearlyPasswordReset_OldPassword()
        {
            UserSignIn(UN_PwdRst, PW_PwdRst_Old, false, 2);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNewPassword")).TypeText(PW_PwdRst_Old);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxConfirmPassword")).TypeText(PW_PwdRst_Old);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSecurityAnswerFromList")).TypeText("aa");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNext")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.AreEqual(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxErrorMessage")).Text.Trim(), 
                "Your new password must be different than your current password.");
        }

        [Test]
        public void T04_YearlyPasswordReset_OldAnswer()
        {
            UserSignIn(UN_PwdRst, PW_PwdRst_Old, false, 2);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNewPassword")).TypeText(PW_PwdRst_New);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxConfirmPassword")).TypeText(PW_PwdRst_New);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSecurityAnswerFromList")).TypeText("aa");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNext")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.AreEqual(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxErrorMessage")).Text.Trim(), 
                "Your new security answer must be different than your current security answer.");
        }

        [Test]
        public void T05_YearlyPasswordReset_SkipPwd()
        {
            UserSignIn(UN_PwdRst, PW_PwdRst_Old, false, 2);
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxRemindMeLater")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxRememberIP")).Exists);
        }

        [Test]
        public void T06_YearlyPasswordReset_ContactInfo()
        {
            UserSignIn(UN_PwdRst, PW_PwdRst_Old, false, 2);
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxRemindMeLater")).Click();
            System.Threading.Thread.Sleep(2000);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxAnswer")).TypeText("aa");
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Image(Find.ByAlt("Zecco logo")).Src.Contains("/logo_zecco.jpg"));
            Assert.AreEqual(browser.Title.Trim(), "Please Update Your Contact Details");
            Assert.IsTrue(browser.ContainsText("Update Your Contact Information"));
            Assert.IsTrue(browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxEmailAddress")).Exists);
            Assert.IsTrue(browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxConfirmEmailAddress")).Exists);
            Assert.IsTrue(browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNext")).Exists);
            Assert.IsTrue(browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxRemindMeLater")).Exists);
        }

        [Test]
        public void T07_YearlyPasswordReset_EmptySubmit()
        {
            UserSignIn(UN_PwdRst, PW_PwdRst_Old, false, 2);
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxRemindMeLater")).Click();
            System.Threading.Thread.Sleep(2000);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxAnswer")).TypeText("aa");
            System.Threading.Thread.Sleep(2000);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxEmailAddress")).TypeText("");
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxConfirmEmailAddress")).TypeText("");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNext")).Click();
            Assert.IsTrue(browser.ContainsText("We are sorry, some of the answers below are incomplete."));
            Assert.IsTrue(browser.ContainsText("Please provide an email address with 64 characters or less."));
            Assert.IsTrue(browser.ContainsText("Please provide an email address with 64 characters or less."));
        }

        [Test]
        public void T08_YearlyPasswordReset_OldEmail()
        {
            UserSignIn(UN_PwdRst, PW_PwdRst_Old, false, 2);
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxRemindMeLater")).Click();
            System.Threading.Thread.Sleep(2000);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxAnswer")).TypeText("aa");
            System.Threading.Thread.Sleep(2000);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxEmailAddress")).TypeText("kevin1985@002.com");
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxConfirmEmailAddress")).TypeText("kevin1985@002.com");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNext")).Click();
            Assert.AreEqual(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxErrorMessage")).Text.Trim(),
                "Your new email address must be different than your current email address.");
        }

        [Test]
        public void T09_YearlyPasswordReset_SkipContact()
        {
            UserSignIn(UN_PwdRst, PW_PwdRst_Old, false, 2);
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxRemindMeLater")).Click();
            System.Threading.Thread.Sleep(2000);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxAnswer")).TypeText("aa");
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxRemindMeLater")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxMemberLoginStatus_uxMemberLoginView_LoginStatus1")).Exists);
        }

        [Test]
        public void T10_YearlyPasswordReset_ResetPwd()
        {
            UserSignIn(UN_PwdRst, PW_PwdRst_Old, false, 2);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNewPassword")).TypeText(PW_PwdRst_New);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxConfirmPassword")).TypeText(PW_PwdRst_New);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSecurityAnswerFromList")).TypeText("bb");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNext")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxRememberIP")).Exists);
        }

        [Test]
        public void T11_YearlyPasswordReset_VerifyPwd()
        {
            UserSignIn(UN_PwdRst, PW_PwdRst_New, false, 2);
            Assert.IsTrue(browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxRememberIP")).Exists);
        }

        [Test]
        public void T12_YearlyPasswordReset_ResetContact()
        {
            UserSignIn(UN_PwdRst, PW_PwdRst_New, false, 2);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxAnswer")).TypeText("bb");
            System.Threading.Thread.Sleep(2000);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxEmailAddress")).TypeText("kevin1985new@002.com");
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxConfirmEmailAddress")).TypeText("kevin1985new@002.com");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNext")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxMemberLoginStatus_uxMemberLoginView_LoginStatus1")).Exists);
        }

        [Test]
        public void T13_YearlyPasswordReset_VerifyContact()
        {
            UserSignIn(UN_PwdRst, PW_PwdRst_New, false, 2);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxAnswer")).TypeText("bb");
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxMemberLoginStatus_uxMemberLoginView_LoginStatus1")).Exists);
        }
    }
}
