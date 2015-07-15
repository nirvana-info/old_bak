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
    public class S009_Static_Page_Display_Module:SignIn
    {
        [Test]
        public void T02_StaticPageDisplay_Backers()
        {
            browser.GoToNoWait(targetHost + "/aboutus/backers.aspx");
            //Assert.AreEqual("Backers & Investors ", browser.Div("MainColumn").Div(Find.ByClass("float-left gutter trail")).Text);
        }

        [Test]
        public void T04_StaticPageDisplay_Careers()
        {
            browser.GoToNoWait(targetHost + "/aboutus/careers.aspx");
            //Assert.AreEqual("Join The Team ", browser.Div("MainColumn").Div(Find.ByClass("float-left gutter trail")).Text);
        }

        [Test]
        public void T07_StaticPageDisplay_Newsmentions()
        {
            browser.Link(Find.ByText("Zecco in the Media")).Click();
            Assert.AreEqual("In the News", browser.Span(Find.ByClass("rtsTxt")).Text);
        }

        [Test]
        public void T08_StaticPageDisplay_Partners()
        {
            browser.Link(Find.ByText("Zecco Partners")).Click();
            string t1=browser.Div("MainColumn").Div(Find.ByClass("contentpart")).Text;
            string t2=t1.Trim().Substring(0,21);
            Assert.AreEqual("Zecco Partner Network",t2);
        }

        [Test]
        public void T09_StaticPageDisplay_Pressreleases()
        {
            browser.Link(Find.ByText("Zecco in the Media")).Click();
            browser.Span(Find.ByText("Press Releases")).Click();
            Assert.IsTrue(browser.ContainsText("Press Releases - 2009"));
        }

        [Test]
        public void T10_StaticPageDisplay_Prkit()
        {
            browser.GoToNoWait(targetHost + "/aboutus/prkit.aspx");
            //Assert.AreEqual("Press & Marketing ", browser.Div("MainColumn").Div(Find.ByClass("float-left gutter trail")).Text);
        }

        [Test]
        public void T11_StaticPageDisplay_Security()
        {
            browser.GoToNoWait(targetHost + "/aboutus/security.aspx");
            //Assert.AreEqual("Is Your Money Safe ", browser.Div("MainColumn").Div(Find.ByClass("float-left gutter")).Text);
        }

        [Test]
        public void T13_StaticPageDisplay_Team()
        {
            browser.Link(Find.ByText("The Zecco Team")).Click();
            Assert.IsTrue(browser.ContainsText("Zecco Holdings Management Team"));
        }

        [Test]
        public void T14_StaticPageDisplay_WelcomeToZecco()
        {
            UserSignIn(UN,PW,false,0);
            browser.GoToNoWait(targetHost + "/aboutus/WelcomeToZecco.aspx");
            //browser.Div(Find.ByClass("welcome")).WaitUntilExists(10);

            SignOut so = new SignOut();
            so.UserSignOut(browser);
        }

        [Test]
        public void T17_StaticPageDisplay_ZeccoTradingSupport()
        {
            browser.GoToNoWait(targetHost + "/aboutus/zeccotradingsupport.aspx");
            //Assert.AreEqual("Zecco Trading ", browser.Div("MainColumn").Div(Find.ByClass("float-left gutter")).Text);
        }
        
        [Test]
        public void T18_StaticPageDisplay_Education()
        {
            browser.GoToNoWait(targetHost + "/education/");
            //Assert.AreEqual("Education", browser.Div("MainColumn").Div(Find.ByClass("float-left gutter")).Link("ctl00_ctl00_uxMainContent_uxBreadcrumbTrail_uxSecondLevel").Text);
        }

        [Test]
        public void T19_StaticPageDisplay_EducationBearMarketStrategies()
        {
            browser.GoToNoWait(targetHost + "/education/bear-market-strategies.aspx");
            //Assert.AreEqual("Topics ", browser.Div("MainColumn").Div(Find.ByClass("float-left gutter trail")).Text);
        }

        [Test]
        public void T20_StaticPageDisplay_EducationGlossary()
        {
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl03_uxSubNavRepeater_ctl02_uxSubNavLink")).Click();
            browser.Link(Find.ByTitle("Glossary")).Click();
            Assert.IsTrue(browser.ContainsText("Glossary of Investing Terms"));
        }

        [Test]
        public void T21_StaticPageDisplay_EducationOil()
        {
            browser.GoToNoWait(targetHost + "/education/oil.aspx");
            //Assert.AreEqual("Topics ", browser.Div("MainColumn").Div(Find.ByClass("float-left gutter trail")).Text);
        }

        [Test]
        public void T22_StaticPageDisplay_EducationStocks()
        {
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl03_uxSubNavRepeater_ctl02_uxSubNavLink")).Click();
            browser.Link(Find.ByTitle("Stocks Learning Center")).Click();
            Assert.IsTrue(browser.ContainsText("Stock Trading Education"));
        }

        [Test]
        public void T23_StaticPageDisplay_EducationStocksHowDoesOnlineTradingWork()
        {
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl03_uxSubNavRepeater_ctl02_uxSubNavLink")).Click();
            browser.Link(Find.ByTitle("How Does Online Trading Work?")).Click();
            Assert.IsTrue(browser.ContainsText("The Basics of Online Trading"));
        }

        [Test]
        public void T24_StaticPageDisplay_EducationStocksOnlineInvestingTips()
        {
            //browser.GoToNoWait(targetHost + "/education/stocks/onlineinvestingtips.aspx");
            //Assert.AreEqual("Online investing tips ", browser.Div("MainColumn").Div(Find.ByClass("float-left gutter trail")).Text);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl03_uxSubNavRepeater_ctl02_uxSubNavLink")).Click();
            browser.Link(Find.ByTitle("Online investing tips")).Click();
            Assert.IsTrue(browser.ContainsText("Tips About Online Investing"));
        }

        [Test]
        public void T25_StaticPageDisplay_EducationStocksSelectinganOnlineBroker()
        {
            //browser.GoToNoWait(targetHost + "/education/stocks/selectinganonlinebroker.aspx");
            //Assert.AreEqual("Selecting an online broker ", browser.Div("MainColumn").Div(Find.ByClass("float-left gutter trail")).Text);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl03_uxSubNavRepeater_ctl02_uxSubNavLink")).Click();
            browser.Link(Find.ByTitle("Selecting an online broker")).Click();
            Assert.IsTrue(browser.ContainsText("Selecting an Online Stock Broker"));
        }

        [Test]
        public void T26_StaticPageDisplay_EducationStocksVisa()
        {
            browser.GoToNoWait(targetHost + "/education/visa-ipo.aspx");
            //Assert.AreEqual("Topics ", browser.Div("MainColumn").Div(Find.ByClass("float-left gutter trail")).Text);
        }
        
        [Test]
        public void T27_StaticPageDisplay_OptionsTradingEducation()
        {
            //browser.GoToNoWait(targetHost + "/optionstradingeducation/");
            //Assert.AreEqual("Options Education ", browser.Div("MainColumn").Div(Find.ByClass("float-left gutter trail")).Text);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl03_uxSubNavRepeater_ctl02_uxSubNavLink")).Click();
            browser.Link(Find.ByTitle("Options Education")).Click();
            Assert.IsTrue(browser.ContainsText("Options Trading Education"));
        }

        [Test]
        public void T28_StaticPageDisplay_OptionsTradingEducationBasic()
        {
            //browser.GoToNoWait(targetHost + "/optionstradingeducation/basics.aspx");
            //Assert.AreEqual("Options Basics ", browser.Div("MainColumn").Div(Find.ByClass("float-left gutter trail")).Text);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl03_uxSubNavRepeater_ctl02_uxSubNavLink")).Click();
            browser.Link(Find.ByTitle("Options Basics")).Click();
            Assert.IsTrue(browser.ContainsText("Options Trading Basics"));
        }

        [Test]
        public void T29_StaticPageDisplay_OptionsTradingEducationBearputSpreadOptions()
        {
            browser.GoToNoWait(targetHost + "/optionstradingeducation/bearputspreadoptions.aspx");
            //Assert.AreEqual("Bear Put Spreads ", browser.Div("MainColumn").Div(Find.ByClass("float-left gutter trail")).Text);
        }

        [Test]
        public void T30_StaticPageDisplay_OptionsTradingEducationBullCallSpreadOptions()
        {
            browser.GoToNoWait(targetHost + "/optionstradingeducation/bullcallspreadoptions.aspx");
            //Assert.AreEqual("Bull Call Spreads ", browser.Div("MainColumn").Div(Find.ByClass("float-left gutter trail")).Text);
        }

        [Test]
        public void T31_StaticPageDisplay_OptionsTradingEducationBullCallSpreadOptions()
        {
            browser.GoToNoWait(targetHost + "/optionstradingeducation/butterflyspreadoptions.aspx");
            //Assert.AreEqual("Butterflies ", browser.Div("MainColumn").Div(Find.ByClass("float-left gutter trail")).Text);
        }

        [Test]
        public void T32_StaticPageDisplay_OptionsTradingEducationCallOptions()
        {
            browser.GoToNoWait(targetHost + "/optionstradingeducation/calloption.aspx");
            //Assert.AreEqual("Call Options ", browser.Div("MainColumn").Div(Find.ByClass("float-left gutter trail")).Text);
        }

        [Test]
        public void T33_StaticPageDisplay_OptionsTradingEducationCoveredCallOption()
        {
            browser.GoToNoWait(targetHost + "/optionstradingeducation/coveredcalloption.aspx");
            //Assert.AreEqual("Covered Calls ", browser.Div("MainColumn").Div(Find.ByClass("float-left gutter trail")).Text);
        }

        [Test]
        public void T34_StaticPageDisplay_OptionsTradingEducationHowToTradeOptions()
        {
            //browser.GoToNoWait(targetHost + "/optionstradingeducation/howtotradeoptions.aspx");
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl03_uxSubNavRepeater_ctl02_uxSubNavLink")).Click();
            browser.Link(Find.ByTitle("How To Trade Options")).Click();
            Assert.IsTrue(browser.ContainsText("Options Trading Strategies"));
        }

        [Test]
        public void T35_StaticPageDisplay_OptionsTradingEducationPutOption()
        {
            browser.GoToNoWait(targetHost + "/optionstradingeducation/putoption.aspx");
            //Assert.AreEqual("Put Options ", browser.Div("MainColumn").Div(Find.ByClass("float-left gutter trail")).Text);
        }

        [Test]
        public void T36_StaticPageDisplay_OptionsTradingEducationStraddleOptions()
        {
            browser.GoToNoWait(targetHost + "/optionstradingeducation/straddleoptions.aspx");
            //Assert.AreEqual("Straddles ", browser.Div("MainColumn").Div(Find.ByClass("float-left gutter trail")).Text);
        }

        [Test]
        public void T37_StaticPageDisplay_OptionsTradingEducationStrangleOptions()
        {
            browser.GoToNoWait(targetHost + "/optionstradingeducation/strangleoptions.aspx");
            //Assert.AreEqual("Strangles ", browser.Div("MainColumn").Div(Find.ByClass("float-left gutter trail")).Text);
        }

        [Test]
        public void T38_StaticPageDisplay_TradingFreeTrading()
        {
            browser.GoToNoWait(targetHost + "/trading/freetrading.aspx");
            //Assert.AreEqual("Zecco Products ", browser.Div("MainColumn").Div(Find.ByClass("float-left gutter")).Text);
        }

        [Test]
        public void T39_StaticPageDisplay_TradingOptions()
        {
            browser.GoToNoWait(targetHost + "/trading/options.aspx");
            //Assert.AreEqual("Options ", browser.Div("MainColumn").Div(Find.ByClass("float-left gutter trail")).Text);
        }

        [Test]
        public void T40_StaticPageDisplay_TradingSecurity()
        {
            browser.GoToNoWait(targetHost + "/trading/security.aspx");
            //Assert.AreEqual("Security ", browser.Div("MainColumn").Div(Find.ByClass("float-left gutter trail")).Text);
        }

        [Test]
        public void T41_StaticPageDisplay_TradingTestimonials()
        {
            browser.GoToNoWait(targetHost + "/trading/testimonials.aspx");
            //Assert.AreEqual("Testimonials ", browser.Div("MainColumn").Div(Find.ByClass("float-left gutter trail")).Text);
        }

        [Test]
        public void T43_StaticPageDisplay_TradingTradingDemoAccountOverview()
        {
            browser.GoToNoWait(targetHost + "/trading/tradingdemoaccountoverview.aspx");
            //Assert.AreEqual("Demo ", browser.Div("MainColumn").Div(Find.ByClass("float-left gutter trail")).Text);
        }

        [Test]
        public void T47_StaticPageDisplay_TradingZeccoAssetAllocation()
        {
            browser.GoToNoWait(targetHost + "/trading/zecco_asset_allocation.aspx");
            //Assert.AreEqual("Retirement ", browser.Div("MainColumn").Div(Find.ByClass("float-left gutter trail")).Text);
        }

        [Test]
        public void T48_StaticPageDisplay_TradingZeccoDiversifiedPortfolio()
        {
            browser.GoToNoWait(targetHost + "/trading/zecco_diversified_portfolio.aspx");
            //Assert.AreEqual("Retirement ", browser.Div("MainColumn").Div(Find.ByClass("float-left gutter trail")).Text);
        }

        [Test]
        public void T49_StaticPageDisplay_TradingZeccoRetirementPlanning()
        {
            browser.GoToNoWait(targetHost + "/trading/zecco_retirement_planning.aspx");
            //Assert.AreEqual("Retirement ", browser.Div("MainColumn").Div(Find.ByClass("float-left gutter trail")).Text);
        }

        [Test]
        public void T50_StaticPageDisplay_TradingZeccoira()
        {
            browser.GoToNoWait(targetHost + "/trading/zeccoira.aspx");
            //Assert.AreEqual("Retirement ", browser.Div("MainColumn").Div(Find.ByClass("float-left gutter trail")).Text);
        }
    }
}
