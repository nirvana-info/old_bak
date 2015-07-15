using System;
using System.Collections.Generic;
using System.Text;
using WatiN.Core;
using NUnit.Framework;
using WatiN.Core.Interfaces;
using WatiN.Core.DialogHandlers;

namespace MaiaRegression.Appobjects.App01_HomePage
{
    public class ChangeEmail : SignIn
    {
        public void GotoChangeEmail()
        {
            UserSignIn(UN, PW, false, 0);
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
            browser.WaitForComplete();
            browser.Link(Find.ByText("Change email address")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxEmailAddress")).WaitUntilExists(10);
        }
    }
}
