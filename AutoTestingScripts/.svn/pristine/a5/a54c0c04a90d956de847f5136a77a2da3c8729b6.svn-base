using System;
using System.Collections.Generic;
using System.Text;
using System.Threading;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;
using System.Text.RegularExpressions;

///////////////////////////////////////
/*** author:bobby  date:2009/11/6  ***/
/*** modify by:    date            ***/
/***                               ***/
///////////////////////////////////////

namespace MaiaRegression.Tasks.Spring6
{
    [TestFixture]
    public class S007_Refer_Friend : SignIn
    {
        [Test]
        public void T01_Refer_Withouttradeaccount()
        {
            
            UserSignIn(UN1, PW1, false, 0);
            browser.Link(Find.ByText("Change password ")).WaitUntilExists();
            //Permission check-Refer a friend link visibility without trading account
            Assert.IsFalse(browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxTradingReferToFriend")).Exists);
        }

        [Test]
        public void T02_Refer_Withtradeaccount()
        {
            
            UserSignIn(UN, PW, false, 0);
            browser.Link(Find.ByText("Change password ")).WaitUntilExists();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxTradingReferToFriend")).Click();
            Thread.Sleep(2000);
            browser.Image(Find.ByClass("pmi-ad-img")).WaitUntilExists();
            //Permission check-guest goes to RAF page
            Assert.IsTrue(browser.Image(Find.ByClass("pmi-ad-img")).Exists);
        }

        [Test]
        public void T03_Refer_Withtradeaccount_Sendmail()
        {
            //block
            
            if (browser.Link(Find.ByText("Sign Out")).Exists == true)
            {
                browser.Link(Find.ByText("Sign Out")).Click();
            }
            UserSignIn(UN, PW, false, 0);
            browser.Link(Find.ById("uxAccountCenter")).Click();
            browser.Link(Find.ByText("Change password ")).WaitUntilExists();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxTradingReferToFriend")).Click();
            Thread.Sleep(2000);
            browser.Image(Find.ByClass("pmi-ad-img")).WaitUntilExists();
            //browser.Image(Find.ByClass("pmi-ad-img")).Click();
            Thread.Sleep(40000);
            browser.Frames[1].Button(Find.ById("test-advance")).Click();
            Thread.Sleep(10000);
            //browser.Frames[1].TextField(Find.ById("recipient_emails")).WaitUntilExists();
            browser.Frames[1].TextField(Find.ById("recipient_emails")).TypeText("jelly.yu@nirvana-info.com,bobby.wang@nirvana-info.com");
            browser.Frames[1].TextField(Find.ByClass("pmi-textfield requiredInput required_empty")).TypeText("tonyleachsf@zecco.com");
            browser.Frames[1].Button(Find.ByClass("pmi-btn-primary pmi_requires_captcha sendEmailButton actionButton")).Click();
            //Flow to refer a friend
            Assert.IsTrue(browser.Frames[1].Button(Find.ByClass("pmi-btn-primary sendEmailButton actionButton")).Exists);
             
            /*
            if (browser.Div(Find.ById("pmi_iframe_edd8631aaf483dc9473b2246dac0261d")).Exists)
            {
                browser.Frame(Find.ById("pmi_iframe_edd8631aaf483dc9473b2246dac0261d")).Button(Find.ById("test-advance")).Click();
                Thread.Sleep(10000);
                browser.Frame(Find.ById("pmi_iframe_edd8631aaf483dc9473b2246dac0261d")).TextField(Find.ById("recipient_emails")).TypeText("jelly.yu@nirvana-info.com,bobby.wang@nirvana-info.com");
                browser.Frame(Find.ById("pmi_iframe_edd8631aaf483dc9473b2246dac0261d")).TextField(Find.ByClass("pmi-textfield requiredInput required_empty")).TypeText("tonyleachsf@zecco.com");
                browser.Frame(Find.ById("pmi_iframe_edd8631aaf483dc9473b2246dac0261d")).Button(Find.ByClass("pmi-btn-primary pmi_requires_captcha sendEmailButton actionButton")).Click();
                Assert.IsTrue(browser.Frame(Find.ById("pmi_iframe_edd8631aaf483dc9473b2246dac0261d")).Button(Find.ByClass("pmi-btn-primary sendEmailButton actionButton")).Exists);
            }
            else 
            {
                browser.Frame(Find.ById("pmi_iframe_83148566590a94b196998373251cf8c5")).Button(Find.ById("test-advance")).Click();
                Thread.Sleep(10000);
                browser.Frame(Find.ById("pmi_iframe_83148566590a94b196998373251cf8c5")).TextField(Find.ById("recipient_emails")).TypeText("jelly.yu@nirvana-info.com,bobby.wang@nirvana-info.com");
                browser.Frame(Find.ById("pmi_iframe_83148566590a94b196998373251cf8c5")).TextField(Find.ByClass("pmi-textfield requiredInput required_empty")).TypeText("tonyleachsf@zecco.com");
                browser.Frame(Find.ById("pmi_iframe_83148566590a94b196998373251cf8c5")).Button(Find.ByClass("pmi-btn-primary pmi_requires_captcha sendEmailButton actionButton")).Click();
                Assert.IsTrue(browser.Frame(Find.ById("pmi_iframe_83148566590a94b196998373251cf8c5")).Button(Find.ByClass("pmi-btn-primary sendEmailButton actionButton")).Exists);
            }
            */
            
        }
    }
}
