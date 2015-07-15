using System;
using System.Collections.Generic;
using System.Text;
using WatiN.Core;
using NUnit.Framework;
using WatiN.Core.Interfaces;
using WatiN.Core.DialogHandlers;
using MaiaRegression.Appobjects;

namespace MaiaRegression.Appobjects.App01_HomePage
{
    public class PassWord:SignIn
    {
        public void ChangePassWord(String CurrentPassword, String NewPassword,String NewPasswordConfirmed)
        {
            if (browser.Link(Find.ByText("Change password")).Exists == false)
            {
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
            }
            browser.Link(Find.ByText("Change password")).WaitUntilExists(10);
            browser.Link(Find.ByText("Change password")).Click();
            browser.TextField("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxCurrentPassword").WaitUntilExists(10);
            browser.TextField("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxCurrentPassword").TypeText(CurrentPassword);
            browser.TextField("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNewPassword").TypeText(NewPassword);
            browser.TextField("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxConfirmPassword").TypeText(NewPasswordConfirmed);

            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxContinue")).Click();
        }
    }
}
