using NUnit.Framework;
using WatiN.Core;
using System.Text.RegularExpressions;
using System;
using System.Threading;




namespace SalesLantern
{

    [TestFixture]

    public class Check01_RegisterUser_OrderLeads:TestBase

    {
        String URL = "http://192.168.0.20:9000";
        String Date = DateTime.Today.ToShortDateString();


        [Test]

        public void Check01_01_Login()
        {
            ie.GoTo(URL);
            ie.Image(Find.ByName("imgGetStarted")).Click();
            ie.Link(Find.ById("ctl00_lbLogin")).WaitUntilExists(120);
            ie.Link(Find.ById("ctl00_lbLogin")).Click();
            ie.Image(Find.ById("myImg")).WaitUntilExists(120);
            ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$tbEmail")).TypeText("christie.duan@nirvana-info.com");
            ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$tbPwd")).TypeText("123456");
            ie.Button(Find.ByName("ctl00$ContentPlaceHolder1$btOk")).Click();
            Assert.IsTrue(ie.ContainsText("Welcome to CRMExpress"));
        }


         [Test]
        public void Check01_02_OrderConsumerLeads_IndividualZipCodes()
           {
               ie.Link(Find.ById("aMainMenu0")).Click();
               ie.Label(Find.ByText("Consumer Leads")).WaitUntilExists(120); 
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$TopBtNext")).Click();
               ie.Label(Find.ByText("Enter Individual Zip Codes(up to 25)")).WaitUntilExists(120);
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$TopBtNext")).Click();
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$TextBox1")).WaitUntilExists(120);
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$TextBox1")).TypeText("53207");
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$TextBox2")).TypeText("53208");
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$TextBox3")).TypeText("53209");
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$TextBox4")).TypeText("53210");
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$TextBox5")).TypeText("53211");
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$TextBox6")).TypeText("53212");
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$TextBox7")).TypeText("53213");
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$TopBtNext")).Click();
               ie.TableCell(Find.ByText("Demographics")).WaitUntilExists(120);
            

               //Demographics selection
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$btAddDem")).Click();

               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$ltbDemCat")).Option("Estimated Income - Narrow Ranges").Select();
               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$ltbDemVar")).Option("Under $15,000").WaitUntilExists(120);
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$btAddDem")).Click();

               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$ltbDemCat")).Option("Dwelling Unit Size").Select();
               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$ltbDemVar")).Option("Multi Family Dwelling Unit").WaitUntilExists(120);
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$btAddDem")).Click();

               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$ltbDemCat")).Option("Gender (Individual)").Select();
               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$ltbDemVar")).Option("Unknown").WaitUntilExists(120);
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$btAddDem")).Click();

               //Get count
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$TopBtNext")).Click();
               ie.TableCell(Find.ByText("List Price")).WaitUntilExists(120);
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$TopBtNext")).Click();

               // Agree Terms
               ie.Label(Find.ByText("I have read and agree to the terms and conditions above.")).WaitUntilExists(120);
               ie.CheckBox(Find.ByName("ctl00$ContentPlaceHolder1$chbAgreement")).Checked = true;
               ie.GoTo(URL + "/OC/OrderPaymentInfo.aspx");

               //Payment Information
               ie.Link(Find.ByText("Order Details")).WaitUntilExists(120);
               ie.CheckBox(Find.ByName("ctl00$ContentPlaceHolder1$chb_contactinfo")).Checked = true;
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_user_firstname")).TypeText("Tester");
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_user_addr")).TypeText("Test");
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_user_city")).TypeText("ADONA");
               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$dl_user_state")).Option("Alaska").Select();
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_user_zip")).TypeText("11111");
               ie.TextField(Find.ById("igtxtctl00_ContentPlaceHolder1_txt_user_phone")).Value= "(123) 111-1111";
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_user_email")).TypeText("christie.duan@nirvana-info.com");
               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$dl_pay_cardtype")).Option("American Express").Select();
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_pay_cardname")).TypeText("Test");
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_pay_account")).TypeText("3782822463100055");
               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$dl_pay_month")).Option("09").Select();
               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$dl_pay_year")).Option("2010").Select();

               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_order_description")).TypeText("ConsumerLeads_IndividualZip" + Date);
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$BottomBtNext")).Click();
               //ie.Div(Find.ById("MyOrderMain")).WaitUntilExists(120);
               ie.Span(Find.ById("ctl00_ContentPlaceHolder1_lbOrderNo")).WaitUntilExists(120);
               Assert.IsTrue(ie.Div(Find.ByText("Your Order Is Complete!")).Exists);
              // Assert.IsTrue(ie.ContainsText("Your Order Is Complete!"));
            
               }

        
           [Test]
        public void Check01_03_OrderConsumerLeads_ChooseCities()
           {
               ie.GoTo(URL + "/OC/OrderSelectGeoType.aspx");
               ie.RadioButton(Find.ById("ctl00_ContentPlaceHolder1_RBLGeoType_2")).Checked = true;
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$BottomBtNext")).Click();
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$btLoadCount")).WaitUntilRemoved(120);
               ie.Image(Find.BySrc(URL+"/Images/Add.jpg")).Click();
               ie.SelectList(Find.ById("ctl00_ContentPlaceHolder1_lstCities")).Option("Akiachak").Select();
               ie.Image(Find.BySrc(URL + "/Images/Add.jpg")).Click();
               ie.SelectList(Find.ById("ctl00_ContentPlaceHolder1_lstCities")).Option("Akiak").Select();
               ie.Image(Find.BySrc(URL+"/Images/Add.jpg")).Click();
               ie.SelectList(Find.ById("ctl00_ContentPlaceHolder1_lstCities")).Option("Akutan").Select();
               ie.Image(Find.BySrc(URL+"/Images/Add.jpg")).Click(); 
               ie.SelectList(Find.ById("ctl00_ContentPlaceHolder1_lstCities")).Option("Alakanuk").Select();
               ie.Image(Find.BySrc(URL + "/Images/Add.jpg")).Click();
               ie.SelectList(Find.ById("ctl00_ContentPlaceHolder1_lstCities")).Option("Aleknagik").Select();
               ie.Image(Find.BySrc(URL + "/Images/Add.jpg")).Click();
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$BottomBtNext")).Click();

               //Demographics
               ie.TableCell(Find.ByText("Demographics")).WaitUntilExists(120);
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$btAddDem")).Click();

               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$ltbDemCat")).Option("Estimated Income - Narrow Ranges").Select();
               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$ltbDemVar")).Option("Under $15,000").WaitUntilExists(120);
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$btAddDem")).Click();

               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$ltbDemCat")).Option("Dwelling Unit Size").Select();
               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$ltbDemVar")).Option("Multi Family Dwelling Unit").WaitUntilExists(120);
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$btAddDem")).Click();

               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$ltbDemCat")).Option("Gender (Individual)").Select();
               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$ltbDemVar")).Option("Unknown").WaitUntilExists(120);
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$btAddDem")).Click();

               //Get count
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$TopBtNext")).Click();
               ie.TableCell(Find.ByText("List Price")).WaitUntilExists(120);
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$TopBtNext")).Click();

                // Agree Terms
               ie.Label(Find.ByText("I have read and agree to the terms and conditions above.")).WaitUntilExists(120);
               ie.CheckBox(Find.ByName("ctl00$ContentPlaceHolder1$chbAgreement")).Checked = true;
               ie.GoTo(URL + "/OC/OrderPaymentInfo.aspx");

               //Payment Information
               ie.Link(Find.ByText("Order Details")).WaitUntilExists(120);
               ie.CheckBox(Find.ByName("ctl00$ContentPlaceHolder1$chb_contactinfo")).Checked = true;
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_user_firstname")).TypeText("Tester");
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_user_addr")).TypeText("Test");
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_user_city")).TypeText("ADONA");
               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$dl_user_state")).Option("Alaska").Select();
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_user_zip")).TypeText("11111");
              // ie.TextField(Find.ById("igtxtctl00_ContentPlaceHolder1_txt_user_phone")).Value= "(123) 111-1111";
               ie.TextField(Find.ById("igtxtctl00_ContentPlaceHolder1_txt_user_phone")).TypeText("1231111111");
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_user_email")).TypeText("christie.duan@nirvana-info.com");
               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$dl_pay_cardtype")).Option("American Express").Select();
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_pay_cardname")).TypeText("Test");
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_pay_account")).TypeText("3782822463100055");
               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$dl_pay_month")).Option("09").Select();
               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$dl_pay_year")).Option("2010").Select();

               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_order_description")).TypeText("ConsumerLeads_ChooseCities" + Date);
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$BottomBtNext")).Click();
               ie.Div(Find.ById("MyOrderMain")).WaitUntilExists(120);
               Assert.IsTrue(ie.ContainsText("Your Order Is Complete!"));
            
               }

