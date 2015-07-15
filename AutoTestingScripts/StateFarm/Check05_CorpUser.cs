using System;
using WatiN.Core;
using NUnit.Framework;
using System.Text;
using System.Globalization;
using System.Threading;

namespace PPlusSystemTesting
{

    [TestFixture]

    //public class Check05_CorpUser
    public class Check05_CorpUser : TestBase
    {


        [Test]
        public void Check05_01_CorpLogin()
        {
            ie.GoTo(url);
            ie.TextField(Find.ByName("ctl00$MainContentHolder$txtUsername")).TypeText("admin");
            ie.TextField(Find.ByName("ctl00$MainContentHolder$txtPassword")).TypeText("12345");
            ie.Image(Find.ByName("ctl00$FooterButtonNext")).Click();

            ie.Image(Find.ByAlt("Settings")).Click();
            ie.Link(Find.ByText("Login as Another User")).Click();
            ie.TextField(Find.ByName("ctl00$MainContentHolder$txtAgentId")).TypeText("l8gg");
            ie.Button(Find.ByName("ctl00$FooterButtonNext")).Click();
            //Assert.IsTrue(ie.ContainsText("Welcome to PAVe, Terri Hoss"));

        }



        [Test]
        public void Check05_02_SearchOrdersReport()
        {
            ie.Image(Find.ByAlt("Reports")).WaitUntilExists(120);
            ie.Image(Find.ByAlt("Reports")).ClickNoWait();
            ie.Link(Find.ById("ctl00_MainContentHolder_LinkButton63")).WaitUntilExists(120);
            ie.Link(Find.ById("ctl00_MainContentHolder_LinkButton63")).ClickNoWait();

            Thread.Sleep(3000);

            ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ByName("ctl00_MainContentHolder_tbDateFrom_input")).WaitUntilExists(120);
            ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ByName("ctl00_MainContentHolder_tbDateFrom_input")).TypeText(dt);
            ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ByName("ctl00_MainContentHolder_tbDateTo_input")).TypeText(dt);
            ie.Frame(Find.ById("MainContentFrame")).SelectList(Find.ById("ctl00_MainContentHolder_ddlStatus")).Option("Active").Select();
            ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ById("ctl00xMainContentHolderxorgDDLxwcAgent_input")).TypeText(AgentID);
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$FooterButtonNext")).Click();
            String Ordername = "Test" + Date;
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ById("ctl00_MainContentHolder_btnPDF")).WaitUntilExists(120);
            Assert.IsTrue(ie.Frame(Find.ById("MainContentFrame")).Image(Find.ById("ctl00_MainContentHolder_btnPDF")).Exists);

        }


        [Test]
        public void Check05_03_SearchOrdersByOrderIDReport()
        {
            String OrderNumber = ie.Frame(Find.ById("MainContentFrame")).Link(Find.ById("ctl00_MainContentHolder_gvOrder_Agent_ctl02_HyperLink1")).Text;
            ie.Image(Find.ByAlt("Reports")).ClickNoWait();
            ie.Link(Find.ById("ctl00_MainContentHolder_LinkButton73")).WaitUntilExists(120);
            ie.Link(Find.ById("ctl00_MainContentHolder_LinkButton73")).ClickNoWait();
            Thread.Sleep(3000);
            ie.Frame(Find.ById("MainContentFrame")).Span(Find.ByText("Search Orders by Order ID")).WaitUntilExists(60);
            ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ByName("ctl00$MainContentHolder$tbOrder")).TypeText(OrderNumber);
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$FooterButtonNext")).Click();
            ie.Frame(Find.ById("MainContentFrame")).Span(Find.ByText("Search Orders > Order History")).WaitUntilExists(60);
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ById("ctl00_MainContentHolder_btnPDF")).WaitUntilExists(120);
            Assert.IsTrue(ie.Frame(Find.ById("MainContentFrame")).Image(Find.ById("ctl00_MainContentHolder_btnPDF")).Exists);
        }




        [Test]
        public void Check05_04_OrderSummaryReport()
        {

            ie.Image(Find.ByAlt("Reports")).Click();
            ie.Link(Find.ById("ctl00_MainContentHolder_LinkButton68")).WaitUntilExists(120);
            ie.Link(Find.ById("ctl00_MainContentHolder_LinkButton68")).Click();
            Thread.Sleep(3000);
            string TotalOrder = ie.Frame(Find.ById("MainContentFrame")).Span(Find.ById("ctl00_MainContentHolder_lbltotalOrder")).Text;
            ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ByName("ctl00_MainContentHolder_WebOrderSummaryFrom_input")).TypeText(dt);
            ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ByName("ctl00_MainContentHolder_WebOrderSummaryTo_input")).TypeText(dt);
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$MainContentHolder$ibtnOrderSummary")).Click();

            for (int i = 1; ie.Frame(Find.ById("MainContentFrame")).Span(Find.ById("ctl00_MainContentHolder_lbltotalOrder")).Text == TotalOrder; )
            {
                i++;
            }
            ie.Frame(Find.ById("MainContentFrame")).Link(Find.ById("ctl00_MainContentHolder_GVOrderSummary_ctl02_lnkBtnOrderSummary")).Click();
            ie.Frame(Find.ById("MainContentFrame")).Span(Find.ByText("State/Province")).WaitUntilExists(60);
            ie.Frame(Find.ById("MainContentFrame")).Link(Find.ById("ctl00_MainContentHolder_GVOrderSummary_ctl02_lnkBtnOrderSummary")).Click();
            ie.Frame(Find.ById("MainContentFrame")).Span(Find.ByText("AFO")).WaitUntilExists(60);
            ie.Frame(Find.ById("MainContentFrame")).Link(Find.ById("ctl00_MainContentHolder_GVOrderSummary_ctl02_lnkBtnOrderSummary")).Click();

            //Assert.AreEqual("Abercrombie III, John C (031195)", ie.Span(Find.ById("ctl00_MainContentHolder_GVOrderSummary_ctl02_lblBtnOrderSummary")).Text);
            Assert.AreEqual("Christy, David (4791FD)", ie.Frame(Find.ById("MainContentFrame")).Span(Find.ById("ctl00_MainContentHolder_GVOrderSummary_ctl02_lblBtnOrderSummary")).Text);
        }

        [Test]
        public void Check05_05_GeographicalMailReport()
        {
            ie.Image(Find.ByAlt("Reports")).Click();
            ie.Link(Find.ById("ctl00_MainContentHolder_LinkButton69")).WaitUntilExists(120);
            ie.Link(Find.ById("ctl00_MainContentHolder_LinkButton69")).Click();
            Thread.Sleep(3000);
            ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ByName("ctl00$MainContentHolder$tbAgentID")).TypeText(AgentID);
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$FooterButtonNext")).Click();
            //ie.Image(Find.ByName("ctl00$MainContentHolder$btnPDF")).WaitUntilExists(60);
            Assert.IsTrue(ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$MainContentHolder$btnPDF")).Exists);
        }

        [Test]
        public void Check05_06_GeographicalOrderHistoryReport()
        {
            ie.Image(Find.ByAlt("Reports")).Click();
            ie.Link(Find.ById("ctl00_MainContentHolder_LinkButton70")).WaitUntilExists(120);
            ie.Link(Find.ById("ctl00_MainContentHolder_LinkButton70")).Click();
            Thread.Sleep(3000);
            ie.Frame(Find.ById("MainContentFrame")).SelectList(Find.ById("ctl00_MainContentHolder_ddlState")).Option("Washington").Select();
            ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ByName("ctl00$MainContentHolder$tbAgentID")).TypeText(AgentID);
            ie.Frame(Find.ById("MainContentFrame")).RadioButton(Find.ById("ctl00_MainContentHolder_rblTiming_1")).Checked = true;
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$FooterButtonNext")).Click();

            Assert.IsTrue(ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$MainContentHolder$btnPDF")).Exists);
        }

        [Test]
        public void Check05_07_MailReport()
        {
            ie.Image(Find.ByAlt("Reports")).Click();
            ie.Link(Find.ById("ctl00_MainContentHolder_LinkButton71")).WaitUntilExists(120);
            ie.Link(Find.ById("ctl00_MainContentHolder_LinkButton71")).Click();
            Thread.Sleep(1000);
            ie.Frame(Find.ById("MainContentFrame")).SelectList(Find.ById("ctl00_MainContentHolder_orgDDL_ddlState")).Option("Washington").Select();
            //ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ById("ctl00xMainContentHolderxorgDDLxwcAgent_input")).FireEventNoWait("onfocus");
            //ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ById("ctl00xMainContentHolderxorgDDLxwcAgent_input")).TypeText(AgentID);
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ById("ctl00_FooterButtonNext")).ClickNoWait();
            ie.Frame(Find.ById("MainContentFrame")).Span(Find.ByText("AFO")).WaitUntilExists(60);



            //ie.Frame(Find.ById("MainContentFrame")).Image(Find.ById("ctl00_MainContentHolder_btnSearch")).ClickNoWait();
            ie.Frame(Find.ById("MainContentFrame")).Link(Find.ById("ctl00_MainContentHolder_gvMode1_ctl02_Label1")).ClickNoWait();

            Assert.IsTrue(ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$MainContentHolder$btnPDF")).Exists);
        }


        [Test]
        public void Check05_08_SubscriptionReport()
        {
            ie.Image(Find.ByAlt("Reports")).Click();
            ie.Link(Find.ById("ctl00_MainContentHolder_LinkButton72")).WaitUntilExists(120);
            ie.Link(Find.ById("ctl00_MainContentHolder_LinkButton72")).Click();
            Thread.Sleep(3000);
            ie.Frame(Find.ById("MainContentFrame")).CheckBox(Find.ByName("ctl00$MainContentHolder$cblActive")).Checked = true;
            ie.Frame(Find.ById("MainContentFrame")).CheckBox(Find.ByName("ctl00$MainContentHolder$cblPending")).Checked = true;
            ie.Frame(Find.ById("MainContentFrame")).CheckBox(Find.ByName("ctl00$MainContentHolder$cblClosed")).Checked = true;
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$FooterButtonNext")).Click();
            ie.Frame(Find.ById("MainContentFrame")).Span(Find.ByText("Zone")).WaitUntilExists(60);
            ie.Frame(Find.ById("MainContentFrame")).SelectList(Find.ById("ctl00_MainContentHolder_orgDDL_ddlState")).Option("Washington").Select();
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$MainContentHolder$btnSearch")).Click();
            ie.Frame(Find.ById("MainContentFrame")).Span(Find.ByText("AFO")).WaitUntilExists(60);


            ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ById("ctl00xMainContentHolderxorgDDLxwcAgent_input")).TypeText(AgentID);

            ie.Frame(Find.ById("MainContentFrame")).RadioButton(Find.ById("ctl00_MainContentHolder_rblTiming_1")).Click();

            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$MainContentHolder$btnSearch")).Click();
            ie.Frame(Find.ById("MainContentFrame")).Span(Find.ByText("Agent")).WaitUntilRemoved(60);
            Assert.IsTrue(ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$MainContentHolder$btnPDF")).Exists);

        }




        [Test]
        public void Check05_09_AgentOrderHistoryReport()
        {
            ie.Image(Find.ByAlt("Reports")).ClickNoWait();
            ie.Link(Find.ById("ctl00_MainContentHolder_LinkButton74")).WaitUntilExists(120);
            ie.Link(Find.ById("ctl00_MainContentHolder_LinkButton74")).ClickNoWait();
            Thread.Sleep(3000);
            ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ByName("ctl00$MainContentHolder$txtAgent")).Value = AgentID;
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$MainContentHolder$imgBtnSearch")).Click();
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$MainContentHolder$btnPDF")).WaitUntilExists(60);
            //ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ById("ctl00_MainContentHolder_tbDateFrom_input")).TypeText(dt);
            //ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$MainContentHolder$imgBtnSearch")).Click();
            Assert.IsTrue(ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$MainContentHolder$btnPDF")).Exists);

        }

        [Test]
        public void Check05_10_TopOrderingAgentsReport()
        {
            ie.Image(Find.ByAlt("Reports")).ClickNoWait();
            ie.Link(Find.ById("ctl00_MainContentHolder_LinkButton75")).WaitUntilExists(120);
            ie.Link(Find.ById("ctl00_MainContentHolder_LinkButton75")).ClickNoWait();
            Thread.Sleep(3000);
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$MainContentHolder$imgBtnSearch")).Click();
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$MainContentHolder$btnPDF")).WaitUntilExists(360);
            Assert.IsTrue(ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$MainContentHolder$btnPDF")).Exists);
        }

        [Test]
        public void Check05_11_MailProductionReport()
        {
            ie.Image(Find.ByAlt("Reports")).ClickNoWait();
            ie.Link(Find.ById("ctl00_MainContentHolder_LinkButton76")).WaitUntilExists(120);
            ie.Link(Find.ById("ctl00_MainContentHolder_LinkButton76")).ClickNoWait();
            Thread.Sleep(3000);
            ie.Frame(Find.ById("MainContentFrame")).CheckBox(Find.ByName("ctl00$MainContentHolder$cboxSum")).Checked = true;
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$MainContentHolder$imgBtnSearch")).Click();
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$MainContentHolder$btnPDF")).WaitUntilExists(60);
            Assert.IsTrue(ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$MainContentHolder$btnPDF")).Exists);
        }

        [Test]
        public void Check05_12_NonActivityFollowUpReport()
        {
            ie.Image(Find.ByAlt("Reports")).Click();
            ie.Link(Find.ById("ctl00_MainContentHolder_LinkButton79")).WaitUntilExists(120);
            ie.Link(Find.ById("ctl00_MainContentHolder_LinkButton79")).Click();
            Thread.Sleep(3000);
            ie.Frame(Find.ById("MainContentFrame")).SelectList(Find.ById("ctl00_MainContentHolder_orgDDL_ddlState")).Option("Washington").Select();
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ById("ctl00_FooterButtonNext")).Click();
            ie.Frame(Find.ById("MainContentFrame")).Link(Find.ByText("AFO")).WaitUntilExists(240);
            Assert.IsTrue(ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$MainContentHolder$btnPDF")).Exists);

        }


        [Test]
        public void Check05_13_ParticipationReport()
        {
            ie.Image(Find.ByAlt("Reports")).Click();
            ie.Link(Find.ById("ctl00_MainContentHolder_LinkButton80")).WaitUntilExists(120);
            ie.Link(Find.ById("ctl00_MainContentHolder_LinkButton80")).Click();
            Thread.Sleep(3000);

            ie.Frame(Find.ById("MainContentFrame")).SelectList(Find.ById("ctl00_MainContentHolder_orgDDL_ddlState")).Option("Washington").Select();
            ie.Frame(Find.ById("MainContentFrame")).RadioButton(Find.ById("ctl00_MainContentHolder_rblTiming_1")).Checked = true;
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$FooterButtonNext")).Click();
            ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ById("ctl00xMainContentHolderxorgDDLxwcAgent_input")).WaitUntilExists(120);
            ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ById("ctl00xMainContentHolderxorgDDLxwcAgent_input")).TypeText(AgentID);
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$MainContentHolder$btnSearch")).ClickNoWait();
            ie.Frame(Find.ById("MainContentFrame")).Span(Find.ByText("Agent")).WaitUntilRemoved(120);
            Assert.IsTrue(ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$MainContentHolder$btnPDF")).Exists);
        }


        [Test]
        public void Check05_14_OwnedLeadsReport()
        {
            ie.Image(Find.ByAlt("Reports")).Click();
            ie.Link(Find.ById("ctl00_MainContentHolder_LinkButton82")).WaitUntilExists(120);
            ie.Link(Find.ById("ctl00_MainContentHolder_LinkButton82")).Click();
            Thread.Sleep(3000);
            ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ByName("ctl00$MainContentHolder$txtZipcode")).TypeText("85020");
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$MainContentHolder$searchZipcode")).Click();
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$MainContentHolder$btnPDF")).WaitUntilExists(120);
            Assert.IsTrue(ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$MainContentHolder$btnPDF")).Exists);
        }

        [Test]
        public void Check05_15_LeadLookupbyNameReport()
        {
            ie.Image(Find.ByAlt("Reports")).Click();
            ie.Link(Find.ById("ctl00_MainContentHolder_LinkButton84")).WaitUntilExists(120);
            ie.Link(Find.ById("ctl00_MainContentHolder_LinkButton84")).Click();
            Thread.Sleep(3000);
            ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ByName("ctl00$MainContentHolder$tbxSingleZip")).TypeText("85020");
            ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ByName("ctl00$MainContentHolder$tbxFirstName")).TypeText("c");
            ie.Frame(Find.ById("MainContentFrame")).RadioButton(Find.ById("ctl00_MainContentHolder_rblRequirement_2")).Checked = true;
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ById("ctl00_MainContentHolder_imgBtnSearch")).Click();
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$MainContentHolder$btnPDF")).WaitUntilExists(240);
            Assert.IsTrue(ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$MainContentHolder$btnPDF")).Exists);
        }

        [Test]
        public void Check05_16_SearchFundingsReport()
        {
            ie.Image(Find.ByAlt("Reports")).Click();
            ie.Link(Find.ById("ctl00_MainContentHolder_LinkButton64")).WaitUntilExists(120);
            ie.Link(Find.ById("ctl00_MainContentHolder_LinkButton64")).Click();
            Thread.Sleep(3000);
            ie.Frame(Find.ById("MainContentFrame")).SelectList(Find.ByName("ctl00$MainContentHolder$ddlZone")).Option("Great Western").Select();
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$FooterButtonNext")).Click();
            ie.Frame(Find.ById("MainContentFrame")).Span(Find.ByText("Search Fundings > Funding History")).WaitUntilExists(120);
            Assert.IsTrue(ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$MainContentHolder$btnPDF")).Exists);
        }

        [Test]
        public void Check05_17_SpendReport()
        {
            ie.Image(Find.ByAlt("Reports")).Click();
            ie.Link(Find.ById("ctl00_MainContentHolder_LinkButton65")).WaitUntilExists(120);
            ie.Link(Find.ById("ctl00_MainContentHolder_LinkButton65")).Click();
            Thread.Sleep(3000);
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$FooterButtonNext")).Click();
            ie.Frame(Find.ById("MainContentFrame")).Span(Find.ByText("Zone")).WaitUntilExists(240);
            Assert.IsTrue(ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$MainContentHolder$btnPDF")).Exists);
        }

        [Test]
        public void Check05_18_ZoneBundleApproval()
        {
            ie.Image(Find.ByAlt("SMPs")).WaitUntilExists(120);
            ie.Image(Find.ByAlt("SMPs")).ClickNoWait();
            ie.Link(Find.ByText("Zone SMP Approval")).WaitUntilExists(120);
            ie.Link(Find.ByText("Zone SMP Approval")).ClickNoWait();
            ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ByName("ctl00$MainContentHolder$txtIDName")).WaitUntilExists(120);
            ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ByName("ctl00$MainContentHolder$txtIDName")).TypeText("ZoneBundle" + Date);
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$MainContentHolder$btnGo")).ClickNoWait();

            ie.Frame(Find.ById("MainContentFrame")).Link(Find.ById("ctl00_MainContentHolder_gvBundles_ctl02_lbEdit")).Click();
            ie.Frame(Find.ById("MainContentFrame")).Span(Find.ByText("Edit SMP")).WaitUntilExists(60);

            WatiN.Core.DialogHandlers.ConfirmDialogHandler bh = new WatiN.Core.DialogHandlers.ConfirmDialogHandler();
            ie.AddDialogHandler(bh);
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$FooterButtonApprove")).ClickNoWait();
            bh.WaitUntilExists(60);
            bh.OKButton.Click();
            ie.RemoveDialogHandler(bh);

            ie.Frame(Find.ById("MainContentFrame")).Span(Find.ByText("Zone SMP Approval")).WaitUntilExists(60);
            Assert.IsTrue(ie.Frame(Find.ById("MainContentFrame")).Span(Find.ByText("Active")).Exists);
        }

        [Test]
        public void Check05_19_DeactiveSubscription()
        {
            ie.GoTo(url + "/Subscription/subscription_management.aspx?start=1");

            ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ByName("ctl00$MainContentHolder$txtIDName")).TypeText("Subtest" + Date);

            ie.Frame(Find.ById("MainContentFrame")).SelectList(Find.ByName("ctl00$MainContentHolder$ddlStatus")).Option("Active").Select(); // modify 2008/5/14

            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$MainContentHolder$btnGo")).Click();

            ie.Frame(Find.ById("MainContentFrame")).Link(Find.ById("ctl00_MainContentHolder_gvSubscription_ctl02_lbEdit")).Click();

            ie.Frame(Find.ById("MainContentFrame")).Span(Find.ByText("Subscription Detail")).WaitUntilExists(60);

            WatiN.Core.DialogHandlers.ConfirmDialogHandler dah = new WatiN.Core.DialogHandlers.ConfirmDialogHandler();
            ie.AddDialogHandler(dah);

            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$FooterButtonDeactive")).ClickNoWait();
            dah.WaitUntilExists(3);
            dah.OKButton.Click();
            ie.RemoveDialogHandler(dah);
            ie.Frame(Find.ById("MainContentFrame")).Span(Find.ByText("Subscription")).WaitUntilExists(60);

            ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ByName("ctl00$MainContentHolder$txtIDName")).TypeText("Subtest" + Date);
            ie.Frame(Find.ById("MainContentFrame")).SelectList(Find.ByName("ctl00$MainContentHolder$ddlStatus")).Option("Active").Select();
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$MainContentHolder$btnGo")).Click();
            ie.Frame(Find.ById("MainContentFrame")).Link(Find.ById("ctl00_MainContentHolder_gvSubscription_ctl02_lbEdit")).Click();
            ie.Frame(Find.ById("MainContentFrame")).Span(Find.ByText("Subscription Detail")).WaitUntilExists(60);
            WatiN.Core.DialogHandlers.ConfirmDialogHandler dah1 = new WatiN.Core.DialogHandlers.ConfirmDialogHandler();
            ie.AddDialogHandler(dah1);
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$FooterButtonDeactive")).ClickNoWait();
            dah1.WaitUntilExists(3);
            dah1.OKButton.Click();
            ie.RemoveDialogHandler(dah1);
            ie.Frame(Find.ById("MainContentFrame")).Span(Find.ByText("Subscription")).WaitUntilExists(60);


            ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ByName("ctl00$MainContentHolder$txtIDName")).TypeText("Subtest" + Date);
            ie.Frame(Find.ById("MainContentFrame")).SelectList(Find.ByName("ctl00$MainContentHolder$drpStatus$ddlEnum")).Option("Active").Select();
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$MainContentHolder$btnGo")).Click();
            // ie.Span(Find.ByText("No subscription selected.")).WaitUntilExists(60);
            //Assert.IsTrue(ie.Span(Find.ByText("No subscription selected.")).Exists);


            ie.Frame(Find.ById("MainContentFrame")).Link(Find.ByText("ID")).WaitUntilRemoved(60);
            Assert.IsFalse(ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$MainContentHolder$btnPDF")).Exists);

        }


    }
}
