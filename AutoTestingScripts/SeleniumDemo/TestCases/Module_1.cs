using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using Selenium;
using NUnit.Framework;
using System.Threading;


namespace CWAdmin.TestCases
{
    [TestFixture]
    public class SmokingTest : TestBase
    {

        // Create a rule iris_test_series at first; Find it in rule list; Delete it; Find it again
        // The type of rule is series
        [Test]        
        public void T001_MultiPriceRule()   
        {
            CommonFunction.Login(this.selenium);            
                        
            // Get into "View Multi Pricing Rules"
            CommonFunction.WaitforElementPresent("//img[@id='logo']",this.selenium);  // Home page
            selenium.Click("//div[@id='headerMenu']/ul/li[5]/a/img");
            Thread.Sleep(5000);
            selenium.Click("//div[@id='headerMenu']/ul/li[5]/ul/li[5]/a/strong");

            CommonFunction.WaitforTextPresent("View Multi Pricing Rules",this.selenium); // Multi-pricing rules list page
            
            
            // Create a rule, type is series
            selenium.Click("IndexCreateButton");
            CommonFunction.WaitforTextPresent("Discount Rule Details",this.selenium);

            // Input different parameters
            selenium.Select("idmptype", "label=Series"); // Type
            selenium.Type("itemname", "iris_test_series"); // Item Name
            selenium.Select("brandbox", "label=BestInAUTO"); // Brand
            selenium.Click("//option[@value='83']"); // ??
            Thread.Sleep(5000);
            CommonFunction.WaitforElementPresent("ISSelectReplacement_555", this.selenium);
            selenium.Click("ISSelectReplacement_555"); // Series: BestInAuto 3rd Brake Lights
            Thread.Sleep(5000);
            CommonFunction.WaitforElementPresent("ISSelectReplacement_216", this.selenium);
            selenium.Click("ISSelectReplacement_216"); // Customer
            selenium.Type("id_group_num", "4"); // Group Num
            selenium.Type("min[]", "1");
            selenium.Type("max[]", "5");
            //selenium.Select("discountType[]", "label=Flat rate discount of $");
            selenium.Select("discountType[]", "label=Percentage discount of %");
            selenium.Type("discount[]", "5.5");
            selenium.Click("//div[@id='discountWrapper']/div/table/tbody/tr[3]/td/table/tbody/tr[10]/td/p/input[1]"); // Save
            selenium.WaitForPageToLoad("30000");             
            
            // Velidate the new created rule.
            CommonFunction.WaitforTextPresent("View Multi Pricing Rules",this.selenium);
            CommonFunction.WaitforElementPresent("MultiTypeSelect", this.selenium);
            selenium.Select("MultiTypeSelect", "label=Series");
            Thread.Sleep(5000);
            CommonFunction.WaitforElementPresent("BrandSeriesSelect", this.selenium);
            selenium.Select("BrandSeriesSelect", "label=BestInAuto 3rd Brake Lights");

            // Verify iris_test_series
            Thread.Sleep(5000);
            CommonFunction.WaitforElementPresent("//table[@id='IndexGrid']/tbody/tr", this.selenium);
            decimal fCount = selenium.GetXpathCount("//table[@id='IndexGrid']/tbody/tr");

            int iIndex = 0;
            bool bCreateRule = false;
            if (fCount > 4)
            {
                for (iIndex = 4; iIndex < fCount; iIndex++)
                {
                    string sName = selenium.GetText("//table[@id='IndexGrid']/tbody/tr[" + iIndex + "]/td[4]");
                    if (sName.Contains("iris_test_series"))   // The Rule created in this case should be found. Otherwise, throw error. 
                    {
                        bCreateRule = true;
                        break;
                    }
                }

            }

            if (bCreateRule == false)
            {
                Assert.Fail("Creating rule iris_test_series fails!");
            }
            

            // Delete the rule
            selenium.Click("//table[@id='IndexGrid']/tbody/tr[" + iIndex + "]/td[1]/input");   // check the rule "iris_test_series"
            Thread.Sleep(1000);
            selenium.Click("IndexDeleteButton");        // Click "Delete Selected" button
            
            // Verify whether or not the rule is deleted
            Thread.Sleep(5000);
            CommonFunction.WaitforElementPresent("//table[@id='IndexGrid']/tbody/tr", this.selenium);
            fCount = selenium.GetXpathCount("//table[@id='IndexGrid']/tbody/tr");
 
            bCreateRule = false;
            if (fCount > 4)
            {
                for (iIndex = 4; iIndex < fCount-1; iIndex++)
                {
                    string sName = selenium.GetText("//table[@id='IndexGrid']/tbody/tr[" + iIndex + "]/td[4]");
                    if (sName.Contains("iris_test_series"))   // The Rule created in this case should be found. Otherwise, throw error. 
                    {
                        bCreateRule = true;
                        break;
                    }
                }

            }

            if (bCreateRule == true)
            {
                Assert.Fail("Removing rule iris_test_series fails!");
            }
  
        }

