using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Collections;
using WatiN.Core;
using NUnit.Framework;


namespace SL360Test_Iris
{
    public class Login
    {
        public void UserLogin(Testbase test)
        {
            ArrayList aAddress = test.para.aAddress;
            ArrayList aKey = test.para.aKey;
            ArrayList aValue = test.para.aValue;

            int iIndex;
            iIndex = aKey.IndexOf("Account");
            test.FF.TextField(Find.ById((string)aAddress[iIndex])).TypeText((string)aValue[iIndex]);

            iIndex = aKey.IndexOf("Password");
            test.FF.TextField(Find.ById((string)aAddress[iIndex])).TypeText((string)aValue[iIndex]);

            iIndex = aKey.IndexOf("Submit Button");
            test.FF.Button(Find.ById((string)aAddress[iIndex])).Click();
        }
    }
}
