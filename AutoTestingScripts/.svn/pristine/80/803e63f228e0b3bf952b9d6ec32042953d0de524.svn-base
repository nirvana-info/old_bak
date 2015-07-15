using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks.Spring4
{
    [TestFixture]
    public class S005_SupportMessage_Module : SignIn
    {
        [Test]
        public void T01_SupportMessage_Validate()
        {
            this.ComposeSupportMessage();
            Assert.IsTrue(browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxTopic")).Exists);
        }

        [Test]
        public void T02_SupportMessage_OLA()
        {
            this.ComposeSupportMessage();
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxTopic")).Option(Find.ByValue("OLA")).Select();
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSendMail")).WaitUntilExists(10);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSendMail")).Click();
            if (browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSuccessMessage")).Text != "Your message was sent successfully.")
            {
                Assert.IsTrue(false);
            }
            Assert.IsTrue(this.CheckSentItem("Account Maintenance"));
        }

        [Test]
        public void T03_SupportMessage_Brokerage()
        {
            this.ComposeSupportMessage();
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxTopic")).Option(Find.ByValue("Brokerage")).Select();
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSendMail")).WaitUntilExists(10);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSendMail")).Click();
            if (browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSuccessMessage")).Text != "Your message was sent successfully.")
            {
                Assert.IsTrue(false);
            }
            Assert.IsTrue(this.CheckSentItem("Brokerage Account Transfer"));
        }

        [Test]
        public void T04_SupportMessage_CTI()
        {
            this.ComposeSupportMessage();
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxTopic")).Option(Find.ByValue("CTI")).Select();
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSendMail")).WaitUntilExists(10);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSendMail")).Click();
            if (browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSuccessMessage")).Text != "Your message was sent successfully.")
            {
                Assert.IsTrue(false);
            }
            Assert.IsTrue(this.CheckSentItem("Cash Transfer Inquiry"));
        }

        [Test]
        public void T05_SupportMessage_CostBasis()
        {
            this.ComposeSupportMessage();
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxTopic")).Option(Find.ByValue("CostBasis")).Select();
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSendMail")).WaitUntilExists(10);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSendMail")).Click();
            if (browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSuccessMessage")).Text != "Your message was sent successfully.")
            {
                Assert.IsTrue(false);
            }
            Assert.IsTrue(this.CheckSentItem("Cost Basis Update"));
        }

        [Test]
        public void T06_SupportMessage_Dividend()
        {
            this.ComposeSupportMessage();
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxTopic")).Option(Find.ByValue("Dividend")).Select();
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSendMail")).WaitUntilExists(10);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSendMail")).Click();
            if (browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSuccessMessage")).Text != "Your message was sent successfully.")
            {
                Assert.IsTrue(false);
            }
            Assert.IsTrue(this.CheckSentItem("Dividend Reinvestment"));
        }

        [Test]
        public void T07_SupportMessage_Feedback()
        {
            this.ComposeSupportMessage();
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxTopic")).Option(Find.ByValue("Feedback")).Select();
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSendMail")).WaitUntilExists(10);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSendMail")).Click();
            if (browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSuccessMessage")).Text != "Your message was sent successfully.")
            {
                Assert.IsTrue(false);
            }
            Assert.IsTrue(this.CheckSentItem("Feedback"));
        }

        [Test]
        public void T08_SupportMessage_Login()
        {
            this.ComposeSupportMessage();
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxTopic")).Option(Find.ByValue("Login")).Select();
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSendMail")).WaitUntilExists(10);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSendMail")).Click();
            if (browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSuccessMessage")).Text != "Your message was sent successfully.")
            {
                Assert.IsTrue(false);
            }
            Assert.IsTrue(this.CheckSentItem("Login Issue"));
        }

        [Test]
        public void T09_SupportMessage_MarginInquiry()
        {
            this.ComposeSupportMessage();
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxTopic")).Option(Find.ByValue("MarginInquiry")).Select();
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSendMail")).WaitUntilExists(10);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSendMail")).Click();
            if (browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSuccessMessage")).Text != "Your message was sent successfully.")
            {
                Assert.IsTrue(false);
            }
            Assert.IsTrue(this.CheckSentItem("Margin Inquiry"));
        }

        [Test]
        public void T10_SupportMessage_MoneySweep()
        {
            this.ComposeSupportMessage();
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxTopic")).Option(Find.ByValue("MoneySweep")).Select();
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSendMail")).WaitUntilExists(10);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSendMail")).Click();
            if (browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSuccessMessage")).Text != "Your message was sent successfully.")
            {
                Assert.IsTrue(false);
            }
            Assert.IsTrue(this.CheckSentItem("Money Market Sweep"));
        }

        [Test]
        public void T11_SupportMessage_Options()
        {
            this.ComposeSupportMessage();
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxTopic")).Option(Find.ByValue("Options")).Select();
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSendMail")).WaitUntilExists(10);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSendMail")).Click();
            if (browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSuccessMessage")).Text != "Your message was sent successfully.")
            {
                Assert.IsTrue(false);
            }
            Assert.IsTrue(this.CheckSentItem("Options Inquiry"));
        }

        [Test]
        public void T12_SupportMessage_Tax()
        {
            this.ComposeSupportMessage();
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxTopic")).Option(Find.ByValue("Tax")).Select();
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSendMail")).WaitUntilExists(10);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSendMail")).Click();
            if (browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSuccessMessage")).Text != "Your message was sent successfully.")
            {
                Assert.IsTrue(false);
            }
            Assert.IsTrue(this.CheckSentItem("Tax & Retirement"));
        }

        [Test]
        public void T13_SupportMessage_Trading()
        {
            this.ComposeSupportMessage();
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxTopic")).Option(Find.ByValue("Trading")).Select();
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSendMail")).WaitUntilExists(10);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSendMail")).Click();
            if (browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSuccessMessage")).Text != "Your message was sent successfully.")
            {
                Assert.IsTrue(false);
            }
            Assert.IsTrue(this.CheckSentItem("Trading Inquiry"));
        }

        [Test]
        public void T14_SupportMessage_Website()
        {
            this.ComposeSupportMessage();
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxTopic")).Option(Find.ByValue("Website")).Select();
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSendMail")).WaitUntilExists(10);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSendMail")).Click();
            if (browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSuccessMessage")).Text != "Your message was sent successfully.")
            {
                Assert.IsTrue(false);
            }
            Assert.IsTrue(this.CheckSentItem("Website"));
        }

        [Test]
        public void T15_SupportMessage_Cancel()
        {
            this.ComposeSupportMessage();
            browser.Link(Find.ByText("Cancel")).Click();
            Assert.IsTrue(browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxComposeSupportmessage")).Exists);
        }

        [Test]
        public void T16_SupportMessage_CheckSent()
        {
            UserSignIn(UN, PW, false, 0);
            System.Threading.Thread.Sleep(10000);
            browser.Link(Find.ById("uxMessages")).WaitUntilExists(20);
            browser.Link(Find.ById("uxMessages")).Click();
            browser.Link(Find.ByText("Sent")).Click();
            Assert.IsTrue(browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxMailListView_ctrl0_uxSenderScreenNamePanel")).Text.Contains("Customer Service"));
        }

        private void ComposeSupportMessage()
        {
            UserSignIn(UN, PW, false, 0);
            browser.Link(Find.ById("uxMessages")).WaitUntilExists(20);
            browser.Link(Find.ById("uxMessages")).Click();
            browser.WaitForComplete();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxComposeSupportmessage")).Click();

            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMessage")).WaitUntilExists(10);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMessage")).TypeText("ddpg message");
        }

        private bool CheckSentItem(string title)
        {
            int time = 0;
            do
            {
                if (time > 120)
                {
                    return false;
                }
                System.Threading.Thread.Sleep(5000);
                time += 5;
                browser.Link(Find.ById("uxMessages")).WaitUntilExists(20);
                browser.Link(Find.ById("uxMessages")).Click();
                browser.Link(Find.ByText("Sent")).Click();
                browser.WaitForComplete(10);
            } while ((browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxMailListView_ctrl0_uxSubject")).Exists == false) 
                || (browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxMailListView_ctrl0_uxSubject")).Text.Contains(title) == false));

            return true;
        }
    }
}
