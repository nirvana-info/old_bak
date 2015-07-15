//#*****************************************************************************
//# Purpose: searching snapshot check.
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
using MaiaRegression.Appobjects.App02_QuotesAndResearch;


namespace MaiaRegression.TestCases._02_Quotes_Research
{
    //#*****************************************************************************
    //# Purpose: This class inherit from Quotes class, Define searching OptionsAnalytics's Checkpoint.
    //# Author:  Christie
    //# Last Modify: Mar 16, 2009
    //#*****************************************************************************   

    public class Check004_OptionsAnalytics:OptionsAnalytics
    {
        protected IFrame Frame1 = null;



        public void PowerOptionChain(String CompanySymbol)
        {

            SearchPowerOptionChain(CompanySymbol);
            Frame1 = browser.Frame(Find.ById("ctl00_ctl00_uxMainContent_uxMainBodyColumnGrid3QM_OptionsAnalyticsTabs1_powserChainFrame"));

            Assert.AreEqual(CompanySymbol, Frame1.Span(Find.ByClass("ts2g")).Text);
            
        }
        public void ProbabilityCalculator(String CompanySymbol)
        { 
        }

        public void OptionsCalculator(String CompanySymbol)
        { 
        }
        public void VolatilityChain(String CompanySymbol)
        { 
        }
    }
}
