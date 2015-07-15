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
    public class MutualFunds_Module : CommonFunction
    {
        [Test]
        public void T01_MutualFunds_Buy()
        {
            SignIn(UN1, PWD1, SA1);
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxAccountShow")).WaitUntilExists();

            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerTop_uxRadTabTopNav")).Span(Find.ByText("Mutual Funds")).Click();
            browser.Button(Find.ById("MutualFundTicket_PreviewOrder")).WaitUntilExists();

            browser.TextField(Find.ById("MutualFundTicket_uxSymbol")).TypeText(symbol_MF);
            browser.TextField(Find.ById("MutualFundTicket_uxDollarAmount")).TypeText("100");
            browser.Button(Find.ById("MutualFundTicket_PreviewOrder")).Click();
            browser.Span(Find.ById("OrderDetail_EstmCost")).WaitUntilExists();
            browser.Div(Find.ById("OrderPopup_Preview")).Button(Find.ById("OrderPreview_BtnSumbitOrder")).Click();
            Thread.Sleep(2000);
            browser.Div(Find.ById("OrderPopup_Confirmation")).Button(Find.ById("OrderConfirmation_BtnOrderStatus")).Click();
            Thread.Sleep(60000);

            for (int i = 0; i < browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxOrdersPanel_OrdersPanel_uxOrderRepeater_Table")).TableRows.Count; i++)
            {
                if ((browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxOrdersPanel_OrdersPanel_uxOrderRepeater_Table")).TableRows[i].TableCells.Count > 1) &&
                    (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxOrdersPanel_OrdersPanel_uxOrderRepeater_Table")).TableRows[i].Span(Find.ByClass("float-left")).Exists == true) &&
                    (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMainContainerBottom_uxOrdersPanel_OrdersPanel_uxOrderRepeater_Table")).TableRows[i].Span(Find.ByClass("float-left")).Text == symbol_MF.ToUpper()))
                {
                    Assert.IsTrue(true);
                    return;
                }
            }

            Assert.IsTrue(false);
        }
    }
}
