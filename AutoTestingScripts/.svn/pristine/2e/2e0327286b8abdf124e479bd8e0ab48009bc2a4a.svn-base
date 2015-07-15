using System;
using System.Text;
using System.Threading;
using WatiN.Core;

namespace Hermes.TestCases
{
    public class CommonFunction : TestClass
    {
        public void SignIn(string userName, string password, string answer)
        {
            if (browser.Link(Find.ByText("Sign Out")).Exists == true)
            {
                SignOut();
                browser.GoTo(targetHost);
                Thread.Sleep(2000);
            }

            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDefaultLoginForm_uxUserName")).WaitUntilExists();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDefaultLoginForm_uxUserName")).TypeText(userName);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDefaultLoginForm_uxPassword")).TypeText(password);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDefaultLoginForm_uxSignIn")).Click();
            Thread.Sleep(5000);

            if ((browser.Link(Find.ByText("Sign Out")).Exists == true) &&
                (browser.Span(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxMemberLoginStatus_uxMemberLoginView_uxLoginName")).Text.ToLower() == userName.ToLower()))
            {
                return;
            }
            else
            {
                if (browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxAnswer")).Exists == true)
                {
                    browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxAnswer")).TypeText(answer);
                    browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNext")).Click();
                }
            }
            Thread.Sleep(5000);
        }

        public void SignOut()
        {
            //ctl00_ctl00_uxPreContent_uxTopNavigation_uxMemberLoginStatus_uxMemberLoginView_LoginStatus1
            if (browser.Link(Find.ByText("Sign Out")).Exists == true)
            {
                browser.Link(Find.ByText("Sign Out")).Click();
                Thread.Sleep(2000);
            }
        }

        public void TradeStocks(Transaction tran, string smb, int qty, OrderType orderType)
        {
            browser.SelectList(Find.ById("EquityTicket_Transaction")).Option(Find.ByText(tran.ToString())).Select();
            browser.TextField(Find.ById("EquityTicket_uxSymbol")).TypeText(smb);
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
            browser.CheckBox(Find.ById("EquityTicket_uxAON")).Checked = false;
            browser.Button(Find.ById("EquitTicket_PreviewOrder")).Click();
            Thread.Sleep(2000);
            browser.Span(Find.ById("OrderDetail_EstmCost")).WaitUntilExists();
            browser.Div(Find.ById("OrderPopup_Preview")).Button(Find.ById("OrderPreview_BtnSumbitOrder")).Click();
            Thread.Sleep(2000);
            browser.Div(Find.ById("OrderPopup_Confirmation")).Button(Find.ById("OrderConfirmation_BtnOrderStatus")).Click();
            Thread.Sleep(60000);
        }

        public void TradeOptions(string expiration, int action, int qty, OrderType orderType)
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

            browser.Span(Find.ById("OrderDetail_EstmCost")).WaitUntilExists();
            browser.Div(Find.ById("OrderPopup_Preview")).Button(Find.ById("OrderPreview_BtnSumbitOrder")).Click();
            Thread.Sleep(2000);
            browser.Div(Find.ById("OrderPopup_Confirmation")).Button(Find.ById("OrderConfirmation_BtnOrderStatus")).Click();
            Thread.Sleep(60000);
        }

        public string GetStrategyControl(OptionStrategy strategy)
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
            IronButterfly,
            IronCondor,
            Ratio,
            Spread,
            Straddle,
            Strangle
        }
    }
}
