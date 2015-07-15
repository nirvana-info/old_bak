using System;
using System.Collections.Generic;
using System.Text;
using WatiN.Core;

using WatiN.Core.Interfaces;
using WatiN.Core.DialogHandlers;

//#*****************************************************************************
//# Purpose: 定义公共参数
//# Author:  bobby
//# Create Date: April 13, 2009
//# Modify History: 

//#*****************************************************************************
namespace zjsteel.appshare
{
    public class PublicPara
    {

        
        //平台用户
        public string UN = System.Configuration.ConfigurationManager.AppSettings["UserName"];
        public string PW = System.Configuration.ConfigurationManager.AppSettings["PassWord"];
        public string PL = System.Configuration.ConfigurationManager.AppSettings["Platform"];
        public string CompanySymbol = System.Configuration.ConfigurationManager.AppSettings["CompanySymbol"];
        public string CompanyName = System.Configuration.ConfigurationManager.AppSettings["CompanyName"];

        
        protected string targetHost = string.Empty;
        public Browser browser = null;

        //平台仓库管理员
        public string CK = "wowck";
        public string CKPW = "123456";
        //供应商
        public string UN1 = "auto001";
        public string PW1 = "123456";
        public string SCK = "auto001ck";
        public string SCKPW = "123456";
        public string SYJ = "auto001yj";
        public string SYJPW = "123456";

        //采购商
        public string UN2 = "auto002";
        public string PW2 = "123456";
        public string PY2 = "1149";

        public string UN4 = "auto003";
        public string PW4 = "123456";
        //自主供应商
        public string UN3 = "tony002";
        public string PW3 = "123456";
        public string SCK3 = "tony002ck";
        public string SCKPW3 = "123456";

        //选择资源大类和小类
        public string BS = "线材";
        public string LS = "焊接用钢盘条";
        //规格
        public string SZ = "11";
        //材质
        public string MT = "脚本";
        //厂家
        public string MD = "脚本";

        //重量
        public string WT = "1";
        
        //价格
        public string PR = "1000";
        //日期
        public string DT = DateTime.Today.ToString("yyyy-MM-dd");
        public string DT1 = DateTime.Today.ToString("yyyyMMdd");
        //仓库
        public string SH = "平台仓库";
        public string SH1 = "自动供应商仓库";
        public string SH2 = "tony自主仓库";
        public string SH3 = "系统默认仓库(名称可以修改)";
        //数量
        public string NUM = "1";
        //订单类型
        public string OT = "全额预付";
        public string OT1 = "定金";
        public string OT2 = "信用";
        //订单生效、议价按钮
        public string BU = "btnNoBargain";
        public string BU1 = "btnBargain";

        //供应商
        public string testuser = "knight002";
        public string testpwd = "123456";

        //message targetid
        public string TID = "1949";
        //pricetype
        public string PRT1 = "2";
        public string PRT2 = "3";

        //浏览器
        public string ibrowser = "iexplore";
        public string fbrowser = "firefox";

    }
}
