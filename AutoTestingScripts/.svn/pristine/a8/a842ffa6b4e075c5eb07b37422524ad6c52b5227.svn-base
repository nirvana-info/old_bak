using System;
using System.Collections.Generic;
using System.Text;
using System.Threading;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;
using System.Text.RegularExpressions;
///////////////////////////////////////
/*** author:bobby  date:2009/11/4  ***/
/*** modify by:    date            ***/
/***                               ***/
///////////////////////////////////////


namespace MaiaRegression.Tasks.Spring5
{
    [TestFixture]
    public class S005_Search_Generic : SignIn
    {
        [Test]
        public void T01_Member_Match()
        {

            UserSignIn(UN, PW, false, 0);
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl04_uxSubNavRepeater_ctl02_uxSubNavLink")).Click();
            //browser.WaitUntilContainsText("Advanced Search Options");
            System.Threading.Thread.Sleep(10000);
            /*
            while (browser.Image(Find.BySrc(new Regex("spinner2.gif"))).Exists)
            {
                System.Threading.Thread.Sleep(5000);
            }
            */
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxScreenName")).TypeText("tonyleach");
            browser.WaitForComplete(30);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSimpleSearch")).Click();
            Thread.Sleep(200);
            //search with username from member search
            Assert.IsTrue(browser.Image(Find.ById("uxPostRankImage")).Exists);
            Thread.Sleep(10000);
            Assert.IsFalse(browser.Link(Find.ByText("percyzhao1")).Exists);
        }

        [Test]
        public void T02_Groups_Match()
        {

            UserSignIn(UN, PW, false, 0);
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl04_uxSubNavRepeater_ctl03_uxSubNavLink")).Click();
            browser.WaitUntilContainsText("Groups Found");
            System.Threading.Thread.Sleep(10000);
            /*
            while (browser.Image(Find.BySrc(new Regex("spinner2.gif"))).Exists)
            {
                System.Threading.Thread.Sleep(5000);
            }*/
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSearchBar")).TypeText("Zecco Associates");
            browser.WaitForComplete(30);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSearch")).Click();
            browser.WaitUntilContainsText("[1] Groups Found");
            //search by group
            Assert.IsTrue(browser.Link(Find.ByText("Zecco Associates")).Exists);
            Thread.Sleep(1000);
            Assert.IsFalse(browser.Link(Find.ByText("zhoujun")).Exists);
            Assert.IsFalse(browser.Link(Find.ByText("Bottom Fishing")).Exists);
            Assert.IsFalse(browser.Link(Find.ByText("close group")).Exists);
            Assert.IsFalse(browser.Link(Find.ByText("eew3")).Exists);
            Assert.IsFalse(browser.Link(Find.ByText("aad")).Exists);


            
        }

