//#*****************************************************************************
//# Purpose: User searching snapshot.
//# Author:  Christie Duan
//# Create Date: Mar 16, 2009
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
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Appobjects.App02_QuotesAndResearch
{
    public class OptionsAnalytics:SignIn
    {
        ////#*****************************************************************************
        //# Purpose: This class inherit from TestBase,it do all option analytics by company symbol.
        //# Author:  Christie
        //# Last Modify: Mar 10, 2009
        ////#*****************************************************************************

        public void SearchPowerOptionChain(String CompanySymbol)
        {
            // Search Power Option Chain according to Company Symbol.
            browser.Link(Find.ByTitle("Quotes & Research")).Click();
            //browser.Span(Find.ByText("Quotes & Research")).Click();
            browser.Link(Find.ByText("Options Analytics")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSearchedSymbol")).Value = CompanySymbol;
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSymbolPageList")).Option("Power Option Chain").Select();
            browser.Button(Find.ByValue("Go")).Click();

        }

        public void SearchProbabilityCalculator(String CompanySymbol)
        {
            // Search Probability Calculator according to Company Symbol.
            browser.Link(Find.ByTitle("Quotes & Research")).Click();
            browser.Link(Find.ByText("Options Analytics")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSearchedSymbol")).Value = CompanySymbol;           
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSymbolPageList")).Option("Probability Calculator").Select();
            browser.Button(Find.ByValue("Go")).Click();
        }

        public void SearchOptionsCalculator(String CompanySymbol)
        {
            // Search Options Calculator according to Company Symbol.
            browser.Link(Find.ByTitle("Quotes & Research")).Click();
            browser.Link(Find.ByText("Options Analytics")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSearchedSymbol")).Value = CompanySymbol;
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSymbolPageList")).Option("Options Calculator").Select();
            browser.Button(Find.ByValue("Go")).Click();
        }

        public void SearchVolatilityChain(String CompanySymbol)
        {
            // Search Volatility Chain according to Company Symbol.
            browser.Link(Find.ByTitle("Quotes & Research")).Click();
            browser.Link(Find.ByText("Options Analytics")).Click();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSearchedSymbol")).Value = CompanySymbol;
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_quoteSearchBar_uxSymbolPageList")).Option("Volatility Chain").Select();
            browser.Button(Find.ByValue("Go")).Click();
        }

           

      
    }
}
