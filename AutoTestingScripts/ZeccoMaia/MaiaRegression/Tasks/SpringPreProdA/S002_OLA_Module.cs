using System.Collections.Generic;
using System.Text;
using WatiN.Core;
using NUnit.Framework;
using MaiaRegression.Appobjects;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks.SpringPreProdA
{
    [TestFixture]
    public class S002_OLA_Module : SignIn
    {
        [Test]
        public void T01_OLA_StartNewApp()
        {
            TestUserSignInFromSignUp(UN1, PW1, false);
            System.Threading.Thread.Sleep(5000);
            browser.Frame(Find.ByName("uxLoadSavedAppsConfirmDialog")).Button(Find.ById("ctl00_DialogPlaceHolder_uxNoButton")).Click();
            browser.Button(Find.ById("ctl00_ContentPlaceHolderActions_uxStart")).Click();
            System.Threading.Thread.Sleep(5000);
            if (browser.Div(Find.ByClass("sidebar")).Images[0].Src.Contains("01") == false)
            {
                Assert.IsTrue(false);
                return;
            }
            browser.TextField(Find.ById("ctl00_ContentPlaceHolderMain_uxFirstName")).TypeText("zhuojun");
            browser.TextField(Find.ById("ctl00_ContentPlaceHolderMain_uxMiddleInitial")).TypeText("z");
            browser.TextField(Find.ById("ctl00_ContentPlaceHolderMain_uxLastName")).TypeText("zhuang");
            browser.TextField(Find.ById("ctl00_ContentPlaceHolderMain_uxDateOfBirth_dateInput_text")).TypeText("01/01/1980");
            browser.Div(Find.ById("ctl00_ContentPlaceHolderMain_uxGender_DropDown")).SelectList(Find.ByClass("rcbList")).Option(Find.ByText("Male")).Select();
            browser.Div(Find.ById("ctl00_ContentPlaceHolderMain_uxMaritalStatus_DropDown")).SelectList(Find.ByClass("rcbList")).Option(Find.ByText("Single")).Select();
            browser.Div(Find.ById("ctl00_ContentPlaceHolderMain_uxCitizenshipCountry_DropDown")).SelectList(Find.ByClass("rcbList")).Option(Find.ByText("United States")).Select();
            browser.Button(Find.ById("ctl00_ContentPlaceHolderActions_uxNext")).Click();
            System.Threading.Thread.Sleep(5000);
            if (browser.Div(Find.ByClass("sidebar")).Images[0].Src.Contains("02") == false)
            {
                Assert.IsTrue(false);
                return;
            }
            browser.RadioButton(Find.ById("ctl00_ContentPlaceHolderMain_uxAccoutTypeIndividualRadio")).Checked = true;
            browser.Button(Find.ById("ctl00_ContentPlaceHolderActions_uxNext")).Click();
            System.Threading.Thread.Sleep(5000);
            if (browser.Div(Find.ByClass("sidebar")).Images[0].Src.Contains("03") == false)
            {
                Assert.IsTrue(false);
                return;
            }
            browser.TextField(Find.ById("ctl00_ContentPlaceHolderMain_uxHomeAddress_uxAddress1")).TypeText("zhongshan road");
            browser.TextField(Find.ById("ctl00_ContentPlaceHolderMain_uxHomeAddress_uxCity")).TypeText("shanghai");
            browser.Div(Find.ById("ctl00_ContentPlaceHolderMain_uxHomeAddress_uxState_DropDown")).SelectList(Find.ByClass("rcbList")).Option(Find.ByText("Alaska")).Select();
            browser.TextField(Find.ById("ctl00_ContentPlaceHolderMain_uxHomeAddress_uxZip")).TypeText("12345");
            browser.TextField(Find.ById("ctl00_ContentPlaceHolderMain_uxHomeAddress_UxHomePhoneMasked")).TypeText("1234567890");
            browser.Button(Find.ById("ctl00_ContentPlaceHolderActions_uxNext")).Click();
            System.Threading.Thread.Sleep(5000);
            if (browser.Div(Find.ByClass("sidebar")).Images[0].Src.Contains("04") == false)
            {
                Assert.IsTrue(false);
                return;
            }
            browser.TextField(Find.ById("ctl00_ContentPlaceHolderMain_uxSesurityNumber")).TypeText("123456789");
            browser.Button(Find.ById("ctl00_ContentPlaceHolderActions_uxNext")).Click();
            System.Threading.Thread.Sleep(5000);
            if (browser.Div(Find.ByClass("sidebar")).Images[0].Src.Contains("05") == false)
            {
                Assert.IsTrue(false);
                return;
            }
            browser.Div(Find.ById("ctl00_ContentPlaceHolderMain_uxEmployeeStatus_DropDown")).SelectList(Find.ByClass("rcbList")).Option(Find.ByText("Student")).Select();
            browser.Button(Find.ById("ctl00_ContentPlaceHolderActions_uxNext")).Click();
            System.Threading.Thread.Sleep(5000);
            if (browser.Div(Find.ByClass("sidebar")).Images[0].Src.Contains("06") == false)
            {
                Assert.IsTrue(false);
                return;
            }
            browser.Div(Find.ById("ctl00_ContentPlaceHolderMain_uxAnnualIncome_DropDown")).SelectList(Find.ByClass("rcbList")).Option(Find.ByText("$24,999 or less")).Select();
            browser.Div(Find.ById("ctl00_ContentPlaceHolderMain_uxNetWorth_DropDown")).SelectList(Find.ByClass("rcbList")).Option(Find.ByText("$24,999 or less")).Select();
            browser.Div(Find.ById("ctl00_ContentPlaceHolderMain_uxLiquidNetWorth_DropDown")).SelectList(Find.ByClass("rcbList")).Option(Find.ByText("$24,999 or less")).Select();
            browser.Div(Find.ById("ctl00_ContentPlaceHolderMain_uxIncomeSource_DropDown")).SelectList(Find.ByClass("rcbList")).Option(Find.ByText("Other")).Select();
            browser.Div(Find.ById("ctl00_ContentPlaceHolderMain_uxExpTradingStocks_DropDown")).SelectList(Find.ByClass("rcbList")).Option(Find.ByText("2 years")).Select();
            browser.Div(Find.ById("ctl00_ContentPlaceHolderMain_uxExpTradingMultFunds_DropDown")).SelectList(Find.ByClass("rcbList")).Option(Find.ByText("2 years")).Select();
            browser.Table(Find.ById("ctl00_ContentPlaceHolderMain_uxInvestmentObjectiveList")).
                TableBodies[0].TableRows[0].TableCells[0].RadioButton(Find.ById("investmentObjective")).Checked = true;
            browser.Button(Find.ById("ctl00_ContentPlaceHolderActions_uxNext")).Click();
            System.Threading.Thread.Sleep(5000);
            if (browser.Div(Find.ByClass("sidebar")).Images[0].Src.Contains("07") == false)
            {
                Assert.IsTrue(false);
                return;
            }
            browser.Div(Find.ById("ctl00_ContentPlaceHolderMain_uxOptionsLevelRequest_DropDown")).SelectList(Find.ByClass("rcbList")).Option(Find.ByText("Level 1")).Select();
            browser.Div(Find.ById("ctl00_ContentPlaceHolderMain_uxExperienceTradingLevel1_DropDown")).SelectList(Find.ByClass("rcbList")).Option(Find.ByText("1")).Select();
            browser.Div(Find.ById("ctl00_ContentPlaceHolderMain_uxExperienceTradingLevel2_DropDown")).SelectList(Find.ByClass("rcbList")).Option(Find.ByText("1")).Select();
            browser.Div(Find.ById("ctl00_ContentPlaceHolderMain_uxExperienceTradingLevel3_DropDown")).SelectList(Find.ByClass("rcbList")).Option(Find.ByText("1")).Select();
            browser.Div(Find.ById("ctl00_ContentPlaceHolderMain_uxExperienceTradingLevel4_DropDown")).SelectList(Find.ByClass("rcbList")).Option(Find.ByText("1")).Select();
            browser.Button(Find.ById("ctl00_ContentPlaceHolderActions_uxNext")).Click();
            System.Threading.Thread.Sleep(5000);
            if (browser.Div(Find.ByClass("sidebar")).Images[0].Src.Contains("08") == false)
            {
                Assert.IsTrue(false);
                return;
            }
            browser.Button(Find.ById("ctl00_ContentPlaceHolderActions_uxNext")).Click();
            System.Threading.Thread.Sleep(5000);
            if (browser.Div(Find.ByClass("sidebar")).Images[0].Src.Contains("09") == false)
            {
                Assert.IsTrue(false);
                return;
            }
            browser.CheckBox(Find.ById("ctl00_ContentPlaceHolderMain_uxAccountAgreement")).Checked = true;
            browser.CheckBox(Find.ById("ctl00_ContentPlaceHolderMain_uxMarginAgreement")).Checked = true;
            browser.CheckBox(Find.ById("ctl00_ContentPlaceHolderMain_uxOptionsAgreement")).Checked = true;
            browser.Button(Find.ById("ctl00_ContentPlaceHolderActions_uxNext")).Click();
            System.Threading.Thread.Sleep(5000);
            if (browser.Div(Find.ByClass("sidebar")).Images[0].Src.Contains("10") == false)
            {
                Assert.IsTrue(false);
                return;
            }
            browser.TextField(Find.ById("ctl00_ContentPlaceHolderMain_uxFirstName")).TypeText("zhuojun");
            browser.TextField(Find.ById("ctl00_ContentPlaceHolderMain_uxLastName")).TypeText("zhuang");
            browser.TextField(Find.ById("ctl00_ContentPlaceHolderMain_uxDate_dateInput_text")).TypeText(Date2);
        }

        [Test]
        public void T02_OLA_ContinueSavedApp()
        {
            TestUserSignInFromSignUp(UN1, PW1, false);
            System.Threading.Thread.Sleep(5000);
            browser.Frame(Find.ByName("uxLoadSavedAppsConfirmDialog")).Button(Find.ById("ctl00_DialogPlaceHolder_uxYesButton")).Click();
            System.Threading.Thread.Sleep(5000);
            Assert.IsTrue(browser.Frame(Find.ByName("uxSavedAppsWindow")).Table(Find.ById("ctl00_DialogPlaceHolder_uxSavedApplicationsGrid_ctl00")).Exists);
        }
    }
}
