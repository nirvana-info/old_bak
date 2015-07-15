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
    public class Options_Module_3 : TestBase
    {
        //Sell 1 Butterfly @Limit
        [Test]
        public void T01_Options_Sell1ButterflyLimit()
        {
            SignIn(UN1, PWD1, SA1);
            browser.Span(Find.ById(CommonFunction.ACCOUNT_LIST)).WaitUntilExists();
            browser.Div(Find.ById(CommonFunction.TOP_TAB)).Span(Find.ByText("Options")).Click();
            browser.Button(Find.ById("OptionTicket_SubmitOrder")).WaitUntilExists();

            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).WaitUntilExists();
            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).TypeText(SYMBOL_BUTTERFLY);
            Thread.Sleep(2000);
            browser.Div(Find.ById("OptionTicket_StrategyImgSmall")).Click();
            //Butterfly
            string controlID = CommonFunction.GetStrategyControl(OptionStrategy.Butterfly);
            browser.Div(Find.ById(CommonFunction.STRATEGY_POP)).Link(Find.ById(controlID)).Click();
            CommonFunction.TradeOptions(browser, "OptionChainPanel_CheckBox_2", 2, 1, OrderType.Limit);

            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, SYMBOL_BUTTERFLY));
        }

        //Sell 1 Calendar @Limit
        [Test]
        public void T02_Options_Sell1CalendarLimit()
        {
            SignIn(UN1, PWD1, SA1);
            browser.Span(Find.ById(CommonFunction.ACCOUNT_LIST)).WaitUntilExists();
            browser.Div(Find.ById(CommonFunction.TOP_TAB)).Span(Find.ByText("Options")).Click();
            browser.Button(Find.ById("OptionTicket_SubmitOrder")).WaitUntilExists();

            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).WaitUntilExists();
            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).TypeText(SYMBOL_CALENDAR);
            Thread.Sleep(2000);
            browser.Div(Find.ById("OptionTicket_StrategyImgSmall")).Click();
            //Calendar
            string controlID = CommonFunction.GetStrategyControl(OptionStrategy.Calendar);
            browser.Div(Find.ById(CommonFunction.STRATEGY_POP)).Link(Find.ById(controlID)).Click();
            CommonFunction.TradeOptions(browser, "OptionChainPanel_CheckBox_2", 2, 1, OrderType.Limit);

            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, SYMBOL_CALENDAR));
        }

        //Sell 1 Collar @Limit
        [Test]
        public void T03_Options_Sell1CollarLimit()
        {
            SignIn(UN1, PWD1, SA1);
            browser.Span(Find.ById(CommonFunction.ACCOUNT_LIST)).WaitUntilExists();
            browser.Div(Find.ById(CommonFunction.TOP_TAB)).Span(Find.ByText("Options")).Click();
            browser.Button(Find.ById("OptionTicket_SubmitOrder")).WaitUntilExists();

            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).WaitUntilExists();
            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).TypeText(SYMBOL_COLLAR);
            Thread.Sleep(2000);
            browser.Div(Find.ById("OptionTicket_StrategyImgSmall")).Click();
            //Collar
            string controlID = CommonFunction.GetStrategyControl(OptionStrategy.Collar);
            browser.Div(Find.ById(CommonFunction.STRATEGY_POP)).Link(Find.ById(controlID)).Click();
            CommonFunction.TradeOptions(browser, "OptionChainPanel_CheckBox_2", 2, 1, OrderType.Limit);

            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, SYMBOL_COLLAR));
        }

        //Sell 1 Condor @Limit
        [Test]
        public void T04_Options_Sell1CondorLimit()
        {
            SignIn(UN1, PWD1, SA1);
            browser.Span(Find.ById(CommonFunction.ACCOUNT_LIST)).WaitUntilExists();
            browser.Div(Find.ById(CommonFunction.TOP_TAB)).Span(Find.ByText("Options")).Click();
            browser.Button(Find.ById("OptionTicket_SubmitOrder")).WaitUntilExists();

            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).WaitUntilExists();
            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).TypeText(SYMBOL_CONDOR);
            Thread.Sleep(2000);
            browser.Div(Find.ById("OptionTicket_StrategyImgSmall")).Click();
            //Condor
            string controlID = CommonFunction.GetStrategyControl(OptionStrategy.Condor);
            browser.Div(Find.ById(CommonFunction.STRATEGY_POP)).Link(Find.ById(controlID)).Click();
            CommonFunction.TradeOptions(browser, "OptionChainPanel_CheckBox_2", 2, 1, OrderType.Limit);

            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, SYMBOL_CONDOR));
        }

        //Sell 1 Covered @Limit
        [Test]
        public void T05_Options_Sell1CoveredLimit()
        {
            SignIn(UN1, PWD1, SA1);
            browser.Span(Find.ById(CommonFunction.ACCOUNT_LIST)).WaitUntilExists();
            browser.Div(Find.ById(CommonFunction.TOP_TAB)).Span(Find.ByText("Options")).Click();
            browser.Button(Find.ById("OptionTicket_SubmitOrder")).WaitUntilExists();

            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).WaitUntilExists();
            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).TypeText(SYMBOL_COVERED);
            Thread.Sleep(2000);
            browser.Div(Find.ById("OptionTicket_StrategyImgSmall")).Click();
            //Covered
            string controlID = CommonFunction.GetStrategyControl(OptionStrategy.Covered);
            browser.Div(Find.ById(CommonFunction.STRATEGY_POP)).Link(Find.ById(controlID)).Click();
            CommonFunction.TradeOptions(browser, "OptionChainPanel_CheckBox_2", 2, 1, OrderType.Limit);

            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, SYMBOL_COVERED));
        }

        //Sell 1 Diagonal @Limit
        [Test]
        public void T06_Options_Sell1DiagonalLimit()
        {
            SignIn(UN1, PWD1, SA1);
            browser.Span(Find.ById(CommonFunction.ACCOUNT_LIST)).WaitUntilExists();
            browser.Div(Find.ById(CommonFunction.TOP_TAB)).Span(Find.ByText("Options")).Click();
            browser.Button(Find.ById("OptionTicket_SubmitOrder")).WaitUntilExists();

            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).WaitUntilExists();
            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).TypeText(SYMBOL_DIAGONAL);
            Thread.Sleep(2000);
            browser.Div(Find.ById("OptionTicket_StrategyImgSmall")).Click();
            //Covered
            string controlID = CommonFunction.GetStrategyControl(OptionStrategy.Diagonal);
            browser.Div(Find.ById(CommonFunction.STRATEGY_POP)).Link(Find.ById(controlID)).Click();
            CommonFunction.TradeOptions(browser, "OptionChainPanel_CheckBox_2", 2, 1, OrderType.Limit);

            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, SYMBOL_DIAGONAL));
        }

        //Sell 1 IronButterfly @Limit
        [Test]
        public void T07_Options_Sell1IronButterflyLimit()
        {
            SignIn(UN1, PWD1, SA1);
            browser.Span(Find.ById(CommonFunction.ACCOUNT_LIST)).WaitUntilExists();
            browser.Div(Find.ById(CommonFunction.TOP_TAB)).Span(Find.ByText("Options")).Click();
            browser.Button(Find.ById("OptionTicket_SubmitOrder")).WaitUntilExists();

            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).WaitUntilExists();
            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).TypeText(SYMBOL_IRONBF);
            Thread.Sleep(2000);
            browser.Div(Find.ById("OptionTicket_StrategyImgSmall")).Click();
            //IronButterfly
            string controlID = CommonFunction.GetStrategyControl(OptionStrategy.IronButterfly);
            browser.Div(Find.ById(CommonFunction.STRATEGY_POP)).Link(Find.ById(controlID)).Click();
            CommonFunction.TradeOptions(browser, "OptionChainPanel_CheckBox_2", 2, 1, OrderType.Limit);

            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, SYMBOL_IRONBF));
        }

        //Sell 1 IronCondor @Limit
        [Test]
        public void T08_Options_Sell1IronCondorLimit()
        {
            SignIn(UN1, PWD1, SA1);
            browser.Span(Find.ById(CommonFunction.ACCOUNT_LIST)).WaitUntilExists();
            browser.Div(Find.ById(CommonFunction.TOP_TAB)).Span(Find.ByText("Options")).Click();
            browser.Button(Find.ById("OptionTicket_SubmitOrder")).WaitUntilExists();

            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).WaitUntilExists();
            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).TypeText(SYMBOL_IRONCD);
            Thread.Sleep(2000);
            browser.Div(Find.ById("OptionTicket_StrategyImgSmall")).Click();
            //IronCondor
            string controlID = CommonFunction.GetStrategyControl(OptionStrategy.IronCondor);
            browser.Div(Find.ById(CommonFunction.STRATEGY_POP)).Link(Find.ById(controlID)).Click();
            CommonFunction.TradeOptions(browser, "OptionChainPanel_CheckBox_2", 2, 1, OrderType.Limit);

            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, SYMBOL_IRONCD));
        }

        //Sell 1 Ratio @Limit
        [Test]
        public void T09_Options_Sell1RatioLimit()
        {
            SignIn(UN1, PWD1, SA1);
            browser.Span(Find.ById(CommonFunction.ACCOUNT_LIST)).WaitUntilExists();
            browser.Div(Find.ById(CommonFunction.TOP_TAB)).Span(Find.ByText("Options")).Click();
            browser.Button(Find.ById("OptionTicket_SubmitOrder")).WaitUntilExists();

            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).WaitUntilExists();
            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).TypeText(SYMBOL_RATIO);
            Thread.Sleep(2000);
            browser.Div(Find.ById("OptionTicket_StrategyImgSmall")).Click();
            //Ratio
            string controlID = CommonFunction.GetStrategyControl(OptionStrategy.Ratio);
            browser.Div(Find.ById(CommonFunction.STRATEGY_POP)).Link(Find.ById(controlID)).Click();
            CommonFunction.TradeOptions(browser, "OptionChainPanel_CheckBox_2", 2, 1, OrderType.Limit);

            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, SYMBOL_RATIO));
        }

        //Sell 1 Spread @Limit
        [Test]
        public void T10_Options_Sell1SpreadLimit()
        {
            SignIn(UN1, PWD1, SA1);
            browser.Span(Find.ById(CommonFunction.ACCOUNT_LIST)).WaitUntilExists();
            browser.Div(Find.ById(CommonFunction.TOP_TAB)).Span(Find.ByText("Options")).Click();
            browser.Button(Find.ById("OptionTicket_SubmitOrder")).WaitUntilExists();

            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).WaitUntilExists();
            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).TypeText(SYMBOL_SPREAD);
            Thread.Sleep(2000);
            browser.Div(Find.ById("OptionTicket_StrategyImgSmall")).Click();
            //Spread
            string controlID = CommonFunction.GetStrategyControl(OptionStrategy.Spread);
            browser.Div(Find.ById(CommonFunction.STRATEGY_POP)).Link(Find.ById(controlID)).Click();
            CommonFunction.TradeOptions(browser, "OptionChainPanel_CheckBox_2", 2, 1, OrderType.Limit);

            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, SYMBOL_SPREAD));
        }

        //Sell 1 Straddle @Limit
        [Test]
        public void T11_Options_Sell1StraddleLimit()
        {
            SignIn(UN1, PWD1, SA1);
            browser.Span(Find.ById(CommonFunction.ACCOUNT_LIST)).WaitUntilExists();
            browser.Div(Find.ById(CommonFunction.TOP_TAB)).Span(Find.ByText("Options")).Click();
            browser.Button(Find.ById("OptionTicket_SubmitOrder")).WaitUntilExists();

            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).WaitUntilExists();
            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).TypeText(SYMBOL_STRADDLE);
            Thread.Sleep(2000);
            browser.Div(Find.ById("OptionTicket_StrategyImgSmall")).Click();
            //Straddle
            string controlID = CommonFunction.GetStrategyControl(OptionStrategy.Straddle);
            browser.Div(Find.ById(CommonFunction.STRATEGY_POP)).Link(Find.ById(controlID)).Click();
            CommonFunction.TradeOptions(browser, "OptionChainPanel_CheckBox_2", 2, 1, OrderType.Limit);

            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, SYMBOL_STRADDLE));
        }

        //Sell 1 Strangle @Limit
        [Test]
        public void T12_Options_Sell1StrangleLimit()
        {
            SignIn(UN1, PWD1, SA1);
            browser.Span(Find.ById(CommonFunction.ACCOUNT_LIST)).WaitUntilExists();
            browser.Div(Find.ById(CommonFunction.TOP_TAB)).Span(Find.ByText("Options")).Click();
            browser.Button(Find.ById("OptionTicket_SubmitOrder")).WaitUntilExists();

            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).WaitUntilExists();
            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).TypeText(SYMBOL_STRANGLE);
            Thread.Sleep(2000);
            browser.Div(Find.ById("OptionTicket_StrategyImgSmall")).Click();
            //Strangle
            string controlID = CommonFunction.GetStrategyControl(OptionStrategy.Strangle);
            browser.Div(Find.ById(CommonFunction.STRATEGY_POP)).Link(Find.ById(controlID)).Click();
            CommonFunction.TradeOptions(browser, "OptionChainPanel_CheckBox_2", 2, 1, OrderType.Limit);

            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, SYMBOL_STRANGLE));
        }
    }
}
