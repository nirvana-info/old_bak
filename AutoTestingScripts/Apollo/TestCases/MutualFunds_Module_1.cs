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
    public class MutualFunds_Module_1 : TestBase
    {
        [Test]
        public void T01_MutualFunds_Buy()
        {
            SignIn(UN1, PWD1, SA1);
            browser.Span(Find.ById(CommonFunction.ACCOUNT_LIST)).WaitUntilExists();
            browser.Div(Find.ById(CommonFunction.TOP_TAB)).Span(Find.ByText("Mutual Funds")).Click();
            browser.Button(Find.ById("MutualFundTicket_PreviewOrder")).WaitUntilExists();

            browser.TextField(Find.ById("MutualFundTicket_uxSymbol")).TypeText(symbol_MF);
            browser.TextField(Find.ById("MutualFundTicket_uxDollarAmount")).TypeText("100");
            browser.Button(Find.ById("MutualFundTicket_PreviewOrder")).Click();
            browser.Span(Find.ById("OrderDetail_EstmCost")).WaitUntilExists();
            browser.Div(Find.ById("OrderPopup_Preview")).Button(Find.ById("OrderPreview_BtnSumbitOrder")).Click();
            Thread.Sleep(2000);
            browser.Div(Find.ById("OrderPopup_Confirmation")).Button(Find.ById("OrderConfirmation_BtnOrderStatus")).Click();
            Thread.Sleep(60000);

            Assert.IsTrue(CommonFunction.CheckOrderStatusPanel(browser, symbol_MF));
        }
    }
}
