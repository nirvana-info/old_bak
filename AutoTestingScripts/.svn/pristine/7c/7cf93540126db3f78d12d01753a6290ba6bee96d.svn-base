//#*****************************************************************************
//# Purpose: 3方订单全额付款
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

namespace zjsteel.task.T004_discount
{
    [TestFixture]
    public class T001_discount : SignIn
    {
        [Test]
        public void T01_Check_discount()
        {
            //供应商登陆
            TestUserSignIn(UN1, PW1);

            //挂牌资源
            salesource sl = new salesource();
            sl.TestUsersales(browser, BS, LS, SZ, MT, MD, WT, PR, DT1, DT, SH1);

            

            //退出功能，

            SignOut so = new SignOut();
            so.TestUserSignOut(browser);

            //平台登陆
            TestUserSignIn(UN, PW);
            //gototrade
            gototrade gt3 = new gototrade();
            gt3.TestUsergototrade(browser);

            //设置折扣
            adddiscount ad1 = new adddiscount();
            ad1.TestUseradddiscount(browser, DT);
            
            //退出功能，

            SignOut so1 = new SignOut();
            so1.TestUserSignOut(browser);
            
            //采购商登陆
            TestUserSignIn(UN2, PW2);

            //采购商购买
            checkdiscount ck1 = new checkdiscount();
            ck1.TestUsercheckdiscount(browser, targetHost, MT, DT1, NUM);

            //退出功能，

            SignOut so2 = new SignOut();
            so2.TestUserSignOut(browser);

            //供应商登陆
            TestUserSignIn(UN1, PW1);

            cancelsource ce1 = new cancelsource();
            ce1.TestUsercancelsource(browser);

            SignOut so4 = new SignOut();
            so4.TestUserSignOut(browser);

            //平台登陆
            TestUserSignIn(UN, PW);

            //gototrade
            gototrade gt4 = new gototrade();
            gt4.TestUsergototrade(browser);

            string raid = adddiscount.raid;
            string temp = raid.Trim().Substring(6, 12);
            canceldiscont cs1 = new canceldiscont();
            cs1.TestUsercanceldiscont(browser,raid,temp);
        }

    }
}
