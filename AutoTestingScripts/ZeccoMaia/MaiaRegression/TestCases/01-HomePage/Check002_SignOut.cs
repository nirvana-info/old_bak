//#*****************************************************************************
//# Purpose: User logout check.
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
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.TestCases._01_HomePage
{

    //#*****************************************************************************
    //# Purpose: This class inherit from SignOut class, Define SignOut Checkpoint.
    //# Author:  Christie
    //# Last Modify: Mar 10, 2009
    //#*****************************************************************************
    public  class Check002_SignOut:SignOut
    {
       
        public  void SignOut(Browser browser)
        //CheckPoint:Logout successfully, the Login button can be viewed. 
        {
            UserSignOut(browser);
            Assert.IsTrue(browser.Link(Find.ByClass("login-button login-signin")).Exists);
            

        }
    }
}
