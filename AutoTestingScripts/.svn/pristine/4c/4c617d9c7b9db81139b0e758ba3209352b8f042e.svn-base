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
    public class AdvancedOrder_Module_1 : TestBase
    {
        [Test]
        public void T01_Advanced_OCO_2Stock()
        {
            this.SignIn(UN1, PWD1, SA1);
            browser.Span(Find.ById(CommonFunction.ACCOUNT_LIST)).WaitUntilExists();
            browser.Div(Find.ById(CommonFunction.TOP_TAB)).Span(Find.ByText("Advanced Orders")).Click();
            browser.SelectList(Find.ById("AdvancedTicket_OrderType")).WaitUntilExists();
            browser.SelectList(Find.ById("AdvancedTicket_OrderType")).Option(Find.ByText("One Cancels Others")).Select();

            CommonFunction.TradeAdvanced(browser, 1121, symbol_21, symbol_22);

            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, symbol_21));
            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, symbol_22));
        }

        [Test]
        public void T02_Advanced_OCO_StockOption()
        {
            this.SignIn(UN1, PWD1, SA1);
            browser.Span(Find.ById(CommonFunction.ACCOUNT_LIST)).WaitUntilExists();
            browser.Div(Find.ById(CommonFunction.TOP_TAB)).Span(Find.ByText("Advanced Orders")).Click();
            browser.SelectList(Find.ById("AdvancedTicket_OrderType")).WaitUntilExists();
            browser.SelectList(Find.ById("AdvancedTicket_OrderType")).Option(Find.ByText("One Cancels Others")).Select();

            CommonFunction.TradeAdvanced(browser, 1122, symbol_21, symbol_24);

            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, symbol_21));
            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, symbol_24));
        }

        [Test]
        public void T03_Advanced_OCO_2Option()
        {
            this.SignIn(UN1, PWD1, SA1);
            browser.Span(Find.ById(CommonFunction.ACCOUNT_LIST)).WaitUntilExists();
            browser.Div(Find.ById(CommonFunction.TOP_TAB)).Span(Find.ByText("Advanced Orders")).Click();
            browser.SelectList(Find.ById("AdvancedTicket_OrderType")).WaitUntilExists();
            browser.SelectList(Find.ById("AdvancedTicket_OrderType")).Option(Find.ByText("One Cancels Others")).Select();

            CommonFunction.TradeAdvanced(browser, 1222, symbol_23, symbol_24);

            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, symbol_23));
            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, symbol_24));
        }

        [Test]
        public void T04_Advanced_OTO_StockStock()
        {
            this.SignIn(UN1, PWD1, SA1);
            browser.Span(Find.ById(CommonFunction.ACCOUNT_LIST)).WaitUntilExists();
            browser.Div(Find.ById(CommonFunction.TOP_TAB)).Span(Find.ByText("Advanced Orders")).Click();
            browser.SelectList(Find.ById("AdvancedTicket_OrderType")).WaitUntilExists();
            browser.SelectList(Find.ById("AdvancedTicket_OrderType")).Option(Find.ByText("One Triggers Others")).Select();

            CommonFunction.TradeAdvanced(browser, 1121, symbol_21, symbol_22);

            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, symbol_21));
            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, symbol_22));
        }

        [Test]
        public void T05_Advanced_OTO_StockOption()
        {
            this.SignIn(UN1, PWD1, SA1);
            browser.Span(Find.ById(CommonFunction.ACCOUNT_LIST)).WaitUntilExists();
            browser.Div(Find.ById(CommonFunction.TOP_TAB)).Span(Find.ByText("Advanced Orders")).Click();
            browser.SelectList(Find.ById("AdvancedTicket_OrderType")).WaitUntilExists();
            browser.SelectList(Find.ById("AdvancedTicket_OrderType")).Option(Find.ByText("One Triggers Others")).Select();

            CommonFunction.TradeAdvanced(browser, 1122, symbol_21, symbol_24);

            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, symbol_21));
            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, symbol_24));
        }

        [Test]
        public void T06_Advanced_OTO_OptionStock()
        {
            this.SignIn(UN1, PWD1, SA1);
            browser.Span(Find.ById(CommonFunction.ACCOUNT_LIST)).WaitUntilExists();
            browser.Div(Find.ById(CommonFunction.TOP_TAB)).Span(Find.ByText("Advanced Orders")).Click();
            browser.SelectList(Find.ById("AdvancedTicket_OrderType")).WaitUntilExists();
            browser.SelectList(Find.ById("AdvancedTicket_OrderType")).Option(Find.ByText("One Triggers Others")).Select();

            CommonFunction.TradeAdvanced(browser, 1221, symbol_23, symbol_22);

            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, symbol_23));
            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, symbol_22));
        }

        [Test]
        public void T07_Advanced_OTO_OptionOption()
        {
            this.SignIn(UN1, PWD1, SA1);
            browser.Span(Find.ById(CommonFunction.ACCOUNT_LIST)).WaitUntilExists();
            browser.Div(Find.ById(CommonFunction.TOP_TAB)).Span(Find.ByText("Advanced Orders")).Click();
            browser.SelectList(Find.ById("AdvancedTicket_OrderType")).WaitUntilExists();
            browser.SelectList(Find.ById("AdvancedTicket_OrderType")).Option(Find.ByText("One Triggers Others")).Select();

            CommonFunction.TradeAdvanced(browser, 1222, symbol_23, symbol_24);

            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, symbol_23));
            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, symbol_24));
        }
    }
}
