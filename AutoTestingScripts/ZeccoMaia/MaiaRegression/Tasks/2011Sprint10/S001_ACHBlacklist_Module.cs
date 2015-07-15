using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks._2011Sprint10
{
    [TestFixture]
    public class S001_ACHBlacklist_Module : SignIn
    {
        [Test]
        public void T01_ACHBlacklist_Add()
        {
            this.LoginPortalAdmin();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxBankRoutingNumber")).TypeText("031176110");
            browser.Button(Find.ById("ctl00_uxMainContent_uxAddBlacklist")).Click();
            System.Threading.Thread.Sleep(5000);
            Assert.IsTrue(browser.Span("ctl00_uxMainContent_uxSuccessMessage").Text.Contains("Routing number has been successfully added"));
        }

        [Test]
        public void T02_ACHBlacklist_AddExist()
        {
            this.LoginPortalAdmin();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxBankRoutingNumber")).TypeText("031176110");
            browser.Button(Find.ById("ctl00_uxMainContent_uxAddBlacklist")).Click();
            System.Threading.Thread.Sleep(5000);
            Assert.IsTrue(browser.Span("ctl00_uxMainContent_uxErrorMessage").Text.Contains("Routing number already exists"));
        }

        [Test]
        public void T03_ACHBlacklist_AddBlank()
        {
            this.LoginPortalAdmin();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxBankRoutingNumber")).TypeText("");
            browser.Button(Find.ById("ctl00_uxMainContent_uxAddBlacklist")).Click();
            System.Threading.Thread.Sleep(5000);
            Assert.IsTrue(browser.Span("ctl00_uxMainContent_uxErrorMessage").Text.Contains("Routing Number is required"));
        }

        [Test]
        public void T04_ACHBlacklist_AddInvalid()
        {
            this.LoginPortalAdmin();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxBankRoutingNumber")).TypeText("123456789");
            browser.Button(Find.ById("ctl00_uxMainContent_uxAddBlacklist")).Click();
            System.Threading.Thread.Sleep(5000);
            Assert.IsTrue(browser.Span("ctl00_uxMainContent_uxErrorMessage").Text.Contains("Routing Number is invalid"));
        }

        [Test]
        public void T05_ACHBlacklist_RelateBlacklist()
        {
            browser.GoTo(targetHost);
            UserSignIn(UN, PW, false, 2);
            browser.GoTo("https://trading.qa.maia.zecco.com/transfers/viewaccountlinks.aspx");
            System.Threading.Thread.Sleep(5000);
            browser.Button(Find.ById("uxShowACHForm")).Click();
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxAccountList_Select")).Option(Find.ByText("Individual - 31474281")).Select();
            System.Threading.Thread.Sleep(2000);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxABARoutingNumber")).TypeText("031176110");
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxBankAccount")).TypeText("146022432");
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxBankAccountConfirm")).TypeText("146022432");
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxAccountNickName")).TypeText("123456789");
            //browser.RadioButton(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxAccountType_0")).Checked = true;
            browser.RadioButton(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxAccountType_1")).Checked = true;
            browser.Button(Find.ById("uxSubmit")).Click();
            System.Threading.Thread.Sleep(5000);
            Assert.IsTrue(browser.Div(Find.ById("uxSuccessMessage")).Exists);
        }

        [Test]
        public void T06_ACHBlacklist_Remove()
        {
            this.LoginPortalAdmin();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxBankRoutingNumber")).TypeText("031176110");
            browser.Button(Find.ById("ctl00_uxMainContent_uxRemoveBlacklist")).Click();
            System.Threading.Thread.Sleep(5000);
            Assert.IsTrue(browser.Span("ctl00_uxMainContent_uxSuccessMessage").Text.Contains("Routing Number has been successfully removed"));
        }

        [Test]
        public void T07_ACHBlacklist_RemoveNotExist()
        {
            this.LoginPortalAdmin();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxBankRoutingNumber")).TypeText("031176110");
            browser.Button(Find.ById("ctl00_uxMainContent_uxRemoveBlacklist")).Click();
            System.Threading.Thread.Sleep(5000);
            Assert.IsTrue(browser.Span("ctl00_uxMainContent_uxErrorMessage").Text.Contains("Routing Number is not found"));
        }

        [Test]
        public void T08_ACHBlacklist_RelateNoBlacklist()
        {
            browser.GoTo(targetHost);
            UserSignIn(UN, PW, false, 2);
            browser.GoTo("https://trading.qa.maia.zecco.com/transfers/viewaccountlinks.aspx");
            System.Threading.Thread.Sleep(5000);
            browser.Button(Find.ById("uxShowACHForm")).Click();
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxAccountList_Select")).Option(Find.ByText("Individual - 31474281")).Select();
            System.Threading.Thread.Sleep(2000);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxABARoutingNumber")).TypeText("031176110");
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxBankAccount")).TypeText("146022432");
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxBankAccountConfirm")).TypeText("146022432");
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxAccountNickName")).TypeText("123456789");
            //browser.RadioButton(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxAccountType_0")).Checked = true;
            browser.RadioButton(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxAccountType_1")).Checked = true;
            browser.Button(Find.ById("uxSubmit")).Click();
            System.Threading.Thread.Sleep(5000);
            Assert.IsTrue(browser.TextField(Find.ById("Verify_Single_Answer_Text_Val1")).Exists);
            Assert.IsTrue(browser.TextField(Find.ById("Verify_Single_Answer_Password_Val2")).Exists);
            Assert.IsTrue(browser.TextField(Find.ById("Verify_Single_Answer_Password_Val3")).Exists);
        }

        private void LoginPortalAdmin()
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
            browser.Div(Find.ById("ctl00_uxMainContent_uxManageACHRelationships")).Link(Find.ByText("Manage ACH Relationships")).Click();
            browser.WaitForComplete();
        }
    }
}
