//#*****************************************************************************
//# Purpose: notes message search
//# Author:  bobby
//# Create Date: apr 13, 2009
//# Modify History: 
//# 
//#*****************************************************************************
using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using zjsteel.appshare.App01_HomePage;
using zjsteel.appshare;
using System.Data.OracleClient;
using System.Data;

namespace zjsteel.appshare.App01_HomePage
{
    public class messagesql
    {
        public static string ladid;
        public static string ladpw;
        public void TestUsermessagesql(Browser browser, string targetid)
        {
            //查询数据库提单密码 和 ID
            string sqlStr = @"select content from 
                                  (select * from notes order by createdate desc)
                                    where rownum <=1 and target_id=:targetID";
            System.Data.OracleClient.OracleParameter[] parms ={ 
                        new OracleParameter(":targetID",targetid)
                    };
            DataSet ds1 = OracleHelper.ExecuteDataset(OracleHelper.ConnectionString, CommandType.Text, sqlStr, parms);
            DataTable dt = ds1.Tables[0];
            string l1 = dt.Rows[0][0].ToString();

            ladid = l1.Trim().Substring(4, 10);
            ladpw = l1.Trim().Substring(20, 6);
        }
    }
}
