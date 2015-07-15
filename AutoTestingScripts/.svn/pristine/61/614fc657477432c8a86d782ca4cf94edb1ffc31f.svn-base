using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using NUnit.Framework;
using Selenium;
using System.Threading;

namespace YinJiaRegressionTestingProject
{
    [TestFixture]
    public class 采购 : TestBase
    {

        [Test]
        public void Step01集团采购申请()
        {
            selenium.Click("link=LOGIN");
            selenium.Type("txtUsername", "n_it0001");
            WatiForClick("ext-gen67", 30);// user(n_it001) login


            WatiForClick("ext-gen65", 40); //选择采购管理


            
            selenium.Open(url + "/Portal/PU/PmcPRequisitionMgmt.aspx?PRTypeCode=All&FromScope=All");
            //选择采购申请单


            WatiForElement("//table[@id='ctl00_contentPlaceHolder_btnNew']", 30);
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_btnNew']/tbody[1]/tr[1]/td[2]/em[1]/button[1]");
            //新建采购申请

            WatiForElement("tabPmcPRequisitionDetail_IFrame", 30);
            selenium.SelectFrame("tabPmcPRequisitionDetail_IFrame");
            WatiForElement("//input[@id='ctl00_contentPlaceHolder_CbPRType']", 30);
            selenium.Click("//input[@id='ctl00_contentPlaceHolder_CbPRType']");

            WatiForElement("//html[@class='ext-strict x-viewport']", 20);
            selenium.Click("//html[@class='ext-strict x-viewport']/body/div[@class='x-layer x-combo-list']/div[1]/div[1]");
            //选择申购类型

            selenium.Click("ctl00_hiddenButton");
            selenium.Click("uxPUEntity");
            selenium.Focus("uxPUEntity");
            selenium.TypeKeys("uxPUEntity", "EEKA");
            WatiForElement("//html[@class='ext-strict x-viewport']/body/div[@class='x-layer x-combo-list']/div[1]/div[1]/h3", 20);
            selenium.Click("//html[@class='ext-strict x-viewport']/body/div[@class='x-layer x-combo-list']/div[1]/div[1]/h3");
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_btnSave']/tbody/tr/td[2]/em");//保存


            WatiForElement("//table[@id='ctl00_contentPlaceHolder_btnInsert']/tbody/tr", 20);
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_btnInsert']/tbody/tr");//增行



            WatiForElement("//div[@class='x-grid3-row x-grid3-dirty-row x-grid3-row-first x-grid3-row-last']/table/tbody/tr/td[5]/div", 20);
            selenium.Click("//div[@class='x-grid3-row x-grid3-dirty-row x-grid3-row-first x-grid3-row-last']/table/tbody/tr/td[5]/div");
            selenium.Focus("//div[@class='x-grid3-row x-grid3-dirty-row x-grid3-row-first x-grid3-row-last']/table/tbody/tr/td[5]/div");
            selenium.TypeKeys("uxItemCode", "N10A72430113213");
            WatiForElement("//body[@class='ext-gecko ext-gecko3']/div[28]/div/div/h3/span", 20);
            selenium.Click("//body[@class='ext-gecko ext-gecko3']/div[28]/div/div/h3/span");
            selenium.MouseDownRight("//body[@class='ext-gecko ext-gecko3']/div[28]/div/div/h3/span");//项目编号
            WatiForElement("//div[@class='x-grid3-row x-grid3-dirty-row x-grid3-row-first']/table/tbody/tr/td[13]", 20);
            selenium.Click("//div[@class='x-grid3-row x-grid3-dirty-row x-grid3-row-first']/table/tbody/tr/td[13]/div");
            selenium.Focus("//div[@class='x-grid3-row x-grid3-dirty-row x-grid3-row-first']/table/tbody/tr/td[13]/div");
            selenium.Type("ctl00_contentPlaceHolder_RequestQtyInput", "100");
            selenium.MouseDownRight("ctl00_contentPlaceHolder_RequestQtyInput"); //申购数量
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_btnSave']/tbody/tr/td[2]/em/button");//保存
            WatiForElement("//table[@id='ctl00_contentPlaceHolder_ctl28']/tbody/tr/td[2]/em/button", 30);
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_btnCommit']/tbody/tr/td[2]/em/button");//提交
            //采购明细   

            selenium.Open(url + "/Portal/HomePage/HomeFrame.aspx");
            selenium.Click("//input[@id='ibLogout']"); //logout

        }


