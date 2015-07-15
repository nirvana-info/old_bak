using System.Text;
using WatiN.Core;
using NUnit.Framework;
using MaiaRegression.Appobjects;
using MaiaRegression.Appobjects.App01_HomePage;
using System;

namespace MaiaRegression.Tasks.Spring6
{
    [TestFixture]
    public class S004_Cache_Module : SignIn
    {
        [Test]
        public void T01_Cache_DiscussionNewThread()
        {
            GotoDiscussions();
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxSubmitNewForum")).Click();
            browser.WaitForComplete();

            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxThreadTitle")).TypeText("zzjdiscussion" + Date);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBody")).TypeText("zzjdiscussion");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPost")).Click();
            System.Threading.Thread.Sleep(5000);
            browser.Link(Find.ByText("Discussions")).Click();
            browser.WaitForComplete(10);
            Assert.IsTrue(browser.Link(Find.ByText("zzjdiscussion" + Date)).Exists);
        }

        [Test]
        public void T02_Cache_DiscussionReplyThread()
        {
            GotoDiscussions();
            browser.Link(Find.ByText("zzjdiscussion" + Date)).Click();
            browser.WaitForComplete();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostReplyText")).TypeText("aatest");
            browser.Button(Find.ById("ux_Submit")).Click();
            System.Threading.Thread.Sleep(10000);
            //browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostReplyText")).TypeText("bbtest");
            //browser.Button(Find.ById("ux_Submit")).Click();
            //Thread.Sleep(10000);
            browser.Link(Find.ByText("Discussions")).Click();
            browser.WaitForComplete(10);
            browser.Link(Find.ByText("zzjdiscussion" + Date)).Click();
            browser.WaitForComplete(10);
            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxThreadRepliesUpdatePanel"));
            Assert.IsTrue(browser.ContainsText("aatest"));
        }

        [Test]
        public void T03_Cache_DiscussionEditReply()
        {
            GotoDiscussions();
            browser.Link(Find.ByText("zzjdiscussion" + Date)).Click();
            browser.WaitForComplete();
            if (browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxThreadRepliesListView_ctrl0_uxEditButton")).Exists == true)
            {
                browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxThreadRepliesListView_ctrl0_uxEditButton")).Click();
                System.Threading.Thread.Sleep(2000);
                if (browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxThreadRepliesListView_ctrl0_uxUpdateButton")).Exists == true)
                {
                    browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxThreadRepliesListView_ctrl0_uxForumPostText")).TypeText("bbtest");
                    browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxThreadRepliesListView_ctrl0_uxUpdateButton")).Click();
                    System.Threading.Thread.Sleep(8000);
                    Assert.IsTrue(browser.ContainsText("bbtest"));
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

        [Test]
        public void T04_Cache_DiscussionDeleteReply()
        {
            GotoDiscussions();
            browser.Link(Find.ByText("zzjdiscussion" + Date)).Click();
            browser.WaitForComplete();
            if (browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxThreadRepliesListView_ctrl0_uxDeleteButton")).Exists == true)
            {
                browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxThreadRepliesListView_ctrl0_uxDeleteButton")).Click();
                browser.Button(Find.ById("ProceedButton")).Click();
                System.Threading.Thread.Sleep(5000);
                Assert.IsFalse(browser.ContainsText("aatest") || browser.ContainsText("bbtest"));
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T05_Cache_GroupNewThread()
        {
            GotoGroups();
            browser.Link(Find.ByText("Zecco Associates")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNewThread")).WaitUntilExists(10);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNewThread")).TypeText("zzjgroup" + Date);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNext")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMessageText")).WaitUntilExists(10);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMessageText")).TypeText("zzjgroup");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostGroupDiscussion")).Click();
            System.Threading.Thread.Sleep(5000);
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxBreadcrumbTrail_uxThirdLevelLink")).Click();
            System.Threading.Thread.Sleep(5000);
            Assert.IsTrue(browser.ContainsText("zzjgroup" + Date));
        }

        [Test]
        public void T06_Cache_GroupReplyThread()
        {
            GotoGroups();
            browser.Link(Find.ByText("Zecco Associates")).Click();
            browser.Link(Find.ByText("zzjgroup" + Date)).WaitUntilExists(20);
            browser.Link(Find.ByText("zzjgroup" + Date)).Click();
            browser.WaitForComplete();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostReplyText")).TypeText("cctest");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostReply")).Click();
            System.Threading.Thread.Sleep(5000);
            //browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostReplyText")).TypeText("ddtest");
            //browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostReply")).Click();
            //Thread.Sleep(5000);
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxBreadcrumbTrail_uxThirdLevelLink")).Click();
            browser.WaitForComplete(10);
            browser.Link(Find.ByText("zzjgroup" + Date)).Click();
            browser.WaitForComplete(10);
            Assert.IsTrue(browser.ContainsText("cctest"));
        }

        [Test]
        public void T07_Cache_GroupEditReply()
        {
            GotoGroups();
            browser.Link(Find.ByText("Zecco Associates")).Click();
            browser.Link(Find.ByText("zzjgroup" + Date)).WaitUntilExists(20);
            browser.Link(Find.ByText("zzjgroup" + Date)).Click();
            browser.WaitForComplete();
            if (browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxThreadRepliesListView_ctrl0_uxEditButton")).Exists == true)
            {
                browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxThreadRepliesListView_ctrl0_uxEditButton")).Click();
                System.Threading.Thread.Sleep(2000);
                if (browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxThreadRepliesListView_ctrl0_uxUpdateButton")).Exists == true)
                {
                    browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxThreadRepliesListView_ctrl0_uxForumPostText")).TypeText("ddtest");
                    browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxThreadRepliesListView_ctrl0_uxUpdateButton")).Click();
                    System.Threading.Thread.Sleep(5000);
                    Assert.IsTrue(browser.ContainsText("ddtest"));
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

        [Test]
        public void T08_Cache_GroupDeleteReply()
        {
            GotoGroups();
            browser.Link(Find.ByText("Zecco Associates")).Click();
            browser.Link(Find.ByText("zzjgroup" + Date)).WaitUntilExists(20);
            browser.Link(Find.ByText("zzjgroup" + Date)).Click();
            browser.WaitForComplete();
            if (browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxThreadRepliesListView_ctrl0_uxDeleteButton")).Exists == true)
            {
                browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxThreadRepliesListView_ctrl0_uxDeleteButton")).Click();
                browser.Button(Find.ById("ProceedButton")).Click();
                System.Threading.Thread.Sleep(5000);
                Assert.IsTrue(!browser.ContainsText("cctest"));
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T09_Cache_BlogNewPost()
        {
            GotoBlogs();
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxGoToZeccoBlog")).Click();
            browser.WaitForComplete(10);
            if (browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBlogPostTitle")).Exists == false)
            {
                browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxManageHeader")).Link(Find.ByText("Create new blog post")).Click();
                browser.WaitForComplete();
            }

            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBlogPostTitle")).TypeText("zzjblog" + Date);
            browser.Span(Find.ByClass("LinkManager")).Click();
            System.Threading.Thread.Sleep(5000);
            browser.Frame(Find.ByName("ctl00_ctl00_uxMainContent_uxMiddleColumn_dialogOpenerLinkManager")).
                TextField(Find.ById("LinkText")).WaitUntilExists(20);
            browser.Frame(Find.ByName("ctl00_ctl00_uxMainContent_uxMiddleColumn_dialogOpenerLinkManager")).
                TextField(Find.ById("LinkText")).TypeText("post blog test");
            browser.Frame(Find.ByName("ctl00_ctl00_uxMainContent_uxMiddleColumn_dialogOpenerLinkManager")).
                Span(Find.ByClass("radfdInnerSpan")).Click();
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPost")).Click();
            System.Threading.Thread.Sleep(5000);
            browser.Link(Find.ByText("Blogs")).Click();
            browser.WaitForComplete(10);
            Assert.IsTrue(browser.Link(Find.ByText("zzjblog" + Date)).Exists);
        }

        [Test]
        public void T10_Cache_BlogReplyPost()
        {
            GotoBlogs();
            browser.Link(Find.ByText("zzjblog" + Date)).Click();
            browser.WaitForComplete();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostReplyText")).TypeText("eetest");
            browser.Button(Find.ById("ux_Submit")).Click();
            System.Threading.Thread.Sleep(10000);
            //browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostReplyText")).TypeText("fftest");
            //browser.Button(Find.ById("ux_Submit")).Click();
            //Thread.Sleep(10000);
            browser.Link(Find.ByText("Blogs")).Click();
            browser.WaitForComplete(10);
            browser.Link(Find.ByText("zzjblog" + Date)).Click();
            browser.WaitForComplete(10);
            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostCommentsUpdatePanel"));
            Assert.IsTrue(browser.ContainsText("eetest"));
        }

        [Test]
        public void T11_Cache_BlogEditReply()
        {
            GotoBlogs();
            browser.Link(Find.ByText("zzjblog" + Date)).Click();
            browser.WaitForComplete();
            if (browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostCommentsListView_ctrl0_uxEditButton")).Exists == true)
            {
                browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostCommentsListView_ctrl0_uxEditButton")).Click();
                System.Threading.Thread.Sleep(2000);
                if (browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostCommentsListView_ctrl0_uxUpdateButton")).Exists == true)
                {
                    browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostCommentsListView_ctrl0_uxBlogPostText")).TypeText("fftest");
                    browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostCommentsListView_ctrl0_uxUpdateButton")).Click();
                    System.Threading.Thread.Sleep(8000);
                    Assert.IsTrue(browser.ContainsText("fftest"));
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

        [Test]
        public void T12_Cache_BlogDeleteReply()
        {
            GotoBlogs();
            browser.Link(Find.ByText("zzjblog" + Date)).Click();
            browser.WaitForComplete();
            if (browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostCommentsListView_ctrl0_uxDeleteButton")).Exists == true)
            {
                browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostCommentsListView_ctrl0_uxDeleteButton")).Click();
                browser.Button(Find.ById("ProceedButton")).Click();
                System.Threading.Thread.Sleep(5000);
                Assert.IsFalse(browser.ContainsText("eetest") || browser.ContainsText("fftest"));
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T13_Cache_DashboardThread()
        {
            GotoDashboard();
            browser.Link(Find.ByText("zzjdiscussion" + Date)).WaitUntilExists(30);
            browser.Link(Find.ByText("zzjdiscussion" + Date)).Click();
            Assert.IsTrue(browser.Button(Find.ById("ux_Submit")).Exists);
        }

        [Test]
        public void T14_Cache_DashboardReply()
        {
            GotoDashboard();
            browser.Link(Find.ByText("zzjdiscussion" + Date)).WaitUntilExists(30);
            browser.Link(Find.ByText("zzjdiscussion" + Date)).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostReplyText")).TypeText("test");
            browser.Button(Find.ById("ux_Submit")).Click();
            browser.WaitForComplete(120);
            System.Threading.Thread.Sleep(5000);
            Assert.IsTrue(browser.ContainsText("test"));
        }

        private void GotoDiscussions()
        {
            UserSignIn(UN, PW, false, 0);
            browser.Link(Find.ByText("Community Profile")).Click();
            browser.Link(Find.ByText("Discussions")).Click();
            browser.WaitForComplete(30);
        }

        private void GotoBlogs()
        {
            UserSignIn(UN, PW, false, 0);
            browser.Link(Find.ByText("Community Profile")).Click();
            browser.Link(Find.ByText("Blogs")).Click();
            browser.WaitForComplete(30);
        }

        private void GotoDashboard()
        {
            UserSignIn(UN, PW, false, 0);
            
                browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl04_uxTopNavLink")).Click();
                //browser.Link(Find.ByText("Dashboard")).Click();
            
            browser.WaitForComplete(30);
        }

        private void GotoGroups()
        {
            UserSignIn(UN, PW, false, 0);
            browser.Link(Find.ByText("Community Profile")).Click();
            browser.Link(Find.ByText("Groups")).Click();
            //browser.Span(Find.ByText("COMMUNITY")).Click();
            //browser.Link(Find.ByText("Groups")).Click();
            browser.WaitForComplete(30);
        }
    }
}
