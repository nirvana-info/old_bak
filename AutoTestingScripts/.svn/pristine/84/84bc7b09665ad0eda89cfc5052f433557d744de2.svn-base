using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using WatiN.Core;
using NUnit.Framework;
using SalesLeads360.Appshare.App01_HomePage;
using SalesLeads360.Appshare;


namespace SalesLeads360.Task.UnRegister.T007_SaveCount
{

    [TestFixture]

    public class T007_ConsumerLeads_SavedCount : Selectleadstype
    {
        [Test]
        public void T01_Check_ConsumerLeads_EnterZipCode()
        {

            //select leads type
            TestUserSelectleadstype(tt1);

            //select order path
            Selectorderpath op = new Selectorderpath();
            op.TestUserSelectorderpath(browser, op0);

            //input zip code
            Manualzipcode mz = new Manualzipcode();
            mz.TestUserManualzipcode(browser, zp1);

            //select Demographic Options
            OrderSelectDemo_Consumer osd = new OrderSelectDemo_Consumer();
            osd.TestUserOrderSelectDemo(browser);

 
            //Save Count
            SaveCount sc = new SaveCount();
            sc.SetDesiredCount(100,browser);
            sc.SavedCount("Unreg_ConsumerZipCode"+"SavedCountTest" + Date, browser);
            browser.Link(Find.ByText("Home")).Click();
        }


        [Test]
        public void T02_Check_ConsumerLeads_mapradius()
        {

            //select leads type
            TestUserSelectleadstype(tt1);

            //select order path
            Selectorderpath op = new Selectorderpath();
            op.TestUserSelectorderpath(browser, op1);

            //input zip code
            OrderSelectMapRadius osm = new OrderSelectMapRadius();
            osm.TestUserOrderSelectMapRadius(browser);

            //select Demographic Options
            OrderSelectDemo_Consumer osd = new OrderSelectDemo_Consumer();
            osd.TestUserOrderSelectDemo(browser);

            //Save Count
            SaveCount sc = new SaveCount();
            sc.SetMapDesiredCount(100,browser);
            sc.SavedCount("Unreg_ConsumerMapRadius" + "SavedCountTest" + Date, browser);
            browser.Link(Find.ByText("Home")).Click();
        }

        [Test]
        public void T03_Check_ConsumerLeads_ZipRadius()
        {

            //select leads type
            TestUserSelectleadstype(tt1);

            //select order path
            Selectorderpath op = new Selectorderpath();
            op.TestUserSelectorderpath(browser, op2);

            //input zip code
            OrderSelectZipRadius osz = new OrderSelectZipRadius();
            osz.TestUserOrderSelectZipRadius(browser);

            //select Demographic Options
            OrderSelectDemo_Consumer osd = new OrderSelectDemo_Consumer();
            osd.TestUserOrderSelectDemo(browser);


            //Save Count
            SaveCount sc = new SaveCount();
            sc.SetDesiredCount(100, browser);
            sc.SavedCount("Unreg_ConsumerZipRadius" + "SavedCountTest" + Date, browser);

            browser.Link(Find.ByText("Home")).Click();
        }


        [Test]
        public void T04_Check_ConsumerLeads_selectcity()
        {

            //select leads type
            TestUserSelectleadstype(tt1);

            //select order path
            Selectorderpath op = new Selectorderpath();
            op.TestUserSelectorderpath(browser, op3);

            //input zip code
            OrderSelectCity osc = new OrderSelectCity();
            osc.TestUserOrderSelectCity(browser);

            //select Demographic Options
            OrderSelectDemo_Consumer osd = new OrderSelectDemo_Consumer();
            osd.TestUserOrderSelectDemo(browser);

            //Save Count
            SaveCount sc = new SaveCount();
            sc.SetDesiredCount(100, browser);
            sc.SavedCount("Unreg_ConsumerSelectCities" + "SavedCountTest" + Date, browser);

            browser.Link(Find.ByText("Home")).Click();
        }

        [Test]
        public void T05_Check_ConsumerLeads_selectcounty()
        {

            //select leads type
            TestUserSelectleadstype(tt1);

            //select order path
            Selectorderpath op = new Selectorderpath();
            op.TestUserSelectorderpath(browser, op4);

            //input zip code
            OrderSelectGeoType osgt = new OrderSelectGeoType();
            osgt.TestUserOrderSelectGeoType(browser);

            //select Demographic Options
            OrderSelectDemo_Consumer osd = new OrderSelectDemo_Consumer();
            osd.TestUserOrderSelectDemo(browser);

            //Save Count
            SaveCount sc = new SaveCount();
            sc.SetDesiredCount(100, browser);
            sc.SavedCount("Unreg_ConsumerSelectCounties" + "SavedCountTest" + Date, browser);

            browser.Link(Find.ByText("Home")).Click();
        }


        [Test]
        public void T06_Check_ConsumerLeads_selectstate()
        {
 
            //select leads type
            TestUserSelectleadstype(tt1);

            //select order path
            Selectorderpath op = new Selectorderpath();
            op.TestUserSelectorderpath(browser, op5);

            //input zip code
            OrderSelectState oss = new OrderSelectState();
            oss.TestUserOrderSelectState(browser);

            //select Demographic Options
            OrderSelectDemo_Consumer osd = new OrderSelectDemo_Consumer();
            osd.TestUserOrderSelectDemo(browser);

            //Save Count
            SaveCount sc = new SaveCount();
            sc.SetDesiredCount(100, browser);
            sc.SavedCount("Unreg_ConsumerSelectStates" + "SavedCountTest" + Date, browser);

            browser.Link(Find.ByText("Home")).Click();
        }

        [Test]
        public void T07_Check_ConsumerLeads_EnterScfCode()
        {

            //select leads type
            TestUserSelectleadstype(tt1);

            //select order path
            Selectorderpath op = new Selectorderpath();
            op.TestUserSelectorderpath(browser, op6);

            //input zip code
            OrderSelectScf oss = new OrderSelectScf();
            oss.TestUserOrderSelectScf(browser, zp2);

            //select Demographic Options
            OrderSelectDemo_Consumer osd = new OrderSelectDemo_Consumer();
            osd.TestUserOrderSelectDemo(browser);

            //Save Count
            SaveCount sc = new SaveCount();
            sc.SetDesiredCount(100, browser);
            sc.SavedCount("Unreg_ConsumerSCFCodes" + "SavedCountTest" + Date, browser);

            browser.Link(Find.ByText("Home")).Click();
        }

        [Test]
        public void T08_Check_ConsumerLeads_upload()
        {

            //select leads type
            TestUserSelectleadstype(tt1);

            //select order path
            Selectorderpath op = new Selectorderpath();
            op.TestUserSelectorderpath(browser, op7);

            //upload zip code
            OrderGeoZipUpload ogzu = new OrderGeoZipUpload();
            ogzu.TestUserOrderGeoZipUpload(browser);

            //select Demographic Options
            OrderSelectDemo_Consumer osd = new OrderSelectDemo_Consumer();
            osd.TestUserOrderSelectDemo(browser);

            //Save Count
            SaveCount sc = new SaveCount();
            sc.SetDesiredCount(100, browser);
            sc.SavedCount("Unreg_ConsumerUploadZips" + "SavedCountTest" + Date, browser);

            browser.Link(Find.ByText("Home")).Click();
        }
    }
}
