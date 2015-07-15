using System;
using WatiN.Core;
using NUnit.Framework;
using System.Threading;
using WatiN.Core.DialogHandlers;

namespace SystemTest
{
    //无捆包
    [TestFixture]
    public class Check1_02_thirdorderA : TestBase
    {
        [Test]
        public void chech1_02_01_login()
        {
            ie.GoTo(url);
            ie.ShowWindow(NativeMethods.WindowShowStyle.Maximize);
            //ie.TextField(Find.ByName("q")).TypeText("watiN");
            //ie.Button(Find.ByName("btnG")).Click();
            //Assert.IsTrue(ie.ContainsText("watiN"));
            ie.TextField(Find.ById("ctl00_IBestLoginStatus1_Login_UserName")).TypeText("bobby002");
            ie.TextField(Find.ById("ctl00_IBestLoginStatus1_Login_Password")).TypeText("123456");
            ie.Button(Find.ById("ctl00_IBestLoginStatus1_Login_LoginButton")).Click();
            ie.Span(Find.ByText("欢迎 bobby002")).WaitUntilExists(120);
            Assert.IsTrue(ie.ContainsText("欢迎 bobby002"));
        }

        [Test]
        public void chech1_02_02_searchsource()
        {
            //search
            ie.Span(Find.ByText("资源查询")).Click();
            ie.Link(Find.ByText(" 清空购物车")).WaitUntilExists(120);
            Assert.IsTrue(ie.ContainsText("清空购物车"));
            ie.TextField(Find.ById("ctl00_ContentPlaceHolder1_txtMaterial")).TypeText("功能测试专用1");
            ie.Button(Find.ById("ctl00_ContentPlaceHolder1_btnSearch")).Click();
            
        }

        [Test]
        public void chech1_02_03_addshoppingcar()
        {
            //buy
            ie.Image(Find.ByAlt("buy product")).Click();
            ie.TextField(Find.ByClass("cinput")).TypeText("1");
            ie.Button(Find.ByClass("addBuyCartBtn")).Click();
            Thread.Sleep(1500);
            //关闭警告窗口
            WatiN.Core.DialogHandlers.ConfirmDialogHandler dh = new WatiN.Core.DialogHandlers.ConfirmDialogHandler();

            ie.AddDialogHandler(dh);
            ie.Link(Find.ById("ctl00_ContentPlaceHolder1_linkBuildOrders")).ClickNoWait();

            dh.WaitUntilExists(3);//
            dh.OKButton.Click();//
            ie.RemoveDialogHandler(dh);
           
        }

        [Test]
        public void chech1_02_04_confirmorder()
        {
            
            //生成意向订单
            //关闭警告窗口
            WatiN.Core.DialogHandlers.ConfirmDialogHandler dh1 = new WatiN.Core.DialogHandlers.ConfirmDialogHandler();

            ie.AddDialogHandler(dh1);
            ie.Button(Find.ById("ctl00_ContentPlaceHolder1_btnBuld")).ClickNoWait();

            dh1.WaitUntilExists(3);//
            dh1.OKButton.Click();//
            ie.RemoveDialogHandler(dh1);

            ie.RadioButton(Find.ByName("radionSelect")).Checked = true;
            ie.Button(Find.ById("btnNoBargain")).Click();
            ie.TableCell(Find.ByText("bobby002")).WaitUntilExists(120);
            //确定
            Thread.Sleep(1500);
            //提货功能暂时只能自提，选择功能先关闭
            //ie.Frame(Find.ById("wheatmsg_ifrm")).SelectList(Find.ById("selTransport")).Option(Find.ByValue("2")).Select();
            ie.Frame(Find.ById("wheatmsg_ifrm")).Button(Find.ById("btnYes")).Click();
            ie.Span(Find.ByText("合同生效配款")).WaitUntilExists(120);
            Assert.IsTrue(ie.ContainsText("合同生效配款"));

        }
    
    }
}
