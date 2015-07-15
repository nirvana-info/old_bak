using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using WatiN.Core;
using NUnit.Framework;
using System.Threading;

namespace SL360Test_Iris
{
    // this class includs functions of different selecting methods: by zip code, by City, by State, and so on.
    public class SelectAreas
    {
        private int iIndex;
        private string sAdd;
        private string sValue;

        public void AreaTypeSelect(Testbase test)
        {
            iIndex = test.para.aKey.IndexOf("ByAreaPage_Index");
            sValue = (string)test.para.aValue[iIndex];

            test.FF.WaitUntilContainsText(sValue);
            Assert.IsTrue(test.FF.ContainsText(sValue));

            iIndex = test.para.aKey.IndexOf("SelectAreaType");
            sAdd = (string)test.para.aAddress[iIndex];
            string sAdd2 = sAdd;

            // Select an area path
            test.FF.RadioButton(Find.ById(sAdd)).Checked = true;

            iIndex = test.para.aKey.IndexOf("Next2");
            sAdd = (string)test.para.aAddress[iIndex];
            test.FF.Span(Find.ByText(sAdd)).Click();

            // Input areas in different area pages

            switch (sAdd2)
            {
                case "geo_type_zip":
                    SelectAreaByZip(test);
                    break;
                case "geo_type_city":
                    SelectAreabyCity(test);
                    break;
                case "geo_type_county":
                    SelectAreabyCounty(test);
                    break;
                case "geo_type_state":
                    SelectAreabyState(test);
                    break;
                case "geo_type_radius":
                    SelectAreabyAddRadius(test);
                    break;
                case "geo_type_zipradius":
                    SelectAreabyZipRadius(test);
                    break;
                case "geo_type_scf":
                    SelectAreabySCF(test);
                    break;
                case "geo_type_entireusa":
                    SelectAreabyUS(test);
                    break;            
                case "geo_type_closex":
                    SelectAreabyClosestRecords(test);
                    break;
            }
        }

        // Selected by Zip codes
        private void SelectAreaByZip(Testbase test)
        {
            // Wait for the page to appear
            iIndex = test.para.aKey.IndexOf("ByZipPage_Index");
            sValue = (string)test.para.aValue[iIndex];

            test.FF.WaitUntilContainsText(sValue);
            Assert.IsTrue(test.FF.ContainsText(sValue));

            // Input three zip codes
            for (int i = 1; i < 4; i++)
            {
                iIndex = test.para.aKey.IndexOf("Zipcode" + i.ToString());
                sAdd = (string)test.para.aAddress[iIndex];
                sValue = (string)test.para.aValue[iIndex];
                test.FF.TextField(Find.ById(sAdd)).TypeText(sValue);            
            }

            // Click "Next" button
            iIndex = test.para.aKey.IndexOf("Next3");
            sAdd = (string)test.para.aAddress[iIndex];
            test.FF.Span(Find.ByText(sAdd)).Click();
            
        }


        // Selected by Cities
        private void SelectAreabyCity(Testbase test)
        {
            // Wait for the page to appear
            iIndex = test.para.aKey.IndexOf("ByCityPage_Index");
            sValue = (string)test.para.aValue[iIndex];

            test.FF.WaitUntilContainsText(sValue);
            Assert.IsTrue(test.FF.ContainsText(sValue));

            // Input three Cities
            for (int i = 1; i < 4; i++)
            {
                iIndex = test.para.aKey.IndexOf("City_State"+i.ToString());
                sAdd = (string)test.para.aAddress[iIndex];
                sValue = (string)test.para.aValue[iIndex];
                test.FF.SelectList(Find.ById(sAdd)).Option(Find.ByValue(sValue)).Select();

                iIndex = test.para.aKey.IndexOf("City" + i.ToString());
                sAdd = (string)test.para.aAddress[iIndex];
                sValue = (string)test.para.aValue[iIndex];
                test.FF.SelectList(Find.ById(sAdd)).Option(Find.ByValue(sValue)).Select();
                test.FF.SelectList(Find.ById(sAdd)).Option(Find.ByValue(sValue)).DoubleClick();                      
            }

            // Click "Next" button
            iIndex = test.para.aKey.IndexOf("Next3");
            sAdd = (string)test.para.aAddress[iIndex];
            test.FF.Span(Find.ByText(sAdd)).Click();

        }


