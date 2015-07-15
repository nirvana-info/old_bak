using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks.SpringTech2.S002_BackEnd_Module
{
    [TestFixture]
    public class S002_BackEnd_Module_1 : OLA
    {
        [Test]
        public void T01_BackEnd_IndiUS_ECIP_SSN()
        {
            this.GotoOLA();
            browser.CheckBox(Find.ById("Welcome_uxIndividual")).Checked = true;
            browser.Button(Find.ById("Welcome_uxSubmit")).Click();
            System.Threading.Thread.Sleep(2000);
            this.Personal();
            this.Financial();
            this.Preferences();
            browser.Button(Find.ById("Review_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.IAuth();
            System.Threading.Thread.Sleep(5000);
            this.SubmitIndividual(first, last);
            browser.Button(Find.ById("Submit_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            Assert.IsTrue(browser.Label(Find.ById("Paperwork_uxReferenceNumber")).Exists);
        }

        [Test]
        public void T02_BackEnd_IndiUS_ECIP_SSN_PF()
        {
            this.GotoOLA();
            browser.CheckBox(Find.ById("Welcome_uxIndividual")).Checked = true;
            browser.Button(Find.ById("Welcome_uxSubmit")).Click();
            System.Threading.Thread.Sleep(2000);
            this.Personal();
            this.FinancialEmployment("1", "nini", "");
            this.FinancialSituationExperience("9", "8", "14", "14", 0, 0);
            this.FinancialAffiliations(false, "", false, "", "", true, "wjb", "gwy", "2830", "1003");
            browser.Button(Find.ById("Background_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.PreferencesObjective(2);
            this.PreferencesMOP(false, true, 2, true);
            browser.Button(Find.ById("Preferences_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            browser.Button(Find.ById("Review_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.IAuth();
            System.Threading.Thread.Sleep(5000);
            this.SubmitIndividual(first, last);
            browser.Button(Find.ById("Submit_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            Assert.IsTrue(browser.Label(Find.ById("Paperwork_uxReferenceNumber")).Exists);
        }

        [Test]
        public void T03_BackEnd_IRAUS_ECIP_SSN()
        {
            this.GotoOLA();
            browser.CheckBox(Find.ById("Welcome_uxIRA")).Checked = true;
            System.Threading.Thread.Sleep(1000);
            browser.RadioButton(Find.ById("Welcome_uxTraditional")).Checked = true;
            browser.Button(Find.ById("Welcome_uxSubmit")).Click();
            System.Threading.Thread.Sleep(2000);
            this.Personal();
            this.Financial();
            this.Beneficiaries();
            this.Preferences();
            browser.Button(Find.ById("Review_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.IAuth();
            System.Threading.Thread.Sleep(5000);
            this.SubmitIndividual(first, last);
            browser.Button(Find.ById("Submit_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            Assert.IsTrue(browser.Label(Find.ById("Paperwork_uxReferenceNumber")).Exists);
        }

        [Test]
        public void T04_BackEnd_IRAUS_ECIP_SSN_PF()
        {
            this.GotoOLA();
            browser.CheckBox(Find.ById("Welcome_uxIRA")).Checked = true;
            System.Threading.Thread.Sleep(1000);
            browser.RadioButton(Find.ById("Welcome_uxTraditional")).Checked = true;
            browser.Button(Find.ById("Welcome_uxSubmit")).Click();
            System.Threading.Thread.Sleep(2000);
            this.Personal();
            this.FinancialEmployment("1", "nini", "");
            this.FinancialSituationExperience("10", "8", "14", "14", 0, 0);
            this.FinancialAffiliations(false, "", false, "", "", true, "wjb", "gwy", "2830", "1003");
            browser.Button(Find.ById("Background_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.Beneficiaries();
            this.PreferencesObjective(1);
            this.PreferencesMOP(false, true, 2, true);
            browser.Button(Find.ById("Preferences_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            browser.Button(Find.ById("Review_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.IAuth();
            System.Threading.Thread.Sleep(5000);
            this.SubmitIndividual(first, last);
            browser.Button(Find.ById("Submit_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            Assert.IsTrue(browser.Label(Find.ById("Paperwork_uxReferenceNumber")).Exists);
        }

        [Test]
        public void T05_BackEnd_IndiUS_ECIP_SSN_Aff()
        {
            this.GotoOLA();
            browser.CheckBox(Find.ById("Welcome_uxIndividual")).Checked = true;
            browser.Button(Find.ById("Welcome_uxSubmit")).Click();
            System.Threading.Thread.Sleep(2000);
            this.Personal();
            this.FinancialEmployment("1", "nini", "");
            this.FinancialSituationExperience("10", "8", "14", "14", 0, 0);
            this.FinancialAffiliations(true, "zecco", false, "", "", false, "", "", "", "");
            browser.Button(Find.ById("Background_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.PreferencesObjective(2);
            this.PreferencesMOP(false, true, 2, true);
            browser.Button(Find.ById("Preferences_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            browser.Button(Find.ById("Review_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.IAuth();
            System.Threading.Thread.Sleep(5000);
            this.SubmitIndividual(first, last);
            browser.Button(Find.ById("Submit_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            Assert.IsTrue(browser.Label(Find.ById("Paperwork_uxReferenceNumber")).Exists);
        }

        [Test]
        public void T06_BackEnd_IndiUS_ECIP_SSN_Aff_PF()
        {
            this.GotoOLA();
            browser.CheckBox(Find.ById("Welcome_uxIndividual")).Checked = true;
            browser.Button(Find.ById("Welcome_uxSubmit")).Click();
            System.Threading.Thread.Sleep(2000);
            this.Personal();
            this.FinancialEmployment("1", "nini", "");
            this.FinancialSituationExperience("10", "8", "16", "15", 2, 2);
            this.FinancialAffiliations(true, "zecco", false, "", "", true, "wjb", "gwy", "2830", "1003");
            browser.Button(Find.ById("Background_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.PreferencesObjective(3);
            this.PreferencesMOP(false, true, 2, true);
            browser.Button(Find.ById("Preferences_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            browser.Button(Find.ById("Review_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.IAuth();
            System.Threading.Thread.Sleep(5000);
            this.SubmitIndividual(first, last);
            browser.Button(Find.ById("Submit_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            Assert.IsTrue(browser.Label(Find.ById("Paperwork_uxReferenceNumber")).Exists);
        }

        [Test]
        public void T07_BackEnd_IRAUS_ECIP_SSN_Aff()
        {
            this.GotoOLA();
            browser.CheckBox(Find.ById("Welcome_uxIRA")).Checked = true;
            System.Threading.Thread.Sleep(1000);
            browser.RadioButton(Find.ById("Welcome_uxTraditional")).Checked = true;
            browser.Button(Find.ById("Welcome_uxSubmit")).Click();
            System.Threading.Thread.Sleep(2000);
            this.Personal();
            this.FinancialEmployment("1", "nini", "");
            this.FinancialSituationExperience("9", "8", "14", "14", 0, 0);
            this.FinancialAffiliations(true, "zecco", false, "", "", false, "", "", "", "");
            browser.Button(Find.ById("Background_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.Beneficiaries();
            this.Preferences();
            browser.Button(Find.ById("Review_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.IAuth();
            System.Threading.Thread.Sleep(5000);
            this.SubmitIndividual(first, last);
            browser.Button(Find.ById("Submit_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            Assert.IsTrue(browser.Label(Find.ById("Paperwork_uxReferenceNumber")).Exists);
        }

        [Test]
        public void T08_BackEnd_IRAUS_ECIP_SSN_Aff_PF()
        {
            this.GotoOLA();
            browser.CheckBox(Find.ById("Welcome_uxIRA")).Checked = true;
            System.Threading.Thread.Sleep(1000);
            browser.RadioButton(Find.ById("Welcome_uxTraditional")).Checked = true;
            browser.Button(Find.ById("Welcome_uxSubmit")).Click();
            System.Threading.Thread.Sleep(2000);
            this.Personal();
            this.FinancialEmployment("1", "nini", "");
            this.FinancialSituationExperience("9", "8", "14", "14", 0, 0);
            this.FinancialAffiliations(true, "zecco", false, "", "", true, "wjb", "gwy", "2830", "1003");
            browser.Button(Find.ById("Background_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.Beneficiaries();
            this.Preferences();
            browser.Button(Find.ById("Review_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.IAuth();
            System.Threading.Thread.Sleep(5000);
            this.SubmitIndividual(first, last);
            browser.Button(Find.ById("Submit_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            Assert.IsTrue(browser.Label(Find.ById("Paperwork_uxReferenceNumber")).Exists);
        }

        [Test]
        public void T09_BackEnd_JointUSUS_ECIP_SSN()
        {
            this.GotoOLA();
            browser.CheckBox(Find.ById("Welcome_uxJoint")).Checked = true;
            browser.Button(Find.ById("Welcome_uxSubmit")).Click();
            System.Threading.Thread.Sleep(2000);
            this.Personal();
            this.Joint();
            this.FinancialJoint();
            this.Preferences();
            browser.Button(Find.ById("Review_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.IAuth();
            System.Threading.Thread.Sleep(5000);
            this.SubmitJoint(first, last, firstCo, lastCo);
            browser.Button(Find.ById("Submit_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            Assert.IsTrue(browser.Label(Find.ById("Paperwork_uxReferenceNumber")).Exists);            
        }

        [Test]
        public void T10_BackEnd_JointUSUS_ECIP_SSN_PF()
        {
            this.GotoOLA();
            browser.CheckBox(Find.ById("Welcome_uxJoint")).Checked = true;
            browser.Button(Find.ById("Welcome_uxSubmit")).Click();
            System.Threading.Thread.Sleep(2000);
            this.Personal();
            this.Joint();
            this.FinancialEmployment("1", "nini", "");
            this.FinancialCoEmployment("1", "nini", "");
            this.FinancialSituationExperience("11", "8", "15", "15", 2, 2);
            this.FinancialAffiliations(false, "", false, "", "", true, "wjb", "gwy", "2830", "1003");
            browser.Button(Find.ById("Background_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.PreferencesObjective(3);
            this.PreferencesMOP(true, true, 3, true);
            browser.Button(Find.ById("Preferences_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            browser.Button(Find.ById("Review_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.IAuth();
            System.Threading.Thread.Sleep(5000);
            this.SubmitJoint(first, last, firstCo, lastCo);
            browser.Button(Find.ById("Submit_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            Assert.IsTrue(browser.Label(Find.ById("Paperwork_uxReferenceNumber")).Exists);
        }

        [Test]
        public void T11_BackEnd_JointUSUS_ECIP_SSN_Aff()
        {
            this.GotoOLA();
            browser.CheckBox(Find.ById("Welcome_uxJoint")).Checked = true;
            browser.Button(Find.ById("Welcome_uxSubmit")).Click();
            System.Threading.Thread.Sleep(2000);
            this.Personal();
            this.Joint();
            this.FinancialEmployment("1", "nini", "");
            this.FinancialCoEmployment("1", "nini", "");
            this.FinancialSituationExperience("11", "8", "16", "14", 2, 2);
            this.FinancialAffiliations(true, "zecco", false, "", "", false, "", "", "", "");
            browser.Button(Find.ById("Background_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.PreferencesObjective(3);
            this.PreferencesMOP(true, true, 3, true);
            browser.Button(Find.ById("Preferences_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            browser.Button(Find.ById("Review_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.IAuth();
            System.Threading.Thread.Sleep(5000);
            this.SubmitJoint(first, last, firstCo, lastCo);
            browser.Button(Find.ById("Submit_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            Assert.IsTrue(browser.Label(Find.ById("Paperwork_uxReferenceNumber")).Exists);
        }

        [Test]
        public void T12_BackEnd_JointUSUS_ECIP_SSN_Aff_PF()
        {
            this.GotoOLA();
            browser.CheckBox(Find.ById("Welcome_uxJoint")).Checked = true;
            browser.Button(Find.ById("Welcome_uxSubmit")).Click();
            System.Threading.Thread.Sleep(2000);
            this.Personal();
            this.Joint();
            this.FinancialEmployment("1", "nini", "");
            this.FinancialCoEmployment("1", "nini", "");
            this.FinancialSituationExperience("11", "8", "16", "15", 1, 2);
            this.FinancialAffiliations(true, "zecco", false, "", "", true, "wjb", "gwy", "2830", "1003");
            browser.Button(Find.ById("Background_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.PreferencesObjective(3);
            this.PreferencesMOP(true, true, 3, true);
            browser.Button(Find.ById("Preferences_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            browser.Button(Find.ById("Review_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.IAuth();
            System.Threading.Thread.Sleep(5000);
            this.SubmitJoint(first, last, firstCo, lastCo);
            browser.Button(Find.ById("Submit_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            Assert.IsTrue(browser.Label(Find.ById("Paperwork_uxReferenceNumber")).Exists);
        }

        [Test]
        public void T13_BackEnd_IRAUS_ECIP_SSN_Spouse()
        {
            this.GotoOLA();
            browser.CheckBox(Find.ById("Welcome_uxIRA")).Checked = true;
            System.Threading.Thread.Sleep(1000);
            browser.RadioButton(Find.ById("Welcome_uxRoth")).Checked = true;
            browser.Button(Find.ById("Welcome_uxSubmit")).Click();
            System.Threading.Thread.Sleep(2000);
            this.Personal();
            this.Financial();
            this.BeneficiariesPrimary("1015", firstCo, "", lastCo, "3", "3", "1983", "234232345");
            browser.Button(Find.ById("Beneficiary_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.Preferences();
            browser.Button(Find.ById("Review_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.IAuth();
            System.Threading.Thread.Sleep(5000);
            this.SubmitIndividual(first, last);
            browser.Button(Find.ById("Submit_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            Assert.IsTrue(browser.Label(Find.ById("Paperwork_uxReferenceNumber")).Exists);
        }

        [Test]
        public void T14_BackEnd_IRAUS_ECIP_SSN_PF_Spouse()
        {
            this.GotoOLA();
            browser.CheckBox(Find.ById("Welcome_uxIRA")).Checked = true;
            System.Threading.Thread.Sleep(1000);
            browser.RadioButton(Find.ById("Welcome_uxRoth")).Checked = true;
            browser.Button(Find.ById("Welcome_uxSubmit")).Click();
            System.Threading.Thread.Sleep(2000);
            this.Personal();
            this.FinancialEmployment("1", "nini", "");
            this.FinancialSituationExperience("9", "8", "14", "14", 0, 0);
            this.FinancialAffiliations(false, "", false, "", "", true, "wjb", "gwy", "2830", "1003");
            browser.Button(Find.ById("Background_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.BeneficiariesPrimary("1015", firstCo, "", lastCo, "3", "3", "1983", "234232345");
            browser.Button(Find.ById("Beneficiary_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.Preferences();
            browser.Button(Find.ById("Review_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.IAuth();
            System.Threading.Thread.Sleep(5000);
            this.SubmitIndividual(first, last);
            browser.Button(Find.ById("Submit_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            Assert.IsTrue(browser.Label(Find.ById("Paperwork_uxReferenceNumber")).Exists);
        }

        [Test]
        public void T15_BackEnd_IRAUS_ECIP_SSN_Aff_Spouse()
        {
            this.GotoOLA();
            browser.CheckBox(Find.ById("Welcome_uxIRA")).Checked = true;
            System.Threading.Thread.Sleep(1000);
            browser.RadioButton(Find.ById("Welcome_uxRoth")).Checked = true;
            browser.Button(Find.ById("Welcome_uxSubmit")).Click();
            System.Threading.Thread.Sleep(2000);
            this.Personal();
            this.FinancialEmployment("1", "nini", "");
            this.FinancialSituationExperience("9", "8", "14", "14", 0, 0);
            this.FinancialAffiliations(true, "zecco", false, "", "", false, "", "", "", "");
            browser.Button(Find.ById("Background_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.BeneficiariesPrimary("1015", firstCo, "", lastCo, "3", "3", "1983", "234232345");
            browser.Button(Find.ById("Beneficiary_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.Preferences();
            browser.Button(Find.ById("Review_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.IAuth();
            System.Threading.Thread.Sleep(5000);
            this.SubmitIndividual(first, last);
            browser.Button(Find.ById("Submit_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            Assert.IsTrue(browser.Label(Find.ById("Paperwork_uxReferenceNumber")).Exists);
        }

        [Test]
        public void T16_BackEnd_IRAUS_ECIP_SSN_Aff_PF_Spouse()
        {
            this.GotoOLA();
            browser.CheckBox(Find.ById("Welcome_uxIRA")).Checked = true;
            System.Threading.Thread.Sleep(1000);
            browser.RadioButton(Find.ById("Welcome_uxRoth")).Checked = true;
            browser.Button(Find.ById("Welcome_uxSubmit")).Click();
            System.Threading.Thread.Sleep(2000);
            this.Personal();
            this.FinancialEmployment("1", "nini", "");
            this.FinancialSituationExperience("9", "8", "14", "14", 0, 0);
            this.FinancialAffiliations(true, "zecco", false, "", "", true, "wjb", "gwy", "2830", "1003");
            browser.Button(Find.ById("Background_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.BeneficiariesPrimary("1015", firstCo, "", lastCo, "3", "3", "1983", "234232345");
            browser.Button(Find.ById("Beneficiary_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.Preferences();
            browser.Button(Find.ById("Review_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.IAuth();
            System.Threading.Thread.Sleep(5000);
            this.SubmitIndividual(first, last);
            browser.Button(Find.ById("Submit_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            Assert.IsTrue(browser.Label(Find.ById("Paperwork_uxReferenceNumber")).Exists);
        }

        [Test]
        public void T17_BackEnd_IndiNRA()
        {
            this.GotoOLA();
            browser.CheckBox(Find.ById("Welcome_uxIndividual")).Checked = true;
            browser.Button(Find.ById("Welcome_uxSubmit")).Click();
            System.Threading.Thread.Sleep(2000);
            this.PersonalName("", first, "", last, "");
            this.PersonalBirthGenderMarital("5", "5", "1985", 1, 2);
            this.PersonalCitiResi(1, "3550", 1, "2830", "123121234");
            this.PersonalOtherResiAddr("aaa", "sss", "ddd", "23432");
            this.PersonalPhoneNum(true, "9874563210", true, "");
            browser.Button(Find.ById("PersonalInfo_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.Financial();
            this.Preferences();
            browser.Button(Find.ById("Review_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            //this.IAuth();
            //System.Threading.Thread.Sleep(5000);
            this.SubmitIndividual(first, last);
            browser.Button(Find.ById("Submit_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            Assert.IsTrue(browser.Label(Find.ById("Paperwork_uxReferenceNumber")).Exists);
        }

        [Test]
        public void T18_BackEnd_IndiNRA_PF()
        {
            this.GotoOLA();
            browser.CheckBox(Find.ById("Welcome_uxIndividual")).Checked = true;
            browser.Button(Find.ById("Welcome_uxSubmit")).Click();
            System.Threading.Thread.Sleep(2000);
            this.PersonalName("", first, "", last, "");
            this.PersonalBirthGenderMarital("5", "5", "1985", 1, 2);
            this.PersonalCitiResi(1, "3550", 1, "2830", "123121234");
            this.PersonalOtherResiAddr("aaa", "sss", "ddd", "23432");
            this.PersonalPhoneNum(true, "9874563210", true, "");
            browser.Button(Find.ById("PersonalInfo_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.FinancialEmployment("1", "nini", "");
            this.FinancialSituationExperience("11", "8", "16", "15", 2, 1);
            this.FinancialAffiliations(false, "", false, "", "", true, "wjb", "gwy", "2830", "1003");
            browser.Button(Find.ById("Background_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.PreferencesObjective(3);
            this.PreferencesMOP(true, true, 3, true);
            browser.Button(Find.ById("Preferences_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            browser.Button(Find.ById("Review_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            //this.IAuth();
            //System.Threading.Thread.Sleep(5000);
            this.SubmitIndividual(first, last);
            browser.Button(Find.ById("Submit_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            Assert.IsTrue(browser.Label(Find.ById("Paperwork_uxReferenceNumber")).Exists);
        }

        [Test]
        public void T19_BackEnd_IndiNRA_Aff()
        {
            this.GotoOLA();
            browser.CheckBox(Find.ById("Welcome_uxIndividual")).Checked = true;
            browser.Button(Find.ById("Welcome_uxSubmit")).Click();
            System.Threading.Thread.Sleep(2000);
            this.PersonalName("", first, "", last, "");
            this.PersonalBirthGenderMarital("5", "5", "1985", 1, 2);
            this.PersonalCitiResi(1, "3550", 1, "2830", "123121234");
            this.PersonalOtherResiAddr("aaa", "sss", "ddd", "23432");
            this.PersonalPhoneNum(true, "9874563210", true, "");
            browser.Button(Find.ById("PersonalInfo_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.FinancialEmployment("1", "nini", "");
            this.FinancialSituationExperience("11", "8", "16", "15", 2, 2);
            this.FinancialAffiliations(true, "zecco", false, "", "", false, "", "", "", "");
            browser.Button(Find.ById("Background_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.PreferencesObjective(2);
            this.PreferencesMOP(true, true, 3, true);
            browser.Button(Find.ById("Preferences_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            browser.Button(Find.ById("Review_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            //this.IAuth();
            //System.Threading.Thread.Sleep(5000);
            this.SubmitIndividual(first, last);
            browser.Button(Find.ById("Submit_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            Assert.IsTrue(browser.Label(Find.ById("Paperwork_uxReferenceNumber")).Exists);
        }

        [Test]
        public void T20_BackEnd_IndiNRA_Aff_PF()
        {
            this.GotoOLA();
            browser.CheckBox(Find.ById("Welcome_uxIndividual")).Checked = true;
            browser.Button(Find.ById("Welcome_uxSubmit")).Click();
            System.Threading.Thread.Sleep(2000);
            this.PersonalName("", first, "", last, "");
            this.PersonalBirthGenderMarital("5", "5", "1985", 1, 2);
            this.PersonalCitiResi(1, "3550", 1, "2830", "123121234");
            this.PersonalOtherResiAddr("aaa", "sss", "ddd", "23432");
            this.PersonalPhoneNum(true, "9874563210", true, "");
            browser.Button(Find.ById("PersonalInfo_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.FinancialEmployment("1", "nini", "");
            this.FinancialSituationExperience("11", "8", "16", "15", 2, 2);
            this.FinancialAffiliations(true, "zecco", false, "", "", true, "wjb", "gwy", "2830", "1003");
            browser.Button(Find.ById("Background_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.PreferencesObjective(3);
            this.PreferencesMOP(true, true, 3, true);
            browser.Button(Find.ById("Preferences_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            browser.Button(Find.ById("Review_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            //this.IAuth();
            //System.Threading.Thread.Sleep(5000);
            this.SubmitIndividual(first, last);
            browser.Button(Find.ById("Submit_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            Assert.IsTrue(browser.Label(Find.ById("Paperwork_uxReferenceNumber")).Exists);
        }

        [Test]
        public void T21_BackEnd_JointNRANRA()
        {
            this.GotoOLA();
            browser.CheckBox(Find.ById("Welcome_uxJoint")).Checked = true;
            browser.Button(Find.ById("Welcome_uxSubmit")).Click();
            System.Threading.Thread.Sleep(2000);
            this.PersonalName("", first, "", last, "");
            this.PersonalBirthGenderMarital("5", "5", "1985", 1, 2);
            this.PersonalCitiResi(1, "3550", 1, "2830", "123121234");
            this.PersonalOtherResiAddr("aaa", "sss", "ddd", "23432");
            this.PersonalPhoneNum(true, "9874563210", true, "");
            browser.Button(Find.ById("PersonalInfo_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.JointName("", firstCo, "", lastCo, "3");
            this.JointBirthGenderMarital("3", "3", "1983", 2, 2);
            this.JointCitiResi(1, "3550", 1, "2830", "234232345");
            browser.Button(Find.ById("JointHolder_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.FinancialJoint();
            this.Preferences();
            browser.Button(Find.ById("Review_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.IAuth();
            System.Threading.Thread.Sleep(5000);
            this.SubmitJoint(first, last, firstCo, lastCo);
            browser.Button(Find.ById("Submit_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            Assert.IsTrue(browser.Label(Find.ById("Paperwork_uxReferenceNumber")).Exists);
        }

        [Test]
        public void T22_BackEnd_JointNRANRA_PF()
        {
            this.GotoOLA();
            browser.CheckBox(Find.ById("Welcome_uxJoint")).Checked = true;
            browser.Button(Find.ById("Welcome_uxSubmit")).Click();
            System.Threading.Thread.Sleep(2000);
            this.PersonalName("", first, "", last, "");
            this.PersonalBirthGenderMarital("5", "5", "1985", 1, 2);
            this.PersonalCitiResi(1, "3550", 1, "2830", "123121234");
            this.PersonalOtherResiAddr("aaa", "sss", "ddd", "23432");
            this.PersonalPhoneNum(true, "9874563210", true, "");
            browser.Button(Find.ById("PersonalInfo_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.JointName("", firstCo, "", lastCo, "3");
            this.JointBirthGenderMarital("3", "3", "1983", 2, 2);
            this.JointCitiResi(1, "3550", 1, "2830", "234232345");
            browser.Button(Find.ById("JointHolder_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.FinancialEmployment("1", "nini", "");
            this.FinancialCoEmployment("1", "nini", "");
            this.FinancialSituationExperience("9", "8", "14", "14", 0, 0);
            this.FinancialAffiliations(false, "", false, "", "", true, "wjb", "gwy", "2830", "1003");
            browser.Button(Find.ById("Background_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.Preferences();
            browser.Button(Find.ById("Review_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.IAuth();
            System.Threading.Thread.Sleep(5000);
            this.SubmitJoint(first, last, firstCo, lastCo);
            browser.Button(Find.ById("Submit_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            Assert.IsTrue(browser.Label(Find.ById("Paperwork_uxReferenceNumber")).Exists);
        }

        [Test]
        public void T23_BackEnd_JointNRANRA_Aff()
        {
            this.GotoOLA();
            browser.CheckBox(Find.ById("Welcome_uxJoint")).Checked = true;
            browser.Button(Find.ById("Welcome_uxSubmit")).Click();
            System.Threading.Thread.Sleep(2000);
            this.PersonalName("", first, "", last, "");
            this.PersonalBirthGenderMarital("5", "5", "1985", 1, 2);
            this.PersonalCitiResi(1, "3550", 1, "2830", "123121234");
            this.PersonalOtherResiAddr("aaa", "sss", "ddd", "23432");
            this.PersonalPhoneNum(true, "9874563210", true, "");
            browser.Button(Find.ById("PersonalInfo_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.JointName("", firstCo, "", lastCo, "3");
            this.JointBirthGenderMarital("3", "3", "1983", 2, 2);
            this.JointCitiResi(1, "3550", 1, "2830", "234232345");
            browser.Button(Find.ById("JointHolder_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.FinancialEmployment("1", "nini", "");
            this.FinancialCoEmployment("1", "nini", "");
            this.FinancialSituationExperience("9", "8", "14", "14", 0, 0);
            this.FinancialAffiliations(true, "zecco", false, "", "", false, "", "", "", "");
            browser.Button(Find.ById("Background_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.Preferences();
            browser.Button(Find.ById("Review_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.IAuth();
            System.Threading.Thread.Sleep(5000);
            this.SubmitJoint(first, last, firstCo, lastCo);
            browser.Button(Find.ById("Submit_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            Assert.IsTrue(browser.Label(Find.ById("Paperwork_uxReferenceNumber")).Exists);
        }

        [Test]
        public void T24_BackEnd_JointNRANRA_Aff_PF()
        {
            this.GotoOLA();
            browser.CheckBox(Find.ById("Welcome_uxJoint")).Checked = true;
            browser.Button(Find.ById("Welcome_uxSubmit")).Click();
            System.Threading.Thread.Sleep(2000);
            this.PersonalName("", first, "", last, "");
            this.PersonalBirthGenderMarital("5", "5", "1985", 1, 2);
            this.PersonalCitiResi(1, "3550", 1, "2830", "123121234");
            this.PersonalOtherResiAddr("aaa", "sss", "ddd", "23432");
            this.PersonalPhoneNum(true, "9874563210", true, "");
            browser.Button(Find.ById("PersonalInfo_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.JointName("", firstCo, "", lastCo, "3");
            this.JointBirthGenderMarital("3", "3", "1983", 2, 2);
            this.JointCitiResi(1, "3550", 1, "2830", "234232345");
            browser.Button(Find.ById("JointHolder_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.FinancialEmployment("1", "nini", "");
            this.FinancialCoEmployment("1", "nini", "");
            this.FinancialSituationExperience("9", "8", "14", "14", 0, 0);
            this.FinancialAffiliations(true, "zecco", false, "", "", true, "wjb", "gwy", "2830", "1003");
            browser.Button(Find.ById("Background_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.Preferences();
            browser.Button(Find.ById("Review_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.IAuth();
            System.Threading.Thread.Sleep(5000);
            this.SubmitJoint(first, last, firstCo, lastCo);
            browser.Button(Find.ById("Submit_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            Assert.IsTrue(browser.Label(Find.ById("Paperwork_uxReferenceNumber")).Exists);
        }

        [Test]
        public void T25_BackEnd_JointUSNRA_ECIP_SSN()
        {
            this.GotoOLA();
            browser.CheckBox(Find.ById("Welcome_uxJoint")).Checked = true;
            browser.Button(Find.ById("Welcome_uxSubmit")).Click();
            System.Threading.Thread.Sleep(2000);
            this.Personal();
            this.JointName("", firstCo, "", lastCo, "3");
            this.JointBirthGenderMarital("3", "3", "1983", 2, 2);
            this.JointCitiResi(1, "3550", 1, "2830", "234232345");
            this.JointOtherResiAddr("www", "eee", "rrr", "23432");
            browser.Button(Find.ById("JointHolder_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.FinancialJoint();
            this.Preferences();
            browser.Button(Find.ById("Review_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.IAuth();
            System.Threading.Thread.Sleep(5000);
            this.SubmitJoint(first, last, firstCo, lastCo);
            browser.Button(Find.ById("Submit_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            Assert.IsTrue(browser.Label(Find.ById("Paperwork_uxReferenceNumber")).Exists);
        }

        [Test]
        public void T26_BackEnd_JointUSNRA_ECIP_SSN_PF()
        {
            this.GotoOLA();
            browser.CheckBox(Find.ById("Welcome_uxJoint")).Checked = true;
            browser.Button(Find.ById("Welcome_uxSubmit")).Click();
            System.Threading.Thread.Sleep(2000);
            this.Personal();
            this.JointName("", firstCo, "", lastCo, "3");
            this.JointBirthGenderMarital("3", "3", "1983", 2, 2);
            this.JointCitiResi(1, "3550", 1, "2830", "234232345");
            this.JointOtherResiAddr("www", "eee", "rrr", "23432");
            browser.Button(Find.ById("JointHolder_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.FinancialEmployment("1", "nini", "");
            this.FinancialCoEmployment("1", "nini", "");
            this.FinancialSituationExperience("9", "8", "14", "14", 0, 0);
            this.FinancialAffiliations(false, "", false, "", "", true, "wjb", "gwy", "2830", "1003");
            browser.Button(Find.ById("Background_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.Preferences();
            browser.Button(Find.ById("Review_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.IAuth();
            System.Threading.Thread.Sleep(5000);
            this.SubmitJoint(first, last, firstCo, lastCo);
            browser.Button(Find.ById("Submit_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            Assert.IsTrue(browser.Label(Find.ById("Paperwork_uxReferenceNumber")).Exists);
        }

        [Test]
        public void T27_BackEnd_JointUSNRA_ECIP_SSN_Aff()
        {
            this.GotoOLA();
            browser.CheckBox(Find.ById("Welcome_uxJoint")).Checked = true;
            browser.Button(Find.ById("Welcome_uxSubmit")).Click();
            System.Threading.Thread.Sleep(2000);
            this.Personal();
            this.JointName("", firstCo, "", lastCo, "3");
            this.JointBirthGenderMarital("3", "3", "1983", 2, 2);
            this.JointCitiResi(1, "3550", 1, "2830", "234232345");
            this.JointOtherResiAddr("www", "eee", "rrr", "23432");
            browser.Button(Find.ById("JointHolder_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.FinancialEmployment("1", "nini", "");
            this.FinancialCoEmployment("1", "nini", "");
            this.FinancialSituationExperience("9", "8", "14", "14", 0, 0);
            this.FinancialAffiliations(true, "zecco", false, "", "", false, "", "", "", "");
            browser.Button(Find.ById("Background_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.Preferences();
            browser.Button(Find.ById("Review_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.IAuth();
            System.Threading.Thread.Sleep(5000);
            this.SubmitJoint(first, last, firstCo, lastCo);
            browser.Button(Find.ById("Submit_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            Assert.IsTrue(browser.Label(Find.ById("Paperwork_uxReferenceNumber")).Exists);
        }

        [Test]
        public void T28_BackEnd_JointUSNRA_ECIP_SSN_Aff_PF()
        {
            this.GotoOLA();
            browser.CheckBox(Find.ById("Welcome_uxJoint")).Checked = true;
            browser.Button(Find.ById("Welcome_uxSubmit")).Click();
            System.Threading.Thread.Sleep(2000);
            this.Personal();
            this.JointName("", firstCo, "", lastCo, "3");
            this.JointBirthGenderMarital("3", "3", "1983", 2, 2);
            this.JointCitiResi(1, "3550", 1, "2830", "234232345");
            this.JointOtherResiAddr("www", "eee", "rrr", "23432");
            browser.Button(Find.ById("JointHolder_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.FinancialEmployment("1", "nini", "");
            this.FinancialCoEmployment("1", "nini", "");
            this.FinancialSituationExperience("9", "8", "14", "14", 0, 0);
            this.FinancialAffiliations(true, "zecco", false, "", "", true, "wjb", "gwy", "2830", "1003");
            browser.Button(Find.ById("Background_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.Preferences();
            browser.Button(Find.ById("Review_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.IAuth();
            System.Threading.Thread.Sleep(5000);
            this.SubmitJoint(first, last, firstCo, lastCo);
            browser.Button(Find.ById("Submit_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            Assert.IsTrue(browser.Label(Find.ById("Paperwork_uxReferenceNumber")).Exists);
        }
    }
}
