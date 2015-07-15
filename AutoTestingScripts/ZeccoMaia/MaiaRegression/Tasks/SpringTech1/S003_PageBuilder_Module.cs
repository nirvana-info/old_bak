using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks.SpringTech1
{
    [TestFixture]
    public class S003_PageBuilder_Module : SignIn
    {
        [Test]
        public void T01_PageBuilder_PageTitle()
        {
            this.LoginPortalAdmin();
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxContentTypeDropdown")).Option(Find.ByValue("3")).Select();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Span(Find.ById("ctl00_uxMainContent_uxHeaderLabel")).Text.Contains("Add New Content"));
        }

        [Test]
        public void T02_PageBuilder_URL()
        {
            this.LoginPortalAdmin();
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxContentTypeDropdown")).Option(Find.ByValue("3")).Select();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.TextField(Find.ById("ctl00_uxMainContent_uxPageName")).Exists);
        }

        [Test]
        public void T03_PageBuilder_URLInstruction()
        {
            this.LoginPortalAdmin();
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxContentTypeDropdown")).Option(Find.ByValue("3")).Select();
            System.Threading.Thread.Sleep(2000);
            Assert.AreEqual(browser.Span(Find.ById("ctl00_uxMainContent_uxFileExtension")).Text, ".aspx - Separate words with a dash, all lowercase");
        }

        [Test]
        public void T04_PageBuilder_HTMLTitle()
        {
            this.LoginPortalAdmin();
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxContentTypeDropdown")).Option(Find.ByValue("3")).Select();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.TextField(Find.ById("ctl00_uxMainContent_uxBrowserTitle")).Exists);
        }

        [Test]
        public void T05_PageBuilder_MetaKeyword()
        {
            this.LoginPortalAdmin();
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxContentTypeDropdown")).Option(Find.ByValue("3")).Select();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.TextField(Find.ById("ctl00_uxMainContent_uxKeywords")).Exists);
        }

        [Test]
        public void T06_PageBuilder_MetaDescription()
        {
            this.LoginPortalAdmin();
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxContentTypeDropdown")).Option(Find.ByValue("3")).Select();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.TextField(Find.ById("ctl00_uxMainContent_uxDescription")).Exists);
        }

        [Test]
        public void T07_PageBuilder_MetaKeywordInstruction()
        {
            this.LoginPortalAdmin();
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxContentTypeDropdown")).Option(Find.ByValue("3")).Select();
            System.Threading.Thread.Sleep(2000);
            Assert.AreEqual(browser.Span(Find.ById("ctl00_uxMainContent_uxKeywordsDescription")).Text, "Separate keywords with a comma");
        }

        [Test]
        public void T08_PageBuilder_ContentShell()
        {
            this.LoginPortalAdmin();
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxContentTypeDropdown")).Option(Find.ByValue("3")).Select();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.SelectList(Find.ById("ctl00_uxMainContent_uxPageContentShellType")).Exists);
        }

        [Test]
        public void T09_PageBuilder_Logo()
        {
            this.LoginPortalAdmin();
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxContentTypeDropdown")).Option(Find.ByValue("3")).Select();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.SelectList(Find.ById("ctl00_uxMainContent_uxPageLogoType")).Exists);
        }

        [Test]
        public void T10_PageBuilder_Navigation()
        {
            this.LoginPortalAdmin();
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxContentTypeDropdown")).Option(Find.ByValue("3")).Select();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.RadioButton(Find.ById("ctl00_uxMainContent_uxPageNavFooterType_0")).Exists);
            Assert.IsTrue(browser.RadioButton(Find.ById("ctl00_uxMainContent_uxPageNavFooterType_1")).Exists);
        }

        [Test]
        public void T11_PageBuilder_Compliance()
        {
            this.LoginPortalAdmin();
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxContentTypeDropdown")).Option(Find.ByValue("3")).Select();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.RadioButton(Find.ById("ctl00_uxMainContent_uxPageComplianceFooterType_0")).Exists);
            Assert.IsTrue(browser.RadioButton(Find.ById("ctl00_uxMainContent_uxPageComplianceFooterType_1")).Exists);
        }

        [Test]
        public void T12_PageBuilder_Cancel()
        {
            this.LoginPortalAdmin();
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxContentTypeDropdown")).Option(Find.ByValue("3")).Select();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Button(Find.ById("ctl00_uxMainContent_uxCancelButton")).Exists);
        }

        [Test]
        public void T13_PageBuilder_SaveContinue()
        {
            this.LoginPortalAdmin();
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxContentTypeDropdown")).Option(Find.ByValue("3")).Select();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Button(Find.ById("ctl00_uxMainContent_uxSavePageContentButton")).Exists);
        }

        [Test]
        public void T14_PageBuilder_NewPage()
        {
            this.LoginPortalAdmin();
            browser.SelectList(Find.ById("ctl00_uxMainContent_uxContentTypeDropdown")).Option(Find.ByValue("3")).Select();
            System.Threading.Thread.Sleep(2000);
            browser.TextField(Find.ById("ctl00_uxMainContent_uxPageName")).TypeText("AutoTestPage" + Date);
            browser.TextField(Find.ById("ctl00_uxMainContent_uxBrowserTitle")).TypeText("AutoTestPage" + Date);
            browser.TextField(Find.ById("ctl00_uxMainContent_uxKeywords")).TypeText("Auto");
            browser.TextField(Find.ById("ctl00_uxMainContent_uxDescription")).TypeText("AutoTestPage" + Date);
            browser.Button(Find.ById("ctl00_uxMainContent_uxSavePageContentButton")).Click();
            System.Threading.Thread.Sleep(2000);
            browser.TextField(Find.ById("ctl00_uxMainContent_uxRevisionBody")).TypeText("AutoTestPage" + Date);
            browser.TextField(Find.ById("ctl00_uxMainContent_uxRevisionComments")).TypeText("AutoTestPage" + Date);
            browser.Button(Find.ById("ctl00_uxMainContent_uxSaveButton")).Click();
            System.Threading.Thread.Sleep(5000);
            Assert.IsTrue(browser.Span(Find.ById("ctl00_uxMainContent_uxContentName")).Text.Contains("AutoTestPage" + Date));
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
            browser.Div(Find.ById("ctl00_uxMainContent_uxCreateNewContentPanel")).Link(Find.ByText("Create New Content")).Click();
            browser.WaitForComplete();
        }
    }
}
