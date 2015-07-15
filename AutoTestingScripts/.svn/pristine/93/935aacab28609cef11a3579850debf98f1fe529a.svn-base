using System;
using System.Collections.Generic;
using System.Text;
using WatiN.Core;
using NUnit.Framework;
using WatiN.Core.Exceptions;


namespace SalesLantern
{

    [TestFixture]
    public class Program : TestBase
    {

        [Test]
        public void placeConsumerOrderCRMExp()
        {
            //Main Page
           
            ie.GoTo("http://www.usadatacrmexpress.com/Home.aspx");
            
            ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$imgGetStarted")).Click();

            //Lead Type
            ie.RadioButton(Find.ByName("ctl00$ContentPlaceHolder1$dataSource")).Checked = true;
            ie.Span(Find.By("innertext", "Next")).Click();


            //Select Geography
            ie.RadioButton(Find.ById("ctl00_ContentPlaceHolder1_RBLGeoType_3")).Checked = true;
            ie.Span(Find.By("innertext", "Next")).Click();
            ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$lbState")).SelectByValue("AK");
            ie.WaitForComplete();
            ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$lbCounties")).Click();

            ie.Image(Find.BySrc("http://www.usadatacrmexpress.com/Images/Add.jpg")).Click();

            ie.Link(Find.ByUrl("javascript:__doPostBack('ctl00$ContentPlaceHolder1$BottomBtNext','')")).Click();

            //Select Demographics


  
            ie.Image(Find.ById("ctl00_ContentPlaceHolder1_btAddDem")).ClickNoWait();
            ie.Div(Find.ById("ctl00_ContentPlaceHolder1_PanButton")).Image(Find.ById("ctl00_ContentPlaceHolder1_btAddDem")).Click();
         


         
        }
    }
}