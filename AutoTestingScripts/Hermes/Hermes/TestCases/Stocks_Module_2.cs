using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading;
using NUnit.Framework;
using WatiN.Core;

namespace Hermes.TestCases
{
    [TestFixture]
    public class Stocks_Module_2 : CommonFunction
    {
        //Short 6 @Market
        [Test]
        public void T01_Stocks_Short6Market()
        {
            SignIn(UN1, PWD1, SA1);
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxAccountShow")).WaitUntilExists();

            this.TradeStocks(Transaction.Short, symbol_2, 6, OrderType.Market);

            browser.Div(Find.ById("Trading_SummaryView_PositionsPanel")).Element(Find.ById("uxRefreshBtn")).Click();
            Thread.Sleep(20000);
            for (int i = 0; i < browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows.Count; i++)
            {
                if ((browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].TableCells.Count > 1) &&
                    (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].Span(Find.ByClass("float-left")).Exists == true) &&
                    (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].Span(Find.ByClass("float-left")).Text == symbol_1.ToUpper()))
                {
                    Assert.IsTrue(true);
                    return;
                }
            }

            Assert.IsTrue(false);
        }

        //Cover 1 @Limit
        [Test]
        public void T02_Stocks_Cover1Limit()
        {
            SignIn(UN1, PWD1, SA1);
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxAccountShow")).WaitUntilExists();

            this.TradeStocks(Transaction.Cover, symbol_2, 1, OrderType.Limit);

            browser.Div(Find.ById("Trading_SummaryView_PositionsPanel")).Element(Find.ById("uxRefreshBtn")).Click();
            Thread.Sleep(20000);
            for (int i = 0; i < browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows.Count; i++)
            {
                if ((browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].TableCells.Count > 1) &&
                    (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].Span(Find.ByClass("float-left")).Exists == true) &&
                    (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].Span(Find.ByClass("float-left")).Text == symbol_1.ToUpper()))
                {
                    Assert.IsTrue(true);
                    return;
                }
            }

            Assert.IsTrue(false);
        }

        //Cover 1 @Stop
        [Test]
        public void T03_Stocks_Cover1Stop()
        {
            SignIn(UN1, PWD1, SA1);
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxAccountShow")).WaitUntilExists();

            this.TradeStocks(Transaction.Cover, symbol_2, 1, OrderType.Stop);

            browser.Div(Find.ById("Trading_SummaryView_PositionsPanel")).Element(Find.ById("uxRefreshBtn")).Click();
            Thread.Sleep(20000);
            for (int i = 0; i < browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows.Count; i++)
            {
                if ((browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].TableCells.Count > 1) &&
                    (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].Span(Find.ByClass("float-left")).Exists == true) &&
                    (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].Span(Find.ByClass("float-left")).Text == symbol_1.ToUpper()))
                {
                    Assert.IsTrue(true);
                    return;
                }
            }

            Assert.IsTrue(false);
        }

        //Cover 1 @Stop Limit
        [Test]
        public void T04_Stocks_Cover1StopLimit()
        {
            SignIn(UN1, PWD1, SA1);
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxAccountShow")).WaitUntilExists();

            this.TradeStocks(Transaction.Cover, symbol_2, 1, OrderType.StopLimit);

            browser.Div(Find.ById("Trading_SummaryView_PositionsPanel")).Element(Find.ById("uxRefreshBtn")).Click();
            Thread.Sleep(20000);
            for (int i = 0; i < browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows.Count; i++)
            {
                if ((browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].TableCells.Count > 1) &&
                    (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].Span(Find.ByClass("float-left")).Exists == true) &&
                    (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].Span(Find.ByClass("float-left")).Text == symbol_1.ToUpper()))
                {
                    Assert.IsTrue(true);
                    return;
                }
            }

            Assert.IsTrue(false);
        }

        //Cover 1 @Trailing Stop $
        [Test]
        public void T05_Stocks_Cover1TrailingStopDollar()
        {
            SignIn(UN1, PWD1, SA1);
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxAccountShow")).WaitUntilExists();

            this.TradeStocks(Transaction.Cover, symbol_2, 1, OrderType.TrailingStopDollar);

            browser.Div(Find.ById("Trading_SummaryView_PositionsPanel")).Element(Find.ById("uxRefreshBtn")).Click();
            Thread.Sleep(20000);
            for (int i = 0; i < browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows.Count; i++)
            {
                if ((browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].TableCells.Count > 1) &&
                    (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].Span(Find.ByClass("float-left")).Exists == true) &&
                    (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].Span(Find.ByClass("float-left")).Text == symbol_1.ToUpper()))
                {
                    Assert.IsTrue(true);
                    return;
                }
            }

            Assert.IsTrue(false);
        }

        //Cover 1 @Trailing Stop %
        [Test]
        public void T06_Stocks_Cover1TrailingStopPercent()
        {
            SignIn(UN1, PWD1, SA1);
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxAccountShow")).WaitUntilExists();

            this.TradeStocks(Transaction.Cover, symbol_2, 1, OrderType.TrailingStopPercent);

            browser.Div(Find.ById("Trading_SummaryView_PositionsPanel")).Element(Find.ById("uxRefreshBtn")).Click();
            Thread.Sleep(20000);
            for (int i = 0; i < browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows.Count; i++)
            {
                if ((browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].TableCells.Count > 1) &&
                    (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].Span(Find.ByClass("float-left")).Exists == true) &&
                    (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].Span(Find.ByClass("float-left")).Text == symbol_1.ToUpper()))
                {
                    Assert.IsTrue(true);
                    return;
                }
            }

            Assert.IsTrue(false);
        }
    }
}
