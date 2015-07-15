using System;
using System.Collections.Generic;
using System.Text;
using WatiN.Core;
using NUnit.Framework;
using WatiN.Core.Interfaces;
using WatiN.Core.DialogHandlers;

namespace MaiaRegression.Appobjects.App01_HomePage
{
    public class OLA : SignIn
    {
        //Title 5:Dr. 6:Mr. 7:Ms. 8:Mrs. 9:Miss
        //Suffix 1:Jr. 2:Sr. 3:II 4:III 5:IV
        //Country 2390-4870
        //State 70-134
        //Employment 1:Employed 2:Self employed 3:Unemployed/Not Employed 4:Retired 5:Student
        //Nature 41-67
        //AnnualIncome 9-13
        //IncomeSource 8-14
        //NetWorth 14-20
        //Liquid 14-20
        //PFRelation 1000-1007
        //Relationship 1010:Spouse 1012:Parent 1013:Sibling 1014:Child 1015:Other relative 1016:Charitable organization 1017:Trust 1018:Applicant's estate
        //BeneficiaryType 1:Primary 2:Contingent

        public string first = "spring";
        public string last = "mei";
        public string firstCo = "jiuma";
        public string lastCo = "wang";

        #region Front End
        public void GotoOLA()
        {
            browser.GoTo(URL);
            UserSignIn(UN_OLA, PW_OLA, false, 3);
            System.Threading.Thread.Sleep(3000);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxTopNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            browser.Image(Find.ByAlt("open an account")).Click();
            browser.Button(Find.ById("Welcome_uxSubmit")).WaitUntilExists();
        }

        public void GotoOLA(string un, string pw)
        {
            browser.GoTo(URL);
            UserSignIn(un, pw, false, 3);
            System.Threading.Thread.Sleep(3000);
            browser.Link(Find.ById("ctl00_ctl00_uxPreContent_uxTopNavigation_uxTopNavRepeater_ctl00_uxTopNavLink")).Click();
            System.Threading.Thread.Sleep(2000);
            browser.Image(Find.ByAlt("open an account")).Click();
            browser.Button(Find.ById("Welcome_uxSubmit")).WaitUntilExists();
        }

        public void PersonalName(string title, string first, string initial, string last, string suffix)
        {
            if (string.IsNullOrEmpty(title) == false)
            {
                browser.SelectList(Find.ById("PersonalInfo_uxTitle")).Option(Find.ByValue(title)).Select();
            }
            browser.TextField(Find.ById("PersonalInfo_uxFirstName")).TypeText(first);
            browser.TextField(Find.ById("PersonalInfo_uxInitial")).TypeText(initial);
            browser.TextField(Find.ById("PersonalInfo_uxLastName")).TypeText(last);
            if (string.IsNullOrEmpty(suffix) == false)
            {
                browser.SelectList(Find.ById("PersonalInfo_uxSuffix")).Option(Find.ByValue(suffix)).Select();
            }
        }

        public void PersonalBirthGenderMarital(string month, string day, string year, int gender, int marital)
        {
            browser.SelectList(Find.ById("PersonalInfo_uxBirthMonth")).Option(Find.ByValue(month)).Select();
            browser.SelectList(Find.ById("PersonalInfo_uxBirthDay")).Option(Find.ByValue(day)).Select();
            browser.SelectList(Find.ById("PersonalInfo_uxBirthYear")).Option(Find.ByValue(year)).Select();
            if (gender == 1)
            {
                //male
                browser.RadioButton(Find.ById("PersonalInfo_uxGender0")).Checked = true;
            }
            else
            {
                //female
                browser.RadioButton(Find.ById("PersonalInfo_uxGender1")).Checked = true;
            }

            if (marital == 1)
            {
                //single
                browser.RadioButton(Find.ById("PersonalInfo_uxMaritalStatus0")).Checked = true;
            }
            else
            {
                //married
                browser.RadioButton(Find.ById("PersonalInfo_uxMaritalStatus1")).Checked = true;
            }
        }

        public void PersonalCitiResi(int citizen, string citiCountry, int residence, string resiCountry, string id)
        {
            if (citizen == 0)
            {
                //US
                browser.RadioButton(Find.ById("PersonalInfo_uxIsUSCitizenShip")).Checked = true;
            }
            else
            {
                //Other
                browser.RadioButton(Find.ById("PersonalInfo_CitizenshipCitizenother")).Checked = true;
                System.Threading.Thread.Sleep(1000);
                browser.SelectList(Find.ById("PersonalInfo_uxCitizenship")).Option(Find.ByValue(citiCountry)).Select();
            }

            if (residence == 0)
            {
                //US
                browser.RadioButton(Find.ById("PersonalInfo_uxIsUSResidence")).Checked = true;
            }
            else
            {
                //Other
                browser.RadioButton(Find.ById("PersonalInfo_Residenceother")).Checked = true;
                System.Threading.Thread.Sleep(1000);
                browser.SelectList(Find.ById("PersonalInfo_uxResidence")).Option(Find.ByValue(resiCountry)).Select();
            }

            System.Threading.Thread.Sleep(1000);
            if (citizen + residence < 2)
            {
                browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxPersonal_PersonalInfo_SocialNumber")).Value = id;
            }
            else
            {
                browser.TextField(Find.ById("PersonalInfo_uxGovernmentId")).TypeText(id);
            }
        }

