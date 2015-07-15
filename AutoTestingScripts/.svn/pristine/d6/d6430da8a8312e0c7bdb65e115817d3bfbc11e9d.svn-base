using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks.Spring5
{
    [TestFixture]
    public class S002_SEO_Module_2 : SignIn
    {
        [Test]
        public void T01_Footer_ZeccoShare()
        {
            UserSignIn(UN, PW, false, 2);
            browser.GoTo(targetHost + "/editmemberprofile.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("community"));

            browser.GoTo(targetHost + "/editmemberprofile.aspx?view=PersonalBlog");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("community"));

            browser.GoTo(targetHost + "/blogs.aspx");
            System.Threading.Thread.Sleep(10000);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxGoToZeccoBlog")).Click();
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("community"));
        }

        [Test]
        public void T02_Footer_FormZeccoTrading()
        {
            UserSignIn(UN, PW, false, 2);
            browser.GoTo(targetHost + "/forms/margin.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("margin"));

            browser.GoTo(targetHost + "/forms/options.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("options"));
        }

        [Test]
        public void T03_Footer_Help()
        {
            //UserSignIn(UN, PW, false, 2);
            browser.GoTo(targetHost + "/help/");
            System.Threading.Thread.Sleep(10000);
            browser.WaitUntilContainsText("Help Center");
            //string tt = browser.Link(Find.ByUrl(targetHost + "/Forms/Zecco Trading Margin Account Disclosure/DownloadForm.aspx")).TextBefore;
            //Console.WriteLine(tt);
            Assert.IsTrue(browser.Link(Find.ByUrl(targetHost + "/Forms/Zecco Trading Margin Account Disclosure/DownloadForm.aspx")).TextBefore.Contains("margin"));

            browser.GoTo(targetHost + "/help/account-opening.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("margin"));

            browser.GoTo(targetHost + "/help/trades-orders.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("margin"));
        }

        [Test]
        public void T04_Footer_Security()
        {
            browser.GoTo(targetHost);
            UserSignIn(UN, PW, false, 2);
            SignOut si = new SignOut();
            si.UserSignOut(browser);
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("options"));

            browser.GoTo(targetHost + "/signin.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("options"));
        }

        [Test]
        public void T05_Footer_Explore()
        {
            browser.GoTo(targetHost + "/explore/commission-free-trading.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("margin"));

            browser.GoTo(targetHost + "/explore/online-options-trading.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("margin"));

            browser.GoTo(targetHost + "/aboutus/partners.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("Forex"));
        }

        [Test]
        public void T06_Footer_Tools()
        {
            browser.GoTo(targetHost);
            UserSignIn(UN, PW, false, 2);
            browser.GoTo(targetHost + "/education/stocks/online-trading-basics.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("margin"));

            browser.GoTo(targetHost + "/education/stocks/select-online-broker.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("margin"));

            browser.GoTo(targetHost + "/education/stocks/online-investing-tips.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("margin"));
        }

        [Test]
        public void T07_Footer_Tools_2()
        {
            browser.GoTo(targetHost);
            UserSignIn(UN, PW, false, 2);
            browser.GoTo(targetHost + "/education/options/");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("options"));

            browser.GoTo(targetHost + "/education/options/call.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("options"));

            browser.GoTo(targetHost + "/education/options/bull-call-spread.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("margin"));
        }

        [Test]
        public void T08_Footer_Tools_3()
        {
            browser.GoTo(targetHost);
            UserSignIn(UN, PW, false, 2);
            browser.GoTo(targetHost + "/education/options/put.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("margin"));

            browser.GoTo(targetHost + "/education/options/bear-put-spread.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("margin"));

            browser.GoTo(targetHost + "/education/options/covered-call.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("margin"));
        }

        [Test]
        public void T09_Footer_Tools_2()
        {
            UserSignIn(UN, PW, false, 2);
            browser.GoTo(targetHost + "/education/options/straddles.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("margin"));

            browser.GoTo(targetHost + "/education/options/strangles.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("margin"));

            browser.GoTo(targetHost + "/education/options/butterfly-spread.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("margin"));
        }

        [Test]
        public void T10_Footer_Tools_3()
        {
            UserSignIn(UN, PW, false, 2);
            browser.GoTo(targetHost + "/education/options/basics.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("margin"));

            browser.GoTo(targetHost + "/education/options/how-to-trade.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("margin"));

            browser.GoTo(targetHost + "/education/glossary.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("margin"));
        }

        [Test]
        public void T11_Footer_Tools_4()
        {
            UserSignIn(UN, PW, false, 2);
            browser.GoTo(targetHost + "/education/ira/diversification.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("options"));

            browser.GoTo(targetHost + "/education/ira/performance-calculations.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("options"));

            browser.GoTo(targetHost + "/education/ira/sample-portfolios.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("options"));
        }

        [Test]
        public void T12_Footer_Community()
        {
            UserSignIn(UN, PW, false, 2);
            browser.GoTo(targetHost + "/communitydashboard.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("community"));

            browser.GoTo(targetHost + "/memberprofile.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("community"));

            browser.GoTo(targetHost + "/activityfeed.aspx?memberid=40855");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("community"));
        }

        [Test]
        public void T13_Footer_Community_2()
        {
            UserSignIn(UN, PW, false, 2);
            browser.GoTo(targetHost + "/membertrades.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("community"));

            browser.GoTo(targetHost + "/searchmembers.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("community"));

            browser.GoTo(targetHost + "/searchgroups.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("community"));
        }

        [Test]
        public void T14_Footer_Community_3()
        {
            UserSignIn(UN, PW, false, 2);
            browser.GoTo(targetHost + "/groups.aspx?groupid=1");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("community"));

            browser.GoTo(targetHost + "/discussions.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("community"));

            browser.GoTo(targetHost + "/adddiscussionthread.aspx?threadtitle=");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("community"));
        }

        [Test]
        public void T15_Footer_Forex()
        {
            UserSignIn(UN, PW, false, 2);
            browser.GoTo(targetHost + "/forex/learn.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("Forex"));

            browser.GoTo(targetHost + "/forex/forex-basics.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("Forex"));

            browser.GoTo(targetHost + "/forex/calculating-pl.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("Forex"));
        }

        [Test]
        public void T16_Footer_Forex_2()
        {
            UserSignIn(UN, PW, false, 2);
            browser.GoTo(targetHost + "/forex/leverage-and-margin.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("Forex"));

            browser.GoTo(targetHost + "/forex/quotes.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("Forex"));

            browser.GoTo(targetHost + "/forex/spot-metals-basics.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("Forex"));
        }

        [Test]
        public void T17_Footer_Forex_3()
        {
            UserSignIn(UN, PW, false, 2);
            browser.GoTo(targetHost + "/forex/spot-metals-quotes.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("Forex"));

            browser.GoTo(targetHost + "/forex/spot-metals-market-drivers.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("Forex"));

            browser.GoTo(targetHost + "/forex/spot-metals-leverage-and-margin.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("Forex"));
        }

        [Test]
        public void T18_Footer_Forex_4()
        {
            UserSignIn(UN, PW, false, 2);
            browser.GoTo(targetHost + "/forex/spot-metals-calculating-pl.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("Forex"));

            browser.GoTo(targetHost + "/forex/technical-analysis.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("Forex"));

            browser.GoTo(targetHost + "/forex/short-term-trends.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("Forex"));
        }

        [Test]
        public void T19_Footer_Forex_5()
        {
            UserSignIn(UN, PW, false, 2);
            browser.GoTo(targetHost + "/forex/technical-indicators.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("Forex"));

            browser.GoTo(targetHost + "/forex/using-indicators.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("Forex"));

            browser.GoTo(targetHost + "/forex/fundamental-analysis.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("Forex"));
        }

        [Test]
        public void T20_Footer_Forex_6()
        {
            UserSignIn(UN, PW, false, 2);

            browser.GoTo(targetHost + "/forex/currency-pair.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("Forex"));

            browser.GoTo(targetHost + "/forex/economic-indicators.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("Forex"));

            browser.GoTo(targetHost + "/forex/market-drivers.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("Forex"));
        }

        [Test]
        public void T21_Footer_Forex_7()
        {
            UserSignIn(UN, PW, false, 2);

            browser.GoTo(targetHost + "/forex/premium-education.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("Forex"));

            browser.GoTo(targetHost + "/forex/glossary.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("Forex"));

            browser.GoTo(targetHost + "/forex/trade.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("Forex"));
        }

        [Test]
        public void T22_Footer_Forex_8()
        {
            UserSignIn(UN, PW, false, 2);

            browser.GoTo(targetHost + "/forex/pricing.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("Forex"));

            browser.GoTo(targetHost + "/forex/pro.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("Forex"));

            browser.GoTo(targetHost + "/forex/platforms.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("Forex"));
        }

        [Test]
        public void T23_Footer_Forex_9()
        {
            UserSignIn(UN, PW, false, 2);
            browser.GoTo(targetHost + "/forex/web.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("Forex"));

            browser.GoTo(targetHost + "/forex/account-types.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("Forex"));

            browser.GoTo(targetHost + "/forex/trade-spot-metals.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("Forex"));
        }

        [Test]
        public void T24_Footer_Forex_10()
        {
            UserSignIn(UN, PW, false, 2);
            browser.GoTo(targetHost + "/forex/open-account.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("Forex"));

            browser.GoTo(targetHost + "/forex/resources.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("Forex"));

            browser.GoTo(targetHost + "/forex/charts.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("Forex"));
        }

        [Test]
        public void T25_Footer_Forex_11()
        {
            UserSignIn(UN, PW, false, 2);
            browser.GoTo(targetHost + "/forex/forex-research.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("Forex"));

            browser.GoTo(targetHost + "/forex/daily-research.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("Forex"));

            browser.GoTo(targetHost + "/forex/weekly-research.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("Forex"));
        }

        [Test]
        public void T26_Footer_Forex_12()
        {
            UserSignIn(UN, PW, false, 2);
            browser.GoTo(targetHost + "/forex/support.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("Forex"));

            browser.GoTo(targetHost + "/forex/account-funding.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("Forex"));

            browser.GoTo(targetHost + "/forex/download-center.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("Forex"));
        }

        [Test]
        public void T27_Footer_Forex_13()
        {
            UserSignIn(UN, PW, false, 2);
            browser.GoTo(targetHost + "/forex/download-windows.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("Forex"));

            browser.GoTo(targetHost + "/forex/trading-handbook.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("Forex"));

            browser.GoTo(targetHost + "/forex/faqs.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("Forex"));
        }

        [Test]
        public void T28_Footer_Forex_14()
        {
            UserSignIn(UN, PW, false, 2);
            browser.GoTo(targetHost + "/forex/practice-confirmation.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("Forex"));

            browser.GoTo(targetHost + "/forex/practice-duplicate.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("Forex"));
        }

        [Test]
        public void T29_Footer_Forex_15()
        {
            UserSignIn(UN, PW, false, 2);
            browser.GoTo(targetHost + "/forex/risk-warning.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("Forex"));

            browser.GoTo(targetHost + "/forex/signin.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("Forex"));
        }

        [Test]
        public void T30_Footer_TradingAccount()
        {
            UserSignIn(UN, PW, false, 2);
            browser.GoTo(targetHost + "/trading/accountrecords.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("margin"));

            browser.GoTo(targetHost + "/trading/accountrecords.aspx?frame=7");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("margin"));

            browser.GoTo(targetHost + "/trading/accountrecords.aspx?frame=5");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("margin"));
        }

        [Test]
        public void T31_Footer_TradingAccount_2()
        {
            UserSignIn(UN, PW, false, 2);
            browser.GoTo(targetHost + "/trading/accountrecords.aspx?frame=2");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("margin"));

            browser.GoTo(targetHost + "/trading/accountrecords.aspx?frame=8");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("margin"));

            browser.GoTo(targetHost + "/trading/accountrecords.aspx?frame=3");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("margin"));
        }

        [Test]
        public void T32_Footer_TradingAccount_3()
        {
            UserSignIn(UN, PW, false, 2);
            browser.GoTo(targetHost + "/trading/accountoverview.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("margin"));

            browser.GoTo(targetHost + "/trading/accountsettings.aspx?frame=2");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("margin"));

            browser.GoTo(targetHost + "/trading/accountrecords.aspx?frame=9");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("margin"));
        }

        [Test]
        public void T33_Footer_Transfer()
        {
            UserSignIn(UN, PW, false, 2);
            browser.GoTo("https://trading.qa.zecco.com" + "/transfers/transfer-money.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("margin"));

            browser.GoTo("https://trading.qa.zecco.com" + "/transfers/viewaccountlinks.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("margin"));

            browser.GoTo("https://trading.qa.zecco.com" + "/transfers/check-deposit.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("margin"));
        }

        [Test]
        public void T34_Footer_Transfer_2()
        {
            UserSignIn(UN, PW, false, 2);
            browser.GoTo("https://trading.qa.zecco.com" + "/transfers/wire-deposit.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("margin"));

            browser.GoTo("https://trading.qa.zecco.com" + "/transfers/check-withdrawal.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("margin"));
        }

        [Test]
        public void T35_Footer_Transfer_3()
        {
            UserSignIn(UN, PW, false, 2);
            browser.GoTo("https://trading.qa.zecco.com" + "/transfers/wire-withdrawal.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("margin"));

            browser.GoTo("https://trading.qa.zecco.com" + "/transfers/transferhistory.aspx");
            System.Threading.Thread.Sleep(10000);
            Assert.IsTrue(browser.Div(Find.ByClass("footer-content")).Text.Contains("margin"));
        }
    }
}