        // Create a rule iris_test_brand at first; Find it in rule list; Delete it; Find it again
        // The type of rule is brand   
        [Test]
        public void T002_MultiPriceRule()
        {

            CommonFunction.Login(this.selenium);

            // Get into "View Multi Pricing Rules"
            CommonFunction.WaitforElementPresent("//img[@id='logo']", this.selenium);  // Home page
            selenium.Click("//div[@id='headerMenu']/ul/li[5]/a/img");
            Thread.Sleep(5000);
            selenium.Click("//div[@id='headerMenu']/ul/li[5]/ul/li[5]/a/strong");

            CommonFunction.WaitforTextPresent("View Multi Pricing Rules", this.selenium); // Multi-pricing rules list page

            
            // Create a rule, type is brand
            selenium.Click("IndexCreateButton");
            CommonFunction.WaitforTextPresent("Discount Rule Details",this.selenium);

            // Input different parameters
            selenium.Select("idmptype", "label=Brand"); // Type
            selenium.Type("itemname", "iris_test_brand"); // Item Name
            selenium.Select("brandbox", "label=Advantage"); // Brand            
            //CommonFunction.WaitforElementPresent("ISSelectReplacement_216", this.selenium);   // You can set specific customer at this step.
            //selenium.Click("ISSelectReplacement_216"); // Customer
            selenium.Type("id_group_num", "4"); // Group Num
            selenium.Type("min[]", "1");
            selenium.Type("max[]", "5");
            selenium.Select("discountType[]", "label=Flat rate discount of $");
            //selenium.Select("discountType[]", "label=Percentage discount of %");
            selenium.Type("discount[]", "5.5");
            selenium.Click("//div[@id='discountWrapper']/div/table/tbody/tr[3]/td/table/tbody/tr[10]/td/p/input[1]"); // Save
            selenium.WaitForPageToLoad("30000");             
            
            // Velidate the new created rule.
            CommonFunction.WaitforTextPresent("View Multi Pricing Rules", this.selenium);
            CommonFunction.WaitforElementPresent("MultiTypeSelect", this.selenium);
            selenium.Select("MultiTypeSelect", "label=Brand");
            Thread.Sleep(5000);
            CommonFunction.WaitforElementPresent("BrandSeriesSelect", this.selenium);
            selenium.Select("BrandSeriesSelect", "label=Advantage");

            // Verify Iris_test_brand
            Thread.Sleep(5000);
            CommonFunction.WaitforElementPresent("//table[@id='IndexGrid']/tbody/tr", this.selenium);
            decimal fCount = selenium.GetXpathCount("//table[@id='IndexGrid']/tbody/tr");

            int iIndex = 0;
            bool bCreateRule = false;
            if (fCount > 4)
            {
                for (iIndex = 4; iIndex < fCount; iIndex++)
                {
                    string sName = selenium.GetText("//table[@id='IndexGrid']/tbody/tr[" + iIndex + "]/td[4]");
                    if (sName.Contains("iris_test_brand"))   // The Rule created in this case should be found. Otherwise, throw error. 
                    {
                        bCreateRule = true;
                        break;
                    }
                }

            }

            if (bCreateRule == false)
            {
                Assert.Fail("Creating rule iris_test_brand fails!");
            }


            // Delete the rule
            selenium.Click("//table[@id='IndexGrid']/tbody/tr[" + iIndex + "]/td[1]/input");   // check the rule "iris_test_brand"
            Thread.Sleep(1000);
            selenium.Click("IndexDeleteButton");        // Click "Delete Selected" button

            // Verify whether or not the rule is deleted
            Thread.Sleep(5000);
            CommonFunction.WaitforElementPresent("//table[@id='IndexGrid']/tbody/tr", this.selenium);
            fCount = selenium.GetXpathCount("//table[@id='IndexGrid']/tbody/tr");

            bCreateRule = false;
            if (fCount > 4)
            {
                for (iIndex = 4; iIndex < fCount - 1; iIndex++)
                {
                    string sName = selenium.GetText("//table[@id='IndexGrid']/tbody/tr[" + iIndex + "]/td[4]");
                    if (sName.Contains("iris_test_brand"))   // The Rule created in this case should be found. Otherwise, throw error. 
                    {
                        bCreateRule = true;
                        break;
                    }
                }

            }

            if (bCreateRule == true)
            {
                Assert.Fail("Removing rule iris_test_brand fails!");
            }
        }

