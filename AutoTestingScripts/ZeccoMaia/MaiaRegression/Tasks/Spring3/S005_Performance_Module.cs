using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks.Spring3
{
    [TestFixture]
    public class S005_Performance_Module : SignIn
    {
        [Test]
        public void T01_Performance_StartShare()
        {
            this.NavigatetoPerformance();
            this.GotoShareAccount();
            string account = browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxZeccoTradingAccount_ctl02_uxDisplayNameBlock")).Value;
            if (browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxZeccoTradingAccount_ctl02_uxIsShard")).Checked == false)
            {
                browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxZeccoTradingAccount_ctl02_uxIsShard")).Checked = true;
            }
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSaveAccountSharing")).Click();
            if (browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSuccessMessageAccountSharing")).Text.Contains("Saved successfully!") == false)
            {
                Assert.IsTrue(false);
                return;
            }
            browser.Link(Find.ByText("Community Profile")).Click();
            if (browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberPortfolioList_Select")).Option(Find.ByText(account)).Exists == true)
            {
                Assert.IsTrue(true);
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T02_Performance_StopShare()
        {
            this.NavigatetoPerformance();
            this.GotoShareAccount();
            string account = browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxZeccoTradingAccount_ctl02_uxDisplayNameBlock")).Value;
            browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxZeccoTradingAccount_ctl02_uxIsShard")).Checked = false;
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSaveAccountSharing")).Click();
            if (browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSuccessMessageAccountSharing")).Text.Contains("Saved successfully!") == false)
            {
                Assert.IsTrue(false);
                return;
            }
            browser.Link(Find.ByText("Community Profile")).Click();
            if (browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberPortfolioList_Select")).Option(Find.ByText(account)).Exists == false)
            {
                Assert.IsTrue(true);
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T03_Performance_HideMetrics()
        {
            this.NavigatetoPerformance();
            this.GotoShareAccount();
            browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxDisplayPerformanceCheck")).Checked = false;
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSaveAccountSharing")).Click();

            browser.Link(Find.ByText("Community Profile")).Click();
            System.Threading.Thread.Sleep(5000);
            int i = 0;
            for (i = 0; i < browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberPortfolioList_Select")).Options.Count; i++)
            {
                browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberPortfolioList_Select")).Options[i].Select();
                if (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberHoldings_Table")).TableBodies[0].TableRows.Count > 0)
                {
                    break;
                }
            }
            if (i < browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberPortfolioList_Select")).Options.Count)
            {
                
                if (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberHoldings_Table")).TableBodies[0].TableRows[0].TableCells[4].Span(Find.ById("uxThreeMonthReturn")).Text.Contains("not shared") == true)
                {
                    Assert.IsTrue(true);
                }
                else
                {
                    Assert.IsTrue(false);
                }
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T04_Performance_StopHideMetrics()
        {
            this.NavigatetoPerformance();
            this.GotoShareAccount();
            if (browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxDisplayPerformanceCheck")).Checked == false)
            {
                browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxDisplayPerformanceCheck")).Checked = true;
            }
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSaveAccountSharing")).Click();

            browser.Link(Find.ByText("Community Profile")).Click();
            System.Threading.Thread.Sleep(5000);
            int i = 0;
            for (i = 0; i < browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberPortfolioList_Select")).Options.Count; i++)
            {
                browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberPortfolioList_Select")).Options[i].Select();
                if (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberHoldings_Table")).TableBodies[0].TableRows.Count > 0)
                {
                    break;
                }
            }
            if (i < browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberPortfolioList_Select")).Options.Count)
            {

                if (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberHoldings_Table")).TableBodies[0].TableRows[0].TableCells[4].Span(Find.ById("uxThreeMonthReturn")).Text.Contains("not shared") == false)
                {
                    Assert.IsTrue(true);
                }
                else
                {
                    Assert.IsTrue(false);
                }
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T05_Performance_OpenAndShare()
        {
            this.NavigatetoPerformance();
            this.GotoShareAccount();
            //string account = browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxZeccoTradingAccount_ctl02_uxDisplayBlock")).Text;
            if (browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxZeccoTradingAccount_ctl02_uxIsShard")).Checked == false)
            {
                browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxZeccoTradingAccount_ctl02_uxIsShard")).Checked = true;
            }
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSaveAccountSharing")).Click();
            if (browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSuccessMessageAccountSharing")).Text.Contains("Saved successfully!") == false)
            {
                Assert.IsTrue(false);
                return;
            }
            browser.Link(Find.ByText("Community Profile")).Click();
            System.Threading.Thread.Sleep(5000);
            if (browser.Link(Find.ById("uxMemberTradesViewAll")).Exists == true)
            {
                Assert.IsTrue(true);
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T07_Performance_AnotherView()
        {
            this.NavigatetoPerformance();
            this.GotoShareAccount();
            string account = browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxZeccoTradingAccount_ctl02_uxDisplayNameBlock")).Value;
            if (browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxZeccoTradingAccount_ctl02_uxIsShard")).Checked == false)
            {
                browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxZeccoTradingAccount_ctl02_uxIsShard")).Checked = true;
            }
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSaveAccountSharing")).Click();
            if (browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSuccessMessageAccountSharing")).Text.Contains("Saved successfully!") == false)
            {
                Assert.IsTrue(false);
                return;
            }
            UserSignIn(UN1, PW1, false, 0);
            browser.Link(Find.ByText("Community Profile")).Click();
            System.Threading.Thread.Sleep(5000);
            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_SideNavigation1_uxSideNavigation")).Link(Find.ByText("Members")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxScreenName")).TypeText(UN);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSimpleSearch")).Click();
            browser.Image(Find.ById("uxMemberProfilePicture")).Click();
            if (browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberPortfolioList_Select")).Option(Find.ByText(account)).Exists == true)
            {
                Assert.IsTrue(true);
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T08_Performance_ComparePerformance()
        {
            this.NavigatetoPerformance();
            this.GotoShareAccount();
            if (browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxDisplayPerformanceCheck")).Checked == false)
            {
                browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxDisplayPerformanceCheck")).Checked = true;
            }
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSaveAccountSharing")).Click();
            UserSignIn(UN1, PW1, false, 0);
            browser.Link(Find.ByText("Community Profile")).Click();
            System.Threading.Thread.Sleep(5000);
            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_SideNavigation1_uxSideNavigation")).Link(Find.ByText("Members")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxScreenName")).TypeText(UN);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSimpleSearch")).Click();
            browser.Image(Find.ById("uxMemberProfilePicture")).Click();
            int i = 0;
            for (i = 0; i < browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberPortfolioList_Select")).Options.Count; i++)
            {
                browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberPortfolioList_Select")).Options[i].Select();
                if (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberHoldings_Table")).TableBodies[0].TableRows.Count > 0)
                {
                    break;
                }
            }
            if (i < browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberPortfolioList_Select")).Options.Count)
            {
                if (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberHoldings_Table")).TableBodies[0].TableRows[0].TableCells[4].Span(Find.ById("uxThreeMonthReturn")).Text.Contains("not shared") == false)
                {
                    Assert.IsTrue(true);
                }
                else
                {
                    Assert.IsTrue(false);
                }
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T09_Performance_AnotherViewNoShare()
        {
            this.NavigatetoPerformance();
            this.GotoShareAccount();
            string account = browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxZeccoTradingAccount_ctl02_uxDisplayNameBlock")).Value;
            browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxZeccoTradingAccount_ctl02_uxIsShard")).Checked = false;
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSaveAccountSharing")).Click();
            if (browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxSuccessMessageAccountSharing")).Text.Contains("Saved successfully!") == false)
            {
                Assert.IsTrue(false);
                return;
            }
            UserSignIn(UN1, PW1, false, 2);
            browser.Link(Find.ByText("Community Profile")).Click();
            System.Threading.Thread.Sleep(5000);
            browser.Div(Find.ById("ctl00_ctl00_uxMainContent_SideNavigation1_uxSideNavigation")).Link(Find.ByText("Members")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxScreenName")).TypeText(UN);
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSimpleSearch")).Click();
            browser.Image(Find.ById("uxMemberProfilePicture")).Click();
            if (browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberPortfolioList_Select")).Option(Find.ByText(account)).Exists == false)
            {
                Assert.IsTrue(true);
            }
            else
            {
                Assert.IsTrue(false);
            }
        }

        [Test]
        public void T10_Performance_ViewStockHoldTrade()
        {
            this.NavigatetoPerformance();
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl02_uxTopNavLink")).Click();
            //browser.Link(Find.ByTitle("Quotes & Research")).Click();
            //browser.Link(Find.ByTitle("Quotes")).Click();
            browser.TextField(Find.ById("WSOD_zeccoSymbolSearchInput")).WaitUntilExists(20);
            browser.TextField(Find.ById("WSOD_zeccoSymbolSearchInput")).TypeText("AAPL");
            //browser.Button(Find.ByValue("Go")).Click();
            browser.WaitForComplete();
            Assert.IsTrue(browser.Div(Find.ById("most_held_webpart")).Exists);
            browser.Back();
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
        }

        [Test]
        public void T11_Performance_ViewStockSentiment()
        {
            this.NavigatetoPerformance();
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl02_uxTopNavLink")).Click();
            //browser.Link(Find.ByTitle("Quotes & Research")).Click();
            //browser.Link(Find.ByTitle("Quotes")).Click();
            browser.TextField(Find.ById("WSOD_zeccoSymbolSearchInput")).WaitUntilExists(20);
            browser.TextField(Find.ById("WSOD_zeccoSymbolSearchInput")).TypeText("AAPL");
            //browser.Button(Find.ByValue("Go")).Click();
            browser.WaitForComplete();
            Assert.IsTrue(browser.Div(Find.ById("community_sentiment_webpart")).Exists);
            browser.Back();
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
        }

        [Test]
        public void T12_Performance_ViewStockTop()
        {
            this.NavigatetoPerformance();
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl02_uxTopNavLink")).Click();
            //browser.Link(Find.ByTitle("Quotes & Research")).Click();
            //browser.Link(Find.ByTitle("Quotes")).Click();
            browser.TextField(Find.ById("WSOD_zeccoSymbolSearchInput")).WaitUntilExists(20);
            browser.TextField(Find.ById("WSOD_zeccoSymbolSearchInput")).TypeText("AAPL");
            //browser.Button(Find.ByValue("Go")).Click();
            browser.WaitForComplete();
            Assert.IsTrue(browser.Div(Find.ById("company_news_webpart")).Exists);
            browser.Back();
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
        }

        [Test]
        public void T13_Performance_NegativeTable()
        {
            this.NavigatetoPerformance();
            browser.Link(Find.ByText("Community Profile")).Click();
            browser.WaitForComplete(10);
            for (int i = 0; i < browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberPortfolioList_Select")).Options.Count; i++)
            {
                browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberPortfolioList_Select")).Options[i].Select();
                if (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberHoldings_Table")).TableBodies.Count > 0)
                {
                    for (int j = 0; j < browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberHoldings_Table")).TableBodies[0].TableRows.Count; j++)
                    {
                        if (string.IsNullOrEmpty(browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMemberHoldings_Table")).TableBodies[0].TableRows[j].TableCells[1].Text))
                        {
                            Assert.IsTrue(false);
                            return;
                        }
                    }
                }
                if (browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxLatestTrades_Table")).TableBodies.Count > 0)
                {
                    for (int j = 0; j < browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxLatestTrades_Table")).TableBodies[0].TableRows.Count; j++)
                    {
                        if (string.IsNullOrEmpty(browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxLatestTrades_Table")).TableBodies[0].TableRows[j].TableCells[1].Text))
                        {
                            Assert.IsTrue(false);
                            return;
                        }
                    }
                }
            }
        }

        [Test]
        public void T14_Performance_NoTrades()
        {
            UserSignIn(UN, PW, false, 2);
            browser.Link(Find.ByText("Community Profile")).Click();
            System.Threading.Thread.Sleep(5000);
            Assert.AreEqual(browser.Span(Find.ById("uxNoTradesHoldingDisplayMessage")).Text, "Sorry, this person does not have any recent trades to share.");
        }

        [Test]
        public void T15_Performance_NoHoldings()
        {
            //UserSignIn(UN, PW, false, 2);
            //browser.Span(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxMemberLoginStatus_uxMemberLoginView_uxLoginName")).Click();
            //System.Threading.Thread.Sleep(5000);
            //Assert.AreEqual(browser.Span(Find.ById("uxNoTradesHoldingDisplayMessage")).Text, "Sorry, this person does not have any holdings to share.");
            string username = "";
            for (int i = 3249; i < 3259; i++)
            {
                username = "HermesTest" + i.ToString("0000");

                if (browser.Link(Find.ByText("Sign Out")).Exists)
                {
                    SignOut si = new SignOut();
                    si.UserSignOut(browser);
                    browser.GoTo(targetHost);

                    System.Threading.Thread.Sleep(5000);
                }
                browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDefaultLoginForm_uxUserName")).TypeText(username);
                browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDefaultLoginForm_uxPassword")).TypeText("Zecco111");
                browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDefaultLoginForm_uxSignIn")).Click();
                System.Threading.Thread.Sleep(10000);

                if ((browser.Link(Find.ByText("Sign Out")).Exists == true) &&
                    (browser.Div(Find.ById("topNavMemberDiv")).Text.Trim().ToLower() == username.ToLower()))
                {

                }
                else
                {
                    if (browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxAnswer")).Exists == true)
                    {
                        browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxAnswer")).TypeText("Zecco");
                        browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNext")).Click();
                        System.Threading.Thread.Sleep(8000);
                    }
                }

                if (browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNASDAQSubscriberSignature")).Exists == true)
                {
                    browser.RadioButton(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNonProfessional")).Checked = true;
                    string sig = browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNASDAQSubscriberName")).Text.Trim();
                    if (string.IsNullOrEmpty(sig) == true)
                    {
                        Console.WriteLine("{0}-Account invalid", username);
                        continue;
                    }
                    browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNASDAQSubscriberSignature")).TypeText(sig);
                    browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxConfirmNASDAQButton")).Click();

                    browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxAgreedtoSection1")).WaitUntilExists(20);
                    browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxAgreedtoSection1")).Checked = true;
                    browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxAgreedtoSection2")).Checked = true;
                    browser.CheckBox(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxAgreedtoSection3")).Checked = true;
                    browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNYSEAddress")).TypeText("NYSEAddress" + i.ToString("0000"));
                    browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNYSEEmployer")).TypeText("NYSEEmployer" + i.ToString("0000"));
                    browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNYSEEmployerFunction")).TypeText("NYSEEmployerFunction" + i.ToString("0000"));
                    browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNYSETitle")).TypeText("NYSETitle" + i.ToString("0000"));
                    browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNYSEEmployerAddress")).TypeText("NYSEEmployerAddress" + i.ToString("0000"));
                    browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNYSEConfirmButton")).Click();

                    browser.RadioButton(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNonProfessionalOPRA")).WaitUntilExists(20);
                    browser.RadioButton(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxNonProfessionalOPRA")).Checked = true;
                    browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxOPRAConfirm")).Click();

                    System.Threading.Thread.Sleep(5000);
                }

                if (browser.Url.Contains("communitydashboard") == true)
                {
                    Console.WriteLine("{0}-No account", username);
                    continue;
                }

                browser.Span(Find.ById("TradeBalance_NetCash")).WaitUntilExists(20);
                string balance = browser.Span(Find.ById("TradeBalance_NetCash")).Text.Trim();
                string stockBP = browser.Span(Find.ById("TradeBalance_StockBuyingPower")).Text.Trim();
                string optionBP = browser.Span(Find.ById("TradeBalance_OptionBuyingPower")).Text.Trim();
                browser.Image(Find.ByClass("money-hover")).Click();

                System.Threading.Thread.Sleep(5000);
                string ach = browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxAccountFrom")).Exists ? "Active" : "Non-active";

                Console.WriteLine("{0}-{1}-{2}-{3}-{4}", username, balance, stockBP, optionBP, ach);
            }
        }

        [Test]
        public void T16_Performance_NoTradesHoldings()
        {
            UserSignIn(UN1, PW1, false, 2);
            browser.Link(Find.ByText("Community Profile")).Click();
            System.Threading.Thread.Sleep(5000);
            Assert.AreEqual(browser.Span(Find.ById("uxNoTradesHoldingDisplayMessage")).Text, "Sorry, this person does not have any holdings or recent trades to share.");
        }

        private void NavigatetoPerformance()
        {
            UserSignIn(UN, PW, false, 2);
            browser.WaitForComplete();
        }

        private void GotoShareAccount()
        {
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
            browser.Link(Find.ByUrl(URL + "/editmemberprofile.aspx?view=AccountSharing")).WaitUntilExists(10);
            browser.Link(Find.ByUrl(URL + "/editmemberprofile.aspx?view=AccountSharing")).Click();
            //browser.Link(Find.ByText("Share Your Account(s)")).WaitUntilExists(10);
            //browser.Link(Find.ByText("Share Your Account(s)")).Click();
            browser.WaitForComplete();
        }
    }
}
