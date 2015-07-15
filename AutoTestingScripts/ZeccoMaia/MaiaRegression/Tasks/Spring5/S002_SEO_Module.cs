using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks.Spring5
{
    [TestFixture]
    public class S002_SEO_Module : SignIn
    {
        [Test]
        public void T01_SEO_SearchBar()
        {
            this.GotoFooterAdmin();
            if ((browser.TextField(Find.ById("ctl00_uxMainContent_uxKeyWord")).Exists == true) && 
                (browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Exists == true))
            {
                Assert.IsTrue(true);
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T02_SEO_SearchButton()
        {
            this.GotoFooterAdmin();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxKeyWord")).TypeText(@"/faq");
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
            Assert.IsTrue(browser.Div(Find.ByClass("footerpage")).Exists);
        }

        [Test]
        public void T03_SEO_Select()
        {
            this.GotoFooterAdmin();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxKeyWord")).TypeText(@"/faq");
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
            if (browser.Div(Find.ByClass("footerpage")).Tables[0].TableRows[1].TableCells[0].Text.Contains(@"/faq"))
            {
                browser.CheckBox(Find.ById("pixelBox27")).Checked = true;
                browser.Button(Find.ByValue("Save")).Click();
                Assert.IsTrue(browser.Span(Find.ById("ctl00_uxMainContent_uxMessageSuccess")).Text.Contains("You have successfully saved this content."));
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T04_SEO_Content()
        {
            this.GotoFooterAdmin();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxKeyWord")).TypeText(@"/faq");
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
            browser.Link(Find.ByText("MARGIN")).Click();
            Assert.IsTrue(browser.Span(Find.ById("ctl00_uxMainContent_uxHeaderLabel")).Text.Contains("Edit Content Info"));
        }

        [Test]
        public void T05_SEO_ContentSave()
        {
            this.GotoFooterAdmin();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxKeyWord")).TypeText(@"/faq");
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
            browser.Link(Find.ByText("MARGIN")).Click();
            browser.Button(Find.ById("ctl00_uxMainContent_uxSaveContentButton")).WaitUntilExists(10);
            browser.Button(Find.ById("ctl00_uxMainContent_uxSaveContentButton")).Click();
            Assert.IsTrue(browser.Span(Find.ById("ctl00_uxMainContent_uxSuccessMessage")).Text.Contains("Edit information is successful."));
        }

        [Test]
        public void T06_SEO_ContentCancel()
        {
            this.GotoFooterAdmin();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxKeyWord")).TypeText(@"/faq");
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
            browser.Link(Find.ByText("MARGIN")).Click();
            browser.Button(Find.ById("ctl00_uxMainContent_uxCancelButton")).WaitUntilExists(10);
            browser.Button(Find.ById("ctl00_uxMainContent_uxCancelButton")).Click();
            Assert.IsTrue(browser.Div(Find.ById("ctl00_uxMainContent_uxContentsGridView")).Exists);
        }

        [Test]
        public void T07_SEO_SelectAll()
        {
            this.GotoFooterAdmin();
            browser.TextField(Find.ById("ctl00_uxMainContent_uxKeyWord")).TypeText(@"/faq");
            browser.Button(Find.ById("ctl00_uxMainContent_uxSearch")).Click();
            if (browser.Div(Find.ByClass("footerpage")).Tables[0].TableRows[1].TableCells[0].Text.Contains(@"/faq"))
            {
                browser.Div(Find.ByClass("footerpage")).Tables[0].TableRows[0].Link(Find.ByText("select all")).Click();
                for (int i = 1; i < browser.Div(Find.ByClass("footerpage")).Tables[0].TableRows.Count - 2; i++)
                {
                    if (browser.Div(Find.ByClass("footerpage")).Tables[0].TableRows[i].TableCells[1].CheckBoxes[0].Checked == false)
                    {
                        Assert.IsTrue(false);
                        return;
                    }
                }
                Assert.IsTrue(browser.Div(Find.ByClass("footerpage")).Tables[0].TableRows[0].Link(Find.ByText("clear this pixel")).Exists);
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        private void GotoFooterAdmin()
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
            browser.Div(Find.ById("ctl00_uxMainContent_uxFooterAdmin")).Link(Find.ByText("Footer Admin")).Click();
            browser.WaitForComplete();
        }
    }
}
