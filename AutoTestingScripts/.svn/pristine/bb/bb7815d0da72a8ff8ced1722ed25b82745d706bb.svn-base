using System.Text;
using WatiN.Core;
using NUnit.Framework;
using MaiaRegression.Appobjects;
using MaiaRegression.Appobjects.App01_HomePage;
using System;

namespace MaiaRegression.Tasks.Spring1_2.S010_BlogsForums_Module
{
    [TestFixture]
    public class S010_BlogsForums_Module_1 : BlogsForums
    {
        [Test]
        public void T01_BlogsForums_ViewDiscussionPage()
        {
            NavigateToDiscussion(browser);
        }

        [Test]
        public void T02_BlogsForums_ForumMostActive()
        {
            GotoForums();
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
        public void T03_BlogsForums_ForumTopRated()
        {
            GotoForums();
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
        public void T04_BlogsForums_ForumMyContributions()
        {
            GotoForums();
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
        public void T05_BlogsForums_ForumSubscribe()
        {
            GotoForums();
            if (browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxRssFeed_uxRssLinkButton")).Exists == true)
            {
                browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxRssFeed_uxRssLinkButton")).Click();
                browser.Back();
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T06_BlogsForums_ForumCategories()
        {
            GotoForums();
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
        public void T07_BlogsForums_ForumTags()
        {
            GotoForums();
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
        public void T08_BlogsForums_ForumUp()
        {
            GotoForums();
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
        public void T09_BlogsForums_ForumDown()
        {
            GotoForums();
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
        public void T10_BlogsForums_ForumRating()
        {
            GotoForums();
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
        public void T11_BlogsForums_ForumCount()
        {
            GotoForums();
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
        public void T12_BlogsForums_BlogLink()
        {
            GotoForums();
            if (browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxSideNavigation_uxSideNavigation")).Link(Find.ByText("Blogs")).Exists == true)
            {
                Assert.IsTrue(true);
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T13_BlogsForums_ForumNew()
        {
            GotoForums();
            if (browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxSubmitNewForum")).Exists == true)
            {
                Assert.IsTrue(true);
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T14_BlogsForums_ForumNewTitle()
        {
            GotoForums();
            if (browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxSubmitNewForum")).Exists == true)
            {
                browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxSubmitNewForum")).Click();
                browser.WaitForComplete(10);
                Assert.IsTrue(browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxThreadTitle")).Exists);
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T15_BlogsForums_ForumNewMessage()
        {
            GotoForums();
            if (browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxSubmitNewForum")).Exists == true)
            {
                browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxSubmitNewForum")).Click();
                browser.WaitForComplete(10);
                Assert.IsTrue(browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBody")).Exists);
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T16_BlogsForums_ForumNewCategories()
        {
            GotoForums();
            if (browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxSubmitNewForum")).Exists == true)
            {
                browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxSubmitNewForum")).Click();
                browser.WaitForComplete(10);
                Assert.IsTrue(browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxCategoriesAndTags_uxCategories_0")).Exists);
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T17_BlogsForums_ForumNewAction()
        {
            GotoForums();
            if (browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxSubmitNewForum")).Exists == true)
            {
                browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxSubmitNewForum")).Click();
                browser.WaitForComplete(10);
                Assert.IsTrue(browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxCategoriesAndTags_uxRoleBasedCategories_0")).Exists);
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T18_BlogsForums_ForumNewTag()
        {
            GotoForums();
            if (browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxSubmitNewForum")).Exists == true)
            {
                browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxSubmitNewForum")).Click();
                browser.WaitForComplete(10);
                Assert.IsTrue(browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxCategoriesAndTags_uxTags")).Exists);
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T19_BlogsForums_ForumNewPost()
        {
            GotoForums();
            if (browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxSubmitNewForum")).Exists == true)
            {
                browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxSubmitNewForum")).Click();
                browser.WaitForComplete(10);
                browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxThreadTitle")).TypeText("post forum test" + Date);
                browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBody")).TypeText("post forum test");
                browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPost")).Click();
                Assert.IsTrue(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxThreadTitle")).Text.Contains("post forum test" + Date));
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T20_BlogsForums_ForumDelete()
        {
            GotoForums();
            browser.Link(Find.ByText("post forum test" + Date)).Click();
            browser.WaitForComplete();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDeleteForumThread")).Click();
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxProcessDeleteThread")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(!browser.Link(Find.ByText("post forum test" + Date)).Exists);
        }

        [Test]
        public void T21_BlogsForums_ForumNewSpecChar()
        {
            string specialCHAR = "~!@#$%^&*()_-+={[}]|\\:;\"'<,>.?/";
            GotoForums();
            if (browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxSubmitNewForum")).Exists == true)
            {
                browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxSubmitNewForum")).Click();
                browser.WaitForComplete(10);
                browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxThreadTitle")).TypeText("forum test" + Date + specialCHAR);
                browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBody")).TypeText("forum test" + specialCHAR);
                browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxCategoriesAndTags_uxTags")).TypeText(specialCHAR);
                browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPost")).Click();

                while (browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxTagCloudRep")).Link(Find.ByText(specialCHAR)).Exists == false)
                {
                    browser.Refresh();
                    System.Threading.Thread.Sleep(30000);
                }
                browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxTagCloudRep")).Link(Find.ByText(specialCHAR)).Click();
                System.Threading.Thread.Sleep(5000);
                Assert.IsTrue(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxThreadTitle")).Text.Contains("forum test" + Date + specialCHAR));
                Assert.IsTrue(browser.Text.Contains(specialCHAR));
            }
            else
            {
                Assert.IsTrue(false);
            }
        }
    }
}
