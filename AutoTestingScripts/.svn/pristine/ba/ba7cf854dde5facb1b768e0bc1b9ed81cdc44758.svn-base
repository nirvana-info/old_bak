using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks.SpringMaia1
{
    [TestFixture]
    public class S003_Homepage_Module : SignIn
    {
        [Test]
        public void T01_Homepage_NewDistribution()
        {
            this.LoginPortalAdmin();
            Assert.IsTrue(browser.Div(Find.ById("ctl00_uxMainContent_uxNewDistribution")).Exists);
        }

        [Test]
        public void T02_Homepage_SetDistribution()
        {
            this.LoginPortalAdmin();
            int row = 4;
            string page = string.Format("ctl00_uxMainContent_uxNewDistribution_ctl00_ctl0{0}_uxAvailableVersion", row);
            while (browser.Link(Find.ById(page)).Exists == true)
            {
                row += 2;
                page = string.Format("ctl00_uxMainContent_uxNewDistribution_ctl00_ctl0{0}_uxAvailableVersion", row);
            }
            decimal temp = 200 / (row - 6);
            decimal pct = Math.Floor(temp);
            for (int i = 4; i < row; i += 2)
            {
                string percent = string.Format("ctl00_uxMainContent_uxNewDistribution_ctl00_ctl0{0}_uxPercentage_text", i);
                browser.TextField(Find.ById(percent)).TypeText(pct.ToString());
            }
        }

        [Test]
        public void T03_Homepage_Lessthan100()
        {
            this.LoginPortalAdmin();
            Assert.IsTrue(browser.Span(Find.ById("validateTotal")).Text.Contains("All versions must add to 100%"));
        }

        [Test]
        public void T04_Homepage_VersionDate()
        {
            this.LoginPortalAdmin();
            Assert.IsTrue(browser.Link(Find.ById("ctl00_uxMainContent_uxDistributionList_ctl00_ctl04_uxHomepageVersion")).Exists);
        }

        [Test]
        public void T05_Homepage_DistributionDate()
        {
            this.LoginPortalAdmin();
            string date = browser.Span(Find.ById("ctl00_uxMainContent_uxDistributionList_ctl00_ctl04_uxDateStarted")).Text;
            Assert.AreEqual(date.Trim(), DateTime.Today.ToString("MM/dd/yyyy"));
        }

        [Test]
        public void T06_Homepage_SignIn()
        {
            this.LoginPortalAdmin();
            Assert.IsTrue(!string.IsNullOrEmpty(browser.Table(Find.ById("ctl00_uxMainContent_uxDistributionList_ctl00")).TableBodies[0].TableRows[0].TableCells[3].Text));
            Assert.IsTrue(!string.IsNullOrEmpty(browser.Table(Find.ById("ctl00_uxMainContent_uxDistributionList_ctl00")).TableBodies[0].TableRows[0].TableCells[4].Text));
        }

        [Test]
        public void T07_Homepage_SignUp()
        {
            this.LoginPortalAdmin();
            Assert.IsTrue(!string.IsNullOrEmpty(browser.Table(Find.ById("ctl00_uxMainContent_uxDistributionList_ctl00")).TableBodies[0].TableRows[0].TableCells[5].Text));
            Assert.IsTrue(!string.IsNullOrEmpty(browser.Table(Find.ById("ctl00_uxMainContent_uxDistributionList_ctl00")).TableBodies[0].TableRows[0].TableCells[6].Text));
        }

        [Test]
        public void T08_Homepage_StartApp()
        {
            this.LoginPortalAdmin();
            Assert.IsTrue(!string.IsNullOrEmpty(browser.Table(Find.ById("ctl00_uxMainContent_uxDistributionList_ctl00")).TableBodies[0].TableRows[0].TableCells[7].Text));
        }

        [Test]
        public void T09_Homepage_CompleteApp()
        {
            this.LoginPortalAdmin();
            Assert.IsTrue(!string.IsNullOrEmpty(browser.Table(Find.ById("ctl00_uxMainContent_uxDistributionList_ctl00")).TableBodies[0].TableRows[0].TableCells[8].Text));
            Assert.IsTrue(!string.IsNullOrEmpty(browser.Table(Find.ById("ctl00_uxMainContent_uxDistributionList_ctl00")).TableBodies[0].TableRows[0].TableCells[9].Text));
        }

        [Test]
        public void T10_Homepage_CSVFileLink()
        {
            this.LoginPortalAdmin();
            Assert.IsTrue(browser.Button(Find.ById("ctl00_uxMainContent_uxCSV")).Exists);
        }

        private void LoginPortalAdmin()
        {
            // if there already have a user login, do logout first
            if (browser.Link(Find.ByText("Sign Out")).Exists)
            {
                SignOut si = new SignOut();
                si.UserSignOut(browser);
            }
            if (browser.Link(Find.ById("ctl00_uxLoginView_uxLoginStatus")).Exists)
            {
                browser.Span(Find.ById("ctl00_uxSiteMapBreadCrumb")).Link(Find.ByText("Portal Admin")).Click();
                browser.Link(Find.ById("ctl00_uxLoginView_uxLoginStatus")).Click();
            }
            browser.GoTo(AdminUrl);
            browser.WaitForComplete();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxLogin_UserName")).TypeText(UN3);
            browser.TextField(Find.ById("ctl00_uxMainContent_uxLogin_Password")).TypeText(PW3);
            browser.Button(Find.ById("ctl00_uxMainContent_uxLogin_LoginButton")).Click();
            browser.WaitForComplete();
            browser.Div(Find.ById("ctl00_uxMainContent_uxHomePageAdministration")).Link(Find.ByText("Homepage Administration")).Click();
            browser.WaitForComplete();
        }
    }
}