        // Create a rule iris_test_cate at first; Find it in rule list; Delete it; Find it again
        // The type of rule is subcategory           
        [Test]
        public void T003_MultiPriceRule()
        {

            CommonFunction.Login(this.selenium);

            // Get into "View Multi Pricing Rules"
            CommonFunction.WaitforElementPresent("//img[@id='logo']", this.selenium);  // Home page
            selenium.Click("//div[@id='headerMenu']/ul/li[5]/a/img");
            Thread.Sleep(5000);
            selenium.Click("//div[@id='headerMenu']/ul/li[5]/ul/li[5]/a/strong");

            CommonFunction.WaitforTextPresent("View Multi Pricing Rules", this.selenium); // Multi-pricing rules list page


            // Create a rule, type is brand
            selenium.Click("IndexCreateButton");
            CommonFunction.WaitforTextPresent("Discount Rule Details", this.selenium);

            // Input different parameters
            selenium.Select("idmptype", "label=Category"); // Type
            selenium.Type("itemname", "iris_test_cate"); // Item Name
            selenium.Select("brandbox", "label=regexp:\\s+Universal Engine_Accessories"); // subcategory           
            //CommonFunction.WaitforElementPresent("ISSelectReplacement_216", this.selenium);   // You can set specific customer at this step.
            //selenium.Click("ISSelectReplacement_216"); // Customer
            selenium.Type("id_group_num", "4"); // Group Num
            selenium.Type("min[]", "1");
            selenium.Type("max[]", "10");
            //selenium.Select("discountType[]", "label=Flat rate discount of $");
            selenium.Select("discountType[]", "label=Percentage discount of %");
            selenium.Type("discount[]", "5.5");
            selenium.Click("//div[@id='discountWrapper']/div/table/tbody/tr[3]/td/table/tbody/tr[10]/td/p/input[1]"); // Save
            selenium.WaitForPageToLoad("30000");

            // Velidate the new created rule.
            CommonFunction.WaitforTextPresent("View Multi Pricing Rules", this.selenium);
            CommonFunction.WaitforElementPresent("MultiTypeSelect", this.selenium);
            selenium.Select("MultiTypeSelect", "label=Category");

            // Verify Iris_test_cate
            Thread.Sleep(5000);
            CommonFunction.WaitforElementPresent("//table[@id='IndexGrid']/tbody/tr", this.selenium);
            decimal fCount = selenium.GetXpathCount("//table[@id='IndexGrid']/tbody/tr");

            int iIndex = 0;
            bool bCreateRule = false;
            if (fCount > 4)
            {
                for (iIndex = 4; iIndex < fCount; iIndex++)
                {
                    string sName = selenium.GetText("//table[@id='IndexGrid']/tbody/tr[" + iIndex + "]/td[4]");
                    if (sName.Contains("Iris_test_cate"))   // The Rule created in this case should be found. Otherwise, throw error. 
                    {
                        bCreateRule = true;
                        break;
                    }
                }

            }

            if (bCreateRule == false)
            {
                Assert.Fail("Creating rule Iris_test_cate fails!");
            }


            // Delete the rule
            selenium.Click("//table[@id='IndexGrid']/tbody/tr[" + iIndex + "]/td[1]/input");   // check the rule "Iris_test_cate"
            Thread.Sleep(1000);
            selenium.Click("IndexDeleteButton");        // Click "Delete Selected" button

            // Verify whether or not the rule is deleted
            Thread.Sleep(5000);
            CommonFunction.WaitforElementPresent("//table[@id='IndexGrid']/tbody/tr", this.selenium);
            fCount = selenium.GetXpathCount("//table[@id='IndexGrid']/tbody/tr");

            bCreateRule = false;
            if (fCount > 4)
            {
                for (iIndex = 4; iIndex < fCount - 1; iIndex++)
                {
                    string sName = selenium.GetText("//table[@id='IndexGrid']/tbody/tr[" + iIndex + "]/td[4]");
                    if (sName.Contains("Iris_test_cate"))   // The Rule created in this case should be found. Otherwise, throw error. 
                    {
                        bCreateRule = true;
                        break;
                    }
                }

            }

            if (bCreateRule == true)
            {
                Assert.Fail("Removing rule Iris_test_cate fails!");
            }
        }

