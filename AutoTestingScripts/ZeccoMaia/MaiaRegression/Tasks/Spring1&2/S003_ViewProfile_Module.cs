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
    public class S003_ViewProfile_Module : ViewProfile
    {
        [Test]
        public void T01_ViewOwnProfile()
        {
            NavigateToProfile(UN, PW);
            Assert.AreEqual(UN, browser.Span(Find.ById("uxMemberDisplayName")).Text);
        }

        [Test]
        public void T02_NavigateToOwnProfilePageFromScreenName()
        {
            NavigateToProfile(UN, PW);
            browser.Span(Find.ByText(UN)).Click();
            browser.WaitForComplete();
            browser.Link(Find.ByText("Edit profile and picture")).WaitUntilExists(10);
            //Click on your screenname at top-right of page
            if (browser.Link(Find.ByText("Edit profile and picture")).Exists == true)
            {
                Assert.IsTrue(true);
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T03_NavigateToOwnProfilePageFromPicture()
        {
            NavigateToProfile(UN, PW);
            browser.Image("uxLogoPic").Click();
            browser.WaitForComplete();
            browser.Link(Find.ByText("Edit profile and picture")).WaitUntilExists(10);
            //Click on your picture at top-right of page
            if (browser.Link(Find.ByText("Edit profile and picture")).Exists == true)
            {
                Assert.IsTrue(true);
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T04_ProfileControlsPersonalInvestorProfile()
        {
            NavigateToProfile(UN, PW);
            browser.Link(Find.ById("uxInforViewAll")).Click();
            Assert.IsTrue(browser.ContainsText("Product Manager"));
            browser.Link(Find.ById("uxInfor2ViewAll")).Click();
            Assert.IsTrue(browser.ContainsText("I like emerging markets"));
        }

        [Test]
        public void T05_ProfileControlsSomeoneProfile()
        {
            NavigateToProfile(UN, PW);
            //if (browser.Image(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxMemberConnections_uxConnectionsList_ctl00_uxConnectionImage")).Exists == true)
            //{
            //    browser.Image(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxMemberConnections_uxConnectionsList_ctl00_uxConnectionImage")).Click();
            //}
            browser.Image(Find.ById("uxConnectionImage")).Click();
            browser.Link(Find.ById("uxSendMessage")).WaitUntilExists(120);
            Assert.IsTrue(browser.Link(Find.ById("uxSendMessage")).Exists);
            Assert.IsTrue(browser.Link(Find.ById("uxRemoveFavorite")).Exists);
        }

        [Test]
        public void T06_ProfileControlsPortfolioe()
        {
            NavigateToProfile(UN, PW);
            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxConnectionsList")).Link(Find.ById("uxConnectionLink")).Click();

            browser.WaitForComplete(10);
            if (browser.Div(Find.ById("uxMemberTradeData")).Exists == true)
            {
                Assert.IsTrue(true);
            }
            else
            {
                Assert.IsTrue(false);
            }
        }
    }
}
