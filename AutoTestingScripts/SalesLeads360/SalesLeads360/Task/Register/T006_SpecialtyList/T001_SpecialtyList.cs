//#*****************************************************************************
//# Purpose: enter zipcode
//# Author:  bobby
//# Create Date: April 27, 2009
//# Modify History: 

//#*****************************************************************************

using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using SalesLeads360.Appshare.App01_HomePage;
using SalesLeads360.Appshare;

using System.Data;


namespace SalesLeads360.Task.Register.T006_SpecialtyList
{
    [TestFixture]
    public class T001_SpecialtyList : Selectsitmap
    {
        [Test]
        public void T01_Check_SpecialtyList()
        {
            //userlogin
            Login login = new Login();
            login.userlogin(CountEmail, CountPW, browser);

            //select leads type
            TestUserSelectsitmap();
            
            //specialty info
            specialtylists sl = new specialtylists();
            sl.TestUserspecialtylists(browser);

            
        }
    }
}
