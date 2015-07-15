//#*****************************************************************************
//# Purpose: User salesource pack
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
    public class salesourcepack
    {
        public void TestUsersalespack(Browser browser, string bigsource, string littlesource, string size, string material, string made, string weight, string price, string date1, string date, string storehouse)
        {
            //#*****************************************************************************
            //# Purpose: define User sales function.
            //# Author:  bobby
            //# Last Modify: apr 13, 2009
            //#*****************************************************************************

            browser.Link(Find.ById("ctl00_linkTrade")).Click();
            browser.WaitUntilContainsText("请在左边的菜单选择您要进行的操作。 如有疑问，请点击下面相关链接查看操作流程图或查看交易指南");
            Assert.IsTrue(browser.ContainsText("请在左边的菜单选择您要进行的操作。 如有疑问，请点击下面相关链接查看操作流程图或查看交易指南"));

            browser.Link(Find.ByText("我要销售")).Click();
            browser.WaitUntilContainsText("请在左边的菜单选择您要进行的操作。 如有疑问，请点击下面相关链接查看操作流程图或查看交易指南");
            Assert.IsTrue(browser.ContainsText("请在左边的菜单选择您要进行的操作。 如有疑问，请点击下面相关链接查看操作流程图或查看交易指南"));

            browser.Link(Find.ByText("资源挂牌")).Click();
            browser.WaitUntilContainsText("可选择以下两种上传方式");
            Assert.IsTrue(browser.ContainsText("可选择以下两种上传方式"));
            //清空失误
            if (browser.Link(Find.ById("ctl00_ContentPlaceHolder1_GridView1_ctl02_edititem")).Exists)
            {
                WatiN.Core.DialogHandlers.ConfirmDialogHandler dh1 = new WatiN.Core.DialogHandlers.ConfirmDialogHandler();

                browser.AddDialogHandler(dh1);

                browser.Button(Find.ByValue("全部删除")).ClickNoWait();
                dh1.WaitUntilExists(15);//

                dh1.OKButton.Click();//
                dh1.WaitUntilExists(15);

                dh1.OKButton.Click();
                browser.RemoveDialogHandler(dh1);

            }
            
                browser.Image(Find.ByAlt("在线上传")).Click();
                browser.WaitUntilContainsText("提示：此处显示所选品种的规格填写规则,单位 为毫米");
                Assert.IsTrue(browser.ContainsText("提示：此处显示所选品种的规格填写规则,单位 为毫米"));
                //大品种
                browser.SelectList(Find.ById("ctl00_ContentPlaceHolder1_cmbCategory")).Option(bigsource).Select();
                browser.WaitUntilContainsText(bigsource);
                Assert.IsTrue(browser.ContainsText(bigsource));
                //小品种
                browser.SelectList(Find.ById("ctl00_ContentPlaceHolder1_cmbProductName")).Option(littlesource).Select();
                browser.WaitUntilContainsText(littlesource);
                Assert.IsTrue(browser.ContainsText(littlesource));
                //规格
                browser.TextField(Find.ById("ctl00_ContentPlaceHolder1_gg_h")).TypeText(size);
                browser.TextField(Find.ById("ctl00_ContentPlaceHolder1_gg_k")).TypeText(size);
                browser.TextField(Find.ById("ctl00_ContentPlaceHolder1_gg_c")).TypeText(size);
                //材质
                browser.TextField(Find.ById("ctl00_ContentPlaceHolder1_cz")).TypeText(material + date1);
                //厂家
                browser.TextField(Find.ById("ctl00_ContentPlaceHolder1_sccj")).TypeText(made + date1);

                //价格
                browser.TextField(Find.ById("ctl00_ContentPlaceHolder1_price")).TypeText(price);
                //日期
                browser.TextField(Find.ById("ctl00_ContentPlaceHolder1_manufacturedate")).TypeText(date);
                //仓库
                browser.SelectList(Find.ById("ctl00_ContentPlaceHolder1_cmblistck")).Option(storehouse).Select();
                browser.WaitUntilContainsText(storehouse);
                Assert.IsTrue(browser.ContainsText(storehouse));

                //重量
                browser.Button(Find.ById("ctl00_ContentPlaceHolder1_Button1")).Click();
                browser.TextField(Find.ById("ctl00_ContentPlaceHolder1_GridView1_ctl02_txtkbh")).TypeText(weight);
                browser.TextField(Find.ById("ctl00_ContentPlaceHolder1_GridView1_ctl02_txtqty")).TypeText(weight);

                browser.Button(Find.ById("ctl00_ContentPlaceHolder1_Button1")).Click();
                Thread.Sleep(1500);

                //确定资源录入
                browser.Button(Find.ById("ctl00_ContentPlaceHolder1_Button2")).Click();
                //挂牌
                browser.CheckBox(Find.ById("ctl00_ContentPlaceHolder1_GridView1_ctl02_gv_Chk")).Checked = true;
                browser.WaitUntilContainsText("可选择以下两种上传方式");
                Assert.IsTrue(browser.ContainsText("可选择以下两种上传方式"));
                //第一次
                WatiN.Core.DialogHandlers.ConfirmDialogHandler dh = new WatiN.Core.DialogHandlers.ConfirmDialogHandler();

                browser.AddDialogHandler(dh);

                browser.Button(Find.ByValue("全部挂")).ClickNoWait();
                dh.WaitUntilExists(15);//

                dh.OKButton.Click();//
                dh.WaitUntilExists(15);

                dh.OKButton.Click();
                browser.RemoveDialogHandler(dh);
                browser.WaitUntilContainsText("未查询到您想要的数据");
                Assert.IsTrue(browser.ContainsText("未查询到您想要的数据"));
            
        }
    }
}
