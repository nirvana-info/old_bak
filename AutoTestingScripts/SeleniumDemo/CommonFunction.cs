using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading;
using Selenium;

namespace CWAdmin
{
    public static class CommonFunction
    {
        // Wait for text present. Time out is 30s.
        public static void WaitforTextPresent(string sText,ISelenium selenium)
        {
            for (int i = 0; i < 100; i++)
            {
                if (selenium.IsTextPresent(sText))
                {
                    break;
                }
                Thread.Sleep(50);
            }
        }

        // Wait for Element present. Time out is 30s.
        public static void WaitforElementPresent(string sElement,ISelenium selenium)
        {
            for (int i = 0; i < 100; i++)
            {
                if (selenium.IsElementPresent(sElement))
                {
                    break;
                }
                Thread.Sleep(50);
            }
        }



        // Login with testing account
        public static void Login(ISelenium selenium)
        {
            for (int i = 0; i < 100; i++)
            {
                if (selenium.IsElementPresent("username") == true)
                {
                    selenium.Type("username", "NvQA");
                    selenium.Type("password", "bJn#8xg4");
                    selenium.Type("captcha", "11111"); // The captcha wont be validated when user is NvQA
                    selenium.Click("SubmitButton");
                    break;
                }
                else
                {
                    Thread.Sleep(50);
                }
            }

            selenium.WaitForPageToLoad("15000");

        }

    }
}
