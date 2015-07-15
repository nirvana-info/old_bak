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
    public class 零售:TestBase
    {
   
        public string UserNo;

        [Test]
        public void R001_会员管理()
        { 
            Userlogin("023241", "a123456");//门店用户登录
           
            WatiForElement("imgLogout", 20);     //检查login成功
            selenium.Open(url1 + "/HomePage/PopMenu.aspx?id=220");//选择零售管理
            selenium.Open(url1 + "/RT/VipDetail.aspx?mode=Add");//新建会员
            Thread.Sleep(3000);
            Random rd = new Random();
            string TN1 = "0" + rd.Next(1, 10);
            string TN2 = "0" + rd.Next(11, 20);
            string TN3 = "00" + rd.Next(21, 40);
            WatiForElement("//input[@id='ctl00_contentPlaceHolder_uxLastName']", 20);
            selenium.Type("//input[@id='ctl00_contentPlaceHolder_uxFirstName']", "Test" + TN1);//输入会员姓名
            selenium.Type("ctl00_contentPlaceHolder_uxSearchKey", "13482288286");//输入手机号
         
            Thread.Sleep(6000);
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_btnSave']/tbody/tr/td[2]/em/button");//保存
            Thread.Sleep(6000);
            selenium.SelectFrame("ctl00_contentPlaceHolder_tabVipBaseInfo_IFrame");
            WatiForElement("//div[@class='x-panel-btns-ct']/div/table/tbody/tr/td/TABLE/tbody/tr/td[2]/em/button",10);
            selenium.Click("//div[@class='x-panel-btns-ct']/div/table/tbody/tr/td/TABLE/tbody/tr/td[2]/em/button");//确认保存
            Thread.Sleep(3000);

            selenium.Open(url1 + "/RT/VipAdvancedSearch.aspx"); //进入会员查询
            selenium.Type("ctl00_contentPlaceHolder_uxInitialDate1", DateTime.Today.ToString("yyyy/MM/dd"));
            selenium.Type("ctl00_contentPlaceHolder_uxInitialDate2", DateTime.Today.ToString("yyyy/MM/dd"));
            selenium.Click("ctl00_contentPlaceHolder_btnSearch");
            Thread.Sleep(3000);
            string GetSearchUserNo = selenium.GetText("//div[@class='x-grid3-row  x-grid3-row-first x-grid3-row-last']/table/tbody/tr/td[4]/div/a");//get查询结果的第一条数据
            Console.Write("新建会员卡号： " + GetSearchUserNo);
            Assert.AreEqual("13482288286", selenium.GetText("//div[@class='x-grid3-row  x-grid3-row-first x-grid3-row-last']/table/tbody/tr/td[13]/div"));//检查是否查询到新建的会员

        }

        [Test]
        public void R002_新建储蓄卡以及冲值()
        {
            Userlogin("yxzxadmin","a123456");//门店用户登录

            selenium.Open(url + "/Portal/RT/CardMgmt.aspx");
            WatiForElement("//table[@id='ctl00_contentPlaceHolder_btnNew']/tbody/tr/td[2]/em/button", 20);
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_btnNew']/tbody/tr/td[2]/em/button");//点击新建

            WatiForElement("uxCardNumber", 20);
            Random rd = new Random();
            string cardnumber = "000000" + rd.Next(1, 100);
            Console.Write("新建卡卡号为：" + cardnumber);
            selenium.Type("uxCardNumber", cardnumber);//输入新建卡卡号

            selenium.Click("//div[@id='x-form-el-uxcbCardCategory']/div/img");
            WatiForElement("//table[@id='data_table']/tbody/tr[2]/td[2]", 20);
            selenium.Click("//table[@id='data_table']/tbody/tr[2]/td[2]");//选择分类

            WatiForElement("//table[@id='btnSave']/tbody/tr/td[2]/em/button", 20);
            selenium.Click("//table[@id='btnSave']/tbody/tr/td[2]/em/button");//保存新建储蓄卡

            selenium.Open(url + "/Portal/RT/CardMgmt.aspx");
            selenium.Type("ctl00_contentPlaceHolder_uxCardNo", cardnumber);
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_btnSearch']/tbody/tr/td[2]/em/button");//根据卡号查询新建的储蓄卡
            Thread.Sleep(2000);
            Assert.AreEqual(cardnumber, selenium.GetText("//div[@class='x-grid3-row  x-grid3-row-first x-grid3-row-last']/table/tbody/tr/td[4]/div/a"));//在结果中能过找到新建储蓄卡卡号
            Userlogout();

            Userlogin("023241", "a123456");
            //selenium.Open(url1 + "/RT/PrepaidRecharge.aspx");//进入开卡充值页面
            //selenium.Type("ctl00_contentPlaceHolder_txtSearchKey", "13918865065");//输入手机号码
            //selenium.Click("ctl00_hiddenButton");
            //selenium.KeyPress("//input[@id='ctl00_contentPlaceHolder_txtSearchKey']", "13");
            //selenium.KeyDown("//input[@id='ctl00_contentPlaceHolder_txtSearchKey']", "13");//enter key

            selenium.Open(url + "/Portal/RT/CardRechargeMgmt.aspx?Type=Deposit");//进入充值页面
            WatiForElement("ctl00_contentPlaceHolder_raCard", 20);
            selenium.Click("ctl00_contentPlaceHolder_raCard");
            WatiForElement("//input[@id='ctl00_contentPlaceHolder_txtCardNo']", 20);
            selenium.Type("//input[@id='ctl00_contentPlaceHolder_txtCardNo']", cardnumber);//输入储蓄卡卡号
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_btnserach']/tbody/tr/td[2]/em/button");//查询

            WatiForElement("//table[@class='x-btn-wrap x-btn x-btn-text-icon x-btn-over']/tbody/tr/td[2]/em/button", 20);
            selenium.Click("//table[@class='x-btn-wrap x-btn x-btn-text-icon x-btn-over']/tbody/tr/td[2]/em/button");
            selenium.MouseDown("//table[@class='x-btn-wrap x-btn x-btn-text-icon x-btn-over']/tbody/tr/td[2]/em/button");//点击冲值
            Thread.Sleep(2000);

            WatiForElement("//div[@id='x-form-el-ctl00_contentPlaceHolder_ctrlDepositCard_cbCardAccount']/div/img", 20);
            selenium.Click("//div[@id='x-form-el-ctl00_contentPlaceHolder_ctrlDepositCard_cbCardAccount']/div/img");
            WatiForElement("//table[@id='Table1']/tbody/tr/td", 20);
            selenium.Click("//table[@id='Table1']/tbody/tr/td");//选择帐户类型为冲值

            selenium.Type("ctl00_contentPlaceHolder_ctrlDepositCard_uxInvoiceNo", "111111");//输入收银小票
            selenium.Type("ctl00_contentPlaceHolder_ctrlDepositCard_uxAmount", "10000");//输入冲值金额
            selenium.Type("ctl00_contentPlaceHolder_ctrlDepositCard_txtFirstPwd", "123456");//输入密码
            selenium.Type("ctl00_contentPlaceHolder_ctrlDepositCard_txtConfrimPwd", "123456");//输入确认密码

            selenium.Click("//table[@id='ctl00_contentPlaceHolder_ctrlDepositCard_btnSaveSub']/tbody/tr/td[2]/em/button");//保存
            Thread.Sleep(2000);
            Console.Write("储蓄卡充值金额为：" + selenium.GetText("//div[@class='x-grid3-cell-inner x-grid3-col-ColTotalAmount']"));
            Assert.AreEqual("10,000", selenium.GetText("//div[@class='x-grid3-cell-inner x-grid3-col-ColTotalAmount']")); //检查储蓄卡充值值是否正确
        }
        


        [Test]
        public void R003_零售收银_储值卡()
        {

            Userlogin("023241","a123456");

            selenium.Open(url + "/POS/POSVoucher.aspx");

            selenium.Click("viewmember");

            WatiForElement("searchKey", 20);
            selenium.Type("searchKey", "13090180030");//输入手机号
            selenium.Type("membershipCardNo", "00000042");//输入vip卡号

            WatiForElement("itemCode", 20);
            selenium.Type("itemCode", "X10C01290207");//输入商品编码
            selenium.KeyDown("itemCode", "13");
            selenium.Click("posVoucherConfirm");
            WatiForElement("deductionConfirm", 20);
            selenium.Click("deductionConfirm");

            WatiForElement("//div[@id='collectionType']/ul/li[6]/a",20);
            selenium.Click("//div[@id='collectionType']/ul/li[6]/a");
            selenium.Type("vipPIN","123456");
            selenium.Type("collectionAmount", selenium.GetText("//div[@id='collectionDialog']/form/fieldset/table/tbody/tr[3]/td[3]/div[2]/div"));
            selenium.Click("btnAddCollectionItem");

            selenium.Click("confirm");//提交
        }

        [Test]
        public void R004_零售收银_现金()
        {
            Userlogin("023241", "a123456");

            selenium.Open(url + "/POS/POSVoucher.aspx");
           

            WatiForElement("searchKey", 20);
            selenium.Type("searchKey", "13482288286");//输入手机号
            //selenium.Click("viewmember");//click查询

            WatiForElement("itemCode", 20);
            selenium.Type("itemCode", "X11C61280109");//输入商品编码
            selenium.KeyDown("itemCode", "13");
            Thread.Sleep(2000);
            string RetailNo = selenium.GetText("posVoucherCode");
            Console.Write("销售小票代码: "+RetailNo);

            selenium.Click("posVoucherConfirm");
            WatiForElement("deductionConfirm", 20);
            selenium.Click("deductionConfirm");

            WatiForElement("//div[@id='collectionType']/ul/li[2]/a", 20);
            selenium.Click("//div[@id='collectionType']/ul/li[2]/a");//选择现金收银

            string amount = selenium.GetText("needPay");
            selenium.Type("collectionAmount",amount);//输入现金金额
            selenium.Click("btnAddCollectionItem");//添加

            selenium.Click("confirm");//收款完成

            selenium.Open(url1 + "/EIS/SalesReports/PosDetail.aspx");//进入收银查询页面
            WatiForElement("ctl00_contentPlaceHolder_txtPosCode", 10);
            selenium.Type("ctl00_contentPlaceHolder_txtPosCode",RetailNo);//输入销售小票代码
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_btnserach']/tbody/tr/td[2]/em/button");//查询


        }

        [Test]
        public void R005_零售退货()
        {
            Userlogin("023241", "a123456");

            selenium.Open(url + "/POS/POSVoucher.aspx");
            WatiForElement("searchKey", 20);
            selenium.Type("searchKey", "13482288286");//输入手机号
            WatiForElement("itemCode", 20);
            selenium.Type("itemCode", "X11C61280109");//输入商品编码
            selenium.KeyDown("itemCode", "13");
            Thread.Sleep(2000);
            string RetailNo = selenium.GetText("posVoucherCode");
            Console.Write("销售小票代码: " + RetailNo);
            selenium.Click("posVoucherConfirm");
            WatiForElement("deductionConfirm", 20);
            selenium.Click("deductionConfirm");
            WatiForElement("//div[@id='collectionType']/ul/li[2]/a", 20);
            selenium.Click("//div[@id='collectionType']/ul/li[2]/a");//选择现金收银
            string amount = selenium.GetText("needPay");
            selenium.Type("collectionAmount", amount);//输入现金金额
            selenium.Click("btnAddCollectionItem");//添加
            selenium.Click("confirm");//收款完成


            selenium.Open(url + "/POS/POSVoucher.aspx?type=20");//进入退货界面
            WatiForElement("oldCode", 20);
            selenium.Type("oldCode", RetailNo);//输入销售小票代码
            selenium.Type("//input[@id='itemCode']", "X11C61280109");//输入商品编码
            selenium.KeyDown("itemCode", "13");
            selenium.Click("addItem");
            selenium.Click("posVoucherConfirm");//下一步
            WatiForElement("deductionConfirm", 10);
            selenium.Click("deductionConfirm");//下一步
            WatiForElement("confirm", 10);
            selenium.Click("confirm"); //退货完成

            selenium.Open(url + "/POS/POSVoucher.aspx?type=20");//进入退货界面
            WatiForElement("oldCode", 20);
            selenium.Type("oldCode", RetailNo);//输入销售小票代码
            selenium.Type("//input[@id='itemCode']", "X11C61280109");//输入商品编码
            Thread.Sleep(2000);
            Assert.AreEqual("该单号已退！", selenium.GetText("errMsg")); //检查是否出现error message："该单号已退！"


        }

        [Test]
        public void R006_零售换货()
        {
            Userlogin("023241", "a123456");

            selenium.Open(url + "/POS/POSVoucher.aspx");
            WatiForElement("searchKey", 20);
            selenium.Type("searchKey", "13482288286");//输入手机号
            WatiForElement("itemCode", 20);
            selenium.Type("itemCode", "X11C61280109");//输入商品编码
            selenium.KeyDown("itemCode", "13");
            Thread.Sleep(2000);
            string RetailNo = selenium.GetText("posVoucherCode");
            Console.Write("销售小票代码: " + RetailNo);
            selenium.Click("posVoucherConfirm");
            WatiForElement("deductionConfirm", 20);
            selenium.Click("deductionConfirm");
            WatiForElement("//div[@id='collectionType']/ul/li[2]/a", 20);
            selenium.Click("//div[@id='collectionType']/ul/li[2]/a");//选择现金收银
            string amount = selenium.GetText("needPay");
            selenium.Type("collectionAmount", amount);//输入现金金额
            selenium.Click("btnAddCollectionItem");//添加
            selenium.Click("confirm");//收款完成
         
            selenium.Open(url + "/POS/POSVoucher.aspx?type=20");//进入退货界面
            selenium.Click("//td[@name='returnInfo']/input[2]");//选择退换货
            WatiForElement("oldCode", 20);
            selenium.Type("oldCode", RetailNo);//输入销售小票代码
            selenium.KeyDown("itemCode", "13");
            selenium.Click("addItem");
            selenium.Click("posVoucherConfirm");//下一步
            WatiForElement("deductionConfirm", 10);
            selenium.Click("deductionConfirm");//下一步
            WatiForElement("confirm", 10);
            selenium.Click("confirm"); //换货完成
        }
    }
}
