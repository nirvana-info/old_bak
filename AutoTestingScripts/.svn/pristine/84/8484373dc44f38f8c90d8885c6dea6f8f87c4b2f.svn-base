using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Appobjects.App01_HomePage
{
    public class ActivityFeed : SignIn
    {
        public void NavigateToAcitivtyFeed(Browser browser)
        {
            UserSignIn(UN, PW, false, 0);
            System.Threading.Thread.Sleep(5000);
        }

        public void FollowAnotherUser()
        {
            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_SideNavigation1_uxSideNavigation")).Link(Find.ByText("Members")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxScreenName")).TypeText("jaylen1");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSimpleSearch")).Click();
            browser.Image(Find.ById("uxMemberProfilePicture")).Click();
            if (browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberProfileBox_uxAddFavorite")).Exists)
            {
                browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberProfileBox_uxAddFavorite")).Click();
            }
            //if (browser.Span(Find.ByClass("loginstatus")).Link(Find.ByText("Sign Out")).Exists == true)
            //{
            //    SignOut so = new SignOut();
            //    so.UserSignOut(browser);
            //}
        }

        public void ShoutAnotherUser()
        {
            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_SideNavigation1_uxSideNavigation")).Link(Find.ByText("Members")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxScreenName")).TypeText("jaylen1");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSimpleSearch")).Click();
            browser.Image(Find.ById("uxMemberProfilePicture")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxShoutText")).TypeText("aaa");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxSubmitShout")).Click();
            //if (browser.Span(Find.ByClass("loginstatus")).Link(Find.ByText("Sign Out")).Exists == true)
            //{
            //    SignOut so = new SignOut();
            //    so.UserSignOut(browser);
            //}
        }

        public void WritePostComment()
        {
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl04_uxSubNavRepeater_ctl01_uxSubNavLink")).Click();
            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_SideNavigation1_uxSideNavigation")).Link(Find.ByText("Blogs")).Click();
            System.Threading.Thread.Sleep(10000);
            browser.Link(Find.ByText("activityZZJ")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostReplyText")).TypeText("aaa");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostReply")).Click();
            //if (browser.Span(Find.ByClass("loginstatus")).Link(Find.ByText("Sign Out")).Exists == true)
            //{
            //    SignOut so = new SignOut();
            //    so.UserSignOut(browser);
            //}
        }

        public void WaitAndLoginAnother()
        {
            //DateTime dt = DateTime.Now.AddMinutes(15);
            //while (dt.CompareTo(DateTime.Now) > 0)
            //{
            //    //wait 15 minutes
            //}
            //System.Threading.Thread.Sleep(900000);
            if (browser.Link(Find.ByText("Sign In")).Exists == true)
            {
            }
            UserSignIn(UN2, PW2, false, 2);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl04_uxSubNavRepeater_ctl01_uxSubNavLink")).Click();
        }

        public void FollowSomeone()
        {
            browser.TextField(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_ctl00_uxSearchedSymbol")).TypeText(UN2);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_ctl00_uxSearchButton")).Click();
            if (browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberProfileBox_uxAddFavorite")).Exists)
            {
                browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberProfileBox_uxAddFavorite")).Click();
            }
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberProfileBox_uxAddFavorite")).Click();
            if (browser.Div(Find.ById("MainColumn")).Div(Find.ByClass("float-left gutter")).Exists == false)
            {
                browser.Span(Find.ByText("COMMUNITY")).Click();
                browser.Link(Find.ByText("Profile")).Click();
            }
        }
    }
}
