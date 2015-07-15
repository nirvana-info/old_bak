//#*****************************************************************************
//# Purpose: User logout check.
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
using MaiaRegression.TestCases._02_Quotes_Research;
using MaiaRegression.Appobjects;


namespace MaiaRegression.Tasks
{
    [TestFixture]
    public class Scenario002_Quotes:Check003_Quotes
    {
 
        [Test]
        public void QuoteSnapshot()
        {
            Snapshot(CompanySymbol);
        }

        [Test]
        public void QuoteCharts()
        {

            Charts(CompanySymbol);
        }

        [Test]
        public void QuoteHistoricalPrices()
        {
            HistoricalPrices(CompanySymbol);
        }

        [Test]
        public void QuoteProfile()
        {
            Profile(CompanySymbol);
        }


        [Test]
        public void QuoteNews()
        {
            News(CompanySymbol);
        }


        [Test]
        public void QuoteOptionChains()
        {
            OptionChains(CompanySymbol);
        }

        [Test]
        public void QuoteFinancials()
        {
            Financials(CompanySymbol);
        }
        
        [Test]
        public void QuoteEarningsEstimates()
        {
            EarningsEstimates(CompanySymbol);
        }

        [Test]
        public void QuoteAnalystRatings()
        {
            AnalystRatings(CompanySymbol);
        }


        [Test]
        public void QuoteInsiders()
        {
            Insiders(CompanySymbol);
        }
    }
}
