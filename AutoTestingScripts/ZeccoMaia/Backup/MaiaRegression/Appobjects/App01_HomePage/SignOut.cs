//#*****************************************************************************
//# Purpose: User logout.
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

namespace MaiaRegression.Appobjects.App01_HomePage
{

    ////#*****************************************************************************
    //# Purpose: This class inherit from TestBase, define User Login function.
    //# Author:  Christie
    //# Last Modify: Mar 10, 2009
    ////#*****************************************************************************
    public class SignOut
    {

        public void UserSignOut(IBrowser browser)
        {
            browser.Link(Find.ByClass("login-button login-signout")).Click();
            
        }
    }
}
