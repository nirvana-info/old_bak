//#*****************************************************************************
//# Purpose: Public Parameters 
//# Author:  Christie Duan
//# Create Date: Mar 10, 2009
//# Modify History: 
//#*****************************************************************************

using System;
using System.Collections.Generic;
using System.Text;
using WatiN.Core;

using WatiN.Core.Interfaces;
using WatiN.Core.DialogHandlers;


namespace MaiaRegression.Appobjects
{
    public class PublicPara
    {
        //www.qa.maia.com
        //jaylen1---z3cc0Q@Passw0rd
        //percyzhao1---Zecco111
        //test22---z3cc0Q@Passw0rd
        //tonyleachsf---Passw0rd
        //bsteel---z3cc0Q@Passw0rd

        public string PL = System.Configuration.ConfigurationManager.AppSettings["Platform"];
        public string CompanySymbol = System.Configuration.ConfigurationManager.AppSettings["CompanySymbol"];
        public string CompanyName = System.Configuration.ConfigurationManager.AppSettings["CompanyName"];
        protected string targetHost = string.Empty;
        public Browser browser = null;
        public string URL = "https://www.qa.zecco.com";
        public string AdminUrl = "https://admin.qa.zecco.com";
        public string OLAAdminUrl = "http://apply.admin.qa.zecco.com/Login.aspx";

        public string UN = "tonyleachsf";
        public string PW = "password";
        //public string PW = "Passw0rd";
        public string SA = "qa";
        public string UN1 = "jaylen";
        //jay~!&(-={len jay]:;"'</len
        public string PW1 = "Jaylen0520";
        public string UN2 = "jaylen1";
        public string PW2 = "password";
        public string UN3 = "percyzhao1";
        public string PW3 = "password";
        public string UN_PwdRst = "kevin1985_003";
        public string PW_PwdRst_Old = "Passw0rd";
        public string PW_PwdRst_New = "Passw0rd1";
        public string UN_OLA = "kevin1985_003";
        public string PW_OLA = "Passw0rd";
        public string UN_BizTrust = "kevin1985_006";
        public string PW_BizTrust = "Passw0rd";
        public string UN_Custodial = "kevin1985_007";
        public string PW_Custodial = "Passw0rd";
        public string UN_OLAAdmin = "test";
        public string PW_OLAAdmin = "password";
        public int CharLimit = 140;

        public string symbol1 = "aapl";
        public string symbol2 = "dell";
        public string symbol3 = "dpdw";
        public string symbol4 = "ibm";

        //date
        public string Date = DateTime.Today.ToString("yyyyMMdd");
        public string Date2 = DateTime.Today.ToString("MM/dd/yyyy");
        //public string DT1 = DateTime.Today.ToString("yyyyMMdd");
        //public string DT2 = DateTime.Today.ToString("yyyyMMddmmss");
        public string Ti = DateTime.Now.ToString("hhmmss");

    }
}
