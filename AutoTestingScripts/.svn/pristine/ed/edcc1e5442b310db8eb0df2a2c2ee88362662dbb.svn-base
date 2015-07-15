'''
Created on 2011-02-25

@author: iris chen
'''
from TestBase import TestBase
import AddCart
import FunctionCommon
import PublicFunctions
import Mutil_Selection
import Payment
import unittest
import time
import HTMLTestRunner
import Verification


### Test cases

class  SmartSearchTestOrders(TestBase):    
    def test010_Prod_SKU(self):
        FunctionCommon.smartsearch(self,"33-2001")
        Mutil_Selection.Products_ViewDetail(self)
        Verification.Verify_SKU(self,"33-2001")
        AddCart.AddCart(self)
        PublicFunctions.my_wait_text_present(self,"Your Shopping Cart")
        AddCart.CheckOut(self)        

    def test011_Prod_SKU(self):
        FunctionCommon.smartsearch(self,"16900")
        Mutil_Selection.Products_ViewDetail(self)
        Verification.Verify_SKU(self,"16900")
        AddCart.AddCart(self)
        PublicFunctions.my_wait_text_present(self,"Your Shopping Cart")
        AddCart.CheckOut(self)

    def test012_Prod_SKU(self):
        FunctionCommon.smartsearch(self,"82016")
        Mutil_Selection.Products_ViewDetail(self)
        Verification.Verify_SKU(self,"82016")
        AddCart.AddCart(self)
        PublicFunctions.my_wait_text_present(self,"Your Shopping Cart")
        AddCart.CheckOut(self) 

    def test020_Brand_Name(self):
        FunctionCommon.smartsearch(self,"Advantage")
        Mutil_Selection.Products_ViewDetail(self)
        Verification.Verify_Brand(self,"Advantage")
        AddCart.AddCart(self)
        PublicFunctions.my_wait_text_present(self,"Your Shopping Cart")
        AddCart.CheckOut(self)

    def test021_Brand_Name(self):
        FunctionCommon.smartsearch(self,"BestInAUTO")
        Mutil_Selection.Products_ViewDetail(self)
        Verification.Verify_Brand(self,"BestInAUTO")
        AddCart.AddCart(self)
        PublicFunctions.my_wait_text_present(self,"Your Shopping Cart")
        AddCart.CheckOut(self)

    def test022_Brand_Name(self):
        FunctionCommon.smartsearch(self,"Extang")
        Mutil_Selection.Products_ViewDetail(self)
        Verification.Verify_Brand(self,"Extang")
        AddCart.AddCart(self)
        PublicFunctions.my_wait_text_present(self,"Your Shopping Cart")
        AddCart.CheckOut(self)

    def test030_Category_Name(self):
        FunctionCommon.smartsearch(self,"Ignition")
        Mutil_Selection.Products_ViewDetail(self)
        Verification.Verify_Category(self,"Ignition")
        AddCart.AddCart(self)
        PublicFunctions.my_wait_text_present(self,"Your Shopping Cart")
        AddCart.CheckOut(self)


              
##Test Suite
def SmartSearchTest():
    suite=unittest.TestSuite()
    suite.addTest(SmartSearchTestOrders("test010_Prod_SKU"))
    suite.addTest(SmartSearchTestOrders("test011_Prod_SKU"))
    suite.addTest(SmartSearchTestOrders("test012_Prod_SKU"))
    suite.addTest(SmartSearchTestOrders("test020_Brand_Name"))
    suite.addTest(SmartSearchTestOrders("test021_Brand_Name"))
    suite.addTest(SmartSearchTestOrders("test022_Brand_Name"))
    suite.addTest(SmartSearchTestOrders("test030_Category_Name")) 
    
    return suite

## Test Execute

if __name__ == "__main__":
    fp = file('CongoWorld Auto-Testing Result_CategoriesOrders_MoreSubcategories.html', 'wb')
    runner = HTMLTestRunner.HTMLTestRunner(stream=fp, title='Quick Test', description='The test report of selenium')    
    runner.run(SmartSearchTest())
