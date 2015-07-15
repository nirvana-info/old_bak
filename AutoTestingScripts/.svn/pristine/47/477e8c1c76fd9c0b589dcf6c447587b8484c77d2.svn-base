using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks._2010Spring6
{
    [TestFixture]
    public class S004_NewAcctTypeLandingPage_Module : SignIn
    {
        [Test]
        public void T01_NewAcctTypeLandingPage_BusinessAcct()
        {
            browser.GoTo(URL + "/c/business-accounts.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Image(Find.ByAlt("Zecco logo")).Src.Contains("logo_zecco_trading.jpg"));
            Assert.AreEqual(browser.Title.Trim(), "Business Trading Accounts – Zecco Trading");
            Assert.IsTrue(browser.Button(Find.BySrc("https://zecco.s3.amazonaws.com/images/landing/account_types/button_open_business_on.gif")).Exists);
        }

        [Test]
        public void T02_NewAcctTypeLandingPage_TrustAcct()
        {
            browser.GoTo(URL + "/c/trust-accounts.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Image(Find.ByAlt("Zecco logo")).Src.Contains("logo_zecco_trading.jpg"));
            Assert.AreEqual(browser.Title.Trim(), "Trade from your trust account - Zecco Trading");
            Assert.IsTrue(browser.Button(Find.BySrc("https://zecco.s3.amazonaws.com/images/landing/account_types/button_open_trust_on.gif")).Exists);
        }

        [Test]
        public void T03_NewAcctTypeLandingPage_CustodialAcct()
        {
            browser.GoTo(URL + "/c/custodial-accounts.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Image(Find.ByAlt("Zecco logo")).Src.Contains("logo_zecco_trading.jpg"));
            Assert.AreEqual(browser.Title.Trim(), "Coverdell and Custodial Accounts - Zecco Trading");
            Assert.IsTrue(browser.Button(Find.BySrc("https://zecco.s3.amazonaws.com/images/landing/account_types/button_minor_on.gif")).Exists);
        }
    }
}
