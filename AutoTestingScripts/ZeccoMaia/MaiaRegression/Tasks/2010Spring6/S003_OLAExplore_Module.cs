using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks._2010Spring6
{
    [TestFixture]
    public class S003_OLAExplore_Module : OLA
    {
        [Test]
        public void T01_OLAExplore_Forex()
        {
            this.GotoOLA();
            Assert.IsTrue(browser.CheckBox(Find.ById("Welcome_uxForex")).Exists);
            browser.CheckBox(Find.ById("Welcome_uxForex")).Checked = true;
            Assert.IsTrue(browser.RadioButton(Find.ById("Welcome_uxForexTrader")).Exists);
            Assert.IsTrue(browser.RadioButton(Find.ById("Welcome_uxMetaTrader")).Exists);
        }

        [Test]
        public void T02_OLAExplore_PaperAppLink()
        {
            this.GotoOLA();
        }

        [Test]
        public void T03_OLAExplore_PaperAppPageInfo()
        {
            this.GotoOLA();
            browser.Link(Find.ById("")).Click();
            browser.Button(Find.ById("submit-btn")).WaitUntilExists(20);
            Assert.IsTrue(browser.Link(Find.ByClass("logo")).Style.ToString().Trim().Contains("logo_topbar_zecco_trading.jpg"));
            Assert.AreEqual(browser.Title.Trim(), "Custodial, Corporate, Trust, and Other Account Applications");
            Assert.IsTrue(browser.ContainsText("Paper Applications"));
        }

        [Test]
        public void T04_OLAExplore_BusinessAccount()
        {
            this.GotoOLA();
            browser.Link(Find.ById("")).Click();
            browser.Button(Find.ById("submit-btn")).WaitUntilExists(20);
            Assert.IsTrue(browser.ContainsText("Business Accounts"));
            Assert.IsTrue(browser.ContainsText("Corporate"));
            Assert.IsTrue(browser.Link(Find.ById("linkcorporate")).Exists);
            Assert.IsTrue(browser.ContainsText("Partnership"));
            Assert.IsTrue(browser.Link(Find.ById("linkpartnership")).Exists);
            Assert.IsTrue(browser.ContainsText("LLC"));
            Assert.IsTrue(browser.Link(Find.ById("linkllc")).Exists);
        }

        [Test]
        public void T05_OLAExplore_TrustAccount()
        {
            this.GotoOLA();
            browser.Link(Find.ById("")).Click();
            browser.Button(Find.ById("submit-btn")).WaitUntilExists(20);
            Assert.IsTrue(browser.ContainsText("Trust Accounts"));
            Assert.IsTrue(browser.Link(Find.ById("linktrust")).Exists);
        }

        [Test]
        public void T06_OLAExplore_MinorsAccount()
        {
            this.GotoOLA();
            browser.Link(Find.ById("")).Click();
            browser.Button(Find.ById("submit-btn")).WaitUntilExists(20);
            Assert.IsTrue(browser.ContainsText("Accounts for Minors"));
            Assert.IsTrue(browser.ContainsText("Custodial (UTMA/UGMA)"));
            Assert.IsTrue(browser.Link(Find.ById("linkcustodial")).Exists);
            Assert.IsTrue(browser.ContainsText("Coverdell (Educational Savings)"));
            Assert.IsTrue(browser.Link(Find.ById("linkcoverdell")).Exists);
        }

        [Test]
        public void T07_OLAExplore_SubmitAppPageInfo()
        {
            this.GotoOLA();
            browser.Link(Find.ById("")).Click();
            browser.Button(Find.ById("submit-btn")).WaitUntilExists(20);
            browser.Button(Find.ById("submit-btn")).Click();
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxLeftContent_uxSignin")).WaitUntilExists(20);
            Assert.IsTrue(browser.Link(Find.ByClass("logo")).Style.ToString().Trim().Contains("logo_topbar_zecco_trading.jpg"));
            Assert.AreEqual(browser.Title.Trim(), "Submit a Paper Application");
            Assert.IsTrue(browser.ContainsText("Submit a Paper Application"));
            Assert.IsTrue(browser.ContainsText("Required Next Steps"));
        }
    }
}
