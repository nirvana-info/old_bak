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
    public class 门店调配:TestBase
    {
        [Test]
        public void A001_自营补货申请()
        {
            Userlogin("039164", "a123456");//门店用户登陆

            selenium.Open(url + "/Portal/PU/Order/ReplenishReqest.aspx?OrderRoleType=60&IsTransfer=Y&FromBrand=Mine"); //选择自营补货申请

            WatiForElement("//table[@id='ctl00_contentPlaceHolder_btnNew']/tbody/tr/td[2]/em/button", 20);
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_btnNew']/tbody/tr/td[2]/em/button");//新建

            WatiForElement("ctl00_contentPlaceHolder_uxSeller", 20);
            selenium.Click("ctl00_contentPlaceHolder_uxSeller");
            selenium.TypeKeys("ctl00_contentPlaceHolder_uxSeller","103");
            selenium.KeyDown("ctl00_contentPlaceHolder_uxSeller", "13");//选处理方

            WatiForElement("//div[@id='x-form-el-ctl00_contentPlaceHolder_uxShipmentMethod']/div/img", 10);
            selenium.Click("//div[@id='x-form-el-ctl00_contentPlaceHolder_uxShipmentMethod']/div/img");

            WatiForElement("data_table", 10);
            selenium.Click("//table[@id='data_table']/tbody/tr[6]/td/h3/span");//选择运输方式
     
            WatiForElement("//table[@id='ctl00_contentPlaceHolder_uxSaveButton']/tbody/tr/td[2]/em/button", 10);
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_uxSaveButton']/tbody/tr/td[2]/em/button");//保存
            selenium.MouseUpRight("//table[@id='ctl00_contentPlaceHolder_uxSaveButton']/tbody/tr/td[2]/em/button");

            WatiForElement("txtNewItemCode", 10);
            selenium.Type("txtNewItemCode", "X48B21015009");
            selenium.KeyUp("txtNewItemCode","13"); //输入项目编码

            Thread.Sleep(5000);
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_uxSaveButton']/tbody/tr/td[2]/em/button");//保存
            Thread.Sleep(5000);
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_uxSubmitButton']/tbody/tr/td[2]/em/button");//提交
        }


        [Test]
        public void A002_自营补货申请处理()
        {
            Userlogin("Y93667", "a123456");//商品经理登陆
            
            selenium.Open(url + "/Portal/SD/Order/ReplenishSummary.aspx?OrderRoleType=50&IsTransfer=Y");//选择自营补货申请处理
                  
            WatiForElement("//table[@id='ctl00_contentPlaceHolder_uxSaveButton']/tbody/tr/td[2]/em/button", 10);
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_btnSearch']/tbody/tr/td[2]/em/button");//查询

            Thread.Sleep(2000);
            selenium.Click("//TABLE[@class='x-btn-wrap x-btn x-btn-over']/tbody/tr/td[2]/em/button"); //点击编辑
            Thread.Sleep(5000);

            WatiForElement("//table[@id='ctl00_contentPlaceHolder_btnSave']/tbody/tr/td[2]/em/button", 10);
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_btnSave']/tbody/tr/td[2]/em/button");//保存
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_btnSubmit']/tbody/tr/td[2]/em/button");//保存并提交
        }

        [Test]
        public void A003_自营补货分货生成调拨计划()
        {
            Userlogin("Y93667", "a123456");//商品经理登陆

            selenium.Open(url + "/Portal/SD/Order/ReplenishSummary.aspx?OrderRoleType=50&IsTransfer=Y");//选择自营补货申请处理

            WatiForElement("//table[@id='ctl00_contentPlaceHolder_uxSaveButton']/tbody/tr/td[1]/em/button", 10);
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_btnSearch']/tbody/tr/td[2]/em/button");//查询

            Thread.Sleep(2000);
            selenium.Click("//TABLE[@class=' x-btn-wrap x-btn x-btn-over x-item-disabled']/tbody/tr/td[2]/em/button"); //点击补货
            Thread.Sleep(5000);

            selenium.SelectFrame("relative=up");
            WatiForElement("ctl00_contentPlaceHolder_pnlDetail_IFrame", 10);
            //selenium.SelectFrame("SplitOrderDetail_100429_IFrame");
            selenium.SelectFrame("ctl00_contentPlaceHolder_pnlDetail_IFrame");

            WatiForElement("//div[@class='x-grid3-hd-checker']", 10);
            selenium.MouseDown("//div[@class='x-grid3-hd-checker']");
    
            Thread.Sleep(5000);
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_btnGenOrder']/tbody/tr/td/table/tbody/tr/td[2]/button");//生成调拨计划
          
        
        }
        
        
        [Test]
        public void A004_自营补货编辑调拨计划()
        {
            Userlogin("Y93667", "a123456");//商品经理登陆
            selenium.Open(url + "/Portal/SD/Order/OrderSummary.aspx?OrderRoleType=10&IsTransfer=Y&Status=Edit&FromBrand=Mine");//进入编制调拨计划页面

            selenium.Click("//div[@id='ctl00_contentPlaceHolder_pnlCriteria']/div/div/div/div[8]/div/div/span/img[2]");
            WatiForElement("//body[@class='  ext-gecko ext-gecko3']/div[5]/div[@class='x-combo-list-inner']/div[2]", 10);
            selenium.Click("//body[@class='  ext-gecko ext-gecko3']/div[5]/div[@class='x-combo-list-inner']/div[2]"); //选择输入状态
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_btnSearch']/tbody/tr/td[2]/em/button");//查询

            Thread.Sleep(2000);
            selenium.Click("//table[@id='ext-comp-1078']/tbody/tr/td[2]/em/button");//点击补货

            WatiForElement("//table[@id='ctl00_contentPlaceHolder_btnSave']/tbody/tr/td[2]/em/button", 10);
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_btnSave']/tbody/tr/td[2]/em/button");//保存
            Thread.Sleep(5000);
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_btnSubmit']/tbody/tr/td[2]/em/button");//提交
        }


        [Test]
        public void A005_自营补货调拨计划审批()
        {
            Userlogin("Y93667", "a123456");//商品经理登陆

            selenium.Open(url + "/Portal/SD/Order/OrderSummary.aspx?OrderRoleType=10&IsTransfer=Y&MsgTypeCode=1248");//进入调拨计划审批页面

            WatiForElement("//div[@id='ctl00_contentPlaceHolder_pnlCriteria']/div/div/div/div[8]/div/div/span/img[2]", 10);
            selenium.Click("//div[@id='ctl00_contentPlaceHolder_pnlCriteria']/div/div/div/div[8]/div/div/span/img[2]");
            WatiForElement("//body[@class='  ext-gecko ext-gecko3']/div[5]/div[@class='x-combo-list-inner']/div[3]", 10);
            selenium.Click("//body[@class='  ext-gecko ext-gecko3']/div[5]/div[@class='x-combo-list-inner']/div[3]"); //选择待批状态
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_btnSearch']/tbody/tr/td[2]/em/button");//查询
            Thread.Sleep(2000);
            WatiForElement("//div[@id='gpSalesOrder']", 10);
            selenium.Click("//div[@id='gpSalesOrder']/div/div/div/div/div[2]/div/div/table/tbody/tr/td[4]/div/a"); //点击编辑

            WatiForElement("//table[@id='ctl00_contentPlaceHolder_btnAccept']/tbody/tr/td/table/tbody/tr/td[2]/button", 10);
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_btnAccept']/tbody/tr/td/table/tbody/tr/td[2]/button");//同意


        }

        [Test]
        public void A006_自营补货生成发货单()
        {
            Userlogin("yxzxadmin", "a123456");//营销中心登陆

            selenium.Open(url + "/Portal/SD/DNGenerate.aspx#");//进入生成发货单页面
            WatiForElement("//div[@class='x-grid3-row-checker']", 10);
            selenium.MouseDown("//div[@class='x-grid3-row-checker']"); //checked第一条单

            Thread.Sleep(3000);
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_uxGenerateBtn']/tbody/tr/td[2]/em/button"); //发货
        }



        [Test]
        public void A007_自营退货申请()
        {
            Userlogin("039164", "a123456");//门店用户登录

            selenium.Open(url + "/Portal/PU/Order/ReplenishReqest.aspx?OrderRoleType=80&IsTransfer=Y&FromBrand=Mine");//选择自营退货申请

            WatiForElement("//table[@id='ctl00_contentPlaceHolder_btnNew']/tbody/tr/td[2]/em/button", 20);
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_btnNew']/tbody/tr/td[2]/em/button");//新建

            WatiForElement("ctl00_contentPlaceHolder_uxSeller", 20);
            selenium.Click("ctl00_contentPlaceHolder_uxSeller");
            selenium.TypeKeys("ctl00_contentPlaceHolder_uxSeller", "103");
            selenium.KeyDown("ctl00_contentPlaceHolder_uxSeller", "13" );//选择处理方

            WatiForElement("//div[@id='x-form-el-ctl00_contentPlaceHolder_uxShipmentMethod']/div/img",10);
            selenium.Click("//div[@id='x-form-el-ctl00_contentPlaceHolder_uxShipmentMethod']/div/img"); //选择运输方式

            WatiForElement("data_table", 10);
            selenium.Click("//table[@id='data_table']/tbody/tr[6]/td/h3/span");//选择运输方式

            WatiForElement("//table[@id='ctl00_contentPlaceHolder_uxSaveButton']/tbody/tr/td[2]/em/button", 20);
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_uxSaveButton']/tbody/tr/td[2]/em/button");//保存
            selenium.MouseUpRight("//table[@id='ctl00_contentPlaceHolder_uxSaveButton']/tbody/tr/td[2]/em/button");

            WatiForElement("txtNewItemCode", 10);
            selenium.Type("txtNewItemCode", "X48B21015009");
            selenium.KeyUp("txtNewItemCode", "13"); //输入项目编码

            Thread.Sleep(5000);
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_uxSaveButton']/tbody/tr/td[2]/em/button");//保存
            Thread.Sleep(5000);
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_uxSubmitButton']/tbody/tr/td[2]/em/button");//提交
        }


        [Test]
        public void A008_自营退货申请处理()
        {
            Userlogin("Y93667", "a123456");//商品经理登陆

            selenium.Open(url + "/Portal/SD/Order/ReplenishSummary.aspx?OrderRoleType=70&IsTransfer=Y");//进入自营退货申请页面

            WatiForElement("//div[@id='x-form-el-ctl00_contentPlaceHolder_uxStatus']/div/span/img[2]", 20);
            selenium.Click("//div[@id='x-form-el-ctl00_contentPlaceHolder_uxStatus']/div/span/img[2]");
            WatiForElement("//body[@class='  ext-gecko ext-gecko3']/div[5]/div[@class='x-combo-list-inner']/div[5]", 10);
            selenium.Click("//body[@class='  ext-gecko ext-gecko3']/div[5]/div[@class='x-combo-list-inner']/div[5]"); //选择开放状态

            selenium.Click("//table[@id='ctl00_contentPlaceHolder_btnSearch']/tbody/tr/td[2]/em/button");//search

            selenium.Click("//TABLE[@class='x-btn-wrap x-btn x-btn-over']/tbody/tr/td[2]/em/button");//编辑


            WatiForElement("//table[@id='ctl00_contentPlaceHolder_btnSave']/tbody/tr/td[2]/em/button", 10);
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_btnSave']/tbody/tr/td[2]/em/button");//保存
            Thread.Sleep(3000);
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_btnSubmit']/tbody/tr/td[2]/em/button");//保存并提交
        }

        [Test]
        public void A009_自营退货分货生成调拨计划()
        {
            Userlogin("Y93667", "a123456");//商品经理登陆

            WatiForElement(WebObject.sptp, 10);
            selenium.Click(WebObject.sptp);//click 商品调配菜单

            selenium.SelectFrame("tabMenu_IFrame");
            WatiForElement("ctl00_contentPlaceHolder_ctl08_IFrame", 10);
            selenium.SelectFrame("ctl00_contentPlaceHolder_ctl08_IFrame");
            WatiForElement(WebObject.zythsq, 10);
            selenium.Click(WebObject.zythsq);//自营退货货申请处理菜单

            selenium.SelectFrame("relative=up");
            selenium.SelectFrame("relative=up");
            WatiForElement("idCltT0303_IFrame", 10);
            selenium.SelectFrame("idCltT0304_IFrame");
            WatiForElement("ctl00_contentPlaceHolder_startDate", 10);
            selenium.Type("ctl00_contentPlaceHolder_startDate", DateTime.Today.ToString("yyyy/MM/dd"));//输入查询日期

            WatiForElement("//div[@id='x-form-el-ctl00_contentPlaceHolder_uxStatus']/div/span/img[2]", 20);
            selenium.Click("//div[@id='x-form-el-ctl00_contentPlaceHolder_uxStatus']/div/span/img[2]");
            WatiForElement("//body[@class='  ext-gecko ext-gecko3']/div[4]/div[@class='x-combo-list-inner']/div[9]", 10);
            selenium.Click("//body[@class='  ext-gecko ext-gecko3']/div[4]/div[@class='x-combo-list-inner']/div[9]"); //选择接受状态
            selenium.Click("ctl00_contentPlaceHolder_cbBuyer");
            selenium.TypeKeys("ctl00_contentPlaceHolder_cbBuyer", "10305");
            WatiForElement("//h3", 10);
            selenium.Click("//h3"); //输入申请方
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_btnSearch']/tbody/tr/td[2]/em/button");//查询
            Thread.Sleep(6000);

            selenium.Click("//TABLE[@class='x-btn-wrap x-btn x-btn-over']/tbody/tr/td[2]/em/button"); //点击分货

            selenium.SelectFrame("relative=up");
            WatiForElement("ctl00_contentPlaceHolder_pnlDetail_IFrame", 10);
            //selenium.SelectFrame("SplitOrderDetail_100429_IFrame");
            selenium.SelectFrame("ctl00_contentPlaceHolder_pnlDetail_IFrame");

            WatiForElement("//div[@class='x-grid3-hd-checker']", 10);
            selenium.MouseDown("//div[@class='x-grid3-hd-checker']");

            Thread.Sleep(5000);
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_btnGenOrder']/tbody/tr/td/table/tbody/tr/td[2]/button");//生成退货调拨计划

            selenium.SelectFrame("relative=up");
            WatiForElement("uxDetailTab_IFrame", 10);
            selenium.SelectFrame("uxDetailTab_IFrame");

            Console.Write("调拨单号: " + "//input[@id='ctl00_contentPlaceHolder_uxOrderCode']"); //输出调拨单号
        }

        [Test]
        public void A010_自营退货编辑调拨计划()
        {

            Userlogin("Y93667", "a123456");//商品经理登陆
            selenium.Open(url + "/Portal/SD/Order/OrderSummary.aspx?OrderRoleType=30&IsTransfer=Y&Status=Edit&FromBrand=Mine");//进入编制调拨计划页面

            selenium.Click("//div[@id='ctl00_contentPlaceHolder_pnlCriteria']/div/div/div/div[8]/div/div/span/img[2]");
            WatiForElement("//body[@class='  ext-gecko ext-gecko3']/div[5]/div[@class='x-combo-list-inner']/div[2]", 10);
            selenium.Click("//body[@class='  ext-gecko ext-gecko3']/div[5]/div[@class='x-combo-list-inner']/div[2]"); //选择输入状态
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_btnSearch']/tbody/tr/td[2]/em/button");//查询
            Thread.Sleep(2000);
            selenium.Click("//TABLE[@class='x-btn-wrap x-btn x-btn-over']/tbody/tr/td[2]/em/button"); //点击编辑

            WatiForElement("//table[@id='ctl00_contentPlaceHolder_btnSave']/tbody/tr/td[2]/em/button", 10);
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_btnSave']/tbody/tr/td[2]/em/button");//保存
            Thread.Sleep(5000);
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_btnSubmit']/tbody/tr/td[2]/em/button");//提交

        }



        [Test]
        public void A011_自营退货调拨计划审核()
        {
            Userlogin("Y93667", "a123456");//商品经理登陆

            selenium.Open(url + "/Portal/SD/Order/OrderSummary.aspx?OrderRoleType=30&IsTransfer=Y&MsgTypeCode=1250");//进入调拨退货审批页面

            WatiForElement("//div[@id='ctl00_contentPlaceHolder_pnlCriteria']/div/div/div/div[8]/div/div/span/img[2]", 10);
            selenium.Click("//div[@id='ctl00_contentPlaceHolder_pnlCriteria']/div/div/div/div[8]/div/div/span/img[2]");
            WatiForElement("//body[@class='  ext-gecko ext-gecko3']/div[5]/div[@class='x-combo-list-inner']/div[3]", 10);
            selenium.Click("//body[@class='  ext-gecko ext-gecko3']/div[5]/div[@class='x-combo-list-inner']/div[3]"); //选择待批状态
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_btnSearch']/tbody/tr/td[2]/em/button");//查询
            Thread.Sleep(2000);
            WatiForElement("//div[@id='gpSalesOrder']", 10);
            selenium.Click("//div[@id='gpSalesOrder']/div/div/div/div/div[2]/div/div/table/tbody/tr/td[4]/div/a"); //点击编辑

            WatiForElement("//table[@id='ctl00_contentPlaceHolder_btnAccept']/tbody/tr/td/table/tbody/tr/td[2]/button", 10);
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_btnAccept']/tbody/tr/td/table/tbody/tr/td[2]/button");//同意

        }


        [Test]
        public void A012_自营退货生成发货单()
        {
            Userlogin("039164", "a123456");//门店用户登陆

            selenium.Open(url + "/Portal/SD/DNGenerate.aspx");//进入生成发货单页面
            WatiForElement("//div[@class='x-grid3-row-checker']", 10);
            selenium.MouseDown("//div[@class='x-grid3-row-checker']"); //checked第一条单
            WatiForElement("//div[@id='OrderDetailPlanView']/div/div/div/div/div[2]/div/div/table/tbody/tr/td[3]/div/a", 10);
            string snumber = selenium.GetText("//div[@id='OrderDetailPlanView']/div/div/div/div/div[2]/div/div/table/tbody/tr/td[3]/div/a"); //got计划单号
            Console.Write("计划单号为: " + snumber);
            Thread.Sleep(3000);
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_uxGenerateBtn']/tbody/tr/td[2]/em/button"); //发货
          }

        [Test]
        public void A013_自营退货发货单配货()
        {
            Userlogin("039164", "a123456");//门店用户登陆
            selenium.Open(url + "/Portal/SD/DNSummary.aspx");//进入生成发货单页面

            WatiForElement("//TABLE[@class='x-btn-wrap x-btn x-btn-over']/tbody/tr/td[2]/em/button", 10);
            selenium.Click("//TABLE[@class='x-btn-wrap x-btn x-btn-over']/tbody/tr/td[2]/em/button");//编辑

            WatiForElement("//TABLE[@id='ctl00_contentPlaceHolder_uxSaveButton']/tbody/tr/td[2]/em/button", 10);
            selenium.Click("//TABLE[@id='ctl00_contentPlaceHolder_uxSaveButton']/tbody/tr/td[2]/em/button");//保存
            Thread.Sleep(3000);
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_uxSubmitButton']/tbody/tr/td[2]/em/button"); //提交
            Thread.Sleep(3000);
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_btnAutoAlloc']/tbody/tr/td[2]/em/button"); //自动配货
        }

        [Test]
        public void A014_自营退货收货()
        {
            Userlogin("000111", "a123456");//物流中心用户登陆

            selenium.Open(url + "/Portal/SD/DNSummaryForGR.aspx?IsLogistics=Y");//进入调入页面
            WatiForElement("//table[@class='x-btn-wrap x-btn x-btn-over']/tbody/tr/td[2]/em/button", 10);
            selenium.Click("//table[@class='x-btn-wrap x-btn x-btn-over']/tbody/tr/td[2]/em/button"); //点击收货

            WatiForElement("//table[@id='ctl00_contentPlaceHolder_uxSaveButton']/tbody/tr/td[2]/em/button", 10);
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_uxSaveButton']/tbody/tr/td[2]/em/button"); //保存
            Thread.Sleep(3000);

            WatiForElement("uxDetailTab_IFrame", 10);
            selenium.SelectFrame("uxDetailTab_IFrame");
            WatiForElement("//TABLE[@class='x-btn-wrap x-btn ']/tbody/tr/td[2]/em/button", 10);
            selenium.Click("//TABLE[@class='x-btn-wrap x-btn ']/tbody/tr/td[2]/em/button");//确认保存

            Thread.Sleep(2000);
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_btnInvGetInAlloc']/tbody/tr/td[2]/em/button");//配货
            Thread.Sleep(6000);
            selenium.SelectFrame("relative=up");
            WatiForElement("uxAllocTab_IFrame", 10);

            WatiForElement("//div[@id='ctl00_contentPlaceHolder_ctrInvAssorting_GPEdit']/div/div/div/div/div[2]/div/div/table/tbody/tr/td[7]/div", 10);
            selenium.Click("//div[@id='ctl00_contentPlaceHolder_ctrInvAssorting_GPEdit']/div/div/div/div/div[2]/div/div/table/tbody/tr/td[7]/div");
            selenium.Type("//div[@id='ctl00_contentPlaceHolder_ctrInvAssorting_GPEdit']/div/div/div/div/div[2]/div/div/table/tbody/tr/td[7]/div","1");
            selenium.KeyDown("//div[@id='ctl00_contentPlaceHolder_ctrInvAssorting_GPEdit']/div/div/div/div/div[2]/div/div/table/tbody/tr/td[7]/div", "13");
            //selenium.TypeKeys("ctl00_contentPlaceHolder_ctrInvAssorting_txtQty", "1");//修改入库数量

            selenium.Click("//TABLE[@id='ctl00_contentPlaceHolder_ctrInvAssorting_btnSave']/tbody/tr/td[2]/em/button"); //保存
        }
    }
}