           [Test]
        public void Check01_04_OrderConsumerLeads_ChooseCounties()
           {
               ie.GoTo(URL + "/OC/OrderSelectGeoType.aspx");
               ie.RadioButton(Find.ById("ctl00_ContentPlaceHolder1_RBLGeoType_3")).Checked = true;
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$BottomBtNext")).Click();
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$btLoadCount")).WaitUntilRemoved(120);

               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$ImageButton1")).Click();
               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$lbCounties")).Option("Aleutians West").Select();
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$ImageButton1")).Click();
               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$lbCounties")).Option("Anchorage").Select();
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$ImageButton1")).Click();
               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$lbCounties")).Option("Bethel").Select();
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$ImageButton1")).Click();
               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$lbCounties")).Option("Denali").Select();
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$ImageButton1")).Click();
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$BottomBtNext")).Click();

               //Demographics
               ie.TableCell(Find.ByText("Demographics")).WaitUntilExists(120);
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$btAddDem")).Click();

               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$ltbDemCat")).Option("Estimated Income - Narrow Ranges").Select();
               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$ltbDemVar")).Option("Under $15,000").WaitUntilExists(120);
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$btAddDem")).Click();

               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$ltbDemCat")).Option("Dwelling Unit Size").Select();
               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$ltbDemVar")).Option("Multi Family Dwelling Unit").WaitUntilExists(120);
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$btAddDem")).Click();

               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$ltbDemCat")).Option("Gender (Individual)").Select();
               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$ltbDemVar")).Option("Unknown").WaitUntilExists(120);
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$btAddDem")).Click();

               //Get count
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$TopBtNext")).Click();
               ie.TableCell(Find.ByText("List Price")).WaitUntilExists(120);
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$TopBtNext")).Click();

               // Agree Terms
               ie.Label(Find.ByText("I have read and agree to the terms and conditions above.")).WaitUntilExists(120);
               ie.CheckBox(Find.ByName("ctl00$ContentPlaceHolder1$chbAgreement")).Checked = true;
               ie.GoTo(URL + "/OC/OrderPaymentInfo.aspx");

               //Payment Information
               ie.Link(Find.ByText("Order Details")).WaitUntilExists(120);
               ie.CheckBox(Find.ByName("ctl00$ContentPlaceHolder1$chb_contactinfo")).Checked = true;
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_user_firstname")).TypeText("Tester");
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_user_addr")).TypeText("Test");
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_user_city")).TypeText("ADONA");
               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$dl_user_state")).Option("Alaska").Select();
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_user_zip")).TypeText("11111");
               ie.TextField(Find.ById("igtxtctl00_ContentPlaceHolder1_txt_user_phone")).Value = "(123) 111-1111";
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_user_email")).TypeText("christie.duan@nirvana-info.com");
               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$dl_pay_cardtype")).Option("American Express").Select();
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_pay_cardname")).TypeText("Test");
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_pay_account")).TypeText("3782822463100055");
               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$dl_pay_month")).Option("09").Select();
               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$dl_pay_year")).Option("2010").Select();

               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_order_description")).TypeText("ConsumerLeads_ChooseCounties" + Date);
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$BottomBtNext")).Click();
               ie.Div(Find.ById("MyOrderMain")).WaitUntilExists(120);
               Assert.IsTrue(ie.ContainsText("Your Order Is Complete!"));

           }

