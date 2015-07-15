using System;
using WatiN.Core;
using NUnit.Framework;
using System.Text;
using System.Globalization;
using System.Threading;

namespace PPlusSystemTesting
{
    [TestFixture]
    public class Check04_ZoneUser:TestBase
    {
        [Test]
        public void Check4_01_ZoneUserLogin()
        {
            ie.GoTo(url);
            ie.TextField(Find.ByName("ctl00$MainContentHolder$txtUsername")).TypeText("admin");
            ie.TextField(Find.ByName("ctl00$MainContentHolder$txtPassword")).TypeText("12345");
            ie.Image(Find.ByName("ctl00$FooterButtonNext")).Click();

            ie.Image(Find.ByAlt("Settings")).Click();
            ie.Link(Find.ByText("Login as Another User")).Click();
            ie.TextField(Find.ByName("ctl00$MainContentHolder$txtAgentId")).TypeText(ZoneID);
            ie.Button(Find.ByName("ctl00$FooterButtonNext")).Click();

        }
        //[Test]
        //public void Check4_02_AddZoneBundle()
        //{
        //    ie.Image(Find.ByAlt("SMPs")).WaitUntilExists(120);
        //    ie.Image(Find.ByAlt("SMPs")).ClickNoWait();
        //    ie.Link(Find.ByText("Zone SMP Management")).WaitUntilExists(120);
        //    ie.Link(Find.ByText("Zone SMP Management")).ClickNoWait();
        //    ie.Frame(Find.ById("MainContentFrame")).Image(Find.ById("ctl00_FooterButtonNew")).WaitUntilExists(120);
        //    ie.Frame(Find.ById("MainContentFrame")).Image(Find.ById("ctl00_FooterButtonNew")).ClickNoWait();

        //    ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ById("ctl00_MainContentHolder_txtBundleName")).WaitUntilExists(120);
        //    ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ById("ctl00_MainContentHolder_txtBundleName")).TypeText("ZoneBundle" + Date);

        //    ie.Frame(Find.ById("MainContentFrame")).CheckBox(Find.ById("ctl00_MainContentHolder_cblLS_0")).Checked = true;
        //    ie.Frame(Find.ById("MainContentFrame")).CheckBox(Find.ById("ctl00_MainContentHolder_cblLS_1")).Checked = true;
        //    ie.Frame(Find.ById("MainContentFrame")).CheckBox(Find.ById("ctl00_MainContentHolder_cblLS_2")).Checked = true;
        //    ie.Frame(Find.ById("MainContentFrame")).CheckBox(Find.ById("ctl00_MainContentHolder_cblLS_3")).Checked = true;


        //    ie.Frame(Find.ById("MainContentFrame")).CheckBox(Find.ById("ctl00_MainContentHolder_cblOT_0")).Checked = true;
        //    ie.Frame(Find.ById("MainContentFrame")).CheckBox(Find.ById("ctl00_MainContentHolder_cblOT_1")).Checked = true;
        //    ie.Frame(Find.ById("MainContentFrame")).CheckBox(Find.ById("ctl00_MainContentHolder_cblOT_2")).Checked = true;

        //    ie.Frame(Find.ById("MainContentFrame")).Image(Find.ById("ctl00_FooterButtonSave_Next")).ClickNoWait();

        //    ie.Frame(Find.ById("MainContentFrame")).Table(Find.ById("ctl00_MainContentHolder_tcBundle_tpMailers_gvBundleMailers")).Table(Find.ById("igtxtctl00_MainContentHolder_tcBundle_tpMailers_gvBundleMailers_ctl03_txtMailerID")).TableCell(Find.ById("ctl00_MainContentHolder_tcBundle_tpMailers_gvBundleMailers_ctl03_txtMailerID_b0")).MouseDown();
        //    ie.Frame(Find.ById("MainContentFrame")).RadioButton(Find.ByName("mailers")).Checked = true;

        //    ie.Frame(Find.ById("MainContentFrame")).Image(Find.ById("ctl00_MainContentHolder_btnSetMailer")).ClickNoWait();


        //    WatiN.Core.DialogHandlers.ConfirmDialogHandler xh = new WatiN.Core.DialogHandlers.ConfirmDialogHandler();
        //    ie.AddDialogHandler(xh);
        //    ie.Frame(Find.ById("MainContentFrame")).Image(Find.ById("ctl00_MainContentHolder_tcBundle_tpMailers_gvBundleMailers_ctl03_btnInsert")).ClickNoWait();
        //    xh.WaitUntilExists(3);
        //    xh.OKButton.Click();
        //    ie.RemoveDialogHandler(xh);

        //    WatiN.Core.DialogHandlers.ConfirmDialogHandler yh = new WatiN.Core.DialogHandlers.ConfirmDialogHandler();
        //    ie.AddDialogHandler(yh);
        //    ie.Frame(Find.ById("MainContentFrame")).Image(Find.ById("ctl00_FooterButtonSubmit")).ClickNoWait();
        //    yh.WaitUntilExists(3);
        //    yh.OKButton.Click();
        //    ie.RemoveDialogHandler(yh);
        //    ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ById("ctl00_MainContentHolder_txtIDName")).WaitUntilExists(120);

