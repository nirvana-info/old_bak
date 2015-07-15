using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using WatiN.Core;
using NUnit.Framework;
using System.Threading;

namespace SL360Test_Iris
{
    // This class is for getting demographic/ lifestyle/ supression information.
    public class SelectAudience
    {
        private int iIndex;
        private string sAdd;
        private string sValue;


        public void AudienceSelect(Testbase test)
        {
            iIndex = test.para.aKey.IndexOf("ByAudiencePage_Index");
            sValue = (string)test.para.aValue[iIndex];

            test.FF.WaitUntilContainsText(sValue);
            Assert.IsTrue(test.FF.ContainsText(sValue));

            if (test.para.sDatasource == "ctl00_ctl00_uxContent_uxContent_rbListType_2")
            {
                Occ_SelectDemo(test);
                return;
            }
            

            iIndex = test.para.aKey.IndexOf("Select All?");
            sAdd = (string)test.para.aAddress[iIndex];
            sValue = (string)test.para.aValue[iIndex];

            if (sValue == "True")
            {
                
                test.FF.CheckBox(Find.ById(sAdd)).Click();
            }
            else if(sValue == "False")
            {
                // Different datasources
                switch (test.para.sDatasource)
                { 
                    case "ctl00_ctl00_uxContent_uxContent_rbListType_0":
                        Consumer_SelectDemo(test);
                        break;
                    case "ctl00_ctl00_uxContent_uxContent_rbListType_1":
                        Business_SelectDemo(test);
                        break;
                    case "ctl00_ctl00_uxContent_uxContent_rbListType_2":
                        Occ_SelectDemo(test);
                        break;
                    case "ctl00_ctl00_uxContent_uxContent_rbListType_3":
                        HomeList_SelectDemo(test);
                        break;
                    case "ctl00_ctl00_uxContent_uxContent_rbListType_4":
                        Mover_SelectDemo(test);
                        break;                    
                }

                
            }
            else
            { 
                //error            
            }

            // Include phone number?
            iIndex = test.para.aKey.IndexOf("Include phone number?");
            sAdd = (string)test.para.aAddress[iIndex];            
            test.FF.RadioButton(Find.ById(sAdd)).Checked = true;

            // Suppression

            // Waiting 
            Thread.Sleep(1000);

            // Click "Next" button
            iIndex = test.para.aKey.IndexOf("Next4");
            sAdd = (string)test.para.aAddress[iIndex];  
            test.FF.Span(Find.ByText(sAdd)).Click();
        }


        private void Consumer_SelectDemo(Testbase test)
        {
            // Demo
            iIndex = test.para.aKey.IndexOf("Select Demo1");
            sAdd = (string)test.para.aAddress[iIndex];
            test.FF.Link(Find.ByText(sAdd)).Click();

            iIndex = test.para.aKey.IndexOf("Demo_Category1");
            sAdd = (string)test.para.aAddress[iIndex];
            sValue = (string)test.para.aValue[iIndex];
            test.FF.SelectList(Find.ById(sAdd)).Option(Find.ByValue(sValue)).Select();

            iIndex = test.para.aKey.IndexOf("Demo_Variable1");
            sAdd = (string)test.para.aAddress[iIndex];
            sValue = (string)test.para.aValue[iIndex];
            test.FF.SelectList(Find.ById(sAdd)).Option(Find.ByValue(sValue)).Select();
            test.FF.SelectList(Find.ById(sAdd)).Option(Find.ByValue(sValue)).DoubleClick();

            // LifeStyle
            iIndex = test.para.aKey.IndexOf("Select Demo2");
            sAdd = (string)test.para.aAddress[iIndex]; // the sAdd is "Lifestyle, Hobby & Purchase Options", but Find.ByText() cannot find it.
            test.FF.Link(Find.ByText("Lifestyle, Hobby &amp; Purchase Options")).Click();

            iIndex = test.para.aKey.IndexOf("Demo_Category2");
            sAdd = (string)test.para.aAddress[iIndex];
            sValue = (string)test.para.aValue[iIndex];
            test.FF.SelectList(Find.ById(sAdd)).Option(Find.ByValue(sValue)).Select();

            iIndex = test.para.aKey.IndexOf("Demo_Variable2");
            sAdd = (string)test.para.aAddress[iIndex];
            sValue = (string)test.para.aValue[iIndex];
            test.FF.SelectList(Find.ById(sAdd)).Option(Find.ByValue(sValue)).Select();
            test.FF.SelectList(Find.ById(sAdd)).Option(Find.ByValue(sValue)).DoubleClick(); 
        }

