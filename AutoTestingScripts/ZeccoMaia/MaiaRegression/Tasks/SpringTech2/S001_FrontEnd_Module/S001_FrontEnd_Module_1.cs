using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks.SpringTech2.S001_FrontEnd_Module
{
    [TestFixture]
    public class S001_FrontEnd_Module_1 : OLA
    {
        [Test]
        public void T01_FrontEnd_NoSelection()
        {
            this.GotoOLA();
            browser.Button(Find.ById("Welcome_uxSubmit")).Click();
            Assert.IsTrue(browser.Div(Find.ById("Welcome_uxErrorMessage")).Text.Contains("You must choose one account type before proceeding."));
        }

        [Test]
        public void T02_FrontEnd_MultiSelection()
        {
            this.GotoOLA();
            browser.CheckBox(Find.ById("Welcome_uxIndividual")).Checked = true;
            browser.CheckBox(Find.ById("Welcome_uxJoint")).Checked = true;
            browser.Button(Find.ById("Welcome_uxSubmit")).Click();
            Assert.IsTrue(browser.Div(Find.ById("Welcome_uxPopup")).Exists);
            browser.Div(Find.ById("Welcome_uxPopup")).Link(Find.ByText("Back")).Click();
        }

        [Test]
        public void T03_FrontEnd_Individual()
        {
            this.GotoOLA();
            browser.CheckBox(Find.ById("Welcome_uxIndividual")).Checked = true;
            browser.Button(Find.ById("Welcome_uxSubmit")).Click();
            System.Threading.Thread.Sleep(2000);
            Assert.IsTrue(browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxPersonal_PersonalInfo_SocialNumber")).Exists);
        }

        [Test]
        public void T04_FrontEnd_IndividualPersonal_Back()
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
        public void T05_FrontEnd_IndividualPersonal_SaveClose()
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
        public void T06_FrontEnd_IndividualPersonal_CheckFields()
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
        public void T07_FrontEnd_IndividualPersonal()
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
        public void T08_FrontEnd_IndividualFinancial_Back()
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
        public void T09_FrontEnd_IndividualFinancial_SaveClose()
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
        public void T10_FrontEnd_IndividualFinancial_CheckFields()
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
        public void T11_FrontEnd_IndividualFinancial()
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
            Assert.IsTrue(browser.RadioButton(Find.ById("Preferences_uxCapital")).Exists);
        }

        [Test]
        public void T12_FrontEnd_IndividualPreferences_Back()
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
        public void T13_FrontEnd_IndividualPreferences_SaveClose()
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
        public void T14_FrontEnd_IndividualPreferences_CheckFields()
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
            this.PreferencesMOP(false, true, 3, true);

            browser.Button(Find.ById("Preferences_uxSubmit")).Click();
            Assert.IsTrue(browser.Div(Find.ById("Preferences_Panel3")).Exists);
        }

        [Test]
        public void T15_FrontEnd_IndividualPreferences()
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
            this.PreferencesMOP(true, true, 2, true);

            browser.Button(Find.ById("Preferences_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            Assert.IsTrue(browser.Button(Find.ById("Review_uxEditPrimary")).Exists);
        }

        [Test]
        public void T16_FrontEnd_IndividualReview_Back()
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
        public void T17_FrontEnd_IndividualReview_SaveClose()
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
        public void T18_FrontEnd_IndividualReview_EditPrimary()
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
        public void T19_FrontEnd_IndividualReview_EditContact()
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
        public void T20_FrontEnd_IndividualReview_EditBackground()
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
        public void T21_FrontEnd_IndividualReview_EditPreferences()
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
        public void T22_FrontEnd_IndividualReview()
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
        public void T23_FrontEnd_IndividualSubmit()
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
            this.SubmitIndividual(first, last);

            browser.Button(Find.ById("Submit_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            Assert.IsTrue(browser.Label(Find.ById("Paperwork_uxReferenceNumber")).Exists);
        }
    }
}
