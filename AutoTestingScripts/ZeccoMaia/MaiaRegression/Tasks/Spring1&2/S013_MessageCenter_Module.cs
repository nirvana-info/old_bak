using System;
using System.Collections.Generic;
using System.Text;
using WatiN.Core;
using NUnit.Framework;
using MaiaRegression.Appobjects;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks.Spring1_2
{
    [TestFixture]
    public class S013_MessageCenter_Module : MessageCenter
    {
        [Test]
        public void T01_MessageCenter_ViewMessageCenter()
        {
            UserSignIn(UN, PW, false, 0);
            browser.Link(Find.ById("uxMessages")).WaitUntilExists(20);
            browser.Link(Find.ById("uxMessages")).Click();
            browser.WaitForComplete();
            //Assert.IsTrue(browser.TextField(Find.ByText("Zecco Message Center")).Text.Contains("Zecco Message Center"));
            Assert.IsTrue(browser.Div(Find.ById("MainColumn")).Div(Find.ByClass("float-left")).Text.Contains("Zecco Message Center"));
        }

        [Test]
        public void T02_MessageCenter_SendforData()
        {
            UserSignIn(UN, PW, false, 0);
            browser.Link(Find.ById("uxMessages")).WaitUntilExists(20);
            browser.Link(Find.ById("uxMessages")).Click();

            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxComposemessage")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxRecipient")).TypeText(UN1);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxTopic")).TypeText("aa");
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMessage")).TypeText("bb");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSendMail")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSuccessMessage")).Text.Contains("Your message was sent successfully."));

            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxComposemessage")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxRecipient")).TypeText(UN1);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxTopic")).TypeText("bb");
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMessage")).TypeText("cc");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSendMail")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSuccessMessage")).Text.Contains("Your message was sent successfully."));

            System.Threading.Thread.Sleep(120000);
        }

        [Test]
        public void T03_MessageCenter_ComposeMsgPos()
        {
            this.ComposeMessage("ddpg", "a");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSendMail")).Click();
            Assert.IsTrue(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSuccessMessage")).Text.Contains("Your message was sent successfully."));
        }

        [Test]
        public void T04_MessageCenter_ComposeMsgCancel()
        {
            this.ComposeMessage("ddpg", "a");
            browser.Link(Find.ByText("Cancel")).Click();
            Assert.IsTrue(browser.Div(Find.ById("MainColumn")).Div(Find.ByClass("float-left")).Text.Contains("Zecco Message Center"));
        }

        [Test]
        public void T05_MessageCenter_ComposeMsgNegNoTitle()
        {
            this.ComposeMessage("", "a");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSendMail")).Click();
            Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Oops! You need to enter a subject before we can proceed."));
        }

        [Test]
        public void T06_MessageCenter_ComposeMsgNegNoMsg()
        {
            this.ComposeMessage("ddpg", "");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSendMail")).Click();
            Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Oops! You need to enter a message before we can proceed."));
        }

        [Test]
        public void T07_MessageCenter_MarkRead()
        {
            this.ChangeReadStatus();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxMarkAsReadSelectedLink")).Click();
            System.Threading.Thread.Sleep(10000);
            if (browser.Image(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxMailListView_ctrl0_uxReadPicture")).Exists == true)
            {
                Assert.IsTrue(true);
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T08_MessageCenter_MarkUnRead()
        {
            this.ChangeReadStatus();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxMarkAsUnreadSelectedLink")).Click();
            System.Threading.Thread.Sleep(10000);
            if (browser.Image(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxMailListView_ctrl0_uxUnreadPicture")).Exists == true)
            {
                Assert.IsTrue(true);
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T09_MessageCenter_MarkSeveralRead()
        {
            this.ChangeReadStatus();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxMarkAsReadSelectedLink")).Click();
            System.Threading.Thread.Sleep(10000);
            if (browser.Image(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxMailListView_ctrl0_uxReadPicture")).Exists == true)
            {
                Assert.IsTrue(true);
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T10_MessageCenter_MarkSeveralUnRead()
        {
            this.ChangeReadStatus();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxMarkAsUnreadSelectedLink")).Click();
            System.Threading.Thread.Sleep(10000);
            if (browser.Image(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxMailListView_ctrl0_uxUnreadPicture")).Exists == true)
            {
                Assert.IsTrue(true);
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T11_MessageCenter_ArchiveMsg()
        {
            this.ChangeReadStatus();
            string title1 = browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxMailListView_ctrl0_uxSubject")).Text.Trim();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxDeleteSelectedLink")).Click();
            System.Threading.Thread.Sleep(1000);
            browser.Button(Find.ById("ProceedButton")).Click();
            System.Threading.Thread.Sleep(2000);
            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxRadTabStripDisplayMessage")).Link(Find.ByText("Archived")).Click();
            string title2 = browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxMailListView_ctrl0_uxSubject")).Text.Trim();
            Assert.AreEqual(title1, title2);
        }

        [Test]
        public void T12_MessageCenter_ViewMessage()
        {
            UserSignIn(UN1, PW1, false, 0);
            browser.Link(Find.ById("uxMessages")).WaitUntilExists(20);
            browser.Link(Find.ById("uxMessages")).Click();
            //browser.Link(Find.ByText("Inbox")).Click();
            string title1 = browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxMailListView_ctrl0_uxSubject")).Text.Trim();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxMailListView_ctrl0_uxSubject")).WaitUntilExists(10);
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxMailListView_ctrl0_uxSubject")).Click();
            string title2 = browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSubject")).Text.Trim();
            Assert.AreEqual(title1, title2);
        }

        [Test]
        public void T13_MessageCenter_ReplyMsgPos()
        {
            this.ViewAndReply();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMessage")).TypeText("bbbb");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSendMail")).Click();
            Assert.IsTrue(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSuccessMessage")).Text.Contains("Your message was sent successfully."));
        }

        [Test]
        public void T14_MessageCenter_ReplyMsgNeg()
        {
            this.ViewAndReply();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMessage")).TypeText("bbbb");
            browser.Link(Find.ByText("Cancel")).Click();
            Assert.IsTrue(browser.Div(Find.ById("MainColumn")).Div(Find.ByClass("float-left")).Text.Contains("Zecco Message Center"));
        }

        [Test]
        public void T15_MessageCenter_ReplyMsgNoMessage()
        {
            this.ViewAndReply();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMessage")).TypeText("");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSendMail")).Click();
            Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Oops! You need to enter a message before we can proceed."));
        }
    }
}
