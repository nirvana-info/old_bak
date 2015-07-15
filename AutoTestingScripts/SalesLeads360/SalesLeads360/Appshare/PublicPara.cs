using System;
using System.Collections.Generic;
using System.Text;
using WatiN.Core;

using WatiN.Core.Interfaces;
using WatiN.Core.DialogHandlers;

//#*****************************************************************************
//# Purpose: 定义公共参数
//# Author:  bobby
//# Create Date: April 27, 2009
//# Modify History: 

//#*****************************************************************************
namespace SalesLeads360.Appshare
{
    public class PublicPara
    {

        
        //
        public string UN = System.Configuration.ConfigurationManager.AppSettings["UserName"];
        public string PW = System.Configuration.ConfigurationManager.AppSettings["PassWord"];
        public string PL = System.Configuration.ConfigurationManager.AppSettings["Platform"];
        public string CompanySymbol = System.Configuration.ConfigurationManager.AppSettings["CompanySymbol"];
        public string CompanyName = System.Configuration.ConfigurationManager.AppSettings["CompanyName"];


        protected string targetHost = "http://192.168.0.20:8080/";
        public Browser browser = null;
        public string Date = DateTime.Today.ToString("yyyyMMdd");

       //leadstype
        public string lt1 = "tab_icon_1";
        public string lt2 = "tab_icon_2";
        public string lt3 = "tab_icon_3";
        public string lt4 = "tab_icon_4";
        public string lt5 = "tab_icon_5";
        public string lt6 = "tab_icon_6";

        public string tt1 = "Consumer Leads";
        public string tt2 = "Business Leads";
        public string tt3 = "Occupant Lists";
        public string tt4 = "New Homeowner Lists";
        public string tt5 = "New Mover Lists";
        public string tt6 = "Specialty Lists";

        //orderpath
                             
        public string op0 = "ctl00_ctl00_uxContent_ContentPlaceHolder1_RBLGeoType_0";
        public string op1 = "ctl00_ctl00_uxContent_ContentPlaceHolder1_RBLGeoType_1";
        public string op2 = "ctl00_ctl00_uxContent_ContentPlaceHolder1_RBLGeoType_2";
        public string op3 = "ctl00_ctl00_uxContent_ContentPlaceHolder1_RBLGeoType_3";
        public string op4 = "ctl00_ctl00_uxContent_ContentPlaceHolder1_RBLGeoType_4";
        public string op5 = "ctl00_ctl00_uxContent_ContentPlaceHolder1_RBLGeoType_5";
        public string op6 = "ctl00_ctl00_uxContent_ContentPlaceHolder1_RBLGeoType_6";
        public string op7 = "ctl00_ctl00_uxContent_ContentPlaceHolder1_RBLGeoType_7";

        //zipcode
        public string zp1 = "10017";
        public string zp2 = "100";


        //browser
        public string ibrowser = "iexplore";
        public string fbrowser = "firefox";

        // upload path
        public string UploadZipPath = "E:\\Work Document\\Upload_Zip.xls";
        public string UploadLeadsPath = "E:\\Work Document\\Upload.xls";

        //user login
        public string loginPage = "http://192.168.0.20:8080/sl360/login.aspx";
       // public string loginPage = "http://192.168.190.100:9000/common/login.aspx";
        public string CountEmail = "christie.duan@nirvana-info.com";
        public string CountPW = "123456";
        public string FileType;
    }
}
