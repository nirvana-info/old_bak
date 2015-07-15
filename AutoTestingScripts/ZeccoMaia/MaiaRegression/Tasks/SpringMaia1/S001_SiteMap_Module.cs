using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks.SpringMaia1
{
    [TestFixture]
    public class S001_SiteMap_Module : SignIn
    {
        [Test]
        public void T01_SiteMap_Explore()
        {
            UserSignIn(UN, PW, false, 2);
            browser.WaitForComplete();
            browser.Div(Find.ById("ctl00_ctl00_uxPostContent_uxBottomNavigation_uxFooterLinks")).Link(Find.ByText("Zecco Site Map")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Link(Find.ByText("ZeccoShare Community")).Url.Contains("/explore/community.aspx"));
        }

        [Test]
        public void T02_SiteMap_Trading()
        {
            UserSignIn(UN, PW, false, 2);
            browser.WaitForComplete();
            browser.Div(Find.ById("ctl00_ctl00_uxPostContent_uxBottomNavigation_uxFooterLinks")).Link(Find.ByText("Zecco Site Map")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Link(Find.ByText("Trading Center")).Exists);
            Assert.IsTrue(browser.Link(Find.ByText("Funding and Transfers")).Exists);
        }

        [Test]
        public void T03_SiteMap_Forex()
        {
            UserSignIn(UN, PW, false, 2);
            browser.WaitForComplete();
            browser.Div(Find.ById("ctl00_ctl00_uxPostContent_uxBottomNavigation_uxFooterLinks")).Link(Find.ByText("Zecco Site Map")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Link(Find.ByText("Start Forex")).Exists);
        }

        [Test]
        public void T04_SiteMap_Community()
        {
            UserSignIn(UN, PW, false, 2);
            browser.WaitForComplete();
            browser.Div(Find.ById("ctl00_ctl00_uxPostContent_uxBottomNavigation_uxFooterLinks")).Link(Find.ByText("Zecco Site Map")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Link(Find.ByText("My Profile")).Exists);
        }

        [Test]
        public void T05_SiteMap_Education()
        {
            UserSignIn(UN, PW, false, 2);
            browser.WaitForComplete();
            browser.Div(Find.ById("ctl00_ctl00_uxPostContent_uxBottomNavigation_uxFooterLinks")).Link(Find.ByText("Zecco Site Map")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Link(Find.ByText("Stock Trading")).Exists);
        }

        [Test]
        public void T06_SiteMap_Explore_NotFound()
        {
            UserSignIn(UN, PW, false, 2);
            browser.GoTo(targetHost + "/NotFound.aspx");
            browser.WaitForComplete();
            browser.Div(Find.ById("ctl00_ctl00_uxPostContent_uxBottomNavigation_uxFooterLinks")).Link(Find.ByText("Zecco Site Map")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Link(Find.ByText("ZeccoShare Community")).Url.Contains("/explore/community.aspx"));
        }

        [Test]
        public void T07_SiteMap_Trading_NotFound()
        {
            UserSignIn(UN, PW, false, 2);
            browser.GoTo(targetHost + "/NotFound.aspx");
            browser.WaitForComplete();
            browser.Div(Find.ById("ctl00_ctl00_uxPostContent_uxBottomNavigation_uxFooterLinks")).Link(Find.ByText("Zecco Site Map")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Link(Find.ByText("Trading Center")).Exists);
            Assert.IsTrue(browser.Link(Find.ByText("Funding and Transfers")).Exists);
        }

        [Test]
        public void T08_SiteMap_Forex_NotFound()
        {
            UserSignIn(UN, PW, false, 2);
            browser.GoTo(targetHost + "/NotFound.aspx");
            browser.WaitForComplete();
            browser.Div(Find.ById("ctl00_ctl00_uxPostContent_uxBottomNavigation_uxFooterLinks")).Link(Find.ByText("Zecco Site Map")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Link(Find.ByText("Start Forex")).Exists);
        }

        [Test]
        public void T09_SiteMap_Community_NotFound()
        {
            UserSignIn(UN, PW, false, 2);
            browser.GoTo(targetHost + "/NotFound.aspx");
            browser.WaitForComplete();
            browser.Div(Find.ById("ctl00_ctl00_uxPostContent_uxBottomNavigation_uxFooterLinks")).Link(Find.ByText("Zecco Site Map")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Link(Find.ByText("My Profile")).Exists);
        }

        [Test]
        public void T10_SiteMap_Education_NotFound()
        {
            UserSignIn(UN, PW, false, 2);
            browser.GoTo(targetHost + "/NotFound.aspx");
            browser.WaitForComplete();
            browser.Div(Find.ById("ctl00_ctl00_uxPostContent_uxBottomNavigation_uxFooterLinks")).Link(Find.ByText("Zecco Site Map")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Link(Find.ByText("Stock Trading")).Exists);
        }

        [Test]
        public void T11_SiteMap_Explore_NotAuthorized()
        {
            UserSignIn(UN, PW, false, 2);
            browser.GoTo(targetHost + "/NotAuthorized.aspx");
            browser.WaitForComplete();
            browser.Div(Find.ById("ctl00_ctl00_uxPostContent_uxBottomNavigation_uxFooterLinks")).Link(Find.ByText("Zecco Site Map")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Link(Find.ByText("ZeccoShare Community")).Url.Contains("/explore/community.aspx"));
        }

        [Test]
        public void T12_SiteMap_Trading_NotAuthorized()
        {
            UserSignIn(UN, PW, false, 2);
            browser.GoTo(targetHost + "/NotAuthorized.aspx");
            browser.WaitForComplete();
            browser.Div(Find.ById("ctl00_ctl00_uxPostContent_uxBottomNavigation_uxFooterLinks")).Link(Find.ByText("Zecco Site Map")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Link(Find.ByText("Trading Center")).Exists);
            Assert.IsTrue(browser.Link(Find.ByText("Funding and Transfers")).Exists);
        }

        [Test]
        public void T13_SiteMap_Forex_NotAuthorized()
        {
            UserSignIn(UN, PW, false, 2);
            browser.GoTo(targetHost + "/NotAuthorized.aspx");
            browser.WaitForComplete();
            browser.Div(Find.ById("ctl00_ctl00_uxPostContent_uxBottomNavigation_uxFooterLinks")).Link(Find.ByText("Zecco Site Map")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Link(Find.ByText("Start Forex")).Exists);
        }

        [Test]
        public void T14_SiteMap_Community_NotAuthorized()
        {
            UserSignIn(UN, PW, false, 2);
            browser.GoTo(targetHost + "/NotAuthorized.aspx");
            browser.WaitForComplete();
            browser.Div(Find.ById("ctl00_ctl00_uxPostContent_uxBottomNavigation_uxFooterLinks")).Link(Find.ByText("Zecco Site Map")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Link(Find.ByText("My Profile")).Exists);
        }

        [Test]
        public void T15_SiteMap_Education_NotAuthorized()
        {
            UserSignIn(UN, PW, false, 2);
            browser.GoTo(targetHost + "/NotAuthorized.aspx");
            browser.WaitForComplete();
            browser.Div(Find.ById("ctl00_ctl00_uxPostContent_uxBottomNavigation_uxFooterLinks")).Link(Find.ByText("Zecco Site Map")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Link(Find.ByText("Stock Trading")).Exists);
        }

        [Test]
        public void T16_SiteMap_Explore_GenericError()
        {
            UserSignIn(UN, PW, false, 2);
            browser.GoTo(targetHost + "/GenericError.aspx");
            browser.WaitForComplete();
            browser.Div(Find.ById("ctl00_ctl00_uxPostContent_uxBottomNavigation_uxFooterLinks")).Link(Find.ByText("Zecco Site Map")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Link(Find.ByText("ZeccoShare Community")).Url.Contains("/explore/community.aspx"));
        }

        [Test]
        public void T17_SiteMap_Trading_GenericError()
        {
            UserSignIn(UN, PW, false, 2);
            browser.GoTo(targetHost + "/GenericError.aspx");
            browser.WaitForComplete();
            browser.Div(Find.ById("ctl00_ctl00_uxPostContent_uxBottomNavigation_uxFooterLinks")).Link(Find.ByText("Zecco Site Map")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Link(Find.ByText("Trading Center")).Exists);
            Assert.IsTrue(browser.Link(Find.ByText("Funding and Transfers")).Exists);
        }

        [Test]
        public void T18_SiteMap_Forex_GenericError()
        {
            UserSignIn(UN, PW, false, 2);
            browser.GoTo(targetHost + "/GenericError.aspx");
            browser.WaitForComplete();
            browser.Div(Find.ById("ctl00_ctl00_uxPostContent_uxBottomNavigation_uxFooterLinks")).Link(Find.ByText("Zecco Site Map")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Link(Find.ByText("Start Forex")).Exists);
        }

        [Test]
        public void T19_SiteMap_Community_GenericError()
        {
            UserSignIn(UN, PW, false, 2);
            browser.GoTo(targetHost + "/GenericError.aspx");
            browser.WaitForComplete();
            browser.Div(Find.ById("ctl00_ctl00_uxPostContent_uxBottomNavigation_uxFooterLinks")).Link(Find.ByText("Zecco Site Map")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Link(Find.ByText("My Profile")).Exists);
        }

        [Test]
        public void T20_SiteMap_Education_GenericError()
        {
            UserSignIn(UN, PW, false, 2);
            browser.GoTo(targetHost + "/GenericError.aspx");
            browser.WaitForComplete();
            browser.Div(Find.ById("ctl00_ctl00_uxPostContent_uxBottomNavigation_uxFooterLinks")).Link(Find.ByText("Zecco Site Map")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Link(Find.ByText("Stock Trading")).Exists);
        }
    }
}
