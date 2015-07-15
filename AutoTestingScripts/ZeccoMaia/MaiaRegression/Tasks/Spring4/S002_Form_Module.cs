using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using WatiN.Core.Interfaces;
using WatiN.Core.DialogHandlers;
using MaiaRegression.Appobjects.App01_HomePage;


namespace MaiaRegression.Tasks.Spring4
{
    [TestFixture]
    public class S002_Form_Module : SignIn
    {
        [Test]
        public void T01_Form_AllLinks()
        {
            this.GotoFormPage();
            //view key word 'Download Adobe Reader'to vierify going to correct page
            Assert.IsTrue(browser.ContainsText("Forms Library"));
        }

        [Test]
        public void T02_Form_Disclosure()
        {
            this.GotoFormPage();
            browser.Back();
            browser.Link(Find.ByText("Apply for options")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDisclosuresPage")).Click();
            //view key word 'Disclosures'to vierify going to correct page from apply for options
            Assert.IsTrue(browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxDisclosures_uxContentPartDiv")).Exists);
        }

        [Test]
        public void T03_Form_Margin()
        {
            this.GotoFormPage();
            browser.Link(Find.ById("uxMarginApplicationHelp")).Click();
            string u05 = browser.Link(Find.ByText("Download Margin Application Form")).Url;


            Assert.AreEqual(URL + "/Forms/margin-application/downloadform.aspx", u05);
            browser.Link(Find.ByText("Download Margin Application Form")).Click();
        }

        [Test]
        public void T04_Form_Options()
        {
            this.GotoFormPage();
            browser.Link(Find.ById("uxOptionsApplicationHelp")).Click();
            string u05 = browser.Link(Find.ByText("Download Options Application Form")).Url;


            Assert.AreEqual(URL + "/Forms/options-application/downloadform.aspx", u05);
            browser.Link(Find.ByText("Download Options Application Form")).Click();
        }

        [Test]
        public void T05_Form_AccountForm_PDFlink()
        {
            this.GotoFormPage();
            browser.Back();
            browser.Link(Find.ByText("View all forms")).Click();
            //Margin Application pdf
            Assert.IsTrue(browser.Link(Find.ById("uxCustomerAccountAgreementDownload")).Exists);
            //Options Application
            Assert.IsTrue(browser.Link(Find.ById("uxOptionAgreementDownload")).Exists);
            //Bank Account Link Request (Establish ACH)
            Assert.IsTrue(browser.Link(Find.ById("uxACHDownload")).Exists);
            //Money Market Sweep Request
            Assert.IsTrue(browser.Link(Find.ByText("Request money market sweep online")).Exists);
            //PenFlex Application
            Assert.IsTrue(browser.Link(Find.ById("uxPenFlexAccountApplicationDownload")).Exists);
            //Account Transfer Request
            Assert.IsTrue(browser.Link(Find.ById("uxACATRequestDownload")).Exists);
            //Account Transfer Cancellation
            Assert.IsTrue(browser.Link(Find.ById("uxRescindLetter")).Exists);
            //Internal Transfer Request
            Assert.IsTrue(browser.Link(Find.ById("uxRescindLetter")).Exists);
            //Non-transferable Security Removal Request
            Assert.IsTrue(browser.Link(Find.ById("uxSecurityDownload")).Exists);
            //Stock Certificate Deposit
            Assert.IsTrue(browser.Link(Find.ById("uxStockPowerDownload")).Exists);
            //IRA Withdrawal Request
            Assert.IsTrue(browser.Link(Find.ById("uxIRABeneficiaryDownload")).Exists);
            //Roth IRA Withdrawal Request
            Assert.IsTrue(browser.Link(Find.ById("uxIRABeneficiaryDownload")).Exists);
            //IRA Change of Beneficiary
            Assert.IsTrue(browser.Link(Find.ById("uxRothConversionDownload")).Exists);
            //IRA Conversion Request
            Assert.IsTrue(browser.Link(Find.ById("uxRothConversionDownload")).Exists);
            //W-9
            Assert.IsTrue(browser.Link(Find.ById("uxFw9Download")).Exists);
            //W-8 BEN
            Assert.IsTrue(browser.Link(Find.ById("uxFw8benDownload")).Exists);
            //Limited Trading Authorization
            Assert.IsTrue(browser.Link(Find.ById("uxAuthorizationDownload")).Exists);
            //Transfer On Death Agreement (TOD)
            Assert.IsTrue(browser.Link(Find.ById("uxTransferOnDeathDownload")).Exists);
        }

        [Test]
        public void T06_Form_ACATRequest()
        {
            this.GotoFormPage();
            browser.Link(Find.ById("uxACATRequestHelp")).Click();
            string u05 = browser.Link(Find.ByText("Download Account Transfer Request Form")).Url;

            Assert.AreEqual(URL + "/Forms/account-transfer-request/downloadform.aspx", u05);
            browser.Link(Find.ByText("Download Account Transfer Request Form")).Click();
        }

        [Test]
        public void T07_Form_IRAWithdrawal()
        {
            this.GotoFormPage();
            browser.Link(Find.ByUrl(URL + "/forms/irawithdrawal.aspx")).Click();
            string u08 = browser.Link(Find.ByText("Download IRA Withdrawal Form")).Url;

            Assert.AreEqual(URL + "/Forms/ira-withdrawal-request/downloadform.aspx", u08);
            browser.Link(Find.ByText("Download IRA Withdrawal Form")).Click();
        }

        [Test]
        public void T08_Form_RothIRAWithdrawal()
        {
            this.GotoFormPage();

            browser.Link(Find.ByUrl(URL + "/forms/rothirawithdrawal.aspx")).Click();
            string u09 = browser.Link(Find.ByText("Download Roth IRA Withdrawal Form")).Url;

            Assert.AreEqual(URL + "/Forms/roth-ira-withdrawal-request/downloadform.aspx", u09);
            browser.Link(Find.ByText("Download Roth IRA Withdrawal Form")).Click();
        }

        [Test]
        public void T09_Form_IRABeneficiary()
        {
            this.GotoFormPage();

            browser.Link(Find.ByUrl(URL + "/forms/irabeneficiary.aspx")).Click();
            string u10 = browser.Link(Find.ByText("Download IRA Beneficiary Form")).Url;

            Assert.AreEqual(URL + "/Forms/ira-designation-of-beneficiary/downloadform.aspx", u10);
            browser.Link(Find.ByText("Download IRA Beneficiary Form")).Click();
        }

        [Test]
        public void T10_Form_IRAConversion()
        {
            this.GotoFormPage();
            browser.Link(Find.ById("A1")).Click();
            string u11 = browser.Link(Find.ByText("Download IRA Conversion Form")).Url;

            Assert.AreEqual(URL + "/Forms/ira-conversion-request/downloadform.aspx", u11);
            browser.Link(Find.ByText("Download IRA Conversion Form")).Click();
        }

        [Test]
        public void T11_Form_W8Ben()
        {
            this.GotoFormPage();
            browser.Link(Find.ById("uxW8BenHelp")).Click();

            string u07 = browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxDownloadW8BENForm")).Url;

            Assert.AreEqual("http://www.irs.gov/pub/irs-pdf/fw8ben.pdf", u07);
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxDownloadW8BENForm")).Click();
        }

        [Test]
        public void T12_Form_AdminView()
        {
            GotoAdminForm();
            //check table
            Assert.IsTrue(browser.Table(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00")).Exists);
        }

        [Test]
        public void T13_Form_AdminUpdate()
        {
            GotoAdminForm();
            browser.Link(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00_ctl04_uxUpdate")).Click();
            browser.Button(Find.ById("ctl00_uxMainContent_uxFileUploadForUpdate_uxSubmit")).Click();
            Assert.AreEqual("Please select a file.", browser.Span(Find.ByClass("message-error")).Text);
        }

        [Test]
        public void T14_Form_AdminNew()
        {
            GotoAdminForm();
            browser.Link(Find.ById("ctl00_uxMainContent_uxAddNewForm")).Click();
            string Ti = DateTime.Now.ToString("hhmmss");
            browser.TextField(Find.ById("ctl00_uxMainContent_uxLoadFileName")).TypeText("zhujun1" + Ti);
            browser.FileUpload(Find.ById("ctl00_uxMainContent_uxFileUploadForAdd_uxRadUploadPicturefile0")).Set("c:\\zhuojun.pdf");
            browser.Button(Find.ById("ctl00_uxMainContent_uxFileUploadForAdd_uxSubmit")).Click();
            System.Threading.Thread.Sleep(10000);
            //browser.Button(Find.ById("ctl00_uxMainContent_uxFileUploadForAdd_uxSubmit")).Click();
            Assert.IsTrue(browser.ContainsText("Thanks! You have successfully added the form."));
            browser.Link(Find.ByText("Form Management")).Click();
            Assert.IsTrue(browser.ContainsText("zhujun1" + Ti));
        }

        [Test]
        public void T15_Form_CheckTableNull()
        {
            GotoAdminForm();
            //check table
            if (browser.Table(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00")).Exists)
            {
                for (int x = 1; x < 4; x++)
                {
                    int n = browser.Table(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00")).TableBodies[0].TableRows.Count;
                    //Console.WriteLine(n);
                    for (int i = 0; i < n; i++)
                    {
                        //Console.WriteLine(browser.Table(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00")).TableBodies[0].TableRows[i].TableCells[0].Text);
                        for (int j = 0; j <= 1; j++)
                        {
                            string cot1 = browser.Table(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00")).TableBodies[0].TableRows[i].TableCells[j].Text;
                            Assert.AreNotEqual("", cot1);
                            //Console.WriteLine(cot1);
                        }
                    }
                    //browser.Link(Find.ByText("2")).Click();

                    if (browser.Link(Find.ByText((x + 1).ToString())).Exists)
                    {
                        browser.Link(Find.ByText((x + 1).ToString())).Click();
                        browser.WaitForComplete();
                    }
                    else
                    {
                        break;
                    }
                }
            }
            else
            {
                Assert.Fail();
            }
        }

        [Test]
        public void T16_Form_W_9()
        {
            if (browser.Link(Find.ById("ctl00_uxLoginView_uxLoginStatus")).Exists)
            {
                browser.Span(Find.ById("ctl00_uxSiteMapBreadCrumb")).Link(Find.ByText("Portal Admin")).Click();
                browser.Link(Find.ById("ctl00_uxLoginView_uxLoginStatus")).Click();
            }
            browser.GoTo(targetHost);
            browser.WaitForComplete();

            this.GotoFormPage();

            string u16 = browser.Link(Find.ById("uxFw9Download")).Url;

            Assert.AreEqual("http://www.irs.gov/pub/irs-pdf/fw9.pdf", u16);
            browser.Link(Find.ById("uxFw9Download")).Click();
        }

        [Test]
        public void T17_Form_Limit_trading()
        {
            this.GotoFormPage();

            string u17 = browser.Link(Find.ById("uxAuthorizationDownload")).Url;

            Assert.AreEqual(URL + "/forms/limited-trading-authorization/DownloadForm.aspx", u17);
            browser.Link(Find.ById("uxAuthorizationDownload")).Click();
        }

        [Test]
        public void T18_Form_TOD()
        {
            this.GotoFormPage();

            string u18 = browser.Link(Find.ById("uxTransferOnDeathDownload")).Url;

            Assert.AreEqual(URL + "/forms/transfer-on-death-agreement/DownloadForm.aspx", u18);
            browser.Link(Find.ById("uxTransferOnDeathDownload")).Click();
        }

        [Test]
        public void T19_Form_RescindLetter_ATC()
        {
            this.GotoFormPage();

            //string u19 = browser.Link(Find.ById("uxRescindLetter")).Url;

            //Assert.AreEqual(URL + "/forms/account-transfer-cancellation/DownloadForm.aspx", u19);
            browser.Link(Find.ByUrl(URL + "/forms/account-transfer-cancellation/DownloadForm.aspx")).Click();
        }

        [Test]
        public void T20_Form_RescindLetter_ITR()
        {
            this.GotoFormPage();

            //string u19 = browser.Link(Find.ById("uxRescindLetter")).Url;

            //Assert.AreEqual(URL + "/forms/account-transfer-cancellation/DownloadForm.aspx", u19);
            browser.Link(Find.ByUrl(URL + "/forms/internal-transfer-request/DownloadForm.aspx")).Click();
        }

        [Test]
        public void T21_Form_SecurityDownload()
        {
            this.GotoFormPage();

            string u21 = browser.Link(Find.ById("uxSecurityDownload")).Url;

            Assert.AreEqual(URL + "/forms/nontransferable-security-removal/DownloadForm.aspx", u21);
            browser.Link(Find.ById("uxSecurityDownload")).Click();
        }

        [Test]
        public void T22_Form_StockPowerDownload()
        {
            this.GotoFormPage();

            string u22 = browser.Link(Find.ById("uxStockPowerDownload")).Url;

            Assert.AreEqual(URL + "/forms/stock-certificate-deposit/DownloadForm.aspx", u22);
            browser.Link(Find.ById("uxStockPowerDownload")).Click();
        }

        [Test]
        public void T23_Form_CustomerAccountAgreementDownload()
        {
            this.GotoFormPage();

            string u23 = browser.Link(Find.ById("uxCustomerAccountAgreementDownload")).Url;

            Assert.AreEqual(URL + "/forms/margin-application/DownloadForm.aspx", u23);
            browser.Link(Find.ById("uxCustomerAccountAgreementDownload")).Click();
        }

        [Test]
        public void T24_Form_OptionAgreementDownload()
        {
            this.GotoFormPage();

            string u24 = browser.Link(Find.ById("uxOptionAgreementDownload")).Url;

            Assert.AreEqual(URL + "/forms/options-application/DownloadForm.aspx", u24);
            browser.Link(Find.ById("uxOptionAgreementDownload")).Click();
        }

        [Test]
        public void T25_Form_ACHDownload()
        {
            this.GotoFormPage();

            string u25 = browser.Link(Find.ById("uxACHDownload")).Url;

            Assert.AreEqual(URL + "/forms/bank-account-link-request/DownloadForm.aspx", u25);
            browser.Link(Find.ById("uxACHDownload")).Click();
        }

        [Test]
        public void T26_PenFlexAccountApplicationDownload()
        {
            this.GotoFormPage();

            string u26 = browser.Link(Find.ById("uxPenFlexAccountApplicationDownload")).Url;

            Assert.AreEqual(URL + "/forms/penflex-application/DownloadForm.aspx", u26);
            browser.Link(Find.ById("uxPenFlexAccountApplicationDownload")).Click();
        }

        [Test]
        public void T27_Request_money_market_sweep_online()
        {
            this.GotoFormPage();

            string u27 = browser.Link(Find.ByText("Request money market sweep online")).Url;

            Assert.AreEqual(URL + "/ComposesupportMessage.aspx?Topic=MoneySweep", u27);
            browser.Link(Find.ByText("Request money market sweep online")).Click();
            Assert.IsTrue(browser.ContainsText("New Message to Zecco Trading Customer Service"));
        }

        private void GotoFormPage()
        {
            UserSignIn(UN, PW, false, 0);
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
            browser.WaitForComplete();
            //left view all form buttom
            browser.Link(Find.ByText("View all forms")).Click();
            //browser.Div(Find.ByClass("titleform-paddingleft")).Link(Find.ByText("Forms Page")).Click();
        }

        private void GotoAdminForm()
        {
            // if there already have a user login, do logout first
            if (browser.Link(Find.ByText("Sign Out")).Exists)
            {
                SignOut si = new SignOut();
                si.UserSignOut(browser);
            }
            if (browser.Link(Find.ById("ctl00_uxLoginView_uxLoginStatus")).Exists)
            {
                browser.Span(Find.ById("ctl00_uxSiteMapBreadCrumb")).Link(Find.ByText("Portal Admin")).Click();
                browser.Link(Find.ById("ctl00_uxLoginView_uxLoginStatus")).Click();
            }
            browser.GoTo(AdminUrl);
            browser.WaitForComplete();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxLogin_UserName")).TypeText(UN3);
            browser.TextField(Find.ById("ctl00_uxMainContent_uxLogin_Password")).TypeText(PW3);
            browser.Button(Find.ById("ctl00_uxMainContent_uxLogin_LoginButton")).Click();
            browser.WaitForComplete();
            browser.Div(Find.ById("ctl00_uxMainContent_uxFormsAdministration")).Link(Find.ByText("Forms Administration")).Click();
            browser.WaitForComplete();
        }
    }
}
