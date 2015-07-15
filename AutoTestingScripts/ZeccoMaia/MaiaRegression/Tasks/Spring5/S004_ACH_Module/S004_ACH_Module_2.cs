using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks.Spring5.S004_ACH_Module
{
    [TestFixture]
    public class S004_ACH_Module_2 : ACH
    {
        [Test]
        public void T01_ACH_LinkedBankAccount()
        {
            this.GotoACH();
            browser.Div(Find.ByClass("webpartsupportcenter")).Link(Find.ByText("Linked Bank Accounts")).Click();
            browser.WaitForComplete(10);
            Assert.IsTrue(browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxDropDowBankAccountList")).Exists);
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
        }

        [Test]
        public void T02_ACH_VerifyRelationship()
        {
            this.GotoACH();
            browser.Div(Find.ByClass("webpartsupportcenter")).Link(Find.ByText("Linked Bank Accounts")).Click();
            browser.WaitForComplete(10);
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxContentsGridView_ctl00_ctl06_uxVerify")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxAmount1")).TypeText("1");
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxAmount2")).TypeText("2");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxConfirmVerify")).Click();
            //Assert.IsTrue();
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
        }

        [Test]
        public void T03_ACH_CancelRelationship()
        {
            this.GotoACH();
            browser.Div(Find.ByClass("webpartsupportcenter")).Link(Find.ByText("Linked Bank Accounts")).Click();
            browser.WaitForComplete(10);
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxContentsGridView_ctl00_ctl04_uxCancelRelationship")).Click();
            Assert.IsTrue(browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxContentsGridView_ctl00_ctl04_uxConfirmCancelButton")).Exists);
            browser.Button(Find.ById("uxGobackButton")).Click();
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
        }

        [Test]
        public void T04_ACH_TransferMoney()
        {
            this.GotoACH();
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxAccountFrom_Select")).Options[1].Select();
            System.Threading.Thread.Sleep(5000);
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxAccountTo_Select")).Options[1].Select();
            System.Threading.Thread.Sleep(5000);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxAmount")).TypeText("$0.00");
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxDateInput")).TypeText(DateTime.Now.AddDays(1).ToShortDateString());
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxFrequency")).Option("One Time").Select();
            browser.Button(Find.ById("uxSubmit")).Click();
            System.Threading.Thread.Sleep(5000);
            browser.Button(Find.ById("uxConfirm")).Click();
            System.Threading.Thread.Sleep(5000);
            Assert.IsTrue(browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxSuccessMessage")).Exists);
            Assert.AreEqual(browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxSuccessMessage")).Text, "Thank you for your transfer!");
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
        }

        [Test]
        public void T05_ACH_DepositCheck()
        {
            this.GotoACH();
            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxOtherTransferLink_uxMailCheck")).Link(Find.ByText("Deposit a Check")).Click();
            Assert.IsTrue(browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxAccountNum")).Exists);
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
        }

        [Test]
        public void T06_ACH_DepositWire()
        {
            this.GotoACH();
            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxOtherTransferLink_uxIncomingwire")).Link(Find.ByText("Deposit via Wire Transfer")).Click();
            Assert.IsTrue(browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxAccountFrom")).Exists);
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
        }

        [Test]
        public void T07_ACH_WithdrawCheck()
        {
            this.GotoACH();
            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxOtherTransferLink_uxRequestcheck")).Link(Find.ByText("Withdraw via Check Request")).Click();
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxAccountFrom_Select")).Options[0].Select();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxAmount")).TypeText("$0.00");
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxDeliveryMethodList")).Options[1].Select();
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxSubmit")).Click();
            System.Threading.Thread.Sleep(5000);
            browser.Button(Find.ById("uxConfirm")).Click();
            System.Threading.Thread.Sleep(5000);
            Assert.IsTrue(browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxSuccessMessage")).Exists);
            Assert.AreEqual(browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxSuccessMessage")).Text, "Thank you for your transfer!");
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
        }

        [Test]
        public void T08_ACH_WithdrawWire()
        {
            this.GotoACH();
            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxOtherTransferLink_uxOutgoingwire")).Link(Find.ByText("Withdraw via Wire Transfer")).Click();
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxAccountList_Select")).Options[0].Select();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxDomesticRoutingNumber")).TypeText("063000021");
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxDomesticBankAccountNumber")).TypeText(DateTime.Today.ToString("yyyyMMdd") + "1");
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxAmount")).TypeText("$0.00");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxSubmit")).Click();
            System.Threading.Thread.Sleep(5000);
            browser.Button(Find.ById("uxConfirm")).Click();
            System.Threading.Thread.Sleep(5000);
            Assert.IsTrue(browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxSuccessMessage")).Exists);
            Assert.AreEqual(browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxSuccessMessage")).Text, "Thank you for your transfer!");
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
        }

        [Test]
        public void T09_ACH_Transfer_Negative()
        {
            this.GotoACH();
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxAccountFrom")).Options[1].Select();
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxAccountTo")).Options[1].Select();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxAmount")).TypeText("");
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxRadDatePicker_dateInput_text")).TypeText("");
            //browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxFrequency")).Option("One Time").Select();
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxSubmit")).Click();
            //Assert.IsTrue();
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
        }

        [Test]
        public void T10_ACH_WithdrawCheck_Negative()
        {
            this.GotoACH();
            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxOtherTransferLink_uxRequestcheck")).Link(Find.ByText("Withdraw via Check Request")).Click();
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxAccountFrom")).Options[0].Select();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxAmount")).TypeText("");
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxDeliveryMethodList")).Options[1].Select();
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxSubmit")).Click();
            //Assert.IsTrue();
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
        }

        [Test]
        public void T11_ACH_WithdrawWire_Negative()
        {
            this.GotoACH();
            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxOtherTransferLink_uxOutgoingwire")).Link(Find.ByText("Withdraw via Wire Transfer")).Click();
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxAccountFrom")).Options[0].Select();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxDomesticRoutingNumber")).TypeText("");
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxDomesticBankAccountNumber")).TypeText("");
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxAmount")).TypeText("");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxSubmit")).Click();
            //Assert.IsTrue();
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
        }

        [Test]
        public void T12_ACH_CashTransferHistory()
        {
            this.GotoACH();
            browser.Div(Find.ByClass("webpartsupportcenter")).Link(Find.ByText("View Transfer Status and History")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxFromDate_dateInput_text")).TypeText(DateTime.Now.AddYears(-1).ToShortDateString());
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxToDate_dateInput_text")).TypeText(DateTime.Now.ToShortDateString());
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxGo")).Click();
            Assert.IsTrue(browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxListGridView_ctl00_ctl04_uxCancel")).Exists);
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
        }

        [Test]
        public void T13_ACH_CancelTransfer()
        {
            this.GotoACH();
            browser.Div(Find.ByClass("webpartsupportcenter")).Link(Find.ByText("View Transfer Status and History")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxFromDate_dateInput_text")).TypeText(DateTime.Now.AddYears(-1).ToShortDateString());
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxToDate_dateInput_text")).TypeText(DateTime.Now.ToShortDateString());
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxGo")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxListGridView_ctl00_ctl04_uxCancel")).Click();
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxListGridView_ctl00_ctl04_uxConfirmButton")).Click();
            System.Threading.Thread.Sleep(10);
            Assert.IsTrue(browser.TableRow(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxListGridView_ctl00__0")).TableCells[6].Text.Contains("Cancelled"));
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
        }
    }
}