        [Test]

        public void Step02集团采购计划()
        {
            selenium.Click("link=LOGIN");
            selenium.Type("txtUsername", "EEKA_it0001");
            WatiForClick("ext-gen67", 30);// user(EEKA_it0001) login

            WatiForClick("ext-gen65", 30); //选择采购管理
            selenium.Open(url + "/Portal/PU/PurchasePlanMgmt.aspx?WorkGroup=All");

            WatiForClick("//div[@id='gridPurchasePlan']/div/div/div/div/div[2]/div/div/table/tbody/tr/td[9]/div", 30);
            selenium.Focus("//div[@id='gridPurchasePlan']/div/div/div/div/div[2]/div/div/table/tbody/tr/td[9]/div");
            selenium.TypeKeys("cbPartner", "");
            selenium.MouseDownRight("cbPartner");
            WatiForElement("//body[@class='ext-gecko ext-gecko3']/div[17]/div/div/h3", 30);
            selenium.Click("//body[@class='ext-gecko ext-gecko3']/div[17]/div/div/h3");
            selenium.MouseDownRight("//body[@class='ext-gecko ext-gecko3']/div[17]/div/div/h3");//选择供应商


            WatiForClick("//div[@id='gridPurchasePlan']/div/div/div/div/div[2]/div/div/table/tbody/tr/td[18]/div", 30);
            selenium.TypeKeys("PriceInput", "10"); //输入单价
            WatiForClick("//div[@id='gridPurchasePlan']/div/div/div/div/div[2]/div/div/table/tbody/tr/td[25]/div", 30);
            selenium.TypeKeys("dateRequest", "2011/2/11");//输入需求时间
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_btnSave']/tbody/tr/td[2]/em/button"); //保存
            WatiForElement("//div[@id='ctl00_contentPlaceHolder_Panel4']/div/div/div/div/div/div/div/div[2]/div/div/table/tbody/tr/td", 30);
            selenium.MouseDown("//div[@id='ctl00_contentPlaceHolder_Panel4']/div/div/div/div/div/div/div/div[2]/div/div/table/tbody/tr/td/div/div");//checked订单
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_btnNewOrder1']/tbody/tr/td[2]/em/button");//点击创建订单

            WatiForElement("//div[@class='x-panel-btns x-panel-btns-center']/table/tbody/tr/td[2]/table/tbody/tr/td[2]/em/button", 20);
            selenium.Click("//div[@class='x-panel-btns x-panel-btns-center']/table/tbody/tr/td[2]/table/tbody/tr/td[2]/em/button");
            WatiForElement("//div[@class='x-panel-btns x-panel-btns-center']/table/tbody/tr/td/table/tbody/tr/td[2]/em/button", 20);
            selenium.Click("//div[@class='x-panel-btns x-panel-btns-center']/table/tbody/tr/td/table/tbody/tr/td[2]/em/button");//确定生成订单

            selenium.Open(url + "/Portal/HomePage/HomeFrame.aspx");
            selenium.Click("//input[@id='ibLogout']"); //logout
        }


        [Test]

