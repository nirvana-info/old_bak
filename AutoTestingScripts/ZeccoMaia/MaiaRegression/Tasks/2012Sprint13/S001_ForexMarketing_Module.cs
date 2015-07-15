using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks._2012Sprint13
{
    [TestFixture]
    public class S001_ForexMarketing_Module : SignIn
    {
        [Test]
        public void T01_ForexMarketing_Landing1_Logo()
        {
            browser.GoTo(URL + "/forex/open-practice-account.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Image(Find.ByAlt("Zecco logo")).Src.Contains("/logo_forex.jpg"));
        }

        [Test]
        public void T02_ForexMarketing_Landing1_Title()
        {
            browser.GoTo(URL + "/forex/open-practice-account.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Title.Contains("Open a Free Practice Forex Account - Zecco Forex"));
        }

        [Test]
        public void T03_ForexMarketing_Landing1_Form()
        {
            browser.GoTo(URL + "/forex/open-practice-account.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Div(Find.ByClass("PracticeSignUp")).Exists);
        }

        [Test]
        public void T04_ForexMarketing_Landing2_Logo()
        {
            browser.GoTo(URL + "/forex/open-account.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Image(Find.ByAlt("Zecco logo")).Src.Contains("/logo_forex.jpg"));
        }

        [Test]
        public void T05_ForexMarketing_Landing2_Title()
        {
            browser.GoTo(URL + "/forex/open-account.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Title.Contains("Open a Forex Account - Zecco Forex"));
        }

        [Test]
        public void T06_ForexMarketing_Landing2_Form()
        {
            browser.GoTo(URL + "/forex/open-account.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Div(Find.ByClass("PracticeSignUp")).Exists);
        }
    }
}
