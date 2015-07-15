using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks.Spring5.S004_ACH_Module
{
    [TestFixture]
    public class S004_ACH_Module_3 : ACH
    {
        [Test]
        public void T01_ACH_TransferIndividual2Individual()
        {
            this.GotoACH();
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxAccountFrom")).Options[1].Select();
            System.Threading.Thread.Sleep(2000);
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxAccountTo")).Options[1].Select();
            System.Threading.Thread.Sleep(2000);
        }

        [Test]
        public void T02_ACH_TransferIndividual2Joint()
        {

        }

        [Test]
        public void T03_ACH_TransferIndividual2IRA()
        {

        }

        [Test]
        public void T04_ACH_TransferIRA2Individual()
        {
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxDistributionType")).Option(Find.ByValue("2")).Select();
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxDistributionReason")).Option(Find.ByValue("10|5")).Select();
            Assert.IsTrue(!browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxSubmit")).Enabled);
        }

        [Test]
        public void T05_ACH_TransferIRA2Joint()
        {

        }

        [Test]
        public void T04_ACH_TransferIRA2IRA()
        {

        }
    }
}
