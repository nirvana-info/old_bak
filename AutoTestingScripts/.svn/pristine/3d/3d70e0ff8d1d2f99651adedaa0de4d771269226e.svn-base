//#*****************************************************************************
//# Purpose: 议价
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

namespace zjsteel.task.T006_bargaining
{
    [TestFixture]
    public class T001_bargaining:SignIn
    {
        [Test]
        public void T01_Check_bargaining()
        {
            //供应商用户登陆
            TestUserSignIn(UN1, PW1);

            //挂牌资源
            salesource sl = new salesource();
            sl.TestUsersales(browser, BS, LS, SZ, MT, MD, WT, PR, DT1, DT, SH1);

            changesourcetype ch1 = new changesourcetype();
            ch1.TestUserchangesourcetype(browser,PRT1);
            
            //退出功能，

            SignOut so = new SignOut();
            so.TestUserSignOut(browser);

            //采购商登陆
            TestUserSignIn(UN2, PW2);

            //采购商议价
            bargainingorder bo1 = new bargainingorder();
            bo1.TestUserbargainingorder(browser, targetHost, MT, DT1, NUM, OT, BU1);

            //退出功能，

            SignOut so1 = new SignOut();
            so1.TestUserSignOut(browser);

            //议价操作员登陆
            TestUserSignIn(SYJ,SYJPW);

            verifybargain ve1 = new verifybargain();
            ve1.TestUserverifylad(browser);

            

        }
    }
}