           [Test]
        public void Check01_05_OrderConsumerLeads_ChooseStates()
           {
               ie.GoTo(URL + "/OC/OrderSelectGeoType.aspx");
               ie.RadioButton(Find.ById("ctl00_ContentPlaceHolder1_RBLGeoType_4")).Checked = true;
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$BottomBtNext")).Click();
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$btLoadCount")).WaitUntilRemoved(120);
         
               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$lbState")).Option("Arkansas").Select();
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$btSelect")).Click();
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$BottomBtNext")).Click();

               //Demographics
               ie.TableCell(Find.ByText("Demographics")).WaitUntilExists(120);
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$btAddDem")).Click();

               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$ltbDemCat")).Option("Estimated Income - Narrow Ranges").Select();
               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$ltbDemVar")).Option("Under $15,000").WaitUntilExists(120);
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$btAddDem")).Click();

               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$ltbDemCat")).Option("Dwelling Unit Size").Select();
               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$ltbDemVar")).Option("Multi Family Dwelling Unit").WaitUntilExists(120);
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$btAddDem")).Click();

               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$ltbDemCat")).Option("Gender (Individual)").Select();
               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$ltbDemVar")).Option("Unknown").WaitUntilExists(120);
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$btAddDem")).Click();

               //Get count
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$TopBtNext")).Click();
               ie.TableCell(Find.ByText("List Price")).WaitUntilExists(120);
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$TopBtNext")).Click();

               // Agree Terms
               ie.Label(Find.ByText("I have read and agree to the terms and conditions above.")).WaitUntilExists(120);
               ie.CheckBox(Find.ByName("ctl00$ContentPlaceHolder1$chbAgreement")).Checked = true;
               ie.GoTo(URL + "/OC/OrderPaymentInfo.aspx");

               //Payment Information
               ie.Link(Find.ByText("Order Details")).WaitUntilExists(120);
               ie.CheckBox(Find.ByName("ctl00$ContentPlaceHolder1$chb_contactinfo")).Checked = true;
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_user_firstname")).TypeText("Tester");
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_user_addr")).TypeText("Test");
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_user_city")).TypeText("ADONA");
               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$dl_user_state")).Option("Alaska").Select();
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_user_zip")).TypeText("11111");
               ie.TextField(Find.ById("igtxtctl00_ContentPlaceHolder1_txt_user_phone")).Value = "(123) 111-1111";
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_user_email")).TypeText("christie.duan@nirvana-info.com");
               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$dl_pay_cardtype")).Option("American Express").Select();
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_pay_cardname")).TypeText("Test");
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_pay_account")).TypeText("3782822463100055");
               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$dl_pay_month")).Option("09").Select();
               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$dl_pay_year")).Option("2010").Select();

               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_order_description")).TypeText("ConsumerLeads_ChooseStates" + Date);
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$BottomBtNext")).Click();
               ie.Div(Find.ById("MyOrderMain")).WaitUntilExists(120);
               Assert.IsTrue(ie.ContainsText("Your Order Is Complete!"));
            
           }

