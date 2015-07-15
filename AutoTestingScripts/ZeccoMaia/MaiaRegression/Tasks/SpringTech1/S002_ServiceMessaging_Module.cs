using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks.SpringTech1
{
    [TestFixture]
    public class S002_ServiceMessaging_Module : SignIn
    {
        [Test]
        public void T01_ServiceMessaging_CreateRoadblock()
        {
            this.LoginPortalAdmin();
            browser.Link(Find.ById("ctl00_uxMainContent_uxCreateNewRoadBlock")).Click();
            browser.WaitForComplete();
            Assert.IsTrue(browser.SelectList(Find.ById("ctl00_uxMainContent_uxContentTypeDropdown")).Exists);
            Assert.IsTrue(browser.SelectList(Find.ById("ctl00_uxMainContent_uxContentTypeDropdown")).SelectedItem.Equals("Roadblock"));
        }

        [Test]
        public void T02_ServiceMessaging_EditNotice()
        {
            this.LoginPortalAdmin();
            browser.Link(Find.ById("ctl00_uxMainContent_uxEditImportantNotice")).Click();
            browser.WaitForComplete();
            Assert.IsTrue(browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxActiveNotices_uxContentPartDiv")).Exists);
            browser.Back();
            browser.Back();
        }

        [Test]
        public void T03_ServiceMessaging_AvailableRoadblocks()
        {
            this.LoginPortalAdmin();
            Assert.IsTrue(browser.SelectList(Find.ById("ctl00_uxMainContent_uxAvailableRoadblock")).Exists);
        }

        [Test]
        public void T04_ServiceMessaging_RoadblockImmediately()
        {
            this.LoginPortalAdmin();
            browser.CheckBox(Find.ById("ctl00_uxMainContent_uxImmediately_NewRoadblock")).Checked = true;
            Assert.IsTrue(!browser.TextField(Find.ById("ctl00_uxMainContent_uxStartDate_NewRoadblock")).Enabled);
            Assert.IsTrue(!browser.SelectList(Find.ById("ctl00_uxMainContent_uxStartTimeHour_NewRoadblock")).Enabled);
            Assert.IsTrue(!browser.SelectList(Find.ById("ctl00_uxMainContent_uxStartTimeMinute_NewRoadblock")).Enabled);
        }

        [Test]
        public void T05_ServiceMessaging_RoadblockUntilRemoved()
        {
            this.LoginPortalAdmin();
            browser.CheckBox(Find.ById("ctl00_uxMainContent_uxUntilRemoved_NewRoadblock")).Checked = true;
            Assert.IsTrue(!browser.TextField(Find.ById("ctl00_uxMainContent_uxEndDate_NewRoadblock")).Enabled);
            Assert.IsTrue(!browser.SelectList(Find.ById("ctl00_uxMainContent_uxEndTimeHour_NewRoadblock")).Enabled);
            Assert.IsTrue(!browser.SelectList(Find.ById("ctl00_uxMainContent_uxEndTimeMimute_NewRoadblock")).Enabled);
        }

        [Test]
        public void T06_ServiceMessaging_Audience()
        {
            this.LoginPortalAdmin();
            Assert.IsTrue(browser.CheckBox(Find.ById("ctl00_uxMainContent_uxAudience_NewRoadblock_0")).Exists);
            Assert.IsTrue(browser.CheckBox(Find.ById("ctl00_uxMainContent_uxAudience_NewRoadblock_1")).Exists);
            Assert.IsTrue(browser.CheckBox(Find.ById("ctl00_uxMainContent_uxAudience_NewNotice_0")).Exists);
            Assert.IsTrue(browser.CheckBox(Find.ById("ctl00_uxMainContent_uxAudience_NewNotice_1")).Exists);
        }

        [Test]
        public void T07_ServiceMessaging_NoticeImmediately()
        {
            this.LoginPortalAdmin();
            browser.CheckBox(Find.ById("ctl00_uxMainContent_uxImmediately_NewNotice")).Checked = true;
            Assert.IsTrue(!browser.TextField(Find.ById("ctl00_uxMainContent_uxStartDate_NewNotice")).Enabled);
            Assert.IsTrue(!browser.SelectList(Find.ById("ctl00_uxMainContent_uxStartTimeHour_NewNotice")).Enabled);
            Assert.IsTrue(!browser.SelectList(Find.ById("ctl00_uxMainContent_uxStartTimeMinute_NewNotice")).Enabled);
        }

        [Test]
        public void T08_ServiceMessaging_NoticeUntilRemoved()
        {
            this.LoginPortalAdmin();
            browser.CheckBox(Find.ById("ctl00_uxMainContent_uxUntilRemoved_NewNotice")).Checked = true;
            Assert.IsTrue(!browser.TextField(Find.ById("ctl00_uxMainContent_uxEndDate_NewNotice")).Enabled);
            Assert.IsTrue(!browser.SelectList(Find.ById("ctl00_uxMainContent_uxEndTimeHour_NewNotice")).Enabled);
            Assert.IsTrue(!browser.SelectList(Find.ById("ctl00_uxMainContent_uxEndTimeMimute_NewNotice")).Enabled);
        }

        [Test]
        public void T09_ServiceMessaging_RoadblockCreation_Type()
        {
            this.LoginPortalAdmin();
            browser.Link(Find.ById("ctl00_uxMainContent_uxCreateNewRoadBlock")).Click();
            browser.WaitForComplete();
            Assert.IsTrue(browser.SelectList(Find.ById("ctl00_uxMainContent_uxContentTypeDropdown")).Exists);
            Assert.IsTrue(browser.SelectList(Find.ById("ctl00_uxMainContent_uxContentTypeDropdown")).SelectedItem.Equals("Roadblock"));
        }

        [Test]
        public void T10_ServiceMessaging_RoadblockCreation_PageUrl()
        {
            this.LoginPortalAdmin();
            browser.Link(Find.ById("ctl00_uxMainContent_uxCreateNewRoadBlock")).Click();
            browser.WaitForComplete();
            Assert.IsTrue(browser.TextField(Find.ById("ctl00_uxMainContent_uxPageName")).Exists);
        }

        [Test]
        public void T11_ServiceMessaging_RoadblockCreation_Instructions()
        {
            this.LoginPortalAdmin();
            browser.Link(Find.ById("ctl00_uxMainContent_uxCreateNewRoadBlock")).Click();
            browser.WaitForComplete();
            Assert.IsTrue(browser.TextField(Find.ById("ctl00_uxMainContent_uxFileExtension")).Exists);
            Assert.IsTrue(browser.TextField(Find.ById("ctl00_uxMainContent_uxFileExtension")).Text.Equals(".aspx - Separate words with a dash, all lowercase"));
        }

        [Test]
        public void T12_ServiceMessaging_RoadblockCreation_BrowserTitle()
        {
            this.LoginPortalAdmin();
            browser.Link(Find.ById("ctl00_uxMainContent_uxCreateNewRoadBlock")).Click();
            browser.WaitForComplete();
            Assert.IsTrue(browser.TextField(Find.ById("ctl00_uxMainContent_uxBrowserTitle")).Exists);
        }

        [Test]
        public void T13_ServiceMessaging_RoadblockCreation_Logo()
        {
            this.LoginPortalAdmin();
            browser.Link(Find.ById("ctl00_uxMainContent_uxCreateNewRoadBlock")).Click();
            browser.WaitForComplete();
            Assert.IsTrue(browser.SelectList(Find.ById("ctl00_uxMainContent_uxPageLogoType")).Exists);
        }

        [Test]
        public void T14_ServiceMessaging_RoadblockCreation_Save()
        {
            this.LoginPortalAdmin();
            browser.Link(Find.ById("ctl00_uxMainContent_uxCreateNewRoadBlock")).Click();
            browser.WaitForComplete();
            Assert.IsTrue(browser.Button(Find.ById("ctl00_uxMainContent_uxSavePageContentButton")).Exists);
        }

        [Test]
        public void T15_ServiceMessaging_RoadblockCreation_Cancel()
        {
            this.LoginPortalAdmin();
            browser.Link(Find.ById("ctl00_uxMainContent_uxCreateNewRoadBlock")).Click();
            browser.WaitForComplete();
            Assert.IsTrue(browser.Button(Find.ById("ctl00_uxMainContent_uxCancelButton")).Exists);
        }

        [Test]
        public void T16_ServiceMessaging_RoadblockCreation()
        {
            this.LoginPortalAdmin();
            browser.Link(Find.ById("ctl00_uxMainContent_uxCreateNewRoadBlock")).Click();
            browser.WaitForComplete();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxPageName")).TypeText("AutoTestRB" + Date);
            browser.TextField(Find.ById("ctl00_uxMainContent_uxBrowserTitle")).TypeText("AutoTestRB" + Date);
            browser.Button(Find.ById("ctl00_uxMainContent_uxSavePageContentButton")).Click();

            browser.Button(Find.ById("ctl00_uxMainContent_uxCancelButton")).WaitUntilExists(20);
            browser.TextField(Find.ById("ctl00_uxMainContent_uxRevisionBody")).TypeText("AutoTestRB" + Date);
            browser.TextField(Find.ById("ctl00_uxMainContent_uxRevisionComments")).TypeText("AutoTestRB" + Date);
            browser.Button(Find.ById("ctl00_uxMainContent_uxSaveButton")).Click();

            browser.Button(Find.ById("ctl00_uxMainContent_uxAndNewRevision")).WaitUntilExists(20);
            browser.Link(Find.ById("ctl00_uxMainContent_uxContentRevisionList_ctl00_ctl04_uxQAPublishedButton")).Click();

            Assert.IsTrue(browser.CheckBox(Find.ById("ctl00_uxMainContent_uxContentRevisionList_ctl00_ctl04_uxQAPublishedCheckBox")).Checked);
        }

        [Test]
        public void T17_ServiceMessaging_SetRoadblock()
        {
            this.LoginPortalAdmin();
            browser.GoTo(AdminUrl + "/PortalAdmin/ServiceMessages.aspx?cpistest=true");
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxAvailableRoadblock")).Option(Find.ByText("/notices/AutoTestRB" + Date + ".aspx")).Select();
            browser.CheckBox(Find.ById("ctl00_uxMainContent_uxImmediately_NewRoadblock")).Checked = true;
            browser.TextField(Find.ById("ctl00_uxMainContent_uxEndDate_NewRoadblock")).TypeText(Date2);
            //members
            browser.CheckBox(Find.ById("ctl00_uxMainContent_uxAudience_NewRoadblock_1")).Checked = true;
            browser.Button(Find.ById("ctl00_uxMainContent_uxSetNewRoadblock")).Click();
            System.Threading.Thread.Sleep(5000);
            int count = browser.Table(Find.ById("ctl00_uxMainContent_uxActiveRoadblockList_ctl00")).TableBodies[0].TableRows.Count;
            string active = browser.Table(Find.ById("ctl00_uxMainContent_uxActiveRoadblockList_ctl00")).TableBodies[0].TableRows[count - 1].TableCells[0].Text;
            Assert.AreEqual(active.Trim(), "AutoTestRB" + Date);
        }

        [Test]
        public void T18_ServiceMessaging_SetNotice()
        {
            this.LoginPortalAdmin();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxNoticeText")).TypeText("AutoTestN" + Date);
            browser.CheckBox(Find.ById("ctl00_uxMainContent_uxImmediately_NewNotice")).Checked = true;
            browser.TextField(Find.ById("ctl00_uxMainContent_uxEndDate_NewNotice")).TypeText(Date2);
            //customers
            browser.CheckBox(Find.ById("ctl00_uxMainContent_uxAudience_NewNotice_0")).Checked = true;
            browser.Button(Find.ById("ctl00_uxMainContent_uxSetNewNotice")).Click();
            System.Threading.Thread.Sleep(5000);
            int count = browser.Table(Find.ById("ctl00_uxMainContent_uxActiveRoadblockList_ctl00")).TableBodies[0].TableRows.Count;
            string active = browser.Table(Find.ById("ctl00_uxMainContent_uxActiveRoadblockList_ctl00")).TableBodies[0].TableRows[count - 1].TableCells[0].Text;
            Assert.AreEqual(active.Trim(), "AutoTestN" + Date);
        }

        [Test]
        public void T19_ServiceMessaging_GetRoadblock()
        {
            if (browser.Link(Find.ById("ctl00_uxLoginView_uxLoginStatus")).Exists)
            {
                browser.Span(Find.ById("ctl00_uxSiteMapBreadCrumb")).Link(Find.ByText("Portal Admin")).Click();
                browser.Link(Find.ById("ctl00_uxLoginView_uxLoginStatus")).Click();
            }
            browser.GoTo(URL + "?cpistest=true");
            browser.WaitForComplete();

            UserSignIn(UN2, PW2, false, 2);
            Assert.IsTrue(browser.Link(Find.ById("uxRemindLater")).Exists);
            Assert.IsTrue(browser.Button(Find.ById("uxContinue")).Exists);
            Assert.IsTrue(browser.Div(Find.ById("uxRoadblockContent_uxContentPartDiv")).Text.Contains("AutoTestRB" + Date));
        }

        [Test]
        public void T20_ServiceMessaging_GetNotice()
        {
            UserSignIn(UN, PW, false, 2);
            Assert.IsTrue(browser.Div(Find.ByClass("notice-container")).Div(Find.ById("uxShortVersion")).Span(Find.ByClass("tagtext-wordwrap")).Text.Contains("AutoTestN" + Date));
        }

        private void LoginPortalAdmin()
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
            browser.Div(Find.ById("ctl00_uxMainContent_uxServiceMessages")).Link(Find.ByText("Service Messages Management")).Click();
            browser.WaitForComplete();
        }
    }
}
