using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;
using MaiaRegression.Appobjects;
using System.Threading;

namespace MaiaRegression.Tasks.Spring1_2
{
    [TestFixture]
    public class S005_ShoutBox_Module : ViewProfile
    {
        [Test]
        public void T01_ShoutBoxSelfProfile_LeavePostToOwnShoutbox()
        {
            NavigateToProfile(UN, PW);
            browser.TextField("ctl00_ctl00_uxMainContent_uxRightColumn_uxShoutText").TypeText("ShoutBoxTest" + Date);
            browser.Button("ctl00_ctl00_uxMainContent_uxRightColumn_uxSubmitShout").Click();
            Thread.Sleep(3000);
            Assert.IsTrue(browser.Div(Find.ByClass("shout-body")).Text.Contains("ShoutBoxTest" + Date));
        }

        [Test]
        public void T02_ShoutBoxSelfProfile_ShoutboxControlsHide()
        {
            NavigateToProfile(UN, PW);
            browser.WaitForComplete();
            string tx1 = browser.Div(Find.ByClass("shout-body")).Text;
            browser.Link(Find.ByClass("Shouts-hide")).Click();
            //browser.Link("ctl00_ctl00_uxMainContent_uxRightColumn_uxMemberShoutBox_uxShoutsList_ctl00_uxShoutPostHideLink").Click();
            browser.Div(Find.ByClass("radtooltip_Portal visiblecallout")).Link("uxHideShout").Click();
            Assert.IsFalse(browser.Div(Find.ByClass("radtooltip_Portal visiblecallout")).Link("uxHideShout").Exists);
            Assert.AreNotSame(tx1, browser.Div(Find.ByClass("shout-body")).Text);
        }

        [Test]
        public void T03_ShoutBoxSelfProfile_ShoutboxControlsViewAll()
        {
            NavigateToProfile(UN, PW);
            browser.Div(Find.ById("Sidebar")).Link(Find.ById("uxShoutBoxHeaderViewAllLink")).WaitUntilExists(10);
            browser.Div(Find.ById("Sidebar")).Link(Find.ById("uxShoutBoxHeaderViewAllLink")).Click();
            string msg = browser.Span("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberDisplayName").Text;
            Assert.IsTrue((msg.Contains("Shoutbox") && msg.Contains("Trade Notes")));
        }

        [Test]
        public void T04_ShoutBoxSelfMain_TabViews()
        {
            NavigateToShoutBoxSelfMain();
            browser.Span(Find.ByText("Following")).WaitUntilExists(20);
            if (browser.Span(Find.ByText("Following")).Exists == true)
            {
                browser.Span(Find.ByText("Following")).Click();
            }
            else
            {
                Assert.IsTrue(false);
            }
            if (browser.Span(Find.ByText("All ZeccoShare")).Exists == true)
            {
                browser.Span(Find.ByText("All ZeccoShare")).Click();
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T05_ShoutBoxSelfMain_LeavePostToOwnShoutbox()
        {
            NavigateToShoutBoxSelfMain();
            browser.TextField("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxShoutSubmitter_uxShoutTextBox").TypeText("SelfMain ShoutBox Test" + Date);
            browser.Button("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxShoutSubmitter_uxSubmitShoutButton").Click();

            Assert.IsTrue(browser.TableRow("ctl00_ctl00_uxMainContent_uxMiddleColumn_AnnotationDisplayRepeater_ctl00__0").Div(Find.ByClass("annotation")).Div(Find.ByClass("annotation-name-display")).Text.Contains("SelfMain ShoutBox Test"));
        }

        [Test]
        public void T06_ShoutBoxSelfMain_LeavePostToOwnShoutboxHide()
        {
            NavigateToShoutBoxSelfMain();
            string OldText = browser.TableRow("ctl00_ctl00_uxMainContent_uxMiddleColumn_AnnotationDisplayRepeater_ctl00__0").Div(Find.ByClass("annotation")).Div(Find.ByClass("annotation-name-display")).Text;
            //remove the first shout
            browser.Link("ctl00_ctl00_uxMainContent_uxMiddleColumn_AnnotationDisplayRepeater_ctl00_ctl04_uxHideLink").Click();
            Thread.Sleep(5000);
            
            Assert.IsFalse(browser.TableRow("ctl00_ctl00_uxMainContent_uxMiddleColumn_AnnotationDisplayRepeater_ctl00__0").Div(Find.ByClass("annotation")).Div(Find.ByText(OldText)).Exists);
        }

        [Test]
        public void T07_ShoutBoxDisplay_SelfMain_Paging()
        {
            NavigateToShoutBoxSelfMain();
            //browser.Div("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxEquity").Table(Find.ByClass("PagerContainerTable")).TableCells[4].Link(Find.ByClass("PagerHyperlinkStyle")).Click();
            //Thread.Sleep(3000);
            //Assert.IsTrue(browser.Div("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxEquity").Table(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxEquityPositions_ctl00")).TableCells.Count >= 0);
            browser.Table(Find.ByClass("PagerContainerTable")).TableCell(Find.ByClass("PagerOtherPageCells")).Link(Find.ByText("2")).Click();
            Thread.Sleep(2000);
            Assert.IsTrue(browser.Table(Find.ByClass("PagerContainerTable")).TableCell(Find.ByClass("PagerOtherPageCells")).Link(Find.ByText("1")).Exists);
        }

        [Test]
        public void T08_ShoutBoxDisplay_PostToOthers()
        {
            NavigateToProfile(UN, PW);
            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_SideNavigation1_uxSideNavigation")).Link(Find.ByText("Members")).Click();
            Thread.Sleep(2000);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxScreenName")).TypeText("percyzhao1");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSimpleSearch")).Click();
            Thread.Sleep(2000);
            browser.Image(Find.ById("uxMemberProfilePicture")).Click();
            //browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxConnectionsInfor")).WaitUntilExists(20);
            //browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxConnectionsInfor")).Link(Find.ById("uxConnectionsViewAllLink")).Click();
            //browser.Link("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberConnectionsList_ctl00_ctl04_uxConnectionDisplayName").WaitUntilExists(10);
            //string membername = browser.Link("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberConnectionsList_ctl00_ctl04_uxConnectionDisplayName").Text.Trim();
            //browser.Link("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberConnectionsList_ctl00_ctl04_uxConnectionDisplayName").Click();
            //browser.Span(Find.ByText(membername)).WaitUntilExists(10);
            browser.TextField("ctl00_ctl00_uxMainContent_uxRightColumn_uxShoutText").TypeText("MemberTest" + Date);
            browser.Button("ctl00_ctl00_uxMainContent_uxRightColumn_uxSubmitShout").Click();
            Thread.Sleep(2000);
            if (browser.Div("ctl00_ctl00_uxMainContent_uxRightColumn_uxShoutsList").TableRows[0].Div(Find.ByClass("shout-body")).Text.Contains("MemberTest") == true)
            {
                Assert.IsTrue(true);
            }
            else
            {
                Assert.IsTrue(false);
            }
            //Assert.IsTrue(browser.Div("ctl00_ctl00_uxMainContent_uxRightColumn_uxShoutsList").Div(Find.ByClass("shout-body")).Text.Contains("MemberTest"));
        }

