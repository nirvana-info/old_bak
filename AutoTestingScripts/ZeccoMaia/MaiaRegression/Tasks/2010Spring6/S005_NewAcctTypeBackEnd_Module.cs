using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks._2010Spring6
{
    [TestFixture]
    public class S005_NewAcctTypeBackEnd_Module : OLA
    {
        [Test]
        public void T01_NewAcctTypeBackEnd_Corporate()
        {
            this.GoToOLAAdmin();
            browser.TextField(Find.ById("ctl00_quickAccessUserName")).TypeText(UN_BizTrust);
            browser.Button(Find.ById("ctl00_btnUserName")).Click();
            this.Preview_BizTrust("Corporate", "123121234", "");
            string referNum = string.Empty;
            string pensonNum = this.Generate_BizTrust("Corporate", "123121234", "", ref referNum);
            Assert.AreEqual(browser.Table(Find.ById("ctl00_ContentPlaceHolder1_RequestList1_grdSearchResults")).TableBodies[0].TableRows[1].TableCells[0].Text.Trim(), referNum);
            Assert.IsTrue(!browser.Table(Find.ById("ctl00_ContentPlaceHolder1_RequestList1_grdSearchResults")).TableBodies[0].TableRows[1].TableCells[0].Enabled);
            Assert.AreEqual(browser.Table(Find.ById("ctl00_ContentPlaceHolder1_RequestList1_grdSearchResults")).TableBodies[0].TableRows[1].TableCells[2].Text.Trim(), pensonNum);
        }

        [Test]
        public void T02_NewAcctTypeBackEnd_CorporateCash()
        {
            this.GoToOLAAdmin();
            browser.TextField(Find.ById("ctl00_quickAccessUserName")).TypeText(UN_BizTrust);
            browser.Button(Find.ById("ctl00_btnUserName")).Click();
            this.Preview_BizTrust("Corporate(Cash)", "123121234", "");
            string referNum = string.Empty;
            string pensonNum = this.Generate_BizTrust("Corporate(Cash)", "123121234", "", ref referNum);
            Assert.AreEqual(browser.Table(Find.ById("ctl00_ContentPlaceHolder1_RequestList1_grdSearchResults")).TableBodies[0].TableRows[1].TableCells[0].Text.Trim(), referNum);
            Assert.IsTrue(!browser.Table(Find.ById("ctl00_ContentPlaceHolder1_RequestList1_grdSearchResults")).TableBodies[0].TableRows[1].TableCells[0].Enabled);
            Assert.AreEqual(browser.Table(Find.ById("ctl00_ContentPlaceHolder1_RequestList1_grdSearchResults")).TableBodies[0].TableRows[1].TableCells[2].Text.Trim(), pensonNum);
        }

        [Test]
        public void T03_NewAcctTypeBackEnd_Trust()
        {
            this.GoToOLAAdmin();
            browser.TextField(Find.ById("ctl00_quickAccessUserName")).TypeText(UN_BizTrust);
            browser.Button(Find.ById("ctl00_btnUserName")).Click();
            this.Preview_BizTrust("Trust", "123121234", "");
            string referNum = string.Empty;
            string pensonNum = this.Generate_BizTrust("Trust", "123121234", "", ref referNum);
            Assert.AreEqual(browser.Table(Find.ById("ctl00_ContentPlaceHolder1_RequestList1_grdSearchResults")).TableBodies[0].TableRows[1].TableCells[0].Text.Trim(), referNum);
            Assert.IsTrue(!browser.Table(Find.ById("ctl00_ContentPlaceHolder1_RequestList1_grdSearchResults")).TableBodies[0].TableRows[1].TableCells[0].Enabled);
            Assert.AreEqual(browser.Table(Find.ById("ctl00_ContentPlaceHolder1_RequestList1_grdSearchResults")).TableBodies[0].TableRows[1].TableCells[2].Text.Trim(), pensonNum);
        }

        [Test]
        public void T04_NewAcctTypeBackEnd_TrustCash()
        {
            this.GoToOLAAdmin();
            browser.TextField(Find.ById("ctl00_quickAccessUserName")).TypeText(UN_BizTrust);
            browser.Button(Find.ById("ctl00_btnUserName")).Click();
            this.Preview_BizTrust("Trust(Cash)", "123121234", "");
            string referNum = string.Empty;
            string pensonNum = this.Generate_BizTrust("Trust(Cash)", "123121234", "", ref referNum);
            Assert.AreEqual(browser.Table(Find.ById("ctl00_ContentPlaceHolder1_RequestList1_grdSearchResults")).TableBodies[0].TableRows[1].TableCells[0].Text.Trim(), referNum);
            Assert.IsTrue(!browser.Table(Find.ById("ctl00_ContentPlaceHolder1_RequestList1_grdSearchResults")).TableBodies[0].TableRows[1].TableCells[0].Enabled);
            Assert.AreEqual(browser.Table(Find.ById("ctl00_ContentPlaceHolder1_RequestList1_grdSearchResults")).TableBodies[0].TableRows[1].TableCells[2].Text.Trim(), pensonNum);
        }

        [Test]
        public void T05_NewAcctTypeBackEnd_LLC()
        {
            this.GoToOLAAdmin();
            browser.TextField(Find.ById("ctl00_quickAccessUserName")).TypeText(UN_BizTrust);
            browser.Button(Find.ById("ctl00_btnUserName")).Click();
            this.Preview_BizTrust("LLC", "123121234", "");
            string referNum = string.Empty;
            string pensonNum = this.Generate_BizTrust("LLC", "123121234", "", ref referNum);
            Assert.AreEqual(browser.Table(Find.ById("ctl00_ContentPlaceHolder1_RequestList1_grdSearchResults")).TableBodies[0].TableRows[1].TableCells[0].Text.Trim(), referNum);
            Assert.IsTrue(!browser.Table(Find.ById("ctl00_ContentPlaceHolder1_RequestList1_grdSearchResults")).TableBodies[0].TableRows[1].TableCells[0].Enabled);
            Assert.AreEqual(browser.Table(Find.ById("ctl00_ContentPlaceHolder1_RequestList1_grdSearchResults")).TableBodies[0].TableRows[1].TableCells[2].Text.Trim(), pensonNum);
        }

        [Test]
        public void T06_NewAcctTypeBackEnd_LLCCash()
        {
            this.GoToOLAAdmin();
            browser.TextField(Find.ById("ctl00_quickAccessUserName")).TypeText(UN_BizTrust);
            browser.Button(Find.ById("ctl00_btnUserName")).Click();
            this.Preview_BizTrust("LLC(Cash)", "123121234", "");
            string referNum = string.Empty;
            string pensonNum = this.Generate_BizTrust("LLC(Cash)", "123121234", "", ref referNum);
            Assert.AreEqual(browser.Table(Find.ById("ctl00_ContentPlaceHolder1_RequestList1_grdSearchResults")).TableBodies[0].TableRows[1].TableCells[0].Text.Trim(), referNum);
            Assert.IsTrue(!browser.Table(Find.ById("ctl00_ContentPlaceHolder1_RequestList1_grdSearchResults")).TableBodies[0].TableRows[1].TableCells[0].Enabled);
            Assert.AreEqual(browser.Table(Find.ById("ctl00_ContentPlaceHolder1_RequestList1_grdSearchResults")).TableBodies[0].TableRows[1].TableCells[2].Text.Trim(), pensonNum);
        }

        [Test]
        public void T07_NewAcctTypeBackEnd_Partnership()
        {
            this.GoToOLAAdmin();
            browser.TextField(Find.ById("ctl00_quickAccessUserName")).TypeText(UN_BizTrust);
            browser.Button(Find.ById("ctl00_btnUserName")).Click();
            this.Preview_BizTrust("Partnership", "123121234", "");
            string referNum = string.Empty;
            string pensonNum = this.Generate_BizTrust("Partnership", "123121234", "", ref referNum);
            Assert.AreEqual(browser.Table(Find.ById("ctl00_ContentPlaceHolder1_RequestList1_grdSearchResults")).TableBodies[0].TableRows[1].TableCells[0].Text.Trim(), referNum);
            Assert.IsTrue(!browser.Table(Find.ById("ctl00_ContentPlaceHolder1_RequestList1_grdSearchResults")).TableBodies[0].TableRows[1].TableCells[0].Enabled);
            Assert.AreEqual(browser.Table(Find.ById("ctl00_ContentPlaceHolder1_RequestList1_grdSearchResults")).TableBodies[0].TableRows[1].TableCells[2].Text.Trim(), pensonNum);
        }

        [Test]
        public void T08_NewAcctTypeBackEnd_PartnershipCash()
        {
            this.GoToOLAAdmin();
            browser.TextField(Find.ById("ctl00_quickAccessUserName")).TypeText(UN_BizTrust);
            browser.Button(Find.ById("ctl00_btnUserName")).Click();
            this.Preview_BizTrust("Partnership(Cash)", "123121234", "");
            string referNum = string.Empty;
            string pensonNum = this.Generate_BizTrust("Partnership(Cash)", "123121234", "", ref referNum);
            Assert.AreEqual(browser.Table(Find.ById("ctl00_ContentPlaceHolder1_RequestList1_grdSearchResults")).TableBodies[0].TableRows[1].TableCells[0].Text.Trim(), referNum);
            Assert.IsTrue(!browser.Table(Find.ById("ctl00_ContentPlaceHolder1_RequestList1_grdSearchResults")).TableBodies[0].TableRows[1].TableCells[0].Enabled);
            Assert.AreEqual(browser.Table(Find.ById("ctl00_ContentPlaceHolder1_RequestList1_grdSearchResults")).TableBodies[0].TableRows[1].TableCells[2].Text.Trim(), pensonNum);
        }

        [Test]
        public void T09_NewAcctTypeBackEnd_CustodialUTMA()
        {
            this.GoToOLAAdmin();
            browser.TextField(Find.ById("ctl00_quickAccessUserName")).TypeText(UN_Custodial);
            browser.Button(Find.ById("ctl00_btnUserName")).Click();
            this.Preview_Custodial("Custodial(UTMA-all other states)", "123121234", "", "", "234232345", "", "");
            string referNum = string.Empty;
            string pensonNum = this.Generate_Custodial("Custodial(UTMA-all other states)", "123121234", "", "", "234232356", "", "", ref referNum);
            Assert.AreEqual(browser.Table(Find.ById("ctl00_ContentPlaceHolder1_RequestList1_grdSearchResults")).TableBodies[0].TableRows[1].TableCells[0].Text.Trim(), referNum);
            Assert.IsTrue(!browser.Table(Find.ById("ctl00_ContentPlaceHolder1_RequestList1_grdSearchResults")).TableBodies[0].TableRows[1].TableCells[0].Enabled);
            Assert.AreEqual(browser.Table(Find.ById("ctl00_ContentPlaceHolder1_RequestList1_grdSearchResults")).TableBodies[0].TableRows[1].TableCells[2].Text.Trim(), pensonNum);
        }

        [Test]
        public void T10_NewAcctTypeBackEnd_CustodialUGMA()
        {
            this.GoToOLAAdmin();
            browser.TextField(Find.ById("ctl00_quickAccessUserName")).TypeText(UN_Custodial);
            browser.Button(Find.ById("ctl00_btnUserName")).Click();
            this.Preview_Custodial("Custodial(UGMA-SC, VT only)", "123121234", "", "", "234232345", "", "");
            string referNum = string.Empty;
            string pensonNum = this.Generate_Custodial("Custodial(UGMA-SC, VT only)", "123121234", "", "", "234232356", "", "", ref referNum);
            Assert.AreEqual(browser.Table(Find.ById("ctl00_ContentPlaceHolder1_RequestList1_grdSearchResults")).TableBodies[0].TableRows[1].TableCells[0].Text.Trim(), referNum);
            Assert.IsTrue(!browser.Table(Find.ById("ctl00_ContentPlaceHolder1_RequestList1_grdSearchResults")).TableBodies[0].TableRows[1].TableCells[0].Enabled);
            Assert.AreEqual(browser.Table(Find.ById("ctl00_ContentPlaceHolder1_RequestList1_grdSearchResults")).TableBodies[0].TableRows[1].TableCells[2].Text.Trim(), pensonNum);
        }

        [Test]
        public void T11_NewAcctTypeBackEnd_Coverdell()
        {
            this.GoToOLAAdmin();
            browser.TextField(Find.ById("ctl00_quickAccessUserName")).TypeText(UN_Custodial);
            browser.Button(Find.ById("ctl00_btnUserName")).Click();
            this.Preview_Custodial("Coverdell", "123121234", "", "", "234232356", "", "");
            string referNum = string.Empty;
            string pensonNum = this.Generate_Custodial("Coverdell", "123121234", "", "", "234232345", "", "", ref referNum);
            Assert.AreEqual(browser.Table(Find.ById("ctl00_ContentPlaceHolder1_RequestList1_grdSearchResults")).TableBodies[0].TableRows[1].TableCells[0].Text.Trim(), referNum);
            Assert.IsTrue(!browser.Table(Find.ById("ctl00_ContentPlaceHolder1_RequestList1_grdSearchResults")).TableBodies[0].TableRows[1].TableCells[0].Enabled);
            Assert.AreEqual(browser.Table(Find.ById("ctl00_ContentPlaceHolder1_RequestList1_grdSearchResults")).TableBodies[0].TableRows[1].TableCells[2].Text.Trim(), pensonNum);
        }

        [Test]
        public void T12_NewAcctTypeBackEnd_Cancel()
        {
            this.GoToOLAAdmin();
            browser.TextField(Find.ById("ctl00_quickAccessUserName")).TypeText(UN_BizTrust);
            browser.Button(Find.ById("ctl00_btnUserName")).Click();
            browser.Link(Find.ByText("Cancel")).WaitUntilExists(20);
            browser.Link(Find.ByText("Cancel")).Click();
            Assert.IsTrue(browser.Link(Find.ById("ctl00_hplLogout")).Exists);
        }

        [Test]
        public void T13_NewAcctTypeBackEnd_EditBizTrust()
        {
            this.GoToOLAAdmin();
            browser.TextField(Find.ById("ctl00_quickAccessUserName")).TypeText(UN_BizTrust);
            browser.Button(Find.ById("ctl00_btnUserName")).Click();
            this.Preview_BizTrust("Corporate", "123121234", "");
            browser.Link(Find.ByText("Edit")).WaitUntilExists(20);
            browser.Link(Find.ByText("Edit")).Click();
            Assert.IsTrue(browser.SelectList(Find.ById("ctl00_InsertPnl_AccountType")).Exists);
            browser.Link(Find.ByText("Cancel")).Click();
        }

        [Test]
        public void T14_NewAcctTypeBackEnd_EditCustodial()
        {
            this.GoToOLAAdmin();
            browser.TextField(Find.ById("ctl00_quickAccessUserName")).TypeText(UN_Custodial);
            browser.Button(Find.ById("ctl00_btnUserName")).Click();
            this.Preview_Custodial("Corporate", "123121234", "", "", "234232345", "", "");
            browser.Link(Find.ByText("Edit")).WaitUntilExists(20);
            browser.Link(Find.ByText("Edit")).Click();
            Assert.IsTrue(browser.SelectList(Find.ById("ctl00_InsertPnl_AccountType")).Exists);
            browser.Link(Find.ByText("Cancel")).Click();
        }

        [Test]
        public void T15_NewAcctTypeBackEnd_QuickAccess()
        {
            this.GoToOLAAdmin();
            browser.TextField(Find.ById("ctl00_quickAccessRequestId")).TypeText("");
            browser.Button(Find.ById("ctl00_btnRequestID")).Click();
            System.Threading.Thread.Sleep(5000);
            Assert.AreEqual(browser.TextField(Find.ById("ctl00_ContentPlaceHolder1_requestId")).Text.Trim(), "");
        }

        [Test]
        public void T16_NewAcctTypeBackEnd_SSNmismatch()
        {
            this.GoToOLAAdmin();
            browser.TextField(Find.ById("ctl00_quickAccessUserName")).TypeText(UN_BizTrust);
            browser.Button(Find.ById("ctl00_btnUserName")).Click();
            this.Preview_BizTrust("Corporate", "123120000", "");
            Assert.AreEqual(browser.Span(Find.ById("ctl00_InsertPnl_ErrorMsg")).Text.Trim(), "Error - User has a non-matching SSN/TIN on another account under this username");
            browser.Link(Find.ByText("Cancel")).Click();
        }
    }
}
