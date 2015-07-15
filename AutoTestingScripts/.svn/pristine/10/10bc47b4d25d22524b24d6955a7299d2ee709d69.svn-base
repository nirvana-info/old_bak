using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks._2010Spring4.S002_HermesFAQ_Module
{
    [TestFixture]
    public class S002_HermesFAQ_Module_1 :SignIn
    {
        [Test]
        public void T01_HermesFAQ_CheckListedTopics()
        {
            browser.GoTo(URL);
            browser.Button(Find.ById("uxHelpCenter")).WaitUntilExists();
            browser.Button(Find.ById("uxHelpCenter")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxBreadcrumbTrail_uxTopLevel")).WaitUntilExists();
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl09_uxCategoryContainer")).Click();
            System.Threading.Thread.Sleep(1000);
            Assert.IsTrue(browser.Element(Find.ById("uxFaqUl8")).Exists);
            Assert.IsTrue(browser.ContainsText("Where can I learn how to use the new Trading Center?"));
            Assert.IsTrue(browser.ContainsText("How do I get access to the new Trading Center?"));
            Assert.IsTrue(browser.ContainsText("How do I place a stock trade?"));
            Assert.IsTrue(browser.ContainsText("How do I place an options trade?"));
            Assert.IsTrue(browser.ContainsText("How do I place a complex options strategy trade?"));
            Assert.IsTrue(browser.ContainsText("How do I place a trailing stop order?"));
            Assert.IsTrue(browser.ContainsText("Can I buy foreign ordinary shares?"));
            Assert.IsTrue(browser.ContainsText("Do you offer extended hours trading?"));
            Assert.IsTrue(browser.ContainsText("How do I get a real time quote for a stock?"));
            Assert.IsTrue(browser.ContainsText("How do I get a real time quote for options?"));
            Assert.IsTrue(browser.ContainsText("What is an Advanced order?"));
            Assert.IsTrue(browser.ContainsText("What is a One-Cancels-Others (OCO) order?"));
            Assert.IsTrue(browser.ContainsText("What is a One-Triggers-Others (OTO) order?"));
            Assert.IsTrue(browser.ContainsText("What is a Bracket order?"));
            Assert.IsTrue(browser.ContainsText("I just sold some stocks or options in my account. Why is my buying power the same?"));
            Assert.IsTrue(browser.ContainsText("How do I access my monthly statements and trading confirmations?"));
            Assert.IsTrue(browser.ContainsText("Can I get duplicates of my trade confirmations and monthly statements?"));
            Assert.IsTrue(browser.ContainsText("What is a Good Faith Violation?"));
        }

        [Test]
        public void T02_HermesFAQ_CheckTradingCenter_01()
        {
            browser.GoTo(URL);
            browser.Button(Find.ById("uxHelpCenter")).WaitUntilExists();
            browser.Button(Find.ById("uxHelpCenter")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxBreadcrumbTrail_uxTopLevel")).WaitUntilExists();
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl09_uxCategoryContainer")).Click();
            System.Threading.Thread.Sleep(1000);
            browser.Link(Find.ByText("Where can I learn how to use the new Trading Center?")).Click();
            System.Threading.Thread.Sleep(1000);
            Assert.IsTrue(browser.ContainsText("Trading Center"));
        }

        [Test]
        public void T03_HermesFAQ_CheckTradingCenter_02()
        {
            browser.GoTo(URL);
            browser.Button(Find.ById("uxHelpCenter")).WaitUntilExists();
            browser.Button(Find.ById("uxHelpCenter")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxBreadcrumbTrail_uxTopLevel")).WaitUntilExists();
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl09_uxCategoryContainer")).Click();
            System.Threading.Thread.Sleep(1000);
            browser.Link(Find.ByText("How do I get access to the new Trading Center?")).Click();
            System.Threading.Thread.Sleep(1000);
            Assert.IsTrue(browser.ContainsText("Trading Center"));
        }

        [Test]
        public void T04_HermesFAQ_CheckTradingCenter_03()
        {
            browser.GoTo(URL);
            browser.Button(Find.ById("uxHelpCenter")).WaitUntilExists();
            browser.Button(Find.ById("uxHelpCenter")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxBreadcrumbTrail_uxTopLevel")).WaitUntilExists();
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl09_uxCategoryContainer")).Click();
            System.Threading.Thread.Sleep(1000);
            browser.Link(Find.ByText("How do I place a stock trade?")).Click();
            System.Threading.Thread.Sleep(1000);
            Assert.IsTrue(browser.ContainsText("Trading Center"));
        }

        [Test]
        public void T05_HermesFAQ_CheckTradingCenter_04()
        {
            browser.GoTo(URL);
            browser.Button(Find.ById("uxHelpCenter")).WaitUntilExists();
            browser.Button(Find.ById("uxHelpCenter")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxBreadcrumbTrail_uxTopLevel")).WaitUntilExists();
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl09_uxCategoryContainer")).Click();
            System.Threading.Thread.Sleep(1000);
            browser.Link(Find.ByText("How do I place an options trade?")).Click();
            System.Threading.Thread.Sleep(1000);
            Assert.IsTrue(browser.ContainsText("Trading Center"));
        }

        [Test]
        public void T06_HermesFAQ_CheckTradingCenter_05()
        {
            browser.GoTo(URL);
            browser.Button(Find.ById("uxHelpCenter")).WaitUntilExists();
            browser.Button(Find.ById("uxHelpCenter")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxBreadcrumbTrail_uxTopLevel")).WaitUntilExists();
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl09_uxCategoryContainer")).Click();
            System.Threading.Thread.Sleep(1000);
            browser.Link(Find.ByText("How do I place a complex options strategy trade?")).Click();
            System.Threading.Thread.Sleep(1000);
            Assert.IsTrue(browser.ContainsText("Trading Center"));
        }

        [Test]
        public void T07_HermesFAQ_CheckTradingCenter_06()
        {
            browser.GoTo(URL);
            browser.Button(Find.ById("uxHelpCenter")).WaitUntilExists();
            browser.Button(Find.ById("uxHelpCenter")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxBreadcrumbTrail_uxTopLevel")).WaitUntilExists();
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl09_uxCategoryContainer")).Click();
            System.Threading.Thread.Sleep(1000);
            browser.Link(Find.ByText("How do I place a trailing stop order?")).Click();
            System.Threading.Thread.Sleep(1000);
            Assert.IsTrue(browser.ContainsText("Trading Center"));
        }

        [Test]
        public void T08_HermesFAQ_CheckTradingCenter_07()
        {
            browser.GoTo(URL);
            browser.Button(Find.ById("uxHelpCenter")).WaitUntilExists();
            browser.Button(Find.ById("uxHelpCenter")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxBreadcrumbTrail_uxTopLevel")).WaitUntilExists();
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl09_uxCategoryContainer")).Click();
            System.Threading.Thread.Sleep(1000);
            browser.Link(Find.ByText("Can I buy foreign ordinary shares?")).Click();
            System.Threading.Thread.Sleep(1000);
            Assert.IsTrue(browser.ContainsText("Trading Center"));
        }

        [Test]
        public void T09_HermesFAQ_CheckTradingCenter_08()
        {
            browser.GoTo(URL);
            browser.Button(Find.ById("uxHelpCenter")).WaitUntilExists();
            browser.Button(Find.ById("uxHelpCenter")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxBreadcrumbTrail_uxTopLevel")).WaitUntilExists();
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl09_uxCategoryContainer")).Click();
            System.Threading.Thread.Sleep(1000);
            browser.Link(Find.ByText("Do you offer extended hours trading?")).Click();
            System.Threading.Thread.Sleep(1000);
            Assert.IsTrue(browser.ContainsText("Trading Center"));
        }

        [Test]
        public void T10_HermesFAQ_CheckTradingCenter_09()
        {
            browser.GoTo(URL);
            browser.Button(Find.ById("uxHelpCenter")).WaitUntilExists();
            browser.Button(Find.ById("uxHelpCenter")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxBreadcrumbTrail_uxTopLevel")).WaitUntilExists();
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl09_uxCategoryContainer")).Click();
            System.Threading.Thread.Sleep(1000);
            browser.Link(Find.ByText("How do I get a real time quote for a stock?")).Click();
            System.Threading.Thread.Sleep(1000);
            Assert.IsTrue(browser.ContainsText("Trading Center"));
        }

        [Test]
        public void T11_HermesFAQ_CheckTradingCenter_10()
        {
            browser.GoTo(URL);
            browser.Button(Find.ById("uxHelpCenter")).WaitUntilExists();
            browser.Button(Find.ById("uxHelpCenter")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxBreadcrumbTrail_uxTopLevel")).WaitUntilExists();
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl09_uxCategoryContainer")).Click();
            System.Threading.Thread.Sleep(1000);
            browser.Link(Find.ByText("How do I get a real time quote for options?")).Click();
            System.Threading.Thread.Sleep(1000);
            Assert.IsTrue(browser.ContainsText("Trading Center"));
        }

        [Test]
        public void T12_HermesFAQ_CheckTradingCenter_11()
        {
            browser.GoTo(URL);
            browser.Button(Find.ById("uxHelpCenter")).WaitUntilExists();
            browser.Button(Find.ById("uxHelpCenter")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxBreadcrumbTrail_uxTopLevel")).WaitUntilExists();
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl09_uxCategoryContainer")).Click();
            System.Threading.Thread.Sleep(1000);
            browser.Link(Find.ByText("What is an Advanced order?")).Click();
            System.Threading.Thread.Sleep(1000);
            Assert.IsTrue(browser.ContainsText("Trading Center"));
        }

        [Test]
        public void T13_HermesFAQ_CheckTradingCenter_12()
        {
            browser.GoTo(URL);
            browser.Button(Find.ById("uxHelpCenter")).WaitUntilExists();
            browser.Button(Find.ById("uxHelpCenter")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxBreadcrumbTrail_uxTopLevel")).WaitUntilExists();
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl09_uxCategoryContainer")).Click();
            System.Threading.Thread.Sleep(1000);
            browser.Link(Find.ByText("What is a One-Cancels-Others (OCO) order?")).Click();
            System.Threading.Thread.Sleep(1000);
            Assert.IsTrue(browser.ContainsText("Trading Center"));
        }

        [Test]
        public void T14_HermesFAQ_CheckTradingCenter_13()
        {
            browser.GoTo(URL);
            browser.Button(Find.ById("uxHelpCenter")).WaitUntilExists();
            browser.Button(Find.ById("uxHelpCenter")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxBreadcrumbTrail_uxTopLevel")).WaitUntilExists();
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl09_uxCategoryContainer")).Click();
            System.Threading.Thread.Sleep(1000);
            browser.Link(Find.ByText("What is a One-Triggers-Others (OTO) order?")).Click();
            System.Threading.Thread.Sleep(1000);
            Assert.IsTrue(browser.ContainsText("Trading Center"));
        }

        [Test]
        public void T15_HermesFAQ_CheckTradingCenter_14()
        {
            browser.GoTo(URL);
            browser.Button(Find.ById("uxHelpCenter")).WaitUntilExists();
            browser.Button(Find.ById("uxHelpCenter")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxBreadcrumbTrail_uxTopLevel")).WaitUntilExists();
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl09_uxCategoryContainer")).Click();
            System.Threading.Thread.Sleep(1000);
            browser.Link(Find.ByText("What is a Bracket order?")).Click();
            System.Threading.Thread.Sleep(1000);
            Assert.IsTrue(browser.ContainsText("Trading Center"));
        }

        [Test]
        public void T16_HermesFAQ_CheckTradingCenter_15()
        {
            browser.GoTo(URL);
            browser.Button(Find.ById("uxHelpCenter")).WaitUntilExists();
            browser.Button(Find.ById("uxHelpCenter")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxBreadcrumbTrail_uxTopLevel")).WaitUntilExists();
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl09_uxCategoryContainer")).Click();
            System.Threading.Thread.Sleep(1000);
            browser.Link(Find.ByText("I just sold some stocks or options in my account. Why is my buying power the same?")).Click();
            System.Threading.Thread.Sleep(1000);
            Assert.IsTrue(browser.ContainsText("Trading Center"));
        }

        [Test]
        public void T17_HermesFAQ_CheckTradingCenter_16()
        {
            browser.GoTo(URL);
            browser.Button(Find.ById("uxHelpCenter")).WaitUntilExists();
            browser.Button(Find.ById("uxHelpCenter")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxBreadcrumbTrail_uxTopLevel")).WaitUntilExists();
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl09_uxCategoryContainer")).Click();
            System.Threading.Thread.Sleep(1000);
            browser.Link(Find.ByText("How do I access my monthly statements and trading confirmations?")).Click();
            System.Threading.Thread.Sleep(1000);
            Assert.IsTrue(browser.ContainsText("Trading Center"));
        }

        [Test]
        public void T18_HermesFAQ_CheckTradingCenter_17()
        {
            browser.GoTo(URL);
            browser.Button(Find.ById("uxHelpCenter")).WaitUntilExists();
            browser.Button(Find.ById("uxHelpCenter")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxBreadcrumbTrail_uxTopLevel")).WaitUntilExists();
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl09_uxCategoryContainer")).Click();
            System.Threading.Thread.Sleep(1000);
            browser.Link(Find.ByText("Can I get duplicates of my trade confirmations and monthly statements?")).Click();
            System.Threading.Thread.Sleep(1000);
            Assert.IsTrue(browser.ContainsText("Trading Center"));
        }

        [Test]
        public void T19_HermesFAQ_CheckTradingCenter_18()
        {
            browser.GoTo(URL);
            browser.Button(Find.ById("uxHelpCenter")).WaitUntilExists();
            browser.Button(Find.ById("uxHelpCenter")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxBreadcrumbTrail_uxTopLevel")).WaitUntilExists();
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl09_uxCategoryContainer")).Click();
            System.Threading.Thread.Sleep(1000);
            browser.Link(Find.ByText("What is a Good Faith Violation?")).Click();
            System.Threading.Thread.Sleep(1000);
            Assert.IsTrue(browser.ContainsText("Trading Center"));
        }
    }
}
