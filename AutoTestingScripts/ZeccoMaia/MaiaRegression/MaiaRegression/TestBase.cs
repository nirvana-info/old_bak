using NUnit.Framework;
using System;
using System.Collections.Generic;
using System.Text;
using WatiN.Core;
using WatiN.Core.Interfaces;
using System.Configuration;


namespace MaiaRegression
{

    public abstract class TestBase
    {
        protected enum Platform
        {
            FF,
            IE
        }



        protected IBrowser browser = null;
        protected string targetHost = string.Empty;
        protected string UserName = string.Empty;
        protected string PassWord = string.Empty;
        protected Platform platform;

        static void Main(string[] args)
        {

        }

        [TestFixtureSetUp]
        public void SetUp()
        {
            platform = (Platform)Enum.Parse(typeof(Platform), System.Configuration.ConfigurationManager.AppSettings["Platform"]);
            targetHost = System.Configuration.ConfigurationManager.AppSettings["TargetHost"];
            UserName = System.Configuration.ConfigurationManager.AppSettings["UserName"];
            PassWord = System.Configuration.ConfigurationManager.AppSettings["PassWord"];


            switch (platform)
            {
                case Platform.IE:

                    browser = new IE();
                    break;
                case Platform.FF:
                    browser = BrowserFactory.Create(BrowserType.FireFox);
                    break;

            }


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