        public void Step03集采订单()
        {
            selenium.Click("link=LOGIN");
            selenium.Type("txtUsername", "EEKA_it0001");
            WatiForClick("ext-gen67", 30);// user(EEKA_it0001) login

            WatiForClick("ext-gen65", 30); //选择采购管理
            selenium.Open(url + "/Portal/PU/PurchaseOrderSummary.aspx?IsTPCreate=Y");

            WatiForElement("//img[@class='x-form-trigger x-form-arrow-trigger']", 20);
            selenium.Click("//img[@class='x-form-trigger x-form-arrow-trigger']");

            WatiForElement("//div[@class='x-layer x-combo-list']/div/div[2]", 20);
            selenium.Click("//div[@class='x-layer x-combo-list']/div/div[2]");
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_btnSearch']/tbody/tr/td[2]/em/button");//search输入状态的订单

            WatiForElement("//div[@id='OrderSummary']", 20);
            selenium.Click("//div[@id='OrderSummary']/div/div/div/div/div[2]/div/div/table/tbody/tr/td[3]/div/a");

            WatiForElement("//table[@id='ctl00_contentPlaceHolder_uxSaveButton']/tbody/tr/td[2]/em/button", 20);
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_uxSaveButton']/tbody/tr/td[2]/em/button");//保存

            WatiForElement("//table[@id='ctl00_contentPlaceHolder_uxSubmitButton']/tbody/tr/td[2]/em/button", 20);
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_uxSubmitButton']/tbody/tr/td[2]/em/button");//提交

            selenium.Open(url + "/Portal/HomePage/HomeFrame.aspx");
            selenium.Click("//input[@id='ibLogout']"); //logout

        }

        [Test]
        public void Step04收货()
        {
            selenium.Click("link=LOGIN");
            selenium.Type("txtUsername", "logistics_it0001");
            WatiForClick("ext-gen67", 30);// 物流用户(logistics_it0001) login

            selenium.Open(url + "/Portal/PU/GRFromOrderSummary.aspx?IsLogistics=Y");//按订单收货

            WatiForElement("//div[@id='GridGRFromOrderSummary']/div/div/div/div/div[2]/div/div/table/tbody/tr/td[11]/div/div/table/tbody/tr/td/table/tbody/tr/td[2]/em/button", 20);
            selenium.Click("//div[@id='GridGRFromOrderSummary']/div/div/div/div/div[2]/div/div/table/tbody/tr/td[11]/div/div/table/tbody/tr/td/table/tbody/tr/td[2]/em/button");//收货

            WatiForElement("//table[@id='ctl00_contentPlaceHolder_uxSaveButton']/tbody/tr/td[2]/em/button", 20);
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_uxSaveButton']/tbody/tr/td[2]/em/button");//保存
            WatiForElement("//div[@class='x-panel-btns x-panel-btns-center']/table/tbody/tr/td/table/tbody/tr/td[2]/em/button",20);
            selenium.Click("//div[@class='x-panel-btns x-panel-btns-center']/table/tbody/tr/td/table/tbody/tr/td[2]/em/button");//确认保存
            Thread.Sleep(600);
            

            WatiForElement("//div[@id='GridGRDetailSummary']/div/div/div/div/div[2]/div/div/table/tbody/tr/td[13]/div", 20);
            selenium.Click("//div[@id='GridGRDetailSummary']/div/div/div/div/div[2]/div/div/table/tbody/tr/td[13]/div");
            WatiForElement("//div[@id='GridGRDetailSummary']/div/div/div/div/div[2]/div[2]/div/img", 20);
            selenium.Click("//div[@id='GridGRDetailSummary']/div/div/div/div/div[2]/div[2]/div/img");
            WatiForElement("//div[@class='x-layer x-combo-list']/div/div", 20);
            selenium.Click("//div[@class='x-layer x-combo-list']/div/div");//选择存储区域

            WatiForElement("//table[@id='ctl00_contentPlaceHolder_uxEnterFulfilled']/tbody/tr/td[2]/em/button", 20);
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_uxEnterFulfilled']/tbody/tr/td[2]/em/button");//输入提交
            

            //selenium.Open(url + "Portal/PU/GRSummary.aspx?IsLogistics=Y");//收货单管理

            selenium.Open(url + "/Portal/HomePage/HomeFrame.aspx");
            selenium.Click("//input[@id='ibLogout']"); //logout
        }

