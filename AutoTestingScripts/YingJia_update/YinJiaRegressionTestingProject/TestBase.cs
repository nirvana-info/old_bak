using System;
using System.Text;
using System.Text.RegularExpressions;
using System.Threading;
using NUnit.Framework;
using Selenium;

namespace YinJiaRegressionTestingProject
{

    public class TestBase
    {
        public ISelenium selenium;
        private StringBuilder verificationErrors;
        public string url = "http://csdrp.szyingjia.org";
        public string url1 = "http://csdrp.szyingjia.org/portal";
        

        [SetUp]
        public void SetupTest()
        {



            selenium = new DefaultSelenium("localhost", 4444, "*firefox", url1);

           
            selenium.SetSpeed("1000");
            selenium.Start();
            selenium.SetTimeout("60000");

            verificationErrors = new StringBuilder();
            selenium.Open(url1);


            selenium.WindowMaximize();

            //selenium.KeyDown(ID, "13");//enter key
            
        }

       /* [TearDown]
        public void TeardownTest()
        {
            try
            {
                selenium.Stop();
            }
            catch (Exception)
            {
                // Ignore errors if unable to close the browser
            }
            //Assert.AreEqual("", verificationErrors.ToString());
        }*/

        public void Userlogin(string username, string password)
        {
            //WatiForElement("//div[@id='frmLogin']/div/div/div[2]/div/div/img", 20);
            //selenium.Click("//div[@id='frmLogin']/div/div/div[2]/div/div/img");
            //WatiForElement("//body[@class='oneColElsCtrHdr  ext-gecko ext-gecko3']/div[7]/div", 20);
            //selenium.Click("//body[@class='oneColElsCtrHdr  ext-gecko ext-gecko3']/div[7]/div"); //选择零售管理
            selenium.Type("txtUsername", username);
            selenium.Type("txtPassword",password);
            WatiForClick("//table[@id='btnLogin']/tbody/tr/td[2]/em/button", 30);
            WatiForElement("imgLogout", 20);     //检查login成功
        
        }

        public void Userlogout()
        {
            selenium.Click("//img[@id='imgLogout']");
            selenium.Click("//div[@class='x-panel-btns x-panel-btns-center']/table/tbody/tr/td[2]/table/tbody/tr/td[2]/em/button");
        }

        public void WatiForClick(string Element, int time)
        {
            int i;
            for (i = 0; i <= time; ++i)
            {
                if (selenium.IsElementPresent(Element) == false)
                {
                    Thread.Sleep(1000);
                }
                else
                {
                    selenium.Click(Element);
                    break;
                }
            }

        }
        public void WatiForElement(string Element, int time)
        {
            int i;
            for (i = 0; i <= time; ++i)
            {
                if (selenium.IsElementPresent(Element) == false)
                {
                    Thread.Sleep(1000);
                }
                else
                {
                    break;
                }
            }
            //if (selenium.IsElementPresent(Element) == false)
            //{
            //    return false;
            //}
            //else
            //{
            //    Console.Write("The Element "+Element+" cannot be found in "+time+"secs!" );
            //    return true;
            //}
        }

        public void WaitForDisappear(string Element, int time)
        {
            int i;
            for (i = 0; i <= time; ++i)
            {
                if (selenium.IsVisible(Element) == true)
                {
                    Thread.Sleep(1000);
                }
                else
                {
                    break;
                }
            
            }

     
         
        }
     
               
         
       /* [Test]
        public void test()
        {
            selenium.Open("http://www.google.com");
            selenium.Type("q", "selenium");
            selenium.Click("btnG");
            Assert.IsTrue(selenium.IsTextPresent("selenium"));
            
        }*/
    }
}
