using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks._2010Spring4.S002_HermesFAQ_Module
{
    [TestFixture]
    public class S002_HermesFAQ_Module_2 : SignIn
    {
        [Test]
        public void T01_HermesFAQ_CheckListedTopics()
        {
            browser.GoTo(URL);
            browser.Button(Find.ById("uxHelpCenter")).WaitUntilExists();
            browser.Button(Find.ById("uxHelpCenter")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxBreadcrumbTrail_uxTopLevel")).WaitUntilExists();
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl10_uxCategoryContainer")).Click();
            System.Threading.Thread.Sleep(1000);
            Assert.IsTrue(browser.Element(Find.ById("uxFaqUl9")).Exists);
            Assert.IsTrue(browser.ContainsText("What will happen when my account is converted to the new Trading Center?"));
            Assert.IsTrue(browser.ContainsText("Do I have a choice over whether my account is converted?"));
            Assert.IsTrue(browser.ContainsText("When will my account be converted?"));
            Assert.IsTrue(browser.ContainsText("Can I switch my account back to the old trading center?"));
            Assert.IsTrue(browser.ContainsText("If I have multiple accounts, will they all be converted at the same time?"));
            Assert.IsTrue(browser.ContainsText("Will the conversion affect my account number, password, or other account settings?"));
            Assert.IsTrue(browser.ContainsText("Will the conversion affect tools I currently use like the Zecco Streamer or Zap Trade?"));
            Assert.IsTrue(browser.ContainsText("Will my watch lists be converted?"));
            Assert.IsTrue(browser.ContainsText("How do I give feedback?"));
            Assert.IsTrue(browser.ContainsText("What are the benefits of the new Trading Center?"));
            Assert.IsTrue(browser.ContainsText("What happened to the old left navigation menu?"));
        }

        [Test]
        public void T02_HermesFAQ_CheckTradingCenterConversion_01()
        {
            browser.GoTo(URL);
            browser.Button(Find.ById("uxHelpCenter")).WaitUntilExists();
            browser.Button(Find.ById("uxHelpCenter")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxBreadcrumbTrail_uxTopLevel")).WaitUntilExists();
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl10_uxCategoryContainer")).Click();
            System.Threading.Thread.Sleep(1000);
            browser.Link(Find.ByText("What will happen when my account is converted to the new Trading Center?")).Click();
            System.Threading.Thread.Sleep(1000);
            Assert.IsTrue(browser.ContainsText("Trading Center Conversion"));
        }

        [Test]
        public void T03_HermesFAQ_CheckTradingCenterConversion_02()
        {
            browser.GoTo(URL);
            browser.Button(Find.ById("uxHelpCenter")).WaitUntilExists();
            browser.Button(Find.ById("uxHelpCenter")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxBreadcrumbTrail_uxTopLevel")).WaitUntilExists();
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl10_uxCategoryContainer")).Click();
            System.Threading.Thread.Sleep(1000);
            browser.Link(Find.ByText("Do I have a choice over whether my account is converted?")).Click();
            System.Threading.Thread.Sleep(1000);
            Assert.IsTrue(browser.ContainsText("Trading Center Conversion"));
        }

        [Test]
        public void T04_HermesFAQ_CheckTradingCenterConversion_03()
        {
            browser.GoTo(URL);
            browser.Button(Find.ById("uxHelpCenter")).WaitUntilExists();
            browser.Button(Find.ById("uxHelpCenter")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxBreadcrumbTrail_uxTopLevel")).WaitUntilExists();
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl10_uxCategoryContainer")).Click();
            System.Threading.Thread.Sleep(1000);
            browser.Link(Find.ByText("When will my account be converted?")).Click();
            System.Threading.Thread.Sleep(1000);
            Assert.IsTrue(browser.ContainsText("Trading Center Conversion"));
        }

        [Test]
        public void T05_HermesFAQ_CheckTradingCenterConversion_04()
        {
            browser.GoTo(URL);
            browser.Button(Find.ById("uxHelpCenter")).WaitUntilExists();
            browser.Button(Find.ById("uxHelpCenter")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxBreadcrumbTrail_uxTopLevel")).WaitUntilExists();
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl10_uxCategoryContainer")).Click();
            System.Threading.Thread.Sleep(1000);
            browser.Link(Find.ByText("Can I switch my account back to the old trading center?")).Click();
            System.Threading.Thread.Sleep(1000);
            Assert.IsTrue(browser.ContainsText("Trading Center Conversion"));
        }

        [Test]
        public void T06_HermesFAQ_CheckTradingCenterConversion_05()
        {
            browser.GoTo(URL);
            browser.Button(Find.ById("uxHelpCenter")).WaitUntilExists();
            browser.Button(Find.ById("uxHelpCenter")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxBreadcrumbTrail_uxTopLevel")).WaitUntilExists();
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl10_uxCategoryContainer")).Click();
            System.Threading.Thread.Sleep(1000);
            browser.Link(Find.ByText("If I have multiple accounts, will they all be converted at the same time?")).Click();
            System.Threading.Thread.Sleep(1000);
            Assert.IsTrue(browser.ContainsText("Trading Center Conversion"));
        }

        [Test]
        public void T07_HermesFAQ_CheckTradingCenterConversion_06()
        {
            browser.GoTo(URL);
            browser.Button(Find.ById("uxHelpCenter")).WaitUntilExists();
            browser.Button(Find.ById("uxHelpCenter")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxBreadcrumbTrail_uxTopLevel")).WaitUntilExists();
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl10_uxCategoryContainer")).Click();
            System.Threading.Thread.Sleep(1000);
            browser.Link(Find.ByText("Will the conversion affect my account number, password, or other account settings?")).Click();
            System.Threading.Thread.Sleep(1000);
            Assert.IsTrue(browser.ContainsText("Trading Center Conversion"));
        }

        [Test]
        public void T08_HermesFAQ_CheckTradingCenterConversion_07()
        {
            browser.GoTo(URL);
            browser.Button(Find.ById("uxHelpCenter")).WaitUntilExists();
            browser.Button(Find.ById("uxHelpCenter")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxBreadcrumbTrail_uxTopLevel")).WaitUntilExists();
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl10_uxCategoryContainer")).Click();
            System.Threading.Thread.Sleep(1000);
            browser.Link(Find.ByText("Will the conversion affect tools I currently use like the Zecco Streamer or Zap Trade?")).Click();
            System.Threading.Thread.Sleep(1000);
            Assert.IsTrue(browser.ContainsText("Trading Center Conversion"));
        }

        [Test]
        public void T09_HermesFAQ_CheckTradingCenterConversion_08()
        {
            browser.GoTo(URL);
            browser.Button(Find.ById("uxHelpCenter")).WaitUntilExists();
            browser.Button(Find.ById("uxHelpCenter")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxBreadcrumbTrail_uxTopLevel")).WaitUntilExists();
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl10_uxCategoryContainer")).Click();
            System.Threading.Thread.Sleep(1000);
            browser.Link(Find.ByText("Will my watch lists be converted?")).Click();
            System.Threading.Thread.Sleep(1000);
            Assert.IsTrue(browser.ContainsText("Trading Center Conversion"));
        }

        [Test]
        public void T10_HermesFAQ_CheckTradingCenterConversion_09()
        {
            browser.GoTo(URL);
            browser.Button(Find.ById("uxHelpCenter")).WaitUntilExists();
            browser.Button(Find.ById("uxHelpCenter")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxBreadcrumbTrail_uxTopLevel")).WaitUntilExists();
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl10_uxCategoryContainer")).Click();
            System.Threading.Thread.Sleep(1000);
            browser.Link(Find.ByText("How do I give feedback?")).Click();
            System.Threading.Thread.Sleep(1000);
            Assert.IsTrue(browser.ContainsText("Trading Center Conversion"));
        }

        [Test]
        public void T11_HermesFAQ_CheckTradingCenterConversion_10()
        {
            browser.GoTo(URL);
            browser.Button(Find.ById("uxHelpCenter")).WaitUntilExists();
            browser.Button(Find.ById("uxHelpCenter")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxBreadcrumbTrail_uxTopLevel")).WaitUntilExists();
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl10_uxCategoryContainer")).Click();
            System.Threading.Thread.Sleep(1000);
            browser.Link(Find.ByText("What are the benefits of the new Trading Center?")).Click();
            System.Threading.Thread.Sleep(1000);
            Assert.IsTrue(browser.ContainsText("Trading Center Conversion"));
        }

        [Test]
        public void T12_HermesFAQ_CheckTradingCenterConversion_11()
        {
            browser.GoTo(URL);
            browser.Button(Find.ById("uxHelpCenter")).WaitUntilExists();
            browser.Button(Find.ById("uxHelpCenter")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxBreadcrumbTrail_uxTopLevel")).WaitUntilExists();
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl10_uxCategoryContainer")).Click();
            System.Threading.Thread.Sleep(1000);
            browser.Link(Find.ByText("What happened to the old left navigation menu?")).Click();
            System.Threading.Thread.Sleep(1000);
            Assert.IsTrue(browser.ContainsText("Trading Center Conversion"));
        }
    }
}
