//#*****************************************************************************
//# Purpose: User change source type
//# Author:  bobby
//# Create Date: apr 13, 2009
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
using zjsteel.appshare;
using System.Threading;


namespace zjsteel.appshare.App01_HomePage
{
    public class changesourcetype
    {
        public void TestUserchangesourcetype(Browser browser, string pricetype)
        {




            browser.Link(Find.ByText("资源数据维护")).Click();
            browser.WaitUntilContainsText("本页可进行已挂资源价格修改");
            Assert.IsTrue(browser.ContainsText("本页可进行已挂资源价格修改"));

            browser.CheckBox(Find.ByName("ckbLotMaster")).Checked = true;
            //browser.SelectList(Find.ById("ctl00_ContentPlaceHolder1_gvLotMaster_ctl02_ddlPricetype")).Option(Find.ByText(pricetype)).Select();
            browser.Button(Find.ById("ctl00_ContentPlaceHolder1_btnEditType")).Click();

            browser.Frame(Find.ById("wheatmsg_ifrm")).SelectList(Find.ById("ddlPriceType")).Option(Find.ByValue(pricetype)).Select();
            browser.Frame(Find.ById("wheatmsg_ifrm")).Button(Find.ById("btnYes")).Click();
            /*WatiN.Core.DialogHandlers.ConfirmDialogHandler dh = new WatiN.Core.DialogHandlers.ConfirmDialogHandler();

            browser.AddDialogHandler(dh);

            browser.Button(Find.ById("ctl00_ContentPlaceHolder1_btnEditType")).ClickNoWait();
            dh.WaitUntilExists(15);//
            dh.OKButton.Click();//
            browser.RemoveDialogHandler(dh);*/
            

        }
    }
}
