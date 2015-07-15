using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;
using MaiaRegression.Appobjects;

namespace MaiaRegression.Tasks.Spring1_2
{
    [TestFixture]
    public class S004_EditProfile_Module : ViewProfile
    {
        [Test]
        public void T01_EditProfile_SettingsLinks()
        {
            //  if (browser.Div("MainColumn").Div(Find.ByClass("float-left gutter")).Text.Contains("Settings Overview ") == false)
            //{
            

            UserSignIn(UN, PW, false, 0);
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
            Assert.IsTrue(browser.ContainsText("ZeccoShare Community"));
            //}
            // Clicking each of the links in the "Community Settings" section directs to the appropriate tab in the community settings page.
            browser.Link(Find.ByText("Edit your profile")).Click();
            Assert.IsTrue(browser.Div("EditMemberProfile").Text.Contains("Edit Your Community Profile"));
            browser.Back();

            browser.Link(Find.ByText("Manage activity feed")).Click();
            Assert.IsTrue(browser.Div("EditMemberProfile").Text.Contains("Edit Your Community Profile"));
            browser.Back();

            browser.Link(Find.ByText("Share your performance")).Click();
            Assert.IsTrue(browser.Div("EditMemberProfile").Text.Contains("Edit Your Community Profile"));
            browser.Back();

            browser.Link(Find.ByText("Set up personal blog")).Click();
            Assert.IsTrue(browser.Div("EditMemberProfile").Text.Contains("Edit Your Community Profile"));
            browser.Back();
        }

        [Test]
        public void T02_EditProfile_SettingsTabs()
        {
            NavigateToMemberProfileSettings(UN, PW);
            browser.Span(Find.ByText("Basics")).Click();
            Assert.IsTrue(browser.ContainsText("Basics"));

            browser.Span(Find.ByText("Data Sharing")).Click();
            Assert.IsTrue(browser.ContainsText("Become more credible to your fellow ZeccoShare community members"));

            browser.Span(Find.ByText("Activity Feed")).Click();
            Assert.IsTrue(browser.ContainsText("What would you like to appear in the activity feed on your profile?"));

            browser.Span(Find.ByText("Personal Profile")).Click();
            Assert.IsTrue(browser.ContainsText("Gender"));

            browser.Span(Find.ByText("Investor Profile")).Click();
            Assert.IsTrue(browser.ContainsText("Investment Discipline"));

            browser.Span(Find.ByText("Personal Blog")).Click();
            Assert.IsTrue(browser.ContainsText("Manage Your Blog") || browser.ContainsText("personal blog"));
        }

