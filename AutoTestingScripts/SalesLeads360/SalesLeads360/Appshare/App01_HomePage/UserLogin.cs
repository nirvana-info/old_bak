using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using WatiN.Core;

namespace SalesLeads360.Appshare.App01_HomePage
{
    public class Login:TestBase
    {

        public void userlogin(string username, string password,Browser browser)
        {

            OpenTargetUrl(targetHost + "salesleads360", browser);
            
            if (browser.Link("ctl00_ctl00_uxContent_uxNavLists_llLogout").Exists == false)
            {
          
            browser.TextField("ctl00_ctl00_uxContent_ContentPlaceHolder1_tbEmail").WaitUntilExists(20);

            browser.TextField("ctl00_ctl00_uxContent_ContentPlaceHolder1_tbEmail").TypeText(username);
            browser.TextField("ctl00_ctl00_uxContent_ContentPlaceHolder1_tbPwd").TypeText(password);
            browser.Button("ctl00_ctl00_uxContent_ContentPlaceHolder1_btOk").Click();
            }

        }
    }
}
