using System;
using System.Collections.Generic;
using System.Text;
using WatiN.Core;
using NUnit.Framework;
using WatiN.Core.Interfaces;
using WatiN.Core.DialogHandlers;
using zjsteel.appshare;
using zjsteel.appshare.App01_HomePage;

namespace zjsteel.appshare.App01_HomePage
{
    //#*****************************************************************************
    //# Purpose:  define User signout function.
    //# Author:  bobby
    //# Last Modify: apr 13, 2009
    //#*****************************************************************************
    class SignOut
    {
        public void TestUserSignOut(Browser browser)
        {

            browser.WaitUntilContainsText("欢迎 ");
            Assert.IsTrue(browser.ContainsText("欢迎 "));
            browser.Image(Find.ById("ctl00_IBestLoginStatus1_lgnStatus")).Click();
            browser.WaitUntilContainsText("用户名");
            Assert.IsTrue(browser.ContainsText("用户名"));
        }
    }
}
