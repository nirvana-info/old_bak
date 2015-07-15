using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading;
using WatiN.Core;
using NUnit.Framework;

namespace SL360Test_Iris
{
    public class PlaceOrder
    {
        private int iIndex;
        private string sAdd;
        private string sValue;


        public void JudgeCounting(Testbase test)
        {
            // Wait until the page appears
            iIndex = test.para.aKey.IndexOf("CountAndQuotePage_Index");
            sAdd = (string)test.para.aAddress[iIndex];
            
            int iCount1 = 0;
            int iCount2 = 0;
            Thread.Sleep(10000);
            while ((iCount1 == 0) & iCount2 < 200000)
            {
                if (test.FF.Span(Find.ByText(sAdd)).Exists)
                {
                    iCount1 = 1;
                }
                iCount2++;

            }
            Thread.Sleep(20000);

            if (test.para.sDatasource == "ctl00_ctl00_uxContent_uxContent_rbListType_2")
            {
                Occ_PlaceOrder(test);
                return;
                //Datasource occ's counting page is different, I have to make a different function.
                
            }
            // Judge the number of count.If it's less than 100, placing order is forbidden.
            iIndex = test.para.aKey.IndexOf("Count Judgement");
            sAdd = (string)test.para.aAddress[iIndex];
            sValue = (string)test.para.aValue[iIndex];

            iIndex = test.para.aKey.IndexOf("SelectAreaType");
            string sByAreas = (string)test.para.aAddress[iIndex];
     
            int iTotal;
            if (sByAreas == "geo_type_radius")
            {
                iTotal = Convert.ToInt32(test.FF.Table(sAdd).OwnTableRows[test.FF.Table(sAdd).OwnTableRows.Count - 1].TextFields[0].Value);                
            }
            else
            {
                iTotal = Convert.ToInt32(test.FF.Table(sAdd).TextFields[test.FF.Table(sAdd).TextFields.Count - 1].Value);
            }                     

            int iSetTotalNumber = Convert.ToInt32(sValue);

            iIndex = test.para.aKey.IndexOf("Select: Save Count(T) or Next(F)");
            string sSaveCount = (string)test.para.aValue[iIndex];

            if(sSaveCount == "False") // Click "Next"
            { 
                if(iTotal < 100) // Warning information shown, and not goto next page.
                {
                    iIndex = test.para.aKey.IndexOf("Address of Save Count or Next");
                    sValue = (string)test.para.aValue[iIndex];

                    test.FF.Span(Find.ByText(sValue)).Click();

                    CountLessThanLimitation(test);
                }
                else // Goto Filling Payment Information page
                {
                    // Set a total number
                    if (iTotal > iSetTotalNumber)
                    {
                        iIndex = test.para.aKey.IndexOf("Count Judgement");
                        sAdd = (string)test.para.aAddress[iIndex];
                        test.FF.Table(sAdd).TextFields[test.FF.Table(sAdd).TextFields.Count - 1].TypeText(Convert.ToString(iSetTotalNumber));
                    }

                    Thread.Sleep(2000);

                    // Using the list for single time or multiple times?
                    iIndex = test.para.aKey.IndexOf("Using this list multiple times?");
                    sAdd = (string)test.para.aAddress[iIndex];
                    test.FF.RadioButton(Find.ById(sAdd)).Checked = true;

                    // Using mailing lables?
                    iIndex = test.para.aKey.IndexOf("Using mailing labels?");
                    sAdd = (string)test.para.aAddress[iIndex];
                    test.FF.RadioButton(Find.ById(sAdd)).Checked = true;

                    iIndex = test.para.aKey.IndexOf("Address of Save Count or Next");
                    sValue = (string)test.para.aValue[iIndex];
                    test.FF.Span(Find.ByText(sValue)).Click();

                    // File payment information
                    FillInformation(test);
                
                }
            }
            else if (sSaveCount == "True") // Clck "Save Count"
            {
                iIndex = test.para.aKey.IndexOf("Address of Save Count or Next");
                sValue = (string)test.para.aValue[iIndex];

                test.FF.Span(Find.ByText(sValue)).Click();

                SaveCount(test);
            }
  
        }
        
