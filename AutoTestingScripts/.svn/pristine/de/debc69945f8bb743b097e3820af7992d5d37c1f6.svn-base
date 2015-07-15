using System;
using System.Collections.Generic;
using System.Text;
using WatiN.Core;
using NUnit.Framework;
using WatiN.Core.Interfaces;
using WatiN.Core.DialogHandlers;
using System.ComponentModel;
using System.Data;
using System.Linq;
using System.Diagnostics;



namespace SL360Test_Iris
{

    public abstract class Testbase
    {
        //[TestFixtureSetUpAttribute]
        //public void OpenTargetUrl(string target)
        //{
        //    FF.GoTo(target);

        //}

        public PublicPara para = null;
        public Browser FF = null;

        [TestFixtureSetUp]
        public void SetUp()
        {
            para = new PublicPara();

            Settings.WaitForCompleteTimeOut = 80;
            Settings.WaitUntilExistsTimeOut = 80;
            FF = new FireFox();
            FF.ShowWindow(WatiN.Core.Native.Windows.NativeMethods.WindowShowStyle.Maximize);

        }

        [STAThread]
        static void Main(string[] args)
        {  // This is just a test project but there needs to be a Main method for compilation.
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
