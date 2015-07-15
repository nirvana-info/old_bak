using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;
using System.Text.RegularExpressions;

namespace MaiaRegression.Tasks.Spring3
{
    [TestFixture]
    public class S003_FieldValidation_Module : SignIn
    {
        //[Test]
        //public void T01_FieldValidation_Search()
        //{
        //    UserSignIn(UN, PW, false, 0);
        //    StringBuilder s = new StringBuilder();
        //    for (int i = 0; i < 65; i++)
        //    {
        //        s.Append("a");
        //    }
        //    browser.TextField(Find.ById("zeccoSymbolSearchInput")).TypeText(s.ToString());
        //    Assert.AreEqual(browser.TextField(Find.ById("zeccoSymbolSearchInput")).Text, s.ToString().Substring(0, 64));
        //}

        //[Test]
        //public void T02_FieldValidation_SymbolField()
        //{
        //    UserSignIn(UN, PW, false, 0);
        //    StringBuilder s = new StringBuilder();
        //    for (int i = 0; i < 9; i++)
        //    {
        //        s.Append("a");
        //    }
        //    browser.Link(Find.ByTitle("Quotes & Research")).Click();
        //    browser.WaitForComplete();
        //    browser.TextField(Find.ById("zeccoSymbolSearchInput")).TypeText(s.ToString());
        //    Assert.AreEqual(browser.TextField(Find.ById("zeccoSymbolSearchInput")).Text, s.ToString().Substring(0, 8));
        //}

