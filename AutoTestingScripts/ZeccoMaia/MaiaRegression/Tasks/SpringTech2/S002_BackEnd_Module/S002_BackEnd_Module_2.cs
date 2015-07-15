using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks.SpringTech2.S002_BackEnd_Module
{
    [TestFixture]
    public class S002_BackEnd_Module_2 : OLA
    {
        [Test]
        public void T01_BackEnd_IndiUS_ECIP()
        {
            this.GotoOLA();
            browser.CheckBox(Find.ById("Welcome_uxIndividual")).Checked = true;
            browser.Button(Find.ById("Welcome_uxSubmit")).Click();
            System.Threading.Thread.Sleep(2000);
            this.PersonalValidSSN();
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
        public void T02_BackEnd_IndiUS_ECIP_PF()
        {
            this.GotoOLA();
            browser.CheckBox(Find.ById("Welcome_uxIndividual")).Checked = true;
            browser.Button(Find.ById("Welcome_uxSubmit")).Click();
            System.Threading.Thread.Sleep(2000);
            this.PersonalValidSSN();
            this.FinancialEmployment("1", "nini", "");
            this.FinancialSituationExperience("9", "8", "14", "14", 0, 0);
            this.FinancialAffiliations(false, "", false, "", "", true, "wjb", "gwy", "2830", "1003");
            browser.Button(Find.ById("Background_uxSubmit")).Click();
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
        public void T03_BackEnd_IRAUS_ECIP()
        {
            this.GotoOLA();
            browser.CheckBox(Find.ById("Welcome_uxIRA")).Checked = true;
            System.Threading.Thread.Sleep(1000);
            browser.RadioButton(Find.ById("Welcome_uxRollover")).Checked = true;
            browser.Button(Find.ById("Welcome_uxSubmit")).Click();
            System.Threading.Thread.Sleep(2000);
            this.PersonalValidSSN();
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
        public void T04_BackEnd_IRAUS_ECIP_PF()
        {
            this.GotoOLA();
            browser.CheckBox(Find.ById("Welcome_uxIRA")).Checked = true;
            System.Threading.Thread.Sleep(1000);
            browser.RadioButton(Find.ById("Welcome_uxRollover")).Checked = true;
            browser.Button(Find.ById("Welcome_uxSubmit")).Click();
            System.Threading.Thread.Sleep(2000);
            this.PersonalValidSSN();
            this.FinancialEmployment("1", "nini", "");
            this.FinancialSituationExperience("9", "8", "14", "14", 0, 0);
            this.FinancialAffiliations(false, "", false, "", "", true, "wjb", "gwy", "2830", "1003");
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
        public void T05_BackEnd_IndiUS_ECIP_Aff()
        {
            this.GotoOLA();
            browser.CheckBox(Find.ById("Welcome_uxIndividual")).Checked = true;
            browser.Button(Find.ById("Welcome_uxSubmit")).Click();
            System.Threading.Thread.Sleep(2000);
            this.PersonalValidSSN();
            this.FinancialEmployment("1", "nini", "");
            this.FinancialSituationExperience("9", "8", "14", "14", 0, 0);
            this.FinancialAffiliations(true, "zecco", false, "", "", false, "", "", "", "");
            browser.Button(Find.ById("Background_uxSubmit")).Click();
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
        public void T06_BackEnd_IndiUS_ECIP_Aff_PF()
        {
            this.GotoOLA();
            browser.CheckBox(Find.ById("Welcome_uxIndividual")).Checked = true;
            browser.Button(Find.ById("Welcome_uxSubmit")).Click();
            System.Threading.Thread.Sleep(2000);
            this.PersonalValidSSN();
            this.FinancialEmployment("1", "nini", "");
            this.FinancialSituationExperience("9", "8", "14", "14", 0, 0);
            this.FinancialAffiliations(true, "zecco", false, "", "", true, "wjb", "gwy", "2830", "1003");
            browser.Button(Find.ById("Background_uxSubmit")).Click();
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
        public void T07_BackEnd_IRAUS_ECIP_Aff()
        {
            this.GotoOLA();
            browser.CheckBox(Find.ById("Welcome_uxIRA")).Checked = true;
            System.Threading.Thread.Sleep(1000);
            browser.RadioButton(Find.ById("Welcome_uxRollover")).Checked = true;
            browser.Button(Find.ById("Welcome_uxSubmit")).Click();
            System.Threading.Thread.Sleep(2000);
            this.PersonalValidSSN();
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
        public void T08_BackEnd_IRAUS_ECIP_Aff_PF()
        {
            this.GotoOLA();
            browser.CheckBox(Find.ById("Welcome_uxIRA")).Checked = true;
            System.Threading.Thread.Sleep(1000);
            browser.RadioButton(Find.ById("Welcome_uxRollover")).Checked = true;
            browser.Button(Find.ById("Welcome_uxSubmit")).Click();
            System.Threading.Thread.Sleep(2000);
            this.PersonalValidSSN();
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
        public void T09_BackEnd_IRAUS_ECIP_Spouse()
        {
            this.GotoOLA();
            browser.CheckBox(Find.ById("Welcome_uxIRA")).Checked = true;
            System.Threading.Thread.Sleep(1000);
            browser.RadioButton(Find.ById("Welcome_uxSEP")).Checked = true;
            browser.Button(Find.ById("Welcome_uxSubmit")).Click();
            System.Threading.Thread.Sleep(2000);
            this.PersonalValidSSN();
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
        public void T10_BackEnd_IRAUS_ECIP_PF_Spouse()
        {
            this.GotoOLA();
            browser.CheckBox(Find.ById("Welcome_uxIRA")).Checked = true;
            System.Threading.Thread.Sleep(1000);
            browser.RadioButton(Find.ById("Welcome_uxSEP")).Checked = true;
            browser.Button(Find.ById("Welcome_uxSubmit")).Click();
            System.Threading.Thread.Sleep(2000);
            this.PersonalValidSSN();
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
        public void T11_BackEnd_JointUSNRA_ECIP()
        {
            this.GotoOLA();
            browser.CheckBox(Find.ById("Welcome_uxJoint")).Checked = true;
            browser.Button(Find.ById("Welcome_uxSubmit")).Click();
            System.Threading.Thread.Sleep(2000);
            this.PersonalValidSSN();
            this.JointName("", firstCo, "", lastCo, "3");
            this.JointBirthGenderMarital("3", "3", "1983", 2, 2);
            this.JointCitiResi(1, "3550", 1, "2830", "234232345");
            browser.Button(Find.ById("JointHolder_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.Financial();
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
        public void T12_BackEnd_JointUSNRA_ECIP_PF()
        {
            this.GotoOLA();
            browser.CheckBox(Find.ById("Welcome_uxJoint")).Checked = true;
            browser.Button(Find.ById("Welcome_uxSubmit")).Click();
            System.Threading.Thread.Sleep(2000);
            this.PersonalValidSSN();
            this.JointName("", firstCo, "", lastCo, "3");
            this.JointBirthGenderMarital("3", "3", "1983", 2, 2);
            this.JointCitiResi(1, "3550", 1, "2830", "234232345");
            browser.Button(Find.ById("JointHolder_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.FinancialEmployment("1", "nini", "");
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
        public void T13_BackEnd_JointUSNRA_ECIP_Aff()
        {
            this.GotoOLA();
            browser.CheckBox(Find.ById("Welcome_uxJoint")).Checked = true;
            browser.Button(Find.ById("Welcome_uxSubmit")).Click();
            System.Threading.Thread.Sleep(2000);
            this.PersonalValidSSN();
            this.JointName("", firstCo, "", lastCo, "3");
            this.JointBirthGenderMarital("3", "3", "1983", 2, 2);
            this.JointCitiResi(1, "3550", 1, "2830", "234232345");
            browser.Button(Find.ById("JointHolder_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.FinancialEmployment("1", "nini", "");
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
        public void T14_BackEnd_JointUSNRA_ECIP_Aff_PF()
        {
            this.GotoOLA();
            browser.CheckBox(Find.ById("Welcome_uxJoint")).Checked = true;
            browser.Button(Find.ById("Welcome_uxSubmit")).Click();
            System.Threading.Thread.Sleep(2000);
            this.PersonalValidSSN();
            this.JointName("", firstCo, "", lastCo, "3");
            this.JointBirthGenderMarital("3", "3", "1983", 2, 2);
            this.JointCitiResi(1, "3550", 1, "2830", "234232345");
            browser.Button(Find.ById("JointHolder_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
            this.FinancialEmployment("1", "nini", "");
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
