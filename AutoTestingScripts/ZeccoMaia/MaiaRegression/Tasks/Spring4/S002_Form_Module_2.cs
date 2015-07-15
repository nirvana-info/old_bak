using System;
using System.Collections.Generic;
using System.Text;
using NUnit.Framework;
using WatiN.Core;
using WatiN.Core.Interfaces;
using WatiN.Core.DialogHandlers;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks.Spring4
{
    [TestFixture]
    public class S002_Form_Module_2 : SignIn
    {
        [Test]
        public void T01_Form_HoldingPrivacyPolicy()
        {
            this.GotoFormDisclosuresPage();
            string u16 = browser.Link(Find.ById("uxPolicyDownload")).Url;
            Assert.AreEqual(URL + "/Forms/Privacy Policy/DownloadForm.aspx", u16);
            browser.Link(Find.ById("uxPolicyDownload")).Click();
        }

        [Test]
        public void T02_Form_TermsService()
        {
            this.GotoFormDisclosuresPage();
            string u16 = browser.Link(Find.ById("uxServiceDownload")).Url;
            Assert.AreEqual(URL + "/forms/terms-of-service/DownloadForm.aspx", u16);
            browser.Link(Find.ById("uxServiceDownload")).Click();
        }

        [Test]
        public void T03_Form_TradingPrivacyPolicy()
        {
            this.GotoFormDisclosuresPage();
            string u16 = browser.Link(Find.ById("uxPolicyDownload1")).Url;
            Assert.AreEqual(URL + "/forms/trading-privacy-policy/DownloadForm.aspx", u16);
            browser.Link(Find.ById("uxPolicyDownload1")).Click();
        }

        [Test]
        public void T04_Form_UserAgreement()
        {
            this.GotoFormDisclosuresPage();
            string u16 = browser.Link(Find.ById("uxUserAgreementDownload")).Url;
            Assert.AreEqual(URL + "/forms/user-agreement/DownloadForm.aspx", u16);
            browser.Link(Find.ById("uxUserAgreementDownload")).Click();
        }

        [Test]
        public void T05_Form_BusinessContinuityStatement()
        {
            this.GotoFormDisclosuresPage();
            string u16 = browser.Link(Find.ById("uxBusinessContinuityStatementDownload")).Url;
            Assert.AreEqual(URL + "/forms/business-continuity-statement/DownloadForm.aspx", u16);
            browser.Link(Find.ById("uxBusinessContinuityStatementDownload")).Click();
        }

        [Test]
        public void T06_Form_AccountProtectionDisclosure()
        {
            this.GotoFormDisclosuresPage();
            string u16 = browser.Link(Find.ById("uxAccountProtectionDisclosureDownload")).Url;
            Assert.AreEqual(URL + "/forms/account-protection/DownloadForm.aspx", u16);
            browser.Link(Find.ById("uxAccountProtectionDisclosureDownload")).Click();
        }

        [Test]
        public void T07_Form_Statement()
        {
            this.GotoFormDisclosuresPage();
            string u16 = browser.Link(Find.ById("uxStatementDownload")).Url;
            Assert.AreEqual(URL + "/forms/statement-of-financial-condition/DownloadForm.aspx", u16);
            browser.Link(Find.ById("uxStatementDownload")).Click();
        }

        [Test]
        public void T08_Form_CustomerAgreement()
        {
            this.GotoFormDisclosuresPage();
            string u16 = browser.Link(Find.ById("uxCustomerAgreementDownload")).Url;
            Assert.AreEqual(URL + "/forms/customer-agreement/DownloadForm.aspx", u16);
            browser.Link(Find.ById("uxCustomerAgreementDownload")).Click();
        }

        [Test]
        public void T09_Form_AccountAgreementSupplement()
        {
            this.GotoFormDisclosuresPage();
            string u16 = browser.Link(Find.ById("uxAccountAgreementSupplementDownload")).Url;
            Assert.AreEqual(URL + "/forms/account-agreement-supplement/DownloadForm.aspx", u16);
            browser.Link(Find.ById("uxAccountAgreementSupplementDownload")).Click();
        }

        [Test]
        public void T10_Form_CustomerIdentificationProgramNotice()
        {
            this.GotoFormDisclosuresPage();
            string u16 = browser.Link(Find.ById("uxCustomerIdentificationProgramNoticeDownload")).Url;
            Assert.AreEqual(URL + "/forms/customer-identification-program/DownloadForm.aspx", u16);
            browser.Link(Find.ById("uxCustomerIdentificationProgramNoticeDownload")).Click();
        }

        [Test]
        public void T11_Form_ElectronicDelivery_andSignature()
        {
            this.GotoFormDisclosuresPage();
            string u16 = browser.Link(Find.ById("uxElectronicDelivery_andSignatureDownload")).Url;
            Assert.AreEqual(URL + "/forms/electronic-signature-and-delivery/DownloadForm.aspx", u16);
            browser.Link(Find.ById("uxElectronicDelivery_andSignatureDownload")).Click();
        }

        [Test]
        public void T12_Form_Electronic_Trading()
        {
            this.GotoFormDisclosuresPage();
            string u16 = browser.Link(Find.ById("uxElectronic_TradingDownload")).Url;
            Assert.AreEqual(URL + "/forms/electronic-trading/DownloadForm.aspx", u16);
            browser.Link(Find.ById("uxElectronic_TradingDownload")).Click();
        }

        [Test]
        public void T13_Form_InternationalUse()
        {
            this.GotoFormDisclosuresPage();
            string u16 = browser.Link(Find.ById("uxInternationalUseDownload")).Url;
            Assert.AreEqual(URL + "/forms/international-use/DownloadForm.aspx", u16);
            browser.Link(Find.ById("uxInternationalUseDownload")).Click();
        }

        [Test]
        public void T18_Form_DayTradingRiskDisclosureStatement()
        {
            this.GotoFormDisclosuresPage();
            string u16 = browser.Link(Find.ById("uxDayTradingRiskDisclosureStatementDownload")).Url;
            Assert.AreEqual(URL + "/forms/day-trading-risk-disclosure/DownloadForm.aspx", u16);
            browser.Link(Find.ById("uxDayTradingRiskDisclosureStatementDownload")).Click();
        }

        [Test]
        public void T19_Form_MarketVolatilityDisclosure()
        {
            this.GotoFormDisclosuresPage();
            string u16 = browser.Link(Find.ById("uxMarketVolatilityDisclosureDownload")).Url;
            Assert.AreEqual(URL + "/forms/market-volatility/DownloadForm.aspx", u16);
            browser.Link(Find.ById("uxMarketVolatilityDisclosureDownload")).Click();
        }

        [Test]
        public void T20_Form_PennyStockDisclosure()
        {
            this.GotoFormDisclosuresPage();
            string u16 = browser.Link(Find.ById("uxPennyStockDisclosureDownload")).Url;
            Assert.AreEqual(URL + "/forms/penny-stock-disclosure/DownloadForm.aspx", u16);
            browser.Link(Find.ById("uxPennyStockDisclosureDownload")).Click();
        }

        [Test]
        public void T21_Form_ZeccoTradingOptionAgreement()
        {
            this.GotoFormDisclosuresPage();
            string u16 = browser.Link(Find.ById("uxZeccoTradingOptionAgreementDownload")).Url;
            Assert.AreEqual(URL + "/forms/options-agreement-and-disclosure/DownloadForm.aspx", u16);
            browser.Link(Find.ById("uxZeccoTradingOptionAgreementDownload")).Click();
        }

        [Test]
        public void T22_Form_CharacteristicsandRisksofStandardizedOptions()
        {
            this.GotoFormDisclosuresPage();
            string u16 = browser.Link(Find.ById("uxCharacteristicsandRisksofStandardizedOptionsDownload")).Url;
            Assert.AreEqual(URL + "/forms/riskstoc/DownloadForm.aspx", u16);
            browser.Link(Find.ById("uxCharacteristicsandRisksofStandardizedOptionsDownload")).Click();
        }

        [Test]
        public void T23_Form_StandardizedOptions()
        {
            this.GotoFormDisclosuresPage();
            string u16 = browser.Link(Find.ById("uxStandardizedOptionsDownload")).Url;
            Assert.AreEqual(URL + "/forms/december-2009-ODD-definitive-supplement/DownloadForm.aspx", u16);
            browser.Link(Find.ById("uxStandardizedOptionsDownload")).Click();
        }

        [Test]
        public void T24_Form_SpreadTradingDisclosure()
        {
            this.GotoFormDisclosuresPage();
            string u16 = browser.Link(Find.ById("uxSpreadTradingDisclosureDownload")).Url;
            Assert.AreEqual(URL + "/forms/spread-trading-disclosure/DownloadForm.aspx", u16);
            browser.Link(Find.ById("uxSpreadTradingDisclosureDownload")).Click();
        }

        [Test]
        public void T25_Form_UncoveredOptionsDisclosure()
        {
            this.GotoFormDisclosuresPage();
            string u16 = browser.Link(Find.ById("uxUncoveredOptionsDisclosureDownload")).Url;
            Assert.AreEqual(URL + "/forms/uncovered-option-writing/DownloadForm.aspx", u16);
            browser.Link(Find.ById("uxUncoveredOptionsDisclosureDownload")).Click();
        }

        [Test]
        public void T26_Form_MarginAccountDisclosure()
        {
            this.GotoFormDisclosuresPage();
            string u16 = browser.Link(Find.ById("uxMarginAccountDisclosureDownload")).Url;
            Assert.AreEqual(URL + "/forms/zecco-trading-margin-account-disclosure/DownloadForm.aspx", u16);
            browser.Link(Find.ById("uxMarginAccountDisclosureDownload")).Click();
        }

        [Test]
        public void T27_Form_PensonCustomerInformationBrochure()
        {
            this.GotoFormDisclosuresPage();
            string u16 = browser.Link(Find.ById("uxPensonCustomerInformationBrochureDownload")).Url;
            Assert.AreEqual(URL + "/forms/penson-execution-and-clearing-functions/DownloadForm.aspx", u16);
            browser.Link(Find.ById("uxPensonCustomerInformationBrochureDownload")).Click();
        }

        [Test]
        public void T28_Form_Rule606Disclosure()
        {
            this.GotoFormDisclosuresPage();
            string u16 = browser.Link(Find.ById("uxRule606DisclosureDownload")).Url;
            Assert.AreEqual(URL + "/forms/order-execution-and-routing-practices-SEC-rule-606/DownloadForm.aspx", u16);
            browser.Link(Find.ById("uxRule606DisclosureDownload")).Click();
        }

        private void GotoFormDisclosuresPage()
        {
            UserSignIn(UN, PW, false, 0);
            browser.Link(Find.ById("uxAccountCenter")).WaitUntilExists(10);
            browser.Link(Find.ById("uxAccountCenter")).Click();
            browser.WaitForComplete();
            //left view all form buttom
            browser.Link(Find.ByText("View all forms")).Click();
            browser.Link(Find.ById("uxMarginApplicationHelp")).WaitUntilExists(10);
            browser.Link(Find.ById("uxMarginApplicationHelp")).Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDisclosuresPage")).WaitUntilExists(10);
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxRightColumn_uxDisclosuresPage")).Click();
            browser.WaitForComplete();
        }
    }
}
