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
    public class Stocks_Module_1 : CommonFunction
    {
        //Buy 6 @Market
        [Test]
        public void T01_Stocks_Buy6Market()
        {
            SignIn(UN1, PWD1, SA1);
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxAccountShow")).WaitUntilExists();
            browser.Button(Find.ById("EquitTicket_PreviewOrder")).WaitUntilExists();

            this.TradeStocks(Transaction.Buy, symbol_1, 6, OrderType.Market);

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

        //Sell 1 @Limit
        [Test]
        public void T02_Stocks_Sell1Limit()
        {
            SignIn(UN1, PWD1, SA1);
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxAccountShow")).WaitUntilExists();

            this.TradeStocks(Transaction.Sell, symbol_1, 1, OrderType.Limit);

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

        //Sell 1 @Stop
        [Test]
        public void T03_Stocks_Sell1Stop()
        {
            SignIn(UN1, PWD1, SA1);
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxAccountShow")).WaitUntilExists();

            this.TradeStocks(Transaction.Sell, symbol_1, 1, OrderType.Stop);

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

        //Sell 1 @Stop Limit
        [Test]
        public void T04_Stocks_Sell1StopLimit()
        {
            SignIn(UN1, PWD1, SA1);
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxAccountShow")).WaitUntilExists();

            this.TradeStocks(Transaction.Sell, symbol_1, 1, OrderType.StopLimit);

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

        //Sell 1 @Trailing Stop $
        [Test]
        public void T05_Stocks_Sell1TrailingStopDollar()
        {
            SignIn(UN1, PWD1, SA1);
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxAccountShow")).WaitUntilExists();

            this.TradeStocks(Transaction.Sell, symbol_1, 1, OrderType.TrailingStopDollar);

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

        //Sell 1 @Trailing Stop %
        [Test]
        public void T06_Stocks_Sell1TrailingStopPercent()
        {
            SignIn(UN1, PWD1, SA1);
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxAccountShow")).WaitUntilExists();

            this.TradeStocks(Transaction.Sell, symbol_1, 1, OrderType.TrailingStopPercent);

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

        //[Test]
        //public void T01_Stocks_Buy()
        //{
        //    SignIn(UN1, PWD1, SA1);
        //    browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxAccount")).WaitUntilExists();

        //    int timeout = 0;

        //    browser.Span(Find.ById("TradeBalance_NetCash")).WaitUntilExists();
        //    string strNetCash = browser.Span(Find.ById("TradeBalance_NetCash")).Text;
        //    while ((string.IsNullOrEmpty(strNetCash) == true) && (timeout < 30))
        //    {
        //        Thread.Sleep(2000);
        //        timeout += 2;
        //        strNetCash = browser.Span(Find.ById("TradeBalance_NetCash")).Text;
        //    }
        //    float netCash = 0f;
        //    if (this.GetMoney(strNetCash, ref netCash) == false)
        //    {
        //        Console.WriteLine("Invalid net cash : " + strNetCash);
        //        Assert.IsTrue(false);
        //        return;
        //    }
        //    this.TradeStocks(Transaction.Buy, symbol_1, 5, OrderType.Market);

        //    browser.Span(Find.ById("OrderDetail_EstmCost")).WaitUntilExists();
        //    timeout = 0;
        //    string strEstCost = browser.Span(Find.ById("OrderDetail_EstmCost")).Text;
        //    while ((string.IsNullOrEmpty(strEstCost) == true) && (timeout < 30))
        //    {
        //        Thread.Sleep(2000);
        //        timeout += 2;
        //        strEstCost = browser.Span(Find.ById("OrderDetail_EstmCost")).Text;
        //    }
        //    float estCost = 0f;
        //    if (this.GetMoney(strEstCost, ref estCost) == false)
        //    {
        //        Console.WriteLine("Invalid estimated cost : " + strEstCost);
        //        Assert.IsTrue(false);
        //        return;
        //    }
        //    browser.Div(Find.ById("OrderPopup_Preview")).Button(Find.ById("OrderPreview_BtnSumbitOrder")).Click();
        //    Thread.Sleep(2000);
        //    browser.Div(Find.ById("OrderPopup_Confirmation")).Button(Find.ById("OrderConfirmation_BtnOrderStatus")).Click();

        //    Thread.Sleep(60000);
        //    browser.Div(Find.ById("tradebalance_fullpanel")).Element(Find.ById("TradeBalance_RefreshBtn")).Click();
        //    Thread.Sleep(5000);
        //    timeout = 0;
        //    browser.Span(Find.ById("TradeBalance_NetCash")).WaitUntilExists();
        //    strNetCash = browser.Span(Find.ById("TradeBalance_NetCash")).Text;
        //    while ((string.IsNullOrEmpty(strNetCash) == true) && (timeout < 30))
        //    {
        //        Thread.Sleep(2000);
        //        timeout += 2;
        //        strNetCash = browser.Span(Find.ById("TradeBalance_NetCash")).Text;
        //    }
        //    float netCash_1 = 0f;
        //    if (this.GetMoney(strNetCash, ref netCash_1) == false)
        //    {
        //        Console.WriteLine("Invalid net cash : " + strNetCash);
        //        Assert.IsTrue(false);
        //        return;
        //    }
        //    else if (netCash - estCost != netCash_1)
        //    {
        //        Console.WriteLine(string.Format("Incorrect cost calculation : {0} - {1} <> {2}", netCash, estCost, netCash_1));
        //        //Bug 12675
        //        //Assert.IsTrue(false);
        //        //return;
        //    }

        //    browser.Div(Find.ById("Trading_SummaryView_PositionsPanel")).Element(Find.ById("uxRefreshBtn")).Click();
        //    Thread.Sleep(20000);
        //    for (int i = 0; i < browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows.Count; i++)
        //    {
        //        if ((browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].TableCells.Count > 1) &&
        //            (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].Span(Find.ByClass("float-left")).Exists == true) &&
        //            (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].Span(Find.ByClass("float-left")).Text == symbol_1.ToUpper()))
        //        {
        //            Assert.IsTrue(true);
        //            return;
        //        }
        //    }

        //    Assert.IsTrue(false);
        //}

        [Test]
        public void T07_Stocks_CheckTabs()
        {
            SignIn(UN1, PWD1, SA1);
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxAccount")).WaitUntilExists();

            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxRadTabTopNav")).Span(Find.ByText("Options")).Click();
            Thread.Sleep(2000);
            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxRadTabTopNav")).Span(Find.ByText("Advanced Orders")).Click();
            Thread.Sleep(2000);
            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxRadTabTopNav")).Span(Find.ByText("Mutual Funds")).Click();
            Thread.Sleep(2000);

            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxRadTabPages")).Span(Find.ByText("Balances")).Click();
            Thread.Sleep(2000);
            if ((browser.Span(Find.ById("TradeBalanceDetail_uxErrorMsg")).Exists == true) && 
                (string.IsNullOrEmpty(browser.Span(Find.ById("TradeBalanceDetail_uxErrorMsg")).Text) == false))
            {
                Console.WriteLine("Error in Balances");
                Assert.IsTrue(false);
                return;
            }
            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxRadTabPages")).Span(Find.ByText("Positions")).Click();
            Thread.Sleep(2000);
            if ((browser.Span(Find.ById("Position_uxErrorMsg")).Exists == true) &&
                (string.IsNullOrEmpty(browser.Span(Find.ById("Position_uxErrorMsg")).Text) == false))
            {
                Console.WriteLine("Error in Positions");
                Assert.IsTrue(false);
                return;
            }
            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxRadTabPages")).Span(Find.ByText("Today's Orders")).Click();
            Thread.Sleep(2000);
            if ((browser.Span(Find.ById("Orders_uxErrorMsg")).Exists == true) &&
                (string.IsNullOrEmpty(browser.Span(Find.ById("Orders_uxErrorMsg")).Text) == false))
            {
                Console.WriteLine("Error in Today's Orders");
                Assert.IsTrue(false);
                return;
            }
            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxRadTabPages")).Span(Find.ByText("History")).Click();
            Thread.Sleep(2000);
            if ((browser.Span(Find.ById("History_uxErrorMsg")).Exists == true) &&
                (string.IsNullOrEmpty(browser.Span(Find.ById("History_uxErrorMsg")).Text) == false))
            {
                Console.WriteLine("Error in History");
                Assert.IsTrue(false);
                return;
            }
        }

        private bool GetMoney(string strMoney, ref float fMoney)
        {
            strMoney = strMoney.Replace("(", "").Replace(")", "").Replace("$", "").Replace(",", "");

            return float.TryParse(strMoney, out fMoney);
        }
    }
}
