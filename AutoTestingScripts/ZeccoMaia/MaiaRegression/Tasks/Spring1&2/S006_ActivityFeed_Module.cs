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
    public class S006_ActivityFeed_Module:ActivityFeed
    {
        [Test]
        public void T01_ActivityFeed_Display()
        {
            NavigateToAcitivtyFeed(browser);
            browser.Div(Find.ById("uxActivityFeedPanel")).WaitUntilExists(20);
            string tx1 = browser.Div(Find.ById("Sidebar")).Div(Find.ById("uxActivityFeedPanel")).Div(Find.ByClass("webpart")).Text;
            string tx2 = tx1.Trim().Substring(8, 18);
            Assert.AreEqual("Your Activity Feed", tx2);
        }

        [Test]
        public void T02_ActivityFeed_ViewAll()
        {
            NavigateToAcitivtyFeed(browser);
            browser.WaitForComplete();
            browser.Div(Find.ById("uxActivityFeedPanel")).Link(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxActivityFeedViewAll")).Click();
            browser.Span("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberDisplayName").WaitUntilExists(20);
            Assert.IsTrue(browser.Span("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberDisplayName").Text.Contains(UN + "´s Activity Feed"));
        }

        [Test]
        public void T03_ActivityFeed_FollowingNotific()
        {
            NavigateToAcitivtyFeed(browser);
            browser.Link(Find.ById("uxEditProfile")).Click();
            browser.GoTo(URL + "/editmemberprofile.aspx?view=ActivityFeed#");
            browser.Span(Find.ByText("Activity Feed")).Click();
            browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSocialActivities")).WaitUntilExists(10);
            if (browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSocialActivities")).Checked == false)
            {
                browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSocialActivities")).Checked = true;
            }
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSaveActivityFeed")).Click();
            this.FollowAnotherUser();
            System.Threading.Thread.Sleep(900000);
            //this.WaitAndLoginAnother();
            browser.Link(Find.ByText("Community Profile")).Click();
            Assert.IsTrue(browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxMemberActivityFeedList_Table")).Div(Find.ByClass("ActivityText")).Text.Contains("friends"));
        }

        [Test]
        public void T04_ActivityFeed_ShoutNotificActive()
        {
            NavigateToAcitivtyFeed(browser);
            browser.Link(Find.ById("uxEditProfile")).Click();
            browser.GoTo(URL + "/editmemberprofile.aspx?view=ActivityFeed#");
            browser.Span(Find.ByText("Activity Feed")).Click();
            browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxShoutboxPosts")).WaitUntilExists(10);
            if (browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxShoutboxPosts")).Checked == false)
            {
                browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxShoutboxPosts")).Checked = true;
            }
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSaveActivityFeed")).Click();
            this.ShoutAnotherUser();
            System.Threading.Thread.Sleep(900000);
            //this.WaitAndLoginAnother();
            browser.Link(Find.ByText("Community Profile")).Click();
            Assert.IsTrue(browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxMemberActivityFeedList_Table")).Div(Find.ByClass("ActivityText")).Text.Contains("shout"));
        }

        [Test]
        public void T05_ActivityFeed_PostNotificActive()
        {
            NavigateToAcitivtyFeed(browser);
            browser.Link(Find.ById("uxEditProfile")).Click();
            browser.GoTo(URL + "/editmemberprofile.aspx?view=ActivityFeed#");
            browser.Span(Find.ByText("Activity Feed")).Click();
            browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxPostsInForums")).WaitUntilExists(10);
            if (browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxPostsInForums")).Checked == false)
            {
                browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxPostsInForums")).Checked = true;
            }
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSaveActivityFeed")).Click();
            this.WritePostComment();
            System.Threading.Thread.Sleep(900000);
            //this.WaitAndLoginAnother();
            browser.Link(Find.ByText("Community Profile")).Click();
            Assert.IsTrue(browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxMemberActivityFeedList_Table")).Div(Find.ByClass("ActivityText")).Text.Contains("post"));
        }

        [Test]
        public void T06_ActivityFeed_FollowingNotificElse()
        {
            //this.FollowSomeone();
            //this.FollowAnotherUser();
            NavigateToAcitivtyFeed(browser);
            this.WaitAndLoginAnother();
            browser.Link(Find.ById("uxEditProfile")).Click();
            browser.GoTo(URL + "/editmemberprofile.aspx?view=ActivityFeed#");
            browser.Span(Find.ByText("Activity Feed")).Click();
            browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSocialActivities")).WaitUntilExists(10);
            if (browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSocialActivities")).Checked == false)
            {
                browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSocialActivities")).Checked = true;
            }
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSaveActivityFeed")).Click();
            //System.Threading.Thread.Sleep(900000);
            browser.Link(Find.ByText("Community Profile")).Click();
            Assert.IsTrue(browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxMemberActivityFeedList_Table")).Div(Find.ByClass("ActivityText")).Text.Contains("friends"));
        }

        [Test]
        public void T07_ActivityFeed_ShoutNotificActiveElse()
        {
            //this.FollowSomeone();
            //this.ShoutAnotherUser();
            NavigateToAcitivtyFeed(browser);
            this.WaitAndLoginAnother();
            browser.Link(Find.ById("uxEditProfile")).Click();
            browser.GoTo(URL + "/editmemberprofile.aspx?view=ActivityFeed#");
            browser.Span(Find.ByText("Activity Feed")).Click();
            browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxShoutboxPosts")).WaitUntilExists(10);
            if (browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxShoutboxPosts")).Checked == false)
            {
                browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxShoutboxPosts")).Checked = true;
            }
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSaveActivityFeed")).Click();
            //System.Threading.Thread.Sleep(900000);
            browser.Link(Find.ByText("Community Profile")).Click();
            Assert.IsTrue(browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxMemberActivityFeedList_Table")).Div(Find.ByClass("ActivityText")).Text.Contains("shout"));
        }

        [Test]
        public void T08_ActivityFeed_PostNotificActiveElse()
        {
            //this.FollowSomeone();
            //this.WritePostComment();
            NavigateToAcitivtyFeed(browser);
            this.WaitAndLoginAnother();
            browser.Link(Find.ById("uxEditProfile")).Click();
            browser.GoTo(URL + "/editmemberprofile.aspx?view=ActivityFeed#");
            browser.Span(Find.ByText("Activity Feed")).Click();
            browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxPostsInForums")).WaitUntilExists(10);
            if (browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxPostsInForums")).Checked == false)
            {
                browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxPostsInForums")).Checked = true;
            }
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSaveActivityFeed")).Click();
            //System.Threading.Thread.Sleep(900000);
            browser.Link(Find.ByText("Community Profile")).Click();
            Assert.IsTrue(browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxMemberActivityFeedList_Table")).Div(Find.ByClass("ActivityText")).Text.Contains("post"));
        }

        [Test]
        public void T09_ActivityFeed_Hide()
        {
            NavigateToAcitivtyFeed(browser);
            if (browser.Image(Find.ById("uxHideActivityImage")).Exists == true)
            {
                browser.Image(Find.ById("uxHideActivityImage")).Click();
                if (browser.Link(Find.ById("A2")).Exists == true)
                {
                    browser.Link(Find.ById("A2")).Click();
                }
                else
                {
                    Assert.IsTrue(false);
                }
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        //[Test]
        //public void T10_ActivityFeed_DeactivateFeed()
        //{
        //    NavigateToAcitivtyFeed(browser);
        //    browser.Link(Find.ById("uxEditProfile")).Click();
        //    browser.GoTo(URL + "/editmemberprofile.aspx?view=ActivityFeed#");
        //    browser.Span(Find.ByText("Activity Feed")).Click();
        //    browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxDisableActivityFeed")).WaitUntilExists(10);
        //    //if (browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxDisableActivityFeed")).Checked == false)
        //    //{
        //    //    browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxDisableActivityFeed")).Checked = true;
        //    //}
        //    browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSocialActivities")).Checked = false;
        //    browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxShoutboxPosts")).Checked = false;
        //    browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxPostsInForums")).Checked = false;
        //    browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSocialActivities")).Checked = false;
        //    browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxShoutboxPosts")).Checked = false;
        //    browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxPostsInForums")).Checked = false;
        //    browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSaveActivityFeed")).Click();
        //    browser.Span(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxMemberLoginStatus_uxMemberLoginView_uxLoginName")).Click();
        //    Assert.IsTrue(browser.Div(Find.ById("uxDisabledActivityFeedMessage")).Text.Contains("You have disabled your activity feed."));
        //    browser.Div(Find.ById("uxDisabledActivityFeedMessage")).Link(Find.ByText("Activate")).Click();
        //    //browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxDisableActivityFeed")).Checked = false;
        //    //browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSaveActivityFeed")).Click();
        //}
    }
}
