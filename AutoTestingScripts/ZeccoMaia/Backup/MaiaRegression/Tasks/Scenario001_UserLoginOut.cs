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
using MaiaRegression.TestCases._01_HomePage;
using MaiaRegression.Appobjects;

namespace MaiaRegression.Tasks
{
   
    [TestFixture]
    public class Scenario001_UserLoginOut:Check001_SignIn
    {
        
        [Test]
        public void UserLoignAndOut()
        // This scenario checks user login and logout functions.
        {            
           
            
            UserSignIn(UserName,PassWord);

            Check002_SignOut nbj = new Check002_SignOut();
            nbj.UserSignOut(browser);
            
        }
       
       

    }
}
