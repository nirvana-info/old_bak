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
    public class Options_Module_1 : CommonFunction
    {
        //Buy 6 Call&Put @Market
        [Test]
        public void T01_Options_Buy6CallPutMarket()
        {
            SignIn(UN1, PWD1, SA1);
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxAccount")).WaitUntilExists();

            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxRadTabTopNav")).Span(Find.ByText("Options")).Click();
            browser.Button(Find.ById("MutualFundTicket_PreviewOrder")).WaitUntilExists();

            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).WaitUntilExists();
            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).TypeText(symbol_3);
            Thread.Sleep(2000);
            browser.Div(Find.ById("OptionTicket_StrategyImgSmall")).Click();
            //calls & puts
            string controlID = this.GetStrategyControl(OptionStrategy.CallPut);
            browser.Div(Find.ById("OptionTicket_StrategyPop")).Link(Find.ById(controlID)).Click();
            this.TradeOptions("OptionChainPanel_CheckBox_2", 1, 6, OrderType.Market);

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

        //Sell 1 Call&Put @Limit
        [Test]
        public void T02_Options_Sell1CallPutLimit()
        {
            SignIn(UN1, PWD1, SA1);
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxAccount")).WaitUntilExists();

            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxRadTabTopNav")).Span(Find.ByText("Options")).Click();
            browser.Button(Find.ById("MutualFundTicket_PreviewOrder")).WaitUntilExists();

            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).WaitUntilExists();
            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).TypeText(symbol_3);
            Thread.Sleep(2000);
            browser.Div(Find.ById("OptionTicket_StrategyImgSmall")).Click();
            //calls & puts
            string controlID = this.GetStrategyControl(OptionStrategy.CallPut);
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

        //Sell 1 Call&Put @Stop
        [Test]
        public void T03_Options_Sell1CallPutStop()
        {
            SignIn(UN1, PWD1, SA1);
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxAccount")).WaitUntilExists();

            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxRadTabTopNav")).Span(Find.ByText("Options")).Click();
            browser.Button(Find.ById("MutualFundTicket_PreviewOrder")).WaitUntilExists();

            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).WaitUntilExists();
            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).TypeText(symbol_3);
            Thread.Sleep(2000);
            browser.Div(Find.ById("OptionTicket_StrategyImgSmall")).Click();
            //calls & puts
            string controlID = this.GetStrategyControl(OptionStrategy.CallPut);
            browser.Div(Find.ById("OptionTicket_StrategyPop")).Link(Find.ById(controlID)).Click();
            this.TradeOptions("OptionChainPanel_CheckBox_2", 2, 1, OrderType.Stop);

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

        //Sell 1 Call&Put @Stop Limit
        [Test]
        public void T04_Options_Sell1CallPutStopLimit()
        {
            SignIn(UN1, PWD1, SA1);
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxAccount")).WaitUntilExists();

            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxRadTabTopNav")).Span(Find.ByText("Options")).Click();
            browser.Button(Find.ById("MutualFundTicket_PreviewOrder")).WaitUntilExists();

            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).WaitUntilExists();
            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).TypeText(symbol_3);
            Thread.Sleep(2000);
            browser.Div(Find.ById("OptionTicket_StrategyImgSmall")).Click();
            //calls & puts
            string controlID = this.GetStrategyControl(OptionStrategy.CallPut);
            browser.Div(Find.ById("OptionTicket_StrategyPop")).Link(Find.ById(controlID)).Click();
            //buy 80 call
            this.TradeOptions("OptionChainPanel_CheckBox_2", 2, 1, OrderType.StopLimit);

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

        //Sell 1 Call&Put @Trailing Stop $
        [Test]
        public void T05_Options_Sell1CallPutTrailingStopDollar()
        {
            SignIn(UN1, PWD1, SA1);
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxAccount")).WaitUntilExists();

            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxRadTabTopNav")).Span(Find.ByText("Options")).Click();
            browser.Button(Find.ById("MutualFundTicket_PreviewOrder")).WaitUntilExists();

            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).WaitUntilExists();
            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).TypeText(symbol_3);
            Thread.Sleep(2000);
            browser.Div(Find.ById("OptionTicket_StrategyImgSmall")).Click();
            //calls & puts
            string controlID = this.GetStrategyControl(OptionStrategy.CallPut);
            browser.Div(Find.ById("OptionTicket_StrategyPop")).Link(Find.ById(controlID)).Click();
            //buy 80 call
            this.TradeOptions("OptionChainPanel_CheckBox_2", 2, 1, OrderType.TrailingStopDollar);

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

        //Sell 1 Call&Put @Trailing Stop %
        [Test]
        public void T06_Options_Sell1CallPutTrailingStopPercent()
        {
            SignIn(UN1, PWD1, SA1);
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxAccount")).WaitUntilExists();

            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxRadTabTopNav")).Span(Find.ByText("Options")).Click();
            browser.Button(Find.ById("MutualFundTicket_PreviewOrder")).WaitUntilExists();

            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).WaitUntilExists();
            browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).TypeText(symbol_3);
            Thread.Sleep(2000);
            browser.Div(Find.ById("OptionTicket_StrategyImgSmall")).Click();
            //calls & puts
            string controlID = this.GetStrategyControl(OptionStrategy.CallPut);
            browser.Div(Find.ById("OptionTicket_StrategyPop")).Link(Find.ById(controlID)).Click();
            //buy 80 call
            this.TradeOptions("OptionChainPanel_CheckBox_2", 2, 1, OrderType.TrailingStopPercent);

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

        //[Test]
        //public void T02_Options_BuyCallPutLimitCancel()
        //{
        //    SignIn(UN1, PWD1, SA1);
        //    browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxAccount")).WaitUntilExists();

        //    browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxRadTabTopNav")).Span(Find.ByText("Options")).Click();

        //    browser.Span(Find.ById("TradeBalance_NetCash")).WaitUntilExists();
        //    float netCash = 0f;
        //    if (this.GetMoney("TradeBalance_NetCash", ref netCash) == false)
        //    {
        //        Console.WriteLine("Invalid net cash : " + browser.Span(Find.ById("TradeBalance_NetCash")).Text);
        //        Assert.IsTrue(false);
        //        return;
        //    }

        //    browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).WaitUntilExists();
        //    browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).TypeText("V");
        //    Thread.Sleep(2000);
        //    browser.Div(Find.ById("OptionTicket_StrategyImgSmall")).Click();
        //    //calls & puts
        //    browser.Div(Find.ById("OptionTicket_StrategyPop")).Link(Find.ById("OptionTicket_code_1")).Click();
        //    //buy 80 call
        //    Thread.Sleep(10000);
        //    for (int i = 0; i < browser.Div(Find.ById("optionchain_datepanel")).CheckBoxes.Count; i++)
        //    {
        //        if (browser.Div(Find.ById("optionchain_datepanel")).CheckBoxes[i].Checked == true)
        //        {
        //            browser.Div(Find.ById("optionchain_datepanel")).CheckBoxes[i].Checked = false;
        //        }
        //    }
        //    Thread.Sleep(2000);
        //    //Jun 2010 (V)
        //    browser.CheckBox(Find.ById("OptionChainPanel_CheckBox_3")).Checked = true;
        //    Thread.Sleep(5000);
        //    Console.WriteLine(browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_JsonOptionChainPanel_uxRepeaterOptionChainLines")).Links.Count);
        //    browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_JsonOptionChainPanel_uxRepeaterOptionChainLines")).Links[1].Click();
        //    browser.SelectList(Find.ById("OptionTicket_OrderTypeDDL")).Option(Find.ByText("Limit")).Select();
        //    Thread.Sleep(2000);
        //    browser.TextField(Find.ById("OptionTicket_LimitSpinner")).TypeText("9.99");
        //    browser.Button(Find.ById("OptionTicket_SubmitOrder")).Click();
        //    Thread.Sleep(2000);

        //    browser.Span(Find.ById("OrderDetail_EstmCost")).WaitUntilExists();
        //    float estCost = 0f;
        //    if (this.GetMoney("OrderDetail_EstmCost", ref estCost) == false)
        //    {
        //        Console.WriteLine("Invalid estimated cost : " + browser.Span(Find.ById("OrderDetail_EstmCost")).Text);
        //        Assert.IsTrue(false);
        //        return;
        //    }
        //    browser.Div(Find.ById("OrderPopup_Preview")).Button(Find.ById("OrderPreview_BtnSumbitOrder")).Click();
        //    Thread.Sleep(2000);
        //    browser.Div(Find.ById("OrderPopup_Confirmation")).Button(Find.ById("OrderConfirmation_BtnOrderStatus")).Click();

        //    Thread.Sleep(60000);
        //    browser.Div(Find.ById("tradebalance_fullpanel")).Element(Find.ById("TradeBalance_RefreshBtn")).Click();
        //    Thread.Sleep(5000);
        //    browser.Span(Find.ById("TradeBalance_NetCash")).WaitUntilExists();
        //    float netCash_1 = 0f;
        //    if (this.GetMoney("TradeBalance_NetCash", ref netCash_1) == false)
        //    {
        //        Console.WriteLine("Invalid net cash : " + browser.Span(Find.ById("TradeBalance_NetCash")).Text);
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

        //    //open in order panel
        //    browser.RadioButton(Find.ById("userControl_OrdersPanel_StatusGroup_OpenOnly_Id")).Checked = true;
        //    browser.Div(Find.ById("Trading_SummaryView_OrdersPanel")).Element(Find.ById("uxRefreshBtn")).Click();
        //    Thread.Sleep(10000);
        //    for (int i = 0; i < browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxOrdersPanel_OrdersPanel_uxOrderRepeater_Table")).TableRows.Count; i++)
        //    {
        //        if ((browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxOrdersPanel_OrdersPanel_uxOrderRepeater_Table")).TableRows[i].TableCells.Count > 1) &&
        //            (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxOrdersPanel_OrdersPanel_uxOrderRepeater_Table")).TableRows[i].TableCells[1].Text.Trim() == symbol_1.ToUpper()) &&
        //            (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxOrdersPanel_OrdersPanel_uxOrderRepeater_Table")).TableRows[i].TableCells[6].Text.Trim() == "Open"))
        //        {
        //            //cancel
        //            browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxOrdersPanel_OrdersPanel_uxOrderRepeater_Table")).TableRows[i].TableCells[8].Links[1].Click();
        //            browser.Button(Find.ById("OrderDetail_BtnCancelOrder")).WaitUntilExists();
        //            browser.Button(Find.ById("OrderDetail_BtnCancelOrder")).Click();
        //            Assert.IsTrue(true);
        //            return;
        //        }
        //    }

        //    Assert.IsTrue(false);
        //}

        ///// <summary>
        ///// BuyButterfly
        ///// 1.Input a symbol;
        ///// 2.Select a strategy type(butterfly);
        ///// 3.Select an expiration date;(can select different expiration date)
        ///// 4.Click a strike price to populate ticket;(can select different strike price)
        ///// 5.Place a Market order;
        ///// 6.Submit this order and check position.
        ///// </summary>
        //[Test]
        //public void T03_Options_BuyButterfly()
        //{
        //    SignIn(UN1, PWD1, SA1);
        //    browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxAccount")).WaitUntilExists();

        //    browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxRadTabTopNav")).Span(Find.ByText("Options")).Click();

        //    browser.Span(Find.ById("TradeBalance_NetCash")).WaitUntilExists();
        //    float netCash = 0f;
        //    if (this.GetMoney("TradeBalance_NetCash", ref netCash) == false)
        //    {
        //        Console.WriteLine("Invalid net cash : " + browser.Span(Find.ById("TradeBalance_NetCash")).Text);
        //        Assert.IsTrue(false);
        //        return;
        //    }

        //    browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).WaitUntilExists();
        //    browser.TextField(Find.ById("OptionTicket_SymbolTextBox")).TypeText("V");
        //    Thread.Sleep(2000);
        //    browser.Div(Find.ById("OptionTicket_StrategyImgSmall")).Click();
        //    //butterfly
        //    browser.Div(Find.ById("OptionTicket_StrategyPop")).Link(Find.ById("OptionTicket_code_2")).Click();
        //    //buy 80/85/90 call
        //    this.TradeOption(15);

        //    browser.Span(Find.ById("OrderDetail_EstmCost")).WaitUntilExists();
        //    float estCost = 0f;
        //    if (this.GetMoney("OrderDetail_EstmCost", ref estCost) == false)
        //    {
        //        Console.WriteLine("Invalid estimated cost : " + browser.Span(Find.ById("OrderDetail_EstmCost")).Text);
        //        Assert.IsTrue(false);
        //        return;
        //    }
        //    browser.Div(Find.ById("OrderPopup_Preview")).Button(Find.ById("OrderPreview_BtnSumbitOrder")).Click();
        //    Thread.Sleep(2000);
        //    browser.Div(Find.ById("OrderPopup_Confirmation")).Button(Find.ById("OrderConfirmation_BtnOrderStatus")).Click();

        //    Thread.Sleep(60000);
        //    browser.Div(Find.ById("tradebalance_fullpanel")).Element(Find.ById("TradeBalance_RefreshBtn")).Click();
        //    Thread.Sleep(5000);
        //    browser.Span(Find.ById("TradeBalance_NetCash")).WaitUntilExists();
        //    float netCash_1 = 0f;
        //    if (this.GetMoney("TradeBalance_NetCash", ref netCash_1) == false)
        //    {
        //        Console.WriteLine("Invalid net cash : " + browser.Span(Find.ById("TradeBalance_NetCash")).Text);
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
        public void T07_Options_History()
        {
            SignIn(UN1, PWD1, SA1);
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxAccount")).WaitUntilExists();

            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxRadTabPages")).Span(Find.ByText("History")).Click();
            Thread.Sleep(2000);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxHistorySummary_uxFromDate")).WaitUntilExists();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxHistorySummary_uxFromDate")).TypeText(DateTime.Now.AddDays(-1).ToString("MM/dd/yyyy"));
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxHistorySummary_uxToDate")).TypeText(DateTime.Now.ToString("MM/dd/yyyy"));
            browser.Button(Find.ById("History_uxFilterButton")).Click();
            Thread.Sleep(5000);

            //check result
        }

        [Test]
        public void T08_Options_DailyDisplay()
        {
            //TODO
        }

        [Test]
        public void T09_Options_AdvancedOrder()
        {
            SignIn(UN1, PWD1, SA1);
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxAccount")).WaitUntilExists();

            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxRadTabTopNav")).Span(Find.ByText("Advanced Orders")).Click();
            browser.SelectList(Find.ById("AdvancedTicket_OrderType")).WaitUntilExists();
            browser.SelectList(Find.ById("AdvancedTicket_OrderType")).Option(Find.ByText("One Triggers Others")).Select();
            Thread.Sleep(2000);
            browser.Button(Find.ById("AdvancedTicket_AddOption")).Click();
            Thread.Sleep(2000);
            browser.TextField(Find.ById("AdvancedTicket_Symbol_1")).TypeText(symbol_1);
            browser.TextField(Find.ById("AdvancedTicket_InputQuantity_1")).TypeText("5");
            browser.CheckBox(Find.ById("AdvancedTicket_Aon_1")).Checked = true;
            browser.TextField(Find.ById("AdvancedTicket_Symbol_2")).TypeText(symbol_5);
            browser.TextField(Find.ById("AdvancedTicket_InputQuantity_2")).TypeText("1");
        }

        private bool GetMoney(string moneyControlID, ref float fMoney)
        {
            int timeout = 0;

            string strMoney = browser.Span(Find.ById(moneyControlID)).Text;
            while ((string.IsNullOrEmpty(strMoney) == true) && (timeout < 30))
            {
                Thread.Sleep(2000);
                timeout += 2;
                strMoney = browser.Span(Find.ById(moneyControlID)).Text;
            }
            strMoney = strMoney.Replace("(", "").Replace(")", "").Replace("$", "").Replace(",", "");

            return float.TryParse(strMoney, out fMoney);
        }
    }
}
