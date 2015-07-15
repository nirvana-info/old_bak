using System.Collections.Generic;
using System.Text;
using WatiN.Core;
using NUnit.Framework;
using MaiaRegression.Appobjects;
using MaiaRegression.Appobjects.App01_HomePage;

namespace MaiaRegression.Tasks.Spring7
{
    [TestFixture]
    public class S002_CRMCase_Module : MessageCenter
    {
        [Test]
        public void T01_CRMCase_CreateMessage()
        {
            ComposeSupportMessage("ddpg1");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSendMail")).Click();
        }

        [Test]
        public void T02_CRMCase_UpdateMessage()
        {
            UserSignIn(UN, PW, false, 0);
            System.Threading.Thread.Sleep(120000);
            browser.Link(Find.ById("uxMessages")).WaitUntilExists(20);
            browser.Link(Find.ById("uxMessages")).Click();
            browser.Link(Find.ByText("Sent")).Click();
            //browser.Div(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxRadTabStripDisplayMessage")).Links[1].Click();
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxMailListView_ctrl0_uxSubject")).WaitUntilExists(10);
            browser.Link(Find.ById("ctl00_ctl00_uxMainContent_uxMainColumn_uxMailListView_ctrl0_uxSubject")).Click();
            browser.WaitForComplete();
            browser.TextField(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxMessage")).TypeText("ddpg2");
            browser.Button(Find.ById("ctl00_ctl00_uxMainContent_uxMiddleColumn_uxSendMail")).Click();
        }
    }
}
