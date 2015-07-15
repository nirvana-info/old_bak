//#*****************************************************************************
//# Purpose: User searching snapshot.
//# Author:  Christie Duan
//# Create Date: Mar 12, 2009
//# Modify History: 
//#*****************************************************************************

using System;
using System.Collections.Generic;
using System.Text;
using WatiN.Core;
using NUnit.Framework;
using WatiN.Core.Interfaces;
using WatiN.Core.DialogHandlers;
using MaiaRegression.Appobjects;
using System.Threading;
using MaiaRegression.Appobjects.App01_HomePage;


namespace MaiaRegression.Appobjects.App02_QuotesAndResearch
{
    public class Quotes : SignIn
    {

        ////#*****************************************************************************
        //# Purpose: This class inherit from TestBase,it do all Quotes in the Quotes page.
        //# Author:  Christie
        //# Last Modify: Mar 10, 2009
        ////#*****************************************************************************
        public void NavigateToQuote(Browser browser)
        {
            if (browser.Link("ctl00_ctl00_uxMainContent_uxBreadcrumbTrail_uxTopLevel").Exists == true)
            {
                if (browser.Link("ctl00_ctl00_uxMainContent_uxBreadcrumbTrail_uxTopLevel").Text != "Quotes & Research")
                {
                    browser.Link(Find.ByTitle("Quotes & Research")).Click();
                }
            }
            else
            {
                browser.Link(Find.ByTitle("Quotes & Research")).Click();
            }
        }
        
