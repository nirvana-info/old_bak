//#*****************************************************************************
//# Purpose: QuickLink_WelcomeToZecco
//# Author:  Jessica Liu
//# Create Date: Mar 13, 2009
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


namespace MaiaRegression.Appobjects.App03_QuickLink
{
    public class WelcomeToZecco: TestBase
    {

        public void WelcomeToZeccoLink(IBrowser browser)
        {
            browser.Link(Find.ByText("Community")).Click();
            browser.Link(Find.ByText("Welcome To Zecco")).Click();
        }

    }
}
