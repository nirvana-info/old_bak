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




### Test cases

class  PlaceMoreSubCateOrSeriesOrders(TestBase):    
    def test010_TwoSubCategories(self):
        Mutil_Selection.Year(self,"2010")
        Mutil_Selection.Categories_QP(self,"Tonneau Covers")
        time.sleep(3)
        Mutil_Selection.Categories_QP(self,"Nerf Bars")        
        FunctionCommon.Browser(self)
        Mutil_Selection.TwoSubCategories_select(self,"Truck Champ Drop Step","Snap Tonneau Covers")
        Mutil_Selection.Products_ViewDetail(self)
        AddCart.AddCart(self)
        PublicFunctions.my_wait_text_present(self,"Your Shopping Cart")
        AddCart.CheckOut(self)
##        PublicFunctions.my_wait_text_present(self,"Express Checkout")
##        Payment.Step1_ProceedCheckOut(self,False)
##        Payment.Step3_ShippingMethod(self)
##        Payment.Step4_OrderConfirm(self)

    def test011_TwoSubCategories(self):
        Mutil_Selection.Make(self,"TOYOTA")
        Mutil_Selection.Categories_QP(self,"Bed Mats")
        time.sleep(3)
        Mutil_Selection.Categories_QP(self,"Oil Filters")        
        FunctionCommon.Browser(self)
        Mutil_Selection.TwoSubCategories_select(self,"Universal Oil Filters","Harley Davidson Bed Mat")
        Mutil_Selection.Products_ViewDetail(self)
        AddCart.AddCart(self)
        PublicFunctions.my_wait_text_present(self,"Your Shopping Cart")
        AddCart.CheckOut(self)
##        PublicFunctions.my_wait_text_present(self,"Express Checkout")
##        Payment.Step1_ProceedCheckOut(self,False)
##        Payment.Step3_ShippingMethod(self)
##        Payment.Step4_OrderConfirm(self)

    def test012_TwoSubCategories(self):
        Mutil_Selection.Year(self,"2009")
        Mutil_Selection.Categories_QP(self,"Fender Flares")
        time.sleep(3)
        Mutil_Selection.Categories_QP(self,"Gauges")        
        FunctionCommon.Browser(self)
        Mutil_Selection.TwoSubCategories_select(self,"Edge Gauge","Extended Fender Flares")
        time.sleep(5)
        Mutil_Selection.Products_ViewDetail(self)
        AddCart.AddCart(self)
        PublicFunctions.my_wait_text_present(self,"Your Shopping Cart")
        AddCart.CheckOut(self)
##        PublicFunctions.my_wait_text_present(self,"Express Checkout")
##        Payment.Step1_ProceedCheckOut(self,False)
##        Payment.Step3_ShippingMethod(self)
##        Payment.Step4_OrderConfirm(self)
   
          
    def test020_TwoSeries(self):
        Mutil_Selection.Year(self,"2010")
        Mutil_Selection.Brand(self,"Advantage")
        time.sleep(3)
        Mutil_Selection.Brand(self,"AEM")       
        FunctionCommon.Browser(self)
        Mutil_Selection.TwoSeries_select(self,"//li[2]/div[1]/img","//div[2]/li[1]/div[1]/img")
        Mutil_Selection.Products_ViewDetail(self)
        AddCart.AddCart(self)
        PublicFunctions.my_wait_text_present(self,"Your Shopping Cart")
        AddCart.CheckOut(self)
         
    def test021_TwoSeries(self):
        Mutil_Selection.Year(self,"2009")
        Mutil_Selection.Make(self,"JEEP")
        Mutil_Selection.Brand(self,"Bedrug")
        time.sleep(3)
        Mutil_Selection.Brand(self,"BestInAUTO")       
        FunctionCommon.Browser(self)   
        Mutil_Selection.TwoSeries_select(self,"//div[@id='subcatleftcolumn']/img","//div[2]/li[1]/div[1]/img")
        Mutil_Selection.Products_ViewDetail(self)
        AddCart.AddCart(self)
        PublicFunctions.my_wait_text_present(self,"Your Shopping Cart")
        AddCart.CheckOut(self)

    def test022_TwoSeries(self):
        Mutil_Selection.Year(self,"2007")
        Mutil_Selection.Brand(self,"K&N")
        time.sleep(3)
        Mutil_Selection.Brand(self,"Lund")       
        FunctionCommon.Browser(self)
        Mutil_Selection.TwoSeries_select(self,"//div[@id='subcatleftcolumn']/img","//div[5]/li[1]/div[1]/img")
        Mutil_Selection.Products_ViewDetail(self)
        AddCart.AddCart(self)
        PublicFunctions.my_wait_text_present(self,"Your Shopping Cart")
        AddCart.CheckOut(self)

        
         
##Test Suite
def MoreSubCateOrSeriesTest():
    suite=unittest.TestSuite()
##    suite.addTest(PlaceMoreSubCateOrSeriesOrders("test010_TwoSubCategories"))
##    suite.addTest(PlaceMoreSubCateOrSeriesOrders("test011_TwoSubCategories"))
##    suite.addTest(PlaceMoreSubCateOrSeriesOrders("test012_TwoSubCategories"))  
    suite.addTest(PlaceMoreSubCateOrSeriesOrders("test020_TwoSeries"))    
##    suite.addTest(PlaceMoreSubCateOrSeriesOrders("test021_TwoSeries"))
    suite.addTest(PlaceMoreSubCateOrSeriesOrders("test022_TwoSeries"))    
    return suite

## Test Execute

if __name__ == "__main__":
    fp = file('CongoWorld Auto-Testing Result_CategoriesOrders_MoreSubcategories.html', 'wb')
    runner = HTMLTestRunner.HTMLTestRunner(stream=fp, title='Quick Test', description='The test report of selenium')    
    runner.run(MoreSubCateOrSeriesTest())
