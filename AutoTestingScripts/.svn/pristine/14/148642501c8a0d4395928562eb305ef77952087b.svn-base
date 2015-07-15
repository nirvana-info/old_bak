using System.Text;
using WatiN.Core;
using NUnit.Framework;
using MaiaRegression.Appobjects;
using MaiaRegression.Appobjects.App01_HomePage;
using System.Threading;

namespace MaiaRegression.Tasks.Spring1_2
{
    [TestFixture]
    public class S008_Connections_Module : ViewProfile
    {
        [Test]
        public void T01_ViewConnectionsOnProfile()
        {
            NavigateToProfile(UN, PW);
            Assert.IsTrue(browser.Link(Find.ById("uxConnectionsViewAllLink")).Exists);
        }

        [Test]
        public void T02_ConnectionsOnProfile_Controls()
        {
            NavigateToProfile(UN, PW);
            browser.Link(Find.ById("uxConnectionsViewAllLink")).WaitUntilExists(20);
            browser.Link(Find.ById("uxConnectionsViewAllLink")).Click();
            browser.Div(Find.ById("MainColumn")).Div(Find.ById("MemberName")).WaitUntilExists(20);
            if ((browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxConnectionsTabs")).Link(Find.ByText("Following")).Exists == true) &&
                (browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxConnectionsTabs")).Link(Find.ByText("Followers")).Exists == true) &&
                (browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxConnectionsTabs")).Link(Find.ByText("Groups")).Exists == true))
            {
                Assert.IsTrue(true);
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T03_Connections_OtherProfile()
        {
            NavigateToProfile(UN, PW);
            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxConnectionsInfor")).WaitUntilExists(20);
            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxConnectionsInfor")).Link(Find.ById("uxConnectionsViewAllLink")).Click();
            browser.Div("MainColumn").Div(Find.ByClass("float-left gutter trail")).WaitUntilExists(20);

            //browser.Div("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxConnectionPages").Table("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberConnectionsList_ctl00");
            string othername1 = browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberConnectionsList_ctl00_ctl04_uxConnectionDisplayName")).Text.Trim();
            //Number of people you're following - links to full connections page, following tab
            browser.Image(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberConnectionsList_ctl00_ctl04_uxDisplayMemberPicture")).Click();
            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberProfile")).Span(Find.ById("uxMemberDisplayName")).WaitUntilExists(20);
            string othername2 = browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberProfile")).Span(Find.ById("uxMemberDisplayName")).Text.Trim();
            Assert.AreEqual(othername1, othername2);
        }

        [Test]
        public void T04_Connections_OtherProfile_Controls()
        {
            NavigateToProfile(UN, PW);
            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxConnectionsInfor")).WaitUntilExists(20);
            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxConnectionsInfor")).Link(Find.ById("uxConnectionsViewAllLink")).Click();
            browser.Div("MainColumn").Div(Find.ByClass("float-left gutter trail")).WaitUntilExists(20);

            //browser.Div("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxConnectionPages").Table("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberConnectionsList_ctl00");
            //Number of people you're following - links to full connections page, following tab
            browser.Image(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberConnectionsList_ctl00_ctl04_uxDisplayMemberPicture")).Click();
            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberProfile")).Span(Find.ById("uxMemberDisplayName")).WaitUntilExists(20);
            Assert.IsTrue(browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxConnectionsInfor")).Link(Find.ById("uxConnectionsViewAllLink")).Exists);
        }

        [Test]
        public void T05_Connections_ViewMainConnectionsPage()
        {
            NavigateToConnection(browser);
            browser.Link(Find.ById("uxConnectionsViewAllLink")).WaitUntilExists(20);
            browser.Link(Find.ById("uxConnectionsViewAllLink")).Click();
            browser.Div(Find.ById("MainColumn")).Div(Find.ById("MemberName")).WaitUntilExists(20);
            Assert.IsTrue(browser.Div(Find.ById("MainColumn")).Div(Find.ById("MemberName")).Text.Contains("Connections"));
        }

        [Test]
        public void T06_Connections_FollowLinks()
        {
            NavigateToConnection(browser);
            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxConnectionsInfor")).WaitUntilExists(20);
            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxConnectionsInfor")).Link(Find.ById("uxConnectionsViewAllLink")).Click();
            Assert.IsTrue(browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberConnectionsList_ctl00_ctl04_uxRemoveFavoriteLink")).Exists);
        }

        [Test]
        public void T07_ViewOthersMainConnectionsPage_FollowLinks()
        {
            NavigateToConnection(browser);
            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_SideNavigation1_uxSideNavigation")).Link(Find.ByText("Members")).Click();
            browser.WaitForComplete();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxScreenName")).TypeText("jaylen");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSimpleSearch")).Click();
            System.Threading.Thread.Sleep(15000);
            browser.Image(Find.ById("uxMemberProfilePicture")).Click();
            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxConnectionsInfor")).WaitUntilExists(20);
            if (browser.Link(Find.ById("uxAddFavorite")).Exists == false)
            {
                Assert.IsTrue(false);
            }
            browser.Link(Find.ById("uxAddFavorite")).Click();
            if (browser.Link(Find.ById("uxRemoveFavorite")).Exists == false)
            {
                Assert.IsTrue(false);
            }
            browser.Link(Find.ById("uxRemoveFavorite")).Click();
            if (browser.Link(Find.ById("uxAddFavorite")).Exists == false)
            {
                Assert.IsTrue(false);
            }
        }
    }
}
