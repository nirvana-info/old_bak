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
    public class Scenario005_HelpLink1 : Check005_HelpLink
    {

        [Test]
     
        public void secondlink(IBrowser browser)
        // This scenario link WelcomeToZecco page 
        {
            Check005_HelpLink h = new Check005_HelpLink();
            h.Help(browser);
           
            Assert.IsTrue(browser.ContainsText("Frequently Asked Questions"));


        }
    }
}