        public void SearchSnapshot(string CompanySymbol)
        // Search Snapshot according to Company Symbol.
        {
            browser.Link(Find.ByTitle("Quotes & Research")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSearchedSymbol")).TypeText(CompanySymbol);
            browser.Button(Find.ByValue("Go")).Click();
        }

        public void SearchCharts(string CompanySymbol)
        // Search Charts according to Company Symbol.
        {
            if (browser.Div(Find.ByClass("float-left gutter trail")).Exists == false)
            {
                browser.Link(Find.ByTitle("Quotes & Research")).Click();
                browser.Link(Find.ByText("Charts")).Click();
                browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSearchedSymbol")).Value = CompanySymbol;
                browser.Button(Find.ByValue("Go")).Click();

            }
            else
            {
                if (browser.Div(Find.ByClass("float-left gutter trail")).Text != "Charts")
                {
                    browser.Link(Find.ByTitle("Quotes & Research")).Click();
                    browser.Link(Find.ByText("Charts")).Click();
                    browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSearchedSymbol")).Value = CompanySymbol;
                    browser.Button(Find.ByValue("Go")).Click();
                }
            }
        }

        public void PriceBar_UpdateSymbol(string CompanySymbol1, string CompanySymbol2, string CompanySymbol3)
        // update Symbols in the price bar.
        {
            browser.Div("WatchDivBtn").Image(Find.ByAlt("watchlist update")).Click();
            browser.TextField("WatchListBox").WaitUntilExists(10);
            string cs = CompanySymbol1 + " " + CompanySymbol2 + " " + CompanySymbol3;
            browser.TextField("WatchListBox").TypeText(cs);
            browser.Image(Find.ByAlt("update")).Click();
            Thread.Sleep(1000);
            browser.Image(Find.ByAlt("refresh")).Click();
        }
        
        public void SearchProfile(string CompanySymbol)
        // Search Profile according to Company Symbol.
        {
            if (browser.Div(Find.ByClass("float-left gutter trail")).Exists == false)
            {
                browser.Link(Find.ByTitle("Quotes & Research")).Click();
                browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSearchedSymbol")).Value = CompanySymbol;
                browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSymbolPageList")).Option("Profile").Select();
                browser.Button(Find.ByValue("Go")).Click();
            }
            else
            {
                if (browser.Div(Find.ByClass("float-left gutter trail")).Text != "Profile")
                {
                    browser.Link(Find.ByTitle("Quotes & Research")).Click();
                    browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSearchedSymbol")).Value = CompanySymbol;
                    browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSymbolPageList")).Option("Profile").Select();
                    browser.Button(Find.ByValue("Go")).Click();
                }
            }
        }

        public void SearchNews(string CompanySymbol)
        // Search Profile according to Company Symbol.
        {
            if (browser.Div(Find.ByClass("float-left gutter trail")).Exists == false)
            {
                browser.Link(Find.ByTitle("Quotes & Research")).Click();
                browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSearchedSymbol")).Value = CompanySymbol;
                browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSymbolPageList")).Option("News").Select();
                browser.Button(Find.ByValue("Go")).Click();

            }
            else
            {
                if (browser.Div(Find.ByClass("float-left gutter trail")).Text != "News")
                {
                    browser.Link(Find.ByTitle("Quotes & Research")).Click();
                    browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSearchedSymbol")).Value = CompanySymbol;
                    browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSymbolPageList")).Option("News").Select();
                    browser.Button(Find.ByValue("Go")).Click();
                }
            }
        }

        public void SearchOptionChains(string CompanySymbol)
        // Search Profile according to Company Symbol.
        {
            browser.Link(Find.ByTitle("Quotes & Research")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSearchedSymbol")).Value = CompanySymbol;
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSymbolPageList")).Option("Option Chains").Select();
            browser.Button(Find.ByValue("Go")).Click();
        }

        public void SearchFinancials(string CompanySymbol)
        // Search Profile according to Company Symbol.
        {
            if (browser.Div(Find.ByClass("float-left gutter trail")).Exists == false)
            {
                browser.Link(Find.ByTitle("Quotes & Research")).Click();
                browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSearchedSymbol")).Value = CompanySymbol;
                browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSymbolPageList")).Option("Financials").Select();
                browser.Button(Find.ByValue("Go")).WaitUntilExists(120);
                browser.Button(Find.ByValue("Go")).Click();
            }
            else
            {
                if (browser.Div(Find.ByClass("float-left gutter trail")).Text != "Financials")
                {
                    browser.Link(Find.ByTitle("Quotes & Research")).Click();
                    browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSearchedSymbol")).Value = CompanySymbol;
                    browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSymbolPageList")).Option("Financials").Select();
                    browser.Button(Find.ByValue("Go")).WaitUntilExists(120);
                    browser.Button(Find.ByValue("Go")).Click();
                }
            }
        }

        public void SearchEarningsEstimates(string CompanySymbol)
        // Search Profile according to Company Symbol.
        {
            if (browser.Div(Find.ByClass("float-left gutter trail")).Exists == false)
            {
                browser.Link(Find.ByTitle("Quotes & Research")).Click();
                browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSearchedSymbol")).Value = CompanySymbol;
                browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSymbolPageList")).Option("Earnings Estimates").Select();
                browser.Button(Find.ByValue("Go")).Click();
            }
            else
            {
                if (browser.Div(Find.ByClass("float-left gutter trail")).Text != "Estimates")
                {
                    browser.Link(Find.ByTitle("Quotes & Research")).Click();
                    browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSearchedSymbol")).Value = CompanySymbol;
                    browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSymbolPageList")).Option("Earnings Estimates").Select();
                    browser.Button(Find.ByValue("Go")).Click();
                }
            }
        }

        public void SearchAnalystRatings(string CompanySymbol)
        // Search Profile according to Company Symbol.
        {
            if (browser.Div(Find.ByClass("float-left gutter trail")).Exists == false)
            {
                browser.Link(Find.ByTitle("Quotes & Research")).Click();
                browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSearchedSymbol")).Value = CompanySymbol;
                browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSymbolPageList")).Option("Analyst Ratings").Select();
                browser.Button(Find.ByValue("Go")).Click();
            }
            else
            {
                if (browser.Div(Find.ByClass("float-left gutter trail")).Text != "Estimates")
                {
                    browser.Link(Find.ByTitle("Quotes & Research")).Click();
                    browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSearchedSymbol")).Value = CompanySymbol;
                    browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSymbolPageList")).Option("Analyst Ratings").Select();
                    browser.Button(Find.ByValue("Go")).Click();
                }
            }
        }

        public void SearchInsiders(string CompanySymbol)
        // Search Profile according to Company Symbol.
        {
            if (browser.Div(Find.ByClass("float-left gutter trail")).Exists == false)
            {
                browser.Link(Find.ByTitle("Quotes & Research")).Click();
                browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSearchedSymbol")).Value = CompanySymbol;
                browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSymbolPageList")).Option("Insiders").Select();
                browser.Button(Find.ByValue("Go")).Click();
            }
            else
            {
                if (browser.Div(Find.ByClass("float-left gutter trail")).Text != "Insider Summary")
                {
                    browser.Link(Find.ByTitle("Quotes & Research")).Click();
                    browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSearchedSymbol")).Value = CompanySymbol;
                    browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSymbolPageList")).Option("Insiders").Select();
                    browser.Button(Find.ByValue("Go")).Click();
                }
            }
        }

        public void SearchHistoricalPrices(string CompanySymbol)
        // Search HistoricalPrices according to Company Symbol.
        {
            if (browser.Div(Find.ByClass("float-left gutter trail")).Exists == false)
            {
                browser.Link(Find.ByTitle("Quotes & Research")).Click();
                browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSearchedSymbol")).Value = CompanySymbol;
                browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSymbolPageList")).Option("Historical Prices").Select();
                browser.Button(Find.ByValue("Go")).Click();
            }
            else
            {
                if (browser.Div(Find.ByClass("float-left gutter trail")).Text != "Historical Data")
                {
                    browser.Link(Find.ByTitle("Quotes & Research")).Click();
                    browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSearchedSymbol")).Value = CompanySymbol;
                    browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSymbolPageList")).Option("Historical Prices").Select();
                    browser.Button(Find.ByValue("Go")).Click();
                }
            }
        }

        public void SearchWikinvest(string CompanySymbol)
        // Search HistoricalPrices according to Company Symbol.
        {
            if (browser.Div(Find.ByClass("float-left gutter trail")).Exists == false)
            {
                browser.Link(Find.ByTitle("Quotes & Research")).Click();
                browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSearchedSymbol")).Value = CompanySymbol;
                browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSymbolPageList")).Option("Wikinvest").Select();
                browser.Button(Find.ByValue("Go")).Click();
            }
            else
            {
                if (browser.Div(Find.ByClass("float-left gutter trail")).Text != "Wikinvest Analysis")
                {
                    browser.Link(Find.ByTitle("Quotes & Research")).Click();
                    browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSearchedSymbol")).Value = CompanySymbol;
                    browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSymbolPageList")).Option("Wikinvest").Select();
                    browser.Button(Find.ByValue("Go")).Click();
                }
            }
        }
    }
}
