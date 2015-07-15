using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks.Spring3
{
    [TestFixture]
    public class S001_ChangeEmail_Module : SignIn
    {
        [Test]
        public void T01_ChangeEmail_ValidPrimEmailDotEnd()
        {
            this.GotoChangeEmail();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxEmailAddress")).TypeText("jaylenpogai@hotmail.com.");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBtnEmailsave")).Click();
            Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Please enter a valid email address"));
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxEmailAddress")).TypeText("QATestUser01@zecco.net");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBtnEmailsave")).Click();
            Assert.IsTrue(browser.ContainsText("Thanks! You have successfully changed your email address"));
        }

        [Test]
        public void T02_ChangeEmail_ValidPrimEmailSpecChar()
        {
            this.GotoChangeEmail();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxEmailAddress")).TypeText("jaylenpogai@nir(vana-info.com");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBtnEmailsave")).Click();
            Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Sorry, but we can't take email addresses in this format."));
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxEmailAddress")).TypeText("jaylenpogai@nir)vana-info.com");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBtnEmailsave")).Click();
            Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Sorry, but we can't take email addresses in this format."));
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxEmailAddress")).TypeText("jaylenpogai@nir<vana-info.com");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBtnEmailsave")).Click();
            Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Sorry, but we can't take email addresses in this format."));
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxEmailAddress")).TypeText("jaylenpogai@nir>vana-info.com");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBtnEmailsave")).Click();
            Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Sorry, but we can't take email addresses in this format."));
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxEmailAddress")).TypeText("jaylenpogai@nir,vana-info.com");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBtnEmailsave")).Click();
            Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Sorry, but we can't take email addresses in this format."));
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxEmailAddress")).TypeText("jaylenpogai@nir;vana-info.com");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBtnEmailsave")).Click();
            Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Sorry, but we can't take email addresses in this format."));
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxEmailAddress")).TypeText("jaylenpogai@nir:vana-info.com");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBtnEmailsave")).Click();
            Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Sorry, but we can't take email addresses in this format."));
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxEmailAddress")).TypeText(@"jaylenpogai@nir\vana-info.com");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBtnEmailsave")).Click();
            Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains(@"Sorry, but we can't take email addresses in this format."));
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxEmailAddress")).TypeText("jaylenpogai@nir/vana-info.com");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBtnEmailsave")).Click();
            Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Sorry, but we can't take email addresses in this format."));
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxEmailAddress")).TypeText(string.Format("jaylenpogai@nir{0}vana-info.com", '"'));
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBtnEmailsave")).Click();
            Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Sorry, but we can't take email addresses in this format."));
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxEmailAddress")).TypeText("jaylenpogai@nir[vana-info.com");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBtnEmailsave")).Click();
            Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Sorry, but we can't take email addresses in this format."));
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxEmailAddress")).TypeText("jaylenpogai@nir]vana-info.com");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBtnEmailsave")).Click();
            Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Sorry, but we can't take email addresses in this format."));
        }

        [Test]
        public void T03_ChangeEmail_ValidPrimEmailMatchOther()
        {
            this.GotoChangeEmail();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxEmailAddress")).TypeText("QATestUser02@zecco.net");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBtnEmailsave")).Click();
            Assert.IsTrue(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxErrorMessage")).Text.Contains("Please use a different email address."));
        }

        [Test]
        public void T04_ChangeEmail_ValidPrimEmailBlank()
        {
            this.GotoChangeEmail();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxEmailAddress")).TypeText("");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBtnEmailsave")).Click();
            Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Oops! Please enter your primary email address."));
        }

        //[Test]
        //public void T05_ChangeEmail_ValidPrimEmailSameSec()
        //{
        //    this.GotoChangeEmail();
        //    browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxEmailAddress")).TypeText("jaylenpogai@nirvana-info.com");
        //    browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSecondEmailAddress")).TypeText("jaylenpogai@nirvana-info.com");
        //    browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBtnEmailsave")).Click();
        //    Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("The secondary email address you entered cannot be the same as the primary email address."));
        //}

        //[Test]
        //public void T06_ChangeEmail_ValidSecEmailDotEnd()
        //{
        //    this.GotoChangeEmail();
        //    browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxEmailAddress")).TypeText("QATestUser01@zecco.net");
        //    browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSecondEmailAddress")).TypeText("jaylenpogai@hotmail.com.");
        //    browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBtnEmailsave")).Click();
        //    Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Please enter a valid email address"));
        //}

        //[Test]
        //public void T07_ChangeEmail_ValidSecEmailSpecChar()
        //{
        //    this.GotoChangeEmail();
        //    browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxEmailAddress")).TypeText("jaylenpogai@hotmail.com");
        //    browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSecondEmailAddress")).TypeText("jaylenpogai@nir(vana-info.com");
        //    browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBtnEmailsave")).Click();
        //    Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Sorry, but we can't take email addresses in this format."));
        //    browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSecondEmailAddress")).TypeText("jaylenpogai@nir)vana-info.com");
        //    browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBtnEmailsave")).Click();
        //    Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Sorry, but we can't take email addresses in this format."));
        //    browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSecondEmailAddress")).TypeText("jaylenpogai@nir<vana-info.com");
        //    browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBtnEmailsave")).Click();
        //    Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Sorry, but we can't take email addresses in this format."));
        //    browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSecondEmailAddress")).TypeText("jaylenpogai@nir>vana-info.com");
        //    browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBtnEmailsave")).Click();
        //    Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Sorry, but we can't take email addresses in this format."));
        //    browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSecondEmailAddress")).TypeText("jaylenpogai@nir,vana-info.com");
        //    browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBtnEmailsave")).Click();
        //    Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Sorry, but we can't take email addresses in this format."));
        //    browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSecondEmailAddress")).TypeText("jaylenpogai@nir;vana-info.com");
        //    browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBtnEmailsave")).Click();
        //    Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Sorry, but we can't take email addresses in this format."));
        //    browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSecondEmailAddress")).TypeText("jaylenpogai@nir:vana-info.com");
        //    browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBtnEmailsave")).Click();
        //    Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Sorry, but we can't take email addresses in this format."));
        //    browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSecondEmailAddress")).TypeText(@"jaylenpogai@nir\vana-info.com");
        //    browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBtnEmailsave")).Click();
        //    Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains(@"Sorry, but we can't take email addresses in this format."));
        //    browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSecondEmailAddress")).TypeText("jaylenpogai@nir/vana-info.com");
        //    browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBtnEmailsave")).Click();
        //    Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Sorry, but we can't take email addresses in this format."));
        //    browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSecondEmailAddress")).TypeText(string.Format("jaylenpogai@nir{0}vana-info.com", '"'));
        //    browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBtnEmailsave")).Click();
        //    Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Sorry, but we can't take email addresses in this format."));
        //    browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSecondEmailAddress")).TypeText("jaylenpogai@nir[vana-info.com");
        //    browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBtnEmailsave")).Click();
        //    Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Sorry, but we can't take email addresses in this format."));
        //    browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSecondEmailAddress")).TypeText("jaylenpogai@nir]vana-info.com");
        //    browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBtnEmailsave")).Click();
        //    Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Sorry, but we can't take email addresses in this format."));
        //}

        //[Test]
        //public void T08_ChangeEmail_ValidSecEmailMatchOther()
        //{
        //    this.GotoChangeEmail();
        //    browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxEmailAddress")).TypeText("QATestUser01@zecco.net");
        //    browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSecondEmailAddress")).TypeText("QATestUser02@zecco.net");
        //    browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBtnEmailsave")).Click();
        //    Assert.IsTrue(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSuccessMessage")).Exists);
        //}

        [Test]
        public void T09_ChangeEmail_ValidSecEmailBothIncorrect()
        {
            this.GotoChangeEmail();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxEmailAddress")).TypeText("jaylenpogai@@nirvana-info.com");
            //browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSecondEmailAddress")).TypeText("jaylenpogai@@nirvana-info.com");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBtnEmailsave")).Click();
            Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Please enter a valid email address"));
        }

        [Test]
        public void T10_ChangeEmail_ValidEmailAsZCS()
        {
            this.GotoChangeEmail();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxEmailAddress")).TypeText("noreply@zecco.com");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBtnEmailsave")).Click();
            Assert.IsTrue(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxErrorMessage")).Text.Contains("Email address can not be 'noreply@zecco.com' and 'customerservice@zeccotrading.com'"));
        }

        [Test]
        public void T11_ChangeEmail_ValidEmailAsZCS_2()
        {
            this.GotoChangeEmail();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxEmailAddress")).TypeText("customerservice@zeccotrading.com");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBtnEmailsave")).Click();
            Assert.IsTrue(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxErrorMessage")).Text.Contains("Email address can not be 'noreply@zecco.com' and 'customerservice@zeccotrading.com'"));
        }

        private void GotoChangeEmail()
        {
            UserSignIn(UN, PW, false, 0);
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
            browser.WaitForComplete();
            browser.Link(Find.ByText("Change email address")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxEmailAddress")).WaitUntilExists(10);
        }
    }
}
