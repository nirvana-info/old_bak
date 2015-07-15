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
    public class Options_Module_3 : CommonFunction
    {
        //Buy 6 Calendar @Market
        [Test]
        public void T01_Options_Buy2CalendarMarket()
        {
            SignIn(UN1, PWD1, SA1);
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxAccount")).WaitUntilExists();

            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxRadTabTopNav")).Span(Find.ByText("Options")).Click();
            browser.Button(Find.ById("MutualFundTicket_PreviewOrder")).WaitUntilExists();

            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).WaitUntilExists();
            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).TypeText(symbol_5);
            Thread.Sleep(2000);
            browser.Div(Find.ById("OptionTicket_StrategyImgSmall")).Click();
            //Calendar
            string controlID = this.GetStrategyControl(OptionStrategy.Calendar);
            browser.Div(Find.ById("OptionTicket_StrategyPop")).Link(Find.ById(controlID)).Click();
            this.TradeOptions("OptionChainPanel_CheckBox_2", 1, 2, OrderType.Market);

            browser.Div(Find.ById("Trading_SummaryView_PositionsPanel")).Element(Find.ById("uxRefreshBtn")).Click();
            Thread.Sleep(20000);

            for (int i = 0; i < browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows.Count; i++)
            {
                if ((browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].TableCells.Count > 1) &&
                    (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].Span(Find.ByClass("float-left")).Exists == true) &&
                    (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].Span(Find.ByClass("float-left")).Text == symbol_3.ToUpper()))
                {
                    Assert.IsTrue(true);
                    return;
                }
            }

            Assert.IsTrue(false);
        }

        //Buy 6 Collar @Market
        [Test]
        public void T02_Options_Buy2CollarMarket()
        {
            SignIn(UN1, PWD1, SA1);
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxAccount")).WaitUntilExists();

            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxRadTabTopNav")).Span(Find.ByText("Options")).Click();
            browser.Button(Find.ById("MutualFundTicket_PreviewOrder")).WaitUntilExists();

            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).WaitUntilExists();
            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).TypeText(symbol_6);
            Thread.Sleep(2000);
            browser.Div(Find.ById("OptionTicket_StrategyImgSmall")).Click();
            //Collar
            string controlID = this.GetStrategyControl(OptionStrategy.Collar);
            browser.Div(Find.ById("OptionTicket_StrategyPop")).Link(Find.ById(controlID)).Click();
            this.TradeOptions("OptionChainPanel_CheckBox_2", 1, 2, OrderType.Market);

            browser.Div(Find.ById("Trading_SummaryView_PositionsPanel")).Element(Find.ById("uxRefreshBtn")).Click();
            Thread.Sleep(20000);

            for (int i = 0; i < browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows.Count; i++)
            {
                if ((browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].TableCells.Count > 1) &&
                    (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].Span(Find.ByClass("float-left")).Exists == true) &&
                    (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].Span(Find.ByClass("float-left")).Text == symbol_3.ToUpper()))
                {
                    Assert.IsTrue(true);
                    return;
                }
            }

            Assert.IsTrue(false);
        }

        //Buy 6 Condor @Market
        [Test]
        public void T03_Options_Buy2CondorMarket()
        {
            SignIn(UN1, PWD1, SA1);
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxAccount")).WaitUntilExists();

            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxRadTabTopNav")).Span(Find.ByText("Options")).Click();
            browser.Button(Find.ById("MutualFundTicket_PreviewOrder")).WaitUntilExists();

            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).WaitUntilExists();
            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).TypeText(symbol_7);
            Thread.Sleep(2000);
            browser.Div(Find.ById("OptionTicket_StrategyImgSmall")).Click();
            //Condor
            string controlID = this.GetStrategyControl(OptionStrategy.Condor);
            browser.Div(Find.ById("OptionTicket_StrategyPop")).Link(Find.ById(controlID)).Click();
            this.TradeOptions("OptionChainPanel_CheckBox_2", 1, 2, OrderType.Market);

            browser.Div(Find.ById("Trading_SummaryView_PositionsPanel")).Element(Find.ById("uxRefreshBtn")).Click();
            Thread.Sleep(20000);

            for (int i = 0; i < browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows.Count; i++)
            {
                if ((browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].TableCells.Count > 1) &&
                    (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].Span(Find.ByClass("float-left")).Exists == true) &&
                    (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].Span(Find.ByClass("float-left")).Text == symbol_3.ToUpper()))
                {
                    Assert.IsTrue(true);
                    return;
                }
            }

            Assert.IsTrue(false);
        }

        //Buy 6 Covered @Market
        [Test]
        public void T04_Options_Buy2CoveredMarket()
        {
            SignIn(UN1, PWD1, SA1);
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxAccount")).WaitUntilExists();

            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxRadTabTopNav")).Span(Find.ByText("Options")).Click();
            browser.Button(Find.ById("MutualFundTicket_PreviewOrder")).WaitUntilExists();

            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).WaitUntilExists();
            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).TypeText(symbol_8);
            Thread.Sleep(2000);
            browser.Div(Find.ById("OptionTicket_StrategyImgSmall")).Click();
            //Covered
            string controlID = this.GetStrategyControl(OptionStrategy.Covered);
            browser.Div(Find.ById("OptionTicket_StrategyPop")).Link(Find.ById(controlID)).Click();
            this.TradeOptions("OptionChainPanel_CheckBox_2", 1, 2, OrderType.Market);

            browser.Div(Find.ById("Trading_SummaryView_PositionsPanel")).Element(Find.ById("uxRefreshBtn")).Click();
            Thread.Sleep(20000);

            for (int i = 0; i < browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows.Count; i++)
            {
                if ((browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].TableCells.Count > 1) &&
                    (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].Span(Find.ByClass("float-left")).Exists == true) &&
                    (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].Span(Find.ByClass("float-left")).Text == symbol_3.ToUpper()))
                {
                    Assert.IsTrue(true);
                    return;
                }
            }

            Assert.IsTrue(false);
        }

        //Buy 6 IronButterfly @Market
        [Test]
        public void T05_Options_Buy2IronButterflyMarket()
        {
            SignIn(UN1, PWD1, SA1);
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxAccount")).WaitUntilExists();

            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxRadTabTopNav")).Span(Find.ByText("Options")).Click();
            browser.Button(Find.ById("MutualFundTicket_PreviewOrder")).WaitUntilExists();

            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).WaitUntilExists();
            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).TypeText(symbol_9);
            Thread.Sleep(2000);
            browser.Div(Find.ById("OptionTicket_StrategyImgSmall")).Click();
            //IronButterfly
            string controlID = this.GetStrategyControl(OptionStrategy.IronButterfly);
            browser.Div(Find.ById("OptionTicket_StrategyPop")).Link(Find.ById(controlID)).Click();
            this.TradeOptions("OptionChainPanel_CheckBox_2", 1, 2, OrderType.Market);

            browser.Div(Find.ById("Trading_SummaryView_PositionsPanel")).Element(Find.ById("uxRefreshBtn")).Click();
            Thread.Sleep(20000);

            for (int i = 0; i < browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows.Count; i++)
            {
                if ((browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].TableCells.Count > 1) &&
                    (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].Span(Find.ByClass("float-left")).Exists == true) &&
                    (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].Span(Find.ByClass("float-left")).Text == symbol_3.ToUpper()))
                {
                    Assert.IsTrue(true);
                    return;
                }
            }

            Assert.IsTrue(false);
        }

        //Buy 6 IronCondor @Market
        [Test]
        public void T06_Options_Buy2IronCondorMarket()
        {
            SignIn(UN1, PWD1, SA1);
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxAccount")).WaitUntilExists();

            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxRadTabTopNav")).Span(Find.ByText("Options")).Click();
            browser.Button(Find.ById("MutualFundTicket_PreviewOrder")).WaitUntilExists();

            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).WaitUntilExists();
            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).TypeText(symbol_10);
            Thread.Sleep(2000);
            browser.Div(Find.ById("OptionTicket_StrategyImgSmall")).Click();
            //IronCondor
            string controlID = this.GetStrategyControl(OptionStrategy.IronCondor);
            browser.Div(Find.ById("OptionTicket_StrategyPop")).Link(Find.ById(controlID)).Click();
            this.TradeOptions("OptionChainPanel_CheckBox_2", 1, 2, OrderType.Market);

            browser.Div(Find.ById("Trading_SummaryView_PositionsPanel")).Element(Find.ById("uxRefreshBtn")).Click();
            Thread.Sleep(20000);

            for (int i = 0; i < browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows.Count; i++)
            {
                if ((browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].TableCells.Count > 1) &&
                    (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].Span(Find.ByClass("float-left")).Exists == true) &&
                    (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].Span(Find.ByClass("float-left")).Text == symbol_3.ToUpper()))
                {
                    Assert.IsTrue(true);
                    return;
                }
            }

            Assert.IsTrue(false);
        }

        //Buy 6 Ratio @Market
        [Test]
        public void T07_Options_Buy2RatioMarket()
        {
            SignIn(UN1, PWD1, SA1);
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxAccount")).WaitUntilExists();

            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxRadTabTopNav")).Span(Find.ByText("Options")).Click();
            browser.Button(Find.ById("MutualFundTicket_PreviewOrder")).WaitUntilExists();

            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).WaitUntilExists();
            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).TypeText(symbol_11);
            Thread.Sleep(2000);
            browser.Div(Find.ById("OptionTicket_StrategyImgSmall")).Click();
            //Ratio
            string controlID = this.GetStrategyControl(OptionStrategy.Ratio);
            browser.Div(Find.ById("OptionTicket_StrategyPop")).Link(Find.ById(controlID)).Click();
            this.TradeOptions("OptionChainPanel_CheckBox_2", 1, 2, OrderType.Market);

            browser.Div(Find.ById("Trading_SummaryView_PositionsPanel")).Element(Find.ById("uxRefreshBtn")).Click();
            Thread.Sleep(20000);

            for (int i = 0; i < browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows.Count; i++)
            {
                if ((browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].TableCells.Count > 1) &&
                    (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].Span(Find.ByClass("float-left")).Exists == true) &&
                    (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].Span(Find.ByClass("float-left")).Text == symbol_3.ToUpper()))
                {
                    Assert.IsTrue(true);
                    return;
                }
            }

            Assert.IsTrue(false);
        }

        //Buy 6 Spread @Market
        [Test]
        public void T08_Options_Buy2SpreadMarket()
        {
            SignIn(UN1, PWD1, SA1);
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxAccount")).WaitUntilExists();

            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxRadTabTopNav")).Span(Find.ByText("Options")).Click();
            browser.Button(Find.ById("MutualFundTicket_PreviewOrder")).WaitUntilExists();

            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).WaitUntilExists();
            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).TypeText(symbol_12);
            Thread.Sleep(2000);
            browser.Div(Find.ById("OptionTicket_StrategyImgSmall")).Click();
            //Spread
            string controlID = this.GetStrategyControl(OptionStrategy.Spread);
            browser.Div(Find.ById("OptionTicket_StrategyPop")).Link(Find.ById(controlID)).Click();
            this.TradeOptions("OptionChainPanel_CheckBox_2", 1, 2, OrderType.Market);

            browser.Div(Find.ById("Trading_SummaryView_PositionsPanel")).Element(Find.ById("uxRefreshBtn")).Click();
            Thread.Sleep(20000);

            for (int i = 0; i < browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows.Count; i++)
            {
                if ((browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].TableCells.Count > 1) &&
                    (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].Span(Find.ByClass("float-left")).Exists == true) &&
                    (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].Span(Find.ByClass("float-left")).Text == symbol_3.ToUpper()))
                {
                    Assert.IsTrue(true);
                    return;
                }
            }

            Assert.IsTrue(false);
        }

        //Buy 6 Straddle @Market
        [Test]
        public void T09_Options_Buy2StraddleMarket()
        {
            SignIn(UN1, PWD1, SA1);
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxAccount")).WaitUntilExists();

            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxRadTabTopNav")).Span(Find.ByText("Options")).Click();
            browser.Button(Find.ById("MutualFundTicket_PreviewOrder")).WaitUntilExists();

            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).WaitUntilExists();
            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).TypeText(symbol_13);
            Thread.Sleep(2000);
            browser.Div(Find.ById("OptionTicket_StrategyImgSmall")).Click();
            //Straddle
            string controlID = this.GetStrategyControl(OptionStrategy.Straddle);
            browser.Div(Find.ById("OptionTicket_StrategyPop")).Link(Find.ById(controlID)).Click();
            this.TradeOptions("OptionChainPanel_CheckBox_2", 1, 2, OrderType.Market);

            browser.Div(Find.ById("Trading_SummaryView_PositionsPanel")).Element(Find.ById("uxRefreshBtn")).Click();
            Thread.Sleep(20000);

            for (int i = 0; i < browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows.Count; i++)
            {
                if ((browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].TableCells.Count > 1) &&
                    (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].Span(Find.ByClass("float-left")).Exists == true) &&
                    (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].Span(Find.ByClass("float-left")).Text == symbol_3.ToUpper()))
                {
                    Assert.IsTrue(true);
                    return;
                }
            }

            Assert.IsTrue(false);
        }

        //Buy 6 Strangle @Market
        [Test]
        public void T10_Options_Buy2StrangleMarket()
        {
            SignIn(UN1, PWD1, SA1);
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxAccount")).WaitUntilExists();

            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxRadTabTopNav")).Span(Find.ByText("Options")).Click();
            browser.Button(Find.ById("MutualFundTicket_PreviewOrder")).WaitUntilExists();

            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).WaitUntilExists();
            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).TypeText(symbol_14);
            Thread.Sleep(2000);
            browser.Div(Find.ById("OptionTicket_StrategyImgSmall")).Click();
            //Strangle
            string controlID = this.GetStrategyControl(OptionStrategy.Strangle);
            browser.Div(Find.ById("OptionTicket_StrategyPop")).Link(Find.ById(controlID)).Click();
            this.TradeOptions("OptionChainPanel_CheckBox_2", 1, 2, OrderType.Market);

            browser.Div(Find.ById("Trading_SummaryView_PositionsPanel")).Element(Find.ById("uxRefreshBtn")).Click();
            Thread.Sleep(20000);

            for (int i = 0; i < browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows.Count; i++)
            {
                if ((browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].TableCells.Count > 1) &&
                    (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].Span(Find.ByClass("float-left")).Exists == true) &&
                    (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].Span(Find.ByClass("float-left")).Text == symbol_3.ToUpper()))
                {
                    Assert.IsTrue(true);
                    return;
                }
            }

            Assert.IsTrue(false);
        }
    }
}