        [Test]
        public void T03_Member_Unsignin()
        {
            if (browser.Link(Find.ByText("Sign Out")).Exists == true)
            {
                browser.Link(Find.ByText("Sign Out")).Click();
            }
            
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl04_uxSubNavRepeater_ctl02_uxSubNavLink")).Click();
            browser.WaitUntilContainsText("Sign up now");
            //verify unsignin user, can not search
            Assert.IsTrue(browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxLoginForm_uxUserName")).Exists);
            
        }

        [Test]
        public void T04_Member_Match_Picture()
        {
            browser.GoTo(targetHost);
            UserSignIn(UN, PW, false, 0);
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl04_uxSubNavRepeater_ctl02_uxSubNavLink")).Click();
            //browser.WaitUntilContainsText("Advanced Search Options");
            System.Threading.Thread.Sleep(10000);
            /*
            while (browser.Image(Find.BySrc(new Regex("spinner2.gif"))).Exists)
            {
                System.Threading.Thread.Sleep(5000);
            }
            */
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxScreenName")).TypeText("tonyleach");
            browser.WaitForComplete(30);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSimpleSearch")).Click();
            Thread.Sleep(200);

            Assert.IsTrue(browser.Image(Find.ById("uxPostRankImage")).Exists);
            Thread.Sleep(1000);
            //verify serarch result's picture whether match user
            browser.Image(Find.ById("uxMemberProfilePicture")).Click();
            browser.Link(Find.ById("uxMemberPostsLink")).WaitUntilExists();
            string l1 = browser.Image(Find.ById("uxMemberProfilePicture")).Src;
            string l3 = l1.Trim().Substring(57, 5);
            Assert.AreEqual("40855",l3);
        }

        [Test]
        public void T05_Member_Match_Screenname()
        {
            UserSignIn(UN, PW, false, 0);
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl04_uxSubNavRepeater_ctl02_uxSubNavLink")).Click();
            //browser.WaitUntilContainsText("Advanced Search Options");
            System.Threading.Thread.Sleep(10000);
            /*
            while (browser.Image(Find.BySrc(new Regex("spinner2.gif"))).Exists)
            {
                System.Threading.Thread.Sleep(5000);
            }*/
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxScreenName")).TypeText("tonyleachsf");
            browser.WaitForComplete(30);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSimpleSearch")).Click();
            Thread.Sleep(200);
            //verify serarch result's screen whether match user
            Assert.IsTrue(browser.Image(Find.ById("uxPostRankImage")).Exists);
            Thread.Sleep(1000);

            browser.Link(Find.ByText("tonyleachsf")).Click();
            browser.Link(Find.ById("uxMemberPostsLink")).WaitUntilExists();
            string l1 = browser.Image(Find.ById("uxMemberProfilePicture")).Src;
            string l3 = l1.Trim().Substring(57, 5);
            Assert.AreEqual("40855", l3);
        }

        [Test]
        public void T06_Member_Match_Url()
        {
            UserSignIn(UN, PW, false, 0);
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl04_uxSubNavRepeater_ctl02_uxSubNavLink")).Click();
            //browser.WaitUntilContainsText("Advanced Search Options");
            System.Threading.Thread.Sleep(10000);
            /*
            while (browser.Image(Find.BySrc(new Regex("spinner2.gif"))).Exists)
            {
                System.Threading.Thread.Sleep(5000);
            }*/

            //url incloud username to do search
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxScreenName")).TypeText("<a href=http://www.percyzhao1.com>percyzhao</a>");
            browser.WaitForComplete(30);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSimpleSearch")).Click();
            Thread.Sleep(2000);
            browser.Link(Find.ByText("percyzhao")).WaitUntilExists();
            Assert.IsTrue(browser.Link(Find.ByText("percyzhao")).Exists);
            //script incloud username to do search
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxScreenName")).TypeText("<i>percyzhao</i>");
            browser.WaitForComplete(30);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSimpleSearch")).Click();
            Thread.Sleep(2000);
            browser.Link(Find.ByText("percyzhao")).WaitUntilExists();
            Assert.IsTrue(browser.Link(Find.ByText("percyzhao")).Exists);
            
        }

        [Test]
        public void T07_Member_Match_Fullname()
        {
            //do search by full name
            UserSignIn(UN, PW, false, 0);
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl04_uxSubNavRepeater_ctl02_uxSubNavLink")).Click();
            //browser.WaitUntilContainsText("Advanced Search Options");
            System.Threading.Thread.Sleep(10000);
            /*
            while (browser.Image(Find.BySrc(new Regex("spinner2.gif"))).Exists)
            {
                System.Threading.Thread.Sleep(5000);
            }*/

            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxScreenName")).TypeText("tonyleachsf");
            browser.WaitForComplete(30);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSimpleSearch")).Click();
            Thread.Sleep(2000);

            Assert.IsTrue(browser.Link(Find.ByText("tonyleachsf")).Exists);
           

        }

        [Test]
        public void T08_Member_Match_Partialname()
        {
            //do search by part name
            UserSignIn(UN, PW, false, 0);
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl04_uxSubNavRepeater_ctl02_uxSubNavLink")).Click();
            //browser.WaitUntilContainsText("Advanced Search Options");
            System.Threading.Thread.Sleep(10000);
            /*
            while (browser.Image(Find.BySrc(new Regex("spinner2.gif"))).Exists)
            {
                System.Threading.Thread.Sleep(5000);
            }
            */
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxScreenName")).TypeText("tony");
            browser.WaitForComplete(30);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSimpleSearch")).Click();
            Thread.Sleep(2000);

            Assert.IsTrue(browser.Link(Find.ByText("tonyleachsf")).Exists);
        }

        [Test]
        public void T09_Member_Moresymbols()
        {
            UserSignIn(UN, PW, false, 0);
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl04_uxSubNavRepeater_ctl02_uxSubNavLink")).Click();
            Thread.Sleep(15000);
            //browser.WaitUntilContainsText("Advanced Search Options");
            System.Threading.Thread.Sleep(10000);
            /*
            while (browser.Image(Find.BySrc(new Regex("spinner2.gif"))).Exists)
            {
                System.Threading.Thread.Sleep(5000);
            }
            */
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPortfolio")).TypeText("aa,bb,cc,dd,ee,ff,gg,hh,ii,jj,kk");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSimpleSearch")).Click();
            //verify no more than 10 symbols separated with commmas
            string l7 = browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPortfolio")).Value;
            
