//#*****************************************************************************
//# Purpose: User login.
//# Author:  Christie Duan
//# Create Date: Mar 10, 2009
//# Modify History: 
//# April 07, 2009    Add "Default page" parameter  ChristieDuan
//#*****************************************************************************

using System;
using System.Collections.Generic;
using System.Text;
using WatiN.Core;
using NUnit.Framework;
using WatiN.Core.Interfaces;
using WatiN.Core.DialogHandlers;
using MaiaRegression.Appobjects;

namespace MaiaRegression.Appobjects.App01_HomePage
{
    //#*****************************************************************************
    //# Purpose: This class inherit from TestBase, define User Login function.
    //# Author:  Christie
    //# Last Modify: Mar 10, 2009
    //#*****************************************************************************
    public class SignIn : TestBase
    {
        PublicPara v = new PublicPara();

        public void TestUserSignIn(String UserName, String PassWord, Boolean bRemember, int DefaultPage)
        {
            // if there already have a user login, do logout first
            if (browser.Link(Find.ByText("Sign Out")).Exists)
            {
                SignOut si = new SignOut();
                si.UserSignOut(browser);
                browser.GoTo(targetHost + "/signin.aspx");

                System.Threading.Thread.Sleep(5000);
            }
            //browser.Button(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxMemberLoginStatus_uxMemberLoginView_LoginStatus1")).Click();
            System.Threading.Thread.Sleep(5000);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleControl_uxLoginForm_uxUserName")).TypeText(UserName);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleControl_uxLoginForm_uxPassword")).TypeText(PassWord);
            
            //SelectList startList = browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDefaultLoginForm_uxStart"));
            //if (startList.Exists)
            //{
            //    startList.Option("Account Settings").Select();
            //}

            if (bRemember)
            {
                browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleControl_uxLoginForm_uxRememberMeNextTime")).Checked = true;
            }

            //switch (DefaultPage)
            ////1--DefaultPage is Zecco Trading Center; 2--DefaultPage is Community Profile; 3--DefaultPage is Account Settings; 4--DefaultPage is Message Center
            //{
            //    case 0:
            //        break;
            //    case 1:
            //        browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDefaultLoginForm_uxStart")).Option("Zecco Trading Center").Select();
            //        break;
            //    case 2:
            //        browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDefaultLoginForm_uxStart")).Option("Community Profile").Select();
            //        break;
            //    case 3:
            //        browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDefaultLoginForm_uxStart")).Option("Account Settings").Select();
            //        break;
            //    case 4:
            //        browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDefaultLoginForm_uxStart")).Option("Message Center").Select();
            //        break;
            //}

            if ((browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDefaultLoginForm_uxBetaAgreeToTerms")).Exists == true) && 
                (browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDefaultLoginForm_uxBetaAgreeToTerms")).Checked == false))
            {
                browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDefaultLoginForm_uxBetaAgreeToTerms")).Checked = true;
            }

            browser.Div(Find.ByClass("SignIn")).Element(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleControl_uxLoginForm_uxSignIn")).Click();

            if ((browser.Link(Find.ByText("Sign Out")).Exists) && (browser.ContainsText(UserName)))
            {
                return;
            }
            else
            {
                if (browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxAnswer")).Exists == true)
                {
                    browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxAnswer")).TypeText(SA);
                    browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNext")).Click();
                }
            }
            //roadblock
            while (browser.Link(Find.ById("uxRemindLater")).Exists == true)
            {
                browser.Link(Find.ById("uxRemindLater")).Click();
                System.Threading.Thread.Sleep(5000);
            }
            System.Threading.Thread.Sleep(5000);
            browser.Link(Find.ByText("Community Profile")).Click();
            System.Threading.Thread.Sleep(5000);
        }

        public void TestUserSignInFromSignUp(String UserName, String PassWord, Boolean bRemember)
        {
            // if there already have a user login, do logout first
            if (browser.Link(Find.ByText("Sign Out")).Exists)
            {
                SignOut si = new SignOut();
                si.UserSignOut(browser);
            }

            browser.Link(Find.ById("uxMemberSignUpLink")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxOpenLoginForm")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxDefaultLoginForm_uxUserName")).TypeText(UserName);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxDefaultLoginForm_uxPassword")).TypeText(PassWord);

            if (bRemember)
            {
                browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxDefaultLoginForm_uxRememberMeNextTime")).Checked = true;
            }
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxDefaultLoginForm_uxSignIn")).Click();
            if ((browser.Link(Find.ByText("Sign Out")).Exists) &&
                (browser.Div(Find.ById("topNavMemberDiv")).Text.Trim().ToLower() == UserName.ToLower()))
            {
                return;
            }
            else
            {
                if (browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxAnswer")).Exists == true)
                {
                    browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxAnswer")).TypeText(SA);
                    browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNext")).Click();
                }
            }
        }

        public void TestUserSignInForIP(String UserName, String PassWord, Boolean bRemember, int DefaultPage)
        {
            // if there already have a user login, do logout first
            if (browser.Link(Find.ByText("Sign Out")).Exists)
            {
                SignOut si = new SignOut();
                si.UserSignOut(browser);
            }
            browser.GoTo(targetHost);

            System.Threading.Thread.Sleep(5000);

            //browser.Link(Find.ByClass("login-button login-signin")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDefaultLoginForm_uxUserName")).TypeText(UserName);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDefaultLoginForm_uxPassword")).TypeText(PassWord);
            SelectList startList = browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDefaultLoginForm_uxStart"));
            if (startList.Exists)
            {
                startList.Option("Account Settings").Select();
            }

            //if (bRemember)
            //{
            //    browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDefaultLoginForm_uxRememberMeNextTime")).Checked = true;
            //}

            switch (DefaultPage)
            //1--DefaultPage is Zecco Trading Center; 2--DefaultPage is Community Profile; 3--DefaultPage is Account Settings; 4--DefaultPage is Message Center
            {
                case 0:
                    break;
                case 1:
                    browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDefaultLoginForm_uxStart")).Option("Zecco Trading Center").Select();
                    break;
                case 2:
                    browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDefaultLoginForm_uxStart")).Option("Community Profile").Select();
                    break;
                case 3:
                    browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDefaultLoginForm_uxStart")).Option("Account Settings").Select();
                    break;
                case 4:
                    browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDefaultLoginForm_uxStart")).Option("Message Center").Select();
                    break;

            }
            if ((browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDefaultLoginForm_uxBetaAgreeToTerms")).Exists == true) &&
                (browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDefaultLoginForm_uxBetaAgreeToTerms")).Checked == false))
            {
                browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDefaultLoginForm_uxBetaAgreeToTerms")).Checked = true;
            }

            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDefaultLoginForm_uxSignIn")).Click();
        }

        public void UserSignIn(String UserName, String PassWord, Boolean bRemember, int DefaultPage)
        {
            if ((browser.Link(Find.ByText("Sign Out")).Exists) &&
                (browser.Div(Find.ById("topNavMemberDiv")).Text.Trim().ToLower() == UserName.ToLower()))
            {
                return;
            }
            else
            {
                TestUserSignIn(UserName, PassWord, bRemember, DefaultPage);
            }
            browser.Link(Find.ByText("Community Profile")).Click();
            System.Threading.Thread.Sleep(5000);
        }
    }
}
