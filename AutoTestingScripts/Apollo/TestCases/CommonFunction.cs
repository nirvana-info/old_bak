using System;
using System.Text;
using System.Threading;
using WatiN.Core;

namespace Apollo.TestCases
{
    public static class CommonFunction
    {
        public const string ACCOUNT_LIST = "ctl00_ctl00_uxMainContent_uxMainContainerTop_uxAccountShow";

        public const string TOP_TAB = "ctl00_ctl00_uxMainContent_uxMainContainerTop_uxTabStrip1";

        public const string BOTTOM_TAB = "ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxTabStrip2";

        public const string STRATEGY_POP = "OptionTicket_StrategyPop";

        public static void TradeStocks(Browser browser, Transaction tran, string symbol, int qty, OrderType orderType)
        {
            browser.SelectList(Find.ById("EquityTicket_Transaction")).Option(Find.ByText(tran.ToString())).Select();
            browser.TextField(Find.ById("EquityTicket_uxSymbol")).TypeText(symbol);
            Thread.Sleep(5000);
            browser.TextField(Find.ById("EquityTicket_uxQuantity")).TypeText(qty.ToString());
            string last = browser.Span(Find.ById("EquityTicket_uxLast")).Text.Substring(1).Trim();
            switch (orderType)
            {
                case OrderType.Market:
                    browser.SelectList(Find.ById("EquityTicket_PriceType")).Option(Find.ByValue("1")).Select();
                    break;
                case OrderType.Limit:
                    browser.SelectList(Find.ById("EquityTicket_PriceType")).Option(Find.ByValue("2")).Select();
                    browser.TextField(Find.ById("EquityTicket_uxLimitPrice")).TypeText(last);
                    break;
                case OrderType.Stop:
                    browser.SelectList(Find.ById("EquityTicket_PriceType")).Option(Find.ByValue("3")).Select();
                    browser.TextField(Find.ById("EquityTicket_uxStopPrice")).TypeText(last);
                    break;
                case OrderType.StopLimit:
                    browser.SelectList(Find.ById("EquityTicket_PriceType")).Option(Find.ByValue("4")).Select();
                    browser.TextField(Find.ById("EquityTicket_uxLimitPrice")).TypeText(last);
                    browser.TextField(Find.ById("EquityTicket_uxStopPrice")).TypeText(last);
                    break;
                case OrderType.TrailingStopDollar:
                    browser.SelectList(Find.ById("EquityTicket_PriceType")).Option(Find.ByValue("5")).Select();
                    break;
                case OrderType.TrailingStopPercent:
                    browser.SelectList(Find.ById("EquityTicket_PriceType")).Option(Find.ByValue("6")).Select();
                    break;
                default:
                    break;
            }
            //browser.CheckBox(Find.ById("EquityTicket_uxAON")).Checked = false;
            browser.Button(Find.ById("EquitTicket_PreviewOrder")).Click();
            Thread.Sleep(2000);
            browser.Span(Find.ById("OrderDetail_EstmCost")).WaitUntilExists();
            browser.Div(Find.ById("OrderPopup_Preview")).Button(Find.ById("OrderPreview_BtnSumbitOrder")).Click();
            Thread.Sleep(2000);
            browser.Div(Find.ById("OrderPopup_Confirmation")).Button(Find.ById("OrderConfirmation_BtnOrderStatus")).Click();
            Thread.Sleep(60000);
        }

