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
    public class Options_Module_2 : TestBase
    {
        //Buy 2 Butterfly @Market
        [Test]
        public void T01_Options_Buy1ButterflyMarket()
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
            CommonFunction.TradeOptions(browser, "OptionChainPanel_CheckBox_2", 1, 2, OrderType.Market);

            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, SYMBOL_BUTTERFLY));
        }

        //Buy 2 Calendar @Market
        [Test]
        public void T02_Options_Buy2CalendarMarket()
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
            CommonFunction.TradeOptions(browser, "OptionChainPanel_CheckBox_2", 1, 2, OrderType.Market);

            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, SYMBOL_CALENDAR));
        }

        //Buy 2 Collar @Market
        [Test]
        public void T03_Options_Buy2CollarMarket()
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
            CommonFunction.TradeOptions(browser, "OptionChainPanel_CheckBox_2", 1, 2, OrderType.Market);

            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, SYMBOL_COLLAR));
        }

        //Buy 2 Condor @Market
        [Test]
        public void T04_Options_Buy2CondorMarket()
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
            CommonFunction.TradeOptions(browser, "OptionChainPanel_CheckBox_2", 1, 2, OrderType.Market);

            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, SYMBOL_CONDOR));
        }

        //Buy 2 Covered @Market
        [Test]
        public void T05_Options_Buy2CoveredMarket()
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
            CommonFunction.TradeOptions(browser, "OptionChainPanel_CheckBox_2", 1, 2, OrderType.Market);

            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, SYMBOL_COVERED));
        }

        //Buy 2 Diagonal @Market
        [Test]
        public void T06_Options_Buy2DiagonalMarket()
        {
            SignIn(UN1, PWD1, SA1);
            browser.Span(Find.ById(CommonFunction.ACCOUNT_LIST)).WaitUntilExists();
            browser.Div(Find.ById(CommonFunction.TOP_TAB)).Span(Find.ByText("Options")).Click();
            browser.Button(Find.ById("OptionTicket_SubmitOrder")).WaitUntilExists();

            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).WaitUntilExists();
            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).TypeText(SYMBOL_DIAGONAL);
            Thread.Sleep(2000);
            browser.Div(Find.ById("OptionTicket_StrategyImgSmall")).Click();
            //IronButterfly
            string controlID = CommonFunction.GetStrategyControl(OptionStrategy.Diagonal);
            browser.Div(Find.ById(CommonFunction.STRATEGY_POP)).Link(Find.ById(controlID)).Click();
            CommonFunction.TradeOptions(browser, "OptionChainPanel_CheckBox_2", 1, 2, OrderType.Market);

            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, SYMBOL_DIAGONAL));
        }

        //Buy 2 IronButterfly @Market
        [Test]
        public void T07_Options_Buy2IronButterflyMarket()
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
            CommonFunction.TradeOptions(browser, "OptionChainPanel_CheckBox_2", 1, 2, OrderType.Market);

            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, SYMBOL_IRONBF));
        }

        //Buy 2 IronCondor @Market
        [Test]
        public void T08_Options_Buy2IronCondorMarket()
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
            CommonFunction.TradeOptions(browser, "OptionChainPanel_CheckBox_2", 1, 2, OrderType.Market);

            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, SYMBOL_IRONCD));
        }

        //Buy 2 Ratio @Market
        [Test]
        public void T09_Options_Buy2RatioMarket()
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
            CommonFunction.TradeOptions(browser, "OptionChainPanel_CheckBox_2", 1, 2, OrderType.Market);

            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, SYMBOL_RATIO));
        }

        //Buy 2 Spread @Market
        [Test]
        public void T10_Options_Buy2SpreadMarket()
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
            CommonFunction.TradeOptions(browser, "OptionChainPanel_CheckBox_2", 1, 2, OrderType.Market);

            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, SYMBOL_SPREAD));
        }

        //Buy 2 Straddle @Market
        [Test]
        public void T11_Options_Buy2StraddleMarket()
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
            CommonFunction.TradeOptions(browser, "OptionChainPanel_CheckBox_2", 1, 2, OrderType.Market);

            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, SYMBOL_STRADDLE));
        }

        //Buy 2 Strangle @Market
        [Test]
        public void T12_Options_Buy2StrangleMarket()
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
            CommonFunction.TradeOptions(browser, "OptionChainPanel_CheckBox_2", 1, 2, OrderType.Market);

            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, SYMBOL_STRANGLE));
        }
    }
}