           [Test]
        public void Check01_06_OrderConsumerLeads_SCFCodes()
           {
               ie.GoTo(URL + "/OC/OrderSelectGeoType.aspx");
               ie.RadioButton(Find.ById("ctl00_ContentPlaceHolder1_RBLGeoType_5")).Checked = true;
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$BottomBtNext")).Click();
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$btLoadCount")).WaitUntilRemoved(120);

               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$TextBox1")).TypeText("532");
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$TextBox2")).TypeText("381");
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$BottomBtNext")).Click();

               //Demographics
               ie.TableCell(Find.ByText("Demographics")).WaitUntilExists(120);
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$btAddDem")).Click();

               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$ltbDemCat")).Option("Estimated Income - Narrow Ranges").Select();
               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$ltbDemVar")).Option("Under $15,000").WaitUntilExists(120);
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$btAddDem")).Click();

               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$ltbDemCat")).Option("Gender (Individual)").Select();
               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$ltbDemVar")).Option("Unknown").WaitUntilExists(120);
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$btAddDem")).Click();

               //Get count
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$TopBtNext")).Click();
               ie.TableCell(Find.ByText("List Price")).WaitUntilExists(120);
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$TopBtNext")).Click();

               // Agree Terms
               ie.Label(Find.ByText("I have read and agree to the terms and conditions above.")).WaitUntilExists(120);
               ie.CheckBox(Find.ByName("ctl00$ContentPlaceHolder1$chbAgreement")).Checked = true;
               ie.GoTo(URL + "/OC/OrderPaymentInfo.aspx");

               //Payment Information
               ie.Link(Find.ByText("Order Details")).WaitUntilExists(120);
               ie.CheckBox(Find.ByName("ctl00$ContentPlaceHolder1$chb_contactinfo")).Checked = true;
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_user_firstname")).TypeText("Tester");
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_user_addr")).TypeText("Test");
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_user_city")).TypeText("ADONA");
               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$dl_user_state")).Option("Alaska").Select();
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_user_zip")).TypeText("11111");
               ie.TextField(Find.ById("igtxtctl00_ContentPlaceHolder1_txt_user_phone")).Value = "(123) 111-1111";
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_user_email")).TypeText("christie.duan@nirvana-info.com");
               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$dl_pay_cardtype")).Option("American Express").Select();
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_pay_cardname")).TypeText("Test");
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_pay_account")).TypeText("3782822463100055");
               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$dl_pay_month")).Option("09").Select();
               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$dl_pay_year")).Option("2010").Select();

               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_order_description")).TypeText("ConsumerLeads_SCFCode" + Date);
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$BottomBtNext")).Click();
               ie.Div(Find.ById("MyOrderMain")).WaitUntilExists(120);
               Assert.IsTrue(ie.ContainsText("Your Order Is Complete!"));


           }



