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
    public class Stocks_Module_2 : TestBase
    {
        //Short 6 @Market
        [Test]
        public void T01_Stocks_Short6Market()
        {
            SignIn(UN1, PWD1, SA1);
            browser.Span(Find.ById(CommonFunction.ACCOUNT_LIST)).WaitUntilExists();
            browser.Div(Find.ById(CommonFunction.TOP_TAB)).Span(Find.ByText("Stocks")).Click();
            browser.Button(Find.ById("EquitTicket_PreviewOrder")).WaitUntilExists();

            CommonFunction.TradeStocks(browser, Transaction.Short, SYMBOL_STOCKSC, 6, OrderType.Market);

            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, SYMBOL_STOCKSC));
        }

        //Cover 1 @Limit
        [Test]
        public void T02_Stocks_Cover1Limit()
        {
            SignIn(UN1, PWD1, SA1);
            browser.Span(Find.ById(CommonFunction.ACCOUNT_LIST)).WaitUntilExists();
            browser.Div(Find.ById(CommonFunction.TOP_TAB)).Span(Find.ByText("Stocks")).Click();
            browser.Button(Find.ById("EquitTicket_PreviewOrder")).WaitUntilExists();

            CommonFunction.TradeStocks(browser, Transaction.Cover, SYMBOL_STOCKSC, 1, OrderType.Limit);

            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, SYMBOL_STOCKSC));
        }

        //Cover 1 @Stop
        [Test]
        public void T03_Stocks_Cover1Stop()
        {
            SignIn(UN1, PWD1, SA1);
            browser.Span(Find.ById(CommonFunction.ACCOUNT_LIST)).WaitUntilExists();
            browser.Div(Find.ById(CommonFunction.TOP_TAB)).Span(Find.ByText("Stocks")).Click();
            browser.Button(Find.ById("EquitTicket_PreviewOrder")).WaitUntilExists();

            CommonFunction.TradeStocks(browser, Transaction.Cover, SYMBOL_STOCKSC, 1, OrderType.Stop);

            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, SYMBOL_STOCKSC));
        }

        //Cover 1 @Stop Limit
        [Test]
        public void T04_Stocks_Cover1StopLimit()
        {
            SignIn(UN1, PWD1, SA1);
            browser.Span(Find.ById(CommonFunction.ACCOUNT_LIST)).WaitUntilExists();
            browser.Div(Find.ById(CommonFunction.TOP_TAB)).Span(Find.ByText("Stocks")).Click();
            browser.Button(Find.ById("EquitTicket_PreviewOrder")).WaitUntilExists();

            CommonFunction.TradeStocks(browser, Transaction.Cover, SYMBOL_STOCKSC, 1, OrderType.StopLimit);

            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, SYMBOL_STOCKSC));
        }

        //Cover 1 @Trailing Stop $
        [Test]
        public void T05_Stocks_Cover1TrailingStopDollar()
        {
            SignIn(UN1, PWD1, SA1);
            browser.Span(Find.ById(CommonFunction.ACCOUNT_LIST)).WaitUntilExists();
            browser.Div(Find.ById(CommonFunction.TOP_TAB)).Span(Find.ByText("Stocks")).Click();
            browser.Button(Find.ById("EquitTicket_PreviewOrder")).WaitUntilExists();

            CommonFunction.TradeStocks(browser, Transaction.Cover, SYMBOL_STOCKSC, 1, OrderType.TrailingStopDollar);

            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, SYMBOL_STOCKSC));
        }

        //Cover 1 @Trailing Stop %
        [Test]
        public void T06_Stocks_Cover1TrailingStopPercent()
        {
            SignIn(UN1, PWD1, SA1);
            browser.Span(Find.ById(CommonFunction.ACCOUNT_LIST)).WaitUntilExists();
            browser.Div(Find.ById(CommonFunction.TOP_TAB)).Span(Find.ByText("Stocks")).Click();
            browser.Button(Find.ById("EquitTicket_PreviewOrder")).WaitUntilExists();

            CommonFunction.TradeStocks(browser, Transaction.Cover, SYMBOL_STOCKSC, 1, OrderType.TrailingStopPercent);

            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, SYMBOL_STOCKSC));
        }
    }
}
