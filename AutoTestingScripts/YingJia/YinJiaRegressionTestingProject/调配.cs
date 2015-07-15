using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using NUnit.Framework;
using Selenium;

namespace YinJiaRegressionTestingProject
{
    [TestFixture]
    public class 调配:TestBase
    {
        [Test]
        public void Step01门店日常补货申请()
        {
            selenium.Click("link=LOGIN");
            selenium.Type("txtUsername", "npos_it0001");
            WatiForClick("ext-gen67", 30);//门店用户登录


            selenium.Open(url + "/Portal/PU/Order/ReplenishReqest.aspx?OrderRoleType=60&IsTransfer=Y"); //选择自营补货申请

            WatiForElement("//table[@id='ctl00_contentPlaceHolder_btnNew']/tbody/tr/td[2]/em/button", 20);
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_btnNew']/tbody/tr/td[2]/em/button");//新增

            WatiForElement("ctl00_contentPlaceHolder_uxSeller", 20);
            selenium.Click("ctl00_contentPlaceHolder_uxSeller");
            selenium.TypeKeys("ctl00_contentPlaceHolder_uxSeller","1");
            WatiForElement("//div[@class='x-layer x-combo-list']/div/div/h3/span", 20);
            selenium.Click("//div[@class='x-layer x-combo-list']/div/div/h3/span");//选处理方

            WatiForElement("//table[@id='ctl00_contentPlaceHolder_uxSaveButton']/tbody/tr/td[2]/em/button", 20);
            selenium.Click("//table[@id='ctl00_contentPlaceHolder_uxSaveButton']/tbody/tr/td[2]/em/button");//保存

            WatiForElement("txtNewItemCode", 20);
            selenium.Type("txtNewItemQty", "1");
            selenium.Type("txtNewItemCode", "N10A01000102807");
            selenium.SelectFrame("uxDetailTab_IFrame");

            //selenium.Submit("//form[@action='http://www.nirvana-info.cn:8111/Portal/PU/Order/ReplenishReqest.aspx?OrderRoleType=60&IsTransfer=Y']");
        }
    }
}
