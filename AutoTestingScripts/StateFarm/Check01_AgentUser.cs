using System;
using System.Collections.Generic;
using System.Text;
using WatiN.Core;
using NUnit.Framework;
using System.Threading;
using System.Globalization;


namespace PPlusSystemTesting
{
    [TestFixture]
    public class Check01_AgentUser : TestBase
    {
        [Test]
        public void Check01_01_Login()
        {
            AdminLogin("admin", "12345");
            AgentLogin(AgentID);
            Assert.IsTrue(ie.Image(Find.ByAlt("Search")).Exists);
            Assert.IsTrue(ie.Image(Find.ByAlt("Leads")).Exists);
            Assert.IsTrue(ie.Image(Find.ByAlt("Prospects")).Exists);
            Assert.IsTrue(ie.Image(Find.ByAlt("SMPs")).Exists);
            Assert.IsTrue(ie.Image(Find.ByAlt("Tasks")).Exists);
            Assert.IsTrue(ie.Image(Find.ByAlt("Reports")).Exists);
            Assert.IsTrue(ie.Image(Find.ByAlt("Profile")).Exists);
            Assert.IsTrue(ie.Image(Find.ByAlt("Help")).Exists);
        }

        [Test]
        public void Check01_02_OrderNewLeadsByCities()
        {
            ie.Image(Find.ByAlt("Leads")).Click();
            ie.Link(Find.ByText("Order New Leads")).Click();

            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ById("ctl00_FooterButtonNext")).Click();

            ie.Frame(Find.ById("MainContentFrame")).Span(Find.ByText("Select Geography")).WaitUntilExists(120);
            ie.Frame(Find.ById("MainContentFrame")).SelectList(Find.ById("ctl00_MainContentHolder_listGeographyType")).Option("Select Cities").Select();
            ie.Frame(Find.ById("MainContentFrame")).Button(Find.ByName("ctl00$FooterButtonNext")).Click();

            ie.Frame(Find.ById("MainContentFrame")).SelectList(Find.ById("ctl00_MainContentHolder_lstCities")).Option("AIRWAY HGTS").Select();
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ById("btnAdd")).Click();
            ie.Frame(Find.ById("MainContentFrame")).SelectList(Find.ById("ctl00_MainContentHolder_lstCitiesTarget")).Option("AIRWAY HGTS,Washington").WaitUntilExists(120);

