//#*****************************************************************************
//# Purpose: searching snapshot check.
//# Author:  Christie Duan
//# Create Date: Mar 13, 2009
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
using MaiaRegression.Appobjects.App02_QuotesAndResearch;
using System.Threading;

namespace MaiaRegression.TestCases._02_Quotes_Research
{
    //#*****************************************************************************
    //# Purpose: This class inherit from Quotes class, Define Quotes's Checkpoint.
    //# Author:  Christie
    //# Last Modify: Mar 10, 2009
    //#*****************************************************************************    

    public class Check003_Quotes:Quotes
    {
        PublicPara P = new PublicPara();

        public void Snapshot(String CompanySymbol)
        //CheckPoint: Get Company's snapshot according to CompanySymbol.
        {

            SearchSnapshot(CompanySymbol);
            Thread.Sleep(5000);
            Assert.AreEqual(CompanyName,browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxCenterColumn_uxCompName_uxLongName")).Text);
        }

        public void SnapshotNegative(String CompanySymbol)
        //CheckPoint: Get Company's snapshot according to a invalid CompanySymbol.
        {

            SearchSnapshot(CompanySymbol);
            Thread.Sleep(5000);
            Assert.IsFalse(browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxCenterColumn_uxCompName_uxLongName")).Exists);
        }


        public void Charts(String CompanySymbol)
        //CheckPoint: Get Company's Charts according to CompanySymbol.
        {

            SearchCharts(CompanySymbol);
            Thread.Sleep(5000);
            Assert.AreEqual(P.CompanyName, browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxMainBodyColumnGrid3QM_uxCompName_uxLongName")).Text);
        }


        public void HistoricalPrices(String CompanySymbol)
        //CheckPoint: Get Company's Charts according to CompanySymbol.
        {
            
            SearchHistoricalPrices(CompanySymbol);
            Thread.Sleep(5000);
            Assert.AreEqual(P.CompanyName, browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxCenterColumn_uxCompName_uxLongName")).Text);
        }

        public void Profile(String CompanySymbol)
        //CheckPoint: Get Company's Profile according to CompanySymbol.
        {

            SearchProfile(CompanySymbol);
            Thread.Sleep(5000);
            Assert.AreEqual(P.CompanyName, browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxCenterColumn_uxCompName_uxLongName")).Text);
        }

        public void News(String CompanySymbol)
        //CheckPoint: Get Company's News according to CompanySymbol.
        {

            SearchNews(CompanySymbol);
            Thread.Sleep(5000);
            Assert.AreEqual(P.CompanyName, browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxCenterColumn_uxCompName_uxLongName")).Text);
        }

        public void OptionChains(String CompanySymbol)
        //CheckPoint: Get Company's OptionChains according to CompanySymbol.
        {

            SearchOptionChains(CompanySymbol);
            Thread.Sleep(5000);
            Assert.AreEqual(P.CompanyName, browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxCenterColumn_uxCompName_uxLongName")).Text);
        }

        public void Financials(String CompanySymbol)
        //CheckPoint: Get Company's OptionChains according to CompanySymbol.
        {

            SearchFinancials(CompanySymbol);
            Thread.Sleep(5000);
            Assert.AreEqual(P.CompanyName, browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxCenterColumn_uxCompName_uxLongName")).Text);
        }

        public void EarningsEstimates(String CompanySymbol)
        //CheckPoint: Get Company's OptionChains according to CompanySymbol.
        {

            SearchEarningsEstimates(CompanySymbol);
            Thread.Sleep(5000);
            Assert.AreEqual(P.CompanyName, browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxCenterColumn_uxCompName_uxLongName")).Text);
        }

        public void AnalystRatings(String CompanySymbol)
        //CheckPoint: Get Company's OptionChains according to CompanySymbol.
        {

            SearchAnalystRatings(CompanySymbol);
            Thread.Sleep(5000);
            Assert.AreEqual(P.CompanyName, browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxCenterColumn_uxCompName_uxLongName")).Text);
        }

        public void Insiders(String CompanySymbol)
        //CheckPoint: Get Company's OptionChains according to CompanySymbol.
        {

            SearchInsiders(CompanySymbol);
            Thread.Sleep(5000);
            Assert.AreEqual(P.CompanyName, browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxCenterColumn_uxCompName_uxLongName")).Text);
        }

        public void GotoQR()
        {
            UserSignIn(UN, PW, false, 0);
            browser.WaitForComplete();
            browser.Link(Find.ByText("QUOTES & RESEARCH")).Click();
            browser.WaitForComplete();
        }
    }
}
