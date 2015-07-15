using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading;
using NUnit.Framework;
using WatiN.Core;

namespace Apollo.TestCases
{
    [TestFixture]
    public class Stocks_Module_1 : TestBase
    {
        //Buy 6 @Market
        [Test]
        public void T01_Stocks_Buy6Market()
        {
            this.SignIn(UN1, PWD1, SA1);
            browser.Span(Find.ById(CommonFunction.ACCOUNT_LIST)).WaitUntilExists();
            browser.Div(Find.ById(CommonFunction.TOP_TAB)).Span(Find.ByText("Stocks")).Click();
            browser.Button(Find.ById("EquitTicket_PreviewOrder")).WaitUntilExists();

            CommonFunction.TradeStocks(browser, Transaction.Buy, SYMBOL_STOCKBS, 6, OrderType.Market);

            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, SYMBOL_STOCKBS));
        }

        //Sell 1 @Limit
        [Test]
        public void T02_Stocks_Sell1Limit()
        {
            SignIn(UN1, PWD1, SA1);
            browser.Span(Find.ById(CommonFunction.ACCOUNT_LIST)).WaitUntilExists();
            browser.Div(Find.ById(CommonFunction.TOP_TAB)).Span(Find.ByText("Stocks")).Click();
            browser.Button(Find.ById("EquitTicket_PreviewOrder")).WaitUntilExists();

            CommonFunction.TradeStocks(browser, Transaction.Sell, SYMBOL_STOCKBS, 1, OrderType.Limit);

            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, SYMBOL_STOCKBS));
        }

        //Sell 1 @Stop
        [Test]
        public void T03_Stocks_Sell1Stop()
        {
            SignIn(UN1, PWD1, SA1);
            browser.Span(Find.ById(CommonFunction.ACCOUNT_LIST)).WaitUntilExists();
            browser.Div(Find.ById(CommonFunction.TOP_TAB)).Span(Find.ByText("Stocks")).Click();
            browser.Button(Find.ById("EquitTicket_PreviewOrder")).WaitUntilExists();

            CommonFunction.TradeStocks(browser, Transaction.Sell, SYMBOL_STOCKBS, 1, OrderType.Stop);

            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, SYMBOL_STOCKBS));
        }

        //Sell 1 @Stop Limit
        [Test]
        public void T04_Stocks_Sell1StopLimit()
        {
            SignIn(UN1, PWD1, SA1);
            browser.Span(Find.ById(CommonFunction.ACCOUNT_LIST)).WaitUntilExists();
            browser.Div(Find.ById(CommonFunction.TOP_TAB)).Span(Find.ByText("Stocks")).Click();
            browser.Button(Find.ById("EquitTicket_PreviewOrder")).WaitUntilExists();

            CommonFunction.TradeStocks(browser, Transaction.Sell, SYMBOL_STOCKBS, 1, OrderType.StopLimit);

            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, SYMBOL_STOCKBS));
        }

        //Sell 1 @Trailing Stop $
        [Test]
        public void T05_Stocks_Sell1TrailingStopDollar()
        {
            SignIn(UN1, PWD1, SA1);
            browser.Span(Find.ById(CommonFunction.ACCOUNT_LIST)).WaitUntilExists();
            browser.Div(Find.ById(CommonFunction.TOP_TAB)).Span(Find.ByText("Stocks")).Click();
            browser.Button(Find.ById("EquitTicket_PreviewOrder")).WaitUntilExists();

            CommonFunction.TradeStocks(browser, Transaction.Sell, SYMBOL_STOCKBS, 1, OrderType.TrailingStopDollar);

            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, SYMBOL_STOCKBS));
        }

        //Sell 1 @Trailing Stop %
        [Test]
        public void T06_Stocks_Sell1TrailingStopPercent()
        {
            SignIn(UN1, PWD1, SA1);
            browser.Span(Find.ById(CommonFunction.ACCOUNT_LIST)).WaitUntilExists();
            browser.Div(Find.ById(CommonFunction.TOP_TAB)).Span(Find.ByText("Stocks")).Click();
            browser.Button(Find.ById("EquitTicket_PreviewOrder")).WaitUntilExists();

            CommonFunction.TradeStocks(browser, Transaction.Sell, SYMBOL_STOCKBS, 1, OrderType.TrailingStopPercent);

            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, SYMBOL_STOCKBS));
        }

        [Test]
        public void T07_Stocks_CheckTabs()
        {
            this.SignIn(UN1, PWD1, SA1);
            browser.Span(Find.ById(CommonFunction.ACCOUNT_LIST)).WaitUntilExists();

            browser.Div(Find.ById(CommonFunction.TOP_TAB)).Span(Find.ByText("Stocks")).Click();
            Thread.Sleep(2000);
            browser.Div(Find.ById(CommonFunction.TOP_TAB)).Span(Find.ByText("Options")).Click();
            Thread.Sleep(2000);
            browser.Div(Find.ById(CommonFunction.TOP_TAB)).Span(Find.ByText("Advanced Orders")).Click();
            Thread.Sleep(2000);
            browser.Div(Find.ById(CommonFunction.TOP_TAB)).Span(Find.ByText("Mutual Funds")).Click();
            Thread.Sleep(2000);

            browser.Div(Find.ById(CommonFunction.BOTTOM_TAB)).Span(Find.ByText("Summary")).Click();
            Thread.Sleep(2000);
            if ((browser.Span(Find.ById("TradeBalanceDetail_uxErrorMsg")).Exists == true) &&
                (string.IsNullOrEmpty(browser.Span(Find.ById("TradeBalanceDetail_uxErrorMsg")).Text) == false))
            {
                Console.WriteLine("Error in Summary");
                Assert.IsTrue(false);
                return;
            }
            browser.Div(Find.ById(CommonFunction.BOTTOM_TAB)).Span(Find.ByText("Balances")).Click();
            Thread.Sleep(2000);
            if ((browser.Span(Find.ById("TradeBalanceDetail_uxErrorMsg")).Exists == true) && 
                (string.IsNullOrEmpty(browser.Span(Find.ById("TradeBalanceDetail_uxErrorMsg")).Text) == false))
            {
                Console.WriteLine("Error in Balances");
                Assert.IsTrue(false);
                return;
            }
            browser.Div(Find.ById(CommonFunction.BOTTOM_TAB)).Span(Find.ByText("Positions")).Click();
            Thread.Sleep(2000);
            if ((browser.Span(Find.ById("Position_uxErrorMsg")).Exists == true) &&
                (string.IsNullOrEmpty(browser.Span(Find.ById("Position_uxErrorMsg")).Text) == false))
            {
                Console.WriteLine("Error in Positions");
                Assert.IsTrue(false);
                return;
            }
            browser.Div(Find.ById(CommonFunction.BOTTOM_TAB)).Span(Find.ByText("Order Status")).Click();
            Thread.Sleep(2000);
            if ((browser.Span(Find.ById("Orders_uxErrorMsg")).Exists == true) &&
                (string.IsNullOrEmpty(browser.Span(Find.ById("Orders_uxErrorMsg")).Text) == false))
            {
                Console.WriteLine("Error in Order Status");
                Assert.IsTrue(false);
                return;
            }
            browser.Div(Find.ById(CommonFunction.BOTTOM_TAB)).Span(Find.ByText("Watch Lists")).Click();
            Thread.Sleep(2000);
            if ((browser.Span(Find.ById("History_uxErrorMsg")).Exists == true) &&
                (string.IsNullOrEmpty(browser.Span(Find.ById("History_uxErrorMsg")).Text) == false))
            {
                Console.WriteLine("Error in Watch Lists");
                Assert.IsTrue(false);
                return;
            }
            browser.Div(Find.ById(CommonFunction.BOTTOM_TAB)).Span(Find.ByText("History")).Click();
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
