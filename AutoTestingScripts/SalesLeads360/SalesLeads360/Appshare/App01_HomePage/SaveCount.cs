using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using WatiN.Core;


namespace SalesLeads360.Appshare.App01_HomePage
{
    public class SaveCount:TestBase
    {
        public void SetDesiredCount(int CountNumber, Browser browser)
        {
            browser.TextField("ctl00_ctl00_uxContent_ContentPlaceHolder1_tbAdjustQty").WaitUntilExists(20);
            browser.TextField("ctl00_ctl00_uxContent_ContentPlaceHolder1_tbAdjustQty").TypeText(CountNumber.ToString());
            browser.Span((Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_tbTolDesQty"))&&(Find.ByText(CountNumber.ToString()))).WaitUntilExists(30);     
        }

        public void SetMapDesiredCount(int CountNumber, Browser browser)
        {
            browser.TextField("ctl00_ctl00_uxContent_ContentPlaceHolder1_gvOrderResults_ctl02_tbDesQty").WaitUntilExists(20);
            browser.TextField("ctl00_ctl00_uxContent_ContentPlaceHolder1_gvOrderResults_ctl02_tbDesQty").TypeText(CountNumber.ToString());

            browser.Span((Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_tbTolDesQty")) && (Find.ByText(CountNumber.ToString()))).WaitUntilExists(30);


        }
       
        public void SavedCount(string SavedName,Browser browser)
        {
            browser.Link("ctl00_ctl00_uxContent_ContentPlaceHolder1_lbSaveCount").Click();
            browser.Frame(Find.ByName("uxSaveCountWindow")).TextField("ctl00_uxDialogContent_tbDesc").WaitUntilExists(20);

            browser.Frame(Find.ByName("uxSaveCountWindow")).TextField("ctl00_uxDialogContent_tbFirstName").TypeText("Test");
            browser.Frame(Find.ByName("uxSaveCountWindow")).TextField("ctl00_uxDialogContent_tbLastName").TypeText("Test");
            browser.Frame(Find.ByName("uxSaveCountWindow")).TextField("ctl00_uxDialogContent_tbEmail").TypeText("christie.duan@nirvana-info.com");
            
            browser.Frame(Find.ByName("uxSaveCountWindow")).TextField("ctl00_uxDialogContent_tbDesc").TypeText(SavedName);
            browser.Frame(Find.ByName("uxSaveCountWindow")).Button("ctl00_uxDialogContent_btSave").Click();
            browser.Frame(Find.ByName("uxSaveCountWindow")).Button("ctl00_uxDialogContent_Button1").Click();
        }

        public void NCOASavedCount(string CountName,Browser browser)
        {
            browser.Frame(Find.ByName("uxSaveCountWindow")).TextField("ctl00_uxDialogContent_tbDesc").WaitUntilExists(20);
            browser.Frame(Find.ByName("uxSaveCountWindow")).TextField("ctl00_uxDialogContent_tbFirstName").TypeText("Test");
            browser.Frame(Find.ByName("uxSaveCountWindow")).TextField("ctl00_uxDialogContent_tbLastName").TypeText("Count");
            browser.Frame(Find.ByName("uxSaveCountWindow")).TextField("ctl00_uxDialogContent_tbEmail").TypeText(CountEmail);
            browser.Frame(Find.ByName("uxSaveCountWindow")).TextField("ctl00_uxDialogContent_tbDesc").TypeText(CountName);
            browser.Frame(Find.ByName("uxSaveCountWindow")).Button("ctl00_uxDialogContent_btSave").Click();
            browser.Frame(Find.ByName("uxSaveCountWindow")).Button("ctl00_uxDialogContent_Button1").Click();
        }

    }
}
