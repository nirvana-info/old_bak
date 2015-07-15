using System;
using System.Collections.Generic;
using System.Text;
using WatiN.Core;
using NUnit.Framework;
using WatiN.Core.Interfaces;
using WatiN.Core.DialogHandlers;



namespace MaiaRegression.Appobjects
{

    public abstract class TestBase:PublicPara
    {
        protected enum Platform
        {
            FF,
            IE
        }



        public IBrowser browser = null;
        protected string targetHost = string.Empty;
        protected Platform platform;

        static void Main(string[] args)
        {

        }

        [TestFixtureSetUp]
        public void SetUp()
        {
            platform = (Platform)Enum.Parse(typeof(Platform), System.Configuration.ConfigurationManager.AppSettings["Platform"]);
            targetHost = System.Configuration.ConfigurationManager.AppSettings["TargetHost"];

            switch (platform)
            {
                case Platform.IE:

                    browser = new IE();
                    browser.ShowWindow(NativeMethods.WindowShowStyle.Maximize);
                    break;
                case Platform.FF:
                    browser = BrowserFactory.Create(BrowserType.FireFox);
                    browser.ShowWindow(NativeMethods.WindowShowStyle.Maximize);
                    break;

            }
            browser.GoTo(targetHost);

        }

        [TestFixtureTearDown]
        public void TearDown()
        {
            //Close();
        }

        protected void Close()
        {
            System.Diagnostics.Process[] processList = System.Diagnostics.Process.GetProcessesByName("IEXPLORE");
            foreach (System.Diagnostics.Process process in processList)
            {
                //System.Threading.Thread.Sleep(10000);
                process.Kill();
            }

        }

    }
}
