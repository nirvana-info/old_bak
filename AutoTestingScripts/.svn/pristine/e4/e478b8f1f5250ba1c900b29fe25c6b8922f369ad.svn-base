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
        public string url = "http://192.168.0.20:8111";

        [SetUp]
        public void SetupTest()
        {
            


            selenium = new DefaultSelenium("localhost", 4444, "*firefox", url);
            selenium.SetSpeed("1000");
            selenium.Start();
            verificationErrors = new StringBuilder();
            selenium.Open("");
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