        // Create a rule iris_test_pack at first; Find it in rule list; Delete it; Find it again
        // The type of rule is package.           
        [Test]
        public void T004_MultiPriceRule()
        {
            CommonFunction.Login(this.selenium);

            // Get into "View Multi Pricing Rules"
            CommonFunction.WaitforElementPresent("//img[@id='logo']", this.selenium);  // Home page
            selenium.Click("//div[@id='headerMenu']/ul/li[5]/a/img");
            Thread.Sleep(5000);
            selenium.Click("//div[@id='headerMenu']/ul/li[5]/ul/li[5]/a/strong");

            CommonFunction.WaitforTextPresent("View Multi Pricing Rules", this.selenium); // Multi-pricing rules list page


            // Create a rule, type is package
            selenium.Click("IndexCreateButton");
            CommonFunction.WaitforTextPresent("Discount Rule Details", this.selenium);

            // Input different parameters
            selenium.Select("idmptype", "label=Package"); // Type
            selenium.Type("itemname", "iris_test_pack"); // Item Name
            selenium.Click("//input[@value='Add Products']");
            selenium.WaitForPopUp("productSelectProductSelecttypecoupon", "30000");
            selenium.SelectWindow("name=productSelectProductSelecttypecoupon");
            selenium.Click("//li[@onclick='if(this.parentNode.previousItem) { this.parentNode.previousItem.className = \"\"; } this.className=\"active\"; var current_category = 696; this.parentNode.previousItem = this; ProductSelect.LoadLinks(\"category=696\");']");
            selenium.Click("ISSelectReplacement_186575");
            selenium.Click("//input[@value='Select']");
            selenium.WaitForPageToLoad("30000");
            selenium.SelectWindow("name=selenium_main_app_window");
            selenium.Type("min[]", "1");
            selenium.Type("max[]", "10");
            selenium.Type("discount[186575][]", "5.55");
            selenium.Click("//div[@id='discountWrapper']/div/table/tbody/tr[3]/td/table/tbody/tr[10]/td/p/input[1]");
            selenium.WaitForPageToLoad("30000");

            // Velidate the new created rule.
            CommonFunction.WaitforTextPresent("View Multi Pricing Rules", this.selenium);
            CommonFunction.WaitforElementPresent("MultiTypeSelect", this.selenium);
            selenium.Select("MultiTypeSelect", "label=Package");

            // Verify Iris_test_pack
            Thread.Sleep(5000);
            CommonFunction.WaitforElementPresent("//table[@id='IndexGrid']/tbody/tr", this.selenium);
            decimal fCount = selenium.GetXpathCount("//table[@id='IndexGrid']/tbody/tr");

            int iIndex = 0;
            bool bCreateRule = false;
            if (fCount > 4)
            {
                for (iIndex = 4; iIndex < fCount; iIndex++)
                {
                    string sName = selenium.GetText("//table[@id='IndexGrid']/tbody/tr[" + iIndex + "]/td[4]");
                    if (sName.Contains("Iris_test_pack"))   // The Rule created in this case should be found. Otherwise, throw error. 
                    {
                        bCreateRule = true;
                        break;
                    }
                }

            }

            if (bCreateRule == false)
            {
                Assert.Fail("Creating rule Iris_test_pack fails!");
            }


            // Delete the rule
            selenium.Click("//table[@id='IndexGrid']/tbody/tr[" + iIndex + "]/td[1]/input");   // check the rule "Iris_test_pack"
            Thread.Sleep(1000);
            selenium.Click("IndexDeleteButton");        // Click "Delete Selected" button

            // Verify whether or not the rule is deleted
            Thread.Sleep(5000);
            CommonFunction.WaitforElementPresent("//table[@id='IndexGrid']/tbody/tr", this.selenium);
            fCount = selenium.GetXpathCount("//table[@id='IndexGrid']/tbody/tr");

            bCreateRule = false;
            if (fCount > 4)
            {
                for (iIndex = 4; iIndex < fCount - 1; iIndex++)
                {
                    string sName = selenium.GetText("//table[@id='IndexGrid']/tbody/tr[" + iIndex + "]/td[4]");
                    if (sName.Contains("Iris_test_pack"))   // The Rule created in this case should be found. Otherwise, throw error. 
                    {
                        bCreateRule = true;
                        break;
                    }
                }

            }

            if (bCreateRule == true)
            {
                Assert.Fail("Removing rule Iris_test_pack fails!");
            }

        }

