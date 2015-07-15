using System;
using System.Collections.Generic;
using System.Text;
using WatiN.Core;
using NUnit.Framework;
using WatiN.Core.Interfaces;
using WatiN.Core.DialogHandlers;

namespace MaiaRegression.Appobjects.App01_HomePage
{
    public class BlogsForums : SignIn
    {

        public void NavigateToDiscussion(Browser browser)
        {
            UserSignIn(UN, PW, false, 2);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl04_uxSubNavRepeater_ctl01_uxSubNavLink")).Click();
            browser.Link(Find.ByText("Discussions")).Click();
            browser.WaitForComplete(30);
            Assert.IsTrue(browser.ContainsText("ZeccoShare Discussions"));
        }

        public void GotoForums()
        {
            UserSignIn(UN, PW, false, 2);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl04_uxSubNavRepeater_ctl01_uxSubNavLink")).Click();
            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_SideNavigation1_uxSideNavigation")).Link(Find.ByText("Discussions")).Click();
            browser.WaitForComplete(30);
            //NavigateToDiscussion(browser);
            //browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMoreForumsLink")).Click();
            //browser.WaitForComplete(10);
        }

        public void GotoBlogs()
        {
            UserSignIn(UN, PW, false, 2);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl04_uxSubNavRepeater_ctl01_uxSubNavLink")).Click();
            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_SideNavigation1_uxSideNavigation")).Link(Find.ByText("Blogs")).Click();
            browser.WaitForComplete(30);
            //NavigateToDiscussion(browser);
            //browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMoreBlogsLink")).Click();
            //browser.WaitForComplete(10);
        }
    }
}