        [Test]
        public void T03_EditProfile_BasicInformation()
        {
            NavigateToMemberProfileSettings(UN, PW);

            //Assert.AreEqual("True",browser.TextField("ctl00_ctl00_uxMainContent_uxMainColumn_uxCommunityScreenName").GetAttributeValue("readOnly"));
            //Community Screen Name is only editable once

            browser.Link(Find.ByText("edit")).Click();
            //Assert.IsTrue(browser.Div("EditMemberProfile").Div(Find.ByClass("emphasis")).Text.Contains("Privacy Settings"));
            //Link under "Shared Accounts" directs to Sharing Settings tab

            browser.Link(Find.ById("uxAccountCenter")).Click();
            browser.Link(Find.ByText("Edit your profile")).Click();
            Assert.IsTrue(browser.SelectList("ctl00_ctl00_uxMainContent_uxMainColumn_uxInvestingStyle").Exists);
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxInvestingStyle")).Option(Find.ByValue("1")).Select();
            //Assert.IsTrue(browser.SelectList("ctl00_ctl00_uxMainContent_uxMainColumn_uxInvestingStyle").Exists);
            // Can choose different Investing Style, Investing Experience
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxFavoriteStock")).TypeText("I really like RIMM and AAPL, but not so much lately.  In general, I like tech stocks because I follow the industry so closely");
            browser.Button("ctl00_ctl00_uxMainContent_uxMainColumn_uxSaveBasicInfo").Click();
            Assert.IsTrue(browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSuccessMessageBasicInfo")).Text.Contains("Saved successfully"));
            //Click save -> "Saved Successfully" appears
        }

        [Test]
        public void T04_EditProfile_UpdatePicture_InvalidFormat()
        {
            NavigateToMemberProfileSettings(UN, PW);
            browser.Div("ctl00_ctl00_uxMainContent_uxMainColumn_uxRadUploadPicture").Span(Find.ByClass("ruFileWrap ruStyled")).WaitUntilExists(10);
            browser.Div("ctl00_ctl00_uxMainContent_uxMainColumn_uxRadUploadPicture").Span(Find.ByClass("ruFileWrap ruStyled")).TextField(Find.ByClass("ruFakeInput")).MouseEnter();
            browser.Div("ctl00_ctl00_uxMainContent_uxMainColumn_uxRadUploadPicture").Span(Find.ByClass("ruFileWrap ruStyled")).TextField(Find.ByClass("ruFakeInput")).TypeTextAction.TypeText(@"c:\tonyleachsf1.jpg");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxUploadPicture")).Click();
            //browser.Div("ctl00_ctl00_uxMainContent_uxMainColumn_uxRadUploadPicture").Span(Find.ByClass("ruFileWrap ruStyled")).TextField(Find.ByClass("ruFakeInput")).MouseDown();

            //browser.Button("ctl00_ctl00_uxMainContent_uxMainColumn_uxUploadPicture").Click();
            ////Find a non-picture file on your computer and click OK

            //Assert.IsTrue(browser.Span("ctl00_ctl00_uxMainContent_uxMainColumn_uxUploadPictureErrorMessage").Text.Contains("We were unable to update your member picture"));
            ////Picture should not upload successfully
        }
        
        [Test]
        public void T05_EditProfile_Account_Sharing()
        {
            NavigateToMemberProfileSettings(UN, PW);
            browser.Link(Find.ByText("edit")).Click();
            //browser.TextField("ctl00_ctl00_uxMainContent_uxMainColumn_uxZeccoTradingAccount_ctl02_uxDisplayBlock").TypeText("XXXX" + Date);
            //browser.TextField("ctl00_ctl00_uxMainContent_uxMainColumn_uxZeccoTradingAccount_ctl02_uxDisplayName").TypeText("XXXX" + Date);
            browser.Button("ctl00_ctl00_uxMainContent_uxMainColumn_uxSaveAccountSharing").Click();
            Assert.IsTrue(browser.Span("ctl00_ctl00_uxMainContent_uxMainColumn_uxSuccessMessageAccountSharing").Text.Contains("Saved successfully!"));
        }

        [Test]
        public void T06_EditProfile_ActivityFeedSettings()
        {
            NavigateToMemberProfileSettings(UN, PW);
            browser.GoTo(targetHost + "/editmemberprofile.aspx?view=ActivityFeed#");
            browser.Span(Find.ByText("Activity Feed")).Click();
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSaveActivityFeed")).Click();

            Assert.IsTrue(browser.Span("ctl00_ctl00_uxMainContent_uxMainColumn_uxSuccessMessageActivityFeed").Text.Contains("Saved successfully!"));
        }

        [Test]
        public void T07_EditProfile_PersonalProfile()
        {
            //Modify each field on the page, Validate that the change is reflected on the profile page
            NavigateToMemberProfileSettings(UN, PW);
            browser.GoTo(targetHost + "/editmemberprofile.aspx?view=PersonalInfo");
            browser.Span(Find.ByText("Personal Profile")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxDateInput")).TypeText("01/01/2000");
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxBio")).TypeText("About Tony Leach… I work for Zecco building the best social investment community available, live in San Francisco");
            browser.TextField("ctl00_ctl00_uxMainContent_uxMainColumn_uxFavoriteWebsites").TypeText("Test" + Date);
            browser.Button("ctl00_ctl00_uxMainContent_uxMainColumn_uxSavePersonalInfo").Click();
            Assert.IsTrue(browser.Span("ctl00_ctl00_uxMainContent_uxMainColumn_uxSuccessMessagePersonalInfo").Text.Contains("Saved successfully!"));
        }

        [Test]
        public void T08_EditProfile_InvestorProfile()
        {
            NavigateToMemberProfileSettings(UN, PW);
            browser.GoTo(targetHost + "/editmemberprofile.aspx?view=InvestingOutlook");
            browser.Span(Find.ByText("Investor Profile")).Click();
            browser.SelectList("ctl00_ctl00_uxMainContent_uxMainColumn_uxInvestmentDiscipline").Option("Aggressive Growth").Select();
            browser.CheckBox("ctl00_ctl00_uxMainContent_uxMainColumn_uxInvestmentInstruments_0").Checked = true;
            browser.Button("ctl00_ctl00_uxMainContent_uxMainColumn_uxSaveInvestingOutlook").Click();

            Assert.IsTrue(browser.Span("ctl00_ctl00_uxMainContent_uxMainColumn_uxSuccessMessageInvestingOutlook").Text.Contains("Saved successfully!"));

            browser.SelectList("ctl00_ctl00_uxMainContent_uxMainColumn_uxInvestmentDiscipline").Option("Please select").Select();
            browser.CheckBox("ctl00_ctl00_uxMainContent_uxMainColumn_uxInvestmentInstruments_0").Checked = false;
            browser.Button("ctl00_ctl00_uxMainContent_uxMainColumn_uxSaveInvestingOutlook").Click();

            Assert.IsTrue(browser.Span("ctl00_ctl00_uxMainContent_uxMainColumn_uxSuccessMessageInvestingOutlook").Text.Contains("Saved successfully!"));
        }
    }
}