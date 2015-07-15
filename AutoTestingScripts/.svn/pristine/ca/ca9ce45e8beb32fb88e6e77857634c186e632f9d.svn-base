using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks._2012Sprint13
{
    [TestFixture]
    public class S002_YodleeUI_Module : SignIn
    {
        [Test]
        public void T01_YodleeUI_BankInfoText()
        {
            browser.GoTo(targetHost);
            UserSignIn(UN, PW, false, 2);
            browser.GoTo(targetHost + "/sign-up.aspx");
            browser.Button(Find.ById("Welcome_uxSubmit")).WaitUntilExists();
            Assert.IsTrue(browser.ContainsText("Bank account information or online access to your bank"));
        }

        [Test]
        public void T02_YodleeUI_BankInfoText_Indiv()
        {
            browser.GoTo(targetHost);
            UserSignIn(UN, PW, false, 2);
            browser.GoTo(targetHost + "/sign-up.aspx");
            browser.Button(Find.ById("Welcome_uxSubmit")).WaitUntilExists();
            browser.RadioButton(Find.ById("Welcome_uxIndividual")).Checked = true;
            Assert.IsTrue(browser.ContainsText("Bank account information or online access to your bank"));
        }

        [Test]
        public void T03_YodleeUI_BankInfoText_Joint()
        {
            browser.GoTo(targetHost);
            UserSignIn(UN, PW, false, 2);
            browser.GoTo(targetHost + "/sign-up.aspx");
            browser.Button(Find.ById("Welcome_uxSubmit")).WaitUntilExists();
            browser.RadioButton(Find.ById("Welcome_uxJoint")).Checked = true;
            Assert.IsTrue(browser.ContainsText("Bank account information or online access to your bank"));
        }

        [Test]
        public void T04_YodleeUI_BankInfoText_IRA()
        {
            browser.GoTo(targetHost);
            UserSignIn(UN, PW, false, 2);
            browser.GoTo(targetHost + "/sign-up.aspx");
            browser.Button(Find.ById("Welcome_uxSubmit")).WaitUntilExists();
            browser.RadioButton(Find.ById("Welcome_uxIRA")).Checked = true;
            browser.RadioButton(Find.ById("Welcome_uxTraditional")).Checked = true;
            Assert.IsTrue(browser.ContainsText("Bank account information or online access to your bank"));
            browser.RadioButton(Find.ById("Welcome_uxRoth")).Checked = true;
            Assert.IsTrue(browser.ContainsText("Bank account information or online access to your bank"));
            browser.RadioButton(Find.ById("Welcome_uxRollover")).Checked = true;
            Assert.IsTrue(browser.ContainsText("Bank account information or online access to your bank"));
            browser.RadioButton(Find.ById("Welcome_uxSEP")).Checked = true;
            Assert.IsTrue(browser.ContainsText("Bank account information or online access to your bank"));
        }

        [Test]
        public void T05_YodleeUI_BankPassword()
        {
            browser.GoTo(targetHost);
            UserSignIn(UN, PW, false, 2);
            //browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl01_uxSubNavRepeater_ctl02_uxSubNavLink")).Click();
            browser.GoTo("https://trading.qa.maia.zecco.com/transfers/viewaccountlinks.aspx");
            System.Threading.Thread.Sleep(5000);
            browser.Button(Find.ById("uxShowACHForm")).Click();
            browser.SelectList(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxAccountList_Select")).Option(Find.ByText("Individual - 31474281")).Select();
            System.Threading.Thread.Sleep(2000);
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxABARoutingNumber")).TypeText("031176110");
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxBankAccount")).TypeText("146022432");
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxBankAccountConfirm")).TypeText("146022432");
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxAccountNickName")).TypeText("autotest");
            browser.RadioButton(Find.ById("ctl00_ctl00_uxMainContent_uxLeftColumn_uxAccountType_1")).Checked = true;
            browser.Button(Find.ById("uxSubmit")).Click();
            System.Threading.Thread.Sleep(5000);
            Assert.IsTrue(browser.TextField(Find.ById("Verify_Single_Answer_Text_Val1")).Exists);
            Assert.IsTrue(browser.TextField(Find.ById("Verify_Single_Answer_Password_Val2")).Exists);
            Assert.IsTrue(browser.TextField(Find.ById("Verify_Single_Answer_Password_Val3")).Exists);
        }
    }
}
