//#*****************************************************************************
//# Purpose: 3方订单定金付款
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

namespace zjsteel.task.T002_3rdorder
{
    [TestFixture]
    public class T002_3rdhalfpayment : SignIn
    {
        [Test]
        public void T01_Check_3rdorder_halfpayment()
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
            TestUserSignIn(UN2, PW2);

            //采购商购买
            placeorder pl = new placeorder();
            pl.TestUserplaceorder(browser, targetHost, MT, DT1, NUM, OT1, BU);

            //付款
            fullpay fl = new fullpay();
            fl.TestUserfullpay(browser, PY2);

            //定金付款
            halfpay hfl = new halfpay();
            hfl.TestUserhalfpay(browser, PY2);

            //退出功能，

            SignOut so1 = new SignOut();
            so1.TestUserSignOut(browser);

            //平台登陆
            TestUserSignIn(UN, PW);

            //gototrade
            gototrade gt1 = new gototrade();
            gt1.TestUsergototrade(browser);

            //可提资源
            ladingbillsearch ld1 = new ladingbillsearch();
            string orderid = fullpay.orderid;

            int o1 = int.Parse(orderid);
            int o2 = o1 + 1;
            string orderid1 = o2.ToString();
            ld1.TestUserladingbillsearch(browser, targetHost, orderid1);



            //可提资源管理
            ladbillmanageadmin lm1 = new ladbillmanageadmin();
            lm1.TestUserladingbillmanageadmin(browser, targetHost);


            //退出功能，

            SignOut so2 = new SignOut();
            so2.TestUserSignOut(browser);

            //采购商登陆
            TestUserSignIn(UN2, PW2);

            //gototrade
            gototrade gt2 = new gototrade();
            gt2.TestUsergototrade(browser);

            //可提资源
            ladingbillsearch ld2 = new ladingbillsearch();
            ld2.TestUserladingbillsearch(browser, targetHost, orderid);

            //可提资源管理
            ladbillmanage lm2 = new ladbillmanage();
            lm2.TestUserladingbillmanage(browser, targetHost);

            //提单密码查询
            messagesql mes1 = new messagesql();
            mes1.TestUsermessagesql(browser, TID);

            //退出功能，
            SignOut so3 = new SignOut();
            so3.TestUserSignOut(browser);


            //仓库用户登陆
            TestUserSignIn(SCK, SCKPW);

            verifylad V1 = new verifylad();
            string ladid = messagesql.ladid;
            string ladpw = messagesql.ladpw;
            V1.TestUserverifylad(browser, ladid, ladpw);

        }
    }
}