        [Test]
        public void Step05入库检配()
        {
            selenium.Click("link=LOGIN");
            selenium.Type("txtUsername", "logistics_it0001");
            WatiForClick("ext-gen67", 30);// 物流用户(logistics_it0001) login

            selenium.Open(url+"/Portal/IM/PickingMgmt/CheckInPicking.aspx?IOFlag=I");//入库检配

            WatiForElement("//div[@id='ctl00_contentPlaceHolder_pnlStatus']/div/div/div/div[1]/img", 20);
            selenium.Click("//div[@id='ctl00_contentPlaceHolder_pnlStatus']/div/div/div/div[1]/img");
            WatiForElement("//div[@class='x-layer x-combo-list']/div/div[2]", 20);
            selenium.Click("//div[@class='x-layer x-combo-list']/div/div[2]");
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_btnSearch']/tbody/tr/td[2]/em/button");// search输入提交状态的收货单

            selenium.Click("//div[@class='x-grid3-row x-grid3-row-first']/table/tbody/tr/td[16]/div/div/table/tbody/tr/td/table/tbody/tr/td[2]/em/button");//点击配货

            WatiForElement("//table[@id='ctl00_contentPlaceHolder_btnInvGetInAlloc']/tbody/tr/td[2]/em/button", 20);
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_btnInvGetInAlloc']/tbody/tr/td[2]/em/button");//点击配货

            WatiForElement("//table[@id='ctl00_contentPlaceHolder_ctrInvAssorting_btnInsert']", 20);
            selenium.SelectFrame("uxAllocTab_IFrame");
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_ctrInvAssorting_btnInsert']/tbody/tr/td[2]/em/button");//新建

            WatiForElement("//div[@class='x-grid3-viewport']/div[2]/div/div/table/tbody/tr/td[5]/div", 20);
            selenium.Click("//div[@class='x-grid3-viewport']/div[2]/div/div/table/tbody/tr/td[5]/div");
            selenium.MouseDown("//div[@class='x-grid3-viewport']/div[2]/div/div/table/tbody/tr/td[5]/div");
            WatiForElement("ctl00_contentPlaceHolder_ctrInvAssorting_txtLocation", 20);
            selenium.Type("ctl00_contentPlaceHolder_ctrInvAssorting_txtLocation", "5E28C03");//输入库位码

            WatiForElement("//div[@class='x-grid3-viewport']/div[2]/div/div/table/tbody/tr/td[7]/div", 20);
            selenium.Click("//div[@class='x-grid3-viewport']/div[2]/div/div/table/tbody/tr/td[7]/div");
            //string qty = selenium.GetText("//input[@id='ctl00_contentPlaceHolder_ctrInvAssorting_txtAQty']");
            selenium.Type("ctl00_contentPlaceHolder_ctrInvAssorting_txtQty", "100");//输入入库数量

            selenium.Click("//table[@id='ctl00_contentPlaceHolder_ctrInvAssorting_btnSave']/tbody/tr/td[2]/em/button");//保存

            selenium.Open(url + "/Portal/IM/PickingMgmt/CheckInPicking.aspx?IOFlag=I");
            WatiForElement("//div[@id='ctl00_contentPlaceHolder_pnlStatus']/div/div/div/div[1]/img", 20);
            selenium.Click("//div[@id='ctl00_contentPlaceHolder_pnlStatus']/div/div/div/div[1]/img");
            WatiForElement("//div[@class='x-layer x-combo-list']/div/div[2]", 20);
            selenium.Click("//div[@class='x-layer x-combo-list']/div/div[2]");
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_btnSearch']/tbody/tr/td[2]/em/button");// search输入提交状态的收货单

            selenium.Click("//div[@class='x-grid3-row x-grid3-row-first']/table/tbody/tr/td[16]/div/div/table/tbody/tr/td/table/tbody/tr/td[2]/em/button");//点击配货

            WatiForElement("//table[@id='ctl00_contentPlaceHolder_uxSubmitButton']/tbody/tr/td[2]/em/button", 20);
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_uxSubmitButton']/tbody/tr/td[2]/em/button");//提交

            selenium.Open(url + "/Portal/HomePage/HomeFrame.aspx");
            selenium.Click("//input[@id='ibLogout']"); //logout
        }

        [Test]