        // The Count & Quote page of Occ lead is diffrent from those of other datasources
        private void Occ_PlaceOrder(Testbase test)
        {
            iIndex = test.para.aKey.IndexOf("Count Judgement");
            sAdd = (string)test.para.aAddress[iIndex];
            sValue = (string)test.para.aValue[iIndex];

            int iTotal;            
            int iTableCellCount = test.FF.Table(Find.ByClass(sAdd)).TableRows[2].TableCells.Count;
            iTotal = Convert.ToInt32(test.FF.Table(Find.ByClass(sAdd)).Span(Find.ById(sValue)).Text);
            
            iIndex = test.para.aKey.IndexOf("Select: Save Count(T) or Next(F)");
            string sSaveCount = (string)test.para.aValue[iIndex];

            if (sSaveCount == "False") // Click "Next"
            {
                if (iTotal < 100) // Warning information shown, and not goto next page.
                {
                    iIndex = test.para.aKey.IndexOf("Address of Save Count or Next");
                    sValue = (string)test.para.aValue[iIndex];

                    test.FF.Span(Find.ByText(sValue)).Click();

                    CountLessThanLimitation(test);
                }
                else // Goto Filling Payment Information page
                {
                    // Using the list for single time or multiple times?
                    iIndex = test.para.aKey.IndexOf("Using this list multiple times?");
                    sAdd = (string)test.para.aAddress[iIndex];
                    test.FF.RadioButton(Find.ById(sAdd)).Checked = true;

                    // Using mailing lables?
                    iIndex = test.para.aKey.IndexOf("Using mailing labels?");
                    sAdd = (string)test.para.aAddress[iIndex];
                    test.FF.RadioButton(Find.ById(sAdd)).Checked = true;

                    iIndex = test.para.aKey.IndexOf("Address of Save Count or Next");
                    sValue = (string)test.para.aValue[iIndex];
                    test.FF.Span(Find.ByText(sValue)).Click();

                    // File payment information
                    FillInformation(test);

                }
            }
            else if (sSaveCount == "True") // Clck "Save Count"
            {
                iIndex = test.para.aKey.IndexOf("Address of Save Count or Next");
                sValue = (string)test.para.aValue[iIndex];

                test.FF.Span(Find.ByText(sValue)).Click();

                SaveCount(test);
            }
        }

        // When count is less than 100, warn information should be shown to remind users
        private void CountLessThanLimitation(Testbase test)
        {
            test.FF.WaitUntilContainsText("The quantity that you desired is less than the minimum quantity of 100.");
            Assert.IsTrue(test.FF.ContainsText("The quantity that you desired is less than the minimum quantity of 100."));
        }

        // Click "Save Count" button
        private void SaveCount(Testbase test)
        {
            // Wait until the page appears
            iIndex = test.para.aKey.IndexOf("SaveCountDialog_Index");
            sValue = (string)test.para.aValue[iIndex];

            test.FF.WaitUntilContainsText(sValue);
            Assert.IsTrue(test.FF.ContainsText(sValue));

            // Fill save information
            iIndex = test.para.aKey.IndexOf("Save_Firstname");
            sAdd = (string)test.para.aAddress[iIndex];
            sValue = (string)test.para.aValue[iIndex];
            test.FF.TextField(Find.ById(sAdd)).TypeText(sValue);

            iIndex = test.para.aKey.IndexOf("Save_Lastname");
            sAdd = (string)test.para.aAddress[iIndex];
            sValue = (string)test.para.aValue[iIndex];
            test.FF.TextField(Find.ById(sAdd)).TypeText(sValue);

            iIndex = test.para.aKey.IndexOf("Save_Email");
            sAdd = (string)test.para.aAddress[iIndex];
            sValue = (string)test.para.aValue[iIndex];
            test.FF.TextField(Find.ById(sAdd)).TypeText(sValue);

            iIndex = test.para.aKey.IndexOf("Save_Ordername");
            sAdd = (string)test.para.aAddress[iIndex];
            sValue = (string)test.para.aValue[iIndex];
            test.FF.TextField(Find.ById(sAdd)).TypeText(sValue);

            iIndex = test.para.aKey.IndexOf("SaveCount button");            
            sAdd = (string)test.para.aAddress[iIndex];
            test.FF.Span(Find.ByText(sAdd)).Click();

            JudgeSaveCountComplete(test);
        }

