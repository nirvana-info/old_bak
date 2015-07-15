//#*****************************************************************************
//# Purpose: User orderdiscount
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
    public class adddiscount
    {
        public static string raid;
        public void TestUseradddiscount(Browser browser,string date)
        {
            browser.Link(Find.ByText("平台管理")).Click();
            browser.WaitUntilContainsText("请在左边的菜单选择您要进行的操作。 如有疑问，请点击下面相关链接查看操作流程图或查看交易指南");
            Assert.IsTrue(browser.ContainsText("请在左边的菜单选择您要进行的操作。 如有疑问，请点击下面相关链接查看操作流程图或查看交易指南"));

            browser.Link(Find.ByText("销售折扣管理")).Click();
            browser.WaitUntilContainsText("折扣设置");
            Assert.IsTrue(browser.ContainsText("折扣设置"));
            browser.Button(Find.ById("ctl00_ContentPlaceHolder1_btnNew")).Click();
            //日期
            browser.TextField(Find.ById("ctl00_ContentPlaceHolder1_txtStartDate")).TypeText(date);
            browser.TextField(Find.ById("ctl00_ContentPlaceHolder1_txtEndDate")).TypeText(date);
            browser.Button(Find.ById("ctl00_ContentPlaceHolder1_btnPricelistDetail")).Click();
            /*
            //选供应商
            browser.Image(Find.ByTitle("供应商查询")).ClickNoWait();

            Browser DW=IE.AttachToIE(Find.ByUrl("http://192.168.0.21/Trade/Price/OrgDetail.aspx?index=ctl00_ContentPlaceHolder1_gvDetail_ctl02_"));
            
            DW.TextField("txtDWMC").TypeText("自动供应商");
            DW.Button("btnSearch").Click();
            //DW.Button(Find.ByName("1001")).Click();
            DW.Button(Find.ByValue("选择")).Click();
            

            /*
            //选小品种       
            browser.Image(Find.ByTitle("品种查询")).ClickNoWait();
            Browser DW1=IE.AttachToIE(Find.ByUrl("http://192.168.0.21/Trade/Price/Product.aspx?orgid=0&index=ctl00_ContentPlaceHolder1_gvDetail_ctl02_"));
            browser.WaitUntilContainsText("小品种代码");
            DW1.TextField(Find.ById("txtProductName")).TypeText("焊接用钢盘条");
            DW1.Button(Find.ById("btnSearch")).Click();
            DW1.Button(Find.ByValue("选择")).Click();*/


            //选资源
            browser.Image(Find.ByTitle("资源查询")).ClickNoWait();
            Browser DW2=IE.AttachToIE(Find.ByUrl("http://192.168.0.21/Trade/Price/ProductDetail.aspx?orgid=0&productid=0&index=ctl00_ContentPlaceHolder1_gvDetail_ctl02_"));
            browser.WaitForComplete(120);
            DW2.TextField(Find.ById("txtcz")).TypeText("脚本");
            DW2.Button(Find.ById("Button1")).Click();
            DW2.Button(Find.ByValue("选择")).Click();

            browser.TextField(Find.ById("ctl00_ContentPlaceHolder1_gvDetail_ctl02_txtQty")).TypeText("1");
            browser.TextField(Find.ById("ctl00_ContentPlaceHolder1_gvDetail_ctl02_txtAmount")).TypeText("100");

            browser.Button(Find.ById("ctl00_ContentPlaceHolder1_btnSave")).ClickNoWait();
            browser.WaitUntilContainsText("折扣设置");
            Assert.IsTrue(browser.ContainsText("折扣设置"));

            //状态生效
            raid=browser.RadioButton(Find.ByName("radionSelect")).Id;
            browser.RadioButton(Find.ByName("radionSelect")).Checked = true;

            
            WatiN.Core.DialogHandlers.ConfirmDialogHandler dh4 = new WatiN.Core.DialogHandlers.ConfirmDialogHandler();

            browser.AddDialogHandler(dh4);

            browser.Button(Find.ById("ctl00_ContentPlaceHolder1_btnEffect")).ClickNoWait();
            dh4.WaitUntilExists(15);//
            dh4.OKButton.Click();//
            dh4.WaitUntilExists(15);

            dh4.OKButton.Click();
            browser.RemoveDialogHandler(dh4);
            Thread.Sleep(1000);
        }
    }
}