            browser.WaitForComplete(30);
            Assert.AreNotEqual("aa,bb,cc,dd,ee,ff,gg,hh,ii,jj,kk", l7);
            
        }

        [Test]
        public void T10_Member_Tensymbols_search()
        {
            //verify 10 symbols separated with commmas to do search, if them are not existing,can not by search
            UserSignIn(UN, PW, false, 0);
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl04_uxSubNavRepeater_ctl02_uxSubNavLink")).Click();
            Thread.Sleep(15000);
            //browser.WaitUntilContainsText("Advanced Search Options");
            System.Threading.Thread.Sleep(10000);
            /*
            while (browser.Image(Find.BySrc(new Regex("spinner2.gif"))).Exists)
            {
                System.Threading.Thread.Sleep(5000);
            }
            */
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxPortfolio")).TypeText("aa,bb,cc,dd,ee,ff,gg,hh,ii,jj,kk");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSimpleSearch")).Click();
            Assert.IsTrue(browser.Span(Find.ByText("No members found.")).Exists);

        }

        [Test]
        public void T11_Member_SearchByCountry()
        {
            UserSignIn(UN, PW, false, 0);
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
            browser.Link(Find.ByText("Edit your profile")).Click();
            browser.GoTo(targetHost + "/editmemberprofile.aspx?view=PersonalInfo");
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxCountry_Select")).WaitUntilExists(20);
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxCountry_Select")).Option(Find.ByValue("3")).Select();
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSavePersonalInfo")).Click();
            Thread.Sleep(2000);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl04_uxSubNavRepeater_ctl02_uxSubNavLink")).Click();
            browser.WaitUntilContainsText("Advanced Search Options");
            Thread.Sleep(2000);
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxCountry_Select")).Option(Find.ByValue("3")).Select();
            //browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxScreenName")).TypeText("tonyleach");
            //browser.WaitForComplete(30);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSimpleSearch")).Click();
            Thread.Sleep(5000);
            Assert.IsTrue(browser.Link(Find.ByText("tonyleachsf")).Exists);
        }

        [Test]
        public void T12_Member_SearchByAge()
        {
            UserSignIn(UN, PW, false, 0);
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
            browser.Link(Find.ByText("Edit your profile")).Click();
            browser.GoTo(targetHost + "/editmemberprofile.aspx?view=PersonalInfo");
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxDateInput")).WaitUntilExists(20);
            Assert.IsTrue(browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxDateInput")).Exists);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxDateInput")).TypeText("01/01/1940");
            if (browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxNotDisplayAge")).Checked == true)
            {
                browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxNotDisplayAge")).Checked = true;
            }
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSavePersonalInfo")).Click();
            Thread.Sleep(2000);
            browser.Link(Find.ByText("Community Profile")).Click();
            browser.Link(Find.ById("uxInforViewAll")).Click();
            Assert.IsTrue(browser.ContainsText("71"));
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl04_uxSubNavRepeater_ctl02_uxSubNavLink")).Click();
            browser.WaitUntilContainsText("Advanced Search Options");
            Thread.Sleep(2000);
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxAge")).Option(Find.ByValue("7")).Select();
            //browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxScreenName")).TypeText("tonyleach");
            browser.WaitForComplete(30);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSimpleSearch")).Click();
            Thread.Sleep(5000);
            Assert.IsTrue(browser.Link(Find.ByText("tonyleachsf")).Exists);
        }

        [Test]
        public void T13_Member_SearchByGender()
        {
            UserSignIn(UN, PW, false, 0);
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
            browser.Link(Find.ByText("Edit your profile")).Click();
            browser.GoTo(targetHost + "/editmemberprofile.aspx?view=PersonalInfo");
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxGender")).WaitUntilExists(20);
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxGender")).Option(Find.ByValue("1")).Select();
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSavePersonalInfo")).Click();
            Thread.Sleep(2000);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl04_uxSubNavRepeater_ctl02_uxSubNavLink")).Click();
            browser.WaitUntilContainsText("Advanced Search Options");
            Thread.Sleep(2000);
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxGender_Select")).Option(Find.ByValue("1")).Select();
            //browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxScreenName")).TypeText("tonyleach");
            browser.WaitForComplete(30);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSimpleSearch")).Click();
            Thread.Sleep(5000);
            Assert.IsTrue(browser.Link(Find.ByText("tonyleachsf")).Exists);
        }
    }
}
