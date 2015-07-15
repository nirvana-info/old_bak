using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks._2010Spring6
{
    [TestFixture]
    public class S006_NewAcctTypeCheck_Module : OLA
    {
        [Test]
        public void T01_NewAcctTypeCheck_PersonBizTrust()
        {
            this.GotoOLA(UN_OLA, PW_OLA);
            browser.Link(Find.ById("")).Click();
            browser.Button(Find.ById("submit-btn")).WaitUntilExists(20);
            Assert.AreEqual(browser.Link(Find.ById("linkcorporate")).Url, "javascript:void(0);");
            Assert.AreEqual(browser.Link(Find.ById("linkpartnership")).Url, "javascript:void(0);");
            Assert.AreEqual(browser.Link(Find.ById("linkllc")).Url, "javascript:void(0);");
            Assert.AreEqual(browser.Link(Find.ById("linktrust")).Url, "javascript:void(0);");
        }

        [Test]
        public void T02_NewAcctTypeCheck_PersonBizTrust_Admin()
        {
            this.GoToOLAAdmin();
            browser.TextField(Find.ById("ctl00_quickAccessUserName")).TypeText(UN_OLA);
            browser.Button(Find.ById("ctl00_btnUserName")).Click();
            this.Preview_BizTrust("Corporate", "123121234", "");
            Assert.AreEqual(browser.Span(Find.ById("ctl00_InsertPnl_ErrorMsg")).Text.Trim(), "Error - User has an incompatible account type under this username");
        }

        [Test]
        public void T03_NewAcctTypeCheck_PersonCustodial()
        {
            this.GotoOLA(UN_OLA, PW_OLA);
            browser.Link(Find.ById("")).Click();
            browser.Button(Find.ById("submit-btn")).WaitUntilExists(20);
            Assert.IsTrue(browser.Link(Find.ById("linkcustodial")).Url.Contains("/forms/custodial-account-application/downloadform.aspx"));
            Assert.IsTrue(browser.Link(Find.ById("linkcoverdell")).Url.Contains("/forms/coverdell-account-application/downloadform.aspx"));
        }

        [Test]
        public void T04_NewAcctTypeCheck_PersonCustodial_Admin()
        {
            this.GoToOLAAdmin();
            browser.TextField(Find.ById("ctl00_quickAccessUserName")).TypeText(UN_OLA);
            browser.Button(Find.ById("ctl00_btnUserName")).Click();
            this.Preview_Custodial("Coverdell", "123121234", "", "", "234232345", "", "");
            string referNum = string.Empty;
            string pensonNum = this.Generate_Custodial("Coverdell", "123121234", "", "", "234232345", "", "", ref referNum);
            Assert.AreEqual(browser.Table(Find.ById("ctl00_ContentPlaceHolder1_RequestList1_grdSearchResults")).TableBodies[0].TableRows[1].TableCells[0].Text.Trim(), referNum);
            Assert.IsTrue(!browser.Table(Find.ById("ctl00_ContentPlaceHolder1_RequestList1_grdSearchResults")).TableBodies[0].TableRows[1].TableCells[0].Enabled);
            Assert.AreEqual(browser.Table(Find.ById("ctl00_ContentPlaceHolder1_RequestList1_grdSearchResults")).TableBodies[0].TableRows[1].TableCells[2].Text.Trim(), pensonNum);
        }

        [Test]
        public void T05_NewAcctTypeCheck_BizTrustPerson()
        {
            this.GotoOLA(UN_BizTrust, PW_BizTrust);
            browser.CheckBox(Find.ById("Welcome_uxIndividual")).Checked = true;
            Assert.IsTrue(browser.ContainsText("Invalid Account Type:"));
        }

        [Test]
        public void T06_NewAcctTypeCheck_BizTrustCustodial()
        {
            this.GotoOLA(UN_BizTrust, PW_BizTrust);
            browser.Link(Find.ById("")).Click();
            browser.Button(Find.ById("submit-btn")).WaitUntilExists(20);
            Assert.AreEqual(browser.Link(Find.ById("linkcustodial")).Url, "javascript:void(0);");
            Assert.AreEqual(browser.Link(Find.ById("linkcoverdell")).Url, "javascript:void(0);");
        }

        [Test]
        public void T07_NewAcctTypeCheck_BizTrustCustodial_Admin()
        {
            this.GoToOLAAdmin();
            browser.TextField(Find.ById("ctl00_quickAccessUserName")).TypeText(UN_BizTrust);
            browser.Button(Find.ById("ctl00_btnUserName")).Click();
            this.Preview_Custodial("Coverdell", "123121234", "", "", "234232345", "", "");
            Assert.AreEqual(browser.Span(Find.ById("ctl00_InsertPnl_ErrorMsg")).Text.Trim(), "Error - User has an incompatible account type under this username");
        }

        [Test]
        public void T08_NewAcctTypeCheck_CustodialPerson()
        {
            this.GotoOLA(UN_Custodial, PW_Custodial);
            browser.CheckBox(Find.ById("Welcome_uxIndividual")).Checked = true;
            browser.Button(Find.ById("Welcome_uxSubmit")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxPersonal_PersonalInfo_SocialNumber")).Exists);
        }

        [Test]
        public void T09_NewAcctTypeCheck_CustodialBizTrust()
        {
            this.GotoOLA(UN_Custodial, PW_Custodial);
            browser.Link(Find.ById("")).Click();
            browser.Button(Find.ById("submit-btn")).WaitUntilExists(20);
            Assert.AreEqual(browser.Link(Find.ById("linkcorporate")).Url, "javascript:void(0);");
            Assert.AreEqual(browser.Link(Find.ById("linkpartnership")).Url, "javascript:void(0);");
            Assert.AreEqual(browser.Link(Find.ById("linkllc")).Url, "javascript:void(0);");
            Assert.AreEqual(browser.Link(Find.ById("linktrust")).Url, "javascript:void(0);");
        }

        [Test]
        public void T10_NewAcctTypeCheck_CustodialBizTrust_Admin()
        {
            this.GoToOLAAdmin();
            browser.TextField(Find.ById("ctl00_quickAccessUserName")).TypeText(UN_Custodial);
            browser.Button(Find.ById("ctl00_btnUserName")).Click();
            this.Preview_BizTrust("Trust", "123121234", "");
            Assert.AreEqual(browser.Span(Find.ById("ctl00_InsertPnl_ErrorMsg")).Text.Trim(), "Error - User has an incompatible account type under this username");
        }
    }
}
