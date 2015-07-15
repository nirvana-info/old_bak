using System;
using WatiN.Core;
using NUnit.Framework;
using System.Threading;
using WatiN.Core.DialogHandlers;

namespace SystemTest
{
    [TestFixture]
    public class Check1_01_salesgoods : TestBase
    {
        [Test]
        public void chech1_01_01_login()
        {
            //login
            ie.GoTo(url);
            ie.ShowWindow(NativeMethods.WindowShowStyle.Maximize);
            //ie.TextField(Find.ByName("q")).TypeText("watiN");
            //ie.Button(Find.ByName("btnG")).Click();
            //Assert.IsTrue(ie.ContainsText("watiN"));
            ie.TextField(Find.ById("ctl00_IBestLoginStatus1_Login_UserName")).TypeText("bobby001");
            ie.TextField(Find.ById("ctl00_IBestLoginStatus1_Login_Password")).TypeText("123456");
            ie.Button(Find.ById("ctl00_IBestLoginStatus1_Login_LoginButton")).Click();
            ie.Span(Find.ByText("欢迎 bobby001")).WaitUntilExists(120);
            Assert.IsTrue(ie.ContainsText("欢迎 bobby001"));
        }

        [Test]
        public void chech1_01_02_salessource()
        {
            //挂牌资源
            ie.Span(Find.ByText("交易平台")).Click();
            ie.Link(Find.ByUrl(url+"Trade/ReceiptSummary.aspx?usertype=sales")).Click();
            ie.Button(Find.ById("ctl00_ContentPlaceHolder1_gpbtn")).WaitUntilExists(120);
            Assert.IsTrue(ie.ContainsText("资源挂牌"));

            ie.Image(Find.ByAlt("在线上传")).Click();
            ie.Span(Find.ByText("资源录入/编辑")).WaitUntilExists(120);
            //无捆包
            ie.SelectList(Find.ById("ctl00_ContentPlaceHolder1_cmbCategory")).Option(Find.ByValue("100000101")).Select();
            ie.TextField(Find.ById("ctl00_ContentPlaceHolder1_cz")).TypeText("功能测试专用1");
            ie.TextField(Find.ById("ctl00_ContentPlaceHolder1_sccj")).TypeText("功能测试专用1");
            ie.TextField(Find.ById("ctl00_ContentPlaceHolder1_gg_h")).TypeText("1");
            ie.TextField(Find.ById("ctl00_ContentPlaceHolder1_gg_k")).TypeText("1");
            ie.TextField(Find.ById("ctl00_ContentPlaceHolder1_gg_c")).TypeText("1");
            ie.TextField(Find.ById("ctl00_ContentPlaceHolder1_weight")).TypeText("1");
            ie.TextField(Find.ById("ctl00_ContentPlaceHolder1_price")).TypeText("100");
            string Date = DateTime.Today.ToString("yyyy-MM-dd");
            ie.TextField(Find.ById("ctl00_ContentPlaceHolder1_manufacturedate")).TypeText(Date);
            //提交后继续添加
            ie.Button(Find.ById("ctl00_ContentPlaceHolder1_Button3")).Click();
            //有捆包
            ie.SelectList(Find.ById("ctl00_ContentPlaceHolder1_cmbCategory")).Option(Find.ByValue("100000101")).Select();
            ie.TextField(Find.ById("ctl00_ContentPlaceHolder1_cz")).TypeText("功能测试专用2");
            ie.TextField(Find.ById("ctl00_ContentPlaceHolder1_sccj")).TypeText("功能测试专用2");
            ie.TextField(Find.ById("ctl00_ContentPlaceHolder1_gg_h")).TypeText("1");
            ie.TextField(Find.ById("ctl00_ContentPlaceHolder1_gg_k")).TypeText("1");
            ie.TextField(Find.ById("ctl00_ContentPlaceHolder1_gg_c")).TypeText("1");
           
            ie.TextField(Find.ById("ctl00_ContentPlaceHolder1_price")).TypeText("100");
            //string Date = DateTime.Today.ToString("yyyy-MM-dd");
            ie.TextField(Find.ById("ctl00_ContentPlaceHolder1_manufacturedate")).TypeText(Date);
            //添加捆包
            ie.Button(Find.ById("ctl00_ContentPlaceHolder1_Button1")).Click();
            ie.TextField(Find.ById("ctl00_ContentPlaceHolder1_GridView1_ctl02_txtkbh")).TypeText("1");
            ie.TextField(Find.ById("ctl00_ContentPlaceHolder1_GridView1_ctl02_txtqty")).TypeText("1");
            ie.Button(Find.ById("ctl00_ContentPlaceHolder1_Button1")).Click();
            //提交
            ie.Button(Find.ById("ctl00_ContentPlaceHolder1_Button2")).Click();
            ie.Button(Find.ById("ctl00_ContentPlaceHolder1_gpbtn")).WaitUntilExists(120);
            
            //关闭警告窗口
            WatiN.Core.DialogHandlers.ConfirmDialogHandler dh = new WatiN.Core.DialogHandlers.ConfirmDialogHandler();

            ie.AddDialogHandler(dh);
            ie.Button(Find.ById("ctl00_ContentPlaceHolder1_gpallbtn")).ClickNoWait();
            //ie.Image(Find.ByAlt("Add")).ClickNoWait();
            dh.WaitUntilExists(15);//
            dh.OKButton.Click();//
            
            ie.RemoveDialogHandler(dh);
            //ie.Close();
            
            
            
        }


    }
}