        [Test]
        public void T03_FieldValidation_SignInUserName()
        {
            UserSignIn(UN, PW, false, 0);
            if (browser.Link(Find.ByText("Sign Out")).Exists)
            {
                SignOut si = new SignOut();
                si.UserSignOut(browser);
                browser.GoTo(targetHost);

                System.Threading.Thread.Sleep(10000);
            }
            browser.WaitForComplete();
            System.Threading.Thread.Sleep(10000);
            StringBuilder s = new StringBuilder();
            for (int i = 0; i < 65; i++)
            {
                s.Append("a");
            }
            browser.TextField("ctl00_ctl00_uxMainContent_uxRightColumn_uxDefaultLoginForm_uxUserName").TypeText(s.ToString());
            Assert.AreEqual(browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDefaultLoginForm_uxUserName")).Text, s.ToString().Substring(0, 64));
        }

        [Test]
        public void T04_FieldValidation_SignInPassword()
        {
            UserSignIn(UN, PW, false, 0);
            if (browser.Link(Find.ByText("Sign Out")).Exists)
            {
                SignOut si = new SignOut();
                si.UserSignOut(browser);
                browser.GoTo(targetHost);

                System.Threading.Thread.Sleep(10000);
            }
            System.Threading.Thread.Sleep(10000);
            browser.WaitForComplete();
            StringBuilder s = new StringBuilder();
            for (int i = 0; i < 17; i++)
            {
                s.Append("a");
            }
            browser.TextField("ctl00_ctl00_uxMainContent_uxRightColumn_uxDefaultLoginForm_uxPassword").TypeText(s.ToString());
            Assert.AreEqual(browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDefaultLoginForm_uxPassword")).Text, s.ToString().Substring(0, 16));
        }

        [Test]
        public void T05_FieldValidation_Thread()
        {
            UserSignIn(UN, PW, false, 0);
            browser.Link(Find.ByText("Community Profile")).Click();
            browser.Link(Find.ByText("Discussions")).Click();
            System.Threading.Thread.Sleep(20000);
            /*
            while (browser.Image(Find.BySrc(new Regex("spinner2.gif"))).Exists)
            {
                System.Threading.Thread.Sleep(1000);
            }
            */
            StringBuilder s = new StringBuilder();
            for (int i = 0; i < 65; i++)
            {
                s.Append("a");
            }
            browser.WaitForComplete();

            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxAddForumThread")).TypeText(s.ToString());
            Assert.AreEqual(browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxAddForumThread")).Text, s.ToString().Substring(0, 64));
        }

        [Test]
        public void T06_FieldValidation_EmailPrimary()
        {
            UserSignIn(UN, PW, false, 0);
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
            browser.WaitForComplete();
            browser.Link(Find.ByText("Change email address")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxEmailAddress")).WaitUntilExists(10);
            System.Threading.Thread.Sleep(10000);
            StringBuilder s = new StringBuilder();
            for (int i = 0; i < 65; i++)
            {
                s.Append("a");
            }
            browser.WaitForComplete();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxEmailAddress")).TypeText(s.ToString());
            Assert.AreEqual(browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxEmailAddress")).Text, s.ToString().Substring(0, 64));
        }

        [Test]
        public void T07_FieldValidation_EmailSecondary()
        {
            UserSignIn(UN, PW, false, 0);
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
            browser.WaitForComplete();
            browser.Link(Find.ByText("Change email address")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxEmailAddress")).WaitUntilExists(10);
            System.Threading.Thread.Sleep(10000);
            StringBuilder s = new StringBuilder();
            for (int i = 0; i < 65; i++)
            {
                s.Append("a");
            }
            browser.WaitForComplete();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxEmailAddress")).TypeText(s.ToString());
            Assert.AreEqual(browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxEmailAddress")).Text, s.ToString().Substring(0, 64));
        }

        [Test]
        public void T08_FieldValidation_ProfileBacisInfo()
        {
            UserSignIn(UN, PW, false, 0);
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
            browser.WaitForComplete();
            browser.Link(Find.ByText("Edit your profile")).Click();
            System.Threading.Thread.Sleep(20000);
            StringBuilder s = new StringBuilder();
            for (int i = 0; i < 151; i++)
            {
                s.Append("a");
            }
            browser.WaitForComplete();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxFavoriteStock")).TypeText(s.ToString());
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSaveBasicInfo")).Click();
            //Assert.IsTrue(browser.ContainsText("We're sorry, we were unable to send your message. Please try again with fewer than 140 characters"));
            Assert.AreEqual(browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxFavoriteStock")).Text, s.ToString().Substring(0, 150));
        }

        [Test]
        public void T09_FieldValidation_ProfilePersonInfo()
        {
            UserSignIn(UN, PW, false, 0);
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
            browser.WaitForComplete();
            browser.Link(Find.ByText("Edit your profile")).Click();
            browser.GoTo(URL+"/editmemberprofile.aspx?view=PersonalInfo");
            browser.Span(Find.ByText("Personal Profile")).Click();
            System.Threading.Thread.Sleep(10000);
            StringBuilder s0 = new StringBuilder();
            StringBuilder s = new StringBuilder();
            StringBuilder s1 = new StringBuilder();
            for (int i = 0; i < 1001; i++)
            {
                s0.Append("a");
            }
            browser.WaitForComplete();
            //browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxCity")).TypeText(s.ToString());
            //Assert.AreEqual(browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxCity")).Text, s.ToString().Substring(0, 100));
            System.Threading.Thread.Sleep(10000);
            s = new StringBuilder();
            for (int i = 0; i < 151; i++)
            {
                s.Append("a");
            }
            s1 = new StringBuilder();
            for (int i = 0; i < 501; i++)
            {
                s1.Append("a");
            }
            browser.WaitForComplete();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxBio")).TypeText(s0.ToString());
            
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxWebSites")).TypeText(s.ToString());
            
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxFavoriteBooks")).TypeText(s.ToString());
            
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxFavoriteWebsites")).TypeText(s.ToString());
            
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxInterests")).TypeText(s1.ToString());
            
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSignature")).TypeText(s.ToString());
            
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSavePersonalInfo")).Click();
            Assert.AreEqual(browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxBio")).Text, s0.ToString().Substring(0, 1000));
            Assert.AreEqual(browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxWebSites")).Text, s.ToString().Substring(0, 150));
            Assert.AreEqual(browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxFavoriteBooks")).Text, s.ToString().Substring(0, 150));
            Assert.AreEqual(browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxFavoriteWebsites")).Text, s.ToString().Substring(0, 150));
            Assert.AreEqual(browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxInterests")).Text, s1.ToString().Substring(0, 500));
            Assert.AreEqual(browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSignature")).Text, s.ToString().Substring(0, 150));
            //Assert.IsTrue(browser.ContainsText("We're sorry, we were unable to send your message. Please try again with fewer than 150 characters"));
        }

        [Test]
        public void T10_FieldValidation_ProfileInvestingOutlook()
        {
            UserSignIn(UN, PW, false, 0);
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
            browser.WaitForComplete();
            browser.Link(Find.ByText("Edit your profile")).Click();
            browser.GoTo(URL+"/editmemberprofile.aspx?view=InvestingOutlook");
            browser.Span(Find.ByText("Investor Profile")).Click();
            System.Threading.Thread.Sleep(10000);
            StringBuilder s = new StringBuilder();
            for (int i = 0; i < 451; i++)
            {
                s.Append("a");
            }
            browser.WaitForComplete();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxUSMarketsOutlook")).TypeText(s.ToString());
            
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxUSEconomyOutlook")).TypeText(s.ToString());
            
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxFedPolicyOutlook")).TypeText(s.ToString());
            
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxWorldMarketsOutlook")).TypeText(s.ToString());
            
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxWorldEconomyOutlook")).TypeText(s.ToString());
            
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSaveInvestingOutlook")).Click();
            Assert.AreEqual(browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxUSMarketsOutlook")).Text, s.ToString().Substring(0, 450));
            Assert.AreEqual(browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxUSEconomyOutlook")).Text, s.ToString().Substring(0, 450));
            Assert.AreEqual(browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxFedPolicyOutlook")).Text, s.ToString().Substring(0, 450));
            Assert.AreEqual(browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxWorldMarketsOutlook")).Text, s.ToString().Substring(0, 450));
            Assert.AreEqual(browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxWorldEconomyOutlook")).Text, s.ToString().Substring(0, 450));
            //Assert.IsTrue(browser.ContainsText("We're sorry, we were unable to send your message. Please try again with fewer than 140 characters"));
        }
    }
}