        // Click "Next" Button
        private void FillInformation(Testbase test)
        {
            // Wait until the page appears
            iIndex = test.para.aKey.IndexOf("PaymentInformationPage_Index");
            sValue = (string)test.para.aAddress[iIndex];

            test.FF.WaitUntilContainsText(sValue);
            Assert.IsTrue(test.FF.ContainsText(sValue));

            // Fill information
            iIndex = test.para.aKey.IndexOf("Information_Firstname");
            sAdd = (string)test.para.aAddress[iIndex];
            sValue = (string)test.para.aValue[iIndex];
            test.FF.TextField(Find.ById(sAdd)).TypeText(sValue);

            iIndex = test.para.aKey.IndexOf("Information_Lastname");
            sAdd = (string)test.para.aAddress[iIndex];
            sValue = (string)test.para.aValue[iIndex];
            test.FF.TextField(Find.ById(sAdd)).TypeText(sValue);

            iIndex = test.para.aKey.IndexOf("Information_Address");
            sAdd = (string)test.para.aAddress[iIndex];
            sValue = (string)test.para.aValue[iIndex];
            test.FF.TextField(Find.ById(sAdd)).TypeText(sValue);

            iIndex = test.para.aKey.IndexOf("Information_City");
            sAdd = (string)test.para.aAddress[iIndex];
            sValue = (string)test.para.aValue[iIndex];
            test.FF.TextField(Find.ById(sAdd)).TypeText(sValue);

            iIndex = test.para.aKey.IndexOf("Information_State");
            sAdd = (string)test.para.aAddress[iIndex];
            sValue = (string)test.para.aValue[iIndex];
            test.FF.SelectList(Find.ById(sAdd)).Option(Find.ByValue(sValue)).Select();

            iIndex = test.para.aKey.IndexOf("Information_Zip");
            sAdd = (string)test.para.aAddress[iIndex];
            sValue = (string)test.para.aValue[iIndex];
            test.FF.TextField(Find.ById(sAdd)).TypeText(sValue);

            iIndex = test.para.aKey.IndexOf("Information_Email");
            sAdd = (string)test.para.aAddress[iIndex];
            sValue = (string)test.para.aValue[iIndex];
            test.FF.TextField(Find.ById(sAdd)).TypeText(sValue);

            iIndex = test.para.aKey.IndexOf("Information_Ordername");
            sAdd = (string)test.para.aAddress[iIndex];
            sValue = (string)test.para.aValue[iIndex];
            test.FF.TextField(Find.ById(sAdd)).TypeText(sValue);

            iIndex = test.para.aKey.IndexOf("Information_SameAsContact");
            sAdd = (string)test.para.aAddress[iIndex];            
            test.FF.CheckBox(Find.ById(sAdd)).Checked = true;

            iIndex = test.para.aKey.IndexOf("Information_PaymentAgreement");
            sAdd = (string)test.para.aAddress[iIndex];
            test.FF.CheckBox(Find.ById(sAdd)).Checked = true;

            iIndex = test.para.aKey.IndexOf("Information_CardNumber");
            sAdd = (string)test.para.aAddress[iIndex];
            sValue = (string)test.para.aValue[iIndex];
            test.FF.TextField(Find.ById(sAdd)).TypeText(sValue);

            iIndex = test.para.aKey.IndexOf("Information_SecurityCode");
            sAdd = (string)test.para.aAddress[iIndex];
            sValue = (string)test.para.aValue[iIndex];
            test.FF.TextField(Find.ById(sAdd)).TypeText(sValue);

            iIndex = test.para.aKey.IndexOf("Place Order");
            sValue = (string)test.para.aValue[iIndex];
            test.FF.Span(Find.ByText(sValue)).Click();

            JudgeOrderComplete(test);
        }

        // Check whether or not the order has been finished.
        private void JudgeOrderComplete(Testbase test)
        {
            iIndex = test.para.aKey.IndexOf("OrderCompletePage_Index");
            sValue = (string)test.para.aAddress[iIndex];
            test.FF.WaitUntilContainsText(sValue);
            Assert.IsTrue(test.FF.ContainsText(sValue));
        }

        // Check whether or not the order has been finished.
        private void JudgeSaveCountComplete(Testbase test)
        {
            iIndex = test.para.aKey.IndexOf("AfterSave");
            sValue = (string)test.para.aAddress[iIndex];
            test.FF.WaitUntilContainsText(sValue);
            Assert.IsTrue(test.FF.ContainsText(sValue));
        }
    }
}
