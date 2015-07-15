using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks.SpringTech2.S001_FrontEnd_Module
{
    [TestFixture]
    public class S001_FrontEnd_Module_3 : OLA
    {
        [Test]
        public void T01_FrontEnd_IRA()
        {
            this.GotoOLA();
            browser.CheckBox(Find.ById("Welcome_uxIRA")).Checked = true;
            System.Threading.Thread.Sleep(1000);
            browser.RadioButton(Find.ById("Welcome_uxTraditional")).Checked = true;
            browser.RadioButton(Find.ById("Welcome_uxRoth")).Checked = true;
            browser.RadioButton(Find.ById("Welcome_uxRollover")).Checked = true;
            browser.RadioButton(Find.ById("Welcome_uxSEP")).Checked = true;
            browser.Button(Find.ById("Welcome_uxSubmit")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxPersonal_PersonalInfo_SocialNumber")).Exists);
        }

        [Test]
        public void T02_FrontEnd_IRAPersonal_Back()
        {
            this.GotoOLA();
            if ((browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxWelcome_Welcome_uxSavedApp_Table")).Exists == false) ||
                (browser.Button(Find.ByValue("Resume")).Exists == false))
            {
                Assert.IsTrue(false);
                return;
            }
            browser.Button(Find.ByValue("Resume")).Click();
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ById("PersonalInfo_uxBack")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Button(Find.ByValue("Resume")).Exists);
        }

        [Test]
        public void T03_FrontEnd_IRAPersonal_SaveClose()
        {
            this.GotoOLA();
            if ((browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxWelcome_Welcome_uxSavedApp_Table")).Exists == false) ||
                (browser.Button(Find.ByValue("Resume")).Exists == false))
            {
                Assert.IsTrue(false);
                return;
            }
            browser.Button(Find.ByValue("Resume")).Click();
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ById("PersonalInfo_uxSaveClose")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Button(Find.ByValue("Resume")).Exists);
        }

        [Test]
        public void T04_FrontEnd_IRAPersonal_CheckFields()
        {
            this.GotoOLA();
            if ((browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxWelcome_Welcome_uxSavedApp_Table")).Exists == false) ||
                (browser.Button(Find.ByValue("Resume")).Exists == false))
            {
                Assert.IsTrue(false);
                return;
            }
            browser.Button(Find.ByValue("Resume")).Click();
            System.Threading.Thread.Sleep(2000);
            this.PersonalName("", "", "", "", "");
            this.PersonalBirthGenderMarital("-1", "-1", "-1", 1, 2);
            this.PersonalCitiResi(0, "", 0, "", "");
            //this.PersonalCitiResi(1, "3550", 1, "2830", "123121234");
            this.PersonalUSResiAddr("", "", "", "");
            //this.PersonalOtherResiAddr("address1", "address2", "province", "12321");
            //this.PersonalUSMailAddr("address1", "address2", "city", "23432");
            //this.PersonalOtherMailAddr("2830", "address1", "address2", "province", "23432");
            this.PersonalPhoneNum(true, "", false, "");

            browser.Button(Find.ById("PersonalInfo_uxSubmit")).Click();
            Assert.IsTrue(browser.Div(Find.ById("PersonalInfo_uxErrorMessage")).Exists);
        }

        [Test]
        public void T05_FrontEnd_MisMatchSSN()
        {
            this.GotoOLA();
            if ((browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxWelcome_Welcome_uxSavedApp_Table")).Exists == false) ||
                (browser.Button(Find.ByValue("Resume")).Exists == false))
            {
                Assert.IsTrue(false);
                return;
            }
            browser.Button(Find.ByValue("Resume")).Click();
            System.Threading.Thread.Sleep(2000);
            this.PersonalName("6", first, "c", last, "3");
            this.PersonalBirthGenderMarital("5", "5", "1985", 1, 2);
            this.PersonalCitiResi(0, "", 0, "", "123456789");
            //this.PersonalCitiResi(1, "3550", 1, "2830", "123121234");
            this.PersonalUSResiAddr("address1", "address2", "city", "12321");
            //this.PersonalOtherResiAddr("address1", "address2", "province", "12321");
            //this.PersonalUSMailAddr("address1", "address2", "city", "23432");
            //this.PersonalOtherMailAddr("2830", "address1", "address2", "province", "23432");
            this.PersonalPhoneNum(true, "9874563210", false, "");

            browser.Button(Find.ById("PersonalInfo_uxSubmit")).Click();
            Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Exists && browser.Link(Find.ById("personal_ssnexplain1")).Exists);
        }

        [Test]
        public void T06_FrontEnd_MisMatchGovID()
        {
            this.GotoOLA();
            if ((browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxWelcome_Welcome_uxSavedApp_Table")).Exists == false) ||
                (browser.Button(Find.ByValue("Resume")).Exists == false))
            {
                Assert.IsTrue(false);
                return;
            }
            browser.Button(Find.ByValue("Resume")).Click();
            System.Threading.Thread.Sleep(2000);
            this.PersonalName("6", first, "c", last, "3");
            this.PersonalBirthGenderMarital("5", "5", "1985", 1, 2);
            //this.PersonalCitiResi(0, "", 0, "", "123121234");
            this.PersonalCitiResi(1, "3550", 1, "2830", "123456789");
            this.PersonalUSResiAddr("address1", "address2", "city", "12321");
            //this.PersonalOtherResiAddr("address1", "address2", "province", "12321");
            //this.PersonalUSMailAddr("address1", "address2", "city", "23432");
            //this.PersonalOtherMailAddr("2830", "address1", "address2", "province", "23432");
            this.PersonalPhoneNum(true, "9874563210", false, "");

            browser.Button(Find.ById("PersonalInfo_uxSubmit")).Click();
            Assert.IsTrue(browser.Div(Find.ByClass("inline-error")).Exists && browser.Link(Find.ById("personal_ssnexplain1")).Exists);
        }

        [Test]
        public void T07_FrontEnd_IRAPersonal()
        {
            this.GotoOLA();
            if ((browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxWelcome_Welcome_uxSavedApp_Table")).Exists == false) ||
                (browser.Button(Find.ByValue("Resume")).Exists == false))
            {
                Assert.IsTrue(false);
                return;
            }
            browser.Button(Find.ByValue("Resume")).Click();
            System.Threading.Thread.Sleep(2000);
            this.PersonalName("6", first, "c", last, "3");
            this.PersonalBirthGenderMarital("5", "5", "1985", 1, 2);
            this.PersonalCitiResi(0, "", 0, "", "123121234");
            //this.PersonalCitiResi(1, "3550", 1, "2830", "123121234");
            this.PersonalUSResiAddr("address1", "address2", "city", "12321");
            //this.PersonalOtherResiAddr("address1", "address2", "province", "12321");
            //this.PersonalUSMailAddr("address1", "address2", "city", "23432");
            //this.PersonalOtherMailAddr("2830", "address1", "address2", "province", "23432");
            this.PersonalPhoneNum(true, "9874563210", false, "");

            browser.Button(Find.ById("PersonalInfo_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            Assert.IsTrue(browser.SelectList(Find.ById("Background_uxEmploymentStatus")).Exists);
        }

        [Test]
        public void T08_FrontEnd_IRAFinancial_Back()
        {
            this.GotoOLA();
            if ((browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxWelcome_Welcome_uxSavedApp_Table")).Exists == false) ||
                (browser.Button(Find.ByValue("Resume")).Exists == false))
            {
                Assert.IsTrue(false);
                return;
            }
            browser.Button(Find.ByValue("Resume")).Click();
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ById("Background_uxBack")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Button(Find.ById("PersonalInfo_uxSubmit")).Exists);
            browser.Button(Find.ById("PersonalInfo_uxSubmit")).Click();
            System.Threading.Thread.Sleep(2000);
        }

        [Test]
        public void T09_FrontEnd_IRAFinancial_SaveClose()
        {
            this.GotoOLA();
            if ((browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxWelcome_Welcome_uxSavedApp_Table")).Exists == false) ||
                (browser.Button(Find.ByValue("Resume")).Exists == false))
            {
                Assert.IsTrue(false);
                return;
            }
            browser.Button(Find.ByValue("Resume")).Click();
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ById("Background_uxSaveAndClose")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Button(Find.ByValue("Resume")).Exists);
        }

        [Test]
        public void T10_FrontEnd_IRAFinancial_CheckFields()
        {
            this.GotoOLA();
            if ((browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxWelcome_Welcome_uxSavedApp_Table")).Exists == false) ||
                (browser.Button(Find.ByValue("Resume")).Exists == false))
            {
                Assert.IsTrue(false);
                return;
            }
            browser.Button(Find.ByValue("Resume")).Click();
            System.Threading.Thread.Sleep(2000);
            this.FinancialEmployment("1", "", "");
            this.FinancialSituationExperience("-1", "-1", "-1", "-1", 0, 0);
            this.FinancialAffiliations(true, "", true, "", "", true, "", "", "", "");

            browser.Button(Find.ById("Background_uxSubmit")).Click();
            Assert.IsTrue(browser.Div(Find.ById("Background_uxErrorMessage")).Exists);
        }

        [Test]
        public void T11_FrontEnd_IRAFinancial()
        {
            this.GotoOLA();
            if ((browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxWelcome_Welcome_uxSavedApp_Table")).Exists == false) ||
                (browser.Button(Find.ByValue("Resume")).Exists == false))
            {
                Assert.IsTrue(false);
                return;
            }
            browser.Button(Find.ByValue("Resume")).Click();
            System.Threading.Thread.Sleep(2000);
            this.FinancialEmployment("1", "nini", "");
            this.FinancialSituationExperience("9", "8", "14", "14", 0, 0);
            this.FinancialAffiliations(false, "", false, "", "", false, "", "", "", "");

            browser.Button(Find.ById("Background_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            Assert.IsTrue(browser.SelectList(Find.ById("Beneficiary_uxRelationship")).Exists);
        }

        [Test]
        public void T12_FrontEnd_IRABeneficiaries_Back()
        {
            this.GotoOLA();
            if ((browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxWelcome_Welcome_uxSavedApp_Table")).Exists == false) ||
                (browser.Button(Find.ByValue("Resume")).Exists == false))
            {
                Assert.IsTrue(false);
                return;
            }
            browser.Button(Find.ByValue("Resume")).Click();
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ById("Beneficiary_uxBack")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Button(Find.ById("Background_uxSubmit")).Exists);
            browser.Button(Find.ById("Background_uxSubmit")).Click();
            System.Threading.Thread.Sleep(2000);
        }

        [Test]
        public void T13_FrontEnd_IRABeneficiaries_SaveClose()
        {
            this.GotoOLA();
            if ((browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxWelcome_Welcome_uxSavedApp_Table")).Exists == false) ||
                (browser.Button(Find.ByValue("Resume")).Exists == false))
            {
                Assert.IsTrue(false);
                return;
            }
            browser.Button(Find.ByValue("Resume")).Click();
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ById("Beneficiary_uxSaveAndClose")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Button(Find.ByValue("Resume")).Exists);
        }

        [Test]
        public void T14_FrontEnd_IRABeneficiaries_CheckFields()
        {
            this.GotoOLA();
            if ((browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxWelcome_Welcome_uxSavedApp_Table")).Exists == false) ||
                (browser.Button(Find.ByValue("Resume")).Exists == false))
            {
                Assert.IsTrue(false);
                return;
            }
            browser.Button(Find.ByValue("Resume")).Click();
            System.Threading.Thread.Sleep(2000);
            this.BeneficiariesPrimary("1010", "", "", "", "-1", "-1", "-1", "");

            browser.Button(Find.ById("Beneficiary_uxSubmit")).Click();
            Assert.IsTrue(browser.Div(Find.ById("Beneficiary_uxErrorMessage")).Exists);
        }

        [Test]
        public void T15_FrontEnd_IRABeneficiaries()
        {
            this.GotoOLA();
            if ((browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxWelcome_Welcome_uxSavedApp_Table")).Exists == false) ||
                (browser.Button(Find.ByValue("Resume")).Exists == false))
            {
                Assert.IsTrue(false);
                return;
            }
            browser.Button(Find.ByValue("Resume")).Click();
            System.Threading.Thread.Sleep(2000);
            this.BeneficiariesPrimary("1010", firstCo, "", lastCo, "3", "3", "1983", "234232345");

            browser.Button(Find.ById("Beneficiary_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            Assert.IsTrue(browser.RadioButton(Find.ById("Preferences_uxCapital")).Exists);
        }

        [Test]
        public void T16_FrontEnd_IRAPreferences_Back()
        {
            this.GotoOLA();
            if ((browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxWelcome_Welcome_uxSavedApp_Table")).Exists == false) ||
                (browser.Button(Find.ByValue("Resume")).Exists == false))
            {
                Assert.IsTrue(false);
                return;
            }
            browser.Button(Find.ByValue("Resume")).Click();
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ById("Preferences_uxBack")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Button(Find.ById("Background_uxSubmit")).Exists);
            browser.Button(Find.ById("Background_uxSubmit")).Click();
            System.Threading.Thread.Sleep(2000);
        }

        [Test]
        public void T17_FrontEnd_IRAPreferences_SaveClose()
        {
            this.GotoOLA();
            if ((browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxWelcome_Welcome_uxSavedApp_Table")).Exists == false) ||
                (browser.Button(Find.ByValue("Resume")).Exists == false))
            {
                Assert.IsTrue(false);
                return;
            }
            browser.Button(Find.ByValue("Resume")).Click();
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ById("Preferences_uxSaveClose")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Button(Find.ByValue("Resume")).Exists);
        }

        [Test]
        public void T18_FrontEnd_IRAPreferences()
        {
            this.GotoOLA();
            if ((browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxWelcome_Welcome_uxSavedApp_Table")).Exists == false) ||
                (browser.Button(Find.ByValue("Resume")).Exists == false))
            {
                Assert.IsTrue(false);
                return;
            }
            browser.Button(Find.ByValue("Resume")).Click();
            System.Threading.Thread.Sleep(2000);
            this.PreferencesObjective(1);
            this.PreferencesMOP(false, false, 0, true);

            browser.Button(Find.ById("Preferences_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            Assert.IsTrue(browser.Button(Find.ById("Review_uxEditPrimary")).Exists);
        }

        [Test]
        public void T19_FrontEnd_IRAReview_Back()
        {
            this.GotoOLA();
            if ((browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxWelcome_Welcome_uxSavedApp_Table")).Exists == false) ||
                (browser.Button(Find.ByValue("Resume")).Exists == false))
            {
                Assert.IsTrue(false);
                return;
            }
            browser.Button(Find.ByValue("Resume")).Click();
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ById("Review_uxBack")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Button(Find.ById("Preferences_uxSubmit")).Exists);
            browser.Button(Find.ById("Preferences_uxSubmit")).Click();
            System.Threading.Thread.Sleep(2000);
        }

        [Test]
        public void T20_FrontEnd_IRAReview_SaveClose()
        {
            this.GotoOLA();
            if ((browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxWelcome_Welcome_uxSavedApp_Table")).Exists == false) ||
                (browser.Button(Find.ByValue("Resume")).Exists == false))
            {
                Assert.IsTrue(false);
                return;
            }
            browser.Button(Find.ByValue("Resume")).Click();
            System.Threading.Thread.Sleep(2000);
            browser.Link(Find.ById("Review_uxSaveClose")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Button(Find.ByValue("Resume")).Exists);
        }

        [Test]
        public void T21_FrontEnd_IRAReview_EditPrimary()
        {
            this.GotoOLA();
            if ((browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxWelcome_Welcome_uxSavedApp_Table")).Exists == false) ||
                (browser.Button(Find.ByValue("Resume")).Exists == false))
            {
                Assert.IsTrue(false);
                return;
            }
            browser.Button(Find.ByValue("Resume")).Click();
            System.Threading.Thread.Sleep(2000);
            this.ReviewEdit("Primary");
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Button(Find.ById("PersonalInfo_uxSubmit")).Exists);
            browser.Button(Find.ById("PersonalInfo_uxSubmit")).Click();
        }

        [Test]
        public void T22_FrontEnd_IRAReview_EditContact()
        {
            this.GotoOLA();
            if ((browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxWelcome_Welcome_uxSavedApp_Table")).Exists == false) ||
                (browser.Button(Find.ByValue("Resume")).Exists == false))
            {
                Assert.IsTrue(false);
                return;
            }
            browser.Button(Find.ByValue("Resume")).Click();
            System.Threading.Thread.Sleep(2000);
            this.ReviewEdit("Contact");
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Button(Find.ById("PersonalInfo_uxSubmit")).Exists);
            browser.Button(Find.ById("PersonalInfo_uxSubmit")).Click();
        }

        [Test]
        public void T23_FrontEnd_IRAReview_EditBackground()
        {
            this.GotoOLA();
            if ((browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxWelcome_Welcome_uxSavedApp_Table")).Exists == false) ||
                (browser.Button(Find.ByValue("Resume")).Exists == false))
            {
                Assert.IsTrue(false);
                return;
            }
            browser.Button(Find.ByValue("Resume")).Click();
            System.Threading.Thread.Sleep(2000);
            this.ReviewEdit("Background");
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Button(Find.ById("Background_uxSubmit")).Exists);
            browser.Button(Find.ById("Background_uxSubmit")).Click();
        }

        [Test]
        public void T24_FrontEnd_IRAReview_EditIraBenificiary()
        {
            this.GotoOLA();
            if ((browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxWelcome_Welcome_uxSavedApp_Table")).Exists == false) ||
                (browser.Button(Find.ByValue("Resume")).Exists == false))
            {
                Assert.IsTrue(false);
                return;
            }
            browser.Button(Find.ByValue("Resume")).Click();
            System.Threading.Thread.Sleep(2000);
            this.ReviewEdit("IraBenificiary");
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Button(Find.ById("Beneficiary_uxSubmit")).Exists);
            browser.Button(Find.ById("Beneficiary_uxSubmit")).Click();
        }

        [Test]
        public void T25_FrontEnd_IRAReview_EditPreferences()
        {
            this.GotoOLA();
            if ((browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxWelcome_Welcome_uxSavedApp_Table")).Exists == false) ||
                (browser.Button(Find.ByValue("Resume")).Exists == false))
            {
                Assert.IsTrue(false);
                return;
            }
            browser.Button(Find.ByValue("Resume")).Click();
            System.Threading.Thread.Sleep(2000);
            this.ReviewEdit("Preferences");
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.Button(Find.ById("Preferences_uxSubmit")).Exists);
            browser.Button(Find.ById("Preferences_uxSubmit")).Click();
        }

        [Test]
        public void T26_FrontEnd_IRAReview()
        {
            this.GotoOLA();
            if ((browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxWelcome_Welcome_uxSavedApp_Table")).Exists == false) ||
                (browser.Button(Find.ByValue("Resume")).Exists == false))
            {
                Assert.IsTrue(false);
                return;
            }
            browser.Button(Find.ByValue("Resume")).Click();
            System.Threading.Thread.Sleep(2000);


            browser.Button(Find.ById("Review_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.IAuth();
            System.Threading.Thread.Sleep(5000);
            Assert.IsTrue(browser.TextField(Find.ById("Submit_uxFirstName")).Exists);
        }

        [Test]
        public void T27_FrontEnd_IRASubmit()
        {
            this.GotoOLA();
            if ((browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxWelcome_Welcome_uxSavedApp_Table")).Exists == false) ||
                (browser.Button(Find.ByValue("Resume")).Exists == false))
            {
                Assert.IsTrue(false);
                return;
            }
            browser.Button(Find.ByValue("Resume")).Click();
            System.Threading.Thread.Sleep(2000);


            browser.Button(Find.ById("Submit_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            Assert.IsTrue(browser.Label(Find.ById("Paperwork_uxReferenceNumber")).Exists);
        }
    }
}