        [Test]
        public void T09_ShoutBoxDisplay_PostToOthersHide()
        {
            NavigateToProfile(UN, PW);
            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_SideNavigation1_uxSideNavigation")).Link(Find.ByText("Members")).Click();
            Thread.Sleep(2000);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxScreenName")).TypeText("percyzhao1");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSimpleSearch")).Click();
            Thread.Sleep(2000);
            browser.Image(Find.ById("uxMemberProfilePicture")).Click();
            //browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxConnectionsInfor")).WaitUntilExists(20);
            //browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxConnectionsInfor")).Link(Find.ById("uxConnectionsViewAllLink")).Click();
            //browser.Link("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberConnectionsList_ctl00_ctl04_uxConnectionDisplayName").WaitUntilExists(10);
            //string membername = browser.Link("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberConnectionsList_ctl00_ctl04_uxConnectionDisplayName").Text.Trim();
            //browser.Link("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberConnectionsList_ctl00_ctl04_uxConnectionDisplayName").Click();
            //browser.Span(Find.ByText(membername)).WaitUntilExists(10);
            browser.TextField("ctl00_ctl00_uxMainContent_uxRightColumn_uxShoutText").TypeText("MemberTest" + Date);
            browser.Button("ctl00_ctl00_uxMainContent_uxRightColumn_uxSubmitShout").Click();
            Thread.Sleep(2000);
            if (browser.Div("ctl00_ctl00_uxMainContent_uxRightColumn_uxShoutsList").TableRows[0].Div(Find.ByClass("shout-caption")).Link(Find.ByClass("Shouts-hide")).Exists == true)
            {
                browser.Div("ctl00_ctl00_uxMainContent_uxRightColumn_uxShoutsList").TableRows[0].Div(Find.ByClass("shout-caption")).Link(Find.ByClass("Shouts-hide")).Click();
                Assert.IsTrue(true);
                //browser.Div(Find.ByClass("radtooltip_Portal visiblecallout")).Link("uxHideShout").Click();
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T10_ShoutBoxOtherProfile_ShoutboxControlsHide()
        {
            NavigateToProfile(UN3, PW3);
            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxConnectionsInfor")).WaitUntilExists(20);
            if (browser.Div("ctl00_ctl00_uxMainContent_uxRightColumn_uxShoutsList").TableRows[0].Div(Find.ByClass("shout-caption")).Link(Find.ByClass("Shouts-hide")).Exists == true)
            {
                browser.Div("ctl00_ctl00_uxMainContent_uxRightColumn_uxShoutsList").TableRows[0].Div(Find.ByClass("shout-caption")).Link(Find.ByClass("Shouts-hide")).Click();
                Assert.IsTrue(true);
                browser.Div(Find.ByClass("radtooltip_Portal visiblecallout")).Link("uxHideShout").Click();
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T11_ShoutBoxSelfProfile_EmptyPost()
        {
            NavigateToProfile(UN, PW);
            browser.TextField("ctl00_ctl00_uxMainContent_uxRightColumn_uxShoutText").TypeText("");
            browser.Button("ctl00_ctl00_uxMainContent_uxRightColumn_uxSubmitShout").Click();
            Thread.Sleep(3000);
            Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Text.Contains("We're sorry, please try again with more than 1 characters."));
        }
    }
}