        private void Business_SelectDemo(Testbase test)
        {
            // Demo
            iIndex = test.para.aKey.IndexOf("Select Demo1");
            sAdd = (string)test.para.aAddress[iIndex];
            test.FF.Link(Find.ByText(sAdd)).Click();

            iIndex = test.para.aKey.IndexOf("Demo_Category1");
            sAdd = (string)test.para.aAddress[iIndex];
            sValue = (string)test.para.aValue[iIndex];            
            test.FF.SelectList(Find.ById(sAdd)).Option(Find.ByValue(sValue)).Select();

            iIndex = test.para.aKey.IndexOf("Demo_Variable1");
            sAdd = (string)test.para.aAddress[iIndex];
            sValue = (string)test.para.aValue[iIndex];
            test.FF.SelectList(Find.ById(sAdd)).Option(Find.ByValue(sValue)).Select();
            test.FF.SelectList(Find.ById(sAdd)).Option(Find.ByValue(sValue)).DoubleClick();

        }

        private void Occ_SelectDemo(Testbase test)
        {
            iIndex = test.para.aKey.IndexOf("Targeting Options");
            sAdd = (string)test.para.aAddress[iIndex];
            test.FF.CheckBox(Find.ById(sAdd)).Checked = false;

            iIndex = test.para.aKey.IndexOf("Route Options");
            sAdd = (string)test.para.aAddress[iIndex];
            test.FF.CheckBox(Find.ById(sAdd)).Checked = false;


            // Click "Next" button
            iIndex = test.para.aKey.IndexOf("Next4");
            sAdd = (string)test.para.aAddress[iIndex];
            test.FF.Span(Find.ByText(sAdd)).Click();
        }

        private void HomeList_SelectDemo(Testbase test)
        {
            // Demo
            iIndex = test.para.aKey.IndexOf("Select Demo1");
            sAdd = (string)test.para.aAddress[iIndex];
            test.FF.Link(Find.ByText(sAdd)).Click();

            iIndex = test.para.aKey.IndexOf("Demo_Category1");
            sAdd = (string)test.para.aAddress[iIndex];
            sValue = (string)test.para.aValue[iIndex];
            test.FF.SelectList(Find.ById(sAdd)).Option(Find.ByValue(sValue)).Select();

            iIndex = test.para.aKey.IndexOf("Demo_Variable1");
            sAdd = (string)test.para.aAddress[iIndex];
            sValue = (string)test.para.aValue[iIndex];
            test.FF.SelectList(Find.ById(sAdd)).Option(Find.ByValue(sValue)).Select();
            test.FF.SelectList(Find.ById(sAdd)).Option(Find.ByValue(sValue)).DoubleClick();
        }

        private void Mover_SelectDemo(Testbase test)
        {
            // Demo
            iIndex = test.para.aKey.IndexOf("Select Demo1");
            sAdd = (string)test.para.aAddress[iIndex];
            test.FF.Link(Find.ByText(sAdd)).Click();

            iIndex = test.para.aKey.IndexOf("Demo_Category1");
            sAdd = (string)test.para.aAddress[iIndex];
            sValue = (string)test.para.aValue[iIndex];
            test.FF.SelectList(Find.ById(sAdd)).Option(Find.ByValue(sValue)).Select();

            iIndex = test.para.aKey.IndexOf("Demo_Variable1");
            sAdd = (string)test.para.aAddress[iIndex];
            sValue = (string)test.para.aValue[iIndex];
            test.FF.SelectList(Find.ById(sAdd)).Option(Find.ByValue(sValue)).Select();
            test.FF.SelectList(Find.ById(sAdd)).Option(Find.ByValue(sValue)).DoubleClick();
        }
    }
}
