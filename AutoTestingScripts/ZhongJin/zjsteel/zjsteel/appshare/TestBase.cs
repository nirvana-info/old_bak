using System;
using System.Collections.Generic;
using System.Text;
using WatiN.Core;
using NUnit.Framework;
using WatiN.Core.Interfaces;
using WatiN.Core.DialogHandlers;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.Diagnostics;


//#*****************************************************************************
//# Purpose: 定义通用浏览器
//# Author:  bobby
//# Create Date: April 13, 2009
//# Modify History: 

//#*****************************************************************************

namespace zjsteel.appshare
{

    public abstract class TestBase:PublicPara
    {
        protected enum Platform
        {
            FF,
            IE
        }

        protected Platform platform;




        static void Main(string[] args)
        {

        }

        [TestFixtureSetUp]
        public void SetUp()
        {
            Settings.WaitForCompleteTimeOut = 80;
            Settings.WaitUntilExistsTimeOut = 80;

            platform = (Platform)Enum.Parse(typeof(Platform), System.Configuration.ConfigurationManager.AppSettings["Platform"]);
            targetHost = System.Configuration.ConfigurationManager.AppSettings["TargetHost"];

            switch (platform)
            {
                case Platform.IE:

                    browser = new IE();
                    browser.ShowWindow(WatiN.Core.Native.Windows.NativeMethods.WindowShowStyle.Maximize);
                    break;
                case Platform.FF:
                    browser = new FireFox();
                    browser.ShowWindow(WatiN.Core.Native.Windows.NativeMethods.WindowShowStyle.Maximize);
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
            System.Diagnostics.Process[] processList = System.Diagnostics.Process.GetProcessesByName("iexplore");
            foreach (System.Diagnostics.Process process in processList)
            {
                process.Kill();
                // sleep to make sure process is killed
                System.Threading.Thread.Sleep(2000);
                
            }
        }
    }
}
