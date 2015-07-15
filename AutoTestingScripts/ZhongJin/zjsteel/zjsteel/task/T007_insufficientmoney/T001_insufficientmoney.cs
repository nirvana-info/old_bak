//#*****************************************************************************
//# Purpose: 金额不足
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

namespace zjsteel.task.T007_insufficientmoney
{
    [TestFixture]
    public class T001_insufficientmoney : SignIn
    {
        [Test]
        public void T01_Check_insufficientmoney()
        {
            //供应商用户登陆
            TestUserSignIn(UN1, PW1);

            //挂牌资源
            salesource sl = new salesource();
            sl.TestUsersales(browser, BS, LS, SZ, MT, MD, WT, PR, DT1, DT, SH1);

            //退出功能，

            SignOut so = new SignOut();
            so.TestUserSignOut(browser);

            //采购商登陆
            TestUserSignIn(UN4, PW4);

            //采购商购买
            placeorderfail pl = new placeorderfail();
            pl.TestUserplaceorderfail(browser, targetHost, MT, DT1, NUM, OT, BU);

            

            //退出功能，

            SignOut so2 = new SignOut();
            so2.TestUserSignOut(browser);

            //供应商登陆
            TestUserSignIn(UN1, PW1);

            cancelsource ce1 = new cancelsource();
            ce1.TestUsercancelsource(browser);

            

        }
    }
}