        public void PersonalUSResiAddr(string address1, string address2, string city, string zip)
        {
            browser.TextField(Find.ById("PersonalInfo_uxAddress1")).TypeText(address1);
            browser.TextField(Find.ById("PersonalInfo_uxAddress2")).TypeText(address2);
            browser.TextField(Find.ById("PersonalInfo_uxCity")).TypeText(city);
            browser.SelectList(Find.ById("PersonalInfo_uxState")).Option(Find.ByValue("70")).Select();
            browser.TextField(Find.ById("PersonalInfo_uxZipCode")).TypeText(zip);
        }

        public void PersonalOtherResiAddr(string address1, string address2, string province, string postal)
        {
            browser.TextField(Find.ById("PersonalInfo_uxAddress1")).TypeText(address1);
            browser.TextField(Find.ById("PersonalInfo_uxAddress2")).TypeText(address2);
            browser.TextField(Find.ById("PersonalInfo_uxProvince")).TypeText(province);
            browser.TextField(Find.ById("PersonalInfo_uxPostalCode")).TypeText(postal);
        }

        public void PersonalUSMailAddr(string address1, string address2, string city, string zip)
        {
            browser.CheckBox(Find.ById("PersonalInfo_uxIsMailingAddressDifferent")).Checked = true;
            System.Threading.Thread.Sleep(1000);
            browser.TextField(Find.ById("PersonalInfo_uxMailingStreetAddress")).TypeText(address1);
            browser.TextField(Find.ById("PersonalInfo_uxMailingAddressLine2")).TypeText(address2);
            browser.TextField(Find.ById("PersonalInfo_uxMailingCity")).TypeText(city);
            browser.SelectList(Find.ById("PersonalInfo_uxMailingState")).Option(Find.ByValue("70")).Select();
            browser.TextField(Find.ById("PersonalInfo_uxMailingZipCode")).TypeText(zip);
        }

        public void PersonalOtherMailAddr(string country, string address1, string address2, string province, string postal)
        {
            browser.CheckBox(Find.ById("PersonalInfo_uxIsMailingAddressDifferent")).Checked = true;
            System.Threading.Thread.Sleep(1000);
            browser.SelectList(Find.ById("PersonalInfo_uxMailAddressCountry")).Option(Find.ByValue(country)).Select();
            browser.TextField(Find.ById("PersonalInfo_uxAddress1")).TypeText(address1);
            browser.TextField(Find.ById("PersonalInfo_uxAddress2")).TypeText(address2);
            browser.TextField(Find.ById("PersonalInfo_uxProvince")).TypeText(province);
            browser.TextField(Find.ById("PersonalInfo_uxPostalCode")).TypeText(postal);
        }

        public void PersonalPhoneNum(bool isPreUS, string prePhone, bool isAltUS, string altPhone)
        {
            if (isPreUS == true)
            {
                browser.SelectList(Find.ById("PersonalInfo_uxPrePhoneType")).Option(Find.ByValue("1")).Select();
            }
            else
            {
                browser.SelectList(Find.ById("PersonalInfo_uxPrePhoneType")).Option(Find.ByValue("0")).Select();
            }
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxPersonal_PersonalInfo_uxPreferred")).TypeText(prePhone);

            if (isAltUS == true)
            {
                browser.SelectList(Find.ById("PersonalInfo_uxAltPhoneType")).Option(Find.ByValue("1")).Select();
            }
            else
            {
                browser.SelectList(Find.ById("PersonalInfo_uxAltPhoneType")).Option(Find.ByValue("0")).Select();
            }
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxPersonal_PersonalInfo_uxAlternative")).TypeText(altPhone);
        }

        public void JointName(string title, string first, string initial, string last, string suffix)
        {
            if (string.IsNullOrEmpty(title) == false)
            {
                browser.SelectList(Find.ById("JointHolder_uxTitle")).Option(Find.ByValue(title)).Select();
            }
            browser.TextField(Find.ById("JointHolder_uxFirstName")).TypeText(first);
            browser.TextField(Find.ById("JointHolder_uxInitial")).TypeText(initial);
            browser.TextField(Find.ById("JointHolder_uxLastName")).TypeText(last);
            if (string.IsNullOrEmpty(suffix) == false)
            {
                browser.SelectList(Find.ById("JointHolder_uxSuffix")).Option(Find.ByValue(suffix)).Select();
            }
        }

