/*
using NUnit.Framework;
using WatiN.Core;
using System.Text.RegularExpressions;
using System;
using System.Threading;*/

using System;
using WatiN.Core;
using NUnit.Framework;
using System.Text;
using System.Globalization;


namespace SalesLantern
{

    [TestFixture]

    public class Check02_View_MyLeads : TestBase
    {
       /* String URL = "http://192.168.0.20:9000";
        String Date = DateTime.Today.ToShortDateString();


        [Test]

        public void Check01_01_dLogin()
        {
            ie.GoTo(URL);
            ie.Image(Find.ByName("imgGetStarted")).Click();
            ie.Link(Find.ById("ctl00_lbLogin")).WaitUntilExists(120);
            ie.Link(Find.ById("ctl00_lbLogin")).Click();
            ie.Image(Find.ById("myImg")).WaitUntilExists(120);
            ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$tbEmail")).TypeText("christie.duan@nirvana-info.com");
            ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$tbPwd")).TypeText("123456");
            ie.Button(Find.ByName("ctl00$ContentPlaceHolder1$btOk")).Click();
            Assert.IsTrue(ie.ContainsText("Welcome to CRMExpress"));
        }

        [Test]

        public void Check01_02_Check_EditLeads()
        {

            ie.GoTo(URL + "/LM/LeadsSummary.aspx?type=MENU");
            ie.CheckBox(Find.ById("ctl00_ContentPlaceHolder1_DGMyLeads_ctl02_CheckBox1")).Checked = true;
            ie.Link(Find.ById("ctl00_ContentPlaceHolder1_lbtEdit")).Click();



            /*ie.TextField(Find.ById("UltraWebTab1__ctl0_txtLeadNote")).TypeText("Modify @"+Date);
            ie.Link(Find.ById("UltraWebTab1__ctl0_lbtSave")).Click();

            ie.Span(Find.ById("ctl00_ContentPlaceHolder1_lbWait")).WaitUntilRemoved(120);
            

        }    

        [Test]

        public void CheckFilter()
        {

            ie.GoTo(URL + "/LM/LeadsSummary.aspx?type=MENU");
            ie.Link(Find.ById("ctl00_ContentPlaceHolder1_lbtFilter")).Click();
            


         //   ie.Span(Find.ById("ctl00_ContentPlaceHolder1_lbWait")).WaitUntilRemoved(120);
        
        
        }    */


        String Date = DateTime.Today.ToShortDateString();
        String URL = "http://192.168.0.20/trunk";
        //String URL = "http://192.168.0.20/branch";
        String dt = DateTime.Today.ToString("d", DateTimeFormatInfo.InvariantInfo);




