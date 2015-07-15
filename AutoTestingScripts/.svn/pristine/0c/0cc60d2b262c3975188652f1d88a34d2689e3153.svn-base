using System.Collections.Generic;
using System.Text;
using WatiN.Core;
using NUnit.Framework;
using MaiaRegression.Appobjects;
using MaiaRegression.Appobjects.App01_HomePage;
using System;

namespace MaiaRegression.Tasks.Spring6
{
    [TestFixture]
    public class S003_Moderation_Module : SignIn
    {
        [Test]
        public void T01_Moderation_ViewRanking()
        {
            GotoAdminModeration();
            browser.Link(Find.ByText("View Community Rankings")).Click();
            browser.Div(Find.ById("ctl00_uxMainContent_uxListGridView")).WaitUntilExists(10);
            Assert.IsTrue(browser.Div(Find.ById("ctl00_uxMainContent_uxListGridView")).Exists);
        }

        [Test]
        public void T02_Moderation_ViewMemberInfo()
        {
            GotoAdminModeration();
            browser.Link(Find.ByText("View Community Rankings")).Click();
            browser.WaitForComplete();
            browser.Link(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00_ctl04_uxView")).WaitUntilExists(10);
            browser.Link(Find.ById("ctl00_uxMainContent_uxListGridView_ctl00_ctl04_uxView")).Click();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSave")).WaitUntilExists(10);
            Assert.IsTrue(browser.Button(Find.ById("ctl00_uxMainContent_uxSave")).Exists);
        }

        [Test]
        public void T03_Moderation_SearchForumPosts()
        {
            GotoAdminModeration();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).TypeText("tonyleachsf");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option(Find.ByValue("CSForum")).Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
            System.Threading.Thread.Sleep(20000);
            Assert.IsTrue(browser.Div(Find.ById("ctl00_uxMainContent_uxModerateView")).Exists);
            Assert.IsTrue(browser.Div(Find.ById("ctl00_uxMainContent_uxAllPostView")).Exists);
            Assert.IsTrue(browser.Div(Find.ById("ctl00_uxMainContent_uxFirstPostView")).Exists);
            Assert.IsTrue(browser.Div(Find.ById("ctl00_uxMainContent_uxMemberPostView")).Exists);
            Assert.IsTrue(browser.Div(Find.ById("ctl00_uxMainContent_uxMostActiveView")).Exists);
        }

        [Test]
        public void T04_Moderation_SearchBlogPosts()
        {
            GotoAdminModeration();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).TypeText("tonyleachsf");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option(Find.ByValue("CSBlog")).Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
            System.Threading.Thread.Sleep(20000);
            Assert.IsTrue(browser.Div(Find.ById("ctl00_uxMainContent_uxModerateView")).Exists);
            Assert.IsTrue(browser.Div(Find.ById("ctl00_uxMainContent_uxAllPostView")).Exists);
            Assert.IsTrue(browser.Div(Find.ById("ctl00_uxMainContent_uxFirstPostView")).Exists);
            Assert.IsTrue(browser.Div(Find.ById("ctl00_uxMainContent_uxMemberPostView")).Exists);
            Assert.IsTrue(browser.Div(Find.ById("ctl00_uxMainContent_uxMostActiveView")).Exists);
        }