        //Selected by County
        private void SelectAreabyCounty(Testbase test)
        {
            // Wait for the page to appear
            iIndex = test.para.aKey.IndexOf("ByCountyPage_Index");
            sValue = (string)test.para.aValue[iIndex];

            test.FF.WaitUntilContainsText(sValue);
            Assert.IsTrue(test.FF.ContainsText(sValue));

            // Input three Cities
            for (int i = 1; i < 4; i++)
            {
                iIndex = test.para.aKey.IndexOf("County_State" + i.ToString());
                sAdd = (string)test.para.aAddress[iIndex];
                sValue = (string)test.para.aValue[iIndex];
                test.FF.SelectList(Find.ById(sAdd)).Option(Find.ByValue(sValue)).Select();

                iIndex = test.para.aKey.IndexOf("County" + i.ToString());
                sAdd = (string)test.para.aAddress[iIndex];
                sValue = (string)test.para.aValue[iIndex];
                test.FF.SelectList(Find.ById(sAdd)).Option(Find.ByValue(sValue)).Select();
                test.FF.SelectList(Find.ById(sAdd)).Option(Find.ByValue(sValue)).DoubleClick();
            }

            // Click "Next" button
            iIndex = test.para.aKey.IndexOf("Next3");
            sAdd = (string)test.para.aAddress[iIndex];
            test.FF.Span(Find.ByText(sAdd)).Click();
        }

        //Selected by State
        private void SelectAreabyState(Testbase test)
        {
            // Wait for the page to appear
            iIndex = test.para.aKey.IndexOf("ByStatePage_Index");
            sValue = (string)test.para.aValue[iIndex];

            test.FF.WaitUntilContainsText(sValue);
            Assert.IsTrue(test.FF.ContainsText(sValue));

            // Input a state
            iIndex = test.para.aKey.IndexOf("State");
            sAdd = (string)test.para.aAddress[iIndex];
            sValue = (string)test.para.aValue[iIndex];
            test.FF.SelectList(Find.ById(sAdd)).Option(Find.ByValue(sValue)).Select();
            test.FF.SelectList(Find.ById(sAdd)).Option(Find.ByValue(sValue)).DoubleClick();

            // Click "Next" button
            iIndex = test.para.aKey.IndexOf("Next3");
            sAdd = (string)test.para.aAddress[iIndex];
            test.FF.Span(Find.ByText(sAdd)).Click();
        }


        //Selected by Address and Radius
        private void SelectAreabyAddRadius(Testbase test)
        {
            // Wait for the page to appear
            iIndex = test.para.aKey.IndexOf("ByRadiusPage_Index");
            sValue = (string)test.para.aValue[iIndex];

            test.FF.WaitUntilContainsText(sValue);
            Assert.IsTrue(test.FF.ContainsText(sValue));

            Thread.Sleep(5000);
            
            iIndex = test.para.aKey.IndexOf("Fill_Address");
            sAdd = (string)test.para.aAddress[iIndex];
            sValue = (string)test.para.aValue[iIndex];            
            test.FF.TextField(Find.ById(sAdd)).Select();

            int iCount = 0;
            while((iCount <60000) & (test.FF.TextField(Find.ById(sAdd)).Text != sValue))
            {
                test.FF.TextField(Find.ById(sAdd)).TypeText(sValue);
                iCount++;
                Thread.Sleep(500);
            }
            
            iIndex = test.para.aKey.IndexOf("Fill_Radius");
            sAdd = (string)test.para.aAddress[iIndex];
            sValue = (string)test.para.aValue[iIndex];            
            test.FF.TextField(Find.ById(sAdd)).Select();
            while ((iCount < 60000) & (test.FF.TextField(Find.ById(sAdd)).Text != sValue))
            {
                test.FF.TextField(Find.ById(sAdd)).TypeText(sValue);
                iCount++;
                Thread.Sleep(500);
            }

            Thread.Sleep(1000);
            // Click "Search" button
            iIndex = test.para.aKey.IndexOf("Search");
            sAdd = (string)test.para.aAddress[iIndex];
            test.FF.Span(Find.ByText(sAdd)).Click();
            Thread.Sleep(2000);
            
            // Click "Next" button
            iIndex = test.para.aKey.IndexOf("Next3");
            sAdd = (string)test.para.aAddress[iIndex];
            test.FF.Span(Find.ByText(sAdd)).Click();
        }

