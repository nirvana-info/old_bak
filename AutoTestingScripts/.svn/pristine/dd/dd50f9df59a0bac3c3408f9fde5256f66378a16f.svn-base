using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks._2010Spring6
{
    [TestFixture]
    public class S001_PricingReferences_Module : SignIn
    {
        [Test]
        public void T01_PricingReferences_NavigationFooter()
        {
            browser.GoTo(URL);
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Div(Find.ById("ctl00_ctl00_uxPostContent_uxBottomNavigation_uxFooterLinks")).Element(Find.ByAlt("facebook")).Exists);
            Assert.IsTrue(browser.Div(Find.ById("ctl00_ctl00_uxPostContent_uxBottomNavigation_uxFooterLinks")).Element(Find.ByAlt("twitter")).Exists);
        }

        [Test]
        public void T02_PricingReferences_ComplianceFooter()
        {
            browser.GoTo(URL);
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Link(Find.ByText("Zecco Privacy Policy")).Url.Contains("/forms/privacy-policy/downloadform.aspx"));
            Assert.IsTrue(browser.Link(Find.ByText("Zecco Terms of Service")).Url.Contains("/forms/terms-of-service/downloadform.aspx"));
            Assert.IsTrue(browser.Link(Find.ByText("Zecco Trading User Agreement")).Url.Contains("/forms/user-agreement/downloadform.aspx"));
            Assert.IsTrue(browser.Link(Find.ByText("Zecco Trading Business Continuity")).Url.Contains("/forms/business-continuity-statement/downloadform.aspx"));
        }

        [Test]
        public void T03_PricingReferences_AboutUs()
        {
            browser.GoTo(URL + "/aboutus/");
            System.Threading.Thread.Sleep(2000);
            Assert.AreEqual(browser.Title.Trim(), "About Zecco, Zecco Trading, and Zecco Forex – Company Information");
        }

        [Test]
        public void T04_PricingReferences_OptionEducationFooter()
        {
            browser.GoTo(URL + "/education/options/call.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.ContainsText("These examples omit the costs associated with trading options, and you'll need to figure that into your overall returns."));
            Assert.IsTrue(browser.ContainsText("At Zecco Trading, options commissions are just $4.95 per trade plus $0.65 per contract."));

            browser.GoTo(URL + "/education/options/bull-call-spread.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.ContainsText("These examples omit the costs associated with trading options, and you'll need to figure that into your overall returns."));
            Assert.IsTrue(browser.ContainsText("At Zecco Trading, options commissions are just $4.95 per trade plus $0.65 per contract."));

            browser.GoTo(URL + "/education/options/put.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.ContainsText("These examples omit the costs associated with trading options, and you'll need to figure that into your overall returns."));
            Assert.IsTrue(browser.ContainsText("At Zecco Trading, options commissions are just $4.95 per trade plus $0.65 per contract."));

            browser.GoTo(URL + "/education/options/bear-put-spread.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.ContainsText("These examples omit the costs associated with trading options, and you'll need to figure that into your overall returns."));
            Assert.IsTrue(browser.ContainsText("At Zecco Trading, options commissions are just $4.95 per trade plus $0.65 per contract."));

            browser.GoTo(URL + "/education/options/covered-call.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.ContainsText("These examples omit the costs associated with trading options, and you'll need to figure that into your overall returns."));
            Assert.IsTrue(browser.ContainsText("At Zecco Trading, options commissions are just $4.95 per trade plus $0.65 per contract."));

            browser.GoTo(URL + "/education/options/straddles.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.ContainsText("These examples omit the costs associated with trading options, and you'll need to figure that into your overall returns."));
            Assert.IsTrue(browser.ContainsText("At Zecco Trading, options commissions are just $4.95 per trade plus $0.65 per contract."));

            browser.GoTo(URL + "/education/options/strangles.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.ContainsText("These examples omit the costs associated with trading options, and you'll need to figure that into your overall returns."));
            Assert.IsTrue(browser.ContainsText("At Zecco Trading, options commissions are just $4.95 per trade plus $0.65 per contract."));

            browser.GoTo(URL + "/education/options/butterfly-spread.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.ContainsText("These examples omit the costs associated with trading options, and you'll need to figure that into your overall returns."));
            Assert.IsTrue(browser.ContainsText("At Zecco Trading, options commissions are just $4.95 per trade plus $0.65 per contract."));

            browser.GoTo(URL + "/education/options/how-to-trade.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.ContainsText("These examples omit the costs associated with trading options, and you'll need to figure that into your overall returns."));
            Assert.IsTrue(browser.ContainsText("At Zecco Trading, options commissions are just $4.95 per trade plus $0.65 per contract."));
        }

        [Test]
        public void T05_PricingReferences_EducationIRA()
        {
            browser.GoTo(URL);
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl03_uxSubNavRepeater_ctl11_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ByTitle("Retirement")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.AreEqual(browser.Title.Trim(), "IRA investment education – Zecco Trading");
        }

        [Test]
        public void T06_PricingReferences_EducationIRADiversification()
        {
            browser.GoTo(URL);
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl03_uxSubNavRepeater_ctl11_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ByTitle("Retirement")).Click();
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ByText("Diversify with ETFs")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.AreEqual(browser.Title.Trim(), "Diversify your retirement account with ETFs – Zecco Trading");
        }

        [Test]
        public void T07_PricingReferences_EducationInvestingTips()
        {
            browser.GoTo(URL);
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl03_uxSubNavRepeater_ctl11_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ByTitle("Online Investing Tips")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.AreEqual(browser.Title.Trim(), "Online stock and investment information - Investing in stocks online – Zecco Trading");
        }

        [Test]
        public void T08_PricingReferences_EducationBrokerage()
        {
            browser.GoTo(URL);
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl03_uxSubNavRepeater_ctl11_uxSubNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ByTitle("Selecting an Online Broker")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.AreEqual(browser.Title.Trim(), "Selecting the best online broker for you – Zecco Trading");
        }

        [Test]
        public void T09_PricingReferences_Homepage()
        {
            browser.GoTo(URL + "/homepages/trading-sign-in.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.AreEqual(browser.Title.Trim(), "Online stock brokerage - low cost Stock trades & options trades - Zecco Trading");
        }

        [Test]
        public void T10_PricingReferences_LandingRaF()
        {
            browser.GoTo(URL + "/refer-friends.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.AreEqual(browser.Title.Trim(), "Online Broker Refer A Friend – $75/Referral - Zecco Trading");
            Assert.IsTrue(browser.Button(Find.ByClass("raf-button")).Exists);
            Assert.IsTrue(browser.Link(Find.ByText("Refer Friends")).Exists);
        }

        [Test]
        public void T11_PricingReferences_PageRedirects()
        {
            browser.GoTo(URL + "/explore/");
            System.Threading.Thread.Sleep(2000);
            Assert.AreEqual(browser.Url, URL + "/explore/why-zecco.aspx");

            browser.GoTo(URL + "/explore/ira.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.AreEqual(browser.Url, URL + "/explore/ira-accounts.aspx");

            browser.GoTo(URL + "/explore/trading-tools.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.AreEqual(browser.Url, URL + "/explore/free-stock-trading-tools.aspx");

            browser.GoTo(URL + "/help/free-trades.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.AreEqual(browser.Url, URL + "/help/pricing.aspx");
        }

        [Test]
        public void T12_PricingReferences_PageDelete()
        {
            browser.GoTo(URL + "/trading/tradeexecution.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.AreEqual(browser.Url, URL + "/explore/why-zecco.aspx");

            browser.GoTo(URL + "/AboutUs/FreeTradingBusinessModel.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.AreEqual(browser.Url, URL + "/explore/why-zecco.aspx");

            browser.GoTo(URL + "/AboutUs/Stability.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.AreEqual(browser.Url, URL + "/explore/why-zecco.aspx");

            browser.GoTo(URL + "/AboutUs/WelcomeToZecco.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.AreEqual(browser.Url, URL + "/explore/why-zecco.aspx");

            browser.GoTo("tradingservices.zecco.com/ZeccoIRA.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.AreEqual(browser.Url, "https://www.zecco.com/explore/ira-accounts.aspx");

            browser.GoTo(URL + "/landing/search/search2/Default.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.AreEqual(browser.Url, URL + "/explore/why-zecco.aspx");

            browser.GoTo(URL + "/landing/search/search9/Default.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.AreEqual(browser.Url, URL + "/explore/why-zecco.aspx");

            browser.GoTo(URL + "/plugin/benzinga-zap-demo.htm");
            System.Threading.Thread.Sleep(2000);
            Assert.AreEqual(browser.Url, URL + "/zaptrade/");

            browser.GoTo(URL + "/Trading/FundingHelp.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.AreEqual(browser.Url, URL + "/help/funding.aspx");

            browser.GoTo(URL + "/c/free-stock-trading-01.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.AreEqual(browser.Url, URL + "/c/search2.aspx");

            browser.GoTo(URL + "/c/low-cost-stock-trading-10.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.AreEqual(browser.Url, URL + "/c/search2.aspx");

            browser.GoTo(URL + "/c/free-stock-trading02.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.AreEqual(browser.Url, URL + "/c/search2.aspx");

            browser.GoTo(URL + "/c/free-stock-trading03.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.AreEqual(browser.Url, URL + "/c/search2.aspx");

            browser.GoTo(URL + "/c/street01.aspx");
            System.Threading.Thread.Sleep(2000);
            Assert.AreEqual(browser.Url, URL + "/zaptrade/");
        }
    }
}