           [Test]
        public void Check01_07_OrderBusinessLeads_MapAddress()
           {
               ie.GoTo(URL + "/OC/OrderSelectDataSource.aspx");
               ie.RadioButton(Find.ById("ctl00_ContentPlaceHolder1_rb2")).Checked = true;
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$IbtNext")).Click();


               ie.RadioButton(Find.ById("ctl00_ContentPlaceHolder1_RBLGeoType_1")).Checked = true;
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$BottomBtNext")).Click();
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$btLoadCount")).WaitUntilRemoved(120);

               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$tbAddr")).TypeText("Newyork");
               ie.TextField(Find.ById("igtxtctl00_ContentPlaceHolder1_tbRadius")).TypeText("0.5");

               ie.Button(Find.ById("ctl00_ContentPlaceHolder1_btSearch")).Click();



               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$TopBtNext")).Click();

               //Demographics
               ie.TableCell(Find.ByText("Demographics")).WaitUntilExists(120);
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$btAddDem")).Click();

               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$ltbDemCat")).Option("Estimated Income - Narrow Ranges").Select();
               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$ltbDemVar")).Option("Under $15,000").WaitUntilExists(120);
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$btAddDem")).Click();

               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$ltbDemCat")).Option("Gender (Individual)").Select();
               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$ltbDemVar")).Option("Unknown").WaitUntilExists(120);
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$btAddDem")).Click();

               //Get count
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$TopBtNext")).Click();
               ie.TableCell(Find.ByText("List Price")).WaitUntilExists(120);
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$TopBtNext")).Click();

               // Agree Terms
               ie.Label(Find.ByText("I have read and agree to the terms and conditions above.")).WaitUntilExists(120);
               ie.CheckBox(Find.ByName("ctl00$ContentPlaceHolder1$chbAgreement")).Checked = true;
               ie.GoTo(URL + "/OC/OrderPaymentInfo.aspx");

               //Payment Information
               ie.Link(Find.ByText("Order Details")).WaitUntilExists(120);
               ie.CheckBox(Find.ByName("ctl00$ContentPlaceHolder1$chb_contactinfo")).Checked = true;
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_user_firstname")).TypeText("Tester");
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_user_addr")).TypeText("Test");
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_user_city")).TypeText("ADONA");
               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$dl_user_state")).Option("Alaska").Select();
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_user_zip")).TypeText("11111");
               ie.TextField(Find.ById("igtxtctl00_ContentPlaceHolder1_txt_user_phone")).Value = "(123) 111-1111";
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_user_email")).TypeText("christie.duan@nirvana-info.com");
               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$dl_pay_cardtype")).Option("American Express").Select();
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_pay_cardname")).TypeText("Test");
               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_pay_account")).TypeText("3782822463100055");
               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$dl_pay_month")).Option("09").Select();
               ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$dl_pay_year")).Option("2010").Select();

               ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_order_description")).TypeText("BusinessLeads_MapAddress" + Date);
               ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$BottomBtNext")).Click();
               ie.Div(Find.ById("MyOrderMain")).WaitUntilExists(120);
               Assert.IsTrue(ie.ContainsText("Your Order Is Complete!"));


           }



