using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks.Spring5.S004_ACH_Module
{
    [TestFixture]
    public class S004_ACH_Module_1 : ACH
    {
        [Test]
        public void T01_ACH_ViewMaxNum()
        {
            this.GotoACHAdmin();
            browser.Div(Find.ById("ctl00_uxMainContent_uxManageACHRelationships")).Link(Find.ByText("Manage ACH Relationships")).Click();
            browser.WaitForComplete(10);
            Assert.IsFalse(browser.TextField(Find.ById("ctl00_uxMainContent_uxGloballimit")).Enabled);
        }

        [Test]
        public void T02_ACH_ChangeOnlineLimit()
        {
            this.GotoACHAdmin();
            browser.Div(Find.ById("ctl00_uxMainContent_uxManageACHRelationships")).Link(Find.ByText("Manage ACH Relationships")).Click();
            browser.WaitForComplete(10);
            browser.TextField(Find.ById("ctl00_uxMainContent_uxOnlinelimit")).TypeText("3");
            browser.Button(Find.ById("ctl00_uxMainContent_uxSave")).Click();
            Assert.AreEqual(browser.Span(Find.ById("ctl00_uxMainContent_uxSuccessMessage")).Text, "Thanks! You have successfully added all ACH relationship limits.");
        }

        [Test]
        public void T03_ACH_AdjustLimit()
        {
            this.GotoACHAdmin();
            browser.Div(Find.ById("ctl00_uxMainContent_uxManageACHRelationships")).Link(Find.ByText("Manage ACH Relationships")).Click();
            browser.WaitForComplete(10);
            browser.TextField(Find.ById("ctl00_uxMainContent_uxKeyword")).TypeText("tonyleachsf");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option("UserName").Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
            Assert.IsTrue(browser.Div(Find.ById("ctl00_uxMainContent_uxListGridView")).Exists);
        }

        [Test]
        public void T04_ACH_AuditTrail()
        {
            this.GotoACHAdmin();
            browser.Div(Find.ById("ctl00_uxMainContent_uxManageACHRelationships")).Link(Find.ByText("Manage ACH Relationships")).Click();
            browser.WaitForComplete(10);
            Console.WriteLine(browser.Link(Find.ByText("history")).Exists);
            browser.Link(Find.ByText("history")).Click();
            Assert.IsTrue(browser.Div(Find.ById("ctl00_uxMainContent_uxUserLevelChangedListView")).Exists);
        }

        [Test]
        public void T05_ACH_AuditTrailAccount()
        {
            this.GotoACHAdmin();
            browser.Div(Find.ById("ctl00_uxMainContent_uxManageACHRelationships")).Link(Find.ByText("Manage ACH Relationships")).Click();
            browser.WaitForComplete(10);
            browser.TextField(Find.ById("ctl00_uxMainContent_uxKeyword")).TypeText("tonyleachsf");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option("UserName").Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
            browser.WaitForComplete(10);
            browser.Table(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00")).TableRow(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00__0")).Link(Find.ByText("history")).Click();
            Assert.IsTrue(browser.Div(Find.ById("ctl00_uxMainContent_uxUserLevelChangedListView")).Exists);
        }

        [Test]
        public void T06_ACH_CashTranferRulesMaxiACHAmount()
        {
            this.GotoACHAdmin();
            browser.Div(Find.ById("ctl00_uxMainContent_uxAutomationRules")).Link(Find.ByText("Cash Transfer Automation")).Click();
            browser.WaitForComplete(10);
            Assert.IsTrue(browser.TextField(Find.ById("ctl00_uxMainContent_uxMaxiIncomingACHAmount")).Exists);
            Assert.IsTrue(browser.TextField(Find.ById("ctl00_uxMainContent_uxMaxiOutgoingACHAmount")).Exists);
        }

        [Test]
        public void T07_ACH_CashTranferRulesMiniAmount()
        {
            this.GotoACHAdmin();
            browser.Div(Find.ById("ctl00_uxMainContent_uxAutomationRules")).Link(Find.ByText("Cash Transfer Automation")).Click();
            browser.WaitForComplete(10);
            Assert.IsTrue(browser.TextField(Find.ById("ctl00_uxMainContent_uxMiniAmount")).Exists);
        }

        [Test]
        public void T08_ACH_CashTranferRulesMaxiACHAmountDay()
        {
            this.GotoACHAdmin();
            browser.Div(Find.ById("ctl00_uxMainContent_uxAutomationRules")).Link(Find.ByText("Cash Transfer Automation")).Click();
            browser.WaitForComplete(10);
            Assert.IsTrue(browser.TextField(Find.ById("ctl00_uxMainContent_uxMaxiIncomingACHAmountDay")).Exists);
            Assert.IsTrue(browser.TextField(Find.ById("ctl00_uxMainContent_uxMaxiOutgoingACHAmountDay")).Exists);
        }

        [Test]
        public void T09_ACH_CashTranferRulesDeposit()
        {
            this.GotoACHAdmin();
            browser.Div(Find.ById("ctl00_uxMainContent_uxAutomationRules")).Link(Find.ByText("Cash Transfer Automation")).Click();
            browser.WaitForComplete(10);
            Assert.IsTrue(browser.TextField(Find.ById("ctl00_uxMainContent_uxAmountT4Limit")).Exists);
            Assert.IsTrue(browser.TextField(Find.ById("ctl00_uxMainContent_uxRatio")).Exists);
            Assert.IsTrue(browser.TextField(Find.ById("ctl00_uxMainContent_uxCashDepositNumber")).Exists);
        }

        [Test]
        public void T10_ACH_CashTranferRulesMinimumEquityValue()
        {
            this.GotoACHAdmin();
            browser.Div(Find.ById("ctl00_uxMainContent_uxAutomationRules")).Link(Find.ByText("Cash Transfer Automation")).Click();
            browser.WaitForComplete(10);
            Assert.IsTrue(browser.TextField(Find.ById("ctl00_uxMainContent_uxLevel4MinimumEquityValue")).Exists);
        }

        [Test]
        public void T11_ACH_CashTranferRulesAML()
        {
            this.GotoACHAdmin();
            browser.Div(Find.ById("ctl00_uxMainContent_uxAutomationRules")).Link(Find.ByText("Cash Transfer Automation")).Click();
            browser.WaitForComplete(10);
            Assert.IsTrue(browser.TextField(Find.ById("ctl00_uxMainContent_uxTransferNumberAMLFlag")).Exists);
            Assert.IsTrue(browser.TextField(Find.ById("ctl00_uxMainContent_uxAMLMonths")).Exists);
            Assert.IsTrue(browser.TextField(Find.ById("ctl00_uxMainContent_uxAmountAMLFlag")).Exists);
        }

        [Test]
        public void T12_ACH_CashTranferRulesDormantMonths()
        {
            this.GotoACHAdmin();
            browser.Div(Find.ById("ctl00_uxMainContent_uxAutomationRules")).Link(Find.ByText("Cash Transfer Automation")).Click();
            browser.WaitForComplete(10);
            Assert.IsTrue(browser.TextField(Find.ById("ctl00_uxMainContent_uxDormantMonths")).Exists);
        }

        [Test]
        public void T13_ACH_CashTranferRulesReverseCashMonths()
        {
            this.GotoACHAdmin();
            browser.Div(Find.ById("ctl00_uxMainContent_uxAutomationRules")).Link(Find.ByText("Cash Transfer Automation")).Click();
            browser.WaitForComplete(10);
            Assert.IsTrue(browser.TextField(Find.ById("ctl00_uxMainContent_uxReverseCashMonths")).Exists);
        }

        [Test]
        public void T14_ACH_CashTranferRulesManualReviewAmount()
        {
            this.GotoACHAdmin();
            browser.Div(Find.ById("ctl00_uxMainContent_uxAutomationRules")).Link(Find.ByText("Cash Transfer Automation")).Click();
            browser.WaitForComplete(10);
            Assert.IsTrue(browser.TextField(Find.ById("ctl00_uxMainContent_uxIncomingManualReviewAmount")).Exists);
            Assert.IsTrue(browser.TextField(Find.ById("ctl00_uxMainContent_uxOutgoingManualReviewAmount")).Exists);
        }

        [Test]
        public void T15_ACH_CashTranferRulesSave()
        {
            this.GotoACHAdmin();
            browser.Div(Find.ById("ctl00_uxMainContent_uxAutomationRules")).Link(Find.ByText("Cash Transfer Automation")).Click();
            browser.WaitForComplete(10);
            browser.Button(Find.ById("ctl00_uxMainContent_uxSave")).Click();
            Assert.IsTrue(browser.Span(Find.ById("ctl00_uxMainContent_uxSuccessMessage")).Exists);
        }
    }
}
