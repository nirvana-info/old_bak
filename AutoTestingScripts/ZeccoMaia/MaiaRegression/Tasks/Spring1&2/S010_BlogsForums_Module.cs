using System.Text;
using WatiN.Core;
using NUnit.Framework;
using MaiaRegression.Appobjects;
using MaiaRegression.Appobjects.App01_HomePage;
using System;

namespace MaiaRegression.Tasks.Spring1_2
{
    [TestFixture]
    public class S010_BlogsForums_Module:BlogsForums
    {
        [Test]
        public void T01_BlogsForums_ViewMainOverviewPage()
        {
            NavigateToBlogForums(browser);

            // Omit Assert: Visit page and make sure it displays 10 posts
        }

        [Test]
        public void T02_BlogsForums_LinksOffMainOverviewPage()
        {
            NavigateToBlogForums(browser);

            string postTitle = browser.Span(Find.ByClass("wordwrap")).Text;
            browser.Span(Find.ByClass("wordwrap")).Click();
            Assert.AreEqual(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBlogPostTitle")).Text, postTitle);

            string author = browser.Span(Find.ByClass("author")).Text;
            browser.Span(Find.ByClass("author")).Click();
            Assert.AreEqual(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberDisplayName")).Text, author);

            browser.Div(Find.ByClass("float-left")).Link(Find.ByText("comments")).Click();

            browser.Div(Find.ByClass("blogforum-content")).Link(Find.ByText("Read more >>")).Click();
        }

        [Test]
        public void T03_BlogsForums_SharePage()
        {
            NavigateToBlogForums(browser);

            browser.Link(Find.ByText(" Share this page")).Click();
            Assert.AreEqual(browser.Span(Find.ById("bookmark_share")).Text, "Bookmark & Share");
        }

        [Test]
        public void T04_BlogsForums_SharePageTag()
        {
            NavigateToBlogForums(browser);

            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBlogAndForumPosts_ctrl0_uxTagRep_ctl00_uxTagLink")).Click();
            browser.Link(Find.ByText(" Share this page")).Click();
            Assert.AreEqual(browser.Span(Find.ById("bookmark_share")).Text, "Bookmark & Share");
        }

        [Test]
        public void T05_BlogsForums_SharePageThread()
        {
            NavigateToBlogForums(browser);

            browser.Link(Find.ByText("zzjfsj")).Click();
            browser.Link(Find.ByText(" Share this page")).Click();
            Assert.AreEqual(browser.Span(Find.ById("bookmark_share")).Text, "Bookmark & Share");
        }

        [Test]
        public void T06_BlogsForums_SharePagePost()
        {
            NavigateToBlogForums(browser);

            browser.Span(Find.ByClass("wordwrap")).Click();
            browser.Link(Find.ByText(" Share this page")).Click();
            Assert.AreEqual(browser.Span(Find.ById("bookmark_share")).Text, "Bookmark & Share");
        }

        [Test]
        public void T07_BlogsForums_SharePageOverView()
        {
            this.EditBlogSetting();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBlogOverview")).Click();
            browser.Link(Find.ByText(" Share this page")).Click();
            Assert.AreEqual(browser.Span(Find.ById("bookmark_share")).Text, "Bookmark & Share");
        }

        [Test]
        public void T08_BlogsForums_RSS()
        {
            NavigateToBlogForums(browser);

            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxRssFeed_uxRssLinkButton")).Click();
            Assert.AreEqual(browser.Div(Find.ById("feedTitleContainer")).Text, "Zecco - Blogs and Forums");
        }

        [Test]
        public void T09_BlogsForums_RSSTagCat()
        {
            NavigateToBlogForums(browser);

            string tag = browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBlogAndForumPosts_ctrl2_uxTagRep_ctl00_uxTagLink")).Text;
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBlogAndForumPosts_ctrl2_uxTagRep_ctl00_uxTagLink")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxRssFeed_uxRssLinkButton")).Click();
            Assert.AreEqual(browser.Div(Find.ById("feedTitleText")).Text, "Zecco - Blogs and Forums for " + tag);
        }

