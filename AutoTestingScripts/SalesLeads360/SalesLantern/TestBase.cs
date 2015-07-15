
using System;

using NUnit.Framework;

using WatiN.Core;

using System.Text.RegularExpressions;
using System.Threading;




namespace SalesLantern

{

    public abstract class TestBase

  {

    protected IE ie = null;

    private bool logged = false;

 

    protected bool LoggedIn

    {

      get { return logged; }

      set { logged = value; }

    }

 

    [TestFixtureSetUpAttribute]

    public void SetUp()

    {
      //System.Threading.Thread.CurrentThread.ApartmentState = System.Threading.ApartmentState.STA;
      ie = new IE();

    }

 

    protected void Login()

    {

 
      this.LoggedIn = true;

    }

 

    [STAThread]

    static void Main(string[] args)

    {

      // This is just a test project but there needs to be a Main method for compilation.

    }

 

    [TestFixtureTearDownAttribute]

    public void TearDown()

    {

      //ie.Close();

    }

  }

}