        [Test]
        public void T005_AddOrder()
        {
            CommonFunction.Login(this.selenium);

            // Add an order   
            CommonFunction.WaitforElementPresent("//img[@id='logo']",this.selenium);
            selenium.Click("//div[@id='headerMenu']/ul/li[1]/a/img");
            Thread.Sleep(1000);
            selenium.Click("//div[@id='headerMenu']/ul/li[1]/ul/li[3]/a/strong");

            // Fill Customer Details
            CommonFunction.WaitforTextPresent("Customer Details", this.selenium);
            selenium.Click("tab0");
            selenium.Type("custconemail", "iris_test@nirvana-info.com");
            selenium.Type("custpassword", "123456");
            selenium.Type("custpassword2", "123456");
            selenium.Click("ordbillsaveAddress");
            selenium.Type("FormField_4", "iris");
            selenium.Type("FormField_5", "chen");
            selenium.Type("FormField_6", "NV");
            selenium.Select("FormField_12", "label=American Samoa");
            selenium.Type("FormField_13", "15535");
            selenium.Type("FormField_7", "123456");
            selenium.Type("FormField_8", "new york");
            selenium.Type("FormField_10", "new york");

            // Fill Order Items            
            selenium.Click("//tr[@id='orderItem_0']/td[2]/div[1]/nobr/a/img");
            Thread.Sleep(15);
            //selenium.WaitForPopUp("productSelect0typesingle", "30000");
            //selenium.SelectWindow("name=productSelect0typesingle");
            //Thread.Sleep(15);
            //selenium.Click("//li[@onclick='if(this.parentNode.previousItem) { this.parentNode.previousItem.className = \"\"; } this.className=\"active\"; var current_category = 798; this.parentNode.previousItem = this; ProductSelect.LoadLinks(\"category=798\");']");
            //Thread.Sleep(10);
            //selenium.Click("//li[@onclick='if(this.parentNode.previousItem) { this.parentNode.previousItem.className = \"\"; } this.className=\"active\"; var current_category = 798; this.parentNode.previousItem = this; ProductSelect.LoadLinks(\"category=798\");']");
            //Thread.Sleep(15);
            //selenium.Select("prodSelect", "label=Bumper Accessories Truck Champ Front Fill Plate Part Number 18016 Stainless Steel , $140.94 , 18016");
            //Thread.Sleep(15);
            //selenium.Click("//input[@value='Select']");
            //selenium.WaitForPageToLoad("30000");
            

        }

        [Test]
        public void T006_EditOrder()
        {

            CommonFunction.Login(this.selenium);

            // Edit an order
            CommonFunction.WaitforElementPresent("//img[@id='logo']",this.selenium);
            selenium.Click("//div[@id='headerMenu']/ul/li[1]/a/img");
            Thread.Sleep(3);
            selenium.Click("//div[@id='headerMenu']/ul/li[1]/ul/li[1]/a/strong");

            CommonFunction.WaitforTextPresent("All Orders",this.selenium);
            selenium.Type("searchQuery", "iris_test");
            selenium.Click("SearchButton");
            selenium.WaitForPageToLoad("30000");

            // Validate whether iris_test exists
            decimal fCount = selenium.GetXpathCount("//table[@id='IndexGrid']/tbody/tr");

            int iIndex = 0;
            bool bOrder = false;
            if (fCount > 1)
            {
                for (iIndex = 3; iIndex < fCount - 1; iIndex++)
                {
                    string sName = selenium.GetText("//table[@id='IndexGrid']/tbody/tr[" + iIndex + "]/td[5]/a[1]");
                    if (sName.Contains("iris_test"))   // The Rule created in this case should be found. Otherwise, throw error. 
                    {
                        bOrder = true;
                        break;
                    }
                }

            }

            if (bOrder == false)
            {
                Assert.Fail("Order created by Iris_test doesn't exist!");
            }

            selenium.Select("order_action_2268", "label=Edit Order");

            CommonFunction.WaitforTextPresent("Customer Details",this.selenium);
            CommonFunction.WaitforElementPresent("FormField_4",this.selenium);
            selenium.Type("FormField_4", "test_iris");
            CommonFunction.WaitforElementPresent("saveandpay",this.selenium);
            selenium.DoubleClick("saveandpay");
            selenium.WaitForPageToLoad("30000");
            CommonFunction.WaitforTextPresent("Pay Order",this.selenium);
            CommonFunction.WaitforElementPresent("CancelButton1",this.selenium);
            selenium.Click("CancelButton1");
            //Assert.IsTrue(Regex.IsMatch(selenium.GetConfirmation(), "^Are you sure you want to cancel[\\s\\S] Click OK to confirm\\.$"));

        }


    }
}