        public void JointBirthGenderMarital(string month, string day, string year, int gender, int marital)
        {
            browser.SelectList(Find.ById("JointHolder_uxBirthMonth")).Option(Find.ByValue(month)).Select();
            browser.SelectList(Find.ById("JointHolder_uxBirthDay")).Option(Find.ByValue(day)).Select();
            browser.SelectList(Find.ById("JointHolder_uxBirthYear")).Option(Find.ByValue(year)).Select();
            if (gender == 1)
            {
                //male
                browser.RadioButton(Find.ById("JointHolder_uxGender0")).Checked = true;
            }
            else
            {
                //female
                browser.RadioButton(Find.ById("JointHolder_uxGender1")).Checked = true;
            }

            if (marital == 1)
            {
                //single
                browser.RadioButton(Find.ById("JointHolder_uxMaritalStatus0")).Checked = true;
            }
            else
            {
                //married
                browser.RadioButton(Find.ById("JointHolder_uxMaritalStatus1")).Checked = true;
            }
        }

        public void JointCitiResi(int citizen, string citiCountry, int residence, string resiCountry, string id)
        {
            if (citizen == 0)
            {
                //US
                browser.RadioButton(Find.ById("JointHolder_uxIsUSCitizenShip")).Checked = true;
            }
            else
            {
                //Other
                browser.RadioButton(Find.ById("JointHolder_CitizenshipOther")).Checked = true;
                System.Threading.Thread.Sleep(2000);
                browser.SelectList(Find.ById("JointHolder_uxCitizenship")).Option(Find.ByValue(citiCountry)).Select();
            }

            if (residence == 0)
            {
                //US
                browser.RadioButton(Find.ById("JointHolder_uxIsUSResidence")).Checked = true;
            }
            else
            {
                //Other
                browser.RadioButton(Find.ById("JointHolder_uxResidenceOther")).Checked = true;
                System.Threading.Thread.Sleep(2000);
                browser.SelectList(Find.ById("JointHolder_uxResidence")).Option(Find.ByValue(resiCountry)).Select();
            }

            System.Threading.Thread.Sleep(1000);
            if (citizen + residence < 2)
            {
                browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxJointHolderStep_JointHolder_SocialNumber")).TypeText(id);
            }
            else
            {
                browser.TextField(Find.ById("JointHolder_uxGovernmentId")).TypeText(id);
            }

            if (browser.CheckBox(Find.ById("JointHolder_LegalCheck")).Enabled == true)
            {
                browser.CheckBox(Find.ById("JointHolder_LegalCheck")).Checked = false;
                System.Threading.Thread.Sleep(1000);
            }
        }

        public void JointUSResiAddr(string address1, string address2, string city, string zip)
        {
            if (browser.CheckBox(Find.ById("JointHolder_LegalCheck")).Checked == false)
            {
                browser.CheckBox(Find.ById("JointHolder_LegalCheck")).Checked = true;
                System.Threading.Thread.Sleep(1000);
            }
            browser.TextField(Find.ById("JointHolder_uxAddress1")).TypeText(address1);
            browser.TextField(Find.ById("JointHolder_uxAddress2")).TypeText(address2);
            browser.TextField(Find.ById("JointHolder_uxCity")).TypeText(city);
            browser.SelectList(Find.ById("JointHolder_uxState")).Option(Find.ByValue("70")).Select();
            browser.TextField(Find.ById("JointHolder_uxZipCode")).TypeText(zip);
        }

        public void JointOtherResiAddr(string address1, string address2, string province, string postal)
        {
            if (browser.CheckBox(Find.ById("JointHolder_LegalCheck")).Checked == false)
            {
                browser.CheckBox(Find.ById("JointHolder_LegalCheck")).Checked = true;
                System.Threading.Thread.Sleep(1000);
            }
            browser.TextField(Find.ById("JointHolder_uxAddress1")).TypeText(address1);
            browser.TextField(Find.ById("JointHolder_uxAddress2")).TypeText(address2);
            browser.TextField(Find.ById("JointHolder_uxProvince")).TypeText(province);
            browser.TextField(Find.ById("JointHolder_uxPostalCode")).TypeText(postal);
        }

        public void FinancialEmployment(string status, string employer, string nature)
        {
            browser.SelectList(Find.ById("Background_uxEmploymentStatus")).Option(Find.ByValue(status)).Select();
            if (int.Parse(status) > 2)
            {
                return;
            }
            System.Threading.Thread.Sleep(1000);
            browser.TextField(Find.ById("Background_uxEmployerName")).TypeText(employer);
            if (string.IsNullOrEmpty(nature) == false)
            {
                browser.SelectList(Find.ById("Background_uxBusinessNature")).Option(Find.ByValue(nature)).Select();
            }
        }

