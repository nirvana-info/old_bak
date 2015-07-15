//#*****************************************************************************
//# Purpose: ViewProfile.
//# Author:  Christie Duan
//# Create Date: April 07, 2009
//# Modify History: 
//#*****************************************************************************


using System;
using System.Collections.Generic;
using System.Text;
using WatiN.Core;
using NUnit.Framework;
using WatiN.Core.Interfaces;
using WatiN.Core.DialogHandlers;

namespace MaiaRegression.Appobjects.App01_HomePage
{
    public class ViewProfile : SignIn
    {
        public string MemberName = string.Empty;

        public void NavigateToProfile(String UserName, String PassWord)
        {
            UserSignIn(UserName, PassWord, false, 0);

            if (browser.Span(Find.ByText("Personal Profile")).Exists == false)
            // Assert if the current page is Profile page.If not,navigate to Profile page.
            {
                browser.Link(Find.ByText("Community Profile")).Click();
            }
            browser.WaitForComplete();
            System.Threading.Thread.Sleep(2000);
        }

        public void NavigateToMemberProfileSettings(String UserName, String PassWord)
        {
            if (browser.Div("MainColumn").Div(Find.ByClass("float-left gutter")).Exists == true)
            {
                if (browser.Div("MainColumn").Div(Find.ByClass("float-left gutter")).Text.Contains("Settings Overview ") == false)
                {
                    if (browser.Span(Find.ByClass("loginstatus")).Link(Find.ByText("Sign Out")).Exists == true)
                    {
                        SignOut so = new SignOut();
                        so.UserSignOut(browser);
                        browser.GoTo(targetHost);
                        System.Threading.Thread.Sleep(10000);
                    }

                    UserSignIn(UserName, PassWord, false, 0);
                    browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
                    browser.Link(Find.ById("uxAccountCenter")).Click();
                }
            }
            else
            {
                if (browser.Span(Find.ByClass("loginstatus")).Link(Find.ByText("Sign Out")).Exists == true)
                {
                    SignOut so = new SignOut();
                    so.UserSignOut(browser);
                    browser.GoTo(targetHost);
                    System.Threading.Thread.Sleep(10000);
                }

                UserSignIn(UN, PW, false, 0);
                browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
                browser.Link(Find.ById("uxAccountCenter")).Click();
            }

            browser.Link(Find.ByText("Edit your profile")).Click();
        }
        
        //public void NavigateToShoutBoxOtherMain()
        //{
        //    if (browser.Span("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberDisplayName").Exists == false)
        //    {
        //        NavigateToProfile(UN, PW);

        //        MemberName = browser.Link("ctl00_ctl00_uxMainContent_uxRightColumn_uxMemberConnections_uxConnectionsList_ctl00_uxConnectionLink").Text.Trim();
        //        browser.Link("ctl00_ctl00_uxMainContent_uxRightColumn_uxMemberConnections_uxConnectionsList_ctl00_uxConnectionLink").Click();
        //        //browser.Div("MainColumn").Div(Find.ByText(MemberName)).WaitUntilExists(30);
        //        browser.Link("uxShoutBoxHeaderViewAllLink").Click();
        //    }
        //    else
        //    {
        //        //if (browser.Span("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberDisplayName").Text == UN)
        //        //{
        //        MemberName = browser.Link("ctl00_ctl00_uxMainContent_uxRightColumn_uxMemberConnections_uxConnectionsList_ctl00_uxConnectionLink").Text.Trim();
        //        browser.Link("ctl00_ctl00_uxMainContent_uxRightColumn_uxMemberConnections_uxConnectionsList_ctl00_uxConnectionLink").Click();
        //        //browser.Div("MainColumn").Div(Find.ByText(MemberName)).WaitUntilExists(30);
        //        browser.Link("uxShoutBoxHeaderViewAllLink").Click();
        //        //}
        //    }
        //}

        //public void NavigateToShoutBoxOtherProfile()
        //{
        //    if (browser.Span("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberDisplayName").Exists == false)
        //    {
        //        NavigateToProfile(UN, PW);

        //        MemberName = browser.Link("ctl00_ctl00_uxMainContent_uxRightColumn_uxMemberConnections_uxConnectionsList_ctl00_uxConnectionLink").Text.Trim();
        //        browser.Link("ctl00_ctl00_uxMainContent_uxRightColumn_uxMemberConnections_uxConnectionsList_ctl00_uxConnectionLink").Click();
        //    }
        //    else
        //    {
        //        if (browser.Span("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberDisplayName").Text == UN)
        //        {
        //            MemberName = browser.Link("ctl00_ctl00_uxMainContent_uxRightColumn_uxMemberConnections_uxConnectionsList_ctl00_uxConnectionLink").Text.Trim();
        //            browser.Link("ctl00_ctl00_uxMainContent_uxRightColumn_uxMemberConnections_uxConnectionsList_ctl00_uxConnectionLink").Click();
        //        }

        //    }
        //}

        public void NavigateToShoutBoxSelfMain()
        {
            if (browser.Span("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberDisplayName").Exists == false)
            {
                NavigateToProfile(UN, PW);
                browser.Div(Find.ById("Sidebar")).Link(Find.ById("uxShoutBoxHeaderViewAllLink")).WaitUntilExists(10);
                browser.Div(Find.ById("Sidebar")).Link(Find.ById("uxShoutBoxHeaderViewAllLink")).Click();
            }
            else
            {
                if (browser.Span("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberDisplayName").Text.Contains("Shoutbox & Trade Notes") == true)
                {
                    NavigateToProfile(UN, PW);
                    browser.Div(Find.ById("Sidebar")).Link(Find.ById("uxShoutBoxHeaderViewAllLink")).WaitUntilExists(10);
                    browser.Div(Find.ById("Sidebar")).Link(Find.ById("uxShoutBoxHeaderViewAllLink")).Click();
                }
            }
        }

        public void NavigateToConnection(Browser browser)
        {
            NavigateToProfile(UN, PW);
        }
    }
}