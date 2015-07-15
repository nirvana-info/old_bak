using System;
using WatiN.Core;
using NUnit.Framework;
using System.Text.RegularExpressions;

namespace SystemTest
{

    public abstract class TestBase
    {
        protected IE ie = null;
        private bool logged = false;
        //public static string url = "http://www.nirvana-info.cn:8181/";
        public static string url = "http://192.168.0.223/";
        protected bool LoggedIn
        {
            get { return logged; }
            set { logged = value; }
        }

        [TestFixtureSetUpAttribute]

        public void SetUp()
        {
            ie = new IE();
        }

        protected void Login()
        {
            ie.GoTo("http://yours");
            ie.ShowWindow(NativeMethods.WindowShowStyle.Maximize);
            ie.TextField(Find.ById("Login1_txtUserId")).TypeText("user");
            ie.TextField(Find.ById("Login1_txtPassword")).TypeText("pass");
            ie.Image(Find.ByName(new Regex(" [a-zA-Z0-9]*btnLogin"))).Click();
            this.LoggedIn = true;
        }


        [STAThread]

        static void Main(string[] args)
        {  // This is just a test project but there needs to be a Main method for compilation.
        }

        [TestFixtureTearDownAttribute]

        public void TearDown()
        {
            ie.Close();
        }
    }
}