        public void FinancialCoEmployment(string status, string employer, string nature)
        {
            browser.SelectList(Find.ById("Background_uxCoEmploymentStatus")).Option(Find.ByValue(status)).Select();
            if (int.Parse(status) > 2)
            {
                return;
            }
            System.Threading.Thread.Sleep(1000);
            browser.TextField(Find.ById("Background_uxCoEmployerName")).TypeText(employer);
            if (string.IsNullOrEmpty(nature) == false)
            {
                browser.SelectList(Find.ById("Background_uxCoBusinessNature")).Option(Find.ByValue(nature)).Select();
            }
        }

        public void FinancialSituationExperience(string annualIncome, string incomeSource, string netWorth, string liqiud, int stock, int option)
        {
            browser.SelectList(Find.ById("Background_uxAnnualIncome")).Option(Find.ByValue(annualIncome)).Select();
            browser.SelectList(Find.ById("Background_uxPrimaryIncome")).Option(Find.ByValue(incomeSource)).Select();
            browser.SelectList(Find.ById("Background_uxNetWorth")).Option(Find.ByValue(netWorth)).Select();
            browser.SelectList(Find.ById("Background_uxLiquidNetWorth")).Option(Find.ByValue(liqiud)).Select();

            //0, 1, 2, 3
            string sEx = "Background_uxStock" + stock.ToString();
            browser.RadioButton(Find.ById(sEx)).Checked = true;
            string oEx = "Background_uxOption" + option.ToString();
            browser.RadioButton(Find.ById(oEx)).Checked = true;
        }

        public void FinancialAffiliations(
            bool isAff, string employer, 
            bool isHold, string company, string symbol, 
            bool isPol, string official, string title, string country, string relationship)
        {
            if (isAff == true)
            {
                browser.RadioButton(Find.ById("Background_uxAffiliationyes")).Checked = true;
                browser.TextField(Find.ById("Background_uxBrokerName")).TypeText(employer);
            }
            else
            {
                browser.RadioButton(Find.ById("Background_uxAffiliationno")).Checked = true;
            }

            if (isHold == true)
            {
                browser.RadioButton(Find.ById("Background_uxShareholderYes")).Checked = true;
                browser.TextField(Find.ById("Background_uxShareHolderCompanyName")).TypeText(company);
                browser.TextField(Find.ById("Background_uxShareHolderComanySymbol")).TypeText(symbol);
            }
            else
            {
                browser.RadioButton(Find.ById("Background_uxShareholderNo")).Checked = true;
            }

            if (isPol == true)
            {
                browser.RadioButton(Find.ById("Background_uxPoliticalYes")).Checked = true;
                browser.TextField(Find.ById("Background_uxOfficialName")).TypeText(official);
                browser.TextField(Find.ById("Background_uxTitleAndDept")).TypeText(title);
                browser.SelectList(Find.ById("Background_uxForeignPoliticalCountry")).Option(Find.ByValue(country)).Select();
                browser.SelectList(Find.ById("Background_uxRelationship")).Option(Find.ByValue(relationship)).Select();
            }
            else
            {
                browser.RadioButton(Find.ById("Background_uxPoliticalNo")).Checked = true;
            }
        }

        public void BeneficiariesPrimary(string relation, string first, string initial, string last, string month, string day, string year, string id)
        {
            browser.SelectList(Find.ById("Beneficiary_uxRelationship")).Option(Find.ByValue(relation)).Select();
            browser.TextField(Find.ById("Beneficiary_uxFirstName")).TypeText(first);
            browser.TextField(Find.ById("Beneficiary_uxMiddleName")).TypeText(initial);
            browser.TextField(Find.ById("Beneficiary_uxLastName")).TypeText(last);
            browser.SelectList(Find.ById("Beneficiary_uxMonth")).Option(Find.ByValue(month)).Select();
            browser.SelectList(Find.ById("Beneficiary_uxDay")).Option(Find.ByValue(day)).Select();
            browser.SelectList(Find.ById("Beneficiary_uxYear")).Option(Find.ByValue(year)).Select();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxBeneficiary_Beneficiary_uxSSN")).TypeText(id);
        }

        public void BeneficiariesPriAddrUS(string address1, string address2, string city, string state, string zip)
        {
            browser.CheckBox(Find.ById("Beneficiary_uxMailingAddr")).Checked = true;
            System.Threading.Thread.Sleep(1000);
            browser.TextField(Find.ById("Beneficiary_uxAddress1")).TypeText(address1);
            browser.TextField(Find.ById("Beneficiary_uxAddress2")).TypeText(address2);
            browser.TextField(Find.ById("Beneficiary_uxCity")).TypeText(city);
            browser.SelectList(Find.ById("Beneficiary_uxState")).Option(Find.ByValue("70")).Select();
            browser.TextField(Find.ById("Beneficiary_uxZipCode")).TypeText(zip);
        }

