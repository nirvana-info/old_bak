//#*****************************************************************************
//# Purpose: User login.
//# Author:  Christie Duan
//# Create Date: Mar 10, 2009
//# Modify History: 
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
    public  class SignIn:TestBase
    {

        PublicPara v = new PublicPara();

        public void UserSignIn(String UserName, String PassWord)
        {

            
            // if there already have a user login, do logout first
            if (browser.Link(Find.ByClass("login-button login-signout")).Exists)
                {
                  SignOut si = new SignOut();
                  si.UserSignOut(browser);
                }


            browser.Link(Find.ByClass("login-button login-signin")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxLoginForm_uxUserName")).Value = UserName;
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxLoginForm_uxPassword")).Value = PassWord;
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxLoginForm_uxSignIn")).Click();

                    
            }

           
           
       
        
    }
}
