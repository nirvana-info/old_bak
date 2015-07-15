//#*****************************************************************************
//# Purpose: Quick Link
//# Author: Jessica Liu 
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
using MaiaRegression.TestCases._03_QuickLink;
using MaiaRegression.Appobjects;

namespace MaiaRegression.Tasks
{

    [TestFixture]
    public class Scenario004_QuickLink : Check004_QuickLink
    {

        [Test]
        public void WelcomeZeccolink()
        // This scenario link WelcomeToZecco page 
        {
            Check004_QuickLink l = new Check004_QuickLink();
            l.WelcomeToZecco(browser);
            Assert.IsTrue(browser.ContainsText("Hello, We Are Zecco"));
            
             
        }
    }
}