            ie.Frame(Find.ById("MainContentFrame")).SelectList(Find.ById("ctl00_MainContentHolder_lstCities")).Option("ALMIRA").Select();
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ById("btnAdd")).Click();
            ie.Frame(Find.ById("MainContentFrame")).SelectList(Find.ById("ctl00_MainContentHolder_lstCitiesTarget")).Option("ALMIRA,Washington").WaitUntilExists(120);

            ie.Frame(Find.ById("MainContentFrame")).SelectList(Find.ById("ctl00_MainContentHolder_lstCities")).Option("ACME").Select();
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ById("btnAdd")).Click();
            ie.Frame(Find.ById("MainContentFrame")).SelectList(Find.ById("ctl00_MainContentHolder_lstCitiesTarget")).Option("ACME,Washington").WaitUntilExists(120);

            ie.Frame(Find.ById("MainContentFrame")).Link(Find.ById("ctl00_MainContentHolder_lkSaveSelected")).Click();

            ie.Frame(Find.ById("MainContentFrame")).SelectList(Find.ById("ctl00_MainContentHolder_lstStates")).Option("Oregon").Select();
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ById("ctl00_FooterButtonNext")).Click();

            ie.Frame(Find.ById("MainContentFrame")).SelectList(Find.ById("ctl00_MainContentHolder_lstCities")).Option("ADAMS").Select();
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ById("btnAdd")).Click();
            ie.Frame(Find.ById("MainContentFrame")).SelectList(Find.ById("ctl00_MainContentHolder_lstCitiesTarget")).Option("ADAMS,Oregon").WaitUntilExists(120);

            ie.Frame(Find.ById("MainContentFrame")).SelectList(Find.ById("ctl00_MainContentHolder_lstCities")).Option("ADEL").Select();
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ById("btnAdd")).Click();
            ie.Frame(Find.ById("MainContentFrame")).SelectList(Find.ById("ctl00_MainContentHolder_lstCitiesTarget")).Option("ADEL,Oregon").WaitUntilExists(120);


            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ById("ctl00_FooterButtonNext")).Click();
            ie.Frame(Find.ById("MainContentFrame")).Span(Find.ByText("Select Target")).WaitUntilExists(120);
            ie.Frame(Find.ById("MainContentFrame")).RadioButton(Find.ById("ctl00_MainContentHolder_tabLead__ctl0_gvLeadTypes_ctl03_rdoSelected")).Checked = true;
            ie.Frame(Find.ById("MainContentFrame")).CheckBox(Find.ById("ctl00_MainContentHolder_rptState_ctl00_cbPhoneOnly")).Checked = true;

            ie.Frame(Find.ById("MainContentFrame")).Button(Find.ByName("ctl00$FooterButtonNext")).ClickNoWait();

            ie.Frame(Find.ById("MainContentFrame")).Span(Find.ByText("Available List Count")).WaitUntilExists(120);


            ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ById("ctl00_MainContentHolder_gvBreakDown_ctl02_txtDetailCount")).TypeText("1");
            ie.Frame(Find.ById("MainContentFrame")).Link(Find.ById("ctl00_MainContentHolder_lbChangeDetailCount")).Click();
            string TotalCount;
            for (int i = 1; i < 1; )
            {
                TotalCount = ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ById("ctl00_MainContentHolder_txtDesiredCount")).Text;
                if (TotalCount == "1")
                {
                    i = 0;
                }
            }// After finish Update Count, Do next step.


            ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ById("ctl00_MainContentHolder_gvBreakDown_ctl03_txtDetailCount")).TypeText("1");
            ie.Frame(Find.ById("MainContentFrame")).Link(Find.ById("ctl00_MainContentHolder_lbChangeDetailCount")).Click();



            for (int i = 1; i < 1; )
            {
                TotalCount = ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ById("ctl00_MainContentHolder_txtDesiredCount")).Text;
                if (TotalCount == "2")
                {
                    i = 0;
                }
            }// After finish Update Count, Do next step.


            ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ById("ctl00_MainContentHolder_gvBreakDown_ctl04_txtDetailCount")).TypeText("1");
            ie.Frame(Find.ById("MainContentFrame")).Link(Find.ById("ctl00_MainContentHolder_lbChangeDetailCount")).Click();

            for (int i = 1; i < 1; )
            {
                TotalCount = ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ById("ctl00_MainContentHolder_txtDesiredCount")).Text;
                if (TotalCount == "3")
                {
                    i = 0;
                }
            }// After finish Update Count, Do next step.


            //ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ById("ctl00_MainContentHolder_gvBreakDown_ctl05_txtDetailCount")).TypeText("1");
            //ie.Frame(Find.ById("MainContentFrame")).Link(Find.ById("ctl00_MainContentHolder_lbChangeDetailCount")).Click();

            //for (int i = 1; i < 1; )
            //{
            //    TotalCount = ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ById("ctl00_MainContentHolder_txtDesiredCount")).Text;
            //    if (TotalCount == "4")
            //    {
            //        i = 0;
            //    }
            //}// After finish Update Count, Do next step.


            //ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ById("ctl00_MainContentHolder_gvBreakDown_ctl06_txtDetailCount")).TypeText("1");
            //ie.Frame(Find.ById("MainContentFrame")).Link(Find.ById("ctl00_MainContentHolder_lbChangeDetailCount")).Click();

            //for (int i = 1; i < 1; )
            //{
            //    TotalCount = ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ById("ctl00_MainContentHolder_txtDesiredCount")).Text;
            //    if (TotalCount == "5")
            //    {
            //        i = 0;
            //    }
            //}// After finish Update Count, Do next step.


            ie.Frame(Find.ById("MainContentFrame")).Button(Find.ByName("ctl00$FooterButtonNext")).Click();

            ie.Frame(Find.ById("MainContentFrame")).TableCell(Find.ByText("Corp SMP")).WaitUntilExists(120);
            ie.Frame(Find.ById("MainContentFrame")).TableCell(Find.ByText("Corp SMP")).ClickNoWait();
            ie.Frame(Find.ById("MainContentFrame")).RadioButton(Find.ById("ctl00_MainContentHolder_tcMailerOrBundle__ctl1_gvBundle_Corp_ctl02_rdoSelected_b")).WaitUntilExists(120);

            ie.Frame(Find.ById("MainContentFrame")).Link(Find.ById("ctl00_MainContentHolder_tcMailerOrBundle__ctl1_gvBundle_Corp_ctl02_lbBundleName")).Click();
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$FooterButtonBack")).Click();

            Thread.Sleep(3000);

            ie.Frame(Find.ById("MainContentFrame")).RadioButton(Find.ById("ctl00_MainContentHolder_rdStatelist_1")).Checked = true;

            ie.Frame(Find.ById("MainContentFrame")).TableCell(Find.ByText("Corp SMP")).ClickNoWait();
            ie.Frame(Find.ById("MainContentFrame")).RadioButton(Find.ById("ctl00_MainContentHolder_tcMailerOrBundle__ctl1_gvBundle_Corp_ctl02_rdoSelected_b")).WaitUntilExists(120);
            ie.Frame(Find.ById("MainContentFrame")).Link(Find.ById("ctl00_MainContentHolder_tcMailerOrBundle__ctl1_gvBundle_Corp_ctl02_lbBundleName")).Click();
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$FooterButtonBack")).Click();

            Thread.Sleep(3000);

            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$FooterButtonNext")).Click();
            ie.Frame(Find.ById("MainContentFrame")).Span(Find.ByText("Order Summary")).WaitUntilExists(120);

            ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ById("ctl00_MainContentHolder_rpOrderName_ctl00_txtCampaignName")).TypeText("order" + Date);

            ie.Frame(Find.ById("MainContentFrame")).Button(Find.ByName("ctl00$FooterButtonPlace")).Click();
            ie.WaitForComplete();

            Assert.IsTrue(ie.Frame(Find.ById("MainContentFrame")).ContainsText("Your Order is Complete"));

        }

        [Test]

        public void Check01_03_SubscriptionByTopZips()
        {
            ie.Image(Find.ByAlt("Leads")).Click();
            ie.Link(Find.ByText("Subscriptions")).Click();

            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ById("ctl00_FooterButtonNew")).Click();
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$FooterButtonNext")).Click();
            ie.Frame(Find.ById("MainContentFrame")).Span(Find.ByText("Select Geography")).WaitUntilExists(120);
            ie.Frame(Find.ById("MainContentFrame")).SelectList(Find.ById("ctl00_MainContentHolder_listGeographyType")).Option("Top ZIP/FSA").Select();
            ie.Frame(Find.ById("MainContentFrame")).Button(Find.ByName("ctl00$FooterButtonNext")).Click();
            ie.Frame(Find.ById("MainContentFrame")).Span(Find.ByText("Select Target")).WaitUntilExists(120);

            ie.Frame(Find.ById("MainContentFrame")).Link(Find.ById("ctl00_MainContentHolder_PagetitleBarWithProgress1_ccProgress_indGeo")).Click();
            ie.Frame(Find.ById("MainContentFrame")).SelectList(Find.ById("ctl00_MainContentHolder_lstStates")).Option("Idaho").Select();
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ById("ctl00_FooterButtonNext")).Click();

            ie.Frame(Find.ById("MainContentFrame")).RadioButton(Find.ById("ctl00_MainContentHolder_tabLead__ctl0_gvLeadTypes_ctl03_rdoSelected")).Checked = true;

            ie.Frame(Find.ById("MainContentFrame")).Button(Find.ByName("ctl00$FooterButtonNext")).ClickNoWait();

            ie.Frame(Find.ById("MainContentFrame")).Span(Find.ByText("Available List Count")).WaitUntilExists(120);


            ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ById("ctl00_MainContentHolder_gvBreakDown_ctl02_txtDetailCount")).TypeText("1");
            ie.Frame(Find.ById("MainContentFrame")).Link(Find.ById("ctl00_MainContentHolder_lbChangeDetailCount")).Click();
            string TotalCount;
            for (int i = 1; i < 1; )
            {
                TotalCount = ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ById("ctl00_MainContentHolder_txtDesiredCount")).Text;
                if (TotalCount == "1")
                {
                    i = 0;
                }
            }

            ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ById("ctl00_MainContentHolder_gvBreakDown_ctl09_txtDetailCount")).TypeText("1");
            ie.Frame(Find.ById("MainContentFrame")).Link(Find.ById("ctl00_MainContentHolder_lbChangeDetailCount")).Click();
            for (int i = 1; i < 1; )
            {
                TotalCount = ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ById("ctl00_MainContentHolder_txtDesiredCount")).Text;
                if (TotalCount == "2")
                {
                    i = 0;
                }
            }


            ie.Frame(Find.ById("MainContentFrame")).Button(Find.ByName("ctl00$FooterButtonNext")).Click();

            ie.Frame(Find.ById("MainContentFrame")).TableCell(Find.ByText("Corp SMP")).WaitUntilExists(120);
            ie.Frame(Find.ById("MainContentFrame")).TableCell(Find.ByText("Corp SMP")).ClickNoWait();

            ie.Frame(Find.ById("MainContentFrame")).RadioButton(Find.ById("ctl00_MainContentHolder_tcMailerOrBundle__ctl1_gvBundle_Corp_ctl02_rdoSelected_b")).WaitUntilExists(120);
            ie.Frame(Find.ById("MainContentFrame")).Link(Find.ById("ctl00_MainContentHolder_tcMailerOrBundle__ctl1_gvBundle_Corp_ctl02_lbBundleName")).Click();
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$FooterButtonBack")).Click();

            Thread.Sleep(3000);
            ie.Frame(Find.ById("MainContentFrame")).RadioButton(Find.ById("ctl00_MainContentHolder_rdStatelist_1")).Checked = true;
            ie.Frame(Find.ById("MainContentFrame")).TableCell(Find.ByText("Corp SMP")).ClickNoWait();
            ie.Frame(Find.ById("MainContentFrame")).RadioButton(Find.ById("ctl00_MainContentHolder_tcMailerOrBundle__ctl1_gvBundle_Corp_ctl02_rdoSelected_b")).WaitUntilExists(120);
            ie.Frame(Find.ById("MainContentFrame")).Link(Find.ById("ctl00_MainContentHolder_tcMailerOrBundle__ctl1_gvBundle_Corp_ctl02_lbBundleName")).Click();
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$FooterButtonBack")).Click();
            Thread.Sleep(3000);

            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$FooterButtonNext")).Click();
            ie.Frame(Find.ById("MainContentFrame")).Span(Find.ByText("Subscription Summary")).WaitUntilExists(120);

            ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ById("ctl00_MainContentHolder_rpOrderName_ctl00_txtCampaignName")).TypeText("sub" + Date);
            ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ById("ctl00_MainContentHolder_rpEffectiveDate_ctl00_wdcDate1_input")).TypeText(dt);
            ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ById("ctl00_MainContentHolder_rpEffectiveDate_ctl00_wdcDate2_input")).TypeText("12/31/2009");
            ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ById("ctl00_MainContentHolder_rpEffectiveDate_ctl01_wdcDate1_input")).TypeText(dt);
            ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ById("ctl00_MainContentHolder_rpEffectiveDate_ctl01_wdcDate2_input")).TypeText("12/31/2009");

            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ByName("ctl00$FooterButtonNext")).Click();
            ie.WaitForComplete();

            Assert.IsTrue(ie.Frame(Find.ById("MainContentFrame")).ContainsText("sub" + Date));

        }

        [Test]

        public void Check01_04_FollowUp()
        {
            ie.Image(Find.ByAlt("Leads")).Click();
            ie.Link(Find.ByText("Follow-up")).Click();
            ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ById("ctl00_MainContentHolder_tbDateFrom_input")).WaitUntilExists(120);
            //ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ById("ctl00_MainContentHolder_tbDateFrom_input")).TypeText(dt);
            //ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ById("ctl00_MainContentHolder_tbDateTo_input")).TypeText(dt);

            ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ById("ctl00_MainContentHolder_tbDateFrom_input")).TypeText("6/2/2008");
            ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ById("ctl00_MainContentHolder_tbDateTo_input")).TypeText("6/2/2008");

            ie.Frame(Find.ById("MainContentFrame")).SelectList(Find.ById("ctl00_MainContentHolder_ddlStatus")).Option("Active").Select();
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ById("ctl00_FooterButtonNext")).Click();
            ie.Frame(Find.ById("MainContentFrame")).Link(Find.ById("ctl00_MainContentHolder_gvOrder_Agent_ctl02_HyperLink1")).WaitUntilExists(120);
            ie.Frame(Find.ById("MainContentFrame")).Link(Find.ById("ctl00_MainContentHolder_gvOrder_Agent_ctl02_HyperLink1")).Click();

            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ById("ctl00_FooterButtonAddFollowup")).WaitUntilExists(120);
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ById("ctl00_FooterButtonAddFollowup")).Click();

            //ie.Frame(Find.ById("MainContentFrame")).TableCell(Find.ById("ctl00_MainContentHolder_gvDrops_ctl03_txtMailerID_b0")).MouseDown(); Add Mailers

            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ById("ctl00_FooterButtonAddBundle")).WaitUntilExists(120);
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ById("ctl00_FooterButtonAddBundle")).ClickNoWait();
            ie.Frame(Find.ById("MainContentFrame")).TableCell(Find.ByText("Corp SMP")).ClickNoWait();

            ie.Frame(Find.ById("MainContentFrame")).RadioButton(Find.ByName("bundles")).Checked = true;
            ie.Frame(Find.ById("MainContentFrame")).Button(Find.ByName("ctl00$FooterButtonNext")).ClickNoWait();
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ById("ctl00_MainContentHolder_btnSave")).ClickNoWait();


            //WatiN.Core.DialogHandlers.ConfirmDialogHandler xh = new WatiN.Core.DialogHandlers.ConfirmDialogHandler();
            //ie.AddDialogHandler(xh);
            //ie.Frame(Find.ById("MainContentFrame")).Button(Find.ByName("ctl00$FooterButtonNext")).ClickNoWait();

            //xh.WaitUntilExists(3);
            //xh.OKButton.Click();
            //ie.RemoveDialogHandler(xh);


            ie.WaitForComplete(120);
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ById("ctl00_FooterButtonAddBundle")).WaitUntilExists(120);
            Assert.IsTrue(ie.Frame(Find.ById("MainContentFrame")).Image(Find.ById("ctl00_FooterButtonAddBundle")).Exists);
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ById("ctl00_FooterButtonSave_Finish")).ClickNoWait();

        }

        [Test]
        public void Check01_05_UploadList()
        {
            ie.Image(Find.ByAlt("Leads")).Click();
            ie.Link(Find.ByText("List Upload")).Click();
            ie.Frame(Find.ById("MainContentFrame")).Span(Find.ByText("Upload > List Upload")).WaitUntilExists(120);

            ie.Frame(Find.ById("MainContentFrame")).FileUpload(Find.ById("ctl00_MainContentHolder_uxFileUpload")).Set("E:\\ListUpload.xls");

            ie.Frame(Find.ById("MainContentFrame")).Button(Find.ByName("ctl00$FooterButtonNext")).Click();
            Assert.IsTrue(ie.Frame(Find.ById("MainContentFrame")).ContainsText("Associate column headers to data in the upload file."));


            string dv = "Uploaded@" + Date;
            ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ByName("ctl00$MainContentHolder$txtListName")).TypeText(dv);
            ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ByName("ctl00_MainContentHolder_wdcEDate_input")).TypeText("12/01/2009");
            ie.Frame(Find.ById("MainContentFrame")).SelectList(Find.ByName("ctl00$MainContentHolder$ddlDataSource")).Option(Find.ByText("US Consumer")).Select();
            ie.Frame(Find.ById("MainContentFrame")).SelectList(Find.ById("ctl00_MainContentHolder_ddlLeadSource")).Option(Find.ByText("AgentsAdvantage")).Select();
            ie.Frame(Find.ById("MainContentFrame")).SelectList(Find.ById("ctl00_MainContentHolder_ddl_lastname_ddl_headers")).Option("Last_Name").Select();

            ie.Frame(Find.ById("MainContentFrame")).Button(Find.ByName("ctl00$FooterButtonNext")).Click();

            Assert.IsTrue(ie.Frame(Find.ById("MainContentFrame")).ContainsText("Your list has been successfully uploaded!"));
        }


        [Test]
        public void Check01_06_UploadedListReport()
        {
            ie.Image(Find.ByAlt("Reports")).Click();
            ie.Link(Find.ByText("Uploaded Details")).Click();
            ie.Frame(Find.ById("MainContentFrame")).Span(Find.ByText("Uploaded List Report")).WaitUntilExists(120);
            ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ById("ctl00_MainContentHolder_fromDate_input")).TypeText(dt);
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ById("ctl00_MainContentHolder_btnGo")).ClickNoWait();
            ie.Frame(Find.ById("MainContentFrame")).Table(Find.ById("ctl00_MainContentHolder_gvList")).TableRow(Find.ByClass("gridRow01")).TableCell(Find.ByText("Uploaded@" + Date)).WaitUntilExists(120);
            Assert.IsTrue(ie.Frame(Find.ById("MainContentFrame")).Table(Find.ById("ctl00_MainContentHolder_gvList")).TableRow(Find.ByClass("gridRow01")).TableCell(Find.ByText("Uploaded@" + Date)).Exists);
        }

        [Test]
        public void Check01_07_SplitList()
        {
            ie.Image(Find.ByAlt("Leads")).Click();
            ie.Link(Find.ByText("Leads Home")).ClickNoWait();
            //ie.Frame(Find.ById("MainContentFrame")).Link(Find.ById("ctl00_MainContentHolder_gvLists_ctl02_lkListName")).WaitUntilExists(120);
            //ie.Frame(Find.ById("MainContentFrame")).Link(Find.ById("ctl00_MainContentHolder_gvLists_ctl02_lkListName")).MouseDown();

            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ById("ctl00_MainContentHolder_gvLists_ctl02_ibViewList")).ClickNoWait();

            ie.Frame(Find.ById("MainContentFrame")).Link(Find.ById("ctl00_MainContentHolder_gvLists_ctl02_lkListName")).ClickNoWait();
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ById("ctl00_FooterButtonSplit")).WaitUntilExists(120);
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ById("ctl00_FooterButtonSplit")).ClickNoWait();
            ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ById("ctl00_MainContentHolder_txtListName")).WaitUntilExists(120);
            //ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ById("ctl00_MainContentHolder_txtListName")).Value = "Split" + Date;
            ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ById("ctl00_MainContentHolder_txtListName")).TypeText("Split" + Date);
            ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ById("ctl00_MainContentHolder_txtNumber")).TypeText("1");
            ie.Frame(Find.ById("MainContentFrame")).Button(Find.ByAlt("Apply")).Click();
            ie.Frame(Find.ById("MainContentFrame")).Button(Find.ById("ctl00_FooterButtonBack")).ClickNoWait();
            ie.Frame(Find.ById("MainContentFrame")).Span(Find.ByText("Leads Home")).WaitUntilExists(120);

            Assert.IsTrue(ie.Frame(Find.ById("MainContentFrame")).Link(Find.ByText("Split" + Date + "_1")).Exists);

        }

        [Test]
        public void Check01_08_MergeList()
        {
            ie.Frame(Find.ById("MainContentFrame")).TableRow(Find.ByClass("gridRow01")).CheckBox(Find.ByName("ckbPick")).Checked = true;
            ie.Frame(Find.ById("MainContentFrame")).TableRow(Find.ByClass("gridRow02")).CheckBox(Find.ByName("ckbPick")).Checked = true;
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ById("ctl00_MainContentHolder_ibMerge")).ClickNoWait();
            ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ById("ctl00_MainContentHolder_txtListName")).WaitUntilExists(120);
            ie.Frame(Find.ById("MainContentFrame")).TextField(Find.ById("ctl00_MainContentHolder_txtListName")).TypeText("Merge" + Date);
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ById("ctl00_MainContentHolder_ibMergeSave")).ClickNoWait();
            ie.Frame(Find.ById("MainContentFrame")).Span(Find.ById("ctl00_pgBarWithoutProg_lblTitle")).WaitUntilExists(120);
            Assert.IsTrue(ie.Frame(Find.ById("MainContentFrame")).Span(Find.ById("ctl00_pgBarWithoutProg_lblTitle")).Exists);

        }

        [Test]
        public void Check01_09_DeactiveList()
        {
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ById("ctl00_FooterButtonBack")).Click();
            ie.Frame(Find.ById("MainContentFrame")).Span(Find.ByText("Leads Home")).WaitUntilExists(120);
            string ListName = ie.Frame(Find.ById("MainContentFrame")).Link(Find.ById("ctl00_MainContentHolder_gvLists_ctl02_lkListName")).Text;
            ie.Frame(Find.ById("MainContentFrame")).TableRow(Find.ByClass("gridRow01")).CheckBox(Find.ByName("ckbPick")).Checked = true;
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ById("ctl00_MainContentHolder_ibDeactivate")).ClickNoWait();

            ie.Frame(Find.ById("MainContentFrame")).SelectList(Find.ById("ctl00_MainContentHolder_lstDisableReason")).WaitUntilExists(120);
            ie.Frame(Find.ById("MainContentFrame")).SelectList(Find.ById("ctl00_MainContentHolder_lstDisableReason")).Option("Other").Select();
            ie.Frame(Find.ById("MainContentFrame")).Image(Find.ById("ctl00_MainContentHolder_ibDeactivateSave")).ClickNoWait();

            Assert.IsFalse(ie.Frame(Find.ById("MainContentFrame")).Link(Find.ByText(ListName)).Exists);
        }

        [Test]
        public void Check01_10_DeleteLeads()
        {

        }

        [Test]
        public void Check01_11_ChangeListName()
        {

        }

        [Test]
        public void Check01_12_CleanOCR()
        {

        }

        [Test]
        public void Check01_13_PrintCallingList()
        {

        }
    }
}
