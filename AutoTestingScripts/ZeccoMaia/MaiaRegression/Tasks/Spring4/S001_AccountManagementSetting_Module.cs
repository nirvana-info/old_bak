using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks.Spring4
{
    [TestFixture]
    public class S001_AccountManagementSetting_Module : SignIn
    {
        [Test]
        public void T01_AMS_ChangePassword()
        {
            this.GotoSupportCenter();
            browser.Link(Find.ByText("Change password")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxCurrentPassword")).WaitUntilExists(10);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxCurrentPassword")).TypeText("Jaylen0520");
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNewPassword")).TypeText("Jaylen0521");
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxConfirmPassword")).TypeText("Jaylen0521");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxContinue")).Click();
            browser.WaitForComplete();
            Assert.IsTrue(browser.ContainsText("You have successfully changed your Zecco password. You will receive an email confirming the password change shortly"));
            browser.WaitForComplete();
            browser.Link(Find.ByText("Change password")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxCurrentPassword")).WaitUntilExists(10);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxCurrentPassword")).TypeText("Jaylen0521");
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNewPassword")).TypeText("Jaylen0520");
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxConfirmPassword")).TypeText("Jaylen0520");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxContinue")).Click();
            browser.WaitForComplete();
            Assert.IsTrue(browser.ContainsText("You have successfully changed your Zecco password. You will receive an email confirming the password change shortly"));
        }

        [Test]
        public void T02_AMS_ChangeEmail()
        {
            this.GotoSupportCenter();
            browser.Link(Find.ByText("Change email address")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxEmailAddress")).WaitUntilExists(10);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxEmailAddress")).TypeText("QATestUser04@zecco.net");
            //browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSecondEmailAddress")).TypeText("jaylenpg3@hotmail.com");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBtnEmailsave")).Click();
            Assert.IsTrue(browser.ContainsText("Thanks! You have successfully changed your email address"));
        }

        [Test]
        public void T03_AMS_ChangeAddress()
        {
            this.GotoSupportCenter();
            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxChangeMailingAddress")).Links[0].Click();
            browser.Frame(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_pensonFrame")).TextField(Find.ById("_ctl0_txtNewAddressLine1_txt")).WaitUntilExists(20);
            //browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxAccount")).Options[0].Select();
            browser.Frame(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_pensonFrame")).TextField(Find.ById("_ctl0_txtNewAddressLine1_txt")).TypeText("baotunlu");
            browser.Frame(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_pensonFrame")).TextField(Find.ById("_ctl0_txtNewCity_txt")).TypeText("shanghai");
            browser.Frame(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_pensonFrame")).TextField(Find.ById("_ctl0_txtNewZipCode")).TypeText("12345");
            browser.Frame(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_pensonFrame")).TextField(Find.ById("_ctl0_txtNewExtendedZipCode")).TypeText("6789");
            browser.Frame(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_pensonFrame")).TextField(Find.ById("_ctl0_txtNewHomePhone")).TypeText("123");
            browser.Frame(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_pensonFrame")).TextField(Find.ById("_ctl0_txtNewHomePhone1")).TypeText("456");
            browser.Frame(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_pensonFrame")).TextField(Find.ById("_ctl0_txtNewHomePhone2")).TypeText("7890");
            browser.Frame(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_pensonFrame")).Button(Find.ById("_ctl0_btnReset_btn")).Click();
            //Assert.IsTrue(browser.ContainsText(""));
        }

        [Test]
        public void T04_AMS_NoTradingAccount()
        {
            this.GotoSupportCenter();
            Assert.IsTrue(!browser.Link(Find.ByText("Change Your Mailing Address & Phone")).Exists);
        }

        [Test]
        public void T05_AMS_MarginForm()
        {
            this.GotoSupportCenter();
            browser.Link(Find.ByText("Apply for margin")).Click();
            Assert.IsTrue(browser.Link(Find.ByText("Download Margin Application Form")).Exists);
        }

        [Test]
        public void T06_AMS_OptionForm()
        {
            this.GotoSupportCenter();
            browser.Link(Find.ByText("Apply for options")).Click();
            Assert.IsTrue(browser.Link(Find.ByText("Download Options Application Form")).Exists);
        }

        [Test]
        public void T07_AMS_ElectronicStatements()
        {
            this.GotoSupportCenter();
            browser.Link(Find.ByText("Enable paperless statements and confirmations")).Click();
            browser.Frame(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_pensonFrame")).Button(Find.ById("Button1")).WaitUntilExists(20);
            browser.Frame(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_pensonFrame")).Button(Find.ById("Button1")).Click();
            //Assert.IsTrue(browser.ContainsText("Thanks! You have successfully changed your account statement"));
        }

        [Test]
        public void T08_AMS_MoneyMarket()
        {
            this.GotoSupportCenter();
            browser.Link(Find.ByText("Request money market sweep")).Click();
            Assert.IsTrue(browser.ContainsText("Instructions for Money Market Sweep"));
        }

        [Test]
        public void T09_AMS_Dividends()
        {
            this.GotoSupportCenter();
            browser.Link(Find.ByText("Reinvest dividends")).Click();
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxTopic")).WaitUntilExists(10);
            //Dividend Reinvestment
            Assert.IsTrue(browser.ContainsText("Instructions for Dividend Reinvestment"));
        }

        [Test]
        public void T10_AMS_CostBasis()
        {
            this.GotoSupportCenter();
            browser.Link(Find.ByText("Update cost basis")).Click();
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxTopic")).WaitUntilExists(10);
            //Cost Basis Update
            Assert.IsTrue(browser.ContainsText("Instructions for Updating Cost Basis:"));
        }

        [Test]
        public void T11_AMS_AccountAppForm()
        {
            this.GotoSupportCenter();
            browser.Link(Find.ByText("View tax forms")).Click();
            browser.Frame(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_pensonFrame")).Button(Find.ById("submit")).WaitUntilExists(20);
            //Cost Basis Update
            Assert.IsTrue(browser.ContainsText("Electronic Documents"));
        }

        [Test]
        public void T12_AMS_AccountInfo()
        {
            this.GotoSupportCenter();
            browser.Link(Find.ByText("View \"My Info\" account details")).Click();
            Assert.IsTrue(!browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxErrorMessageLbl")).Exists);
        }

        private void GotoSupportCenter()
        {
            UserSignIn(UN, PW, false, 0);
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
            browser.WaitForComplete();
        }
    }
}