        public void Step06收货()
        {
            selenium.Click("link=LOGIN");
            selenium.Type("txtUsername", "logistics_it0001");
            WatiForClick("ext-gen67", 30);// 物流用户(logistics_it0001) login

            selenium.Open(url + "/Portal/IM/PickingMgmt/CheckInPicking.aspx?IOFlag=I");//入库检配

            WatiForElement("//div[@id='ctl00_contentPlaceHolder_pnlMMType']/div/div/div/div[1]/img", 20);
            selenium.Click("//div[@id='ctl00_contentPlaceHolder_pnlMMType']/div/div/div/div[1]/img");
            WatiForElement("//div[@class='x-layer x-combo-list']/div/div[9]", 20);
            selenium.Click("//div[@class='x-layer x-combo-list']/div/div[9]");//选择采购收货
            //selenium.Click("//table[@id='ctl00_contentPlaceHolder_btnSearch']/tbody/tr/td[2]/em/button");// search采购收货

            WatiForElement("//div[@id='ctl00_contentPlaceHolder_pnlStatus']/div/div/div/div[1]/img", 20);
            selenium.Click("//div[@id='ctl00_contentPlaceHolder_pnlStatus']/div/div/div/div[1]/img");
         
            WatiForElement("//body[@class='ext-gecko ext-gecko3']/div[8]/div/div[1]", 20);
            selenium.Click("//body[@class='ext-gecko ext-gecko3']/div[8]/div/div[1]");//选择开放状态
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_btnSearch']/tbody/tr/td[2]/em/button");// search开放状态的收货单

            WatiForElement("//div[@class='x-grid3-row x-grid3-row-first']/table/tbody/tr/td[2]/div/a", 20);
            selenium.Click("//div[@class='x-grid3-row x-grid3-row-first']/table/tbody/tr/td[2]/div/a");
            WatiForElement("//div[@class='x-grid3-row x-grid3-row-first x-grid3-row-last']/table/tbody/tr/td[6]/div", 20);
            String projectnumber = selenium.GetText("//div[@class='x-grid3-row x-grid3-row-first x-grid3-row-last']/table/tbody/tr/td[6]/div");//取得项目编号
            Console.WriteLine(projectnumber);

            selenium.Open(url + "/Portal/IM/PickingMgmt/CheckInPicking.aspx?IOFlag=I");//入库检配

            WatiForElement("//div[@id='ctl00_contentPlaceHolder_pnlMMType']/div/div/div/div[1]/img", 20);
            selenium.Click("//div[@id='ctl00_contentPlaceHolder_pnlMMType']/div/div/div/div[1]/img");
            WatiForElement("//div[@class='x-layer x-combo-list']/div/div[9]", 20);
            selenium.Click("//div[@class='x-layer x-combo-list']/div/div[9]");//选择采购收货
            WatiForElement("//div[@id='ctl00_contentPlaceHolder_pnlStatus']/div/div/div/div[1]/img", 20);
            selenium.Click("//div[@id='ctl00_contentPlaceHolder_pnlStatus']/div/div/div/div[1]/img");
            WatiForElement("//body[@class='ext-gecko ext-gecko3']/div[8]/div/div[1]", 20);
            selenium.Click("//body[@class='ext-gecko ext-gecko3']/div[8]/div/div[1]");//选择开放状态
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_btnSearch']/tbody/tr/td[2]/em/button");// search开放状态的收货单
            selenium.Click("//div[@class='x-grid3-row x-grid3-row-first']/table/tbody/tr/td[16]/div/div/table/tbody/tr/td[2]/table/tbody/tr/td[2]/em/button");//点击拣配

            WatiForElement("//div[@id='ctl00_contentPlaceHolder_ctl25']/table/tbody/tr/td/div/input", 20);

            selenium.SelectFrame("tabInAllocDetail_IFrame");

            WatiForElement("txtBarCode", 20);
            selenium.Type("txtBarCode",projectnumber);
            String Number = selenium.GetText("//div[@id='ctl00_contentPlaceHolder_grPickMatrix']/div/div/div/div/div[2]/div/div/table/tbody/tr/td[8]/div/div");

            selenium.Type("ctl00_contentPlaceHolder_txtNumber", Number);
     
            selenium.FireEvent("aspnetForm", "onkeypress");


            selenium.Submit("aspnetForm");
            
           
        }

    }
}