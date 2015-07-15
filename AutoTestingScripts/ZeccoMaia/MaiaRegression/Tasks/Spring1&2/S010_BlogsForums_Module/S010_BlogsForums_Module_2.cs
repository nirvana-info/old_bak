using System.Text;
using WatiN.Core;
using NUnit.Framework;
using MaiaRegression.Appobjects;
using MaiaRegression.Appobjects.App01_HomePage;
using System;

namespace MaiaRegression.Tasks.Spring1_2.S010_BlogsForums_Module
{
    [TestFixture]
    public class S010_BlogsForums_Module_2 : BlogsForums
    {
        [Test]
        public void T20_BlogsForums_BlosMostActive()
        {
            GotoBlogs();
            if (browser.Element(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxRelevancyList_uxMostActive")).Exists == true)
            {
                Assert.IsTrue(true);
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T21_BlogsForums_BlogTopRated()
        {
            GotoBlogs();
            if (browser.Element(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxRelevancyList_uxTopRated")).Exists == true)
            {
                Assert.IsTrue(true);
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T22_BlogsForums_BlogMyContributions()
        {
            GotoBlogs();
            if (browser.Element(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxRelevancyList_uxMyContributions")).Exists == true)
            {
                Assert.IsTrue(true);
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T23_BlogsForums_BlogSubscribe()
        {
            GotoBlogs();
            if (browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxRssFeed_uxRssLinkButton")).Exists == true)
            {
                browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxRssFeed_uxRssLinkButton")).Click();
                browser.Back();
            }
        }

        [Test]
        public void T24_BlogsForums_BlogCategories()
        {
            GotoBlogs();
            if (browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxCategoriesRep")).Exists == true)
            {
                Assert.IsTrue(true);
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T25_BlogsForums_BlogTags()
        {
            GotoBlogs();
            if (browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxTagCloudRep")).Exists == true)
            {
                Assert.IsTrue(true);
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T26_BlogsForums_BlogUp()
        {
            GotoBlogs();
            if (browser.Link(Find.ById("uxThumbsUp")).Exists == true)
            {
                browser.Link(Find.ById("uxThumbsUp")).Click();
                Assert.IsTrue(true);
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T27_BlogsForums_BlogDown()
        {
            GotoBlogs();
            if (browser.Link(Find.ById("uxThumbsDown")).Exists == true)
            {
                browser.Link(Find.ById("uxThumbsDown")).Click();
                Assert.IsTrue(true);
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T28_BlogsForums_BlogRating()
        {
            GotoBlogs();
            if (browser.Span(Find.ById("uxRatingSum1")).Exists == true)
            {
                string rating = browser.Span(Find.ById("uxRatingSum1")).Text.Trim();
                int r = 0;
                Assert.IsTrue(Int32.TryParse(rating, out r));
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T29_BlogsForums_BlogCount()
        {
            GotoBlogs();
            if (browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxRepeatBlogAndForum")).Exists == true)
            {
                int count = browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxRepeatBlogAndForum")).Table(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxRepeatBlogAndForum_Table")).TableRows.Count;
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T30_BlogsForums_ForumLink()
        {
            GotoBlogs();
            if (browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxSideNavigation_uxSideNavigation")).Link(Find.ByText("Discussions")).Exists == true)
            {
                Assert.IsTrue(true);
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T31_BlogsForums_BlogNew()
        {
            GotoBlogs();
            browser.GoTo(targetHost + "/editmemberprofile.aspx?view=PersonalBlog");
            browser.WaitForComplete(10);
            if ((browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxBlogTitle")).Exists == true) &&
                (browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxBlogURL")).Exists == true))
            {
                browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxBlogTitle")).TypeText("zzj");
                browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxBlogURL")).TypeText("zzj");
                browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxNext")).Click();
                browser.WaitForComplete(10);
                browser.Link(Find.ByText("Community Profile")).Click();
                browser.GoTo(targetHost + "/editmemberprofile.aspx?view=PersonalBlog");
                browser.WaitForComplete(10);
            }
            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxManageHeader")).Link(Find.ByText("Create new blog post")).Click();
            browser.WaitForComplete(10);
            Assert.IsTrue(browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPost")).Exists);
        }

        [Test]
        public void T32_BlogsForums_BlogNewTitle()
        {
            GotoBlogs();
            browser.GoTo(targetHost + "/editmemberprofile.aspx?view=PersonalBlog");
            browser.WaitForComplete(10);
            if ((browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxBlogTitle")).Exists == true) &&
                (browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxBlogURL")).Exists == true))
            {
                browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxBlogTitle")).TypeText("zzj");
                browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxBlogURL")).TypeText("zzj");
                browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxNext")).Click();
                browser.WaitForComplete(10);
                browser.Link(Find.ByText("Community Profile")).Click();
                browser.GoTo(targetHost + "/editmemberprofile.aspx?view=PersonalBlog");
                browser.WaitForComplete(10);
            }
            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxManageHeader")).Link(Find.ByText("Create new blog post")).Click();
            browser.WaitForComplete(10);
            Assert.IsTrue(browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBlogPostTitle")).Exists);
        }

        [Test]
        public void T33_BlogsForums_BlogNewMessage()
        {
            GotoBlogs();
            browser.GoTo(targetHost + "/editmemberprofile.aspx?view=PersonalBlog");
            browser.WaitForComplete(10);
            if ((browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxBlogTitle")).Exists == true) &&
                (browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxBlogURL")).Exists == true))
            {
                browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxBlogTitle")).TypeText("zzj");
                browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxBlogURL")).TypeText("zzj");
                browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxNext")).Click();
                browser.WaitForComplete(10);
                browser.Link(Find.ByText("Community Profile")).Click();
                browser.GoTo(targetHost + "/editmemberprofile.aspx?view=PersonalBlog");
                browser.WaitForComplete(10);
            }
            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxManageHeader")).Link(Find.ByText("Create new blog post")).Click();
            browser.WaitForComplete(10);
            Assert.IsTrue(browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostBodyWrapper")).Exists);
        }

        [Test]
        public void T34_BlogsForums_BlogNewCategories()
        {
            GotoBlogs();
            browser.GoTo(targetHost + "/editmemberprofile.aspx?view=PersonalBlog");
            browser.WaitForComplete(10);
            if ((browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxBlogTitle")).Exists == true) &&
                (browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxBlogURL")).Exists == true))
            {
                browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxBlogTitle")).TypeText("zzj");
                browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxBlogURL")).TypeText("zzj");
                browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxNext")).Click();
                browser.WaitForComplete(10);
                browser.Link(Find.ByText("Community Profile")).Click();
                browser.GoTo(targetHost + "/editmemberprofile.aspx?view=PersonalBlog");
                browser.WaitForComplete(10);
            }
            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxManageHeader")).Link(Find.ByText("Create new blog post")).Click();
            browser.WaitForComplete(10);
            Assert.IsTrue(browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxCategoriesAndTags_uxCategories_0")).Exists);
        }

        [Test]
        public void T36_BlogsForums_BlogNewTag()
        {
            GotoBlogs();
            browser.GoTo(targetHost + "/editmemberprofile.aspx?view=PersonalBlog");
            browser.WaitForComplete(10);
            if ((browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxBlogTitle")).Exists == true) &&
                (browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxBlogURL")).Exists == true))
            {
                browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxBlogTitle")).TypeText("zzj");
                browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxBlogURL")).TypeText("zzj");
                browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxNext")).Click();
                browser.WaitForComplete(10);
                browser.Link(Find.ByText("Community Profile")).Click();
                browser.GoTo(targetHost + "/editmemberprofile.aspx?view=PersonalBlog");
                browser.WaitForComplete(10);
            }
            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxManageHeader")).Link(Find.ByText("Create new blog post")).Click();
            browser.WaitForComplete(10);
            Assert.IsTrue(browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxCategoriesAndTags_uxTags")).Exists);
        }

        [Test]
        public void T37_BlogsForums_BlogNewPost()
        {
            GotoBlogs();
            browser.GoTo(targetHost + "/editmemberprofile.aspx?view=PersonalBlog");
            browser.WaitForComplete(10);
            if ((browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxBlogTitle")).Exists == true) &&
                (browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxBlogURL")).Exists == true))
            {
                browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxBlogTitle")).TypeText("zzj");
                browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxBlogURL")).TypeText("zzj");
                browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxNext")).Click();
                browser.WaitForComplete(10);
                browser.Link(Find.ByText("Community Profile")).Click();
                browser.GoTo(targetHost + "/editmemberprofile.aspx?view=PersonalBlog");
                browser.WaitForComplete(10);
            }
            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxManageHeader")).Link(Find.ByText("Create new blog post")).Click();
            browser.WaitForComplete(10);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBlogPostTitle")).TypeText("post blog test" + Date);
            browser.Span(Find.ByClass("LinkManager")).Click();
            System.Threading.Thread.Sleep(5000);
            browser.Frame(Find.ByName("ctl00_ctl00_uxMainContent_uxMiddleColumn_ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostBodydialogOpenerLinkManager")).
                TextField(Find.ById("LinkText")).WaitUntilExists(20);
            browser.Frame(Find.ByName("ctl00_ctl00_uxMainContent_uxMiddleColumn_ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostBodydialogOpenerLinkManager")).
                TextField(Find.ById("LinkText")).TypeText("post blog test");
            browser.Frame(Find.ByName("ctl00_ctl00_uxMainContent_uxMiddleColumn_ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostBodydialogOpenerLinkManager")).
                Span(Find.ByClass("radfdInnerSpan")).Click();
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPost")).Click();
            Assert.IsTrue(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBlogPostTitle")).Text.Contains("post blog test" + Date));
        }

        [Test]
        public void T38_BlogsForums_BlogNewSpecChar()
        {
            string specialCHAR = "~!@#$%^&*()_-+={[}]|\\:;\"'<,>.?/";
            GotoBlogs();
            browser.GoTo(targetHost + "/editmemberprofile.aspx?view=PersonalBlog");
            browser.WaitForComplete(10);
            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxManageHeader")).Link(Find.ByText("Create new blog post")).Click();
            browser.WaitForComplete(10);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBlogPostTitle")).TypeText("blog test" + Date + specialCHAR);
            browser.Span(Find.ByClass("LinkManager")).Click();
            System.Threading.Thread.Sleep(5000);
            browser.Frame(Find.ByName("ctl00_ctl00_uxMainContent_uxMiddleColumn_ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostBodydialogOpenerLinkManager")).
                TextField(Find.ById("LinkText")).WaitUntilExists(20);
            browser.Frame(Find.ByName("ctl00_ctl00_uxMainContent_uxMiddleColumn_ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostBodydialogOpenerLinkManager")).
                TextField(Find.ById("LinkText")).TypeText("blog test" + specialCHAR);
            browser.Frame(Find.ByName("ctl00_ctl00_uxMainContent_uxMiddleColumn_ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostBodydialogOpenerLinkManager")).
                Span(Find.ByClass("radfdInnerSpan")).Click();
            System.Threading.Thread.Sleep(5000);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxCategoriesAndTags_uxTags")).TypeText(specialCHAR);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPost")).Click();

            while (browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxTagCloudRep")).Link(Find.ByText(specialCHAR)).Exists == false)
            {
                browser.Refresh();
                System.Threading.Thread.Sleep(30000);
            }
            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxTagCloudRep")).Link(Find.ByText(specialCHAR)).Click();
            System.Threading.Thread.Sleep(5000);
            Assert.IsTrue(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBlogPostTitle")).Text.Contains("blog test" + Date + specialCHAR));
            Assert.IsTrue(browser.Text.Contains(specialCHAR));
        }

        [Test]
        public void T39_BlogsForums_BlogSetting()
        {
            string specialCHAR = "~!@#$%^&*()_-+={[}]|\\:;\"'<,>.?/";
            GotoBlogs();
            browser.GoTo(targetHost + "/editmemberprofile.aspx?view=PersonalBlog");
            browser.WaitForComplete(10);
            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxManageHeader")).Link(Find.ByText("Edit blog settings")).Click();
            browser.Span(Find.ByClass("LinkManager")).Click();
            browser.Frame(Find.ByName("ctl00_ctl00_uxMainContent_uxMainColumn_uxEditBlogSet_ctl00_ctl00_uxMainContent_uxMainColumn_uxEditBlogSet_uxBlogDescriptiondialogOpenerLinkManager")).
                TextField(Find.ById("LinkText")).WaitUntilExists(20);
            browser.Frame(Find.ByName("ctl00_ctl00_uxMainContent_uxMainColumn_uxEditBlogSet_ctl00_ctl00_uxMainContent_uxMainColumn_uxEditBlogSet_uxBlogDescriptiondialogOpenerLinkManager")).
                TextField(Find.ById("LinkText")).TypeText(specialCHAR);
            browser.Frame(Find.ByName("ctl00_ctl00_uxMainContent_uxMainColumn_uxEditBlogSet_ctl00_ctl00_uxMainContent_uxMainColumn_uxEditBlogSet_uxBlogDescriptiondialogOpenerLinkManager")).
                Span(Find.ByClass("radfdInnerSpan")).Click();
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxEditBlogSet_uxSave")).Click();
        }
    }
}