        public void BeneficiariesAdd(string type, string relation, string first, string initial, string last, string month, string day, string year, string id)
        {
            if (browser.Div(Find.ById("Beneficiary_uxAdditionalSection1")).Style.Display == "none")
            {
                browser.Button(Find.ById("Beneficiary_uxAddAnotherBeneficiary")).Click();
                System.Threading.Thread.Sleep(1000);
                browser.SelectList(Find.ById("Beneficiary_uxBeneficiaryType1")).Option(Find.ByValue(type)).Select();
                browser.SelectList(Find.ById("Beneficiary_uxRelationship1")).Option(Find.ByValue(relation)).Select();
                browser.TextField(Find.ById("Beneficiary_uxFirstName1")).TypeText(first);
                browser.TextField(Find.ById("Beneficiary_uxMiddleName1")).TypeText(initial);
                browser.TextField(Find.ById("Beneficiary_uxLastName1")).TypeText(last);
                browser.SelectList(Find.ById("Beneficiary_uxMonth1")).Option(Find.ByValue(month)).Select();
                browser.SelectList(Find.ById("Beneficiary_uxDay1")).Option(Find.ByValue(day)).Select();
                browser.SelectList(Find.ById("Beneficiary_uxYear1")).Option(Find.ByValue(year)).Select();
                browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxBeneficiary_Beneficiary_uxSSN1")).TypeText(id);
            }
            else if (browser.Div(Find.ById("Beneficiary_uxAdditionalSection2")).Style.Display == "none")
            {
                browser.Button(Find.ById("Beneficiary_uxAddAnotherBeneficiary")).Click();
                System.Threading.Thread.Sleep(1000);
                browser.SelectList(Find.ById("Beneficiary_uxBeneficiaryType2")).Option(Find.ByValue(type)).Select();
                browser.SelectList(Find.ById("Beneficiary_uxRelationship2")).Option(Find.ByValue(relation)).Select();
                browser.TextField(Find.ById("Beneficiary_uxFirstName2")).TypeText(first);
                browser.TextField(Find.ById("Beneficiary_uxMiddleName2")).TypeText(initial);
                browser.TextField(Find.ById("Beneficiary_uxLastName2")).TypeText(last);
                browser.SelectList(Find.ById("Beneficiary_uxMonth2")).Option(Find.ByValue(month)).Select();
                browser.SelectList(Find.ById("Beneficiary_uxDay2")).Option(Find.ByValue(day)).Select();
                browser.SelectList(Find.ById("Beneficiary_uxYear2")).Option(Find.ByValue(year)).Select();
                browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxBeneficiary_Beneficiary_uxSSN2")).TypeText(id);
            }
            else if (browser.Div(Find.ById("Beneficiary_uxAdditionalSection3")).Style.Display == "none")
            {
                browser.Button(Find.ById("Beneficiary_uxAddAnotherBeneficiary")).Click();
                System.Threading.Thread.Sleep(1000);
                browser.SelectList(Find.ById("Beneficiary_uxBeneficiaryType3")).Option(Find.ByValue(type)).Select();
                browser.SelectList(Find.ById("Beneficiary_uxRelationship3")).Option(Find.ByValue(relation)).Select();
                browser.TextField(Find.ById("Beneficiary_uxFirstName3")).TypeText(first);
                browser.TextField(Find.ById("Beneficiary_uxMiddleName3")).TypeText(initial);
                browser.TextField(Find.ById("Beneficiary_uxLastName3")).TypeText(last);
                browser.SelectList(Find.ById("Beneficiary_uxMonth3")).Option(Find.ByValue(month)).Select();
                browser.SelectList(Find.ById("Beneficiary_uxDay3")).Option(Find.ByValue(day)).Select();
                browser.SelectList(Find.ById("Beneficiary_uxYear3")).Option(Find.ByValue(year)).Select();
                browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxBeneficiary_Beneficiary_uxSSN3")).TypeText(id);
            }
        }

        public void BeneficiariesAllocation(int alloc, int t1, int alloc1, int t2, int alloc2, int t3, int alloc3)
        {
            browser.TextField(Find.ById("Beneficiary_uxPrimaryInput")).TypeText(alloc.ToString());
            if (t1 == 1)
            {
                browser.TextField(Find.ById("Beneficiary_uxPrimaryInput1")).TypeText(alloc1.ToString());
            }
            else if (t1 == 2)
            {
                browser.TextField(Find.ById("Beneficiary_uxContingentInput1")).TypeText(alloc1.ToString());
            }
            if (t2 == 1)
            {
                browser.TextField(Find.ById("Beneficiary_uxPrimaryInput2")).TypeText(alloc2.ToString());
            }
            else if (t2 == 2)
            {
                browser.TextField(Find.ById("Beneficiary_uxContingentInput2")).TypeText(alloc2.ToString());
            }
            if (t3 == 1)
            {
                browser.TextField(Find.ById("Beneficiary_uxPrimaryInput3")).TypeText(alloc3.ToString());
            }
            else if (t3 == 2)
            {
                browser.TextField(Find.ById("Beneficiary_uxContingentInput3")).TypeText(alloc3.ToString());
            }
        }

