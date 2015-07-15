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
using System.Windows.Forms;
using System.Diagnostics;



//#*****************************************************************************
//# Purpose: Define the TestBase
//# Author:  bobby
//# Create Date: April 27, 2009
//# Modify History: 

//#*****************************************************************************

namespace SalesLeads360.Appshare
{

    public abstract class TestBase:PublicPara
    {
        protected enum Platform
        {
            FF,
            IE
        }

        protected Platform platform;

        public void OpenTargetUrl(string target, Browser browser)
        {
            browser.GoTo(target);

        }


        static void Main(string[] args)
        {

        }

        [TestFixtureSetUp]
        public void SetUp()
        {
            Settings.WaitForCompleteTimeOut = 80;
            Settings.WaitUntilExistsTimeOut = 80;

            platform = (Platform)Enum.Parse(typeof(Platform), System.Configuration.ConfigurationManager.AppSettings["Platform"]);
            //targetHost = System.Configuration.ConfigurationManager.AppSettings["TargetHost"];

            switch (platform)
            {
                case Platform.IE:
                    if (IE.InternetExplorers().Count == 0)
                    {
                        browser = new IE();
                        browser.ShowWindow(WatiN.Core.Native.Windows.NativeMethods.WindowShowStyle.Maximize);
                        
                    }
                    else
                    {
                        int pagecount = IE.InternetExplorers().Count;
                        int index=100;

                        for (int i=0; i < pagecount; i++)
                        {
                            if (IE.InternetExplorers()[i].Url.Contains(targetHost) == true)
                            {
                                index = i;
                            }
                         
                        }
                        if (index != 100)
                        {
                            browser = IE.InternetExplorers()[index];
                        }
                        else
                        {
                            browser = new IE();
                        }
                        browser.ShowWindow(WatiN.Core.Native.Windows.NativeMethods.WindowShowStyle.Maximize);
                    }
                    break;
                    //if (IE.InternetExplorers().Count == 0)
                    //{
                    //    browser = new IE();
                    //}
                    //else
                    //{
                    //    int Count = IE.InternetExplorers().Count;

                    //    //for(int i; i<Count;i++)
                    //    //{
                    //    //    bool Contains;
                    //    //    Contains
                    //    //    IE.InternetExplorers()[1].Url.Contains(targetHost);
                        
                    //    //}

                    //    if(IE.InternetExplorers())
                    //    {
                    //        browser = IE.InternetExplorers()[1];
                    //        IE.InternetExplorers()[1].Url.Contains(targetHost);
                    //    }
                    //    else
                    //    {
                    //        browser = new IE();
                    //    }
                    //}
                   
                    
              
                case Platform.FF:
                    browser = new FireFox();
                    browser.ShowWindow(WatiN.Core.Native.Windows.NativeMethods.WindowShowStyle.Maximize);
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