        [Test]
        public void T05_Moderation_SearchGroupPosts()
        {
            GotoAdminModeration();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).TypeText("tonyleachsf");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option(Find.ByValue("CSGroup")).Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
            System.Threading.Thread.Sleep(20000);
            Assert.IsTrue(browser.Div(Find.ById("ctl00_uxMainContent_uxModerateView")).Exists);
            Assert.IsTrue(browser.Div(Find.ById("ctl00_uxMainContent_uxAllPostView")).Exists);
            Assert.IsTrue(browser.Div(Find.ById("ctl00_uxMainContent_uxFirstPostView")).Exists);
            Assert.IsTrue(browser.Div(Find.ById("ctl00_uxMainContent_uxMemberPostView")).Exists);
            Assert.IsTrue(browser.Div(Find.ById("ctl00_uxMainContent_uxMostActiveView")).Exists);
        }

        [Test]
        public void T06_Moderation_SearchShoutPosts()
        {
            GotoAdminModeration();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).TypeText("tonyleachsf");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option(Find.ByText("Shoutbox posts")).Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
            System.Threading.Thread.Sleep(20000);
            Assert.IsTrue(browser.Div(Find.ById("ctl00_uxMainContent_uxModerateView")).Exists);
            Assert.IsTrue(browser.Div(Find.ById("ctl00_uxMainContent_uxAllPostView")).Exists);
            Assert.IsTrue(browser.Div(Find.ById("ctl00_uxMainContent_uxFirstPostView")).Exists);
            Assert.IsTrue(browser.Div(Find.ById("ctl00_uxMainContent_uxMemberPostView")).Exists);
            Assert.IsTrue(browser.Div(Find.ById("ctl00_uxMainContent_uxMostActiveView")).Exists);
        }

        [Test]
        public void T07_Moderation_SearchMessages()
        {
            GotoAdminModeration();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).TypeText("tonyleachsf");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option(Find.ByValue("MaiaMemberMessage")).Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
            System.Threading.Thread.Sleep(20000);
            Assert.IsTrue(browser.Div(Find.ById("ctl00_uxMainContent_uxModerateView")).Exists);
            Assert.IsTrue(browser.Div(Find.ById("ctl00_uxMainContent_uxAllPostView")).Exists);
            Assert.IsTrue(browser.Div(Find.ById("ctl00_uxMainContent_uxFirstPostView")).Exists);
            Assert.IsTrue(browser.Div(Find.ById("ctl00_uxMainContent_uxMemberPostView")).Exists);
            Assert.IsTrue(browser.Div(Find.ById("ctl00_uxMainContent_uxMostActiveView")).Exists);
        }

        [Test]
        public void T08_Moderation_ChangeRole()
        {
            GotoAdminModeration();
            browser.Link(Find.ByText("Search All Users")).Click();
            browser.WaitForComplete();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).TypeText("tonyleachsf");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option(Find.ByValue("UserName")).Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
            Assert.IsTrue(browser.Div(Find.ById("ctl00_uxMainContent_uxListGridView")).Exists);
        }

        [Test]
        public void T09_Moderation_DiscussionSearchForumPosts()
        {
            GotoAdminModeration();
            browser.Back();
            browser.Div(Find.ById("ctl00_uxMainContent_uxDiscussionSearch")).Link(Find.ByText("Discussion Search")).Click();
            browser.WaitForComplete();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxSearchBox")).TypeText("tonyleachsf");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option(Find.ByValue("CSForum")).Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
            System.Threading.Thread.Sleep(20000);
            Assert.IsTrue(browser.Div(Find.ById("ctl00_uxMainContent_uxListGridView")).Exists);
        }

        [Test]
        public void T10_Moderation_DiscussionSearchBlogPosts()
        {
            GotoAdminModeration();
            browser.Back();
            browser.Div(Find.ById("ctl00_uxMainContent_uxDiscussionSearch")).Link(Find.ByText("Discussion Search")).Click();
            browser.WaitForComplete();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxSearchBox")).TypeText("tonyleachsf");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option(Find.ByValue("CSBlog")).Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
            System.Threading.Thread.Sleep(20000);
            Assert.IsTrue(browser.Div(Find.ById("ctl00_uxMainContent_uxListGridView")).Exists);
        }

        [Test]
        public void T11_Moderation_DiscussionSearchGroupPosts()
        {
            GotoAdminModeration();
            browser.Back();
            browser.Div(Find.ById("ctl00_uxMainContent_uxDiscussionSearch")).Link(Find.ByText("Discussion Search")).Click();
            browser.WaitForComplete();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxSearchBox")).TypeText("tonyleachsf");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option(Find.ByValue("CSGroup")).Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
            System.Threading.Thread.Sleep(20000);
            Assert.IsTrue(browser.Div(Find.ById("ctl00_uxMainContent_uxListGridView")).Exists);
        }

        [Test]
        public void T12_Moderation_DiscussionSearchShoutPosts()
        {
            GotoAdminModeration();
            browser.Back();
            browser.Div(Find.ById("ctl00_uxMainContent_uxDiscussionSearch")).Link(Find.ByText("Discussion Search")).Click();
            browser.WaitForComplete();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxSearchBox")).TypeText("tonyleachsf");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option(Find.ByText("Shoutbox Posts")).Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
            System.Threading.Thread.Sleep(20000);
            Assert.IsTrue(browser.Div(Find.ById("ctl00_uxMainContent_uxListGridView")).Exists);
        }

        [Test]
        public void T13_Moderation_DiscussionSearchMessages()
        {
            GotoAdminModeration();
            browser.Back();
            browser.Div(Find.ById("ctl00_uxMainContent_uxDiscussionSearch")).Link(Find.ByText("Discussion Search")).Click();
            browser.WaitForComplete();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxSearchBox")).TypeText("tonyleachsf");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option(Find.ByValue("MaiaMemberMessage")).Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
            System.Threading.Thread.Sleep(20);
            Assert.IsTrue(browser.Div(Find.ById("ctl00_uxMainContent_uxListGridView")).Exists);
        }

        [Test]
        public void T14_Moderation_SetEditPicker()
        {
            if (browser.Link(Find.ById("ctl00_uxLoginView_uxLoginStatus")).Exists)
            {
                browser.Span(Find.ById("ctl00_uxSiteMapBreadCrumb")).Link(Find.ByText("Portal Admin")).Click();
                browser.Link(Find.ById("ctl00_uxLoginView_uxLoginStatus")).Click();
            }
            browser.GoTo(URL);
            browser.WaitForComplete();

            UserSignIn(UN, PW, false, 2);
            browser.Link(Find.ByText("Community Profile")).Click();
            browser.Span(Find.ById("uxEditorPickText")).WaitUntilExists(10);
            browser.Span(Find.ById("uxEditorPickText")).Click();
            System.Threading.Thread.Sleep(1000);
            Assert.IsTrue(browser.Span(Find.ById("uxEditorPickText")).Text.Contains("Remove"));
        }

        [Test]
        public void T15_Moderation_RemoveEditPicker()
        {
            UserSignIn(UN, PW, false, 2);
            browser.Link(Find.ByText("Community Profile")).Click();
            browser.Span(Find.ById("uxEditorPickText")).WaitUntilExists(10);
            browser.Span(Find.ById("uxEditorPickText")).Click();
            System.Threading.Thread.Sleep(1000);
            Assert.IsTrue(browser.Span(Find.ById("uxEditorPickText")).Text.Contains("Set"));
        }

        [Test]
        public void T16_Moderation_BannedUser()
        {
            UserSignIn("test22", "Passw0rd", false, 2);
            browser.Link(Find.ByText("Community Profile")).Click();
            browser.WaitForComplete();

            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxShoutText")).TypeText("banned");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxSubmitShout")).Click();
            if ((browser.Div(Find.ById("uxShoutMesssage")).Exists == false) ||
                (browser.Div(Find.ById("uxShoutMesssage")).Text.Contains("restricted") == false))
            {
                Assert.IsTrue(false);
                return;
            }

            browser.Link(Find.ByText("Discussions")).Click();
            browser.WaitForComplete(30);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxSubmitNewForum")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxThreadTitle")).TypeText("banned");
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBody")).TypeText("banned");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPost")).Click();
            if ((browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberMesssage_Panel1")).Exists == false) ||
                (browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberMesssage_Panel1")).Text.Contains("restricted") == false))
            {
                Assert.IsTrue(false);
                return;
            }
            //browser.Button(Find.ByClass("CloseButton")).Click();
        }

        [Test]
        public void T17_Moderation_ModeratedUser()
        {
            UserSignIn(UN2, PW2, false, 2);
            browser.Link(Find.ByText("Community Profile")).Click();
            browser.WaitForComplete();

            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxShoutText")).TypeText("moderated");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxSubmitShout")).Click();
            if ((browser.Div(Find.ById("uxShoutMesssage")).Exists == false) ||
                (browser.Div(Find.ById("uxShoutMesssage")).Text.Contains("moderated") == false))
            {
                Assert.IsTrue(false);
                return;
            }

            browser.Link(Find.ByText("Discussions")).Click();
            browser.WaitForComplete(30);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxSubmitNewForum")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxThreadTitle")).TypeText("moderated");
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxBody")).TypeText("moderated");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPost")).Click();
            if ((browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberMesssage_Panel2")).Exists == false) ||
                (browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberMesssage_Panel2")).Text.Contains("moderated") == false))
            {
                Assert.IsTrue(false);
                return;
            }
            //browser.Button(Find.ByClass("CloseButton")).Click();
        }

        [Test]
        public void T18_Moderation_ApproveDeny()
        {
            GotoAdminModeration();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxUser")).TypeText("moderated");
            //browser.SelectList(Find.ById("ctl00_uxMainContent_uxSearchBy")).Option(Find.ByValue("Everything")).Select();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
            System.Threading.Thread.Sleep(20000);
            int rows = browser.Div(Find.ById("ctl00_uxMainContent_uxModerateView")).Table(Find.ById("ctl00_uxMainContent_uxModerateView_ctl00")).TableBodies[0].TableRows.Count;
            browser.CheckBox(Find.ById("ctl00_uxMainContent_uxModerateView_ctl00_ctl06_approvalFlag")).Checked = true;
            browser.Button(Find.ById("ctl00_uxMainContent_uxDeny")).Click();
            System.Threading.Thread.Sleep(10);
            if (rows != browser.Div(Find.ById("ctl00_uxMainContent_uxModerateView")).Table(Find.ById("ctl00_uxMainContent_uxModerateView_ctl00")).TableBodies[0].TableRows.Count + 1)
            {
                Assert.IsTrue(false);
                return;
            }
            browser.CheckBox(Find.ById("ctl00_uxMainContent_uxModerateView_ctl00_ctl04_approvalFlag")).Checked = true;
            browser.Button(Find.ById("ctl00_uxMainContent_uxApprove")).Click();
            if (rows != browser.Div(Find.ById("ctl00_uxMainContent_uxModerateView")).Table(Find.ById("ctl00_uxMainContent_uxModerateView_ctl00")).TableBodies[0].TableRows.Count + 2)
            {
                Assert.IsTrue(false);
                return;
            }
        }

        private void GotoAdminModeration()
        {
            // if there already have a user login, do logout first
            if (browser.Link(Find.ByText("Sign Out")).Exists)
            {
                SignOut si = new SignOut();
                si.UserSignOut(browser);
            }
            if (browser.Link(Find.ById("ctl00_uxLoginView_uxLoginStatus")).Exists)
            {
                browser.Span(Find.ById("ctl00_uxSiteMapBreadCrumb")).Link(Find.ByText("Portal Admin")).Click();
                browser.Link(Find.ById("ctl00_uxLoginView_uxLoginStatus")).Click();
            }
            browser.GoTo(AdminUrl);
            browser.WaitForComplete();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxLogin_UserName")).TypeText(UN3);
            browser.TextField(Find.ById("ctl00_uxMainContent_uxLogin_Password")).TypeText(PW3);
            browser.Button(Find.ById("ctl00_uxMainContent_uxLogin_LoginButton")).Click();
            browser.WaitForComplete();
            browser.Div(Find.ById("ctl00_uxMainContent_uxCommunityManagement")).Link(Find.ByText("Community Management")).Click();
            browser.WaitForComplete();
        }
    }
}
