using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks._2011Sprint12
{
    [TestFixture]
    public class S001_Simplexity_Module : SignIn
    {
        [Test]
        public void T01_Simplexity_FreeAndroid_Title()
        {
            browser.GoTo(URL + "/free-android.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Title.Contains("Free Android Mobile Phone from Zecco"));
        }

        [Test]
        public void T02_Simplexity_FreeAndroid_Logo()
        {
            browser.GoTo(URL + "/free-android.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Image(Find.ById("Branding")).Src.Contains("logo_zecco.jpg"));
        }

        [Test]
        public void T03_Simplexity_FreeAndroid_Button()
        {
            browser.GoTo(URL + "/free-android.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Element(Find.ByClass("New-Customer-Button")).Exists);
            Assert.IsTrue(browser.Element(Find.ByClass("Exist-Customer-Button")).Exists);
        }

        [Test]
        public void T04_Simplexity_FreeAndroidPhone_Title()
        {
            browser.GoTo(URL + "/free-android-phone.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Title.Contains("Free Android Mobile Phone from Zecco"));
        }

        [Test]
        public void T05_Simplexity_FreeAndroidPhone_Logo()
        {
            browser.GoTo(URL + "/free-android-phone.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Image(Find.ById("Branding")).Src.Contains("logo_zecco.jpg"));
        }

        [Test]
        public void T06_Simplexity_FreeAndroidPhone_Button()
        {
            browser.GoTo(URL + "/free-android-phone.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Element(Find.ByClass("New-Customer-Button")).Exists);
        }
    }
}