        [Test]
        public void Check01_08_OrderOccupantLists_ChooseCities()
        {
            ie.GoTo(URL + "/OC/OrderSelectDataSource.aspx");
            ie.RadioButton(Find.ById("ctl00_ContentPlaceHolder1_rb3")).Checked = true;
            ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$IbtNext")).Click();


            ie.RadioButton(Find.ById("ctl00_ContentPlaceHolder1_RBLGeoType_2")).Checked = true;
            ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$BottomBtNext")).Click();
            ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$btLoadCount")).WaitUntilRemoved(120);


            ie.Image(Find.BySrc(URL + "/Images/Add.jpg")).Click();
            ie.SelectList(Find.ById("ctl00_ContentPlaceHolder1_lstCities")).Option("Adak").Select();
            ie.Image(Find.BySrc(URL + "/Images/Add.jpg")).Click();
            ie.SelectList(Find.ById("ctl00_ContentPlaceHolder1_lstCities")).Option("Akiachak").Select();
            ie.Image(Find.BySrc(URL + "/Images/Add.jpg")).Click();
            ie.SelectList(Find.ById("ctl00_ContentPlaceHolder1_lstCities")).Option("Akiak").Select();
            ie.Image(Find.BySrc(URL + "/Images/Add.jpg")).Click();
            ie.SelectList(Find.ById("ctl00_ContentPlaceHolder1_lstCities")).Option("Akutan").Select();
            ie.Image(Find.BySrc(URL + "/Images/Add.jpg")).Click();
            ie.SelectList(Find.ById("ctl00_ContentPlaceHolder1_lstCities")).Option("Alakanuk").Select();
            ie.Image(Find.BySrc(URL + "/Images/Add.jpg")).Click();
            ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$BottomBtNext")).Click();



            //Demographics
            ie.Label(Find.ByText("Include homes")).WaitUntilExists(120);


            //Get count
            ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$TopBtNext")).Click();
            ie.TableCell(Find.ByText("List Price")).WaitUntilExists(120);
            ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$TopBtNext")).Click();

            // Agree Terms
            ie.Label(Find.ByText("I have read and agree to the terms and conditions above.")).WaitUntilExists(120);
            ie.CheckBox(Find.ByName("ctl00$ContentPlaceHolder1$chbAgreement")).Checked = true;
            ie.GoTo(URL + "/OC/OrderPaymentInfo.aspx");

            //Payment Information
            ie.Link(Find.ByText("Order Details")).WaitUntilExists(120);
            ie.CheckBox(Find.ByName("ctl00$ContentPlaceHolder1$chb_contactinfo")).Checked = true;
            ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_user_firstname")).TypeText("Tester");
            ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_user_addr")).TypeText("Test");
            ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_user_city")).TypeText("ADONA");
            ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$dl_user_state")).Option("Alaska").Select();
            ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_user_zip")).TypeText("11111");
            ie.TextField(Find.ById("igtxtctl00_ContentPlaceHolder1_txt_user_phone")).Value = "(123) 111-1111";
            ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_user_email")).TypeText("christie.duan@nirvana-info.com");
            ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$dl_pay_cardtype")).Option("American Express").Select();
            ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_pay_cardname")).TypeText("Test");
            ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_pay_account")).TypeText("3782822463100055");
            ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$dl_pay_month")).Option("09").Select();
            ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$dl_pay_year")).Option("2010").Select();

            ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_order_description")).TypeText("OccupantLists_ChooseCities" + Date);
            ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$BottomBtNext")).Click();
            ie.Div(Find.ById("MyOrderMain")).WaitUntilExists(120);
            Assert.IsTrue(ie.ContainsText("Your Order Is Complete!"));


        }

