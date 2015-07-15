using System;
using WatiN.Core;
using NUnit.Framework;
using System.Text.RegularExpressions;
using WatiN.Core.Exceptions;
using System.Threading;
using System.Globalization;


namespace PPlusSystemTesting
{

    public abstract class TestBase
    {
        protected IE ie = null;
        private bool logged = false;
        public static string url = "http://192.168.0.20/";
        //public static string url = "https://staging.sfpave.com";
        public static string AgentID = "4791fd";
        public static string StaffID = "";
        public static string AFOID = "";
        public static string ZoneID = "QRNO";
        public static string CorpID = "";
        public string Date = DateTime.Today.ToString("yyyyMMdd");
        public string dt = DateTime.Today.ToString("d", DateTimeFormatInfo.InvariantInfo);
       
        protected bool LoggedIn
        {
            get { return logged; }
            set { logged = value; }
        }

        [TestFixtureSetUpAttribute]

        public void SetUp()
        {
            Settings.WaitForCompleteTimeOut = 10;
            Settings.WaitUntilExistsTimeOut = 10;
            ie = new IE();
            ie.GoTo(url + "ProspectorPlus/VendorLogin.aspx");
            ie.ShowWindow(NativeMethods.WindowShowStyle.Maximize);
        }



        [STAThread]

        static void Main(string[] args)
        {  // This is just a test project but there needs to be a Main method for compilation.
        }

        [TestFixtureTearDownAttribute]

        public void TearDown()
        {
            //ie.Close();
        }


        public void AdminLogin(string admin,string password)
        {
            ie.TextField(Find.ByName("ctl00$MainContentHolder$txtUsername")).TypeText(admin);
            ie.TextField(Find.ByName("ctl00$MainContentHolder$txtPassword")).TypeText(password);
            ie.Button(Find.ByName("ctl00$FooterButtonNext")).Click();
        }

        public void AgentLogin(string agent)
        {
            ie.Span(Find.ByText("Login as Another User")).WaitUntilExists(120);
            ie.TextField(Find.ByName("ctl00$MainContentHolder$txtAgentId")).TypeText(agent);
            ie.Button(Find.ByName("ctl00$FooterButtonNext")).Click();
        
        }

    }
}
