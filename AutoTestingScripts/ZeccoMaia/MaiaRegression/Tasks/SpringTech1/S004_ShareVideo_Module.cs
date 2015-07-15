using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks.SpringTech1
{
    [TestFixture]
    public class S004_ShareVideo_Module : SignIn
    {
        [Test]
        public void T01_ShareVideo_Video()
        {
            UserSignIn(UN, PW, false, 2);
            browser.WaitForComplete();
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl03_uxTopNavLink")).Click();
            browser.WaitForComplete();
            browser.Div(Find.ByClass("box accountcenterbox center")).Image(Find.ByAlt("Zecco Streamer Tour")).Click();
            Assert.IsTrue(browser.Form(Find.ById("form1")).Exists);
        }

        [Test]
        public void T02_ShareVideo_Email()
        {
            UserSignIn(UN, PW, false, 2);
            browser.WaitForComplete();
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl03_uxTopNavLink")).Click();
            browser.WaitForComplete();
            browser.Div(Find.ByClass("box accountcenterbox center")).Image(Find.ByAlt("Zecco Streamer Tour")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Form(Find.ById("form1")).Div(Find.ById("video-container")).Link(Find.ByClass("sending-email")).Exists);
        }

        [Test]
        public void T03_ShareVideo_GetLink()
        {
            UserSignIn(UN, PW, false, 2);
            browser.WaitForComplete();
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl03_uxTopNavLink")).Click();
            browser.WaitForComplete();
            browser.Div(Find.ByClass("box accountcenterbox center")).Image(Find.ByAlt("Zecco Streamer Tour")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Form(Find.ById("form1")).Div(Find.ById("video-container")).Link(Find.ByClass("get-page-link")).Exists);
        }

        [Test]
        public void T04_ShareVideo_GetCode()
        {
            UserSignIn(UN, PW, false, 2);
            browser.WaitForComplete();
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl03_uxTopNavLink")).Click();
            browser.WaitForComplete();
            browser.Div(Find.ByClass("box accountcenterbox center")).Image(Find.ByAlt("Zecco Streamer Tour")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Form(Find.ById("form1")).Div(Find.ById("video-container")).Link(Find.ByClass("get-page-code")).Exists);
        }

        [Test]
        public void T05_ShareVideo_EmailFriend()
        {
            UserSignIn(UN, PW, false, 2);
            browser.WaitForComplete();
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl03_uxTopNavLink")).Click();
            browser.WaitForComplete();
            browser.Div(Find.ByClass("box accountcenterbox center")).Image(Find.ByAlt("Zecco Streamer Tour")).Click();
            System.Threading.Thread.Sleep(2000);
            browser.Form(Find.ById("form1")).Div(Find.ById("video-container")).Link(Find.ByClass("sending-email")).Click();
            //
        }

        [Test]
        public void T06_ShareVideo_Sender()
        {
            UserSignIn(UN, PW, false, 2);
            browser.WaitForComplete();
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl03_uxTopNavLink")).Click();
            browser.WaitForComplete();
            browser.Div(Find.ByClass("box accountcenterbox center")).Image(Find.ByAlt("Zecco Streamer Tour")).Click();
            System.Threading.Thread.Sleep(2000);
            browser.Form(Find.ById("form1")).Div(Find.ById("video-container")).Link(Find.ByClass("sending-email")).Click();
            Assert.IsTrue(browser.Form(Find.ById("form1")).Div(Find.ById("video-container")).TextField(Find.ById("uxSenderEmail")).Exists);
        }

        [Test]
        public void T07_ShareVideo_Receiver()
        {
            UserSignIn(UN, PW, false, 2);
            browser.WaitForComplete();
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl03_uxTopNavLink")).Click();
            browser.WaitForComplete();
            browser.Div(Find.ByClass("box accountcenterbox center")).Image(Find.ByAlt("Zecco Streamer Tour")).Click();
            browser.Form(Find.ById("form1")).Div(Find.ById("video-container")).Link(Find.ByClass("sending-email")).Click();
            Assert.IsTrue(browser.Form(Find.ById("form1")).Div(Find.ById("video-container")).TextField(Find.ById("uxReceiverEmail")).Exists);
        }

        [Test]
        public void T08_ShareVideo_MsgContents()
        {
            UserSignIn(UN, PW, false, 2);
            browser.WaitForComplete();
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl03_uxTopNavLink")).Click();
            browser.WaitForComplete();
            browser.Div(Find.ByClass("box accountcenterbox center")).Image(Find.ByAlt("Zecco Streamer Tour")).Click();
            System.Threading.Thread.Sleep(2000);
            browser.Form(Find.ById("form1")).Div(Find.ById("video-container")).Link(Find.ByClass("sending-email")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Form(Find.ById("form1")).Div(Find.ById("video-container")).TextField(Find.ById("uxPersonalMsg")).Exists);
        }

        [Test]
        public void T09_ShareVideo_Send()
        {
            UserSignIn(UN, PW, false, 2);
            browser.WaitForComplete();
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl03_uxTopNavLink")).Click();
            browser.WaitForComplete();
            browser.Div(Find.ByClass("box accountcenterbox center")).Image(Find.ByAlt("Zecco Streamer Tour")).Click();
            System.Threading.Thread.Sleep(2000);
            browser.Form(Find.ById("form1")).Div(Find.ById("video-container")).Link(Find.ByClass("sending-email")).Click();
            System.Threading.Thread.Sleep(2000);
            browser.Form(Find.ById("form1")).Div(Find.ById("video-container")).TextField(Find.ById("uxSenderEmail")).TypeText("Auto" + Date + "@");
            browser.Form(Find.ById("form1")).Div(Find.ById("video-container")).TextField(Find.ById("uxReceiverEmail")).TypeText("Auto" + Date + "@");
            browser.Form(Find.ById("form1")).Div(Find.ById("video-container")).TextField(Find.ById("uxPersonalMsg")).TypeText("auto test");
            browser.Form(Find.ById("form1")).Div(Find.ById("video-container")).Button(Find.ById("uxSendBtn")).Click();
            Assert.AreEqual(browser.Form(Find.ById("form1")).Div(Find.ById("video-container")).Span(Find.ById("uxSuccessMsg")).Text, "Email has been sent successfully!");
        }

        [Test]
        public void T10_ShareVideo_EmailCancel()
        {
            UserSignIn(UN, PW, false, 2);
            browser.WaitForComplete();
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl03_uxTopNavLink")).Click();
            browser.WaitForComplete();
            browser.Div(Find.ByClass("box accountcenterbox center")).Image(Find.ByAlt("Zecco Streamer Tour")).Click();
            System.Threading.Thread.Sleep(2000);
            browser.Form(Find.ById("form1")).Div(Find.ById("video-container")).Link(Find.ByClass("sending-email")).Click();
            System.Threading.Thread.Sleep(2000);
            browser.Form(Find.ById("form1")).Div(Find.ById("video-container")).Link(Find.ByClass("cancel-link")).Click();
        }

        [Test]
        public void T11_ShareVideo_Link()
        {
            UserSignIn(UN, PW, false, 2);
            browser.WaitForComplete();
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl03_uxTopNavLink")).Click();
            browser.WaitForComplete();
            browser.Div(Find.ByClass("box accountcenterbox center")).Image(Find.ByAlt("Zecco Streamer Tour")).Click();
            System.Threading.Thread.Sleep(2000);
            browser.Form(Find.ById("form1")).Div(Find.ById("video-container")).Link(Find.ByClass("get-page-link")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Form(Find.ById("form1")).Div(Find.ById("video-container")).TextField(Find.ById("share-link-box")).Text.Contains("/video/zap_trade.aspx"));
        }

        [Test]
        public void T12_ShareVideo_CopyLink()
        {
            UserSignIn(UN, PW, false, 2);
            browser.WaitForComplete();
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl03_uxTopNavLink")).Click();
            browser.WaitForComplete();
            browser.Div(Find.ByClass("box accountcenterbox center")).Image(Find.ByAlt("Zecco Streamer Tour")).Click();
            System.Threading.Thread.Sleep(2000);
            browser.Form(Find.ById("form1")).Div(Find.ById("video-container")).Link(Find.ByClass("get-page-link")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Form(Find.ById("form1")).Div(Find.ById("video-container")).Button(Find.ById("ZeroClipboardMovie_1")).Exists);
        }

        [Test]
        public void T13_ShareVideo_LinkCancel()
        {
            UserSignIn(UN, PW, false, 2);
            browser.WaitForComplete();
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl03_uxTopNavLink")).Click();
            browser.WaitForComplete();
            browser.Div(Find.ByClass("box accountcenterbox center")).Image(Find.ByAlt("Zecco Streamer Tour")).Click();
            System.Threading.Thread.Sleep(2000);
            browser.Form(Find.ById("form1")).Div(Find.ById("video-container")).Link(Find.ByClass("get-page-link")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Form(Find.ById("form1")).Div(Find.ById("video-container")).Link(Find.ByClass("cancel-link")).Exists);
        }

        [Test]
        public void T14_ShareVideo_Code()
        {
            UserSignIn(UN, PW, false, 2);
            browser.WaitForComplete();
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl03_uxTopNavLink")).Click();
            browser.WaitForComplete();
            browser.Div(Find.ByClass("box accountcenterbox center")).Image(Find.ByAlt("Zecco Streamer Tour")).Click();
            System.Threading.Thread.Sleep(2000);
            browser.Form(Find.ById("form1")).Div(Find.ById("video-container")).Link(Find.ByClass("get-page-code")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Form(Find.ById("form1")).Div(Find.ById("video-container")).TextField(Find.ById("copy-code-box")).Exists);
        }

        [Test]
        public void T15_ShareVideo_CopyCode()
        {
            UserSignIn(UN, PW, false, 2);
            browser.WaitForComplete();
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl03_uxTopNavLink")).Click();
            browser.WaitForComplete();
            browser.Div(Find.ByClass("box accountcenterbox center")).Image(Find.ByAlt("Zecco Streamer Tour")).Click();
            System.Threading.Thread.Sleep(2000);
            browser.Form(Find.ById("form1")).Div(Find.ById("video-container")).Link(Find.ByClass("get-page-code")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Form(Find.ById("form1")).Div(Find.ById("video-container")).Button(Find.ById("ZeroClipboardMovie_2")).Exists);
        }

        [Test]
        public void T16_ShareVideo_CodeCancel()
        {
            UserSignIn(UN, PW, false, 2);
            browser.WaitForComplete();
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl03_uxTopNavLink")).Click();
            browser.WaitForComplete();
            browser.Div(Find.ByClass("box accountcenterbox center")).Image(Find.ByAlt("Zecco Streamer Tour")).Click();
            System.Threading.Thread.Sleep(2000);
            browser.Form(Find.ById("form1")).Div(Find.ById("video-container")).Link(Find.ByClass("get-page-code")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Form(Find.ById("form1")).Div(Find.ById("video-container")).Link(Find.ByClass("cancel-link")).Exists);
        }
    }
}