        [Test]
        public void T10_BlogsForums_RSSComment1()
        {
            NavigateToBlogForums(browser);

            browser.Link(Find.ByText("zzjfsj")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxRssFeed_uxRssLinkButton")).Click();
            //Assert.AreEqual(browser.Div(Find.ById("feedTitleContainer")).Text, "Zecco - Blogs and Forums");
            //TODO bug
        }

        [Test]
        public void T11_BlogsForums_RSSComment2()
        {
            NavigateToBlogForums(browser);

            browser.Span(Find.ByClass("wordwrap")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxRssFeed_uxRssLinkButton")).Click();
            //Assert.AreEqual(browser.Div(Find.ById("feedTitleContainer")).Text, "Zecco - Blogs and Forums");
            //TODO bug
        }

        [Test]
        public void T12_BlogsForums_RSSPost()
        {
            this.EditBlogSetting();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBlogOverview")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxRssFeed_uxRssLinkButton")).Click();
            //Assert.AreEqual(browser.Div(Find.ById("feedTitleContainer")).Text, "Zecco - Blogs and Forums");
            //TODO bug
        }

        [Test]
        public void T13_BlogsForums_RateThreadMain()
        {
            NavigateToBlogForums(browser);

            int rate = Convert.ToInt32(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBlogAndForumPosts_ctrl0_uxRatingSum")).Text);
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBlogAndForumPosts_ctrl0_uxThumbsUp")).Click();
            Assert.AreEqual(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBlogAndForumPosts_ctrl0_uxRatingSum")).Text, (rate + 1).ToString());
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBlogAndForumPosts_ctrl0_uxThumbsUp")).Click();
            Assert.AreEqual(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBlogAndForumPosts_ctrl0_uxRatingSum")).Text, (rate + 1).ToString());
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBlogAndForumPosts_ctrl0_uxThumbsDown")).Click();
            Assert.AreEqual(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBlogAndForumPosts_ctrl0_uxRatingSum")).Text, (rate - 1).ToString());
        }

        [Test]
        public void T14_BlogsForums_RateThreadPost()
        {
            NavigateToBlogForums(browser);

            browser.Link(Find.ByText("zzjfsj")).Click();
            int rate = Convert.ToInt32(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostRatingSum")).Text);
            browser.Link(Find.ByClass("thumb thumb-down")).Click();
            Assert.AreEqual(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostRatingSum")).Text, (rate - 1).ToString());
            browser.Link(Find.ByClass("thumb thumb-down")).Click();
            Assert.AreEqual(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostRatingSum")).Text, (rate - 1).ToString());
            browser.Link(Find.ByClass("thumb thumb-up")).Click();
            Assert.AreEqual(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostRatingSum")).Text, (rate + 1).ToString());
        }

        [Test]
        public void T15_BlogsForums_RateForumComment()
        {
            NavigateToBlogForums(browser);

            browser.Link(Find.ByText("zzjfsj")).Click();
            int rate = Convert.ToInt32(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostRatingSum")).Text);
            browser.Link(Find.ByClass("thumb thumb-down")).Click();
            Assert.AreEqual(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostRatingSum")).Text, (rate - 1).ToString());
            browser.Link(Find.ByClass("thumb thumb-down")).Click();
            Assert.AreEqual(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostRatingSum")).Text, (rate - 1).ToString());
            browser.Link(Find.ByClass("thumb thumb-up")).Click();
            Assert.AreEqual(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostRatingSum")).Text, (rate + 1).ToString());
        }

        [Test]
        public void T16_BlogsForums_RateBlogComment()
        {
            NavigateToBlogForums(browser);

            browser.Span(Find.ByClass("wordwrap")).Click();
            int rate = Convert.ToInt32(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostRatingSum")).Text);
            browser.Link(Find.ByClass("thumb thumb-down")).Click();
            Assert.AreEqual(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostRatingSum")).Text, (rate - 1).ToString());
            browser.Link(Find.ByClass("thumb thumb-down")).Click();
            Assert.AreEqual(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostRatingSum")).Text, (rate - 1).ToString());
            browser.Link(Find.ByClass("thumb thumb-up")).Click();
            Assert.AreEqual(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostRatingSum")).Text, (rate + 1).ToString());
        }

        [Test]
        public void T17_BlogsForums_ReplyForumThread()
        {
            NavigateToBlogForums(browser);

            browser.Link(Find.ByText("zzjfsj")).Click();
            int rate = Convert.ToInt32(browser.TextField(Find.ByText("Replies")).Text.Replace("Replies", "").Trim());
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostReplyText")).TypeText("ddpg");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostReply")).Click();
            Assert.AreEqual(Convert.ToInt32(browser.TextField(Find.ByText("Replies")).Text.Replace("Replies", "").Trim()), rate + 1);
        }

        [Test]
        public void T18_BlogsForums_ReplyBlogPost()
        {
            NavigateToBlogForums(browser);

            browser.Span(Find.ByClass("wordwrap")).Click();
            int rate = Convert.ToInt32(browser.TextField(Find.ByText("Replies")).Text.Replace("Replies", "").Trim());
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostReplyText")).TypeText("ddpg");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostReply")).Click();
            Assert.AreEqual(Convert.ToInt32(browser.TextField(Find.ByText("Replies")).Text.Replace("Replies", "").Trim()), rate + 1);
        }

        [Test]
        public void T19_BlogsForums_ReplyForumThreadOver1500()
        {
            NavigateToBlogForums(browser);

            browser.Link(Find.ByText("zzjfsj")).Click();
            int rate = Convert.ToInt32(browser.TextField(Find.ByText("Replies")).Text.Replace("Replies", "").Trim());
            StringBuilder text = new StringBuilder();
            for (int i = 0; i < 1501; i++)
            {
                text.Append('a');
            }
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostReplyText")).TypeText(text.ToString());
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostReply")).Click();
            Assert.AreEqual(Convert.ToInt32(browser.TextField(Find.ByText("Replies")).Text.Replace("Replies", "").Trim()), rate + 1);
            Assert.AreEqual(browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostReplyText")).Text, text.ToString(0, 1500));
        }

        [Test]
        public void T20_BlogsForums_ReplyBlogPostOver1500()
        {
            NavigateToBlogForums(browser);

            browser.Span(Find.ByClass("wordwrap")).Click();
            int rate = Convert.ToInt32(browser.TextField(Find.ByText("Replies")).Text.Replace("Replies", "").Trim());
            StringBuilder text = new StringBuilder();
            for (int i = 0; i < 1501; i++)
            {
                text.Append('a');
            }
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostReplyText")).TypeText(text.ToString());
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostReply")).Click();
            Assert.AreEqual(Convert.ToInt32(browser.TextField(Find.ByText("Replies")).Text.Replace("Replies", "").Trim()), rate + 1);
            Assert.AreEqual(browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostReplyText")).Text, text.ToString(0, 1500));
        }

        [Test]
        public void T21_BlogsForums_ReplyForumThreadHTMLPos()
        {
            NavigateToBlogForums(browser);

            browser.Link(Find.ByText("zzjfsj")).Click();
            int rate = Convert.ToInt32(browser.TextField(Find.ByText("Replies")).Text.Replace("Replies", "").Trim());
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostReplyText")).TypeText("aa(<a href='URL'>i'm here</a>)aa");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostReply")).Click();
            Assert.AreEqual(Convert.ToInt32(browser.TextField(Find.ByText("Replies")).Text.Replace("Replies", "").Trim()), rate + 1);
            Assert.AreEqual(browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostReplyText")).Text, "aa(i'm here)aa");
        }

        [Test]
        public void T22_BlogsForums_ReplyForumThreadHTMLNeg()
        {
            NavigateToBlogForums(browser);

            browser.Link(Find.ByText("zzjfsj")).Click();
            int rate = Convert.ToInt32(browser.TextField(Find.ByText("Replies")).Text.Replace("Replies", "").Trim());
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostReplyText")).TypeText("aa(<a href='L'>i'm here</a>)aa");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostReply")).Click();
            Assert.AreEqual(Convert.ToInt32(browser.TextField(Find.ByText("Replies")).Text.Replace("Replies", "").Trim()), rate + 1);
            Assert.AreEqual(browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostReplyText")).Text, "aa()aa");
        }

        [Test]
        public void T23_BlogsForums_ReplyBlogPostHTMLPos()
        {
            NavigateToBlogForums(browser);

            browser.Span(Find.ByClass("wordwrap")).Click();
            int rate = Convert.ToInt32(browser.TextField(Find.ByText("Replies")).Text.Replace("Replies", "").Trim());
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostReplyText")).TypeText("aa(<a href='URL'>i'm here</a>)aa");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostReply")).Click();
            Assert.AreEqual(Convert.ToInt32(browser.TextField(Find.ByText("Replies")).Text.Replace("Replies", "").Trim()), rate + 1);
            Assert.AreEqual(browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostReplyText")).Text, "aa(i'm here)aa");
        }

        [Test]
        public void T24_BlogsForums_ReplyBlogPostHTMLNeg()
        {
            NavigateToBlogForums(browser);

            browser.Span(Find.ByClass("wordwrap")).Click();
            int rate = Convert.ToInt32(browser.TextField(Find.ByText("Replies")).Text.Replace("Replies", "").Trim());
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostReplyText")).TypeText("aa(<a href='L'>i'm here</a>)aa");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostReply")).Click();
            Assert.AreEqual(Convert.ToInt32(browser.TextField(Find.ByText("Replies")).Text.Replace("Replies", "").Trim()), rate + 1);
            Assert.AreEqual(browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostReplyText")).Text, "aa()aa");
        }

        [Test]
        public void T25_BlogsForums_CreateForumThreadPos()
        {
            NavigateToBlogForums(browser);

            string title = "zzjfsj";
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxAddForumThread")).TypeText(title);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxSubmitNewForum")).Click();
            //Assert.AreEqual(browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxThreadTitle")).Text, title);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBody")).TypeText("ddpg");
            browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxCategoriesAndTags_uxCategories_0")).Checked = true;
            browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxCategoriesAndTags_uxCategories_1")).Checked = true;
            browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxCategoriesAndTags_uxCategories_2")).Checked = true;
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxCategoriesAndTags_uxTags")).TypeText("abc");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPost")).Click();
        }

        [Test]
        public void T26_BlogsForums_CreateForumThreadNegNoTitle()
        {
            NavigateToBlogForums(browser);

            string title = "zzjfsj";
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxAddForumThread")).TypeText(title);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxSubmitNewForum")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxThreadTitle")).TypeText("");
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBody")).TypeText("ddpg");
            browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxCategoriesAndTags_uxCategories_0")).Checked = true;
            browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxCategoriesAndTags_uxCategories_1")).Checked = true;
            browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxCategoriesAndTags_uxCategories_2")).Checked = true;
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxCategoriesAndTags_uxTags")).TypeText("abc");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPost")).Click();
            Assert.IsTrue(browser.Span(Find.ByClass("inline-error")).Text.Contains("Oops!  You need to enter a thread title before we can proceed."));
        }

        [Test]
        public void T27_BlogsForums_CreateForumThreadNegNoCatTag()
        {
            NavigateToBlogForums(browser);

            string title = "zzjfsj";
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxAddForumThread")).TypeText(title);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxSubmitNewForum")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBody")).TypeText("ddpg");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPost")).Click();
            //TODO bug
            //Assert.IsTrue(browser.Span(Find.ByClass("inline-error")).Text.Contains("Oops!  You need to enter a thread title before we can proceed."));
        }

        [Test]
        public void T28_BlogsForums_CreateForumThreadMaxChar()
        {
            NavigateToBlogForums(browser);

            string title = "zzjfsj";
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxAddForumThread")).TypeText(title);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxSubmitNewForum")).Click();
            StringBuilder tt = new StringBuilder();
            for (int i = 0; i < 65; i++)
            {
                tt.Append('b');
            }
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxThreadTitle")).TypeText(tt.ToString());
            StringBuilder text = new StringBuilder();
            for (int i = 0; i < 1501; i++)
            {
                text.Append('a');
            }
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBody")).TypeText(text.ToString());
            browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxCategoriesAndTags_uxCategories_0")).Checked = true;
            browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxCategoriesAndTags_uxCategories_1")).Checked = true;
            browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxCategoriesAndTags_uxCategories_2")).Checked = true;
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxCategoriesAndTags_uxTags")).TypeText("abc");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPost")).Click();
            Assert.AreEqual(browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxThreadTitle")).Text, text.ToString().Substring(0, 64));
            Assert.AreEqual(browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBody")).Text, text.ToString().Substring(0, 1500));
        }

        [Test]
        public void T29_BlogsForums_CreateForumThreadHTML()
        {
            NavigateToBlogForums(browser);

            string title = "zzjfsj";
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxAddForumThread")).TypeText(title);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxSubmitNewForum")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBody")).TypeText("aa(<a href='URL'>i'm here</a>)aa");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPost")).Click();
            Assert.AreEqual(browser.Div(Find.ByClass("content blogforum-content")).Text, "aa(i'm here)aa");
        }

        [Test]
        public void T30_BlogsForums_ReportAbuseForum()
        {
            NavigateToBlogForums(browser);

            browser.Link(Find.ByText("zzjfsj")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxThreadRepliesListView_ctrl0_uxFlagAbuse")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxThreadRepliesListView_ctrl0_uxFlagAbuseMessageBody")).TypeText("a");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxThreadRepliesListView_ctrl0_uxSaveFlagAbuseThreadReply")).Click();
            //TODO block by bug
        }

        [Test]
        public void T31_BlogsForums_ReportAbuseBlog()
        {
            NavigateToBlogForums(browser);

            browser.Span(Find.ByClass("wordwrap")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxThreadRepliesListView_ctrl0_uxFlagAbuse")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxThreadRepliesListView_ctrl0_uxFlagAbuseMessageBody")).TypeText("a");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxThreadRepliesListView_ctrl0_uxSaveFlagAbuseThreadReply")).Click();
            //TODO block by bug
        }

        [Test]
        public void T32_BlogsForums_EditYourOwnForum()
        {
            NavigateToBlogForums(browser);

            browser.Link(Find.ByText("zzjfsj")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxEditForumThread")).Click();
            string text = "abc";
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxEditThreadBody")).TypeText(text);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxSaveInitialForumThread")).Click();
            Assert.AreEqual(browser.TextField(Find.ByClass("content blogforum-content")).Text, text);
        }

        [Test]
        public void T33_BlogsForums_EditYourOwnForumNegMaxChar()
        {
            NavigateToBlogForums(browser);

            browser.Link(Find.ByText("zzjfsj")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxEditForumThread")).Click();
            StringBuilder text = new StringBuilder();
            for (int i = 0; i < 1501; i++)
            {
                text.Append('a');
            }
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxEditThreadBody")).TypeText(text.ToString());
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxSaveInitialForumThread")).Click();
            Assert.AreEqual(browser.TextField(Find.ByClass("content blogforum-content")).Text, text.ToString().Substring(0, 1500));
        }

        [Test]
        public void T34_BlogsForums_EditYourOwnForumHTML()
        {
            NavigateToBlogForums(browser);

            browser.Link(Find.ByText("zzjfsj")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxEditForumThread")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxEditThreadBody")).TypeText("aa(<a href='URL'>i'm here</a>)aa");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxSaveInitialForumThread")).Click();
            Assert.AreEqual(browser.TextField(Find.ByClass("content blogforum-content")).Text, "aa(i'm here)aa");
        }

        [Test]
        public void T35_BlogsForums_DelForumNegCancel()
        {
            NavigateToBlogForums(browser);

            browser.Link(Find.ByText("zzjfsj")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDeleteForumThread")).Click();
            browser.Button(Find.ByClass("CloseButton")).Click();
            Assert.AreEqual(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxThreadTitle")).Text, "zzjfsj");
        }

        [Test]
        public void T36_BlogsForums_DelForumPos()
        {
            NavigateToBlogForums(browser);

            browser.Link(Find.ByText("zzjfsj")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDeleteForumThread")).Click();
            browser.Button(Find.ById("ProceedButton")).Click();
            Assert.IsTrue(browser.Div(Find.ByClass("blogforum-content")).Text.Contains("Blogs & Forums"));
        }

        [Test]
        public void T37_BlogsForums_LockThread()
        {
            NavigateToBlogForums(browser);

            browser.Link(Find.ByText("zzjfsj")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxLockForumThread")).Click();
            Assert.IsTrue(browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxLockForumThread")).Text.Contains("Unlock Thread"));
        }

        [Test]
        public void T38_BlogsForums_UnlockThread()
        {
            NavigateToBlogForums(browser);

            browser.Link(Find.ByText("zzjfsj")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxLockForumThread")).Click();
            Assert.IsTrue(browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxLockForumThread")).Text.Contains("Lock Thread"));
        }

        [Test]
        public void T39_BlogsForums_EditYourOwnForumComment()
        {
            //TODO bug
        }

        [Test]
        public void T40_BlogsForums_EditYourOwnForumCommentCancel()
        {
            //TODO bug
        }

        [Test]
        public void T41_BlogsForums_EditYourOwnForumCommentHTMLPos()
        {
            //TODO bug
        }

        [Test]
        public void T42_BlogsForums_EditYourOwnForumCommentHTMLNeg()
        {
            //TODO bug
        }

        [Test]
        public void T43_BlogsForums_EditYourOwnForumCommentOver1500()
        {
            //TODO bug
        }

        [Test]
        public void T44_BlogsForums_DeleteYourOwnForumComment()
        {
            //TODO bug
        }

        [Test]
        public void T45_BlogsForums_DeleteYourOwnForumCommentCancel()
        {
            //TODO bug
        }

        [Test]
        public void T46_BlogsForums_EditYourOwnBlogComment()
        {
            //TODO bug
        }

        [Test]
        public void T47_BlogsForums_EditYourOwnBlogCommentCancel()
        {
            //TODO bug
        }

        [Test]
        public void T48_BlogsForums_EditYourOwnBlogCommentHTMLPos()
        {
            //TODO bug
        }

        [Test]
        public void T49_BlogsForums_EditYourOwnBlogCommentHTMLNeg()
        {
            //TODO bug
        }

        [Test]
        public void T50_BlogsForums_EditYourOwnBlogCommentOver1500()
        {
            //TODO bug
        }

        [Test]
        public void T51_BlogsForums_DeleteYourOwnBlogComment()
        {
            //TODO bug
        }

        [Test]
        public void T52_BlogsForums_DeleteYourOwnBlogCommentCancel()
        {
            //TODO bug
        }

        [Test]
        public void T53_BlogsForums_FilterByPerson()
        {
            NavigateToBlogForums(browser);

            string name = browser.Link(Find.ByClass("author")).Text;
            browser.Link(Find.ByClass("author")).Click();
            Assert.AreEqual(browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxMemberShoutBox_uxShoutsList_ctl00_uxShoutAuthorScreenNameLink")).Text, name);
        }

        [Test]
        public void T54_BlogsForums_FilterByTag()
        {
            NavigateToBlogForums(browser);

            string tag = browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBlogAndForumPosts_ctrl0_uxTagRep_ctl00_uxTagLink")).Text;
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBlogAndForumPosts_ctrl0_uxTagRep_ctl00_uxTagLink")).Click();
            Assert.AreEqual(browser.Div(Find.ByClass("blogforum-content")).Text, string.Format("                     Posts Related to {0}                 ", tag));
        }

        [Test]
        public void T55_BlogsForums_FilterByCategory()
        {
            NavigateToBlogForums(browser);

            string cat = browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxTopCategories_uxCategoriesListView_ctrl3_uxPostLink")).Text;
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxTopCategories_uxCategoriesListView_ctrl3_uxPostLink")).Click();
            Assert.AreEqual(browser.Div(Find.ByClass("blogforum-content")).Text, string.Format("                     Posts Related to {0}                 ", cat));
        }

        [Test]
        public void T56_BlogsForums_CreateBlogPostPos()
        {
            string title = "ddpg1";
            this.CreateBlogPost(title, true, "dim", "", "");
            Assert.AreEqual(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBlogPostTitle")).Text, title);
        }

        [Test]
        public void T57_BlogsForums_CreateBlogPostNegNoTitle()
        {
            string title = "";
            this.CreateBlogPost(title, true, "dim", "", "");
            Assert.IsTrue(browser.Span(Find.ByClass("inline-error")).Text.Contains("Oops!  You need to enter your blog post title before we can proceed."));
        }

        [Test]
        public void T58_BlogsForums_CreateBlogPostNegNoCatTag()
        {
            string title = "ddpg1";
            this.CreateBlogPost(title, false, "", "", "");
            Assert.IsTrue(browser.Span(Find.ByClass("inline-error")).Text.Contains("TODO:???"));
        }

        [Test]
        public void T59_BlogsForums_CreateBlogPostMaxChar()
        {
            StringBuilder title = new StringBuilder();
            for (int i = 0; i < 65; i++)
            {
                title.Append('a');
            }
            this.CreateBlogPost(title.ToString(), true, "dim", "", "");
            Assert.AreEqual(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBlogPostTitle")).Text, title.ToString().Substring(0, 64));
        }

        [Test]
        public void T60_BlogsForums_CreateBlogPostHTML()
        {
            string title = "ddpg1";
            this.CreateBlogPost(title, true, "dim", "", "");
            Assert.AreEqual(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBlogPostTitle")).Text, title);
        }

        [Test]
        public void T61_BlogsForums_CreateBlogPostHTML()
        {
            string title = "ddpg1";
            this.CreateBlogPost(title, true, "dim", "", "");
            Assert.AreEqual(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBlogPostTitle")).Text, title);
        }

        [Test]
        public void T62_BlogsForums_CreateBlog()
        {
            this.CreateBlog("jaylen", "jaylen");
            Assert.IsTrue(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSuccessMessagePersonalBlog")).Text.Contains("Saved successfully!"));
            Assert.AreEqual(browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxBlogTitle")).Text, "jaylen");
            Assert.AreEqual(browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxBlogURL")).Text, "jaylen");
        }

        [Test]
        public void T63_BlogsForums_CreateBlogMaxChar()
        {
            StringBuilder title = new StringBuilder();
            for (int i = 0; i < 65; i++)
            {
                title.Append('a');
            }
            this.CreateBlog(title.ToString(), "abcde1234567890a");
            Assert.IsTrue(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSuccessMessagePersonalBlog")).Text.Contains("Saved successfully!"));
            Assert.AreEqual(browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxBlogTitle")).Text, title.ToString().Substring(0, 64));
            Assert.AreEqual(browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxBlogURL")).Text, "abcde1234567890");
        }

        [Test]
        public void T64_BlogsForums_CreateBlogNegChar()
        {
            NavigateToBlogForums(browser);
            Assert.IsTrue(browser.Span(Find.ByClass("message-error")).Text.Contains("Oops!  You need to choose a Blog URL before we can proceed."));
        }

        [Test]
        public void T65_BlogsForums_ManagePostsControls()
        {
            NavigateToBlogForums(browser);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxMemberLoginStatus_uxMemberLoginView_uxSettings")).Click();
            browser.Link(Find.ByText("Set Up Your Personal Blog")).Click();
            //browser.Link(Find.ByText("                                     Manage Previous Posts")).Click();
            //browser.Link(Find.ByText(" 								View")).Click();
            browser.Link(Find.ByText("Manage Previous Posts")).Click();
            int view1 = Convert.ToInt32(browser.TableBody(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxRadGridMail_ctl00__0")).TableRows[0].TableCells[2].Text);
            browser.Link(Find.ByText("View")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxManageBlog")).Click();
            int view2 = Convert.ToInt32(browser.TableBody(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxRadGridMail_ctl00__0")).TableRows[0].TableCells[2].Text);
            Assert.AreEqual(view1 + 1, view2);
        }

        [Test]
        public void T66_BlogsForums_ManagePostsEdit()
        {
            NavigateToBlogForums(browser);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxMemberLoginStatus_uxMemberLoginView_uxSettings")).Click();
            browser.Link(Find.ByText("Set Up Your Personal Blog")).Click();
            //browser.Link(Find.ByText("                                     Manage Previous Posts")).Click();
            //browser.Link(Find.ByText(" 								Edit")).Click();
            browser.Link(Find.ByText("Manage Previous Posts")).Click();
            browser.Link(Find.ByText("Edit")).Click();
            string title = "ddpg2";
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBlogPostTitle")).TypeText(title);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxUpdate")).Click();
            Assert.AreEqual(browser.TableBody(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxRadGridMail_ctl00__0")).TableRows[0].TableCells[0].Text, title);
        }

        [Test]
        public void T67_BlogsForums_ManagePostsEditNegMaxChar()
        {
            NavigateToBlogForums(browser);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxMemberLoginStatus_uxMemberLoginView_uxSettings")).Click();
            browser.Link(Find.ByText("Set Up Your Personal Blog")).Click();
            browser.Link(Find.ByText("Manage Previous Posts")).Click();
            browser.Link(Find.ByText("Edit")).Click();
            StringBuilder title = new StringBuilder();
            for (int i = 0; i < 65; i++)
            {
                title.Append('a');
            }
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBlogPostTitle")).TypeText(title.ToString());
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxUpdate")).Click();
            Assert.AreEqual(browser.TableBody(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxRadGridMail_ctl00__0")).TableRows[0].TableCells[0].Text, 
                title.ToString().Substring(0, 64));
        }

        [Test]
        public void T68_BlogsForums_CreateBlogPostDatePre()
        {
            DateTime dt = DateTime.Now.AddDays(-1);
            this.CreateBlogPost("ddlc", true, "dp", dt.ToString("M/dd/yyyy"), "");
            Assert.IsTrue(browser.Span(Find.ByClass("date")).Text.Contains(dt.DayOfWeek.ToString()));
        }

        [Test]
        public void T69_BlogsForums_CreateBlogPostDateFuture()
        {
            DateTime dt = DateTime.Now.AddHours(1);
            this.CreateBlogPost("ddlc", true, "dp", dt.ToString("M/dd/yyyy"), dt.ToString("H:mm"));
            //TODO no post
        }

        [Test]
        public void T70_BlogsForums_ManagePostDelete()
        {
            NavigateToBlogForums(browser);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxMemberLoginStatus_uxMemberLoginView_uxSettings")).Click();
            browser.Link(Find.ByText("Set Up Your Personal Blog")).Click();
            browser.Link(Find.ByText("Manage Previous Posts")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxRadGridMail_ctl00_ctl04_uxDeletePost")).Click();
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxRadGridMail_ctl00_ctl04_uxYesButton")).Click();
            Assert.AreEqual(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSuccessMessage")).Text, "The post was deleted successfully.");
        }

        [Test]
        public void T71_BlogsForums_ManagePostDeleteCancel()
        {
            NavigateToBlogForums(browser);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxMemberLoginStatus_uxMemberLoginView_uxSettings")).Click();
            browser.Link(Find.ByText("Set Up Your Personal Blog")).Click();
            browser.Link(Find.ByText("Manage Previous Posts")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxRadGridMail_ctl00_ctl04_uxDeletePost")).Click();
            browser.Button(Find.ByClass("CloseButton")).Click();
        }

        [Test]
        public void T72_BlogsForums_ManagePostView()
        {
            NavigateToBlogForums(browser);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxMemberLoginStatus_uxMemberLoginView_uxSettings")).Click();
            browser.Link(Find.ByText("Set Up Your Personal Blog")).Click();
            browser.Link(Find.ByText("Manage Previous Posts")).Click();
            string title = browser.TableBody(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxRadGridMail_ctl00__0")).TableRows[0].TableCells[0].Text;
            browser.Link(Find.ByText("View")).Click();
            Assert.AreEqual(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBlogPostTitle")).Text, title);
        }

        [Test]
        public void T73_BlogsForums_EditBlogSetting()
        {
            this.EditBlogSetting();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBlogTitle")).TypeText("ddpg");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSave")).Click();
            //TODO no function
        }

        [Test]
        public void T74_BlogsForums_EditBlogSettingContent()
        {
            this.EditBlogSetting();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBlogTitle")).TypeText("ddpg");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSave")).Click();
            //TODO no function
        }

        [Test]
        public void T75_BlogsForums_EditBlogSetting64Char()
        {
            this.EditBlogSetting();
            StringBuilder title = new StringBuilder();
            for (int i = 0; i < 65; i++)
            {
                title.Append('a');
            }
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBlogTitle")).TypeText(title.ToString());
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSave")).Click();
            //TODO no function
        }

        [Test]
        public void T76_BlogsForums_EditBlogSettingContent()
        {
            this.EditBlogSetting();
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSave")).Click();
            //TODO no function
        }

        [Test]
        public void T77_BlogsForums_EditBlogSettingGoToBlog()
        {
            this.EditBlogSetting();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBlogOverview")).Click();
            Assert.IsTrue(browser.Label(Find.ByClass("PagerInfoCell")).Text.Contains("Page"));
        }

        [Test]
        public void T78_BlogsForums_ManagePostGoToBlog()
        {
            NavigateToBlogForums(browser);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxMemberLoginStatus_uxMemberLoginView_uxSettings")).Click();
            browser.Link(Find.ByText("Set Up Your Personal Blog")).Click();
            browser.Link(Find.ByText("Manage Previous Posts")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBlogOverview")).Click();
            Assert.IsTrue(browser.Label(Find.ByClass("PagerInfoCell")).Text.Contains("Page"));
        }

        #region CommonPart
        private void CreateBlogPost(string title, bool hasCat, string tag, string date, string time)
        {
            NavigateToBlogForums(browser);

            browser.Link(Find.ByTitle("Profile")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberProfileBox_uxEditProfile")).Click();
            browser.Link(Find.ByText("Personal Blog")).Click();
            browser.Link(Find.ByText("                                     Write a New Post")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBlogPostTitle")).TypeText(title);
            browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxCategoriesAndTags_uxCategories_0")).Checked = hasCat;
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxCategoriesAndTags_uxTags")).TypeText(tag);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxRadDatePicker_dateInput_text")).TypeText(date);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxRadTimePicker_dateInput_text")).TypeText(time);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPost")).Click();
        }

        private void CreateBlog(string title, string url)
        {
            NavigateToBlogForums(browser);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxMemberLoginStatus_uxMemberLoginView_uxSettings")).Click();
            browser.Link(Find.ByText("Set Up Your Personal Blog")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxBlogTitle")).TypeText(title);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxBlogURL")).TypeText(url);
        }

        private void EditBlogSetting()
        {
            NavigateToBlogForums(browser);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxMemberLoginStatus_uxMemberLoginView_uxSettings")).Click();
            browser.Link(Find.ByText("Set Up Your Personal Blog")).Click();
            browser.Link(Find.ByText("Edit Blog Settings")).Click();
        }
        #endregion
    }
}