        //    Assert.IsTrue(ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ById("ctl00_MainContentHolder_txtIDName")).Exists);
        //}

        [Test]
        public void Check4_03_NewAgentOrder()
        {
            ie.Image(Find.ByAlt("Order Leads")).WaitUntilExists(120);
            ie.Image(Find.ByAlt("Order Leads")).ClickNoWait();
            ie.Link(Find.ByText("New Agent Order")).WaitUntilExists(120);
            ie.Link(Find.ByText("New Agent Order")).ClickNoWait();
            ie.Frame(Find.ById("MainContentFrame")).Span(Find.ByText("Select Agent")).WaitUntilExists(120);
            ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ById("ctl00xMainContentHolderxwcAgentxwcAgent_input")).TypeText("613148");
            
            Thread.Sleep(5000);
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ById("ctl00_MainContentHolder_btnGo")).ClickNoWait();
            Thread.Sleep(3000);
            ie.Frame(Find.ById("MainContentFrame")).RadioButton(Find.ById("rbAgent")).Checked = true;
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$FooterButtonNewOrder")).Click();

            ie.Frame(Find.ById("MainContentFrame")).Span(Find.ByText("Select Geography")).WaitUntilExists(120);
            ie.Frame(Find.ById("MainContentFrame")).SelectList(Find.ById("ctl00_MainContentHolder_listGeographyType")).Option(Find.ByValue("4")).Select();
            ie.Frame(Find.ById("MainContentFrame")).Button(Find.ByName("ctl00$FooterButtonNext")).Click();
            ie.Frame(Find.ById("MainContentFrame")).Span(Find.ByText("Select Target")).WaitUntilExists(120);


            ie.Frame(Find.ById("MainContentFrame")).RadioButton(Find.ById("ctl00_MainContentHolder_tabLead__ctl0_gvLeadTypes_ctl03_rdoSelected")).Checked = true;

            ie.Frame(Find.ById("MainContentFrame")).Button(Find.ByName("ctl00$FooterButtonNext")).ClickNoWait();

            ie.Frame(Find.ById("MainContentFrame")).Span(Find.ByText("Available List Count")).WaitUntilExists(120);


            ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ById("ctl00_MainContentHolder_gvBreakDown_ctl11_txtDetailCount")).TypeText("1");
            string TotalCount;
            for (int i = 1; i < 1; )
            {
                TotalCount = ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ById("ctl00_MainContentHolder_txtDesiredCount")).Text;
                if (TotalCount == "1")
                {
                    i = 0;
                }
            }


            ie.Frame(Find.ById("MainContentFrame")).Button(Find.ByName("ctl00$FooterButtonNext")).Click();

            ie.Frame(Find.ById("MainContentFrame")).TableCell(Find.ByText("Corp SMP")).WaitUntilExists(120);
            ie.Frame(Find.ById("MainContentFrame")).TableCell(Find.ByText("Corp SMP")).ClickNoWait();

            ie.Frame(Find.ById("MainContentFrame")).RadioButton(Find.ById("ctl00_MainContentHolder_tcMailerOrBundle__ctl1_gvBundle_Corp_ctl02_rdoSelected_b")).WaitUntilExists(120);
            ie.Frame(Find.ById("MainContentFrame")).RadioButton(Find.ById("ctl00_MainContentHolder_tcMailerOrBundle__ctl1_gvBundle_Corp_ctl02_rdoSelected_b")).FireEventNoWait("onclick");
            ie.Frame(Find.ById("MainContentFrame")).RadioButton(Find.ById("ctl00_MainContentHolder_tcMailerOrBundle__ctl1_gvBundle_Corp_ctl02_rdoSelected_b")).Checked = true;
            Thread.Sleep(3000);

            ie.Frame(Find.ById("MainContentFrame")).Button(Find.ByName("ctl00$FooterButtonNext")).Click();
            ie.Frame(Find.ById("MainContentFrame")).Span(Find.ByText("Subscription Summary")).WaitUntilExists(120);

            ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ById("ctl00_MainContentHolder_txtName")).TypeText("sub" + Date);
            ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ById("ctl00_MainContentHolder_wdcDate1_input")).TypeText(dt);
            ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ById("ctl00_MainContentHolder_wdcDate2_input")).TypeText("12/31/2009");

            ie.Frame(Find.ById("MainContentFrame")).Button(Find.ByName("ctl00$FooterButtonNext")).Click();
            ie.WaitForComplete();

            Assert.IsTrue(ie.Frame(Find.ById("MainContentFrame")).ContainsText("sub" + Date));

         
        }

        [Test]
        public void Check4_03_NewSubscription()
        {

        }
    }
}
