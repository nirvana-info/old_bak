using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using WatiN.Core;
using NUnit.Framework;
using WatiN.Core.Interfaces;
using WatiN.Core.DialogHandlers;

namespace Hermes
{
    public class TestClass
    {
        public Browser browser = null;
        public string targetHost = string.Empty;
        public string UN1 = "HermesTest0440";
        public string PWD1 = "Zecco111";
        public string SA1 = "zecco";

        public string symbol_1 = "A";//Buy2|Sell1;Limit/Cancel/Open
        public string symbol_2 = "B";//Short2|Cover1
        public string symbol_3 = "C";//CallPut;Limit/Cancel/Open
        public string symbol_4 = "D";//Butterfly
        public string symbol_5 = "F";//Calendar
        public string symbol_6 = "G";//Collar
        public string symbol_7 = "H";//Condor(Put)
        public string symbol_8 = "K";//Covered(Put)
        public string symbol_9 = "L";//IronButterfly(Put)
        public string symbol_10 = "M";//IronCondor(Put)
        public string symbol_11 = "N";//Ratio
        public string symbol_12 = "O";//Spread
        public string symbol_13 = "Q";//Straddle(Put)
        public string symbol_14 = "R";//Strangle(Put)

        public string symbol_MF = "SWPPX";
        //public string symbol_5 = "V";

        [TestFixtureSetUp]
        public void SetUp()
        {
            Settings.WaitForCompleteTimeOut = 60;
            Settings.WaitUntilExistsTimeOut = 60;

            targetHost = System.Configuration.ConfigurationManager.AppSettings["targetHost"];
            string platform = System.Configuration.ConfigurationManager.AppSettings["Platform"];

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
    }
}
