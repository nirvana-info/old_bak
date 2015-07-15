using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Collections;
using WatiN.Core;
using NUnit.Framework;


namespace SL360Test_Iris
{
    public class DataSource
    {
        public void SelectDataSource(Testbase test)
        {
            int iIndex = test.para.aKey.IndexOf("DatasourcePage_Index");           
            string sValue = (string)test.para.aValue[iIndex];
            string sAddress;

            test.FF.WaitUntilContainsText(sValue);
            Assert.IsTrue(test.FF.ContainsText(sValue));
           
            // Get Datasource lead           
            iIndex = test.para.aKey.IndexOf("Datasource");
            sAddress = (string)test.para.aAddress[iIndex];
            test.para.sDatasource = sAddress;

            test.FF.RadioButton(sAddress).Checked = true;

            // Get ID of Next button
            iIndex = test.para.aKey.IndexOf("Next1");
            sValue = (string)test.para.aValue[iIndex];

            test.FF.Span(Find.ByText(sValue)).Click();            
        }

    }
}
