using System;
using System.Collections.Generic;
using System.Text;
using System.Threading;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;
using System.Text.RegularExpressions;

///////////////////////////////////////
/*** author:bobby  date:2009/11/4  ***/
/*** modify by:    date            ***/
/***                               ***/
///////////////////////////////////////
namespace MaiaRegression.Tasks.Spring5
{
    [TestFixture]
    public class S006_AD_Option : SignIn
    {
        [Test]
        public void T01_AD_Option_LTInvestors()
        {
            
            UserSignIn(UN, PW, false, 0);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl04_uxSubNavRepeater_ctl02_uxSubNavLink")).Click();
            browser.WaitUntilContainsText("Advanced Search Options");
            System.Threading.Thread.Sleep(10000);
            /*
            while (browser.Image(Find.BySrc(new Regex("spinner2.gif"))).Exists)
            {
                System.Threading.Thread.Sleep(5000);
            }*/

            browser.Element(Find.ById("uxSearchAdvanceOption")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxLongTerm")).Click();
            Assert.IsTrue(browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxltBuy")).Checked);
            Assert.IsTrue(browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxFixed")).Checked);
            Assert.IsTrue(browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxConservative")).Checked);
          
           
        }

        [Test]
        public void T02_AD_Option_ActiveTrade()
        {
           
            UserSignIn(UN, PW, false, 0);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl04_uxSubNavRepeater_ctl02_uxSubNavLink")).Click();
            browser.WaitUntilContainsText("Advanced Search Options");
            System.Threading.Thread.Sleep(10000);
            /*
            while (browser.Image(Find.BySrc(new Regex("spinner2.gif"))).Exists)
            {
                System.Threading.Thread.Sleep(5000);
            }*/

            browser.Element(Find.ById("uxSearchAdvanceOption")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxActive")).Click();
            Assert.IsTrue(browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxstTrend")).Checked);
            Assert.IsTrue(browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxstDay")).Checked);
            Assert.IsTrue(browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMomentum")).Checked);

        }

        [Test]
        public void T03_AD_Option_NewInvestors()
        {

            UserSignIn(UN, PW, false, 0);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl04_uxSubNavRepeater_ctl02_uxSubNavLink")).Click();
            browser.WaitUntilContainsText("Advanced Search Options");
            System.Threading.Thread.Sleep(10000);
            /*
            while (browser.Image(Find.BySrc(new Regex("spinner2.gif"))).Exists)
            {
                System.Threading.Thread.Sleep(5000);
            }*/

            browser.Element(Find.ById("uxSearchAdvanceOption")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNew")).Click();
            Assert.IsFalse(browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxltBuy")).Checked);
            Assert.IsFalse(browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxstTrend")).Checked);
            Assert.IsFalse(browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxstDay")).Checked);
            Assert.IsFalse(browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMomentum")).Checked);
            Assert.IsFalse(browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxAggressive")).Checked);
            Assert.IsFalse(browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxGrowth")).Checked);
            Assert.IsFalse(browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBalanced")).Checked);
            Assert.IsFalse(browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxFixed")).Checked);
            Assert.IsFalse(browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxConservative")).Checked);

        }

        [Test]
        public void T04_AD_Option_TradingVeterans()
        {
            
            UserSignIn(UN, PW, false, 0);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl04_uxSubNavRepeater_ctl02_uxSubNavLink")).Click();
            browser.WaitUntilContainsText("Advanced Search Options");
            System.Threading.Thread.Sleep(10000);
            /*
            while (browser.Image(Find.BySrc(new Regex("spinner2.gif"))).Exists)
            {
                System.Threading.Thread.Sleep(5000);
            }*/

            browser.Element(Find.ById("uxSearchAdvanceOption")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxTrading")).Click();
            Assert.IsFalse(browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxltBuy")).Checked);
            Assert.IsFalse(browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxstTrend")).Checked);
            Assert.IsFalse(browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxstDay")).Checked);
            Assert.IsFalse(browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMomentum")).Checked);
            Assert.IsFalse(browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxAggressive")).Checked);
            Assert.IsFalse(browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxGrowth")).Checked);
            Assert.IsFalse(browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBalanced")).Checked);
            Assert.IsFalse(browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxFixed")).Checked);
            Assert.IsFalse(browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxConservative")).Checked);

        }
        /*
        [Test]
        public void T05_AD_Option_MoveSlide()
        {
            
            //block
            if (browser.Link(Find.ByText("Sign Out")).Exists == true)
            {
                browser.Link(Find.ByText("Sign Out")).Click();
            }
            UserSignIn(UN, PW, false, 0);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl04_uxSubNavRepeater_ctl02_uxSubNavLink")).Click();
            browser.WaitUntilContainsText("Advanced Options");
            browser.Image(Find.ById("imgtwosearchmember")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSliderExperience_uxShowSlider")).Click();
            
            

        }

        [Test]
        public void T06_AD_Option_Search()
        {
            //block
            
            if (browser.Link(Find.ByText("Sign Out")).Exists == true)
            {
                browser.Link(Find.ByText("Sign Out")).Click();
            }
            UserSignIn(UN, PW, false, 0);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl04_uxSubNavRepeater_ctl02_uxSubNavLink")).Click();
            browser.WaitUntilContainsText("Advanced Options");
            browser.Image(Find.ById("imgtwosearchmember")).Click();
            
            


        }*/
    }
}
