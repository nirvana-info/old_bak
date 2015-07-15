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

namespace MaiaRegression.Tasks.Spring6
{
    [TestFixture]
    public class S005_Community_Reputation : SignIn
    {
        [Test]
        public void T01_Dashboard_Reputation()
        {
            GotoDashboard();
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl04_uxTopNavLink")).Click();
            //Check reputation ranking on community Dashboard pag
            Thread.Sleep(200);
            browser.Span(Find.ByClass("widges wordwrap")).WaitUntilExists(120);
            //Assert.AreEqual("aa", browser.Div(Find.ByClass("wordwrap")).Text);
            Assert.IsTrue(browser.Image(Find.ById("Image5")).Exists);
        }

        [Test]
        public void T02_Profile_Reputation()
        {
            GotoDashboard();
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl04_uxSubNavRepeater_ctl01_uxSubNavLink")).Click();
            browser.WaitForComplete();
            //Check reputation ranking on member profile page
            Assert.IsTrue(browser.Image(Find.ById("uxPostRankImage")).Exists);
        }

        [Test]
        public void T03_Connection_Reputation()
        {

            GotoDashboard();
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl04_uxSubNavRepeater_ctl01_uxSubNavLink")).Click();
            browser.WaitForComplete();
            browser.Link(Find.ById("uxConnectionsViewAllLink")).Click();
            browser.WaitForComplete();
            //Check reputation ranking on member connections page
            Assert.IsTrue(browser.Image(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberProfileBox_uxPostRankImage")).Exists);
        }

        [Test]
        public void T04_Groups_Reputation()
        {
            
            UserSignIn(UN, PW, false, 0);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl04_uxSubNavRepeater_ctl03_uxSubNavLink")).Click();
            browser.WaitUntilContainsText("Groups Found");
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSearchBar")).TypeText("Zecco Associates");
            browser.WaitForComplete(30);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSearch")).Click();
            browser.WaitUntilContainsText("[1] Groups Found");
            browser.Span(Find.ById("uxViewGroupLink")).Click();
            browser.WaitUntilContainsText("About This Group");
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxMembersViewAll")).Click();

            //Check reputation ranking on group members page
            browser.WaitUntilContainsText("Group Owner(s)");
            Assert.IsTrue(browser.Image(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxDetailList_ctl00_ctl05_Img1")).Exists);
        }

        [Test]
        public void T05_Member_Reputation()
        {
            
            UserSignIn(UN, PW, false, 0);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl04_uxSubNavRepeater_ctl02_uxSubNavLink")).Click();
            browser.WaitUntilContainsText("Advanced Search Options");
            System.Threading.Thread.Sleep(10000);
            /*
            while (browser.Image(Find.BySrc(new Regex("spinner2.gif"))).Exists)
            {
                System.Threading.Thread.Sleep(1000);
            }*/
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxScreenName")).TypeText("tonyleach");
            browser.WaitForComplete(30);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSimpleSearch")).Click();
            Thread.Sleep(200);
            //Check reputation ranking on member search page
            Assert.IsTrue(browser.Image(Find.ById("uxPostRankImage")).Exists);
        }

        [Test]
        public void T06_Forum_Reputation()
        {
            
            UserSignIn(UN, PW, false, 0);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl04_uxSubNavRepeater_ctl04_uxSubNavLink")).Click();
            browser.Span(Find.ByClass("wordwrap")).WaitUntilExists();
            browser.Link(Find.ByClass("tagtext-wordwrap")).Click();
            browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxThreadTitle")).WaitUntilExists();
            //Check reputation ranking on forum thread page
            Assert.IsTrue(browser.Image(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_Img1")).Exists);
        }

        [Test]
        public void T07_Blog_Reputation()
        {
            
            UserSignIn(UN, PW, false, 0);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl04_uxSubNavRepeater_ctl04_uxSubNavLink")).Click();
            browser.Span(Find.ByClass("wordwrap")).WaitUntilExists();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMoreBlogsLink")).Click();
            System.Threading.Thread.Sleep(10000);
            /*
            while (browser.Image(Find.BySrc(new Regex("spinner2.gif"))).Exists)
            {
                System.Threading.Thread.Sleep(1000);
            }
            */
            browser.Link(Find.ByClass("tagtext-wordwrap")).Click();
            //Check reputation ranking on blog post page
            Assert.IsTrue(browser.Image(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_Img1")).Exists);
        }
        /*
        [Test]
        public void T08_Blog_Post()
        {

            UserSignIn(UN, PW, false, 0);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl04_uxSubNavRepeater_ctl05_uxSubNavLink")).Click();
            browser.Span(Find.ByClass("wordwrap")).WaitUntilExists();
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxGoToZeccoBlog")).Click();
            System.Threading.Thread.Sleep(10000);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBlogPostTitle")).TypeText("wftest20100105");
            browser.Frame(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostBody_contentIframe")).Element(Find.ByElement("body")).Text = "sdf";
        }
        */
        private void GotoDashboard()
        {
            UserSignIn(UN1, PW1, false, 0);
            if (browser.Link(Find.ByText("Dashboard")).Exists == false)
            {
                browser.Span(Find.ByText("COMMUNITY")).Click();
                //browser.Link(Find.ByText("Dashboard")).Click();
            }
            browser.WaitForComplete(30);
        }
    }
}

