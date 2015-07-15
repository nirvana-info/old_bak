//#*****************************************************************************
//# Purpose: Public Parameters 
//# Author:  Christie Duan
//# Create Date: Mar 10, 2009
//# Modify History: 
//#*****************************************************************************

using System;
using System.Collections.Generic;
using System.Text;
using System.Configuration;

namespace MaiaRegression.Appobjects
{
    public class PublicPara
    {

        

        public string UserName = System.Configuration.ConfigurationManager.AppSettings["UserName"];
        public string PassWord = System.Configuration.ConfigurationManager.AppSettings["PassWord"];
        public string PL = System.Configuration.ConfigurationManager.AppSettings["Platform"];
        public string CompanySymbol = System.Configuration.ConfigurationManager.AppSettings["CompanySymbol"];
        public string CompanyName = System.Configuration.ConfigurationManager.AppSettings["CompanyName"];
    }
}
