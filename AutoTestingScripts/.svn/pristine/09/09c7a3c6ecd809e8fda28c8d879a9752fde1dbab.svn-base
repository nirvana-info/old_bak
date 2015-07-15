//#*****************************************************************************
//# Purpose: User upload zipcode
//# Author:  bobby
//# Create Date: apr 27, 2009
//# Modify History: 
//# 
//#*****************************************************************************

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
    public class OrderGeoZipUpload:PublicPara

    {
        public void TestUserOrderGeoZipUpload(Browser browser)
        {
            browser.WaitUntilContainsText("Step 1: Select Target Area(s) - Upload Zip Codes");
            Assert.IsTrue(browser.ContainsText("Step 1: Select Target Area(s) - Upload Zip Codes"));


            //upload list 
            browser.FileUpload(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_uploadfile1")).WaitUntilExists(20);
            browser.FileUpload(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_uploadfile1")).Set(UploadZipPath);

            browser.FileUpload(Find.ByValue(UploadZipPath)).WaitUntilExists(60);

            browser.Button(Find.ById("ctl00_ctl00_uxContent_ContentPlaceHolder1_btUpload")).Click();
            browser.Span(Find.ByText("Next")).Click();

        }
    }
}