        public void BeneficiariesRemove(int addNum)
        {
            string section = "Beneficiary_uxAdditionalSection" + addNum.ToString();
            browser.Div(Find.ById(section)).Link(Find.ByClass("remove")).Click();
        }

        public void PreferencesObjective(int objective)
        {
            switch (objective)
            {
                case 1:
                    browser.RadioButton(Find.ById("Preferences_uxCapital")).Checked = true;
                    break;
                case 2:
                    browser.RadioButton(Find.ById("Preferences_uxIncome")).Checked = true;
                    break;
                case 3:
                    browser.RadioButton(Find.ById("Preferences_uxIncomeGrowth")).Checked = true;
                    break;
                case 4:
                    browser.RadioButton(Find.ById("Preferences_uxGrowth")).Checked = true;
                    break;
                case 5:
                    browser.RadioButton(Find.ById("Preferences_uxSpeculation")).Checked = true;
                    break;
                default:
                    break;
            }
        }

        public void PreferencesMOP(bool margin, bool option, int level, bool paperless)
        {
            if (margin == true)
            {
                if (browser.RadioButton(Find.ById("Preferences_uxEnablemargin")).Exists == true)
                {
                    browser.RadioButton(Find.ById("Preferences_uxEnablemargin")).Checked = true;
                }
            }
            else
            {
                if (browser.RadioButton(Find.ById("Preferences_uxDisablemargin")).Exists == true)
                {
                    browser.RadioButton(Find.ById("Preferences_uxDisablemargin")).Checked = true;
                }
            }

            if (option == true)
            {
                browser.RadioButton(Find.ById("Preferences_uxEnableoptions")).Checked = true;
                System.Threading.Thread.Sleep(1000);
                switch (level)
                {
                    case 1:
                        browser.CheckBox(Find.ById("slider1input")).Checked = true;
                        break;
                    case 2:
                        browser.CheckBox(Find.ById("slider2input")).Checked = true;
                        break;
                    case 3:
                        browser.CheckBox(Find.ById("slider3input")).Checked = true;
                        break;
                    default:
                        break;
                }
            }
            else
            {
                browser.RadioButton(Find.ById("Preferences_uxDisableoptions")).Checked = true;
            }

            if (paperless == true)
            {
                browser.RadioButton(Find.ById("Preferences_Paperlessyes")).Checked = true;
            }
            else
            {
                browser.RadioButton(Find.ById("Preferences_Paperlessno")).Checked = true;
            }
        }

        public void ReviewEdit(string edit)
        {
            switch (edit)
            {
                case "Primary":
                    browser.Button(Find.ById("Review_uxEditPrimary")).Click();
                    break;
                case "Co":
                    browser.Button(Find.ById("Review_uxEditCo")).Click();
                    break;
                case "Contact":
                    browser.Button(Find.ById("Review_uxEditContact")).Click();
                    break;
                case "Background":
                    browser.Button(Find.ById("Review_uxEditBackground")).Click();
                    break;
                case "Preferences":
                    browser.Button(Find.ById("Review_uxEditPreferences")).Click();
                    break;
                case "IraBenificiary":
                    browser.Button(Find.ById("Review_uxEditIraBenificiary")).Click();
                    break;
                default:
                    break;
            }
        }

        public void IAuth()
        {
            if (browser.Div(Find.ById("Review_uxPopup")).Exists == true)
            {
                browser.Button(Find.ById("Review_uxPopupContinue")).Click();
                for (int i = 0; i < 2; i++)
                {
                    System.Threading.Thread.Sleep(5000);
                    if (((browser.Link(Find.ById("IAuth_uxHelpHowDoWeKnowTheseAnswers")).Exists == true) ||
                        (browser.Link(Find.ById("IAuthJoint_uxHelpHowDoWeKnowTheseAnswers")).Exists == true)) && 
                        (browser.TextField(Find.ById("Submit_uxFirstName")).Exists == false))
                    {
                        this.IdentityQuestions();
                    }
                }
            }
            this.AddFundLater();
        }