        public static void TradeOptions(Browser browser, string expiration, int action, int qty, OrderType orderType)
        {
            Thread.Sleep(10000);
            for (int i = 0; i < browser.Div(Find.ById("optionchain_datepanel")).CheckBoxes.Count; i++)
            {
                if (browser.Div(Find.ById("optionchain_datepanel")).CheckBoxes[i].Checked == true)
                {
                    browser.Div(Find.ById("optionchain_datepanel")).CheckBoxes[i].Checked = false;
                }
            }
            Thread.Sleep(2000);

            browser.Div(Find.ById("optionchain_datepanel")).CheckBox(Find.ById(expiration)).Checked = true;
            Thread.Sleep(5000);
            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_JsonOptionChainPanel_uxRepeaterOptionChainLines")).Links[action].Click();
            Thread.Sleep(2000);

            browser.TextField(Find.ById("OptionTicket_InputQuantity_1")).TypeText(qty.ToString());
            switch (orderType)
            {
                case OrderType.Market:
                    browser.SelectList(Find.ById("OptionTicket_OrderTypeDDL")).Option(Find.ByValue("1")).Select();
                    break;
                case OrderType.Limit:
                    browser.SelectList(Find.ById("OptionTicket_OrderTypeDDL")).Option(Find.ByValue("2")).Select();
                    break;
                case OrderType.Stop:
                    browser.SelectList(Find.ById("OptionTicket_OrderTypeDDL")).Option(Find.ByValue("3")).Select();
                    break;
                case OrderType.StopLimit:
                    browser.SelectList(Find.ById("OptionTicket_OrderTypeDDL")).Option(Find.ByValue("4")).Select();
                    break;
                case OrderType.TrailingStopDollar:
                    browser.SelectList(Find.ById("OptionTicket_OrderTypeDDL")).Option(Find.ByValue("5")).Select();
                    break;
                case OrderType.TrailingStopPercent:
                    browser.SelectList(Find.ById("OptionTicket_OrderTypeDDL")).Option(Find.ByValue("6")).Select();
                    break;
                default:
                    break;
            }
            Thread.Sleep(2000);
            browser.Button(Find.ById("OptionTicket_SubmitOrder")).Click();
            Thread.Sleep(2000);
            browser.Span(Find.ById("OrderDetail_EstmCost")).WaitUntilExists();
            browser.Div(Find.ById("OrderPopup_Preview")).Button(Find.ById("OrderPreview_BtnSumbitOrder")).Click();
            Thread.Sleep(2000);
            browser.Div(Find.ById("OrderPopup_Confirmation")).Button(Find.ById("OrderConfirmation_BtnOrderStatus")).Click();
            Thread.Sleep(60000);
        }

        public static void TradeAdvanced(Browser browser, int type, string symbol1, string symbol2)
        {
            browser.TextField(Find.ById("AdvancedTicket_Symbol_1")).TypeText(symbol1);
            Thread.Sleep(2000);
            browser.TextField(Find.ById("AdvancedTicket_Symbol_2")).TypeText(symbol2);
            Thread.Sleep(2000);
            browser.TextField(Find.ById("AdvancedTicket_InputQuantity_1")).TypeText("1");
            browser.TextField(Find.ById("AdvancedTicket_InputQuantity_2")).TypeText("1");
            int strike = 0;
            switch (type)
            {
                case 1121:
                    browser.RadioButton(Find.ById("AdvancedTiceket_OrderType_1_1")).Checked = true;
                    browser.RadioButton(Find.ById("AdvancedTiceket_OrderType_2_1")).Checked = true;
                    break;
                case 1122:
                    browser.RadioButton(Find.ById("AdvancedTiceket_OrderType_1_1")).Checked = true;
                    browser.RadioButton(Find.ById("AdvancedTiceket_OrderType_2_2")).Checked = true;
                    browser.SelectList(Find.ById("AdvancedTicket_SelectExpiration_2")).Options[0].Select();
                    strike = browser.SelectList(Find.ById("AdvancedTicket_SelectStrike_2")).Options.Count;
                    browser.SelectList(Find.ById("AdvancedTicket_SelectStrike_2")).Options[strike / 2].Select();
                    break;
                case 1221:
                    browser.RadioButton(Find.ById("AdvancedTiceket_OrderType_1_2")).Checked = true;
                    browser.SelectList(Find.ById("AdvancedTicket_SelectExpiration_1")).Options[0].Select();
                    strike = browser.SelectList(Find.ById("AdvancedTicket_SelectStrike_1")).Options.Count;
                    browser.SelectList(Find.ById("AdvancedTicket_SelectStrike_1")).Options[strike].Select();
                    browser.RadioButton(Find.ById("AdvancedTiceket_OrderType_2_1")).Checked = true;
                    break;
                case 1222:
                    browser.RadioButton(Find.ById("AdvancedTiceket_OrderType_1_2")).Checked = true;
                    browser.SelectList(Find.ById("AdvancedTicket_SelectExpiration_1")).Options[0].Select();
                    strike = browser.SelectList(Find.ById("AdvancedTicket_SelectStrike_1")).Options.Count;
                    browser.SelectList(Find.ById("AdvancedTicket_SelectStrike_1")).Options[strike].Select();
                    browser.RadioButton(Find.ById("AdvancedTiceket_OrderType_2_2")).Checked = true;
                    browser.SelectList(Find.ById("AdvancedTicket_SelectExpiration_2")).Options[0].Select();
                    strike = browser.SelectList(Find.ById("AdvancedTicket_SelectStrike_2")).Options.Count;
                    browser.SelectList(Find.ById("AdvancedTicket_SelectStrike_2")).Options[strike / 2].Select();
                    break;
                default:
                    break;
            }
            browser.TextField(Find.ById("AdvancedTicket_Limit_1")).TypeText(browser.Span(Find.ById("AdvancedTicket_quote_Bid_1")).Text.Substring(1).Trim());
            browser.TextField(Find.ById("AdvancedTicket_Limit_2")).TypeText(browser.Span(Find.ById("AdvancedTicket_quote_Bid_2")).Text.Substring(1).Trim());

            browser.Button(Find.ById("OptionTicket_SubmitOrder")).Click();
            Thread.Sleep(2000);
            browser.Span(Find.ById("OrderDetail_EstmCost")).WaitUntilExists();
            browser.Div(Find.ById("OrderPopup_Preview")).Button(Find.ById("OrderPreview_BtnSumbitOrder")).Click();
            Thread.Sleep(2000);
            browser.Div(Find.ById("OrderPopup_Confirmation")).Button(Find.ById("OrderConfirmation_BtnOrderStatus")).Click();
            Thread.Sleep(60000);
        }

