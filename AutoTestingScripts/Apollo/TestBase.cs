using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using WatiN.Core;
using NUnit.Framework;
using WatiN.Core.Interfaces;
using WatiN.Core.DialogHandlers;
using System.Threading;

namespace Apollo
{
    public class TestBase
    {
        public Browser browser = null;
        public string targetHost = string.Empty;

        public string UN1 = "HermesTest8060";
        public string PWD1 = "Zecco111";
        public string SA1 = "zecco";

        public string SYMBOL_STOCKBS = "A";//Buy2|Sell1;Limit/Cancel/Open
        public string SYMBOL_STOCKSC = "B";//Short2|Cover1
        public string SYMBOL_CALLPUT = "C";//CallPut;Limit/Cancel/Open
        public string SYMBOL_BUTTERFLY = "D";//Butterfly
        public string SYMBOL_CALENDAR = "E";//Calendar
        public string SYMBOL_COLLAR = "F";//Collar
        public string SYMBOL_CONDOR = "G";//Condor(Put)
        public string SYMBOL_COVERED = "H";//Covered(Put)
        public string SYMBOL_DIAGONAL = "K";//Diagonal Spread(Put)
        public string SYMBOL_IRONBF = "L";//IronButterfly(Put)
        public string SYMBOL_IRONCD = "M";//IronCondor(Put)
        public string SYMBOL_RATIO = "N";//Ratio
        public string SYMBOL_SPREAD = "O";//Spread
        public string SYMBOL_STRADDLE = "P";//Straddle(Put)
        public string SYMBOL_STRANGLE = "R";//Strangle(Put)

        public string symbol_21 = "";
        public string symbol_22 = "";
        public string symbol_23 = "";
        public string symbol_24 = "";

        public string symbol_MF = "SWPPX";
        //public string symbol_5 = "V";

        [TestFixtureSetUp]
        public void SetUp()
        {
            Settings.WaitForCompleteTimeOut = 60;
            Settings.WaitUntilExistsTimeOut = 60;

            targetHost = System.Configuration.ConfigurationSettings.AppSettings["TargetHost"];
            string platform = System.Configuration.ConfigurationSettings.AppSettings["Platform"];

            switch (platform)
            {
                case "IE":
                    browser = new IE();
                    browser.ShowWindow(WatiN.Core.Native.Windows.NativeMethods.WindowShowStyle.Maximize);
                    break;
                case "FF":
                    browser = new FireFox();
                    browser.ShowWindow(WatiN.Core.Native.Windows.NativeMethods.WindowShowStyle.Maximize);
                    break;
                //default:
                //    break;
            }
            browser.GoTo(targetHost);
        }

        public void SignIn(string userName, string password, string answer)
        {
            this.SignOut();
            browser.GoTo(targetHost);

            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleControl_uxLoginForm_uxUserName")).WaitUntilExists();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleControl_uxLoginForm_uxUserName")).TypeText(userName);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleControl_uxLoginForm_uxPassword")).TypeText(password);
            browser.Div(Find.ByClass("SignIn")).Element(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleControl_uxLoginForm_uxSignIn")).Click();
            Thread.Sleep(2000);

            while ((browser.Link(Find.ByText("Sign Out")).Exists == false) || (!browser.ContainsText(userName)))
            {
                if (browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxAnswer")).Exists == true)
                {
                    browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxAnswer")).TypeText(answer);
                    browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNext")).Click();
                }
                else if (browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxRemindMeLater")).Exists == true)
                {
                    browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxRemindMeLater")).Click();
                }
                Thread.Sleep(2000);
            }
            browser.GoTo(targetHost);
        }

        public void SignOut()
        {
            //ctl00_ctl00_uxPreContent_uxTopNavigation_uxMemberLoginStatus_uxMemberLoginView_LoginStatus1
            if (browser.Link(Find.ByText("Sign Out")).Exists == true)
            {
                browser.Link(Find.ByText("Sign Out")).Click();
                Thread.Sleep(2000);
            }
        }

    }
}
