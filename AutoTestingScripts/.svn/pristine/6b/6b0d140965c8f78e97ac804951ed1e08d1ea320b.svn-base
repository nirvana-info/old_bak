using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks._2011Sprint7
{
    [TestFixture]
    public class S001_MarginSchedule_Module : SignIn
    {
        [Test]
        public void T01_MarginSchedule_HelpPageInfo()
        {
            browser.GoTo(URL + "/help/margin-buying-schedule.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Image(Find.ByAlt("Zecco logo")).Src.Contains("logo_zecco.jpg"));
            Assert.AreEqual(browser.Title.Trim(), "Buying on Margin - Margin Schedule - Zecco Trading");
        }

        [Test]
        public void T02_MarginSchedule_HelpPageContent()
        {
            browser.GoTo(URL + "/help/margin-buying-schedule.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.ContainsText("Margin Schedule"));
            Assert.IsTrue(browser.Table(Find.ByClass("marginscheduletable")).Exists);
        }

        [Test]
        public void T03_MarginSchedule_HelpRightNav()
        {
            browser.GoTo(URL);
            browser.Button(Find.ById("uxHelpCenter")).WaitUntilExists();
            browser.Button(Find.ById("uxHelpCenter")).Click();
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl05_uxCategoryContainer")).Click();
            Assert.IsTrue(browser.Link(Find.ByText("How are margin requirements calculated for individual positions?")).Exists);
        }

        [Test]
        public void T04_MarginSchedule_HelpBody()
        {
            browser.GoTo(URL);
            browser.Button(Find.ById("uxHelpCenter")).WaitUntilExists();
            browser.Button(Find.ById("uxHelpCenter")).Click();
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxFAQSelfService_uxShowData_ctl05_uxCategoryContainer")).Click();
            browser.Link(Find.ByText("How are margin requirements calculated for individual positions?")).Click();
            Assert.IsTrue(browser.ContainsText("How are margin requirements calculated for individual positions?"));
            Assert.IsTrue(browser.Link(Find.ByText("Zecco Trading Margin Schedule")).Exists);
        }
    }
}
