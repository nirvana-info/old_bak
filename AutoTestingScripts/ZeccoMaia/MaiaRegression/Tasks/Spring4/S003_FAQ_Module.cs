using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks.Spring4
{
    [TestFixture]
    public class S003_FAQ_Module : SignIn
    {
        [Test]
        public void T01_FAQ_MostAsked()
        {
            this.GotoFAQ();
            browser.WaitForComplete();
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl01_uxCategoryContainer")).Click();
            Assert.IsTrue(browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxFAQMosk_uxContentPartDiv")).Exists);
        }

        [Test]
        public void T02_FAQ_AccountOpen()
        {
            this.GotoFAQ();
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl02_uxCategoryContainer")).WaitUntilExists(10);
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl02_uxCategoryContainer")).Click();
            //browser.Div(Find.ById("Sidebar")).Link(Find.ByText("Account Opening Process")).Click();
            browser.Link(Find.ByText("What is the minimum deposit required to open a Zecco Trading account?")).Click();
            browser.WaitForComplete();
            Assert.IsTrue(browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxAccountOpen_uxContentPartDiv")).Exists);
        }

        [Test]
        public void T03_FAQ_FundingTransfer()
        {
            this.GotoFAQ();
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl03_uxCategoryContainer")).WaitUntilExists(10);
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl03_uxCategoryContainer")).Click();
            browser.Link(Find.ByText("How do I deposit funds into my Zecco Trading account?")).Click();
            browser.WaitForComplete();
            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxFAQFundingTransfers_uxContentPartDiv")).WaitUntilExists(10);
            Assert.IsTrue(browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxFAQFundingTransfers_uxContentPartDiv")).Exists);
        }

        [Test]
        public void T04_FAQ_Retirements()
        {
            this.GotoFAQ();
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl04_uxCategoryContainer")).WaitUntilExists(10);
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl04_uxCategoryContainer")).Click();
            browser.Link(Find.ByText("What type of IRA accounts do you offer?")).Click();
            browser.WaitForComplete();
            Assert.IsTrue(browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxRetirement_uxContentPartDiv")).Exists);
        }

        [Test]
        public void T05_FAQ_ServiceFee()
        {
            this.GotoFAQ();
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl05_uxCategoryContainer")).WaitUntilExists(10);
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl05_uxCategoryContainer")).Click();
            browser.Link(Find.ByText("What are the commission rates at Zecco Trading?")).Click();
            browser.WaitForComplete();
            Assert.IsTrue(browser.ContainsText("What are the commission rates at Zecco Trading"));
            Assert.AreEqual(browser.Title.Trim(), "FAQ: Commissions, Rates, and Fees – Zecco Trading");
        }

        [Test]
        public void T06_FAQ_TradeOrder()
        {
            this.GotoFAQ();
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl06_uxCategoryContainer")).WaitUntilExists(10);
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl06_uxCategoryContainer")).Click();
            browser.Link(Find.ByText("How do I place a stock trade?")).Click();
            browser.WaitForComplete();
            Assert.IsTrue(browser.ContainsText("How do I place a stock trade"));
        }

        [Test]
        public void T07_FAQ_MarginInformation()
        {
            this.GotoFAQ();
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl07_uxCategoryContainer")).WaitUntilExists(10);
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl07_uxCategoryContainer")).Click();
            browser.Link(Find.ByText("How does margin work?")).Click();
            browser.WaitForComplete();
            Assert.IsTrue(browser.ContainsText("How does margin work"));
        }

        [Test]
        public void T08_FAQ_OptionExpiration()
        {
            this.GotoFAQ();
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl08_uxCategoryContainer")).WaitUntilExists(10);
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl08_uxCategoryContainer")).Click();
            browser.Link(Find.ByText("What is a call option?")).Click();
            browser.WaitForComplete();
            Assert.IsTrue(browser.ContainsText("What is a call option"));
        }

        [Test]
        public void T09_FAQ_PremiumTool()
        {
            this.GotoFAQ();
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl09_uxCategoryContainer")).WaitUntilExists(10);
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl09_uxCategoryContainer")).Click();
            browser.Link(Find.ByText("Are there any tools available to help me with tax filing?")).Click();
            browser.WaitForComplete();
            Assert.IsTrue(browser.ContainsText("Are there any tools available to help me with tax filing"));
        }

        [Test]
        public void T10_FAQ_SystemRequirement()
        {
            this.GotoFAQ();
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl10_uxCategoryContainer")).WaitUntilExists(10);
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl10_uxCategoryContainer")).Click();
            browser.Link(Find.ByText("Operating System and Browsers")).Click();
            browser.WaitForComplete();
            Assert.IsTrue(browser.ContainsText("Operating System and Browsers"));
        }

        [Test]
        public void T11_FAQ_FriendProgram()
        {
            this.GotoFAQ();
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl11_uxCategoryContainer")).WaitUntilExists(10);
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl11_uxCategoryContainer")).Click();
            browser.Link(Find.ByText("What is the Zecco Friends Program?")).Click();
            browser.WaitForComplete();
            Assert.IsTrue(browser.ContainsText("What is the Zecco Friends Program"));
        }

        [Test]
        public void T12_FAQ_Community()
        {
            this.GotoFAQ();
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl12_uxCategoryContainer")).WaitUntilExists(10);
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl12_uxCategoryContainer")).Click();
            browser.Link(Find.ByText("How do I share my positions and trades?")).Click();
            browser.WaitForComplete();
            Assert.IsTrue(browser.ContainsText("How do I share my positions and trades"));
        }

        private void GotoFAQ()
        {
            UserSignIn(UN, PW, false, 0);
            browser.Link(Find.ById("uxHelpCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxHelpCenter")).Click();
            browser.WaitForComplete();

            //browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl00_uxCategoryContainer")).Click();
        }
    }
}