        public static string GetStrategyControl(OptionStrategy strategy)
        {
            string controlID = string.Empty;

            switch (strategy)
            {
                case OptionStrategy.CallPut:
                    controlID = "OptionTicket_code_1";
                    break;
                case OptionStrategy.Butterfly:
                    controlID = "OptionTicket_code_2";
                    break;
                case OptionStrategy.Calendar:
                    controlID = "OptionTicket_code_3";
                    break;
                case OptionStrategy.Collar:
                    controlID = "OptionTicket_code_13";
                    break;
                case OptionStrategy.Condor:
                    controlID = "OptionTicket_code_4";
                    break;
                case OptionStrategy.Covered:
                    controlID = "OptionTicket_code_5";
                    break;
                case OptionStrategy.Diagonal:
                    controlID = "OptionTicket_code_19";
                    break;
                case OptionStrategy.IronButterfly:
                    controlID = "OptionTicket_code_6";
                    break;
                case OptionStrategy.IronCondor:
                    controlID = "OptionTicket_code_7";
                    break;
                case OptionStrategy.Ratio:
                    controlID = "OptionTicket_code_9";
                    break;
                case OptionStrategy.Spread:
                    controlID = "OptionTicket_code_10";
                    break;
                case OptionStrategy.Straddle:
                    controlID = "OptionTicket_code_11";
                    break;
                case OptionStrategy.Strangle:
                    controlID = "OptionTicket_code_12";
                    break;
                default:
                    break;
            }

            return controlID;
        }

        public static bool CheckOrderStatusPanel(Browser browser, string symbol)
        {
            browser.Div(Find.ById("Trading_SummaryView_OrdersPanel")).Element(Find.ById("uxRefreshBtn")).Click();
            Thread.Sleep(10000);
            for (int i = 0; i < browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxOrdersPanel_OrdersPanel_uxOrderRepeater_Table")).TableRows.Count; i++)
            {
                if ((browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxOrdersPanel_OrdersPanel_uxOrderRepeater_Table")).TableRows[i].TableCells.Count > 1) &&
                    (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxOrdersPanel_OrdersPanel_uxOrderRepeater_Table")).TableRows[i].Span(Find.ByClass("float-left")).Exists == true) &&
                    (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxOrdersPanel_OrdersPanel_uxOrderRepeater_Table")).TableRows[i].Span(Find.ByClass("float-left")).Text == symbol.ToUpper()))
                {
                    return true;
                }
            }
            return false;
        }

        public static bool CheckPositionPanel(Browser browser, string symbol)
        {
            browser.Div(Find.ById("Trading_SummaryView_PositionsPanel")).Element(Find.ById("uxRefreshBtn")).Click();
            Thread.Sleep(30000);
            for (int i = 0; i < browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows.Count; i++)
            {
                if ((browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].TableCells.Count > 1) &&
                    (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].Span(Find.ByClass("float-left")).Exists == true) &&
                    (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxPositionsPanel_Position_uxCurrent_Table")).TableRows[i].Span(Find.ByClass("float-left")).Text == symbol.ToUpper()))
                {
                    return true;
                }
            }
            return false;
        }
    }

    public enum Transaction
    {
        Buy,
        Sell,
        Short,
        Cover
    }

    public enum OrderType
    {
        Market,
        Limit,
        Stop,
        StopLimit,
        TrailingStopDollar,
        TrailingStopPercent
    }

    public enum OptionStrategy
    {
        CallPut,
        Butterfly,
        Calendar,
        Collar,
        Condor,
        Covered,
        Diagonal,
        IronButterfly,
        IronCondor,
        Ratio,
        Spread,
        Straddle,
        Strangle
    }

    public enum AdvancedType
    {
        OCO,

    }
}
