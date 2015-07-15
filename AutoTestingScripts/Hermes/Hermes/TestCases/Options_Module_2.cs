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
    public class Options_Module_2 : CommonFunction
    {
        //Buy 6 Butterfly @Market
        [Test]
        public void T01_Options_Buy1ButterflyMarket()
        {
            SignIn(UN1, PWD1, SA1);
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxAccount")).WaitUntilExists();

            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxRadTabTopNav")).Span(Find.ByText("Options")).Click();
            browser.Button(Find.ById("MutualFundTicket_PreviewOrder")).WaitUntilExists();

            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).WaitUntilExists();
            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).TypeText(symbol_4);
            Thread.Sleep(2000);
            browser.Div(Find.ById("OptionTicket_StrategyImgSmall")).Click();
            //Butterfly
            string controlID = this.GetStrategyControl(OptionStrategy.Butterfly);
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

        //Sell 1 Butterfly @Limit
        [Test]
        public void T02_Options_Sell1ButterflyLimit()
        {
            SignIn(UN1, PWD1, SA1);
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxAccount")).WaitUntilExists();

            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxRadTabTopNav")).Span(Find.ByText("Options")).Click();
            browser.Button(Find.ById("MutualFundTicket_PreviewOrder")).WaitUntilExists();

            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).WaitUntilExists();
            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).TypeText(symbol_4);
            Thread.Sleep(2000);
            browser.Div(Find.ById("OptionTicket_StrategyImgSmall")).Click();
            //Butterfly
            string controlID = this.GetStrategyControl(OptionStrategy.Butterfly);
            browser.Div(Find.ById("OptionTicket_StrategyPop")).Link(Find.ById(controlID)).Click();
            this.TradeOptions("OptionChainPanel_CheckBox_2", 2, 1, OrderType.Limit);

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