        [Test]
        public void Check01_09_OrderNewHomeownerLists_PromoCode()
        {
            ie.GoTo(URL + "/OC/OrderSelectDataSource.aspx");
            ie.RadioButton(Find.ById("ctl00_ContentPlaceHolder1_rb4")).Checked = true;
            ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$IbtNext")).Click();


            ie.RadioButton(Find.ById("ctl00_ContentPlaceHolder1_RBLGeoType_2")).Checked = true;
            ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$BottomBtNext")).Click();
            ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$btLoadCount")).WaitUntilRemoved(120);


            ie.Image(Find.BySrc(URL + "/Images/Add.jpg")).Click();
            ie.SelectList(Find.ById("ctl00_ContentPlaceHolder1_lstCities")).Option("Adak").Select();
            ie.Image(Find.BySrc(URL + "/Images/Add.jpg")).Click();
            ie.SelectList(Find.ById("ctl00_ContentPlaceHolder1_lstCities")).Option("Akiachak").Select();
            ie.Image(Find.BySrc(URL + "/Images/Add.jpg")).Click();
            ie.SelectList(Find.ById("ctl00_ContentPlaceHolder1_lstCities")).Option("Akiak").Select();
            ie.Image(Find.BySrc(URL + "/Images/Add.jpg")).Click();
            ie.SelectList(Find.ById("ctl00_ContentPlaceHolder1_lstCities")).Option("Akutan").Select();
            ie.Image(Find.BySrc(URL + "/Images/Add.jpg")).Click();
            ie.SelectList(Find.ById("ctl00_ContentPlaceHolder1_lstCities")).Option("Alakanuk").Select();
            ie.Image(Find.BySrc(URL + "/Images/Add.jpg")).Click();
            ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$BottomBtNext")).Click();



            //Demographics
            ie.TableCell(Find.ByText("Demographics")).WaitUntilExists(120);
            ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$btAddDem")).Click();

            ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$ltbDemCat")).Option("Gender").Select();
            ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$ltbDemVar")).Option("Unknown").WaitUntilExists(120);
            ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$btAddDem")).Click();

            ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$ltbDemCat")).Option("Loan Type").Select();
            ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$ltbDemVar")).Option("VA").WaitUntilExists(120);
            ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$btAddDem")).Click();



            //Get count
            ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$TopBtNext")).Click();
            ie.TableCell(Find.ByText("List Price")).WaitUntilExists(120);

            ie.Link(Find.ByText("Promo Code")).Click();
            ie.RadioButton(Find.ById("ctl00_ContentPlaceHolder1_GVPromotion_ctl02_rbPromotionCode")).Checked = true;
            ie.Button(Find.ById("ctl00_ContentPlaceHolder1_OkButton")).Click();


            ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$TopBtNext")).Click();

            // Agree Terms
            ie.Label(Find.ByText("I have read and agree to the terms and conditions above.")).WaitUntilExists(120);
            ie.CheckBox(Find.ByName("ctl00$ContentPlaceHolder1$chbAgreement")).Checked = true;
            ie.GoTo(URL + "/OC/OrderPaymentInfo.aspx");

            //Payment Information
            ie.Link(Find.ByText("Order Details")).WaitUntilExists(120);
            ie.CheckBox(Find.ByName("ctl00$ContentPlaceHolder1$chb_contactinfo")).Checked = true;
            ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_user_firstname")).TypeText("Tester");
            ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_user_addr")).TypeText("Test");
            ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_user_city")).TypeText("ADONA");
            ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$dl_user_state")).Option("Alaska").Select();
            ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_user_zip")).TypeText("11111");
            ie.TextField(Find.ById("igtxtctl00_ContentPlaceHolder1_txt_user_phone")).Value = "(123) 111-1111";
            ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_user_email")).TypeText("christie.duan@nirvana-info.com");
            ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$dl_pay_cardtype")).Option("American Express").Select();
            ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_pay_cardname")).TypeText("Test");
            ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_pay_account")).TypeText("3782822463100055");
            ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$dl_pay_month")).Option("09").Select();
            ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$dl_pay_year")).Option("2010").Select();

            ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_order_description")).TypeText("NewHomeownerLists_PromoCode" + Date);
            ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$BottomBtNext")).Click();
            ie.Div(Find.ById("MyOrderMain")).WaitUntilExists(120);
            Assert.IsTrue(ie.ContainsText("Your Order Is Complete!"));


        }