        //Selected by Zip code and Radius
        private void SelectAreabyZipRadius(Testbase test)
        {
            // Wait for the page to appear
            iIndex = test.para.aKey.IndexOf("ByZipRadius_Index");
            sValue = (string)test.para.aValue[iIndex];

            test.FF.WaitUntilContainsText(sValue);
            Assert.IsTrue(test.FF.ContainsText(sValue));

            Thread.Sleep(5000);

            iIndex = test.para.aKey.IndexOf("Fill_Zip");
            sAdd = (string)test.para.aAddress[iIndex];
            sValue = (string)test.para.aValue[iIndex];
            test.FF.TextField(Find.ById(sAdd)).Select();

            int iCount = 0;
            while ((iCount < 60000) & (test.FF.TextField(Find.ById(sAdd)).Text != sValue))
            {
                test.FF.TextField(Find.ById(sAdd)).TypeText(sValue);
                iCount++;
                Thread.Sleep(500);
            }

            iIndex = test.para.aKey.IndexOf("Fill_Radius");
            sAdd = (string)test.para.aAddress[iIndex];
            sValue = (string)test.para.aValue[iIndex];
            test.FF.TextField(Find.ById(sAdd)).Select();
            while ((iCount < 60000) & (test.FF.TextField(Find.ById(sAdd)).Text != sValue))
            {
                test.FF.TextField(Find.ById(sAdd)).TypeText(sValue);
                iCount++;
                Thread.Sleep(500);
            }

            Thread.Sleep(1000);
            // Click "Search" button
            iIndex = test.para.aKey.IndexOf("Search");
            sAdd = (string)test.para.aAddress[iIndex];
            test.FF.Span(Find.ByText(sAdd)).Click();
            Thread.Sleep(1000);

            // Click "Next" button
            iIndex = test.para.aKey.IndexOf("Next3");
            sAdd = (string)test.para.aAddress[iIndex];
            test.FF.Span(Find.ByText(sAdd)).Click();
        }

        //Selected by SCF
        private void SelectAreabySCF(Testbase test)
        {
            // Wait for the page to appear
            iIndex = test.para.aKey.IndexOf("BySCFPage_Index");
            sValue = (string)test.para.aValue[iIndex];

            test.FF.WaitUntilContainsText(sValue);
            Assert.IsTrue(test.FF.ContainsText(sValue));

            // Input a zip code
            iIndex = test.para.aKey.IndexOf("SCF");
            sAdd = (string)test.para.aAddress[iIndex];
            sValue = (string)test.para.aValue[iIndex];
            test.FF.TextField(Find.ById(sAdd)).TypeText(sValue);

            // Click "Next" button
            iIndex = test.para.aKey.IndexOf("Next3");
            sAdd = (string)test.para.aAddress[iIndex];
            test.FF.Span(Find.ByText(sAdd)).Click();
        }

        //Selected the entire US
        private void SelectAreabyUS(Testbase test)
        {
            //
        }

        private void SelectAreabyClosestRecords(Testbase test)
        {
            // Wait for the page to appear
            iIndex = test.para.aKey.IndexOf("ByClosestRecordPage_Index");
            sValue = (string)test.para.aValue[iIndex];

            test.FF.WaitUntilContainsText(sValue);
            Assert.IsTrue(test.FF.ContainsText(sValue));

            Thread.Sleep(5000);

            iIndex = test.para.aKey.IndexOf("Fill_Address");
            sAdd = (string)test.para.aAddress[iIndex];
            sValue = (string)test.para.aValue[iIndex];
            test.FF.TextField(Find.ById(sAdd)).Select();

            int iCount = 0;
            while ((iCount < 60000) & (test.FF.TextField(Find.ById(sAdd)).Text != sValue))
            {
                test.FF.TextField(Find.ById(sAdd)).TypeText(sValue);
                iCount++;
                Thread.Sleep(500);
            }

            iIndex = test.para.aKey.IndexOf("Fill_Quantity");
            sAdd = (string)test.para.aAddress[iIndex];
            sValue = (string)test.para.aValue[iIndex];
            test.FF.TextField(Find.ById(sAdd)).Select();
            while ((iCount < 60000) & (test.FF.TextField(Find.ById(sAdd)).Text != sValue))
            {
                test.FF.TextField(Find.ById(sAdd)).TypeText(sValue);
                iCount++;
                Thread.Sleep(500);
            }

            Thread.Sleep(1000);
            // Click "Search" button
            iIndex = test.para.aKey.IndexOf("Search");
            sAdd = (string)test.para.aAddress[iIndex];
            test.FF.Span(Find.ByText(sAdd)).Click();
            Thread.Sleep(1000);

            // Click "Next" button
            iIndex = test.para.aKey.IndexOf("Next3");
            sAdd = (string)test.para.aAddress[iIndex];
            test.FF.Span(Find.ByText(sAdd)).Click();
        
        }


    }
}