        [Test]
        public void Check3_AddSubscription_38()
        {
            ie.GoTo(URL + "/PAVELogin.aspx");
            //ie.WaitForComplete();
            ie.Span(Find.ByText("PAVe Login")).WaitUntilExists(120);
            ie.TextField(Find.ByName("ctl00$MainContentHolder$txtUsername")).TypeText("admin");
            ie.TextField(Find.ByName("ctl00$MainContentHolder$txtPassword")).TypeText("12345");
            ie.Image(Find.ByName("ctl00$FooterButtonNext")).Click();

            ie.GoTo(URL + "/Corp/login_as.aspx");
            ie.TextField(Find.ByName("ctl00$MainContentHolder$txtAgentId")).TypeText("153621");
            ie.Button(Find.ByName("ctl00$FooterButtonNext")).Click();

            ie.GoTo(URL + "/Subscription/subscription_management.aspx");
            ie.Image(Find.ByName("ctl00$FooterButtonNew")).Click();
            ie.SelectList(Find.ByName("ctl00$MainContentHolder$listGeographyType")).Option("Select ZIP Codes").Select();

            ie.Image(Find.ById("ctl00_FooterButtonNext")).Click();
            ie.Span(Find.ByText("Enter ZIP codes")).WaitUntilExists(120);


            ie.TextField(Find.ById("ctl00_MainContentHolder_tbZip")).TypeText("51645 ");


            ie.Image(Find.ById("ctl00_FooterButtonNext")).Click();

            ie.Span(Find.ByText("Select Target")).WaitUntilExists(120);

            ie.RadioButton(Find.ByName("ctl00$MainContentHolder$tabLead$_ctl0$gvLeadTypes$ctl03$leadTypes")).Click();

            ie.Image(Find.ById("ctl00_FooterButtonNext")).Click();
            //ie.WaitForComplete();
            //ie.Span(Find.ByText("Getting Count")).WaitUntilExists(120);
            //ie.WaitForComplete();
            ie.Span(Find.ByText("Available List Count")).WaitUntilExists(120);

            ie.TextField(Find.ByName("ctl00$MainContentHolder$gvBreakDown$ctl02$txtDetailCount")).TypeText("300");

            ie.Image(Find.ById("ctl00_FooterButtonNext")).Click();
            ie.Span(Find.ByText("Select Mailer/Bundle")).WaitUntilExists(120);

            ie.TableCell(Find.ByText("Corp Bundle")).Click();
            ie.RadioButton(Find.ByName("ctl00$MainContentHolder$tcMailerOrBundle$_ctl1$gvBundle_Corp$ctl05$mailers")).Checked = true;
            ie.Image(Find.ByName("ctl00$FooterButtonNext")).Click();

            ie.Span(Find.ByText("Subscription Summary")).WaitUntilExists(120);


            ie.TextField(Find.ByName("ctl00$MainContentHolder$txtName")).TypeText("Heartland" + "SubtestL2_" + "38");
            ie.TextField(Find.ByName("ctl00_MainContentHolder_wdcDate2_input")).TypeText("12/31/2008");
            ie.Image(Find.ById("ctl00_FooterButtonNext")).Click();
            ie.TextField(Find.ByName("ctl00$MainContentHolder$txtIDName")).TypeText("Heartland" + "SubtestL2_" + "38");
            ie.Image(Find.ByName("ctl00$MainContentHolder$btnGo")).Click();
            Assert.IsTrue(ie.Image(Find.ById("ctl00_MainContentHolder_btnPDF")).Exists);


        }


        [Test]
        public void Check3_AddSubscription_39()
        {

            ie.GoTo(URL + "/Subscription/subscription_management.aspx");
            ie.Image(Find.ByName("ctl00$FooterButtonNew")).Click();
            ie.SelectList(Find.ByName("ctl00$MainContentHolder$listGeographyType")).Option("Select ZIP Codes").Select();

            ie.Image(Find.ById("ctl00_FooterButtonNext")).Click();
            ie.Span(Find.ByText("Enter ZIP codes")).WaitUntilExists(120);


            ie.TextField(Find.ById("ctl00_MainContentHolder_tbZip")).TypeText("50583 ");


            ie.Image(Find.ById("ctl00_FooterButtonNext")).Click();

            ie.Span(Find.ByText("Select Target")).WaitUntilExists(120);

            ie.RadioButton(Find.ByName("ctl00$MainContentHolder$tabLead$_ctl0$gvLeadTypes$ctl03$leadTypes")).Click();

            ie.Image(Find.ById("ctl00_FooterButtonNext")).Click();
            //ie.WaitForComplete();
            //ie.Span(Find.ByText("Getting Count")).WaitUntilExists(120);
            //ie.WaitForComplete();
            ie.Span(Find.ByText("Available List Count")).WaitUntilExists(120);

            ie.TextField(Find.ByName("ctl00$MainContentHolder$gvBreakDown$ctl02$txtDetailCount")).TypeText("300");

            ie.Image(Find.ById("ctl00_FooterButtonNext")).Click();
            ie.Span(Find.ByText("Select Mailer/Bundle")).WaitUntilExists(120);

            ie.TableCell(Find.ByText("Corp Bundle")).Click();
            ie.RadioButton(Find.ByName("ctl00$MainContentHolder$tcMailerOrBundle$_ctl1$gvBundle_Corp$ctl05$mailers")).Checked = true;
            ie.Image(Find.ByName("ctl00$FooterButtonNext")).Click();

            ie.Span(Find.ByText("Subscription Summary")).WaitUntilExists(120);


            ie.TextField(Find.ByName("ctl00$MainContentHolder$txtName")).TypeText("Heartland" + "SubtestL2_" + "39");
            ie.TextField(Find.ByName("ctl00_MainContentHolder_wdcDate2_input")).TypeText("12/31/2008");
            ie.Image(Find.ById("ctl00_FooterButtonNext")).Click();
            ie.TextField(Find.ByName("ctl00$MainContentHolder$txtIDName")).TypeText("Heartland" + "SubtestL2_" + "39");
            ie.Image(Find.ByName("ctl00$MainContentHolder$btnGo")).Click();
            Assert.IsTrue(ie.Image(Find.ById("ctl00_MainContentHolder_btnPDF")).Exists);


        }

