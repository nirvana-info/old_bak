using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using WatiN.Core.Interfaces;
using MaiaRegression.Appobjects;
using MaiaRegression.Appobjects.App02_QuotesAndResearch;
using System.Threading;


namespace MaiaRegression.Tasks.Spring1_2
{
    [TestFixture]
    public class S011_QR_Module : Quotes
    {
        [Test]
        public void T01_QR_Snapshot()
        {
            GotoQR();
            browser.Link(Find.ByText("Snapshot")).Click();
        }

        [Test]
        public void T02_QR_SnapshotPerformance()
        {
            GotoQR();
            browser.Link(Find.ByText("Snapshot")).Click();
            browser.WaitForComplete();
            Assert.IsTrue(browser.Div(Find.ByClass("column column_a")).Div(Find.ById("peer_chart_webpart")).Div(Find.ByText("Performance")).Exists);
        }

        [Test]
        public void T03_QR_SnapshotCommunitySentiment()
        {
            GotoQR();
            browser.Link(Find.ByText("Snapshot")).Click();
            browser.WaitForComplete();
            Assert.IsTrue(browser.Div(Find.ByClass("column column_a")).Div(Find.ById("peer_chart_webpart")).Div(Find.ByText("Community Sentiment")).Exists);
        }

        [Test]
        public void T04_QR_Charts()
        {
            GotoQR();
            browser.Link(Find.ByText("Charts")).Click();
        }

        [Test]
        public void T05_QR_News()
        {
            GotoQR();
            browser.Link(Find.ByText("News")).Click();
        }

        [Test]
        public void T06_QR_NewsMostShared()
        {
            GotoQR();
            browser.Link(Find.ByText("News")).Click();
            browser.WaitForComplete();
            Assert.IsTrue(browser.Div(Find.ByClass("column column_a")).Div(Find.ByClass("webpart")).Div(Find.ByText("Most Shared")).Exists);
        }

        [Test]
        public void T07_QR_Options()
        {
            GotoQR();
            browser.Link(Find.ByText("Options")).Click();
        }

        [Test]
        public void T08_QR_OptionsViewButton()
        {
            GotoQR();
            browser.Link(Find.ByText("Options")).Click();
            browser.WaitForComplete();
            Assert.IsTrue(browser.Div(Find.ById("optionsContent")).Div(Find.ById("optionsTableControls")).Button(Find.ByText("VIEW")).Exists);
        }

        [Test]
        public void T09_QR_Earnings()
        {
            GotoQR();
            browser.Link(Find.ByText("Earnings")).Click();
        }

        [Test]
        public void T10_QR_Fundamentals()
        {
            GotoQR();
            browser.Link(Find.ByText("Fundamentals")).Click();
        }

        [Test]
        public void T11_QR_CommunitySentiment()
        {
            GotoQR();
            browser.Link(Find.ByText("Community Sentiment")).Click();
        }

        [Test]
        public void T12_QR_Insiders()
        {
            GotoQR();
            browser.Link(Find.ByText("Insiders")).Click();
        }

        [Test]
        public void T13_QR_InsidersViewButton()
        {
            GotoQR();
            browser.Link(Find.ByText("Insiders")).Click();
            browser.WaitForComplete();
            Assert.IsTrue(browser.Div(Find.ById("insider_chart_webpart")).Div(Find.ById("insider_chart_header")).Div(Find.ById("right_buttons")).Exists);
        }

        [Test]
        public void T14_QR_Financials()
        {
            GotoQR();
            browser.Link(Find.ByText("Financials")).Click();
        }

        [Test]
        public void T15_QR_FinancialsStatement()
        {
            GotoQR();
            browser.Link(Find.ByText("Financials")).Click();
            browser.WaitForComplete();
            Assert.IsTrue(browser.Div(Find.ByClass("column column_a")).Div(Find.ById("financial_statement_webpart")).Exists);
        }

        private void GotoQR()
        {
            UserSignIn(UN, PW, false, 0);
            browser.WaitForComplete();
            browser.Link(Find.ByText("QUOTES & RESEARCH")).Click();
            browser.WaitForComplete();
        }
    }
}
