//#*****************************************************************************
//# Purpose: 平台购买 信用交易
//# Author:  bobby
//# Create Date: April 13, 2009
//# Modify History: 

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

namespace zjsteel.task.T005_tradebycredit
{
    [TestFixture]
    public class T001_tradebycredit:SignIn
    {
        [Test]
        public void T01_Check_tradebycredit()
        {
            //供应商登陆
            TestUserSignIn(UN1, PW1);

            //挂牌资源
            salesource sl = new salesource();
            sl.TestUsersales(browser, BS, LS, SZ, MT, MD, WT, PR, DT1, DT, SH1);

            //退出功能，

            SignOut so = new SignOut();
            so.TestUserSignOut(browser);

            //采购商登陆
            TestUserSignIn(UN, PW);

            //采购商购买
            placeordertradebycredit pl = new placeordertradebycredit();
            pl.TestUserplaceordertradebycredit(browser, targetHost, MT, DT1, NUM, OT2, BU);

            

            //可提资源
            ladingbillsearch ld1 = new ladingbillsearch();
            string temp = placeordertradebycredit.orderid1;
            string orderid1 = temp.Trim().Substring(0, 10);
            ld1.TestUserladingbillsearch(browser, targetHost, orderid1);



            //可提资源管理
            ladbillmanageadmin lm1 = new ladbillmanageadmin();
            lm1.TestUserladingbillmanageadmin(browser, targetHost);


        }

    }
}