        [Test]
        public void Check3_AddSubscription_40()
        {

            ie.GoTo(URL + "/Subscription/subscription_management.aspx");
            ie.Image(Find.ByName("ctl00$FooterButtonNew")).Click();
            ie.SelectList(Find.ByName("ctl00$MainContentHolder$listGeographyType")).Option("Select ZIP Codes").Select();

            ie.Image(Find.ById("ctl00_FooterButtonNext")).Click();
            ie.Span(Find.ByText("Enter ZIP codes")).WaitUntilExists(120);


            ie.TextField(Find.ById("ctl00_MainContentHolder_tbZip")).TypeText("50309");


            ie.Image(Find.ById("ctl00_FooterButtonNext")).Click();

            ie.Span(Find.ByText("Select Target")).WaitUntilExists(120);

            ie.RadioButton(Find.ByName("ctl00$MainContentHolder$tabLead$_ctl0$gvLeadTypes$ctl03$leadTypes")).Click();

            ie.Image(Find.ById("ctl00_FooterButtonNext")).Click();
            //ie.WaitForComplete();
            //ie.Span(Find.ByText("Getting Count")).WaitUntilExists(120);
            //ie.WaitForComplete();
            ie.Span(Find.ByText("Available List Count")).WaitUntilExists(120);

            ie.TextField(Find.ByName("ctl00$MainContentHolder$gvBreakDown$ctl02$txtDetailCount")).TypeText("300");

            ie.Image(Find.ById("ctl00_FooterButtonNext")).Click();
            ie.Span(Find.ByText("Select Mailer/Bundle")).WaitUntilExists(120);

            ie.TableCell(Find.ByText("Corp Bundle")).Click();
            ie.RadioButton(Find.ByName("ctl00$MainContentHolder$tcMailerOrBundle$_ctl1$gvBundle_Corp$ctl05$mailers")).Checked = true;
            ie.Image(Find.ByName("ctl00$FooterButtonNext")).Click();

            ie.Span(Find.ByText("Subscription Summary")).WaitUntilExists(120);


            ie.TextField(Find.ByName("ctl00$MainContentHolder$txtName")).TypeText("Heartland" + "SubtestL2_" + "40");
            ie.TextField(Find.ByName("ctl00_MainContentHolder_wdcDate2_input")).TypeText("12/31/2008");
            ie.Image(Find.ById("ctl00_FooterButtonNext")).Click();
            ie.TextField(Find.ByName("ctl00$MainContentHolder$txtIDName")).TypeText("Heartland" + "SubtestL2_" + "40");
            ie.Image(Find.ByName("ctl00$MainContentHolder$btnGo")).Click();
            Assert.IsTrue(ie.Image(Find.ById("ctl00_MainContentHolder_btnPDF")).Exists);

        }





    }
}



