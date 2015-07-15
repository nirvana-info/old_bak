//#*****************************************************************************
//# Purpose: User login.
//# Author:  Christie Duan
//# Create Date: Mar 31, 2009
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
    public class SignUp : TestBase
    {
        PublicPara v = new PublicPara();

        public void NavigateToSignup(Browser browser)
        {
            if (browser.Link(Find.ByText("Sign Out")).Exists)
            {
                SignOut si = new SignOut();
                si.UserSignOut(browser);
            }
            browser.GoTo(targetHost);
            //browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxMemberLoginStatus_uxMemberLoginView_uxMemberSignUpLink")).Click();
            browser.Link(Find.ById("uxMemberSignUpLink")).Click();
        }

        public void CheckUserAvailable(String Acount)
        {
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxUserName")).Value = Acount;
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxNext")).Focus();
            //browser.Link(Find.ByText("Check username availability")).Click();
        }

        public void UserSignUp(String Acount, String Password1, String Password2, String Email1, String Email2, int Answer, int Tos)
        {
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxUserName")).Value = Acount;
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxPassword")).Value = Password1;
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxConfirmPassword")).Value = Password2;
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxEmailAddress")).Value = Email1;
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxConfirmEmailAddress")).Value = Email2;
            // Answer=0, no answer; Answer=1,answer; Tos=0, unchecked Tos; Tos=1, checked Tos 
            if (Answer == 1)
            {
                browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxSecurityQuestionList1")).Option("What is the color of your eyes?").Select();
                browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxSecurityAnswerFromList1")).Value = "Red";
            }

            if (Tos == 1)
            {
                //browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxAgreeToTerms")).Click();
            }
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxNext")).Click();
            System.Threading.Thread.Sleep(5000);
        }
    }
}
