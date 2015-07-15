
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

namespace MaiaRegression.TestCases._02_Quotes_Research
{
    
    public class Check003_Quotes:Quotes
    {
        PublicPara Q = new PublicPara();

        public void Snapshot(String CompanyName)
        {
            
            SearchSnapshot(CompanyName);
            Assert.AreEqual(Q.CompanyName,browser.Span(Find.ById("ctl00_ctl00_uxMainContent_uxCenterColumn_uxCompName_uxLongName")).Text);

        }


    }
}
