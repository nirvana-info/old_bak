//#*****************************************************************************
//# Purpose: User login check.
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
using MaiaRegression.Appobjects.App01_HomePage;
using System.Web;

namespace MaiaRegression.TestCases._01_HomePage
{

    //#*****************************************************************************
    //# Purpose: This class inherit from SignIn class, Define SignOut Checkpoint.
    //# Author:  Christie
    //# Last Modify: Mar 10, 2009
    //#*****************************************************************************

    public class Check001_SignIn:SignIn
    {

        public void SignIn(String UserName, String PassWord)
        //CheckPoint: UserName can be viewed in the bottom of the screen after login successfully.      

        {

            UserSignIn(UserName,PassWord);

            string UN = browser.Span(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxMemberLoginStatus_uxMemberLoginView_uxLoginName")).Text;

            //if login unsuccessfully, it shows reminder message.
            if (UN != UserName)
             {
                 Console.WriteLine("Check001_SignIn failed:User Login unsuccessfully!");                 
             }

             Assert.AreEqual(UserName,  browser.Span(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxMemberLoginStatus_uxMemberLoginView_uxLoginName")).Text);
          
        }
       
     }
}