        public void IdentityQuestions()
        {
            browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxIAuth_uxRepeaterIssues_Table")).TableBodies[0].Divs[0].Spans[0].CheckBoxes[0].Checked = true;
            browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxIAuth_uxRepeaterIssues_Table")).TableBodies[0].Divs[1].Spans[0].CheckBoxes[0].Checked = true;
            browser.Table(Find.ById("ctl00_ctl00_uxMainContent_uxUserControlContent_uxIAuth_uxRepeaterIssues_Table")).TableBodies[0].Divs[2].Spans[0].CheckBoxes[0].Checked = true;

            browser.Button(Find.ById("IAuth_uxSubmit")).Click();
        }

        public void AddFundLater()
        {
            browser.Link(Find.ById("Prepare_uxAddFundsLater")).WaitUntilExists();
            browser.Link(Find.ById("Prepare_uxAddFundsLater")).Click();
            System.Threading.Thread.Sleep(5000);            
        }

        public void SubmitIndividual(string first, string last)
        {
            browser.TextField(Find.ById("Submit_uxFirstName")).TypeText(first);
            browser.TextField(Find.ById("Submit_uxLastName")).TypeText(last);
        }

        public void SubmitJoint(string first, string last, string firstCo, string lastCo)
        {
            //browser.Span(Find.ById("Submit_uxFirstNameLabel")).Text;
            //browser.Span(Find.ById("Submit_uxLastNameLabel")).Text;
            //browser.Span(Find.ById("Submit_uxCoFirstNameLabel")).Text;
            //browser.Span(Find.ById("Submit_uxCoLastNameLabel")).Text;
            browser.TextField(Find.ById("Submit_uxFirstName")).TypeText(first);
            browser.TextField(Find.ById("Submit_uxLastName")).TypeText(last);
            browser.TextField(Find.ById("Submit_uxCoFirstName")).TypeText(firstCo);
            browser.TextField(Find.ById("Submit_uxCoLastName")).TypeText(lastCo);
        }
        #endregion

