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


namespace MaiaRegression.Appobjects.App02_QuotesAndResearch
{
    public class Quotes:TestBase
    {

    ////#*****************************************************************************
    //# Purpose: This class inherit from TestBase,it do all Quotes in the Quotes page.
    //# Author:  Christie
    //# Last Modify: Mar 10, 2009
  ////#*****************************************************************************

        public void SearchSnapshot(String CompanySymbol)
        // Search Snapshot according to Company Symbol.
        {

            browser.Span(Find.ByText("Quotes & Research")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSearchedSymbol")).Value =CompanySymbol;
            browser.Button(Find.ByClass("button-submit")).Click();
        }

        public void SearchCharts(String CompanySymbol)
        // Search Charts according to Company Symbol.
        {
            browser.Span(Find.ByText("Quotes & Research")).Click();
            browser.Link(Find.ByText("Charts")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSearchedSymbol")).Value = CompanySymbol;
            browser.Button(Find.ByClass("button-submit")).Click();
        }

        public void SearchHistoricalPrices(String CompanySymbol)
        // Search HistoricalPrices according to Company Symbol.
        {
            browser.Span(Find.ByText("Quotes & Research")).Click();
            browser.Link(Find.ByText("Historical Prices")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSearchedSymbol")).Value = CompanySymbol;
            browser.Button(Find.ByClass("button-submit")).Click();
        }

        public void SearchProfile(String CompanySymbol)
        // Search Profile according to Company Symbol.
        {
            browser.Span(Find.ByText("Quotes & Research")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSearchedSymbol")).Value = CompanySymbol;
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSymbolPageList")).Option("Profile").Select();
            browser.Button(Find.ByClass("button-submit")).Click();
        }

        public void SearchNews(String CompanySymbol)
        // Search Profile according to Company Symbol.
        {
            browser.Span(Find.ByText("Quotes & Research")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSearchedSymbol")).Value = CompanySymbol;
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSymbolPageList")).Option("News").Select();
            browser.Button(Find.ByClass("button-submit")).Click();
        }
        public void SearchOptionChains(String CompanySymbol)
        // Search Profile according to Company Symbol.
        {
            browser.Span(Find.ByText("Quotes & Research")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSearchedSymbol")).Value = CompanySymbol;
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSymbolPageList")).Option("Option Chains").Select();
            browser.Button(Find.ByClass("button-submit")).Click();
        }

        public void SearchFinancials(String CompanySymbol)
        // Search Profile according to Company Symbol.
        {
            browser.Span(Find.ByText("Quotes & Research")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSearchedSymbol")).Value = CompanySymbol;
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSymbolPageList")).Option("Financials").Select();
            browser.Button(Find.ByClass("button-submit")).Click();
        }

        public void SearchEarningsEstimates(String CompanySymbol)
        // Search Profile according to Company Symbol.
        {
            browser.Span(Find.ByText("Quotes & Research")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSearchedSymbol")).Value = CompanySymbol;
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSymbolPageList")).Option("Earnings Estimates").Select();
            browser.Button(Find.ByClass("button-submit")).Click();
        }

        public void SearchAnalystRatings(String CompanySymbol)
        // Search Profile according to Company Symbol.
        {
            browser.Span(Find.ByText("Quotes & Research")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSearchedSymbol")).Value = CompanySymbol;
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSymbolPageList")).Option("Analyst Ratings").Select();
            browser.Button(Find.ByClass("button-submit")).Click();
        }

        public void SearchInsiders(String CompanySymbol)
        // Search Profile according to Company Symbol.
        {
            browser.Span(Find.ByText("Quotes & Research")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSearchedSymbol")).Value = CompanySymbol;
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSymbolPageList")).Option("Insiders").Select();
            browser.Button(Find.ByClass("button-submit")).Click();
        }
    }
}
