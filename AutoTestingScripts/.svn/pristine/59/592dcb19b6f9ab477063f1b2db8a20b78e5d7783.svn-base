//#*****************************************************************************
//# Purpose: 2方订单全额付款
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

namespace zjsteel.task.T001_2ndorder
{
    [TestFixture]
    public class T001_fullpayment:SignIn
    {

        
        [Test]
        public void T01_Check_2ndorder_fullpayment()
        {
            //平台用户登陆
            TestUserSignIn(UN, PW);

            //挂牌资源
            salesource sl = new salesource();
            sl.TestUsersales(browser, BS, LS,SZ,MT,MD,WT,PR,DT1,DT,SH);
            
            //退出功能，
            
            SignOut so = new SignOut();
            so.TestUserSignOut(browser);

            //采购商登陆
            TestUserSignIn(UN2, PW2);
            
            //采购商购买
            placeorder pl = new placeorder();
            pl.TestUserplaceorder(browser, targetHost,MT, DT1, NUM, OT, BU);

            //付款
            fullpay fl = new fullpay();
            fl.TestUserfullpay(browser, PY2);
            
            //可提资源
            ladingbillsearch ld1 = new ladingbillsearch();
            string orderid = fullpay.orderid;
            ld1.TestUserladingbillsearch(browser, targetHost, orderid);

            

            //可提资源管理
            ladbillmanage lm1 = new ladbillmanage();
            lm1.TestUserladingbillmanage(browser, targetHost);

            //提单密码查询
            messagesql mes1 = new messagesql();
            mes1.TestUsermessagesql(browser, TID);
            
            //退出功能，
            SignOut so1 = new SignOut();
            so1.TestUserSignOut(browser);


            //仓库用户登陆
            TestUserSignIn(CK, CKPW);

            verifylad V1 = new verifylad();
            string ladid = messagesql.ladid;
            string ladpw = messagesql.ladpw;
            V1.TestUserverifylad(browser, ladid, ladpw);
            
        }
        
        
    }
}