        #region Back End
        public void Personal()
        {
            this.PersonalName("", first, "", last, "");
            this.PersonalBirthGenderMarital("5", "5", "1985", 1, 2);
            this.PersonalCitiResi(0, "", 0, "", "123121234");
            this.PersonalUSResiAddr("qqq", "www", "eee", "94147");
            this.PersonalPhoneNum(true, "9874563210", true, "");
            browser.Button(Find.ById("PersonalInfo_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
        }

        public string ssnFirst = "Christopher";
        public string ssnLast = "Leach";

        public void PersonalValidSSN()
        {
            this.PersonalName("", ssnFirst, "", ssnLast, "");
            this.PersonalBirthGenderMarital("1", "1", "1981", 1, 2);
            this.PersonalCitiResi(0, "", 0, "", "569813322");
            this.PersonalUSResiAddr("qqq", "www", "eee", "94147");
            this.PersonalPhoneNum(true, "9874563210", true, "");
            browser.Button(Find.ById("PersonalInfo_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
        }

        public void Joint()
        {
            browser.WaitForComplete(10);
            this.JointName("", firstCo, "", lastCo, "");
            this.JointBirthGenderMarital("3", "3", "1983", 2, 2);
            this.JointCitiResi(0, "", 0, "", "234232345");
            browser.Button(Find.ById("JointHolder_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
        }

        public void Financial()
        {
            this.FinancialEmployment("1", "nini", "");
            this.FinancialSituationExperience("9", "8", "14", "14", 0, 0);
            this.FinancialAffiliations(false, "", false, "", "", false, "", "", "", "");
            browser.Button(Find.ById("Background_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
        }

        public void FinancialJoint()
        {
            this.FinancialEmployment("1", "nini", "");
            this.FinancialCoEmployment("1", "nini", "");
            this.FinancialSituationExperience("9", "8", "14", "14", 0, 0);
            this.FinancialAffiliations(false, "", false, "", "", false, "", "", "", "");
            browser.Button(Find.ById("Background_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
        }

        public void Beneficiaries()
        {
            this.BeneficiariesPrimary("1010", firstCo, "", lastCo, "3", "3", "1983", "234232345");
            browser.Button(Find.ById("Beneficiary_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
        }

        public void Preferences()
        {
            this.PreferencesObjective(1);
            this.PreferencesMOP(false, false, 0, true);
            browser.Button(Find.ById("Preferences_uxSubmit")).Click();
            System.Threading.Thread.Sleep(3000);
        }
        #endregion

        #region OLA admin
        public void GoToOLAAdmin()
        {
            browser.GoTo(OLAAdminUrl);
            browser.TextField(Find.ById("userName")).TypeText(UN_OLAAdmin);
            browser.TextField(Find.ById("password")).TypeText(PW_OLAAdmin);
            browser.Button(Find.ByClass("submit")).Click();
            browser.Link(Find.ById("ctl00_hplLogout")).WaitUntilExists(20);
        }

        public void Preview_BizTrust(string type, string id, string name)
        {
            browser.Button(Find.ById("ctl00_InsertPnl_BtnPreview")).WaitUntilExists(20);
            browser.SelectList(Find.ById("ctl00_InsertPnl_AccountType")).Option(Find.ByText(type)).Select();
            browser.TextField(Find.ById("ctl00_InsertPnl_AdultSSN")).TypeText(id);
            browser.TextField(Find.ById("ctl00_InsertPnl_AdultFirstName")).TypeText(name);
            browser.Button(Find.ById("ctl00_InsertPnl_BtnPreview")).Click();
        }

        public string Generate_BizTrust(string type, string id, string name, ref string referNum)
        {
            browser.Button(Find.ById("ctl00_ConfirmPnl_PreAllocateBtn")).WaitUntilExists(20);
            Assert.AreEqual(browser.Span(Find.ById("ctl00_ConfirmPnl_AccountType")).Text.Trim(), type);
            Assert.AreEqual(browser.Span(Find.ById("ctl00_ConfirmPnl_AdultSSNValue")).Text.Trim(), id);
            Assert.AreEqual(browser.Span(Find.ById("ctl00_ConfirmPnl_AdultFirstNameValue")).Text.Trim(), name);
            browser.Button(Find.ById("ctl00_ConfirmPnl_PreAllocateBtn")).Click();
            browser.Button(Find.ById("ctl00_SuccessPnl_SaveBtn")).WaitUntilExists(20);
            referNum = browser.Span(Find.ById("ctl00_SuccessPnl_ReferNum")).Text.Trim();
            string pensonNum = browser.Span(Find.ById("ctl00_SuccessPnl_PensonNum")).Text.Trim();
            browser.Button(Find.ById("ctl00_SuccessPnl_SaveBtn")).Click();

            return pensonNum;
        }

        public void Preview_Custodial(string type, string adultSSN, string adultFN, string adultLN, string childSSN, string childFN, string childLN)
        {
            browser.Button(Find.ById("ctl00_InsertPnl_BtnPreview")).WaitUntilExists(20);
            browser.SelectList(Find.ById("ctl00_InsertPnl_AccountType")).Option(Find.ByText(type)).Select();
            browser.TextField(Find.ById("ctl00_InsertPnl_AdultSSN")).TypeText(adultSSN);
            browser.TextField(Find.ById("ctl00_InsertPnl_AdultFirstName")).TypeText(adultFN);
            browser.TextField(Find.ById("ctl00_InsertPnl_AdultLastName")).TypeText(adultLN);
            browser.TextField(Find.ById("ctl00_InsertPnl_ChildSSN")).TypeText(childSSN);
            browser.TextField(Find.ById("ctl00_InsertPnl_ChildFirstName")).TypeText(childFN);
            browser.TextField(Find.ById("ctl00_InsertPnl_ChildLastName")).TypeText(childLN);
            browser.Button(Find.ById("ctl00_InsertPnl_BtnPreview")).Click();
        }

        public string Generate_Custodial(string type, string adultSSN, string adultFN, string adultLN, string childSSN, string childFN, string childLN, ref string referNum)
        {
            browser.Button(Find.ById("ctl00_ConfirmPnl_PreAllocateBtn")).WaitUntilExists(20);
            Assert.AreEqual(browser.Span(Find.ById("ctl00_ConfirmPnl_AccountType")).Text.Trim(), type);
            Assert.AreEqual(browser.Span(Find.ById("ctl00_ConfirmPnl_AdultSSNValue")).Text.Trim(), adultSSN);
            Assert.AreEqual(browser.Span(Find.ById("ctl00_ConfirmPnl_AdultFirstNameValue")).Text.Trim(), adultFN);
            Assert.AreEqual(browser.Span(Find.ById("ctl00_ConfirmPnl_AdultLastName")).Text.Trim(), adultLN);
            Assert.AreEqual(browser.Span(Find.ById("ctl00_ConfirmPnl_ChildSSN")).Text.Trim(), childSSN);
            Assert.AreEqual(browser.Span(Find.ById("ctl00_ConfirmPnl_ChildFirstName")).Text.Trim(), childFN);
            Assert.AreEqual(browser.Span(Find.ById("ctl00_ConfirmPnl_ChildLastName")).Text.Trim(), childLN);
            browser.Button(Find.ById("ctl00_ConfirmPnl_PreAllocateBtn")).Click();
            browser.Button(Find.ById("ctl00_SuccessPnl_SaveBtn")).WaitUntilExists(20);
            referNum = browser.Span(Find.ById("ctl00_SuccessPnl_ReferNum")).Text.Trim();
            string pensonNum = browser.Span(Find.ById("ctl00_SuccessPnl_PensonNum")).Text.Trim();
            browser.Button(Find.ById("ctl00_SuccessPnl_SaveBtn")).Click();

            return pensonNum;
        }
        #endregion
    }
}
