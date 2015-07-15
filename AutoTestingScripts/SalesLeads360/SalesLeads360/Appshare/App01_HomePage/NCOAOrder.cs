using System;
using System.Collections.Generic;
using System.Text;
using WatiN.Core;
using NUnit.Framework;
using WatiN.Core.Interfaces;
using WatiN.Core.DialogHandlers;
using SalesLeads360.Appshare;
using SalesLeads360;

namespace SalesLeads360.Appshare.App01_HomePage
{
    public class NCOAOrder:TestBase
    {
        public void NCOAOrders(Browser browser,String FileType, string HostPath)
        {
            if (HostPath == "u")
            {
                OpenTargetUrl(targetHost + "sl360",browser);
            }
            else
            {
                OpenTargetUrl(targetHost+"salesleads360",browser);

                //userlogin
                Login login = new Login();
                login.userlogin(CountEmail, CountPW, browser);

            }

            browser.Link("aMainMenu1").WaitUntilExists(60);
            browser.Link("aMainMenu1").ClickNoWait();
            browser.Span(Find.ByText("NCOA")).WaitUntilExists(60);
            browser.Image("ctl00_ctl00_uxContent_ContentPlaceHolder1_ibStartNow").ClickNoWait();
            browser.FileUpload("ctl00_ctl00_uxContent_ContentPlaceHolder1_fuFile").WaitUntilExists(60);
           
            browser.FileUpload("ctl00_ctl00_uxContent_ContentPlaceHolder1_fuFile").Set(UploadLeadsPath);
            if (FileType == "c")
            {
                browser.RadioButton("ctl00_ctl00_uxContent_ContentPlaceHolder1_rblListType_0").Checked = true;
            }
            else
            {
                browser.RadioButton("ctl00_ctl00_uxContent_ContentPlaceHolder1_rblListType_1").Checked = true;
            }

            browser.Link("ctl00_ctl00_uxContent_ContentPlaceHolder1_BottomBtNext").Click();
            browser.Link("ctl00_ctl00_uxContent_ContentPlaceHolder1_BottomBtNext").Click();

            browser.CheckBox("ctl00_ctl00_uxContent_ContentPlaceHolder1_sOptions_cbOption1").Checked = true;

        }



    }
}