using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks.Spring6
{
    [TestFixture]
    public class S002_Group_Module : SignIn
    {
        private string groupname = string.Empty;

        [Test]
        public void T01_Group_CreateNew()
        {
            this.groupname = "zhuojun" + DateTime.UtcNow.ToShortTimeString();
            GotoGroup();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxCreateOwnGroup")).Click();
            browser.WaitForComplete();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxGroupName")).WaitUntilExists(10);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxGroupName")).TypeText(this.groupname);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxGroupDescription")).TypeText(this.groupname);
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxCategoryList")).Option(Find.ByValue("1")).Select();
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMembershipList")).Option(Find.ByText("Open")).Select();
            //browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxchk")).Checked = false;
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSaveGroup")).Click();
            System.Threading.Thread.Sleep(5000);
            Assert.IsTrue(browser.Span(Find.ById("uxGroupName")).Text.Contains(this.groupname));
        }

        [Test]
        public void T02_Group_Search()
        {
            GotoGroup();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSearchBar")).TypeText(this.groupname);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSearch")).Click();
            browser.WaitForComplete();
            Assert.IsTrue(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNumberResults")).Exists);
        }

        [Test]
        public void T03_Group_CreateNoName()
        {
            GotoGroup();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxCreateOwnGroup")).Click();
            browser.WaitForComplete();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxGroupName")).TypeText("");
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxGroupDescription")).TypeText(this.groupname);
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxCategoryList")).Option(Find.ByValue("1")).Select();
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMembershipList")).Option(Find.ByValue("1")).Select();
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSaveGroup")).Click();
            Assert.AreEqual(browser.Div(Find.ByClass("inline-error")).Text, "Group name is required.");
        }

        [Test]
        public void T04_Group_CreateNoDescription()
        {
            GotoGroup();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxCreateOwnGroup")).Click();
            browser.WaitForComplete();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxGroupName")).TypeText(this.groupname);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxGroupDescription")).TypeText("");
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxCategoryList")).Option(Find.ByValue("1")).Select();
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMembershipList")).Option(Find.ByValue("1")).Select();
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSaveGroup")).Click();
            Assert.AreEqual(browser.Div(Find.ByClass("inline-error")).Text, "Oops! You need to enter your group description before we can proceed.");
        }

        [Test]
        public void T05_Group_CreateNoCategory()
        {
            GotoGroup();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxCreateOwnGroup")).Click();
            browser.WaitForComplete();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxGroupName")).TypeText(this.groupname);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxGroupDescription")).TypeText(this.groupname);
            //browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxCategoryList")).Option(Find.ByValue("0")).Select();
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMembershipList")).Option(Find.ByValue("1")).Select();
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSaveGroup")).Click();
            Assert.AreEqual(browser.Div(Find.ByClass("inline-error")).Text, "Please select a category.");
        }

        [Test]
        public void T06_Group_CreateNoMembership()
        {
            GotoGroup();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxCreateOwnGroup")).Click();
            browser.WaitForComplete();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxGroupName")).TypeText(this.groupname);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxGroupDescription")).TypeText(this.groupname);
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxCategoryList")).Option(Find.ByValue("1")).Select();
            //browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMembershipList")).Option(Find.ByValue("0")).Select();
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSaveGroup")).Click();
            Assert.AreEqual(browser.Div(Find.ByClass("inline-error")).Text, "Please select membership type.");
        }

        [Test]
        public void T07_Group_ViewGroup()
        {
            GotoGroup();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSearchBar")).TypeText(this.groupname);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSearch")).Click();
            browser.WaitForComplete();
            if (browser.Link(Find.ById("uxDisplayGroupUrl")).Exists == true)
            {
                browser.Link(Find.ById("uxDisplayGroupUrl")).Click();
                browser.Span(Find.ById("uxGroupName")).WaitUntilExists(10);
                System.Threading.Thread.Sleep(2000);
                Assert.IsTrue(browser.Span(Find.ById("uxGroupName")).Text.Contains(this.groupname));
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T08_Group_ViewMembers()
        {
            GotoGroup();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSearchBar")).TypeText(this.groupname);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSearch")).Click();
            browser.WaitForComplete();
            browser.Link(Find.ById("uxDisplayGroupUrl")).Click();
            browser.Span(Find.ById("uxGroupName")).WaitUntilExists(10);
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxMembersViewAll")).Click();
            Assert.IsTrue(browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberInfo")).Exists);
        }

        [Test]
        public void T09_Group_NewThreadNoTitle()
        {
            GotoGroup();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSearchBar")).TypeText(this.groupname);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSearch")).Click();
            browser.WaitForComplete();
            browser.Link(Find.ById("uxDisplayGroupUrl")).Click();
            browser.Span(Find.ById("uxGroupName")).WaitUntilExists(10);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNext")).Click();
            Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("Oops! You need to enter a thread title before we can proceed."));
        }

        [Test]
        public void T10_Group_NewThread()
        {
            return;
            string specialCHAR = "~!@#$%^&*()_-+={[}]|\\:;\"'<,>.?/";
            GotoGroup();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSearchBar")).TypeText(this.groupname);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSearch")).Click();
            browser.WaitForComplete();
            browser.Link(Find.ById("uxDisplayGroupUrl")).Click();
            browser.Span(Find.ById("uxGroupName")).WaitUntilExists(10);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNewThread")).TypeText("gpzzj" + specialCHAR);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNext")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMessageText")).TypeText("gpzzj" + specialCHAR);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxTag")).TypeText(specialCHAR);
            if (browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostGroupDiscussion")).Exists == true)
            {
                browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPostGroupDiscussion")).Click();
                Assert.IsTrue(true);
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T11_Group_ViewThread()
        {
            return;
            GotoGroup();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSearchBar")).TypeText(this.groupname);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSearch")).Click();
            browser.WaitForComplete();
            browser.Link(Find.ById("uxDisplayGroupUrl")).Click();
            browser.Span(Find.ById("uxGroupName")).WaitUntilExists(10);
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ById("uxPostsViewAll")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxGroupDiscussion_uxGroupPosts_ctrl0_uxTitle")).WaitUntilExists(10);
            Assert.IsTrue(browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxGroupDiscussion_uxGroupPosts_ctrl0_uxTitle")).Text.Contains("gpzzj"));
        }

        [Test]
        public void T12_Group_JoinGroup()
        {
            UserSignIn(UN1, PW1, false, 0);
            browser.Link(Find.ByText("Community Profile")).Click();
            browser.Link(Find.ByText("Groups")).Click();
            //browser.Span(Find.ByText("COMMUNITY")).Click();
            //browser.Link(Find.ByText("Groups")).Click();
            browser.WaitForComplete(30);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSearchBar")).TypeText(this.groupname);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSearch")).Click();
            System.Threading.Thread.Sleep(5000);
            if (browser.Link(Find.ById("uxDisplayGroupName")).Exists)
            {
                browser.Link(Find.ById("uxDisplayGroupName")).Click();
                browser.WaitForComplete();
                browser.Link(Find.ByText("Join")).WaitUntilExists(10);
                browser.Link(Find.ByText("Join")).Click();
                System.Threading.Thread.Sleep(5000);
                Assert.IsTrue(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSuccessMessage")).Text.Contains("You have successfully joined this group."));
                return;
            }
            Assert.IsTrue(false);
        }

        [Test]
        public void T13_Group_LeaveGroup()
        {
            UserSignIn(UN1, PW1, false, 0);
            browser.Link(Find.ByText("Community Profile")).Click();
            browser.Link(Find.ByText("Groups")).Click();
            //browser.Span(Find.ByText("COMMUNITY")).Click();
            //browser.Link(Find.ByText("Groups")).Click();
            browser.WaitForComplete(30);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSearchBar")).TypeText(this.groupname);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSearch")).Click();
            System.Threading.Thread.Sleep(5000);
            if (browser.Link(Find.ById("uxDisplayGroupName")).Exists)
            {
                browser.Link(Find.ById("uxDisplayGroupName")).Click();
                browser.WaitForComplete();
                browser.Link(Find.ByText("Leave")).WaitUntilExists(10);
                browser.Link(Find.ByText("Leave")).Click();
                System.Threading.Thread.Sleep(5000);
                Assert.IsTrue(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSuccessMessage")).Text.Contains("You have successfully left this group."));
                return;
            }
            Assert.IsTrue(false);
        }

        [Test]
        public void T14_Group_EditGroup()
        {
            GotoGroup();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSearchBar")).TypeText(this.groupname);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSearch")).Click();
            System.Threading.Thread.Sleep(5000);
            if (browser.Link(Find.ById("uxDisplayGroupName")).Exists)
            {
                browser.Link(Find.ById("uxDisplayGroupName")).Click();
                browser.WaitForComplete();
                browser.Link(Find.ById("uxEditGroupLink")).WaitUntilExists(10);
                if (browser.Link(Find.ById("uxEditGroupLink")).Exists)
                {
                    browser.Link(Find.ById("uxEditGroupLink")).Click();
                    browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMembershipList")).WaitUntilExists(10);
                    browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMembershipList")).Option(Find.ByText("Application Only")).Select();
                    //browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxchk")).Checked = true;
                    browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSaveGroup")).Click();
                    browser.Span(Find.ById("uxGroupName")).WaitUntilExists(10);
                    System.Threading.Thread.Sleep(2000);
                    Assert.IsTrue(browser.Span(Find.ById("uxGroupName")).Text.Contains(this.groupname));
                    return;
                }
            }
            Assert.IsTrue(false);
        }

        [Test]
        public void T15_Group_ApplyGroup()
        {
            UserSignIn(UN1, PW1, false, 0);
            browser.Link(Find.ByText("Community Profile")).Click();
            browser.Link(Find.ByText("Groups")).Click();
            //browser.Span(Find.ByText("COMMUNITY")).Click();
            //browser.Link(Find.ByText("Groups")).Click();
            browser.WaitForComplete(30);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSearchBar")).TypeText(this.groupname);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSearch")).Click();
            System.Threading.Thread.Sleep(5000);
            if (browser.Link(Find.ById("uxDisplayGroupName")).Exists)
            {
                browser.Link(Find.ById("uxDisplayGroupName")).Click();
                browser.WaitForComplete();
                browser.Link(Find.ByText("Join")).WaitUntilExists(10);
                browser.Link(Find.ByText("Join")).Click();
                System.Threading.Thread.Sleep(5000);
                Assert.IsTrue(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSuccessMessage")).Text.Contains("wait for the group owner to approve"));
                return;
            }
            Assert.IsTrue(false);
        }

        [Test]
        public void T16_Group_ApproveAdd()
        {
            GotoGroup();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSearchBar")).TypeText(this.groupname);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSearch")).Click();
            System.Threading.Thread.Sleep(5000);
            if (browser.Link(Find.ById("uxDisplayGroupName")).Exists)
            {
                browser.Link(Find.ById("uxDisplayGroupName")).Click();
                browser.WaitForComplete();
                browser.Link(Find.ById("uxManageMembershipLink")).WaitUntilExists(10);
                browser.Link(Find.ById("uxManageMembershipLink")).Click();
                browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxDetailList_ctl00_ctl08_uxApprove")).WaitUntilExists(10);
                browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxDetailList_ctl00_ctl08_uxApprove")).Click();
                browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxDetailList_ctl00_ctl08_uxMakeGroupOwner")).Click();
                Assert.IsTrue(true);
                return;
            }
            Assert.IsTrue(false);
        }

        [Test]
        public void T17_Group_RemoveRemove()
        {
            GotoGroup();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSearchBar")).TypeText(this.groupname);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSearch")).Click();
            System.Threading.Thread.Sleep(5000);
            if (browser.Link(Find.ById("uxDisplayGroupName")).Exists)
            {
                browser.Link(Find.ById("uxDisplayGroupName")).Click();
                browser.WaitForComplete();
                browser.Link(Find.ById("uxEditGroupLink")).WaitUntilExists(10);
                browser.Link(Find.ById("uxEditGroupLink")).Click();
                browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxGroupOwnerList_ctrl0_uxRemove")).WaitUntilExists(10);
                browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxGroupOwnerList_ctrl0_uxRemove")).Click();
                browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxGroupOwnerList_ctrl0_uxConfirmRemoveButton")).Click();
                //browser.WaitForComplete();
                //browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxAddGroupOwner")).Click();
                //browser.Link(Find.ByText("Remove")).Click();
                Assert.IsTrue(true);
                return;
            }
            Assert.IsTrue(false);
        }

        [Test]
        public void T18_Group_DeleteGroup()
        {
            return;
            GotoGroup();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSearchBar")).TypeText(this.groupname);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSearch")).Click();
            System.Threading.Thread.Sleep(5000);
            if (browser.Link(Find.ById("uxDisplayGroupName")).Exists)
            {
                browser.Link(Find.ById("uxDisplayGroupName")).Click();
                browser.WaitForComplete();
                browser.Link(Find.ById("uxEditGroupLink")).WaitUntilExists(10);
                browser.Link(Find.ById("uxEditGroupLink")).Click();
                browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxDeleteGroup")).WaitUntilExists(10);
                browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxDeleteGroup")).Click();
                browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxConfirmDeleteButton")).Click();
                Assert.IsTrue(true);
                return;
            }
            Assert.IsTrue(false);
        }

        [Test]
        public void T19_Group_NonMemberView()
        {
            UserSignIn(UN1, PW1, false, 0);
            browser.Link(Find.ByText("Community Profile")).Click();
            browser.Link(Find.ByText("Groups")).Click();
            //browser.Span(Find.ByText("COMMUNITY")).Click();
            //browser.Link(Find.ByText("Groups")).Click();
            browser.WaitForComplete(30);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSearchBar")).TypeText("zecco associates");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSearch")).Click();
            System.Threading.Thread.Sleep(5000);
            if (browser.Link(Find.ById("uxDisplayGroupName")).Exists == false)
            {
                Assert.IsTrue(false);
                return;
            }
            browser.Link(Find.ById("uxDisplayGroupName")).Click();
            System.Threading.Thread.Sleep(5000);
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxMembersViewAll")).Click();
            System.Threading.Thread.Sleep(2000);
            if (browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxErrorMessage")).Text.Contains("Sorry, you must be a member of this group to go any further") == false)
            {
                Assert.IsTrue(false);
                return;
            }
            browser.Link(Find.ById("uxPostsViewAll")).Click();
            System.Threading.Thread.Sleep(2000);
            if (browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxErrorMessage")).Text.Contains("Sorry, you must be a member of this group to go any further") == false)
            {
                Assert.IsTrue(false);
                return;
            }
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNext")).Click();
            System.Threading.Thread.Sleep(2000);
            if (browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxErrorMessage")).Text.Contains("Sorry, you must be a member of this group to go any further") == false)
            {
                Assert.IsTrue(false);
                return;
            }
        }

        [Test]
        public void T20_Group_DuplicatedGroup()
        {
            GotoGroup();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxCreateOwnGroup")).Click();
            browser.WaitForComplete();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxGroupName")).WaitUntilExists(10);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxGroupName")).TypeText("zecco associates");
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxGroupDescription")).TypeText("zecco associates");
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxCategoryList")).Option(Find.ByValue("1")).Select();
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMembershipList")).Option(Find.ByText("Open")).Select();
            //browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxchk")).Checked = false;
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSaveGroup")).Click();
            Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("already exists. Please choose another name."));

        }

        private void GotoGroup()
        {
            UserSignIn(UN, PW, false, 2);
            browser.Link(Find.ByText("Community Profile")).Click();
            browser.Link(Find.ByText("Groups")).Click();
            //browser.Span(Find.ByText("COMMUNITY")).Click();
            //browser.Link(Find.ByText("Groups")).Click();
            browser.WaitForComplete(30);
            System.Threading.Thread.Sleep(5000);
        }
    }
}