        [Test]
        public void Check01_10_OrderNewMoverLists_Cities()
        {
            ie.GoTo(URL + "/OC/OrderSelectDataSource.aspx");
            ie.RadioButton(Find.ById("ctl00_ContentPlaceHolder1_rb5")).Checked = true;
            ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$IbtNext")).Click();


            ie.RadioButton(Find.ById("ctl00_ContentPlaceHolder1_RBLGeoType_2")).Checked = true;
            ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$BottomBtNext")).Click();
            ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$btLoadCount")).WaitUntilRemoved(120);


            ie.Image(Find.BySrc(URL + "/Images/Add.jpg")).Click();
            ie.SelectList(Find.ById("ctl00_ContentPlaceHolder1_lstCities")).Option("Adak").Select();
            ie.Image(Find.BySrc(URL + "/Images/Add.jpg")).Click();
            ie.SelectList(Find.ById("ctl00_ContentPlaceHolder1_lstCities")).Option("Akiachak").Select();
            ie.Image(Find.BySrc(URL + "/Images/Add.jpg")).Click();
            ie.SelectList(Find.ById("ctl00_ContentPlaceHolder1_lstCities")).Option("Akiak").Select();
            ie.Image(Find.BySrc(URL + "/Images/Add.jpg")).Click();
            ie.SelectList(Find.ById("ctl00_ContentPlaceHolder1_lstCities")).Option("Akutan").Select();
            ie.Image(Find.BySrc(URL + "/Images/Add.jpg")).Click();
            ie.SelectList(Find.ById("ctl00_ContentPlaceHolder1_lstCities")).Option("Alakanuk").Select();
            ie.Image(Find.BySrc(URL + "/Images/Add.jpg")).Click();
            ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$BottomBtNext")).Click();



            //Demographics
            ie.TableCell(Find.ByText("Demographics")).WaitUntilExists(120);
            ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$btAddDem")).Click();

            ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$ltbDemCat")).Option("Dwelling Type").Select();
            ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$ltbDemVar")).Option("Single Family").WaitUntilExists(120);
            ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$btAddDem")).Click();

            ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$ltbDemCat")).Option("Gender of Primary Owner").Select();
            ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$ltbDemVar")).Option("Female").WaitUntilExists(120);
            ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$btAddDem")).Click();



            //Get count
            ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$TopBtNext")).Click();
            ie.TableCell(Find.ByText("List Price")).WaitUntilExists(120);


            ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$TopBtNext")).Click();

            // Agree Terms
            ie.Label(Find.ByText("I have read and agree to the terms and conditions above.")).WaitUntilExists(120);
            ie.CheckBox(Find.ByName("ctl00$ContentPlaceHolder1$chbAgreement")).Checked = true;
            ie.GoTo(URL + "/OC/OrderPaymentInfo.aspx");

            //Payment Information
            ie.Link(Find.ByText("Order Details")).WaitUntilExists(120);
            ie.CheckBox(Find.ByName("ctl00$ContentPlaceHolder1$chb_contactinfo")).Checked = true;
            ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_user_firstname")).TypeText("Tester");
            ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_user_addr")).TypeText("Test");
            ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_user_city")).TypeText("ADONA");
            ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$dl_user_state")).Option("Alaska").Select();
            ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_user_zip")).TypeText("11111");
            ie.TextField(Find.ById("igtxtctl00_ContentPlaceHolder1_txt_user_phone")).Value = "(123) 111-1111";
            ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_user_email")).TypeText("christie.duan@nirvana-info.com");
            ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$dl_pay_cardtype")).Option("American Express").Select();
            ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_pay_cardname")).TypeText("Test");
            ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_pay_account")).TypeText("3782822463100055");
            ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$dl_pay_month")).Option("09").Select();
            ie.SelectList(Find.ByName("ctl00$ContentPlaceHolder1$dl_pay_year")).Option("2010").Select();

            ie.TextField(Find.ByName("ctl00$ContentPlaceHolder1$txt_order_description")).TypeText("NewMoverLists_Cities" + Date);
            ie.Image(Find.ByName("ctl00$ContentPlaceHolder1$BottomBtNext")).Click();
            ie.Div(Find.ById("MyOrderMain")).WaitUntilExists(120);
            Assert.IsTrue(ie.ContainsText("Your Order Is Complete!"));


        }



    }
}
