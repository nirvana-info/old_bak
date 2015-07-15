//#*****************************************************************************
//# Purpose: User login.
//# Author:  bobby
//# Create Date: apr 13, 2009
//# Modify History: 
//# 
//#*****************************************************************************

using System;
using System.Collections.Generic;
using System.Text;
using WatiN.Core;
using NUnit.Framework;
using WatiN.Core.Interfaces;
using WatiN.Core.DialogHandlers;
using zjsteel.appshare;


namespace zjsteel.appshare.App01_HomePage
{

    //#*****************************************************************************
    //# Purpose: This class inherit from TestBase, define User Login function.
    //# Author:  bobby
    //# Last Modify: apr 13, 2009
    //#*****************************************************************************
    public class SignIn : TestBase
    {

        PublicPara v = new PublicPara();
        
        public void TestUserSignIn(String UserName, String PassWord)
        {
            browser.WaitUntilContainsText("用户名");
            
            browser.TextField(Find.ById("ctl00_IBestLoginStatus1_Login_UserName")).TypeText(UserName);
            browser.TextField(Find.ById("ctl00_IBestLoginStatus1_Login_Password")).TypeText(PassWord);
            Assert.IsTrue(browser.ContainsText("用户名"));
            browser.Button(Find.ById("ctl00_IBestLoginStatus1_Login_LoginButton")).Click();
            browser.WaitUntilContainsText("欢迎 "+UserName);
            Assert.IsTrue(browser.ContainsText("欢迎 "+UserName));
        }
    }
}
